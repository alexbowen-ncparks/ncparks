CREATE DATABASE  IF NOT EXISTS `nrid` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `nrid`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 10.35.80.181    Database: nrid
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
-- Table structure for table `NHP_moth_temp`
--

DROP TABLE IF EXISTS `NHP_moth_temp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `NHP_moth_temp` (
  `state_stat` varchar(8) NOT NULL,
  `nhp_rank` longtext,
  `moth_site_ranks` varchar(16) DEFAULT NULL,
  `sci_name` varchar(128) NOT NULL,
  `MONA_number` decimal(11,2) NOT NULL,
  PRIMARY KEY (`MONA_number`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `alien`
--

DROP TABLE IF EXISTS `alien`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `alien` (
  `scientific_name` varchar(128) NOT NULL,
  `common_name` text NOT NULL,
  `taxa_group` text NOT NULL,
  `native_habitat` text NOT NULL,
  `nc_status_range` text NOT NULL,
  `nc_status_occurrence` text NOT NULL,
  `nc_list` text NOT NULL,
  `sc` text NOT NULL,
  `va` text NOT NULL,
  `tn` text NOT NULL,
  `ga` text NOT NULL,
  `fed` text NOT NULL,
  `usgs` text NOT NULL,
  KEY `scientific_name` (`scientific_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `batch_dprspp`
--

DROP TABLE IF EXISTS `batch_dprspp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `batch_dprspp` (
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `family` varchar(50) NOT NULL DEFAULT '',
  `subfamily` varchar(50) NOT NULL DEFAULT '',
  `majorGroup` varchar(50) NOT NULL DEFAULT '',
  `orderx` varchar(50) NOT NULL DEFAULT '',
  `comName` text NOT NULL,
  `dateC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `elcode` varchar(19) NOT NULL DEFAULT '',
  `elcode_x` varchar(19) NOT NULL DEFAULT '',
  `synonym` text NOT NULL,
  `track_reason` tinytext NOT NULL,
  `seotrack` varchar(7) NOT NULL DEFAULT '',
  `introduced` varchar(4) NOT NULL DEFAULT '',
  `authSp` text NOT NULL,
  `authSsp` text NOT NULL,
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sciName` (`sciName`),
  KEY `family` (`family`),
  KEY `elcode_x` (`elcode_x`),
  KEY `orderx` (`orderx`(35)),
  KEY `MGfamily` (`majorGroup`(25),`family`(30)),
  KEY `majorGroup` (`majorGroup`(25)),
  KEY `comName` (`comName`(25)),
  KEY `seotrack` (`seotrack`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `batch_dprspp_skip`
--

DROP TABLE IF EXISTS `batch_dprspp_skip`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `batch_dprspp_skip` (
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `family` varchar(50) NOT NULL DEFAULT '',
  `subfamily` varchar(50) NOT NULL DEFAULT '',
  `majorGroup` varchar(50) NOT NULL DEFAULT '',
  `orderx` varchar(50) NOT NULL DEFAULT '',
  `comName` text NOT NULL,
  `dateC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `elcode` varchar(19) NOT NULL DEFAULT '',
  `elcode_x` varchar(19) NOT NULL DEFAULT '',
  `synonym` text NOT NULL,
  `track_reason` tinytext NOT NULL,
  `seotrack` varchar(7) NOT NULL DEFAULT '',
  `introduced` varchar(4) NOT NULL DEFAULT '',
  `authSp` text NOT NULL,
  `authSsp` text NOT NULL,
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sciName` (`sciName`),
  KEY `family` (`family`),
  KEY `elcode_x` (`elcode_x`),
  KEY `orderx` (`orderx`(35)),
  KEY `MGfamily` (`majorGroup`(25),`family`(30)),
  KEY `majorGroup` (`majorGroup`(25)),
  KEY `comName` (`comName`(25)),
  KEY `seotrack` (`seotrack`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bird_count`
--

DROP TABLE IF EXISTS `bird_count`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bird_count` (
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `occur_id` int(11) NOT NULL DEFAULT '0',
  `park` varchar(4) NOT NULL DEFAULT '',
  `comment` mediumtext NOT NULL,
  `date` date DEFAULT NULL,
  `observer` varchar(100) DEFAULT NULL,
  `number` int(11) DEFAULT '0',
  `delete` char(1) NOT NULL DEFAULT '',
  `mark` char(1) NOT NULL DEFAULT '',
  `tempX` char(1) NOT NULL DEFAULT '',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `sciName` (`sciName`),
  KEY `park` (`park`),
  KEY `dataC` (`dateCreate`),
  KEY `mark` (`mark`),
  KEY `date` (`date`),
  KEY `occur_id` (`occur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=282 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `butterfly_account`
--

DROP TABLE IF EXISTS `butterfly_account`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `butterfly_account` (
  `comName` varchar(100) NOT NULL DEFAULT '',
  `sciName` varchar(75) NOT NULL DEFAULT '',
  `distribution` text NOT NULL,
  `abundance` text NOT NULL,
  `checklist_mt` varchar(6) NOT NULL DEFAULT '',
  `checklist_pd` varchar(6) NOT NULL DEFAULT '',
  `checklist_cp` varchar(6) NOT NULL DEFAULT '',
  `flight` text NOT NULL,
  `habitat` text NOT NULL,
  `plants` text NOT NULL,
  `comments` text NOT NULL,
  `state_status` varchar(12) NOT NULL DEFAULT '',
  `fed_status` varchar(12) NOT NULL DEFAULT '',
  `date_spread` char(1) NOT NULL DEFAULT '',
  `collection` char(1) NOT NULL DEFAULT '',
  `synonym` tinytext NOT NULL,
  `other_name` mediumtext NOT NULL,
  `photo_link` tinytext NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `update_by` varchar(50) NOT NULL DEFAULT '',
  `edit_done` char(1) NOT NULL DEFAULT '',
  `page_num` int(11) NOT NULL DEFAULT '0',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `comName` (`comName`)
) ENGINE=MyISAM AUTO_INCREMENT=176 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `chsw_lichen`
--

DROP TABLE IF EXISTS `chsw_lichen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `chsw_lichen` (
  `a` text NOT NULL,
  `b` text NOT NULL,
  `c` text NOT NULL,
  `d` text NOT NULL,
  `e` text NOT NULL,
  `f` text NOT NULL,
  `g` text NOT NULL,
  `p` text,
  `j` text NOT NULL,
  `l` text,
  `k` text NOT NULL,
  `o` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cover_page`
--

DROP TABLE IF EXISTS `cover_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cover_page` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majorGroup` varchar(48) NOT NULL DEFAULT '',
  `overview` text NOT NULL,
  `links` text NOT NULL,
  `resources` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cover_page_park`
--

DROP TABLE IF EXISTS `cover_page_park`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cover_page_park` (
  `majorGroup` text NOT NULL,
  `park` varchar(10) NOT NULL,
  `habitat` text NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `park` (`park`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dprspp`
--

DROP TABLE IF EXISTS `dprspp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dprspp` (
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `family` varchar(50) NOT NULL DEFAULT '',
  `subfamily` varchar(50) NOT NULL DEFAULT '',
  `majorGroup` varchar(50) NOT NULL DEFAULT '',
  `orderx` varchar(50) NOT NULL DEFAULT '',
  `comName` text NOT NULL,
  `dateC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `elcode` varchar(19) NOT NULL DEFAULT '',
  `elcode_x` varchar(19) NOT NULL DEFAULT '',
  `sort_order` decimal(11,2) NOT NULL,
  `synonym` text NOT NULL,
  `track_reason` tinytext NOT NULL,
  `seotrack` varchar(7) NOT NULL DEFAULT '',
  `introduced` varchar(4) NOT NULL DEFAULT '',
  `authSp` text NOT NULL,
  `authSsp` text NOT NULL,
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sciName` (`sciName`),
  KEY `family` (`family`),
  KEY `elcode_x` (`elcode_x`),
  KEY `orderx` (`orderx`(35)),
  KEY `MGfamily` (`majorGroup`(25),`family`(30)),
  KEY `majorGroup` (`majorGroup`(25)),
  KEY `comName` (`comName`(25)),
  KEY `seotrack` (`seotrack`)
) ENGINE=MyISAM AUTO_INCREMENT=16168 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `dumond_memi`
--

DROP TABLE IF EXISTS `dumond_memi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dumond_memi` (
  `a` varchar(4) NOT NULL DEFAULT 'MEMI',
  `b` varchar(128) NOT NULL,
  `c` text NOT NULL,
  `d` date NOT NULL,
  `e` varchar(8) NOT NULL DEFAULT 'Gates',
  `f` varchar(128) NOT NULL,
  `g` int(11) NOT NULL,
  `h` text NOT NULL,
  `i` text NOT NULL,
  `j` text NOT NULL,
  `k` text NOT NULL,
  `l` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `enri_ed`
--

DROP TABLE IF EXISTS `enri_ed`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enri_ed` (
  `park` text NOT NULL,
  `sciName` varchar(100) NOT NULL,
  `common_name` text NOT NULL,
  `date` text NOT NULL,
  `county` text NOT NULL,
  `observer` text NOT NULL,
  `number` text NOT NULL,
  `comment` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `in_bloom` text NOT NULL,
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fact`
--

DROP TABLE IF EXISTS `fact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fact` (
  `dateC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `source` text NOT NULL,
  `contrib` varchar(75) NOT NULL DEFAULT '',
  `funFact` text NOT NULL,
  `web` tinytext NOT NULL,
  `pick` char(1) NOT NULL DEFAULT '',
  `fid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`fid`),
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM AUTO_INCREMENT=8059 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `families`
--

DROP TABLE IF EXISTS `families`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `families` (
  `majorGroup` text NOT NULL,
  `family_sciname` varchar(36) NOT NULL DEFAULT '',
  `family_comname` text NOT NULL,
  PRIMARY KEY (`family_sciname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `family_names`
--

DROP TABLE IF EXISTS `family_names`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `family_names` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `majorGroup` text NOT NULL,
  `family_sciname` varchar(36) NOT NULL DEFAULT '',
  `family_comname` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `family_sciname_2` (`family_sciname`),
  KEY `family_sciname` (`family_sciname`)
) ENGINE=MyISAM AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fish`
--

DROP TABLE IF EXISTS `fish`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fish` (
  `fid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `family` varchar(75) NOT NULL DEFAULT '',
  `sciName` varchar(75) NOT NULL DEFAULT '',
  `tolerance` varchar(50) NOT NULL DEFAULT '',
  `guild` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`fid`),
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM AUTO_INCREMENT=214 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `forum`
--

DROP TABLE IF EXISTS `forum`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `forum` (
  `topic` text NOT NULL,
  `submitter` varchar(35) NOT NULL DEFAULT '',
  `submission` text NOT NULL,
  `weblink` text NOT NULL,
  `mark` char(1) NOT NULL DEFAULT '',
  `dateCreate` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `submisID` int(10) unsigned NOT NULL DEFAULT '0',
  `forumID` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`forumID`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fungi_enri_thro_foma`
--

DROP TABLE IF EXISTS `fungi_enri_thro_foma`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fungi_enri_thro_foma` (
  `park` text NOT NULL,
  `sciName` varchar(75) NOT NULL,
  `county` text NOT NULL,
  `date` date NOT NULL,
  `observer` text NOT NULL,
  `locality` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `fungi_lendemer`
--

DROP TABLE IF EXISTS `fungi_lendemer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `fungi_lendemer` (
  `park` varchar(4) NOT NULL,
  `sciName` varchar(255) NOT NULL,
  `comName` varchar(24) NOT NULL,
  `date` date DEFAULT NULL,
  `county` text,
  `observer` text NOT NULL,
  `number` int(11) NOT NULL DEFAULT '1',
  `comments` text,
  `lat` text,
  `lon` text NOT NULL,
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `gocr_bryo`
--

DROP TABLE IF EXISTS `gocr_bryo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `gocr_bryo` (
  `park` varchar(4) NOT NULL DEFAULT 'GOCR',
  `sciName` varchar(256) NOT NULL,
  `b` text NOT NULL,
  `c` text NOT NULL,
  `d` text NOT NULL,
  `e` text NOT NULL,
  `f` text NOT NULL,
  `g` text NOT NULL,
  `h` text NOT NULL,
  `comments` text NOT NULL,
  `i` text NOT NULL,
  `j` text NOT NULL,
  `k` text NOT NULL,
  `l` text NOT NULL,
  `m` text NOT NULL,
  `n` text NOT NULL,
  `o` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hall_bioblitz`
--

DROP TABLE IF EXISTS `hall_bioblitz`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hall_bioblitz` (
  `park` text NOT NULL,
  `sciName` text NOT NULL,
  `comName` text NOT NULL,
  `date` text NOT NULL,
  `county` varchar(8) NOT NULL DEFAULT 'Moore; C',
  `observer` text NOT NULL,
  `number` text NOT NULL,
  `comment` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `in_bloom_(plants_only)` text NOT NULL,
  `breeding_(birds_only)` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `hide_park`
--

DROP TABLE IF EXISTS `hide_park`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hide_park` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `park_name` text NOT NULL,
  `park_code` varchar(10) NOT NULL,
  `pin` char(10) NOT NULL,
  `hide` char(1) NOT NULL,
  `email` text NOT NULL,
  `address` text NOT NULL,
  `phone` text NOT NULL,
  `parklat` varchar(16) NOT NULL,
  `parklon` varchar(16) NOT NULL,
  `cklist_email` varchar(200) NOT NULL,
  `cklist_phone` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `park_code` (`park_code`),
  UNIQUE KEY `pin` (`pin`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `howell_bay_lake`
--

DROP TABLE IF EXISTS `howell_bay_lake`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `howell_bay_lake` (
  `park` text NOT NULL,
  `sciName` text NOT NULL,
  `common_name` text NOT NULL,
  `date` text NOT NULL,
  `county` text NOT NULL,
  `observer` text NOT NULL,
  `number` text NOT NULL,
  `comments` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `in_bloom` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `howell_bay_lake_1`
--

DROP TABLE IF EXISTS `howell_bay_lake_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `howell_bay_lake_1` (
  `park_code` text NOT NULL,
  `sciName` text NOT NULL,
  `common_name` text NOT NULL,
  `date` text NOT NULL,
  `county` text NOT NULL,
  `observer` text NOT NULL,
  `number` text NOT NULL,
  `comments` text NOT NULL,
  `collection_number` text NOT NULL,
  `herbarium` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `in_bloom` text NOT NULL,
  `in_fruit` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `howell_bay_lake_2`
--

DROP TABLE IF EXISTS `howell_bay_lake_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `howell_bay_lake_2` (
  `park_code` text NOT NULL,
  `sciName` text NOT NULL,
  `common_name` text NOT NULL,
  `date` text NOT NULL,
  `county` text NOT NULL,
  `observer` text NOT NULL,
  `number` text NOT NULL,
  `comments` text NOT NULL,
  `collection_number` text NOT NULL,
  `herbarium` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `in_bloom` text NOT NULL,
  `in_fruit` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `howell_bay_lake_animal`
--

DROP TABLE IF EXISTS `howell_bay_lake_animal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `howell_bay_lake_animal` (
  `park` text NOT NULL,
  `sciName` text NOT NULL,
  `common_name` text NOT NULL,
  `date` text NOT NULL,
  `county` text NOT NULL,
  `observer` text NOT NULL,
  `number` text NOT NULL,
  `comments` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `images_the_id`
--

DROP TABLE IF EXISTS `images_the_id`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images_the_id` (
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `comName` varchar(75) NOT NULL DEFAULT '',
  `park` varchar(4) NOT NULL DEFAULT '',
  `pid` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pid`),
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM AUTO_INCREMENT=5390 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `intermediate`
--

DROP TABLE IF EXISTS `intermediate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `intermediate` (
  `park` varchar(4) NOT NULL,
  `sciName` varchar(64) DEFAULT NULL,
  `comName` varchar(16) NOT NULL,
  `date` varchar(24) DEFAULT NULL,
  `county` varchar(24) DEFAULT NULL,
  `observer` varchar(48) NOT NULL,
  `number` int(11) NOT NULL,
  `comments` text NOT NULL,
  `latitude` decimal(5,3) DEFAULT NULL,
  `longitude` decimal(7,4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Merrite beetles uploaded _20150512';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `laja_bioblitz_hemiptera`
--

DROP TABLE IF EXISTS `laja_bioblitz_hemiptera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `laja_bioblitz_hemiptera` (
  `a` text NOT NULL,
  `b` text NOT NULL,
  `c` text NOT NULL,
  `d` text NOT NULL,
  `e` text NOT NULL,
  `f` text NOT NULL,
  `g` text NOT NULL,
  `h` varchar(24) NOT NULL DEFAULT '2014 BioBlitz'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `land_snails`
--

DROP TABLE IF EXISTS `land_snails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `land_snails` (
  `park` text NOT NULL,
  `sciName` text,
  `comName` text NOT NULL,
  `date_` text,
  `county` text,
  `observer` text NOT NULL,
  `number` text NOT NULL,
  `comment` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `land_snails_park`
--

DROP TABLE IF EXISTS `land_snails_park`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `land_snails_park` (
  `park` text NOT NULL,
  `sciName` text,
  `comName` text NOT NULL,
  `date_` text,
  `county` text,
  `observer` text NOT NULL,
  `number` text NOT NULL,
  `comment` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `login`
--

DROP TABLE IF EXISTS `login`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `loginTime` datetime NOT NULL,
  `userAddress` varchar(20) NOT NULL DEFAULT '',
  `loginName` varchar(25) NOT NULL DEFAULT '',
  `level` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `memi_bryo`
--

DROP TABLE IF EXISTS `memi_bryo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memi_bryo` (
  `a` text NOT NULL,
  `sciName` varchar(100) NOT NULL,
  `ssp` varchar(100) NOT NULL,
  `auth` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `memi_lichen`
--

DROP TABLE IF EXISTS `memi_lichen`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `memi_lichen` (
  `sciName` varchar(100) NOT NULL,
  `date` varchar(16) NOT NULL,
  `comments` text NOT NULL,
  `darcollector` text NOT NULL,
  `darcounty` text NOT NULL,
  `darlocality` text NOT NULL,
  `darlongitude` text NOT NULL,
  `darlatitude` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `merrit_2013_2014`
--

DROP TABLE IF EXISTS `merrit_2013_2014`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `merrit_2013_2014` (
  `park` varchar(4) NOT NULL,
  `sciName` varchar(100) NOT NULL,
  `comName` varchar(8) NOT NULL,
  `date` varchar(16) NOT NULL,
  `county` varchar(48) NOT NULL,
  `observer` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `coll_date` text NOT NULL,
  `collector,_comments` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `moje_move_to_moth`
--

DROP TABLE IF EXISTS `moje_move_to_moth`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moje_move_to_moth` (
  `park` varchar(4) NOT NULL,
  `sciName` varchar(28) DEFAULT NULL,
  `comName` varchar(16) NOT NULL,
  `date` varchar(24) DEFAULT NULL,
  `county` varchar(4) DEFAULT NULL,
  `observer` varchar(48) NOT NULL,
  `number` int(11) NOT NULL,
  `comments` text NOT NULL,
  `latitude` decimal(5,3) DEFAULT NULL,
  `longitude` decimal(7,4) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `momo_necrop`
--

DROP TABLE IF EXISTS `momo_necrop`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `momo_necrop` (
  `a` text NOT NULL,
  `b` text NOT NULL,
  `c` text NOT NULL,
  `d` text NOT NULL,
  `e` text NOT NULL,
  `f` text NOT NULL,
  `g` text NOT NULL,
  `h` text NOT NULL,
  `i` text NOT NULL,
  `j` text NOT NULL,
  `k` text NOT NULL,
  `l` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `moth_emails`
--

DROP TABLE IF EXISTS `moth_emails`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moth_emails` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Fname` varchar(24) NOT NULL,
  `Lname` varchar(48) NOT NULL,
  `email` varchar(255) NOT NULL,
  `currPark` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `moth_sp_list`
--

DROP TABLE IF EXISTS `moth_sp_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moth_sp_list` (
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `family` varchar(50) NOT NULL DEFAULT '',
  `comName` text NOT NULL,
  `sort_order` decimal(11,2) NOT NULL,
  `id` smallint(5) unsigned NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `moth_sullivan_moje`
--

DROP TABLE IF EXISTS `moth_sullivan_moje`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `moth_sullivan_moje` (
  `nhp_number` text NOT NULL,
  `genus` text NOT NULL,
  `species` text NOT NULL,
  `jbs_name` text NOT NULL,
  `nhp_name` text NOT NULL,
  `mpg_family` text NOT NULL,
  `mpg_subfamily` text NOT NULL,
  `mpg_tribe` text NOT NULL,
  `sprot` text NOT NULL,
  `srank` text NOT NULL,
  `grank` text NOT NULL,
  `range` text NOT NULL,
  `ref_range` text NOT NULL,
  `host_pls` text NOT NULL,
  `ref_host` text NOT NULL,
  `location` text NOT NULL,
  `county` text NOT NULL,
  `date_(date_format)` text NOT NULL,
  `sampling_method` text NOT NULL,
  `weather` text NOT NULL,
  `latitude` text NOT NULL,
  `longitude` text NOT NULL,
  `elevation` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `natinv`
--

DROP TABLE IF EXISTS `natinv`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `natinv` (
  `dateC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `park` varchar(4) NOT NULL DEFAULT '',
  `natinv_id` int(11) NOT NULL DEFAULT '0',
  `habitat` varchar(12) NOT NULL DEFAULT '',
  `presence` varchar(20) NOT NULL DEFAULT '',
  `residence` varchar(20) NOT NULL DEFAULT '',
  `hidden` char(1) NOT NULL DEFAULT '',
  `mark` char(1) NOT NULL DEFAULT '',
  `sprB` varchar(25) NOT NULL DEFAULT '',
  `sumB` varchar(25) NOT NULL DEFAULT '',
  `falB` varchar(25) NOT NULL DEFAULT '',
  `winB` varchar(25) NOT NULL DEFAULT '',
  `id` mediumint(6) unsigned NOT NULL AUTO_INCREMENT,
  `herbarium` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `parkSciName` (`park`,`sciName`),
  KEY `park` (`park`),
  KEY `sciName` (`sciName`),
  KEY `mark` (`mark`),
  KEY `hidden` (`hidden`),
  KEY `residence` (`residence`(10))
) ENGINE=MyISAM AUTO_INCREMENT=74954 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nature_notes`
--

DROP TABLE IF EXISTS `nature_notes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nature_notes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `park_code` varchar(4) NOT NULL,
  `title` text NOT NULL,
  `link` varchar(72) NOT NULL,
  `blank` varchar(4) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nc_bugs`
--

DROP TABLE IF EXISTS `nc_bugs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nc_bugs` (
  `id` int(11) NOT NULL,
  `family` text NOT NULL,
  `subfamily` text NOT NULL,
  `sciname` varchar(100) NOT NULL,
  `comname` text NOT NULL,
  `synonym` text NOT NULL,
  `sort_order` int(11) NOT NULL,
  UNIQUE KEY `sciname` (`sciname`),
  KEY `sort_order` (`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=382 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nc_bugs_original`
--

DROP TABLE IF EXISTS `nc_bugs_original`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nc_bugs_original` (
  `id` int(11) NOT NULL,
  `family` text NOT NULL,
  `subfamily` text NOT NULL,
  `sciName` text NOT NULL,
  `comName` text NOT NULL,
  `sort_order` int(11) NOT NULL,
  KEY `sort_order` (`sort_order`)
) ENGINE=MyISAM AUTO_INCREMENT=381 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nc_bugs_subfam`
--

DROP TABLE IF EXISTS `nc_bugs_subfam`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nc_bugs_subfam` (
  `a` text NOT NULL,
  `b` text NOT NULL,
  `c` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nc_esi`
--

DROP TABLE IF EXISTS `nc_esi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nc_esi` (
  `species` varchar(255) NOT NULL,
  `sciName` varchar(255) NOT NULL,
  KEY `species` (`species`),
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nc_spiders_from_fuller`
--

DROP TABLE IF EXISTS `nc_spiders_from_fuller`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nc_spiders_from_fuller` (
  `family` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `habitat` text NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nhp_animal_list`
--

DROP TABLE IF EXISTS `nhp_animal_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nhp_animal_list` (
  `element_subnational_id` text NOT NULL,
  `sci_name` text NOT NULL,
  `com_name` text NOT NULL,
  `state_stat` text NOT NULL,
  `fed_stat` text NOT NULL,
  `s_rank` text NOT NULL,
  `g_rank` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nhp_name_change`
--

DROP TABLE IF EXISTS `nhp_name_change`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nhp_name_change` (
  `elcode` text NOT NULL,
  `gname` text NOT NULL,
  `sname` varchar(100) NOT NULL,
  KEY `sname` (`sname`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nhp_plant_list`
--

DROP TABLE IF EXISTS `nhp_plant_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nhp_plant_list` (
  `element_subnational_id` int(11) NOT NULL,
  `sci_name` varchar(100) NOT NULL,
  `com_name` text NOT NULL,
  `state_stat` varchar(8) NOT NULL,
  `fed_stat` varchar(8) NOT NULL,
  `s_rank` varchar(8) NOT NULL,
  `g_rank` varchar(8) NOT NULL,
  UNIQUE KEY `element_subnational_id` (`element_subnational_id`),
  KEY `sci_name` (`sci_name`),
  KEY `state_stat` (`state_stat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nhp_species_list`
--

DROP TABLE IF EXISTS `nhp_species_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nhp_species_list` (
  `element_subnational_id` int(11) NOT NULL,
  `sci_name` varchar(100) NOT NULL,
  `com_name` text NOT NULL,
  `state_stat` varchar(8) NOT NULL,
  `fed_stat` varchar(8) NOT NULL,
  `s_rank` varchar(8) NOT NULL,
  `g_rank` varchar(8) NOT NULL,
  UNIQUE KEY `element_subnational_id` (`element_subnational_id`),
  KEY `sci_name` (`sci_name`),
  KEY `state_stat` (`state_stat`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `nhp_tw`
--

DROP TABLE IF EXISTS `nhp_tw`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `nhp_tw` (
  `est_id` int(11) NOT NULL,
  `elcode` text NOT NULL,
  `category` text NOT NULL,
  `taxonomic_group` varchar(256) NOT NULL,
  `sci_name` varchar(128) NOT NULL,
  `com_name` text NOT NULL,
  `s_rank` text NOT NULL,
  `rounded_s_rank` varchar(24) NOT NULL,
  `g_rank` text NOT NULL,
  `rounded_g_rank` text NOT NULL,
  `state_stat` varchar(8) NOT NULL,
  `fed_stat` text NOT NULL,
  `origin_desc` text NOT NULL,
  KEY `rounded_s_rank` (`rounded_s_rank`),
  KEY `state_stat` (`state_stat`),
  KEY `sci_name` (`sci_name`),
  KEY `taxonomic_group` (`taxonomic_group`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `not_on_steve_list`
--

DROP TABLE IF EXISTS `not_on_steve_list`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `not_on_steve_list` (
  `mpg_number` text NOT NULL,
  `nrid_name` varchar(64) NOT NULL,
  `park` text NOT NULL,
  `comment` text NOT NULL,
  `date` text NOT NULL,
  `observer` text NOT NULL,
  `id` text NOT NULL,
  `sph_comments` text NOT NULL,
  `bo_comments` text NOT NULL,
  `tom_comment` text NOT NULL,
  KEY `nrid_name` (`nrid_name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `note`
--

DROP TABLE IF EXISTS `note`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `note` (
  `ceid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `noteid` varchar(10) NOT NULL DEFAULT '',
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `text` mediumtext NOT NULL,
  `image` varchar(100) NOT NULL DEFAULT '',
  `mark` char(1) NOT NULL DEFAULT '',
  PRIMARY KEY (`ceid`),
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM AUTO_INCREMENT=241 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `observer`
--

DROP TABLE IF EXISTS `observer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `observer` (
  `oid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `Fname` varchar(25) NOT NULL DEFAULT '',
  `MI` char(2) NOT NULL DEFAULT '',
  `Lname` varchar(25) NOT NULL DEFAULT '',
  `nridName` mediumtext NOT NULL,
  `email` varchar(100) NOT NULL DEFAULT '',
  `snailMail` text NOT NULL,
  `phone` varchar(15) NOT NULL DEFAULT '',
  PRIMARY KEY (`oid`)
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `occur`
--

DROP TABLE IF EXISTS `occur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `occur` (
  `dateCreate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `occur_id` int(11) NOT NULL DEFAULT '0',
  `park` varchar(4) NOT NULL DEFAULT '',
  `comment` mediumtext NOT NULL,
  `date` date DEFAULT NULL,
  `lon` varchar(11) NOT NULL DEFAULT '',
  `lat` varchar(9) NOT NULL DEFAULT '',
  `observer` varchar(100) DEFAULT NULL,
  `number` int(11) DEFAULT '0',
  `edit` char(2) NOT NULL DEFAULT '',
  `dYear` varchar(4) NOT NULL DEFAULT '',
  `dMonth` char(2) NOT NULL DEFAULT '',
  `dDay` char(2) NOT NULL DEFAULT '',
  `delete` char(1) NOT NULL DEFAULT '',
  `mark` char(1) NOT NULL DEFAULT '',
  `tempX` char(1) NOT NULL DEFAULT '',
  `bloom` char(1) NOT NULL DEFAULT '',
  `county` varchar(25) NOT NULL DEFAULT '',
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `sciName` (`sciName`),
  KEY `park` (`park`),
  KEY `dataC` (`dateCreate`),
  KEY `mark` (`mark`),
  KEY `dYear` (`dYear`),
  KEY `date` (`date`),
  KEY `lat` (`lat`),
  KEY `occur_id` (`occur_id`)
) ENGINE=MyISAM AUTO_INCREMENT=253543 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `photos`
--

DROP TABLE IF EXISTS `photos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `photos` (
  `park` varchar(5) DEFAULT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `filesize` varchar(50) DEFAULT NULL,
  `filetype` varchar(50) DEFAULT NULL,
  `sciName` varchar(50) NOT NULL DEFAULT '',
  `photos_id` int(11) NOT NULL DEFAULT '0',
  `majorGroup` varchar(30) NOT NULL DEFAULT '',
  `discus` text NOT NULL,
  `photog` varchar(255) NOT NULL DEFAULT '',
  `date` date DEFAULT NULL,
  `comment` text NOT NULL,
  `ided` enum('no','yes') NOT NULL DEFAULT 'no',
  `dateM` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `idBy` text NOT NULL,
  `email` varchar(50) NOT NULL DEFAULT '',
  `mark` char(1) NOT NULL DEFAULT '',
  `link` varchar(255) NOT NULL DEFAULT '',
  `testinclude` tinyint(4) NOT NULL DEFAULT '0',
  `pid` int(4) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`pid`),
  KEY `sciName` (`sciName`),
  KEY `park` (`park`),
  KEY `dateM` (`dateM`),
  KEY `majorGroup` (`majorGroup`),
  KEY `mark` (`mark`),
  KEY `ided` (`ided`),
  KEY `idBy` (`idBy`(1))
) ENGINE=MyISAM AUTO_INCREMENT=8726 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pimo_cvs`
--

DROP TABLE IF EXISTS `pimo_cvs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pimo_cvs` (
  `observation_id` varchar(8) NOT NULL,
  `sciName` varchar(100) NOT NULL,
  `dprspp_sciName` varchar(100) NOT NULL,
  `park` varchar(4) NOT NULL,
  `comment` text NOT NULL,
  `date` date NOT NULL,
  `lon` varchar(11) NOT NULL,
  `lat` varchar(9) NOT NULL,
  `observer` varchar(100) NOT NULL,
  `dYear` char(4) NOT NULL,
  `dMonth` char(2) NOT NULL,
  `dDay` char(2) NOT NULL,
  `county` varchar(25) NOT NULL,
  KEY `observation_id` (`observation_id`),
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pimo_cvs_info`
--

DROP TABLE IF EXISTS `pimo_cvs_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pimo_cvs_info` (
  `observation_id` varchar(8) NOT NULL,
  `author_observation_code` text NOT NULL,
  `observation_start_date` text NOT NULL,
  `countyname` text NOT NULL,
  `real_latitude` text NOT NULL,
  `real_longitude` text NOT NULL,
  `observation_narrative` text NOT NULL,
  `location_narrative` text NOT NULL,
  `plot_rationale` text NOT NULL,
  `commprimarycommon` text NOT NULL,
  KEY `observation_id` (`observation_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `ref`
--

DROP TABLE IF EXISTS `ref`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ref` (
  `rid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `park` varchar(4) NOT NULL DEFAULT '',
  `majorGroup` varchar(50) NOT NULL DEFAULT 'Misc',
  `author` varchar(200) NOT NULL DEFAULT '',
  `title` text NOT NULL,
  `year` varchar(8) NOT NULL DEFAULT '',
  `comment` mediumtext NOT NULL,
  `link` varchar(255) NOT NULL DEFAULT '',
  `dateM` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=238 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `research_spp`
--

DROP TABLE IF EXISTS `research_spp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `research_spp` (
  `id` int(11) NOT NULL,
  `majorGroup` varchar(50) NOT NULL,
  `sciName` varchar(100) NOT NULL,
  `comName` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sensitive_spp`
--

DROP TABLE IF EXISTS `sensitive_spp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sensitive_spp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dprspp_id` int(11) NOT NULL DEFAULT '0',
  `sciName` varchar(75) NOT NULL DEFAULT '',
  `state_status` varchar(10) NOT NULL DEFAULT '',
  `fed_status` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=55 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sounds`
--

DROP TABLE IF EXISTS `sounds`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sounds` (
  `sid` mediumint(9) NOT NULL AUTO_INCREMENT,
  `sciName` varchar(50) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `link` varchar(255) NOT NULL DEFAULT '',
  `testInclude` tinyint(4) NOT NULL DEFAULT '1',
  `park` varchar(10) NOT NULL DEFAULT '',
  `type` varchar(20) NOT NULL DEFAULT '',
  `source` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`sid`),
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `species_table`
--

DROP TABLE IF EXISTS `species_table`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `species_table` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `family` varchar(50) NOT NULL DEFAULT '',
  `subfamily` varchar(50) NOT NULL DEFAULT '',
  `majorGroup` varchar(50) NOT NULL DEFAULT '',
  `orderx` varchar(50) NOT NULL DEFAULT '',
  `comName` text NOT NULL,
  `dateC` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `sort_order` varchar(19) NOT NULL DEFAULT '',
  `synonym` text NOT NULL,
  `track_reason` tinytext NOT NULL,
  `seotrack` varchar(7) NOT NULL DEFAULT '',
  `introduced` varchar(4) NOT NULL DEFAULT '',
  `authSp` text NOT NULL,
  `authSsp` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `sciName` (`sciName`),
  UNIQUE KEY `sort_order` (`sort_order`(8)),
  KEY `comName` (`comName`(25)),
  KEY `family` (`family`)
) ENGINE=MyISAM AUTO_INCREMENT=12235 DEFAULT CHARSET=latin1 PACK_KEYS=0;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `spider_upload`
--

DROP TABLE IF EXISTS `spider_upload`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `spider_upload` (
  `family` text NOT NULL,
  `name` varchar(100) NOT NULL,
  `auth` varchar(48) NOT NULL,
  `habitat` text NOT NULL,
  `majorGroup` varchar(64) NOT NULL,
  `orderx` varchar(64) NOT NULL,
  `introduced` varchar(3) NOT NULL,
  `seotrack` varchar(3) NOT NULL,
  `exists` varchar(1) NOT NULL,
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stmo_bryos`
--

DROP TABLE IF EXISTS `stmo_bryos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stmo_bryos` (
  `park` varchar(4) NOT NULL DEFAULT 'STMO',
  `sciName` varchar(128) NOT NULL,
  `comName` text NOT NULL,
  `date` text,
  `county` text,
  `observer` text,
  `number` text NOT NULL,
  `comment` text NOT NULL,
  `latitude` text,
  `longitude` text NOT NULL,
  KEY `scientific_name` (`sciName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `stmo_bryos_old`
--

DROP TABLE IF EXISTS `stmo_bryos_old`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `stmo_bryos_old` (
  `park_code` varchar(4) NOT NULL DEFAULT 'STMO',
  `scientific_name` text NOT NULL,
  `authority` text NOT NULL,
  `plant_group` text NOT NULL,
  `notes` text NOT NULL,
  `county_or_district` text NOT NULL,
  `habitat` text NOT NULL,
  `collection_date` text NOT NULL,
  `collectors` text NOT NULL,
  `collection_number` text NOT NULL,
  `associated_taxa` text NOT NULL,
  `longitude` text NOT NULL,
  `latitude` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tempNRID`
--

DROP TABLE IF EXISTS `tempNRID`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tempNRID` (
  `majorGroup` varchar(50) NOT NULL DEFAULT '',
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `comName` text NOT NULL,
  `orderx` varchar(50) NOT NULL DEFAULT '',
  `elcode_x` varchar(19) NOT NULL DEFAULT '',
  `family` varchar(50) NOT NULL DEFAULT '',
  `track_reason` tinytext NOT NULL,
  `park` varchar(10) NOT NULL DEFAULT '',
  `date` date DEFAULT NULL,
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `dateCreate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dYear` varchar(4) NOT NULL DEFAULT '',
  `dMonth` char(2) NOT NULL DEFAULT '',
  `dDay` char(2) NOT NULL DEFAULT '',
  `comment` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `tempNRID_1`
--

DROP TABLE IF EXISTS `tempNRID_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tempNRID_1` (
  `majorGroup` varchar(50) NOT NULL DEFAULT '',
  `sciName` varchar(100) NOT NULL DEFAULT '',
  `comName` text NOT NULL,
  `orderx` varchar(50) NOT NULL DEFAULT '',
  `elcode_x` varchar(19) NOT NULL DEFAULT '',
  `family` varchar(50) NOT NULL DEFAULT '',
  `seotrack` varchar(7) NOT NULL DEFAULT '',
  `track_reason` tinytext NOT NULL,
  `park` varchar(10) NOT NULL DEFAULT '',
  `date` date DEFAULT NULL,
  `id` int(10) unsigned NOT NULL DEFAULT '0',
  `dateCreate` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `dYear` varchar(4) NOT NULL DEFAULT '',
  `dMonth` char(2) NOT NULL DEFAULT '',
  `dDay` char(2) NOT NULL DEFAULT '',
  `comment` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `visit`
--

DROP TABLE IF EXISTS `visit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `visit` (
  `vid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `address` varchar(16) NOT NULL DEFAULT '',
  `Mgroup` varchar(50) NOT NULL DEFAULT '',
  `park` varchar(10) NOT NULL DEFAULT '',
  `when` varchar(19) NOT NULL,
  PRIMARY KEY (`vid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `w6_spp`
--

DROP TABLE IF EXISTS `w6_spp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `w6_spp` (
  `sciName` varchar(75) NOT NULL DEFAULT '',
  `sandhill` char(1) NOT NULL DEFAULT '',
  `coastal_plain` char(1) NOT NULL DEFAULT '',
  `piedmont` char(1) NOT NULL DEFAULT '',
  `mountain` char(1) NOT NULL DEFAULT '',
  `comment` varchar(75) NOT NULL DEFAULT '',
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wells_plant`
--

DROP TABLE IF EXISTS `wells_plant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wells_plant` (
  `a` text NOT NULL,
  `b` text NOT NULL,
  `c` text,
  `d` text,
  `e` text NOT NULL,
  `f` text NOT NULL,
  `g` text NOT NULL,
  `h` text NOT NULL,
  `i` text,
  `j` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wewo_555_plant`
--

DROP TABLE IF EXISTS `wewo_555_plant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wewo_555_plant` (
  `park` varchar(4) NOT NULL DEFAULT '',
  `sciName` varchar(100) NOT NULL DEFAULT '',
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wewo_sorrie_new`
--

DROP TABLE IF EXISTS `wewo_sorrie_new`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wewo_sorrie_new` (
  `park` varchar(4) NOT NULL DEFAULT 'HARO',
  `sciName` varchar(100) NOT NULL,
  `comName` varchar(4) NOT NULL,
  `date` text,
  `county` varchar(16) NOT NULL,
  `observer` varchar(100) NOT NULL,
  `number` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `lat` varchar(1) NOT NULL,
  `long` varchar(1) NOT NULL,
  `bloom` varchar(1) NOT NULL,
  `breed` varchar(1) NOT NULL,
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wewo_sorrie_occur`
--

DROP TABLE IF EXISTS `wewo_sorrie_occur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wewo_sorrie_occur` (
  `park` varchar(4) NOT NULL DEFAULT 'HARO',
  `sciName` varchar(100) NOT NULL,
  `comName` varchar(4) NOT NULL,
  `date` text,
  `county` varchar(16) NOT NULL,
  `observer` varchar(100) NOT NULL,
  `number` int(11) NOT NULL DEFAULT '0',
  `comment` text NOT NULL,
  `lat` varchar(1) NOT NULL,
  `long` varchar(1) NOT NULL,
  `bloom` varchar(1) NOT NULL,
  `breed` varchar(1) NOT NULL,
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wewo_sorrie_plant`
--

DROP TABLE IF EXISTS `wewo_sorrie_plant`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wewo_sorrie_plant` (
  `park` varchar(4) NOT NULL DEFAULT 'WEWO',
  `sciName` varchar(255) NOT NULL,
  `comName` varchar(255) NOT NULL,
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `wiki`
--

DROP TABLE IF EXISTS `wiki`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wiki` (
  `wid` int(11) NOT NULL AUTO_INCREMENT,
  `sciName` varchar(75) NOT NULL DEFAULT '',
  `wiki_link` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`wid`),
  KEY `sciName` (`sciName`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-03 14:59:36
