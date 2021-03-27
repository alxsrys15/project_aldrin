-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Feb 14, 2021 at 08:40 AM
-- Server version: 10.4.14-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u929428956_loukha`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `is_active`) VALUES
(1, 'Accessories', 1),
(2, 'Tops', 1),
(3, 'Bottoms', 1);

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `id` int(11) NOT NULL,
  `description` varchar(500) DEFAULT NULL,
  `img_name` varchar(45) DEFAULT NULL,
  `img_ext` varchar(45) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feeds`
--

INSERT INTO `feeds` (`id`, `description`, `img_name`, `img_ext`, `created`, `modified`) VALUES
(2, 'What do you think about this top guys?', 'Bonnie High Waisted Shorts.jpg', NULL, '2020-12-03 04:09:23', '2020-12-03 04:09:23');

-- --------------------------------------------------------

--
-- Table structure for table `feed_comments`
--

CREATE TABLE `feed_comments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `feed_id` int(11) DEFAULT NULL,
  `comment` varchar(500) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feed_comments`
--

INSERT INTO `feed_comments` (`id`, `user_id`, `feed_id`, `comment`, `created`, `modified`) VALUES
(1, 8, 2, 'nice', '2020-12-03 07:26:45', '2020-12-03 07:26:45');

-- --------------------------------------------------------

--
-- Table structure for table `feed_dislikes`
--

CREATE TABLE `feed_dislikes` (
  `id` int(11) NOT NULL,
  `feed_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `feed_likes`
--

CREATE TABLE `feed_likes` (
  `id` int(11) NOT NULL,
  `feed_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feed_likes`
--

INSERT INTO `feed_likes` (`id`, `feed_id`, `user_id`) VALUES
(4, 2, 8);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL,
  `description` varchar(45) DEFAULT NULL,
  `price` decimal(11,2) NOT NULL DEFAULT 0.00,
  `category_id` int(11) DEFAULT NULL,
  `imgs` varchar(500) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `category_id`, `imgs`, `is_active`) VALUES
(1, 'Rue (Gold)', 'Alloy face earrings', '399.00', 1, 'rue.png,rue1.png,rue2.png', 1),
(2, 'Lola (Gold)', 'Alloy face earrings\r\n', '399.00', 1, 'lola.png,lola1.png,lola2.png', 1),
(3, 'Sao Paulo (Yellow)', 'Alloy double round leaf earrings', '799.00', 1, 'Sao.png,sao1.png,sao2.png', 1),
(4, 'Vienna (Gold)', 'Alloy triple flower drop earrings\r\n', '799.00', 1, 'vie.png,vie1.png,vie2.png', 1),
(5, 'Bahamas', 'Boho resin sea shell and beads drop earrings', '799.00', 1, 'baha.png,baha1.png,baha2.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `product_stocks`
--

CREATE TABLE `product_stocks` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `size_id` int(11) DEFAULT NULL,
  `variant` varchar(45) DEFAULT NULL,
  `sku` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_stocks`
--

INSERT INTO `product_stocks` (`id`, `product_id`, `size_id`, `variant`, `sku`, `created`, `modified`) VALUES
(1, 1, 1, 'Silver', 9, '2020-12-02 20:04:18', '2020-12-31 12:28:55'),
(2, 2, 2, 'Gold', 49, '2020-12-03 02:31:57', '2020-12-03 06:52:48'),
(3, 3, 1, 'Silver', 30, '2020-12-03 02:32:26', '2020-12-03 02:32:26'),
(4, 3, 2, 'Gold', 19, '2020-12-03 02:32:26', '2020-12-03 06:52:48'),
(5, 4, 3, 'Silver', 74, '2020-12-03 02:32:49', '2020-12-03 02:32:49'),
(6, 4, 2, 'Gold', 66, '2020-12-03 02:32:49', '2020-12-03 02:32:49'),
(7, 5, 1, 'Multi-Color', 44, '2020-12-03 02:33:32', '2020-12-03 02:33:32'),
(8, 1, 2, 'Gold', 9, '2020-12-31 12:28:04', '2020-12-31 12:28:14');

-- --------------------------------------------------------

--
-- Table structure for table `sizes`
--

CREATE TABLE `sizes` (
  `id` int(11) NOT NULL,
  `name` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sizes`
--

INSERT INTO `sizes` (`id`, `name`) VALUES
(1, 'Small'),
(2, 'Medium'),
(3, 'Large');

-- --------------------------------------------------------

--
-- Table structure for table `statuses`
--

CREATE TABLE `statuses` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `statuses`
--

INSERT INTO `statuses` (`id`, `name`) VALUES
(1, 'Pending'),
(2, 'Accepted'),
(3, 'For Delivery'),
(4, 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_price` decimal(11,2) DEFAULT 0.00,
  `shipping_fee` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status_id` tinyint(4) DEFAULT NULL,
  `transaction_type_id` int(11) DEFAULT NULL,
  `paypal_token` varchar(500) DEFAULT NULL,
  `payment_image` varchar(100) DEFAULT NULL,
  `street` varchar(400) NOT NULL,
  `barangay` varchar(400) NOT NULL,
  `city` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user_id`, `total_price`, `shipping_fee`, `created`, `modified`, `status_id`, `transaction_type_id`, `paypal_token`, `payment_image`, `street`, `barangay`, `city`) VALUES
(1, 4, '399.00', 100, '2020-12-03 02:56:18', '2020-12-31 12:02:36', 3, 2, 'COD5fc853d1f3b6d6.07339441', NULL, '1150 Maginhawa street', 'Barangay 34', 'Manila'),
(2, 4, '399.00', 100, '2020-12-03 03:16:10', '2020-12-03 03:16:10', 1, 2, 'COD5fc8587aa89e60.32651212', NULL, '1150 Maginhawa street', 'Barangay 34', 'Manila'),
(3, 8, '1597.00', 100, '2020-12-03 06:52:46', '2020-12-03 07:15:27', 4, 2, 'COD5fc88b3e394c12.74735095', NULL, 'test', '1', 'Samal');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_details`
--

CREATE TABLE `transaction_details` (
  `id` int(11) NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_stocks_id` int(11) DEFAULT NULL,
  `total_qty` int(11) DEFAULT NULL,
  `transaction_id` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_details`
--

INSERT INTO `transaction_details` (`id`, `product_id`, `product_stocks_id`, `total_qty`, `transaction_id`, `created`) VALUES
(1, 1, 1, 1, 1, '2020-12-03 02:56:18'),
(2, 1, 1, 1, 2, '2020-12-03 03:16:10'),
(3, 2, 2, 2, 3, '2020-12-03 06:52:46'),
(4, 3, 4, 1, 3, '2020-12-03 06:52:46');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_types`
--

CREATE TABLE `transaction_types` (
  `id` int(11) NOT NULL,
  `name` varchar(45) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `transaction_types`
--

INSERT INTO `transaction_types` (`id`, `name`) VALUES
(1, 'PayPal'),
(2, 'COD'),
(3, 'Bank Transfer');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(500) NOT NULL,
  `password` varchar(200) NOT NULL,
  `contact_no` varchar(45) DEFAULT NULL,
  `first_name` varchar(45) DEFAULT NULL,
  `last_name` varchar(45) DEFAULT NULL,
  `street_name` varchar(45) DEFAULT NULL,
  `barangay` varchar(45) DEFAULT NULL,
  `city` varchar(45) DEFAULT NULL,
  `country` varchar(45) DEFAULT NULL,
  `is_admin` tinyint(4) DEFAULT 0,
  `is_active` tinyint(4) DEFAULT 0,
  `verification_token` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `contact_no`, `first_name`, `last_name`, `street_name`, `barangay`, `city`, `country`, `is_admin`, `is_active`, `verification_token`) VALUES
(1, 'Loukha@admin.com', 'password123', NULL, 'Loukha', 'Admin', NULL, NULL, NULL, NULL, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MywiZW1haWwiOiJMb3VraGFAYWRtaW4uY29tIiwiZXhwIjoxNjA2OTM4OTQzfQ.oGcKXGKdW5SgOgA_ZFOy_ONLSmliFgdyS8EzglnS4zo'),
(2, 'tin.eusebio@yahoo.com', '$2y$10$hx88/ZfS3beFx97tE5LD1uetFYBwjVeGYbGjq6ewezq0owzaK2gc.', NULL, 'tin', 'Eusebio', NULL, NULL, NULL, NULL, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MiwiZW1haWwiOiJ0aW4uZXVzZWJpb0B5YWhvby5jb20iLCJleHAiOjE2MDY5Mzg0NDd9.VK2Wu9r-nNY5EpmlMWhfazqb7lgoUJVmKi6UWuA24_c'),
(4, 'russellcanoy@yahoo.com', '$2y$10$ZS2ILJudXyEyTrN1PDmHf.8mQcpaIbWOLbHaRbKXj3mVk39x3PDne', '09165826699', 'Russell', 'Canoy', '1150 Maginhawa street', 'Barangay 34', 'Manila', 'Metro Manila', 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6NCwiZW1haWwiOiJydXNzZWxsY2Fub3lAeWFob28uY29tIiwiZXhwIjoxNjA2OTY2NTI4fQ.w6eo0HlYo5dauHpZtubA8jp63BRBUPyqn0GSixjHwlg'),
(6, 'legurpakervin21@gmail.com', '$2y$10$9q58573gvDo9rKhMa62CT.8uhkDueqIesDNd0IFiLQiowjJ7pdqUK', NULL, 'Kervin', 'Legurpa', NULL, NULL, NULL, NULL, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6NiwiZW1haWwiOiJsZWd1cnBha2VydmluMjFAZ21haWwuY29tIiwiZXhwIjoxNjA2OTY3MDU0fQ.MiPj3eKzl63IhKi6HdY36MF2PEbbzbBeVw555WknfpY'),
(8, 'justin.aldrin.eusebio@gmail.com', '$2y$10$/ZE/XXtTrmqye2eZeXVdJ.1zRbRju2Q6Ap49qdq4epNIkH26ZHOoq', NULL, 'tin', 'eusebio', NULL, NULL, NULL, NULL, 0, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6OCwiZW1haWwiOiJqdXN0aW4uYWxkcmluLmV1c2ViaW9AZ21haWwuY29tIiwiZXhwIjoxNjA2OTgxNDU2fQ.LCrFKroCrynG6gbupvKbQXP66cpF0w0w78WrXkP1GdI'),
(9, 'shaoshaogabriel@gmail.com', '$2y$10$baudlZBylQErK7QGiPFsUOuFf7C9Ytogd0PmzA2njPDPG7j5PJ3TS', NULL, 'Shaobert', 'Gabriel', NULL, NULL, NULL, NULL, 0, 0, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6OSwiZW1haWwiOiJzaGFvc2hhb2dhYnJpZWxAZ21haWwuY29tIiwiZXhwIjoxNjA2OTgxNzQ5fQ.zw7-XOW8CVS-x6RON6mnPdoZPS3KjzdfguIPjGWx6k4'),
(10, 'michaelandrewfelix@gmail.com', '$2y$10$xUuxEnKmU0KCs0S3BmQ9GOiTQTsyckqMZy/nC5K.7v4m/GP3yjwPK', NULL, 'Super', 'Admin', NULL, NULL, NULL, NULL, 1, 1, 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MTAsImVtYWlsIjoibWljaGFlbGFuZHJld2ZlbGl4QGdtYWlsLmNvbSIsImV4cCI6MTYwODM5MjkwOH0.Jv9igAOyqj1_VzLr8OOGzbrO2VQrkoB6KVRif1FBT10');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_comments`
--
ALTER TABLE `feed_comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_dislikes`
--
ALTER TABLE `feed_dislikes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feed_likes`
--
ALTER TABLE `feed_likes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_stocks`
--
ALTER TABLE `product_stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sizes`
--
ALTER TABLE `sizes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `statuses`
--
ALTER TABLE `statuses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_details`
--
ALTER TABLE `transaction_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_types`
--
ALTER TABLE `transaction_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feed_comments`
--
ALTER TABLE `feed_comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `feed_dislikes`
--
ALTER TABLE `feed_dislikes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `feed_likes`
--
ALTER TABLE `feed_likes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_stocks`
--
ALTER TABLE `product_stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `sizes`
--
ALTER TABLE `sizes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `statuses`
--
ALTER TABLE `statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaction_details`
--
ALTER TABLE `transaction_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction_types`
--
ALTER TABLE `transaction_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
