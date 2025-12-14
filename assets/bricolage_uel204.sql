-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : dim. 14 déc. 2025 à 16:30
-- Version du serveur : 10.4.32-MariaDB
-- Version de PHP : 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `bricolage_uel204`
--

-- --------------------------------------------------------

--
-- Structure de la table `outil`
--

CREATE TABLE `outil` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `quantite` int(11) NOT NULL,
  `tarif_journee` int(11) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT 'images/outils/default.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `outil`
--

INSERT INTO `outil` (`id`, `nom`, `quantite`, `tarif_journee`, `image`) VALUES
(1, 'ponceuse parquet', 10, 50, 'assets/images/outils/ponceuse_parquet.webp'),
(2, 'shampouineuse', 5, 30, 'assets/images/outils/shampouineuse.jpg'),
(3, 'perforateur', 10, 20, 'assets/images/outils/perforateur.jpg'),
(4, 'tronçonneuse', 10, 30, 'assets/images/outils/tronconneuse.jpg'),
(5, 'diable', 15, 10, 'assets/images/outils/diable.webp'),
(6, 'scie circulaire', 10, 20, 'assets/images/outils/scie_circulaire.jpg'),
(7, 'perceuse visseuse', 15, 15, 'assets/images/outils/perceuse_visseuse.webp'),
(8, 'tondeuse', 7, 10, 'assets/images/outils/tondeuse.jpg'),
(9, 'scie sauteuse', 12, 10, 'assets/images/outils/scie_sauteuse.jpg'),
(10, 'niveau laser', 15, 10, 'assets/images/outils/niveau_laser.jpg'),
(11, 'rainureuse', 5, 30, 'assets/images/outils/rainureuse.jpg'),
(12, 'taille-haie', 10, 25, 'assets/images/outils/taille_haie.jpg'),
(13, 'serre-joint', 10, 10, 'assets/images/outils/serre_joint.jpg'),
(14, 'caisse à outils', 15, 10, 'assets/images/outils/caisse_outils.jpg'),
(15, 'décapeur', 5, 15, 'assets/images/outils/decapeur.webp'),
(16, 'pistolet à colle', 10, 15, 'assets/images/outils/pistolet_colle.jpg'),
(17, 'débroussailleuse', 13, 20, 'assets/images/outils/debroussailleuse.jpg'),
(18, 'coupe-bordure', 8, 15, 'assets/images/outils/coupe_bordure.webp'),
(19, 'nettoyeur haute pression', 15, 20, 'assets/images/outils/nettoyeur_haute_pression.webp'),
(20, 'échelle', 20, 10, 'assets/images/outils/echelle.jpg'),
(21, 'compresseur', 6, 30, 'assets/images/outils/compresseur.jpeg'),
(22, 'aspirateur de chantier', 10, 15, 'assets/images/outils/aspirateur_de_chantier.avif'),
(23, 'élagueuse', 5, 55, 'assets/images/outils/elagueuse.jpg'),
(24, 'meuleuse', 15, 20, 'assets/images/outils/meuleuse.jpg'),
(25, 'transpalette', 4, 75, 'assets/images/outils/transpalette.jpg'),
(26, 'Boulonneuse', 14, 27, 'assets/images/outils/boulonneuse.jpg'),
(27, 'nacelle', 6, 80, 'assets/images/outils/nacelle.jpg'),
(28, 'remorque', 2, 40, 'assets/images/outils/remorque.jpg'),
(29, 'souffleur', 10, 35, 'assets/images/outils/souffleur.jpg'),
(30, 'déshumidificateur', 15, 70, 'assets/images/outils/deshumidificateur.jpg');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `outil`
--
ALTER TABLE `outil`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `outil`
--
ALTER TABLE `outil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
