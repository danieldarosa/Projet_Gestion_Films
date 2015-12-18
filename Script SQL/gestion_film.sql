-- phpMyAdmin SQL Dump
-- version 4.1.4
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Ven 18 Décembre 2015 à 07:41
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `commentaires`
--

INSERT INTO `commentaires` (`idCommentaire`, `message`, `dateMessage`, `idVideo`, `idUser`) VALUES
(1, 'GÃ©nial !', '2015-12-11', 1, 6),
(2, 'Merci ! :)', '2015-12-11', 1, 4);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`idUser`, `nom`, `prenom`, `pseudo`, `email`, `password`, `dateNaissance`, `admin`) VALUES
(4, 'test', 'test', 'test', 'test.test@test.com', '859ec9e23a09ce6fe7f3fcc5fdaa4e2fce1f23c4', '2015-01-06', 1),
(6, 'Nouveau', 'Test', 'Test2', 'tests.tests@tests.com', 'b3191b81658da1aba7392dcec0cfa931cd1f1385', '2015-12-11', 0),
(8, 'Film', 'Support', 'SupportSite', 'film.support@gmail.com', '4ffa7a3a97c777008d2fef4ec9b9dec4556c7512', '2015-12-11', 1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `videos`
--

INSERT INTO `videos` (`idVideo`, `nomVideo`, `lienVideo`, `descVideo`, `dateAjout`, `idCategorie`, `idUser`) VALUES
(1, 'Let''s play Minecraft [PS3]', 'a05niKAXmX8', 'Premier let''s play de Minecraft sur PS3 !', '2015-12-11', 2, 4),
(2, 'Bande annonce Star Wars : Seul sur Mars', 'sjhEtg3VApY', 'Voici la bande annonce de Star Wars : Seul sur Mars !', '2015-12-11', 3, 6);

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `commentaires`
--
ALTER TABLE `commentaires`
  ADD CONSTRAINT `commentaires_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `commentaires_ibfk_3` FOREIGN KEY (`idVideo`) REFERENCES `videos` (`idVideo`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Contraintes pour la table `videos`
--
ALTER TABLE `videos`
  ADD CONSTRAINT `videos_ibfk_1` FOREIGN KEY (`idCategorie`) REFERENCES `categories` (`idCategorie`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `videos_ibfk_2` FOREIGN KEY (`idUser`) REFERENCES `users` (`idUser`) ON DELETE NO ACTION ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
