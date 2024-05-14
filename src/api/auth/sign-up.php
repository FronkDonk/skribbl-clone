<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Ramsey\Uuid\Uuid;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        'username' => [$validator->notEmpty(), $validator->htmlspecialchars()],
        'email' => [$validator->notEmpty(), $validator->email(), $validator->htmlspecialchars()],
        'password' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->minLength(8)],
    ], $_POST);


    header('Content-Type: application/json');
    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
        try {
            $existingUser = $db->prepare("SELECT * FROM users WHERE email = :email");
            $existingUser->bindValue(':email', $_POST["email"]);
            $existingUser->execute();
            $data = $existingUser->fetch();
            if ($data) {
                http_response_code(400);
                echo json_encode(['message' => 'User already exists']);
                exit;
            }
            $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);
            $id = Uuid::uuid4()->toString();
            $user = $db->prepare("INSERT INTO users (id, username, email, password) VALUES (:id, :username, :email, :password)");

            $user->bindValue(':username', $_POST["username"]);
            $user->bindValue(':email', $_POST["email"]);
            $user->bindValue(':password', $hashedPassword);
            $user->bindValue(':id', $id);
            $user->execute();



            $_SESSION["userId"] = $id;
            $_SESSION["username"] = $_POST["username"];
            $_SESSION["email"] = $_POST["email"];

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
        echo json_encode(['message' => 'FEsk', 'errors' => $errors]);
        exit;
    }
}
