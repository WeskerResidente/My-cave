-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : mer. 30 juil. 2025 à 14:51
-- Version du serveur : 9.1.0
-- Version de PHP : 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `my-cave`
--

-- --------------------------------------------------------

--
-- Structure de la table `appelation`
--

DROP TABLE IF EXISTS `appelation`;
CREATE TABLE IF NOT EXISTS `appelation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `appelation`
--

INSERT INTO `appelation` (`id`, `nom`) VALUES
(1, 'Châteauneuf-du-Pape AOC'),
(2, 'Pauillac AOC'),
(3, 'Margaux AOC'),
(4, 'Saint-Émilion AOC'),
(5, 'Pomerol AOC'),
(6, 'Sauternes AOC'),
(7, 'Pessac-Léognan AOC'),
(8, 'Graves AOC'),
(9, 'Cahors AOC'),
(10, 'Côtes du Rhône AOC'),
(11, 'Gigondas AOC'),
(12, 'Vacqueyras AOC'),
(13, 'Crozes-Hermitage AOC'),
(14, 'Hermitage AOC'),
(15, 'Alsace AOC'),
(16, 'Crémant d’Alsace AOC'),
(17, 'Chablis AOC'),
(18, 'Meursault AOC'),
(19, 'Pommard AOC'),
(20, 'Volnay AOC'),
(21, 'Pouilly-Fuissé AOC'),
(22, 'Beaujolais AOC'),
(23, 'Morgon AOC'),
(24, 'Juliénas AOC'),
(25, 'Brouilly AOC'),
(26, 'Côtes de Provence AOC'),
(27, 'Bandol AOC'),
(28, 'Vouvray AOC'),
(29, 'Chinon AOC'),
(30, 'Sancerre AOC'),
(31, 'Pouilly-Fumé AOC'),
(32, 'Muscadet Sèvre-et-Maine AOC'),
(33, 'Champagne AOC'),
(34, 'Barolo DOCG'),
(35, 'Barbaresco DOCG'),
(36, 'Chianti Classico DOCG'),
(37, 'Brunello di Montalcino DOCG'),
(38, 'Montepulciano d\'Abruzzo DOC'),
(39, 'Prosecco DOC'),
(40, 'Amarone della Valpolicella DOCG'),
(41, 'Valpolicella DOC'),
(42, 'Taurasi DOCG'),
(43, 'Franciacorta DOCG'),
(44, 'Vernaccia di San Gimignano DOCG'),
(45, 'Gavi DOCG'),
(46, 'Rioja DOCa'),
(47, 'Priorat DOCa'),
(48, 'Ribera del Duero DO'),
(49, 'Rueda DO'),
(50, 'Toro DO'),
(51, 'Albariño Rías Baixas DO'),
(52, 'Jumilla DO'),
(53, 'Navarra DO'),
(54, 'Penedès DO'),
(55, 'La Mancha DO'),
(56, 'Douro DOC'),
(57, 'Vinho Verde DOC'),
(58, 'Dão DOC'),
(59, 'Bairrada DOC'),
(60, 'Setúbal DOC'),
(61, 'Madeira DOC'),
(62, 'Porto DOC'),
(63, 'Mosel QbA'),
(64, 'Rheingau QbA'),
(65, 'Pfalz QbA'),
(66, 'Nahe QbA'),
(67, 'Franken QbA'),
(68, 'Napa Valley AVA'),
(69, 'Sonoma County AVA'),
(70, 'Willamette Valley AVA'),
(71, 'Columbia Valley AVA'),
(72, 'Paso Robles AVA'),
(73, 'Finger Lakes AVA'),
(74, 'Santa Barbara County AVA');

-- --------------------------------------------------------

--
-- Structure de la table `bouteille_cave`
--

DROP TABLE IF EXISTS `bouteille_cave`;
CREATE TABLE IF NOT EXISTS `bouteille_cave` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `bouteille_id` bigint NOT NULL,
  `cave_id` bigint NOT NULL,
  `quantite` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_AD84F5BDF1966394` (`bouteille_id`),
  KEY `IDX_AD84F5BD7F05B85` (`cave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `bouteille_de_vin`
--

DROP TABLE IF EXISTS `bouteille_de_vin`;
CREATE TABLE IF NOT EXISTS `bouteille_de_vin` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `cree_par_id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `annee` int NOT NULL,
  `prix` decimal(10,2) NOT NULL,
  `images` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_ajout` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `cave_id` bigint DEFAULT NULL,
  `cepage_id` int NOT NULL,
  `pays_id` int NOT NULL,
  `region_id` int NOT NULL,
  `appelation_id` int NOT NULL,
  `type_de_vin_id` int NOT NULL,
  `is_valide` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_E88F9E49FC29C013` (`cree_par_id`),
  KEY `IDX_E88F9E497F05B85` (`cave_id`),
  KEY `IDX_E88F9E498AC6BB8A` (`cepage_id`),
  KEY `IDX_E88F9E49A6E44244` (`pays_id`),
  KEY `IDX_E88F9E4998260155` (`region_id`),
  KEY `IDX_E88F9E49F9E65DDB` (`appelation_id`),
  KEY `IDX_E88F9E491576D565` (`type_de_vin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `bouteille_de_vin`
--

INSERT INTO `bouteille_de_vin` (`id`, `cree_par_id`, `nom`, `annee`, `prix`, `images`, `description`, `date_ajout`, `date_modification`, `cave_id`, `cepage_id`, `pays_id`, `region_id`, `appelation_id`, `type_de_vin_id`, `is_valide`) VALUES
(1, 1, 'test', 2014, 32.00, 'telecharge-6880d9bc7f75f.jpg', 'dsdsd', '2025-07-23 12:46:52', '2025-07-23 12:46:52', 25, 1, 1, 56, 1, 6, 1),
(3, 1, 'test', 2014, 32.00, 'telecharge-6880da4358ad8.jpg', 'dsdsd', '2025-07-23 12:49:07', '2025-07-23 12:49:07', NULL, 1, 1, 56, 1, 6, 0),
(4, 1, 'test', 2014, 32.00, 'telecharge-6880da8606f3f.jpg', 'dsdsd', '2025-07-23 12:50:13', '2025-07-23 12:50:13', NULL, 1, 1, 56, 1, 6, 0),
(5, 1, 'test', 2014, 32.00, 'telecharge-6880daae78a3e.jpg', 'dsdsd', '2025-07-23 12:50:54', '2025-07-23 12:50:54', NULL, 1, 1, 56, 1, 6, 1),
(6, 1, 'bé', 2014, 55.00, 'V0LOxTNsIc-6880f55b9bf8e.png', 'sddsd', '2025-07-23 14:44:43', '2025-07-23 14:44:43', 22, 1, 1, 56, 1, 3, 1),
(7, 1, 'Boubou', 2015, 133.00, 'Dogon-6883450b707f1.jpg', 'dsdsdsd', '2025-07-25 08:49:13', '2025-07-25 08:49:13', NULL, 17, 9, 138, 1, 3, 1),
(8, 1, 'CHATEAU DE SAINT COSME', 1980, 50.00, 'saint-cosme-688888cc7ecc2.jpg', 'Les arômes de fruits et d\'épices donnent un aperçu de la légèreté de ce joli vin, qui constitue un excellent complément aux plats de poisson.', '2025-07-29 08:39:40', '2025-07-29 08:39:40', 16, 4, 1, 66, 1, 1, 1),
(9, 1, 'LAN RIOJA CRIANZA', 2006, 9.80, 'lan-rioja-6888cdbbca584.jpg', 'Le regain d\'intérêt pour les vignobles de charme a ouvert la voie à cette excellente incursion sur le marché des vins de dessert. Léger et dynamique, avec une pointe de truffe noire, ce vin ne manquera pas de ravir les papilles.', '2025-07-29 13:33:47', '2025-07-29 13:33:47', 16, 23, 3, 67, 46, 10, 1),
(10, 1, 'MARGERUM SYBARITE', 2010, 15.00, 'margerum-6888cf155684c.jpg', 'Le secret d\'un bon Cabernet dans votre cave à vin peut désormais être remplacé par un vin enfantin et ludique, débordant de saveurs alléchantes de cerise noire et de réglisse. Une dégustation qui vous transportera assurément dans le passé.', '2025-07-29 13:39:32', '2025-07-29 13:39:32', 16, 12, 4, 76, 74, 2, 1),
(11, 1, 'OWEN ROE \"EX UMBRIS\"', 2009, 30.00, 'ex-umbris-6888cfdf629da.jpg', 'Un mélange de poivre noir et de jalapeño éveillera vos sens, tandis que l\'essence d\'orange vous ramènera à la réalité. Ne manquez pas cette sensation gustative primée.', '2025-07-29 13:42:54', '2025-07-29 13:42:54', 16, 3, 4, 78, 71, 1, 1),
(12, 1, 'REX HILL', 2009, 24.00, 'rex-hill-6888d17aaa140.jpg', 'Nul doute que ce vin sera servi lors des cérémonies de remise de prix à Hollywood, car il possède un pouvoir de star indéniable. Soyez les premiers à découvrir\r\nla première qui fera parler de lui demain.', '2025-07-29 13:49:46', '2025-07-29 13:49:46', NULL, 5, 4, 77, 70, 1, 1),
(13, 3, 'VITICCIO CLASSICO RISERVA', 2007, 33.00, 'viticcio-6889fd349944b.jpg', 'Bien que doux et rond en bouche, ce vin présente un corps ample et riche, ô combien séduisant. Son expression est encore plus impressionnante lorsqu\'on remarque les tanins tendres qui comblent pleinement les papilles.', '2025-07-30 11:08:36', '2025-07-30 11:08:36', NULL, 9, 2, 71, 48, 1, 1),
(14, 3, 'CHATEAU LE DOYENNE', 2005, 15.00, 'le-doyenne-6889fdebcdd29.jpg', 'Bien que dense et moelleux, ce vin ne domine pas par sa profondeur et sa structure finement équilibrées. C\'est une véritable expérience sensorielle.', '2025-07-30 11:11:39', '2025-07-30 11:11:39', NULL, 2, 1, 56, 26, 1, 1),
(15, 3, 'DOMAINE DU BOUSCAT', 2009, 11.60, 'bouscat-6889ff30602b6.jpg', 'La robe légèrement dorée de ce vin dissimule ses arômes vifs. Véritable vin d\'été, il invite à un pique-nique dans un vignoble ensoleillé.', '2025-07-30 11:17:03', '2025-07-30 11:17:03', NULL, 2, 1, 56, 3, 1, 1),
(16, 3, 'BLOCK NINE', 2009, 21.60, 'block-nine-6889ffc9773d0.jpg', 'With hints of ginger and spice, this wine makes an excellent complement to light appetizer and dessert fare for a holiday gathering.', '2025-07-30 11:19:37', '2025-07-30 11:19:37', NULL, 5, 4, 76, 71, 1, 1),
(17, 3, 'DOMAINE SERENE', 2007, 85.00, 'domaine-serene-688a00991606d.jpg', 'Bien que subtil dans sa complexité, ce vin saura plaire à un large éventail d\'amateurs. Des notes de grenade raviront, tandis que la finale noisetée complète le tableau d\'une dégustation raffinée.', '2025-07-30 11:23:04', '2025-07-30 11:23:04', NULL, 16, 4, 77, 70, 1, 1),
(18, 3, 'BODEGA LURTON', 2011, 12.00, 'bodega-lurton-688a0151c1814.jpg', 'Des notes solides de cassis mêlées à un léger agrume font de ce vin un vin facile à boire pour des palais variés.', '2025-07-30 11:26:09', '2025-07-30 11:26:09', NULL, 16, 5, 81, 51, 2, 1),
(19, 3, 'LES MORIZOTTES', 2009, 19.00, 'morizottes-688a02093b332.jpg', 'Rompant avec les codes classiques, cette création surprendra et fera sans aucun doute parler d\'elle avec ses notes de café et de tabac en parfaite harmonie avec des notes plus traditionnelles. Elle ravira assurément les noctambules grâce à la légère poussée d\'adrénaline qu\'elle procure.', '2025-07-30 11:29:12', '2025-07-30 11:29:12', NULL, 11, 1, 57, 22, 2, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cave_avin`
--

DROP TABLE IF EXISTS `cave_avin`;
CREATE TABLE IF NOT EXISTS `cave_avin` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `utilisateur_id` int NOT NULL,
  `cree_par_id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_ajout` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `date_modification` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `region` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_privee` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3FB7323DFB88E14F` (`utilisateur_id`),
  KEY `IDX_3FB7323DFC29C013` (`cree_par_id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cave_avin`
--

INSERT INTO `cave_avin` (`id`, `utilisateur_id`, `cree_par_id`, `nom`, `date_ajout`, `date_modification`, `image`, `description`, `region`, `is_privee`) VALUES
(16, 1, 1, 'La place de poutou', '2025-07-22 09:45:32', '2025-07-23 10:05:13', 'img-687f7031cdd33.jpg', 'Le vin, fruit de la terre et du savoir-faire des hommes, révèle à chaque gorgée des arômes complexes et subtils. Issu de cépages soigneusement sélectionnés et d’un élevage maîtrisé, il exprime le caractère unique de son terroir. Chaque bouteille raconte une histoire, celle d’une passion, d’un climat, d’un millésime. La cave qui l’abrite devient alors un écrin de souvenirs et de découvertes. Déguster, c’est voyager, partager, s’émouvoir et célébrer l’instant. dsdsdsd', '', 0),
(22, 3, 3, 'la cave des fetards', '2025-07-29 12:31:54', '2025-07-29 12:32:46', 'default-cave.jpg', 'Pas de description fournie.', NULL, 0),
(24, 1, 1, 'Ma cave personnelle', '2025-07-29 13:27:41', '2025-07-29 13:27:41', 'default-cave.jpg', NULL, NULL, 1),
(25, 3, 3, 'Ma cave personnelle', '2025-07-30 09:20:27', '2025-07-30 09:20:27', 'default-cave.jpg', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Structure de la table `cepage`
--

DROP TABLE IF EXISTS `cepage`;
CREATE TABLE IF NOT EXISTS `cepage` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `cepage`
--

INSERT INTO `cepage` (`id`, `nom`) VALUES
(1, 'Cabernet Sauvignon'),
(2, 'Merlot'),
(3, 'Syrah'),
(4, 'Grenache'),
(5, 'Pinot Noir'),
(6, 'Malbec'),
(7, 'Tempranillo'),
(8, 'Zinfandel'),
(9, 'Sangiovese'),
(10, 'Nebbiolo'),
(11, 'Chardonnay'),
(12, 'Sauvignon Blanc'),
(13, 'Riesling'),
(14, 'Gewürztraminer'),
(15, 'Viognier'),
(16, 'Pinot Grigio'),
(17, 'Muscadet'),
(18, 'Mourvèdre'),
(19, 'Petit Verdot'),
(20, 'Cabernet Franc'),
(21, 'Torrontés'),
(22, 'Carmenère'),
(23, 'Trebbiano'),
(24, 'Albariño'),
(25, 'Gamay'),
(26, 'Barbera'),
(27, 'Vermentino'),
(28, 'Fiano'),
(29, 'Grüner Veltliner'),
(30, 'Semillon'),
(31, 'Chenin Blanc'),
(32, 'Tannat'),
(33, 'Lambrusco'),
(34, 'Nero d’Avola'),
(35, 'Aglianico'),
(36, 'Carignan'),
(37, 'Touriga Nacional'),
(38, 'Pinot Blanc'),
(39, 'Colombard');

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int NOT NULL AUTO_INCREMENT,
  `vin_id` bigint DEFAULT NULL,
  `user_id` int DEFAULT NULL,
  `commentaire` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `auteur` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_67F068BCA76ED395` (`user_id`),
  KEY `IDX_67F068BCBA62C651` (`vin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `vin_id`, `user_id`, `commentaire`, `created_at`, `auteur`) VALUES
(3, 8, 1, 'Cool', '2025-07-29 08:41:06', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
CREATE TABLE IF NOT EXISTS `doctrine_migration_versions` (
  `version` varchar(191) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;

--
-- Déchargement des données de la table `doctrine_migration_versions`
--

INSERT INTO `doctrine_migration_versions` (`version`, `executed_at`, `execution_time`) VALUES
('DoctrineMigrations\\Version20250724143602', '2025-07-24 14:36:11', 477),
('DoctrineMigrations\\Version20250724152113', '2025-07-24 15:21:19', 113),
('DoctrineMigrations\\Version20250725104929', '2025-07-25 10:49:38', 170),
('DoctrineMigrations\\Version20250725112739', '2025-07-25 11:27:51', 26),
('DoctrineMigrations\\Version20250729070114', '2025-07-29 07:01:22', 106);

-- --------------------------------------------------------

--
-- Structure de la table `messenger_messages`
--

DROP TABLE IF EXISTS `messenger_messages`;
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `body` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `headers` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue_name` varchar(190) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `available_at` datetime NOT NULL COMMENT '(DC2Type:datetime_immutable)',
  `delivered_at` datetime DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)',
  PRIMARY KEY (`id`),
  KEY `IDX_75EA56E0FB7336F0` (`queue_name`),
  KEY `IDX_75EA56E0E3BD61CE` (`available_at`),
  KEY `IDX_75EA56E016BA31DB` (`delivered_at`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `messenger_messages`
--

INSERT INTO `messenger_messages` (`id`, `body`, `headers`, `queue_name`, `created_at`, `available_at`, `delivered_at`) VALUES
(1, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:51:\\\"Nom : d\nEmail : normanbelaid@gmail.com\n\nMessage :\ny\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:24:\\\"destinataire@example.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:3:\\\"yty\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2025-07-30 06:53:33', '2025-07-30 06:53:33', NULL),
(2, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:62:\\\"Nom : dsdsds\nEmail : normanbelaid@gmail.com\n\nMessage :\ndsdsdsd\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:24:\\\"destinataire@example.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:7:\\\"dsdsdsd\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2025-07-30 06:56:52', '2025-07-30 06:56:52', NULL),
(3, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:60:\\\"Nom : dsdsds\nEmail : normanbelaid@gmail.com\n\nMessage :\nsdsds\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:3:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:24:\\\"destinataire@example.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:4:\\\"dsds\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2025-07-30 07:01:23', '2025-07-30 07:01:23', NULL),
(4, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:60:\\\"Nom    : dsd\nEmail  : normanbelaid@gmail.com\nMessage:\nsdsdsd\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:4:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:26:\\\"no-reply@votre-domaine.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:8:\\\"Site Web\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:8:\\\"reply-to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:8:\\\"Reply-To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:15:\\\"[Contact] dsdsd\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2025-07-30 07:11:29', '2025-07-30 07:11:29', NULL),
(5, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:54:\\\"Nom    : dsdsds\nEmail  : toto@toto.com\nMessage:\nsdsdsd\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:4:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:26:\\\"no-reply@votre-domaine.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:8:\\\"Site Web\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:8:\\\"reply-to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:8:\\\"Reply-To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:13:\\\"toto@toto.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:15:\\\"[Contact] dsdsd\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2025-07-30 07:13:00', '2025-07-30 07:13:00', NULL),
(6, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:57:\\\"Nom    : dsd\nEmail  : normanbelaid@gmail.com\nMessage:\ndsd\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:4:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:26:\\\"no-reply@votre-domaine.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:8:\\\"Site Web\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:8:\\\"reply-to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:8:\\\"Reply-To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:14:\\\"[Contact] dsds\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2025-07-30 07:17:10', '2025-07-30 07:17:10', NULL),
(7, 'O:36:\\\"Symfony\\\\Component\\\\Messenger\\\\Envelope\\\":2:{s:44:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0stamps\\\";a:1:{s:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\";a:1:{i:0;O:46:\\\"Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\\":1:{s:55:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Stamp\\\\BusNameStamp\\0busName\\\";s:21:\\\"messenger.bus.default\\\";}}}s:45:\\\"\\0Symfony\\\\Component\\\\Messenger\\\\Envelope\\0message\\\";O:51:\\\"Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\\":2:{s:60:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0message\\\";O:28:\\\"Symfony\\\\Component\\\\Mime\\\\Email\\\":6:{i:0;s:62:\\\"Nom    : dsdsds\nEmail  : normanbelaid@gmail.com\nMessage:\nrtrtr\\\";i:1;s:5:\\\"utf-8\\\";i:2;N;i:3;N;i:4;a:0:{}i:5;a:2:{i:0;O:37:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\\":2:{s:46:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0headers\\\";a:4:{s:4:\\\"from\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:4:\\\"From\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:26:\\\"no-reply@votre-domaine.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:8:\\\"Site Web\\\";}}}}s:2:\\\"to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:2:\\\"To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:8:\\\"reply-to\\\";a:1:{i:0;O:47:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:8:\\\"Reply-To\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:58:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\MailboxListHeader\\0addresses\\\";a:1:{i:0;O:30:\\\"Symfony\\\\Component\\\\Mime\\\\Address\\\":2:{s:39:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0address\\\";s:22:\\\"normanbelaid@gmail.com\\\";s:36:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Address\\0name\\\";s:0:\\\"\\\";}}}}s:7:\\\"subject\\\";a:1:{i:0;O:48:\\\"Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\\":5:{s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0name\\\";s:7:\\\"Subject\\\";s:56:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lineLength\\\";i:76;s:50:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0lang\\\";N;s:53:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\AbstractHeader\\0charset\\\";s:5:\\\"utf-8\\\";s:55:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\UnstructuredHeader\\0value\\\";s:16:\\\"[Contact] trtrtr\\\";}}}s:49:\\\"\\0Symfony\\\\Component\\\\Mime\\\\Header\\\\Headers\\0lineLength\\\";i:76;}i:1;N;}}s:61:\\\"\\0Symfony\\\\Component\\\\Mailer\\\\Messenger\\\\SendEmailMessage\\0envelope\\\";N;}}', '[]', 'default', '2025-07-30 07:44:19', '2025-07-30 07:44:19', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `notation`
--

DROP TABLE IF EXISTS `notation`;
CREATE TABLE IF NOT EXISTS `notation` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `vin_id` bigint NOT NULL,
  `note` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_268BC95A76ED395` (`user_id`),
  KEY `IDX_268BC95BA62C651` (`vin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `notation`
--

INSERT INTO `notation` (`id`, `user_id`, `vin_id`, `note`) VALUES
(1, 1, 3, 5),
(2, 1, 3, 4),
(3, 1, 3, 5),
(4, 1, 7, 3),
(5, 4, 1, 5),
(6, 1, 8, 4);

-- --------------------------------------------------------

--
-- Structure de la table `note_de_vin`
--

DROP TABLE IF EXISTS `note_de_vin`;
CREATE TABLE IF NOT EXISTS `note_de_vin` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `vin_id` bigint NOT NULL,
  `utilisateur_id` int NOT NULL,
  `note` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_B680D4A1BA62C651` (`vin_id`),
  KEY `IDX_B680D4A1FB88E14F` (`utilisateur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `pays`
--

DROP TABLE IF EXISTS `pays`;
CREATE TABLE IF NOT EXISTS `pays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `pays`
--

INSERT INTO `pays` (`id`, `nom`) VALUES
(1, 'France'),
(2, 'Italy'),
(3, 'Spain'),
(4, 'United States'),
(5, 'Argentina'),
(6, 'Australia'),
(7, 'Germany'),
(8, 'South Africa'),
(9, 'Chile'),
(10, 'Portugal'),
(11, 'New Zealand'),
(12, 'Greece'),
(13, 'Hungary'),
(14, 'Austria'),
(15, 'Switzerland'),
(16, 'Canada'),
(17, 'Brazil'),
(18, 'China'),
(19, 'Romania'),
(20, 'Bulgaria'),
(21, 'Georgia'),
(22, 'Uruguay'),
(23, 'Israel'),
(24, 'Lebanon'),
(25, 'Turkey'),
(26, 'Slovenia'),
(27, 'Croatia'),
(28, 'Moldova'),
(29, 'Czech Republic'),
(30, 'Slovakia'),
(31, 'Mexico'),
(32, 'Morocco'),
(33, 'Algeria'),
(34, 'Peru'),
(35, 'India'),
(36, 'Thailand'),
(37, 'Japan'),
(38, 'Ukraine'),
(39, 'Russia');

-- --------------------------------------------------------

--
-- Structure de la table `region`
--

DROP TABLE IF EXISTS `region`;
CREATE TABLE IF NOT EXISTS `region` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pays_id` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_F62F176A6E44244` (`pays_id`)
) ENGINE=InnoDB AUTO_INCREMENT=147 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `region`
--

INSERT INTO `region` (`id`, `nom`, `pays_id`) VALUES
(56, 'Bordeaux', 1),
(57, 'Bourgogne', 1),
(58, 'Champagne', 1),
(59, 'Alsace', 1),
(60, 'Vallée de la Loire', 1),
(61, 'Vallée du Rhône', 1),
(62, 'Provence', 1),
(63, 'Languedoc-Roussillon', 1),
(64, 'Corse', 1),
(65, 'Sud-Ouest', 1),
(66, 'Gigondas', 1),
(67, 'Rioja', 2),
(68, 'Ribera del Duero', 2),
(69, 'Navarre', 2),
(70, 'Priorat', 2),
(71, 'Toscane', 3),
(72, 'Piémont', 3),
(73, 'Vénétie', 3),
(74, 'Pouilles', 3),
(75, 'Sicile', 3),
(76, 'Californie', 4),
(77, 'Oregon', 4),
(78, 'Washington', 4),
(79, 'New York', 4),
(80, 'Texas', 4),
(81, 'Mendoza', 5),
(82, 'Salta', 5),
(83, 'Patagonie', 5),
(84, 'San Juan', 5),
(85, 'Barossa Valley', 6),
(86, 'Hunter Valley', 6),
(87, 'Yarra Valley', 6),
(88, 'McLaren Vale', 6),
(89, 'Margaret River', 6),
(90, 'Mosel', 7),
(91, 'Rheingau', 7),
(92, 'Pfalz', 7),
(93, 'Nahe', 7),
(94, 'Franken', 7),
(95, 'Stellenbosch', 8),
(96, 'Paarl', 8),
(97, 'Constantia', 8),
(98, 'Franschhoek', 8),
(99, 'Maipo Valley', 9),
(100, 'Colchagua Valley', 9),
(101, 'Casablanca Valley', 9),
(102, 'Aconcagua Valley', 9),
(103, 'Douro', 10),
(104, 'Alentejo', 10),
(105, 'Vinho Verde', 10),
(106, 'Dão', 10),
(107, 'Marlborough', 11),
(108, 'Hawke\'s Bay', 11),
(109, 'Central Otago', 11),
(110, 'Naoussa', 12),
(111, 'Santorini', 12),
(112, 'Nemea', 12),
(113, 'Tokaj', 13),
(114, 'Eger', 13),
(115, 'Villány', 13),
(116, 'Wachau', 14),
(117, 'Burgenland', 14),
(118, 'Kamptal', 14),
(119, 'Valais', 15),
(120, 'Vaud', 15),
(121, 'Geneva', 15),
(122, 'Okanagan Valley', 16),
(123, 'Niagara Peninsula', 16),
(124, 'Prince Edward County', 16),
(125, 'Serra Gaúcha', 17),
(126, 'Campanha Gaúcha', 17),
(127, 'Ningxia', 18),
(128, 'Shandong', 18),
(129, 'Xinjiang', 18),
(130, 'Dealu Mare', 19),
(131, 'Cotnari', 19),
(132, 'Murfatlar', 19),
(133, 'Thracian Valley', 20),
(134, 'Danubian Plain', 20),
(135, 'Kakheti', 21),
(136, 'Imereti', 21),
(137, 'Kartli', 21),
(138, 'Canelones', 22),
(139, 'Maldonado', 22),
(140, 'Galilee', 23),
(141, 'Golan Heights', 23),
(142, 'Judean Hills', 23),
(143, 'Bekaa Valley', 24),
(144, 'Thrace', 25),
(145, 'Aegean', 25),
(146, 'Central Anatolia', 25);

-- --------------------------------------------------------

--
-- Structure de la table `type_de_vin`
--

DROP TABLE IF EXISTS `type_de_vin`;
CREATE TABLE IF NOT EXISTS `type_de_vin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `type_de_vin`
--

INSERT INTO `type_de_vin` (`id`, `nom`) VALUES
(1, 'Rouge'),
(2, 'Blanc'),
(3, 'Rosé'),
(4, 'Effervescent'),
(5, 'Pétillant'),
(6, 'Vin doux naturel'),
(7, 'Liquoreux'),
(8, 'Vin orange'),
(9, 'Vin muté'),
(10, 'Vin tranquille');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(180) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` json NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `prenom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pseudo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_IDENTIFIER_EMAIL` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`id`, `email`, `nom`, `roles`, `password`, `prenom`, `pseudo`) VALUES
(1, 'normanbelaid@gmail.com', 'Belaid', '[\"ROLE_ADMIN\"]', '$2y$13$XZ3eKI/lrtO.A2uO8SGZJunLUjskMpUv7N0qqwDqHLrhzr0Y98x2e', 'Norman', 'Wesker'),
(2, 'ds@d.com', 'd', '[\"ROLE_USER\"]', '$2y$13$BnCYRyw4OoxyNcBjax2RF.biN2mnqYrVV4g1Zqg13RbVKLpdcVZUa', 'd', 'test2'),
(3, 'toto@toto.com', 'toto', '[\"ROLE_USER\"]', '$2y$13$nw6ZO2PmIc3ojJX75Rp6Fur0rbcLO3dkUDtBRKiQNG.yI4qWC7tGW', 'toto', 'toto'),
(4, 'test@test.com', 'test', '[\"ROLE_USER\"]', '$2y$13$DeYhxd/ENvZbzkuUL.pgv.OPKkH3ethwxrVKecIJbWRgn11NU//oG', 'test', 'test');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `bouteille_cave`
--
ALTER TABLE `bouteille_cave`
  ADD CONSTRAINT `FK_AD84F5BD7F05B85` FOREIGN KEY (`cave_id`) REFERENCES `cave_avin` (`id`),
  ADD CONSTRAINT `FK_AD84F5BDF1966394` FOREIGN KEY (`bouteille_id`) REFERENCES `bouteille_de_vin` (`id`);

--
-- Contraintes pour la table `bouteille_de_vin`
--
ALTER TABLE `bouteille_de_vin`
  ADD CONSTRAINT `FK_E88F9E491576D565` FOREIGN KEY (`type_de_vin_id`) REFERENCES `type_de_vin` (`id`),
  ADD CONSTRAINT `FK_E88F9E497F05B85` FOREIGN KEY (`cave_id`) REFERENCES `cave_avin` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_E88F9E498AC6BB8A` FOREIGN KEY (`cepage_id`) REFERENCES `cepage` (`id`),
  ADD CONSTRAINT `FK_E88F9E4998260155` FOREIGN KEY (`region_id`) REFERENCES `region` (`id`),
  ADD CONSTRAINT `FK_E88F9E49A6E44244` FOREIGN KEY (`pays_id`) REFERENCES `pays` (`id`),
  ADD CONSTRAINT `FK_E88F9E49F9E65DDB` FOREIGN KEY (`appelation_id`) REFERENCES `appelation` (`id`),
  ADD CONSTRAINT `FK_E88F9E49FC29C013` FOREIGN KEY (`cree_par_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `cave_avin`
--
ALTER TABLE `cave_avin`
  ADD CONSTRAINT `FK_3FB7323DFB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_3FB7323DFC29C013` FOREIGN KEY (`cree_par_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `commentaire`
--
ALTER TABLE `commentaire`
  ADD CONSTRAINT `FK_67F068BCA76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `FK_67F068BCBA62C651` FOREIGN KEY (`vin_id`) REFERENCES `bouteille_de_vin` (`id`);

--
-- Contraintes pour la table `notation`
--
ALTER TABLE `notation`
  ADD CONSTRAINT `FK_268BC95A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_268BC95BA62C651` FOREIGN KEY (`vin_id`) REFERENCES `bouteille_de_vin` (`id`);

--
-- Contraintes pour la table `note_de_vin`
--
ALTER TABLE `note_de_vin`
  ADD CONSTRAINT `FK_B680D4A1BA62C651` FOREIGN KEY (`vin_id`) REFERENCES `bouteille_de_vin` (`id`),
  ADD CONSTRAINT `FK_B680D4A1FB88E14F` FOREIGN KEY (`utilisateur_id`) REFERENCES `user` (`id`);

--
-- Contraintes pour la table `region`
--
ALTER TABLE `region`
  ADD CONSTRAINT `FK_F62F176A6E44244` FOREIGN KEY (`pays_id`) REFERENCES `pays` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
