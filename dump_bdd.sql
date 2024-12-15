-- MySQL dump 10.13  Distrib 5.7.39, for osx11.0 (x86_64)
--
-- Host: 127.0.0.1    Database: MIROFF_Airplanes
-- ------------------------------------------------------
-- Server version	5.7.39

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
-- Table structure for table `Articles`
--

DROP TABLE IF EXISTS `Articles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Articles` (
                            `id_art` int(11) NOT NULL,
                            `ID_STRIPE` varchar(255) DEFAULT NULL,
                            `nom` varchar(255) NOT NULL,
                            `quantite` int(11) NOT NULL,
                            `prix` varchar(255) NOT NULL,
                            `url_photo` varchar(255) NOT NULL,
                            `description` text NOT NULL,
                            PRIMARY KEY (`id_art`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Articles`
--

LOCK TABLES `Articles` WRITE;
/*!40000 ALTER TABLE `Articles` DISABLE KEYS */;
INSERT INTO `Articles` VALUES (1,'price_1QQU2z2LxFCJRb6Qoob5YO66','Dassault Rafale',998,'70','../images/article1.png','Avion multirôle développé par Dassault Aviation, capable d\'effectuer des missions de supériorité aérienne, d\'attaque au sol et de reconnaissance. Premier vol en 1986, entré en service en 2001. Utilisé par l\'armée de l\'air française et la marine nationale.'),(2,'price_1QQU482LxFCJRb6QVQi1Fel6','Airbus A400M',998,'135','../images/article2.png','Avion de transport militaire développé par Airbus Defence and Space. Multirôle, conçu pour transporter des troupes, du matériel et du fret en tout genre, sur de courtes et moyennes distances. Robuste et capable d\'opérer depuis des pistes courtes et non préparées. Entrée en service en 2013, utilisé par plusieurs forces aériennes européennes.'),(3,'price_1QQU5G2LxFCJRb6QYuR6Tbnp','NH 90 Caïman',0,'39','../images/article3.png','Hélicoptère de transport militaire développé par NHIndustries. Multirôle, conçu pour des missions de transport de troupes, de matériel et de soutien logistique, ainsi que pour des opérations de recherche et sauvetage. Polyvalent, il est capable d\'opérer dans des environnements difficiles, y compris depuis des navires et sur des terrains accidentés. Entré en service en 2007, il est utilisé par l\'armée française ainsi que par de nombreuses forces armées à travers le monde.');
/*!40000 ALTER TABLE `Articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Clients`
--

DROP TABLE IF EXISTS `Clients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Clients` (
                           `id_client` int(11) NOT NULL AUTO_INCREMENT,
                           `ID_STRIPE` varchar(255) DEFAULT NULL,
                           `nom` varchar(255) NOT NULL,
                           `prenom` varchar(255) NOT NULL,
                           `adresse` text NOT NULL,
                           `telephone` varchar(11) NOT NULL,
                           `email` varchar(255) NOT NULL,
                           `mdp` varchar(255) NOT NULL,
                           PRIMARY KEY (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Clients`
--

LOCK TABLES `Clients` WRITE;
/*!40000 ALTER TABLE `Clients` DISABLE KEYS */;
INSERT INTO `Clients` VALUES (29,NULL,'admin','admin','admin','0615562659','a@a','$2y$10$mOuCTSqR.RdO7uCiFgpQPep2tjKPtfaBd9wlESOu79WtpqoaQYLt.'),(30,NULL,'a','a','a','1234567891','adadf@a','$2y$10$nx6Y.9nHwcGFMUTJKDrSveib7v/5xxufaXEoqnZqDjbsFRrB6wDha'),(31,NULL,'test redirect','test redirect','test redirect','0123456789','test-redirect@test-redirect','$2y$10$GeL1H22siI3P8AuG4..yZ.i/aJLxn0v9TsBXN53S.ay9N422Djchm'),(32,NULL,'Miroff','Maxime','11 Rue Frédéric Chopin','0615562659','s@s','$2y$10$4A.OdgSAqMxFq9Y1xM2k4.u4m54QPcGfDq86qE8h6U2BSHUZ3JmU2'),(33,NULL,'Miroff','Maxime','11 Rue Frédéric Chopin','0615562659','m.m@1','$2y$10$17Gvo1FkqQUDtvJwExj1oevuzOspdBmkqkKHHeLNrHRYI7n7SNKkO'),(34,NULL,'Miroff','Maxime','11 Rue Frédéric Chopin','0615562659','maxime@1','$2y$10$PiHSEat9ZqWDXSqXEVXJ0e8z5X89fbZLAin61hMJ8jwxRrtsuwT9S'),(35,NULL,'TestNom','TestPrenom','TestAdresse','0612345678','test@example.com','$2y$10$0yBpSHLCG/7qQEImxmfVqOq5hFrkxT9kCNV.uasfAmdGzv10Epk8q'),(36,NULL,'a','a','a','a@a.a','1111111111','$2y$10$DGtk/QvBYCAo6HU0JULjL.39meGSuHUbfvGqrIJ2k5c2rj90rf4S.'),(37,NULL,'a','a','a','a@a.a','1111111111','$2y$10$FF/ZlrIFvfTXVDzM55TQAOTmA.mbNEaXZIm6BWKizwUw1D1cGNV/.'),(38,NULL,'a','a','a','a@a.a','1111111111','$2y$10$ylMK8ytPnvdfr8h7L4gXBuABXwv9643Bw5CyinFKzy3LxtLt91g2y'),(39,NULL,'b','b','b','b@b.b','2222222222','$2y$10$WSOIfqdEwYrF1BSmhDrj/.hnYKhmeTVYFxykdrH/EqInFm3YWFdfy'),(40,NULL,'a','a','a','m@m.m','1111111111','$2y$10$kpoFF74q3TruDBiOnXCT3.vElZhF0QB7MLh9gKYFNAYwyNn8dGqoS'),(41,NULL,'o','o','o','o@o.o','1111111112','$2y$10$fMh2HhVqRv.y4c9zq61DUO9hoCCyM9MAgDcdm0HM4nRRY2UnZPzzq'),(42,NULL,'realAdmin','realAdmin','realAdmin','9999999999','realAdmin@realAdmin.realAdmin','$2y$10$SpLk7xRiWouy2yiVpJL25eKhQv5uHSGozns6R8SVzjb0gL9ljjXVK'),(43,'cus_RJ6DIzMM2WkNmb','aze','aze','aze','0987654321','a@a.a','$2y$10$uIUhJV8kizSZfHoC4.ONqO7/YF2Ijkvou9SfTpEt3k..WTfk2NGMm'),(44,'cus_RJcY5KCdN3Nd3j','i','i','i','0765432111','i@i.i','$2y$10$zMDwbVeqYugFg7qVUH2yLOAsG2jtSIXnT5CwvlWIPikuGDUCl508e'),(45,'cus_RNblP9AKHxXlqn','a','a','a','1234567890','z@z.z','$2y$10$63bjnWjVbPvmT3fc1sNu0.roWpRS/kPoUABzxxZtdPStbgVNUOGVy'),(51,'cus_RNlgSiCVQBD72s','Compte A','Compte A','Compte A','0612121212','comptea@a.a','$2y$10$lnIeylTGBUqbKwlEgPk5P.ed7Y2jmowUmIoyzQRNmfDJSgWLWB5s6'),(52,'cus_RNlhY4LX6nZ13k','Compte B','Compte B','Compte B','0612121212','compteb@b.b','$2y$10$tPbhKVHeBD2h3bPcDvn9A.xalR8TJ7W.2cRsjYa45ZbGRmvTrvJYm');
/*!40000 ALTER TABLE `Clients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Commandes`
--

DROP TABLE IF EXISTS `Commandes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Commandes` (
                             `id_commande` int(11) NOT NULL AUTO_INCREMENT,
                             `id_art` int(11) DEFAULT NULL,
                             `id_client` int(11) DEFAULT NULL,
                             `quantite` int(11) DEFAULT NULL,
                             `envoi` tinyint(1) DEFAULT '0',
                             PRIMARY KEY (`id_commande`),
                             KEY `id_art` (`id_art`),
                             KEY `id_client` (`id_client`),
                             CONSTRAINT `commandes_ibfk_1` FOREIGN KEY (`id_art`) REFERENCES `Articles` (`id_art`),
                             CONSTRAINT `commandes_ibfk_2` FOREIGN KEY (`id_client`) REFERENCES `Clients` (`id_client`)
) ENGINE=InnoDB AUTO_INCREMENT=80 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Commandes`
--

LOCK TABLES `Commandes` WRITE;
/*!40000 ALTER TABLE `Commandes` DISABLE KEYS */;
INSERT INTO `Commandes` VALUES (16,2,29,1,0),(17,2,29,1,0),(18,1,29,1,0),(19,1,29,10,0),(20,1,29,20,0),(21,3,29,1,0),(22,2,29,1,0),(23,2,29,1,0),(24,1,29,1,0),(25,3,29,1,0),(26,1,29,1,0),(27,1,29,997,0),(28,2,43,3,0),(29,3,43,1,0),(30,3,43,1,0),(31,2,43,1,0),(32,2,43,1,0),(33,2,43,1,0),(34,2,43,1,0),(35,2,43,1,0),(36,1,43,1,0),(37,1,43,1,0),(38,3,44,1,0),(39,3,43,5,0),(40,3,43,1,0),(41,2,43,1,0),(42,2,43,10,0),(43,2,44,978,0),(44,3,43,1,0),(45,2,43,1,0),(46,2,43,1,0),(47,2,43,1,0),(48,3,45,1,0),(49,2,45,1,0),(50,2,43,1,0),(51,2,43,1,0),(52,2,43,1,0),(53,2,43,1,0),(54,2,43,1,0),(55,2,43,1,0),(56,2,43,988,0),(57,2,43,989,0),(58,2,43,1,0),(59,2,43,998,0),(60,2,43,999,0),(61,2,43,1,0),(62,2,43,998,0),(63,2,43,999,0),(74,1,51,1,0),(75,2,51,1,0),(76,3,51,999,0),(77,1,51,1,0),(78,2,51,1,0),(79,3,51,999,0);
/*!40000 ALTER TABLE `Commandes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Messages`
--

DROP TABLE IF EXISTS `Messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Messages` (
                            `id` int(11) NOT NULL AUTO_INCREMENT,
                            `nom` varchar(255) NOT NULL,
                            `texte` text NOT NULL,
                            `date_envoi` datetime NOT NULL,
                            PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Messages`
--

LOCK TABLES `Messages` WRITE;
/*!40000 ALTER TABLE `Messages` DISABLE KEYS */;
INSERT INTO `Messages` VALUES (22,'Compte A','hey B','2024-12-12 01:24:05'),(23,'Compte B','hey','2024-12-12 01:24:16'),(24,'Compte A','d','2024-12-12 01:24:25'),(25,'Compte A','c','2024-12-12 01:24:40');
/*!40000 ALTER TABLE `Messages` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-12-15 22:34:27
