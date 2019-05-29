-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: 0.0.0.0    Database: pset7
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

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
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `transaction` char(4) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `symbol` varchar(255) NOT NULL,
  `shares` int(10) unsigned NOT NULL,
  `price` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
INSERT INTO `history` VALUES (3,29,'BUY','2016-09-16 21:26:30','GOLD',1,'$96.480'),(4,29,'SELL','2016-09-16 21:29:47','GOLD',1,'$96.480'),(5,29,'BUY','2016-09-16 21:33:56','GOLD',1,'$96.480'),(6,29,'BUY','2016-09-16 23:22:31','BAC',5,'$77.450'),(7,30,'BUY','2016-09-17 09:48:08','JPY=X',10,'$1,022.700'),(8,29,'SELL','2016-09-17 10:07:31','BAC',5,'$77.450'),(9,29,'BUY','2016-09-17 14:19:27','ROKA',11,'$8.800'),(10,29,'BUY','2016-09-17 14:19:47','FGDBX',30,'$687.000'),(11,29,'BUY','2016-09-17 14:27:51','JPY=X',6,'$613.620'),(12,29,'BUY','2016-09-17 14:30:49','SPY',3,'$640.110'),(13,29,'SELL','2016-09-17 14:44:46','JPY=X',3,'$306.810'),(14,31,'BUY','2016-09-18 21:13:04','USD',3,'$353.760'),(15,31,'SELL','2016-09-18 21:13:20','USD',1,'$117.920'),(16,31,'BUY','2016-09-18 21:17:28','BTG',10,'$27.400'),(17,31,'BUY','2016-09-18 21:17:45','EVBG',2,'$30.500'),(18,31,'BUY','2016-09-18 21:18:01','SBOT',5,'$13.950'),(19,29,'BUY','2016-09-18 21:27:31','USDEGP=X',100,'$885.740'),(20,29,'BUY','2016-09-18 21:29:26','EGPGBP=X',17,'$1.465'),(21,29,'BUY','2016-09-18 21:30:05','EGPEUR=X',5,'$0.503'),(22,29,'SELL','2016-09-18 21:31:17','EGPEUR=X',4,'$0.402'),(23,29,'SELL','2016-09-20 20:42:53','SPY',1,'$213.420');
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `portfolios`
--

DROP TABLE IF EXISTS `portfolios`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `portfolios` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `shares` bigint(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_2` (`user_id`,`symbol`),
  UNIQUE KEY `user_id_3` (`user_id`,`symbol`),
  UNIQUE KEY `user_id_4` (`user_id`,`symbol`),
  UNIQUE KEY `user_id` (`user_id`,`symbol`),
  CONSTRAINT `portfolios_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `portfolios`
--

LOCK TABLES `portfolios` WRITE;
/*!40000 ALTER TABLE `portfolios` DISABLE KEYS */;
INSERT INTO `portfolios` VALUES (3,29,'GOLD',1),(5,30,'JPY=X',10),(6,29,'ROKA',11),(7,29,'FGDBX',30),(9,29,'JPY=X',3),(10,29,'SPY',2),(11,31,'USD',2),(12,31,'BTG',10),(13,31,'EVBG',2),(14,31,'SBOT',5),(15,29,'USDEGP=X',100),(16,29,'EGPGBP=X',17),(17,29,'EGPEUR=X',1);
/*!40000 ALTER TABLE `portfolios` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(300) NOT NULL,
  `cash` decimal(65,4) unsigned NOT NULL DEFAULT '0.0000',
  `date` date NOT NULL COMMENT 'This is the date for the last deposite',
  `username` varchar(255) NOT NULL,
  `hash` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`username`),
  UNIQUE KEY `email_2` (`email`),
  UNIQUE KEY `email_3` (`email`,`username`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'andi@harvard.edu',10000.0000,'2016-09-16','andi','$2y$10$c.e4DK7pVyLT.stmHxgAleWq4yViMmkwKz3x8XCo4b/u3r8g5OTnS'),(2,'caesar@harvard.edu',10000.0000,'2016-09-16','caesar','$2y$10$0p2dlmu6HnhzEMf9UaUIfuaQP7tFVDMxgFcVs0irhGqhOxt6hJFaa'),(3,'eli@harvard.edu',10000.0000,'2016-09-16','eli','$2y$10$COO6EnTVrCPCEddZyWeEJeH9qPCwPkCS0jJpusNiru.XpRN6Jf7HW'),(4,'hdan@harvard.edu',10000.0000,'2016-09-16','hdan','$2y$10$o9a4ZoHqVkVHSno6j.k34.wC.qzgeQTBHiwa3rpnLq7j2PlPJHo1G'),(5,'jason@harvard.edu',10000.0000,'2016-09-16','jason','$2y$10$ci2zwcWLJmSSqyhCnHKUF.AjoysFMvlIb1w4zfmCS7/WaOrmBnLNe'),(6,'john@harvard.edu',10000.0000,'2016-09-16','john','$2y$10$dy.LVhWgoxIQHAgfCStWietGdJCPjnNrxKNRs5twGcMrQvAPPIxSy'),(7,'levatich@harvard.edu',10000.0000,'2016-09-16','levatich','$2y$10$fBfk7L/QFiplffZdo6etM.096pt4Oyz2imLSp5s8HUAykdLXaz6MK'),(8,'rob@harvard.edu',10000.0000,'2016-09-16','rob','$2y$10$3pRWcBbGdAdzdDiVVybKSeFq6C50g80zyPRAxcsh2t5UnwAkG.I.2'),(9,'skroob@harvard.edu',10000.0000,'2016-09-16','skroob','$2y$10$395b7wODm.o2N7W5UZSXXuXwrC0OtFB17w4VjPnCIn/nvv9e4XUQK'),(10,'zamyla@harvard.edu',10000.0000,'2016-09-16','zamyla','$2y$10$UOaRF0LGOaeHG4oaEkfO4O7vfI34B1W23WqHr9zCpXL68hfQsS3/e'),(29,'abdullahem1997@hotmail.com',9886.9140,'2016-09-20','abdullah','$2y$10$KW1e3IXpxL7xZsmeicbMiOia/RkAUPtyWIk5iDvsRVAyWr4LJ4RIK'),(30,'emad111@gmail.com',8977.3000,'2016-09-17','emad','$2y$10$nnEIGJ0ErodkNcv4Zbuv4.hs6JHoAUcoFKvz65Fc0ZIHAb13NonQO'),(31,'mai.mahmoud97@hotmail.com',9692.3100,'2016-09-18','maimahmoud','$2y$10$fgwPKAK0auQURDkfxZEIfuMEzdD6L6NlmWqrhWWZmXwEI3b.s7ke2');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-09-20 20:54:58
