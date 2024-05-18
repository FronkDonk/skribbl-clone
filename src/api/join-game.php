<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Ramsey\Uuid\Uuid;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();
    // Validerar inkommande data
    $errors = $validator->validate([
        'gameId' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->minLength(6), $validator->maxLength(6)],
        "username" => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType()],
    ], $_POST);


    header('Content-Type: application/json');
    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/redis.php";
        require $_SERVER['DOCUMENT_ROOT'] . "/src/constants/constants.php";
        try {
            // Kontrollerar om spelet existerar i redis
            $gameId = $_POST['gameId'];
            $existingGame = $client->get("game:$gameId");
            if ($existingGame === null) {
                http_response_code(400);
                echo json_encode(['message' => 'Game does not exist']);
                exit;
            }
            // Skapar ett unikt spelar-id och sätter det i sessionen
            $id = Uuid::uuid4()->toString();
            $_SESSION["playerId"] = $id;

            // Väljer en slumpmässig avatar från en lista med färger
            $randomIndex = array_rand($colors, 1);
            $avatar = $colors[$randomIndex];

            // Skapar en ny spelare i databasen
            $query = $db->prepare("INSERT INTO room_players (id, username, game_room_id, score, is_owner, avatar) VALUES (:id, :username, :gameId, 0, :is_owner, :avatar)");
            $query->bindValue(':id', $id);
            $query->bindValue(':gameId', $gameId);
            $query->bindValue(':username', $_POST["username"]);
            $query->bindValue(':is_owner', 0);
            $query->bindValue(':avatar', $avatar);
            $query->execute();

            // Skickar tillbaka status 200 till klienten
            http_response_code(200);
            echo json_encode(['message' => 'Success']);
            exit;
        } catch (PDOException $e) {
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