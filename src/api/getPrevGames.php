<?php


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/db.php';
    $userId = $_SESSION["userId"];

    try {
        $query = $db->prepare("SELECT * FROM game_room JOIN ON game_room.id = room_players.game_room_id)

        if (!$userData) {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
            exit;
        }


        unset($userData['password']);
        http_response_code(200);
        echo json_encode(['message' => 'Success', 'data' => $userData]);
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
