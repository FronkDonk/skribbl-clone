<?php
require $path = $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        'gameId' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->minLength(6), $validator->maxLength(6)],
    ], $_POST);

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }

    require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
    try {
        $query = $db->prepare("SELECT * FROM game_room WHERE id = :gameId");
        $query->bindValue(':gameId', $_POST["gameId"]);
        $query->execute();
        $existingGame = $query->fetch();

        http_response_code(200);
        echo json_encode(["gameData" => $existingGame]);
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
