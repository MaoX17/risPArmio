/*
Navicat MySQL Data Transfer

Source Server         : WWW7-LAN-105
Source Server Version : 50541
Source Host           : 172.21.1.105:3306
Source Database       : risPArmio

Target Server Type    : MYSQL
Target Server Version : 50541
File Encoding         : 65001

Date: 2015-11-27 11:41:51
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for cache_data
-- ----------------------------
DROP TABLE IF EXISTS `cache_data`;
CREATE TABLE `cache_data` (
  `id_cache_data` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `dt` date DEFAULT NULL,
  `tot` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`id_cache_data`),
  UNIQUE KEY `dt_unica` (`dt`)
) ENGINE=InnoDB AUTO_INCREMENT=1793 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for documenti
-- ----------------------------
DROP TABLE IF EXISTS `documenti`;
CREATE TABLE `documenti` (
  `iddocumento` int(11) NOT NULL AUTO_INCREMENT,
  `progetti_idprogetto` int(11) unsigned NOT NULL,
  `documento` varchar(250) DEFAULT NULL,
  `descrizione` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iddocumento`,`progetti_idprogetto`),
  KEY `fk_documenti_progetti_idx` (`progetti_idprogetto`),
  CONSTRAINT `fk_documenti_progetti` FOREIGN KEY (`progetti_idprogetto`) REFERENCES `progetti` (`idprogetto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for progetti
-- ----------------------------
DROP TABLE IF EXISTS `progetti`;
CREATE TABLE `progetti` (
  `idprogetto` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `progetto` varchar(250) DEFAULT NULL,
  `descrizione` varchar(2000) DEFAULT NULL,
  PRIMARY KEY (`idprogetto`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Table structure for spese
-- ----------------------------
DROP TABLE IF EXISTS `spese`;
CREATE TABLE `spese` (
  `idspesa` int(11) NOT NULL AUTO_INCREMENT,
  `progetti_idprogetto` int(11) unsigned NOT NULL,
  `dt_da` date DEFAULT NULL,
  `dt_a` date DEFAULT NULL,
  `spesa` decimal(11,2) DEFAULT NULL,
  `tipologia` varchar(11) DEFAULT NULL COMMENT 'può essere una spesa puntuale (1 giorno) - Periodica (periodo) - Ricorrente (annuale)',
  `reale_preventivo` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`idspesa`,`progetti_idprogetto`),
  KEY `fk_spese_progetti1_idx` (`progetti_idprogetto`),
  CONSTRAINT `fk_spese_progetti1` FOREIGN KEY (`progetti_idprogetto`) REFERENCES `progetti` (`idprogetto`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;
