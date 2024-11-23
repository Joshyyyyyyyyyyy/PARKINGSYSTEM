-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2024 at 10:44 AM
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
-- Database: `db2`
--

-- --------------------------------------------------------

--
-- Table structure for table `information_management`
--

CREATE TABLE `information_management` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `registration` varchar(50) DEFAULT NULL,
  `slot_number` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `time_out` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `information_management`
--

INSERT INTO `information_management` (`id`, `name`, `vehicle_type`, `customer_type`, `registration`, `slot_number`, `date`, `time`, `price`, `time_out`) VALUES
(16, 'Josdhua', '4wheeler', 'VIP', '4215451241', 4, '2024-11-10', '23:55:00', 0.00, '2010-11-15 00:00:00'),
(17, 'Josdhua', '4wheeler', 'VIP', '4215451241', 4, '2024-11-10', '23:55:00', 0.00, NULL),
(18, 'joshuaaa', '6wheeler', 'VIP', '4215451241', 1, '2024-11-10', '23:15:00', 0.00, NULL),
(19, 'sgfdhgsgds', '6wheeler', 'Regular', '3252532', 11, '2024-11-11', '11:05:00', 20.00, NULL),
(20, 'sgfdhgsgds', '6wheeler', 'Regular', '3252532', 11, '2024-11-11', '11:05:00', 20.00, NULL),
(21, 'sgfdhgsgds', '6wheeler', 'Regular', '3252532', 11, '2024-11-11', '11:05:00', 20.00, NULL),
(22, 'Josdhua', '6wheeler', 'VIP', '12414141', 3, '2024-11-10', '22:53:00', 0.00, NULL),
(23, 'suruiz', '2wheeler', 'VIP', '215351241', 1, '2024-11-11', '12:39:00', 0.00, NULL),
(24, 'suruiz', '2wheeler', 'VIP', '215351241', 1, '2024-11-11', '12:39:00', 0.00, NULL),
(25, 'suruiz', '2wheeler', 'VIP', '215351241', 1, '2024-11-11', '12:39:00', 0.00, NULL),
(26, 'suruiz', '2wheeler', 'VIP', '215351241', 1, '2024-11-11', '12:39:00', 0.00, NULL),
(27, 'suruiz', '2wheeler', 'VIP', '215351241', 1, '2024-11-11', '12:39:00', 0.00, NULL),
(28, 'suruiz', '4wheeler', 'VIP', '9877978', 2, '2024-11-11', '15:19:00', 0.00, NULL),
(29, 'suruiz', '4wheeler', 'VIP', '9877978', 2, '2024-11-11', '15:19:00', 0.00, NULL),
(30, 'suruiz', '4wheeler', 'VIP', '9877978', 2, '2024-11-11', '15:19:00', 0.00, NULL),
(31, 'Joshua', '6wheeler', 'Regular', '421541351', 31, '2024-11-11', '23:36:00', 40.00, NULL),
(32, 'DSGSDGSGSGS', '6wheeler', 'VIP', '3523675632', 1, '2024-11-11', '23:58:00', 0.00, NULL),
(33, 'DSGSDGSGSGS', '6wheeler', 'VIP', '3523675632', 1, '2024-11-11', '23:58:00', 0.00, NULL),
(34, 'suruiz', '6wheeler', 'VIP', '12414141', 3, '2024-11-12', '10:20:00', 0.00, NULL),
(35, 'suruiz', '6wheeler', 'VIP', '12414141', 3, '2024-11-12', '10:20:00', 0.00, NULL),
(36, 'joshuaa', '6wheeler', 'Regular', '3529-5832-892', 32, '2024-11-12', '10:24:00', 0.00, NULL),
(37, 'SUruiz', '6wheeler', 'Regular', '2143124151', 31, '2024-11-12', '20:54:00', 60.00, NULL),
(38, 'joshuaa', '6wheeler', 'Regular', '3529-5832-892', 32, '2024-11-12', '10:24:00', 0.00, NULL),
(39, 'suruiz', '6wheeler', 'Regular', '3529-5832-892', 33, '2024-11-12', '10:25:00', 60.00, NULL),
(40, 'suruiz', '6wheeler', 'Regular', '3529-5832-892', 33, '2024-11-12', '10:25:00', 60.00, NULL),
(41, 'suruiz', '6wheeler', 'Regular', '3529-5832-892', 33, '2024-11-12', '10:25:00', 60.00, NULL),
(42, 'suruiz', '6wheeler', 'Regular', '3529-5832-892', 33, '2024-11-12', '10:25:00', 60.00, NULL),
(43, 'suruiz', '6wheeler', 'Regular', '3529-5832-892', 34, '2024-11-12', '10:39:00', 60.00, NULL),
(44, 'suruiz', '6wheeler', 'Regular', '3529-5832-892', 34, '2024-11-12', '10:39:00', 60.00, NULL),
(45, 'suruiz', '6wheeler', 'Regular', '3467226262', 33, '2024-11-12', '22:09:00', 60.00, NULL),
(46, 'suruiz', '6wheeler', 'Regular', '6316115151', 31, '2024-11-12', '21:58:00', 60.00, NULL),
(47, 'SURUIZ', '6wheeler', 'VIP', '52352453242', 1, '2024-11-12', '21:12:00', 0.00, NULL),
(48, 'suruiz', '6wheeler', 'VIP', '224726325252', 2, '2024-11-12', '21:56:00', 0.00, NULL),
(49, 'Josh', '4wheeler', 'Regular', '8942981808', 31, '2024-11-12', '23:47:00', 60.00, NULL),
(50, 'Joshyy', '6wheeler', 'VIP', '125165151', 1, '2024-11-13', '00:29:00', 0.00, NULL),
(51, 'Joshua ', '6wheeler', 'Regular', '24772742762', 33, '2024-11-13', '00:55:00', 60.00, NULL),
(52, 'Suruiz', '6wheeler', 'Regular', '789978978978', 31, '2024-11-13', '11:10:00', 60.00, NULL),
(53, 'Joshyua', '6wheeler', 'VIP', '1421411', 1, '2024-11-13', '11:14:00', 0.00, NULL),
(54, 'Joshua', '6wheeler', 'VIP', '2362252532', 3, '2024-11-13', '12:57:00', 0.00, NULL),
(55, 'Suruiz', '6wheeler', 'Regular', '2362252532', 31, '2024-11-13', '12:57:00', 60.00, NULL),
(56, 'JOSHYY', '4wheeler', 'Regular', '929529-03-032', 34, '2024-11-13', '13:08:00', 60.00, NULL),
(57, 'Joshua', '6wheeler', 'VIP', '43810010', 6, '2024-11-13', '13:17:00', 0.00, NULL),
(58, 'suruiz', '6wheeler', 'VIP', '483439340990', 5, '2024-11-13', '14:54:00', 0.00, NULL),
(59, 'JOshdua', '6wheeler', 'Regular', '3529-5832-892', 37, '2024-11-13', '13:18:00', 60.00, NULL),
(60, 'JOSHUA', '4wheeler', 'Regular', '23623253242', 39, '2024-11-13', '13:31:00', 60.00, NULL),
(61, 'Joshua', '4wheeler', 'Regular', '3529-5832-892', 40, '2024-11-13', '13:54:00', 40.00, NULL),
(62, 'SURUIZ', '6wheeler', 'Regular', '322424242', 32, '2024-11-16', '15:35:00', 60.00, NULL),
(64, 'JOshua', '6wheeler', 'VIP', '4114321313213', 7, '2024-11-13', '21:45:00', 0.00, NULL),
(65, 'suruiz', '4wheeler', 'VIP', '3167656757', 30, '2024-11-16', '16:42:00', 0.00, NULL),
(66, 'JOSHYY', '4wheeler', 'VIP', '32194093820321', 8, '2024-11-13', '22:37:00', 140.00, NULL),
(67, 'Joshua', '4wheeler', 'Regular', '31412413132', 31, '2024-11-13', '23:29:00', 280.00, NULL),
(68, 'Test', '4wheeler', 'Regular', '241414142', 31, '2024-11-17', '16:22:00', 120.00, NULL),
(69, 'test2', '4wheeler', 'Regular', '12414141', 32, '2024-11-17', '16:28:00', 140.00, NULL),
(70, 'test3', '4wheeler', 'Regular', '45142141421', 31, '2024-11-17', '16:34:00', 80.00, NULL),
(71, 'TEST4', '2wheeler', 'Regular', '2414141421', 32, '2024-11-17', '16:37:00', 20.00, NULL),
(72, 'test5', '2wheeler', 'VIP', '3515153151', 5, '2024-11-17', '16:42:00', 0.00, NULL),
(73, 'TEST6', '2wheeler', 'Regular', '2414141414', 31, '2024-11-17', '16:49:00', 0.00, NULL),
(74, 'TEST7', '4wheeler', 'Regular', '2311414214211', 31, '2024-11-17', '16:52:00', 20.00, NULL),
(75, 'TEST8', '4wheeler', 'Regular', '12414141', 31, '2024-11-17', '17:16:00', 0.00, NULL),
(76, 'TEST9', '4wheeler', 'Regular', '42124141241', 31, '2024-11-17', '17:16:00', 20.00, NULL),
(77, 'TEST10', '4wheeler', 'Regular', '2441512414', 31, '2024-11-17', '17:26:00', 20.00, '2024-11-17 17:27:16'),
(78, 'test11', '4wheeler', 'Regular', '4215451241', 31, '2024-11-17', '17:33:00', 20.00, '2024-11-17 17:34:01'),
(79, 'test12', '2wheeler', 'VIP', '42141421421', 5, '2024-11-17', '18:16:00', 0.00, '2024-11-17 18:16:44'),
(80, 'test13', '2wheeler', 'VIP', '2141421414', 5, '2024-11-17', '18:17:00', 0.00, '2024-11-17 18:18:15'),
(81, 'test14', '2wheeler', 'Regular', '2411414141', 32, '2024-11-17', '18:49:00', 0.00, '2024-11-17 18:49:45'),
(82, 'TEST2', '2wheeler', 'Regular', '3124141421', 31, '2024-11-18', '13:27:00', 20.00, '2024-11-18 13:28:36'),
(83, 'TEST2', '4wheeler', 'Regular', '3415153141', 31, '2024-11-18', '13:45:00', 0.00, '2024-11-18 13:45:45'),
(84, 'test3', '4wheeler', 'Regular', '523525242', 31, '2024-11-18', '13:55:00', 20.00, '2024-11-18 13:56:05'),
(85, 'test3', '4wheeler', 'Regular', '5152141414', 31, '2024-11-18', '14:11:00', 0.00, '2024-11-18 14:11:27'),
(86, 'test4', '4wheeler', 'Regular', '2413132111', 31, '2024-11-18', '14:25:00', 20.00, '2024-11-18 14:26:28'),
(87, 'test5', '2wheeler', 'Regular', '24141421541', 31, '2024-11-18', '14:28:00', 20.00, '2024-11-18 14:29:14'),
(88, 'Joshuaaaaatest', '6wheeler', 'VIP', '43242424242', 6, '2024-11-15', '00:43:00', 0.00, '2024-11-18 14:32:44'),
(89, 'test6', '2wheeler', 'Regular', '2142142141', 31, '2024-11-18', '14:32:00', 20.00, '2024-11-18 14:36:19'),
(90, 'test7', '4wheeler', 'Regular', '4124151251', 31, '2024-11-18', '14:38:00', 0.00, '2024-11-18 14:38:48'),
(91, 'test8', '4wheeler', 'Regular', '214115511', 31, '2024-11-18', '14:40:00', 20.00, '2024-11-18 14:41:09'),
(92, 'test8', '4wheeler', 'Regular', '124121251', 31, '2024-11-18', '14:44:00', 20.00, '2024-11-18 14:45:17'),
(93, 'test9', '4wheeler', 'Regular', '124124251412', 31, '2024-11-18', '14:50:00', 0.00, '2024-11-18 14:50:57'),
(94, 'test9', '2wheeler', 'Regular', '632532543141', 31, '2024-11-18', '14:57:00', 20.00, '2024-11-18 14:58:22'),
(95, 'test10', '2wheeler', 'Regular', '2141114141421', 31, '2024-11-18', '14:59:00', 20.00, '2024-11-18 15:00:28'),
(96, 'test11', '2wheeler', 'VIP', '241414214131', 5, '2024-11-18', '16:00:00', 0.00, '2024-11-18 17:00:27'),
(97, 'test11', '2wheeler', 'Regular', '241414214131', 100, '2024-11-18', '16:00:00', 20.00, '2024-11-18 17:00:44'),
(98, 'test11', '2wheeler', 'VIP', '241414214131', 6, '2024-11-18', '16:00:00', 0.00, '2024-11-18 17:00:52'),
(99, 'test14', '2wheeler', 'Regular', '24141411', 32, '2024-11-18', '17:02:00', 20.00, '2024-11-18 18:50:38'),
(100, 'test1', '2wheeler', 'Regular', '31561531412421', 44, '2024-11-19', '14:21:00', 0.00, '2024-11-19 14:21:29'),
(101, 'test2', '2wheeler', 'Regular', '4243141412', 44, '2024-11-19', '14:22:00', 20.00, '2024-11-19 14:23:14'),
(102, 'test1', '2-wheeler', 'Regular', '215151241421', 55, '2024-11-19', '16:56:00', 20.00, '2024-11-20 16:33:07'),
(103, 'test14', '4-wheeler', 'Regular', '24141411', 39, '2024-11-18', '17:02:00', 20.00, '2024-11-20 16:33:34'),
(104, 'test14', '2wheeler', 'Regular', '24141411', 33, '2024-11-18', '17:02:00', 20.00, '2024-11-20 16:34:35'),
(105, 'test14', '2wheeler', 'Regular', '24141411', 32, '2024-11-18', '17:02:00', 20.00, '2024-11-20 16:39:07'),
(106, 'test14', '2wheeler', 'Regular', '24141411', 31, '2024-11-18', '17:02:00', 20.00, '2024-11-20 16:43:01'),
(107, 'JOshuaaaaa', '4wheeler', 'VIP', '41414121', 4, '2024-11-14', '22:27:00', 0.00, '2024-11-20 16:43:14'),
(108, 'Suruiz', '4wheeler', 'VIP', '21414121421', 2, '2024-11-13', '23:20:00', 0.00, '2024-11-20 16:43:23'),
(109, 'JOshua', '4wheeler', 'VIP', '43141421231321', 1, '2024-11-13', '23:00:00', 0.00, '2024-11-20 16:43:33'),
(110, 'Joshua', '6wheeler', 'VIP', '24141411', 3, '2024-11-13', '23:19:00', 0.00, '2024-11-20 16:43:36'),
(111, 'test1', '4wheeler', 'Regular', '6421978419', 31, '2024-11-20', '16:44:00', 20.00, '2024-11-20 16:46:08'),
(112, 'test2', '6wheeler', 'Regular', '21414141', 31, '2024-11-20', '16:52:00', 20.00, '2024-11-20 16:53:44'),
(113, 'TEST4', '6wheeler', 'Regular', '413332242', 31, '2024-11-20', '16:56:00', 20.00, '2024-11-20 16:57:42'),
(114, 'test3', '4wheeler', 'Regular', '21414141', 32, '2024-11-20', '16:53:00', 20.00, '2024-11-20 16:57:57'),
(115, 'TEST3', '6wheeler', 'Regular', '43242424', 31, '2024-11-20', '16:58:00', 20.00, '2024-11-20 16:59:18'),
(116, 'TEST', '6wheeler', 'Regular', '414112', 36, '2024-11-20', '17:00:00', 20.00, '2024-11-20 17:05:24'),
(117, 'TEST', '6wheeler', 'Regular', '32421141', 34, '2024-11-20', '17:00:00', 20.00, '2024-11-20 17:05:48'),
(118, 'TEST', '6wheeler', 'Regular', '21313132', 31, '2024-11-20', '16:59:00', 20.00, '2024-11-20 17:08:37'),
(119, 'TEST6', '6wheeler', 'Regular', '2434252532', 32, '2024-11-20', '11:58:00', 60.00, '2024-11-20 17:10:03'),
(120, 'TEST', '2wheeler', 'Regular', '2314141', 31, '2024-11-20', '11:11:00', 80.00, '2024-11-20 17:12:16'),
(121, 'TEST', '4wheeler', 'Regular', '4233111412', 31, '2024-11-20', '10:14:00', 80.00, '2024-11-20 17:15:44'),
(122, 'TEST', '4wheeler', 'Regular', '321313131', 31, '2024-11-20', '18:29:00', 20.00, '2024-11-20 18:48:31'),
(123, 'test2', '4wheeler', 'Regular', '23214141', 31, '2024-11-20', '18:52:00', 0.00, '2024-11-20 18:52:27'),
(124, 'test', '2-wheeler', 'VIP', '1213131', 17, '2024-11-20', '13:26:00', 0.00, '2024-11-21 13:28:10'),
(125, 'test1', '4wheeler', 'Regular', '1231314214', 36, '2024-11-21', '13:28:00', 20.00, '2024-11-21 13:29:14'),
(126, 'test1', '4wheeler', 'Regular', 'NGT314', 40, '2024-11-21', '13:38:00', 20.00, '2024-11-21 13:43:10'),
(127, 'TEST1', '2-wheeler', 'VIP', '214JKSA', 12, '2024-11-21', '13:47:00', 0.00, '2024-11-21 13:49:23'),
(128, 'rewrwre', '4wheeler', 'Regular', '123122', 32, '2024-11-21', '14:12:00', 0.00, '2024-11-21 14:12:34');

-- --------------------------------------------------------

--
-- Table structure for table `parking_slots`
--

CREATE TABLE `parking_slots` (
  `id` int(11) NOT NULL,
  `slot_number` int(11) NOT NULL,
  `slot_type` enum('VIP','Regular') NOT NULL,
  `status` enum('Available','Occupied') DEFAULT 'Available',
  `vehicle_id` int(11) DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `parking_slots`
--

INSERT INTO `parking_slots` (`id`, `slot_number`, `slot_type`, `status`, `vehicle_id`, `date`) VALUES
(1, 1, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(2, 2, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(3, 3, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(4, 4, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(5, 5, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(6, 6, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(7, 7, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(8, 8, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(9, 9, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(10, 10, 'VIP', 'Available', NULL, '2024-11-10 02:55:02'),
(11, 11, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(12, 12, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(13, 13, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(14, 14, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(15, 15, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(16, 16, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(17, 17, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(18, 18, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(19, 19, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(20, 20, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(21, 21, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(22, 22, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(23, 23, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(24, 24, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(25, 25, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(26, 26, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(27, 27, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(28, 28, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(29, 29, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(30, 30, 'VIP', 'Available', NULL, '2024-11-10 02:55:15'),
(31, 31, 'Regular', 'Occupied', NULL, '2024-11-09 18:55:15'),
(32, 32, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(33, 33, 'Regular', 'Occupied', NULL, '2024-11-09 18:55:15'),
(34, 34, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(35, 35, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(36, 36, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(37, 37, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(38, 38, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(39, 39, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(40, 40, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(41, 41, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(42, 42, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(43, 43, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(44, 44, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(45, 45, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(46, 46, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(47, 47, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(48, 48, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(49, 49, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(50, 50, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(51, 51, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(52, 52, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(53, 53, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(54, 54, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(55, 55, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(56, 56, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(57, 57, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(58, 58, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(59, 59, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(60, 60, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(61, 61, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(62, 62, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(63, 63, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(64, 64, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(65, 65, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(66, 66, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(67, 67, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(68, 68, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(69, 69, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(70, 70, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(71, 71, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(72, 72, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(73, 73, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(74, 74, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(75, 75, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(76, 76, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(77, 77, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(78, 78, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(79, 79, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(80, 80, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(81, 81, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(82, 82, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(83, 83, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(84, 84, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(85, 85, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(86, 86, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(87, 87, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(88, 88, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(89, 89, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(90, 90, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(91, 91, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(92, 92, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(93, 93, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(94, 94, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(95, 95, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(96, 96, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(97, 97, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(98, 98, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(99, 99, 'Regular', 'Available', NULL, '2024-11-09 18:55:15'),
(100, 100, 'Regular', 'Available', NULL, '2024-11-09 18:55:15');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','attendant') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(6, 'admin1', '$2y$10$LKWlVKQzFAePZkKLeYlU1.JTSBJbkCq2Xsp2woWr9ws8s2XVQiXam', 'admin'),
(7, 'parkingattendant', '$2y$10$lXgMCGjOz8OzCC9kc39LverRDp0TfGJqOh/tKi7RGxbHPLC/BwcWq', 'attendant'),
(8, 'admin', '$2y$10$ii5XYHO2DdzaWc/lljS5..3qyd8ENu3F9Vuniw1nQcGY0ouk1G2p.', 'admin'),
(9, 'admin3', '$2y$10$RExWFdlaZfoo4cMiO0.WK.1w4qIF24N11qcp1g32z.eYejcAKh5Dm', 'admin'),
(10, 'parkingattendant3', '$2y$10$rRWk.A0FV3vMpdzJG0/5t.4FW7EG36auGDL0lFX9mMAFoqF9btMTi', 'attendant'),
(13, 'test1', '$2y$10$Y2gJqxC9/OcEHGpCkBmfYOqBsd8fR.Rm3bZUwQV6PyC09XsyPEblS', 'attendant');

-- --------------------------------------------------------

--
-- Table structure for table `vehicle_entries`
--

CREATE TABLE `vehicle_entries` (
  `id` int(11) NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `vehicle_type` varchar(50) DEFAULT NULL,
  `customer_type` varchar(50) DEFAULT NULL,
  `registration` varchar(50) DEFAULT NULL,
  `slot_number` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `time` time DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `status` varchar(10) DEFAULT 'In'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vehicle_entries`
--

INSERT INTO `vehicle_entries` (`id`, `name`, `vehicle_type`, `customer_type`, `registration`, `slot_number`, `date`, `time`, `price`, `status`) VALUES
(132, 'test', '2-wheeler', 'Regular', '2141413132', 33, '2024-11-20', '19:30:00', 0.00, 'In'),
(133, 'test', '2-wheeler', 'Regular', '2141413132', 31, '2024-11-20', '19:30:00', 0.00, 'In');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `information_management`
--
ALTER TABLE `information_management`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parking_slots`
--
ALTER TABLE `parking_slots`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idx_slot_number` (`slot_number`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vehicle_entries`
--
ALTER TABLE `vehicle_entries`
  ADD PRIMARY KEY (`id`),
  ADD KEY `slot_number` (`slot_number`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `information_management`
--
ALTER TABLE `information_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=129;

--
-- AUTO_INCREMENT for table `parking_slots`
--
ALTER TABLE `parking_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `vehicle_entries`
--
ALTER TABLE `vehicle_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=139;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vehicle_entries`
--
ALTER TABLE `vehicle_entries`
  ADD CONSTRAINT `vehicle_entries_ibfk_1` FOREIGN KEY (`slot_number`) REFERENCES `parking_slots` (`slot_number`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
