-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 10, 2024 at 10:17 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pos`
--

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE `member` (
  `id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `name` varchar(128) NOT NULL,
  `lastname` varchar(128) NOT NULL,
  `phone` int(20) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `status` varchar(1) NOT NULL COMMENT '0 = user , admin = 1;'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`id`, `name`, `lastname`, `phone`, `username`, `password`, `status`) VALUES
(0000000002, 'test', 'der', 2099119922, 'user', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', '0'),
(0000000003, 'demo', 'der', 2077117227, 'admin', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', '1'),
(0000000004, 'somchai', 'sydaeng', 2077772221, 'chai', 'd404559f602eab6fd602ac7680dacbfaadd13630335e951f097af3900e9de176b6db28512f2e000b9d04fba5133e8b1c6e8df59db3a8ab9d60be4b97cc9e81db', '0');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `member_id` int(10) UNSIGNED ZEROFILL NOT NULL,
  `grand_total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `order_date`, `member_id`, `grand_total`) VALUES
(8, '2024-09-19 21:39:50', 0000000002, 37.45),
(9, '2024-09-19 21:40:58', 0000000002, 58.85),
(10, '2024-09-19 21:50:10', 0000000002, 96.30),
(11, '2024-09-19 21:55:55', 0000000002, 58.85),
(12, '2024-09-20 09:10:20', 0000000002, 123.05),
(13, '2024-09-20 10:38:20', 0000000002, 240.75),
(14, '2024-09-20 10:44:12', 0000000002, 133.75),
(15, '2024-09-20 10:46:42', 0000000002, 197.95),
(16, '2024-09-20 10:50:25', 0000000002, 123.05);

-- --------------------------------------------------------

--
-- Table structure for table `order_detail`
--

CREATE TABLE `order_detail` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total` decimal(10,2) GENERATED ALWAYS AS (`price` * `quantity`) STORED
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_detail`
--

INSERT INTO `order_detail` (`id`, `order_id`, `product_id`, `product_name`, `price`, `quantity`) VALUES
(8, 8, 18, 'LAY\'S Classic Potato Chips', 35.00, 1),
(9, 9, 19, 'Hamburger', 55.00, 1),
(10, 10, 18, 'LAY\'S Classic Potato Chips', 35.00, 1),
(11, 10, 19, 'Hamburger', 55.00, 1),
(12, 11, 19, 'Hamburger', 55.00, 1),
(13, 12, 19, 'Hamburger', 55.00, 1),
(14, 12, 18, 'LAY\'S Classic Potato Chips', 35.00, 1),
(15, 12, 17, 'Coke', 25.00, 1),
(16, 13, 18, 'LAY\'S Classic Potato Chips', 35.00, 1),
(17, 13, 17, 'Coke', 25.00, 1),
(18, 13, 19, 'Hamburger', 55.00, 3),
(19, 14, 19, 'Hamburger', 55.00, 1),
(20, 14, 18, 'LAY\'S Classic Potato Chips', 35.00, 2),
(21, 15, 19, 'Hamburger', 55.00, 1),
(22, 15, 18, 'LAY\'S Classic Potato Chips', 35.00, 3),
(23, 15, 17, 'Coke', 25.00, 1),
(24, 16, 18, 'LAY\'S Classic Potato Chips', 35.00, 1),
(25, 16, 17, 'Coke', 25.00, 1),
(26, 16, 19, 'Hamburger', 55.00, 1);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `price` decimal(8,2) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `detail` text NOT NULL,
  `product_type_id` int(11) UNSIGNED ZEROFILL NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_name`, `price`, `profile_image`, `detail`, `product_type_id`) VALUES
(17, 'Coke', 25.00, 'coke.png', 'ໂຄ້ກກະປ໋ອງ ', 00000000002),
(18, 'LAY\'S Classic Potato Chips', 35.00, 'Lay.jpg', 'แช่บบบบ.....', 00000000001),
(19, 'Hamburger', 55.00, 'Burger copy.png', 'Burger Beef', 00000000004);

-- --------------------------------------------------------

--
-- Table structure for table `product_type`
--

CREATE TABLE `product_type` (
  `id` int(11) UNSIGNED ZEROFILL NOT NULL,
  `type_name` varchar(128) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_type`
--

INSERT INTO `product_type` (`id`, `type_name`) VALUES
(00000000001, 'ເຂົ້າໜົມ'),
(00000000002, 'ເຄື່ອງດື່ມ'),
(00000000003, 'ເຄື່ອງໃຊ້ໃນບ້ານ'),
(00000000004, 'ອາຫານ Fastfood'),
(00000000005, 'ອາຫານ ແຊ່ແຂງ'),
(00000000006, 'ອາຫານ ແຫ້ງ'),
(00000000007, 'ເຄື່ອງເດັກນ້ອຍ'),
(00000000008, 'ຢາ ແລະ ເຄື່ອງປະຖົມພະຍາບານ');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `test` (`member_id`);

--
-- Indexes for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `order_detail_ibfk_1` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `testt` (`product_type_id`);

--
-- Indexes for table `product_type`
--
ALTER TABLE `product_type`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(10) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `order_detail`
--
ALTER TABLE `order_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `product_type`
--
ALTER TABLE `product_type`
  MODIFY `id` int(11) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `test` FOREIGN KEY (`member_id`) REFERENCES `member` (`id`);

--
-- Constraints for table `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `testt` FOREIGN KEY (`product_type_id`) REFERENCES `product_type` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
