<?php
session_start();
// panggil file koneksi
include 'koneksi.php';
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CariRuang.com - UBhi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">CariRuang.com - UBhi</a>

      <div class="d-flex align-items-center">
        <?php
        // Cek apakah user sudah login atau belum
        if (isset($_SESSION['login'])) {
        ?>
          <span class="text-white me-3 small">Halo, <strong><?php echo $_SESSION['nama']; ?></strong></span>
          <a href="lihat_denah.php" class="btn btn-outline-light btn-sm fw-bold me-2" target="_blank">Denah</a>
          <a href="logout.php" class="btn btn-danger btn-sm fw-bold shadow-sm" onclick="return confirm('Apakah Anda yakin ingin keluar?')">Logout</a>
        <?php
        } else {
        ?>
          <a href="login.php" class="btn btn-light btn-sm fw-bold">Login</a>
        <?php
        }
        ?>
      </div>
    </div>
  </nav>

  <div class="container my-5">
    <div class="text-center mb-5">
      <h1 class="fw-bold text-dark">Cek Ketersediaan Ruang</h1>
      <p class="text-muted">Cari tau ruangan mana saja yang kosong di UBhi secara real-time</p>
    </div>

    <div class="card shadow-sm border-0 mb-5">
      <div class="card-body p-4">
        <form action="cari.php" method="GET" class="row g-3">
          <div class="col-md-5">
            <label class="form-label fw-bold">Pilih Hari</label>
            <select name="hari" class="form-select" required>
              <option value="">-- Pilih Hari --</option>
              <option value="Senin">Senin</option>
              <option value="Selasa">Selasa</option>
              <option value="Rabu">Rabu</option>
              <option value="Kamis">Kamis</option>
              <option value="Jumat">Jumat</option>
            </select>
          </div>
          <div class="col-md-5">
            <label class="form-label fw-bold">Jam Mulai Kuliah</label>
            <input type="time" name="jam" class="form-control" required>
          </div>
          <div class="col-md-2 d-flex align-items-end">
            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">Cari Kelas</button>
          </div>
        </form>
      </div>
    </div>

    <div class="mb-5">
      <h3 class="fw-bold mb-3 text-secondary">📢 Riwayat Booking Kelas Terkini</h3>
      <?php
      $query_riwayat = "SELECT jp.*, r.nama_ruang, u.nama_lengkap 
                        FROM jadwal_pengganti AS jp
                        JOIN ruangan AS r ON jp.id_ruangan = r.id_ruangan
                        JOIN user AS u ON jp.id_user = u.id_user";

      $result_riwayat = mysqli_query($koneksi, $query_riwayat);

      if ($result_riwayat && mysqli_num_rows($result_riwayat) > 0) {
        $semua_riwayat = [];
        while ($row_riwayat = mysqli_fetch_assoc($result_riwayat)) {
          $semua_riwayat[] = $row_riwayat;
        }
        // mengurutkan data paling baru otomatis naik ke atas
        $semua_riwayat = array_reverse($semua_riwayat);

        // maksimal hanya menampilkan 5 riwayat booking terakhir
        $maksimal_tampil = array_slice($semua_riwayat, 0, 5);

        foreach ($maksimal_tampil as $riwayat) {
          $tanggal_format = date('d-m-Y', strtotime($riwayat['tanggal']));
          $jam_mulai_format = date('H:i', strtotime($riwayat['jam_mulai']));
          $jam_selesai_format = date('H:i', strtotime($riwayat['jam_selesai']));
      ?>
          <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center py-3 mb-2" role="alert">
            <span class="fs-4 me-3">📌</span>
            <div>
              Kelas <strong class="text-dark"><?php echo $riwayat['nama_ruang']; ?></strong>
              di jam <strong><?php echo $jam_mulai_format; ?> - <?php echo $jam_selesai_format; ?></strong> (Tanggal: <?php echo $tanggal_format; ?>)
              sudah di-booking oleh <span class="badge bg-primary"><?php echo $riwayat['nama_lengkap']; ?></span>
              <br>
              <small class="text-muted italic">Keperluan: "<?php echo $riwayat['keterangan']; ?>"</small>
            </div>
          </div>
      <?php
        }
      } else {
        // jika tabel jadwal_pengganti masih kosong
        echo '<div class="card border-0 bg-white p-4 text-center text-muted shadow-sm mb-2">
                  <p class="m-0 small">Belum ada ruangan yang di-booking hari ini. Ruangan kosong bebas digunakan!</p>
                </div>';
      }
      ?>
    </div>