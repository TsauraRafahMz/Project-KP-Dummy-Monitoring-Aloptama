-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: aws_demo
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `aws_site1`
--

DROP TABLE IF EXISTS `aws_site1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aws_site1` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `ws` float DEFAULT NULL,
  `ws_max` float DEFAULT NULL,
  `wd` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `temp_max` float DEFAULT NULL,
  `temp_min` float DEFAULT NULL,
  `rh` float DEFAULT NULL,
  `press` float DEFAULT NULL,
  `sr` float DEFAULT NULL,
  `sr_max` float DEFAULT NULL,
  `lith` float DEFAULT NULL,
  `batt` float DEFAULT NULL,
  `ptemp` float DEFAULT NULL,
  `mdl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prog` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_site1`
--

LOCK TABLES `aws_site1` WRITE;
/*!40000 ALTER TABLE `aws_site1` DISABLE KEYS */;
INSERT INTO `aws_site1` VALUES (1,'2026-09-10 10:00:55','01/09/2026','08:00:00','DEMO01','AWS_SITE_01',2.4,1.8,3.2,145,27.8,28.5,26.9,78,1008.2,420,650,0.2,12.4,28.1,'DEMO_MODEL','DEMO_SN01','DEMO_OS','DEMO_PROG'),(2,'2026-09-10 10:00:55','01/09/2026','09:00:00','DEMO01','AWS_SITE_01',1.2,2.1,3.5,160,28.4,29.1,27.5,75,1007.8,510,720,0.2,12.3,28.7,'DEMO_MODEL','DEMO_SN01','DEMO_OS','DEMO_PROG'),(3,'2026-09-10 10:00:55','01/09/2026','10:00:00','DEMO01','AWS_SITE_01',0,2.8,4.1,175,29.2,30,28.2,72,1007.1,620,810,0.3,12.2,29.4,'DEMO_MODEL','DEMO_SN01','DEMO_OS','DEMO_PROG'),(4,'2026-09-10 10:00:55','01/09/2026','11:00:00','DEMO01','AWS_SITE_01',0,3.2,4.8,190,30.1,31,29,69,1006.5,710,900,0.3,12.1,30.2,'DEMO_MODEL','DEMO_SN01','DEMO_OS','DEMO_PROG'),(5,'2026-09-10 10:00:55','01/09/2026','12:00:00','DEMO01','AWS_SITE_01',0.5,2.5,4,205,30.5,31.4,29.6,67,1006,680,870,0.4,12,30.7,'DEMO_MODEL','DEMO_SN01','DEMO_OS','DEMO_PROG');
/*!40000 ALTER TABLE `aws_site1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aws_site2`
--

DROP TABLE IF EXISTS `aws_site2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aws_site2` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `ws` float DEFAULT NULL,
  `ws_max` float DEFAULT NULL,
  `wd` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `temp_max` float DEFAULT NULL,
  `temp_min` float DEFAULT NULL,
  `rh` float DEFAULT NULL,
  `press` float DEFAULT NULL,
  `sr` float DEFAULT NULL,
  `sr_max` float DEFAULT NULL,
  `lith` float DEFAULT NULL,
  `batt` float DEFAULT NULL,
  `ptemp` float DEFAULT NULL,
  `mdl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prog` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_site2`
--

LOCK TABLES `aws_site2` WRITE;
/*!40000 ALTER TABLE `aws_site2` DISABLE KEYS */;
INSERT INTO `aws_site2` VALUES (1,'2026-09-10 10:03:14','01/09/2026','08:00:00','DEMO02','AWS_SITE_02',1.8,1.5,2.9,130,27.2,28,26.5,80,1008.5,390,620,0.2,12.5,27.6,'DEMO_MODEL','DEMO_SN02','DEMO_OS','DEMO_PROG'),(2,'2026-09-10 10:03:14','01/09/2026','09:00:00','DEMO02','AWS_SITE_02',0.8,2,3.3,145,28,28.8,27.1,77,1008,480,700,0.2,12.4,28.3,'DEMO_MODEL','DEMO_SN02','DEMO_OS','DEMO_PROG'),(3,'2026-09-10 10:03:14','01/09/2026','10:00:00','DEMO02','AWS_SITE_02',0,2.6,3.9,160,28.8,29.6,27.9,74,1007.4,590,790,0.3,12.3,29,'DEMO_MODEL','DEMO_SN02','DEMO_OS','DEMO_PROG'),(4,'2026-09-10 10:03:14','01/09/2026','11:00:00','DEMO02','AWS_SITE_02',0,3,4.5,175,29.7,30.6,28.6,71,1006.8,690,880,0.3,12.2,29.9,'DEMO_MODEL','DEMO_SN02','DEMO_OS','DEMO_PROG'),(5,'2026-09-10 10:03:14','01/09/2026','12:00:00','DEMO02','AWS_SITE_02',0.3,2.4,3.8,190,30.2,31.1,29.3,68,1006.3,660,850,0.4,12.1,30.4,'DEMO_MODEL','DEMO_SN02','DEMO_OS','DEMO_PROG');
/*!40000 ALTER TABLE `aws_site2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aws_site3`
--

DROP TABLE IF EXISTS `aws_site3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aws_site3` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `ws` float DEFAULT NULL,
  `ws_max` float DEFAULT NULL,
  `wd` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `temp_max` float DEFAULT NULL,
  `temp_min` float DEFAULT NULL,
  `rh` float DEFAULT NULL,
  `press` float DEFAULT NULL,
  `sr` float DEFAULT NULL,
  `sr_max` float DEFAULT NULL,
  `lith` float DEFAULT NULL,
  `batt` float DEFAULT NULL,
  `ptemp` float DEFAULT NULL,
  `mdl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prog` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_site3`
--

LOCK TABLES `aws_site3` WRITE;
/*!40000 ALTER TABLE `aws_site3` DISABLE KEYS */;
INSERT INTO `aws_site3` VALUES (1,'2026-09-10 10:03:14','01/09/2026','08:00:00','DEMO03','AWS_SITE_03',1.8,1.5,2.9,130,27.2,28,26.5,80,1008.5,390,620,0.2,12.5,27.6,'DEMO_MODEL','DEMO_SN03','DEMO_OS','DEMO_PROG'),(2,'2026-09-10 10:03:14','01/09/2026','09:00:00','DEMO03','AWS_SITE_03',0.8,2,3.3,145,28,28.8,27.1,77,1008,480,700,0.2,12.4,28.3,'DEMO_MODEL','DEMO_SN03','DEMO_OS','DEMO_PROG'),(3,'2026-09-10 10:03:14','01/09/2026','10:00:00','DEMO03','AWS_SITE_03',0,2.6,3.9,160,28.8,29.6,27.9,74,1007.4,590,790,0.3,12.3,29,'DEMO_MODEL','DEMO_SN03','DEMO_OS','DEMO_PROG'),(4,'2026-09-10 10:03:14','01/09/2026','11:00:00','DEMO03','AWS_SITE_03',0,3,4.5,175,29.7,30.6,28.6,71,1006.8,690,880,0.3,12.2,29.9,'DEMO_MODEL','DEMO_SN03','DEMO_OS','DEMO_PROG'),(5,'2026-09-10 10:03:14','01/09/2026','12:00:00','DEMO03','AWS_SITE_03',0.3,2.4,3.8,190,30.2,31.1,29.3,68,1006.3,660,850,0.4,12.1,30.4,'DEMO_MODEL','DEMO_SN03','DEMO_OS','DEMO_PROG');
/*!40000 ALTER TABLE `aws_site3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aws_site4`
--

DROP TABLE IF EXISTS `aws_site4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aws_site4` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `ws` float DEFAULT NULL,
  `ws_max` float DEFAULT NULL,
  `wd` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `temp_max` float DEFAULT NULL,
  `temp_min` float DEFAULT NULL,
  `rh` float DEFAULT NULL,
  `press` float DEFAULT NULL,
  `sr` float DEFAULT NULL,
  `sr_max` float DEFAULT NULL,
  `lith` float DEFAULT NULL,
  `batt` float DEFAULT NULL,
  `ptemp` float DEFAULT NULL,
  `mdl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prog` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_site4`
--

LOCK TABLES `aws_site4` WRITE;
/*!40000 ALTER TABLE `aws_site4` DISABLE KEYS */;
INSERT INTO `aws_site4` VALUES (1,'2026-09-10 10:03:14','01/09/2026','08:00:00','DEMO04','AWS_SITE_04',1.8,1.5,2.9,130,27.2,28,26.5,80,1008.5,390,620,0.2,12.5,27.6,'DEMO_MODEL','DEMO_SN04','DEMO_OS','DEMO_PROG'),(2,'2026-09-10 10:03:14','01/09/2026','09:00:00','DEMO04','AWS_SITE_04',0.8,2,3.3,145,28,28.8,27.1,77,1008,480,700,0.2,12.4,28.3,'DEMO_MODEL','DEMO_SN04','DEMO_OS','DEMO_PROG'),(3,'2026-09-10 10:03:14','01/09/2026','10:00:00','DEMO04','AWS_SITE_04',0,2.6,3.9,160,28.8,29.6,27.9,74,1007.4,590,790,0.3,12.3,29,'DEMO_MODEL','DEMO_SN04','DEMO_OS','DEMO_PROG'),(4,'2026-09-10 10:03:14','01/09/2026','11:00:00','DEMO04','AWS_SITE_04',0,3,4.5,175,29.7,30.6,28.6,71,1006.8,690,880,0.3,12.2,29.9,'DEMO_MODEL','DEMO_SN04','DEMO_OS','DEMO_PROG'),(5,'2026-09-10 10:03:14','01/09/2026','12:00:00','DEMO04','AWS_SITE_04',0.3,2.4,3.8,190,30.2,31.1,29.3,68,1006.3,660,850,0.4,12.1,30.4,'DEMO_MODEL','DEMO_SN04','DEMO_OS','DEMO_PROG');
/*!40000 ALTER TABLE `aws_site4` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aws_site5`
--

DROP TABLE IF EXISTS `aws_site5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aws_site5` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `ws` float DEFAULT NULL,
  `ws_max` float DEFAULT NULL,
  `wd` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `temp_max` float DEFAULT NULL,
  `temp_min` float DEFAULT NULL,
  `rh` float DEFAULT NULL,
  `press` float DEFAULT NULL,
  `sr` float DEFAULT NULL,
  `sr_max` float DEFAULT NULL,
  `lith` float DEFAULT NULL,
  `batt` float DEFAULT NULL,
  `ptemp` float DEFAULT NULL,
  `mdl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prog` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_site5`
--

LOCK TABLES `aws_site5` WRITE;
/*!40000 ALTER TABLE `aws_site5` DISABLE KEYS */;
INSERT INTO `aws_site5` VALUES (1,'2026-09-10 10:03:14','01/09/2026','08:00:00','DEMO05','AWS_SITE_05',1.8,1.5,2.9,130,27.2,28,26.5,80,1008.5,390,620,0.2,12.5,27.6,'DEMO_MODEL','DEMO_SN05','DEMO_OS','DEMO_PROG'),(2,'2026-09-10 10:03:14','01/09/2026','09:00:00','DEMO05','AWS_SITE_05',0.8,2,3.3,145,28,28.8,27.1,77,1008,480,700,0.2,12.4,28.3,'DEMO_MODEL','DEMO_SN05','DEMO_OS','DEMO_PROG'),(3,'2026-09-10 10:03:14','01/09/2026','10:00:00','DEMO05','AWS_SITE_05',0,2.6,3.9,160,28.8,29.6,27.9,74,1007.4,590,790,0.3,12.3,29,'DEMO_MODEL','DEMO_SN05','DEMO_OS','DEMO_PROG'),(4,'2026-09-10 10:03:14','01/09/2026','11:00:00','DEMO05','AWS_SITE_05',0,3,4.5,175,29.7,30.6,28.6,71,1006.8,690,880,0.3,12.2,29.9,'DEMO_MODEL','DEMO_SN05','DEMO_OS','DEMO_PROG'),(5,'2026-09-10 10:03:14','01/09/2026','12:00:00','DEMO05','AWS_SITE_05',0.3,2.4,3.8,190,30.2,31.1,29.3,68,1006.3,660,850,0.4,12.1,30.4,'DEMO_MODEL','DEMO_SN05','DEMO_OS','DEMO_PROG');
/*!40000 ALTER TABLE `aws_site5` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aws_site6`
--

DROP TABLE IF EXISTS `aws_site6`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aws_site6` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `ws` float DEFAULT NULL,
  `ws_max` float DEFAULT NULL,
  `wd` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `temp_max` float DEFAULT NULL,
  `temp_min` float DEFAULT NULL,
  `rh` float DEFAULT NULL,
  `press` float DEFAULT NULL,
  `sr` float DEFAULT NULL,
  `sr_max` float DEFAULT NULL,
  `lith` float DEFAULT NULL,
  `batt` float DEFAULT NULL,
  `ptemp` float DEFAULT NULL,
  `mdl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prog` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_site6`
--

LOCK TABLES `aws_site6` WRITE;
/*!40000 ALTER TABLE `aws_site6` DISABLE KEYS */;
INSERT INTO `aws_site6` VALUES (1,'2026-09-08 10:36:12','01/09/2026','08:00:00','DEMO06','AWS_SITE_06',2.4,1.8,3.2,145,27.8,28.5,26.9,78,1008.2,420,650,0.2,12.4,28.1,'DEMO_MODEL','DEMO_SN06','DEMO_OS','DEMO_PROG');
/*!40000 ALTER TABLE `aws_site6` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aws_site7`
--

DROP TABLE IF EXISTS `aws_site7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aws_site7` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `ws` float DEFAULT NULL,
  `ws_max` float DEFAULT NULL,
  `wd` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `temp_max` float DEFAULT NULL,
  `temp_min` float DEFAULT NULL,
  `rh` float DEFAULT NULL,
  `press` float DEFAULT NULL,
  `sr` float DEFAULT NULL,
  `sr_max` float DEFAULT NULL,
  `lith` float DEFAULT NULL,
  `batt` float DEFAULT NULL,
  `ptemp` float DEFAULT NULL,
  `mdl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prog` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_site7`
--

LOCK TABLES `aws_site7` WRITE;
/*!40000 ALTER TABLE `aws_site7` DISABLE KEYS */;
INSERT INTO `aws_site7` VALUES (1,'2026-09-05 10:36:12','01/09/2026','08:00:00','DEMO07','AWS_SITE_07',2.4,1.8,3.2,145,27.8,28.5,26.9,78,1008.2,420,650,0.2,12.4,28.1,'DEMO_MODEL','DEMO_SN07','DEMO_OS','DEMO_PROG');
/*!40000 ALTER TABLE `aws_site7` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aws_site8`
--

DROP TABLE IF EXISTS `aws_site8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aws_site8` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `ws` float DEFAULT NULL,
  `ws_max` float DEFAULT NULL,
  `wd` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `temp_max` float DEFAULT NULL,
  `temp_min` float DEFAULT NULL,
  `rh` float DEFAULT NULL,
  `press` float DEFAULT NULL,
  `sr` float DEFAULT NULL,
  `sr_max` float DEFAULT NULL,
  `lith` float DEFAULT NULL,
  `batt` float DEFAULT NULL,
  `ptemp` float DEFAULT NULL,
  `mdl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prog` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_site8`
--

LOCK TABLES `aws_site8` WRITE;
/*!40000 ALTER TABLE `aws_site8` DISABLE KEYS */;
INSERT INTO `aws_site8` VALUES (1,'2026-08-31 10:36:12','01/09/2026','08:00:00','DEMO08','AWS_SITE_08',2.4,1.8,3.2,145,27.8,28.5,26.9,78,1008.2,420,650,0.2,12.4,28.1,'DEMO_MODEL','DEMO_SN08','DEMO_OS','DEMO_PROG');
/*!40000 ALTER TABLE `aws_site8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `aws_site9`
--

DROP TABLE IF EXISTS `aws_site9`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `aws_site9` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `Date` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `time` varchar(25) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `staid` varchar(10) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rain` float DEFAULT NULL,
  `ws` float DEFAULT NULL,
  `ws_max` float DEFAULT NULL,
  `wd` float DEFAULT NULL,
  `temp` float DEFAULT NULL,
  `temp_max` float DEFAULT NULL,
  `temp_min` float DEFAULT NULL,
  `rh` float DEFAULT NULL,
  `press` float DEFAULT NULL,
  `sr` float DEFAULT NULL,
  `sr_max` float DEFAULT NULL,
  `lith` float DEFAULT NULL,
  `batt` float DEFAULT NULL,
  `ptemp` float DEFAULT NULL,
  `mdl` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `sn` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `os` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `prog` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `aws_site9`
--

LOCK TABLES `aws_site9` WRITE;
/*!40000 ALTER TABLE `aws_site9` DISABLE KEYS */;
INSERT INTO `aws_site9` VALUES (1,'2026-08-26 10:36:12','01/09/2026','08:00:00','DEMO09','AWS_SITE_09',2.4,1.8,3.2,145,27.8,28.5,26.9,78,1008.2,420,650,0.2,12.4,28.1,'DEMO_MODEL','DEMO_SN09','DEMO_OS','DEMO_PROG');
/*!40000 ALTER TABLE `aws_site9` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-10 18:38:27
