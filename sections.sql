-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 22, 2025 at 10:43 PM
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
(1, 'about', 'Redefining Performance', 'Lebih dari Sekadar Sparepart, Ini Tentang Pengalaman Berkendara', 'Di Boy Project, kami menghadirkan produk terbaik untuk meningkatkan performa dan estetika motor Anda. Setiap sparepart yang kami sediakan dipilih dengan cermat untuk memberikan kualitas, ketahanan, dan kenyamanan terbaik bagi para rider.', 'landing/images/startup-bg.jpg', NULL, NULL, 1, 2, '2025-03-21 01:21:56', '2025-03-21 01:21:56'),
(2, 'contact', 'Contact Us', '- Stay in Touch -', NULL, NULL, NULL, NULL, 1, 8, '2025-03-21 01:21:56', '2025-03-21 01:21:56'),
(3, 'counter', 'Our Achievements', 'We have achieved great milestones over the years.', NULL, NULL, NULL, NULL, 1, 6, '2025-03-21 01:21:56', '2025-03-21 01:21:56'),
(4, 'portofolio', 'Our Work', 'Explore our best projects in various categories.', NULL, NULL, NULL, NULL, 1, 7, '2025-03-21 01:21:56', '2025-03-21 01:21:56'),
(5, 'pricing', 'Our Pricing', '- Choose Your Plan -', NULL, NULL, NULL, NULL, 1, 10, '2025-03-21 01:23:12', '2025-03-21 01:23:12'),
(6, 'services', 'Apa yang Kami Tawarkan', '- Enhancing Your Performance -', NULL, NULL, NULL, NULL, 1, 4, '2025-03-21 01:24:18', '2025-03-21 01:24:18'),
(7, 'team', 'Meet Our Team', '- We Are Stronger -', NULL, NULL, NULL, NULL, 1, 5, '2025-03-21 01:25:06', '2025-03-21 01:25:06'),
(8, 'testimonials', 'Testimonials', '- Happy Clients -', NULL, NULL, NULL, NULL, 1, 9, '2025-03-21 01:25:39', '2025-03-21 01:25:39'),
(9, 'home', 'Welcome to Boys Project', 'Jual beli sparepart motor & pemasangan terpercaya', NULL, NULL, NULL, NULL, 1, 1, '2025-03-21 01:37:27', '2025-03-21 01:37:27'),
(10, 'tiktok', 'Our TikTok Content', 'Latest updates from TikTok', NULL, NULL, NULL, NULL, 1, 12, '2025-03-21 02:02:27', '2025-03-21 02:02:27'),
(11, 'instagram', 'Our Instagram Posts', 'Latest updates from Instagram', NULL, NULL, NULL, NULL, 1, 13, '2025-03-21 02:03:17', '2025-03-21 02:03:17'),
(12, 'activities', 'Our Activities', 'Lebih dari Sekadar Produk, Ini Tentang Perjalanan Bersama', NULL, 'landing/images/onepage-bg-left.jpg', NULL, NULL, 1, 3, '2025-03-21 18:40:43', '2025-03-21 18:40:43'),
(13, 'cta', 'Take Action Now!', 'Join us and upgrade your bike today!', NULL, 'landing/images/background/parallax-bg-2.jpg', 'Get Started', 'https://wa.me/08211990442', 1, 11, '2025-03-21 18:52:50', '2025-03-21 18:52:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
