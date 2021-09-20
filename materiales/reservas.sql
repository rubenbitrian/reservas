-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-09-2021 a las 20:03:03
-- Versión del servidor: 10.4.21-MariaDB
-- Versión de PHP: 7.4.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `reservas`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boking`
--

CREATE TABLE `boking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `mobile_home_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `boking`
--

INSERT INTO `boking` (`id`, `user_id`, `state_id`, `mobile_home_id`, `start_date`, `end_date`) VALUES
(1, 1, 2, 1, '2021-09-17', '2021-09-19'),
(2, 1, 2, 1, '2021-09-24', '2021-09-26'),
(3, 2, 2, 1, '2021-10-08', '2021-10-12'),
(4, 3, 2, 1, '2021-10-29', '2021-11-01');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `doctrine_migration_versions`
--

CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Volcado de datos para la tabla `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20210914092625', '2021-09-17 19:22:00', 211);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `mobile_home`
--

CREATE TABLE `mobile_home` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `mobile_home`
--

INSERT INTO `mobile_home` (`id`, `name`) VALUES
(1, 'Principal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `state`
--

CREATE TABLE `state` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `state`
--

INSERT INTO `state` (`id`, `name`) VALUES
(1, 'Pendiente'),
(2, 'Reservado'),
(3, 'Cancelado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `user_group_id` int(11) DEFAULT NULL,
  `nombre` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellidos` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` longtext COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '(DC2Type:json)',
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `user_group_id`, `nombre`, `apellidos`, `email`, `roles`, `password`) VALUES
(1, 1, 'José Luis', 'Bitrián Esquillor', 'joseluisbitrian@yahoo.es', '', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO'),
(2, 2, 'Rubén', 'Bitrián Crespo', 'rbitrian@gmail.com', '[\"ROLE_ADMIN\"]', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO'),
(3, 3, 'David', 'Bitrián Crespo', 'jdbitrian@gmail.com', '', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO'),
(4, 4, 'Ester', 'Bitrián Crespo', 'esterbitrian@yahoo.es', '', '$2y$13$Jmaqlq10jGku4gd7zdegzOtzNc964vLA6KW8td2xnaVdfDnrCKGKO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user_group`
--

CREATE TABLE `user_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `user_group`
--

INSERT INTO `user_group` (`id`, `name`, `color`) VALUES
(1, 'Propietarios', '#0F0'),
(2, 'Bitrián Andaluz', '#FF0'),
(3, 'Bitrián Rodríguez', '#0BF'),
(4, 'Secretaria central de reservas', '#FA0');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boking`
--
ALTER TABLE `boking`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_6C15DD11A76ED395` (`user_id`),
  ADD KEY `IDX_6C15DD115D83CC1` (`state_id`),
  ADD KEY `IDX_6C15DD11C8670569` (`mobile_home_id`);

--
-- Indices de la tabla `doctrine_migration_versions`
--
ALTER TABLE `doctrine_migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indices de la tabla `mobile_home`
--
ALTER TABLE `mobile_home`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `state`
--
ALTER TABLE `state`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_8D93D649E7927C74` (`email`),
  ADD KEY `IDX_8D93D6491ED93D47` (`user_group_id`);

--
-- Indices de la tabla `user_group`
--
ALTER TABLE `user_group`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boking`
--
ALTER TABLE `boking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `mobile_home`
--
ALTER TABLE `mobile_home`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `state`
--
ALTER TABLE `state`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `user_group`
--
ALTER TABLE `user_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `boking`
--
ALTER TABLE `boking`
  ADD CONSTRAINT `FK_6C15DD115D83CC1` FOREIGN KEY (`state_id`) REFERENCES `state` (`id`),
  ADD CONSTRAINT `FK_6C15DD11A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_6C15DD11C8670569` FOREIGN KEY (`mobile_home_id`) REFERENCES `mobile_home` (`id`);

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `FK_8D93D6491ED93D47` FOREIGN KEY (`user_group_id`) REFERENCES `user_group` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
