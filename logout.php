<?php
session_start(); // mulai session agar bisa dihapus
session_unset(); // kosongkan semua data session
session_destroy(); // hancurkan session dari sistem

// lempar kembali user ke halaman utama (index.php) setelah logout
header("Location: index.php");
exit;
