-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: localhost    Database: trilhando_doctrine
-- ------------------------------------------------------
-- Server version	5.7.12-0ubuntu1.1

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
-- Table structure for table `clientes`
--

DROP TABLE IF EXISTS `clientes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `clientes`
--

LOCK TABLES `clientes` WRITE;
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` VALUES (1,'Valdomiro Zanin','elenaotem@email.com'),(2,'Esmeraldina de Moraes','esmeraldinam@rmail.com'),(3,'Joana de Barro','baresa@gmail.com'),(4,'JoÃ£o de Barro Mole','joaodbmole@barro.com'),(5,'JoÃ£o de Barro Engenheiro','joaodbeng@gmail.com'),(6,'JoÃ£o de Barro3','jao3@barro.com'),(7,'JoÃ£o de Barro4','jao4@barro.com'),(8,'JoÃ£o de Barro5','jao5@barro.com'),(9,'JoÃ£o de Barro6','jao6@barro.com'),(10,'JoÃ£o de Barro7','jao7@barro.com'),(11,'JoÃ£o de Barro8','jao8@barro.com'),(12,'JoÃ£o de Barro9','jao9@barro.com'),(13,'JoÃ£o de Barro Cauim','joaodbc@barro.com'),(14,'JoÃ£o de Barro11','jao10@barro.com'),(15,'JoÃ£o de Barro12','jao10@barro.com'),(16,'JoÃ£o de Barro13','jao10@barro.com'),(17,'JoÃ£o de Barro14','jao10@barro.com'),(18,'JoÃ£o de Barro15','jao10@barro.com'),(19,'JoÃ£o de Barro16','jao10@barro.com'),(20,'JoÃ£o de Barro17','jao10@barro.com'),(21,'JoÃ£o de Barro18','jao10@barro.com'),(22,'JoÃ£o de Barro19','jao10@barro.com'),(23,'JoÃ£o de Barro20','jao10@barro.com'),(24,'JoÃ£o de Barro21','jao10@barro.com'),(25,'JoÃ£o de Barro22','jao10@barro.com'),(26,'JoÃ£o de Barro23','jao10@barro.com'),(27,'JoÃ£o de Barro24','jao10@barro.com'),(28,'JoÃ£o de Barro25','jao10@barro.com'),(29,'JoÃ£o de Barro26','jao10@barro.com'),(30,'JoÃ£o de Barro27','jao10@barro.com'),(31,'JoÃ£o de Barro28','jao10@barro.com'),(32,'JoÃ£o de Barro29','jao10@barro.com'),(33,'Marlon Severino','marlosev@gmail.com'),(34,'Jarles Pingo','jarlespingo@gmail.com'),(35,'Marcelo Stramari','marcelo@gmail.com'),(37,'Taline da Gama','taline.dagama@email.com');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-16 13:07:19
