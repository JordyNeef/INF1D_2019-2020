-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2019 at 12:13 PM
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
  `categorieid` int(11) NOT NULL,
  `naam` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `gebruiker`
--

CREATE TABLE `gebruiker` (
  `gebruikerid` int(11) NOT NULL,
  `gebruikersnaam` varchar(30) NOT NULL,
  `wachtwoord` varchar(30) NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `proefversie` tinyint(1) NOT NULL,
  `userimagepath` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `kijksessie`
--

CREATE TABLE `kijksessie` (
  `gebruikerid` int(7) NOT NULL,
  `videoid` int(7) NOT NULL,
  `tijdstip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rating`
--

CREATE TABLE `rating` (
  `ratingid` int(11) NOT NULL,
  `gebruikerid` int(7) NOT NULL,
  `videoid` int(7) NOT NULL,
  `beoordeling` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `video`
--

CREATE TABLE `video` (
  `videoid` int(11) NOT NULL,
  `playbackid` varchar(30) NOT NULL,
  `titel` varchar(30) NOT NULL,
  `Beschrijving` varchar(500) NOT NULL,
  `UploadedBy` varchar(30) NOT NULL,
  `videocatid` int(7) NOT NULL,
  `Leeftijd` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `video_categorie`
--

CREATE TABLE `video_categorie` (
  `videocatid` int(11) NOT NULL,
  `categorieid` int(7) NOT NULL,
  `videoid` int(7) NOT NULL
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
  ADD PRIMARY KEY (`gebruikerid`,`videoid`),
  ADD KEY `videoid` (`videoid`);

--
-- Indexes for table `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`ratingid`),
  ADD KEY `gebruikerid` (`gebruikerid`),
  ADD KEY `videoid` (`videoid`);

--
-- Indexes for table `video`
--
ALTER TABLE `video`
  ADD PRIMARY KEY (`videoid`),
  ADD KEY `videocatid` (`videocatid`);

--
-- Indexes for table `video_categorie`
--
ALTER TABLE `video_categorie`
  ADD PRIMARY KEY (`videocatid`),
  ADD KEY `categorieid` (`categorieid`),
  ADD KEY `videoid` (`videoid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorieid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `gebruikerid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `ratingid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `videoid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video_categorie`
--
ALTER TABLE `video_categorie`
  MODIFY `videocatid` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kijksessie`
--
ALTER TABLE `kijksessie`
  ADD CONSTRAINT `kijksessie_ibfk_1` FOREIGN KEY (`gebruikerid`) REFERENCES `gebruiker` (`gebruikerid`),
  ADD CONSTRAINT `kijksessie_ibfk_2` FOREIGN KEY (`videoid`) REFERENCES `video` (`videoid`);

--
-- Constraints for table `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `rating_ibfk_1` FOREIGN KEY (`gebruikerid`) REFERENCES `gebruiker` (`gebruikerid`),
  ADD CONSTRAINT `rating_ibfk_2` FOREIGN KEY (`videoid`) REFERENCES `video` (`videoid`);

--
-- Constraints for table `video`
--
ALTER TABLE `video`
  ADD CONSTRAINT `video_ibfk_1` FOREIGN KEY (`videocatid`) REFERENCES `video_categorie` (`videocatid`);

--
-- Constraints for table `video_categorie`
--
ALTER TABLE `video_categorie`
  ADD CONSTRAINT `video_categorie_ibfk_1` FOREIGN KEY (`categorieid`) REFERENCES `categorie` (`categorieid`),
  ADD CONSTRAINT `video_categorie_ibfk_2` FOREIGN KEY (`videoid`) REFERENCES `video` (`videoid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
