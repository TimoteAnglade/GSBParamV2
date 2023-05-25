-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3307
-- Généré le : jeu. 25 mai 2023 à 20:09
-- Version du serveur : 10.6.11-MariaDB
-- Version de PHP : 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tim_paramv2`
--

-- --------------------------------------------------------

--
-- Structure de la table `archivagecommande`
--

DROP TABLE IF EXISTS `archivagecommande`;
CREATE TABLE IF NOT EXISTS `archivagecommande` (
  `id` char(32) NOT NULL,
  `dateCommande` date DEFAULT NULL,
  `nomPrenomClient` char(32) DEFAULT NULL,
  `adresseRueClient` char(32) DEFAULT NULL,
  `cpClient` char(5) DEFAULT NULL,
  `villeClient` char(32) DEFAULT NULL,
  `mailClient` char(50) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `archivecontenir`
--

DROP TABLE IF EXISTS `archivecontenir`;
CREATE TABLE IF NOT EXISTS `archivecontenir` (
  `id` char(32) NOT NULL,
  `id_archivagecommande` char(32) NOT NULL,
  PRIMARY KEY (`id`,`id_archivagecommande`),
  KEY `archivecontenir_archivagecommande0_FK` (`id_archivagecommande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `avis`
--

DROP TABLE IF EXISTS `avis`;
CREATE TABLE IF NOT EXISTS `avis` (
  `mail` varchar(50) NOT NULL,
  `id` varchar(32) NOT NULL,
  `note` int(1) NOT NULL,
  `contenu_avis` text NOT NULL,
  PRIMARY KEY (`mail`,`id`),
  KEY `avis_produit_fk` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `avis`
--

INSERT INTO `avis` (`mail`, `id`, `note`, `contenu_avis`) VALUES
('a.fougerard@gmail.fr', 'c01', 3, 'fgsdfg'),
('timote.anglade.45@gmail.com', 'c01', 2, 'Très mauvais rapport qualité/prix.'),
('timote.anglade.45@gmail.com', 'c02', 5, 'C\'est vraiment super cool');

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

DROP TABLE IF EXISTS `categorie`;
CREATE TABLE IF NOT EXISTS `categorie` (
  `id` char(32) NOT NULL,
  `libelle` char(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `categorie`
--

INSERT INTO `categorie` (`id`, `libelle`) VALUES
('CH', 'Cheveux'),
('FO', 'Forme'),
('PS', 'Protection Solaire');

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

DROP TABLE IF EXISTS `commande`;
CREATE TABLE IF NOT EXISTS `commande` (
  `mail` varchar(50) NOT NULL,
  `id` char(32) NOT NULL,
  `dateCommande` date DEFAULT NULL,
  `etatCde` char(1) NOT NULL DEFAULT 'P' COMMENT 'T = Transport\r\nP = en Préparation\r\nA = Arrivée\r\nC = Cancel',
  PRIMARY KEY (`mail`,`id`)
) ;

--
-- Déchargement des données de la table `commande`
--

INSERT INTO `commande` (`mail`, `id`, `dateCommande`, `etatCde`) VALUES
('timote.anglade.45@gmail.com', '1', '2023-04-20', 'T'),
('timote.anglade.45@gmail.com', '2', '2023-05-25', 'T'),
('timote.anglade.45@gmail.com', '3', '2023-03-15', 'P'),
('timote.anglade.45@gmail.com', '4', '2022-10-11', 'P');

-- --------------------------------------------------------

--
-- Structure de la table `compte`
--

DROP TABLE IF EXISTS `compte`;
CREATE TABLE IF NOT EXISTS `compte` (
  `mail` varchar(50) NOT NULL,
  `pass` varchar(255) DEFAULT NULL,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `adresseRue` varchar(255) NOT NULL,
  `ville` varchar(50) NOT NULL,
  `cp` varchar(5) NOT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `compte`
--

INSERT INTO `compte` (`mail`, `pass`, `nom`, `prenom`, `adresseRue`, `ville`, `cp`, `admin`) VALUES
('a.fougerard@gmail.fr', '$2y$10$thuLWMDRfGPnO8St6vwu7OuojH9NbPmguDZO4ISoRvC.Z.pyvwahe', 'Fougerard', 'Antonin', '78 Chépaou', 'Orléans', '45000', 1),
('timote.anglade.45@gmail.com', '$2y$10$1VKMBjDHcDQ1MPtxpMyvVuyWqGRrkAAuNg5qp21a1EBO28CEXDuhW', 'Anglade', 'Timoté', '11 Rue Eulalie Lebrun', 'Chateauneuf Sur Loire', '45110', 1);

-- --------------------------------------------------------

--
-- Structure de la table `contenir`
--

DROP TABLE IF EXISTS `contenir`;
CREATE TABLE IF NOT EXISTS `contenir` (
  `id_produit` char(32) NOT NULL,
  `id_contenance` int(11) NOT NULL,
  `mail_commande` varchar(50) NOT NULL,
  `id_commande` char(32) NOT NULL,
  `qte` int(11) NOT NULL DEFAULT 1,
  `reduction` float DEFAULT NULL,
  PRIMARY KEY (`id_produit`,`id_contenance`,`mail_commande`,`id_commande`),
  KEY `contenir_commande0_FK` (`mail_commande`,`id_commande`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `contenir`
--

INSERT INTO `contenir` (`id_produit`, `id_contenance`, `mail_commande`, `id_commande`, `qte`, `reduction`) VALUES
('c01', 1, 'timote.anglade.45@gmail.com', '1', 1, 0.5),
('c03', 1, 'timote.anglade.45@gmail.com', '2', 1, 1),
('c07', 1, 'timote.anglade.45@gmail.com', '3', 16, 1),
('f02', 1, 'timote.anglade.45@gmail.com', '4', 1, 0.5),
('p02', 1, 'timote.anglade.45@gmail.com', '3', 11, 1),
('p06', 1, 'timote.anglade.45@gmail.com', '3', 6, 0.5);

-- --------------------------------------------------------

--
-- Structure de la table `marque`
--

DROP TABLE IF EXISTS `marque`;
CREATE TABLE IF NOT EXISTS `marque` (
  `id_marque` int(11) NOT NULL AUTO_INCREMENT,
  `nom_marque` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id_marque`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `marque`
--

INSERT INTO `marque` (`id_marque`, `nom_marque`) VALUES
(1, 'Laino'),
(2, 'Klorane'),
(3, 'Weleda'),
(4, 'Phytopulp'),
(5, 'Nuxe'),
(6, 'Avène'),
(7, 'Bioderma'),
(8, 'Futuro sport'),
(9, 'ISDIN'),
(10, 'La Roche Posay'),
(11, 'Microlife'),
(12, 'Melapi'),
(13, 'Mustela'),
(14, 'Uriage'),
(15, 'Somirel');

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

DROP TABLE IF EXISTS `panier`;
CREATE TABLE IF NOT EXISTS `panier` (
  `id` char(32) NOT NULL,
  `id_contenance` int(11) NOT NULL,
  `mail` varchar(50) NOT NULL,
  `qte` int(11) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`,`id_contenance`,`mail`),
  KEY `Panier_compte0_FK` (`mail`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

DROP TABLE IF EXISTS `produit`;
CREATE TABLE IF NOT EXISTS `produit` (
  `id` char(32) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `image` char(100) DEFAULT NULL,
  `dateMiseEnRayon` date NOT NULL,
  `id_categorie` char(32) NOT NULL,
  `id_marque` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `produit_categorie_FK` (`id_categorie`),
  KEY `produit_marque_FK` (`id_marque`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `produit`
--

INSERT INTO `produit` (`id`, `libelle`, `description`, `image`, `dateMiseEnRayon`, `id_categorie`, `id_marque`) VALUES
('c01', 'Shampooing Douche BIO', 'Shampooing Douche au Thé Vert BIO', 'images/laino-shampooing-douche-au-the-vert-bio-200ml.png', '0001-00-00', 'CH', 1),
('c02', 'Après shampooing', 'Fibres de lin baume après shampooing', 'images/UPLOADED_klorane-fibres-de-lin-baume-apres-shampooing-150-ml.jpg', '0002-00-00', 'CH', 2),
('c03', 'Shampooing orange', 'Kids 2in1 Shower & Shampoo Orange fruitée', 'images/weleda-kids-2in1-shower-shampoo-orange-fruitee-150-ml.jpg', '0003-00-00', 'CH', 3),
('c04', 'Shampooing vanille', 'Kids 2in1 Shower & Shampoo vanille douce', 'images/weleda-kids-2in1-shower-shampoo-vanille-douce-150-ml.jpg', '0004-00-00', 'CH', 3),
('c05', 'Shampooing sec', 'Shampooing sec à l\'extrait d\'ortie', 'images/klorane-shampooing-sec-a-l-extrait-d-ortie-spray-150ml.png', '0005-00-00', 'CH', 2),
('c06', 'Mousse volume', 'Mousse volume intense', 'images/phytopulp-mousse-volume-intense-200ml.jpg', '0006-00-00', 'CH', 4),
('c07', 'Shampooing nutritif', 'Shampooing nutritif', 'images/bio-beaute-by-nuxe-shampooing-nutritif-200ml.png', '0007-00-00', 'CH', 5),
('f01', 'Contour yeux', 'Contour des Yeux Multi-Fonctions', 'images/nuxe-men-contour-des-yeux-multi-fonctions-15ml.png', '0008-00-00', 'FO', 5),
('f02', 'Tisane en sachet', 'Tisane nature sommirel bio', 'images/tisane-romon-nature-sommirel-bio-sachet-20.jpg', '0009-00-00', 'FO', 15),
('f03', 'Crème pansement', 'Cicaplast crème pansement', 'images/la-roche-posay-cicaplast-creme-pansement-40ml.jpg', '0010-00-00', 'FO', 10),
('f04', 'Stabilisateur cheville', 'Sport stabilisateur pour cheville', 'images/futuro-sport-stabilisateur-pour-cheville-deluxe-attelle-cheville.png', '0011-00-00', 'FO', 8),
('f05', 'Pèse-personne électronique', 'Pèse-personne électronique weegschaal', 'images/microlife-pese-personne-electronique-weegschaal-ws80.jpg', '0012-00-00', 'FO', 11),
('f06', 'Miel Liquide', 'Miel de Thym Liquide', 'images/melapi-miel-thym-liquide-500g.jpg', '0013-00-00', 'FO', 12),
('f07', 'Pollen', 'Meliflor Pollen 200g', 'images/melapi-pollen-250g.jpg', '0014-00-00', 'FO', 12),
('p01', 'Spray solaire', 'Solaire Spray très haute protection', 'images/avene-solaire-spray-tres-haute-protection-spf50200ml.png', '0015-00-00', 'PS', 6),
('p02', 'Crème solaire', 'Solaire Lait très haute Protection', 'images/mustela-solaire-lait-tres-haute-protection-spf50-100ml.jpg', '0016-00-00', 'PS', 13),
('p03', 'Crème', 'Eryfotona aAK fluid', 'images/isdin-eryfotona-aak-fluid-100-50ml.jpg', '0017-00-00', 'PS', 9),
('p04', 'Spray visage', 'Anthélios 50+ Brume Visage', 'images/la-roche-posay-anthelios-50-brume-visage-toucher-sec-75ml.png', '0018-00-00', 'PS', 10),
('p05', 'Huile Capillaire', 'Sun Huile Lactée Capillaire Protectrice', 'images/nuxe-sun-huile-lactee-capillaire-protectrice-100ml.png', '0019-00-00', 'PS', 5),
('p06', 'Stick lèvres', 'Stick lèvres SPF30', 'images/uriage-bariesun-stick-levres-spf30-4g.jpg', '0020-00-00', 'PS', 14),
('p07', 'Crème cicatrisante', 'Cicabio creme SPF50+', 'images/bioderma-cicabio-creme-spf50-30ml.png', '0021-00-00', 'PS', 7);

-- --------------------------------------------------------

--
-- Structure de la table `produitcontenance`
--

DROP TABLE IF EXISTS `produitcontenance`;
CREATE TABLE IF NOT EXISTS `produitcontenance` (
  `id` char(32) NOT NULL,
  `id_contenance` int(11) NOT NULL,
  `prix` double NOT NULL,
  `qte` int(11) NOT NULL,
  `stock` int(11) NOT NULL DEFAULT 0,
  `isBase` tinyint(1) NOT NULL,
  `id_unit` int(11) NOT NULL,
  PRIMARY KEY (`id`,`id_contenance`),
  KEY `ProduitContenance_unites0_FK` (`id_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `produitcontenance`
--

INSERT INTO `produitcontenance` (`id`, `id_contenance`, `prix`, `qte`, `stock`, `isBase`, `id_unit`) VALUES
('c01', 1, 4, 200, 50, 1, 1),
('c02', 1, 11, 150, 50, 1, 1),
('c03', 1, 4, 150, 50, 1, 1),
('c04', 1, 4, 150, 50, 1, 1),
('c05', 1, 6, 50, 50, 1, 1),
('c06', 1, 18, 200, 50, 1, 1),
('c07', 1, 8, 200, 50, 1, 1),
('f01', 1, 12, 15, 50, 1, 1),
('f02', 1, 6, 20, 50, 1, 6),
('f02', 2, 12, 40, 0, 0, 6),
('f03', 1, 11, 40, 50, 1, 1),
('f04', 1, 27, 1, 50, 1, 7),
('f05', 1, 63, 1, 50, 1, 7),
('f06', 1, 7, 500, 50, 1, 3),
('f07', 1, 9, 200, 50, 1, 3),
('p01', 1, 22, 200, 50, 1, 1),
('p02', 1, 18, 100, 50, 1, 1),
('p03', 1, 29, 50, 50, 1, 1),
('p04', 1, 9, 75, 50, 1, 1),
('p05', 1, 15, 100, 50, 1, 1),
('p06', 1, 6, 4, 50, 1, 3),
('p07', 1, 14, 30, 50, 1, 1);

-- --------------------------------------------------------

--
-- Structure de la table `promotion`
--

DROP TABLE IF EXISTS `promotion`;
CREATE TABLE IF NOT EXISTS `promotion` (
  `id_reduc` float NOT NULL,
  `reduction` float NOT NULL,
  `poidsReco` int(11) NOT NULL,
  PRIMARY KEY (`id_reduc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `promotion`
--

INSERT INTO `promotion` (`id_reduc`, `reduction`, `poidsReco`) VALUES
(1, 0.5, 3),
(2, 0.9, 2);

-- --------------------------------------------------------

--
-- Structure de la table `recommande`
--

DROP TABLE IF EXISTS `recommande`;
CREATE TABLE IF NOT EXISTS `recommande` (
  `id` char(32) NOT NULL,
  `id_produit` char(32) NOT NULL,
  PRIMARY KEY (`id`,`id_produit`),
  KEY `recommande_produit0_FK` (`id_produit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `recommande`
--

INSERT INTO `recommande` (`id`, `id_produit`) VALUES
('c01', 'c02'),
('c01', 'c04'),
('c01', 'c07'),
('c01', 'f03'),
('c01', 'f04'),
('c01', 'p02'),
('c04', 'c06');

-- --------------------------------------------------------

--
-- Structure de la table `sur`
--

DROP TABLE IF EXISTS `sur`;
CREATE TABLE IF NOT EXISTS `sur` (
  `id_reduc` float NOT NULL,
  `id` char(32) NOT NULL,
  `id_contenance` int(11) NOT NULL,
  PRIMARY KEY (`id_reduc`,`id`,`id_contenance`),
  KEY `sur_produit0_FK` (`id`),
  KEY `sur_produitcontenance_fk` (`id`,`id_contenance`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `sur`
--

INSERT INTO `sur` (`id_reduc`, `id`, `id_contenance`) VALUES
(1, 'c01', 1),
(1, 'c02', 1),
(1, 'f02', 1),
(1, 'f02', 2),
(1, 'p06', 1),
(2, 'f04', 1);

-- --------------------------------------------------------

--
-- Structure de la table `unites`
--

DROP TABLE IF EXISTS `unites`;
CREATE TABLE IF NOT EXISTS `unites` (
  `id_unit` int(11) NOT NULL,
  `unit_intitule` varchar(50) NOT NULL,
  `unit_pluriel` varchar(50) NOT NULL,
  PRIMARY KEY (`id_unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Déchargement des données de la table `unites`
--

INSERT INTO `unites` (`id_unit`, `unit_intitule`, `unit_pluriel`) VALUES
(1, 'mL', ''),
(2, 'L', ''),
(3, 'g', ''),
(4, 'kg', ''),
(5, 'paquet', 'paquets'),
(6, 'sachet', 'sachets'),
(7, 'exemplaire', 'exemplaires');

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `archivecontenir`
--
ALTER TABLE `archivecontenir`
  ADD CONSTRAINT `archivecontenir_archivagecommande0_FK` FOREIGN KEY (`id_archivagecommande`) REFERENCES `archivagecommande` (`id`),
  ADD CONSTRAINT `archivecontenir_produit_FK` FOREIGN KEY (`id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `avis`
--
ALTER TABLE `avis`
  ADD CONSTRAINT `avis_compte_fk` FOREIGN KEY (`mail`) REFERENCES `compte` (`mail`),
  ADD CONSTRAINT `avis_produit_fk` FOREIGN KEY (`id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `commande_compte_FK` FOREIGN KEY (`mail`) REFERENCES `compte` (`mail`);

--
-- Contraintes pour la table `contenir`
--
ALTER TABLE `contenir`
  ADD CONSTRAINT `contenir_ProduitContenance_FK` FOREIGN KEY (`id_produit`,`id_contenance`) REFERENCES `produitcontenance` (`id`, `id_contenance`),
  ADD CONSTRAINT `contenir_commande0_FK` FOREIGN KEY (`mail_commande`,`id_commande`) REFERENCES `commande` (`mail`, `id`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `Panier_ProduitContenance_FK` FOREIGN KEY (`id`,`id_contenance`) REFERENCES `produitcontenance` (`id`, `id_contenance`),
  ADD CONSTRAINT `Panier_compte0_FK` FOREIGN KEY (`mail`) REFERENCES `compte` (`mail`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `produit_categorie_FK` FOREIGN KEY (`id_categorie`) REFERENCES `categorie` (`id`),
  ADD CONSTRAINT `produit_marque_FK` FOREIGN KEY (`id_marque`) REFERENCES `marque` (`id_marque`);

--
-- Contraintes pour la table `produitcontenance`
--
ALTER TABLE `produitcontenance`
  ADD CONSTRAINT `ProduitContenance_produit_FK` FOREIGN KEY (`id`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `ProduitContenance_unites0_FK` FOREIGN KEY (`id_unit`) REFERENCES `unites` (`id_unit`);

--
-- Contraintes pour la table `recommande`
--
ALTER TABLE `recommande`
  ADD CONSTRAINT `recommande_produit0_FK` FOREIGN KEY (`id_produit`) REFERENCES `produit` (`id`),
  ADD CONSTRAINT `recommande_produit_FK` FOREIGN KEY (`id`) REFERENCES `produit` (`id`);

--
-- Contraintes pour la table `sur`
--
ALTER TABLE `sur`
  ADD CONSTRAINT `sur_produitcontenance_fk` FOREIGN KEY (`id`,`id_contenance`) REFERENCES `produitcontenance` (`id`, `id_contenance`),
  ADD CONSTRAINT `sur_promotion_FK` FOREIGN KEY (`id_reduc`) REFERENCES `promotion` (`id_reduc`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
