<?php
require 'koneksi.php'; 

// 🔥 CEK COOKIE
if (!isset($_COOKIE['login'])) {
    header("Location: login.php");
    exit;
}

$email_user = $_COOKIE['email'];

// ambil data user dari DB
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email_user'");
$data_user = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Saya - Wisata Wonogiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; min-height: 100vh; }
        .profile-card { border-radius: 15px; overflow: hidden; border: none; }
        .profile-header { background-color: #112a46; height: 100px; }
        .profile-pic { width: 100px; height: 100px; background: white; border-radius: 50%; margin-top: -50px; display: flex; align-items: center; justify-content: center; font-size: 40px; color: #112a46; border: 4px solid white; }
    </style>
</head>
<body>

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm profile-card">
                    <div class="profile-header"></div>
                    <div class="card-body text-center pb-5">
                        <div class="d-flex justify-content-center">
                            <div class="profile-pic shadow-sm">
                                <i class="fa-solid fa-user"></i>
                            </div>
                        </div>
                        <h3 class="fw-bold mt-3"><?= htmlspecialchars($data_user['nama']); ?></h3>
                        <p class="text-muted mb-4"><i class="fa-solid fa-envelope me-2"></i><?= htmlspecialchars($data_user['email']); ?></p>
                        
                        <div class="d-grid gap-2 col-8 mx-auto">
                            <a href="home.php" class="btn btn-secondary fw-bold">
                                <i class="fa-solid fa-house me-2"></i>Kembali ke Home
                            </a>
                            
                            <a href="edit_profil.php" class="btn btn-outline-primary">
                                <i class="fa-solid fa-pen-to-square me-2"></i>Edit Profil
                            </a>
                            
                            <a href="logout.php" class="btn btn-danger fw-bold">
                                <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>