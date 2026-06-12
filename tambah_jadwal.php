<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}

// ambil data ruangan dan mata kuliah untuk pilihan di Form (dropdown)
$ruangan_opsi = mysqli_query($koneksi, "SELECT * FROM ruangan");
$matkul_opsi  = mysqli_query($koneksi, "SELECT * FROM mata_kuliah");

if (isset($_POST['simpan'])) {
  $id_ruangan  = $_POST['id_ruangan'];
  $id_matkul   = $_POST['id_matkul'];
  $hari        = $_POST['hari'];
  $jam_mulai   = $_POST['jam_mulai'];
  $jam_selesai = $_POST['jam_selesai'];

  // cek apakah di hari, jam, dan ruangan yang sama sudah diisi jadwal lain
  $cek = mysqli_query($koneksi, "SELECT * FROM jadwal_reguler WHERE id_ruangan='$id_ruangan' AND hari='$hari' AND (('$jam_mulai' BETWEEN jam_mulai AND jam_selesai) OR ('$jam_selesai' BETWEEN jam_mulai AND jam_selesai))");

  if (mysqli_num_rows($cek) > 0) {
    echo "<script>alert('Gagal! Ruangan tersebut sudah terpakai oleh jadwal lain di jam yang sama.'); window.history.back();</script>";
  } else {
    $insert = "INSERT INTO jadwal_reguler (id_ruangan, id_matkul, hari, jam_mulai, jam_selesai) VALUES ('$id_ruangan', '$id_matkul', '$hari', '$jam_mulai', '$jam_selesai')";
    if (mysqli_query($koneksi, $insert)) {
      echo "<script>alert('Jadwal Baru Berhasil Ditambahkan!'); window.location.href='admin_dashboard.php';</script>";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Tambah Jadwal Baru</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container my-5">
    <div class="card mx-auto shadow-sm" style="max-width: 550px;">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-4 text-success">Tambah Jadwal Kuliah Reguler</h4>
        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label fw-bold">Pilih Ruangan</label>
            <select name="id_ruangan" class="form-select" required>
              <?php while ($r = mysqli_fetch_assoc($ruangan_opsi)): ?>
                <option value="<?php echo $r['id_ruangan']; ?>"><?php echo $r['nama_ruang']; ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Pilih Mata Kuliah</label>
            <select name="id_matkul" class="form-select" required>
              <?php while ($m = mysqli_fetch_assoc($matkul_opsi)): ?>
                <option value="<?php echo $m['id_matkul']; ?>"><?php echo $m['nama_matkul']; ?></option>
              <?php endwhile; ?>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Hari</label>
            <select name="hari" class="form-select" required>
              <option value="Senin">Senin</option>
              <option value="Selasa">Selasa</option>
              <option value="Rabu">Rabu</option>
              <option value="Kamis">Kamis</option>
              <option value="Jumat">Jumat</option>
            </select>
          </div>
          <div class="row mb-4">
            <div class="col">
              <label class="form-label fw-bold">Jam Mulai</label>
              <input type="time" name="jam_mulai" class="form-control" required>
            </div>
            <div class="col">
              <label class="form-label fw-bold">Jam Selesai</label>
              <input type="time" name="jam_selesai" class="form-control" required>
            </div>
          </div>
          <button type="submit" name="simpan" class="btn btn-success w-100 fw-bold py-2">Simpan Jadwal</button>
          <a href="admin_dashboard.php" class="btn btn-secondary w-100 mt-2">Kembali</a>
        </form>
      </div>
    </div>
  </div>
</body>

</html>