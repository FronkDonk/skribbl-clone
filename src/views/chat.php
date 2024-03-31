<?php


use Jenssegers\Blade\Blade;

$blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

echo $blade->make('chat', [
])->render();


