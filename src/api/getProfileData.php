<?php


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    $headers = getallheaders();
    $csrfToken = $headers['X-CSRF-Token'];
    if ($csrfToken !== $_SESSION['csrf_token']) {
        http_response_code(403);
        echo json_encode(['message' => 'CSRF token mismatch']);
        exit;
    }
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/db.php';
    $playerId = $_SESSION["userId"];

    try {
        $user = $db->prepare("SELECT * FROM users WHERE id = :userId");
        $user->bindValue(':userId', $playerId);
        $user->execute();
        $userData = $user->fetch();

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
