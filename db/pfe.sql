-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2020 at 03:47 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pfe`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `CodeAd` int(5) NOT NULL,
  `CIN` varchar(40) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`CodeAd`, `CIN`) VALUES
(1, 'ABC1526');

-- --------------------------------------------------------

--
-- Table structure for table `appartement`
--

CREATE TABLE `appartement` (
  `Codeapp` int(5) NOT NULL,
  `nbrC` int(1) DEFAULT NULL,
  `nbrP` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `eqlo`
--

CREATE TABLE `eqlo` (
  `CodeE` varchar(5) NOT NULL,
  `CodeL` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `equipement`
--

CREATE TABLE `equipement` (
  `CodeE` varchar(5) NOT NULL,
  `nom` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `equipement`
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
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `CodeF` int(11) NOT NULL,
  `CodeL` int(5) NOT NULL,
  `file` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `image`
--

CREATE TABLE `image` (
  `CodeImg` int(11) NOT NULL,
  `CodeL` int(5) DEFAULT NULL,
  `image` mediumblob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `logement`
--

CREATE TABLE `logement` (
  `CodeL` int(5) NOT NULL,
  `CodeP` int(5) NOT NULL,
  `nom` varchar(100) DEFAULT NULL,
  `adress` varchar(255) DEFAULT NULL,
  `description` varchar(3000) NOT NULL,
  `reglement` varchar(255) NOT NULL,
  `prix` double NOT NULL,
  `superficie` int(11) NOT NULL,
  `SL_adr_nom` varchar(255) NOT NULL,
  `type` varchar(11) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `idMsg` int(11) NOT NULL,
  `Codesender` int(5) NOT NULL,
  `Codereciever` int(5) NOT NULL,
  `Msg` varchar(500) NOT NULL,
  `vue` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `proprietaire`
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
-- Table structure for table `studio`
--

CREATE TABLE `studio` (
  `CodeS` int(5) NOT NULL,
  `nbrP` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `CodeU` int(5) NOT NULL,
  `username` varchar(40) DEFAULT NULL,
  `email` varchar(90) DEFAULT NULL,
  `pass` varchar(40) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `Code_confirmation` varchar(40) DEFAULT NULL,
  `imageP` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `utilisateur`
--

INSERT INTO `utilisateur` (`CodeU`, `username`, `email`, `pass`, `type`, `Code_confirmation`, `imageP`) VALUES
(1, 'aymankd', 'aymankaddioui@gmail.com', 'c72fa1f6102b6993b9c2ac7acafd5702a5b66870', 'admin', NULL, '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`CodeAd`);

--
-- Indexes for table `appartement`
--
ALTER TABLE `appartement`
  ADD PRIMARY KEY (`Codeapp`);

--
-- Indexes for table `eqlo`
--
ALTER TABLE `eqlo`
  ADD PRIMARY KEY (`CodeE`,`CodeL`),
  ADD KEY `eqlo_ibfk_1` (`CodeL`);

--
-- Indexes for table `equipement`
--
ALTER TABLE `equipement`
  ADD PRIMARY KEY (`CodeE`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`CodeF`),
  ADD KEY `fileLog` (`CodeL`);

--
-- Indexes for table `image`
--
ALTER TABLE `image`
  ADD PRIMARY KEY (`CodeImg`),
  ADD KEY `image_ibfk_1` (`CodeL`);

--
-- Indexes for table `logement`
--
ALTER TABLE `logement`
  ADD PRIMARY KEY (`CodeL`),
  ADD UNIQUE KEY `nom` (`nom`),
  ADD KEY `ProLog` (`CodeP`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`idMsg`),
  ADD KEY `msgrecie` (`Codereciever`),
  ADD KEY `msgsend` (`Codesender`);

--
-- Indexes for table `proprietaire`
--
ALTER TABLE `proprietaire`
  ADD PRIMARY KEY (`CodeP`);

--
-- Indexes for table `studio`
--
ALTER TABLE `studio`
  ADD PRIMARY KEY (`CodeS`);

--
-- Indexes for table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`CodeU`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `CodeF` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `image`
--
ALTER TABLE `image`
  MODIFY `CodeImg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `logement`
--
ALTER TABLE `logement`
  MODIFY `CodeL` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `idMsg` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `CodeU` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `FkeyAd` FOREIGN KEY (`CodeAd`) REFERENCES `utilisateur` (`CodeU`);

--
-- Constraints for table `appartement`
--
ALTER TABLE `appartement`
  ADD CONSTRAINT `applog` FOREIGN KEY (`Codeapp`) REFERENCES `logement` (`CodeL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `eqlo`
--
ALTER TABLE `eqlo`
  ADD CONSTRAINT `eqlo_ibfk_2` FOREIGN KEY (`CodeE`) REFERENCES `equipement` (`CodeE`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eqlo_logem_3` FOREIGN KEY (`CodeL`) REFERENCES `logement` (`CodeL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `files`
--
ALTER TABLE `files`
  ADD CONSTRAINT `fileLog` FOREIGN KEY (`CodeL`) REFERENCES `logement` (`CodeL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `image`
--
ALTER TABLE `image`
  ADD CONSTRAINT `imLog` FOREIGN KEY (`CodeL`) REFERENCES `logement` (`CodeL`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `logement`
--
ALTER TABLE `logement`
  ADD CONSTRAINT `ProLog` FOREIGN KEY (`CodeP`) REFERENCES `proprietaire` (`CodeP`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `msgrecie` FOREIGN KEY (`Codereciever`) REFERENCES `utilisateur` (`CodeU`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `msgsend` FOREIGN KEY (`Codesender`) REFERENCES `utilisateur` (`CodeU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `proprietaire`
--
ALTER TABLE `proprietaire`
  ADD CONSTRAINT `FkeyPro` FOREIGN KEY (`CodeP`) REFERENCES `utilisateur` (`CodeU`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `studio`
--
ALTER TABLE `studio`
  ADD CONSTRAINT `Stlog` FOREIGN KEY (`CodeS`) REFERENCES `logement` (`CodeL`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
