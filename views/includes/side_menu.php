<aside
    class="admin-sidebar h-screen w-64 fixed left-0 top-0 bg-[#131313] flex flex-col p-4 border-r border-[#b6a0ff]/5 shadow-2xl z-50 -translate-x-full lg:translate-x-0 transition-transform">
    <div class="mb-10 px-4 flex justify-between items-center">
        <div>
            <span class="text-xl font-black text-[#b6a0ff] font-headline tracking-tighter">Admin Portal</span>
            <p class="text-[10px] text-gray-500 font-medium tracking-widest uppercase mt-1">Midnight Branch</p>
        </div>
        <button id="menu-close" class="lg:hidden text-on-surface-variant">
            <span class="material-symbols-outlined">close</span>
        </button>
    </div>
    <nav class="flex-1 space-y-2">
        <a class="flex items-center gap-3 bg-[#b6a0ff]/10 text-[#b6a0ff] rounded-lg px-4 py-3 transition-all active:translate-x-1 duration-150"
            href="/dashboard/Aji_nl3bou/dashboard/admin">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="font-medium font-label">Dashboard</span>
        </a>
        <a class="flex items-center gap-3 text-gray-500 px-4 py-3 transition-all hover:bg-[#1c1c1c] hover:text-[#b6a0ff] active:translate-x-1 duration-150"
            href="/dashboard/Aji_nl3bou/inventory">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="font-medium font-label">Inventory</span>
        </a>
        <a class="flex items-center gap-3 text-gray-500 px-4 py-3 transition-all hover:bg-[#1c1c1c] hover:text-[#b6a0ff] active:translate-x-1 duration-150"
            href="/dashboard/Aji_nl3bou/reservations">
            <span class="material-symbols-outlined">event_available</span>
            <span class="font-medium font-label">Reservations</span>
        </a>
    </nav>
    <div class="mt-auto space-y-2 border-t border-white/5 pt-4">
        <a href="/dashboard/Aji_nl3bou/reservations/add">
            <button
                class="w-full bg-gradient-to-b from-primary to-primary-dim text-on-primary font-bold py-3 rounded-xl shadow-lg shadow-primary/20 hover:shadow-primary/40 transition-all active:scale-95 mb-4">
                New Reservation
            </button>
        </a>
        <a class="flex items-center gap-3 text-gray-500 px-4 py-2 hover:text-[#b6a0ff] transition-colors" href="/dashboard/Aji_nl3bou/logout">
            <span class="material-symbols-outlined">logout</span>
            <span class="text-sm font-label">Logout</span>
        </a>
        <div class="flex items-center gap-3 px-4 pt-4 mt-4 border-t border-white/5">
            <img alt="Admin profile" class="w-10 h-10 rounded-full border-2 border-primary/20"
                data-alt="close-up portrait of a professional male manager with short dark hair in a modern workspace setting"
                src="https://lh3.googleusercontent.com/aida-public/AB6AXuBa9aSVm88nzr1MuCQ4OqdWqgd0CtypeDb4Tb8GroOFk5O9wPagkCasebtNbRJ7OTyqbHEpNrm7Pkjaz5-X3wyzbQr7pij8EaBPh02vlrpzzaKFHnL90v5ddPMdPjWPoju6--qHC1ox-iXSPUUzyjOYVHGziRVzkSt_0Z9KRmSnQ9fDgp36aAeU9adhrVUcUeiy7wGKTn4UK6E4QufY2dAw01cQac4noMSwV2SNGEVo_vucJQemAybUwG6YWxFGrzX-HLff9Beaxpc" />
            <div class="overflow-hidden">
                <p class="text-xs font-bold truncate">Alex Rivera</p>
                <p class="text-[10px] text-gray-500 truncate">Senior Manager</p>
            </div>
        </div>
    </div>
</aside>