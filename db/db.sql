DROP TABLE IF EXISTS `guitars`;
CREATE TABLE IF NOT EXISTS `guitars` (
  `id` INT (11) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR (100) NOT NULL,
  `price` DECIMAL (12,2) NOT NULL,
  `qty` INT (11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
-- Records of tasks
-- ----------------------------
INSERT INTO `guitars` (`id`, `name`, `price`, `qty`) VALUES (1, 'Taylor Baby', 349.00, 3);
INSERT INTO `guitars` (`id`, `name`, `price`, `qty`) VALUES (2, 'Yamaha F310', 115.00, 5);
INSERT INTO `guitars` (`id`, `name`, `price`, `qty`) VALUES (3, 'Martin D10E', 899.00, 2);
INSERT INTO `guitars` (`id`, `name`, `price`, `qty`) VALUES (4, 'Fender FA-125', 99.00, 4);
INSERT INTO `guitars` (`id`, `name`, `price`, `qty`) VALUES (5, 'Epiphone EJ-200SCE', 329.00, 5);