-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 11 Sep 2026 pada 07.57
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `desa_rantau_kadam`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `activity` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `activity_logs`
--

INSERT INTO `activity_logs` (`id`, `user_id`, `activity`, `created_at`) VALUES
(1, 1, 'Login admin', '2026-09-11 03:55:53');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(180) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `isi` longtext NOT NULL,
  `kategori` varchar(80) NOT NULL DEFAULT 'Kegiatan',
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal_publish` date NOT NULL,
  `id_user` int(10) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `judul`, `slug`, `isi`, `kategori`, `gambar`, `tanggal_publish`, `id_user`, `created_at`) VALUES
(1, 'Gotong Royong Bersihkan Lingkungan Desa', 'gotong-royong-bersihkan-lingkungan-desa', 'Pemerintah desa bersama masyarakat melaksanakan gotong royong membersihkan lingkungan desa agar tetap bersih, sehat, dan nyaman.', 'Kegiatan', NULL, '2026-09-11', NULL, '2026-09-11 03:38:15'),
(2, 'Penyaluran BLT Dana Desa Tahap II Tahun 2024', 'penyaluran-blt-dana-desa-tahap-ii-tahun-2024', 'Informasi penyaluran bantuan langsung tunai dana desa kepada penerima manfaat sesuai ketentuan yang berlaku.', 'Pemerintahan', NULL, '2026-09-08', NULL, '2026-09-11 03:38:15'),
(3, 'Musyawarah Desa RKPDES Tahun 2025', 'musyawarah-desa-rkpdes-tahun-2025', 'Musyawarah desa untuk penyusunan rencana kerja pemerintah desa.', 'Pembangunan', NULL, '2026-09-04', NULL, '2026-09-11 03:38:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `dokumen_publik`
--

CREATE TABLE `dokumen_publik` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul_dokumen` varchar(180) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `tanggal_upload` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(180) NOT NULL,
  `kategori` varchar(80) NOT NULL DEFAULT 'Kegiatan Desa',
  `file_gambar` varchar(255) NOT NULL,
  `tanggal_upload` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id` int(10) UNSIGNED NOT NULL,
  `judul` varchar(180) NOT NULL,
  `isi` longtext NOT NULL,
  `file_pdf` varchar(255) DEFAULT NULL,
  `tanggal_publish` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id`, `judul`, `isi`, `file_pdf`, `tanggal_publish`, `created_at`) VALUES
(1, 'Pemberitahuan Libur Hari Raya Idul Fitri 1445 H', 'Pemberitahuan jadwal pelayanan administrasi desa selama libur Hari Raya Idul Fitri.', NULL, '2026-09-06', '2026-09-11 03:38:15'),
(2, 'Pembayaran PBB-P2 Tahun 2024', 'Warga desa diimbau melakukan pembayaran PBB-P2 sesuai jadwal.', NULL, '2026-09-03', '2026-09-11 03:38:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `perangkat_desa`
--

CREATE TABLE `perangkat_desa` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(120) NOT NULL,
  `jabatan` varchar(120) NOT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `urutan_hirarki` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `perangkat_desa`
--

INSERT INTO `perangkat_desa` (`id`, `nama`, `jabatan`, `foto`, `urutan_hirarki`) VALUES
(1, 'Kepala Desa', 'Kepala Desa', NULL, 1),
(2, 'Sekretaris Desa', 'Sekretaris Desa', NULL, 2),
(3, 'Kasi Pemerintahan', 'Kepala Seksi Pemerintahan', NULL, 3),
(4, 'Kasi Kesejahteraan', 'Kepala Seksi Kesejahteraan', NULL, 4),
(5, 'Kaur Keuangan', 'Kepala Urusan Keuangan', NULL, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan_kontak`
--

CREATE TABLE `pesan_kontak` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `subjek` varchar(180) NOT NULL,
  `pesan` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `potensi_desa`
--

CREATE TABLE `potensi_desa` (
  `id` int(10) UNSIGNED NOT NULL,
  `kategori` varchar(80) NOT NULL,
  `judul` varchar(180) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `profil_desa`
--

CREATE TABLE `profil_desa` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `sejarah` text NOT NULL,
  `visi` text NOT NULL,
  `misi` text NOT NULL,
  `wilayah` text DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `email` varchar(120) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `profil_desa`
--

INSERT INTO `profil_desa` (`id`, `sejarah`, `visi`, `misi`, `wilayah`, `alamat`, `telepon`, `email`, `created_at`, `updated_at`) VALUES
(1, 'Desa Rantau Kadam merupakan desa di Kecamatan Karang Dapo, Kabupaten Musi Rawas Utara, Provinsi Sumatera Selatan. Silakan sesuaikan narasi dengan sejarah resmi desa.', 'Terwujudnya Desa Rantau Kadam yang maju, mandiri, transparan, aman, dan sejahtera.', 'Meningkatkan pelayanan publik; memperkuat ekonomi masyarakat; mengembangkan potensi desa; meningkatkan kualitas sumber daya manusia; dan membangun tata kelola pemerintahan yang transparan.', 'Kecamatan Karang Dapo, Kabupaten Musi Rawas Utara, Provinsi Sumatera Selatan.', 'Desa Rantau Kadam, Kecamatan Karang Dapo, Kabupaten Musi Rawas Utara, Sumatera Selatan', '0732-123456', 'desa.rantaukadam@gmail.com', '2026-09-11 03:38:15', '2026-09-11 03:38:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(120) NOT NULL,
  `role` enum('admin','editor') NOT NULL DEFAULT 'editor',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `nama_lengkap`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$qf9rbllmn1zIWShAnkwhB.m/H/fI3ePw6JMkGswF76qk8QvjZ4UJq', 'Administrator Desa', 'admin', '2026-09-11 03:54:54');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `dokumen_publik`
--
ALTER TABLE `dokumen_publik`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `perangkat_desa`
--
ALTER TABLE `perangkat_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `potensi_desa`
--
ALTER TABLE `potensi_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `profil_desa`
--
ALTER TABLE `profil_desa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `dokumen_publik`
--
ALTER TABLE `dokumen_publik`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `perangkat_desa`
--
ALTER TABLE `perangkat_desa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `potensi_desa`
--
ALTER TABLE `potensi_desa`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `profil_desa`
--
ALTER TABLE `profil_desa`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD CONSTRAINT `berita_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
