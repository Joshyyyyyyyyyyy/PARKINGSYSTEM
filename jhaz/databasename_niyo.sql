-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 04:03 AM
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
-- Database: `databasename niyo`
--

-- --------------------------------------------------------

--
-- Table structure for table `table na name niyo`
--

CREATE TABLE `table na name niyo` (
  `id` int(80) NOT NULL,
  `name` varchar(80) NOT NULL,
  `vehicle_type` varchar(80) NOT NULL,
  `registration` varchar(80) NOT NULL,
  `slot_occupied` varchar(80) NOT NULL,
  `date` varchar(80) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `table na name niyo`
--

INSERT INTO `table na name niyo` (`id`, `name`, `vehicle_type`, `registration`, `slot_occupied`, `date`) VALUES
(1, 'Jhaz', 'idk', '211141', '1', '1223213');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
