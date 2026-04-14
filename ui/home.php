<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>The Curated Playroom | Game Catalogue</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;family=Inter:wght@400;500;600&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link href="style.css" rel="stylesheet" />
    <script defer="" src="main.js"></script>
</head>

<body class="bg-surface font-body text-on-surface selection:bg-primary/30">
    <header class="w-full top-0 sticky z-50 bg-[#0e0e0e] font-['Plus_Jakarta_Sans'] tracking-tight shadow-none">
        <div class="flex justify-between items-center px-8 py-4 w-full max-w-full mx-auto">
            <div class="text-2xl font-bold tracking-tighter text-[#b6a0ff]">The Curated Playroom</div>
            <nav class="hidden md:flex items-center gap-8">
                <a class="text-[#b6a0ff] font-bold border-b-2 border-[#b6a0ff] pb-1 transition-colors"
                    href="home.php">Explore</a>
                <a class="text-gray-400 font-medium hover:text-[#b6a0ff] transition-colors" href="#">Cafe Menu</a>
                <a class="text-gray-400 font-medium hover:text-[#b6a0ff] transition-colors" href="#">Events</a>
            </nav>
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-4">
                    <button class="text-[#b6a0ff] hover:text-white transition-colors active:scale-95 duration-200">
                        <span class="material-symbols-outlined">shopping_bag</span>
                    </button>
                    <button class="text-[#b6a0ff] hover:text-white transition-colors active:scale-95 duration-200">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                </div>
                <div
                    class="w-10 h-10 rounded-full bg-surface-container-highest overflow-hidden border border-[#b6a0ff]/20">
                    <img alt="User profile avatar"
                        data-alt="Close up portrait of a friendly professional man with a clean beard and smiling eyes in soft studio lighting"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDp5W2keEkC2JNW1XUWgsFoWM73LYLeVgUxCaquB1zCNQMaoNIYYAh5fmTrtAQqRm7UR1qC6pXh1NR0UcQCjSfvTwdVHO1RxHe-lqwa8g5AfNRgII22r3KEgAU8hMC4WKc4N3lfz3lrkujleaKq2CTHmswDO4peofLC5yW21R8d4QtB4qTVqUlaVtkIjpNl5x8D2xgV6qHdSSs9oEHFgX8RhLWJPC1U1pPvGSvlogFedEZ3n9IlSpiMdNZYiw13PU_RvjPBTWCpNAE" />
                </div>
            </div>
        </div>
    </header>
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
                <div
                    class="flex items-center bg-surface-container-highest/80 backdrop-blur-md rounded-xl p-2 border border-outline-variant/15 shadow-2xl">
                    <div class="flex-1 flex items-center px-4">
                        <span class="material-symbols-outlined text-primary">search</span>
                        <input
                            class="w-full bg-transparent border-none focus:ring-0 text-on-surface placeholder:text-on-surface-variant font-medium py-3 px-3"
                            placeholder="Search strategy, family, or specific titles..." type="text" />
                    </div>
                    <button
                        class="bg-gradient-to-b from-primary to-primary-dim text-on-primary font-bold px-8 py-3 rounded-lg active:scale-95 transition-all shadow-[0_0_20px_rgba(182,160,255,0.3)]">
                        Explore Now
                    </button>
                </div>
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
                        <div
                            class="group relative bg-surface-container-low rounded-xl overflow-hidden hover:translate-y-[-4px] transition-all duration-300">
                            <div class="h-64 relative overflow-hidden">
                                <img alt="Scythe board game"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    data-alt="Close up of a steampunk-themed board game with detailed mech miniatures and a snowy map board with deep atmospheric lighting"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCn2KxNSl6Et0vLiqCx-PjpQnndaOt0kAibfZFGvqmaZWGas_HD46Lgd9cBljQ0sHS8OgkOQflmsc5iYPFK_7XSytT1e8wQtBDv1TLeORRce6aQYTw6R4ccsxL4ud81C1Y3ifB4NsF6xB613nSN5tKuIWTtvvWPnOisjDoRkOLuQ2LuiwjofPTSEcf_LSsfMHKW42BS3TDvhETljib9cus0629ciXK-wJEwpBZCcF9glI6hcvUiSoUl9iqxw3-3lVjgKgxA9SEE__Q" />
                                <div
                                    class="absolute top-4 right-4 bg-tertiary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5 shadow-lg">
                                    <div class="w-2 h-2 rounded-full bg-on-tertiary-container"></div>
                                    <span
                                        class="text-[10px] font-bold text-on-tertiary-container tracking-wider uppercase">Available</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-primary-container text-on-primary-container shadow-md">Strategy</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4
                                    class="font-headline text-xl font-extrabold mb-3 group-hover:text-primary transition-colors">
                                    Scythe</h4>
                                <div class="flex items-center gap-6 mb-6">
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">group</span>
                                        <span class="text-sm font-medium">1-5 Players</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">schedule</span>
                                        <span class="text-sm font-medium">90-115m</span>
                                    </div>
                                </div>
                                <button
                                    class="w-full py-3 bg-surface-container-highest hover:bg-primary hover:text-on-primary text-on-surface font-bold rounded-lg transition-all active:scale-95">
                                    View Details
                                </button>
                            </div>
                        </div>
                        <div
                            class="group relative bg-surface-container-low rounded-xl overflow-hidden hover:translate-y-[-4px] transition-all duration-300">
                            <div class="h-64 relative overflow-hidden">
                                <img alt="Wingspan board game"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    data-alt="Beautifully illustrated board game cards featuring various bird species with wooden egg tokens in vibrant pastel colors on a textured surface"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuCAQtXBuMgQwgrvn7UjesqeFAUfGWupHC0jwjAh4Xpwcrg-oZNGrsH1qFo29Xvm_ZYQihf6wnlT9kNC8HbNhdw6LGR4yq7AAoagwO1WyP-BkzL0g3Xe0ZgtnEcIh0NNlw0GeejMtKR54W_CXwSTgoZXEU2Eb81C52_Hm7pUp6hoNdVlGDxmGVxYfZo9fxc3lVz40ifEnjTqzMTR9b-vshDY-oZRwx96g6VFuiGqR2B_fK6jYMXr2TKxsxWGV_2XjCA698XSrWdkeNE" />
                                <div
                                    class="absolute top-4 right-4 bg-error-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5 shadow-lg">
                                    <div class="w-2 h-2 rounded-full bg-on-error-container"></div>
                                    <span
                                        class="text-[10px] font-bold text-on-error-container tracking-wider uppercase">In
                                        Use</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-secondary-container text-on-secondary-container shadow-md">Family</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4
                                    class="font-headline text-xl font-extrabold mb-3 group-hover:text-primary transition-colors">
                                    Wingspan</h4>
                                <div class="flex items-center gap-6 mb-6">
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">group</span>
                                        <span class="text-sm font-medium">1-5 Players</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">schedule</span>
                                        <span class="text-sm font-medium">40-70m</span>
                                    </div>
                                </div>
                                <button
                                    class="w-full py-3 bg-surface-container-highest hover:bg-primary hover:text-on-primary text-on-surface font-bold rounded-lg transition-all active:scale-95">
                                    View Details
                                </button>
                            </div>
                        </div>
                        <div
                            class="group relative bg-surface-container-low rounded-xl overflow-hidden hover:translate-y-[-4px] transition-all duration-300">
                            <div class="h-64 relative overflow-hidden">
                                <img alt="Root board game"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    data-alt="Stylized forest-themed board game components with cute woodland animal wooden tokens and detailed forest map board under bright even lighting"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDYdsPiVbzDEKdfCMEJIv7kscloSYfoVDfamzRC8E-6E70NhiWMvDZQY_QacJQGqZEVwBeY-oav0QNjQ5SlDX3ptOREfV88smr5W0BEzq8bA8OHj_wSr2CoeLwyncv-5uaFVHyTQxKBsCMOshXWESW6YTDHdlr1RHny0cqcSWVohYnjVIKHN81GtkeU38XnaZJ4z22zLDUGmkovt0IvO1SsC3Ma_2HaNmR1ZgTILWPzytRojyoxHf9PK0SSd_ultde7WhF34aytogc" />
                                <div
                                    class="absolute top-4 right-4 bg-tertiary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5 shadow-lg">
                                    <div class="w-2 h-2 rounded-full bg-on-tertiary-container"></div>
                                    <span
                                        class="text-[10px] font-bold text-on-tertiary-container tracking-wider uppercase">Available</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-primary-container text-on-primary-container shadow-md">Strategy</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4
                                    class="font-headline text-xl font-extrabold mb-3 group-hover:text-primary transition-colors">
                                    Root</h4>
                                <div class="flex items-center gap-6 mb-6">
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">group</span>
                                        <span class="text-sm font-medium">2-4 Players</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">schedule</span>
                                        <span class="text-sm font-medium">60-90m</span>
                                    </div>
                                </div>
                                <button
                                    class="w-full py-3 bg-surface-container-highest hover:bg-primary hover:text-on-primary text-on-surface font-bold rounded-lg transition-all active:scale-95">
                                    View Details
                                </button>
                            </div>
                        </div>
                        <div
                            class="group relative bg-surface-container-low rounded-xl overflow-hidden hover:translate-y-[-4px] transition-all duration-300">
                            <div class="h-64 relative overflow-hidden">
                                <img alt="Catan"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    data-alt="Classic hexagonal resource tiles for board game arranged on a table with small wooden settlement pieces under soft indoor lighting"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDv3eZP095jmRJ496wMkTEzYzJiAEKLsmCa1NDREmMndZzDWSK7occGoCCy3kLn0kUawqmYyrvm8pZNjnDZ5f9Qn-3HnPSdbf4_LfGGSiowBWrxKytCR4wHp8xhAsX9KZe9eytRC0EQOztVr_oU3dERXqgcD4qrH5fPUn9mLYlafTmn-cuIjSmOtl_r_ds8LmK9EzsenBhPKIhWUdTAKwdn53hHNDa0B9h3uOL2atm8dgvwREq_VikdjsVKbhdHC5bwOOcxm4iahjs" />
                                <div
                                    class="absolute top-4 right-4 bg-tertiary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5 shadow-lg">
                                    <div class="w-2 h-2 rounded-full bg-on-tertiary-container"></div>
                                    <span
                                        class="text-[10px] font-bold text-on-tertiary-container tracking-wider uppercase">Available</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-secondary-container text-on-secondary-container shadow-md">Family</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4
                                    class="font-headline text-xl font-extrabold mb-3 group-hover:text-primary transition-colors">
                                    Catan</h4>
                                <div class="flex items-center gap-6 mb-6">
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">group</span>
                                        <span class="text-sm font-medium">3-4 Players</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">schedule</span>
                                        <span class="text-sm font-medium">60-120m</span>
                                    </div>
                                </div>
                                <a href="booking_client.php"
                                    class="w-full block text-center py-3 bg-surface-container-highest hover:bg-primary hover:text-on-primary text-on-surface font-bold rounded-lg transition-all active:scale-95">
                                    View Details
                                </a>
                            </div>
                        </div>
                        <div
                            class="group relative bg-surface-container-low rounded-xl overflow-hidden hover:translate-y-[-4px] transition-all duration-300">
                            <div class="h-64 relative overflow-hidden">
                                <img alt="Gloomhaven"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    data-alt="Enormous heavy board game box with dark fantasy illustrations and hundreds of cardboard tokens and small character figures"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuABwGOZtu21pLXM99vDQ13aHnDcIpCWlq0gPwJ37wAOVIAGQwgSxqc1UvvfKCEIFgLr1zL-_zDfZ9xdl8-qVwqxbtYSC5NcVFlYPFQl12TL9UKMSxDkGxuklZtpLDqm9GikRgu3YYv8D4U_F_ktu8Y9Z1LjRWees-Oyht2wAwuK5BMMaTc9eGcmDAU19HRMMDdTTw5HxkoJwGlCbUeNAXwLknyA8CiqBtpH9lg1CxspNoR0sPA0E5MKI48RVR4eL0A8IpiUN81CFUQ" />
                                <div
                                    class="absolute top-4 right-4 bg-tertiary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5 shadow-lg">
                                    <div class="w-2 h-2 rounded-full bg-on-tertiary-container"></div>
                                    <span
                                        class="text-[10px] font-bold text-on-tertiary-container tracking-wider uppercase">Available</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-surface-container-highest text-on-surface-variant shadow-md">Experts</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4
                                    class="font-headline text-xl font-extrabold mb-3 group-hover:text-primary transition-colors">
                                    Gloomhaven</h4>
                                <div class="flex items-center gap-6 mb-6">
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">group</span>
                                        <span class="text-sm font-medium">1-4 Players</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">schedule</span>
                                        <span class="text-sm font-medium">60-120m</span>
                                    </div>
                                </div>
                                <a href="booking_client.php"
                                    class="w-full block text-center py-3 bg-surface-container-highest hover:bg-primary hover:text-on-primary text-on-surface font-bold rounded-lg transition-all active:scale-95">
                                    View Details
                                </a>
                            </div>
                        </div>
                        <div
                            class="group relative bg-surface-container-low rounded-xl overflow-hidden hover:translate-y-[-4px] transition-all duration-300">
                            <div class="h-64 relative overflow-hidden">
                                <img alt="Azul"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                    data-alt="Colorful patterned square tiles reminiscent of Moroccan ceramics arranged in an artistic circle on a white surface with soft shadows"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuAr_uAuQuoQpmV5h41im84unxTCTRk0wwIqpf4MQI2t9MwJ_dncgybNpMoRAM2dz2Y148AGyadtA08HhpAsAIdmYUMKNJQYaRrtLUz4rRsW2l9Fmfbf4BgHIdTBuQ58yCIFt4r8LDK_ROQrVCFFyHIYxXVO73yxB3xEY7eljCvUHO6t3APAgYt3XmGAIAhRcziqDgFgwNwpcM4YDwgBwJvVQtxiRzh9jzmg-zFGu2NQN85_DNnOjqUNUjW9H5FMRBoRHv9e6yHMZAE" />
                                <div
                                    class="absolute top-4 right-4 bg-tertiary-container/90 backdrop-blur-md px-3 py-1 rounded-full flex items-center gap-1.5 shadow-lg">
                                    <div class="w-2 h-2 rounded-full bg-on-tertiary-container"></div>
                                    <span
                                        class="text-[10px] font-bold text-on-tertiary-container tracking-wider uppercase">Available</span>
                                </div>
                                <div class="absolute bottom-4 left-4">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-bold bg-secondary-container text-on-secondary-container shadow-md">Family</span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h4
                                    class="font-headline text-xl font-extrabold mb-3 group-hover:text-primary transition-colors">
                                    Azul</h4>
                                <div class="flex items-center gap-6 mb-6">
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">group</span>
                                        <span class="text-sm font-medium">2-4 Players</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-on-surface-variant">
                                        <span class="material-symbols-outlined text-lg">schedule</span>
                                        <span class="text-sm font-medium">30-45m</span>
                                    </div>
                                </div>
                                <a href="booking_client.php"
                                    class="w-full block text-center py-3 bg-surface-container-highest hover:bg-primary hover:text-on-primary text-on-surface font-bold rounded-lg transition-all active:scale-95">
                                    View Details
                                </a>
                            </div>
                        </div>
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
    <footer class="w-full py-12 border-t border-[#b6a0ff]/10 bg-[#0e0e0e] font-['Inter'] text-sm">
        <div class="flex flex-col items-center justify-center gap-6 w-full">
            <div class="text-lg font-bold text-[#b6a0ff]">The Curated Playroom</div>
            <div class="flex gap-8">
                <a class="text-gray-500 hover:text-white transition-colors" href="#">Terms</a>
                <a class="text-gray-500 hover:text-white transition-colors" href="#">Privacy</a>
                <a class="text-gray-500 hover:text-white transition-colors" href="#">Careers</a>
                <a class="text-gray-500 hover:text-white transition-colors" href="#">Contact</a>
            </div>
            <div class="text-gray-500">© 2024 The Curated Playroom. Roll with intention.</div>
        </div>
    </footer>
    <button
        class="md:hidden fixed bottom-6 right-6 w-14 h-14 bg-gradient-to-b from-primary to-primary-dim text-on-primary rounded-full shadow-2xl flex items-center justify-center z-50 active:scale-95 transition-transform">
        <span class="material-symbols-outlined text-2xl" style="font-variation-settings: 'FILL' 1;">add</span>
    </button>
</body>

</html>