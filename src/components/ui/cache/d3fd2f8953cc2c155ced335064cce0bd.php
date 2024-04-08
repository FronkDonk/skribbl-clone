          <?php
          require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
          
          use Jenssegers\Blade\Blade;
          
          $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');
          $message = $message ?? '';
          ?>
          <?php if($message): ?>
              <div class="p-2 bg-muted rounded-md flex items-center gap-2">
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
                          <p class="text-sm text-muted-foreground"><?php echo e($sentAt); ?></p>
                      </div>

                      <p class="text-sm "><?php echo e($message); ?></p>
                  </div>
              </div>
          <?php endif; ?>
<?php /**PATH C:\xampp\htdocs\skribbl-clone\src\components\ui/message.blade.php ENDPATH**/ ?>