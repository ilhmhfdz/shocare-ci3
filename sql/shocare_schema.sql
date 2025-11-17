-- shocare_schema.sql
-- Converted & cleaned from original db dump (items / service_requests / users)
-- - harga (varchar) converted to price DECIMAL
-- - offensive text sanitized
-- - preserves original ids where reasonable
-- - use this file to initialize the database for Shocare web app

CREATE DATABASE IF NOT EXISTS `shocare_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `shocare_db`;

-- Drop tables if exist (uncomment if you want reset)
-- DROP TABLE IF EXISTS `service_requests`;
-- DROP TABLE IF EXISTS `items`;
-- DROP TABLE IF EXISTS `users`;

/* -------------------------
   Table: items
   (converted harga -> price DECIMAL)
   ------------------------- */
CREATE TABLE IF NOT EXISTS `items` (
  `id` INT(11) NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `price` DECIMAL(12,2) NOT NULL DEFAULT 0.00,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert items (cleaned descriptions where needed)
INSERT INTO `items` (`id`, `name`, `description`, `price`, `created_at`, `image`) VALUES
(21, 'Service Batre', 'Baterai HP: penggantian/servis baterai Lithium-ion.', 50000.00, '2025-06-11 04:02:48', '289622a582f9b041a33e81efed0f6a8b.jpg'),
(22, 'Service Screen', 'Ganti screen HP Android dan iPhone.', 100000.00, '2025-06-11 04:12:12', 'c7ec5f73c0c5c0899d33c354d23f6d79.png'),
(23, 'Service TWS', 'Servis TWS berbagai merk: penggantian baterai dan perbaikan kecil.', 125000.00, '2025-06-11 04:15:27', 'b07e266f588bbdefda8b163c3e2aad42.jpg'),
(25, 'Misc Service', 'Deskripsi layanan contoh (telah disanitasi).', 10000.00, '2025-06-11 05:23:11', '5b58252e383d94c9ae17ba43bb2abe18.jpg');

-- Set AUTO_INCREMENT for items so new inserts keep increasing
ALTER TABLE `items` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;


/* -------------------------
   Table: service_requests
   (keperluan: menyimpan permintaan layanan / order)
   ------------------------- */
CREATE TABLE IF NOT EXISTS `service_requests` (
  `id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `service_id` INT(11) NOT NULL,
  `description` TEXT DEFAULT NULL,
  `status` ENUM('pending','processed','completed','rejected') NOT NULL DEFAULT 'pending',
  `admin_notes` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id_idx` (`user_id`),
  KEY `service_id_idx` (`service_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert service_requests (cleaned descriptions)
INSERT INTO `service_requests` (`id`, `user_id`, `service_id`, `description`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 2, 21, 'Permintaan servis: contoh deskripsi (disanitasi).', 'pending', 'test', '2025-06-11 05:07:44', '2025-06-11 00:13:57'),
(2, 2, 22, 'Permintaan servis: contoh deskripsi (disanitasi).', 'pending', NULL, '2025-06-11 05:10:08', '2025-06-11 05:10:08'),
(3, 2, 25, 'Tes order contoh', 'processed', 'lagi dicek admin', '2025-06-11 05:34:43', '2025-06-11 00:34:57');

-- Set AUTO_INCREMENT for service_requests
ALTER TABLE `service_requests` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


/* -------------------------
   Table: users
   (keamanan: passwords hashed, kept as-is from dump)
   ------------------------- */
CREATE TABLE IF NOT EXISTS `users` (
  `id` INT(11) NOT NULL,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert users (password = bcrypt hashes from original dump)
INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$MWkXv/KnpdsxlNKn.qyWb.Axr.D6.fOMD9IKZRwIF.R7bY1BlbD1.', 'admin', '2025-06-10 14:08:32'),
(2, 'user', '$2y$10$9q4gf3G/z1IWnSyp86tvSOEtXKmpLUaqNv1/dywgNV3OSy4cawixC', 'user', '2025-06-10 14:08:33');

-- Set AUTO_INCREMENT for users
ALTER TABLE `users` MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

COMMIT;
