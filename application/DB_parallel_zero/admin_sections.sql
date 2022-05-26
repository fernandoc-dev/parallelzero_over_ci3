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
  `table_section` varchar(99) NOT NULL,
  `section_singular` varchar(50) DEFAULT NULL,
  `section_plural` varchar(50) DEFAULT NULL,
  `menu_open` varchar(99) DEFAULT NULL,
  `menu_active` varchar(99) DEFAULT NULL,
  `menu_active_2` varchar(99) DEFAULT NULL,
  `dont_show` varchar(99) DEFAULT NULL,
  `dependencies` varchar(255) DEFAULT NULL,
  `view_read_all` varchar(255) NOT NULL DEFAULT 'generic',
  `view_update` varchar(255) NOT NULL DEFAULT 'generic',
  `view_create` varchar(255) NOT NULL DEFAULT 'generic',
  `role_read_all` tinyint(1) NOT NULL DEFAULT 1,
  `role_create` tinyint(1) NOT NULL DEFAULT 1,
  `role_update` tinyint(1) NOT NULL DEFAULT 1,
  `role_delete` tinyint(1) NOT NULL DEFAULT 1,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admin_sections`
--

INSERT INTO `admin_sections` (`id`, `section`, `activated`, `table_section`, `section_singular`, `section_plural`, `menu_open`, `menu_active`, `menu_active_2`, `dont_show`, `dependencies`, `view_read_all`, `view_update`, `view_create`, `role_read_all`, `role_create`, `role_update`, `role_delete`, `deleted`) VALUES
(1, 'articles', 1, 'articles', 'an article', 'articles', 'articles', 'articles', '', 'articles', 'summernote,select2,switch', 'generic', 'generic', 'generic', 1, 1, 1, 1, 0),
(2, 'users', 1, 'users', 'an user', 'users', 'Users', 'Users', '', 'users-admin', '', 'generic', 'generic', 'generic', 1, 1, 1, 1, 0),
(3, 'admin_sections', 1, 'admin_sections', 'Admin section', 'Admin Sections', 'Admin sections', 'activated_sections', 'activated_sections', NULL, NULL, 'generic', 'generic', 'generic', 1, 1, 1, 1, 0),
(5, 'dont_show', 1, 'dont_show', 'don\'t show record', 'don\'t show records', 'Don\'t show', 'Don\'t show', 'Don\'t show', '', NULL, 'generic', 'generic', 'generic', 1, 1, 1, 1, 0),
(6, 'menu', 1, 'admin_menu', 'Menu item', 'Menu items', 'Admin menu', 'Admin menu', '', 'admin_menu', '', 'generic', 'generic', 'generic', 1, 1, 1, 1, 0),
(7, 'icons', 1, 'icons', 'an icon', 'icons', 'Icons', 'Icons', '', 'icons', NULL, 'generic/responsive_hover_table_for_icons', 'generic', 'generic', 1, 1, 1, 1, 0),
(8, 'welcome_admin', 1, 'NULL', 'welcome', 'welcome', 'Welcome', 'Welcome', 'Welcome', '', '', 'generic', 'generic', 'generic', 1, 1, 1, 1, 0),
(9, 'articles_blog_admin', 1, 'articles', 'an article', 'articles', 'Articles', 'Articles', 'All articles', 'articles', 'summernote,select2,switch', 'blog_admin/responsive_hover_table_for_articles', 'blog_admin/update_article_form', 'blog_admin/create_article_form', 1, 1, 1, 1, 0),
(10, 'menu_dedicated', 1, 'admin_menu', 'menu', 'menues', NULL, 'Admin menu', NULL, NULL, NULL, 'generic', 'generic', 'generic', 1, 1, 1, 1, 0);

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
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
