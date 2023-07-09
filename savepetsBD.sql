-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 28-11-2022 a las 19:47:58
-- Versión del servidor: 8.0.31-0ubuntu0.20.04.1
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `savepetsBD`
--

DROP DATABASE IF EXISTS `savepetsBD`;
CREATE DATABASE IF NOT EXISTS `savepetsBD` DEFAULT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci;
USE `savepetsBD`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `address`
--

DROP TABLE IF EXISTS `address`;
CREATE TABLE IF NOT EXISTS `address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `province` varchar(30) NOT NULL,
  `postal_code` int NOT NULL,
  `city` varchar(100) NOT NULL,
  `street` varchar(100) NOT NULL,
  `country` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (1, 'Desconocida', '32004', 'Desconocida', 'Desconocida', 'Desconocida');

--  Direcciones usuarios
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (2, 'Pontevedra', '32004', 'Vigo', 'Rosalia de Castro', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (3, 'Lugo', '27001', 'Lugo', 'Real', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (4, 'Pontevedra', '36004', 'Pontevedra', 'Redondela', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (5, 'Pontevedra', '36001', 'Tui', 'Real', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (6, 'Ourense', '32005', 'Ourense', 'Habana', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (7, 'Ourense', '32006', 'Ourense', 'Habana', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (8, 'Lugo', '27002', 'Lugo', 'Buenos Aires', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (9, 'Madrid', '28001', 'Madrid', 'Real', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (10, 'Ourense', '32004', 'Ourense', 'Buenos Aires', 'España'); 

--  Direcciones eventos
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (11, 'Pontevedra', '32004', 'Vigo', 'Rosalia de Castro', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (12, 'Lugo', '27001', 'Lugo', 'Real', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (13, 'Ourense', '32005', 'Ourense', 'Habana', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (14, 'Pontevedra', '36004', 'Pontevedra', 'Redondela', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (15, 'Madrid', '28001', 'Madrid', 'Real', 'España'); 

-- Direcciones animal publicacion perdidos
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (16, 'Pontevedra', '32004', 'Vigo', 'Rosalia de Castro', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (17, 'Lugo', '27001', 'Lugo', 'Real', 'España'); 
INSERT INTO `address` (`id`, `province`, `postal_code`, `city`, `street`, `country`) VALUES (18, 'Ourense', '32005', 'Ourense', 'Habana', 'España'); 

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `animal`
--

DROP TABLE IF EXISTS `animal`;
CREATE TABLE IF NOT EXISTS `animal` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `image` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `specie` enum('cat','dog','bunny','hamster','snake','turtles','other') NOT NULL,
  `chip` enum('','yes','no','unknown') DEFAULT NULL,
  `sex` enum('intact_female','intact_male','neutered_female','castrated_male','unknow') NOT NULL,
  `race` varchar(100) DEFAULT NULL,
  `age` int DEFAULT NULL,
  `information` varchar(300) DEFAULT NULL,
  `state` enum('healthy','sick','adopted','dead','foster','vet','unknown','other') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (1, 'Cookie', NULL, 'dog', NULL, 'intact_male', NULL, NULL, NULL, 'healthy'); 
INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (2, 'Mimi', NULL, 'cat', NULL, 'neutered_female', NULL, NULL, NULL, 'healthy'); 
INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (3, 'Louis', NULL, 'snake', 'no', 'castrated_male', NULL, '1', NULL, 'foster'); 
INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (4, 'Tom', NULL, 'dog', NULL, 'castrated_male', 'Caniche', '3', 'Muy tranquilo', 'vet'); 
INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (5, 'Herry', NULL, 'cat', NULL, 'intact_male', NULL, NULL, NULL, 'healthy'); 
INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (6, 'Sugar', NULL, 'dog', NULL, 'castrated_male', NULL, '9', NULL, 'adopted'); 
INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (7, 'Lisa', NULL, 'dog', NULL, 'intact_female', NULL, '5', 'Acostumbrada a jugar con niños.', 'adopted'); 
INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (8, 'Anne', NULL, 'cat', NULL, 'intact_female', NULL, '8', NULL, 'healthy'); 
INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (9, 'Pluto', NULL, 'dog', NULL, 'intact_male', NULL, NULL, NULL, 'vet'); 
INSERT INTO `animal` (`id`, `name`, `image`, `specie`, `chip`, `sex`, `race`, `age`, `information`, `state`) VALUES (10, 'Phineas', NULL, 'dog', NULL, 'castrated_male', NULL, '7', NULL, 'healthy'); 


--
-- Estructura de tabla para la tabla `animal_adoption`
--

DROP TABLE IF EXISTS `animal_adoption`;
CREATE TABLE IF NOT EXISTS `animal_adoption` (
  `id` int NOT NULL AUTO_INCREMENT,
  `start_date` datetime NOT NULL,
  `end_date` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `animal_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `animal_id` (`animal_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------
INSERT INTO `animal_adoption` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (1, '2023-04-01 21:08:21', NULL, '5', '6'); 
INSERT INTO `animal_adoption` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (2, '2023-04-18 11:01:05', NULL, '7', '7'); 
--
-- Estructura de tabla para la tabla `animal_shelter`
--

DROP TABLE IF EXISTS `animal_shelter`;
CREATE TABLE IF NOT EXISTS `animal_shelter` (
  `id` int NOT NULL AUTO_INCREMENT,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `user_id` int NOT NULL,
  `animal_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `shelter` (`user_id`),
  KEY `animal` (`animal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------


INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (1, '2023-04-10 12:31:05', NULL, '2', '1'); 
INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (2, '2023-11-07 11:01:05', NULL, '2', '2'); 
INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (3, '2023-12-09 12:45:09', NULL, '3', '3'); 
INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (4, '2023-04-03 11:00:45', NULL, '3', '4'); 
INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (5, '2011-02-02 21:01:00', NULL, '2', '5'); 
INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (6, '2021-06-01 09:18:21', '2023-04-01 21:08:21', '2', '6'); 
INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (7, '2022-08-18 07:31:15', '2023-04-18 11:01:05', '2', '7'); 
INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (8, '2022-09-12 11:09:00', NULL, '2', '8'); 
INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (9, '2021-01-08 13:51:00', NULL, '2', '9'); 
INSERT INTO `animal_shelter` (`id`, `start_date`, `end_date`, `user_id`, `animal_id`) VALUES (10, '2020-02-19 14:21:00', NULL, '3', '10'); 

--
-- Estructura de tabla para la tabla `comment`
--

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `comment_date` datetime NOT NULL,
  `message` varchar(300) NOT NULL,
  `publication_id` int NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `publication_id` (`publication_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------
INSERT INTO `comment` (`id`, `comment_date`, `message`, `publication_id`, `user_id`) VALUES (1, '2023-04-27 18:38:45', 'Yo tengo', '1', '9'); 
INSERT INTO `comment` (`id`, `comment_date`, `message`, `publication_id`, `user_id`) VALUES (2, '2023-05-12 11:09:11', 'A mi me interesa', '1', '5'); 
INSERT INTO `comment` (`id`, `comment_date`, `message`, `publication_id`, `user_id`) VALUES (3, '2023-05-13 12:04:13', 'Yo querria adoptarlo', '6', '6'); 
INSERT INTO `comment` (`id`, `comment_date`, `message`, `publication_id`, `user_id`) VALUES (4, '2023-05-27 17:25:05', 'Tengo algunos que pueden servir', '5', '4'); 
--
-- Estructura de tabla para la tabla `event`
--

DROP TABLE IF EXISTS `event`;
CREATE TABLE IF NOT EXISTS `event` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `message` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `user_id` int NOT NULL,
  `addres_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `shelter` (`user_id`),
  KEY `address` (`addres_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

INSERT INTO `event` (`id`, `title`, `message`, `start_date`, `end_date`, `user_id`, `addres_id`) VALUES (1, 'Comida Solidaria', 'Recogida de comida para animales de la protectora ', '2023-07-18 09:00:00', '2023-07-18 21:00:00', '2', '11'); 
INSERT INTO `event` (`id`, `title`, `message`, `start_date`, `end_date`, `user_id`, `addres_id`) VALUES (2, 'Mercadillo Solidaria', 'Participación en un mercadillo, el dinero recaudado irá a los animales ', '2023-07-23 16:00:00', '2023-07-23 21:00:00', '3', '12'); 
INSERT INTO `event` (`id`, `title`, `message`, `start_date`, `end_date`, `user_id`, `addres_id`) VALUES (3, 'Desfile Perruno', 'Desfile de los perros de la protectora para llamar la atención y que los adopten', '2023-07-19 16:00:00', '2023-07-19 21:00:00', '3', '14'); 
INSERT INTO `event` (`id`, `title`, `message`, `start_date`, `end_date`, `user_id`, `addres_id`) VALUES (4, 'Recogida Solidaria', 'Recogida de comida y otros utiles para animales de la protectora ', '2023-06-01 12:00:00', '2023-06-01 21:00:00', '2', '14'); 
INSERT INTO `event` (`id`, `title`, `message`, `start_date`, `end_date`, `user_id`, `addres_id`) VALUES (5, 'Paseo Solidario', 'Paseo de perros de la protectora por la ciudad para buscarles hogar.', '2023-07-21 09:00:00', '2023-07-21 21:00:00', '3', '15'); 

--
-- Estructura de tabla para la tabla `feature`
--

DROP TABLE IF EXISTS `feature`;
CREATE TABLE IF NOT EXISTS `feature` (
  `id` int NOT NULL AUTO_INCREMENT,
  `key_feature` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `key_feature` (`key_feature`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `feature` (`id`, `key_feature`) VALUES (1, 'work'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (2, 'studies'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (3, 'marital status'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (4, 'children'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (5, 'housing type'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (6, 'other pets');
INSERT INTO `feature` (`id`, `key_feature`) VALUES (7, 'numpets'); 
INSERT INTO `feature` (`id`, `key_feature`) VALUES (8, 'gender');

--
-- Estructura de tabla para la tabla `feature_user`
--

DROP TABLE IF EXISTS `feature_user`;
CREATE TABLE IF NOT EXISTS `feature_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `feature_id` int NOT NULL,
  `value` varchar(100) NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `feature_id` (`feature_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (1, 1,1,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (2, 1,2,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (3, 1,3,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (4, 1,4,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (5, 1,5,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (6, 1,6,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (7, 1,7,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (8, 1,8,NULL); 


INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (9, 2,1, NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (10, 2,2,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (11, 2,3,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (12, 2,4,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (13, 2,5,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (14, 2,6,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (15, 2,7,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (16, 2,8,NULL); 

INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (17, 3,1, NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (18, 3,2,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (19, 3,3,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (20, 3,4,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (21, 3,5,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (22, 3,6,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (23, 3,7,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (24, 3,8,NULL); 

INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (25, 4,1,'Profesora'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (26, 4,2,'Magisterio'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (27, 4,3,'single'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (28, 4,4,0); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (29, 4,5,'flat'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (30, 4,6,'dog'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (31, 4,7,1); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (32, 4,8,'female'); 

INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (33, 5,1,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (34, 5,2,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (35, 5,3,'single'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (36, 5,4,0); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (37, 5,5,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (38, 5,6,'cat'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (39, 5,7,1); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (40, 5,8,'female'); 

INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (41, 6,1,'Mecanico'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (42, 6,2,NUll); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (43, 6,3,'single'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (44, 6,4,0); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (45, 6,5,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (46, 6,6,'dog'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (47, 6,7,2); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (48, 6,8,NULL); 

INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (49, 7,1,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (50, 7,2,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (51, 7,3,'single'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (52, 7,4,0); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (53, 7,5,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (54, 7,6,'cat'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (55, 7,7,3); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (56, 7,8,'female'); 

INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (57, 8,1,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (58, 8,2,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (59, 8,3,'single'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (60, 8,4,0); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (61, 8,5,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (62, 8,6,'cat'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (63, 8,7,1); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (64, 8,8, NULL); 

INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (65, 9,1,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (66, 9,2,NUll); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (67, 9,3,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (68, 9,4,0); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (69, 9,5,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (70, 9,6,'dog'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (71, 9,7,1); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (72, 9,8,NULL); 

INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (73, 10,1,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (74, 10,2,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (75, 10,3,'single'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (76, 10,4,0); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (77, 10,5,NULL); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (78, 10,6,'cat'); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (79, 10,7,3); 
INSERT INTO `feature_user` (`id`, `user_id`, `feature_id`, `value`) VALUES (80, 10,8,NULL); 

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `foster_list`
--

DROP TABLE IF EXISTS `foster_list`;
CREATE TABLE IF NOT EXISTS `foster_list` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------
INSERT INTO `foster_list` (`id`, `user_id`) VALUES (1, '2'); 
INSERT INTO `foster_list` (`id`, `user_id`) VALUES (2, '3'); 
--
-- Estructura de tabla para la tabla `foster_list_user`
--

DROP TABLE IF EXISTS `foster_list_user`;
CREATE TABLE IF NOT EXISTS `foster_list_user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `foster_list_id` int NOT NULL,
  `user_id` int NOT NULL,
  `specie` enum('cat','dog','bunny','hamster','snake','turtles','other','indifferent') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `foster_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `foster_list_id` (`foster_list_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------
INSERT INTO `foster_list_user` (`id`, `foster_list_id`, `user_id`, `specie`, `foster_date`) VALUES (1, '1', '7', 'dog', '2023-05-12 18:36:37'); 
INSERT INTO `foster_list_user` (`id`, `foster_list_id`, `user_id`, `specie`, `foster_date`) VALUES (2, '2', '8', 'dog', NULL); 
INSERT INTO `foster_list_user` (`id`, `foster_list_id`, `user_id`, `specie`, `foster_date`) VALUES (3, '2', '9', 'dog', NULL); 
INSERT INTO `foster_list_user` (`id`, `foster_list_id`, `user_id`, `specie`, `foster_date`) VALUES (4, '1', '8', 'cat', NULL); 


--
-- Estructura de tabla para la tabla `message`
--

DROP TABLE IF EXISTS `message`;
CREATE TABLE IF NOT EXISTS `message` (
  `id` int NOT NULL AUTO_INCREMENT,
  `message_date` datetime NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `content` varchar(700) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `transmitter_user_id` int NOT NULL,
  `receiver_user_id` int NOT NULL,
  `readed` enum('yes','no') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transmitter` (`transmitter_user_id`),
  KEY `receiver` (`receiver_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;


-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `publication`
--

DROP TABLE IF EXISTS `publication`;
CREATE TABLE IF NOT EXISTS `publication` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_date` datetime NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` varchar(700) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------
-- Ayuda
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (1, '2023-04-01 21:41:27', 'Se necesita comida', 'Necesito comida para mi perro'); 
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (2, '2023-04-01 21:41:27', 'Se necesita mantas', 'Necesito mantas para unos gatos que están sin hogar'); 
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (3, '2023-04-01 21:41:27', 'Ofrezco comida para pajaros', 'Mis pájaros se han muerto y me ha sobrado  comida, quería donarsela a alguien que la neesitase'); 
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (4, '2023-04-01 21:41:27', 'Medicamentos', 'Tengo medicamentos para las lombrices, estan en buen estado pero mi perro ya no los necesita'); 
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (5, '2023-04-01 21:41:27', 'Se necesita juguetes', 'Necesito juguetes para mi perro que puedan resistir ya que es muy bruto y los rompe'); 

-- Adopción
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (6, '2023-04-01 21:41:27', 'Adopta un gato', 'Se busca alguien que adopte un gato, la protectora no tiene un lugar adecuado.'); 
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (7, '2023-04-01 21:41:27', 'Cookie busca hogar', 'Cookie esta deseando encontrar un hogar'); 
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (8, '2023-04-01 21:41:27', 'Tom necesita alguien que lo cuida', 'Tom saldra pronto del veterinario y necesita un hogar para vivir y poder recuperarse tranquilamente'); 

-- Perdido
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (9, '2023-04-01 21:41:27', 'Se perdió serpiente', 'Perdida serpiente'); 
INSERT INTO `publication` (`id`, `publication_date`, `title`, `message`) VALUES (10, '2023-04-01 21:41:27', 'Perro desaparecido', 'Dalmata perdido'); 

--
-- Estructura de tabla para la tabla `publication_adoption`
--

DROP TABLE IF EXISTS `publication_adoption`;
CREATE TABLE IF NOT EXISTS `publication_adoption` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_id` int NOT NULL,
  `animal_id` int NOT NULL,
  `urgent` enum('yes','no') CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_id` (`publication_id`) USING BTREE,
  KEY `animal_id` (`animal_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------
INSERT INTO `publication_adoption` (`id`, `publication_id`, `animal_id`, `urgent`, `user_id`) VALUES (1, '6', '5', 'yes', '2'); 
INSERT INTO `publication_adoption` (`id`, `publication_id`, `animal_id`, `urgent`, `user_id`) VALUES (2, '7', '1', 'no', '2'); 
INSERT INTO `publication_adoption` (`id`, `publication_id`, `animal_id`, `urgent`, `user_id`) VALUES (3, '8', '4', 'yes', '3'); 
--
-- Estructura de tabla para la tabla `publication_help`
--

DROP TABLE IF EXISTS `publication_help`;
CREATE TABLE IF NOT EXISTS `publication_help` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_id` int NOT NULL,
  `categorie` enum('textile','medical devices','food','cleaning products','hygiene products','pet accessories','other') NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_id` (`publication_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

INSERT INTO `publication_help` (`id`, `publication_id`, `categorie`, `user_id`) VALUES (1, '1', 'food', '7'); 
INSERT INTO `publication_help` (`id`, `publication_id`, `categorie`, `user_id`) VALUES (2, '2', 'textile', '6'); 
INSERT INTO `publication_help` (`id`, `publication_id`, `categorie`, `user_id`) VALUES (3, '3', 'food', '5'); 
INSERT INTO `publication_help` (`id`, `publication_id`, `categorie`, `user_id`) VALUES (4, '4', 'medical devices', '4'); 
INSERT INTO `publication_help` (`id`, `publication_id`, `categorie`, `user_id`) VALUES (5, '5', 'pet accessories', '4'); 

--
-- Estructura de tabla para la tabla `publication_stray`
--

DROP TABLE IF EXISTS `publication_stray`;
CREATE TABLE IF NOT EXISTS `publication_stray` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_id` int NOT NULL,
  `image` varchar(300) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `urgent` enum('yes','no') NOT NULL,
  `user_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `publication_id` (`publication_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------
INSERT INTO `publication_stray` (`id`, `publication_id`, `image`, `urgent`, `user_id`) VALUES (1, '9', NULL, 'yes', '3'); 
INSERT INTO `publication_stray` (`id`, `publication_id`, `image`, `urgent`, `user_id`) VALUES (2, '10', NULL, 'yes', '2'); 
--
-- Estructura de tabla para la tabla `publication_stray_address`
--

DROP TABLE IF EXISTS `publication_stray_address`;
CREATE TABLE IF NOT EXISTS `publication_stray_address` (
  `id` int NOT NULL AUTO_INCREMENT,
  `publication_stray_id` int NOT NULL,
  `addres_id` int NOT NULL,
  `user_id` int NOT NULL,
  `publication_date` datetime NOT NULL,
  `image` varchar(300) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `publication_stray_id` (`publication_stray_id`),
  KEY `user_id` (`user_id`),
  KEY `addres_id` (`addres_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------
INSERT INTO `publication_stray_address` (`id`, `publication_stray_id`, `addres_id`, `user_id`, `publication_date`, `image`) VALUES (1, '1', '16', '1', '2023-05-02 12:04:10', NULL); 
INSERT INTO `publication_stray_address` (`id`, `publication_stray_id`, `addres_id`, `user_id`, `publication_date`, `image`) VALUES (2, '1', '17', '1', '2023-05-13 21:21:34', NULL); 
INSERT INTO `publication_stray_address` (`id`, `publication_stray_id`, `addres_id`, `user_id`, `publication_date`, `image`) VALUES (3, '2', '18', '1', '2023-05-12 19:32:21', NULL); 

--
-- Estructura de tabla para la tabla `alert`
--

DROP TABLE IF EXISTS `alert`;
CREATE TABLE IF NOT EXISTS `alert` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `country` varchar(100) NOT NULL,
  `province` varchar(30) DEFAULT NULL,
  `specie` enum('','cat','dog','bunny','hamster','snake','turtles','other') DEFAULT NULL,
  `race` varchar(100) DEFAULT NULL,
  `creation_date` datetime NOT NULL,
  `active` enum('yes','no') NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `DNI_CIF` varchar(9) NOT NULL,
  `name` varchar(30) NOT NULL,
  `lastname` varchar(100) DEFAULT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `birth_date` date NOT NULL,
  `role` enum('standar','admin','shelter') NOT NULL,
  `addres_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `DNI_CIF` (`DNI_CIF`),
  UNIQUE KEY `email` (`email`),
  UNIQUE KEY `phone` (`phone`),
  UNIQUE KEY `username` (`username`),
  KEY `addres_id` (`addres_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (1, '12345678A', 'admin', 'admin', 'admin', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'imalvarez17@esei.uvigo.es', '123456789', 'admin', '1', '1999-07-19'); 
INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (2, 'A67397497', 'AnimalHelp', NULL , 'AnimalHelp', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'animalhelpsavepets@egmail.com', '670093510', 'shelter', '2', '1980-08-29'); 
INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (3, 'J13024476', 'LoveAnimal', NULL, 'LoveAnimal', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'loveanimalsavepets@gmail.com', '690193228', 'shelter', '3', '1987-02-09'); 
INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (4, '35745322X', 'Isabel', 'Martinez', 'Isamar', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'isasavepets2023@gmail.com', '654321566', 'standar', '4', '1997-03-21'); 
INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (5, 'Y9816368M', 'Macarena', 'Rodriguez', 'MacaRo', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'macasavepets2023@egmail.com', '731541779', 'standar', '5', '1968-12-14'); 
INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (6, '02855635R', 'Jose', 'Lopez', 'JoseLo', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'josesavepets2023@gmail.com', '787648458', 'standar', '6', '1999-05-17'); 
INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (7, '34230136H', 'Angeles', 'Torres', 'AngelesTo', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'angsavepets2023@gmail.com', '784196036', 'standar', '7', '1992-03-06'); 
INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (8, '45324885G', 'Pepe', 'Garcia', 'PepeGar', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'pepesavepets2023@gmail.com', '643128754', 'standar', '8', '1996-08-12'); 
INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (9, '81203445J', 'Ana', 'Perez', 'AnaPe', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'anasavepets2023@gmail.com', '769511765', 'standar', '9', '1990-02-08'); 
INSERT INTO `user` (`id`, `DNI_CIF`, `name`, `lastname`, `username`, `password`, `email`, `phone`, `role`, `addres_id`, `birth_date`) VALUES (10, '71327140T', 'Maria', 'Alvarez', 'MariaAl', '$2y$10$kdHfBy8aucllq9VjHRigWeZ1AVUSlGkz8wL5bs5GS3SY.WsUPEI0e', 'mariasavepets2023@gmail.com', '678967821', 'standar', '10', '1982-12-18'); 


--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `animal_adoption`
--
ALTER TABLE `animal_adoption`
  ADD CONSTRAINT `animal_adoption_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `animal_adoption_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `animal_shelter`
--
ALTER TABLE `animal_shelter`
  ADD CONSTRAINT `animal_shelter_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `animal_shelter_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `event`
--
ALTER TABLE `event`
  ADD CONSTRAINT `event_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `event_ibfk_2` FOREIGN KEY (`addres_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `feature_user`
--
ALTER TABLE `feature_user`
  ADD CONSTRAINT `feature_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `feature_user_ibfk_2` FOREIGN KEY (`feature_id`) REFERENCES `feature` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `foster_list`
--
ALTER TABLE `foster_list`
  ADD CONSTRAINT `foster_list_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `foster_list_user`
--
ALTER TABLE `foster_list_user`
  ADD CONSTRAINT `foster_list_user_ibfk_1` FOREIGN KEY (`foster_list_id`) REFERENCES `foster_list` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foster_list_user_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`transmitter_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `message_ibfk_2` FOREIGN KEY (`receiver_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Filtros para la tabla `publication_adoption`
--
ALTER TABLE `publication_adoption`
  ADD CONSTRAINT `publication_adoption_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_adoption_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animal` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_adoption_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publication_help`
--
ALTER TABLE `publication_help`
  ADD CONSTRAINT `publication_help_ibfk_1` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_help_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publication_stray`
--
ALTER TABLE `publication_stray`
  ADD CONSTRAINT `publication_stray_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_stray_ibfk_2` FOREIGN KEY (`publication_id`) REFERENCES `publication` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `publication_stray_address`
--
ALTER TABLE `publication_stray_address`
  ADD CONSTRAINT `publication_stray_address_ibfk_1` FOREIGN KEY (`publication_stray_id`) REFERENCES `publication_stray` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_stray_address_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `publication_stray_address_ibfk_3` FOREIGN KEY (`addres_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `alert`
  ADD CONSTRAINT `alert_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`addres_id`) REFERENCES `address` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

CREATE USER  IF NOT EXISTS 'savepetsuser'@'localhost' IDENTIFIED BY 'savepetspass';
GRANT ALL PRIVILEGES ON * . * TO 'savepetsuser'@'localhost';