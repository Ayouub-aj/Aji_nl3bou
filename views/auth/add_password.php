<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="../style/tailwind-config.js"></script>
    <link href="../style/style.css" rel="stylesheet" />
</head>

<body
    class="bg-background text-on-background font-body selection:bg-primary selection:text-on-primary min-h-screen flex flex-col">
    <!-- TopNavBar: Transcribed from JSON -->
    <nav
        class="bg-[#0e0e0e] text-[#b6a0ff] font-['Plus_Jakarta_Sans'] font-bold tracking-tight docked full-width top-0 bg-[#131313] flat no shadows flex justify-between items-center w-full px-6 py-4 sticky top-0 z-50">
        <div class="text-xl font-black text-[#b6a0ff] tracking-tighter">The Curated Playroom</div>
        <div class="flex items-center gap-4">
            <button
                class="text-gray-400 hover:bg-[#1c1c1c] transition-colors p-2 rounded-full scale-95 active:duration-100">
                <span class="material-symbols-outlined" data-icon="help">help</span>
            </button>
            <button
                class="text-gray-400 hover:bg-[#1c1c1c] transition-colors p-2 rounded-full scale-95 active:duration-100">
                <span class="material-symbols-outlined" data-icon="dark_mode">dark_mode</span>
            </button>
        </div>
    </nav>
    <!-- Main Content: Task-Focused Suppression of Side/Bottom Nav applied -->
    <main class="flex-grow flex items-center justify-center p-6 relative overflow-hidden">
        <!-- Abstract Background Glows -->
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/10 blur-[120px] rounded-full"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-secondary/5 blur-[120px] rounded-full"></div>
        <div class="w-full max-w-md z-10">
            <!-- Header Section (Editorial Style) -->
            <div class="mb-8 text-center md:text-left">
                <h1 class="font-headline text-4xl font-extrabold tracking-tight mb-2 text-on-background">Secure Your
                    Playroom.</h1>
                <p class="text-on-surface-variant text-sm max-w-xs md:max-w-none">Protect your collection and strategy
                    guides with a strong, unique password.</p>
            </div>
            <!-- Central Card (Glassmorphism) -->
            <div class="glass-card rounded-xl p-8 border border-outline-variant/15 shadow-2xl">
                <form class="space-y-6">
                    <!-- New Password Field -->
                    <div class="space-y-2">
                        <label class="font-label text-xs uppercase tracking-widest text-on-surface-variant ml-1">New
                            Password</label>
                        <div class="relative">
                            <input
                                class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                placeholder="••••••••" type="password" />
                            <span
                                class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-on-surface-variant cursor-pointer"
                                data-icon="visibility">visibility</span>
                        </div>
                    </div>
                    <!-- Strength Indicators (Bento Style Sub-grid) -->
                    <div class="grid grid-cols-2 gap-3">
                        <div class="bg-surface-container-low rounded-lg p-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-tertiary text-sm" data-icon="check_circle"
                                style="font-variation-settings: 'FILL' 1;">check_circle</span>
                            <span class="text-[10px] font-label uppercase tracking-wider text-on-surface">8+
                                Characters</span>
                        </div>
                        <div class="bg-surface-container-low rounded-lg p-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-outline text-sm"
                                data-icon="circle">circle</span>
                            <span
                                class="text-[10px] font-label uppercase tracking-wider text-on-surface-variant">Numbers
                                (0-9)</span>
                        </div>
                        <div class="bg-surface-container-low rounded-lg p-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-outline text-sm"
                                data-icon="circle">circle</span>
                            <span
                                class="text-[10px] font-label uppercase tracking-wider text-on-surface-variant">Special
                                Symbols</span>
                        </div>
                        <div class="bg-surface-container-low rounded-lg p-3 flex items-center gap-2">
                            <span class="material-symbols-outlined text-outline text-sm"
                                data-icon="circle">circle</span>
                            <span class="text-[10px] font-label uppercase tracking-wider text-on-surface-variant">Upper
                                &amp; Lower</span>
                        </div>
                    </div>
                    <!-- Confirm Password Field -->
                    <div class="space-y-2 pt-2">
                        <label class="font-label text-xs uppercase tracking-widest text-on-surface-variant ml-1">Confirm
                            Password</label>
                        <div class="relative">
                            <input
                                class="w-full bg-surface-container-highest border border-outline-variant/15 rounded-lg px-4 py-3 text-on-surface placeholder:text-outline focus:outline-none focus:ring-2 focus:ring-primary/50 focus:border-primary transition-all"
                                placeholder="••••••••" type="password" />
                        </div>
                    </div>
                    <!-- Action Button -->
                    <button
                        class="w-full primary-gradient text-on-primary font-bold py-4 rounded-lg shadow-lg shadow-primary/20 hover:shadow-primary/40 transition-all scale-95 active:scale-90 flex justify-center items-center gap-2 group"
                        type="submit">
                        Set Password
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform"
                            data-icon="arrow_forward">arrow_forward</span>
                    </button>
                </form>
                <!-- Security Note -->
                <div class="mt-8 flex gap-3 p-4 bg-surface-container-low rounded-lg border-l-4 border-secondary">
                    <span class="material-symbols-outlined text-secondary" data-icon="shield_lock"
                        style="font-variation-settings: 'FILL' 1;">shield_lock</span>
                    <p class="text-[11px] text-on-surface-variant leading-relaxed">
                        Security tip: Avoid using common words, birthdays, or sequences like "12345". Aji L3bo Café uses
                        AES-256 encryption to keep your vault private.
                    </p>
                </div>
            </div>
            <!-- Cancel/Back Link -->
            <div class="mt-6 text-center">
                <a class="text-xs font-label uppercase tracking-widest text-outline hover:text-on-surface transition-colors"
                    href="login.php">Cancel and return to login</a>
            </div>
        </div>
    </main>
    <!-- Footer: Transcribed from JSON -->
    <footer
        class="bg-[#0e0e0e] text-[#b6a0ff] font-['Inter'] text-xs uppercase tracking-widest docked full-width bottom-0 border-t border-[#ffffff15] flat no shadows w-full py-8 px-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="text-gray-500">© <?php echo date('Y'); ?> The Curated Playroom. All rights reserved.</div>
        <div class="flex gap-6">
            <a class="text-gray-500 hover:text-[#b5ffc2] transition-colors opacity-80 hover:opacity-100" href="#">Terms
                of Service</a>
            <a class="text-gray-500 hover:text-[#b5ffc2] transition-colors opacity-80 hover:opacity-100"
                href="#">Privacy Policy</a>
            <a class="text-gray-500 hover:text-[#b5ffc2] transition-colors opacity-80 hover:opacity-100"
                href="#">Security Standards</a>
            <a class="text-gray-500 hover:text-[#b5ffc2] transition-colors opacity-80 hover:opacity-100"
                href="#">Support</a>
        </div>
    </footer>
    <!-- Aesthetic Decorative Element -->
    <div class="fixed bottom-12 left-12 opacity-10 pointer-events-none hidden lg:block">
        <img alt="Abstract chess piece" class="w-64 h-64 object-contain"
            data-alt="minimalist 3D abstract shape resembling a transparent chess piece with violet and neon green internal glow on dark background"
            src="https://lh3.googleusercontent.com/aida-public/AB6AXuCYMN_79qUuWEqXqhlLB2DncbOBWaIRZfUJjD40zC00qDXFYNGKLqPt5VoZYsEqP3Kew4WH_RO8zRShc2ybM7rpjgOviEmIb8AWy5xtlKoa-gxA4t-gcxnM-czBco9kKPtqHK4oHIa8HfVtaKVChC2XevxRUWYXQVff4BCAMLMu0tXk7o3UOzNdi68Z8vQc36iSM2F18P4C4gn8kIGBRuOXqb0eZQZ6n07caO4VpGKmm_1tFys5WlLTnlIhqgjUZCzip2C6y0pQkJs" />
    </div>
</body>

</html>