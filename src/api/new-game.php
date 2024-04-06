<?php

use Respect\Validation\Validator as v;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        'selectedValue-maxPlayers' => v::notEmpty()->intVal()->in([2, 4, 6, 8]),
        'selectedValue-numRounds' => v::notEmpty()->intVal()->in([3, 6, 8]),
        'selectedValue-drawingTime' => v::notEmpty()->intVal()->in([20, 40, 60, 80]),
        'selectedValue-visibility' => v::notEmpty()->stringType()->in(['Public', 'Private']),
        "ownerId" => v::notEmpty()->uuid(),
        'gameId' => v::notEmpty()->uuid()

    ], $_POST);
    header('Content-Type: application/json');
    if ($_POST["ownerId"] !== $_SESSION["userId"]) {
        http_response_code(403);
        echo json_encode(["errors" => ["you are not the owner of this game"]]);
        exit;
    }

    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/supabase.php";
        $db = $service->initializeDatabase("game_room");
        $isPublic = $_POST['selectedValue-visibility'] === 'Public' ? true : false;
        $newgame = [
            'id' => $_POST['gameId'],
            'max_players' => $_POST['selectedValue-maxPlayers'],
            'num_rounds' => $_POST['selectedValue-numRounds'],
            'drawing_time' => $_POST['selectedValue-drawingTime'],
            'isPublic' => $isPublic,
            'owner' => $_POST['ownerId'],
        ];
        try {
            $data = $db->insert($newgame);

            http_response_code(200);
            echo json_encode(['message' => 'Success', 'data' => $data]);
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'message' => $e->getMessage(),
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
