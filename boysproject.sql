-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 17, 2025 at 06:20 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `boysproject`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `security_code` varchar(8) DEFAULT NULL,
  `security_code_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `is_active`, `verified`, `password`, `remember_token`, `security_code`, `security_code_expires_at`, `created_at`, `updated_at`) VALUES
(1, 'eyJpdiI6InRlTDA0em5ORndCZWluWGZXVUsyelE9PSIsInZhbHVlIjoiT1pTQlg3QndGZG12Z1pEd25VSmdwSy9ucloxM2dyUzNtZ2NXSDNscGJOST0iLCJtYWMiOiI3YjdhZTY5NDViMGRjNTE1MDczNWNlYTQ4ZGFiMzcwYjI5YTQ2ZjE2NTI5Y2M5ZDZkOTlmNmIzZjRkY2I0MzRjIiwidGFnIjoiIn0=', 'eyJpdiI6ImFtYWFkQUFvZ29Gd0o5MDNCa0tyR3c9PSIsInZhbHVlIjoienAvV1hJV0RaemdqbU1jNUJJa0dQMEg1OER0NmNyYlRma3A2QUE4eldWdz0iLCJtYWMiOiI4OTU5MTIzMmRmYjg5YmI4Y2UwZTgzYmIyMjM0MDQ5MmMyM2Y5NTE3NzhkYzUwNGUzNTRjMjNhZmZkNzg2MGYzIiwidGFnIjoiIn0=', '2025-06-13 06:20:33', 1, 1, '$2y$12$chpFAnfS1xzKGMFu0vR.NeDhwOZU9JcqAgeIoEN0Mt/UIpgQykY1O', NULL, NULL, NULL, '2025-06-12 22:59:52', '2025-06-16 15:52:16'),
(4, 'eyJpdiI6InB5T1dCS1BKbzBDM1c0WW1Dc0xhdEE9PSIsInZhbHVlIjoiRG15V20rWlMyamxwTXVZN2NvTUk3UT09IiwibWFjIjoiZjJjZmQyODYxMDNiOGFiZjgxZmM0Y2FiZTI0M2Q2YmNlZjFjMGU3MTEzNjlmNWI5MDcyNTRmZDE0MjQ0NzAyNyIsInRhZyI6IiJ9', 'eyJpdiI6IkJ4a3Z2UUxTYlRnRjRhZGg0VTZzdHc9PSIsInZhbHVlIjoiRG5xS2ZqYVJudktOKzhwTUJIMHhHY0wwRUZXL3pOdGdaVVlmcnJnVkpsM2xERThlSFZDUjZaM3Y4RXk0T0d4TiIsIm1hYyI6ImQ5MDAyMzA0ZGViNDY1OWY2MzI0YzczNjViMjcxYzg4NGIyYjRjNzBlMGI5NjUyOGRiZTk5ZDA5OTFmMWVhNzAiLCJ0YWciOiIifQ==', NULL, 1, 0, '$2y$12$Il5rym7AWDaJfY4QN4adR.2.E6PfVJ.J0o.83cxoNIDg7fxaITBKi', NULL, NULL, NULL, '2025-06-16 07:30:04', '2025-06-16 07:30:04'),
(5, 'eyJpdiI6IndSWHpFU3g0ZHRBUG5oYTQ4b2YyOVE9PSIsInZhbHVlIjoicW1YaUhNSUxHUTZidE5UR0tRUGkvQT09IiwibWFjIjoiYzliNWM1YzBjYjQ1ZmE1NzRhOThiOGVlMDM5NzUzNGM4YjJjMWMyYmIwNmJkYzU0NDcxYTc3ZjNjYjZhNjgyMCIsInRhZyI6IiJ9', 'eyJpdiI6IlhhUlVUY3ExMGZsNWV2S1JlOEdKWGc9PSIsInZhbHVlIjoiVVp6K2cwaEU1MXJVdXZRdmFqYmxNbWU3ZXFmcjZEeVRRYmp2dWdGaHJDWmJINSs4K0p6SG13bE5IZ2FabldYYyIsIm1hYyI6IjM3ZmI3ODRmNWIzMWNiNGIwNWJkMTkxN2QwYzBkMDk5ZTYwOGRjZjEzNjlhZGFkNzQ2MGJkMWIxZmNkMThmNWYiLCJ0YWciOiIifQ==', NULL, 1, 1, '$2y$12$bFrN00U75q.pXGKVy9jGYuUq4rCuM0CuiwKAc3ocIROCSmQGLqOcu', NULL, '9A8E83ED', '2025-06-16 10:12:49', '2025-06-16 08:41:43', '2025-06-16 09:12:49');

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chatbot_auto_responses`
--

CREATE TABLE `chatbot_auto_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `keyword` varchar(255) NOT NULL,
  `response` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `priority` int(11) NOT NULL DEFAULT 0,
  `additional_keywords` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`additional_keywords`)),
  `match_type` enum('exact','contains','starts_with','ends_with') NOT NULL DEFAULT 'contains',
  `case_sensitive` tinyint(1) NOT NULL DEFAULT 0,
  `description` text DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `chatbot_auto_responses`
--

INSERT INTO `chatbot_auto_responses` (`id`, `keyword`, `response`, `is_active`, `priority`, `additional_keywords`, `match_type`, `case_sensitive`, `description`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'hai', 'Hai! 👋 Selamat datang di Boys Project! Kami siap membantu Anda dengan sparepart motor terbaik. Ada yang bisa kami bantu?', 1, 1, '[\"halo\",\"hello\",\"hi\",\"selamat\"]', 'contains', 0, 'Greeting response for customers', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(2, 'saya butuh bantuan', 'Tentu! 😊 Saya siap membantu Anda. Silakan pilih topik yang ingin Anda tanyakan atau ketik pertanyaan langsung.', 1, 1, '[\"bantuan\",\"help\",\"tolong\",\"butuh\"]', 'contains', 0, 'Help request response', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(3, 'harga', '💰 **INFORMASI HARGA** | Untuk info harga terbaru, silakan sebutkan produk yang Anda cari. Contoh: \"harga mounting aerox\" atau \"harga lampu LED\". Kami juga ada promo menarik lho! 🔥', 1, 1, '[\"price\",\"biaya\",\"cost\",\"berapa\"]', 'contains', 0, 'Price inquiry response', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(4, 'info kontak', '📞 **KONTAK KAMI** | WhatsApp: 08211990442 | Jam operasional: Senin-Jumat 08:00-17:00, Sabtu-Minggu 10:00-16:00 | Lokasi: Cimahi, Bandung | Siap melayani Anda! 😊', 1, 1, '[\"kontak\",\"contact\",\"telepon\",\"whatsapp\",\"alamat\"]', 'contains', 0, 'Contact information response', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(5, 'jam operasional', '⏰ **JAM OPERASIONAL** | Senin - Jumat: 08:00 - 17:00 WIB | Sabtu - Minggu: 10:00 - 16:00 WIB | Untuk respon cepat, hubungi WhatsApp kami di 08211990442! 📱', 1, 2, '[\"jam\",\"buka\",\"tutup\",\"operasional\",\"waktu\"]', 'contains', 0, 'Operating hours information', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(6, 'stok', '📦 **CEK STOK** | Untuk mengecek ketersediaan stok, sebutkan produk yang Anda cari. Contoh: \"stok mounting vario\" atau \"ada lampu projector?\". Stok kami update real-time! ✅', 1, 1, '[\"stock\",\"tersedia\",\"ada\",\"ready\",\"available\"]', 'contains', 0, 'Stock availability inquiry', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(7, 'produk apa saja', '🛍️ **PRODUK KAMI** | 💡 Lampu & LED | 🏍️ Mounting & Body Kit | ⚙️ Aksesoris Motor | 🔧 Jasa Pemasangan | Semua produk berkualitas tinggi dengan garansi! Mau lihat yang mana?', 1, 2, '[\"produk\",\"katalog\",\"jual\",\"kategori\"]', 'contains', 0, 'Product catalog information', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(8, 'mounting', '🏍️ **MOUNTING & BODY KIT** | Tersedia mounting carbon untuk berbagai motor matic. Harga mulai Rp 450.000. Presisi tinggi, mudah pasang, garansi kualitas! Mau tanya untuk motor apa?', 1, 2, '[\"mounting\",\"body kit\",\"carbon\"]', 'contains', 0, 'Mounting and body kit information', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(9, 'lampu', '💡 **LAMPU & LED** | LED headlamp, projector, lampu sein tersedia! Harga mulai Rp 350.000. Terang, hemat listrik, tahan lama. Cocok untuk motor matic dan sport!', 1, 2, '[\"led\",\"projector\",\"headlamp\",\"sein\"]', 'contains', 0, 'Lighting products information', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(10, 'pemasangan', '🔧 **JASA PEMASANGAN** | Mounting: Rp 50.000 | Body kit: Rp 100.000 | Lampu: Rp 75.000 | Home service +Rp 30.000 | Teknisi berpengalaman, hasil rapi! 👨‍🔧', 1, 2, '[\"pasang\",\"install\",\"service\",\"teknisi\"]', 'contains', 0, 'Installation service information', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(11, 'pengiriman', '🚚 **PENGIRIMAN** | Bandung-Cimahi: GRATIS ongkir! | Luar kota: Rp 15.000-25.000 | Same day delivery: +Rp 10.000 | COD tersedia area Bandung | Aman & cepat sampai! 📦', 1, 2, '[\"kirim\",\"ongkir\",\"cod\",\"delivery\",\"ekspedisi\"]', 'contains', 0, 'Shipping and delivery information', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(12, 'promo', '🎉 **PROMO TERBARU** | Bundling mounting + lampu diskon 15%! | Flash sale Jumat 19:00 | Member discount 10% | Follow IG @boyprojects untuk update promo! Ada yang mau ditanya? 🔥', 1, 2, '[\"diskon\",\"sale\",\"discount\",\"murah\"]', 'contains', 0, 'Promotional offers information', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52'),
(13, 'terima kasih', 'Sama-sama! 😊 Senang bisa membantu Anda. Jika ada pertanyaan lain, jangan ragu untuk bertanya ya! Boys Project siap melayani kebutuhan motor Anda! 🏍️✨', 1, 3, '[\"thanks\",\"makasih\",\"terimakasih\"]', 'contains', 0, 'Thank you response', NULL, NULL, '2025-06-12 23:19:52', '2025-06-12 23:19:52');

-- --------------------------------------------------------

--
-- Table structure for table `chat_conversations`
--

CREATE TABLE `chat_conversations` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) DEFAULT NULL,
  `status` enum('active','resolved','closed') NOT NULL DEFAULT 'active',
  `priority` enum('low','normal','high','urgent') NOT NULL DEFAULT 'normal',
  `initial_message` text DEFAULT NULL,
  `has_predefined_answer` tinyint(1) NOT NULL DEFAULT 0,
  `last_message_at` timestamp NULL DEFAULT NULL,
  `customer_acknowledged_recording` tinyint(1) NOT NULL DEFAULT 0,
  `session_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`session_data`)),
  `resolved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `resolved_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chat_messages`
--

CREATE TABLE `chat_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversation_id` bigint(20) UNSIGNED NOT NULL,
  `sender_type` enum('customer','admin') NOT NULL,
  `sender_id` bigint(20) UNSIGNED DEFAULT NULL,
  `message_content` text NOT NULL,
  `message_type` enum('text','image','file','system') NOT NULL DEFAULT 'text',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED DEFAULT NULL,
  `content_key` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'new',
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `is_important` tinyint(1) NOT NULL DEFAULT 0,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'general',
  `last_update_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `customer_id`, `admin_id`, `content_key`, `content`, `status`, `is_read`, `is_important`, `is_deleted`, `deleted_at`, `category`, `last_update_time`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'warranty', 'Saya mau klaim garansi', 'in_progress', 1, 0, 0, NULL, 'warranty', '2025-06-15 07:21:13', '2025-06-15 07:20:33', '2025-06-15 07:21:13'),
(2, 2, NULL, 'installation', 'Work Timings\r\nSenin - Jumat : 08:00 - 17:00\r\nSabtu - Minggu : 10:00 - 16:00', 'new', 1, 0, 0, NULL, 'installation', '2025-06-16 07:25:54', '2025-06-16 07:25:54', '2025-06-16 07:26:21'),
(3, 3, NULL, 'general', 'Work Timings\r\nSenin - Jumat : 08:00 - 17:00\r\nSabtu - Minggu : 10:00 - 16:00', 'new', 1, 0, 0, NULL, 'general', '2025-06-16 08:48:27', '2025-06-16 08:48:27', '2025-06-16 10:04:15'),
(4, 4, 1, 'warranty', 'contact_messages contact_messages contact_messages', 'in_progress', 1, 0, 0, NULL, 'warranty', '2025-06-16 16:08:02', '2025-06-16 10:04:56', '2025-06-16 16:08:02'),
(5, 5, 1, 'installation', 'Work Timings\r\nSenin - Jumat : 08:00 - 17:00\r\nSabtu - Minggu : 10:00 - 16:00', 'in_progress', 1, 0, 0, NULL, 'installation', '2025-06-16 15:34:19', '2025-06-16 15:33:12', '2025-06-16 15:34:19');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `phone` text DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'eyJpdiI6Im13RWRlR01hTzBPdEY4Z3RHV0QxVmc9PSIsInZhbHVlIjoiMjlNamVGTlBWNGRacEh2MXU0TlVSQT09IiwibWFjIjoiZTI3OWFjM2VlMjU3NGVjMzhkNDNiOTQxYWE1MTNlZmRkNTY2YjUxYjJlMTNlMTJjMTI0MDcxYzFjZDU4YzVmOSIsInRhZyI6IiJ9', 'eyJpdiI6IksxWlVudEZocWpoZXNQV0tUZTZBbkE9PSIsInZhbHVlIjoiWGVaMEdOWHlSV3pzTVRjOTVRQjBoS0I1OVZSbmx0NWVZalJDZEUzMTZ0S1dDVUk0a3YxYWJYN1BEZGlBaHpBaCIsIm1hYyI6ImUwZGRkYzg3Y2IyZjYzZDk2YTU0Nzc3MTYxZTVkZjdhNmU5YmIzNDg4YmZhMGM3ODNiNmRjYmJlNjc3MDkyNDciLCJ0YWciOiIifQ==', NULL, NULL, '2025-06-15 07:20:33', '2025-06-15 07:20:33'),
(2, 'eyJpdiI6IkttRE1CNkxGWjBTS3pWcmxoQVBmL3c9PSIsInZhbHVlIjoiYXNZaUVFYk5idFF1cEdEdjdvbDN5UT09IiwibWFjIjoiNGE4NzZiNjE2ZWNhMmFlYWIwNWJmNWI5MWRhOGFlMTcwMjAwMzZiMTRhNzYyZWExZmFjN2ZhM2QxMzRhYTI0YiIsInRhZyI6IiJ9', 'eyJpdiI6Im9NK1hmSW9XL1dELzBPVTJHaXZUN2c9PSIsInZhbHVlIjoiWnAzeHpoSFQvQ1BpQ2lEWHJXWElSc1BFYjhSMUNWTDhhdnJ5NksvemQyQUVJQkpNS01RWDBha2RGdDlqeG9QeiIsIm1hYyI6IjRlYWZhMDBiMzc4N2RjNDAxYzRhOGMxYWYxMmUwNTkyOGJmMzE5NzRmNjZmNDhlOTFkZjU2ZDBlNTk5ODI2NzkiLCJ0YWciOiIifQ==', NULL, NULL, '2025-06-16 07:25:54', '2025-06-16 07:25:54'),
(3, 'eyJpdiI6IjkxWEFwcGpQbnZGbnFIUjJGcS85Z0E9PSIsInZhbHVlIjoiVTRYTFVxU2s1aW5MMVV2L2FXc1paZz09IiwibWFjIjoiOTk4YzhhM2ZhNjY0ODg4NDkyNTA4OTQ4MzdhNzEzNjU5NTM1OGQ1ZDZmMzBmNzFhYWI4NjQ2ZGNkMjdhMTMzNyIsInRhZyI6IiJ9', 'eyJpdiI6Im1lcVI0WDlzRzEvWDBqTEkvLzZMMHc9PSIsInZhbHVlIjoiVmVZUUkvWkVMWHc1S3JJLzdDZ2FsODBsOXJFamJtTFBhZCszTzhZZmJnTT0iLCJtYWMiOiJkMTUwOGI3OWEyYjM5MWMzNTAzZTI1YmZmNTM4YjBiNjE0OGI3MjI1NjVjMTA2ODVlYmZiNzcxZWNjM2M4YTNiIiwidGFnIjoiIn0=', NULL, NULL, '2025-06-16 08:48:27', '2025-06-16 08:48:27'),
(4, 'eyJpdiI6IkdDR01NalRjZzVRZVB5YVFvVWNsZ1E9PSIsInZhbHVlIjoieXFqcUpLdUkvaGZ3dWFFRGNpZFM5S29PSDJlckVZcHBYNHNRS21iMDFWaz0iLCJtYWMiOiJmNmQ0MzkxYTk0OThhZWM1NDZhMmJkOWIyYmMzZGFhMWEwYmRiMTYyODkxODBkMDhmMjllZDkyMWY1OTlkMjYyIiwidGFnIjoiIn0=', 'eyJpdiI6ImFielFRWDdkVXNpakJSS1o3bXQ2S1E9PSIsInZhbHVlIjoiWGFnQUpieHlOMWpGNXY3OFcxMCthMFhIRUJJK3V5WlRSR1RpWlhSNU5EYys2bTRieEIxUXF0MGoxSUhlV1NBWCIsIm1hYyI6IjkzODI3MjcxZjBjYjkxNjZjNDEzMDFmMTU2ZTQ1NmQzNWVlZjI2YTI4MTFmMTE2MzA3NWZjOThiMjZlYzI0YjYiLCJ0YWciOiIifQ==', NULL, NULL, '2025-06-16 10:04:56', '2025-06-16 10:04:56'),
(5, 'eyJpdiI6InpnaDNIdjhEemVZZWZBZU45SGtkR2c9PSIsInZhbHVlIjoianVmVllrb3Zmekp1UHl6NHFMa3h0Zz09IiwibWFjIjoiNzBkYjNmZGRhNGEwMjNlZmNkNDkzYTI1ODU5NDk4OTA1NjY3OGJlZTQwZTRjNDE2NjVmZTM3Y2UzZThmNTEyOCIsInRhZyI6IiJ9', 'eyJpdiI6IlR2K29DK3pHS1c1OW9ycS9aK2hLcnc9PSIsInZhbHVlIjoiOTNEU2hrTzRoYS9CdmZHMmVsSUoyanJTSzF5MmxlNUJnUFlTSjgvZzBvVVpkUXVUN2t4dHh2VCtIMC9SQ3JVbyIsIm1hYyI6ImUzMDJhNGRhY2Q5ODA1MTU0ZTI4NmRiZmZlYzEzZDNlZWVhOTQ5OWQ1ZGVlN2I3Yzg2NTIwZDUwMTM3Y2ZkYjAiLCJ0YWciOiIifQ==', NULL, NULL, '2025-06-16 15:33:12', '2025-06-16 15:33:12');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
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
-- Table structure for table `job_batches`
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
-- Table structure for table `landing_pages`
--

CREATE TABLE `landing_pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `hero_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `message_responses`
--

CREATE TABLE `message_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_message_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_responses`
--

INSERT INTO `message_responses` (`id`, `contact_message_id`, `admin_id`, `message`, `created_at`) VALUES
(1, 1, 1, 'Boleh ka, silahkan nomor transaksinya', '2025-06-15 07:21:13'),
(2, 4, 1, 'Reply to Rio Ardana PutraReply to Rio Ardana PutraReply to Rio Ardana PutraReply to Rio Ardana Putra', '2025-06-16 10:05:32'),
(3, 5, 1, 'Benar, jam kerja terebut', '2025-06-16 15:34:19'),
(6, 4, 1, 'Illuminate\\Mail\\Mailables\\Envelope::__construct(): Argument #1 ($from) must be of type Illuminate\\Mail\\Mailables\\Address|string|null, array given, called in C:\\Users\\rioar\\Documents\\K U L I A H\\Computing Project\\Project2\\boyzproject\\app\\Mail\\MessageReplyMail.php on line 47', '2025-06-16 16:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_03_20_create_customers_table', 1),
(5, '2024_03_21_000000_create_admins_table', 1),
(6, '2024_03_21_000000_create_sections_table', 1),
(7, '2024_03_21_000001_create_section_contents_table', 1),
(8, '2024_03_21_create_contact_messages_table', 1),
(9, '2024_03_21_create_predefined_messages_table', 1),
(10, '2024_03_22_add_is_read_to_contact_messages', 1),
(11, '2025_06_03_052802_add_security_code_to_admins_table', 1),
(12, '2025_06_04_054649_create_message_responses_table', 1),
(13, '2025_06_04_054905_remove_extra_data_from_contact_messages_table', 1),
(14, '2025_06_04_060348_remove_updated_at_from_message_responses', 1),
(15, '2025_06_04_060357_drop_users_table', 1),
(16, '2025_06_04_060852_update_admin_table_column_sizes', 1),
(17, '2025_06_04_061203_add_verified_column_to_admins_table', 1),
(18, '2025_06_04_062113_remove_department_and_permissions_from_admins_table', 1),
(19, '2025_06_05_055211_ensure_remember_token_in_admins_table', 1),
(20, '2025_06_05_123304_add_important_and_deleted_to_contact_messages_table', 1),
(21, '2025_06_05_141840_drop_unused_ecommerce_tables', 1),
(22, '2025_06_06_043752_create_products_table', 1),
(23, '2025_06_06_043801_create_product_options_table', 1),
(24, '2025_06_06_043809_create_product_option_values_table', 1),
(25, '2025_06_06_045538_update_products_tables_for_new_dataset', 1),
(26, '2025_06_06_050422_update_existing_contact_message_categories', 1),
(27, '2025_06_06_050429_update_existing_contact_message_categories', 1),
(28, '2025_06_07_030443_create_chat_conversations_table', 1),
(29, '2025_06_07_030457_create_chat_messages_table', 1),
(30, '2025_06_07_033915_update_chat_conversations_table_fix_fields', 1),
(31, '2025_06_11_115757_encrypt_admin_emails_existing_data', 1),
(32, '2025_06_11_122329_increase_admin_email_column_size', 1),
(33, '2025_06_11_122518_encrypt_existing_admin_emails', 1),
(34, '2025_06_11_123046_increase_admin_name_column_size', 1),
(35, '2025_06_11_123157_encrypt_existing_admin_names', 1),
(36, '2025_06_11_125222_increase_customer_columns_for_encryption', 1),
(37, '2025_06_11_125839_encrypt_existing_customer_data', 1),
(38, '2025_06_12_032150_create_chatbot_auto_responses_table', 1),
(39, '2025_06_12_032150_create_ml_responses_table', 1),
(40, '2025_06_16_112714_create_landing_pages_table', 2),
(41, '2025_06_16_181638_add_description_to_section_contents_table', 2),
(42, '2025_06_16_182201_create_notifications_table', 3),
(43, '2025_06_16_182321_create_admin_notifications_table', 3),
(44, '2025_06_16_223028_add_notification_fields_to_notifications_table', 4),
(45, '2025_01_15_120000_merge_notification_tables', 5);

-- --------------------------------------------------------

--
-- Table structure for table `ml_responses`
--

CREATE TABLE `ml_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `intent_key` varchar(255) NOT NULL,
  `response` text NOT NULL,
  `category` varchar(255) NOT NULL DEFAULT 'main_intent',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `usage_count` int(11) NOT NULL DEFAULT 0,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `auto_response_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ml_responses`
--

INSERT INTO `ml_responses` (`id`, `intent_key`, `response`, `category`, `is_active`, `usage_count`, `metadata`, `auto_response_id`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'harga', '💰 **INFORMASI HARGA** | Silakan sebutkan produk spesifik untuk info harga detail. Kami ada berbagai pilihan harga dan paket khusus!', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(2, 'stok_produk', '📦 **CEK STOK PRODUK** | Sebutkan produk yang ingin dicek stocknya. Kami update stok real-time!', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(3, 'kategori_lighting', '💡 **KATEGORI LIGHTING** | Tersedia berbagai jenis lampu dan aksesori lighting untuk motor matic Anda!', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(4, 'kategori_mounting_body', '🏍️ **KATEGORI MOUNTING & BODY** | Tersedia mounting dan body kit berkualitas untuk motor matic!', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(5, 'harga_harga_produk', '💰 **HARGA PRODUK SPESIFIK** | Harga mounting carbon: Rp 450.000-650.000, Body kit: Rp 800.000-1.200.000, Lampu LED: Rp 350.000-550.000, Projector: Rp 750.000-950.000. *Harga dapat berubah, konfirmasi via WhatsApp untuk harga terkini!', 'sub_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(6, 'harga_harga_promo', '🎉 **PROMO & DISKON TERKINI** | Saat ini ada promo bundling mounting + lampu diskon 15%! Flash sale setiap Jumat jam 19:00. Member discount 10%. Follow IG @motorparts_bandung untuk update promo terbaru! 🔥', 'sub_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(7, 'harga_harga_grosir', '🏪 **HARGA GROSIR & RESELLER** | Harga khusus reseller: diskon 20-30% untuk pembelian min 5 pcs. Sistem dropship tersedia. MOQ grosir: 10 pcs. Daftar jadi partner via WhatsApp untuk price list khusus! 💼', 'sub_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(8, 'harga_harga_ongkir', '🚚 **BIAYA PENGIRIMAN** | Bandung-Cimahi: GRATIS ongkir! Luar kota: Rp 15.000-25.000. Same day delivery +Rp 10.000. COD gratis area Bandung. Express overnight +Rp 20.000. Cek ongkir eksak via WhatsApp! 📦', 'sub_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(9, 'harga_harga_instalasi', '🔧 **BIAYA PEMASANGAN** | Jasa pasang mounting: Rp 50.000. Body kit install: Rp 100.000. Lampu setup: Rp 75.000. Home service +Rp 30.000. Weekend service normal rate. Paket install beli produk diskon 50%! ⚡', 'sub_intent', 1, 1, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:25:04'),
(10, 'stok_produk_stok_tersedia', '✅ **PRODUK READY STOCK** | Sebagian besar item ready stock! Mounting carbon, LED headlamp, body kit populer tersedia. Update stok real-time cek WhatsApp. Fast moving items selalu kami stock! 📦', 'sub_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(11, 'stok_produk_stok_habis', '⏳ **RESTOCK SCHEDULE** | Item sold out biasanya restock 2-3 hari kerja. Import item 1-2 minggu. Limited edition by request. Join waiting list untuk prioritas stock! Info restock via broadcast WhatsApp 📱', 'sub_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(12, 'stok_produk_stok_booking', '📝 **BOOKING & PRE-ORDER** | Bisa booking stock dengan DP 30%. Pre-order item khusus tersedia. Waiting list gratis! Notification otomatis saat stock ready. Booking berlaku 7 hari! 🎯', 'sub_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(13, 'motor_compatibility', '🏍️ **KOMPATIBILITAS MOTOR** | Produk tersedia untuk motor matic populer. Sebutkan tipe motor spesifik untuk cek compatibility. Custom fitting tersedia untuk motor langka! Konsultasi gratis via WhatsApp 💬', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(14, 'general_inquiry', '❓ **BANTUAN UMUM** | Silakan tanyakan hal spesifik tentang produk, harga, stok, atau pemasangan. Tim customer service kami siap membantu! WhatsApp aktif 09:00-17:00 WIB 📞', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(15, 'booking_pemasangan', '📅 **BOOKING PEMASANGAN** | Booking install bisa via WA/call. Jadwal weekday/weekend tersedia. Home service area Bandung +30rb. Estimasi 1-2 jam per produk. Konfirmasi H-1 sebelum install. Garansi pemasangan 6 bulan! 🔧', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(16, 'durasi_pengiriman', '🚚 **ESTIMASI PENGIRIMAN** | Same day delivery area Bandung (order sebelum 15:00). Luar kota 1-3 hari kerja via JNE/J&T. Gratis ongkir pembelian >500rb. Tracking number dikirim via WA. Barang dikemas bubble wrap + kardus! 📦', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(17, 'harga_produk', '💰 **DAFTAR HARGA PRODUK** | Mounting phone holder: Rp 75.000-150.000. Body kit Aerox: Rp 250.000-400.000. Lampu LED projector: Rp 180.000-350.000. DRL strip: Rp 120.000-200.000. Harga bervariasi sesuai kualitas dan merk! 🏷️', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(18, 'info_produk', 'ℹ️ **INFO PRODUK** | Spesialisasi aksesoris motor: Mounting phone holder, Body kit custom, Lampu LED/projector, DRL strip. Semua produk berkualitas tinggi dengan garansi. Katalog lengkap di website! 🛵', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(19, 'kontak_info', '📞 **KONTAK KAMI** | WhatsApp: 0812-3456-7890 | Telepon: (022) 1234-5678 | Email: info@boyzproject.com | Alamat: Jl. Contoh No.123, Bandung | Jam operasional: 08:00-17:00 WIB (Senin-Sabtu) 🏪', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(20, 'jam_operasional', '🕐 **JAM OPERASIONAL** | Senin-Jumat: 08:00-17:00 WIB | Sabtu: 08:00-15:00 WIB | Minggu: TUTUP | Customer service online 24/7 via WhatsApp untuk pertanyaan mendesak! ⏰', 'sub_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(21, 'promo_diskon', '🎉 **PROMO SPESIAL** | Diskon 15% pembelian >300rb | Paket install + produk diskon 50% jasa pasang | Gratis ongkir area Bandung min. 200rb | Member VIP cashback 10%! Promo terbatas, buruan order! 🔥', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(22, 'cara_pemesanan', '📝 **CARA PEMESANAN** | 1. Pilih produk di website/katalog | 2. Chat WA dengan kode produk | 3. Konfirmasi detail & alamat | 4. Transfer DP 50% | 5. Produk dikirim/dijadwalkan install | 6. Pelunasan saat terima barang! 🛒', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(23, 'garansi_produk', '🛡️ **GARANSI PRODUK** | Garansi produk 6-12 bulan (tergantung jenis) | Garansi pemasangan 6 bulan | Klaim garansi dengan bukti pembelian | Free service 1x dalam masa garansi | Penggantian jika cacat produksi! ✅', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37'),
(24, 'metode_pembayaran', '💳 **METODE PEMBAYARAN** | Transfer Bank: BCA, Mandiri, BRI | E-wallet: OVO, DANA, GoPay | COD area Bandung (+10rb) | Cicilan 0% kartu kredit | Crypto payment (Bitcoin, USDT) tersedia! 💰', 'main_intent', 1, 0, NULL, NULL, NULL, NULL, '2025-06-13 00:05:37', '2025-06-13 00:05:37');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `icon` varchar(255) DEFAULT NULL,
  `color` varchar(255) NOT NULL DEFAULT 'primary',
  `action_type` varchar(255) NOT NULL,
  `action_id` bigint(20) UNSIGNED DEFAULT NULL,
  `action_model` varchar(255) DEFAULT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_type` varchar(255) NOT NULL DEFAULT 'system',
  `user_name` varchar(255) DEFAULT NULL,
  `user_email` varchar(255) DEFAULT NULL,
  `metadata` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`metadata`)),
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `type`, `title`, `message`, `icon`, `color`, `action_type`, `action_id`, `action_model`, `user_id`, `user_type`, `user_name`, `user_email`, `metadata`, `is_read`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 'login', 'Admin Login', 'Test Admin logged into the admin panel.', 'bx bx-log-in', 'info', 'admin', NULL, NULL, 1, 'admin', 'Main Admin', 'test@newdomain.com', NULL, 0, '2025-06-16 15:49:34', '2025-06-16 11:34:53', '2025-06-16 15:49:34'),
(2, 'create', 'Section Content Created', 'Test Admin created a new section content: Portfolio Item.', 'bx bx-plus-circle', 'success', 'section_content', 1, NULL, 1, 'admin', 'Main Admin', 'test@newdomain.com', '\"{\\\"section_type\\\":\\\"portfolio\\\",\\\"content_title\\\":\\\"New Portfolio Item\\\"}\"', 0, '2025-06-16 15:49:34', '2025-06-16 11:29:53', '2025-06-16 15:49:34'),
(3, 'update', 'Section Content Updated', 'Test Admin updated section content: Testimonial Item.', 'bx bx-edit-alt', 'warning', 'section_content', 2, NULL, 1, 'admin', 'Main Admin', 'test@newdomain.com', '\"{\\\"section_type\\\":\\\"testimonials\\\",\\\"content_title\\\":\\\"Customer Testimonial\\\"}\"', 0, '2025-06-16 11:31:53', '2025-06-16 11:24:53', '2025-06-16 11:39:53'),
(4, 'delete', 'Section Content Deleted', 'Test Admin deleted section content: Old Instagram Post.', 'bx bx-trash', 'danger', 'section_content', NULL, NULL, 1, 'admin', 'Main Admin', 'test@newdomain.com', '\"{\\\"item_name\\\":\\\"Old Instagram Post\\\",\\\"section_type\\\":\\\"instagram\\\"}\"', 0, '2025-06-16 15:49:34', '2025-06-16 11:19:53', '2025-06-16 15:49:34'),
(5, 'create', 'Admin User Created', 'Test Admin created a new admin user account.', 'bx bx-user-plus', 'success', 'admin', 2, NULL, 1, 'admin', 'Main Admin', 'test@newdomain.com', '\"{\\\"new_admin_email\\\":\\\"newadmin@example.com\\\"}\"', 0, '2025-06-16 15:49:34', '2025-06-16 10:39:53', '2025-06-16 15:49:34'),
(6, 'system', 'System Maintenance', 'System maintenance completed successfully.', 'bx bx-cog', 'dark', 'system', NULL, NULL, NULL, 'admin', 'System', NULL, NULL, 0, '2025-06-16 09:39:53', '2025-06-16 08:39:53', '2025-06-16 11:39:53'),
(7, 'warning', 'Security Alert', 'Multiple failed login attempts detected.', 'bx bx-error-circle', 'warning', 'security', NULL, NULL, NULL, 'admin', 'Security System', NULL, '\"{\\\"ip_address\\\":\\\"192.168.1.100\\\",\\\"attempts\\\":5}\"', 0, '2025-06-16 15:49:34', '2025-06-16 05:39:53', '2025-06-16 15:49:34'),
(8, 'update', 'Section_content Updated', 'Test Admin updated section content.', 'bx bx-edit-alt', 'warning', 'section_content', 45, 'App\\Models\\SectionContent', 1, 'admin', 'Main Admin', 'test@newdomain.com', '{\"section_type\":\"text\",\"content_title\":\"TikTok Video 1\",\"admin_id\":1,\"timestamp\":\"2025-06-16T18:40:51.957818Z\",\"ip_address\":\"127.0.0.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/137.0.0.0 Safari\\/537.36\"}', 0, '2025-06-16 15:49:34', '2025-06-16 11:40:51', '2025-06-16 15:49:34'),
(9, 'login', 'User Login', 'Test Admin logged into the system.', 'bx bx-log-in', 'info', 'admin', NULL, NULL, 1, 'admin', 'Main Admin', 'test@newdomain.com', '{\"user_id\":1,\"user_type\":\"admin\",\"timestamp\":\"2025-06-16T22:18:39.279392Z\",\"ip_address\":\"127.0.0.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/137.0.0.0 Safari\\/537.36\"}', 1, '2025-06-16 15:49:34', '2025-06-16 15:18:39', '2025-06-16 15:49:34'),
(10, 'system', 'System Backup Completed', 'Daily system backup has been completed successfully.', 'bx bx-check-circle', 'success', 'system', NULL, NULL, NULL, 'system', 'System', NULL, NULL, 1, '2025-06-16 15:49:34', '2025-06-16 13:31:32', '2025-06-16 15:49:34'),
(11, 'system', 'Database Maintenance', 'Scheduled database maintenance will occur at 2:00 AM.', 'bx bx-wrench', 'warning', 'maintenance', NULL, NULL, NULL, 'system', 'System', NULL, NULL, 0, '2025-06-16 15:49:34', '2025-06-16 09:31:32', '2025-06-16 15:49:34'),
(12, 'login', 'Admin Login', 'Test Admin logged into the admin panel.', 'bx bx-log-in', 'info', 'admin', NULL, NULL, 1, 'admin', 'Main Admin', 'test@newdomain.com', '{\"ip_address\":\"192.168.1.100\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36\"}', 0, '2025-06-16 15:49:34', '2025-06-16 15:01:32', '2025-06-16 15:49:34'),
(13, 'create', 'New Admin User Created', 'Test Admin created a new admin user account.', 'bx bx-user-plus', 'success', 'admin', 1, 'App\\Models\\Admin', 1, 'admin', 'Main Admin', 'test@newdomain.com', '{\"created_admin_email\":\"newadmin@example.com\"}', 0, '2025-06-16 15:11:32', '2025-06-16 14:46:32', '2025-06-16 15:31:32'),
(14, 'create', 'New Customer Registration', 'New customer Rio has registered.', 'bx bx-user-plus', 'success', 'customer', 1, 'App\\Models\\Customer', 1, 'customer', 'Rio', 'rioardanaputra98@gmail.com', '{\"registration_ip\":\"192.168.1.150\",\"source\":\"web\"}', 0, '2025-06-16 15:49:34', '2025-06-16 11:31:32', '2025-06-16 15:49:34'),
(15, 'update', 'Customer Profile Updated', 'Customer Rio updated their profile information.', 'bx bx-edit-alt', 'warning', 'customer', 1, 'App\\Models\\Customer', 1, 'customer', 'Rio', 'rioardanaputra98@gmail.com', '{\"fields_updated\":[\"phone\",\"address\"]}', 0, '2025-06-16 15:49:34', '2025-06-16 07:31:32', '2025-06-16 15:49:34'),
(16, 'info', 'New Feature Available', 'A new chatbot feature has been deployed and is now available.', 'bx bx-info-circle', 'info', 'feature', NULL, NULL, NULL, 'system', 'System', NULL, '{\"feature_name\":\"Enhanced Chatbot\",\"version\":\"2.1.0\"}', 0, '2025-06-16 15:49:34', '2025-06-15 15:31:32', '2025-06-16 15:49:34'),
(17, 'warning', 'High Server Load', 'Server load is higher than normal. Monitoring system performance.', 'bx bx-error-circle', 'warning', 'performance', NULL, NULL, NULL, 'system', 'Monitoring System', NULL, '{\"cpu_usage\":\"85%\",\"memory_usage\":\"78%\"}', 0, '2025-06-16 03:31:32', '2025-06-14 15:31:32', '2025-06-16 15:31:32'),
(18, 'success', 'Security Update Applied', 'Security patches have been successfully applied to the system.', 'bx bx-shield-check', 'success', 'security', NULL, NULL, NULL, 'system', 'Security System', NULL, '{\"patches_applied\":3,\"security_level\":\"high\"}', 0, '2025-06-16 15:49:34', '2025-06-13 15:31:32', '2025-06-16 15:49:34'),
(19, 'create', 'System: Customer Created', 'System automatically created a new customer: Rio.', 'bx bx-plus-circle', 'success', 'customer', 5, 'App\\Models\\Customer', NULL, 'system', 'System', NULL, '{\"model_class\":\"App\\\\Models\\\\Customer\",\"model_id\":5,\"created_at\":\"2025-06-16T22:33:12.000000Z\",\"timestamp\":\"2025-06-16T22:33:12.399941Z\",\"automated\":true}', 0, '2025-06-16 15:49:34', '2025-06-16 15:33:12', '2025-06-16 15:49:34'),
(20, 'create', 'System: Contact Created', 'System automatically created a new contact message (ID: 5).', 'bx bx-plus-circle', 'success', 'contact', 5, 'App\\Models\\ContactMessage', NULL, 'system', 'System', NULL, '{\"model_class\":\"App\\\\Models\\\\ContactMessage\",\"model_id\":5,\"created_at\":\"2025-06-16T22:33:12.000000Z\",\"timestamp\":\"2025-06-16T22:33:12.415016Z\",\"automated\":true}', 0, '2025-06-16 15:49:34', '2025-06-16 15:33:12', '2025-06-16 15:49:34'),
(21, 'update', 'System: Contact Updated', 'System automatically updated contact message (ID: 5).', 'bx bx-edit-alt', 'warning', 'contact', 5, 'App\\Models\\ContactMessage', NULL, 'system', 'System', NULL, '{\"model_class\":\"App\\\\Models\\\\ContactMessage\",\"model_id\":5,\"changes\":{\"is_read\":true,\"updated_at\":\"2025-06-16 22:34:08\"},\"original\":{\"id\":5,\"customer_id\":5,\"admin_id\":null,\"content_key\":\"installation\",\"content\":\"Work Timings\\r\\nSenin - Jumat : 08:00 - 17:00\\r\\nSabtu - Minggu : 10:00 - 16:00\",\"status\":\"new\",\"is_read\":false,\"is_important\":false,\"is_deleted\":false,\"deleted_at\":null,\"category\":\"installation\",\"last_update_time\":\"2025-06-16T22:33:12.000000Z\",\"created_at\":\"2025-06-16T22:33:12.000000Z\",\"updated_at\":\"2025-06-16T22:33:12.000000Z\"},\"updated_at\":\"2025-06-16T22:34:08.000000Z\",\"timestamp\":\"2025-06-16T22:34:08.630642Z\",\"automated\":true}', 0, '2025-06-16 15:49:34', '2025-06-16 15:34:08', '2025-06-16 15:49:34'),
(22, 'update', 'System: Contact Updated', 'System automatically updated contact message (ID: 5).', 'bx bx-edit-alt', 'warning', 'contact', 5, 'App\\Models\\ContactMessage', NULL, 'system', 'System', NULL, '{\"model_class\":\"App\\\\Models\\\\ContactMessage\",\"model_id\":5,\"changes\":{\"admin_id\":1,\"status\":\"in_progress\",\"last_update_time\":\"2025-06-16 22:34:19\",\"updated_at\":\"2025-06-16 22:34:19\"},\"original\":{\"id\":5,\"customer_id\":5,\"admin_id\":null,\"content_key\":\"installation\",\"content\":\"Work Timings\\r\\nSenin - Jumat : 08:00 - 17:00\\r\\nSabtu - Minggu : 10:00 - 16:00\",\"status\":\"new\",\"is_read\":true,\"is_important\":false,\"is_deleted\":false,\"deleted_at\":null,\"category\":\"installation\",\"last_update_time\":\"2025-06-16T22:33:12.000000Z\",\"created_at\":\"2025-06-16T22:33:12.000000Z\",\"updated_at\":\"2025-06-16T22:34:08.000000Z\"},\"updated_at\":\"2025-06-16T22:34:19.000000Z\",\"timestamp\":\"2025-06-16T22:34:19.640330Z\",\"automated\":true}', 0, '2025-06-16 15:49:34', '2025-06-16 15:34:19', '2025-06-16 15:49:34'),
(23, 'update', 'Admin Updated', 'Test Admin updated admin: Main Admin.', 'bx bx-edit-alt', 'warning', 'admin', 1, 'App\\Models\\Admin', 1, 'admin', 'Main Admin', 'test@newdomain.com', '{\"model_class\":\"App\\\\Models\\\\Admin\",\"model_id\":1,\"changes\":{\"name\":\"eyJpdiI6InRlTDA0em5ORndCZWluWGZXVUsyelE9PSIsInZhbHVlIjoiT1pTQlg3QndGZG12Z1pEd25VSmdwSy9ucloxM2dyUzNtZ2NXSDNscGJOST0iLCJtYWMiOiI3YjdhZTY5NDViMGRjNTE1MDczNWNlYTQ4ZGFiMzcwYjI5YTQ2ZjE2NTI5Y2M5ZDZkOTlmNmIzZjRkY2I0MzRjIiwidGFnIjoiIn0=\",\"email\":\"eyJpdiI6ImFtYWFkQUFvZ29Gd0o5MDNCa0tyR3c9PSIsInZhbHVlIjoienAvV1hJV0RaemdqbU1jNUJJa0dQMEg1OER0NmNyYlRma3A2QUE4eldWdz0iLCJtYWMiOiI4OTU5MTIzMmRmYjg5YmI4Y2UwZTgzYmIyMjM0MDQ5MmMyM2Y5NTE3NzhkYzUwNGUzNTRjMjNhZmZkNzg2MGYzIiwidGFnIjoiIn0=\",\"password\":\"$2y$12$chpFAnfS1xzKGMFu0vR.NeDhwOZU9JcqAgeIoEN0Mt\\/UIpgQykY1O\",\"updated_at\":\"2025-06-16 22:52:16\"},\"original\":{\"id\":1,\"name\":\"Test Admin\",\"email\":\"test@newdomain.com\",\"email_verified_at\":\"2025-06-13 13:20:33\",\"is_active\":true,\"verified\":true,\"password\":\"$2y$12$JxuudnK9UUlfNkWa056Dzu91.HU8upTyio88GzWvWgrnkFywt8bEa\",\"remember_token\":null,\"security_code\":null,\"security_code_expires_at\":null,\"created_at\":\"2025-06-13T05:59:52.000000Z\",\"updated_at\":\"2025-06-13T05:59:52.000000Z\"},\"updated_at\":\"2025-06-16T22:52:16.000000Z\",\"user_id\":1,\"user_type\":\"admin\",\"timestamp\":\"2025-06-16T22:52:16.931270Z\",\"ip_address\":\"127.0.0.1\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/137.0.0.0 Safari\\/537.36\"}', 0, NULL, '2025-06-16 15:52:16', '2025-06-16 15:52:16'),
(24, 'update', 'System: Contact Updated', 'System automatically updated contact message (ID: 4).', 'bx bx-edit-alt', 'warning', 'contact', 4, 'App\\Models\\ContactMessage', NULL, 'system', 'System', NULL, '{\"model_class\":\"App\\\\Models\\\\ContactMessage\",\"model_id\":4,\"changes\":{\"last_update_time\":\"2025-06-16 23:04:01\",\"updated_at\":\"2025-06-16 23:04:01\"},\"original\":{\"id\":4,\"customer_id\":4,\"admin_id\":1,\"content_key\":\"warranty\",\"content\":\"contact_messages contact_messages contact_messages\",\"status\":\"in_progress\",\"is_read\":true,\"is_important\":false,\"is_deleted\":false,\"deleted_at\":null,\"category\":\"warranty\",\"last_update_time\":\"2025-06-16T17:05:32.000000Z\",\"created_at\":\"2025-06-16T17:04:56.000000Z\",\"updated_at\":\"2025-06-16T17:05:32.000000Z\"},\"updated_at\":\"2025-06-16T23:04:01.000000Z\",\"timestamp\":\"2025-06-16T23:04:01.232677Z\",\"automated\":true}', 0, NULL, '2025-06-16 16:04:01', '2025-06-16 16:04:01'),
(25, 'update', 'System: Contact Updated', 'System automatically updated contact message (ID: 4).', 'bx bx-edit-alt', 'warning', 'contact', 4, 'App\\Models\\ContactMessage', NULL, 'system', 'System', NULL, '{\"model_class\":\"App\\\\Models\\\\ContactMessage\",\"model_id\":4,\"changes\":{\"last_update_time\":\"2025-06-16 23:06:01\",\"updated_at\":\"2025-06-16 23:06:01\"},\"original\":{\"id\":4,\"customer_id\":4,\"admin_id\":1,\"content_key\":\"warranty\",\"content\":\"contact_messages contact_messages contact_messages\",\"status\":\"in_progress\",\"is_read\":true,\"is_important\":false,\"is_deleted\":false,\"deleted_at\":null,\"category\":\"warranty\",\"last_update_time\":\"2025-06-16T23:04:01.000000Z\",\"created_at\":\"2025-06-16T17:04:56.000000Z\",\"updated_at\":\"2025-06-16T23:04:01.000000Z\"},\"updated_at\":\"2025-06-16T23:06:01.000000Z\",\"timestamp\":\"2025-06-16T23:06:01.301072Z\",\"automated\":true}', 0, NULL, '2025-06-16 16:06:01', '2025-06-16 16:06:01'),
(26, 'update', 'System: Contact Updated', 'System automatically updated contact message (ID: 4).', 'bx bx-edit-alt', 'warning', 'contact', 4, 'App\\Models\\ContactMessage', NULL, 'system', 'System', NULL, '{\"model_class\":\"App\\\\Models\\\\ContactMessage\",\"model_id\":4,\"changes\":{\"last_update_time\":\"2025-06-16 23:08:02\",\"updated_at\":\"2025-06-16 23:08:02\"},\"original\":{\"id\":4,\"customer_id\":4,\"admin_id\":1,\"content_key\":\"warranty\",\"content\":\"contact_messages contact_messages contact_messages\",\"status\":\"in_progress\",\"is_read\":true,\"is_important\":false,\"is_deleted\":false,\"deleted_at\":null,\"category\":\"warranty\",\"last_update_time\":\"2025-06-16T23:06:01.000000Z\",\"created_at\":\"2025-06-16T17:04:56.000000Z\",\"updated_at\":\"2025-06-16T23:06:01.000000Z\"},\"updated_at\":\"2025-06-16T23:08:02.000000Z\",\"timestamp\":\"2025-06-16T23:08:02.587006Z\",\"automated\":true}', 0, NULL, '2025-06-16 16:08:02', '2025-06-16 16:08:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `predefined_messages`
--

CREATE TABLE `predefined_messages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `question` varchar(255) NOT NULL,
  `answer` text NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `display_order` int(11) NOT NULL DEFAULT 0,
  `show_in_faq` tinyint(1) NOT NULL DEFAULT 0,
  `show_in_chat` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `sold` int(11) NOT NULL DEFAULT 0,
  `ratings` int(11) NOT NULL DEFAULT 0,
  `average_rating` decimal(2,1) NOT NULL DEFAULT 0.0,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `image`, `description`, `stock`, `sold`, `ratings`, `average_rating`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Mounting Upsize All', 'Mounting & Body', 'landing/images/products/mounting-upsize-all.jpg', 'Universal mounting solution for various motorcycle types', 3901, 377, 192, '4.6', 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(2, 'Mounting Vario', 'Mounting & Body', 'landing/images/products/mounting-vario.jpg', 'Specialized mounting for Vario and compatible models', 3006, 3100, 1600, '4.8', 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(3, 'Turbo SE Experience 60W', 'Lampu', 'landing/images/products/turbo-se-60w.jpg', 'High-performance 60W LED lamp with advanced features', 90, 0, 0, '0.0', 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `product_options`
--

CREATE TABLE `product_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `option_name` varchar(255) NOT NULL,
  `display_name` varchar(255) NOT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT 0,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_options`
--

INSERT INTO `product_options` (`id`, `product_id`, `option_name`, `display_name`, `is_required`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'motor_type', 'Motor Type', 1, 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(2, 1, 'size', 'Size', 1, 2, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(3, 2, 'motor_type', 'Motor Type', 1, 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(4, 2, 'size', 'Size', 1, 2, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(5, 3, 'quantity', 'Quantity', 1, 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `product_option_values`
--

CREATE TABLE `product_option_values` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_option_id` bigint(20) UNSIGNED NOT NULL,
  `value` varchar(255) NOT NULL,
  `display_value` varchar(255) NOT NULL,
  `price_adjustment` decimal(10,2) NOT NULL DEFAULT 0.00,
  `is_default` tinyint(1) NOT NULL DEFAULT 0,
  `is_available` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_option_values`
--

INSERT INTO `product_option_values` (`id`, `product_option_id`, `value`, `display_value`, `price_adjustment`, `is_default`, `is_available`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'aerox_old', 'Aerox Old', '0.00', 1, 1, 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(2, 1, 'aerox_new', 'Aerox New', '0.00', 0, 1, 2, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(3, 1, 'aerox_alpha', 'Aerox Alpha', '0.00', 0, 1, 3, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(4, 1, 'nmax_new', 'Nmax New', '0.00', 0, 1, 4, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(5, 1, 'nmax_neo', 'Nmax Neo', '0.00', 0, 1, 5, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(6, 1, 'lexy', 'Lexy', '0.00', 0, 0, 6, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(7, 2, '3cm', '3cm', '0.00', 1, 1, 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(8, 2, '4cm', '4cm', '0.00', 0, 1, 2, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(9, 2, '5cm', '5cm', '0.00', 0, 1, 3, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(10, 2, '6cm', '6cm', '0.00', 0, 1, 4, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(11, 2, '7cm', '7cm', '0.00', 0, 1, 5, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(12, 2, '8cm', '8cm', '0.00', 0, 1, 6, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(13, 2, '9cm', '9cm', '0.00', 0, 1, 7, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(14, 3, 'vario_led_old', 'Vario LED Old', '0.00', 1, 1, 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(15, 3, 'vario_led_new', 'Vario LED New', '0.00', 0, 1, 2, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(16, 3, 'beat_esp', 'Beat ESP', '0.00', 0, 1, 3, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(17, 3, 'scoopy_esp', 'Scoopy ESP', '0.00', 0, 1, 4, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(18, 4, '3cm', '3cm', '0.00', 1, 1, 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(19, 4, '4cm', '4cm', '0.00', 0, 1, 2, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(20, 4, '5cm', '5cm', '0.00', 0, 1, 3, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(21, 4, '6cm', '6cm', '0.00', 0, 1, 4, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(22, 4, '7cm', '7cm', '0.00', 0, 1, 5, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(23, 4, '8cm', '8cm', '0.00', 0, 1, 6, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(24, 4, '9cm', '9cm', '0.00', 0, 1, 7, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(25, 5, 'single', 'Single', '0.00', 1, 1, 1, '2025-06-12 23:06:47', '2025-06-12 23:06:47'),
(26, 5, 'pair', 'Pair', '20.00', 0, 1, 2, '2025-06-12 23:06:47', '2025-06-12 23:06:47');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(25) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `layout` int(11) NOT NULL DEFAULT 1,
  `show_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `title`, `description`, `content`, `image`, `button_text`, `button_link`, `is_active`, `layout`, `show_order`, `created_at`, `updated_at`) VALUES
(1, 'about', 'Redefining Performance', 'Lebih dari Sekadar Sparepart, Ini Tentang Pengalaman Berkendara', 'Di Boy Project, kami menghadirkan produk terbaik untuk meningkatkan performa dan estetika motor Anda. Setiap sparepart yang kami sediakan dipilih dengan cermat untuk memberikan kualitas, ketahanan, dan kenyamanan terbaik bagi para rider.', 'landing/images/startup-bg.jpg', NULL, NULL, 1, 2, 2, '2025-03-20 04:21:56', '2025-06-16 10:59:27'),
(2, 'contact', 'Contact Us', '- Stay in Touch -', NULL, NULL, NULL, NULL, 1, 1, 8, '2025-03-20 04:21:56', '2025-03-20 04:21:56'),
(3, 'counter', 'Our Achievements', 'We have achieved great milestones over the years.', NULL, NULL, NULL, NULL, 1, 1, 6, '2025-03-20 04:21:56', '2025-03-20 04:21:56'),
(4, 'portofolio', 'Our Work', 'Explore our best projects in various categories.', NULL, NULL, NULL, NULL, 1, 1, 7, '2025-03-20 04:21:56', '2025-03-20 04:21:56'),
(5, 'pricing', 'Our Pricing', '- Choose Your Plan -', NULL, NULL, NULL, NULL, 1, 1, 10, '2025-03-20 04:23:12', '2025-03-20 04:23:12'),
(6, 'services', 'Apa yang Kami Tawarkan', '- Enhancing Your Performance -', NULL, NULL, NULL, NULL, 1, 1, 4, '2025-03-20 04:24:18', '2025-03-20 04:24:18'),
(7, 'promotion', 'NEW PRODUCTS', 'get promotion info', NULL, NULL, NULL, NULL, 1, 2, 5, '2025-03-20 04:25:06', '2025-03-20 04:25:06'),
(8, 'testimonials', 'Testimonials', '- Happy Clients -', NULL, NULL, NULL, NULL, 1, 1, 9, '2025-03-20 04:25:39', '2025-03-20 04:25:39'),
(9, 'home', 'Welcome to Boys Project', 'Jual beli sparepart motor & pemasangan terpercaya', NULL, NULL, NULL, NULL, 1, 1, 1, '2025-03-20 04:37:27', '2025-06-02 23:15:56'),
(10, 'tiktok', 'Our TikTok Content', 'Latest updates from TikTok', NULL, NULL, NULL, NULL, 1, 1, 12, '2025-03-20 05:02:27', '2025-03-20 05:02:27'),
(11, 'instagram', 'Our Instagram Posts', 'Latest updates from Instagram', NULL, NULL, NULL, NULL, 1, 1, 13, '2025-03-20 05:03:17', '2025-03-20 05:03:17'),
(12, 'activities', 'Our Activities', 'Lebih dari Sekadar Produk, Ini Tentang Perjalanan Bersama', NULL, 'landing/images/onepage-bg-left.jpg', NULL, NULL, 1, 1, 3, '2025-03-20 21:40:43', '2025-03-20 21:40:43'),
(13, 'cta', 'Take Action Now!', 'Join us and upgrade your bike today!', 'Get the best spare parts and professional installation for your motorbike.', 'landing/images/background/parallax-bg-2.jpg', 'Chat Us!!', 'https://wa.me/08211990442', 1, 1, 11, '2025-03-20 21:52:50', '2025-03-20 21:52:50'),
(14, 'categories', 'WHAT WE OFFER', NULL, NULL, NULL, NULL, NULL, 1, 1, 3, '2025-04-20 16:47:43', '2025-04-20 16:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `section_contents`
--

CREATE TABLE `section_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `content_key` varchar(255) NOT NULL,
  `content_value` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `extra_data` longtext DEFAULT NULL,
  `show_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_contents`
--

INSERT INTO `section_contents` (`id`, `section_id`, `content_key`, `content_value`, `description`, `type`, `extra_data`, `show_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kualitas Terjamin!!', 'Produk unggulan untuk performa maksimal.', NULL, 'text', '[]', 0, '2025-03-19 21:22:22', '2025-06-16 11:18:55'),
(2, 1, ' Pemasangan Mudah', 'Dirancang untuk presisi tanpa ribet.', NULL, 'text', NULL, 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(3, 1, 'Didesain untuk performa', 'Cocok untuk motor harian hingga modifikasi.', NULL, 'text', NULL, 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(4, 2, 'email', 'info@example.com', NULL, 'text', NULL, 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(5, 2, 'address', '123 Street Name, City, Country', NULL, 'text', NULL, 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(6, 2, 'postal_address', 'Cimahi, Bandung', NULL, 'text', NULL, 0, '2025-03-21 09:22:53', '2025-03-21 09:22:53'),
(7, 2, 'phone', '08211990442', NULL, 'text', NULL, 0, '2025-03-21 09:22:53', '2025-03-21 09:22:53'),
(8, 2, 'work_time_weekdays', 'Senin - Jumat : 08:00 - 17:00', NULL, 'text', NULL, 0, '2025-03-21 09:22:53', '2025-03-21 09:22:53'),
(9, 2, 'work_time_weekend', 'Sabtu - Minggu : 10:00 - 16:00', NULL, 'text', NULL, 0, '2025-03-21 09:22:53', '2025-03-21 09:22:53'),
(10, 3, 'Working Hours', '5600', NULL, 'number', NULL, 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(11, 3, 'Happy Clients', '220', NULL, 'number', NULL, 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(12, 3, 'Awards', '108', NULL, 'number', NULL, 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(13, 3, 'Projects a Year', '650', NULL, 'number', NULL, 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(14, 4, 'Beach Club', 'Print Design', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/1.jpg\", \"categories\": \"pemasangan, kolaborasi, event\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(15, 4, 'Be loved one', 'Branding', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/2.jpg\", \"categories\": \"modifikasi\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(16, 4, 'Salute to twins', 'Branding', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/3.jpg\", \"categories\": \"kolaborasi\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(17, 4, 'Tired eye', 'Web Design', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/4.jpg\", \"categories\": \"event, pemasangan\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(18, 4, 'Welcome home', 'Web Design', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/5.jpg\", \"categories\": \"modifikasi, event\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(19, 4, 'Repair and improve', 'Print Design', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/6.jpg\", \"categories\": \"modifikasi, perbaikan\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(20, 4, 'My bed room', 'Branding', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/7.jpg\", \"categories\": \"kolaborasi, event\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(21, 4, 'Saksi bisu', 'Web Design', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/8.jpg\", \"categories\": \"event, pemasangan\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(22, 4, 'Sure, aku solo', 'Branding', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/9.jpg\", \"categories\": \"event\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(23, 4, 'Make it RED', 'Web Design', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/10.jpg\", \"categories\": \"perbaikan, pemasangan\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(24, 4, 'Upgrading', 'Web Design', NULL, 'image', '{\"image\": \"landing/images/portfolio/grid/11.jpg\", \"categories\": \"modifikasi, pemasangan\", \"link\": \"#\"}', 0, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(25, 5, 'Started', '{\"price\": \"0.99\", \"icon\": \"icofont-paper-plane\", \"features\": [\"512 GB Ram\", \"50 GB Disk\", \"1 User\", \"4TB Bandwidth\"]}', NULL, 'json', NULL, 0, '2025-03-19 21:23:12', '2025-03-19 21:23:12'),
(26, 5, 'Basic', '{\"price\": \"19.99\", \"icon\": \"icofont-light-bulb\", \"features\": [\"512 GB Ram\", \"80 GB Disk\", \"2 User\", \"4TB Bandwidth\"]}', NULL, 'json', NULL, 0, '2025-03-19 21:23:12', '2025-03-19 21:23:12'),
(27, 5, 'Standard', '{\"price\": \"39.99\", \"icon\": \"icofont-pen-alt-3\", \"features\": [\"768 GB Ram\", \"80 GB Disk\", \"3 User\", \"Full Data Security\", \"Unlimited Questions\", \"6TB Bandwidth\"]}', NULL, 'json', NULL, 0, '2025-03-19 21:23:12', '2025-03-19 21:23:12'),
(28, 5, 'Pro', '{\"price\": \"49.99\", \"icon\": \"icofont-magic\", \"features\": [\"1 TB Ram\", \"1 TB Disk\", \"4 User\", \"4TB Bandwidth\"]}', NULL, 'json', NULL, 0, '2025-03-19 21:23:12', '2025-03-19 21:23:12'),
(29, 6, 'Installation Service', 'Professional and precise installation of motorbike parts by experienced technicians.', NULL, 'text', '{\"icon\": \"icofont-tools\"}', 0, '2025-03-19 21:24:18', '2025-03-19 21:24:18'),
(30, 6, 'Spare Parts Sales', 'Wide range of high-quality spare parts with guaranteed authenticity and competitive pricing.', NULL, 'text', '{\"icon\": \"icofont-motor-biker\"}', 0, '2025-03-19 21:24:18', '2025-03-19 21:24:18'),
(31, 6, 'Customization & Tuning', 'Upgrade your bike’s look and performance with our custom modification and tuning services.', NULL, 'text', '{\"icon\": \"icofont-gear-alt\"}', 0, '2025-03-19 21:24:18', '2025-03-19 21:24:18'),
(32, 6, 'Fast Delivery Service', 'Quick and reliable delivery for all your motorbike spare parts and accessories.', NULL, 'text', '{\"icon\": \"icofont-fast-delivery\"}', 0, '2025-03-19 21:24:18', '2025-03-19 21:24:18'),
(33, 7, 'Free Ongkir', 'selama bulan desember', NULL, 'image', '{\"image\": \"landing/images/team/team-1.png\", \"link\": \"#\"}', 0, '2025-03-19 21:25:06', '2025-03-19 21:25:06'),
(34, 7, 'Kusus Honda', 'diskon untuk mounting', NULL, 'image', '{\"image\": \"landing/images/team/team-2.png\", \"link\": \"#\"}', 0, '2025-03-19 21:25:06', '2025-03-19 21:25:06'),
(35, 7, 'Gratis Pasang', 's&k berlaku', NULL, 'image', '{\"image\": \"landing/images/team/team-3.png\", \"link\": \"#\"}', 0, '2025-03-19 21:25:06', '2025-03-19 21:25:06'),
(36, 7, 'Promo Bulan Ini', 'Perhatikan terus sosmed', NULL, 'image', '{\"image\": \"landing/images/team/team-4.png\", \"link\": \"#\"}', 0, '2025-03-19 21:25:06', '2025-03-19 21:25:06'),
(37, 8, 'krnawnaprl', 'KEREN BANGET MOUNTINGNYA KOK BISA SIH SE CENTER ITU MIN 😔☝🏻', NULL, 'text', '{\"image\": \"landing/images/team/team-1.jpg\", \"variation\": \"Aerox New, 7cm\"}', 0, '2025-03-19 21:25:39', '2025-03-19 21:25:39'),
(38, 8, 'syahrulrochman859', 'Thanks min, mountingnya bagus & center🔥', NULL, 'text', '{\"image\": \"landing/images/team/team-2.jpg\", \"variation\": \"Aerox New, 8cm\"}', 0, '2025-03-19 21:25:39', '2025-03-19 21:25:39'),
(39, 8, 'juned_alfied', 'mounting by boyprojects sangat pnp sekali ke kzr saya tanpa rubah apapun, benar-benar plug n play...', NULL, 'text', '{\"image\": \"landing/images/team/team-3.jpg\", \"variation\": \"5cm + bosh\"}', 0, '2025-03-19 21:25:39', '2025-03-19 21:25:39'),
(40, 8, 'nobodyjudgeme', 'Alhamdulillah barang terpasang dengan baik dan posisi center. Terimakasih omku', NULL, 'text', '{\"image\": \"landing/images/team/team-4.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-19 21:25:39', '2025-03-19 21:25:39'),
(41, 8, 'adidaengg', 'Mantapp, mounting nya aman 100% presisi, ga ada kendala sama sekali pas pemasangan.', NULL, 'text', '{\"image\": \"landing/images/team/team-5.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-19 21:25:39', '2025-03-19 21:25:39'),
(42, 8, 'harsanandarozzaqfirmansyah', 'mantab asli top lah boy! kaga miring samsek joss puas kali lah!', NULL, 'text', '{\"image\": \"landing/images/team/team-6.jpg\", \"variation\": \"3 cm\"}', 0, '2025-03-19 21:25:39', '2025-03-19 21:25:39'),
(43, 9, 'Ubah tampilan dan performa dengan berkualitas tinggi', 'Upgrade Your Ride, Elevate Your Style!', NULL, 'text', '{\"image\": \"landing/images/slides/home-bg-2.jpg\", \"description\": \"Kami menyediakan berbagai sparepart terbaik untuk motor matic dan sport.\", \"button_text\": \"Lihat Produk\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-19 21:37:27', '2025-03-19 21:37:27'),
(44, 9, 'Kami siap melayani!', 'Sparepart berkualitas, pemasangan presisi', NULL, 'text', '{\"image\": \"landing/images/slides/home-bg-1.jpg\", \"description\": \"Layanan pemasangan sparepart dengan teknisi berpengalaman.\", \"button_text\": \"Cek Layanan\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-19 21:37:27', '2025-03-19 21:37:27'),
(45, 10, 'TikTok Video 1', 'https://www.tiktok.com/@boyprojects/video/7482575523772779831', NULL, 'text', '{\"embed_url\":\"https:\\/\\/www.tiktok.com\\/@boyprojects\\/video\\/7482575523772779831\",\"video_id\":\"7482575523772779831\"}', 2, '2025-03-19 22:02:27', '2025-06-16 11:40:51'),
(46, 10, 'TikTok Video 2', NULL, NULL, 'text', '{\"embed_url\": \"https://www.tiktok.com/@boyprojects/photo/7483462663515753736\", \"video_id\": \"7483462663515753736\"}', 0, '2025-03-19 22:02:27', '2025-03-19 22:02:27'),
(47, 11, 'Instagram Post 1', 'https://www.instagram.com/p/DH3oGaVy9TO', NULL, 'text', '{\"embed_url\":\"https:\\/\\/www.instagram.com\\/p\\/DH3oGaVy9TO\"}', 0, '2025-03-19 22:03:17', '2025-06-16 10:40:16'),
(48, 11, 'Instagram Post 2', NULL, NULL, 'text', '{\"embed_url\": \"https://www.instagram.com/p/DId4T2hJVC\"}', 0, '2025-03-19 22:03:17', '2025-03-19 22:03:17'),
(49, 12, 'Workshop & Modifikasi', 'Mengikuti berbagai event otomotif dan modifikasi motor untuk menghadirkan inovasi terbaik.', NULL, 'text', '{\"icon\": \"icofont-trophy\"}', 0, '2025-03-20 14:41:07', '2025-03-20 14:45:41'),
(50, 12, 'Gathering & Riding Events', 'Berkolaborasi dengan komunitas riders dan penggemar otomotif dari seluruh Indonesia.', NULL, 'text', '{\"icon\": \"icofont-users\"}', 1, '2025-03-20 14:41:07', '2025-03-20 14:45:41'),
(51, 12, 'Online Webinars & Tips', 'Berbagi wawasan seputar perawatan, pemasangan, dan upgrade motor untuk performa maksimal.', NULL, 'text', '{\"icon\": \"icofont-tools\"}', 2, '2025-03-20 14:41:07', '2025-03-20 14:45:41'),
(52, 12, 'Networking & Partnership', 'Memperluas koneksi dengan sesama pecinta otomotif melalui berbagai acara eksklusif.', NULL, 'text', '{\"icon\": \"icofont-web\"}', 3, '2025-03-20 14:41:07', '2025-03-20 14:41:07'),
(53, 13, 'Upgrade Your Ride Today!', 'Get the best spare parts and professional installation for your motorbike.', NULL, 'text', NULL, 0, NULL, NULL),
(54, 14, 'LAMPU', '', NULL, 'image', '{\"image\": \"landing/images/categories/categories-1.png\", \"link\": \"https://shopee.co.id/boyprojectsasli?originalCategoryId=11043768#product_list\"}', 1, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(55, 14, 'MOUNTING', '', NULL, 'image', '{\"image\": \"landing/images/categories/categories-2.png\", \"link\": \"https://shopee.co.id/boyprojectsasli?originalCategoryId=11043764#product_list\"}', 1, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(56, 14, 'SERVICE', '', NULL, 'image', '{\"image\": \"landing/images/categories/default.png\", \"link\": \"\"}', 1, '2025-03-19 21:22:22', '2025-03-19 21:22:22'),
(57, 14, 'SOMETHING', '', NULL, 'image', '{\"image\": \"landing/images/categories/default.png\", \"link\": \"\"}', 1, '2025-03-19 21:22:22', '2025-03-19 21:22:22');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
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
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('UouBz9ro6pwBR9E2KjmRg7AnHpjAIDOw6A7dQmR1', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/137.0.0.0 Safari/537.36', 'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiYnRlSElhTDhweWJIa1Yxd0NWZW13NGR3Z0VjSkwxMTR4TU1nVmozVCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9kb2N1bWVudGF0aW9uIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MjoibG9naW5fYWRtaW5fNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToxO3M6MjI6IlBIUERFQlVHQkFSX1NUQUNLX0RBVEEiO2E6MDp7fX0=', 1750116002);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `chatbot_auto_responses`
--
ALTER TABLE `chatbot_auto_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chatbot_auto_responses_created_by_foreign` (`created_by`),
  ADD KEY `chatbot_auto_responses_updated_by_foreign` (`updated_by`),
  ADD KEY `chatbot_auto_responses_is_active_priority_index` (`is_active`,`priority`),
  ADD KEY `chatbot_auto_responses_match_type_index` (`match_type`),
  ADD KEY `chatbot_auto_responses_keyword_index` (`keyword`);

--
-- Indexes for table `chat_conversations`
--
ALTER TABLE `chat_conversations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_conversations_customer_id_foreign` (`customer_id`),
  ADD KEY `chat_conversations_status_created_at_index` (`status`,`created_at`),
  ADD KEY `chat_conversations_customer_email_index` (`customer_email`),
  ADD KEY `chat_conversations_admin_id_status_index` (`admin_id`,`status`),
  ADD KEY `chat_conversations_resolved_by_foreign` (`resolved_by`);

--
-- Indexes for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `chat_messages_conversation_id_created_at_index` (`conversation_id`,`created_at`),
  ADD KEY `chat_messages_sender_type_is_read_index` (`sender_type`,`is_read`),
  ADD KEY `chat_messages_sender_id_foreign` (`sender_id`);

--
-- Indexes for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `contact_messages_customer_id_foreign` (`customer_id`),
  ADD KEY `contact_messages_admin_id_foreign` (`admin_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customers_email_index` (`email`(768)),
  ADD KEY `customers_phone_index` (`phone`(768));

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `landing_pages`
--
ALTER TABLE `landing_pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `landing_pages_slug_unique` (`slug`);

--
-- Indexes for table `message_responses`
--
ALTER TABLE `message_responses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_responses_admin_id_foreign` (`admin_id`),
  ADD KEY `message_responses_contact_message_id_created_at_index` (`contact_message_id`,`created_at`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ml_responses`
--
ALTER TABLE `ml_responses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ml_responses_intent_key_unique` (`intent_key`),
  ADD KEY `ml_responses_auto_response_id_foreign` (`auto_response_id`),
  ADD KEY `ml_responses_created_by_foreign` (`created_by`),
  ADD KEY `ml_responses_updated_by_foreign` (`updated_by`),
  ADD KEY `ml_responses_intent_key_category_is_active_index` (`intent_key`,`category`,`is_active`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_type_is_read_index` (`type`,`is_read`),
  ADD KEY `notifications_user_type_user_id_index` (`user_type`,`user_id`),
  ADD KEY `notifications_action_type_action_id_index` (`action_type`,`action_id`),
  ADD KEY `notifications_created_at_index` (`created_at`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `predefined_messages`
--
ALTER TABLE `predefined_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_options`
--
ALTER TABLE `product_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_options_product_id_foreign` (`product_id`);

--
-- Indexes for table `product_option_values`
--
ALTER TABLE `product_option_values`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_option_values_product_option_id_foreign` (`product_option_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `section_contents`
--
ALTER TABLE `section_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_contents_section_id_foreign` (`section_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `chatbot_auto_responses`
--
ALTER TABLE `chatbot_auto_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `chat_conversations`
--
ALTER TABLE `chat_conversations`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chat_messages`
--
ALTER TABLE `chat_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `landing_pages`
--
ALTER TABLE `landing_pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message_responses`
--
ALTER TABLE `message_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `ml_responses`
--
ALTER TABLE `ml_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `predefined_messages`
--
ALTER TABLE `predefined_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `product_options`
--
ALTER TABLE `product_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_option_values`
--
ALTER TABLE `product_option_values`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `section_contents`
--
ALTER TABLE `section_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chatbot_auto_responses`
--
ALTER TABLE `chatbot_auto_responses`
  ADD CONSTRAINT `chatbot_auto_responses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `chatbot_auto_responses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chat_conversations`
--
ALTER TABLE `chat_conversations`
  ADD CONSTRAINT `chat_conversations_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `chat_conversations_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `chat_conversations_resolved_by_foreign` FOREIGN KEY (`resolved_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `chat_messages`
--
ALTER TABLE `chat_messages`
  ADD CONSTRAINT `chat_messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `chat_conversations` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `chat_messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD CONSTRAINT `contact_messages_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `contact_messages_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `message_responses`
--
ALTER TABLE `message_responses`
  ADD CONSTRAINT `message_responses_admin_id_foreign` FOREIGN KEY (`admin_id`) REFERENCES `admins` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `message_responses_contact_message_id_foreign` FOREIGN KEY (`contact_message_id`) REFERENCES `contact_messages` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ml_responses`
--
ALTER TABLE `ml_responses`
  ADD CONSTRAINT `ml_responses_auto_response_id_foreign` FOREIGN KEY (`auto_response_id`) REFERENCES `chatbot_auto_responses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ml_responses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ml_responses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `admins` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_options`
--
ALTER TABLE `product_options`
  ADD CONSTRAINT `product_options_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_option_values`
--
ALTER TABLE `product_option_values`
  ADD CONSTRAINT `product_option_values_product_option_id_foreign` FOREIGN KEY (`product_option_id`) REFERENCES `product_options` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `section_contents`
--
ALTER TABLE `section_contents`
  ADD CONSTRAINT `section_contents_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
