-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : jeu. 08 mai 2025 à 17:53
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
-- Base de données : `velvetbloom_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `administrateur`
--

CREATE TABLE `administrateur` (
  `id_admin` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `administrateur`
--

INSERT INTO `administrateur` (`id_admin`, `nom`, `password`) VALUES
(1, 'Hafsa', 'hafsapass1'),
(2, 'Aya', 'ayapass2');

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `adresse` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `client`
--

INSERT INTO `client` (`id_client`, `nom`, `email`, `adresse`, `password`) VALUES
(1, 'hafsa', 'hafsa1@gmail.com', '123, Rue des Lilas, Casa', 'hafsamotdepasse1'),
(2, 'aya', 'aya@gmail.com', 'marrakech', 'ayaamotdepasse2'),
(4, 'cbhiebf', 'vvrear@hbrivhber', 'vbiurehug', 'hahahahaha'),
(5, 'test', 'test@test.com', 'testtest', '$2y$10$HO2v9/qE7hYLmNxtB9X9x.g4ZwObGm3WFMaj/jAdqvZKC5WZjP50m');

-- --------------------------------------------------------

--
-- Structure de la table `commande_client`
--

CREATE TABLE `commande_client` (
  `id_commande` int(11) NOT NULL,
  `id_client` int(11) DEFAULT NULL,
  `id_materiel` int(11) DEFAULT NULL,
  `date_commande` date NOT NULL,
  `statut` text NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `commande_client`
--

INSERT INTO `commande_client` (`id_commande`, `id_client`, `id_materiel`, `date_commande`, `statut`, `quantite`) VALUES
(1, 1, 1, '2025-04-06', '', 4),
(2, 2, 3, '2024-05-08', '', 2),
(3, 2, 2, '2025-05-06', '', 1),
(40, 5, 4, '2025-05-08', 'confirmed', 1),
(41, 5, 4, '2025-05-08', 'confirmed', 1),
(42, 5, 1, '2025-05-08', 'confirmed', 1),
(43, 5, 2, '2025-05-08', 'confirmed', 2);

-- --------------------------------------------------------

--
-- Structure de la table `materiel`
--

CREATE TABLE `materiel` (
  `id_materiel` int(11) NOT NULL,
  `produit` varchar(100) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `prix` decimal(10,2) NOT NULL,
  `caracteristique` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `materiel`
--

INSERT INTO `materiel` (`id_materiel`, `produit`, `image`, `prix`, `caracteristique`) VALUES
(1, 'Robe élégante', 'Robe élégante1.jpg', 450.00, 'Robe longue en satin, coupe ajustée, couleur bordeaux'),
(2, 'Jean taille haute', 'Jean taille haute 1.jpg', 299.99, 'Jean bleu clair, coupe droite, tissu stretch'),
(3, 'Sac en cuir', 'Sacencuir 1.jpg', 520.50, 'Sac à main noir, cuir véritable, anse réglable'),
(4, 'Top fluide', 'topfluide1.jpg', 189.90, 'Top blanc en mousseline, manches longues'),
(10, 'baggy jean', 'pic5.jpg', 250.00, 'nice jean');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `administrateur`
--
ALTER TABLE `administrateur`
  ADD PRIMARY KEY (`id_admin`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Index pour la table `commande_client`
--
ALTER TABLE `commande_client`
  ADD PRIMARY KEY (`id_commande`),
  ADD KEY `id_client` (`id_client`),
  ADD KEY `id_materiel` (`id_materiel`);

--
-- Index pour la table `materiel`
--
ALTER TABLE `materiel`
  ADD PRIMARY KEY (`id_materiel`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `administrateur`
--
ALTER TABLE `administrateur`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `commande_client`
--
ALTER TABLE `commande_client`
  MODIFY `id_commande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT pour la table `materiel`
--
ALTER TABLE `materiel`
  MODIFY `id_materiel` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `commande_client`
--
ALTER TABLE `commande_client`
  ADD CONSTRAINT `commande_client_ibfk_1` FOREIGN KEY (`id_client`) REFERENCES `client` (`id_client`),
  ADD CONSTRAINT `commande_client_ibfk_2` FOREIGN KEY (`id_materiel`) REFERENCES `materiel` (`id_materiel`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
