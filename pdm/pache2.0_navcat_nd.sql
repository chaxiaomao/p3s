/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : pache_p3s2.0_dev

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2019-07-08 15:47:44
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for c2_fe_user
-- ----------------------------
DROP TABLE IF EXISTS `c2_fe_user`;
CREATE TABLE `c2_fe_user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '0',
  `attributeset_id` bigint(20) DEFAULT '0',
  `username` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `auth_key` varchar(255) DEFAULT NULL,
  `confirmed_at` datetime DEFAULT NULL,
  `unconfirmed_email` varchar(255) DEFAULT NULL,
  `blocked_at` datetime DEFAULT NULL,
  `registration_ip` varchar(255) DEFAULT NULL,
  `registration_src_type` tinyint(4) DEFAULT '100',
  `flags` int(11) DEFAULT NULL,
  `level` tinyint(4) DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `last_login_ip` varchar(255) DEFAULT NULL,
  `open_id` varchar(255) DEFAULT NULL,
  `wechat_union_id` char(10) DEFAULT NULL,
  `wechat_open_id` varchar(255) DEFAULT NULL,
  `mobile_number` varchar(255) DEFAULT NULL,
  `sms_receipt` varchar(255) DEFAULT NULL,
  `access_token` varchar(255) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `province_id` bigint(20) DEFAULT '0',
  `city_id` bigint(20) DEFAULT '0',
  `district_id` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT '0',
  `updated_by` bigint(20) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`username`(191)),
  KEY `Index_2` (`email`(191)),
  KEY `Index_3` (`type`),
  KEY `Index_4` (`open_id`(191)),
  KEY `Index_5` (`wechat_open_id`(191)),
  KEY `Index_6` (`access_token`(191),`status`),
  KEY `Index_7` (`mobile_number`(191)),
  KEY `Index_8` (`district_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_fe_user_auth
-- ----------------------------
DROP TABLE IF EXISTS `c2_fe_user_auth`;
CREATE TABLE `c2_fe_user_auth` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '0',
  `user_id` bigint(20) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `source_id` varchar(255) DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`source`(191)),
  KEY `Index_2` (`user_id`,`source_id`(191),`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_fe_user_profile
-- ----------------------------
DROP TABLE IF EXISTS `c2_fe_user_profile`;
CREATE TABLE `c2_fe_user_profile` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `wechat_number` varchar(255) DEFAULT NULL,
  `public_email` varchar(255) DEFAULT NULL,
  `gravatar_email` varchar(255) DEFAULT NULL,
  `gravatar_id` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `bio` text,
  `timezone` varchar(255) DEFAULT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `birthday` datetime DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `id_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `terms` tinyint(4) DEFAULT '0',
  `qr_code` varchar(255) DEFAULT NULL,
  `qr_code_image` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_inventory_delivery_note
-- ----------------------------
DROP TABLE IF EXISTS `c2_inventory_delivery_note`;
CREATE TABLE `c2_inventory_delivery_note` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT '0',
  `sales_order_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT '0',
  `occurrence_date` datetime DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `contact_man` varchar(255) DEFAULT NULL,
  `cs_name` varchar(255) DEFAULT NULL,
  `sender_name` varchar(255) DEFAULT NULL,
  `financial_name` varchar(255) DEFAULT NULL,
  `payment_method` varchar(255) DEFAULT NULL,
  `delivery_method` varchar(255) DEFAULT NULL,
  `memo` text,
  `remote_ip` varchar(255) DEFAULT NULL,
  `is_audited` tinyint(4) DEFAULT '0',
  `audited_by` bigint(20) DEFAULT '0',
  `updated_by` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`code`(191)),
  KEY `Index_2` (`warehouse_id`),
  KEY `Index_3` (`occurrence_date`),
  KEY `Index_4` (`customer_id`),
  KEY `Index_5` (`sales_order_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_inventory_delivery_note_item
-- ----------------------------
DROP TABLE IF EXISTS `c2_inventory_delivery_note_item`;
CREATE TABLE `c2_inventory_delivery_note_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `note_id` bigint(20) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `package_id` bigint(20) DEFAULT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `combination_id` bigint(20) DEFAULT NULL,
  `combination_name` varchar(255) DEFAULT NULL,
  `measure_id` bigint(20) DEFAULT NULL,
  `pieces` mediumint(9) DEFAULT '0',
  `product_sum` mediumint(9) DEFAULT '0',
  `volume` varchar(255) DEFAULT NULL,
  `weight` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT '0.00',
  `subtotal` decimal(10,2) DEFAULT '0.00',
  `memo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`note_id`),
  KEY `Index_2` (`product_id`),
  KEY `Index_3` (`package_id`),
  KEY `Index_4` (`combination_id`),
  KEY `Index_5` (`product_name`(191)),
  KEY `Index_6` (`product_sku`(191)),
  KEY `Index_7` (`combination_name`(191)),
  KEY `Index_8` (`created_at`),
  KEY `Index_9` (`package_name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_inventory_note_log
-- ----------------------------
DROP TABLE IF EXISTS `c2_inventory_note_log`;
CREATE TABLE `c2_inventory_note_log` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `note_id` bigint(20) DEFAULT '0',
  `type` tinyint(4) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT '0',
  `occurrence_date` datetime DEFAULT NULL,
  `memo` text,
  `updated_by` bigint(20) DEFAULT '0',
  `created_by` bigint(20) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`note_id`,`type`),
  KEY `Index_2` (`warehouse_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_inventory_receipt_note
-- ----------------------------
DROP TABLE IF EXISTS `c2_inventory_receipt_note`;
CREATE TABLE `c2_inventory_receipt_note` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT '0',
  `supplier_id` bigint(20) DEFAULT '0',
  `arrival_date` datetime DEFAULT NULL,
  `occurrence_date` datetime DEFAULT NULL,
  `arrival_number` varchar(255) DEFAULT NULL,
  `buyer_name` varchar(255) DEFAULT NULL,
  `dept_manager_name` varchar(255) DEFAULT NULL,
  `financial_name` varchar(255) DEFAULT NULL,
  `receiver_name` varchar(255) DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `memo` text,
  `remote_ip` varchar(255) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`code`(191)),
  KEY `Index_2` (`warehouse_id`),
  KEY `Index_3` (`occurrence_date`),
  KEY `Index_4` (`supplier_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_inventory_receipt_note_item
-- ----------------------------
DROP TABLE IF EXISTS `c2_inventory_receipt_note_item`;
CREATE TABLE `c2_inventory_receipt_note_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `note_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_label` varchar(255) DEFAULT NULL,
  `product_value` varchar(255) DEFAULT NULL,
  `measure_id` bigint(20) DEFAULT NULL,
  `pieces` mediumint(9) DEFAULT '0',
  `price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `purcharse_order_code` varchar(255) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`note_id`),
  KEY `Index_2` (`product_id`),
  KEY `Index_3` (`product_name`(191)),
  KEY `Index_4` (`product_sku`(191)),
  KEY `Index_5` (`product_label`(191)),
  KEY `Index_6` (`product_value`(191))
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_measure
-- ----------------------------
DROP TABLE IF EXISTS `c2_measure`;
CREATE TABLE `c2_measure` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text,
  `is_default` tinyint(4) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`code`(191)),
  KEY `Index_2` (`label`(191)),
  KEY `Index_3` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_order
-- ----------------------------
DROP TABLE IF EXISTS `c2_order`;
CREATE TABLE `c2_order` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `production_date` datetime DEFAULT NULL,
  `delivery_date` datetime DEFAULT NULL,
  `grand_total` decimal(10,2) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`customer_id`),
  KEY `Index_2` (`production_date`),
  KEY `Index_3` (`delivery_date`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_order_item
-- ----------------------------
DROP TABLE IF EXISTS `c2_order_item`;
CREATE TABLE `c2_order_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `customer_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_label` varchar(255) DEFAULT NULL,
  `product_value` varchar(255) DEFAULT NULL,
  `combination_id` bigint(20) DEFAULT NULL,
  `combination_name` varchar(255) DEFAULT NULL,
  `package_id` bigint(20) DEFAULT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `measure_id` bigint(20) DEFAULT NULL,
  `pieces` mediumint(9) DEFAULT NULL,
  `product_sum` mediumint(9) DEFAULT NULL,
  `produced_number` mediumint(9) NOT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `send_pieces` mediumint(9) NOT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`order_id`),
  KEY `Index_2` (`product_id`),
  KEY `Index_3` (`combination_id`),
  KEY `Index_4` (`package_id`),
  KEY `Index_5` (`product_name`(191)),
  KEY `Index_6` (`product_sku`(191)),
  KEY `Index_7` (`combination_name`(191)),
  KEY `Index_8` (`package_name`(191)),
  KEY `Index_9` (`created_at`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_order_item_consumption
-- ----------------------------
DROP TABLE IF EXISTS `c2_order_item_consumption`;
CREATE TABLE `c2_order_item_consumption` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint(20) DEFAULT NULL,
  `order_item_id` bigint(20) DEFAULT NULL,
  `sale_product_id` bigint(20) DEFAULT NULL,
  `sale_product_sum` mediumint(9) DEFAULT '0',
  `production_sum` mediumint(9) DEFAULT '0',
  `need_product_id` bigint(20) DEFAULT NULL,
  `need_product_sku` varchar(255) DEFAULT NULL,
  `need_product_name` varchar(255) DEFAULT NULL,
  `need_product_label` varchar(255) DEFAULT NULL,
  `need_product_value` varchar(255) DEFAULT NULL,
  `need_number` mediumint(9) DEFAULT '0',
  `need_sum` mediumint(9) DEFAULT '0',
  `memo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`order_id`),
  KEY `Index_2` (`order_item_id`),
  KEY `Index_3` (`need_product_id`),
  KEY `Index_4` (`sale_product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_product
-- ----------------------------
DROP TABLE IF EXISTS `c2_product`;
CREATE TABLE `c2_product` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '1',
  `seo_code` varchar(255) DEFAULT NULL,
  `sku` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  `low_price` decimal(10,2) DEFAULT '0.00',
  `sales_price` decimal(10,2) DEFAULT NULL,
  `cost_price` decimal(10,2) DEFAULT NULL,
  `market_price` decimal(10,2) DEFAULT NULL,
  `supplier_id` bigint(20) DEFAULT '0',
  `currency_id` bigint(20) DEFAULT '0',
  `measure_id` bigint(20) DEFAULT '0',
  `summary` text,
  `description` text,
  `sold_count` int(11) DEFAULT '0',
  `is_released` tinyint(4) DEFAULT '0',
  `released_at` datetime DEFAULT NULL,
  `created_by` bigint(20) DEFAULT '0',
  `updated_by` bigint(20) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '50',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`sku`(191)),
  KEY `Index_2` (`name`(191)),
  KEY `Index_3` (`label`(191))
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_product_combination
-- ----------------------------
DROP TABLE IF EXISTS `c2_product_combination`;
CREATE TABLE `c2_product_combination` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `memo` text,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_product_combination_item
-- ----------------------------
DROP TABLE IF EXISTS `c2_product_combination_item`;
CREATE TABLE `c2_product_combination_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `combination_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `need_number` mediumint(9) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`combination_id`),
  KEY `Index_2` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_product_package
-- ----------------------------
DROP TABLE IF EXISTS `c2_product_package`;
CREATE TABLE `c2_product_package` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `product_capacity` mediumint(9) DEFAULT '0',
  `gross_weight` varchar(255) DEFAULT NULL,
  `net_weight` varchar(255) DEFAULT NULL,
  `memo` text,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_product_package_item
-- ----------------------------
DROP TABLE IF EXISTS `c2_product_package_item`;
CREATE TABLE `c2_product_package_item` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT '0',
  `package_id` bigint(20) DEFAULT '0',
  `product_id` bigint(20) DEFAULT '0',
  `need_number` mediumint(9) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`package_id`),
  KEY `Index_2` (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_product_stock
-- ----------------------------
DROP TABLE IF EXISTS `c2_product_stock`;
CREATE TABLE `c2_product_stock` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `number` mediumint(9) DEFAULT '0',
  `state` tinyint(4) DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`product_id`),
  KEY `Index_2` (`warehouse_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_supplier
-- ----------------------------
DROP TABLE IF EXISTS `c2_supplier`;
CREATE TABLE `c2_supplier` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `province_id` bigint(20) DEFAULT NULL,
  `city_id` bigint(20) DEFAULT NULL,
  `district_id` bigint(20) DEFAULT NULL,
  `geo_longitude` varchar(255) DEFAULT NULL,
  `geo_latitude` varchar(255) DEFAULT NULL,
  `geo_marker_color` varchar(255) DEFAULT NULL,
  `description` text,
  `is_default` tinyint(4) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`code`(191)),
  KEY `Index_2` (`label`(191)),
  KEY `Index_3` (`name`(191))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_warehouse
-- ----------------------------
DROP TABLE IF EXISTS `c2_warehouse`;
CREATE TABLE `c2_warehouse` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `contact_name` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(255) DEFAULT NULL,
  `fax` varchar(255) DEFAULT NULL,
  `eshop_id` bigint(20) DEFAULT NULL,
  `entity_id` bigint(20) DEFAULT '0',
  `entity_class` varchar(255) DEFAULT '0',
  `country_id` int(11) DEFAULT NULL,
  `province_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `district_id` bigint(20) DEFAULT '0',
  `area_id` int(11) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `geo_longitude` varchar(255) DEFAULT NULL,
  `geo_latitude` varchar(255) DEFAULT NULL,
  `geo_marker_color` varchar(255) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`eshop_id`),
  KEY `Index_2` (`entity_id`),
  KEY `Index_3` (`province_id`,`country_id`,`city_id`,`area_id`),
  KEY `Index_4` (`geo_longitude`(191),`geo_latitude`(191))
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_warehouse_commit_delivery_item
-- ----------------------------
DROP TABLE IF EXISTS `c2_warehouse_commit_delivery_item`;
CREATE TABLE `c2_warehouse_commit_delivery_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '1',
  `label` varchar(255) DEFAULT NULL,
  `commit_id` bigint(20) DEFAULT NULL,
  `note_id` bigint(20) DEFAULT NULL,
  `package_id` bigint(20) DEFAULT NULL,
  `package_name` varchar(255) DEFAULT NULL,
  `combination_id` bigint(20) DEFAULT NULL,
  `combination_name` varchar(255) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_label` varchar(255) DEFAULT NULL,
  `product_value` varchar(255) DEFAULT NULL,
  `measure_id` bigint(20) DEFAULT NULL,
  `pieces` mediumint(9) DEFAULT NULL,
  `product_sum` mediumint(9) DEFAULT NULL,
  `produce_number` mediumint(9) DEFAULT '0',
  `stock_number` mediumint(9) DEFAULT '0',
  `memo` varchar(255) DEFAULT NULL,
  `state` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`commit_id`),
  KEY `Index_2` (`note_id`,`product_id`),
  KEY `Index_3` (`package_id`),
  KEY `Index_4` (`combination_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_warehouse_commit_note
-- ----------------------------
DROP TABLE IF EXISTS `c2_warehouse_commit_note`;
CREATE TABLE `c2_warehouse_commit_note` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '1',
  `note_id` bigint(20) DEFAULT NULL,
  `note_code` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `receiver_name` varchar(255) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `memo` text,
  `state` tinyint(4) DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_2` (`created_at`),
  KEY `Index_1` (`note_code`(191)) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Table structure for c2_warehouse_commit_receipt_item
-- ----------------------------
DROP TABLE IF EXISTS `c2_warehouse_commit_receipt_item`;
CREATE TABLE `c2_warehouse_commit_receipt_item` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '1',
  `label` varchar(255) DEFAULT NULL,
  `commit_id` bigint(20) DEFAULT NULL,
  `note_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `number` mediumint(9) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `state` tinyint(4) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `Index_1` (`commit_id`),
  KEY `Index_2` (`note_id`,`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4;
