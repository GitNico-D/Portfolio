-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 14 oct. 2020 à 08:25
-- Version du serveur :  5.7.31
-- Version de PHP : 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `db_portfolio`
--

-- --------------------------------------------------------

--
-- Structure de la table `category`
--

DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`) VALUES
(1, 'Informatique'),
(2, 'Son'),
(3, 'Vidéo'),
(4, 'Commercial');

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20201009143448', '2020-10-09 14:37:06', 97),
('DoctrineMigrations\\Version20201009151215', '2020-10-09 15:14:58', 626);

-- --------------------------------------------------------

--
-- Structure de la table `education`
--

DROP TABLE IF EXISTS `education`;
CREATE TABLE IF NOT EXISTS `education` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `school` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `city` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `education`
--

INSERT INTO `education` (`id`, `title`, `school`, `city`, `start_date`, `end_date`) VALUES
(1, 'Baccalauréat Scientifique - Option S', 'Lycée Phillipe de Gérard', 'Avignon', '2002-05-05 08:30:00', '2005-06-30 15:28:18'),
(2, 'Diplôme Universitaire \"Conception et administration de site web\"', 'IUT Informatique', 'Montpellier', '2005-10-09 08:30:00', '2007-07-01 15:28:18');

-- --------------------------------------------------------

--
-- Structure de la table `experience`
--

DROP TABLE IF EXISTS `experience`;
CREATE TABLE IF NOT EXISTS `experience` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo_company` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `experience`
--

INSERT INTO `experience` (`id`, `name`, `description`, `company`, `logo_company`, `start_date`, `end_date`) VALUES
(1, 'Développement Personnel et Professionnel', 'Création et développement d’une Auto Entreprise dans le secteur audiovisuel.\r\nDiverses productions audiovisuelles avec des freelance et créateurs événementiels.\r\n', 'Indépendant', '', '2010-01-01 08:30:00', '2014-12-30 08:30:00'),
(2, 'Concepteur en Communication Audiovisuelle', 'Réalisations de films documentaires (Salon vin et terroir, Foire Internationale de   Toulouse, Salon de l’entreprise,…).\r\nRéalisations de trailers pour ARENA PRODUCTION.\r\nFreelance sur plusieurs projets de Post production et de Sound Design.\r\n', 'Auto Entrepreneur', '', '2014-11-15 08:30:00', '2019-01-01 08:30:00');

-- --------------------------------------------------------

--
-- Structure de la table `project`
--

DROP TABLE IF EXISTS `project`;
CREATE TABLE IF NOT EXISTS `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_static` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `img_hover` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_static` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `alt_hover` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `create_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `url`, `img_static`, `img_hover`, `alt_static`, `alt_hover`, `create_at`) VALUES
(1, 'Intégration de la maquette d\'une agence web', 'Réalisation de l\'intégration de le nouvelle maquette d\'un site d\'un agence web.\r\nTravail effectué exclusivement en HTML5 et CSS, sans utilisation de Framework telle que boostrap.', 'https://determined-johnson-613dfb.netlify.app/', '/img/project/project_1.png', '', '', '', '2019-07-15 15:00:00'),
(2, 'Site WordPress', 'Création d\'un site sous WordPress en personnalisant un thème préalablement choisit afin de convenir à la demande. Mise en place de plug-ins WordPress, dédiés aux besoins du client, adapté une cohérence graphique de l\'ensemble des pages, définir la structure de navigation, gestion d\'une accessibilité d\'utilisateurs différents au site et application des principes de SEO.', 'http://projet-ireki.devnweb.fr/', '', '', '', '', '2019-10-29 15:00:00'),
(3, 'Carte interactive de location de vélo', 'Conception d\'une application de location de vélo à l\'aide de l\'API JCDecaux. Site conçue en HTML5, CSS avec l\'appui du framework Boostrap et JavaScript avec utilisation de la librairie JQuery. Construit en Programmation Orienté Objet.', 'http://projet-velyonlib.devnweb.fr/', '', '', '', '', '2020-04-08 17:00:00'),
(4, 'Blog pour un écrivain', 'Ce site est conçu en PHP sous le modèle MVC, en programmation orienté objet. Intégralement construit from scratch sans utilisation d\'aucun Framework telle que Symfony ou Laravel, et intégration et gestion d\'une base de donnée sous MySql. Gestion du FrontEnd et du BackEnd.', 'http://projet-forteroche.devnweb.net/', '', '', '', '', '2020-09-15 14:00:00');

-- --------------------------------------------------------

--
-- Structure de la table `skill`
--

DROP TABLE IF EXISTS `skill`;
CREATE TABLE IF NOT EXISTS `skill` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `knowledge_level` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `skill`
--

INSERT INTO `skill` (`id`, `name`, `icon`, `description`, `knowledge_level`) VALUES
(1, 'HTML5', '/img/logo/logo_html.png', '', 60),
(2, 'CSS3', '/img/logo/logo_css.png', '', 60);

-- --------------------------------------------------------

--
-- Structure de la table `software`
--

DROP TABLE IF EXISTS `software`;
CREATE TABLE IF NOT EXISTS `software` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(75) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mastery_of` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
