-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : lun. 20 nov. 2023 à 23:48
-- Version du serveur : 8.0.31
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `user`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `mot_de_passe` varchar(100) DEFAULT NULL,
  `code` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `admin`
--

INSERT INTO `admin` (`id`, `nom`, `prenom`, `user_id`, `email`, `mot_de_passe`, `code`) VALUES
(1, 'Nirmaladas', 'Arwin', 1, 'anirmaladas@gmail.com', 'Arwin', 6695);

-- --------------------------------------------------------

--
-- Structure de la table `enregistrements`
--

DROP TABLE IF EXISTS `enregistrements`;
CREATE TABLE IF NOT EXISTS `enregistrements` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `animal_id` int NOT NULL,
  `date_enregistrement` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `animal_id` (`animal_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `enregistrements`
--

INSERT INTO `enregistrements` (`id`, `user_id`, `animal_id`, `date_enregistrement`) VALUES
(1, 55, 237301, '2023-11-14 10:31:14'),
(2, 72, 610881, '2023-11-15 12:36:35'),
(3, 55, 240281, '2023-11-19 13:39:01');

-- --------------------------------------------------------

--
-- Structure de la table `historique_utilisateur`
--

DROP TABLE IF EXISTS `historique_utilisateur`;
CREATE TABLE IF NOT EXISTS `historique_utilisateur` (
  `id` int NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `user_id` int DEFAULT NULL,
  `date_action` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `historique_utilisateur`
--

INSERT INTO `historique_utilisateur` (`id`, `action`, `user_id`, `date_action`) VALUES
(1, 'Ajout utilisateur', 73, '2023-11-15 13:40:29'),
(2, 'Suppression utilisateur', 73, '2023-11-15 13:51:11'),
(3, 'Ajout utilisateur', 74, '2023-11-15 13:54:05'),
(4, 'Ajout utilisateur', 75, '2023-11-15 13:56:53'),
(5, 'Suppression utilisateur', 65, '2023-11-15 13:57:17'),
(6, 'Suppression utilisateur', 14, '2023-11-15 14:15:37'),
(7, 'Suppression utilisateur', 14, '2023-11-15 14:22:42'),
(8, 'Suppression utilisateur', 14, '2023-11-15 14:23:06'),
(9, 'Modification utilisateur', 72, '2023-11-15 16:25:55'),
(10, 'Modification utilisateur', 72, '2023-11-15 16:26:58'),
(11, 'Modification utilisateur', 26, '2023-11-15 16:39:17'),
(12, 'Modification utilisateur', 26, '2023-11-15 16:40:27'),
(13, 'Modification utilisateur', 27, '2023-11-15 16:40:54'),
(14, 'Modification utilisateur', 8, '2023-11-15 17:43:25'),
(15, 'Modification utilisateur', 8, '2023-11-15 17:43:48'),
(16, 'Modification utilisateur', 9, '2023-11-15 17:44:08'),
(17, 'Suppression utilisateur', 26, '2023-11-15 20:07:17'),
(18, 'Modification utilisateur', 8, '2023-11-15 20:08:30'),
(19, 'Modification utilisateur', 72, '2023-11-16 09:23:00'),
(20, 'Modification utilisateur', 72, '2023-11-16 09:23:23'),
(21, 'Suppression utilisateur', 8, '2023-11-17 08:18:22'),
(22, 'Ajout utilisateur', 76, '2023-11-17 08:19:50'),
(23, 'Suppression utilisateur', NULL, '2023-11-17 11:20:37'),
(24, 'Suppression utilisateur', NULL, '2023-11-17 11:20:55'),
(25, 'Suppression utilisateur', NULL, '2023-11-17 11:21:12'),
(26, 'Suppression utilisateur', 28, '2023-11-17 11:21:16'),
(27, 'Suppression utilisateur', 28, '2023-11-17 11:21:47'),
(28, 'Suppression utilisateur', NULL, '2023-11-17 11:21:51'),
(29, 'Suppression utilisateur', 23, '2023-11-17 11:22:01'),
(30, 'Suppression utilisateur', 23, '2023-11-17 11:23:32'),
(31, 'Suppression utilisateur', 23, '2023-11-17 11:24:09'),
(32, 'Suppression utilisateur', 23, '2023-11-17 11:24:12'),
(33, 'Suppression utilisateur', 25, '2023-11-17 11:24:19'),
(34, 'Suppression utilisateur', 25, '2023-11-17 11:24:40'),
(35, 'Suppression utilisateur', 25, '2023-11-17 11:24:49'),
(36, 'Suppression utilisateur', NULL, '2023-11-17 11:26:28'),
(37, 'Suppression utilisateur', NULL, '2023-11-17 11:28:12'),
(38, 'Suppression utilisateur', 29, '2023-11-17 11:28:20'),
(39, 'Suppression utilisateur', 27, '2023-11-17 13:07:36'),
(40, 'Suppression utilisateur', 27, '2023-11-17 13:11:37'),
(41, 'Suppression utilisateur', 27, '2023-11-17 13:12:41'),
(42, 'Suppression utilisateur', 27, '2023-11-17 13:12:54'),
(43, 'Suppression utilisateur', 27, '2023-11-17 13:13:54'),
(44, 'Suppression utilisateur', 27, '2023-11-17 13:14:12'),
(45, 'Suppression utilisateur', 27, '2023-11-17 13:14:15'),
(46, 'Suppression utilisateur', 27, '2023-11-17 13:15:00'),
(47, 'Suppression utilisateur', 27, '2023-11-17 13:15:11'),
(48, 'Suppression utilisateur', 27, '2023-11-17 13:17:23'),
(49, 'Suppression utilisateur', 3, '2023-11-17 13:17:33'),
(50, 'Suppression utilisateur', 10, '2023-11-17 13:24:19'),
(51, 'Suppression utilisateur', 10, '2023-11-17 13:34:27'),
(52, 'Suppression utilisateur', 10, '2023-11-17 13:37:47'),
(53, 'Suppression utilisateur', 10, '2023-11-17 13:38:08'),
(54, 'Suppression utilisateur', 10, '2023-11-17 13:38:56'),
(55, 'Ajout utilisateur', 77, '2023-11-17 13:50:15'),
(56, 'Ajout utilisateur', 78, '2023-11-17 13:50:31'),
(57, 'Ajout utilisateur', 79, '2023-11-17 13:50:49'),
(58, 'Ajout utilisateur', 80, '2023-11-17 13:51:05'),
(59, 'Suppression utilisateur', 30, '2023-11-17 13:58:18'),
(60, 'Ajout utilisateur', 81, '2023-11-17 13:58:48'),
(61, 'Modification utilisateur', 78, '2023-11-17 13:59:56'),
(62, 'Modification utilisateur', 77, '2023-11-17 14:01:18'),
(63, 'Ajout utilisateur', 82, '2023-11-17 14:02:27'),
(64, 'Ajout utilisateur', 83, '2023-11-17 14:03:11'),
(65, 'Ajout utilisateur', 84, '2023-11-17 14:03:16'),
(66, 'Suppression utilisateur', 78, '2023-11-17 14:07:03'),
(67, 'Ajout utilisateur', 85, '2023-11-17 14:07:20'),
(68, 'Ajout utilisateur', 86, '2023-11-17 14:10:09'),
(69, 'Ajout utilisateur', 87, '2023-11-17 14:11:59'),
(70, 'Suppression utilisateur', 81, '2023-11-19 13:41:53');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
CREATE TABLE IF NOT EXISTS `utilisateur` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `nom` text,
  `prenom` text,
  `email` text,
  `mdp` text,
  `date_enregistrement` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`user_id`, `nom`, `prenom`, `email`, `mdp`, `date_enregistrement`) VALUES
(86, 'dsmkj', 'sjfojd', 'ddf@gmail.com', 'osdfjflj', '2023-11-17 14:10:09'),
(4, NULL, NULL, NULL, NULL, '2023-11-12 23:37:01'),
(5, NULL, NULL, NULL, NULL, '2023-11-12 23:37:01'),
(24, '', '', '', '', '2023-11-13 10:14:57'),
(7, NULL, NULL, NULL, NULL, '2023-11-12 23:37:01'),
(9, 'Nirmaladas', 'Arwin', 'lknld@gmail.com', 'sqdldf,', '2023-11-12 23:37:10'),
(77, 'Sheryne', 'sqj', 'kjsdfk@yahoo.com', 'djfdjsf', '2023-11-17 13:50:15'),
(11, NULL, NULL, NULL, NULL, '2023-11-12 23:44:44'),
(12, NULL, NULL, NULL, NULL, '2023-11-12 23:46:24'),
(13, '', '', '', '', '2023-11-12 23:49:39'),
(80, 'Sheryne', 'dsijf', 'sheryne@gmail.com', 'dlkjflsd', '2023-11-17 13:51:05'),
(55, 'Nirmaladas', 'Arwin', 'arwin94240@gmail.com', 'arwin', '2023-11-13 14:24:20'),
(16, '', '', '', '', '2023-11-12 23:50:47'),
(17, '', '', '', '', '2023-11-12 23:51:39'),
(19, '', '', '', '', '2023-11-12 23:52:55'),
(20, '', '', '', '', '2023-11-12 23:53:25'),
(22, '', '', '', '', '2023-11-12 23:55:46'),
(79, 'Sheryne', 'dsijf', 'sheryne@gmail.com', 'dlkjflsd', '2023-11-17 13:50:49'),
(85, 'marius', 'mabulu', 'hsdfhjd@gmail.com', 'sjfdj', '2023-11-17 14:07:20'),
(31, 'boughrara', 'youssef', 'arwin.nirmaladas@gmjgjg', 'KHD.KJF.K', '2023-11-13 13:15:48'),
(32, 'boughrara', 'youssef', 'arwin.nirmaladas@gmail.codfsfsdm', 'dùlqsdùmlsds', '2023-11-13 13:16:13'),
(33, 'boughrara', 'youssef', 'arwin.nirmaladas@gmail.codfsfsdm', 'dùlqsdùmlsds', '2023-11-13 13:22:16'),
(34, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmail.com', 'hhfjhgjgk', '2023-11-13 13:24:11'),
(35, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmail.com', 'hhfjhgjgk', '2023-11-13 13:29:56'),
(36, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmail.com', ' ;!:!:!', '2023-11-13 13:30:03'),
(56, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmasghgqdsqdlqsdil.com', 'ghgh', '2023-11-13 14:33:32'),
(57, 'JUGUGUGGUd', 'ineedmoreboulets', 'INTPstudents@gmail.comfsdfsdfdsf', 'dsfdsfd', '2023-11-14 09:50:49'),
(39, 'Nirmaladas', 'Arwin', 'arwin94240@gmail.comsqdsd', 'sqdqsdqdsqdsdqsdqdqsd', '2023-11-13 13:33:28'),
(40, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmail.com', ' ;!:!:!', '2023-11-13 13:33:35'),
(41, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmail.com', ' ;!:!:!', '2023-11-13 13:33:38'),
(42, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmail.com', ' ;!:!:!', '2023-11-13 13:33:57'),
(43, 'boughrara', 'youssef', 'youssef@fmail.com', 'dqsdsùqdùsqd', '2023-11-13 13:34:08'),
(44, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmasqdsqdlqsdil.com', 'sdsqdsqdqss', '2023-11-13 13:35:56'),
(45, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmasqdsqdlqsdil.com', 'sdsqdsqdqss', '2023-11-13 13:44:22'),
(46, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmasqdsqdlqsdil.com', 'sdsqdsqdqss', '2023-11-13 13:45:11'),
(47, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmasqdsqdlqsdil.com', 'sdsqdsqdqss', '2023-11-13 13:47:10'),
(48, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmasqdsqdlqsdil.com', 'sdsqdsqdqss', '2023-11-13 13:47:46'),
(49, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmasqdsqdlqsdil.com', 'sdsqdsqdqss', '2023-11-13 13:54:22'),
(50, 'JUGUGUGGU', 'ineedmoreboulets', 'INTPstudents@gmail.comdsdsd', 'jdnfl!kdsf', '2023-11-13 14:04:54'),
(51, 'JUGUGUGGU', 'ineedmoreboulets', 'INTPstudents@gmail.comdsdsd', 'jdnfl!kdsf', '2023-11-13 14:05:40'),
(52, 'JUGUGUGGU', 'ineedmoreboulets', 'INTPstudents@gmail.comdsdsd', 'jdnfl!kdsf', '2023-11-13 14:05:49'),
(53, 'JUGUGUGGU', 'ineedmoreboulets', 'INTPstudents@gmail.comdsdsd', 'jdnfl!kdsf', '2023-11-13 14:05:58'),
(54, 'JUGUGUGGU', 'ineedmoreboulets', 'INTPstudents@gmail.comdsdsd', 'jdnfl!kdsf', '2023-11-13 14:06:13'),
(58, 'boughrara', 'youssef', 'youssef@fmail.comsqdsd', 'sdsdsdd', '2023-11-14 09:56:07'),
(60, 'Nirmaladas', 'Arwin', 'arwin94240@gmail.comdsfdfdf', 'dfsfdfdsf', '2023-11-14 23:26:37'),
(61, 'Nirmaladas', 'Arwin', 'arwin94240@gmail.comdsfdfdf', 'dfsfdfdsf', '2023-11-14 23:26:37'),
(62, 'Nirmaladas', 'Arwin', 'arwin94240@gmail.comdsfdfdf', 'dfsfdfdsf', '2023-11-14 23:27:52'),
(63, 'Nirmaladas', 'Arwin', 'arwin94240@gmail.comdsfdfdf', 'dfsfdfdsf', '2023-11-14 23:27:52'),
(64, 'Nirmaladas', 'Arwin', 'arwin94240@gmail.comdsfdfdf', 'dfsfdfdsf', '2023-11-14 23:28:41'),
(66, 'Youtu', 'fdidj', 'emildha.nirmaladas@gmail.commm', 'Laboss', '2023-11-14 23:31:02'),
(67, 'Nirmaladas', 'Arwin', 'arwin94240@gmail.comdsfdf', 'dfdsfdfdf;d', '2023-11-14 23:31:18'),
(68, 'JUGUGUGGUdxc', 'ineedmoreboulets', 'INTPstudents@gmail.covcxvmfsdfsdfdsf', 'cvcvcvcv', '2023-11-14 23:32:57'),
(69, 'Nirmaladas', 'Arwin', 'arwin94240@gmail.comsdfdffdsfdfdf', 'dsfdfdf', '2023-11-14 23:34:59'),
(70, 'wowo', 'Abdelrahman', 'abdelrhamant@gmail.com', 'ejfejfdd', '2023-11-15 07:48:36'),
(72, 'MAMA', 'mams', 'mamsams@gmail.com', 'mams', '2023-11-15 12:35:33'),
(74, 'Arwin', 'Nirmaladas', 'jsdhfmdjshf@gmail.com', 'slfndlf', '2023-11-15 13:54:05'),
(75, 'jshdlshjd', 'qsdqsdsqd', 'dfqhfoi@gmail.com', 'lsqhjflùdsqj', '2023-11-15 13:56:53'),
(76, 'Axel ', 'dhdh', 'jdksdf@dkhf.com', 'salutr', '2023-11-17 08:19:50'),
(82, 'delechelle', 'del', 'dkjf@edl.com', 'dkfjdsjf', '2023-11-17 14:02:27'),
(83, 'delechelle', 'del', 'dkjf@edl.com', 'dkfjdsjf', '2023-11-17 14:03:11'),
(84, 'delechelle', 'del', 'dkjf@edl.com', 'dkfjdsjf', '2023-11-17 14:03:16'),
(87, 'dsmkj', 'sjfojd', 'ddf@gmail.com', 'osdfjflj', '2023-11-17 14:11:59');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
