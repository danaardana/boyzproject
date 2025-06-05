-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 09:32 AM
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
  `name` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `last_login_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `security_code` varchar(8) DEFAULT NULL,
  `security_code_expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `is_active`, `verified`, `last_login_at`, `remember_token`, `security_code`, `security_code_expires_at`, `created_at`, `updated_at`) VALUES
(1, 'Rio A', 'rioardanaputra98@gmail.com', '$2y$12$w5EaJrzJ44WF8PLU27tm4O0IEIylUP/8o1KFh0HAlHffJPzvv.H1.', 1, 1, NULL, '20gpU3hkayo4K3207PStOQsUwTdTYVHw7TC9zCrb3JStKdzXcDtfHLXwxmrl', '2936AF44', '2025-06-04 01:59:29', '2025-06-02 23:58:12', '2025-06-04 00:59:29');

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
  `category` varchar(255) NOT NULL DEFAULT 'general',
  `last_update_time` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `customer_id`, `admin_id`, `content_key`, `content`, `status`, `is_read`, `category`, `last_update_time`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Product Inquiry', 'I would like to know more about your products.', 'new', 1, 'general', '2025-06-02 23:58:12', '2025-06-02 23:58:12', '2025-06-03 05:56:10'),
(2, 2, 1, 'Technical Support', 'I need help with installation.', 'in_progress', 1, 'installation', '2025-06-02 23:58:12', '2025-06-02 23:58:12', '2025-06-03 22:57:16'),
(3, 3, NULL, 'pemasangan', 'How??????????????????????', 'new', 1, 'pemasangan', '2025-06-04 07:49:23', '2025-06-04 07:49:23', '2025-06-04 08:00:49'),
(4, 3, NULL, 'lain', 'lagi', 'new', 0, 'lain', '2025-06-04 07:54:12', '2025-06-04 07:54:12', '2025-06-04 07:54:12'),
(5, 3, NULL, 'garansi', 'Di Boy Project, kami menghadirkan produk terbaik untuk meningkatkan performa dan estetika motor Anda. Setiap sparepart yang kami sediakan dipilih dengan cermat untuk memberikan kualitas, ketahanan, dan kenyamanan terbaik bagi para rider.', 'new', 0, 'garansi', '2025-06-04 07:59:27', '2025-06-04 07:59:27', '2025-06-04 07:59:27'),
(6, 1, NULL, 'pemasangan', 'aaaaaaaaaaaaaaaaaaaaa asdasasdasd asdadassdasdas asdasda asdas d', 'new', 0, 'pemasangan', '2025-06-04 08:11:13', '2025-06-04 08:11:13', '2025-06-04 08:11:13'),
(7, 1, NULL, 'garansi', 'Cimahi, Bandung\r\nPhone: 08211990442\r\nWhatsapp: 08211990442\r\ninfo@example.comCimahi, Bandung\r\nPhone: 08211990442\r\nWhatsapp: 08211990442\r\ninfo@example.com', 'new', 0, 'garansi', '2025-06-04 08:13:02', '2025-06-04 08:13:02', '2025-06-04 08:13:02'),
(8, 3, NULL, 'pemasangan', 'aaaaaaaa', 'new', 0, 'pemasangan', '2025-06-04 09:30:30', '2025-06-04 09:30:30', '2025-06-04 09:30:30'),
(9, 5, NULL, 'garansi', 'new new new new', 'new', 0, 'garansi', '2025-06-04 09:31:44', '2025-06-04 09:31:44', '2025-06-04 09:31:44');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `name`, `email`, `phone`, `address`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john@example.com', '1234567890', '123 Main St, City', '2025-06-02 23:58:12', '2025-06-02 23:58:12'),
(2, 'Jane Smith', 'jane@example.com', '0987654321', '456 Oak Ave, Town', '2025-06-02 23:58:12', '2025-06-02 23:58:12'),
(3, 'nama', 'rio@gmail.com', NULL, NULL, '2025-06-03 05:49:36', '2025-06-03 05:49:36'),
(4, 'Rio 1', 'rioardanaputra98@gmail.com', NULL, NULL, '2025-06-04 07:21:30', '2025-06-04 07:21:30'),
(5, 'New', 'admin@example.com', NULL, NULL, '2025-06-04 09:31:44', '2025-06-04 09:31:44');

-- --------------------------------------------------------

--
-- Table structure for table `message_responses`
--

CREATE TABLE `message_responses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `contact_message_id` bigint(20) UNSIGNED NOT NULL,
  `admin_id` bigint(20) UNSIGNED NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `message_responses`
--

INSERT INTO `message_responses` (`id`, `contact_message_id`, `admin_id`, `message`, `created_at`) VALUES
(1, 1, 1, 'I will help you', '2025-06-04 05:55:58');

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
(4, '2024_03_20_create_admins_table', 1),
(5, '2024_03_20_create_customers_table', 1),
(6, '2024_03_21_create_contact_messages_table', 1),
(7, '2025_03_19_020014_create_sections_table', 1),
(8, '2025_03_19_020015_create_section_contents_table', 1),
(9, '2025_06_03_052802_add_security_code_to_admins_table', 1),
(10, '2024_03_22_add_is_read_to_contact_messages', 2),
(11, '2024_03_21_create_predefined_messages_table', 3),
(12, '2025_06_04_054649_create_message_responses_table', 4),
(13, '2025_06_04_054905_remove_extra_data_from_contact_messages_table', 5),
(14, '2025_06_04_060348_remove_updated_at_from_message_responses', 6),
(15, '2025_06_04_060357_drop_users_table', 6),
(16, '2025_06_04_060852_update_admin_table_column_sizes', 7),
(17, '2025_06_04_061203_add_verified_column_to_admins_table', 8),
(18, '2025_06_04_062113_remove_department_and_permissions_from_admins_table', 9);

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
(1, 'about', 'Redefining Performance', 'Lebih dari Sekadar Sparepart, Ini Tentang Pengalaman Berkendara', 'Di Boy Project, kami menghadirkan produk terbaik untuk meningkatkan performa dan estetika motor Anda. Setiap sparepart yang kami sediakan dipilih dengan cermat untuk memberikan kualitas, ketahanan, dan kenyamanan terbaik bagi para rider.', 'landing/images/startup-bg.jpg', NULL, NULL, 1, 1, 2, '2025-03-20 11:21:56', '2025-06-03 06:08:33'),
(2, 'contact', 'Contact Us', '- Stay in Touch -', NULL, NULL, NULL, NULL, 1, 1, 8, '2025-03-20 11:21:56', '2025-03-20 11:21:56'),
(3, 'counter', 'Our Achievements', 'We have achieved great milestones over the years.', NULL, NULL, NULL, NULL, 1, 1, 6, '2025-03-20 11:21:56', '2025-03-20 11:21:56'),
(4, 'portofolio', 'Our Work', 'Explore our best projects in various categories.', NULL, NULL, NULL, NULL, 1, 1, 7, '2025-03-20 11:21:56', '2025-03-20 11:21:56'),
(5, 'pricing', 'Our Pricing', '- Choose Your Plan -', NULL, NULL, NULL, NULL, 1, 1, 10, '2025-03-20 11:23:12', '2025-03-20 11:23:12'),
(6, 'services', 'Apa yang Kami Tawarkan', '- Enhancing Your Performance -', NULL, NULL, NULL, NULL, 1, 1, 4, '2025-03-20 11:24:18', '2025-03-20 11:24:18'),
(7, 'promotion', 'NEW PRODUCTS', 'get promotion info', NULL, NULL, NULL, NULL, 1, 2, 5, '2025-03-20 11:25:06', '2025-03-20 11:25:06'),
(8, 'testimonials', 'Testimonials', '- Happy Clients -', NULL, NULL, NULL, NULL, 1, 1, 9, '2025-03-20 11:25:39', '2025-03-20 11:25:39'),
(9, 'home', 'Welcome to Boys Project', 'Jual beli sparepart motor & pemasangan terpercaya', NULL, NULL, NULL, NULL, 1, 1, 1, '2025-03-20 11:37:27', '2025-06-03 06:15:56'),
(10, 'tiktok', 'Our TikTok Content', 'Latest updates from TikTok', NULL, NULL, NULL, NULL, 1, 1, 12, '2025-03-20 12:02:27', '2025-03-20 12:02:27'),
(11, 'instagram', 'Our Instagram Posts', 'Latest updates from Instagram', NULL, NULL, NULL, NULL, 1, 1, 13, '2025-03-20 12:03:17', '2025-03-20 12:03:17'),
(12, 'activities', 'Our Activities', 'Lebih dari Sekadar Produk, Ini Tentang Perjalanan Bersama', NULL, 'landing/images/onepage-bg-left.jpg', NULL, NULL, 1, 1, 3, '2025-03-21 04:40:43', '2025-03-21 04:40:43'),
(13, 'cta', 'Take Action Now!', 'Join us and upgrade your bike today!', 'Get the best spare parts and professional installation for your motorbike.', 'landing/images/background/parallax-bg-2.jpg', 'Chat Us!!', 'https://wa.me/08211990442', 1, 1, 11, '2025-03-21 04:52:50', '2025-03-21 04:52:50'),
(14, 'categories', 'WHAT WE OFFER', NULL, NULL, NULL, NULL, NULL, 1, 1, 3, '2025-04-20 23:47:43', '2025-04-20 23:47:43');

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
(1, 1, 'Kualitas Terjamin', 'Produk unggulan untuk performa maksimal.', 'text', NULL, 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(2, 1, ' Pemasangan Mudah', 'Dirancang untuk presisi tanpa ribet.', 'text', NULL, 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(3, 1, 'Didesain untuk performa', 'Cocok untuk motor harian hingga modifikasi.', 'text', NULL, 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(4, 2, 'email', 'info@example.com', 'text', NULL, 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(5, 2, 'address', '123 Street Name, City, Country', 'text', NULL, 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(6, 2, 'postal_address', 'Cimahi, Bandung', 'text', NULL, 0, '2025-03-21 16:22:53', '2025-03-21 16:22:53'),
(7, 2, 'phone', '08211990442', 'text', NULL, 0, '2025-03-21 16:22:53', '2025-03-21 16:22:53'),
(8, 2, 'work_time_weekdays', 'Senin - Jumat : 08:00 - 17:00', 'text', NULL, 0, '2025-03-21 16:22:53', '2025-03-21 16:22:53'),
(9, 2, 'work_time_weekend', 'Sabtu - Minggu : 10:00 - 16:00', 'text', NULL, 0, '2025-03-21 16:22:53', '2025-03-21 16:22:53'),
(10, 3, 'Working Hours', '5600', 'number', NULL, 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(11, 3, 'Happy Clients', '220', 'number', NULL, 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(12, 3, 'Awards', '108', 'number', NULL, 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(13, 3, 'Projects a Year', '650', 'number', NULL, 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(14, 4, 'Beach Club', 'Print Design', 'image', '{\"image\": \"landing/images/portfolio/grid/1.jpg\", \"categories\": \"pemasangan, kolaborasi, event\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(15, 4, 'Be loved one', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/2.jpg\", \"categories\": \"modifikasi\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(16, 4, 'Salute to twins', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/3.jpg\", \"categories\": \"kolaborasi\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(17, 4, 'Tired eye', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/4.jpg\", \"categories\": \"event, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(18, 4, 'Welcome home', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/5.jpg\", \"categories\": \"modifikasi, event\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(19, 4, 'Repair and improve', 'Print Design', 'image', '{\"image\": \"landing/images/portfolio/grid/6.jpg\", \"categories\": \"modifikasi, perbaikan\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(20, 4, 'My bed room', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/7.jpg\", \"categories\": \"kolaborasi, event\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(21, 4, 'Saksi bisu', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/8.jpg\", \"categories\": \"event, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(22, 4, 'Sure, aku solo', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/9.jpg\", \"categories\": \"event\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(23, 4, 'Make it RED', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/10.jpg\", \"categories\": \"perbaikan, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(24, 4, 'Upgrading', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/11.jpg\", \"categories\": \"modifikasi, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(25, 5, 'Started', '{\"price\": \"0.99\", \"icon\": \"icofont-paper-plane\", \"features\": [\"512 GB Ram\", \"50 GB Disk\", \"1 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 04:23:12', '2025-03-20 04:23:12'),
(26, 5, 'Basic', '{\"price\": \"19.99\", \"icon\": \"icofont-light-bulb\", \"features\": [\"512 GB Ram\", \"80 GB Disk\", \"2 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 04:23:12', '2025-03-20 04:23:12'),
(27, 5, 'Standard', '{\"price\": \"39.99\", \"icon\": \"icofont-pen-alt-3\", \"features\": [\"768 GB Ram\", \"80 GB Disk\", \"3 User\", \"Full Data Security\", \"Unlimited Questions\", \"6TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 04:23:12', '2025-03-20 04:23:12'),
(28, 5, 'Pro', '{\"price\": \"49.99\", \"icon\": \"icofont-magic\", \"features\": [\"1 TB Ram\", \"1 TB Disk\", \"4 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 04:23:12', '2025-03-20 04:23:12'),
(29, 6, 'Installation Service', 'Professional and precise installation of motorbike parts by experienced technicians.', 'text', '{\"icon\": \"icofont-tools\"}', 0, '2025-03-20 04:24:18', '2025-03-20 04:24:18'),
(30, 6, 'Spare Parts Sales', 'Wide range of high-quality spare parts with guaranteed authenticity and competitive pricing.', 'text', '{\"icon\": \"icofont-motor-biker\"}', 0, '2025-03-20 04:24:18', '2025-03-20 04:24:18'),
(31, 6, 'Customization & Tuning', 'Upgrade your bike’s look and performance with our custom modification and tuning services.', 'text', '{\"icon\": \"icofont-gear-alt\"}', 0, '2025-03-20 04:24:18', '2025-03-20 04:24:18'),
(32, 6, 'Fast Delivery Service', 'Quick and reliable delivery for all your motorbike spare parts and accessories.', 'text', '{\"icon\": \"icofont-fast-delivery\"}', 0, '2025-03-20 04:24:18', '2025-03-20 04:24:18'),
(33, 7, 'Free Ongkir', 'selama bulan desember', 'image', '{\"image\": \"landing/images/team/team-1.jpg\", \"link\": \"#\"}', 0, '2025-03-20 04:25:06', '2025-03-20 04:25:06'),
(34, 7, 'Kusus Honda', 'diskon untuk mounting', 'image', '{\"image\": \"landing/images/team/team-2.jpg\", \"link\": \"#\"}', 0, '2025-03-20 04:25:06', '2025-03-20 04:25:06'),
(35, 7, 'Gratis Pasang', 's&k berlaku', 'image', '{\"image\": \"landing/images/team/team-3.jpg\", \"link\": \"#\"}', 0, '2025-03-20 04:25:06', '2025-03-20 04:25:06'),
(36, 7, 'Promo Bulan Ini', 'Perhatikan terus sosmed', 'image', '{\"image\": \"landing/images/team/team-4.jpg\", \"link\": \"#\"}', 0, '2025-03-20 04:25:06', '2025-03-20 04:25:06'),
(37, 8, 'krnawnaprl', 'KEREN BANGET MOUNTINGNYA KOK BISA SIH SE CENTER ITU MIN 😔☝🏻', 'text', '{\"image\": \"landing/images/team/team-1.jpg\", \"variation\": \"Aerox New, 7cm\"}', 0, '2025-03-20 04:25:39', '2025-03-20 04:25:39'),
(38, 8, 'syahrulrochman859', 'Thanks min, mountingnya bagus & center🔥', 'text', '{\"image\": \"landing/images/team/team-2.jpg\", \"variation\": \"Aerox New, 8cm\"}', 0, '2025-03-20 04:25:39', '2025-03-20 04:25:39'),
(39, 8, 'juned_alfied', 'mounting by boyprojects sangat pnp sekali ke kzr saya tanpa rubah apapun, benar-benar plug n play...', 'text', '{\"image\": \"landing/images/team/team-3.jpg\", \"variation\": \"5cm + bosh\"}', 0, '2025-03-20 04:25:39', '2025-03-20 04:25:39'),
(40, 8, 'nobodyjudgeme', 'Alhamdulillah barang terpasang dengan baik dan posisi center. Terimakasih omku', 'text', '{\"image\": \"landing/images/team/team-4.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-20 04:25:39', '2025-03-20 04:25:39'),
(41, 8, 'adidaengg', 'Mantapp, mounting nya aman 100% presisi, ga ada kendala sama sekali pas pemasangan.', 'text', '{\"image\": \"landing/images/team/team-5.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-20 04:25:39', '2025-03-20 04:25:39'),
(42, 8, 'harsanandarozzaqfirmansyah', 'mantab asli top lah boy! kaga miring samsek joss puas kali lah!', 'text', '{\"image\": \"landing/images/team/team-6.jpg\", \"variation\": \"3 cm\"}', 0, '2025-03-20 04:25:39', '2025-03-20 04:25:39'),
(43, 9, 'Ubah tampilan dan performa dengan berkualitas tinggi', 'Upgrade Your Ride, Elevate Your Style!', 'text', '{\"image\": \"landing/images/slides/home-bg-2.jpg\", \"description\": \"Kami menyediakan berbagai sparepart terbaik untuk motor matic dan sport.\", \"button_text\": \"Lihat Produk\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-20 04:37:27', '2025-03-20 04:37:27'),
(44, 9, 'Kami siap melayani!', 'Sparepart berkualitas, pemasangan presisi', 'text', '{\"image\": \"landing/images/slides/home-bg-1.jpg\", \"description\": \"Layanan pemasangan sparepart dengan teknisi berpengalaman.\", \"button_text\": \"Cek Layanan\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-20 04:37:27', '2025-03-20 04:37:27'),
(45, 10, 'TikTok Video 1', NULL, 'text', '{\"embed_url\": \"https://www.tiktok.com/@boyprojects/video/7482575523772779831\", \"video_id\": \"7482575523772779831\"}', 0, '2025-03-20 05:02:27', '2025-03-20 05:02:27'),
(46, 10, 'TikTok Video 2', NULL, 'text', '{\"embed_url\": \"https://www.tiktok.com/@boyprojects/photo/7483462663515753736\", \"video_id\": \"7483462663515753736\"}', 0, '2025-03-20 05:02:27', '2025-03-20 05:02:27'),
(47, 11, 'Instagram Post 1', NULL, 'text', '{\"embed_url\": \"https://www.instagram.com/p/DH3oGaVy9TO\"}', 0, '2025-03-20 05:03:17', '2025-03-20 05:03:17'),
(48, 11, 'Instagram Post 2', NULL, 'text', '{\"embed_url\": \"https://www.instagram.com/p/DId4T2hJVC\"}', 0, '2025-03-20 05:03:17', '2025-03-20 05:03:17'),
(49, 12, 'Workshop & Modifikasi', 'Mengikuti berbagai event otomotif dan modifikasi motor untuk menghadirkan inovasi terbaik.', 'text', '{\"icon\": \"icofont-trophy\"}', 0, '2025-03-20 21:41:07', '2025-03-20 21:45:41'),
(50, 12, 'Gathering & Riding Events', 'Berkolaborasi dengan komunitas riders dan penggemar otomotif dari seluruh Indonesia.', 'text', '{\"icon\": \"icofont-users\"}', 1, '2025-03-20 21:41:07', '2025-03-20 21:45:41'),
(51, 12, 'Online Webinars & Tips', 'Berbagi wawasan seputar perawatan, pemasangan, dan upgrade motor untuk performa maksimal.', 'text', '{\"icon\": \"icofont-tools\"}', 2, '2025-03-20 21:41:07', '2025-03-20 21:45:41'),
(52, 12, 'Networking & Partnership', 'Memperluas koneksi dengan sesama pecinta otomotif melalui berbagai acara eksklusif.', 'text', '{\"icon\": \"icofont-web\"}', 3, '2025-03-20 21:41:07', '2025-03-20 21:41:07'),
(53, 13, 'Upgrade Your Ride Today!', 'Get the best spare parts and professional installation for your motorbike.', 'text', NULL, 0, NULL, NULL),
(54, 14, 'LAMPU', '', 'image', '{\"image\": \"landing/images/categories/categories-1.png\", \"link\": \"https://shopee.co.id/boyprojectsasli?originalCategoryId=11043768#product_list\"}', 1, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(55, 14, 'MOUNTING', '', 'image', '{\"image\": \"landing/images/categories/categories-2.png\", \"link\": \"https://shopee.co.id/boyprojectsasli?originalCategoryId=11043764#product_list\"}', 1, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(56, 14, 'SERVICE', '', 'image', '{\"image\": \"landing/images/categories/default.png\", \"link\": \"\"}', 1, '2025-03-20 04:22:22', '2025-03-20 04:22:22'),
(57, 14, 'SOMETHING', '', 'image', '{\"image\": \"landing/images/categories/default.png\", \"link\": \"\"}', 1, '2025-03-20 04:22:22', '2025-03-20 04:22:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `admins_email_unique` (`email`),
  ADD KEY `admins_email_is_active_index` (`email`,`is_active`);

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
  ADD KEY `customers_email_index` (`email`),
  ADD KEY `customers_phone_index` (`phone`);

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `message_responses`
--
ALTER TABLE `message_responses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `predefined_messages`
--
ALTER TABLE `predefined_messages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
