-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2026 at 02:01 AM
-- Server version: 10.11.16-MariaDB
-- PHP Version: 8.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mysql_task`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(11) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `salary` int(11) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `first_name`, `city`, `salary`, `password`) VALUES
(1, 'Demott', 'Kerkrade', 7164, 'vN3$9/HN\'(OUdL'),
(2, 'Sara', 'Huanggang', 19012, 'oM0?N{}o*s*'),
(3, 'Roosevelt', 'Kajatian', 29544, 'rO7%tqvT.jG=}1D'),
(4, 'Tierney', 'Xinjian', 20057, 'pT6$q8V7'),
(5, 'Albina', 'Bankim', 10547, 'xA1\"Mr\',Z5,Q},V'),
(6, 'Letty', 'Ajuy', 39569, 'nS7<Jv5PK/~U+Y'),
(7, 'Iggie', 'Skinnskatteberg', 34813, 'rJ4+r`Z8?L)'),
(8, 'Kelvin', 'Manogay', 37208, 'sQ2=,3&TSyRfS'),
(9, 'Jennine', 'Wonorejo', 37226, 'tA0.SaUL+Un');

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `manager_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `manager_id`) VALUES
(1, 'Ahmed Hassan', NULL),
(2, 'Sara Ali', 1),
(3, 'Omar Khaled', 1),
(4, 'Mona Adel', 2),
(5, 'Youssef Ibrahim', 2),
(6, 'Nour Tarek', 3),
(7, 'Ahmed Hassan', NULL),
(8, 'Sara Ali', 1),
(9, 'Omar Khaled', 1),
(10, 'Mona Adel', 2),
(11, 'Youssef Ibrahim', 2),
(12, 'Nour Tarek', 3);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `order_date` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_date`) VALUES
(1, 1, '2026-11-22 02:32:57'),
(2, 1, '2026-11-22 02:32:57'),
(3, 1, '2026-11-22 02:32:57'),
(4, 1, '2026-11-22 02:32:57'),
(5, 1, '2026-11-22 02:32:57'),
(6, 2, '2026-11-22 02:32:57'),
(7, 2, '2026-11-22 02:32:57'),
(8, 2, '2026-11-22 02:32:57'),
(9, 2, '2026-11-22 02:32:57'),
(10, 2, '2026-11-22 02:32:57'),
(11, 2, '2026-11-22 02:32:57'),
(12, 2, '2026-11-22 02:32:57'),
(13, 2, '2026-11-22 02:32:57'),
(14, 2, '2026-11-22 02:32:57'),
(15, 3, '2026-11-22 02:32:57'),
(16, 3, '2026-11-22 02:32:57'),
(17, 4, '2026-11-22 02:32:57'),
(18, 5, '2026-11-22 02:32:57'),
(19, 6, '2026-11-22 02:32:57'),
(20, 7, '2026-11-22 02:32:57');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`) VALUES
(1, 1, 1, 10),
(2, 2, 2, 12),
(3, 3, 1, 150),
(4, 4, 2, 200),
(5, 5, 3, 500),
(6, 6, 4, 1200),
(7, 7, 5, 80),
(8, 8, 6, 3000),
(9, 9, 1, 400),
(10, 10, 2, 950),
(11, 11, 3, 700),
(12, 12, 4, 2500),
(13, 13, 5, 1600),
(14, 14, 6, 2200),
(15, 15, 1, 600),
(16, 16, 2, 1400),
(17, 17, 3, 450),
(18, 18, 4, 1800),
(19, 19, 5, 900),
(20, 20, 6, 1100);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`) VALUES
(1, 'Milk', 125.40),
(2, 'Orange', 729.67),
(3, 'Bread', 35.00),
(4, 'Cheese', 180.00),
(5, 'Coffee', 250.00),
(6, 'Rice', 90.00),
(7, 'Milk', 125.40),
(8, 'Orange', 729.67),
(9, 'Bread', 35.00),
(10, 'Cheese', 180.00),
(11, 'Coffee', 250.00),
(12, 'Rice', 90.00);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manager_id` (`manager_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `employees`
--
ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`manager_id`) REFERENCES `employees` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
