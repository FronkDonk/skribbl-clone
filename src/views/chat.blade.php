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
    session_start();
    
    require $path;
    
    use Jenssegers\Blade\Blade;
    require 'db/supabase.php';
    
    $blade = new Blade('./views', './views/cache');
    if (!isset($_SESSION['messages'])) {
        $_SESSION['messages'] = [];
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['message'])) {
        array_push($_SESSION['messages'], $_POST['message']);
    }
    
    $messages = $_SESSION['messages'];
    ?>
    <section class="h-screen flex flex-col gap-2 justify-end">
        @foreach ($messages as $message)
            <?php
            echo $blade
                ->make('message', [
                    'message' => $message,
                    'username' => 'Player 1',
                    'path' => '../vendor/autoload.php',
                ])
                ->render();
            ?>
        @endforeach
        <form method="post" class="flex gap-2 ">
            <?php
            echo $blade
                ->make('input', [
                    'name' => 'message',
                    'type' => 'text',
                ])
                ->render();
            echo $blade
                ->make('button', [
                    'label' => 'send',
                    'type' => 'submit',
                ])
                ->render();
            ?>

        </form>
    </section>

</body>

</html>
