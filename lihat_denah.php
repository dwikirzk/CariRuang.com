<?php
session_start();
// proteksi keamanan agar hanya yang login yang bisa lihat
if (!isset($_SESSION['login'])) {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Denah UBhi - RoomBook System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }

    .card-denah {
      background-color: #ffffff;
      border: none;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .denah-img {
      max-height: 70vh;
      object-fit: contain;
    }
  </style>
</head>

<body>

  <div class="container my-4 text-center">
    <div class="mb-4">
      <?php if ($_SESSION['role'] === 'admin') { ?>
        <a href="admin_dashboard.php" class="btn btn-outline-primary fw-bold px-4 rounded-pill shadow-sm">
          Kembali ke Dashboard Admin
        </a>
      <?php } else { ?>
        <a href="index.php" class="btn btn-primary fw-bold px-4 rounded-pill shadow-sm">
          Kembali ke Dashboard
        </a>
      <?php } ?>
    </div>

    <div class="card card-denah p-3 p-md-4 d-inline-block mx-auto">
      <img src="assets/denah.png" alt="Denah UBhi" class="img-fluid rounded denah-img">
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>