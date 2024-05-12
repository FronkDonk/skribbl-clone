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
    < class="min-h-screen p-6">
        <section id="section" class="w-full flex flex-col gap-3 ">
            <div id="scoreboard" class="flex flex-wrap gap-2">
            </div>
            <div class="flex w-full gap-5">
                <div class="w-[80%]">
                    <div class="bg-muted rounded-lg relative w-full p-2 ">
                        <canvas id="gameCanvas" class="aspect-video w-full"></canvas>
                        <div id="draw" class="p-2 flex gap-2 items-center">

                        </div>
                        <div id="counter" class="text-3xl font-medium absolute right-0 top-0 p-2 ">

                        </div>

                    </div>
                </div>
                <div class="max-h-full">
                    <div class=" flex flex-col justify-end relative h-full">
                        <div id="chat" class="flex flex-col gap-2 ">

                        </div>
                        <form class="flex gap-2 items-center" id="guessForm">
                            <?php
                            echo $blade->make("input", [
                                "id" => "message",
                                "name" => "message",
                                "placeholder" => "Enter your guess here",
                                "type" => "text",
                            ])->render();
                            echo $blade->make("button", [
                                "icon" => true,
                                "type" => "submit",
                                "class" => "aspect-square"
                            ])->render();
                            ?>
                        </form>
                    </div>
                </div>
            </div>
            <div class=" gap-2 w-full flex justify-start" id="wordSelection">

            </div>
        </section>
        <section class="" id="gameFinished">
            <div class="flex flex-col gap-2 items-center">
                <h1 class="text-3xl font-bold">Game Over</h1>
                <p class="text-lg">The word was <span id="word"></span></p>
                <p class="text-lg">The winner is <span id="winner"></span></p>
                <button id="playAgain" class="bg-primary text-white p-2 rounded-lg">Play Again</button>
            </div>
        </section>


        </main>
        <script src="/dist/game.bundle.js"></script>
</body>

</html>