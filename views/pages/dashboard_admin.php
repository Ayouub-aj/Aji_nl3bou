<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Portal | The Curated Playroom</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="../style/tailwind-config.js"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../style/style.css">
    <script src="../style/main.js" defer></script>
</head>

<body class="bg-background text-on-surface font-body selection:bg-primary selection:text-on-primary">
    <?php include '../includes/side_menu.php'; ?>
    <main class="lg:ml-64 admin-main min-h-screen pb-20">
        <header class="sticky top-0 z-40 flex justify-between items-center px-8 py-6 bg-[#0e0e0e]/80 backdrop-blur-md">
            <div class="flex items-center gap-4">
                <button id="menu-toggle"
                    class="lg:hidden text-on-surface-variant flex items-center justify-center p-2 rounded-lg bg-surface-container-low border border-white/5">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h1 class="text-3xl font-extrabold font-headline tracking-tighter text-on-surface">Overview</h1>
                    <p class="text-on-surface-variant text-sm font-medium mt-1">Thursday, October 24, 2024</p>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <div class="relative">
                    <span
                        class="material-symbols-outlined text-on-surface-variant text-2xl hover:text-primary transition-colors cursor-pointer"
                        data-icon="notifications">notifications</span>
                    <span
                        class="absolute top-0 right-0 w-2 h-2 bg-secondary rounded-full border-2 border-background"></span>
                </div>
                <div
                    class="flex items-center gap-3 bg-surface-container-low rounded-full px-4 py-2 border border-white/5">
                    <div class="w-2 h-2 bg-tertiary rounded-full shadow-[0_0_8px_rgba(181,255,194,0.6)]"></div>
                    <span class="text-xs font-bold text-on-surface uppercase tracking-widest">System Live</span>
                </div>
            </div>
        </header>
        <section class="px-8 mt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-surface-container-high rounded-xl p-6 border-l-4 border-primary">
                    <p class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1">Active Sessions
                    </p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black font-headline">12</span>
                        <span class="text-tertiary text-xs font-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm" data-icon="trending_up">trending_up</span>
                            +3
                        </span>
                    </div>
                </div>
                <div class="bg-surface-container-high rounded-xl p-6 border-l-4 border-secondary">
                    <p class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1">Pending
                        Reservations</p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black font-headline">08</span>
                        <span class="text-secondary text-xs font-bold">Upcoming 2h</span>
                    </div>
                </div>
                <div class="bg-surface-container-high rounded-xl p-6 border-l-4 border-tertiary">
                    <p class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1">Occupied Tables
                    </p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black font-headline">18<span
                                class="text-lg text-gray-600 font-medium">/24</span></span>
                        <span class="text-on-surface-variant text-xs font-bold">75% Load</span>
                    </div>
                </div>
                <div class="bg-surface-container-high rounded-xl p-6 border-l-4 border-primary-dim">
                    <p class="text-on-surface-variant text-xs font-bold uppercase tracking-widest mb-1">Today's Revenue
                    </p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black font-headline">$1.2k</span>
                        <span class="text-tertiary text-xs font-bold flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm" data-icon="trending_up">trending_up</span>
                            14%
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-8 mt-12">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary" data-icon="bolt">bolt</span>
                    <h2 class="text-2xl font-extrabold font-headline tracking-tight">Live Sessions</h2>
                </div>
                <button class="text-sm font-bold text-primary hover:underline transition-all">View All Tables</button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                <div
                    class="group relative bg-surface-container rounded-xl overflow-hidden shadow-xl hover:shadow-primary/5 transition-all">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span
                                    class="bg-primary/20 text-primary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded">Strategy</span>
                                <h3 class="text-xl font-bold font-headline mt-2 uppercase">Table 04</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black text-primary-fixed-dim">01:42</p>
                                <p class="text-[10px] text-on-surface-variant font-bold uppercase">Time Elapsed</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mb-6">
                            <img alt="Scythe Board Game" class="w-16 h-16 rounded-lg object-cover"
                                data-alt="close-up of Scythe board game components with high detail and dramatic lighting on a dark table"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAzgoNn-1AZGIZs71jjwlCKK0ptEjdR-BsRaAI7bqDpyHJx4wv-ZZ9zMfFqlt0gNw8NSYiz9J4HUhxreuGYemQKUUnO6axIZbEnAPoS0E9cwc3ePtKsh84e2pp1WH1jHSG_JshXGRnCpLpNJdCrxvYR_JXizgcXsw7N7fEiuDdwtMNwEQ6O2c1ywTlcuaGAwngwE0Yuhph4t5zp2s8nyPJUuTS8rzY_BgvaDIU90GSVND4vzIDPIsxvP8zHMvqrUShNw8ovZIvrRGI" />
                            <div>
                                <p class="font-bold text-on-surface">Scythe</p>
                                <p class="text-xs text-on-surface-variant">4 Players • Expert</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-container-low px-6 py-4 flex justify-between items-center">
                        <div class="flex -space-x-2">
                            <img alt="Player 1" class="w-8 h-8 rounded-full border-2 border-surface-container"
                                data-alt="vibrant 3d character avatar of a young gamer"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuB15jIByoFvd1qZzEtNAmaKxIWYgpqTUDZBO8vnpuET4aMuKazjXBCT-LPP0YDE2Ub8IadFjSRLMf6uwM2szMU8I4--Q6NoY6-TuWOrK2Hd6ClGVJJ_n66QE7wCvxY1GRtQXYmFGXSBRufAbjCbfGjtYQ43zTACNRqId2RXDNhy4oXSfTPN0rhC0jkvHCThzw_vGhi1isaWge2Cfi584oDe1iAdTrds6QL1g0owwANeKRPM0Lsu6HGtA-DQab-g8qlQv0ks1YKlGEM" />
                            <img alt="Player 2" class="w-8 h-8 rounded-full border-2 border-surface-container"
                                data-alt="vibrant 3d character avatar of a young man with glasses"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBTCF8pkoziQvNJG9d_WLB-UlLM3Ts7YkM0mrBz8ytoH4pogpJbXtFLg92HFLWfOis4VVkwF1hk_nWrKe6sc0LHrNDBmYi1scrFlUBNJvEPNGIwdkYnHaaPjGJlrMxi3FdI8ovOhVMN69s66RMg650vDTs0f32G6fOeUvtD7SMI75KcW8O8IArcIORd1bM5KfzMHW0zTCBn01QPb2yUdAf2AXcqNU2aIOq65-PZVOIN4xQTUA5EpUEc_efY2AcE2NiUKWQrbIwn3Cc" />
                            <div
                                class="w-8 h-8 rounded-full border-2 border-surface-container bg-surface-container-highest flex items-center justify-center text-[10px] font-bold">
                                +2</div>
                        </div>
                        <button
                            class="material-symbols-outlined text-on-surface-variant hover:text-error transition-colors"
                            data-icon="more_vert">more_vert</button>
                    </div>
                </div>
                <div
                    class="group relative bg-surface-container rounded-xl overflow-hidden shadow-xl hover:shadow-secondary/5 transition-all">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span
                                    class="bg-secondary/20 text-secondary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded">Family</span>
                                <h3 class="text-xl font-bold font-headline mt-2 uppercase">Table 12</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black text-secondary-fixed-dim">00:24</p>
                                <p class="text-[10px] text-on-surface-variant font-bold uppercase">Time Elapsed</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mb-6">
                            <img alt="Ticket to Ride" class="w-16 h-16 rounded-lg object-cover"
                                data-alt="close up of colorful train pieces on a Ticket to Ride board game with warm lighting"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAW1IM1usNRo5gpMYDDzqgjltY514yznzpF211B7XUnwTCUHhzWIFeK3QpcwA6XxWM2-FKNGWopfacrUD42-9GJ-yX2V-WG2U-7KylE42qpjoEsnLTclpppVKFCHlOnzLYVMsgTQgUqxOXG_7VtMebiMm-srH01xuAlnelKF-U2PbxRsyG-sNYXMvXs0pqtsVBEv7Vi-rAVl7I-tqe1a61UBuZGPIaeMDoJMMZUgCaVW4k6BZBqZqY67be_CrFOK1VjrdwDqTwRZec" />
                            <div>
                                <p class="font-bold text-on-surface">Ticket to Ride</p>
                                <p class="text-xs text-on-surface-variant">3 Players • Casual</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-container-low px-6 py-4 flex justify-between items-center">
                        <div class="flex -space-x-2">
                            <img alt="Player 1" class="w-8 h-8 rounded-full border-2 border-surface-container"
                                data-alt="vibrant 3d character avatar of a young girl"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAaR1S7K1IgJ8tpeqAK9SbAU6w6V6Xez2DqFi7yLk6wRxHiQE65v4uXg7lLnwK3EdIcSdDIDtDFRAaE1vcDAs-m2-msdHL7NbCH9-lXrfsIHSuGJBK7az_OX8754CIJR4rGVJnWuczxD042bRDnR5_ZxBDU1OKcc57hVgTIzhbqyE9bghqh5PZphSVAYbEzB9gSn6S5tcnZFDL0GbicZTD1RXjZqD-MfhmXnrdWZ94SycMg31hA_tw1FAL7s_UpB26PHlAor8Ts-0w" />
                            <img alt="Player 2" class="w-8 h-8 rounded-full border-2 border-surface-container"
                                data-alt="vibrant 3d character avatar of a young woman"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCVi0BfkFUycaO4QrZOCXi6b2n2yzvRTksh6Ihaw_ggn8uaVxzcXJ9MGXnG4f3KvshMDdQNLO4l4uOxSkRe-jwXmo9oxrfk-DF4uH5vl53mRS36ppcg_ZFAOWhg0wW_p1dD_zA_AQIZduqgfw-Tvqp0TyzrTsfcxqAvYikvunNrlVtYVSQQ_k_KOG3rHYroPopyRKX1JPWeCZW9y6MYwhKOgTqStFw-0QDiy4_XyfAKuiB_sC1I7WH5dgFk1MxDPd53dKbLzQlYCVs" />
                            <img alt="Player 3" class="w-8 h-8 rounded-full border-2 border-surface-container"
                                data-alt="vibrant 3d character avatar of a man with beard"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCo52AbETG3kwdQKYA7h_3dptyKt9t3NLO15fX4u6MzRnW0RcKAd5GwsAkIGeyKRjeizKHas4OpQ9qMzW_2ecfrSFFHd_kNU5ntbvOHl8HjwpCes0P4v9nKxXfIQWMHtR8AFPBX3QsEXTvnN_jeQTnOdGMwn35kLFuXlNpJQpgUKbGSdOMr_3cQUNMljucK41ZptXtCo7bBEP1f4uCnSn6ajYJrOuA0W_sMctnH2MEIzfldpzYLEN6FsPLJlTlIL7318hUI1pn7myY" />
                        </div>
                        <button
                            class="material-symbols-outlined text-on-surface-variant hover:text-error transition-colors"
                            data-icon="more_vert">more_vert</button>
                    </div>
                </div>
                <div
                    class="group relative bg-surface-container rounded-xl overflow-hidden shadow-xl hover:shadow-primary/5 transition-all">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div>
                                <span
                                    class="bg-primary/20 text-primary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded">Strategy</span>
                                <h3 class="text-xl font-bold font-headline mt-2 uppercase">Table 09</h3>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-black text-primary-fixed-dim">02:15</p>
                                <p class="text-[10px] text-on-surface-variant font-bold uppercase">Time Elapsed</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 mb-6">
                            <img alt="Terraforming Mars" class="w-16 h-16 rounded-lg object-cover"
                                data-alt="detailed close-up of game components from Terraforming Mars featuring cubes and board surface under moody lighting"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuAqxxJq5uoCu39rsbhTF974HVX5g2vYIojoHLqweAv16cJExBP5rQJu81oqNsA3EoCqDLfF49aBQgsp0_R-CMiL4BPTwNrrU3khsjaFw7gH7HoyiQTanyhFZfiLK34gwEDb8v89KtPFTOfOMco78oHzwReDVMsfsXPhq_GHfv9b0V9LhZ6sBPZyJTlezAum5oQSeXh3SHkFwJ5TL-W9nJysmMSM-wOKnFU4-H8X_ALo2iT6iBGubMBljlHHREZDlAu6Abh786yj_qU" />
                            <div>
                                <p class="font-bold text-on-surface">Terraforming Mars</p>
                                <p class="text-xs text-on-surface-variant">2 Players • Advanced</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-surface-container-low px-6 py-4 flex justify-between items-center">
                        <div class="flex -space-x-2">
                            <img alt="Player 1" class="w-8 h-8 rounded-full border-2 border-surface-container"
                                data-alt="vibrant 3d character avatar of a cheerful young man"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuA16HvVR95UgPy1mXAmeuPLRU5bXPCBIsn6IAFFY3tbYxrSGmuFpIS9JA0YxkxGmWwZZn67I5mCTb3o2LFFh2tWu-VlrPy6UbBAYHFtvd2I_BG2mtyz0rbbTMZpKXRdmkd_3teCzIdwT3p9RNYDVWESUHqF9f35f3jDXdIpYDygYvBL7aDtAt-oCiNlN899WaxP354bzrnOVYagGSzLbG99bBjTdXpMDZy0wXYayaaMh1_7TncezGjBzV8DWsalWYzPMzGh-1C7VMs" />
                            <img alt="Player 2" class="w-8 h-8 rounded-full border-2 border-surface-container"
                                data-alt="vibrant 3d character avatar of a young student"
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuDQ_ETFX2rdHUUUFFLM0z-g-qpESCF3X0BZxzefm9kw2KBbkM5vZWJlRfiHcdQc62vNV3GWVJQyszysBoSV6d-mDPVn5toch-aikR1KGXGA7lTCm32LnltnyZQO5sv0QN_Do4ZLB_KooZvuCn5XwaFdHhXGE5W4OJJxiedcC5qI3byvgh3HZGsCxLFhZdaq6ouhMo7_mIx2hSx0lt9dnSbuQKFD5oFKbrLAqvkDcOr6oLTTVammZxggez8Pu_Gbb3sFx8RYYf1Z3Ek" />
                        </div>
                        <button
                            class="material-symbols-outlined text-on-surface-variant hover:text-error transition-colors"
                            data-icon="more_vert">more_vert</button>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-8 mt-12 mb-12">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-secondary"
                        data-icon="calendar_month">calendar_month</span>
                    <h2 class="text-2xl font-extrabold font-headline tracking-tight">Recent Reservations</h2>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs font-bold text-on-surface-variant">Filter by:</span>
                    <select
                        class="bg-surface-container-highest border-none text-xs font-bold rounded-lg py-1 pl-3 pr-8 focus:ring-1 focus:ring-primary">
                        <option>Today</option>
                        <option>Tomorrow</option>
                    </select>
                </div>
            </div>
            <div class="bg-surface-container rounded-xl overflow-hidden shadow-2xl">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-surface-container-low border-b border-white/5">
                        <tr>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Time</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Guest Name</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Size</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Game Request</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant">
                                Status</th>
                            <th
                                class="px-6 py-4 text-[10px] font-black uppercase tracking-widest text-on-surface-variant text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/5">
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 font-bold text-secondary">18:30</td>
                            <td class="px-6 py-4 font-semibold text-on-surface">Jordan Blackwood</td>
                            <td class="px-6 py-4 text-on-surface-variant">4 People</td>
                            <td class="px-6 py-4"><span class="text-on-surface">Catan: 5-6 Player Ext.</span></td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-tertiary/10 text-tertiary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-full">Confirmed</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    class="bg-primary text-on-primary text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg hover:shadow-[0_0_15px_rgba(182,160,255,0.4)] transition-all">Check-in</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 font-bold text-secondary">19:00</td>
                            <td class="px-6 py-4 font-semibold text-on-surface">Elena Rodriguez</td>
                            <td class="px-6 py-4 text-on-surface-variant">2 People</td>
                            <td class="px-6 py-4"><span class="text-on-surface">Wingspan</span></td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-secondary/10 text-secondary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-full">Pending</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="p-1.5 rounded-lg border border-white/10 hover:bg-white/10 transition-colors">
                                        <span class="material-symbols-outlined text-sm text-error"
                                            data-icon="close">close</span>
                                    </button>
                                    <button
                                        class="bg-tertiary text-on-tertiary text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg hover:brightness-110 transition-all">Confirm</button>
                                </div>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 font-bold text-secondary">19:15</td>
                            <td class="px-6 py-4 font-semibold text-on-surface">Marcus Chen</td>
                            <td class="px-6 py-4 text-on-surface-variant">6 People</td>
                            <td class="px-6 py-4"><span class="text-on-surface-variant italic">No request</span></td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-tertiary/10 text-tertiary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-full">Confirmed</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    class="bg-primary text-on-primary text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg opacity-50 cursor-not-allowed">Check-in</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 font-bold text-secondary">20:00</td>
                            <td class="px-6 py-4 font-semibold text-on-surface">Sarah Jenkins</td>
                            <td class="px-6 py-4 text-on-surface-variant">4 People</td>
                            <td class="px-6 py-4"><span class="text-on-surface">Root</span></td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-tertiary/10 text-tertiary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-full">Confirmed</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <button
                                    class="bg-primary text-on-primary text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg opacity-50 cursor-not-allowed">Check-in</button>
                            </td>
                        </tr>
                        <tr class="hover:bg-white/[0.02] transition-colors">
                            <td class="px-6 py-4 font-bold text-secondary">20:30</td>
                            <td class="px-6 py-4 font-semibold text-on-surface">The Miller Family</td>
                            <td class="px-6 py-4 text-on-surface-variant">5 People</td>
                            <td class="px-6 py-4"><span class="text-on-surface">Sushi Go! Party</span></td>
                            <td class="px-6 py-4">
                                <span
                                    class="bg-secondary/10 text-secondary text-[10px] font-black uppercase tracking-widest px-2 py-1 rounded-full">Pending</span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button
                                        class="p-1.5 rounded-lg border border-white/10 hover:bg-white/10 transition-colors">
                                        <span class="material-symbols-outlined text-sm text-error"
                                            data-icon="close">close</span>
                                    </button>
                                    <button
                                        class="bg-tertiary text-on-tertiary text-[10px] font-black uppercase tracking-widest px-3 py-1.5 rounded-lg hover:brightness-110 transition-all">Confirm</button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
    <?php include '../includes/footer.php'; ?>
</body>

</html>