-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- 主机： 127.0.0.1
-- 生成日期： 2019-07-24 18:00:14
-- 服务器版本： 10.1.36-MariaDB
-- PHP 版本： 7.2.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `pache_p3s_dev`
--

-- --------------------------------------------------------

--
-- 表的结构 `c2_fe_user`
--

CREATE TABLE `c2_fe_user` (
  `id` bigint(20) NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_fe_user`
--

INSERT INTO `c2_fe_user` (`id`, `type`, `attributeset_id`, `username`, `email`, `password_hash`, `auth_key`, `confirmed_at`, `unconfirmed_email`, `blocked_at`, `registration_ip`, `registration_src_type`, `flags`, `level`, `last_login_at`, `last_login_ip`, `open_id`, `wechat_union_id`, `wechat_open_id`, `mobile_number`, `sms_receipt`, `access_token`, `password_reset_token`, `province_id`, `city_id`, `district_id`, `created_by`, `updated_by`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 2, 0, '义务呀杰', '', NULL, NULL, NULL, NULL, NULL, NULL, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, 0, 0, NULL, 0, 0, 1, 0, '2019-07-19 19:14:54', '2019-07-19 19:14:54');

-- --------------------------------------------------------

--
-- 表的结构 `c2_fe_user_auth`
--

CREATE TABLE `c2_fe_user_auth` (
  `id` bigint(20) NOT NULL,
  `type` tinyint(4) DEFAULT '0',
  `user_id` bigint(20) DEFAULT NULL,
  `source` varchar(255) DEFAULT NULL,
  `source_id` varchar(255) DEFAULT NULL,
  `expired_at` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `c2_fe_user_profile`
--

CREATE TABLE `c2_fe_user_profile` (
  `id` bigint(20) NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `c2_inventory_delivery_note`
--

CREATE TABLE `c2_inventory_delivery_note` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_inventory_delivery_note`
--

INSERT INTO `c2_inventory_delivery_note` (`id`, `type`, `code`, `label`, `warehouse_id`, `sales_order_id`, `customer_id`, `occurrence_date`, `grand_total`, `contact_man`, `cs_name`, `sender_name`, `financial_name`, `payment_method`, `delivery_method`, `memo`, `remote_ip`, `is_audited`, `audited_by`, `updated_by`, `created_by`, `state`, `status`, `position`, `updated_at`, `created_at`) VALUES
(1, 1, 'DN201907190', '', 2, 1, 1, NULL, '0.00', '', '', '', '', '', '', '', NULL, 0, 0, 1, 1, 3, 1, 0, '2019-07-19 23:53:55', '2019-07-19 23:53:44');

-- --------------------------------------------------------

--
-- 表的结构 `c2_inventory_delivery_note_item`
--

CREATE TABLE `c2_inventory_delivery_note_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_inventory_delivery_note_item`
--

INSERT INTO `c2_inventory_delivery_note_item` (`id`, `note_id`, `customer_id`, `product_id`, `product_name`, `product_sku`, `package_id`, `package_name`, `combination_id`, `combination_name`, `measure_id`, `pieces`, `product_sum`, `volume`, `weight`, `price`, `subtotal`, `memo`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 8, '电动牙刷', 'SS1', 1, '100装', 2, '黄色', 2, 10, 1000, NULL, NULL, '2.00', '2000.00', '', 1, 0, '2019-07-19 23:53:55', '2019-07-19 23:53:55');

-- --------------------------------------------------------

--
-- 表的结构 `c2_inventory_note_log`
--

CREATE TABLE `c2_inventory_note_log` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `c2_inventory_receipt_note`
--

CREATE TABLE `c2_inventory_receipt_note` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_inventory_receipt_note`
--

INSERT INTO `c2_inventory_receipt_note` (`id`, `type`, `code`, `label`, `warehouse_id`, `supplier_id`, `arrival_date`, `occurrence_date`, `arrival_number`, `buyer_name`, `dept_manager_name`, `financial_name`, `receiver_name`, `grand_total`, `memo`, `remote_ip`, `updated_by`, `created_by`, `state`, `status`, `position`, `updated_at`, `created_at`) VALUES
(1, 1, 'RN201907190', '', 2, 1, NULL, NULL, '', '', '', '', '', '0.00', '', NULL, 1, 1, 4, 1, 0, '2019-07-19 23:40:54', '2019-07-19 23:27:10'),
(2, 1, 'RN201907190', '', 2, 1, NULL, NULL, '', '', '', '', '', '50.00', '', NULL, 1, 1, 2, 1, 0, '2019-07-19 23:41:00', '2019-07-19 23:37:03');

-- --------------------------------------------------------

--
-- 表的结构 `c2_inventory_receipt_note_item`
--

CREATE TABLE `c2_inventory_receipt_note_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `note_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `product_name` varchar(255) DEFAULT NULL,
  `product_sku` varchar(255) DEFAULT NULL,
  `product_label` varchar(255) DEFAULT NULL,
  `product_value` varchar(255) DEFAULT NULL,
  `measure_id` bigint(20) DEFAULT NULL,
  `number` mediumint(9) DEFAULT '0',
  `price` decimal(10,2) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `purcharse_order_code` varchar(255) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_inventory_receipt_note_item`
--

INSERT INTO `c2_inventory_receipt_note_item` (`id`, `note_id`, `product_id`, `product_name`, `product_sku`, `product_label`, `product_value`, `measure_id`, `number`, `price`, `subtotal`, `purcharse_order_code`, `memo`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 2, 6, '白色瓶', 'pz-1', '白色瓶', '', 2, 1000, '0.05', '50.00', 'RN201907190', '', 1, 0, '2019-07-19 23:37:03', '2019-07-19 23:37:03');

-- --------------------------------------------------------

--
-- 表的结构 `c2_measure`
--

CREATE TABLE `c2_measure` (
  `id` bigint(20) NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text,
  `is_default` tinyint(4) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_measure`
--

INSERT INTO `c2_measure` (`id`, `code`, `name`, `label`, `description`, `is_default`, `status`, `position`, `created_at`, `updated_at`) VALUES
(2, 'Piece', '件', '件', '', 0, 1, 0, '2019-07-18 08:58:29', '2019-07-18 08:58:29');

-- --------------------------------------------------------

--
-- 表的结构 `c2_order`
--

CREATE TABLE `c2_order` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_order`
--

INSERT INTO `c2_order` (`id`, `code`, `label`, `customer_id`, `production_date`, `delivery_date`, `grand_total`, `created_by`, `updated_by`, `memo`, `state`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, '201907190', '', 1, NULL, NULL, '200.00', 1, 1, '', 1, 1, 0, '2019-07-19 19:15:03', '2019-07-24 23:50:18');

-- --------------------------------------------------------

--
-- 表的结构 `c2_order_item`
--

CREATE TABLE `c2_order_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_order_item`
--

INSERT INTO `c2_order_item` (`id`, `order_id`, `label`, `customer_id`, `product_id`, `product_name`, `product_sku`, `product_label`, `product_value`, `combination_id`, `combination_name`, `package_id`, `package_name`, `measure_id`, `pieces`, `product_sum`, `produced_number`, `price`, `send_pieces`, `subtotal`, `memo`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, '', 1, 8, '电动牙刷', 'SS1', NULL, NULL, 2, '黄色', 1, '100装', 2, 1, 200, 2000, '2.00', 20, '200.00', '', 2, 0, '2019-07-19 19:15:03', '2019-07-19 19:15:03');

-- --------------------------------------------------------

--
-- 表的结构 `c2_order_item_consumption`
--

CREATE TABLE `c2_order_item_consumption` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `c2_product`
--

CREATE TABLE `c2_product` (
  `id` bigint(20) NOT NULL,
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
  `warehouse_id` bigint(20) NOT NULL,
  `summary` text,
  `description` text,
  `sold_count` int(11) DEFAULT '0',
  `stock` float NOT NULL DEFAULT '0',
  `is_released` tinyint(4) DEFAULT '0',
  `released_at` datetime DEFAULT NULL,
  `created_by` bigint(20) DEFAULT '0',
  `updated_by` bigint(20) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '50',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_product`
--

INSERT INTO `c2_product` (`id`, `type`, `seo_code`, `sku`, `name`, `label`, `value`, `low_price`, `sales_price`, `cost_price`, `market_price`, `supplier_id`, `currency_id`, `measure_id`, `warehouse_id`, `summary`, `description`, `sold_count`, `stock`, `is_released`, `released_at`, `created_by`, `updated_by`, `status`, `position`, `created_at`, `updated_at`) VALUES
(6, 1, NULL, 'pz-1', '白色瓶', '白色瓶', '', '2.00', NULL, NULL, NULL, 0, 0, 2, 0, NULL, '', 0, 66666700, 0, NULL, 1, 1, 1, 50, '2019-07-18 08:55:24', '2019-07-23 22:25:02'),
(7, 1, NULL, 'pe', '塑料', '塑料', '', '0.00', NULL, NULL, NULL, 0, 0, 2, 0, NULL, '', 0, 0, 0, NULL, 1, 1, 1, 50, '2019-07-18 08:57:42', '2019-07-18 08:58:39'),
(8, 2, NULL, 'SS1', '电动牙刷', NULL, NULL, '0.00', NULL, NULL, NULL, 0, 0, 2, 0, NULL, '', 0, 120, 0, NULL, 1, 1, 1, 50, '2019-07-18 09:03:08', '2019-07-18 09:03:08'),
(9, 1, NULL, 'box', '外箱', '外箱', '40*80*20', '0.00', NULL, NULL, NULL, 0, 0, 2, 0, NULL, '', 0, -10, 0, NULL, 1, 1, 1, 50, '2019-07-19 19:06:21', '2019-07-19 19:06:21'),
(10, 1, NULL, 'pz-12', '塑料', '塑料', '', '0.01', NULL, NULL, NULL, 0, 0, 2, 2, NULL, '', 0, 0, 0, NULL, 1, 1, 1, 50, '2019-07-23 22:27:52', '2019-07-23 22:27:52');

-- --------------------------------------------------------

--
-- 表的结构 `c2_production_schedule`
--

CREATE TABLE `c2_production_schedule` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `code` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `dept_manager_name` varchar(255) DEFAULT NULL,
  `financial_name` varchar(255) DEFAULT NULL,
  `occurrence_date` datetime DEFAULT NULL,
  `accomplish_date` datetime DEFAULT NULL,
  `memo` text,
  `updated_by` bigint(20) DEFAULT NULL,
  `created_by` bigint(20) DEFAULT NULL,
  `state` tinyint(4) DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `updated_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_production_schedule`
--

INSERT INTO `c2_production_schedule` (`id`, `type`, `code`, `label`, `dept_manager_name`, `financial_name`, `occurrence_date`, `accomplish_date`, `memo`, `updated_by`, `created_by`, `state`, `status`, `position`, `updated_at`, `created_at`) VALUES
(1, 1, 'PS201907241', '', '', '', NULL, NULL, '', 1, 1, 1, 1, 0, '2019-07-24 23:47:20', '2019-07-24 23:42:02');

-- --------------------------------------------------------

--
-- 表的结构 `c2_production_schedule_item`
--

CREATE TABLE `c2_production_schedule_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) DEFAULT NULL,
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
  `pieces` mediumint(9) NOT NULL DEFAULT '0',
  `production_sum` mediumint(9) DEFAULT '0',
  `bad_number` mediumint(9) DEFAULT NULL,
  `memo` varchar(255) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_production_schedule_item`
--

INSERT INTO `c2_production_schedule_item` (`id`, `schedule_id`, `product_id`, `product_name`, `product_sku`, `product_label`, `product_value`, `combination_id`, `combination_name`, `package_id`, `package_name`, `measure_id`, `pieces`, `production_sum`, `bad_number`, `memo`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 1, 8, '电动牙刷', 'SS1', NULL, NULL, 2, '黄色', 1, '100装', 2, 5, 500, NULL, '', 2, 0, '2019-07-24 23:42:02', '2019-07-24 23:42:02');

-- --------------------------------------------------------

--
-- 表的结构 `c2_production_schedule_item_consumption`
--

CREATE TABLE `c2_production_schedule_item_consumption` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `schedule_id` bigint(20) DEFAULT NULL,
  `schedule_item_id` bigint(20) DEFAULT NULL,
  `need_product_id` bigint(20) DEFAULT NULL,
  `need_product_sku` varchar(255) DEFAULT NULL,
  `need_product_name` varchar(255) DEFAULT NULL,
  `need_product_label` varchar(255) DEFAULT NULL,
  `need_product_value` varchar(255) DEFAULT NULL,
  `need_number` float DEFAULT '0',
  `need_sum` float DEFAULT '0',
  `memo` varchar(255) DEFAULT NULL,
  `state` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `c2_product_category`
--

CREATE TABLE `c2_product_category` (
  `id` bigint(20) NOT NULL,
  `eshop_id` bigint(20) DEFAULT '1',
  `type` tinyint(4) DEFAULT '0',
  `root` bigint(20) DEFAULT '0',
  `lft` bigint(20) DEFAULT '0',
  `rgt` bigint(20) DEFAULT '0',
  `lvl` int(11) DEFAULT '0',
  `selected` tinyint(4) DEFAULT '0',
  `readonly` tinyint(4) DEFAULT '0',
  `visible` tinyint(4) DEFAULT '0',
  `collapsed` tinyint(4) DEFAULT '0',
  `movable_u` tinyint(4) DEFAULT '1',
  `movable_d` tinyint(4) DEFAULT '1',
  `movable_l` tinyint(4) DEFAULT '1',
  `movable_r` tinyint(4) DEFAULT '1',
  `removable` tinyint(4) DEFAULT '1',
  `removable_all` tinyint(4) DEFAULT '1',
  `disabled` tinyint(4) DEFAULT '0',
  `active` tinyint(4) DEFAULT '1',
  `code` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text,
  `icon` varchar(255) DEFAULT NULL,
  `icon_type` tinyint(4) DEFAULT '1',
  `created_by` bigint(20) DEFAULT '0',
  `updated_by` bigint(20) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `c2_product_category_rs`
--

CREATE TABLE `c2_product_category_rs` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(20) NOT NULL DEFAULT '0',
  `category_id` bigint(20) NOT NULL DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `c2_product_combination`
--

CREATE TABLE `c2_product_combination` (
  `id` bigint(20) NOT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `memo` text,
  `stock` mediumint(9) NOT NULL,
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_product_combination`
--

INSERT INTO `c2_product_combination` (`id`, `product_id`, `name`, `label`, `memo`, `stock`, `status`, `position`, `created_at`, `updated_at`) VALUES
(2, 8, '黄色', '黄色', '', -1988, 1, 0, '2019-07-18 09:03:26', '2019-07-18 09:04:22');

-- --------------------------------------------------------

--
-- 表的结构 `c2_product_combination_item`
--

CREATE TABLE `c2_product_combination_item` (
  `id` bigint(20) NOT NULL,
  `label` varchar(255) DEFAULT NULL,
  `combination_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `need_number` float DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_product_combination_item`
--

INSERT INTO `c2_product_combination_item` (`id`, `label`, `combination_id`, `product_id`, `need_number`, `status`, `position`, `created_at`, `updated_at`) VALUES
(4, '', 2, 7, 0.0002, 1, 0, '2019-07-18 09:03:26', '2019-07-18 09:03:26');

-- --------------------------------------------------------

--
-- 表的结构 `c2_product_package`
--

CREATE TABLE `c2_product_package` (
  `id` bigint(20) NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_product_package`
--

INSERT INTO `c2_product_package` (`id`, `product_id`, `name`, `label`, `product_capacity`, `gross_weight`, `net_weight`, `memo`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 8, '100装', '', 100, '', '', '', 1, 0, '2019-07-19 19:06:34', '2019-07-19 19:06:34');

-- --------------------------------------------------------

--
-- 表的结构 `c2_product_package_item`
--

CREATE TABLE `c2_product_package_item` (
  `id` bigint(20) NOT NULL,
  `label` varchar(255) DEFAULT '0',
  `package_id` bigint(20) DEFAULT '0',
  `product_id` bigint(20) DEFAULT '0',
  `need_number` mediumint(9) DEFAULT '0',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_product_package_item`
--

INSERT INTO `c2_product_package_item` (`id`, `label`, `package_id`, `product_id`, `need_number`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, '', 1, 9, 1, 1, 0, '2019-07-19 19:06:34', '2019-07-19 19:06:34');

-- --------------------------------------------------------

--
-- 表的结构 `c2_product_stock`
--

CREATE TABLE `c2_product_stock` (
  `id` bigint(20) NOT NULL,
  `warehouse_id` bigint(20) DEFAULT NULL,
  `product_id` bigint(20) DEFAULT NULL,
  `number` mediumint(9) DEFAULT '0',
  `state` tinyint(4) DEFAULT '1',
  `status` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_product_stock`
--

INSERT INTO `c2_product_stock` (`id`, `warehouse_id`, `product_id`, `number`, `state`, `status`, `position`, `created_at`, `updated_at`) VALUES
(6, 2, 6, 300, 1, 1, 0, '2019-07-18 08:55:24', '2019-07-18 08:55:24'),
(7, 2, 7, 0, 1, 1, 0, '2019-07-18 08:57:42', '2019-07-18 08:57:42'),
(8, 2, 8, 0, 1, 1, 0, '2019-07-18 09:03:08', '2019-07-18 09:03:08'),
(9, 2, 9, 990, 1, 1, 0, '2019-07-19 19:06:21', '2019-07-19 19:06:21');

-- --------------------------------------------------------

--
-- 表的结构 `c2_supplier`
--

CREATE TABLE `c2_supplier` (
  `id` bigint(20) NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_supplier`
--

INSERT INTO `c2_supplier` (`id`, `code`, `name`, `label`, `contact_name`, `contact_phone`, `fax`, `province_id`, `city_id`, `district_id`, `geo_longitude`, `geo_latitude`, `geo_marker_color`, `description`, `is_default`, `status`, `position`, `created_at`, `updated_at`) VALUES
(1, 'JD', '京东', '', '', '', '', 0, NULL, NULL, NULL, NULL, NULL, '', 0, 1, 0, '2019-07-19 23:40:34', '2019-07-19 23:40:34');

-- --------------------------------------------------------

--
-- 表的结构 `c2_warehouse`
--

CREATE TABLE `c2_warehouse` (
  `id` bigint(20) NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转存表中的数据 `c2_warehouse`
--

INSERT INTO `c2_warehouse` (`id`, `label`, `name`, `code`, `contact_name`, `contact_phone`, `fax`, `eshop_id`, `entity_id`, `entity_class`, `country_id`, `province_id`, `city_id`, `district_id`, `area_id`, `address`, `geo_longitude`, `geo_latitude`, `geo_marker_color`, `state`, `status`, `position`, `created_at`, `updated_at`) VALUES
(2, '子弹头仓库', '子弹头仓库', NULL, 'xun', '15622965560', '2222222', NULL, 0, '0', NULL, 0, NULL, 0, NULL, '', NULL, NULL, NULL, NULL, 1, 0, '2019-07-18 08:55:06', '2019-07-18 08:55:06');

-- --------------------------------------------------------

--
-- 表的结构 `c2_warehouse_commit_delivery_item`
--

CREATE TABLE `c2_warehouse_commit_delivery_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `c2_warehouse_commit_note`
--

CREATE TABLE `c2_warehouse_commit_note` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- 表的结构 `c2_warehouse_commit_receipt_item`
--

CREATE TABLE `c2_warehouse_commit_receipt_item` (
  `id` bigint(20) UNSIGNED NOT NULL,
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
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- 转储表的索引
--

--
-- 表的索引 `c2_fe_user`
--
ALTER TABLE `c2_fe_user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`username`(191)),
  ADD KEY `Index_2` (`email`(191)),
  ADD KEY `Index_3` (`type`),
  ADD KEY `Index_4` (`open_id`(191)),
  ADD KEY `Index_5` (`wechat_open_id`(191)),
  ADD KEY `Index_6` (`access_token`(191),`status`),
  ADD KEY `Index_7` (`mobile_number`(191)),
  ADD KEY `Index_8` (`district_id`);

--
-- 表的索引 `c2_fe_user_auth`
--
ALTER TABLE `c2_fe_user_auth`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`source`(191)),
  ADD KEY `Index_2` (`user_id`,`source_id`(191),`type`);

--
-- 表的索引 `c2_fe_user_profile`
--
ALTER TABLE `c2_fe_user_profile`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`user_id`);

--
-- 表的索引 `c2_inventory_delivery_note`
--
ALTER TABLE `c2_inventory_delivery_note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`code`(191)),
  ADD KEY `Index_2` (`warehouse_id`),
  ADD KEY `Index_3` (`occurrence_date`),
  ADD KEY `Index_4` (`customer_id`),
  ADD KEY `Index_5` (`sales_order_id`);

--
-- 表的索引 `c2_inventory_delivery_note_item`
--
ALTER TABLE `c2_inventory_delivery_note_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`note_id`),
  ADD KEY `Index_2` (`product_id`),
  ADD KEY `Index_3` (`package_id`),
  ADD KEY `Index_4` (`combination_id`),
  ADD KEY `Index_5` (`product_name`(191)),
  ADD KEY `Index_6` (`product_sku`(191)),
  ADD KEY `Index_7` (`combination_name`(191)),
  ADD KEY `Index_8` (`created_at`),
  ADD KEY `Index_9` (`package_name`(191));

--
-- 表的索引 `c2_inventory_note_log`
--
ALTER TABLE `c2_inventory_note_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`note_id`,`type`),
  ADD KEY `Index_2` (`warehouse_id`);

--
-- 表的索引 `c2_inventory_receipt_note`
--
ALTER TABLE `c2_inventory_receipt_note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`code`(191)),
  ADD KEY `Index_2` (`warehouse_id`),
  ADD KEY `Index_3` (`occurrence_date`),
  ADD KEY `Index_4` (`supplier_id`);

--
-- 表的索引 `c2_inventory_receipt_note_item`
--
ALTER TABLE `c2_inventory_receipt_note_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`note_id`),
  ADD KEY `Index_2` (`product_id`),
  ADD KEY `Index_3` (`product_name`(191)),
  ADD KEY `Index_4` (`product_sku`(191)),
  ADD KEY `Index_5` (`product_label`(191)),
  ADD KEY `Index_6` (`product_value`(191));

--
-- 表的索引 `c2_measure`
--
ALTER TABLE `c2_measure`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`code`(191)),
  ADD KEY `Index_2` (`label`(191)),
  ADD KEY `Index_3` (`name`(191));

--
-- 表的索引 `c2_order`
--
ALTER TABLE `c2_order`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`customer_id`),
  ADD KEY `Index_2` (`production_date`),
  ADD KEY `Index_3` (`delivery_date`);

--
-- 表的索引 `c2_order_item`
--
ALTER TABLE `c2_order_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`order_id`),
  ADD KEY `Index_2` (`product_id`),
  ADD KEY `Index_3` (`combination_id`),
  ADD KEY `Index_4` (`package_id`),
  ADD KEY `Index_5` (`product_name`(191)),
  ADD KEY `Index_6` (`product_sku`(191)),
  ADD KEY `Index_7` (`combination_name`(191)),
  ADD KEY `Index_8` (`package_name`(191)),
  ADD KEY `Index_9` (`created_at`);

--
-- 表的索引 `c2_order_item_consumption`
--
ALTER TABLE `c2_order_item_consumption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`order_id`),
  ADD KEY `Index_2` (`order_item_id`),
  ADD KEY `Index_3` (`need_product_id`),
  ADD KEY `Index_4` (`sale_product_id`);

--
-- 表的索引 `c2_product`
--
ALTER TABLE `c2_product`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`sku`(191)),
  ADD KEY `Index_2` (`name`(191)),
  ADD KEY `Index_3` (`label`(191));

--
-- 表的索引 `c2_production_schedule`
--
ALTER TABLE `c2_production_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`code`(191)),
  ADD KEY `Index_2` (`occurrence_date`),
  ADD KEY `Index_3` (`accomplish_date`),
  ADD KEY `Index_4` (`state`);

--
-- 表的索引 `c2_production_schedule_item`
--
ALTER TABLE `c2_production_schedule_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`schedule_id`),
  ADD KEY `Index_2` (`product_id`),
  ADD KEY `Index_3` (`product_name`(191)),
  ADD KEY `Index_4` (`product_sku`(191)),
  ADD KEY `Index_5` (`product_label`(191)),
  ADD KEY `Index_6` (`product_value`(191)),
  ADD KEY `Index_7` (`combination_id`),
  ADD KEY `Index_8` (`package_id`);

--
-- 表的索引 `c2_production_schedule_item_consumption`
--
ALTER TABLE `c2_production_schedule_item_consumption`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`schedule_id`),
  ADD KEY `Index_2` (`schedule_item_id`),
  ADD KEY `Index_3` (`need_product_id`);

--
-- 表的索引 `c2_product_category`
--
ALTER TABLE `c2_product_category`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`lft`,`rgt`),
  ADD KEY `Index_2` (`eshop_id`),
  ADD KEY `Index_3` (`lvl`),
  ADD KEY `Index_4` (`type`),
  ADD KEY `Index_5` (`code`(191)),
  ADD KEY `Index_6` (`root`);

--
-- 表的索引 `c2_product_category_rs`
--
ALTER TABLE `c2_product_category_rs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`product_id`),
  ADD KEY `Index_2` (`category_id`);

--
-- 表的索引 `c2_product_combination`
--
ALTER TABLE `c2_product_combination`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`product_id`);

--
-- 表的索引 `c2_product_combination_item`
--
ALTER TABLE `c2_product_combination_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`combination_id`),
  ADD KEY `Index_2` (`product_id`);

--
-- 表的索引 `c2_product_package`
--
ALTER TABLE `c2_product_package`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`product_id`);

--
-- 表的索引 `c2_product_package_item`
--
ALTER TABLE `c2_product_package_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`package_id`),
  ADD KEY `Index_2` (`product_id`);

--
-- 表的索引 `c2_product_stock`
--
ALTER TABLE `c2_product_stock`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`product_id`),
  ADD KEY `Index_2` (`warehouse_id`);

--
-- 表的索引 `c2_supplier`
--
ALTER TABLE `c2_supplier`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`code`(191)),
  ADD KEY `Index_2` (`label`(191)),
  ADD KEY `Index_3` (`name`(191));

--
-- 表的索引 `c2_warehouse`
--
ALTER TABLE `c2_warehouse`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`eshop_id`),
  ADD KEY `Index_2` (`entity_id`),
  ADD KEY `Index_3` (`province_id`,`country_id`,`city_id`,`area_id`),
  ADD KEY `Index_4` (`geo_longitude`(191),`geo_latitude`(191));

--
-- 表的索引 `c2_warehouse_commit_delivery_item`
--
ALTER TABLE `c2_warehouse_commit_delivery_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`commit_id`),
  ADD KEY `Index_2` (`note_id`,`product_id`),
  ADD KEY `Index_3` (`package_id`),
  ADD KEY `Index_4` (`combination_id`);

--
-- 表的索引 `c2_warehouse_commit_note`
--
ALTER TABLE `c2_warehouse_commit_note`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_2` (`created_at`),
  ADD KEY `Index_1` (`note_code`(191)) USING BTREE;

--
-- 表的索引 `c2_warehouse_commit_receipt_item`
--
ALTER TABLE `c2_warehouse_commit_receipt_item`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Index_1` (`commit_id`),
  ADD KEY `Index_2` (`note_id`,`product_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `c2_fe_user`
--
ALTER TABLE `c2_fe_user`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_fe_user_auth`
--
ALTER TABLE `c2_fe_user_auth`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `c2_fe_user_profile`
--
ALTER TABLE `c2_fe_user_profile`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `c2_inventory_delivery_note`
--
ALTER TABLE `c2_inventory_delivery_note`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_inventory_delivery_note_item`
--
ALTER TABLE `c2_inventory_delivery_note_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_inventory_note_log`
--
ALTER TABLE `c2_inventory_note_log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `c2_inventory_receipt_note`
--
ALTER TABLE `c2_inventory_receipt_note`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `c2_inventory_receipt_note_item`
--
ALTER TABLE `c2_inventory_receipt_note_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_measure`
--
ALTER TABLE `c2_measure`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `c2_order`
--
ALTER TABLE `c2_order`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_order_item`
--
ALTER TABLE `c2_order_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_order_item_consumption`
--
ALTER TABLE `c2_order_item_consumption`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `c2_product`
--
ALTER TABLE `c2_product`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- 使用表AUTO_INCREMENT `c2_production_schedule`
--
ALTER TABLE `c2_production_schedule`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_production_schedule_item`
--
ALTER TABLE `c2_production_schedule_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_production_schedule_item_consumption`
--
ALTER TABLE `c2_production_schedule_item_consumption`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `c2_product_category`
--
ALTER TABLE `c2_product_category`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `c2_product_category_rs`
--
ALTER TABLE `c2_product_category_rs`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `c2_product_combination`
--
ALTER TABLE `c2_product_combination`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `c2_product_combination_item`
--
ALTER TABLE `c2_product_combination_item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- 使用表AUTO_INCREMENT `c2_product_package`
--
ALTER TABLE `c2_product_package`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_product_package_item`
--
ALTER TABLE `c2_product_package_item`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_product_stock`
--
ALTER TABLE `c2_product_stock`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- 使用表AUTO_INCREMENT `c2_supplier`
--
ALTER TABLE `c2_supplier`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- 使用表AUTO_INCREMENT `c2_warehouse`
--
ALTER TABLE `c2_warehouse`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `c2_warehouse_commit_delivery_item`
--
ALTER TABLE `c2_warehouse_commit_delivery_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `c2_warehouse_commit_note`
--
ALTER TABLE `c2_warehouse_commit_note`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- 使用表AUTO_INCREMENT `c2_warehouse_commit_receipt_item`
--
ALTER TABLE `c2_warehouse_commit_receipt_item`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
