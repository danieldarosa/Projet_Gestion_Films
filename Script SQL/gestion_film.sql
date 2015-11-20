-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 20 Novembre 2015 à 11:15
-- Version du serveur :  5.6.15-log
-- Version de PHP :  5.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `gestion_film`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `idCategorie` int(11) NOT NULL AUTO_INCREMENT,
  `nomCategorie` varchar(50) NOT NULL,
  PRIMARY KEY (`idCategorie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`idCategorie`, `nomCategorie`) VALUES
(1, 'Musique'),
(2, 'Jeux vidéos'),
(3, 'Cinématographie'),
(4, 'Développement');

-- --------------------------------------------------------

--
-- Structure de la table `commentaires`
--

CREATE TABLE IF NOT EXISTS `commentaires` (
  `idCommentaire` int(11) NOT NULL AUTO_INCREMENT,
  `message` varchar(255) NOT NULL,
  `dateMessage` date NOT NULL,
  `idVideo` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idCommentaire`),
  KEY `idVideo` (`idVideo`,`idUser`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `commentaires`
--

INSERT INTO `commentaires` (`idCommentaire`, `message`, `dateMessage`, `idVideo`, `idUser`) VALUES
(1, 'Excellent, LOL !', '2015-11-20', 5, 3),
(2, 'YUUUUUUUUUUUKI <3', '2015-11-20', 18, 3),
(3, 'slurp !', '2015-11-20', 18, 5);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `idUser` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(50) NOT NULL,
  `prenom` varchar(50) NOT NULL,
  `pseudo` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `dateNaissance` date NOT NULL,
  `admin` int(11) NOT NULL,
  PRIMARY KEY (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idUser`, `nom`, `prenom`, `pseudo`, `email`, `password`, `dateNaissance`, `admin`) VALUES
(3, 'DA ROSA', 'Daniel', 'ErzaTheTitania91', 'daniel.darosa97@gmail.com', 'd40dde993c639bb6f07a7b1cc9f88a2cb12f0c45', '2015-09-02', 1),
(4, 'test', 'test', 'test', 'test.test@test.com', '859ec9e23a09ce6fe7f3fcc5fdaa4e2fce1f23c4', '2015-01-06', 0),
(5, 'nyan', 'nyan', 'nyan', 'nyan.nyan@nyan.com', 'ad65d9c63c2db59493f3ed8712eb40a3ea055190', '2015-11-09', 0);

-- --------------------------------------------------------

--
-- Structure de la table `videos`
--

CREATE TABLE IF NOT EXISTS `videos` (
  `idVideo` int(11) NOT NULL AUTO_INCREMENT,
  `nomVideo` varchar(50) NOT NULL,
  `lienVideo` varchar(50) NOT NULL,
  `descVideo` varchar(255) NOT NULL,
  `dateAjout` date NOT NULL,
  `idCategorie` int(11) NOT NULL,
  `idUser` int(11) NOT NULL,
  PRIMARY KEY (`idVideo`),
  KEY `idCategorie` (`idCategorie`,`idUser`),
  KEY `idUser` (`idUser`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=21 ;

--
-- Contenu de la table `videos`
--

INSERT INTO `videos` (`idVideo`, `nomVideo`, `lienVideo`, `descVideo`, `dateAjout`, `idCategorie`, `idUser`) VALUES
(5, 'TAS - GBA Metroid Fusion', '8EOBTd99nnY', 'TAS de Metroid Fusion par BioSpark en 0:55 (In game time)\r\nwww.tasvideos.org', '2015-10-30', 2, 3),
(6, 'ALLAHU AKBAR', 'XSdzWEImjY4', '/pol', '2015-10-30', 3, 3),
(7, 'Scandal - Awanaitsumorino, Genkidene', '_EDvabyo620', 'Fuck yeah !', '2015-11-06', 1, 5),
(16, 'Scandal - Kagen No Tsuki', 'fFyUvfD-ZWU', 'sdsdfsdfsdf', '2015-11-13', 1, 4),
(18, 'Yuki Yuki Yuki <3', 'NI_fgwbmJg0', 'gdfgdfgdfgf', '2015-11-13', 1, 3),
(20, 'FranÃ§ois Hollande VS Kaamelott', 'seWlCQGzc7E', 'Lol', '2015-11-20', 3, 5);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_1` FOREIGN KEY (`idVideo`) REFERENCES `videos` (`idVideo`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Contraintes pour la table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categories` (`idCategorie`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `videos_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
