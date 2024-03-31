<?php
require '../../vendor/autoload.php';

use Jenssegers\Blade\Blade;

$blade = new Blade('../views', '../views/cache');

echo $blade->make('sign-up')->render();
