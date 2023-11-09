-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220802.ff0b2d86c9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 09, 2023 at 08:33 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gudang_beras`
--

-- --------------------------------------------------------

--
-- Table structure for table `beras`
--

CREATE TABLE `beras` (
  `id_beras` char(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `merk_beras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `berat` int(11) NOT NULL,
  `jenis_beras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_beras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sopir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plat_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_masuk_beras` date NOT NULL,
  `harga` int(11) NOT NULL,
  `stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `beras`
--

INSERT INTO `beras` (`id_beras`, `merk_beras`, `berat`, `jenis_beras`, `grade_beras`, `nama_sopir`, `plat_no`, `tanggal_masuk_beras`, `harga`, `stock`, `created_at`, `updated_at`) VALUES
('B-00001', 'Jempol', 3, 'IR64', 'GRADE A', 'rudi', 'P 8765 NB', '2023-11-08', 30000, 96, '2023-11-07 22:18:18', '2023-11-07 23:12:57'),
('B-00002', 'Jempol', 3, 'PANDAN WANGI', 'GRADE A', 'rudi', 'P 8765 NB', '2023-11-08', 31000, 200, '2023-11-07 22:18:41', '2023-11-07 23:18:01');

-- --------------------------------------------------------

--
-- Table structure for table `detail_distribusi`
--

CREATE TABLE `detail_distribusi` (
  `id_detail_distribusi` bigint(20) UNSIGNED NOT NULL,
  `id_distribusi` bigint(20) UNSIGNED NOT NULL,
  `nama_beras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_beras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah_beras` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_distribusi`
--

INSERT INTO `detail_distribusi` (`id_detail_distribusi`, `id_distribusi`, `nama_beras`, `jenis_beras`, `harga`, `jumlah_beras`, `sub_total`, `created_at`, `updated_at`) VALUES
(3, 2, 'Jempol 3 Kg IR64 GRADE A', 'IR64', 30000, 11, 330000, '2023-11-07 23:17:40', '2023-11-07 23:17:40'),
(4, 2, 'Jempol 3 Kg PANDAN WANGI GRADE A', 'PANDAN WANGI', 31000, 12, 372000, '2023-11-07 23:17:40', '2023-11-07 23:17:40'),
(5, 3, 'Jempol 3 Kg IR64 GRADE A', 'IR64', 30000, 2, 60000, '2023-11-09 00:28:13', '2023-11-09 00:28:13'),
(6, 3, 'Jempol 3 Kg PANDAN WANGI GRADE A', 'PANDAN WANGI', 31000, 2, 62000, '2023-11-09 00:28:13', '2023-11-09 00:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pengembalians`
--

CREATE TABLE `detail_pengembalians` (
  `id_detail_pengembalian` bigint(20) UNSIGNED NOT NULL,
  `id_pengembalian` bigint(20) UNSIGNED NOT NULL,
  `id_detail_distribusi` bigint(20) UNSIGNED NOT NULL,
  `nama_baras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_baras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `sub_total` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `distribusis`
--

CREATE TABLE `distribusis` (
  `id_distribusi` bigint(20) UNSIGNED NOT NULL,
  `id_toko` char(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kode_distribusi` char(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_sopir` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plat_no` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_distribusi` date NOT NULL,
  `jumlah_distribusi` int(11) NOT NULL,
  `total_harga` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `distribusis`
--

INSERT INTO `distribusis` (`id_distribusi`, `id_toko`, `kode_distribusi`, `nama_sopir`, `plat_no`, `tanggal_distribusi`, `jumlah_distribusi`, `total_harga`, `created_at`, `updated_at`) VALUES
(2, 'T-00005', 'DS1108067605', 'rudi', 'P 8765 NB', '2023-11-08', 69, 702000, '2023-11-07 23:17:40', '2023-11-07 23:17:40'),
(3, 'T-00021', 'DS1109071827', 'rudi', 'P 8765 NB', '2023-11-09', 12, 122000, '2023-11-09 00:28:13', '2023-11-09 00:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `grades`
--

CREATE TABLE `grades` (
  `id_grade` bigint(20) UNSIGNED NOT NULL,
  `grade` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grades`
--

INSERT INTO `grades` (`id_grade`, `grade`, `created_at`, `updated_at`) VALUES
(1, 'GRADE A', NULL, NULL),
(2, 'GRADE A-', NULL, NULL),
(3, 'GRADE B', NULL, NULL),
(4, 'GRADE C', NULL, NULL),
(5, 'REJECT A', NULL, NULL),
(6, 'REJECT B', NULL, NULL),
(7, 'REJECT C', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `grade_tokos`
--

CREATE TABLE `grade_tokos` (
  `id_grade_toko` bigint(20) UNSIGNED NOT NULL,
  `toko_id` char(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grade_toko` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `grade_tokos`
--

INSERT INTO `grade_tokos` (`id_grade_toko`, `toko_id`, `grade_toko`, `created_at`, `updated_at`) VALUES
(1, NULL, 'BIASA', NULL, NULL),
(2, NULL, 'SEDANG', NULL, NULL),
(3, NULL, 'TERBAIK', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jenis`
--

CREATE TABLE `jenis` (
  `id_jenis` bigint(20) UNSIGNED NOT NULL,
  `jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jenis`
--

INSERT INTO `jenis` (`id_jenis`, `jenis`, `created_at`, `updated_at`) VALUES
(1, 'IR64', NULL, NULL),
(2, 'PANDAN WANGI', NULL, NULL),
(3, 'LEGOWO', NULL, NULL),
(4, 'GRADE C', NULL, NULL),
(5, 'GH', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `merks`
--

CREATE TABLE `merks` (
  `id_merk` bigint(20) UNSIGNED NOT NULL,
  `merk` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `merks`
--

INSERT INTO `merks` (`id_merk`, `merk`, `created_at`, `updated_at`) VALUES
(1, 'Jempol', NULL, NULL),
(2, 'Wangi', NULL, NULL),
(3, 'Dua Anak', NULL, NULL),
(4, 'Ratu', NULL, NULL),
(5, 'Gajah', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_10_22_040216_create_beras_table', 1),
(6, '2023_10_22_065150_create_tokos_table', 1),
(7, '2023_10_23_022313_create_jenis_table', 1),
(8, '2023_10_23_023034_create_grades_table', 1),
(9, '2023_10_24_023750_create_distribusis_table', 1),
(10, '2023_10_24_025028_create_detail_distribusi_table', 1),
(11, '2023_10_24_143428_create_pembayarans_table', 1),
(12, '2023_10_29_050456_create_pengembalians_table', 1),
(13, '2023_10_29_050555_create_detail_pengembalians_table', 1),
(14, '2023_10_30_024337_create_merks_table', 1),
(15, '2023_10_31_013306_create_grade_tokos_table', 1),
(16, '2023_10_31_142358_create_total_stocks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayarans`
--

CREATE TABLE `pembayarans` (
  `id_pembayaran` bigint(20) UNSIGNED NOT NULL,
  `id_distribusi` bigint(20) UNSIGNED NOT NULL,
  `tanggal_tengat_pembayaran` date DEFAULT NULL,
  `tanggal_pembayaran` date DEFAULT NULL,
  `jumlah_pembayaran` int(11) DEFAULT NULL,
  `metode_pembayaran` enum('tunai','transfer') COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pembayarans`
--

INSERT INTO `pembayarans` (`id_pembayaran`, `id_distribusi`, `tanggal_tengat_pembayaran`, `tanggal_pembayaran`, `jumlah_pembayaran`, `metode_pembayaran`, `created_at`, `updated_at`) VALUES
(3, 2, '2023-11-18', NULL, NULL, NULL, '2023-11-07 23:17:40', '2023-11-07 23:17:40'),
(4, 3, '2023-11-19', NULL, NULL, NULL, '2023-11-09 00:28:13', '2023-11-09 00:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `pengembalians`
--

CREATE TABLE `pengembalians` (
  `id_pengembalian` bigint(20) UNSIGNED NOT NULL,
  `nama_toko` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_harga` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
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
-- Table structure for table `tokos`
--

CREATE TABLE `tokos` (
  `id_toko` char(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_toko` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_toko` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pemilik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_tlp` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tokos`
--

INSERT INTO `tokos` (`id_toko`, `nama_toko`, `grade_toko`, `pemilik`, `alamat`, `nomor_tlp`, `created_at`, `updated_at`) VALUES
('T-00005', 'abadi sumber', 'BIASA', 'Nimo', 'Kemiren', '081229399475', NULL, NULL),
('T-00006', 'rejeki abdul', 'BIASA', 'Joko', 'Rogojampi', '081229288956', NULL, NULL),
('T-00007', 'abdul makmur', 'BIASA', 'Senlong', 'Jl. Kalimantan', '081218251765', NULL, NULL),
('T-00009', 'sumber abadi', 'BIASA', 'Ado', 'Jl. Kalimantan', '081252256149', NULL, NULL),
('T-00010', 'sari subur', 'BIASA', 'Vander', 'Kemiren', '081237088270', NULL, NULL),
('T-00011', 'jembar subur', 'BIASA', 'Tun', 'Kemiren', '081233972266', NULL, NULL),
('T-00013', 'abdul tukul', 'BIASA', 'Ado', 'Rogojampi', '081295920916', NULL, NULL),
('T-00015', 'makmur joyo', 'BIASA', 'Senlong', 'Kemiren', '081225045127', NULL, NULL),
('T-00016', 'abadi sari', 'BIASA', 'Bon', 'Sumbersari', '081235975346', NULL, NULL),
('T-00018', 'rejeki tukul', 'BIASA', 'Nuha', 'Jl. Sumatra', '081264121719', NULL, NULL),
('T-00019', 'abadi jembar', 'BIASA', 'Akil', 'Rogojampi', '081290619893', NULL, NULL),
('T-00021', 'sumber subur', 'BIASA', 'Joko', 'Rogojampi', '081252122541', NULL, NULL),
('T-00022', 'makmur abdul', 'BIASA', 'Bon', 'Kemiren', '081296787308', NULL, NULL),
('T-00025', 'tukul joyo', 'BIASA', 'Akil', 'Rogojampi', '081268630269', NULL, NULL),
('T-00026', 'sumber jembar', 'BIASA', 'Senlong', 'Kemiren', '081281620080', NULL, NULL),
('T-00029', 'abadi rejeki', 'BIASA', 'Akil', 'Sumbersari', '081217418919', NULL, NULL),
('T-00030', 'tukul abdul', 'BIASA', 'Vander', 'Kemiren', '081294196821', NULL, NULL),
('T-00031', 'abadi joyo', 'BIASA', 'Edi', 'Jl. Kalimantan', '081298314221', NULL, NULL),
('T-00032', 'sari makmur', 'BIASA', 'Senlong', 'Blimbingsari', '081261854205', NULL, NULL),
('T-00033', 'makmur jembar', 'BIASA', 'Nuha', 'Blimbingsari', '081298898438', NULL, NULL),
('T-00034', 'joyo joyo', 'BIASA', 'Tun', 'Rogojampi', '081243956981', NULL, NULL),
('T-00035', 'joyo sari', 'BIASA', 'Jupri', 'Rogojampi', '081271908981', NULL, NULL),
('T-00036', 'sari sumber', 'BIASA', 'Tun', 'Jl. Sumatra', '081226211391', NULL, NULL),
('T-00037', 'abadi abadi', 'BIASA', 'Nuha', 'Jl. Kalimantan', '081215016862', NULL, NULL),
('T-00039', 'abadi tukul', 'BIASA', 'Akil', 'Sumbersari', '081257014221', NULL, NULL),
('T-00041', 'abadi abdul', 'BIASA', 'Tun', 'Sumbersari', '081285522282', NULL, NULL),
('T-00042', 'jembar rejeki', 'BIASA', 'Joko', 'Jl. Sumatra', '081266087868', NULL, NULL),
('T-00043', 'rejeki sumber', 'BIASA', 'Jupri', 'Blimbingsari', '081244680985', NULL, NULL),
('T-00046', 'joyo jembar', 'BIASA', 'Jupri', 'Jl. Sumatra', '081292590116', NULL, NULL),
('T-00047', 'abdul abdul', 'BIASA', 'Jupri', 'Rogojampi', '081256017402', NULL, NULL),
('T-00049', 'subur sari', 'BIASA', 'Bon', 'Rogojampi', '081297076418', NULL, NULL),
('T-00050', 'rejeki makmur', 'BIASA', 'Senlong', 'Rogojampi', '081259234194', NULL, NULL),
('T-00051', 'sumber sari', 'BIASA', 'Akil', 'Kemiren', '081289655904', NULL, NULL),
('T-00052', 'jembar makmur', 'BIASA', 'Jupri', 'Rogojampi', '081214907720', NULL, NULL),
('T-00053', 'joyo abadi', 'BIASA', 'Nuha', 'Kemiren', '081241115304', NULL, NULL),
('T-00054', 'subur rejeki', 'BIASA', 'Senlong', 'Kemiren', '081261887908', NULL, NULL),
('T-00055', 'subur tukul', 'BIASA', 'Ado', 'Sumbersari', '081215631782', NULL, NULL),
('T-00056', 'jembar sari', 'BIASA', 'Ado', 'Jl. Kalimantan', '081223773370', NULL, NULL),
('T-00059', 'tukul sumber', 'BIASA', 'Bon', 'Kemiren', '081299256983', NULL, NULL),
('T-00063', 'rejeki sari', 'BIASA', 'Senlong', 'Jl. Sumatra', '081234032274', NULL, NULL),
('T-00066', 'subur sumber', 'BIASA', 'Bon', 'Jl. Kalimantan', '081283065680', NULL, NULL),
('T-00068', 'abadi makmur', 'BIASA', 'Bon', 'Sumbersari', '081270632682', NULL, NULL),
('T-00069', 'abadi subur', 'BIASA', 'Jupri', 'Rogojampi', '081239544423', NULL, NULL),
('T-00070', 'makmur abadi', 'BIASA', 'Jupri', 'Blimbingsari', '081290579790', NULL, NULL),
('T-00071', 'makmur makmur', 'BIASA', 'Joko', 'Jl. Kalimantan', '081237959381', NULL, NULL),
('T-00072', 'makmur tukul', 'BIASA', 'Tun', 'Blimbingsari', '081277994439', NULL, NULL),
('T-00073', 'sumber abdul', 'BIASA', 'Senlong', 'Kemiren', '081240918132', NULL, NULL),
('T-00074', 'sari rejeki', 'BIASA', 'Nimo', 'Sumbersari', '081269239516', NULL, NULL),
('T-00076', 'abdul joyo', 'BIASA', 'Ado', 'Blimbingsari', '081226662944', NULL, NULL),
('T-00077', 'subur joyo', 'BIASA', 'Akil', 'Rogojampi', '081228780470', NULL, NULL),
('T-00078', 'tukul subur', 'BIASA', 'Senlong', 'Rogojampi', '081227282456', NULL, NULL),
('T-00080', 'rejeki abadi', 'BIASA', 'Akil', 'Rogojampi', '081279082211', NULL, NULL),
('T-00081', 'sari jembar', 'BIASA', 'Bon', 'Jl. Kalimantan', '081287994861', NULL, NULL),
('T-00083', 'sari abadi', 'BIASA', 'Joko', 'Blimbingsari', '081253330744', NULL, NULL),
('T-00084', 'makmur sari', 'BIASA', 'Vander', 'Jl. Kalimantan', '081242438350', NULL, NULL),
('T-00086', 'subur makmur', 'BIASA', 'Akil', 'Kemiren', '081245520669', NULL, NULL),
('T-00087', 'jembar abdul', 'BIASA', 'Joko', 'Blimbingsari', '081247659996', NULL, NULL),
('T-00090', 'makmur subur', 'BIASA', 'Jupri', 'Sumbersari', '081250611935', NULL, NULL),
('T-00092', 'joyo makmur', 'BIASA', 'Edi', 'Rogojampi', '081224695665', NULL, NULL),
('T-00094', 'subur abadi', 'BIASA', 'Tun', 'Kemiren', '081271141358', NULL, NULL),
('T-00097', 'tukul jembar', 'BIASA', 'Tun', 'Kemiren', '081246840277', NULL, NULL),
('T-00098', 'tukul abadi', 'BIASA', 'Vander', 'Kemiren', '081212086768', NULL, NULL),
('T-00099', 'sumber sumber', 'BIASA', 'Nimo', 'Sumbersari', '081253739921', NULL, NULL),
('T-00100', 'tukul sari', 'BIASA', 'Senlong', 'Kemiren', '081236153160', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `total_stocks`
--

CREATE TABLE `total_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `merk_beras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ukuran_beras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_beras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `grade_beras` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `jumlah_stock` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `total_stocks`
--

INSERT INTO `total_stocks` (`id`, `merk_beras`, `ukuran_beras`, `jenis_beras`, `grade_beras`, `harga`, `jumlah_stock`, `created_at`, `updated_at`) VALUES
(1, 'Jempol', '3', 'IR64', 'GRADE A', 30000, 63, '2023-11-07 22:18:18', '2023-11-09 00:28:13'),
(2, 'Jempol', '3', 'PANDAN WANGI', 'GRADE A', 31000, 206, '2023-11-07 22:18:41', '2023-11-09 00:28:13');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','superadmin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'superadmin', 'superadmin@gmail.com', NULL, '$2y$10$vKKwGkwjvHdKdFlfUh.5Z.dtOqdOiZR5rOJuAousIDXN15R1SNzDC', 'superadmin', NULL, NULL, NULL),
(2, 'admin', 'admin@gmail.com', NULL, '$2y$10$FJPZ5qTbgyaAUDu4UP0AY.1tBngsy4UpoY7Ba83u8UvR.UP09T49i', 'admin', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `beras`
--
ALTER TABLE `beras`
  ADD PRIMARY KEY (`id_beras`);

--
-- Indexes for table `detail_distribusi`
--
ALTER TABLE `detail_distribusi`
  ADD PRIMARY KEY (`id_detail_distribusi`),
  ADD KEY `detail_distribusi_id_distribusi_foreign` (`id_distribusi`);

--
-- Indexes for table `detail_pengembalians`
--
ALTER TABLE `detail_pengembalians`
  ADD PRIMARY KEY (`id_detail_pengembalian`),
  ADD KEY `detail_pengembalians_id_pengembalian_foreign` (`id_pengembalian`),
  ADD KEY `detail_pengembalians_id_detail_distribusi_foreign` (`id_detail_distribusi`);

--
-- Indexes for table `distribusis`
--
ALTER TABLE `distribusis`
  ADD PRIMARY KEY (`id_distribusi`),
  ADD KEY `distribusis_id_toko_foreign` (`id_toko`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `grades`
--
ALTER TABLE `grades`
  ADD PRIMARY KEY (`id_grade`);

--
-- Indexes for table `grade_tokos`
--
ALTER TABLE `grade_tokos`
  ADD PRIMARY KEY (`id_grade_toko`),
  ADD KEY `grade_tokos_toko_id_foreign` (`toko_id`);

--
-- Indexes for table `jenis`
--
ALTER TABLE `jenis`
  ADD PRIMARY KEY (`id_jenis`);

--
-- Indexes for table `merks`
--
ALTER TABLE `merks`
  ADD PRIMARY KEY (`id_merk`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD PRIMARY KEY (`id_pembayaran`),
  ADD KEY `pembayarans_id_distribusi_foreign` (`id_distribusi`);

--
-- Indexes for table `pengembalians`
--
ALTER TABLE `pengembalians`
  ADD PRIMARY KEY (`id_pengembalian`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `tokos`
--
ALTER TABLE `tokos`
  ADD PRIMARY KEY (`id_toko`);

--
-- Indexes for table `total_stocks`
--
ALTER TABLE `total_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_distribusi`
--
ALTER TABLE `detail_distribusi`
  MODIFY `id_detail_distribusi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `detail_pengembalians`
--
ALTER TABLE `detail_pengembalians`
  MODIFY `id_detail_pengembalian` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `distribusis`
--
ALTER TABLE `distribusis`
  MODIFY `id_distribusi` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `grades`
--
ALTER TABLE `grades`
  MODIFY `id_grade` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `grade_tokos`
--
ALTER TABLE `grade_tokos`
  MODIFY `id_grade_toko` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `jenis`
--
ALTER TABLE `jenis`
  MODIFY `id_jenis` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `merks`
--
ALTER TABLE `merks`
  MODIFY `id_merk` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `pembayarans`
--
ALTER TABLE `pembayarans`
  MODIFY `id_pembayaran` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengembalians`
--
ALTER TABLE `pengembalians`
  MODIFY `id_pengembalian` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `total_stocks`
--
ALTER TABLE `total_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_distribusi`
--
ALTER TABLE `detail_distribusi`
  ADD CONSTRAINT `detail_distribusi_id_distribusi_foreign` FOREIGN KEY (`id_distribusi`) REFERENCES `distribusis` (`id_distribusi`);

--
-- Constraints for table `detail_pengembalians`
--
ALTER TABLE `detail_pengembalians`
  ADD CONSTRAINT `detail_pengembalians_id_detail_distribusi_foreign` FOREIGN KEY (`id_detail_distribusi`) REFERENCES `detail_distribusi` (`id_detail_distribusi`),
  ADD CONSTRAINT `detail_pengembalians_id_pengembalian_foreign` FOREIGN KEY (`id_pengembalian`) REFERENCES `pengembalians` (`id_pengembalian`);

--
-- Constraints for table `distribusis`
--
ALTER TABLE `distribusis`
  ADD CONSTRAINT `distribusis_id_toko_foreign` FOREIGN KEY (`id_toko`) REFERENCES `tokos` (`id_toko`) ON DELETE CASCADE;

--
-- Constraints for table `grade_tokos`
--
ALTER TABLE `grade_tokos`
  ADD CONSTRAINT `grade_tokos_toko_id_foreign` FOREIGN KEY (`toko_id`) REFERENCES `tokos` (`id_toko`) ON DELETE CASCADE;

--
-- Constraints for table `pembayarans`
--
ALTER TABLE `pembayarans`
  ADD CONSTRAINT `pembayarans_id_distribusi_foreign` FOREIGN KEY (`id_distribusi`) REFERENCES `distribusis` (`id_distribusi`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
