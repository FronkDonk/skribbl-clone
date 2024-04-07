<?php
require $path = $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
use Respect\Validation\Validator as v;
use Jenssegers\Blade\Blade;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require $_SERVER['DOCUMENT_ROOT'] . '/src/validators/index.php';

    $validator = new Validator();

    $errors = $validator->validate([
        "message" => v::notEmpty()->stringVal(),
        "username" => v::notEmpty()->stringVal(),
        "userId" => v::notEmpty()->uuid(),
        "sentAt" => v::notEmpty()->stringVal(),
    ], $_POST);

    $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

    echo $blade->make("message", [
        "message" => $_POST['message'],
        "username" => $_POST['username'],
        "sentAt" => $_POST['sentAt'],    
    ])->render();
}








