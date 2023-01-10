CREATE DATABASE  IF NOT EXISTS `photos` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `photos`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 10.35.80.181    Database: photos
-- ------------------------------------------------------
-- Server version	5.5.68-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `bad_links`
--

DROP TABLE IF EXISTS `bad_links`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bad_links` (
  `a` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_archive`
--

DROP TABLE IF EXISTS `dcr_archive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `place` text NOT NULL,
  `object_file_name` text NOT NULL,
  `title_` text NOT NULL,
  `creator` text NOT NULL,
  `contributor` text NOT NULL,
  `date` text NOT NULL,
  `period` varchar(255) NOT NULL,
  `subjects` text,
  `index_terms` text NOT NULL,
  `clemson` char(1) NOT NULL,
  `description` text NOT NULL,
  `physical_characteristics` text NOT NULL,
  `local_call_no` text NOT NULL,
  `metadata_creator` text NOT NULL,
  `digital_creation_date` text NOT NULL,
  `digital_creator` text NOT NULL,
  `general_comments_by_dpr_team` text NOT NULL,
  `program_manager_comment` text NOT NULL,
  `dcr_sent` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13127 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_archive_defaults`
--

DROP TABLE IF EXISTS `dcr_archive_defaults`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_archive_defaults` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dcr_field` varchar(48) NOT NULL,
  `dcr_item` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_archive_images`
--

DROP TABLE IF EXISTS `dcr_archive_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_archive_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `archive_id` int(11) NOT NULL,
  `link` varchar(88) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `archive_id` (`archive_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15964 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_archive_notes`
--

DROP TABLE IF EXISTS `dcr_archive_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_archive_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_file_name` text NOT NULL,
  `title_` text NOT NULL,
  `creator` text NOT NULL,
  `contributor` text NOT NULL,
  `date` text NOT NULL,
  `period` text NOT NULL,
  `subjects` text NOT NULL,
  `index_terms` text NOT NULL,
  `place` text NOT NULL,
  `clemson` text NOT NULL,
  `description` text NOT NULL,
  `physical_characteristics` text NOT NULL,
  `local_call_no` text NOT NULL,
  `metadata_creator` text NOT NULL,
  `digital_creation_date` text NOT NULL,
  `digital_creator` text NOT NULL,
  `general_comments_by_dpr_team` text NOT NULL,
  `program_manager_comment` text NOT NULL,
  `dcr_sent` varchar(8) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_archive_original`
--

DROP TABLE IF EXISTS `dcr_archive_original`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_archive_original` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_file_name` text NOT NULL,
  `title_` text NOT NULL,
  `creator` text NOT NULL,
  `contributor` text NOT NULL,
  `date` text NOT NULL,
  `period` varchar(255) NOT NULL,
  `subjects` text,
  `index_terms` text NOT NULL,
  `place` text NOT NULL,
  `clemson` char(1) NOT NULL,
  `description` text NOT NULL,
  `physical_characteristics` text NOT NULL,
  `local_call_no` text NOT NULL,
  `metadata_creator` text NOT NULL,
  `digital_creation_date` text NOT NULL,
  `digital_creator` text NOT NULL,
  `general_comments_by_dpr_team` text NOT NULL,
  `program_manager_comment` text NOT NULL,
  `dcr_sent` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=295 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_characteristics`
--

DROP TABLE IF EXISTS `dcr_characteristics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_characteristics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `characteristic` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_creators`
--

DROP TABLE IF EXISTS `dcr_creators`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_creators` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `creator` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`creator`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_periods`
--

DROP TABLE IF EXISTS `dcr_periods`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_periods` (
  `period` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `range_start` varchar(4) NOT NULL,
  `range_end` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_subjects`
--

DROP TABLE IF EXISTS `dcr_subjects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_subjects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` varchar(256) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `subject` (`subject`)
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dcr_thumbnails`
--

DROP TABLE IF EXISTS `dcr_thumbnails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dcr_thumbnails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `archive_id` int(11) NOT NULL,
  `link` varchar(88) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `archive_id` (`archive_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5755 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `historical_photos_1`
--

DROP TABLE IF EXISTS `historical_photos_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `historical_photos_1` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_file_name` text NOT NULL,
  `title` text NOT NULL,
  `creator` text NOT NULL,
  `contributor` text NOT NULL,
  `date` text NOT NULL,
  `period` text NOT NULL,
  `subjects` text NOT NULL,
  `index_terms` text NOT NULL,
  `place` text NOT NULL,
  `description` text NOT NULL,
  `physical_characteristics` text NOT NULL,
  `local_call_no` text NOT NULL,
  `metadata_creator` text NOT NULL,
  `didgital_creation_date` text NOT NULL,
  `digital_creator` text NOT NULL,
  `date_sent_to_digital_collections` text NOT NULL,
  `comments_from_dw` text NOT NULL,
  `test` varchar(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `park` varchar(6) DEFAULT NULL,
  `photo` longblob,
  `filename` varchar(50) DEFAULT NULL,
  `filesize` varchar(50) DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `photoname` varchar(255) NOT NULL DEFAULT '',
  `personID` varchar(100) NOT NULL DEFAULT '',
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `majorGroup` varchar(40) NOT NULL DEFAULT '',
  `discus` text NOT NULL,
  `photog` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(10) DEFAULT NULL,
  `comment` text NOT NULL,
  `cd` varchar(50) NOT NULL DEFAULT 'no',
  `dateM` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `height` varchar(5) NOT NULL DEFAULT '',
  `width` varchar(5) NOT NULL DEFAULT '',
  `mark` char(1) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `cat` varchar(100) NOT NULL DEFAULT '',
  `subcat` text NOT NULL,
  `website` char(1) NOT NULL DEFAULT '',
  `sys_plan` char(1) NOT NULL DEFAULT '',
  `fire_gallery` char(1) NOT NULL,
  `public_hide` char(1) NOT NULL,
  `lat` varchar(10) NOT NULL DEFAULT '',
  `lon` varchar(11) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pid`),
  KEY `park` (`park`),
  KEY `sciName` (`sciName`),
  KEY `mark` (`mark`),
  KEY `MG` (`majorGroup`),
  KEY `cat` (`cat`),
  KEY `park_2` (`park`,`sciName`),
  KEY `public_hide` (`public_hide`)
) ENGINE=MyISAM AUTO_INCREMENT=36591 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `images_good`
--

DROP TABLE IF EXISTS `images_good`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images_good` (
  `park` varchar(6) DEFAULT NULL,
  `photo` longblob,
  `filename` varchar(50) DEFAULT NULL,
  `filesize` varchar(50) DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `photoname` varchar(255) NOT NULL DEFAULT '',
  `personID` varchar(100) NOT NULL DEFAULT '',
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `majorGroup` varchar(40) NOT NULL DEFAULT '',
  `discus` text NOT NULL,
  `photog` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(10) DEFAULT NULL,
  `comment` text NOT NULL,
  `cd` varchar(50) NOT NULL DEFAULT 'no',
  `dateM` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `height` varchar(5) NOT NULL DEFAULT '',
  `width` varchar(5) NOT NULL DEFAULT '',
  `mark` char(1) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `cat` varchar(100) NOT NULL DEFAULT '',
  `subcat` text NOT NULL,
  `website` char(1) NOT NULL DEFAULT '',
  `sys_plan` char(1) NOT NULL DEFAULT '',
  `fire_gallery` char(1) NOT NULL,
  `public_hide` char(1) NOT NULL,
  `lat` varchar(10) NOT NULL DEFAULT '',
  `lon` varchar(11) NOT NULL DEFAULT '',
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pid`),
  KEY `park` (`park`),
  KEY `sciName` (`sciName`),
  KEY `mark` (`mark`),
  KEY `MG` (`majorGroup`),
  KEY `cat` (`cat`),
  KEY `park_2` (`park`,`sciName`),
  KEY `public_hide` (`public_hide`)
) ENGINE=MyISAM AUTO_INCREMENT=32786 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `publish_hi-res`
--

DROP TABLE IF EXISTS `publish_hi-res`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `publish_hi-res` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `pid` text NOT NULL,
  `email` tinytext NOT NULL,
  `retrievals` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pid` (`pid`(100),`email`(100))
) ENGINE=MyISAM AUTO_INCREMENT=557 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `signature`
--

DROP TABLE IF EXISTS `signature`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `signature` (
  `fullName` varchar(75) NOT NULL DEFAULT '',
  `filename` varchar(50) DEFAULT NULL,
  `filesize` varchar(50) DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `personID` varchar(100) NOT NULL DEFAULT '',
  `dateM` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `link` varchar(255) NOT NULL DEFAULT '',
  `pid` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pid`),
  UNIQUE KEY `personID` (`personID`),
  KEY `park` (`fullName`)
) ENGINE=MyISAM AUTO_INCREMENT=1208 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `videos`
--

DROP TABLE IF EXISTS `videos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `videos` (
  `park` varchar(6) DEFAULT NULL,
  `photo` longblob,
  `video_name` varchar(255) NOT NULL DEFAULT '',
  `personID` varchar(100) NOT NULL DEFAULT '',
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `majorGroup` varchar(40) NOT NULL DEFAULT '',
  `video_link` varchar(255) DEFAULT NULL,
  `photog` varchar(255) NOT NULL DEFAULT '',
  `date` varchar(10) DEFAULT NULL,
  `comment` text NOT NULL,
  `dateM` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `mark` char(1) NOT NULL DEFAULT '',
  `cat` varchar(100) NOT NULL DEFAULT '',
  `subcat` text NOT NULL,
  `lat` varchar(10) NOT NULL,
  `lon` varchar(11) NOT NULL,
  `pid` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pid`),
  KEY `park` (`park`),
  KEY `sciName` (`sciName`),
  KEY `mark` (`mark`),
  KEY `MG` (`majorGroup`),
  KEY `cat` (`cat`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=latin1 COMMENT='clone of 195 20111106';
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-03 14:54:04
