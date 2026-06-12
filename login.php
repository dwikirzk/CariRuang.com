<?php
session_start();
include 'koneksi.php';

// jika sudah login, langsung lempar ke halaman yang sesuai
if (isset($_SESSION['login'])) {
  if ($_SESSION['role'] == 'admin') {
    header("Location: admin_dashboard.php");
  } else {
    header("Location: index.php");
  }
  exit;
}

// Proses ketika tombol login diklik
if (isset($_POST['btn_login'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];

  // cek ke database apakah username dan password cocok
  $query  = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
  $result = mysqli_query($koneksi, $query);
  // jika database ada
  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    // lalu daftarkan data ke session
    $_SESSION['login']   = true;
    $_SESSION['id_user'] = $row['id_user'];
    $_SESSION['nama']    = $row['nama_lengkap'];
    $_SESSION['role']    = $row['role']; // simpan role ('admin' atau 'user')

    // arahkan halaman berdasarkan role
    if ($_SESSION['role'] == 'admin') {
      echo "<script>
                    alert('Login Berhasil! Selamat datang admin " . $row['nama_lengkap'] . "');
                    window.location.href='admin_dashboard.php';
                  </script>";
    } else {
      echo "<script>
                    alert('Login Berhasil! Selamat datang " . $row['nama_lengkap'] . "');
                    window.location.href='index.php';
                  </script>";
    }
    exit;
  } else {
    // jika username atau password tidak ditemukan di database
    $error = true;
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - UBhi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="height: 100vh;">

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow border-0">
          <div class="card-body p-4">
            <h3 class="text-center fw-bold text-primary mb-2">Login Sistem</h3>
            <p class="text-center text-muted small mb-4">Masuk dengan username dan password anda agar bisa mengakses layanan kampus ini</p>

            <?php if (isset($error)) : ?>
              <div class="alert alert-danger text-center py-2 small" role="alert">
                Username atau Password salah!
              </div>
            <?php endif; ?>

            <form action="" method="POST">
              <div class="mb-3">
                <label class="form-label fw-bold small">Username</label>
                <input type="text" name="username" class="form-control" placeholder="Masukan username / email / NPM" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold small">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
              </div>
              <button type="submit" name="btn_login" class="btn btn-primary w-100 fw-bold py-2 mt-2">Masuk</button>
            </form>

            <div class="text-center mt-3">
              <a href="index.php" class="text-decoration-none small text-secondary">← Kembali ke Beranda</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</body>

</html>