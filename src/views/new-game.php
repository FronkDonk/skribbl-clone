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
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

    use Jenssegers\Blade\Blade;

    $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');
    ?>
    <?php
    $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');
    echo $blade->make("navbar")->render();
    ?>
    <main class="bg-background flex flex-col items-center justify-center h-screen">
        <section class="flex flex-col gap-10 w-full max-w-xl">
            <div class="flex flex-col gap-3">
                <h1 class="text-5xl">DrawFuse</h1>
                <p class="text-muted-foreground text-lg">Start a new game</p>
            </div>
            <div id="players" class="flex gap-3">

            </div>
            <form id="new-game-form" class="grid gap-4">
                <div class="grid gap-2">
                    <?php
                    echo $blade->make('label', [
                        "label" => "Maximum players",
                    ])->render();
                    echo $blade->make('select', [
                        "id" => "maxPlayers",
                        "options" => [
                            '2',
                            '4',
                            '6',
                            '8',
                        ]
                    ])->render();
                    ?>
                </div>
                <div class="grid gap-2">
                    <?php
                    echo $blade->make('label', [
                        "label" => "Number of rounds",
                    ])->render();
                    echo $blade->make('select', [
                        "id" => "numRounds",
                        "options" => [
                            '3',
                            '6',
                            '8',
                        ]
                    ])->render();
                    ?>
                </div>
                <div class="grid gap-2">
                    <?php
                    echo $blade->make('label', [
                        "label" => "Drawing time",
                    ])->render();
                    echo $blade->make('select', [
                        "id" => "drawingTime",
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
                    <?php
                    echo $blade->make('label', [
                        "label" => "Visibility",
                    ])->render();
                    echo $blade->make('select', [
                        "id" => "visibility",
                        "options" => [
                            'Public',
                            'Private',
                        ]
                    ])->render();
                    ?>
                </div>
                <div id="players">

                </div>
                <?php
                echo $blade->make('button', [
                    "label" => "Start game",
                    "type" => "submit",
                    "class" => "w-full",
                    "id" => "startGame",
                    "icon" => false
                ])->render();
                ?>
                <input type="hidden" name="game-id" id="game-id" value="">
            </form>
        </section>
    </main>
    <script src="/dist/lobby.bundle.js"></script>
</body>

</html>