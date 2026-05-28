-- ============================================================
-- PcpartsVes - Full SQL Dump
-- Import this in phpMyAdmin or run in MySQL CLI
-- ============================================================

CREATE DATABASE IF NOT EXISTS `pcparts_ves`
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;

USE `pcparts_ves`;

-- ----------------------------
-- Table: users
-- ----------------------------
CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `address` varchar(500) DEFAULT NULL,
  `gender` varchar(50) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: password_reset_tokens
-- ----------------------------
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: sessions
-- ----------------------------
CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: cache
-- ----------------------------
CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: cache_locks
-- ----------------------------
CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: jobs
-- ----------------------------
CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: job_batches
-- ----------------------------
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
  `finished_at` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: failed_jobs
-- ----------------------------
CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Table: pc_parts
-- ----------------------------
CREATE TABLE `pc_parts` (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `brand` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1,
  `description` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pc_parts_user_id_foreign` (`user_id`),
  CONSTRAINT `pc_parts_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Sample Data: users
-- Passwords are all: password123
-- (bcrypt hash of "password123")
-- ----------------------------
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `address`, `gender`, `phone`, `profile_picture`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin User',    'admin@pcparts.com',  NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'Quezon City, Metro Manila', 'Male',   '+63 912 345 6789', NULL, NULL, NOW(), NOW()),
(2, 'Juan Dela Cruz','juan@email.com',     NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user',  'Cebu City, Cebu',           'Male',   '+63 923 456 7890', NULL, NULL, NOW(), NOW()),
(3, 'Maria Santos',  'maria@email.com',    NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user',  'Davao City, Davao del Sur', 'Female', '+63 934 567 8901', NULL, NULL, NOW(), NOW()),
(4, 'Pedro Reyes',   'pedro@email.com',    NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user',  'Makati City, Metro Manila', 'Male',   '+63 945 678 9012', NULL, NULL, NOW(), NOW()),
(5, 'Ana Gonzales',  'ana@email.com',      NOW(), '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user',  'Pasig City, Metro Manila',  'Female', '+63 956 789 0123', NULL, NULL, NOW(), NOW());

-- ----------------------------
-- Sample Data: pc_parts
-- ----------------------------
INSERT INTO `pc_parts` (`user_id`, `name`, `category`, `brand`, `price`, `quantity`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Ryzen 5 5600X',           'CPU',         'AMD',     14500.00, 3, '6-core 12-thread desktop processor, 3.7GHz base clock',                    NOW(), NOW()),
(1, 'RTX 3060 Ti',             'GPU',         'NVIDIA',  22000.00, 2, '8GB GDDR6 graphics card, excellent 1080p and 1440p gaming',                 NOW(), NOW()),
(1, 'Corsair Vengeance 16GB',  'RAM',         'Corsair', 3200.00,  4, 'DDR4 3200MHz CL16, 2x8GB dual channel kit',                                NOW(), NOW()),
(2, 'Core i5-12400F',          'CPU',         'Intel',   12000.00, 2, '6-core 12-thread, 2.5GHz base, no integrated graphics',                    NOW(), NOW()),
(2, 'B550M DS3H',              'Motherboard', 'Gigabyte',4500.00,  1, 'Micro-ATX AM4 motherboard, supports PCIe 4.0',                             NOW(), NOW()),
(2, 'Samsung 970 EVO 500GB',   'Storage',     'Samsung', 3800.00,  2, 'NVMe M.2 SSD, 3500MB/s read speed',                                        NOW(), NOW()),
(3, 'RX 6600 XT',              'GPU',         'AMD',     18500.00, 1, '8GB GDDR6, great 1080p performance',                                       NOW(), NOW()),
(3, 'Cooler Master Hyper 212', 'Cooling',     'Cooler Master', 1800.00, 3, 'Air CPU cooler, 120mm fan, compatible with AM4 and LGA1700',           NOW(), NOW()),
(3, 'EVGA 650W Gold',          'PSU',         'EVGA',    5500.00,  2, '650W 80+ Gold certified, fully modular',                                   NOW(), NOW()),
(4, 'NZXT H510',               'Case',        'NZXT',    5200.00,  1, 'Mid-tower ATX case, tempered glass side panel',                            NOW(), NOW()),
(4, 'Kingston 1TB SSD',        'Storage',     'Kingston',2800.00,  5, 'SATA III 2.5-inch SSD, 550MB/s read',                                     NOW(), NOW()),
(5, 'LG 27" 144Hz Monitor',    'Monitor',     'LG',      14000.00, 1, '1080p IPS panel, 144Hz refresh rate, 1ms response time',                   NOW(), NOW()),
(5, 'Logitech G Pro X',        'Peripherals', 'Logitech',4500.00,  2, 'Mechanical gaming keyboard, swappable switches',                           NOW(), NOW()),
(1, 'Seagate 2TB HDD',         'Storage',     'Seagate', 2500.00,  6, '7200RPM 3.5-inch hard drive, 256MB cache',                                 NOW(), NOW()),
(2, 'Razer DeathAdder V2',     'Peripherals', 'Razer',   3200.00,  3, 'Ergonomic gaming mouse, 20000 DPI optical sensor',                         NOW(), NOW());
