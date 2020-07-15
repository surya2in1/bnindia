-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 15, 2020 at 10:37 PM
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
(2, 'accounts', '2020-07-15 20:34:44', '2020-07-15 20:34:44');

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
(1, 'admin', '2020-07-15 20:23:26', '2020-07-15 20:23:26');

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
(1, 1, 1, 1, '2020-07-15 20:23:00', '2020-07-15 20:23:00');

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
  `accupation` varchar(50) DEFAULT NULL,
  `income_amt` varchar(15) DEFAULT NULL,
  `address_proof` varchar(50) DEFAULT NULL,
  `photo_proof` varchar(50) DEFAULT NULL,
  `other_document` varchar(50) DEFAULT NULL,
  `profile_picture` varchar(50) DEFAULT NULL,
  `token` varchar(200) NOT NULL,
  `status` int(5) NOT NULL DEFAULT 1,
  `role_id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `password`, `first_name`, `middle_name`, `last_name`, `address`, `city`, `state`, `gender`, `maritial_status`, `date_of_birth`, `mobile_number`, `email`, `nominee_name`, `nominee_relation`, `nominee_dob`, `accupation`, `income_amt`, `address_proof`, `photo_proof`, `other_document`, `profile_picture`, `token`, `status`, `role_id`, `created`, `modified`) VALUES
(1, '$2y$10$qYtiBAAcd1CQuZ1PeAzyFepcHZAGD3xiILKx.0umdcBP.AOCLKWUW', 'jaya', 'ganesh', 'suryawanshi', '', 'Pune', 'Maharashtra', 'female', 'unmarried', '2020-06-29', '7788999999', 'jayshris22@gmail.com', 'divya', 'sister', '2020-06-30', 'Developer', '100000', NULL, NULL, NULL, 'ef8f20e13787b52d213f83499c9b1957_user5.jpg', '7dfa4aaf7bc93d5c131b58d0b7d2c112e20130f3', 1, 0, '2020-07-04 21:01:20', '2020-07-04 21:01:20'),
(2, '$2y$10$cDrgJrVDBatv5ncjhI0y.eDpIGuFzijut2Bj/E9URTbN0ue.NRHSm', 'Rajj', 'Kj', 'Malhotrakk', 'Akshya Nagar 1st Block 1st Cross, Rammurthy nagar, Bangalore-560016', 'Punek', 'Maharashtrak', 'male', 'married', '2019-03-18', '7709645938', 'raj@gmail.com', 'Anujp', 'Nairl', '2020-06-15', 'Developerj', '100009', '2_d7072a081a3fde099757d911b5815496_blog1.jpg', '2_d5b4ac8a6023f1c08d7f3151dd78e41d_blog2.jpg', '2_892fcabac53bd9e98f252ee015af3db6_blog3.jpg', '2_8a2b0bd20c5b512b37dd310fe4d4ab1a_100_13.jpg', '', 1, 1, '2020-07-15 20:26:54', '2020-07-10 20:21:46'),
(3, '$2y$10$Ez9ta/sgmgrJguOzfw62suuxi0e6LJi2WS3fh3N7C0qDf71wFPAfm', 'dsfsd', 'test', 'ghfg', '', '', '', 'male', 'hg', '0000-00-00', '', 'test@gmail.com', '', '', NULL, '', '', '', '', '', '', '', 1, 0, '2020-07-14 21:01:37', '2020-07-14 21:01:37');

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `modules`
--
ALTER TABLE `modules`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `role_permissions`
--
ALTER TABLE `role_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
