-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: gabrielle12_booksite
-- ------------------------------------------------------
-- Server version 	8.0.34-0ubuntu0.20.04.1
-- Date: Sat, 02 Sep 2023 10:23:12 +0000

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40101 SET @OLD_AUTOCOMMIT=@@AUTOCOMMIT */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Authors`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Authors` (
  `AuthorID` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `Fname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Lname` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`AuthorID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Authors`
--

LOCK TABLES `Authors` WRITE;
/*!40000 ALTER TABLE `Authors` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `Authors` VALUES (1,'Louisa May','Alcott'),(2,'Stephen','King'),(3,'Stephenie','Meyer'),(4,'George','Orowell'),(5,'Sally','Rooney'),(6,'Gillian','Flynn');
/*!40000 ALTER TABLE `Authors` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `Authors` with 6 row(s)
--

--
-- Table structure for table `Books`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Books` (
  `BookID` int unsigned NOT NULL AUTO_INCREMENT,
  `AuthorID` mediumint unsigned NOT NULL,
  `PubID` mediumint unsigned NOT NULL,
  `Title` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PubYr` smallint unsigned NOT NULL,
  `Cover` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`BookID`),
  KEY `AuthorID_2` (`AuthorID`),
  KEY `PubID_2` (`PubID`),
  CONSTRAINT `Books_ibfk_1` FOREIGN KEY (`AuthorID`) REFERENCES `Authors` (`AuthorID`),
  CONSTRAINT `Books_ibfk_2` FOREIGN KEY (`PubID`) REFERENCES `Publishers` (`PubID`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Books`
--

LOCK TABLES `Books` WRITE;
/*!40000 ALTER TABLE `Books` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `Books` VALUES (1,1,1,'Little Women',1868,'littlewomen.jpg'),(2,2,2,'IT',1986,'it.jpg'),(3,3,3,'Twilight',2008,'twilight.jpg'),(4,4,4,'1984',1949,'1984.jpg'),(5,5,5,'Normal People',2018,'normalpeople.jpg'),(6,5,5,'Conversations with Friends',2017,'conversationswfriends.jpg'),(7,2,2,'Misery',1987,'misery.jpg'),(8,6,6,'Gone Girl',2012,'gonegirl.jpg');
/*!40000 ALTER TABLE `Books` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `Books` with 8 row(s)
--

--
-- Table structure for table `Favourites`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Favourites` (
  `FavID` int unsigned NOT NULL AUTO_INCREMENT,
  `UserID` int unsigned NOT NULL,
  `BookID` int unsigned NOT NULL,
  PRIMARY KEY (`FavID`),
  KEY `BookID` (`BookID`),
  KEY `UserID` (`UserID`),
  KEY `UserID_2` (`UserID`),
  KEY `BookID_2` (`BookID`),
  CONSTRAINT `Favourites_ibfk_1` FOREIGN KEY (`BookID`) REFERENCES `Books` (`BookID`),
  CONSTRAINT `Favourites_ibfk_2` FOREIGN KEY (`UserID`) REFERENCES `Users` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Favourites`
--

LOCK TABLES `Favourites` WRITE;
/*!40000 ALTER TABLE `Favourites` DISABLE KEYS */;
SET autocommit=0;
/*!40000 ALTER TABLE `Favourites` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `Favourites` with 0 row(s)
--

--
-- Table structure for table `Publishers`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Publishers` (
  `PubID` mediumint unsigned NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`PubID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Publishers`
--

LOCK TABLES `Publishers` WRITE;
/*!40000 ALTER TABLE `Publishers` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `Publishers` VALUES (1,'Puffin Books'),(2,'Simon & Schuster'),(3,'Little, Brown & Company'),(4,'Signet Classic'),(5,'Penguin Random House'),(6,'Crown Publishing Group');
/*!40000 ALTER TABLE `Publishers` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `Publishers` with 6 row(s)
--

--
-- Table structure for table `Users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Users` (
  `UserID` int unsigned NOT NULL AUTO_INCREMENT,
  `Username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(72) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Users`
--

LOCK TABLES `Users` WRITE;
/*!40000 ALTER TABLE `Users` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `Users` VALUES (1,'Gabrielle','$2y$10$EYZMXafM3OtLbDhxJingFuzmO39dMl4G/0G2rPV6l2sOySAjapnMW'),(2,'Arlene','/$%!');
/*!40000 ALTER TABLE `Users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `Users` with 2 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET AUTOCOMMIT=@OLD_AUTOCOMMIT */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Sat, 02 Sep 2023 10:23:12 +0000
