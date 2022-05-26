-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 02-05-2022 a las 04:53:20
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
-- Estructura de tabla para la tabla `admin_menu`
--

CREATE TABLE `admin_menu` (
  `id` int(3) UNSIGNED NOT NULL,
  `item` varchar(50) NOT NULL,
  `role` int(1) NOT NULL DEFAULT 1,
  `level` tinyint(1) NOT NULL,
  `icon` varchar(50) DEFAULT 'far fa-circle',
  `link` varchar(99) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `item`, `role`, `level`, `icon`, `link`, `deleted`) VALUES
(1, 'Users', 1, 1, 'fas fa-users', 'admin/users_admin/users', 0),
(2, 'New', 1, 2, 'fas fa-user-plus', 'admin/users_admin/users', 0),
(3, 'Update', 5, 2, 'fas fa-user-edit', 'admin/users_admin/users', 0),
(4, 'Articles', 1, 1, 'fas fa-newspaper', 'admin/blog_admin/new_article', 0),
(5, 'All articles', 1, 2, 'fas fa-newspaper', 'admin/generic_crud/read_all/articles', 0),
(6, 'New article', 1, 2, 'fas fa-folder-plus', 'admin/blog_admin/register', 0),
(7, 'Categories', 1, 2, 'far fa-circle', 'admin/blog_admin/categories', 0),
(8, 'Admin menu', 1, 1, 'fa-solid fa-arrow-down-short-wide', 'admin/generic_crud/read_all/menu', 0),
(11, 'Icons', 1, 1, 'fa-solid fa-at', 'admin/generic_crud/read_all/icons', 0),
(12, 'Don\'t show', 1, 1, 'fa-solid fa-ban', 'admin/generic_crud/read_all/dont_show', 0),
(13, 'Admin sections', 1, 1, 'fa-solid fa-arrow-up-right-from-square', 'admin/generic_crud/read_all/sections', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item` (`item`),
  ADD KEY `item_2` (`item`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
