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
    
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
    
    use Jenssegers\Blade\Blade;
    require 'db/supabase.php';
    $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');
    
    ?>
    <section class="h-screen flex flex-col gap-2 justify-end">
        <?php
        echo $blade
            ->make('message', [
                'username' => 'Player 1',
                'path' => '../vendor/autoload.php',
            ])
            ->render();
        ?>
        <div id="chatMessages"></div>
        <form class="flex gap-2 ">
            <?php
            echo $blade
                ->make('input', [
                    'name' => 'message',
                    'type' => 'text',
                    'id' => 'message',
                ])
                ->render();
            echo $blade
                ->make('button', [
                    'label' => 'send',
                    'type' => 'submit',
                    'class' => '',
                ])
                ->render();
            ?>

        </form>

    </section>
    <script type="module" src="chat.js"></script>
    <script type="module" src="message.js"></script>


</body>

</html>
