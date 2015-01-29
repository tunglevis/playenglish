CREATE TABLE `http_api_log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `http_username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `request_method` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `request_url` text COLLATE utf8_unicode_ci NOT NULL,
  `response_code` int(11) NOT NULL DEFAULT '200',
  `src_ip` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `dst_ip` tinytext COLLATE utf8_unicode_ci,
  `request_headers` text COLLATE utf8_unicode_ci NOT NULL,
  `response_headers` text COLLATE utf8_unicode_ci,
  `request_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `duration` float NOT NULL COMMENT 'in second',
  `post_data` text COLLATE utf8_unicode_ci,
  `response_data` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  KEY `http_api_log_ibfk_1` (`http_username`),
  CONSTRAINT `http_api_log_ibfk_1` FOREIGN KEY (`http_username`) REFERENCES `http_user` (`username`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=105 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;