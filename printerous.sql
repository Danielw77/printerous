/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 10.4.14-MariaDB : Database - printerous
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`printerous` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `printerous`;

/*Table structure for table `m_organization` */

DROP TABLE IF EXISTS `m_organization`;

CREATE TABLE `m_organization` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `website` varchar(50) DEFAULT NULL,
  `logo` text DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

/*Data for the table `m_organization` */

insert  into `m_organization`(`id`,`name`,`phone`,`email`,`website`,`logo`) values 
(6,'Printerous','02153670433','support@printerous.com','printerous.com','AX0NKVFiAiYCJVJsADlUZgY0AX8FaVE2AjYCKwJgXHVQJQBiVyAAfwB9CGoHOFxvDXVQd1d0DzsGJwB/DHkGYltuVTJRNlsuUmVRYAU2DDQBYQ01UTECYQJtUjkAfVQ3BmUBOQUwUXQCaQI1AixcNlBnACpXJAB+ADsIbQchXG0NKFBtV3IPLQZ7AHoMZwZp');

/*Table structure for table `m_organization_pic` */

DROP TABLE IF EXISTS `m_organization_pic`;

CREATE TABLE `m_organization_pic` (
  `pic_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_id` int(11) DEFAULT NULL,
  `user_name` varchar(50) DEFAULT NULL,
  `user_email` varchar(50) DEFAULT NULL,
  `user_phone` varchar(20) DEFAULT NULL,
  `avatar` text DEFAULT NULL,
  PRIMARY KEY (`pic_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

/*Data for the table `m_organization_pic` */

insert  into `m_organization_pic`(`pic_id`,`organization_id`,`user_name`,`user_email`,`user_phone`,`avatar`) values 
(7,6,'Printerous Staff 1','printerousstaff1@gmail.com','021123123','BnoBJVVmUXVQd1dpAjsFN1RmCnRXOwNkVmJSe1g6DyZQJQJgVyBdIgR5C2lSbVVmAHgCJVBzADQHJgd4AXRTN1VgAWYEYwp/VWIAMQQ3XWUGZgE5VTRRNlAxVz0CfwVmVDcKMldiAyZWPVJlWHYPZVBnAihXJF0jBD8LblJ0VWQAJQI/UHUAIgd6B30BalM8'),
(8,6,'Printerous Staff 2','printerousstaff2@gmail.com','021123456','A39afldkVHANKlNtAzpRYwQ2B3kAbFM0VWFTegNhAClUIVIwAnVfIAV4AWNWaQAzVi5ZfgAjAzdScwJ9DXgEYFdiAmVTNFgtVGMCMwU2DjYDY1piVzZUNA1qUzEDflEyBGcHPwA1U3ZVPlNkAy0AalRjUngCcV8hBT4BZFZwADFWc1lkACUDIVIvAngNZgRr');

/*Table structure for table `m_user` */

DROP TABLE IF EXISTS `m_user`;

CREATE TABLE `m_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL COMMENT 'ADM = ADMIN, AM = ACCOUNT MANAGER, NA = NORMAL ACCOUNT',
  `assigned_organization` text DEFAULT NULL COMMENT 'organization id separated by comma',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

/*Data for the table `m_user` */

insert  into `m_user`(`id`,`email`,`nama`,`password`,`role`,`assigned_organization`) values 
(1,'printerousADM@gmail.com','Printerous Admin','VnRdJAE6BjwEJ1FmVXdVaw4oBXw=','ADM',NULL),
(14,'printerousNA@gmail.com','Printerous Normal Account','VnRdJAE6BjwEJ1FmVXdVaw4oBXw=','NA',NULL),
(15,'printerousAM@gmail.com','Printerous Account Manager','VnRYIVJpBz0ML1FmAiAOMFVzBn8=','AM','6');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
