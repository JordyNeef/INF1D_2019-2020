-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2020 at 12:48 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `niffoflix`
--

-- --------------------------------------------------------

--
-- Table structure for table `categorie`
--

CREATE TABLE `categorie` (
  `categorieid` int(7) NOT NULL,
  `naam` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gebruiker`
--

CREATE TABLE `gebruiker` (
  `gebruikerid` int(10) NOT NULL,
  `gebruikersnaam` varchar(30) NOT NULL,
  `wachtwoord` varchar(75) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `proefversie` tinyint(1) NOT NULL,
  `userimagepath` varchar(255) DEFAULT NULL,
  `mail` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gebruiker`
--

INSERT INTO `gebruiker` (`gebruikerid`, `gebruikersnaam`, `wachtwoord`, `admin`, `proefversie`, `userimagepath`, `mail`) VALUES
(1, 'jordy', '$2y$10$/UCWjkpqOV6r4oST5NvwCecExF09f0dDlnH8MMq2xEJFFisFsDBx2', 1, 0, NULL, 'jordy@mail.nl');

-- --------------------------------------------------------

--
-- Table structure for table `kijksessie`
--

CREATE TABLE `kijksessie` (
  `gebruikerid` int(10) NOT NULL,
  `videoid` int(7) NOT NULL,
  `tijdstip` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `ratingid` int(7) NOT NULL,
  `gebruikerid` int(10) DEFAULT NULL,
  `videoid` int(7) DEFAULT NULL,
  `beoordeling` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `playbackid` varchar(30) DEFAULT NULL,
  `titel` varchar(30) DEFAULT NULL,
  `beschrijving` varchar(500) DEFAULT NULL,
  `uploadedby` int(10) DEFAULT NULL,
  `leeftijd` int(2) DEFAULT NULL,
  `videoid` int(7) NOT NULL,
  `categorieid` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`categorieid`);

--
-- Indexes for table `gebruiker`
--
ALTER TABLE `gebruiker`
  ADD PRIMARY KEY (`gebruikerid`);

--
-- Indexes for table `kijksessie`
--
ALTER TABLE `kijksessie`
  ADD PRIMARY KEY (`videoid`,`gebruikerid`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ratingid`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`videoid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorieid` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `gebruikerid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
