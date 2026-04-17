<?php
require_once __DIR__ . '/../../config/init.php';

// Games data is passed from controller
$games = $data['games'] ?? [];
$categories = $data['categories'] ?? [];
$filters = $data['filters'] ?? [];
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>The Curated Playroom | Game Catalogue</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= URL_ROOT ?>/public/style/tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link href="<?= URL_ROOT ?>/public/style/style.css" rel="stylesheet" />
</head>

<body class="bg-surface font-body text-on-surface selection:bg-primary/30">
    <?php include __DIR__ . '/../includes/header.php'; ?>
    <main class="relative min-h-screen">
        <section class="relative w-full h-[400px] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 z-0">
                <img alt="Hero background" class="w-full h-full object-cover opacity-40 grayscale-[0.5]"
                    data-alt="Dramatic high-angle shot of complex modern board game pieces and colorful cards arranged on a dark wooden table under warm spotlight"
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBuvKOmWYT6xIZenbyMjqEz-9phYR36_Y6SNivoyxGW0Zibncdbngu9LN7Kab8iFuGhLWZ15deX7y_TDk2ZcSKodtsrgXACp3m2NRlBuRT3ay7-2-P6b3GCTaFpXbulY7nx8-FKdV5pQyhdGIPsBJ0WKL6-OioKNJ_sEcPG3bvFLZCXXnDKHZganwQkji6nctds__0WQcU5h7ji78bpm6dQUBvFelXIPxqgRiqZpBD6Wt7LkWF-33RqvL_Q4EKe_p9ioQ6QLnFomW4" />
                <div class="absolute inset-0 bg-gradient-to-t from-surface via-surface/60 to-transparent"></div>
            </div>
            <div class="relative z-10 w-full max-w-4xl px-6 text-center">
                <h1 class="font-headline text-5xl md:text-6xl font-extrabold tracking-tighter mb-8 text-on-surface">
                    Find Your Next <span class="text-primary">Adventure</span>
                </h1>
                <form method="GET" action="<?= URL_ROOT ?>/"
                    class="flex items-center bg-surface-container-highest/80 backdrop-blur-md rounded-xl p-2 border border-outline-variant/15 shadow-2xl">
                    <div class="flex-1 flex items-center px-4">
                        <span class="material-symbols-outlined text-primary">search</span>
                        <input
                            class="w-full bg-transparent border-none focus:ring-0 text-on-surface placeholder:text-on-surface-variant font-medium py-3 px-3"
                            name="search" placeholder="Search games..." type="text" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" />
                    </div>
                    <button
                        class="bg-gradient-to-b from-primary to-primary-dim text-on-primary font-bold px-8 py-3 rounded-lg active:scale-95 transition-all shadow-[0_0_20px_rgba(182,160,255,0.3)]">
                        Search
                    </button>
                </form>
            </div>
        </section>
        <section class="max-w-[1440px] mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row gap-8">
                <aside class="w-full lg:w-72 flex-shrink-0 space-y-8">
                    <form method="GET" action="<?= URL_ROOT ?>/" class="space-y-6">
                        <input type="hidden" name="search" value="<?= htmlspecialchars($filters['search'] ?? '') ?>" />
                        
                        <!-- Categories Filter -->
                        <div>
                            <h3 class="font-headline text-lg font-bold mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">filter_list</span>
                                Categories
                            </h3>
                            <div class="flex flex-wrap lg:flex-col gap-2">
                                <?php
                                $categoryQuery = '?search=' . urlencode($filters['search'] ?? '');
                                if (!empty($filters['difficulty'])) $categoryQuery .= '&difficulty=' . urlencode($filters['difficulty']);
                                if (!empty($filters['players'])) $categoryQuery .= '&players=' . urlencode($filters['players']);
                                ?>
                                <a href="<?= URL_ROOT ?>/<?= $categoryQuery ?>"
                                    class="flex items-center justify-between px-4 py-2 rounded-lg font-medium transition-colors <?= empty($filters['category']) || $filters['category'] === 'all' ? 'bg-primary/10 text-primary border border-primary/20' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">
                                    All Games
                                </a>
                                <?php foreach ($categories as $cat): ?>
                                <?php
                                $catQuery = '?search=' . urlencode($filters['search'] ?? '') . '&category=' . urlencode($cat);
                                if (!empty($filters['difficulty'])) $catQuery .= '&difficulty=' . urlencode($filters['difficulty']);
                                if (!empty($filters['players'])) $catQuery .= '&players=' . urlencode($filters['players']);
                                ?>
                                <a href="<?= URL_ROOT ?>/<?= $catQuery ?>"
                                    class="flex items-center justify-between px-4 py-2 rounded-lg font-medium transition-colors <?= ($filters['category'] ?? '') === $cat ? 'bg-primary/10 text-primary border border-primary/20' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">
                                    <?= htmlspecialchars($cat) ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Difficulty Filter -->
                        <div>
                            <h3 class="font-headline text-lg font-bold mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">tune</span>
                                Difficulty
                            </h3>
                            <div class="flex flex-wrap lg:flex-col gap-2">
                                <?php
                                $baseDiffQuery = '?search=' . urlencode($filters['search'] ?? '') . '&category=' . urlencode($filters['category'] ?? '');
                                if (!empty($filters['players'])) $baseDiffQuery .= '&players=' . urlencode($filters['players']);
                                ?>
                                <a href="<?= URL_ROOT ?>/<?= $baseDiffQuery ?>"
                                    class="flex items-center justify-between px-4 py-2 rounded-lg font-medium transition-colors <?= empty($filters['difficulty']) || $filters['difficulty'] === 'all' ? 'bg-primary/10 text-primary border border-primary/20' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">
                                    Any
                                </a>
                                <?php foreach (['Facile' => 'Easy', 'Moyen' => 'Medium', 'Difficile' => 'Hard'] as $diff => $label): ?>
                                <?php
                                $diffQuery = '?search=' . urlencode($filters['search'] ?? '') . '&category=' . urlencode($filters['category'] ?? '') . '&difficulty=' . urlencode($diff);
                                if (!empty($filters['players'])) $diffQuery .= '&players=' . urlencode($filters['players']);
                                ?>
                                <a href="<?= URL_ROOT ?>/<?= $diffQuery ?>"
                                    class="flex items-center justify-between px-4 py-2 rounded-lg font-medium transition-colors <?= ($filters['difficulty'] ?? '') === $diff ? 'bg-primary/10 text-primary border border-primary/20' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">
                                    <?= $label ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <!-- Players Filter -->
                        <div>
                            <h3 class="font-headline text-lg font-bold mb-4 flex items-center gap-2">
                                <span class="material-symbols-outlined text-primary text-sm">group</span>
                                Players
                            </h3>
                            <div class="flex flex-wrap lg:flex-col gap-2">
                                <?php
                                $basePlayerQuery = '?search=' . urlencode($filters['search'] ?? '') . '&category=' . urlencode($filters['category'] ?? '');
                                if (!empty($filters['difficulty'])) $basePlayerQuery .= '&difficulty=' . urlencode($filters['difficulty']);
                                ?>
                                <a href="<?= URL_ROOT ?>/<?= $basePlayerQuery ?>"
                                    class="flex items-center justify-between px-4 py-2 rounded-lg font-medium transition-colors <?= empty($filters['players']) ? 'bg-primary/10 text-primary border border-primary/20' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">
                                    Any
                                </a>
                                <?php foreach (['2' => '2 Players', '4' => '4 Players', '6' => '6+ Players'] as $players => $label): ?>
                                <?php
                                $playerQuery = '?search=' . urlencode($filters['search'] ?? '') . '&category=' . urlencode($filters['category'] ?? '') . '&players=' . urlencode($players);
                                if (!empty($filters['difficulty'])) $playerQuery .= '&difficulty=' . urlencode($filters['difficulty']);
                                ?>
                                <a href="<?= URL_ROOT ?>/<?= $playerQuery ?>"
                                    class="flex items-center justify-between px-4 py-2 rounded-lg font-medium transition-colors <?= ($filters['players'] ?? '') === $players ? 'bg-primary/10 text-primary border border-primary/20' : 'text-on-surface-variant hover:bg-surface-container-high' ?>">
                                    <?= $label ?>
                                </a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <?php if ($filters['search'] || $filters['category'] || $filters['difficulty'] || $filters['players']): ?>
                        <a href="<?= URL_ROOT ?>/" class="block text-center py-2 px-4 rounded-lg border border-error/30 text-error hover:bg-error/10 transition-colors">
                            Clear Filters
                        </a>
                        <?php endif; ?>
                    </form>
                </aside>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-8">
                        <p class="text-on-surface-variant font-medium">
                            Showing <span class="text-on-surface"><?= count($games) ?></span> Games
                            <?php if ($filters['search']): ?>
                                for "<span class="text-primary"><?= htmlspecialchars($filters['search']) ?></span>"
                            <?php endif; ?>
                            <?php if ($filters['category'] && $filters['category'] !== 'all'): ?>
                                in <span class="text-primary"><?= htmlspecialchars($filters['category']) ?></span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <?php if (empty($games)): ?>
                    <div class="text-center py-16">
                        <span class="material-symbols-outlined text-6xl text-on-surface-variant mb-4">search_off</span>
                        <p class="text-xl font-bold text-on-surface">No games found</p>
                        <p class="text-on-surface-variant mt-2">Try adjusting your filters or search terms</p>
                        <a href="<?= URL_ROOT ?>/" class="inline-block mt-4 px-6 py-2 bg-primary text-on-primary rounded-lg font-bold">
                            Clear Filters
                        </a>
                    </div>
                    <?php else: ?>
                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                        <?php foreach ($games as $game): ?>
                        <div
                            class="group relative bg-surface-container-low rounded-xl overflow-hidden hover:translate-y-[-4px] transition-all duration-300">
                            <div class="h-64 relative overflow-hidden">
                                <?php if (!empty($game['image_url'])): ?>
                                <img alt="<?= htmlspecialchars($game['title']) ?>"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    src="<?= htmlspecialchars($game['image_url']) ?>" />
                                <?php else: ?>
                                <div class="w-full h-full bg-surface-container flex items-center justify-center">
                                    <span class="material-symbols-outlined text-6xl text-on-surface-variant">casino</span>
                                </div>
                                <?php endif; ?>
                                <div
                                    class="absolute top-4 right-4 bg-tertiary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5 shadow-lg">
                                    <div class="w-2 h-2 rounded-full bg-on-tertiary-container"></div>
                                    <span
                                        class="text-[10px] font-bold text-on-tertiary-container tracking-wider uppercase"><?= ucfirst($game['status']) ?></span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-primary-container text-on-primary-container shadow-md"><?= htmlspecialchars($game['category']) ?></span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4
                                    class="font-headline text-xl font-extrabold mb-3 group-hover:text-primary transition-colors">
                                    <?= htmlspecialchars($game['title']) ?></h4>
                                <div class="flex items-center gap-6 mb-6">
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">group</span>
                                        <span class="text-sm font-medium"><?= $game['min_players'] ?>-<?= $game['max_players'] ?> Players</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">schedule</span>
                                        <span class="text-sm font-medium"><?= $game['duration'] ?>m</span>
                                    </div>
                                </div>
                                <a href="<?= URL_ROOT ?>/booking?game_id=<?= $game['id'] ?>"
                                    class="w-full block text-center py-3 bg-surface-container-highest hover:bg-primary hover:text-on-primary text-on-surface font-bold rounded-lg transition-all active:scale-95">
                                    Reserve 
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
