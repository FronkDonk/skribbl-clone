<?php


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/supabase.php';

    $auth = $service->createAuth();
    $accessToken = $_SESSION['access_token'];

    try {
        $userData = $auth->getUser($accessToken);
        http_response_code(200);
        echo json_encode(['message' => 'Success', 'data' => $userData]);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => $e->getMessage()]);
        exit;
    }

}
