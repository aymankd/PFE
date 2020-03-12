-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  Dim 02 fév. 2020 à 14:33
-- Version du serveur :  10.4.11-MariaDB
-- Version de PHP :  7.2.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `pfe`
--

-- --------------------------------------------------------

--
-- Structure de la table `admin`
--

CREATE TABLE `admin` (
  `CodeAd` int(5) NOT NULL,
  `CIN` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `appartement`
--

CREATE TABLE `appartement` (
  `Codeapp` int(5) NOT NULL,
  `nbrC` int(1) DEFAULT NULL,
  `nbrP` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `eqlo`
--

CREATE TABLE `eqlo` (
  `CodeE` varchar(5) NOT NULL,
  `CodeL` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `equipement`
--

CREATE TABLE `equipement` (
  `CodeE` varchar(5) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `equipement`
--

INSERT INTO `equipement` (`CodeE`, `nom`) VALUES
('01', 'serviettes,draps,savon,papier toilette, oreillers'),
('02', 'Climatisation'),
('03', 'Chauffage'),
('04', 'Seche-cheveux'),
('05', 'Penderie/Commode'),
('06', 'Fer a repasser'),
('07', 'Television'),
('08', 'Cheminée'),
('09', 'Entrée privée'),
('10', 'Shampoing'),
('11', 'Wi-Fi'),
('12', 'Bureau/Espace de travail'),
('13', 'Petit dejeuner,café,thé'),
('14', 'Extincteur'),
('15', 'Detecteur de monoxyde de carbon'),
('16', 'Detecteur de fumée'),
('17', 'Kit de premiers secours');

-- --------------------------------------------------------

--
-- Structure de la table `files`
--

CREATE TABLE `files` (
  `CodeL` int(5) NOT NULL,
  `file` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `image`
--

CREATE TABLE `image` (
  `CodeL` int(5) DEFAULT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `logement`
--

CREATE TABLE `logement` (
  `CodeL` int(5) NOT NULL,
  `CodeP` int(5) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `description` varchar(3000) NOT NULL,
  `reglement` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `proprietaire`
--

CREATE TABLE `proprietaire` (
  `CodeP` int(5) NOT NULL,
  `CIN` varchar(40) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `nom` varchar(50) DEFAULT NULL,
  `prenom` varchar(50) DEFAULT NULL,
  `tel` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `studio`
--

CREATE TABLE `studio` (
  `CodeS` int(5) NOT NULL,
  `nbrP` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `CodeU` int(5) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `pass` varchar(40) DEFAULT NULL,
  `type` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `utilisateur`
--

INSERT INTO `utilisateur` (`CodeU`, `username`, `email`, `pass`, `type`) VALUES
(1, 'admin', 'admin@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997', 'admin');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`CodeAd`);

--
-- Index pour la table `appartement`
--
ALTER TABLE `appartement`
  ADD PRIMARY KEY (`Codeapp`);

--
-- Index pour la table `eqlo`
--
ALTER TABLE `eqlo`
  ADD PRIMARY KEY (`CodeE`,`CodeL`),
  ADD KEY `eqlo_ibfk_1` (`CodeL`);

--
-- Index pour la table `equipement`
--
ALTER TABLE `equipement`
  ADD PRIMARY KEY (`CodeE`);

--
-- Index pour la table `files`
--
ALTER TABLE `files`
  ADD KEY `fileLog` (`CodeL`);

--
-- Index pour la table `image`
--
ALTER TABLE `image`
  ADD KEY `image_ibfk_1` (`CodeL`);

--
-- Index pour la table `logement`
--
ALTER TABLE `logement`
  ADD PRIMARY KEY (`CodeL`),
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `ProLog` (`CodeP`);

--
-- Index pour la table `proprietaire`
--
ALTER TABLE `proprietaire`
  ADD PRIMARY KEY (`CodeP`);

--
-- Index pour la table `studio`
--
ALTER TABLE `studio`
  ADD PRIMARY KEY (`CodeS`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`CodeU`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `logement`
--
ALTER TABLE `logement`
  MODIFY `CodeL` int(5) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `CodeU` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FkeyAd` FOREIGN KEY (`CodeAd`) REFERENCES `utilisateur` (`CodeU`);

--
-- Contraintes pour la table `appartement`
--
ALTER TABLE `appartement`
  ADD CONSTRAINT `applog` FOREIGN KEY (`Codeapp`) REFERENCES `logement` (`CodeL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `eqlo`
--
ALTER TABLE `eqlo`
  ADD CONSTRAINT `eqlo_ibfk_2` FOREIGN KEY (`CodeE`) REFERENCES `equipement` (`CodeE`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `fileLog` FOREIGN KEY (`CodeL`) REFERENCES `logement` (`CodeL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `imLog` FOREIGN KEY (`CodeL`) REFERENCES `logement` (`CodeL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `logement`
--
ALTER TABLE `logement`
  ADD CONSTRAINT `ProLog` FOREIGN KEY (`CodeP`) REFERENCES `proprietaire` (`CodeP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `proprietaire`
--
ALTER TABLE `proprietaire`
  ADD CONSTRAINT `FkeyPro` FOREIGN KEY (`CodeP`) REFERENCES `utilisateur` (`CodeU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `studio`
--
ALTER TABLE `studio`
  ADD CONSTRAINT `Stlog` FOREIGN KEY (`CodeS`) REFERENCES `logement` (`CodeL`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
