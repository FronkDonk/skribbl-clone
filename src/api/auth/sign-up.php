<?php
use Respect\Validation\Validator as v;

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        'username' => v::notEmpty()->length(1, 30)->alnum()->noWhitespace(),
        'email' => v::notEmpty()->email(),
        'password' => v::notEmpty()->length(8, null)->noWhitespace(),
    ], $_POST);
    header('Content-Type: application/json');

    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/supabase.php";
        $auth = $service->createAuth();
        $user_metadata = [
            'username' => $_POST['username'],
        ];
        try {

            $auth->createUserWithEmailAndPassword($_POST['email'], $_POST['password'], $user_metadata);
            $data = $auth->data();
            http_response_code(200);
            echo json_encode(['message' => 'Success', 'data' => $data]);
            /*             $_SESSION['userId'] = $data->$id;
             */
            exit;
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => 'Internal server error']);
            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode($errors);
        exit;
    }


}

