-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 26, 2022 at 11:13 AM
-- Server version: 5.7.33
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clan_vent_fresh`
--

-- --------------------------------------------------------

--
-- Table structure for table `ic_attributes`
--

CREATE TABLE `ic_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_attribute_items`
--

CREATE TABLE `ic_attribute_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `attribute_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `color` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_brands`
--

CREATE TABLE `ic_brands` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_coupons`
--

CREATE TABLE `ic_coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `banner` text COLLATE utf8mb4_unicode_ci,
  `minimum_shopping` int(11) DEFAULT '0',
  `maximum_discount` double(10,3) DEFAULT NULL,
  `discount_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount` double(10,3) DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `start_date` timestamp NULL DEFAULT NULL,
  `end_date` timestamp NULL DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_coupon_products`
--

CREATE TABLE `ic_coupon_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_customers`
--

CREATE TABLE `ic_customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` bigint(20) UNSIGNED DEFAULT NULL,
  `state` bigint(20) UNSIGNED DEFAULT NULL,
  `city` bigint(20) UNSIGNED DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_address` text COLLATE utf8mb4_unicode_ci,
  `billing_same` tinyint(1) NOT NULL DEFAULT '0',
  `b_first_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_last_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_email` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_address_line_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_address_line_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_country` bigint(20) UNSIGNED DEFAULT NULL,
  `b_state` bigint(20) UNSIGNED DEFAULT NULL,
  `b_city` bigint(20) UNSIGNED DEFAULT NULL,
  `b_zipcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `b_short_address` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `is_verified` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'verified',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_customers`
--

INSERT INTO `ic_customers` (`id`, `first_name`, `last_name`, `email`, `email_verified_at`, `password`, `phone`, `company`, `designation`, `address_line_1`, `address_line_2`, `country`, `state`, `city`, `zipcode`, `short_address`, `billing_same`, `b_first_name`, `b_last_name`, `b_email`, `b_phone`, `b_address_line_1`, `b_address_line_2`, `b_country`, `b_state`, `b_city`, `b_zipcode`, `b_short_address`, `avatar`, `status`, `is_verified`, `remember_token`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Shanelle', 'Rosenbaum', 'customer@app.com', '2022-12-26 11:12:20', '$2y$10$8WWSR3gYL08jitlTe5QJyORr1yKzamBNF3zgRylFQHrVHnq2LykKa', '01234567891', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', 'verified', 'J7O1ixKWcf', NULL, NULL, '2022-12-26 11:12:20', '2022-12-26 11:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `ic_draft_invoices`
--

CREATE TABLE `ic_draft_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer` json DEFAULT NULL,
  `billing_info` json DEFAULT NULL,
  `shipping_info` json DEFAULT NULL,
  `bank_info` json DEFAULT NULL,
  `items_data` json DEFAULT NULL,
  `tax_amount` decimal(14,2) DEFAULT NULL,
  `discount_amount` decimal(14,2) DEFAULT NULL,
  `global_discount` decimal(14,2) DEFAULT '0.00',
  `global_discount_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(14,2) DEFAULT NULL,
  `total_paid` decimal(14,2) DEFAULT NULL,
  `last_paid` decimal(14,2) NOT NULL DEFAULT '0.00',
  `payment_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_created_from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_draft_invoice_items`
--

CREATE TABLE `ic_draft_invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `draft_invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(14,2) NOT NULL,
  `tax` int(11) NOT NULL DEFAULT '0',
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` decimal(14,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_expenses`
--

CREATE TABLE `ic_expenses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` decimal(8,2) DEFAULT NULL,
  `notes` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expense_by` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_expenses_categories`
--

CREATE TABLE `ic_expenses_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_expenses_files`
--

CREATE TABLE `ic_expenses_files` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expenses_id` bigint(20) UNSIGNED DEFAULT NULL,
  `original_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `file_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_expenses_items`
--

CREATE TABLE `ic_expenses_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `expenses_id` bigint(20) UNSIGNED DEFAULT NULL,
  `item_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_qty` mediumint(9) NOT NULL DEFAULT '1',
  `amount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_failed_jobs`
--

CREATE TABLE `ic_failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_invoices`
--

CREATE TABLE `ic_invoices` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `due_date` date DEFAULT NULL,
  `customer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `customer` json DEFAULT NULL,
  `billing_info` json DEFAULT NULL,
  `shipping_info` json DEFAULT NULL,
  `items_data` json DEFAULT NULL,
  `tax_amount` decimal(14,2) DEFAULT NULL,
  `discount_amount` decimal(14,2) DEFAULT NULL,
  `global_discount` decimal(14,2) DEFAULT '0.00',
  `global_discount_type` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `total` decimal(14,2) DEFAULT NULL,
  `total_paid` decimal(14,2) DEFAULT NULL,
  `last_paid` decimal(14,2) NOT NULL DEFAULT '0.00',
  `payment_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `delivery_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'delivered',
  `invoice_created_from` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'admin',
  `delivered_at` timestamp NULL DEFAULT '2022-12-26 11:12:18',
  `canceled_at` timestamp NULL DEFAULT '2022-12-26 11:12:18',
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bank_info` json DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_invoice_items`
--

CREATE TABLE `ic_invoice_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(14,2) NOT NULL,
  `tax` int(11) NOT NULL DEFAULT '0',
  `discount` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `discount_type` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` decimal(14,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_invoice_payments`
--

CREATE TABLE `ic_invoice_payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_type` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `amount` decimal(14,2) DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `bank_info` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_manufacturers`
--

CREATE TABLE `ic_manufacturers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_measurement_units`
--

CREATE TABLE `ic_measurement_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_migrations`
--

CREATE TABLE `ic_migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_migrations`
--

INSERT INTO `ic_migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2020_12_31_055154_create_permission_tables', 1),
(5, '2021_07_17_050049_create_system_countries_table', 1),
(6, '2021_07_18_050700_create_system_states_table', 1),
(7, '2021_07_19_050948_create_system_cities_table', 1),
(8, '2021_08_17_045916_create_warehouses_table', 1),
(9, '2021_08_18_085126_create_brands_table', 1),
(10, '2021_08_19_043411_create_manufacturers_table', 1),
(11, '2021_08_19_054121_create_weight_units_table', 1),
(12, '2021_08_19_071558_create_measurement_units_table', 1),
(13, '2021_08_19_092718_create_product_categories_table', 1),
(14, '2021_08_26_043158_create_attributes_table', 1),
(15, '2021_08_26_055628_create_attribute_items_table', 1),
(16, '2021_08_30_051232_create_products_table', 1),
(17, '2021_08_30_095212_create_product_attributes_table', 1),
(18, '2021_08_31_103032_create_product_stocks_table', 1),
(19, '2021_09_02_041005_create_customers_table', 1),
(20, '2021_09_02_084554_create_suppliers_table', 1),
(21, '2021_09_02_094612_create_expenses_categories_table', 1),
(22, '2021_09_12_044901_create_expenses_table', 1),
(23, '2021_09_12_054539_create_expenses_items_table', 1),
(24, '2021_09_12_055040_create_expenses_files_table', 1),
(25, '2021_09_12_084843_create_purchases_table', 1),
(26, '2021_09_12_085621_create_purchase_items_table', 1),
(27, '2021_09_12_095850_create_purchase_returns_table', 1),
(28, '2021_09_12_095915_create_purchase_return_items_table', 1),
(29, '2021_09_14_115607_create_purchase_receives_table', 1),
(30, '2021_09_14_115611_create_purchase_item_receives_table', 1),
(31, '2021_10_28_104330_add_tax_to_product', 1),
(32, '2021_11_01_054626_create_invoices_table', 1),
(33, '2021_11_01_104452_create_invoice_items_table', 1),
(34, '2021_11_01_104531_create_invoice_payments_table', 1),
(35, '2021_11_04_103443_create_sale_returns_table', 1),
(36, '2021_11_04_112115_create_sale_return_items_table', 1),
(37, '2021_11_07_052114_add_stock_column_to_products', 1),
(38, '2021_11_09_053542_create_system_settings_table', 1),
(39, '2021_11_10_103702_add_bank_to_invoice', 1),
(40, '2021_11_10_103814_add_bank_to_invoice_payment', 1),
(41, '2022_04_10_063011_add_short_address_column_to_purchases', 1),
(42, '2022_04_10_073127_add_short_address_to_customers', 1),
(43, '2022_04_10_081049_add_short_address_to_suppliers', 1),
(44, '2022_04_12_060629_add_expense_by_to_expenses', 1),
(45, '2022_04_12_075552_add_split_sale_to_products', 1),
(46, '2022_06_16_094219_change_total_rage_to_purchases', 1),
(47, '2022_06_16_094450_change_total_rage_to_purchase_items', 1),
(48, '2022_06_16_094907_change_total_rage_to_purchase_receives', 1),
(49, '2022_06_16_095244_change_total_rage_to_purchase_item_receives', 1),
(50, '2022_06_26_105012_add_warehouse_id_to_invoices', 1),
(51, '2022_06_30_065842_add_alert_quantity_to_products', 1),
(52, '2022_07_26_045153_change_total_limit_to_invoices', 1),
(53, '2022_07_26_050002_change_decimal_limit_invoice_items', 1),
(54, '2022_07_26_050421_change_decimal_limit_invoice_payments', 1),
(55, '2022_07_31_104035_change_date_type_to_invoices', 1),
(56, '2022_09_18_051147_add_position_to_product_categories_table', 1),
(57, '2022_09_21_083000_add_password_to_customers_table', 1),
(58, '2022_09_21_101736_create_coupons_table', 1),
(59, '2022_09_22_061954_alter_table_products_change_some_column_type', 1),
(60, '2022_09_22_075729_create_coupon_products_table', 1),
(61, '2022_10_18_101603_add_customer_price_to_products_table', 1),
(62, '2022_10_19_051713_create_sale_return_requests_table', 1),
(63, '2022_10_19_052408_create_sale_return_item_requests_table', 1),
(64, '2022_10_20_112627_add_column_to_expense_items_table', 1),
(65, '2022_10_20_112627_add_column_to_invoices_table', 1),
(66, '2022_10_24_064859_create_draft_invoices_table', 1),
(67, '2022_10_24_064927_create_draft_invoice_items_table', 1),
(68, '2022_11_13_105243_update_decimal_to_sale_return_items_table', 1),
(69, '2022_11_13_105744_update_decimal_to_sale_returns_table', 1),
(70, '2022_11_13_110110_update_decimal_to_purchase_returns_table', 1),
(71, '2022_11_13_111102_update_decimal_to_purchase_return_items_table', 1),
(72, '2022_11_13_111338_update_decimal_to_purchase_items_table', 1),
(73, '2022_11_29_064452_add_warehouse_id_to_sale_return_requests_table', 1),
(74, '2022_12_11_143715_add_attribute_wise_price_to_product_stocks_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `ic_model_has_permissions`
--

CREATE TABLE `ic_model_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_model_has_roles`
--

CREATE TABLE `ic_model_has_roles` (
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `model_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_model_has_roles`
--

INSERT INTO `ic_model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
(1, 'App\\Models\\User', 1),
(2, 'App\\Models\\User', 2);

-- --------------------------------------------------------

--
-- Table structure for table `ic_password_resets`
--

CREATE TABLE `ic_password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_permissions`
--

CREATE TABLE `ic_permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_permissions`
--

INSERT INTO `ic_permissions` (`id`, `parent_id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Dashboard', 'web', '2022-12-26 11:12:20', '2022-12-26 11:12:20'),
(2, 1, 'Total Customer', 'web', '2022-12-26 11:12:20', '2022-12-26 11:12:20'),
(3, 1, 'Total Supplier', 'web', '2022-12-26 11:12:20', '2022-12-26 11:12:20'),
(4, 1, 'Total Product', 'web', '2022-12-26 11:12:20', '2022-12-26 11:12:20'),
(5, 1, 'Total Sale', 'web', '2022-12-26 11:12:20', '2022-12-26 11:12:20'),
(6, 1, 'Total Purchase', 'web', '2022-12-26 11:12:20', '2022-12-26 11:12:20'),
(7, 1, 'Total Expenses', 'web', '2022-12-26 11:12:20', '2022-12-26 11:12:20'),
(8, 1, 'Total Sale Amount', 'web', '2022-12-26 11:12:20', '2022-12-26 11:12:20'),
(9, 1, 'Total purchase Amount', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(10, 1, 'Total Expenses Amount', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(11, 1, 'Total Product Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(12, 1, 'Total Sale Return Request', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(13, 1, 'Total Pending Sale Return Request', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(14, 1, 'Total Stock', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(15, 1, 'Total Invoice By Auth User', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(16, 1, 'Total Sale By Auth User', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(17, 1, 'Total Warehouse', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(18, 1, 'Active Coupons', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(19, 1, 'Total Sale Return', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(20, 1, 'Sale Report Charts', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(21, 1, 'Top Products', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(22, 1, 'Best Items', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(23, 1, 'Latest Sales', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(24, NULL, 'User', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(25, 24, 'Add User', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(26, 24, 'Edit User', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(27, 24, 'Show User', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(28, 24, 'List User', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(29, 24, 'Delete User', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(30, NULL, 'Role', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(31, 30, 'Add Role', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(32, 30, 'Edit Role', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(33, 30, 'Show Role', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(34, 30, 'List Role', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(35, 30, 'Delete Role', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(36, NULL, 'Product', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(37, 36, 'Add Product', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(38, 36, 'Edit Product', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(39, 36, 'Stock Product', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(40, 36, 'List Product', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(41, 36, 'Delete Product', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(42, NULL, 'Warehouse', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(43, 42, 'Add Warehouse', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(44, 42, 'Edit Warehouse', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(45, 42, 'Show Warehouse', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(46, 42, 'List Warehouse', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(47, 42, 'Delete Warehouse', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(48, NULL, 'Product Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(49, 48, 'Add Product Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(50, 48, 'Edit Product Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(51, 48, 'List Product Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(52, 48, 'Delete Product Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(53, NULL, 'Brand', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(54, 53, 'Add Brand', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(55, 53, 'Edit Brand', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(56, 53, 'List Brand', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(57, 53, 'Delete Brand', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(58, NULL, 'Manufacturer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(59, 58, 'Add Manufacturer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(60, 58, 'Edit Manufacturer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(61, 58, 'List Manufacturer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(62, 58, 'Delete Manufacturer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(63, NULL, 'Weight Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(64, 63, 'Add Weight Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(65, 63, 'Edit Weight Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(66, 63, 'List Weight Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(67, 63, 'Delete Weight Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(68, NULL, 'Measurement Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(69, 68, 'Add Measurement Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(70, 68, 'Edit Measurement Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(71, 68, 'List Measurement Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(72, 68, 'Delete Measurement Unit', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(73, NULL, 'Attribute', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(74, 73, 'Add Attribute', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(75, 73, 'Edit Attribute', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(76, 73, 'List Attribute', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(77, 73, 'Delete Attribute', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(78, NULL, 'Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(79, 78, 'Add Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(80, 78, 'Edit Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(81, 78, 'Show Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(82, 78, 'List Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(83, 78, 'Cancel Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(84, 78, 'Receive Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(85, 78, 'Confirm Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(86, 78, 'Return Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(87, 78, 'Delete Purchase', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(88, 78, 'Purchase Receive List', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(89, 78, 'Purchase Return List', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(90, NULL, 'Coupon', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(91, 90, 'Add Coupon', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(92, 90, 'Edit Coupon', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(93, 90, 'List Coupon', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(94, 90, 'Delete Coupon', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(95, NULL, 'Customer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(96, 95, 'Add Customer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(97, 95, 'Edit Customer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(98, 95, 'List Customer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(99, 95, 'Delete Customer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(100, 95, 'Verify Customer', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(101, NULL, 'Supplier', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(102, 101, 'Add Supplier', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(103, 101, 'Edit Supplier', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(104, 101, 'List Supplier', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(105, 101, 'Delete Supplier', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(106, NULL, 'Expenses Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(107, 106, 'Add Expenses Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(108, 106, 'Edit Expenses Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(109, 106, 'List Expenses Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(110, 106, 'Delete Expenses Category', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(111, NULL, 'Expenses', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(112, 111, 'Add Expenses', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(113, 111, 'Edit Expenses', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(114, 111, 'Show Expenses', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(115, 111, 'List Expenses', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(116, 111, 'Delete Expenses', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(117, NULL, 'Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(118, 117, 'List Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(119, 117, 'Add Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(120, 117, 'Edit Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(121, 117, 'Show Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(122, 117, 'Return Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(123, 117, 'View Payment Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(124, 117, 'Make Payment Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(125, 117, 'Download Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(126, 117, 'Send Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(127, 117, 'Link Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(128, 117, 'Delete Invoice', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(129, NULL, 'Sale Return', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(130, 129, 'Show Sale Return', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(131, 129, 'Return Sale Return', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(132, 129, 'Sale Return List', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(133, 129, 'Sale Return Request List', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(134, NULL, 'Reports', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(135, 134, 'Expenses Report', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(136, 134, 'Sales Report', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(137, 134, 'Purchases Report', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(138, 134, 'Payments Report', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(139, NULL, 'Settings', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(140, 139, 'Site Settings', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `ic_products`
--

CREATE TABLE `ic_products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sku` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `barcode_image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_buying_price` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` double DEFAULT NULL,
  `dimension_l` double DEFAULT NULL,
  `dimension_w` double DEFAULT NULL,
  `dimension_d` double DEFAULT NULL,
  `thumb` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `notes` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `desc` text COLLATE utf8mb4_unicode_ci,
  `is_variant` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `available_for` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all',
  `category_id` bigint(20) UNSIGNED DEFAULT NULL,
  `brand_id` bigint(20) UNSIGNED DEFAULT NULL,
  `manufacturer_id` bigint(20) UNSIGNED DEFAULT NULL,
  `weight_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `measurement_unit_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `tax_status` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT 'included',
  `custom_tax` double DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `split_sale` tinyint(1) DEFAULT NULL,
  `stock_alert_quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_product_attributes`
--

CREATE TABLE `ic_product_attributes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attribute_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attribute_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_product_categories`
--

CREATE TABLE `ic_product_categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `desc` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `parent_id` bigint(20) UNSIGNED DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_product_stocks`
--

CREATE TABLE `ic_product_stocks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT '0',
  `product_id` bigint(20) UNSIGNED DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attribute_id` bigint(20) UNSIGNED DEFAULT NULL,
  `attribute_item_id` bigint(20) UNSIGNED DEFAULT NULL,
  `price` double DEFAULT NULL,
  `customer_buying_price` double DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_purchases`
--

CREATE TABLE `ic_purchases` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_number` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier_id` bigint(20) UNSIGNED NOT NULL,
  `warehouse_id` bigint(20) UNSIGNED NOT NULL,
  `company` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` datetime NOT NULL,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `total` decimal(14,2) NOT NULL,
  `status` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address_line_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` bigint(20) UNSIGNED DEFAULT NULL,
  `state` bigint(20) UNSIGNED DEFAULT NULL,
  `city` bigint(20) UNSIGNED DEFAULT NULL,
  `zipcode` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `received` tinyint(1) DEFAULT NULL,
  `cancel_date` date DEFAULT NULL,
  `cancel_by` bigint(20) UNSIGNED DEFAULT NULL,
  `cancel_note` text COLLATE utf8mb4_unicode_ci,
  `short_address` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_purchase_items`
--

CREATE TABLE `ic_purchase_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `note` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sub_total` double NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_purchase_item_receives`
--

CREATE TABLE `ic_purchase_item_receives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_receive_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_item_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(14,2) NOT NULL,
  `sub_total` decimal(14,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_purchase_receives`
--

CREATE TABLE `ic_purchase_receives` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `receive_date` date NOT NULL,
  `total` decimal(14,2) NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_purchase_returns`
--

CREATE TABLE `ic_purchase_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_id` bigint(20) UNSIGNED NOT NULL,
  `return_date` date NOT NULL,
  `note` text COLLATE utf8mb4_unicode_ci,
  `total` double NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_purchase_return_items`
--

CREATE TABLE `ic_purchase_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `purchase_return_id` bigint(20) UNSIGNED NOT NULL,
  `purchase_item_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `sub_total` double NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_roles`
--

CREATE TABLE `ic_roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_roles`
--

INSERT INTO `ic_roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21'),
(2, 'Manager', 'web', '2022-12-26 11:12:21', '2022-12-26 11:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `ic_role_has_permissions`
--

CREATE TABLE `ic_role_has_permissions` (
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_role_has_permissions`
--

INSERT INTO `ic_role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(7, 1),
(11, 1),
(12, 1),
(13, 1),
(14, 1),
(15, 1),
(16, 1),
(17, 1),
(18, 1),
(19, 1),
(20, 1),
(21, 1),
(22, 1),
(23, 1),
(24, 1),
(25, 1),
(26, 1),
(27, 1),
(28, 1),
(29, 1),
(30, 1),
(31, 1),
(32, 1),
(33, 1),
(34, 1),
(35, 1),
(36, 1),
(37, 1),
(38, 1),
(39, 1),
(40, 1),
(41, 1),
(42, 1),
(43, 1),
(44, 1),
(45, 1),
(46, 1),
(47, 1),
(48, 1),
(49, 1),
(50, 1),
(51, 1),
(52, 1),
(53, 1),
(54, 1),
(55, 1),
(56, 1),
(57, 1),
(58, 1),
(59, 1),
(60, 1),
(61, 1),
(62, 1),
(63, 1),
(64, 1),
(65, 1),
(66, 1),
(67, 1),
(68, 1),
(69, 1),
(70, 1),
(71, 1),
(72, 1),
(73, 1),
(74, 1),
(75, 1),
(76, 1),
(77, 1),
(78, 1),
(79, 1),
(80, 1),
(81, 1),
(82, 1),
(83, 1),
(84, 1),
(85, 1),
(86, 1),
(87, 1),
(88, 1),
(89, 1),
(90, 1),
(91, 1),
(92, 1),
(93, 1),
(94, 1),
(95, 1),
(96, 1),
(97, 1),
(98, 1),
(99, 1),
(100, 1),
(101, 1),
(102, 1),
(103, 1),
(104, 1),
(105, 1),
(106, 1),
(107, 1),
(108, 1),
(109, 1),
(110, 1),
(111, 1),
(112, 1),
(113, 1),
(114, 1),
(115, 1),
(116, 1),
(117, 1),
(118, 1),
(119, 1),
(120, 1),
(121, 1),
(122, 1),
(123, 1),
(124, 1),
(125, 1),
(126, 1),
(127, 1),
(128, 1),
(129, 1),
(130, 1),
(131, 1),
(132, 1),
(133, 1),
(134, 1),
(135, 1),
(136, 1),
(137, 1),
(138, 1),
(139, 1),
(140, 1),
(1, 2),
(2, 2),
(3, 2),
(7, 2),
(11, 2),
(12, 2),
(13, 2),
(14, 2),
(15, 2),
(16, 2),
(17, 2),
(18, 2),
(19, 2),
(20, 2),
(21, 2),
(22, 2),
(23, 2),
(24, 2),
(25, 2),
(26, 2),
(27, 2),
(28, 2),
(29, 2),
(30, 2),
(31, 2),
(32, 2),
(33, 2),
(34, 2),
(35, 2),
(36, 2),
(37, 2),
(38, 2),
(39, 2),
(40, 2),
(41, 2),
(42, 2),
(43, 2),
(44, 2),
(45, 2),
(46, 2),
(47, 2),
(48, 2),
(49, 2),
(50, 2),
(51, 2),
(52, 2),
(53, 2),
(54, 2),
(55, 2),
(56, 2),
(57, 2),
(58, 2),
(59, 2),
(60, 2),
(61, 2),
(62, 2),
(63, 2),
(64, 2),
(65, 2),
(66, 2),
(67, 2),
(68, 2),
(69, 2),
(70, 2),
(71, 2),
(72, 2),
(73, 2),
(74, 2),
(75, 2),
(76, 2),
(77, 2),
(78, 2),
(79, 2),
(80, 2),
(81, 2),
(82, 2),
(83, 2),
(84, 2),
(85, 2),
(86, 2),
(87, 2),
(88, 2),
(89, 2),
(90, 2),
(91, 2),
(92, 2),
(93, 2),
(94, 2),
(95, 2),
(96, 2),
(97, 2),
(98, 2),
(99, 2),
(100, 2),
(101, 2),
(102, 2),
(103, 2),
(104, 2),
(105, 2),
(106, 2),
(107, 2),
(108, 2),
(109, 2),
(110, 2),
(111, 2),
(112, 2),
(113, 2),
(114, 2),
(115, 2),
(116, 2),
(117, 2),
(118, 2),
(119, 2),
(120, 2),
(121, 2),
(122, 2),
(123, 2),
(124, 2),
(125, 2),
(126, 2),
(127, 2),
(128, 2),
(129, 2),
(130, 2),
(131, 2),
(132, 2),
(133, 2),
(134, 2),
(135, 2),
(136, 2),
(137, 2),
(138, 2),
(139, 2),
(140, 2);

-- --------------------------------------------------------

--
-- Table structure for table `ic_sale_returns`
--

CREATE TABLE `ic_sale_returns` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `return_date` date NOT NULL,
  `return_note` text COLLATE utf8mb4_unicode_ci,
  `return_total_amount` double NOT NULL,
  `items_info` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_sale_return_items`
--

CREATE TABLE `ic_sale_return_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_return_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_item_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_qty` int(11) NOT NULL,
  `return_price` double NOT NULL,
  `return_sub_total` double NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_sale_return_item_requests`
--

CREATE TABLE `ic_sale_return_item_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sale_return_request_id` bigint(20) UNSIGNED NOT NULL,
  `invoice_item_id` bigint(20) UNSIGNED NOT NULL,
  `product_id` bigint(20) UNSIGNED NOT NULL,
  `product_stock_id` bigint(20) UNSIGNED DEFAULT NULL,
  `product_name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `return_qty` int(11) NOT NULL,
  `return_price` double NOT NULL,
  `return_sub_total` double NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_sale_return_requests`
--

CREATE TABLE `ic_sale_return_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `invoice_id` bigint(20) UNSIGNED NOT NULL,
  `return_date` date NOT NULL,
  `return_note` text COLLATE utf8mb4_unicode_ci,
  `return_total_amount` double NOT NULL,
  `items_info` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `requested_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status_updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `status_updated_at` timestamp NULL DEFAULT '2022-12-26 11:12:18',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `warehouse_id` bigint(20) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_suppliers`
--

CREATE TABLE `ic_suppliers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `first_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `designation` varchar(200) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_line_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` bigint(20) UNSIGNED DEFAULT NULL,
  `state` bigint(20) UNSIGNED DEFAULT NULL,
  `city` bigint(20) UNSIGNED DEFAULT NULL,
  `zipcode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_address` text COLLATE utf8mb4_unicode_ci,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_suppliers`
--

INSERT INTO `ic_suppliers` (`id`, `first_name`, `last_name`, `email`, `phone`, `company`, `designation`, `address_line_1`, `address_line_2`, `country`, `state`, `city`, `zipcode`, `short_address`, `avatar`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'In House', 'Supplier', 'supplier@app.com', '01234567891', 'Morar PLC', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'active', NULL, NULL, '2022-12-26 11:12:20', '2022-12-26 11:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `ic_system_cities`
--

CREATE TABLE `ic_system_cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_system_countries`
--

CREATE TABLE `ic_system_countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shortname` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phonecode` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_system_settings`
--

CREATE TABLE `ic_system_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `settings_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `settings_value` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_system_settings`
--

INSERT INTO `ic_system_settings` (`id`, `settings_key`, `settings_value`, `created_at`, `updated_at`) VALUES
(1, 'purchase_info', '{\"domain\": \"https://clanvent32.dev\", \"install_at\": \"2022-12-26 17:12:22\", \"purchase_code\": \"\"}', '2022-12-26 11:12:22', '2022-12-26 11:12:22');

-- --------------------------------------------------------

--
-- Table structure for table `ic_system_states`
--

CREATE TABLE `ic_system_states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ic_users`
--

CREATE TABLE `ic_users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_users`
--

INSERT INTO `ic_users` (`id`, `name`, `email`, `phone`, `email_verified_at`, `password`, `avatar`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@app.com', NULL, '2022-12-26 11:12:20', '$2y$10$8PIYyh/Hj.AwLGBjauNZHu26xRXigavdAqTe8f6el4c04cu.lAwq6', NULL, 'active', 'GrA7m9fAfc', '2022-12-26 11:12:20', '2022-12-26 11:12:22'),
(2, 'John Doe', 'manager@app.com', NULL, '2022-12-26 11:12:20', '$2y$10$oYFY.K7tqPX4d73/aFKxq.axsByVJzJh1OVZsf.Ly/jVJJ9gPlkBy', NULL, 'active', 'qeFV4llWmE', '2022-12-26 11:12:20', '2022-12-26 11:12:20');

-- --------------------------------------------------------

--
-- Table structure for table `ic_warehouses`
--

CREATE TABLE `ic_warehouses` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `company_name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_1` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address_2` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` tinyint(4) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ic_warehouses`
--

INSERT INTO `ic_warehouses` (`id`, `name`, `email`, `phone`, `company_name`, `address_1`, `address_2`, `priority`, `is_default`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Default Warehouse', 'default@email.com', '12345678', 'Default Company', '', '', 1, 1, 'active', 1, 1, '2022-12-26 11:12:21', '2022-12-26 11:12:21');

-- --------------------------------------------------------

--
-- Table structure for table `ic_weight_units`
--

CREATE TABLE `ic_weight_units` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ic_attributes`
--
ALTER TABLE `ic_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_attributes_name_index` (`name`),
  ADD KEY `ic_attributes_created_by_foreign` (`created_by`),
  ADD KEY `ic_attributes_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_attribute_items`
--
ALTER TABLE `ic_attribute_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_attribute_items_attribute_id_foreign` (`attribute_id`),
  ADD KEY `ic_attribute_items_created_by_foreign` (`created_by`),
  ADD KEY `ic_attribute_items_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_brands`
--
ALTER TABLE `ic_brands`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_brands_name_index` (`name`),
  ADD KEY `ic_brands_created_by_foreign` (`created_by`),
  ADD KEY `ic_brands_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_coupons`
--
ALTER TABLE `ic_coupons`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_coupons_created_by_foreign` (`created_by`),
  ADD KEY `ic_coupons_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_coupon_products`
--
ALTER TABLE `ic_coupon_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_coupon_products_coupon_id_foreign` (`coupon_id`),
  ADD KEY `ic_coupon_products_product_id_foreign` (`product_id`);

--
-- Indexes for table `ic_customers`
--
ALTER TABLE `ic_customers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_customers_country_foreign` (`country`),
  ADD KEY `ic_customers_state_foreign` (`state`),
  ADD KEY `ic_customers_city_foreign` (`city`),
  ADD KEY `ic_customers_b_country_foreign` (`b_country`),
  ADD KEY `ic_customers_b_state_foreign` (`b_state`),
  ADD KEY `ic_customers_b_city_foreign` (`b_city`),
  ADD KEY `ic_customers_created_by_foreign` (`created_by`),
  ADD KEY `ic_customers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_draft_invoices`
--
ALTER TABLE `ic_draft_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_draft_invoices_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `ic_draft_invoices_customer_id_foreign` (`customer_id`),
  ADD KEY `ic_draft_invoices_created_by_foreign` (`created_by`),
  ADD KEY `ic_draft_invoices_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_draft_invoice_items`
--
ALTER TABLE `ic_draft_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_draft_invoice_items_draft_invoice_id_index` (`draft_invoice_id`),
  ADD KEY `ic_draft_invoice_items_product_id_foreign` (`product_id`),
  ADD KEY `ic_draft_invoice_items_created_by_foreign` (`created_by`),
  ADD KEY `ic_draft_invoice_items_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_draft_invoice_items_product_stock_id_foreign` (`product_stock_id`);

--
-- Indexes for table `ic_expenses`
--
ALTER TABLE `ic_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_expenses_title_index` (`title`),
  ADD KEY `ic_expenses_category_id_foreign` (`category_id`),
  ADD KEY `ic_expenses_created_by_foreign` (`created_by`),
  ADD KEY `ic_expenses_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_expenses_expense_by_foreign` (`expense_by`);

--
-- Indexes for table `ic_expenses_categories`
--
ALTER TABLE `ic_expenses_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_expenses_categories_name_index` (`name`),
  ADD KEY `ic_expenses_categories_created_by_foreign` (`created_by`),
  ADD KEY `ic_expenses_categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_expenses_files`
--
ALTER TABLE `ic_expenses_files`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_expenses_files_expenses_id_foreign` (`expenses_id`);

--
-- Indexes for table `ic_expenses_items`
--
ALTER TABLE `ic_expenses_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_expenses_items_expenses_id_foreign` (`expenses_id`);

--
-- Indexes for table `ic_failed_jobs`
--
ALTER TABLE `ic_failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ic_failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `ic_invoices`
--
ALTER TABLE `ic_invoices`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_invoices_customer_id_foreign` (`customer_id`),
  ADD KEY `ic_invoices_created_by_foreign` (`created_by`),
  ADD KEY `ic_invoices_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_invoices_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `ic_invoice_items`
--
ALTER TABLE `ic_invoice_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_invoice_items_invoice_id_index` (`invoice_id`),
  ADD KEY `ic_invoice_items_product_id_foreign` (`product_id`),
  ADD KEY `ic_invoice_items_created_by_foreign` (`created_by`),
  ADD KEY `ic_invoice_items_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_invoice_items_product_stock_id_foreign` (`product_stock_id`);

--
-- Indexes for table `ic_invoice_payments`
--
ALTER TABLE `ic_invoice_payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_invoice_payments_invoice_id_index` (`invoice_id`),
  ADD KEY `ic_invoice_payments_created_by_foreign` (`created_by`),
  ADD KEY `ic_invoice_payments_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_manufacturers`
--
ALTER TABLE `ic_manufacturers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_manufacturers_name_index` (`name`),
  ADD KEY `ic_manufacturers_created_by_foreign` (`created_by`),
  ADD KEY `ic_manufacturers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_measurement_units`
--
ALTER TABLE `ic_measurement_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_measurement_units_name_index` (`name`),
  ADD KEY `ic_measurement_units_created_by_foreign` (`created_by`),
  ADD KEY `ic_measurement_units_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_migrations`
--
ALTER TABLE `ic_migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ic_model_has_permissions`
--
ALTER TABLE `ic_model_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  ADD KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `ic_model_has_roles`
--
ALTER TABLE `ic_model_has_roles`
  ADD PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  ADD KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`);

--
-- Indexes for table `ic_password_resets`
--
ALTER TABLE `ic_password_resets`
  ADD KEY `ic_password_resets_email_index` (`email`);

--
-- Indexes for table `ic_permissions`
--
ALTER TABLE `ic_permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ic_products`
--
ALTER TABLE `ic_products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_products_name_index` (`name`),
  ADD KEY `ic_products_sku_index` (`sku`),
  ADD KEY `ic_products_barcode_index` (`barcode`),
  ADD KEY `ic_products_category_id_foreign` (`category_id`),
  ADD KEY `ic_products_brand_id_foreign` (`brand_id`),
  ADD KEY `ic_products_manufacturer_id_foreign` (`manufacturer_id`),
  ADD KEY `ic_products_weight_unit_id_foreign` (`weight_unit_id`),
  ADD KEY `ic_products_measurement_unit_id_foreign` (`measurement_unit_id`),
  ADD KEY `ic_products_created_by_foreign` (`created_by`),
  ADD KEY `ic_products_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_product_attributes`
--
ALTER TABLE `ic_product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_product_attributes_product_id_foreign` (`product_id`),
  ADD KEY `ic_product_attributes_attribute_id_foreign` (`attribute_id`),
  ADD KEY `ic_product_attributes_attribute_item_id_foreign` (`attribute_item_id`);

--
-- Indexes for table `ic_product_categories`
--
ALTER TABLE `ic_product_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_product_categories_name_index` (`name`),
  ADD KEY `ic_product_categories_parent_id_foreign` (`parent_id`),
  ADD KEY `ic_product_categories_created_by_foreign` (`created_by`),
  ADD KEY `ic_product_categories_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_product_stocks`
--
ALTER TABLE `ic_product_stocks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_product_stocks_product_id_foreign` (`product_id`),
  ADD KEY `ic_product_stocks_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `ic_product_stocks_attribute_id_foreign` (`attribute_id`),
  ADD KEY `ic_product_stocks_attribute_item_id_foreign` (`attribute_item_id`);

--
-- Indexes for table `ic_purchases`
--
ALTER TABLE `ic_purchases`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ic_purchases_purchase_number_unique` (`purchase_number`),
  ADD KEY `ic_purchases_supplier_id_foreign` (`supplier_id`),
  ADD KEY `ic_purchases_warehouse_id_foreign` (`warehouse_id`),
  ADD KEY `ic_purchases_country_foreign` (`country`),
  ADD KEY `ic_purchases_state_foreign` (`state`),
  ADD KEY `ic_purchases_city_foreign` (`city`),
  ADD KEY `ic_purchases_created_by_foreign` (`created_by`),
  ADD KEY `ic_purchases_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_purchases_cancel_by_foreign` (`cancel_by`);

--
-- Indexes for table `ic_purchase_items`
--
ALTER TABLE `ic_purchase_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_purchase_items_purchase_id_foreign` (`purchase_id`),
  ADD KEY `ic_purchase_items_product_id_foreign` (`product_id`),
  ADD KEY `ic_purchase_items_created_by_foreign` (`created_by`),
  ADD KEY `ic_purchase_items_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_purchase_items_product_stock_id_foreign` (`product_stock_id`);

--
-- Indexes for table `ic_purchase_item_receives`
--
ALTER TABLE `ic_purchase_item_receives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_purchase_item_receives_purchase_receive_id_foreign` (`purchase_receive_id`),
  ADD KEY `ic_purchase_item_receives_purchase_item_id_foreign` (`purchase_item_id`),
  ADD KEY `ic_purchase_item_receives_product_id_foreign` (`product_id`),
  ADD KEY `ic_purchase_item_receives_product_stock_id_foreign` (`product_stock_id`);

--
-- Indexes for table `ic_purchase_receives`
--
ALTER TABLE `ic_purchase_receives`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_purchase_receives_purchase_id_foreign` (`purchase_id`),
  ADD KEY `ic_purchase_receives_created_by_foreign` (`created_by`),
  ADD KEY `ic_purchase_receives_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_purchase_returns`
--
ALTER TABLE `ic_purchase_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_purchase_returns_purchase_id_foreign` (`purchase_id`),
  ADD KEY `ic_purchase_returns_created_by_foreign` (`created_by`),
  ADD KEY `ic_purchase_returns_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_purchase_return_items`
--
ALTER TABLE `ic_purchase_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_purchase_return_items_purchase_return_id_foreign` (`purchase_return_id`),
  ADD KEY `ic_purchase_return_items_purchase_item_id_foreign` (`purchase_item_id`),
  ADD KEY `ic_purchase_return_items_product_id_foreign` (`product_id`),
  ADD KEY `ic_purchase_return_items_created_by_foreign` (`created_by`),
  ADD KEY `ic_purchase_return_items_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_purchase_return_items_product_stock_id_foreign` (`product_stock_id`);

--
-- Indexes for table `ic_roles`
--
ALTER TABLE `ic_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ic_role_has_permissions`
--
ALTER TABLE `ic_role_has_permissions`
  ADD PRIMARY KEY (`permission_id`,`role_id`),
  ADD KEY `ic_role_has_permissions_role_id_foreign` (`role_id`);

--
-- Indexes for table `ic_sale_returns`
--
ALTER TABLE `ic_sale_returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_sale_returns_invoice_id_foreign` (`invoice_id`),
  ADD KEY `ic_sale_returns_created_by_foreign` (`created_by`),
  ADD KEY `ic_sale_returns_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_sale_return_items`
--
ALTER TABLE `ic_sale_return_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_sale_return_items_sale_return_id_foreign` (`sale_return_id`),
  ADD KEY `ic_sale_return_items_invoice_item_id_foreign` (`invoice_item_id`),
  ADD KEY `ic_sale_return_items_product_id_foreign` (`product_id`),
  ADD KEY `ic_sale_return_items_created_by_foreign` (`created_by`),
  ADD KEY `ic_sale_return_items_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_sale_return_items_product_stock_id_foreign` (`product_stock_id`);

--
-- Indexes for table `ic_sale_return_item_requests`
--
ALTER TABLE `ic_sale_return_item_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_sale_return_item_requests_sale_return_request_id_foreign` (`sale_return_request_id`),
  ADD KEY `ic_sale_return_item_requests_invoice_item_id_foreign` (`invoice_item_id`),
  ADD KEY `ic_sale_return_item_requests_product_id_foreign` (`product_id`),
  ADD KEY `ic_sale_return_item_requests_created_by_foreign` (`created_by`),
  ADD KEY `ic_sale_return_item_requests_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_sale_return_item_requests_product_stock_id_foreign` (`product_stock_id`);

--
-- Indexes for table `ic_sale_return_requests`
--
ALTER TABLE `ic_sale_return_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_sale_return_requests_invoice_id_foreign` (`invoice_id`),
  ADD KEY `ic_sale_return_requests_requested_by_foreign` (`requested_by`),
  ADD KEY `ic_sale_return_requests_status_updated_by_foreign` (`status_updated_by`),
  ADD KEY `ic_sale_return_requests_created_by_foreign` (`created_by`),
  ADD KEY `ic_sale_return_requests_updated_by_foreign` (`updated_by`),
  ADD KEY `ic_sale_return_requests_warehouse_id_foreign` (`warehouse_id`);

--
-- Indexes for table `ic_suppliers`
--
ALTER TABLE `ic_suppliers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_suppliers_country_foreign` (`country`),
  ADD KEY `ic_suppliers_state_foreign` (`state`),
  ADD KEY `ic_suppliers_city_foreign` (`city`),
  ADD KEY `ic_suppliers_created_by_foreign` (`created_by`),
  ADD KEY `ic_suppliers_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_system_cities`
--
ALTER TABLE `ic_system_cities`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_system_cities_created_by_foreign` (`created_by`),
  ADD KEY `ic_system_cities_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_system_countries`
--
ALTER TABLE `ic_system_countries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_system_countries_created_by_foreign` (`created_by`),
  ADD KEY `ic_system_countries_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_system_settings`
--
ALTER TABLE `ic_system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ic_system_states`
--
ALTER TABLE `ic_system_states`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_system_states_created_by_foreign` (`created_by`),
  ADD KEY `ic_system_states_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_users`
--
ALTER TABLE `ic_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ic_users_email_unique` (`email`),
  ADD KEY `ic_users_name_index` (`name`),
  ADD KEY `ic_users_email_index` (`email`);

--
-- Indexes for table `ic_warehouses`
--
ALTER TABLE `ic_warehouses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_warehouses_name_index` (`name`),
  ADD KEY `ic_warehouses_created_by_foreign` (`created_by`),
  ADD KEY `ic_warehouses_updated_by_foreign` (`updated_by`);

--
-- Indexes for table `ic_weight_units`
--
ALTER TABLE `ic_weight_units`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ic_weight_units_name_index` (`name`),
  ADD KEY `ic_weight_units_created_by_foreign` (`created_by`),
  ADD KEY `ic_weight_units_updated_by_foreign` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ic_attributes`
--
ALTER TABLE `ic_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_attribute_items`
--
ALTER TABLE `ic_attribute_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_brands`
--
ALTER TABLE `ic_brands`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_coupons`
--
ALTER TABLE `ic_coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_coupon_products`
--
ALTER TABLE `ic_coupon_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_customers`
--
ALTER TABLE `ic_customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ic_draft_invoices`
--
ALTER TABLE `ic_draft_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_draft_invoice_items`
--
ALTER TABLE `ic_draft_invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_expenses`
--
ALTER TABLE `ic_expenses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_expenses_categories`
--
ALTER TABLE `ic_expenses_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_expenses_files`
--
ALTER TABLE `ic_expenses_files`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_expenses_items`
--
ALTER TABLE `ic_expenses_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_failed_jobs`
--
ALTER TABLE `ic_failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_invoices`
--
ALTER TABLE `ic_invoices`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_invoice_items`
--
ALTER TABLE `ic_invoice_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_invoice_payments`
--
ALTER TABLE `ic_invoice_payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_manufacturers`
--
ALTER TABLE `ic_manufacturers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_measurement_units`
--
ALTER TABLE `ic_measurement_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_migrations`
--
ALTER TABLE `ic_migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `ic_permissions`
--
ALTER TABLE `ic_permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=141;

--
-- AUTO_INCREMENT for table `ic_products`
--
ALTER TABLE `ic_products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_product_attributes`
--
ALTER TABLE `ic_product_attributes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_product_categories`
--
ALTER TABLE `ic_product_categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_product_stocks`
--
ALTER TABLE `ic_product_stocks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_purchases`
--
ALTER TABLE `ic_purchases`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_purchase_items`
--
ALTER TABLE `ic_purchase_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_purchase_item_receives`
--
ALTER TABLE `ic_purchase_item_receives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_purchase_receives`
--
ALTER TABLE `ic_purchase_receives`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_purchase_returns`
--
ALTER TABLE `ic_purchase_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_purchase_return_items`
--
ALTER TABLE `ic_purchase_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_roles`
--
ALTER TABLE `ic_roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ic_sale_returns`
--
ALTER TABLE `ic_sale_returns`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_sale_return_items`
--
ALTER TABLE `ic_sale_return_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_sale_return_item_requests`
--
ALTER TABLE `ic_sale_return_item_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_sale_return_requests`
--
ALTER TABLE `ic_sale_return_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_suppliers`
--
ALTER TABLE `ic_suppliers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ic_system_cities`
--
ALTER TABLE `ic_system_cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_system_countries`
--
ALTER TABLE `ic_system_countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_system_settings`
--
ALTER TABLE `ic_system_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ic_system_states`
--
ALTER TABLE `ic_system_states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ic_users`
--
ALTER TABLE `ic_users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `ic_warehouses`
--
ALTER TABLE `ic_warehouses`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ic_weight_units`
--
ALTER TABLE `ic_weight_units`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ic_attributes`
--
ALTER TABLE `ic_attributes`
  ADD CONSTRAINT `ic_attributes_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_attributes_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_attribute_items`
--
ALTER TABLE `ic_attribute_items`
  ADD CONSTRAINT `ic_attribute_items_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `ic_attributes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ic_attribute_items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_attribute_items_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_brands`
--
ALTER TABLE `ic_brands`
  ADD CONSTRAINT `ic_brands_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_brands_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_coupons`
--
ALTER TABLE `ic_coupons`
  ADD CONSTRAINT `ic_coupons_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_coupons_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_coupon_products`
--
ALTER TABLE `ic_coupon_products`
  ADD CONSTRAINT `ic_coupon_products_coupon_id_foreign` FOREIGN KEY (`coupon_id`) REFERENCES `ic_coupons` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ic_coupon_products_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ic_customers`
--
ALTER TABLE `ic_customers`
  ADD CONSTRAINT `ic_customers_b_city_foreign` FOREIGN KEY (`b_city`) REFERENCES `ic_system_cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_customers_b_country_foreign` FOREIGN KEY (`b_country`) REFERENCES `ic_system_countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_customers_b_state_foreign` FOREIGN KEY (`b_state`) REFERENCES `ic_system_states` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_customers_city_foreign` FOREIGN KEY (`city`) REFERENCES `ic_system_cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_customers_country_foreign` FOREIGN KEY (`country`) REFERENCES `ic_system_countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_customers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_customers_state_foreign` FOREIGN KEY (`state`) REFERENCES `ic_system_states` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_customers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_draft_invoices`
--
ALTER TABLE `ic_draft_invoices`
  ADD CONSTRAINT `ic_draft_invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_draft_invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `ic_customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_draft_invoices_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_draft_invoices_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ic_warehouses` (`id`);

--
-- Constraints for table `ic_draft_invoice_items`
--
ALTER TABLE `ic_draft_invoice_items`
  ADD CONSTRAINT `ic_draft_invoice_items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_draft_invoice_items_draft_invoice_id_foreign` FOREIGN KEY (`draft_invoice_id`) REFERENCES `ic_draft_invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ic_draft_invoice_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `ic_draft_invoice_items_product_stock_id_foreign` FOREIGN KEY (`product_stock_id`) REFERENCES `ic_product_stocks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_draft_invoice_items_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_customers` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_expenses`
--
ALTER TABLE `ic_expenses`
  ADD CONSTRAINT `ic_expenses_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `ic_expenses_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_expenses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_expenses_expense_by_foreign` FOREIGN KEY (`expense_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_expenses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_expenses_categories`
--
ALTER TABLE `ic_expenses_categories`
  ADD CONSTRAINT `ic_expenses_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_expenses_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_expenses_files`
--
ALTER TABLE `ic_expenses_files`
  ADD CONSTRAINT `ic_expenses_files_expenses_id_foreign` FOREIGN KEY (`expenses_id`) REFERENCES `ic_expenses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ic_expenses_items`
--
ALTER TABLE `ic_expenses_items`
  ADD CONSTRAINT `ic_expenses_items_expenses_id_foreign` FOREIGN KEY (`expenses_id`) REFERENCES `ic_expenses` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ic_invoices`
--
ALTER TABLE `ic_invoices`
  ADD CONSTRAINT `ic_invoices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_invoices_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `ic_customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_invoices_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_invoices_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ic_warehouses` (`id`);

--
-- Constraints for table `ic_invoice_items`
--
ALTER TABLE `ic_invoice_items`
  ADD CONSTRAINT `ic_invoice_items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_invoice_items_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `ic_invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ic_invoice_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`) ON DELETE NO ACTION,
  ADD CONSTRAINT `ic_invoice_items_product_stock_id_foreign` FOREIGN KEY (`product_stock_id`) REFERENCES `ic_product_stocks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_invoice_items_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_invoice_payments`
--
ALTER TABLE `ic_invoice_payments`
  ADD CONSTRAINT `ic_invoice_payments_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_invoice_payments_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `ic_invoices` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ic_invoice_payments_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_manufacturers`
--
ALTER TABLE `ic_manufacturers`
  ADD CONSTRAINT `ic_manufacturers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_manufacturers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_measurement_units`
--
ALTER TABLE `ic_measurement_units`
  ADD CONSTRAINT `ic_measurement_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_measurement_units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_model_has_permissions`
--
ALTER TABLE `ic_model_has_permissions`
  ADD CONSTRAINT `ic_model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `ic_permissions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ic_model_has_roles`
--
ALTER TABLE `ic_model_has_roles`
  ADD CONSTRAINT `ic_model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `ic_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ic_products`
--
ALTER TABLE `ic_products`
  ADD CONSTRAINT `ic_products_brand_id_foreign` FOREIGN KEY (`brand_id`) REFERENCES `ic_brands` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_products_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `ic_product_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_products_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_products_manufacturer_id_foreign` FOREIGN KEY (`manufacturer_id`) REFERENCES `ic_manufacturers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_products_measurement_unit_id_foreign` FOREIGN KEY (`measurement_unit_id`) REFERENCES `ic_measurement_units` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_products_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_products_weight_unit_id_foreign` FOREIGN KEY (`weight_unit_id`) REFERENCES `ic_weight_units` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_product_attributes`
--
ALTER TABLE `ic_product_attributes`
  ADD CONSTRAINT `ic_product_attributes_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `ic_attributes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_product_attributes_attribute_item_id_foreign` FOREIGN KEY (`attribute_item_id`) REFERENCES `ic_attribute_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_product_attributes_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ic_product_categories`
--
ALTER TABLE `ic_product_categories`
  ADD CONSTRAINT `ic_product_categories_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_product_categories_parent_id_foreign` FOREIGN KEY (`parent_id`) REFERENCES `ic_product_categories` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_product_categories_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_product_stocks`
--
ALTER TABLE `ic_product_stocks`
  ADD CONSTRAINT `ic_product_stocks_attribute_id_foreign` FOREIGN KEY (`attribute_id`) REFERENCES `ic_attributes` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_product_stocks_attribute_item_id_foreign` FOREIGN KEY (`attribute_item_id`) REFERENCES `ic_attribute_items` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_product_stocks_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ic_product_stocks_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ic_warehouses` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_purchases`
--
ALTER TABLE `ic_purchases`
  ADD CONSTRAINT `ic_purchases_cancel_by_foreign` FOREIGN KEY (`cancel_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchases_city_foreign` FOREIGN KEY (`city`) REFERENCES `ic_system_cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchases_country_foreign` FOREIGN KEY (`country`) REFERENCES `ic_system_countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchases_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchases_state_foreign` FOREIGN KEY (`state`) REFERENCES `ic_system_states` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchases_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `ic_suppliers` (`id`),
  ADD CONSTRAINT `ic_purchases_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchases_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ic_warehouses` (`id`);

--
-- Constraints for table `ic_purchase_items`
--
ALTER TABLE `ic_purchase_items`
  ADD CONSTRAINT `ic_purchase_items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchase_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`),
  ADD CONSTRAINT `ic_purchase_items_product_stock_id_foreign` FOREIGN KEY (`product_stock_id`) REFERENCES `ic_product_stocks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchase_items_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `ic_purchases` (`id`),
  ADD CONSTRAINT `ic_purchase_items_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_purchase_item_receives`
--
ALTER TABLE `ic_purchase_item_receives`
  ADD CONSTRAINT `ic_purchase_item_receives_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`),
  ADD CONSTRAINT `ic_purchase_item_receives_product_stock_id_foreign` FOREIGN KEY (`product_stock_id`) REFERENCES `ic_product_stocks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchase_item_receives_purchase_item_id_foreign` FOREIGN KEY (`purchase_item_id`) REFERENCES `ic_purchase_items` (`id`),
  ADD CONSTRAINT `ic_purchase_item_receives_purchase_receive_id_foreign` FOREIGN KEY (`purchase_receive_id`) REFERENCES `ic_purchase_receives` (`id`);

--
-- Constraints for table `ic_purchase_receives`
--
ALTER TABLE `ic_purchase_receives`
  ADD CONSTRAINT `ic_purchase_receives_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchase_receives_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `ic_purchases` (`id`),
  ADD CONSTRAINT `ic_purchase_receives_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_purchase_returns`
--
ALTER TABLE `ic_purchase_returns`
  ADD CONSTRAINT `ic_purchase_returns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchase_returns_purchase_id_foreign` FOREIGN KEY (`purchase_id`) REFERENCES `ic_purchases` (`id`),
  ADD CONSTRAINT `ic_purchase_returns_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_purchase_return_items`
--
ALTER TABLE `ic_purchase_return_items`
  ADD CONSTRAINT `ic_purchase_return_items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchase_return_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`),
  ADD CONSTRAINT `ic_purchase_return_items_product_stock_id_foreign` FOREIGN KEY (`product_stock_id`) REFERENCES `ic_product_stocks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_purchase_return_items_purchase_item_id_foreign` FOREIGN KEY (`purchase_item_id`) REFERENCES `ic_purchase_items` (`id`),
  ADD CONSTRAINT `ic_purchase_return_items_purchase_return_id_foreign` FOREIGN KEY (`purchase_return_id`) REFERENCES `ic_purchase_returns` (`id`),
  ADD CONSTRAINT `ic_purchase_return_items_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_role_has_permissions`
--
ALTER TABLE `ic_role_has_permissions`
  ADD CONSTRAINT `ic_role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `ic_permissions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ic_role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `ic_roles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ic_sale_returns`
--
ALTER TABLE `ic_sale_returns`
  ADD CONSTRAINT `ic_sale_returns_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_sale_returns_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `ic_invoices` (`id`),
  ADD CONSTRAINT `ic_sale_returns_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_sale_return_items`
--
ALTER TABLE `ic_sale_return_items`
  ADD CONSTRAINT `ic_sale_return_items_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_sale_return_items_invoice_item_id_foreign` FOREIGN KEY (`invoice_item_id`) REFERENCES `ic_invoice_items` (`id`),
  ADD CONSTRAINT `ic_sale_return_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`),
  ADD CONSTRAINT `ic_sale_return_items_product_stock_id_foreign` FOREIGN KEY (`product_stock_id`) REFERENCES `ic_product_stocks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_sale_return_items_sale_return_id_foreign` FOREIGN KEY (`sale_return_id`) REFERENCES `ic_sale_returns` (`id`),
  ADD CONSTRAINT `ic_sale_return_items_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_sale_return_item_requests`
--
ALTER TABLE `ic_sale_return_item_requests`
  ADD CONSTRAINT `ic_sale_return_item_requests_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_sale_return_item_requests_invoice_item_id_foreign` FOREIGN KEY (`invoice_item_id`) REFERENCES `ic_invoice_items` (`id`),
  ADD CONSTRAINT `ic_sale_return_item_requests_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `ic_products` (`id`),
  ADD CONSTRAINT `ic_sale_return_item_requests_product_stock_id_foreign` FOREIGN KEY (`product_stock_id`) REFERENCES `ic_product_stocks` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_sale_return_item_requests_sale_return_request_id_foreign` FOREIGN KEY (`sale_return_request_id`) REFERENCES `ic_sale_return_requests` (`id`),
  ADD CONSTRAINT `ic_sale_return_item_requests_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_sale_return_requests`
--
ALTER TABLE `ic_sale_return_requests`
  ADD CONSTRAINT `ic_sale_return_requests_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_sale_return_requests_invoice_id_foreign` FOREIGN KEY (`invoice_id`) REFERENCES `ic_invoices` (`id`),
  ADD CONSTRAINT `ic_sale_return_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `ic_customers` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_sale_return_requests_status_updated_by_foreign` FOREIGN KEY (`status_updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_sale_return_requests_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_sale_return_requests_warehouse_id_foreign` FOREIGN KEY (`warehouse_id`) REFERENCES `ic_warehouses` (`id`);

--
-- Constraints for table `ic_suppliers`
--
ALTER TABLE `ic_suppliers`
  ADD CONSTRAINT `ic_suppliers_city_foreign` FOREIGN KEY (`city`) REFERENCES `ic_system_cities` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_suppliers_country_foreign` FOREIGN KEY (`country`) REFERENCES `ic_system_countries` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_suppliers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_suppliers_state_foreign` FOREIGN KEY (`state`) REFERENCES `ic_system_states` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_suppliers_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_system_cities`
--
ALTER TABLE `ic_system_cities`
  ADD CONSTRAINT `ic_system_cities_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_system_cities_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_system_countries`
--
ALTER TABLE `ic_system_countries`
  ADD CONSTRAINT `ic_system_countries_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_system_countries_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_system_states`
--
ALTER TABLE `ic_system_states`
  ADD CONSTRAINT `ic_system_states_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_system_states_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_warehouses`
--
ALTER TABLE `ic_warehouses`
  ADD CONSTRAINT `ic_warehouses_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_warehouses_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `ic_weight_units`
--
ALTER TABLE `ic_weight_units`
  ADD CONSTRAINT `ic_weight_units_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ic_weight_units_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ic_users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
