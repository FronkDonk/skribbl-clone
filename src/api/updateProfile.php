<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION["userId"];

    header('Content-Type: application/json');
    if (empty($errors)) {

        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
        try {
            // Förbereder en SQL-query för att uppdatera användaren
            $query = "UPDATE users SET ";
            $params = array();

            // Kontrollerar om användarnamnet är angivet och lägger till det i queryn om det är det
            if (!empty($_POST["username"])) {
                $query .= "username = :username, ";
                $params[':username'] = $_POST["username"];
            }

            // Kontrollerar om e-postadressen är angiven och lägger till den i queryn om den är det
            if (!empty($_POST["email"])) {
                $query .= "email = :email, ";
                $params[':email'] = $_POST["email"];
            }
            // Tar bort det sista kommat från frågan
            $query = rtrim($query, ', ');

            // Lägger till villkoret för vilken användare som ska uppdateras
            $query .= " WHERE id = :userId";
            $params[':userId'] = $userId;

            $user = $db->prepare($query);

            // Binder alla parametrar till queryn
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
