-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 25 Agu 2026 pada 18.22
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
-- Basis data: `db_web_monitoring`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `anggota_kelompok`
--

CREATE TABLE `anggota_kelompok` (
  `id` bigint UNSIGNED NOT NULL,
  `kelompok_id` bigint UNSIGNED NOT NULL,
  `nama_anggota` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jenis_sampah`
--

CREATE TABLE `jenis_sampah` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `contoh` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `jenis_sampah`
--

INSERT INTO `jenis_sampah` (`id`, `nama_jenis`, `deskripsi`, `contoh`, `created_at`, `updated_at`) VALUES
(1, 'Organik', 'Sampah yang berasal dari makhluk hidup dan mudah terurai secara alami', 'Sisa makanan, kulit buah, sayuran busuk, daun kering, dan ranting pohon', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(2, 'Anorganik', 'Sampah yang tidak mudah terurai dan berasal dari bahan non-organik', 'Botol plastik, kantong plastik, kaleng, dan gelas kaca', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(3, 'Kertas', 'Sampah berbahan dasar kertas yang dapat didaur ulang', 'Kardus, koran, buku bekas, dan bungkus kertas', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(4, 'B3 (Bahan Berbahaya dan Beracun)', 'Sampah yang mengandung bahan berbahaya dan memerlukan penanganan khusus', 'Baterai bekas, lampu neon, aki, dan kemasan obat kimia', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(5, 'Residu', 'Sampah sisa yang tidak dapat didaur ulang atau dimanfaatkan kembali', 'Popok bayi sekali pakai, pembalut wanita, tisu basah, dan puntung rokok', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(6, 'Organik', 'Sampah yang berasal dari makhluk hidup dan mudah terurai secara alami', 'Sisa makanan, kulit buah, sayuran busuk, daun kering, dan ranting pohon', '2026-08-22 03:55:22', '2026-08-22 03:55:22'),
(7, 'Anorganik', 'Sampah yang tidak mudah terurai dan berasal dari bahan non-organik', 'Botol plastik, kantong plastik, kaleng, dan gelas kaca', '2026-08-22 03:55:22', '2026-08-22 03:55:22'),
(8, 'Kertas', 'Sampah berbahan dasar kertas yang dapat didaur ulang', 'Kardus, koran, buku bekas, dan bungkus kertas', '2026-08-22 03:55:22', '2026-08-22 03:55:22'),
(9, 'B3 (Bahan Berbahaya dan Beracun)', 'Sampah yang mengandung bahan berbahaya dan memerlukan penanganan khusus', 'Baterai bekas, lampu neon, aki, dan kemasan obat kimia', '2026-08-22 03:55:22', '2026-08-22 03:55:22'),
(10, 'Residu', 'Sampah sisa yang tidak dapat didaur ulang atau dimanfaatkan kembali', 'Popok bayi sekali pakai, pembalut wanita, tisu basah, dan puntung rokok', '2026-08-22 03:55:22', '2026-08-22 03:55:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kelompok`
--

CREATE TABLE `kelompok` (
  `id` bigint UNSIGNED NOT NULL,
  `nama_kelompok` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `kelompok`
--

INSERT INTO `kelompok` (`id`, `nama_kelompok`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'TPA 1', 'Tempat Pembuangan Akhir 1', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(2, 'TPA 2', 'Tempat Pembuangan Akhir 2', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(3, 'IPAL 1', 'Instalasi Pengolahan Air Limbah 1', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(4, 'IPAL 2', 'Instalasi Pengolahan Air Limbah 2', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(5, 'KRAMAT', 'Kelompok Kramat', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(6, 'PONCOL', 'Kelompok Poncol', '2026-08-22 03:54:51', '2026-08-22 03:54:51'),
(7, 'CIPEUCANG', 'Kelompok Cipeucang', '2026-08-22 03:54:51', '2026-08-22 03:54:51');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_04_19_224228_create_sampahs_table', 1),
(6, '2026_04_19_224229_create_trackings_table', 1),
(7, '2026_04_20_011500_add_session_id_to_trackings_table', 2),
(8, '2026_04_20_021500_add_username_to_users_table', 3),
(9, '2026_04_27_220700_add_tracking_images_columns', 4),
(10, '2026_08_22_100000_create_kelompok_sampah_tables', 5),
(11, '2026_08_22_113055_add_tugas_fields_to_trackings_table', 6),
(12, '2026_08_22_114131_add_kelompok_to_users_table', 7),
(13, '2026_08_26_000001_add_anggota_petugas_id_to_users_table', 8),
(14, '2026_08_26_000002_add_anggota_nama_to_users_table', 9),
(15, '2026_08_26_000003_drop_anggota_nama_from_users_table', 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(43, 'App\\Models\\User', 4, 'web-gis-token', 'e082a71816f725b92f5894952d8980222dbdfa3ef520e789a8b856e535c3cf97', '[\"*\"]', '2026-06-23 04:53:29', NULL, '2026-06-23 04:51:54', '2026-06-23 04:53:29'),
(103, 'App\\Models\\User', 1, 'web-gis-token', 'e1182dc42b96ccb03ae6a647d9d2fcc87a2162e20a9985f1a29bcea46297af2b', '[\"*\"]', '2026-08-25 11:14:37', NULL, '2026-08-25 11:10:59', '2026-08-25 11:14:37');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sampahs`
--

CREATE TABLE `sampahs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(11,7) NOT NULL,
  `keterangan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sampahs`
--

INSERT INTO `sampahs` (`id`, `user_id`, `latitude`, `longitude`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 5, -6.3356100, 107.0030167, 'Laporan titik sampah', '2026-07-13 00:30:20', '2026-07-13 00:30:20'),
(3, 5, -6.3355246, 107.0029045, 'Laporan titik sampah', '2026-07-13 19:22:15', '2026-07-13 19:22:15'),
(4, 5, -6.3352700, 107.0029383, 'Laporan titik sampah', '2026-07-14 18:54:06', '2026-07-14 18:54:06'),
(5, 5, -6.3347055, 107.0023389, 'Laporan titik sampah', '2026-07-15 20:43:12', '2026-07-15 20:43:12'),
(6, 5, -6.3347055, 107.0023389, 'Laporan titik sampah', '2026-07-15 20:43:13', '2026-07-15 20:43:13'),
(7, 5, -6.3354267, 107.0026983, 'Laporan titik sampah', '2026-07-16 19:13:52', '2026-07-16 19:13:52'),
(8, 5, -6.3353641, 107.0028925, 'Laporan titik sampah', '2026-07-19 19:07:36', '2026-07-19 19:07:36'),
(9, 5, -6.3243243, 107.0116031, 'Laporan titik sampah', '2026-07-20 19:07:28', '2026-07-20 19:07:28'),
(10, 5, -6.3356500, 107.0029567, 'Laporan titik sampah', '2026-07-21 19:06:09', '2026-07-21 19:06:09'),
(11, 5, -6.3352700, 107.0030487, 'Laporan titik sampah', '2026-07-22 23:52:23', '2026-07-22 23:52:23'),
(12, 5, -6.3350511, 107.0031764, 'Laporan titik sampah', '2026-07-23 21:17:44', '2026-07-23 21:17:44'),
(13, 5, -6.3352360, 107.0030661, 'Laporan titik sampah', '2026-07-26 21:51:11', '2026-07-26 21:51:11'),
(14, 5, -6.3354086, 107.0029387, 'Laporan titik sampah', '2026-07-28 06:39:15', '2026-07-28 06:39:15'),
(15, 5, -6.3351717, 107.0030584, 'Laporan titik sampah', '2026-07-28 21:34:16', '2026-07-28 21:34:16'),
(16, 5, -6.3355142, 107.0028951, 'Laporan titik sampah', '2026-07-29 20:29:55', '2026-07-29 20:29:55'),
(17, 5, -6.3354529, 107.0029229, 'Laporan titik sampah', '2026-07-31 02:30:42', '2026-07-31 02:30:42');

-- --------------------------------------------------------

--
-- Struktur dari tabel `trackings`
--

CREATE TABLE `trackings` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `latitude` decimal(10,7) NOT NULL,
  `longitude` decimal(11,7) NOT NULL,
  `image_before_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image_after_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jenis_sampah` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tanggal_tugas` date DEFAULT NULL,
  `waktu_mulai` time DEFAULT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `lokasi_tugas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `session_id` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tracked_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `trackings`
--

INSERT INTO `trackings` (`id`, `user_id`, `latitude`, `longitude`, `image_before_path`, `image_after_path`, `jenis_sampah`, `tanggal_tugas`, `waktu_mulai`, `waktu_selesai`, `lokasi_tugas`, `catatan`, `session_id`, `tracked_at`, `created_at`, `updated_at`) VALUES
(13, 5, -6.3356100, 107.0030167, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:30:17', '2026-07-13 00:30:20', '2026-07-13 00:30:20'),
(14, 5, -6.3356150, 107.0030433, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:30:22', '2026-07-13 00:30:24', '2026-07-13 00:30:24'),
(15, 5, -6.3356167, 107.0030583, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:30:27', '2026-07-13 00:30:29', '2026-07-13 00:30:29'),
(16, 5, -6.3356000, 107.0030700, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:30:32', '2026-07-13 00:30:34', '2026-07-13 00:30:34'),
(17, 5, -6.3355950, 107.0030717, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:30:37', '2026-07-13 00:30:39', '2026-07-13 00:30:39'),
(18, 5, -6.3355967, 107.0030767, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:30:42', '2026-07-13 00:30:44', '2026-07-13 00:30:44'),
(19, 5, -6.3355550, 107.0030867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:30:47', '2026-07-13 00:30:49', '2026-07-13 00:30:49'),
(20, 5, -6.3355567, 107.0030883, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:30:52', '2026-07-13 00:30:54', '2026-07-13 00:30:54'),
(21, 5, -6.3355533, 107.0030883, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:30:57', '2026-07-13 00:30:59', '2026-07-13 00:30:59'),
(22, 5, -6.3355533, 107.0030883, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:02', '2026-07-13 00:31:04', '2026-07-13 00:31:04'),
(23, 5, -6.3355533, 107.0030867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:07', '2026-07-13 00:31:09', '2026-07-13 00:31:09'),
(24, 5, -6.3355283, 107.0030600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:12', '2026-07-13 00:31:14', '2026-07-13 00:31:14'),
(25, 5, -6.3355483, 107.0030783, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:18', '2026-07-13 00:31:20', '2026-07-13 00:31:20'),
(26, 5, -6.3355500, 107.0030783, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:22', '2026-07-13 00:31:24', '2026-07-13 00:31:24'),
(27, 5, -6.3355483, 107.0030867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:28', '2026-07-13 00:31:30', '2026-07-13 00:31:30'),
(28, 5, -6.3355471, 107.0030877, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:32', '2026-07-13 00:31:34', '2026-07-13 00:31:34'),
(29, 5, -6.3355517, 107.0031050, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:38', '2026-07-13 00:31:40', '2026-07-13 00:31:40'),
(30, 5, -6.3355417, 107.0031017, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:42', '2026-07-13 00:31:44', '2026-07-13 00:31:44'),
(31, 5, -6.3355424, 107.0031034, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:47', '2026-07-13 00:31:49', '2026-07-13 00:31:49'),
(32, 5, -6.3355404, 107.0031023, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:52', '2026-07-13 00:31:54', '2026-07-13 00:31:54'),
(33, 5, -6.3355133, 107.0031017, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:31:58', '2026-07-13 00:32:00', '2026-07-13 00:32:00'),
(34, 5, -6.3355117, 107.0031017, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:02', '2026-07-13 00:32:04', '2026-07-13 00:32:04'),
(35, 5, -6.3355123, 107.0031031, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:07', '2026-07-13 00:32:09', '2026-07-13 00:32:09'),
(36, 5, -6.3355119, 107.0031040, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:12', '2026-07-13 00:32:14', '2026-07-13 00:32:14'),
(37, 5, -6.3354450, 107.0030917, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:18', '2026-07-13 00:32:20', '2026-07-13 00:32:20'),
(38, 5, -6.3354083, 107.0030583, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:23', '2026-07-13 00:32:25', '2026-07-13 00:32:25'),
(39, 5, -6.3354075, 107.0030602, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:27', '2026-07-13 00:32:29', '2026-07-13 00:32:29'),
(40, 5, -6.3354075, 107.0030602, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:33', '2026-07-13 00:32:35', '2026-07-13 00:32:35'),
(41, 5, -6.3354075, 107.0030602, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:38', '2026-07-13 00:32:40', '2026-07-13 00:32:40'),
(42, 5, -6.3354075, 107.0030602, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:42', '2026-07-13 00:32:44', '2026-07-13 00:32:44'),
(43, 5, -6.3354013, 107.0030658, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:47', '2026-07-13 00:32:49', '2026-07-13 00:32:49'),
(44, 5, -6.3353833, 107.0030817, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:52', '2026-07-13 00:32:54', '2026-07-13 00:32:54'),
(45, 5, -6.3353800, 107.0030783, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:32:57', '2026-07-13 00:32:59', '2026-07-13 00:32:59'),
(46, 5, -6.3353900, 107.0030050, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:33:03', '2026-07-13 00:33:05', '2026-07-13 00:33:05'),
(47, 5, -6.3353950, 107.0029233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:33:08', '2026-07-13 00:33:10', '2026-07-13 00:33:10'),
(48, 5, -6.3356100, 107.0030167, 'tracking_photos/before/A0CeJK4558NAhbCeNhjh2zziOIq4i3wmyqiHkewC.jpg', 'tracking_photos/after/VIFoccvKn5eQYjSw3ujBQ7iE4vBKyY0DfFqj9ELU.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '4085f4c1-188e-4667-9c8e-07237fc1eb1f', '2026-07-13 00:33:00', '2026-07-13 00:33:13', '2026-07-13 00:33:13'),
(49, 5, -6.3354167, 107.0029217, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:33:13', '2026-07-13 00:33:15', '2026-07-13 00:33:15'),
(50, 5, -6.3356100, 107.0030167, 'tracking_photos/before/cJQWvzsS9qWgMgLSaaioaKswB4JNcq3Ua2s3WhGV.jpg', 'tracking_photos/after/70dAg74ZtlokuuB4l448CcCo8FNFiSitAyvTCpTE.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '4085f4c1-188e-4667-9c8e-07237fc1eb1f', '2026-07-13 00:33:08', '2026-07-13 00:33:18', '2026-07-13 00:33:18'),
(51, 5, -6.3354217, 107.0029117, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:33:17', '2026-07-13 00:33:19', '2026-07-13 00:33:19'),
(52, 5, -6.3354083, 107.0029367, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'db22e42c-ba2c-4527-9423-75fe6b3d5f9b', '2026-07-13 00:33:22', '2026-07-13 00:33:24', '2026-07-13 00:33:24'),
(53, 5, -6.3354570, 107.0028970, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:08', '2026-07-13 19:22:08', '2026-07-13 19:22:08'),
(54, 5, -6.3355246, 107.0029045, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:14', '2026-07-13 19:22:14', '2026-07-13 19:22:14'),
(55, 5, -6.3354897, 107.0028796, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:20', '2026-07-13 19:22:20', '2026-07-13 19:22:20'),
(56, 5, -6.3354946, 107.0028769, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:25', '2026-07-13 19:22:25', '2026-07-13 19:22:25'),
(57, 5, -6.3355242, 107.0029008, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:31', '2026-07-13 19:22:31', '2026-07-13 19:22:31'),
(58, 5, -6.3355790, 107.0028876, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:35', '2026-07-13 19:22:35', '2026-07-13 19:22:35'),
(59, 5, -6.3355246, 107.0029045, 'tracking_photos/before/ufdyb9HrxrZpx3I4EyWvXruOK0FlaWMqLTQTpUIB.jpg', 'tracking_photos/after/CmH7YH9eolhMGSI8Grb8eVlB2gRm5k2dHXBnJ62p.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 'feca6f39-f106-4acd-8e1b-f79e0c33136b', '2026-07-13 19:22:39', '2026-07-13 19:22:41', '2026-07-13 19:22:41'),
(60, 5, -6.3355832, 107.0028994, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:40', '2026-07-13 19:22:41', '2026-07-13 19:22:41'),
(61, 5, -6.3355866, 107.0028984, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:45', '2026-07-13 19:22:45', '2026-07-13 19:22:45'),
(62, 5, -6.3355883, 107.0028871, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:51', '2026-07-13 19:22:51', '2026-07-13 19:22:51'),
(63, 5, -6.3355931, 107.0028867, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:22:55', '2026-07-13 19:22:55', '2026-07-13 19:22:55'),
(64, 5, -6.3355933, 107.0028834, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:23:01', '2026-07-13 19:23:01', '2026-07-13 19:23:01'),
(65, 5, -6.3355966, 107.0028833, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '6aa30203-2c74-4c7f-bd47-2edbb32e4805', '2026-07-13 19:23:06', '2026-07-13 19:23:06', '2026-07-13 19:23:06'),
(66, 5, -6.3320336, 107.0013522, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff6b5987-4af4-48d2-b2cb-ddac16f53a13', '2026-07-14 18:53:54', '2026-07-14 18:53:56', '2026-07-14 18:53:56'),
(67, 5, -6.3320336, 107.0013522, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff6b5987-4af4-48d2-b2cb-ddac16f53a13', '2026-07-14 18:54:03', '2026-07-14 18:54:03', '2026-07-14 18:54:03'),
(68, 5, -6.3355667, 107.0029233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff6b5987-4af4-48d2-b2cb-ddac16f53a13', '2026-07-14 18:54:09', '2026-07-14 18:54:09', '2026-07-14 18:54:09'),
(69, 5, -6.3355667, 107.0029233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff6b5987-4af4-48d2-b2cb-ddac16f53a13', '2026-07-14 18:54:13', '2026-07-14 18:54:13', '2026-07-14 18:54:13'),
(70, 5, -6.3355533, 107.0029300, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff6b5987-4af4-48d2-b2cb-ddac16f53a13', '2026-07-14 18:54:18', '2026-07-14 18:54:19', '2026-07-14 18:54:19'),
(71, 5, -6.3355517, 107.0029367, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff6b5987-4af4-48d2-b2cb-ddac16f53a13', '2026-07-14 18:54:23', '2026-07-14 18:54:24', '2026-07-14 18:54:24'),
(72, 5, -6.3352700, 107.0029383, 'tracking_photos/before/xq9wENBRdY7ikHJInW8Ob641jHfxRLq4iVlPWe66.jpg', 'tracking_photos/after/9RmE9nVUCDQK9BPL9jpEYnSea7OVpyzpSKnk5dIe.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2705d750-bd19-4105-87ac-bcd6ad7ddb52', '2026-07-14 18:54:25', '2026-07-14 18:54:27', '2026-07-14 18:54:27'),
(73, 5, -6.3355517, 107.0029367, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff6b5987-4af4-48d2-b2cb-ddac16f53a13', '2026-07-14 18:54:28', '2026-07-14 18:54:28', '2026-07-14 18:54:28'),
(74, 5, -6.3355583, 107.0029350, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'ff6b5987-4af4-48d2-b2cb-ddac16f53a13', '2026-07-14 18:54:33', '2026-07-14 18:54:34', '2026-07-14 18:54:34'),
(75, 5, -6.3347055, 107.0023389, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7d62b694-ffa2-4dec-a3c9-0db874f922bd', '2026-07-15 20:42:49', '2026-07-15 20:42:50', '2026-07-15 20:42:50'),
(76, 5, -6.3347055, 107.0023389, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '7d62b694-ffa2-4dec-a3c9-0db874f922bd', '2026-07-15 20:43:11', '2026-07-15 20:43:12', '2026-07-15 20:43:12'),
(77, 5, -6.3347055, 107.0023389, 'tracking_photos/before/Etp1syxToLHaGE44L45a3017bSBUvLdxMYvB0zJi.jpg', 'tracking_photos/after/FUFk0jomedj95q4EGJ8GQx4EsSYzwu913R5SdH7S.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '7a95999b-6c59-482e-bcf7-389a2d01f9d7', '2026-07-15 20:43:40', '2026-07-15 20:43:44', '2026-07-15 20:43:44'),
(78, 5, -6.3323532, 107.0013522, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3693ef27-c87c-412b-a35f-94debd8a387c', '2026-07-16 19:13:44', '2026-07-16 19:13:44', '2026-07-16 19:13:44'),
(79, 5, -6.3354267, 107.0026983, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3693ef27-c87c-412b-a35f-94debd8a387c', '2026-07-16 19:13:52', '2026-07-16 19:13:52', '2026-07-16 19:13:52'),
(80, 5, -6.3355133, 107.0030100, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3693ef27-c87c-412b-a35f-94debd8a387c', '2026-07-16 19:13:58', '2026-07-16 19:13:58', '2026-07-16 19:13:58'),
(81, 5, -6.3351883, 107.0029483, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3693ef27-c87c-412b-a35f-94debd8a387c', '2026-07-16 19:14:03', '2026-07-16 19:14:03', '2026-07-16 19:14:03'),
(82, 5, -6.3351817, 107.0030767, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3693ef27-c87c-412b-a35f-94debd8a387c', '2026-07-16 19:14:08', '2026-07-16 19:14:08', '2026-07-16 19:14:08'),
(83, 5, -6.3354267, 107.0026983, 'tracking_photos/before/fVgmu9hsgkjTGISMlzKualVjRagfx9SrJPuetmJq.jpg', 'tracking_photos/after/Ie4Ys7mZH3mwtGLVxhHA48mZJYuVtCNp51ToKDWs.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '8b12bb5b-a153-40be-8fd1-05ca6fcf6d4a', '2026-07-16 19:14:09', '2026-07-16 19:14:11', '2026-07-16 19:14:11'),
(84, 5, -6.3355017, 107.0025217, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3693ef27-c87c-412b-a35f-94debd8a387c', '2026-07-16 19:14:12', '2026-07-16 19:14:12', '2026-07-16 19:14:12'),
(85, 5, -6.3353604, 107.0028921, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:07:27', '2026-07-19 19:07:30', '2026-07-19 19:07:30'),
(86, 5, -6.3353641, 107.0028925, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:07:33', '2026-07-19 19:07:36', '2026-07-19 19:07:36'),
(87, 5, -6.3353633, 107.0029199, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:07:39', '2026-07-19 19:07:42', '2026-07-19 19:07:42'),
(88, 5, -6.3354813, 107.0030075, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:07:42', '2026-07-19 19:07:45', '2026-07-19 19:07:45'),
(89, 5, -6.3354910, 107.0030129, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:07:46', '2026-07-19 19:07:49', '2026-07-19 19:07:49'),
(90, 5, -6.3354922, 107.0030152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:07:52', '2026-07-19 19:07:55', '2026-07-19 19:07:55'),
(91, 5, -6.3354921, 107.0030152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:07:56', '2026-07-19 19:07:59', '2026-07-19 19:07:59'),
(92, 5, -6.3354921, 107.0030152, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:07:59', '2026-07-19 19:08:02', '2026-07-19 19:08:02'),
(93, 5, -6.3354383, 107.0029161, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:08:03', '2026-07-19 19:08:06', '2026-07-19 19:08:06'),
(94, 5, -6.3353641, 107.0028925, 'tracking_photos/before/z6gDSKXCuts7yNm374Hw5hnJPhnHsdj6oL2T6Ip9.jpg', 'tracking_photos/after/xaLduBLtgmGMxqvm314wJ5CutTnoJLPPPulomRJ9.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 'b57dd12a-f655-4747-ac1a-bac0d5495527', '2026-07-19 19:08:00', '2026-07-19 19:08:08', '2026-07-19 19:08:08'),
(95, 5, -6.3354369, 107.0029196, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '9ba74f27-122c-412e-88b5-fce55723f9d5', '2026-07-19 19:08:06', '2026-07-19 19:08:09', '2026-07-19 19:08:09'),
(96, 5, -6.3354107, 107.0029142, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'd57d2069-0153-4aa9-8bca-7d26079cfcf6', '2026-07-19 19:08:11', '2026-07-19 19:08:14', '2026-07-19 19:08:14'),
(97, 5, -6.3243243, 107.0116031, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '216e3807-07d3-43bd-8b18-69490180cb66', '2026-07-20 19:07:22', '2026-07-20 19:07:25', '2026-07-20 19:07:25'),
(98, 5, -6.3243243, 107.0116031, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '216e3807-07d3-43bd-8b18-69490180cb66', '2026-07-20 19:07:28', '2026-07-20 19:07:31', '2026-07-20 19:07:31'),
(99, 5, -6.3243243, 107.0116031, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '216e3807-07d3-43bd-8b18-69490180cb66', '2026-07-20 19:07:33', '2026-07-20 19:07:36', '2026-07-20 19:07:36'),
(100, 5, -6.3243243, 107.0116031, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '216e3807-07d3-43bd-8b18-69490180cb66', '2026-07-20 19:07:38', '2026-07-20 19:07:41', '2026-07-20 19:07:41'),
(101, 5, -6.3243243, 107.0116031, 'tracking_photos/before/aLDeb1l29iYnsTzJ7419PAgb9AUiG7tJdssDZz0s.jpg', 'tracking_photos/after/72PRwsxVlb1OFqD17SLD2r4O6ZU8aEDap8L57QRf.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '0631fa28-39aa-41c1-b0fe-17b64ad01935', '2026-07-20 19:07:43', '2026-07-20 19:07:49', '2026-07-20 19:07:49'),
(102, 5, -6.3356500, 107.0029567, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a95b2a2f-5915-4e05-89a5-600a6029edea', '2026-07-21 19:06:00', '2026-07-21 19:06:03', '2026-07-21 19:06:03'),
(103, 5, -6.3356500, 107.0029567, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a95b2a2f-5915-4e05-89a5-600a6029edea', '2026-07-21 19:06:06', '2026-07-21 19:06:09', '2026-07-21 19:06:09'),
(104, 5, -6.3356433, 107.0030417, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a95b2a2f-5915-4e05-89a5-600a6029edea', '2026-07-21 19:06:11', '2026-07-21 19:06:15', '2026-07-21 19:06:15'),
(105, 5, -6.3357017, 107.0030567, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'a95b2a2f-5915-4e05-89a5-600a6029edea', '2026-07-21 19:06:16', '2026-07-21 19:06:20', '2026-07-21 19:06:20'),
(106, 5, -6.3356650, 107.0030533, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:06:37', '2026-07-21 19:06:40', '2026-07-21 19:06:40'),
(107, 5, -6.3357017, 107.0030400, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:06:42', '2026-07-21 19:06:45', '2026-07-21 19:06:45'),
(108, 5, -6.3356617, 107.0030483, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:06:47', '2026-07-21 19:06:50', '2026-07-21 19:06:50'),
(109, 5, -6.3356617, 107.0030483, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:06:51', '2026-07-21 19:06:55', '2026-07-21 19:06:55'),
(110, 5, -6.3356617, 107.0030483, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:06:57', '2026-07-21 19:07:00', '2026-07-21 19:07:00'),
(111, 5, -6.3357867, 107.0029233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:07:02', '2026-07-21 19:07:05', '2026-07-21 19:07:05'),
(112, 5, -6.3357783, 107.0029233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:07:06', '2026-07-21 19:07:09', '2026-07-21 19:07:09'),
(113, 5, -6.3357783, 107.0029233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:07:11', '2026-07-21 19:07:14', '2026-07-21 19:07:14'),
(114, 5, -6.3357783, 107.0029233, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:07:17', '2026-07-21 19:07:20', '2026-07-21 19:07:20'),
(115, 5, -6.3356500, 107.0029567, 'tracking_photos/before/FzaXHQ7hKcgOsgnhd6gGjJugMf7yyQLRTt0Rp5SI.jpg', 'tracking_photos/after/pE1wTtviYOX0SGySBYFyZoyfzKK59TbhzCz1UqEF.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '25185ba1-4788-4bb2-995d-5df4b9191a5e', '2026-07-21 19:07:15', '2026-07-21 19:07:25', '2026-07-21 19:07:25'),
(116, 5, -6.3357333, 107.0029517, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:07:21', '2026-07-21 19:07:25', '2026-07-21 19:07:25'),
(117, 5, -6.3357333, 107.0029517, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '32d3adfd-e7e4-4b99-854e-9b11592c201d', '2026-07-21 19:07:25', '2026-07-21 19:07:29', '2026-07-21 19:07:29'),
(118, 5, -6.3352700, 107.0030487, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1b6958df-4d06-448d-8db1-fa813371fb47', '2026-07-22 18:50:37', '2026-07-22 23:51:41', '2026-07-22 23:51:41'),
(119, 5, -6.3352700, 107.0030487, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1b6958df-4d06-448d-8db1-fa813371fb47', '2026-07-22 18:50:44', '2026-07-22 23:51:47', '2026-07-22 23:51:47'),
(120, 5, -6.3352700, 107.0030487, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1b6958df-4d06-448d-8db1-fa813371fb47', '2026-07-22 18:51:20', '2026-07-22 23:52:23', '2026-07-22 23:52:23'),
(121, 5, -6.3352700, 107.0030487, 'tracking_photos/before/yzF0RJxG0J0AVQRZPnsp3eSX0GBZyrjx29fjsfKd.jpg', 'tracking_photos/after/uLGwyVyckxmz6GhPLUHsEIRtGaUBf1g4a70G0pTK.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '01598d03-f22d-457f-aeb9-d151b4ce3675', '2026-07-22 18:51:48', '2026-07-22 23:53:00', '2026-07-22 23:53:00'),
(122, 5, -6.3351560, 107.0031516, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3c33ae02-e409-40f7-ad64-05644da7d62a', '2026-07-23 19:15:17', '2026-07-23 21:16:02', '2026-07-23 21:16:02'),
(123, 5, -6.3350511, 107.0031764, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1c06bbd7-aee7-4db3-91dc-934c56520160', '2026-07-23 19:16:58', '2026-07-23 21:17:43', '2026-07-23 21:17:43'),
(124, 5, -6.3350511, 107.0031764, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1c06bbd7-aee7-4db3-91dc-934c56520160', '2026-07-23 19:17:05', '2026-07-23 21:17:50', '2026-07-23 21:17:50'),
(125, 5, -6.3350511, 107.0031764, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1c06bbd7-aee7-4db3-91dc-934c56520160', '2026-07-23 19:17:08', '2026-07-23 21:17:53', '2026-07-23 21:17:53'),
(126, 5, -6.3350511, 107.0031764, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1c06bbd7-aee7-4db3-91dc-934c56520160', '2026-07-23 19:17:13', '2026-07-23 21:17:58', '2026-07-23 21:17:58'),
(127, 5, -6.3350511, 107.0031764, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1c06bbd7-aee7-4db3-91dc-934c56520160', '2026-07-23 19:17:18', '2026-07-23 21:18:03', '2026-07-23 21:18:03'),
(128, 5, -6.3350511, 107.0031764, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '1c06bbd7-aee7-4db3-91dc-934c56520160', '2026-07-23 19:17:23', '2026-07-23 21:18:08', '2026-07-23 21:18:08'),
(129, 5, -6.3350511, 107.0031764, 'tracking_photos/before/OyIedsIylxWeDpquMhMGhdQix9XpTvI9MgnnYCwV.jpg', 'tracking_photos/after/GAOKSdaSuV1yS6niUcEg6FcZMIqo8kdByYFgPLLo.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '61c1eb82-d288-4936-9a8c-f2b2bf007ccb', '2026-07-23 19:17:23', '2026-07-23 21:18:14', '2026-07-23 21:18:14'),
(130, 5, -6.3350491, 107.0031818, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4e8efd91-46a9-4305-863a-e11ddbefc667', '2026-07-26 19:13:34', '2026-07-26 21:46:03', '2026-07-26 21:46:03'),
(131, 5, -6.3348508, 107.0032642, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4e8efd91-46a9-4305-863a-e11ddbefc667', '2026-07-26 19:13:45', '2026-07-26 21:46:14', '2026-07-26 21:46:14'),
(132, 5, -6.3348508, 107.0032642, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4e8efd91-46a9-4305-863a-e11ddbefc667', '2026-07-26 19:13:48', '2026-07-26 21:46:17', '2026-07-26 21:46:17'),
(133, 5, -6.3351574, 107.0030979, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '4e8efd91-46a9-4305-863a-e11ddbefc667', '2026-07-26 19:13:53', '2026-07-26 21:46:22', '2026-07-26 21:46:22'),
(134, 5, -6.3352360, 107.0030661, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c0712863-2209-470c-af7e-ef714f6ca075', '2026-07-26 19:18:34', '2026-07-26 21:51:04', '2026-07-26 21:51:04'),
(135, 5, -6.3352360, 107.0030661, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c0712863-2209-470c-af7e-ef714f6ca075', '2026-07-26 19:18:41', '2026-07-26 21:51:11', '2026-07-26 21:51:11'),
(136, 5, -6.3352360, 107.0030661, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'c0712863-2209-470c-af7e-ef714f6ca075', '2026-07-26 19:18:47', '2026-07-26 21:51:16', '2026-07-26 21:51:16'),
(137, 5, -6.3352360, 107.0030661, 'tracking_photos/before/0b8qSq9XnMYIPwPaIZohK8n0Vly4IHzTqQe00F6G.jpg', 'tracking_photos/after/0OULdGnpLPpGgi02ViD7Nn47QwhfRzBKTfFG9Fk0.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '0f326a87-af81-4083-b195-d7f4c09a1aaa', '2026-07-26 19:18:59', '2026-07-26 21:51:32', '2026-07-26 21:51:32'),
(138, 5, -6.3352360, 107.0030661, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28cc40b8-6240-42ef-8ca2-217186c1620c', '2026-07-27 18:39:56', '2026-07-28 06:38:03', '2026-07-28 06:38:03'),
(139, 5, -6.3350441, 107.0031600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28cc40b8-6240-42ef-8ca2-217186c1620c', '2026-07-27 18:40:05', '2026-07-28 06:38:12', '2026-07-28 06:38:12'),
(140, 5, -6.3350441, 107.0031600, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28cc40b8-6240-42ef-8ca2-217186c1620c', '2026-07-27 18:40:08', '2026-07-28 06:38:14', '2026-07-28 06:38:14'),
(141, 5, -6.3358511, 107.0026292, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28cc40b8-6240-42ef-8ca2-217186c1620c', '2026-07-27 18:40:13', '2026-07-28 06:38:20', '2026-07-28 06:38:20'),
(142, 5, -6.3354086, 107.0029387, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28cc40b8-6240-42ef-8ca2-217186c1620c', '2026-07-27 18:40:18', '2026-07-28 06:38:25', '2026-07-28 06:38:25'),
(143, 5, -6.3354086, 107.0029387, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28cc40b8-6240-42ef-8ca2-217186c1620c', '2026-07-27 18:41:08', '2026-07-28 06:39:15', '2026-07-28 06:39:15'),
(144, 5, -6.3352640, 107.0030453, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28cc40b8-6240-42ef-8ca2-217186c1620c', '2026-07-27 18:41:21', '2026-07-28 06:39:43', '2026-07-28 06:39:43'),
(145, 5, -6.3352640, 107.0030453, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '28cc40b8-6240-42ef-8ca2-217186c1620c', '2026-07-27 18:41:43', '2026-07-28 06:39:52', '2026-07-28 06:39:52'),
(146, 5, -6.3354086, 107.0029387, 'tracking_photos/before/WxW60DZqy9KVdoqpyzbZppFm2Yesl5OHp61Ajfu1.jpg', 'tracking_photos/after/4pnjNHH2dZSGzkwzgpk1Sc7kIQSIInfXlrXWHznJ.jpg', NULL, NULL, NULL, NULL, NULL, NULL, 'a1b13243-cf1c-46d7-85a8-057da292e567', '2026-07-27 18:41:39', '2026-07-28 06:40:02', '2026-07-28 06:40:02'),
(147, 5, -6.3350604, 107.0031787, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e80ba9b8-7ca0-477b-b1ab-034137a72446', '2026-07-28 19:20:12', '2026-07-28 21:32:41', '2026-07-28 21:32:41'),
(148, 5, -6.3353166, 107.0030054, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e80ba9b8-7ca0-477b-b1ab-034137a72446', '2026-07-28 19:20:28', '2026-07-28 21:32:57', '2026-07-28 21:32:57'),
(149, 5, -6.3353166, 107.0030054, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e80ba9b8-7ca0-477b-b1ab-034137a72446', '2026-07-28 19:20:34', '2026-07-28 21:33:17', '2026-07-28 21:33:17'),
(150, 5, -6.3353283, 107.0029994, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'e80ba9b8-7ca0-477b-b1ab-034137a72446', '2026-07-28 19:20:44', '2026-07-28 21:33:17', '2026-07-28 21:33:17'),
(151, 5, -6.3351717, 107.0030584, 'tracking_photos/before/g1kfOTaA9lGGlNXjj3bIpirWSpgnLkCyreudFhrB.jpg', 'tracking_photos/after/EoIAldpMRxIpcafy70o0TQm3I5K8wm9AjtyCmIFk.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '2fe8d77e-0ce8-40a2-8f61-aba7dc364271', '2026-07-28 19:22:07', '2026-07-28 21:34:40', '2026-07-28 21:34:40'),
(152, 5, -6.3353416, 107.0030047, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'b0c35767-51c1-435d-8215-bc9fda44b2c1', '2026-07-29 19:28:22', '2026-07-29 20:28:46', '2026-07-29 20:28:46'),
(153, 5, -6.3353750, 107.0029769, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '477d5d19-a219-4f52-b0ca-1c99a7cc1743', '2026-07-29 19:29:01', '2026-07-29 20:29:13', '2026-07-29 20:29:13'),
(154, 5, -6.3354506, 107.0029283, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '477d5d19-a219-4f52-b0ca-1c99a7cc1743', '2026-07-29 19:29:22', '2026-07-29 20:29:34', '2026-07-29 20:29:34'),
(155, 5, -6.3355142, 107.0028951, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '477d5d19-a219-4f52-b0ca-1c99a7cc1743', '2026-07-29 19:29:37', '2026-07-29 20:29:49', '2026-07-29 20:29:49'),
(156, 5, -6.3355142, 107.0028951, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '477d5d19-a219-4f52-b0ca-1c99a7cc1743', '2026-07-29 19:29:42', '2026-07-29 20:29:54', '2026-07-29 20:29:54'),
(157, 5, -6.3355142, 107.0028951, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '477d5d19-a219-4f52-b0ca-1c99a7cc1743', '2026-07-29 19:29:47', '2026-07-29 20:29:59', '2026-07-29 20:29:59'),
(158, 5, -6.3355142, 107.0028951, 'tracking_photos/before/dCmtVWfCkmXuV264E0EySTA0H3WA3OAnS8ARQK5K.jpg', 'tracking_photos/after/ACSdB2eJuP6ZRnHBaJYrjl4RSUSvw49pleKly9KU.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '62366764-77b5-4d5a-be2b-c60057ebc2bc', '2026-07-29 19:30:04', '2026-07-29 20:30:19', '2026-07-29 20:30:19'),
(159, 5, -6.3353283, 107.0030121, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '349d2b19-a64d-4a5c-9a75-1005cb698098', '2026-07-30 18:34:12', '2026-07-31 02:29:20', '2026-07-31 02:29:20'),
(160, 5, -6.3353530, 107.0029970, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'affe2f71-9649-410f-b3ae-2e033a55a06f', '2026-07-30 18:34:51', '2026-07-31 02:29:57', '2026-07-31 02:29:57'),
(161, 5, -6.3353530, 107.0029970, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'affe2f71-9649-410f-b3ae-2e033a55a06f', '2026-07-30 18:34:54', '2026-07-31 02:30:00', '2026-07-31 02:30:00'),
(162, 5, -6.3353996, 107.0029625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'affe2f71-9649-410f-b3ae-2e033a55a06f', '2026-07-30 18:35:11', '2026-07-31 02:30:18', '2026-07-31 02:30:18'),
(163, 5, -6.3353996, 107.0029625, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'affe2f71-9649-410f-b3ae-2e033a55a06f', '2026-07-30 18:35:15', '2026-07-31 02:30:20', '2026-07-31 02:30:20'),
(164, 5, -6.3354236, 107.0029427, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'affe2f71-9649-410f-b3ae-2e033a55a06f', '2026-07-30 18:35:24', '2026-07-31 02:30:30', '2026-07-31 02:30:30'),
(165, 5, -6.3354236, 107.0029427, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'affe2f71-9649-410f-b3ae-2e033a55a06f', '2026-07-30 18:35:26', '2026-07-31 02:30:32', '2026-07-31 02:30:32'),
(166, 5, -6.3354529, 107.0029229, 'tracking_photos/before/8YnX01BgB9ecIJMSWI66sFuliS9WKO2njWLxJB8l.jpg', 'tracking_photos/after/XESURvM89XvHBeVVjLnjtAp4Ky3fWGtCGLhAV9d7.jpg', NULL, NULL, NULL, NULL, NULL, NULL, '7f123c26-2766-4d12-9983-8e7c70a86e0c', '2026-07-30 18:36:01', '2026-07-31 02:31:11', '2026-07-31 02:31:11');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tugas_jadwal`
--

CREATE TABLE `tugas_jadwal` (
  `id` bigint UNSIGNED NOT NULL,
  `kelompok_id` bigint UNSIGNED NOT NULL,
  `jenis_sampah_id` bigint UNSIGNED NOT NULL,
  `tanggal_tugas` date NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `jam_selesai` time DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','in_progress','completed','cancelled') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `catatan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `tugas_jadwal`
--

INSERT INTO `tugas_jadwal` (`id`, `kelompok_id`, `jenis_sampah_id`, `tanggal_tugas`, `jam_mulai`, `jam_selesai`, `lokasi`, `status`, `catatan`, `created_at`, `updated_at`) VALUES
(1, 5, 1, '2026-08-23', '08:00:00', '12:00:00', 'Area Kramat Timur', 'pending', 'Pengangkutan sampah organik rutin', '2026-08-22 03:55:22', '2026-08-22 03:55:22'),
(2, 5, 2, '2026-08-24', '08:00:00', '12:00:00', 'Area Kramat Barat', 'pending', 'Pemilahan sampah anorganik', '2026-08-22 03:55:22', '2026-08-22 03:55:22'),
(3, 1, 3, '2026-08-23', '13:00:00', '16:00:00', 'TPA 1 Zona A', 'pending', 'Pengumpulan sampah kertas', '2026-08-22 03:55:22', '2026-08-22 03:55:22');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `role` enum('admin','petugas') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'petugas',
  `kelompok_id` bigint UNSIGNED DEFAULT NULL,
  `anggota_kelompok_id` bigint UNSIGNED DEFAULT NULL,
  `anggota_petugas_id` bigint UNSIGNED DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `username`, `role`, `kelompok_id`, `anggota_kelompok_id`, `anggota_petugas_id`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin Web GIS', 'admin@webgis.test', 'admin', 'admin', 6, NULL, NULL, NULL, '$2y$12$H3f11/aUqk2u/CzHpaPMqe78QAPmlrjLRbxi5vhfFN/UcoGiVpAA2', NULL, '2026-04-19 15:45:52', '2026-08-25 10:52:22'),
(2, 'Petugas Lapangan', 'petugas@webgis.test', 'petugas', 'petugas', 4, NULL, NULL, NULL, '$2y$12$H3f11/aUqk2u/CzHpaPMqe78QAPmlrjLRbxi5vhfFN/UcoGiVpAA2', NULL, '2026-04-19 15:45:52', '2026-08-25 10:52:17'),
(3, 'Joko', 'joko.ganteng@gmail.com', 'joko123', 'petugas', 3, NULL, NULL, NULL, '$2y$12$KGIuF.U0LFerIuRtTHU.Pu5gEUgSHoI2t8FyaJR3S9qwZo/0pGzXW', NULL, '2026-04-20 05:00:09', '2026-08-25 10:52:10'),
(5, 'Laman', 'sulamanlaman3@gmail.com', 'laman', 'petugas', 5, NULL, NULL, NULL, '$2y$12$gggKFD91uBH03rz42CAM2uqTCVQEpKYErK60B/5KXsoEANZHNZ.xe', NULL, '2026-07-12 20:45:07', '2026-08-25 10:48:49'),
(6, 'Abdul Rojak', 'rojak123@gmail.com', 'rojak', 'petugas', 5, NULL, NULL, NULL, '$2y$12$NWGkVxseMTLyR8s.Y9R2vOM55OeAe.eGLyXYuuu3YTPwuPjjqq0Lq', NULL, '2026-07-12 20:47:07', '2026-08-25 10:50:46'),
(7, 'Furkon', 'furkon76@gmail.com', 'furkon', 'petugas', 5, NULL, NULL, NULL, '$2y$12$RwPSn6C7SiWxs4Gz6ixeCe3M.WbL0vCIppvg1R1Op68N.wNGlatM.', NULL, '2026-07-12 20:52:41', '2026-08-25 10:50:33'),
(8, 'Hamdani', 'hamdanidani@gmail.com', 'hamdani', 'petugas', 5, NULL, NULL, NULL, '$2y$12$m.K/QyR15cgyjrsbMFaAK.30aB1/T0El98J6N5gWwdI9qDj44vWfu', NULL, '2026-07-12 20:53:31', '2026-08-25 10:50:25'),
(9, 'Chandra Dwi Wiryan', 'chandradwi90@gmail.com', 'chandra', 'petugas', 5, NULL, NULL, NULL, '$2y$12$2RA69JkbuZqTLifyLhm/4OKNFRBrzCQ38BtfFlTnap6Mo1/iULY.a', NULL, '2026-07-12 20:55:23', '2026-08-25 10:50:20'),
(10, 'Atan', 'rtatan324@gmail.com', 'atan', 'petugas', 5, NULL, NULL, NULL, '$2y$12$6Am3d3HCfR.qG6b6I5ZlROrO1ZxfuOq0zeXoIpl8RWsqYwRf9y5vi', NULL, '2026-07-12 20:56:19', '2026-08-25 10:50:15'),
(11, 'Rohman', 'rohmarohman76@gmail.com', 'rohman', 'petugas', 5, NULL, NULL, NULL, '$2y$12$lpLZ56zN8i61R2Eplxnuc.iUODw/4/VB4YHVr7Ktxw4bPD/mxb..O', NULL, '2026-07-12 21:12:38', '2026-08-25 10:50:10'),
(12, 'Jumat Saputra', 'saputraj00@gmail.com', 'jumat', 'petugas', 5, NULL, NULL, NULL, '$2y$12$u8CAsGSbJP82cuEPTQ1LqeXbufneNxfO3ErfXNyHlrek9/RWWHN2C', NULL, '2026-07-12 21:14:01', '2026-08-25 10:50:04'),
(13, 'M Nurasidin', 'idinsumbat55@gmail.com', 'idin', 'petugas', 5, NULL, NULL, NULL, '$2y$12$zuv8fa8el9eBgnfGCNxeRuK761E/gxGftMRZyCDvwOuxUHl7EehZC', NULL, '2026-07-12 21:15:50', '2026-08-25 10:49:58'),
(14, 'Roby Wijayanto', 'robbywija01@gmail.com', 'roby', 'petugas', 5, NULL, NULL, NULL, '$2y$12$QxpM8d8qwSm2gouhsLaf5u.1u5qRcVY.a5bMwhBCeJUx72Ddf72SK', NULL, '2026-07-12 21:17:24', '2026-08-25 10:49:52'),
(15, 'Damin Saepudin', 'aepdamin888@gmail.com', 'damin', 'petugas', 5, NULL, NULL, NULL, '$2y$12$fh4WfYgQdAA0GwGGRnfdwOs9arG.2k75VL/LdMpNyHpyebwzMEMJC', NULL, '2026-07-12 21:18:26', '2026-08-25 10:49:47'),
(16, 'Ahmad Dado Widodo', 'dadadado232@gmail.com', 'dado', 'petugas', 5, NULL, NULL, NULL, '$2y$12$H3f11/aUqk2u/CzHpaPMqe78QAPmlrjLRbxi5vhfFN/UcoGiVpAA2', NULL, '2026-07-12 21:20:30', '2026-08-25 10:49:42');

--
-- Indeks untuk tabel yang dibuang
--

--
-- Indeks untuk tabel `anggota_kelompok`
--
ALTER TABLE `anggota_kelompok`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota_kelompok_kelompok_id_foreign` (`kelompok_id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jenis_sampah`
--
ALTER TABLE `jenis_sampah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `sampahs`
--
ALTER TABLE `sampahs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sampahs_user_id_foreign` (`user_id`);

--
-- Indeks untuk tabel `trackings`
--
ALTER TABLE `trackings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trackings_user_id_foreign` (`user_id`),
  ADD KEY `trackings_session_id_index` (`session_id`);

--
-- Indeks untuk tabel `tugas_jadwal`
--
ALTER TABLE `tugas_jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tugas_jadwal_kelompok_id_foreign` (`kelompok_id`),
  ADD KEY `tugas_jadwal_jenis_sampah_id_foreign` (`jenis_sampah_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD KEY `users_kelompok_id_foreign` (`kelompok_id`),
  ADD KEY `users_anggota_kelompok_id_foreign` (`anggota_kelompok_id`),
  ADD KEY `users_anggota_petugas_id_foreign` (`anggota_petugas_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `anggota_kelompok`
--
ALTER TABLE `anggota_kelompok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jenis_sampah`
--
ALTER TABLE `jenis_sampah`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `kelompok`
--
ALTER TABLE `kelompok`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=104;

--
-- AUTO_INCREMENT untuk tabel `sampahs`
--
ALTER TABLE `sampahs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `trackings`
--
ALTER TABLE `trackings`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=167;

--
-- AUTO_INCREMENT untuk tabel `tugas_jadwal`
--
ALTER TABLE `tugas_jadwal`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `anggota_kelompok`
--
ALTER TABLE `anggota_kelompok`
  ADD CONSTRAINT `anggota_kelompok_kelompok_id_foreign` FOREIGN KEY (`kelompok_id`) REFERENCES `kelompok` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `sampahs`
--
ALTER TABLE `sampahs`
  ADD CONSTRAINT `sampahs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `trackings`
--
ALTER TABLE `trackings`
  ADD CONSTRAINT `trackings_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tugas_jadwal`
--
ALTER TABLE `tugas_jadwal`
  ADD CONSTRAINT `tugas_jadwal_jenis_sampah_id_foreign` FOREIGN KEY (`jenis_sampah_id`) REFERENCES `jenis_sampah` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tugas_jadwal_kelompok_id_foreign` FOREIGN KEY (`kelompok_id`) REFERENCES `kelompok` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_anggota_kelompok_id_foreign` FOREIGN KEY (`anggota_kelompok_id`) REFERENCES `anggota_kelompok` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_anggota_petugas_id_foreign` FOREIGN KEY (`anggota_petugas_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `users_kelompok_id_foreign` FOREIGN KEY (`kelompok_id`) REFERENCES `kelompok` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
