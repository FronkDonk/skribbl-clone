<?php

use Respect\Validation\Validator as v;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


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

    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/supabase.php';

    $auth = $service->createAuth();
    $userId = $_SESSION["userId"];
    $accessToken = $_SESSION["access_token"];
    $roomPlayers = $service->initializeDatabase("room_players");
    $gameRoom = $service->initializeDatabase("game_room");


    try {
        $existingGame = $gameRoom->findBy("id", $_POST["gameId"])->getResult();
        //SELECT * FROM game_room WHERE id = $_POST["gameId"];
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
        $gameRoomData = $gameRoom->findBy("id", $_POST["gameId"])->getResult();
        //SELECT * FROM game_room WHERE id = $_POST["gameId"];
        $existingPlayer = $roomPlayers->findBy("id", $userId)->getResult();
        //SELECT * FROM room_players WHERE id = $userId;
        if ($existingPlayer) {
            http_response_code(200);
            echo json_encode(['message' => 'Success', 'player' => $existingPlayer, "gameRoom" => $gameRoomData]);
            exit;
        }
        //no existing player, create new player
        //create new player
        /*         $userData = $auth->getUser($accessToken);
         */        //fetch game room data
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
        //INSERT INTO room_players (id, username, game_room_id, score, isOwner) VALUES ($userId, $newPlayer["username"], $_POST["gameId"], 0, $newPlayer["isOwner"]);

        http_response_code(200);
        echo json_encode(['message' => 'New player created', 'player' => $player, "gameRoom" => $gameRoomData]);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => $e->getMessage()]);
        exit;
    }
}
