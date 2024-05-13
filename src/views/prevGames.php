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
                <h1 class="text-3xl font-semibold">Games</h1>
            </div>
            <div class="mx-auto grid w-full max-w-6xl items-start gap-6">
                <div class="grid gap-6">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Previous
                                Games</h3>
                            <p class="text-sm text-muted-foreground">View your previously played games.</p>
                        </div>
                        <div class="p-6">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&amp;_tr]:border-b">
                                        <tr
                                            class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <th
                                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                                Game
                                            </th>
                                            <th
                                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                                Date
                                            </th>
                                            <th
                                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                                Score
                                            </th>
                                            <th
                                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                                Duration
                                            </th>
                                            <th
                                                class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                                Players
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="prevGames" class="[&amp;_tr:last-child]:border-0">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script src="/dist/prevGames.bundle.js"></script>
</body>

</html>