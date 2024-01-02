-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 02, 2024 at 01:21 AM
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
-- Database: `fitness`
--

-- --------------------------------------------------------

--
-- Table structure for table `fasting`
--

CREATE TABLE `fasting` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `startTime` bigint(20) NOT NULL,
  `endTime` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fasting`
--

INSERT INTO `fasting` (`id`, `user_id`, `startTime`, `endTime`) VALUES
(1, 54, 122222222, 11222222222);

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
(25, 52, 'Diet Pepsi (16.9 oz)', '28798013', 53, '0', '1', 'L', 'Liked it 💯', 1702671230),
(26, 52, 'Pepperoni Topper Traditional Crust Pizza (Large)', '64947', 54, '460', '2', 'L', 'Loved it 😍 ', 1702671281),
(27, 52, 'Natural Vanilla Bean Ice Cream', '145646', 55, '240', '1', 'L', '', 1702671319),
(28, 52, 'Cosmic Stardust Energy Drink', '43520061', 56, '10', '1', 'B', '', 1702671368);

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
(53, 52, '0', '0', '0', 1702671230),
(54, 52, '20', '44', '22', 1702671281),
(55, 52, '5', '28', '12', 1702671319),
(56, 52, '0', '4', '0', 1702671368);

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
  `created_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `avatar`, `created_at`) VALUES
(52, 'Levi', 'okoye', 'leviokoye@gmail.com', '$2y$10$4A.yQ6ST62sBsj.f9BSQweJkZSfIot7AtW9d8xaWFFwq/3Kzb6Z3y', NULL, 1702671162),
(53, 'James', 'peters', 'hello', '$2y$10$OBcBsDH/YrF/zv3SNEQsSumfs39I4Dk/e7eV3wlZVT6sWdcR/F94m', NULL, 1703258195),
(54, 'Levi', 'Okoye', 'leviokoye@gmail.com1', '$2y$10$EXeKiU7r3VVJVlRl06juPusbo4saEe.44251jev/7qfdop08CAiAu', NULL, 1703967939);

-- --------------------------------------------------------

--
-- Table structure for table `user_profile`
--

CREATE TABLE `user_profile` (
  `user_id` int(11) NOT NULL,
  `age` int(11) NOT NULL,
  `gender` enum('male','female','other','') NOT NULL,
  `daily_calories` int(11) NOT NULL,
  `weight` decimal(10,0) NOT NULL,
  `height` decimal(10,0) NOT NULL,
  `activity_level` enum('Sedentary','Lightly Active','Active','Very Active') NOT NULL,
  `goal_weight` decimal(10,0) NOT NULL,
  `dietary_preferences` varchar(255) DEFAULT NULL,
  `favorite_foods` text DEFAULT NULL,
  `disliked_foods` text DEFAULT NULL,
  `updated_at` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_profile`
--

INSERT INTO `user_profile` (`user_id`, `age`, `gender`, `daily_calories`, `weight`, `height`, `activity_level`, `goal_weight`, `dietary_preferences`, `favorite_foods`, `disliked_foods`, `updated_at`) VALUES
(52, 21, 'male', 187, 200, 6, 'Active', 2401, NULL, 'spaghetti,panda express,jersey mike\'s', 'fish', 1702671162),
(53, 3, 'male', 2500, 305, 201, 'Very Active', 240, NULL, '', '', 1703942816),
(54, 21, 'male', 3000, 308, 201, 'Very Active', 240, NULL, 'pasta', '', 1703967939);

-- --------------------------------------------------------

--
-- Table structure for table `weight_tracking`
--

CREATE TABLE `weight_tracking` (
  `user_id` int(11) NOT NULL,
  `weight` decimal(10,0) NOT NULL,
  `date` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `weight_tracking`
--

INSERT INTO `weight_tracking` (`user_id`, `weight`, `date`) VALUES
(52, 308, 1702671162),
(53, 305, 1703258195),
(54, 308, 1703967939);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fasting`
--
ALTER TABLE `fasting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fast_User_id_FK` (`user_id`);

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
-- Indexes for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `weight_tracking`
--
ALTER TABLE `weight_tracking`
  ADD PRIMARY KEY (`user_id`,`date`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fasting`
--
ALTER TABLE `fasting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `food`
--
ALTER TABLE `food`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `nutrition`
--
ALTER TABLE `nutrition`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `fasting`
--
ALTER TABLE `fasting`
  ADD CONSTRAINT `fast_User_id_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

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

--
-- Constraints for table `user_profile`
--
ALTER TABLE `user_profile`
  ADD CONSTRAINT `user_id_FK` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `weight_tracking`
--
ALTER TABLE `weight_tracking`
  ADD CONSTRAINT `user_id_FK_weight_tracking` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
