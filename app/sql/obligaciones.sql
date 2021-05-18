DROP TABLE IF EXISTS `obligacion_anio`;
CREATE TABLE `obligacion_anio` (
  `oba_id` int(4) NOT NULL COMMENT 'Identificador del anio de reporte de obligaciones',
  `oba_anio` int(11) NOT NULL COMMENT 'Anio de reporte',
  PRIMARY KEY (`oba_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 COMMENT='Contiene los años de reporte de obligaciones';

INSERT INTO `obligacion_anio` VALUES (1,2018),(2,2019),(3,2020),(4,2021),(5,2022);

DROP TABLE IF EXISTS `obligacion_mes`;
CREATE TABLE `obligacion_mes` (
  `obm_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del mes de reporte de obligaciones',
  `obm_mes` varchar(3) NOT NULL COMMENT 'Nombre del mes de reporte de obligaciones',
  PRIMARY KEY (`obm_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 COMMENT='Contiene los meses de reporte de obligaciones';
INSERT INTO `obligacion_mes` VALUES (1,'Ene'),(2,'Feb'),(3,'Mar'),(4,'Abr'),(5,'May'),(6,'Jun'),(7,'Jul'),(8,'Ago'),(9,'Sep'),(10,'Oct'),(11,'Nov'),(12,'Dic');

DROP TABLE IF EXISTS `obligacion_periodicidad`;
CREATE TABLE `obligacion_periodicidad` (
  `obp_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la periodicidad',
  `obp_nombre` varchar(50) NOT NULL COMMENT 'Nombre de la periodicidad',
  PRIMARY KEY (`obp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 COMMENT='Contiene las periodicidades con que se verifica una obligacion';
INSERT INTO `obligacion_periodicidad` VALUES (1,'Mensual'),(2,'Bimensual (o cuando se presenten actualizaciones)'),(3,'Semestral (o cuando se presenten actualizaciones)'),(4,'Anual'),(5,'No aplica'),(6,'Por demanda'),(7,'Por cierre de fase'),(8,'Trimestral');

DROP TABLE IF EXISTS `obligacion_clausula`;
CREATE TABLE `obligacion_clausula` (
  `obc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la clausula',
  `obc_nombre` varchar(50) NOT NULL COMMENT 'Nombre de la clausula',
  PRIMARY KEY (`obc_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='Contiene las clausulas del contrato';

DROP TABLE IF EXISTS `obligacion_componente`;
CREATE TABLE `obligacion_componente` (
  `oco_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del componente',
  `oco_nombre` varchar(50) NOT NULL COMMENT 'Nombre del componente',
  PRIMARY KEY (`oco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 COMMENT='Contiene los componentes del contrato';

INSERT INTO `obligacion_componente` VALUES (1,'Juridico'),(2,'Financiero'),(4,'Técnico - Software'),(5,'Técnico - Base de Datos'),(6,'Técnico - Infrae. Central'),(7,'Técnico - Seguridad'),(8,'Técnico - Operacion'),(9,'Transversal'),(10,'Técnico - Auditoría'),(11,'Administrativo '),(12,'Técnico - Conectividad'),(13,'Técnico - Infrae. Distribuida');

DROP TABLE IF EXISTS `obligacion_estado`;
CREATE TABLE `obligacion_estado` (
  `obe_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado',
  `obe_nombre` varchar(50) NOT NULL COMMENT 'Nombre del estado',
  PRIMARY KEY (`obe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 COMMENT='Contiene los estados de la obligacion';

INSERT INTO `obligacion_estado` VALUES (1,'Cumple'),(2,'No cumple'),(3,'En proceso de Verificacion'),(4,'No aplica (conceptuado por anterior Interventoria)'),(5,'Posible incumplimiento');


DROP TABLE IF EXISTS `obligacion_concesion`;
CREATE TABLE `obligacion_concesion` (
  `ocs_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la obligacion',
  `obc_id` int(11) NOT NULL COMMENT 'Id de la clausula',
  `oco_id` int(11) NOT NULL COMMENT 'Id del componente',
  `ocs_literal` varchar(150) NOT NULL COMMENT 'literal que menciona la obligacion',
  `ocs_descripcion` text NOT NULL COMMENT 'Descripcion de la obligacion',
  `obp_id` int(1) NOT NULL COMMENT 'Id de la periodicidad',
  `ocs_criterio` text NOT NULL COMMENT 'Criterio de aceptacion',
  PRIMARY KEY (`ocs_id`),
  UNIQUE KEY `UK_LITERAL` (`ocs_literal`),
  KEY `FK_CLAUSULA` (`obc_id`),
  KEY `FK_COMPONENTE` (`oco_id`),
  KEY `FK_PERIODICIDAD` (`obp_id`),
  CONSTRAINT `obligacion_concesion_ibfk_1` FOREIGN KEY (`obc_id`) REFERENCES `obligacion_clausula` (`obc_id`),
  CONSTRAINT `obligacion_concesion_ibfk_2` FOREIGN KEY (`oco_id`) REFERENCES `obligacion_componente` (`oco_id`),
  CONSTRAINT `obligacion_concesion_ibfk_4` FOREIGN KEY (`obp_id`) REFERENCES `obligacion_periodicidad` (`obp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='Contiene las obligaciones de la concesion';

DROP TABLE IF EXISTS `obligacion_interventoria`;
CREATE TABLE `obligacion_interventoria` (
  `obi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la obligacion',
  `obc_id` int(11) NOT NULL COMMENT 'Id de la clausula',
  `oco_id` int(11) NOT NULL COMMENT 'Id del componente',
  `obi_literal` varchar(150) NOT NULL COMMENT 'literal que menciona la obligacion',
  `obi_descripcion` text NOT NULL COMMENT 'Descripcion de la obligacion',
  PRIMARY KEY (`obi_id`),
  UNIQUE KEY `UK_LITERAL` (`obi_literal`),
  KEY `FK_CLAUSULA` (`obc_id`),
  KEY `FK_COMPONENTE` (`oco_id`),
  CONSTRAINT `obligacion_interventoria_ibfk_1` FOREIGN KEY (`obc_id`) REFERENCES `obligacion_clausula` (`obc_id`),
  CONSTRAINT `obligacion_interventoria_ibfk_2` FOREIGN KEY (`oco_id`) REFERENCES `obligacion_componente` (`oco_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1 COMMENT='Contiene las obligaciones de la interventoria';

DROP TABLE IF EXISTS `obligacion_conc_int`;
CREATE TABLE `obligacion_conc_int` (
  `oci_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la relacion',
  `ocs_id` int(11) NOT NULL COMMENT 'Id de la obligacion de la concesión',
  `obi_id` int(11) NOT NULL COMMENT 'Id de la obligación de la Interventoría',
  PRIMARY KEY (`oci_id`),
  UNIQUE KEY `UK_OBL_CSC_INT` (`ocs_id`,`obi_id`),
  KEY `FK_OBL_CSC` (`ocs_id`),
  KEY `FK_OBL_INT` (`obi_id`),
  CONSTRAINT `obligacion_conc_int_ibfk_1` FOREIGN KEY (`ocs_id`) REFERENCES `obligacion_concesion` (`ocs_id`),
  CONSTRAINT `obligacion_conc_int_ibfk_2` FOREIGN KEY (`obi_id`) REFERENCES `obligacion_interventoria` (`obi_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='Contiene las relaciones entre las obligaciones de la Concesion y las de Interven';

DROP TABLE IF EXISTS `obligacion_concesion_traza`;
CREATE TABLE `obligacion_concesion_traza` (
  `oct_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la trazabilidad',
  `ocs_id` int(11) NOT NULL COMMENT 'Id de la obligacion',
  `obe_id` int(1) NOT NULL COMMENT 'Id del estado',
  `oct_anio` int(4) NOT NULL COMMENT 'Año para el que se reporta la traza',
  `oct_mes` int(2) NOT NULL COMMENT 'Mes para el que se reporta la traza',
  `oct_evidencia` text NOT NULL COMMENT 'Evidencia de la traza',
  `oct_gestion` text NOT NULL COMMENT 'Gestion realizada para la verificacion',
  `oct_archivo` varchar(200) NOT NULL COMMENT 'Archivo de la evidencia',
  `oct_recomendacion` text NOT NULL COMMENT 'Recomendacion',
  PRIMARY KEY (`oct_id`),
  UNIQUE KEY `UK_TRAZA` (`ocs_id`,`oct_anio`,`oct_mes`),
  KEY `FK_OBLIGACION_CONCESION` (`ocs_id`),
  KEY `FK_ESTADO` (`obe_id`),
  CONSTRAINT `obligacion_concesion_traza_ibfk_1` FOREIGN KEY (`ocs_id`) REFERENCES `obligacion_concesion` (`ocs_id`),
  CONSTRAINT `obligacion_concesion_traza_ibfk_3` FOREIGN KEY (`obe_id`) REFERENCES `obligacion_estado` (`obe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 COMMENT='Contiene la trazabilidad de la obligacion mes por mes';
