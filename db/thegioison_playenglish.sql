/*
SQLyog Community v11.31 (64 bit)
MySQL - 5.6.20 : Database - thegioison_playenglish
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`thegioison_playenglish` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `thegioison_playenglish`;

/*Table structure for table `comment_daily` */

DROP TABLE IF EXISTS `comment_daily`;

CREATE TABLE `comment_daily` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_daily` int(11) NOT NULL COMMENT 'id of daily where commented',
  `parent_id` int(11) DEFAULT '0' COMMENT 'comment parent',
  `content` varchar(1000) NOT NULL COMMENT 'content of comment',
  `status` enum('enable','disable') DEFAULT 'enable' COMMENT 'status of comment',
  `id_send` int(11) NOT NULL COMMENT 'id of user write comment',
  `created` int(11) DEFAULT NULL COMMENT 'time to creat comment',
  `name_send` varchar(255) NOT NULL COMMENT 'name of user write comment',
  `image` varchar(255) DEFAULT NULL COMMENT 'image of comment daily',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `comment_daily` */

/*Table structure for table `comment_message` */

DROP TABLE IF EXISTS `comment_message`;

CREATE TABLE `comment_message` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_send` int(11) NOT NULL COMMENT 'id of user comment',
  `name_send` varchar(255) NOT NULL COMMENT 'name of user comment',
  `content` varchar(255) NOT NULL COMMENT 'content of comment',
  `created` int(11) DEFAULT NULL COMMENT 'time created comment',
  `id_message` int(11) NOT NULL COMMENT 'id of message wall',
  `parent_id` int(11) DEFAULT '0' COMMENT 'id of parrent comment message',
  `status` enum('enable','disable') DEFAULT 'enable' COMMENT 'status of comment message',
  `image` varchar(255) DEFAULT NULL COMMENT 'image of comment message',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `comment_message` */

/*Table structure for table `course` */

DROP TABLE IF EXISTS `course`;

CREATE TABLE `course` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL COMMENT 'name of course',
  `time_start` int(11) DEFAULT NULL COMMENT 'time start course',
  `time_end` int(11) NOT NULL COMMENT 'time end course',
  `content` text COMMENT 'content of course',
  `status` enum('enable','disable') DEFAULT 'enable' COMMENT 'status of course',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `course` */

/*Table structure for table `course_user` */

DROP TABLE IF EXISTS `course_user`;

CREATE TABLE `course_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `course_user` */

/*Table structure for table `daily_english` */

DROP TABLE IF EXISTS `daily_english`;

CREATE TABLE `daily_english` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `feed` varchar(1000) NOT NULL COMMENT 'content of daily english',
  `user_read` varchar(1000) DEFAULT NULL COMMENT 'id of user who read feed',
  `status` enum('enable','disable') DEFAULT 'enable' COMMENT 'status of daily english',
  `id_send` int(11) NOT NULL COMMENT 'id of user who write feed',
  `course_id` int(11) NOT NULL COMMENT 'id of course',
  `image` varchar(255) DEFAULT NULL COMMENT 'image of feed',
  `name_send` varchar(255) NOT NULL COMMENT 'name of user who write',
  `created` int(11) DEFAULT NULL COMMENT 'time create feed',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

/*Data for the table `daily_english` */

/*Table structure for table `document` */

DROP TABLE IF EXISTS `document`;

CREATE TABLE `document` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` int(11) NOT NULL COMMENT 'id of course',
  `desc` varchar(1000) NOT NULL COMMENT 'descreption of document',
  `link` varchar(255) DEFAULT NULL COMMENT 'link of document',
  `title` varchar(255) NOT NULL COMMENT 'name of doucment',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `document` */

/*Table structure for table `homework` */

DROP TABLE IF EXISTS `homework`;

CREATE TABLE `homework` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL COMMENT 'name of homework',
  `desc` varchar(1000) DEFAULT NULL COMMENT 'descreption of homework',
  `link` varchar(255) NOT NULL COMMENT 'link of homework',
  `id_user` int(11) NOT NULL COMMENT 'id of user who do homework',
  `name_user` varchar(255) NOT NULL COMMENT 'name of user who do homework',
  `created` int(11) DEFAULT NULL COMMENT 'time created up homework',
  `id_course` int(11) NOT NULL COMMENT 'id of course which user join',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

/*Data for the table `homework` */

/*Table structure for table `lession` */

DROP TABLE IF EXISTS `lession`;

CREATE TABLE `lession` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `id_course` int(11) NOT NULL,
  `time_start` int(11) NOT NULL,
  `time_end` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `lession` */

/*Table structure for table `manager` */

DROP TABLE IF EXISTS `manager`;

CREATE TABLE `manager` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('ADMIN','MANAGER','STAFF','DISABLE') COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `yahoo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `skype` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `reset_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UK__email_shop_id` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

/*Data for the table `manager` */

/*Table structure for table `message_wall` */

DROP TABLE IF EXISTS `message_wall`;

CREATE TABLE `message_wall` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `content` varchar(1000) NOT NULL COMMENT 'content of message',
  `id_send` int(11) NOT NULL COMMENT 'id of user who send message',
  `id_receive` int(11) DEFAULT NULL COMMENT 'id of user who receive message',
  `is_read` tinyint(1) DEFAULT '0' COMMENT 'status read',
  `status` enum('enable','disable') DEFAULT 'enable' COMMENT 'status of message',
  `created` int(11) NOT NULL COMMENT 'time created',
  `name_send` varchar(255) NOT NULL COMMENT 'name of user who send message',
  `image` varchar(255) DEFAULT NULL COMMENT 'image of message',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

/*Data for the table `message_wall` */

/*Table structure for table `notify` */

DROP TABLE IF EXISTS `notify`;

CREATE TABLE `notify` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_course` int(11) NOT NULL,
  `time_start` int(11) NOT NULL,
  `desc` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

/*Data for the table `notify` */

/*Table structure for table `user` */

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `password` varchar(255) DEFAULT NULL,
  `name` varchar(160) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `gender` enum('MALE','FEMALE') DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created` int(11) NOT NULL,
  `address` varchar(50) DEFAULT NULL,
  `city_id` int(10) unsigned DEFAULT NULL,
  `district_id` int(10) unsigned DEFAULT NULL,
  `status` enum('ENABLE','DISABLE') NOT NULL DEFAULT 'ENABLE',
  `reset_time` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;

/*Data for the table `user` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
