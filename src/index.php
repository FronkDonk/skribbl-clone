<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="src/output.css" rel="stylesheet">


</head>

<body>
    <div class="flex gap-24 justify-center">


    </div>
    <?php
    require 'vendor/autoload.php';

    $loader = new \Twig\Loader\FilesystemLoader('./src/views');
    $twig = new \Twig\Environment($loader);

    /*     echo $twig->render('button.twig', ["label" => 'someValue']);
     */ ?>
    <!--     <button class="bg-red-500 w-10/12">asdlasd<button>
 -->
    <button class="inline-flex items-center px-5 py-3 justify-center 
    rounded-md text-sm font-medium disabled:pointer-events-none 
    disabled:opacity-50 bg-primary hover:bg-green-400">button<button>

            <script type="module" src="./test.js"></script>

</body>

</html>