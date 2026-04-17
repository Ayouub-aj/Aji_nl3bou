<?php
require_once __DIR__ . '/../../config/init.php';

use App\Models\TableModel;
use App\Models\GameModel;

$tableModel = new TableModel();
$gameModel = new GameModel();

// Get available tables by default
$defaultPlayers = 4;
$defaultDate = date('Y-m-d');
$defaultTime = '19:00';

$availableTables = $tableModel->getAvailableTables($defaultPlayers, $defaultDate, $defaultTime);
$games = $gameModel->getAvailableGames();
$selectedGame = null;

// If game_id is passed, get the selected game
if (isset($_GET['game_id'])) {
    $selectedGame = $gameModel->getGameById($_GET['game_id']);
}
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>The Curated Playroom | Make a Reservation</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script src="<?= URL_ROOT ?>/public/style/tailwind-config.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="<?= URL_ROOT ?>/public/style/style.css">
</head>

<body class="bg-surface text-on-surface selection:bg-primary/30">
  <?php include __DIR__ . '/../includes/header.php'; ?>
  <main class="relative min-h-screen">
    <section class="relative w-full h-[400px] flex items-end overflow-hidden">
      <div class="absolute inset-0 z-0">
        <?php if ($selectedGame && !empty($selectedGame['image_url'])): ?>
        <img alt="<?= htmlspecialchars($selectedGame['title']) ?>" class="w-full h-full object-cover brightness-[0.4]" src="<?= htmlspecialchars($selectedGame['image_url']) ?>" />
        <?php else: ?>
        <img alt="Board game cafe" class="w-full h-full object-cover brightness-[0.4]" src="https://images.unsplash.com/photo-1610890716171-6b1c9f2cd9be?w=1920&q=80" />
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

        <!-- Available Tables Section -->
        <div class="bg-surface-container-low rounded-xl p-8">
          <h2 class="text-2xl font-bold mb-6 flex items-center gap-3">
            <span class="material-symbols-outlined text-primary">table_restaurant</span>
            Available Tables
          </h2>
          
          <!-- Filter Controls -->
          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <div>
              <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-2">Players</label>
              <select id="filter-players" class="w-full bg-surface-container-highest border-0 rounded-lg px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary outline-none">
                <?php for ($i = 2; $i <= 10; $i++): ?>
                <option value="<?= $i ?>" <?= $i == $defaultPlayers ? 'selected' : '' ?>><?= $i ?> Players</option>
                <?php endfor; ?>
              </select>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-2">Date</label>
              <input type="date" id="filter-date" value="<?= $defaultDate ?>" class="w-full bg-surface-container-highest border-0 rounded-lg px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary outline-none">
            </div>
            <div>
              <label class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-2">Time</label>
              <select id="filter-time" class="w-full bg-surface-container-highest border-0 rounded-lg px-4 py-3 text-on-surface focus:ring-2 focus:ring-primary outline-none">
                <option value="18:00" <?= $defaultTime == '18:00' ? 'selected' : '' ?>>18:00</option>
                <option value="19:00" <?= $defaultTime == '19:00' ? 'selected' : '' ?>>19:00</option>
                <option value="20:00" <?= $defaultTime == '20:00' ? 'selected' : '' ?>>20:00</option>
                <option value="21:00" <?= $defaultTime == '21:00' ? 'selected' : '' ?>>21:00</option>
                <option value="22:00" <?= $defaultTime == '22:00' ? 'selected' : '' ?>>22:00</option>
              </select>
            </div>
          </div>

          <!-- Available Tables Grid -->
          <div id="available-tables" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <?php foreach ($availableTables as $table): ?>
            <div class="bg-surface-container-high rounded-xl p-4 border-2 border-primary/30 hover:border-primary transition-colors cursor-pointer" data-table-id="<?= $table['id'] ?>">
              <div class="flex items-center justify-between mb-2">
                <span class="font-bold">Table <?= $table['number'] ?></span>
                <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
              </div>
              <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                <span class="material-symbols-outlined text-sm">groups</span>
                <span><?= $table['capacity'] ?> seats</span>
              </div>
              <?php if (!empty($table['name'])): ?>
              <p class="text-xs text-on-surface-variant mt-2"><?= htmlspecialchars($table['name']) ?></p>
              <?php endif; ?>
            </div>
            <?php endforeach; ?>
            
            <?php if (empty($availableTables)): ?>
            <div class="col-span-full text-center py-8 text-on-surface-variant">
              <span class="material-symbols-outlined text-4xl mb-2">event_busy</span>
              <p>No tables available for this selection</p>
              <p class="text-sm">Try different date or time</p>
            </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <div class="lg:col-span-5">
        <form action="<?= URL_ROOT ?>/booking" method="POST" class="sticky top-28 glass-panel border border-outline-variant/15 p-8 rounded-2xl shadow-2xl flex flex-col gap-8">
          <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCSRFToken(); ?>">
          <?php if ($selectedGame): ?>
          <input type="hidden" name="game_id" value="<?= $selectedGame['id'] ?>">
          <?php endif; ?>
          <input type="hidden" name="table_id" id="selected-table-id" value="">
          
          <div class="flex flex-col gap-2">
            <h3 class="text-2xl font-bold">Reserve Your Table</h3>
            <p class="text-on-surface-variant text-sm">Fill in your details to book.</p>
          </div>
          
          <div class="space-y-6">
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="client_name">Your Name</label>
              <div class="relative">
                <input class="w-full bg-surface-container-highest border-0 rounded-xl px-4 py-4 text-on-surface focus:ring-2 focus:ring-primary outline-none transition-all" id="client_name" name="client_name" placeholder="Your name" required type="text" />
                <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined pointer-events-none opacity-40">person</span>
              </div>
            </div>
            
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="client_phone">Phone Number</label>
              <div class="relative">
                <input class="w-full bg-surface-container-highest border-0 rounded-xl px-4 py-4 text-on-surface focus:ring-2 focus:ring-primary outline-none transition-all" id="client_phone" name="client_phone" placeholder="+212 6XX-XXXXXX" required type="tel" />
                <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined pointer-events-none opacity-40">call</span>
              </div>
            </div>
            
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1" for="date">Select Date</label>
              <div class="relative">
                <input class="w-full bg-surface-container-highest border-0 rounded-xl px-4 py-4 text-on-surface focus:ring-2 focus:ring-primary outline-none transition-all cursor-pointer" id="date" name="date" required type="date" value="<?= $defaultDate ?>" />
                <span class="absolute right-4 top-1/2 -translate-y-1/2 material-symbols-outlined pointer-events-none opacity-40">calendar_today</span>
              </div>
            </div>

            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Table Capacity</label>
              <div class="grid grid-cols-4 gap-2">
                <input class="hidden" id="players_count" name="players_count" type="hidden" value="<?= $defaultPlayers ?>" />
                <?php foreach ([2, 4, 6, 8] as $count): ?>
                <button class="capacity-btn py-3 rounded-xl transition-colors <?= $count == $defaultPlayers ? 'bg-primary-container text-on-primary-container font-bold' : 'bg-surface-container-highest text-on-surface hover:bg-surface-container-high' ?>" data-value="<?= $count ?>" type="button"><?= $count ?></button>
                <?php endforeach; ?>
              </div>
            </div>
            
            <div class="flex flex-col gap-3">
              <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant ml-1">Select Time</label>
              <input class="hidden" id="time" name="time" type="hidden" value="<?= $defaultTime ?>" />
              <div class="grid grid-cols-3 gap-2">
                <?php foreach (['18:00', '19:00', '20:00', '21:00', '22:00'] as $time): ?>
                <button class="time-btn py-3 rounded-xl transition-colors <?= $time == $defaultTime ? 'bg-primary-container text-on-primary-container font-bold' : 'bg-surface-container-highest text-on-surface hover:bg-surface-container-high' ?>" data-value="<?= $time ?>" type="button"><?= $time ?></button>
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          
          <!-- Selected Table Display -->
          <div id="selected-table-display" class="hidden bg-primary-container/20 border border-primary/30 rounded-xl p-4">
            <div class="flex items-center gap-3">
              <span class="material-symbols-outlined text-primary text-2xl">table_restaurant</span>
              <div>
                <p class="text-sm text-on-surface-variant">Selected Table</p>
                <p class="font-bold" id="selected-table-name">-</p>
              </div>
            </div>
          </div>
          
          <div class="pt-4 border-t border-outline-variant/15 flex flex-col gap-4">
            <div class="flex justify-between items-center text-sm">
              <span class="text-on-surface-variant">Reservation Fee</span>
              <span class="font-bold">$12.00</span>
            </div>
            <button id="submit-btn" class="w-full bg-gradient-to-b from-[#b6a0ff] to-[#7e51ff] text-[#340090] font-black py-5 rounded-xl shadow-[0_0_20px_rgba(182,160,255,0.3)] hover:shadow-[0_0_30px_rgba(182,160,255,0.5)] transition-all active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed" type="submit" disabled>
              Select a Table First
            </button>
            <p class="text-[10px] text-center text-on-surface-variant uppercase tracking-[0.2em]">Cancellable up to 24h prior</p>
          </div>
        </form>
      </div>
    </div>
  </main>
  
  <footer class="w-full py-12 border-t border-[#b6a0ff]/10 bg-[#0e0e0e]">
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

<script>
// Table selection and availability checking
let selectedTableId = null;
const allTables = <?= json_encode($availableTables) ?>;

// Update available tables when filters change
async function updateAvailableTables() {
    const players = document.getElementById('filter-players').value;
    const date = document.getElementById('filter-date').value;
    const time = document.getElementById('filter-time').value;
    
    // Update form fields
    document.getElementById('players_count').value = players;
    document.getElementById('date').value = date;
    document.getElementById('time').value = time;
    
    // Fetch available tables
    try {
        const response = await fetch(`<?= URL_ROOT ?>/api/tables/available?players=${players}&date=${date}&time=${time}`);
        const data = await response.json();
        
        const container = document.getElementById('available-tables');
        
        if (data.tables && data.tables.length > 0) {
            container.innerHTML = data.tables.map(table => `
                <div class="bg-surface-container-high rounded-xl p-4 border-2 border-primary/30 hover:border-primary transition-colors cursor-pointer ${selectedTableId == table.id ? 'border-primary bg-primary-container/20' : ''}" data-table-id="${table.id}" data-table-name="Table ${table.number}">
                    <div class="flex items-center justify-between mb-2">
                        <span class="font-bold">Table ${table.number}</span>
                        <span class="material-symbols-outlined text-primary text-xl">check_circle</span>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-on-surface-variant">
                        <span class="material-symbols-outlined text-sm">groups</span>
                        <span>${table.capacity} seats</span>
                    </div>
                    ${table.name ? `<p class="text-xs text-on-surface-variant mt-2">${table.name}</p>` : ''}
                </div>
            `).join('');
            
            // Add click listeners
            container.querySelectorAll('[data-table-id]').forEach(el => {
                el.addEventListener('click', () => selectTable(el.dataset.tableId, el.dataset.tableName));
            });
        } else {
            container.innerHTML = `
                <div class="col-span-full text-center py-8 text-on-surface-variant">
                    <span class="material-symbols-outlined text-4xl mb-2">event_busy</span>
                    <p>No tables available for this selection</p>
                    <p class="text-sm">Try different date or time</p>
                </div>
            `;
        }
    } catch (error) {
        console.error('Error fetching tables:', error);
    }
}

// Select a table
function selectTable(tableId, tableName) {
    selectedTableId = tableId;
    
    // Update hidden input
    document.getElementById('selected-table-id').value = tableId;
    
    // Update display
    const display = document.getElementById('selected-table-display');
    document.getElementById('selected-table-name').textContent = tableName;
    display.classList.remove('hidden');
    
    // Update button
    const btn = document.getElementById('submit-btn');
    btn.disabled = false;
    btn.textContent = 'Confirm Reservation';
    
    // Update visual selection
    document.querySelectorAll('#available-tables [data-table-id]').forEach(el => {
        if (el.dataset.tableId == tableId) {
            el.classList.add('border-primary', 'bg-primary-container/20');
        } else {
            el.classList.remove('border-primary', 'bg-primary-container/20');
        }
    });
}

// Event listeners for filters
document.getElementById('filter-players').addEventListener('change', updateAvailableTables);
document.getElementById('filter-date').addEventListener('change', updateAvailableTables);
document.getElementById('filter-time').addEventListener('change', updateAvailableTables);

// Event listeners for form fields
document.getElementById('date').addEventListener('change', updateAvailableTables);

// Capacity buttons
document.querySelectorAll('.capacity-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.capacity-btn').forEach(b => {
            b.classList.remove('bg-primary-container', 'text-on-primary-container', 'font-bold');
            b.classList.add('bg-surface-container-highest', 'text-on-surface');
        });
        btn.classList.add('bg-primary-container', 'text-on-primary-container', 'font-bold');
        btn.classList.remove('bg-surface-container-highest', 'text-on-surface');
        document.getElementById('filter-players').value = btn.dataset.value;
        updateAvailableTables();
    });
});

// Time buttons
document.querySelectorAll('.time-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('.time-btn').forEach(b => {
            b.classList.remove('bg-primary-container', 'text-on-primary-container', 'font-bold');
            b.classList.add('bg-surface-container-highest', 'text-on-surface');
        });
        btn.classList.add('bg-primary-container', 'text-on-primary-container', 'font-bold');
        btn.classList.remove('bg-surface-container-highest', 'text-on-surface');
        document.getElementById('filter-time').value = btn.dataset.value;
        updateAvailableTables();
    });
});

// Initialize table click listeners
document.querySelectorAll('#available-tables [data-table-id]').forEach(el => {
    el.addEventListener('click', () => selectTable(el.dataset.tableId, el.dataset.tableName));
});
</script>
</body>

</html>
