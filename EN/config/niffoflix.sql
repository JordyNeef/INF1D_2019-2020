-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 27, 2020 at 03:28 PM
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
  `naam` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categorie`
--

INSERT INTO `categorie` (`categorieid`, `naam`) VALUES
(1, 'Action'),
(2, 'Horror'),
(3, 'Comedy'),
(4, 'Basketball'),
(5, 'Mavs'),
(6, 'Jazz'),
(7, 'NBA'),
(8, 'Rudy'),
(9, 'Shaqtin');

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
(1, 'jordy', '$2y$10$/UCWjkpqOV6r4oST5NvwCecExF09f0dDlnH8MMq2xEJFFisFsDBx2', 1, 0, 'steam-avatar-profile-picture-0455.png', 'jordy@mail.nl'),
(2, 'test01', '$2y$10$g.AH5awbK6uRHNuphDnfDuku1oHesZM666.X1pq/51Adn.BeRTwUy', 1, 0, 'steam-avatar-profile-picture-mr duck.jpg', 'test01@mail.nl');

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
  `videoid` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video`
--

INSERT INTO `video` (`playbackid`, `titel`, `beschrijving`, `uploadedby`, `leeftijd`, `videoid`) VALUES
('1CYqhg7Lrlw', 'NBA &#34;You Reach I Teach&#34', 'DISCLAIMER : All clips are property of the NBA. No copyright infringement is intended, all videos are edited to follow the &#34;Free Use&#34; guideline of YouTube.)', 1, 3, 1),
('yZ4IxuOtxJU', 'NBA &#34;ARE YOU BLIND?!&#34; ', 'These Referees and Players were blind for the moments.&#13;&#10;DISCLAIMER: All clips are property of the NBA. No copyright infringement is intended, all videos are edited to follow the &#34;Free Use&#34; guideline of YouTube. &#13;&#10;', 1, 3, 2),
('6MN6Z0XBqLA', 'It&#39;s A Shaqtin Showdown! |', 'Bricks, too many players on the court and more highlight this week&#39;s Shaqtin!', 1, 3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `video_categorie`
--

CREATE TABLE `video_categorie` (
  `vidcatid` int(7) NOT NULL,
  `videoid` int(7) NOT NULL,
  `categorieid` int(7) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `video_categorie`
--

INSERT INTO `video_categorie` (`vidcatid`, `videoid`, `categorieid`) VALUES
(1, 1, 4),
(2, 1, 7),
(3, 2, 4),
(4, 2, 7),
(5, 3, 0),
(6, 3, 7),
(7, 3, 4);

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
-- Indexes for table `video_categorie`
--
ALTER TABLE `video_categorie`
  ADD PRIMARY KEY (`vidcatid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `categorieid` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `gebruiker`
--
ALTER TABLE `gebruiker`
  MODIFY `gebruikerid` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `rating`
--
ALTER TABLE `rating`
  MODIFY `ratingid` int(7) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `video`
--
ALTER TABLE `video`
  MODIFY `videoid` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `video_categorie`
--
ALTER TABLE `video_categorie`
  MODIFY `vidcatid` int(7) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
