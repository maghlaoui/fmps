-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 18, 2013 at 04:23 AM
-- Server version: 5.5.25
-- PHP Version: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `fmps`
--

-- --------------------------------------------------------

--
-- Table structure for table `situation_caisse`
--

CREATE TABLE IF NOT EXISTS `situation_caisse` (
  `id` int(11) NOT NULL,
  `ecole_id` int(11) NOT NULL,
  `mois` varchar(125) NOT NULL,
  `annee` year(4) NOT NULL,
  `solde_initiale` float DEFAULT NULL,
  `total_alimentation` float DEFAULT NULL,
  `total_achat` float DEFAULT NULL,
  `solde_finale` float DEFAULT NULL,
  `cloture` tinyint(1) DEFAULT '0',
  `fichier` varchar(125) NOT NULL,
  `path` varchar(125) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
