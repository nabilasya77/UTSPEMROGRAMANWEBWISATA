<?php
// File: admin.dashboard.php
session_start();
require 'koneksi.php';


echo $_SESSION['role'];
exit();

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses Ditolak!'); window.location='login.php';</script>";
    exit;
}

// Hitung data untuk statistik
$jml_user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM users WHERE role = 'user'"))['total'];
$jml_admin = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM users WHERE role = 'admin'"))['total'];
$jml_wisata = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM destinasi"))['total'];


$url_bps = "https://webapi.bps.go.id/v1/api/list/model/data/lang/ind/domain/3312/var/574/th/126/key/d3e573a5bfa1b72f6faa5adc3dc920cb";
$response_bps = @file_get_contents($url_bps);

$total_bps = 0;
if ($response_bps !== FALSE) {
    $data_bps = json_decode($response_bps, true);
    if (isset($data_bps['datacontent'])) {
        foreach ($data_bps['datacontent'] as $key => $value) {
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
            <a class="navbar-brand fw-bold" href="admin.dashboard.php"><i class="fa-solid fa-shield-halved me-2"></i>Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="home.php" target="_blank">home</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_wisata.php">Wisata</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin_users.php">Users</a></li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fa-solid fa-user-circle me-1"></i> <?= htmlspecialchars($_SESSION['nama'] ?? 'Admin'); ?>
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
        <h2>Selamat datang, Admin <?= htmlspecialchars($_SESSION['nama'] ?? ''); ?>!</h2>
        <div class="row mt-4">
            <div class="col-md-3 mb-3">
                <div class="card bg-primary text-white text-center p-4 shadow h-100">
                    <h3><?= $jml_wisata; ?></h3><p class="mb-0">Total Wisata</p>
                    <a href="admin_wisata.php" class="btn btn-light btn-sm mt-3 fw-bold">Kelola Wisata</a>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-success text-white text-center p-4 shadow h-100">
                    <h3><?= $jml_user; ?></h3><p class="mb-0">Total User</p>
                    <a href="admin_users.php" class="btn btn-light btn-sm mt-3 fw-bold">Kelola Akun</a>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-danger text-white text-center p-4 shadow h-100">
                    <h3><?= $jml_admin; ?></h3><p class="mb-0">Total Admin</p>
                    <div class="mt-3"></div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card bg-info text-white text-center p-4 shadow h-100">
                    <h3><?= $total_bps; ?></h3><p class="mb-0">Data BPS Wisatawan</p>
                    <div class="mt-auto pt-2">
                        <small class="text-white-50"><i class="fa-solid fa-database"></i> Source: webapi.bps.go.id</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>