-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 07, 2025 at 09:29 PM
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
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User', 'admin@example.com', NULL, '$2y$10$8nHq9Q9TeW4Z1hTQyF4sYONfb3q3K8fAQcdsDRzT7Z5eHvktjGFFO', 'randomtoken123', '2025-03-21 01:16:19', '2025-03-21 01:16:19');

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
(4, '2025_03_19_020014_create_sections_table', 1),
(5, '2025_03_19_020015_create_section_contents_table', 1),
(6, '2025_03_21_011253_create_admin_table', 1);

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
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `layout` int(11) NOT NULL DEFAULT 1,
  `show_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `title`, `description`, `content`, `image`, `button_text`, `button_link`, `is_active`, `layout`, `show_order`, `created_at`, `updated_at`) VALUES
(1, 'about', 'Redefining Performance', 'Lebih dari Sekadar Sparepart, Ini Tentang Pengalaman Berkendara', 'Di Boy Project, kami menghadirkan produk terbaik untuk meningkatkan performa dan estetika motor Anda. Setiap sparepart yang kami sediakan dipilih dengan cermat untuk memberikan kualitas, ketahanan, dan kenyamanan terbaik bagi para rider.', 'landing/images/startup-bg.jpg', NULL, NULL, 1, 2, 2, '2025-03-20 18:21:56', '2025-03-20 18:21:56'),
(2, 'contact', 'Contact Us', '- Stay in Touch -', NULL, NULL, NULL, NULL, 1, 1, 8, '2025-03-20 18:21:56', '2025-03-20 18:21:56'),
(3, 'counter', 'Our Achievements', 'We have achieved great milestones over the years.', NULL, NULL, NULL, NULL, 1, 1, 6, '2025-03-20 18:21:56', '2025-03-20 18:21:56'),
(4, 'portofolio', 'Our Work', 'Explore our best projects in various categories.', NULL, NULL, NULL, NULL, 1, 1, 7, '2025-03-20 18:21:56', '2025-03-20 18:21:56'),
(5, 'pricing', 'Our Pricing', '- Choose Your Plan -', NULL, NULL, NULL, NULL, 1, 1, 10, '2025-03-20 18:23:12', '2025-03-20 18:23:12'),
(6, 'services', 'Apa yang Kami Tawarkan', '- Enhancing Your Performance -', NULL, NULL, NULL, NULL, 1, 1, 4, '2025-03-20 18:24:18', '2025-03-20 18:24:18'),
(7, 'promotion', 'NEW PRODUCTS', 'get promotion info', NULL, NULL, NULL, NULL, 1, 2, 5, '2025-03-20 18:25:06', '2025-03-20 18:25:06'),
(8, 'testimonials', 'Testimonials', '- Happy Clients -', NULL, NULL, NULL, NULL, 1, 1, 9, '2025-03-20 18:25:39', '2025-03-20 18:25:39'),
(9, 'home', 'Welcome to Boys Project', 'Jual beli sparepart motor & pemasangan terpercaya', NULL, NULL, NULL, NULL, 1, 1, 1, '2025-03-20 18:37:27', '2025-03-20 18:37:27'),
(10, 'tiktok', 'Our TikTok Content', 'Latest updates from TikTok', NULL, NULL, NULL, NULL, 1, 1, 12, '2025-03-20 19:02:27', '2025-03-20 19:02:27'),
(11, 'instagram', 'Our Instagram Posts', 'Latest updates from Instagram', NULL, NULL, NULL, NULL, 1, 1, 13, '2025-03-20 19:03:17', '2025-03-20 19:03:17'),
(12, 'activities', 'Our Activities', 'Lebih dari Sekadar Produk, Ini Tentang Perjalanan Bersama', NULL, 'landing/images/onepage-bg-left.jpg', NULL, NULL, 1, 1, 3, '2025-03-21 11:40:43', '2025-03-21 11:40:43'),
(13, 'cta', 'Take Action Now!', 'Join us and upgrade your bike today!', 'Get the best spare parts and professional installation for your motorbike.', 'landing/images/background/parallax-bg-2.jpg', 'Chat Us!!', 'https://wa.me/08211990442', 1, 1, 11, '2025-03-21 11:52:50', '2025-03-21 11:52:50'),
(14, 'categories', 'WHAT WE OFFER', NULL, NULL, NULL, NULL, NULL, 1, 1, 3, '2025-04-21 06:47:43', '2025-04-21 06:47:43');

-- --------------------------------------------------------

--
-- Table structure for table `section_contents`
--

CREATE TABLE `section_contents` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section_id` bigint(20) UNSIGNED NOT NULL,
  `content_key` varchar(255) NOT NULL,
  `content_value` text DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'text',
  `extra_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`extra_data`)),
  `show_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `section_contents`
--

INSERT INTO `section_contents` (`id`, `section_id`, `content_key`, `content_value`, `type`, `extra_data`, `show_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Kualitas Terjamin', 'Produk unggulan untuk performa maksimal.', 'text', NULL, 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(2, 1, ' Pemasangan Mudah', 'Dirancang untuk presisi tanpa ribet.', 'text', NULL, 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(3, 1, 'Didesain untuk performa', 'Cocok untuk motor harian hingga modifikasi.', 'text', NULL, 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(4, 2, 'email', 'info@example.com', 'text', NULL, 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(5, 2, 'address', '123 Street Name, City, Country', 'text', NULL, 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(6, 2, 'postal_address', 'Cimahi, Bandung', 'text', NULL, 0, '2025-03-21 23:22:53', '2025-03-21 23:22:53'),
(7, 2, 'phone', '08211990442', 'text', NULL, 0, '2025-03-21 23:22:53', '2025-03-21 23:22:53'),
(8, 2, 'work_time_weekdays', 'Senin - Jumat : 08:00 - 17:00', 'text', NULL, 0, '2025-03-21 23:22:53', '2025-03-21 23:22:53'),
(9, 2, 'work_time_weekend', 'Sabtu - Minggu : 10:00 - 16:00', 'text', NULL, 0, '2025-03-21 23:22:53', '2025-03-21 23:22:53'),
(10, 3, 'Working Hours', '5600', 'number', NULL, 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(11, 3, 'Happy Clients', '220', 'number', NULL, 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(12, 3, 'Awards', '108', 'number', NULL, 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(13, 3, 'Projects a Year', '650', 'number', NULL, 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(14, 4, 'Beach Club', 'Print Design', 'image', '{\"image\": \"landing/images/portfolio/grid/1.jpg\", \"categories\": \"pemasangan, kolaborasi, event\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(15, 4, 'Be loved one', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/2.jpg\", \"categories\": \"modifikasi\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(16, 4, 'Salute to twins', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/3.jpg\", \"categories\": \"kolaborasi\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(17, 4, 'Tired eye', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/4.jpg\", \"categories\": \"event, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(18, 4, 'Welcome home', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/5.jpg\", \"categories\": \"modifikasi, event\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(19, 4, 'Repair and improve', 'Print Design', 'image', '{\"image\": \"landing/images/portfolio/grid/6.jpg\", \"categories\": \"modifikasi, perbaikan\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(20, 4, 'My bed room', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/7.jpg\", \"categories\": \"kolaborasi, event\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(21, 4, 'Saksi bisu', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/8.jpg\", \"categories\": \"event, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(22, 4, 'Sure, aku solo', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/9.jpg\", \"categories\": \"event\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(23, 4, 'Make it RED', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/10.jpg\", \"categories\": \"perbaikan, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(24, 4, 'Upgrading', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/11.jpg\", \"categories\": \"modifikasi, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(25, 5, 'Started', '{\"price\": \"0.99\", \"icon\": \"icofont-paper-plane\", \"features\": [\"512 GB Ram\", \"50 GB Disk\", \"1 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 11:23:12', '2025-03-20 11:23:12'),
(26, 5, 'Basic', '{\"price\": \"19.99\", \"icon\": \"icofont-light-bulb\", \"features\": [\"512 GB Ram\", \"80 GB Disk\", \"2 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 11:23:12', '2025-03-20 11:23:12'),
(27, 5, 'Standard', '{\"price\": \"39.99\", \"icon\": \"icofont-pen-alt-3\", \"features\": [\"768 GB Ram\", \"80 GB Disk\", \"3 User\", \"Full Data Security\", \"Unlimited Questions\", \"6TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 11:23:12', '2025-03-20 11:23:12'),
(28, 5, 'Pro', '{\"price\": \"49.99\", \"icon\": \"icofont-magic\", \"features\": [\"1 TB Ram\", \"1 TB Disk\", \"4 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 11:23:12', '2025-03-20 11:23:12'),
(29, 6, 'Installation Service', 'Professional and precise installation of motorbike parts by experienced technicians.', 'text', '{\"icon\": \"icofont-tools\"}', 0, '2025-03-20 11:24:18', '2025-03-20 11:24:18'),
(30, 6, 'Spare Parts Sales', 'Wide range of high-quality spare parts with guaranteed authenticity and competitive pricing.', 'text', '{\"icon\": \"icofont-motor-biker\"}', 0, '2025-03-20 11:24:18', '2025-03-20 11:24:18'),
(31, 6, 'Customization & Tuning', 'Upgrade your bike’s look and performance with our custom modification and tuning services.', 'text', '{\"icon\": \"icofont-gear-alt\"}', 0, '2025-03-20 11:24:18', '2025-03-20 11:24:18'),
(32, 6, 'Fast Delivery Service', 'Quick and reliable delivery for all your motorbike spare parts and accessories.', 'text', '{\"icon\": \"icofont-fast-delivery\"}', 0, '2025-03-20 11:24:18', '2025-03-20 11:24:18'),
(33, 7, 'Free Ongkir', 'selama bulan desember', 'image', '{\"image\": \"landing/images/team/team-1.jpg\", \"link\": \"#\"}', 0, '2025-03-20 11:25:06', '2025-03-20 11:25:06'),
(34, 7, 'Kusus Honda', 'diskon untuk mounting', 'image', '{\"image\": \"landing/images/team/team-2.jpg\", \"link\": \"#\"}', 0, '2025-03-20 11:25:06', '2025-03-20 11:25:06'),
(35, 7, 'Gratis Pasang', 's&k berlaku', 'image', '{\"image\": \"landing/images/team/team-3.jpg\", \"link\": \"#\"}', 0, '2025-03-20 11:25:06', '2025-03-20 11:25:06'),
(36, 7, 'Promo Bulan Ini', 'Perhatikan terus sosmed', 'image', '{\"image\": \"landing/images/team/team-4.jpg\", \"link\": \"#\"}', 0, '2025-03-20 11:25:06', '2025-03-20 11:25:06'),
(37, 8, 'krnawnaprl', 'KEREN BANGET MOUNTINGNYA KOK BISA SIH SE CENTER ITU MIN 😔☝🏻', 'text', '{\"image\": \"landing/images/team/team-1.jpg\", \"variation\": \"Aerox New, 7cm\"}', 0, '2025-03-20 11:25:39', '2025-03-20 11:25:39'),
(38, 8, 'syahrulrochman859', 'Thanks min, mountingnya bagus & center🔥', 'text', '{\"image\": \"landing/images/team/team-2.jpg\", \"variation\": \"Aerox New, 8cm\"}', 0, '2025-03-20 11:25:39', '2025-03-20 11:25:39'),
(39, 8, 'juned_alfied', 'mounting by boyprojects sangat pnp sekali ke kzr saya tanpa rubah apapun, benar-benar plug n play...', 'text', '{\"image\": \"landing/images/team/team-3.jpg\", \"variation\": \"5cm + bosh\"}', 0, '2025-03-20 11:25:39', '2025-03-20 11:25:39'),
(40, 8, 'nobodyjudgeme', 'Alhamdulillah barang terpasang dengan baik dan posisi center. Terimakasih omku', 'text', '{\"image\": \"landing/images/team/team-4.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-20 11:25:39', '2025-03-20 11:25:39'),
(41, 8, 'adidaengg', 'Mantapp, mounting nya aman 100% presisi, ga ada kendala sama sekali pas pemasangan.', 'text', '{\"image\": \"landing/images/team/team-5.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-20 11:25:39', '2025-03-20 11:25:39'),
(42, 8, 'harsanandarozzaqfirmansyah', 'mantab asli top lah boy! kaga miring samsek joss puas kali lah!', 'text', '{\"image\": \"landing/images/team/team-6.jpg\", \"variation\": \"3 cm\"}', 0, '2025-03-20 11:25:39', '2025-03-20 11:25:39'),
(43, 9, 'Ubah tampilan dan performa dengan berkualitas tinggi', 'Upgrade Your Ride, Elevate Your Style!', 'text', '{\"image\": \"landing/images/slides/home-bg-2.jpg\", \"description\": \"Kami menyediakan berbagai sparepart terbaik untuk motor matic dan sport.\", \"button_text\": \"Lihat Produk\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-20 11:37:27', '2025-03-20 11:37:27'),
(44, 9, 'Kami siap melayani!', 'Sparepart berkualitas, pemasangan presisi', 'text', '{\"image\": \"landing/images/slides/home-bg-1.jpg\", \"description\": \"Layanan pemasangan sparepart dengan teknisi berpengalaman.\", \"button_text\": \"Cek Layanan\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-20 11:37:27', '2025-03-20 11:37:27'),
(45, 10, 'TikTok Video 1', NULL, 'text', '{\"embed_url\": \"https://www.tiktok.com/@boyprojects/video/7482575523772779831\", \"video_id\": \"7482575523772779831\"}', 0, '2025-03-20 12:02:27', '2025-03-20 12:02:27'),
(46, 10, 'TikTok Video 2', NULL, 'text', '{\"embed_url\": \"https://www.tiktok.com/@boyprojects/photo/7483462663515753736\", \"video_id\": \"7483462663515753736\"}', 0, '2025-03-20 12:02:27', '2025-03-20 12:02:27'),
(47, 11, 'Instagram Post 1', NULL, 'text', '{\"embed_url\": \"https://www.instagram.com/p/DH3oGaVy9TO\"}', 0, '2025-03-20 12:03:17', '2025-03-20 12:03:17'),
(48, 11, 'Instagram Post 2', NULL, 'text', '{\"embed_url\": \"https://www.instagram.com/p/DId4T2hJVC\"}', 0, '2025-03-20 12:03:17', '2025-03-20 12:03:17'),
(49, 12, 'Workshop & Modifikasi', 'Mengikuti berbagai event otomotif dan modifikasi motor untuk menghadirkan inovasi terbaik.', 'text', '{\"icon\": \"icofont-trophy\"}', 0, '2025-03-21 04:41:07', '2025-03-21 04:45:41'),
(50, 12, 'Gathering & Riding Events', 'Berkolaborasi dengan komunitas riders dan penggemar otomotif dari seluruh Indonesia.', 'text', '{\"icon\": \"icofont-users\"}', 1, '2025-03-21 04:41:07', '2025-03-21 04:45:41'),
(51, 12, 'Online Webinars & Tips', 'Berbagi wawasan seputar perawatan, pemasangan, dan upgrade motor untuk performa maksimal.', 'text', '{\"icon\": \"icofont-tools\"}', 2, '2025-03-21 04:41:07', '2025-03-21 04:45:41'),
(52, 12, 'Networking & Partnership', 'Memperluas koneksi dengan sesama pecinta otomotif melalui berbagai acara eksklusif.', 'text', '{\"icon\": \"icofont-web\"}', 3, '2025-03-21 04:41:07', '2025-03-21 04:41:07'),
(53, 13, 'Upgrade Your Ride Today!', 'Get the best spare parts and professional installation for your motorbike.', 'text', NULL, 0, NULL, NULL),
(54, 14, 'LAMPU', '', 'image', '{\"image\": \"landing/images/categories/categories-1.png\", \"link\": \"https://shopee.co.id/boyprojectsasli?originalCategoryId=11043768#product_list\"}', 1, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(55, 14, 'MOUNTING', '', 'image', '{\"image\": \"landing/images/categories/categories-2.png\", \"link\": \"https://shopee.co.id/boyprojectsasli?originalCategoryId=11043764#product_list\"}', 1, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(56, 14, 'SERVICE', '', 'image', '{\"image\": \"landing/images/categories/default.png\", \"link\": \"\"}', 1, '2025-03-20 11:22:22', '2025-03-20 11:22:22'),
(57, 14, 'SOMETHING', '', 'image', '{\"image\": \"landing/images/categories/default.png\", \"link\": \"\"}', 1, '2025-03-20 11:22:22', '2025-03-20 11:22:22');

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
('f4iQGRznMXT1wA2I99lDp0O8AIITc1rG2xXETErI', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiNmtLcVBRV0N4enhvWnVSQXM3Rm1hOW52Q1lzblliQTRaN1h6alR4UyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mzc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9wcm9tb3Rpb24iO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjA6e319', 1746596959),
('woN959PknHvjbwkE8vadGmOj5IACaguAbAeyVG1j', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoialRkWTdrR1hETGdEQmNoSFZ3S3BldDAxR2diUEFNNHRVTTVoN3ZiZCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi90ZXN0aW1vbmlhbHMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjIyOiJQSFBERUJVR0JBUl9TVEFDS19EQVRBIjthOjA6e319', 1746625444);

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admin_email_unique` (`email`);

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
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `section_contents`
--
ALTER TABLE `section_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `section_contents`
--
ALTER TABLE `section_contents`
  ADD CONSTRAINT `section_contents_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `sections` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
