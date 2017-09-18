CREATE TABLE `users_results` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(45) DEFAULT NULL,
  `date_create` timestamp NULL DEFAULT NULL,
  `scores` int(11) DEFAULT NULL,
  `time` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;


ALTER TABLE `electron`.`users_results` 
ADD COLUMN `level` INT(1) NULL AFTER `time`;