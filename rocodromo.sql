-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 27, 2021 at 10:11 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rocodromo`
--

-- --------------------------------------------------------

--
-- Table structure for table `hours`
--

CREATE TABLE `hours` (
  `id_hour` int(2) NOT NULL COMMENT 'ID of the time zone',
  `start_hour` varchar(5) NOT NULL COMMENT 'Hour when reservation starts',
  `end_hour` varchar(5) NOT NULL COMMENT 'Hour when reservation finishes',
  `week_day` varchar(7) NOT NULL COMMENT 'Array with active week day ([LMXJVSD] for all week days)',
  `user_modification` int(6) NOT NULL COMMENT 'ID of th user who has done the transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When the transaction was done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hours`
--

INSERT INTO `hours` (`id_hour`, `start_hour`, `end_hour`, `week_day`, `user_modification`, `timestamp`) VALUES
(1, '08:00', '09:30', 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(2, '10:00', '11:30', 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(3, '12:00', '13:30', 'LMXJVSD', 1, '2021-04-12 11:07:56'),
(4, '14:00', '15:30', 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(5, '16:00', '17:30', 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(6, '18:00', '19:30', 'LMXJV', 1, '2021-02-28 17:39:17'),
(7, '19:45', '21:15', 'LMXJV', 1, '2021-02-28 17:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(6) NOT NULL COMMENT 'ID of reservation',
  `id_related_reservation` int(6) NOT NULL COMMENT 'ID which links double reservations in routes zone',
  `reservation_date` date NOT NULL COMMENT 'Date when reservation has been done',
  `hour_id` int(2) NOT NULL COMMENT 'ID of the time zone when reservation has been done',
  `zone_id` int(2) NOT NULL COMMENT 'ID of the zone where reservations has been done',
  `user_id` int(6) NOT NULL COMMENT 'ID of the reservation user',
  `reservation_status` varchar(1) NOT NULL COMMENT 'Status of the reservation (Active = A) (Inactive = "I") (Pending confirmation = "P" or "C" [C is who should confirm]) (Without rope team = "W")',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user who has done last transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When the last transaction has been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabal de reservas';

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `id_related_reservation`, `reservation_date`, `hour_id`, `zone_id`, `user_id`, `reservation_status`, `user_modification`, `timestamp`) VALUES
(2, 0, '2021-05-15', 1, 1, 3, 'I', 3, '2021-04-12 13:34:16'),
(6, 0, '2021-04-28', 2, 11, 3, 'I', 3, '2021-04-12 13:34:22'),
(7, 0, '2021-04-15', 2, 1, 1, 'I', 999999, '2021-04-16 06:35:50'),
(10, 0, '2021-03-07', 4, 6, 1, 'I', 999999, '2021-04-06 08:37:14'),
(11, 0, '2021-04-20', 7, 10, 3, 'I', 3, '2021-04-20 10:35:26'),
(12, 0, '2021-04-26', 2, 1, 1, 'I', 999999, '2021-04-26 22:00:00'),
(15, 0, '2021-04-15', 2, 10, 5, 'I', 1, '2021-04-12 18:08:09'),
(16, 0, '2021-04-28', 2, 6, 1, 'I', 1, '2021-04-12 16:49:09'),
(17, 0, '2021-04-15', 7, 1, 1, 'I', 1, '2021-04-09 06:03:13'),
(18, 0, '2021-04-14', 1, 11, 6, 'I', 1, '2021-04-12 13:21:39'),
(19, 0, '2021-04-27', 2, 2, 1, 'I', 1, '2021-04-12 18:03:14'),
(20, 0, '2021-04-02', 7, 6, 3, 'I', 999999, '2021-04-12 13:47:19'),
(21, 0, '2021-04-14', 7, 6, 3, 'I', 3, '2021-04-12 13:49:16'),
(22, 0, '2021-04-21', 2, 2, 3, 'I', 3, '2021-04-12 14:49:13'),
(23, 0, '2021-04-20', 1, 7, 3, 'I', 3, '2021-04-12 14:49:49'),
(24, 0, '2021-04-15', 1, 7, 3, 'I', 3, '2021-04-12 15:02:45'),
(25, 0, '2021-04-14', 7, 10, 3, 'I', 3, '2021-04-12 15:12:15'),
(26, 0, '2021-04-14', 5, 10, 3, 'I', 3, '2021-04-12 15:05:17'),
(27, 0, '2021-04-15', 1, 4, 3, 'I', 3, '2021-04-12 15:10:23'),
(28, 0, '2021-04-15', 1, 9, 3, 'I', 3, '2021-04-12 15:11:12'),
(29, 0, '2021-04-15', 1, 10, 3, 'I', 3, '2021-04-12 15:12:19'),
(30, 0, '2021-04-15', 3, 11, 3, 'I', 3, '2021-04-12 15:13:04'),
(31, 0, '2021-04-14', 7, 9, 3, 'I', 3, '2021-04-12 16:32:31'),
(32, 0, '2021-04-15', 7, 2, 3, 'I', 3, '2021-04-12 16:43:35'),
(33, 0, '2021-04-13', 7, 2, 3, 'I', 3, '2021-04-12 16:41:01'),
(34, 0, '2021-04-16', 7, 6, 3, 'I', 3, '2021-04-12 16:44:35'),
(35, 0, '2021-04-19', 1, 11, 3, 'I', 1, '2021-04-12 17:05:34'),
(36, 0, '2021-04-20', 1, 2, 3, 'I', 3, '2021-04-12 16:45:32'),
(37, 0, '2021-04-14', 2, 4, 3, 'I', 999999, '2021-04-15 07:59:42'),
(38, 0, '2021-04-13', 7, 9, 1, 'I', 999999, '2021-04-15 07:59:42'),
(39, 0, '2021-04-12', 1, 4, 1, 'I', 999999, '2021-04-15 07:59:42'),
(40, 0, '2021-04-15', 1, 2, 1, 'I', 999999, '2021-04-16 06:35:50'),
(41, 0, '2021-04-25', 4, 4, 3, 'I', 1, '2021-04-15 19:48:42'),
(42, 0, '2021-04-15', 5, 2, 5, 'I', 1, '2021-04-12 17:35:44'),
(43, 0, '2021-04-18', 1, 11, 5, 'I', 1, '2021-04-12 17:38:56'),
(44, 0, '2021-04-27', 2, 6, 5, 'I', 1, '2021-04-12 18:05:37'),
(45, 0, '2021-04-15', 4, 11, 5, 'I', 1, '2021-04-15 17:27:28'),
(46, 0, '2021-04-15', 2, 11, 5, 'I', 1, '2021-04-12 18:10:24'),
(47, 0, '2021-04-15', 7, 11, 5, 'I', 999999, '2021-04-16 06:35:50'),
(48, 0, '2021-04-14', 2, 4, 1, 'I', 999999, '2021-04-15 07:59:42'),
(49, 0, '2021-04-14', 7, 75, 1, 'I', 1, '2021-04-12 21:13:28'),
(50, 0, '2021-04-16', 4, 6, 1, 'I', 999999, '2021-04-17 06:47:23'),
(51, 0, '2021-04-30', 5, 10, 3, 'I', 3, '2021-04-20 10:35:21'),
(52, 0, '2021-04-30', 3, 9, 5, 'I', 1, '2021-04-15 17:29:26'),
(53, 0, '2021-04-16', 1, 4, 5, 'I', 999999, '2021-04-17 06:47:23'),
(54, 0, '2021-04-27', 7, 7, 1, 'I', 1, '2021-04-19 15:21:38'),
(55, 0, '2021-04-20', 7, 10, 1, 'I', 999999, '2021-04-21 09:22:22'),
(56, 0, '2021-04-20', 2, 4, 1, 'I', 1, '2021-04-16 20:46:36'),
(57, 0, '2021-04-21', 2, 2, 1, 'I', 1, '2021-04-19 19:11:56'),
(58, 0, '2021-04-25', 5, 75, 1, 'I', 1, '2021-04-21 18:38:46'),
(59, 0, '2021-04-29', 1, 11, 1, 'I', 1, '2021-04-19 10:33:49'),
(60, 0, '2021-04-29', 1, 11, 1, 'I', 1, '2021-04-19 10:33:59'),
(61, 0, '2021-04-26', 3, 11, 1, 'I', 1, '2021-04-21 09:22:50'),
(62, 0, '2021-04-26', 4, 4, 1, 'I', 1, '2021-04-19 15:12:06'),
(63, 0, '2021-04-20', 1, 11, 1, 'I', 1, '2021-04-19 19:11:49'),
(66, 0, '2021-04-21', 1, 11, 1, 'I', 1, '2021-04-20 07:28:11'),
(67, 0, '2021-04-21', 2, 11, 1, 'I', 1, '2021-04-21 09:22:29'),
(68, 0, '2021-04-23', 1, 11, 1, 'I', 1, '2021-04-20 07:40:44'),
(69, 0, '2021-04-29', 1, 11, 1, 'I', 1, '2021-04-21 09:22:46'),
(70, 0, '2021-04-25', 1, 11, 1, 'I', 1, '2021-04-21 09:22:39'),
(71, 0, '2021-04-29', 1, 6, 3, 'I', 3, '2021-04-20 10:44:34'),
(72, 0, '2021-04-29', 1, 6, 1, 'I', 1, '2021-04-21 09:22:53'),
(73, 0, '2021-04-30', 7, 1, 3, 'I', 3, '2021-04-21 19:08:56'),
(74, 0, '2021-04-30', 7, 1, 3, 'I', 3, '2021-04-21 14:42:06'),
(75, 0, '2021-04-30', 7, 1, 3, 'I', 1, '2021-04-21 15:17:36'),
(76, 0, '2021-04-23', 7, 4, 1, 'I', 999999, '2021-04-26 08:47:56'),
(77, 0, '2021-04-28', 1, 7, 3, 'I', 1, '2021-04-21 15:22:37'),
(78, 0, '2021-04-25', 1, 76, 3, 'I', 1, '2021-04-21 15:25:11'),
(79, 0, '2021-04-29', 1, 11, 1, 'I', 1, '2021-04-21 16:10:01'),
(84, 0, '2021-04-30', 3, 4, 1, 'A', 1, '2021-04-21 19:01:30'),
(85, 0, '2021-04-30', 6, 2, 1, 'I', 1, '2021-04-21 18:38:41'),
(86, 0, '2021-04-25', 3, 4, 1, 'I', 999999, '2021-04-26 08:47:56'),
(87, 0, '2021-04-22', 6, 2, 1, 'I', 999999, '2021-04-23 06:37:00'),
(88, 0, '2021-04-25', 1, 11, 1, 'I', 1, '2021-04-21 19:14:42'),
(89, 5, '2021-04-25', 3, 11, 1, 'I', 999999, '2021-04-26 08:47:56'),
(90, 0, '2021-04-30', 7, 11, 1, 'I', 1, '2021-04-26 21:54:58'),
(91, 0, '2021-04-29', 7, 7, 3, 'I', 3, '2021-04-21 19:47:47'),
(92, 0, '2021-04-22', 4, 75, 3, 'I', 3, '2021-04-21 20:28:58'),
(93, 0, '2021-04-27', 2, 4, 3, 'I', 3, '2021-04-21 22:17:41'),
(94, 0, '2021-04-25', 1, 4, 3, 'I', 3, '2021-04-21 20:30:42'),
(95, 0, '2021-04-28', 6, 1, 3, 'I', 3, '2021-04-22 01:09:40'),
(96, 0, '2021-04-27', 1, 4, 3, 'I', 3, '2021-04-22 09:15:05'),
(97, 0, '2021-04-27', 7, 1, 3, 'I', 3, '2021-04-22 09:13:14'),
(98, 0, '2021-04-29', 1, 75, 3, 'I', 3, '2021-04-22 09:16:07'),
(99, 0, '2021-04-27', 7, 4, 3, 'I', 3, '2021-04-22 13:00:25'),
(100, 0, '2021-04-26', 7, 2, 3, 'I', 3, '2021-04-22 09:22:26'),
(101, 0, '2021-04-30', 2, 4, 3, 'I', 3, '2021-04-22 09:54:02'),
(102, 10, '2021-04-28', 2, 4, 3, 'A', 3, '2021-04-22 16:02:18'),
(103, 10, '2021-04-25', 1, 2, 1, 'I', 999999, '2021-04-26 08:47:56'),
(104, 0, '2021-04-30', 3, 4, 1, 'A', 1, '2021-04-22 12:59:51'),
(105, 0, '2021-04-25', 1, 11, 3, 'I', 3, '2021-04-23 06:37:37'),
(106, 0, '2021-04-30', 7, 75, 3, 'I', 1, '2021-04-23 06:57:47'),
(107, 5, '2021-04-30', 7, 1, 1, 'A', 1, '2021-04-23 08:41:42'),
(108, 0, '2021-04-29', 2, 6, 3, 'I', 1, '2021-04-23 08:49:31'),
(125, 11, '2021-04-27', 7, 9, 4, 'I', 4, '2021-04-23 19:24:12'),
(126, 11, '2021-04-27', 7, 9, 4, 'I', 4, '2021-04-23 19:24:18'),
(127, 12, '2021-04-29', 1, 6, 4, 'I', 4, '2021-04-23 19:39:56'),
(128, 12, '2021-04-29', 1, 6, 1, 'I', 1, '2021-04-23 19:57:01'),
(129, 0, '2021-04-28', 6, 11, 4, 'I', 1, '2021-04-26 23:57:43'),
(130, 13, '2021-04-29', 6, 76, 4, 'I', 4, '2021-04-23 19:49:36'),
(131, 13, '2021-04-29', 6, 76, 1, 'I', 1, '2021-04-23 19:57:05'),
(159, 0, '2021-05-26', 1, 75, 4, 'I', 1, '2021-04-26 22:40:35'),
(174, 14, '2021-04-30', 7, 6, 3, 'P', 1, '2021-04-26 23:59:03'),
(175, 14, '2021-04-30', 7, 6, 4, 'C', 1, '2021-04-26 23:59:03'),
(176, 15, '2021-04-30', 7, 9, 1, 'A', 1, '2021-04-27 00:01:38'),
(177, 15, '2021-04-30', 7, 9, 1, 'A', 1, '2021-04-27 00:01:39'),
(178, 16, '2021-04-30', 7, 7, 6, 'A', 1, '2021-04-27 00:03:49'),
(179, 16, '2021-04-30', 7, 7, 6, 'W', 1, '2021-04-27 00:03:49'),
(180, 17, '2021-04-30', 7, 76, 1, 'A', 1, '2021-04-27 00:04:50'),
(181, 17, '2021-04-30', 7, 76, 1, 'W', 1, '2021-04-27 00:04:50');

-- --------------------------------------------------------

--
-- Table structure for table `reservationsconfig`
--

CREATE TABLE `reservationsconfig` (
  `id_config` int(11) NOT NULL COMMENT 'ID of the configuration',
  `max_reservation` int(11) NOT NULL COMMENT 'Maximun number of reservations by user',
  `max_users_route` int(2) NOT NULL COMMENT 'Número máximo de usuarios totales en la zona de vías',
  `start_free_date` date NOT NULL COMMENT 'Start free date for  reservations',
  `end_free_date` date NOT NULL COMMENT 'End free date for  reservations',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user who has done last transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'When last transaction has been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reservationsconfig`
--

INSERT INTO `reservationsconfig` (`id_config`, `max_reservation`, `max_users_route`, `start_free_date`, `end_free_date`, `user_modification`, `timestamp`) VALUES
(1, 2, 6, '2021-04-01', '2021-05-30', 1, '2021-04-26 21:43:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(6) NOT NULL COMMENT 'ID of the user',
  `user_type` varchar(1) NOT NULL COMMENT 'Type of user ["A"=Admin, "G"=Generic, "M"=Generic with Minors]',
  `card_number` int(6) NOT NULL COMMENT 'Card number',
  `user_status` varchar(1) NOT NULL COMMENT 'Status of the user \r\n(Active = "A") \r\n(Inactive = "I"',
  `user_email` varchar(50) NOT NULL COMMENT 'User email',
  `user_password` varchar(255) NOT NULL COMMENT 'Password of the user',
  `user_name` varchar(100) NOT NULL COMMENT 'User name & surnames',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user Who has done the transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'When transaccion has done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de usuarios';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `user_type`, `card_number`, `user_status`, `user_email`, `user_password`, `user_name`, `user_modification`, `timestamp`) VALUES
(1, 'A', 100, 'A', 'plosky21@hotmail.com', '$2y$10$KN53byzg.0fjivHRR4x8Yud47gbuN7VtVvVZdFCaWSR95z4qeZHXK', 'Escuela escalada', 1, '2021-04-27 07:24:35'),
(2, 'G', 200, 'I', 'email1@hotmail.com', 'Passwor1', 'Joan Espinosa', 1, '2021-04-27 07:37:26'),
(3, 'G', 300, 'A', 'guaubisabi@gmail.com', '$2y$10$NXyIGrmwzipqI5FpIJpR9eLdWVenNY9WgWE4K/qVVeIB79LSRgxhy', 'Felip Solsona', 1, '2021-04-27 07:31:53'),
(4, 'G', 400, 'A', 'ssaannddrruuss@gmail.com', '$2y$10$NeGc9aJbavkmCNHhBp9KGO9nI8Cbbmuzy5pbeqODrBnxKKyILoVkS', 'Sandra Ruiz', 1, '2021-04-27 07:23:52'),
(5, 'M', 500, 'A', 'sandra.arcas.valero@gmail.com', '$2y$10$6FLYWBqZUfL8fes/1a0eGOs3gNVvMRSs6gIZyC/NPN81IZ00HT7XS', 'Nuria Crespo', 1, '2021-04-27 08:07:03'),
(6, 'G', 600, 'A', 'info@guaubisabi.com', '$2y$10$dw5.l9NuOpOWRiHdkJFm5.9k7rc.9YREx0i0CtODLI2J0NWl5.SXi', 'Javier Maroto', 6, '2021-04-27 07:48:17');

-- --------------------------------------------------------

--
-- Table structure for table `zones`
--

CREATE TABLE `zones` (
  `id_zone` int(2) NOT NULL COMMENT 'ID of the zone',
  `zone_name` varchar(30) NOT NULL COMMENT 'Name of the zone',
  `max_users_zone` int(2) NOT NULL COMMENT 'Maximun users number in an specific zone',
  `zone_status` varchar(1) NOT NULL COMMENT 'Status of the zone (Active = "A") (Inactive = "I"',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user who has done the last transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'When the last transaction has been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `zones`
--

INSERT INTO `zones` (`id_zone`, `zone_name`, `max_users_zone`, `zone_status`, `user_modification`, `timestamp`) VALUES
(1, 'Volúmenes', 3, 'A', 1, '2021-03-13 22:44:12'),
(2, 'Moonboard', 2, 'A', 999999, '2021-03-08 16:33:20'),
(4, 'Plafón', 2, 'A', 1, '2021-03-15 12:15:34'),
(6, 'Vía R1', 2, 'A', 1, '2021-03-15 12:16:11'),
(7, 'Vía R2', 2, 'A', 1, '2021-04-05 22:02:38'),
(9, 'Vía R4', 2, 'A', 999999, '2021-03-08 16:33:20'),
(10, 'Vía R5', 2, 'A', 1, '2021-03-15 09:58:17'),
(11, 'Caballo', 2, 'A', 999999, '2021-03-13 22:51:23'),
(75, 'Placa desplomada', 2, 'A', 1, '2021-04-12 17:04:24'),
(76, 'Vía R3', 2, 'A', 1, '2021-04-20 09:00:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hours`
--
ALTER TABLE `hours`
  ADD PRIMARY KEY (`id_hour`),
  ADD UNIQUE KEY `id_start_hour` (`start_hour`,`end_hour`);

--
-- Indexes for table `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `hour_id` (`hour_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `card_number_id` (`user_id`),
  ADD KEY `reservation_date` (`reservation_date`);

--
-- Indexes for table `reservationsconfig`
--
ALTER TABLE `reservationsconfig`
  ADD PRIMARY KEY (`id_config`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `card_number` (`card_number`,`user_status`,`user_name`);

--
-- Indexes for table `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id_zone`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hours`
--
ALTER TABLE `hours`
  MODIFY `id_hour` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID of the time zone', AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID of reservation', AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `reservationsconfig`
--
ALTER TABLE `reservationsconfig`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the configuration', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID of the user', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id_zone` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID of the zone', AUTO_INCREMENT=77;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id_zone`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_5` FOREIGN KEY (`hour_id`) REFERENCES `hours` (`id_hour`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
