-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 11 nov. 2020 à 08:29
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
  `created_at` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `category`
--

INSERT INTO `category` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Informatique', NULL, NULL),
(2, 'Son', NULL, NULL),
(3, 'Vidéo', NULL, NULL),
(4, 'Commercial', NULL, NULL),
(5, 'New', NULL, NULL),
(6, 'New Experience', NULL, NULL),
(7, 'New Experience', NULL, NULL),
(8, 'New category', NULL, NULL),
(9, 'New category', NULL, NULL);

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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `education`
--

INSERT INTO `education` (`id`, `title`, `school`, `city`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Baccalauréat Scientifique - Option S', 'Lycée Phillipe de Gérard', 'Avignon', '2002-05-05 08:30:00', '2005-06-30 15:28:18', NULL, NULL),
(2, 'Diplôme Universitaire \"Conception et administration de site web\"', 'IUT Informatique', 'Montpellier', '2005-10-09 08:30:00', '2007-07-01 15:28:18', NULL, NULL),
(4, 'Modificaiton New education', 'Modification New education', '212', '2020-05-05 08:30:00', '2020-06-30 15:28:18', NULL, NULL),
(5, 'New education', 'New education', 'New education', '2020-05-05 08:30:00', '2020-06-30 15:28:18', NULL, NULL);

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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `experience`
--

INSERT INTO `experience` (`id`, `name`, `description`, `company`, `logo_company`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Développement Personnel et Professionnel', 'Création et développement d’une Auto Entreprise dans le secteur audiovisuel.\r\nDiverses productions audiovisuelles avec des freelance et créateurs événementiels.\r\n', 'Indépendant', '', '2010-01-01 08:30:00', '2014-12-30 08:30:00', NULL, NULL),
(2, 'Concepteur en Communication Audiovisuelle', 'Réalisations de films documentaires (Salon vin et terroir, Foire Internationale de   Toulouse, Salon de l’entreprise,…).\r\nRéalisations de trailers pour ARENA PRODUCTION.\r\nFreelance sur plusieurs projets de Post production et de Sound Design.\r\n', 'Auto Entrepreneur', '', '2014-11-15 08:30:00', '2019-01-01 08:30:00', NULL, NULL),
(3, 'New Experience', 'ddd', 'ddd', '', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(4, 'New Experience', 'New Experience', 'New Experience', '', '2010-01-01 08:30:00', '2014-12-30 08:30:00', NULL, NULL),
(5, 'New Experience', 'New Experience', 'New Experience', '', '2010-01-01 08:30:00', '2014-12-30 08:30:00', NULL, NULL),
(6, 'N', 'New Experience', 'New Experience', '', '2010-01-01 08:30:00', '2014-12-30 08:30:00', NULL, NULL),
(7, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(8, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(9, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(10, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(11, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(12, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(13, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(14, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(15, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(16, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(17, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(18, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(19, 'New Experience', 'New Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(20, 'New paramConverter Experience', 'New paramConverter Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(21, 'New paramConverter Experience', 'New paramConverter Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(22, 'New paramConverter Experience', 'New paramConverter Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', NULL, NULL),
(23, 'New paramConverter Experience', 'New paramConverter Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', '2020-11-10 17:08:29', NULL),
(24, 'New paramConverter Experience', 'New paramConverter Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', '2020-11-10 17:29:07', NULL),
(25, 'New timeStampable Experience', 'New timeStampable Experience', 'New Experience', 'New Experience', '2020-01-01 08:30:00', '2020-12-30 08:30:00', '2020-11-10 17:29:12', NULL);

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
  `create_at` date NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `project`
--

INSERT INTO `project` (`id`, `name`, `description`, `url`, `img_static`, `img_hover`, `alt_static`, `alt_hover`, `create_at`, `updated_at`) VALUES
(1, 'Intégration de la maquette d\'une agence web', 'Réalisation de l\'intégration de le nouvelle maquette d\'un site d\'un agence web.\r\nTravail effectué exclusivement en HTML5 et CSS, sans utilisation de Framework telle que boostrap.', 'https://determined-johnson-613dfb.netlify.app/', '/img/project/project_1.png', '', '', '', '2019-07-15', NULL),
(2, 'Site WordPress', 'Création d\'un site sous WordPress en personnalisant un thème préalablement choisit afin de convenir à la demande. Mise en place de plug-ins WordPress, dédiés aux besoins du client, adapté une cohérence graphique de l\'ensemble des pages, définir la structure de navigation, gestion d\'une accessibilité d\'utilisateurs différents au site et application des principes de SEO.', 'http://projet-ireki.devnweb.fr/', '', '', '', '', '2019-10-29', NULL),
(3, 'Carte interactive de location de vélo', 'Conception d\'une application de location de vélo à l\'aide de l\'API JCDecaux. Site conçue en HTML5, CSS avec l\'appui du framework Boostrap et JavaScript avec utilisation de la librairie JQuery. Construit en Programmation Orienté Objet.', 'http://projet-velyonlib.devnweb.fr/', '', '', '', '', '2020-04-08', NULL),
(4, 'Blog pour un écrivain', 'Ce site est conçu en PHP sous le modèle MVC, en programmation orienté objet. Intégralement construit from scratch sans utilisation d\'aucun Framework telle que Symfony ou Laravel, et intégration et gestion d\'une base de donnée sous MySql. Gestion du FrontEnd et du BackEnd.', 'http://projet-forteroche.devnweb.net/', '', '', '', '', '2020-09-15', NULL),
(5, 'Portfolio en cours', 'Réalisation d\'un portfolio à l\'aide d\'une Api créé avec Symfony', 'A venir', '', '', '', '', '2019-07-16', NULL),
(6, 'fhgfhgfd du projet 6', 'hfdhd c\'est sur', 'A venir', '', '', '', '', '2019-07-16', NULL),
(7, 'test ajout ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(8, 'test ajout ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(9, 'test ajout ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(10, 'Ajout new project ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(11, 'Ajout new project ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(12, 'Ajout new project ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(13, 'Ajout new project ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(14, 'Ajout new project ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(15, 'Ajout new project ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(16, 'Ajout new project ', '', 'A venir', '', '', '', '', '2019-07-16', NULL),
(18, 'New modification  project', 'New modification project', 'New modification project', 'New modification project', '', '', '', '2019-07-15', NULL),
(19, 'New project', 'New project', 'New  project', 'New modification project', '', '', '', '2019-07-15', NULL),
(21, 'N', 'New project', 'New  project', 'New modification project', 'jj', 'jj', 'jj', '2019-07-15', NULL),
(22, 'Test Ajout', 'Test Ajout', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(24, 'N', 'N', 'url/', 'imgStatic', 'imgHover', 'altStatic', 'altHover', '2019-07-15', NULL),
(25, 'New paramConverter project', 'New paramConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(26, 'New paramConverter project', 'New paramConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(27, 'Really new paramConverter project', 'Really new paramConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(28, 'ParamConverter project', 'ParamConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(29, 'ParamConverter project', 'ParamConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(30, 'ParamConverter project', 'ParamConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(31, 'ParamConverter project', 'ParamConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(32, 'ParamConverter project', 'ParamConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(33, 'ParamConverter project', 'ParamConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(34, 'ParamConverter project', 'ParamConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(35, 'ParamConverter project', 'ParamConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL),
(36, 'ParamConverter project', 'ParamConverter project', 'New project', 'New modification project', 'Test Ajout', 'Test Ajout', 'Test Ajout', '2019-07-15', NULL);

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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `skill`
--

INSERT INTO `skill` (`id`, `name`, `icon`, `description`, `knowledge_level`, `created_at`, `updated_at`) VALUES
(1, 'HTML5', '/img/logo/logo_html.png', '', 60, NULL, NULL),
(2, 'CSS3', '/img/logo/logo_css.png', '', 60, NULL, NULL),
(3, 'New skill', '/img/logo.png', '', 20, NULL, NULL),
(4, 'New skill', '/img/logo/new_skill.png', '', 60, NULL, NULL),
(5, 'New Skill', '/img/logo/logo_html.png', 'New skill description', 60, NULL, NULL),
(6, 'New Modification Skill', '/img/logo/logo_html.png', 'New modification skill description', 60, NULL, NULL);

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
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `software`
--

INSERT INTO `software` (`id`, `name`, `icon`, `mastery_of`, `created_at`, `updated_at`, `category_id`) VALUES
(1, 'Cubase', '/img/logo/cubase.png', 70, NULL, NULL, 2),
(2, 'k', '/img/logo/cubase.png', 70, NULL, NULL, 2),
(3, 'New Software', '/img/logo/cubase.png', 70, NULL, NULL, 2),
(4, 'New modification software', '/img/logo/cubase.png', 70, NULL, NULL, 2),
(5, 'New modification software', '/img/logo/cubase.png', 70, NULL, NULL, 2),
(6, 'Sotware', 'Sotware', 70, '2020-11-10 18:03:26', NULL, 2),
(7, 'New modif Sotware', 'New modif Sotware', 70, '2020-11-10 18:08:27', '2020-11-10 18:09:53', 2),
(8, 'New modif Sotware', 'New modif Sotware', 70, '2020-11-10 18:08:35', '2020-11-10 18:09:26', 2);

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
