# --------------------------------------------------------
# Host:                         localhost
# Database:                     lek_laundry
# Server version:               5.5.16
# Server OS:                    Win32
# HeidiSQL version:             5.0.0.3272
# Date/time:                    2011-10-06 16:45:22
# --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
# Dumping database structure for lek_laundry
DROP DATABASE IF EXISTS `lek_laundry`;
CREATE DATABASE IF NOT EXISTS `lek_laundry` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `lek_laundry`;


# Dumping structure for table lek_laundry.customer
DROP TABLE IF EXISTS `customer`;
CREATE TABLE IF NOT EXISTS `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_register` date NOT NULL,
  `date_start` date DEFAULT NULL,
  `date_exp` date DEFAULT NULL,
  `credit` int(10) unsigned NOT NULL DEFAULT '0',
  `is_member` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = normal, 1 = member',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.customer: 30 rows
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` (`id`, `name`, `lastname`, `nickname`, `tel`, `address`, `date_register`, `date_start`, `date_exp`, `credit`, `is_member`) VALUES (1, 'วรรณนิชา ', 'ชัยรัตนสุนทร', 'ปุ้ย', '026433873', '227 ซอยตลาดศรีทองคำ เขตดินแดง กรุงเทพมหานคร 10400	', '2011-10-01', NULL, NULL, 0, 0), (2, 'ดาริณ', ' สุวรรณนุช', 'บูม', '0849665896', '268 ซอยตลาดศรีทองคำ เขตดินแดง กรุงเทพมหานคร 10400	', '2011-10-01', NULL, NULL, 0, 0), (3, 'นนธวัช', 'นนเทศา	', 'เจมส์', '0485223652', '604 ซอยตลาดศรีดินแดง เขตดินแดง กรุงเทพมหานคร 10400	', '2011-10-01', '2011-10-06', '2011-11-06', 22, 1), (4, 'วีรานงค์', 'เศรษฐภักดี', 'กฏ', '0896543212', '166 ซอยแสงอุทัยทิพย์ เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-02', '2011-10-02', '2011-11-02', 23, 1), (5, 'ศิริชาญ ', 'อติวรรณาพัฒน์', 'ที', '0841021010', '262 ซอยตลาดศรีดินแดง เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-02', NULL, NULL, 0, 0), (6, 'ธนกฤต', 'งานดี		', 'เนเน่', '0845156842', '137 ซอยตึกคู่ฟ้า เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-02', NULL, NULL, 0, 0), (7, 'พิมพ์นภา ', 'ตั้งจิตมั่น', 'พิมพ์	', '0684429955', '23 ซอยตลาดศรีทองคำ เขตดินแดง กรุงเทพมหานคร 10400	', '2011-10-02', '2011-10-02', '2011-11-02', 22, 1), (8, 'ญาดา ', 'ทิวารักษ์		', 'ดา	', '0684459750', 'SIRICHAI mansion 12 ซอยทรงดวง เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-02', NULL, NULL, 0, 0), (9, 'ชูชาติ ', 'แซ่แต้	', '	ไกด์', '048212224', '225 ซอยตลาดศรีทองคำ เขตดินแดง กรุงเทพมหานคร 10400	', '2011-10-02', '2011-10-06', '2011-11-06', 54, 1), (10, 'ปิยะดา', 'ศรีสุวรรณ		', 'ดา', '0894429955', '58 ซอยตลาดศรีทองคำ เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-03', NULL, NULL, 0, 0), (11, 'กนกศักดิ์ ', 'ผ่องท่าไม้	', 'ไก่', '0849776565', 'KJS mansion 34 ซอยหมอเหล็ง ถนนราชปรารถ แขวงมักกะสัน เขตราชเทวี กรุงเทพ 10400', '2011-10-04', NULL, NULL, 0, 0), (12, 'อานนท์ ', 'พงษ์เภา		', 'นนท์', '0819989955', '59/8 ซอยหมอเหล็ง ถนนราชปรารถ แขวงมักกะสัน เขตราชเทวี กรุงเทพ 10400	', '2011-10-04', '2011-10-06', '2011-11-06', 58, 1), (13, 'ปฏิภาณ ', 'พานรอง		', 'เพชร', '0851227712', 'SIRICHAI mansion 105 ซอยทรงดวง เขตดินแดง กรุงเทพมหานคร 10400	', '2011-10-04', NULL, NULL, 0, 0), (14, 'พีรพงษ์ ', 'วงเวียน		', 'พงษ์', '0849694512', 'KJS mansion 79 ซอยหมอเหล็ง ถนนราชปรารถ แขวงมักกะสัน เขตราชเทวี กรุงเทพ 10400', '2011-10-04', NULL, NULL, 0, 0), (15, 'ธนพล ', 'แสงหล้า	', 'ตั้ม', '0871427624', 'SIRICHAI mansion 89 ซอยทรงดวง เขตดินแดง กรุงเทพมหานคร 10400	', '2011-10-04', '2011-10-04', '2011-11-04', 13, 1), (16, 'พงศธร ', 'ไทยพานิช	', 'ต้น', '0897751212', 'KJS mansion 55 ซอยหมอเหล็ง ถนนราชปรารถ แขวงมักกะสัน เขตราชเทวี กรุงเทพ 10400	', '2011-10-04', NULL, NULL, 0, 0), (17, 'มหาชัย ', 'รุ่งฤกษ์วิวัฒน์	', 'ไตเติล', '0852345612', '23/3 แฟลตดินแดง เขตดินแดง กรุงเทพมหานคร 10400	', '2011-10-04', '2011-10-06', '2011-11-06', 59, 1), (18, 'บรรณสรณ์ ', 'บรมทองชุ่ม	', 'เต้', '0816696969', '1 ซอยแสงอุทัยทิพย์ เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-04', NULL, NULL, 0, 0), (19, 'พิรสิชฌ์ ', 'ธนะสาร		', 'พี', '0852526791', '2 ซอยตึกคู่ฟ้า เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-04', NULL, NULL, 0, 0), (20, 'สมบูรณ์ ', 'เอื้ออัชฌาสัย	', 'โอ๋', '0854127612', '89 ซอยทรงดวง เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-04', '2011-10-04', '2011-11-04', 50, 1), (21, 'นิชดา ', 'ประวัติดี		', 'นิด้า', '0814459525', '137 ซอยตึกคู่ฟ้า เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-04', NULL, NULL, 0, 0), (22, 'กิตติกร ', 'ชัยวรรณ		', 'กี่กี้', '0894124261', '166 ซอยแสงอุทัยทิพย์ เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-05', NULL, NULL, 0, 0), (23, 'กนกวรรณ ', 'พิทยานนท์	', 'มิ้น', '025776430', 'SIRICHAI mansion 12 ซอยทรงดวง เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-05', '2011-10-05', '2011-11-05', 5, 1), (24, 'ตรงกระแส ', 'กระแสสินธุ์	', 'แชมป์', '0840140916', 'KJS mansion 14 ซอยหมอเหล็ง ถนนราชปรารถ แขวงมักกะสัน เขตราชเทวี กรุงเทพ 10400', '2011-10-05', NULL, NULL, 0, 0), (25, 'กรรณิการ์ ', 'จงใจ	', '	ปิง', '0831129955', '156 ซอยแสงอุทัยทิพย์ เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-05', NULL, NULL, 0, 0), (26, 'มนชดา ', 'ทรัพย์ชื่อชู	', 'มน', '025561150', '30 ซอยเพิ่มสิน ถนนประชาสงะคราะห์  เขตดินแดง กรุงเทพฯ 10400 ', '2011-10-05', NULL, NULL, 0, 0), (27, 'อิ่มเอม ', 'ใจสะอาด		', 'เอม', '021150112', '64 ซอยสมปรารถนา ถนนประชาสงเคราะห์ เขตดินแดง  10400 ', '2011-10-05', '2011-10-05', '2011-11-05', 23, 1), (28, 'เอมชะมัย ', 'นันโท		', 'เอม', '0211121150', '10 ซอยประชาสงเคราะห์ 47 ถนนประชาสุข  เขตดินแดง 10400 ', '2011-10-05', NULL, NULL, 0, 0), (29, 'จิรดา ', 'ปานเจริญ		', 'จิมมี่', '0899361231', 'KJS mansion 31 ซอยหมอเหล็ง ถนนราชปรารถ แขวงมักกะสัน เขตราชเทวี กรุงเทพ 10400', '2011-10-05', '2011-10-05', '2011-11-05', 50, 1), (30, 'คณึงนิจ ', 'สมทรัยพ์หทัย	', 'นิด', '0816116255', '51 ซอยแสงอุทัยทิพย์ เขตดินแดง กรุงเทพมหานคร 10400', '2011-10-05', NULL, NULL, 0, 0);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;


# Dumping structure for table lek_laundry.customer_receipt
DROP TABLE IF EXISTS `customer_receipt`;
CREATE TABLE IF NOT EXISTS `customer_receipt` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_receipt_type` int(10) unsigned NOT NULL,
  `id_customer` int(10) unsigned NOT NULL,
  `id_order` int(10) unsigned DEFAULT NULL,
  `amount` int(10) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_create` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_customer_receipt_customer` (`id_customer`),
  KEY `FK_customer_receipt_receipt_type` (`id_receipt_type`),
  KEY `FK_customer_receipt_order_head` (`id_order`),
  CONSTRAINT `FK_customer_receipt_customer` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_customer_receipt_order_head` FOREIGN KEY (`id_order`) REFERENCES `order_head` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_customer_receipt_receipt_type` FOREIGN KEY (`id_receipt_type`) REFERENCES `customer_receipt_type` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.customer_receipt: 60 rows
/*!40000 ALTER TABLE `customer_receipt` DISABLE KEYS */;
INSERT INTO `customer_receipt` (`id`, `id_receipt_type`, `id_customer`, `id_order`, `amount`, `description`, `date_create`) VALUES (61, 1, 14, 45, 500, NULL, '2011-10-06 16:42:09'), (62, 2, 17, NULL, 500, NULL, '2011-10-06 16:44:02');
/*!40000 ALTER TABLE `customer_receipt` ENABLE KEYS */;


# Dumping structure for table lek_laundry.customer_receipt_type
DROP TABLE IF EXISTS `customer_receipt_type`;
CREATE TABLE IF NOT EXISTS `customer_receipt_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.customer_receipt_type: 2 rows
/*!40000 ALTER TABLE `customer_receipt_type` DISABLE KEYS */;
INSERT INTO `customer_receipt_type` (`id`, `name`) VALUES (1, 'ใบเสร็จรับเงิน'), (2, 'ใบเสร็จรับเงินค่าสมาชิกรายเดือน');
/*!40000 ALTER TABLE `customer_receipt_type` ENABLE KEYS */;


# Dumping structure for table lek_laundry.inventory
DROP TABLE IF EXISTS `inventory`;
CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `brand` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `volume` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `price` int(10) unsigned NOT NULL,
  `total` int(10) unsigned NOT NULL DEFAULT '0',
  `id_inventory_unit` int(10) unsigned DEFAULT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_inventory_inventory_unit` (`id_inventory_unit`),
  CONSTRAINT `FK_inventory_inventory_unit` FOREIGN KEY (`id_inventory_unit`) REFERENCES `inventory_unit` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.inventory: 4 rows
/*!40000 ALTER TABLE `inventory` DISABLE KEYS */;
INSERT INTO `inventory` (`id`, `name`, `brand`, `volume`, `price`, `total`, `id_inventory_unit`, `date_update`) VALUES (1, 'ผงซักฟอก', 'บรีสเพาเวอร์', '5000 กรัม', 313, 17, 1, '2011-10-06 09:53:33'), (2, 'น้ำยาปรับผ้านุ่ม', 'ดาวน์นี่', '400 มิลลิลิตร', 52, 120, 3, '2011-10-04 18:18:26'), (3, 'น้ำยารีดผ้าเรียบ', 'ไฟล์ไลน์', '500 มิลลิลิตร', 0, 50, 2, '2011-10-04 01:01:48'), (4, 'น้ำยาซักผ้าขาว', 'ไฮเตอร์', '500 มิลลิลิตร', 0, 50, 2, '2011-10-04 01:01:50');
/*!40000 ALTER TABLE `inventory` ENABLE KEYS */;


# Dumping structure for table lek_laundry.inventory_transaction
DROP TABLE IF EXISTS `inventory_transaction`;
CREATE TABLE IF NOT EXISTS `inventory_transaction` (
  `id_inventory` int(10) unsigned NOT NULL,
  `amount` int(10) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `FK_inventory_transaction_inventory` (`id_inventory`),
  CONSTRAINT `FK_inventory_transaction_inventory` FOREIGN KEY (`id_inventory`) REFERENCES `inventory` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.inventory_transaction: 11 rows
/*!40000 ALTER TABLE `inventory_transaction` DISABLE KEYS */;
INSERT INTO `inventory_transaction` (`id_inventory`, `amount`, `description`, `date_create`) VALUES (2, 50, '', '2011-09-22 12:48:21'), (2, 5, '', '2011-09-22 12:48:28'), (2, -5, '', '2011-09-22 12:48:35'), (2, -5, '', '2011-09-22 12:48:41'), (2, -5, '', '2011-09-22 12:48:50'), (2, -10, '', '2011-09-22 12:49:08'), (1, 1, '', '2011-09-22 13:40:44'), (1, -4, '', '2011-10-01 16:55:34'), (2, -3, '', '2011-10-04 18:18:18'), (2, -7, '', '2011-10-04 18:18:26'), (1, 10, '', '2011-10-06 09:53:33');
/*!40000 ALTER TABLE `inventory_transaction` ENABLE KEYS */;


# Dumping structure for table lek_laundry.inventory_unit
DROP TABLE IF EXISTS `inventory_unit`;
CREATE TABLE IF NOT EXISTS `inventory_unit` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

# Dumping data for table lek_laundry.inventory_unit: 4 rows
/*!40000 ALTER TABLE `inventory_unit` DISABLE KEYS */;
INSERT INTO `inventory_unit` (`id`, `name`) VALUES (1, 'กล่อง'), (2, 'ถุง'), (3, 'ขวด'), (4, 'ถัง');
/*!40000 ALTER TABLE `inventory_unit` ENABLE KEYS */;


# Dumping structure for table lek_laundry.machine
DROP TABLE IF EXISTS `machine`;
CREATE TABLE IF NOT EXISTS `machine` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_machine_size` int(10) unsigned DEFAULT NULL,
  `id_machine_type` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `max_volume` int(10) NOT NULL DEFAULT '1',
  `is_enable` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '0 = ไม่ใช้งาน, 1 = เปิดใช้งาน',
  PRIMARY KEY (`id`),
  KEY `FK_machine_machine_type` (`id_machine_type`),
  KEY `FK_machine_machine_size` (`id_machine_size`),
  CONSTRAINT `FK_machine_machine_size` FOREIGN KEY (`id_machine_size`) REFERENCES `machine_size` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_machine_machine_type` FOREIGN KEY (`id_machine_type`) REFERENCES `machine_type` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.machine: 8 rows
/*!40000 ALTER TABLE `machine` DISABLE KEYS */;
INSERT INTO `machine` (`id`, `id_machine_size`, `id_machine_type`, `name`, `model`, `description`, `max_volume`, `is_enable`) VALUES (1, 1, 1, 'SAMSUNG  9 kg.   10-30 ตัว', 'WA11G9 Eco Strom', 'เครื่องซักผ้าฝาบน ', 1, 1), (2, 2, 1, 'SAMSUNG 12 kg.    30-40 ตัว', 'WA14P9 Eco Strom ', 'เครื่องซักผ้าฝาบน ', 1, 1), (3, 3, 1, 'SAMSUNG 15 kg. 40-50    ตัว', 'WF8150NXV', 'เครื่องซักผ้าฝาหน้า ', 1, 1), (4, 1, 2, 'SAMSUNG 9 kg.', 'DV520AEP', '', 1, 1), (5, 2, 2, 'Electrolux 12 kg.', 'EIMED55IIW', '', 1, 1), (6, 3, 2, 'LG 15 kg. ', 'DLEX5101V', '', 1, 1), (7, 1, 3, 'เตารีดไอน้ำ Silver Star ', 'ES85AF ', '', 1, 1), (11, 1, 3, 'เตารีดไอน้ำ Silver Star', 'ES85AF', '', 1, 1);
/*!40000 ALTER TABLE `machine` ENABLE KEYS */;


# Dumping structure for table lek_laundry.machine_size
DROP TABLE IF EXISTS `machine_size`;
CREATE TABLE IF NOT EXISTS `machine_size` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.machine_size: 3 rows
/*!40000 ALTER TABLE `machine_size` DISABLE KEYS */;
INSERT INTO `machine_size` (`id`, `name`, `description`) VALUES (1, 'S', NULL), (2, 'M', NULL), (3, 'L', NULL);
/*!40000 ALTER TABLE `machine_size` ENABLE KEYS */;


# Dumping structure for table lek_laundry.machine_type
DROP TABLE IF EXISTS `machine_type`;
CREATE TABLE IF NOT EXISTS `machine_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.machine_type: 3 rows
/*!40000 ALTER TABLE `machine_type` DISABLE KEYS */;
INSERT INTO `machine_type` (`id`, `name`, `description`) VALUES (1, 'เครื่องซักผ้า', NULL), (2, 'เครื่องอบผ้า', NULL), (3, 'เตารีด', NULL);
/*!40000 ALTER TABLE `machine_type` ENABLE KEYS */;


# Dumping structure for table lek_laundry.order_head
DROP TABLE IF EXISTS `order_head`;
CREATE TABLE IF NOT EXISTS `order_head` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_customer` int(10) unsigned NOT NULL,
  `id_order_type` int(10) unsigned DEFAULT NULL,
  `id_product_group` int(10) unsigned DEFAULT NULL,
  `id_order_status` int(10) unsigned NOT NULL DEFAULT '1',
  `total_item` smallint(6) unsigned NOT NULL,
  `total_price` smallint(6) unsigned NOT NULL,
  `date_finish` datetime NOT NULL,
  `date_due` datetime NOT NULL,
  `date_create` datetime NOT NULL,
  `date_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_receive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '0 = notreceive, 1 = receive',
  PRIMARY KEY (`id`),
  KEY `FK_order_head_customer` (`id_customer`),
  KEY `FK_order_head_order_type` (`id_order_type`),
  KEY `FK_order_head_product_group` (`id_product_group`),
  KEY `FK_order_head_order_status` (`id_order_status`),
  CONSTRAINT `FK_order_head_customer` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_order_head_order_status` FOREIGN KEY (`id_order_status`) REFERENCES `order_status` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_order_head_order_type` FOREIGN KEY (`id_order_type`) REFERENCES `order_type` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_order_head_product_group` FOREIGN KEY (`id_product_group`) REFERENCES `product_group` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.order_head: 44 rows
/*!40000 ALTER TABLE `order_head` DISABLE KEYS */;
INSERT INTO `order_head` (`id`, `id_customer`, `id_order_type`, `id_product_group`, `id_order_status`, `total_item`, `total_price`, `date_finish`, `date_due`, `date_create`, `date_update`, `is_receive`) VALUES (45, 14, 1, 1, 1, 50, 500, '2011-10-06 18:45:00', '2011-10-06 20:45:00', '2011-10-06 16:42:09', '2011-10-06 16:42:09', 0);
/*!40000 ALTER TABLE `order_head` ENABLE KEYS */;


# Dumping structure for table lek_laundry.order_item
DROP TABLE IF EXISTS `order_item`;
CREATE TABLE IF NOT EXISTS `order_item` (
  `id_order` int(10) unsigned NOT NULL,
  `id_product` int(10) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `product_name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `product_price` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id_order`,`id_product`),
  KEY `FK_order_item_order_head` (`id_order`),
  KEY `FK_order_item_product` (`id_product`),
  CONSTRAINT `FK_order_item_order_head` FOREIGN KEY (`id_order`) REFERENCES `order_head` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_order_item_product` FOREIGN KEY (`id_product`) REFERENCES `product` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.order_item: 171 rows
/*!40000 ALTER TABLE `order_item` DISABLE KEYS */;
INSERT INTO `order_item` (`id_order`, `id_product`, `quantity`, `product_name`, `product_price`, `remark`) VALUES (45, 10, 50, '', '', '');
/*!40000 ALTER TABLE `order_item` ENABLE KEYS */;


# Dumping structure for table lek_laundry.order_status
DROP TABLE IF EXISTS `order_status`;
CREATE TABLE IF NOT EXISTS `order_status` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.order_status: 2 rows
/*!40000 ALTER TABLE `order_status` DISABLE KEYS */;
INSERT INTO `order_status` (`id`, `name`) VALUES (1, 'รอดำเนินการ'), (2, 'ดำเนินการเสร็จแล้ว');
/*!40000 ALTER TABLE `order_status` ENABLE KEYS */;


# Dumping structure for table lek_laundry.order_type
DROP TABLE IF EXISTS `order_type`;
CREATE TABLE IF NOT EXISTS `order_type` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.order_type: 3 rows
/*!40000 ALTER TABLE `order_type` DISABLE KEYS */;
INSERT INTO `order_type` (`id`, `name`) VALUES (1, 'ซัก-อบ-รีด'), (2, 'ซัก-อบ'), (3, 'รีด');
/*!40000 ALTER TABLE `order_type` ENABLE KEYS */;


# Dumping structure for table lek_laundry.product
DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_product_group` int(10) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `price_wash` tinyint(3) unsigned DEFAULT NULL,
  `price_iron` tinyint(3) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_product_product_group` (`id_product_group`),
  CONSTRAINT `FK_product_product_group` FOREIGN KEY (`id_product_group`) REFERENCES `product_group` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.product: 39 rows
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `id_product_group`, `name`, `price_wash`, `price_iron`) VALUES (1, 1, 'เสื้อยืด', 5, 5), (2, 1, 'เสื้อกล้าม', 3, 5), (3, 1, 'เสื้อเชิ้ต', 5, 10), (4, 1, 'แจ็กเกต', 5, 10), (5, 1, 'กระโปรงสั้น', 3, 5), (6, 1, 'กระโปรงยาว', 5, 5), (7, 1, 'ชุดแซ็ก', 5, 5), (8, 1, 'กางเกงขาสั้น', 3, 5), (9, 1, 'กางเกงขายาว', 5, 10), (10, 1, 'กางเกงขาสามส่วน', 5, 5), (11, 1, 'กางเกงยีนส์', 5, 10), (12, 3, '', NULL, NULL), (13, 3, '', NULL, NULL), (14, 3, '', NULL, NULL), (15, 3, '', NULL, NULL), (16, 3, '', NULL, NULL), (17, 3, '', NULL, NULL), (18, 3, '', NULL, NULL), (19, 1, 'ผ้าเช็คหน้า', 3, 2), (20, 1, 'ผ้าเช็ดหัว', 3, 2), (21, 1, 'ผ้าเช็ดตัว', 5, 0), (22, 1, 'ชุดคลุมอาบน้ำ', 5, 0), (23, 2, 'ผ้านวมขนาดเล็ก', 60, 0), (24, 2, 'ผ้านวมขนาดกลาง', 80, 0), (25, 2, 'ผ้านวมขนาดใหญ่', 120, 0), (26, 2, 'ผ้าปูเตียงขนาดเล็ก', 20, 10), (27, 2, 'ผ้าปูเตียงขนาดกลาง', 40, 15), (28, 2, 'ผ้าปูเตียงขนาดใหญ่', 50, 20), (29, 2, 'ผ้าคลุมเตียงขนาดเล็ก', 20, 0), (30, 2, 'ผ้าคลุมเตียงขนาดกลาง', 40, 0), (31, 2, 'ผ้าคลุมเตียงขนาดใหญ่', 50, 0), (32, 2, 'ปลอกผ้านวมขนาดเล็ก', 20, 0), (33, 2, 'ปลอกผ้านวมขนาดกลาง', 40, 0), (34, 2, 'ปลอกผ้านวมขนาดใหญ่', 50, 0), (35, 2, 'ปลอกหมอน', 5, 5), (36, 2, 'ปลอกหมอนข้าง', 5, 5), (37, 3, '', NULL, NULL), (38, 3, '', NULL, NULL), (39, 3, '', NULL, NULL);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;


# Dumping structure for table lek_laundry.product_group
DROP TABLE IF EXISTS `product_group`;
CREATE TABLE IF NOT EXISTS `product_group` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.product_group: 3 rows
/*!40000 ALTER TABLE `product_group` DISABLE KEYS */;
INSERT INTO `product_group` (`id`, `name`, `description`) VALUES (1, 'ทั่วไป', NULL), (2, 'ชุดเครื่องนอน', NULL), (3, 'ซักมือ', NULL);
/*!40000 ALTER TABLE `product_group` ENABLE KEYS */;


# Dumping structure for table lek_laundry.queue_iron
DROP TABLE IF EXISTS `queue_iron`;
CREATE TABLE IF NOT EXISTS `queue_iron` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_machine` int(10) unsigned NOT NULL,
  `id_order` int(10) unsigned NOT NULL,
  `id_queue_time` int(10) unsigned DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `FK_queue_iron_machine` (`id_machine`),
  KEY `FK_queue_iron_order_head` (`id_order`),
  KEY `FK_queue_iron_queue_time` (`id_queue_time`),
  CONSTRAINT `FK_queue_iron_machine` FOREIGN KEY (`id_machine`) REFERENCES `machine` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_queue_iron_order_head` FOREIGN KEY (`id_order`) REFERENCES `order_head` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_queue_iron_queue_time` FOREIGN KEY (`id_queue_time`) REFERENCES `queue_time` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=585 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.queue_iron: 136 rows
/*!40000 ALTER TABLE `queue_iron` DISABLE KEYS */;
INSERT INTO `queue_iron` (`id`, `id_machine`, `id_order`, `id_queue_time`, `date_start`, `date_create`) VALUES (581, 7, 45, 36, '2011-10-06', '2011-10-06 16:42:09'), (582, 7, 45, 37, '2011-10-06', '2011-10-06 16:42:09'), (583, 7, 45, 38, '2011-10-06', '2011-10-06 16:42:09'), (584, 7, 45, 39, '2011-10-06', '2011-10-06 16:42:09');
/*!40000 ALTER TABLE `queue_iron` ENABLE KEYS */;


# Dumping structure for table lek_laundry.queue_time
DROP TABLE IF EXISTS `queue_time`;
CREATE TABLE IF NOT EXISTS `queue_time` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `time_start` time NOT NULL,
  `time_end` time NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.queue_time: 48 rows
/*!40000 ALTER TABLE `queue_time` DISABLE KEYS */;
INSERT INTO `queue_time` (`id`, `time_start`, `time_end`) VALUES (1, '09:00:00', '09:14:59'), (2, '09:15:00', '09:29:59'), (3, '09:30:00', '09:44:59'), (4, '09:45:00', '09:59:59'), (5, '10:00:00', '10:14:59'), (6, '10:15:00', '10:29:59'), (7, '10:30:00', '10:44:59'), (8, '10:45:00', '10:59:59'), (9, '11:00:00', '11:14:59'), (10, '11:15:00', '11:29:59'), (11, '11:30:00', '11:44:59'), (12, '11:45:00', '11:59:59'), (13, '12:00:00', '12:14:59'), (14, '12:15:00', '12:29:59'), (15, '12:30:00', '12:44:59'), (16, '12:45:00', '12:59:59'), (17, '13:00:00', '13:14:59'), (18, '13:15:00', '13:29:59'), (19, '13:30:00', '13:44:59'), (20, '13:45:00', '13:59:59'), (21, '14:00:00', '14:14:59'), (22, '14:15:00', '14:29:59'), (23, '14:30:00', '14:44:59'), (24, '14:45:00', '14:59:59'), (25, '15:00:00', '15:14:59'), (26, '15:15:00', '15:29:59'), (27, '15:30:00', '15:44:59'), (28, '15:45:00', '15:59:59'), (29, '16:00:00', '16:14:59'), (30, '16:15:00', '16:29:59'), (31, '16:30:00', '16:44:59'), (32, '16:45:00', '16:59:59'), (33, '17:00:00', '17:14:59'), (34, '17:15:00', '17:29:59'), (35, '17:30:00', '17:44:59'), (36, '17:45:00', '17:59:59'), (37, '18:00:00', '18:14:59'), (38, '18:15:00', '18:29:59'), (39, '18:30:00', '18:44:59'), (40, '18:45:00', '18:59:59'), (41, '19:00:00', '19:14:59'), (42, '19:15:00', '19:29:59'), (43, '19:30:00', '19:44:59'), (44, '19:45:00', '19:59:59'), (45, '20:00:00', '20:14:59'), (46, '20:15:00', '20:29:59'), (47, '20:30:00', '20:44:59'), (48, '20:45:00', '20:59:59');
/*!40000 ALTER TABLE `queue_time` ENABLE KEYS */;


# Dumping structure for table lek_laundry.queue_wash
DROP TABLE IF EXISTS `queue_wash`;
CREATE TABLE IF NOT EXISTS `queue_wash` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_machine` int(10) unsigned NOT NULL,
  `id_order` int(10) unsigned NOT NULL,
  `id_queue_time` int(10) unsigned DEFAULT NULL,
  `date_start` date DEFAULT NULL,
  `date_create` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_queue_wash_machine` (`id_machine`),
  KEY `FK_queue_wash_order_head` (`id_order`),
  KEY `FK_queue_wash_queue_time` (`id_queue_time`),
  CONSTRAINT `FK_queue_wash_machine` FOREIGN KEY (`id_machine`) REFERENCES `machine` (`id`) ON UPDATE CASCADE,
  CONSTRAINT `FK_queue_wash_order_head` FOREIGN KEY (`id_order`) REFERENCES `order_head` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_queue_wash_queue_time` FOREIGN KEY (`id_queue_time`) REFERENCES `queue_time` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=537 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

# Dumping data for table lek_laundry.queue_wash: 136 rows
/*!40000 ALTER TABLE `queue_wash` DISABLE KEYS */;
INSERT INTO `queue_wash` (`id`, `id_machine`, `id_order`, `id_queue_time`, `date_start`, `date_create`) VALUES (533, 3, 45, 32, '2011-10-06', '2011-10-06 00:00:00'), (534, 3, 45, 33, '2011-10-06', '2011-10-06 00:00:00'), (535, 3, 45, 34, '2011-10-06', '2011-10-06 00:00:00'), (536, 3, 45, 35, '2011-10-06', '2011-10-06 00:00:00');
/*!40000 ALTER TABLE `queue_wash` ENABLE KEYS */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
