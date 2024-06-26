<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../output.css" rel="stylesheet">
    <title>Sign up</title>
</head>

<body>
    <?php
    session_start();
    $signUpSuccess = false;
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';
    
    use Jenssegers\Blade\Blade;
    
    $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
        require '../db/supabase.php';
    
        $username = $_POST['username'];
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = $_POST['password'];
        $auth = $service->createAuth();
    
        try {
            $user_metadata = [
                'username' => $_POST['username'],
            ];
    
            $auth->createUserWithEmailAndPassword($email, $password, $user_metadata);
            $data = $auth->data();
            print_r($data);
            $signUpSuccess = true;
            $_SESSION['userId'] = $data->$id;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    ?>
    <div class="w-full h-svh lg:grid lg:min-h-[600px] lg:grid-cols-2 xl:min-h-[800px]">
        <div class="flex items-center justify-center py-12">
            <div class="mx-auto grid w-[350px] gap-6">
                <div class="grid gap-2 text-center">
                    <h1 class="text-3xl font-bold"><?php echo e($signUpSuccess ? 'Check your email!' : 'Sign up'); ?></h1>
                    <p class="text-balance text-muted-foreground">
                        <?php echo e($signUpSuccess ? 'We just sent a verification link to' : 'Enter your information to create an account'); ?>

                        <?php if($signUpSuccess): ?>
                            <span class=" text-accent text-5xl"><?php echo e($email); ?></span>
                        <?php endif; ?>
                    </p>
                </div>
                <?php if(!$signUpSuccess): ?>
                    <form method="post" class="grid gap-4">
                        <div class="grid gap-2">
                            <?php
                            echo $blade
                                ->make('label', [
                                    'label' => 'Username',
                                ])
                                ->render();
                            echo $blade
                                ->make('input', [
                                    'name' => 'username',
                                    'type' => 'text',
                                ])
                                ->render();
                            ?>
                        </div>
                        <div class="grid gap-2">
                            <?php
                            echo $blade
                                ->make('label', [
                                    'label' => 'Email',
                                ])
                                ->render();
                            echo $blade
                                ->make('input', [
                                    'name' => 'email',
                                    'type' => 'email',
                                ])
                                ->render();
                            ?>
                        </div>
                        <div class="grid gap-2">
                            <?php
                            echo $blade
                                ->make('label', [
                                    'label' => 'Password',
                                ])
                                ->render();
                            echo $blade
                                ->make('input', [
                                    'name' => 'password',
                                    'type' => 'password',
                                ])
                                ->render();
                            ?>
                        </div>
                        <div>
                            <?php
                            echo $blade
                                ->make('button', [
                                    'type' => 'submit',
                                    'label' => 'Sign up',
                                    'class' => 'w-full',
                                ])
                                ->render();
                            ?>
                        </div>
                    </form>
                    <div class="mt-4 text-center text-sm">
                        Already have an account?
                        <a href="#" class="underline ">
                            Sign in
                        </a>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <div class="hidden bg-muted lg:block">
            <img src="/placeholder.svg" alt="Image"
                class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
    </div>


</body>

</html>
<?php /**PATH C:\xampp\htdocs\ecommerce-store\src\components\ui/sign-up.blade.php ENDPATH**/ ?>