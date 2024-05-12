<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Ramsey\Uuid\Uuid;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        "username" => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType()],
    ], $_POST);


    header('Content-Type: application/json');
    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/redis.php";

        $gameId = bin2hex(random_bytes(3));
        $id = Uuid::uuid4()->toString();
        $_SESSION["playerId"] = $id;

        try {
            $client->set("game:$gameId", true);
            $query = $db->prepare("INSERT INTO room_players (id, username, game_room_id, score, is_owner, user_id) VALUES (:id, :username, :gameId, 0, :is_owner, :user_id)");
            $query->bindValue(':id', $id);
            $query->bindValue(':gameId', $gameId);
            $query->bindValue(':username', $_POST["username"]);
            $query->bindValue(':is_owner', true);
            $query->bindValue(':user_id', $_SESSION["userId"] ?? null);
            $query->execute();



            http_response_code(200);
            echo json_encode(["gameId" => $gameId]);
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