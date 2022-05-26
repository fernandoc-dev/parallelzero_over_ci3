-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 30-04-2022 a las 22:22:59
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
(13, 'Admin sections', 1, 1, 'fa-solid fa-arrow-up-right-from-square', 'admin/generic_crud/read_all/admin_sections', 0);

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
-- Volcado de datos para la tabla `admin_sections`
--

INSERT INTO `admin_sections` (`id`, `section`, `activated`, `generic_activated`, `table_section`, `section_singular`, `section_plural`, `menu_open`, `menu_active`, `menu_active_2`, `dont_show`, `dependencies`, `view`, `role`, `deleted`) VALUES
(1, 'menu', 1, 1, 'admin_menu', 'admin menu', 'admin menues', 'Admin menu', 'Admin menu', 'Admin menu', NULL, NULL, 'generic', 1, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `articles`
--

CREATE TABLE `articles` (
  `id` int(6) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `author` int(3) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `category` int(3) NOT NULL,
  `subcategories` varchar(50) DEFAULT NULL,
  `tags` varchar(50) DEFAULT NULL,
  `current_state` varchar(20) NOT NULL DEFAULT 'released',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `release_at` timestamp NULL DEFAULT NULL,
  `expire_at` timestamp NULL DEFAULT NULL,
  `modified_by` tinyint(2) NOT NULL,
  `modified_at` timestamp NULL DEFAULT NULL,
  `content` mediumtext NOT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `articles`
--

INSERT INTO `articles` (`id`, `title`, `url`, `author`, `description`, `category`, `subcategories`, `tags`, `current_state`, `created_at`, `release_at`, `expire_at`, `modified_by`, `modified_at`, `content`, `deleted`) VALUES
(1, 'The title 5', 'the-url-5', 2, 'The description 5', 1, '2,3', '2,4', 'released', '2022-04-26 01:57:19', '2022-02-02 20:41:00', '2022-02-03 20:41:00', 0, '2022-02-04 20:41:00', 'Place <em>here</em> <u>the</u> <strong>content</strong> pepepepepepepepepepepepepepe', 0),
(2, 'The title 6', 'the-url-6', 1, 'The description 6', 2, '1,2', '1', 'released', '2022-04-26 01:57:22', '2022-02-03 00:30:00', '2022-02-04 00:30:00', 0, '2022-02-05 00:31:00', 'Place <em>here</em> <u>the</u> <strong>content</strong>', 0),
(3, 'The title 7', 'the-url-7', 3, 'The description 7', 2, '2,3', '2,4', 'released', '2022-04-26 01:57:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '<h1 style=\"font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; color: rgb(33, 37, 41);\">Place&nbsp;<em>here</em>&nbsp;<u>the</u>&nbsp;<span style=\"font-weight: bolder;\">content</span></h1><p><img src=\"http://localhost/mp/ci/./assets/parallel_zero/img/1645748143.JPG\" style=\"width: 600px;\"></p><p><br></p><p>Este es el cuerpo del articulo</p><p><img src=\"https://www.mediaticadigital.com.ar/files/image/24/24061/5c4907f0b1d0d.jpg\" style=\"width: 720px;\"><br></p><p><strong><br></strong></p><p><strong><font color=\"#000000\" style=\"background-color: rgb(255, 255, 0);\">Este es el final del articulo</font></strong></p><h1><strong><br></strong></h1><p><strong><br></strong></p><p><strong><br></strong>\r\n                            </p>', 0),
(4, 'Maicena de mi negra', 'todo-sobre-la-maicena', 1, 'Maicenas', 3, '2', '1', 'released', '2022-04-26 01:57:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', '<h1 style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\">La maicena</h1><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\">Se llama coloquialmente&nbsp;<b>maicena</b>&nbsp;a la harina de&nbsp;<a href=\"https://es.wikipedia.org/wiki/Almid%C3%B3n\" title=\"Almidón\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">almidón</a>&nbsp;de&nbsp;<a href=\"https://es.wikipedia.org/wiki/Zea_mays\" title=\"Zea mays\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">maíz</a>&nbsp;(en&nbsp;<a href=\"https://es.wikipedia.org/wiki/Espa%C3%B1a\" title=\"España\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">España</a>, se le llama «harina fina de maíz»). Se extrae del endospermo del grano.<sup id=\"cite_ref-1\" class=\"reference separada\" style=\"line-height: 1em; unicode-bidi: isolate; white-space: nowrap; margin-right: 0.6ch;\"><a href=\"https://es.wikipedia.org/wiki/Maicena#cite_note-1\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">1</a></sup>​</p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\">También se escribe&nbsp;<b>maizena</b>&nbsp;o&nbsp;<b>maizina</b>, que son&nbsp;<a href=\"https://es.wikipedia.org/wiki/Vulgarizaci%C3%B3n_de_marca\" title=\"Vulgarización de marca\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">marcas vulgarizadas</a>&nbsp;(es decir,&nbsp;<a href=\"https://es.wikipedia.org/wiki/Marca_(registro)\" title=\"Marca (registro)\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">marcas comerciales</a>&nbsp;que pasaron al uso común).</p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\">La maicena se utiliza para hacer pan, pastas, bizcochos, bases de pizza, etc., y como&nbsp;<a href=\"https://es.wikipedia.org/wiki/Espesante\" title=\"Espesante\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">espesante</a>&nbsp;para sopas,&nbsp;<a href=\"https://es.wikipedia.org/wiki/Chocolate_caliente\" title=\"Chocolate caliente\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">chocolate caliente</a>,&nbsp;<a href=\"https://es.wikipedia.org/wiki/Crema_pastelera\" title=\"Crema pastelera\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">crema pastelera</a>, y&nbsp;<a href=\"https://es.wikipedia.org/wiki/Helado\" title=\"Helado\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">helados</a>, entre otros. Maizena fue registrada como marca comercial en el año&nbsp;<a href=\"https://es.wikipedia.org/wiki/1856\" title=\"1856\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">1856</a>&nbsp;y adquirida por Corn Products Refining Co. en el año&nbsp;<a href=\"https://es.wikipedia.org/wiki/1900\" title=\"1900\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">1900</a>. La maicena se comercializa en todo el mundo, y se convirtió en referente de la harina de almidón de maíz.</p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\">En&nbsp;<a href=\"https://es.wikipedia.org/wiki/Argentina\" title=\"Argentina\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Argentina</a>&nbsp;se suele utilizar frecuentemente para hacer los clásicos alfajores de maizena argentinos, rellenos con dulce de leche y decorados con coco rallado.</p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\"><img src=\"http://localhost/mp/ci/./assets/parallel_zero/img/1645748627.JPG\" style=\"width: 50%;\"></p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\"><br></p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\">Se llama coloquialmente&nbsp;<b>maicena</b>&nbsp;a la harina de&nbsp;<a href=\"https://es.wikipedia.org/wiki/Almid%C3%B3n\" title=\"Almidón\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">almidón</a>&nbsp;de&nbsp;<a href=\"https://es.wikipedia.org/wiki/Zea_mays\" title=\"Zea mays\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">maíz</a>&nbsp;(en&nbsp;<a href=\"https://es.wikipedia.org/wiki/Espa%C3%B1a\" title=\"España\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">España</a>, se le llama «harina fina de maíz»). Se extrae del endospermo del grano.<sup id=\"cite_ref-1\" class=\"reference separada\" style=\"line-height: 1em; unicode-bidi: isolate; white-space: nowrap; margin-right: 0.6ch;\"><a href=\"https://es.wikipedia.org/wiki/Maicena#cite_note-1\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">1</a></sup>​</p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\">También se escribe&nbsp;<b>maizena</b>&nbsp;o&nbsp;<b>maizina</b>, que son&nbsp;<a href=\"https://es.wikipedia.org/wiki/Vulgarizaci%C3%B3n_de_marca\" title=\"Vulgarización de marca\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">marcas vulgarizadas</a>&nbsp;(es decir,&nbsp;<a href=\"https://es.wikipedia.org/wiki/Marca_(registro)\" title=\"Marca (registro)\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">marcas comerciales</a>&nbsp;que pasaron al uso común).</p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\">La maicena se utiliza para hacer pan, pastas, bizcochos, bases de pizza, etc., y como&nbsp;<a href=\"https://es.wikipedia.org/wiki/Espesante\" title=\"Espesante\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">espesante</a>&nbsp;para sopas,&nbsp;<a href=\"https://es.wikipedia.org/wiki/Chocolate_caliente\" title=\"Chocolate caliente\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">chocolate caliente</a>,&nbsp;<a href=\"https://es.wikipedia.org/wiki/Crema_pastelera\" title=\"Crema pastelera\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">crema pastelera</a>, y&nbsp;<a href=\"https://es.wikipedia.org/wiki/Helado\" title=\"Helado\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">helados</a>, entre otros. Maizena fue registrada como marca comercial en el año&nbsp;<a href=\"https://es.wikipedia.org/wiki/1856\" title=\"1856\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">1856</a>&nbsp;y adquirida por Corn Products Refining Co. en el año&nbsp;<a href=\"https://es.wikipedia.org/wiki/1900\" title=\"1900\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">1900</a>. La maicena se comercializa en todo el mundo, y se convirtió en referente de la harina de almidón de maíz.</p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\">En&nbsp;<a href=\"https://es.wikipedia.org/wiki/Argentina\" title=\"Argentina\" style=\"color: rgb(6, 69, 173); background-image: none; background-position: initial; background-size: initial; background-repeat: initial; background-attachment: initial; background-origin: initial; background-clip: initial;\">Argentina</a>&nbsp;se suele utilizar frecuentemente para hacer los clásicos alfajores de maizena argentinos, rellenos con dulce de leche y decorados con coco rallado.</p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\"><br></p><p style=\"margin: 0.5em 0px; color: rgb(32, 33, 34); font-family: sans-serif; font-size: 14px;\"><img src=\"http://localhost/mp/ci/./assets/parallel_zero/img/1645748684.JPG\" style=\"width: 991px;\"><br></p>', 0),
(40, 'The cosmos', 'the-cosmos', 0, 'The infinite cosmos', 0, '4', '4', 'released', '2022-04-26 01:57:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 'The cosmos content', 0),
(41, 'The cosmos 2', 'the-cosmos-2', 3, 'The infinite cosmos', 4, '2,3', '2,4', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00', 'The content', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `category` varchar(100) NOT NULL,
  `deleted` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `categories`
--

INSERT INTO `categories` (`id`, `category`, `deleted`) VALUES
(1, 'Computers', 0),
(2, 'Climbing high', 0),
(3, 'Cranes', 0),
(4, 'Book', 0),
(5, 'Car', 0),
(6, 'Roads', 0),
(7, 'Sports Xtreme', 0),
(8, 'Mountains high', 0),
(9, 'Skates long', 0),
(10, 'Religion', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company_data`
--

CREATE TABLE `company_data` (
  `id` tinyint(1) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `logo2` varchar(255) DEFAULT NULL,
  `deleted` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `company_data`
--

INSERT INTO `company_data` (`id`, `name`, `logo`, `logo2`, `deleted`) VALUES
(1, 'Mondo', 'LogoMondo.png', 'mondo2', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `control_syslogin`
--

CREATE TABLE `control_syslogin` (
  `check_failed_attempts` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Indicate if the system will check the failed attempts',
  `failed_attempts_allowed` tinyint(2) UNSIGNED DEFAULT 10 COMMENT 'Define how many failed attempts are permited',
  `unblock_method` varchar(50) DEFAULT NULL,
  `minutes_to_delete_failed_attempts` tinyint(4) UNSIGNED DEFAULT 60 COMMENT 'Define after how many minutes delete failed attempts',
  `check_time_after_failed_login` tinyint(1) DEFAULT 1 COMMENT 'Indicate if the system will check the time failed attempts',
  `time_after_failed_attempts` int(5) UNSIGNED DEFAULT 300 COMMENT 'Define how long must wait after the failed attempts permited',
  `action_after_failed_attempts` tinyint(3) UNSIGNED DEFAULT 1 COMMENT 'Define if after the failed attempts',
  `session_time` int(10) NOT NULL,
  `soft_deleting_activated` tinyint(1) DEFAULT 1 COMMENT 'Indicate if the soft-deleting is activated',
  `users_expiration_time` int(3) NOT NULL DEFAULT 0,
  `validity_of_recover_password_link` int(6) DEFAULT NULL COMMENT 'Minutes of validity for the recover password link',
  `sender_for_recovery_password_link` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `control_syslogin`
--

INSERT INTO `control_syslogin` (`check_failed_attempts`, `failed_attempts_allowed`, `unblock_method`, `minutes_to_delete_failed_attempts`, `check_time_after_failed_login`, `time_after_failed_attempts`, `action_after_failed_attempts`, `session_time`, `soft_deleting_activated`, `users_expiration_time`, `validity_of_recover_password_link`, `sender_for_recovery_password_link`, `deleted`) VALUES
(1, 2, 'time', 3, 1, 20, 1, 7200, 1, 30, 30, 'faby@modosaludable.com', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dependencies`
--

CREATE TABLE `dependencies` (
  `id` int(3) NOT NULL,
  `dependency` varchar(255) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `dont_show`
--

CREATE TABLE `dont_show` (
  `id` int(3) NOT NULL,
  `identifier` varchar(50) NOT NULL,
  `dont_show` varchar(999) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `dont_show`
--

INSERT INTO `dont_show` (`id`, `identifier`, `dont_show`, `deleted`) VALUES
(1, 'users-admin', 'id,password,verified,failed_attempts_made,last_failed_attempt,keep_open_session,deleted,deleted_at,last_block', 0),
(3, 'categories', 'id,deleted', 0),
(4, 'dont_show', 'id,deleted', 0),
(5, 'articles', 'id,content,deleted', 0),
(6, 'admin_menu', 'id,deleted', 0),
(7, 'icons', 'id,deleted', 0),
(8, 'admin_sections', 'id,deleted', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `icons`
--

CREATE TABLE `icons` (
  `id` int(3) NOT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `icons`
--

INSERT INTO `icons` (`id`, `icon`, `image`, `deleted`) VALUES
(1, 'fab fa-500px', NULL, 0),
(2, 'fab fa-accessible-icon', NULL, 0),
(3, 'fa-solid fa-0', '', 1),
(4, 'fa-regular fa-0', '', 1),
(5, 'fa-light fa-0', '', 1),
(6, 'fa-thin fa-0', '', 1),
(7, 'fa-duotone fa-0', '', 1),
(8, 'fa-brands fa-42-group', '', 0),
(9, 'fa-brands fa-accessible-icon', '', 1),
(10, 'fa-brands fa-accusoft', '', 0),
(11, 'fa-solid fa-address-book', '', 0),
(12, 'fa-regular fa-address-book', '', 0),
(13, 'fa-light fa-address-book', '', 1),
(14, 'fa-solid fa-address-card', '', 0),
(15, 'fa-regular fa-address-card', '', 0),
(16, 'fa-brands fa-adn', '', 0),
(17, 'fa-brands fa-adversal', '', 0),
(18, 'fa-brands fa-affiliatetheme', '', 0),
(19, 'fa-brands fa-airbnb', '', 0),
(20, 'fa-brands fa-algolia', '', 0),
(21, 'fa-solid fa-align-center', '', 0),
(22, 'fa-solid fa-align-justify', '', 0),
(23, 'fa-solid fa-align-left', '', 0),
(24, 'fa-solid fa-align-right', '', 0),
(25, 'fa-brands fa-alipay', '', 0),
(26, 'fa-brands fa-amazon', '', 0),
(27, 'fa-brands fa-amazon-pay', '', 0),
(28, 'fa-brands fa-amilia', '', 0),
(29, 'fa-solid fa-anchor', '', 0),
(30, 'fa-brands fa-android', '', 0),
(31, 'fa-brands fa-angellist', '', 0),
(32, 'fa-solid fa-angle-down', '', 0),
(33, 'fa-solid fa-angle-left', '', 0),
(34, 'fa-solid fa-angle-right', '', 0),
(35, 'fa-solid fa-angle-up', '', 0),
(36, 'fa-solid fa-angles-down', '', 0),
(37, 'fa-solid fa-angles-left', '', 0),
(38, 'fa-solid fa-angles-right', '', 0),
(39, 'fa-solid fa-angles-up', '', 0),
(40, 'fa-brands fa-angrycreative', '', 0),
(41, 'fa-brands fa-angular', '', 0),
(42, 'fa-solid fa-ankh', '', 0),
(43, 'fa-brands fa-app-store', '', 0),
(44, 'fa-brands fa-app-store-ios', '', 0),
(45, 'fa-brands fa-apper', '', 0),
(46, 'fa-brands fa-apple', '', 0),
(47, 'fa-brands fa-apple-pay', '', 0),
(48, 'fa-solid fa-apple-whole', '', 0),
(49, 'fa-solid fa-archway', '', 0),
(50, 'fa-solid fa-arrow-down', '', 0),
(51, 'fa-solid fa-arrow-down-1-9', '', 0),
(52, 'fa-solid fa-arrow-down-9-1', '', 0),
(53, 'fa-solid fa-arrow-down-a-z', '', 0),
(54, 'fa-solid fa-arrow-down-long', '', 0),
(55, 'fa-solid fa-arrow-down-short-wide', '', 0),
(56, 'fa-solid fa-arrow-down-wide-short', '', 0),
(57, 'fa-solid fa-arrow-down-z-a', '', 0),
(58, 'fa-solid fa-arrow-left', '', 0),
(59, 'fa-solid fa-arrow-left-long', '', 0),
(60, 'fa-solid fa-arrow-pointer', '', 0),
(61, 'fa-solid fa-arrow-right', '', 0),
(62, 'fa-solid fa-arrow-right-arrow-left', '', 0),
(63, 'fa-solid fa-arrow-right-from-bracket', '', 0),
(64, 'fa-solid fa-arrow-right-long', '', 0),
(65, 'fa-solid fa-arrow-right-to-bracket', '', 0),
(66, 'fa-solid fa-arrow-rotate-left', '', 0),
(67, 'fa-solid fa-arrow-rotate-right', '', 0),
(68, 'fa-solid fa-arrow-trend-down', '', 0),
(69, 'fa-solid fa-arrow-trend-up', '', 0),
(70, 'fa-solid fa-arrow-turn-down', '', 0),
(71, 'fa-solid fa-arrow-turn-up', '', 0),
(72, 'fa-solid fa-arrow-up', '', 0),
(73, 'fa-solid fa-arrow-up-1-9', '', 0),
(74, 'fa-solid fa-arrow-up-9-1', '', 0),
(75, 'fa-solid fa-arrow-up-a-z', '', 0),
(76, 'fa-solid fa-arrow-up-from-bracket', '', 0),
(77, 'fa-solid fa-arrow-up-long', '', 0),
(78, 'fa-solid fa-arrow-up-right-from-square', '', 0),
(79, 'fa-solid fa-arrow-up-short-wide', '', 0),
(80, 'fa-solid fa-arrow-up-wide-short', '', 0),
(81, 'fa-solid fa-arrow-up-z-a', '', 0),
(82, 'fa-solid fa-arrows-left-right', '', 0),
(83, 'fa-solid fa-arrows-rotate', '', 0),
(84, 'fa-solid fa-arrows-up-down', '', 0),
(85, 'fa-solid fa-arrows-up-down-left-right', '', 0),
(86, 'fa-brands fa-artstation', '', 0),
(87, 'fa-solid fa-asterisk', '', 0),
(88, 'fa-regular fa-asterisk', '', 0),
(89, 'fa-light fa-asterisk', '', 0),
(90, 'fa-brands fa-asymmetrik', '', 0),
(91, 'fa-solid fa-at', '', 0),
(92, 'fa-regular fa-at', '', 0),
(93, 'fa-light fa-at', '', 0),
(94, 'fa-brands fa-atlassian', '', 0),
(95, 'fa-solid fa-atom', '', 0),
(96, 'fa-brands fa-audible', '', 0),
(97, 'fa-solid fa-audio-description', '', 0),
(98, 'fa-solid fa-austral-sign', '', 0),
(99, 'fa-brands fa-autoprefixer', '', 0),
(100, 'fa-brands fa-avianex', '', 0),
(101, 'fa-brands fa-aviato', '', 0),
(102, 'fa-solid fa-award', '', 0),
(103, 'fa-brands fa-aws', '', 0),
(104, 'fa-solid fa-b', '', 0),
(105, 'fa-solid fa-baby', '', 0),
(106, 'fa-solid fa-baby-carriage', '', 0),
(107, 'fa-solid fa-backward', '', 0),
(108, 'fa-solid fa-backward-fast', '', 0),
(109, 'fa-solid fa-backward-step', '', 0),
(110, 'fa-solid fa-bacon', '', 0),
(111, 'fa-solid fa-bacteria', '', 0),
(112, 'fa-solid fa-bacterium', '', 0),
(113, 'fa-solid fa-bag-shopping', '', 0),
(114, 'fa-solid fa-bahai', '', 0),
(115, 'fa-solid fa-baht-sign', '', 0),
(116, 'fa-solid fa-ban', '', 0),
(117, 'fa-solid fa-ban-smoking', '', 0),
(118, 'fa-solid fa-bandage', '', 0),
(119, 'fa-brands fa-bandcamp', '', 0),
(120, 'fa-solid fa-barcode', '', 0),
(121, 'fa-solid fa-bars', '', 0),
(122, 'fa-solid fa-bars-progress', '', 0),
(123, 'fa-solid fa-bars-staggered', '', 0),
(124, 'fa-solid fa-baseball', '', 0),
(125, 'fa-solid fa-baseball-bat-ball', '', 0),
(126, 'fa-solid fa-basket-shopping', '', 0),
(127, 'fa-solid fa-basketball', '', 0),
(128, 'fa-solid fa-bath', '', 0),
(129, 'fa-solid fa-battery-empty', '', 0),
(130, 'fa-solid fa-battery-full', '', 0),
(131, 'fa-solid fa-battery-half', '', 0),
(132, 'fa-solid fa-battery-quarter', '', 0),
(133, 'fa-solid fa-battery-three-quarters', '', 0),
(134, 'fa-brands fa-battle-net', '', 0),
(135, 'fa-solid fa-bed', '', 0),
(136, 'fa-solid fa-bed-pulse', '', 0),
(137, 'fa-solid fa-beer-mug-empty', '', 0),
(138, 'fa-brands fa-behance', '', 0),
(139, 'fa-solid fa-bell', '', 0),
(140, 'fa-regular fa-bell', '', 0),
(141, 'fa-solid fa-bell-concierge', '', 0),
(142, 'fa-solid fa-bell-slash', '', 0),
(143, 'fa-regular fa-bell-slash', '', 0),
(144, 'fa-solid fa-bezier-curve', '', 0),
(145, 'fa-solid fa-bicycle', '', 0),
(146, 'fa-brands fa-bilibili', '', 0),
(147, 'fa-brands fa-bimobject', '', 0),
(148, 'fa-solid fa-binoculars', '', 0),
(149, 'fa-solid fa-biohazard', '', 0),
(150, 'fa-brands fa-bitbucket', '', 0),
(151, 'fa-brands fa-bitcoin', '', 0),
(152, 'fa-solid fa-bitcoin-sign', '', 0),
(153, 'fa-brands fa-bity', '', 0),
(154, 'fa-brands fa-black-tie', '', 0),
(155, 'fa-brands fa-blackberry', '', 0),
(156, 'fa-solid fa-blender', '', 0),
(157, 'fa-solid fa-blog', '', 0),
(158, 'fa-brands fa-blogger', '', 0),
(159, 'fa-brands fa-blogger-b', '', 0),
(160, 'fa-brands fa-bluetooth', '', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `roles`
--

CREATE TABLE `roles` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `role` varchar(50) NOT NULL,
  `deleted` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `roles`
--

INSERT INTO `roles` (`id`, `role`, `deleted`) VALUES
(1, 'Subscriber', NULL),
(2, 'Collaborator', NULL),
(3, 'Author', NULL),
(4, 'Editor', NULL),
(5, 'Administrator', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `subcategories`
--

CREATE TABLE `subcategories` (
  `id` tinyint(3) NOT NULL,
  `subcategory` varchar(50) CHARACTER SET utf8 NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `subcategories`
--

INSERT INTO `subcategories` (`id`, `subcategory`, `deleted`) VALUES
(1, 'monitors', 0),
(2, 'CPUs', 0),
(3, 'Power sources', 0),
(4, 'Speakers', 0),
(5, 'Hard Disk', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tags`
--

CREATE TABLE `tags` (
  `id` tinyint(3) NOT NULL,
  `tag` varchar(50) NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tags`
--

INSERT INTO `tags` (`id`, `tag`, `deleted`) VALUES
(1, 'tech', 0),
(2, 'nutrition', 0),
(3, 'computers', 0),
(4, 'news', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL COMMENT 'Identifier of users',
  `name` varchar(50) NOT NULL COMMENT 'Complete name of user',
  `username` varchar(50) NOT NULL COMMENT 'User name',
  `email` varchar(50) NOT NULL COMMENT 'E-mail of user',
  `phone` varchar(50) DEFAULT NULL,
  `birthday` date DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `verified` tinyint(1) DEFAULT 0 COMMENT 'Activation account by e-mail',
  `password` varchar(100) NOT NULL COMMENT 'Password of user',
  `role` tinyint(2) UNSIGNED NOT NULL DEFAULT 1 COMMENT 'Role of user',
  `registered_date` datetime DEFAULT current_timestamp() COMMENT 'Date of registration',
  `failed_attempts_made` tinyint(2) UNSIGNED DEFAULT 0 COMMENT 'Failed attempts made',
  `last_login` datetime DEFAULT NULL COMMENT 'Last logged in correctly',
  `logged_now` tinyint(1) DEFAULT NULL COMMENT 'Logged in now?',
  `last_failed_attempt` datetime DEFAULT NULL COMMENT 'Time of last failed attempt',
  `last_block` datetime DEFAULT NULL COMMENT 'Time of last blocked to calc the release',
  `keep_open_session` tinyint(1) DEFAULT 0 COMMENT 'Indication if close the session or not',
  `recover_password_link` varchar(255) CHARACTER SET utf8 DEFAULT NULL,
  `recover_password_link_date` datetime DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT 0 COMMENT 'Indication if the user was deleted',
  `deleted_at` datetime DEFAULT NULL COMMENT 'Time of delete action'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `phone`, `birthday`, `photo`, `verified`, `password`, `role`, `registered_date`, `failed_attempts_made`, `last_login`, `logged_now`, `last_failed_attempt`, `last_block`, `keep_open_session`, `recover_password_link`, `recover_password_link_date`, `deleted`, `deleted_at`) VALUES
(1, 'Fernando', 'fernando', 'fernando@mail.com', '0996549881', NULL, NULL, 0, '$2y$10$Sqg8aZUFnZ8CMo/cvmRwV.GAtiH6Rij8r6o5.JRoClyqjuE3ZypOy', 5, '2022-03-27 19:24:09', 0, '2022-03-27 21:08:47', NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(2, 'Andre', 'andre', 'andre@mail.com', '1231654654', NULL, NULL, 0, '$2y$10$7EvgMID4vJNdhBot/MP26eM9oJM7Lcqsr8TKjA4oAsBwimaLIkRS2', 5, '2022-03-29 08:20:38', 0, NULL, NULL, NULL, NULL, 0, NULL, NULL, 0, NULL),
(3, 'Robert', 'robert', 'robert@mail.com', '2165465', '1987-11-13', '', 0, '$2y$10$mWrMffJSS2itDQyEV/ql.eyFw5JVaxwkYfuCh3C0LF7Su30XO5VeC', 5, '2022-03-29 11:58:19', 0, '2022-04-30 14:08:30', 0, '0000-00-00 00:00:00', NULL, 0, '', '0000-00-00 00:00:00', 0, '0000-00-00 00:00:00');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `item` (`item`);

--
-- Indices de la tabla `admin_sections`
--
ALTER TABLE `admin_sections`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `section` (`section`);

--
-- Indices de la tabla `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title_article` (`title`),
  ADD UNIQUE KEY `url_article` (`url`);

--
-- Indices de la tabla `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `category` (`category`);

--
-- Indices de la tabla `company_data`
--
ALTER TABLE `company_data`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `control_syslogin`
--
ALTER TABLE `control_syslogin`
  ADD PRIMARY KEY (`check_failed_attempts`);

--
-- Indices de la tabla `dependencies`
--
ALTER TABLE `dependencies`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `dont_show`
--
ALTER TABLE `dont_show`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `identifier` (`identifier`);

--
-- Indices de la tabla `icons`
--
ALTER TABLE `icons`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `icon` (`icon`);

--
-- Indices de la tabla `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `role` (`role`) USING BTREE;

--
-- Indices de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `subcategory` (`subcategory`);

--
-- Indices de la tabla `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tag` (`tag`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` int(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `admin_sections`
--
ALTER TABLE `admin_sections`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de la tabla `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT de la tabla `company_data`
--
ALTER TABLE `company_data`
  MODIFY `id` tinyint(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `dependencies`
--
ALTER TABLE `dependencies`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `dont_show`
--
ALTER TABLE `dont_show`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `icons`
--
ALTER TABLE `icons`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=161;

--
-- AUTO_INCREMENT de la tabla `subcategories`
--
ALTER TABLE `subcategories`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tags`
--
ALTER TABLE `tags`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifier of users', AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
