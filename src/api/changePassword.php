<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        "password" => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType()],
        "newPassword" => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType()],
    ], $_POST);

    $userId = $_SESSION["userId"];




    header('Content-Type: application/json');
    if (empty($errors)) {
        $headers = getallheaders();
        $csrfToken = $headers['X-CSRF-Token'];
        if ($csrfToken !== $_SESSION['csrf_token']) {
            http_response_code(403);
            echo json_encode(['message' => 'CSRF token mismatch']);
            exit;
        }

        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
        try {
            $user = $db->prepare("SELECT * FROM users WHERE id = :userId");
            $user->bindValue(':userId', $userId);
            $user->execute();
            $userData = $user->fetch();

            if (!password_verify($_POST["password"], $userData["password"])) {
                http_response_code(400);
                echo json_encode(["message" => "Incorrect password"]);
                exit;
            }


            $password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);

            $updatePassword = $db->prepare("UPDATE users SET password = :password WHERE id = :userId");
            $updatePassword->bindValue(':password', $password);
            $updatePassword->bindValue(':userId', $userId);
            $updatePassword->execute();

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
    } else {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }
}
