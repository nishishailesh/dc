-- MySQL dump 10.13  Distrib 5.5.44, for debian-linux-gnu (i686)
--
-- Host: localhost    Database: dc
-- ------------------------------------------------------
-- Server version	5.5.44-0+deb7u1

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
-- Table structure for table `bloodgroup`
--

DROP TABLE IF EXISTS `bloodgroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bloodgroup` (
  `bloodgroup` varchar(20) NOT NULL,
  PRIMARY KEY (`bloodgroup`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `clinician`
--

DROP TABLE IF EXISTS `clinician`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clinician` (
  `clinician` varchar(100) NOT NULL,
  PRIMARY KEY (`clinician`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `department`
--

DROP TABLE IF EXISTS `department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `department` (
  `department` varchar(200) NOT NULL,
  `code` varchar(30) NOT NULL,
  PRIMARY KEY (`department`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `discharge_type`
--

DROP TABLE IF EXISTS `discharge_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `discharge_type` (
  `discharge_type` varchar(100) NOT NULL,
  PRIMARY KEY (`discharge_type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `location` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `pt`
--

DROP TABLE IF EXISTS `pt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pt` (
  `mrd` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `ipd` varchar(20) NOT NULL,
  `mobile` varchar(100) NOT NULL,
  `age` varchar(20) NOT NULL,
  `sex` varchar(1) NOT NULL,
  `department` varchar(100) NOT NULL,
  `unit` varchar(5) NOT NULL,
  `location` varchar(30) NOT NULL,
  `clinician` varchar(100) NOT NULL,
  `diagnosis` varchar(100) NOT NULL,
  `doa` date DEFAULT NULL,
  `doo` date DEFAULT NULL,
  `dod` date DEFAULT NULL,
  `LCDC_no` varchar(20) NOT NULL,
  `HPE_no` varchar(20) NOT NULL,
  `MLC_no` varchar(20) NOT NULL,
  `bloodgroup` varchar(20) NOT NULL,
  `complains` varchar(500) NOT NULL,
  `Hb` varchar(250) NOT NULL DEFAULT '  gm/dL',
  `Platelet` varchar(250) NOT NULL DEFAULT '  /(mm)3',
  `TC` varchar(250) NOT NULL,
  `DC` varchar(250) NOT NULL,
  `Hematocrit` varchar(250) NOT NULL,
  `Creatinine` varchar(250) NOT NULL,
  `Sodium` varchar(250) NOT NULL,
  `Potassium` varchar(250) NOT NULL,
  `Glucose` varchar(250) NOT NULL,
  `pus_culture` varchar(100) NOT NULL,
  `urine_culture` varchar(100) NOT NULL,
  `Urine_microscopy` varchar(100) NOT NULL,
  `other_laboratory` varchar(1000) NOT NULL,
  `x_ray` varchar(300) NOT NULL,
  `USG` varchar(300) NOT NULL,
  `ECG` varchar(300) NOT NULL,
  `reference` varchar(500) NOT NULL,
  `OT` varchar(2000) NOT NULL,
  `treatment_in_ward` varchar(1000) NOT NULL,
  `discharge_type` varchar(100) NOT NULL,
  `condition_on_discharge` varchar(1000) NOT NULL,
  `advise_on_discharge` varchar(500) NOT NULL,
  `followup` varchar(500) NOT NULL,
  `lock` int(11) NOT NULL,
  PRIMARY KEY (`ipd`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `unit`
--

DROP TABLE IF EXISTS `unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit` (
  `unit` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`unit`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` bigint(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `department` varchar(100) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `right` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `user_pass`
--

DROP TABLE IF EXISTS `user_pass`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_pass` (
  `id` bigint(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `password` varchar(300) NOT NULL,
  `department` varchar(100) NOT NULL,
  `unit` varchar(10) NOT NULL,
  `right` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-05 16:15:13
