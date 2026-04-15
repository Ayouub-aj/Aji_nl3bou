<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Reservations | The Curated Playroom</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="../style/tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../style/style.css">
    <script src="../style/main.js" defer></script>
</head>

<body class="bg-background text-on-surface font-body selection:bg-primary selection:text-on-primary">
    <?php include '../includes/side_menu.php'; ?>
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
            <div class="relative min-w-[300px]">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant"
                    data-icon="search">search</span>
                <input
                    class="w-full pl-10 pr-4 py-2.5 bg-surface-container-highest border border-outline-variant/15 rounded-xl focus:ring-2 focus:ring-primary focus:outline-none transition-all placeholder:text-on-surface-variant/50"
                    placeholder="Search guest or game..." type="text" />
            </div>
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
                            <td class="px-6 py-5 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button
                                        class="flex items-center gap-1.5 px-4 py-2 bg-primary text-on-primary-container text-xs font-black rounded-lg hover:brightness-110 active:scale-95 transition-all">
                                        <span class="material-symbols-outlined text-sm" data-icon="login">login</span>
                                        CHECK-IN
                                    </button>
                                    <button
                                        class="p-2 hover:bg-surface-bright rounded-lg transition-colors text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg" data-icon="edit">edit</span>
                                    </button>
                                    <button
                                        class="p-2 hover:bg-error-container/20 rounded-lg transition-colors text-error">
                                        <span class="material-symbols-outlined text-lg" data-icon="cancel">cancel</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-high/50 transition-colors group bg-primary/5">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-on-surface font-bold">13:00</span>
                                    <span class="text-[10px] text-tertiary uppercase font-bold tracking-tighter">Active
                                        Now</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <img alt="Guest" class="w-8 h-8 rounded-full"
                                        data-alt="round avatar of a woman with curly hair and a joyful expression"
                                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuCxZ2teNoVcE6V6t6FhY8gk4oidHWyH78SeExLzRpeqNp_B-lEqe1Ma5iFqqwzl3DHhDCHdiWmJdE6STvKL6jSmMwhKJKUQGjM-xXgs5Gp3X5ZMYaObsru-6KHpfLV4S9nmsDYk6giAY1t1-W7n2mOkYe0FDm1UBiyS16dlNwpQvCllEA7YIDiOX9lKZbtOcjPpenIfb_r4J3l9kaQfIfCBSObepzag8WHrgBgVkYKx14AaN1V3eWCNZoE-OlyPOLImcI0zdXWvHM4" />
                                    <div class="flex flex-col">
                                        <span class="text-on-surface font-semibold">Sarah Jenkins</span>
                                        <span class="text-xs text-on-surface-variant">+1 555-0123</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="px-2 py-1 rounded bg-surface-container-highest text-on-surface text-sm font-medium">2
                                    People</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-secondary text-lg"
                                        data-icon="family_history">family_history</span>
                                    <span class="text-on-surface">Wingspan</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-tertiary-container text-on-tertiary-container">
                                    <span class="w-1.5 h-1.5 rounded-full bg-tertiary mr-1.5"></span>
                                    Seated
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button
                                        class="flex items-center gap-1.5 px-4 py-2 border border-primary/30 text-primary text-xs font-black rounded-lg hover:bg-primary/10 transition-all">
                                        <span class="material-symbols-outlined text-sm" data-icon="timer">timer</span>
                                        END SESSION
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-high/50 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-on-surface font-bold">15:45</span>
                                    <span
                                        class="text-[10px] text-on-surface-variant uppercase font-bold tracking-tighter">Later</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-surface-bright flex items-center justify-center border border-outline-variant/20 text-xs font-bold text-tertiary">
                                        DK</div>
                                    <div class="flex flex-col">
                                        <span class="text-on-surface font-semibold">David Kim</span>
                                        <span class="text-xs text-on-surface-variant">dkim_99@outlook.com</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="px-2 py-1 rounded bg-surface-container-highest text-on-surface text-sm font-medium">6
                                    People</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2 text-on-surface-variant">
                                    <span class="material-symbols-outlined text-lg" data-icon="casino">casino</span>
                                    <span class="italic text-sm">Undecided</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-surface-container-highest text-on-surface-variant border border-outline-variant/20">
                                    <span class="w-1.5 h-1.5 rounded-full bg-outline mr-1.5"></span>
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div
                                    class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button
                                        class="px-3 py-1.5 bg-tertiary text-on-tertiary-container text-[10px] font-black rounded hover:brightness-110">CONFIRM</button>
                                    <button
                                        class="p-2 hover:bg-surface-bright rounded-lg transition-colors text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg"
                                            data-icon="more_vert">more_vert</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-surface-container-high/50 transition-colors group opacity-60">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-on-surface font-bold">12:15</span>
                                    <span
                                        class="text-[10px] text-error uppercase font-bold tracking-tighter">Missed</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-surface-bright flex items-center justify-center border border-outline-variant/20 text-xs font-bold text-error">
                                        RR</div>
                                    <div class="flex flex-col">
                                        <span class="text-on-surface font-semibold">Robert Ross</span>
                                        <span class="text-xs text-on-surface-variant">rob.ross@domain.com</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="px-2 py-1 rounded bg-surface-container-highest text-on-surface text-sm font-medium">3
                                    People</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg"
                                        data-icon="extension">extension</span>
                                    <span class="text-on-surface">Catan</span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-error-container/20 text-error">
                                    <span class="w-1.5 h-1.5 rounded-full bg-error mr-1.5"></span>
                                    Canceled
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <span class="text-[10px] text-on-surface-variant uppercase font-black">Archive</span>
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
    <?php include '../includes/footer.php'; ?>
</body>

</html>