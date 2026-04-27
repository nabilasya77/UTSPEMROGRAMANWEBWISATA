<?php
require 'koneksi.php';

$login = $_COOKIE['login'] ?? null;
$role  = $_COOKIE['role'] ?? null;

if (!$login || $role !== 'admin') {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query_hapus = "DELETE FROM destinasi WHERE id = '$id'";

    if (mysqli_query($koneksi, $query_hapus)) {
        header("Location: admin_wisata.php?status=sukses_hapus");
    } else {
        echo "Error: " . mysqli_error($koneksi);
    }
}