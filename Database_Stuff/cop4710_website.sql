-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 12, 2019 at 05:45 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cop4710 website`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `UserID` int(11) NOT NULL,
  `RSO_ID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`RSO_ID`),
  KEY `RSO_ID` (`RSO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `commented`
--

DROP TABLE IF EXISTS `commented`;
CREATE TABLE IF NOT EXISTS `commented` (
  `UserID` int(11) NOT NULL,
  `EventID` int(11) NOT NULL,
  `Rating` double NOT NULL,
  `Text` text,
  `TimePrint` time DEFAULT NULL,
  `DayOfPost` date DEFAULT NULL,
  PRIMARY KEY (`UserID`,`EventID`),
  KEY `EventID` (`EventID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `eventpics`
-- While it exists, nothing has been implemented to use this

DROP TABLE IF EXISTS `eventpics`;
CREATE TABLE IF NOT EXISTS `eventpics` (
  `PicID` int(11) NOT NULL AUTO_INCREMENT,
  `Dir` char(255) NOT NULL,
  `EventID` int(11) NOT NULL,
  PRIMARY KEY (`PicID`,`EventID`),
  KEY `EventID` (`EventID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

DROP TABLE IF EXISTS `events`;
CREATE TABLE IF NOT EXISTS `events` (
  `EventID` int(11) NOT NULL AUTO_INCREMENT,
  `EventName` char(127) NOT NULL,
  `Start_Time` datetime DEFAULT NULL,
  `EventPic` char(255) DEFAULT '../Sources/Images/running-man_318-1564.jpg',
  `MainLocationID` int(11) NOT NULL DEFAULT '1',
  `EventDesc` text,
  `InviteType` int(11) NOT NULL DEFAULT '2',
  `HostingUserID` int(11) NOT NULL,
  `Host_RSO_ID` int(11) DEFAULT NULL,
  `SchoolID` int(11) NOT NULL,
  `approved` bit(1) NOT NULL DEFAULT b'0',
  `rating` double(10,2) DEFAULT NULL,
  PRIMARY KEY (`EventID`),
  UNIQUE KEY `no double events` (`EventName`,`Host_RSO_ID`,`SchoolID`),
  UNIQUE KEY `One Event per Location` (`EventID`,`Start_Time`),
  KEY `MainLocationID` (`MainLocationID`),
  KEY `Host_RSO_ID` (`Host_RSO_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `eventtype`
-- While it exists, nothing has been implemented to use this

DROP TABLE IF EXISTS `eventtype`;
CREATE TABLE IF NOT EXISTS `eventtype` (
  `EventID` int(11) NOT NULL,
  `TypeID` int(11) NOT NULL,
  PRIMARY KEY (`EventID`,`TypeID`),
  KEY `TypeID` (`TypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `locID` int(11) NOT NULL AUTO_INCREMENT,
  `longitude` double NOT NULL,
  `latitude` double NOT NULL,
  `Building` text,
  `floorNum` int(11) DEFAULT NULL,
  `Room` text,
  PRIMARY KEY (`locID`),
  UNIQUE KEY `No double locations` (`longitude`,`latitude`,`Building`(123),`floorNum`,`Room`(123)) USING BTREE
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
CREATE TABLE IF NOT EXISTS `members` (
  `UserID` int(11) NOT NULL,
  `RSO_ID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`RSO_ID`),
  KEY `RSO_ID` (`RSO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rso`
--

DROP TABLE IF EXISTS `rso`;
CREATE TABLE IF NOT EXISTS `rso` (
  `RSO_ID` int(11) NOT NULL AUTO_INCREMENT,
  `RSO_Name` char(255) NOT NULL,
  `RSO_CreationDate` date DEFAULT NULL,
  `NumofMembers` int(11) NOT NULL,
  `RSO_Desc` text,
  `RSO_ProfPic` char(255) NOT NULL DEFAULT '..\\Sources\\Images\\running-man_318-1564.jpg',
  `SchoolID` int(11) NOT NULL,
  PRIMARY KEY (`RSO_ID`),
  UNIQUE KEY `RSO_Name` (`RSO_Name`),
  UNIQUE KEY `RSO_Name_2` (`RSO_Name`,`SchoolID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `rso_pics`
--

DROP TABLE IF EXISTS `rso_pics`;
CREATE TABLE IF NOT EXISTS `rso_pics` (
  `PicID` int(11) NOT NULL AUTO_INCREMENT,
  `Dir` char(255) NOT NULL,
  `RSO_ID` int(11) NOT NULL,
  PRIMARY KEY (`PicID`,`RSO_ID`),
  KEY `RSO_ID` (`RSO_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
CREATE TABLE IF NOT EXISTS `school` (
  `SchoolID` int(11) NOT NULL AUTO_INCREMENT,
  `SchoolName` char(255) NOT NULL,
  `SchoolPic` char(255) NOT NULL,
  `SchoolDesc` text,
  `NumOfStudents` int(11) NOT NULL,
  `NumOfRSOs` int(11) NOT NULL,
  `School_Lat` double NOT NULL,
  `School_long` double NOT NULL,
  `SchoolExt` tinytext NOT NULL,
  PRIMARY KEY (`SchoolID`),
  UNIQUE KEY `SchoolID` (`SchoolID`),
  UNIQUE KEY `emailExt` (`SchoolPic`),
  UNIQUE KEY `one coord` (`School_Lat`,`School_long`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `schoolpictures`
-- While it exists, nothing has been implemented to use this

DROP TABLE IF EXISTS `schoolpictures`;
CREATE TABLE IF NOT EXISTS `schoolpictures` (
  `PicID` int(11) NOT NULL AUTO_INCREMENT,
  `Dir` char(255) NOT NULL,
  `SchoolID` int(11) NOT NULL,
  PRIMARY KEY (`PicID`,`SchoolID`),
  KEY `SchoolID` (`SchoolID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `UserID` int(11) NOT NULL,
  `SchoolID` int(11) NOT NULL,
  PRIMARY KEY (`SchoolID`,`UserID`),
  KEY `UserID` (`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `super_admins`
--

DROP TABLE IF EXISTS `super_admins`;
CREATE TABLE IF NOT EXISTS `super_admins` (
  `UserID` int(11) NOT NULL,
  `SchoolID` int(11) NOT NULL,
  PRIMARY KEY (`SchoolID`,`UserID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `types`
-- While it exists, nothing has been implemented to use this

DROP TABLE IF EXISTS `types`;
CREATE TABLE IF NOT EXISTS `types` (
  `TypeID` int(11) NOT NULL AUTO_INCREMENT,
  `TypeName` char(31) DEFAULT NULL,
  PRIMARY KEY (`TypeID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Username` char(63) NOT NULL,
  `Pasword` char(255) NOT NULL,
  `ProfilePic` char(255) DEFAULT '../Sources/Images/running-man_318-1564.jpg',
  `Email` char(127) NOT NULL,
  `Bio` text,
  `SchoolID` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  UNIQUE KEY `Email` (`Email`) USING BTREE,
  KEY `SchoolID` (`SchoolID`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
