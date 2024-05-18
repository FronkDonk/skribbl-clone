<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Ramsey\Uuid\Uuid;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';
    require $_SERVER['DOCUMENT_ROOT'] . "/src/constants/constants.php";

    $validator = new Validator();

    $errors = $validator->validate([
        "username" => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType()],
    ], $_POST);


    header('Content-Type: application/json');
    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/redis.php";

        // Skapar ett unikt gameId och ett unikt spelar-id
        $gameId = bin2hex(random_bytes(3));
        $id = Uuid::uuid4()->toString();
        // Sätter spelar-id i sessionen
        $_SESSION["playerId"] = $id;

        // Väljer en slumpmässig avatar från en lista med färger
        $randomIndex = array_rand($colors, 1);
        $avatar = $colors[$randomIndex];

        try {
            // Sätter spel-id i redis för att snabbt kunna kolla om ett spel existerar
            $client->set("game:$gameId", true);

            // Skapar en ny spelare i databasen
            $query = $db->prepare("INSERT INTO room_players (id, username, game_room_id, score, is_owner, user_id, avatar) VALUES (:id, :username, :gameId, 0, :is_owner, :user_id, :avatar)");
            $query->bindValue(':id', $id);
            $query->bindValue(':gameId', $gameId);
            $query->bindValue(':username', $_POST["username"]);
            $query->bindValue(':is_owner', true);
            $query->bindValue(':user_id', $_SESSION["userId"] ?? null);
            $query->bindValue(':avatar', $avatar);
            $query->execute();


            // Skickar tillbaka spel-id till klienten
            http_response_code(200);
            echo json_encode(["gameId" => $gameId]);
            exit;
        } catch (PDOException $e) {
            // Om det blir ett fel med databasen, skicka tillbaka ett felmeddelande
            http_response_code(500);
            echo json_encode([
                'message' => 'Database error: ' . $e->getMessage(),
                'code' => $e->getCode(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }


}