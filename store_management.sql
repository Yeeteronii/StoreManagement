-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 14, 2025 at 07:26 PM
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
-- Database: `store_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `actions`
--

CREATE TABLE `actions` (
  `id` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `controller` varchar(32) NOT NULL COMMENT 'Example: Users',
  `action` varchar(32) NOT NULL COMMENT 'Example: list'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `actions`
--

INSERT INTO `actions` (`id`, `controller`, `action`) VALUES
(1, 'Product', 'list'),
(2, 'Product', 'add'),
(3, 'Product', 'delete'),
(4, 'Product', 'update'),
(5, 'Product', 'order'),
(6, 'Product', 'category'),
(7, 'Category', 'add'),
(8, 'Category', 'update'),
(9, 'Category', 'delete'),
(10, 'Category', 'list'),
(11, 'Schedule', 'list'),
(12, 'Schedule', 'add'),
(13, 'Schedule', 'delete'),
(14, 'Schedule', 'update'),
(15, 'Report', 'list'),
(16, 'Report', 'add'),
(17, 'Report', 'delete'),
(18, 'Report', 'update'),
(19, 'Order', 'list'),
(20, 'Order', 'delete'),
(21, 'Order', 'update'),
(22, 'Supplier', 'list'),
(23, 'Supplier', 'delete'),
(24, 'Supplier', 'update'),
(25, 'Supplier', 'add'),
(26, 'Employee', 'list'),
(27, 'Employee', 'delete'),
(28, 'Employee', 'update'),
(29, 'Employee', 'add'),
(30, 'Setting', 'list'),
(31, 'Setting', 'update'),
(32, 'Setting', 'language'),
(33, 'Setting', 'theme');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `categoryId` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `categoryName` varchar(32) NOT NULL COMMENT 'Example: Candy',
  `categoryTax` double NOT NULL COMMENT 'Example: 0.5',
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Example: 0: (disabled)\r\n1: (enabled)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `name` varchar(32) NOT NULL COMMENT 'Example: admin'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`) VALUES
(1, 'admin'),
(2, 'employee');

-- --------------------------------------------------------

--
-- Table structure for table `groups_actions`
--

CREATE TABLE `groups_actions` (
  `id` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `group_id` int(11) NOT NULL COMMENT 'Example: 1',
  `action_id` int(11) NOT NULL COMMENT 'Example: 2 (list)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `groups_actions`
--

INSERT INTO `groups_actions` (`id`, `group_id`, `action_id`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 1, 3),
(4, 1, 4),
(5, 1, 5),
(6, 1, 6),
(7, 1, 7),
(8, 1, 8),
(9, 1, 9),
(10, 1, 10),
(11, 1, 11),
(12, 1, 12),
(13, 1, 13),
(14, 1, 14),
(15, 1, 15),
(16, 1, 16),
(17, 1, 17),
(18, 1, 18),
(19, 1, 19),
(20, 1, 20),
(21, 1, 21),
(22, 1, 22),
(23, 1, 23),
(24, 1, 24),
(25, 1, 25),
(26, 1, 26),
(27, 1, 27),
(28, 1, 28),
(29, 1, 29),
(30, 1, 30),
(31, 1, 31),
(32, 1, 32),
(33, 1, 33),
(34, 2, 1),
(35, 2, 3),
(36, 2, 4),
(37, 2, 5),
(38, 2, 11),
(39, 2, 30),
(40, 2, 31),
(41, 2, 32),
(42, 2, 33);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderId` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `productId` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `orderDate` date NOT NULL COMMENT 'Example: 14/04/2025 (dd/mm/yyyy)',
  `quantity` int(11) NOT NULL COMMENT 'Example: 10',
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Example: 0: (disabled) 1: (enabled)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `productId` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `productName` varchar(64) NOT NULL COMMENT 'Example: Hershey''s Cookies and Cream, 55g',
  `cost` double NOT NULL COMMENT 'Example: 30.00$ (how much he bought it for)',
  `priceToSell` double NOT NULL COMMENT 'Example: 50.00$ (Sell price)\r\n',
  `categoryId` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `threshold` int(11) NOT NULL COMMENT 'Example: 15 (desired stock)',
  `quantity` int(11) NOT NULL COMMENT 'Example: 20 (amount currently)',
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Example: 0: (disabled) 1: (enabled)	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reports`
--

CREATE TABLE `reports` (
  `reportId` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `Date` date NOT NULL COMMENT 'Example: 14/04/2025 (dd/mm/yyyy)',
  `earnings` double NOT NULL COMMENT 'Example: 25.00$',
  `profits` double NOT NULL COMMENT 'Example: 15.00$',
  `decription` varchar(128) NOT NULL COMMENT 'Example: Beer was not well, Candy was selling good, neutral on everything else',
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Example: 0: (disabled) 1: (enabled)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shifts`
--

CREATE TABLE `shifts` (
  `shiftId` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `userId` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `day` date NOT NULL COMMENT 'Example: 14/04/2025 (dd/mm/yyyy)',
  `startTime` time NOT NULL COMMENT 'Example: 10:00:00',
  `endTime` time NOT NULL COMMENT 'Example: 18:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplierId` int(11) NOT NULL COMMENT 'Example: 1111111111',
  `supplierName` varchar(32) NOT NULL COMMENT 'Example: Suns of Calydon',
  `email` varchar(32) NOT NULL COMMENT 'Example: parthpatel@gmail.com',
  `phoneNum` int(11) NOT NULL COMMENT 'Example: 222-111-8907',
  `isActive` tinyint(1) NOT NULL DEFAULT 1 COMMENT 'Example: 0: (disabled) 1: (enabled)	'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL COMMENT 'Example: 1',
  `username` varchar(32) NOT NULL COMMENT 'Example: parthpatel',
  `password` varchar(128) NOT NULL COMMENT 'Example: NicholasRoyMicrowave'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '12345'),
(2, 'employee', '67890');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) NOT NULL COMMENT 'Example: 11111111111',
  `user_id` int(11) NOT NULL COMMENT 'Example: 1 (parthpatel)',
  `group_id` int(11) NOT NULL COMMENT 'Example: 1 (admin)'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1),
(2, 2, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actions`
--
ALTER TABLE `actions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`categoryId`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups_actions`
--
ALTER TABLE `groups_actions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `action_id` (`action_id`),
  ADD KEY `group_id` (`group_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderId`),
  ADD KEY `productFK` (`productId`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`productId`),
  ADD KEY `categoryFK` (`categoryId`);

--
-- Indexes for table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`reportId`);

--
-- Indexes for table `shifts`
--
ALTER TABLE `shifts`
  ADD PRIMARY KEY (`shiftId`),
  ADD KEY `employeeFK` (`userId`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplierId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD KEY `GROUPS` (`group_id`),
  ADD KEY `USERS` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actions`
--
ALTER TABLE `actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 11111111111', AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `categoryId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 11111111111';

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 11111111111', AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups_actions`
--
ALTER TABLE `groups_actions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 11111111111', AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 11111111111';

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `productId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 11111111111';

--
-- AUTO_INCREMENT for table `reports`
--
ALTER TABLE `reports`
  MODIFY `reportId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 11111111111';

--
-- AUTO_INCREMENT for table `shifts`
--
ALTER TABLE `shifts`
  MODIFY `shiftId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 11111111111';

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplierId` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 1111111111';

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 1', AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Example: 11111111111', AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `groups_actions`
--
ALTER TABLE `groups_actions`
  ADD CONSTRAINT `groups_actions_ibfk_1` FOREIGN KEY (`action_id`) REFERENCES `actions` (`id`),
  ADD CONSTRAINT `groups_actions_ibfk_2` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `productFK` FOREIGN KEY (`productId`) REFERENCES `products` (`productId`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `categoryFK` FOREIGN KEY (`categoryId`) REFERENCES `categories` (`categoryId`);

--
-- Constraints for table `shifts`
--
ALTER TABLE `shifts`
  ADD CONSTRAINT `userFK` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `GROUPS` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`),
  ADD CONSTRAINT `USERS` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
