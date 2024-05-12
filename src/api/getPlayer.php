<?php


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/db.php';
    $playerId = $_SESSION["playerId"];



    try {
        $user = $db->prepare("SELECT * FROM room_players WHERE id = :playerId");
        $user->bindValue(':playerId', $playerId);
        $user->execute();
        $userData = $user->fetch();

        if (!$userData) {
            http_response_code(404);
            echo json_encode(['message' => 'User not found']);
            exit;
        }
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
