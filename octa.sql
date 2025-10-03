-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 02, 2025 at 01:37 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `octa`
--

-- --------------------------------------------------------

--
-- Table structure for table `gold_distribution`
--

CREATE TABLE `gold_distribution` (
  `id` int NOT NULL,
  `player_name` varchar(100) NOT NULL,
  `category` enum('Officer','Cross-Server Event','Monthly Jotun') NOT NULL,
  `gold_amount` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gold_stock`
--

CREATE TABLE `gold_stock` (
  `id` int NOT NULL,
  `total_gold` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gold_stock`
--

INSERT INTO `gold_stock` (`id`, `total_gold`) VALUES
(1, 203739);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `gold_distribution`
--
ALTER TABLE `gold_distribution`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gold_stock`
--
ALTER TABLE `gold_stock`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `gold_distribution`
--
ALTER TABLE `gold_distribution`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gold_stock`
--
ALTER TABLE `gold_stock`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
