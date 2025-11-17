-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2025 at 07:35 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_service`
--

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `harga` varchar(12) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `image` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `description`, `harga`, `created_at`, `image`) VALUES
(21, 'Service Batre ', 'Baterai HP, terutama baterai Lithium-ion, memiliki masa pakai yang terbatas. Setelah beberapa siklus pengisian, performa baterai akan menurun dan masa pakainya akan berkurang. \r\n\r\n', '50000', '2025-06-11 04:02:48', '289622a582f9b041a33e81efed0f6a8b.jpg'),
(22, 'Service Screen', 'Ganti Screen HP Android dan Iphone', '100000', '2025-06-11 04:12:12', 'c7ec5f73c0c5c0899d33c354d23f6d79.png'),
(23, 'Service TWS', 'Servis TWS mulai dari KZ sampai dengan Samsung, Bisa ganti batre dan TWSnya.', '125000', '2025-06-11 04:15:27', 'b07e266f588bbdefda8b163c3e2aad42.jpg'),
(25, 'Dapa gay', 'dapa terlalu gay', '10000', '2025-06-11 05:23:11', '5b58252e383d94c9ae17ba43bb2abe18.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `service_requests`
--

CREATE TABLE `service_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('pending','processed','completed','rejected') NOT NULL DEFAULT 'pending',
  `admin_notes` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `service_requests`
--

INSERT INTO `service_requests` (`id`, `user_id`, `service_id`, `description`, `status`, `admin_notes`, `created_at`, `updated_at`) VALUES
(1, 2, 21, 'Dapa gay', 'pending', 'test', '2025-06-11 05:07:44', '2025-06-11 00:13:57'),
(2, 2, 22, 'dapa gay', 'pending', NULL, '2025-06-11 05:10:08', '2025-06-11 05:10:08'),
(3, 2, 25, 'etst', 'processed', 'lgi nyari hugo', '2025-06-11 05:34:43', '2025-06-11 00:34:57');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin', '$2y$10$MWkXv/KnpdsxlNKn.qyWb.Axr.D6.fOMD9IKZRwIF.R7bY1BlbD1.', 'admin', '2025-06-10 14:08:32'),
(2, 'user', '$2y$10$9q4gf3G/z1IWnSyp86tvSOEtXKmpLUaqNv1/dywgNV3OSy4cawixC', 'user', '2025-06-10 14:08:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `service_requests`
--
ALTER TABLE `service_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `service_id` (`service_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `service_requests`
--
ALTER TABLE `service_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
