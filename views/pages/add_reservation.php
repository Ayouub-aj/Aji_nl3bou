<?php
require_once __DIR__ . '/../../config/init.php';

$tables = $data['tables'] ?? [];
$games = $data['games'] ?? [];
$error = $data['error'] ?? '';
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Aji L3bo Café | New Reservation</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= URL_ROOT ?>/public/style/tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="<?= URL_ROOT ?>/public/style/style.css">
</head>

<body class="bg-surface text-on-surface font-body selection:bg-primary selection:text-on-primary min-h-screen flex">
    <?php include __DIR__ . '/../includes/side_menu.php'; ?>
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
                            New <span class="text-primary italic">Reservation.</span>
                        </h1>
                    </div>
                </div>
                <a href="<?= URL_ROOT ?>/reservations" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-surface-container-low hover:bg-surface-container-high transition-all text-sm">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Back to Reservations
                </a>
            </header>

            <?php if ($error): ?>
            <div class="mb-6 p-4 rounded-lg bg-error/20 border border-error/50 text-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <div class="lg:col-span-8 space-y-8">
                    <form class="space-y-10" method="POST" action="<?= URL_ROOT ?>/reservations/add">
                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <h3 class="text-secondary font-headline font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">person</span>
                                01. Client Information
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Client Name</label>
                                    <input class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg p-4 text-white font-medium outline-none transition-all"
                                        name="client_name" type="text" placeholder="John Doe" required />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Phone Number</label>
                                    <input class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg p-4 text-white font-medium outline-none transition-all"
                                        name="client_phone" type="tel" placeholder="+123 456 7890" required />
                                </div>
                            </div>
                        </section>

                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <h3 class="text-secondary font-headline font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">calendar_month</span>
                                02. Date &amp; Time
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Select Date</label>
                                    <input class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg p-4 text-white font-medium outline-none transition-all"
                                        name="date" type="date" required min="<?php echo date('Y-m-d'); ?>" />
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Number of Players</label>
                                    <input class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg p-4 text-white font-medium outline-none transition-all"
                                        name="players_count" type="number" min="1" max="20" value="4" required />
                                </div>
                            </div>
                        </section>

                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <h3 class="text-secondary font-headline font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">schedule</span>
                                03. Pick a Time Slot
                            </h3>
                            <input type="hidden" name="time" id="selected_time" value="" required />
                            <div class="grid grid-cols-3 md:grid-cols-4 gap-3">
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="10:00">10:00 AM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="12:30">12:30 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-primary text-on-primary text-sm font-bold shadow-[0_0_15px_rgba(182,160,255,0.4)]" data-time="14:00">02:00 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="16:30">04:30 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="18:00">06:00 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="20:30">08:30 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="22:30">10:30 PM</button>
                            </div>
                        </section>

                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <h3 class="text-secondary font-headline font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">table_restaurant</span>
                                04. Select Table
                            </h3>
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Table</label>
                                <select class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg p-4 text-white font-medium outline-none transition-all"
                                    name="table_id" required>
                                    <option value="">Select a table...</option>
                                    <?php foreach ($tables as $table): ?>
                                    <option value="<?php echo $table['id']; ?>">
                                        <?php echo htmlspecialchars($table['name']); ?> (Capacity: <?php echo $table['capacity']; ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </section>

                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <h3 class="text-secondary font-headline font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">sports_esports</span>
                                05. Game (Optional)
                            </h3>
                            <div class="space-y-2">
                                <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Select Game</label>
                                <select class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg p-4 text-white font-medium outline-none transition-all"
                                    name="game_id">
                                    <option value="">No specific game</option>
                                    <?php foreach ($games as $game): ?>
                                    <option value="<?php echo $game['id']; ?>">
                                        <?php echo htmlspecialchars($game['title']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </section>

                        <button class="w-full bg-gradient-to-b from-primary to-primary-dim text-on-primary py-5 rounded-xl font-headline font-extrabold text-xl shadow-2xl hover:scale-[1.02] active:scale-95 transition-all flex items-center justify-center gap-3"
                            type="submit">
                            Create Reservation
                            <span class="material-symbols-outlined" data-icon="arrow_forward">arrow_forward</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timeSlots = document.querySelectorAll('.time-slot');
            const selectedTimeInput = document.getElementById('selected_time');
            
            timeSlots.forEach(button => {
                button.addEventListener('click', function() {
                    if (this.disabled) return;
                    timeSlots.forEach(btn => {
                        btn.classList.remove('bg-primary', 'text-on-primary', 'shadow-[0_0_15px_rgba(182,160,255,0.4)]');
                        btn.classList.add('bg-surface-container-highest');
                    });
                    this.classList.remove('bg-surface-container-highest');
                    this.classList.add('bg-primary', 'text-on-primary', 'shadow-[0_0_15px_rgba(182,160,255,0.4)]');
                    selectedTimeInput.value = this.getAttribute('data-time');
                });
            });
        });
    </script>
</body>

</html>
