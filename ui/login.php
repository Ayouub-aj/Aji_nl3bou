<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Aji L3bo | Sign In</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="style.css">
    <script src="main.js" defer></script>
</head>
</head>

<body class="bg-surface text-on-surface min-h-screen flex flex-col">
    <!-- Header / Brand Identity (Mapped from Shared Components JSON logic) -->
    <header class="w-full absolute top-0 left-0 flex justify-between items-center px-8 py-6 w-full z-10">
        <div class="text-2xl font-bold tracking-tighter text-violet-300 dark:text-violet-200 font-headline">
            The Curated Playroom
        </div>
        <div class="flex items-center gap-4">
            <span class="material-symbols-outlined text-violet-300">help_outline</span>
        </div>
    </header>
    <!-- Main Content Area -->
    <main class="flex-grow flex items-center justify-center p-6 bg-login-hero"
        data-alt="Dark dramatic close-up of high-quality board game pieces like dice and cards on a dark wooden tabletop with violet ambient lighting and deep shadows">
        <div class="w-full max-w-md">
            <!-- Login Card -->
            <div class="glass-panel p-8 md:p-10 rounded-xl shadow-2xl space-y-8">
                <div class="text-center space-y-2">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white">Aji L3bo</h1>
                    <p class="text-on-surface-variant text-sm font-medium">Welcome back to the table.</p>
                </div>
                <!-- Admin/Client Toggle (Asymmetric Tab Design) -->
                <!-- Form -->
                <form class="space-y-6 mt-8">
                    <div class="space-y-4">
                        <!-- Username/Email -->
                        <div class="space-y-2">
                            <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant px-1"
                                for="identifier">Email or Username</label>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">person</span>
                                <input
                                    class="w-full pl-12 pr-4 py-3.5 bg-surface-container-highest border-none rounded-lg focus:ring-2 focus:ring-primary text-on-surface placeholder:text-zinc-600 transition-all outline-none"
                                    id="identifier" placeholder="Enter your credentials" type="text" />
                                <div
                                    class="absolute inset-0 rounded-lg border border-white/5 pointer-events-none group-hover:border-white/10 transition-colors">
                                </div>
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="space-y-2">
                            <div class="flex justify-between items-center px-1">
                                <label class="text-xs font-bold uppercase tracking-widest text-on-surface-variant"
                                    for="password">Password</label>
                                <a class="text-xs font-semibold text-primary-dim hover:text-primary transition-colors"
                                    href="#">Forgot password?</a>
                            </div>
                            <div class="relative group">
                                <span
                                    class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">lock</span>
                                <input
                                    class="w-full pl-12 pr-4 py-3.5 bg-surface-container-highest border-none rounded-lg focus:ring-2 focus:ring-primary text-on-surface placeholder:text-zinc-600 transition-all outline-none"
                                    id="password" placeholder="••••••••" type="password" />
                                <div
                                    class="absolute inset-0 rounded-lg border border-white/5 pointer-events-none group-hover:border-white/10 transition-colors">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Remember Me -->
                    <div class="flex items-center px-1">
                        <label class="flex items-center cursor-pointer group">
                            <input
                                class="w-5 h-5 rounded border-outline-variant bg-surface-container text-primary focus:ring-primary focus:ring-offset-surface-container transition-all cursor-pointer"
                                type="checkbox" />
                            <span
                                class="ml-3 text-sm font-medium text-on-surface-variant group-hover:text-on-surface transition-colors">Stay
                                signed in for 30 days</span>
                        </label>
                    </div>
                    <!-- Submit Button -->
                    <button
                        class="w-full py-4 px-6 rounded-lg font-bold text-on-primary bg-gradient-to-b from-primary to-primary-dim shadow-[0_0_20px_rgba(182,160,255,0.2)] hover:shadow-[0_0_25px_rgba(182,160,255,0.4)] active:scale-[0.98] transition-all flex items-center justify-center gap-2"
                        type="submit">
                        Sign In
                        <span class="material-symbols-outlined text-lg">arrow_forward</span>
                    </button>
                </form>
                <!-- Signup Prompt -->
                <div class="pt-4 text-center">
                    <p class="text-sm text-on-surface-variant">
                        Don't have an account yet?
                        <a class="text-primary font-bold ml-1 hover:underline underline-offset-4" href="#">Join the
                            Club</a>
                    </p>
                </div>
            </div>
            <!-- Subtle Decorative Elements -->
            <div
                class="mt-8 flex justify-center gap-8 opacity-40 grayscale hover:grayscale-0 transition-all duration-500">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-2xl">casino</span>
                    <span class="text-[10px] uppercase tracking-tighter font-headline font-bold">1,200+ Games</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-2xl">groups</span>
                    <span class="text-[10px] uppercase tracking-tighter font-headline font-bold">Player Community</span>
                </div>
            </div>
        </div>
    </main>
    <!-- Footer (Mapped from Shared Components JSON) -->
    <footer
        class="w-full absolute bottom-0 left-0 flex flex-col md:flex-row justify-between items-center px-8 py-6 w-full opacity-60 z-10">
        <div class="text-sm font-bold text-zinc-400 font-inter">
            © 2024 The Curated Playroom. All Rights Reserved.
        </div>
        <div
            class="flex gap-6 mt-4 md:mt-0 font-inter text-[12px] uppercase tracking-widest text-violet-300 dark:text-violet-200">
            <a class="hover:text-zinc-300 transition-colors opacity-80" href="#">Privacy Policy</a>
            <a class="hover:text-zinc-300 transition-colors opacity-80" href="#">Terms of Service</a>
        </div>
    </footer>
</body>

</html>