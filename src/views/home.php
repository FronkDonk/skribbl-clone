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
    <main class="bg-background flex flex-col items-center justify-center h-screen">




        <section class="flex flex-col gap-10 w-full max-w-xl">
            <div class="flex flex-col gap-3">
                <h1 class="text-5xl">DrawFuse</h1>
                <div class="text-lg text-muted-foreground">
                    <span class=" ">join an existing game OR</span>
                    <a href="/create-game" class="text-primary font-medium hover:underline">create a new one</a>
                </div>
            </div>
            <form id="join-form" class="grid gap-4">
                <div class="grid gap-2">
                    <?php
                    echo $blade->make('label', [
                        "label" => "Game id",
                        "class" => "",
                    ])->render();
                    echo $blade->make('input', [
                        'name' => 'gameId',
                        'type' => 'text',
                        "id" => "game-id",
                        "class" => ""
                    ])->render();
                    ?>
                </div>
                <div class="grid gap-2">
                    <?php
                    echo $blade->make('label', [
                        "label" => "Username",
                        "class" => "",
                    ])->render();
                    echo $blade->make('input', [
                        'name' => 'username',
                        'type' => 'text',
                        "id" => "username",
                        "class" => ""
                    ])->render();
                    ?>
                </div>
                <?php
                echo $blade->make('button', [
                    "label" => "Join",
                    "type" => "submit",
                    "class" => "w-full",
                    "id" => "",
                    "icon" => false
                ])->render();
                ?>
            </form>
        </section>
    </main>
    <script src="/dist/joinGame.bundle.js"></script>
</body>

</html>