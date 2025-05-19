-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 09:35 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vibeplan_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_events`
--

CREATE TABLE `custom_events` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `event_request_id` bigint(20) UNSIGNED NOT NULL,
  `organizer_id` bigint(20) UNSIGNED NOT NULL,
  `finalized_date` date DEFAULT NULL,
  `total_price` decimal(12,2) NOT NULL,
  `notes` text DEFAULT NULL,
  `status` enum('draft','confirmed','cancelled','inprogress') NOT NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `custom_events`
--

INSERT INTO `custom_events` (`id`, `event_request_id`, `organizer_id`, `finalized_date`, `total_price`, `notes`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 2, '2025-05-21', 80000.00, 'Includes catering and decoration', 'confirmed', '2025-05-05 23:01:11', '2025-05-10 20:47:16', NULL),
(4, 3, 2, '2025-07-26', 200000.00, 'Mr John\'s Moms Birthday at Hilton', 'inprogress', '2025-05-19 05:11:24', '2025-05-19 05:11:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_inventory_orders`
--

CREATE TABLE `event_inventory_orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `custom_event_id` bigint(20) UNSIGNED NOT NULL,
  `inventory_item_id` bigint(20) UNSIGNED NOT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_inventory_orders`
--

INSERT INTO `event_inventory_orders` (`id`, `custom_event_id`, `inventory_item_id`, `quantity`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 50, 'approved', '2025-05-05 23:01:11', '2025-05-10 21:45:34', NULL),
(2, 1, 5, 50, 'pending', '2025-05-19 02:29:18', '2025-05-19 02:29:18', NULL),
(3, 1, 1, 20, 'pending', '2025-05-19 05:13:06', '2025-05-19 05:13:06', NULL),
(4, 4, 1, 10, 'pending', '2025-05-19 06:03:38', '2025-05-19 06:03:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_requests`
--

CREATE TABLE `event_requests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `event_type_id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `event_date` date NOT NULL,
  `guest_count` int(11) NOT NULL,
  `location` varchar(255) NOT NULL,
  `status` enum('pending','approved','rejected','completed') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `event_requests`
--

INSERT INTO `event_requests` (`id`, `customer_id`, `event_type_id`, `title`, `description`, `event_date`, `guest_count`, `location`, `status`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'John’s 30th Birthday', 'Surprise birthday party', '2025-05-21', 40, 'Colombo City Hall', 'approved', '2025-05-05 23:01:11', '2025-05-19 03:59:16', NULL),
(2, 1, 5, 'John Engagement', 'John Engagement Description', '2025-07-26', 100, 'Hilton', 'pending', '2025-05-19 09:58:12', NULL, NULL),
(3, 1, 1, 'My Moms Birthday', 'My Moms Birthday', '2025-07-26', 100, 'Hilton', 'approved', '2025-05-19 10:00:53', '2025-05-19 05:11:07', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `event_types`
--

CREATE TABLE `event_types` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `locations` varchar(255) NOT NULL,
  `starting_price` varchar(255) NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `added_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event_types`
--

INSERT INTO `event_types` (`id`, `name`, `description`, `locations`, `starting_price`, `image_url`, `added_by`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Birth Day', 'Birth Day Event', 'Shrangila, Hilton', '200', NULL, 2, '2025-05-09 00:33:37', NULL, NULL),
(2, 'Wedding', 'Wedding', 'Cinnamon Life, Shrangila', '400', 'public/event-types/uQA3KIuLOqjc4tXkD7jI7EeNekkWSNaCRUNRWl1j.png', 4, '2025-05-09 19:43:31', '2025-05-09 19:49:22', NULL),
(3, 'Conference', 'Non ut fugiat a ut e', 'Animi veritatis est', '593', NULL, 4, '2025-05-09 19:52:59', '2025-05-16 15:15:18', NULL),
(4, 'Anniversary Celebration', 'Officiis sed dolorib', 'Adipisci voluptas ex', '777', 'public/event-types/uQA3KIuLOqjc4tXkD7jI7EeNekkWSNaCRUNRWl1j.png', 4, '2025-05-09 20:04:30', '2025-05-16 15:15:08', NULL),
(5, 'Engagement', 'Dolor suscipit ea ar', 'Fuga Tempor magnam', '94', 'event-types/Utu1Y2LbJePmnB2qWiRNXrCS3kaxNHobwYbfKgOl.png', 4, '2025-05-09 20:22:56', '2025-05-16 15:14:56', NULL),
(6, 'Graduation Party', 'Occaecat consequatur', 'Debitis explicabo N', '626', 'event-types/ObjpaTBGuNVzt32j2dxaU85vpXEGS8Lb1SjJ2j1U.png', 4, '2025-05-09 20:27:24', '2025-05-16 15:14:45', NULL),
(7, 'Gender Reveal Party', 'Fluckshi', 'Fluckshi', '20', 'event-types/nyBiuy6UhU994jMDhZowrTo3JzHkwmflhkEbQNhS.png', 4, '2025-05-09 21:27:47', '2025-05-16 15:13:48', NULL),
(8, 'Outdoor Wedding', 'Ut eaque odio cumque', 'Velit irure laboris', '226', 'event-types/YgLD2Z9oCLFSFJLBmwyftZX9WnIyoimdVZLNuKAh.png', 4, '2025-05-11 13:54:38', '2025-05-16 15:13:22', NULL),
(9, 'Outdoor Engagement', 'Outdoor Engagement', 'Shrangila, Hilton', '400', 'event-types/LFHSpRuKRxDjAiJSTYuzQrQschkyxqbsp437Y5YD.png', 4, '2025-05-17 07:57:00', '2025-05-17 07:57:00', NULL),
(10, 'Graduation Party Updated', 'Graduation Party', 'Hilton', '4000', 'event-types/bENoWwbLt166ToyypbBtaOtgy2KzWg5viiwH13g4.jpg', 10, '2025-05-17 09:58:18', '2025-05-17 12:20:30', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `inventory_items`
--

CREATE TABLE `inventory_items` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `inventory_staff_id` bigint(20) UNSIGNED NOT NULL,
  `item_name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `quantity_available` int(11) NOT NULL,
  `price_per_unit` decimal(10,2) NOT NULL,
  `item_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `inventory_items`
--

INSERT INTO `inventory_items` (`id`, `inventory_staff_id`, `item_name`, `description`, `quantity_available`, `price_per_unit`, `item_image`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 3, 'Chairs', 'Plastic chairs', 100, 100.00, NULL, '2025-05-10 16:18:43', NULL, NULL),
(2, 3, 'Tables', 'Wooden tables', 150, 120.00, NULL, '2025-05-10 16:21:24', '2025-05-10 11:36:47', NULL),
(3, 8, 'Flower Boquets', 'Fresh flower Boquets', 100, 10000.00, NULL, '2025-05-11 11:31:41', '2025-05-10 11:31:41', NULL),
(4, 3, 'Baloons', 'Baloons', 10000, 100.00, NULL, '2025-05-18 20:53:50', '2025-05-18 20:53:50', NULL),
(5, 3, 'Microphones', 'Microphones', 100, 2500.00, NULL, '2025-05-18 21:22:38', '2025-05-18 21:22:38', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000001_create_cache_table', 1),
(2, '0001_01_01_000002_create_jobs_table', 1),
(3, '2025_05_06_034931_create_users_table', 1),
(4, '2025_05_06_040116_create_event_types_table', 2),
(5, '2025_05_06_040302_create_inventory_items_table', 2),
(6, '2025_05_06_040406_create_event_requests_table', 2),
(7, '2025_05_06_040453_create_custom_events_table', 2),
(8, '2025_05_06_040534_create_payments_table', 2),
(9, '2025_05_06_040609_create_event_inventory_orders_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` bigint(20) UNSIGNED NOT NULL,
  `custom_event_id` bigint(20) UNSIGNED NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `payment_method` varchar(255) NOT NULL,
  `payment_status` enum('pending','paid','failed') NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `customer_id`, `custom_event_id`, `amount`, `payment_method`, `payment_status`, `paid_at`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 50000.00, 'Credit Card', 'paid', '2025-05-05 23:01:11', '2025-05-05 23:01:11', '2025-05-19 03:26:06', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('dSWASjZVQ1eog2japYEFM4VzX4BdpBctYWAWNupQ', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/136.0.0.0 Safari/537.36', 'YTo1OntzOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo0NjoiaHR0cDovLzEyNy4wLjAuMTo4MDAwL2V2ZW50LW9yZ2FuaXplci9wYXltZW50cyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NjoiX3Rva2VuIjtzOjQwOiJ2eFJKdktXdGtuNjA2cWRXcUUyYm1Vb3BRNk5kdDlMdnl2S3c4RHkyIjtzOjE4OiJmbGFzaGVyOjplbnZlbG9wZXMiO2E6MDp7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==', 1747655459);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `active_status` varchar(255) DEFAULT '1',
  `profile_image` varchar(255) DEFAULT NULL,
  `role` enum('customer','event_organizer','inventory_staff','admin') NOT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `phone_number`, `address`, `active_status`, `profile_image`, `role`, `password`, `remember_token`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'John Customer', 'customer@gmail.com', NULL, '0771234567', 'Colombo', '1', NULL, 'customer', '$2y$12$JYlWXtzomEycPkFDsQ3PM.bDNDAuJmRzfw3cgSiRmSs/rWxQxCtn2', NULL, '2025-05-09 17:30:10', '2025-05-16 07:53:33', NULL),
(2, 'Jane Organizer', 'organizer@gmail.com', NULL, '0777654321', 'Colombo', '1', NULL, 'event_organizer', '$2y$12$JYlWXtzomEycPkFDsQ3PM.bDNDAuJmRzfw3cgSiRmSs/rWxQxCtn2', NULL, '2025-05-09 17:30:10', '2025-05-16 07:53:47', NULL),
(3, 'Sam Inventory', 'inventory@gmail.com', NULL, '0779876543', 'Colombo', '1', NULL, 'inventory_staff', '$2y$12$JYlWXtzomEycPkFDsQ3PM.bDNDAuJmRzfw3cgSiRmSs/rWxQxCtn2', NULL, '2025-05-09 17:30:10', NULL, NULL),
(4, 'Admin', 'admin@gmail.com', NULL, '0779999999', 'Colombo', '1', NULL, 'admin', '$2y$12$JYlWXtzomEycPkFDsQ3PM.bDNDAuJmRzfw3cgSiRmSs/rWxQxCtn2', NULL, '2025-05-09 17:30:10', NULL, NULL),
(5, 'Janani Mayadunna', 'janani@gmail.com', NULL, '0715225252', 'Kandy', '1', NULL, 'customer', '$2y$12$JYlWXtzomEycPkFDsQ3PM.bDNDAuJmRzfw3cgSiRmSs/rWxQxCtn2', NULL, '2025-05-09 22:01:06', NULL, NULL),
(6, 'Robert Ashley', 'robert@gmail.com', NULL, '1105966977', 'Kadana', '1', NULL, 'customer', '$2y$12$oPeWJUEnq9.8FusO1r4seuJbdj2cfvReXXRzzCWyQuTdNwqqzZKhK', NULL, '2025-05-10 17:20:12', '2025-05-09 17:50:54', NULL),
(7, 'Lamar Sloan', 'lamar@gmail.com', NULL, '1527128640', 'Kadawatha', '1', NULL, 'event_organizer', '$2y$12$obHcmioMf3ChXbTZNkicPOhkR6JB84zGjIHPodxUyPgwIMer92X8C', NULL, '2025-05-09 17:30:10', '2025-05-09 17:30:10', NULL),
(8, 'Lillian Conner', 'lillian@gmail.com', NULL, '1972595541', 'JaEla', '1', NULL, 'inventory_staff', '$2y$12$AMInpnhxJBZ3imOwiqPbx.cV9wI77fHbZpq3ZqRJDXSp7oeda0die', NULL, '2025-05-09 17:44:41', '2025-05-09 17:44:41', NULL),
(9, 'Shashini', 'shashini@gmail.com', NULL, '0716848828', 'Kandy', '1', NULL, 'event_organizer', '$2y$12$SUq7PmMgEtaYaecU2osLlOvr7aUWyhz.c5b/YbZj3Y/Qb9/FlJJme', NULL, '2025-05-11 13:52:40', '2025-05-11 13:52:59', NULL),
(10, 'Lewis Cox', 'event@organizer.com', NULL, '1522246938', 'Neque quas illo eius', '1', NULL, 'event_organizer', '$2y$12$JYlWXtzomEycPkFDsQ3PM.bDNDAuJmRzfw3cgSiRmSs/rWxQxCtn2', NULL, '2025-05-16 07:55:36', '2025-05-16 07:55:36', NULL),
(11, 'Steven Wiley', 'wiley@gmail.com', NULL, '1807205350', 'Consequat Voluptate', '1', NULL, 'customer', '$2y$12$5ON.3Hn3I/Uz3pAlpYMrR.2KXUhR8YGVjsnltfQID83obvn1NnM9K', NULL, '2025-05-16 11:18:51', '2025-05-16 11:18:51', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `custom_events`
--
ALTER TABLE `custom_events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `custom_events_event_request_id_foreign` (`event_request_id`),
  ADD KEY `custom_events_organizer_id_foreign` (`organizer_id`);

--
-- Indexes for table `event_inventory_orders`
--
ALTER TABLE `event_inventory_orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_inventory_orders_custom_event_id_foreign` (`custom_event_id`),
  ADD KEY `event_inventory_orders_inventory_item_id_foreign` (`inventory_item_id`);

--
-- Indexes for table `event_requests`
--
ALTER TABLE `event_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_requests_customer_id_foreign` (`customer_id`),
  ADD KEY `event_requests_event_type_id_foreign` (`event_type_id`);

--
-- Indexes for table `event_types`
--
ALTER TABLE `event_types`
  ADD PRIMARY KEY (`id`),
  ADD KEY `event_types_added_by_foreign` (`added_by`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `inventory_items_inventory_staff_id_foreign` (`inventory_staff_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_customer_id_foreign` (`customer_id`),
  ADD KEY `payments_custom_event_id_foreign` (`custom_event_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `custom_events`
--
ALTER TABLE `custom_events`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_inventory_orders`
--
ALTER TABLE `event_inventory_orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `event_requests`
--
ALTER TABLE `event_requests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `event_types`
--
ALTER TABLE `event_types`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `inventory_items`
--
ALTER TABLE `inventory_items`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `custom_events`
--
ALTER TABLE `custom_events`
  ADD CONSTRAINT `custom_events_event_request_id_foreign` FOREIGN KEY (`event_request_id`) REFERENCES `event_requests` (`id`),
  ADD CONSTRAINT `custom_events_organizer_id_foreign` FOREIGN KEY (`organizer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `event_inventory_orders`
--
ALTER TABLE `event_inventory_orders`
  ADD CONSTRAINT `event_inventory_orders_custom_event_id_foreign` FOREIGN KEY (`custom_event_id`) REFERENCES `custom_events` (`id`),
  ADD CONSTRAINT `event_inventory_orders_inventory_item_id_foreign` FOREIGN KEY (`inventory_item_id`) REFERENCES `inventory_items` (`id`);

--
-- Constraints for table `event_requests`
--
ALTER TABLE `event_requests`
  ADD CONSTRAINT `event_requests_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `event_requests_event_type_id_foreign` FOREIGN KEY (`event_type_id`) REFERENCES `event_types` (`id`);

--
-- Constraints for table `event_types`
--
ALTER TABLE `event_types`
  ADD CONSTRAINT `event_types_added_by_foreign` FOREIGN KEY (`added_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `inventory_items`
--
ALTER TABLE `inventory_items`
  ADD CONSTRAINT `inventory_items_inventory_staff_id_foreign` FOREIGN KEY (`inventory_staff_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_custom_event_id_foreign` FOREIGN KEY (`custom_event_id`) REFERENCES `custom_events` (`id`),
  ADD CONSTRAINT `payments_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
