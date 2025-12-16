-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mar. 16 déc. 2025 à 13:04
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

-- --------------------------------------------------------

--
-- Structure de la table `reservation`
--

CREATE TABLE `reservation` (
  `id` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL,
  `outil_id` int(11) NOT NULL,
  `date_debut` date NOT NULL,
  `date_fin` date NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `reservation`
--

INSERT INTO `reservation` (`id`, `utilisateur_id`, `outil_id`, `date_debut`, `date_fin`, `quantite`) VALUES
(1, 3, 1, '2025-11-20', '2025-11-22', 1),
(2, 5, 4, '2025-11-23', '2025-11-25', 2),
(3, 7, 6, '2025-11-26', '2025-11-28', 1),
(4, 9, 3, '2025-11-29', '2025-11-30', 1),
(5, 12, 8, '2025-12-01', '2025-12-03', 1),
(6, 2, 10, '2025-12-02', '2025-12-04', 1),
(7, 14, 12, '2025-12-05', '2025-12-07', 1),
(8, 16, 5, '2025-12-06', '2025-12-09', 3),
(9, 18, 7, '2025-12-08', '2025-12-10', 1),
(10, 20, 2, '2025-12-11', '2025-12-13', 1),
(11, 1, 9, '2025-12-14', '2025-12-15', 2),
(12, 4, 11, '2025-12-15', '2025-12-17', 1),
(13, 6, 14, '2025-12-18', '2025-12-19', 1),
(14, 8, 16, '2025-12-19', '2025-12-21', 1),
(15, 10, 17, '2025-12-20', '2025-12-23', 2),
(16, 11, 19, '2025-12-24', '2025-12-26', 1),
(17, 13, 20, '2025-12-27', '2025-12-29', 1),
(18, 15, 21, '2025-12-28', '2025-12-30', 1),
(19, 17, 22, '2025-12-30', '2026-01-02', 1),
(20, 19, 13, '2026-01-03', '2026-01-05', 2),
(21, 3, 22, '2025-12-14', '2025-12-15', 1),
(23, 3, 22, '2025-12-14', '2025-12-15', 1);

-- --------------------------------------------------------

--
-- Structure de la table `utilisateurs`
--

CREATE TABLE `utilisateurs` (
  `id` int(11) NOT NULL,
  `identifiant` varchar(255) NOT NULL,
  `motdepasse` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `utilisateurs`
--

INSERT INTO `utilisateurs` (`id`, `identifiant`, `motdepasse`, `role`) VALUES
(1, 'Robert', '$2y$10$HbgiSLtH8AGGI1XmXVZ8x.Odge3WG80pCdvQDN2AqKj1qoges2HOq', 'user'),
(2, 'Admin', '$2y$10$R2CB7vesLHr1sFMYTmwjhunAx9f4CHmmyqwkjYGAhCdpEV5WGU5Rm', 'admin'),
(3, 'Julie', '$2y$10$ivLDHvsqK5oez2U9.oUDMOuMBZ7R.9GGzNO9DU9AR3wd8E47L5r3S', 'user'),
(4, 'Mathilde', '$2y$10$eiMcjKwtgknmQ1zz9yi..u3wTXmBOWoRx/feNgVXEouh9WP9EzjRG', 'user'),
(5, 'Pascal', '$2y$10$CO/UbdcD/cv0AJeoiE1jZ.Id7rtKzFfexT8N2ryVKWwEt67iThoWi', 'user'),
(6, 'Marie', '$2y$10$uVHx9OgR4UBV5QgdHPP.feglsepcdDmVjYnjLcWLe6S20qvGlSNCG', 'user'),
(7, 'Taslim', '$2y$10$jfb6mqzCa3AWwzx29HpPGOFMHY7UBCLw5XWuasau3I26iT5wdT6Fm', 'user'),
(8, 'Safiya', '$2y$10$sIyA2Usa33A7bQqVzKKa..SR7/hjXm7F7djFXVpA5NtsHa/L3YA4y', 'user'),
(9, 'Lucie', '$2y$10$g3SqyJwyacpahGQiawcR/.SotX.0CnXKNWNt9ba.JtFA3JGLCtTjW', 'user'),
(10, 'Stéphane', '$2y$10$KO0X.YyCyfdYJy3oqh9EiumE1NXfs/wh2reX59Rhsp.IDN0VKFYBC', 'user'),
(11, 'Alexis', '$2y$10$LUM.0jaIOur1ajnvq5pMR.krXDFgZsm255IBEDWRMXzpbkQTMTKAq', 'user'),
(12, 'Martin', '$2y$10$Dt.ZyW1KIosmmPjA4VhJ0eevZ7cCKPsfMeCucNbfndKYjBZLsDixO', 'user'),
(13, 'Enzo', '$2y$10$5IMJCvSBOOBcFHXU3Vdzz.Lwp/gUCYV.Fe5ajf.Mvdl3XTiaC3LFS', 'user'),
(14, 'Patrick', '$2y$10$Ll0TfcoKRv8M.KV6/2SaLe5o2e472VpdSUTSeawaczsd40pPRU2qO', 'user'),
(15, 'Laurence', '$2y$10$0d7OpdBZIbnaPG0tdiRxQepaZvujEUnWDOUuaduZXZfJ8uzzNQA/i', 'user'),
(16, 'Paul', '$2y$10$wabj6B4OPNZHggTL7UAPXeRpl80nb7AtU9eOLbCYTuOB0HBIXCEMS', 'user'),
(17, 'Jacques', '$2y$10$n5kq6LSwwwb1ju5CVBZe9e7x2LqyVOzGY/ui.2LNUAxrMa5N8ASX6', 'user'),
(18, 'Laure', '$2y$10$vow5Tp267R/Yvqetqo8P5..LJUMhn0Rl9EhoEfpljgz2l2Y/PMNfu', 'user'),
(19, 'Michel', '$2y$10$CHuJU9a6oCn1Vjp284dN2eyg3We6Vi5TIHHmnm..SPuShNS6Zpu5m', 'user'),
(20, 'Annick', '$2y$10$Wuta0ReG/boc.ga6RMtSJuF.LW67.Yd183mMzEw/RmA/aX/2lxgbm', 'user');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `outil`
--
ALTER TABLE `outil`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_reservation_utilisateur` (`utilisateur_id`),
  ADD KEY `idx_reservation_outil` (`outil_id`);

--
-- Index pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `outil`
--
ALTER TABLE `outil`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT pour la table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `utilisateurs`
--
ALTER TABLE `utilisateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `fk_reservation_outil` FOREIGN KEY (`outil_id`) REFERENCES `outil` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_reservation_utilisateur` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateurs` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
