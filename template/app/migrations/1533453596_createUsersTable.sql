DROP TABLE IF EXISTS users;
CREATE TABLE `users` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(200) DEFAULT '',
  `last_name` varchar(200) DEFAULT '',
  `email` varchar(200) DEFAULT '',
  `password` varchar(255) DEFAULT '',
  `entered_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  KEY `first_name_idx` (`first_name`),
  KEY `last_name_idx` (`last_name`),
  KEY `email_idx` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=UTF8MB4;