-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-05-2021 a las 22:51:45
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `rocodromo`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `hours`
--

CREATE TABLE `hours` (
  `id_hour` int(3) NOT NULL COMMENT 'ID of the time zone',
  `start_hour` varchar(5) NOT NULL COMMENT 'Hour when reservation starts',
  `end_hour` varchar(5) NOT NULL COMMENT 'Hour when reservation finishes',
  `week_day` varchar(7) NOT NULL COMMENT 'Array with active week day ([LMXJVSD] for all week days)',
  `user_modification` int(6) NOT NULL COMMENT 'ID of th user who has done the transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When the transaction was done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `hours`
--

INSERT INTO `hours` (`id_hour`, `start_hour`, `end_hour`, `week_day`, `user_modification`, `timestamp`) VALUES
(1, '08:00', '10:00', 'LMXJVSD', 999999, '2021-05-18 22:17:05'),
(2, '10:00', '12:00', 'LMXJVSD', 999999, '2021-05-18 22:17:22'),
(3, '12:00', '14:00', 'LMXJVSD', 999999, '2021-05-18 22:17:38'),
(4, '14:00', '16:00', 'LMXJVSD', 999999, '2021-05-18 22:17:51'),
(5, '16:00', '18:00', 'LMXJVSD', 999999, '2021-05-18 22:18:03'),
(6, '18:00', '20:00', 'LMXJVSD', 999999, '2021-05-18 22:18:20'),
(7, '20:00', '22:00', 'LMXJVSD', 999999, '2021-05-18 22:19:27');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(7) NOT NULL COMMENT 'ID of reservation',
  `id_related_reservation` int(7) NOT NULL COMMENT 'ID which links double reservations in routes zone',
  `reservation_date` date NOT NULL COMMENT 'Date when reservation has been done',
  `hour_id` int(3) NOT NULL COMMENT 'ID of the time zone when reservation has been done',
  `zone_id` int(3) NOT NULL COMMENT 'ID of the zone where reservations has been done',
  `user_id` int(6) NOT NULL COMMENT 'ID of the reservation user',
  `reservation_status` varchar(1) NOT NULL COMMENT 'Status of the reservation (Active = A) (Inactive = "I") (Pending confirmation = "P" or "C" [C is who should confirm]) (Without rope team = "W")',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user who has done last transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When the last transaction has been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabal de reservas';

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `id_related_reservation`, `reservation_date`, `hour_id`, `zone_id`, `user_id`, `reservation_status`, `user_modification`, `timestamp`) VALUES
(10, 0, '2021-03-07', 4, 6, 1, 'I', 1, '2021-05-13 09:34:23'),
(11, 0, '2021-04-20', 7, 10, 3, 'I', 1, '2021-05-13 09:34:23'),
(15, 0, '2021-04-15', 2, 10, 5, 'I', 1, '2021-05-13 09:34:23'),
(16, 0, '2021-04-28', 2, 6, 1, 'I', 1, '2021-05-13 09:34:23'),
(20, 0, '2021-04-02', 7, 6, 3, 'I', 1, '2021-05-13 09:34:23'),
(21, 0, '2021-04-14', 7, 6, 3, 'I', 1, '2021-05-13 09:34:23'),
(25, 0, '2021-04-14', 7, 10, 3, 'I', 1, '2021-05-13 09:34:23'),
(26, 0, '2021-04-14', 5, 10, 3, 'I', 1, '2021-05-13 09:34:23'),
(31, 0, '2021-04-14', 7, 9, 3, 'I', 1, '2021-05-13 09:34:23'),
(34, 0, '2021-04-16', 7, 6, 3, 'I', 1, '2021-05-13 09:34:23'),
(37, 0, '2021-04-14', 2, 4, 3, 'I', 1, '2021-05-13 09:34:23'),
(38, 0, '2021-04-13', 7, 9, 1, 'I', 1, '2021-05-13 09:34:23'),
(41, 0, '2021-04-25', 4, 4, 3, 'I', 1, '2021-05-13 09:34:23'),
(44, 0, '2021-04-27', 2, 6, 5, 'I', 1, '2021-05-13 09:34:23'),
(48, 0, '2021-04-14', 2, 4, 1, 'I', 1, '2021-05-13 09:34:23'),
(50, 0, '2021-04-16', 4, 6, 1, 'I', 1, '2021-05-13 09:34:23'),
(51, 0, '2021-04-30', 5, 10, 3, 'I', 1, '2021-05-13 09:34:23'),
(54, 0, '2021-04-27', 7, 7, 1, 'I', 1, '2021-05-13 09:34:23'),
(55, 0, '2021-04-20', 7, 10, 1, 'I', 1, '2021-05-13 09:34:23'),
(56, 0, '2021-04-20', 2, 4, 1, 'I', 1, '2021-05-13 09:34:23'),
(62, 0, '2021-04-26', 4, 4, 1, 'I', 1, '2021-05-13 09:34:23'),
(76, 0, '2021-04-23', 7, 4, 1, 'I', 1, '2021-05-13 09:34:23'),
(91, 0, '2021-04-29', 7, 7, 3, 'I', 1, '2021-05-13 09:34:23'),
(99, 0, '2021-04-27', 7, 4, 3, 'I', 1, '2021-05-13 09:34:23'),
(101, 0, '2021-04-30', 2, 4, 3, 'I', 1, '2021-05-13 09:34:23'),
(102, 10, '2021-04-28', 2, 4, 3, 'I', 999999, '2021-05-13 09:27:34'),
(108, 0, '2021-04-29', 2, 6, 3, 'I', 1, '2021-05-13 09:34:23'),
(125, 11, '2021-04-27', 7, 9, 4, 'I', 4, '2021-04-23 19:24:12'),
(126, 11, '2021-04-27', 7, 9, 4, 'I', 4, '2021-04-23 19:24:18'),
(174, 14, '2021-04-30', 7, 6, 3, 'I', 999999, '2021-05-13 09:27:34'),
(175, 14, '2021-04-30', 7, 6, 4, 'I', 999999, '2021-05-13 09:27:34'),
(176, 15, '2021-04-30', 7, 9, 1, 'I', 999999, '2021-05-13 09:27:34'),
(177, 15, '2021-04-30', 7, 9, 1, 'I', 999999, '2021-05-13 09:27:34'),
(178, 16, '2021-04-30', 7, 7, 6, 'I', 999999, '2021-05-13 09:27:34'),
(179, 16, '2021-04-30', 7, 7, 6, 'I', 999999, '2021-05-13 09:27:34'),
(191, 19, '2021-05-15', 2, 6, 4, 'I', 1, '2021-05-13 09:48:25'),
(192, 19, '2021-05-15', 2, 6, 3, 'I', 1, '2021-05-13 09:48:25'),
(204, 23, '2021-05-15', 5, 7, 5, 'I', 1, '2021-05-13 10:07:19'),
(205, 23, '2021-05-15', 5, 7, 3, 'I', 1, '2021-05-13 10:07:19'),
(207, 24, '2021-05-16', 2, 7, 5, 'I', 1, '2021-05-13 10:29:36'),
(208, 24, '2021-05-16', 2, 7, 3, 'I', 1, '2021-05-13 10:29:36'),
(210, 25, '2021-05-16', 2, 7, 5, 'I', 1, '2021-05-13 10:30:54'),
(211, 25, '2021-05-16', 2, 7, 3, 'I', 1, '2021-05-13 10:30:54'),
(214, 27, '2021-05-16', 2, 10, 5, 'I', 1, '2021-05-13 10:36:02'),
(215, 27, '2021-05-16', 2, 10, 3, 'I', 1, '2021-05-13 10:36:02'),
(216, 28, '2021-05-16', 2, 7, 5, 'I', 1, '2021-05-13 10:40:47'),
(217, 28, '2021-05-16', 2, 7, 5, 'I', 1, '2021-05-13 10:40:47'),
(221, 30, '2021-05-16', 2, 6, 5, 'I', 1, '2021-05-13 10:47:01'),
(222, 30, '2021-05-16', 2, 6, 3, 'I', 1, '2021-05-13 10:47:01'),
(224, 31, '2021-05-14', 6, 9, 1, 'I', 1, '2021-05-13 13:58:40'),
(225, 31, '2021-05-14', 6, 9, 1, 'I', 1, '2021-05-13 13:58:40'),
(240, 37, '2021-05-14', 6, 10, 1, 'I', 999999, '2021-05-18 06:57:43'),
(241, 37, '2021-05-14', 6, 10, 1, 'I', 999999, '2021-05-18 06:57:43'),
(245, 0, '2021-05-29', 1, 1, 4, 'I', 4, '2021-05-27 09:55:17'),
(249, 40, '2021-05-15', 4, 6, 3, 'I', 1, '2021-05-13 15:29:40'),
(250, 40, '2021-05-15', 4, 6, 5, 'I', 1, '2021-05-13 15:29:40'),
(253, 42, '2021-05-16', 2, 7, 4, 'I', 999999, '2021-05-18 06:57:43'),
(254, 42, '2021-05-16', 2, 7, 4, 'I', 999999, '2021-05-18 06:57:43'),
(262, 45, '2021-05-19', 7, 6, 4, 'I', 999999, '2021-05-20 09:19:04'),
(263, 45, '2021-05-19', 7, 6, 3, 'I', 999999, '2021-05-20 09:19:04'),
(265, 46, '2021-05-25', 7, 8, 3, 'I', 999999, '2021-05-27 07:43:13'),
(266, 46, '2021-05-25', 7, 8, 3, 'I', 999999, '2021-05-27 07:43:13'),
(267, 0, '2021-05-22', 6, 4, 3, 'I', 1, '2021-05-21 15:57:04'),
(268, 47, '2021-06-08', 5, 6, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(269, 47, '2021-06-08', 5, 6, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(270, 48, '2021-06-08', 6, 6, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(271, 48, '2021-06-08', 6, 6, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(272, 49, '2021-06-08', 7, 6, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(273, 49, '2021-06-08', 7, 6, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(274, 50, '2021-06-08', 5, 7, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(275, 50, '2021-06-08', 5, 7, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(276, 51, '2021-06-08', 6, 7, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(277, 51, '2021-06-08', 6, 7, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(278, 52, '2021-05-27', 7, 7, 1, 'I', 1, '2021-05-21 07:24:43'),
(279, 52, '2021-05-27', 7, 7, 1, 'I', 1, '2021-05-21 07:24:43'),
(280, 53, '2021-05-27', 5, 8, 1, 'I', 1, '2021-05-21 09:33:43'),
(281, 53, '2021-05-27', 5, 8, 1, 'I', 1, '2021-05-21 09:33:43'),
(282, 54, '2021-05-27', 6, 8, 1, 'I', 1, '2021-05-21 10:07:10'),
(283, 54, '2021-05-27', 6, 8, 1, 'I', 1, '2021-05-21 10:07:10'),
(284, 55, '2021-05-27', 7, 8, 1, 'I', 1, '2021-05-21 07:23:14'),
(285, 55, '2021-05-27', 7, 8, 1, 'I', 1, '2021-05-21 07:23:14'),
(286, 56, '2021-06-08', 5, 8, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(287, 56, '2021-06-08', 5, 8, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(288, 57, '2021-06-08', 5, 9, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(289, 57, '2021-06-08', 5, 9, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(290, 58, '2021-06-08', 5, 10, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(291, 58, '2021-06-08', 5, 10, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(292, 59, '2021-06-08', 6, 8, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(293, 59, '2021-06-08', 6, 8, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(294, 60, '2021-06-08', 6, 9, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(295, 60, '2021-06-08', 6, 9, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(296, 61, '2021-06-08', 6, 10, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(297, 61, '2021-06-08', 6, 10, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(298, 62, '2021-06-08', 7, 7, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(299, 62, '2021-06-08', 7, 7, 1, 'W', 88888888, '2021-05-27 17:12:11'),
(300, 63, '2021-05-27', 7, 8, 1, 'I', 1, '2021-05-21 14:11:06'),
(301, 63, '2021-05-27', 7, 8, 1, 'I', 1, '2021-05-21 14:11:06'),
(302, 64, '2021-06-08', 7, 9, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(303, 64, '2021-06-08', 7, 9, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(304, 65, '2021-06-08', 7, 10, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(305, 65, '2021-06-08', 7, 10, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(306, 0, '2021-05-27', 5, 1, 5, 'I', 5, '2021-05-21 14:12:30'),
(307, 66, '2021-05-28', 7, 2, 5, 'I', 5, '2021-05-27 09:31:08'),
(308, 66, '2021-05-28', 7, 2, 5, 'I', 5, '2021-05-27 09:31:08'),
(309, 67, '2021-05-29', 1, 6, 5, 'I', 5, '2021-05-21 14:19:14'),
(310, 67, '2021-05-29', 1, 6, 1, 'I', 5, '2021-05-21 14:19:14'),
(311, 68, '2021-05-30', 4, 7, 5, 'I', 5, '2021-05-21 14:21:39'),
(312, 68, '2021-05-30', 4, 7, 5, 'I', 5, '2021-05-21 14:21:39'),
(313, 0, '2021-05-23', 2, 5, 6, 'I', 5, '2021-05-21 14:23:35'),
(314, 0, '2021-05-22', 2, 4, 6, 'I', 999999, '2021-05-27 07:43:13'),
(315, 0, '2021-05-29', 5, 4, 4, 'I', 4, '2021-05-27 09:31:57'),
(316, 69, '2021-05-23', 5, 8, 4, 'I', 4, '2021-05-21 15:10:59'),
(317, 69, '2021-05-23', 5, 8, 6, 'I', 4, '2021-05-21 15:10:59'),
(318, 70, '2021-05-28', 5, 7, 4, 'I', 4, '2021-05-21 15:53:09'),
(319, 70, '2021-05-28', 5, 7, 4, 'I', 4, '2021-05-21 15:53:09'),
(320, 0, '2021-06-08', 7, 2, 1, 'A', 88888888, '2021-05-27 17:12:11'),
(321, 0, '2021-05-27', 6, 1, 1, 'I', 1, '2021-05-27 10:00:33'),
(322, 0, '2021-05-28', 1, 5, 5, 'I', 5, '2021-05-27 09:56:38'),
(323, 0, '2021-05-28', 2, 5, 4, 'A', 4, '2021-05-27 09:52:16'),
(324, 71, '2021-05-28', 4, 10, 5, 'I', 4, '2021-05-27 10:06:14'),
(325, 71, '2021-05-28', 4, 10, 4, 'I', 4, '2021-05-27 10:06:14'),
(326, 72, '2021-05-30', 6, 6, 1, 'I', 1, '2021-05-27 10:02:34'),
(327, 72, '2021-05-30', 6, 6, 1, 'I', 1, '2021-05-27 10:02:34'),
(328, 73, '2021-05-30', 6, 7, 1, 'I', 1, '2021-05-27 10:12:29'),
(329, 73, '2021-05-30', 6, 7, 1, 'I', 1, '2021-05-27 10:12:29'),
(330, 74, '2021-05-28', 4, 8, 4, 'I', 4, '2021-05-27 10:09:21'),
(331, 74, '2021-05-28', 4, 8, 5, 'I', 4, '2021-05-27 10:09:21'),
(332, 0, '2021-05-29', 4, 4, 5, 'A', 5, '2021-05-27 10:07:34'),
(333, 75, '2021-05-28', 4, 9, 4, 'I', 4, '2021-05-27 10:10:27'),
(334, 75, '2021-05-28', 4, 9, 5, 'I', 4, '2021-05-27 10:10:27'),
(335, 76, '2021-05-28', 4, 10, 4, 'I', 4, '2021-05-27 10:15:47'),
(336, 76, '2021-05-28', 4, 10, 5, 'I', 4, '2021-05-27 10:15:47'),
(337, 0, '2021-05-30', 6, 1, 1, 'A', 1, '2021-05-27 10:12:29'),
(338, 0, '2021-05-28', 7, 2, 4, 'A', 4, '2021-05-27 10:15:47');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservationsconfig`
--

CREATE TABLE `reservationsconfig` (
  `id_config` int(3) NOT NULL COMMENT 'ID of the configuration',
  `max_reservation` int(2) NOT NULL COMMENT 'Maximun number of reservations by user',
  `max_users_route` int(2) NOT NULL COMMENT 'Número máximo de usuarios totales en la zona de vías',
  `start_free_date` date NOT NULL COMMENT 'Start free date for  reservations',
  `end_free_date` date NOT NULL COMMENT 'End free date for  reservations',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user who has done last transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'When last transaction has been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `reservationsconfig`
--

INSERT INTO `reservationsconfig` (`id_config`, `max_reservation`, `max_users_route`, `start_free_date`, `end_free_date`, `user_modification`, `timestamp`) VALUES
(1, 2, 6, '2021-05-01', '2021-05-30', 1, '2021-05-21 07:10:39');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
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
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `user_type`, `card_number`, `user_status`, `user_email`, `user_password`, `user_name`, `user_modification`, `timestamp`) VALUES
(1, 'A', 100, 'A', 'plosky21@hotmail.com', '$2y$10$KN53byzg.0fjivHRR4x8Yud47gbuN7VtVvVZdFCaWSR95z4qeZHXK', 'Escuela escalada', 1, '2021-04-27 07:24:35'),
(2, 'G', 200, 'I', 'email1@hotmail.com', 'Passwor1', 'Joan Espinosa', 1, '2021-05-20 13:56:43'),
(3, 'M', 300, 'A', 'guaubisabi@gmail.com', '$2y$10$NXyIGrmwzipqI5FpIJpR9eLdWVenNY9WgWE4K/qVVeIB79LSRgxhy', 'Felip Solsona', 1, '2021-05-21 07:02:52'),
(4, 'G', 400, 'A', 'ssaannddrruuss@gmail.com', '$2y$10$NeGc9aJbavkmCNHhBp9KGO9nI8Cbbmuzy5pbeqODrBnxKKyILoVkS', 'Sandra Ruiz', 1, '2021-05-20 10:18:09'),
(5, 'M', 500, 'A', 'sandra.arcas.valero@gmail.com', '$2y$10$6FLYWBqZUfL8fes/1a0eGOs3gNVvMRSs6gIZyC/NPN81IZ00HT7XS', 'Nuria Crespo', 1, '2021-05-20 16:10:32'),
(6, 'G', 600, 'A', 'info@guaubisabi.com', '$2y$10$dw5.l9NuOpOWRiHdkJFm5.9k7rc.9YREx0i0CtODLI2J0NWl5.SXi', 'Javier Maroto', 1, '2021-05-19 15:56:35'),
(7, 'G', 700, 'I', 'antonio@hotmail.com', '', 'Antonio Gonzalez', 1, '2021-05-28 10:19:21');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zones`
--

CREATE TABLE `zones` (
  `id_zone` int(3) NOT NULL COMMENT 'ID of the zone',
  `zone_name` varchar(30) NOT NULL COMMENT 'Name of the zone',
  `max_users_zone` int(2) NOT NULL COMMENT 'Maximun users number in an specific zone',
  `zone_status` varchar(1) NOT NULL COMMENT 'Status of the zone (Active = "A") (Inactive = "I"',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user who has done the last transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'When the last transaction has been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `zones`
--

INSERT INTO `zones` (`id_zone`, `zone_name`, `max_users_zone`, `zone_status`, `user_modification`, `timestamp`) VALUES
(1, 'Caballo', 2, 'A', 1, '2021-05-21 11:06:44'),
(2, 'Volúmenes', 3, 'A', 999999, '2021-05-18 23:35:01'),
(3, 'Placa desplomada', 2, 'A', 999999, '2021-05-18 23:35:01'),
(4, 'Moonboard', 2, 'A', 999999, '2021-05-18 23:35:01'),
(5, 'Plafón', 2, 'A', 999999, '2021-05-18 23:35:01'),
(6, 'Vía R1', 2, 'A', 1, '2021-05-19 11:16:20'),
(7, 'Vía R2', 2, 'A', 999999, '2021-05-18 23:35:01'),
(8, 'Vía R3', 2, 'A', 999999, '2021-05-18 23:35:01'),
(9, 'Vía R4', 2, 'A', 999999, '2021-05-18 23:35:01'),
(10, 'Vía R5', 2, 'A', 999999, '2021-05-18 23:35:01');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hours`
--
ALTER TABLE `hours`
  ADD PRIMARY KEY (`id_hour`),
  ADD UNIQUE KEY `id_start_hour` (`start_hour`,`end_hour`);

--
-- Indices de la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id_reservation`),
  ADD KEY `hour_id` (`hour_id`),
  ADD KEY `zone_id` (`zone_id`),
  ADD KEY `card_number_id` (`user_id`),
  ADD KEY `reservation_date` (`reservation_date`);

--
-- Indices de la tabla `reservationsconfig`
--
ALTER TABLE `reservationsconfig`
  ADD PRIMARY KEY (`id_config`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD KEY `card_number` (`card_number`,`user_status`,`user_name`);

--
-- Indices de la tabla `zones`
--
ALTER TABLE `zones`
  ADD PRIMARY KEY (`id_zone`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `hours`
--
ALTER TABLE `hours`
  MODIFY `id_hour` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ID of the time zone', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(7) NOT NULL AUTO_INCREMENT COMMENT 'ID of reservation', AUTO_INCREMENT=339;

--
-- AUTO_INCREMENT de la tabla `reservationsconfig`
--
ALTER TABLE `reservationsconfig`
  MODIFY `id_config` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ID of the configuration', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID of the user', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `zones`
--
ALTER TABLE `zones`
  MODIFY `id_zone` int(3) NOT NULL AUTO_INCREMENT COMMENT 'ID of the zone', AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id_zone`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_5` FOREIGN KEY (`hour_id`) REFERENCES `hours` (`id_hour`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `reservations_ibfk_6` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
