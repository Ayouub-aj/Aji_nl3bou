<?php
require_once __DIR__ . '/../../config/init.php';
use App\Models\GameModel;

$gameModel = new GameModel();
$games = $gameModel->getAllGames();
$totalGames = count($games);
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Admin Game Inventory | The Curated Playroom</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script src="/dashboard/Aji_nl3bou/public/style/tailwind-config.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="/dashboard/Aji_nl3bou/public/style/style.css">
</head>

<body class="bg-surface text-on-surface flex min-h-screen">
  <!-- SideNavBar Shell -->
  <?php include __DIR__ . '/../includes/side_menu.php'; ?>
  <!-- Main Content Area -->
  <main class="lg:ml-64 admin-main flex-1 flex flex-col min-h-screen">
    <!-- Top Action Bar -->
    <header class="sticky top-0 z-30 bg-[#0e0e0e]/80 backdrop-blur-xl px-8 py-6 flex items-center justify-between">
      <div class="flex items-center gap-4">
        <button id="menu-toggle"
          class="lg:hidden text-on-surface-variant flex items-center justify-center p-2 rounded-lg bg-surface-container-low border border-white/5">
          <span class="material-symbols-outlined">menu</span>
        </button>
        <div class="flex flex-col">
          <h2 class="text-3xl font-extrabold tracking-tight font-headline text-on-surface">Game Inventory</h2>
          <p class="text-on-surface-variant text-sm">Managing <?= $totalGames ?> titles</p>
        </div>
      </div>
      <div class="flex items-center gap-4">
        <form method="GET" action="inventory.php" class="relative group">
          <span
            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">search</span>
          <input
            class="bg-surface-container-highest border-none outline-none focus:ring-2 focus:ring-primary/20 rounded-lg pl-10 pr-4 py-2.5 w-64 text-sm transition-all placeholder:text-outline"
            name="query" placeholder="Search games by title..." type="text" />
        </form>
        <button
          class="flex items-center gap-2 bg-surface-container-high text-on-surface px-4 py-2.5 rounded-lg border border-outline-variant/10 hover:bg-surface-bright transition-all">
          <span class="material-symbols-outlined text-xl">filter_list</span>
          <span class="text-sm font-medium">Filter</span>
        </button>
        <a href="/dashboard/Aji_nl3bou/games/add">
          <button
            class="flex items-center gap-2 bg-gradient-to-b from-primary to-primary-dim text-on-primary-fixed px-6 py-2.5 rounded-lg font-bold shadow-lg shadow-primary/10 hover:scale-[1.02] active:scale-[0.98] transition-all">
            <span class="material-symbols-outlined">add_circle</span>
            <span>Add New Game</span>
          </button>
        </a>
      </div>
    </header>
    <!-- Content Canvas -->
    <section class="p-8 flex-1">
      <!-- Inventory Table Container -->
      <div class="bg-surface-container-low rounded-xl overflow-hidden shadow-2xl">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr
                class="bg-surface-container-high text-on-surface-variant text-xs font-bold uppercase tracking-widest border-none">
                <th class="px-6 py-5">Image</th>
                <th class="px-6 py-5">Game Title</th>
                <th class="px-6 py-5">Category</th>
                <th class="px-6 py-5">Players</th>
                <th class="px-6 py-5">Status</th>
                <th class="px-6 py-5 text-right">Actions</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-outline-variant/5">
              <?php foreach ($games as $game): ?>
              <?php
                $statusClass = match($game['status']) {
                  'available' => 'bg-tertiary-container text-on-tertiary-container',
                  'unavailable' => 'bg-error-container text-on-error',
                  default => 'bg-surface-container-high text-on-surface-variant'
                };
                $statusText = match($game['status']) {
                  'available' => 'Available',
                  'unavailable' => 'Unavailable',
                  default => ucfirst($game['status'])
                };
              ?>
              <tr class="hover:bg-surface-container-highest/50 transition-colors group">
                <td class="px-6 py-4">
                  <div class="w-14 h-14 rounded-lg bg-surface-container-highest overflow-hidden">
                    <?php if (!empty($game['image_url'])): ?>
                    <img class="w-full h-full object-cover" src="<?= htmlspecialchars($game['image_url']) ?>" alt="<?= htmlspecialchars($game['title']) ?>" />
                    <?php else: ?>
                    <div class="w-full h-full flex items-center justify-center bg-surface-container">
                      <span class="material-symbols-outlined text-on-surface-variant">casino</span>
                    </div>
                    <?php endif; ?>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="flex flex-col">
                    <span class="font-bold text-on-surface text-lg"><?= htmlspecialchars($game['title']) ?></span>
                    <span class="text-xs text-on-surface-variant"><?= htmlspecialchars($game['category'] ?? '') ?></span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span class="px-3 py-1 rounded-full bg-primary-container text-on-primary-container text-xs font-bold uppercase tracking-tighter"><?= htmlspecialchars($game['category'] ?? 'N/A') ?></span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-1.5 text-on-surface-variant">
                    <span class="material-symbols-outlined text-sm">groups</span>
                    <span class="text-sm font-medium"><?= $game['min_players'] ?? '1' ?> - <?= $game['max_players'] ?? '5' ?></span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full <?= $statusClass ?> text-xs font-bold">
                    <?php if ($game['status'] === 'available'): ?>
                    <span class="w-2 h-2 rounded-full bg-on-tertiary-container animate-pulse"></span>
                    <?php endif; ?>
                    <?= $statusText ?>
                  </div>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <a href="/dashboard/Aji_nl3bou/games/edit/<?= $game['id'] ?>">
                      <button class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-primary transition-colors">
                        <span class="material-symbols-outlined">edit</span>
                      </button>
                    </a>
                    <form action="/dashboard/Aji_nl3bou/games/delete/<?= $game['id'] ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this game?');">
                      <input type="hidden" name="csrf_token" value="<?php echo \App\Core\Security::generateCSRFToken(); ?>">
                      <button type="submit" class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-error transition-colors">
                        <span class="material-symbols-outlined">delete</span>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php if (empty($games)): ?>
              <tr>
                <td colspan="6" class="px-6 py-12 text-center text-on-surface-variant">
                  <span class="material-symbols-outlined text-4xl mb-4">casino</span>
                  <p class="text-lg font-medium">No games in inventory</p>
                  <p class="text-sm">Add your first game to get started</p>
                </td>
              </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
        <!-- Pagination Footer -->
        <div
          class="px-8 py-5 flex items-center justify-between border-t border-outline-variant/5 bg-surface-container-low">
          <div class="flex items-center gap-6 text-sm text-on-surface-variant">
            <div class="flex items-center gap-2">
              <span>Show</span>
              <select
                class="bg-surface-container-highest border-none rounded-lg text-sm focus:ring-1 focus:ring-primary py-1 px-3">
                <option>10 entries</option>
                <option>25 entries</option>
                <option>50 entries</option>
              </select>
            </div>
              <span>Showing <?= count($games) ?> games</span>
          </div>
          <div class="flex items-center gap-2">
            <button
              class="p-2 rounded-lg hover:bg-surface-container-highest text-on-surface-variant hover:text-on-surface transition-all">
              <span class="material-symbols-outlined" data-icon="chevron_left">chevron_left</span>
            </button>
            <div class="flex items-center gap-1">
              <button
                class="w-9 h-9 flex items-center justify-center rounded-lg bg-primary text-on-primary font-bold">1</button>
              <button
                class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-surface-container-highest text-on-surface-variant transition-all">2</button>
              <button
                class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-surface-container-highest text-on-surface-variant transition-all">3</button>
              <span class="text-on-surface-variant px-1">...</span>
              <button
                class="w-9 h-9 flex items-center justify-center rounded-lg hover:bg-surface-container-highest text-on-surface-variant transition-all">15</button>
            </div>
            <button
              class="p-2 rounded-lg hover:bg-surface-container-highest text-on-surface-variant hover:text-on-surface transition-all">
              <span class="material-symbols-outlined" data-icon="chevron_right">chevron_right</span>
            </button>
          </div>
        </div>
      </div>
    </section>
  <!-- Site Footer -->
  <?php include __DIR__ . '/../includes/footer.php'; ?>
  </main>
</body>

</html>
