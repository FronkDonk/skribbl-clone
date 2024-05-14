<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            $query = "UPDATE users SET ";
            $params = array();

            if (!empty($_POST["username"])) {
                $query .= "username = :username, ";
                $params[':username'] = $_POST["username"];
                $_SESSION["username"] = $_POST["username"];
            }

            if (!empty($_POST["email"])) {
                $query .= "email = :email, ";
                $params[':email'] = $_POST["email"];
                $_SESSION["email"] = $_POST["email"];
            }

            $query = rtrim($query, ', ');

            $query .= " WHERE id = :userId";
            $params[':userId'] = $userId;

            $user = $db->prepare($query);

            foreach ($params as $key => $value) {
                $user->bindValue($key, $value);
            }

            $user->execute();

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
