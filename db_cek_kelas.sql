-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 12 Jun 2026 pada 01.27
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `db_cek_kelas`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_pengganti`
--

CREATE TABLE `jadwal_pengganti` (
  `id_reservasi` int NOT NULL,
  `id_ruangan` int DEFAULT NULL,
  `id_user` int DEFAULT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `keterangan` text,
  `waktu_booking` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jadwal_pengganti`
--

INSERT INTO `jadwal_pengganti` (`id_reservasi`, `id_ruangan`, `id_user`, `tanggal`, `jam_mulai`, `jam_selesai`, `keterangan`, `waktu_booking`) VALUES
(3, 1, 1, '2026-05-28', '08:30:00', '11:30:00', 'Kuliah Pengganti Struktur Data 2A', '2026-05-27 04:30:52'),
(4, 2, 1, '2026-06-02', '12:37:00', '12:37:00', 'Pertemuan Mingguan Robotic', '2026-05-27 05:37:48'),
(5, 7, 2, '2026-06-04', '10:40:00', '13:40:00', 'Kuliah Pengganti Matkul Statistika 2B', '2026-06-07 06:39:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_reguler`
--

CREATE TABLE `jadwal_reguler` (
  `id_jadwal` int NOT NULL,
  `id_ruangan` int DEFAULT NULL,
  `id_matkul` int DEFAULT NULL,
  `hari` varchar(10) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `jadwal_reguler`
--

INSERT INTO `jadwal_reguler` (`id_jadwal`, `id_ruangan`, `id_matkul`, `hari`, `jam_mulai`, `jam_selesai`) VALUES
(1, 1, 1, 'Senin', '07:45:00', '09:30:00'),
(2, 2, 3, 'Senin', '09:40:00', '12:00:00'),
(4, 4, 2, 'Senin', '07:30:00', '10:00:00'),
(5, 5, 3, 'Selasa', '08:00:00', '10:00:00'),
(6, 6, 4, 'Selasa', '10:00:00', '12:30:00'),
(7, 7, 5, 'Selasa', '07:00:00', '08:30:00'),
(8, 1, 6, 'Selasa', '09:40:00', '12:30:00'),
(9, 1, 6, 'Rabu', '08:40:00', '12:00:00'),
(10, 2, 5, 'Rabu', '07:30:00', '09:30:00'),
(12, 4, 3, 'Kamis', '11:00:00', '12:45:00'),
(13, 5, 2, 'Kamis', '07:30:00', '10:00:00'),
(15, 7, 4, 'Jumat', '08:00:00', '10:30:00'),
(16, 1, 1, 'Jumat', '13:30:00', '15:30:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `mata_kuliah`
--

CREATE TABLE `mata_kuliah` (
  `id_matkul` int NOT NULL,
  `nama_matkul` varchar(50) NOT NULL,
  `dosen` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `mata_kuliah`
--

INSERT INTO `mata_kuliah` (`id_matkul`, `nama_matkul`, `dosen`) VALUES
(1, 'Basis Data', 'Taufiq Agung Cahyono, M.Kom.'),
(2, 'Pengenalan Pemrograman', 'Yayak Kartika Sari, M.Kom.'),
(3, 'Kompleksitas Algoritma', 'Joko Iskandar, M.Kom.'),
(4, 'Statistika', 'Dr.Maylita Hasyim, M.Si.'),
(5, 'Struktur Data', 'Fahrur Rozi, M.Kom.'),
(6, 'Sistem Operasi', 'Agung Prasetya, M.Kom.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan`
--

CREATE TABLE `ruangan` (
  `id_ruangan` int NOT NULL,
  `nama_ruang` varchar(10) NOT NULL,
  `kapasitas` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `ruangan`
--

INSERT INTO `ruangan` (`id_ruangan`, `nama_ruang`, `kapasitas`) VALUES
(1, 'B1.1', 40),
(2, 'B1.2', 40),
(3, 'B1.3', 45),
(4, 'B2.1', 30),
(5, 'B2.2', 35),
(6, 'B2.3', 40),
(7, 'B2.4', 50);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` int NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `nomor_wa` varchar(15) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_lengkap`, `nomor_wa`, `role`) VALUES
(1, '25161562021', '2021', 'Mohamad Dwiki Rozak', '085755305608', 'user'),
(2, '25161562000', '2000', 'Vania Bakrie', '082755102199', 'user'),
(3, 'admin', 'admin', 'Administrator UBhi', '081122334455', 'admin');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `jadwal_pengganti`
--
ALTER TABLE `jadwal_pengganti`
  ADD PRIMARY KEY (`id_reservasi`),
  ADD KEY `id_ruangan` (`id_ruangan`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `jadwal_reguler`
--
ALTER TABLE `jadwal_reguler`
  ADD PRIMARY KEY (`id_jadwal`),
  ADD KEY `id_ruangan` (`id_ruangan`),
  ADD KEY `id_matkul` (`id_matkul`);

--
-- Indeks untuk tabel `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  ADD PRIMARY KEY (`id_matkul`);

--
-- Indeks untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  ADD PRIMARY KEY (`id_ruangan`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `jadwal_pengganti`
--
ALTER TABLE `jadwal_pengganti`
  MODIFY `id_reservasi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `jadwal_reguler`
--
ALTER TABLE `jadwal_reguler`
  MODIFY `id_jadwal` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT untuk tabel `mata_kuliah`
--
ALTER TABLE `mata_kuliah`
  MODIFY `id_matkul` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `ruangan`
--
ALTER TABLE `ruangan`
  MODIFY `id_ruangan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `jadwal_pengganti`
--
ALTER TABLE `jadwal_pengganti`
  ADD CONSTRAINT `jadwal_pengganti_ibfk_1` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`),
  ADD CONSTRAINT `jadwal_pengganti_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `jadwal_reguler`
--
ALTER TABLE `jadwal_reguler`
  ADD CONSTRAINT `jadwal_reguler_ibfk_1` FOREIGN KEY (`id_ruangan`) REFERENCES `ruangan` (`id_ruangan`),
  ADD CONSTRAINT `jadwal_reguler_ibfk_2` FOREIGN KEY (`id_matkul`) REFERENCES `mata_kuliah` (`id_matkul`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
