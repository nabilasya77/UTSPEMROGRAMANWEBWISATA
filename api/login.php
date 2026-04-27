<?php
require 'koneksi.php';

header('Content-Type: application/json');

$email = $_POST['email'] ?? '';
$pass  = $_POST['password'] ?? '';

$result = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email'");

if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    if (password_verify($pass, $row['password'])) {

        echo json_encode([
            "status" => "success",
            "user" => [
                "nama" => $row['nama'],
                "email" => $row['email'],
                "role" => $row['role']
            ]
        ]);
        exit;
    }
}

echo json_encode([
    "status" => "error",
    "message" => "Email atau password salah"
]);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Wisata Wonogiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="height: 100vh;">
    <div class="container">
        <div class="card mx-auto shadow" style="max-width: 400px; border-radius: 15px;">
            <div class="card-body p-4 text-center">
                <h3 class="fw-bold mb-4" style="color: #112a46;">Login</h3>
                
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger" role="alert">
                        Email atau Password Salah!
                    </div>
                <?php endif; ?>

                <form method="POST">
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Masukkan Email" required>
                    </div>
                    <div class="mb-4">
                        <input type="password" name="password" class="form-control" placeholder="Masukkan Password" required>
                    </div>
                    <button type="submit" name="login" class="btn w-100 fw-bold text-white mb-3" style="background-color: #498edd;">Masuk</button>
                    
                    <a href="api/index.html" class="text-decoration-none text-muted"><small>Kembali ke Halaman Awal</small></a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>