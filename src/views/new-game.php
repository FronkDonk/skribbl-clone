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
    <main class=" h-screen bg-background p-6  ">
        <section id="playerView">
            <div class="flex flex-col space-y-1.5 p-6">
                <h3 class="text-2xl font-semibold leading-none tracking-tight">Waiting for host to start the game</h3>
                <p class="text-sm text-muted-foreground">Feel free to practice your drawing skills in the meantime</p>
            </div>
            <div class=" bg-muted rounded-lg ">
                <div class="onlineUsers flex gap-3 border-b">
                </div>
                <canvas id="playerCanvas" class=" bg-muted aspect-video w-full ">

                </canvas>
                <svg class="cursor absolute h-8 w-8" viewBox="0 0 389 408" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M75.2425 395.818L6.94946 8.50924L376.515 143.02L200.629 237.751L199.717 238.242L199.076 239.054L75.2425 395.818Z" fill="#22E9E9" stroke="#FBFFFF" stroke-width="10" />
                </svg>
        </section>
        <section id="ownerView" class="flex gap-6 h-full ">
            <div class="rounded-lg border  bg-card text-card-foreground shadow-sm  min-w-[40%]">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">Game settings</h3>
                    <p class="text-sm text-muted-foreground">Configure your game settings and invite your friends!
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <form id="myForm" class="grid gap-4 ">
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
                        <?php
                        echo $blade->make('button', [
                            "label" => "Create game",
                            "type" => "submit",
                            "id" => "startGame",
                            "icon" => false
                        ])->render();

                        ?>
                        <input type="hidden" name="game-id" id="game-id" value="">
                    </form>
                </div>
            </div>

            <div class="rounded-lg bg-muted text-card-foreground h-full w-full ">

                <div class="onlineUsers flex flex-col gap-3 p-2 ">

                </div>
            </div>
        </section>
    </main>

    <!--     <script src="/src/js/lobbyForm.js" type="module"></script>
    <script scr="/src/js/actions/getUserData.js" type="module"></script>
    <script src="/src/js/lobbyView.js" type="module"></script>
    <script src="/src/js/lobbyPresence.js" type="module"></script>
    <script src="/src/js/lobby.js" type="module"></script>
    <script src="/src/js/lobbyCanvas.js" type="module"></script> -->
    <script src="/dist/lobby.bundle.js"></script>

</body>

</html>