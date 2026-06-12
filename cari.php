<?php
session_start();
include 'koneksi.php';

// ambil data dari form pencarian di index.php
$hari_dicari = $_GET['hari'];
$jam_dicari  = $_GET['jam'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Ruangan Kosong</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="index.php">← Kembali ke Pencarian</a>
    </div>
  </nav>

  <div class="container my-5">
    <div class="mb-4">
      <h2>Daftar Ruangan Kosong</h2>
      <p class="text-muted">Menampilkan ruang kelas yang tersedia pada hari <strong><?php echo $hari_dicari; ?></strong> sekitar jam <strong><?php echo $jam_dicari; ?></strong></p>
    </div>

    <div class="row g-4">
      <?php
      /**
       * LOGIKA UTAMA:
       * mencari semua ruangan yang ID-nya tidak ada di tabel jadwal_reguler pada hari dan jam tersebut,
       * dan juga tidak ada di tabel jadwal_pengganti pada tanggal/jam tersebut.
       */
      $query = "SELECT * FROM ruangan WHERE id_ruangan NOT IN (
                        SELECT id_ruangan FROM jadwal_reguler 
                        WHERE hari = '$hari_dicari' 
                        AND '$jam_dicari' BETWEEN jam_mulai AND jam_selesai
                      ) AND id_ruangan NOT IN (
                        SELECT id_ruangan FROM jadwal_pengganti
                        WHERE tanggal = CURDATE() -- mengecek booking di tanggal hari ini
                        AND '$jam_dicari' BETWEEN jam_mulai AND jam_selesai
                      )";

      $result = mysqli_query($koneksi, $query);

      // cek apakah ada ruangan yang kosong
      if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
      ?>
          <div class="col-md-4">
            <div class="card shadow-sm border-0 border-top border-success border-4 h-100">
              <div class="card-body">
                <span class="badge bg-success mb-2">Tersedia</span>
                <h4 class="fw-bold text-dark mb-2"><?php echo $row['nama_ruang']; ?></h4>
                <p class="text-muted mb-3">Kapasitas: <?php echo $row['kapasitas']; ?> Kursi</p>
                <a href="booking.php?id_ruangan=<?php echo $row['id_ruangan']; ?>" class="btn btn-outline-primary btn-sm w-100 fw-bold">Booking Ruangan</a>
              </div>
            </div>
          </div>
      <?php
        }
      } else {
        // jika semua ruangan penuh di jam tersebut
        echo "
                <div class='col-12'>
                    <div class='alert alert-danger text-center p-5 shadow-sm border-0' role='alert'>
                        <h4 class='fw-bold'>Waduh, Semua Ruangan Penuh!</h4>
                        <p class='mb-0 text-muted'>Tidak ada ruangan di UBhi yang kosong pada hari $hari_dicari jam $jam_dicari. Silakan coba cari di jam atau hari lain.</p>
                    </div>
                </div>
              ";
      }
      ?>
    </div>
  </div>

</body>

</html>