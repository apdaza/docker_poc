
DROP TABLE IF EXISTS `inventario_equipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario_equipo` (
  `ine_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del nombre del equipo',
  `ine_nombre` varchar(50) NOT NULL COMMENT 'Nombre del equipo',
  `ine_reposicion` int(11) NOT NULL COMMENT 'tiempo de reposicion en años',
  PRIMARY KEY (`ine_id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1 COMMENT='contiene los nombres de los equipos que pertenecen al inventario';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario_equipo`
--

LOCK TABLES `inventario_equipo` WRITE;
/*!40000 ALTER TABLE `inventario_equipo` DISABLE KEYS */;
INSERT INTO `inventario_equipo` VALUES (1,'ACCES POINT',3),(2,'AIRE ACONDICIONADO',3),(3,'BALANCEADOR DE CARGA',3),(4,'CAMARA',3),(5,'CAMARA D CCTV',3),(6,'CHASIS BLADE',3),(7,'CONSOLA DE CONTROL DE ACCESO',3),(8,'CONSOLA DE MONITOREO',3),(9,'DIGITALIZADOR DE FIRMA',3),(10,'DISPOSITIVO LECTOR DE HUELLA',3),(11,'IMPRESORA',3),(12,'MODEM',3),(13,'MONITOR CCTV',3),(14,'MOUSE',3),(15,'PISTOLA LECTORA',3),(16,'ROUTER',3),(17,'SWITCH OT',3),(18,'TECLADO',3),(19,'TELEFONO',3),(20,'TELEFONO IP',3),(21,'UPS',3),(22,'CAMARA + BASE METALICA',3),(23,'COMPUTADOR',3),(24,'IMPRESORA DE SUSTRATOS',3),(25,'BALANCEADOR TRAFICO',3),(26,'SERVIDOR',3),(27,'MONITOR',3),(28,'DISPOSITIVO DE ALMACENAMIENTO',3),(29,'GABINETE',3),(30,'LIBRERÍA CINTAS',3),(31,'FIREWALL',3),(32,'SWITCH CENTRAL',3),(33,'ROUTER CENTRAL',3),(34,'IPS',3),(35,'CORRELACIONADOR EVENTOS',3),(36,'SWITCH SAN FIBRA',3),(37,'DRIVE LIBRERÍA',3);
/*!40000 ALTER TABLE `inventario_equipo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario_estado`
--

DROP TABLE IF EXISTS `inventario_estado`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario_estado` (
  `ies_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado del equipo',
  `ies_nombre` varchar(50) NOT NULL COMMENT 'Nombre del estado',
  PRIMARY KEY (`ies_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1 COMMENT='contiene los estados de los equipos que pertenecen al inventario';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario_estado`
--

LOCK TABLES `inventario_estado` WRITE;
/*!40000 ALTER TABLE `inventario_estado` DISABLE KEYS */;
INSERT INTO `inventario_estado` VALUES (1,'SIN verificar por Interventoria (En sitio)'),(2,'Verificado por Interventoria (En sitio en uso)'),(3,'SIN verificar por Interventoria (En bodega)'),(4,'Verificado por Interventoria (En bodega)'),(5,'SIN verificar por Interventoria (Destruido)'),(6,'Verificado por Interventoria (Destruido)'),(7,'SIN verificar por Interventoria (Vendido)'),(8,'Verificado por Interventoria (Vendido)'),(9,'Verificado por Interventoria (En sitio sin uso)'),(10,'SIN verificar por Interventoria (No encontrado en '),(11,'No se aprecia'),(12,'No tiene');
/*!40000 ALTER TABLE `inventario_estado` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario_marca`
--

DROP TABLE IF EXISTS `inventario_marca`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario_marca` (
  `inm_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la marca',
  `inm_nombre` varchar(50) NOT NULL COMMENT 'Nombre dela marca',
  PRIMARY KEY (`inm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1 COMMENT='contiene las marcas de los equipos que pertenecen al inventario';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario_marca`
--

LOCK TABLES `inventario_marca` WRITE;
/*!40000 ALTER TABLE `inventario_marca` DISABLE KEYS */;
INSERT INTO `inventario_marca` VALUES (1,'HP'),(2,'DATALOGIC GRYPHON'),(3,'EPAD LINK'),(4,'LOGITECH'),(5,'SAGEM'),(6,'CISCO'),(7,'OKI'),(8,'SAFRAN '),(9,'IDENTICA'),(10,'POWER WARE'),(11,'EMERSON'),(12,'SYMBOL'),(13,'ENERGEX'),(14,'DATACARD'),(15,'LENOVO '),(16,'GENIUS '),(17,'F5'),(18,'IBM'),(19,'CHECKPOINT');
/*!40000 ALTER TABLE `inventario_marca` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario_grupo`
--

DROP TABLE IF EXISTS `inventario_grupo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario_grupo` (
  `ivg_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del grupo de inventario',
  `ivg_nombre` varchar(50) NOT NULL COMMENT 'Nombre del grupo de inventario',
  PRIMARY KEY (`ivg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1 COMMENT='Contiene los grupos de inventarios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario_grupo`
--

LOCK TABLES `inventario_grupo` WRITE;
/*!40000 ALTER TABLE `inventario_grupo` DISABLE KEYS */;
INSERT INTO `inventario_grupo` VALUES (1,'Data Center 1'),(2,'Data Center 2'),(3,'Telemática'),(4,'C4'),(5,'Agencias');
/*!40000 ALTER TABLE `inventario_grupo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario_involucrado`
--

DROP TABLE IF EXISTS `inventario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario` (
  `ini_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del inventario',
  `ine_id` int(2) NOT NULL COMMENT 'Id del equipo',
  `inm_id` int(2) NOT NULL COMMENT 'Id de la marca',
  `ini_modelo` varchar(35) NOT NULL COMMENT 'Modelo del equipo',
  `ini_serie` varchar(25) NOT NULL COMMENT 'Numero de serie del equipo',
  `ini_placa` int(8) DEFAULT NULL COMMENT 'Placa del equipo',
  `ini_fecha_compra` date NOT NULL COMMENT 'Fecha de compra del equipo',
  `ies_id` int(2) NOT NULL COMMENT 'Estado del equipo',
  `ivg_id` int(11) NOT NULL COMMENT 'Id del grupo de inventario',
  PRIMARY KEY (`ini_id`),
  UNIQUE KEY `INI_PLACA` (`ini_placa`),
  KEY `FK_EQUIPO` (`ine_id`),
  KEY `FK_MARCA` (`inm_id`),
  KEY `FK_ESTADO` (`ies_id`),
  KEY `FK_GRUPO` (`ivg_id`),
  CONSTRAINT `inventario_ibfk_1` FOREIGN KEY (`ine_id`) REFERENCES `inventario_equipo` (`ine_id`),
  CONSTRAINT `inventario_ibfk_2` FOREIGN KEY (`inm_id`) REFERENCES `inventario_marca` (`inm_id`),
  CONSTRAINT `inventario_ibfk_3` FOREIGN KEY (`ies_id`) REFERENCES `inventario_estado` (`ies_id`),
  CONSTRAINT `inventario_ibfk_4` FOREIGN KEY (`ivg_id`) REFERENCES `inventario_grupo` (`ivg_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='contiene los inventarios de la concesion';
/*!40101 SET character_set_client = @saved_cs_client */;

-------------------------------------------------------
--
-- Table structure for table `inventario_soporte`
--

DROP TABLE IF EXISTS `inventario_soporte`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario_soporte` (
  `ins_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del soporte',
  `ini_id` int(11) NOT NULL COMMENT 'Id del inventario',
  `ist_id` int(1) NOT NULL COMMENT 'Id del tipo de soporte',
  `ins_archivo` varchar(200) NOT NULL COMMENT 'Nombre del archivo',
  PRIMARY KEY (`ins_id`),
  UNIQUE KEY `UK_ARCHIVO` (`ins_archivo`),
  KEY `FK_SOPORTE_TIPO` (`ist_id`),
  KEY `FK_INVENTARIO` (`ini_id`),
  CONSTRAINT `inventario_soporte_ibfk_1` FOREIGN KEY (`ist_id`) REFERENCES `inventario_soporte_tipo` (`ist_id`),
  CONSTRAINT `inventario_soporte_ibfk_2` FOREIGN KEY (`ini_id`) REFERENCES `inventario_involucrado` (`ini_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los soportes de los equipos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario_soporte`
--

LOCK TABLES `inventario_soporte` WRITE;
/*!40000 ALTER TABLE `inventario_soporte` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventario_soporte` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventario_soporte_tipo`
--

DROP TABLE IF EXISTS `inventario_soporte_tipo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventario_soporte_tipo` (
  `ist_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Id del tipo de soporte',
  `ist_nombre` varchar(50) NOT NULL COMMENT 'Nombre del tipo de soporte',
  PRIMARY KEY (`ist_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los tipos de soportes';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventario_soporte_tipo`
--

LOCK TABLES `inventario_soporte_tipo` WRITE;
/*!40000 ALTER TABLE `inventario_soporte_tipo` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventario_soporte_tipo` ENABLE KEYS */;
UNLOCK TABLES;


-- falta ejecutar
ALTER TABLE `inventario` CHANGE `ini_placa` `ini_placa` VARCHAR(15) NULL DEFAULT NULL COMMENT 'Placa del equipo';
ALTER TABLE `inventario` CHANGE `ini_fecha_compra` `ini_fecha_compra` DATE NULL COMMENT 'Fecha de compra del equipo';
ALTER TABLE `inventario` ADD `ini_descripcion` VARCHAR(150) NULL COMMENT 'descripción del elemento' AFTER `ivg_id`;
