<aside
    class="admin-sidebar h-screen w-64 fixed left-0 top-0 bg-[#131313] flex flex-col p-4 border-r border-[#b6a0ff]/5 shadow-2xl z-50 -translate-x-full lg:translate-x-0 transition-transform">
    <div class="mb-10 px-4 flex justify-between items-center">
        <div>
            <span class="text-xl font-black text-[#b6a0ff] font-headline tracking-tighter">Client Portal</span>
            <p class="text-[10px] text-gray-500 font-medium tracking-widest uppercase mt-1">Midnight Branch</p>
        </div>
        <button id="menu-close" class="lg:hidden text-on-surface-variant">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    <nav class="flex-1 space-y-2">
        <a class="flex items-center gap-3 bg-[#b6a0ff]/10 text-[#b6a0ff] rounded-lg px-4 py-3 transition-all active:translate-x-1 duration-150"
            href="dashboard_client.php">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-medium font-label">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 text-gray-500 px-4 py-3 transition-all hover:bg-[#1c1c1c] hover:text-[#b6a0ff] active:translate-x-1 duration-150"
            href="home.php">
            <span class="material-symbols-outlined">casino</span>
            <span class="font-medium font-label">Game Vault</span>
        </a>
    </nav>
    <div class="mt-auto space-y-2 border-t border-white/5 pt-4">
        <a class="flex items-center gap-3 text-gray-500 px-4 py-2 hover:text-[#b6a0ff] transition-colors" href="#">
            <span class="material-symbols-outlined">settings</span>
            <span class="text-sm font-label">Settings</span>
        </a>
        <a class="flex items-center gap-3 text-gray-500 px-4 py-2 hover:text-[#b6a0ff] transition-colors" href="#">
            <span class="material-symbols-outlined">help</span>
            <span class="text-sm font-label">Help</span>
        </a>
        <div class="flex items-center gap-3 px-4 pt-4 mt-4 border-t border-white/5">
            <img alt="Client profile" class="w-10 h-10 rounded-full border-2 border-primary/20"
                data-alt="Close-up portrait of a stylish young man with a friendly expression in soft urban lighting"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuCNJhCPpeFrLt59m2b2lVjHZLxPv54X62gzTLXPxfNL8JgAUqamtQYFXykw8sthIBXs2MtSf_8ZqaZEfxbrZqI9SI4eHmJeyajflvWm6A4xWr3DWBXwtnsRxpHfAPvXwIUJQVhdAVdQXuTI2od6p-EODXjPva2co8KHUR3elWZ8EU_WJvcIbSx9nVPOWBwPjWDF6zkqjtRgkdjqVA15psDzP_WSllu8SZnCnBfEvdcdRl5LQzqhBQ7jmZ1atRT2DAdUG9bWflpGSiQ" />
            <div class="overflow-hidden">
                <p class="text-xs font-bold truncate">Strategist</p>
                <p class="text-[10px] text-gray-500 truncate">Premium Member</p>
            </div>
        </div>
        <a class="flex items-center gap-3 px-4 py-2 text-gray-500 hover:text-error-dim transition-all rounded-lg"
            href="../auth/login.php">
            <span class="material-symbols-outlined">logout</span>
            <span class="font-medium text-sm">Log Out</span>
        </a>
    </div>
</aside>