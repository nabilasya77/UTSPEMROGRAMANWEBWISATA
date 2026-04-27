<?php
require 'koneksi.php';

$login = $_COOKIE['login'] ?? null;
$role  = $_COOKIE['role'] ?? null;

if (!$login || $role !== 'admin') {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$query_ambil = mysqli_query($koneksi, "SELECT * FROM destinasi WHERE id = '$id'");
$data = mysqli_fetch_assoc($query_ambil);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Edit Wisata</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="card shadow-sm mx-auto" style="max-width: 800px;">
            <div class="card-header bg-warning text-dark fw-bold">Edit Data Wisata</div>
            <div class="card-body p-4">
                <form action="proses_edit.php" method="POST">
                    <input type="hidden" name="id" value="<?= $data['id']; ?>">
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Wisata</label>
                            <input type="text" name="nama" class="form-control" value="<?= $data['nama']; ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lokasi</label>
                            <input type="text" name="lokasi" class="form-control" value="<?= $data['lokasi']; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" rows="4" required><?= $data['deskripsi']; ?></textarea>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Fasilitas</label>
                            <input type="text" name="fasilitas" class="form-control" value="<?= $data['fasilitas']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">URL Gambar</label>
                            <input type="url" name="gambar" class="form-control" value="<?= $data['gambar']; ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">URL Rute (Maps)</label>
                            <input type="url" name="rute" class="form-control" value="<?= $data['rute']; ?>" required>
                        </div>
                    </div>
                    <a href="admin_wisata.php" class="btn btn-secondary px-4">Batal</a>
                    <button type="submit" name="update" class="btn btn-warning px-4 fw-bold">Update Data</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>