<?php
require 'koneksi.php';

$login = $_COOKIE['login'] ?? null;
$role  = $_COOKIE['role'] ?? null;

if (!$login || $role !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_POST['update'])) {
    $id        = $_POST['id'];
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $gambar    = mysqli_real_escape_string($koneksi, $_POST['gambar']);
    $fasilitas = mysqli_real_escape_string($koneksi, $_POST['fasilitas']);
    $lokasi    = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $rute      = mysqli_real_escape_string($koneksi, $_POST['rute']);

    $query_update = "UPDATE destinasi SET 
                        nama='$nama', 
                        deskripsi='$deskripsi', 
                        gambar='$gambar', 
                        fasilitas='$fasilitas', 
                        lokasi='$lokasi', 
                        rute='$rute' 
                     WHERE id='$id'";

    if (mysqli_query($koneksi, $query_update)) {
        header("Location: admin_wisata.php?status=sukses_edit");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}