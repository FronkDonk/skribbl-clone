<?php
require $path = $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        "message" => [$validator->notEmpty(), $validator->stringType()],
        'gameId' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->minLength(6), $validator->maxLength(6)],
    ], $_POST);

    if (!empty($errors)) {
        http_response_code(400);
        echo json_encode(["errors" => $errors]);
        exit;
    }
    require $_SERVER['DOCUMENT_ROOT'] . "/src/db/redis.php";
    require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";

    try {
        // Hämtar ordet för det aktuella spelet från redis
        $word = $client->get("game:{$_POST['gameId']}:word");
        $word = trim($word);
        $message = trim($_POST["message"]);

        // Kontrollerar om det inkommande meddelandet matchar ordet
        if (strtolower($word) == strtolower($message)) {
            // Om det gör det, uppdatera spelarens poäng i databasen
            $query = $db->prepare("UPDATE room_players SET score = score + 100 WHERE game_room_id = :gameId AND id = :playerId");
            $query->bindValue(":gameId", $_POST['gameId']);
            $query->bindValue(":playerId", $_SESSION['playerId']);
            $query->execute();

            http_response_code(200);
            echo json_encode(["isCorrect" => true]);
            exit;
        } else {
            // Om det inte gör det, skicka tillbaka ett meddelande om att gissningen var felaktig
            http_response_code(200);
            echo json_encode(["isCorrect" => false]);
            exit;
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => $e->getMessage()]);
        exit;
    }
}
