-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2026 at 10:12 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 8.0.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grc`
--

-- --------------------------------------------------------

--
-- Table structure for table `action`
--

CREATE TABLE `action` (
  `id` int(11) NOT NULL,
  `process_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `risk_id` int(11) NOT NULL,
  `action` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `priority` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timeline` date DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `approval` int(11) NOT NULL DEFAULT 1,
  `uid_approve` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `approved_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `action`
--

INSERT INTO `action` (`id`, `process_id`, `dept_id`, `risk_id`, `action`, `status`, `priority`, `timeline`, `uid`, `approval`, `uid_approve`, `created_at`, `approved_at`, `updated_at`) VALUES
(1, 3, 1, 5, 'continuous monitoring', 'ongoing', 'Medium', '2025-10-15', 1, 2, '0000-00-00 00:00:00', '2025-10-15 15:12:58', '2025-10-15 22:28:26', '2025-10-15 15:12:58'),
(2, 8, 2, 12, 'Monitoring and Supervision\r\n', 'yes', 'Medium', '2025-10-15', 1, 2, '0000-00-00 00:00:00', '2025-10-15 23:26:20', '2025-10-15 22:28:34', '2025-10-15 23:26:20'),
(3, 11, 3, 15, 'Continuous monitoring\r\n', 'yes', 'Medium', '2025-10-16', 1, 2, '0000-00-00 00:00:00', '2025-10-16 01:53:44', '2025-10-16 08:11:44', '2025-10-16 01:53:44'),
(4, 28, 5, 45, 'Continuous monitoring\r\n', 'yes', 'Low', '2025-10-16', 1, 2, '0000-00-00 00:00:00', '2025-10-16 14:02:11', '2025-10-16 14:20:34', '2025-10-16 14:02:11'),
(5, 56, 8, 79, 'Continuous monitoring\r\n', 'yes', 'Medium', '2025-10-17', 1, 2, '0000-00-00 00:00:00', '2025-10-17 03:14:44', '2025-10-17 02:17:54', '2025-10-17 03:14:44');

-- --------------------------------------------------------

--
-- Table structure for table `assessment`
--

CREATE TABLE `assessment` (
  `id` int(11) NOT NULL,
  `risk_id` int(11) NOT NULL,
  `iimp` int(11) NOT NULL,
  `ilikely` int(11) NOT NULL,
  `rimp` int(11) NOT NULL,
  `rlikely` int(11) NOT NULL,
  `timp` int(11) NOT NULL,
  `tlikely` int(11) NOT NULL,
  `treatment` int(11) DEFAULT NULL,
  `apetite` int(11) NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `ass_uid` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `assessment`
--

INSERT INTO `assessment` (`id`, `risk_id`, `iimp`, `ilikely`, `rimp`, `rlikely`, `timp`, `tlikely`, `treatment`, `apetite`, `userid`, `ass_uid`, `created_at`, `updated_at`) VALUES
(1, 1, 4, 5, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 14:42:20', '2025-10-15 14:42:20'),
(2, 2, 4, 4, 2, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 14:44:39', '2025-10-15 14:44:39'),
(3, 3, 5, 5, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 14:47:41', '2025-10-15 14:47:41'),
(4, 4, 4, 4, 2, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 14:48:59', '2025-10-15 14:48:59'),
(5, 5, 4, 5, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 14:51:09', '2025-10-15 14:51:09'),
(6, 6, 4, 5, 4, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 14:52:44', '2025-10-15 14:52:44'),
(7, 7, 2, 5, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 14:56:12', '2025-10-15 14:56:12'),
(8, 8, 4, 3, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 15:04:50', '2025-10-15 15:04:50'),
(9, 9, 4, 4, 2, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 23:12:11', '2025-10-15 23:12:11'),
(10, 10, 4, 4, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 23:15:01', '2025-10-15 23:15:01'),
(11, 11, 5, 4, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 23:16:25', '2025-10-15 23:16:25'),
(12, 12, 4, 4, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 23:18:45', '2025-10-15 23:18:45'),
(13, 13, 4, 4, 4, 4, 1, 1, 4, 2, 1, 1, '2025-10-15 23:21:42', '2025-10-15 23:21:42'),
(14, 14, 4, 3, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-15 23:22:42', '2025-10-15 23:22:42'),
(15, 23, 3, 4, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-16 00:49:53', '2025-10-16 00:49:53'),
(16, 16, 5, 5, 3, 4, 1, 1, 4, 2, 1, 1, '2025-10-16 00:51:26', '2025-10-16 00:51:26'),
(17, 17, 4, 5, 2, 3, 1, 1, 4, 2, 1, 1, '2025-10-16 01:19:05', '2025-10-16 01:19:05'),
(18, 18, 4, 4, 2, 3, 1, 1, 4, 2, 1, 1, '2025-10-16 01:23:15', '2025-10-16 01:23:15'),
(19, 20, 3, 4, 2, 2, 1, 1, 4, 2, 1, 1, '2025-10-16 01:24:38', '2025-10-16 01:24:38'),
(20, 15, 5, 5, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-16 01:41:39', '2025-10-16 01:41:39'),
(21, 24, 3, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 01:47:05', '2025-10-16 01:47:05'),
(22, 21, 3, 3, 2, 2, 1, 1, NULL, 0, 1, NULL, '2025-10-16 01:48:18', '2025-10-16 01:48:18'),
(23, 22, 4, 4, 1, 2, 1, 1, NULL, 0, 1, NULL, '2025-10-16 01:49:34', '2025-10-16 01:49:34'),
(24, 23, 3, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 01:50:51', '2025-10-16 01:50:51'),
(25, 25, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:13:32', '2025-10-16 09:13:32'),
(26, 26, 5, 5, 5, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:14:30', '2025-10-16 09:14:30'),
(27, 27, 5, 5, 5, 5, 2, 2, NULL, 0, 1, NULL, '2025-10-16 09:21:17', '2025-10-16 09:21:17'),
(28, 28, 4, 5, 3, 2, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:22:03', '2025-10-16 09:22:03'),
(29, 29, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:23:01', '2025-10-16 09:23:01'),
(30, 30, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:24:15', '2025-10-16 09:24:15'),
(31, 31, 5, 5, 4, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:25:01', '2025-10-16 09:25:01'),
(32, 32, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:25:58', '2025-10-16 09:25:58'),
(33, 33, 4, 5, 3, 2, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:26:46', '2025-10-16 09:26:46'),
(34, 34, 5, 5, 2, 1, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:27:42', '2025-10-16 09:27:42'),
(35, 35, 4, 5, 3, 2, 1, 1, NULL, 0, 1, NULL, '2025-10-16 09:28:59', '2025-10-16 09:28:59'),
(36, 36, 5, 5, 3, 3, 1, 1, 4, 1, 1, 1, '2025-10-16 13:40:40', '2025-10-16 13:40:40'),
(37, 37, 3, 4, 2, 2, 1, 1, 4, 1, 1, 1, '2025-10-16 13:42:10', '2025-10-16 13:42:10'),
(38, 38, 4, 5, 3, 3, 1, 1, 4, 1, 1, 1, '2025-10-16 13:43:37', '2025-10-16 13:43:37'),
(39, 39, 4, 5, 3, 3, 1, 1, 4, 1, 1, 1, '2025-10-16 13:44:37', '2025-10-16 13:44:37'),
(40, 40, 3, 4, 2, 3, 1, 1, 4, 1, 1, 1, '2025-10-16 13:45:40', '2025-10-16 13:45:40'),
(41, 41, 3, 5, 2, 3, 1, 1, 4, 1, 1, 1, '2025-10-16 13:49:02', '2025-10-16 13:49:02'),
(42, 42, 4, 4, 2, 3, 1, 1, 4, 1, 1, 1, '2025-10-16 13:52:14', '2025-10-16 13:52:14'),
(43, 43, 5, 4, 2, 1, 1, 1, 4, 1, 1, 1, '2025-10-16 13:54:06', '2025-10-16 13:54:06'),
(44, 44, 3, 4, 2, 3, 1, 1, 4, 1, 1, 1, '2025-10-16 13:55:16', '2025-10-16 13:55:16'),
(45, 45, 5, 4, 2, 1, 1, 1, 4, 1, 1, 1, '2025-10-16 13:57:18', '2025-10-16 13:57:18'),
(46, 46, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 15:23:39', '2025-10-16 15:23:39'),
(47, 47, 4, 4, 4, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-16 15:36:29', '2025-10-16 15:36:29'),
(48, 48, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 15:37:12', '2025-10-16 15:37:12'),
(49, 49, 5, 5, 4, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-16 15:38:17', '2025-10-16 15:38:17'),
(50, 50, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 15:38:59', '2025-10-16 15:38:59'),
(51, 51, 4, 4, 4, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-16 15:39:46', '2025-10-16 15:39:46'),
(52, 52, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 15:40:40', '2025-10-16 15:40:40'),
(53, 53, 5, 5, 2, 1, 1, 1, NULL, 0, 1, NULL, '2025-10-16 15:41:47', '2025-10-16 15:41:47'),
(54, 54, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-16 15:42:27', '2025-10-16 15:42:27'),
(55, 55, 4, 5, 4, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-17 00:00:26', '2025-10-17 00:00:26'),
(56, 56, 3, 5, 3, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-17 00:02:00', '2025-10-17 00:02:00'),
(57, 57, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 00:04:02', '2025-10-17 00:04:02'),
(58, 66, 4, 4, 4, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-17 00:10:42', '2025-10-17 00:10:42'),
(59, 59, 5, 5, 4, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 00:12:16', '2025-10-17 00:12:16'),
(60, 60, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 00:13:32', '2025-10-17 00:13:32'),
(61, 61, 4, 3, 2, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 00:14:20', '2025-10-17 00:14:20'),
(62, 62, 5, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 00:15:28', '2025-10-17 00:15:28'),
(63, 62, 5, 4, 3, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-17 01:04:39', '2025-10-17 01:04:39'),
(64, 71, 5, 5, 4, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 01:34:57', '2025-10-17 01:34:57'),
(65, 68, 4, 3, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 01:37:52', '2025-10-17 01:37:52'),
(66, 63, 3, 4, 3, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-17 01:42:38', '2025-10-17 01:42:38'),
(67, 64, 4, 3, 2, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 01:43:41', '2025-10-17 01:43:41'),
(68, 65, 5, 5, 2, 1, 1, 1, NULL, 0, 1, NULL, '2025-10-17 01:45:10', '2025-10-17 01:45:10'),
(69, 58, 5, 5, 4, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 01:47:46', '2025-10-17 01:47:46'),
(70, 72, 5, 5, 3, 3, 1, 1, 4, 1, 1, 1, '2025-10-17 02:48:04', '2025-10-17 02:48:04'),
(71, 73, 4, 5, 3, 4, 1, 1, 4, 2, 1, 1, '2025-10-17 02:52:42', '2025-10-17 02:52:42'),
(72, 74, 5, 5, 4, 4, 1, 1, 4, 2, 1, 1, '2025-10-17 02:53:59', '2025-10-17 02:53:59'),
(73, 81, 5, 5, 3, 3, 1, 1, 4, 1, 1, 1, '2025-10-17 02:58:35', '2025-10-17 02:58:35'),
(74, 75, 4, 5, 3, 3, 1, 1, 4, 2, 1, 1, '2025-10-17 03:02:15', '2025-10-17 03:02:15'),
(75, 76, 4, 5, 3, 3, 1, 1, 4, 1, 1, 1, '2025-10-17 03:06:52', '2025-10-17 03:06:52'),
(76, 77, 4, 5, 3, 3, 1, 1, 4, 1, 1, 1, '2025-10-17 03:08:44', '2025-10-17 03:08:44'),
(77, 78, 4, 5, 2, 3, 1, 1, 4, 1, 1, 1, '2025-10-17 03:09:25', '2025-10-17 03:09:25'),
(78, 79, 5, 5, 2, 2, 1, 1, 4, 1, 1, 1, '2025-10-17 03:11:21', '2025-10-17 03:11:21'),
(79, 80, 5, 5, 3, 3, 1, 1, 3, 1, 1, 1, '2025-10-17 03:12:25', '2025-10-17 03:12:25'),
(80, 82, 3, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 11:16:49', '2025-10-17 11:16:49'),
(81, 83, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 11:17:28', '2025-10-17 11:17:28'),
(82, 84, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 11:18:21', '2025-10-17 11:18:21'),
(83, 85, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 11:21:55', '2025-10-17 11:21:55'),
(84, 86, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 11:22:58', '2025-10-17 11:22:58'),
(85, 87, 4, 4, 3, 4, 1, 1, NULL, 0, 1, NULL, '2025-10-17 11:24:37', '2025-10-17 11:24:37'),
(86, 88, 4, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 11:25:30', '2025-10-17 11:25:30'),
(87, 89, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2025-10-17 11:26:24', '2025-10-17 11:26:24'),
(88, 90, 4, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-01-30 14:31:42', '2026-01-30 14:31:42'),
(89, 92, 3, 3, 1, 2, 1, 1, NULL, 0, 1, NULL, '2026-01-31 18:04:30', '2026-01-31 18:04:30'),
(90, 93, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-01-31 18:05:44', '2026-01-31 18:05:44'),
(91, 94, 4, 4, 2, 1, 1, 1, NULL, 0, 1, NULL, '2026-01-31 18:06:47', '2026-01-31 18:06:47'),
(92, 95, 4, 4, 1, 2, 1, 1, NULL, 0, 1, NULL, '2026-01-31 18:07:46', '2026-01-31 18:07:46'),
(93, 96, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-01-31 18:08:45', '2026-01-31 18:08:45'),
(94, 97, 5, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-01-31 18:10:01', '2026-01-31 18:10:01'),
(95, 98, 5, 4, 2, 1, 1, 1, NULL, 0, 1, NULL, '2026-01-31 18:10:49', '2026-01-31 18:10:49'),
(96, 99, 5, 5, 4, 3, 1, 1, NULL, 0, 1, NULL, '2026-01-31 21:15:47', '2026-01-31 21:15:47'),
(97, 100, 3, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-01-31 21:17:33', '2026-01-31 21:17:33'),
(98, 101, 5, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-01-31 21:18:55', '2026-01-31 21:18:55'),
(99, 102, 4, 4, 3, 2, 1, 1, NULL, 0, 1, NULL, '2026-01-31 21:20:52', '2026-01-31 21:20:52'),
(100, 103, 3, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-01-31 21:22:06', '2026-01-31 21:22:06'),
(101, 104, 4, 3, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-01-31 21:23:13', '2026-01-31 21:23:13'),
(102, 105, 5, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-01-31 21:24:21', '2026-01-31 21:24:21'),
(103, 106, 4, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-01-31 21:25:12', '2026-01-31 21:25:12'),
(104, 107, 4, 4, 1, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:06:05', '2026-02-01 21:06:05'),
(105, 108, 4, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:07:35', '2026-02-01 21:07:35'),
(106, 109, 4, 5, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:08:51', '2026-02-01 21:08:51'),
(107, 110, 3, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:09:57', '2026-02-01 21:09:57'),
(108, 111, 3, 3, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:10:46', '2026-02-01 21:10:46'),
(109, 112, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:11:40', '2026-02-01 21:11:40'),
(110, 113, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:50:48', '2026-02-01 21:50:48'),
(111, 115, 4, 4, 3, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:51:51', '2026-02-01 21:51:51'),
(112, 114, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:52:44', '2026-02-01 21:52:44'),
(113, 116, 3, 4, 1, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:53:51', '2026-02-01 21:53:51'),
(114, 117, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:55:16', '2026-02-01 21:55:16'),
(115, 118, 4, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-01 21:56:15', '2026-02-01 21:56:15'),
(116, 119, 4, 5, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-01 23:43:38', '2026-02-01 23:43:38'),
(117, 120, 4, 5, 2, 4, 1, 1, NULL, 0, 1, NULL, '2026-02-01 23:44:35', '2026-02-01 23:44:35'),
(118, 121, 5, 3, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-01 23:45:44', '2026-02-01 23:45:44'),
(119, 122, 3, 4, 2, 1, 1, 1, NULL, 0, 1, NULL, '2026-02-01 23:47:04', '2026-02-01 23:47:04'),
(120, 123, 3, 3, 2, 1, 1, 1, NULL, 0, 1, NULL, '2026-02-01 23:48:14', '2026-02-01 23:48:14'),
(121, 124, 4, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-01 23:49:35', '2026-02-01 23:49:35'),
(123, 126, 5, 5, 3, 4, 1, 1, NULL, 0, 1, NULL, '2026-02-02 17:02:08', '2026-02-02 17:02:08'),
(124, 127, 4, 5, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-02 17:03:51', '2026-02-02 17:03:51'),
(125, 128, 4, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-02 17:05:14', '2026-02-02 17:05:14'),
(126, 129, 3, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-02 17:09:39', '2026-02-02 17:09:39'),
(127, 130, 3, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-02 17:15:04', '2026-02-02 17:15:04'),
(128, 131, 3, 3, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-02 17:16:17', '2026-02-02 17:16:17'),
(129, 132, 4, 4, 1, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-02 17:17:12', '2026-02-02 17:17:12'),
(130, 133, 3, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-02 17:18:00', '2026-02-02 17:18:00'),
(131, 125, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-02 17:18:48', '2026-02-02 17:18:48'),
(132, 134, 3, 3, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 06:43:49', '2026-02-03 06:43:49'),
(133, 135, 3, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-03 06:44:44', '2026-02-03 06:44:44'),
(134, 136, 4, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-03 06:46:21', '2026-02-03 06:46:21'),
(135, 137, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 06:47:38', '2026-02-03 06:47:38'),
(136, 139, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:14:46', '2026-02-03 09:14:46'),
(137, 140, 5, 5, 3, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:15:46', '2026-02-03 09:15:46'),
(138, 141, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:17:41', '2026-02-03 09:17:41'),
(139, 142, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:18:57', '2026-02-03 09:18:57'),
(140, 143, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:20:07', '2026-02-03 09:20:07'),
(141, 144, 4, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:21:24', '2026-02-03 09:21:24'),
(142, 145, 4, 4, 3, 4, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:24:46', '2026-02-03 09:24:46'),
(143, 146, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:25:48', '2026-02-03 09:25:48'),
(144, 147, 4, 5, 3, 4, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:27:13', '2026-02-03 09:27:13'),
(145, 148, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 09:29:12', '2026-02-03 09:29:12'),
(146, 149, 5, 5, 3, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-03 14:18:01', '2026-02-03 14:18:01'),
(147, 150, 5, 5, 3, 5, 1, 1, NULL, 0, 1, NULL, '2026-02-03 14:20:00', '2026-02-03 14:20:00'),
(148, 151, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 14:21:26', '2026-02-03 14:21:26'),
(149, 152, 5, 5, 3, 5, 1, 1, NULL, 0, 1, NULL, '2026-02-03 14:22:44', '2026-02-03 14:22:44'),
(150, 154, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 19:53:43', '2026-02-03 19:53:43'),
(151, 155, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 19:54:41', '2026-02-03 19:54:41'),
(152, 156, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 19:55:46', '2026-02-03 19:55:46'),
(153, 157, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 19:59:52', '2026-02-03 19:59:52'),
(154, 158, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 20:30:11', '2026-02-03 20:30:11'),
(155, 159, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 20:32:24', '2026-02-03 20:32:24'),
(156, 160, 4, 4, 3, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-03 20:33:32', '2026-02-03 20:33:32'),
(157, 161, 5, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 20:34:38', '2026-02-03 20:34:38'),
(158, 162, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-03 20:37:56', '2026-02-03 20:37:56'),
(159, 163, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 06:24:59', '2026-02-05 06:24:59'),
(160, 164, 5, 5, 3, 5, 1, 1, NULL, 0, 1, NULL, '2026-02-05 06:26:41', '2026-02-05 06:26:41'),
(161, 165, 3, 3, 1, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-05 06:27:56', '2026-02-05 06:27:56'),
(162, 166, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 06:29:03', '2026-02-05 06:29:03'),
(163, 167, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 06:30:32', '2026-02-05 06:30:32'),
(164, 168, 2, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-05 06:31:39', '2026-02-05 06:31:39'),
(165, 169, 4, 4, 3, 4, 1, 1, NULL, 0, 1, NULL, '2026-02-05 06:32:41', '2026-02-05 06:32:41'),
(166, 170, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 06:33:42', '2026-02-05 06:33:42'),
(167, 171, 4, 5, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 08:52:35', '2026-02-05 08:52:35'),
(168, 172, 4, 5, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 08:53:33', '2026-02-05 08:53:33'),
(169, 173, 3, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:15:57', '2026-02-05 09:15:57'),
(170, 174, 3, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:20:10', '2026-02-05 09:20:10'),
(171, 175, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:20:54', '2026-02-05 09:20:54'),
(172, 176, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:21:48', '2026-02-05 09:21:48'),
(173, 177, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:22:29', '2026-02-05 09:22:29'),
(174, 178, 3, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:23:12', '2026-02-05 09:23:12'),
(175, 179, 4, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:24:07', '2026-02-05 09:24:07'),
(176, 180, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:25:28', '2026-02-05 09:25:28'),
(177, 181, 4, 4, 4, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:26:18', '2026-02-05 09:26:18'),
(178, 182, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:27:23', '2026-02-05 09:27:23'),
(179, 184, 5, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:29:01', '2026-02-05 09:29:01'),
(180, 186, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 09:29:51', '2026-02-05 09:29:51'),
(181, 187, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 10:46:03', '2026-02-05 10:46:03'),
(182, 188, 5, 4, 2, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 10:47:04', '2026-02-05 10:47:04'),
(183, 189, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:18:55', '2026-02-05 11:18:55'),
(184, 190, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:19:43', '2026-02-05 11:19:43'),
(185, 191, 5, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:20:37', '2026-02-05 11:20:37'),
(186, 192, 5, 5, 5, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:21:48', '2026-02-05 11:21:48'),
(187, 193, 4, 5, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:22:55', '2026-02-05 11:22:55'),
(188, 194, 4, 4, 2, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:23:51', '2026-02-05 11:23:51'),
(189, 195, 3, 4, 2, 1, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:24:58', '2026-02-05 11:24:58'),
(190, 196, 4, 4, 3, 3, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:25:53', '2026-02-05 11:25:53'),
(191, 197, 4, 4, 3, 2, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:26:37', '2026-02-05 11:26:37'),
(192, 198, 5, 5, 1, 1, 1, 1, NULL, 0, 1, NULL, '2026-02-05 11:28:11', '2026-02-05 11:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `ass_action`
--

CREATE TABLE `ass_action` (
  `ass_id` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ass_action`
--

INSERT INTO `ass_action` (`ass_id`, `action`, `uid`, `created_at`) VALUES
(1, 1, 1, '2025-10-15 15:13:36'),
(2, 1, 1, '2025-10-15 15:13:52'),
(3, 1, 1, '2025-10-15 15:14:05'),
(4, 1, 1, '2025-10-15 15:15:34'),
(5, 1, 1, '2025-10-15 15:15:46'),
(6, 1, 1, '2025-10-15 15:15:59'),
(7, 1, 1, '2025-10-15 15:16:15'),
(8, 1, 1, '2025-10-15 15:16:40');

-- --------------------------------------------------------

--
-- Table structure for table `audit`
--

CREATE TABLE `audit` (
  `id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `risk_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `finding` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `recommend` varchar(3000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timeline` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `auditprog`
--

CREATE TABLE `auditprog` (
  `id` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `planned_start` date NOT NULL,
  `exit_meeting` date NOT NULL,
  `draft_issued` date NOT NULL,
  `audit_resp` date NOT NULL,
  `final_report` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `audit_rating`
--

CREATE TABLE `audit_rating` (
  `id` int(11) NOT NULL,
  `grade` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `points` int(11) NOT NULL,
  `color` int(11) NOT NULL,
  `meaning` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cgroup`
--

CREATE TABLE `cgroup` (
  `id` int(11) NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `objectives` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `website` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company`
--

CREATE TABLE `company` (
  `id` int(11) NOT NULL,
  `company_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cgroup` int(11) DEFAULT 0,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL,
  `website` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` varchar(300) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `company`
--

INSERT INTO `company` (`id`, `company_name`, `cgroup`, `email`, `phone`, `website`, `address`, `logo`, `created_at`) VALUES
(1, 'Strathmore University', 0, 'info@strathmore.edu', 254, 'https://strathmore.edu', 'P O Box 59857\r\n00200\r\nNAIROBI', '../assets/images/logo/images.png', '2025-10-15 10:08:49');

-- --------------------------------------------------------

--
-- Table structure for table `control`
--

CREATE TABLE `control` (
  `control_id` int(11) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `process_id` int(11) NOT NULL,
  `controls` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cstrength` int(11) NOT NULL,
  `ctype` int(11) NOT NULL,
  `reviewer` int(11) DEFAULT NULL,
  `rdate` date DEFAULT NULL,
  `userid` int(11) NOT NULL,
  `approval` int(11) NOT NULL DEFAULT 1,
  `uid_approve` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control`
--

INSERT INTO `control` (`control_id`, `dept_id`, `process_id`, `controls`, `cstrength`, `ctype`, `reviewer`, `rdate`, `userid`, `approval`, `uid_approve`, `created_at`, `approved_at`, `updated_at`) VALUES
(1, 1, 1, '• Have a standardised design of project processes to accomodate delays\r\n•For collaborative projects, come with a policy that we can share with partners outlining our framework of speedy delivery\r\n•For granted projects, let the units directly connected to the project handle the project and pay the bonuses to the teams sourcing for the grants\r\n• Establish a partnership/network that can get us acquiring equipment as soon as possible when needed\r\n•Conduct regular financial monitoring and variance analysis.\r\n•Train project managers on cost control and financial accountability.\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 10:56:10', '2025-10-15 13:34:23', '2025-10-15 13:56:10'),
(2, 1, 1, '•Setting up of a project plan and an agreement that strictly guides project collaboration/partnership.\r\n•Implement strong project management practices (Gantt charts, milestones).\r\n•Allocate adequate resources and secure them before project kickoff.\r\n•Establish realistic project timelines with buffer periods.\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 10:57:39', '2025-10-15 13:34:31', '2025-10-15 13:57:39'),
(3, 1, 2, '• Have a stricter project plan and agreement on the get go.\r\n•  Lead the major packages especially in slow partnerships\r\n•  Have regular meetings for project assessments and reports\r\n• Create an esclation and responsive process design.\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 10:58:33', '2025-10-15 13:34:38', '2025-10-15 13:58:33'),
(4, 1, 2, 'Have a clear guidelines of the equipment issuing policy.\r\nEquipments used in active projects should not be given out.\r\nRegular stock taking of the equipment in the lab.\r\nVerify all security measures in place.\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 10:59:43', '2025-10-15 13:34:44', '2025-10-15 13:59:43'),
(5, 1, 3, '• Train and maintain a pool of qualified and reliable trainers\r\n•  Offering relevant/on-demand training (Research)\r\n•  Good customer service \r\n• Adhering to SU standard of branding and marketing\r\n• Creation of Awareness through use of clubs around school, and to other universities (open-days).Aggressive and timely  marketing of trainings through social media, Email and Print media.\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 11:10:14', '2025-10-15 13:34:51', '2025-10-15 14:10:14'),
(6, 1, 4, 'Secure budget approval and resource allocation well in advance\r\nCreating a calender of event for the whole year\r\n Develop a standard event planning checklist and timeline\r\nConduct pre-event rehearsals and technical dry runs\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 11:29:31', '2025-10-15 13:34:56', '2025-10-15 14:29:31'),
(7, 1, 5, '•Secure budget approval in advance\r\n•Plan early with detailed technical specifications and needs assessment.\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 11:30:24', '2025-10-15 13:35:03', '2025-10-15 14:30:24'),
(8, 1, 6, '• Creation of a single point of focus when engaging partners i.e. if it is IoT, let everyone attending the meeting support it.\r\n• Exposure of the staff on handling these kind of discussions with partners.', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 11:31:22', '2025-10-15 13:35:09', '2025-10-15 14:31:22'),
(9, 2, 7, '•Frequent and timely communication to students on the mandate of career development office.\r\n•Taking feedback through surveys and holding events for continual improvement of service.\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 19:55:42', '2025-10-15 22:05:30', '2025-10-15 22:55:42'),
(10, 2, 7, '• Ensure that all students undergo soft skills training in the University.\r\n• Career Development Services will have 7 hours annually with 3rd and 4th years to train on soft skills. \r\n•Liaising with schools and discussing on any improvements needed to prepare students with skills needed to match the job market .\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 19:56:33', '2025-10-15 22:05:49', '2025-10-15 22:56:33'),
(11, 2, 7, '• Requiring company information - location, website, company profile, registration details and job profiles for opportunities they wish to hire for                                                                                                                                                                                                               •Recording and investigating complaints from students and alumni about negative employer \r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 19:57:16', '2025-10-15 22:06:00', '2025-10-15 22:57:16'),
(12, 2, 8, '•  Constant communication with faculty administration\r\n•  Continous positive linkages between industry and the faculties\r\n•  Marketing the event through social media, email students on upcoming events, posts on instagram, linkedin\r\n•Planning to launch portal for career services development (wip).\r\nWorking with Student Council and Clubs to mobilize students to attend events.\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 19:58:53', '2025-10-15 22:06:11', '2025-10-15 22:58:53'),
(13, 2, 9, '•  Recommendation of staff salary increment  to match the market rates subject to availability of funds.\r\n• There is need for more staff such that each school has a dedicated member of staff\r\n•  More trainings aligned to career aspirations.\r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 19:59:33', '2025-10-15 22:06:34', '2025-10-15 22:59:33'),
(14, 2, 10, '• Informing the faculties of what is happening in the industries.\r\n•  Follow-up surveys  to graduates on their employment status 1 year after graduating. \r\n', 3, 1, 1, '2025-10-15', 1, 2, 2, '2025-10-15 20:00:21', '2025-10-15 22:06:58', '2025-10-15 23:00:21'),
(15, 3, 11, '• Proper orientation of staff and students.\r\n• Guidelines and simplified exam policies in place.\r\n• Limited access to examinations office. • Secure storage of exams\r\n• Controlled issuance of CATS and exams booklets\r\n• Issuance of exam cards\r\n• Examinations staff approval for doing short courses and also higher education courses relating to professional ethics\r\n• Benchmarking with other institutions e.g UNESCO, KNEC and other examining bodies\r\n• Documented procedures on handling exam integrity issues. \r\n• Exam machine which is immobile and offline\r\n• Separate exam network\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-15 21:35:26', '2025-10-15 23:44:50', '2025-10-16 00:35:26'),
(16, 3, 11, '•Strict invigilation measures\r\n•CCTV available\r\n•Strong disciplinary policy\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-15 21:36:01', '2025-10-15 23:45:30', '2025-10-16 00:36:01'),
(17, 3, 11, '•strict deadlines for faculty submission of papers\r\n• Internal and external reviews being done on time to avoid delays when submitting examinations.\r\n• Releasing timetable on time (timely scheduling of exams)\r\n• Implement trackers on receipt of CATs/Exams in time to enable early printing\r\n• Increased staff capacity to avoid delays\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-15 21:36:40', '2025-10-15 23:45:54', '2025-10-16 00:36:40'),
(18, 3, 11, '•Workload planning\r\n•Clear timelines set\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-15 21:37:13', '2025-10-15 23:46:15', '2025-10-16 00:37:13'),
(19, 3, 11, '• Policy on students documents management \r\n• Back up of exams on soft copy on external harddrive which is securely stored in the safe \r\n• Controlled access to exams office.\r\n•  Decentralize storage of data\r\n\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-15 21:38:07', '2025-10-15 23:46:28', '2025-10-16 00:38:07'),
(20, 3, 11, '• Calls and emails are handled by the team (examination centre email in place)\r\n• Segregation of roles to improve turn-around time of responses\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-15 21:38:42', '2025-10-15 23:46:40', '2025-10-16 00:38:42'),
(21, 3, 14, '•Regular training for exam staff\r\n•Clear communication\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-15 21:39:22', '2025-10-15 23:45:18', '2025-10-16 00:39:22'),
(22, 3, 15, '• Upgraded examination venues .\r\n• Big exam halls (exclusive use of rooms)\r\n• Timetabling system in place \r\n• Early planning\r\n• Improved the class booking system\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-15 21:40:35', '2025-10-15 23:45:09', '2025-10-16 00:40:35'),
(23, 3, 16, '•Adequate recruitment\r\n•Workforce planning\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-15 21:41:06', '2025-10-15 23:44:59', '2025-10-16 00:41:06'),
(24, 4, 17, '• Existing Policies & procedures that are reviewed regularly (Payables policy/SOP)\r\n• Maker checker levels of payment.\r\n• Authorization(segregation of duties)\r\n• Automation of payments (use of kuali rice for payments)\r\n• Easy access of supporting information through electronic archiving (TalaB)\r\n•Staff training and mentorship \r\n•Approval matrix for HODS\r\n• Regular review of management accounts.\r\n• Monthly reporting of accounts payables.\r\n• Payables accounts reconciliations.\r\n• Daily bank reconciliations\r\n\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 05:57:46', '2025-10-16 08:11:37', '2025-10-16 08:57:46'),
(25, 4, 18, '• Regular review of Debtors aging Report.\r\n• Monthly reporting of both Student and Corporate Debtors to Schools to follow-up on outstanding debt\r\n• Debtors accounts reconciliations.\r\n• Daily bank reconciliations\r\n•  Unidentified deposits are categorized by banks for ease of allocation and reconciliations. Unidentified deposits are recorded in one central place and analyzed per account. \r\n• Staff Training on Emerging Trends in the industry i.e. IFRS 9 Adoption.\r\n• Credit control team follows-up with student debtors\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 05:58:29', '2025-10-16 08:11:30', '2025-10-16 08:58:29'),
(26, 4, 19, '• Approval by Finance Manager or his  designate before any cash is issued. \r\n• Budget confirmation\r\n• Alternative modes of payment to reduce over holding of liquid cash i.e. cheque, bank transfers, credit cards, Mpesa. \r\n•  Students required to pay fees through the bank. \r\n• Insurance cover for cash held. \r\n•  Opened an Mpesa pay bill account for the clinic and Cafeteria. ', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 05:59:05', '2025-10-16 08:11:24', '2025-10-16 08:59:05'),
(27, 4, 20, '• Cash flow projections and planning. \r\n• Arranged credit facilities for heavy purchases such as student laptops.\r\n•Prioritization of university needs.\r\n• Diversification of revenue sources e.g on research grants, executive education programs', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 05:59:36', '2025-10-16 08:11:15', '2025-10-16 08:59:36'),
(28, 4, 20, '• Due Diligence before placing investments on various investment vehicles\r\n•  Spreading investments in various banks to avoid over reliance on few banks (not more than 25% for a single bank)\r\n• Consider investing in tier one banks only.\r\n• Improve returns by investing in government securities.\r\n•Regular portfolio reviews\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 06:00:07', '2025-10-16 08:11:06', '2025-10-16 09:00:07'),
(29, 4, 20, '• SU maintatains a foreign currency accounts to collect foreign currency incomes which are consequently used to service foreign currency loans. \r\n• Finance liaises with banks to get projected exchange rates for budeting purposes.\r\n• Daily monitoring of exchange rate movement. \r\n• Hedging to protect SU from volatility (reserve dollars)\r\n• Make payments in foreign currency to avoid foreign currency conversion risk\r\n• Negotiate for fixed rate loans with lenders', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 06:00:37', '2025-10-16 08:11:00', '2025-10-16 09:00:37'),
(30, 4, 21, '• Implementation of a payment request system that checks the available budget before processing payment. \r\n• ‘Disorganize to organize’ project where each department is assigned an accountant.\r\n• Regular reviews (Quartely) of the faculty/school budget by the faculty board & MB before being tabled to the Council. Timely feedback received on whether the budget has been approved or otherwise. \r\n• Budgetary committee requires that the budget be linked to the SU strategy.\r\n•  Budget workshops held with HoDs. \r\n• Regular review of financial reports by the accountant, finance manager, director, management board and ultimately the university council. ', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 06:01:02', '2025-10-16 08:10:55', '2025-10-16 09:01:02'),
(31, 4, 22, '• Payments are made against orders raised and matched with invoices. \r\n• Five step verification process for any payment. \r\n• Payments done through Citi Direct and review done by a different person. \r\n• Review of payments by signatories on a sample basis. \r\n• Payment advice slips are sent to suppliers, statements obtained and reconciled. \r\n• Suppliers to provide supplier statements. \r\n• Reconciliations and voucher verification during petty cash float replenishment. \r\n• Credit card policy has been developed and was rolled out in November 2016. \r\n• Segregation of duties.\r\n• Call backs to confirm approval from HoDSs before payment\r\n• Whistleblowing platform in place to report any fraud cases', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 06:01:27', '2025-10-16 08:10:48', '2025-10-16 09:01:27'),
(32, 4, 22, '• Special purpose vehicle e.g. SRCC to deal with all Consultancy Projects. \r\n• Engaging consultants to ensure compliance with tax laws and enable the University retain tax exemption status. \r\n• Application for renewal of tax exemption certificate in good time. Renewed every 5 years - the next renewal is in 2019. \r\n• Regular reviews of payments of Statutory deductions. \r\n•Automated Payroll System for computation of Deductions.', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 06:01:56', '2025-10-16 08:10:42', '2025-10-16 09:01:56'),
(33, 4, 23, '• Tagging of fixed assets for ease of monitoring. \r\n• Stock takes - every 1 years. \r\n• Physical security within SU. \r\n• Asset verification every 2 years. \r\n• Tracking devices installed on all motor vehicles. \r\n• Fixed asset register updated every month\r\n• Insurance cover for assets ', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 06:02:18', '2025-10-16 08:10:31', '2025-10-16 09:02:18'),
(34, 4, 18, '•To prevent further risk exposure, the signing of new contracts for county governments under the current business model has been discontinued. Any new contracts will only be signed in an arrangement where the income is collected upfront.\r\n•The University is actively pursuing a potential debt buyout arrangement and has established formal engagement with Quest Holdings Ltd. \r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 06:19:21', '2025-10-16 08:19:51', '2025-10-16 09:19:21'),
(35, 5, 28, '• Training of staff members; \r\n• Keep and display chemical components of what the department uses\r\n• Ensuring that suppliers have necessary certifications\r\n• Annual updating of procedures and processes\r\n• Annual self assessment reports of the department\r\n•Clear accountability and escalation channels for compliance breaches', 4, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:21:55', '2025-10-16 12:30:44', '2025-10-16 12:56:35'),
(36, 5, 27, '• Controlled handover of keys.\r\n•Staff rotation.\r\nWork schedules help trace who was at a particular room at a particular time.\r\n• There are procedures and timeframes for surrender for lost & found items.', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:22:37', '2025-10-16 12:30:37', '2025-10-16 13:22:37'),
(37, 5, 27, '• Strict tagging and record keeping system\r\n• Proper segregation of staff and guest laundry\r\n• Double-checking during dispatch', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:23:21', '2025-10-16 12:30:28', '2025-10-16 13:23:21'),
(38, 5, 27, '• Store keeper in charge of the store. Supervisors monitor items in the sub stores.\r\n• Only supervisor in charge of each building is allowed to pick items from the store using a requisition form.\r\n• Each building has a record of standard agents needed. This can be referenced to avoid misuse. \r\n• Replenishment/replacement of housekeeping materials and equipment is done on presentation of the empty and broken items.\r\n• Stock analysis to be done every quarter', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:23:52', '2025-10-16 12:30:20', '2025-10-16 13:23:52'),
(39, 5, 26, '• There are established loads for the washing machine and tumble drier therefore there is optimal usage. \r\n• Scheduled servicing of equipment. \r\n• Laundry receiving and dispatch form is maintained. \r\n•Proper timetabling of laundry operations', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:24:18', '2025-10-16 12:30:11', '2025-10-16 13:24:18'),
(40, 5, 26, '• There are established loads for the washing machine and tumble drier therefore there is optimal usage. \r\n• Scheduled servicing of equipment. \r\n• Laundry receiving and dispatch form is maintained. \r\n•Proper timetabling of laundry operations\r\n•Use appropriate detergents and washing programs per fabric type', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:24:51', '2025-10-16 12:30:02', '2025-10-16 13:24:51'),
(41, 5, 25, 'Training of staff members on safety precautions and ensuring that sanitisers are adequately refilled.\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:25:31', '2025-10-16 12:29:55', '2025-10-16 13:25:31'),
(42, 5, 25, '• Trainining the staff members on proper Ergonomic practices,\r\n• Provision of trollies/necessary equipment\r\n• Assigning heavy lift duties to the housekeeping men ', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:26:14', '2025-10-16 12:29:33', '2025-10-16 13:26:14'),
(43, 5, 24, '•Regular pest control\r\n•Food hygiene enforcement\r\n•Waste segregation', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:26:41', '2025-10-16 12:29:26', '2025-10-16 13:26:41'),
(44, 5, 24, '•Training of H/K staff to follow protocol/procedures\r\n•Use of checklists\r\n•Proper handover processes\r\n•Enforcing on safety and hygiene\r\n•Carry out routine inspections and health audits of cleaning practices', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 10:27:41', '2025-10-16 12:29:17', '2025-10-16 13:27:41'),
(45, 6, 29, '• Multi level authorization of system changes\r\n• Assigning user rights based on job roles\r\n• Implemented defense-in-depth: role-based access, network/host firewall.\r\n• Back up of information databases and systems.\r\n• Physical access controls like restriction to the server room, security guards in the compound.\r\n• Log access to server room \r\n• Physical IT assets secured appropriately including storing equipment in locked rooms/cabinet etc.\r\n• Regular user rights review by the system owners.\r\n• Approved access control matrix \r\n• Review of user logs and exceptional reports \r\n• Periodic change of user passwords \r\n• Implemented a Database Audit & Monitoring (DAM) tool for critical applications\r\n• Implemented an end-point protection solution (Trend-Micro) to guard against malware \r\n• Frequently training staff, in high-risk job roles, on current cyber security threats such as social engineering attacks (2).\r\n\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 11:46:00', '2025-10-16 14:22:08', '2025-10-16 14:46:00'),
(46, 6, 30, '• Implemented changes to the ICT organisational structure thereby improving succession planning \r\n• Sponsoring the ICT Services team for professional and academic courses based on their job roles ', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 11:46:58', '2025-10-16 14:22:00', '2025-10-16 14:46:58'),
(47, 6, 31, '• The ICT Steering committee is active and involved in ICT matters as set out in the University Statutes.\r\n• The ICT Management committee is active and involved in ICT matters.\r\n• Quarterly ICT Services reports to the University Management and Council.\r\nBackup and Disaster Recovery Policy in place\r\nICT goals aligned with university strategic goals', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 11:47:56', '2025-10-16 14:21:39', '2025-10-16 14:47:56'),
(48, 6, 33, '• Infrastructure and software systems are tested before go-live and performance acceptance tests and post-implementation reviews are conducted \r\n• Monitoring of capacity IT technology and infrastructure \r\n• Provision of technology replacement plans through appropriate funding/budgeting processes \r\n• Installed sufficient backup power systems i.e. power generators and UPS \r\n• Operationalized and tested the IT module in the BCP Policy \r\n• Change management policy and RFC form in place - proper testing and documentation of results before full implementation of IT systems \r\n• An active information security policy  \r\n• Avoiding single point of network failure through redundancy of network links and devices \r\n• Ensure redundancy of the network backbone \r\n• Ensure two ISPs supply internet bandwidth, one being a backup link. (i.e.   KENET and Seacom). This ensures higher availability of internet (\r\n• Utilization of a bandwidth management tool (ALLOT) which implements Quality of Service (QoS) minimizing effects of downtime to the user \r\n• ICT service help desk to provide timely response.\r\n• Periodic system maintenance and servicing( service schedule)\r\n• Ensure adequate training of ICT Services staff.\r\n• Ensure compliance with set standards and/or procedures.\r\n• Ensure critical equipment are covered with software and hardware warranty.\r\n• Change management policy and RFC form in place - proper testing and documentation of results before full implementation of IT systems (1).\r\n• A software test environment in place and operational.\r\n• User acceptance tests conducted by relevant parties (IT, business reps, etc) to ensure the change, module or software meets user expectations.\r\n• Segregation of duties in place between software developers and system administrators.\r\n• Software repository and version control systems in place to ensure version control and bug tracking.', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 11:48:44', '2025-10-16 14:21:28', '2025-10-16 14:48:44'),
(49, 6, 34, '• Assessment of vendor capabilities conducted \r\n• Signed and active SLAs in place for some vendors and suppliers ', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 11:49:18', '2025-10-16 14:21:12', '2025-10-16 14:49:18'),
(50, 6, 35, '• Storage of physical IT Assets in locked or secure cabinets or rooms \r\n• Installation of CCTv cameras in strategic locations across the University \r\n• Presence of security guards on campus at strategic points ', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 11:54:08', '2025-10-16 14:21:05', '2025-10-16 14:54:08'),
(51, 6, 36, '• A disaster recovery site in place.\r\n• Critical data in production systems backed up in the disaster recovery site regularly.\r\n• Implemented redundancy for critical services and systems such as backup generators, two internet service providers, multiple fibre links and core switches.\r\n• Secure access to information resources through the VPN', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 11:54:41', '2025-10-16 14:20:57', '2025-10-16 14:54:41'),
(52, 6, 37, '• The University has acquired certifications from relevant bodies such as ODPC.\r\n• The University has reviewed its Statutes, Policies, and Standards to ensure compliance.\r\n• Regular review of University IT Policies and Standards to ensure compliance.\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 11:55:27', '2025-10-16 14:20:49', '2025-10-16 14:55:27'),
(53, 6, 38, '•Conduct technical and functional feasibility assessments before adoption\r\n•Pilot or sandbox testing for all new technologies before full rollout\r\n•Perform vendor due diligence including references, demos, and SLAs\r\n•Provide targeted training and documentation to prepare users for new technologies', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 11:55:59', '2025-10-16 14:20:42', '2025-10-16 14:55:59'),
(54, 7, 39, 'Each department shares leave schedule for its members to ensure staff utilize their leaves and avoid leave carred forwards', 2, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:21:11', '2025-10-16 22:57:39', '2025-10-16 23:21:11'),
(55, 7, 40, '• Training on performance management for Heads of Departments (HoDs) and staff.\r\n• Review of the performance management policy based on the SU strategic pillars.\r\n• Automated performance management system in place\r\n• Advise HoDs to ensure that goals and Key Performance Indicators for staff are established.\r\n• Email reminders sent to Heads of Department and staff on the need to carry out performance appraisals \r\nTraining of campions on Performance Management system was done', 2, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:22:27', '2025-10-16 22:57:28', '2025-10-16 23:22:27'),
(56, 7, 41, '• Attracting faculty on sabbatical leave to assist in lecturing\r\n• Review remuneration packages based on field of specialization and performance.\r\n• The People and Culture department has increased the number of Institutional Fit Assessors (IFA) to enhance recruitment of suitable lecturers and staff\r\n• Headhunting.\r\n• Professional networking.\r\n• Broadening the advertising platform such as LinkedIn and other professional networks.\r\n• Internal staff are given first priority for most opportunities that arise within the University as a way of motivating them whilst conserving the Strathmore spirit.\r\n• Enhancing the induction process. \r\n• Career mentorship programs including Leadership Academy. \r\n• Defined career progression path for lecturers\r\n• Attracting foreign  academic staff to teach virtually \r\n•Job evaluation recommendations implemented\r\n•Review of People and Culture Policy\r\nBuild a talent pool for reserach scholars and interns \r\nDeveloped People and Culture Process Maps\r\nCascaded the People and Culture Policy manual\r\nPanel were interviewed on CBI ', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:23:14', '2025-10-16 22:57:17', '2025-10-16 23:23:14'),
(57, 7, 41, '• Continuous improvement of terms of service and working conditions (resources and office space)\r\n• Flexible programs to enable lecturers complete their PhD degrees and reduced workload\r\n• Training our own PhD - Doctoral fellows ( Doctoral Academy)\r\n• Value proposition - People and Culture emphasizes more on other benefits in conjunction with Staff Welfare Committee.\r\n• Review remuneration packages based on field of specialization and performance.\r\n• Sponsorship programs for staff and leadership program.\r\n• Staff welfare activities-Weekly webinars,Staff welfare hikes\r\n• Career mentorship programs including Leadership Academy. \r\n• Defined career progression path for lecturers\r\n• Attracting foreign  academic staff to teach virtually \r\n•Job evaluation recommendations implemented\r\n•Review of People and Culture Policy\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:24:13', '2025-10-16 22:57:07', '2025-10-16 23:24:13'),
(58, 7, 41, '• Sensitize People and Culture staff to follow recruitment guidelines and procedures.\r\n• People and Culture Business partners incharge of their respective schools and departments ensure the recruitment process is adhered to (decentralized the recruitment process)\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:28:02', '2025-10-16 22:55:40', '2025-10-16 23:28:02'),
(59, 7, 42, '•Ensure disciplinary issues are dealt with according to SU guidelines and procedures\r\n•Grievancy and Disciplinary policy in place\r\n•Training and sensitization sessions for Heads of Departments/Managers on employee related issues such as discriminination, workplace harassment, unethical conduct/immoral behaviour, non-compliance to regulations, theft, fraud etc are usually conducted at least once a year.', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:28:54', '2025-10-16 22:55:30', '2025-10-16 23:28:54'),
(60, 7, 43, '• Back up  to the cloud. Information and Communication Technology Servives department (ICTS) ensures back up of data. We create two data dumps for the e-records per day\r\n• Files are under lock and key.\r\n• Fire proof safes.\r\n•  Controlled access to records in both hard and  soft - (E-filing system)\r\n•Automated the process of filing records', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:30:47', '2025-10-16 22:55:22', '2025-10-16 23:30:47'),
(61, 7, 43, '• Regular updating of employee details/information. \r\n•Sensitizing staff to update their records in the Orange System', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:33:36', '2025-10-16 22:55:15', '2025-10-16 23:33:36'),
(62, 7, 44, '•Trained Heads of Departments on importance of succession planning\r\n•Encourage career mapping to employees\r\n•A database of potential hires internally and externally in place\r\n•Identification of key strategic roles and ensuring job shadowing is  in place', 2, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:34:14', '2025-10-16 22:55:01', '2025-10-16 23:34:14'),
(63, 7, 45, '•Adherence to data protection act\r\n•Enhanced cybersecurity measures (in conjunction with Information and Communication Technology Services( ICTS) department)\r\n', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:36:15', '2025-10-16 22:54:53', '2025-10-16 23:36:15'),
(64, 7, 46, '•Ensuring a budget is in place to support training needs\r\n•Encouraging staff to take advantage of online free trainings\r\n•Learning and Development function in place that follows up on training needs of employees', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:38:34', '2025-10-16 22:54:46', '2025-10-16 23:38:34'),
(65, 7, 46, 'Bonding agreements are in place to ensure the University benefits from the training investment. They deter premature exit, or alternatively, allow the organization to recover a portion of the training cost if the employee leaves early.', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:39:26', '2025-10-16 22:54:38', '2025-10-16 23:39:26'),
(66, 7, 47, '• The  People and Culture Department has been organizing wellness programs for staff such as staff hikes\r\n• There is a wellness coordinator under People and Culture who focuses on staff welfare\r\n•Increased number of psychologists from whom staff can seek counselling services \r\n• SU has waived on co-pay option that enables counselling services of upto Ksh 5000 fully covered for staff', 3, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:40:32', '2025-10-16 22:54:28', '2025-10-16 23:40:32'),
(67, 7, 48, '• Continuous sensitization of People and Culture staff on legal and statutory requirements .\r\n• Attend Labor Law trainings by relevant bodies.\r\n• Guidance from the Corporate and Legal Affairs office on legal matters relating to employment.\r\n• Guidelines on general People and Culture related issues are received from relevant People and Culture bodies-Federation of Kenya Employers (FKE) and external legal advisors                                                            \r\n• People and Culture is continuously advised by external consultants on Immigration matters.\r\n•  SU-OSH (Occupational Safety & Health) committee in place\r\n• Membership to Federation of Kenya Employers (FKE), Kenya Employment Law platform\r\n•Internal Audits carried out to ensure compliance is adhered to\r\n', 4, 1, 1, '2025-10-16', 1, 2, 2, '2025-10-16 20:41:09', '2025-10-16 22:54:18', '2025-10-16 22:41:37'),
(68, 8, 49, '•mandatory entrance exams/aptitude tests are conducted\r\n•Strengtheneda admission criteria and verification processes', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:24:37', '2025-10-17 01:46:15', '2025-10-17 02:24:37'),
(69, 8, 49, '•Set enrollment caps aligned with available capacity\r\n•Improve forecasting models for admissions\r\n•Strengthen communication between admissions and the School', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:26:16', '2025-10-17 01:46:06', '2025-10-17 01:26:42'),
(70, 8, 50, '•Recruit part-time/adjunct faculty\r\n•Improve workforce planning and succession management\r\n•Monitor staff-to-student ratios regularly', 2, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:27:42', '2025-10-17 01:45:57', '2025-10-17 02:27:42'),
(71, 8, 51, '•Strengthen academic support systems (remedial classes, tutoring, peer mentoring)\r\n•Provide financial aid, scholarships, or flexible payment option\r\nstudent engagement programs (clubs, mentorship, career guidance).', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:30:20', '2025-10-17 01:45:46', '2025-10-17 02:30:20'),
(72, 8, 52, '• Organizing Conferences.\r\n• Supporting staff in attending conferences.\r\n• Supporting staff with publication costs especially in high level journals.\r\n• Encouraging  students at all levels to present research work in conferences.\r\n• Launch of PhD by course work\r\n• Reduced staff workload  to facilitate research work\r\n•Formation of research teams to enable collaborative grant application', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:31:23', '2025-10-17 01:45:36', '2025-10-17 02:31:23'),
(73, 8, 53, '•Industry partnerships \r\n•Internship programs available\r\n•Curriculum reviews conducted to ensure match with market changes', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:32:11', '2025-10-17 01:45:23', '2025-10-17 02:32:11'),
(74, 8, 54, '•Plagiarism software in place\r\n•Supervision during CATs/Exams', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:33:33', '2025-10-17 01:45:14', '2025-10-17 02:33:33'),
(75, 8, 55, 'Safety audits; PPE provision; Staff/student training; Clear lab rules; Regular equipment checks', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:34:53', '2025-10-17 01:45:03', '2025-10-17 02:34:53'),
(76, 8, 56, 'Liaise with Office of Registrar to ensure programmes are accredited and curriculum reviews are conducted', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:35:36', '2025-10-17 01:44:53', '2025-10-17 02:35:36'),
(77, 8, 57, '•Enforced strict tuition payment deadlines and policies\r\n•Diversify funding sources to reduce reliance on tuition alone\r\n•Provide flexible but controlled payment plans\r\n•Designated finance officer at School level to follow-up on debt collection', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-16 23:36:25', '2025-10-17 01:44:45', '2025-10-17 02:36:25'),
(78, 9, 58, '• The school prepares an orientation schedule for all intakes.\r\n• Facilitors advised in advance on topics to address during orientation.\r\n• Advance communication to students.\r\n• Students can get assistance from other departments who would refer them to the right offices.\r\n•Orientation is continous within classes taught in the first semester. These are specific classes with specific lecturers who assist with this', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-17 08:00:42', '2025-10-17 10:15:42', '2025-10-17 11:00:42'),
(79, 9, 59, '• Marketing budget for holding webinars and promotions\r\n• Calendar of events, school visits and workshops\r\n• Aggressive marketing online.\r\n• Nurture relationship with prospective clients through free career guidance workshops online, web competitions etc.\r\n• Work together with BA and Masters alumni to enhance post clearing experience and have them assist with bringing their friends to do the same courses they did.\r\n• Plan academic trips to create more awareness of the program', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-17 08:01:25', '2025-10-17 10:15:35', '2025-10-17 11:01:25'),
(80, 9, 60, '• Encouraging staff members to apply for advertised grants. \r\n• Training staff members on writing proposals for grants. \r\n• Sending out expression of interest for grants that suit or are tailored to the schools needs', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-17 08:02:18', '2025-10-17 10:15:27', '2025-10-17 11:02:18'),
(81, 9, 61, '•Strict invigilation measures\r\n•CCTV available\r\n•Strong disciplinary policy', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-17 08:02:40', '2025-10-17 10:15:20', '2025-10-17 11:02:40'),
(82, 9, 62, '•Enforced strict tuition payment deadlines and policies\r\n•Diversify funding sources to reduce reliance on tuition alone\r\n•Provide flexible but controlled payment plans\r\n•Designated finance officer at School level to follow-up on debt collection', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-17 08:03:25', '2025-10-17 10:15:12', '2025-10-17 11:03:25'),
(83, 9, 63, '• Shorten the course evaluation questionnaire to encourage more responses.\r\n• Seek better incentives for the students to fill out the course evaluation.\r\n• Organising the course evaluation, and encouraging lecturers to seek better ways of encouraging feedback of their own through class engagement.\r\n• Explore use of online tools to get course evaluation feedback', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-17 08:04:06', '2025-10-17 10:15:04', '2025-10-17 11:04:06'),
(84, 9, 64, '-Set key dates for submission of student results. \r\n-Proper planning.\r\n-Ensuring exam processes are in order.\r\n', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-17 08:05:15', '2025-10-17 10:14:58', '2025-10-17 11:05:15'),
(85, 9, 65, 'Providing staff incentives (e.g pay education fees\r\nfor staff for their career progression) and implementing staff engagement programs', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-17 08:05:44', '2025-10-17 10:14:52', '2025-10-17 11:05:44'),
(86, 9, 65, 'Providing staff incentives (e.g pay education fees\r\nfor staff for their career progression) and implementing staff engagement programs', 3, 1, 1, '2025-10-17', 1, 2, 2, '2025-10-17 08:13:11', '2025-10-17 10:14:44', '2025-10-17 11:13:11'),
(87, 11, 66, '• Supervision by administrative department to expedite issues resolution. \r\n• Regular servicing of vehicles by approved/contracted garages. \r\n• There is a driver in charge of each vehicle. This driver reports any issues that need to be dealt with. \r\n• Installation of tracking devices on all vehicles. The tracking system is used to monitor all vehicles, Cut-out installed on all vehicles. \r\n•Insurance covers are upto date.\r\n•Drivers schedules are well managed to factor in long distances and long working hours. ', 3, 1, 1, '2026-01-30', 1, 2, 2, '2026-01-30 10:30:42', '2026-01-30 12:24:04', '2026-01-30 13:30:42'),
(88, 11, 68, '• Access keys are kept in the Admin Office and the Warehouse / Stores Administrator picks the keys when going to open the stores and returns them back to the Admin Office.\r\n• Inventory system helps in monitoring the movement of stock in the warehouse and stores.\r\n• Keep a log of the Administrator to sign when picking and returning the stores/warehouse keys.\r\n• Installed CCTV and monitoring systems in stores', 4, 1, 1, '2026-01-30', 1, 2, 2, '2026-01-30 10:32:20', '2026-01-30 12:23:55', '2026-01-30 13:32:20'),
(89, 11, 69, '•There are fire extinguishers at every building and at every floor\r\n•The university properties have been insured\r\n•Staff and students have been trained on fire response\r\n•Proper naming of exit doors\r\n•OSH inspections done on a quarterly basis\r\n•Maintenance and servicing to prevent gas leaks\r\n', 3, 1, 1, '2026-01-30', 1, 2, 2, '2026-01-30 10:34:24', '2026-01-30 12:23:18', '2026-01-30 13:34:24'),
(90, 11, 70, '• Water reservoir in place(two tanks)\r\n• Regularly implement routine inspection and preventive maintenance of water infrastructure\r\n• Underground water tanks to store water\r\n•  Water harvesting in various buildings\r\n• Water treatment before consumption \r\n•  Annual water testing with KEBS \r\n• Periodic maintenance of water pumps\r\n•Installed adequate water storage facilities and backup systems \r\n• 2 boreholes are in place. There are various services points for the NCWSC water. The 2 boreholes are interconnected such that if one fails, the other can take over', 4, 1, 1, '2026-01-30', 1, 2, 2, '2026-01-30 10:44:14', '2026-01-30 12:22:58', '2026-01-30 13:44:14'),
(92, 11, 71, '• There are four backup generators in place and serviced regularly\r\n• Installation of solar panels in various buildings to supplement KLPC power\r\n• Updating and maintaining electrical equipment regularly.\r\n• From time-to-time, replacing cables, connectors, transformers, switches and many other types of electrical equipment that can trigger a power interruption', 4, 1, 1, '2026-01-30', 1, 2, 2, '2026-01-30 10:46:51', '2026-01-30 12:20:58', '2026-01-30 13:46:51'),
(93, 11, 72, '• Provide proper working equipment to all staff\r\n• Pre - employment  medical  tests\r\n• Yearly medical test for Drivers \r\n', 3, 1, 1, '2026-01-30', 1, 2, 2, '2026-01-30 10:51:41', '2026-01-30 12:20:49', '2026-01-30 13:51:41'),
(94, 11, 73, '•Enforced driver qualification, training, and certification requirements\r\n•Installed GPS tracking, speed governors\r\n•Driver training, adherence to road safety rules, regular vehicle maintenance\r\n', 3, 1, 1, '2026-01-30', 1, 2, 2, '2026-01-30 10:53:44', '2026-01-30 12:20:42', '2026-01-30 13:53:44'),
(95, 11, 74, '•Maintain up-to-date compliance documentation and licenses\r\n•Engage regulators for periodic inspections and advisory support\r\n•Conduct regular OSH, environmental, and transport compliance audits', 4, 1, 1, '2026-01-30', 1, 2, 2, '2026-01-30 10:54:35', '2026-01-30 12:20:21', '2026-01-30 13:54:35'),
(96, 12, 75, '•Virtual marketing and open days.\r\n•Movement of application process to online.\r\n•Engagement of recrutement agencies in countries such as Uganda and then refer to SU\r\n•Enhanced program value proposition', 3, 1, 1, '2026-01-31', 1, 2, 2, '2026-01-31 15:56:04', '2026-01-31 17:13:46', '2026-01-31 18:56:04'),
(97, 12, 75, 'Virtual process implemented and proper scheduling of interviews\r\n', 3, 1, 1, '2026-01-31', 1, 2, 2, '2026-01-31 15:56:29', '2026-01-31 17:13:37', '2026-01-31 18:56:29'),
(98, 12, 76, '• Staff awareness trainings\r\n• Strengthened IT controls in conjunction with ICTS\r\n• Staff training by Data Protection Officer (DPO)\r\n', 3, 1, 1, '2026-01-31', 1, 2, 2, '2026-01-31 15:57:27', '2026-01-31 17:13:26', '2026-01-31 18:57:27'),
(99, 12, 77, '• Regularly analyze conversion rates\r\n• Ensure follow-ups are conducted\r\n•Simplify and clarify the application process for prospective students\r\n', 3, 1, 1, '2026-01-31', 1, 2, 2, '2026-01-31 15:58:02', '2026-01-31 17:13:16', '2026-01-31 18:58:02'),
(100, 12, 78, '• Existing policies and procedures to guide the process.\r\n• Staff are trained on efficient handling of student queries and issue resolution\r\n• Ensure adequate staffing during peak onboarding periods\r\n• Monitor and track outstanding issues to ensure timely closure', 3, 1, 1, '2026-01-31', 1, 2, 2, '2026-01-31 15:58:41', '2026-01-31 17:13:09', '2026-01-31 18:58:41'),
(101, 12, 79, '•Switched the switchboard calls to mobile numbers to enable quick turnaround time on responding to student issues\r\n•Encourage a culture of accountability, responsiveness, and professionalism', 3, 1, 1, '2026-01-31', 1, 2, 2, '2026-01-31 15:59:26', '2026-01-31 17:13:01', '2026-01-31 18:59:26'),
(102, 12, 80, '•Ensure students bring certified result slips/documents\r\n•Use photo ID verification to prevent impersonation', 3, 1, 1, '2026-01-31', 1, 2, 2, '2026-01-31 16:00:10', '2026-01-31 17:12:54', '2026-01-31 19:00:10'),
(103, 12, 81, 'Liaise with ICTS to ensure system backups\r\n', 3, 1, 1, '2026-01-31', 1, 2, 2, '2026-01-31 16:00:44', '2026-01-31 17:12:45', '2026-01-31 19:00:44'),
(104, 13, 82, '• Aggressive marketing through social media, newsletters, website,\r\n• Constant communication through emails, calls, and text messages\r\n• Involve alumni in the planning process\r\n• Proper planning by issuing sufficient notice period\r\n• Follow-ups conducted regularly\r\n• Conduct alumni needs analysis\r\n• Collaborate with schools to strengthen alumni engagement', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 17:54:53', '2026-02-01 19:03:12', '2026-02-01 20:54:53'),
(105, 13, 83, '• Develop a well-thought framework for the mentoring programme\r\n• Make meetings (time and venue) between alumni and students flexible\r\n• Implement a system for gathering feedback and acting on corrective measures\r\n', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 17:55:47', '2026-02-01 19:03:05', '2026-02-01 20:55:47'),
(106, 13, 84, '• Well defined systems of collecting data at various occasions\r\n• A system is in place that allows alumni to update their own information\r\n• Work with stakeholders in gathering and updating the information\r\n• Frequent reminder to alumni to update their information', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 17:56:28', '2026-02-01 19:02:57', '2026-02-01 20:56:28'),
(107, 13, 85, '• In collaboration with the SUF team, develop and prepare funding materials to share with alumni\r\n• Organize regular engagement events with different alumni groups\r\n• Communicate progress and outcomes of funded initiatives\r\n• Strengthen donor stewardship', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 17:57:16', '2026-02-01 19:02:50', '2026-02-01 20:57:16'),
(108, 13, 86, '• Monitoring & reporting on spending\r\n• Regularly reviewing & adjusting spending \r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 17:58:53', '2026-02-01 19:02:42', '2026-02-01 20:58:53'),
(109, 13, 87, '• Obtain consent from alumni before using their data for any purpose, and clearly communicate this.\r\n• Implement access controls when handling the data', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 18:00:57', '2026-02-01 19:02:34', '2026-02-01 21:00:57'),
(110, 14, 88, '• Hired a dedicated resource to manage all our social media platforms. \r\n• The Director and Manager review all the online accounts \r\n• Creation of an encrypted password that can only be accessed by authorized personnel and changed regularly.\r\n•Train communications and frontline staff on digital engagement and brand tone\r\n•Escalate sensitive issues promptly to management\r\n• Social Media Policy reviewed every three years\r\n• Continuous Team members, training on basic social media skills\r\n• Creativity sessions and social media campaigns', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 18:40:25', '2026-02-01 19:48:36', '2026-02-01 21:40:25'),
(111, 14, 89, '• Internal Legal guidance and advice all the time.\r\n• Establishing strictness towards the students around and within the campus with conjunction with Security. \r\n• Ensuring that we maintain good academic standing.\r\n• Regular monitoring of traditional and digital media for early detection of negative stories\r\n• strengthen student discipline, counselling, and off-campus engagement programmes\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 18:42:06', '2026-02-01 19:48:29', '2026-02-01 21:42:06'),
(112, 14, 90, '•  Protocol and Events Manager to follow up and ensure effective events management\r\n• Circulation of emails of upcoming events to staff and students.\r\n• Training staff on importance of communicationn and protocol management.\r\n•On-screen for display at the Student Centre has been purchased.\r\n• A protocol policy in place', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 18:43:06', '2026-02-01 19:48:23', '2026-02-01 21:43:06'),
(113, 14, 91, '• Created a guideline for handling equipment in the office.\r\n• Sign up sheets for tracking the movement of the equipment.\r\n• Fire proof storage cabinets.\r\n• Insured the equipment', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 18:44:20', '2026-02-01 19:48:16', '2026-02-01 21:44:20'),
(114, 14, 92, '•Consent forms in place\r\n•Photography and videography notice in rooms\r\n•Require explicit consent for photographing minors and vulnerable persons\r\n•Train communications staff on privacy, consent, and data protection laws\r\n\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 18:45:08', '2026-02-01 19:48:10', '2026-02-01 21:45:08'),
(115, 14, 93, '•Subscribed to approved stock media platforms\r\n•Maintained a central register of licensed media and usage rights', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 18:46:17', '2026-02-01 19:48:04', '2026-02-01 21:46:17'),
(116, 15, 94, '• An annual sports timetable\r\n• Annual budget preparation\r\n•Improved stakeholder engagement\r\n•Rent out sports facilities to generate income\r\n•Sponsorship and partnerships\r\n•Periodic maintenance of sports facilities and equipments\r\n•Maintaining assest register and contolled access to equipment stores', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 20:19:24', '2026-02-01 21:38:25', '2026-02-01 23:19:24'),
(117, 15, 94, '• All students have GPA cover, and sporting injuries are covered by the university\r\n• Four physiotherapists are available with accessible first-aid kits and a dedicated physiotherapy room\r\n• Enforced use of protective gear and safety equipment\r\n• Conduct regular safety inspections of sports facilities and equipment', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 20:20:15', '2026-02-01 21:38:18', '2026-02-01 23:20:15'),
(118, 15, 94, '• Secure storage and access controls\r\n• Implemented preventive maintenance and inspection schedules', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 20:21:05', '2026-02-01 21:38:11', '2026-02-01 23:21:05'),
(119, 15, 95, '\"• Enforced a student elections policy and code of conduct\r\n• Ensure transparent voting and tallying\r\n• Develop clear election timelines and logistics plans\r\n• Dispute resolution and appeals mechanisms in place\"\r\n', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 20:24:31', '2026-02-01 21:38:04', '2026-02-01 23:24:31'),
(120, 15, 96, '• Established a dedicated international student office\r\n• Relationship management with government offices and ministry of education.\r\n• Email correspondence with international students\r\n• Calendar of events for international students.\r\nInternational students brochure', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 20:25:19', '2026-02-01 21:37:58', '2026-02-01 23:25:19');
INSERT INTO `control` (`control_id`, `dept_id`, `process_id`, `controls`, `cstrength`, `ctype`, `reviewer`, `rdate`, `userid`, `approval`, `uid_approve`, `created_at`, `approved_at`, `updated_at`) VALUES
(121, 15, 97, '• Committees for different events\r\n• Annual budgeting of events and events template/checklist.\r\nliason with student leadership in organising and planning for events.\r\n• Collection of feedback from studens for continous improvement. \r\n• Partnering with other stakeholders to make student events interesting.', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-01 20:26:00', '2026-02-01 21:37:50', '2026-02-01 23:26:00'),
(122, 16, 98, '• Proper orientation of staff and students.\r\n• Guidelines and simplified exam policies in place.\r\n• Limited access to examinations office. • Secure storage of exams\r\n• Controlled issuance of CATS and exams booklets\r\n• Issuance of exam cards\r\n• Examinations staff approval for doing short courses and also higher education courses relating to professional ethics\r\n• Benchmarking with other institutions e.g UNESCO, KNEC and other examining bodies\r\n• Documented procedures on handling exam integrity issues. \r\n• Exam machine which is immobile and offline\r\n• Separate exam network\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-02 09:16:17', '2026-02-02 10:31:49', '2026-02-02 12:16:17'),
(123, 16, 98, '•Strict invigilation measures\r\n•CCTV available\r\n•Strong disciplinary policy', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-02 09:16:49', '2026-02-02 10:31:56', '2026-02-02 12:16:49'),
(124, 16, 98, '•strict deadlines for faculty submission of papers\r\n• Internal and external reviews being done on time to avoid delays when submitting examinations.\r\n• Releasing timetable on time (timely scheduling of exams)\r\n• Implement trackers on receipt of CATs/Exams in time to enable early printing\r\n• Increased staff capacity to avoid delays', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-02 09:17:42', '2026-02-02 10:32:04', '2026-02-02 12:17:42'),
(125, 16, 98, '•Workload planning\r\n•Clear timelines set\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-02 09:18:45', '2026-02-02 10:32:11', '2026-02-02 12:18:45'),
(126, 16, 99, '• Policy on students documents management \r\n• Back up of exams on soft copy on external hardrive which is securely stored in the safe \r\n• Controlled access to exams office.\r\n•  Decentralize storage of data\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-02 09:19:27', '2026-02-02 10:32:17', '2026-02-02 12:19:27'),
(127, 16, 100, '• Calls and emails are handled by the team (examination centre email in place)\r\n• Segregation of roles to improve turn-around time of responses\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-02 09:21:48', '2026-02-02 10:32:24', '2026-02-02 12:21:48'),
(128, 16, 101, '•Regular training for exam staff\r\n•Clear communication\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-02 09:22:29', '2026-02-02 10:32:30', '2026-02-02 12:22:29'),
(129, 16, 102, '• Upgraded examination venues .\r\n• Big exam halls (exclusive use of rooms)\r\n• Timetabling system in place \r\n• Early planning\r\n• Improved the class booking system\r\n', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-02 09:23:06', '2026-02-02 10:32:36', '2026-02-02 12:23:06'),
(130, 16, 103, '•Adequate recruitment\r\n•Workforce planning\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-02 09:23:55', '2026-02-02 10:32:42', '2026-02-02 12:23:55'),
(131, 17, 104, '•Student outreach campaigns\r\n•Flexible session scheduling, peer-to-peer ambassadors', 2, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 03:37:19', '2026-02-03 04:42:40', '2026-02-03 06:37:19'),
(132, 17, 105, '•Participation during the established SU orientation week - introduction to students of the mentoring services staff and mentoring coordinators from the various schools and a presentation of the mentoring process with testimonials from students.\r\n•Faculty meet-your-mentor cocktails where the specific schools have an informal interaction between all the new students and all their mentors.                                                                     \r\n•Issuance of students mentoring handbook: include all mentoring activities for the year, list of mentors per faculty, insights on character.    \r\n•Welcome emails from mentoring services to all the new students.\r\n•Conduct virtual orientations and meet your mentor cocktails.\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 03:38:10', '2026-02-03 04:42:32', '2026-02-03 06:38:10'),
(133, 17, 106, 'Have 90% of first and second year students mentored by ensuring:                                                                        •100% Allocation: The number of all new students in a semester who have been allocated a mentor within the first month of their enrollment.                                                                \r\n•Atleast 90%  Uptake/initiation: Number of students with atleast one mentoring session recorded in their first semester over all students who were allocated mentors in that semester.                                                                   \r\n•Commitment: Students recording atleast 2 mentoring sessions per semester.                                                                                                      •Encourage mentors and mentees to meet virtually and use text or email to maintain contact.\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 03:39:21', '2026-02-03 04:42:25', '2026-02-03 06:39:21'),
(134, 17, 107, '•Training of mentoring services personnel in process mapping, measuring process performance and risk management.\r\n•Ensuring we get quarterly reports on student feedback consistently from Strategy and Quality Assurance Department.\r\n•Conduct periodic reviews and impact assessments to evaluate programme effectiveness and guide improvements                                                           \r\n', 2, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 03:40:06', '2026-02-03 04:42:17', '2026-02-03 06:40:06'),
(135, 18, 109, '•Institution-wide digital platform for research project  tracking and reporting in place (RMS)\r\n•SOPs and Policy in place for proposal submission, funding applications, ethics review, and reporting\r\n•Defined clear roles and responsibilities between the central research office and faculties.', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 06:02:41', '2026-02-03 07:12:46', '2026-02-03 09:02:41'),
(136, 18, 109, 'SU-ISERC undertakes internal monitoring and evaluation.\r\nNo research starts without written ethics approval fromSU-ISERC as well as approval from NACOSTI\r\nEthics and compliance training for researchersand students are conducted', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 06:03:11', '2026-02-03 07:12:36', '2026-02-03 09:03:11'),
(137, 18, 109, '•Regular data protection and privacy training to researchers, staff, and students\r\n•Ensure all research involving personal data includes informed consent forms and ethics approval.\r\n•Data Privacy Policy in place', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 06:03:47', '2026-02-03 07:12:26', '2026-02-03 09:03:47'),
(138, 18, 110, '•Recognize top authors through performance-based rewards or promotion points\r\n•Offer regular academic writing workshops, mentorship, and publication support clinics/brown bag sessions', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 06:04:23', '2026-02-03 07:12:15', '2026-02-03 09:04:23'),
(139, 18, 111, '•Conduct regular grant-writing workshops and mentorship programs for faculty and postgraduate students\r\n•Forge collaborative research agreements with industry and other universities to co-fund projects\r\n•Reward faculties and researchers who bring in external grants or produce high-impact research outputs\r\n•Establish an internal research fund to support seed projects or early-career researchers', 2, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 06:05:13', '2026-02-03 07:12:07', '2026-02-03 09:05:13'),
(140, 18, 111, '•Provide guidance and support for researchers to map their proposals to university goals during development.\r\n•Conduct training sessions for faculty and researchers on aligning funding opportunities with institutional objectives\r\n•Require all external grant proposals to be reviewed and endorsed by the research/grants office before submission to donors.\r\n•Develop and communicate a clear set of institutional research and innovation priorities linked to the strategic plan', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 06:05:49', '2026-02-03 07:11:59', '2026-02-03 09:05:49'),
(141, 18, 111, ' •Train PIs and project teams on donor-specific guidelines, contracts, and deliverables\r\n•Maintain a central repository of grant agreements with clear tracking of deliverables, due dates, and responsible persons\r\n•Grant dashboard to monitor timelines, outputs, and budget performance\r\n•Encourage project teams to include risk mitigation and contingency plans in project planning to address delays or unforeseen disruptions', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 06:06:34', '2026-02-03 07:11:51', '2026-02-03 09:06:34'),
(142, 18, 112, '•Promote co-funding and cost-sharing models\r\n•Build capacity of research hubs and project teams in sustainability planning and resource mobilization\r\n•Establish a post-grant monitoring mechanism to track continuation of outcomes and maintain accountability.', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 06:07:12', '2026-02-03 07:11:43', '2026-02-03 09:07:12'),
(143, 18, 113, '•Provide targeted funding schemes and seed grants to stimulate research.\r\n•Clear incentives and recognition frameworks for high-quality outputs\r\n•Build capacity through training, mentorship, and research support programs.\r\n•Establish regular monitoring and reporting of research output across CREs to identify gaps early', 3, 1, 1, '2026-02-02', 1, 2, 2, '2026-02-03 06:08:07', '2026-02-03 07:11:36', '2026-02-03 09:08:07'),
(144, 18, 114, '•plagiarism checks using reliable detection software before submission or publication.\r\n•Provide regular training and workshops on academic honesty and responsible conduct of research.\r\n•Foster a culture of ethics and transparency', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 06:08:47', '2026-02-03 07:11:26', '2026-02-03 09:08:47'),
(145, 19, 115, '•Enforced segregation of duties (different staff for requisition, approval, and payment)\r\n•E-procurement system in place to minimize manual manipulation', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 11:09:55', '2026-02-03 12:16:20', '2026-02-03 14:09:55'),
(146, 19, 116, '•Use forward contracts or bulk-purchasing agreements to lock in prices for critical imports eg HP laptops-the University has entered into a three-year framework agreement with HP, securing fixed pricing for laptops. This agreement provides a buffer against potential price hikes resulting from future tariff changes or trade disruptions, ensuring procurement stability through the three years\r\n•Regularly scan global and regional markets for emerging geopolitical risks\r\n•Supplier diversification:build a pool of both local and international suppliers.\r\n•Emergency procurement protocols: ensure contingency plans for critical supplies (fuel, ICT, food supplies)', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 11:10:43', '2026-02-03 12:16:13', '2026-02-03 14:10:43'),
(147, 19, 117, '•Supplier due diligence: evaluate financial health, capacity, and track record before contracting.\r\n•Supplier diversification-avoid over-reliance on one vendor by developing multiple supply sources.\r\n•Contingency planning-maintain backup suppliers and frameworks for emergency procurement.', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 11:11:40', '2026-02-03 12:16:07', '2026-02-03 14:11:40'),
(148, 19, 118, '•Scenario and contingency planning-identify critical supplies (ICT, labs, food services) and establish backup suppliers.\r\n•Policy and regulatory monitoring-track changes in procurement laws and align processes quickly\r\n•Use forward contracts or bulk-purchasing agreements to lock in prices for critical imports eg HP laptops-the University has entered into a three-year framework agreement with HP, securing fixed pricing for laptops. This agreement provides a buffer against potential price hikes resulting from future tariff changes or trade disruptions, ensuring procurement stability through the three years', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 11:12:29', '2026-02-03 12:16:00', '2026-02-03 14:12:29'),
(149, 19, 119, '•Strong access management-implement multi-factor authentication, regular password updates, and role-based access controls.\r\n•Cybersecurity awareness training in liaison with ICTS team-train staff on phishing, fraud detection, and safe system use', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 11:13:36', '2026-02-03 12:15:52', '2026-02-03 14:13:36'),
(150, 20, 120, '•Feedback mechanism in place for both trainees and clients\r\n•Conduct regular stakeholder consultations and needs assessments\r\n•Establish clear project scopes, deliverables, and timelines', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 11:58:22', '2026-02-03 13:02:44', '2026-02-03 14:58:22'),
(151, 20, 121, '•Established and enforced comprehensive laboratory and field safety policies\r\n•Provide and enforce use of appropriate PPE\r\n•Maintain incident reporting and investigation procedures\r\n•Conduct regular safety inspections \r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 11:59:14', '2026-02-03 13:02:37', '2026-02-03 14:59:14'),
(152, 20, 122, '•Budget controls and expenditure approval workflows implemented\r\n•There is a designated grants accountant who follows up on expenditure\r\n•Use automated financial management systems (kuali)', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 12:00:02', '2026-02-03 13:02:30', '2026-02-03 15:00:02'),
(153, 20, 123, '•Legal dept. reviews of all partnership agreements\r\n•Clearly define project scope, milestones, and deliverables in all projects\r\n•Maintain clear communication and escalation channels', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 12:00:36', '2026-02-03 13:02:23', '2026-02-03 15:00:36'),
(154, 21, 124, '•mandatory entrance exams/aptitude tests are conducted\r\n•Strengthened admission criteria and verification processes', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 17:18:32', '2026-02-03 18:28:17', '2026-02-03 20:18:32'),
(155, 21, 124, '•Marketing campaigns highlighting career opportunities\r\n•Scholarships for bright needy students provided\r\n•Parent engagement forums to enhance connections\r\n•Partnerships with industry for internships', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 17:18:59', '2026-02-03 18:28:10', '2026-02-03 20:18:59'),
(156, 21, 125, '•Industry partnerships \r\n•Internship programs available\r\n•Curriculum reviews conducted to ensure match with market changes', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 17:19:47', '2026-02-03 18:28:02', '2026-02-03 20:19:47'),
(157, 21, 126, '•Flexible payment options (fees)\r\n•Mentoring services available', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 17:21:18', '2026-02-03 18:27:18', '2026-02-03 20:21:18'),
(158, 21, 127, '•Enforced strict tuition payment deadlines and policies\r\n•Diversify funding sources to reduce reliance on tuition alone\r\n•Provide flexible but controlled payment plans\r\n•Designated finance officer at School level to follow-up on debt collection', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-03 17:22:32', '2026-02-03 18:27:10', '2026-02-03 20:22:32'),
(159, 22, 128, '•Dedicated personnel at STH who deals with admission process and ensuring compliance and all requirements are met\r\n•Ensure all international students submit KNQA certificate that certifies that they have met qualifications', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-04 19:50:54', '2026-02-05 04:21:56', '2026-02-04 22:50:54'),
(160, 22, 128, '• Aggressive marketing including IGSE schools, technical colleges, County schools all over  the country and targeting the right people i.e. Strathmore alumni, School  owners for diploma of education management program.\r\n• Multiple intakes in the year. (July/ November)\r\n• Flexible modular and hybrid programmess to allow interested students to enroll for the programs at different times in the year and from different locations. e.g. professionals for evening classes.\r\n• Nurture relationship with prospective clients through free career guidance workshops, open days and sponsoring academic competitions e.g. High school mathematics competition.\r\n•Marketing internationally i.e. Rwanda, Uganda, Tanzania and Burundi.\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-04 19:51:35', '2026-02-05 04:21:49', '2026-02-04 22:51:35'),
(161, 22, 129, '• Timely registration of first year students with provision for late comers.\r\n• Provide orientation to individual latecomers \r\n• Timely communication to students on orientation dates to ensure attendance\r\n• Issuing of timetables in a timely manner', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 02:31:49', '2026-02-05 04:21:41', '2026-02-05 05:31:49'),
(162, 22, 130, '• Timely follow up on debt\r\n• Timely invoicing of fees \r\n• Engagement with parents \r\n• Providing or facilitating financial aid for needy students \r\n• Timely resolution of invoicing descrepancies \r\n• Provision for fee installments ', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 02:43:33', '2026-02-05 04:21:32', '2026-02-05 05:43:33'),
(163, 22, 131, '• Consistent monitoring and tracking of expenditure\r\n• Appropriate controls to prevent over expenditure on specific budget lines\r\n• Quarterly review of financial performance reports\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 02:44:09', '2026-02-05 04:21:24', '2026-02-05 05:44:09'),
(164, 22, 132, '• Timely registration of students on AMS - within the first 3 weeks\r\n•Timely communication of examination timelines and deadline to lecturers \r\n• Existing policies and procedures to guide on the process', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 02:44:56', '2026-02-05 04:21:17', '2026-02-05 05:44:56'),
(165, 22, 133, '• A research center (BID-C) has been established to promote research work and acess funding opportunities\r\n• Sourcing for research for research grants\r\n• Publishing of research work\r\n• Increase participation in research brown-bag sessions\r\n• Provide training for staff on grants and proposal writing ', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 02:45:38', '2026-02-05 04:21:09', '2026-02-05 05:45:38'),
(166, 22, 134, 'Enforced strong password policies and two-factor authentication\r\nImplemented role-based access control', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 02:46:29', '2026-02-05 04:20:22', '2026-02-05 05:46:29'),
(167, 23, 135, '•Regularly review targeting criteria\r\n•Train development staff on effective donor research and alignment techniques\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:08:43', '2026-02-05 06:49:36', '2026-02-05 08:08:43'),
(168, 23, 135, '•Conduct comprehensive due diligence\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:09:14', '2026-02-05 06:49:29', '2026-02-05 08:09:14'),
(169, 23, 137, '•Train staff in effective qualification techniques\r\n-Conduct peer reviews of prospect qualification decisions for major donors', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:09:42', '2026-02-05 06:49:22', '2026-02-05 08:09:42'),
(170, 23, 137, '•Training for staff on data entry protocols and accuracy\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:10:13', '2026-02-05 06:49:15', '2026-02-05 08:10:13'),
(171, 23, 138, '•Segment donors and tailor touchpoints (events, emails, updates) based on interests\r\n•Provide ongoing training for staff on relationship-building and stewardship.', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:11:07', '2026-02-05 06:49:09', '2026-02-05 08:11:07'),
(172, 23, 139, '•Monitor donor engagement analytics to detect signs of fatigue\r\n•Implement a donor communication calendar with cooling-off periods between asks', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:11:34', '2026-02-05 06:49:01', '2026-02-05 08:11:34'),
(173, 23, 139, '•Maintain transparency with donors on what is achievable, including any risks or limitations\r\n•Regularly review and reconcile donor expectations with project reports to detect and correct misalignments early\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:12:16', '2026-02-05 06:45:40', '2026-02-05 08:12:16'),
(174, 23, 139, '•Conduct donor readiness assessments before making an ask (review engagement history, prior giving, and capacity)\r\n•Develop and follow a structured cultivation timeline before solicitation', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:12:56', '2026-02-05 06:45:29', '2026-02-05 08:12:56'),
(175, 23, 139, '•Provide training in proposal writing and donor-focused communication for staff\r\n•Use a standardized proposal template that includes clear objectives, timelines, budgets, and expected impact.\r\n•Conduct internal peer review and approval processes before submission to donors', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:13:32', '2026-02-05 06:45:22', '2026-02-05 08:13:32'),
(176, 23, 140, '•Strict financial controls in place\r\n•Regular financial reporting to MB', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:14:00', '2026-02-05 06:45:14', '2026-02-05 08:14:00'),
(177, 23, 140, '•Develop a mixed portfolio of funding sources, \r\n•Develop new donor acquisition strategies to expand donor base, \r\n•Stay informed about trends and shifts in donor preferences\r\n•Regularly review the donor portfolio to assess concentration risk\r\n•Establish a university endowment fund to support long-term sustainability', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:14:36', '2026-02-05 06:42:11', '2026-02-05 08:14:36'),
(178, 23, 141, 'cross-training and professional development opportunities to groom internal talent for future leadership positions\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:15:10', '2026-02-05 06:26:23', '2026-02-05 08:15:10'),
(179, 23, 141, '•Develop unique value propositions, \r\n•Implement donor segmentation (Use data to segment donors and tailor communication and engagement strategies to different groups), \r\n•Regularly evaluate and improve fundraising strategies based on donor feedback and market trends.\r\n•Deepen engagement through meaningful stewardship, alumni involvement, and transparency\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:15:39', '2026-02-05 06:26:17', '2026-02-05 08:15:39'),
(180, 23, 142, '•Ensure all donor data collection and communication follow data privacy laws\r\n•Maintain documented donor agreements, financial records, and grant compliance logs', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:16:10', '2026-02-05 06:26:10', '2026-02-05 08:16:10'),
(181, 23, 143, '•Diversify donor portfolio\r\n•Monitor economic and political trends through scenario planning and forecasting\r\n•Establish a reserve or endowment fund to cushion against economic shocks', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:16:49', '2026-02-05 06:26:03', '2026-02-05 06:21:28'),
(182, 23, 144, '•Educate employees on data protection best practices, phishing prevention, and incident response protocols\r\n•Assess and monitor third-party vendors handling donor data to ensure they meet adequate security standards\r\n•Implement robust data encryption, access controls, and secure storage practices for donor information (in liaison with ICTS)', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 05:22:24', '2026-02-05 06:25:57', '2026-02-05 08:22:24'),
(183, 24, 145, '•Enforced Standard Operating Procedures (SOPs) for every step of patient flow.\r\n•Real-time queue management system in place\r\n•Established triage prioritization protocols to fast-track urgent cases\r\n•Strengthened interdepartmental coordination between reception, triage, lab, imaging, pharmacy, billing\r\n•Track Turnaround Time (TAT) for each service area\r\n•Set TAT benchmarks (e.g., triage within 10 minutes, registration within 5 minutes)\r\n•Continuous staff training on customer service, time management, and workflow efficiency.\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:36:29', '2026-02-05 08:45:01', '2026-02-05 10:36:29'),
(184, 24, 146, '•Strict hand hygiene protocols enforced at all clinical touchpoints\r\n•Proper medical waste segregation (sharps, infectious waste, non-infectious)\r\n•Visual reminders (posters, workplace guides) on IPC protocols\r\n•Installed hand-washing stations and sanitizer dispensers at strategic points\r\n•Training housekeepers on how to clean and disifect using the recommeded solutions and ratios\r\n•Routine immunizations for staff against infectious diseases like flu, cholera and hepatitis\r\n\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:37:03', '2026-02-05 08:44:53', '2026-02-05 10:37:03'),
(185, 24, 147, '•Implement and enforce standard medication administration procedures (the 6 Rights)\r\n•Standardize medication labeling, storage, and separation of look-alike/sound-alike drugs\r\n•Regular staff training on medication safety and the six rights\r\n•Use of electronic medical records (EMR) for prescription verification and alerts\r\n•Ensure timely and accurate documentation after medication administration\r\n•Improved communication channels between pharmacy and clinical teams', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:37:34', '2026-02-05 08:44:45', '2026-02-05 10:37:34'),
(186, 24, 148, '•The Sanitas system uses Role-Based Access Control to restrict access to patient records based on the user’s role within the medical centre. Each role is assigned specific permissions that dictate the level of access to patient data.\r\n•Regular review of user access rights\r\n•Secure storage of paper files (locked cabinets where applicable)\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:38:02', '2026-02-05 08:44:40', '2026-02-05 10:38:02'),
(187, 24, 148, 'SUMC collaborates closely with ICTS team which ensures:\r\n•Strong firewalls and endpoint protection\r\n•Regular patching and updates\r\n•Implementation of a network firewall, database activity monitoring (DAM) monitoring solution, Disaster Recovery (DR) site and an automated backup solution.', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:38:28', '2026-02-05 08:44:34', '2026-02-05 10:38:28'),
(188, 24, 148, '•Conducted due diligence before signing a contract with Fortis Innovations (provider of the Sanitas system) and ascertained that they have registered with the Office of the Data Protection Commissioner. \r\n•There is a dedicated ICT personnel from the university who oversees the system’s performance, monitors system logs, and ensures security protocols are followed. The ICT personnel collaborates with the system provider to troubleshoot issues, apply updates, resolve incidents, and escalate any system vulnerabilities immediately.\r\n•Multi-factor authentication (MFA) and role-based access control\r\n•Train all users on proper system use, data privacy guidelines, and secure handling practices.', 2, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:38:55', '2026-02-05 08:44:27', '2026-02-05 10:38:55'),
(189, 24, 148, '•Data privacy and ethics training conducted\r\n•Orientation training for new staff on confidentiality rules\r\n•Whistleblower mechanism for reporting misconduct in place\r\n•Disciplinary action against individuals who knowingly go against this\r\n•Report significant breaches to regulators as required by law', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:39:21', '2026-02-05 08:44:21', '2026-02-05 10:39:21'),
(190, 24, 149, '•Double-check high-risk medications\r\n•Ensure clear electronic prescriptions (include all prescription particulars into the HMIS prescription)', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:39:50', '2026-02-05 08:44:14', '2026-02-05 10:39:50'),
(191, 24, 149, '•Use the FEFO system\r\n•Daily temperature & humidity monitoring for certain medicines eg insulin\r\n•Regular quality and expiry checks\r\n', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:40:32', '2026-02-05 08:44:08', '2026-02-05 10:40:32'),
(192, 24, 150, '•Automated inventory tracking\r\n•Diverse supplier base in place\r\n•Established minimum stock levels\r\n', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:41:02', '2026-02-05 08:44:02', '2026-02-05 10:41:02'),
(193, 24, 151, '•First aid training for staff\r\n•Partnerships with nearby hospitals', 3, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:41:29', '2026-02-05 08:43:56', '2026-02-05 10:41:29'),
(194, 24, 152, '•Ensure all licenses are duly renewed and staff also have required updated licenses eg pharmacists\r\n•Ensure compliance', 4, 1, 1, '2026-02-01', 1, 2, 2, '2026-02-05 07:41:58', '2026-02-05 08:43:47', '2026-02-05 10:41:58');

-- --------------------------------------------------------

--
-- Table structure for table `control_strength`
--

CREATE TABLE `control_strength` (
  `strength_id` int(11) NOT NULL,
  `cs_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_strength`
--

INSERT INTO `control_strength` (`strength_id`, `cs_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Ineffective', 'Controls are not adequate, appropriate or effective. They do not provide reasonable assurance that risks are being managed. Controls are poorly communicated and are not subject to monitoring.\r\n', '2025-10-15 12:28:01', '2025-10-15 12:28:01'),
(2, 'Improvement Desired', 'Numerous specific control weaknesses noted. Controls evaluated are unlikely to provide reasonable assurance that risks are being managed.\r\n', '2025-10-15 12:28:22', '2025-10-15 12:28:22'),
(3, 'Well Based', 'A few specific control weaknesses noted. However, many controls are adequate, appropriate and effective to provide a solid basis for assurance that risks are being managed.\r\n', '2025-10-15 12:28:59', '2025-10-15 12:28:59'),
(4, 'Effective/Strong', 'Controls are adequate, appropriate and effective. They provide a reasonable assurance that risks are being managed and objectives should be met\r\n', '2025-10-15 12:29:21', '2025-10-15 12:29:21');

-- --------------------------------------------------------

--
-- Table structure for table `control_type`
--

CREATE TABLE `control_type` (
  `ctype_id` int(11) NOT NULL,
  `ct_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `control_type`
--

INSERT INTO `control_type` (`ctype_id`, `ct_name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Preventive', 'Before the event, preventive controls are intended to prevent an incident from occurring e.g. firewalls to avoid system intrusions, employee background checks, employee training, password protected access, security camera systems, segregation of duties etc.\r\n', '2025-10-15 12:26:43', '2025-10-15 12:26:43'),
(2, 'Detective', 'During the event, detective controls are intended to identify and characterize an incident in progress e.g. transaction authorisation, reconciliation, physical inventory counts etc.\r\n', '2025-10-15 12:27:08', '2025-10-15 12:27:08'),
(3, 'Corrective', 'After the event, corrective controls are intended to limit the extent of any damage caused by the incident e.g. recoveries from insurance, data backups, management review\r\n', '2025-10-15 12:27:30', '2025-10-15 12:27:30');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `dept_id` int(11) NOT NULL,
  `dept_name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company` int(11) NOT NULL,
  `owners` int(11) NOT NULL,
  `functions` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`dept_id`, `dept_name`, `company`, `owners`, `functions`, `created_at`) VALUES
(1, 'Internet of Things (IOT)', 1, 1, 'IOT Project implimentations			\r\nIOT Research and implimentation			\r\nCapacity building and training on IOT and related technologies			\r\nPartnership and industrial collaboration', '2025-10-15 11:05:04'),
(2, 'Career Development Services', 1, 1, 'Link students to employers-prepare students for industry', '2025-10-15 11:21:24'),
(3, 'Examinations Office', 1, 1, 'Ensure that exams and CATs are administered as scheduled, Ensure that the printed exams are well packed and no leakage occurs, Ensure the student records on AMS are not tampered with, Ensure that graduating and continuing students get their certificates and transcripts on time, Ensure that Faculties/Schools adhere to the set examination policies and procedures,Ensure timely and smooth running of exams and CATs in the venue', '2025-10-15 11:22:06'),
(4, 'Finance', 1, 1, 'Provision of quality financial services e.g. ensuring statutory compliance, timely processing of payments.     \r\nEnsuring safe custody of grants, provide information on donor funds and administration of donor funds.     \r\nEnsuring proper Budgeting for the University as well as budget control.     \r\nEnsuring accurate, timely and efficient processing of payments      \r\nEnsuring Prompt collection of Debts to ensure that the University manages its Working Capital in an efficient manner      \r\nEnsuring safe custody of University financial resources and other assets.     \"', '2025-10-15 11:23:12'),
(5, 'Housekeeping', 1, 1, 'To provide and maintain quality standards of a clean, safe and healthy working environment for all students, staff and visitors using University facilities,To enhance the appearance of the University facilities and contribute to the delivery of core activities, To cater for the laundry requirements of various departments in the University, To achieve the maximum possible efficiency in ensuring the care and comfort of all our students, staff and guests, To establish a welcoming atmosphere and ensure couteous, reliable service from all the staff of the department', '2025-10-15 11:23:57'),
(6, 'ICTS', 1, 1, 'Service delivery - improve operational efficiency and effectiveness of business operations, Reduce ICT-related business risk by improving security of systems and services, To lead innovation opportunities for the University by automating University processes, Provision of an appropriate ICT infrastructure optimized to meet University needs, Develop and better manage ICT Talent.', '2025-10-15 11:25:22'),
(7, 'People & Culture', 1, 1, 'Recruit and retain competent staff, Resolve disputes within departments and across the entire University, facilitate career growth amongst staff (staff trainig and development)    \r\nSuccession planning for continuity    \r\nProvide and foster a good working environment, Ensure employee wellbeing through implementation of staff wellness programs, Employee performance management    \r\nCompensation management.', '2025-10-15 11:25:58'),
(8, '(SCES)School of Computing and Engineering Sciences', 1, 1, 'To create a  learning environment where students learn to become global change agents. ,To nurture an atmosphere of collaborative, innovative and flexible research, To educate, support, and empower employees to improve their knowledge and skills and maintain their overall health and well-being, To improve quality of life of the local community through ethical leadership and community projects.', '2025-10-15 11:27:00'),
(9, '(SHSS)School of Humanities and Social Sciences', 1, 1, 'To provide an all-round education on humanities and social sciences to all undergraduate and postgraduate students of the University.,To develop core human virtues., To develop transformative virtuous leadership., To excel in languages teaching., To capacitate all willing students with an additional means of linguistic communication., To provide teacher enhancement programs for lecturers and teachers.    \r\nTo bring on board degrees in Strathmore which will equip students with skills that will enable them to communicate effectively; skills that will enable them start a career in organizations that traverse national boundaries; and offer a unique and comprehensive combination of philosophical grounding for the issues of human development.', '2025-10-15 11:27:58'),
(10, 'School of Humanities and Social Sciences  (SHSS)', 1, 1, 'To provide an all-round education on humanities and social sciences to all undergraduate and postgraduate students of the University. To develop core human virtues., To develop transformative virtuous leadership., To excel in languages teaching., To capacitate all willing students with an additional means of linguistic communication., To provide teacher enhancement programs for lecturers and teachers.    \r\nTo bring on board degrees in Strathmore which will equip students with skills that will enable them to communicate effectively; skills that will enable them start a career in organizations that traverse national boundaries; and offer a unique and comprehensive combination of philosophical grounding for the issues of human development.', '2026-01-29 18:00:37'),
(11, 'Administration Services ', 1, 1, 'Provide support e.g. transport, maintenance and repairs, utility services to all areas of the University.   \r\n Ensure the safety and health of staff and visitors.   \r\n To maintain physical assets in good condition.   \r\n To ensure optimal allocation of space and furniture.   \r\nFollow up on claims of the university from external parties.', '2026-01-29 18:05:43'),
(12, 'Admission & Marketing', 1, 1, 'Ensure only qualified students join the University.     \r\nOnboard the projected/ budgeted number of students.     \r\nEnsure that students onboarded meet the minimum requirements/qualification set.      \r\nMarket university programs to target market.', '2026-01-29 18:06:39'),
(13, 'Alumni Risk Register', 1, 1, 'Increase Alumni participation through targeted alumni events    \r\nBuild and sustain a vibrant Alumni Association    \r\nStrengthen Strathmore Alumni affinitty and engagement    \r\nGrow student enrollment and participation in the alumni community   \r\nPromote adoption and use of alumni merchandise', '2026-01-29 18:07:24'),
(14, 'Corporate Communications Office', 1, 1, 'Enhance positive messaging that demonstrates SU as a trailblazer in ethical leadership, innovation, and positive impact.    \r\nExplore opportunities for greater event & content coordination across schools and departments.    \r\nRaise SU national and global profile and maintain the university\'s christian identity    \r\n\"\"Develop strategic promotion campaigns to support university marketing communication goals   \r\nExecute effective internal and external stakeholder management.', '2026-01-29 18:07:59'),
(15, 'Dean of Students', 1, 1, 'Enhance student success and holistic development    \r\nSupport and strengthen student leadership structures    \r\nImprove international student support services    \r\nPromote inclusive student engagement    \r\nCoordinate student welfare and well‑being support    \r\nStrengthen communication and collaboration with the university community    \r\nAdvance student development through service and community initiatives', '2026-01-29 18:08:29'),
(16, 'Library-Risk ', 1, 1, 'Expand and strengthen teaching role and educational impact at the university     \r\nBuild sustainable digital infrastructure to support expanding modes of research,teaching, and scholarly communication     \r\nEstablish processes and support structures that ensure we can select, acquire, preserve, and provide access to the full spectrum of research materials     \r\nCreate a user experience that is high quality, consistent, and robust regardless of the user’s location, access method, or objective     \r\nEngage with our users through communication strategies that make library resources and services more visible, more used, and better attuned to user needs.', '2026-01-29 18:09:01'),
(17, 'Mentoring Services', 1, 1, 'To contribute to the formation of the all-round SU graduate through personal and industry mentoring by providing information and a supportive relationship\r\n that aims at increased self confidence, self awareness and management of behaviour.', '2026-01-29 18:09:29'),
(18, 'R&I Risk ', 1, 1, 'Quality research and high capacity building in research personnel   \r\nIncrease research funding   \r\nIncreased Strathmore university presence in the research realm   \r\nImpactful research and innovations   \r\nTriple helix research projects', '2026-01-29 18:09:59'),
(19, 'Procurement Risk ', 1, 1, 'Procure quality goods and services at competitive prices   \r\nPromote cost efficiency and optimal use of institutional resources   \r\nEnsure timely availability of goods, works, and services to support teaching, research, and administration', '2026-01-29 18:10:29'),
(20, 'SERC Risk ', 1, 1, 'Conduct high-quality applied research in renewable energy and energy efficiency.   \r\nProvide professional training and capacity building in the energy sector   \r\nOffer expert advice and services to stakeholders   \r\nOffer laboratory testing, especially for solar PV', '2026-01-29 18:10:58'),
(21, 'SIMS', 1, 1, 'Promote an all-round education through personalised mentoring; creating an open learning environment that allows exchange of viewpoints from different cultures, social, religious and ethical backgrounds; as well as fostering an environment that promotes positive personal habits that nurture personal development.					\r\nPromote research in mathematical sciences and continuously improve on the data available within the institution’s data repository, thus enhancing the quality of research output.					\r\nEncourage and support interdisciplinary and multidisciplinary research					\r\nNurture lifelong learners who are inspired to continue learning after they leave the classroom and pursue learning independently.					\r\nOffer students the opportunity to experience the worth of helping others and serving the society.					\r\n', '2026-01-29 18:11:34'),
(22, 'School of Tourism & Hospitality', 1, 1, 'To deliver market oriented curriculum using effective learning and transformation mechanisms    \r\nTo enhance student achievement in academics and engagement in co-curricular activities.    \r\nTo promote  research-based teaching and learning and attract research funding', '2026-01-29 18:11:57'),
(23, 'SUF Risk ', 1, 1, 'Enhanced sustainable Fundraising    \r\nStrengthening Donor Relationships    \r\nExpanding Donor Base & Reach    \r\nBuild organizational capacity', '2026-01-29 18:12:37'),
(24, 'SUMC Risk ', 1, 1, 'To improve the quality of outpatient clinical care services   \r\nTo improve the quality of clinical disgnostic services   \r\nTo strengthen health system to respond to the quality service delivery needs', '2026-01-29 18:13:01');

-- --------------------------------------------------------

--
-- Table structure for table `dept_process`
--

CREATE TABLE `dept_process` (
  `dept_id` int(11) NOT NULL,
  `process_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE `division` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE `files` (
  `id` int(11) NOT NULL,
  `risk_id` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `findings`
--

CREATE TABLE `findings` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `ongoing` int(11) NOT NULL,
  `pending` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `impact`
--

CREATE TABLE `impact` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `impact`
--

INSERT INTO `impact` (`id`, `name`, `level`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Insignificant ', 1, 'The consequences are dealt with by routine operations.\r\nThe risk has little to no noticeable effect on the university\'s operations, reputation, or finances.\"\r\n', '2025-10-15 11:42:30', '2025-10-15 11:42:30'),
(2, 'Minor', 2, 'The consequences would threaten the efficiency or effectiveness of some aspect of the activity but would be dealt with internally.\r\nThe risk might cause some disruption but can be easily managed or contained with minimal resources. The impact is noticeable but not detrimental to the university’s core operations.', '2025-10-15 11:43:11', '2025-10-15 11:43:11'),
(3, 'Moderate', 3, 'The consequences would not threaten the activity but would mean that the activity could be subject to significant review or changed ways of operating.\r\nThe risk might cause some disruption, and while it can be managed, it would require attention and effort to resolve.\"\r\n', '2025-10-15 11:43:52', '2025-10-15 11:43:52'),
(4, 'Major', 4, 'The consequences would threaten the survival or continued effective operation of the activity or project, or attract adverse media attention, and require senior management and/or the Council action.\r\nRisks with significant consequences that could disrupt key university functions or have serious financial or reputational repercussions. They are not immediately catastrophic but require prompt and significant action.\r\n', '2025-10-15 11:44:30', '2025-10-15 11:44:30'),
(5, 'Extreme', 5, 'The consequences would threaten the survival of not only the activity, but also the entire Strathmore University, possibly causing major problems for stakeholders and require Council intervention.\r\nThese risks have catastrophic consequences for the university. They could potentially endanger its long-term viability or pose severe legal, financial, or reputational risks. They require urgent, high-level intervention.\r\n', '2025-10-15 11:45:13', '2025-10-15 11:45:13');

-- --------------------------------------------------------

--
-- Table structure for table `incident`
--

CREATE TABLE `incident` (
  `incident_id` int(11) NOT NULL,
  `incident` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept_id` int(11) NOT NULL,
  `process_id` int(11) NOT NULL,
  `risk_id` int(11) NOT NULL,
  `dol` date NOT NULL,
  `actual` int(11) NOT NULL,
  `expected` int(11) NOT NULL,
  `potential` int(11) NOT NULL,
  `recovery` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ki`
--

CREATE TABLE `ki` (
  `id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `process_id` int(11) NOT NULL,
  `risk_id` int(11) NOT NULL,
  `ki` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `approval` int(11) DEFAULT 1,
  `uid_approve` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `approved_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kri`
--

CREATE TABLE `kri` (
  `id` int(11) NOT NULL,
  `kpi` int(11) NOT NULL,
  `kri` int(11) NOT NULL,
  `perform` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `b_objective` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kri_hist`
--

CREATE TABLE `kri_hist` (
  `kri` int(11) NOT NULL,
  `rapetite` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `date` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kri_hist`
--

INSERT INTO `kri_hist` (`kri`, `rapetite`, `owner`, `date`, `created_at`) VALUES
(1, 40, 1, '2026-05-31', '2026-05-18 17:34:04'),
(1, 50, 1, '2026-06-26', '2026-05-18 17:36:31'),
(2, 80, 1, '2026-05-30', '2026-05-18 17:37:10'),
(1, 4, 1, '2026-05-31', '2026-05-18 17:48:27'),
(2, 70, 1, '2026-06-19', '2026-05-18 23:09:09'),
(2, 79, 1, '2026-07-11', '2026-05-18 23:09:33'),
(2, 68, 1, '2026-08-29', '2026-05-18 23:10:02'),
(3, 0, 1, '0000-00-00', '2026-05-19 10:26:25'),
(3, 40, 1, '2026-06-30', '2026-05-19 10:26:25'),
(4, 1, 1, '2026-05-30', '2026-05-19 11:42:02'),
(5, 77, 1, '2026-06-01', '2026-05-19 11:43:37'),
(5, 60, 1, '2026-07-05', '2026-05-19 11:44:21'),
(5, 80, 1, '2026-07-08', '2026-05-19 11:44:38'),
(5, 88, 1, '2026-09-26', '2026-05-19 11:45:00'),
(5, 99, 1, '2026-10-16', '2026-05-19 12:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `kri_parameter`
--

CREATE TABLE `kri_parameter` (
  `id` int(11) NOT NULL,
  `pname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rlimit` int(11) NOT NULL,
  `fmngt` int(11) NOT NULL,
  `tmngt` int(11) NOT NULL,
  `fboard` int(11) NOT NULL,
  `tboard` int(11) NOT NULL,
  `fmboard` int(11) NOT NULL,
  `tmboard` int(11) NOT NULL,
  `pdesc` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kri_parameter`
--

INSERT INTO `kri_parameter` (`id`, `pname`, `rlimit`, `fmngt`, `tmngt`, `fboard`, `tboard`, `fmboard`, `tmboard`, `pdesc`, `dept_id`, `created_at`) VALUES
(1, 'Percentage', 40, 0, 50, 51, 70, 71, 100, 'this is for percentage', 24, '2026-03-30 13:52:21'),
(2, 'Days', 20, 0, 50, 51, 80, 81, 100, 'test', 24, '2026-05-04 21:06:58'),
(3, 'Number of false alerts', 7, 1, 2, 3, 5, 6, 9, 'this is erroneous autogenerated alerts from firewall', 24, '2026-05-04 21:11:38');

-- --------------------------------------------------------

--
-- Table structure for table `letterupload`
--

CREATE TABLE `letterupload` (
  `id` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `likelihood`
--

CREATE TABLE `likelihood` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` int(11) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `likelihood`
--

INSERT INTO `likelihood` (`id`, `name`, `level`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Rare', 1, 'Not likely to happen within the next 5 -10 years\r\nVery low probability of the risk event occurring (0-4%)\"\r\n', '2025-10-15 11:46:43', '2025-10-15 11:46:43'),
(2, 'Unlikely', 2, 'Could occur within a 2-to-5-year period.\r\nRisk event not expected to happen, however an outside chance exists (5 -24%).\r\n', '2025-10-15 11:57:21', '2025-10-15 11:57:21'),
(3, 'Possible', 3, 'Possible to occur within the next 6 months - 1 year\r\nThe indicators are that:\r\nthere is a history of occurrence in the University  in the last 1 year\r\nIt has happened to our competitors in the last year 1 year.\r\nRisk event could potentially take place (25 – 54%)\"\r\n', '2025-10-15 12:10:27', '2025-10-15 12:10:27'),
(4, 'Likely', 4, 'Likely to arise within the next 3 - 6 months\r\nThe indicators are that:\r\nit has occurred at least once in the last 6 months\r\nthere is a potential of it occurring several times within 6 months\r\nProbable that the risk event will occur (55 – 89%)\"\r\n', '2025-10-15 12:12:46', '2025-10-15 12:12:46'),
(5, 'Materialized/ Almost certain', 5, 'Has occurred/Is occurring or will occur within the next 0 - 3 months\r\nStrong probability (>90%) that the risk event will occur\"\r\n', '2025-10-15 12:14:36', '2025-10-15 12:14:36');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempt`
--

CREATE TABLE `login_attempt` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `attempted_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login_attempt`
--

INSERT INTO `login_attempt` (`id`, `ip_address`, `email`, `attempted_at`) VALUES
(1, '::1', 'hillary@gmail.com', '2026-06-24 14:06:15'),
(2, '::1', 'hillary@gmail.com', '2026-06-24 14:06:22');

-- --------------------------------------------------------

--
-- Table structure for table `meeting`
--

CREATE TABLE `meeting` (
  `id` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `participant` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `requirement` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mdate` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mngtletter`
--

CREATE TABLE `mngtletter` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `closed` int(11) NOT NULL,
  `ongoing` int(11) NOT NULL,
  `pending` int(11) NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nletter`
--

CREATE TABLE `nletter` (
  `id` int(11) NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entity` int(11) NOT NULL,
  `sdate` date NOT NULL,
  `edate` date NOT NULL,
  `owner` int(11) NOT NULL,
  `description` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `nominee`
--

CREATE TABLE `nominee` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `owner`
--

CREATE TABLE `owner` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sup` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `dept` int(11) NOT NULL,
  `division` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `passess_fin`
--

CREATE TABLE `passess_fin` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `kra` int(11) NOT NULL,
  `kpi` int(11) NOT NULL,
  `target` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `weight` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q1_actual` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q1_per` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q2_actual` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q2_per` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q3_actual` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q3_per` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q4_actual` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `q4_per` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbscbusiness`
--

CREATE TABLE `pbscbusiness` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `kra` int(11) NOT NULL,
  `kpi` int(11) NOT NULL,
  `baseline` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ftarget` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(8,4) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbsccustomer`
--

CREATE TABLE `pbsccustomer` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `kra` int(11) NOT NULL,
  `kpi` int(11) NOT NULL,
  `baseline` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ftarget` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(8,4) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbscfinancial`
--

CREATE TABLE `pbscfinancial` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `kra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `kpi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `baseline` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ftarget` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(8,3) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbsclgrowth`
--

CREATE TABLE `pbsclgrowth` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `kra` int(11) NOT NULL,
  `kpi` int(11) NOT NULL,
  `baseline` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ftarget` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `weight` decimal(8,3) NOT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pbscsetting`
--

CREATE TABLE `pbscsetting` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `bscname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `year` year(4) NOT NULL,
  `rfinance` int(11) NOT NULL,
  `rcustomer` int(11) NOT NULL,
  `rbusiness` int(11) NOT NULL,
  `rgrowth` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `performance`
--

CREATE TABLE `performance` (
  `id` int(11) NOT NULL,
  `process_id` int(11) NOT NULL,
  `risk_id` int(11) NOT NULL,
  `measure` varchar(300) NOT NULL,
  `apetite` int(11) NOT NULL,
  `risk_apetite` int(11) NOT NULL,
  `rapetite_desc` text NOT NULL,
  `timeline` date NOT NULL,
  `approved_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `performance`
--

INSERT INTO `performance` (`id`, `process_id`, `risk_id`, `measure`, `apetite`, `risk_apetite`, `rapetite_desc`, `timeline`, `approved_at`, `updated_at`) VALUES
(1, 148, 191, 'Number of false alerts', 3, 4, 'extreme case of erroneous alarts from firewall', '2026-05-31', '2026-05-04 21:17:01', '2026-05-18 17:48:27'),
(2, 132, 168, 'measure with KRI', 1, 68, 'testing', '2026-05-31', '2026-05-12 12:47:52', '2026-05-18 23:10:02'),
(3, 149, 194, 'Number of times false medicine dispensed', 1, 40, 'Number of times false medicine dispensed', '2026-05-23', '2026-05-19 10:24:41', '2026-05-19 10:26:25'),
(4, 150, 196, 'percentage of stock out', 1, 20, 'percentage of stock out', '2026-05-30', '2026-05-19 11:42:02', '2026-05-19 11:42:02'),
(5, 152, 198, 'test', 1, 99, 'testing', '2026-06-01', '2026-05-19 11:43:37', '2026-05-19 12:18:25');

-- --------------------------------------------------------

--
-- Table structure for table `permission`
--

CREATE TABLE `permission` (
  `uid` int(11) NOT NULL,
  `add_btn` int(11) NOT NULL,
  `edit_btn` int(11) NOT NULL,
  `delete_btn` int(11) NOT NULL,
  `process` int(11) NOT NULL,
  `control` int(11) NOT NULL,
  `recommend` int(11) NOT NULL,
  `rlist` int(11) NOT NULL,
  `rassess` int(11) NOT NULL,
  `rregister` int(11) NOT NULL,
  `top` int(11) NOT NULL,
  `kpi` int(11) NOT NULL,
  `kri` int(11) NOT NULL,
  `perform` int(11) NOT NULL,
  `incident` int(11) NOT NULL,
  `action` int(11) NOT NULL,
  `objective` int(11) DEFAULT NULL,
  `report` int(11) NOT NULL,
  `card` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permission`
--

INSERT INTO `permission` (`uid`, `add_btn`, `edit_btn`, `delete_btn`, `process`, `control`, `recommend`, `rlist`, `rassess`, `rregister`, `top`, `kpi`, `kri`, `perform`, `incident`, `action`, `objective`, `report`, `card`, `rating`) VALUES
(1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(2, 1, 1, 0, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(3, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(4, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(5, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(27, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(33, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(4, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `pkpi`
--

CREATE TABLE `pkpi` (
  `id` int(11) NOT NULL,
  `kpi` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pkra`
--

CREATE TABLE `pkra` (
  `id` int(11) NOT NULL,
  `owner` int(11) NOT NULL,
  `kra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `bsc_pillar` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `process`
--

CREATE TABLE `process` (
  `process_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `process_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `details` varchar(2000) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `process`
--

INSERT INTO `process` (`process_id`, `dept_id`, `process_name`, `details`) VALUES
(1, 1, 'Project Design & Implementation', 'Project design & Implementation\r\n'),
(2, 1, 'Research and Development', 'Research and Development\r\n\r\n'),
(3, 1, 'Capacity Building and Training on IoT and Related Technologies', 'Capacity Building and Training on IoT and Related Technologies\r\n'),
(4, 1, 'Events Management', 'Events Management\r\n'),
(5, 1, 'Equipment Acquisition', 'Equipment Acquisition\r\n'),
(6, 1, 'Partnerships and Industrial collaboration', 'Partnerships and Industrial collaboration\r\n'),
(7, 2, 'Placement service', 'Placement service\r\n'),
(8, 2, 'Career events/activities ', 'Career events/activities \r\n'),
(9, 2, 'Human resource capacity', 'Human resource capacity\r\n'),
(10, 2, 'Feedback collection from stakeholders', 'Feedback collection from stakeholders\r\n'),
(11, 3, 'Exam Administration', 'Exam Administration\r\n'),
(12, 3, 'Filing, record keeping and stores management', 'Filing, record keeping and stores management\r\n'),
(13, 3, 'Stakeholder Management', 'Stakeholder Management\r\n'),
(14, 3, 'Compliance', 'Compliance\r\n'),
(15, 3, 'Timetabling and allocation of Examination Venues. ', 'Timetabling and allocation of Examination Venues. \r\n'),
(16, 3, 'Staff Management', 'Staff Management\r\n'),
(17, 4, 'Payment process', 'Payment process\r\n'),
(18, 4, 'Receivables Management', 'Receivables Management\r\n'),
(19, 4, 'Cash Management', 'Cash Management\r\n'),
(20, 4, 'Treasury Management', 'Treasury Management\r\n'),
(21, 4, 'Budgeting ', 'Budgeting \r\n'),
(22, 4, 'Internal Financial Controls and Compliance', 'Internal Financial Controls and Compliance\r\n'),
(23, 4, 'Asset Management', 'Asset Management\r\n'),
(24, 5, 'Hygiene Management', 'Hygiene Management\r\n'),
(25, 5, 'Occupational Health & Safety', 'Occupational Health & Safety\r\n'),
(26, 5, 'Laundry Management', 'Laundry Management\r\n'),
(27, 5, 'Inventory management - Cleaning agents, materials & equipments', 'Inventory management - Cleaning agents, materials & equipments\r\n'),
(28, 5, 'Compliance', 'Compliance\r\n'),
(29, 6, 'Information and Data Management', 'Information and Data Management\r\n'),
(30, 6, 'Talent Acquisition and Retention', 'Talent Acquisition and Retention\r\n'),
(31, 6, 'IT Governance', 'IT Governance\r\n'),
(33, 6, 'IT Service and Infrastructure Management (Network, Systems and Storage)', 'IT Service and Infrastructure Management (Network, Systems and Storage)\r\n'),
(34, 6, 'Vendor and Third-party Management', 'Vendor and Third-party Management\r\n'),
(35, 6, 'Asset Management ', 'Asset Management (Laptops, PCs etc)\r\n'),
(36, 6, 'Business Continuity Management and Disaster Recovery Planning', 'Business Continuity Management and Disaster Recovery Planning\r\n'),
(37, 6, 'Compliance', 'Compliance\r\n'),
(38, 6, 'Technology Innovation and Experimentation', 'Technology Innovation and Experimentation\r\n'),
(39, 7, 'Leave Management', 'Leave Management\r\n'),
(40, 7, 'Performance Management ', 'Performance Management \r\n'),
(41, 7, 'Talent Management', 'Talent Management\r\n'),
(42, 7, 'Litigation Management', 'Litigation Management\r\n'),
(43, 7, 'Records Management', 'Records Management\r\n'),
(44, 7, 'Employee Succession Management', 'Employee Succession Management\r\n'),
(45, 7, 'Data Protection', 'Data Protection\r\n'),
(46, 7, 'Learning and Development', 'Learning and Development\r\n'),
(47, 7, 'Staff Experience', 'Staff Experience\r\n'),
(48, 7, 'Compliance Management', 'Compliance Management\r\n'),
(49, 8, 'Admission', 'Admission\r\n'),
(50, 8, 'Teaching', 'Teaching\r\n'),
(51, 8, 'Student Retention and Progression', 'Student Retention and Progression\r\n'),
(52, 8, 'Research Management', 'Research Management\r\n'),
(53, 8, 'Graduate Employability', 'Graduate Employability\r\n'),
(54, 8, 'Teaching and Learning', 'Teaching and Learning\r\n'),
(55, 8, 'Laboratory Management', 'Laboratory Management\r\n'),
(56, 8, 'Course Accreditation', 'Course Accreditation\r\n'),
(57, 8, 'Debt Management', 'Debt Management\r\n'),
(58, 9, 'Student onboarding ', 'Student onboarding \r\n'),
(59, 9, 'Admission', 'Admission\r\n'),
(60, 9, 'Research Management', 'Research Management\r\n'),
(61, 9, 'Examination', 'Examination\r\n'),
(62, 9, 'Debt Management', 'Debt Management\r\n'),
(63, 9, 'Teaching & Learning', 'Teaching & Learning\r\n'),
(64, 9, 'Graduation ', 'Graduation \r\n'),
(65, 9, 'Staff Attrition', 'Staff Attrition\r\n'),
(66, 11, 'Repairs and maintenance M/Vehicles', 'Repairs and maintenance M/Vehicles\r\n'),
(68, 11, 'Warehouse management', 'Warehouse management\r\n'),
(69, 11, 'Emergency and Fire Management', 'Emergency and Fire Management\r\n'),
(70, 11, 'Health and Safety', 'Health and Safety\r\n'),
(71, 11, 'Energy supply', 'Energy  supply\r\n'),
(72, 11, 'Occupational Safety', 'Occupational Safety\r\n'),
(73, 11, 'Transport management', 'Transport management\r\n'),
(74, 11, 'Compliance/Environment', 'Compliance/Environment\r\n'),
(75, 12, 'Marketing', 'Marketing\r\n'),
(76, 12, 'Data Management', 'Data Management\r\n'),
(77, 12, 'Applicant conversion', 'Applicant conversion\r\n'),
(78, 12, 'Student onboarding', 'Student onboarding\r\n'),
(79, 12, 'Customer management', 'Customer management\r\n'),
(80, 12, 'Admission Compliance and Credential Checks', 'Admission Compliance and Credential Checks\r\n'),
(81, 12, 'Admission', 'Admission\r\n'),
(82, 13, 'Events Management ', 'Events Management \r\n'),
(83, 13, 'Alumni Mentoring Program', 'Alumni Mentoring Program\r\n'),
(84, 13, 'Alumni Database Management', 'Alumni Database Management\r\n'),
(85, 13, 'Alumni Fundraising and Donor Relations', 'Alumni Fundraising and Donor Relations\r\n'),
(86, 13, 'Alumni Financial Planning, Budgeting and Expenditure Management', 'Alumni Financial Planning, Budgeting and Expenditure Management\r\n'),
(87, 13, 'Alumni Data Protection and Compliance Management', 'Alumni Data Protection and Compliance Management\r\n'),
(88, 14, 'Social Media Account Management', 'Social Media Account Management\r\n'),
(89, 14, 'Media Relations Management', 'Media Relations Management\r\n'),
(90, 14, 'University Events and Protocol Management', 'University Events and Protocol Management\r\n'),
(91, 14, 'Production equipment management', 'Production equipment management\r\n'),
(92, 14, 'Data Protection', 'Data Protection\r\n'),
(93, 14, 'Content Creation and Media Rights Management', 'Content Creation and Media Rights Management\r\n'),
(94, 15, 'Sports Management', 'Sports Management\r\n'),
(95, 15, 'Elections for clubs and student council', 'Elections for clubs and student council\r\n'),
(96, 15, 'International students management', 'International students management\r\n'),
(97, 15, 'Clubs and student council events management', 'Clubs and student council events management\r\n'),
(98, 16, 'Exam Administration', 'Exam Administration\r\n'),
(99, 16, 'Filing, record keeping and stores management', 'Filing, record keeping and stores management\r\n'),
(100, 16, 'Stakeholder Management', 'Stakeholder Management\r\n'),
(101, 16, 'Compliance', 'Compliance\r\n'),
(102, 16, 'Timetabling and allocation of Examination Venues. ', 'Timetabling and allocation of Examination Venues. \r\n'),
(103, 16, 'Staff Management', 'Staff Management\r\n'),
(104, 17, 'Enrolment  (students admission process)', 'Enrolment  (students admission process)\r\n'),
(105, 17, 'Induction', 'Induction\r\n'),
(106, 17, 'Mentor-Mentee Engagement', 'Mentor-Mentee Engagement\r\n'),
(107, 17, 'Performance Management', 'Performance Management\r\n'),
(108, 17, 'Data Privacy', 'Data Privacy\r\n'),
(109, 18, 'Research Governance', 'Research Governance\r\n'),
(110, 18, 'Research Dissemination', 'Research Dissemination\r\n'),
(111, 18, 'Research/Grant Management', 'Research/Grant Management\r\n'),
(112, 18, 'Project Sustainability and Post-Grant Continuity Management', 'Project Sustainability and Post-Grant Continuity Management\r\n'),
(113, 18, 'Research Productivity and Output Management', 'Research Productivity and Output Management\r\n'),
(114, 18, 'Research Integrity and Ethics Management', 'Research Integrity and Ethics Management\r\n'),
(115, 19, 'Procurement and Contract Management', 'Procurement and Contract Management\r\n'),
(116, 19, 'Strategic Planning based on External Environment', 'Strategic Planning based on External Environment\r\n'),
(117, 19, 'Supply Chain Management', 'Supply Chain Management\r\n'),
(118, 19, 'External Relations', 'External Relations\r\n'),
(119, 19, 'IT Management', 'IT Management\r\n'),
(120, 20, 'Training and Stakeholder Management', 'Training and Stakeholder Management\r\n'),
(121, 20, 'Occupational Health & Safety', 'Occupational Health & Safety\r\n'),
(122, 20, 'Grant & Funding Management', 'Grant & Funding Management\r\n'),
(123, 20, 'Industry Partnerships & Contracts', 'Industry Partnerships & Contracts\r\n'),
(124, 21, 'Admission', 'Admission\r\n'),
(125, 21, 'Graduate Employability', 'Graduate Employability\r\n'),
(126, 21, 'Student Retention and Progression', 'Student Retention and Progression\r\n'),
(127, 21, 'Debt Management', 'Debt Management\r\n'),
(128, 22, 'Admission', 'Admission\r\n'),
(129, 22, 'Student Onboarding', 'Student Onboarding\r\n'),
(130, 22, 'Debt Management ', 'Debt Management \r\n'),
(131, 22, 'Budget Management ', 'Budget Management\r\n'),
(132, 22, 'Administration of Examinations', 'Administration of Examinations'),
(133, 22, 'Research Management', 'Research Management\r\n'),
(134, 22, 'Data Privacy ', 'Data Privacy'),
(135, 23, 'Identification Process', 'Identification Process\r\n'),
(137, 23, 'Qualification', 'Qualification\r\n'),
(138, 23, 'Cultivation', 'Cultivation\r\n'),
(139, 23, 'Solicitation', 'Solicitation\r\n'),
(140, 23, 'Stewardship', 'Stewardship\r\n'),
(141, 23, 'Talent Management', 'Talent Management\r\n'),
(142, 23, 'Compliance', 'Compliance\r\n'),
(143, 23, 'External Environment', 'External Environment\r\n'),
(144, 23, 'Technology Management', 'Technology Management\r\n'),
(145, 24, 'Service Delivery and Turnaround Time Management', 'Service Delivery and Turnaround Time Management\r\n'),
(146, 24, 'Occupational Health and Safety', 'Occupational Health and Safety'),
(147, 24, 'Medication Administration Process', 'Medication Administration Process\r\n'),
(148, 24, 'Data Privacy Management', 'Data Privacy Management\r\n'),
(149, 24, 'Pharmacy Management', 'Pharmacy Management\r\n'),
(150, 24, 'Inventory Management', 'Inventory Management\r\n'),
(151, 24, 'Emergency Response', 'Emergency Response\r\n'),
(152, 24, 'Compliance Management', 'Compliance Management\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `entityid` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `riskid` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pubaccount`
--

CREATE TABLE `pubaccount` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `recommend`
--

CREATE TABLE `recommend` (
  `id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `process_id` int(11) NOT NULL,
  `risk_id` int(11) NOT NULL,
  `mrc` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `armc` varchar(2000) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `action` int(11) NOT NULL,
  `status` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `timeline` date NOT NULL,
  `uid` int(11) DEFAULT NULL,
  `approval` int(11) DEFAULT 1,
  `uid_approve` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `approved_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewer`
--

CREATE TABLE `reviewer` (
  `id` int(11) NOT NULL,
  `fname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `risk`
--

CREATE TABLE `risk` (
  `risk_id` int(11) NOT NULL,
  `risk_name` varchar(300) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rcat` int(11) NOT NULL,
  `dept` int(11) NOT NULL,
  `process` int(11) NOT NULL,
  `cause` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `consequence` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `assessment` int(11) NOT NULL DEFAULT 0,
  `reviewer` int(11) DEFAULT NULL,
  `rdate` date DEFAULT NULL,
  `nominee` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `userid` int(11) DEFAULT NULL,
  `approval` int(11) NOT NULL DEFAULT 1,
  `uid_approve` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `approved_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk`
--

INSERT INTO `risk` (`risk_id`, `risk_name`, `rcat`, `dept`, `process`, `cause`, `consequence`, `assessment`, `reviewer`, `rdate`, `nominee`, `userid`, `approval`, `uid_approve`, `created_at`, `approved_at`, `updated_at`) VALUES
(1, 'Project running beyond the assigned budget', 1, 1, 1, '•Poor cost estimation and unrealistic budgeting at project initiation.\r\n•Scope creep due to unplanned features or changes.\r\n•Inflation and price fluctuations of IoT equipment and software.\r\n', '•Project stalls or incomplete deliverables due to lack of funds.\r\n•Reputational damage with stakeholders, funders, and partners.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 12:38:28', '2025-10-15 13:33:40', '2025-10-15 12:38:28'),
(2, 'Project running beyond the assigned timeline', 2, 1, 1, 'Scope creep due to unclear requirements or frequent changes\r\nWeak monitoring, evaluation, and reporting mechanisms\r\nPoor project planning and unrealistic timelines\"\r\n', 'Increased project costs and budget overruns.\r\nDelayed project delivery.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 13:38:25', '2025-10-15 13:33:45', '2025-10-15 13:38:25'),
(3, 'Delayed deliverables in a collaborative research ', 2, 1, 2, 'Delayed deliverables in a collaborative research due to delayed funds from the partners/delay on action from the partners.\r\n', 'This would lead to long project timeline which would affect the budget\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 13:39:33', '2025-10-15 13:33:52', '2025-10-15 13:39:33'),
(4, 'Theft/loss of materials', 2, 1, 2, 'The risk of loss of components due to inaccountabilty of equipment/students taking equipment out of the lab without permission. \r\n', 'This would affect project delivery\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 13:41:10', '2025-10-15 13:33:57', '2025-10-15 13:41:10'),
(5, 'Lack of a quorum to warrant training/lack of sufficient marketing', 1, 1, 3, 'Lack of numbers due to  poor marketing ,high training costs, bad timings, lack of confidence, competition,poor market research\r\n', 'Low enrollment leading to underutilized programs, reduced revenue, and weakened competitiveness.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 13:43:15', '2025-10-15 13:34:03', '2025-10-15 13:43:15'),
(6, 'Inadequate preparation of events', 2, 1, 4, '•Poor planning and lack of clear event objectives\r\n•Limited budget allocation or delayed fund release\r\n•Shortage of skilled staff to manage logistics and technical setup\"\r\n', '•Poor attendance and low stakeholder engagement\r\n•Lost opportunities for partnerships, sponsorships, or funding.\r\n•Reduced impact of the IoT Office in showcasing innovation and research\"\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 13:45:07', '2025-10-15 13:34:08', '2025-10-15 13:45:07'),
(7, 'Delayed Acquisition of Equipment.', 2, 1, 5, '•Lengthy procurement procedures and bureaucratic approvals.\r\n•Budget constraints or delayed release of funds.\r\n•Poor planning and unclear specifications of required equipment.\r\n', 'This would lead to bad customer experience.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 13:46:37', '2025-10-15 13:34:13', '2025-10-15 13:46:37'),
(8, 'Prolonged Negotiation Processes', 3, 1, 6, '•Multiple stakeholders with divergent interests\r\n•Conflicts of interest among parties.\r\n•Poor communication or unclear expectations.\r\n', '•Delays in project implementation and delivery\r\n•Missed opportunities due to slow decision-making\r\n•Increased administrative and operational costs\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 14:57:37', '2025-10-15 13:58:33', '2025-10-15 14:57:37'),
(9, 'Failure to meet students expections ', 3, 2, 7, 'Rapidly changing student needs – expectations shifting due to new technologies, job market demands, or peer university benchmarks.\r\n', ' Student dissatisfaction leading to low retention and negative reputation.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 22:43:46', '2025-10-15 22:04:37', '2025-10-15 22:43:46'),
(10, 'Lack of competitiveness of Strathmore graduates', 3, 2, 7, 'This is due to skill gaps, high competition  and huge demand for soft skills. The risk can also be caused by failure to reach out to all students to train on soft skills due to student apathy and crowded timetable.\r\n', 'Graduates struggle in job market , reduced attractiveness of University.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 22:44:45', '2025-10-15 22:04:44', '2025-10-15 22:44:45'),
(11, 'Unprincipled/ Fake Employers', 3, 2, 7, ' This may be due to failure to conduct due diligence on employers.\r\n', 'This would adversely affect the reputation of the university. Exploitation or fraud risks for students.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 22:46:25', '2025-10-15 22:04:53', '2025-10-15 22:46:25'),
(12, 'Low student participation in career events and other activities. ', 3, 2, 8, 'The is  due to lack of clear understanding of what Career Development Services is in the University, lack of synchronization of classes, CATs and career activities, and failure to create programs that enables students to access CDS at school level.\r\n', 'Students miss networking/career readiness opportunities.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 22:47:34', '2025-10-15 22:05:01', '2025-10-15 22:47:34'),
(13, 'Inadequate human resource.', 3, 2, 9, 'The risk of lack of adequate human resource due to lack of staff incentives  to keep them on the job and limited staff to serve the entire university. This lowers efficiency.\r\n', 'Strain on staff, reduced quality of service, event delays.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 22:48:36', '2025-10-15 22:05:11', '2025-10-15 22:48:36'),
(14, 'Inadequate collection of feedback from stakeholders.', 2, 2, 10, ' The risk of not collecting, processing and distributing feedback from stakeholders to inform curriculum, policies and programs. \r\n', 'Poor service improvement, blind spots in decision-making.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 22:50:23', '2025-10-15 22:05:19', '2025-10-15 22:50:23'),
(15, 'Compromised Integrity of examinations/Leakage of exams', 2, 3, 11, '•Inadequate exam security facilities.\r\n•Insider collusion.\r\n•Improper storage of exams.\r\n•Complacency by exams stakeholder.', '•Loss of integrity\r\n•Reputational damage\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 23:54:09', '2025-10-15 23:43:22', '2025-10-15 23:54:09'),
(16, 'Exam malpractice (cheating)', 2, 3, 11, '•Inadequate invigilation\r\n•Use of tech gadgets\r\n•Collusion\r\n•Poor seating arrangement\r\n', '•Integrity loss\r\n•Student suspensions\r\n•Reputational damage.\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 23:55:14', '2025-10-15 23:43:29', '2025-10-15 23:55:14'),
(17, 'Delays in administering CATs and Exams', 2, 3, 11, '•Due to late printing, late collection, late submissions by faculty, overlapping timetables, overlapping semesters,  unavailability of invigilators and venues\r\n', '•Student frustration\r\n•Increased risk of malpractice (last-minute confusion)\r\n•Disruption of academic calendar', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 23:56:38', '2025-10-15 23:43:38', '2025-10-15 23:56:38'),
(18, 'Late Release of Results', 2, 3, 11, '•System breakdown\r\n•Data entry errors\r\n', 'Student frustration\r\n', 1, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 23:57:45', '2025-10-15 23:43:46', '2025-10-15 23:57:45'),
(19, 'Filing, record keeping and stores management', 2, 3, 12, 'Poor Record Management/Loss of data/information\r\n', 'Poor handling, inadequate indexing and storage, uncontrolled access,\r\n', 0, 1, '2025-10-15', 'super-admin', 1, 2, 2, '2025-10-15 23:58:52', '2025-10-15 23:43:52', '2025-10-15 23:58:52'),
(20, 'Poor Record Management/Loss of data/information', 2, 3, 13, 'Poor handling, inadequate indexing and storage, uncontrolled access,\r\n', 'May lead to litigation and reputation damage\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 00:01:50', '2025-10-15 23:43:58', '2025-10-16 00:01:50'),
(21, 'Non-Compliance with Academic Regulations', 5, 3, 14, '•Ignorance of policies\r\n•Weak training\r\n•Poor communication and Weak governance\r\n', 'Accreditation risk\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 00:03:07', '2025-10-15 23:44:05', '2025-10-16 00:03:07'),
(22, 'Examination Venue Risks/Insufficient exams venues to administer exams', 2, 3, 15, '•Increased student population\r\n•Inadequate planning\r\n', '•Student complaints\r\n•Reputational damage.\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 00:04:58', '2025-10-15 23:44:14', '2025-10-16 00:04:58'),
(23, 'Staff Shortages', 2, 3, 16, '•Resignations\r\n•Limited recruitment\r\n', '•Increased complaints\r\n•Delays in printing CAT/Exam material\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 00:07:51', '2025-10-15 23:44:24', '2025-10-16 00:07:51'),
(24, 'Inadequate Stakeholder Communication', 2, 3, 13, '•Weak/inadequate feedback systems\r\n•Late notices\r\n•IT failures', 'Affects customer experience\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 01:44:12', '2025-10-16 00:45:18', '2025-10-16 01:44:12'),
(25, 'Delays or erroneous payment processing ', 2, 4, 17, '• Incomplete or inaccurate vendor/student bank detailslack of proper documenting, poor cashflow management, delays in approvals, inaccurate information from depts, human error, system failures, inaccurate supplier details, erroneous approvals.\r\n\r\n', '• Supplier/vendor dissatisfaction and strained relationships\r\n•Penalties for late payments (e.g., statutory payments like PAYE, NSSF, NHIF)\r\n•Duplicate or fraudulent payments leading to financial loss\r\n•Reputational damage with staff, students, or donors\r\n•Operational disruptions due to unpaid services or contracts\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:13:30', '2025-10-16 08:08:51', '2025-10-16 02:13:30'),
(26, 'Credit risk - delays in receiving payments, provisioning and bad debt write offs (Students and Corporates)', 1, 4, 18, '•Delayed invoicing or fee communication\r\n•Inadequate credit evaluation before granting payment plans\r\n•Ineffective follow-up and enforcement mechanisms\r\n•Poor tracking of payment commitments (e.g., scholarship or corporate agreements)\r\n', '•Reduced cash inflows leading to liquidity constraints\r\n•Increased provision for doubtful debts reducing net income\r\n•Escalation of bad debt write-offs impacting financial statements\r\n•Budget shortfalls\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:14:54', '2025-10-16 08:08:45', '2025-10-16 02:14:54'),
(27, 'County Debt risk', 1, 4, 18, '•Delayed/lack of disbursement of funds from the  counties\r\n•Political interference or change in county leadership\r\n', '•Shortfall in anticipated cash inflows, thereby limiting University capacity to pursue strategic initiatives\r\n•Debt Collection Costs and Legal Expenses\r\n•Increase in provisions for doubtful debts and bad debt write-offs\r\n•Reputational risk in case of conflict with county governments\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:16:16', '2025-10-16 08:08:39', '2025-10-16 02:16:16'),
(28, 'Poor cash management/loss of cash', 1, 4, 19, '•Weak internal controls over cash handling (e.g., cashiering, petty cash\r\n•Inadequate segregation of duties and approval workflows\r\n•Delayed banking of received cash or cheques\r\n•Poor forecasting and liquidity planning\r\n•Fraud or theft by staff or third parties\r\n•Unmonitored cash collections during events\r\n•Lack of regular cash reconciliations\r\n', '•Liquidity shortfalls affecting daily operations and obligations\r\n•Direct financial loss\r\n•Audit qualifications\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:17:44', '2025-10-16 08:08:34', '2025-10-16 02:17:44'),
(29, 'Liquidity risk (The risk that the university will be unable to meet its short-term financial obligations when they fall due)', 1, 4, 20, '•Delayed receipt of funding (e.g., government capitation, donor grants, tuition fees)\r\n•Over-reliance on a limited number of revenue streams (e.g., student tuition)\r\n•Poor cash flow forecasting and budget planning\r\n•High fixed operational costs with limited flexibility\r\n•Excessive accounts receivable (e.g., unpaid student or sponsor debts), •Misalignment of income and expenditure cycles (e.g., income concentrated at semester start, but expenses spread out)\r\n•Lack of emergency reserves or overdraft facilities\r\n•Unexpected large expenditures (e.g., repairs, legal settlements)\r\n', '•Inability to meet obligations on time, •Disruption of academic operations and services\r\n•Increased borrowing costs or penalties due to default\r\n•Reduced ability to invest in strategic projects or infrastructure.\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:18:44', '2025-10-16 08:08:26', '2025-10-16 02:18:44'),
(30, 'Investment Risk (The risk of financial loss or underperformance arising from university investments, including endowment funds, capital projects, or partnerships)', 1, 4, 20, '•Poor investment decisions due to lack of expertise or due diligence\r\n•Market volatility (interest rates, inflation, economic downturns)\r\n•Inadequate diversification of investment portfolio\r\n•Misalignment of investments with university risk appetite or liquidity needs\r\n•Absence of an investment policy or governance structure\r\n', '•Financial losses reducing available funds for operations\r\n•Erosion of endowment or reserve funds, •Reputational damage among donors, alumni, and the public\r\n•Reduced future income from interest, dividends, or capital gains\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:19:55', '2025-10-16 08:08:20', '2025-10-16 02:19:55'),
(31, 'Market Risk (The risk of financial loss or volatility due to changes in external market conditions)', 4, 4, 20, '•Fluctuations in interest rates affecting investment returns or borrowing costs, •Currency exchange rate volatility (especially for international transactions, scholarships, or imports),\r\n•Inflation increasing the cost of goods, services, and capital projects\r\n•Changes in the demand for academic programs due to market trends or competitor behavior\r\n•Global or national economic downturns\r\n', '•Increased operational costs (e.g., utility bills, materials, outsourced services)\r\n•Unfavorable foreign exchange losses on international payments (e.g., software licenses, research equipment)\r\n•Budget deficits or reallocation of funds from strategic priorities\r\n•Delays in capital projects due to cost escalation\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:20:54', '2025-10-16 08:08:15', '2025-10-16 02:20:54'),
(32, 'Budget overruns', 2, 4, 21, '•Inaccurate cost estimates or unrealistic budgeting\r\n•Unforeseen expenses (e.g., emergency repairs, inflation)\r\n•Poor budget monitoring and control mechanisms\r\n•Ineffective procurement or project management\r\n•Scope creep in projects or programs\r\n', '•Financial shortfalls requiring emergency funding\r\n•Disruption of planned activities or projects, •Reallocation of funds from other strategic priorities', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:21:50', '2025-10-16 08:08:10', '2025-10-16 02:21:50'),
(33, 'Fraud Risk', 2, 4, 22, '• Weak internal controls (e.g., lack of segregation of duties or oversight)\r\n• Inadequate fraud detection systems and audit mechanisms\r\n• Collusion between employees and external parties (e.g., suppliers, contractors)\r\n• Manual financial processes prone to manipulation\r\n• Inadequate ethics training and weak institutional culture\r\n• Poor enforcement of disciplinary or anti-fraud policies', ' Direct financial loss and resource misappropriation\r\n• Reputational damage, especially if fraud becomes public\r\n• Legal consequences and regulatory penalties, • Loss of stakeholder confidence (donors, government, partners)', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:24:35', '2025-10-16 08:08:05', '2025-10-16 02:24:35'),
(34, 'Non compliance to internal policies, laws and regulatory guidelines.', 5, 4, 22, '•Inadequate awareness or training on policies and regulations\r\n•Lack of updated policies aligned with changing laws and standards\r\n•Failure to implement internal audit and compliance monitoring systems\r\n•Poor recordkeeping or documentation, Intentional disregard for rules (e.g., fraudulent procurement)\r\n•Delayed response to changes in regulatory requirements (e.g., tax, labor laws, Higher Education regulations)\r\n•Weak compliance enforcement and accountability mechanisms\r\n•Decentralized or inconsistent policy application across departments', '•Regulatory penalties, fines, or sanctions from authorities (e.g., KRA, NACOSTI, MoE)\r\n•Loss of eligibility for grants, scholarships, or research funding\r\n•Audit qualifications and increased scrutiny from oversight bodies\r\n•Legal liability and potential lawsuits, Reputational damage with stakeholders (students, donors, government)\r\n•Internal inefficiencies and lack of standardization', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:25:48', '2025-10-16 08:08:00', '2025-10-16 02:25:48'),
(35, 'Loss of university assets (The risk of theft, damage, misplacement, or misappropriation of l assets owned by the university).', 2, 4, 23, '•Poor asset management systems or lack of asset registers,\r\n•Inadequate physical security (e.g., lack of CCTV, guards, locks), \r\n•Failure to tag, track, or regularly verify university assets,\r\n •Lack of accountability in asset assignment or usage,\r\n• Internal theft or fraud by staff or students, \r\n•Natural disasters, fire, or vandalism', '•Direct financial loss from theft or damage,\r\n• Disruption of academic and administrative services (e.g., loss of ICT or lab equipment),\r\n• Increased costs for replacements or emergency procurement, \r\n•Audit queries or adverse audit opinions, \r\n•Reduced institutional efficiency and credibility', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 02:28:08', '2025-10-16 08:07:53', '2025-10-16 02:28:08'),
(36, 'Poor Hygiene Standards/Cross contamination', 2, 5, 24, '•Use of the same cleaning tools (mops, cloths) across different areas (toilets, kitchens, lecture halls)\r\n•Lack of color-coded cleaning equipment and clear protocols\r\n•Inadequate training of housekeeping staff on hygiene practices', '•Spread of infections and communicable diseases on campus\r\n•Reputational damage\r\n•Potential legal and compliance liabilities under public health regulations', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 09:39:43', '2025-10-16 12:29:08', '2025-10-16 09:39:43'),
(37, 'Pest Infestation', 2, 5, 24, '•Poor waste management\r\n•Poor Food storage issues\r\n•Infrequent pest control\r\n', '•Spread of infections and communicable diseases on campus\r\n•Reputational damage\r\n•Potential legal and compliance liabilities under public health regulations', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 09:40:42', '2025-10-16 12:29:01', '2025-10-16 09:40:42'),
(38, 'Ergonomic Hazards ', 2, 5, 25, 'Musculoskeletal disorders as a result of heavy lifting, bending, repetitive movements\r\n', '•May lead to Musculoskeletal disorders.\r\n•May lead to increased worker compensation cost/health care', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 09:41:32', '2025-10-16 12:28:56', '2025-10-16 09:41:32'),
(39, 'Risk of infection / Allergen and respiratory issues', 2, 5, 25, 'Risk of infection from Dust, handling of waste or dirty linen.\r\n', '•It may lead to infection of the team members.\r\n•May lead to increased worker compensation cost/health care, may lead to decreased work productivity.', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 09:42:45', '2025-10-16 12:28:51', '2025-10-16 09:42:45'),
(40, 'Damage to linen ', 2, 5, 26, '•Use of harsh detergents or incorrect washing chemicals\r\n•Overloading or poor maintenance of laundry machine\r\n•Inadequate staff training on proper laundry handling', '•Increased replacement costs and budget overruns\r\n•Disruptions in service delivery (insufficient clean linen stock)', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 09:43:48', '2025-10-16 12:28:46', '2025-10-16 09:43:48'),
(41, 'Delays in turn around time for laundry', 2, 5, 26, '•Insufficient laundry machines or frequent equipment breakdowns\r\n•High volume of linen during peak periods\r\n•Poor scheduling and workflow management', '•Customer dissatisfaction and complaints\r\n•Service disruption for critical units (health center, catering)\r\n•Increased operational costs from overtime or emergency outsourcing.', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 09:44:35', '2025-10-16 12:28:39', '2025-10-16 09:44:35'),
(42, 'Stock Variances', 2, 5, 27, 'Poor stock management due to poor planning, delays by supplier, unavailability of the raw materials in the market, poor recording keeping,misposting\r\n', 'May lead to Cost implications, poor client experience and delays in H/K operations. ', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 09:45:25', '2025-10-16 12:28:35', '2025-10-16 09:45:25'),
(43, 'Loss of laundry items', 2, 5, 27, '•Poor tracking systems (manual registers, lack of barcoding/tagging)\r\n•Mixing of laundry from different departments without clear labeling\r\n•Insider theft or mishandling by staff', '•Increased costs of replacing lost items\r\n•Client dissatisfaction and complaints\r\n•Reputational damage for poor service delivery', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 09:47:52', '2025-10-16 12:28:26', '2025-10-16 09:47:52'),
(44, 'Pilferage', 2, 5, 27, '•Poor inventory control\r\n•Insider theft\r\n•Lack of monitoring', '•Budget overruns\r\n•Service disruption', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 13:16:09', '2025-10-16 12:28:20', '2025-10-16 13:16:09'),
(45, 'Non compliance to internal policies, regulatory requirements and laws. ', 5, 5, 28, '•Lack of awareness or training among housekeeping staff on policies and legal requirements\r\n•Frequent changes in health, safety, and environmental regulations\r\n•Inadequate documentation and record-keeping', '•Legal liability for accidents, unsafe practices, or environmental breaches\r\n•Fines, penalties, or sanctions from regulatory agencies\r\n•Reputational damage to the university', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 13:17:18', '2025-10-16 12:28:15', '2025-10-16 13:17:18'),
(46, 'Failure to safeguard information and data by way of cyber attacks, unauthorized access and inability recover data. ', 2, 6, 29, 'The risk of failing to safeguard information and data due to:\r\n•lack of data classification\r\n•unauthorized access\r\n• errors during updating of data\r\n•inadequate disaster recovery procedures •inadequate physical access control, •unmonitored privileged users,\r\n•disgruntled employees\r\n•unintentional information leak and hacking of systems and websites.\r\n', 'ICT Services could lead to busines disruption,  reputational loss and  financial loss due to legal and financial costs attributed to restoration of the affected services.', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 14:19:19', '2025-10-16 14:20:22', '2025-10-16 14:19:19'),
(47, 'High turnover of IT staff and loss of key IT personnel.', 3, 6, 30, 'The risk of high turnover due to inability to attract and retain key talent caused by unattractive remuneration package, career growth prospects, and succession planning for key ICTS job roles.', ' Inability to address IT issues due to high turnover is likely to occur resulting to service interruptions. ', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 14:21:11', '2025-10-16 14:20:16', '2025-10-16 14:21:11'),
(48, 'Inadequate IT Governance Structure and Policies (The risk that weak or absent IT governance frameworks and policies will lead to poor decision-making, misalignment with institutional goals, non-compliance, and inefficient use of ICT resources)', 3, 6, 31, '•Lack of defined ICT governance roles and responsibilities\r\n•Absence of an institutional ICT strategy aligned with university goals\r\n•Infrequent or ineffective ICT steering committees or governance bodies\r\n•Failure to engage senior leadership in ICT decision-making\r\n•Poor communication between ICT and user departments\r\n•No formal policy framework for ICT usage, security, procurement, and data management\r\n•Rapid technological changes not matched by policy updates', '•Misaligned ICT projects and investments with academic and strategic objectives\r\n•Wastage of resources through redundant or conflicting ICT systems\r\n•Delays in decision-making on critical ICT issues\r\n•Increased exposure to cyber, operational, and compliance risks\r\n•Fragmented ICT infrastructure across departments\r\n•Reduced user satisfaction and system adoption', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 14:28:54', '2025-10-16 14:20:11', '2025-10-16 14:28:54'),
(49, 'System outages/Business disruption ', 6, 6, 33, '• Server failures or hardware breakdowns\r\n• Power outages or unstable electricity supply, Cyberattacks (e.g., denial of service, ransomware)\r\n• Software bugs or failed system upgrades\r\n• Poor system configuration or integration issues,\r\n• Inadequate IT infrastructure capacity (e.g., bandwidth, storage)\r\n• Absence of load balancing or failover mechanisms, • Infrequent system maintenance or patching\r\n• Lack of disaster recovery planning or testing', 'Disruption of core services (e.g., LMS, ERP, exams, admissions, email, payroll), Missed academic deadlines (e.g., registration, exam results, class schedules)\r\n• Financial delays (e.g., payment processing, student billing)\r\n• Increased user frustration and reputational damage', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 14:31:55', '2025-10-16 14:20:04', '2025-10-16 14:31:55'),
(50, 'Technology vendor and third-party risk', 2, 6, 34, 'Third party risks arising due to lack of due diligence, weak or a lack of proper contracting, inadequate SLAs and monitoring of vendors on service/product delivery requirements.', 'This may result in IT Service and Project failure and possible financial loss.', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 14:35:28', '2025-10-16 14:19:59', '2025-10-16 14:35:28'),
(51, 'Theft of or damage to physical  IT assets.', 2, 6, 35, '• Poor physical security (e.g., lack of CCTV, guards, access controls)\r\n• Inadequate asset tracking and tagging systems\r\n• Weak asset handover and accountability procedures', '• Financial loss due to asset replacement costs\r\n• Data loss or unauthorized data access if devices are unencrypted\r\n• Reduced operational efficiency and productivity for staff/students', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 14:37:15', '2025-10-16 14:19:49', '2025-10-16 14:37:15'),
(52, 'Information security breaches/Cyberattacks.', 2, 6, 36, '• Lack of strong cybersecurity protocols (e.g., encryption, firewalls, multi-factor authentication)\r\n• Absence of regular data backups and disaster recovery testing\r\n• Unpatched software vulnerabilities or outdated systems\r\n• Weak user passwords and poor credential management\r\n• Phishing, malware, or ransomware attacks\r\n• Inadequate access controls and role-based permissions\r\n• Lack of user training and security awareness', '• Exposure or theft of sensitive student, staff, or research data\r\n• Legal penalties for breach of data protection laws\r\n• Operational disruption due to system lockdowns or corrupted files\r\n• Academic integrity concerns (e.g., leaked exam materials or transcripts)', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 14:38:51', '2025-10-16 14:19:43', '2025-10-16 14:38:51'),
(53, 'Non-Compliance with Regulatory bodies and Relevant Laws', 5, 6, 37, '•Lack of awareness or understanding of applicable laws and regulations\r\n•Poor internal communication of compliance requirements\r\n•Delayed implementation of regulatory changes\r\n•Inadequate documentation and record-keeping practices', '•Financial penalties, fines, or litigation from regulatory agencies\r\n•Increased scrutiny by auditors, regulators, and donors\r\n•Reputational damage', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 14:40:10', '2025-10-16 14:19:37', '2025-10-16 14:40:10'),
(54, 'Adoption of Immature or Untested Technologies', 6, 6, 38, '•Lack of due diligence in selecting technologies\r\n•Pressure to modernize quickly without a formal review\r\n•Absence of a technology assessment or pilot phase\r\n•Vendor influence without proper market comparison\r\n•No alignment with university strategic or operational needs', '•Lack of due diligence in selecting technologies\r\n•Pressure to modernize quickly without a formal review\r\n•Absence of a technology assessment or pilot phase\r\n•Vendor influence without proper market comparison\r\n•No alignment with university strategic or operational needs', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 14:41:34', '2025-10-16 14:19:32', '2025-10-16 14:41:34'),
(55, 'Accumulated staff leave days', 1, 7, 39, 'Employees may feel unable to take leave due to pressing responsibilities or insufficient coverage when they are away', 'May lead to financial loss should staff choose to leave the University calling for need for compensation for the accumulated leave days\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 22:50:14', '2025-10-16 22:54:07', '2025-10-16 22:50:14'),
(56, 'Failure to carry out timely performance appraisals by Heads of Departments (HoDs) may impact People and Culture activities in terms of training and development analysis, compensation analysis and job analysis.', 2, 7, 40, 'This may arise from an inefficient performance management system. \r\n', 'This may lead to difficulty in identifying and addressing performance issues and creating staff development plans.\r\nIts likely that productivity will go down if performance is not managed well thus lowering the quality of service. Management should tie Key Performance Indicators to rewards, appraise staff bi-annually, and clarify expectations. \r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 22:53:32', '2025-10-16 22:54:00', '2025-10-16 22:53:32'),
(57, 'Risk of recruiting unqualified staff or not not attracting qualified staff', 3, 7, 41, 'This risk may occur due to:\r\n•Competition from other universities for academic staff and the few PhD graduate lecturers\r\n•Skill shortages for specific job roles\r\n•The changing work environment (preference for remote working)\r\n\r\n', '•Increased training costs if unqualified personnel are hired\r\n•Damage to organizational reputation\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 22:55:25', '2025-10-16 22:53:53', '2025-10-16 22:55:25'),
(58, ' Risk related to staff retention', 2, 7, 41, '•Inadequate screening of candidates may result in mismatches in hiring which contributes to employee turnover\r\n•Absence of career development opportunities that may lead to employee dissatisfaction and attrition\r\n•Low employee engagement', '•Employee attrition/turnover may lead to disruptions in workflow and lead to knowledge gaps\r\n•Employee attrition/turnover may lead to difficulties in succession planning\r\n\r\n', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 23:02:57', '2025-10-16 22:53:47', '2025-10-16 23:02:57'),
(59, 'Risk of litigations by employees', 5, 7, 42, 'Litigations may arise when employees sue the University on the basis of:\r\n•Discrimination\r\n•Wrongful termination\r\n•Workplace harassment\r\n•Failure to be provided with a safe working environment', 'Litigations by employees may lead to:\r\n•Financial costs (settlements/court costs)\r\n•Reputational damage\r\n•Negative impact on recruitment', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 23:06:51', '2025-10-16 22:53:41', '2025-10-16 23:06:51'),
(60, 'Loss of records ', 2, 7, 43, 'Loss of records due to crashing of the server, theft or poor storage', 'This may have a major impact as this would lead to loss of crucial employee data', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 23:08:18', '2025-10-16 22:53:23', '2025-10-16 23:08:18'),
(61, ' Failure to update employee/personnel records (incomplete employee records)', 2, 7, 43, 'This may be due to:\r\n•Lack of an appropriate checklist for verification\r\n•Failure by employees to respond to requests to provide updated records', 'Failure to have complete employee records leads to non-compliance to regulations and gaps in information on employee file records', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 23:09:49', '2025-10-16 22:53:09', '2025-10-16 23:09:49'),
(62, 'Succession risk-potential negative impact on an University due to the lack of a ready and capable successor to fill key leadership or critical positions when the current role-holders leave—whether due to retirement, resignation, termination, illness, or other unforeseen circumstances.', 3, 7, 44, 'This may be due:\r\n•Absence of a formal succession plan\r\n•Overdependence on Key Individuals\r\n•Limited Talent Pipeline\r\n•Sudden or Unplanned Exits', '•Inadequate succession planning may lead to talent gaps (loss of institutional knowledge/skills/experience) that will impact service delivery/output and achievement of SU strategic plan and student and staff experience.\r\n•Key functions or projects may stall due to loss of expertise or oversight', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 23:11:20', '2025-10-16 22:52:54', '2025-10-16 23:11:20'),
(63, 'Exit of staff after training', 3, 7, 45, 'Highly skilled staff poached by competitors ', 'Loss of highly skilled talent pool; \r\nDifficulty in replacing highly skilled employees who have exited', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 23:13:27', '2025-10-16 22:52:48', '2025-10-16 23:13:27'),
(64, 'Mental Wellness & Psychology', 3, 7, 47, 'The risk of increased mental wellness cases due to depression, health conditions, or workplace exhaustion', ' This may lead to increased absenteeism and low work productivity', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 23:14:37', '2025-10-16 22:52:41', '2025-10-16 23:14:37'),
(65, 'Risk of non - compliance with relevant/applicable regulations-OSH, KRA, WIBA, labour laws (employment act, data protection act), Persons with Disability Act, Labour Relations Act, Industrial Disputes Act, Regulation of Wages (General Amendments Order,2024), internal policies  and statutes', 5, 7, 48, 'Non - compliance with relevant regulations and statutory requirements due to inadequate training on legal implications and emerging legislation; lack of awareness in emerging issues and new regulations.', '•Fines, penalties, or sanctions from regulatory bodies (e.g. KRA, NITA, NSSF, NEMA, etc.)\r\n•Lawsuits or legal actions from employees, unions, or affected third parties\r\n•Costly litigation expenses', 1, 1, '2025-10-16', 'super-admin', 1, 2, 2, '2025-10-16 23:17:01', '2025-10-16 22:52:34', '2025-10-16 23:17:01'),
(66, 'c) Risk of delays in recruitment process and failure to communicate to job candidates on how long the recruitment process may take ', 2, 7, 41, 'Delays in the recruitment may arise due to delays in decision-making amongst interview panelists and manual screening of candidates\' resumes that is time-consuming.', 'Delays in the recuitment process and failure to communicate this to potential job candidates may lead to:\r\n•poor candidate experience\r\n•candidates losing interest in the process and taking up other competitive offers\r\n•Reputational damage to the University as disgruntled candidates may post negative reviews of their experience on social platforms', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 00:05:46', '2025-10-16 23:06:28', '2025-10-17 00:05:46'),
(68, 'Absence of training needs analysis', 2, 7, 46, 'This may be due to lack of proper performance management', 'Absence of training needs analysis may lead to failure to identify skill gaps in good time which may lead to failure to meet overall departmental/SU goals.', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 01:14:37', '2025-10-17 00:26:52', '2025-10-17 01:14:37'),
(71, 'Risk of fines, penalties and litigations arising from failure to adhere to Data Protection Act relating to management of employee information (staff files)', 5, 7, 45, 'This may be due to failure to familiarize with recent Data requirement acts.', 'Litigations may lead to fines and reputational damage.', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 01:31:25', '2025-10-17 00:32:25', '2025-10-17 01:31:25'),
(72, 'Risk of admitting unqualified students', 2, 8, 49, '•Unstandardized interview process\r\n•Untrained staff/failure of staff to be keen on admission requirements', '•Admitting unqualified students who may not be able to handle course content\r\n•Can lead to low completion rates', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:05:57', '2025-10-17 01:40:00', '2025-10-17 02:05:57'),
(73, 'Risk of over-enrollment of students', 3, 8, 49, '•Lack of enrollment caps or quotas\r\n•Poor forecasting of student demand\r\n•Weak coordination with admissions office', '•Overcrowded classes\r\n•Decline in teaching quality\r\n•Strain on facilities\r\n•Student dissatisfaction and complaints', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:06:55', '2025-10-17 01:39:53', '2025-10-17 02:06:55'),
(74, 'Staff-to-Student Ratio Not Meeting Standards', 3, 8, 50, '•Over-enrollment without proportional staff recruitment.\r\n•Faculty attrition (resignations, retirements)\r\n•Poor succession planning', '•Decline in teaching quality and supervision\r\n•High faculty workload and burnout', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:11:53', '2025-10-17 01:39:28', '2025-10-17 02:11:53'),
(75, 'Low Research Output', 3, 8, 52, '•High teaching loads\r\n•Lack of funding\r\n•Weak mentorship\r\n•Poor collaboration\r\n•Limited publications support', '•Reduced competitiveness for grants and external funding\r\n•Decline in institutional and school rankings.', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:14:27', '2025-10-17 01:39:22', '2025-10-17 02:14:27'),
(76, 'Low graduate employability', 3, 8, 53, '•Curriculum mismatch\r\n•Weak industry ties', '•Student dissatisfaction\r\n•Low attractiveness', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:15:25', '2025-10-17 01:39:12', '2025-10-17 02:15:25'),
(77, 'Academic Misconduct (plagiarism, cheating)', 3, 8, 54, '•Pressure to perform •Inadequate supervision', '•Integrity loss\r\n•Reputational damage', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:17:14', '2025-10-17 01:39:05', '2025-10-17 02:17:14'),
(78, 'Laboratory Safety Incidents', 2, 8, 55, '•Weak training\r\n•Lack of PPE; Old equipment;', 'Injuries; Legal claims; Insurance costs; Class disruptions; Reputational damage', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:18:49', '2025-10-17 01:38:56', '2025-10-17 02:18:49'),
(79, 'Accreditation Non-Compliance', 5, 8, 56, '•Outdated curriculum\r\n•Weak Quality Assurance systems;\r\n•Poor records management', '•Loss of accreditation\r\n•Student attrition to other institutions\r\n•Reputational damage', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:20:34', '2025-10-17 01:38:50', '2025-10-17 02:20:34'),
(80, 'Credit risk', 1, 8, 57, '•Students defaulting on tuition fee payments or payment plans\r\n•Weak debt collection and follow-up processes', '•Loss of expected revenue, affecting cash flow\r\n•Inadequate funds to fund academic/research programs', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:23:24', '2025-10-17 01:38:43', '2025-10-17 02:23:24'),
(81, 'Low student retention/progression', 3, 8, 51, '•Poor teaching support\r\n•Financial hardship\r\n•Low student engagement\r\n•Course difficulties/cademic difficulty due to demanding curriculum and poor preparedness of students', '•Lower graduation rates\r\n•Lower progression rate', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 02:56:38', '2025-10-17 01:57:02', '2025-10-17 02:56:38'),
(82, 'The risk of lack of proper student orientation. ', 2, 9, 58, ' This is due to poor communication, lack of interest for orientation,  poor planning and lack of support by facilitators', 'This would affect students experience in the university. ', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 10:45:29', '2025-10-17 10:14:36', '2025-10-17 10:45:29'),
(83, 'Low intake of bachelors and masters students', 3, 9, 59, 'Poor marketing, high competition, unfavorable economic conditions, limited program diversity.\r\n', 'Reduced tuition revenue, underutilization of facilities, reputational decline, financial strain.', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 10:46:47', '2025-10-17 10:14:26', '2025-10-17 10:46:47'),
(84, 'Low Research Output', 3, 9, 60, '•High teaching loads\r\n•Lack of funding\r\n•Weak mentorship\r\n•Poor collaboration\r\n•Limited publications support', '•Reduced competitiveness for grants and external funding\r\n•Decline in institutional and school rankings.', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 10:48:00', '2025-10-17 10:14:18', '2025-10-17 10:48:00'),
(85, 'Exam malpractice (cheating)\r\n', 2, 9, 61, '•Inadequate invigilation\r\n•Use of tech gadgets\r\n•Collusion\r\n•Poor seating arrangement', '•Integrity loss\r\n•Student suspensions\r\n•Reputational damage', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 10:48:45', '2025-10-17 10:14:12', '2025-10-17 10:48:45'),
(86, 'Credit risk', 1, 9, 62, '•Students defaulting on tuition fee payments or payment plans\r\n•Weak debt collection and follow-up processes', '•Loss of expected revenue, affecting cash flow\r\n•Inadequate funds to fund academic/research programs', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 10:49:43', '2025-10-17 10:14:07', '2025-10-17 10:49:43'),
(87, 'Ineffective Course Evaluation Feedback', 3, 9, 63, 'Student perception that administration ignores feedback\r\nLow student awareness of the purpose/importance of feedback\r\nFatigue or lack of motivation to complete evaluations seriously.', 'Missed opportunities for lecturer improvement\r\nStudents continue experiencing unresolved teaching/learning challenges.\r\nDecline in teaching quality and student satisfaction', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 10:50:32', '2025-10-17 10:14:02', '2025-10-17 10:50:32'),
(88, 'Delays in preparation of graduation list', 2, 9, 64, 'Incomplete student clearance, delays in exam processing, weak coordination.\r\n', 'Graduation postponements, reputational damage, student frustration.\r\n', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 10:54:54', '2025-10-17 10:13:56', '2025-10-17 10:54:54'),
(89, 'The risk of employees shifting to other institutions/departments as a result of poor job satisfaction or working environment in the school', 2, 9, 65, 'Low morale, lack of recognition, poor working conditions, limited career progression, low remuneration.\r\n', 'Loss of talent,  reduced service quality.', 1, 1, '2025-10-17', 'super-admin', 1, 2, 2, '2025-10-17 10:58:59', '2025-10-17 10:13:51', '2025-10-17 10:58:59'),
(90, 'Risk of delayed resolution of maintenance requests, vehicle breakdowns, and loss of institutional assets', 2, 11, 66, '•Inadequate preventive maintenance schedules\r\n•Delayed reporting and escalation of maintenance issues\r\n•Poor fleet inspection and servicing routines', '•Increased downtime of vehicles and equipment\r\n•Higher repair and replacement costs\r\n•Delays in service delivery', 1, 1, '2026-01-29', 'super-admin', 1, 2, 2, '2026-01-30 06:54:36', '2026-01-30 06:37:57', '2026-01-30 06:54:36'),
(92, 'The risk of loss of warehouse and stores items to theft by internal staff and students or external parties. ', 2, 11, 68, '• Weak access controls\r\n•Lack of surveillance, •Inadequate segregation of duties in inventory handling', '•Financial losses, •Reputational damage\r\n•Stock shortages affecting operations and service delivery', 1, 1, '2026-01-30', 'super-admin', 1, 2, 2, '2026-01-30 08:17:18', '2026-01-30 06:37:50', '2026-01-30 08:17:18'),
(93, 'The risk of fire outbreaks resulting from short circuits, open fire at the cafeteria.', 2, 11, 69, '•Faulty or overloaded electrical wiring and appliances\r\n•Poor electrical inspections and maintenance\r\n•Lack of fire detection and suppression equipment', '•Loss of property, injury.\r\n•Reputational damage\r\n', 1, 1, '2026-01-30', 'super-admin', 1, 2, 2, '2026-01-30 08:22:23', '2026-01-30 06:37:43', '2026-01-30 08:22:23'),
(94, 'The risk that water shortage/water contamination will be experienced in the university causing health hazard. ', 2, 11, 70, '•Poor maintenance of water tanks, pipes, and pumps\r\n•Contamination from broken pipes, leaking sewer lines, or poor drainage\r\n•Lack of routine water quality testing', '•Outbreak of waterborne diseases affecting students and staff\r\n•Increased medical and sanitation costs\r\n•Reduced campus hygiene and sanitation standards', 1, 1, '2026-01-30', 'super-admin', 1, 2, 2, '2026-01-30 08:23:51', '2026-01-30 06:37:35', '2026-01-30 08:23:51'),
(95, 'The risk of  downtime as a result of power outages, damaged equipment: and the electrical surges that occur when the power is restored. ', 2, 11, 71, '•National grid failure\r\n•Poor maintenance, lack of backup systems\r\n•Overloaded electrical circuits and outdated wiring', '•Disruption of administrative and academic operations\r\n•Damage to computers, servers, laboratory, and office equipment\r\n•Increased repair and replacement costs', 1, 1, '2026-01-30', 'super-admin', 1, 2, 2, '2026-01-30 08:25:11', '2026-01-30 06:37:29', '2026-01-30 08:25:11'),
(96, 'Risk of occupational injuries and work-related health conditions among administrative staff due to poor ergonomics, unsafe work practices, and inadequate occupational health controls.', 2, 11, 72, '•Poor workplace ergonomics, \r\n•Inadequate health & safety training', '•Work-related compensation claims and legal exposure\r\n•Poor staff wellbeing and engagement\r\n', 1, 1, '2026-01-30', 'super-admin', 1, 2, 2, '2026-01-30 08:26:47', '2026-01-30 06:37:22', '2026-01-30 08:26:47'),
(97, 'Accident involving university buses', 2, 11, 73, '•Driver fatigue\r\n•Poor road conditions\r\n•Reckless driving.', '•Injury/loss of life\r\n•Legal liability, compensation claims, and regulatory penalties\r\n•Reputational loss.\r\n', 1, 1, '2026-01-30', 'super-admin', 1, 2, 2, '2026-01-30 08:28:00', '2026-01-30 06:37:16', '2026-01-30 08:28:00'),
(98, 'Risk of non-compliance with occupational safety, health, environmental, and transport regulations', 5, 11, 74, '•Inadequate awareness of applicable OSH, environmental, and transport regulations\r\n•Infrequent internal compliance audits and inspections\r\n', '•Regulatory penalties, fines, and legal sanctions\r\n•Suspension of operations or withdrawal of operating licenses\r\n•Reputational damage to the university\r\n', 1, 1, '2026-01-30', 'super-admin', 1, 2, 2, '2026-01-30 08:29:04', '2026-01-30 06:37:09', '2026-01-30 08:29:04'),
(99, 'Low number of students enrollment. ( Especially evening classes)', 3, 12, 75, '•The risk of not attaining minimum number of target students due to high fees charged as compared to other institutions.\r\n•Tough competition from other learning institutions offering the same courses as the University.\r\n', 'Financial sustainability of university is impacted\r\n', 1, 1, '2026-01-31', 'super-admin', 1, 2, 2, '2026-01-31 19:02:55', '2026-01-31 17:12:36', '2026-01-31 19:02:55'),
(100, 'Delays in interviewing students', 2, 12, 75, 'Delays in interviewing students\r\n', '• High application volumes during peak admission periods\r\n• Inadequate number of interview panels or trained interviewers\r\n• Poor scheduling and coordination of interview sessions', 1, 1, '2026-01-31', 'super-admin', 1, 2, 2, '2026-01-31 19:05:13', '2026-01-31 17:12:29', '2026-01-31 19:05:13'),
(101, 'Data breach of applicant information ', 6, 12, 76, '• Human error\r\n• Weak cybersecurity controls\r\n•Poor document handling and disposal practices', '• Legal consequences\r\n• Reputational damage', 1, 1, '2026-01-31', 'super-admin', 1, 2, 2, '2026-01-31 19:06:09', '2026-01-31 17:12:21', '2026-01-31 19:06:09'),
(102, 'Low conversion of inquiries to applications', 3, 12, 77, '• Weak follow-up or communication with prospective students\r\n• Poor responsiveness of admissions staff to inquiries', '• Reduced number of applications and lower enrollment rates\r\n•Failure to achieve enrollment targets and institutional growth goals', 1, 1, '2026-01-31', 'super-admin', 1, 2, 2, '2026-01-31 19:07:07', '2026-01-31 17:12:14', '2026-01-31 19:07:07'),
(103, 'Delays in onboarding and solving student issues. ', 2, 12, 78, '•Poor coordination between departments\r\n•Inadequate tracking and follow-up of student issues \r\n', '•Poor client experience.\r\n•Negative reputation and loss of prospective or returning students\r\n', 1, 1, '2026-01-31', 'super-admin', 1, 2, 2, '2026-01-31 19:08:28', '2026-01-31 17:12:07', '2026-01-31 19:08:28');
INSERT INTO `risk` (`risk_id`, `risk_name`, `rcat`, `dept`, `process`, `cause`, `consequence`, `assessment`, `reviewer`, `rdate`, `nominee`, `userid`, `approval`, `uid_approve`, `created_at`, `approved_at`, `updated_at`) VALUES
(104, 'Poor customer service  by the reception, front desk and those handling calls and emails', 2, 12, 79, '•High workload and understaffing in reception and call-handling areas\r\n•Insufficient training in customer service skills\r\n•Inadequate feedback or complaint management mechanisms\r\n', '•Reputational damage\r\n•Poor client experience\r\n•Reduced efficiency in handling administrative tasks and inquiries\r\n', 1, 1, '2026-01-31', 'super-admin', 1, 2, 2, '2026-01-31 19:09:25', '2026-01-31 17:12:01', '2026-01-31 19:09:25'),
(105, 'Failure to identify illegitimate documents used in application of courses or impersonation in applications ', 3, 12, 80, '•Manual verification processes prone to human error\r\n•High application volumes leading to rushed verification\r\n•Weak internal controls over document handling and applicant identity checks\r\n', 'Admitting a student who does not meet the admission criteria.\r\n', 1, 1, '2026-01-31', 'super-admin', 1, 2, 2, '2026-01-31 19:10:19', '2026-01-31 17:11:54', '2026-01-31 19:10:19'),
(106, 'Disruption in admission process due to system failure', 2, 12, 81, 'System outage\r\n', 'Application delays, reputational damage\r\n', 1, 1, '2026-01-31', 'super-admin', 1, 2, 2, '2026-01-31 19:11:04', '2026-01-31 17:11:48', '2026-01-31 19:11:04'),
(107, 'Low attendance at  events', 3, 13, 82, '• Short notice communication \r\n• Unfavorable venue\r\n• High pricing \r\n• Weak promotions\r\n• Competing events  ', '• Revenue shortfall\r\n• Wasted venue and logistic cost\r\n• Poor stakeholder perception\r\n• Reduced sponsor value\r\n• Low engagement outcomes', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 20:47:15', '2026-02-01 19:02:16', '2026-02-01 20:47:15'),
(108, 'Risk of few alumni participating in mentoring programmes', 2, 13, 83, '• Alumni have limited availability\r\n• Poor communication with alumni\r\n• Students are unprepared to participate\r\n• Lack of incentives for alumni to participate ', '• Lower mentoring outcomes \r\n• Reduced students developments\r\n• Lower program evaluation scores ', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 20:48:16', '2026-02-01 19:02:11', '2026-02-01 20:48:16'),
(109, 'Risk of ineffective alumni engagement and support due to incomplete, inaccurate, and outdated alumni records arising from weak data management and update mechanisms', 2, 13, 84, '• Poor data collection processes\r\n• Lack of validation procedures \r\n• Manual errors during data entry\r\n• Lack of staff training on information management', '• Inability to effectively communicate and engage alumni\r\n• Poor fundraising and partnership outcomes\r\n• Ineffective alumni tracking for rankings and reporting\r\n•Missed networking and mentorship opportunities', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 20:49:09', '2026-02-01 19:02:05', '2026-02-01 20:49:09'),
(110, 'Risk of failure to meet fundraising targets due to weak alumni relations and donor engagement strategies (Low funds raised)', 1, 13, 85, '• Limited alumni engagement or low participation in the fundraising campaign\r\n•Weak or unclear fundraising strategy and targets\r\n• Short fundraising timelines or late launch of the campaign\r\n• Lack of trust or transparency on how funds are used.\r\n', '• Fundraising targets not met\r\n• Insufficient time to secure donor commitments\r\n• Reduced donor confidence and repeat giving', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 20:50:10', '2026-02-01 19:01:59', '2026-02-01 20:50:10'),
(111, 'Risk of budget overruns and overspending within the Department due to weak financial planning, monitoring, and expenditure control mechanisms.', 1, 13, 86, '• Inadequate budgeting and forecasting processes\r\n• Poor expenditure tracking and monitoring\r\n• Unplanned alumni events and activities\r\n• Lack of cost control and procurement planning\r\n', '• Budget overruns in the alumni department\r\n• Reduction or cancellation of planned activities and events\r\n• Need for unplanned budget reallocations or approvals\r\n• Delays in programme implementation', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 20:51:54', '2026-02-01 19:01:53', '2026-02-01 20:51:54'),
(112, 'Risk of breach of alumni data privacy laws and regulations due to weak data protection controls.', 5, 13, 87, '• Weak data protection policies and procedures\r\n•Unauthorized access to alumni data due to poor access controls\r\n• Inadequate consent management for use of alumni  data and images\r\n• Low staff awareness or training on data protection requirements\r\n', '• Non-compliance with data protection laws\r\n• Data breaches and exposure of personal information\r\n• Legal claims and complaints from alumni\r\n• Increased risk of data handling errors and breaches\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 20:52:58', '2026-02-01 19:01:44', '2026-02-01 20:52:58'),
(113, 'Poor reputation caused by many negative comments on social media platforms', 7, 14, 88, '•Slow or ineffective response to complaints raised on social media\r\n•Poor service delivery by frontline departments reflected online\r\n•Lack of a structured social media engagement and crisis response strategy\r\n•Inadequate monitoring of social media channels', '•Negative media attention and public scrutiny\r\n•Loss of partnerships and sponsorship opportunities\r\n•Long-term brand damage and stakeholder disengagement\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 21:30:52', '2026-02-01 19:47:57', '2026-02-01 21:30:52'),
(114, 'Uncoordinated communication on University and Departmental events-Lack of alignment and coordination in the planning, approval, and dissemination of information on university and departmental events', 2, 14, 90, '•Poor coordination between departments and the Communications Office\r\n•Lack of a shared university events calendar\r\n•Late submission of event information to the Communications Office\r\n', '•Low attendance at events due to poor or conflicting information\r\n•Reputational damage from poorly communicated or cancelled events\r\n•Reduced visibility of strategic university initiatives\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 21:33:09', '2026-02-01 19:47:50', '2026-02-01 21:33:09'),
(115, 'Damage to the university’s public image and brand reputation arising from biased or inaccurate media reporting, litigation matters and negative off-campus student activities', 7, 14, 89, '•Court cases involving the university or its stakeholders\r\n•Delayed or ineffective response to negative publicity\r\n•Absence of crisis communication and issues management framework\r\n', '•Long-term brand damage and loss of competitive positioning\r\n•Increased scrutiny by regulators and the public\r\n•Reduced attractiveness to sponsors, partners, and donors\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 21:35:47', '2026-02-01 19:47:44', '2026-02-01 21:35:47'),
(116, 'Loss of production equipment', 2, 14, 91, '•Weak asset management and tracking controls\r\n•Inadequate inventory records and tagging of equipment\r\n•Poor physical security at studios, offices, and field locations\r\n', '•Financial loss due to replacement or repair costs\r\n•Delays in coverage of university events and campaigns\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 21:36:45', '2026-02-01 19:47:38', '2026-02-01 21:36:45'),
(117, 'Breach of privacy and data protection obligations arising from taking photographs of individuals without consent, publishing images without permission, capturing sensitive or vulnerable persons without authorisation, and storing event images insecurely', 5, 14, 92, '•Limited staff awareness of data protection and privacy requirements\r\n•Inadequate approval process before publishing images\r\n•Lack of a formal consent and image-use policy', '•Violation of data protection and privacy laws\r\n•Legal claims, regulatory sanctions, and fines\r\n•Negative publicity and reputational damage', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 21:37:44', '2026-02-01 19:47:32', '2026-02-01 21:37:44'),
(118, 'Use, publication, or distribution of copyrighted images, videos, music, graphics, or written content without proper licensing, permission, or attribution', 5, 14, 93, '•Lack of awareness of copyright and intellectual property laws\r\n•Use of content sourced from the internet without license verification', '•Legal action, fines, and compensation claims\r\n•Damage to the university’s reputation\r\n•Financial loss from penalties and legal costs', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 21:39:02', '2026-02-01 19:47:27', '2026-02-01 21:39:02'),
(119, 'Lack of adequate resources e.g funding, playing facilities, ', 3, 15, 94, '• Insufficient budget allocation for sports programmes\r\n• Poor planning or prioritization of sports resources\r\n•Limited or inadequate sporting facilities and equipment\r\n• Low sponsorship or external funding support\r\n• Delayed release of funds or financi al bottlenecks\r\n• Lack of collaboration with relevant departments for resource mobilization', '• Poor performance of students and teams in competitions\r\n• Disruption of the sports calendar and scheduled events\r\n• Reduced support services for student-athletes\r\n• Low motivation and engagement among students and teams\r\n• Negative impact on the university’s reputation in sports', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 23:03:24', '2026-02-01 21:37:42', '2026-02-01 23:03:24'),
(120, 'Accidents /injuries to students/athletes', 2, 15, 94, '• Inadequate safety standards and inspections\r\n• Inadequate first aid and emergency response preparedness\r\n• Overtraining, fatigue, and poor conditioning of athletes', '• Injuries or fatalities involving students\r\n• Legal liability and compensation claims', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 23:04:24', '2026-02-01 21:37:35', '2026-02-01 23:04:24'),
(121, 'Poor managements of sports equipments and facilities', 2, 15, 94, '• Inadequate inventory and asset tracking system\r\n• Weak supervision and accountability for equipment use\r\n• Poor storage, handling, and maintenance practices\r\n• Unauthorized access or misuse by students or staff', '• Loss, damage, or theft of sports equipment\r\n• Increased replacement and maintenance costs\r\n• Disruption of training sessions and sports competitions', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 23:05:12', '2026-02-01 21:37:30', '2026-02-01 23:05:12'),
(122, 'Risk of unfair, disputed, or poorly conducted student council elections due to weak electoral governance, inadequate controls, and poor stakeholder engagement.', 2, 15, 95, '• Unclear or poorly communicated election rules and procedures\r\n• Inadequate planning and coordination of the election process\r\n• Weak oversight or lack of an independent elections committee\r\n• Use of unreliable voting systems or manual processes prone to errors', '• Disputes, complaints, or appeals from candidates and students\r\n• Loss of trust in student leadership and governance structures\r\n• Disruption of student activities and campus harmony', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 23:06:09', '2026-02-01 21:37:23', '2026-02-01 23:06:09'),
(123, 'Risk of inadequate support, integration, and compliance for international students', 2, 15, 96, '• Inadequate orientation and induction programs\r\n• Weak service standards, procedures, or response timelines\r\n• Poor coordination between International Office, Admissions, Immigration, and Academics\r\n• Limited communication channels or delayed feedback handling', '• Dissatisfaction and complaints from international students\r\n• Decline in international student retention and referrals\r\n• Reputational damage affecting future international enrolment\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 23:07:04', '2026-02-01 21:37:17', '2026-02-01 23:07:04'),
(124, 'Poor management of student events', 2, 15, 97, '• Weak event planning and approval process\r\n• No clear roles between clubs, student council, and administration\r\n• Inadequate budgeting and late fund disbursement\r\n• Poor vendor selection and contract control\r\n• Weak communication to students on event details\r\n• Last-minute changes without formal approvals', '•  Poor-quality events that fail to meet student expectations\r\n• Low turnout and reduced student engagement\r\n• Student frustration leading to apathy and disengagement\r\n• Event delays, cancellations, or incomp lete activities\r\n• Financial losses from cost overruns and penalties\r\n• Disputes with vendors and service breakdowns', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-01 23:07:50', '2026-02-01 21:37:11', '2026-02-01 23:07:50'),
(125, 'Compromised Integrity of examinations/Leakage of exams', 2, 16, 98, '•Inadequate exam security facilities\r\n•Insider collusion\r\n•Improper storage of exams\r\n•Complacency by exams stakeholder\r\n', '•Loss of integrity\r\n•Reputational damage', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 12:04:18', '2026-02-02 10:31:41', '2026-02-02 12:04:18'),
(126, 'Exam malpractice (cheating)', 2, 16, 98, '•Inadequate invigilation\r\n•Use of tech gadgets\r\n•Collusion\r\n•Poor seating arrangement', '•Integrity loss\r\n•Student suspensions\r\n•Reputational damage\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 12:05:08', '2026-02-02 10:31:36', '2026-02-02 12:05:08'),
(127, 'Delays in administering CATs and Exams', 2, 16, 98, '•Due to late printing, late collection, late submissions by faculty, overlapping timetables, overlapping semesters,  unavailability of invigilators and venues\r\n', '•Student frustration\r\n•Increased risk of malpractice (last-minute confusion)\r\n•Disruption of academic calendar\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 12:06:02', '2026-02-02 10:31:27', '2026-02-02 12:06:02'),
(128, 'Late Release of Results', 2, 16, 98, '•System breakdown\r\n•Data entry errors\r\n', 'Student frustration', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 12:07:00', '2026-02-02 10:31:20', '2026-02-02 12:07:00'),
(129, 'Poor Record Management/Loss of data/information', 2, 16, 99, 'Poor handling, inadequate indexing and storage, uncontrolled access,\r\n', 'May lead to litigation and reputation damage\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 12:08:46', '2026-02-02 10:31:14', '2026-02-02 12:08:46'),
(130, 'Inadequate Stakeholder Communication', 2, 16, 100, '•Weak/inadequate feedback systems\r\n•Late notices\r\n•IT failures\r\n', 'Affects customer experience', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 12:09:41', '2026-02-02 10:31:09', '2026-02-02 12:09:41'),
(131, 'Non-Compliance with Academic Regulations', 5, 16, 101, '•Ignorance of policies\r\n•Weak training\r\n•Poor communication and Weak governance', 'Accreditation risk\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 12:10:43', '2026-02-02 10:31:05', '2026-02-02 12:10:43'),
(132, 'Examination Venue Risks/Insufficient exams venues to administer exams', 2, 16, 102, '•Increased student population\r\n•Inadequate planning\r\n', '•Student complaints\r\n•Reputational damage\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 12:11:57', '2026-02-02 10:31:00', '2026-02-02 12:11:57'),
(133, 'Staff Shortages', 2, 16, 103, '•Resignations\r\n•Limited recruitment\r\n', '•Increased complaints\r\n•Delays in printing CAT/Exam material\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 12:12:48', '2026-02-02 10:30:53', '2026-02-02 12:12:48'),
(134, 'Enrolling students who are not open to mentorship', 2, 17, 104, 'The risk that we enroll students who are not open to being mentored due to the following reasons;\r\n1. Prospective students are not informed about mentoring during marketing activities.                                         \r\n2. They are also not exposed to mentoring during the second interview.', '•Reduced program effectiveness\r\n•Limited student impact', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 17:43:29', '2026-02-03 03:58:07', '2026-02-02 17:43:29'),
(135, 'Lack of formal introduction to mentors', 2, 17, 105, 'Some of the  causes include;\r\n•Not all students attend the established orientations sessions\r\n•Short time - no time to introduce the mentors during orientation.\r\n•Information overload and boredom during orientation\r\n•Absence of a structured mentor–mentee onboarding process                                               ', '•Negative student perception of the mentoring programme and the university’s student support services\r\n•Low student engagement and participation in the mentoring programme.\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 17:44:42', '2026-02-03 03:57:58', '2026-02-02 17:44:42'),
(136, 'Very few or no meetings between mentors and mentees', 2, 17, 106, '•Mentoring is not compulsory for students.    \r\n•Busy SU schedule for both students and lecturers. (time restraints)                              \r\n•Failure to honour meeting sessions by both mentors/mentees.             \r\n•Shortage of mentors. (staff turnover, increasing student population).                            ', '•Weak mentor-mentee relationships, reducing trust and rapport.\r\n•Reduced effectiveness and credibility of the mentoring programme.\r\n•Increased student dissatisfaction and negative perception of university support services.\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 17:47:16', '2026-02-03 03:57:51', '2026-02-02 17:47:16'),
(137, 'Inability to measure the effectiveness of mentoring and its supporting activities What qualities does a well mentored student have and how many students get mentored each semester  ', 2, 17, 107, '•Absence of defined key performance indicators (KPIs) or success metrics for mentoring.\r\n•Limited data collection tools or systems to track mentor–mentee interactions and outcomes.\r\n•Lack of structured monitoring and evaluation framework', '•Difficulty in tracking whether mentoring is improving student academic performance, wellbeing, and personal growth.\r\n•Difficulty in assessing whether mentoring objectives (academic, personal, career development) are being met.\r\n•Inability to identify programme strengths, weaknesses, or areas for improvement.', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 17:48:55', '2026-02-03 03:57:44', '2026-02-02 17:48:55'),
(138, 'Breach of mentee personal data', 5, 17, 108, '•Use of unsecured systems (emails, spreadsheets, or shared drives) to store mentee information.\r\n•Inadequate staff and mentor awareness on confidentiality and data protection requirements', '•Exposure of sensitive student information, leading to identity theft or misuse\r\n•Reduced participation in mentoring programmes due to privacy concerns\r\n', 0, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-02 17:51:24', '2026-02-03 03:57:37', '2026-02-02 17:51:24'),
(139, 'Poor/Inadequate coordination between faculties and the central research office (The risk that faculties, departments, or individual researchers operate in silos without proper engagement or alignment with the central research office)', 2, 18, 109, '•Lack of clear communication protocols and reporting lines\r\n•Absence of a centralized research management system\r\n•Misalignment of priorities between central office and academic units\r\n•Faculty autonomy without adequate institutional oversight', '•Duplication of research efforts across faculties\r\n•Unregistered or unauthorized research projects\r\n•Inaccurate or incomplete institutional research reporting\r\n•Missed funding opportunities due to poor grant coordination\r\n•Delayed approvals and disjointed support for researchers\r\n•Difficulty tracking research output and impact for performance audits\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 06:56:49', '2026-02-03 07:11:18', '2026-02-03 06:56:49'),
(140, 'Failure to Comply with Research Regulations and Ethics (The risk that research activities conducted under the university\'s name do not adhere to legal, ethical, or institutional guidelines including those from NACOSTI/CUE and funding agencies-e.g. plagiarism)', 5, 18, 109, '•Lack of awareness or training on research ethics and regulations\r\n•Pressure to publish or complete projects leading to shortcutting of processes\r\n•Absence of monitoring or post-approval follow-up on ongoing research\r\n•Non-standardized processes across faculties and departments', '•Legal action or sanctions from regulatory authorities\r\n•Retraction of publications or bans from academic journals\r\n•Damage to university’s academic reputation and stakeholder trust\r\n•Institutional non-compliance reports affecting rankings and audits\r\n•Loss of credibility with international collaborators and donors', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 07:09:59', '2026-02-03 07:11:08', '2026-02-03 07:09:59'),
(141, 'Non-compliance with Data Protection and Access Laws (The risk that the university, through its research functions, fails to comply with legal and regulatory requirements related to personal data protection, privacy, and access)', 5, 18, 109, '•Lack of awareness or training on applicable data protection laws\r\n•Inadequate security controls for storing, transmitting, and accessing sensitive data\r\n•Research projects collecting or sharing personal data without appropriate consent\r\n•Use of third-party platforms without data processing agreements or proper due diligence\r\n•Failure to honor data subject rights', '•Legal and regulatory sanctions from the Office of the Data •Protection Commissioner (ODPC) or other authorities\r\n•Financial penalties, litigation, or damages\r\n•Loss of public and stakeholder trust in the university’s ability to handle personal data\r\n•Reputational damage, especially among donors, partners, and students', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 07:10:52', '2026-02-03 07:11:01', '2026-02-03 07:10:52'),
(142, 'Failure to Publish Research Results (The risk that completed or near-complete research projects are not published in peer-reviewed journals or shared through RMS leading to loss of value, credibility)', 3, 18, 110, '•Inadequate research writing and publishing skills among researchers\r\n•Limited funding for journal publication fees\r\n•Weak incentives or recognition for publishing\r\n•Delays in ethical or editorial approvals\r\n•Inadequate research writing and publishing skills among researchers', '•Missed opportunities for policy influence, innovation, or societal impact\r\n•Reduced research visibility and university rankings\r\n•Disengagement of staff and postgraduate students from research', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 07:12:09', '2026-02-03 07:10:55', '2026-02-03 07:12:09'),
(143, 'Inadequate Research Funding (The risk that the university is unable to secure or allocate sufficient financial resources to support its research agenda)', 3, 18, 111, '•Poor grant-writing capacity among faculty and researchers\r\n•Lack of institutional strategy for donor engagement and partnerships\r\n•Weak visibility or reputation in research output\r\n•Low investment in research infrastructure and enablers', '•Poor global university rankings and limited academic visibility\r\n•Reduction in research activity, outputs, and innovation\r\n•Stalled or abandoned projects\r\n•Missed opportunities for societal impact and policy influence', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 07:13:46', '2026-02-03 07:10:48', '2026-02-03 07:13:46'),
(144, 'Mis-alignment Between Grant Objectives and Institutional Goals (The risk that grants secured by researchers or departments pursue objectives that do not support the university\'s strategic direction, academic priorities, or long-term vision)', 3, 18, 111, '•Researchers applying for grants based solely on availability, not institutional need\r\n•Weak integration between faculty research planning and the university’s strategic plan\r\n•Pressure to secure funding regardless of relevance\r\n•Lack of institutional oversight or coordination during grant proposal development', '•Diversion of time, staff, and resources to projects that add little value to institutional mission\r\n•Fragmented or duplicative research output\r\n•Lowered institutional effectiveness and identity in strategic areas\r\n•Missed opportunities to scale research that addresses core university mandates', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 07:14:38', '2026-02-03 07:10:40', '2026-02-03 07:14:38'),
(145, 'Non-compliance with Donor Guidelines / Failure to Meet Grant Deliverables or Milestones (The risk that the university researchers do not adhere to donor contractual requirements, timelines, technical standards, or reporting expectations', 5, 18, 111, '•Lack of understanding or awareness of donor requirements by project teams\r\n•Inadequate grant monitoring systems or project tracking tools\r\n•Unrealistic project timelines or resource planning at proposal stage\r\n•Weak project management and absence of milestone tracking\r\n•Failure to submit financial and narrative reports on time\r\n•Donor requirements not integrated into institutional processes and compliance checklists', '•Withdrawal of funding or penalties\r\n•Disqualification from future funding opportunities from the same or affiliated donors\r\n•Reputational damage to both the project team and the institution\r\n•Breakdown in partnerships or trust with key stakeholders\r\n•Poor institutional performance in national or global rankings', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 07:15:45', '2026-02-03 07:10:34', '2026-02-03 07:15:45'),
(146, 'Lack of Sustainability Plans Post-Grant (The risk that projects funded through external grants cannot continue delivering outcomes or maintaining operations once the funding period ends, leading to the collapse of initiatives)', 3, 18, 112, '•Overreliance on short-term donor funding with no clear continuation strategy\r\n•Absence of sustainability or exit plans embedded in project design.', '•Collapse of initiatives once funding ends\r\n•Missed opportunities for scaling up successful pilots to national or international levels.\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 07:17:18', '2026-02-03 07:10:24', '2026-02-03 07:17:18'),
(147, 'Low Research Output', 3, 18, 113, '•Insufficient funding or resources to support sustained research activities.\r\n•High teaching or administrative workloads limiting time for research\r\n•Limited research skills or mentorship among early-career researchers\r\n•Weak collaboration structures leading to isolated efforts instead of productive networks•Insufficient funding or resources to support sustained research activities.\r\n•High teaching or administrative workloads limiting time for research\r\n•Limited research skills or mentorship among early-career researchers\r\n•Weak collaboration structures leading to isolated efforts instead of productive networks', '•Reduced visibility\r\n•Loss of competitive advantage compared to other global research institutions', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 08:59:52', '2026-02-03 07:10:29', '2026-02-03 08:59:52'),
(148, 'Plagiarism or Academic Misconduct in Research Outputs', 5, 18, 114, '•Pressure to publish in order to meet funding, or reporting requirements.\r\n•Absence of robust plagiarism detection systems or weak enforcement of policies.\r\n•Weak institutional culture of ethics and accountability in research.', '•Reputational damage to the Institution\r\n•Retraction of publications or invalidation of research findings\r\n•Possible legal, regulatory, or compliance penalties (e.g., breach of grant conditions)', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 09:00:39', '2026-02-03 07:10:18', '2026-02-03 09:00:39'),
(149, 'Fraudulent Procurement Practices', 2, 19, 115, '•Collusion with vendors\r\n•Falsified documentation: fake invoices, delivery notes, or quotations submitted and approved.\r\n•Weak internal controls : lack of segregation of duties, poor approvals, or bypassing of tender procedures.', '•Financial loss: inflated costs, payments for goods not received, or duplicate invoicing.\r\n•Reputational damage: loss of trust from stakeholders, donors, regulators, and the public\r\n•Operational disruption: delayed projects due to fake or unreliable suppliers', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 14:03:40', '2026-02-03 12:15:28', '2026-02-03 14:03:40'),
(150, 'Geopolitical Fragmentation Risk', 3, 19, 116, '•Regional conflicts and wars: Ukraine–Russia war, Middle East instability, and their spillover effects on energy, food, and global markets.\r\n•Trade tensions and sanctions: e.g., U.S.–China competition, EU–Russia sanctions, creating instability in supply chains.\r\n', '•Disruption of supply chains: Increased costs and delays in procurement of critical goods/services.\r\n•Rising costs: Inflation and currency volatility driven by global instability increasing the cost of imported goods and services\r\n•Budget overruns: Procurement budgets strained by unpredictable price escalations for fuel, food, paper etc', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 14:04:31', '2026-02-03 12:15:21', '2026-02-03 14:04:31'),
(151, 'Supplier Reliability Risk: Vendors fail to deliver goods/services on time or to the required standard', 2, 19, 117, '•External disruptions: geopolitical conflicts, pandemics, strikes, or natural disasters affecting supplier operations.\r\n•Financial instability of supplier: vendor unable to sustain operations due to cash flow problems or bankruptcy\r\n•Poor supplier management/oversight: lack of due diligence, monitoring, or performance reviews\r\n•Over-dependence on single supplier: lack of alternative sources leading to vulnerability if supplier fails', '•Delays in service delivery disrupting university operations\r\n•Operational inefficiencies-halted projects\r\n•Dissatisfaction among students, faculty, and external partners due to service disruptions.\r\n•Increased costs-emergency procurement', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 14:05:29', '2026-02-03 12:15:16', '2026-02-03 14:05:29'),
(152, 'Political Volatility Risk', 3, 19, 118, '•Election-related instability: changing regimes\r\n•Policy and regulatory shifts: sudden changes in procurement laws, tax regimes, or import restrictions.', 'Political instability often fuels investor uncertainty, weakening the Kenyan shilling against major currencies. A weaker shilling may inflate procurement costs. Rising forex volatility also impacts travel budgets for staff and students engaged in exchange programs, making foreign exposure more expensive.\r\nBeyond forex effects, political volatility may also trigger trade slowdowns and border or port delays, making it harder for the university to obtain imported goods on schedule. Such interruptions frequently lead to extra storage charges.\r\nProcurement delays: disrupted timelines for acquiring goods and services critical to academic and operational function', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 14:06:48', '2026-02-03 12:15:10', '2026-02-03 14:06:48'),
(153, 'Technology & Cybersecurity Risk-Vulnerabilities in e-procurement systems', 6, 19, 119, '•Weak access controls-poorly managed passwords, lack of two-factor authentication\r\n•Unpatched vulnerabilities in the e-procurement platform.\r\n•Procurement staff or IT administrators misusing system privileges\r\n•Phishing or social engineering attacks', '•Procurement fraud- manipulation of payments\r\n•Data breaches\r\n•Service disruptions-downtime of e-procurement system halting critical acquisitions', 0, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 14:07:58', '2026-02-03 12:15:04', '2026-02-03 14:07:58'),
(154, 'Failure to meet stakeholder expectations', 3, 20, 120, '•Poor stakeholder needs assessment and expectation setting\r\n•Inadequate stakeholder engagement and communication\r\n•Delays in research project delivery', '•Loss of stakeholder confidence and trust\r\n•Damage to institutional and centre reputation\r\n•Termination of partnerships and collaboration', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 14:41:55', '2026-02-03 13:02:08', '2026-02-03 14:41:55'),
(155, 'Risk of health and safety incidents within the Energy Research Centre arising from hazardous research activities, unsafe equipment, and inadequate safety management systems.', 2, 20, 121, '•Exposure to high-voltage systems, batteries, chemicals, and mechanical equipment\r\n•Lack of proper personal protective equipment (PPE)\r\n•Poor equipment maintenance and unsafe laboratory conditions\r\n•Inadequate risk assessments and standard operating procedures (SOPs)', '•Injuries or fatalities involving staff, students, or visitors\r\n•Damage to research equipment and facilities\r\n•Legal liability and regulatory penalties', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 14:42:43', '2026-02-03 13:02:02', '2026-02-03 14:42:43'),
(156, 'Risk of mismanagement of donor and grant funds', 1, 20, 122, '•Limited understanding of donor funding conditions\r\n•Delayed or inaccurate financial reporting\r\n•Poor procurement and expenditure controls', '•Loss of donor confidence and future funding\r\n•Project suspension or termination\r\n•Reputational damage to the university and research centre', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 14:44:24', '2026-02-03 13:01:56', '2026-02-03 14:44:24'),
(157, 'Risk of contractual, intellectual property, or performance-related disputes with industry partners and sponsors due to unclear agreements, misaligned expectations, and weak partnership governance', 3, 20, 123, '•Ambiguous contract terms and deliverables\r\n•Misalignment of project expectations and timelines\r\n•Inadequate legal review of partnership agreements\r\n•Communication breakdowns with partners', '•Delays or cancellation of joint research projects\r\n•Legal disputes and associated costs\r\n•Termination of partnerships and loss of funding', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 14:57:07', '2026-02-03 13:01:50', '2026-02-03 14:57:07'),
(158, 'Risk of admitting unqualified students', 3, 21, 124, '•Unstandardized interview process\r\n•Untrained staff/failure of staff to be keen on admission requirements', '•Admitting unqualified students who may not be able to handle course content\r\n•Can lead to low completion rates', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 20:11:31', '2026-02-03 18:27:03', '2026-02-03 20:11:31'),
(159, 'Risk of low student enrollment', 3, 21, 124, '•Low interest in STEM careers\r\n•Competition from other universities\r\n•Poor secondary school math performance\r\n•Inadequate outreach to high schools', '•Reduced tuition income\r\n•Weakened reputation', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 20:12:35', '2026-02-03 18:26:57', '2026-02-03 20:12:35'),
(160, 'Low graduate employability', 3, 21, 125, '•Curriculum mismatch\r\n•Weak industry ties', '•Student dissatisfaction\r\n•Low attractiveness of SIMS courses', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 20:13:39', '2026-02-03 18:26:51', '2026-02-03 20:13:39'),
(161, 'Low student retention/progression', 3, 21, 126, '•Poor teaching support\r\n•Financial hardship\r\n•Low student engagement\r\n•Course difficulties', '•Lower graduation rates\r\n•Lower progression rate', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 20:14:36', '2026-02-03 18:26:45', '2026-02-03 20:14:36'),
(162, 'Credit risk', 1, 21, 127, '•Students defaulting on tuition fee payments or payment plans\r\n•Weak debt collection and follow-up processes', '•Loss of expected revenue, affecting cash flow\r\n•Inadequate funds to fund academic/research programs', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-03 20:15:32', '2026-02-03 18:26:40', '2026-02-03 20:15:32'),
(163, 'Risk of admitting unqualified students', 2, 22, 128, '•Unstandardized interview process\r\n•Untrained staff/failure of staff to be keen on admission requirements', '•Admitting unqualified students who may not be able to handle course content\r\n•Can lead to low completion rates', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-04 22:39:35', '2026-02-05 04:20:14', '2026-02-04 22:39:35'),
(164, 'Low student numbers in the programmes for both full-time and evening programmes, as well as the masters programme', 3, 22, 128, '•Competition from other institutions\r\n•Inadequate marketing of school programmes\r\n•Economic factors\r\n•Mode of programme delivery that limits student enrolment especially for evening students who are employed\r\n•Student preference for other courses that are deemed more employable', 'May affect financial sustainability of the School', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-04 22:40:39', '2026-02-05 04:20:08', '2026-02-04 22:40:39'),
(165, 'Inadequate student onboarding', 2, 22, 129, 'The risk of inadequate student onboarding occassioned by delays in orientation, issuing IDs and unit registration. ', 'This may affect student experience.', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-04 22:42:05', '2026-02-05 04:20:03', '2026-02-04 22:42:05'),
(166, 'Credit risk - High Receivables ', 1, 22, 130, '•Credit risk arising from delayed fee payment by students.\r\n•Improper invoicing, late registration, student withdrawing from registered units and poor debt collection strategies  can also cause delays in collection money. ', 'High credit risk may affect the School\'s ability to meet current and longterm obligations-affect cashflow of the School.', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-04 22:43:15', '2026-02-05 04:19:57', '2026-02-04 22:43:15'),
(167, 'Over expenditure/ budget overruns ', 1, 22, 131, 'Budget overruns as a result of:\r\n•Inaccurate estimates during budgeting process\r\n•Increased expenses arising from economic factors-inflation\r\n•Failure to monitor expenses', '•May cause financial strain on the school leading to shortage of funds for essential activities\r\n•May affect the School\'s ability to meet current financial obligations', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-04 22:44:37', '2026-02-05 04:19:52', '2026-02-04 22:44:37'),
(168, 'Delays in examination processes', 2, 22, 132, 'The risk of delays in administration of examinations as a result of late registration of students on AMS, late submission of exams and results by lecturers', 'May lead to delayed reporting and publishing of exams results which can impact student experience.', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-04 22:45:52', '2026-02-05 04:19:46', '2026-02-04 22:45:52'),
(169, 'Low Research Output', 3, 22, 133, '•High teaching loads\r\n•Lack of funding\r\n•Weak mentorship\r\n•Poor collaboration\r\n•Limited publications support', '•Reduced competitiveness for grants and external funding\r\n•Decline in institutional and school rankings.', 1, 1, '2026-02-02', 'super-admin', 1, 2, 2, '2026-02-04 22:47:06', '2026-02-05 04:19:41', '2026-02-04 22:47:06'),
(170, 'Unauthorized Access to Student Data', 2, 22, 134, '•Weak access controls\r\n•Shared passwords\r\n•Lack of role-based restrictions.', '•Breach of confidential student (grades, medical, financial data)\r\n•Regulatory penalties', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-04 22:48:13', '2026-02-05 04:19:33', '2026-02-04 22:48:13'),
(171, 'Targeting Non-Aligned Prospects', 2, 23, 135, '•Inadequate prospect research or profiling\r\n•Lack of clear donor segmentation criteria\r\n•Misalignment between donor interests and university mission\r\n•Pressure to increase donor pool without quality checks', '•Wasted time and resources on unproductive leads\r\n•Low donor conversion rates\r\n•Reputational damage if outreach appears indiscriminate or insincere', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:48:33', '2026-02-05 06:25:45', '2026-02-05 06:48:33'),
(172, 'Reputational Risks from Associating with Controversial Donors', 7, 23, 135, '•Inadequate due diligence or background checks\r\n•Pressure to meet fundraising targets leading to overlooked red flags\r\n•Donor\'s involvement in legal, political, environmental, or social controversies', '•Damage to university’s public image and brand\r\n•Withdrawal of support from other donors or partners', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:49:27', '2026-02-05 06:25:31', '2026-02-05 06:49:27'),
(173, 'Misjudging Donor Capacity or Interest', 2, 23, 137, '•Inadequate due diligence or background checks\r\n•Pressure to meet fundraising targets leading to overlooked red flags\r\n•Donor\'s involvement in legal, political, environmental, or social controversies', '•Damage to university’s public image and brand\r\n•Withdrawal of support from other donors or partners', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:51:02', '2026-02-05 06:25:22', '2026-02-05 06:51:02'),
(174, 'Use of outdated or Inaccurate Data', 2, 23, 137, '•Infrequent data updates in the donor database\r\n•Manual data entry errors\r\n•Limited access to verified external data sources', '•Targeting wrong or inactive prospects\r\n•Poor personalization of communication\r\n•Misjudgment of donor capacity or preferences\r\n•Missed opportunities', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:52:36', '2026-02-05 06:25:12', '2026-02-05 06:52:36'),
(175, 'Inadequate engagement/Poor Relationship-Building', 2, 23, 138, '•Infrequent or impersonal communication with donors\r\n•Lack of staff training in donor engagement and emotional intelligence\r\n•Failure to understand donor motivations, values, or giving history\r\n•Absence of a relationship management strategy or donor journey map\r\n•High staff turnover leading to inconsistent contact', '•Donor disengagement or withdrawal of support\r\n•Damaged institutional reputation\r\n•Lower donor retention\r\n•Missed opportunities for long-term partnerships and endowments', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:53:25', '2026-02-05 06:25:02', '2026-02-05 06:53:25'),
(176, 'Donor Fatigue Due to Excessive Engagement', 2, 23, 139, '•Frequent or repetitive solicitation requests\r\n•Lack of coordination among departments leading to multiple, uncoordinated contacts\r\n•Failure to segment donors based on engagement preferences and giving cycles', '•Donors may feel overwhelmed\r\n•Decline in donor responsiveness or giving frequency\r\n•Increased opt-outs or unsubscribes from communications\r\n•Damage to long-term donor relationships and retention rates\r\n•Reduced effectiveness of future campaigns', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:54:17', '2026-02-05 06:24:28', '2026-02-05 06:54:17'),
(177, 'Overpromising Impact ', 2, 23, 139, '•Pressure to secure funding or meet fundraising targets\r\n•Miscommunication or exaggerated claims in proposals or discussions', '•Donor dissatisfaction or withdrawal of support\r\n•Reduced likelihood of repeat donations\r\n•Reputational damage', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:54:58', '2026-02-05 06:24:20', '2026-02-05 06:54:58'),
(178, 'Poorly Timed or Inappropriate Ask', 2, 23, 139, '•Inadequate understanding of donor readiness or giving cycles\r\n•Lack of donor research or previous engagement\r\n•Misalignment between ask amount and donor capacity\r\n•Failure to consider external contexts (e.g., economic downturns, personal donor situations)', '•Damaged donor relationship or loss of future giving potential\r\n•Donor frustration, especially among major or legacy donors\r\n•Loss of donor or obtaining too little funds\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:55:49', '2026-02-05 06:24:15', '2026-02-05 06:55:49'),
(179, 'Unclear or Vague Funding Proposals', 2, 23, 139, '•Lack of clarity in objectives, outcomes, and impact of the project\r\n•Poor proposal writing skills or limited donor-centered communication\r\n•Failure to align proposal with donor priorities and interests\r\n•Rushed proposal development without sufficient data or evidence', '•Donor confusion or rejection of the proposal\r\n•Loss of funding opportunities\r\n•Delay in project implementation due to funding gaps\r\n•Reduced competitiveness compared to other institutions with stronger proposals', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:57:03', '2026-02-05 06:24:08', '2026-02-05 06:57:03'),
(180, 'Misuse or Misallocation of Funds', 1, 23, 140, '•Weak financial controls and oversight mechanisms\r\n•Miscommunication between departments on fund utilization\r\n•Intentional fraud or negligence by staff or project leads', '•Breach of donor agreements and legal implications\r\n•Loss of donor trust and future funding opportunities\r\n•Reputational damage to the university\r\n•Disruption of funded projects and services (e.g., scholarships)', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:57:49', '2026-02-05 06:24:03', '2026-02-05 06:57:49'),
(181, 'Donor Dependency Risk', 3, 23, 140, '•Over-reliance on a small number of high-value donors\r\n•Lack of diversification in the donor base (corporate, alumni, foundations, etc.)\r\n•Inadequate investment in prospecting or cultivating new donors', '•Vulnerability to financial instability if a major donor withdraws support\r\n•Strategic shifts in donor priorities can abruptly affect ongoing programs', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 06:58:44', '2026-02-05 06:23:58', '2026-02-05 06:58:44'),
(182, 'Succession Risk', 3, 23, 141, '•Staff turnover/leadership transition\r\n•Lack of succession planning', '•Operational Instabilities\r\n•Disruption in donor engagement and stewardship', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 08:03:01', '2026-02-05 06:23:53', '2026-02-05 08:03:01'),
(183, 'Competition from Other Nonprofits for Donor Contributions/Failure to innovate in a competitive fundraising environment)', 3, 23, 141, '•Increased number of nonprofits targeting the same donor pool\r\n•Donors prioritizing other causes (e.g., health, environment, humanitarian aid)\r\n•Inadequate donor engagement or stewardship compared to competitors\r\n•Economic constraints forcing donors to reduce contributions', '•Reduced donor retention and difficulty attracting new donors\r\n•Lower fundraising revenue and support for scholarships and capital projects •Increased cost of donor acquisition and engagement\r\n•Loss of long-term partnerships to competing organizations', 0, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 08:03:56', '2026-02-05 06:23:47', '2026-02-05 08:03:56'),
(184, 'Legal or Regulatory Non-Compliance (e.g Data Privacy)', 5, 23, 142, '•Lack of awareness or understanding of applicable laws (e.g., data protection\r\n•Failure to obtain proper donor consent for data use and communication\r\n•Poor documentation of donor agreements and fund utilization\r\n•Inadequate training of staff on compliance responsibilities', '•Legal penalties or fines from regulatory authorities\r\n•Reputational damage and erosion of donor trust\r\n•Risk of data breaches and lawsuits', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 08:04:46', '2026-02-05 06:23:41', '2026-02-05 08:04:46'),
(185, 'Economic Downturns / Political Events', 4, 23, 143, '•National or global economic recessions reducing donor disposable income\r\n•Political instability or government policy shifts impacting philanthropic giving or foreign donations\r\n•Devaluation of local currency or inflation reducing the value of donations\r\n•Changes in tax laws affecting donor incentives', '•Reduction in donor contributions\r\n•Difficulty in meeting fundraising targets or sustaining long-term commitments\r\n•Postponement or cancellation of major capital or scholarship', 0, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 08:05:41', '2026-02-05 06:23:37', '2026-02-05 08:05:41'),
(186, 'Cybersecurity / Data Breach', 6, 23, 144, '•Lack of encryption and secure access controls\r\n•Phishing attacks, malware, or ransomware\r\n•Inadequate staff awareness of cyber threats\r\n•Use of unsecured networks or third-party platforms without proper vetting', '•Unauthorized access to or theft of donor data (names, contacts, financial details)\r\n•Reputational damage and erosion of donor trust\r\n•Financial penalties or legal action from affected stakeholders', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 08:06:29', '2026-02-05 06:23:31', '2026-02-05 08:06:29'),
(187, 'Failure to maintain turn around time acceptable in target areas e.g. Registration to exit, registration to triage, registration to billing , Laboratory , Imaging, physiotherapy e.t.c', 2, 24, 145, 'Occupational Health and Safety\r\n', '•Long waiting times leading to patient frustration and complaints\r\n•Reputational damage to the medical centre and university\r\n•Possible loss of revenue as patients opt for external facilities\r\n•Patient safety risks, especially for urgent cases delayed in triage or diagnostics\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:50:01', '2026-02-05 08:35:24', '2026-02-05 09:50:01');
INSERT INTO `risk` (`risk_id`, `risk_name`, `rcat`, `dept`, `process`, `cause`, `consequence`, `assessment`, `reviewer`, `rdate`, `nominee`, `userid`, `approval`, `uid_approve`, `created_at`, `approved_at`, `updated_at`) VALUES
(188, '\"Failure to maintain a  safe environment for  staff and our clients  in the medical centre  through proper  infection prevention measures.\"', 2, 24, 146, '•Non-compliance with infection prevention and control (IPC) protocols ((e.g., hand hygiene, PPE usage, cleaning standards)\r\n•Poor sanitation and environmental cleaning practices\r\n•Improper waste segregation and disposal, especially medical waste\r\n•Lack of functional ventilation systems\r\n•Breakdowns in water supply, affecting hygiene practices\r\n•Delayed maintenance of cleaning equipment or sterilization machines', '•Spread of infections among patients and staff\r\n•Heightened risk of outbreaks within the university community\r\n•Patient and staff complaints, loss of confidence in medical centre\r\n•Higher operational costs due to increased disease management\r\n•Regulatory non-compliance, risking closure or penalties', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:51:09', '2026-02-05 08:35:16', '2026-02-05 09:51:09'),
(189, 'Failure to Observe the Six Rights of Medication Administration ((Right Patient, Right Medication, Right Dose, Right Route, Right Time, Right Documentation)', 2, 24, 147, '•Distractions and interruptions during medication rounds\r\n•Lack of standardized medication administration protocols\r\n•Medication look-alike / sound-alike errors\r\n•Inadequate staff training on medication safety\r\n•Poor communication between prescribers, nurses, and pharmacy', '•Medication errors (overdose, underdose, wrong drug, wrong route\r\n•Patient harm or death, including adverse drug reactions\r\n•Legal liability for the medical centre and the university\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:52:06', '2026-02-05 08:35:07', '2026-02-05 09:52:06'),
(190, 'Unauthorized Access to Patient Records ', 5, 24, 148, '•Weak access controls on HMIS system-Sanitas\r\n•Shared login credentials or weak passwords\r\n•Lack of monitoring or audit trails', '•Violation of patient confidentiality\r\n•Legal penalties for the university (Data Protection Act)\r\n•Risk of sensitive health data being leaked\r\n•Potential lawsuits and reputational damage', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:53:14', '2026-02-05 08:35:02', '2026-02-05 09:53:14'),
(191, 'Data Breach or Cyberattack (Hacking, Malware, Ransomware)', 6, 24, 148, '•Staff clicking phishing emails\r\n•Weak cybersecurity infrastructure\r\n•Lack of network firewalls\r\n•Unpatched vulnerabilities', '•Loss of patient data or medical histories\r\n•Legal liability and compliance penalties\r\n•Service disruption', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:54:26', '2026-02-05 08:34:57', '2026-02-05 09:54:26'),
(192, 'Unauthorized Access, Misuse, or Loss of Patient Data Due to Use of a Third-Party Medical System (Sanitas)', 2, 24, 148, '•Insufficient due diligence on the vendor’s security and privacy practices.\r\n•System vulnerabilities or misconfigurations within the vendor’s platform\r\n•Dependence on vendor support, increasing exposure if vendor is breached.\r\n•Inadequate contractual safeguards', '•Patient data breach exposing diagnoses, lab results, personal identifiers.\r\n•Reputational damage to the medical centre and university.\r\n•Regulatory fines or sanctions for using non-compliant processors.\r\n•Loss of service availability if the vendor suffers downtime or ransomware attack.\r\n•Data integrity risks if vendor systems corrupt or alter records.', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:55:21', '2026-02-05 08:34:52', '2026-02-05 09:55:21'),
(193, 'Privacy Breach Due to Staff Misconduct', 5, 24, 148, '•Gossip about patients\r\n•Sharing test results with unauthorized persons\r\n•Improper handling of patient files', '•Inadequate verification of prescriptions\r\n•Poor handwriting on manual prescriptions\r\n•Wrong dose form selected (tablet vs syrup)', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:56:22', '2026-02-05 08:34:47', '2026-02-05 09:56:22'),
(194, 'Medication Dispensing Errors', 2, 24, 149, '•Inadequate verification of prescriptions\r\n•Poor handwriting on manual prescriptions\r\n•Wrong dose form selected (tablet vs syrup)\r\n', '•Patient harm or adverse drug reactions\r\n•Legal liability for the institution in adverse cases', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:57:50', '2026-02-05 08:34:42', '2026-02-05 09:57:50'),
(195, 'Expired or Poor-Quality Medicines Released to Patients', 2, 24, 149, '•Lack of first-expiry-first-out (FEFO) system\r\n•Inadequate storage monitoring\r\n•Receiving substandard/damaged stock from suppliers', '•Patient harm or therapeutic failure\r\n•Regulatory penalties\r\n•Damage to the centre’s reputation', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:58:47', '2026-02-05 08:34:35', '2026-02-05 09:58:47'),
(196, 'Medicine Stock-outs & Supply Chain Disruptions', 2, 24, 150, '•Inefficient procurement planning\r\n•Supplier failures or shortages\r\n•Poor inventory tracking', 'Patient dissatisfaction\r\nOperational interruptions', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 09:59:37', '2026-02-05 08:34:29', '2026-02-05 09:59:37'),
(197, 'Emergency Response Failure', 2, 24, 151, '•Inadequate emergency procedures\r\n•Lack of first responders or trained staff\r\n•Shortage of emergency supplies\r\n', '•Loss of life or medical complications\r\n•Litigation and reputational damage', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 10:00:39', '2026-02-05 08:34:20', '2026-02-05 10:00:39'),
(198, 'Non-Compliance with Health Regulations', 5, 24, 152, '•Lack of regulatory awareness\r\n•Delayed license renewals\r\n•Failure to meet public health standards', '•Suspension of medical centre operations\r\n•Fines and penalties\r\n', 1, 1, '2026-02-01', 'super-admin', 1, 2, 2, '2026-02-05 10:01:29', '2026-02-05 08:34:14', '2026-02-05 10:01:29');

-- --------------------------------------------------------

--
-- Table structure for table `riskcat`
--

CREATE TABLE `riskcat` (
  `riskcat_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `riskcat`
--

INSERT INTO `riskcat` (`riskcat_id`, `name`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Financial', 'Financial\r\n', '2025-10-15 11:31:19', '2025-10-15 11:31:19'),
(2, 'Operational', 'Operational\r\n', '2025-10-15 11:39:49', '2025-10-15 11:39:49'),
(3, 'Strategic', 'Strategic\r\n', '2025-10-15 11:40:06', '2025-10-15 11:40:06'),
(4, 'Economic', 'Economic\r\n', '2025-10-15 11:40:24', '2025-10-15 11:40:24'),
(5, 'Compliance/Legal', 'Compliance/Legal\r\n', '2025-10-15 11:40:41', '2025-10-15 11:40:41'),
(6, 'technological', 'technological\r\n', '2025-10-15 11:41:07', '2025-10-15 11:41:07'),
(7, 'Reputational', 'Reputational', '2026-02-01 21:29:34', '2026-02-01 21:29:34');

-- --------------------------------------------------------

--
-- Table structure for table `risk_control`
--

CREATE TABLE `risk_control` (
  `dept_id` int(11) NOT NULL,
  `risk_id` int(11) NOT NULL,
  `control_id` int(11) NOT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `risk_control`
--

INSERT INTO `risk_control` (`dept_id`, `risk_id`, `control_id`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 1, '2025-10-15 14:42:20', '2025-10-15 14:42:20'),
(1, 2, 2, 1, '2025-10-15 14:44:39', '2025-10-15 14:44:39'),
(1, 3, 3, 1, '2025-10-15 14:47:41', '2025-10-15 14:47:41'),
(1, 4, 4, 1, '2025-10-15 14:48:59', '2025-10-15 14:48:59'),
(1, 5, 5, 1, '2025-10-15 14:51:09', '2025-10-15 14:51:09'),
(1, 6, 7, 1, '2025-10-15 14:52:44', '2025-10-15 14:52:44'),
(1, 7, 7, 1, '2025-10-15 14:56:12', '2025-10-15 14:56:12'),
(1, 8, 8, 1, '2025-10-15 15:04:50', '2025-10-15 15:04:50'),
(2, 9, 9, 1, '2025-10-15 23:12:11', '2025-10-15 23:12:11'),
(2, 10, 10, 1, '2025-10-15 23:15:01', '2025-10-15 23:15:01'),
(2, 11, 11, 1, '2025-10-15 23:16:25', '2025-10-15 23:16:25'),
(2, 12, 11, 1, '2025-10-15 23:18:45', '2025-10-15 23:18:45'),
(2, 13, 13, 1, '2025-10-15 23:21:42', '2025-10-15 23:21:42'),
(2, 14, 14, 1, '2025-10-15 23:22:42', '2025-10-15 23:22:42'),
(3, 15, 15, 1, '2025-10-16 00:49:53', '2025-10-16 00:49:53'),
(3, 16, 16, 1, '2025-10-16 00:51:26', '2025-10-16 00:51:26'),
(3, 17, 17, 1, '2025-10-16 01:19:05', '2025-10-16 01:19:05'),
(3, 18, 18, 1, '2025-10-16 01:23:15', '2025-10-16 01:23:15'),
(3, 20, 19, 1, '2025-10-16 01:24:38', '2025-10-16 01:24:38'),
(3, 23, 23, 1, '2025-10-16 01:30:38', '2025-10-16 01:30:38'),
(3, 15, 15, 1, '2025-10-16 01:41:39', '2025-10-16 01:41:39'),
(3, 24, 20, 1, '2025-10-16 01:47:05', '2025-10-16 01:47:05'),
(3, 21, 21, 1, '2025-10-16 01:48:18', '2025-10-16 01:48:18'),
(3, 22, 22, 1, '2025-10-16 01:49:34', '2025-10-16 01:49:34'),
(3, 23, 23, 1, '2025-10-16 01:50:51', '2025-10-16 01:50:51'),
(4, 25, 24, 1, '2025-10-16 09:13:32', '2025-10-16 09:13:32'),
(4, 26, 24, 0, '2025-10-16 09:14:30', '2025-10-16 09:14:30'),
(4, 26, 25, 1, '2025-10-16 09:16:34', '2025-10-16 09:16:34'),
(4, 27, 34, 1, '2025-10-16 09:21:17', '2025-10-16 09:21:17'),
(4, 28, 26, 1, '2025-10-16 09:22:03', '2025-10-16 09:22:03'),
(4, 29, 27, 1, '2025-10-16 09:23:01', '2025-10-16 09:23:01'),
(4, 30, 28, 1, '2025-10-16 09:24:15', '2025-10-16 09:24:15'),
(4, 31, 29, 1, '2025-10-16 09:25:01', '2025-10-16 09:25:01'),
(4, 32, 30, 1, '2025-10-16 09:25:58', '2025-10-16 09:25:58'),
(4, 33, 31, 1, '2025-10-16 09:26:46', '2025-10-16 09:26:46'),
(4, 34, 32, 1, '2025-10-16 09:27:42', '2025-10-16 09:27:42'),
(4, 35, 33, 1, '2025-10-16 09:28:59', '2025-10-16 09:28:59'),
(5, 36, 44, 1, '2025-10-16 13:40:40', '2025-10-16 13:40:40'),
(5, 37, 43, 1, '2025-10-16 13:42:10', '2025-10-16 13:42:10'),
(5, 38, 42, 1, '2025-10-16 13:43:37', '2025-10-16 13:43:37'),
(5, 39, 41, 1, '2025-10-16 13:44:37', '2025-10-16 13:44:37'),
(5, 40, 39, 1, '2025-10-16 13:45:40', '2025-10-16 13:45:40'),
(5, 41, 40, 1, '2025-10-16 13:49:02', '2025-10-16 13:49:02'),
(5, 42, 39, 1, '2025-10-16 13:52:14', '2025-10-16 13:52:14'),
(5, 43, 35, 1, '2025-10-16 13:54:06', '2025-10-16 13:54:06'),
(5, 44, 36, 1, '2025-10-16 13:55:16', '2025-10-16 13:55:16'),
(5, 45, 35, 1, '2025-10-16 13:57:18', '2025-10-16 13:57:18'),
(6, 46, 45, 1, '2025-10-16 15:23:39', '2025-10-16 15:23:39'),
(6, 47, 46, 1, '2025-10-16 15:36:29', '2025-10-16 15:36:29'),
(6, 48, 47, 1, '2025-10-16 15:37:12', '2025-10-16 15:37:12'),
(6, 49, 48, 1, '2025-10-16 15:38:17', '2025-10-16 15:38:17'),
(6, 50, 49, 1, '2025-10-16 15:38:59', '2025-10-16 15:38:59'),
(6, 51, 50, 1, '2025-10-16 15:39:46', '2025-10-16 15:39:46'),
(6, 52, 51, 1, '2025-10-16 15:40:40', '2025-10-16 15:40:40'),
(6, 53, 52, 1, '2025-10-16 15:41:47', '2025-10-16 15:41:47'),
(6, 54, 53, 1, '2025-10-16 15:42:27', '2025-10-16 15:42:27'),
(7, 55, 54, 1, '2025-10-17 00:00:26', '2025-10-17 00:00:26'),
(7, 56, 55, 1, '2025-10-17 00:02:00', '2025-10-17 00:02:00'),
(7, 57, 56, 1, '2025-10-17 00:04:02', '2025-10-17 00:04:02'),
(7, 66, 58, 1, '2025-10-17 00:10:42', '2025-10-17 00:10:42'),
(7, 59, 59, 1, '2025-10-17 00:12:16', '2025-10-17 00:12:16'),
(7, 60, 60, 1, '2025-10-17 00:13:32', '2025-10-17 00:13:32'),
(7, 61, 61, 1, '2025-10-17 00:14:20', '2025-10-17 00:14:20'),
(7, 62, 61, 1, '2025-10-17 00:15:28', '2025-10-17 00:15:28'),
(7, 62, 62, 1, '2025-10-17 01:04:39', '2025-10-17 01:04:39'),
(7, 71, 63, 1, '2025-10-17 01:34:57', '2025-10-17 01:34:57'),
(7, 68, 64, 1, '2025-10-17 01:37:52', '2025-10-17 01:37:52'),
(7, 63, 65, 1, '2025-10-17 01:42:38', '2025-10-17 01:42:38'),
(7, 64, 66, 1, '2025-10-17 01:43:41', '2025-10-17 01:43:41'),
(7, 65, 57, 1, '2025-10-17 01:45:10', '2025-10-17 01:45:10'),
(7, 58, 57, 1, '2025-10-17 01:47:46', '2025-10-17 01:47:46'),
(8, 72, 68, 1, '2025-10-17 02:48:04', '2025-10-17 02:48:04'),
(8, 73, 69, 1, '2025-10-17 02:52:42', '2025-10-17 02:52:42'),
(8, 74, 70, 1, '2025-10-17 02:53:59', '2025-10-17 02:53:59'),
(8, 81, 71, 1, '2025-10-17 02:58:35', '2025-10-17 02:58:35'),
(8, 75, 72, 1, '2025-10-17 03:02:15', '2025-10-17 03:02:15'),
(8, 76, 73, 1, '2025-10-17 03:06:52', '2025-10-17 03:06:52'),
(8, 77, 74, 1, '2025-10-17 03:08:44', '2025-10-17 03:08:44'),
(8, 78, 75, 1, '2025-10-17 03:09:25', '2025-10-17 03:09:25'),
(8, 79, 76, 1, '2025-10-17 03:11:21', '2025-10-17 03:11:21'),
(8, 80, 77, 1, '2025-10-17 03:12:25', '2025-10-17 03:12:25'),
(9, 82, 78, 1, '2025-10-17 11:16:49', '2025-10-17 11:16:49'),
(9, 83, 79, 1, '2025-10-17 11:17:28', '2025-10-17 11:17:28'),
(9, 84, 80, 1, '2025-10-17 11:18:21', '2025-10-17 11:18:21'),
(9, 85, 17, 1, '2025-10-17 11:21:55', '2025-10-17 11:21:55'),
(9, 86, 77, 1, '2025-10-17 11:22:58', '2025-10-17 11:22:58'),
(9, 87, 83, 1, '2025-10-17 11:24:37', '2025-10-17 11:24:37'),
(9, 88, 84, 1, '2025-10-17 11:25:30', '2025-10-17 11:25:30'),
(9, 89, 85, 1, '2025-10-17 11:26:24', '2025-10-17 11:26:24'),
(11, 90, 87, 1, '2026-01-30 14:25:25', '2026-01-30 14:25:25'),
(11, 90, 87, 1, '2026-01-30 14:28:46', '2026-01-30 14:28:46'),
(11, 90, 87, 1, '2026-01-30 14:29:16', '2026-01-30 14:29:16'),
(11, 90, 87, 1, '2026-01-30 14:31:42', '2026-01-30 14:31:42'),
(11, 92, 88, 1, '2026-01-31 18:04:30', '2026-01-31 18:04:30'),
(11, 93, 89, 1, '2026-01-31 18:05:44', '2026-01-31 18:05:44'),
(11, 94, 90, 1, '2026-01-31 18:06:47', '2026-01-31 18:06:47'),
(11, 95, 92, 1, '2026-01-31 18:07:46', '2026-01-31 18:07:46'),
(11, 96, 93, 1, '2026-01-31 18:08:45', '2026-01-31 18:08:45'),
(11, 97, 94, 1, '2026-01-31 18:10:01', '2026-01-31 18:10:01'),
(11, 98, 95, 1, '2026-01-31 18:10:49', '2026-01-31 18:10:49'),
(12, 99, 96, 1, '2026-01-31 21:15:47', '2026-01-31 21:15:47'),
(12, 100, 97, 1, '2026-01-31 21:17:33', '2026-01-31 21:17:33'),
(12, 101, 98, 1, '2026-01-31 21:18:55', '2026-01-31 21:18:55'),
(12, 102, 99, 1, '2026-01-31 21:20:52', '2026-01-31 21:20:52'),
(12, 103, 100, 1, '2026-01-31 21:22:06', '2026-01-31 21:22:06'),
(12, 104, 101, 1, '2026-01-31 21:23:13', '2026-01-31 21:23:13'),
(12, 105, 102, 1, '2026-01-31 21:24:21', '2026-01-31 21:24:21'),
(12, 106, 103, 1, '2026-01-31 21:25:12', '2026-01-31 21:25:12'),
(13, 107, 104, 1, '2026-02-01 21:06:05', '2026-02-01 21:06:05'),
(13, 108, 105, 1, '2026-02-01 21:07:35', '2026-02-01 21:07:35'),
(13, 109, 106, 1, '2026-02-01 21:08:51', '2026-02-01 21:08:51'),
(13, 110, 107, 1, '2026-02-01 21:09:57', '2026-02-01 21:09:57'),
(13, 111, 108, 1, '2026-02-01 21:10:46', '2026-02-01 21:10:46'),
(13, 112, 109, 1, '2026-02-01 21:11:40', '2026-02-01 21:11:40'),
(14, 113, 110, 1, '2026-02-01 21:50:48', '2026-02-01 21:50:48'),
(14, 115, 111, 1, '2026-02-01 21:51:51', '2026-02-01 21:51:51'),
(14, 114, 112, 1, '2026-02-01 21:52:44', '2026-02-01 21:52:44'),
(14, 116, 113, 1, '2026-02-01 21:53:51', '2026-02-01 21:53:51'),
(14, 117, 114, 1, '2026-02-01 21:55:16', '2026-02-01 21:55:16'),
(14, 118, 115, 1, '2026-02-01 21:56:15', '2026-02-01 21:56:15'),
(15, 119, 116, 1, '2026-02-01 23:43:38', '2026-02-01 23:43:38'),
(15, 120, 117, 1, '2026-02-01 23:44:35', '2026-02-01 23:44:35'),
(15, 121, 118, 1, '2026-02-01 23:45:44', '2026-02-01 23:45:44'),
(15, 122, 119, 1, '2026-02-01 23:47:04', '2026-02-01 23:47:04'),
(15, 123, 120, 1, '2026-02-01 23:48:14', '2026-02-01 23:48:14'),
(15, 124, 121, 1, '2026-02-01 23:49:35', '2026-02-01 23:49:35'),
(16, 125, 15, 0, '2026-02-02 12:25:40', '2026-02-02 12:25:40'),
(16, 126, 16, 1, '2026-02-02 17:02:08', '2026-02-02 17:02:08'),
(16, 127, 17, 1, '2026-02-02 17:03:51', '2026-02-02 17:03:51'),
(16, 128, 18, 1, '2026-02-02 17:05:14', '2026-02-02 17:05:14'),
(16, 129, 19, 1, '2026-02-02 17:09:39', '2026-02-02 17:09:39'),
(16, 130, 20, 1, '2026-02-02 17:15:04', '2026-02-02 17:15:04'),
(16, 131, 21, 1, '2026-02-02 17:16:17', '2026-02-02 17:16:17'),
(16, 132, 22, 1, '2026-02-02 17:17:12', '2026-02-02 17:17:12'),
(16, 133, 23, 1, '2026-02-02 17:18:00', '2026-02-02 17:18:00'),
(16, 125, 15, 1, '2026-02-02 17:18:48', '2026-02-02 17:18:48'),
(17, 134, 131, 1, '2026-02-03 06:43:49', '2026-02-03 06:43:49'),
(17, 135, 132, 1, '2026-02-03 06:44:44', '2026-02-03 06:44:44'),
(17, 136, 133, 1, '2026-02-03 06:46:21', '2026-02-03 06:46:21'),
(17, 137, 134, 1, '2026-02-03 06:47:38', '2026-02-03 06:47:38'),
(18, 139, 135, 1, '2026-02-03 09:14:46', '2026-02-03 09:14:46'),
(18, 140, 136, 1, '2026-02-03 09:15:46', '2026-02-03 09:15:46'),
(18, 141, 137, 1, '2026-02-03 09:17:41', '2026-02-03 09:17:41'),
(18, 142, 138, 1, '2026-02-03 09:18:57', '2026-02-03 09:18:57'),
(18, 143, 139, 1, '2026-02-03 09:20:07', '2026-02-03 09:20:07'),
(18, 144, 140, 1, '2026-02-03 09:21:24', '2026-02-03 09:21:24'),
(18, 145, 141, 1, '2026-02-03 09:24:46', '2026-02-03 09:24:46'),
(18, 146, 142, 1, '2026-02-03 09:25:48', '2026-02-03 09:25:48'),
(18, 147, 143, 1, '2026-02-03 09:27:13', '2026-02-03 09:27:13'),
(18, 148, 144, 1, '2026-02-03 09:29:12', '2026-02-03 09:29:12'),
(19, 149, 145, 1, '2026-02-03 14:18:01', '2026-02-03 14:18:01'),
(19, 150, 146, 1, '2026-02-03 14:20:00', '2026-02-03 14:20:00'),
(19, 151, 147, 1, '2026-02-03 14:21:26', '2026-02-03 14:21:26'),
(19, 152, 148, 1, '2026-02-03 14:22:44', '2026-02-03 14:22:44'),
(20, 154, 150, 1, '2026-02-03 19:53:43', '2026-02-03 19:53:43'),
(20, 155, 151, 1, '2026-02-03 19:54:41', '2026-02-03 19:54:41'),
(20, 156, 152, 1, '2026-02-03 19:55:46', '2026-02-03 19:55:46'),
(20, 157, 153, 1, '2026-02-03 19:59:52', '2026-02-03 19:59:52'),
(21, 158, 68, 1, '2026-02-03 20:30:11', '2026-02-03 20:30:11'),
(21, 159, 155, 1, '2026-02-03 20:32:24', '2026-02-03 20:32:24'),
(21, 160, 73, 1, '2026-02-03 20:33:32', '2026-02-03 20:33:32'),
(21, 161, 157, 1, '2026-02-03 20:34:38', '2026-02-03 20:34:38'),
(21, 162, 77, 1, '2026-02-03 20:37:56', '2026-02-03 20:37:56'),
(22, 163, 159, 1, '2026-02-05 06:24:59', '2026-02-05 06:24:59'),
(22, 164, 160, 1, '2026-02-05 06:26:41', '2026-02-05 06:26:41'),
(22, 165, 161, 1, '2026-02-05 06:27:56', '2026-02-05 06:27:56'),
(22, 166, 162, 1, '2026-02-05 06:29:03', '2026-02-05 06:29:03'),
(22, 167, 163, 1, '2026-02-05 06:30:32', '2026-02-05 06:30:32'),
(22, 168, 164, 1, '2026-02-05 06:31:39', '2026-02-05 06:31:39'),
(22, 169, 165, 1, '2026-02-05 06:32:41', '2026-02-05 06:32:41'),
(22, 170, 166, 1, '2026-02-05 06:33:42', '2026-02-05 06:33:42'),
(23, 171, 167, 1, '2026-02-05 08:52:35', '2026-02-05 08:52:35'),
(23, 172, 168, 1, '2026-02-05 08:53:33', '2026-02-05 08:53:33'),
(23, 173, 169, 1, '2026-02-05 09:15:57', '2026-02-05 09:15:57'),
(23, 174, 170, 1, '2026-02-05 09:20:10', '2026-02-05 09:20:10'),
(23, 175, 171, 1, '2026-02-05 09:20:54', '2026-02-05 09:20:54'),
(23, 176, 172, 1, '2026-02-05 09:21:48', '2026-02-05 09:21:48'),
(23, 177, 173, 1, '2026-02-05 09:22:29', '2026-02-05 09:22:29'),
(23, 178, 174, 1, '2026-02-05 09:23:12', '2026-02-05 09:23:12'),
(23, 179, 175, 1, '2026-02-05 09:24:07', '2026-02-05 09:24:07'),
(23, 180, 176, 1, '2026-02-05 09:25:28', '2026-02-05 09:25:28'),
(23, 181, 177, 1, '2026-02-05 09:26:18', '2026-02-05 09:26:18'),
(23, 182, 178, 1, '2026-02-05 09:27:23', '2026-02-05 09:27:23'),
(23, 184, 180, 1, '2026-02-05 09:29:01', '2026-02-05 09:29:01'),
(23, 186, 182, 1, '2026-02-05 09:29:51', '2026-02-05 09:29:51'),
(24, 189, 183, 1, '2026-02-05 10:46:03', '2026-02-05 10:46:03'),
(24, 188, 184, 1, '2026-02-05 10:47:04', '2026-02-05 10:47:04'),
(24, 187, 183, 1, '2026-02-05 11:16:56', '2026-02-05 11:16:56'),
(24, 189, 185, 1, '2026-02-05 11:18:55', '2026-02-05 11:18:55'),
(24, 190, 186, 1, '2026-02-05 11:19:43', '2026-02-05 11:19:43'),
(24, 191, 187, 1, '2026-02-05 11:20:37', '2026-02-05 11:20:37'),
(24, 192, 188, 1, '2026-02-05 11:21:48', '2026-02-05 11:21:48'),
(24, 193, 189, 1, '2026-02-05 11:22:55', '2026-02-05 11:22:55'),
(24, 194, 190, 1, '2026-02-05 11:23:51', '2026-02-05 11:23:51'),
(24, 195, 191, 1, '2026-02-05 11:24:58', '2026-02-05 11:24:58'),
(24, 196, 192, 1, '2026-02-05 11:25:53', '2026-02-05 11:25:53'),
(24, 197, 193, 1, '2026-02-05 11:26:37', '2026-02-05 11:26:37'),
(24, 198, 194, 1, '2026-02-05 11:28:11', '2026-02-05 11:28:11');

-- --------------------------------------------------------

--
-- Table structure for table `system_logs`
--

CREATE TABLE `system_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `entity` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `action` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ip_address` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `system_logs`
--

INSERT INTO `system_logs` (`id`, `user_id`, `entity`, `action`, `ip_address`, `created_at`) VALUES
(1, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2025-10-15 09:56:48'),
(2, 2, 'Login', 'user hillaryW Logged in', '::1', '2025-10-15 09:56:55'),
(3, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2025-10-15 09:58:36'),
(4, 1, 'Login', 'user Mkirimi Logged in', '::1', '2025-10-15 09:59:00'),
(5, 1, 'Logout', 'user admin Logged out', 'NA', '2025-10-15 10:04:13'),
(6, 1, 'Login', 'user admin Logged in', '::1', '2025-10-15 10:04:23'),
(7, 2, 'Company', 'added a new company', '::1', '2025-10-15 10:08:49'),
(8, 1, 'Login', 'user admin Logged in', '127.0.0.1', '2025-10-15 10:12:02'),
(9, 1, 'Login', 'user admin Logged in', '127.0.0.1', '2025-10-15 11:04:24'),
(10, 1, 'Entity', 'added new Entity', '127.0.0.1', '2025-10-15 11:05:04'),
(11, 1, 'Logout', 'user admin Logged out', 'NA', '2025-10-15 11:05:22'),
(12, 2, 'Login', 'user hillaryW Logged in', '127.0.0.1', '2025-10-15 11:06:03'),
(13, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2025-10-15 11:06:35'),
(14, 1, 'Login', 'user admin Logged in', '127.0.0.1', '2025-10-15 11:07:28'),
(15, 1, 'Entity', 'added new Entity', '127.0.0.1', '2025-10-15 11:21:24'),
(16, 1, 'Entity', 'added new Entity', '127.0.0.1', '2025-10-15 11:22:06'),
(17, 1, 'Entity', 'added new Entity', '127.0.0.1', '2025-10-15 11:23:12'),
(18, 1, 'Entity', 'added new Entity', '127.0.0.1', '2025-10-15 11:23:57'),
(19, 1, 'Entity', 'added new Entity', '127.0.0.1', '2025-10-15 11:25:22'),
(20, 1, 'Entity', 'added new Entity', '127.0.0.1', '2025-10-15 11:25:58'),
(21, 1, 'Entity', 'added new Entity', '127.0.0.1', '2025-10-15 11:27:00'),
(22, 1, 'Entity', 'added new Entity', '127.0.0.1', '2025-10-15 11:27:58'),
(23, 1, 'Logout', 'user admin Logged out', 'NA', '2025-10-15 11:28:04'),
(24, 2, 'Login', 'user hillaryW Logged in', '127.0.0.1', '2025-10-15 11:28:17'),
(25, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2025-10-15 11:30:20'),
(26, 1, 'Login', 'user admin Logged in', '127.0.0.1', '2025-10-15 11:30:32'),
(27, 1, 'Risk Category', 'Added risk category', '127.0.0.1', '2025-10-15 11:31:19'),
(28, 1, 'Risk Category', 'Added risk category', '127.0.0.1', '2025-10-15 11:39:49'),
(29, 1, 'Risk Category', 'Added risk category', '127.0.0.1', '2025-10-15 11:40:06'),
(30, 1, 'Risk Category', 'Added risk category', '127.0.0.1', '2025-10-15 11:40:24'),
(31, 1, 'Risk Category', 'Added risk category', '127.0.0.1', '2025-10-15 11:40:41'),
(32, 1, 'Risk Category', 'Added risk category', '127.0.0.1', '2025-10-15 11:41:07'),
(33, 1, 'IMPACT', 'added impact level', '127.0.0.1', '2025-10-15 11:42:30'),
(34, 1, 'IMPACT', 'added impact level', '127.0.0.1', '2025-10-15 11:43:11'),
(35, 1, 'IMPACT', 'added impact level', '127.0.0.1', '2025-10-15 11:43:52'),
(36, 1, 'IMPACT', 'added impact level', '127.0.0.1', '2025-10-15 11:44:30'),
(37, 1, 'IMPACT', 'added impact level', '127.0.0.1', '2025-10-15 11:45:13'),
(38, 1, 'Likelihood', 'Added likelihood', '127.0.0.1', '2025-10-15 11:46:43'),
(39, 1, 'Likelihood', 'Added likelihood', '127.0.0.1', '2025-10-15 11:57:22'),
(40, 1, 'Likelihood', 'Added likelihood', '127.0.0.1', '2025-10-15 12:10:27'),
(41, 1, 'Likelihood', 'Added likelihood', '127.0.0.1', '2025-10-15 12:12:46'),
(42, 1, 'Likelihood', 'Added likelihood', '127.0.0.1', '2025-10-15 12:14:36'),
(43, 1, 'Control Type', 'Added Control Type', '127.0.0.1', '2025-10-15 12:26:43'),
(44, 1, 'Control Type', 'Added Control Type', '127.0.0.1', '2025-10-15 12:27:08'),
(45, 1, 'Control Type', 'Added Control Type', '127.0.0.1', '2025-10-15 12:27:30'),
(46, 1, 'control strength', 'Added Control strength', '127.0.0.1', '2025-10-15 12:28:01'),
(47, 1, 'control strength', 'Added Control strength', '127.0.0.1', '2025-10-15 12:28:22'),
(48, 1, 'control strength', 'Added Control strength', '127.0.0.1', '2025-10-15 12:28:59'),
(49, 1, 'control strength', 'Added Control strength', '127.0.0.1', '2025-10-15 12:29:21'),
(50, 1, 'Process', 'Added Process', '127.0.0.1', '2025-10-15 12:32:03'),
(51, 1, 'Process', 'Added Process', '127.0.0.1', '2025-10-15 12:33:41'),
(52, 1, 'Process', 'Added Process', '127.0.0.1', '2025-10-15 12:34:13'),
(53, 1, 'Process', 'Added Process', '127.0.0.1', '2025-10-15 12:34:39'),
(54, 1, 'Process', 'Added Process', '127.0.0.1', '2025-10-15 12:34:58'),
(55, 1, 'Process', 'Added Process', '127.0.0.1', '2025-10-15 12:35:30'),
(56, 1, 'Risk', 'Added risk', '127.0.0.1', '2025-10-15 12:38:28'),
(57, 1, 'Login', 'user admin Logged in', '127.0.0.1', '2025-10-15 13:23:21'),
(58, 1, 'Risk', 'Added risk', '127.0.0.1', '2025-10-15 13:38:25'),
(59, 1, 'Risk', 'Added risk', '127.0.0.1', '2025-10-15 13:39:33'),
(60, 1, 'Risk', 'Added risk', '127.0.0.1', '2025-10-15 13:41:10'),
(61, 1, 'Risk', 'Added risk', '127.0.0.1', '2025-10-15 13:43:15'),
(62, 1, 'Risk', 'Added risk', '127.0.0.1', '2025-10-15 13:45:07'),
(63, 1, 'Risk', 'Added risk', '127.0.0.1', '2025-10-15 13:46:37'),
(64, 1, 'Control', 'Added Control', '127.0.0.1', '2025-10-15 13:56:10'),
(65, 1, 'Control', 'Added Control', '127.0.0.1', '2025-10-15 13:57:39'),
(66, 1, 'Control', 'Added Control', '127.0.0.1', '2025-10-15 13:58:33'),
(67, 1, 'Control', 'Added Control', '127.0.0.1', '2025-10-15 13:59:43'),
(68, 1, 'Login', 'user admin Logged in', '127.0.0.1', '2025-10-15 14:05:11'),
(69, 1, 'Control', 'Added Control', '127.0.0.1', '2025-10-15 14:10:14'),
(70, 1, 'Login', 'user admin Logged in', '127.0.0.1', '2025-10-15 14:28:44'),
(71, 1, 'Control', 'Added Control', '127.0.0.1', '2025-10-15 14:29:31'),
(72, 1, 'Control', 'Added Control', '127.0.0.1', '2025-10-15 14:30:24'),
(73, 1, 'Control', 'Added Control', '127.0.0.1', '2025-10-15 14:31:22'),
(74, 1, 'Logout', 'user admin Logged out', 'NA', '2025-10-15 14:33:05'),
(75, 2, 'Login', 'user hillaryW Logged in', '127.0.0.1', '2025-10-15 14:33:27'),
(76, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2025-10-15 14:35:21'),
(77, 1, 'Login', 'user admin Logged in', '127.0.0.1', '2025-10-15 14:35:33'),
(78, 1, 'Assessment', 'Added Risk Assessment', '127.0.0.1', '2025-10-15 14:42:20'),
(79, 1, 'Assessment', 'Added Risk Assessment', '127.0.0.1', '2025-10-15 14:44:39'),
(80, 1, 'Assessment', 'Added Risk Assessment', '127.0.0.1', '2025-10-15 14:47:41'),
(81, 1, 'Assessment', 'Added Risk Assessment', '127.0.0.1', '2025-10-15 14:48:59'),
(82, 1, 'Assessment', 'Added Risk Assessment', '127.0.0.1', '2025-10-15 14:51:09'),
(83, 1, 'Assessment', 'Added Risk Assessment', '127.0.0.1', '2025-10-15 14:52:44'),
(84, 1, 'Assessment', 'Added Risk Assessment', '127.0.0.1', '2025-10-15 14:56:12'),
(85, 1, 'Risk', 'Added risk', '127.0.0.1', '2025-10-15 14:57:37'),
(86, 1, 'Logout', 'user admin Logged out', 'NA', '2025-10-15 14:58:09'),
(87, 2, 'Login', 'user hillaryW Logged in', '127.0.0.1', '2025-10-15 14:58:23'),
(88, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2025-10-15 14:58:39'),
(89, 1, 'Login', 'user admin Logged in', '127.0.0.1', '2025-10-15 14:58:54'),
(90, 1, 'Assessment', 'Added Risk Assessment', '127.0.0.1', '2025-10-15 15:04:50'),
(91, 1, 'Action', 'Added Action', '127.0.0.1', '2025-10-15 15:12:58'),
(92, 1, 'Treatment', 'Mitigated Risk Assessment', '127.0.0.1', '2025-10-15 15:13:36'),
(93, 1, 'Treatment', 'Mitigated Risk Assessment', '127.0.0.1', '2025-10-15 15:13:52'),
(94, 1, 'Treatment', 'Mitigated Risk Assessment', '127.0.0.1', '2025-10-15 15:14:05'),
(95, 1, 'Treatment', 'Mitigated Risk Assessment', '127.0.0.1', '2025-10-15 15:15:34'),
(96, 1, 'Treatment', 'Mitigated Risk Assessment', '127.0.0.1', '2025-10-15 15:15:46'),
(97, 1, 'Treatment', 'Mitigated Risk Assessment', '127.0.0.1', '2025-10-15 15:15:59'),
(98, 1, 'Treatment', 'Mitigated Risk Assessment', '127.0.0.1', '2025-10-15 15:16:15'),
(99, 1, 'Treatment', 'Mitigated Risk Assessment', '127.0.0.1', '2025-10-15 15:16:40'),
(100, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-15 12:30:34'),
(101, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-17 08:42:29'),
(102, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-18 03:43:36'),
(103, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-20 07:49:33'),
(104, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-20 08:18:56'),
(105, 1, 'Login', 'user Mkirimi Logged in', '102.135.172.111', '2025-10-20 09:24:30'),
(106, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2025-10-20 09:30:23'),
(107, 1, 'Login', 'user Mkirimi Logged in', '102.135.172.111', '2025-10-20 09:34:12'),
(108, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2025-10-20 09:34:40'),
(109, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-20 09:35:13'),
(110, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2025-10-20 09:36:50'),
(111, 1, 'Login', 'user Mkirimi Logged in', '102.135.172.111', '2025-10-20 09:37:00'),
(112, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-20 09:59:21'),
(113, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-20 10:00:52'),
(114, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2025-10-20 10:01:54'),
(115, 1, 'Login', 'user Mkirimi Logged in', '102.135.172.111', '2025-10-20 10:02:02'),
(116, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2025-10-20 10:07:22'),
(117, 1, 'Login', 'user Mkirimi Logged in', '102.135.172.111', '2025-10-20 10:07:33'),
(118, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2025-10-20 10:09:49'),
(119, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-20 10:09:57'),
(120, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2025-10-20 10:10:31'),
(121, 1, 'Login', 'user Mkirimi Logged in', '102.135.172.111', '2025-10-20 10:10:41'),
(122, 1, 'Login', 'user Mkirimi Logged in', '102.135.172.111', '2025-10-20 10:13:03'),
(123, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2025-10-20 10:19:33'),
(124, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-20 10:20:05'),
(125, 4, 'Login', 'user Nkosgei Logged in', '156.0.232.23', '2025-10-21 08:51:33'),
(126, 2, 'Login', 'user hillaryW Logged in', '197.248.204.191', '2025-10-21 09:17:45'),
(127, 1, 'Login', 'user Mkirimi Logged in', '197.248.204.191', '2025-10-21 12:03:54'),
(128, 4, 'Login', 'user Nkosgei Logged in', '156.0.232.51', '2025-10-22 11:43:57'),
(129, 4, 'Login', 'user Nkosgei Logged in', '156.0.232.51', '2025-10-22 13:08:33'),
(130, 4, 'Login', 'user Nkosgei Logged in', '156.0.232.51', '2025-10-22 13:08:36'),
(131, 4, 'Login', 'user Nkosgei Logged in', '156.0.232.23', '2025-10-23 09:31:40'),
(132, 4, 'Logout', 'user Nkosgei Logged out', 'NA', '2025-10-23 09:32:05'),
(133, 2, 'Login', 'user hillaryW Logged in', '197.248.204.191', '2025-10-27 11:04:09'),
(134, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2025-10-27 11:07:54'),
(135, 4, 'Login', 'user Nkosgei Logged in', '156.0.232.23', '2025-10-27 13:21:52'),
(136, 4, 'Logout', 'user Nkosgei Logged out', 'NA', '2025-10-27 13:36:25'),
(137, 2, 'Login', 'user hillaryW Logged in', '41.220.112.50', '2025-10-27 19:12:53'),
(138, 2, 'Login', 'user hillaryW Logged in', '41.220.112.50', '2025-10-27 19:21:30'),
(139, 2, 'Login', 'user hillaryW Logged in', '102.135.172.111', '2025-10-29 19:46:52'),
(140, 2, 'Login', 'user hillaryW Logged in', '41.209.14.82', '2025-10-30 04:09:44'),
(141, 2, 'Login', 'user hillaryW Logged in', '127.0.0.1', '2025-10-30 11:27:44'),
(142, 2, 'Login', 'user hillaryW Logged in', '127.0.0.1', '2025-10-30 13:01:35'),
(143, 2, 'Login', 'user hillaryW Logged in', '127.0.0.1', '2026-01-26 13:46:06'),
(144, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-01-26 13:55:08'),
(145, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-26 13:55:15'),
(146, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-27 12:00:52'),
(147, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-27 12:01:10'),
(148, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-27 17:35:13'),
(149, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-29 08:06:03'),
(150, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-29 08:14:09'),
(151, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-29 11:44:25'),
(152, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-29 11:44:45'),
(153, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-29 11:47:12'),
(154, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-01-29 11:48:31'),
(155, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-29 11:48:53'),
(156, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-29 17:29:37'),
(157, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-29 17:57:42'),
(158, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-01-29 17:58:25'),
(159, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-29 17:58:34'),
(160, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:00:37'),
(161, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-29 18:03:02'),
(162, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:05:43'),
(163, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:06:39'),
(164, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:07:24'),
(165, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:07:59'),
(166, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:08:29'),
(167, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:09:01'),
(168, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:09:29'),
(169, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:09:59'),
(170, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:10:29'),
(171, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:10:58'),
(172, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:11:34'),
(173, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:11:57'),
(174, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:12:37'),
(175, 1, 'Entity', 'added new Entity', '::1', '2026-01-29 18:13:01'),
(176, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-01-30 06:19:46'),
(177, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-30 06:19:55'),
(178, 1, 'Process', 'Added Process', '::1', '2026-01-30 06:27:34'),
(179, 1, 'Process', 'Added Process', '::1', '2026-01-30 06:27:34'),
(180, 1, 'Process', 'Added Process', '::1', '2026-01-30 06:28:11'),
(181, 1, 'Process', 'Added Process', '::1', '2026-01-30 06:28:34'),
(182, 1, 'Process', 'Added Process', '::1', '2026-01-30 06:28:55'),
(183, 1, 'Process', 'Added Process', '::1', '2026-01-30 06:30:40'),
(184, 1, 'Process', 'Added Process', '::1', '2026-01-30 06:31:02'),
(185, 1, 'Process', 'Added Process', '::1', '2026-01-30 06:31:35'),
(186, 1, 'Process', 'Added Process', '::1', '2026-01-30 06:31:55'),
(187, 1, 'Risk', 'Added risk', '::1', '2026-01-30 06:54:36'),
(188, 1, 'Risk', 'Added risk', '::1', '2026-01-30 06:54:36'),
(189, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-30 06:54:49'),
(190, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-30 08:14:44'),
(191, 1, 'Risk', 'Added risk', '::1', '2026-01-30 08:17:18'),
(192, 1, 'Risk', 'Added risk', '::1', '2026-01-30 08:22:23'),
(193, 1, 'Risk', 'Added risk', '::1', '2026-01-30 08:23:51'),
(194, 1, 'Risk', 'Added risk', '::1', '2026-01-30 08:25:11'),
(195, 1, 'Risk', 'Added risk', '::1', '2026-01-30 08:26:47'),
(196, 1, 'Risk', 'Added risk', '::1', '2026-01-30 08:28:00'),
(197, 1, 'Risk', 'Added risk', '::1', '2026-01-30 08:29:04'),
(198, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-30 08:36:44'),
(199, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-30 12:27:34'),
(200, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-30 13:18:10'),
(201, 1, 'Control', 'Added Control', '::1', '2026-01-30 13:30:42'),
(202, 1, 'Control', 'Added Control', '::1', '2026-01-30 13:32:20'),
(203, 1, 'Control', 'Added Control', '::1', '2026-01-30 13:34:24'),
(204, 1, 'Control', 'Added Control', '::1', '2026-01-30 13:44:14'),
(205, 1, 'Control', 'Added Control', '::1', '2026-01-30 13:44:14'),
(206, 1, 'Control', 'Added Control', '::1', '2026-01-30 13:46:51'),
(207, 1, 'Control', 'Added Control', '::1', '2026-01-30 13:51:41'),
(208, 1, 'Control', 'Added Control', '::1', '2026-01-30 13:53:44'),
(209, 1, 'Control', 'Added Control', '::1', '2026-01-30 13:54:35'),
(210, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-30 14:13:01'),
(211, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-30 14:20:03'),
(212, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-30 14:31:42'),
(213, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-31 17:53:03'),
(214, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-31 18:00:02'),
(215, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-31 18:00:18'),
(216, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 18:04:30'),
(217, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 18:05:44'),
(218, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 18:06:47'),
(219, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 18:07:46'),
(220, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 18:08:45'),
(221, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 18:10:01'),
(222, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 18:10:49'),
(223, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-31 18:45:23'),
(224, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-01-31 18:50:57'),
(225, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-31 18:51:08'),
(226, 1, 'Process', 'Added Process', '::1', '2026-01-31 18:52:50'),
(227, 1, 'Process', 'Added Process', '::1', '2026-01-31 18:53:07'),
(228, 1, 'Process', 'Added Process', '::1', '2026-01-31 18:53:21'),
(229, 1, 'Process', 'Added Process', '::1', '2026-01-31 18:53:36'),
(230, 1, 'Process', 'Added Process', '::1', '2026-01-31 18:53:49'),
(231, 1, 'Process', 'Added Process', '::1', '2026-01-31 18:54:05'),
(232, 1, 'Process', 'Added Process', '::1', '2026-01-31 18:54:25'),
(233, 1, 'Control', 'Added Control', '::1', '2026-01-31 18:56:04'),
(234, 1, 'Control', 'Added Control', '::1', '2026-01-31 18:56:29'),
(235, 1, 'Control', 'Added Control', '::1', '2026-01-31 18:57:27'),
(236, 1, 'Control', 'Added Control', '::1', '2026-01-31 18:58:02'),
(237, 1, 'Control', 'Added Control', '::1', '2026-01-31 18:58:41'),
(238, 1, 'Control', 'Added Control', '::1', '2026-01-31 18:59:26'),
(239, 1, 'Control', 'Added Control', '::1', '2026-01-31 19:00:10'),
(240, 1, 'Control', 'Added Control', '::1', '2026-01-31 19:00:44'),
(241, 1, 'Risk', 'Added risk', '::1', '2026-01-31 19:02:55'),
(242, 1, 'Risk', 'Added risk', '::1', '2026-01-31 19:05:13'),
(243, 1, 'Risk', 'Added risk', '::1', '2026-01-31 19:06:09'),
(244, 1, 'Risk', 'Added risk', '::1', '2026-01-31 19:07:07'),
(245, 1, 'Risk', 'Added risk', '::1', '2026-01-31 19:08:28'),
(246, 1, 'Risk', 'Added risk', '::1', '2026-01-31 19:09:25'),
(247, 1, 'Risk', 'Added risk', '::1', '2026-01-31 19:10:19'),
(248, 1, 'Risk', 'Added risk', '::1', '2026-01-31 19:11:04'),
(249, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-31 19:11:31'),
(250, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-01-31 21:13:24'),
(251, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 21:15:47'),
(252, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 21:17:33'),
(253, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 21:18:55'),
(254, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 21:20:52'),
(255, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 21:22:06'),
(256, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 21:23:13'),
(257, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 21:24:21'),
(258, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-01-31 21:25:12'),
(259, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-01-31 21:25:30'),
(260, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-01 20:35:09'),
(261, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-01 20:35:27'),
(262, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-01 20:42:37'),
(263, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-01 20:42:47'),
(264, 1, 'Process', 'Added Process', '::1', '2026-02-01 20:43:47'),
(265, 1, 'Process', 'Added Process', '::1', '2026-02-01 20:44:00'),
(266, 1, 'Process', 'Added Process', '::1', '2026-02-01 20:44:19'),
(267, 1, 'Process', 'Added Process', '::1', '2026-02-01 20:44:31'),
(268, 1, 'Process', 'Added Process', '::1', '2026-02-01 20:44:59'),
(269, 1, 'Process', 'Added Process', '::1', '2026-02-01 20:45:19'),
(270, 1, 'Risk', 'Added risk', '::1', '2026-02-01 20:47:15'),
(271, 1, 'Risk', 'Added risk', '::1', '2026-02-01 20:48:16'),
(272, 1, 'Risk', 'Added risk', '::1', '2026-02-01 20:49:09'),
(273, 1, 'Risk', 'Added risk', '::1', '2026-02-01 20:50:10'),
(274, 1, 'Risk', 'Added risk', '::1', '2026-02-01 20:51:54'),
(275, 1, 'Risk', 'Added risk', '::1', '2026-02-01 20:52:58'),
(276, 1, 'Control', 'Added Control', '::1', '2026-02-01 20:54:53'),
(277, 1, 'Control', 'Added Control', '::1', '2026-02-01 20:55:47'),
(278, 1, 'Control', 'Added Control', '::1', '2026-02-01 20:56:28'),
(279, 1, 'Control', 'Added Control', '::1', '2026-02-01 20:57:16'),
(280, 1, 'Control', 'Added Control', '::1', '2026-02-01 20:58:53'),
(281, 1, 'Control', 'Added Control', '::1', '2026-02-01 21:00:57'),
(282, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-01 21:01:16'),
(283, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:06:05'),
(284, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:07:35'),
(285, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:08:51'),
(286, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:09:57'),
(287, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:10:46'),
(288, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:11:40'),
(289, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-01 21:16:37'),
(290, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-01 21:16:49'),
(291, 1, 'Process', 'Added Process', '::1', '2026-02-01 21:22:59'),
(292, 1, 'Process', 'Added Process', '::1', '2026-02-01 21:23:24'),
(293, 1, 'Process', 'Added Process', '::1', '2026-02-01 21:23:38'),
(294, 1, 'Process', 'Added Process', '::1', '2026-02-01 21:23:52'),
(295, 1, 'Process', 'Added Process', '::1', '2026-02-01 21:24:07'),
(296, 1, 'Process', 'Added Process', '::1', '2026-02-01 21:27:32'),
(297, 1, 'Risk Category', 'Added risk category', '::1', '2026-02-01 21:29:34'),
(298, 1, 'Risk', 'Added risk', '::1', '2026-02-01 21:30:52'),
(299, 1, 'Risk', 'Added risk', '::1', '2026-02-01 21:33:09'),
(300, 1, 'Risk', 'Added risk', '::1', '2026-02-01 21:35:47'),
(301, 1, 'Risk', 'Added risk', '::1', '2026-02-01 21:36:45'),
(302, 1, 'Risk', 'Added risk', '::1', '2026-02-01 21:37:44'),
(303, 1, 'Risk', 'Added risk', '::1', '2026-02-01 21:39:02'),
(304, 1, 'Control', 'Added Control', '::1', '2026-02-01 21:40:25'),
(305, 1, 'Control', 'Added Control', '::1', '2026-02-01 21:42:06'),
(306, 1, 'Control', 'Added Control', '::1', '2026-02-01 21:43:06'),
(307, 1, 'Control', 'Added Control', '::1', '2026-02-01 21:44:20'),
(308, 1, 'Control', 'Added Control', '::1', '2026-02-01 21:45:08'),
(309, 1, 'Control', 'Added Control', '::1', '2026-02-01 21:46:17'),
(310, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-01 21:47:14'),
(311, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:50:48'),
(312, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:51:51'),
(313, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:52:44'),
(314, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:53:51'),
(315, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:55:16'),
(316, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 21:56:15'),
(317, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-01 23:00:33'),
(318, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-01 23:00:47'),
(319, 1, 'Process', 'Added Process', '::1', '2026-02-01 23:01:14'),
(320, 1, 'Process', 'Added Process', '::1', '2026-02-01 23:01:36'),
(321, 1, 'Process', 'Added Process', '::1', '2026-02-01 23:01:52'),
(322, 1, 'Process', 'Added Process', '::1', '2026-02-01 23:02:07'),
(323, 1, 'Risk', 'Added risk', '::1', '2026-02-01 23:03:24'),
(324, 1, 'Risk', 'Added risk', '::1', '2026-02-01 23:04:24'),
(325, 1, 'Risk', 'Added risk', '::1', '2026-02-01 23:05:12'),
(326, 1, 'Risk', 'Added risk', '::1', '2026-02-01 23:06:09'),
(327, 1, 'Risk', 'Added risk', '::1', '2026-02-01 23:07:04'),
(328, 1, 'Risk', 'Added risk', '::1', '2026-02-01 23:07:50'),
(329, 1, 'Control', 'Added Control', '::1', '2026-02-01 23:19:24'),
(330, 1, 'Control', 'Added Control', '::1', '2026-02-01 23:20:15'),
(331, 1, 'Control', 'Added Control', '::1', '2026-02-01 23:21:05'),
(332, 1, 'Control', 'Added Control', '::1', '2026-02-01 23:24:31'),
(333, 1, 'Control', 'Added Control', '::1', '2026-02-01 23:25:19'),
(334, 1, 'Control', 'Added Control', '::1', '2026-02-01 23:26:00'),
(335, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-02-01 23:26:13'),
(336, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-01 23:26:21'),
(337, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-01 23:42:41'),
(338, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 23:43:38'),
(339, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 23:44:35'),
(340, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 23:45:44'),
(341, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 23:47:04'),
(342, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 23:48:14'),
(343, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-01 23:49:35'),
(344, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-02 08:42:12'),
(345, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-02 11:43:06'),
(346, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-02 11:54:56'),
(347, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-02 11:55:53'),
(348, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-02 11:56:02'),
(349, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-02 11:58:25'),
(350, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-02 11:58:34'),
(351, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-02 11:59:06'),
(352, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-02 11:59:12'),
(353, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-02 11:59:20'),
(354, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-02 11:59:39'),
(355, 1, 'Process', 'Added Process', '::1', '2026-02-02 12:00:41'),
(356, 1, 'Process', 'Added Process', '::1', '2026-02-02 12:01:07'),
(357, 1, 'Process', 'Added Process', '::1', '2026-02-02 12:01:22'),
(358, 1, 'Process', 'Added Process', '::1', '2026-02-02 12:01:39'),
(359, 1, 'Process', 'Added Process', '::1', '2026-02-02 12:01:53'),
(360, 1, 'Process', 'Added Process', '::1', '2026-02-02 12:02:05'),
(361, 1, 'Risk', 'Added risk', '::1', '2026-02-02 12:04:18'),
(362, 1, 'Risk', 'Added risk', '::1', '2026-02-02 12:05:08'),
(363, 1, 'Risk', 'Added risk', '::1', '2026-02-02 12:06:02'),
(364, 1, 'Risk', 'Added risk', '::1', '2026-02-02 12:07:00'),
(365, 1, 'Risk', 'Added risk', '::1', '2026-02-02 12:08:46'),
(366, 1, 'Risk', 'Added risk', '::1', '2026-02-02 12:09:41'),
(367, 1, 'Risk', 'Added risk', '::1', '2026-02-02 12:10:43'),
(368, 1, 'Risk', 'Added risk', '::1', '2026-02-02 12:11:57'),
(369, 1, 'Risk', 'Added risk', '::1', '2026-02-02 12:12:48'),
(370, 1, 'Control', 'Added Control', '::1', '2026-02-02 12:16:17'),
(371, 1, 'Control', 'Added Control', '::1', '2026-02-02 12:16:49'),
(372, 1, 'Control', 'Added Control', '::1', '2026-02-02 12:17:42'),
(373, 1, 'Control', 'Added Control', '::1', '2026-02-02 12:18:45'),
(374, 1, 'Control', 'Added Control', '::1', '2026-02-02 12:19:27'),
(375, 1, 'Control', 'Added Control', '::1', '2026-02-02 12:21:48'),
(376, 1, 'Control', 'Added Control', '::1', '2026-02-02 12:22:29'),
(377, 1, 'Control', 'Added Control', '::1', '2026-02-02 12:23:06'),
(378, 1, 'Control', 'Added Control', '::1', '2026-02-02 12:23:55'),
(379, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 12:25:40'),
(380, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-02 12:30:40'),
(381, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-02 16:59:55'),
(382, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 17:02:08'),
(383, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 17:03:51'),
(384, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 17:05:14'),
(385, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 17:09:39'),
(386, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 17:15:04'),
(387, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 17:16:17'),
(388, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 17:17:12'),
(389, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 17:18:00'),
(390, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-02 17:18:48'),
(391, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-02 17:37:24'),
(392, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-02 17:37:35'),
(393, 1, 'Process', 'Added Process', '::1', '2026-02-02 17:39:31'),
(394, 1, 'Process', 'Added Process', '::1', '2026-02-02 17:39:48'),
(395, 1, 'Process', 'Added Process', '::1', '2026-02-02 17:40:15'),
(396, 1, 'Process', 'Added Process', '::1', '2026-02-02 17:40:29'),
(397, 1, 'Process', 'Added Process', '::1', '2026-02-02 17:40:49'),
(398, 1, 'Risk', 'Added risk', '::1', '2026-02-02 17:43:29'),
(399, 1, 'Risk', 'Added risk', '::1', '2026-02-02 17:44:42'),
(400, 1, 'Risk', 'Added risk', '::1', '2026-02-02 17:47:16'),
(401, 1, 'Risk', 'Added risk', '::1', '2026-02-02 17:48:55'),
(402, 1, 'Risk', 'Added risk', '::1', '2026-02-02 17:51:24'),
(403, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 05:55:35'),
(404, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-03 05:57:08'),
(405, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 06:35:22'),
(406, 1, 'Control', 'Added Control', '::1', '2026-02-03 06:37:19'),
(407, 1, 'Control', 'Added Control', '::1', '2026-02-03 06:38:10'),
(408, 1, 'Control', 'Added Control', '::1', '2026-02-03 06:39:21'),
(409, 1, 'Control', 'Added Control', '::1', '2026-02-03 06:40:06'),
(410, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-03 06:42:05'),
(411, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 06:43:49'),
(412, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 06:44:44'),
(413, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 06:46:21'),
(414, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 06:47:38'),
(415, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-03 06:48:24'),
(416, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 06:48:36'),
(417, 1, 'Process', 'Added Process', '::1', '2026-02-03 06:49:49'),
(418, 1, 'Process', 'Added Process', '::1', '2026-02-03 06:50:18'),
(419, 1, 'Process', 'Added Process', '::1', '2026-02-03 06:51:06'),
(420, 1, 'Process', 'Added Process', '::1', '2026-02-03 06:52:00'),
(421, 1, 'Process', 'Added Process', '::1', '2026-02-03 06:52:33'),
(422, 1, 'Process', 'Added Process', '::1', '2026-02-03 06:52:58'),
(423, 1, 'Risk', 'Added risk', '::1', '2026-02-03 06:56:49'),
(424, 1, 'Risk', 'Added risk', '::1', '2026-02-03 07:09:59'),
(425, 1, 'Risk', 'Added risk', '::1', '2026-02-03 07:10:52'),
(426, 1, 'Risk', 'Added risk', '::1', '2026-02-03 07:12:09'),
(427, 1, 'Risk', 'Added risk', '::1', '2026-02-03 07:13:46'),
(428, 1, 'Risk', 'Added risk', '::1', '2026-02-03 07:14:38'),
(429, 1, 'Risk', 'Added risk', '::1', '2026-02-03 07:15:45'),
(430, 1, 'Risk', 'Added risk', '::1', '2026-02-03 07:17:18'),
(431, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 08:57:32'),
(432, 1, 'Risk', 'Added risk', '::1', '2026-02-03 08:59:52'),
(433, 1, 'Risk', 'Added risk', '::1', '2026-02-03 09:00:39'),
(434, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:02:41'),
(435, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:03:11'),
(436, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:03:47'),
(437, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:04:23'),
(438, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:05:13'),
(439, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:05:49'),
(440, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:06:34'),
(441, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:07:12'),
(442, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:08:07'),
(443, 1, 'Control', 'Added Control', '::1', '2026-02-03 09:08:47'),
(444, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-03 09:09:40'),
(445, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:14:46'),
(446, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:15:46'),
(447, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:17:41'),
(448, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:18:57'),
(449, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:20:07'),
(450, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:21:24'),
(451, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:24:46'),
(452, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:25:48'),
(453, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:27:13'),
(454, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 09:29:12'),
(455, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 12:22:59'),
(456, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-03 12:25:49'),
(457, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 12:25:58'),
(458, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 13:03:26'),
(459, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-03 13:05:31'),
(460, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 13:43:29'),
(461, 1, 'Process', 'Added Process', '::1', '2026-02-03 13:59:16'),
(462, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 13:59:31'),
(463, 1, 'Process', 'Added Process', '::1', '2026-02-03 14:00:12'),
(464, 1, 'Process', 'Added Process', '::1', '2026-02-03 14:00:44'),
(465, 1, 'Process', 'Added Process', '::1', '2026-02-03 14:01:06'),
(466, 1, 'Process', 'Added Process', '::1', '2026-02-03 14:01:29'),
(467, 1, 'Risk', 'Added risk', '::1', '2026-02-03 14:03:40'),
(468, 1, 'Risk', 'Added risk', '::1', '2026-02-03 14:04:31'),
(469, 1, 'Risk', 'Added risk', '::1', '2026-02-03 14:05:29'),
(470, 1, 'Risk', 'Added risk', '::1', '2026-02-03 14:06:48'),
(471, 1, 'Risk', 'Added risk', '::1', '2026-02-03 14:07:58'),
(472, 1, 'Control', 'Added Control', '::1', '2026-02-03 14:09:55'),
(473, 1, 'Control', 'Added Control', '::1', '2026-02-03 14:10:43'),
(474, 1, 'Control', 'Added Control', '::1', '2026-02-03 14:11:40'),
(475, 1, 'Control', 'Added Control', '::1', '2026-02-03 14:12:29'),
(476, 1, 'Control', 'Added Control', '::1', '2026-02-03 14:13:36'),
(477, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-03 14:14:51'),
(478, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 14:18:01'),
(479, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 14:20:00'),
(480, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 14:21:26'),
(481, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 14:22:44'),
(482, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-03 14:27:56'),
(483, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 14:28:35'),
(484, 1, 'Logout', 'user Mkirimi Logged out', 'NA', '2026-02-03 14:32:32'),
(485, 1, 'Login', 'user Mkirimi Logged in', '::1', '2026-02-03 14:32:43'),
(486, 1, 'Logout', 'user SAdmin Logged out', 'NA', '2026-02-03 14:33:52'),
(487, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-03 14:34:04'),
(488, 1, 'Process', 'Added Process', '::1', '2026-02-03 14:39:05'),
(489, 1, 'Process', 'Added Process', '::1', '2026-02-03 14:39:26'),
(490, 1, 'Process', 'Added Process', '::1', '2026-02-03 14:39:41'),
(491, 1, 'Process', 'Added Process', '::1', '2026-02-03 14:40:13'),
(492, 1, 'Risk', 'Added risk', '::1', '2026-02-03 14:41:55'),
(493, 1, 'Risk', 'Added risk', '::1', '2026-02-03 14:42:43'),
(494, 1, 'Risk', 'Added risk', '::1', '2026-02-03 14:44:24'),
(495, 1, 'Risk', 'Added risk', '::1', '2026-02-03 14:57:07'),
(496, 1, 'Control', 'Added Control', '::1', '2026-02-03 14:58:22'),
(497, 1, 'Control', 'Added Control', '::1', '2026-02-03 14:59:14'),
(498, 1, 'Control', 'Added Control', '::1', '2026-02-03 15:00:02'),
(499, 1, 'Control', 'Added Control', '::1', '2026-02-03 15:00:36'),
(500, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-03 15:01:30'),
(501, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-03 18:46:49'),
(502, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-03 19:49:16'),
(503, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 19:53:43'),
(504, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 19:54:41'),
(505, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 19:55:46'),
(506, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 19:59:52'),
(507, 1, 'Logout', 'user SAdmin Logged out', 'NA', '2026-02-03 20:02:25'),
(508, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-03 20:02:36'),
(509, 1, 'Entity', 'edited entity id= ENT0021', '::1', '2026-02-03 20:06:04'),
(510, 1, 'Process', 'Added Process', '::1', '2026-02-03 20:07:22'),
(511, 1, 'Process', 'Added Process', '::1', '2026-02-03 20:08:00'),
(512, 1, 'Process', 'Added Process', '::1', '2026-02-03 20:08:17'),
(513, 1, 'Process', 'Added Process', '::1', '2026-02-03 20:10:27'),
(514, 1, 'Risk', 'Added risk', '::1', '2026-02-03 20:11:31'),
(515, 1, 'Risk', 'Added risk', '::1', '2026-02-03 20:12:35'),
(516, 1, 'Risk', 'Added risk', '::1', '2026-02-03 20:13:39'),
(517, 1, 'Risk', 'Added risk', '::1', '2026-02-03 20:14:36'),
(518, 1, 'Risk', 'Added risk', '::1', '2026-02-03 20:15:32'),
(519, 1, 'Control', 'Added Control', '::1', '2026-02-03 20:18:32'),
(520, 1, 'Control', 'Added Control', '::1', '2026-02-03 20:18:59'),
(521, 1, 'Control', 'Added Control', '::1', '2026-02-03 20:19:47'),
(522, 1, 'Control', 'Added Control', '::1', '2026-02-03 20:21:18'),
(523, 1, 'Control', 'Added Control', '::1', '2026-02-03 20:22:32'),
(524, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-03 20:24:47'),
(525, 1, 'Logout', 'user SAdmin Logged out', 'NA', '2026-02-03 20:25:00'),
(526, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-03 20:25:07'),
(527, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 20:30:11'),
(528, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 20:32:24'),
(529, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 20:33:32'),
(530, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 20:34:38'),
(531, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-03 20:37:56'),
(532, 1, 'Logout', 'user SAdmin Logged out', 'NA', '2026-02-03 20:59:39'),
(533, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-03 20:59:56'),
(534, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-03 21:13:44'),
(535, 1, 'Process', 'Added Process', '::1', '2026-02-03 21:14:46'),
(536, 1, 'Process', 'Added Process', '::1', '2026-02-03 21:15:09'),
(537, 1, 'Process', 'Added Process', '::1', '2026-02-03 21:15:46'),
(538, 1, 'Process', 'Added Process', '::1', '2026-02-03 21:16:12'),
(539, 1, 'Process', 'Added Process', '::1', '2026-02-03 21:16:32'),
(540, 1, 'Process', 'Added Process', '::1', '2026-02-03 21:16:50'),
(541, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-04 22:34:34'),
(542, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-04 22:34:54'),
(543, 1, 'Process', 'Added Process', '::1', '2026-02-04 22:37:41'),
(544, 1, 'Risk', 'Added risk', '::1', '2026-02-04 22:39:35'),
(545, 1, 'Risk', 'Added risk', '::1', '2026-02-04 22:40:39'),
(546, 1, 'Risk', 'Added risk', '::1', '2026-02-04 22:42:05'),
(547, 1, 'Risk', 'Added risk', '::1', '2026-02-04 22:43:15'),
(548, 1, 'Risk', 'Added risk', '::1', '2026-02-04 22:44:37'),
(549, 1, 'Risk', 'Added risk', '::1', '2026-02-04 22:45:52'),
(550, 1, 'Risk', 'Added risk', '::1', '2026-02-04 22:47:06'),
(551, 1, 'Risk', 'Added risk', '::1', '2026-02-04 22:48:13'),
(552, 1, 'Control', 'Added Control', '::1', '2026-02-04 22:50:54'),
(553, 1, 'Control', 'Added Control', '::1', '2026-02-04 22:51:35'),
(554, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-05 05:30:52'),
(555, 1, 'Control', 'Added Control', '::1', '2026-02-05 05:31:49'),
(556, 1, 'Control', 'Added Control', '::1', '2026-02-05 05:43:33'),
(557, 1, 'Control', 'Added Control', '::1', '2026-02-05 05:44:09'),
(558, 1, 'Control', 'Added Control', '::1', '2026-02-05 05:44:56'),
(559, 1, 'Control', 'Added Control', '::1', '2026-02-05 05:45:38'),
(560, 1, 'Control', 'Added Control', '::1', '2026-02-05 05:46:29'),
(561, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-05 06:17:36'),
(562, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-05 06:19:19'),
(563, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 06:24:59'),
(564, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 06:26:41'),
(565, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 06:27:56'),
(566, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 06:29:03'),
(567, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 06:30:32'),
(568, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 06:31:39'),
(569, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 06:32:41'),
(570, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 06:33:42'),
(571, 1, 'Logout', 'user SAdmin Logged out', 'NA', '2026-02-05 06:37:19'),
(572, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-05 06:37:33'),
(573, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:39:51'),
(574, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:40:07'),
(575, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:40:30'),
(576, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:40:46'),
(577, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:41:09'),
(578, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:41:30'),
(579, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:41:48'),
(580, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:42:10'),
(581, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:42:43'),
(582, 1, 'Process', 'Added Process', '::1', '2026-02-05 06:42:57'),
(583, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-05 06:44:50'),
(584, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:48:33'),
(585, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:49:27'),
(586, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:51:02'),
(587, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:52:36'),
(588, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:53:25'),
(589, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:54:17'),
(590, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:54:58'),
(591, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:55:49'),
(592, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:57:03'),
(593, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:57:49'),
(594, 1, 'Risk', 'Added risk', '::1', '2026-02-05 06:58:44'),
(595, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-05 08:01:53'),
(596, 1, 'Risk', 'Added risk', '::1', '2026-02-05 08:03:01'),
(597, 1, 'Risk', 'Added risk', '::1', '2026-02-05 08:03:56'),
(598, 1, 'Risk', 'Added risk', '::1', '2026-02-05 08:04:46'),
(599, 1, 'Risk', 'Added risk', '::1', '2026-02-05 08:05:41'),
(600, 1, 'Risk', 'Added risk', '::1', '2026-02-05 08:06:29'),
(601, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:08:43'),
(602, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:09:14'),
(603, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:09:42'),
(604, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:10:13'),
(605, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:11:07'),
(606, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:11:34'),
(607, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:12:16'),
(608, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:12:56'),
(609, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:13:32'),
(610, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:14:00'),
(611, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:14:36'),
(612, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:15:10'),
(613, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:15:39'),
(614, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:16:10'),
(615, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:16:49'),
(616, 1, 'Controls', 'Edited Control id=CTRL0181', '::1', '2026-02-05 08:21:28'),
(617, 1, 'Control', 'Added Control', '::1', '2026-02-05 08:22:24'),
(618, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-05 08:22:56'),
(619, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-05 08:42:24'),
(620, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-05 08:51:15'),
(621, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 08:52:35'),
(622, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 08:53:33'),
(623, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-05 09:14:28'),
(624, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:15:57'),
(625, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:20:10'),
(626, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:20:54'),
(627, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:21:48'),
(628, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:22:29'),
(629, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:23:12'),
(630, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:24:07'),
(631, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:25:28'),
(632, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:26:18'),
(633, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:27:23'),
(634, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:29:01'),
(635, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 09:29:51'),
(636, 1, 'Logout', 'user SAdmin Logged out', 'NA', '2026-02-05 09:43:40'),
(637, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-05 09:43:49'),
(638, 1, 'Process', 'Added Process', '::1', '2026-02-05 09:45:05'),
(639, 1, 'Process', 'Added Process', '::1', '2026-02-05 09:45:26'),
(640, 1, 'Process', 'Edited Process id=P00146', '::1', '2026-02-05 09:46:04'),
(641, 1, 'Process', 'Added Process', '::1', '2026-02-05 09:46:36'),
(642, 1, 'Process', 'Added Process', '::1', '2026-02-05 09:46:52'),
(643, 1, 'Process', 'Added Process', '::1', '2026-02-05 09:47:15'),
(644, 1, 'Process', 'Edited Process id=P00149', '::1', '2026-02-05 09:48:06'),
(645, 1, 'Process', 'Added Process', '::1', '2026-02-05 09:48:27'),
(646, 1, 'Process', 'Added Process', '::1', '2026-02-05 09:48:46'),
(647, 1, 'Process', 'Added Process', '::1', '2026-02-05 09:49:01'),
(648, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:50:01'),
(649, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:51:09'),
(650, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:52:06'),
(651, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:53:14'),
(652, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:54:26'),
(653, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:55:21'),
(654, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:56:22'),
(655, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:57:50'),
(656, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:58:47'),
(657, 1, 'Risk', 'Added risk', '::1', '2026-02-05 09:59:37'),
(658, 1, 'Risk', 'Added risk', '::1', '2026-02-05 10:00:39'),
(659, 1, 'Risk', 'Added risk', '::1', '2026-02-05 10:01:29'),
(660, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-05 10:33:10'),
(661, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-02-05 10:33:18'),
(662, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-02-05 10:33:25'),
(663, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:36:29'),
(664, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:37:03'),
(665, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:37:34'),
(666, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:38:02'),
(667, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:38:28'),
(668, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:38:55'),
(669, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:39:21'),
(670, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:39:50'),
(671, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:40:32'),
(672, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:41:02'),
(673, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:41:29'),
(674, 1, 'Control', 'Added Control', '::1', '2026-02-05 10:41:58'),
(675, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 10:46:03'),
(676, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 10:47:04'),
(677, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-02-05 11:08:11'),
(678, 1, 'Assessment', 'Edited Risk Assessment id=RSK0181', '::1', '2026-02-05 11:16:18'),
(679, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:18:55'),
(680, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:19:43'),
(681, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:20:37'),
(682, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:21:48'),
(683, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:22:55'),
(684, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:23:51'),
(685, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:24:58'),
(686, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:25:53'),
(687, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:26:37'),
(688, 1, 'Assessment', 'Added Risk Assessment', '::1', '2026-02-05 11:28:11'),
(689, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-03-28 14:55:25'),
(690, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-03-28 18:23:15'),
(691, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-03-28 18:25:30'),
(692, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-03-30 10:34:55'),
(693, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-03-30 10:35:57'),
(694, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-30 10:36:03'),
(695, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-30 11:06:05'),
(696, 1, 'KRI', 'Added KRI', '::1', '2026-03-30 12:22:10'),
(697, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-30 12:22:57'),
(698, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-30 13:06:26'),
(699, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-30 13:46:24'),
(700, 1, 'KRI', 'Added KRI', '::1', '2026-03-30 13:52:21'),
(701, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-30 14:16:45'),
(702, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-31 10:59:18'),
(703, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-31 11:50:11'),
(704, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-31 13:05:26'),
(705, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-03-31 14:56:47'),
(706, 1, 'Risk Performance', 'Added Risk Performance', '::1', '2026-03-31 15:03:51'),
(707, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-04-01 16:07:54');
INSERT INTO `system_logs` (`id`, `user_id`, `entity`, `action`, `ip_address`, `created_at`) VALUES
(708, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-04-01 21:57:12'),
(709, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-04-04 11:37:12'),
(710, 1, 'Logout', 'user SAdmin Logged out', 'NA', '2026-04-04 11:37:45'),
(711, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-04-09 15:43:32'),
(712, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-04-09 16:25:47'),
(713, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-04-09 16:55:25'),
(714, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-04-10 12:27:39'),
(715, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-04 20:16:09'),
(716, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-05-04 20:17:14'),
(717, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-04 20:17:25'),
(718, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-04 20:55:48'),
(719, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-05-04 21:04:53'),
(720, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-04 21:05:01'),
(721, 1, 'KRI', 'Added KRI', '::1', '2026-05-04 21:06:58'),
(722, 1, 'KRI', 'Added KRI', '::1', '2026-05-04 21:11:38'),
(723, 1, 'Risk Performance', 'Added Risk Performance', '::1', '2026-05-04 21:17:01'),
(724, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-05 15:27:39'),
(725, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 11:14:58'),
(726, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 11:36:16'),
(727, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 12:11:06'),
(728, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 12:32:41'),
(729, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 14:26:03'),
(730, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 14:44:10'),
(731, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 15:37:05'),
(732, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 16:21:24'),
(733, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 17:34:40'),
(734, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-07 17:35:18'),
(735, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-12 11:09:04'),
(736, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-12 12:11:58'),
(737, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-12 12:37:03'),
(738, 2, 'Risk Performance', 'Added Risk Performance', '::1', '2026-05-12 12:47:52'),
(739, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-14 22:02:47'),
(740, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-14 22:08:34'),
(741, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-14 22:50:55'),
(742, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-14 22:51:24'),
(743, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-14 22:52:17'),
(744, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-14 23:18:38'),
(745, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 10:52:24'),
(746, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-18 11:50:49'),
(747, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 13:46:00'),
(748, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 14:05:45'),
(749, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 14:21:13'),
(750, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 17:06:07'),
(751, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 17:06:22'),
(752, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 17:28:15'),
(753, 24, 'Performance History', 'Added Performance History id=', '::1', '2026-05-18 17:34:04'),
(754, 24, 'Performance History', 'Added Performance History id=1', '::1', '2026-05-18 17:36:31'),
(755, 24, 'Performance History', 'Added Performance History id=2', '::1', '2026-05-18 17:37:10'),
(756, 24, 'Performance History', 'Added Performance History id=1', '::1', '2026-05-18 17:48:27'),
(757, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 21:19:01'),
(758, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 21:57:01'),
(759, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-18 23:04:32'),
(760, 24, 'Performance History', 'Added Performance History id=2', '::1', '2026-05-18 23:09:10'),
(761, 24, 'Performance History', 'Added Performance History id=2', '::1', '2026-05-18 23:09:33'),
(762, 24, 'Performance History', 'Added Performance History id=2', '::1', '2026-05-18 23:10:02'),
(763, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-18 23:32:12'),
(764, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-19 07:12:43'),
(765, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-19 07:45:18'),
(766, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-19 09:39:26'),
(767, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-19 10:22:21'),
(768, 1, 'Risk Performance', 'Added Risk Performance', '::1', '2026-05-19 10:24:41'),
(769, 24, 'Performance History', 'Added Performance History id=3', '::1', '2026-05-19 10:26:25'),
(770, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-19 11:40:48'),
(771, 1, 'Risk Performance', 'Added Risk Performance', '::1', '2026-05-19 11:42:02'),
(772, 1, 'Risk Performance', 'Added Risk Performance', '::1', '2026-05-19 11:43:37'),
(773, 24, 'Performance History', 'Added Performance History id=5', '::1', '2026-05-19 11:44:21'),
(774, 24, 'Performance History', 'Added Performance History id=5', '::1', '2026-05-19 11:44:38'),
(775, 24, 'Performance History', 'Added Performance History id=5', '::1', '2026-05-19 11:45:00'),
(776, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-19 11:52:44'),
(777, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-19 12:17:18'),
(778, 1, 'Performance History', 'Added Performance History id=5', '::1', '2026-05-19 12:18:25'),
(779, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-19 12:55:49'),
(780, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-27 15:36:50'),
(781, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-05-27 16:07:07'),
(782, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-05-27 16:30:04'),
(783, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-05 14:18:54'),
(784, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-14 18:52:20'),
(785, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-14 19:23:54'),
(786, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-06-15 17:47:17'),
(787, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-15 17:47:28'),
(788, 1, 'Login', 'user SAdmin Logged in', '::1', '2026-06-16 05:54:49'),
(789, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-16 05:55:12'),
(790, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-20 07:17:30'),
(791, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-20 07:18:58'),
(792, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-20 12:35:29'),
(793, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-06-20 12:49:56'),
(794, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-20 16:57:37'),
(795, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-06-22 10:43:18'),
(796, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-22 10:43:36'),
(797, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-06-22 12:11:01'),
(798, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-22 12:11:16'),
(799, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-23 10:57:18'),
(800, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-23 11:32:38'),
(801, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-23 11:32:54'),
(802, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-23 11:37:45'),
(803, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-06-23 11:53:45'),
(804, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-23 11:53:57'),
(805, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-23 12:01:43'),
(806, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-23 12:18:52'),
(807, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-06-23 12:34:47'),
(808, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-23 12:35:03'),
(809, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-06-23 12:49:27'),
(810, 2, 'Login', 'user hillaryW Logged in', '::1', '2026-06-23 12:58:28'),
(811, 2, 'Logout', 'user hillaryW Logged out', 'NA', '2026-06-23 13:28:20'),
(812, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-24 14:06:32'),
(813, 2, 'Logout', 'user hillaryW logged out', 'NA', '2026-06-24 14:14:42'),
(814, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-24 14:15:03'),
(815, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-24 14:15:38'),
(816, 2, 'Logout', 'user hillaryW logged out', 'NA', '2026-06-24 14:18:03'),
(817, 1, 'Login', 'user SAdmin logged in', '::1', '2026-06-24 14:18:10'),
(818, 1, 'Logout', 'user SAdmin logged out', 'NA', '2026-06-24 14:23:06'),
(819, 1, 'Login', 'user SAdmin logged in', '::1', '2026-06-24 14:52:57'),
(820, 1, 'Login', 'user SAdmin logged in', '::1', '2026-06-24 15:46:19'),
(821, 1, 'Logout', 'user SAdmin logged out', 'NA', '2026-06-24 15:47:18'),
(822, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-24 16:46:16'),
(823, 2, 'Logout', 'user hillaryW logged out', 'NA', '2026-06-24 16:51:56'),
(824, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-24 16:52:09'),
(825, 1, 'Login', 'user SAdmin logged in', '::1', '2026-06-24 23:15:08'),
(826, 1, 'Logout', 'user SAdmin logged out', 'NA', '2026-06-24 23:15:21'),
(827, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-24 23:15:32'),
(828, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-24 23:30:50'),
(829, 2, 'Users', 'deleted user id=26', '::1', '2026-06-24 23:34:25'),
(830, 2, 'Users', 'suspended user id=19', '::1', '2026-06-24 23:38:06'),
(831, 2, 'Users', 'suspended user id=1', '::1', '2026-06-24 23:48:27'),
(832, 2, 'Users', 'activated user id=1', '::1', '2026-06-24 23:48:34'),
(833, 2, 'Users', 'suspended user id=19', '::1', '2026-06-24 23:50:34'),
(834, 2, 'Users', 'suspended user id=19', '::1', '2026-06-24 23:50:38'),
(835, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-25 00:31:39'),
(836, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-25 10:06:47'),
(837, 2, 'Login', 'user hillaryW logged in', '::1', '2026-06-25 10:26:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `authid` varchar(100) DEFAULT NULL,
  `fname` varchar(200) NOT NULL,
  `sname` varchar(200) NOT NULL,
  `gender` varchar(20) DEFAULT NULL,
  `dept_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `username` varchar(200) NOT NULL,
  `upassword` varchar(300) NOT NULL,
  `roles` int(11) NOT NULL DEFAULT 2,
  `access` int(11) NOT NULL DEFAULT 1,
  `user_type` int(11) NOT NULL DEFAULT 1,
  `verify_token` varchar(255) DEFAULT NULL,
  `token_expires_at` datetime DEFAULT NULL,
  `bsc_setting` year(4) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `first_login` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `authid`, `fname`, `sname`, `gender`, `dept_id`, `email`, `phone`, `username`, `upassword`, `roles`, `access`, `user_type`, `verify_token`, `token_expires_at`, `bsc_setting`, `created_at`, `deleted_at`, `avatar`, `first_login`) VALUES
(1, NULL, 'Admin', 'SAdmin', 'male', 24, 'evamarticent@gmail.com', '0725154544', 'SAdmin', '$2y$10$RLmqosjdBfNTMa1UXqIbbOeG9JpP/.B94ncz1z4asBr8QRVGYMDMW', 2, 1, 1, NULL, NULL, 2024, '2022-11-02 15:44:20', NULL, NULL, 0),
(2, NULL, 'hillary', 'wachinga', 'male', 12, 'hillary@gmail.com', '725154544', 'hillaryW', '$2y$10$Z81d9BObG5UQuO75EBBov.QqzTxYWj0ryLEe0ogOWuNc3gCTSmMUC', 1, 1, 1, NULL, NULL, 2024, '2022-11-02 15:44:20', NULL, NULL, 0),
(3, NULL, 'mary', 'Wanyonyi', 'female', 2, 'mary@gmail.com', '72515864', 'WMary', '$2y$10$wjDuDrWk68PWW75LjisDkOJ0/ivu8xZTKvVICAjthzo01H1Oz7IaS', 2, 1, 1, NULL, NULL, 0000, '2022-11-02 15:44:20', NULL, NULL, 0),
(4, NULL, 'naomi', 'kosgei', 'female', 1, 'nkosgei@strathmore.edu', '111111', 'Nkosgei', '$2y$10$ThIyanwPmmCtz4PQRYTVKOtvGzm.WNfk47Kvztsg.t36PSDy3TUI2', 1, 1, 1, NULL, NULL, 0000, '2025-10-15 09:24:25', NULL, NULL, 0),
(5, NULL, 'Daniel ', 'Amoke', 'male', 6, 'damoke@strathmore.edu', '738227833', 'DAmoke', '$2y$10$YR8A1jnw7oxotHvJeIl3s.luEbwniO1kKrXZYAurer2z8N92GW4DW', 2, 1, 1, NULL, NULL, 0000, '2025-03-28 15:44:49', NULL, NULL, 0),
(19, NULL, 'timoty', 'timo', 'male', 1, 'timo@gmail.com', '012345678', 'Timo', '$2y$10$i.A2SyiWUlFY1h7L6sfQduzKz5j6pk0BjlZ/j8PgDIix0G1r75B6e', 2, -1, 0, NULL, NULL, 0000, '2024-09-17 08:29:38', NULL, NULL, 0),
(26, NULL, 'RiskPro', 'GRC', 'male', 1, 'riskprogrc@gmail.com', '0', 'riskprogrc', '$2y$10$ywHaGZJs7RNHMTf2ykC3jeC8sk0BhWeYKkygYgGoUfh9qLV9pnqge', 2, 1, 1, NULL, NULL, 0000, '2025-03-28 19:39:51', '2026-06-24 23:34:25', NULL, 0),
(27, NULL, 'Nicholas ', 'Musyimi ', 'male', 6, 'nmateli@strathmore.edu', '11111122', 'Nmateli', '$2y$10$pEeWFaBYBSMcRTaLids59OGQ23fJc3HMaahGJqSIAm/leNDCbfWye', 1, 1, 1, NULL, NULL, 0000, '2025-06-06 11:16:34', NULL, NULL, 0),
(34, NULL, 'linda', 'Mukoma', 'male', 6, 'lmukoma@strathmore.edu', '342424', 'Lmukoma', '$2y$10$z9dyxHDe3GzNkAHQOWR3zO2uj6olPm7tSRrioF5Zh1aK8Fmbtg4KO', 1, 1, 0, NULL, NULL, 0000, '2026-01-29 08:28:29', NULL, NULL, 0),
(35, NULL, 'quinter', 'Kirimi', 'female', 10, 'martokrish@gmail.com', '0111111111', 'Qkirimi', '$2y$10$aIsxc3u0X1jJK7Tr68t68.ppiLKWDGPTVpjiJ/l/ldP0l5pVP1FHa', 2, 1, 0, NULL, NULL, 0000, '2026-06-25 10:37:54', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `action`
--
ALTER TABLE `action`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment`
--
ALTER TABLE `assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit`
--
ALTER TABLE `audit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `auditprog`
--
ALTER TABLE `auditprog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `audit_rating`
--
ALTER TABLE `audit_rating`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cgroup`
--
ALTER TABLE `cgroup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`control_id`);

--
-- Indexes for table `control_strength`
--
ALTER TABLE `control_strength`
  ADD PRIMARY KEY (`strength_id`);

--
-- Indexes for table `control_type`
--
ALTER TABLE `control_type`
  ADD PRIMARY KEY (`ctype_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`dept_id`);

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `files`
--
ALTER TABLE `files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `findings`
--
ALTER TABLE `findings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `impact`
--
ALTER TABLE `impact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `incident`
--
ALTER TABLE `incident`
  ADD PRIMARY KEY (`incident_id`);

--
-- Indexes for table `ki`
--
ALTER TABLE `ki`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kri`
--
ALTER TABLE `kri`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kri_parameter`
--
ALTER TABLE `kri_parameter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `letterupload`
--
ALTER TABLE `letterupload`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likelihood`
--
ALTER TABLE `likelihood`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempt`
--
ALTER TABLE `login_attempt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_ip` (`ip_address`,`attempted_at`),
  ADD KEY `idx_email` (`email`,`attempted_at`);

--
-- Indexes for table `meeting`
--
ALTER TABLE `meeting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mngtletter`
--
ALTER TABLE `mngtletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nletter`
--
ALTER TABLE `nletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `nominee`
--
ALTER TABLE `nominee`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `owner`
--
ALTER TABLE `owner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `passess_fin`
--
ALTER TABLE `passess_fin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbscbusiness`
--
ALTER TABLE `pbscbusiness`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbsccustomer`
--
ALTER TABLE `pbsccustomer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbscfinancial`
--
ALTER TABLE `pbscfinancial`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbsclgrowth`
--
ALTER TABLE `pbsclgrowth`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pbscsetting`
--
ALTER TABLE `pbscsetting`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `performance`
--
ALTER TABLE `performance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pkpi`
--
ALTER TABLE `pkpi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pkra`
--
ALTER TABLE `pkra`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `process`
--
ALTER TABLE `process`
  ADD PRIMARY KEY (`process_id`);

--
-- Indexes for table `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pubaccount`
--
ALTER TABLE `pubaccount`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recommend`
--
ALTER TABLE `recommend`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reviewer`
--
ALTER TABLE `reviewer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `risk`
--
ALTER TABLE `risk`
  ADD PRIMARY KEY (`risk_id`);

--
-- Indexes for table `riskcat`
--
ALTER TABLE `riskcat`
  ADD PRIMARY KEY (`riskcat_id`);

--
-- Indexes for table `system_logs`
--
ALTER TABLE `system_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_email` (`email`),
  ADD UNIQUE KEY `uq_username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `action`
--
ALTER TABLE `action`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assessment`
--
ALTER TABLE `assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=193;

--
-- AUTO_INCREMENT for table `audit`
--
ALTER TABLE `audit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `auditprog`
--
ALTER TABLE `auditprog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `audit_rating`
--
ALTER TABLE `audit_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cgroup`
--
ALTER TABLE `cgroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company`
--
ALTER TABLE `company`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `control`
--
ALTER TABLE `control`
  MODIFY `control_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=195;

--
-- AUTO_INCREMENT for table `control_strength`
--
ALTER TABLE `control_strength`
  MODIFY `strength_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `control_type`
--
ALTER TABLE `control_type`
  MODIFY `ctype_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `dept_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `files`
--
ALTER TABLE `files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `findings`
--
ALTER TABLE `findings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `impact`
--
ALTER TABLE `impact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `incident`
--
ALTER TABLE `incident`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ki`
--
ALTER TABLE `ki`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kri`
--
ALTER TABLE `kri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kri_parameter`
--
ALTER TABLE `kri_parameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `letterupload`
--
ALTER TABLE `letterupload`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `likelihood`
--
ALTER TABLE `likelihood`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_attempt`
--
ALTER TABLE `login_attempt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `meeting`
--
ALTER TABLE `meeting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mngtletter`
--
ALTER TABLE `mngtletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nletter`
--
ALTER TABLE `nletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `nominee`
--
ALTER TABLE `nominee`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `owner`
--
ALTER TABLE `owner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `passess_fin`
--
ALTER TABLE `passess_fin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pbscbusiness`
--
ALTER TABLE `pbscbusiness`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pbsccustomer`
--
ALTER TABLE `pbsccustomer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pbscfinancial`
--
ALTER TABLE `pbscfinancial`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pbsclgrowth`
--
ALTER TABLE `pbsclgrowth`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pbscsetting`
--
ALTER TABLE `pbscsetting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `performance`
--
ALTER TABLE `performance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `pkpi`
--
ALTER TABLE `pkpi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pkra`
--
ALTER TABLE `pkra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `process`
--
ALTER TABLE `process`
  MODIFY `process_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=153;

--
-- AUTO_INCREMENT for table `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pubaccount`
--
ALTER TABLE `pubaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `recommend`
--
ALTER TABLE `recommend`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewer`
--
ALTER TABLE `reviewer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `risk`
--
ALTER TABLE `risk`
  MODIFY `risk_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=199;

--
-- AUTO_INCREMENT for table `riskcat`
--
ALTER TABLE `riskcat`
  MODIFY `riskcat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `system_logs`
--
ALTER TABLE `system_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=838;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
