<?php
require_once __DIR__ . '/../../config/init.php';
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>The Playroom | Client Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= URL_ROOT ?>/public/style/tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?= URL_ROOT ?>/public/style/style.css">
</head>

<body class="bg-surface text-on-surface antialiased overflow-x-hidden">
    <div class="flex min-h-screen">
        <!-- SideNavBar -->
        <?php include __DIR__ . '/../includes/client_side_menu.php'; ?>
        <main class="admin-main flex-1 lg:ml-64 p-4 md:p-10 mb-24 md:mb-0">
            <!-- Header section with Tonal Layering -->
            <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div class="flex items-center gap-4">
                    <button id="menu-toggle"
                        class="lg:hidden text-on-surface-variant flex items-center justify-center p-2 rounded-lg bg-surface-container-low border border-white/5">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <div>
                        <?php if (isset($welcome_message)): ?>
                        <div class="bg-primary-container/20 border border-primary/30 rounded-lg px-4 py-2 mb-4">
                            <p class="text-primary text-sm"><?= htmlspecialchars($welcome_message) ?></p>
                        </div>
                        <?php endif; ?>
                        <h2 class="text-3xl md:text-5xl font-extrabold tracking-tight text-on-surface mb-2">Welcome
                            back, <?= htmlspecialchars($user['username'] ?? 'Strategist') ?>.</h2>
                        <p class="text-on-surface-variant text-lg">Your next move is waiting at Aji L3bo.</p>
                    </div>
                </div>
                <div class="flex items-center gap-4 bg-surface-container-low p-2 rounded-2xl">
                    <div class="flex flex-col items-end px-2">
                        <span class="text-xs text-on-surface-variant uppercase tracking-widest font-bold">Loyalty
                            Tier</span>
                        <span class="text-secondary font-headline font-bold">Grandmaster Rank</span>
                    </div>
                    <div
                        class="w-12 h-12 rounded-xl bg-surface-container-highest overflow-hidden border border-outline-variant/30">
                        <img alt="User profile avatar" class="w-full h-full object-cover"
                            data-alt="close-up portrait of a young man with a confident expression in low-key lighting with deep shadows and soft purple highlights"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuBhdKLaFzV9fj59B4lxJ3vbMibJ3iKbOfYSXJ-0EeT1aHgYBe8RRJ3p-CW7aIpvmME7HuD2yw2mPEaRGPs7huLEdlKU0vTGdyTw9zYRMlN7ecIrwvVEZ-o_4xwS7JyI1klD58PfD_j-Bx6PJQXy_5gsCPxZ5c498VJWAHrJ5r6Kq5U6hbIecxpExqeZdRpDUB0jPlFLGrxlPORYAVjnazQvSXEophkIzepYJPyMwG5B8GBov8Ez9IOWQpK_ZbXYegXZkT5HPevsmtQ" />
                    </div>
                </div>
            </header>
            <!-- Bento Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                <!-- Upcoming Reservations Section -->
                <section class="md:col-span-12 mt-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold tracking-tight">Upcoming Reservations</h3>
                        <button class="text-sm font-bold text-primary hover:text-primary-fixed transition-colors">View
                            All</button>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        <?php if (!empty($reservations)): ?>
                            <?php foreach ($reservations as $res): ?>
                            <?php 
                            $date = new DateTime($res['date']);
                            $month = $date->format('M');
                            $day = $date->format('d');
                            $statusClass = match($res['status']) {
                                'confirmed' => 'bg-tertiary-container/10 text-tertiary',
                                'pending' => 'bg-primary-container/10 text-primary',
                                'canceled' => 'bg-error-container/10 text-error',
                                default => 'bg-surface-container text-on-surface-variant'
                            };
                            ?>
                            <div
                                class="bg-surface-container-high rounded-xl overflow-hidden flex items-stretch border border-outline-variant/5 <?= (isset($pending_reservation_id) && $pending_reservation_id == $res['id']) ? 'ring-2 ring-primary' : '' ?>">
                                <div class="w-24 bg-primary-container/20 flex flex-col items-center justify-center p-4">
                                    <span class="text-on-primary-container text-xs font-bold uppercase tracking-widest"><?= $month ?></span>
                                    <span class="text-on-primary-container text-3xl font-bold"><?= $day ?></span>
                                </div>
                                <div class="flex-1 p-6 flex flex-col justify-center">
                                    <div class="flex justify-between items-start mb-2">
                                        <h4 class="font-bold text-lg"><?= htmlspecialchars($res['table_name'] ?? 'Table #' . $res['table_id']) ?></h4>
                                        <span class="<?= $statusClass ?> px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider"><?= ucfirst($res['status']) ?></span>
                                    </div>
                                    <div class="flex gap-4 text-sm text-on-surface-variant mb-2">
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">schedule</span> 
                                            <?= date('H:i', strtotime($res['time'])) ?>
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <span class="material-symbols-outlined text-sm">groups</span> 
                                            <?= $res['players_count'] ?? 4 ?> Players
                                        </span>
                                    </div>
                                    <?php if (!empty($res['game_title'])): ?>
                                    <div class="text-sm text-on-surface-variant">
                                        <span class="material-symbols-outlined text-sm align-middle mr-1">casino</span>
                                        <?= htmlspecialchars($res['game_title']) ?>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div class="p-6 flex items-center">
                                    <button
                                        class="w-10 h-10 rounded-full bg-surface-container-highest text-on-surface-variant flex items-center justify-center hover:bg-surface-bright transition-colors">
                                        <span class="material-symbols-outlined">more_vert</span>
                                    </button>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                        <div class="col-span-2 bg-surface-container-high rounded-xl p-8 text-center">
                            <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-4">event_busy</span>
                            <p class="text-on-surface-variant">No reservations yet.</p>
                            <a href="<?= URL_ROOT ?>/booking" class="inline-block mt-4 px-6 py-2 bg-primary text-on-primary rounded-lg font-bold hover:bg-primary-dim transition-colors">
                                Make a Reservation
                            </a>
                        </div>
                        <?php endif; ?>
                    </div>
                </section>
                <!-- Gaming History -->
                <section class="md:col-span-12 mt-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold tracking-tight uppercase italic text-on-surface-variant">Gaming History</h3>
                        <?php if (count($sessionHistory ?? []) > 4): ?>
                        <button class="text-xs font-black uppercase tracking-widest text-primary hover:underline transition-all">View All Sessions</button>
                        <?php endif; ?>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <?php if (empty($sessionHistory)): ?>
                            <div class="col-span-1 sm:col-span-2 lg:col-span-4 bg-surface-container-high rounded-xl p-8 text-center border border-white/5">
                                <span class="material-symbols-outlined text-4xl text-on-surface-variant/30 mb-4">history</span>
                                <p class="text-on-surface-variant">Your playroom story hasn't started yet. Book a table to begin!</p>
                            </div>
                        <?php else: ?>
                            <?php foreach (array_slice($sessionHistory, 0, 4) as $sh): ?>
                            <div class="bg-surface-container-high rounded-2xl overflow-hidden group border border-outline-variant/5 hover:border-primary/20 transition-all duration-300">
                                <div class="h-32 bg-gradient-to-br from-surface-container-highest to-surface-container flex items-center justify-center relative overflow-hidden">
                                    <span class="material-symbols-outlined text-5xl text-on-surface-variant/20 absolute -right-2 -bottom-2 rotate-12" data-icon="casino">casino</span>
                                    <div class="w-16 h-16 rounded-xl bg-background/50 backdrop-blur-md flex items-center justify-center text-primary border border-white/10 z-10">
                                        <span class="material-symbols-outlined text-3xl">sports_esports</span>
                                    </div>
                                    <div class="absolute top-3 left-3 bg-secondary-container/80 backdrop-blur-sm text-on-secondary-container text-[10px] font-black px-2 py-1 rounded-full uppercase tracking-widest">
                                        <?= date('M d', strtotime($sh['start_time'])) ?>
                                    </div>
                                </div>
                                <div class="p-5">
                                    <h5 class="font-black text-on-surface mb-1 truncate uppercase italic"><?= htmlspecialchars($sh['game_title'] ?? 'The Curated Experience') ?></h5>
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase tracking-widest mb-4">
                                        Table <?= htmlspecialchars($sh['table_name'] ?? $sh['table_id']) ?>
                                    </p>
                                    <div class="flex items-center justify-between bg-background/30 rounded-xl p-3 border border-white/5">
                                        <div class="flex flex-col">
                                            <span class="text-[8px] font-black uppercase text-on-surface-variant">Duration</span>
                                            <span class="text-xs font-bold text-on-surface"><?= $sh['duration'] ?> MIN</span>
                                        </div>
                                        <div class="w-px h-6 bg-white/10"></div>
                                        <div class="flex flex-col items-end">
                                            <span class="text-[8px] font-black uppercase text-on-surface-variant">Status</span>
                                            <span class="text-xs font-bold <?= $sh['status'] === 'active' ? 'text-tertiary animate-pulse' : 'text-on-surface-variant' ?>">
                                                <?= strtoupper($sh['status']) ?>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </section>
            </div>
        </main>
        <!-- BottomNavBar (Mobile only) -->
        <nav
            class="lg:hidden fixed bottom-0 left-0 w-full z-50 flex justify-around items-center px-6 pb-6 pt-3 bg-[#131313]/80 backdrop-blur-xl shadow-[0_-8px_32px_rgba(0,0,0,0.5)] rounded-t-[2rem]">
            <!-- Home: Active -->
            <a class="flex flex-col items-center justify-center bg-[#b6a0ff] text-[#0e0e0e] rounded-2xl p-2 h-12 w-12 transition-all active:scale-90"
                href="#">
                <span class="material-symbols-outlined" data-icon="home"
                    style="font-variation-settings: 'FILL' 1;">home</span>
                <span class="text-[10px] font-medium font-['Inter'] mt-0.5">Home</span>
            </a>
            <a class="flex flex-col items-center justify-center text-gray-500 p-2 transition-all active:bg-white/10 active:scale-90"
                href="#">
                <span class="material-symbols-outlined" data-icon="event_seat">event_seat</span>
                <span class="text-[10px] font-medium font-['Inter'] mt-0.5">Book</span>
            </a>
            <a class="flex flex-col items-center justify-center text-gray-500 p-2 transition-all active:bg-white/10 active:scale-90"
                href="#">
                <span class="material-symbols-outlined" data-icon="style">style</span>
                <span class="text-[10px] font-medium font-['Inter'] mt-0.5">Vault</span>
            </a>
            <a class="flex flex-col items-center justify-center text-gray-500 p-2 transition-all active:bg-white/10 active:scale-90"
                href="#">
                <span class="material-symbols-outlined" data-icon="person">person</span>
                <span class="text-[10px] font-medium font-['Inter'] mt-0.5">Profile</span>
            </a>
        </nav>
    </div>
</body>

</html>
