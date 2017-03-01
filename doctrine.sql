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
-- Table structure for table `categorias`
--

DROP TABLE IF EXISTS `categorias`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `categorias` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categorias`
--

LOCK TABLES `categorias` WRITE;
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` VALUES (1,'Roupas'),(2,'CalÃ§ados'),(3,'Bebidas com Ã¡lcool'),(4,'Frios'),(5,'MÃ³veis'),(6,'EletrodomÃ©sticos'),(7,'Artesanato'),(8,'Games'),(10,'Instrumentos musicais'),(11,'Automotivo'),(12,'Celulares'),(13,'InformÃ¡tica'),(14,'RobÃ³tica'),(15,'Camping');
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;
UNLOCK TABLES;

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

--
-- Table structure for table `produtos`
--

DROP TABLE IF EXISTS `produtos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) DEFAULT NULL,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `descricao` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valor` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `IDX_3E524353397707A` (`categoria_id`),
  CONSTRAINT `FK_3E524353397707A` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos`
--

LOCK TABLES `produtos` WRITE;
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` VALUES (1,3,'Vinho Chardonnay','VilcÃºn Chardonnay 2014 - 750ml','R$ 32,00'),(2,3,'Vinho Malbec','Altivo Classic Malbec 2015 750ml','R$ 42,00'),(3,3,'Vinho Tannat','ViÃ±edo de Los Vientos Alcyone Tannat Dessert Wine 500ml','R$ 79,00'),(4,1,'Bermuda','BERMUDA CARGO BÃSICA COM CINTO','R$ 69,90'),(5,1,'Camisa','Camisa em sarja com bolsos','R$ 139,00'),(6,6,'FogÃ£o a gÃ¡s','FogÃ£o de Piso Electrolux 76DFX 5 Bocas com Duplo Forno, Grill ElÃ©trico, Timer Digital Painel Blue Touch, Inox','R$ 2599,00'),(7,6,'Geladeira/ Refrigerador','Electrolux Frost Free DW42X 380L Inox','R$ 2072,94'),(8,6,'Lavadora','Roupas Electrolux 13kg Turbo Secagem LTD13 Branco','R$ 1269,00'),(9,10,'Piano','Marca Rhodes, 500 teclas, nas cores branco e black piano','R$ 2521,99'),(10,8,'Euro Truck','Game : Euro Truck Simulator - Going East - Simulador de caminhÃµes','R$ 28,00'),(11,5,'ColchÃ£o','ColchÃ£o Solteiro Ortobom Physical Spring Black Molas Nanolastic','R$ 302,00');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `produtos_tags`
--

DROP TABLE IF EXISTS `produtos_tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `produtos_tags` (
  `produto_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  PRIMARY KEY (`produto_id`,`tag_id`),
  KEY `IDX_F00CAA2A105CFD56` (`produto_id`),
  KEY `IDX_F00CAA2ABAD26311` (`tag_id`),
  CONSTRAINT `FK_F00CAA2A105CFD56` FOREIGN KEY (`produto_id`) REFERENCES `produtos` (`id`),
  CONSTRAINT `FK_F00CAA2ABAD26311` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `produtos_tags`
--

LOCK TABLES `produtos_tags` WRITE;
/*!40000 ALTER TABLE `produtos_tags` DISABLE KEYS */;
INSERT INTO `produtos_tags` VALUES (1,2),(1,5),(2,3),(2,4),(3,1),(3,6),(4,2),(4,5),(5,1),(5,3),(5,6),(6,3),(6,8),(7,3),(7,8),(8,1),(8,2),(8,3),(8,8),(9,1),(9,2),(9,3),(9,4),(10,8),(10,10),(10,11),(11,4),(11,5),(11,6);
/*!40000 ALTER TABLE `produtos_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'Novo'),(2,'PromoÃ§Ã£o'),(3,'Nacional'),(4,'Produto OrgÃ¢nico'),(5,'Importado'),(6,'Especial'),(7,'Fabricado na China'),(8,'Garantia Estendida'),(10,'Educacional'),(11,'Livre'),(12,'Zona Franca Manaus'),(13,'Madeira de Lei'),(14,'TransgÃªnico');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-03-01 12:58:31
