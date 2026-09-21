<?php

include '../config/koneksi.php';


$koneksi_db = null;
if (isset($conn)) {
    $koneksi_db = $conn;
} elseif (isset($koneksi)) {
    $koneksi_db = $koneksi;
}

if (!$koneksi_db) {
    die("<div style='padding:2rem;'><h3 style='color:red;'>Koneksi Gagal!</h3></div>");
}


$total_penerima = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT COUNT(*) FROM PENERIMA"))[0] ?? 0;
$total_mitra    = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT COUNT(*) FROM MITRA"))[0] ?? 0;
$total_paket    = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT SUM(kuantitas) FROM PAKETBANTUAN"))[0] ?? 0;


$distribusi_selesai = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT COUNT(*) FROM DISTRIBUSI WHERE status_pengiriman IN ('Selesai', 'Diterima', 'Terkirim')"))[0] ?? 0;
$distribusi_proses  = mysqli_fetch_row(mysqli_query($koneksi_db, "SELECT COUNT(*) FROM DISTRIBUSI WHERE status_pengiriman NOT IN ('Selesai', 'Diterima', 'Terkirim')"))[0] ?? 0;

$data_chart = mysqli_query($koneksi_db, "
    SELECT DATE_FORMAT(tanggal_kirim, '%Y-%m') AS bulan, COUNT(*) AS total
    FROM DISTRIBUSI
    GROUP BY bulan
    ORDER BY bulan ASC
    LIMIT 12
");

$bulan = [];
$jumlah_distribusi = [];
while ($row = mysqli_fetch_assoc($data_chart)) {
    $bulan[] = date('M Y', strtotime($row['bulan'])); 
    $jumlah_distribusi[] = $row['total'];
}

$data_kategori = mysqli_query($koneksi_db, "
    SELECT kategori_penerima, COUNT(*) AS total
    FROM PENERIMA
    GROUP BY kategori_penerima
");

$label_kategori = [];
$total_kategori = [];
while ($row = mysqli_fetch_assoc($data_kategori)) {
    $label_kategori[] = $row['kategori_penerima'];
    $total_kategori[] = $row['total'];
}


$query_stok = mysqli_query($koneksi_db, "SELECT * FROM ITEM ORDER BY stok_gudang ASC LIMIT 5");
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Dashboard Laporan - MBG Workspace</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet"/>
    <script>
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

<div class="flex min-h-screen w-full">
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
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors" href="../index.php">
                    <span class="material-symbols-outlined text-[22px]">dashboard</span>
                    <p class="text-sm font-medium">Dashboard</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors" href="../mitra/index.php">
                    <span class="material-symbols-outlined text-[22px]">handshake</span>
                    <p class="text-sm font-medium">Mitra</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors" href="../user/index.php">
                    <span class="material-symbols-outlined text-[22px]">person</span>
                    <p class="text-sm font-medium">Pengguna</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors" href="../penerima/index.php">
                    <span class="material-symbols-outlined text-[22px]">groups</span>
                    <p class="text-sm font-medium">Penerima</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors" href="../paketbantuan/index.php">
                    <span class="material-symbols-outlined text-[22px]">inventory_2</span>
                    <p class="text-sm font-medium">Paket Bantuan</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors" href="../distribusi/index.php">
                    <span class="material-symbols-outlined text-[22px]">local_shipping</span>
                    <p class="text-sm font-medium">Distribusi</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-primary-50 text-primary-600 transition-colors" href="../laporandata/index.php">
                    <span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 1;">analytics</span>
                    <p class="text-sm font-semibold">Laporan Data</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors" href="../item/index.php">
                    <span class="material-symbols-outlined text-[22px]">warehouse</span>
                    <p class="text-sm font-medium">Gudang Item</p>
                </a>
            </nav>

            <button class="flex items-center justify-center gap-2 rounded-xl h-11 px-4 bg-slate-50 text-slate-600 hover:bg-red-50 hover:text-red-600 text-sm font-semibold transition-colors border border-slate-100">
                <span class="material-symbols-outlined text-[20px]">logout</span> Keluar
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        <header class="lg:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-slate-100">
            <h1 class="text-lg font-bold text-slate-900">MBG Workspace</h1>
            <span class="material-symbols-outlined">menu</span>
        </header>

        <div class="flex-1 p-6 lg:p-10 max-w-7xl mx-auto w-full">
            
            <div class="flex items-center gap-2 mb-2">
                <a class="text-slate-400 text-sm font-medium hover:text-primary-600 transition-colors" href="../index.php">Dashboard</a>
                <span class="text-slate-300 text-sm">/</span>
                <span class="text-slate-600 text-sm font-medium">Laporan Data</span>
            </div>

            <div class="flex flex-col gap-1 mb-8">
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Pusat Analitik & Laporan</h2>
                <p class="text-slate-500 mt-1 text-sm">Ringkasan metrik statistik dan performa program bantuan sosial.</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-10 rounded-xl bg-blue-50 text-blue-600"><span class="material-symbols-outlined text-[20px]">groups</span></div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Penerima</p>
                    </div>
                    <p class="text-3xl font-bold text-slate-900"><?= number_format($total_penerima) ?></p>
                </div>
                
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-10 rounded-xl bg-purple-50 text-purple-600"><span class="material-symbols-outlined text-[20px]">handshake</span></div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Mitra</p>
                    </div>
                    <p class="text-3xl font-bold text-slate-900"><?= number_format($total_mitra) ?></p>
                </div>
                
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-10 rounded-xl bg-indigo-50 text-indigo-600"><span class="material-symbols-outlined text-[20px]">inventory_2</span></div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Stok Paket</p>
                    </div>
                    <p class="text-3xl font-bold text-slate-900"><?= number_format($total_paket) ?></p>
                </div>
                
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-10 rounded-xl bg-emerald-50 text-emerald-600"><span class="material-symbols-outlined text-[20px]">check_circle</span></div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Selesai</p>
                    </div>
                    <p class="text-3xl font-bold text-slate-900"><?= number_format($distribusi_selesai) ?></p>
                </div>
                
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-slate-100 flex flex-col gap-3">
                    <div class="flex items-center gap-3">
                        <div class="flex items-center justify-center size-10 rounded-xl bg-amber-50 text-amber-600"><span class="material-symbols-outlined text-[20px]">pending</span></div>
                        <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Proses</p>
                    </div>
                    <p class="text-3xl font-bold text-slate-900"><?= number_format($distribusi_proses) ?></p>
                </div>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
                <!-- Line Chart -->
                <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                    <h3 class="text-base font-bold text-slate-900 mb-6">Tren Distribusi Bulanan</h3>
                    <div class="relative h-[280px] w-full"><canvas id="chartDistribusi"></canvas></div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col">
                    <h3 class="text-base font-bold text-slate-900 mb-6">Demografi Penerima</h3>
                    <div class="relative flex-1 w-full flex justify-center items-center min-h-[200px]"><canvas id="chartKategori"></canvas></div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-rose-500 text-[20px]">warning</span> Peringatan Stok Terendah
                        </h3>
                        <a href="../item/index.php" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors">Kelola Item &rarr;</a>
                    </div>
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Barang</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Tersedia</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php if(mysqli_num_rows($query_stok) > 0) {
                                    while ($item = mysqli_fetch_assoc($query_stok)) {
                                        $stok = $item['stok_gudang'];
                                        if ($stok == 0) {
                                            $status_badge = '<span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-rose-50 text-rose-600 ring-1 ring-inset ring-rose-500/20">Habis</span>';
                                        } elseif ($stok < 50) {
                                            $status_badge = '<span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-amber-50 text-amber-600 ring-1 ring-inset ring-amber-500/20">Menipis</span>';
                                        } else {
                                            $status_badge = '<span class="inline-flex items-center px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-500/20">Aman</span>';
                                        }
                                ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-5 py-3 text-sm font-semibold text-slate-800">
                                        <?= htmlspecialchars($item['nama_item']) ?>
                                        <span class="block text-xs text-slate-400 font-normal mt-0.5">Satuan: <?= htmlspecialchars($item['satuan']) ?></span>
                                    </td>
                                    <td class="px-5 py-3 text-sm font-bold text-slate-600"><?= number_format($stok) ?></td>
                                    <td class="px-5 py-3 text-right"><?= $status_badge ?></td>
                                </tr>
                                <?php 
                                    } 
                                } else { 
                                    echo "<tr><td colspan='3' class='px-5 py-8 text-center text-sm text-slate-400'>Belum ada data barang di gudang.</td></tr>";
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                    <div class="p-5 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                        <h3 class="text-sm font-bold text-slate-900 flex items-center gap-2">
                            <span class="material-symbols-outlined text-primary-500 text-[20px]">history</span> Aktivitas Distribusi Terbaru
                        </h3>
                        <a href="../distribusi/index.php" class="text-xs font-semibold text-primary-600 hover:text-primary-700 transition-colors">Lihat Semua &rarr;</a>
                    </div>
                    <div class="overflow-x-auto flex-1">
                        <table class="w-full text-left">
                            <thead class="bg-slate-50 border-b border-slate-100">
                                <tr>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Pengiriman</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider">Tanggal</th>
                                    <th class="px-5 py-3 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <?php
                                $latest = mysqli_query($koneksi_db, "
                                    SELECT d.distribusi_id, m.nama_mitra, r.nama_lengkap, d.tanggal_kirim, d.status_pengiriman
                                    FROM DISTRIBUSI d
                                    LEFT JOIN MITRA m ON d.mitra_id = m.mitra_id
                                    LEFT JOIN PENERIMA r ON d.penerima_id = r.penerima_id
                                    ORDER BY d.tanggal_kirim DESC
                                    LIMIT 5
                                ");
                                
                                if(mysqli_num_rows($latest) > 0){
                                    while ($row = mysqli_fetch_assoc($latest)) {
                                        $status = strtolower($row['status_pengiriman']);
                                        $badge_class = "bg-slate-50 text-slate-600 ring-slate-500/20";
                                        if(strpos($status, 'selesai')!==false || strpos($status, 'terkirim')!==false) $badge_class = "bg-emerald-50 text-emerald-600 ring-emerald-500/20";
                                        elseif(strpos($status, 'proses')!==false) $badge_class = "bg-amber-50 text-amber-600 ring-amber-500/20";
                                        elseif(strpos($status, 'gagal')!==false) $badge_class = "bg-rose-50 text-rose-600 ring-rose-500/20";
                                ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-5 py-3 text-sm">
                                        <p class="font-semibold text-slate-800">To: <?= htmlspecialchars($row['nama_lengkap']) ?></p>
                                        <p class="text-xs text-slate-500 mt-0.5">Via: <?= htmlspecialchars($row['nama_mitra']) ?> (#<?= $row['distribusi_id'] ?>)</p>
                                    </td>
                                    <td class="px-5 py-3 text-sm text-slate-500"><?= date('d M Y', strtotime($row['tanggal_kirim'])) ?></td>
                                    <td class="px-5 py-3 text-right">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider ring-1 ring-inset <?= $badge_class ?>">
                                            <?= htmlspecialchars($row['status_pengiriman']) ?>
                                        </span>
                                    </td>
                                </tr>
                                <?php 
                                    } 
                                } else {
                                    echo "<tr><td colspan='3' class='px-5 py-8 text-center text-sm text-slate-400'>Belum ada data distribusi terbaru.</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </main>
</div>

<script>
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#64748b'; 
    Chart.defaults.scale.grid.color = '#f1f5f9';
    
    const ctxLine = document.getElementById('chartDistribusi').getContext('2d');
    new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: <?= json_encode($bulan) ?>,
            datasets: [{
                label: 'Jumlah Distribusi',
                data: <?= json_encode($jumlah_distribusi) ?>,
                borderColor: '#0ea5e9',
                backgroundColor: 'rgba(14, 165, 233, 0.1)',
                borderWidth: 3,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#ffffff',
                pointBorderColor: '#0ea5e9',
                pointBorderWidth: 2,
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 12,
                    titleFont: { size: 13 },
                    bodyFont: { size: 14, weight: 'bold' }
                }
            },
            scales: {
                y: { beginAtZero: true, border: { dash: [4, 4] } },
                x: { grid: { display: false } }
            }
        }
    });

    const ctxPie = document.getElementById('chartKategori').getContext('2d');
    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($label_kategori) ?>,
            datasets: [{
                data: <?= json_encode($total_kategori) ?>,
                backgroundColor: [
                    '#0ea5e9', 
                    '#8b5cf6',
                    '#f59e0b', 
                    '#10b981', 
                    '#f43f5e'  
                ],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { 
                    position: 'bottom', 
                    labels: { usePointStyle: true, padding: 20, font: { size: 12 } } 
                },
                tooltip: {
                    backgroundColor: '#1e293b',
                    padding: 10
                }
            },
            cutout: '70%',
            layout: { padding: { bottom: 10 } }
        }
    });
</script>

</body>
</html>