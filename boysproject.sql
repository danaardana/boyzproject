-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 21, 2025 at 10:18 AM
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
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `content` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `button_text` varchar(255) DEFAULT NULL,
  `button_link` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `show_order` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `title`, `description`, `content`, `image`, `button_text`, `button_link`, `is_active`, `show_order`, `created_at`, `updated_at`) VALUES
(1, 'about', 'What We Do', 'We develop big ideas that sell', 'We are a fully in-house digital agency focusing on branding, marketing, web design and development with clients ranging from start-ups. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed varius quam ut magna ultricies pellentesque.', 'landing/images/startup-bg.jpg', NULL, NULL, 1, 0, '2025-03-21 01:21:56', '2025-03-21 01:21:56'),
(2, 'contact', 'Contact Us', '- Stay in Touch -', NULL, NULL, NULL, NULL, 1, 0, '2025-03-21 01:21:56', '2025-03-21 01:21:56'),
(3, 'counter', 'Our Achievements', 'We have achieved great milestones over the years.', NULL, NULL, NULL, NULL, 1, 0, '2025-03-21 01:21:56', '2025-03-21 01:21:56'),
(4, 'portofolio', 'Our Work', 'Explore our best projects in various categories.', NULL, NULL, NULL, NULL, 1, 0, '2025-03-21 01:21:56', '2025-03-21 01:21:56'),
(5, 'pricing', 'Our Pricing', '- Choose Your Plan -', NULL, NULL, NULL, NULL, 1, 0, '2025-03-21 01:23:12', '2025-03-21 01:23:12'),
(6, 'services', 'Our Services', '- Design your presence -', NULL, NULL, NULL, NULL, 1, 0, '2025-03-21 01:24:18', '2025-03-21 01:24:18'),
(7, 'team', 'Meet Our Team', '- We Are Stronger -', NULL, NULL, NULL, NULL, 1, 0, '2025-03-21 01:25:06', '2025-03-21 01:25:06'),
(8, 'testimonials', 'Testimonials', '- Happy Clients -', NULL, NULL, NULL, NULL, 1, 0, '2025-03-21 01:25:39', '2025-03-21 01:25:39'),
(9, 'who', 'Who We Are', '- The way we work is fun -', '', '', NULL, NULL, 1, 0, '2025-03-21 01:27:46', '2025-03-21 01:27:46'),
(10, 'home', 'Welcome to Boys Project', 'Jual beli sparepart motor & pemasangan terpercaya', NULL, NULL, NULL, NULL, 1, 1, '2025-03-21 01:37:27', '2025-03-21 01:37:27'),
(11, 'tiktok', 'Our TikTok Content', 'Latest updates from TikTok', NULL, NULL, NULL, NULL, 1, 8, '2025-03-21 02:02:27', '2025-03-21 02:02:27'),
(12, 'instagram', 'Our Instagram Posts', 'Latest updates from Instagram', NULL, NULL, NULL, NULL, 1, 9, '2025-03-21 02:03:17', '2025-03-21 02:03:17');

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
(1, 1, 'Creative Design', 'Designing a good website that accommodates a lot of content is a tricky balancing act to pull off.', 'text', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(2, 1, 'Web Development', 'We build mobile apps for the conference, integrating unique content and branding to create.', 'text', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(3, 1, 'Marketing Support', 'Google has made this important since 1998 when it launched. Content became, and still is king since websites.', 'text', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(4, 2, 'email', 'info@example.com', 'text', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(5, 2, 'phone', '+1234567890', 'text', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(6, 2, 'address', '123 Street Name, City, Country', 'text', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(7, 3, 'Working Hours', '5600', 'number', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(8, 3, 'Happy Clients', '220', 'number', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(9, 3, 'Awards', '108', 'number', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(10, 3, 'Projects a Year', '650', 'number', NULL, 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(11, 4, 'Business Cards', 'Print Design', 'image', '{\"image\": \"landing/images/portfolio/grid/1.jpg\", \"categories\": \"print, branding\", \"link\": \"#\"}', 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(12, 4, 'Magazine', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/2.jpg\", \"categories\": \"branding\", \"link\": \"#\"}', 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(13, 4, 'Rabycad CD Design', 'Branding', 'image', '{\"image\": \"landing/images/portfolio/grid/3.jpg\", \"categories\": \"branding\", \"link\": \"#\"}', 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(14, 4, 'Micro Chips', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/4.jpg\", \"categories\": \"web, design\", \"link\": \"#\"}', 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(15, 4, 'Flat Web Design', 'Web Design', 'image', '{\"image\": \"landing/images/portfolio/grid/5.jpg\", \"categories\": \"print, web\", \"link\": \"#\"}', 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(16, 4, 'Flyer Design', 'Print Design', 'image', '{\"image\": \"landing/images/portfolio/grid/6.jpg\", \"categories\": \"design\", \"link\": \"#\"}', 0, '2025-03-21 01:22:22', '2025-03-21 01:22:22'),
(17, 5, 'Started', '{\"price\": \"0.99\", \"icon\": \"icofont-paper-plane\", \"features\": [\"512 GB Ram\", \"50 GB Disk\", \"1 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-21 01:23:12', '2025-03-21 01:23:12'),
(18, 5, 'Basic', '{\"price\": \"19.99\", \"icon\": \"icofont-light-bulb\", \"features\": [\"512 GB Ram\", \"80 GB Disk\", \"2 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-21 01:23:12', '2025-03-21 01:23:12'),
(19, 5, 'Standard', '{\"price\": \"39.99\", \"icon\": \"icofont-pen-alt-3\", \"features\": [\"768 GB Ram\", \"80 GB Disk\", \"3 User\", \"Full Data Security\", \"Unlimited Questions\", \"6TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-21 01:23:12', '2025-03-21 01:23:12'),
(20, 5, 'Pro', '{\"price\": \"49.99\", \"icon\": \"icofont-magic\", \"features\": [\"1 TB Ram\", \"1 TB Disk\", \"4 User\", \"4TB Bandwidth\"]}', 'json', NULL, 0, '2025-03-21 01:23:12', '2025-03-21 01:23:12'),
(21, 6, 'Web Design', 'Designing a good website that accommodates a lot of content is a tricky balancing act to pull off.', 'text', '{\"icon\": \"icofont-world\"}', 0, '2025-03-21 01:24:18', '2025-03-21 01:24:18'),
(22, 6, 'App Development', 'We build mobile apps for the conference, integrating unique content and branding to create.', 'text', '{\"icon\": \"icofont-paint\"}', 0, '2025-03-21 01:24:18', '2025-03-21 01:24:18'),
(23, 6, 'Digital Marketing', 'Google has made this important since 1998 when it launched. Content became, and still is king since websites.', 'text', '{\"icon\": \"icofont-paper-plane\"}', 0, '2025-03-21 01:24:18', '2025-03-21 01:24:18'),
(24, 6, 'UI / UX Friendly', 'UX design refers to the term user experience design, while UI design stands for user interface design.', 'text', '{\"icon\": \"icofont-magic\"}', 0, '2025-03-21 01:24:18', '2025-03-21 01:24:18'),
(25, 7, 'Randy Bell', 'UI/UX Designer', 'text', '{\"image\": \"landing/images/team/team-04.jpg\", \"social_links\": {\"icofont-facebook\": \"#\", \"icofont-twitter\": \"#\", \"fa-youtube\": \"#\"}}', 0, '2025-03-21 01:25:06', '2025-03-21 01:25:06'),
(26, 7, 'Alice Andrews', 'Photographer', 'text', '{\"image\": \"landing/images/team/team-02.jpg\", \"social_links\": {\"icofont-facebook\": \"#\", \"icofont-twitter\": \"#\", \"fa-youtube\": \"#\"}}', 0, '2025-03-21 01:25:06', '2025-03-21 01:25:06'),
(27, 7, 'Nicholas Hart', 'Web Developer', 'text', '{\"image\": \"landing/images/team/team-03.jpg\", \"social_links\": {\"icofont-facebook\": \"#\", \"icofont-twitter\": \"#\", \"fa-youtube\": \"#\"}}', 0, '2025-03-21 01:25:06', '2025-03-21 01:25:06'),
(28, 7, 'Grace Ross', 'CEO/Founder', 'text', '{\"image\": \"landing/images/team/team-04.jpg\", \"social_links\": {\"icofont-facebook\": \"#\", \"icofont-twitter\": \"#\", \"fa-youtube\": \"#\"}}', 0, '2025-03-21 01:25:06', '2025-03-21 01:25:06'),
(29, 8, 'krnawnaprl', 'KEREN BANGET MOUNTINGNYA KOK BISA SIH SE CENTER ITU MIN 😔☝🏻', 'text', '{\"image\": \"landing/images/team/avatar-1.jpg\", \"variation\": \"Aerox New, 7cm\"}', 0, '2025-03-21 01:25:39', '2025-03-21 01:25:39'),
(30, 8, 'syahrulrochman859', 'Thanks min, mountingnya bagus & center🔥', 'text', '{\"image\": \"landing/images/team/avatar-2.jpg\", \"variation\": \"Aerox New, 8cm\"}', 0, '2025-03-21 01:25:39', '2025-03-21 01:25:39'),
(31, 8, 'juned_alfied', 'mounting by boyprojects sangat pnp sekali ke kzr saya tanpa rubah apapun, benar-benar plug n play...', 'text', '{\"image\": \"landing/images/team/avatar-3.jpg\", \"variation\": \"5cm + bosh\"}', 0, '2025-03-21 01:25:39', '2025-03-21 01:25:39'),
(32, 8, 'nobodyjudgeme', 'Alhamdulillah barang terpasang dengan baik dan posisi center. Terimakasih omku', 'text', '{\"image\": \"landing/images/team/avatar-2.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-21 01:25:39', '2025-03-21 01:25:39'),
(33, 8, 'adidaengg', 'Mantapp, mounting nya aman 100% presisi, ga ada kendala sama sekali pas pemasangan.', 'text', '{\"image\": \"landing/images/team/avatar-2.jpg\", \"variation\": \"4 cm\"}', 0, '2025-03-21 01:25:39', '2025-03-21 01:25:39'),
(34, 8, 'harsanandarozzaqfirmansyah', 'mantab asli top lah boy! kaga miring samsek joss puas kali lah!', 'text', '{\"image\": \"landing/images/team/avatar-4.jpg\", \"variation\": \"3 cm\"}', 0, '2025-03-21 01:25:39', '2025-03-21 01:25:39'),
(35, 10, 'Jual Sparepart Motor', 'Terpercaya & Berkualitas', 'text', '{\"image\": \"landing/images/slides/home-bg-2.jpg\", \"description\": \"Kami menyediakan berbagai sparepart terbaik untuk motor matic dan sport.\", \"button_text\": \"Lihat Produk\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-21 01:37:27', '2025-03-21 01:37:27'),
(36, 10, 'Jasa Pemasangan', 'Profesional & Terjamin', 'text', '{\"image\": \"landing/images/slides/home-bg-1.jpg\", \"description\": \"Layanan pemasangan sparepart dengan teknisi berpengalaman.\", \"button_text\": \"Cek Layanan\", \"button_link\": \"http://shopee.co.id/boyprojectsasli\", \"contact_link\": \"https://wa.me/08211990442\"}', 0, '2025-03-21 01:37:27', '2025-03-21 01:37:27'),
(37, 9, 'description', 'We are a fully in-house digital agency focusing on branding, marketing, web design and development with clients ranging from start-ups. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed varius quam ut magna ultricies pellentesque.', 'text', NULL, 0, '2025-03-21 01:48:08', '2025-03-21 01:48:08'),
(38, 11, 'TikTok Video 1', NULL, 'text', '{\"embed_url\": \"https://www.tiktok.com/@boyprojects/video/7482575523772779831\", \"video_id\": \"7482575523772779831\"}', 0, '2025-03-21 02:02:27', '2025-03-21 02:02:27'),
(39, 11, 'TikTok Video 2', NULL, 'text', '{\"embed_url\": \"https://www.tiktok.com/@boyprojects/photo/7483462663515753736\", \"video_id\": \"7483462663515753736\"}', 0, '2025-03-21 02:02:27', '2025-03-21 02:02:27'),
(40, 12, 'Instagram Post 1', NULL, 'text', '{\"embed_url\": \"https://www.instagram.com/p/XYZ123/\"}', 0, '2025-03-21 02:03:17', '2025-03-21 02:03:17'),
(41, 12, 'Instagram Post 2', NULL, 'text', '{\"embed_url\": \"https://www.instagram.com/p/ABC789/\"}', 0, '2025-03-21 02:03:17', '2025-03-21 02:03:17');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `section_contents`
--
ALTER TABLE `section_contents`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
