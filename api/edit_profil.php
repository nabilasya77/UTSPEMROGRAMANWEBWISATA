<?php
require 'koneksi.php';


if (!isset($_COOKIE['login'])) {
    header("Location: login.php");
    exit;
}

$email_user = $_COOKIE['email'];

$query = mysqli_query($koneksi, "SELECT * FROM users WHERE email = '$email_user'");
$data_user = mysqli_fetch_assoc($query);

// Update profil
if (isset($_POST['update'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $password_baru = $_POST['password'];

    if (!empty($password_baru)) {
        $password_hash = password_hash($password_baru, PASSWORD_DEFAULT);
        $update_query = "UPDATE users SET nama = '$nama', password = '$password_hash' WHERE email = '$email_user'";
    } else {
        $update_query = "UPDATE users SET nama = '$nama' WHERE email = '$email_user'";
    }

    if (mysqli_query($koneksi, $update_query)) {


        setcookie("nama", $nama, time() + 3600, "/");

        echo "<script>alert('Profil berhasil diperbarui!'); window.location='profil.php';</script>";
    } else {
        echo "<script>alert('Gagal update profil');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - Wisata Wonogiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 p-4">
                    <h3 class="fw-bold mb-4 text-center text-primary-dark">Edit Profil</h3>
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data_user['nama']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold">Email</label>
                            <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($data_user['email']); ?>" readonly>
                            <small class="text-danger">*Email tidak dapat diubah</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted fw-bold">Ganti Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Ketik password baru jika ingin diganti...">
                            <small class="text-muted">*Kosongkan jika tidak ingin mengganti password</small>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="update" class="btn btn-primary fw-bold"><i class="fa-solid fa-floppy-disk me-2"></i>Simpan Perubahan</button>
                            <a href="profil.php" class="btn btn-outline-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>