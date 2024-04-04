<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Jenssegers\Blade\Blade;

$blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

?>

<div class="flex items-center p-4 justify-between rounded-lg border bg-card text-card-foreground shadow-sm">
    <div class="flex gap-2 items-center ">
        <?php
        echo $blade
            ->make('avatar', [
                'class' => 'from-[#7FB2FF] to-[#FF7F7F]',
            ])
            ->render();
        ?>
        <div class="flex items-center gap-2">
            <h3 class="text-xl font-semibold leading-none tracking-tight">
                <?php echo e($username); ?>

            </h3>
            <?php if($isClient): ?>
                <p class="text-lg text-muted-foreground">(You)</p>
            <?php endif; ?>
        </div>
    </div>
    <?php if($isOwner): ?>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-6 h-6 stroke-primary">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
        </svg>
    <?php elseif(!$isOwner && !$isClient): ?>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
            stroke="currentColor" class="w-6 h-6 stroke-destructive">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
        </svg>
    <?php endif; ?>

</div>
<?php /**PATH C:\xampp\htdocs\ecommerce-store\src\components\ui/onlineAvatars.blade.php ENDPATH**/ ?>