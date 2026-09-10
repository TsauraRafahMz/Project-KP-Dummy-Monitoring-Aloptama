-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: arg_demo
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
-- Table structure for table `arg_site1`
--

DROP TABLE IF EXISTS `arg_site1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arg_site1` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_arg` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `rr_arg` float NOT NULL,
  `batt_arg` float NOT NULL,
  `log_temp` float NOT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arg_site1`
--

LOCK TABLES `arg_site1` WRITE;
/*!40000 ALTER TABLE `arg_site1` DISABLE KEYS */;
INSERT INTO `arg_site1` VALUES (1,'2026-09-10 10:07:42','DEMO_ARG_01','08:00:00',0,12.5,26.8,'ARG_SITE_01','01/09/2026'),(2,'2026-09-10 10:07:42','DEMO_ARG_01','09:00:00',0.4,12.4,27.3,'ARG_SITE_01','01/09/2026'),(3,'2026-09-10 10:07:42','DEMO_ARG_01','10:00:00',1.2,12.3,28.1,'ARG_SITE_01','01/09/2026'),(4,'2026-09-10 10:07:42','DEMO_ARG_01','11:00:00',2.8,12.2,29,'ARG_SITE_01','01/09/2026'),(5,'2026-09-10 10:07:42','DEMO_ARG_01','12:00:00',0.6,12.1,29.5,'ARG_SITE_01','01/09/2026');
/*!40000 ALTER TABLE `arg_site1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arg_site2`
--

DROP TABLE IF EXISTS `arg_site2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arg_site2` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_arg` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `rr_arg` float NOT NULL,
  `batt_arg` float NOT NULL,
  `log_temp` float NOT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arg_site2`
--

LOCK TABLES `arg_site2` WRITE;
/*!40000 ALTER TABLE `arg_site2` DISABLE KEYS */;
INSERT INTO `arg_site2` VALUES (1,'2026-09-10 10:07:54','DEMO_ARG_02','08:00:00',0.2,12.6,26.5,'ARG_SITE_02','01/09/2026'),(2,'2026-09-10 10:07:54','DEMO_ARG_02','09:00:00',0.8,12.5,27,'ARG_SITE_02','01/09/2026'),(3,'2026-09-10 10:07:54','DEMO_ARG_02','10:00:00',1.5,12.4,27.8,'ARG_SITE_02','01/09/2026'),(4,'2026-09-10 10:07:54','DEMO_ARG_02','11:00:00',3.2,12.3,28.6,'ARG_SITE_02','01/09/2026'),(5,'2026-09-10 10:07:54','DEMO_ARG_02','12:00:00',1,12.2,29.1,'ARG_SITE_02','01/09/2026');
/*!40000 ALTER TABLE `arg_site2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arg_site3`
--

DROP TABLE IF EXISTS `arg_site3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arg_site3` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_arg` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `rr_arg` float NOT NULL,
  `batt_arg` float NOT NULL,
  `log_temp` float NOT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arg_site3`
--

LOCK TABLES `arg_site3` WRITE;
/*!40000 ALTER TABLE `arg_site3` DISABLE KEYS */;
INSERT INTO `arg_site3` VALUES (1,'2026-09-10 10:08:01','DEMO_ARG_03','08:00:00',0,12.7,26.2,'ARG_SITE_03','01/09/2026'),(2,'2026-09-10 10:08:01','DEMO_ARG_03','09:00:00',0.3,12.6,26.9,'ARG_SITE_03','01/09/2026'),(3,'2026-09-10 10:08:01','DEMO_ARG_03','10:00:00',0.9,12.5,27.6,'ARG_SITE_03','01/09/2026'),(4,'2026-09-10 10:08:01','DEMO_ARG_03','11:00:00',2.4,12.4,28.4,'ARG_SITE_03','01/09/2026'),(5,'2026-09-10 10:08:01','DEMO_ARG_03','12:00:00',0.5,12.3,28.9,'ARG_SITE_03','01/09/2026');
/*!40000 ALTER TABLE `arg_site3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arg_site4`
--

DROP TABLE IF EXISTS `arg_site4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arg_site4` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_arg` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `rr_arg` float NOT NULL,
  `batt_arg` float NOT NULL,
  `log_temp` float NOT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arg_site4`
--

LOCK TABLES `arg_site4` WRITE;
/*!40000 ALTER TABLE `arg_site4` DISABLE KEYS */;
INSERT INTO `arg_site4` VALUES (1,'2026-09-10 10:08:53','DEMO_ARG_04','08:00:00',0.1,12.5,26.7,'ARG_SITE_04','01/09/2026'),(2,'2026-09-10 10:08:53','DEMO_ARG_04','09:00:00',0.6,12.4,27.4,'ARG_SITE_04','01/09/2026'),(3,'2026-09-10 10:08:53','DEMO_ARG_04','10:00:00',1.8,12.3,28.2,'ARG_SITE_04','01/09/2026'),(4,'2026-09-10 10:08:53','DEMO_ARG_04','11:00:00',2.9,12.2,29.1,'ARG_SITE_04','01/09/2026'),(5,'2026-09-10 10:08:53','DEMO_ARG_04','12:00:00',0.7,12.1,29.7,'ARG_SITE_04','01/09/2026');
/*!40000 ALTER TABLE `arg_site4` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arg_site5`
--

DROP TABLE IF EXISTS `arg_site5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arg_site5` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_arg` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `rr_arg` float NOT NULL,
  `batt_arg` float NOT NULL,
  `log_temp` float NOT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arg_site5`
--

LOCK TABLES `arg_site5` WRITE;
/*!40000 ALTER TABLE `arg_site5` DISABLE KEYS */;
INSERT INTO `arg_site5` VALUES (1,'2026-09-10 10:08:59','DEMO_ARG_05','08:00:00',0,12.6,26.4,'ARG_SITE_05','01/09/2026'),(2,'2026-09-10 10:08:59','DEMO_ARG_05','09:00:00',0.5,12.5,27.1,'ARG_SITE_05','01/09/2026'),(3,'2026-09-10 10:08:59','DEMO_ARG_05','10:00:00',1.1,12.4,27.9,'ARG_SITE_05','01/09/2026'),(4,'2026-09-10 10:08:59','DEMO_ARG_05','11:00:00',3.5,12.3,28.7,'ARG_SITE_05','01/09/2026'),(5,'2026-09-10 10:08:59','DEMO_ARG_05','12:00:00',0.8,12.2,29.3,'ARG_SITE_05','01/09/2026');
/*!40000 ALTER TABLE `arg_site5` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arg_site6`
--

DROP TABLE IF EXISTS `arg_site6`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arg_site6` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_arg` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `rr_arg` float NOT NULL,
  `batt_arg` float NOT NULL,
  `log_temp` float NOT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arg_site6`
--

LOCK TABLES `arg_site6` WRITE;
/*!40000 ALTER TABLE `arg_site6` DISABLE KEYS */;
INSERT INTO `arg_site6` VALUES (1,'2026-09-08 10:36:23','DEMO_ARG_06','08:00:00',0,12.5,26.8,'ARG_SITE_06','01/09/2026');
/*!40000 ALTER TABLE `arg_site6` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arg_site7`
--

DROP TABLE IF EXISTS `arg_site7`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arg_site7` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_arg` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `rr_arg` float NOT NULL,
  `batt_arg` float NOT NULL,
  `log_temp` float NOT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arg_site7`
--

LOCK TABLES `arg_site7` WRITE;
/*!40000 ALTER TABLE `arg_site7` DISABLE KEYS */;
INSERT INTO `arg_site7` VALUES (1,'2026-09-05 10:36:23','DEMO_ARG_07','08:00:00',0,12.5,26.8,'ARG_SITE_07','01/09/2026');
/*!40000 ALTER TABLE `arg_site7` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arg_site8`
--

DROP TABLE IF EXISTS `arg_site8`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arg_site8` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_arg` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `rr_arg` float NOT NULL,
  `batt_arg` float NOT NULL,
  `log_temp` float NOT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arg_site8`
--

LOCK TABLES `arg_site8` WRITE;
/*!40000 ALTER TABLE `arg_site8` DISABLE KEYS */;
INSERT INTO `arg_site8` VALUES (1,'2026-08-31 10:36:23','DEMO_ARG_08','08:00:00',0,12.5,26.8,'ARG_SITE_08','01/09/2026');
/*!40000 ALTER TABLE `arg_site8` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `arg_site9`
--

DROP TABLE IF EXISTS `arg_site9`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `arg_site9` (
  `No` int NOT NULL AUTO_INCREMENT,
  `waktu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `time_arg` varchar(25) COLLATE utf8mb4_general_ci NOT NULL,
  `rr_arg` float NOT NULL,
  `batt_arg` float NOT NULL,
  `log_temp` float NOT NULL,
  `site` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `date` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  PRIMARY KEY (`No`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `arg_site9`
--

LOCK TABLES `arg_site9` WRITE;
/*!40000 ALTER TABLE `arg_site9` DISABLE KEYS */;
INSERT INTO `arg_site9` VALUES (1,'2026-08-26 10:36:23','DEMO_ARG_09','08:00:00',0,12.5,26.8,'ARG_SITE_09','01/09/2026');
/*!40000 ALTER TABLE `arg_site9` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-10 18:38:36
