<?php
require $path = $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Respect\Validation\Validator as v;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        "message" => [$validator->notEmpty(), $validator->stringType()],
        "userId" => [$validator->notEmpty(), $validator->uuid()],
        "sentAt" => [$validator->notEmpty(), $validator->stringType()],
        'gameId' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->minLength(6), $validator->maxLength(6)],
    ], $_POST);

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }
    require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
    try {
        $query = $db->prepare("INSERT INTO room_messages (message, user_id, sent_at, room_id) VALUES (:message, :userId, :sentAt, :gameId)");

        $query->bindValue(':message', $_POST["message"]);
        $query->bindValue(':userId', $_POST["userId"]);
        $query->bindValue(':sentAt', $_POST["sentAt"]);
        $query->bindValue(':gameId', $_POST["gameId"]);

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
}
