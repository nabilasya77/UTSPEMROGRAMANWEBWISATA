<?php
require 'koneksi.php';

$login = $_COOKIE['login'] ?? null;
$role  = $_COOKIE['role'] ?? null;

if (!$login || $role !== 'admin') {
    header("Location: login.php");
    exit();
}
if (isset($_POST['tambah'])) {
    $nama      = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $gambar    = mysqli_real_escape_string($koneksi, $_POST['gambar']);
    $fasilitas = mysqli_real_escape_string($koneksi, $_POST['fasilitas']);
    $lokasi    = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $rute      = mysqli_real_escape_string($koneksi, $_POST['rute']);

    $query = "INSERT INTO destinasi (nama, deskripsi, gambar, fasilitas, lokasi, rute) 
              VALUES ('$nama', '$deskripsi', '$gambar', '$fasilitas', '$lokasi', '$rute')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: admin_wisata.php?status=sukses_tambah");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}
?>