/*
SQLyog Ultimate v10.00 Beta1
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
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
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

insert  into `crs_admin_users`(`id`,`firstname`,`lastname`,`email`,`username`,`userpassword`,`active_status`,`user_type`,`trash_status`,`profile_type`) values (11,'elan','','elanvans@gmail.com','admin','edb8d9a04705539e91aa7520fbf37a05',1,'admin',0,1),(12,'elan',NULL,'elanvans@gmail.com','admin1','edb8d9a04705539e91aa7520fbf37a05',1,'admin',0,2);

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
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `invoice_date` int(10) DEFAULT '0',
  `return_status` enum('no','yes') DEFAULT 'no',
  `profile_type` int(2) DEFAULT '0',
  `trash_status` int(2) DEFAULT '0',
  `comments` text,
  `duration_type` enum('month','year') DEFAULT NULL,
  `duration` int(10) DEFAULT NULL,
  `total_systems` int(10) DEFAULT '0',
  `active` enum('yes','no') DEFAULT 'yes',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

/*Data for the table `crs_client` */

insert  into `crs_client`(`id`,`client_id`,`client_name`,`organisation`,`emailid`,`mobileno`,`landline`,`address`,`contact_person`,`cemailid`,`cmobileno`,`start_date`,`end_date`,`invoice_date`,`return_status`,`profile_type`,`trash_status`,`comments`,`duration_type`,`duration`,`total_systems`,`active`) values (6,'CRS0001','test','test','test@gmail.com',1234456,'42343223','test','test','test@gmail.com',124312421,'2015-03-23 00:00:00','2015-04-08 00:00:00',11,'no',1,0,'test','month',6,2,'yes'),(7,'CRS0002','test1','test1','test1@gmail.com',12344561,'423432231','test1','test1','test1@gmail.com',1243124211,'2015-03-23 00:00:00','2015-04-09 00:00:00',9,'no',1,0,'test1','month',10,3,'yes'),(8,'CRS0003','test1','test1','test1@gmail.com',12344561,'423432231','test1','test1','test1@gmail.com',1243124211,'2015-03-23 00:00:00','2015-04-10 00:00:00',9,'no',1,0,'test1','month',4,4,'yes'),(9,'CRS0004','test11','test11','test1@gmail.com',12344561,'423432231','test11','test1','test1@gmail.com',1243124211,'2015-03-23 00:00:00','2015-04-24 00:00:00',9,'no',1,0,'test1','month',2,5,'yes'),(10,'CRS0005','test112','test112','test1@gmail.com',12344561,'423432231','test112','test1','test1@gmail.com',1243124211,'2015-03-23 00:00:00','2015-04-24 00:00:00',9,'no',1,0,'test1','year',1,5,'yes'),(11,'CRS0006','Shankar','caltech','san5835@gmail.com',2147483647,'23423423423','asdlfkasjfla','23423423','san5835@gmail.com',234234,'2015-04-08 00:00:00','2015-04-23 00:00:00',10,'no',1,0,'qwereqwrqwerqwe','month',6,5,'yes');

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
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `crs_client_document` */

insert  into `crs_client_document`(`id`,`client_id`,`document_name`,`document_type`,`updated_date`,`verifiedby`,`verified_date`) values (1,10,'document_10_23032015104015.oxps','id proof','2015-03-23 10:40:15','test','2015-03-23 11:37:40'),(2,10,'document_10_23032015110446.jpg','address proof','2015-03-23 11:04:46',NULL,NULL),(3,11,'document_11_08042015060716.jpg','Address Proof','2015-04-08 06:07:16','Sankar','2015-04-08 06:07:30');

/*Table structure for table `crs_invoice_list` */

DROP TABLE IF EXISTS `crs_invoice_list`;

CREATE TABLE `crs_invoice_list` (
  `id` bigint(10) NOT NULL AUTO_INCREMENT,
  `client_id` int(32) DEFAULT '0',
  `invoice_id` varchar(128) DEFAULT NULL,
  `invoice_period` varchar(128) DEFAULT NULL,
  `generated_date` datetime DEFAULT NULL,
  `email_status` enum('sent','notsend','cancelled') DEFAULT NULL,
  `payment_status` enum('pending','paid','hold') DEFAULT NULL,
  `invoice_file_name` varchar(128) DEFAULT NULL,
  `admin_id` int(32) DEFAULT NULL,
  `archive_status` int(2) DEFAULT '0',
  `invoice_amount` decimal(10,2) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `profile_type` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

/*Data for the table `crs_invoice_list` */

insert  into `crs_invoice_list`(`id`,`client_id`,`invoice_id`,`invoice_period`,`generated_date`,`email_status`,`payment_status`,`invoice_file_name`,`admin_id`,`archive_status`,`invoice_amount`,`invoice_date`,`profile_type`) values (5,6,'CRS0001042015','11-Apr-2015','2015-04-08 12:58:34','notsend','pending','INVOICE_CRS0001042015125834',11,0,'13000.00','2015-04-11',1),(6,6,'CRS0001042015','11-Apr-2015','2015-04-08 13:13:03','notsend','pending','INVOICE_CRS0001042015131303',11,0,'13000.00','2015-04-11',1),(7,6,'CRS0001042015','11-Apr-2015','2015-04-08 13:50:55','notsend','pending','INVOICE_CRS0001042015135055',11,0,'13000.00','2015-04-11',1),(8,6,'CRS0001042015','11-Apr-2015','2015-04-08 14:06:23','notsend','pending','INVOICE_CRS0001042015140623',11,0,'13000.00','2015-04-11',1),(9,6,'CRS0001042015','11-Apr-2015','2015-04-08 14:07:30','notsend','pending','INVOICE_CRS0001042015140730',11,0,'13000.00','2015-04-11',1),(10,6,'CRS0001042015','11-Apr-2015','2015-04-09 06:21:54','notsend','pending','INVOICE_CRS0001042015062154',11,0,'13000.00','2015-04-11',1);

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

/*Table structure for table `crs_onoffice_systems` */

DROP TABLE IF EXISTS `crs_onoffice_systems`;

CREATE TABLE `crs_onoffice_systems` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `system_type` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text,
  `system_qty` int(10) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `trash_status` int(2) DEFAULT '0',
  `available_status` enum('yes','no') DEFAULT 'yes',
  `profile_type` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

/*Data for the table `crs_onoffice_systems` */

insert  into `crs_onoffice_systems`(`id`,`system_type`,`short_description`,`description`,`system_qty`,`last_update_date`,`trash_status`,`available_status`,`profile_type`) values (1,'laptop','sf','sfs',3,'2015-04-20 06:57:08',0,'yes',1),(2,'desktop','i3','test',2,'2015-04-20 07:19:22',0,'yes',1);

/*Table structure for table `crs_rental_category` */

DROP TABLE IF EXISTS `crs_rental_category`;

CREATE TABLE `crs_rental_category` (
  `id` int(32) NOT NULL AUTO_INCREMENT,
  `rental_category` varchar(120) DEFAULT NULL,
  `category_meta` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `crs_rental_category` */

insert  into `crs_rental_category`(`id`,`rental_category`,`category_meta`) values (1,'Desktop','desktop'),(2,'Laptop','laptop'),(3,'Monitor','monitor'),(4,'CPU','cpu'),(5,'Network Switch','switch');

/*Table structure for table `crs_system_details` */

DROP TABLE IF EXISTS `crs_system_details`;

CREATE TABLE `crs_system_details` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `client_id` int(10) DEFAULT NULL,
  `system_type` varchar(255) DEFAULT NULL,
  `short_description` varchar(255) DEFAULT NULL,
  `description` text,
  `system_qty` int(10) DEFAULT NULL,
  `unit_rent` decimal(10,2) DEFAULT NULL,
  `last_update_date` datetime DEFAULT NULL,
  `trash_status` int(2) DEFAULT '0',
  `rental_status` enum('yes','no') DEFAULT 'yes',
  `profile_type` int(2) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `crs_system_details` */

insert  into `crs_system_details`(`id`,`client_id`,`system_type`,`short_description`,`description`,`system_qty`,`unit_rent`,`last_update_date`,`trash_status`,`rental_status`,`profile_type`) values (1,1,'laptop','i3','test',2,'150.00','2015-03-20 06:50:24',0,'yes',1),(2,1,'laptop','i7','test',1,'100.00','2015-03-20 06:50:10',0,'yes',1),(3,6,'desktop','i3','test',5,'1000.00','2015-04-08 09:48:42',0,'yes',1),(4,6,'laptop','i5','test',4,'2000.00','2015-04-08 11:45:32',0,'yes',1),(5,6,'monitor','test','test',2,'200.00','2015-04-20 06:58:41',0,'yes',1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
