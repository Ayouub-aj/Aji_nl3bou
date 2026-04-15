<?php require_once __DIR__ . '/../../app/core/Security.php'; ?>
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
                    <form class="space-y-10" method="POST" action="add_reservation.php">
                        <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">
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
                                        name="date" type="date" required />
                                </div>
                                <div class="space-y-2">
                                    <label
                                        class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Number
                                        of Players</label>
                                    <input
                                        class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg p-4 text-white font-medium outline-none transition-all"
                                        name="players_count" type="number" min="1" max="20" value="4" required />
                                </div>
                            </div>
                        </section>
                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <h3
                                class="text-secondary font-headline font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm" data-icon="schedule">schedule</span>
                                02. Pick a Time Slot
                            </h3>
                            <input type="hidden" name="time" id="selected_time" value="" required />
                            <div class="grid grid-cols-3 md:grid-cols-4 gap-3">
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="10:00:00">10:00 AM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="12:30:00">12:30 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-primary text-on-primary text-sm font-bold shadow-[0_0_15px_rgba(182,160,255,0.4)]" data-time="14:00:00">02:00 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="16:30:00">04:30 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="18:00:00">06:00 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="20:30:00">08:30 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent opacity-40 cursor-not-allowed" disabled>10:00 PM</button>
                                <button type="button" class="time-slot p-3 rounded-lg bg-surface-container-highest text-sm font-medium border-2 border-transparent hover:border-primary/50 transition-all" data-time="23:30:00">11:30 PM</button>
                            </div>
                        </section>
                        <section class="bg-surface-container-low p-8 rounded-xl">
                            <h3
                                class="text-secondary font-headline font-bold text-sm uppercase tracking-widest mb-6 flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm" data-icon="phone">phone</span>
                                04. Contact Information
                            </h3>
                            <div class="space-y-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-semibold text-on-surface-variant uppercase tracking-wider">Phone Number</label>
                                    <input
                                        class="w-full bg-surface-container-highest border-0 focus:ring-2 focus:ring-primary rounded-lg p-4 text-white font-medium outline-none transition-all"
                                        name="client_phone" type="tel" placeholder="+33 6 12 34 56 78" required pattern="[0-9+\s\-()]{8,20}" />
                                </div>
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