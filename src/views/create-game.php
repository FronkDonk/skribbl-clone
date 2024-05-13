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
                <div class="text-lg text-muted-foreground">
                    <span>Start a new game OR</span>
                    <a href="/" class="text-primary font-medium hover:underline">join an existing game</a>
                </div>
            </div>
            <form id="create-form" class="grid gap-4">
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
                        "class" => "",
                        "defaultValue" => $_SESSION["username"]
                    ])->render();
                    ?>
                </div>
                <?php
                echo $blade->make('button', [
                    "label" => "Create lobby",
                    "type" => "submit",
                    "class" => "w-full",
                    "id" => "",
                    "icon" => false
                ])->render();
                ?>
            </form>
        </section>
    </main>
    <script src="/dist/createGame.bundle.js"></script>

</body>

</html>