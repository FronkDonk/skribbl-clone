<!-- isClient
: 
false
online_at
: 
1712143936877
owner
: 
true
user
: 
"9500a7f2-469e-481e-b5a1-18695c02f794"
username
: 
"The Fake Slim Shady" -->

<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Jenssegers\Blade\Blade;

$blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

$owner = $_POST["owner"] === "true" ? true : false;
$username = $_POST["username"];
$isClient = $_POST["isClient"] === "true" ? true : false;


echo $blade->make("onlineAvatars", [
    "username" => $username,
    "isOwner" => $owner,
    "isPlayer" => $owner ? false : true,
    "isClient" => $isClient,
])->render();
?>