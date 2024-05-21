<?php
use Jenssegers\Blade\Blade;

$blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/temp');
?>

<header class="sticky top-0 flex justify-between h-16 items-center gap-4 border-b bg-background px-4 md:px-6">
    <a class="transition-colors text-lg hover:text-muted-foreground font-semibold " href="/">
        DrawFuse
    </a>
    <nav class="font-medium flex flex-row items-center gap-5 text-sm lg:gap-6">

        <a class="text-muted-foreground transition-colors hover:text-foreground" href="/create-game">
            Create game
        </a>
        <a class="text-muted-foreground transition-colors hover:text-foreground" href="/">
            Join game
        </a>
        <a class="text-muted-foreground transition-colors hover:text-foreground" href="/profile">
            Profile
        </a>
    </nav>
    <a href="/auth/sign-out">
        <?php
        if (isset($_SESSION['userId'])) {
            echo $blade
                ->make('button', [
                    'label' => 'Sign out',
                    'icon' => false,
                    'type' => '',
                    'class' => '',
                ])
                ->render();
        }
        ?>
    </a>
</header>
