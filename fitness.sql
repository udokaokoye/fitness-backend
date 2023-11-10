-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 10, 2023 at 03:34 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.0.25

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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `food`
--

INSERT INTO `food` (`id`, `userId`, `name`, `apiFoodID`, `nutritionID`, `calories`, `serving`, `meal`, `note`, `created_at`) VALUES
(1, 4, 'sods', 'sods', 20, 'dsfs', 'sdfsd', 'pdf', 'pdf', '2023-11-09 17:25:05'),
(2, 4, 'Apple', 'A12345', 21, '95', '1', 'Breakfast', 'Fresh green apple', '2023-11-09 08:00:00'),
(3, 3, 'Apple', 'A12345', 22, '95', '1', 'Breakfast', 'Fresh green apple', '2023-11-09 08:00:00'),
(5, 3, 'Apple', 'A12345', 25, '95', '1', 'Breakfast', 'Fresh green apple', '2023-11-09 08:00:00');

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
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `nutrition`
--

INSERT INTO `nutrition` (`id`, `userId`, `protein`, `carbohydrate`, `fat`, `created_at`) VALUES
(20, 4, 'sd', 'sd', 'sd', '2023-11-09 17:38:50'),
(21, 4, '0.5', '25', '0.3', '2023-11-09 08:00:00'),
(22, 3, '0.5', '25', '0.3', '2023-11-09 08:00:00'),
(25, 3, '0.5', '25', '0.3', '2023-11-09 08:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(500) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `avatar` text DEFAULT NULL,
  `caloriesGoal` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `avatar`, `caloriesGoal`, `created_at`) VALUES
(1, ' cvbcvb', '', 'cvbcv', NULL, 'bcvbc', '2023-11-04 21:48:29'),
(2, ' cvbcvb', '', 'cvbcv', NULL, 'bcvbc', '2023-11-04 21:49:06'),
(3, 'Levi', '', 'leviokoye@gmail.com', NULL, '2000', '2023-11-09 11:18:53'),
(4, 'Levi', 'Levi', 'leviokoye@gmail.com', NULL, '2000', '2023-11-09 11:21:39');

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
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `nutrition`
--
ALTER TABLE `nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `food`
--
ALTER TABLE `food`
  ADD CONSTRAINT `fk_food_nutrition_id` FOREIGN KEY (`nutritionID`) REFERENCES `nutrition` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_food_user_id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `nutrition`
--
ALTER TABLE `nutrition`
  ADD CONSTRAINT `fk_nutrition_user_id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
