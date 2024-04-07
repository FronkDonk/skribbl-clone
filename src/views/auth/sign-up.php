<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/src/output.css" rel="stylesheet">
    <title>Sign up</title>
</head>

<body>
    <?php
    require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

    use Jenssegers\Blade\Blade;

    $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

    ?>
    <div class="w-full h-svh lg:grid lg:min-h-[600px] lg:grid-cols-2 xl:min-h-[800px]">
        <div class="flex items-center justify-center py-12">
            <div class="mx-auto grid w-[350px] gap-6">
                <div class="grid gap-2 text-center">
                    <h1 class="text-3xl font-bold">Sign up</h1>
                    <p class="text-balance text-muted-foreground">
                        Enter your information to create an account
                        <span class=" text-accent text-5xl"></span>
                    </p>
                </div>
                <form id="myForm" method="post" class="grid gap-4">
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
                                "icon" => false,

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
            </div>
        </div>
        <div class="hidden bg-muted lg:block">
            <img src="/placeholder.svg" alt="Image"
                class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
    </div>

    <script>
        document.getElementById('myForm').addEventListener('submit', async function (event) {
            event.preventDefault(); // Prevent the form from being submitted normally

            const formData = new FormData(this); // Create a FormData object from the form

            // Send the form data to the server with fetch
            const res = await fetch('/api/auth/sign-up', {
                method: 'POST',
                body: formData
            })
            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            } else {
                const {
                    data
                } = await res.json();
                // Log the response body to the console
                console.log(data);

            }


        });
    </script>
</body>

</html>