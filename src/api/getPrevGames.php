<?php


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Content-Type: application/json');
    require $_SERVER['DOCUMENT_ROOT'] . '/src/db/db.php';
    $userId = $_SESSION["userId"];

    try {
        // First, fetch the room_players for the user
        $query = $db->prepare("SELECT * FROM room_players WHERE user_id = :userId");
        $query->bindValue(':userId', $userId);
        $query->execute();
        $userRooms = $query->fetchAll(PDO::FETCH_ASSOC);

        // Then, for each room_player, fetch the game room and all players
        foreach ($userRooms as $index => $userRoom) {
            // Fetch the game room
            $query = $db->prepare("SELECT * FROM game_room WHERE id = :gameRoomId ORDER BY created_at DESC");
            $query->bindValue(':gameRoomId', $userRoom['game_room_id']);
            $query->execute();
            $gameRoom = $query->fetch(PDO::FETCH_ASSOC);

            // Fetch all players for the game room
            $query = $db->prepare("SELECT * FROM room_players WHERE game_room_id = :gameRoomId ORDER BY score DESC");
            $query->bindValue(':gameRoomId', $userRoom['game_room_id']);
            $query->execute();
            $players = $query->fetchAll(PDO::FETCH_ASSOC);

            // Filter out the current user
            /*   $players = array_filter($players, function ($player) use ($userId) {
                  return $player['user_id'] !== $userId;
              }); */


            // Add the game room and players to the user room
            $userRooms[$index]['game_room'] = $gameRoom;
            $userRooms[$index]['players'] = $players;
        }
        http_response_code(200);
        echo json_encode(['message' => 'Success', 'data' => $userRooms]);
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
}
