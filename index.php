<?php 
include "config/koneksi.php"; 

$koneksi_db = null;
if (isset($conn)) $koneksi_db = $conn;
elseif (isset($koneksi)) $koneksi_db = $koneksi;

if (!$koneksi_db) {
    die("<div style='padding:2rem; font-family:sans-serif;'><h3 style='color:red;'>Koneksi Gagal!</h3><p>Pastikan file <code>config/koneksi.php</code> ada dan mendefinisikan variabel koneksi.</p></div>");
}

$query_penerima = mysqli_query($koneksi_db, "SELECT COUNT(*) as total FROM PENERIMA");
$stats_penerima = ($query_penerima) ? mysqli_fetch_assoc($query_penerima)['total'] : 0;

$query_total_dist = mysqli_query($koneksi_db, "SELECT COUNT(*) as total FROM DISTRIBUSI");
$total_distribusi = ($query_total_dist) ? mysqli_fetch_assoc($query_total_dist)['total'] : 0;

$query_selesai = mysqli_query($koneksi_db, "SELECT COUNT(*) as total FROM DISTRIBUSI WHERE status_pengiriman IN ('Selesai', 'Terkirim', 'Diterima')");
$jumlah_selesai = ($query_selesai) ? mysqli_fetch_assoc($query_selesai)['total'] : 0;
$stats_distribusi_count = ($total_distribusi > 0) ? $jumlah_selesai : 0;

$query_pending = mysqli_query($koneksi_db, "SELECT COUNT(*) as total FROM DISTRIBUSI WHERE status_pengiriman IN ('Pending', 'Diproses', 'Gagal', 'Retur')");
$stats_pending = ($query_pending) ? mysqli_fetch_assoc($query_pending)['total'] : 0;


date_default_timezone_set('Asia/Jakarta');
$hour = date('H');
if ($hour < 11) $greeting = "Selamat Pagi";
elseif ($hour < 15) $greeting = "Selamat Siang";
elseif ($hour < 18) $greeting = "Selamat Sore";
else $greeting = "Selamat Malam";
?>
<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Command Center - MBG</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ["Inter", "sans-serif"] },
                    colors: {
                        primary: { 50: '#f0f9ff', 100: '#e0f2fe', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1' },
                        surface: '#f8fafc'
                    }
                }
            }
        }
    </script>
</head>
<body class="font-sans bg-surface text-slate-800 antialiased selection:bg-primary-100 selection:text-primary-700">


<header class="sticky top-0 z-30 bg-white/80 backdrop-blur-md border-b border-slate-200 px-6 py-3 flex items-center justify-between shadow-sm">
    <div class="flex items-center gap-3">
        <div class="flex items-center justify-center size-9 rounded-xl bg-gradient-to-br from-primary-500 to-primary-700 text-white shadow-md">
            <span class="material-symbols-outlined text-xl">dataset</span>
        </div>
        <h1 class="text-xl font-bold text-slate-900 tracking-tight">MBG <span class="text-primary-600 font-medium">Workspace</span></h1>
    </div>
    <div class="flex items-center gap-4">
        <button class="relative p-2 text-slate-500 hover:text-primary-600 transition-colors rounded-full hover:bg-primary-50">
            <span class="material-symbols-outlined">notifications</span>
            <?php if($stats_pending > 0): ?>
                <span class="absolute top-1.5 right-1.5 size-2.5 bg-red-500 rounded-full ring-2 ring-white animate-pulse"></span>
            <?php endif; ?>
        </button>
        <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
            <div class="text-right hidden sm:block">
                <p class="text-sm font-semibold text-slate-900 leading-none">Admin System</p>
                <p class="text-xs text-slate-500 mt-1">Administrator</p>
            </div>
            <div class="size-10 rounded-full ring-2 ring-slate-100 shadow-sm bg-cover bg-center" style='background-image: url("https://ui-avatars.com/api/?name=Admin+MBG&background=0ea5e9&color=fff");'></div>
        </div>
    </div>
</header>

<main class="max-w-[1400px] mx-auto px-6 py-8">
    
    
    <div class="mb-8 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h2 class="text-3xl font-bold text-slate-900 tracking-tight"><?= $greeting ?>, Admin! 👋</h2>
            <p class="text-slate-500 mt-1.5 text-lg">Berikut adalah ringkasan operasional distribusi bantuan hari ini.</p>
        </div>
        <a href="distribusi/create.php" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-lg font-medium transition-colors shadow-sm hover:shadow">
            <span class="material-symbols-outlined text-lg">add</span> Buat Distribusi Baru
        </a>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-blue-200 transition-colors">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Total Penerima Aktif</p>
                <p class="text-3xl font-bold text-slate-900"><?= number_format($stats_penerima) ?></p>
            </div>
            <div class="size-14 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-3xl">groups</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-emerald-200 transition-colors">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Distribusi Sukses</p>
                <p class="text-3xl font-bold text-slate-900"><?= number_format($stats_distribusi_count) ?></p>
            </div>
            <div class="size-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-3xl">task_alt</span>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center justify-between group hover:border-amber-200 transition-colors">
            <div>
                <p class="text-sm font-medium text-slate-500 mb-1">Menunggu Tindakan</p>
                <div class="flex items-center gap-3">
                    <p class="text-3xl font-bold text-slate-900"><?= number_format($stats_pending) ?></p>
                    <?php if($stats_pending > 0): ?>
                        <span class="flex h-3 w-3 relative">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-3 w-3 bg-amber-500"></span>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="size-14 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center group-hover:scale-110 transition-transform">
                <span class="material-symbols-outlined text-3xl">hourglass_top</span>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Area Grafik (Placeholder Visual) -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Tren Distribusi Bulan Ini</h3>
                    <button class="text-sm font-medium text-primary-600 hover:text-primary-700">Lihat Detail Laporan &rarr;</button>
                </div>
                
                <div class="h-48 w-full flex items-end justify-between gap-2 px-2 pb-2 border-b border-slate-100">
                    <div class="w-full bg-primary-100 rounded-t-md relative group hover:bg-primary-200 transition-colors" style="height: 40%">
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Minggu 1</span>
                    </div>
                    <div class="w-full bg-primary-300 rounded-t-md relative group hover:bg-primary-400 transition-colors" style="height: 70%">
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Minggu 2</span>
                    </div>
                    <div class="w-full bg-primary-500 rounded-t-md relative group hover:bg-primary-600 transition-colors" style="height: 55%">
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Minggu 3</span>
                    </div>
                    <div class="w-full bg-primary-600 rounded-t-md relative group hover:bg-primary-700 transition-colors" style="height: 90%">
                        <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity">Minggu 4</span>
                    </div>
                </div>
            </div>

            
            <div>
                <h3 class="text-lg font-bold text-slate-900 mb-4">Modul Sistem</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <?php
                    $menus = [
                        ['title' => 'Manajemen Distribusi', 'desc' => 'Atur rute dan jadwal pengiriman', 'icon' => 'local_shipping', 'link' => 'distribusi/index.php'],
                        ['title' => 'Data Penerima', 'desc' => 'Validasi KPM & dokumen', 'icon' => 'contact_page', 'link' => 'penerima/index.php'],
                        ['title' => 'Stok Paket Bantuan', 'desc' => 'Katalog dan ketersediaan paket', 'icon' => 'inventory_2', 'link' => 'paketbantuan/index.php'],
                        ['title' => 'Gudang Item', 'desc' => 'Inventaris fisik barang', 'icon' => 'warehouse', 'link' => 'item/index.php'],
                        ['title' => 'Jejaring Mitra', 'desc' => 'Vendor dan pihak ketiga', 'icon' => 'handshake', 'link' => 'mitra/index.php'],
                        ['title' => 'Pengaturan Admin', 'desc' => 'Otorisasi dan akses sistem', 'icon' => 'admin_panel_settings', 'link' => 'user/index.php']
                    ];
                    foreach ($menus as $menu): ?>
                    <a href="<?= $menu['link'] ?>" class="group bg-white p-5 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:border-primary-200 transition-all duration-200 flex items-start gap-4">
                        <div class="flex items-center justify-center size-12 rounded-xl bg-slate-50 text-slate-400 group-hover:bg-primary-50 group-hover:text-primary-600 transition-colors shrink-0">
                            <span class="material-symbols-outlined text-2xl"><?= $menu['icon'] ?></span>
                        </div>
                        <div>
                            <h4 class="text-base font-bold text-slate-900 group-hover:text-primary-600 transition-colors"><?= $menu['title'] ?></h4>
                            <p class="text-sm text-slate-500 mt-1 leading-relaxed"><?= $menu['desc'] ?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sticky top-24">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold text-slate-900">Aktivitas Terakhir</h3>
                    <span class="material-symbols-outlined text-slate-400">history</span>
                </div>
                
                
                <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                    
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 size-4 bg-emerald-500 rounded-full border-4 border-white"></div>
                        <p class="text-sm font-semibold text-slate-900">Distribusi Selesai</p>
                        <p class="text-sm text-slate-500 mt-0.5">Paket #PKT-092 berhasil dikirim ke Desa Mekarsari.</p>
                        <p class="text-xs text-slate-400 mt-1.5">10 menit yang lalu</p>
                    </div>

                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 size-4 bg-blue-500 rounded-full border-4 border-white"></div>
                        <p class="text-sm font-semibold text-slate-900">Data Penerima Baru</p>
                        <p class="text-sm text-slate-500 mt-0.5">Admin menambahkan 15 KPM baru ke dalam sistem.</p>
                        <p class="text-xs text-slate-400 mt-1.5">1 jam yang lalu</p>
                    </div>

                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 size-4 bg-amber-500 rounded-full border-4 border-white"></div>
                        <p class="text-sm font-semibold text-slate-900">Stok Menipis</p>
                        <p class="text-sm text-slate-500 mt-0.5">Stok 'Beras 5kg' tersisa kurang dari 20 unit di gudang.</p>
                        <p class="text-xs text-slate-400 mt-1.5">3 jam yang lalu</p>
                    </div>
                    
                    <div class="relative pl-6">
                        <div class="absolute -left-[9px] top-1 size-4 bg-slate-300 rounded-full border-4 border-white"></div>
                        <p class="text-sm font-semibold text-slate-900">Login Sistem</p>
                        <p class="text-sm text-slate-500 mt-0.5">Sesi baru dimulai oleh Admin MBG.</p>
                        <p class="text-xs text-slate-400 mt-1.5">Hari ini, 08:15 WIB</p>
                    </div>

                </div>

                <a href="laporandata/index.php" class="mt-8 block w-full py-2.5 px-4 bg-slate-50 hover:bg-slate-100 text-slate-600 text-sm font-semibold text-center rounded-lg transition-colors">
                    Lihat Semua Log Aktivitas
                </a>
            </div>
        </div>

    </div>
</main>

</body>
</html>