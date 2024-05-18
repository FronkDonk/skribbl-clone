<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        "password" => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType()],
    ], $_POST);


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

        $userId = $_SESSION['userId'];

        try {
            $user = $db->prepare("SELECT * FROM users WHERE id = :id");
            $user->bindValue(":id", $userId);
            $user->execute();
            $data = $user->fetch();

            if (!password_verify($_POST['password'], $data['password'])) {
                http_response_code(400);
                echo json_encode(["errors" => ["message" => "Password is incorrect"]]);
                exit;
            }

            $query = $db->prepare("DELETE FROM users WHERE id = :id");
            $query->bindValue(":id", $userId);
            $query->execute();

            $_SESSION = [];

            http_response_code(200);
            echo json_encode(["message" => "Account deleted successfully"]);
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
