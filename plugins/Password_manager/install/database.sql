CREATE TABLE IF NOT EXISTS `password_manager_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ; --#

CREATE TABLE IF NOT EXISTS `password_manager_general`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) NULL,
    `category_id` int(11) NOT NULL,
    `url` VARCHAR(300) NULL,
    `username` VARCHAR(80) NULL,
    `description` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `password` VARCHAR(1000) NULL,
    `client_id` INT(11) NOT NULL,
    `share_with` mediumtext COLLATE utf8_unicode_ci,
    `share_with_client` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
    `created_by` INT(11) NOT NULL,
    `created_by_client` TINYINT NOT NULL DEFAULT '0',
    `created_at` DATETIME NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT '0',
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1; --#

CREATE TABLE IF NOT EXISTS `password_manager_email`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) DEFAULT NULL,
    `category_id` INT(11) NOT NULL,
    `username` VARCHAR(80) NULL,
    `description` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `password` VARCHAR(1000) NULL,
    `client_id` INT(11) NOT NULL,
    `email_type` VARCHAR(150) DEFAULT NULL,
    `auth_method` VARCHAR(150) DEFAULT NULL,
    `host` VARCHAR(150) DEFAULT NULL,
    `port` VARCHAR(10) DEFAULT NULL,
    `smtp_auth_method` VARCHAR(150) DEFAULT NULL,
    `smtp_host` VARCHAR(150) DEFAULT NULL,
    `smtp_port` VARCHAR(150) DEFAULT NULL,
    `smtp_user_name` VARCHAR(150) DEFAULT NULL,
    `smtp_password` VARCHAR(1500) DEFAULT NULL,
    `share_with` MEDIUMTEXT COLLATE utf8_unicode_ci,
    `share_with_client` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
    `created_by` INT(11) NOT NULL,
    `created_by_client` TINYINT NOT NULL DEFAULT '0',
    `created_at` DATETIME NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT '0',
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1; --#

CREATE TABLE IF NOT EXISTS `password_manager_credit_card`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) DEFAULT NULL,
    `category_id` INT(11) NOT NULL,
    `pin` VARCHAR(500) DEFAULT NULL,
    `credit_card_type` VARCHAR(150) DEFAULT NULL,
    `card_number` VARCHAR(150) DEFAULT NULL,
    `card_cvc` VARCHAR(150) DEFAULT NULL,
    `valid_from` DATE NOT NULL,
    `valid_to` DATE NOT NULL,
    `username` VARCHAR(80) DEFAULT NULL,
    `description` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `client_id` INT(11) NOT NULL,
    `share_with` MEDIUMTEXT COLLATE utf8_unicode_ci,
    `share_with_client` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
    `created_by` INT(11) NOT NULL,
    `created_by_client` TINYINT NOT NULL DEFAULT '0',
    `created_at` DATETIME NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT '0',
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1; --#

CREATE TABLE IF NOT EXISTS `password_manager_bank_account`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) DEFAULT NULL,
    `category_id` INT(11) NOT NULL,
    `url` VARCHAR(300) DEFAULT NULL,
    `username` VARCHAR(80) DEFAULT NULL,
    `pin` VARCHAR(500) DEFAULT NULL,
    `bank_name` VARCHAR(200) DEFAULT NULL,
    `bank_code` VARCHAR(200) DEFAULT NULL,
    `account_holder` VARCHAR(200) DEFAULT NULL,
    `account_number` VARCHAR(200) DEFAULT NULL,
    `iban` VARCHAR(200) DEFAULT NULL,
    `description` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `client_id` INT(11) NOT NULL,
    `share_with` MEDIUMTEXT COLLATE utf8_unicode_ci,
    `share_with_client` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
    `created_by` INT(11) NOT NULL,
    `created_by_client` TINYINT NOT NULL DEFAULT '0',
    `created_at` DATETIME NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT '0',
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1; --#

CREATE TABLE IF NOT EXISTS `password_manager_software_license`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(150) DEFAULT NULL,
    `category_id` INT(11) NOT NULL,
    `version` VARCHAR(150) DEFAULT NULL,
    `url` VARCHAR(150) DEFAULT NULL,
    `license_key` VARCHAR(1500) DEFAULT NULL,
    `description` TEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
    `client_id` INT(11) NOT NULL,
    `share_with` MEDIUMTEXT COLLATE utf8_unicode_ci,
    `share_with_client` MEDIUMTEXT CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL,
    `created_by` INT(11) NOT NULL,
    `created_by_client` TINYINT NOT NULL DEFAULT '0',
    `created_at` DATETIME NOT NULL,
    `deleted` TINYINT(1) NOT NULL DEFAULT '0',
    PRIMARY KEY(`id`)
) ENGINE = INNODB DEFAULT CHARSET = utf8 COLLATE = utf8_unicode_ci AUTO_INCREMENT = 1; --#
