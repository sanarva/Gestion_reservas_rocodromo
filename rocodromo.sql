-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 28-02-2021 a las 19:11:10
-- Versión del servidor: 10.4.14-MariaDB
-- Versión de PHP: 7.4.11

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
  `id_hours` int(2) NOT NULL COMMENT 'ID of the time zone',
  `id_start_hour` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Hour when reservation starts',
  `id_end_hour` int(4) UNSIGNED ZEROFILL NOT NULL COMMENT 'Hour when reservation finishes',
  `week_day` varchar(7) NOT NULL COMMENT 'Array with active week day ([LMXJVSD] for all week days)',
  `user_modification` int(6) NOT NULL COMMENT 'ID of th user who has done the transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When the transaction was done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `reservations`
--

CREATE TABLE `reservations` (
  `id_reservation` int(6) NOT NULL COMMENT 'ID of reservation',
  `reservation_date` date NOT NULL COMMENT 'Date when reservation has been done',
  `hour_id` int(2) NOT NULL COMMENT 'ID of the time zone when reservation has been done',
  `zone_id` int(2) NOT NULL COMMENT 'ID of the zone where reservations has been done',
  `user_id` int(6) NOT NULL COMMENT 'IF of the user who has done the reservation',
  `reservation_status` tinyint(1) NOT NULL COMMENT 'Status of the reservation [Active=> False=0, True=1]',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user who has done last transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() COMMENT 'When the last transaction has been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabal de reservas';


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id_user` int(6) NOT NULL COMMENT 'ID of the user',
  `user_type` varchar(1) NOT NULL COMMENT 'Type of user ["A"=Admin, "G"=generic]',
  `card_number` int(6) NOT NULL COMMENT 'Card number',
  `user_status` tinyint(1) NOT NULL COMMENT 'User status (Active =>False=0, True=1]',
  `user_email` varchar(50) NOT NULL COMMENT 'User email',
  `user_name` varchar(100) NOT NULL COMMENT 'User name & surnames',
  `start_date_user` date NOT NULL COMMENT 'Date when user has been suscribed',
  `end_date_user` date NOT NULL COMMENT 'Date when user has been unsubscribed',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user Who has done the transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'When transaccion has done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Tabla de usuarios';


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `zones`
--

CREATE TABLE `zones` (
  `id_zone` int(2) NOT NULL COMMENT 'ID of the zone',
  `zone_name` varchar(30) NOT NULL COMMENT 'Name of the zone',
  `max_users_zone` int(2) NOT NULL COMMENT 'Maximun users number in an specific zone',
  `zone_status` tinyint(1) NOT NULL COMMENT 'Status of the zone (Active = True)',
  `user_modification` int(6) NOT NULL COMMENT 'ID of the user who has done the last transaction',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() COMMENT 'When the last transaction has been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `hours`
--
ALTER TABLE `hours`
  ADD PRIMARY KEY (`id_hours`),
  ADD UNIQUE KEY `id_start_hour` (`id_start_hour`,`id_end_hour`);

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
  MODIFY `id_hours` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID of the time zone', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id_reservation` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID of reservation', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(6) NOT NULL AUTO_INCREMENT COMMENT 'ID of the user', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `zones`
--
ALTER TABLE `zones`
  MODIFY `id_zone` int(2) NOT NULL AUTO_INCREMENT COMMENT 'ID of the zone', AUTO_INCREMENT=11;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `reservations_ibfk_3` FOREIGN KEY (`hour_id`) REFERENCES `hours` (`id_hours`),
  ADD CONSTRAINT `reservations_ibfk_4` FOREIGN KEY (`zone_id`) REFERENCES `zones` (`id_zone`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
