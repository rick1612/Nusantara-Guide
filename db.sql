-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 17 Sep 2026 pada 07.53
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
-- Database: `db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `airlines`
--

CREATE TABLE `airlines` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `airlines`
--

INSERT INTO `airlines` (`id`, `code`, `name`, `logo_url`) VALUES
(1, 'GA', 'Garuda Indonesia', NULL),
(2, 'QG', 'Citilink', NULL),
(3, 'ID', 'Batik Air', NULL),
(4, 'JT', 'Lion Air', NULL),
(5, 'SJ', 'Sriwijaya Air', NULL),
(6, 'IN', 'Nam Air', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `airports`
--

CREATE TABLE `airports` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(3) NOT NULL,
  `name` varchar(150) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `airports`
--

INSERT INTO `airports` (`id`, `code`, `name`, `city`, `province_id`) VALUES
(1, 'CGK', 'Soekarno-Hatta International Airport', 'Jakarta', 3),
(2, 'SUB', 'Juanda International Airport', 'Surabaya', 1),
(3, 'DPS', 'Ngurah Rai International Airport', 'Bali', 2),
(4, 'JOG', 'Adisutjipto International Airport', 'Yogyakarta', 6),
(5, 'UPG', 'Sultan Hasanuddin International Airport', 'Makassar', 7),
(6, 'PDG', 'Minangkabau International Airport', 'Padang', 8),
(7, 'BPN', 'Sultan Aji Muhammad Sulaiman Airport', 'Balikpapan', 9),
(8, 'MLG', 'Abdul Rachman Saleh Airport', 'Malang', 1),
(9, 'SOC', 'Adi Soemarmo International Airport', 'Solo', 4),
(10, 'PLM', 'Sultan Mahmud Badaruddin II Airport', 'Palembang', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bookings`
--

CREATE TABLE `bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `room_id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `check_in` date NOT NULL,
  `check_out` date NOT NULL,
  `guests` tinyint(3) UNSIGNED DEFAULT 1,
  `total_price` decimal(15,2) NOT NULL,
  `special_requests` text DEFAULT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `booking_code` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `bookings`
--

INSERT INTO `bookings` (`id`, `user_id`, `room_id`, `place_id`, `check_in`, `check_out`, `guests`, `total_price`, `special_requests`, `status`, `booking_code`, `created_at`, `updated_at`) VALUES
(1, 35, 4, 21, '2026-05-27', '2026-05-31', 2, 32000000.00, NULL, 'cancelled', 'NGH-20260001', '2026-05-23 23:14:24', '2026-05-27 23:03:13'),
(2, 35, 1, 21, '2026-05-29', '2026-05-31', 1, 3000000.00, 'yang bagus', 'pending', 'NGH-202660002', '2026-05-27 23:03:01', '2026-05-27 23:03:01'),
(3, 35, 2, 21, '2026-06-11', '2026-06-16', 2, 12500000.00, NULL, 'pending', 'NGH-202660003', '2026-06-03 02:30:33', '2026-06-03 02:30:33'),
(4, 45, 2, 21, '2026-06-06', '2026-06-07', 2, 2500000.00, 'Bla ba balbal', 'pending', 'NGH-202660004', '2026-06-04 03:27:01', '2026-06-04 03:27:01'),
(5, 47, 3, 21, '2026-06-06', '2026-06-07', 2, 4000000.00, 'Bla bla bla bla', 'pending', 'NGH-202660005', '2026-06-04 03:36:06', '2026-06-04 03:36:06'),
(6, 48, 4, 21, '2026-06-06', '2026-06-07', 2, 8000000.00, 'Bla bla blaBla bla blaBla bla blaBla bla bla', 'pending', 'NGH-202660006', '2026-06-04 03:45:24', '2026-06-04 03:45:24'),
(7, 35, 1, 21, '2026-06-07', '2026-06-08', 2, 1500000.00, 'wadwasd', 'pending', 'NGH-202660007', '2026-06-07 00:19:49', '2026-06-07 00:19:49'),
(8, 50, 2, 21, '2026-06-09', '2026-06-10', 2, 2500000.00, 'Bla bla bla', 'pending', 'NGH-202660008', '2026-06-07 00:41:19', '2026-06-07 00:41:19');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(10) DEFAULT '?'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon`) VALUES
(1, 'Tempat Wisata', '🏛️'),
(2, 'Restoran', '🍽️'),
(3, 'Hotel', '🏨'),
(4, 'Oleh-oleh', '🛍️'),
(5, 'Kafe', '☕'),
(6, 'Pantai', '🏖️'),
(7, 'Alam & Petualangan', '🌿');

-- --------------------------------------------------------

--
-- Struktur dari tabel `customer`
--

CREATE TABLE `customer` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `bio` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `customer`
--

INSERT INTO `customer` (`id`, `role_id`, `name`, `email`, `password`, `avatar_url`, `bio`, `created_at`, `updated_at`) VALUES
(1, 1, 'Developer Handal', 'dev@mytour.com', 'secret123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(2, 2, 'Admin Jodipan', 'admin.jodipan@mytour.com', 'secret123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(3, 2, 'Admin Hotel Tugu', 'admin.tugu@mytour.com', 'secret123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(4, 3, 'Budi Santoso', 'budi@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(5, 3, 'Siti Aminah', 'siti@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(6, 3, 'Andi Pratama', 'andi@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(7, 3, 'Rina Marlina', 'rina@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(8, 3, 'Doni Tata', 'doni@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(9, 3, 'Citra Kirana', 'citra.k@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(10, 3, 'Dewi Sartika', 'dewi.s@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(11, 3, 'Eko Prasetyo', 'eko.p@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(12, 3, 'Fajar Nugroho', 'fajar.n@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(13, 3, 'Gita Gutawa', 'gita.g@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(14, 3, 'Hendra Setiawan', 'hendra.s@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(15, 3, 'Indah Permatasari', 'indah.p@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(16, 3, 'Joko Anwar', 'joko.a@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(17, 3, 'Kartika Putri', 'kartika.p@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(18, 3, 'Lukman Sardi', 'lukman.s@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(19, 3, 'Maudy Ayunda', 'maudy.a@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(20, 3, 'Nicholas Saputra', 'nicholas.s@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(21, 3, 'Oki Setiana', 'oki.s@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(22, 3, 'Prilly Latuconsina', 'prilly.l@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(23, 3, 'Qory Sandioriva', 'qory.s@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(24, 3, 'Reza Rahadian', 'reza.r@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(25, 3, 'Sandra Dewi', 'sandra.d@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(26, 3, 'Tulus Abadi', 'tulus.a@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(27, 3, 'Ucok Baba', 'ucok.b@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(28, 3, 'Vino G Bastian', 'vino.g@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(29, 3, 'Wulan Guritno', 'wulan.g@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(30, 3, 'Xaverius', 'xaverius@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(31, 3, 'Yuni Shara', 'yuni.s@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(32, 3, 'Zaskia Adya', 'zaskia.a@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(33, 3, 'Bambang Pamungkas', 'bambang.p@gmail.com', 'user123', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(34, 3, 'Testing', 'Testing@gmail.com', '$2y$12$J1D3t1M5rf3J.x1GB5El3esOUimig3edTz8dvJW.qpKGQEt2pjimi', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(35, 3, 'test', 'test@gmail.com', '$2y$12$yGKSVXD7ABUurAG4mXIM4u.j61GK7NsQwDbmgjPorXtNHWVJJ2Mni', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(36, 3, 'database', 'database@gmail.com', '$2y$12$Jg7oo2rT/E3y2LVrYU7mh.HKoTClaNaAdslXlwVsK/jFnEtCJAuLy', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(37, 3, 'finpro', 'finpro@gmail.com', '$2y$12$6BN4EZ2o/aDxaAKUSt1ApODnbEX9HrmI9wSWMShMIqcNd82DZIXDm', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(38, 3, 'halo', 'halo@gmail.com', '$2y$12$gwTerFdI2xoxaHgpRxccX.7g32TQEF4J9S/zzfvOnQQXEdVDkH4b.', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(39, 3, 'yesyes', 'yesyes@gmail.com', '$2y$12$oRPZhfFhKk33iKXZNLb4xO/C84ujrMtCHBG8S5MCjfcczNct1mW2u', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(40, 3, 'budi', 'budi2@gmail.com', '$2y$12$fsIC2Gv1v3XEIKV2SeMhwOvsaObQJH/WPF/lgGl65HPtI8sDY55PW', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(41, 3, 'testt', 'testt@gmail.com', '$2y$12$/nCz/gAh9kxb37nod7nI9.FmO6I2DLgbKxl8QTCwFu2v9BK9rVRnq', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(42, 3, 'testtt', 'testtt@gmail.com', '$2y$12$Ng8u4BWOPqfeTYlWIJXT8O0p3bGgUK0lCTjOPhNYCHjj3TxYDSpjC', NULL, NULL, '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(43, 3, 'yoyo', 'yoyo@gmail.com', '$2y$12$2s6BH8OUFN3BoF8ZwI9onO4BPnGVInCf0AHVRvJRKpg6o4WPE9DDW', NULL, NULL, '2026-05-09 05:59:32', '2026-05-09 05:59:32'),
(44, 3, '12345678', '12345678@gmail.com', '$2y$12$37f371.aWTPOlyWBwTHJz.z3o3acL3N7UT6S5bFQVES9Lb.xHujSK', NULL, NULL, '2026-06-04 03:24:40', '2026-06-04 03:24:40'),
(45, 3, '123456789', '123456789@gmail.com', '$2y$12$Ftg1divBaznSQlJEL7ukw.9woXCrlk3g5NybAWErx3.dhY5dJlREW', NULL, NULL, '2026-06-04 03:26:15', '2026-06-04 03:26:15'),
(46, 3, 'qwertyuiop', 'qwertyuiop@gmail.com', '$2y$12$NQD0D6jM6r9Uo3qf7VnnOeL.wtpO8R6IIi7z/5KPLSwjH5/gUz4Ha', NULL, NULL, '2026-06-04 03:33:26', '2026-06-04 03:33:26'),
(47, 3, 'asdfghjkl', 'asdfghjkl@gmail.com', '$2y$12$4ZtDv/xBmAGMmsF0lCwMEu9BP6iMKWHAjj/CpOkeoKu7Xnw9Nhd1u', NULL, NULL, '2026-06-04 03:35:05', '2026-06-04 03:35:05'),
(48, 3, 'poiuytrewq', 'poiuytrewq@gmail.com', '$2y$12$74edTmybLNElgZ9w6e3a6uq.bQdE4J2kkHFdEJwVP8ZLv5jrYHfai', NULL, NULL, '2026-06-04 03:44:22', '2026-06-04 03:44:22'),
(49, 3, 'Adiaosda', 'Adiaosda@gmail.com', '$2y$12$g0ZYAGlU9y/ZNCG1Ol2zqe1cZBhrAujIeNMu9HztT/pzcoCyZUuHG', NULL, NULL, '2026-06-07 00:38:29', '2026-06-07 00:38:29'),
(50, 3, 'Jandiwansd', 'Jandiwansd@gmail.com', '$2y$12$HN.I4nXW27gZ1t6UucMIu.uKkyWBnRGwlXStg3oAqumOjrtBgbgue', NULL, NULL, '2026-06-07 00:40:25', '2026-06-07 00:40:25'),
(51, 3, 'Testing101', 'Testing101@gmail.com', '$2y$12$tWQILSWG/OSC.9oif/f2JOhgWLCchsiOoc2ou0WeOgcHtWYviDEO2', NULL, NULL, '2026-09-13 22:47:09', '2026-09-13 22:47:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `events`
--

CREATE TABLE `events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `price` decimal(15,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `events`
--

INSERT INTO `events` (`id`, `place_id`, `name`, `description`, `start_date`, `end_date`, `price`) VALUES
(1, 1, 'Festival Warna Warni 2025', 'Lomba mural internasional dan pameran fotografi tahunan.', '2025-02-14 08:00:00', '2025-02-16 17:00:00', 15000.00),
(2, 4, 'Malang Flower Carnival 2025', 'Parade kostum bunga termegah di jalanan Tugu Malang.', '2025-08-10 13:00:00', '2025-08-10 17:00:00', 0.00),
(3, 5, 'Pasar Rakyat Lebaran', 'Bazaar UMKM menyambut Idul Fitri di Alun-Alun Merdeka.', '2025-03-25 15:00:00', '2025-03-30 22:00:00', 0.00),
(4, 8, 'Kayutangan Jazz Festival', 'Pertunjukan musik jazz jalanan di kawasan heritage.', '2025-05-20 18:00:00', '2025-05-20 23:00:00', 50000.00),
(5, 6, 'Pameran Sejarah Kemerdekaan', 'Spesial hari pahlawan, pameran koleksi langka.', '2025-11-10 08:00:00', '2025-11-12 16:00:00', 5000.00),
(6, 21, 'Royal Imlek Dinner 2025', 'Makan malam tahun baru Imlek dengan pertunjukan Barongsai.', '2025-01-29 18:00:00', '2025-01-29 22:00:00', 750000.00),
(7, 30, 'Grand Mercure Wedding Fair', 'Pameran vendor pernikahan terbesar di Malang.', '2025-06-05 10:00:00', '2025-06-07 21:00:00', 25000.00),
(8, 24, 'Harris Kids Holiday Camp', 'Kegiatan seru untuk anak-anak selama liburan sekolah.', '2025-07-01 08:00:00', '2025-07-03 16:00:00', 300000.00),
(9, 22, 'Ramadhan Iftar Buffet', 'Promo buka puasa all you can eat spesial.', '2025-03-01 17:00:00', '2025-03-29 20:00:00', 125000.00),
(10, 13, 'HUT Bakso President ke-50', 'Makan bakso gratis untuk 100 orang pertama.', '2025-09-09 10:00:00', '2025-09-09 14:00:00', 0.00),
(11, 31, 'Malang Strudel Baking Class', 'Belajar membuat strudel langsung bersama chef.', '2025-04-21 09:00:00', '2025-04-21 12:00:00', 100000.00),
(12, 11, 'Tempo Doeloe Night', 'Makan malam nuansa 1930an di Toko Oen.', '2025-10-02 18:00:00', '2025-10-02 21:00:00', 0.00),
(13, 15, 'Lomba Makan Cwie Mie', 'Siapa cepat dia dapat hadiah jutaan rupiah.', '2025-12-15 10:00:00', '2025-12-15 13:00:00', 20000.00),
(14, 19, 'Festival Pedas Bakso Bakar', 'Tantangan makan bakso bakar level neraka.', '2025-08-17 10:00:00', '2025-08-17 15:00:00', 0.00),
(15, 39, 'Panen Raya Keripik Buah', 'Diskon 50% untuk semua item keripik buah.', '2025-01-01 08:00:00', '2025-01-05 21:00:00', 0.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `facilities`
--

CREATE TABLE `facilities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `icon`) VALUES
(1, 'WiFi', '📶'),
(2, 'Parkir Mobil', '🚗'),
(3, 'Parkir Motor', '🏍️'),
(4, 'Toilet Umum', '🚻'),
(5, 'Mushola', '🕌'),
(6, 'AC', '❄️'),
(7, 'Kolam Renang', '🏊'),
(8, 'Area Merokok', '🚬'),
(9, 'Akses Difabel', '♿'),
(10, 'ATM/Kasir', '💳');

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `favorites`
--

CREATE TABLE `favorites` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `favorites`
--

INSERT INTO `favorites` (`id`, `user_id`, `place_id`) VALUES
(1, 4, 1),
(6, 4, 13),
(10, 4, 21),
(2, 5, 1),
(7, 5, 13),
(11, 5, 21),
(3, 6, 1),
(12, 6, 5),
(8, 6, 13),
(4, 7, 1),
(13, 7, 5),
(9, 7, 13),
(5, 8, 1),
(14, 8, 5),
(15, 9, 1),
(37, 9, 13),
(52, 9, 21),
(84, 9, 29),
(16, 10, 1),
(63, 10, 3),
(27, 10, 4),
(47, 10, 21),
(85, 10, 30),
(17, 11, 1),
(64, 11, 5),
(38, 11, 13),
(55, 11, 31),
(86, 11, 32),
(18, 12, 1),
(28, 12, 4),
(65, 12, 6),
(56, 12, 31),
(87, 12, 33),
(19, 13, 1),
(66, 13, 8),
(39, 13, 13),
(57, 13, 31),
(88, 13, 34),
(20, 14, 1),
(29, 14, 4),
(67, 14, 10),
(53, 14, 21),
(58, 14, 31),
(89, 14, 35),
(21, 15, 1),
(68, 15, 11),
(40, 15, 13),
(48, 15, 21),
(59, 15, 31),
(90, 15, 36),
(22, 16, 1),
(30, 16, 4),
(69, 16, 12),
(60, 16, 31),
(91, 16, 37),
(23, 17, 1),
(41, 17, 13),
(70, 17, 14),
(61, 17, 31),
(92, 17, 38),
(24, 18, 1),
(31, 18, 4),
(71, 18, 15),
(93, 18, 39),
(25, 19, 1),
(42, 19, 13),
(72, 19, 16),
(54, 19, 21),
(94, 19, 40),
(26, 20, 1),
(32, 20, 4),
(73, 20, 17),
(49, 20, 21),
(96, 21, 3),
(43, 21, 13),
(74, 21, 18),
(33, 22, 4),
(97, 22, 5),
(75, 22, 19),
(98, 23, 8),
(44, 23, 13),
(76, 23, 20),
(34, 24, 4),
(99, 24, 11),
(77, 24, 22),
(45, 25, 13),
(100, 25, 15),
(50, 25, 21),
(78, 25, 23),
(35, 26, 4),
(79, 26, 24),
(46, 27, 13),
(80, 27, 25),
(36, 28, 4),
(81, 28, 26),
(82, 29, 27),
(51, 30, 21),
(83, 30, 28),
(112, 35, 1),
(113, 35, 4),
(114, 35, 17),
(101, 37, 1),
(103, 37, 3),
(102, 37, 4),
(104, 37, 6),
(105, 38, 1),
(106, 38, 3),
(107, 38, 4),
(111, 41, 1),
(115, 46, 21),
(116, 48, 1),
(117, 49, 21),
(118, 50, 21);

-- --------------------------------------------------------

--
-- Struktur dari tabel `flights`
--

CREATE TABLE `flights` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `airline_id` bigint(20) UNSIGNED NOT NULL,
  `flight_number` varchar(10) NOT NULL,
  `origin_id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `duration_minutes` smallint(5) UNSIGNED NOT NULL,
  `price_economy` decimal(12,2) NOT NULL,
  `price_business` decimal(12,2) DEFAULT NULL,
  `seats_economy` smallint(5) UNSIGNED DEFAULT 150,
  `seats_business` smallint(5) UNSIGNED DEFAULT 20,
  `days_of_week` varchar(20) DEFAULT 'daily',
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `flights`
--

INSERT INTO `flights` (`id`, `airline_id`, `flight_number`, `origin_id`, `destination_id`, `departure_time`, `arrival_time`, `duration_minutes`, `price_economy`, `price_business`, `seats_economy`, `seats_business`, `days_of_week`, `is_active`) VALUES
(1, 1, 'GA300', 1, 2, '06:00:00', '07:10:00', 70, 850000.00, 2500000.00, 150, 20, 'daily', 1),
(2, 1, 'GA302', 1, 2, '09:00:00', '10:10:00', 70, 920000.00, 2800000.00, 150, 20, 'daily', 1),
(3, 2, 'QG800', 1, 2, '07:00:00', '08:10:00', 70, 650000.00, NULL, 150, 20, 'daily', 1),
(4, 4, 'JT680', 1, 2, '08:30:00', '09:40:00', 70, 580000.00, NULL, 150, 20, 'daily', 1),
(5, 1, 'GA400', 1, 3, '07:00:00', '08:55:00', 115, 1100000.00, 3200000.00, 150, 20, 'daily', 1),
(6, 2, 'QG900', 1, 3, '09:00:00', '10:55:00', 115, 820000.00, NULL, 150, 20, 'daily', 1),
(7, 3, 'ID600', 1, 3, '11:00:00', '12:55:00', 115, 950000.00, 2700000.00, 150, 20, 'daily', 1),
(8, 1, 'GA200', 1, 6, '08:00:00', '08:55:00', 55, 780000.00, 2200000.00, 150, 20, 'daily', 1),
(9, 2, 'QG700', 1, 6, '10:00:00', '10:55:00', 55, 560000.00, NULL, 150, 20, 'daily', 1),
(10, 1, 'GA500', 1, 7, '07:30:00', '10:00:00', 150, 1400000.00, 3800000.00, 150, 20, 'daily', 1),
(11, 2, 'QG500', 1, 7, '09:30:00', '12:00:00', 150, 980000.00, NULL, 150, 20, 'daily', 1),
(12, 1, 'GA301', 2, 1, '08:00:00', '09:10:00', 70, 850000.00, 2500000.00, 150, 20, 'daily', 1),
(13, 2, 'QG801', 2, 1, '09:00:00', '10:10:00', 70, 650000.00, NULL, 150, 20, 'daily', 1),
(14, 1, 'GA401', 3, 1, '10:00:00', '11:55:00', 115, 1100000.00, 3200000.00, 150, 20, 'daily', 1),
(15, 2, 'QG901', 3, 1, '12:00:00', '13:55:00', 115, 820000.00, NULL, 150, 20, 'daily', 1),
(16, 1, 'GA201', 6, 1, '10:00:00', '10:55:00', 55, 780000.00, 2200000.00, 150, 20, 'daily', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `flight_bookings`
--

CREATE TABLE `flight_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `flight_id` bigint(20) UNSIGNED NOT NULL,
  `travel_date` date NOT NULL,
  `seat_class` enum('economy','business') DEFAULT 'economy',
  `passengers` tinyint(3) UNSIGNED DEFAULT 1,
  `total_price` decimal(15,2) NOT NULL,
  `passenger_name` varchar(255) NOT NULL,
  `passenger_id_number` varchar(50) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `booking_code` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `follows`
--

CREATE TABLE `follows` (
  `follower_id` bigint(20) UNSIGNED NOT NULL,
  `following_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `itinerary_comments`
--

CREATE TABLE `itinerary_comments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `itinerary_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `comment` text NOT NULL,
  `rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `itinerary_comments`
--

INSERT INTO `itinerary_comments` (`id`, `itinerary_id`, `user_id`, `comment`, `rating`, `created_at`) VALUES
(1, 7, 35, 'Wow bagus bet', NULL, '2026-06-03 12:47:41'),
(2, 7, 47, 'Wih mantap', NULL, '2026-06-04 10:42:51'),
(3, 7, 48, 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', NULL, '2026-06-04 10:51:36'),
(4, 7, 35, 'test', 4, '2026-06-07 00:23:21'),
(5, 11, 35, 'nice', 4, '2026-06-07 00:26:36'),
(6, 11, 50, 'Mantap', 4, '2026-06-07 00:47:54');

-- --------------------------------------------------------

--
-- Struktur dari tabel `itinerary_copies`
--

CREATE TABLE `itinerary_copies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `original_itinerary_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `copied_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `itinerary_copies`
--

INSERT INTO `itinerary_copies` (`id`, `original_itinerary_id`, `user_id`, `copied_at`) VALUES
(2, 8, 35, '2026-06-07 00:13:47'),
(3, 11, 35, '2026-06-07 00:31:21'),
(4, 11, 50, '2026-06-07 00:48:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `itinerary_days`
--

CREATE TABLE `itinerary_days` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `itinerary_id` bigint(20) UNSIGNED NOT NULL,
  `day_number` tinyint(3) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `itinerary_days`
--

INSERT INTO `itinerary_days` (`id`, `itinerary_id`, `day_number`, `title`, `notes`) VALUES
(1, 5, 1, 'Hari TIba', 'Cuaca cera Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla'),
(2, 6, 1, 'Hari TIba', 'Cuaca cera Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla'),
(3, 7, 1, 'Hari TIba', 'Cuaca cera Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla'),
(4, 7, 2, 'Hari terakhir', NULL),
(5, 8, 1, 'Hari tiba', 'Bla bla blaBla bla blaBla bla blaBla bla bla'),
(6, 8, 2, 'Hari pulang', 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla bla'),
(9, 10, 1, 'Hari tiba', 'Bla bla blaBla bla blaBla bla blaBla bla bla'),
(10, 10, 2, 'Hari pulang', 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla bla'),
(11, 11, 1, 'Hari TIba', NULL),
(12, 11, 2, 'Hari terakhir', NULL),
(13, 12, 1, 'Hari TIba', NULL),
(14, 12, 2, 'Hari terakhir', NULL),
(15, 13, 1, 'Hari tiba', 'Cuaca cerah'),
(16, 13, 2, 'Hari terakhir', NULL),
(17, 14, 1, 'Hari TIba', NULL),
(18, 14, 2, 'Hari terakhir', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `itinerary_likes`
--

CREATE TABLE `itinerary_likes` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `itinerary_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `itinerary_posts`
--

CREATE TABLE `itinerary_posts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `cover_image` varchar(255) DEFAULT NULL,
  `summary` text DEFAULT NULL,
  `body` longtext DEFAULT NULL,
  `region_id` bigint(20) UNSIGNED DEFAULT NULL,
  `duration_days` tinyint(3) UNSIGNED DEFAULT 1,
  `estimated_budget` decimal(15,2) DEFAULT NULL,
  `actual_budget` decimal(15,2) DEFAULT NULL,
  `trip_rating` tinyint(3) UNSIGNED DEFAULT NULL,
  `trip_tips` text DEFAULT NULL,
  `travel_style` enum('backpacker','budget','mid-range','luxury','family','solo','couple','group') DEFAULT 'mid-range',
  `status` enum('draft','published') DEFAULT 'draft',
  `is_verified` tinyint(1) DEFAULT 0,
  `copied_from_id` bigint(20) UNSIGNED DEFAULT NULL,
  `views` int(10) UNSIGNED DEFAULT 0,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `itinerary_posts`
--

INSERT INTO `itinerary_posts` (`id`, `user_id`, `title`, `slug`, `cover_image`, `summary`, `body`, `region_id`, `duration_days`, `estimated_budget`, `actual_budget`, `trip_rating`, `trip_tips`, `travel_style`, `status`, `is_verified`, `copied_from_id`, `views`, `created_at`, `updated_at`) VALUES
(1, 35, 'Trip ke Malang', 'trip-ke-malang-Ls4iY', NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 1, 2, 3000000.00, 2000000.00, NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'mid-range', 'published', 0, NULL, 0, '2026-06-03 05:26:05', '2026-06-03 05:26:05'),
(2, 35, 'Trip ke Malang', 'trip-ke-malang-icJf1', NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 1, 2, 3000000.00, 2000000.00, NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'mid-range', 'draft', 0, NULL, 0, '2026-06-03 05:26:16', '2026-06-03 05:26:16'),
(3, 35, 'Trip ke Malang', 'trip-ke-malang-2r6Mm', NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 1, 2, 3000000.00, 2000000.00, NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'mid-range', 'draft', 0, NULL, 0, '2026-06-03 05:26:24', '2026-06-03 05:26:24'),
(4, 35, 'Trip ke Malang', 'trip-ke-malang-844gF', NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 1, 2, 3000000.00, 2000000.00, NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'mid-range', 'published', 0, NULL, 0, '2026-06-03 05:26:39', '2026-06-03 05:26:39'),
(5, 35, 'Trip ke Malang', 'trip-ke-malang-Oj6xd', NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 1, 2, 3000000.00, 2000000.00, NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'mid-range', 'published', 0, NULL, 0, '2026-06-03 05:29:00', '2026-06-03 05:29:00'),
(6, 35, 'Trip ke Malang', 'trip-ke-malang-FmGIq', NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 1, 2, 3000000.00, 2000000.00, NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'mid-range', 'published', 0, NULL, 2, '2026-06-03 05:31:46', '2026-06-03 05:48:32'),
(7, 35, 'Trip ke Malang', 'trip-ke-malang-nCWEj', NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 1, 2, 3000000.00, 2000000.00, NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', 'mid-range', 'published', 1, NULL, 18, '2026-06-03 05:33:25', '2026-06-07 00:24:54'),
(8, 48, '2 Hari di malang', '2-hari-di-malang-dGa1X', NULL, 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', 3, 2, 10000000.00, 9000000.00, 5, 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', 'luxury', 'published', 1, NULL, 12, '2026-06-04 03:51:12', '2026-06-07 00:43:48'),
(10, 35, '2 Hari di malang (Salinan)', '2-hari-di-malang-copy-Pqd07', NULL, 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', 3, 2, 10000000.00, NULL, NULL, 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', 'luxury', 'draft', 0, 8, 2, '2026-06-07 00:13:47', '2026-06-07 00:14:02'),
(11, 35, '2 hari di malang', '2-hari-di-malang-Qo229', NULL, 'yooooooooooooooooooooooooooo', 'yooooooooooooooooooooooooooo', 1, 2, 4000000.00, 3000000.00, 4, 'yooooooooooooooooooooooooooo', 'mid-range', 'published', 1, NULL, 5, '2026-06-07 00:26:24', '2026-06-07 00:47:55'),
(12, 35, '2 hari di malang (Salinan)', '2-hari-di-malang-copy-jg5iu', NULL, 'yooooooooooooooooooooooooooo', 'yooooooooooooooooooooooooooo', 1, 2, 4000000.00, NULL, NULL, 'yooooooooooooooooooooooooooo', 'mid-range', 'draft', 0, 11, 0, '2026-06-07 00:31:21', '2026-06-07 00:31:21'),
(13, 50, '2 hari di malang', '2-hari-di-malang-RhgCD', NULL, 'Bla bla blaBla bla blaBla bla bla', 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', 1, 2, 5000000.00, 3900000.00, 4, 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', 'mid-range', 'published', 1, NULL, 2, '2026-06-07 00:47:29', '2026-06-07 00:47:38'),
(14, 50, '2 hari di malang (Salinan)', '2-hari-di-malang-copy-b2wK3', NULL, 'yooooooooooooooooooooooooooo', 'yooooooooooooooooooooooooooo', 1, 2, 4000000.00, NULL, NULL, 'yooooooooooooooooooooooooooo', 'mid-range', 'draft', 0, 11, 0, '2026-06-07 00:48:10', '2026-06-07 00:48:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `itinerary_stops`
--

CREATE TABLE `itinerary_stops` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `day_id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED DEFAULT NULL,
  `flight_booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `hotel_booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `train_booking_id` bigint(20) UNSIGNED DEFAULT NULL,
  `custom_place_name` varchar(255) DEFAULT NULL,
  `custom_title` varchar(255) DEFAULT NULL,
  `custom_description` text DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `visit_order` tinyint(3) UNSIGNED NOT NULL DEFAULT 1,
  `stop_type` enum('flight','train','hotel','place','food','custom') DEFAULT 'custom',
  `visit_time` time DEFAULT NULL,
  `duration_minutes` smallint(5) UNSIGNED DEFAULT NULL,
  `tip` text DEFAULT NULL,
  `transport_mode` varchar(100) DEFAULT NULL,
  `transport_cost` int(11) DEFAULT 0,
  `order` int(11) DEFAULT 1,
  `cost` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `itinerary_stops`
--

INSERT INTO `itinerary_stops` (`id`, `day_id`, `place_id`, `flight_booking_id`, `hotel_booking_id`, `train_booking_id`, `custom_place_name`, `custom_title`, `custom_description`, `time_start`, `time_end`, `visit_order`, `stop_type`, `visit_time`, `duration_minutes`, `tip`, `transport_mode`, `transport_cost`, `order`, `cost`) VALUES
(1, 3, NULL, NULL, NULL, NULL, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 1 penumpang', NULL, NULL, 1, 'train', NULL, NULL, NULL, NULL, 0, 1, 450000.00),
(2, 3, NULL, NULL, 2, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Standard Room · Check-in: 2026-05-29T00:00:00.000000Z · Check-out: 2026-05-31T00:00:00.000000Z · 1 tamu', NULL, NULL, 2, 'hotel', NULL, NULL, NULL, NULL, 0, 1, 3000000.00),
(3, 3, NULL, NULL, NULL, NULL, 'Bla bla bla', 'Rawon Rampal', 'Bla bla bla', NULL, NULL, 3, 'food', NULL, NULL, NULL, NULL, 0, 1, 20000.00),
(4, 4, 4, NULL, NULL, NULL, 'Tugu', NULL, 'Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla Bla bla bla', NULL, NULL, 1, 'place', NULL, NULL, NULL, NULL, 0, 1, 0.00),
(5, 4, NULL, NULL, NULL, NULL, 'Bla bla bla Bla bla bla Bla bla bla', 'Tempat yang enak', 'Bla bla bla Bla bla bla Bla bla bla', NULL, NULL, 2, 'food', NULL, NULL, NULL, NULL, 0, 1, 30000.00),
(6, 5, NULL, NULL, NULL, 5, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 2 penumpang', '17:30:00', '05:30:00', 1, 'train', NULL, NULL, NULL, NULL, 0, 1, 900000.00),
(7, 5, NULL, NULL, 6, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Presidential Suite · Check-in: 2026-06-06T00:00:00.000000Z · Check-out: 2026-06-07T00:00:00.000000Z · 2 tamu', '14:00:00', NULL, 2, 'hotel', NULL, NULL, NULL, 'Pakai Gojek untuk ke hotel', 20000, 1, 8000000.00),
(8, 5, 17, NULL, NULL, NULL, NULL, 'Rawon Rampal', 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', NULL, NULL, 3, 'food', NULL, NULL, NULL, 'Gojek', 30000, 1, 30000.00),
(9, 6, 803, NULL, NULL, NULL, 'Jatim park', NULL, 'Bla bla blaBla bla blaBla bla bla', NULL, NULL, 1, 'place', NULL, NULL, NULL, NULL, 0, 1, 200000.00),
(10, 6, 13, NULL, NULL, NULL, NULL, 'Bakso President', 'Bla bla blaBla bla bla', NULL, NULL, 2, 'food', NULL, NULL, NULL, 'Gojek', 70000, 1, 30000.00),
(16, 9, NULL, NULL, NULL, NULL, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 2 penumpang', '17:30:00', '05:30:00', 1, 'train', NULL, NULL, NULL, NULL, 0, 1, 900000.00),
(17, 9, NULL, NULL, NULL, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Presidential Suite · Check-in: 2026-06-06T00:00:00.000000Z · Check-out: 2026-06-07T00:00:00.000000Z · 2 tamu', '14:00:00', NULL, 2, 'hotel', NULL, NULL, NULL, 'Pakai Gojek untuk ke hotel', 20000, 1, 8000000.00),
(18, 9, 17, NULL, NULL, NULL, NULL, 'Rawon Rampal', 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', NULL, NULL, 3, 'food', NULL, NULL, NULL, 'Gojek', 30000, 1, 30000.00),
(19, 10, 803, NULL, NULL, NULL, 'Jatim park', NULL, 'Bla bla blaBla bla blaBla bla bla', NULL, NULL, 1, 'place', NULL, NULL, NULL, NULL, 0, 1, 200000.00),
(20, 10, 13, NULL, NULL, NULL, NULL, 'Bakso President', 'Bla bla blaBla bla bla', NULL, NULL, 2, 'food', NULL, NULL, NULL, 'Gojek', 70000, 1, 30000.00),
(21, 11, NULL, NULL, NULL, 1, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 1 penumpang', '17:30:00', '05:30:00', 1, 'train', NULL, NULL, NULL, NULL, 0, 1, 450000.00),
(22, 11, NULL, NULL, 2, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Standard Room · Check-in: 2026-05-29 · Check-out: 2026-05-31 · 1 tamu', '14:00:00', NULL, 2, 'hotel', NULL, NULL, NULL, NULL, 0, 1, 3000000.00),
(23, 11, 40, NULL, NULL, NULL, 'Jl. Jaksa Agung Suprapto', 'Avia (Toko Roti & Kue)', NULL, NULL, NULL, 3, 'place', NULL, NULL, NULL, NULL, 0, 1, 10000.00),
(24, 12, NULL, NULL, 2, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Standard Room · Check-in: 2026-05-29 · Check-out: 2026-05-31 · 1 tamu', '14:00:00', NULL, 1, 'hotel', NULL, NULL, NULL, NULL, 0, 1, 3000000.00),
(25, 12, NULL, NULL, NULL, 1, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 1 penumpang', '17:30:00', '05:30:00', 2, 'train', NULL, NULL, NULL, NULL, 0, 1, 450000.00),
(26, 13, NULL, NULL, NULL, NULL, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 1 penumpang', '17:30:00', '05:30:00', 1, 'train', NULL, NULL, NULL, NULL, 0, 1, 450000.00),
(27, 13, NULL, NULL, NULL, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Standard Room · Check-in: 2026-05-29 · Check-out: 2026-05-31 · 1 tamu', '14:00:00', NULL, 2, 'hotel', NULL, NULL, NULL, NULL, 0, 1, 3000000.00),
(28, 13, 40, NULL, NULL, NULL, 'Jl. Jaksa Agung Suprapto', 'Avia (Toko Roti & Kue)', NULL, NULL, NULL, 3, 'place', NULL, NULL, NULL, NULL, 0, 1, 10000.00),
(29, 14, NULL, NULL, NULL, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Standard Room · Check-in: 2026-05-29 · Check-out: 2026-05-31 · 1 tamu', '14:00:00', NULL, 1, 'hotel', NULL, NULL, NULL, NULL, 0, 1, 3000000.00),
(30, 14, NULL, NULL, NULL, NULL, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 1 penumpang', '17:30:00', '05:30:00', 2, 'train', NULL, NULL, NULL, NULL, 0, 1, 450000.00),
(31, 15, NULL, NULL, NULL, 8, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 2 penumpang', '17:30:00', '05:30:00', 1, 'train', NULL, NULL, NULL, NULL, 0, 1, 900000.00),
(32, 15, NULL, NULL, 8, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Deluxe Room · Check-in: 2026-06-09 · Check-out: 2026-06-10 · 2 tamu', '14:00:00', NULL, 2, 'hotel', NULL, NULL, NULL, 'Gojek ke hotel', 20000, 1, 2500000.00),
(33, 15, 17, NULL, NULL, NULL, 'Jl. Panglima Sudirman', 'Rawon Rampal', 'Bla bla blaBla bla blaBla bla blaBla bla blaBla bla bla', NULL, NULL, 3, 'food', NULL, NULL, 'Reservasi dulu karena ramai', 'Gojek', 20000, 1, 35000.00),
(34, 15, NULL, NULL, 8, NULL, NULL, 'Hotel Tugu Malang', 'Kembali ke hotel untuk istirahat', '14:00:00', NULL, 4, 'hotel', NULL, NULL, NULL, 'Gojek', 20000, 1, 2500000.00),
(35, 16, 40, NULL, NULL, NULL, 'Jl. Jaksa Agung Suprapto', 'Avia (Toko Roti & Kue)', NULL, NULL, NULL, 1, 'food', NULL, NULL, NULL, NULL, 0, 1, 10000.00),
(36, 16, 803, NULL, NULL, NULL, 'Jl. Kartika No.2, Batu, Jawa Timur', 'Jatim Park 1', NULL, NULL, NULL, 2, 'place', NULL, NULL, NULL, 'Gojek', 70000, 1, 100000.00),
(37, 16, NULL, NULL, NULL, 8, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 2 penumpang', '17:30:00', '05:30:00', 3, 'train', NULL, NULL, NULL, 'Gojek ke stasiun', 0, 1, 900000.00),
(38, 17, NULL, NULL, NULL, NULL, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 1 penumpang', '17:30:00', '05:30:00', 1, 'train', NULL, NULL, NULL, NULL, 0, 1, 450000.00),
(39, 17, NULL, NULL, NULL, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Standard Room · Check-in: 2026-05-29 · Check-out: 2026-05-31 · 1 tamu', '14:00:00', NULL, 2, 'hotel', NULL, NULL, NULL, NULL, 0, 1, 3000000.00),
(40, 17, 40, NULL, NULL, NULL, 'Jl. Jaksa Agung Suprapto', 'Avia (Toko Roti & Kue)', NULL, NULL, NULL, 3, 'place', NULL, NULL, NULL, NULL, 0, 1, 10000.00),
(41, 18, NULL, NULL, NULL, NULL, NULL, 'Hotel Tugu Malang', 'Kamar: Standard Room · Check-in: 2026-05-29 · Check-out: 2026-05-31 · 1 tamu', '14:00:00', NULL, 1, 'hotel', NULL, NULL, NULL, NULL, 0, 1, 3000000.00),
(42, 18, NULL, NULL, NULL, NULL, 'Jakarta → Malang', 'Gajayana', 'Kelas economy · 1 penumpang', '17:30:00', '05:30:00', 2, 'train', NULL, NULL, NULL, NULL, 0, 1, 450000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `itinerary_tags`
--

CREATE TABLE `itinerary_tags` (
  `itinerary_id` bigint(20) UNSIGNED NOT NULL,
  `tag_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `itinerary_tags`
--

INSERT INTO `itinerary_tags` (`itinerary_id`, `tag_id`) VALUES
(1, 2),
(1, 9),
(2, 2),
(2, 9),
(3, 2),
(3, 9),
(4, 2),
(4, 9),
(5, 2),
(5, 9),
(6, 2),
(6, 9),
(7, 2),
(7, 9),
(8, 2),
(8, 9),
(8, 10),
(10, 2),
(10, 9),
(10, 10),
(11, 1),
(11, 2),
(11, 6),
(11, 7),
(11, 9),
(11, 10),
(12, 1),
(12, 2),
(12, 6),
(12, 7),
(12, 9),
(12, 10),
(13, 2),
(13, 3),
(13, 9),
(13, 10),
(14, 1),
(14, 2),
(14, 6),
(14, 7),
(14, 9),
(14, 10);

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `operating_hours`
--

CREATE TABLE `operating_hours` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `day_of_week` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday') NOT NULL,
  `open_time` time NOT NULL,
  `close_time` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `operating_hours`
--

INSERT INTO `operating_hours` (`id`, `place_id`, `day_of_week`, `open_time`, `close_time`) VALUES
(1, 1, 'Monday', '08:00:00', '22:00:00'),
(2, 1, 'Tuesday', '08:00:00', '22:00:00'),
(3, 1, 'Wednesday', '08:00:00', '22:00:00'),
(4, 1, 'Thursday', '08:00:00', '22:00:00'),
(5, 1, 'Friday', '08:00:00', '22:00:00'),
(6, 1, 'Saturday', '08:00:00', '22:00:00'),
(7, 1, 'Sunday', '08:00:00', '22:00:00'),
(15, 3, 'Monday', '08:00:00', '22:00:00'),
(16, 3, 'Tuesday', '08:00:00', '22:00:00'),
(17, 3, 'Wednesday', '08:00:00', '22:00:00'),
(18, 3, 'Thursday', '08:00:00', '22:00:00'),
(19, 3, 'Friday', '08:00:00', '22:00:00'),
(20, 3, 'Saturday', '08:00:00', '22:00:00'),
(21, 3, 'Sunday', '08:00:00', '22:00:00'),
(22, 4, 'Monday', '08:00:00', '22:00:00'),
(23, 4, 'Tuesday', '08:00:00', '22:00:00'),
(24, 4, 'Wednesday', '08:00:00', '22:00:00'),
(25, 4, 'Thursday', '08:00:00', '22:00:00'),
(26, 4, 'Friday', '08:00:00', '22:00:00'),
(27, 4, 'Saturday', '08:00:00', '22:00:00'),
(28, 4, 'Sunday', '08:00:00', '22:00:00'),
(29, 5, 'Monday', '08:00:00', '22:00:00'),
(30, 5, 'Tuesday', '08:00:00', '22:00:00'),
(31, 5, 'Wednesday', '08:00:00', '22:00:00'),
(32, 5, 'Thursday', '08:00:00', '22:00:00'),
(33, 5, 'Friday', '08:00:00', '22:00:00'),
(34, 5, 'Saturday', '08:00:00', '22:00:00'),
(35, 5, 'Sunday', '08:00:00', '22:00:00'),
(36, 6, 'Monday', '08:00:00', '22:00:00'),
(37, 6, 'Tuesday', '08:00:00', '22:00:00'),
(38, 6, 'Wednesday', '08:00:00', '22:00:00'),
(39, 6, 'Thursday', '08:00:00', '22:00:00'),
(40, 6, 'Friday', '08:00:00', '22:00:00'),
(41, 6, 'Saturday', '08:00:00', '22:00:00'),
(42, 6, 'Sunday', '08:00:00', '22:00:00'),
(43, 7, 'Monday', '08:00:00', '22:00:00'),
(44, 7, 'Tuesday', '08:00:00', '22:00:00'),
(45, 7, 'Wednesday', '08:00:00', '22:00:00'),
(46, 7, 'Thursday', '08:00:00', '22:00:00'),
(47, 7, 'Friday', '08:00:00', '22:00:00'),
(48, 7, 'Saturday', '08:00:00', '22:00:00'),
(49, 7, 'Sunday', '08:00:00', '22:00:00'),
(50, 8, 'Monday', '08:00:00', '22:00:00'),
(51, 8, 'Tuesday', '08:00:00', '22:00:00'),
(52, 8, 'Wednesday', '08:00:00', '22:00:00'),
(53, 8, 'Thursday', '08:00:00', '22:00:00'),
(54, 8, 'Friday', '08:00:00', '22:00:00'),
(55, 8, 'Saturday', '08:00:00', '22:00:00'),
(56, 8, 'Sunday', '08:00:00', '22:00:00'),
(57, 9, 'Monday', '08:00:00', '22:00:00'),
(58, 9, 'Tuesday', '08:00:00', '22:00:00'),
(59, 9, 'Wednesday', '08:00:00', '22:00:00'),
(60, 9, 'Thursday', '08:00:00', '22:00:00'),
(61, 9, 'Friday', '08:00:00', '22:00:00'),
(62, 9, 'Saturday', '08:00:00', '22:00:00'),
(63, 9, 'Sunday', '08:00:00', '22:00:00'),
(64, 10, 'Monday', '08:00:00', '22:00:00'),
(65, 10, 'Tuesday', '08:00:00', '22:00:00'),
(66, 10, 'Wednesday', '08:00:00', '22:00:00'),
(67, 10, 'Thursday', '08:00:00', '22:00:00'),
(68, 10, 'Friday', '08:00:00', '22:00:00'),
(69, 10, 'Saturday', '08:00:00', '22:00:00'),
(70, 10, 'Sunday', '08:00:00', '22:00:00'),
(71, 11, 'Monday', '08:00:00', '22:00:00'),
(72, 11, 'Tuesday', '08:00:00', '22:00:00'),
(73, 11, 'Wednesday', '08:00:00', '22:00:00'),
(74, 11, 'Thursday', '08:00:00', '22:00:00'),
(75, 11, 'Friday', '08:00:00', '22:00:00'),
(76, 11, 'Saturday', '08:00:00', '22:00:00'),
(77, 11, 'Sunday', '08:00:00', '22:00:00'),
(78, 12, 'Monday', '08:00:00', '22:00:00'),
(79, 12, 'Tuesday', '08:00:00', '22:00:00'),
(80, 12, 'Wednesday', '08:00:00', '22:00:00'),
(81, 12, 'Thursday', '08:00:00', '22:00:00'),
(82, 12, 'Friday', '08:00:00', '22:00:00'),
(83, 12, 'Saturday', '08:00:00', '22:00:00'),
(84, 12, 'Sunday', '08:00:00', '22:00:00'),
(85, 13, 'Monday', '08:00:00', '22:00:00'),
(86, 13, 'Tuesday', '08:00:00', '22:00:00'),
(87, 13, 'Wednesday', '08:00:00', '22:00:00'),
(88, 13, 'Thursday', '08:00:00', '22:00:00'),
(89, 13, 'Friday', '08:00:00', '22:00:00'),
(90, 13, 'Saturday', '08:00:00', '22:00:00'),
(91, 13, 'Sunday', '08:00:00', '22:00:00'),
(92, 14, 'Monday', '08:00:00', '22:00:00'),
(93, 14, 'Tuesday', '08:00:00', '22:00:00'),
(94, 14, 'Wednesday', '08:00:00', '22:00:00'),
(95, 14, 'Thursday', '08:00:00', '22:00:00'),
(96, 14, 'Friday', '08:00:00', '22:00:00'),
(97, 14, 'Saturday', '08:00:00', '22:00:00'),
(98, 14, 'Sunday', '08:00:00', '22:00:00'),
(99, 15, 'Monday', '08:00:00', '22:00:00'),
(100, 15, 'Tuesday', '08:00:00', '22:00:00'),
(101, 15, 'Wednesday', '08:00:00', '22:00:00'),
(102, 15, 'Thursday', '08:00:00', '22:00:00'),
(103, 15, 'Friday', '08:00:00', '22:00:00'),
(104, 15, 'Saturday', '08:00:00', '22:00:00'),
(105, 15, 'Sunday', '08:00:00', '22:00:00'),
(106, 16, 'Monday', '08:00:00', '22:00:00'),
(107, 16, 'Tuesday', '08:00:00', '22:00:00'),
(108, 16, 'Wednesday', '08:00:00', '22:00:00'),
(109, 16, 'Thursday', '08:00:00', '22:00:00'),
(110, 16, 'Friday', '08:00:00', '22:00:00'),
(111, 16, 'Saturday', '08:00:00', '22:00:00'),
(112, 16, 'Sunday', '08:00:00', '22:00:00'),
(113, 17, 'Monday', '08:00:00', '22:00:00'),
(114, 17, 'Tuesday', '08:00:00', '22:00:00'),
(115, 17, 'Wednesday', '08:00:00', '22:00:00'),
(116, 17, 'Thursday', '08:00:00', '22:00:00'),
(117, 17, 'Friday', '08:00:00', '22:00:00'),
(118, 17, 'Saturday', '08:00:00', '22:00:00'),
(119, 17, 'Sunday', '08:00:00', '22:00:00'),
(120, 18, 'Monday', '08:00:00', '22:00:00'),
(121, 18, 'Tuesday', '08:00:00', '22:00:00'),
(122, 18, 'Wednesday', '08:00:00', '22:00:00'),
(123, 18, 'Thursday', '08:00:00', '22:00:00'),
(124, 18, 'Friday', '08:00:00', '22:00:00'),
(125, 18, 'Saturday', '08:00:00', '22:00:00'),
(126, 18, 'Sunday', '08:00:00', '22:00:00'),
(127, 19, 'Monday', '08:00:00', '22:00:00'),
(128, 19, 'Tuesday', '08:00:00', '22:00:00'),
(129, 19, 'Wednesday', '08:00:00', '22:00:00'),
(130, 19, 'Thursday', '08:00:00', '22:00:00'),
(131, 19, 'Friday', '08:00:00', '22:00:00'),
(132, 19, 'Saturday', '08:00:00', '22:00:00'),
(133, 19, 'Sunday', '08:00:00', '22:00:00'),
(134, 20, 'Monday', '08:00:00', '22:00:00'),
(135, 20, 'Tuesday', '08:00:00', '22:00:00'),
(136, 20, 'Wednesday', '08:00:00', '22:00:00'),
(137, 20, 'Thursday', '08:00:00', '22:00:00'),
(138, 20, 'Friday', '08:00:00', '22:00:00'),
(139, 20, 'Saturday', '08:00:00', '22:00:00'),
(140, 20, 'Sunday', '08:00:00', '22:00:00'),
(141, 21, 'Monday', '00:00:00', '23:59:00'),
(142, 21, 'Tuesday', '00:00:00', '23:59:00'),
(143, 21, 'Wednesday', '00:00:00', '23:59:00'),
(144, 21, 'Thursday', '00:00:00', '23:59:00'),
(145, 21, 'Friday', '00:00:00', '23:59:00'),
(146, 21, 'Saturday', '00:00:00', '23:59:00'),
(147, 21, 'Sunday', '00:00:00', '23:59:00'),
(148, 22, 'Monday', '00:00:00', '23:59:00'),
(149, 22, 'Tuesday', '00:00:00', '23:59:00'),
(150, 22, 'Wednesday', '00:00:00', '23:59:00'),
(151, 22, 'Thursday', '00:00:00', '23:59:00'),
(152, 22, 'Friday', '00:00:00', '23:59:00'),
(153, 22, 'Saturday', '00:00:00', '23:59:00'),
(154, 22, 'Sunday', '00:00:00', '23:59:00'),
(155, 23, 'Monday', '00:00:00', '23:59:00'),
(156, 23, 'Tuesday', '00:00:00', '23:59:00'),
(157, 23, 'Wednesday', '00:00:00', '23:59:00'),
(158, 23, 'Thursday', '00:00:00', '23:59:00'),
(159, 23, 'Friday', '00:00:00', '23:59:00'),
(160, 23, 'Saturday', '00:00:00', '23:59:00'),
(161, 23, 'Sunday', '00:00:00', '23:59:00'),
(162, 24, 'Monday', '00:00:00', '23:59:00'),
(163, 24, 'Tuesday', '00:00:00', '23:59:00'),
(164, 24, 'Wednesday', '00:00:00', '23:59:00'),
(165, 24, 'Thursday', '00:00:00', '23:59:00'),
(166, 24, 'Friday', '00:00:00', '23:59:00'),
(167, 24, 'Saturday', '00:00:00', '23:59:00'),
(168, 24, 'Sunday', '00:00:00', '23:59:00'),
(169, 25, 'Monday', '00:00:00', '23:59:00'),
(170, 25, 'Tuesday', '00:00:00', '23:59:00'),
(171, 25, 'Wednesday', '00:00:00', '23:59:00'),
(172, 25, 'Thursday', '00:00:00', '23:59:00'),
(173, 25, 'Friday', '00:00:00', '23:59:00'),
(174, 25, 'Saturday', '00:00:00', '23:59:00'),
(175, 25, 'Sunday', '00:00:00', '23:59:00'),
(176, 26, 'Monday', '00:00:00', '23:59:00'),
(177, 26, 'Tuesday', '00:00:00', '23:59:00'),
(178, 26, 'Wednesday', '00:00:00', '23:59:00'),
(179, 26, 'Thursday', '00:00:00', '23:59:00'),
(180, 26, 'Friday', '00:00:00', '23:59:00'),
(181, 26, 'Saturday', '00:00:00', '23:59:00'),
(182, 26, 'Sunday', '00:00:00', '23:59:00'),
(183, 27, 'Monday', '00:00:00', '23:59:00'),
(184, 27, 'Tuesday', '00:00:00', '23:59:00'),
(185, 27, 'Wednesday', '00:00:00', '23:59:00'),
(186, 27, 'Thursday', '00:00:00', '23:59:00'),
(187, 27, 'Friday', '00:00:00', '23:59:00'),
(188, 27, 'Saturday', '00:00:00', '23:59:00'),
(189, 27, 'Sunday', '00:00:00', '23:59:00'),
(190, 28, 'Monday', '00:00:00', '23:59:00'),
(191, 28, 'Tuesday', '00:00:00', '23:59:00'),
(192, 28, 'Wednesday', '00:00:00', '23:59:00'),
(193, 28, 'Thursday', '00:00:00', '23:59:00'),
(194, 28, 'Friday', '00:00:00', '23:59:00'),
(195, 28, 'Saturday', '00:00:00', '23:59:00'),
(196, 28, 'Sunday', '00:00:00', '23:59:00'),
(197, 29, 'Monday', '00:00:00', '23:59:00'),
(198, 29, 'Tuesday', '00:00:00', '23:59:00'),
(199, 29, 'Wednesday', '00:00:00', '23:59:00'),
(200, 29, 'Thursday', '00:00:00', '23:59:00'),
(201, 29, 'Friday', '00:00:00', '23:59:00'),
(202, 29, 'Saturday', '00:00:00', '23:59:00'),
(203, 29, 'Sunday', '00:00:00', '23:59:00'),
(204, 30, 'Monday', '00:00:00', '23:59:00'),
(205, 30, 'Tuesday', '00:00:00', '23:59:00'),
(206, 30, 'Wednesday', '00:00:00', '23:59:00'),
(207, 30, 'Thursday', '00:00:00', '23:59:00'),
(208, 30, 'Friday', '00:00:00', '23:59:00'),
(209, 30, 'Saturday', '00:00:00', '23:59:00'),
(210, 30, 'Sunday', '00:00:00', '23:59:00'),
(211, 31, 'Monday', '08:00:00', '22:00:00'),
(212, 31, 'Tuesday', '08:00:00', '22:00:00'),
(213, 31, 'Wednesday', '08:00:00', '22:00:00'),
(214, 31, 'Thursday', '08:00:00', '22:00:00'),
(215, 31, 'Friday', '08:00:00', '22:00:00'),
(216, 31, 'Saturday', '08:00:00', '22:00:00'),
(217, 31, 'Sunday', '08:00:00', '22:00:00'),
(218, 32, 'Monday', '08:00:00', '22:00:00'),
(219, 32, 'Tuesday', '08:00:00', '22:00:00'),
(220, 32, 'Wednesday', '08:00:00', '22:00:00'),
(221, 32, 'Thursday', '08:00:00', '22:00:00'),
(222, 32, 'Friday', '08:00:00', '22:00:00'),
(223, 32, 'Saturday', '08:00:00', '22:00:00'),
(224, 32, 'Sunday', '08:00:00', '22:00:00'),
(225, 33, 'Monday', '08:00:00', '22:00:00'),
(226, 33, 'Tuesday', '08:00:00', '22:00:00'),
(227, 33, 'Wednesday', '08:00:00', '22:00:00'),
(228, 33, 'Thursday', '08:00:00', '22:00:00'),
(229, 33, 'Friday', '08:00:00', '22:00:00'),
(230, 33, 'Saturday', '08:00:00', '22:00:00'),
(231, 33, 'Sunday', '08:00:00', '22:00:00'),
(232, 34, 'Monday', '08:00:00', '22:00:00'),
(233, 34, 'Tuesday', '08:00:00', '22:00:00'),
(234, 34, 'Wednesday', '08:00:00', '22:00:00'),
(235, 34, 'Thursday', '08:00:00', '22:00:00'),
(236, 34, 'Friday', '08:00:00', '22:00:00'),
(237, 34, 'Saturday', '08:00:00', '22:00:00'),
(238, 34, 'Sunday', '08:00:00', '22:00:00'),
(239, 35, 'Monday', '08:00:00', '22:00:00'),
(240, 35, 'Tuesday', '08:00:00', '22:00:00'),
(241, 35, 'Wednesday', '08:00:00', '22:00:00'),
(242, 35, 'Thursday', '08:00:00', '22:00:00'),
(243, 35, 'Friday', '08:00:00', '22:00:00'),
(244, 35, 'Saturday', '08:00:00', '22:00:00'),
(245, 35, 'Sunday', '08:00:00', '22:00:00'),
(246, 36, 'Monday', '08:00:00', '22:00:00'),
(247, 36, 'Tuesday', '08:00:00', '22:00:00'),
(248, 36, 'Wednesday', '08:00:00', '22:00:00'),
(249, 36, 'Thursday', '08:00:00', '22:00:00'),
(250, 36, 'Friday', '08:00:00', '22:00:00'),
(251, 36, 'Saturday', '08:00:00', '22:00:00'),
(252, 36, 'Sunday', '08:00:00', '22:00:00'),
(253, 37, 'Monday', '08:00:00', '22:00:00'),
(254, 37, 'Tuesday', '08:00:00', '22:00:00'),
(255, 37, 'Wednesday', '08:00:00', '22:00:00'),
(256, 37, 'Thursday', '08:00:00', '22:00:00'),
(257, 37, 'Friday', '08:00:00', '22:00:00'),
(258, 37, 'Saturday', '08:00:00', '22:00:00'),
(259, 37, 'Sunday', '08:00:00', '22:00:00'),
(260, 38, 'Monday', '08:00:00', '22:00:00'),
(261, 38, 'Tuesday', '08:00:00', '22:00:00'),
(262, 38, 'Wednesday', '08:00:00', '22:00:00'),
(263, 38, 'Thursday', '08:00:00', '22:00:00'),
(264, 38, 'Friday', '08:00:00', '22:00:00'),
(265, 38, 'Saturday', '08:00:00', '22:00:00'),
(266, 38, 'Sunday', '08:00:00', '22:00:00'),
(267, 39, 'Monday', '08:00:00', '22:00:00'),
(268, 39, 'Tuesday', '08:00:00', '22:00:00'),
(269, 39, 'Wednesday', '08:00:00', '22:00:00'),
(270, 39, 'Thursday', '08:00:00', '22:00:00'),
(271, 39, 'Friday', '08:00:00', '22:00:00'),
(272, 39, 'Saturday', '08:00:00', '22:00:00'),
(273, 39, 'Sunday', '08:00:00', '22:00:00'),
(274, 40, 'Monday', '08:00:00', '22:00:00'),
(275, 40, 'Tuesday', '08:00:00', '22:00:00'),
(276, 40, 'Wednesday', '08:00:00', '22:00:00'),
(277, 40, 'Thursday', '08:00:00', '22:00:00'),
(278, 40, 'Friday', '08:00:00', '22:00:00'),
(279, 40, 'Saturday', '08:00:00', '22:00:00'),
(280, 40, 'Sunday', '08:00:00', '22:00:00');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `places`
--

CREATE TABLE `places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `region_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `price_start` decimal(15,2) DEFAULT 0.00,
  `price_end` decimal(15,2) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `places`
--

INSERT INTO `places` (`id`, `category_id`, `region_id`, `name`, `description`, `image_url`, `address`, `phone`, `latitude`, `longitude`, `price_start`, `price_end`, `website`, `is_verified`) VALUES
(1, 1, 1, 'Kampung Warna Warni Jodipan', 'Desa wisata unik dengan cat warna-warni.', 'images/1.webp', 'Jl. Jodipan, Kec. Blimbing', '0341-111001', -7.98287970, 112.63467990, 5000.00, NULL, NULL, 1),
(3, 1, 1, 'Kampung Biru Arema', 'Kampung tematik biru Arema FC.', 'images/3.webp', 'Jl. Kiduldalem', '0341-111003', -7.98130510, 112.63511760, 5000.00, NULL, NULL, 1),
(4, 1, 1, 'Alun-Alun Tugu Malang', 'Taman bersejarah di depan Balai Kota.', 'images/4.jpg', 'Jl. Tugu', '0341-111004', -7.97714300, 112.63147290, 0.00, NULL, NULL, 1),
(5, 1, 1, 'Alun-Alun Merdeka Malang', 'Pusat kota Malang dengan burung merpati.', 'images/5.webp', 'Jl. Merdeka Selatan', '0341-111005', -7.98261450, 112.62823640, 0.00, NULL, NULL, 1),
(6, 1, 1, 'Museum Brawijaya', 'Museum sejarah perjuangan.', 'images/6.webp', 'Jl. Ijen No.25A', '0341-562394', -7.97213250, 112.61863410, 5000.00, NULL, NULL, 1),
(7, 1, 1, 'Pasar Burung & Bunga Splendid', 'Pasar hobi burung dan tanaman hias.', 'images/7.webp', 'Jl. Brawijaya, Kauman', '0341-111007', -7.97750620, 112.62859850, 0.00, NULL, NULL, 1),
(8, 1, 1, 'Kayutangan Heritage', 'Kawasan wisata bangunan tua bersejarah.', 'images/8.jpg', 'Jl. Basuki Rahmat', '0341-111008', -7.97647100, 112.62536580, 0.00, NULL, NULL, 1),
(9, 1, 1, 'Taman Slamet', 'Taman kota yang asri dan sejuk.', 'images/9.jpg', 'Jl. Taman Slamet', '0341-111009', -7.97370800, 112.61987500, 0.00, NULL, NULL, 1),
(10, 1, 1, 'Museum Mpu Purwa', 'Museum peninggalan purbakala.', 'images/10.webp', 'Jl. Soekarno Hatta Perumahan Griya Shanta', '0341-404589', -7.94039070, 112.61824880, 0.00, NULL, NULL, 1),
(11, 2, 1, 'Toko Oen', 'Restoran nuansa kolonial Belanda.', 'images/11.jpg', 'Jl. Basuki Rahmat No.5', '0341-364052', -7.98070400, 112.62775710, 25000.00, NULL, NULL, 1),
(12, 2, 1, 'Rawon Nguling', 'Rawon daging hitam pekat legendaris.', 'images/12.jpg', 'Jl. Zainul Arifin', '0341-324683', -7.98388090, 112.62573940, 30000.00, NULL, NULL, 1),
(13, 2, 1, 'Bakso President', 'Bakso legendaris pinggir rel kereta.', 'images/13.jpg', 'Jl. Batanghari', '0341-496746', -7.95207800, 112.64608800, 20000.00, NULL, NULL, 1),
(14, 2, 1, 'Pecel Kawi', 'Nasi pecel khas Malang sejak 1975.', 'images/14.jpg', 'Jl. Kawi Atas', '0341-551567', -7.97572300, 112.62003300, 15000.00, NULL, NULL, 1),
(15, 2, 1, 'Depot Hok Lay', 'Lumpia dan Cwie Mie legendaris.', 'images/15.jpeg', 'Jl. KH Ahmad Dahlan', '0341-364513', -7.98455000, 112.63428500, 20000.00, NULL, NULL, 1),
(16, 2, 1, 'Inggil Museum Resto', 'Makan dengan suasana museum Jawa kuno.', 'images/16.jpg', 'Jl. Gajahmada No.4', '0341-332110', -7.98405000, 112.63418600, 35000.00, NULL, NULL, 1),
(17, 2, 1, 'Rawon Rampal', 'Rawon legendaris dengan daging empuk.', 'images/17.jpg', 'Jl. Panglima Sudirman', '0341-365389', -7.97421000, 112.63840500, 35000.00, NULL, NULL, 1),
(18, 2, 1, 'Sate Gebug 1920', 'Sate daging sapi pukul khas Malang.', 'images/18.jpg', 'Jl. Basuki Rahmat', '0341-364052', -7.96241320, 112.63578750, 30000.00, NULL, NULL, 1),
(19, 2, 1, 'Bakso Bakar Trowulan', 'Pelopor bakso bakar di Malang.', 'images/19.jpg', 'Jl. C.Trowulan', '0341-492576', -7.94131000, 112.63815300, 15000.00, NULL, NULL, 1),
(20, 2, 1, 'Depot Gang Djangkrik', 'Cwie mie dan makanan chinese food halal.', 'images/20.jpeg', 'Jl. Kawi', '0341-566270', -7.97537200, 112.61957100, 25000.00, NULL, NULL, 1),
(21, 3, 1, 'Hotel Tugu Malang', 'Hotel mewah barang antik terbaik.', 'images/21.jpg', 'Jl. Tugu No.3', '0341-363891', -7.97721200, 112.63316300, 1500000.00, NULL, NULL, 1),
(22, 3, 1, 'Atria Hotel Malang', 'Hotel bisnis bintang 4 strategis.', 'images/22.jpg', 'Jl. Letjen S. Parman', '0341-441888', -7.94943200, 112.63922100, 500000.00, NULL, NULL, 1),
(23, 3, 1, 'Savana Hotel & Convention', 'Hotel elegan bintang 4.', 'images/23.jpg', 'Jl. Letjen Sutoyo', '0341-495522', -7.96231400, 112.63623800, 520000.00, NULL, NULL, 1),
(24, 3, 1, 'HARRIS Hotel & Conventions', 'Hotel resort ramah keluarga.', 'images/24.jpg', 'Jl. A. Yani Utara', '0341-299333', -7.92575700, 112.64896400, 550000.00, NULL, NULL, 1),
(25, 3, 1, 'Swiss-Belinn Malang', 'Hotel modern dekat mall.', 'images/25.webp', 'Jl. Veteran', '0341-550368', -7.95546800, 112.61872900, 450000.00, NULL, NULL, 1),
(26, 3, 1, 'Whiz Prime Hotel Basuki Rahmat', 'Hotel budget lokasi prima.', 'images/26.jpg', 'Jl. Basuki Rahmat', '0341-355888', -7.97603800, 112.62912800, 350000.00, NULL, NULL, 1),
(27, 3, 1, 'Aria Gajayana Hotel', 'Hotel mewah di dalam mall MOG.', 'images/27.jpg', 'Jl. Kawi', '0341-336262', -7.97807800, 112.62395500, 750000.00, NULL, NULL, 1),
(28, 3, 1, 'Grand Citihub Hotel @Kajoetangan', 'Hotel budget modern di kawasan heritage.', 'images/28.jpg', 'Jl. Basuki Rahmat', '0341-366366', -7.97709800, 112.62960100, 300000.00, NULL, NULL, 1),
(29, 3, 1, 'Ibis Styles Malang', 'Hotel unik dengan desain warna-warni.', 'images/29.jpg', 'Jl. S. Parman', '0341-409988', -7.95253900, 112.63864100, 400000.00, NULL, NULL, 1),
(30, 3, 1, 'Grand Mercure Malang Mirama', 'Hotel premium bintang 5 terbaru.', 'images/30.jpg', 'Jl. Raden Panji Suroso', '0341-330000', -7.94222900, 112.64852900, 900000.00, NULL, NULL, 1),
(31, 4, 1, 'Malang Strudel', 'Oleh-oleh kekinian khas Malang.', 'images/31.webp', 'Jl. Semeru', '0341-3012773', -7.97350200, 112.62365200, 55000.00, NULL, NULL, 1),
(32, 4, 1, 'Pia Cap Mangkok', 'Pia legendaris sejak 1959.', 'images/32.webp', 'Jl. Semeru', '0341-362243', -7.97467800, 112.62519100, 25000.00, NULL, NULL, 1),
(33, 4, 1, 'Lapis Malang', 'Kue lapis lembut berbagai rasa.', 'images/33.webp', 'Jl. Kawi Atas', '0341-5078888', -7.98889900, 112.63221700, 35000.00, NULL, NULL, 1),
(34, 4, 1, 'Lancar Jaya', 'Pusat camilan dan kripik tempe.', 'images/34.webp', 'Jl. Tumenggung Suryo', '0341-492988', -7.96021100, 112.64264700, 20000.00, NULL, NULL, 1),
(35, 4, 1, 'Goedang Oleh-Oleh', 'Pusat oleh-oleh luas dan lengkap.', 'images/35.jpg', 'Jl. Tenaga Selatan', '0341-488688', -7.94861500, 112.64598800, 10000.00, NULL, NULL, 1),
(36, 4, 1, 'Toko Kue Gaya Baru', 'Toko kue klasik dan legendaris.', 'images/36.webp', 'Jl. Laksamana Martadinata', '0341-362272', -7.94048100, 112.62350500, 5000.00, NULL, NULL, 1),
(37, 4, 1, 'Toko Oen (Bakery)', 'Roti dan kue kering resep kuno.', 'images/37.jpg', 'Jl. Basuki Rahmat', '0341-364052', -7.97638200, 112.63220200, 15000.00, NULL, NULL, 1),
(38, 4, 1, 'Pia Cap Mangkok (Branch)', 'Cabang Pia Mangkok area Soekarno Hatta.', 'images/38.jpg', 'Jl. Soekarno Hatta', '0341-4375599', -7.93881800, 112.63067600, 25000.00, NULL, NULL, 1),
(39, 4, 1, 'Keripik Buah Kane Kane', 'Produsen kripik buah asli Malang.', 'images/39.jpg', 'Jl. Industri', '0341-482270', -7.93540000, 112.60780300, 18000.00, NULL, NULL, 1),
(40, 4, 1, 'Avia (Toko Roti & Kue)', 'Toko roti jadul favorit warga lokal.', 'images/40.webp', 'Jl. Jaksa Agung Suprapto', '0341-364444', -7.97406600, 112.62978400, 10000.00, NULL, NULL, 1),
(100, 1, 5, 'Pura Tanah Lot', 'Kuil ikonik di atas batu karang di tepi laut, menjadi salah satu sunset spot terbaik di Bali.', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800&q=80', 'Beraban, Kediri, Tabanan, Bali', '+62-361-880361', -8.62107000, 115.08698000, 60000.00, NULL, NULL, 1),
(101, 1, 6, 'Tegallalang Rice Terrace', 'Sawah bertingkat UNESCO yang memukau di Ubud, simbol keindahan subak Bali.', 'https://images.unsplash.com/photo-1555400038-63f5ba517a47?w=800&q=80', 'Jl. Raya Tegallalang, Gianyar, Bali', '+62-361-901234', -8.43198000, 115.27937000, 0.00, NULL, NULL, 1),
(102, 6, 12, 'Pantai Kelingking Nusa Penida', 'Pantai berbentuk kepala T-Rex dengan tebing dramatis, salah satu pantai paling indah di dunia.', 'https://images.unsplash.com/photo-1573790387438-4da905039392?w=800&q=80', 'Nusa Penida, Klungkung, Bali', NULL, -8.72618000, 115.46453000, 0.00, NULL, NULL, 1),
(103, 1, 5, 'Pura Uluwatu', 'Kuil tebing suci di ujung selatan Bali dengan pertunjukan Tari Kecak saat matahari terbenam.', 'https://images.unsplash.com/photo-1604999333679-b86d54738315?w=800&q=80', 'Pecatu, Kuta Selatan, Badung, Bali', '+62-361-9007567', -8.82932000, 115.08491000, 50000.00, NULL, NULL, 1),
(104, 1, 6, 'Sacred Monkey Forest Ubud', 'Hutan suci dengan ratusan monyet ekor panjang dan tiga pura bersejarah di jantung Ubud.', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80', 'Jl. Monkey Forest, Ubud, Gianyar, Bali', '+62-361-971304', -8.51888000, 115.25917000, 80000.00, NULL, NULL, 1),
(105, 3, 6, 'Four Seasons Resort Bali at Sayan', 'Resort mewah di tepi Sungai Ayung, Ubud, dengan villa private pool dan pemandangan hutan tropis.', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', 'Sayan, Ubud, Gianyar, Bali', '+62-361-977577', -8.50619000, 115.25126000, 8500000.00, NULL, NULL, 1),
(106, 3, 5, 'The Mulia Nusa Dua', 'Hotel bintang 5 mewah di tepi pantai Nusa Dua dengan kolam renang infinity dan spa kelas dunia.', 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800&q=80', 'Jl. Raya Nusa Dua Selatan, Badung, Bali', '+62-361-3017777', -8.80117000, 115.22847000, 5000000.00, NULL, NULL, 1),
(107, 2, 6, 'Locavore Ubud', 'Restoran fine dining terbaik di Bali dengan menu berbahan lokal Indonesia yang inovatif.', 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80', 'Jl. Dewi Sita No.10, Ubud, Gianyar', '+62-361-977733', -8.51345000, 115.26231000, 500000.00, NULL, NULL, 1),
(108, 2, 5, 'Merah Putih Restaurant', 'Restoran modern Indonesia di Seminyak dengan arsitektur bambu ikonik dan menu nusantara premium.', 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=800&q=80', 'Jl. Petitenget No.100X, Kerobokan, Badung', '+62-361-846-5030', -8.67893000, 115.15432000, 300000.00, NULL, NULL, 1),
(109, 5, 6, 'Seniman Coffee Studio', 'Kafe specialty coffee ikonik di Ubud dengan biji kopi pilihan dari seluruh Nusantara.', 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800&q=80', 'Jl. Sriwedari No.5, Ubud, Gianyar', '+62-361-972085', -8.50634000, 115.26378000, 45000.00, NULL, NULL, 1),
(110, 5, 5, 'Shelter Cafe Bali', 'Kafe tropis dengan kolam renang, hammock, dan pemandangan sawah di Canggu.', 'https://images.unsplash.com/photo-1445116572660-236099ec97a0?w=800&q=80', 'Jl. Pantai Berawa, Canggu, Badung', NULL, -8.65432000, 115.13245000, 75000.00, NULL, NULL, 1),
(111, 6, 5, 'Pantai Seminyak', 'Pantai sunset favorit di Bali dengan beach club mewah, bar, dan ombak yang sempurna untuk surfing.', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&q=80', 'Seminyak, Kuta, Badung, Bali', NULL, -8.69214000, 115.15789000, 0.00, NULL, NULL, 1),
(112, 6, 12, 'Crystal Bay Nusa Penida', 'Teluk kristal jernih dengan ikan Mola-Mola, spot snorkeling dan diving terbaik di Nusa Penida.', 'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800&q=80', 'Nusa Penida, Klungkung, Bali', NULL, -8.73198000, 115.47821000, 0.00, NULL, NULL, 1),
(200, 1, 7, 'Monumen Nasional (Monas)', 'Tugu kemerdekaan Indonesia setinggi 132 meter di jantung Jakarta, simbol kebanggaan bangsa.', 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=800&q=80', 'Gambir, Jakarta Pusat', '+62-21-3810040', -6.17564000, 106.82718000, 20000.00, NULL, NULL, 1),
(201, 1, 7, 'Kota Tua Jakarta', 'Kawasan bersejarah peninggalan kolonial Belanda dengan museum-museum dan café vintage.', 'https://images.unsplash.com/photo-1584810359583-96fc3448beaa?w=800&q=80', 'Tamansari, Jakarta Barat', NULL, -6.13566000, 106.81333000, 0.00, NULL, NULL, 1),
(202, 1, 7, 'Museum Nasional Indonesia', 'Museum terbesar di Indonesia dengan koleksi 190.000 artefak dari seluruh nusantara.', 'https://images.unsplash.com/photo-1551966775-a4ddc8df052b?w=800&q=80', 'Jl. Medan Merdeka Barat No.12, Jakarta Pusat', '+62-21-3868172', -6.17654000, 106.82219000, 10000.00, NULL, NULL, 1),
(203, 3, 14, 'Hotel Indonesia Kempinski', 'Hotel bersejarah bintang 5 di jantung Jakarta dengan pemandangan Bundaran HI yang ikonik.', 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80', 'Jl. M.H. Thamrin No.1, Jakarta Pusat', '+62-21-2358-3800', -6.19461000, 106.82318000, 3500000.00, NULL, NULL, 1),
(204, 2, 14, 'Sate Khas Senayan', 'Restoran sate legendaris Jakarta dengan bumbu kacang otentik dan suasana tradisional Jawa.', 'https://images.unsplash.com/photo-1529042410759-befb1204b468?w=800&q=80', 'Jl. Kebon Sirih No.31A, Jakarta Pusat', '+62-21-3904049', -6.18923000, 106.82671000, 85000.00, NULL, NULL, 1),
(205, 5, 14, 'Anomali Coffee', 'Pionir specialty coffee Indonesia dengan konsep farm-to-cup dari kebun kopi seluruh nusantara.', 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&q=80', 'Jl. Senopati No.24, Kebayoran Baru, Jakarta Selatan', '+62-21-27088576', -6.24156000, 106.80938000, 55000.00, NULL, NULL, 1),
(206, 1, 15, 'Kepulauan Seribu', 'Gugusan 110 pulau di Teluk Jakarta dengan pantai putih, snorkeling, dan resort terpencil.', 'https://images.unsplash.com/photo-1548032885-b5e38734688a?w=800&q=80', 'Kepulauan Seribu, Jakarta Utara', NULL, -5.61234000, 106.54321000, 200000.00, NULL, NULL, 1),
(300, 1, 17, 'Candi Borobudur', 'Candi Buddha terbesar di dunia, Warisan Dunia UNESCO, dibangun abad ke-8 oleh Dinasti Sailendra.', 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800&q=80', 'Borobudur, Magelang, Jawa Tengah', '+62-293-788266', -7.60789000, 110.20367000, 50000.00, NULL, NULL, 1),
(301, 1, 8, 'Candi Prambanan', 'Kompleks candi Hindu terbesar di Indonesia, dibangun abad ke-9, berdiri megah di perbatasan Jawa.', 'https://images.unsplash.com/photo-1565967511849-76a60a516170?w=800&q=80', 'Prambanan, Sleman, DI Yogyakarta', '+62-274-496401', -7.75204000, 110.49145000, 50000.00, NULL, NULL, 1),
(302, 1, 8, 'Keraton Ngayogyakarta', 'Istana Kesultanan Yogyakarta yang masih aktif, pusat kebudayaan Jawa dan warisan kerajaan.', 'https://images.unsplash.com/photo-1570829460005-c840387bb1ca?w=800&q=80', 'Jl. Rotowijayan Blok No.1, Yogyakarta', '+62-274-373721', -7.80509000, 110.36435000, 15000.00, NULL, NULL, 1),
(303, 1, 8, 'Jalan Malioboro', 'Jantung wisata Yogyakarta: belanja batik, kerajinan, kuliner kaki lima, dan suasana khas Jawa.', 'https://images.unsplash.com/photo-1548454782-15b189d129ab?w=800&q=80', 'Jl. Malioboro, Gedongtengen, Yogyakarta', NULL, -7.79268000, 110.36585000, 0.00, NULL, NULL, 1),
(304, 6, 18, 'Pantai Parangtritis', 'Pantai mistis di selatan Yogyakarta dengan legenda Nyi Roro Kidul dan ombak besar Samudra Hindia.', 'https://images.unsplash.com/photo-1520454974749-a49e13a3df3a?w=800&q=80', 'Parangtritis, Kretek, Bantul', NULL, -8.02341000, 110.33234000, 10000.00, NULL, NULL, 1),
(305, 3, 8, 'Royal Ambarrukmo Hotel', 'Hotel bersejarah bintang 5 di Yogyakarta, bertumpu pada warisan budaya keraton Jawa.', 'https://images.unsplash.com/photo-1551882547-ff40c63fe2e2?w=800&q=80', 'Jl. Laksda Adisucipto No.81, Yogyakarta', '+62-274-488488', -7.78623000, 110.40173000, 1800000.00, NULL, NULL, 1),
(306, 2, 8, 'Gudeg Mbah Lindu', 'Warung gudeg legendaris di Yogyakarta yang buka sejak 1950-an, spesialis gudeg kering otentik.', 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=800&q=80', 'Jl. Sosrowijayan No.67, Yogyakarta', NULL, -7.79452000, 110.36321000, 25000.00, NULL, NULL, 1),
(307, 4, 8, 'Batik Plentong', 'Toko batik tulis berkualitas tinggi di Yogyakarta dengan pengerjaan tradisional yang autentik.', 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=800&q=80', 'Jl. Tirtodipuran No.48, Yogyakarta', '+62-274-386471', -7.81234000, 110.36789000, 150000.00, NULL, NULL, 1),
(308, 7, 17, 'Gunung Merapi', 'Gunung berapi paling aktif di Indonesia, menawarkan trekking mendebarkan dan pemandangan spektakuler.', 'https://images.unsplash.com/photo-1540979388789-6cee28a1cdc9?w=800&q=80', 'Lereng Merapi, Sleman, DI Yogyakarta', NULL, -7.54021000, 110.44543000, 100000.00, NULL, NULL, 1),
(400, 7, 20, 'Kawah Putih', 'Danau kawah vulkanik berwarna putih kehijauan di ketinggian 2.430 mdpl, pemandangan sangat unik.', 'https://images.unsplash.com/photo-1591839188649-524bf38d9c4e?w=800&q=80', 'Ciwidey, Bandung Selatan, Jawa Barat', '+62-22-5924083', -7.16650000, 107.40197000, 50000.00, NULL, NULL, 1),
(401, 2, 19, 'Warung Nasi Ibu Imas', 'Warung legendaris nasi Sunda di Bandung dengan lalapan segar dan sambal terasi yang menggugah selera.', 'https://images.unsplash.com/photo-1512058564366-18510be2db19?w=800&q=80', 'Jl. Dago No.88, Coblong, Bandung', '+62-22-2503450', -6.88543000, 107.61234000, 35000.00, NULL, NULL, 1),
(402, 5, 19, 'Kopi Toko Djawa', 'Kafe ikonik di Gedung Merdeka Bandung dengan interior art deco kolonial dan kopi Arabika pilihan.', 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800&q=80', 'Jl. Asia Afrika No.81, Sumur Bandung, Bandung', '+62-22-4230860', -6.92087000, 107.60891000, 55000.00, NULL, NULL, 1),
(403, 3, 19, 'Trans Luxury Hotel Bandung', 'Hotel ultra mewah bintang 5 di Bandung dengan spa, kolam renang rooftop, dan pemandangan kota.', 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=800&q=80', 'Jl. Gatot Subroto No.289, Bandung', '+62-22-87340888', -6.91234000, 107.62456000, 2500000.00, NULL, NULL, 1),
(404, 1, 19, 'Gedung Sate Bandung', 'Ikon arsitektur kolonial Bandung dengan ornamen sate unik, kini menjadi kantor Gubernur Jawa Barat.', 'https://images.unsplash.com/photo-1566438480900-0609be27a4be?w=800&q=80', 'Jl. Diponegoro No.22, Citarum, Bandung', '+62-22-4232448', -6.90234000, 107.61897000, 0.00, NULL, NULL, 1),
(500, 2, 21, 'Coto Makassar Haji Udin', 'Warung coto makassar paling terkenal di kota, sup jeroan sapi dengan bumbu rempah khas Bugis.', 'https://images.unsplash.com/photo-1547592180-85f173990554?w=800&q=80', 'Jl. Nusantara Baru No.35, Makassar', NULL, -5.13765000, 119.41298000, 30000.00, NULL, NULL, 1),
(501, 6, 21, 'Pantai Losari', 'Pantai ikonik Makassar dengan promenade sepanjang 1km, sunset spektakuler, dan kuliner kaki lima.', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&q=80', 'Jl. Penghibur, Losari, Makassar', NULL, -5.14213000, 119.40876000, 0.00, NULL, NULL, 1),
(502, 1, 22, 'Toraja Kete Kesu', 'Kampung adat Toraja dengan rumah Tongkonan berusia ratusan tahun dan kuburan batu tebing.', 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80', 'Kete Kesu, Rantepao, Toraja Utara', NULL, -2.96987000, 119.89432000, 30000.00, NULL, NULL, 1),
(503, 7, 22, 'Lolai To Tombi', 'Negeri di atas awan Toraja — padang rumput tinggi dengan pemandangan awan di bawah kaki.', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80', 'Lolai, Toraja Utara, Sulawesi Selatan', NULL, -2.87654000, 119.98765000, 15000.00, NULL, NULL, 1),
(600, 2, 23, 'Rumah Makan Lamun Ombak', 'Restoran seafood legendaris Padang dengan pemandangan langsung ke Samudra Hindia.', 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80', 'Jl. Samudera No.1, Padang', '+62-751-23456', -0.94765000, 100.35432000, 75000.00, NULL, NULL, 1),
(601, 6, 23, 'Pantai Air Manis', 'Pantai indah di Padang dengan legenda Malin Kundang dan batu berbentuk manusia terkutuk.', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=800&q=80', 'Air Manis, Padang Selatan, Padang', NULL, -0.98765000, 100.36123000, 10000.00, NULL, NULL, 1),
(602, 7, 23, 'Lembah Harau', 'Lembah spektakuler dengan tebing granit setinggi 100-300 meter dan air terjun di Limapuluh Kota.', 'https://images.unsplash.com/photo-1448375240586-882707db888b?w=800&q=80', 'Harau, Lima Puluh Kota, Sumatera Barat', NULL, -0.11234000, 100.67890000, 15000.00, NULL, NULL, 1),
(700, 1, 4, 'House of Sampoerna', 'Museum rokok kretek bersejarah di Kota Tua Surabaya dengan bangunan kolonial Belanda yang cantik.', 'https://images.unsplash.com/photo-1551966775-a4ddc8df052b?w=800&q=80', 'Taman Sampoerna No.6, Krembangan, Surabaya', '+62-31-3539000', -7.24534000, 112.73421000, 0.00, NULL, NULL, 1),
(701, 2, 4, 'Rawon Setan Surabaya', 'Warung rawon setan legendaris Surabaya yang buka tengah malam, sup daging hitam keluak terenak.', 'https://images.unsplash.com/photo-1547592180-85f173990554?w=800&q=80', 'Jl. Embong Malang No.78, Genteng, Surabaya', NULL, -7.26543000, 112.74532000, 35000.00, NULL, NULL, 1),
(702, 3, 4, 'JW Marriott Hotel Surabaya', 'Hotel bintang 5 di pusat bisnis Surabaya dengan rooftop pool, spa, dan akses mudah ke mal mewah.', 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80', 'Jl. Embong Malang No.85-89, Surabaya', '+62-31-5458888', -7.26789000, 112.74123000, 2000000.00, NULL, NULL, 1),
(703, 5, 4, 'Rollaas Coffee Surabaya', 'Kafe specialty coffee dengan konsep kebun teh dan kopi milik PTPN XII, pengalaman unik di Surabaya.', 'https://images.unsplash.com/photo-1442512595331-e89e73853f31?w=800&q=80', 'Jl. Pregolan Bunder No.1, Surabaya', '+62-31-5460065', -7.24321000, 112.73654000, 50000.00, NULL, NULL, 1),
(800, 6, 3, 'Pantai Balekambang', 'Pantai eksotis dengan pura di atas batu karang mirip Tanah Lot, dijuluki \"Tanah Lot van Java\".', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&q=80', 'Srigonco, Bantur, Kabupaten Malang', NULL, -8.36543000, 112.56789000, 15000.00, NULL, NULL, 1),
(801, 7, 3, 'Coban Rondo Waterfall', 'Air terjun indah setinggi 84 meter dikelilingi hutan pinus di lereng Gunung Kawi.', 'https://images.unsplash.com/photo-1506905925346-21bda4d32df4?w=800&q=80', 'Pandesari, Pujon, Kabupaten Malang', '+62-341-524123', -7.87654000, 112.48765000, 20000.00, NULL, NULL, 1),
(802, 5, 1, 'Toko Oen Malang', 'Toko kue dan es krim legendaris sejak 1930, dengan resep warisan Belanda dan suasana nostalgia.', 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800&q=80', 'Jl. Jend. Basuki Rahmat No.5, Malang', '+62-341-364052', -7.98071000, 112.62776000, 30000.00, NULL, NULL, 1),
(803, 7, 2, 'Jatim Park 1', 'Taman hiburan edukasi terbesar di Jawa Timur dengan wahana seru dan museum sains interaktif.', 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=800&q=80', 'Jl. Kartika No.2, Batu, Jawa Timur', '+62-341-591000', -7.87234000, 112.52341000, 100000.00, NULL, NULL, 1),
(804, 4, 1, 'Kampung Wisata Keramik Dinoyo', 'Sentra kerajinan keramik tradisional Malang dengan ratusan pengrajin dan toko souvenir unik.', 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=800&q=80', 'Jl. MT. Haryono No.9, Dinoyo, Malang', NULL, -7.95432000, 112.60234000, 0.00, NULL, NULL, 1),
(900, 1, 24, 'Lawang Sewu', 'Gedung bersejarah peninggalan Belanda dengan seribu pintu, ikon kota Semarang yang penuh misteri dan sejarah.', 'https://images.unsplash.com/photo-1584810359583-96fc3448beaa?w=800&q=80', 'Jl. Pemuda, Sekayu, Semarang Tengah, Semarang', '+62-24-3584075', -6.98373000, 110.41056000, 20000.00, NULL, NULL, 1),
(901, 2, 24, 'Lumpia Gang Lombok', 'Lumpia Semarang paling legendaris sejak 1800-an, dengan isian rebung, telur, dan ayam yang gurih sempurna.', 'https://images.unsplash.com/photo-1455619452474-d2be8b1e70cd?w=800&q=80', 'Gang Lombok No.11, Kranggan, Semarang Tengah', '+62-24-3543587', -6.97234000, 110.41987000, 25000.00, NULL, NULL, 1),
(902, 1, 24, 'Kota Lama Semarang', 'Kawasan kota tua peninggalan kolonial VOC Belanda, dijuluki \"Little Netherlands\" dengan 50+ bangunan bersejarah.', 'https://images.unsplash.com/photo-1566438480900-0609be27a4be?w=800&q=80', 'Kota Lama, Semarang Barat, Semarang', NULL, -6.96543000, 110.42876000, 0.00, NULL, NULL, 1),
(903, 5, 24, 'Spiegel Bar & Bistro', 'Kafe dan bar bergaya Art Deco di gedung bersejarah Kota Lama, suasana Eropa di jantung Semarang.', 'https://images.unsplash.com/photo-1445116572660-236099ec97a0?w=800&q=80', 'Jl. Letjen Suprapto No.31-35, Kota Lama, Semarang', '+62-24-3583726', -6.96789000, 110.42543000, 60000.00, NULL, NULL, 1),
(904, 3, 24, 'Gumaya Tower Hotel', 'Hotel bintang 5 tertinggi di Semarang dengan pemandangan kota 360 derajat dan fasilitas lengkap.', 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800&q=80', 'Jl. Gajah Mada No.59-61, Semarang', '+62-24-3553333', -6.98123000, 110.40987000, 1200000.00, NULL, NULL, 1),
(905, 1, 25, 'Candi Borobudur', 'Candi Buddha terbesar di dunia dan Warisan Dunia UNESCO, dibangun abad ke-8 oleh Dinasti Sailendra. Megah saat sunrise.', 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800&q=80', 'Borobudur, Magelang, Jawa Tengah', '+62-293-788266', -7.60789000, 110.20367000, 50000.00, NULL, NULL, 1),
(906, 7, 25, 'Bukit Rhema (Gereja Ayam)', 'Bangunan unik berbentuk burung merpati di bukit yang menghadap langsung ke Candi Borobudur.', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80', 'Gombong, Borobudur, Magelang, Jawa Tengah', NULL, -7.60234000, 110.19876000, 25000.00, NULL, NULL, 1),
(907, 5, 25, 'Plataran Borobudur', 'Resor dan restoran premium dengan pemandangan langsung ke Candi Borobudur di antara kebun teh hijau.', 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80', 'Dusun Tanjungan, Borobudur, Magelang', '+62-293-788888', -7.61234000, 110.20543000, 200000.00, NULL, NULL, 1),
(908, 1, 26, 'Keraton Kasunanan Surakarta', 'Istana kerajaan Kasunanan Solo, pusat kebudayaan Jawa dengan koleksi pusaka dan pertunjukan seni tradisional.', 'https://images.unsplash.com/photo-1570829460005-c840387bb1ca?w=800&q=80', 'Jl. Sindet Raden Mas Said, Baluwarti, Solo', '+62-271-634564', -7.57234000, 110.83456000, 15000.00, NULL, NULL, 1),
(909, 4, 26, 'Pasar Klewer Solo', 'Pasar batik terbesar di Indonesia, surga belanja kain batik Solo dengan ratusan motif dari seluruh Nusantara.', 'https://images.unsplash.com/photo-1558769132-cb1aea458c5e?w=800&q=80', 'Jl. DR. Radjiman No.5A, Gajahan, Solo', NULL, -7.57654000, 110.82987000, 50000.00, NULL, NULL, 1),
(910, 2, 26, 'Nasi Liwet Wongso Lemu', 'Warung nasi liwet paling legendaris di Solo sejak 1950, dengan ayam opor, areh, dan telur pindang khas.', 'https://images.unsplash.com/photo-1547592180-85f173990554?w=800&q=80', 'Jl. Teuku Umar, Keprabon, Banjarsari, Solo', NULL, -7.56543000, 110.82765000, 20000.00, NULL, NULL, 1),
(911, 3, 26, 'The Sunan Hotel Solo', 'Hotel bintang 5 kebanggaan Kota Solo dengan nuansa budaya Jawa dan fasilitas MICE terlengkap.', 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80', 'Jl. Ahmad Yani No.40, Kerten, Laweyan, Solo', '+62-271-731312', -7.56789000, 110.81234000, 1500000.00, NULL, NULL, 1),
(912, 1, 27, 'Candi Cetho', 'Candi Hindu abad ke-15 di lereng Gunung Lawu setinggi 1.496 mdpl, dengan pemandangan lembah yang dramatis.', 'https://images.unsplash.com/photo-1596402184320-417e7178b2cd?w=800&q=80', 'Cetho, Jenawi, Karanganyar, Jawa Tengah', NULL, -7.59876000, 111.16543000, 10000.00, NULL, NULL, 1),
(913, 7, 27, 'Kebun Teh Kemuning', 'Perkebunan teh hijau di lereng Gunung Lawu dengan udara segar dan panorama kebun teh yang memukau.', 'https://images.unsplash.com/photo-1448375240586-882707db888b?w=800&q=80', 'Kemuning, Ngargoyoso, Karanganyar, Jawa Tengah', NULL, -7.62345000, 111.14321000, 10000.00, NULL, NULL, 1),
(1000, 6, 28, 'Pantai Kemala Balikpapan', 'Pantai berpasir putih paling populer di Balikpapan, cocok untuk berenang, sunset, dan kuliner seafood tepi pantai.', 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800&q=80', 'Jl. Jenderal Sudirman, Telaga Sari, Balikpapan Tengah', NULL, -1.26543000, 116.83210000, 0.00, NULL, NULL, 1),
(1001, 2, 28, 'Ocean\'s Resto Balikpapan', 'Restoran seafood romantis tepi laut Balikpapan dengan pemandangan sunset langsung ke Teluk Balikpapan.', 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80', 'Jl. Marsma R. Iswahyudi No.4, Gunung Bahagia, Balikpapan Selatan', '+62-542-761234', -1.28901000, 116.83654000, 100000.00, NULL, NULL, 1),
(1002, 2, 28, 'Dandito Restaurant', 'Restoran kepiting dan seafood paling terkenal di Balikpapan, wajib coba Dandito sauce crab khas Kalimantan.', 'https://images.unsplash.com/photo-1547592180-85f173990554?w=800&q=80', 'Jl. Jenderal Sudirman No.73, Gunung Bahagia, Balikpapan Selatan', '+62-542-421234', -1.28765000, 116.83432000, 80000.00, NULL, NULL, 1),
(1003, 3, 28, 'Four Points by Sheraton Balikpapan', 'Hotel bintang 4 modern di pusat kota Balikpapan dengan kolam renang outdoor dan pemandangan Teluk Balikpapan.', 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?w=800&q=80', 'Jl. Pelita No.1, Gunung Sari Ulu, Balikpapan Tengah', '+62-542-8880000', -1.26789000, 116.83123000, 1200000.00, NULL, NULL, 1),
(1004, 7, 28, 'Bukit Bangkirai', 'Kawasan wisata hutan hujan tropis Kalimantan dengan canopy bridge sepanjang 64 meter di ketinggian 30 meter.', 'https://images.unsplash.com/photo-1448375240586-882707db888b?w=800&q=80', 'Km. 38, Jl. Soekarno Hatta, Samboja, Kutai Kartanegara', '+62-542-531234', -1.09876000, 117.00123000, 25000.00, NULL, NULL, 1),
(1005, 5, 28, 'Kafe Malabar Balikpapan', 'Kafe cozy di Balikpapan dengan kopi lokal Kalimantan dan pemandangan kota, favorit komunitas kreatif.', 'https://images.unsplash.com/photo-1501339847302-ac426a4a7cbb?w=800&q=80', 'Jl. MT. Haryono No.12, Balikpapan Kota', NULL, -1.26543000, 116.82890000, 35000.00, NULL, NULL, 1),
(1006, 1, 29, 'Masjid Islamic Center Samarinda', 'Masjid terbesar di Asia Tenggara dengan menara setinggi 99 meter dan kubah emas megah di tepi Sungai Mahakam.', 'https://images.unsplash.com/photo-1591004124937-14b79c23b8e0?w=800&q=80', 'Jl. Slamet Riyadi, Teluk Lerong Ulu, Samarinda Ulu', '+62-541-201234', -0.48765000, 117.13456000, 0.00, NULL, NULL, 1),
(1007, 7, 29, 'Sungai Mahakam', 'Sungai terpanjang di Kalimantan Timur, wisata perahu tradisional melewati kampung apung dan hutan mangrove.', 'https://images.unsplash.com/photo-1559827291-72ee739d0d9a?w=800&q=80', 'Tepian Mahakam, Samarinda', NULL, -0.50234000, 117.14321000, 50000.00, NULL, NULL, 1),
(1008, 3, 29, 'HARRIS Hotel Samarinda', 'Hotel bintang 4 modern di pusat Samarinda dengan kolam renang, gym, dan akses mudah ke pusat perbelanjaan.', 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800&q=80', 'Jl. Bhayangkara No.Id, Sungai Pinang Luar, Samarinda Utara', '+62-541-7778888', -0.48123000, 117.13890000, 900000.00, NULL, NULL, 1),
(1009, 2, 29, 'Rumah Makan Torani Samarinda', 'Restoran seafood populer di Samarinda dengan menu kepiting, ikan bakar, dan cumi serta harga yang terjangkau.', 'https://images.unsplash.com/photo-1529042410759-befb1204b468?w=800&q=80', 'Jl. KH. Abul Hasan No.54, Pasar Pagi, Samarinda Kota', '+62-541-734567', -0.50456000, 117.14789000, 60000.00, NULL, NULL, 1),
(1010, 6, 30, 'Kepulauan Derawan', 'Surga bawah laut kelas dunia di Kalimantan Timur — penyu hijau, ubur-ubur danau, dan terumbu karang spektakuler.', 'https://images.unsplash.com/photo-1559827291-72ee739d0d9a?w=800&q=80', 'Kepulauan Derawan, Berau, Kalimantan Timur', NULL, 2.28761000, 118.23456000, 150000.00, NULL, NULL, 1),
(1011, 6, 30, 'Danau Ubur-Ubur Kakaban', 'Danau air laut terisolasi di Pulau Kakaban dengan jutaan ubur-ubur tak berbisa, fenomena alam langka di dunia.', 'https://images.unsplash.com/photo-1519046904884-53103b34b206?w=800&q=80', 'Pulau Kakaban, Kepulauan Derawan, Berau', NULL, 2.15432000, 118.49876000, 200000.00, NULL, NULL, 1),
(1100, 1, 31, 'Taman Nasional Komodo', 'Warisan Dunia UNESCO, rumah bagi Komodo — kadal terbesar di dunia. Menjelajahi pulau Komodo dan Rinca adalah pengalaman tak terlupakan.', 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80', 'Kepulauan Komodo, Labuan Bajo, Manggarai Barat', '+62-385-41025', -8.55000000, 119.48000000, 150000.00, NULL, NULL, 1),
(1101, 6, 31, 'Pink Beach Komodo', 'Salah satu dari hanya 7 pantai berpasir merah muda di dunia, dengan air biru jernih dan terumbu karang yang memukau.', 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=800&q=80', 'Pulau Komodo, Labuan Bajo, Manggarai Barat', NULL, -8.65432000, 119.54321000, 0.00, NULL, NULL, 1),
(1102, 7, 31, 'Manta Point Labuan Bajo', 'Spot menyelam dan snorkeling terbaik di dunia untuk berenang bersama pari manta raksasa di perairan hangat Flores.', 'https://images.unsplash.com/photo-1573790387438-4da905039392?w=800&q=80', 'Perairan Komodo, Labuan Bajo, Manggarai Barat', NULL, -8.72345000, 119.62345000, 350000.00, NULL, NULL, 1),
(1103, 3, 31, 'AYANA Komodo Waecicu Beach', 'Resort bintang 5 terbaik di Labuan Bajo dengan private beach, infinity pool, dan pemandangan Kepulauan Komodo.', 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80', 'Jl. Waecicu, Labuan Bajo, Manggarai Barat', '+62-385-2040000', -8.48765000, 119.85432000, 5000000.00, NULL, NULL, 1),
(1104, 3, 31, 'Plataran Komodo Resort & Spa', 'Resor butik mewah di Labuan Bajo dengan villa kayu di tepi laut dan akses eksklusif ke perairan Komodo.', 'https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=800&q=80', 'Jl. Pantai Pede, Labuan Bajo, Manggarai Barat', '+62-385-2041234', -8.49876000, 119.86543000, 3500000.00, NULL, NULL, 1),
(1105, 2, 31, 'Kampung Ujung Seafood Labuan Bajo', 'Deretan warung seafood segar di pelabuhan Labuan Bajo dengan pemandangan langsung ke Kepulauan Komodo saat sunset.', 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?w=800&q=80', 'Kampung Ujung, Labuan Bajo, Manggarai Barat', NULL, -8.49543000, 119.87654000, 75000.00, NULL, NULL, 1),
(1106, 1, 31, 'Bukit Cinta Labuan Bajo', 'Bukit romantis dengan pemandangan panorama 360 derajat Kepulauan Komodo dan sunset paling indah di Flores.', 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=800&q=80', 'Bukit Cinta, Labuan Bajo, Manggarai Barat', NULL, -8.47654000, 119.87123000, 20000.00, NULL, NULL, 1),
(1107, 1, 32, 'Wae Rebo Village', 'Desa adat terpencil di pegunungan Flores dengan rumah kerucut Mbaru Niang warisan budaya dunia UNESCO.', 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=800&q=80', 'Desa Wae Rebo, Satar Mese Barat, Manggarai', NULL, -8.74321000, 120.34567000, 375000.00, NULL, NULL, 1),
(1108, 5, 31, 'Treehouse Cafe Labuan Bajo', 'Kafe unik di atas pohon dengan hammock dan pemandangan Teluk Labuan Bajo, spot favorit para traveler.', 'https://images.unsplash.com/photo-1445116572660-236099ec97a0?w=800&q=80', 'Jl. Soekarno Hatta, Labuan Bajo, Manggarai Barat', NULL, -8.49123000, 119.86789000, 45000.00, NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `place_facilities`
--

CREATE TABLE `place_facilities` (
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `facility_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `place_facilities`
--

INSERT INTO `place_facilities` (`place_id`, `facility_id`) VALUES
(1, 2),
(1, 4),
(3, 2),
(3, 4),
(4, 2),
(4, 4),
(5, 2),
(5, 4),
(6, 2),
(6, 4),
(7, 2),
(7, 4),
(8, 2),
(8, 4),
(9, 2),
(9, 4),
(10, 2),
(10, 4),
(11, 1),
(11, 2),
(11, 4),
(11, 5),
(12, 1),
(12, 2),
(12, 4),
(12, 5),
(13, 1),
(13, 2),
(13, 4),
(13, 5),
(14, 1),
(14, 2),
(14, 4),
(14, 5),
(15, 1),
(15, 2),
(15, 4),
(15, 5),
(16, 1),
(16, 2),
(16, 4),
(16, 5),
(17, 1),
(17, 2),
(17, 4),
(17, 5),
(18, 1),
(18, 2),
(18, 4),
(18, 5),
(19, 1),
(19, 2),
(19, 4),
(19, 5),
(20, 1),
(20, 2),
(20, 4),
(20, 5),
(21, 1),
(21, 2),
(21, 4),
(21, 6),
(21, 7),
(22, 1),
(22, 2),
(22, 4),
(22, 6),
(22, 7),
(23, 1),
(23, 2),
(23, 4),
(23, 6),
(23, 7),
(24, 1),
(24, 2),
(24, 4),
(24, 6),
(24, 7),
(25, 1),
(25, 2),
(25, 4),
(25, 6),
(25, 7),
(26, 1),
(26, 2),
(26, 4),
(26, 6),
(26, 7),
(27, 1),
(27, 2),
(27, 4),
(27, 6),
(27, 7),
(28, 1),
(28, 2),
(28, 4),
(28, 6),
(28, 7),
(29, 1),
(29, 2),
(29, 4),
(29, 6),
(29, 7),
(30, 1),
(30, 2),
(30, 4),
(30, 6),
(30, 7),
(31, 2),
(31, 4),
(32, 2),
(32, 4),
(33, 2),
(33, 4),
(34, 2),
(34, 4),
(35, 2),
(35, 4),
(36, 2),
(36, 4),
(37, 2),
(37, 4),
(38, 2),
(38, 4),
(39, 2),
(39, 4),
(40, 2),
(40, 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `provinces`
--

CREATE TABLE `provinces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `provinces`
--

INSERT INTO `provinces` (`id`, `name`, `slug`, `description`, `image_url`) VALUES
(1, 'Jawa Timur', 'jawa-timur', 'Provinsi terbesar di Jawa dengan wisata alam, budaya, dan kuliner yang kaya.', 'https://images.unsplash.com/photo-1588668214407-6ea9a6d8c272?w=600&q=80'),
(2, 'Bali', 'bali', 'Pulau Dewata, destinasi wisata internasional paling terkenal di Indonesia.', 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=600&q=80'),
(3, 'DKI Jakarta', 'dki-jakarta', 'Ibukota Indonesia, pusat bisnis, budaya, dan sejarah modern.', 'https://images.unsplash.com/photo-1555899434-94d1368aa7af?w=600&q=80'),
(4, 'Jawa Tengah', 'jawa-tengah', 'Pusat kebudayaan Jawa dengan candi-candi bersejarah.', 'https://upload.wikimedia.org/wikipedia/commons/9/9e/Kraton_Solo.jpg'),
(5, 'Jawa Barat', 'jawa-barat', 'Provinsi dengan keragaman alam dari pantai hingga pegunungan.', 'https://c.files.bbci.co.uk/0057/production/_108578000_gettyimages-923316538.jpg'),
(6, 'Yogyakarta', 'yogyakarta', 'Kota pelajar dan budaya Jawa, pusat seni dan warisan kerajaan.', 'https://joglosemar.id/wp-content/uploads/2024/05/Tugu-Yogyakarta-2-1024x576.jpeg'),
(7, 'Sulawesi Selatan', 'sulawesi-selatan', 'Budaya Bugis-Makassar dan keindahan alam bawah laut.', 'https://images.unsplash.com/photo-1518548419970-58e3b4079ab2?w=600&q=80'),
(8, 'Sumatera Barat', 'sumatera-barat', 'Ranah Minang dengan kuliner dan budaya yang unik.', 'https://img.bdhigh.com/img/1200/bhi890wxbhpmle62na/L7QFRXo0C6OKXfd5L7yLkpxe5iZQtm4RxME9UQHrLNKw.jpg'),
(9, 'Kalimantan Timur', 'kalimantan-timur', 'Hutan tropis dan budaya Dayak yang otentik.', 'https://img.inews.co.id/media/1200/files/inews_new/2021/10/15/jembatan_sungai_mahakam.jpg'),
(10, 'Nusa Tenggara Timur', 'nusa-tenggara-timur', 'Rumah Komodo dan pantai-pantai eksotis.', 'https://indonesiajuara.asia/wp-content/uploads/2024/05/Ekowisata-di-Desa-Waerebo.webp');

-- --------------------------------------------------------

--
-- Struktur dari tabel `regions`
--

CREATE TABLE `regions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `province_id` bigint(20) UNSIGNED DEFAULT NULL,
  `slug` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `regions`
--

INSERT INTO `regions` (`id`, `name`, `province_id`, `slug`, `description`) VALUES
(1, 'Kota Malang', 1, 'kota-malang', NULL),
(2, 'Kota Batu', 1, 'kota-batu', NULL),
(3, 'Kab. Malang', 1, 'kabupaten-malang', NULL),
(4, 'Kota Surabaya', 1, 'kota-surabaya', 'Kota pahlawan, metropolis terbesar kedua Indonesia.'),
(5, 'Kabupaten Badung', 2, 'kabupaten-badung', 'Wilayah Kuta, Seminyak, dan Nusa Dua.'),
(6, 'Kabupaten Gianyar', 2, 'kabupaten-gianyar', 'Ubud - pusat seni dan budaya Bali.'),
(7, 'Jakarta Pusat', 3, 'jakarta-pusat', 'Jantung ibukota dengan Monas dan Kota Tua.'),
(8, 'Kota Yogyakarta', 6, 'kota-yogyakarta', 'Keraton, Malioboro, dan wisata budaya Jogja.'),
(9, 'Kota Denpasar', 2, 'kota-denpasar', 'Ibukota Bali, pusat bisnis dan budaya.'),
(10, 'Kabupaten Badung', 2, 'kabupaten-badung', 'Kuta, Seminyak, Nusa Dua — jantung pariwisata Bali.'),
(11, 'Kabupaten Gianyar', 2, 'kabupaten-gianyar', 'Ubud, pusat seni dan budaya Bali.'),
(12, 'Kabupaten Klungkung', 2, 'kabupaten-klungkung', 'Nusa Penida, surga tersembunyi di Bali.'),
(13, 'Jakarta Pusat', 3, 'jakarta-pusat', 'Monas, Kota Tua, dan pusat pemerintahan.'),
(14, 'Jakarta Selatan', 3, 'jakarta-selatan', 'Kawasan kuliner dan hiburan modern Jakarta.'),
(15, 'Jakarta Utara', 3, 'jakarta-utara', 'Kepulauan Seribu dan kawasan pelabuhan.'),
(16, 'Kota Yogyakarta', 6, 'kota-yogyakarta', 'Keraton, Malioboro, pusat budaya Jawa.'),
(17, 'Kabupaten Sleman', 6, 'kabupaten-sleman', 'Borobudur area, Merapi, dan kampus.'),
(18, 'Kabupaten Bantul', 6, 'kabupaten-bantul', 'Pantai Parangtritis dan kerajinan Kasongan.'),
(19, 'Kota Bandung', 5, 'kota-bandung', 'Paris van Java, kota kuliner dan fashion.'),
(20, 'Kabupaten Bandung', 5, 'kabupaten-bandung', 'Kawah Putih, Ciwidey, dan alam pegunungan.'),
(21, 'Kota Makassar', 7, 'kota-makassar', 'Kota Daeng, gerbang wisata Indonesia Timur.'),
(22, 'Kabupaten Toraja Utara', 7, 'kabupaten-toraja', 'Tanah Toraja, budaya dan alam unik.'),
(23, 'Kota Padang', 8, 'kota-padang', 'Kota Padang, kuliner Minang dan pantai.'),
(24, 'Kota Semarang', 4, 'kota-semarang', 'Ibukota Jawa Tengah dengan arsitektur kolonial dan kuliner khas.'),
(25, 'Kabupaten Magelang', 4, 'kabupaten-magelang', 'Rumah Candi Borobudur dan panorama Gunung Merapi.'),
(26, 'Kota Solo', 4, 'kota-solo', 'Kota batik dan budaya Jawa yang kental, saudara kembar Yogyakarta.'),
(27, 'Kabupaten Karanganyar', 4, 'kabupaten-karanganyar', 'Candi Cetho, Candi Sukuh, dan perkebunan teh Kemuning.'),
(28, 'Kota Balikpapan', 9, 'kota-balikpapan', 'Kota minyak Kalimantan, gerbang wisata Kalimantan Timur.'),
(29, 'Kota Samarinda', 9, 'kota-samarinda', 'Ibukota Kalimantan Timur di tepi Sungai Mahakam.'),
(30, 'Kabupaten Berau', 9, 'kabupaten-berau', 'Kepulauan Derawan, surga bawah laut Kalimantan.'),
(31, 'Kabupaten Manggarai Barat', 10, 'kabupaten-manggarai-barat', 'Labuan Bajo, gerbang menuju Komodo National Park.'),
(32, 'Kabupaten Manggarai', 10, 'kabupaten-manggarai', 'Flores tengah dengan budaya Manggarai yang kaya.'),
(33, 'Kota Kupang', 10, 'kota-kupang', 'Ibukota NTT dengan budaya Timor yang unik.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `reviews`
--

CREATE TABLE `reviews` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `rating` tinyint(3) UNSIGNED NOT NULL CHECK (`rating` between 1 and 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `reviews`
--

INSERT INTO `reviews` (`id`, `place_id`, `user_id`, `rating`, `comment`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(3, 3, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(4, 4, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(5, 5, 4, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(6, 6, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(7, 7, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(8, 8, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(9, 9, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(10, 10, 4, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(11, 11, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(12, 12, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(13, 13, 4, 2, 'Pelayanan kurang ramah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(14, 14, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(15, 15, 4, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(16, 16, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(17, 17, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(18, 18, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(19, 19, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(20, 20, 4, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(21, 21, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(22, 22, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(23, 23, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(24, 24, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(25, 25, 4, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(26, 26, 4, 2, 'Pelayanan kurang ramah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(27, 27, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(28, 28, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(29, 29, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(30, 30, 4, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(31, 31, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(32, 32, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(33, 33, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(34, 34, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(35, 35, 4, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(36, 36, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(37, 37, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(38, 38, 4, 5, 'Tempat yang sangat luar biasa! Sangat merekomendasikan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(39, 39, 4, 2, 'Pelayanan kurang ramah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(40, 40, 4, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(64, 1, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(66, 3, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(67, 4, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(68, 5, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(69, 6, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(70, 7, 5, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(71, 8, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(72, 9, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(73, 10, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(74, 11, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(75, 12, 5, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(76, 13, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(77, 14, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(78, 15, 5, 2, 'Pelayanan kurang ramah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(79, 16, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(80, 17, 5, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(81, 18, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(82, 19, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(83, 20, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(84, 21, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(85, 22, 5, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(86, 23, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(87, 24, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(88, 25, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(89, 26, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(90, 27, 5, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(91, 28, 5, 2, 'Pelayanan kurang ramah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(92, 29, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(93, 30, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(94, 31, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(95, 32, 5, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(96, 33, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(97, 34, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(98, 35, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(99, 36, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(100, 37, 5, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(101, 38, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(102, 39, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(103, 40, 5, 4, 'Fasilitas cukup lengkap, tapi parkiran agak penuh.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(127, 1, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(129, 3, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(130, 4, 6, 2, 'Pelayanan kurang ramah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(131, 5, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(132, 6, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(133, 7, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(134, 8, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(135, 9, 6, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(136, 10, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(137, 11, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(138, 12, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(139, 13, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(140, 14, 6, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(141, 15, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(142, 16, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(143, 17, 6, 2, 'Pelayanan kurang ramah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(144, 18, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(145, 19, 6, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(146, 20, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(147, 21, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(148, 22, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(149, 23, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(150, 24, 6, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(151, 25, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(152, 26, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(153, 27, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(154, 28, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(155, 29, 6, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(156, 30, 6, 2, 'Pelayanan kurang ramah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(157, 31, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(158, 32, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(159, 33, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(160, 34, 6, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(161, 35, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(162, 36, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(163, 37, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(164, 38, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(165, 39, 6, 3, 'Biasa saja, perlu perbaikan kebersihan.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(166, 40, 6, 5, 'Pemandangan indah dan makanan enak. Pasti kembali lagi.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(190, 1, 9, 5, 'Bagus banget buat foto-foto, warnanya cerah!', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(191, 1, 10, 4, 'Tiket masuk murah, warga ramah, tapi tangga agak curam.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(192, 1, 11, 5, 'Spot instagramable terbaik di Malang.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(193, 1, 12, 3, 'Panas banget kalau siang, saran datang sore.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(194, 1, 13, 4, 'Unik, kampungnya bersih.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(195, 13, 14, 5, 'Sensasi makan bakso ada kereta lewat itu gokil abis!', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(196, 13, 15, 5, 'Kuahnya gurih, bakso bakarnya juara dunia.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(197, 13, 16, 4, 'Enak tapi antriannya panjang banget pas weekend.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(198, 13, 17, 5, 'Legend! Wajib coba kalau ke Malang.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(199, 21, 18, 5, 'Hotel paling estetik, serasa tidur di museum tapi mewah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(200, 21, 19, 5, 'Pelayanan kelas satu, sarapannya enak banget.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(201, 21, 20, 4, 'Suasananya agak mistis tapi artistik.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(202, 11, 21, 5, 'Es krimnya klasik, rasanya ga berubah dari dulu.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(203, 11, 22, 3, 'Harga agak mahal untuk porsi yang standar.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(204, 11, 23, 4, 'Tempat nostalgia jaman Belanda.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(205, 31, 24, 5, 'Oleh-oleh wajib, varian apel paling enak.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(206, 31, 25, 4, 'Rasa enak, tapi rotinya agak keras kalau sudah 2 hari.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(207, 31, 26, 5, 'Banyak promo, pelayanan cepat.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(208, 4, 27, 5, 'Alun-alun Tugu sangat cantik saat malam hari dengan lampu-lampunya.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(209, 8, 28, 4, 'Kayutangan vibesnya kayak di Malioboro tapi versi Malang.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(210, 15, 29, 5, 'Lumpia Hok Lay sausnya tiada dua!', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(211, 24, 30, 5, 'Hotel Harris kolam renangnya luas, anak-anak suka.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(212, 30, 9, 5, 'Grand Mercure hotel baru yang sangat mewah.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(213, 12, 10, 4, 'Rawonnya dagingnya empuk banget.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(214, 19, 11, 5, 'Bakso bakar Trowulan pedesnya nampol!', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(216, 5, 13, 3, 'Alun-alun merdeka ramai banget, susah parkir.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(217, 33, 14, 5, 'Lapis Malang lembut banget, cocok buat oleh-oleh mertua.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(218, 36, 15, 4, 'Kue gaya baru, rasa klasik yang ngangenin.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(219, 22, 16, 5, 'Atria hotel lokasinya strategis di tengah kota.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(220, 18, 17, 4, 'Sate gebug rasanya unik, dagingnya dipukul sampai empuk.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(221, 40, 18, 5, 'Roti Avia rasanya otentik jaman dulu.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(222, 35, 19, 4, 'Goedang oleh-oleh lengkap banget, one stop shopping.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(223, 25, 20, 4, 'Swiss Belinn nyaman, dekat mall MX dan Matos.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(224, 6, 21, 5, 'Museum Brawijaya sangat edukatif untuk anak-anak.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(225, 16, 22, 4, 'Makan di Inggil sambil liat koleksi topeng, unik.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(226, 3, 23, 5, 'Kampung Biru Arema biru semua! Salam satu jiwa.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(227, 29, 24, 4, 'Ibis styles desainnya pop art keren.', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(228, 1, 36, 5, 'database', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(229, 1, 38, 5, 'bla bla bal', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(230, 3, 35, 5, 'bla bla bla', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(231, 21, 40, 5, 'bla bla bla', '2026-05-07 10:30:41', '2026-05-07 10:30:41'),
(232, 21, 40, 5, 'wadmsdsa', '2026-05-07 10:30:41', '2026-05-07 10:30:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `name`) VALUES
(1, 'Super Admin'),
(2, 'Place Admin'),
(3, 'User');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rooms`
--

CREATE TABLE `rooms` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `place_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price_per_night` decimal(15,2) NOT NULL,
  `max_guests` tinyint(3) UNSIGNED DEFAULT 2,
  `image_url` varchar(255) DEFAULT NULL,
  `is_available` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rooms`
--

INSERT INTO `rooms` (`id`, `place_id`, `name`, `description`, `price_per_night`, `max_guests`, `image_url`, `is_available`, `created_at`, `updated_at`) VALUES
(1, 21, 'Standard Room', 'Kamar nyaman dengan fasilitas lengkap dan pemandangan taman.', 1500000.00, 2, NULL, 1, '2026-05-24 06:04:38', '2026-05-24 06:04:38'),
(2, 21, 'Deluxe Room', 'Kamar luas dengan dekorasi antik khas Hotel Tugu dan bathtub.', 2500000.00, 2, NULL, 1, '2026-05-24 06:04:38', '2026-05-24 06:04:38'),
(3, 21, 'Junior Suite', 'Suite mewah dengan ruang duduk terpisah dan koleksi seni eksklusif.', 4000000.00, 3, NULL, 1, '2026-05-24 06:04:38', '2026-05-24 06:04:38'),
(4, 21, 'Presidential Suite', 'Suite terluas dengan balkon pribadi dan fasilitas butler service.', 8000000.00, 4, NULL, 1, '2026-05-24 06:04:38', '2026-05-24 06:04:38'),
(5, 105, 'Garden Pool Villa', 'Villa dengan private pool di tengah kebun tropis.', 12000000.00, 2, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(6, 105, 'River Suite', 'Suite premium menghadap Sungai Ayung.', 18000000.00, 2, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(7, 106, 'Mulia Suite', 'Suite mewah dengan panorama pantai Nusa Dua.', 7000000.00, 2, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(8, 106, 'Mulia Villa', 'Villa eksklusif dengan butler service dan private pool.', 15000000.00, 4, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(9, 203, 'Deluxe Room', 'Kamar mewah dengan pemandangan Bundaran HI.', 3500000.00, 2, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(10, 203, 'Grand Deluxe Suite', 'Suite luas dengan ruang tamu terpisah.', 6500000.00, 3, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(11, 305, 'Superior Room', 'Kamar nyaman dengan dekorasi batik Jawa.', 1800000.00, 2, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(12, 305, 'Ambarrukmo Suite', 'Suite prestisius terinspirasi keraton Yogyakarta.', 4500000.00, 3, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(13, 403, 'Deluxe City View', 'Kamar deluxe dengan pemandangan panorama Kota Bandung.', 2500000.00, 2, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(14, 403, 'Executive Suite', 'Suite eksklusif dengan jacuzzi dan lounge akses.', 5000000.00, 3, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(15, 702, 'Deluxe Room', 'Kamar luas dengan pemandangan kota Surabaya.', 2000000.00, 2, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(16, 702, 'Executive Room', 'Kamar eksekutif dengan akses Executive Lounge.', 3200000.00, 2, NULL, 1, '2026-06-02 10:24:55', '2026-06-02 10:24:55'),
(17, 904, 'Superior Room', 'Kamar nyaman dengan pemandangan kota Semarang.', 1200000.00, 2, NULL, 1, '2026-06-02 10:30:15', '2026-06-02 10:30:15'),
(18, 904, 'Deluxe Suite', 'Suite luas dengan panorama 360 derajat.', 2500000.00, 3, NULL, 1, '2026-06-02 10:30:15', '2026-06-02 10:30:15'),
(19, 911, 'Deluxe Room', 'Kamar deluxe bergaya Jawa dengan batik premium.', 1500000.00, 2, NULL, 1, '2026-06-02 10:30:15', '2026-06-02 10:30:15'),
(20, 911, 'Junior Suite', 'Suite dengan ruang tamu terpisah dan sofa bed.', 2800000.00, 3, NULL, 1, '2026-06-02 10:30:15', '2026-06-02 10:30:15'),
(21, 1003, 'Deluxe Room', 'Kamar modern dengan pemandangan kota Balikpapan.', 1200000.00, 2, NULL, 1, '2026-06-02 10:41:48', '2026-06-02 10:41:48'),
(22, 1003, 'Superior Suite', 'Suite luas dengan sofa bed dan akses lounge.', 2200000.00, 3, NULL, 1, '2026-06-02 10:41:48', '2026-06-02 10:41:48'),
(23, 1008, 'Superior Room', 'Kamar nyaman di pusat kota Samarinda.', 900000.00, 2, NULL, 1, '2026-06-02 10:41:48', '2026-06-02 10:41:48'),
(24, 1008, 'Deluxe Room', 'Kamar deluxe dengan pemandangan kota dan Mahakam.', 1500000.00, 2, NULL, 1, '2026-06-02 10:41:48', '2026-06-02 10:41:48'),
(25, 1103, 'Waecicu Suite', 'Suite premium dengan private plunge pool dan sea view.', 7000000.00, 2, NULL, 1, '2026-06-02 10:41:48', '2026-06-02 10:41:48'),
(26, 1103, 'Ocean Villa', 'Villa mewah langsung menghadap Selat Sape.', 12000000.00, 4, NULL, 1, '2026-06-02 10:41:48', '2026-06-02 10:41:48'),
(27, 1104, 'Deluxe Sea View', 'Kamar dengan balkon menghadap perairan Komodo.', 3500000.00, 2, NULL, 1, '2026-06-02 10:41:48', '2026-06-02 10:41:48'),
(28, 1104, 'Water Cottage', 'Cottage di atas air dengan akses langsung ke laut.', 6500000.00, 2, NULL, 1, '2026-06-02 10:41:48', '2026-06-02 10:41:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `saved_itineraries`
--

CREATE TABLE `saved_itineraries` (
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `itinerary_id` bigint(20) UNSIGNED NOT NULL,
  `saved_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('i8rXZ8PmTFq8icynUwralPDfmfJfl0NOWuoK8Lc6', 51, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/153.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiU1YwUzBmbHo3ZnQ5VjFJeUI3ZG1VbGFlcHZEcTltRlRrcjJBRERScyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9ob21lIjtzOjU6InJvdXRlIjtzOjQ6ImhvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aTo1MTt9', 1789364836);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tags`
--

CREATE TABLE `tags` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(50) NOT NULL,
  `slug` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tags`
--

INSERT INTO `tags` (`id`, `name`, `slug`) VALUES
(1, 'Wisata Alam', 'wisata-alam'),
(2, 'Kuliner', 'kuliner'),
(3, 'Budget Hemat', 'budget-hemat'),
(4, 'Liburan Keluarga', 'liburan-keluarga'),
(5, 'Solo Traveling', 'solo-traveling'),
(6, 'Honeymoon', 'honeymoon'),
(7, 'Weekend Getaway', 'weekend-getaway'),
(8, 'Heritage & Budaya', 'heritage-budaya'),
(9, 'Adventure', 'adventure'),
(10, 'Instagramable', 'instagramable');

-- --------------------------------------------------------

--
-- Struktur dari tabel `trains`
--

CREATE TABLE `trains` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `train_number` varchar(10) NOT NULL,
  `class` enum('Eksekutif','Bisnis','Ekonomi') DEFAULT 'Eksekutif',
  `origin_id` bigint(20) UNSIGNED NOT NULL,
  `destination_id` bigint(20) UNSIGNED NOT NULL,
  `departure_time` time NOT NULL,
  `arrival_time` time NOT NULL,
  `duration_minutes` smallint(5) UNSIGNED NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `seats` smallint(5) UNSIGNED DEFAULT 100,
  `days_of_week` varchar(20) DEFAULT 'daily',
  `is_active` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `trains`
--

INSERT INTO `trains` (`id`, `name`, `train_number`, `class`, `origin_id`, `destination_id`, `departure_time`, `arrival_time`, `duration_minutes`, `price`, `seats`, `days_of_week`, `is_active`) VALUES
(1, 'Argo Bromo Anggrek', '1', 'Eksekutif', 1, 7, '09:00:00', '18:00:00', 540, 500000.00, 100, 'daily', 1),
(2, 'Argo Bromo Anggrek', '2', 'Eksekutif', 7, 1, '08:00:00', '17:00:00', 540, 500000.00, 100, 'daily', 1),
(3, 'Gajayana', '67', 'Eksekutif', 1, 8, '17:30:00', '05:30:00', 720, 450000.00, 100, 'daily', 1),
(4, 'Gajayana', '68', 'Eksekutif', 8, 1, '17:00:00', '05:00:00', 720, 450000.00, 100, 'daily', 1),
(5, 'Taksaka', '71', 'Eksekutif', 1, 4, '08:00:00', '13:30:00', 330, 350000.00, 100, 'daily', 1),
(6, 'Taksaka', '72', 'Eksekutif', 4, 1, '13:00:00', '18:30:00', 330, 350000.00, 100, 'daily', 1),
(7, 'Argo Wilis', '5', 'Eksekutif', 2, 4, '07:00:00', '14:10:00', 430, 380000.00, 100, 'daily', 1),
(8, 'Argo Wilis', '6', 'Eksekutif', 4, 2, '14:30:00', '21:40:00', 430, 380000.00, 100, 'daily', 1),
(9, 'Sancaka', '87', 'Bisnis', 4, 7, '08:00:00', '11:00:00', 180, 150000.00, 100, 'daily', 1),
(10, 'Sancaka', '88', 'Bisnis', 7, 4, '12:00:00', '15:00:00', 180, 150000.00, 100, 'daily', 1),
(11, 'Logawa', '89', 'Ekonomi', 2, 8, '07:00:00', '17:00:00', 600, 75000.00, 100, 'daily', 1),
(12, 'Mataram', '190', 'Bisnis', 1, 7, '20:00:00', '05:30:00', 570, 280000.00, 100, 'daily', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `train_bookings`
--

CREATE TABLE `train_bookings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `train_id` bigint(20) UNSIGNED NOT NULL,
  `travel_date` date NOT NULL,
  `passengers` tinyint(3) UNSIGNED DEFAULT 1,
  `total_price` decimal(15,2) NOT NULL,
  `passenger_name` varchar(255) NOT NULL,
  `passenger_id_number` varchar(50) NOT NULL,
  `contact_phone` varchar(20) NOT NULL,
  `status` enum('pending','confirmed','cancelled') DEFAULT 'pending',
  `booking_code` varchar(20) NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `train_bookings`
--

INSERT INTO `train_bookings` (`id`, `user_id`, `train_id`, `travel_date`, `passengers`, `total_price`, `passenger_name`, `passenger_id_number`, `contact_phone`, `status`, `booking_code`, `created_at`, `updated_at`) VALUES
(1, 35, 3, '2026-05-24', 1, 450000.00, 'test', '123456789123123123', '12312312313', 'pending', 'TRN-20260001', '2026-05-24 11:16:57', '2026-05-24 11:16:57'),
(2, 35, 3, '2026-05-25', 1, 450000.00, 'test', '12321431413321', '3213412324123', 'pending', 'TRN-202660002', '2026-05-24 22:09:12', '2026-05-24 22:09:12'),
(3, 35, 3, '2026-06-03', 2, 900000.00, 'testetets', '12312312413', '213124312', 'pending', 'TRN-202660003', '2026-06-03 03:25:22', '2026-06-03 03:25:22'),
(4, 47, 3, '2026-06-06', 2, 900000.00, 'asdfghjkl', '12371982483901', '912839102312', 'pending', 'TRN-202660004', '2026-06-04 03:36:42', '2026-06-04 03:36:42'),
(5, 48, 3, '2026-06-06', 2, 900000.00, 'poiuytrewq', '12371982483901', '821380192312123', 'pending', 'TRN-202660005', '2026-06-04 03:45:59', '2026-06-04 03:45:59'),
(6, 35, 3, '2026-06-08', 1, 450000.00, 'test', '123456789123123123', '12312312313', 'pending', 'TRN-202660006', '2026-06-06 23:38:13', '2026-06-06 23:38:13'),
(7, 35, 3, '2026-06-07', 2, 900000.00, 'test', '123456789123123123', '12312312313', 'pending', 'TRN-202660007', '2026-06-07 00:20:37', '2026-06-07 00:20:37'),
(8, 50, 3, '2026-06-09', 2, 900000.00, 'Jandiwansd', '23817390213901231', '120938102931321', 'pending', 'TRN-202660008', '2026-06-07 00:41:49', '2026-06-07 00:41:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `train_stations`
--

CREATE TABLE `train_stations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `code` varchar(5) NOT NULL,
  `name` varchar(150) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `train_stations`
--

INSERT INTO `train_stations` (`id`, `code`, `name`, `city`, `province_id`) VALUES
(1, 'GMR', 'Gambir', 'Jakarta', 3),
(2, 'PSE', 'Pasar Senen', 'Jakarta', 3),
(3, 'BD', 'Bandung', 'Bandung', 5),
(4, 'YK', 'Yogyakarta', 'Yogyakarta', 6),
(5, 'SLO', 'Solo Balapan', 'Solo', 4),
(6, 'SMT', 'Semarang Tawang', 'Semarang', 4),
(7, 'SBI', 'Surabaya Gubeng', 'Surabaya', 1),
(8, 'ML', 'Malang', 'Malang', 1),
(9, 'KTA', 'Kutoarjo', 'Kutoarjo', 4);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `airlines`
--
ALTER TABLE `airlines`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `airports`
--
ALTER TABLE `airports`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indeks untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `room_id` (`room_id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `role_id` (`role_id`);

--
-- Indeks untuk tabel `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indeks untuk tabel `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_place_unique` (`user_id`,`place_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indeks untuk tabel `flights`
--
ALTER TABLE `flights`
  ADD PRIMARY KEY (`id`),
  ADD KEY `origin_id` (`origin_id`),
  ADD KEY `destination_id` (`destination_id`),
  ADD KEY `flights_airline_fk` (`airline_id`);

--
-- Indeks untuk tabel `flight_bookings`
--
ALTER TABLE `flight_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `flight_id` (`flight_id`);

--
-- Indeks untuk tabel `follows`
--
ALTER TABLE `follows`
  ADD PRIMARY KEY (`follower_id`,`following_id`),
  ADD KEY `follows_following_fk` (`following_id`);

--
-- Indeks untuk tabel `itinerary_comments`
--
ALTER TABLE `itinerary_comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itinerary_id` (`itinerary_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `itinerary_copies`
--
ALTER TABLE `itinerary_copies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_original` (`user_id`,`original_itinerary_id`),
  ADD KEY `copies_iti_fk` (`original_itinerary_id`);

--
-- Indeks untuk tabel `itinerary_days`
--
ALTER TABLE `itinerary_days`
  ADD PRIMARY KEY (`id`),
  ADD KEY `itinerary_id` (`itinerary_id`);

--
-- Indeks untuk tabel `itinerary_likes`
--
ALTER TABLE `itinerary_likes`
  ADD PRIMARY KEY (`user_id`,`itinerary_id`),
  ADD KEY `iti_likes_iti_fk` (`itinerary_id`);

--
-- Indeks untuk tabel `itinerary_posts`
--
ALTER TABLE `itinerary_posts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indeks untuk tabel `itinerary_stops`
--
ALTER TABLE `itinerary_stops`
  ADD PRIMARY KEY (`id`),
  ADD KEY `day_id` (`day_id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `stops_flight_fk` (`flight_booking_id`),
  ADD KEY `stops_hotel_fk` (`hotel_booking_id`),
  ADD KEY `stops_train_fk` (`train_booking_id`);

--
-- Indeks untuk tabel `itinerary_tags`
--
ALTER TABLE `itinerary_tags`
  ADD PRIMARY KEY (`itinerary_id`,`tag_id`),
  ADD KEY `iti_tags_tag_fk` (`tag_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `operating_hours`
--
ALTER TABLE `operating_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `places`
--
ALTER TABLE `places`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `region_id` (`region_id`);

--
-- Indeks untuk tabel `place_facilities`
--
ALTER TABLE `place_facilities`
  ADD PRIMARY KEY (`place_id`,`facility_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Indeks untuk tabel `provinces`
--
ALTER TABLE `provinces`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `regions`
--
ALTER TABLE `regions`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD PRIMARY KEY (`id`),
  ADD KEY `place_id` (`place_id`);

--
-- Indeks untuk tabel `saved_itineraries`
--
ALTER TABLE `saved_itineraries`
  ADD PRIMARY KEY (`user_id`,`itinerary_id`),
  ADD KEY `saved_iti_iti_fk` (`itinerary_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slug` (`slug`);

--
-- Indeks untuk tabel `trains`
--
ALTER TABLE `trains`
  ADD PRIMARY KEY (`id`),
  ADD KEY `trains_origin_fk` (`origin_id`),
  ADD KEY `trains_dest_fk` (`destination_id`);

--
-- Indeks untuk tabel `train_bookings`
--
ALTER TABLE `train_bookings`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `booking_code` (`booking_code`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `train_id` (`train_id`);

--
-- Indeks untuk tabel `train_stations`
--
ALTER TABLE `train_stations`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

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
-- AUTO_INCREMENT untuk tabel `airlines`
--
ALTER TABLE `airlines`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `airports`
--
ALTER TABLE `airports`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `bookings`
--
ALTER TABLE `bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `customer`
--
ALTER TABLE `customer`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `events`
--
ALTER TABLE `events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT untuk tabel `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT untuk tabel `flights`
--
ALTER TABLE `flights`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `flight_bookings`
--
ALTER TABLE `flight_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `itinerary_comments`
--
ALTER TABLE `itinerary_comments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `itinerary_copies`
--
ALTER TABLE `itinerary_copies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `itinerary_days`
--
ALTER TABLE `itinerary_days`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `itinerary_posts`
--
ALTER TABLE `itinerary_posts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `itinerary_stops`
--
ALTER TABLE `itinerary_stops`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `operating_hours`
--
ALTER TABLE `operating_hours`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=281;

--
-- AUTO_INCREMENT untuk tabel `places`
--
ALTER TABLE `places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1109;

--
-- AUTO_INCREMENT untuk tabel `provinces`
--
ALTER TABLE `provinces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `regions`
--
ALTER TABLE `regions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT untuk tabel `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `rooms`
--
ALTER TABLE `rooms`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT untuk tabel `tags`
--
ALTER TABLE `tags`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `trains`
--
ALTER TABLE `trains`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT untuk tabel `train_bookings`
--
ALTER TABLE `train_bookings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `train_stations`
--
ALTER TABLE `train_stations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bookings`
--
ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_place_fk` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_room_fk` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bookings_user_fk` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `favorites_ibfk_2` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `flights`
--
ALTER TABLE `flights`
  ADD CONSTRAINT `flights_airline_fk` FOREIGN KEY (`airline_id`) REFERENCES `airlines` (`id`),
  ADD CONSTRAINT `flights_dest_fk` FOREIGN KEY (`destination_id`) REFERENCES `airports` (`id`),
  ADD CONSTRAINT `flights_origin_fk` FOREIGN KEY (`origin_id`) REFERENCES `airports` (`id`);

--
-- Ketidakleluasaan untuk tabel `flight_bookings`
--
ALTER TABLE `flight_bookings`
  ADD CONSTRAINT `fb_flight_fk` FOREIGN KEY (`flight_id`) REFERENCES `flights` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fb_user_fk` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `follows`
--
ALTER TABLE `follows`
  ADD CONSTRAINT `follows_follower_fk` FOREIGN KEY (`follower_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `follows_following_fk` FOREIGN KEY (`following_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `itinerary_comments`
--
ALTER TABLE `itinerary_comments`
  ADD CONSTRAINT `iti_comments_iti_fk` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `iti_comments_user_fk` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `itinerary_copies`
--
ALTER TABLE `itinerary_copies`
  ADD CONSTRAINT `copies_iti_fk` FOREIGN KEY (`original_itinerary_id`) REFERENCES `itinerary_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `copies_user_fk` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `itinerary_days`
--
ALTER TABLE `itinerary_days`
  ADD CONSTRAINT `iti_days_post_fk` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary_posts` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `itinerary_likes`
--
ALTER TABLE `itinerary_likes`
  ADD CONSTRAINT `iti_likes_iti_fk` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `iti_likes_user_fk` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `itinerary_posts`
--
ALTER TABLE `itinerary_posts`
  ADD CONSTRAINT `iti_posts_region_fk` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `iti_posts_user_fk` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `itinerary_stops`
--
ALTER TABLE `itinerary_stops`
  ADD CONSTRAINT `iti_stops_day_fk` FOREIGN KEY (`day_id`) REFERENCES `itinerary_days` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `iti_stops_place_fk` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stops_flight_fk` FOREIGN KEY (`flight_booking_id`) REFERENCES `flight_bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stops_hotel_fk` FOREIGN KEY (`hotel_booking_id`) REFERENCES `bookings` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `stops_train_fk` FOREIGN KEY (`train_booking_id`) REFERENCES `train_bookings` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `itinerary_tags`
--
ALTER TABLE `itinerary_tags`
  ADD CONSTRAINT `iti_tags_iti_fk` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `iti_tags_tag_fk` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `operating_hours`
--
ALTER TABLE `operating_hours`
  ADD CONSTRAINT `operating_hours_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `places`
--
ALTER TABLE `places`
  ADD CONSTRAINT `places_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `places_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `place_facilities`
--
ALTER TABLE `place_facilities`
  ADD CONSTRAINT `place_facilities_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `place_facilities_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `rooms`
--
ALTER TABLE `rooms`
  ADD CONSTRAINT `rooms_place_fk` FOREIGN KEY (`place_id`) REFERENCES `places` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `saved_itineraries`
--
ALTER TABLE `saved_itineraries`
  ADD CONSTRAINT `saved_iti_iti_fk` FOREIGN KEY (`itinerary_id`) REFERENCES `itinerary_posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `saved_iti_user_fk` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `trains`
--
ALTER TABLE `trains`
  ADD CONSTRAINT `trains_dest_fk` FOREIGN KEY (`destination_id`) REFERENCES `train_stations` (`id`),
  ADD CONSTRAINT `trains_origin_fk` FOREIGN KEY (`origin_id`) REFERENCES `train_stations` (`id`);

--
-- Ketidakleluasaan untuk tabel `train_bookings`
--
ALTER TABLE `train_bookings`
  ADD CONSTRAINT `tb_train_fk` FOREIGN KEY (`train_id`) REFERENCES `trains` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tb_user_fk` FOREIGN KEY (`user_id`) REFERENCES `customer` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
