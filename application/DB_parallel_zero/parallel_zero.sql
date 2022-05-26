-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-01-2022 a las 23:18:45
-- Versión del servidor: 10.4.18-MariaDB
-- Versión de PHP: 7.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de datos: `parallel_zero`
--
CREATE DATABASE IF NOT EXISTS `parallel_zero` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `parallel_zero`;

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id_article` int(6) UNSIGNED NOT NULL AUTO_INCREMENT,
  `title_article` varchar(100) NOT NULL,
  `url_article` varchar(100) NOT NULL,
  `content_article` mediumtext NOT NULL,
  `author_article` int(3) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `realeased_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `state_article` tinyint(1) NOT NULL,
  `modified_by` tinyint(2) NOT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `main_category` int(3) NOT NULL,
  `subcategory1` int(3) DEFAULT NULL,
  `subcategory2` int(3) DEFAULT NULL,
  `description_article` varchar(255) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `deleted` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id_article`),
  UNIQUE KEY `title_article` (`title_article`),
  UNIQUE KEY `url_article` (`url_article`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id_article`, `title_article`, `url_article`, `content_article`, `author_article`, `created_at`, `realeased_at`, `expires_at`, `state_article`, `modified_by`, `modified_at`, `main_category`, `subcategory1`, `subcategory2`, `description_article`, `tags`, `deleted`) VALUES
(5, 'Artículo 1', 'articulo1', '<p>Este es el contenido del articulo 1</p>\r\n', 0, '2021-03-18 15:18:11', NULL, NULL, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(6, 'Artículo 2', 'articulo2', '<p>Este es el contenido del articulo 2</p>\r\n', 0, '2021-03-18 15:18:27', NULL, NULL, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(7, 'Artículo 3', 'articulo3', '<p>Este es el contenido del articulo 3</p>\r\n', 0, '2021-03-18 15:18:42', NULL, NULL, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL),
(8, 'El libro que hubiese querido tener al iniciarme en el mundo de la repostería saludable', 'home', '<p><img alt=\"\" src=\"https://postressaludables.com/wp-content/uploads/2021/01/7.png\"></p>\r\n\r\n<p>Con este libro aprenderás todos los secretos de la repostería saludable</p>\r\n\r\n<p>Por tan solo 1500 USD obtendras:</p>\r\n\r\n<ol>\r\n <li>Un libro</li>\r\n <li>Y mas nada</li>\r\n</ol>\r\n\r\n<p><strong>¡No pierdas la oportunidad!</strong></p>\r\n', 0, '2021-03-18 17:24:22', NULL, NULL, 0, 0, NULL, 0, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id_category` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category` varchar(50) NOT NULL,
  `deleted` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id_category`),
  UNIQUE KEY `category` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla `control_syslogin`
--

CREATE TABLE IF NOT EXISTS `control_syslogin` (
  `check_failed_attempts` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Indicate if the system will check the failed attempts',
  `failed_attempts_allowed` tinyint(2) UNSIGNED DEFAULT 10 COMMENT 'Define how many failed attempts are permited',
  `unblock_method` varchar(50) CHARACTER SET utf8mb4 DEFAULT NULL,
  `minutes_to_delete_failed_attempts` tinyint(4) UNSIGNED DEFAULT 60 COMMENT 'Define after how many minutes delete failed attempts',
  `check_time_after_failed_login` tinyint(1) DEFAULT 1 COMMENT 'Indicate if the system will check the time failed attempts',
  `time_after_failed_attempts` int(5) UNSIGNED DEFAULT 300 COMMENT 'Define how long must wait after the failed attempts permited',
  `action_after_failed_attempts` tinyint(3) UNSIGNED DEFAULT 1 COMMENT 'Define if after the failed attempts',
  `session_time` int(10) NOT NULL,
  `soft_deleting_activated` tinyint(1) DEFAULT 1 COMMENT 'Indicate if the soft-deleting is activated',
  PRIMARY KEY (`check_failed_attempts`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `control_syslogin`
--

INSERT INTO `control_syslogin` (`check_failed_attempts`, `failed_attempts_allowed`, `unblock_method`, `minutes_to_delete_failed_attempts`, `check_time_after_failed_login`, `time_after_failed_attempts`, `action_after_failed_attempts`, `session_time`, `soft_deleting_activated`) VALUES
(1, 2, 'time', 10, 1, 20, 1, 7200, 1);

--
-- Estructura de tabla para la tabla `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `id_event` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `article` int(10) NOT NULL,
  `action` tinyint(2) NOT NULL,
  `user` int(3) NOT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `deleted` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id_event`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id_role` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `role` varchar(50) NOT NULL,
  `deleted` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id_role`),
  UNIQUE KEY `role` (`role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla `state_articles`
--

CREATE TABLE IF NOT EXISTS `state_articles` (
  `id_state` tinyint(1) UNSIGNED NOT NULL AUTO_INCREMENT,
  `state` varchar(50) NOT NULL,
  `deleted` bit(1) DEFAULT NULL,
  PRIMARY KEY (`id_state`),
  UNIQUE KEY `state` (`state`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier of users',
  `complete_name` varchar(50) NOT NULL COMMENT 'Complete name of user',
  `username` varchar(50) NOT NULL COMMENT 'User name',
  `email` varchar(50) NOT NULL COMMENT 'E-mail of user',
  `phone` varchar(50) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0 COMMENT 'Activation account by e-mail',
  `password` varchar(100) NOT NULL COMMENT 'Password of user',
  `role` tinyint(2) UNSIGNED NOT NULL COMMENT 'Role of user',
  `registered_date` datetime DEFAULT current_timestamp() COMMENT 'Date of registration',
  `failed_attempts_made` tinyint(2) UNSIGNED DEFAULT 0 COMMENT 'Failed attempts made',
  `last_login` datetime DEFAULT NULL COMMENT 'Last logged in correctly',
  `logged_now` tinyint(1) DEFAULT NULL COMMENT 'Logged in now?',
  `last_failed_attempt` datetime DEFAULT NULL COMMENT 'Time of last failed attempt',
  `last_block` datetime DEFAULT NULL COMMENT 'Time of last blocked to calc the release',
  `keep_open_session` tinyint(1) DEFAULT 0 COMMENT 'Indication if close the session or not',
  `deleted` tinyint(1) DEFAULT 0 COMMENT 'Indication if the user was deleted',
  `deleted_at` datetime DEFAULT NULL COMMENT 'Time of delete action',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Estructura de tabla para la tabla `admin_menu`
--

CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  `item` varchar(50) NOT NULL,
  `level` tinyint(1) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `icon` varchar(50) DEFAULT NULL,
  `link` varchar(99) DEFAULT NULL,
  `parent` tinyint(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `item` (`item`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `item`, `level`, `class`, `icon`, `link`) VALUES
(1, 'Users', 1, NULL, NULL, NULL);
