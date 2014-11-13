-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Servidor: localhost
-- Tiempo de generación: 07-11-2012 a las 17:45:01
-- Versión del servidor: 5.5.9
-- Versión de PHP: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `qr_fzt`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `social_media`
--

CREATE TABLE `social_media` (
  `socialMediaId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id of social media',
  `socialMediaTokenFacebook` varchar(400) COLLATE utf8_bin NOT NULL COMMENT 'user''s token facebook',
  `socialMediaOauthTwitter` varchar(400) COLLATE utf8_bin NOT NULL COMMENT 'user''s token twitter oauth',
  `socialMediaOauthSecretTwitter` varchar(400) COLLATE utf8_bin NOT NULL COMMENT 'user''s token twitter secret',
  `socialMediaUserId` int(11) NOT NULL COMMENT 'id of user, like foreign key',
  PRIMARY KEY (`socialMediaId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='social media''s table where system save data of user for post in networks' AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `social_media`
--

INSERT INTO `social_media` VALUES(1, '1', '0', '0', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key of users',
  `userName` varchar(500) COLLATE utf8_bin NOT NULL COMMENT 'user''s first name',
  `userLastName` varchar(500) COLLATE utf8_bin NOT NULL COMMENT 'user''s last name',
  `userEmail` varchar(400) COLLATE utf8_bin NOT NULL COMMENT 'user''s email',
  `userBirthday` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'user''s birthday',
  `userGender` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'user''s gender',
  `userFacebookId` varchar(400) COLLATE utf8_bin NOT NULL COMMENT 'user''s facebook id',
  `userCreationAt` varchar(100) COLLATE utf8_bin NOT NULL COMMENT 'user''s creation at',
  PRIMARY KEY (`userId`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin COMMENT='User''s table where save all the data of the user for can use the movil app' AUTO_INCREMENT=2 ;

--
-- Volcar la base de datos para la tabla `users`
--

INSERT INTO `users` VALUES(1, '1', '1', '1', '1', '1', '1', '07-11-2012 17:28:55');
