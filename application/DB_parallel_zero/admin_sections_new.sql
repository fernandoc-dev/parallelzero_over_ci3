-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2022 a las 22:11:47
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
-- Base de datos: `parallel_zero`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin_sections`
--

CREATE TABLE `admin_sections` (
  `id` int(3) NOT NULL,
  `section` varchar(50) NOT NULL,
  `activated` tinyint(1) NOT NULL DEFAULT 1,
  `generic_activated` tinyint(1) NOT NULL DEFAULT 1,
  `table_section` varchar(99) NOT NULL,
  `section_singular` varchar(50) DEFAULT NULL,
  `section_plural` varchar(50) DEFAULT NULL,
  `menu_open` varchar(99) DEFAULT NULL,
  `menu_active` varchar(99) DEFAULT NULL,
  `menu_active_2` varchar(99) DEFAULT NULL,
  `dont_show` varchar(99) DEFAULT NULL,
  `dependencies` varchar(255) DEFAULT NULL,
  `view` varchar(255) NOT NULL DEFAULT 'generic',
  `role` tinyint(1) NOT NULL DEFAULT 1,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_sections`
--
ALTER TABLE `admin_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section` (`section`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_sections`
--
ALTER TABLE `admin_sections`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
