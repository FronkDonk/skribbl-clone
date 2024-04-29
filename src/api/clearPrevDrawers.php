<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Respect\Validation\Validator as v;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        "gameId" => [$validator->notEmpty(), $validator->uuid()],
        "rounds" => [$validator->notEmpty(), $validator->intVal()],
    ], $_POST);

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }

    try {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/redis.php";
        $client->del("prevDrawers:{$_POST["gameId"]}");
        $currentRounds = $client->get("rounds:{$_POST["gameId"]}");
        if ($_POST["rounds"] == $currentRounds) {
            //end round

            $client->del("rounds:{$_POST["gameId"]}");
            $client->del("gameMembers:{$_POST["gameId"]}");
            $client->del("prevDrawers:{$_POST["gameId"]}");

            http_response_code(200);
            echo json_encode(['end' => true]);
            exit;
        }
        $client->incr("rounds:{$_POST["gameId"]}");

        http_response_code(200);
        echo json_encode(['message' => 'Success']);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => $e->getMessage()]);
        exit;
    }

}