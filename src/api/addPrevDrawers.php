<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Respect\Validation\Validator as v;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        "gameId" => v::notEmpty()->uuid(),
        "drawerId" => v::notEmpty()->uuid(),
    ], $_POST);

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }


    try {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/redis.php";
        $client->rpush("prevDrawers:{$_POST["gameId"]}", $_POST["drawerId"]);
        $values = $client->lrange("prevDrawers:{$_POST["gameId"]}", 0, -1);
        http_response_code(200);
        echo json_encode(['message' => 'Success', 'data' => $values]);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => $e->getMessage()]);
        exit;
    }

}