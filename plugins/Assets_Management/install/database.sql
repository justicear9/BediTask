CREATE TABLE IF NOT EXISTS `asset_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ; --#

CREATE TABLE IF NOT EXISTS `asset_units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ; --#

CREATE TABLE IF NOT EXISTS `asset_locations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ; --#

CREATE TABLE IF NOT EXISTS `assets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_code` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `asset_name` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` INT(11) NOT NULL,
  `amount` double NOT NULL,
  `unit_id` int(11) NOT NULL,
  `group_id` int(11) NULL,
  `location_id` INT(11) NULL,
  `series` VARCHAR(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL,
  `purchase_date` date NOT NULL,
  `warranty_period` int(11) NOT NULL,
  `unit_price` double NOT NULL,
  `depreciation` int(11) NOT NULL,
  `supplier_name` varchar(150) COLLATE utf8_unicode_ci,
  `supplier_address` mediumtext COLLATE utf8_unicode_ci,
  `supplier_phone` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `files` text COLLATE utf8_unicode_ci NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1',
  `total_allocation` int(11) NOT NULL DEFAULT '0',
  `total_lost` int(11) NOT NULL DEFAULT '0',
  `total_liquidation` int(11) NOT NULL DEFAULT '0',
  `total_damages` int(11) NOT NULL DEFAULT '0',
  `total_warranty` int(11) NOT NULL DEFAULT '0',
  `added_by` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1; --#

CREATE TABLE IF NOT EXISTS `asset_actions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_code` VARCHAR(200) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `asset_id` text COLLATE utf8_unicode_ci NOT NULL,
  `quantity` INT(11) NOT NULL,
  `cost` double NULL,
  `action_type` varchar(20) NOT NULL,
  `asset_location` varchar(150) NULL,
  `action_location` varchar(150) NULL,
  `receiver_id` int(11) NOT NULL,
  `provider_id` int(11) NOT NULL,
  `opening_stock` INT(11) NOT NULL,
  `closing_stock` INT(11) NOT NULL,
  `description` mediumtext COLLATE utf8_unicode_ci,
  `added_by` int(11) NOT NULL,
  `action_time` datetime NOT NULL,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1; --#