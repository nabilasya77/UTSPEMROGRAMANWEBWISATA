<?php
require 'koneksi.php';

$login = $_COOKIE['login'] ?? null;
$role  = $_COOKIE['role'] ?? null;
$email_login = $_COOKIE['email'] ?? null;

if (!$login || $role !== 'admin') {
    header("Location: login.php");
    exit;
}
// Logika Ubah Role
if (isset($_GET['ubah_role_id']) && isset($_GET['role_baru'])) {
    $id_ubah = $_GET['ubah_role_id'];
    $role_baru = $_GET['role_baru'];
    mysqli_query($koneksi, "UPDATE users SET role = '$role_baru' WHERE id = '$id_ubah'");
    header("Location: admin_users.php"); exit;
}

// Logika Hapus User
if (isset($_GET['hapus_id'])) {
    $id_hapus = $_GET['hapus_id'];
    mysqli_query($koneksi, "DELETE FROM users WHERE id = '$id_hapus'");
    header("Location: admin_users.php"); exit;
}

$users = mysqli_query($koneksi, "SELECT * FROM users ORDER BY role ASC, nama ASC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8"><title>Kelola Akun</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="admin_dashboard.php">Pusat Kelola Wisata</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="admin_wisata.php">Kelola Wisata</a>
                <a class="nav-link active" href="admin_users.php">Kelola Akun</a>
                <a class="nav-link text-danger" href="logout.php">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h3 class="mb-4">Kelola User & Admin</h3>
        <div class="card shadow-sm p-4">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>No</th><th>Nama</th><th>Email</th><th>Role</th><th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = 1; while ($row = mysqli_fetch_assoc($users)): ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['email']); ?></td>
                        <td>
                            <span class="badge <?= $row['role'] == 'admin' ? 'bg-danger' : 'bg-success'; ?>">
                                <?= strtoupper($row['role']); ?>
                            </span>
                        </td>
                        <td>
                            <?php if ($row['role'] == 'user'): ?>
                                <a href="?ubah_role_id=<?= $row['id']; ?>&role_baru=admin" class="btn btn-warning btn-sm" onclick="return confirm('Jadikan Admin?')">Jadikan Admin</a>
                            <?php else: ?>
                               <?php if ($row['email'] !== $email_login): ?>
                                    <a href="?ubah_role_id=<?= $row['id']; ?>&role_baru=user" class="btn btn-secondary btn-sm" onclick="return confirm('Turunkan jadi User?')">Jadikan User</a>
                                <?php endif; ?>
                            <?php endif; ?>
                            
                           <?php if ($row['email'] !== $email_login): ?>
                                <a href="?hapus_id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus akun ini?')">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>