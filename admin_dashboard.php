<?php
session_start();
include 'koneksi.php';

// hanya admin yang boleh masuk
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}

$query = "SELECT jadwal_reguler.*, ruangan.nama_ruang, mata_kuliah.nama_matkul 
          FROM jadwal_reguler 
          JOIN ruangan ON jadwal_reguler.id_ruangan = ruangan.id_ruangan
          JOIN mata_kuliah ON jadwal_reguler.id_matkul = mata_kuliah.id_matkul
          ORDER BY hari, jam_mulai ASC";
$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <title>Admin - Kelola Jadwal</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>

<body class="bg-light">
  <nav class="navbar navbar-dark bg-dark shadow-sm">
    <div class="container">
      <a class="navbar-brand fw-bold" href="admin_dashboard.php">Panel Admin</a>
      <a href="logout.php" class="btn btn-danger btn-sm fw-bold">Logout</a>
    </div>
  </nav>

  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="fw-bold m-0">Atur Jadwal Kuliah Reguler</h2>
      <div>
        <a href="lihat_denah.php" class="btn btn-info text-white fw-bold me-2">Lihat Denah</a>
        <a href="tambah_jadwal.php" class="btn btn-success fw-bold">+ Tambah Jadwal</a>
      </div>
    </div>

    <div class="card shadow-sm border-0">
      <div class="p-3">
        <table id="tabelJadwal" class="table table-striped table-hover align-middle">
          <thead class="table-dark">
            <tr>
              <th>Hari</th>
              <th>Ruangan</th>
              <th>Mata Kuliah</th>
              <th>Jam</th>
              <th style="width: 180px;">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
              <tr>
                <td><?php echo $row['hari']; ?></td>
                <td><strong><?php echo $row['nama_ruang']; ?></strong></td>
                <td><?php echo $row['nama_matkul']; ?></td>
                <td><?php echo date('H:i', strtotime($row['jam_mulai'])); ?> - <?php echo date('H:i', strtotime($row['jam_selesai'])); ?></td>
                <td>
                  <a href="edit_jadwal.php?id=<?php echo $row['id_jadwal']; ?>" class="btn btn-warning btn-sm fw-bold me-1">Edit</a>
                  <a href="hapus_jadwal.php?id=<?php echo $row['id_jadwal']; ?>" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function() {
      $('#tabelJadwal').DataTable({
        // filter kolom
        "columnDefs": [{
            "orderable": false,
            "targets": [3, 4]
          } // mematikan fitur sorting untuk kolom Jam (3) dan Aksi (4)
        ],
        "language": {
          "search": "Cari Cepat:",
          "lengthMenu": "Tampilkan _MENU_ data per halaman",
          "zeroRecords": "Data jadwal tidak ditemukan",
          "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
          "infoEmpty": "Tidak ada data tersedia",
          "infoFiltered": "(difilter dari _MAX_ total data)",
          "paginate": {
            "first": "Pertama",
            "last": "Terakhir",
            "next": "Berikutnya",
            "previous": "Sebelumnya"
          }
        }
      });
    });
  </script>
</body>

</html>