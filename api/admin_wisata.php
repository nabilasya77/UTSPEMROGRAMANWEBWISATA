<?php
require 'koneksi.php';

$login = $_COOKIE['login'] ?? null;
$role  = $_COOKIE['role'] ?? null;

if (!$login || $role !== 'admin') {
    header("Location: login.php");
    exit;
}

$destinasi = mysqli_query($koneksi, "SELECT * FROM destinasi ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Wisata - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container my-5">
        <a href="home.php" class="btn btn-secondary mb-4 shadow-sm">
          <i class="fa-solid fa-house me-2"></i>Kembali ke Home
        </a>

        <div class="card shadow-sm p-4 mb-4">
            <h4 class="fw-bold mb-3"><i class="fa-solid fa-map-location-dot me-2"></i>Tambah Wisata</h4>
            <form action="proses_tambah.php" method="POST">
                <div class="row mb-3">
                    <div class="col-md-6"><input type="text" name="nama" class="form-control" placeholder="Nama Wisata" required></div>
                    <div class="col-md-6"><input type="text" name="lokasi" class="form-control" placeholder="Lokasi (Kecamatan)" required></div>
                </div>
                <textarea name="deskripsi" class="form-control mb-3" rows="3" placeholder="Deskripsi Singkat" required></textarea>
                <div class="row mb-3">
                    <div class="col-md-4"><input type="text" name="fasilitas" class="form-control" placeholder="Fasilitas (Pisahkan dgn koma)" required></div>
                    <div class="col-md-4"><input type="url" name="gambar" class="form-control" placeholder="URL Gambar" required></div>
                    <div class="col-md-4"><input type="url" name="rute" class="form-control" placeholder="URL Google Maps" required></div>
                </div>
                <button type="submit" name="tambah" class="btn btn-primary"><i class="fa-solid fa-plus me-2"></i>Tambah Data</button>
            </form>
        </div>

        <div class="card shadow-sm p-4">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Wisata</th>
                            <th>Lokasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($destinasi) > 0): ?>
                            <?php $no = 1; while ($row = mysqli_fetch_assoc($destinasi)): ?>
                            <tr>
                                <td class="text-center"><?= $no++; ?></td>
                                <td class="fw-bold"><?= $row['nama']; ?></td>
                                <td><?= $row['lokasi']; ?></td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="admin_edit_wisata.php?id=<?= $row['id']; ?>" class="btn btn-warning btn-sm text-dark fw-bold">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>
                                        <a href="proses_hapus.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus wisata ini?')">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="4" class="text-center">Belum ada data destinasi.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
</html>