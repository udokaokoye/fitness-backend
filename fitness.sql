-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2023 at 08:31 PM
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
-- Database: `fitness`
--

-- --------------------------------------------------------

--
-- Table structure for table `food`
--

CREATE TABLE `food` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `name` text NOT NULL,
  `apiFoodID` varchar(100) NOT NULL,
  `nutritionID` int(11) NOT NULL,
  `calories` varchar(50) NOT NULL,
  `serving` varchar(50) NOT NULL,
  `meal` varchar(10) NOT NULL,
  `note` text NOT NULL,
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `userId`, `name`, `apiFoodID`, `nutritionID`, `calories`, `serving`, `meal`, `note`, `created_at`) VALUES
(12, 6, 'Beef Top Sirloin (Trimmed to 1/8\" Fat)', '37657', 40, '171', '3', 'B', 'No notes', 1699900187),
(13, 6, 'Lettuce Salad with Egg, Cheese, Tomato, and/or Carrots', '6393', 41, '369', '3', 'L', 'No notes', 1699901475),
(14, 6, 'Waves Fuego', '58125250', 42, '300', '2', 'L', 'No notes', 1699903027),
(15, 6, 'Grilled Chicken', '448901', 43, '588', '4', 'L', 'No notes', 1699903049),
(16, 6, 'Malta', '3183136', 44, '140', '1', 'L', 'No notes', 1699903728);

-- --------------------------------------------------------

--
-- Table structure for table `nutrition`
--

CREATE TABLE `nutrition` (
  `id` int(11) NOT NULL,
  `userId` int(11) NOT NULL,
  `protein` varchar(50) NOT NULL,
  `carbohydrate` varchar(50) NOT NULL,
  `fat` varchar(50) NOT NULL,
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutrition`
--

INSERT INTO `nutrition` (`id`, `userId`, `protein`, `carbohydrate`, `fat`, `created_at`) VALUES
(40, 6, '15', '1', '9', 1699900187),
(41, 6, '21', '21', '21', 1699901475),
(42, 6, '4', '34', '16', 1699903027),
(43, 6, '64', '0', '32', 1699903049),
(44, 6, '2', '34', '0', 1699903728);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(500) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `avatar` text DEFAULT NULL,
  `caloriesGoal` text NOT NULL,
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `avatar`, `caloriesGoal`, `created_at`) VALUES
(6, 'Udoka', 'Okoye', 'leviokoye@gmail.com', '$2y$10$j0mvRje29lMbk2xZKbvk1eHhfUYpuKZZXLP7D8vaew1gRWrBhbfVK', NULL, '2500', 1699592400),
(21, 'sdfsd', 'fsdfs', 'leviokoye@gmail.com1', '$2y$10$/6lev3S/jv3lQQrSnAF79uQ6qgWftzQP0xjq16ZCXJEJT1b36lX/S', NULL, '2000', 123456);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `food`
--
ALTER TABLE `food`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_food_nutrition_id` (`nutritionID`),
  ADD KEY `fk_food_user_id` (`userId`);

--
-- Indexes for table `nutrition`
--
ALTER TABLE `nutrition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nutrition_user_id` (`userId`);

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
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `nutrition`
--
ALTER TABLE `nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `fk_food_nutrition_id` FOREIGN KEY (`nutritionID`) REFERENCES `nutrition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_food_user_id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `nutrition`
--
ALTER TABLE `nutrition`
  ADD CONSTRAINT `fk_nutrition_user_id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
