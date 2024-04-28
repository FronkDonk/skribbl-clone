<?php
require $path = $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Respect\Validation\Validator as v;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        "message" => v::notEmpty()->stringVal(),
        "username" => v::notEmpty()->stringVal(),
        "userId" => v::notEmpty()->uuid(),
        "sentAt" => v::notEmpty()->stringVal(),
        "gameId" => v::notEmpty()->uuid(),
    ], $_POST);

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }
    require $_SERVER['DOCUMENT_ROOT'] . "/src/db/supabase.php";
    $db = $service->initializeDatabase("room_messages");
    $newMessage = [
        "message" => $_POST["message"],
        "user_id" => $_POST["userId"],
        "sent_at" => $_POST["sentAt"],
        "room_id" => $_POST["gameId"],
    ];


    try {
        $db->insert($newMessage);
        // INSERT INTO room_messages (message, user_id, sent_at, room_id) 
        // VALUES ($_POST["message"], $_POST["userId"], $_POST["sentAt"], $_POST["gameId"])
        http_response_code(200);
        echo json_encode(['message' => 'Success']);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => $e->getMessage()]);
        exit;
    }
}
