<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';
    $validator = new Validator();

    $errors = $validator->validate([
        'email' => [$validator->notEmpty(), $validator->email(), $validator->htmlspecialchars()],
        'password' => [$validator->notEmpty(), $validator->htmlspecialchars()],
    ], $_POST);

    header('Content-Type: application/json');

    if (empty($errors)) {
        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
        try {
            $existingUser = $db->prepare("SELECT * FROM users WHERE email = :email");
            $existingUser->bindValue(':email', $_POST["email"]);
            $existingUser->execute();
            $data = $existingUser->fetch();
            if (!$data) {
                http_response_code(400);
                echo json_encode(['message' => 'User does not exist']);
                exit;
            }
            $passwordIsValid = password_verify($_POST["password"], $data["password"]);

            if (!$passwordIsValid) {
                http_response_code(400);
                echo json_encode(['message' => 'Invalid password']);
                exit;
            }


            $_SESSION['userId'] = $data["id"];

            http_response_code(200);
            echo json_encode(['message' => 'Success']);
            exit;
        } catch (Exception $e) {
            http_response_code(500);

            echo json_encode(['message' => $e->getMessage()]);

            exit;
        }
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'FEsk', 'errors' => $errors]);
        exit;
    }
}
