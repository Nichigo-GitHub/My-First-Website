-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 12, 2021 at 05:50 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fitchen`
--
CREATE DATABASE IF NOT EXISTS `fitchen` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `fitchen`;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `password` text COLLATE utf8_unicode_ci NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `key_value` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_level` int(11) NOT NULL DEFAULT 0,
  `fb_user_id` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `fb_access_token` varchar(500) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `created`, `key_value`, `user_level`, `fb_user_id`, `fb_access_token`) VALUES
(1, 'neilchristian_go@yahoo.com', 'Neil Christian', 'Go', '$2y$12$Bcno5e8J6QPzm5/J55nW9./IF.TwO7xviSQ2rVX7O0fk7B6rCO/MK', '2021-01-25 03:18:50', '6de099faae2f254845308666923f2a67', 1, '3752055488194889', 'EAAC9ZCUBeMDgBAHhxBwoSzcxpQq3eyTLD6VKUoGOOMLZBCrA7FSHIzhZAzXItYwCdfkZAgiID6TVsKp1E0dqJ7CrZBoEVUClZB9zqPyVAPGpNnVLJV8ZAukmiUC2OXWC3EQ47JkLWfd9y0KiMO9W8r6DsM5iubMOEJ0vsoxkGjZBLnAYZCYpPIl3JHKXvGlxzCpZCy2XIre2ShjQZDZD'),
(2, 'testing@test.com', 'Testing', 'Tester', '$2y$12$fO1aAby7DRp.xiQSKJ/98eAayuK/ZxU244VoIXG/xoDdb.etEJB3m', '2021-02-08 03:08:45', '68d96d85fb3d04e5f3b36ee241ed357b', 0, '', ''),
(3, 'carlzmarasiganz@gmail.com', 'Carl Joseph', 'Marasigan', '$2y$12$zjV5daflHdzyjShD3RIxM.HXnA8QSVFIIIZJFGQuhKT2tG/Prin5m', '2021-02-08 03:11:54', '9c64dfa179dea478d5e25b3b57210bc0', 1, '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=80;