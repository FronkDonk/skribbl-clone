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
    <main class="min-h-screen ">
        <div class="p-6 flex justify-center items-center">


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
        </div>
        <!--   <div class="rounded-lg border bg-card text-card-foreground shadow-sm">
            <div class="flex flex-col space-y-1.5 p-6">
                <div id="wordSelection" class="text-2xl font-semibold leading-none tracking-tight">
                    hej
                </div>
            </div>
        </div> -->
        <div class="flex gap-2" id="wordSelection">

        </div>
    </main>
    <script src="/dist/game.bundle.js"></script>
</body>

</html>