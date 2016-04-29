/*
SQLyog Ultimate v11.11 (64 bit)
MySQL - 5.6.17 : Database - crslivedb
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`crslivedb` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `crslivedb`;

/*Table structure for table `crs_admin_users` */

DROP TABLE IF EXISTS `crs_admin_users`;

CREATE TABLE `crs_admin_users` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `userpassword` varchar(255) DEFAULT NULL,
  `active_status` int(10) DEFAULT '0',
  `user_type` enum('admin','manager') DEFAULT NULL,
  `trash_status` int(10) DEFAULT '0',
  `profile_type` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

/*Data for the table `crs_admin_users` */

insert  into `crs_admin_users`(`id`,`email`,`username`,`userpassword`,`active_status`,`user_type`,`trash_status`,`profile_type`) values (11,NULL,'admin','edb8d9a04705539e91aa7520fbf37a05',1,'admin',0,1),(12,NULL,'admin1','edb8d9a04705539e91aa7520fbf37a05',1,'admin',0,2);

/*Table structure for table `crs_client` */

DROP TABLE IF EXISTS `crs_client`;

CREATE TABLE `crs_client` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `client_id` varchar(122) DEFAULT NULL,
  `client_name` varchar(255) DEFAULT NULL,
  `organisation` varchar(500) DEFAULT NULL,
  `emailid` varchar(255) DEFAULT NULL,
  `mobileno` int(12) DEFAULT NULL,
  `landline` varchar(122) DEFAULT NULL,
  `address` varchar(500) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `cemailid` varchar(255) DEFAULT NULL,
  `cmobileno` int(12) DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `return_status` enum('no','yes') DEFAULT 'no',
  `return_date` datetime DEFAULT NULL,
  `next_payment_date` datetime DEFAULT NULL,
  `profile_type` int(2) DEFAULT '0',
  `trash_status` int(2) DEFAULT '0',
  `comments` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `crs_client` */

insert  into `crs_client`(`id`,`client_id`,`client_name`,`organisation`,`emailid`,`mobileno`,`landline`,`address`,`contact_person`,`cemailid`,`cmobileno`,`delivery_date`,`return_status`,`return_date`,`next_payment_date`,`profile_type`,`trash_status`,`comments`) values (1,NULL,'client11','test','test@gmail.com',123456789,NULL,'test',NULL,NULL,NULL,'2015-03-10 00:00:00','no','2015-03-10 00:00:00','2015-03-20 15:52:48',1,0,NULL),(2,'BS0001','client2','test','test@gmail.com',123456789,NULL,'test',NULL,NULL,NULL,NULL,'no',NULL,'2015-03-18 15:52:55',2,0,NULL),(3,NULL,'dgdf','dfgsd','test@gmail.com',452543,NULL,'dfgfd',NULL,NULL,NULL,NULL,'no',NULL,'2015-03-21 15:53:02',1,0,NULL),(4,NULL,'dges','gdfsgre','test@gmail.com',563876563,NULL,'gdfsgdf',NULL,NULL,NULL,'1970-01-01 00:00:00','no','1970-01-01 00:00:00','2015-03-25 15:53:08',1,0,NULL),(5,NULL,'stew','sdfgsd','test@gmail.com',3453453,NULL,'fghfghfg',NULL,NULL,NULL,'2015-03-10 00:00:00','no','2015-03-10 00:00:00','2015-03-28 15:53:13',1,1,NULL),(6,NULL,'test','test','test@gmail.com',1234456,'42343223','test','test','test@gmail.com',124312421,'2015-03-23 00:00:00','no','2015-04-24 00:00:00','2015-04-24 00:00:00',1,0,'test'),(7,NULL,'test1','test1','test1@gmail.com',12344561,'423432231','test1','test1','test1@gmail.com',1243124211,'2015-03-23 00:00:00','no','2015-04-24 00:00:00','2015-04-24 00:00:00',1,0,'test1'),(8,NULL,'test1','test1','test1@gmail.com',12344561,'423432231','test1','test1','test1@gmail.com',1243124211,'2015-03-23 00:00:00','no','2015-04-24 00:00:00','2015-04-24 00:00:00',1,0,'test1'),(9,NULL,'test11','test11','test1@gmail.com',12344561,'423432231','test11','test1','test1@gmail.com',1243124211,'2015-03-23 00:00:00','no','2015-04-24 00:00:00','2015-04-24 00:00:00',1,0,'test1'),(10,'CRS0001','test112','test112','test1@gmail.com',12344561,'423432231','test112','test1','test1@gmail.com',1243124211,'2015-03-23 00:00:00','no','2015-04-24 00:00:00','2015-04-24 00:00:00',1,0,'test1');

/*Table structure for table `crs_client_document` */

DROP TABLE IF EXISTS `crs_client_document`;

CREATE TABLE `crs_client_document` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `client_id` int(10) DEFAULT NULL,
  `document_name` varchar(255) DEFAULT NULL,
  `document_type` varchar(255) DEFAULT NULL,
  `updated_date` datetime DEFAULT NULL,
  `verifiedby` varchar(255) DEFAULT NULL,
  `verified_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `crs_client_document` */

insert  into `crs_client_document`(`id`,`client_id`,`document_name`,`document_type`,`updated_date`,`verifiedby`,`verified_date`) values (1,10,'document_10_23032015104015.oxps','id proof','2015-03-23 10:40:15','test','2015-03-23 11:37:40'),(2,10,'document_10_23032015110446.jpg','address proof','2015-03-23 11:04:46',NULL,NULL);

/*Table structure for table `crs_maintainance` */

DROP TABLE IF EXISTS `crs_maintainance`;

CREATE TABLE `crs_maintainance` (
  `id` int(128) NOT NULL AUTO_INCREMENT,
  `prop_address` varchar(255) DEFAULT NULL,
  `apart_number` varchar(255) DEFAULT NULL,
  `area_description` text,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_number` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `show_status` enum('show','hide') DEFAULT 'show',
  `absence_value` varchar(128) DEFAULT NULL,
  `p_time` varchar(255) DEFAULT NULL,
  `b_time` varchar(255) DEFAULT NULL,
  `request_date` datetime DEFAULT NULL,
  `status` int(10) DEFAULT '0',
  `comments` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `crs_maintainance` */

/*Table structure for table `crs_system_details` */

DROP TABLE IF EXISTS `crs_system_details`;

CREATE TABLE `crs_system_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `client_id` int(10) DEFAULT NULL,
  `system_type` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text,
  `system_qty` int(10) DEFAULT NULL,
  `unit_rent` decimal(5,2) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `trash_status` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `crs_system_details` */

insert  into `crs_system_details`(`id`,`client_id`,`system_type`,`short_description`,`description`,`system_qty`,`unit_rent`,`last_update_date`,`trash_status`) values (1,1,'laptop','i3','test',2,150.00,'2015-03-20 06:50:24',0),(2,1,'laptop','i7','test',1,100.00,'2015-03-20 06:50:10',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
