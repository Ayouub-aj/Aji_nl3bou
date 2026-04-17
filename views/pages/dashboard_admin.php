<?php
require_once __DIR__ . '/../../config/init.php';
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Portal | The Curated Playroom</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="/dashboard/Aji_nl3bou/public/style/tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="/dashboard/Aji_nl3bou/public/style/style.css">
</head>

<body class="bg-background text-on-surface font-body selection:bg-primary selection:text-on-primary">
    <?php include __DIR__ . '/../includes/side_menu.php'; ?>
    <main class="lg:ml-64 admin-main min-h-screen pb-20">
        <header class="sticky top-0 z-40 flex justify-between items-center px-8 py-6 bg-[#0e0e0e]/80 backdrop-blur-md">
            <div class="flex items-center gap-4">
                <button id="menu-toggle"
                    class="lg:hidden text-on-surface-variant flex items-center justify-center p-2 rounded-lg bg-surface-container-low border border-white/5">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h1 class="text-3xl font-extrabold font-headline tracking-tighter text-on-surface">Overview</h1>
                    <p class="text-on-surface-variant text-sm font-medium mt-1"><?php echo date("l, F j, Y"); ?></p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="relative">
                    <span
                        class="material-symbols-outlined text-on-surface-variant text-2xl hover:text-primary transition-colors cursor-pointer"
                        data-icon="notifications">notifications</span>
                    <span
                        class="absolute top-0 right-0 w-2 h-2 bg-secondary rounded-full border-2 border-background"></span>
                </div>
                <div
                    class="flex items-center gap-3 bg-surface-container-low rounded-full px-4 py-2 border border-white/5">
                    <div class="w-2 h-2 bg-tertiary rounded-full shadow-[0_0_8px_rgba(181,255,194,0.6)]"></div>
                    <span class="text-xs font-bold text-on-surface uppercase tracking-widest">System Live</span>
                </div>
            </div>
        </header>
        <section class="px-8 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-surface-container-high rounded-xl p-6 border-l-4 border-primary">
                    <p class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1">Active Sessions
                    </p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black font-headline"><?php echo $data['activeSessions'] ?? 0; ?></span>
                        <span class="text-tertiary text-xs font-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm" data-icon="trending_up">trending_up</span>
                            Live
                        </span>
                    </div>
                </div>
                <div class="bg-surface-container-high rounded-xl p-6 border-l-4 border-secondary">
                    <p class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1">Pending
                        Reservations</p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black font-headline"><?php echo $data['pendingCount'] ?? 0; ?></span>
                        <span class="text-secondary text-xs font-bold">Awaiting</span>
                    </div>
                </div>
                <div class="bg-surface-container-high rounded-xl p-6 border-l-4 border-tertiary">
                    <p class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1">Today's Reservations
                    </p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black font-headline"><?php echo $data['totalToday'] ?? 0; ?><span
                                class="text-lg text-gray-600 font-medium">/<?php echo $data['totalTables'] ?? 0; ?></span></span>
                        <span class="text-on-surface-variant text-xs font-bold">Tables</span>
                    </div>
                </div>
                <div class="bg-surface-container-high rounded-xl p-6 border-l-4 border-primary-dim">
                    <p class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1">Total Games
                    </p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black font-headline"><?php echo $data['totalGames'] ?? 0; ?></span>
                        <span class="text-on-surface-variant text-xs font-bold"><?php echo $data['availableGames'] ?? 0; ?> Available</span>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-8 mt-12">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="bolt">bolt</span>
                    <h2 class="text-2xl font-extrabold font-headline tracking-tight">Live Sessions</h2>
                </div>
                <a href="/dashboard/Aji_nl3bou/tables" class="text-sm font-bold text-primary hover:underline transition-all">View All Tables</a>
            </div>
            <?php $activeSessions = $data['activeSessionsList'] ?? []; ?>
            <?php if (empty($activeSessions)): ?>
            <div class="bg-surface-container rounded-xl p-8 text-center">
                <span class="material-symbols-outlined text-4xl text-on-surface-variant mb-4">sports_esports</span>
                <p class="text-on-surface-variant">No active sessions at the moment.</p>
            </div>
            <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <?php foreach ($activeSessions as $session): ?>
                <?php
                    $startTime = strtotime($session['start_time']);
                    $elapsed = time() - $startTime;
                    $minutes = floor($elapsed / 60);
                    $seconds = $elapsed % 60;
                    $elapsedStr = sprintf('%02d:%02d', $minutes, $seconds);
                ?>
                <div class="group relative bg-surface-container rounded-xl overflow-hidden shadow-xl hover:shadow-secondary/5 transition-all">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span class="bg-secondary/20 text-secondary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded">Active</span>
                                <h3 class="text-xl font-bold font-headline mt-2 uppercase"><?php echo htmlspecialchars($session['table_name'] ?? 'Table'); ?></h3>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black text-secondary-fixed-dim"><?php echo $elapsedStr; ?></p>
                                <p class="text-[10px] text-on-surface-variant font-bold uppercase">Time Elapsed</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mb-6">
                            <?php if (!empty($session['game_title'])): ?>
                            <div class="w-16 h-16 rounded-lg bg-surface-container-highest flex items-center justify-center">
                                <span class="material-symbols-outlined text-primary">sports_esports</span>
                            </div>
                            <div>
                                <p class="font-bold text-on-surface"><?php echo htmlspecialchars($session['game_title']); ?></p>
                                <p class="text-xs text-on-surface-variant"><?php echo $session['players_count']; ?> Players</p>
                            </div>
                            <?php else: ?>
                            <div class="w-16 h-16 rounded-lg bg-surface-container-highest flex items-center justify-center">
                                <span class="material-symbols-outlined text-on-surface-variant">group</span>
                            </div>
                            <div>
                                <p class="font-bold text-on-surface"><?php echo htmlspecialchars($session['client_name'] ?? 'Walk-in'); ?></p>
                                <p class="text-xs text-on-surface-variant"><?php echo $session['players_count']; ?> Players</p>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="bg-surface-container-low px-6 py-4 flex justify-between items-center">
                        <span class="text-xs text-on-surface-variant">Started <?php echo date('H:i', $startTime); ?></span>
                        <a href="/dashboard/Aji_nl3bou/sessions/end/<?php echo $session['id']; ?>" class="text-sm font-bold text-error hover:underline">End Session</a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </section>
        <section class="px-8 mt-12 mb-12">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary"
                        data-icon="calendar_month">calendar_month</span>
                    <h2 class="text-2xl font-extrabold font-headline tracking-tight">Recent Reservations</h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-on-surface-variant">Filter by:</span>
                    <select
                        class="bg-surface-container-highest border-none text-xs font-bold rounded-lg py-1 pl-3 pr-8 focus:ring-1 focus:ring-primary">
                        <option>Today</option>
                        <option>Tomorrow</option>
                    </select>
                </div>
            </div>
            <div class="bg-surface-container rounded-xl overflow-hidden shadow-2xl">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low border-b border-white/5">
                        <tr>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Time</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Guest Name</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Size</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Game Request</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Status</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 font-bold text-secondary">20:30</td>
                            <td class="px-6 py-4 font-semibold text-on-surface">The Miller Family</td>
                            <td class="px-6 py-4 text-on-surface-variant">5 People</td>
                            <td class="px-6 py-4"><span class="text-on-surface">Sushi Go! Party</span></td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-secondary/10 text-secondary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-full">Pending</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="p-1.5 rounded-lg border border-white/10 hover:bg-white/10 transition-colors">
                                        <span class="material-symbols-outlined text-sm text-error"
                                            data-icon="close">close</span>
                                    </button>
                                    <button
                                        class="bg-tertiary text-on-tertiary text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg hover:brightness-110 transition-all">Confirm</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
