<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/src/output.css" rel="stylesheet">
    <title>Document</title>
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
                    <h1 class="text-3xl font-bold">Sign in</h1>
                    <p class="text-balance text-muted-foreground">
                        Enter your email below to sign in to your account
                    </p>
                </div>
                <form id="myForm" method="post" class="grid gap-4">
                    <div class="grid gap-2">
                        <?php
                        echo $blade->make('label', [
                            "label" => "email",
                        ])->render();
                        echo $blade->make('input', [
                            "name" => "email",
                            "type" => "email",
                            "id" => "",
                        ])->render();
                        ?>
                    </div>
                    <div class="grid gap-2">
                        <div class="flex items-center">
                            <?php
                            echo $blade->make('label', [
                                "label" => "Password",
                            ])->render();
                            ?>
                            <a href="/forgot-password" class="ml-auto inline-block text-sm underline">
                                Forgot your password?
                            </a>
                        </div>
                        <?php

                        echo $blade->make('input', [
                            "name" => "password",
                            "type" => "password",
                            "id" => "",
                        ])->render();
                        ?>
                    </div>
                    <?php
                    echo $blade->make('button', [
                        "label" => "Sign in",
                        "icon" => false,
                        "type" => "submit",
                        "class" => "w-full",
                    ])->render();
                    ?>
                </form>

                <div class="mt-4 text-center text-sm">
                    Don't have an account?
                    <a href="#" class="underline ">
                        Sign up
                    </a>
                </div>
            </div>
        </div>
        <div class="hidden bg-muted lg:block">
            <img src="/placeholder.svg" alt="Image" width="1920" height="1080"
                class="h-full w-full object-cover dark:brightness-[0.2] dark:grayscale" />
        </div>
    </div>
    <script>
        document.getElementById('myForm').addEventListener('submit', async function (event) {
            event.preventDefault(); // Prevent the form from being submitted normally

            const formData = new FormData(this); // Create a FormData object from the form

            // Send the form data to the server with fetch
            const res = await fetch('/api/auth/sign-in', {
                method: 'POST',
                body: formData
            })
            if (!res.ok) {

                const data
                    = await res.json();
                console.log(`Error: ${data.message}`);
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