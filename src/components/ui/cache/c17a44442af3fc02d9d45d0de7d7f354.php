<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Jenssegers\Blade\Blade;

$blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

?>
<nav class="flex items-center justify-between w-full px-6 py-3 border-b shadow-sm sticky top-0 z-50 bg-background ">
    <a class="text-2xl font-semibold leading-none tracking-tight" href="#">DrawFuse</a>

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
<?php /**PATH C:\xampp\htdocs\skribbl-clone\src\components\ui/navbar.blade.php ENDPATH**/ ?>