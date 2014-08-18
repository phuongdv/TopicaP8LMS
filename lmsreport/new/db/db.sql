-- phpMyAdmin SQL Dump
-- version 2.6.3-pl1
-- http://www.phpmyadmin.net
-- 
-- Host: localhost
-- Generation Time: Apr 18, 2007 at 04:43 PM
-- Server version: 4.1.13
-- PHP Version: 5.0.4
-- 
-- Database: `clase_listado`
-- 

-- --------------------------------------------------------

-- 
-- Table structure for table `clients`
-- 

CREATE TABLE `clients` (
  `code` int(6) NOT NULL auto_increment,
  `name` varchar(50) collate latin1_general_ci NOT NULL default '',
  `id` varchar(11) collate latin1_general_ci NOT NULL default '0',
  `birthday` date NOT NULL default '0000-00-00',
  `age` int(2) NOT NULL default '0',
  `vehicule_type` int(5) NOT NULL default '0',
  `inscription_date` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`code`),
  KEY `inscription` (`inscription_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=17774 ;

-- 
-- Dumping data for table `clients`
-- 

INSERT INTO `clients` VALUES (2, 'Linux Trolvars', '79467042', '1968-11-28', 38, 4, '2005-12-01');
INSERT INTO `clients` VALUES (3, 'Steve jobs', '52226618', '1975-04-01', 31, 8, '2006-04-18');
INSERT INTO `clients` VALUES (4, 'Dracula', '132137423', '1941-09-23', 64, 1, '2005-12-01');
INSERT INTO `clients` VALUES (5, 'Tom jones', '76047872', '1972-03-03', 35, 3, '2005-12-02');

-- --------------------------------------------------------

-- 
-- Table structure for table `conf_vehicule_type`
-- 

CREATE TABLE `conf_vehicule_type` (
  `code` int(5) NOT NULL auto_increment,
  `name` varchar(30) collate latin1_general_ci NOT NULL default '',
  PRIMARY KEY  (`code`),
  UNIQUE KEY `nombre` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Marcas de vehiculos de los clientes' AUTO_INCREMENT=18 ;

-- 
-- Dumping data for table `conf_vehicule_type`
-- 

INSERT INTO `conf_vehicule_type` VALUES (1, 'Renault');
INSERT INTO `conf_vehicule_type` VALUES (2, 'Fiat');
INSERT INTO `conf_vehicule_type` VALUES (3, 'Mazda');
INSERT INTO `conf_vehicule_type` VALUES (4, 'Daewoo');
INSERT INTO `conf_vehicule_type` VALUES (5, 'Toyota');
INSERT INTO `conf_vehicule_type` VALUES (6, 'Nissan');
INSERT INTO `conf_vehicule_type` VALUES (7, 'Mitsubishi');
INSERT INTO `conf_vehicule_type` VALUES (8, 'Jeep');
INSERT INTO `conf_vehicule_type` VALUES (9, 'Sangyong');
INSERT INTO `conf_vehicule_type` VALUES (10, 'Kia');
INSERT INTO `conf_vehicule_type` VALUES (11, 'Volkswagen');
INSERT INTO `conf_vehicule_type` VALUES (12, 'Hyunday');
INSERT INTO `conf_vehicule_type` VALUES (13, 'Honda');
INSERT INTO `conf_vehicule_type` VALUES (14, 'Ford');
INSERT INTO `conf_vehicule_type` VALUES (15, 'Chevrolet');
INSERT INTO `conf_vehicule_type` VALUES (17, 'Bmw');

-- --------------------------------------------------------

-- 
-- Table structure for table `invoices`
-- 

CREATE TABLE `invoices` (
  `code` int(6) NOT NULL auto_increment,
  `code_client` int(6) NOT NULL default '0',
  `value` bigint(20) NOT NULL default '0',
  `inscription_date` date NOT NULL default '0000-00-00',
  `inscription_hour` time NOT NULL default '00:00:00',
  PRIMARY KEY  (`code`),
  KEY `Fecha Inscripcion` (`inscription_hour`),
  KEY `fecha_inscripcion` (`inscription_date`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=26320 ;

-- 
-- Dumping data for table `invoices`
-- 

INSERT INTO `invoices` VALUES (1, 5, 130500, '2005-12-01', '11:37:00');
INSERT INTO `invoices` VALUES (3, 5, 72660, '2005-12-01', '12:03:00');
INSERT INTO `invoices` VALUES (4, 5, 66910, '2005-12-01', '12:03:00');
INSERT INTO `invoices` VALUES (5, 5, 200000, '2005-12-01', '12:48:00');
INSERT INTO `invoices` VALUES (6, 5, 99900, '2005-12-01', '12:48:00');
INSERT INTO `invoices` VALUES (7, 2, 34700, '2005-12-01', '13:37:00');
INSERT INTO `invoices` VALUES (8, 2, 34180, '2005-12-01', '14:47:00');
INSERT INTO `invoices` VALUES (9, 2, 79900, '2005-12-01', '16:12:00');
INSERT INTO `invoices` VALUES (10, 3, 242935, '2005-12-11', '19:24:00');
INSERT INTO `invoices` VALUES (11, 3, 50660, '2005-12-11', '20:02:00');
INSERT INTO `invoices` VALUES (12, 3, 99900, '2005-12-17', '22:12:00');
INSERT INTO `invoices` VALUES (14, 4, 30000, '2007-03-08', '02:10:59');
INSERT INTO `invoices` VALUES (15, 4, 30000, '2007-03-08', '02:12:11');
