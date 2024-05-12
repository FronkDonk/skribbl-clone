<?php


require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        'selectedValue-maxPlayers' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->in([2, 4, 6, 8])],
        'selectedValue-numRounds' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->in([3, 6, 8])],
        'selectedValue-drawingTime' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->in([20, 40, 60, 80])],
        'selectedValue-visibility' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->in(['Public', 'Private'])],
        "ownerId" => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->uuid()],
        'gameId' => [$validator->notEmpty(), $validator->htmlspecialchars(), $validator->stringType(), $validator->minLength(6), $validator->maxLength(6)],
    ], $_POST);




    header('Content-Type: application/json');
    if ($_POST["ownerId"] !== $_SESSION["playerId"]) {
        http_response_code(403);
        echo json_encode(["errors" => ["you are not the owner of this game"]]);
        exit;
    }

    if (empty($errors)) {

        require $_SERVER['DOCUMENT_ROOT'] . "/src/db/db.php";
        $isPublic = $_POST['selectedValue-visibility'] === 'Public' ? true : false;
        try {
            //update owner to true 

            $updatePlayer = $db->prepare("UPDATE room_players SET is_owner = :is_owner WHERE id = :owner_id AND game_room_id = :game_id");
            $updatePlayer->bindValue(':owner_id', $_POST["ownerId"]);
            $updatePlayer->bindValue(':game_id', $_POST["gameId"]);
            $updatePlayer->bindValue(':is_owner', true);
            $updatePlayer->execute();

            $query = $db->prepare("INSERT INTO game_room (id, max_players, num_rounds, drawing_time, is_public, owner) VALUES (:gameId, :maxPlayers, :numRounds, :drawingTime, :isPublic, :ownerId)");

            $query->bindValue(':gameId', $_POST["gameId"]);
            $query->bindValue(':maxPlayers', $_POST["selectedValue-maxPlayers"]);
            $query->bindValue(':numRounds', $_POST["selectedValue-numRounds"]);
            $query->bindValue(':drawingTime', $_POST["selectedValue-drawingTime"]);
            $query->bindValue(':isPublic', $isPublic);
            $query->bindValue(':ownerId', $_POST["ownerId"]);
            $query->execute();

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
