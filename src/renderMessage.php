<?php
$message = $_POST['message'];
$username = $_POST['username'];
$path = $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
require $path;

use Jenssegers\Blade\Blade;



$blade = new Blade('./views', './views/cache');
echo $blade->make("message", [
    "message" => $message,
    "username" => $username,

])->render();
