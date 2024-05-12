<?php

/* require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';
    $validator = new Validator();


    $errors = $validator->validate([
        "gameId" => [$validator->notEmpty(), $validator->uuid()],
    ], $_POST);

    header('Content-Type: application/json');

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }

    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/db.php';

    $auth = $service->createAuth();
    $userId = $_SESSION["userId"];

    try {
        $existingGame = $db->prepare("SELECT * FROM game_room WHERE id = :gameId");
        $existingGame->bindValue(':gameId', $_POST["gameId"]);
        $existingGame->execute();
        $existingGame = $existingGame->fetch();

        $isOwner = $existingGame["owner"] === $userId ? true : false;


        if (!$existingGame) {
            http_response_code(404);
            echo json_encode(["message" => 'Game not found']);
            exit;
        }

        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/redis.php";

        $isMember = $client->sismember("gameMembers:{$_POST["gameId"]}", $userId);

        if (!$isMember) {
            $client->sadd("gameMembers:{$_POST["gameId"]}", $userId);
        }

        $existingPlayer = $db->prepare("SELECT * FROM room_players WHERE id = :userId");
        $existingPlayer->bindValue(':userId', $userId);
        $existingPlayer->execute();
        $existingPlayer = $existingPlayer->fetch();


        if ($existingPlayer) {
            http_response_code(200);
            echo json_encode(['message' => 'Success', 'player' => $existingPlayer, "gameRoom" => $gameRoomData]);
            exit;
        }

        $adjectives = ["Cheerful", "Jolly", "Daring", "Brave", "Lucky", "Funky", "Jazzy", "Energetic", "Breezy", "Giggly"];
        $nouns = ["Unicorn", "Rainbow", "Puppy", "Kitten", "Dolphin", "Butterfly", "Bumblebee", "Cupcake", "Sunflower", "Starfish"];

        $usernames = [];
        for ($i = 0; $i < 10; $i++) {
            $adjective = $adjectives[array_rand($adjectives)];
            $noun = $nouns[array_rand($nouns)];
            $usernames[] = $adjective . $noun;
        }


        $newPlayer = [
            "id" => $userId,
            "username" => $usernames[array_rand($usernames)],
            "game_room_id" => $_POST["gameId"],
            "score" => 0,
            "isOwner" => $gameRoomData[0]->owner === $userId ? true : false,
        ];

        $player = $roomPlayers->insert($newPlayer);
        $player = $db->prepare("INSERT INTO room_players (id, username, game_room_id, score, isOwner) VALUES (:userId, :username, :gameId, :score, :isOwner)");
        $player->bindValue(':userId', $userId);
        $player->bindValue(':username', $usernames[array_rand($usernames)]);
        $player->bindValue(':gameId', $_POST["gameId"]);
        $player->bindValue(':score', 0);
        $player->bindValue(':isOwner', $isOwner);

        $player->execute();


        http_response_code(200);
        echo json_encode(['message' => 'New player created']);
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
}
 */