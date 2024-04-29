<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }

    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/db.php';

    /*     $db = $service->initializeDatabase("words");
     */
    try {
        $words = [];
        for ($i = 0; $i < 3; $i++) {
            $randomNumber = rand(1, 36);
            /*             $words[] = $db->findBy("id", $randomNumber)->getResult();
             */
            $query = $db->prepare("SELECT name FROM words WHERE id = :randomNumber");
            $query->bindValue(':randomNumber', $randomNumber);
            $query->execute();
            $words[] = $query->fetchColumn();

        }
        list($word1, $word2, $word3) = $words;
        http_response_code(200);
        echo json_encode(['message' => 'Success', "words" => [$word1, $word2, $word3]]);
        exit;
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => $e->getMessage()]);
        exit;
    }
}
