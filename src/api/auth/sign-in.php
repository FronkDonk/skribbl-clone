<?php

use Respect\Validation\Validator as v;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';
    $validator = new Validator();

    $errors = $validator->validate([
        'email' => v::notEmpty()->email(),
        'password' => v::notEmpty()->noWhitespace(),
    ], $_POST);
    header('Content-Type: application/json');

    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/supabase.php";
        $auth = $service->createAuth();

        try {
            $auth->signInWithEmailAndPassword($_POST["email"], $_POST["password"]);
            $data = $auth->data();
            $_SESSION['access_token'] = $data->access_token;
            $_SESSION['userId'] = $data->user->id;
            http_response_code(200);
            echo json_encode(['message' => 'Success', 'data' => $data]);
            exit;
        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode(['message' => $e->getMessage()]);

            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode($errors);

        exit;
    }
}
