

<div class="flex flex-col gap-px relative">
    <div onclick="toggleSelect(event)"
        class="flex justify-between font-semibold  w-full py-2 px-3 rounded-md 
border-2 hover:border-primary border-input bg-background text-sm  
disabled:cursor-not-allowed 
disabled:opacity-50 select-none">
        <p id="selectLabel"><?php echo e($label); ?></p>
        <p>chevron</p>
    </div>
    <div class="z-50">
        <div id="dropdown"
            class="hidden bg-background absolute text-sm font-semibold w-full
        border-2 border-input disabled:cursor-not-allowed 
        disabled:opacity-50 select-none rounded-md p-1">
            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="py-2 pl-12 cursor-pointer hover:bg-muted rounded-md" onclick="handleClick(event)">
                    <?php echo e($label); ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<script>
    function handleClick(event) {
        console.log(event.target.innerText); // Logs the clicked element to the console
        document.getElementById('selectLabel').innerText = event.target.innerText;
    }

    function toggleSelect(event) {
        event.stopPropagation();
        let dropdown = document.getElementById('dropdown');
        if (dropdown.style.display === "none") {
            dropdown.style.display = "block";
        } else {
            dropdown.style.display = "none";
        }
    }

    document.addEventListener('click', function() {
        let dropdown = document.getElementById('dropdown');
        dropdown.style.display = "none";
    });
</script>
<?php /**PATH C:\xampp\htdocs\ecommerce-store\src\components\ui/select.blade.php ENDPATH**/ ?>