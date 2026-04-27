<?php
$login = $_COOKIE['login'] ?? null;
$nama  = $_COOKIE['nama'] ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang - Wisata Wonogiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; display: flex; flex-direction: column; min-height: 100vh; }
        .about-header { background: linear-gradient(rgba(17, 42, 70, 0.9), rgba(17, 42, 70, 0.9)), url('https://asset.kompas.com/crops/c77BE3vztV_nZbuGYC9o8g2zK_E=/0x0:0x0/750x500/data/photo/2024/01/27/65b5229440479.jpg') center/cover; padding: 80px 0; color: white; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background-color: #112a46;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="home.php"><i class="fa-solid fa-map-location-dot me-2"></i>Wisata Wonogiri</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="menu">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="tentang.php">Tentang</a></li>
                    <li class="nav-item"><a class="nav-link" href="kontak.php">Kontak</a></li>
                    
                    <?php if (isset($_SESSION['login'])): ?>
                        <li class="nav-item dropdown ms-lg-3">
                            <a class="btn btn-primary dropdown-toggle rounded-pill px-4" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fa-solid fa-circle-user me-2"></i>Halo, <?= htmlspecialchars($_SESSION['nama'] ?? 'Pengguna'); ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                                <li><a class="dropdown-item" href="profil.php"><i class="fa-solid fa-user me-2"></i>Profil Saya</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger fw-bold" href="logout.php"><i class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item"><a class="btn btn-primary rounded-pill ms-lg-3 px-4" href="login.php">Login</a></li>
                    <?php endif; ?>
                    
                </ul>
            </div>
        </div>
    </nav>

    <header class="about-header text-center">
        <div class="container">
            <h1 class="display-5 fw-bold mb-3">Tentang Wisata Wonogiri</h1>
            <p class="lead">Wonogiri menyimpan banyak keindahan alam yang belum banyak orang tahu di Jawa Tengah.</p>
        </div>
    </header>

    <div class="container my-5 flex-grow-1">
        <div class="row align-items-center mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <img src="https://ik.imagekit.io/tvlk/blog/2024/07/shutterstock_2487276609.jpg" class="img-fluid rounded shadow" alt="Pemandangan Wonogiri">
            </div>
            <div class="col-lg-6 px-lg-5">
                <h3 class="fw-bold mb-3" style="color: #112a46;">Kenapa Harus Wonogiri?</h3>
                <p class="text-muted" style="line-height: 1.8;">
                    Wonogiri tidak hanya terkenal dengan Waduk Gajah Mungkur. Di sini juga ada banyak tempat menarik yang bisa dikunjungi. Mulai dari pantai berpasir putih di bagian selatan, perbukitan yang indah, sampai kuliner khas yang enak seperti Nasi Tiwul dan Bakso Wonogiri yang sudah terkenal.
                </p>
                <p class="text-muted" style="line-height: 1.8;">
                   Website ini dibuat untuk membantu wisatawan menemukan tempat wisata di Wonogiri.
                </p>
            </div>
        </div>

        <div class="row text-center mt-5">
            <div class="col-md-4 mb-4">
                <i class="fa-solid fa-mountain-sun fa-3x mb-3" style="color: #1a73e8;"></i>
                <h5 class="fw-bold">Wisata Alam</h5>
                <p class="text-muted">Nikmati keindahan alam seperti pantai, air terjun, dan perbukitan yang menenangkan.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fa-solid fa-bowl-food fa-3x mb-3" style="color: #1a73e8;"></i>
                <h5 class="fw-bold">Wisata Kuliner</h5>
                <p class="text-muted">Coba berbagai makanan khas Wonogiri yang memiliki rasa khas dan lezat.</p>
            </div>
            <div class="col-md-4 mb-4">
                <i class="fa-solid fa-camera-retro fa-3x mb-3" style="color: #1a73e8;"></i>
                <h5 class="fw-bold">Spot Foto</h5>
                <p class="text-muted">Temukan tempat-tempat menarik yang cocok untuk berfoto dan mengabadikan momen.</p>
            </div>
        </div>
    </div>

    <footer class="text-white text-center py-4 mt-auto" style="background-color: #112a46;">
        <p class="mb-0">© <?= date('Y'); ?> Destinasi Wisata Wonogiri. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>