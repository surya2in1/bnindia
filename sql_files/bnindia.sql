-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 22, 2020 at 08:57 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bnindia`
--

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `group_number` varchar(500) NOT NULL,
  `chit_amount` int(10) NOT NULL,
  `total_number` int(10) NOT NULL,
  `premium` int(10) NOT NULL,
  `gov_reg_no` varchar(500) NOT NULL,
  `date` date NOT NULL,
  `status` int(2) NOT NULL DEFAULT 1 COMMENT '0- full, 1- not full, 2- disable',
  `no_of_months` int(10) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `group_number`, `chit_amount`, `total_number`, `premium`, `gov_reg_no`, `date`, `status`, `no_of_months`, `created_date`, `modified_date`) VALUES
(1, 'BH111', 100000, 2, 1000, 'JJJ222', '2020-08-13', 0, 12, '2020-08-21 19:42:25', '2020-08-21 20:22:32'),
(2, 'BH222', 200000, 2, 1000, 'JJJ229', '2020-08-18', 1, 24, '2020-08-21 19:43:02', '2020-08-21 19:43:02');

-- --------------------------------------------------------

--
-- Table structure for table `members_groups`
--

CREATE TABLE `members_groups` (
  `id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL COMMENT 'user_id',
  `group_id` int(10) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp(),
  `modified_date` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `members_groups`
--

INSERT INTO `members_groups` (`id`, `user_id`, `group_id`, `created_date`, `modified_date`) VALUES
(1, 3, 1, '2020-08-21 20:21:04', '2020-08-21 20:21:04'),
(2, 2, 1, '2020-08-21 20:22:32', '2020-08-21 20:22:32');

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf16 NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`id`, `name`, `created`, `modified`) VALUES
(1, 'users', '2020-07-15 20:16:44', '2020-07-15 20:16:44'),
(2, 'members', '2020-07-15 20:34:44', '2020-07-28 19:51:28'),
(3, 'groups', '2020-08-03 19:28:34', '2020-08-03 19:28:34');

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` int(11) NOT NULL,
  `permission` varchar(50) CHARACTER SET utf16 NOT NULL,
  `permission_desc` varchar(50) CHARACTER SET utf16 NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `permission`, `permission_desc`, `created`, `modified`) VALUES
(1, '1111', 'crud', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(2, '1110', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(3, '1100', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(4, '1000', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(5, '0000', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(6, '0001', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(7, '0011', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(8, '0111', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(9, '1010', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(10, '1001', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(11, '1101', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(12, '1011', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(13, '0100', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(14, '0110', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(15, '0101', '', '2020-07-15 20:11:59', '2020-07-15 20:11:59'),
(16, '0010', '', '2020-07-15 20:13:34', '2020-07-15 20:13:34');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(50) CHARACTER SET utf16 NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created`, `modified`) VALUES
(1, 'admin', '2020-07-15 20:23:26', '2020-07-15 20:23:26'),
(2, 'member', '2020-07-20 19:27:13', '2020-07-28 20:01:04'),
(3, 'user', '2020-07-20 19:27:13', '2020-07-28 20:00:58');

-- --------------------------------------------------------

--
-- Table structure for table `role_permissions`
--

CREATE TABLE `role_permissions` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `role_permissions`
--

INSERT INTO `role_permissions` (`id`, `role_id`, `module_id`, `permission_id`, `created`, `modified`) VALUES
(1, 1, 1, 1, '2020-07-15 20:23:00', '2020-07-15 20:23:00'),
(3, 1, 2, 1, '2020-07-28 20:02:40', '2020-07-28 20:02:40'),
(4, 2, 1, 5, '2020-07-28 20:02:40', '2020-07-28 20:02:40'),
(5, 2, 2, 5, '2020-07-28 20:02:40', '2020-07-29 20:11:07'),
(6, 1, 3, 1, '2020-08-03 19:29:51', '2020-08-03 19:30:21'),
(7, 2, 3, 5, '2020-08-03 19:30:37', '2020-08-03 19:30:37');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `password` varchar(400) CHARACTER SET utf8 NOT NULL,
  `first_name` varchar(200) NOT NULL,
  `middle_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `address` varchar(300) NOT NULL,
  `city` varchar(50) NOT NULL,
  `state` varchar(50) NOT NULL,
  `gender` varchar(15) NOT NULL,
  `maritial_status` varchar(30) NOT NULL,
  `date_of_birth` date NOT NULL,
  `mobile_number` varchar(15) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nominee_name` varchar(50) DEFAULT NULL,
  `nominee_relation` varchar(50) DEFAULT NULL,
  `nominee_dob` date DEFAULT NULL,
  `occupation` varchar(50) DEFAULT NULL,
  `income_amt` varchar(15) DEFAULT NULL,
  `address_proof` varchar(50) DEFAULT NULL,
  `photo_proof` varchar(50) DEFAULT NULL,
  `other_document` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(50) DEFAULT NULL,
  `token` varchar(200) NOT NULL,
  `status` int(5) NOT NULL DEFAULT 1,
  `role_id` int(11) NOT NULL,
  `signature` varchar(500) CHARACTER SET utf8 NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `first_name`, `middle_name`, `last_name`, `address`, `city`, `state`, `gender`, `maritial_status`, `date_of_birth`, `mobile_number`, `email`, `nominee_name`, `nominee_relation`, `nominee_dob`, `occupation`, `income_amt`, `address_proof`, `photo_proof`, `other_document`, `profile_picture`, `token`, `status`, `role_id`, `signature`, `created`, `modified`) VALUES
(1, '$2y$10$cDrgJrVDBatv5ncjhI0y.eDpIGuFzijut2Bj/E9URTbN0ue.NRHSm', 'jaya', 'ganesh', 'suryawanshi', '', 'Pune', 'Maharashtra', 'female', 'unmarried', '2020-06-29', '7788999999', 'jayshris22@gmail.com', 'divya', 'sister', '2020-06-30', 'Developer', '100000', NULL, NULL, NULL, 'ef8f20e13787b52d213f83499c9b1957_user5.jpg', 'cd587d392bc2699855015f75959d3a828be7d630', 1, 1, '', '2020-08-21 19:23:50', '2020-08-17 19:41:01'),
(2, '$2y$10$7OTY6ECD/sLNWrGW2tjjyOPt7cb9npYvt9gzaFKhvWesAf68.zGGe', 'Riya', 'K', 'LL', 'Akshya Nagar 1st Block 1st Cross, Rammurthy nagar, Bangalore-560016', 'Pune', 'Maharashtra', 'female', 'married', '2020-08-13', '8899009988', 'riyajaya692@gmail.com', 'Jiya', 'sister', '2020-08-06', 'Developer', '100000', '2_9c0608cd95bfa9a0c1b35652f2a600f2_100_9.jpg', '2_fe172763850a5134fa3d510e753ee72b_100_11.jpg', '2_3d6b7745b4dcd7e78baf78fd4803d98b_100_12.jpg', '2_7fc172d69ee7ccedb38e63900873850d_100_7.jpg', 'b27b9d2daa5566d90741c8afc44c0d2bfcd30ddd', 1, 2, '', '2020-08-21 20:26:45', '2020-08-21 20:26:45'),
(3, '$2y$10$JloWsIiu.xA7YTiIAPtTEOI4rWwYh6RhWrW4TzwNb5I8jH5Zrx6Sq', 'Raj', 'K', 'Malhotra', 'Akshya Nagar 1st Block 1st Cross, Rammurthy nagar, Bangalore-560016', 'Pune', 'Maharashtra', 'male', 'married', '2020-08-11', '7709645931', 'raj@gmail.com', 'Anuj', 'Brother', '2020-08-03', 'Developer', '100000', '3_e7bd77863a470c2addd81c0d6431d5dd_100_9.jpg', '3_f5a96255b8654fddfb6a8645ea1ba2e0_100_10.jpg', '3_7a59dee8a010f48f39988fac8ee61e01_100_11.jpg', '3_767d0f7a2788e0a9f3eb0158dfe6116e_300_3.jpg', '', 1, 2, '', '2020-08-21 20:21:04', '2020-08-21 20:21:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `group_no_unique` (`group_number`);

--
-- Indexes for table `members_groups`
--
ALTER TABLE `members_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `member_group_unique` (`user_id`,`group_id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `permission_unique` (`permission`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role_module_unique` (`role_id`,`module_id`),
  ADD KEY `module_id` (`module_id`),
  ADD KEY `permission_id` (`permission_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `members_groups`
--
ALTER TABLE `members_groups`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `role_permissions`
--
ALTER TABLE `role_permissions`
  ADD CONSTRAINT `role_permissions_ibfk_1` FOREIGN KEY (`module_id`) REFERENCES `modules` (`id`),
  ADD CONSTRAINT `role_permissions_ibfk_2` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`),
  ADD CONSTRAINT `role_permissions_ibfk_3` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
