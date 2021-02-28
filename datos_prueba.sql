--
-- Volcado de datos para la tabla `hours`
--

INSERT INTO `hours` (`id_hours`, `id_start_hour`, `id_end_hour`, `week_day`, `user_modification`, `timestamp`) VALUES
(1, 0800, 0930, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(2, 1000, 1130, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(3, 1200, 1330, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(4, 1400, 1530, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(5, 1600, 1730, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(6, 1800, 1930, 'LMXJVSD', 999999, '2021-02-28 17:39:17'),
(7, 1945, 2115, 'LMXJVSD', 999999, '2021-02-28 17:39:17');

--
-- Volcado de datos para la tabla `reservations`
--

INSERT INTO `reservations` (`id_reservation`, `reservation_date`, `hour_id`, `zone_id`, `user_id`, `reservation_status`, `user_modification`, `timestamp`) VALUES
(2, '2021-03-15', 1, 1, 3, 1, 999999, '2021-02-28 18:02:00'),
(5, '2021-01-28', 1, 1, 3, 0, 999999, '2021-02-28 18:04:11'),
(6, '2021-03-28', 1, 1, 3, 0, 999999, '2021-02-28 18:06:36'),
(7, '2021-03-15', 2, 1, 1, 1, 999999, '2021-02-28 18:06:36'),
(8, '2021-03-28', 3, 3, 1, 1, 999999, '2021-02-28 18:06:36'),
(9, '2021-03-28', 4, 5, 1, 0, 999999, '2021-02-28 18:06:36'),
(10, '2021-04-28', 4, 6, 1, 1, 999999, '2021-02-28 18:06:36');

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id_user`, `user_type`, `card_number`, `user_status`, `user_email`, `user_name`, `start_date_user`, `end_date_user`, `user_modification`, `timestamp`) VALUES
(1, 'A', 108, 1, 'admin1@hotmail.com', 'Admin1 AdmiSurname1 AdmiSurname2', '2020-01-01', '0000-00-00', 999999, '2021-02-28 17:50:20'),
(2, 'G', 25, 0, 'email1@hotmail.com', 'Name1 Surname1 Surname2', '2019-01-01', '2021-01-01', 999999, '2021-02-28 17:54:41'),
(3, 'G', 400, 1, 'email2@hotmail.com', 'Name2 Surname1 Surname2', '2020-01-01', '0000-00-00', 999999, '2021-02-28 17:54:41'),
(4, 'G', 108, 1, 'email3@hotmail.com', 'Name3 Surname1 Surname2', '2020-01-01', '0000-00-00', 999999, '2021-02-28 17:54:41'),
(5, 'G', 123, 1, 'email4@hotmail.com', 'Name4 Surname1 Surname2', '2020-01-01', '0000-00-00', 999999, '2021-02-28 17:54:41'),
(6, 'G', 325, 1, 'email5@hotmail.com', 'Name5 Surname1 Surname2', '2020-01-01', '0000-00-00', 999999, '2021-02-28 17:54:41');


--
-- Volcado de datos para la tabla `zones`
--

INSERT INTO `zones` (`id_zone`, `zone_name`, `max_users_zone`, `zone_status`, `user_modification`, `timestamp`) VALUES
(1, 'Volúmenes', 3, 1, 999999, '2021-02-28 13:24:22'),
(2, 'Moonboard', 2, 1, 999999, '2021-02-28 13:24:22'),
(3, 'Placa desplomada', 2, 1, 999999, '2021-02-28 13:24:22'),
(4, 'Plafón', 2, 1, 999999, '2021-02-28 13:24:22'),
(5, 'Caballo', 2, 1, 999999, '2021-02-28 13:24:22'),
(6, 'Vía R1', 2, 1, 999999, '2021-02-28 13:24:22'),
(7, 'Vía R2', 2, 1, 999999, '2021-02-28 13:24:22'),
(8, 'Vía R3', 2, 1, 999999, '2021-02-28 13:24:22'),
(9, 'Vía R4', 2, 1, 999999, '2021-02-28 13:24:22'),
(10, 'Vía R5', 2, 1, 999999, '2021-02-28 13:24:23');
