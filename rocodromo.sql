-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 16, 2021 at 03:14 PM
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
  `id_related_reservation` int(6) NOT NULL COMMENT 'id_reservation of the related reservation if it has been done in routes zone',
  `reservation_date` date NOT NULL COMMENT 'Date when reservation has been done',
  `hour_id` int(2) NOT NULL COMMENT 'ID of the time zone when reservation has been done',
  `zone_id` int(2) NOT NULL COMMENT 'ID of the zone where reservations has been done',
  `user_id` int(6) NOT NULL COMMENT 'ID of the user who has done the reservation',
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
(11, 0, '2021-04-20', 7, 10, 3, 'P', 1, '2021-04-05 22:15:32'),
(12, 0, '2021-04-26', 6, 2, 1, 'A', 1, '2021-04-05 22:05:04'),
(14, 0, '2021-04-27', 7, 7, 1, 'W', 1, '2021-04-12 19:39:49'),
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
(50, 0, '2021-04-16', 4, 6, 1, 'A', 1, '2021-04-15 17:24:16'),
(51, 0, '2021-04-30', 5, 10, 3, 'A', 1, '2021-04-15 17:25:27'),
(52, 0, '2021-04-30', 3, 9, 5, 'I', 1, '2021-04-15 17:29:26'),
(53, 0, '2021-04-16', 1, 4, 5, 'A', 1, '2021-04-15 17:30:49'),
(54, 0, '2021-04-27', 7, 7, 1, 'A', 1, '2021-04-12 19:39:49'),
(55, 0, '2021-04-20', 7, 10, 1, 'C', 1, '2021-04-05 22:15:32');

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
(1, 2, 1, '2021-04-01', '2021-04-30', 1, '2021-04-15 16:45:39');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(6) NOT NULL COMMENT 'ID of the user',
  `user_type` varchar(1) NOT NULL COMMENT 'Type of user ["A"=Admin, "G"=generic]',
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
(1, 'A', 108, 'A', 'plosky21@hotmail.com', '$2y$10$KN53byzg.0fjivHRR4x8Yud47gbuN7VtVvVZdFCaWSR95z4qeZHXK', 'Sandra Arcas', 1, '2021-04-12 16:55:53'),
(2, 'G', 25, 'I', 'email1@hotmail.com', 'Passwor1', 'Name1 Surname1 Surname2', 999999, '2021-03-20 21:04:02'),
(3, 'G', 400, 'A', 'guaubisabi@gmail.com', '$2y$10$NXyIGrmwzipqI5FpIJpR9eLdWVenNY9WgWE4K/qVVeIB79LSRgxhy', 'Name2 Surname1 Surname2', 3, '2021-04-12 13:35:01'),
(4, 'G', 108, 'A', 'email3@hotmail.com', 'Passwor1', 'Name3 Surname1 Surname2', 1, '2021-03-20 21:03:35'),
(5, 'G', 123, 'A', 'email4@hotmail.com', 'Passwor1', 'Name4 Surname1 Surname2', 1, '2021-03-20 21:03:35'),
(6, 'G', 325, 'A', 'email5@hotmail.com', 'Passwor1', 'Name5 Surname1 Surname2', 1, '2021-03-20 21:03:35'),
(10, 'A', 100, 'A', 'taykete@gmail.com', '', 'Carlos Izquierdo', 1, '2021-04-12 21:15:12');

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
(75, 'Placa desplomada', 2, 'A', 1, '2021-04-12 17:04:24');

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
  MODIFY `id_hour` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID of the time zone', AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID of reservation', AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `reservationsconfig`
--
ALTER TABLE `reservationsconfig`
  MODIFY `id_config` int(11) NOT NULL AUTO_INCREMENT COMMENT 'ID of the configuration', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID of the user', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id_zone` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID of the zone', AUTO_INCREMENT=76;

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
