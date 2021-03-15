-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 15, 2021 at 08:43 PM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.11

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
  `id_hours` int(2) NOT NULL COMMENT 'ID of the time zone',
  `start_hour` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Hour when reservation starts',
  `end_hour` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Hour when reservation finishes',
  `week_day` varchar(7) NOT NULL COMMENT 'Array with active week day ([LMXJVSD] for all week days)',
  `user_modification` int(6) NOT NULL COMMENT 'ID of th user who has done the transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When the transaction was done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `hours`
--

INSERT INTO `hours` (`id_hours`, `start_hour`, `end_hour`, `week_day`, `user_modification`, `timestamp`) VALUES
(1, 0800, 0930, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(2, 1000, 1130, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(3, 1200, 1330, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(4, 1400, 1530, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(5, 1600, 1730, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(6, 1800, 1930, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(7, 1945, 2115, 'LMXJVSD', 999999, '2021-02-28 17:39:17');

-- --------------------------------------------------------

--
-- Table structure for table `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(6) NOT NULL COMMENT 'ID of reservation',
  `reservation_date` date NOT NULL COMMENT 'Date when reservation has been done',
  `hour_id` int(2) NOT NULL COMMENT 'ID of the time zone when reservation has been done',
  `zone_id` int(2) NOT NULL COMMENT 'ID of the zone where reservations has been done',
  `user_id` int(6) NOT NULL COMMENT 'ID of the user who has done the reservation',
  `reservation_status` varchar(1) NOT NULL COMMENT 'Status of the reservation (Active = A) (Inactive = "I") ',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user who has done last transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When the last transaction has been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabal de reservas';

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `reservation_date`, `hour_id`, `zone_id`, `user_id`, `reservation_status`, `user_modification`, `timestamp`) VALUES
(2, '2021-03-15', 1, 1, 3, 'A', 999999, '2021-02-28 17:02:00'),
(5, '2021-01-28', 1, 1, 3, 'I', 999999, '2021-02-28 17:04:11'),
(6, '2021-03-28', 1, 1, 3, 'I', 999999, '2021-02-28 17:06:36'),
(7, '2021-03-15', 2, 1, 1, 'A', 999999, '2021-02-28 17:06:36'),
(8, '2021-03-28', 3, 3, 1, 'A', 999999, '2021-02-28 17:06:36'),
(10, '2021-04-28', 4, 6, 1, 'A', 999999, '2021-02-28 17:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(6) NOT NULL COMMENT 'ID of the user',
  `user_type` varchar(1) NOT NULL COMMENT 'Type of user ["A"=Admin, "G"=generic]',
  `card_number` int(6) NOT NULL COMMENT 'Card number',
  `user_status` tinyint(1) NOT NULL COMMENT 'User status (Active =>False=0, True=1]',
  `user_email` varchar(50) NOT NULL COMMENT 'User email',
  `user_password` varchar(8) NOT NULL COMMENT 'Password of the user',
  `user_name` varchar(100) NOT NULL COMMENT 'User name & surnames',
  `start_date_user` date NOT NULL COMMENT 'Date when user has been suscribed',
  `end_date_user` date NOT NULL COMMENT 'Date when user has been unsubscribed',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user Who has done the transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'When transaccion has done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de usuarios';

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `user_type`, `card_number`, `user_status`, `user_email`, `user_password`, `user_name`, `start_date_user`, `end_date_user`, `user_modification`, `timestamp`) VALUES
(1, 'A', 108, 1, 'plosky21@hotmail.com', 'P@sswor1', 'Sandra Arcas', '2020-01-01', '0000-00-00', 1, '2021-03-14 19:26:31'),
(2, 'G', 25, 0, 'email1@hotmail.com', 'P@sswor1', 'Name1 Surname1 Surname2', '2019-01-01', '2021-01-01', 999999, '2021-03-05 16:09:28'),
(3, 'G', 400, 1, 'email2@hotmail.com', 'P@sswor1', 'Name2 Surname1 Surname2', '2020-01-01', '0000-00-00', 1, '2021-03-08 10:49:50'),
(4, 'G', 108, 1, 'email3@hotmail.com', 'P@sswor1', 'Name3 Surname1 Surname2', '2020-01-01', '0000-00-00', 1, '2021-03-08 10:49:50'),
(5, 'G', 123, 1, 'email4@hotmail.com', 'P@sswor1', 'Name4 Surname1 Surname2', '2020-01-01', '0000-00-00', 1, '2021-03-08 10:49:50'),
(6, 'G', 325, 1, 'email5@hotmail.com', 'P@sswor1', 'Name5 Surname1 Surname2', '2020-01-01', '0000-00-00', 1, '2021-03-08 10:49:50');

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
(3, 'Placa desplomada', 2, 'I', 1, '2021-03-15 09:59:04'),
(4, 'Plafón', 2, 'A', 1, '2021-03-15 12:15:34'),
(6, 'Vía R1', 2, 'A', 1, '2021-03-15 12:16:11'),
(7, 'Vía R2', 2, 'I', 1, '2021-03-15 09:58:50'),
(8, 'Vía R3', 2, 'A', 1, '2021-03-15 09:59:33'),
(9, 'Vía R4', 2, 'A', 999999, '2021-03-08 16:33:20'),
(10, 'Vía R5', 2, 'A', 1, '2021-03-15 09:58:17'),
(11, 'Caballo', 2, 'A', 999999, '2021-03-13 22:51:23');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hours`
--
ALTER TABLE `hours`
  ADD PRIMARY KEY (`id_hours`),
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
  MODIFY `id_hours` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID of the time zone', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID of reservation', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID of the user', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `zones`
--
ALTER TABLE `zones`
  MODIFY `id_zone` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID of the zone', AUTO_INCREMENT=70;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`hour_id`) REFERENCES `hours` (`id_hours`),
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id_zone`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
