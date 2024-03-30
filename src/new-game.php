<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="output.css">
</head>

<body>
    <?php
    require '../vendor/autoload.php';

    use Jenssegers\Blade\Blade;

    $blade = new Blade('./views', './views/cache');

    ?>
    <main class=" h-screen ">
        <form method="post" class="grid gap-4">
            <div class="grid gap-2">
                <?php
                echo $blade->make('label', [
                    "label" => "Maximum Players",
                ])->render();
                echo $blade->make('input', [
                    "name" => "max_players",
                    "type" => "number",
                ])->render();

                echo $blade->make('label', [
                    "label" => "Number of Rounds",
                ])->render();
                echo $blade->make('input', [
                    "name" => "num_rounds",
                    "type" => "number",
                ])->render();

                echo $blade->make('label', [
                    "label" => "Round Time (in seconds)",
                ])->render();
                echo $blade->make('input', [
                    "name" => "round_time",
                    "type" => "number",
                ])->render();
                ?>
            </div>
            <?php
            echo $blade->make('avatar', [
                "class" => "from-[#7FB2FF] to-[#FF7F7F]",
            ])->render();
            ?>
            <?php
            echo $blade->make("message", [
                "message" => "Please wait for other players to join",
                "username" => "Player 1",
                "path" => "../vendor/autoload.php",
            ])->render();
            ?>
    </main>

    <script type="module" src="./presenceTest.js"></script>
</body>

</html>