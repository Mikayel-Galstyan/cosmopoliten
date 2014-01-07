/*
SQLyog Professional v10.42 
MySQL - 5.5.16 : Database - 737934
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`737934` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `737934`;

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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `color` */

LOCK TABLES `color` WRITE;

insert  into `color`(`id`,`name`,`code`) values (1,'red','#FF0000'),(2,'green','#008000'),(3,'yellow','#FFFF00'),(4,'black','#000000'),(5,'white','#FFFFFF'),(6,'gold','rgb(250, 250, 5)');

UNLOCK TABLES;

/*Table structure for table `comment` */

DROP TABLE IF EXISTS `comment`;

CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `table_name` varchar(45) NOT NULL DEFAULT 'objects',
  `message` text NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `subject_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `comment` */

LOCK TABLES `comment` WRITE;

UNLOCK TABLES;

/*Table structure for table `discount` */

DROP TABLE IF EXISTS `discount`;

CREATE TABLE `discount` (
  `id` int(11) NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `percent` float NOT NULL,
  `shopList_id` int(11) NOT NULL,
  `objectType_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `discount` */

LOCK TABLES `discount` WRITE;

UNLOCK TABLES;

/*Table structure for table `imagesstatus` */

DROP TABLE IF EXISTS `imagesstatus`;

CREATE TABLE `imagesstatus` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `likes` int(11) NOT NULL DEFAULT '0',
  `path` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `imagesstatus` */

LOCK TABLES `imagesstatus` WRITE;

UNLOCK TABLES;

/*Table structure for table `lovelist` */

DROP TABLE IF EXISTS `lovelist`;

CREATE TABLE `lovelist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `object_id` int(11) DEFAULT NULL,
  `publisher_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_loveList_users1` (`user_id`),
  KEY `fk_loveList_objects1` (`object_id`),
  KEY `fk_loveList_publishers1` (`publisher_id`),
  CONSTRAINT `fk_loveList_objects1` FOREIGN KEY (`object_id`) REFERENCES `objects` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_loveList_publishers1` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_loveList_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `lovelist` */

LOCK TABLES `lovelist` WRITE;

UNLOCK TABLES;

/*Table structure for table `material` */

DROP TABLE IF EXISTS `material`;

CREATE TABLE `material` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `active` int(1) DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `material` */

LOCK TABLES `material` WRITE;

insert  into `material`(`id`,`name`,`active`) values (1,'leather',2),(2,'silk',2),(3,'fabric',2);

UNLOCK TABLES;

/*Table structure for table `objects` */

DROP TABLE IF EXISTS `objects`;

CREATE TABLE `objects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `description` text,
  `path` varchar(255) NOT NULL DEFAULT 'defaultImages/objects.png',
  `name` varchar(45) DEFAULT NULL,
  `cost` float DEFAULT NULL,
  `publisher_id` int(11) NOT NULL,
  `objectType_id` int(11) NOT NULL,
  `shopList_id` int(11) DEFAULT NULL,
  `population` int(11) NOT NULL DEFAULT '0',
  `gender` int(11) NOT NULL DEFAULT '1',
  `valuta` int(11) NOT NULL DEFAULT '1',
  `brand_id` int(11) DEFAULT NULL,
  `material_id` int(11) DEFAULT NULL,
  `color_id` int(11) DEFAULT NULL,
  `object_group_id` int(11) DEFAULT '0',
  `path_back` varchar(255) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_objects_publishers` (`publisher_id`),
  KEY `fk_objects_objectType1` (`objectType_id`),
  KEY `fk_objects_shopList1` (`shopList_id`),
  CONSTRAINT `fk_objects_objectType1` FOREIGN KEY (`objectType_id`) REFERENCES `objecttype` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_objects_publishers` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_objects_shopList1` FOREIGN KEY (`shopList_id`) REFERENCES `shoplist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `objects` */

LOCK TABLES `objects` WRITE;

insert  into `objects`(`id`,`description`,`path`,`name`,`cost`,`publisher_id`,`objectType_id`,`shopList_id`,`population`,`gender`,`valuta`,`brand_id`,`material_id`,`color_id`,`object_group_id`,`path_back`,`active`) values (1,'default.description','users/publisher@mail.ru/1/00206c31f0ba72c24024b87706322cf1.png','default.name.object',30,1,1,1,0,1,1,1,1,1,0,NULL,1),(2,'default.description','users/publisher@mail.ru/1/d6c39cd522ca9f06dd4e316dd938dd59.png','default.name.object',30,1,1,1,0,1,1,1,1,1,0,NULL,1);

UNLOCK TABLES;

/*Table structure for table `objectsgroup` */

DROP TABLE IF EXISTS `objectsgroup`;

CREATE TABLE `objectsgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `path` varchar(255) NOT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `objectsgroup` */

LOCK TABLES `objectsgroup` WRITE;

UNLOCK TABLES;

/*Table structure for table `objecttype` */

DROP TABLE IF EXISTS `objecttype`;

CREATE TABLE `objecttype` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT 'defaultImages/objectType.png',
  `active` int(1) DEFAULT '2',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `objecttype` */

LOCK TABLES `objecttype` WRITE;

insert  into `objecttype`(`id`,`name`,`path`,`active`) values (1,'shoes','defaultImages/objectType.png',2),(2,'dresses','defaultImages/objectType.png',2),(3,'pants','defaultImages/objectType.png',2),(4,'cap','defaultImages/objectType.png',2),(5,'garniture','defaultImages/objectType.png',2),(6,'suit','defaultImages/objectType.png',2);

UNLOCK TABLES;

/*Table structure for table `publishers` */

DROP TABLE IF EXISTS `publishers`;

CREATE TABLE `publishers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `order` tinyint(1) NOT NULL,
  `address` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `site` varchar(45) DEFAULT NULL,
  `clicks` int(11) NOT NULL DEFAULT '0',
  `user_id` int(11) NOT NULL,
  `end_order_date` datetime NOT NULL,
  `population` int(11) NOT NULL DEFAULT '0',
  `status` int(2) DEFAULT '1',
  `path` varchar(255) NOT NULL DEFAULT 'defaultImages/publishers.png',
  PRIMARY KEY (`id`),
  KEY `fk_publishers_users1` (`user_id`),
  CONSTRAINT `fk_publishers_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `publishers` */

LOCK TABLES `publishers` WRITE;

insert  into `publishers`(`id`,`name`,`order`,`address`,`phone`,`site`,`clicks`,`user_id`,`end_order_date`,`population`,`status`,`path`) values (1,'Roberto',1,'Totovenc 3/3','545454','myWebsite.com',2,2,'2014-01-27 12:04:04',0,1,'users/publisher@mail.ru/Roberto/fa9d288a820e1cc1a49f11f44ceb1c6c.png');

UNLOCK TABLES;

/*Table structure for table `shopgroup` */

DROP TABLE IF EXISTS `shopgroup`;

CREATE TABLE `shopgroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) NOT NULL,
  `path` varchar(255) NOT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `shopgroup` */

LOCK TABLES `shopgroup` WRITE;

UNLOCK TABLES;

/*Table structure for table `shopimage` */

DROP TABLE IF EXISTS `shopimage`;

CREATE TABLE `shopimage` (
  `id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT 'defaultImages/shopList.png',
  `shopList_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_shopImage_shopList1` (`shopList_id`),
  CONSTRAINT `fk_shopImage_shopList1` FOREIGN KEY (`shopList_id`) REFERENCES `shoplist` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `shopimage` */

LOCK TABLES `shopimage` WRITE;

UNLOCK TABLES;

/*Table structure for table `shoplist` */

DROP TABLE IF EXISTS `shoplist`;

CREATE TABLE `shoplist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `address` varchar(45) NOT NULL,
  `phone` varchar(45) NOT NULL,
  `description` text NOT NULL,
  `publisher_id` int(11) NOT NULL,
  `population` int(11) NOT NULL DEFAULT '0',
  `name` varchar(45) NOT NULL,
  `path` varchar(255) NOT NULL DEFAULT 'defaultImages/shopList.png',
  `site` varchar(45) DEFAULT NULL,
  `mapControl` varchar(200) NOT NULL DEFAULT '{lat:0,long:0}',
  `shops_group_id` int(11) DEFAULT NULL,
  `active` int(1) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_shopList_publishers1` (`publisher_id`),
  CONSTRAINT `fk_shopList_publishers1` FOREIGN KEY (`publisher_id`) REFERENCES `publishers` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

/*Data for the table `shoplist` */

LOCK TABLES `shoplist` WRITE;

insert  into `shoplist`(`id`,`address`,`phone`,`description`,`publisher_id`,`population`,`name`,`path`,`site`,`mapControl`,`shops_group_id`,`active`) values (1,'amiryan 3/3','545454','sa hrashq e',1,2,'Roberto','users/publisher@mail.ru/Roberto/022898bbc7110244fd24b3e410597047.png','roberto.am','\'{lat:44.52085018157959,long:undefined}\'',NULL,1);

UNLOCK TABLES;

/*Table structure for table `userimage` */

DROP TABLE IF EXISTS `userimage`;

CREATE TABLE `userimage` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_userImage_users1` (`user_id`),
  CONSTRAINT `fk_userImage_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `userimage` */

LOCK TABLES `userimage` WRITE;

UNLOCK TABLES;

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(45) DEFAULT 'unkown',
  `last_name` varchar(45) DEFAULT 'unkown',
  `login` varchar(45) DEFAULT NULL,
  `email` varchar(45) NOT NULL,
  `password` varchar(255) NOT NULL,
  `gender` int(2) DEFAULT NULL,
  `status` varchar(45) NOT NULL DEFAULT '2',
  `date` datetime NOT NULL,
  `password_salt` varchar(45) NOT NULL,
  `oauth_uid` varchar(200) DEFAULT NULL,
  `oauth_provider` varchar(200) DEFAULT NULL,
  `twitter_oauth_token` varchar(200) DEFAULT NULL,
  `twitter_oauth_token_secret` varchar(200) DEFAULT NULL,
  `username` varchar(200) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `activate` int(2) DEFAULT '0',
  `send_discount_maile_status` varchar(45) DEFAULT '0',
  `activation_key` varchar(200) DEFAULT NULL,
  `used_last_image` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `users` */

LOCK TABLES `users` WRITE;

insert  into `users`(`id`,`first_name`,`last_name`,`login`,`email`,`password`,`gender`,`status`,`date`,`password_salt`,`oauth_uid`,`oauth_provider`,`twitter_oauth_token`,`twitter_oauth_token_secret`,`username`,`path`,`activate`,`send_discount_maile_status`,`activation_key`,`used_last_image`) values (1,'Mikayel','Galstyan','admin','admin','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec',1,'3','2013-12-27 11:48:03','',NULL,NULL,NULL,NULL,NULL,'users/miko-galstyan@mail.ru/c2a21fe05c383aa8bf70ca44f68fedc8.png',0,'0','0668c4a329c745799ae1961340d62914','users/miko-galstyan@mail.ru/c2a21fe05c383aa8bf70ca44f68fedc8.png'),(2,'unkown','unkown',NULL,'publisher@mail.ru','c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec',NULL,'1','2013-12-27 12:02:08','',NULL,NULL,NULL,NULL,NULL,'users/publisher@mail.ru/061a107cb23e524a972dec77e905d9ca.png',0,'0','bdad8edecdae03292d17a674bbcdf056','users/publisher@mail.ru/061a107cb23e524a972dec77e905d9ca.png');

UNLOCK TABLES;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
