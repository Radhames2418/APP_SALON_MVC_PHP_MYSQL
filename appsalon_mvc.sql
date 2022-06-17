-- phpMyAdmin SQL Dump
-- version 5.3.0-dev+20220616.7a6bd9eb57
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 17-06-2022 a las 22:05:18
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `appsalon_mvc`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citas`
--

CREATE TABLE `citas` (
  `id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `usuarioId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `citas`
--

INSERT INTO `citas` (`id`, `fecha`, `hora`, `usuarioId`) VALUES
(75, '2022-10-15', '10:15:00', 5),
(76, '2022-06-20', '17:17:00', 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `citasservicios`
--

CREATE TABLE `citasservicios` (
  `id` int(11) NOT NULL,
  `citaId` int(11) DEFAULT NULL,
  `servicioId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `citasservicios`
--

INSERT INTO `citasservicios` (`id`, `citaId`, `servicioId`) VALUES
(80, 76, 1),
(81, 76, 2),
(82, NULL, 1),
(83, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `servicios`
--

CREATE TABLE `servicios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `precio` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `servicios`
--

INSERT INTO `servicios` (`id`, `nombre`, `precio`) VALUES
(1, 'Corte de cabello Mujer', '80.99'),
(2, 'Corte de cabello Hombre', '80.00'),
(3, 'Corte de cabello Niño', '60.00'),
(4, 'Peinado Mujer', '80.00'),
(5, 'Peinado Hombre', '60.00'),
(6, 'Peinado Niño', '60.00'),
(7, 'Corte de Barba', '60.00'),
(8, 'Uñas', '400.00'),
(9, 'Lavado de cabello', '50.00'),
(10, 'Transplante capilar', '150.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `apellido` varchar(60) COLLATE utf8_bin DEFAULT NULL,
  `email` varchar(30) COLLATE utf8_bin DEFAULT NULL,
  `password` varchar(60) COLLATE utf8_bin NOT NULL,
  `telefono` varchar(10) COLLATE utf8_bin DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  `confirmado` tinyint(1) DEFAULT NULL,
  `token` varchar(15) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `telefono`, `admin`, `confirmado`, `token`) VALUES
(1, 'Radhames', 'Encarnacion', 'correo@correo.com', '$2y$10$ovOKA02KHBe.tl8avzYhu.gdyoAbVi6rOCn/yZJBETvRyBinqX0fO', '8492052418', 1, 1, ''),
(2, ' Radhames', 'Encarnacion', 'Radhamesenc2412002@gmail.com', '$2y$10$MosgUOGiCgQ7ndBFWR1hAuQPKY5MnYs84/LRpDrUDC4dlrF6ZV0Jm', '8294681768', 0, 0, '62994bb19033a '),
(3, ' Radhames', 'Encarnacion', 'Radhamesenc2412005@gmail.com', '$2y$10$qUxB0ry6g3NUvnOcVJ1eteBK5waFN6MOqYMBTyyam3hNHUzAvhWCa', '8294681768', 0, 0, '62994cfdd87e2 '),
(4, ' Llecenia', 'Encarnacion', 'correo5@correo.com', '$2y$10$dezrP1WPf4bmWpu8prSi3e7qbq4YjaDF98.wgQ94V/ftMeSjhLXcC', '8294681768', 0, 1, ''),
(5, ' Marino', 'Encarnacion', 'Marino@correo.com', '$2y$10$zSDwz3HX8ngXHBZIqs6ZeupuKDxPriNTA9n8jU4vie59a5jDh/K2S', '8294681768', 0, 1, '62a02c5bd8085');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `citas`
--
ALTER TABLE `citas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioId` (`usuarioId`);

--
-- Indices de la tabla `citasservicios`
--
ALTER TABLE `citasservicios`
  ADD PRIMARY KEY (`id`),
  ADD KEY `citasservicios_ibfk_1` (`citaId`),
  ADD KEY `citasservicios_ibfk_2` (`servicioId`);

--
-- Indices de la tabla `servicios`
--
ALTER TABLE `servicios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `citas`
--
ALTER TABLE `citas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT de la tabla `citasservicios`
--
ALTER TABLE `citasservicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT de la tabla `servicios`
--
ALTER TABLE `servicios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `citas`
--
ALTER TABLE `citas`
  ADD CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;

--
-- Filtros para la tabla `citasservicios`
--
ALTER TABLE `citasservicios`
  ADD CONSTRAINT `citasservicios_ibfk_1` FOREIGN KEY (`citaId`) REFERENCES `citas` (`id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `citasservicios_ibfk_2` FOREIGN KEY (`servicioId`) REFERENCES `servicios` (`id`) ON DELETE SET NULL ON UPDATE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;



