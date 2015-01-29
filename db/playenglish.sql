/*
SQLyog Community v11.31 (64 bit)
MySQL - 5.6.20 : Database - playenglish
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`playenglish` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `playenglish`;

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

insert  into `comment_daily`(`id`,`id_daily`,`parent_id`,`content`,`status`,`id_send`,`created`,`name_send`,`image`) values (1,1,0,'Ý kiến của bạn hay lắm','enable',22,1418629119,'Tung le Van',NULL),(2,1,0,'hello bạn, chúc bạn ngày mơi vui vẻ','enable',22,1418634048,'Tung le Van',NULL),(3,2,0,'Chào mừng bạn đến gia đinh Play English','enable',22,1418634916,'Tung le Van',NULL),(4,2,0,'Giờ thì sao','enable',22,1418635075,'Tung le Van',NULL),(5,2,0,'alo','enable',22,1418635087,'Tung le Van',NULL),(6,2,0,'a','enable',22,1418635134,'Tung le Van',NULL),(7,2,0,'a','enable',22,1418635215,'Tung le Van',NULL),(8,2,0,'b','enable',22,1418635230,'Tung le Van',NULL),(9,2,0,'a','enable',22,1418635609,'Tung le Van',NULL),(10,2,0,'đôi khi lòng muốn yêu em thật nhiều','enable',22,1418635753,'Tung le Van',NULL),(11,2,0,'cho ngày sau thôi bần tiện','enable',22,1418635961,'Tung le Van',NULL),(12,2,0,'chán vồn','enable',22,1418636007,'Tung le Van',NULL),(13,2,0,'1','enable',22,1418636053,'Tung le Van',NULL),(14,2,0,'a','enable',22,1418636244,'Tung le Van',NULL),(15,1,0,'Chào bạn, chúc bạn có một khóa học bổ ích','enable',22,1418637336,'Tung le Van',NULL),(16,1,0,'Rất vui được gặp bạn','enable',22,1418637456,'Tung le Van','comment-250'),(17,3,0,'chao em, dep trai vcl','enable',22,1418704890,'Tung le Van',NULL),(18,1,0,'Thu đi qua m&ugrave;a đ&ocirc;ng cho ta','enable',22,1418785223,'Tung le Van',NULL),(19,1,0,'D&ugrave; sao đi nữa anh vẫn y&ecirc;u em','enable',22,1418804538,'Tung le Van',NULL),(20,3,0,'vcl đẹp trai k&igrave;a','enable',22,1418807588,'Tung le Van',NULL);

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

insert  into `comment_message`(`id`,`id_send`,`name_send`,`content`,`created`,`id_message`,`parent_id`,`status`,`image`) values (1,22,'Tung le Van','c&oacute; vẻ hot',1418805175,1,0,'enable','comment-250'),(2,22,'Tung le Van','v&atilde;i xo&agrave;i hay thế',1418805437,2,0,'enable',NULL);

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

insert  into `course`(`id`,`name`,`time_start`,`time_end`,`content`,`status`) values (1,'pronunciation',NULL,1418439722,'<p><span>Everyone knows that&nbsp;</span><span>using</span><span>&nbsp;English is the only way to really improve your pronunciation. But what if you can\'t practice with a native speaker every day? Don\'t worry! There are plenty of ways to stretch your vocal chords.</span></p>','enable'),(2,'Grammar',NULL,1419044156,'<p>Ngữ ph&aacute;p pro l&agrave; vũ kh&iacute; v&ocirc; c&ugrave;ng lợi hại</p>','enable');

/*Table structure for table `course_user` */

DROP TABLE IF EXISTS `course_user`;

CREATE TABLE `course_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `course_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

/*Data for the table `course_user` */

insert  into `course_user`(`id`,`user_id`,`course_id`) values (1,22,1),(2,18,2);

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

insert  into `daily_english`(`id`,`feed`,`user_read`,`status`,`id_send`,`course_id`,`image`,`name_send`,`created`) values (1,'Hello mọi người. Tôi là học viên mới của khóa học mong mọi người giúp đỡ nhiều','22','enable',22,1,NULL,'Tung le Van',NULL),(2,'Hello mọi người. Tôi là thành viên mới của gia đình ta, chúc mọi người tuần mới vui vẻ','22','enable',22,1,'feed-text','Tung le Van',NULL),(3,'Chao ca nha hu hu chuc tuan moi vui ve','22','enable',22,1,NULL,'Tung le Van',NULL),(4,'Khoai lắm','22','enable',22,2,NULL,'Tung le Van',1419045729);

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

insert  into `document`(`id`,`course_id`,`desc`,`link`,`title`) values (1,1,'Pronunciation is very important','f1-b.jpg','Pronunciation'),(2,1,'Document is very good','f2b.jpg','Pronunciation lession 2');

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

insert  into `homework`(`id`,`name`,`desc`,`link`,`id_user`,`name_user`,`created`,`id_course`) values (4,NULL,NULL,'Tuan 1 - Phat am - Le Van Tung .jpg',22,'Tung le Van',1418703976,1),(5,NULL,NULL,'Tuan 2 - Phat am - Le Van Tung .jpg',22,'Tung le Van',1418704415,1),(6,NULL,NULL,'Tuan 3 - Phat am - Le Van Tung.jpg',22,'Tung le Van',1418704548,1);

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

insert  into `lession`(`id`,`name`,`content`,`id_course`,`time_start`,`time_end`) values (1,'Lession 1','Luyện phát âm',1,1418201500,1418806000),(2,'Lession 2','Thực hành phát âm',1,1418806371,1419411000),(3,'Lession 3','Ngữ pháp chính quy',1,1419411206,1420016050);

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

insert  into `manager`(`id`,`email`,`password`,`status`,`name`,`phone`,`yahoo`,`skype`,`reset_time`) values (4,'manhhaiphp@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','ADMIN','Mạnh Hải','0989030623','','','2013-03-06 17:59:24'),(23,'test@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','STAFF','','','','',NULL),(24,'anhthikhong86@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Ánh','','','',NULL),(25,'hunght@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Hùng','','','',NULL),(26,'p2045i@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Phi','','','',NULL),(28,'tunglv.1990@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Tùng',NULL,NULL,NULL,NULL),(29,'phuonggs88@gmail.com','$P$BYdbbEdiHV/ByrvhWUPO6FS9RjKK8z0','MANAGER','Phương',NULL,NULL,NULL,NULL),(30,'tunglv_90@yahoo.com.vn','$P$B0kmANx11Qi2A.kuIaG/X8HxUztdVo0','STAFF','','','','',NULL);

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

insert  into `message_wall`(`id`,`content`,`id_send`,`id_receive`,`is_read`,`status`,`created`,`name_send`,`image`) values (1,'Hello anh ch&agrave;ng đẹp trai',22,NULL,0,'enable',1418803364,'Tung le Van',NULL),(2,'Dù cho em đưa tôi đi đến cuối cuộc đời',22,NULL,0,'enable',1418805392,'Tung le Van','feed-text'),(3,'Đong đếm chi một b&agrave;n tay b&eacute;',18,NULL,0,'enable',1419046507,'Tùng Lê',NULL);

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

insert  into `notify`(`id`,`id_course`,`time_start`,`desc`) values (1,1,1418806371,'Tuần này, do bạn Nguyễn Thị Nguyệt đi ăn cưới, nên lớp ta nghỉ nhé, tuần sau sẽ có lịch học bù sau. Mọi người thông cảm nhé');

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

insert  into `user`(`id`,`password`,`name`,`dob`,`gender`,`website`,`image`,`created`,`address`,`city_id`,`district_id`,`status`,`reset_time`,`email`,`user_name`) values (18,'$P$Bm2d5a66KbFeHFuUA/6f8Y6m4G7Mzh/','Tùng Lê',NULL,'MALE','https://plus.google.com/116258319838432439745',NULL,2147483647,NULL,NULL,NULL,'ENABLE',NULL,NULL,'tunglv_1990'),(19,NULL,'Tuế Nguyễn',NULL,'MALE','https://plus.google.com/106311101514641936814',NULL,2147483647,NULL,NULL,NULL,'ENABLE',NULL,NULL,''),(20,NULL,'Bùi Đàn',NULL,'MALE','https://plus.google.com/117909326743988996736',NULL,2147483647,NULL,NULL,NULL,'ENABLE',NULL,NULL,''),(21,NULL,'Tung le Van','1990-02-07','MALE','https://www.facebook.com/tung.levan1','http://graph.facebook.com/100001655274181/picture?type=large',2147483647,NULL,NULL,NULL,'ENABLE',NULL,NULL,''),(22,'$P$Bm2d5a66KbFeHFuUA/6f8Y6m4G7Mzh/','Tung le Van','1990-02-07','MALE','https://www.facebook.com/tung.levan1','avatar',2147483647,'Nam Định',NULL,NULL,'ENABLE',1418117733,NULL,'tunglv_90');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
