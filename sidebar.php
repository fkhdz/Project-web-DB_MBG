<aside class="flex flex-col w-64 bg-white border-r border-slate-100 p-4 shrink-0 hidden lg:flex shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-10">
    <div class="flex flex-col h-full">
        <div class="flex items-center gap-3 px-3 py-4 mb-4 border-b border-slate-100">
            <div class="size-10 rounded-full ring-2 ring-slate-100 shadow-sm bg-cover bg-center" style="background-image: url('https://ui-avatars.com/api/?name=Admin+MBG&background=0ea5e9&color=fff');"></div>
            <div class="flex flex-col">
                <h1 class="text-slate-900 text-sm font-bold leading-tight">Administrator</h1>
                <p class="text-slate-500 text-xs mt-0.5">admin@portal.com</p>
            </div>
        </div>

        <nav class="flex flex-col gap-1.5 flex-grow">
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl <?= ($current_page == 'dashboard') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?> transition-colors" href="../index.php">
                <span class="material-symbols-outlined text-[22px]">dashboard</span> <p class="text-sm">Dashboard</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl <?= ($current_page == 'mitra') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?> transition-colors" href="../mitra/index.php">
                <span class="material-symbols-outlined text-[22px]">handshake</span> <p class="text-sm">Mitra</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl <?= ($current_page == 'user') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?> transition-colors" href="../user/index.php">
                <span class="material-symbols-outlined text-[22px]">person</span> <p class="text-sm">Pengguna</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl <?= ($current_page == 'penerima') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?> transition-colors" href="../penerima/index.php">
                <span class="material-symbols-outlined text-[22px]">groups</span> <p class="text-sm">Penerima</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl <?= ($current_page == 'paket') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?> transition-colors" href="../paketbantuan/index.php">
                <span class="material-symbols-outlined text-[22px]">inventory_2</span> <p class="text-sm">Paket Bantuan</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl <?= ($current_page == 'distribusi') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?> transition-colors" href="../distribusi/index.php">
                <span class="material-symbols-outlined text-[22px]">local_shipping</span> <p class="text-sm">Distribusi</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl <?= ($current_page == 'laporan') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?> transition-colors" href="../laporandata/index.php">
                <span class="material-symbols-outlined text-[22px]">analytics</span> <p class="text-sm">Laporan Data</p>
            </a>
            <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl <?= ($current_page == 'item') ? 'bg-primary-50 text-primary-600 font-semibold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' ?> transition-colors" href="../item/index.php">
                <span class="material-symbols-outlined text-[22px]">warehouse</span> <p class="text-sm">Gudang Item</p>
            </a>
        </nav>

        <button class="flex items-center justify-center gap-2 rounded-xl h-11 px-4 bg-slate-50 text-slate-600 hover:bg-red-50 hover:text-red-600 text-sm font-semibold transition-colors border border-slate-100">
            <span class="material-symbols-outlined text-[20px]">logout</span> Keluar
        </button>
    </div>
</aside>