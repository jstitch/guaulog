-- phpMyAdmin SQL Dump
-- version 3.4.3.1
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 18-07-2011 a las 16:57:55
-- Versión del servidor: 5.5.14
-- Versión de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `guaulog`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guaulog_detalle`
--

CREATE TABLE IF NOT EXISTS `guaulog_detalle` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `entrada_id` bigint(20) NOT NULL DEFAULT '0',
  `detalle` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`,`entrada_id`),
  KEY `guaulog_detalle_entrada_id_guaulog_entrada_id` (`entrada_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `guaulog_detalle`
--

INSERT INTO `guaulog_detalle` (`id`, `entrada_id`, `detalle`, `created_at`, `updated_at`) VALUES
(1, 4, 'Este es un ejemplo de un detalle... por ejemplo... ''primer cita con el pediatra, abril 7 2011''', '2011-07-07 12:00:48', '2011-07-07 12:00:48'),
(2, 4, 'Otro detalle de ejemplo... ''a los 7 dias crecio 3 cm!!''', '2011-07-07 12:01:13', '2011-07-07 12:03:31'),
(3, 3, 'Un detalle de ejemplo... ''Ya duerme corrido toda la noche! Gracias al descanso que nos permite tener :)''', '2011-07-07 12:02:56', '2011-07-07 12:02:56'),
(4, 2, 'detalle de ejemplo: ''enfermo de gripa por 2 dias''', '2011-07-07 12:04:51', '2011-07-07 12:04:51'),
(5, 2, 'detalle ejemplo: ''sonrie mucho a sus papas y abuelos''', '2011-07-07 12:05:14', '2011-07-07 12:05:14'),
(6, 2, 'detalle ejemplo: ''cambiamos talla de pañal a una mas grande''', '2011-07-07 12:06:13', '2011-07-07 12:06:13'),
(7, 1, 'detalle ejemplo: ''casi se sienta solito!''', '2011-07-07 12:06:33', '2011-07-07 12:06:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guaulog_entrada`
--

CREATE TABLE IF NOT EXISTS `guaulog_entrada` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `mes` bigint(20) NOT NULL,
  `anio` bigint(20) NOT NULL,
  `mide` decimal(18,2) NOT NULL DEFAULT '0.00',
  `pesa` decimal(18,2) NOT NULL DEFAULT '0.00',
  `pc` decimal(18,2) NOT NULL DEFAULT '0.00',
  `foto` bigint(20) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `slug` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mesanio_idx` (`mes`,`anio`),
  UNIQUE KEY `guaulog_entrada_sluggable_idx` (`slug`),
  KEY `foto_idx` (`foto`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `guaulog_entrada`
--

INSERT INTO `guaulog_entrada` (`id`, `mes`, `anio`, `mide`, `pesa`, `pc`, `foto`, `created_at`, `updated_at`, `slug`) VALUES
(1, 7, 2011, 1.00, 2.00, 3.00, 1, '2011-07-05 15:39:40', '2011-07-07 11:55:52', '7-2011'),
(2, 6, 2011, 0.90, 1.90, 2.90, 4, '2011-07-07 11:57:10', '2011-07-07 11:57:37', '6-2011'),
(3, 5, 2011, 0.80, 1.80, 2.80, 6, '2011-07-07 11:58:02', '2011-07-07 11:59:01', '5-2011'),
(4, 4, 2011, 0.70, 1.70, 2.70, 7, '2011-07-07 11:59:28', '2011-07-07 12:00:12', '4-2011');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `guaulog_foto`
--

CREATE TABLE IF NOT EXISTS `guaulog_foto` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `entrada_id` bigint(20) NOT NULL DEFAULT '0',
  `foto` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`,`entrada_id`),
  KEY `guaulog_foto_entrada_id_guaulog_entrada_id` (`entrada_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `guaulog_foto`
--

INSERT INTO `guaulog_foto` (`id`, `entrada_id`, `foto`, `created_at`, `updated_at`) VALUES
(1, 1, '915b1c56f8039247fe96b27b120ac10adb3dbfcd.jpg', '2011-07-07 11:55:46', '2011-07-07 11:55:46'),
(3, 1, 'e93f313fdd123ef560d6d646cd3602df9b5f97be.jpg', '2011-07-07 11:56:48', '2011-07-07 11:56:48'),
(4, 2, '59262387b2cea9abc6c3aa6a2d47c8b5d6f886be.jpg', '2011-07-07 11:57:31', '2011-07-07 11:57:31'),
(5, 3, '26877670ca9dcd5483d26bb4066a23ef31118480.jpg', '2011-07-07 11:58:19', '2011-07-07 11:58:19'),
(6, 3, '33458dc3c2421f53c74c543a05411b31353aeb3e.jpg', '2011-07-07 11:58:55', '2011-07-07 11:58:55'),
(7, 4, '59e43fe3194aa4bdad751fb3c86758fa0d2cee72.jpg', '2011-07-07 12:00:07', '2011-07-07 12:00:07');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_forgot_password`
--

CREATE TABLE IF NOT EXISTS `sf_guard_forgot_password` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) NOT NULL,
  `unique_key` varchar(255) DEFAULT NULL,
  `expires_at` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_group_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_group_permission` (
  `group_id` bigint(20) NOT NULL DEFAULT '0',
  `permission_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`group_id`,`permission_id`),
  KEY `sf_guard_group_permission_permission_id_sf_guard_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_permission` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` text,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `sf_guard_permission`
--

INSERT INTO `sf_guard_permission` (`id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'Administrador', '2011-07-05 15:38:13', '2011-07-05 15:38:13');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_remember_key`
--

CREATE TABLE IF NOT EXISTS `sf_guard_remember_key` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `remember_key` varchar(32) DEFAULT NULL,
  `ip_address` varchar(50) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_user`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email_address` varchar(255) NOT NULL,
  `username` varchar(128) NOT NULL,
  `algorithm` varchar(128) NOT NULL DEFAULT 'sha1',
  `salt` varchar(128) DEFAULT NULL,
  `password` varchar(128) DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `is_super_admin` tinyint(1) DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_address` (`email_address`),
  UNIQUE KEY `username` (`username`),
  KEY `is_active_idx_idx` (`is_active`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `sf_guard_user`
--

INSERT INTO `sf_guard_user` (`id`, `first_name`, `last_name`, `email_address`, `username`, `algorithm`, `salt`, `password`, `is_active`, `is_super_admin`, `last_login`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, 'jstitch@invernalia.homelinux.net', 'user', 'sha1', '946f3df32535cf310b35399375be193e', 'edc550eb98ca60e50e914a15bb199ed68fd73fcd', 1, 0, '2011-07-08 10:34:34', '2011-07-05 14:08:18', '2011-07-08 10:34:34'),
(3, NULL, NULL, 'root@invernalia.homelinux.net', 'admin', 'sha1', '7b0c0fb1d93bee186a696bdec135fca5', 'b5b218257cdc0a9dd7b64952bfe3ee0df8e82927', 1, 0, '2011-07-18 16:47:25', '2011-07-05 14:08:33', '2011-07-18 16:47:25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_user_group`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_group` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `group_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`group_id`),
  KEY `sf_guard_user_group_group_id_sf_guard_group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `sf_guard_user_permission`
--

CREATE TABLE IF NOT EXISTS `sf_guard_user_permission` (
  `user_id` bigint(20) NOT NULL DEFAULT '0',
  `permission_id` bigint(20) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`user_id`,`permission_id`),
  KEY `sf_guard_user_permission_permission_id_sf_guard_permission_id` (`permission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `sf_guard_user_permission`
--

INSERT INTO `sf_guard_user_permission` (`user_id`, `permission_id`, `created_at`, `updated_at`) VALUES
(3, 1, '2011-07-05 15:38:13', '2011-07-05 15:38:13');

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `guaulog_detalle`
--
ALTER TABLE `guaulog_detalle`
  ADD CONSTRAINT `guaulog_detalle_entrada_id_guaulog_entrada_id` FOREIGN KEY (`entrada_id`) REFERENCES `guaulog_entrada` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `guaulog_entrada`
--
ALTER TABLE `guaulog_entrada`
  ADD CONSTRAINT `guaulog_entrada_foto_guaulog_foto_id` FOREIGN KEY (`foto`) REFERENCES `guaulog_foto` (`id`) ON DELETE SET NULL;

--
-- Filtros para la tabla `guaulog_foto`
--
ALTER TABLE `guaulog_foto`
  ADD CONSTRAINT `guaulog_foto_entrada_id_guaulog_entrada_id` FOREIGN KEY (`entrada_id`) REFERENCES `guaulog_entrada` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sf_guard_forgot_password`
--
ALTER TABLE `sf_guard_forgot_password`
  ADD CONSTRAINT `sf_guard_forgot_password_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sf_guard_group_permission`
--
ALTER TABLE `sf_guard_group_permission`
  ADD CONSTRAINT `sf_guard_group_permission_group_id_sf_guard_group_id` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_group_permission_permission_id_sf_guard_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sf_guard_remember_key`
--
ALTER TABLE `sf_guard_remember_key`
  ADD CONSTRAINT `sf_guard_remember_key_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sf_guard_user_group`
--
ALTER TABLE `sf_guard_user_group`
  ADD CONSTRAINT `sf_guard_user_group_group_id_sf_guard_group_id` FOREIGN KEY (`group_id`) REFERENCES `sf_guard_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_group_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `sf_guard_user_permission`
--
ALTER TABLE `sf_guard_user_permission`
  ADD CONSTRAINT `sf_guard_user_permission_permission_id_sf_guard_permission_id` FOREIGN KEY (`permission_id`) REFERENCES `sf_guard_permission` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `sf_guard_user_permission_user_id_sf_guard_user_id` FOREIGN KEY (`user_id`) REFERENCES `sf_guard_user` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
