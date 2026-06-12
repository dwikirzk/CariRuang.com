<?php
$host     = "localhost";
$user     = "root";
$password = "";
$database = "db_cek_kelas";

$koneksi = mysqli_connect($host, $user, $password, $database);

// cek apakah koneksi berhasil atau gagal
if (!$koneksi) {
  die("Koneksi ke database gagal: " . mysqli_connect_error());
}