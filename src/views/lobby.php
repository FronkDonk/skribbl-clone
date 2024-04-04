<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/src/output.css">
</head>

<body>
    <?php
    //generate id for game here and then when the user starts the game and the players are more than 2 
    //then the game will start
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

    use Jenssegers\Blade\Blade;

    $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

    ?>

    <?php
    echo $blade->make('navbar')->render();
    ?>



    <script src="/src/js/lobby.js" type="module"></script>
</body>

</html>