<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Add New Game | The Curated Playroom</title>
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
    <script src="tailwind-config.js"></script>
    <link href="style.css" rel="stylesheet" />
</head>

<body class="bg-background text-on-background min-h-screen flex">
    <!-- SideNavBar -->
    <aside id="sidebar" class="admin-sidebar h-full w-64 fixed left-0 top-0 bg-[#131313] flex flex-col py-6 px-4 z-50">
        <div class="mb-10 px-2 flex justify-between items-center">
            <div>
                <div class="text-xl font-bold tracking-tighter text-[#b6a0ff]">The Curated Playroom</div>
                <div class="text-[10px] uppercase tracking-widest text-gray-500 mt-1 font-bold">Admin Terminal</div>
            </div>
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-white">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:text-gray-200 hover:bg-[#1e1e1e] transition-colors duration-200"
                href="dashboard_admin.php">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-medium">Dashboard</span>
            </a>
            <!-- Active Tab: Inventory -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-[#b6a0ff] font-bold border-r-4 border-[#b6a0ff] bg-[#1e1e1e] transition-colors duration-200"
                href="inventory.php">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="font-medium">Inventory</span>
            </a>
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:text-gray-200 hover:bg-[#1e1e1e] transition-colors duration-200"
                href="reservation_admin.php">
                <span class="material-symbols-outlined">event_available</span>
                <span class="font-medium">Reservations</span>
            </a>
            <!-- <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:text-gray-200 hover:bg-[#1e1e1e] transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">history</span>
                <span class="font-medium">History</span>
            </a> -->
            <!-- <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:text-gray-200 hover:bg-[#1e1e1e] transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">analytics</span>
                <span class="font-medium">Stats</span>
                <a> -->
        </nav>
        <div class="mt-auto pt-6 border-t border-white/5 space-y-1">
            <!-- <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:text-gray-200 hover:bg-[#1e1e1e] transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-medium text-sm">Settings</span>
            </a> -->
            <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-gray-500 hover:text-gray-200 hover:bg-[#1e1e1e] transition-colors duration-200"
                href="login.php">
                <span class="material-symbols-outlined">logout</span>
                <span class="font-medium text-sm">Log Out</span>
            </a>
            <div class="mt-4 px-4 flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-surface-container-highest overflow-hidden">
                    <img class="w-full h-full object-cover"
                        data-alt="professional headshot of a café administrator with a friendly expression in a modern office setting"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuAU21DfbLx0Ja5N5FFCyt9BB3t6p0b0l1-HCQaaxjCHmT5_hPWuzCa6zWtmF_Uu2OC6zxwrIxAeW1t6KAmfyuiwZB5vHkCZpDMcSZfwEw3qAaJFPT-Xwn_uhMy98JTI2ivjffAQR4jBfAobpHhdetMS1654PPrGCwswtbwvR2-rIAaK64W6V4a6Z2KRktDNKAJYo5UEdJYbvNubJetyUjqjyyKQ3ItzCGbtaNToD106trMTA-jW3FxnPMfOsRurJfAghZ4TNP8pdVQ" />
                </div>
                <div class="text-xs">
                    <div class="font-bold text-on-surface">Admin User</div>
                    <div class="text-gray-500">Super Admin</div>
                </div>
            </div>
        </div>
    </aside>
    <!-- Main Canvas -->
    <main class="admin-main ml-64 flex-1 flex flex-col min-h-screen bg-surface">
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
            <div class="flex items-center justify-between mb-10">
                <div>
                    <nav class="flex items-center gap-2 text-xs text-gray-500 mb-2 font-bold uppercase tracking-wider">
                        <span>Inventory</span>
                        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
                        <span class="text-primary">Add New Game</span>
                    </nav>
                    <h1 class="text-4xl font-extrabold tracking-tight text-on-surface">Add New Game</h1>
                </div>
                <div class="flex gap-4">
                    <button
                        class="px-6 py-2.5 rounded-lg font-bold text-sm text-gray-400 hover:text-white border border-outline-variant/15 hover:bg-surface-container-high transition-all">
                        Cancel
                    </button>
                    <button
                        class="px-8 py-2.5 rounded-lg font-bold text-sm text-on-primary bg-gradient-to-v from-primary to-primary-dim shadow-[0_0_20px_rgba(182,160,255,0.3)] hover:shadow-[0_0_25px_rgba(182,160,255,0.5)] transition-all">
                        Save Game
                    </button>
                </div>
            </div>
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
                                    placeholder="e.g. Terraforming Mars" type="text" />
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 px-1">ISBN/Reference</label>
                                    <input
                                        class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface transition-all"
                                        placeholder="978-3-16-148410-0" type="text" />
                                </div>
                                <div>
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2 px-1">Category</label>
                                    <select
                                        class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface transition-all appearance-none cursor-pointer">
                                        <option value="Stratégie">Stratégie</option>
                                        <option value="Ambiance">Ambiance</option>
                                        <option value="Famille">Famille</option>
                                        <option value="Experts">Experts</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Game Mechanics -->
                    <form action="add_game.php" method="POST"> <!-- Added form tag -->
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
                                                min="1" placeholder="1" type="number" />
                                        </div>
                                        <div class="flex-1">
                                            <span class="text-[10px] text-gray-500 block mb-1">MAX</span>
                                            <input
                                                class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface"
                                                min="1" placeholder="5" type="number" />
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
                                            placeholder="60" step="15" type="number" />
                                        <span
                                            class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 text-sm font-medium">mins</span>
                                    </div>
                                </div>
                            </div>
                            <div class="pt-4">
                                <div class="flex justify-between items-center mb-4">
                                    <label
                                        class="block text-xs font-bold text-gray-500 uppercase tracking-widest px-1">Difficulty
                                        Level</label>
                                    <span id="difficulty-label"
                                        class="bg-primary-container/20 text-primary px-3 py-1 rounded-full text-xs font-bold">Moyen</span>
                                </div>
                                <select
                                    class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface transition-all appearance-none cursor-pointer">
                                    <option value="Facile">Facile</option>
                                    <option value="Moyen" selected>Moyen</option>
                                    <option value="Difficile">Difficile</option>
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
                                <textarea
                                    class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 focus:ring-2 focus:ring-primary/50 focus:border-primary outline-none text-on-surface transition-all resize-none"
                                    placeholder="Describe the gameplay mechanics, theme, and what makes this game unique..."
                                    rows="6"></textarea>
                            </div>
                        </section>
                </div>
                <!-- Right: Visuals & Metadata -->
                <div class="space-y-6">
                    <!-- Image Upload -->
                    <section class="bg-surface-container-low rounded-xl p-8 space-y-6">
                        <h2 class="text-sm font-bold text-gray-400 uppercase tracking-widest">Cover Image</h2>
                        <div
                            class="aspect-square w-full rounded-xl border-2 border-dashed border-outline-variant/30 flex flex-col items-center justify-center gap-4 bg-surface-container-highest/30 hover:bg-surface-container-highest/50 transition-colors group cursor-pointer">
                            <div
                                class="w-16 h-16 rounded-full bg-surface-container-high flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                                <span class="material-symbols-outlined text-3xl">add_a_photo</span>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-bold text-on-surface">Upload Game Art</p>
                                <p class="text-[10px] text-gray-500 mt-1">PNG, JPG up to 10MB</p>
                            </div>
                        </div>
                        <div class="p-4 rounded-lg bg-surface-container-highest/50 flex gap-4 items-center">
                            <div class="w-10 h-10 rounded bg-surface-container flex items-center justify-center">
                                <span class="material-symbols-outlined text-gray-500">info</span>
                            </div>
                            <p class="text-[11px] leading-tight text-gray-400">
                                Recommend 1000x1000px square format for optimal dashboard display.
                            </p>
                        </div>
                    </section>
                    </form> <!-- Closed form tag after image upload section -->
                    <!-- Preview Card -->
                    <section class="bg-[#1e1e1e] rounded-xl overflow-hidden shadow-2xl">
                        <div class="h-40 w-full bg-surface-container-highest relative">
                            <img class="w-full h-full object-cover opacity-30 grayscale"
                                data-alt="abstract artistic background with geometric shapes and soft purple neon glow for placeholder content"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuC_1K685FQ9vCsXI_nILAmMMLDDDLMuPXKYOyu-2Rv5voSiqK-t1ARlsDtNSa6g4IrWwG1n5BFoOxdlnLIcBc9-dPnBlkm43tLLz6L8IumEudcACjbcx68QKItxoS3bb7xlqWM2ygDHIBm1RPro3gmuCCaMKRGYwTDBtFEqTDizMnJpHtCXRuOe9cq-Cz7TviujlpaNRbbXib-fJ4JtKlBn_OSR5BlWYxBPMrnEfshXuKIMzZTBuiw5f9XTw-9HKSuu-SViIqav78U" />
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-widest italic">Preview
                                    State</span>
                            </div>
                        </div>
                        <div class="p-6 space-y-4">
                            <div class="h-6 w-3/4 bg-surface-container-high rounded animate-pulse"></div>
                            <div class="flex gap-2">
                                <div class="h-6 w-16 bg-primary/20 rounded-full"></div>
                                <div class="h-6 w-12 bg-secondary/20 rounded-full"></div>
                            </div>
                            <div class="space-y-2">
                                <div class="h-3 w-full bg-surface-container-high rounded"></div>
                                <div class="h-3 w-full bg-surface-container-high rounded"></div>
                                <div class="h-3 w-2/3 bg-surface-container-high rounded"></div>
                            </div>
                        </div>
                        <div
                            class="bg-surface-container-low p-4 border-t border-white/5 flex justify-between items-center">
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-xs text-gray-500">group</span>
                                <span class="text-[10px] text-gray-400">1 - 5 Players</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-xs text-gray-500">schedule</span>
                                <span class="text-[10px] text-gray-400">60 mins</span>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
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
    </script>
</body>

</html>