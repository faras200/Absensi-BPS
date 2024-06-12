-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Jul 2022 pada 02.51
-- Versi server: 10.4.24-MariaDB
-- Versi PHP: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absensi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absen`
--

CREATE TABLE `absen` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `tgl_absen` date NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `absen`
--

INSERT INTO `absen` (`id`, `karyawan_id`, `jam_masuk`, `jam_keluar`, `tgl_absen`, `status`, `created_at`, `updated_at`) VALUES
(10, 2, '02:56:30', '02:56:30', '2022-07-05', 'telat', '2022-07-04 19:56:30', '2022-07-04 19:56:37'),
(11, 4, '02:56:30', '02:56:30', '2022-07-05', 'masuk', '2022-07-04 19:56:30', '2022-07-04 19:56:30'),
(12, 2, '02:57:29', '02:57:29', '2022-07-04', 'masuk', '2022-07-04 19:57:30', '2022-07-04 19:57:30'),
(13, 4, '02:57:30', '02:57:30', '2022-07-04', 'masuk', '2022-07-04 19:57:30', '2022-07-04 19:57:30'),
(16, 2, '04:04:31', '04:04:31', '2022-07-08', 'masuk', '2022-07-04 21:04:31', '2022-07-04 21:04:31'),
(17, 4, '04:04:31', '04:04:31', '2022-07-08', 'masuk', '2022-07-04 21:04:31', '2022-07-04 21:04:31'),
(18, 2, '05:52:41', '05:52:41', '2022-07-07', 'masuk', '2022-07-04 22:52:41', '2022-07-04 22:52:41'),
(19, 4, '05:52:41', '05:52:41', '2022-07-07', 'masuk', '2022-07-04 22:52:41', '2022-07-04 22:52:41'),
(20, 2, '01:12:48', '01:12:54', '2022-07-06', 'masuk', '2022-07-05 18:12:48', '2022-07-05 18:12:54'),
(21, 4, '01:20:49', '01:25:08', '2022-07-06', 'masuk', '2022-07-05 18:20:49', '2022-07-05 18:25:08'),
(22, 2, '22:25:41', '22:25:41', '2022-07-09', 'masuk', '2022-07-06 15:25:41', '2022-07-06 15:25:41'),
(23, 4, '22:25:41', '22:25:41', '2022-07-09', 'masuk', '2022-07-06 15:25:41', '2022-07-06 15:25:41'),
(24, 5, '22:25:41', '22:25:41', '2022-07-09', 'masuk', '2022-07-06 15:25:41', '2022-07-06 15:25:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `karyawan`
--

CREATE TABLE `karyawan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_fingerprint` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('tambah','aktif','hapus','ubah') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tambah',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `karyawan`
--

INSERT INTO `karyawan` (`id`, `nama`, `email`, `alamat`, `id_fingerprint`, `status`, `created_at`, `updated_at`) VALUES
(2, 'Farras Aldi Alfikri', 'admin@faras.xyz', 'Villa Tangerang Elok', '1', 'aktif', '2022-07-03 19:32:25', '2022-07-05 18:00:26'),
(4, 'Reza Maulana', 'admina@faras.xyz', 'tangerang', '2', 'aktif', '2022-07-03 22:48:19', '2022-07-05 18:18:13'),
(5, 'Dzikri aizen', 'admin3@faras.xyz', 'Perum', '3', 'tambah', '2022-07-06 15:23:18', '2022-07-06 15:35:19'),
(6, 'doni maulia', 'doni@gmail.com', 'kejaten', '4', 'tambah', '2022-07-06 15:36:10', '2022-07-06 15:36:10'),
(7, 'maulia aditia', 'maulia@gmail.com', 'cibadak', '5', 'tambah', '2022-07-06 15:36:55', '2022-07-06 15:36:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_06_18_190246_create_karyawans_table', 2),
(6, '2022_06_20_172854_create_absens_table', 2),
(7, '2022_06_24_001657_create_penggajians_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `penggajian`
--

CREATE TABLE `penggajian` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `karyawan_id` bigint(20) UNSIGNED NOT NULL,
  `gaji_pokok` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `lembur` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `bonus` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `thr` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `penggajian`
--

INSERT INTO `penggajian` (`id`, `karyawan_id`, `gaji_pokok`, `lembur`, `bonus`, `thr`, `created_at`, `updated_at`) VALUES
(1, 2, '200000', '50000', '25000', '100000', '2022-07-03 19:32:25', '2022-07-05 15:48:15'),
(3, 4, '150000', '100000', '25000', '100000', '2022-07-03 22:48:19', '2022-07-04 19:02:24'),
(4, 5, '100000', '50000', '0', '0', '2022-07-06 15:23:18', '2022-07-06 15:23:56'),
(5, 6, '0', '0', '0', '0', '2022-07-06 15:36:10', '2022-07-06 15:36:10'),
(6, 7, '0', '0', '0', '0', '2022-07-06 15:36:55', '2022-07-06 15:36:55');

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','pimpinan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'admin',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`, `updated_at`) VALUES
(1, 'Admin Admin', 'admin@argon.com', '$2y$10$SmKYPq2UuoZ3RG9Q/8eK5eYCv2.bYunZ4MkcwoChYAstDiwh26CQa', 'admin', '2022-07-03 19:23:06', '2022-07-03 19:23:06'),
(2, 'Reza', 'admin@gmail.com', '$2y$10$AVIkOEFon54BioLZkRXA3eZOkXV3r3MCL8jOEiWQ5BSiAGnC96vZq', 'admin', '2022-07-03 19:25:27', '2022-07-03 19:25:27'),
(3, 'Farras Aldi Alfikri', 'farasaldi30@gmail.com', '$2y$10$lg4enz3xkGU2.YoMeOC0XOxV4vH9fiHNK5k26EQxYxKuVmgT8Vn.K', 'pimpinan', '2022-07-05 11:24:06', '2022-07-05 11:24:06');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `karyawan_email_unique` (`email`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `penggajian`
--
ALTER TABLE `penggajian`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absen`
--
ALTER TABLE `absen`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `penggajian`
--
ALTER TABLE `penggajian`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
