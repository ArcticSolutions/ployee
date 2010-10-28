-- Ployee database structure
-- Includes demo content
-- NB! REMEMBER TO SELECT THE DATABASE BEFORE RUNNING THIS!


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

--
-- Definition of table `employees`
--

DROP TABLE IF EXISTS `employees`;
CREATE TABLE `employees` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `username` varchar(45) NOT NULL,
  `email` varchar(250) DEFAULT NULL,
  `password` varchar(45) NOT NULL,
  `extra` tinyint(1) NOT NULL DEFAULT '0',
  `selected_id` int(10) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `Username` (`username`),
  KEY `Name` (`name`),
  KEY `Email` (`email`),
  KEY `Extra` (`extra`),
  KEY `Selected_id` (`selected_id`),
  CONSTRAINT `selected_id` FOREIGN KEY (`selected_id`) REFERENCES `images` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `employees`
--

/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` (`id`,`name`,`username`,`email`,`password`,`extra`,`selected_id`) VALUES 
 (1,'Efstathios Nala','0126',NULL,'1234',0,NULL),
 (2,'Annemarie Salome','0127',NULL,'1234',0,NULL),
 (3,'Lucius Achim','0128',NULL,'1234',0,NULL),
 (4,'Agnes Linus','0129',NULL,'1234',0,NULL);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;


--
-- Definition of table `images`
--

DROP TABLE IF EXISTS `images`;
CREATE TABLE `images` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `employee_id` int(10) unsigned DEFAULT NULL,
  `originalname` varchar(250) NOT NULL,
  `filename_thumb` varchar(100) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE KEY `Filename` (`filename`),
  UNIQUE KEY `Originalname` (`originalname`),
  KEY `Employee_id` (`employee_id`),
  CONSTRAINT `employee_id` FOREIGN KEY (`employee_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `images`
--

/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` (`id`,`filename`,`employee_id`,`originalname`,`filename_thumb`) VALUES 
 (1,'0126_001_L.jpg',1,'0126_001_L.jpg','0126_001_S.jpg'),
 (2,'0126_002_L.jpg',1,'0126_002_L.jpg','0126_002_S.jpg'),
 (3,'0126_003_L.jpg',1,'0126_003_L.jpg','0126_003_S.jpg'),
 (4,'0126_004_L.jpg',1,'0126_004_L.jpg','0126_004_S.jpg'),
 (5,'0127_001_L.jpg',2,'0127_001_L.jpg','0127_001_S.jpg'),
 (6,'0127_002_L.jpg',2,'0127_002_L.jpg','0127_002_S.jpg'),
 (7,'0127_003_L.jpg',2,'0127_003_L.jpg','0127_003_S.jpg'),
 (8,'0127_004_L.jpg',2,'0127_004_L.jpg','0127_004_S.jpg'),
 (9,'0128_001_L.jpg',3,'0128_001_L.jpg','0128_001_S.jpg'),
 (10,'0128_002_L.jpg',3,'0128_002_L.jpg','0128_002_S.jpg'),
 (11,'0128_003_L.jpg',3,'0128_003_L.jpg','0128_003_S.jpg'),
 (12,'0128_004_L.jpg',3,'0128_004_L.jpg','0128_004_S.jpg'),
 (13,'0129_001_L.jpg',4,'0129_001_L.jpg','0129_001_S.jpg'),
 (14,'0129_002_L.jpg',4,'0129_002_L.jpg','0129_002_S.jpg'),
 (15,'0129_003_L.jpg',4,'0129_003_L.jpg','0129_003_S.jpg'),
 (16,'0129_004_L.jpg',4,'0129_004_L.jpg','0129_004_S.jpg');
/*!40000 ALTER TABLE `images` ENABLE KEYS */;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
