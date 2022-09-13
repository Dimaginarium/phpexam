-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2021 at 11:09 PM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vizsga`
--

-- --------------------------------------------------------

--
-- Table structure for table `codes`
--

CREATE TABLE `codes` (
  `user_id` int(11) NOT NULL,
  `code` varchar(24) NOT NULL,
  `time_uploaded` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `codes`
--

INSERT INTO `codes` (`user_id`, `code`, `time_uploaded`) VALUES
(1, '123456123456123456DR6GF5', '2021-08-04 22:46:52'),
(1, '123456123456126SDF123454', '2021-08-04 23:02:23'),
(1, '6985FG123456126SDF123456', '2021-08-04 22:02:49'),
(16, 'ADFRYT123456GDERF4LJ06UF', '2021-08-04 23:07:00'),
(1, 'FKJ689KFH576GJ58GH06JDUR', '2021-08-04 22:13:06'),
(16, 'HELO56HOMBRE345678123456', '2021-08-04 23:06:36'),
(3, 'HFGH76123456126SDFSDF456', '2021-08-04 22:17:20'),
(14, 'JANE12HELLO3LDK567LEM984', '2021-08-04 22:49:17');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `sid` varchar(64) NOT NULL,
  `spass` varchar(80) NOT NULL,
  `stime` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `time_created` datetime NOT NULL,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `time_created`, `last_login`) VALUES
(1, 'admin', 'dtakacs11@yahoo.com', '$2y$10$2XjU6aev7AjzXY7g1Kv.4OKzs7jd.Ji0.ltiGkuyVrPrI.jXachY6', '2021-07-29 21:15:20', NULL),
(3, 'teszt', 'a@a.a', '$2y$10$jM7vjaiyopqDoYcMXzm53.v8ZY2kE8bpeUs3u8ijdMVIoU/wSl7hO', '2021-07-31 22:33:36', NULL),
(13, 'kgj', 'fgh@ser.ko', '$2y$10$SarnMoyheZnTllM5KjtR7OmD/CQ5gshwl22ubkM4Q17dFqWuWX3Bi', '2021-08-03 20:19:39', NULL),
(14, 'jane doe', 'jane@doe.com', '$2y$10$hBWGAFauaUXlea8Eu57fw.hUyv.49Jip4kXGVtrNdAqIKCimWbMm2', '2021-08-04 22:48:35', NULL),
(15, 'john doe', 'fht@gj.k', '$2y$10$D2xoEsBx45Kxy9rioiW5YO7x219XpdAypZd8ZLyXs2yEtIrE.UM3O', '2021-08-04 23:00:33', NULL),
(16, 'hombre', 'helo@helo.com', '$2y$10$EYHy/u3A74DUrF6R3G1gM.CiuG.JfGhSZE0M5G84421w.J3R2x4P6', '2021-08-04 23:05:51', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `codes`
--
ALTER TABLE `codes`
  ADD PRIMARY KEY (`code`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`sid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
