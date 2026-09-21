<?php
// 1. Integrasi Koneksi Database
include "../config/koneksi.php";

// Fix variabel koneksi
$koneksi_db = null;
if (isset($conn)) $koneksi_db = $conn;
elseif (isset($koneksi)) $koneksi_db = $koneksi;

if (!$koneksi_db) {
    die("<div style='padding:2rem;'><h3 style='color:red;'>Koneksi Gagal!</h3></div>");
}

// 2. Logika Simpan Data (Sesuaikan nama kolom dengan struktur tabel Anda)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $paket_id = $_POST['paket_id'];
    $penerima_id = $_POST['penerima_id'];
    $mitra_id = $_POST['mitra_id'];
    $tanggal_kirim = $_POST['tanggal_kirim'];
    $tanggal_terima = $_POST['tanggal_terima'] ?: NULL;
    $lokasi_pengiriman = $_POST['lokasi_pengiriman'];
    $status_pengiriman = $_POST['status_pengiriman'];
    // Untuk file bukti pengiriman, Anda perlu menambahkan logika upload file di sini

    // Contoh Query Insert (Sesuaikan dengan nama tabel dan kolom di database Anda)
    $query_insert = "INSERT INTO DISTRIBUSI (paket_id, penerima_id, mitra_id, tanggal_kirim, tanggal_terima, lokasi_pengiriman, status_pengiriman) 
                     VALUES ('$paket_id', '$penerima_id', '$mitra_id', '$tanggal_kirim', " . ($tanggal_terima ? "'$tanggal_terima'" : "NULL") . ", '$lokasi_pengiriman', '$status_pengiriman')";
    
    if (mysqli_query($koneksi_db, $query_insert)) {
        header("Location: index.php?msg=created");
        exit();
    } else {
        $error_msg = "Gagal menambahkan data: " . mysqli_error($koneksi_db);
    }
}
?>

<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>Tambah Distribusi - MBG Workspace</title>
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

    <!-- SIDEBAR TEMA BARU (Sama dengan halaman index lainnya) -->
    <aside class="flex flex-col w-64 bg-white border-r border-slate-100 p-4 shrink-0 hidden lg:flex shadow-[4px_0_24px_rgba(0,0,0,0.02)] z-10">
        <div class="flex flex-col h-full">
            <!-- Profil Admin -->
            <div class="flex items-center gap-3 px-3 py-4 mb-4 border-b border-slate-100">
                <div class="size-10 rounded-full ring-2 ring-slate-100 shadow-sm bg-cover bg-center" style="background-image: url('https://ui-avatars.com/api/?name=Admin+MBG&background=0ea5e9&color=fff');"></div>
                <div class="flex flex-col">
                    <h1 class="text-slate-900 text-sm font-bold leading-tight">Administrator</h1>
                    <p class="text-slate-500 text-xs mt-0.5">admin@portal.com</p>
                </div>
            </div>

            <!-- Navigasi -->
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
                <!-- Menu Distribusi Aktif -->
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-primary-50 text-primary-600 transition-colors" href="index.php">
                    <span class="material-symbols-outlined text-[22px]" style="font-variation-settings: 'FILL' 1;">local_shipping</span>
                    <p class="text-sm font-semibold">Distribusi</p>
                </a>
                <a class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors" href="../laporandata/index.php">
                    <span class="material-symbols-outlined text-[22px]">analytics</span>
                    <p class="text-sm font-medium">Laporan Data</p>
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

    <!-- KONTEN UTAMA -->
    <main class="flex-1 flex flex-col h-screen overflow-y-auto">
        
        <header class="lg:hidden flex items-center justify-between px-6 py-4 bg-white border-b border-slate-100">
            <h1 class="text-lg font-bold text-slate-900">MBG Workspace</h1>
            <span class="material-symbols-outlined">menu</span>
        </header>

        <div class="flex-1 p-6 lg:p-10 max-w-4xl mx-auto w-full">
            
            <!-- Breadcrumb -->
            <div class="flex items-center gap-2 mb-2">
                <a class="text-slate-400 text-sm font-medium hover:text-primary-600 transition-colors" href="index.php">Distribusi</a>
                <span class="text-slate-300 text-sm">/</span>
                <span class="text-slate-600 text-sm font-medium">Tambah Distribusi</span>
            </div>

            <!-- Page Header -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight">Tambah Distribusi</h2>
                <p class="text-slate-500 mt-1.5 text-sm">Lengkapi detail di bawah ini untuk menambahkan data pengiriman bantuan baru.</p>
            </div>

            <?php if(isset($error_msg)): ?>
                <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-100/50 shadow-sm flex items-center gap-3">
                    <span class="material-symbols-outlined text-red-500">error</span>
                    <p class="text-sm font-semibold"><?= $error_msg ?></p>
                </div>
            <?php endif; ?>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 sm:p-8">
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="space-y-6">
                        
                        <!-- Pilihan Paket -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Paket Bantuan</label>
                            <div class="relative">
                                <select name="paket_id" required class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all appearance-none cursor-pointer">
                                    <option value="">-- Pilih Paket --</option>
                                    <?php
                                    $paket_q = mysqli_query($koneksi_db, "SELECT * FROM PAKETBANTUAN");
                                    while($p = mysqli_fetch_assoc($paket_q)){
                                        echo "<option value='{$p['paket_id']}'>{$p['nama_paket']} - {$p['jenis_bantuan']}</option>";
                                    }
                                    ?>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Baris: Penerima & Mitra -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Penerima</label>
                                <div class="relative">
                                    <select name="penerima_id" required class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all appearance-none cursor-pointer">
                                        <option value="">-- Pilih Penerima --</option>
                                        <?php
                                        $penerima_q = mysqli_query($koneksi_db, "SELECT * FROM PENERIMA");
                                        while($r = mysqli_fetch_assoc($penerima_q)){
                                            echo "<option value='{$r['penerima_id']}'>{$r['nama_lengkap']} ({$r['kategori_penerima']})</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Mitra Penyalur</label>
                                <div class="relative">
                                    <select name="mitra_id" required class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all appearance-none cursor-pointer">
                                        <option value="">-- Pilih Mitra --</option>
                                        <?php
                                        $mitra_q = mysqli_query($koneksi_db, "SELECT * FROM MITRA");
                                        while($m = mysqli_fetch_assoc($mitra_q)){
                                            echo "<option value='{$m['mitra_id']}'>{$m['nama_mitra']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                                </div>
                            </div>
                        </div>

                        <!-- Baris: Tanggal Kirim & Terima -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Kirim</label>
                                <input type="date" name="tanggal_kirim" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all"/>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Terima <span class="text-slate-400 font-normal">(Opsional)</span></label>
                                <input type="date" name="tanggal_terima" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all"/>
                            </div>
                        </div>

                        <!-- Lokasi Pengiriman -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Lokasi Pengiriman</label>
                            <input type="text" name="lokasi_pengiriman" required placeholder="Masukkan alamat lengkap pengiriman" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all placeholder:text-slate-400"/>
                        </div>

                        <!-- Status Pengiriman -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Status Pengiriman</label>
                            <div class="relative">
                                <select name="status_pengiriman" required class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-900 focus:outline-none focus:border-primary-500 focus:ring-1 focus:ring-primary-500 transition-all appearance-none cursor-pointer">
                                    <option value="Dikemas">Dikemas</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Proses">Dalam Proses</option>
                                    <option value="Dikirim">Dikirim</option>
                                    <option value="Terkirim">Terkirim</option>
                                    <option value="Selesai">Selesai</option>
                                    <option value="Gagal">Gagal</option>
                                </select>
                                <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">expand_more</span>
                            </div>
                        </div>

                        <!-- Bukti Pengiriman -->
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Bukti Pengiriman <span class="text-slate-400 font-normal">(Opsional)</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl bg-slate-50 hover:bg-slate-100 transition-colors">
                                <div class="space-y-1 text-center">
                                    <span class="material-symbols-outlined text-4xl text-slate-400 mb-2">cloud_upload</span>
                                    <div class="flex text-sm text-slate-600 justify-center">
                                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none px-2 py-0.5 shadow-sm ring-1 ring-slate-200">
                                            <span>Unggah file</span>
                                            <input id="file-upload" name="bukti_pengiriman" type="file" class="sr-only">
                                        </label>
                                        <p class="pl-1">atau seret dan lepas</p>
                                    </div>
                                    <p class="text-xs text-slate-500">PNG, JPG, PDF hingga 5MB</p>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                        <a href="index.php" class="px-5 py-2.5 text-sm font-semibold text-slate-600 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Batal</a>
                        <button type="submit" class="px-5 py-2.5 text-sm font-semibold text-white bg-primary-600 rounded-xl hover:bg-primary-700 transition-colors shadow-sm flex items-center gap-2">
                            <span class="material-symbols-outlined text-[18px]">save</span> Simpan Distribusi
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </main>
</div>

<script>
    // Script interaktif sederhana untuk menampilkan nama file yang diunggah
    document.getElementById('file-upload').addEventListener('change', function(e) {
        var fileName = e.target.files[0].name;
        var label = this.nextElementSibling;
        label.innerText = fileName;
        label.classList.add('text-primary-600', 'font-semibold');
    });
</script>

</body>
</html>