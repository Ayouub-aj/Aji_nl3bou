<?php
require_once __DIR__ . '/../../config/init.php';
use App\Models\GameModel;

$gameModel = new GameModel();
$games = $gameModel->getAvailableGames();
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>The Curated Playroom | Game Catalogue</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= URLROOT; ?>/public/style/tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link href="<?= URLROOT; ?>/public/style/style.css" rel="stylesheet" />
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
                <form method="GET" action="home.php"
                    class="flex items-center bg-surface-container-highest/80 backdrop-blur-md rounded-xl p-2 border border-outline-variant/15 shadow-2xl">
                    <div class="flex-1 flex items-center px-4">
                        <span class="material-symbols-outlined text-primary">search</span>
                        <input
                            class="w-full bg-transparent border-none focus:ring-0 text-on-surface placeholder:text-on-surface-variant font-medium py-3 px-3"
                            name="query" placeholder="Search strategy, family, or specific titles..." type="text" />
                    </div>
                    <button
                        class="bg-gradient-to-b from-primary to-primary-dim text-on-primary font-bold px-8 py-3 rounded-lg active:scale-95 transition-all shadow-[0_0_20px_rgba(182,160,255,0.3)]">
                        Explore Now
                    </button>
                </form>
            </div>
        </section>
        <section class="max-w-[1440px] mx-auto px-8 py-12">
            <div class="flex flex-col lg:flex-row gap-8">
                <aside class="w-full lg:w-72 flex-shrink-0 space-y-8">
                    <div>
                        <h3 class="font-headline text-lg font-bold mb-4 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary text-sm">filter_list</span>
                            Categories
                        </h3>
                        <div class="flex flex-wrap lg:flex-col gap-2">
                            <button
                                class="flex items-center justify-between px-4 py-2 bg-primary/10 text-primary rounded-lg font-medium border border-primary/20">
                                Strategy <span class="text-xs opacity-60">24</span>
                            </button>
                            <button
                                class="flex items-center justify-between px-4 py-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg font-medium transition-colors">
                                Ambiance <span class="text-xs opacity-40">12</span>
                            </button>
                            <button
                                class="flex items-center justify-between px-4 py-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg font-medium transition-colors">
                                Family <span class="text-xs opacity-40">48</span>
                            </button>
                            <button
                                class="flex items-center justify-between px-4 py-2 text-on-surface-variant hover:bg-surface-container-high rounded-lg font-medium transition-colors">
                                Experts <span class="text-xs opacity-40">09</span>
                            </button>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-headline text-lg font-bold mb-4">Players</h3>
                        <div class="grid grid-cols-3 gap-2">
                            <button
                                class="p-2 text-center rounded-lg bg-surface-container border border-outline-variant/15 text-sm font-bold hover:border-primary/50 transition-all">1-2</button>
                            <button
                                class="p-2 text-center rounded-lg bg-surface-container border border-outline-variant/15 text-sm font-bold hover:border-primary/50 transition-all">3-4</button>
                            <button
                                class="p-2 text-center rounded-lg bg-surface-container border border-outline-variant/15 text-sm font-bold hover:border-primary/50 transition-all">5+</button>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-headline text-lg font-bold mb-4">Duration</h3>
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div
                                    class="w-5 h-5 rounded border border-outline-variant/30 group-hover:border-primary transition-colors flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[14px] text-primary hidden">check</span>
                                </div>
                                <span
                                    class="text-on-surface-variant group-hover:text-on-surface transition-colors">Short
                                    (&lt; 30m)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div
                                    class="w-5 h-5 rounded border border-primary bg-primary/20 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[14px] text-primary">check</span>
                                </div>
                                <span class="text-on-surface">Standard (30-90m)</span>
                            </label>
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <div
                                    class="w-5 h-5 rounded border border-outline-variant/30 group-hover:border-primary transition-colors flex items-center justify-center">
                                    <span class="material-symbols-outlined text-[14px] text-primary hidden">check</span>
                                </div>
                                <span class="text-on-surface-variant group-hover:text-on-surface transition-colors">Long
                                     (90m+)</span>
                            </label>
                        </div>
                    </div>
                </aside>
                <div class="flex-1">
                    <div class="flex justify-between items-center mb-8">
                        <p class="text-on-surface-variant font-medium">Showing <span class="text-on-surface">248
                                Games</span></p>
                        <div class="flex items-center gap-2">
                            <span class="text-sm text-on-surface-variant">Sort by:</span>
                            <button
                                class="flex items-center gap-1 font-bold text-sm bg-surface-container px-3 py-1.5 rounded-lg border border-outline-variant/10">
                                Most Popular <span class="material-symbols-outlined text-sm">expand_more</span>
                            </button>
                        </div>
                    </div>
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
                                <a href="<?= URLROOT; ?>/booking?game_id=<?= $game['id'] ?>"
                                    class="w-full block text-center py-3 bg-surface-container-highest hover:bg-primary hover:text-on-primary text-on-surface font-bold rounded-lg transition-all active:scale-95">
                                    Reservation 
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="mt-12 flex justify-center">
                        <nav class="flex gap-2">
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-surface-container text-on-surface-variant hover:text-on-surface transition-colors border border-outline-variant/10">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </button>
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-primary text-on-primary font-bold">1</button>
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-surface-container text-on-surface-variant hover:text-on-surface font-bold border border-outline-variant/10">2</button>
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-surface-container text-on-surface-variant hover:text-on-surface font-bold border border-outline-variant/10">3</button>
                            <span class="w-10 h-10 flex items-center justify-center text-on-surface-variant">...</span>
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-surface-container text-on-surface-variant hover:text-on-surface font-bold border border-outline-variant/10">12</button>
                            <button
                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-surface-container text-on-surface-variant hover:text-on-surface transition-colors border border-outline-variant/10">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </button>
                        </nav>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
    <button
        class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-b from-primary to-primary-dim text-on-primary rounded-full shadow-2xl flex items-center justify-center z-50 active:scale-95 transition-transform">
        <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">add</span>
    </button>
</body>

</html>
