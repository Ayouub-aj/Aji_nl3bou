<?php
require_once __DIR__ . '/../../config/init.php';
$game = $game ?? null;
$categories = $categories ?? [];
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Edit Game | The Curated Playroom</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="/dashboard/Aji_nl3bou/public/style/tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link href="/dashboard/Aji_nl3bou/public/style/style.css" rel="stylesheet" />
</head>

<body class="bg-surface text-on-surface min-h-screen flex">
    <!-- SideNavBar -->
    <?php include __DIR__ . '/../includes/side_menu.php'; ?>
    <!-- Main Canvas -->
    <main class="admin-main lg:ml-64 flex-1 flex flex-col min-h-screen bg-surface">
        <!-- TopNavBar -->
        <header
            class="admin-header h-16 px-8 flex justify-between items-center fixed top-0 right-0 w-[calc(100%-16rem)] z-40 bg-[#0e0e0e]/70 backdrop-blur-xl">
            <div class="flex items-center gap-4">
                <button onclick="toggleSidebar()" class="lg:hidden text-gray-400 hover:text-white p-2">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div class="relative group">
                    <span
                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-[#b6a0ff] transition-colors">search</span>
                    <input
                        class="bg-surface-container-highest border-none rounded-full pl-10 pr-4 py-1.5 text-sm w-64 focus:ring-1 focus:ring-primary transition-all outline-none"
                        placeholder="Search catalog..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-6">
                <nav class="flex items-center gap-6 text-sm font-medium">
                    <a class="text-gray-400 hover:text-[#b6a0ff] transition-colors" href="#">Table View</a>
                    <a class="text-gray-400 hover:text-[#b6a0ff] transition-colors" href="#">Floor Plan</a>
                </nav>
                <div class="flex items-center gap-3 border-l border-white/10 pl-6">
                    <button class="p-1.5 text-gray-400 hover:text-white transition-colors relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span
                            class="absolute top-1.5 right-1.5 w-2 h-2 bg-secondary rounded-full border-2 border-[#0e0e0e]"></span>
                    </button>
                    <button class="p-1.5 text-gray-400 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">help_outline</span>
                    </button>
                </div>
            </div>
        </header>
        <!-- Content Area -->
        <div class="mt-16 p-10 max-w-5xl mx-auto w-full">
            <form action="/dashboard/Aji_nl3bou/games/update/<?= $game['id'] ?? '' ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="csrf_token" value="<?php echo \App\Core\Security::generateCSRFToken(); ?>">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <nav class="flex items-center gap-2 text-xs text-gray-500 mb-2 font-bold uppercase tracking-wider">
                            <a href="/dashboard/Aji_nl3bou/inventory" class="hover:text-primary">Inventory</a>
                            <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                            <span class="text-primary">Edit Game</span>
                        </nav>
                        <h1 class="text-4xl font-extrabold tracking-tight text-on-surface">Edit Game</h1>
                    </div>
                    <div class="flex gap-4">
                        <a href="/dashboard/Aji_nl3bou/inventory">
                            <button type="button"
                                class="px-6 py-2.5 rounded-lg font-bold text-sm text-gray-400 hover:text-white border border-outline-variant/15 hover:bg-surface-container-high transition-all">
                                Cancel
                            </button>
                        </a>
                        <button type="submit"
                            class="px-8 py-2.5 rounded-lg font-bold text-sm text-on-primary bg-gradient-to-v from-primary to-primary-dim shadow-[0_0_20px_rgba(182,160,255,0.3)] hover:shadow-[0_0_25px_rgba(182,160,255,0.5)] transition-all">
                            Update Game
                        </button>
                    </div>
                </div>
                <!-- Added form tag -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Left: Form Sections -->
                    <div class="lg:col-span-2 space-y-6">
                        <!-- Basic Information -->
                        <section class="bg-surface-container-low rounded-xl p-8 space-y-6">
                            <h2 class="text-lg font-bold flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                                Basic Information
                            </h2>
                            <div class="space-y-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 px-1">Game
                                        Title</label>
                                    <input
                                        class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface transition-all"
                                        name="title" placeholder="e.g. Terraforming Mars" type="text" 
                                        value="<?= htmlspecialchars($game['title'] ?? '') ?>" required />
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 px-1">Category</label>
                                        <select name="category"
                                            class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface transition-all appearance-none cursor-pointer">
                                            <option value="Stratégie" <?= ($game['category'] ?? '') === 'Stratégie' ? 'selected' : '' ?>>Stratégie</option>
                                            <option value="Ambiance" <?= ($game['category'] ?? '') === 'Ambiance' ? 'selected' : '' ?>>Ambiance</option>
                                            <option value="Famille" <?= ($game['category'] ?? '') === 'Famille' ? 'selected' : '' ?>>Famille</option>
                                            <option value="Experts" <?= ($game['category'] ?? '') === 'Experts' ? 'selected' : '' ?>>Experts</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 px-1">Difficulty</label>
                                        <select name="difficulty"
                                            class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface transition-all appearance-none cursor-pointer">
                                            <option value="Facile" <?= ($game['difficulty'] ?? '') === 'Facile' ? 'selected' : '' ?>>Facile</option>
                                            <option value="Moyen" <?= ($game['difficulty'] ?? 'Moyen') === 'Moyen' ? 'selected' : '' ?>>Moyen</option>
                                            <option value="Difficile" <?= ($game['difficulty'] ?? '') === 'Difficile' ? 'selected' : '' ?>>Difficile</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Game Mechanics -->
                        <section class="bg-surface-container-low rounded-xl p-8 space-y-6">
                            <h2 class="text-lg font-bold flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-secondary rounded-full"></span>
                                Gameplay Details
                            </h2>
                            <div class="grid grid-cols-2 gap-8">
                                <div class="space-y-4">
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest px-1">Player
                                        Count</label>
                                    <div class="flex items-center gap-4">
                                        <div class="flex-1">
                                            <span class="text-[10px] text-gray-500 block mb-1">MIN</span>
                                            <input
                                                class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface"
                                                name="min_players" min="1" placeholder="1" type="number" 
                                                value="<?= $game['min_players'] ?? '1' ?>" required />
                                        </div>
                                        <div class="flex-1">
                                            <span class="text-[10px] text-gray-500 block mb-1">MAX</span>
                                            <input
                                                class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface"
                                                name="max_players" min="1" placeholder="5" type="number" 
                                                value="<?= $game['max_players'] ?? '5' ?>" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="space-y-4">
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest px-1">Duration
                                        (Min)</label>
                                    <div class="relative">
                                        <input
                                            class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-2 pr-12 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface"
                                            name="duration" placeholder="60" step="15" type="number" 
                                            value="<?= $game['duration'] ?? '60' ?>" required />
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">mins</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- Status Selection -->
                        <section class="bg-surface-container-low rounded-xl p-8 space-y-6">
                            <h2 class="text-lg font-bold flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-primary rounded-full"></span>
                                Game Status
                            </h2>
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 px-1">Availability</label>
                                <select name="status"
                                    class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface transition-all appearance-none cursor-pointer">
                                    <option value="available" <?= ($game['status'] ?? 'available') === 'available' ? 'selected' : '' ?>>Available</option>
                                    <option value="unavailable" <?= ($game['status'] ?? '') === 'unavailable' ? 'selected' : '' ?>>Unavailable</option>
                                </select>
                            </div>
                        </section>
                        <!-- Narrative -->
                        <section class="bg-surface-container-low rounded-xl p-8 space-y-6">
                            <h2 class="text-lg font-bold flex items-center gap-2">
                                <span class="w-1.5 h-6 bg-tertiary-fixed rounded-full"></span>
                                Description &amp; Content
                            </h2>
                            <div>
                                <label
                                    class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 px-1">Game
                                    Description</label>
                                <textarea name="description"
                                    class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface transition-all resize-none"
                                    placeholder="Describe the gameplay mechanics, theme, and what makes this game unique..."
                                    rows="6"><?= htmlspecialchars($game['description'] ?? '') ?></textarea>
                            </div>
                        </section>
                    </div>
                    <!-- Right: Visuals & Metadata -->
                    <div class="space-y-6">
                        <!-- Image Upload -->
                        <section class="bg-surface-container-low rounded-xl p-8 space-y-6">
                            <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Cover Image</h2>
                            <label
                                class="aspect-square w-full rounded-xl border-2 border-dashed border-outline-variant/30 flex flex-col items-center justify-center gap-4 bg-surface-container-highest/30 hover:bg-surface-container-highest/50 transition-colors group cursor-pointer overflow-hidden relative">
                                <input type="file" name="image" accept="image/*" class="hidden" id="imageInput" onchange="previewImage(this)" />
                                <div id="imagePreview" class="w-full h-full flex flex-col items-center justify-center">
                                    <?php if (!empty($game['image_url'])): ?>
                                    <img src="<?= htmlspecialchars($game['image_url']) ?>" class="w-full h-full object-cover" alt="Current image" />
                                    <?php else: ?>
                                    <div
                                        class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                        <span class="material-symbols-outlined text-3xl">add_a_photo</span>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm font-bold text-on-surface">Upload Game Art</p>
                                        <p class="text-[10px] text-gray-500 mt-1">PNG, JPG up to 10MB</p>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </label>
                            <?php if (!empty($game['image_url'])): ?>
                            <p class="text-xs text-center text-gray-500">Current image shown. Upload new to replace.</p>
                            <?php endif; ?>
                            <div class="p-4 rounded-lg bg-surface-container-highest/50 flex gap-4 items-center">
                                <div class="w-10 h-10 rounded bg-surface-container flex items-center justify-center">
                                    <span class="material-symbols-outlined text-gray-500">info</span>
                                </div>
                                <p class="text-[11px] leading-tight text-gray-400">
                                    Recommend 1000x1000px square format for optimal dashboard display.
                                </p>
                            </div>
                        </section>
                    </div>
                </div>
            </form>
            <!-- Footer -->
            <footer
                class="mt-20 py-10 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-gray-500 text-xs">
                    © 2024 Aji L3bo Cafe. <span class="text-gray-600 ml-2">All Rights Reserved.</span>
                </div>
                <div class="flex items-center gap-8">
                    <a class="text-xs font-bold text-gray-500 hover:text-primary transition-colors uppercase tracking-widest"
                        href="#">Documentation</a>
                    <a class="text-xs font-bold text-gray-500 hover:text-primary transition-colors uppercase tracking-widest"
                        href="#">Support</a>
                    <a class="text-xs font-bold text-gray-500 hover:text-primary transition-colors uppercase tracking-widest"
                        href="#">Privacy Policy</a>
                </div>
            </footer>
        </div>
    </main>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('active');
        }
        
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('imagePreview');
                    preview.innerHTML = '<img src="' + e.target.result + '" class="w-full h-full object-cover" />';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>

</html>
