<?php
require $path = $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $error = $validator->validate([
        "word" => [$validator->notEmpty(), $validator->stringType()],
        "gameId" => [$validator->notEmpty(), $validator->uuid()],
    ], $_POST);

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }
    require $_SERVER['DOCUMENT_ROOT'] . "/src/db/redis.php";
    try {
        $client->set("game:{$_POST['gameId']}:word}", $_POST["word"]);
        http_response_code(200);
        echo json_encode(['message' => 'Success']);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => $e->getMessage()]);
        exit;
    }
}








