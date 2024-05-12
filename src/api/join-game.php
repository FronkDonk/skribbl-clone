<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Ramsey\Uuid\Uuid;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        'gameId' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->minLength(6), $validator->maxLength(6)],
        "username" => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType()],
    ], $_POST);


    header('Content-Type: application/json');
    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/redis.php";

        try {
            $gameId = $_POST['gameId'];
            $existingGame = $client->get("game:$gameId");
            if ($existingGame === null) {
                http_response_code(400);
                echo json_encode(['message' => 'Game does not exist']);
                exit;
            }
            $id = Uuid::uuid4()->toString();
            $_SESSION["playerId"] = $id;

            $query = $db->prepare("INSERT INTO room_players (id, username, game_room_id, score, is_owner) VALUES (:id, :username, :gameId, 0, :is_owner)");
            $query->bindValue(':id', $id);
            $query->bindValue(':gameId', $gameId);
            $query->bindValue(':username', $_POST["username"]);
            $query->bindValue(':is_owner', 0);
            $query->execute();


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