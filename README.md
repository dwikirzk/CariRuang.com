# CariRuang.com - Sistem Cek & Booking Kelas Kosong Ubhi

CariRuang.com adalah aplikasi berbasis web _Full-Stack_ yang dirancang untuk mempermudah mahasiswa (Komting) dalam mencari dan mengklaim ruangan kelas kosong di Gedung B untuk keperluan kuliah pengganti secara _real-time_. Sistem ini juga dilengkapi dengan panel khusus admin untuk mengelola jadwal kuliah reguler agar tidak terjadi bentrok peminjaman.

---

### 👤 Identitas Pengembang

- **Nama:** Mohamad Dwiki Rozak
- **NIM:** 25161562021
- **Kelas:** INF 2A
- **Program Studi:** Informatika
- **Tujuan Proyek:** Project Akhir Basis Data Semester 2

---

### 🚀 Fitur Utama Sistem

1. **Sisi Mahasiswa / Komting:**
   - **Pencarian Real-Time:** Mencari kelas kosong berdasarkan kombinasi Hari dan Jam Kuliah secara akurat.
   - **Riwayat Peminjaman Terkini:** Menampilkan log 5 bookingan terakhir langsung di halaman utama.
   - **Sistem Klaim Mandiri:** Komting dapat melakukan _booking_ setelah melakukan autentikasi login menggunakan NIM.
   - **Peta Denah Interaktif:** Penampil denah Gedung B dengan desain _clean light mode_ yang minimalis.

2. **Sisi Admin:**
   - **Multi-role Authentication:** Pemisahan hak akses beranda menggunakan sistem _Session PHP_.
   - **Dashboard CRUD:** Panel kendali khusus untuk Menambah, Melihat, Mengedit, dan Menghapus jadwal kuliah reguler secara instan.

3. **Optimasi Antarmuka (UI):**
   - **DataTables Integration:** Fitur penyortiran (_sorting_) naik-turun pada kolom Hari, Ruangan, dan Matkul serta fitur _Cari Cepat_ tanpa membebani performa database server.

---

### 📂 Penjelasan Struktur File PHP

Berikut adalah peran dan fungsi dari masing-masing file PHP di dalam proyek ini:

- **`index.php`** Halaman utama website yang diakses oleh publik/mahasiswa. Berfungsi menyediakan form pencarian kelas kosong, menampilkan **Riwayat Booking Kelas Terkini** (menggunakan manipulasi array PHP), dan menampilkan daftar seluruh ruangan default di Gedung B.
- **`koneksi.php`** File konfigurasi sentral yang mengatur penghubung kodingan PHP dengan database MySQL (menggunakan `mysqli_connect`). Dipanggil di hampir setiap file menggunakan perintah `include`.

- **`login.php`** Halaman autentikasi akun. Memproses validasi input login menggunakan _Session_ untuk memisahkan hak akses (Role Admin diarahkan ke panel kontrol, sedangkan Role Komting diarahkan ke halaman utama).

- **`logout.php`** File proses pemutus _session_ login pengguna secara aman, kemudian mengarahkan kembali user ke halaman utama.

- **`cari.php`** Memproses parameter input Hari dan Jam dari form halaman utama. Melakukan kueri logika untuk memfilter dan menampilkan daftar ruangan mana saja yang benar-benar kosong dan siap di-booking.

- **`booking.php`** Halaman form klaim ruangan bagi Komting yang sudah login. Memuat validasi `POST` untuk merekam data tanggal, jam, komting yang meminjam, serta alasan keperluan ke tabel `jadwal_pengganti`.

- **`lihat_denah.php`** Halaman visualisasi peta lokasi kelas Gedung B. Dibuat dengan gaya _clean light mode_ yang minimalis, responsif, dan menyatu dengan estetika Bootstrap halaman lainnya.

- **`admin_dashboard.php`** Halaman utama panel kendali khusus Admin. Menampilkan tabel seluruh jadwal kuliah reguler yang dilengkapi fitur interaktif _DataTables_ (Cari Cepat & Sorting khusus kolom Hari, Ruangan, dan Matkul).

- **`tambah_jadwal.php`** Form input bagi admin untuk menambahkan data jadwal kuliah reguler baru ke dalam database.

- **`edit_jadwal.php`** Form modifikasi data untuk mengubah hari, jam, mata kuliah, ataupun ruangan pada jadwal reguler yang sudah ada berdasarkan parameter `id_jadwal`.

- **`hapus_jadwal.php`** File proses _background execution_ yang bertugas menghapus data jadwal reguler terpilih secara instan di database berdasarkan ID yang dikirim.

---

### 🛠️ Spesifikasi Teknologi

- **Front-End:** HTML5, CSS3, Bootstrap 5 (Responsive Layout)
- **Back-End:** PHP Native (Session Management & Multi-role)
- **Database:** MySQL
- **Library Tambahan:** jQuery, DataTables Bootstrap 5
