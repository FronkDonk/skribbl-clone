      <?php
      
      ?>

      <div class="p-2 bg-muted rounded-md flex items-center gap-2 <?php echo e($class); ?>">
          <?php
          
          echo $blade
              ->make('avatar', [
                  'class' => 'from-[#7FB2FF] to-[#FF7F7F]',
              ])
              ->render();
          ?>
          <div>
              <div class="flex items-center gap-2 ">
                  <?php
                  echo $blade
                      ->make('label', [
                          'label' => $username,
                          'class' => 'text-base',
                      ])
                      ->render();
                  ?>
                  <!-- date -->
                  <p class="text-sm text-muted-foreground">9:11pm</p>
              </div>

              <p class="text-sm "><?php echo e($message); ?></p>
          </div>
      </div>
<?php /**PATH C:\xampp\htdocs\skribbl-clone\src\views/message.blade.php ENDPATH**/ ?>