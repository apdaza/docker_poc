-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 03, 2019 at 07:45 PM
-- Server version: 10.1.29-MariaDB-6ubuntu2
-- PHP Version: 7.2.10-0ubuntu1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `madeopen_kbt`
--

-- --------------------------------------------------------

--
-- Table structure for table `alcance`
--

CREATE TABLE `alcance` (
  `alc_id` int(11) NOT NULL COMMENT 'Identificador del alcance a controlar',
  `alc_nombre` varchar(50) NOT NULL COMMENT 'Nombre de la solucion',
  `ale_id` int(1) NOT NULL COMMENT 'Estado del alcance',
  `alc_fecha_registro` date NOT NULL COMMENT 'Fecha de puesto el requerimiento/alcance',
  `alc_observaciones` varchar(500) NOT NULL COMMENT 'Observaciones al alcance',
  `deq_id_contratante` int(11) NOT NULL COMMENT 'Id del contratante responsable',
  `deq_id_contratista` int(11) NOT NULL COMMENT 'Id del contratista responsable',
  `alc_reunion` varchar(25) NOT NULL COMMENT 'fecha de las reuniones',
  `deq_id_interventoria` int(11) NOT NULL COMMENT 'Id del interventor responsable',
  `ope_id` int(11) NOT NULL COMMENT 'Id del operador',
  `alc_registro` varchar(1) NOT NULL DEFAULT 'N' COMMENT 'Indicador de si es tipo registro o no',
  `alc_tema` varchar(1) NOT NULL DEFAULT 'S' COMMENT 'Indicador de si es tema o no'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los alcances a controlar';

-- --------------------------------------------------------

--
-- Table structure for table `alcance_estado`
--

CREATE TABLE `alcance_estado` (
  `ale_id` int(1) NOT NULL COMMENT 'Identificador del estado del alcance',
  `ale_nombre` varchar(50) NOT NULL COMMENT 'Nombre del estado del alcance'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los estados de los alcances';

--
-- Dumping data for table `alcance_estado`
--

INSERT INTO `alcance_estado` (`ale_id`, `ale_nombre`) VALUES
(1, 'En desarrollo'),
(2, 'En piloto'),
(3, 'En produccion'),
(4, 'En operacion');

-- --------------------------------------------------------

--
-- Table structure for table `compromiso`
--

CREATE TABLE `compromiso` (
  `com_id` int(11) NOT NULL COMMENT 'Identificador del compromiso',
  `com_actividad` text NOT NULL COMMENT 'Actividad que debe ejecutar',
  `doc_id` int(11) NOT NULL COMMENT 'Id del documento que generó el compromiso',
  `com_fecha_limite` date NOT NULL COMMENT 'Fecha limite de cumplimiento del compromiso',
  `com_fecha_entrega` date NOT NULL COMMENT 'Fecha real de cumplimiento del compromiso',
  `ces_id` int(1) NOT NULL COMMENT 'Id del estado del compromiso',
  `com_observaciones` text NOT NULL COMMENT 'Observaciones del compromiso',
  `ope_id` int(2) NOT NULL COMMENT 'Id del operador responsable del compromiso'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los compromisos de las reuniones';

--
-- Dumping data for table `compromiso`
--

INSERT INTO `compromiso` (`com_id`, `com_actividad`, `doc_id`, `com_fecha_limite`, `com_fecha_entrega`, `ces_id`, `com_observaciones`, `ope_id`) VALUES
(1, 'adfaf-asdfkaskflj', 1, '2019-02-03', '2019-02-03', 5, 'dfkasdlkfjalskdfjadsjfl', 1);

-- --------------------------------------------------------

--
-- Table structure for table `compromiso_estado`
--

CREATE TABLE `compromiso_estado` (
  `ces_id` int(1) NOT NULL COMMENT 'Identificador del estado del compromiso',
  `ces_nombre` varchar(30) NOT NULL COMMENT 'Nombre del estado del compromiso'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los estados de los compromisos';

--
-- Dumping data for table `compromiso_estado`
--

INSERT INTO `compromiso_estado` (`ces_id`, `ces_nombre`) VALUES
(5, 'Abierto'),
(6, 'Cerrado'),
(7, 'Cancelado');

-- --------------------------------------------------------

--
-- Table structure for table `compromiso_responsable`
--

CREATE TABLE `compromiso_responsable` (
  `cor_id` int(11) NOT NULL COMMENT 'Identificador del responsable',
  `com_id` int(11) NOT NULL COMMENT 'Id del compromiso',
  `doa_id` int(11) NOT NULL COMMENT 'Id del actor responsable de este compromiso'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los responsables de los compromisos';

--
-- Dumping data for table `compromiso_responsable`
--

INSERT INTO `compromiso_responsable` (`cor_id`, `com_id`, `doa_id`) VALUES
(1, 1, 2),
(2, 1, 8);

-- --------------------------------------------------------

--
-- Table structure for table `compromiso_resumen`
--

CREATE TABLE `compromiso_resumen` (
  `cor_nombre_tmp` varchar(200) NOT NULL COMMENT 'Nombre temporal de los responsables',
  `ces_1` int(3) NOT NULL COMMENT 'Id del estado 1',
  `ces_2` int(3) NOT NULL COMMENT 'Id del estado 2',
  `ces_3` int(3) NOT NULL COMMENT 'Id del estado 3',
  `ope_id` int(11) NOT NULL COMMENT 'Id del operador responsable'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla temporal para visualizar el resumen de compromisos';

-- --------------------------------------------------------

--
-- Table structure for table `departamento`
--

CREATE TABLE `departamento` (
  `dep_id` varchar(2) NOT NULL DEFAULT '' COMMENT 'codigo dane del departamento',
  `dep_nombre` varchar(60) NOT NULL DEFAULT '' COMMENT 'nombre del departamento',
  `ope_id` int(1) NOT NULL,
  `dpr_id` int(1) NOT NULL COMMENT 'Id de la region'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='contiene los departamentos';

--
-- Dumping data for table `departamento`
--

INSERT INTO `departamento` (`dep_id`, `dep_nombre`, `ope_id`, `dpr_id`) VALUES
('05', 'ANTIOQUIA', 1, 3),
('08', 'ATLÁNTICO', 1, 1),
('11', 'BOGOTÁ', 1, 2),
('13', 'BOLIVAR', 1, 1),
('15', 'BOYACÁ', 1, 2),
('17', 'CALDAS', 1, 3),
('18', 'CAQUETÁ', 1, 5),
('19', 'CAUCA', 1, 5),
('20', 'CESAR', 1, 1),
('23', 'CÓRDOBA', 1, 1),
('25', 'CUNDINAMARCA', 1, 2),
('27', 'CHOCÓ', 1, 3),
('41', 'HUILA', 1, 5),
('44', 'LA GUAJIRA', 1, 1),
('47', 'MAGDALENA', 1, 1),
('50', 'META', 1, 2),
('52', 'NARIÑO', 1, 5),
('54', 'NORTE DE SANTANDER', 1, 4),
('63', 'QUINDIO', 1, 3),
('66', 'RISARALDA', 1, 3),
('68', 'SANTANDER', 1, 4),
('70', 'SUCRE', 1, 1),
('73', 'TOLIMA', 1, 2),
('76', 'VALLE DEL CAUCA', 1, 5),
('81', 'ARAUCA', 1, 4),
('85', 'CASANARE', 1, 4),
('86', 'PUTUMAYO', 1, 5),
('88', 'SAN ANDRÉS', 1, 1),
('91', 'AMAZONAS', 1, 5),
('94', 'GUAINÍA', 1, 5),
('95', 'GUAVIARE', 1, 4),
('97', 'VAUPÉS', 1, 5),
('99', 'VICHADA', 1, 4);

-- --------------------------------------------------------

--
-- Table structure for table `departamento_region`
--

CREATE TABLE `departamento_region` (
  `dpr_id` int(1) NOT NULL COMMENT 'Identificador de la region',
  `dpr_nombre` varchar(25) NOT NULL COMMENT 'Nombre de la region'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='contiene las regiones';

--
-- Dumping data for table `departamento_region`
--

INSERT INTO `departamento_region` (`dpr_id`, `dpr_nombre`) VALUES
(1, 'Caribe'),
(2, 'Central'),
(3, 'Centro Occidente'),
(4, 'Centro Oriente'),
(5, 'Sur Occidente');

-- --------------------------------------------------------

--
-- Table structure for table `documento`
--

CREATE TABLE `documento` (
  `doc_id` int(11) NOT NULL COMMENT 'identificador unico del documento',
  `dti_id` int(2) NOT NULL DEFAULT '0' COMMENT 'identificador del tipo de documento',
  `dot_id` int(3) DEFAULT '0' COMMENT 'identificador del tema del documento',
  `dos_id` int(3) NOT NULL DEFAULT '0' COMMENT 'identificador del subtema del documento',
  `doc_fecha` date NOT NULL COMMENT 'fecha de creacion del documento',
  `doc_descripcion` text NOT NULL COMMENT 'descripcion del documento',
  `doc_archivo` varchar(200) NOT NULL COMMENT 'nombre del documento',
  `doc_version` varchar(15) DEFAULT NULL COMMENT 'informacion de la version del documento',
  `doe_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Identificador del tipo de estado',
  `ope_id` int(11) NOT NULL COMMENT 'Identificador del tipo de estado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los documentos soporte del proyecto';

--
-- Dumping data for table `documento`
--

INSERT INTO `documento` (`doc_id`, `dti_id`, `dot_id`, `dos_id`, `doc_fecha`, `doc_descripcion`, `doc_archivo`, `doc_version`, `doe_id`, `ope_id`) VALUES
(1, 2, 5, 83, '2019-02-01', 'wsdsdfzdvzsdv', 'piensa_en_haskell.pdf', '1', 10, 1);

-- --------------------------------------------------------

--
-- Table structure for table `documento_actor`
--

CREATE TABLE `documento_actor` (
  `doa_id` int(3) NOT NULL COMMENT 'Identificador del actor',
  `doa_nombre` varchar(60) NOT NULL DEFAULT '' COMMENT 'Nombre del actor',
  `doa_sigla` varchar(3) NOT NULL DEFAULT '' COMMENT 'Sigla del actor',
  `ope_id` int(11) NOT NULL COMMENT 'Id del operador',
  `dta_id` int(11) NOT NULL COMMENT 'Id del tipo de actor'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los actores responsables de documentos';

--
-- Dumping data for table `documento_actor`
--

INSERT INTO `documento_actor` (`doa_id`, `doa_nombre`, `doa_sigla`, `ope_id`, `dta_id`) VALUES
(1, 'MT-GRUPO KBT', 'MT', 1, 1),
(2, 'CONCESION KBT', 'CSR', 1, 2),
(3, 'FIDUCIARIA', 'FDV', 1, 3),
(4, 'KBT', 'KBT', 1, 4),
(5, 'TERCEROS', 'TER', 1, 3),
(6, 'SUBDIR PLANTA', 'PLT', 1, 5),
(7, 'SUBDIR OPERACION', 'SOP', 1, 5),
(8, 'INFORMATICA', 'INF', 1, 5),
(9, 'FINANCIERA', 'STF', 1, 5),
(10, 'GRUPO OPERACION', 'GOP', 1, 5);

-- --------------------------------------------------------

--
-- Table structure for table `documento_articulo`
--

CREATE TABLE `documento_articulo` (
  `doa_id` int(2) NOT NULL COMMENT 'Identificador del articulo',
  `doa_nombre` varchar(150) DEFAULT NULL COMMENT 'Identificador del articulo',
  `doa_descripcion` text NOT NULL COMMENT 'Descripcion del articulo',
  `doc_id` int(11) NOT NULL COMMENT 'Id del documento',
  `alc_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los articulos de la normatividad del RUNT';

-- --------------------------------------------------------

--
-- Table structure for table `documento_comunicado`
--

CREATE TABLE `documento_comunicado` (
  `doc_id` int(11) NOT NULL COMMENT 'identificador unico del comunicado',
  `dti_id` int(2) NOT NULL DEFAULT '0' COMMENT 'identificador del tipo de comunicado',
  `dot_id` int(3) DEFAULT '0' COMMENT 'identificador del tema del comunicado',
  `dos_id` int(3) NOT NULL DEFAULT '0' COMMENT 'identificador del subtema del comunicado',
  `doa_id_autor` int(3) NOT NULL DEFAULT '0' COMMENT 'identificador del autor del comunicado',
  `doa_id_dest` int(3) NOT NULL DEFAULT '0' COMMENT 'identificador del destinatario del comunicado',
  `doc_fecha_radicado` date NOT NULL DEFAULT '0000-00-00' COMMENT 'fecha de radicado del comunicado',
  `doc_referencia` varchar(30) NOT NULL COMMENT 'referencia del comunicado',
  `doc_descripcion` text NOT NULL COMMENT 'descripcion del comunicado',
  `doc_archivo` varchar(200) NOT NULL COMMENT 'nombre del comunicado',
  `usu_id` int(11) NOT NULL DEFAULT '1' COMMENT 'responsable del comunicado y respuesta sobre este',
  `doc_fecha_respuesta` date DEFAULT NULL COMMENT 'fecha de respuesta al comunicado si esta es requerida',
  `doc_alarma` int(1) NOT NULL DEFAULT '2' COMMENT '1 si esta activa la alarma 2 si ya fue desactivada',
  `doc_fecha_respondido` date DEFAULT '0000-00-00' COMMENT 'Fecha en la que se repondel el comunicado',
  `doc_referencia_respondido` int(11) DEFAULT NULL COMMENT 'referencia con la que se reponde el comunicado',
  `ope_id` int(11) NOT NULL COMMENT 'Identificador del tipo de estado',
  `der_id` int(1) NOT NULL COMMENT 'Id del estado de la respuesta'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `documento_comunicado`
--

INSERT INTO `documento_comunicado` (`doc_id`, `dti_id`, `dot_id`, `dos_id`, `doa_id_autor`, `doa_id_dest`, `doc_fecha_radicado`, `doc_referencia`, `doc_descripcion`, `doc_archivo`, `usu_id`, `doc_fecha_respuesta`, `doc_alarma`, `doc_fecha_respondido`, `doc_referencia_respondido`, `ope_id`, `der_id`) VALUES
(12344, 2, 4, 7, 2, 4, '2019-02-01', '123-CSR-RDC-000-19', 'fzcvzxcvzxcv', 'criptografia_simetrica.pdf', 98, '0000-00-00', 2, '0000-00-00', NULL, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `documento_comunicado_soporte`
--

CREATE TABLE `documento_comunicado_soporte` (
  `dcs_id` int(11) NOT NULL COMMENT 'Identificador del soporte',
  `doc_id` int(11) NOT NULL COMMENT 'Id del comunicado',
  `dcs_archivo` varchar(100) NOT NULL COMMENT 'Nombre del archivo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los soportes de los recursos';

-- --------------------------------------------------------

--
-- Table structure for table `documento_equipo`
--

CREATE TABLE `documento_equipo` (
  `deq_id` int(11) NOT NULL COMMENT 'Identificador de los equipos',
  `doa_id` int(3) NOT NULL COMMENT 'Id del actor destinatario',
  `usu_id` int(11) NOT NULL COMMENT 'Id del usuario',
  `deq_controla_alarmas` varchar(1) NOT NULL COMMENT 'Indica si el usuario controla alarmas'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los equipos de trabajo por actor';

--
-- Dumping data for table `documento_equipo`
--

INSERT INTO `documento_equipo` (`deq_id`, `doa_id`, `usu_id`, `deq_controla_alarmas`) VALUES
(1, 1, 64, 'S'),
(3, 2, 64, 'S'),
(8, 9, 98, 'S'),
(9, 8, 64, 'S'),
(10, 7, 98, 'S'),
(11, 6, 98, 'S'),
(19, 2, 98, 'N'),
(43, 6, 64, 'S'),
(57, 3, 98, 'N'),
(64, 1, 98, 'N'),
(68, 4, 98, 'X'),
(69, 4, 64, 'X'),
(72, 3, 64, 'S'),
(73, 5, 64, 'N');

-- --------------------------------------------------------

--
-- Table structure for table `documento_estado`
--

CREATE TABLE `documento_estado` (
  `doe_id` int(11) NOT NULL COMMENT 'Identificador del estado de los documentos',
  `doe_nombre` varchar(50) NOT NULL COMMENT 'Nombre del estado de los documentos'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los estados de los documentos';

--
-- Dumping data for table `documento_estado`
--

INSERT INTO `documento_estado` (`doe_id`, `doe_nombre`) VALUES
(1, 'Generada(o)'),
(5, 'Aprobada(o)'),
(6, 'Aprobada(o) RDC'),
(10, 'Firmada(o)'),
(11, 'No aplica'),
(12, 'Anulada(o)');

-- --------------------------------------------------------

--
-- Table structure for table `documento_estado_respuesta`
--

CREATE TABLE `documento_estado_respuesta` (
  `der_id` int(11) NOT NULL COMMENT 'Identificador del estado de las respuestas',
  `der_nombre` varchar(50) NOT NULL COMMENT 'Nombre del estado de las respuestas'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los estados de las respuestas';

--
-- Dumping data for table `documento_estado_respuesta`
--

INSERT INTO `documento_estado_respuesta` (`der_id`, `der_nombre`) VALUES
(1, 'Sin respuesta'),
(2, 'Respuesta con pendientes'),
(3, 'Respuesta sin pendientes'),
(4, 'Respuesta sin confirmar por el lider');

-- --------------------------------------------------------

--
-- Table structure for table `documento_resumen`
--

CREATE TABLE `documento_resumen` (
  `dor_tipo` varchar(200) NOT NULL COMMENT 'Nombre temporal de los tipos',
  `dor_tema` varchar(200) NOT NULL COMMENT 'Nombre temporal de los temas',
  `ces_1` int(3) NOT NULL COMMENT 'Id del estado 1',
  `ces_2` int(3) NOT NULL COMMENT 'Id del estado 2',
  `ces_3` int(3) NOT NULL COMMENT 'Id del estado 3',
  `ces_4` int(3) NOT NULL COMMENT 'Id del estado 4',
  `ces_5` int(3) NOT NULL COMMENT 'Id del estado 5',
  `ces_6` int(3) NOT NULL COMMENT 'Id del estado 6',
  `ces_7` int(3) NOT NULL COMMENT 'Id del estado 7',
  `ces_8` int(3) NOT NULL COMMENT 'Id del estado 8',
  `ces_9` int(3) NOT NULL COMMENT 'Id del estado 9',
  `ces_10` int(3) NOT NULL COMMENT 'Id del estado 10'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla temporal para visualizar el resumen de documentos';

-- --------------------------------------------------------

--
-- Table structure for table `documento_subtema`
--

CREATE TABLE `documento_subtema` (
  `dos_id` int(3) NOT NULL COMMENT 'Identificador del subtema',
  `dot_id` int(2) NOT NULL DEFAULT '0' COMMENT 'Id del tema del documento',
  `dos_nombre` varchar(45) NOT NULL DEFAULT '' COMMENT 'Nombre del subtema'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los subtemas de documentos';

--
-- Dumping data for table `documento_subtema`
--

INSERT INTO `documento_subtema` (`dos_id`, `dot_id`, `dos_nombre`) VALUES
(1, 1, 'CONTRATO'),
(2, 1, 'ANEXOS'),
(3, 2, 'NO APLICA'),
(4, 3, 'GESTION MENSUAL'),
(5, 3, 'OTROS'),
(6, 4, 'ADMINISTRACION '),
(7, 4, 'AMBIENTAL'),
(8, 4, 'FINANCIERO'),
(9, 4, 'INSTALACION'),
(10, 4, 'JURIDICO'),
(11, 4, 'TECNICO-OPERACION'),
(12, 4, 'PLANEACION'),
(13, 4, 'DIVULGACION'),
(14, 4, 'OTROS'),
(15, 5, 'COMITE FIDUCIARIO'),
(16, 5, 'COMITE SEGUIMIENTO CONCESION'),
(17, 5, 'COMITE DIRECTIVO'),
(18, 5, 'MESA DE TRABAJO FINANCIERA'),
(19, 15, 'CALIDAD'),
(31, 9, 'LEY'),
(32, 9, 'RESOLUCION'),
(33, 11, 'TODOS'),
(34, 12, 'OTRAS'),
(35, 4, 'TECNICO-SOFTWARE'),
(36, 8, 'GESTION MENSUAL'),
(37, 5, 'COMITE SEGUIMIENTO INTERVENTORIA'),
(38, 5, 'MESA DE TRABAJO SOFTWARE'),
(39, 5, 'MESA DE TRABAJO INFRAESTRUCTURA'),
(40, 5, 'MESA DE TRABAJO SEGURIDAD'),
(41, 5, 'MESA DE TRABAJO OPERACION'),
(42, 5, 'MESA DE TRABAJO JURIDICA'),
(43, 8, 'MESA DE AYUDA'),
(44, 4, 'CONTRACTUAL'),
(46, 8, 'AUDITORIAS'),
(47, 8, 'PRUEBAS'),
(48, 15, 'TRABAJO'),
(49, 15, 'GESTION DE RIESGOS'),
(50, 15, 'COMUNICACIONES'),
(52, 16, 'CONTRATO'),
(53, 16, 'ANEXOS'),
(54, 17, 'CALIDAD'),
(55, 17, 'TRABAJO'),
(56, 17, 'GESTION DE CAMBIO'),
(57, 18, 'NO APLICA'),
(58, 3, 'ANS'),
(59, 4, 'TECNICO-AUDITORIA'),
(60, 4, 'TECNICO-BASE DE DATOS'),
(61, 4, 'TECNICO-SEGURIDAD'),
(62, 4, 'TECNICO-INFRAESTRUCTURA'),
(63, 9, 'DECRETO'),
(64, 9, 'DECISION'),
(65, 8, 'PROCESOS Y PROCEDIMIENTOS'),
(66, 5, 'MESA DE TRABAJO BASE DE DATOS'),
(67, 1, 'COTT'),
(68, 1, 'FIDUCIA'),
(70, 3, 'GESTION FINANCIERA '),
(73, 9, 'CIRCULAR'),
(74, 8, 'OPERACIONES'),
(75, 9, 'OTRO'),
(76, 20, 'FONDO DE REPOSICION'),
(77, 21, 'NO APLICA'),
(78, 22, 'CONCESION RUNT'),
(79, 22, 'FIDUCIARIA DAVIVIENDA'),
(80, 9, 'RESOLUCION TARIFAS'),
(81, 23, 'NO APLICA'),
(82, 1, 'ACTAS'),
(83, 5, 'CIERRE DE FASE'),
(84, 24, 'NO APLICA'),
(85, 12, 'SOAT'),
(86, 12, 'RCC-RCE');

-- --------------------------------------------------------

--
-- Table structure for table `documento_tema`
--

CREATE TABLE `documento_tema` (
  `dot_id` int(2) NOT NULL COMMENT 'Identificador del tema',
  `dot_nombre` varchar(45) NOT NULL DEFAULT '' COMMENT 'Nombre del tema',
  `dti_id` int(2) NOT NULL DEFAULT '0' COMMENT 'Id del tipo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los temas de documentos';

--
-- Dumping data for table `documento_tema`
--

INSERT INTO `documento_tema` (`dot_id`, `dot_nombre`, `dti_id`) VALUES
(5, 'ACTAS', 2),
(21, 'ACTAS DE AFORO', 4),
(24, 'CCB', 4),
(4, 'COMUNICADOS', 2),
(10, 'CONCEPTOS', 5),
(1, 'CONTRATO CONCESION', 1),
(16, 'CONTRATO INTERVENTORIA', 1),
(11, 'CONVENIOS', 5),
(22, 'ESTADOS FINANCIEROS', 4),
(23, 'EXTRACTOS FIDUCIARIA', 4),
(3, 'INFORMES CONCESION', 3),
(8, 'INFORMES INTERVENTORIA', 3),
(9, 'LEY, RESOLUCION, DECRETO,CIRCULAR', 5),
(20, 'ORDENES DE PAGO', 4),
(17, 'PLANES CONCESION', 1),
(15, 'PLANES INTERVENTORIA', 1),
(2, 'PLIEGO CONCESION', 1),
(18, 'PLIEGO INTERVENTORIA', 1),
(12, 'POLIZAS', 4);

-- --------------------------------------------------------

--
-- Table structure for table `documento_tipo`
--

CREATE TABLE `documento_tipo` (
  `dti_id` int(2) NOT NULL COMMENT 'Identificador del tipo',
  `dti_nombre` varchar(45) NOT NULL DEFAULT '' COMMENT 'Nombre del tipo de documento',
  `dti_estado` varchar(1) NOT NULL COMMENT 'Indica si el tipo de documento maneja estado (si o no)',
  `dti_responsable` varchar(1) NOT NULL COMMENT 'Indica si el tipo de documento maneja responsable (si o no)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los tipos de documentos';

--
-- Dumping data for table `documento_tipo`
--

INSERT INTO `documento_tipo` (`dti_id`, `dti_nombre`, `dti_estado`, `dti_responsable`) VALUES
(1, 'SOPORTE CONTRACTUAL', 'N', 'N'),
(2, 'SOPORTE ADMINISTRATIVO', 'S', 'S'),
(3, 'SOPORTE GERENCIAL', 'N', 'N'),
(4, 'SOPORTE FINANCIERO', 'N', 'N'),
(5, 'SOPORTE JURIDICO', 'N', 'N');

-- --------------------------------------------------------

--
-- Table structure for table `documento_tipo_actor`
--

CREATE TABLE `documento_tipo_actor` (
  `dta_id` int(2) NOT NULL COMMENT 'Identificador del tipo de actor',
  `dta_nombre` varchar(50) NOT NULL COMMENT 'Nombre del tipo de actor'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los tipos de actores';

--
-- Dumping data for table `documento_tipo_actor`
--

INSERT INTO `documento_tipo_actor` (`dta_id`, `dta_nombre`) VALUES
(1, 'Contratante'),
(2, 'Contratista'),
(3, 'Entidad'),
(4, 'Interventoria'),
(5, 'Otros');

-- --------------------------------------------------------

--
-- Table structure for table `festivos_colombia`
--

CREATE TABLE `festivos_colombia` (
  `fes_id` date NOT NULL COMMENT 'fecha de los festivos'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='contiene los festivos de colombia';

-- --------------------------------------------------------

--
-- Table structure for table `municipio`
--

CREATE TABLE `municipio` (
  `mun_id` varchar(5) NOT NULL DEFAULT '' COMMENT 'Codigo dane del municipio',
  `dep_id` varchar(2) NOT NULL DEFAULT '' COMMENT 'Codigo dane del departamento al que pertenece el municipio',
  `mun_nombre` varchar(100) NOT NULL DEFAULT '' COMMENT 'Nombre del municipio',
  `mun_poblacion` int(11) NOT NULL DEFAULT '0' COMMENT 'Nro de habitantes del municipio segun proyeccion DANE'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los municipios por departamento';

--
-- Dumping data for table `municipio`
--

INSERT INTO `municipio` (`mun_id`, `dep_id`, `mun_nombre`, `mun_poblacion`) VALUES
('05001', '05', 'MEDELLIN', 5000),
('05002', '05', 'ABEJORRAL', 19893),
('05004', '05', 'ABRIAQUI', 2173),
('05021', '05', 'ALEJANDRIA', 3730),
('05030', '05', 'AMAGA', 27115),
('05031', '05', 'AMALFI', 20482),
('05034', '05', 'ANDES', 41491),
('05036', '05', 'ANGELOPOLIS', 7648),
('05038', '05', 'ANGOSTURA', 12371),
('05040', '05', 'ANORI', 14776),
('05042', '05', 'SANTAFE DE ANTIOQUIA', 22858),
('05044', '05', 'ANZA', 7371),
('05045', '05', 'APARTADO', 134572),
('05051', '05', 'ARBOLETES', 31039),
('05055', '05', 'ARGELIA', 8911),
('05059', '05', 'ARMENIA', 5096),
('05079', '05', 'BARBOSA', 42547),
('05086', '05', 'BELMIRA', 6196),
('05088', '05', 'BELLO', 373013),
('05091', '05', 'BETANIA', 10120),
('05093', '05', 'BETULIA', 16665),
('05101', '05', 'CIUDAD BOLIVAR', 28090),
('05107', '05', 'BRICEÑO', 8061),
('05113', '05', 'BURITICA', 6472),
('05120', '05', 'CACERES', 29238),
('05125', '05', 'CAICEDO', 7669),
('05129', '05', 'CALDAS', 68157),
('05134', '05', 'CAMPAMENTO', 7828),
('05138', '05', 'CAÑASGORDAS', 16518),
('05142', '05', 'CARACOLI', 4747),
('05145', '05', 'CARAMANTA', 5603),
('05147', '05', 'CAREPA', 43691),
('05148', '05', 'CARMEN DE VIBORAL', 40968),
('05150', '05', 'CAROLINA', 3929),
('05154', '05', 'CAUCASIA', 89443),
('05172', '05', 'CHIGORODO', 59597),
('05190', '05', 'CISNEROS', 9617),
('05197', '05', 'COCORNA', 14741),
('05206', '05', 'CONCEPCION', 4410),
('05209', '05', 'CONCORDIA', 21226),
('05212', '05', 'COPACABANA', 61421),
('05234', '05', 'DABEIBA', 22721),
('05237', '05', 'DON MATIAS', 17759),
('05240', '05', 'EBEJICO', 12313),
('05250', '05', 'EL BAGRE', 45848),
('05264', '05', 'ENTRERRIOS', 8452),
('05266', '05', 'ENVIGADO', 175337),
('05282', '05', 'FREDONIA', 21882),
('05284', '05', 'FRONTINO', 19674),
('05306', '05', 'GIRALDO', 4146),
('05308', '05', 'GIRARDOTA', 42830),
('05310', '05', 'GOMEZ PLATA', 11229),
('05313', '05', 'GRANADA', 9436),
('05315', '05', 'GUADALUPE', 6191),
('05318', '05', 'GUARNE', 39753),
('05321', '05', 'GUATAPE', 5800),
('05347', '05', 'HELICONIA', 6567),
('05353', '05', 'HISPANIA', 4801),
('05360', '05', 'ITAGUI', 231768),
('05361', '05', 'ITUANGO', 24592),
('05364', '05', 'JARDIN', 14323),
('05368', '05', 'JERICO', 12761),
('05376', '05', 'LA CEJA', 46366),
('05380', '05', 'LA ESTRELLA', 52763),
('05390', '05', 'LA PINTADA', 7094),
('05400', '05', 'LA UNION', 17836),
('05411', '05', 'LIBORINA', 9370),
('05420', '05', 'ANTIOQUIA', 7),
('05425', '05', 'MACEO', 7534),
('05440', '05', 'MARINILLA', 45658),
('05467', '05', 'MONTEBELLO', 7389),
('05475', '05', 'MURINDO', 3768),
('05480', '05', 'MUTATA', 9671),
('05483', '05', 'NARIÑO', 11238),
('05490', '05', 'NECOCLI', 48679),
('05495', '05', 'NECHI', 21287),
('05501', '05', 'OLAYA', 2906),
('05541', '05', 'PEÑOL', 16177),
('05543', '05', 'PEQUE', 9618),
('05576', '05', 'PUEBLORRICO', 8168),
('05579', '05', 'PUERTO BERRIO', 38944),
('05585', '05', 'PUERTO NARE', 16711),
('05591', '05', 'PUERTO TRIUNFO', 16349),
('05604', '05', 'REMEDIOS', 22914),
('05607', '05', 'RETIRO', 16974),
('05615', '05', 'RIONEGRO', 101046),
('05628', '05', 'SABANALARGA', 8136),
('05631', '05', 'SABANETA', 44874),
('05642', '05', 'SALGAR', 18074),
('05647', '05', 'SAN ANDRES', 7059),
('05649', '05', 'SAN CARLOS', 13000),
('05652', '05', 'SAN FRANCISCO', 6273),
('05656', '05', 'SAN JERONIMO', 11603),
('05658', '05', 'SAN JOSE DE LA MONTAÑA', 3077),
('05659', '05', 'SAN JUAN DE URABA', 20938),
('05660', '05', 'SAN LUIS', 10780),
('05664', '05', 'SAN PEDRO', 22100),
('05665', '05', 'SAN PEDRO DE URABA', 28747),
('05667', '05', 'SAN RAFAEL', 13203),
('05670', '05', 'SAN ROQUE', 17958),
('05674', '05', 'SAN VICENTE', 19273),
('05679', '05', 'SANTA BARBARA', 23442),
('05686', '05', 'SANTA.ROSA DE OSOS', 31028),
('05690', '05', 'SANTO DOMINGO', 11418),
('05697', '05', 'SANTUARIO', 26152),
('05736', '05', 'SEGOVIA', 35095),
('05756', '05', 'SONSON', 38359),
('05761', '05', 'SOPETRAN', 13352),
('05789', '05', 'TAMESIS', 16212),
('05790', '05', 'TARAZA', 33434),
('05792', '05', 'TARSO', 8543),
('05809', '05', 'TITIRIBI', 13324),
('05819', '05', 'TOLEDO', 5129),
('05837', '05', 'TURBO', 122780),
('05842', '05', 'URAMITA', 7262),
('05847', '05', 'URRAO', 38937),
('05854', '05', 'VALDIVIA', 17489),
('05856', '05', 'VALPARAISO', 5980),
('05858', '05', 'VEGACHI', 11086),
('05861', '05', 'VENECIA', 12607),
('05873', '05', 'VIGIA DEL FUERTE', 5320),
('05885', '05', 'YALI', 6273),
('05887', '05', 'YARUMAL', 41362),
('05890', '05', 'YOLOMBO', 20099),
('05893', '05', 'YONDO', 15176),
('05895', '05', 'ZARAGOZA', 26939),
('08001', '08', 'BARRANQUILLA', 1113016),
('08078', '08', 'BARANOA', 50261),
('08137', '08', 'CAMPO DE LA CRUZ', 18354),
('08141', '08', 'CANDELARIA', 11635),
('08296', '08', 'GALAPA', 31596),
('08372', '08', 'JUAN DE ACOSTA', 14184),
('08421', '08', 'LURUACO', 22878),
('08433', '08', 'MALAMBO', 99058),
('08436', '08', 'MANATI', 13456),
('08520', '08', 'PALMAR DE VARELA', 23012),
('08549', '08', 'PIOJO', 4874),
('08558', '08', 'POLONUEVO', 13518),
('08560', '08', 'PONEDERA', 18430),
('08573', '08', 'PUERTO COLOMBIA', 26932),
('08606', '08', 'REPELON', 22196),
('08634', '08', 'SABANAGRANDE', 24880),
('08638', '08', 'SABANALARGA', 0),
('08675', '08', 'SANTA LUCIA', 11947),
('08685', '08', 'SANTO TOMAS', 23188),
('08758', '08', 'SOLEDAD', 455796),
('08770', '08', 'SUAN', 9344),
('08832', '08', 'TUBARA', 10602),
('08849', '08', 'USIACURI', 8561),
('11001', '11', 'BOGOTÁ', 2259564),
('13001', '13', 'CARTAGENA', 895400),
('13006', '13', 'ACHI', 19629),
('13030', '13', 'ALTOS DEL ROSARIO', 10695),
('13042', '13', 'ARENAL', 7364),
('13052', '13', 'ARJONA', 60600),
('13062', '13', 'ARROYOHONDO', 8825),
('13074', '13', 'BARRANCO DE LOBA', 15186),
('13140', '13', 'CALAMAR', 20771),
('13160', '13', 'CANTAGALLO', 7839),
('13188', '13', 'CICUCO', 10981),
('13212', '13', 'CORDOBA', 12824),
('13222', '13', 'CLEMENCIA', 11699),
('13244', '13', 'EL CARMEN DE BOLIVAR', 67601),
('13248', '13', 'EL GUAMO', 7754),
('13268', '13', 'EL PENON', 7871),
('13300', '13', 'HATILLO DE LOBA', 11316),
('13430', '13', 'MAGANGUE', 121085),
('13433', '13', 'MAHATES', 22983),
('13440', '13', 'MARGARITA', 9368),
('13442', '13', 'MARIA LA BAJA', 45262),
('13458', '13', 'MONTECRISTO', 17331),
('13468', '13', 'MOMPOS', 41326),
('13473', '13', 'MORALES', 16117),
('13490', '13', 'NOROSI', 0),
('13549', '13', 'PINILLOS', 22714),
('13580', '13', 'REGIDOR', 4511),
('13600', '13', 'RIO VIEJO', 20901),
('13620', '13', 'SAN CRISTOBAL', 6578),
('13647', '13', 'SAN ESTANISLAO', 15269),
('13650', '13', 'SAN FERNANDO', 12800),
('13654', '13', 'SAN JACINTO', 21218),
('13655', '13', 'SAN JACINTO DEL CAUCA', 10205),
('13657', '13', 'SAN JUAN NEPOMUCENO', 32296),
('13667', '13', 'SAN MARTIN DE LOBA', 14365),
('13670', '13', 'SAN PABLO', 27108),
('13673', '13', 'SANTA CATALINA', 12042),
('13683', '13', 'SANTA ROSA', 18365),
('13688', '13', 'SANTA ROSA DEL SUR', 30482),
('13744', '13', 'SIMITI', 18139),
('13760', '13', 'SOPLAVIENTO', 8303),
('13780', '13', 'TALAIGUA NUEVO', 10973),
('13810', '13', 'TIQUISIO', 18714),
('13836', '13', 'TURBACO', 63450),
('13838', '13', 'TURBANA', 13507),
('13873', '13', 'VILLANUEVA', 17622),
('13894', '13', 'ZAMBRANO', 11056),
('15001', '15', 'TUNJA', 152419),
('15022', '15', 'ALMEIDA', 2171),
('15047', '15', 'AQUITANIA', 16087),
('15051', '15', 'ARCABUCO', 5090),
('15087', '15', 'BELEN', 8471),
('15090', '15', 'BERBEO', 1862),
('15092', '15', 'BETEITIVA', 2413),
('15097', '15', 'BOAVITA', 6467),
('15104', '15', 'BOYACA', 4947),
('15106', '15', 'BRICEÑO', 0),
('15109', '15', 'BUENAVISTA', 5759),
('15114', '15', 'BUSBANZA', 875),
('15131', '15', 'CALDAS', 0),
('15135', '15', 'CAMPOHERMOSO', 3949),
('15162', '15', 'CERINZA', 4199),
('15172', '15', 'CHINAVITA', 3651),
('15176', '15', 'CHIQUINQUIRA', 54949),
('15180', '15', 'CHISCAS', 5175),
('15183', '15', 'CHITA', 10405),
('15185', '15', 'CHITARAQUE', 6500),
('15187', '15', 'CHIVATA', 4977),
('15189', '15', 'CIENEGA', 5096),
('15200', '15', 'COCUY', 0),
('15204', '15', 'COMBITA', 12752),
('15212', '15', 'COPER', 4047),
('15215', '15', 'CORRALES', 2481),
('15218', '15', 'COVARACHIA', 3205),
('15223', '15', 'CUBARA', 6462),
('15224', '15', 'CUCAITA', 4474),
('15226', '15', 'CUITIVA', 1969),
('15232', '15', 'CHIQUIZA', 5916),
('15236', '15', 'CHIVOR', 2126),
('15238', '15', 'DUITAMA', 105412),
('15244', '15', 'EL COCUY', 5383),
('15248', '15', 'EL ESPINO', 3914),
('15272', '15', 'FIRAVITOBA', 6177),
('15276', '15', 'FLORESTA', 3833),
('15293', '15', 'GACHANTIVA', 2985),
('15296', '15', 'GAMEZA', 4895),
('15299', '15', 'GARAGOA', 16195),
('15317', '15', 'GUACAMAYAS', 2042),
('15322', '15', 'GUATEQUE', 9921),
('15325', '15', 'GUAYATA', 6018),
('15332', '15', 'GUICAN', 5920),
('15362', '15', 'IZA', 2081),
('15367', '15', 'JENESANO', 7287),
('15368', '15', 'JERICO', 4538),
('15377', '15', 'LABRANZAGRANDE', 5231),
('15380', '15', 'LA CAPILLA', 3052),
('15401', '15', 'LA VICTORIA', 1645),
('15403', '15', 'LA UVITA', 3390),
('15407', '15', 'VILLA DE LEYVA', 9645),
('15425', '15', 'MACANAL', 4611),
('15442', '15', 'MARIPI', 7680),
('15455', '15', 'MIRAFLORES', 9455),
('15464', '15', 'MONGUA', 5080),
('15466', '15', 'MONGUI', 4901),
('15469', '15', 'MONIQUIRA', 21377),
('15476', '15', 'MOTAVITA', 5926),
('15480', '15', 'MUZO', 9828),
('15491', '15', 'NOBSA', 14946),
('15494', '15', 'NUEVO COLON', 5962),
('15500', '15', 'OICATA', 2770),
('15507', '15', 'OTANCHE', 10788),
('15511', '15', 'PACHAVITA', 2968),
('15514', '15', 'PAEZ', 3242),
('15516', '15', 'PAIPA', 27274),
('15518', '15', 'PAJARITO', 2168),
('15522', '15', 'PANQUEBA', 1781),
('15531', '15', 'PAUNA', 10155),
('15533', '15', 'PAYA', 2587),
('15537', '15', 'PAZ DE RIO', 5083),
('15542', '15', 'PESCA', 9322),
('15550', '15', 'PISBA', 1481),
('15572', '15', 'PUERTO BOYACA', 49912),
('15580', '15', 'QUIPAMA', 8815),
('15599', '15', 'RAMIRIQUI', 9700),
('15600', '15', 'RAQUIRA', 12299),
('15621', '15', 'RONDON', 2934),
('15632', '15', 'SABOYA', 12611),
('15638', '15', 'SACHICA', 3783),
('15646', '15', 'SAMACA', 17352),
('15660', '15', 'SAN EDUARDO', 1867),
('15664', '15', 'SAN JOSE DE PARE', 5586),
('15667', '15', 'SAN LUIS DE GACENO', 6158),
('15673', '15', 'SAN MATEO', 4551),
('15676', '15', 'SAN MIGUEL DE SEMA', 4028),
('15681', '15', 'SAN PABLO BORBUR', 8913),
('15686', '15', 'SANTANA', 7680),
('15690', '15', 'SANTA MARIA', 4498),
('15693', '15', 'SAN ROSA VITERBO', 11816),
('15696', '15', 'SANTA SOFIA', 3012),
('15720', '15', 'SATIVANORTE', 2661),
('15723', '15', 'SATIVASUR', 1294),
('15740', '15', 'SIACHOQUE', 7630),
('15753', '15', 'SOATA', 8730),
('15755', '15', 'SOCOTA', 9812),
('15757', '15', 'SOCHA', 7364),
('15759', '15', 'SOGAMOSO', 114509),
('15761', '15', 'SOMONDOCO', 3246),
('15762', '15', 'SORA', 2916),
('15763', '15', 'SOTAQUIRA', 8303),
('15764', '15', 'SORACA', 5805),
('15774', '15', 'SUSACON', 3550),
('15776', '15', 'SUTAMARCHAN', 5624),
('15778', '15', 'SUTATENZA', 4444),
('15790', '15', 'TASCO', 6707),
('15798', '15', 'TENZA', 4513),
('15804', '15', 'TIBANA', 9464),
('15806', '15', 'TIBASOSA', 12463),
('15808', '15', 'TINJACA', 2889),
('15810', '15', 'TIPACOQUE', 3730),
('15814', '15', 'TOCA', 8749),
('15816', '15', 'TOGUI', 5099),
('15820', '15', 'TOPAGA', 3608),
('15822', '15', 'TOTA', 5531),
('15832', '15', 'TUNUNGUA', 2133),
('15835', '15', 'TURMEQUE', 7347),
('15837', '15', 'TUTA', 8823),
('15839', '15', 'TUTAZA', 2185),
('15842', '15', 'UMBITA', 9888),
('15861', '15', 'VENTAQUEMADA', 14166),
('15879', '15', 'VIRACACHA', 3380),
('15897', '15', 'ZETAQUIRA', 5016),
('17001', '17', 'MANIZALES', 368433),
('17013', '17', 'AGUADAS', 22307),
('17042', '17', 'ANSERMA', 33674),
('17050', '17', 'ARANZAZU', 12181),
('17088', '17', 'BELALCAZAR', 11327),
('17174', '17', 'CHINCHINA', 51301),
('17272', '17', 'FILADELFIA', 12235),
('17380', '17', 'LA DORADA', 70486),
('17388', '17', 'LA MERCED', 6324),
('17433', '17', 'MANZANARES', 18895),
('17442', '17', 'MARMATO', 8175),
('17444', '17', 'MARQUETALIA', 13880),
('17446', '17', 'MARULANDA', 2735),
('17486', '17', 'NEIRA', 27250),
('17495', '17', 'NORCASIA', 6523),
('17513', '17', 'PACORA', 14448),
('17524', '17', 'PALESTINA', 17310),
('17541', '17', 'PENSILVANIA', 25456),
('17614', '17', 'RIOSUCIO', 35843),
('17616', '17', 'RISARALDA', 10175),
('17653', '17', 'SALAMINA', 8239),
('17662', '17', 'SAMANA', 24595),
('17665', '17', 'SAN JOSE', 7288),
('17777', '17', 'SUPIA', 24072),
('17867', '17', 'VICTORIA', 8756),
('17873', '17', 'VILLAMARIA', 45038),
('17877', '17', 'VITERBO', 11805),
('18001', '18', 'FLORENCIA', 142123),
('18029', '18', 'ALBANIA', 6036),
('18094', '18', 'BELEN DE LOS ANDAQUIES', 10809),
('18150', '18', 'CARTAGENA DEL CHAIRA', 27998),
('18205', '18', 'CURRILLO', 9977),
('18247', '18', 'EL DONCELLO', 20999),
('18256', '18', 'EL PAUJIL', 15400),
('18410', '18', 'LA MONTAÑITA', 21626),
('18460', '18', 'MILAN', 9821),
('18479', '18', 'MORELIA', 3580),
('18592', '18', 'PUERTO RICO', 27886),
('18610', '18', 'SAN JOSE DE LA FRAGUA', 13559),
('18753', '18', 'SAN VICENTE DEL CAGÜAN', 56291),
('18756', '18', 'SOLANO', 19528),
('18785', '18', 'SOLITA', 8734),
('18860', '18', 'VALPARAISO', 0),
('19001', '19', 'POPAYAN', 258653),
('19022', '19', 'ALMAGUER', 18393),
('19050', '19', 'ARGELIA', 0),
('19075', '19', 'BALBOA', 23699),
('19100', '19', 'BOLIVAR', 43461),
('19110', '19', 'BUENOS AIRES', 22804),
('19130', '19', 'CAJIBIO', 34818),
('19137', '19', 'CALDONO', 31045),
('19142', '19', 'CALOTO', 36901),
('19212', '19', 'CORINTO', 22825),
('19256', '19', 'EL TAMBO', 37883),
('19290', '19', 'FLORENCIA', 0),
('19300', '19', 'GUACHENÉ', 0),
('19318', '19', 'GUAPI', 28649),
('19355', '19', 'INZA', 27172),
('19364', '19', 'JAMBALO', 14831),
('19392', '19', 'LA SIERRA', 10844),
('19397', '19', 'LA VEGA', 39133),
('19418', '19', 'LOPEZ', 14268),
('19450', '19', 'MERCADERES', 17670),
('19455', '19', 'MIRANDA', 33874),
('19473', '19', 'MORALES', 24381),
('19513', '19', 'PADILLA', 8279),
('19517', '19', 'PAEZ', 31548),
('19532', '19', 'PATIA', 33328),
('19533', '19', 'PIAMONTE', 7371),
('19548', '19', 'PIENDAMO', 36225),
('19573', '19', 'PUERTO TEJADA', 44220),
('19585', '19', 'PURACE', 15688),
('19622', '19', 'ROSAS', 12715),
('19693', '19', 'SAN SEBASTIAN', 12976),
('19698', '19', 'SANTANDER DE QUILICHAO', 80653),
('19701', '19', 'SANTA ROSA', 0),
('19743', '19', 'SILVIA', 30377),
('19760', '19', 'SOTARA', 15904),
('19780', '19', 'SUAREZ', 19002),
('19785', '19', 'SUCRE', 7907),
('19807', '19', 'TIMBIO', 29775),
('19809', '19', 'TIMBIQUI', 20560),
('19821', '19', 'TORIBIO', 26616),
('19824', '19', 'TOTORO', 18060),
('19845', '19', 'VILLA RICA', 14378),
('20001', '20', 'VALLEDUPAR', 348990),
('20011', '20', 'AGUACHICA', 80789),
('20013', '20', 'AGUSTIN CODAZZI', 52219),
('20032', '20', 'ASTREA', 17786),
('20045', '20', 'BECERRIL', 13584),
('20060', '20', 'BOSCONIA', 30334),
('20175', '20', 'CHIMICHAGUA', 30116),
('20178', '20', 'CHIRIGUANA', 21494),
('20228', '20', 'CURUMANI', 26740),
('20238', '20', 'EL COPEY', 24368),
('20250', '20', 'EL PASO', 20292),
('20295', '20', 'GAMARRA', 14224),
('20310', '20', 'GONZALEZ', 8859),
('20383', '20', 'LA GLORIA', 14173),
('20400', '20', 'LA JAGUA DE IBIRICO', 21386),
('20443', '20', 'MANAURE', 6883),
('20517', '20', 'PAILITAS', 15578),
('20550', '20', 'PELAYA', 16242),
('20570', '20', 'PUEBLO BELLO', 16942),
('20614', '20', 'RIO DE ORO', 14023),
('20621', '20', 'LA PAZ', 21289),
('20710', '20', 'SAN ALBERTO', 19656),
('20750', '20', 'SAN DIEGO', 13390),
('20770', '20', 'SAN MARTIN', 16921),
('20787', '20', 'TAMALAMEQUE', 13636),
('23001', '23', 'MONTERIA', 381525),
('23068', '23', 'AYAPEL', 42629),
('23079', '23', 'BUENAVISTA', 0),
('23090', '23', 'CANALETE', 17446),
('23162', '23', 'CERETE', 83978),
('23168', '23', 'CHIMA', 13668),
('23182', '23', 'CHINU', 43331),
('23189', '23', 'CIENAGA DE ORO', 53403),
('23300', '23', 'COTORRA', 15903),
('23350', '23', 'LA APARTADA', 12728),
('23417', '23', 'LORICA', 111923),
('23419', '23', 'LOS CORDOBAS', 18197),
('23464', '23', 'MOMIL', 14160),
('23466', '23', 'MONTELIBANO', 73619),
('23500', '23', 'MOÑITOS', 22709),
('23555', '23', 'PLANETA RICA', 61570),
('23570', '23', 'PUEBLO NUEVO', 31754),
('23574', '23', 'PUERTO ESCONDIDO', 22302),
('23580', '23', 'PUERTO LIBERTADOR', 36026),
('23586', '23', 'PURISIMA', 14496),
('23635', '23', 'SAN BERNARDO DEL VIENTO', 0),
('23660', '23', 'SAHAGUN', 86189),
('23670', '23', 'SAN ANDRES DE SOTAVENTO', 63453),
('23672', '23', 'SAN ANTERO', 26462),
('23675', '23', 'SAN BERNARDO DEL VIENTO', 31455),
('23678', '23', 'SAN CARLOS', 0),
('23682', '23', 'SAN JOSE DE URE', 0),
('23686', '23', 'SAN PELAYO', 37550),
('23807', '23', 'TIERRALTA', 78972),
('23815', '23', 'TUCHIN', 0),
('23855', '23', 'VALENCIA', 34654),
('25001', '25', 'AGUA DE DIOS', 11515),
('25019', '25', 'ALBAN', 5820),
('25035', '25', 'ANAPOIMA', 11337),
('25040', '25', 'ANOLAIMA', 12911),
('25053', '25', 'ARBELAEZ', 11355),
('25086', '25', 'BELTRAN', 1908),
('25095', '25', 'BITUIMA', 2454),
('25099', '25', 'BOJACA', 8788),
('25120', '25', 'CABRERA', 4557),
('25123', '25', 'CACHIPAY', 9737),
('25126', '25', 'CAJICA', 44721),
('25148', '25', 'CAPARRAPI', 13788),
('25151', '25', 'CAQUEZA', 15999),
('25154', '25', 'CARMEN DE CARUPA', 8243),
('25168', '25', 'CHAGUANI', 3935),
('25175', '25', 'CHIA', 97444),
('25178', '25', 'CHIPAQUE', 8191),
('25181', '25', 'CHOACHI', 10874),
('25183', '25', 'CHOCONTA', 19054),
('25200', '25', 'COGUA', 18093),
('25214', '25', 'COTA', 19664),
('25224', '25', 'CUCUNUBA', 6777),
('25245', '25', 'EL COLEGIO', 20020),
('25258', '25', 'EL PEÑON', 0),
('25260', '25', 'EL ROSAL', 13432),
('25269', '25', 'FACATATIVA', 106067),
('25279', '25', 'FOMEQUE', 11669),
('25281', '25', 'FOSCA', 6506),
('25286', '25', 'FUNZA', 60571),
('25288', '25', 'FUQUENE', 5088),
('25290', '25', 'FUSAGASUGA', 107259),
('25293', '25', 'GACHALA', 5751),
('25295', '25', 'GACHANCIPA', 10792),
('25297', '25', 'GACHETA', 10199),
('25299', '25', 'GAMA', 3776),
('25307', '25', 'GIRARDOT', 95496),
('25312', '25', 'GRANADA', 0),
('25317', '25', 'GUACHETA', 11230),
('25320', '25', 'GUADUAS', 31250),
('25322', '25', 'GUASCA', 12208),
('25324', '25', 'GUATAQUI', 2223),
('25326', '25', 'GUATAVITA', 5715),
('25328', '25', 'GUAYABAL DE SIQUIMA', 3533),
('25335', '25', 'GUAYABETAL', 4628),
('25339', '25', 'GUTIERREZ', 3403),
('25368', '25', 'JERUSALEN', 2632),
('25372', '25', 'JUNIN', 8115),
('25377', '25', 'LA CALERA', 23308),
('25386', '25', 'LA MESA', 26699),
('25394', '25', 'LA PALMA', 9396),
('25398', '25', 'LA PEÑA', 6792),
('25402', '25', 'LA VEGA', 0),
('25407', '25', 'LENGUAZAQUE', 9548),
('25426', '25', 'MACHETA', 6663),
('25430', '25', 'MADRID', 61599),
('25436', '25', 'MANTA', 4393),
('25438', '25', 'MEDINA', 9484),
('25473', '25', 'MOSQUERA', 63584),
('25483', '25', 'NARIÑO', 2042),
('25486', '25', 'NEMOCON', 11093),
('25488', '25', 'NILO', 14224),
('25489', '25', 'NIMAIMA', 5486),
('25491', '25', 'NOCAIMA', 5303),
('25506', '25', 'VENECIA', 0),
('25513', '25', 'PACHO', 24766),
('25518', '25', 'PAIME', 5281),
('25524', '25', 'PANDI', 5350),
('25530', '25', 'PARATEBUENO', 7256),
('25535', '25', 'PASCA', 10876),
('25572', '25', 'PUERTO SALGAR', 15237),
('25580', '25', 'PULI', 2837),
('25592', '25', 'QUEBRADANEGRA', 4531),
('25594', '25', 'QUETAME', 6433),
('25596', '25', 'QUIPILE', 7890),
('25599', '25', 'APULO', 7630),
('25612', '25', 'RICAURTE', 7990),
('25645', '25', 'SAN ANTONIO DE TEQUENDAMA', 10202),
('25649', '25', 'SAN BERNARDO', 9910),
('25653', '25', 'SAN CAYETANO', 5145),
('25658', '25', 'SAN FRANCISCO', 0),
('25662', '25', 'SAN JUAN DE RIOSECO', 9462),
('25718', '25', 'SASAIMA', 9948),
('25736', '25', 'SESQUILE', 9691),
('25740', '25', 'SIBATE', 31166),
('25743', '25', 'SILVANIA', 20872),
('25745', '25', 'SIMIJACA', 10642),
('25754', '25', 'SOACHA', 398295),
('25758', '25', 'SOPO', 21014),
('25769', '25', 'SUBACHOQUE', 12972),
('25772', '25', 'SUESCA', 13985),
('25777', '25', 'SUPATA', 4764),
('25779', '25', 'SUSA', 9788),
('25781', '25', 'SUTATAUSA', 4653),
('25785', '25', 'TABIO', 20714),
('25793', '25', 'TAUSA', 7575),
('25797', '25', 'TENA', 7469),
('25799', '25', 'TENJO', 16607),
('25805', '25', 'TIBACUY', 4698),
('25807', '25', 'TIBIRITA', 2888),
('25815', '25', 'TOCAIMA', 16149),
('25817', '25', 'TOCANCIPA', 23981),
('25823', '25', 'TOPAIPI', 4599),
('25839', '25', 'UBALA', 11525),
('25841', '25', 'UBAQUE', 6692),
('25843', '25', 'UBATE', 32781),
('25845', '25', 'UNE', 7856),
('25851', '25', 'UTICA', 4209),
('25862', '25', 'VERGARA', 7339),
('25867', '25', 'VIANI', 3992),
('25871', '25', 'VILLAGOMEZ', 2104),
('25873', '25', 'VILLAPINZON', 16217),
('25875', '25', 'VILLETA', 23736),
('25878', '25', 'VIOTA', 13073),
('25885', '25', 'YACOPI', 15840),
('25898', '25', 'ZIPACON', 4916),
('25899', '25', 'ZIPAQUIRA', 100038),
('27001', '27', 'QUIBDO', 110032),
('27006', '27', 'ACANDI', 10070),
('27025', '27', 'ALTO BAUDO', 28502),
('27050', '27', 'ATRATO', 7492),
('27073', '27', 'BAGADO', 8174),
('27075', '27', 'BAHIA SOLANO', 8847),
('27077', '27', 'BAJO BAUDO', 15943),
('27086', '27', 'BLEN DE BAJIRA', 13438),
('27099', '27', 'BOJAYA', 9595),
('27135', '27', 'CANTON DE SAN PABLO', 6044),
('27150', '27', 'CARMEN DEL DARIEN', 4626),
('27160', '27', 'CERTEGUI', 9353),
('27205', '27', 'CONDOTO', 12733),
('27245', '27', 'EL CARMEN DE ATRATO', 11738),
('27250', '27', 'EL LITORAL DEL SAN JUAN', 12044),
('27361', '27', 'ISTMINA', 23411),
('27372', '27', 'JURADO', 3443),
('27413', '27', 'LLORO', 10013),
('27415', '27', 'MALPELO', 0),
('27425', '27', 'MEDIO ATRATO', 21368),
('27430', '27', 'MEDIO BAUDO', 11521),
('27450', '27', 'MEDIO SAN JUAN', 12379),
('27491', '27', 'NOVITA', 7562),
('27495', '27', 'NUQUI', 6295),
('27580', '27', 'RIO IRO', 7968),
('27600', '27', 'RIO QUITO', 7092),
('27615', '27', 'RIOSUCIO', 0),
('27660', '27', 'SAN JOSE DEL PALMAR', 4822),
('27745', '27', 'SIPI', 3423),
('27787', '27', 'TADO', 17525),
('27800', '27', 'UNGUIA', 14132),
('27810', '27', 'UNION PANAMERICANA', 7979),
('27999', '27', 'MALPELO', 0),
('41001', '41', 'NEIVA', 315332),
('41006', '41', 'ACEVEDO', 26597),
('41013', '41', 'AGRADO', 8459),
('41016', '41', 'AIPE', 19928),
('41020', '41', 'ALGECIRAS', 23323),
('41026', '41', 'ALTAMIRA', 3609),
('41078', '41', 'BARAYA', 8348),
('41132', '41', 'CAMPOALEGRE', 32101),
('41206', '41', 'COLOMBIA', 9067),
('41244', '41', 'ELIAS', 3342),
('41298', '41', 'GARZON', 70144),
('41306', '41', 'GIGANTE', 28174),
('41319', '41', 'GUADALUPE', 0),
('41349', '41', 'HOBO', 6521),
('41357', '41', 'IQUIRA', 10706),
('41359', '41', 'ISNOS', 23756),
('41378', '41', 'LA ARGENTINA', 11674),
('41396', '41', 'LA PLATA', 51784),
('41483', '41', 'NATAGA', 5807),
('41503', '41', 'OPORAPA', 10139),
('41518', '41', 'PAICOL', 5186),
('41524', '41', 'PALERMO', 27282),
('41530', '41', 'PALESTINA', 0),
('41548', '41', 'PITAL', 12811),
('41551', '41', 'PITALITO', 103582),
('41615', '41', 'RIVERA', 16654),
('41660', '41', 'SALADOBLANCO', 10262),
('41668', '41', 'SAN AGUSTIN', 29699),
('41676', '41', 'SANTA MARIA', 0),
('41770', '41', 'SUAZA', 14617),
('41791', '41', 'TARQUI', 15921),
('41797', '41', 'TESALIA', 8845),
('41799', '41', 'TELLO', 13447),
('41801', '41', 'TERUEL', 8198),
('41807', '41', 'TIMANA', 19787),
('41872', '41', 'VILLAVIEJA', 7314),
('41885', '41', 'YAGUARA', 7855),
('44001', '44', 'RIOHACHA', 169311),
('44035', '44', 'ALBANIA', 0),
('44078', '44', 'BARRANCAS', 22207),
('44090', '44', 'DIBULLA', 21098),
('44098', '44', 'DISTRACCION', 8274),
('44110', '44', 'EL MOLINO', 5937),
('44279', '44', 'FONSECA', 22220),
('44378', '44', 'HATONUEVO', 9797),
('44420', '44', 'LA JAGUA DEL PILAR', 2196),
('44430', '44', 'MAICAO', 103124),
('44560', '44', 'MANAURE', 0),
('44650', '44', 'SAN JUAN DEL CESAR', 25587),
('44847', '44', 'URIBIA', 116674),
('44855', '44', 'URUMITA', 8545),
('44874', '44', 'VILLANUEVA', 0),
('47001', '47', 'SANTA MARTA', 414387),
('47030', '47', 'ALGARROBO', 11556),
('47053', '47', 'ARACATACA', 34929),
('47058', '47', 'ARIGUANI', 30568),
('47161', '47', 'CERRO SAN ANTONIO', 8058),
('47170', '47', 'CHIVOLO', 16018),
('47189', '47', 'CIENAGA', 100908),
('47205', '47', 'CONCORDIA', 0),
('47245', '47', 'EL BANCO', 53544),
('47258', '47', 'EL PIÑON', 16684),
('47268', '47', 'EL RETEN', 18417),
('47288', '47', 'FUNDACION', 56107),
('47318', '47', 'GUAMAL', 25058),
('47460', '47', 'NUEVA GRANADA', 16088),
('47541', '47', 'PEDRAZA', 7865),
('47545', '47', 'PIJINO DEL CARMEN', 13850),
('47551', '47', 'PIVIJAY', 38307),
('47555', '47', 'PLATO', 48898),
('47570', '47', 'PUEBLOVIEJO', 24865),
('47605', '47', 'REMOLINO', 7840),
('47660', '47', 'SABANAS DE SAN ANGEL', 11425),
('47675', '47', 'SALAMINA', 0),
('47692', '47', 'SAN SEBASTIAN DE BUENAVISTA', 16924),
('47703', '47', 'SAN ZENON', 8749),
('47707', '47', 'SANTA ANA', 22840),
('47720', '47', 'SANTA BARBARA DE PINTO', 10919),
('47745', '47', 'SITIONUEVO', 26777),
('47798', '47', 'TENERIFE', 12291),
('47960', '47', 'ZAPAYAN', 8464),
('47980', '47', 'ZONA BANANERA', 56404),
('50001', '50', 'VILLAVICENCIO', 384131),
('50006', '50', 'ACACIAS', 54753),
('50110', '50', 'BARRANCA DE UPIA', 3232),
('50124', '50', 'CABUYARO', 3660),
('50150', '50', 'CASTILLA LA NUEVA', 7258),
('50223', '50', 'SAN LUIS DE CUBARRAL', 5174),
('50226', '50', 'CUMARAL', 16634),
('50245', '50', 'EL CALVARIO', 2256),
('50251', '50', 'EL CASTILLO', 5684),
('50270', '50', 'EL DORADO', 3301),
('50287', '50', 'FUENTE DE ORO', 11162),
('50313', '50', 'GRANADA', 50837),
('50318', '50', 'GUAMAL', 8933),
('50325', '50', 'MAPIRIPAN', 13438),
('50330', '50', 'MESETAS', 10588),
('50350', '50', 'LA MACARENA', 25079),
('50370', '50', 'LA URIBE', 12717),
('50400', '50', 'LEJANIAS', 9136),
('50450', '50', 'PUERTO CONCORDIA', 16308),
('50568', '50', 'PUERTO GAITAN', 17310),
('50573', '50', 'PUERTO LOPEZ', 28922),
('50577', '50', 'PUERTO LLERAS', 10582),
('50590', '50', 'PUERTO RICO', 0),
('50606', '50', 'RESTREPO', 10112),
('50680', '50', 'SAN CARLOS GUAROA', 6909),
('50683', '50', 'SAN JUAN DE ARAMA', 9172),
('50686', '50', 'SAN JUANITO', 1879),
('50689', '50', 'SAN MARTIN', 0),
('50711', '50', 'VISTA HERMOSA', 21194),
('52001', '52', 'PASTO', 383846),
('52019', '52', 'ALBAN', 19367),
('52022', '52', 'ALDANA', 6780),
('52036', '52', 'ANCUYA', 8304),
('52051', '52', 'ARBOLEDA', 7442),
('52079', '52', 'BARBACOAS', 30456),
('52083', '52', 'BELEN', 0),
('52110', '52', 'BUESACO', 22325),
('52203', '52', 'COLON', 9735),
('52207', '52', 'CONSACA', 10209),
('52210', '52', 'CONTADERO', 6639),
('52215', '52', 'CORDOBA', 0),
('52224', '52', 'CUASPUD', 8108),
('52227', '52', 'CUMBAL', 26463),
('52233', '52', 'CUMBITARA', 11717),
('52240', '52', 'CHACHAGÜI', 11910),
('52250', '52', 'EL CHARCO', 26163),
('52254', '52', 'EL PENOL', 6683),
('52256', '52', 'EL ROSARIO', 11204),
('52258', '52', 'EL TABLÓN DE GÓMEZ', 13890),
('52260', '52', 'EL TAMBO', 0),
('52287', '52', 'FUNES', 6687),
('52317', '52', 'GUACHUCAL', 16627),
('52320', '52', 'GUAITARILLA', 12764),
('52323', '52', 'GUALMATAN', 5656),
('52352', '52', 'ILES', 7867),
('52354', '52', 'IMUES', 7387),
('52356', '52', 'IPIALES', 109865),
('52378', '52', 'LA CRUZ', 18542),
('52381', '52', 'LA FLORIDA', 11151),
('52385', '52', 'LA LLANADA', 6468),
('52390', '52', 'LA TOLA', 8571),
('52399', '52', 'LA UNION', 0),
('52405', '52', 'LEIVA', 11825),
('52411', '52', 'LINARES', 11546),
('52418', '52', 'LOS ANDES', 16326),
('52427', '52', 'MAGUI', 16749),
('52435', '52', 'MALLAMA', 9147),
('52473', '52', 'MOSQUERA', 12130),
('52480', '52', 'NARINO', 0),
('52490', '52', 'OLAYA HERRERA', 27493),
('52506', '52', 'OSPINA', 8233),
('52520', '52', 'FRANCISCO PIZARRO', 11183),
('52540', '52', 'POLICARPA', 11163),
('52560', '52', 'POTOSI', 13040),
('52565', '52', 'PROVIDENCIA', 11726),
('52573', '52', 'PUERRES', 8850),
('52585', '52', 'PUPIALES', 18415),
('52612', '52', 'RICAURTE', 15053),
('52621', '52', 'ROBERTO PAYAN', 17286),
('52678', '52', 'SAMANIEGO', 49992),
('52683', '52', 'SANDONA', 25134),
('52685', '52', 'SAN BERNARDO', 0),
('52687', '52', 'SAN LORENZO', 18430),
('52693', '52', 'SAN PABLO', 0),
('52694', '52', 'SAN PEDRO DE CARTAGO', 7047),
('52696', '52', 'SANTA BARBARA', 0),
('52699', '52', 'SANTACRUZ', 22437),
('52720', '52', 'SAPUYES', 7369),
('52786', '52', 'TAMINANGO', 17354),
('52788', '52', 'TANGUA', 10672),
('52835', '52', 'TUMACO', 161490),
('52838', '52', 'TUQUERRES', 41205),
('52885', '52', 'YACUANQUER', 10012),
('54001', '54', 'CUCUTA', 585919),
('54003', '54', 'ABREGO', 34409),
('54051', '54', 'ARBOLEDAS', 8637),
('54099', '54', 'BOCHALEMA', 6558),
('54109', '54', 'BUCARASICA', 4507),
('54125', '54', 'CACOTA', 2513),
('54128', '54', 'CACHIRA', 10557),
('54172', '54', 'CHINACOTA', 14736),
('54174', '54', 'CHITAGA', 9618),
('54206', '54', 'CONVENCION', 16251),
('54223', '54', 'CUCUTILLA', 8318),
('54239', '54', 'DURANIA', 4181),
('54245', '54', 'EL CARMEN', 15685),
('54250', '54', 'EL TARRA', 10231),
('54261', '54', 'EL ZULIA', 20247),
('54313', '54', 'GRAMALOTE', 6233),
('54344', '54', 'HACARI', 9409),
('54347', '54', 'HERRAN', 4446),
('54377', '54', 'LABATECA', 5776),
('54385', '54', 'LA ESPERANZA', 10889),
('54398', '54', 'LA PLAYA', 7716),
('54405', '54', 'LOS PATIOS', 67441),
('54418', '54', 'LOURDES', 3407),
('54480', '54', 'MUTISCUA', 3847),
('54498', '54', 'OCAÑA', 90245),
('54518', '54', 'PAMPLONA', 52903),
('54520', '54', 'PAMPLONITA', 4767),
('54553', '54', 'PUERTO SANTANDER', 8712),
('54599', '54', 'RAGONVALIA', 6757),
('54660', '54', 'SALAZAR', 9272),
('54670', '54', 'SAN CALIXTO', 12513),
('54673', '54', 'SAN CAYETANO', 0),
('54680', '54', 'SANTIAGO', 2662),
('54720', '54', 'SARDINATA', 19716),
('54743', '54', 'SILOS', 5367),
('54800', '54', 'TEORAMA', 17770),
('54810', '54', 'TIBU', 30828),
('54820', '54', 'TOLEDO', 0),
('54871', '54', 'VILLA CARO', 5007),
('54874', '54', 'VILLA DEL ROSARIO', 69991),
('63001', '63', 'ARMENIA', 0),
('63111', '63', 'BUENAVISTA', 0),
('63130', '63', 'CALARCA', 71605),
('63190', '63', 'CIRCASIA', 26705),
('63212', '63', 'CORDOBA', 5238),
('63272', '63', 'FILANDIA', 12510),
('63302', '63', 'GENOVA', 9293),
('63401', '63', 'LA TEBAIDA', 32748),
('63470', '63', 'MONTENEGRO', 38714),
('63548', '63', 'PIJAO', 6421),
('63594', '63', 'QUIMBAYA', 32928),
('63690', '63', 'SALENTO', 7001),
('66001', '66', 'PEREIRA', 428397),
('66045', '66', 'APIA', 16886),
('66075', '66', 'BALBOA', 6081),
('66088', '66', 'BELEN DE UMBRIA', 26603),
('66170', '66', 'DOS QUEBRADAS', 173452),
('66318', '66', 'GUATICA', 15102),
('66383', '66', 'LA CELIA', 8348),
('66400', '66', 'LA VIRGINIA', 30095),
('66440', '66', 'MARSELLA', 20683),
('66456', '66', 'MISTRATO', 12438),
('66572', '66', 'PUEBLO RICO', 11436),
('66594', '66', 'QUINCHIA', 31996),
('66682', '66', 'SANTA ROSA DE CABAL', 67410),
('66687', '66', 'SANTUARIO', 14736),
('68001', '68', 'BUCARAMANGA', 509918),
('68013', '68', 'AGUADA', 1494),
('68020', '68', 'ALBANIA', 0),
('68051', '68', 'ARATOCA', 8285),
('68077', '68', 'BARBOSA', 0),
('68079', '68', 'BARICHARA', 7063),
('68081', '68', 'BARRANCABERMEJA', 187311),
('68092', '68', 'BETULIA', 0),
('68101', '68', 'BOLIVAR', 0),
('68121', '68', 'CABRERA', 0),
('68132', '68', 'CALIFORNIA', 1783),
('68147', '68', 'CAPITANEJO', 5988),
('68152', '68', 'CARCASI', 5073),
('68160', '68', 'CEPITA', 1984),
('68162', '68', 'CERRITO', 6187),
('68167', '68', 'CHARALA', 11119),
('68169', '68', 'CHARTA', 3069),
('68176', '68', 'CHIMA', 3273),
('68179', '68', 'CHIPATA', 4972),
('68190', '68', 'CIMITARRA', 30843),
('68207', '68', 'CONCEPCION', 0),
('68209', '68', 'CONFINES', 2705),
('68211', '68', 'CONTRATACION', 3904),
('68217', '68', 'COROMORO', 6110),
('68229', '68', 'CURITI', 11343),
('68235', '68', 'EL CARMEN DE CHUCURI', 18103),
('68245', '68', 'EL GUACAMAYO', 2482),
('68250', '68', 'EL PEÑON', 0),
('68255', '68', 'EL PLAYON', 12880),
('68264', '68', 'ENCINO', 2668),
('68266', '68', 'ENCISO', 3894),
('68271', '68', 'EL FLORIAN', 6242),
('68276', '68', 'FLORIDABLANCA', 252472),
('68296', '68', 'GALAN', 2903),
('68298', '68', 'GAMBITA', 5079),
('68307', '68', 'GIRON', 135531),
('68318', '68', 'GUACA', 6761),
('68320', '68', 'GUADALUPE', 0),
('68322', '68', 'GUAPOTA', 2229),
('68324', '68', 'GUAVATA', 4149),
('68327', '68', 'GÜEPSA', 4200),
('68344', '68', 'HATO', 2358),
('68368', '68', 'JESUS MARIA', 3571),
('68370', '68', 'JORDAN', 897),
('68377', '68', 'LA BELLEZA', 6689),
('68385', '68', 'LANDAZURI', 13155),
('68397', '68', 'LA PAZ', 0),
('68406', '68', 'LEBRIJA', 30984),
('68418', '68', 'LOS SANTOS', 10614),
('68425', '68', 'MACARAVITA', 2640),
('68432', '68', 'MALAGA', 18334),
('68444', '68', 'MATANZA', 5689),
('68464', '68', 'MOGOTES', 10664),
('68468', '68', 'MOLAGAVITA', 5303),
('68498', '68', 'OCAMONTE', 4877),
('68500', '68', 'OIBA', 10815),
('68502', '68', 'ONZAGA', 5527),
('68522', '68', 'PALMAR', 2972),
('68524', '68', 'PALMAS DEL SOCORRO', 2391),
('68533', '68', 'PARAMO', 3643),
('68547', '68', 'PIEDECUESTA', 116736),
('68549', '68', 'PINCHOTE', 4365),
('68572', '68', 'PUENTE NACIONAL', 14243),
('68573', '68', 'PUERTO PARRA', 6462),
('68575', '68', 'PUERTO WILCHES', 31058),
('68615', '68', 'RIONEGRO', 26834),
('68655', '68', 'SABANA DE TORRES', 19448),
('68669', '68', 'SAN ANDRES', 9480),
('68673', '68', 'SAN BENITO', 3844),
('68679', '68', 'SAN GIL', 42988),
('68682', '68', 'SAN JOAQUIN', 2862),
('68684', '68', 'SAN JOSE DE MIRANDA', 4740),
('68686', '68', 'SAN MIGUEL', 2592),
('68689', '68', 'SAN VICENTE DE CHUCURI', 28084),
('68705', '68', 'SANTA BARBARA', 0),
('68720', '68', 'SANTA HELENA DEL OPON', 4329),
('68745', '68', 'SIMACOTA', 8744),
('68755', '68', 'SOCORRO', 28758),
('68770', '68', 'SUAITA', 9969),
('68773', '68', 'SUCRE', 0),
('68780', '68', 'SURATA', 3565),
('68820', '68', 'TONA', 6651),
('68855', '68', 'VALLE SAN JOSE', 5082),
('68861', '68', 'VELEZ', 18177),
('68867', '68', 'VETAS', 1709),
('68872', '68', 'VILLANUEVA', 0),
('68895', '68', 'ZAPATOCA', 9255),
('70001', '70', 'SINCELEJO', 236780),
('70110', '70', 'BUENAVISTA', 0),
('70124', '70', 'CAIMITO', 10960),
('70204', '70', 'COLOSO', 6013),
('70215', '70', 'COROZAL', 57300),
('70221', '70', 'COVEÑAS', 11270),
('70230', '70', 'CHALAN', 3870),
('70233', '70', 'EL ROBLE', 9407),
('70235', '70', 'GALERAS', 17251),
('70265', '70', 'GUARANDA', 15434),
('70400', '70', 'LA UNION', 10279),
('70418', '70', 'LOS PALMITOS', 18916),
('70429', '70', 'MAJAGUAL', 31213),
('70473', '70', 'MORROA', 12784),
('70508', '70', 'OVEJAS', 21149),
('70523', '70', 'PALMITO', 11432),
('70670', '70', 'SAMPUES', 36090),
('70678', '70', 'SAN BENITO ABAD', 22802),
('70702', '70', 'SAN JUAN BETULIA', 12215),
('70708', '70', 'SAN MARCOS', 50336),
('70713', '70', 'SAN ONOFRE', 45672),
('70717', '70', 'SAN PEDRO', 0),
('70742', '70', 'SINCE', 30406),
('70771', '70', 'SUCRE', 0),
('70820', '70', 'SANTIAGO DE TOLÚ', 27957),
('70823', '70', 'TOLÚ VIEJO', 18587),
('73001', '73', 'IBAGUE', 495246),
('73024', '73', 'ALPUJARRA', 5098),
('73026', '73', 'ALVARADO', 8873),
('73030', '73', 'AMBALEMA', 7563),
('73043', '73', 'ANZOATEGUI', 16546),
('73055', '73', 'ARMERO GUAYABAL', 12852),
('73067', '73', 'ATACO', 21603),
('73124', '73', 'CAJAMARCA', 19501),
('73148', '73', 'CARMEN APICALA', 8330),
('73152', '73', 'CASABIANCA', 6793),
('73168', '73', 'CHAPARRAL', 46090),
('73200', '73', 'COELLO', 8940),
('73217', '73', 'COYAIMA', 27733),
('73226', '73', 'CUNDAY', 8445),
('73236', '73', 'DOLORES', 8269),
('73268', '73', 'ESPINAL', 75375),
('73270', '73', 'FALAN', 7923),
('73275', '73', 'FLANDES', 27683),
('73283', '73', 'FRESNO', 30750),
('73319', '73', 'GUAMO', 34254),
('73347', '73', 'HERVEO', 8901),
('73349', '73', 'HONDA', 26873),
('73352', '73', 'ICONONZO', 10130),
('73408', '73', 'LERIDA', 18115),
('73411', '73', 'LIBANO', 41650),
('73443', '73', 'MARIQUITA', 32642),
('73449', '73', 'MELGAR', 32636),
('73461', '73', 'MURILLO', 4953),
('73483', '73', 'NATAGAIMA', 20268),
('73504', '73', 'ORTEGA', 33297),
('73520', '73', 'PALOCABILDO', 9433),
('73547', '73', 'PIEDRAS', 5370),
('73555', '73', 'PLANADAS', 28808),
('73563', '73', 'PRADO', 8605),
('73585', '73', 'PURIFICACION', 27586),
('73616', '73', 'RIOBLANCO', 24993),
('73622', '73', 'RONCESVALLES', 6090),
('73624', '73', 'ROVIRA', 21250),
('73671', '73', 'SALDAÑA', 14732),
('73675', '73', 'SAN ANTONIO', 14970),
('73678', '73', 'SAN LUIS', 0),
('73686', '73', 'SANTA ISABEL', 6453),
('73770', '73', 'SUAREZ', 0),
('73854', '73', 'VALLE DE SAN JUAN', 6131),
('73861', '73', 'VENADILLO', 18576),
('73870', '73', 'VILLAHERMOSA', 10919),
('73873', '73', 'VILLARRICA', 6010),
('76000', '76', 'BOLIVAR', 0),
('76001', '76', 'CALI', 2075380),
('76020', '76', 'ALCALA', 12716),
('76036', '76', 'ANDALUCIA', 17518),
('76041', '76', 'ANSERMANUEVO', 19836),
('76054', '76', 'ARGELIA', 0),
('76100', '76', 'BOLIVAR', 14827),
('76109', '76', 'BUENAVENTURA', 325090),
('76111', '76', 'GUADALAJARA DE BUGA', 113903),
('76113', '76', 'BUGALAGRANDE', 20990),
('76122', '76', 'CAICEDONIA', 29972),
('76126', '76', 'CALIMA', 15715),
('76130', '76', 'CANDELARIA', 0),
('76147', '76', 'CARTAGO', 121741),
('76233', '76', 'DAGUA', 34310),
('76243', '76', 'EL AGUILA', 10380),
('76246', '76', 'EL CAIRO', 9105),
('76248', '76', 'EL CERRITO', 53244),
('76250', '76', 'EL DOVIO', 9138),
('76275', '76', 'FLORIDA', 54626),
('76306', '76', 'GINEBRA', 18808),
('76318', '76', 'GUACARI', 31055),
('76364', '76', 'JAMUNDI', 96095),
('76377', '76', 'LA CUMBRE', 10822),
('76400', '76', 'LA UNION', 31075),
('76403', '76', 'LA VICTORIA', 0),
('76497', '76', 'OBANDO', 14009),
('76520', '76', 'PALMIRA', 278388),
('76563', '76', 'PRADERA', 47755),
('76606', '76', 'RESTREPO', 14518),
('76616', '76', 'RIOFRIO', 15402),
('76622', '76', 'ROLDANILLO', 33697),
('76670', '76', 'SAN PEDRO', 0),
('76736', '76', 'SEVILLA', 41659),
('76823', '76', 'TORO', 15395),
('76828', '76', 'TRUJILLO', 18142),
('76834', '76', 'TULUA', 183236),
('76845', '76', 'ULLOA', 5166),
('76863', '76', 'VERSALLES', 7987),
('76869', '76', 'VIJES', 9606),
('76890', '76', 'YOTOCO', 14537),
('76892', '76', 'YUMBO', 90642),
('76895', '76', 'ZARZAL', 39850),
('81001', '81', 'ARAUCA', 74385),
('81065', '81', 'ARAUQUITA', 20981),
('81220', '81', 'CRAVO NORTE', 3312),
('81300', '81', 'FORTUL', 15500),
('81591', '81', 'PUERTO RONDON', 3670),
('81736', '81', 'SARAVENA', 43063),
('81794', '81', 'TAME', 47694),
('85001', '85', 'YOPAL', 103754),
('85010', '85', 'AGUAZUL', 27443),
('85015', '85', 'CHAMEZA', 1697),
('85125', '85', 'HATO COROZAL', 9618),
('85136', '85', 'LA SALINA', 1236),
('85139', '85', 'MANI', 10493),
('85162', '85', 'MONTERREY', 11421),
('85225', '85', 'NUNCHIA', 7909),
('85230', '85', 'OROCUE', 7324),
('85250', '85', 'PAZ DE ARIPORO', 25399),
('85263', '85', 'PORE', 7490),
('85279', '85', 'RECETOR', 2454),
('85300', '85', 'SABANALARGA', 0),
('85315', '85', 'SACAMA', 1638),
('85325', '85', 'SAN LUIS DE PALENQUE', 6982),
('85400', '85', 'TAMARA', 6653),
('85410', '85', 'TAURAMENA', 15896),
('85430', '85', 'TRINIDAD', 11083),
('85440', '85', 'VILLANUEVA', 0),
('86001', '86', 'MOCOA', 36185),
('86219', '86', 'COLON', 0),
('86320', '86', 'ORITO', 39519),
('86568', '86', 'PUERTO ASIS', 55878),
('86569', '86', 'PUERTO CAICEDO', 14168),
('86571', '86', 'PUERTO GUZMAN', 15867),
('86573', '86', 'LEGUÍZAMO', 14680),
('86749', '86', 'SIBUNDOY', 13340),
('86755', '86', 'SAN FRANCISCO', 0),
('86757', '86', 'SAN MIGUEL', 0),
('86760', '86', 'SANTIAGO', 0),
('86865', '86', 'VALLE DEL GUAMUEZ', 45601),
('86885', '86', 'VILLAGARZON', 20646),
('88001', '88', 'SAN ANDRES', 0),
('88564', '88', 'PROVIDENCIA Y SANTA CATALINA', 0),
('91001', '91', 'LETICIA', 32450),
('91263', '91', 'EL ENCANTO', 4247),
('91405', '91', 'LA CHORRERA', 2031),
('91407', '91', 'LA PEDRERA', 1456),
('91430', '91', 'LA VICTORIA', 0),
('91460', '91', 'MIRITI-PARANA', 701),
('91530', '91', 'PUERTO ALEGRIA', 1390),
('91536', '91', 'PUERTO ARICA', 1343),
('91540', '91', 'PUERTO NARIÑO', 6836),
('91669', '91', 'PUERTO SANTANDER', 0),
('91798', '91', 'TARAPACA', 2407),
('91970', '91', 'PUERTO ALEGRIA', 0),
('94001', '94', 'INIRIDA', 15827),
('94343', '94', 'BARRANCO MINA', 4202),
('94663', '94', 'MAPIRIPANA', 2895),
('94883', '94', 'SAN FELIPE', 1238),
('94884', '94', 'PUERTO COLOMBIA', 0),
('94885', '94', 'LA GUADALUPE', 226),
('94886', '94', 'CACAHUAL', 1662),
('94887', '94', 'PANA PANA', 2189),
('94888', '94', 'MORICHAL', 776),
('95001', '95', 'SAN JOSE DEL GUAVIARE', 45573),
('95015', '95', 'CALAMAR', 0),
('95025', '95', 'EL RETORNO', 18474),
('95200', '95', 'MIRAFLORES', 0),
('97001', '97', 'MITU', 17641),
('97161', '97', 'CARURU', 2000),
('97511', '97', 'PACOA', 4412),
('97666', '97', 'TARAIRA', 1015),
('97777', '97', 'PAPUNAHUA', 855),
('97889', '97', 'YAVARATE', 1201),
('99001', '99', 'PUERTO CARREÑO', 12897),
('99524', '99', 'LA PRIMAVERA', 10269),
('99624', '99', 'SANTA ROSALIA', 3188),
('99773', '99', 'CUMARIBO', 28804);

-- --------------------------------------------------------

--
-- Table structure for table `opcion`
--

CREATE TABLE `opcion` (
  `opc_id` int(11) NOT NULL COMMENT 'Identificador de la opcion',
  `opc_nombre` varchar(60) NOT NULL DEFAULT '' COMMENT 'Nombre de la opcion',
  `opc_variable` varchar(50) NOT NULL COMMENT 'Variable que se controla para la ejecucion de la accion asociada a la opcion',
  `opc_url` varchar(250) NOT NULL COMMENT 'URL de la opcion',
  `opn_id` int(1) NOT NULL DEFAULT '0' COMMENT 'Nivel de la opcion',
  `opc_padre_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Id de la opcion padre',
  `opc_orden` int(10) NOT NULL DEFAULT '0' COMMENT 'Orden de la opcion',
  `layout` varchar(60) NOT NULL DEFAULT '' COMMENT 'Layout asociado a la opcion',
  `ope_id` int(11) DEFAULT NULL COMMENT 'Id del operador'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene las opciones para crear el menu';

--
-- Dumping data for table `opcion`
--

INSERT INTO `opcion` (`opc_id`, `opc_nombre`, `opc_variable`, `opc_url`, `opn_id`, `opc_padre_id`, `opc_orden`, `layout`, `ope_id`) VALUES
(1, 'PRINCIPAL', '', '', 0, 0, 100000, '', 1),
(2, 'ADMIN', '', '', 0, 0, 200000, '', 1),
(3, 'SEGURIDAD', '', '', 0, 0, 900000, '', 1),
(4, 'Inicio', 'home', 'home.php', 1, 1, 101000, '', 1),
(5, 'Tablas Basicas', 'tablas', 'tablas/tablas.php', 1, 3, 901000, '', 1),
(6, 'Usuarios', 'usuarios', 'usuarios/usuarios.php', 1, 3, 902000, '', 1),
(7, 'Perfiles', 'perfiles', 'perfiles/perfiles.php', 1, 3, 903000, '', 1),
(8, 'Opciones', 'opciones', 'opciones/opciones.php', 1, 3, 904000, '', 1),
(9, 'Cambiar Clave', 'usuarios&task=editClave', 'usuarios/usuarios.php', 1, 3, 908000, '', 1),
(10, 'Cerrar Sesion', 'cerrar', 'cerrar.php', 1, 3, 909000, 'login_layout.php', 1),
(66, 'Documental', 'documentos', 'documentos/documentos.php', 1, 2, 202000, '', 1),
(67, 'Comunicados', 'comunicados', 'documentos/comunicados.php', 1, 2, 201000, '', 1),
(68, 'Compromisos', 'compromisos', 'documentos/compromisos.php', 1, 2, 203000, '', 1),
(87, 'Obtencion token', 'getToken', 'documentos/obtencion_token.php', 1, 2, 209000, '', 1),
(86, 'Riesgos', 'riesgos', 'riesgos/riesgos.php', 1, 2, 204000, '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `opcion_nivel`
--

CREATE TABLE `opcion_nivel` (
  `opn_id` int(1) NOT NULL COMMENT 'Identificador del nivel',
  `opn_nombre` varchar(25) NOT NULL COMMENT 'Nombre del nivel'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los niveles de las opciones';

--
-- Dumping data for table `opcion_nivel`
--

INSERT INTO `opcion_nivel` (`opn_id`, `opn_nombre`) VALUES
(0, 'encabezado'),
(1, 'modulo'),
(2, 'opcion del modulo');

-- --------------------------------------------------------

--
-- Table structure for table `operador`
--

CREATE TABLE `operador` (
  `ope_id` int(11) NOT NULL COMMENT 'Identificador del operador',
  `ope_nombre` varchar(50) NOT NULL COMMENT 'Nombre del operador',
  `ope_sigla` varchar(20) NOT NULL COMMENT 'Sigla del operador',
  `ope_contrato_no` varchar(45) DEFAULT NULL COMMENT 'Nro de contrato del operador',
  `ope_contrato_valor` decimal(19,2) DEFAULT NULL COMMENT 'Valor del contrato del operador'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los operadores que forman parte del contrato';

--
-- Dumping data for table `operador`
--

INSERT INTO `operador` (`ope_id`, `ope_nombre`, `ope_sigla`, `ope_contrato_no`, `ope_contrato_valor`) VALUES
(1, 'OPERADOR', 'OPR', '1', '1.00');

-- --------------------------------------------------------

--
-- Table structure for table `perfil`
--

CREATE TABLE `perfil` (
  `per_id` int(11) NOT NULL COMMENT 'Identificador del perfil',
  `per_nombre` varchar(50) NOT NULL COMMENT 'Nombre del perfil'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los perfiles de acceso al sistema';

--
-- Dumping data for table `perfil`
--

INSERT INTO `perfil` (`per_id`, `per_nombre`) VALUES
(1, 'Administrador'),
(2, 'Consulta'),
(7, 'Demo');

-- --------------------------------------------------------

--
-- Table structure for table `perfil_x_opcion`
--

CREATE TABLE `perfil_x_opcion` (
  `per_id` int(11) NOT NULL COMMENT 'Id del perfil',
  `opc_id` int(11) NOT NULL COMMENT 'Id de la opcion',
  `pxo_nivel` int(1) NOT NULL COMMENT 'Nivel de acceso a la opcion'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene la relacion perfil vs opcion';

--
-- Dumping data for table `perfil_x_opcion`
--

INSERT INTO `perfil_x_opcion` (`per_id`, `opc_id`, `pxo_nivel`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(1, 10, 1),
(1, 66, 1),
(1, 67, 1),
(1, 68, 1),
(1, 87, 1),
(7, 1, 2),
(7, 2, 2),
(7, 3, 2),
(7, 4, 2),
(7, 5, 2),
(7, 6, 2),
(7, 7, 2),
(7, 8, 2),
(7, 9, 1),
(7, 10, 2),
(7, 66, 1),
(7, 67, 1),
(7, 68, 1);

-- --------------------------------------------------------

--
-- Table structure for table `riesgo`
--

CREATE TABLE `riesgo` (
  `rie_id` int(11) NOT NULL COMMENT 'Identificador de los riesgos',
  `rie_descripcion` text NOT NULL COMMENT 'Descripcion del riesgo',
  `rie_fecha_deteccion` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Fecha de deteccion del riesgo',
  `rie_estrategia` text NOT NULL COMMENT 'Estrategia de mitigacion',
  `rim_id` int(1) NOT NULL COMMENT 'Id del impacto',
  `rpr_id` int(1) NOT NULL COMMENT 'Id de la probabilidad',
  `rca_id` int(1) NOT NULL COMMENT 'Id de la categoria',
  `rie_fecha_actualizacion` date DEFAULT '0000-00-00' COMMENT 'Fecha de actualizacion del riesgo',
  `alc_id` int(11) NOT NULL COMMENT 'Id del alcance',
  `res_id` int(1) NOT NULL COMMENT 'Id del estado del riesgo'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los riesgos';

-- --------------------------------------------------------

--
-- Table structure for table `riesgo_accion`
--

CREATE TABLE `riesgo_accion` (
  `rac_id` int(11) NOT NULL COMMENT 'Identificador de la accion',
  `rie_id` int(11) NOT NULL COMMENT 'Id del riesgo',
  `rac_descripcion` text NOT NULL COMMENT 'Descripcion de la accion',
  `deq_id` int(11) NOT NULL COMMENT 'Id del responsable del equipo',
  `rac_fecha` date NOT NULL DEFAULT '0000-00-00' COMMENT 'Fecha de la accion',
  `rim_id` int(11) NOT NULL COMMENT 'Id del impacto',
  `rpr_id` int(11) NOT NULL COMMENT 'Id de la probabilidad',
  `rca_id` int(11) NOT NULL COMMENT 'Id de la categoria',
  `rca_valor` float NOT NULL COMMENT 'Valor de mitigacion (porcentaje)'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene las acciones de mitigacion del riesgo';

-- --------------------------------------------------------

--
-- Table structure for table `riesgo_categoria`
--

CREATE TABLE `riesgo_categoria` (
  `rca_id` int(1) NOT NULL COMMENT 'Identificador de la categoria',
  `rca_nombre` varchar(500) NOT NULL COMMENT 'Nombre de la categoria',
  `rca_minimo` float NOT NULL COMMENT 'Minimo del rango de la categoria',
  `rca_maximo` float NOT NULL COMMENT 'Maximo de la categoria'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene las categorias de los riesgos';

--
-- Dumping data for table `riesgo_categoria`
--

INSERT INTO `riesgo_categoria` (`rca_id`, `rca_nombre`, `rca_minimo`, `rca_maximo`) VALUES
(1, 'Muy bajo', 0, 0.006),
(2, 'Bajo', 0.006, 0.05),
(3, 'Medio', 0.05, 0.14),
(4, 'Alto', 0.14, 0.71),
(5, 'Muy alto', 0.71, 0.73);

-- --------------------------------------------------------

--
-- Table structure for table `riesgo_estado`
--

CREATE TABLE `riesgo_estado` (
  `res_id` int(1) NOT NULL COMMENT 'Identificador del estado',
  `res_nombre` varchar(500) NOT NULL COMMENT 'Nombre del estado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los posibles estados de los riesgos';

--
-- Dumping data for table `riesgo_estado`
--

INSERT INTO `riesgo_estado` (`res_id`, `res_nombre`) VALUES
(1, 'Aceptado'),
(2, 'Cerrado sin mitigacion'),
(3, 'Latente'),
(4, 'Materializado'),
(5, 'Mitigado');

-- --------------------------------------------------------

--
-- Table structure for table `riesgo_impacto`
--

CREATE TABLE `riesgo_impacto` (
  `rim_id` int(1) NOT NULL COMMENT 'Identificador de impacto',
  `rim_nombre` varchar(500) NOT NULL COMMENT 'Nombre del impacto',
  `rim_valor` float NOT NULL COMMENT 'Valor representativo del impacto'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los impactos de los riesgos';

--
-- Dumping data for table `riesgo_impacto`
--

INSERT INTO `riesgo_impacto` (`rim_id`, `rim_nombre`, `rim_valor`) VALUES
(1, 'Muy bajo', 0.05),
(2, 'Bajo', 0.1),
(3, 'Medio', 0.2),
(4, 'Alto', 0.4),
(5, 'Muy alto', 0.8),
(6, 'Sin definir', 0);

-- --------------------------------------------------------

--
-- Table structure for table `riesgo_probabilidad`
--

CREATE TABLE `riesgo_probabilidad` (
  `rpr_id` int(1) NOT NULL COMMENT 'Identificador de probabilidades',
  `rpr_nombre` varchar(500) NOT NULL COMMENT 'Nombre de la probabilidad',
  `rpr_valor` float NOT NULL COMMENT 'Valor de probabilidad'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene las probabilidades de los riesgos';

--
-- Dumping data for table `riesgo_probabilidad`
--

INSERT INTO `riesgo_probabilidad` (`rpr_id`, `rpr_nombre`, `rpr_valor`) VALUES
(1, 'Muy baja', 0.1),
(2, 'Baja', 0.3),
(3, 'Media', 0.5),
(4, 'Alta', 0.7),
(5, 'Muy alta', 0.9),
(6, 'Sin definir', 0);

-- --------------------------------------------------------

--
-- Table structure for table `riesgo_responsable`
--

CREATE TABLE `riesgo_responsable` (
  `rir_id` int(11) NOT NULL COMMENT 'Identificador del responsable del riesgo',
  `rie_id` int(11) NOT NULL COMMENT 'Identificador del riesgo',
  `doa_id` int(11) NOT NULL COMMENT 'Identificador del actor'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los responsables de los riesgos';

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE `usuario` (
  `usu_id` int(11) NOT NULL COMMENT 'Identificador del usuario para el sistema',
  `per_id` int(11) NOT NULL COMMENT 'Id del perfil',
  `usu_login` varchar(15) NOT NULL COMMENT 'Login del usuario',
  `usu_clave` varchar(100) NOT NULL COMMENT 'Clave del usuario',
  `usu_nombre` varchar(100) NOT NULL COMMENT 'Nombre del usuario',
  `usu_apellido` varchar(100) NOT NULL COMMENT 'Apellido del usurio',
  `usu_documento` varchar(20) NOT NULL DEFAULT '' COMMENT 'Documeno del usuario',
  `usu_telefono` varchar(20) NOT NULL DEFAULT '' COMMENT 'Telefono del usuario',
  `usu_celular` varchar(20) NOT NULL DEFAULT '' COMMENT 'Celular del usuario',
  `usu_correo` varchar(200) NOT NULL DEFAULT '' COMMENT 'Direccion de correo del usuario',
  `usu_estado` int(1) NOT NULL DEFAULT '1' COMMENT 'Estado del usuario en el sistema (1 activo 0 inactivo)',
  `usu_fecha_ultimo_ingreso` date NOT NULL COMMENT 'Fecha de ultimo ingreso al sistema'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los usuarios';

--
-- Dumping data for table `usuario`
--

INSERT INTO `usuario` (`usu_id`, `per_id`, `usu_login`, `usu_clave`, `usu_nombre`, `usu_apellido`, `usu_documento`, `usu_telefono`, `usu_celular`, `usu_correo`, `usu_estado`, `usu_fecha_ultimo_ingreso`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Usuario', 'Administrador', '123456', '12336655', '3158989898', 'admin@mail.com', 1, '2019-02-03'),
(64, 2, 'consulta', '5d76beffe761403531a6eb339e0f0231', 'consulta', 'consulta', '63526847', '74563987', '3000000000', 'xxx@redcom.com.co', 1, '2014-08-01'),
(98, 7, 'demo', 'fe01ce2a7fbac8fafaed7c982a04e229', 'Usuario', 'Demo', '1234567', '23222222', '3113222222', 'mail@mail.com', 1, '2019-02-01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alcance`
--
ALTER TABLE `alcance`
  ADD PRIMARY KEY (`alc_id`),
  ADD KEY `FK_ALCANCE_CONTRATANTE` (`deq_id_contratante`),
  ADD KEY `FK_ALCANCE_CONTRATISTA` (`deq_id_contratista`),
  ADD KEY `FK_ALCANCE_ESTADO` (`ale_id`),
  ADD KEY `FK_ALCANCE_INTERVENTORIA` (`deq_id_interventoria`);

--
-- Indexes for table `alcance_estado`
--
ALTER TABLE `alcance_estado`
  ADD PRIMARY KEY (`ale_id`);

--
-- Indexes for table `compromiso`
--
ALTER TABLE `compromiso`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `FK_COMPROMISO1_TIPO_ESTADO` (`ces_id`),
  ADD KEY `FK_COMPROMISO1_DOCUMENTO` (`doc_id`),
  ADD KEY `fk_compromiso_operador_idx` (`ope_id`);

--
-- Indexes for table `compromiso_estado`
--
ALTER TABLE `compromiso_estado`
  ADD PRIMARY KEY (`ces_id`);

--
-- Indexes for table `compromiso_responsable`
--
ALTER TABLE `compromiso_responsable`
  ADD PRIMARY KEY (`cor_id`),
  ADD KEY `FK_COMPROMISO_COMPROMISO` (`com_id`),
  ADD KEY `FK_COMPROMISO_ACTOR` (`doa_id`);

--
-- Indexes for table `compromiso_resumen`
--
ALTER TABLE `compromiso_resumen`
  ADD PRIMARY KEY (`cor_nombre_tmp`),
  ADD KEY `fk_compromiso_resumen_operador_idx` (`ope_id`);

--
-- Indexes for table `departamento`
--
ALTER TABLE `departamento`
  ADD PRIMARY KEY (`dep_id`),
  ADD KEY `FK_OPERADOR` (`ope_id`),
  ADD KEY `FK_REGION` (`dpr_id`);

--
-- Indexes for table `departamento_region`
--
ALTER TABLE `departamento_region`
  ADD PRIMARY KEY (`dpr_id`);

--
-- Indexes for table `documento`
--
ALTER TABLE `documento`
  ADD PRIMARY KEY (`doc_id`),
  ADD UNIQUE KEY `UK_DOC_ID_TIPO_ARCHIVO` (`doc_id`,`dti_id`,`doc_archivo`) USING BTREE,
  ADD KEY `FK_DOCUMENTO_TIPO` (`dti_id`),
  ADD KEY `FK_DOCUMENTO_TEMA` (`dot_id`),
  ADD KEY `FK_DOCUMENTO_SUBTEMA` (`dos_id`),
  ADD KEY `FK_DOCUMENTO_ESTADO` (`doe_id`),
  ADD KEY `FK_DOCUMENTO_OPERADOR` (`ope_id`);

--
-- Indexes for table `documento_actor`
--
ALTER TABLE `documento_actor`
  ADD PRIMARY KEY (`doa_id`),
  ADD KEY `FK_OPERADOR` (`ope_id`),
  ADD KEY `FK_DOCUMENTO_TIPO_ACTOR` (`dta_id`);

--
-- Indexes for table `documento_articulo`
--
ALTER TABLE `documento_articulo`
  ADD PRIMARY KEY (`doa_id`),
  ADD UNIQUE KEY `UK_NOMBRE` (`doa_nombre`,`doc_id`,`alc_id`) USING BTREE,
  ADD KEY `FK_DOCUMENTO` (`doc_id`),
  ADD KEY `FK_ALCANCE` (`alc_id`);

--
-- Indexes for table `documento_comunicado`
--
ALTER TABLE `documento_comunicado`
  ADD PRIMARY KEY (`doc_id`),
  ADD UNIQUE KEY `UK_DOC_ID_TIPO_ARCHIVO` (`doc_id`,`dti_id`,`doc_archivo`),
  ADD KEY `FK_TIPO` (`dti_id`),
  ADD KEY `FK_TEMA` (`dot_id`),
  ADD KEY `FK_SUBTEMA` (`dos_id`),
  ADD KEY `FK_AUTOR` (`doa_id_autor`),
  ADD KEY `FK_DESTINATARIO` (`doa_id_dest`),
  ADD KEY `FK_OPERADOR` (`ope_id`),
  ADD KEY `FK_documento_comunicado_estado_rta` (`der_id`);

--
-- Indexes for table `documento_comunicado_soporte`
--
ALTER TABLE `documento_comunicado_soporte`
  ADD PRIMARY KEY (`dcs_id`),
  ADD UNIQUE KEY `UK_ARCHIVO` (`dcs_archivo`),
  ADD KEY `FK_COMUNICADO` (`doc_id`);

--
-- Indexes for table `documento_equipo`
--
ALTER TABLE `documento_equipo`
  ADD PRIMARY KEY (`deq_id`),
  ADD UNIQUE KEY `UK_DOCUMENTO_EQUIPO` (`doa_id`,`usu_id`),
  ADD KEY `FK_DOCUMENTO_EQUIPO_USUARIO` (`usu_id`),
  ADD KEY `FK_DOCUMENTO_EQUIPO_ACTOR` (`doa_id`);

--
-- Indexes for table `documento_estado`
--
ALTER TABLE `documento_estado`
  ADD PRIMARY KEY (`doe_id`);

--
-- Indexes for table `documento_estado_respuesta`
--
ALTER TABLE `documento_estado_respuesta`
  ADD PRIMARY KEY (`der_id`);

--
-- Indexes for table `documento_subtema`
--
ALTER TABLE `documento_subtema`
  ADD PRIMARY KEY (`dos_id`),
  ADD KEY `FK_SUBTEMA1_documento_TEMA` (`dot_id`);

--
-- Indexes for table `documento_tema`
--
ALTER TABLE `documento_tema`
  ADD PRIMARY KEY (`dot_id`),
  ADD UNIQUE KEY `UK_TIPO_TEMA` (`dot_nombre`,`dti_id`),
  ADD KEY `FK_TEMA1_DOCUMENTO_TIPO` (`dti_id`);

--
-- Indexes for table `documento_tipo`
--
ALTER TABLE `documento_tipo`
  ADD PRIMARY KEY (`dti_id`);

--
-- Indexes for table `documento_tipo_actor`
--
ALTER TABLE `documento_tipo_actor`
  ADD PRIMARY KEY (`dta_id`);

--
-- Indexes for table `festivos_colombia`
--
ALTER TABLE `festivos_colombia`
  ADD UNIQUE KEY `UK_FECHA` (`fes_id`);

--
-- Indexes for table `municipio`
--
ALTER TABLE `municipio`
  ADD PRIMARY KEY (`mun_id`),
  ADD KEY `FK_MUNICIPIO_DEPARTAMENTO` (`dep_id`);

--
-- Indexes for table `opcion`
--
ALTER TABLE `opcion`
  ADD PRIMARY KEY (`opc_id`),
  ADD KEY `FK_OPCION_NIVEL` (`opn_id`);

--
-- Indexes for table `opcion_nivel`
--
ALTER TABLE `opcion_nivel`
  ADD PRIMARY KEY (`opn_id`);

--
-- Indexes for table `operador`
--
ALTER TABLE `operador`
  ADD PRIMARY KEY (`ope_id`);

--
-- Indexes for table `perfil`
--
ALTER TABLE `perfil`
  ADD PRIMARY KEY (`per_id`);

--
-- Indexes for table `perfil_x_opcion`
--
ALTER TABLE `perfil_x_opcion`
  ADD PRIMARY KEY (`per_id`,`opc_id`),
  ADD KEY `FK_PERFIL_OPCION_PERFIL` (`per_id`),
  ADD KEY `FK_PERFIL_OPCION_OPCION` (`opc_id`);

--
-- Indexes for table `riesgo`
--
ALTER TABLE `riesgo`
  ADD PRIMARY KEY (`rie_id`),
  ADD KEY `FK_ALCANCE` (`alc_id`),
  ADD KEY `FK_CATEGORIA` (`rca_id`),
  ADD KEY `FK_IMPACTO` (`rim_id`),
  ADD KEY `FK_PROBABILIDAD` (`rpr_id`),
  ADD KEY `FK_ESTADO` (`res_id`);

--
-- Indexes for table `riesgo_accion`
--
ALTER TABLE `riesgo_accion`
  ADD PRIMARY KEY (`rac_id`),
  ADD UNIQUE KEY `FK_RIESGO_FECHA` (`rie_id`,`rac_fecha`),
  ADD KEY `FK_RIESGO_ACCIONES_RIESGOS` (`rie_id`),
  ADD KEY `FK_RIESGO_CATEGORIAS` (`rca_id`),
  ADD KEY `FK_RIESGO_IMPACTO` (`rim_id`),
  ADD KEY `FK_RIESGO_PROBABILIDAD` (`rpr_id`),
  ADD KEY `FK_RIESGO_ACCIONES_EQUIPO` (`deq_id`);

--
-- Indexes for table `riesgo_categoria`
--
ALTER TABLE `riesgo_categoria`
  ADD PRIMARY KEY (`rca_id`);

--
-- Indexes for table `riesgo_estado`
--
ALTER TABLE `riesgo_estado`
  ADD PRIMARY KEY (`res_id`);

--
-- Indexes for table `riesgo_impacto`
--
ALTER TABLE `riesgo_impacto`
  ADD PRIMARY KEY (`rim_id`);

--
-- Indexes for table `riesgo_probabilidad`
--
ALTER TABLE `riesgo_probabilidad`
  ADD PRIMARY KEY (`rpr_id`);

--
-- Indexes for table `riesgo_responsable`
--
ALTER TABLE `riesgo_responsable`
  ADD PRIMARY KEY (`rir_id`),
  ADD KEY `FK_RIESGO_RIESGO` (`rie_id`),
  ADD KEY `FK_RIESGO_ACTOR` (`doa_id`);

--
-- Indexes for table `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`usu_id`),
  ADD UNIQUE KEY `UK_LOGIN` (`usu_login`),
  ADD KEY `FK_USUARIO_PERFIL` (`per_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alcance`
--
ALTER TABLE `alcance`
  MODIFY `alc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del alcance a controlar', AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `alcance_estado`
--
ALTER TABLE `alcance_estado`
  MODIFY `ale_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado del alcance', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `compromiso`
--
ALTER TABLE `compromiso`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del compromiso', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `compromiso_estado`
--
ALTER TABLE `compromiso_estado`
  MODIFY `ces_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado del compromiso', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `compromiso_responsable`
--
ALTER TABLE `compromiso_responsable`
  MODIFY `cor_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del responsable', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `departamento_region`
--
ALTER TABLE `departamento_region`
  MODIFY `dpr_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la region', AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `documento`
--
ALTER TABLE `documento`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del documento', AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `documento_actor`
--
ALTER TABLE `documento_actor`
  MODIFY `doa_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del actor', AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `documento_articulo`
--
ALTER TABLE `documento_articulo`
  MODIFY `doa_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del articulo';

--
-- AUTO_INCREMENT for table `documento_comunicado`
--
ALTER TABLE `documento_comunicado`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del comunicado', AUTO_INCREMENT=12345;

--
-- AUTO_INCREMENT for table `documento_comunicado_soporte`
--
ALTER TABLE `documento_comunicado_soporte`
  MODIFY `dcs_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del soporte';

--
-- AUTO_INCREMENT for table `documento_equipo`
--
ALTER TABLE `documento_equipo`
  MODIFY `deq_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de los equipos', AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT for table `documento_estado`
--
ALTER TABLE `documento_estado`
  MODIFY `doe_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado de los documentos', AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `documento_estado_respuesta`
--
ALTER TABLE `documento_estado_respuesta`
  MODIFY `der_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado de las respuestas', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `documento_subtema`
--
ALTER TABLE `documento_subtema`
  MODIFY `dos_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del subtema', AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `documento_tema`
--
ALTER TABLE `documento_tema`
  MODIFY `dot_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del tema', AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `documento_tipo`
--
ALTER TABLE `documento_tipo`
  MODIFY `dti_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del tipo', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `documento_tipo_actor`
--
ALTER TABLE `documento_tipo_actor`
  MODIFY `dta_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del tipo de actor', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `opcion`
--
ALTER TABLE `opcion`
  MODIFY `opc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la opcion', AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `opcion_nivel`
--
ALTER TABLE `opcion_nivel`
  MODIFY `opn_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del nivel', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `perfil`
--
ALTER TABLE `perfil`
  MODIFY `per_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del perfil', AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `riesgo`
--
ALTER TABLE `riesgo`
  MODIFY `rie_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de los riesgos';

--
-- AUTO_INCREMENT for table `riesgo_accion`
--
ALTER TABLE `riesgo_accion`
  MODIFY `rac_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la accion';

--
-- AUTO_INCREMENT for table `riesgo_categoria`
--
ALTER TABLE `riesgo_categoria`
  MODIFY `rca_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la categoria', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `riesgo_estado`
--
ALTER TABLE `riesgo_estado`
  MODIFY `res_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado', AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `riesgo_impacto`
--
ALTER TABLE `riesgo_impacto`
  MODIFY `rim_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de impacto', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `riesgo_probabilidad`
--
ALTER TABLE `riesgo_probabilidad`
  MODIFY `rpr_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de probabilidades', AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `riesgo_responsable`
--
ALTER TABLE `riesgo_responsable`
  MODIFY `rir_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del responsable del riesgo';

--
-- AUTO_INCREMENT for table `usuario`
--
ALTER TABLE `usuario`
  MODIFY `usu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del usuario para el sistema', AUTO_INCREMENT=99;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alcance`
--
ALTER TABLE `alcance`
  ADD CONSTRAINT `alcance_ibfk_1` FOREIGN KEY (`ale_id`) REFERENCES `alcance_estado` (`ale_id`),
  ADD CONSTRAINT `alcance_ibfk_2` FOREIGN KEY (`deq_id_contratante`) REFERENCES `documento_equipo` (`deq_id`),
  ADD CONSTRAINT `alcance_ibfk_3` FOREIGN KEY (`deq_id_contratista`) REFERENCES `documento_equipo` (`deq_id`),
  ADD CONSTRAINT `alcance_ibfk_4` FOREIGN KEY (`deq_id_interventoria`) REFERENCES `documento_equipo` (`deq_id`);

--
-- Constraints for table `compromiso`
--
ALTER TABLE `compromiso`
  ADD CONSTRAINT `fk_compromiso_compromiso_estado` FOREIGN KEY (`ces_id`) REFERENCES `compromiso_estado` (`ces_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compromiso_documento` FOREIGN KEY (`doc_id`) REFERENCES `documento` (`doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compromiso_operador` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `compromiso_responsable`
--
ALTER TABLE `compromiso_responsable`
  ADD CONSTRAINT `fk_compromiso_responsable_compromiso` FOREIGN KEY (`com_id`) REFERENCES `compromiso` (`com_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compromiso_responsable_documento_actor` FOREIGN KEY (`doa_id`) REFERENCES `documento_actor` (`doa_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `compromiso_resumen`
--
ALTER TABLE `compromiso_resumen`
  ADD CONSTRAINT `fk_compromiso_resumen_operador` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`),
  ADD CONSTRAINT `departamento_ibfk_2` FOREIGN KEY (`dpr_id`) REFERENCES `departamento_region` (`dpr_id`);

--
-- Constraints for table `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`dos_id`) REFERENCES `documento_subtema` (`dos_id`),
  ADD CONSTRAINT `documento_ibfk_3` FOREIGN KEY (`doe_id`) REFERENCES `documento_estado` (`doe_id`),
  ADD CONSTRAINT `fk_documento_documento_tema` FOREIGN KEY (`dot_id`) REFERENCES `documento_tema` (`dot_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_documento_tipo` FOREIGN KEY (`dti_id`) REFERENCES `documento_tipo` (`dti_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_operador` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `documento_actor`
--
ALTER TABLE `documento_actor`
  ADD CONSTRAINT `documento_actor_ibfk_1` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`),
  ADD CONSTRAINT `documento_actor_ibfk_2` FOREIGN KEY (`dta_id`) REFERENCES `documento_tipo_actor` (`dta_id`);

--
-- Constraints for table `documento_comunicado`
--
ALTER TABLE `documento_comunicado`
  ADD CONSTRAINT `FK_documento_comunicado_estado_rta` FOREIGN KEY (`der_id`) REFERENCES `documento_estado_respuesta` (`der_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_1` FOREIGN KEY (`dti_id`) REFERENCES `documento_tipo` (`dti_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_2` FOREIGN KEY (`dot_id`) REFERENCES `documento_tema` (`dot_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_3` FOREIGN KEY (`dos_id`) REFERENCES `documento_subtema` (`dos_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_4` FOREIGN KEY (`doa_id_autor`) REFERENCES `documento_actor` (`doa_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_5` FOREIGN KEY (`doa_id_dest`) REFERENCES `documento_actor` (`doa_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_6` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
