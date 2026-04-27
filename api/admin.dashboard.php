<?php
require 'koneksi.php';

// Cek login & role (lebih aman: cek semua dulu)
if (
    !isset($_COOKIE['login']) ||
    !isset($_COOKIE['role']) ||
    $_COOKIE['role'] !== 'admin'
) {
    echo "<script>alert('Akses Ditolak!'); window.location='login.php';</script>";
    exit;
}

// Ambil nama dari cookie (fallback)
$nama = $_COOKIE['nama'] ?? 'Admin';

// Ambil data (cukup sekali)
$jml_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM users WHERE role='user'"))['total'];
$jml_admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM users WHERE role='admin'"))['total'];
$jml_wisata = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM destinasi"))['total'];

// API BPS (pakai timeout biar tidak lemot)
$url_bps = "https://webapi.bps.go.id/v1/api/list/model/data/lang/ind/domain/3312/var/574/th/126/key/d3e573a5bfa1b72f6faa5adc3dc920cb";

$context = stream_context_create([
    'http' => ['timeout' => 5]
]);

$response_bps = @file_get_contents($url_bps, false, $context);

$total_bps = 0;
if ($response_bps !== FALSE) {
    $data_bps = json_decode($response_bps, true);
    if (isset($data_bps['datacontent'])) {
        foreach ($data_bps['datacontent'] as $value) {
            $total_bps += (float)$value;
        }
        $total_bps = number_format($total_bps, 0, ',', '.'); 
    } else {
        $total_bps = "0";
    }
} else {
    $total_bps = "Error API";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="admin_dashboard.php">
            <i class="fa-solid fa-shield-halved me-2"></i>Admin Panel
        </a>

        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="home.php" target="_blank">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_wisata.php">Wisata</a></li>
                <li class="nav-item"><a class="nav-link" href="admin_users.php">Users</a></li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="fa-solid fa-user-circle me-1"></i>
                        <?= htmlspecialchars($nama); ?>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger fw-bold" href="logout.php">Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container my-5">
    <h2>Selamat datang, Admin <?= htmlspecialchars($nama); ?>!</h2>

    <div class="row mt-4">
        <div class="col-md-3 mb-3">
            <div class="card bg-primary text-white text-center p-4 shadow h-100">
                <h3><?= $jml_wisata; ?></h3>
                <p>Total Wisata</p>
                <a href="admin_wisata.php" class="btn btn-light btn-sm mt-2">Kelola Wisata</a>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-success text-white text-center p-4 shadow h-100">
                <h3><?= $jml_user; ?></h3>
                <p>Total User</p>
                <a href="admin_users.php" class="btn btn-light btn-sm mt-2">Kelola Akun</a>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-danger text-white text-center p-4 shadow h-100">
                <h3><?= $jml_admin; ?></h3>
                <p>Total Admin</p>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card bg-info text-white text-center p-4 shadow h-100">
                <h3><?= $total_bps; ?></h3>
                <p>Data BPS Wisatawan</p>
                <small class="text-white-50">Source: webapi.bps.go.id</small>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>