/*
SQLyog Professional v10.42 
MySQL - 5.5.16 : Database - cosmopoliten
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`cosmopoliten` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `cosmopoliten`;

/*Table structure for table `brand` */

DROP TABLE IF EXISTS `brand`;

CREATE TABLE `brand` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `logo` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `brand` */

LOCK TABLES `brand` WRITE;

insert  into `brand`(`id`,`name`,`logo`) values (1,'GUCHI',''),(2,'IMPORIO ARMANI',''),(3,'ADIDAS',''),(4,'PUMA',''),(5,'D&G','');

UNLOCK TABLES;

/*Table structure for table `color` */

DROP TABLE IF EXISTS `color`;

CREATE TABLE `color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `code` varchar(45) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `color` */

LOCK TABLES `color` WRITE;

insert  into `color`(`id`,`name`,`code`) values (1,'red','#FF0000'),(2,'green','#008000'),(3,'yellow','#FFFF00'),(4,'black','#000000'),(5,'white','#FFFFFF');

UNLOCK TABLES;

/*Table structure for table `material` */

DROP TABLE IF EXISTS `material`;

CREATE TABLE `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `material` */

LOCK TABLES `material` WRITE;

insert  into `material`(`id`,`name`) values (1,'leather'),(2,'silk'),(3,'fabric');

UNLOCK TABLES;

/*Table structure for table `objecttype` */

DROP TABLE IF EXISTS `objecttype`;

CREATE TABLE `objecttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT 'defaultImages/objectType.png',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `objecttype` */

LOCK TABLES `objecttype` WRITE;

insert  into `objecttype`(`id`,`name`,`path`) values (1,'shoes','defaultImages/objectType.png'),(2,'dresses','defaultImages/objectType.png'),(3,'pants','defaultImages/objectType.png'),(4,'cap','defaultImages/objectType.png'),(5,'garniture','defaultImages/objectType.png'),(6,'suit','defaultImages/objectType.png');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
