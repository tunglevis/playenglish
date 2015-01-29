CREATE TABLE `http_user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `black_ips` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Danh sách những IP không được truy cập, mỗi pattern (theo regex) trên 1 dòng. Ưu tiên cao hơn white list',
  `white_ips` text COLLATE utf8_unicode_ci NOT NULL COMMENT 'Danh sách những IP được truy cập, mỗi pattern (theo regex) trên 1 dòng.',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

INSERT  INTO `http_user`(`id`,`username`,`password`,`black_ips`,`white_ips`,`create_time`) VALUES (1,'test','test','9*','','2013-04-12 10:03:33');