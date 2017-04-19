# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 10.1.13-MariaDB)
# Database: homestead
# Generation Time: 2016-10-09 08:05:11 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table dict_new_site_sc
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dict_new_site_sc`;

CREATE TABLE `dict_new_site_sc` (
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `user_num` int(11) DEFAULT NULL,
  `user_type` varchar(255) DEFAULT NULL,
  `fee_type` varchar(255) DEFAULT NULL,
  `share_value` decimal(10,4) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dict_new_site_sc` WRITE;
/*!40000 ALTER TABLE `dict_new_site_sc` DISABLE KEYS */;

INSERT INTO `dict_new_site_sc` (`seq`, `user_num`, `user_type`, `fee_type`, `share_value`, `update_time`)
VALUES
	(53,1,NULL,NULL,1.0000,'2016-09-29 18:52:32'),
	(54,2,'锚定用户','基准价格',0.7500,'2016-09-29 18:52:32'),
	(55,2,'锚定用户','场地费',0.5500,'2016-09-29 18:52:32'),
	(56,2,'锚定用户','电力引入费',0.5500,'2016-09-29 18:52:32'),
	(57,2,'其他租户','基准价格',0.8000,'2016-09-29 18:52:32'),
	(58,2,'其他租户','场地费',0.6000,'2016-09-29 18:52:32'),
	(59,2,'其他租户','电力引入费',0.6000,'2016-09-29 18:52:32'),
	(60,3,'锚定用户','基准价格',0.6500,'2016-09-29 18:52:32'),
	(61,3,'锚定用户','场地费',0.4500,'2016-09-29 18:52:32'),
	(62,3,'锚定用户','电力引入费',0.4500,'2016-09-29 18:52:32'),
	(63,3,'其他租户','基准价格',0.7000,'2016-09-29 18:52:32'),
	(64,3,'其他租户','场地费',0.5000,'2016-09-29 18:52:32'),
	(65,3,'其他租户','电力引入',0.5000,'2016-09-29 18:52:32');

/*!40000 ALTER TABLE `dict_new_site_sc` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dict_old_site_sc
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dict_old_site_sc`;

CREATE TABLE `dict_old_site_sc` (
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `share_type` varchar(255) DEFAULT NULL,
  `user_num` int(11) DEFAULT NULL,
  `is_newly_added` int(1) DEFAULT NULL,
  `fee_type` varchar(255) DEFAULT NULL,
  `share_value` decimal(10,4) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dict_old_site_sc` WRITE;
/*!40000 ALTER TABLE `dict_old_site_sc` DISABLE KEYS */;

INSERT INTO `dict_old_site_sc` (`seq`, `share_type`, `user_num`, `is_newly_added`, `fee_type`, `share_value`, `update_time`)
VALUES
	(13,'既有共享',NULL,0,NULL,0.3000,'2016-09-29 18:42:51'),
	(14,'原产权方',1,0,NULL,1.0000,'2016-09-29 18:42:51'),
	(15,'原产权方',2,0,'基准价格',0.7500,'2016-09-29 18:42:51'),
	(16,'原产权方',2,0,'场地费',0.7000,'2016-09-29 18:42:51'),
	(17,'原产权方',2,0,'电力引入费',0.0000,'2016-09-29 18:42:51'),
	(18,'原产权方',3,0,'基准价格',0.6500,'2016-09-29 18:42:51'),
	(19,'原产权方',3,0,'场地费',0.4500,'2016-09-29 18:42:51'),
	(20,'原产权方',3,0,'电力引入费',0.0000,'2016-09-29 18:42:51'),
	(21,'原产权方',3,1,'基准价格',0.6500,'2016-09-29 18:42:51'),
	(22,'原产权方',3,1,'场地费',0.4500,'2016-09-29 18:42:51'),
	(23,'原产权方',3,1,'电力引入费',0.0000,'2016-09-29 18:42:51');

/*!40000 ALTER TABLE `dict_old_site_sc` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table dict_tax_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `dict_tax_info`;

CREATE TABLE `dict_tax_info` (
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `fee_type` varchar(255) DEFAULT NULL,
  `tax_value` decimal(10,4) DEFAULT NULL,
  `update_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `dict_tax_info` WRITE;
/*!40000 ALTER TABLE `dict_tax_info` DISABLE KEYS */;

INSERT INTO `dict_tax_info` (`seq`, `fee_type`, `tax_value`, `update_time`)
VALUES
	(6,'基准价格',0.0600,'2016-09-29 19:01:08'),
	(7,'场地费',0.0600,'2016-09-29 19:01:08'),
	(8,'电力引入费',0.0600,'2016-09-29 19:01:08'),
	(9,'油机发电费',0.0600,'2016-09-29 19:01:08'),
	(10,'日常电费',0.1100,'2016-09-29 19:01:08');

/*!40000 ALTER TABLE `dict_tax_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fee_out
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fee_out`;

CREATE TABLE `fee_out` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `start_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `end_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `region_id` int(11) NOT NULL,
  `region_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fee_gnr` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_site` double(10,4) NOT NULL DEFAULT '0.0000',
  `is_out` int(11) NOT NULL DEFAULT '0',
  `operator` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `fee_out` WRITE;
/*!40000 ALTER TABLE `fee_out` DISABLE KEYS */;

INSERT INTO `fee_out` (`id`, `start_day`, `end_day`, `region_id`, `region_name`, `fee_gnr`, `fee_site`, `is_out`, `operator`, `created_at`, `updated_at`)
VALUES
	(12,'2015-11','2016-12',0,'十堰',4080.0000,864354.0000,1,1,'2016-10-09 14:56:18','2016-10-09 15:36:12');

/*!40000 ALTER TABLE `fee_out` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fee_out_elec
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fee_out_elec`;

CREATE TABLE `fee_out_elec` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `out_id` int(11) NOT NULL DEFAULT '0',
  `site_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `start_time` datetime NOT NULL,
  `stop_time` datetime NOT NULL,
  `elec_amount` double(10,4) NOT NULL DEFAULT '0.0000',
  `elec_price` double(10,4) NOT NULL DEFAULT '0.0000',
  `elec_fee` double(10,4) NOT NULL DEFAULT '0.0000',
  `operator` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_out_elec_out_id_index` (`out_id`),
  KEY `fee_out_elec_site_code_index` (`site_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table fee_out_gnr
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fee_out_gnr`;

CREATE TABLE `fee_out_gnr` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `out_id` int(11) NOT NULL DEFAULT '0',
  `site_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `gnr_start_time` datetime NOT NULL,
  `gnr_stop_time` datetime NOT NULL,
  `gnr_len` int(11) NOT NULL DEFAULT '0',
  `gnr_compute_len` int(11) NOT NULL DEFAULT '0',
  `gnr_fee` double(10,4) NOT NULL DEFAULT '0.0000',
  `gnr_fee_taxed` double(10,4) NOT NULL DEFAULT '0.0000',
  `is_modified` int(11) DEFAULT '0',
  `is_long` int(11) DEFAULT '0',
  `is_short` int(11) DEFAULT '0',
  `last_gnr_stop_time` datetime DEFAULT NULL,
  `interval_time` int(11) DEFAULT '0',
  `operator` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_out_gnr_out_id_index` (`out_id`),
  KEY `fee_out_gnr_site_code_index` (`site_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `fee_out_gnr` WRITE;
/*!40000 ALTER TABLE `fee_out_gnr` DISABLE KEYS */;

INSERT INTO `fee_out_gnr` (`id`, `out_id`, `site_code`, `gnr_start_time`, `gnr_stop_time`, `gnr_len`, `gnr_compute_len`, `gnr_fee`, `gnr_fee_taxed`, `is_modified`, `is_long`, `is_short`, `last_gnr_stop_time`, `interval_time`, `operator`, `created_at`, `updated_at`)
VALUES
	(1,12,'420300908000000233','2015-12-01 10:22:00','2015-12-01 12:22:29',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-01 13:21:31','2016-10-09 14:56:18'),
	(2,12,'420300908000000233','2015-12-01 13:22:00','2015-12-01 15:24:31',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-01 14:23:17','2016-10-09 14:56:18'),
	(3,12,'420300908000000233','2015-12-02 05:25:21','2015-12-02 10:25:36',0,6,120.0000,133.0000,0,0,0,NULL,0,0,'2015-12-02 10:24:58','2016-10-09 14:56:18'),
	(4,12,'420300908000000232','2015-12-02 11:24:58','2015-12-02 12:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-02 13:24:58','2016-10-09 14:56:18'),
	(5,12,'420300908000000232','2015-12-03 08:24:58','2015-12-03 12:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-03 13:24:58','2016-10-09 14:56:18'),
	(6,12,'420300908000000232','2015-12-03 14:24:58','2015-12-03 15:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-03 17:24:58','2016-10-09 14:56:18'),
	(7,12,'420300908000000232','2015-12-04 08:24:58','2015-12-04 13:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-04 14:24:58','2016-10-09 14:56:18'),
	(8,12,'420300908000000235','2015-12-04 14:24:58','2015-12-04 16:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-04 18:24:58','2016-10-09 14:56:18'),
	(9,12,'420300908000000235','2015-12-05 04:24:58','2015-12-05 09:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-05 10:24:58','2016-10-09 14:56:18'),
	(10,12,'420300908000000235','2015-12-05 10:24:58','2015-12-05 12:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-05 13:24:58','2016-10-09 14:56:18'),
	(11,12,'420300908000000235','2015-12-06 10:24:58','2015-12-06 16:24:58',0,6,120.0000,133.0000,0,0,0,NULL,0,0,'2015-12-06 17:24:58','2016-10-09 14:56:18'),
	(12,12,'420300908000000235','2015-12-06 17:24:58','2015-12-06 19:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-06 21:24:58','2016-10-09 14:56:18'),
	(13,12,'420300908000000248','2015-12-07 06:24:58','2015-12-07 10:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-07 13:24:58','2016-10-09 14:56:18'),
	(14,12,'420300908000000248','2015-12-07 14:24:58','2015-12-07 17:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-07 18:24:58','2016-10-09 14:56:18'),
	(15,12,'420300908000000248','2015-12-08 03:24:58','2015-12-08 06:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-08 09:24:58','2016-10-09 14:56:18'),
	(16,12,'420300908000000248','2015-12-08 10:24:58','2015-12-08 13:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-08 14:24:58','2016-10-09 14:56:18'),
	(17,12,'420300908000000248','2015-12-09 05:24:58','2015-12-09 10:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-09 11:24:58','2016-10-09 14:56:18'),
	(18,12,'420300908000000249','2015-12-09 11:24:58','2015-12-09 16:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-09 18:24:58','2016-10-09 14:56:18'),
	(19,12,'420300908000000249','2015-12-10 04:24:58','2015-12-10 09:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-10 10:24:58','2016-10-09 14:56:18'),
	(20,12,'420300908000000249','2015-12-10 10:24:58','2015-12-02 14:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-10 15:24:58','2016-10-09 14:56:18'),
	(21,12,'420302908000000068','2015-12-01 10:22:00','2015-12-01 12:22:29',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-01 13:21:31','2016-10-09 14:56:18'),
	(22,12,'420302908000000068','2015-12-01 13:22:00','2015-12-01 15:24:31',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-01 14:23:17','2016-10-09 14:56:18'),
	(23,12,'420302908000000068','2015-12-02 05:25:21','2015-12-02 10:25:36',0,6,120.0000,133.0000,0,0,0,NULL,0,0,'2015-12-02 10:24:58','2016-10-09 14:56:18'),
	(24,12,'420302908000000068','2015-12-02 11:24:58','2015-12-02 12:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-02 13:24:58','2016-10-09 14:56:18'),
	(25,12,'420302908000000068','2015-12-03 08:24:58','2015-12-03 12:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-03 13:24:58','2016-10-09 14:56:18'),
	(26,12,'420302908001900002','2015-12-03 14:24:58','2015-12-03 15:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-03 17:24:58','2016-10-09 14:56:18'),
	(27,12,'420302908001900002','2015-12-04 08:24:58','2015-12-04 13:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-04 14:24:58','2016-10-09 14:56:18'),
	(28,12,'420302908001900002','2015-12-04 14:24:58','2015-12-04 16:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-04 18:24:58','2016-10-09 14:56:18'),
	(29,12,'420302908001900002','2015-12-05 04:24:58','2015-12-05 09:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-05 10:24:58','2016-10-09 14:56:18'),
	(30,12,'420302908001900002','2015-12-05 10:24:58','2015-12-05 12:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-05 13:24:58','2016-10-09 14:56:18'),
	(31,12,'420302908001900006','2015-12-06 10:24:58','2015-12-06 16:24:58',0,6,120.0000,133.0000,0,0,0,NULL,0,0,'2015-12-06 17:24:58','2016-10-09 14:56:18'),
	(32,12,'420302908001900006','2015-12-06 17:24:58','2015-12-06 19:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-06 21:24:58','2016-10-09 14:56:18'),
	(33,12,'420302908001900006','2015-12-07 06:24:58','2015-12-07 10:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-07 13:24:58','2016-10-09 14:56:18'),
	(34,12,'420302908001900006','2015-12-07 14:24:58','2015-12-07 17:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-07 18:24:58','2016-10-09 14:56:18'),
	(35,12,'420302908001900006','2015-12-08 03:24:58','2015-12-08 06:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-08 09:24:58','2016-10-09 14:56:18'),
	(36,12,'420321908000000110','2015-12-08 10:24:58','2015-12-08 13:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-08 14:24:58','2016-10-09 14:56:18'),
	(37,12,'420321908000000110','2015-12-09 05:24:58','2015-12-09 10:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-09 11:24:58','2016-10-09 14:56:18'),
	(38,12,'420321908000000110','2015-12-09 11:24:58','2015-12-09 16:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-09 18:24:58','2016-10-09 14:56:18'),
	(39,12,'420321908000000110','2015-12-10 04:24:58','2015-12-10 09:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-10 10:24:58','2016-10-09 14:56:18'),
	(40,12,'420321908000000110','2015-12-10 10:24:58','2015-12-02 14:24:58',0,5,100.0000,111.0000,0,0,0,NULL,0,0,'2015-12-10 15:24:58','2016-10-09 14:56:18');

/*!40000 ALTER TABLE `fee_out_gnr` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fee_out_site
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fee_out_site`;

CREATE TABLE `fee_out_site` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `out_id` int(11) NOT NULL DEFAULT '0',
  `site_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `start_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `end_day` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fee_basic` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_basic_taxed` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_site` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_site_taxed` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_import` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_import_taxed` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_cut` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_cut_taxed` double(10,4) NOT NULL DEFAULT '0.0000',
  `operator` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_out_site_out_id_index` (`out_id`),
  KEY `fee_out_site_site_code_index` (`site_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `fee_out_site` WRITE;
/*!40000 ALTER TABLE `fee_out_site` DISABLE KEYS */;

INSERT INTO `fee_out_site` (`id`, `out_id`, `site_code`, `start_day`, `end_day`, `fee_basic`, `fee_basic_taxed`, `fee_site`, `fee_site_taxed`, `fee_import`, `fee_import_taxed`, `fee_cut`, `fee_cut_taxed`, `operator`, `created_at`, `updated_at`)
VALUES
	(1,12,'420300908000000233','2015-11','2016-12',10000.0000,10600.0000,5000.0000,5300.0000,1200.0000,1400.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(2,12,'420300908000000232','2015-11','2016-12',11000.0000,11500.0000,4524.0000,4752.0000,1152.0000,1251.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(3,12,'420300908000000234','2015-11','2016-12',12541.0000,12856.0000,4625.0000,4852.0000,1254.0000,1357.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(4,12,'420300908000000235','2015-11','2016-12',14254.0000,15845.0000,4521.0000,4852.0000,1254.0000,1452.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(5,12,'420300908000000236','2015-11','2016-12',15625.0000,16241.0000,4525.0000,4852.0000,1452.0000,1652.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(6,12,'420300908000000241','2015-11','2016-12',16544.0000,17525.0000,5265.0000,5654.0000,1520.0000,1752.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(7,12,'420300908000000242','2015-11','2016-12',14521.0000,15264.0000,5412.0000,5620.0000,1245.0000,1354.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(8,12,'420300908000000248','2015-11','2016-12',15241.0000,15620.0000,4521.0000,4687.0000,1120.0000,1254.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(9,12,'420300908000000249','2015-11','2016-12',17541.0000,18521.0000,4521.0000,4621.0000,1425.0000,1578.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(10,12,'420300908000000251','2015-11','2016-12',14587.0000,15247.0000,4756.0000,4856.0000,1145.0000,1254.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(11,12,'420300908000000252','2015-11','2016-12',17854.0000,18544.0000,4527.0000,4687.0000,1547.0000,1687.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(12,12,'420300908000000253','2015-11','2016-12',15547.0000,16544.0000,4552.0000,4751.0000,1544.0000,1687.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(13,12,'420300908000000258','2015-11','2016-12',15441.0000,17451.0000,4521.0000,4687.0000,1754.0000,1857.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(14,12,'420321908000000106','2015-11','2016-12',16547.0000,17541.0000,5214.0000,5621.0000,1452.0000,1568.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(15,12,'420301908001900003','2015-11','2016-12',15241.0000,16574.0000,4557.0000,4789.0000,1458.0000,1657.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(16,12,'420302700000066052','2015-11','2016-12',17852.0000,18547.0000,4856.0000,4958.0000,1457.0000,1657.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(17,12,'420302700000066072','2015-11','2016-12',18547.0000,19587.0000,4785.0000,4521.0000,1754.0000,1857.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(18,12,'420300908001900077','2015-11','2016-12',15241.0000,16587.0000,4258.0000,4521.0000,1541.0000,1654.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(19,12,'420300908001900101','2015-11','2016-12',18544.0000,19588.0000,4752.0000,4952.0000,1458.0000,1524.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(20,12,'420302908000000038','2015-11','2016-12',15687.0000,16854.0000,5874.0000,5954.0000,1524.0000,1654.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(21,12,'420302908000000042','2015-11','2016-12',10000.0000,10600.0000,5000.0000,5300.0000,1200.0000,1400.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(22,12,'420302908000000043','2015-11','2016-12',11000.0000,11500.0000,4524.0000,4752.0000,1152.0000,1251.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(23,12,'420302908000000044','2015-11','2016-12',12541.0000,12856.0000,4625.0000,4852.0000,1254.0000,1357.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(24,12,'420302908000000049','2015-11','2016-12',14254.0000,15845.0000,4521.0000,4852.0000,1254.0000,1452.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(25,12,'420302908000000056','2015-11','2016-12',15625.0000,16241.0000,4525.0000,4852.0000,1452.0000,1652.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(26,12,'420302908000000062','2015-11','2016-12',16544.0000,17525.0000,5265.0000,5654.0000,1520.0000,1752.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(27,12,'420302908000000063','2015-11','2016-12',14521.0000,15264.0000,5412.0000,5620.0000,1245.0000,1354.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(28,12,'420302908000000064','2015-11','2016-12',15241.0000,15620.0000,4521.0000,4687.0000,1120.0000,1254.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(29,12,'420302908000000065','2015-11','2016-12',17541.0000,18521.0000,4521.0000,4621.0000,1425.0000,1578.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(30,12,'420302908000000066','2015-11','2016-12',14587.0000,15247.0000,4756.0000,4856.0000,1145.0000,1254.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(31,12,'420302908000000068','2015-11','2016-12',17854.0000,18544.0000,4527.0000,4687.0000,1547.0000,1687.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(32,12,'420302908001900001','2015-11','2016-12',15547.0000,16544.0000,4552.0000,4751.0000,1544.0000,1687.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(33,12,'420302908001900002','2015-11','2016-12',15441.0000,17451.0000,4521.0000,4687.0000,1754.0000,1857.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(34,12,'420302908001900003','2015-11','2016-12',16547.0000,17541.0000,5214.0000,5621.0000,1452.0000,1568.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(35,12,'420302908001900005','2015-11','2016-12',15241.0000,16574.0000,4557.0000,4789.0000,1458.0000,1657.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(36,12,'420302908001900006','2015-11','2016-12',17852.0000,18547.0000,4856.0000,4958.0000,1457.0000,1657.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(37,12,'420321908000000107','2015-11','2016-12',18547.0000,19587.0000,4785.0000,4521.0000,1754.0000,1857.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(38,12,'420321908000000110','2015-11','2016-12',15241.0000,16587.0000,4258.0000,4521.0000,1541.0000,1654.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(39,12,'420303908000000451','2015-11','2016-12',18544.0000,19588.0000,4752.0000,4952.0000,1458.0000,1524.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18'),
	(40,12,'420303908000000498','2015-11','2016-12',15687.0000,16854.0000,5874.0000,5954.0000,1524.0000,1654.0000,0.0000,0.0000,1,'2016-10-09 14:56:18','2016-10-09 14:56:18');

/*!40000 ALTER TABLE `fee_out_site` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table fee_out_site_price
# ------------------------------------------------------------

DROP TABLE IF EXISTS `fee_out_site_price`;

CREATE TABLE `fee_out_site_price` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `fee_basic` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_basic_taxed` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_site` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_site_taxed` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_import` double(10,4) NOT NULL DEFAULT '0.0000',
  `fee_import_taxed` double(10,4) NOT NULL DEFAULT '0.0000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fee_out_site_price_site_code_index` (`site_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `fee_out_site_price` WRITE;
/*!40000 ALTER TABLE `fee_out_site_price` DISABLE KEYS */;

INSERT INTO `fee_out_site_price` (`id`, `site_code`, `fee_basic`, `fee_basic_taxed`, `fee_site`, `fee_site_taxed`, `fee_import`, `fee_import_taxed`, `created_at`, `updated_at`)
VALUES
	(1,'420300908000000233',10000.0000,10600.0000,5000.0000,5300.0000,1200.0000,1400.0000,NULL,NULL),
	(2,'420300908000000232',11000.0000,11500.0000,4524.0000,4752.0000,1152.0000,1251.0000,NULL,NULL),
	(3,'420300908000000234',12541.0000,12856.0000,4625.0000,4852.0000,1254.0000,1357.0000,NULL,NULL),
	(4,'420300908000000235',14254.0000,15845.0000,4521.0000,4852.0000,1254.0000,1452.0000,NULL,NULL),
	(5,'420300908000000236',15625.0000,16241.0000,4525.0000,4852.0000,1452.0000,1652.0000,NULL,NULL),
	(6,'420300908000000241',16544.0000,17525.0000,5265.0000,5654.0000,1520.0000,1752.0000,NULL,NULL),
	(7,'420300908000000242',14521.0000,15264.0000,5412.0000,5620.0000,1245.0000,1354.0000,NULL,NULL),
	(8,'420300908000000248',15241.0000,15620.0000,4521.0000,4687.0000,1120.0000,1254.0000,NULL,NULL),
	(9,'420300908000000249',17541.0000,18521.0000,4521.0000,4621.0000,1425.0000,1578.0000,NULL,NULL),
	(10,'420300908000000251',14587.0000,15247.0000,4756.0000,4856.0000,1145.0000,1254.0000,NULL,NULL),
	(11,'420300908000000252',17854.0000,18544.0000,4527.0000,4687.0000,1547.0000,1687.0000,NULL,NULL),
	(12,'420300908000000253',15547.0000,16544.0000,4552.0000,4751.0000,1544.0000,1687.0000,NULL,NULL),
	(13,'420300908000000258',15441.0000,17451.0000,4521.0000,4687.0000,1754.0000,1857.0000,NULL,NULL),
	(14,'420321908000000106',16547.0000,17541.0000,5214.0000,5621.0000,1452.0000,1568.0000,NULL,NULL),
	(15,'420301908001900003',15241.0000,16574.0000,4557.0000,4789.0000,1458.0000,1657.0000,NULL,NULL),
	(16,'420302700000066052',17852.0000,18547.0000,4856.0000,4958.0000,1457.0000,1657.0000,NULL,NULL),
	(17,'420302700000066072',18547.0000,19587.0000,4785.0000,4521.0000,1754.0000,1857.0000,NULL,NULL),
	(18,'420300908001900077',15241.0000,16587.0000,4258.0000,4521.0000,1541.0000,1654.0000,NULL,NULL),
	(19,'420300908001900101',18544.0000,19588.0000,4752.0000,4952.0000,1458.0000,1524.0000,NULL,NULL),
	(20,'420302908000000038',15687.0000,16854.0000,5874.0000,5954.0000,1524.0000,1654.0000,NULL,NULL),
	(21,'420302908000000042',10000.0000,10600.0000,5000.0000,5300.0000,1200.0000,1400.0000,NULL,NULL),
	(22,'420302908000000043',11000.0000,11500.0000,4524.0000,4752.0000,1152.0000,1251.0000,NULL,NULL),
	(23,'420302908000000044',12541.0000,12856.0000,4625.0000,4852.0000,1254.0000,1357.0000,NULL,NULL),
	(24,'420302908000000049',14254.0000,15845.0000,4521.0000,4852.0000,1254.0000,1452.0000,NULL,NULL),
	(25,'420302908000000056',15625.0000,16241.0000,4525.0000,4852.0000,1452.0000,1652.0000,NULL,NULL),
	(26,'420302908000000062',16544.0000,17525.0000,5265.0000,5654.0000,1520.0000,1752.0000,NULL,NULL),
	(27,'420302908000000063',14521.0000,15264.0000,5412.0000,5620.0000,1245.0000,1354.0000,NULL,NULL),
	(28,'420302908000000064',15241.0000,15620.0000,4521.0000,4687.0000,1120.0000,1254.0000,NULL,NULL),
	(29,'420302908000000065',17541.0000,18521.0000,4521.0000,4621.0000,1425.0000,1578.0000,NULL,NULL),
	(30,'420302908000000066',14587.0000,15247.0000,4756.0000,4856.0000,1145.0000,1254.0000,NULL,NULL),
	(31,'420302908000000068',17854.0000,18544.0000,4527.0000,4687.0000,1547.0000,1687.0000,NULL,NULL),
	(32,'420302908001900001',15547.0000,16544.0000,4552.0000,4751.0000,1544.0000,1687.0000,NULL,NULL),
	(33,'420302908001900002',15441.0000,17451.0000,4521.0000,4687.0000,1754.0000,1857.0000,NULL,NULL),
	(34,'420302908001900003',16547.0000,17541.0000,5214.0000,5621.0000,1452.0000,1568.0000,NULL,NULL),
	(35,'420302908001900005',15241.0000,16574.0000,4557.0000,4789.0000,1458.0000,1657.0000,NULL,NULL),
	(36,'420302908001900006',17852.0000,18547.0000,4856.0000,4958.0000,1457.0000,1657.0000,NULL,NULL),
	(37,'420321908000000107',18547.0000,19587.0000,4785.0000,4521.0000,1754.0000,1857.0000,NULL,NULL),
	(38,'420321908000000110',15241.0000,16587.0000,4258.0000,4521.0000,1541.0000,1654.0000,NULL,NULL),
	(39,'420303908000000451',18544.0000,19588.0000,4752.0000,4952.0000,1458.0000,1524.0000,NULL,NULL),
	(40,'420303908000000498',15687.0000,16854.0000,5874.0000,5954.0000,1524.0000,1654.0000,NULL,NULL);

/*!40000 ALTER TABLE `fee_out_site_price` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table migrations
# ------------------------------------------------------------

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;

INSERT INTO `migrations` (`migration`, `batch`)
VALUES
	('2014_10_12_000000_create_users_table',1),
	('2014_10_12_100000_create_password_resets_table',1),
	('2016_09_09_071325_create_article_table',2),
	('2015_01_15_105324_create_roles_table',3),
	('2015_01_15_114412_create_role_user_table',3),
	('2015_01_26_115212_create_permissions_table',3),
	('2015_01_26_115523_create_permission_role_table',3),
	('2015_02_09_132439_create_permission_user_table',3),
	('2016_09_30_101447_create_towerbill_table',4),
	('2016_09_30_162400_create_siteinfo_table',4);

/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table monthly_out_account
# ------------------------------------------------------------

DROP TABLE IF EXISTS `monthly_out_account`;

CREATE TABLE `monthly_out_account` (
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `account_start_time` datetime DEFAULT NULL,
  `account_stop_time` datetime DEFAULT NULL,
  `region_name` varchar(255) DEFAULT NULL,
  `gnr_fee` decimal(10,4) DEFAULT NULL,
  `serv_fee` decimal(10,4) DEFAULT NULL,
  `is_out` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;

LOCK TABLES `monthly_out_account` WRITE;
/*!40000 ALTER TABLE `monthly_out_account` DISABLE KEYS */;

INSERT INTO `monthly_out_account` (`seq`, `account_start_time`, `account_stop_time`, `region_name`, `gnr_fee`, `serv_fee`, `is_out`)
VALUES
	(1,'2015-10-01 12:12:53','2015-11-01 12:13:01','丹江口市',15000.0000,130000.0000,1),
	(2,'2015-10-01 12:12:53','2015-11-01 12:13:01','茅箭区',14500.0000,150000.0000,1),
	(3,'2015-11-01 12:15:31','2015-12-01 12:15:39','丹江口市',16500.0000,160000.0000,0),
	(4,'2015-11-01 12:16:13','2015-12-01 12:16:19',NULL,NULL,NULL,NULL);

/*!40000 ALTER TABLE `monthly_out_account` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table password_resets
# ------------------------------------------------------------

DROP TABLE IF EXISTS `password_resets`;

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table permission_role
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permission_role`;

CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_index` (`permission_id`),
  KEY `permission_role_role_id_index` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `permission_role` WRITE;
/*!40000 ALTER TABLE `permission_role` DISABLE KEYS */;

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'2016-02-16 17:37:51','2016-04-16 17:57:51');

/*!40000 ALTER TABLE `permission_role` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table permission_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permission_user`;

CREATE TABLE `permission_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_index` (`permission_id`),
  KEY `permission_user_user_id_index` (`user_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table permissions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `permissions`;

CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;

INSERT INTO `permissions` (`id`, `name`, `slug`, `description`, `model`, `created_at`, `updated_at`)
VALUES
	(1,'后台管理首页','admin.index.index','后台管理首页',NULL,'2016-02-16 17:57:51','2016-02-16 17:57:51');

/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table role_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `role_user`;

CREATE TABLE `role_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `role_user_role_id_index` (`role_id`),
  KEY `role_user_user_id_index` (`user_id`),
  CONSTRAINT `role_user_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `role_user` WRITE;
/*!40000 ALTER TABLE `role_user` DISABLE KEYS */;

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'2016-02-16 17:37:51','2016-04-16 17:57:51');

/*!40000 ALTER TABLE `role_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `roles`;

CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `level`, `created_at`, `updated_at`)
VALUES
	(1,'后台管理员','admin','后台管理员，具有最高权限',1,'2016-02-16 09:52:13','2016-02-16 09:52:13'),
	(2,'普通会员','member','普通会员，不可管理后台',1,'2016-02-16 09:52:13','2016-02-16 09:52:13');

/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table setting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `setting`;

CREATE TABLE `setting` (
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;



# Dump of table site_info
# ------------------------------------------------------------

DROP TABLE IF EXISTS `site_info`;

CREATE TABLE `site_info` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tower_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sys_num` int(11) NOT NULL,
  `share_num` int(11) NOT NULL,
  `is_tower_property` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `site_district_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_rru_away` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tower_built_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `elec_introduced_type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_code` (`site_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `site_info` WRITE;
/*!40000 ALTER TABLE `site_info` DISABLE KEYS */;

INSERT INTO `site_info` (`id`, `site_code`, `region_name`, `city_name`, `product_type`, `tower_type`, `sys_num`, `share_num`, `is_tower_property`, `site_district_type`, `is_rru_away`, `tower_built_type`, `elec_introduced_type`)
VALUES
	(1,'420300908000000233','十堰','丹江口市','景观塔（无机房无配套）','景观塔',2,1,'是','市区','否','原产权','380'),
	(2,'420300908000000232','十堰','丹江口市','简易塔+RRU拉远+RRU拉远配套','简易塔',1,1,'是','市区','是','原产权','380'),
	(3,'420300908000000234','十堰','丹江口市','普通楼面塔+RRU拉远+RRU拉远配套','普通楼面塔',2,1,'是','市区','是','原产权','380'),
	(4,'420300908000000235','十堰','丹江口市','普通地面塔+自建地面机房+普通地面塔机房配套','普通地面塔',2,1,'是','市区','否','原产权','220'),
	(5,'420300908000000236','十堰','丹江口市','景观塔+RRU拉远+RRU拉远配套','景观塔',2,1,'是','市区','是','原产权','220'),
	(6,'420300908000000241','十堰','丹江口市','景观塔+自建地面机房+其他机房配套','景观塔',2,1,'是','市区','否','原产权','380'),
	(7,'420300908000000242','十堰','丹江口市','普通楼面塔+一体化机柜+其他一体化柜配套','普通楼面塔',3,1,'是','市区','否','既有共享','380'),
	(8,'420300908000000248','十堰','丹江口市','普通地面塔+自建地面机房+普通地面塔机房配套','普通地面塔',3,1,'是','市区','否','既有共享','380'),
	(9,'420300908000000249','十堰','丹江口市','景观塔+自建地面机房+其他机房配套','景观塔',2,1,'是','市区','否','既有共享','380'),
	(10,'420300908000000251','十堰','丹江口市','普通地面塔+自建地面机房+普通地面塔机房配套','普通地面塔',1,1,'是','市区','否','既有共享','380'),
	(11,'420300908000000252','十堰','丹江口市','景观塔+自建地面机房+其他机房配套','景观塔',2,1,'是','市区','否','既有共享','380'),
	(12,'420300908000000253','十堰','丹江口市','普通楼面塔（无机房无配套）','普通楼面塔',1,1,'是','城镇','否','既有共享','380'),
	(13,'420300908000000258','十堰','丹江口市','楼面抱杆+租赁机房+其他机房配套','楼面抱杆',2,1,'是','城镇','否','既有共享','380'),
	(14,'420321908000000106','十堰','丹江口市','景观塔+自建地面机房+其他机房配套','景观塔',2,1,'是','城镇','否','既有共享','380'),
	(15,'420301908001900003','十堰','丹江口市','景观塔（无机房无配套）','景观塔',2,1,'是','城镇','否','既有共享','380'),
	(16,'420302700000066052','十堰','丹江口市','楼面抱杆+RRU拉远+RRU拉远配套','楼面抱杆',2,1,'是','城镇','是','原产权','380'),
	(17,'420302700000066072','十堰','丹江口市','楼面抱杆+RRU拉远+RRU拉远配套','楼面抱杆',2,1,'是','城镇','是','原产权','380'),
	(18,'420300908001900077','十堰','丹江口市','普通楼面塔（无机房无配套）','普通楼面塔',2,1,'是','城镇','否','原产权','380'),
	(19,'420300908001900101','十堰','丹江口市','简易塔+租赁机房+其他机房配套','简易塔',2,1,'是','城镇','否','原产权','380'),
	(20,'420302908000000038','十堰','丹江口市','简易塔（无机房无配套）','简易塔',1,1,'是','城镇','否','原产权','380'),
	(21,'420302908000000042','十堰','茅箭区','简易塔（无机房无配套）','简易塔',2,1,'是','城镇','否','原产权','380'),
	(22,'420302908000000043','十堰','茅箭区','普通地面塔+自建地面机房+普通地面塔机房配套','普通地面塔',2,1,'是','城镇','否','原产权','380'),
	(23,'420302908000000044','十堰','茅箭区','普通地面塔（无机房无配套）','普通地面塔',1,1,'是','城镇','否','原产权','380'),
	(24,'420302908000000049','十堰','茅箭区','景观塔（无机房无配套）','景观塔',2,1,'是','城镇','否','原产权','380'),
	(25,'420302908000000056','十堰','茅箭区','景观塔+租赁机房+其他机房配套','景观塔',3,2,'是','城镇','否','原产权','380'),
	(26,'420302908000000062','十堰','茅箭区','楼面抱杆+租赁机房+其他机房配套','楼面抱杆',2,2,'是','城镇','否','原产权','380'),
	(27,'420302908000000063','十堰','茅箭区','楼面抱杆+租赁机房+其他机房配套','楼面抱杆',2,1,'是','市区','否','原产权','380'),
	(28,'420302908000000064','十堰','茅箭区','普通楼面塔+自建楼面机房+其他机房配套','普通楼面塔',2,1,'是','市区','否','既有共享','220'),
	(29,'420302908000000065','十堰','茅箭区','普通地面塔（无机房无配套）','普通地面塔',2,2,'是','市区','否','既有共享','220'),
	(30,'420302908000000066','十堰','茅箭区','简易塔（无机房无配套）','简易塔',2,1,'是','市区','否','既有共享','220'),
	(31,'420302908000000068','十堰','茅箭区','景观塔+自建地面机房+其他机房配套','景观塔',1,1,'是','市区','否','既有共享','220'),
	(32,'420302908001900001','十堰','茅箭区','楼面抱杆+RRU拉远+RRU拉远配套','楼面抱杆',2,1,'是','市区','是','既有共享','220'),
	(33,'420302908001900002','十堰','茅箭区','楼面抱杆+RRU拉远+RRU拉远配套','楼面抱杆',2,1,'是','市区','是','既有共享','220'),
	(34,'420302908001900003','十堰','茅箭区','楼面抱杆+一体化机柜+其他一体化柜配套','楼面抱杆',2,2,'是','市区','否','既有共享','220'),
	(35,'420302908001900005','十堰','茅箭区','楼面抱杆+RRU拉远+RRU拉远配套','楼面抱杆',2,1,'是','市区','是','既有共享','220'),
	(36,'420302908001900006','十堰','茅箭区','景观塔+自建地面机房+其他机房配套','景观塔',1,1,'是','市区','否','原产权','220'),
	(37,'420321908000000107','十堰','茅箭区','普通地面塔+自建地面机房+普通地面塔机房配套','普通地面塔',2,1,'是','农村','否','原产权','220'),
	(38,'420321908000000110','十堰','茅箭区','景观塔+自建地面机房+其他机房配套','景观塔',2,1,'是','农村','否','原产权','220'),
	(39,'420303908000000451','十堰','茅箭区','景观塔+自建地面机房+其他机房配套','景观塔',2,1,'是','农村','否','原产权','220'),
	(40,'420303908000000498','十堰','茅箭区','景观塔+一体化机柜+其他一体化柜配套','景观塔',2,2,'是','农村','否','原产权','220');

/*!40000 ALTER TABLE `site_info` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;

INSERT INTO `users` (`id`, `name`, `email`, `password`, `remember_token`, `created_at`, `updated_at`)
VALUES
	(1,'alexv','alexv1@163.com','$2y$10$dXLgM.herHy7AKd7OpmlzuKAsRbkbhazmoAAqatmz/OfRrd.wWER2','YoiAd7xclPHxQC1ld32gnLTHsxvV2Do9M24zzJisNdTQfDmzsUDogLKVPVuu','2016-02-16 17:37:51','2016-09-21 21:15:28');

/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
