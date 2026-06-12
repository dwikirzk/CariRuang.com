<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id_hapus = $_GET['id'];

    // perintah hapus disesuaikan menggunakan id_jadwal
    $query_hapus = "DELETE FROM jadwal_reguler WHERE id_jadwal = '$id_hapus'";

    if (mysqli_query($koneksi, $query_hapus)) {
        echo "<script>
                alert('Jadwal berhasil dihapus dari sistem!');
                window.location.href='admin_dashboard.php';
              </script>";
        exit;
    } else {
        echo "Gagal menghapus data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: admin_dashboard.php");
    exit;
}
