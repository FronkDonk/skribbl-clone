<?php

require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $_SERVER['DOCUMENT_ROOT'] . "/src/db/supabase.php";

$db = $service->initializeDatabase("room_messages");

try {
    $messages = $db->fetchAll()->getResult();
    echo json_encode(["messages" => $messages]);
} catch (Exception $e) {
    echo $e->getMessage();
}

