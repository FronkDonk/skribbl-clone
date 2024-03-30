<?php
require '../vendor/autoload.php';

use Jenssegers\Blade\Blade;

$blade = new Blade('./views', './views/cache');

echo $blade->make('chat', [
    "path" => "../vendor/autoload.php",
])->render();
