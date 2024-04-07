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
    <main class="min-h-screen p-6 flex justify-center items-center">
        <div class="flex" id="wordSelection">
            
        </div>
        <section id="section" class="flex justify-center gap-5 w-full  max-w-[100rem] ">
            <div class="w-[70%]">
                <div class="bg-muted rounded-lg">
                    <canvas id="gameCanvas" class="aspect-video w-full"></canvas>
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
        </section>
    </main>
    <script src="/dist/game.bundle.js"></script>
</body>

</html>