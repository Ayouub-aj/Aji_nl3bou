<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>The Curated Playroom | New Reservation</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../style/style.css">
    <script src="../style/tailwind-config.js"></script>
    <script src="../style/main.js" defer></script>
</head>

<body class="bg-surface text-on-surface font-body selection:bg-primary selection:text-on-primary min-h-screen flex">
    <!-- SideNavBar -->
    <?php include '../includes/side_menu.php'; ?>
    <main class="admin-main lg:ml-64 flex-1 flex flex-col min-h-screen py-12 px-6 md:px-12 lg:px-24 bg-surface">
        <div class="max-w-6xl mx-auto">
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div class="flex items-center gap-4">
                    <button id="menu-toggle"
                        class="lg:hidden text-on-surface-variant flex items-center justify-center p-2 rounded-lg bg-surface-container-low border border-white/5">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div>
                        <h1 class="text-5xl md:text-6xl font-extrabold font-headline tracking-tighter text-white">
                            Secure Your <span class="text-primary italic">Seat.</span>
                        </h1>
                    </div>
                </div>
                <p class="text-on-surface-variant max-w-xl text-lg mt-4 md:mt-0">
                    Experience Aji L3bo Café's premium strategy environment.
                </p>
            </header>
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-7 space-y-8">
                    <form class="space-y-10">
                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <h3
                                class="text-secondary font-headline font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm"
                                    data-icon="calendar_month">calendar_month</span>
                                01. Date &amp; Occupancy
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label
                                        class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Select
                                        Date</label>
                                    <input
                                        class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg p-4 text-white font-medium outline-none transition-all"
                                        type="date" />
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Number
                                        of Players</label>
                                    <div class="flex items-center gap-4 bg-surface-container-highest p-1 rounded-lg">
                                        <button
                                            class="w-12 h-12 flex items-center justify-center hover:bg-white/5 rounded-md text-primary"
                                            type="button">
                                            <span class="material-symbols-outlined" data-icon="remove">remove</span>
                                        </button>
                                        <span class="flex-1 text-center font-bold text-xl">4</span>
                                        <button
                                            class="w-12 h-12 flex items-center justify-center hover:bg-white/5 rounded-md text-primary"
                                            type="button">
                                            <span class="material-symbols-outlined" data-icon="add">add</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <h3
                                class="text-secondary font-headline font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm" data-icon="schedule">schedule</span>
                                02. Pick a Time Slot
                            </h3>
                            <div class="grid grid-cols-3 md:grid-cols-4 gap-3">
                                <button
                                    class="p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all"
                                    type="button">10:00 AM</button>
                                <button
                                    class="p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all"
                                    type="button">12:30 PM</button>
                                <button
                                    class="p-3 rounded-lg bg-primary text-on-primary text-sm font-bold shadow-[0_0_15px_rgba(182,160,255,0.4)]"
                                    type="button">02:00 PM</button>
                                <button
                                    class="p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all"
                                    type="button">04:30 PM</button>
                                <button
                                    class="p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all"
                                    type="button">06:00 PM</button>
                                <button
                                    class="p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all"
                                    type="button">08:30 PM</button>
                                <button
                                    class="p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent opacity-40 cursor-not-allowed"
                                    type="button">10:00 PM</button>
                                <button
                                    class="p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all"
                                    type="button">11:30 PM</button>
                            </div>
                        </section>
                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <div class="flex justify-between items-center mb-6">
                                <h3
                                    class="text-secondary font-headline font-bold text-sm uppercase tracking-widest flex items-center gap-2">
                                    <span class="material-symbols-outlined text-sm" data-icon="casino">casino</span>
                                    03. Preferred Game
                                </h3>
                                <span
                                    class="text-[10px] bg-white/5 px-2 py-1 rounded text-on-surface-variant uppercase tracking-tighter">Optional</span>
                            </div>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant"
                                    data-icon="search">search</span>
                                <input
                                    class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg py-4 pl-12 pr-4 text-white font-medium outline-none transition-all placeholder:text-on-surface-variant/50"
                                    placeholder="Search our vault (e.g. Catan, Terraforming Mars...)" type="text" />
                            </div>
                            <div class="mt-4 flex flex-wrap gap-2">
                                <span
                                    class="px-3 py-1 bg-primary-container/20 text-primary text-xs font-medium rounded-full border border-primary/20">Scythe</span>
                                <span
                                    class="px-3 py-1 bg-secondary-container/20 text-secondary text-xs font-medium rounded-full border border-secondary/20">Catan</span>
                                <span
                                    class="px-3 py-1 bg-tertiary-container/20 text-tertiary text-xs font-medium rounded-full border border-tertiary/20">Ticket
                                    to Ride</span>
                            </div>
                        </section>
                        <button
                            class="w-full bg-gradient-to-b from-primary to-primary-dim text-on-primary py-5 rounded-xl font-headline font-extrabold text-xl shadow-2xl hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3"
                            type="submit">
                            Confirm Reservation
                            <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
</body>

</html>