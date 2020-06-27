ALTER TABLE `members` CHANGE `modified` `modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

RENAME TABLE `bnindia`.`members` TO `bnindia`.`users`;

ALTER TABLE `users` CHANGE `password` `password` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;
