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
        <header class="sticky top-0 flex h-16 items-center gap-4 border-b bg-background px-4 md:px-6">
            <nav class="hidden flex-col gap-6 text-lg font-medium md:flex md:flex-row md:items-center md:gap-5 md:text-sm lg:gap-6">
                <a class="flex items-center gap-2 text-lg font-semibold md:text-base" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-6 w-6">
                        <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z"></path>
                        <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9"></path>
                        <path d="M12 3v6"></path>
                    </svg>
                    <span class="sr-only">Acme Inc</span>
                </a>
                <a class="text-muted-foreground transition-colors hover:text-foreground" href="#">
                    Dashboard
                </a>
                <a class="text-muted-foreground transition-colors hover:text-foreground" href="#">
                    Orders
                </a>
                <a class="text-muted-foreground transition-colors hover:text-foreground" href="#">
                    Products
                </a>
                <a class="text-muted-foreground transition-colors hover:text-foreground" href="#">
                    Customers
                </a>
                <a class="text-foreground transition-colors hover:text-foreground" href="#">
                    Settings
                </a>
                <a class="text-foreground transition-colors hover:text-foreground" href="#">
                    Games
                </a>
            </nav>
            <button class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 border border-input bg-background hover:bg-accent hover:text-accent-foreground h-10 w-10 shrink-0 md:hidden" type="button" aria-haspopup="dialog" aria-expanded="false" aria-controls="radix-:rp:" data-state="closed">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <line x1="4" x2="20" y1="12" y2="12"></line>
                    <line x1="4" x2="20" y1="6" y2="6"></line>
                    <line x1="4" x2="20" y1="18" y2="18"></line>
                </svg>
                <span class="sr-only">Toggle navigation menu</span>
            </button>
            <div class="flex w-full items-center gap-4 md:ml-auto md:gap-2 lg:gap-4">
                <form class="ml-auto flex-1 sm:flex-initial">
                    <div class="relative">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="absolute left-2.5 top-2.5 h-4 w-4 text-muted-foreground">
                            <circle cx="11" cy="11" r="8"></circle>
                            <path d="m21 21-4.3-4.3"></path>
                        </svg>
                        <input class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 pl-8 sm:w-[300px] md:w-[200px] lg:w-[300px]" placeholder="Search products..." type="search" />
                    </div>
                </form>
                <button class="inline-flex items-center justify-center whitespace-nowrap text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-secondary text-secondary-foreground hover:bg-secondary/80 h-10 w-10 rounded-full" type="button" id="radix-:rs:" aria-haspopup="menu" aria-expanded="false" data-state="closed">
                    <img src="/placeholder.svg" width="32" height="32" class="rounded-full border" alt="Avatar" style="aspect-ratio: 32 / 32; object-fit: cover;" />
                    <span class="sr-only">Toggle user menu</span>
                </button>
            </div>
        </header>
        <main class="flex min-h-[calc(100vh_-_theme(spacing.16))] flex-1 flex-col gap-4 bg-muted/40 p-4 md:gap-8 md:p-10">
            <div class="mx-auto grid w-full max-w-6xl gap-2">
                <h1 class="text-3xl font-semibold">Games</h1>
            </div>
            <div class="mx-auto grid w-full max-w-6xl items-start gap-6">
                <div class="grid gap-6">
                    <div class="rounded-lg border bg-card text-card-foreground shadow-sm" data-v0-t="card">
                        <div class="flex flex-col space-y-1.5 p-6">
                            <h3 class="whitespace-nowrap text-2xl font-semibold leading-none tracking-tight">Previous Games</h3>
                            <p class="text-sm text-muted-foreground">View your previously played games.</p>
                        </div>
                        <div class="p-6">
                            <div class="relative w-full overflow-auto">
                                <table class="w-full caption-bottom text-sm">
                                    <thead class="[&amp;_tr]:border-b">
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                                Game
                                            </th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                                Date
                                            </th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                                Score
                                            </th>
                                            <th class="h-12 px-4 text-left align-middle font-medium text-muted-foreground [&amp;:has([role=checkbox])]:pr-0">
                                                Duration
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="prevGames" class="[&amp;_tr:last-child]:border-0">
                                        <!--  <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Tetris</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2023-04-15</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">1000</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">30 minutes</td>
                                        </tr>
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Pacman</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2023-03-20</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">5000</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">45 minutes</td>
                                        </tr>
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Space Invaders</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2023-02-28</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2500</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">60 minutes</td>
                                        </tr>
                                      
                                        <tr class="border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted">
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">Donkey Kong</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">2022-12-05</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">4000</td>
                                            <td class="p-4 align-middle [&amp;:has([role=checkbox])]:pr-0">50 minutes</td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>