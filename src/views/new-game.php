<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./src/output.css">
</head>

<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

    use Jenssegers\Blade\Blade;

    $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

    ?>
    <main class=" h-screen ">
        <section class="flex flex-col items-center ">
            <h1 class="text-5xl">Start game or whatever</h1>
            <form method="post" class="grid gap-4 w-full max-w-xl">
                <div class="grid gap-2">
                    <?php
                    echo $blade->make('label', [
                        "label" => "Maximum players",
                    ])->render();
                    echo $blade->make('input', [
                        "name" => "max_players",
                        "type" => "number",
                    ])->render();
                    ?>
                </div>
                <div class="grid gap-2">

                    <?php
                    echo $blade->make('label', [
                        "label" => "Number of rounds",
                    ])->render();
                    echo $blade->make('input', [
                        "name" => "num_rounds",
                        "type" => "number",
                    ])->render();
                    ?>
                </div>
                <div class="grid gap-2">
                    <?php
                    echo $blade->make('input', [
                        "name" => "guessTime",
                        "type" => "number",
                    ])->render();
                    ?>
                    <?php
                    echo $blade->make('select', [
                        "label" => "Drawing time",
                        "options" => [
                            '20',
                            '40',
                            '60',
                            '80',
                        ]
                    ])->render();
                    ?>
                </div>

                <div class="grid gap-2">
                   
                    ?>
                </div>
            </form>
        </section>
    </main>

    <script type="module" src="./presenceTest.js"></script>
</body>

</html>