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
                <!-- Recently Played - Horizontal Scrollable Area -->
                <section class="md:col-span-12 mt-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold tracking-tight">Recently Played</h3>
                        <div class="flex gap-2">
                            <button
                                class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:bg-surface-bright"><span
                                    class="material-symbols-outlined text-sm"
                                    data-icon="chevron_left">chevron_left</span></button>
                            <button
                                class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant hover:bg-surface-bright"><span
                                    class="material-symbols-outlined text-sm"
                                    data-icon="chevron_right">chevron_right</span></button>
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                        <!-- Game Card 1 -->
                        <div
                            class="bg-surface-container-high rounded-lg overflow-hidden group border border-outline-variant/10">
                            <div class="h-48 overflow-hidden relative">
                                <img alt="Board game box art"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    data-alt="top-down artistic macro shot of colorful wooden game pieces and miniature characters from a fantasy board game"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDoQuRPG_pUxA7J5jS-AUft0FQYG6_hzK6sT5b3fyW2pPwYRjXWV8MAQ_nIWKUzJS_Nj071Ol770I_Vqikd38JjRaEWwXkZ2fWunDxNGNMDo4C44ckPCchyaCqYHkHwHs-pImM4i4cAwqzVNfZU65inOWl0FiUoMvGlvds3UHyOjVkBbdGrWYplt9cUetRP5IUzi-igzvqp2Iy-QiU4wHXINfw60iy2GNIHnSVFNLfeu4wKOxB5Bt3GeH7eJP1DH9v33R6F3kzTx7w" />
                                <div
                                    class="absolute top-3 left-3 bg-primary-container text-on-primary-container text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-tighter">
                                    Strategy</div>
                            </div>
                            <div class="p-5">
                                <h5 class="font-bold text-base mb-1">Terraforming Mars</h5>
                                <p class="text-on-surface-variant text-xs mb-4">Played 2 days ago</p>
                                <div class="flex items-center justify-between bg-surface-container-low rounded-lg p-2">
                                    <div
                                        class="flex items-center gap-1 text-[10px] font-medium text-on-surface-variant">
                                        <span class="material-symbols-outlined text-xs" data-icon="timer">timer</span>
                                        120m
                                    </div>
                                    <div
                                        class="flex items-center gap-1 text-[10px] font-medium text-on-surface-variant">
                                        <span class="material-symbols-outlined text-xs" data-icon="person">person</span>
                                        1-5
                                    </div>
                                    <button class="text-primary hover:text-primary-fixed">
                                        <span class="material-symbols-outlined text-sm"
                                            data-icon="favorite">favorite</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Game Card 2 -->
                        <div
                            class="bg-surface-container-high rounded-lg overflow-hidden group border border-outline-variant/10">
                            <div class="h-48 overflow-hidden relative">
                                <img alt="Board game box art"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    data-alt="artistic bokeh shot of colorful glass gaming tokens and abstract game board textures with moody lighting"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCWBxlotyKhzIDHwfrXUzlwrxocFccSyZ7uvucHeW6UT44RkNNaN2aH9ZGFHgcwMXK4vnPUkfNiQj0ZMuhW4Z-mqjbrpdJRto0jbmm8ws3Zwuq6zLnNdyXwyL0PZVQHXHw8Y71reCIRhTUWN-hxbPfZ-knU3gwMTJhBDUFqcuIis4g7JA4Exz393_iGcO0OgAKwGqjdunER5pYSGHOHqg0KCAfAXyOrN3-YVLEESebghtThuUXLMXhWgbEQYiYO1HGgccmmpnxWITM" />
                                <div
                                    class="absolute top-3 left-3 bg-secondary-container text-on-secondary-container text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-tighter">
                                    Family</div>
                            </div>
                            <div class="p-5">
                                <h5 class="font-bold text-base mb-1">Wingspan</h5>
                                <p class="text-on-surface-variant text-xs mb-4">Played 5 days ago</p>
                                <div class="flex items-center justify-between bg-surface-container-low rounded-lg p-2">
                                    <div
                                        class="flex items-center gap-1 text-[10px] font-medium text-on-surface-variant">
                                        <span class="material-symbols-outlined text-xs" data-icon="timer">timer</span>
                                        70m
                                    </div>
                                    <div
                                        class="flex items-center gap-1 text-[10px] font-medium text-on-surface-variant">
                                        <span class="material-symbols-outlined text-xs" data-icon="person">person</span>
                                        1-5
                                    </div>
                                    <button class="text-primary hover:text-primary-fixed">
                                        <span class="material-symbols-outlined text-sm" data-icon="favorite"
                                            style="font-variation-settings: 'FILL' 1;">favorite</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Game Card 3 -->
                        <div
                            class="bg-surface-container-high rounded-lg overflow-hidden group border border-outline-variant/10">
                            <div class="h-48 overflow-hidden relative">
                                <img alt="Board game box art"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    data-alt="close-up of elegant wooden board game tiles with engraved symbols under soft focus warm lighting"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAWgWvKyabrdS3rUIQRKptQ5Z6RFDbzhQFzCRtNvNcKfs8aeakh8hRjiWK09bQd-QkzAUb97CFanLyKUOnlcyEMGTiOsaRvMCsd6Wbk4YQbbiFLDCS8eI7-GkHXt1yZnpfidtmFn9awMGUVyvxR9AjSnOEwRTwDHdv-YGy3jWl56pglTwxo06lyrSuQzPjcoaHMW_qZunCLhlR2swjjRnypgBw6QYG2EjqKAC1F4YaIpmv4_Ictftjr9Yc34tLaKQorqr4vvYrrMvE" />
                                <div
                                    class="absolute top-3 left-3 bg-primary-container text-on-primary-container text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-tighter">
                                    Strategy</div>
                            </div>
                            <div class="p-5">
                                <h5 class="font-bold text-base mb-1">Root</h5>
                                <p class="text-on-surface-variant text-xs mb-4">Played last week</p>
                                <div class="flex items-center justify-between bg-surface-container-low rounded-lg p-2">
                                    <div
                                        class="flex items-center gap-1 text-[10px] font-medium text-on-surface-variant">
                                        <span class="material-symbols-outlined text-xs" data-icon="timer">timer</span>
                                        90m
                                    </div>
                                    <div
                                        class="flex items-center gap-1 text-[10px] font-medium text-on-surface-variant">
                                        <span class="material-symbols-outlined text-xs" data-icon="person">person</span>
                                        2-4
                                    </div>
                                    <button class="text-primary hover:text-primary-fixed">
                                        <span class="material-symbols-outlined text-sm"
                                            data-icon="favorite">favorite</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- Game Card 4 -->
                        <div
                            class="bg-surface-container-high rounded-lg overflow-hidden group border border-outline-variant/10">
                            <div class="h-48 overflow-hidden relative">
                                <img alt="Board game box art"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    data-alt="atmospheric shot of detailed miniature figurines on a complex fantasy game board with misty background effects"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDbtFYuTwHPnkyovU4PpVtN8DJ9TaWaVWU7JUv74FWdo83go3URyK5UeVdqdCLF53i6nz44E4ZW9bxJztwAXry-noCHX-Pv6sJPHES3nxDs2M6adTDJEzAGL8EYcGBiKT2syhCQyRzJHKQ-IcpMG0RMInCCjc6MDjypduLfvNAyWhqPd2Ft-Nph1jXEgYbtthuuiBi8zwOlgl5j0Uf6KGiSrAMIT3UZp4xRbQtTVwdM2JjKd9xC0Lp8Ddmtt5Ex8pzykx267JN_MxQ" />
                                <div
                                    class="absolute top-3 left-3 bg-primary-container text-on-primary-container text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-tighter">
                                    Strategy</div>
                            </div>
                            <div class="p-5">
                                <h5 class="font-bold text-base mb-1">Scythe</h5>
                                <p class="text-on-surface-variant text-xs mb-4">Played 2 weeks ago</p>
                                <div class="flex items-center justify-between bg-surface-container-low rounded-lg p-2">
                                    <div
                                        class="flex items-center gap-1 text-[10px] font-medium text-on-surface-variant">
                                        <span class="material-symbols-outlined text-xs" data-icon="timer">timer</span>
                                        115m
                                    </div>
                                    <div
                                        class="flex items-center gap-1 text-[10px] font-medium text-on-surface-variant">
                                        <span class="material-symbols-outlined text-xs" data-icon="person">person</span>
                                        1-5
                                    </div>
                                    <button class="text-primary hover:text-primary-fixed">
                                        <span class="material-symbols-outlined text-sm"
                                            data-icon="favorite">favorite</span>
                                    </button>
                                </div>
                            </div>
                        </div>
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
