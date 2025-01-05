-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jan 04, 2025 at 01:53 PM
-- Server version: 8.0.35
-- PHP Version: 8.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `online_market`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

-- Create users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    role ENUM('admin', 'user') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create categories table
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    image VARCHAR(255),
    category_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Create cart_items table
CREATE TABLE cart_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

INSERT INTO `categories` (`id`, `name`, `created_at`) VALUES
(1, 'Electronics', '2024-12-29 00:04:41'),
(2, 'Clothing', '2024-12-29 00:04:41'),
(3, 'Books', '2024-12-29 00:04:41'),
(5, 'Games', '2024-12-29 08:04:51');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

-- CREATE TABLE `products` (
--   `id` int NOT NULL,
--   `name` varchar(100) NOT NULL,
--   `description` text,
--   `price` decimal(10,2) NOT NULL,
--   `image` varchar(255) DEFAULT NULL,
--   `category_id` int DEFAULT NULL,
--   `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `image`, `category_id`, `created_at`) VALUES
(1, 'Laptop', 'High performance laptop', 999.99, 'laptop.jpeg', 1, '2024-12-29 00:04:41'),
(2, 'T-Shirt', 'Comfortable cotton t-shirt', 19.99, 'tshirt.jpeg', 2, '2024-12-29 00:04:41'),
(3, 'Novel', 'Bestselling novel', 14.99, 'novel.jpeg', 3, '2024-12-29 00:04:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

-- CREATE TABLE `users` (
--   `id` int NOT NULL,
--   `username` varchar(50) NOT NULL,
--   `password` varchar(255) NOT NULL,
--   `email` varchar(100) NOT NULL,
--   `role` enum('admin','user') NOT NULL,
--   `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
-- ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `role`, `created_at`) VALUES
(1, 'admin', '123', 'admin@example.com', 'admin', '2024-12-29 00:04:41'),
(2, 'user1', 'test', 'user1@example.com', 'user', '2024-12-29 00:04:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart_items`
--
-- ALTER TABLE `cart_items`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `user_id` (`user_id`),
--   ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
-- ALTER TABLE `categories`
--   ADD PRIMARY KEY (`id`),
--   ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `products`
--
-- ALTER TABLE `products`
--   ADD PRIMARY KEY (`id`),
--   ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
-- ALTER TABLE `users`
--   ADD PRIMARY KEY (`id`),
--   ADD UNIQUE KEY `username` (`username`),
--   ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart_items`
--
-- ALTER TABLE `cart_items`
--   MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
-- ALTER TABLE `categories`
--   MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `products`
--
-- ALTER TABLE `products`
--   MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

-- --
-- AUTO_INCREMENT for table `users`
--
-- ALTER TABLE `users`
--   MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
-- ALTER TABLE `cart_items`
--   ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
--   ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
-- ALTER TABLE `products`
--   ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;
-- COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
