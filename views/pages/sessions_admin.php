<?php
require_once __DIR__ . '/../../config/init.php';
?>
<!DOCTYPE html>
<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Session Management | The Curated Playroom</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= URL_ROOT ?>/public/style/tailwind-config.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= URL_ROOT ?>/public/style/style.css">
    <style>
        .timer-progress {
            transition: width 1s linear;
        }
    </style>
</head>

<body class="bg-background text-on-surface font-body selection:bg-primary selection:text-on-primary">
    <?php include __DIR__ . '/../includes/side_menu.php'; ?>
    <main class="lg:ml-64 admin-main min-h-screen pb-20">
        <header class="sticky top-0 z-40 flex justify-between items-center px-8 py-6 bg-[#0e0e0e]/80 backdrop-blur-md">
            <div class="flex items-center gap-4">
                <button id="menu-toggle" class="lg:hidden text-on-surface-variant flex items-center justify-center p-2 rounded-lg bg-surface-container-low border border-white/5">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h1 class="text-3xl font-extrabold font-headline tracking-tighter text-on-surface">Gaming Sessions</h1>
                    <p class="text-on-surface-variant text-sm font-medium mt-1">Live tracking and history</p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <?php $stats = $data['stats'] ?? ['total' => 0, 'active' => 0, 'today' => 0]; ?>
                <div class="hidden md:flex items-center gap-8">
                    <div class="text-center">
                        <p class="text-[10px] font-black uppercase text-on-surface-variant tracking-widest">Active</p>
                        <p class="text-xl font-bold text-tertiary"><?= $stats['active'] ?></p>
                    </div>
                    <div class="text-center border-l border-white/10 pl-8">
                        <p class="text-[10px] font-black uppercase text-on-surface-variant tracking-widest">Today</p>
                        <p class="text-xl font-bold text-primary"><?= $stats['today'] ?></p>
                    </div>
                    <div class="text-center border-l border-white/10 pl-8">
                        <p class="text-[10px] font-black uppercase text-on-surface-variant tracking-widest">Lifetime</p>
                        <p class="text-xl font-bold text-secondary"><?= $stats['total'] ?></p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Active Sessions Section -->
        <section class="px-8 mt-8">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-tertiary" data-icon="timer">timer</span>
                <h2 class="text-2xl font-extrabold font-headline tracking-tight">Active Sessions</h2>
            </div>

            <?php $activeSessions = $data['activeSessions'] ?? []; ?>
            <?php if (empty($activeSessions)): ?>
                <div class="bg-surface-container rounded-2xl p-12 text-center border border-white/5">
                    <span class="material-symbols-outlined text-6xl text-on-surface-variant/30 mb-4">sports_esports</span>
                    <p class="text-on-surface-variant font-medium text-lg">No guests are currently gaming.</p>
                    <a href="<?= URL_ROOT ?>/reservations" class="inline-flex items-center gap-2 mt-6 text-primary font-bold hover:underline">
                        Start a session from reservations <span class="material-symbols-outlined text-sm">arrow_forward</span>
                    </a>
                </div>
            <?php else: ?>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php foreach ($activeSessions as $session): ?>
                        <div class="session-card bg-surface-container rounded-2xl overflow-hidden border border-white/5 shadow-2xl transition-all hover:scale-[1.01]" 
                             data-start="<?= strtotime($session['start_time']) ?>" 
                             data-duration="<?= $session['duration'] * 60 ?>">
                            <div class="p-6">
                                <div class="flex justify-between items-start mb-6">
                                    <div>
                                        <span class="bg-tertiary/10 text-tertiary text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-full border border-tertiary/20">Live Session</span>
                                        <h3 class="text-xl font-black font-headline mt-3 italic uppercase"><?= htmlspecialchars($session['table_name'] ?? 'Table ' . $session['table_id']) ?></h3>
                                    </div>
                                    <div class="text-right">
                                        <div class="countdown-timer text-3xl font-black font-headline text-tertiary tracking-tighter">--:--</div>
                                        <p class="text-[10px] text-on-surface-variant font-black uppercase tracking-widest">Time Remaining</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4 p-4 bg-background/50 rounded-xl border border-white/5 mb-6">
                                    <div class="w-12 h-12 rounded-lg bg-surface-container-highest flex items-center justify-center text-primary shadow-inner">
                                        <span class="material-symbols-outlined text-2xl">person</span>
                                    </div>
                                    <div class="overflow-hidden">
                                        <p class="text-sm font-black text-on-surface truncate uppercase"><?= htmlspecialchars($session['client_name'] ?? 'Guest') ?></p>
                                        <p class="text-xs text-on-surface-variant font-semibold"><?= $session['players_count'] ?> Players • <?= htmlspecialchars($session['game_title'] ?? 'Custom Game') ?></p>
                                    </div>
                                </div>

                                <div class="relative h-1.5 w-full bg-surface-container-highest rounded-full overflow-hidden">
                                    <div class="timer-progress absolute top-0 left-0 h-full bg-gradient-to-r from-tertiary to-primary rounded-full w-0"></div>
                                </div>
                            </div>
                            
                            <div class="px-6 py-4 bg-surface-container-low border-t border-white/5 flex justify-between items-center">
                                <span class="text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">Check-in <?= date('H:i', strtotime($session['start_time'])) ?></span>
                                <a href="<?= URL_ROOT ?>/sessions/end/<?= $session['id'] ?>" class="flex items-center gap-2 text-xs font-black text-error uppercase tracking-widest hover:bg-error/10 px-3 py-2 rounded-lg transition-colors">
                                    <span class="material-symbols-outlined text-sm">stop_circle</span>
                                    End Session
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>

        <!-- History Section -->
        <section class="px-8 mt-16 mb-20">
            <div class="flex items-center gap-3 mb-6">
                <span class="material-symbols-outlined text-secondary" data-icon="history">history</span>
                <h2 class="text-2xl font-extrabold font-headline tracking-tight">Recent Activity</h2>
            </div>
            
            <?php $allSessions = $data['allSessions'] ?? []; ?>
            <div class="bg-surface-container-low rounded-2xl overflow-hidden border border-white/5">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container text-on-surface-variant text-[10px] uppercase font-black tracking-widest border-b border-white/5">
                                <th class="px-6 py-4 italic">Date</th>
                                <th class="px-6 py-4">Guest</th>
                                <th class="px-6 py-4">Table</th>
                                <th class="px-6 py-4">Game</th>
                                <th class="px-6 py-4">Duration</th>
                                <th class="px-6 py-4">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            <?php foreach ($allSessions as $s): ?>
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-on-surface"><?= date('M d, Y', strtotime($s['start_time'])) ?></span>
                                            <span class="text-[10px] text-on-surface-variant font-medium"><?= date('H:i', strtotime($s['start_time'])) ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm font-semibold text-on-surface uppercase italic"><?= htmlspecialchars($s['client_name'] ?? 'Guest') ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-on-surface-variant font-bold uppercase tracking-tighter"><?= htmlspecialchars($s['table_name'] ?? 'TBD') ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-on-surface font-medium"><?= htmlspecialchars($s['game_title'] ?? '-') ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-xs text-on-surface-variant"><?= $s['duration'] ?> min</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <?php if ($s['status'] === 'active'): ?>
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-tertiary/10 text-tertiary border border-tertiary/20">
                                                <span class="w-1 h-1 bg-tertiary rounded-full animate-pulse"></span> Active
                                            </span>
                                        <?php else: ?>
                                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-white/5 text-on-surface-variant">
                                                Finished
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <script>
        function updateTimers() {
            const now = Math.floor(Date.now() / 1000);
            document.querySelectorAll('.session-card').forEach(card => {
                const start = parseInt(card.dataset.start);
                const totalSeconds = parseInt(card.dataset.duration);
                const elapsed = now - start;
                const remaining = totalSeconds - elapsed;
                
                const timerDisplay = card.querySelector('.countdown-timer');
                const progressDisplay = card.querySelector('.timer-progress');
                
                if (remaining <= 0) {
                    timerDisplay.textContent = "00:00";
                    timerDisplay.classList.remove('text-tertiary');
                    timerDisplay.classList.add('text-error');
                    progressDisplay.style.width = "100%";
                    progressDisplay.classList.remove('from-tertiary');
                    progressDisplay.classList.add('from-error');
                } else {
                    const mins = Math.floor(remaining / 60);
                    const secs = remaining % 60;
                    timerDisplay.textContent = 
                        String(mins).padStart(2, '0') + ":" + 
                        String(secs).padStart(2, '0');
                    
                    const percent = Math.min(100, (elapsed / totalSeconds) * 100);
                    progressDisplay.style.width = percent + "%";
                }
            });
        }

        setInterval(updateTimers, 1000);
        updateTimers();

        // Responsive Sidebar Toggle
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.admin-sidebar');
        if (menuToggle && sidebar) {
            menuToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    </script>
</body>
</html>
