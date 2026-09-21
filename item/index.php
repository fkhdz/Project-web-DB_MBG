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
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Gudang Logistik - MBG Workspace</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors" href="../laporandata/index.php">
                    <span class="material-symbols-outlined text-[22px]">analytics</span>
                    <p class="text-sm font-medium">Laporan Data</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-primary-50 text-primary-600 transition-colors" href="../item/index.php">
                    <span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 1;">warehouse</span>
                    <p class="text-sm font-semibold">Gudang Item</p>
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
                <span class="text-slate-600 text-sm font-medium">Gudang Item</span>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Manajemen Gudang Item</h2>
                    <p class="text-slate-500 mt-1.5 text-sm">Kelola inventaris barang mentah dan ketersediaan stok fisik.</p>
                </div>
                <div class="flex gap-2">
                    <a href="../paketbantuan/index.php" class="inline-flex items-center gap-2 bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">inventory_2</span> Paket Bantuan
                    </a>
                    <a href="create.php" class="inline-flex items-center gap-2 bg-primary-600 hover:bg-primary-700 text-white px-5 py-2.5 rounded-xl text-sm font-medium transition-all shadow-sm hover:shadow">
                        <span class="material-symbols-outlined text-[20px]">add</span> Tambah Item
                    </a>
                </div>
            </div>

            <?php if (isset($_GET['msg'])) : ?>
                <div class="mb-6">
                    <?php if ($_GET['msg'] == 'deleted') : ?>
                        <div class="flex items-center gap-3 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-100/50 shadow-sm" role="alert">
                            <span class="material-symbols-outlined text-emerald-500">check_circle</span>
                            <div class="text-sm font-semibold">Berhasil! Data item berhasil dihapus.</div>
                        </div>
                    <?php elseif ($_GET['msg'] == 'error') : ?>
                        <div class="flex items-center gap-3 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100/50 shadow-sm" role="alert">
                            <span class="material-symbols-outlined text-red-500">error</span>
                            <div class="text-sm font-semibold">Gagal! Data tidak dapat dihapus karena masih digunakan pada paket bantuan.</div>
                        </div>
                    <?php elseif ($_GET['msg'] == 'updated') : ?>
                        <div class="flex items-center gap-3 p-4 bg-primary-50 text-primary-700 rounded-xl border border-primary-100/50 shadow-sm" role="alert">
                            <span class="material-symbols-outlined text-primary-500">info</span>
                            <div class="text-sm font-semibold">Berhasil! Data stok item berhasil diperbarui.</div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <div class="relative w-full max-w-md">
                        <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-[20px]">search</span>
                        <input type="text" class="w-full pl-10 pr-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all placeholder:text-slate-400 shadow-sm" placeholder="Cari nama barang atau satuan..."/>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100">
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider w-16">No</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Detail Item</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Stok Gudang</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Status Ketersediaan</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">

                        <?php
                        $no = 1;
                        $query = mysqli_query($koneksi_db, "SELECT * FROM ITEM ORDER BY item_id DESC");

                        if (mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) : 
                                $stok = $row['stok_gudang'];
                                
                                if ($stok == 0) {
                                    $badge_class = "bg-rose-50 text-rose-600 ring-1 ring-inset ring-rose-500/20";
                                    $status_text = "Habis";
                                    $icon = "warning";
                                } elseif ($stok < 50) {
                                    $badge_class = "bg-amber-50 text-amber-600 ring-1 ring-inset ring-amber-500/20";
                                    $status_text = "Menipis";
                                    $icon = "error";
                                } else {
                                    $badge_class = "bg-emerald-50 text-emerald-600 ring-1 ring-inset ring-emerald-500/20";
                                    $status_text = "Aman";
                                    $icon = "check_circle";
                                }
                        ?>
                            <tr class="hover:bg-slate-50/50 transition-colors group">
                                <td class="px-6 py-4 text-sm font-medium text-slate-400"><?= $no++ ?></td>
                                <td class="px-6 py-4">
                                    <p class="text-sm font-bold text-slate-900"><?= htmlspecialchars($row['nama_item']) ?></p>
                                    <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                                        <span class="material-symbols-outlined text-[14px]">category</span>
                                        Satuan: <?= htmlspecialchars($row['satuan']) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-lg font-black <?= $stok == 0 ? 'text-rose-600' : 'text-slate-700' ?>">
                                        <?= number_format($stok) ?>
                                    </p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold uppercase tracking-wide <?= $badge_class ?>">
                                        <span class="material-symbols-outlined text-[14px]"><?= $icon ?></span>
                                        <?= $status_text ?>
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="update.php?id=<?= $row['item_id'] ?>" class="flex items-center justify-center size-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-primary-600 hover:border-primary-200 hover:bg-primary-50 transition-all shadow-sm" title="Edit Stok/Item">
                                            <span class="material-symbols-outlined text-[18px]">edit</span>
                                        </a>
                                        <a href="delete.php?id=<?= $row['item_id'] ?>" onclick="return confirm('Hapus item ini dari gudang?')" class="flex items-center justify-center size-8 rounded-lg bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 transition-all shadow-sm" title="Hapus">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php 
                            endwhile; 
                        } else {
                        ?>
                            <tr>
                                <td colspan="5" class="text-center py-12">
                                    <div class="flex flex-col items-center justify-center">
                                        <span class="material-symbols-outlined text-4xl text-slate-300 mb-3">category</span>
                                        <p class="text-slate-500 text-sm font-medium">Gudang kosong. Belum ada item yang ditambahkan.</p>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>

                        </tbody>
                    </table>
                </div>
                
                <div class="px-6 py-4 border-t border-slate-100 flex items-center justify-between bg-slate-50/50">
                    <p class="text-xs text-slate-500 font-medium">Menampilkan seluruh inventaris gudang</p>
                </div>

            </div>
        </div>
    </main>
</div>
</body>
</html>