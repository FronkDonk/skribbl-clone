<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/src/output.css">
</head>

<body>
    <div class="flex min-h-screen w-full flex-col">
        <?php
        require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

        use Jenssegers\Blade\Blade;

        $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');

        ?>
        <?php
        $blade = new Blade($_SERVER['DOCUMENT_ROOT'] . '/src/components/ui', $_SERVER['DOCUMENT_ROOT'] . '/src/components/ui/cache');
        echo $blade->make("navbar")->render();
        ?>
        <main
            class="flex min-h-[calc(100vh_-_theme(spacing.16))] flex-1 flex-col gap-4 bg-muted/40 p-4 md:gap-8 md:p-10">
            <div class="mx-auto grid w-full max-w-6xl gap-2">
                <h1 class="text-3xl font-semibold">Profile</h1>
            </div>
            <div
                class="mx-auto grid w-full max-w-6xl items-start gap-6 md:grid-cols-[180px_1fr] lg:grid-cols-[250px_1fr]">
                <nav class="grid gap-4 text-sm text-muted-foreground" x-chunk="dashboard-04-chunk-0">
                    <a class="font-semibold " href="/profile">Profile</a>
                    <a class="font-semibold " href="/profile/games">Games</a>
                </nav>
                <div class="grid gap-6">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm" x-chunk="dashboard-04-chunk-1"
                        data-v0-t="card">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">
                                Profile Information
                            </h3>
                            <p class="text-sm text-muted-foreground">Update your personal information.</p>
                        </div>
                        <div class="p-6">
                            <form id="profile-form">
                                <div class="space-y-4">
                                    <div>
                                        <label
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                            for="name">
                                            Username
                                        </label>
                                        <input
                                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                            name="username" id="username" placeholder="Enter your username" />
                                    </div>
                                    <div>
                                        <label
                                            class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                            for="email">
                                            Email
                                        </label>
                                        <input
                                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                            name="email" id="email" placeholder="Enter your email" type="email" />
                                    </div>
                                </div>
                                <div class="flex items-center mt-6 border-t py-4">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm" x-chunk="dashboard-04-chunk-2"
                        data-v0-t="card">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Change
                                Password</h3>
                            <p class="text-sm text-muted-foreground">Update your account password.</p>
                        </div>
                        <div class="p-6">
                            <form id="password-form" class="space-y-4" data-bitwarden-watching="1">
                                <div>
                                    <label
                                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                        for="password">
                                        Current Password
                                    </label>
                                    <input name="password"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        id="password" placeholder="Enter your current password" type="password" />
                                </div>
                                <div>
                                    <label
                                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                        for="newPassword">
                                        New Password
                                    </label>
                                    <input name="new-password"
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        id="newPassword" placeholder="Enter your new password" type="password" />
                                </div>
                                <div>
                                    <label
                                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                        for="confirmPassword">
                                        Confirm Password
                                    </label>
                                    <input
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        id="confirmPassword" placeholder="Confirm your new password" type="password" />
                                </div>
                                <div class="flex items-center mt-6 border-t py-4">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Change password
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm" x-chunk="dashboard-04-chunk-1"
                        data-v0-t="card">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">
                                Delete account
                            </h3>
                            <form id="delete-account">
                                <div>
                                    <label
                                        class="text-sm font-medium leading-none peer-disabled:cursor-not-allowed peer-disabled:opacity-70"
                                        for="confirmPassword">
                                        Password
                                    </label>
                                    <input
                                        class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                                        name="delete" placeholder="Enter your password" type="password" />
                                </div>
                                <div class="flex items-center mt-6 border-t py-4">
                                    <button type="submit"
                                        class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-primary text-primary-foreground hover:bg-primary/90 h-10 px-4 py-2">
                                        Delete account
                                    </button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="/dist/profile.bundle.js"></script>
</body>

</html>