<?php
require_once __DIR__ . '/../../config/init.php';

// Set defaults
$selectedGame = $selectedGame ?? null;
$games = $games ?? [];
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>The Curated Playroom | Make a Reservation</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script src="<?= URLROOT; ?>/public/style/tailwind-config.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="<?= URLROOT; ?>/public/style/style.css">
</head>

<body class="bg-surface text-on-surface selection:bg-primary/30">
  <?php include __DIR__ . '/../includes/header.php'; ?>
  <main class="relative min-h-screen">
    <section class="relative w-full h-[400px] flex items-end overflow-hidden">
      <div class="absolute inset-0 z-0">
        <?php if ($selectedGame && !empty($selectedGame['image_url'])): ?>
        <img alt="<?= htmlspecialchars($selectedGame['title']) ?>" class="w-full h-full object-cover brightness-[0.4]"
          src="<?= htmlspecialchars($selectedGame['image_url']) ?>" />
        <?php else: ?>
        <img alt="Board game cafe" class="w-full h-full object-cover brightness-[0.4]"
          src="https://images.unsplash.com/photo-1610890716171-6b1c9f2cd9be?w=1920&q=80" />
        <?php endif; ?>
        <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/60 to-transparent"></div>
      </div>
      <div class="relative z-10 w-full max-w-7xl mx-auto px-8 pb-16">
        <div class="flex flex-col gap-4">
          <div class="flex gap-2">
            <?php if ($selectedGame): ?>
            <span class="px-3 py-1 bg-primary-container text-on-primary-container rounded-full text-xs font-bold tracking-widest uppercase"><?= htmlspecialchars($selectedGame['category'] ?? 'Game') ?></span>
            <?php else: ?>
            <span class="px-3 py-1 bg-primary-container text-on-primary-container rounded-full text-xs font-bold tracking-widest uppercase">Reservation</span>
            <?php endif; ?>
          </div>
          <h1 class="text-5xl md:text-7xl font-black tracking-tighter text-on-surface"><?= $selectedGame ? htmlspecialchars($selectedGame['title']) : 'Book Your Table' ?></h1>
          <?php if ($selectedGame): ?>
          <div class="flex items-center gap-6 text-on-surface-variant font-medium">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">groups</span>
              <span><?= $selectedGame['min_players'] ?> - <?= $selectedGame['max_players'] ?> Players</span>
            </div>
            <span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span>
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary">schedule</span>
              <span><?= $selectedGame['duration'] ?> minutes</span>
            </div>
          </div>
          <?php else: ?>
          <p class="text-on-surface-variant">Select a game and time to reserve your table</p>
          <?php endif; ?>
        </div>
      </div>
    </section>
    <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 -mt-10 relative z-20 pb-24">
      <div class="lg:col-span-7 flex flex-col gap-10">
        <?php if ($selectedGame): ?>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="bg-surface-container-high p-6 rounded-xl flex flex-col gap-2">
            <span class="material-symbols-outlined text-primary mb-2">speed</span>
            <span class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">Difficulty</span>
            <span class="text-xl font-bold"><?= htmlspecialchars($selectedGame['difficulty'] ?? 'Moyen') ?></span>
          </div>
          <div class="bg-surface-container-high p-6 rounded-xl flex flex-col gap-2">
            <span class="material-symbols-outlined text-secondary mb-2">schedule</span>
            <span class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">Duration</span>
            <span class="text-xl font-bold"><?= $selectedGame['duration'] ?>m</span>
          </div>
          <div class="bg-surface-container-high p-6 rounded-xl flex flex-col gap-2">
            <span class="material-symbols-outlined text-primary mb-2">groups</span>
            <span class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">Players</span>
            <span class="text-xl font-bold"><?= $selectedGame['min_players'] ?>-<?= $selectedGame['max_players'] ?></span>
          </div>
          <div class="bg-surface-container-high p-6 rounded-xl flex flex-col gap-2">
            <span class="material-symbols-outlined text-tertiary mb-2">category</span>
            <span class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">Category</span>
            <span class="text-xl font-bold"><?= htmlspecialchars($selectedGame['category'] ?? 'Game') ?></span>
          </div>
        </div>
        <?php endif; ?>
        </div>
        <div class="flex flex-col gap-6">
          <h2 class="text-3xl font-bold tracking-tight">The Mechanics</h2>
          <div class="text-on-surface-variant leading-relaxed font-body flex flex-col gap-4">
            <p></p>
          </div>
          <div class="flex flex-wrap gap-3 mt-4">
            <span class="px-4 py-2 bg-surface-container-highest text-on-surface-variant rounded-lg text-sm">Territory
              Building</span>
            <span class="px-4 py-2 bg-surface-container-highest text-on-surface-variant rounded-lg text-sm">Resource
              Management</span>
            <span
              class="px-4 py-2 bg-surface-container-highest text-on-surface-variant rounded-lg text-sm">Dieselpunk</span>
            <span
              class="px-4 py-2 bg-surface-container-highest text-on-surface-variant rounded-lg text-sm">Miniatures</span>
          </div>
        </div>
      </div>
      <div class="lg:col-span-5">
        <form action="<?= URLROOT; ?>/booking" method="POST"
          class="sticky top-28 glass-panel border border-outline-variant/15 p-8 rounded-2xl shadow-2xl flex flex-col gap-8">
          <input type="hidden" name="csrf_token" value="<?php echo \App\Core\Security::generateCSRFToken(); ?>">
          <?php if ($selectedGame): ?>
          <input type="hidden" name="game_id" value="<?= $selectedGame['id'] ?>">
          <?php endif; ?>
          <div class="flex flex-col gap-2">
            <h3 class="text-2xl font-bold">Reserve Your Table</h3>
            <p class="text-on-surface-variant text-sm">Fill in your details to book.</p>
          </div>
          <div class="space-y-6">
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1"
                for="client_name">Your Name</label>
              <div class="relative">
                <input
                  class="w-full bg-surface-container-highest border-0 rounded-xl px-4 py-4 text-on-surface focus:ring-2 focus:ring-primary outline-none transition-all"
                  id="client_name" name="client_name" placeholder="Your name" required="" type="text" />
                <span
                  class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined pointer-events-none opacity-40">person</span>
              </div>
            </div>
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1"
                for="client_phone">Phone Number</label>
              <div class="relative">
                <input
                  class="w-full bg-surface-container-highest border-0 rounded-xl px-4 py-4 text-on-surface focus:ring-2 focus:ring-primary outline-none transition-all"
                  id="client_phone" name="client_phone" placeholder="+212 6XX-XXXXXX" required="" type="tel" />
                <span
                  class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined pointer-events-none opacity-40">call</span>
              </div>
            </div>
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="date">Select
                Date</label>
              <div class="relative">
                <input
                  class="w-full bg-surface-container-highest border-0 rounded-xl px-4 py-4 text-on-surface focus:ring-2 focus:ring-primary outline-none transition-all cursor-pointer"
                  id="date" name="date" required="" type="date" value="2024-11-20" />
                <span
                  class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined pointer-events-none opacity-40">calendar_today</span>
              </div>
            </div>
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Table
                Capacity</label>
              <div class="grid grid-cols-4 gap-2">
                <input class="hidden" id="players_count" name="players_count" type="hidden" value="4" />
                <button
                  class="capacity-btn py-3 bg-surface-container-highest text-on-surface rounded-xl hover:bg-surface-container-high transition-colors active:scale-95"
                  data-value="2" type="button">2</button>
                <button
                  class="capacity-btn py-3 bg-primary-container text-on-primary-container font-bold rounded-xl active:scale-95"
                  data-value="4" type="button">4</button>
                <button
                  class="capacity-btn py-3 bg-surface-container-highest text-on-surface rounded-xl hover:bg-surface-container-high transition-colors active:scale-95"
                  data-value="6" type="button">6</button>
                <button
                  class="capacity-btn py-3 bg-surface-container-highest text-on-surface rounded-xl hover:bg-surface-container-high transition-colors active:scale-95"
                  data-value="8" type="button">8+</button>
              </div>
            </div>
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Available
                Slots</label>
              <input class="hidden" id="time" name="time" type="hidden" value="19:30" />
              <div class="grid grid-cols-2 gap-3">
                <button
                  class="time-btn flex flex-col items-center justify-center py-4 bg-surface-container-highest rounded-xl hover:ring-2 hover:ring-primary/40 transition-all active:scale-95"
                  data-value="18:00" type="button">
                  <span class="font-bold">18:00</span>
                  <span class="text-[10px] text-tertiary uppercase font-bold tracking-tighter">Limited Slots</span>
                </button>
                <button
                  class="time-btn ring-2 ring-primary flex flex-col items-center justify-center py-4 bg-surface-container-highest rounded-xl transition-all active:scale-95"
                  data-value="19:30" type="button">
                  <span class="font-bold">19:30</span>
                  <span
                    class="text-[10px] text-on-surface-variant uppercase font-bold tracking-tighter">Available</span>
                </button>
                <button
                  class="time-btn flex flex-col items-center justify-center py-4 bg-surface-container-highest rounded-xl hover:ring-2 hover:ring-primary/40 transition-all active:scale-95"
                  data-value="21:00" type="button">
                  <span class="font-bold">21:00</span>
                  <span
                    class="text-[10px] text-on-surface-variant uppercase font-bold tracking-tighter">Available</span>
                </button>
                <button
                  class="flex flex-col items-center justify-center py-4 bg-surface-container-highest rounded-xl opacity-40 cursor-not-allowed"
                  disabled="" type="button">
                  <span class="font-bold">22:30</span>
                  <span class="text-[10px] text-error uppercase font-bold tracking-tighter">Fully Booked</span>
                </button>
              </div>
            </div>
          </div>
          <div class="pt-4 border-t border-outline-variant/15 flex flex-col gap-4">
            <div class="flex justify-between items-center text-sm">
              <span class="text-on-surface-variant">Reservation Fee</span>
              <span class="font-bold">$12.00</span>
            </div>
            <button
              class="w-full bg-gradient-to-b from-[#b6a0ff] to-[#7e51ff] text-[#340090] font-black py-5 rounded-xl shadow-[0_0_20px_rgba(182,160,255,0.3)] hover:shadow-[0_0_30px_rgba(182,160,255,0.5)] transition-all active:scale-[0.98]"
              type="submit">
              Confirm Reservation
            </button>
            <p class="text-[10px] text-center text-on-surface-variant uppercase tracking-[0.2em]">Cancellable up to 24h
              prior</p>
          </div>
        </form>
      </div>
    </div>
  </main>
  <footer class="w-full py-12 border-t border-[#b6a0ff]/10 bg-[#0e0e0e] dark:bg-[#0e0e0e]">
    <div class="flex flex-col items-center justify-center gap-6 w-full max-w-7xl mx-auto px-8">
      <div class="text-lg font-bold text-[#b6a0ff] font-['Inter']">The Curated Playroom</div>
      <div class="flex gap-8">
        <a class="text-gray-500 font-['Inter'] text-sm hover:text-white transition-colors" href="#">Terms</a>
        <a class="text-gray-500 font-['Inter'] text-sm hover:text-white transition-colors" href="#">Privacy</a>
        <a class="text-gray-500 font-['Inter'] text-sm hover:text-white transition-colors" href="#">Careers</a>
        <a class="text-gray-500 font-['Inter'] text-sm hover:text-white transition-colors" href="#">Contact</a>
      </div>
      <div class="text-gray-500 font-['Inter'] text-xs">© 2024 The Curated Playroom. Roll with intention.</div>
    </div>
  </footer>
</body>

</html>
