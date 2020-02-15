-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2019 at 01:19 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `kbt_poc_2019`
--

-- --------------------------------------------------------

--
-- Table structure for table `actividad`
--

CREATE TABLE `actividad` (
  `act_id` int(11) NOT NULL COMMENT 'id de la actividad',
  `act_descripcion` varchar(250) NOT NULL COMMENT 'descripción de la actividad',
  `act_fecha_inicio` date NOT NULL COMMENT 'fecha de inicio de la actividad',
  `act_fecha_fin` date DEFAULT NULL COMMENT 'fecha final de la actividad',
  `usu_id` int(11) NOT NULL COMMENT 'usuario eresponsable',
  `ace_id` int(11) NOT NULL COMMENT 'estado de la actividad',
  `act_inconvenientes` text COMMENT 'inconvenientes presentados durante la actividad',
  `acs_id` int(11) NOT NULL COMMENT 'subsistema de la actividad'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='actividades de los consultores';

-- --------------------------------------------------------

--
-- Table structure for table `actividad_estado`
--

CREATE TABLE `actividad_estado` (
  `ace_id` int(11) NOT NULL COMMENT 'identificador del estado de actividad',
  `ace_nombre` varchar(25) NOT NULL COMMENT 'nombre del estado'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `actividad_estado`
--

INSERT INTO `actividad_estado` (`ace_id`, `ace_nombre`) VALUES
(1, 'Completado'),
(2, 'Suspendido'),
(3, 'Seguimiento'),
(4, 'Aplazado');

-- --------------------------------------------------------

--
-- Table structure for table `actividad_subsistema`
--

CREATE TABLE `actividad_subsistema` (
  `acs_id` int(11) NOT NULL COMMENT 'identificador del subsistema',
  `acs_nombre` varchar(50) NOT NULL COMMENT 'nombre del subsistema'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='subsistemas de las actividades';

--
-- Dumping data for table `actividad_subsistema`
--

INSERT INTO `actividad_subsistema` (`acs_id`, `acs_nombre`) VALUES
(1, 'Subsistema de GIS-AVL-TDM'),
(2, 'Subsistema de Telefonía'),
(3, 'Subsistema de grabación de llamadas'),
(4, 'Subsistema de TIC'),
(5, 'Subsistema de Cliente AVL'),
(6, 'Subsistema de Cliente TDM'),
(7, 'Subsistema de Cliente PC'),
(8, 'Todos');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`act_id`);

--
-- Indexes for table `actividad_estado`
--
ALTER TABLE `actividad_estado`
  ADD PRIMARY KEY (`ace_id`);

--
-- Indexes for table `actividad_subsistema`
--
ALTER TABLE `actividad_subsistema`
  ADD PRIMARY KEY (`acs_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actividad`
--
ALTER TABLE `actividad`
  MODIFY `act_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'nombre de la actividad';

--
-- AUTO_INCREMENT for table `actividad_estado`
--
ALTER TABLE `actividad_estado`
  MODIFY `ace_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador del estado de actividad', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `actividad_subsistema`
--
ALTER TABLE `actividad_subsistema`
  MODIFY `acs_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador del subsistema', AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
