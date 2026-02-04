-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 08, 2025 at 01:13 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `support_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `bs_admins`
--

CREATE TABLE `bs_admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(50) NOT NULL,
  `admin_username` varchar(20) NOT NULL,
  `admin_email` varchar(50) DEFAULT NULL,
  `admin_mobile` varchar(12) NOT NULL,
  `admin_password` varchar(100) NOT NULL,
  `admin_emailed_pass` varchar(20) NOT NULL,
  `admin_address` varchar(500) DEFAULT NULL,
  `admin_designation` varchar(30) NOT NULL,
  `admin_status` tinyint(1) NOT NULL,
  `admin_last_login` datetime NOT NULL,
  `admin_added_on` datetime NOT NULL,
  `admin_updated_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `bs_admins`
--

INSERT INTO `bs_admins` (`admin_id`, `admin_name`, `admin_username`, `admin_email`, `admin_mobile`, `admin_password`, `admin_emailed_pass`, `admin_address`, `admin_designation`, `admin_status`, `admin_last_login`, `admin_added_on`, `admin_updated_on`) VALUES
(1, 'Admin', 'admin', 'admin@admin.com', '', 'fcea920f7412b5da7be0cf42b8c93759', '', '', '', 1, '2025-06-08 16:17:58', '2017-09-07 00:00:00', '2017-09-07 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `cms_contents`
--

CREATE TABLE `cms_contents` (
  `id` int(11) NOT NULL,
  `content_type` varchar(20) NOT NULL,
  `content_title` varchar(255) NOT NULL,
  `content_description` longtext NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cms_contents`
--

INSERT INTO `cms_contents` (`id`, `content_type`, `content_title`, `content_description`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'About Us Page', 'About Us', '<div class=\"site-heading mb-3\"><span class=\"site-title-tagline\">About Us</span>\r\n<h2 class=\"site-title\">We at Max Earth Resources Limited attempt to live to the Dreams We See</h2>\r\n</div>\r\n<p class=\"about-text mb-4\">Max Earth Resources Limited is a leading mining company in India, specializing in minor and major minerals like Black Strap Metal and Manganese. With operations across Jharkhand, Maharashtra, Odisha, and Kerala, we are committed to innovation, sustainability, and industrial growth.</p>\r\n<p class=\"about-text mb-4\">The Group has strong inspiration to contribute to the nation&rsquo;s economy through its contributions in the Minor and Major Mineral Mining, Processing, Blending, Marketing and Sales in India and abroad. It comes to the Group as intrinsic traits, and therefore, we can humbly notify that as an Institutional Minor, we are the largest Black Strap Minor and Manufacturer of Black Strap Metal in the State of Jharkhand, with an annual production surpassing 2 Lakhs Ton.</p>\r\n<!-- Points -->\r\n<ul class=\"about-list list-unstyled mb-4\">\r\n<li>At vero eos et accusamus et iusto odio.</li>\r\n<li>Established fact that a reader will be distracted.</li>\r\n<li>Sed ut perspiciatis unde omnis iste natus sit.</li>\r\n</ul>', '2025-06-03 13:47:47', 0, '2025-06-08 11:05:49', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bs_admins`
--
ALTER TABLE `bs_admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cms_contents`
--
ALTER TABLE `cms_contents`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bs_admins`
--
ALTER TABLE `bs_admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cms_contents`
--
ALTER TABLE `cms_contents`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
