CREATE TABLE `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(100) NOT NULL DEFAULT '',
  `pwd` char(64) NOT NULL DEFAULT '',
  `uuid` char(36) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL DEFAULT '1',
  `created` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `blacklist` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `token_id` char(64) NOT NULL DEFAULT '',
  `type` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `created` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `tokin_id` (`token_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;