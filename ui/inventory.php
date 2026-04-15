<!DOCTYPE html>

<html class="dark" lang="en">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Admin Game Inventory | The Curated Playroom</title>
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <script src="tailwind-config.js"></script>
  <link
    href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap"
    rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <script src="main.js" defer></script>
</head>
</head>

<body class="bg-surface text-on-surface flex min-h-screen">
  <!-- SideNavBar Shell -->
  <aside
    class="admin-sidebar h-screen w-64 fixed left-0 top-0 bg-[#131313] flex flex-col p-4 border-r border-[#b6a0ff]/5 shadow-2xl font-['Inter'] font-medium z-50 -translate-x-full lg:translate-x-0 transition-transform">
    <div class="mb-10 px-4 flex justify-between items-center">
      <div>
        <h1 class="text-xl font-black text-[#b6a0ff] tracking-tighter">Admin Portal</h1>
        <p class="text-xs text-on-surface-variant">Midnight Branch</p>
      </div>
      <button id="menu-close" class="lg:hidden text-on-surface-variant">
        <span class="material-symbols-outlined">close</span>
      </button>
    </div>
    <nav class="flex-1 space-y-2">
      <a class="flex items-center gap-3 text-gray-500 px-4 py-3 hover:bg-[#1c1c1c] hover:text-[#b6a0ff] transition-all active:translate-x-1 duration-150"
        href="dashboard_admin.php">
        <span class="material-symbols-outlined">dashboard</span>
        <span>Dashboard</span>
      </a>
      <a class="flex items-center gap-3 bg-[#b6a0ff]/10 text-[#b6a0ff] rounded-lg px-4 py-3 active:translate-x-1 duration-150"
        href="inventory.php">
        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">inventory_2</span>
        <span>Inventory</span>
      </a>
      <a class="flex items-center gap-3 text-gray-500 px-4 py-3 hover:bg-[#1c1c1c] hover:text-[#b6a0ff] transition-all active:translate-x-1 duration-150"
        href="reservation_admin.php">
        <span class="material-symbols-outlined">event_available</span>
        <span>Reservations</span>
      </a>
      <!-- <a class="flex items-center gap-3 text-gray-500 px-4 py-3 hover:bg-[#1c1c1c] hover:text-[#b6a0ff] transition-all active:translate-x-1 duration-150"
        href="#">
        <span class="material-symbols-outlined">history</span>
        <span>History</span>
      </a> -->
      <!-- <a class="flex items-center gap-3 text-gray-500 px-4 py-3 hover:bg-[#1c1c1c] hover:text-[#b6a0ff] transition-all active:translate-x-1 duration-150"
        href="#">
        <span class="material-symbols-outlined">query_stats</span>
        <span>Stats</span>
      </a> -->
    </nav>
    <div class="mt-auto space-y-2 border-t border-[#b6a0ff]/5 pt-4">
      <button
        class="w-full bg-gradient-to-b from-primary to-primary-dim text-on-primary font-bold py-3 rounded-xl shadow-lg shadow-primary/20 hover:shadow-primary/40 transition-all active:scale-95 mb-4">
        New Reservation
      </button>
      <a class="flex items-center gap-3 text-gray-500 px-4 py-2 hover:bg-[#1c1c1c] hover:text-[#b6a0ff] transition-all"
        href="#">
        <span class="material-symbols-outlined text-xl">settings</span>
        <span class="text-sm">Settings</span>
      </a>
      <a class="flex items-center gap-3 text-gray-500 px-4 py-2 hover:bg-[#1c1c1c] hover:text-[#b6a0ff] transition-all"
        href="#">
        <span class="material-symbols-outlined text-xl">help</span>
        <span class="text-sm">Support</span>
      </a>
    </div>
  </aside>
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
          <p class="text-on-surface-variant text-sm">Managing 148 titles across 12 categories</p>
        </div>
      </div>
      <div class="flex items-center gap-4">
        <div class="relative group">
          <span
            class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant group-focus-within:text-primary transition-colors">search</span>
          <input
            class="bg-surface-container-highest border-none outline-none focus:ring-2 focus:ring-primary/20 rounded-lg pl-10 pr-4 py-2.5 w-64 text-sm transition-all placeholder:text-outline"
            placeholder="Search games by title..." type="text" />
        </div>
        <button
          class="flex items-center gap-2 bg-surface-container-high text-on-surface px-4 py-2.5 rounded-lg border border-outline-variant/10 hover:bg-surface-bright transition-all">
          <span class="material-symbols-outlined text-xl">filter_list</span>
          <span class="text-sm font-medium">Filter</span>
        </button>
        <a href="add_game.php">
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
              <!-- Row 1 -->
              <tr class="hover:bg-surface-container-highest/50 transition-colors group">
                <td class="px-6 py-4">
                  <div class="w-14 h-14 rounded-lg bg-surface-container-highest overflow-hidden">
                    <img class="w-full h-full object-cover"
                      data-alt="high quality top down shot of a complex sci-fi themed board game box with vibrant purple and neon accents"
                      src="https://lh3.googleusercontent.com/aida-public/AB6AXuCIlPNm1nJPrMEJIwp1VCfOpJUpDaHHNUFIw2IXQ8VNqEfQlelIGL_AzkdcvrgNORJKmsP7-61uNhIAvh5s0jSSmJlXZDE5Ew0uOMaTIrr01v-HqznKbGMTax7EjJaIJsqLmS_pfSe5bJXQoh3_MZWPzpJKD6y1Rroag-h58R7LDrVUoCfi-AF_Ahe96UyE2L7smixcZTQzlMz8en5pP55JV38FS00PXFlvG6oRJ9r1YGnWLzHj6vyQhrFTWpowC269RalMjPx2fzE" />
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="flex flex-col">
                    <span class="font-bold text-on-surface text-lg">Terraforming Mars</span>
                    <span class="text-xs text-on-surface-variant">ISBN: 978-01-2345-678</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span
                    class="px-3 py-1 rounded-full bg-primary-container text-on-primary-container text-xs font-bold uppercase tracking-tighter">Strategy</span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-1.5 text-on-surface-variant">
                    <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                    <span class="text-sm font-medium">1 - 5</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-tertiary-container text-on-tertiary-container text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-on-tertiary-container animate-pulse"></span>
                    Available
                  </div>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                      class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-primary transition-colors">
                      <span class="material-symbols-outlined" data-icon="edit">edit</span>
                    </button>
                    <button
                      class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-error transition-colors">
                      <span class="material-symbols-outlined" data-icon="delete">delete</span>
                    </button>
                  </div>
                </td>
              </tr>
              <!-- Row 2 -->
              <tr class="hover:bg-surface-container-highest/50 transition-colors group">
                <td class="px-6 py-4">
                  <div class="w-14 h-14 rounded-lg bg-surface-container-highest overflow-hidden">
                    <img class="w-full h-full object-cover"
                      data-alt="colorful birds on board game cards with warm lighting and wooden tokens scattered around artistic tabletop game components"
                      src="https://lh3.googleusercontent.com/aida-public/AB6AXuAvZfZF8UB2VZ1mertM66apO12bWzu3cyRkhv7gbpWZgezSHdmEK7cBFBXJIl7k4FZg1lrLl68LDjlnB_dZsOAANfpFQqPYvQ9yz4QC0bWKl8h354bH_yYKDD62fH5_Wv8NYuMG72a2JiAwt8oHzc34HmqlYDAnS5VSFtmKSaScBtBe-vRZAU93keal451FOXsgRKjbHTbdjKh581ELsZuc2O1Q59iBL3mA7btu6e_x9F_rKsx8taFDgldsWZwYjg5w3PVimcZmcDE" />
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="flex flex-col">
                    <span class="font-bold text-on-surface text-lg">Wingspan</span>
                    <span class="text-xs text-on-surface-variant">ISBN: 978-01-9876-543</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span
                    class="px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold uppercase tracking-tighter">Family</span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-1.5 text-on-surface-variant">
                    <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                    <span class="text-sm font-medium">1 - 5</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-secondary-container text-secondary-fixed text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-secondary-fixed"></span>
                    In-Use
                  </div>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                      class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-primary transition-colors">
                      <span class="material-symbols-outlined" data-icon="edit">edit</span>
                    </button>
                    <button
                      class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-error transition-colors">
                      <span class="material-symbols-outlined" data-icon="delete">delete</span>
                    </button>
                  </div>
                </td>
              </tr>
              <!-- Row 3 -->
              <tr class="hover:bg-surface-container-highest/50 transition-colors group">
                <td class="px-6 py-4">
                  <div class="w-14 h-14 rounded-lg bg-surface-container-highest overflow-hidden">
                    <img class="w-full h-full object-cover"
                      data-alt="a dark medieval themed board game box featuring a dragon silhouette and golden embossed title text on black background"
                      src="https://lh3.googleusercontent.com/aida-public/AB6AXuCK7MzdqjHSnI0tORw15GJ5w-OZp_wVmzlQRF7xZNr2MHmqVFuyMWIln39YV4hZIwqtbXqjcQso7A1NXA1VF98OQ8HNax8fOXZVabnv89BCp5o-lFVbRRBnKADaqvtcPZyuO-H6frPgk_UkH2JFoWw-YrgO-AawCLYwwrpiGmtdxEJDNW4CUAVU2GofbLNq6hArHOQ3R0gy7gZ1pE_EM6Fhonmz6tVAVBizyaK9iBedl8ExgT0Zi1a1OC0VJZzORPKM4iuOTcroBNo" />
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="flex flex-col">
                    <span class="font-bold text-on-surface text-lg">Gloomhaven</span>
                    <span class="text-xs text-on-surface-variant">ISBN: 978-02-1111-222</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span
                    class="px-3 py-1 rounded-full bg-primary-container text-on-primary-container text-xs font-bold uppercase tracking-tighter">Strategy</span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-1.5 text-on-surface-variant">
                    <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                    <span class="text-sm font-medium">1 - 4</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-error-container text-on-error-container text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-on-error-container"></span>
                    Maintenance
                  </div>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                      class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-primary transition-colors">
                      <span class="material-symbols-outlined" data-icon="edit">edit</span>
                    </button>
                    <button
                      class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-error transition-colors">
                      <span class="material-symbols-outlined" data-icon="delete">delete</span>
                    </button>
                  </div>
                </td>
              </tr>
              <!-- Row 4 -->
              <tr class="hover:bg-surface-container-highest/50 transition-colors group">
                <td class="px-6 py-4">
                  <div class="w-14 h-14 rounded-lg bg-surface-container-highest overflow-hidden">
                    <img class="w-full h-full object-cover"
                      data-alt="vibrant colored plastic board game tokens and dice on a blue gaming surface with soft bokeh background"
                      src="https://lh3.googleusercontent.com/aida-public/AB6AXuDjnjtZWqBTm_k_KyGbATOwo04GwXBzWj-kFMpbVDvvce4mpWVyWoca3m8BoGNpN5RgloXRXgxs4s34v9qvO3XPHzQoXiLKk0COaqzAeKD6OHPHJ83SixttsWHeNc5i4HZAIvNY4hvhaydFAAdF0liTJQO27kAjyYf58kAS9QVbOrsd9cPqGClwZNaJIG2DH3flgC0eCKw4vXl1v8T3lmrTiInL-L2G_yI7vOlJ2Nbz8ZxqoZakfu_Jo4LKcVMVLnOfayySwS78t54" />
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="flex flex-col">
                    <span class="font-bold text-on-surface text-lg">Catan</span>
                    <span class="text-xs text-on-surface-variant">ISBN: 978-01-5555-444</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <span
                    class="px-3 py-1 rounded-full bg-secondary-container text-on-secondary-container text-xs font-bold uppercase tracking-tighter">Family</span>
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center gap-1.5 text-on-surface-variant">
                    <span class="material-symbols-outlined text-sm" data-icon="groups">groups</span>
                    <span class="text-sm font-medium">3 - 4</span>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-tertiary-container text-on-tertiary-container text-xs font-bold">
                    <span class="w-2 h-2 rounded-full bg-on-tertiary-container animate-pulse"></span>
                    Available
                  </div>
                </td>
                <td class="px-6 py-4 text-right">
                  <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                    <button
                      class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-primary transition-colors">
                      <span class="material-symbols-outlined" data-icon="edit">edit</span>
                    </button>
                    <button
                      class="p-2 rounded-lg hover:bg-surface-bright text-on-surface-variant hover:text-error transition-colors">
                      <span class="material-symbols-outlined" data-icon="delete">delete</span>
                    </button>
                  </div>
                </td>
              </tr>
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
            <span>Showing 1 to 10 of 148 entries</span>
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
    <footer
      class="w-full py-12 border-t border-[#b6a0ff]/10 flex flex-col items-center justify-center gap-6 bg-[#0e0e0e] font-['Inter'] text-sm">
      <div class="text-lg font-bold text-[#b6a0ff]">The Curated Playroom</div>
      <div class="flex gap-8">
        <a class="text-gray-500 hover:text-white transition-colors" href="#">Terms</a>
        <a class="text-gray-500 hover:text-white transition-colors" href="#">Privacy</a>
        <a class="text-gray-500 hover:text-white transition-colors" href="#">Careers</a>
        <a class="text-gray-500 hover:text-white transition-colors" href="#">Contact</a>
      </div>
      <div class="text-gray-500">© 2024 The Curated Playroom. Roll with intention.</div>
    </footer>
  </main>
</body>

</html>