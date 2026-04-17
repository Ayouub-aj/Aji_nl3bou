<?php
require_once __DIR__ . '/../../config/init.php';
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Reservations | The Curated Playroom</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= URLROOT; ?>/public/style/tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?= URLROOT; ?>/public/style/style.css">
</head>

<body class="bg-surface text-on-surface font-body selection:bg-primary selection:text-on-primary">
    <?php include __DIR__ . '/../includes/side_menu.php'; ?>
    <main class="lg:ml-64 admin-main min-h-screen p-8 bg-background">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
            <div class="flex items-center gap-4">
                <button id="menu-toggle"
                    class="lg:hidden text-on-surface-variant flex items-center justify-center p-2 rounded-lg bg-surface-container-low border border-white/5">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h2 class="text-4xl font-headline font-extrabold tracking-tighter text-on-surface">Reservations</h2>
                    <p class="text-on-surface-variant font-body mt-1">Managing 24 bookings for today, Oct 24th.</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-surface-container-low p-1 rounded-xl">
                <button
                    class="px-4 py-2 rounded-lg bg-surface-container-highest text-on-surface shadow-sm font-medium transition-colors">List
                    View</button>
                <button
                    class="px-4 py-2 rounded-lg text-on-surface-variant hover:text-on-surface transition-colors font-medium">Calendar</button>
            </div>
        </header>
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <button
                    class="px-4 py-2 rounded-full text-sm font-semibold bg-primary text-on-primary shadow-lg shadow-primary/20">All</button>
                <button
                    class="px-4 py-2 rounded-full text-sm font-semibold bg-surface-container-high text-on-surface-variant hover:bg-surface-bright transition-colors border border-outline-variant/10">Confirmed</button>
                <button
                    class="px-4 py-2 rounded-full text-sm font-semibold bg-surface-container-high text-on-surface-variant hover:bg-surface-bright transition-colors border border-outline-variant/10">Pending</button>
                <button
                    class="px-4 py-2 rounded-full text-sm font-semibold bg-surface-container-high text-on-surface-variant hover:bg-surface-bright transition-colors border border-outline-variant/10">Canceled</button>
            </div>
            <form method="GET" action="reservation_admin.php" class="relative min-w-[300px]">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant"
                    data-icon="search">search</span>
                <input
                    class="w-full pl-10 pr-4 py-2.5 bg-surface-container-highest border border-outline-variant/15 rounded-xl focus:ring-2 focus:ring-primary focus:outline-none transition-all placeholder:text-on-surface-variant/50"
                    name="query" placeholder="Search guest or game..." type="text" />
            </form>
        </div>
        <div class="bg-surface-container-low rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-surface-container text-on-surface-variant text-xs uppercase tracking-widest font-bold">
                            <th class="px-6 py-5">Time</th>
                            <th class="px-6 py-5">Guest</th>
                            <th class="px-6 py-5">Size</th>
                            <th class="px-6 py-5">Game Request</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        <tr class="hover:bg-surface-container-high/50 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-on-surface font-bold">14:30</span>
                                    <span class="text-[10px] text-primary uppercase font-bold tracking-tighter">In 15
                                        mins</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-surface-bright flex items-center justify-center border border-outline-variant/20">
                                        <span class="text-xs font-bold text-secondary">MH</span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-on-surface font-semibold">Marcus Holloway</span>
                                        <span class="text-xs text-on-surface-variant">marcus.h@gmail.com</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="px-2 py-1 rounded bg-surface-container-highest text-on-surface text-sm font-medium">4
                                    People</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg"
                                        data-icon="strategy">strategy</span>
                                    <span class="text-on-surface">Terraforming Mars</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-secondary-container text-on-secondary-container">
                                    <span class="w-1.5 h-1.5 rounded-full bg-secondary mr-1.5"></span>
                                    Confirmed
                                </span>
                            </td>
                        </tr>           
                    </tbody>
                </table>
            </div>
            <div
                class="p-6 bg-surface-container-low border-t border-outline-variant/5 flex items-center justify-between">
                <span class="text-sm text-on-surface-variant font-medium">Showing 4 of 24 reservations</span>
                <div class="flex gap-2">
                    <button
                        class="p-2 rounded-lg bg-surface-container-highest text-on-surface-variant hover:text-on-surface transition-colors disabled:opacity-30"
                        disabled="">
                        <span class="material-symbols-outlined" data-icon="chevron_left">chevron_left</span>
                    </button>
                    <button
                        class="p-2 rounded-lg bg-surface-container-highest text-on-surface-variant hover:text-on-surface transition-colors">
                        <span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
                    </button>
                </div>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
