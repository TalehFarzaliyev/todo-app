-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 20, 2021 at 02:24 AM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.1.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `azericardtodo`
--

-- --------------------------------------------------------

--
-- Table structure for table `todolist`
--

CREATE TABLE `todolist` (
  `id` int(10) NOT NULL,
  `ses_id` varchar(255) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0 - passive, 1 - active',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `todolist`
--

INSERT INTO `todolist` (`id`, `ses_id`, `content`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'd41d8cd98f00b204e9800998ecf8427e', 'Lorem Ipsum dolor Set', 0, NULL, '2021-10-19 23:30:47', '2021-10-19 23:30:47'),
(4, 'd41d8cd98f00b204e9800998ecf8427e', '', 1, NULL, '2021-10-20 00:16:36', '2021-10-20 00:16:36'),
(5, 'd41d8cd98f00b204e9800998ecf8427e', 'Lorem Ipsum dolor Set', 0, NULL, '2021-10-19 23:28:59', NULL),
(6, 'd41d8cd98f00b204e9800998ecf8427e', 'Lorem Ipsum dolor Set 2', 1, NULL, '2021-10-20 00:16:28', NULL),
(7, 'd41d8cd98f00b204e9800998ecf8427e', 'salam dunya', 0, '2021-10-20 00:01:07', '2021-10-20 00:05:32', '2021-10-20 00:05:32'),
(8, 'd41d8cd98f00b204e9800998ecf8427e', 'salam ay dunya', 0, '2021-10-20 00:03:06', '2021-10-20 00:05:35', '2021-10-20 00:05:35'),
(9, 'd41d8cd98f00b204e9800998ecf8427e', 'kimsen sen?', 0, '2021-10-20 00:04:30', '2021-10-20 00:05:34', '2021-10-20 00:05:34'),
(10, 'd41d8cd98f00b204e9800998ecf8427e', 'salam dunya', 0, '2021-10-20 00:05:46', '2021-10-20 00:05:46', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `todolist`
--
ALTER TABLE `todolist`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `todolist`
--
ALTER TABLE `todolist`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
