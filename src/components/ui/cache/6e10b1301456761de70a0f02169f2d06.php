<button type="<?php echo e($type); ?>" id="<?php echo e($id ?? 'button'); ?>"
    class="inline-flex items-center justify-center whitespace-nowrap
		        rounded-[0.3rem]  text-sm font-medium ring-offset-background transition-colors
		        focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring
		        focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50
		        bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2 
                <?php echo e($class); ?>">
    <?php if($icon): ?>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="w-5 h-5 absolute">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 10.5 12 3m0 0 7.5 7.5M12 3v18" />
        </svg>
    <?php else: ?>
        <?php echo e($label); ?>

    <?php endif; ?>
</button>
<?php /**PATH C:\xampp\htdocs\skribbl-clone\src\components\ui/button.blade.php ENDPATH**/ ?>