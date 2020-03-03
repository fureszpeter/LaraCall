-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: laracall
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1












--
-- Table structure for table `auto_charge_logs`
--

DROP TABLE IF EXISTS `auto_charge_logs`;


CREATE TABLE `auto_charge_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) DEFAULT NULL,
  `amount` double NOT NULL,
  `successful` tinyint(1) NOT NULL,
  `payment_log` longtext COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_92DDF43BF396750` (`id`),
  KEY `IDX_92DDF439A1887DC` (`subscription_id`),
  CONSTRAINT `FK_92DDF439A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `auto_charges`
--

DROP TABLE IF EXISTS `auto_charges`;


CREATE TABLE `auto_charges` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) DEFAULT NULL,
  `do_when_balance_less_than` double NOT NULL,
  `amount_to_charge` double NOT NULL,
  `last_used` datetime DEFAULT NULL,
  `last_failed` datetime DEFAULT NULL,
  `enabled` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `blocked_date_blocked` datetime DEFAULT NULL,
  `blocked_status` tinyint(1) NOT NULL,
  `blocked_reason` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_10AA1D20BF396750` (`id`),
  UNIQUE KEY `UNIQ_10AA1D209A1887DC` (`subscription_id`),
  CONSTRAINT `FK_10AA1D209A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `countries`
--

DROP TABLE IF EXISTS `countries`;


CREATE TABLE `countries` (
  `isoAlpha3` varchar(3) COLLATE utf8_unicode_ci NOT NULL,
  `countryCode` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `countryName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `currencyCode` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`isoAlpha3`),
  UNIQUE KEY `UNIQ_5D66EBADA164B0CD` (`countryCode`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `credit_cards`
--

DROP TABLE IF EXISTS `credit_cards`;


CREATE TABLE `credit_cards` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) DEFAULT NULL,
  `token` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `card_brand` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `card_masked_number` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `name_on_card` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `expiration_year` int(11) NOT NULL,
  `expiration_month` int(11) NOT NULL,
  `expiration_date` datetime NOT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_5CADD653BF396750` (`id`),
  KEY `IDX_5CADD6539A1887DC` (`subscription_id`),
  CONSTRAINT `FK_5CADD6539A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `ebay_payment_transactions`
--

DROP TABLE IF EXISTS `ebay_payment_transactions`;


CREATE TABLE `ebay_payment_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ebay_user_id` int(11) DEFAULT NULL,
  `subscription_id` int(11) DEFAULT NULL,
  `new_subscription` tinyint(1) NOT NULL,
  `date_payment` datetime NOT NULL,
  `ebay_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ebay_username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transaction_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `item_value` double NOT NULL,
  `item_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `mc_gross` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mc_currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount_in_usd` double NOT NULL,
  `buyer_first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `buyer_last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `buyer_zip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `buyer_address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `buyer_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `receiver_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payment_fee` double NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `buyerCountry` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stateCode` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1447698EBF396750` (`id`),
  KEY `IDX_1447698E17BD05CF` (`ebay_user_id`),
  KEY `IDX_1447698EC3B61999` (`buyerCountry`),
  KEY `IDX_1447698E1DFEC4D5` (`stateCode`),
  KEY `IDX_1447698E9A1887DC` (`subscription_id`),
  CONSTRAINT `FK_1447698E17BD05CF` FOREIGN KEY (`ebay_user_id`) REFERENCES `ebay_users` (`id`),
  CONSTRAINT `FK_1447698E1DFEC4D5` FOREIGN KEY (`stateCode`) REFERENCES `states` (`stateCode`),
  CONSTRAINT `FK_1447698E9A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`),
  CONSTRAINT `FK_1447698EC3B61999` FOREIGN KEY (`buyerCountry`) REFERENCES `countries` (`isoAlpha3`)
) ENGINE=InnoDB AUTO_INCREMENT=445 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `ebay_price_lists`
--

DROP TABLE IF EXISTS `ebay_price_lists`;


CREATE TABLE `ebay_price_lists` (
  `item_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `product_price` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tariff_id` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `deleted` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `min_stock` int(11) NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `ebay_users`
--

DROP TABLE IF EXISTS `ebay_users`;


CREATE TABLE `ebay_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subscription_id` int(11) DEFAULT NULL,
  `ebay_user_token_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ebay_user_id` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(64) COLLATE utf8_unicode_ci DEFAULT NULL,
  `date_last_purchase` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_EC19D36BBF396750` (`id`),
  UNIQUE KEY `token_username_unique` (`ebay_user_token_id`,`ebay_user_id`),
  KEY `IDX_EC19D36B9A1887DC` (`subscription_id`),
  CONSTRAINT `FK_EC19D36B9A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=275 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;


CREATE TABLE `failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `ipn_queues`
--

DROP TABLE IF EXISTS `ipn_queues`;


CREATE TABLE `ipn_queues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `raw_data` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `is_pay_pal_the_sender` tinyint(1) DEFAULT NULL,
  `request_details` longtext COLLATE utf8_unicode_ci COMMENT '(DC2Type:array)',
  `try_count` int(11) NOT NULL,
  `processed` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_502F0CFBBF396750` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;


CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `pay_pal_ipns`
--

DROP TABLE IF EXISTS `pay_pal_ipns`;


CREATE TABLE `pay_pal_ipns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_ipn_id` int(11) DEFAULT NULL,
  `subscription_id` int(11) DEFAULT NULL,
  `txn_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_processed` datetime DEFAULT NULL,
  `process_count` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_valid` tinyint(1) NOT NULL,
  `is_sand_box` tinyint(1) NOT NULL,
  `sales_message` longtext COLLATE utf8_unicode_ci NOT NULL,
  `payment_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_payment` datetime NOT NULL,
  `is_ebay` tinyint(1) NOT NULL,
  `ebay_username` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_D3BD91ABF396750` (`id`),
  UNIQUE KEY `uniq_paypal_ipn` (`txn_id`,`payment_status`),
  KEY `IDX_D3BD91A6A01402A` (`parent_ipn_id`),
  KEY `IDX_D3BD91A9A1887DC` (`subscription_id`),
  CONSTRAINT `FK_D3BD91A6A01402A` FOREIGN KEY (`parent_ipn_id`) REFERENCES `pay_pal_ipns` (`id`),
  CONSTRAINT `FK_D3BD91A9A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=475 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `payment_transactions`
--

DROP TABLE IF EXISTS `payment_transactions`;


CREATE TABLE `payment_transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pin` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `amount_payed` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `currency` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `converted_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `quantity` int(11) NOT NULL,
  `source` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date_of_payment` datetime NOT NULL,
  `refill_value` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remote_transaction_id` varchar(128) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_8C58AD56BF396750` (`id`),
  KEY `IDX_8C58AD56B5852DF3` (`pin`),
  CONSTRAINT `FK_8C58AD56B5852DF3` FOREIGN KEY (`pin`) REFERENCES `pins` (`pin`)
) ENGINE=InnoDB AUTO_INCREMENT=445 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `pin_token_deliveries`
--

DROP TABLE IF EXISTS `pin_token_deliveries`;


CREATE TABLE `pin_token_deliveries` (
  `token` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `pin` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `date_expire` datetime NOT NULL,
  `display_counter` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`token`),
  UNIQUE KEY `UNIQ_6CDB0D525F37A13B` (`token`),
  KEY `IDX_6CDB0D52B5852DF3` (`pin`),
  CONSTRAINT `FK_6CDB0D52B5852DF3` FOREIGN KEY (`pin`) REFERENCES `pins` (`pin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `pins`
--

DROP TABLE IF EXISTS `pins`;


CREATE TABLE `pins` (
  `pin` varchar(16) COLLATE utf8_unicode_ci NOT NULL,
  `subscription_id` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `blocked_date_blocked` datetime DEFAULT NULL,
  `blocked_status` tinyint(1) NOT NULL,
  `blocked_reason` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`pin`),
  UNIQUE KEY `UNIQ_3F0FE980B5852DF3` (`pin`),
  KEY `IDX_3F0FE9809A1887DC` (`subscription_id`),
  CONSTRAINT `FK_3F0FE9809A1887DC` FOREIGN KEY (`subscription_id`) REFERENCES `subscriptions` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `states`
--

DROP TABLE IF EXISTS `states`;


CREATE TABLE `states` (
  `stateCode` varchar(2) COLLATE utf8_unicode_ci NOT NULL,
  `stateName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `countryIsoAlpha3` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`stateCode`),
  KEY `IDX_31C2774DA0185D21` (`countryIsoAlpha3`),
  CONSTRAINT `FK_31C2774DA0185D21` FOREIGN KEY (`countryIsoAlpha3`) REFERENCES `countries` (`isoAlpha3`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `subscriptions`
--

DROP TABLE IF EXISTS `subscriptions`;


CREATE TABLE `subscriptions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `default_pin` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zip_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `city` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address2` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `package_id` int(11) NOT NULL,
  `date_last_purchase` datetime NOT NULL,
  `number_of_refill` int(11) NOT NULL,
  `number_of_refund` int(11) NOT NULL,
  `last_transaction_amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `isoAlpha3` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `stateCode` varchar(2) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_4778A01BF396750` (`id`),
  UNIQUE KEY `UNIQ_4778A01A76ED395` (`user_id`),
  KEY `IDX_4778A013FE3CB5F` (`isoAlpha3`),
  KEY `IDX_4778A011DFEC4D5` (`stateCode`),
  CONSTRAINT `FK_4778A011DFEC4D5` FOREIGN KEY (`stateCode`) REFERENCES `states` (`stateCode`),
  CONSTRAINT `FK_4778A013FE3CB5F` FOREIGN KEY (`isoAlpha3`) REFERENCES `countries` (`isoAlpha3`),
  CONSTRAINT `FK_4778A01A76ED395` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=282 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;


CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `token_expire_date` datetime DEFAULT NULL,
  `registration_date` datetime NOT NULL,
  `admin` tinyint(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `blocked_date_blocked` datetime DEFAULT NULL,
  `blocked_status` tinyint(1) NOT NULL,
  `blocked_reason` longtext COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `UNIQ_1483A5E9E7927C74` (`email`),
  UNIQUE KEY `UNIQ_1483A5E9BF396750` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=304 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Temporary view structure for view `v_subscriptions`
--

DROP TABLE IF EXISTS `v_subscriptions`;
