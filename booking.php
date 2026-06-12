<?php
session_start();
include 'koneksi.php';

// jika belum login tapi nekat buka halaman ini, tarik ke halaman login
if (!isset($_SESSION['login'])) {
  echo "<script>
            alert('Maaf, Anda harus login terlebih dahulu untuk mem-booking kelas!');
            window.location.href='login.php';
          </script>";
  exit;
}

// ambil id ruangan dari url
$id_ruangan = $_GET['id_ruangan'];

// ambil data ruangan untuk ditampilkan di text form
$query_ruang  = "SELECT * FROM ruangan WHERE id_ruangan = '$id_ruangan'";
$result_ruang = mysqli_query($koneksi, $query_ruang);
$ruang        = mysqli_fetch_assoc($result_ruang);

// ketika tombol "Konfirmasi Pengambilan Kelas" diklik
if (isset($_POST['btn_booking'])) {
  $id_user      = $_SESSION['id_user'];
  $tanggal      = $_POST['tanggal'];
  $jam_mulai    = $_POST['jam_mulai'];
  $jam_selesai  = $_POST['jam_selesai'];
  $keterangan   = $_POST['keterangan'];

  // cek apakah di tanggal dan jam tersebut ruangan sudah terisi/bentrok
  $cek_bentrok = "SELECT * FROM jadwal_pengganti 
                    WHERE id_ruangan = '$id_ruangan' 
                    AND tanggal = '$tanggal' 
                    AND (('$jam_mulai' BETWEEN jam_mulai AND jam_selesai) 
                    OR ('$jam_selesai' BETWEEN jam_mulai AND jam_selesai))";

  $proses_cek = mysqli_query($koneksi, $cek_bentrok);

  if (mysqli_num_rows($proses_cek) > 0) {
    // jika bentrok, gagalkan proses
    echo "<script>
                alert('Gagal! Ruangan ini sudah di-booking oleh user lain pada tanggal dan jam tersebut.');
                window.history.back();
              </script>";
  } else {
    // jika aman, langsung masukkan ke database (klaim mandiri)
    $query_insert = "INSERT INTO jadwal_pengganti (id_ruangan, id_user, tanggal, jam_mulai, jam_selesai, keterangan) 
                         VALUES ('$id_ruangan', '$id_user', '$tanggal', '$jam_mulai', '$jam_selesai', '$keterangan')";

    if (mysqli_query($koneksi, $query_insert)) { //run query atas dan simpan ke database
      echo "<script>
                    alert('Berhasil! Ruangan " . $ruang['nama_ruang'] . " resmi menjadi hak kelas Anda.');
                    window.location.href='index.php';
                  </script>";
    } else {
      echo "Error: " . mysqli_error($koneksi);
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Booking Ruangan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow border-0">
          <div class="card-header bg-primary text-white p-3 fw-bold">
            Formulir Klaim Ruangan Mandiri
          </div>
          <div class="card-body p-4">
            <p class="text-muted">Anda login sebagai: <strong><?php echo $_SESSION['nama']; ?></strong></p>

            <form action="" method="POST">
              <div class="mb-3">
                <label class="form-label fw-bold">Ruangan yang Dipilih</label>
                <input type="text" class="form-control bg-light" value="<?php echo $ruang['nama_ruang']; ?> (Kapasitas: <?php echo $ruang['kapasitas']; ?>)" readonly>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold">Tanggal Kuliah Pengganti</label>
                <input type="date" name="tanggal" class="form-control" required>
              </div>
              <div class="row mb-3">
                <div class="col">
                  <label class="form-label fw-bold">Jam Mulai</label>
                  <input type="time" name="jam_mulai" class="form-control" required>
                </div>
                <div class="col">
                  <label class="form-label fw-bold">Jam Selesai</label>
                  <input type="time" name="jam_selesai" class="form-control" required>
                </div>
              </div>
              <div class="mb-3">
                <label class="form-label fw-bold">Keterangan Penggunaan</label>
                <textarea name="keterangan" class="form-control" rows="3" placeholder="Contoh: Kuliah Pengganti Pemrograman Web Kelas 2A" required></textarea>
              </div>

              <div class="d-flex justify-content-between mt-4">
                <a href="index.php" class="btn btn-secondary fw-bold">Batal</a>
                <button type="submit" name="btn_booking" class="btn btn-success fw-bold">Konfirmasi</button>
              </div>

            </form>

          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>