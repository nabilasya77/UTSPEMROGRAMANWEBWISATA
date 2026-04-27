<?php
session_start(); 
require 'koneksi.php'; 

// Ambil data destinasi dari DATABASE
$query_wisata = mysqli_query($koneksi, "SELECT * FROM destinasi ORDER BY id DESC");
$destinasi = [];
while ($row = mysqli_fetch_assoc($query_wisata)) {
    $row['fasilitas_array'] = explode(',', $row['fasilitas']); 
    $destinasi[] = $row;
}

// Logika Simpan Buku Tamu
$notif = "";
if (isset($_POST['kirim_pesan'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $pesan = mysqli_real_escape_string($koneksi, $_POST['pesan']);
    
    $query = "INSERT INTO buku_tamu (nama, pesan) VALUES ('$nama', '$pesan')";
    if (mysqli_query($koneksi, $query)) {
        $notif = "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                    Pesan berhasil dikirim! Terima kasih.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
    } else {
        $notif = "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                    Gagal mengirim pesan.
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                  </div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jelajah Wisata Wonogiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        .hero-section {
            background: linear-gradient(rgba(17, 42, 70, 0.8), rgba(17, 42, 70, 0.8)), url('https://asset.kompas.com/crops/c77BE3vztV_nZbuGYC9o8g2zK_E=/0x0:0x0/750x500/data/photo/2024/01/27/65b5229440479.jpg') center/cover;
            padding: 80px 0;
            color: white;
        }
        
        .wisata-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border-radius: 12px; overflow: hidden; }
        .wisata-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important; }
        .card-img-top { height: 200px; object-fit: cover; }
        .badge-fasilitas { background-color: #e8f0fe; color: #1a73e8; font-weight: 500; margin-bottom: 5px; margin-right: 5px; }
        .btn-rounded { border-radius: 20px; }

        / --- STYLE KHUSUS KARTU STATISTIK BPS --- /
        .bps-stats-container { display: flex; justify-content: center; margin-bottom: 3rem; }
        .bps-card {
            background: linear-gradient(135deg, #112a46 0%, #1a73e8 100%);
            border-radius: 20px; padding: 40px; color: white; display: flex;
            align-items: center; gap: 30px; position: relative; overflow: hidden;
            width: 100%; box-shadow: 0 10px 20px rgba(17, 42, 70, 0.2);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .bps-card:hover { transform: translateY(-5px); box-shadow: 0 15px 30px rgba(26, 115, 232, 0.4); }
        .bps-icon-box {
            background: rgba(255, 255, 255, 0.15); padding: 25px; border-radius: 50%;
            z-index: 2; backdrop-filter: blur(10px); border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .bps-content { z-index: 2; }
        .bps-title { font-weight: 800; margin-bottom: 5px; letter-spacing: 0.5px; color: #e8f0fe; }
        .bps-subtitle { font-size: 0.95rem; opacity: 0.8; margin-bottom: 10px; }
        .bps-number {
            font-size: 3.5rem; font-weight: 900; text-shadow: 0 4px 15px rgba(0,0,0,0.3);
            color: #ffca28; line-height: 1;
        }
        .bps-unit { font-size: 1.2rem; font-weight: 600; opacity: 0.9; margin-left: 8px; }
        .bps-chart-bg { position: absolute; right: -20px; bottom: -40px; opacity: 0.08; z-index: 1; transform: rotate(-10deg); }
        @media (max-width: 768px) {
            .bps-card { flex-direction: column; text-align: center; padding: 30px; }
            .bps-number { font-size: 2.5rem; }
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top" style="background-color: #112a46;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="home.php"><i class="fa-solid fa-map-location-dot me-2"></i>Wisata Wonogiri</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link active" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="tentang.php">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                    
                    <?php if (isset($_SESSION['login'])): ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="btn btn-primary dropdown-toggle btn-rounded px-4" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-circle-user me-2"></i><?= htmlspecialchars($_SESSION['nama']); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="profil.php"><i class="fa-solid fa-user me-2"></i>Profil Saya</a></li>
                                
                                <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><h6 class="dropdown-header">Menu Pengelola</h6></li>
                                    <li><a class="dropdown-item" href="admin_users.php"><i class="fa-solid fa-users-gear me-2"></i>Kelola Akun</a></li>
                                    <li><a class="dropdown-item" href="admin_wisata.php"><i class="fa-solid fa-pen-to-square me-2"></i>Kelola Wisata</a></li>
                                <?php endif; ?>

                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-bold" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="btn btn-primary btn-rounded ms-lg-3 px-4" href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-3">Eksplorasi Wonogiri</h1>
            <p class="lead mb-4">Temukan informasi lokasi dan fasilitas wisata terbaik di Wonogiri</p>
            
            <div class="card p-3 shadow-lg mx-auto" style="max-width: 800px; border-radius: 15px;">
                <div class="row g-2">
                    <div class="col-md-7">
                        <input type="text" class="form-control form-control-lg border-0 bg-light" id="searchInput" placeholder="Cari destinasi atau lokasi..." onkeyup="filterWisata()">
                    </div>
                    <div class="col-md-5">
                        <select class="form-select form-select-lg border-0 bg-light" id="filterFasilitas" onchange="filterWisata()">
                            <option value="semua">Semua Fasilitas</option>
                            <option value="parkir">Parkir</option>
                            <option value="toilet">Toilet</option>
                            <option value="mushola">Mushola</option>
                            <option value="warung">Warung Makan</option>
                            <option value="spot foto">Spot Foto</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="container my-5">
        
        <div class="row">
            <div class="col-12 bps-stats-container">
                <div class="bps-card">
                    <div class="bps-icon-box d-none d-md-block">
                        <i class="fa-solid fa-users-viewfinder fa-3x text-white"></i>
                    </div>
                    <div class="bps-content">
                        <h4 class="bps-title">Statistik Kunjungan Wisata</h4>
                        <p class="bps-subtitle">Total Jumlah Perjalanan Wisatawan Nusantara Tujuan Kabupaten Wonogiri tercatat menurut data BPS</p>
                        <div class="bps-number-wrapper">
                            <span id="animated-bps-number" class="bps-number">0</span>
                            <span class="bps-unit">Perjalanan</span>
                        </div>
                    </div>
                    <div class="bps-chart-bg">
                        <i class="fa-solid fa-earth-asia fa-10x"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-4 border-start border-primary border-4 ps-3">
            <h3 class="fw-bold mb-0" style="color: #112a46;">🌴 Daftar Tempat Wisata</h3>
            
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                <a href="admin_wisata.php" class="btn btn-success fw-bold shadow-sm"><i class="fa-solid fa-plus me-2"></i>Tambah Wisata</a>
            <?php endif; ?>
        </div>

        <div class="row g-4" id="wisataGrid">
            <?php if (empty($destinasi)): ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">Belum ada data wisata.</p>
                </div>
            <?php else: ?>
                <?php foreach ($destinasi as $item): ?>
                <div class="col-md-6 col-lg-4 wisata-card-wrapper" data-fasilitas="<?= strtolower($item['fasilitas']); ?>">
                    <div class="card h-100 shadow-sm border-0 wisata-card">
                        <img src="<?= htmlspecialchars($item['gambar']); ?>" class="card-img-top" alt="<?= htmlspecialchars($item['nama']); ?>">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold" style="color: #112a46;"><?= htmlspecialchars($item['nama']); ?></h5>
                            <p class="card-text text-muted flex-grow-1" style="font-size: 14px;"><?= htmlspecialchars($item['deskripsi']); ?></p>
                            <div>
                                <?php foreach ($item['fasilitas_array'] as $f): ?>
                                    <span class="badge badge-fasilitas"><?= trim(htmlspecialchars($f)); ?></span>
                                <?php endforeach; ?>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mt-3 border-top pt-3">
                                <small class="text-muted lokasi-text"><i class="fa-solid fa-location-dot text-danger"></i> <?= htmlspecialchars($item['lokasi']); ?></small>
                                <a href="<?= htmlspecialchars($item['rute']); ?>" target="_blank" class="btn btn-outline-primary btn-sm">📍 Lihat Rute</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <div class="row mt-5 pt-5" id="buku-tamu">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm border-0" style="background-color: #e8f0fe; border-radius: 15px;">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-4 text-center" style="color: #1a73e8;">📝 Buku Tamu Wisatawan</h4>
                        <?= $notif; ?>
                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda..." required 
                                       value="<?= isset($_SESSION['nama']) ? htmlspecialchars($_SESSION['nama']) : ''; ?>"
                                       <?= isset($_SESSION['nama']) ? 'readonly' : ''; ?>>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold">Pesan / Kesan</label>
                                <textarea name="pesan" class="form-control" rows="4" placeholder="Apa pendapatmu tentang wisata Wonogiri?" required></textarea>
                            </div>
                            <button type="submit" name="kirim_pesan" class="btn btn-primary w-100 py-2 fw-bold shadow">Kirim Pesan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-4 mt-5" style="background-color: #112a46;">
        <p class="mb-0">© <?= date('Y'); ?> Destinasi Wisata Wonogiri. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // SCRIPT AJAX BPS DENGAN ANIMASI COUNTING UP
        async function fetchAndAnimateBpsData() {
            const numberElement = document.getElementById('animated-bps-number');
            
            try {
                const response = await fetch('get_alamat.php');
                const data = await response.json();

                if (data.datacontent) {
                    let totalWisatawan = 0;
                    for (let key in data.datacontent) {
                        totalWisatawan += parseFloat(data.datacontent[key]);
                    }
                    
                    // Panggil fungsi animasi (dari 0 menuju total, durasi 2 detik / 2000 ms)
                    animateValue("animated-bps-number", 0, totalWisatawan, 2000);
                } else {
                    numberElement.innerText = "-";
                }
            } catch (error) {
                console.error('Error fetching BPS data:', error);
                numberElement.innerText = "Error";
            }
        }

        // Fungsi untuk membuat animasi angka berjalan naik
        function animateValue(id, start, end, duration) {
            let obj = document.getElementById(id);
            let range = end - start;
            let minTimer = 50; 
            let stepTime = Math.abs(Math.floor(duration / range));
            stepTime = Math.max(stepTime, minTimer);
            let startTime = new Date().getTime();
            let endTime = startTime + duration;
            let timer;

            function run() {
                let now = new Date().getTime();
                let remaining = Math.max((endTime - now) / duration, 0);
                let value = Math.round(end - (remaining * range));
                obj.innerHTML = value.toLocaleString('id-ID'); // Format titik ribuan
                if (value == end) {
                    clearInterval(timer);
                }
            }
            timer = setInterval(run, stepTime);
            run();
        }

        // Panggil fungsinya saat DOM HTML selesai dimuat
        document.addEventListener('DOMContentLoaded', fetchAndAnimateBpsData);

        // Fungsi filter fasilitas / pencarian teks wisata
        function filterWisata() {
            let searchInput = document.getElementById("searchInput").value.toLowerCase();
            let filterFasilitas = document.getElementById("filterFasilitas").value.toLowerCase();
            let wrappers = document.getElementsByClassName("wisata-card-wrapper");

            for (let i = 0; i < wrappers.length; i++) {
                let wrapper = wrappers[i];
                let title = wrapper.querySelector(".card-title").innerText.toLowerCase();
                let lokasi = wrapper.querySelector(".lokasi-text").innerText.toLowerCase();
                let fasilitas = wrapper.getAttribute("data-fasilitas").toLowerCase();

                let matchSearch = title.includes(searchInput) || lokasi.includes(searchInput);
                let matchFilter = (filterFasilitas === "semua") || fasilitas.includes(filterFasilitas);

                wrapper.style.display = (matchSearch && matchFilter) ? "block" : "none";
            }
        }
    </script>
</body>
</html>