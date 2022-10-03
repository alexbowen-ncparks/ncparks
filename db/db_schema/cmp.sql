CREATE DATABASE  IF NOT EXISTS `cmp` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `cmp`;
-- MySQL dump 10.13  Distrib 5.7.17, for Win64 (x86_64)
--
-- Host: 10.35.80.181    Database: cmp
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
-- Table structure for table `form`
--

DROP TABLE IF EXISTS `form`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `form` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `park_code` varchar(4) NOT NULL,
  `prime_beacon_num` text NOT NULL,
  `sec_beacon_num` text NOT NULL,
  `q_1` text NOT NULL,
  `q_2` text NOT NULL,
  `q_3` text NOT NULL,
  `q_4` text NOT NULL,
  `q_5` text NOT NULL,
  `q_6` text NOT NULL,
  `q_7` text NOT NULL,
  `q_8` text NOT NULL,
  `q_9` text NOT NULL,
  `q_10` text NOT NULL,
  `q_11` text NOT NULL,
  `q_12` text NOT NULL,
  `q_13` text NOT NULL,
  `q_14` text NOT NULL,
  `q_15` text NOT NULL,
  `q_16` text NOT NULL,
  `q_17` text NOT NULL,
  `q_18` text NOT NULL,
  `q_19` text NOT NULL,
  `q_20` text NOT NULL,
  `q_21` text NOT NULL,
  `q_22` text NOT NULL,
  `update_date` date NOT NULL,
  `auditor_date` date NOT NULL,
  `emid` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `park_code` (`park_code`)
) ENGINE=MyISAM AUTO_INCREMENT=538 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `sig`
--

DROP TABLE IF EXISTS `sig`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sig` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `park_code` varchar(4) NOT NULL,
  `prime_beacon_num` varchar(255) NOT NULL,
  `sec_beacon_num` varchar(255) NOT NULL,
  `s1_1` char(1) NOT NULL,
  `s1_2` char(1) NOT NULL,
  `s1_3` char(1) NOT NULL,
  `s1_4` char(1) NOT NULL,
  `s1_5` char(1) NOT NULL,
  `s1_6` char(1) NOT NULL,
  `s1_7` char(1) NOT NULL,
  `s1_8` char(1) NOT NULL,
  `s1_9` char(1) NOT NULL,
  `s1_10` char(1) NOT NULL,
  `s1_11` char(1) NOT NULL,
  `s1_12` char(1) NOT NULL,
  `s1_13` char(1) NOT NULL,
  `s1_14` char(1) NOT NULL,
  `s1_15` char(1) NOT NULL,
  `s1_16` char(1) NOT NULL,
  `s1_17` char(1) NOT NULL,
  `s1_18` char(1) NOT NULL,
  `s2_1` char(1) NOT NULL,
  `s2_2` char(1) NOT NULL,
  `s2_3` char(1) NOT NULL,
  `s2_4` char(1) NOT NULL,
  `s2_5` char(1) NOT NULL,
  `s2_6` char(1) NOT NULL,
  `s2_7` char(1) NOT NULL,
  `s2_8` char(1) NOT NULL,
  `s2_9` char(1) NOT NULL,
  `s2_10` char(1) NOT NULL,
  `s2_11` char(1) NOT NULL,
  `s2_12` char(1) NOT NULL,
  `s2_13` char(1) NOT NULL,
  `s2_14` char(1) NOT NULL,
  `s2_15` char(1) NOT NULL,
  `s2_16` char(1) NOT NULL,
  `s2_17` char(1) NOT NULL,
  `s2_18` char(1) NOT NULL,
  `update_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `active_date` varchar(16) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `park_code` (`park_code`)
) ENGINE=MyISAM AUTO_INCREMENT=404 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-03 15:12:24
