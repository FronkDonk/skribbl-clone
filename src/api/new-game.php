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
        'game-id' => v::notEmpty()->uuid()

    ], $_POST);
    header('Content-Type: application/json');
    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/supabase.php";
        $db = $service->initializeDatabase("game_room");
        $isPublic = $_POST['selectedValue-visibility'] === 'Public' ? true : false;
        $newgame = [
            'id' => $_POST['game-id'],
            'max_players' => $_POST['selectedValue-maxPlayers'],
            'num_rounds' => $_POST['selectedValue-numRounds'],
            'drawing_time' => $_POST['selectedValue-drawingTime'],
            'isPublic' => $isPublic,
            'owner' => 'af7c1fe6-d669-414e-b066-e9733f0de7a8',
        ];
        try {
            $data = $db->insert($newgame);

            http_response_code(200);
            echo json_encode(['message' => 'Success', 'data' => $data]);
            exit;


        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Internal server error']);
            exit;
        }



    } else {
        http_response_code(400);
        echo json_encode($errors);
        exit;
    }

}
?>