-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 24, 2025 at 05:11 PM
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

(1, 1, 'Kualitas Terjamin', 'Produk unggulan untuk performa maksimal.', 'text', NULL, 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(2, 1, ' Pemasangan Mudah', 'Dirancang untuk presisi tanpa ribet.', 'text', NULL, 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(3, 1, 'Didesain untuk performa', 'Cocok untuk motor harian hingga modifikasi.', 'text', NULL, 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(4, 2, 'email', 'info@example.com', 'text', NULL, 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),

(5, 2, 'address', '123 Street Name, City, Country', 'text', NULL, 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(6, 2, 'postal_address', 'Cimahi, Bandung', 'text', NULL, 0, '2025-03-22 06:22:53', '2025-03-22 06:22:53'),
(7, 2, 'phone', '08211990442', 'text', NULL, 0, '2025-03-22 06:22:53', '2025-03-22 06:22:53'),
(8, 2, 'work_time_weekdays', 'Senin - Jumat : 08:00 - 17:00', 'text', NULL, 0, '2025-03-22 06:22:53', '2025-03-22 06:22:53'),
(9, 2, 'work_time_weekend', 'Sabtu - Minggu : 10:00 - 16:00', 'text', NULL, 0, '2025-03-22 06:22:53', '2025-03-22 06:22:53'),

(10, 3, 'Working Hours', '5600', 'number', NULL, 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(11, 3, 'Happy Clients', '220', 'number', NULL, 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(12, 3, 'Awards', '108', 'number', NULL, 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(13, 3, 'Projects a Year', '650', 'number', NULL, 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),

(14, 4, 'Beach Club', 'Print Design', 'image', '{\"image\": \"landing/images/portfolio/grid/1.jpg\", \"categories\": \"pemasangan, kolaborasi, event\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(15, 4, 'Be loved one', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/2.jpg\", \"categories\": \"modifikasi\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(16, 4, 'Salute to twins', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/3.jpg\", \"categories\": \"kolaborasi\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(17, 4, 'Tired eye', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/4.jpg\", \"categories\": \"event, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(18, 4, 'Welcome home', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/5.jpg\", \"categories\": \"modifikasi, event\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(19, 4, 'Repair and improve', 'Print Design', 'image', '{\"image\": \"landing/images/portfolio/grid/6.jpg\", \"categories\": \"modifikasi, perbaikan\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(20, 4, 'My bed room', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/7.jpg\", \"categories\": \"kolaborasi, event\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(21, 4, 'Saksi bisu', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/8.jpg\", \"categories\": \"event, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(22, 4, 'Sure, aku solo', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/9.jpg\", \"categories\": \"event\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(23, 4, 'Make it RED', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/10.jpg\", \"categories\": \"perbaikan, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),
(24, 4, 'Upgrading', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/11.jpg\", \"categories\": \"modifikasi, pemasangan\", \"link\": \"#\"}', 0, '2025-03-20 18:22:22', '2025-03-20 18:22:22'),

(25, 5, 'Started', '{\"price\": \"0.99\", \"icon\": \"icofont-paper-plane\", \"features\": [\"512 GB Ram\", \"50 GB Disk\", \"1 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 18:23:12', '2025-03-20 18:23:12'),
(26, 5, 'Basic', '{\"price\": \"19.99\", \"icon\": \"icofont-light-bulb\", \"features\": [\"512 GB Ram\", \"80 GB Disk\", \"2 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 18:23:12', '2025-03-20 18:23:12'),
(27, 5, 'Standard', '{\"price\": \"39.99\", \"icon\": \"icofont-pen-alt-3\", \"features\": [\"768 GB Ram\", \"80 GB Disk\", \"3 User\", \"Full Data Security\", \"Unlimited Questions\", \"6TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 18:23:12', '2025-03-20 18:23:12'),
(28, 5, 'Pro', '{\"price\": \"49.99\", \"icon\": \"icofont-magic\", \"features\": [\"1 TB Ram\", \"1 TB Disk\", \"4 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-20 18:23:12', '2025-03-20 18:23:12'),

(29, 6, 'Installation Service', 'Professional and precise installation of motorbike parts by experienced technicians.', 'text', '{\"icon\": \"icofont-tools\"}', 0, '2025-03-20 18:24:18', '2025-03-20 18:24:18'),
(30, 6, 'Spare Parts Sales', 'Wide range of high-quality spare parts with guaranteed authenticity and competitive pricing.', 'text', '{\"icon\": \"icofont-motor-biker\"}', 0, '2025-03-20 18:24:18', '2025-03-20 18:24:18'),
(31, 6, 'Customization & Tuning', 'Upgrade your bike’s look and performance with our custom modification and tuning services.', 'text', '{\"icon\": \"icofont-gear-alt\"}', 0, '2025-03-20 18:24:18', '2025-03-20 18:24:18'),
(32, 6, 'Fast Delivery Service', 'Quick and reliable delivery for all your motorbike spare parts and accessories.', 'text', '{\"icon\": \"icofont-fast-delivery\"}', 0, '2025-03-20 18:24:18', '2025-03-20 18:24:18'),

(33, 7, 'Randy Bell', 'UI/UX Designer', 'text', '{\"image\": \"landing/images/team/team-01.jpg\", \"social_links\": {\"icofont-facebook\": \"#\", \"icofont-twitter\": \"#\", \"fa-youtube\": \"#\"}}', 0, '2025-03-20 18:25:06', '2025-03-20 18:25:06'),
(34, 7, 'Alice Andrews', 'Photographer', 'text', '{\"image\": \"landing/images/team/team-02.jpg\", \"social_links\": {\"icofont-facebook\": \"#\", \"icofont-twitter\": \"#\", \"fa-youtube\": \"#\"}}', 0, '2025-03-20 18:25:06', '2025-03-20 18:25:06'),
(35, 7, 'Nicholas Hart', 'Web Developer', 'text', '{\"image\": \"landing/images/team/team-03.jpg\", \"social_links\": {\"icofont-facebook\": \"#\", \"icofont-twitter\": \"#\", \"fa-youtube\": \"#\"}}', 0, '2025-03-20 18:25:06', '2025-03-20 18:25:06'),
(36, 7, 'Grace Ross', 'CEO/Founder', 'text', '{\"image\": \"landing/images/team/team-04.jpg\", \"social_links\": {\"icofont-facebook\": \"#\", \"icofont-twitter\": \"#\", \"fa-youtube\": \"#\"}}', 0, '2025-03-20 18:25:06', '2025-03-20 18:25:06'),

(37, 8, 'krnawnaprl', 'KEREN BANGET MOUNTINGNYA KOK BISA SIH SE CENTER ITU MIN 😔☝🏻', 'text', '{\"image\": \"landing/images/team/avatar-1.jpg\", \"variation\": \"Aerox New, 7cm\"}', 0, '2025-03-20 18:25:39', '2025-03-20 18:25:39'),
(38, 8, 'syahrulrochman859', 'Thanks min, mountingnya bagus & center🔥', 'text', '{\"image\": \"landing/images/team/avatar-2.jpg\", \"variation\": \"Aerox New, 8cm\"}', 0, '2025-03-20 18:25:39', '2025-03-20 18:25:39'),
(39, 8, 'juned_alfied', 'mounting by boyprojects sangat pnp sekali ke kzr saya tanpa rubah apapun, benar-benar plug n play...', 'text', '{\"image\": \"landing/images/team/avatar-3.jpg\", \"variation\": \"5cm + bosh\"}', 0, '2025-03-20 18:25:39', '2025-03-20 18:25:39'),
(40, 8, 'nobodyjudgeme', 'Alhamdulillah barang terpasang dengan baik dan posisi center. Terimakasih omku', 'text', '{\"image\": \"landing/images/team/avatar-4.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-20 18:25:39', '2025-03-20 18:25:39'),
(41, 8, 'adidaengg', 'Mantapp, mounting nya aman 100% presisi, ga ada kendala sama sekali pas pemasangan.', 'text', '{\"image\": \"landing/images/team/avatar-5.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-20 18:25:39', '2025-03-20 18:25:39'),
(42, 8, 'harsanandarozzaqfirmansyah', 'mantab asli top lah boy! kaga miring samsek joss puas kali lah!', 'text', '{\"image\": \"landing/images/team/avatar-6.jpg\", \"variation\": \"3 cm\"}', 0, '2025-03-20 18:25:39', '2025-03-20 18:25:39'),

(43, 9, 'Ubah tampilan dan performa dengan berkualitas tinggi', 'Upgrade Your Ride, Elevate Your Style!', 'text', '{\"image\": \"landing/images/slides/home-bg-2.jpg\", \"description\": \"Kami menyediakan berbagai sparepart terbaik untuk motor matic dan sport.\", \"button_text\": \"Lihat Produk\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-20 18:37:27', '2025-03-20 18:37:27'),
(44, 9, 'Kami siap melayani!', 'Sparepart berkualitas, pemasangan presisi', 'text', '{\"image\": \"landing/images/slides/home-bg-1.jpg\", \"description\": \"Layanan pemasangan sparepart dengan teknisi berpengalaman.\", \"button_text\": \"Cek Layanan\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-20 18:37:27', '2025-03-20 18:37:27'),

(45, 10, 'TikTok Video 1', NULL, 'text', '{\"embed_url\": \"https://www.tiktok.com/@boyprojects/video/7482575523772779831\", \"video_id\": \"7482575523772779831\"}', 0, '2025-03-20 19:02:27', '2025-03-20 19:02:27'),
(46, 10, 'TikTok Video 2', NULL, 'text', '{\"embed_url\": \"https://www.tiktok.com/@boyprojects/photo/7483462663515753736\", \"video_id\": \"7483462663515753736\"}', 0, '2025-03-20 19:02:27', '2025-03-20 19:02:27'),

(47, 11, 'Instagram Post 1', NULL, 'text', '{\"embed_url\": \"https://www.instagram.com/p/XYZ123/\"}', 0, '2025-03-20 19:03:17', '2025-03-20 19:03:17'),
(48, 11, 'Instagram Post 2', NULL, 'text', '{\"embed_url\": \"https://www.instagram.com/p/ABC789/\"}', 0, '2025-03-20 19:03:17', '2025-03-20 19:03:17'),

(49, 12, 'Workshop & Modifikasi', 'Mengikuti berbagai event otomotif dan modifikasi motor untuk menghadirkan inovasi terbaik.', 'text', '{\"icon\": \"icofont-trophy\"}', 0, '2025-03-21 11:41:07', '2025-03-21 11:45:41'),
(50, 12, 'Gathering & Riding Events', 'Berkolaborasi dengan komunitas riders dan penggemar otomotif dari seluruh Indonesia.', 'text', '{\"icon\": \"icofont-users\"}', 1, '2025-03-21 11:41:07', '2025-03-21 11:45:41'),
(51, 12, 'Online Webinars & Tips', 'Berbagi wawasan seputar perawatan, pemasangan, dan upgrade motor untuk performa maksimal.', 'text', '{\"icon\": \"icofont-tools\"}', 2, '2025-03-21 11:41:07', '2025-03-21 11:45:41'),
(52, 12, 'Networking & Partnership', 'Memperluas koneksi dengan sesama pecinta otomotif melalui berbagai acara eksklusif.', 'text', '{\"icon\": \"icofont-web\"}', 3, '2025-03-21 11:41:07', '2025-03-21 11:41:07'),

(53, 13, 'Upgrade Your Ride Today!', 'Get the best spare parts and professional installation for your motorbike.', 'text', NULL, 0, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `section_contents`
--
ALTER TABLE `section_contents`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_contents_section_id_foreign` (`section_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `section_contents`
--
ALTER TABLE `section_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
