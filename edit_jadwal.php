<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}

$id = $_GET['id'];

// query disesuaikan menggunakan id_jadwal
$query_lama = "SELECT * FROM jadwal_reguler WHERE id_jadwal = '$id'";
$data_lama  = mysqli_query($koneksi, $query_lama);
$j          = mysqli_fetch_assoc($data_lama);

if (isset($_POST['update'])) {
  $hari    = $_POST['hari'];
  $mulai   = $_POST['jam_mulai'];
  $selesai = $_POST['jam_selesai'];

  // update disesuaikan menggunakan id_jadwal
  $update_query = "UPDATE jadwal_reguler SET hari='$hari', jam_mulai='$mulai', jam_selesai='$selesai' WHERE id_jadwal='$id'";

  if (mysqli_query($koneksi, $update_query)) {
    echo "<script>
                alert('Jadwal Berhasil Diperbarui!'); 
                window.location.href='admin_dashboard.php';
              </script>";
    exit;
  } else {
    echo "Gagal: " . mysqli_error($koneksi);
  }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <title>Edit Jadwal Kuliah</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <div class="container my-5">
    <div class="card mx-auto shadow-sm" style="max-width: 500px;">
      <div class="card-body p-4">
        <h4 class="fw-bold mb-4 text-warning">Edit Jadwal Kuliah</h4>
        <form action="" method="POST">
          <div class="mb-3">
            <label class="form-label fw-bold">Hari</label>
            <select name="hari" class="form-select" required>
              <option value="Senin" <?php if ($j['hari'] == 'Senin') echo 'selected'; ?>>Senin</option>
              <option value="Selasa" <?php if ($j['hari'] == 'Selasa') echo 'selected'; ?>>Selasa</option>
              <option value="Rabu" <?php if ($j['hari'] == 'Rabu') echo 'selected'; ?>>Rabu</option>
              <option value="Kamis" <?php if ($j['hari'] == 'Kamis') echo 'selected'; ?>>Kamis</option>
              <option value="Jumat" <?php if ($j['hari'] == 'Jumat') echo 'selected'; ?>>Jumat</option>
            </select>
          </div>
          <div class="row mb-4">
            <div class="col">
              <label class="form-label fw-bold">Jam Mulai</label>
              <input type="time" name="jam_mulai" class="form-control" value="<?php echo $j['jam_mulai']; ?>" required>
            </div>
            <div class="col">
              <label class="form-label fw-bold">Jam Selesai</label>
              <input type="time" name="jam_selesai" class="form-control" value="<?php echo $j['jam_selesai']; ?>" required>
            </div>
          </div>
          <button type="submit" name="update" class="btn btn-primary w-100 fw-bold py-2">Simpan Perubahan</button>
          <a href="admin_dashboard.php" class="btn btn-secondary w-100 mt-2">Batal</a>
        </form>
      </div>
    </div>
  </div>
</body>

</html>