<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../output.css" rel="stylesheet">
    <title>Document</title>
</head>

<body>
    <?php
    require '../../vendor/autoload.php';

    use Jenssegers\Blade\Blade;

    $blade = new Blade('../views', '../views/cache');

    echo $blade->make('sign-up')->render();
    ?>

</body>

</html>