-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 28, 2024 at 10:17 AM
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
-- Database: `database1`
--

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `id` int(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  `vehicle_type` varchar(80) NOT NULL,
  `registration` varchar(80) NOT NULL,
  `slot_occupied` varchar(80) NOT NULL,
  `date` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`) VALUES
('joshua', 'admin'),
('admin', 'admin123');

-- --------------------------------------------------------

--
-- Table structure for table `parking_slots`
--

CREATE TABLE `parking_slots` (
  `id` int(11) NOT NULL,
  `slot_number` int(11) NOT NULL,
  `status` enum('available','occupied') DEFAULT 'available'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking_slots`
--

INSERT INTO `parking_slots` (`id`, `slot_number`, `status`) VALUES
(1, 1, 'available'),
(2, 2, 'available'),
(3, 3, 'available'),
(4, 4, 'available'),
(5, 5, 'available'),
(6, 6, 'available'),
(7, 7, 'available'),
(8, 8, 'available'),
(9, 9, 'available'),
(10, 10, 'available'),
(11, 11, 'available'),
(12, 12, 'available'),
(13, 13, 'available'),
(14, 14, 'available'),
(15, 15, 'available'),
(16, 16, 'available'),
(17, 17, 'available'),
(18, 18, 'available'),
(19, 19, 'available'),
(20, 20, 'available'),
(21, 21, 'available'),
(22, 22, 'available'),
(23, 23, 'available'),
(24, 24, 'available'),
(25, 25, 'available'),
(26, 26, 'available'),
(27, 27, 'available'),
(28, 28, 'available'),
(29, 29, 'available'),
(30, 30, 'available'),
(31, 31, 'available'),
(32, 32, 'available'),
(33, 33, 'available'),
(34, 34, 'available'),
(35, 35, 'available'),
(36, 36, 'available'),
(37, 37, 'available'),
(38, 38, 'available'),
(39, 39, 'available'),
(40, 40, 'available'),
(41, 41, 'available'),
(42, 42, 'available'),
(43, 43, 'available'),
(44, 44, 'available'),
(45, 45, 'available'),
(46, 46, 'available'),
(47, 47, 'available'),
(48, 48, 'available'),
(49, 49, 'available'),
(50, 50, 'available');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_slots`
--
ALTER TABLE `parking_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `slot_number` (`slot_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `id` int(80) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `parking_slots`
--
ALTER TABLE `parking_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
