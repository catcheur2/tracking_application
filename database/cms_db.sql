-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 10.123.0.54:3306
-- Généré le :  ven. 01 mars 2024 à 04:03
-- Version du serveur :  8.0.22
-- Version de PHP :  7.0.33-0+deb9u12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `theparadoxe6_boca_group`
--

-- --------------------------------------------------------

--
-- Structure de la table `branches`
--

CREATE TABLE `branches` (
  `id` int NOT NULL,
  `branch_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `street` text COLLATE utf8mb4_general_ci NOT NULL,
  `city` text COLLATE utf8mb4_general_ci NOT NULL,
  `state` text COLLATE utf8mb4_general_ci NOT NULL,
  `zip_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `country` text COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `branches`
--

INSERT INTO `branches` (`id`, `branch_code`, `street`, `city`, `state`, `zip_code`, `country`, `contact`, `date_created`) VALUES
(5, 'NGIQrXDl3EhWkLY', '400 Rue Mermoz', 'Douala', '', '', 'Cameroun', '698256867', '2023-10-26 18:47:41'),
(7, 'CktsquZix84gM2O', 'Rue 333', 'Kribi', '', '', 'Cameroun', '4646', '2023-10-26 22:58:33');

-- --------------------------------------------------------

--
-- Structure de la table `compte_crediter`
--

CREATE TABLE `compte_crediter` (
  `id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `compte_crediter`
--

INSERT INTO `compte_crediter` (`id`, `nom`) VALUES
(1, 'Belgique'),
(2, 'Cameroun');

-- --------------------------------------------------------

--
-- Structure de la table `conteneur`
--

CREATE TABLE `conteneur` (
  `id` int NOT NULL,
  `nom_c` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_c` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `conteneur`
--

INSERT INTO `conteneur` (`id`, `nom_c`, `status_c`) VALUES
(9, 'E001', '1');

-- --------------------------------------------------------

--
-- Structure de la table `conteneur_track`
--

CREATE TABLE `conteneur_track` (
  `id` int NOT NULL,
  `invoice_id` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `conteneur_id` int NOT NULL,
  `status` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lu` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

-- --------------------------------------------------------

--
-- Structure de la table `destination`
--

CREATE TABLE `destination` (
  `id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `destination`
--

INSERT INTO `destination` (`id`, `nom`) VALUES
(1, 'Belgique'),
(2, 'Allemagne'),
(4, 'France'),
(5, 'Cameroun');

-- --------------------------------------------------------

--
-- Structure de la table `invoice`
--

CREATE TABLE `invoice` (
  `sid` int NOT NULL,
  `invoice_no` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `num_conteneur` int NOT NULL,
  `sender_name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `sender_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `sender_email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_depot` datetime NOT NULL,
  `recipient_name` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `recipient_address` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `recipient_email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `destination` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `conteneur` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `note` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `status_retr` int NOT NULL DEFAULT '1',
  `retire` int NOT NULL DEFAULT '0',
  `creance` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `total_reduction` double NOT NULL,
  `grand_total` double NOT NULL,
  `grand_euro` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `invoice`
--

INSERT INTO `invoice` (`sid`, `invoice_no`, `num_conteneur`, `sender_name`, `sender_address`, `sender_email`, `date_depot`, `recipient_name`, `recipient_address`, `recipient_email`, `destination`, `conteneur`, `note`, `status`, `status_retr`, `retire`, `creance`, `total_reduction`, `grand_total`, `grand_euro`) VALUES
(316, 'IN1123-0001', 9, 'TAGNE WILLIAMS', '+237268256867', '/', '2023-12-02 00:00:00', 'MACKTUS Gerald', '+237698256867', '/', '5', '', '', 2, 1, 0, '0', 0, 12, 8160),
(317, 'IN1223-0001', 9, '123', '*', '/', '2023-12-14 00:00:00', 'MACKTUS Gerald', '*', '/', '2', '', 'jtyuituitgig', 2, 1, 0, '-100', 0, 500, 340000),
(318, 'IN1223-0002', 9, 'Serena james', '+237698265896', 'carmel.kacre@gmail.com', '2023-12-10 00:00:00', 'MACKTUS Gerald', '+237698926948', 'jordan.kacre@datacorp-sarl.com', '4', '', 'tele', 0, 1, 0, '200', 0, 200, 136000),
(319, 'IN1223-0003', 9, 'TAGNE WILLIAMS', '+237690369856', '/', '2023-12-07 00:00:00', '225', '+237694589622', '/', '5', '', '', 0, 1, 0, '250', 0, 250, 170000),
(320, 'IN1223-0004', 9, 'LUCRECE', '+237698586985', '/', '2023-12-16 00:00:00', 'KACRE', '+237692569856', '/', '2', '', '', 0, 1, 0, '100', 0, 100, 68000);

-- --------------------------------------------------------

--
-- Structure de la table `invoice_products`
--

CREATE TABLE `invoice_products` (
  `ID` int NOT NULL,
  `SID` int NOT NULL,
  `invoice_no` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `pname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `weight` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `pricecol` float NOT NULL,
  `height` float NOT NULL,
  `length` float NOT NULL,
  `width` float NOT NULL,
  `vol` float NOT NULL,
  `pricevol` float NOT NULL,
  `reduction` float NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `invoice_products`
--

INSERT INTO `invoice_products` (`ID`, `SID`, `invoice_no`, `pname`, `weight`, `pricecol`, `height`, `length`, `width`, `vol`, `pricevol`, `reduction`, `total`) VALUES
(384, 316, '', 'carton xv', '1', 0, 1.32, 0.8, 0.25, 0.264, 45, 0, 11.88),
(387, 317, '', 'carton xv', '5', 100, 0, 0, 0, 0, 0, 0, 500),
(389, 319, '', 'FUT DE CAVE', '5', 50, 0, 0, 0, 0, 0, 0, 250),
(390, 320, '', 'carton xv', '10', 10, 0, 0, 0, 0, 0, 0, 100),
(391, 318, '', 'carton vin', '5', 0, 1, 1, 1, 1, 200, 0, 200);

-- --------------------------------------------------------

--
-- Structure de la table `invoice_track`
--

CREATE TABLE `invoice_track` (
  `id` int NOT NULL,
  `invoice_sid` int NOT NULL,
  `conteneur_inv` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `statut_inv` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `date_created_inv` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

-- --------------------------------------------------------

--
-- Structure de la table `mode_paiement`
--

CREATE TABLE `mode_paiement` (
  `id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `mode_paiement`
--

INSERT INTO `mode_paiement` (`id`, `nom`) VALUES
(1, 'Chèque'),
(2, 'Espèce');

-- --------------------------------------------------------

--
-- Structure de la table `paiement`
--

CREATE TABLE `paiement` (
  `id` int NOT NULL,
  `sid` int NOT NULL,
  `date_paiement` date NOT NULL,
  `type_paiement` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `montant` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0',
  `compte_credite` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `paiement`
--

INSERT INTO `paiement` (`id`, `sid`, `date_paiement`, `type_paiement`, `montant`, `compte_credite`) VALUES
(53, 316, '0000-00-00', '0', '0', '0'),
(54, 316, '1970-01-01', '2', '12', '2'),
(55, 317, '0000-00-00', '0', '0', '0'),
(56, 317, '2023-12-03', '1', '600', '2'),
(57, 318, '0000-00-00', '0', '0', '0'),
(58, 319, '0000-00-00', '0', '0', '0'),
(59, 320, '0000-00-00', '0', '0', '0');

-- --------------------------------------------------------

--
-- Structure de la table `parcels`
--

CREATE TABLE `parcels` (
  `id` int NOT NULL,
  `reference_number` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `sender_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `sender_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `sender_contact` text COLLATE utf8mb4_general_ci NOT NULL,
  `recipient_name` text COLLATE utf8mb4_general_ci NOT NULL,
  `recipient_address` text COLLATE utf8mb4_general_ci NOT NULL,
  `recipient_contact` text COLLATE utf8mb4_general_ci NOT NULL,
  `type` int NOT NULL COMMENT '1 = Deliver, 2=Pickup',
  `from_branch_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `to_branch_id` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `weight` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `height` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `width` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `length` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `price` float NOT NULL,
  `status` int NOT NULL DEFAULT '0',
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `parcels`
--

INSERT INTO `parcels` (`id`, `reference_number`, `sender_name`, `sender_address`, `sender_contact`, `recipient_name`, `recipient_address`, `recipient_contact`, `type`, `from_branch_id`, `to_branch_id`, `weight`, `height`, `width`, `length`, `price`, `status`, `date_created`) VALUES
(1, '201406231415', 'John Smith', 'Sample', '+123456', 'Claire Blake', 'Sample', 'Sample', 1, '1', '0', '30kg', '12in', '12in', '15in', 2500, 7, '2020-11-26 16:15:46'),
(2, '117967400213', 'John Smith', 'Sample', '+123456', 'Claire Blake', 'Sample', 'Sample', 2, '1', '3', '30kg', '12in', '12in', '15in', 2500, 1, '2020-11-26 16:46:03'),
(3, '983186540795', 'John Smith', 'Sample', '+123456', 'Claire Blake', 'Sample', 'Sample', 2, '1', '3', '20Kg', '10in', '10in', '10in', 1500, 2, '2020-11-26 16:46:03'),
(4, '514912669061', 'Claire Blake', 'Sample', '+123456', 'John Smith', 'Sample Address', '+12345', 2, '4', '1', '23kg', '12in', '12in', '15in', 1900, 0, '2020-11-27 13:52:14'),
(5, '897856905844', 'Claire Blake', 'Sample', '+123456', 'John Smith', 'Sample Address', '+12345', 2, '4', '1', '30kg', '10in', '10in', '10in', 1450, 0, '2020-11-27 13:52:14'),
(6, '505604168988', 'John Smith', 'Sample', '+123456', 'Sample', 'Sample', '+12345', 1, '1', '0', '23kg', '12in', '12in', '15in', 2500, 1, '2020-11-27 14:06:42');

-- --------------------------------------------------------

--
-- Structure de la table `parcel_tracks`
--

CREATE TABLE `parcel_tracks` (
  `id` int NOT NULL,
  `parcel_id` int NOT NULL,
  `status` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `parcel_tracks`
--

INSERT INTO `parcel_tracks` (`id`, `parcel_id`, `status`, `date_created`) VALUES
(1, 2, 1, '2020-11-27 09:53:27'),
(2, 3, 1, '2020-11-27 09:55:17'),
(3, 1, 1, '2020-11-27 10:28:01'),
(4, 1, 2, '2020-11-27 10:28:10'),
(5, 1, 3, '2020-11-27 10:28:16'),
(6, 1, 4, '2020-11-27 11:05:03'),
(7, 1, 5, '2020-11-27 11:05:17'),
(8, 1, 7, '2020-11-27 11:05:26'),
(9, 3, 2, '2020-11-27 11:05:41'),
(10, 6, 1, '2020-11-27 14:06:57');

-- --------------------------------------------------------

--
-- Structure de la table `status`
--

CREATE TABLE `status` (
  `id` int NOT NULL,
  `nom` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `status`
--

INSERT INTO `status` (`id`, `nom`) VALUES
(1, 'Ouvert'),
(2, 'Payé');

-- --------------------------------------------------------

--
-- Structure de la table `status_conteneur`
--

CREATE TABLE `status_conteneur` (
  `id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `status_conteneur`
--

INSERT INTO `status_conteneur` (`id`, `nom`) VALUES
(1, 'Prêt à l\'embarquement'),
(2, 'En Transit'),
(3, 'A Douala'),
(4, 'A Yaoundé'),
(5, 'Arrivé à destination'),
(7, 'Retiré');

-- --------------------------------------------------------

--
-- Structure de la table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int NOT NULL,
  `name` text COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `contact` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `address` text COLLATE utf8mb4_general_ci NOT NULL,
  `cover_img` text COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `address`, `cover_img`) VALUES
(1, 'Système de gestion de transferts des colis', 'info@sample.comm', '+6948 8542 623', '2102  Caldwell Road, Rochester, New York, 14608', '');

-- --------------------------------------------------------

--
-- Structure de la table `test`
--

CREATE TABLE `test` (
  `id` int NOT NULL,
  `nom` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `firstname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `password` text COLLATE utf8mb4_general_ci NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '2' COMMENT '1 = admin, 2 = staff',
  `branch_id` int NOT NULL,
  `date_created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci TABLESPACE `theparadoxe6_boca_group`;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `type`, `branch_id`, `date_created`) VALUES
(1, 'Administrateur', '', 'noelmonkam@github.com', '5e8667a439c68f5145dd2fcbecf02209', 1, 0, '2020-11-26 10:57:04'),
(2, 'jordan', 'kacre', 'jordan@jordan.com', '25d55ad283aa400af464c76d713c07ad', 2, 1, '2020-11-26 11:52:04'),
(3, 'noel', 'catcheur', 'noel@noel.com', '25d55ad283aa400af464c76d713c07ad', 3, 4, '2020-11-27 13:32:12'),
(4, 'mike', 'kouamo', 'mike@mike.com', '1254737c076cf867dc53d60a0364f38e', 3, 0, '2023-11-23 01:36:21');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `compte_crediter`
--
ALTER TABLE `compte_crediter`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `conteneur`
--
ALTER TABLE `conteneur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `conteneur_track`
--
ALTER TABLE `conteneur_track`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `destination`
--
ALTER TABLE `destination`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`sid`);

--
-- Index pour la table `invoice_products`
--
ALTER TABLE `invoice_products`
  ADD PRIMARY KEY (`ID`);

--
-- Index pour la table `invoice_track`
--
ALTER TABLE `invoice_track`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `mode_paiement`
--
ALTER TABLE `mode_paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `paiement`
--
ALTER TABLE `paiement`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parcels`
--
ALTER TABLE `parcels`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parcel_tracks`
--
ALTER TABLE `parcel_tracks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `status_conteneur`
--
ALTER TABLE `status_conteneur`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `test`
--
ALTER TABLE `test`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT pour la table `compte_crediter`
--
ALTER TABLE `compte_crediter`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `conteneur`
--
ALTER TABLE `conteneur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT pour la table `conteneur_track`
--
ALTER TABLE `conteneur_track`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT pour la table `destination`
--
ALTER TABLE `destination`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `sid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=321;

--
-- AUTO_INCREMENT pour la table `invoice_products`
--
ALTER TABLE `invoice_products`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=392;

--
-- AUTO_INCREMENT pour la table `invoice_track`
--
ALTER TABLE `invoice_track`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `mode_paiement`
--
ALTER TABLE `mode_paiement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `paiement`
--
ALTER TABLE `paiement`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT pour la table `parcels`
--
ALTER TABLE `parcels`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pour la table `parcel_tracks`
--
ALTER TABLE `parcel_tracks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `status`
--
ALTER TABLE `status`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `status_conteneur`
--
ALTER TABLE `status_conteneur`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT pour la table `test`
--
ALTER TABLE `test`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pour la table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
