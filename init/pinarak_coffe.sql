-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 05, 2025 at 01:32 PM
-- Server version: 8.0.30
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pinarak_coffe`
--

-- --------------------------------------------------------

--
-- Table structure for table `carts`
--

CREATE TABLE `carts` (
  `id` bigint NOT NULL,
  `session_id` varchar(255) NOT NULL,
  `product_id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `quantity` bigint NOT NULL DEFAULT '1',
  `sub_total` bigint NOT NULL,
  `cart_status` enum('active','completed','abandoned') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `carts`
--

INSERT INTO `carts` (`id`, `session_id`, `product_id`, `user_id`, `quantity`, `sub_total`, `cart_status`, `created_at`, `updated_at`) VALUES
(22, 'cart_677a5953a0793', 3, 2, 1, 13000, 'abandoned', '2025-01-05 11:19:22', '2025-01-05 12:32:41'),
(24, 'cart_677a5953a0793', 6, 2, 1, 8000, 'abandoned', '2025-01-05 11:22:51', '2025-01-05 12:32:41'),
(25, 'cart_677a5953a0793', 4, 2, 1, 15000, 'abandoned', '2025-01-05 11:24:03', '2025-01-05 12:28:07'),
(26, 'cart_677a5953a0793', 5, 2, 3, 60000, 'abandoned', '2025-01-05 11:38:19', '2025-01-05 12:23:22'),
(37, 'cart_677a5953a0793', 6, 1, 1, 8000, 'abandoned', '2025-01-05 13:03:53', '2025-01-05 13:04:39'),
(39, 'cart_677a5953a0793', 3, 1, 1, 13000, 'abandoned', '2025-01-05 13:04:32', '2025-01-05 13:04:39'),
(40, 'cart_677a5953a0793', 2, 1, 1, 12000, 'abandoned', '2025-01-05 13:05:48', '2025-01-05 13:05:59'),
(41, 'cart_677a5953a0793', 1, 1, 1, 15000, 'abandoned', '2025-01-05 13:05:51', '2025-01-05 13:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` enum('menu','product') NOT NULL,
  `price` int NOT NULL,
  `description` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `rating` tinyint NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `type`, `price`, `description`, `image`, `rating`, `created_at`, `updated_at`) VALUES
(1, 'Americano', 'menu', 15000, '', 'https://plus.unsplash.com/premium_photo-1694141252774-c937d97641da?q=80&w=1888&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 4, '2025-01-05 07:41:41', '2025-01-05 07:41:41'),
(2, 'Espresso', 'menu', 12000, '', 'https://plus.unsplash.com/premium_photo-1683619761492-639240d29bb5?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 5, '2025-01-05 07:41:41', '2025-01-05 07:41:41'),
(3, 'Capuccino ', 'menu', 13000, '', 'https://plus.unsplash.com/premium_photo-1674327105280-b86494dfc690?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 3, '2025-01-05 07:44:25', '2025-01-05 07:44:25'),
(4, 'Latte', 'menu', 15000, '', 'https://images.unsplash.com/photo-1508179181885-120b520a44eb?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 5, '2025-01-05 07:44:25', '2025-01-05 07:44:25'),
(5, 'Croissant', 'product', 20000, '', 'https://plus.unsplash.com/premium_photo-1661743823829-326b78143b30?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 5, '2025-01-05 07:46:33', '2025-01-05 07:46:33'),
(6, 'Donat', 'product', 8000, '', 'https://images.unsplash.com/photo-1619685347769-c7e6d5a83b10?q=80&w=1776&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 3, '2025-01-05 07:46:33', '2025-01-05 07:46:33');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` bigint NOT NULL,
  `user_id` bigint NOT NULL,
  `invoice_number` varchar(255) NOT NULL,
  `amount` bigint NOT NULL,
  `date` date NOT NULL,
  `status` enum('pending','completed','cancelled') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `invoice_number`, `amount`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 'INV-20250105122057-9779', 96000, '2025-01-05', 'completed', '2025-01-05 12:20:57', '2025-01-05 12:20:57'),
(2, 2, 'INV-20250105122308-8516', 96000, '2025-01-05', 'completed', '2025-01-05 12:23:08', '2025-01-05 12:23:08'),
(3, 2, 'INV-20250105122322-2454', 96000, '2025-01-05', 'completed', '2025-01-05 12:23:22', '2025-01-05 12:23:22'),
(4, 2, 'INV-20250105122807-0998', 23000, '2025-01-05', 'completed', '2025-01-05 12:28:07', '2025-01-05 12:28:07'),
(5, 2, 'INV-20250105122827-5886', 23000, '2025-01-05', 'completed', '2025-01-05 12:28:27', '2025-01-05 12:28:27'),
(6, 2, 'INV-20250105123241-0136', 21000, '2025-01-05', 'completed', '2025-01-05 12:32:41', '2025-01-05 12:32:41'),
(7, 1, 'INV-20250105130404-5939', 8000, '2025-01-05', 'completed', '2025-01-05 13:04:04', '2025-01-05 13:04:04'),
(8, 1, 'INV-20250105130439-5316', 21000, '2025-01-05', 'completed', '2025-01-05 13:04:39', '2025-01-05 13:04:39'),
(9, 1, 'INV-20250105130559-5200', 27000, '2025-01-05', 'completed', '2025-01-05 13:05:59', '2025-01-05 13:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_items`
--

CREATE TABLE `transaction_items` (
  `id` bigint NOT NULL,
  `transaction_id` bigint NOT NULL,
  `cart_id` bigint NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaction_items`
--

INSERT INTO `transaction_items` (`id`, `transaction_id`, `cart_id`, `created_at`, `updated_at`) VALUES
(1, 1, 22, '2025-01-05 12:20:57', '2025-01-05 12:20:57'),
(2, 1, 25, '2025-01-05 12:20:57', '2025-01-05 12:20:57'),
(3, 1, 26, '2025-01-05 12:20:57', '2025-01-05 12:20:57'),
(4, 1, 24, '2025-01-05 12:20:57', '2025-01-05 12:20:57'),
(5, 2, 22, '2025-01-05 12:23:08', '2025-01-05 12:23:08'),
(6, 3, 22, '2025-01-05 12:23:22', '2025-01-05 12:23:22'),
(7, 3, 25, '2025-01-05 12:23:22', '2025-01-05 12:23:22'),
(8, 3, 26, '2025-01-05 12:23:22', '2025-01-05 12:23:22'),
(9, 3, 24, '2025-01-05 12:23:22', '2025-01-05 12:23:22'),
(10, 4, 25, '2025-01-05 12:28:07', '2025-01-05 12:28:07'),
(11, 4, 24, '2025-01-05 12:28:07', '2025-01-05 12:28:07'),
(12, 5, 25, '2025-01-05 12:28:27', '2025-01-05 12:28:27'),
(13, 5, 24, '2025-01-05 12:28:27', '2025-01-05 12:28:27'),
(14, 6, 22, '2025-01-05 12:32:41', '2025-01-05 12:32:41'),
(15, 6, 24, '2025-01-05 12:32:41', '2025-01-05 12:32:41'),
(16, 7, 37, '2025-01-05 13:04:04', '2025-01-05 13:04:04'),
(17, 8, 39, '2025-01-05 13:04:39', '2025-01-05 13:04:39'),
(18, 8, 37, '2025-01-05 13:04:39', '2025-01-05 13:04:39'),
(19, 9, 41, '2025-01-05 13:05:59', '2025-01-05 13:05:59'),
(20, 9, 40, '2025-01-05 13:05:59', '2025-01-05 13:05:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `updated_at`) VALUES
(1, 'budi', 'budi@gmail.com', 'budi1234', '2025-01-05 06:52:44', '2025-01-05 06:52:44'),
(2, 'Jojo', 'jojo@gmail.com', 'jojo1234', '2025-01-05 07:23:50', '2025-01-05 07:23:50'),
(3, 'cahyo', 'cahyo@gmail.com', 'cahyo123', '2025-01-05 07:26:40', '2025-01-05 07:26:40');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `carts`
--
ALTER TABLE `carts`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_user_product` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `invoice_number` (`invoice_number`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaction_id` (`transaction_id`),
  ADD KEY `cart_id` (`cart_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `carts`
--
ALTER TABLE `carts`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `transaction_items`
--
ALTER TABLE `transaction_items`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `carts`
--
ALTER TABLE `carts`
  ADD CONSTRAINT `carts_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`),
  ADD CONSTRAINT `carts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transaction_items`
--
ALTER TABLE `transaction_items`
  ADD CONSTRAINT `transaction_items_ibfk_1` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `transaction_items_ibfk_2` FOREIGN KEY (`cart_id`) REFERENCES `carts` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
