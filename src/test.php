<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="output.css" rel="stylesheet">
</head>

<body>
    <?php
    require '../vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('./views');
    $twig = new \Twig\Environment($loader);

    echo $twig->render('button.twig', ["label" => 'someValue']);
    echo $twig->render("input.twig")
        ?>

    <script type="module" src="./test2.js"></script>
</body>

</html>