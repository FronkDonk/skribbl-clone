<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Jenssegers\Blade\Blade;

$blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

?>
<nav class="flex justify-between w-full">

    <a href="#">DrawFuse</a>
    <div>
        <?php
        echo $blade
            ->make('avatar', [
                'label' => 'Home',
                'class' => 'from-[#7FB2FF] to-[#FF7F7F]',
            ])
            ->render();
        ?>
    </div>
</nav>
