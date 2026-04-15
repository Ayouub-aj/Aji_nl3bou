<?php require_once __DIR__ . '/../../app/core/Security.php'; ?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>The Curated Playroom | Game Details</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script src="../style/tailwind-config.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="../style/style.css">
  <script src="../style/main.js" defer></script>
</head>

<body class="bg-background text-on-background selection:bg-primary/30">
  <?php include '../includes/header.php'; ?>
  <main class="relative min-h-screen">
    <section class="relative w-full h-[614px] flex items-end overflow-hidden">
      <div class="absolute inset-0 z-0">
        <img alt="Scythe board game cinematic artwork" class="w-full h-full object-cover brightness-[0.4]"
          data-alt="Dramatic close-up of Scythe board game components with high-contrast cinematic lighting and heavy dieselpunk atmosphere"
          src="https://lh3.googleusercontent.com/aida-public/AB6AXuC0RwsTYVgBCnGkzBjCwKQrHWSOzJVRrsPN5LByg8qO5p6B7ZEbx5ZoK9LS-M8QZmuAj17JQqj2iDD_76Wy-FSKuf9kim-UfEa-pmTmCme2bjhhDxHScnnq3cq8WMCVm6naPJbuxVmfeoJTprT4fvNRMCJlwU28wmT5R2IwITLVznsbzdxcr5j4ElMrXRcayYfjwJ6ggUKsBJxgfP8gdi7n4jqz-zTXf7szWjaV-l_SFhTg-JJWrEKIzel-VaPdCpW_7L3PoBtsQ58" />
        <div class="absolute inset-0 bg-gradient-to-t from-background via-background/20 to-transparent"></div>
      </div>
      <div class="relative z-10 w-full max-w-7xl mx-auto px-8 pb-16">
        <div class="flex flex-col gap-4">
          <div class="flex gap-2">
            <span
              class="px-3 py-1 bg-primary-container text-on-primary-container rounded-full text-xs font-bold tracking-widest uppercase">Strategy</span>
            <span
              class="px-3 py-1 bg-secondary-container text-on-secondary-container rounded-full text-xs font-bold tracking-widest uppercase">Top
              Rated</span>
          </div>
          <h1 class="text-6xl md:text-8xl font-black tracking-tighter text-on-surface">Scythe</h1>
          <div class="flex items-center gap-6 text-on-surface-variant font-medium">
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary" data-icon="star"
                style="font-variation-settings: 'FILL' 1;">star</span>
              <span class="text-on-surface">4.8</span>
              <span class="text-sm opacity-60">(124 Reviews)</span>
            </div>
            <span class="w-1.5 h-1.5 rounded-full bg-outline-variant"></span>
            <div class="flex items-center gap-2">
              <span class="material-symbols-outlined text-primary" data-icon="groups">groups</span>
              <span>1 - 5 Players</span>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="max-w-7xl mx-auto px-8 grid grid-cols-1 lg:grid-cols-12 gap-12 -mt-10 relative z-20 pb-24">
      <div class="lg:col-span-7 flex flex-col gap-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
          <div class="bg-surface-container-high p-6 rounded-xl flex flex-col gap-2">
            <span class="material-symbols-outlined text-primary mb-2" data-icon="speed">speed</span>
            <span class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">Difficulty</span>
            <span class="text-xl font-bold">3.4 / 5</span>
          </div>
          <div class="bg-surface-container-high p-6 rounded-xl flex flex-col gap-2">
            <span class="material-symbols-outlined text-secondary mb-2" data-icon="schedule">schedule</span>
            <span class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">Duration</span>
            <span class="text-xl font-bold">90-115m</span>
          </div>
          <div class="bg-surface-container-high p-6 rounded-xl flex flex-col gap-2">
            <span class="material-symbols-outlined text-tertiary mb-2" data-icon="child_care">child_care</span>
            <span class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">Age Range</span>
            <span class="text-xl font-bold">14+</span>
          </div>
          <div class="bg-surface-container-high p-6 rounded-xl flex flex-col gap-2">
            <span class="material-symbols-outlined text-primary mb-2" data-icon="category">category</span>
            <span class="text-on-surface-variant text-xs font-bold uppercase tracking-widest">Complex</span>
            <span class="text-xl font-bold">Engine Build</span>
          </div>
        </div>
        <div class="flex flex-col gap-6">
          <h2 class="text-3xl font-bold tracking-tight">The Mechanics</h2>
          <div class="text-on-surface-variant leading-relaxed font-body flex flex-col gap-4">
            <p>It is a time of unrest in 1920s Europa. The ashes from the first great war still darken the snow. The
              capitalistic city-state known simply as "The Factory," which fueled the war with armored mechs, has closed
              its doors, drawing the attention of several nearby countries.</p>
            <p>In Scythe, each player represents a character from one of five factions of Eastern Europa who are
              attempting to earn their fortune and claim their faction's stake in the land around the mysterious
              Factory. Players conquer territory, enlist new recruits, reap resources, gain villagers, build structures,
              and activate monstrous mechs.</p>
            <p>Every part of Scythe has an aspect of engine-building to it. Players can upgrade actions to become more
              efficient, build structures that improve their position on the map, enlist recruits to enhance character
              abilities, and activate mechs to deter opponents from invading.</p>
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
        <form action="booking_client.php" method="POST"
          class="sticky top-28 glass-panel border border-outline-variant/15 p-8 rounded-2xl shadow-2xl flex flex-col gap-8">
          <input type="hidden" name="csrf_token" value="<?php echo Security::generateCSRFToken(); ?>">
          <div class="flex flex-col gap-2">
            <h3 class="text-2xl font-bold">Check Availability</h3>
            <p class="text-on-surface-variant text-sm">Select your preferred date and crew size.</p>
          </div>
          <div class="space-y-6">
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1"
                for="username">Username</label>
              <div class="relative">
                <input
                  class="w-full bg-surface-container-highest border-0 rounded-xl px-4 py-4 text-on-surface focus:ring-2 focus:ring-primary outline-none transition-all"
                  id="username" name="username" placeholder="Mohamed" required="" type="text" />
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