<?php
session_start();

$notifikasi = "";

/* Ambil data dari cookie jika ada */
$nama_cookie  = $_COOKIE['nama'] ?? '';
$email_cookie = $_COOKIE['email'] ?? '';

/* Cek apakah user sudah login */
$login = isset($_SESSION['login']);

/* Ambil nama & email user */
$nama  = $_SESSION['nama'] ?? $nama_cookie ?? '';
$email = $_SESSION['email'] ?? $email_cookie ?? '';

/* Proses kirim pesan */
if (isset($_POST['kirim_pesan'])) {
    $nama  = htmlspecialchars($_POST['nama']);
    $email = htmlspecialchars($_POST['email']);
    $pesan = htmlspecialchars($_POST['pesan']);

    $notifikasi = "
    <div class='alert alert-success alert-dismissible fade show shadow-sm mb-4' role='alert'>
        <i class='fa-solid fa-circle-check me-2'></i>
        <strong>Berhasil!</strong> Terima kasih <strong>$nama</strong>, pesan Anda telah kami terima.
        <button type='button' class='btn-close' data-bs-dismiss='alert'></button>
    </div>";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak - Wisata Wonogiri</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .btn-rounded {
            border-radius: 20px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark shadow-sm sticky-top" style="background-color: #112a46;">
    <div class="container">
        <a class="navbar-brand fw-bold" href="home.php">
            <i class="fa-solid fa-map-location-dot me-2"></i>
            Wisata Wonogiri
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav ms-auto align-items-center">

                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="tentang.php">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link active" href="kontak.php">Kontak</a>
                </li>

                <?php if ($login): ?>
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="btn btn-primary dropdown-toggle rounded-pill px-4"
                           href="#"
                           data-bs-toggle="dropdown">
                            <i class="fa-solid fa-circle-user me-2"></i>
                            Halo, <?= htmlspecialchars($nama ?: 'Pengguna'); ?>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="profil.php">
                                    Profil Saya
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="logout.php">
                                    Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="btn btn-primary rounded-pill ms-lg-3 px-4" href="login.php">
                            Login
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>

<!-- CONTENT -->
<div class="container my-5 flex-grow-1">
    <h2 class="text-center fw-bold mb-5" style="color: #112a46;">
        Hubungi Kami
    </h2>

    <div class="row bg-white shadow-sm p-4 p-md-5 rounded-4 mx-auto" style="max-width: 1000px;">

        <!-- NOTIFIKASI -->
        <div class="col-12">
            <?= $notifikasi; ?>
        </div>

        <!-- INFORMASI KONTAK -->
        <div class="col-md-5 mb-4 mb-md-0 pe-md-5">

            <h4 class="fw-bold mb-4">Informasi Kontak</h4>

            <p class="text-muted mb-4">
                Punya pertanyaan seputar destinasi wisata Wonogiri?
                Jangan ragu untuk menghubungi tim kami melalui kontak di bawah ini.
            </p>

            <ul class="list-unstyled">
                <li class="mb-3 d-flex align-items-center">
                    <i class="fa-solid fa-location-dot fs-5 text-primary me-3"></i>
                    <span class="text-muted">
                        Jl. Pemuda No. 12, Wonogiri, Jawa Tengah
                    </span>
                </li>

                <li class="mb-3 d-flex align-items-center">
                    <i class="fa-solid fa-phone fs-5 text-primary me-3"></i>
                    <span class="text-muted">
                        +62 813 1112 2223
                    </span>
                </li>

                <li class="mb-3 d-flex align-items-center">
                    <i class="fa-solid fa-envelope fs-5 text-primary me-3"></i>
                    <span class="text-muted">
                        info@wisatawonogiri.com
                    </span>
                </li>
            </ul>

            <h5 class="fw-bold mt-5 mb-3">Ikuti Kami</h5>

            <div class="d-flex gap-3">
                <a href="#" class="btn btn-outline-primary rounded-circle">
                    <i class="fa-brands fa-instagram"></i>
                </a>

                <a href="#" class="btn btn-outline-primary rounded-circle">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>

                <a href="#" class="btn btn-outline-primary rounded-circle">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>

        <!-- FORM KONTAK -->
        <div class="col-md-7 ps-md-5 mt-4 mt-md-0">

            <h4 class="fw-bold mb-4">Kirim Pesan</h4>

            <form method="POST" action="">

                <div class="mb-3">
                    <label class="form-label text-muted">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        name="nama"
                        class="form-control"
                        value="<?= htmlspecialchars($nama); ?>"
                        <?= $login ? 'readonly' : ''; ?>
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">
                        Email
                    </label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="<?= htmlspecialchars($email); ?>"
                        <?= $login ? 'readonly' : ''; ?>
                        required
                    >
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted">
                        Pesan
                    </label>

                    <textarea
                        name="pesan"
                        class="form-control"
                        rows="5"
                        placeholder="Tulis pesan, kritik, atau saran di sini..."
                        required
                    ></textarea>
                </div>

                <button
                    type="submit"
                    name="kirim_pesan"
                    class="btn btn-primary px-5">
                    Kirim Pesan
                </button>

            </form>
        </div>
    </div>
</div>

<!-- FOOTER -->
<footer class="text-white text-center py-4 mt-auto" style="background-color: #112a46;">
    <p class="mb-0">
        © <?= date('Y'); ?> Destinasi Wisata Wonogiri. All rights reserved.
    </p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>