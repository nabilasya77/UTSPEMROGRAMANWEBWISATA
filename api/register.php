<?php
require 'koneksi.php';

$login = $_COOKIE['login'] ?? null;

if ($login) {
    header("Location: home.php");
    exit;
}
if (isset($_POST['register'])) {
   
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    
    if ($password !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak sesuai!";
    } else {
        // 2. Cek apakah email sudah terdaftar sebelumnya
        $cek_email = mysqli_query($koneksi, "SELECT email FROM users WHERE email = '$email'");
        if (mysqli_num_rows($cek_email) > 0) {
            $error = "Email sudah terdaftar! Silakan gunakan email lain atau login.";
        } else {
            // 3. Enkripsi password (Wajib agar bisa login dengan password_verify di login.php)
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            
            // 4. Set role default sebagai 'user'
            $role = 'user';

            // 5. Masukkan data ke database
            $query_insert = "INSERT INTO users (nama, email, password, role) VALUES ('$nama', '$email', '$password_hash', '$role')";
            
            if (mysqli_query($koneksi, $query_insert)) {
                // Jika berhasil, munculkan alert dan arahkan ke login.php
                echo "<script>
                        alert('Registrasi berhasil! Silakan login.');
                        window.location.href = 'login.php';
                      </script>";
                exit;
            } else {
                $error = "Terjadi kesalahan! Gagal mendaftarkan akun.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">
    <div class="container">
        <div class="card mx-auto shadow border-0" style="max-width: 450px; border-radius: 15px;">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <h3 class="fw-bold" style="color: #112a46;">Daftar Akun Baru</h3>
                    <p class="text-muted">Bergabunglah untuk menjelajahi Wisata Wonogiri</p>
                </div>
                
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?= $error; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" placeholder="Masukkan nama Anda" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="nama@email.com" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label text-muted fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Buat password" required minlength="6">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label text-muted fw-bold">Konfirmasi Password</label>
                        <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi password" required minlength="6">
                    </div>
                    
                    <button type="submit" name="register" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 10px;">Daftar Sekarang</button>
                </form>

                <div class="text-center mt-4">
                    <p class="mb-0 text-muted">Sudah punya akun? <a href="login.php" class="text-primary fw-bold text-decoration-none">Login di sini</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>