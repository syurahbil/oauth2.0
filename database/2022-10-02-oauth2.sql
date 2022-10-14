-- MySQL dump 10.13  Distrib 8.0.30, for Linux (x86_64)
--
-- Host: localhost    Database: oauth2
-- ------------------------------------------------------
-- Server version	8.0.30-0ubuntu0.20.04.2

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
-- Table structure for table `history_send_receive`
--

DROP TABLE IF EXISTS `history_send_receive`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `history_send_receive` (
  `row_id` int NOT NULL AUTO_INCREMENT,
  `com_type` varchar(20) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `com_code` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `no_ref` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `status` varchar(30) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `message` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `event` text CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci,
  `token` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `register_date` datetime DEFAULT NULL,
  `register_by` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `flag` smallint DEFAULT '1',
  PRIMARY KEY (`row_id`)
) ENGINE=InnoDB AUTO_INCREMENT=43447 DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history_send_receive`
--

LOCK TABLES `history_send_receive` WRITE;
/*!40000 ALTER TABLE `history_send_receive` DISABLE KEYS */;
INSERT INTO `history_send_receive` VALUES (43425,'RECEIVE','z9x80d8111af5vg','0','00','Request Data User user1','Request Data User user1','00290b4932d60d46717c95c025ba9268208d44d2','2022-09-08 17:34:10','Local User',1),(43426,'SEND','z9x80d8111af5vg','0','00','Request Data Successful','Request Data Successful - Username user1','00290b4932d60d46717c95c025ba9268208d44d2','2022-09-08 17:34:10','Local User',1),(43427,'RECEIVE','t3wsil5jcth97eg','0','00','Request Data User user1','Request Data User user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:37:38','Local User',1),(43428,'SEND','t3wsil5jcth97eg','0','00','Request Data Successful','Request Data Successful - Username user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:37:38','Local User',1),(43429,'RECEIVE','9ddl6epknv63wz3','0','00','Request Data User user1','Request Data User user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:39:49','Local User',1),(43430,'SEND','9ddl6epknv63wz3','0','00','Request Data Successful','Request Data Successful - Username user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:39:49','Local User',1),(43431,'RECEIVE','p2pih7h4h60yogh','0','00','Request Data User user1','Request Data User user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:40:52','Local User',1),(43432,'SEND','p2pih7h4h60yogh','0','00','Request Data Successful','Request Data Successful - Username user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:40:52','Local User',1),(43433,'RECEIVE','gs9mvmlll0xqoki','0','00','Request Data User user1','Request Data User user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:46:42','Local User',1),(43434,'SEND','gs9mvmlll0xqoki','0','00','Request Data Successful','Request Data Successful - Username user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:46:42','Local User',1),(43435,'RECEIVE','0vc6matd8dk14gl','0','00','Request Data User user1','Request Data User user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:47:07','Local User',1),(43436,'SEND','0vc6matd8dk14gl','0','00','Request Data Successful','Request Data Successful - Username user1','b66be0932c8de9eda062c135f0d9ebda24803384','2022-09-08 17:47:07','Local User',1),(43437,'RECEIVE','l1wjadfi5z80eq9','0','00','Request Data User user1','Request Data User user1','b104817d235856ce6b0aded33b767f4301373461','2022-09-08 19:56:14','Local User',1),(43438,'SEND','l1wjadfi5z80eq9','0','00','Request Data Successful','Request Data Successful - Username user1','b104817d235856ce6b0aded33b767f4301373461','2022-09-08 19:56:14','Local User',1),(43439,'RECEIVE','v6a6o9sj5wloevl','0','00','Request Data User user1','Request Data User user1','1e142cdf20ade9401e28ea3b107a87632e5e3773','2022-09-08 19:57:33','Local User',1),(43440,'SEND','v6a6o9sj5wloevl','0','00','Request Data Successful','Request Data Successful - Username user1','1e142cdf20ade9401e28ea3b107a87632e5e3773','2022-09-08 19:57:33','Local User',1),(43441,'RECEIVE','sxer7xsn6c6a7uq','0','00','Request Data User user1','Request Data User user1','a36befdaeb49fb9f9be85967b377a9ce01cd4c4e','2022-10-11 20:14:40','Local User',1),(43442,'SEND','sxer7xsn6c6a7uq','0','00','Request Data Successful','Request Data Successful - Username user1','a36befdaeb49fb9f9be85967b377a9ce01cd4c4e','2022-10-11 20:14:40','Local User',1),(43443,'RECEIVE','14hz9d36xj63i76','0','00','Request Data User user1','Request Data User user1','aa688c1154e5e6551afdf29299082fb30e0bcfba','2022-10-11 20:15:32','Local User',1),(43444,'SEND','14hz9d36xj63i76','0','00','Request Data Successful','Request Data Successful - Username user1','aa688c1154e5e6551afdf29299082fb30e0bcfba','2022-10-11 20:15:32','Local User',1),(43445,'RECEIVE','wlclk5bxvtatep2','0','00','Request Data User user1','Request Data User user1','0c5126d95d78597c090af3d0a62523bab7b65ac2','2022-10-12 10:42:08','Local User',1),(43446,'SEND','wlclk5bxvtatep2','0','00','Request Data Successful','Request Data Successful - Username user1','0c5126d95d78597c090af3d0a62523bab7b65ac2','2022-10-12 10:42:08','Local User',1);
/*!40000 ALTER TABLE `history_send_receive` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `internal_log`
--

DROP TABLE IF EXISTS `internal_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `internal_log` (
  `Id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(40) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `event` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `register_date` datetime DEFAULT NULL,
  `session` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  `process_id` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `internal_log`
--

LOCK TABLES `internal_log` WRITE;
/*!40000 ALTER TABLE `internal_log` DISABLE KEYS */;
/*!40000 ALTER TABLE `internal_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_access_tokens`
--

DROP TABLE IF EXISTS `oauth_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_access_tokens` (
  `access_token` varchar(40) NOT NULL DEFAULT '',
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`access_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_access_tokens`
--

LOCK TABLES `oauth_access_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_access_tokens` DISABLE KEYS */;
INSERT INTO `oauth_access_tokens` VALUES ('00290b4932d60d46717c95c025ba9268208d44d2','user1','user1','2022-09-09 07:09:57',NULL),('08806154e0b68cfa22da7e3549991af3353c1380','user1','user1','2022-09-09 07:57:34',NULL),('0c5126d95d78597c090af3d0a62523bab7b65ac2','user1','user1','2022-10-13 01:12:07',NULL),('1e142cdf20ade9401e28ea3b107a87632e5e3773','user1','user1','2022-09-08 12:27:33',NULL),('32a1c3b65e724c78c5573cbed46d294d29192ac4','user1','user1','2022-09-09 12:32:00',NULL),('4aa047161e683f8b3d0cd619e9b6462fdf4e1d0b','user1','user1','2022-09-09 08:17:04',NULL),('5b2598909cfcc758c040b8f984f24fd21b6f9b60','user1','user1','2022-09-09 08:18:07',NULL),('a36befdaeb49fb9f9be85967b377a9ce01cd4c4e','user1','user1','2022-10-12 10:44:39',NULL),('aa688c1154e5e6551afdf29299082fb30e0bcfba','user1','user1','2022-10-12 10:45:32',NULL),('b104817d235856ce6b0aded33b767f4301373461','user1','user1','2022-09-09 12:26:14',NULL),('b66be0932c8de9eda062c135f0d9ebda24803384','user1','user1','2022-09-09 10:07:38',NULL),('d348b604ec376fd6b0b15fb08be3db1eb6e0d2af','user1','user1','2022-09-09 08:16:13',NULL),('ed6a6b5d6bd112300439ac0b7e3142d163563532','user1','user1','2022-09-09 08:18:42',NULL);
/*!40000 ALTER TABLE `oauth_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_authorization_codes`
--

DROP TABLE IF EXISTS `oauth_authorization_codes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_authorization_codes` (
  `authorization_code` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `redirect_uri` varchar(2000) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`authorization_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_authorization_codes`
--

LOCK TABLES `oauth_authorization_codes` WRITE;
/*!40000 ALTER TABLE `oauth_authorization_codes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_authorization_codes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_clients`
--

DROP TABLE IF EXISTS `oauth_clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_clients` (
  `client_id` varchar(80) NOT NULL,
  `client_secret` varchar(80) DEFAULT NULL,
  `redirect_uri` varchar(2000) NOT NULL,
  `grant_types` varchar(80) DEFAULT NULL,
  `scope` varchar(100) DEFAULT NULL,
  `user_id` varchar(80) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_clients`
--

LOCK TABLES `oauth_clients` WRITE;
/*!40000 ALTER TABLE `oauth_clients` DISABLE KEYS */;
INSERT INTO `oauth_clients` VALUES ('user1','123456','http://fake',NULL,NULL,'user1');
/*!40000 ALTER TABLE `oauth_clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_jwt`
--

DROP TABLE IF EXISTS `oauth_jwt`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_jwt` (
  `client_id` varchar(80) NOT NULL,
  `subject` varchar(80) DEFAULT NULL,
  `public_key` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_jwt`
--

LOCK TABLES `oauth_jwt` WRITE;
/*!40000 ALTER TABLE `oauth_jwt` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_jwt` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_public_keys`
--

DROP TABLE IF EXISTS `oauth_public_keys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_public_keys` (
  `client_id` varchar(80) DEFAULT NULL,
  `public_key` varchar(8000) DEFAULT NULL,
  `private_key` varchar(8000) DEFAULT NULL,
  `encryption_algorithm` varchar(80) DEFAULT 'RS256'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_public_keys`
--

LOCK TABLES `oauth_public_keys` WRITE;
/*!40000 ALTER TABLE `oauth_public_keys` DISABLE KEYS */;
INSERT INTO `oauth_public_keys` VALUES (NULL,'-----BEGIN PUBLIC KEY-----\r\nMIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzEkcVtDHXoUe8rxPyvI5\r\ny57pwlSrXm0Rgz5RJ7M05oMhppnaw70Wesgy5VRsSBllgagTh+5NErG/s/1YlqXP\r\nv//OATO2z8u6w82jxC0ewN4RigWlNDGw2d4XVuvCxNt1u19BzIuMFZQ8g6mg6tkJ\r\n+gi+a57NyNnCyS/QW1Qh+Sv46vpsuZQDIfvCR+cJEo6RwjvFb1AcbCA3I1+NuSyQ\r\n2ZshIW18oXWsqsIJ6Ub+xAcs5+L1PzKhdTIN3qn0/DqMapTxBkYQrmh0J/nbE6my\r\nAQE84iRr1Oq5OT51qd7DcIjv9bSbe9FdVI36w2YHDZFImYtKoUmLkYWvLAvkABLr\r\nUwIDAQAB\r\n-----END PUBLIC KEY-----\r\n','-----BEGIN RSA PRIVATE KEY-----\r\nMIIEpAIBAAKCAQEAzEkcVtDHXoUe8rxPyvI5y57pwlSrXm0Rgz5RJ7M05oMhppna\r\nw70Wesgy5VRsSBllgagTh+5NErG/s/1YlqXPv//OATO2z8u6w82jxC0ewN4RigWl\r\nNDGw2d4XVuvCxNt1u19BzIuMFZQ8g6mg6tkJ+gi+a57NyNnCyS/QW1Qh+Sv46vps\r\nuZQDIfvCR+cJEo6RwjvFb1AcbCA3I1+NuSyQ2ZshIW18oXWsqsIJ6Ub+xAcs5+L1\r\nPzKhdTIN3qn0/DqMapTxBkYQrmh0J/nbE6myAQE84iRr1Oq5OT51qd7DcIjv9bSb\r\ne9FdVI36w2YHDZFImYtKoUmLkYWvLAvkABLrUwIDAQABAoIBAQDBMrOWd0TV41ft\r\ngKKF8KcwJ04z9xdK6iOR17Gwtg7lokaE5SS70WwdGpDnyfvOBBa3lFlESN6jO29t\r\nrb/GWXIsxqPxBxNxWd97plOnCHT5OgukWMpwnj3/DcdM8RL2Ugb5+ZCk/aSyE8tX\r\nSWliMXj5+qL77Of5d9h7pLiMZvjqSDYgIzI6r7ByZnHEkeqSanNwldx085Z2T2qf\r\n2rYqiVjl2bkokmpjcFANUhe/sCdBg9EhCtGgV9q6cdY0Ph3Uo2XxwigW7cLrzbb+\r\n7i2QYPi0X1HyO6pHoD6yW8mfNlgDSZfOl0K48058P7PVblWCd2ukSkMlc0Cg6MuB\r\nBm4u67JBAoGBAPYAvRoRuKjhSEx3+LcttiBowDebrDArsCYh6TYx8Zt9fJaevhHI\r\nl3T0aOhTQ07mFjQvrh0YcSyfdYmSJPvDTaysAwDlQ0dopQSQTR27oo7eGH3aorPb\r\n7zfdGqx9IjKRPOjG7dPlab2E9+BN85okJ2SbO4Jb7mA+wq5sM9S9CapLAoGBANSW\r\nXwRR1pTYgTe+xDXSlcVhtHdUU2ZSKFOOofNBHYDFbso1L1B0aAqvQGkiETS1iJxx\r\nk9Cv6SUPT7QrZIATXe+qlCTtUvlHBDR53X4OXV/yQNyyCNh06n7BW0PVjZDIbLYT\r\n/8G4tiL1xmDzfyr4qLrBzV0/AIHlIs8k+vkEtZ4ZAoGAYFGRuO9PWfA7GpWusCoZ\r\nsT7SY/Nzy7iPU57bbPjJHJRZf6/Pw67Cfmxj1vMi23WDJBO3HHVBerNElgS+rkSd\r\n2QnQcz1QxljWo57MUuPwlfenpz8/jSSD2V+c3gRwq1PqgUnCPMEKUcYKN6zNwIB/\r\nXAjbmALepphsKVb8RENv0VkCgYEAhbVeZdUjZdMW0v0FY+TjlpXxb+x12DFsc8GO\r\nUvVtnQSQvlXdQHk2xyGbHYTz1XcoSV2WXveFaG3M78ErIPMNbiSXsPIj8e2c03Si\r\nvxpB2IsCCM1hiuNeagMrZ+r1c07cMVk6z5lh1XNIJsp//YMQfQZQKInrw8desXLM\r\n97rikGECgYBw7VskPU1dKAQKMFGmpvcGSkvmEf9SNzpFCSAk4s5ThEW0oRb8ezzN\r\nc8eCbTpp/5GozUH6i/b87XTWBJ0da8r55Cf144LtUoMdW+r2X4w+4wglOvZuOfiq\r\nUwDDqsC2+2YuFQBIkr+TpKvJrdvsB/jzUkggsM3MNMU9gs0Y/P5mGg==\r\n-----END RSA PRIVATE KEY-----\r\n','RS256');
/*!40000 ALTER TABLE `oauth_public_keys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_refresh_tokens`
--

DROP TABLE IF EXISTS `oauth_refresh_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_refresh_tokens` (
  `refresh_token` varchar(40) NOT NULL,
  `client_id` varchar(80) NOT NULL,
  `user_id` varchar(255) DEFAULT NULL,
  `expires` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `scope` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`refresh_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_refresh_tokens`
--

LOCK TABLES `oauth_refresh_tokens` WRITE;
/*!40000 ALTER TABLE `oauth_refresh_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_refresh_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_scopes`
--

DROP TABLE IF EXISTS `oauth_scopes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_scopes` (
  `scope` text,
  `is_default` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_scopes`
--

LOCK TABLES `oauth_scopes` WRITE;
/*!40000 ALTER TABLE `oauth_scopes` DISABLE KEYS */;
/*!40000 ALTER TABLE `oauth_scopes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `oauth_users`
--

DROP TABLE IF EXISTS `oauth_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `oauth_users` (
  `username` varchar(255) NOT NULL,
  `password` varchar(2000) DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `merchant` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `oauth_users`
--

LOCK TABLES `oauth_users` WRITE;
/*!40000 ALTER TABLE `oauth_users` DISABLE KEYS */;
INSERT INTO `oauth_users` VALUES ('user1','123456','User','1','Local User');
/*!40000 ALTER TABLE `oauth_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_profile` (
  `username` varchar(100) NOT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `register_date` datetime DEFAULT '2022-01-01 00:00:00',
  `modified_date` datetime DEFAULT '2022-01-01 00:00:00',
  `flag` smallint DEFAULT '1',
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES ('user1','Syurahbil','Hadi','mail@mail.com','6281111111','2022-01-01 00:00:00','2022-01-01 00:00:00',1);
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-10-12 12:57:17
