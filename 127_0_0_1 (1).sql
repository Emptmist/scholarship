-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 27, 2024 at 04:12 PM
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
-- Database: `db_scholarship_system`
--
CREATE DATABASE IF NOT EXISTS `db_scholarship_system` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `db_scholarship_system`;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_address`
--

CREATE TABLE `tbl_address` (
  `Student_No` int(11) NOT NULL,
  `Region` text DEFAULT NULL,
  `Province` text DEFAULT NULL,
  `Municipality` text DEFAULT NULL,
  `Barangay` text DEFAULT NULL,
  `House_No_Street_Barangay` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_address`
--

INSERT INTO `tbl_address` (`Student_No`, `Region`, `Province`, `Municipality`, `Barangay`, `House_No_Street_Barangay`) VALUES
(8, 'CALABARZON', 'Cavite', 'Bacoor', 'Zapote', 'm4'),
(202210224, 'CALABARZON', 'Cavite', 'Imus', 'Malagasang', 'Blk 20 Lot 1, Woodlane'),
(202110696, 'CALABARZON', 'Cavite', 'Kawit', 'Gahak', '123 Mango Street'),
(202210202, 'CALABARZON', 'Cavite', 'Dasmariñas', 'Burol', '5 Laurel St.'),
(202210203, 'CALABARZON', 'Cavite', 'Imus', 'Bucandala', '45 Bayan Luma II'),
(202210206, 'CALABARZON', 'Cavite', 'Bacoor', 'Niog', '32 Molino Blvd.'),
(202210208, 'CALABARZON', 'Cavite', 'Imus', 'Medicion', '12 Palmera St'),
(202210219, 'CALABARZON', 'Cavite', 'Dasmariñas', 'Burol', '45 Mabini St'),
(202210227, 'CALABARZON', 'Cavite', 'Kawit', 'Binakayan-Aplaya', '67 Silang Estates'),
(202210236, 'CALABARZON', 'Cavite', 'Dasmariñas', 'Langkaan', '34 J.P. Rizal St.'),
(202210250, 'CALABARZON', 'Cavite', 'Bacoor', 'Zapote', '7 Zapote St., Barangay Ligtong, Rosario, Cavite'),
(202210255, 'CALABARZON', 'Cavite', 'Bacoor', 'Panapaan', '23 Bayan St.'),
(202210260, 'CALABARZON', 'Cavite', 'Imus', 'Anabu', '15 San Antonio'),
(202210263, 'CALABARZON', 'Cavite', 'Dasmariñas', 'Paliparan', '67 Angel St.'),
(202210289, 'CALABARZON', 'Cavite', 'Bacoor', 'Panapaan', '145 Habay 2'),
(202210291, 'CALABARZON', 'Cavite', 'Bacoor', 'Talaba', '097 Mari St.'),
(202210299, 'CALABARZON', 'Cavite', 'Imus', 'Anabu', '871 Anabu St.'),
(202210315, 'CALABARZON', 'Cavite', 'Bacoor', 'Zapote', 'Pangilin Compound'),
(202210323, 'CALABARZON', 'Cavite', 'Dasmariñas', 'Paliparan', '762 Paliparan'),
(202210324, 'CALABARZON', 'Cavite', 'Imus', 'Malagasang', '012 Malagasang G'),
(202210330, 'CALABARZON', 'Cavite', 'Bacoor', 'Niog', '66 Niog'),
(202210334, 'CALABARZON', 'Cavite', 'Bacoor', 'Panapaan', '017 Panapaan'),
(202210215, 'CALABARZON', 'Cavite', 'Kawit', 'Balsahan-Bisita', '332 Balsahan-Bisita St.'),
(202210347, 'CALABARZON', 'Cavite', 'Bacoor', 'Zapote', '207 P Tortona St.'),
(202210810, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_account`
--

CREATE TABLE `tbl_admin_account` (
  `Admin_id` int(11) NOT NULL,
  `Email` varchar(50) NOT NULL,
  `Password` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_account`
--

INSERT INTO `tbl_admin_account` (`Admin_id`, `Email`, `Password`) VALUES
(101000002, 'unsent@admin', '$2y$10$GEzK2DlVqbmE/obo/LGK0OGc7HXBYYKL.StxuIwsxCl98w7LrED3u'),
(101000003, 'loelcampana14@gmail.com', '$2y$10$qrXUB/J7QA9an/6/AzqOB.NcWXTnHW7tFYxhl1n5IH91M2VUBsxwS'),
(101000004, 'suzy@cvsu.edu.ph', '$2y$10$FtYYFcxm1p/ycE1b6vqPteLrr9czdRQB3l1DlEfEuimfQRUD6Zq.e');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_archive`
--

CREATE TABLE `tbl_admin_archive` (
  `Archive_id` int(11) NOT NULL,
  `Admin_id` int(11) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Deleted_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_history`
--

CREATE TABLE `tbl_admin_history` (
  `admin_login_no` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_history`
--

INSERT INTO `tbl_admin_history` (`admin_login_no`, `email`, `login_time`, `logout_time`) VALUES
(1, 'unsent@admin', '2024-08-23 20:50:15', '0000-00-00 00:00:00'),
(2, 'unsent@admin', '2024-08-23 20:50:27', '0000-00-00 00:00:00'),
(3, 'unsent@admin', '2024-08-23 20:52:21', '2024-08-23 20:52:32'),
(4, 'unsent@admin', '2024-08-23 20:52:21', '0000-00-00 00:00:00'),
(5, 'unsent@admin', '2024-08-23 23:37:13', '2024-08-23 23:40:06'),
(6, 'unsent@admin', '2024-08-24 14:28:19', '2024-08-24 14:29:25'),
(7, 'unsent@admin', '2024-08-24 14:38:49', '2024-08-24 14:44:05'),
(8, 'unsent@admin', '2024-08-24 15:10:43', '0000-00-00 00:00:00'),
(9, 'unsent@admin', '2024-08-24 15:49:47', '2024-08-24 15:51:55'),
(10, 'unsent@admin', '2024-08-24 16:08:13', '2024-08-24 16:08:29'),
(11, 'unsent@admin', '2024-08-25 17:04:51', '2024-08-25 17:05:59'),
(12, 'unsent@admin', '2024-08-25 17:11:51', '2024-08-25 17:31:11'),
(13, 'unsent@admin', '2024-08-25 18:09:41', '0000-00-00 00:00:00'),
(14, 'unsent@admin', '2024-08-25 18:34:10', '2024-08-25 18:34:22'),
(15, 'unsent@admin', '2024-08-25 18:34:10', '0000-00-00 00:00:00'),
(16, 'unsent@admin', '2024-08-25 18:46:05', '0000-00-00 00:00:00'),
(17, 'unsent@admin', '2024-08-25 20:27:51', '2024-08-25 20:48:53'),
(18, 'unsent@admin', '2024-08-25 21:26:42', '2024-08-25 21:28:00'),
(19, 'unsent@admin', '2024-08-25 21:36:06', '2024-08-25 21:36:10'),
(20, 'unsent@admin', '2024-08-25 21:44:13', '2024-08-25 21:46:10'),
(21, 'unsent@admin', '2024-08-25 21:50:38', '2024-08-25 22:03:03'),
(22, 'unsent@admin', '2024-08-25 22:06:01', '2024-08-25 22:06:03'),
(23, 'unsent@admin', '2024-08-25 22:08:18', '2024-08-25 22:08:21'),
(24, 'unsent@admin', '2024-08-25 22:23:14', '2024-08-25 22:23:16'),
(25, 'unsent@admin', '2024-08-25 22:23:17', '2024-08-25 22:23:22'),
(26, 'unsent@admin', '2024-08-25 22:29:18', '2024-08-25 22:34:00'),
(27, 'unsent@admin', '2024-08-25 22:34:08', '2024-08-25 22:34:49'),
(28, 'unsent@admin', '2024-08-25 22:34:57', '2024-08-25 22:35:14'),
(29, 'unsent@admin', '2024-08-25 22:35:15', '2024-08-25 22:35:53'),
(30, 'unsent@admin', '2024-08-25 22:40:31', '2024-08-25 22:45:20'),
(31, 'unsent@admin', '2024-08-25 22:49:01', '0000-00-00 00:00:00'),
(32, 'unsent@admin', '2024-08-26 00:47:55', '2024-08-26 00:49:28'),
(33, 'unsent@admin', '2024-08-26 01:13:50', '2024-08-26 01:32:30'),
(34, 'unsent@admin', '2024-08-26 01:41:34', '2024-08-26 01:46:34'),
(35, 'unsent@admin', '2024-08-26 13:43:46', '2024-08-26 13:48:53'),
(36, 'unsent@admin', '2024-08-26 13:56:25', '2024-08-26 13:58:11'),
(37, 'unsent@admin', '2024-08-26 14:06:06', '2024-08-26 14:24:31'),
(38, 'unsent@admin', '2024-08-26 14:24:40', '2024-08-26 15:20:34'),
(39, 'unsent@admin', '2024-08-26 15:21:17', '2024-08-26 15:31:52'),
(40, 'unsent@admin', '2024-08-26 15:31:54', '2024-08-26 15:40:26'),
(41, 'unsent@admin', '2024-08-26 15:49:02', '2024-08-26 16:10:17'),
(42, 'unsent@admin', '2024-08-26 16:10:49', '2024-08-26 16:11:00'),
(43, 'unsent@admin', '2024-08-26 19:08:35', '2024-08-26 19:23:58'),
(44, 'unsent@admin', '2024-08-26 19:46:53', '2024-08-26 19:57:54'),
(45, 'unsent@admin', '2024-08-26 19:57:56', '2024-08-26 19:57:59'),
(46, 'unsent@admin', '2024-08-26 21:12:21', '2024-08-26 22:49:39'),
(47, 'unsent@admin', '2024-08-26 22:49:46', '2024-08-26 22:57:30'),
(48, 'unsent@admin', '2024-08-27 11:54:07', '2024-08-27 12:22:31'),
(49, 'unsent@admin', '2024-08-27 12:31:26', '2024-08-27 13:02:22'),
(50, 'unsent@admin', '2024-08-27 13:03:35', '2024-08-27 13:45:17'),
(51, 'unsent@admin', '2024-08-27 14:01:51', '2024-08-27 14:02:43'),
(52, 'unsent@admin', '2024-08-27 14:15:20', '2024-08-27 14:15:50'),
(53, 'unsent@admin', '2024-08-27 15:13:39', '2024-08-27 15:13:57'),
(54, 'unsent@admin', '2024-08-27 15:58:37', '2024-08-27 16:07:04'),
(55, 'unsent@admin', '2024-08-27 16:08:30', '2024-08-27 16:09:40'),
(56, 'unsent@admin', '2024-08-27 16:10:39', '2024-08-27 16:11:14'),
(57, 'unsent@admin', '2024-08-27 16:12:23', '2024-08-27 16:19:39');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_personal_info`
--

CREATE TABLE `tbl_admin_personal_info` (
  `Admin_id` int(11) NOT NULL,
  `Last_Name` varchar(50) NOT NULL,
  `First_Name` varchar(50) NOT NULL,
  `Middle_Name` varchar(50) NOT NULL,
  `address` varchar(100) NOT NULL,
  `birth_date` date NOT NULL,
  `age` int(11) NOT NULL,
  `phone` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_personal_info`
--

INSERT INTO `tbl_admin_personal_info` (`Admin_id`, `Last_Name`, `First_Name`, `Middle_Name`, `address`, `birth_date`, `age`, `phone`) VALUES
(1, 'Campana', 'Loel', '', 'Somewhere in Imus', '2004-01-01', 20, 911),
(101000002, 'Campaña', 'Loel', 'Miane', 'Molino 4, Bacoor', '2002-11-14', 22, 90629241);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_admin_profile_picture`
--

CREATE TABLE `tbl_admin_profile_picture` (
  `admin_id` int(11) NOT NULL,
  `image` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_admin_profile_picture`
--

INSERT INTO `tbl_admin_profile_picture` (`admin_id`, `image`) VALUES
(101000002, 'IMG-6682bdd1cbd468.15704269.jpg'),
(1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_announcement`
--

CREATE TABLE `tbl_announcement` (
  `no_announcement` int(11) NOT NULL,
  `title` text NOT NULL,
  `zwhen` varchar(255) NOT NULL,
  `zwhere` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `posted_to` varchar(100) NOT NULL,
  `post_date` date NOT NULL DEFAULT current_timestamp(),
  `ann_pic` text DEFAULT NULL,
  `Admin_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_announcement`
--

INSERT INTO `tbl_announcement` (`no_announcement`, `title`, `zwhen`, `zwhere`, `body`, `posted_to`, `post_date`, `ann_pic`, `Admin_id`) VALUES
(31, 'TO ALL STUDENTS', 'NOW', 'CVSU', 'WELCOME', 'all', '2024-08-08', NULL, 101000002),
(33, 'TO APPROVED STUDENTS', 'NOW', 'CVSU', 'CONGRATS', 'approved', '2024-08-08', NULL, 101000002),
(34, 'TO PENDING STUDENTS', 'NOW', 'CVSU', 'STILL PROCESSING', 'pending', '2024-08-08', NULL, 101000002),
(35, 'TO REJECTED STUDENTS', 'NOW', 'CVSU', 'KEET IT UP!', 'rejected', '2024-08-08', NULL, 101000002),
(37, 'TO FRED', 'NGAYON', 'MAMAYA', 'ambatukam', 'all', '2024-08-27', '', 101000002),
(38, 'TO FRED', 'AMBATUKAM', 'AMBASING', 'AMANUT', 'all', '2024-08-27', '', 101000002),
(39, 'eargesrhstrh', 'setrhsrthsrthdrtjd', 'fdtjhdrtjdtyj', 'xgfmjcghmcghkcghkcghk', 'all', '2024-08-27', '0e00fa3812296d95c04208783430b5ba.png', 101000002);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_application_archive`
--

CREATE TABLE `tbl_application_archive` (
  `Student_No` int(11) NOT NULL,
  `scholarship_no` int(11) NOT NULL,
  `C_status_archive` varchar(50) NOT NULL,
  `reason_archive` text NOT NULL,
  `application_date_archive` date DEFAULT NULL,
  `Admin_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_application_archive`
--

INSERT INTO `tbl_application_archive` (`Student_No`, `scholarship_no`, `C_status_archive`, `reason_archive`, `application_date_archive`, `Admin_id`) VALUES
(8, 62, 'pending', 'Application still in process. Thank you.', '2024-08-22', NULL),
(8, 63, 'pending', 'Application still in process. Thank you.', '2024-08-22', NULL),
(8, 63, 'pending', 'Application still in process. Thank you.', '2024-08-22', NULL),
(8, 63, 'pending', 'Application still in process. Thank you.', '2024-08-26', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_application_scholarship`
--

CREATE TABLE `tbl_application_scholarship` (
  `Student_No` int(11) NOT NULL,
  `scholarship_no` int(11) NOT NULL,
  `C_status` varchar(50) NOT NULL,
  `rejection_reason` text NOT NULL,
  `application_date` date DEFAULT NULL,
  `Admin_id` int(11) DEFAULT NULL,
  `processed_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_application_scholarship`
--

INSERT INTO `tbl_application_scholarship` (`Student_No`, `scholarship_no`, `C_status`, `rejection_reason`, `application_date`, `Admin_id`, `processed_date`) VALUES
(202210202, 61, 'approved', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 12:00:15'),
(202210203, 62, 'approved', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 12:00:16'),
(202210206, 61, 'rejected', 'Invalid attachment for \"Proof of Residency\"', NULL, 101000002, NULL),
(202210208, 61, 'rejected', 'GPA did not meet the standard.', NULL, 101000002, NULL),
(202210219, 61, 'approved', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 12:00:16'),
(202210224, 62, 'approved', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 12:00:17'),
(202210236, 62, 'rejected', 'GPA did not meet the standard.', NULL, 101000002, NULL),
(202210250, 61, 'rejected', 'invalid attachment \"PSA\"', NULL, 101000002, NULL),
(202210255, 61, 'rejected', 'invalid attachment \"official transcript\"', NULL, 101000002, NULL),
(202210260, 61, 'approved', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 12:00:18'),
(202210263, 61, 'approved', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 12:00:18'),
(202210289, 61, 'approved', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 12:00:19'),
(202210291, 61, 'rejected', 'kulamng ka po', NULL, 101000002, '2024-08-27 16:09:07'),
(202210299, 61, 'pending', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 11:59:06'),
(202210315, 61, 'pending', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 11:59:07'),
(202210323, 61, 'pending', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 11:59:08'),
(202210324, 61, 'pending', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 11:59:08'),
(202210334, 61, 'pending', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 11:59:11'),
(202210255, 62, 'pending', 'Congratulations! Your application has been approved as your grades exceeded our criteria. We look forward to supporting your academic journey. Thank you.', NULL, 101000002, '2024-08-27 11:59:11'),
(202210347, 61, 'pending', 'Application still in process. Thank you.', '2024-08-27', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_college_edu`
--

CREATE TABLE `tbl_college_edu` (
  `Student_No` int(11) NOT NULL,
  `C_Name_of_school` text DEFAULT NULL,
  `C_Year_graduated` text DEFAULT NULL,
  `C_Degree_Course` text DEFAULT NULL,
  `C_Degree_Unit` int(11) DEFAULT NULL,
  `C_GPA` decimal(5,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_college_edu`
--

INSERT INTO `tbl_college_edu` (`Student_No`, `C_Name_of_school`, `C_Year_graduated`, `C_Degree_Course`, `C_Degree_Unit`, `C_GPA`) VALUES
(202210224, 'Cavite State University Imus', '2ND YEAR', 'BS Information Technology', 6, 1.89),
(202110696, 'Cavite State University', '3RD YEAR', 'BS Psychology', 6, 2.25),
(202210202, 'Cavite State University Imus', '3RD YEAR', 'BS Information Technology', 6, 1.25),
(202210203, 'Cavite State University Imus', '3RD YEAR', 'BS Elementary Education', 8, 2.00),
(202210206, 'Cavite State University Imus', '2ND YEAR', 'BS Business Management', 6, 1.75),
(202210208, 'Cavite State University', '3RD YEAR', 'BS Arts in Journalism', 7, 3.00),
(202210219, 'Cavite State University Imus', '3RD YEAR', 'BS Secondary Education', 5, 2.00),
(202210227, 'Cavite State University Imus', '2ND YEAR', 'BS Office Administration', 6, 1.75),
(202210236, 'Cavite State University Imus', '3RD YEAR', 'BS Entrepreneurship', 7, 3.00),
(202210250, 'Cavite State University', '2ND YEAR', 'BS Information Technology', 22, 2.00),
(202210255, 'Cavite State University', '2ND YEAR', 'BS Information Technology', 24, 1.62),
(202210260, 'Cavite State University', '2ND YEAR', 'BS Secondary Education', 24, 1.78),
(202210263, 'Cavite State University', '2ND YEAR', 'BS Information Technology', 24, 1.50),
(202210289, 'Cavite State University', '2ND YEAR', 'BS Hotel and Restaurant Management', 24, 1.65),
(202210291, 'Cavite State University', '2ND YEAR', 'BS Office Administration', 24, 1.90),
(202210299, 'Cavite State University', '2ND YEAR', 'BS Secondary Education', 24, 1.10),
(202210315, 'Cavite State University', '2ND YEAR', 'BS Information Technology', 24, 1.20),
(202210323, 'Cavite State University', '2ND YEAR', 'BS Business Management', 24, 1.34),
(202210324, 'Cavite State University', '2ND YEAR', 'BS Computer Science', 24, 1.89),
(202210330, 'Cavite State University', '2ND YEAR', 'BS Hotel and Restaurant Management', 24, 1.99),
(202210334, 'Cavite State University', '2ND YEAR', 'BS Office Administration', 24, 1.98),
(202210215, 'Cavite State University Imus Campus', '2ND YEAR', 'BS Information Technology', 3, 2.00),
(202210347, 'Cavite State University Imus Campus', '2ND YEAR', 'BS Information Technology', 3, 1.00),
(202210810, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_cvsu_students`
--

CREATE TABLE `tbl_cvsu_students` (
  `Student_No` int(11) NOT NULL,
  `Last_name` varchar(100) NOT NULL,
  `First_name` varchar(100) NOT NULL,
  `CVSU_Email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_cvsu_students`
--

INSERT INTO `tbl_cvsu_students` (`Student_No`, `Last_name`, `First_name`, `CVSU_Email`) VALUES
(202211106, 'ASPERILLA', 'JAMES CARLO', 'ic.jamescarlo.asperilla@cvsu.edu.ph'),
(202210344, 'BAUTISTA', 'HAZEL ANNE', 'ic.hazelanne.bautista@cvsu.edu.ph'),
(202210347, 'BITANCOR', 'XEVIER  CLYDE', 'ic.xevierclyde.bitancor@cvsu.edu.ph'),
(202221074, 'BUCLARES', 'RHANEL SEIGHMONE', 'ic.rhanelseighmone.buclares@cvsu.edu.ph'),
(202210572, 'CALAIS', 'GIULIANI', 'ic.giuliani.calais@cvsu.edu.ph'),
(202210275, 'CAMPAÑA', 'LOEL', 'ic.loel.campaña@cvsu.edu.ph'),
(202210352, 'CASTAÑEDA', 'DANIELA ROMANA', 'ic.danielaromana.castañeda@cvsu.edu.ph'),
(202210356, 'CINCO', 'DANIELA FAITH', 'ic.danielafaith.cinco@cvsu.edu.ph'),
(202210363, 'DE CASTRO', 'KRISCHELLE', 'ic.krischelle.de castro@cvsu.edu.ph'),
(202210810, 'ENRIQUE', 'LORD RAVEN FLEA IRIS', 'ic.lordravenfleairis.enrique@cvsu.edu.ph'),
(202210202, 'FABIAN', 'MEG ANGELINE', 'ic.megangeline.fabian@cvsu.edu.ph'),
(202210203, 'FIDELIS', 'ALEN', 'ic.alen.fidelis@cvsu.edu.ph'),
(202210206, 'GALO', 'SHANLEY', 'ic.shanley.galo@cvsu.edu.ph'),
(202210289, 'GASCON', 'JAMAIELYN MAY', 'ic.jamaielynmay.gascon@cvsu.edu.ph'),
(202210291, 'GERVACIO', 'DANIELA', 'ic.daniela.gervacio@cvsu.edu.ph'),
(202210208, 'GUMATAS', 'ANGELA KATE', 'ic.angelakate.gumatas@cvsu.edu.ph'),
(202210215, 'JAVIER', 'JAN HARVEY', 'ic.janharvey.javier@cvsu.edu.ph'),
(202210299, 'KOA', 'KRISTINE', 'ic.kristine.koa@cvsu.edu.ph'),
(202210723, 'LABANIEGO', 'EVAN KERR', 'ic.evankerr.labaniego@cvsu.edu.ph'),
(202211201, 'LAGSAC', 'ANGELO MHYR', 'ic.angelomhyr.lagsac@cvsu.edu.ph'),
(202211203, 'LOFAMIA', 'DHANIEL', 'ic.dhaniel.lofamia@cvsu.edu.ph'),
(202210219, 'MACASPAC', 'JOHN PATRICK', 'ic.johnpatrick.macaspac@cvsu.edu.ph'),
(202210224, 'MORALES', 'CHARICE', 'ic.charice.morales@cvsu.edu.ph'),
(202310536, 'NAGTALON', 'PRINCE HARVEY', 'ic.princeharvey.nagtalon@cvsu.edu.ph'),
(202210227, 'NICOL', 'CARLOS JR', 'ic.carlosjr.nicol@cvsu.edu.ph'),
(202211207, 'OMEGA', 'REYMART', 'ic.reymart.omega@cvsu.edu.ph'),
(202110696, 'ORELLANO', 'JOHNRIEL', 'ic.johnriel.orellano@cvsu.edu.ph'),
(202210236, 'PALIMA', 'GINNA', 'ic.ginna.palima@cvsu.edu.ph'),
(202210315, 'PANGILIN', 'JASMINE', 'ic.jasmine.pangilin@cvsu.edu.ph'),
(202210239, 'PAR', 'JOHN PATRICK', 'ic.johnpatrick.par@cvsu.edu.ph'),
(202211211, 'RAMA', 'ANDREI ANGELO', 'ic.andreiangelo.rama@cvsu.edu.ph'),
(202210323, 'SANGIL', 'JOEY', 'ic.joey.sangil@cvsu.edu.ph'),
(202210324, 'SANTOS', 'RODNEY', 'ic.rodney.santos@cvsu.edu.ph'),
(202210250, 'SERRANO', 'KATE', 'ic.kate.serrano@cvsu.edu.ph'),
(202210255, 'TOLEDO', 'MARC ANDREI', 'ic.marcandrei.toledo@cvsu.edu.ph'),
(202210330, 'TROPICO', 'FREDDRICK', 'ic.freddrick.tropico@cvsu.edu.ph'),
(202210334, 'VALENTINO', 'MARTIN LOUIS', 'ic.martinlouis.valentino@cvsu.edu.ph'),
(202210260, 'VELASCO', 'HAZEL MAE', 'ic.hazelmae.velasco@cvsu.edu.ph'),
(202210263, 'ZULUETA', 'RAVEN NICO', 'ic.ravennico.zulueta@cvsu.edu.ph');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_elem_edu_bg`
--

CREATE TABLE `tbl_elem_edu_bg` (
  `Student_No` int(11) NOT NULL,
  `Elem_Name_of_school` text DEFAULT NULL,
  `Elem_Year_graduated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_elem_edu_bg`
--

INSERT INTO `tbl_elem_edu_bg` (`Student_No`, `Elem_Name_of_school`, `Elem_Year_graduated`) VALUES
(202210224, 'Hephzibah Praisers Academe', 2016),
(202110696, 'San Isidro Elementary School', 2010),
(202210202, 'De La Salle Elementary School', 2012),
(202210203, 'Anabu II Elementary School', 2011),
(202210206, 'Molino Elementary School', 2013),
(202210208, 'General Trias Elementary School', 2010),
(202210219, 'Tagaytay Elementary School', 2012),
(202210227, 'Silang Central Elementary School', 2009),
(202210236, 'Trece Martires Elementary School', 2012),
(202210250, '', 2011),
(202210255, 'Panapaan Elementary School', 2012),
(202210260, 'Imus Elementary School', 2016),
(202210263, 'Dasmarinas Elementary School', 2016),
(202210289, 'Panapaan Elementary School', 2016),
(202210291, 'Talaba Elementary School', 2016),
(202210299, 'Imus Elementary School', 2016),
(202210315, 'San Nicolas Elementary School', 2016),
(202210323, 'Molino Elementary School', 2016),
(202210324, 'Imus Elementary School', 2016),
(202210330, 'Panapaan Elementary School', 2016),
(202210334, 'Panapaan Elementary School', 2016),
(202210215, 'Gov DM Camerino Elementary School', 2014),
(202210347, 'Aniban Ceentral School', 2015),
(202210810, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_faq`
--

CREATE TABLE `tbl_faq` (
  `no_faq` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_father_info`
--

CREATE TABLE `tbl_father_info` (
  `Student_No` int(11) NOT NULL,
  `F_Last_Name` varchar(50) DEFAULT NULL,
  `F_First_Name` varchar(50) DEFAULT NULL,
  `F_MI` varchar(50) DEFAULT NULL,
  `F_Occupation` text DEFAULT NULL,
  `F_Contact_No` bigint(20) DEFAULT NULL,
  `F_Citizenship` varchar(50) DEFAULT NULL,
  `F_Religion` varchar(50) DEFAULT NULL,
  `F_Income` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_father_info`
--

INSERT INTO `tbl_father_info` (`Student_No`, `F_Last_Name`, `F_First_Name`, `F_MI`, `F_Occupation`, `F_Contact_No`, `F_Citizenship`, `F_Religion`, `F_Income`) VALUES
(202210224, 'NA', 'NA', '', 'NA', 9000000000, 'NA', 'None', NULL),
(202110696, 'Orellano', 'Juan Carlos', '', 'Engineer', 9271234567, 'Filipino', 'RomanCatholic', NULL),
(202210202, 'Fabian', 'Ernesto', '', 'Civil Engineer', 9193456782, 'Filipino', 'RomanCatholic', NULL),
(202210203, 'Fidelis', 'Manuel', '', 'OFW', 9274563412, 'Filipino', 'IglesiaNiCristo', NULL),
(202210206, 'Galo', 'Roberto', '', 'Businessman', 9193452671, 'Filipino', 'RomanCatholic', NULL),
(202210208, 'Gumatas', 'Ramon', '', 'Farmer', 9172347890, 'Filipino', 'RomanCatholic', NULL),
(202210219, 'Macaspac', 'Ricardo', '', 'OFW', 9272346781, 'Filipino', 'Christian', NULL),
(202210227, 'Nicol', 'Miguel', '', 'Farmer', 9164562839, 'Filipino', 'RomanCatholic', NULL),
(202210236, 'Palima', 'Carlos', '', 'Teacher', 9275634891, 'Filipino', 'IglesiaNiCristo', NULL),
(202210250, 'Castillo', 'Luis', '', 'Police Officer', 9283456712, 'Filipino', 'RomanCatholic', NULL),
(202210255, 'Toledo', 'Rodrigo', '', 'Electrician', 9762017432, 'Filipino', 'RomanCatholic', NULL),
(202210260, 'Velasco', 'Justin', '', 'Architect', 9328453295, 'Filipino', 'RomanCatholic', NULL),
(202210263, 'Zulueta', 'Juan', '', 'Security Guard', 9834293520, 'Filipino', 'RomanCatholic', NULL),
(202210289, 'Gascon', 'Jose', '', 'Mechanic', 9127481274, 'Filipino', 'RomanCatholic', NULL),
(202210291, 'Gervacio', 'Louie', '', 'Chef', 9987749192, 'Filipino', 'Christian', NULL),
(202210299, 'Koa', 'Kayden', '', 'Driver', 9876776747, 'Filipino', 'RomanCatholic', NULL),
(202210315, 'Pangilin', 'Henry', '', 'Maintenance', 9184982948, 'Filipino', 'Christian', NULL),
(202210323, 'Sangil', 'Joel', '', 'Vendor', 9128948912, 'Filipino', 'RomanCatholic', NULL),
(202210324, 'Santos', 'Julio', '', 'Vendor', 9898989312, 'Filipino', 'IglesiaNiCristo', NULL),
(202210330, 'Tropico', 'Lucio', '', 'Chef', 9981738721, 'Filipino', 'IglesiaNiCristo', NULL),
(202210334, 'Valentino', 'Bruno', '', 'Chef', 9918348293, 'Filipino', 'RomanCatholic', NULL),
(202210215, 'Reynante', 'Javier', 'P', 'Electronic Technician', 9951597099, 'Filipino', 'None', 500),
(202210347, 'Bitancor', 'Herminigildo', 'C', 'Electronic Technician', 9776803426, 'Filipino', 'RomanCatholic', 1000),
(202210810, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_feedback`
--

CREATE TABLE `tbl_feedback` (
  `feedback_no` int(11) NOT NULL,
  `feedback_date` date DEFAULT NULL,
  `feedback_category` varchar(255) NOT NULL,
  `feedback_message` text NOT NULL,
  `feedback_image` text DEFAULT NULL,
  `Student_No` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_feedback`
--

INSERT INTO `tbl_feedback` (`feedback_no`, `feedback_date`, `feedback_category`, `feedback_message`, `feedback_image`, `Student_No`) VALUES
(1, '2024-08-25', 'Bug Reports', 'error ohh', 'feedbackpic-66cafc1e10bb82.03249383.jpg', 8),
(2, '2024-08-25', 'Bug Reports', 'error ohh', 'feedbackpic-66cafc248415b7.31602866.jpg', 8),
(3, '2024-08-25', 'Comments', 'boss', '', 8),
(4, '2024-08-25', 'Comments', 'boss', '', 8),
(5, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cafe0476c965.73798029.jpg', 8),
(6, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cafe0b4a7872.49453000.jpg', 8),
(7, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cafe22246bc4.53002521.jpg', 8),
(8, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cafe23d848a4.06770848.jpg', 8),
(9, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cafe81940d30.15341659.jpg', 8),
(10, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cb0049685345.43777636.jpg', 8),
(11, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cb00a80068b9.40058418.jpg', 8),
(12, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cb0161690757.25057390.jpg', 8),
(13, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cb01a8a11d44.87089791.jpg', 8),
(14, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cb0242ac2409.55065780.jpg', 8),
(15, '2024-08-25', 'Bug Reports', 'aww', 'feedbackpic-66cb02aa7b6883.02165114.jpg', 8),
(16, '2024-08-26', 'Bug Reports', 'dsf', 'feedbackpic-66cc54d5c69b32.50031891.jpg', 8),
(17, '2024-08-26', 'Questions', '??', '', 8),
(18, '2024-08-26', 'Questions', '??', '', 8),
(19, '2024-08-26', 'Questions', '??', '', 8),
(20, '2024-08-26', 'Questions', '??', '', 8),
(21, '2024-08-26', 'Questions', '??', '', 8),
(22, '2024-08-26', 'Questions', 'qwe?', '', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_jh_edu_bg`
--

CREATE TABLE `tbl_jh_edu_bg` (
  `Student_No` int(11) NOT NULL,
  `JH_Name_of_school` text DEFAULT NULL,
  `JH_Year_graduated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_jh_edu_bg`
--

INSERT INTO `tbl_jh_edu_bg` (`Student_No`, `JH_Name_of_school`, `JH_Year_graduated`) VALUES
(202210224, 'APEC Schools Dasma', 2020),
(202110696, 'Makati Science High School', 2014),
(202210202, 'Imus National High School', 2016),
(202210203, 'Imus National High School', 2015),
(202210206, 'Bacoor National High School', 2017),
(202210208, 'Cavite National High School', 2014),
(202210219, 'Tagaytay National High School', 2016),
(202210227, 'Silang National High School', 2013),
(202210236, 'Cavite National High School', 2016),
(202210250, 'Rosario National High School', 2015),
(202210255, 'Cavite National High School', 2016),
(202210260, 'Imus National High School', 2020),
(202210263, 'Dasmarinas National High School', 2020),
(202210289, 'Panapaan National High School', 2020),
(202210291, 'Talaba High School', 2020),
(202210299, 'Imus National High School', 2020),
(202210315, 'Gods Grace Christian School', 2020),
(202210323, 'Dasmarinas National High School', 2020),
(202210324, 'Imus National High School', 2020),
(202210330, 'Panapaan National High School', 2020),
(202210334, 'Panapaan National High School', 2020),
(202210215, 'Emiliano Tria Tirona Memorial National Highschool', 2018),
(202210347, 'Bacoor National Highschool', 2019),
(202210810, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mother_info`
--

CREATE TABLE `tbl_mother_info` (
  `Student_No` int(11) NOT NULL,
  `M_Last_Name` varchar(50) DEFAULT NULL,
  `M_First_Name` varchar(50) DEFAULT NULL,
  `M_MI` varchar(50) DEFAULT NULL,
  `M_Occupation` text DEFAULT NULL,
  `M_Contact_No` bigint(11) DEFAULT NULL,
  `M_Citizenship` varchar(50) DEFAULT NULL,
  `M_Religion` varchar(50) DEFAULT NULL,
  `M_Income` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_mother_info`
--

INSERT INTO `tbl_mother_info` (`Student_No`, `M_Last_Name`, `M_First_Name`, `M_MI`, `M_Occupation`, `M_Contact_No`, `M_Citizenship`, `M_Religion`, `M_Income`) VALUES
(202210224, 'Liberty', 'Morales', '', 'Government Employee', 9980701947, 'Filipino', 'Christian', NULL),
(202110696, 'Orellano', 'Maria Luisa', '', 'Accountant', 9176543210, 'Filipino', 'Roman Catholic', NULL),
(202210202, 'Fabian', 'Patricia', '', 'Teacher', 9167834567, 'Filipino', 'Roman Catholic', NULL),
(202210203, 'Fidelis', 'Rosa', '', 'Nurse', 9176452348, 'Filipino', 'IglesiaNiCristo', NULL),
(202210206, 'Galo', 'Ana', '', 'Banker', 9176543789, 'Filipino', 'Roman Catholic', NULL),
(202210208, 'Gumatas', 'Isabel', '', 'Government Employee', 9183567498, 'Filipino', 'Roman Catholic', NULL),
(202210219, 'Macaspac', 'Lourdes', '', 'Teacher', 9184563478, 'Filipino', 'Christian', NULL),
(202210227, 'Nicol', 'Maria Clara', '', 'Businesswoman', 9273456123, 'Filipino', 'Roman Catholic', NULL),
(202210236, 'Palima', 'Elena', '', 'Nurse', 9176543890, 'Filipino', 'IglesiaNiCristo', NULL),
(202210250, 'Castillo', 'Teresa', '', 'Businesswoman', 9173456789, 'Filipino', 'Roman Catholic', NULL),
(202210255, 'Toledo', 'Imelda', '', 'Teacher', 9652301521, 'Filipino', 'Roman Catholic', NULL),
(202210260, 'Velasco', 'Mae', '', 'Engineer', 9841299432, 'Filipino', 'Roman Catholic', NULL),
(202210263, 'Zulueta', 'Rosa', '', 'OFW', 9823853285, 'Filipino', 'Roman Catholic', NULL),
(202210289, 'Gascon', 'Mari', '', 'Nurse', 9127487174, 'Filipino', 'Roman Catholic', NULL),
(202210291, 'Gervacio', 'Jamie', '', 'Vendor', 9100941942, 'Filipino', 'Roman Catholic', NULL),
(202210299, 'Koa', 'Kay', '', 'Doctor', 9987147821, 'Filipino', 'Roman Catholic', NULL),
(202210315, 'Pangilin', 'Rutchel', '', 'Real Estate Agent', 9182498219, 'Filipino', 'Christian', NULL),
(202210323, 'Sangil', 'Aki', '', 'Chef', 9183281949, 'Filipino', 'Roman Catholic', NULL),
(202210324, 'Santos', 'Mae', '', 'Nurse', 9881284918, 'Filipino', 'IglesiaNiCristo', NULL),
(202210330, 'Tropico', 'Wendy', '', 'Accountant', 9881748782, 'Filipino', 'Roman Catholic', NULL),
(202210334, 'Valentino', 'Lucy', '', 'Nurse', 9918293891, 'Filipino', 'Roman Catholic', NULL),
(202210215, 'Rosalie', 'Javier', 'C', 'Housewife', 9951597099, 'Filipino', 'None', 1000),
(202210347, 'Acoja', 'Karen Joy', 'A', 'Housewife', 9951597099, 'Filipino', 'Roman Catholic', 500),
(202210810, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_personal_info`
--

CREATE TABLE `tbl_personal_info` (
  `Student_No` int(11) NOT NULL,
  `Last_Name` varchar(50) DEFAULT NULL,
  `First_Name` varchar(50) DEFAULT NULL,
  `Middle_Name` varchar(50) DEFAULT NULL,
  `Date_of_Birth` date DEFAULT NULL,
  `Place_Of_Birth` text DEFAULT NULL,
  `Gender` varchar(50) DEFAULT NULL,
  `Nationality` varchar(50) DEFAULT NULL,
  `Religion` varchar(50) DEFAULT NULL,
  `Age` int(11) DEFAULT NULL,
  `Civil_Status` varchar(50) DEFAULT NULL,
  `Phone_No` bigint(11) DEFAULT NULL,
  `Email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_personal_info`
--

INSERT INTO `tbl_personal_info` (`Student_No`, `Last_Name`, `First_Name`, `Middle_Name`, `Date_of_Birth`, `Place_Of_Birth`, `Gender`, `Nationality`, `Religion`, `Age`, `Civil_Status`, `Phone_No`, `Email`) VALUES
(202210224, 'Morales', 'Charice', '', '2003-03-01', 'Quezon', 'female', 'Filipino', 'None', 21, 'Single', 9083527360, 'ic.charice.morales@cvsu.edu.ph'),
(202110696, 'Orellano', 'Johnriel', '', '1998-03-14', 'Quezon City', 'male', 'Filipino', 'Roman Catholic', 26, 'Single', 9123456789, 'ic.johnriel.orellano@cvsu.edu.ph'),
(202210202, 'Fabian', 'Meg Angeline', '', '2000-04-20', 'Dasmarinas Cavite', 'female', 'Filipino', 'Roman Catholic', 24, 'Single', 9175467823, 'ic.megangeline.fabian@cvsu.edu.ph'),
(202210203, 'Fidelis', 'Alen', '', '1999-06-15', 'Imus Cavite', 'male', 'Filipino', 'IglesiaNiCristo', 25, 'Single', 9283456712, 'ic.alen.fidelis@cvsu.edu.ph'),
(202210206, 'Galo', 'Shanley', '', '2001-02-28', 'Bacoor Cavite', 'female', 'Filipino', 'Roman Catholic', 23, 'Single', 9173456789, 'ic.shanley.galo@cvsu.edu.ph'),
(202210208, 'Gumatas', 'Angela Kate', '', '1998-05-10', 'General Trias Cavite', 'female', 'Filipino', 'Roman Catholic', 26, 'Married', 9184567890, 'ic.angelakate.gumatas@cvsu.edu.ph'),
(202210219, 'Macaspac', 'John Patrick', '', '2000-09-25', 'Tagaytay Cavite', 'male', 'Filipino', 'Christian', 24, 'Single', 9176546738, 'ic.johnpatrick.macaspac@cvsu.edu.ph'),
(202210227, 'Nicol', 'Carlos Jr', '', '1997-12-12', 'Silang Cavite', 'male', 'Filipino', 'Roman Catholic', 27, 'Married', 9273456981, 'ic.carlosjr.nicol@cvsu.edu.ph'),
(202210236, 'Palima', 'Ginna', '', '2001-01-08', 'Trece Martires Cavite', 'female', 'Filipino', 'IglesiaNiCristo', 23, 'Single', 9183456782, 'ic.ginna.palima@cvsu.edu.ph'),
(202210250, 'Serrano', 'Kate', '', '2003-06-10', 'Rosario Cavite', 'female', 'Filipino', 'Roman Catholic', 21, 'Single', 9194567834, 'ic.kate.serrano@cvsu.edu.ph'),
(202210255, 'Toledo', 'Marc Andrei', '', '2003-01-28', 'Kawit Cavite', 'male', 'Filipino', 'Roman Catholic', 21, 'Single', 9627134934, 'ic.marcandrei.toledo@cvsu.edu.ph'),
(202210260, 'Velasco', 'Hazel Mae', '', '2002-12-29', 'Noveleta', 'female', 'Filipino', 'Roman Catholic', 22, 'Single', 9874294923, 'ic.hazelmae.velasco@cvsu.edu.ph'),
(202210263, 'Zulueta', 'Raven Nico', '', '2004-10-24', 'Dasmarinas', 'male', 'Filipino', 'Roman Catholic', 20, 'Single', 9782753285, 'ic.ravennico.zulueta@cvsu.edu.ph'),
(202210289, 'Gascon', 'Jamaielyn May', '', '2001-12-01', 'Bacoor', 'female', 'Filipino', 'Roman Catholic', 23, 'Single', 9127472184, 'ic.jamaielynmay.gascon@cvsu.edu.ph'),
(202210291, 'Gervacio', 'Daniela', '', '2001-09-28', 'Bacoor', 'female', 'Filipino', 'Roman Catholic', 23, 'Single', 9127784712, 'ic.daniela.gervacio@cvsu.edu.ph'),
(202210299, 'Koa', 'Kristine', '', '2003-01-01', 'Imus', 'female', 'Filipino', 'Roman Catholic', 21, 'Single', 9127848721, 'ic.kristine.koa@cvsu.edu.ph'),
(202210315, 'Pangilin', 'Jasmine', '', '2003-12-14', 'Dasmarinas', 'female', 'Filipino', 'Christian', 21, 'Single', 9097127481, 'ic.jasmine.pangilin@cvsu.edu.ph'),
(202210323, 'Sangil', 'Joey', '', '2003-08-28', 'Dasmarinas', 'male', 'Filipino', 'Christian', 21, 'Single', 9127848127, 'ic.joey.sangil@cvsu.edu.ph'),
(202210324, 'Santos', 'Rodney', '', '2001-09-10', 'Imus', 'male', 'Filipino', 'IglesiaNiCristo', 23, 'Single', 9217844218, 'ic.rodney.santos@cvsu.edu.ph'),
(202210330, 'Tropico', 'Freddrick', '', '2000-01-01', 'Bacoor', 'male', 'Filipino', 'Roman Catholic', 24, 'Single', 9781287482, 'ic.freddrick.tropico@cvsu.edu.ph'),
(202210334, 'Valentino', 'Martin Louis', '', '2003-01-20', 'Bacoor', 'male', 'Filipino', 'Roman Catholic', 21, 'Single', 9001024389, 'ic.martinlouis.valentino@cvsu.edu.ph'),
(202210215, 'JAVIER', 'JAN', '', '2003-01-19', 'Camarines Sur Bicol', 'male', 'Filipino', 'None', 21, 'Single', 9951597099, 'ic.janharvey.javier@cvsu.edu.ph'),
(202210347, 'BITANCOR', 'XEVIER', 'ACOJA', '2001-10-02', 'Philippine General Hospital Makati', 'male', 'Filipino', 'Roman Catholic', 23, 'Single', 9463463574, 'bitancor23@gmail.com'),
(202210810, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_psa`
--

CREATE TABLE `tbl_psa` (
  `Student_No` int(11) NOT NULL,
  `PSA_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_psa`
--

INSERT INTO `tbl_psa` (`Student_No`, `PSA_url`) VALUES
(202210224, 'PSA_ATTACHMENT66c1f62315fbf2.32371792.pdf'),
(202110696, NULL),
(202210202, 'PSA_ATTACHMENT66c2159e7cbf91.54216617.pdf'),
(202210203, 'PSA_ATTACHMENT66c218197dd4d0.84101298.pdf'),
(202210206, 'PSA_ATTACHMENT66c226fcaa5f34.73711966.pdf'),
(202210208, 'PSA_ATTACHMENT66c229986c44a2.80164418.pdf'),
(202210219, 'PSA_ATTACHMENT66c22bea06e2f7.93321228.pdf'),
(202210227, 'PSA_ATTACHMENT66c29484edf156.14474689.pdf'),
(202210236, 'PSA_ATTACHMENT66c2aa94cbcfe5.98490714.pdf'),
(202210250, 'PSA_ATTACHMENT66c2af7b344b49.39256457.pdf'),
(202210255, 'PSA_ATTACHMENT66c2b19b4098f5.19672728.pdf'),
(202210260, 'PSA_ATTACHMENT66c2b32077c1c5.16915009.pdf'),
(202210263, 'PSA_ATTACHMENT66c2b44e8a72e6.96109899.pdf'),
(202210289, 'PSA_ATTACHMENT66c34c3297a929.13368680.pdf'),
(202210291, 'PSA_ATTACHMENT66c34d4dbb3ad3.93418706.pdf'),
(202210299, 'PSA_ATTACHMENT66c34e6eec9c57.58183408.pdf'),
(202210315, 'PSA_ATTACHMENT66c34f50403330.68562019.pdf'),
(202210323, 'PSA_ATTACHMENT66c35015751df0.32082956.pdf'),
(202210324, 'PSA_ATTACHMENT66c35110ef7d98.17910081.pdf'),
(202210330, 'PSA_ATTACHMENT66c352bcd29cd3.94235459.pdf'),
(202210334, 'PSA_ATTACHMENT66c35355615fd3.76953851.pdf'),
(202210215, 'PSA_ATTACHMENT66cd5640710206.75795620.pdf'),
(202210347, 'PSA_ATTACHMENT66cd84c1194e11.77497962.pdf'),
(202210810, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_requirements`
--

CREATE TABLE `tbl_requirements` (
  `no_req` int(11) NOT NULL,
  `req_name` text NOT NULL,
  `scholarship_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_requirements`
--

INSERT INTO `tbl_requirements` (`no_req`, `req_name`, `scholarship_no`) VALUES
(1, 'CertificateOfGrade', 20),
(2, 'CertificateOfEnrollment', 20),
(1, 'asd', 60),
(1, 'Application Form', 62),
(2, 'Official Transcript', 62),
(3, 'Certification of Good Moral Character', 62),
(1, 'Application Form', 61),
(2, 'Proof of Residency', 61),
(3, 'Official Transcript', 61),
(1, '432', 66);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_requirements_archive`
--

CREATE TABLE `tbl_requirements_archive` (
  `no_req` int(11) NOT NULL,
  `req_name` text NOT NULL,
  `scholarship_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_requirements_archive`
--

INSERT INTO `tbl_requirements_archive` (`no_req`, `req_name`, `scholarship_no`) VALUES
(1, 'Clearance of Indigency', 72);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_req_attachment`
--

CREATE TABLE `tbl_req_attachment` (
  `no_attach` int(11) NOT NULL,
  `Student_No` int(11) NOT NULL,
  `Name_Attachment` text DEFAULT NULL,
  `no_req` int(11) NOT NULL,
  `scholarship_no` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_req_attachment`
--

INSERT INTO `tbl_req_attachment` (`no_attach`, `Student_No`, `Name_Attachment`, `no_req`, `scholarship_no`) VALUES
(144, 202210202, 'Application Form-66c21602e5f627.73523606.pdf', 1, 61),
(145, 202210202, 'Proof of Residency-66c21623a0c3d0.79459610.pdf', 2, 61),
(147, 202210202, 'Official Transcript-66c21699b9f939.72721975.pdf', 3, 61),
(151, 202210206, 'Application Form-66c2274e349d23.35529743.pdf', 1, 61),
(152, 202210206, 'Proof of Residency-66c227570329d5.36711163.pdf', 2, 61),
(153, 202210206, 'Official Transcript-66c227644bdb51.94705436.pdf', 3, 61),
(154, 202210208, 'Application Form-66c229b36882c3.08844173.pdf', 1, 61),
(155, 202210208, 'Proof of Residency-66c229bde82004.44181374.pdf', 2, 61),
(156, 202210208, 'Official Transcript-66c229c94a2959.53303619.pdf', 3, 61),
(157, 202210219, 'Application Form-66c27c6a027a38.27552469.pdf', 1, 61),
(158, 202210219, 'Proof of Residency-66c27c75a97de6.69744187.pdf', 2, 61),
(159, 202210219, 'Official Transcript-66c27c862d7630.78547482.pdf', 3, 61),
(166, 202210250, 'Application Form-66c2af92536c91.28384750.pdf', 1, 61),
(167, 202210250, 'Proof of Residency-66c2afa3797747.79872951.pdf', 2, 61),
(168, 202210250, 'Official Transcript-66c2afb75158e9.07370748.pdf', 3, 61),
(169, 202210255, 'Application Form-66c2b1b0983938.20831824.pdf', 1, 61),
(170, 202210255, 'Proof of Residency-66c2b1c44e5152.24080655.pdf', 2, 61),
(171, 202210255, 'Official Transcript-66c2b1dde86120.23106929.pdf', 3, 61),
(172, 202210260, 'Application Form-66c2b338b52314.93917207.pdf', 1, 61),
(173, 202210260, 'Proof of Residency-66c2b345883ac1.34631703.pdf', 2, 61),
(174, 202210260, 'Official Transcript-66c2b3520a8175.54096621.pdf', 3, 61),
(175, 202210263, 'Application Form-66c2b4617c0aa3.98434044.pdf', 1, 61),
(176, 202210263, 'Proof of Residency-66c2b46f267b00.16085089.pdf', 2, 61),
(177, 202210263, 'Official Transcript-66c2b47d73f476.06950970.pdf', 3, 61),
(178, 202210289, 'Application Form-66c34c4311f6b3.23672581.pdf', 1, 61),
(179, 202210289, 'Proof of Residency-66c34c4e74b373.62955466.pdf', 2, 61),
(180, 202210289, 'Official Transcript-66c34c610d32e9.64812153.pdf', 3, 61),
(181, 202210291, 'Application Form-66c34d5948f325.06085664.pdf', 1, 61),
(182, 202210291, 'Proof of Residency-66c34d60026ff6.90679656.pdf', 2, 61),
(183, 202210291, 'Official Transcript-66c34d6bceba14.62933642.pdf', 3, 61),
(184, 202210299, 'Application Form-66c34e7ad48400.80526111.pdf', 1, 61),
(185, 202210299, 'Proof of Residency-66c34e83b623c1.37323764.pdf', 2, 61),
(186, 202210299, 'Official Transcript-66c34e8c754850.09947874.pdf', 3, 61),
(187, 202210315, 'Application Form-66c34f5b399bc5.10286032.pdf', 1, 61),
(188, 202210315, 'Proof of Residency-66c34f655b2982.35825487.pdf', 2, 61),
(189, 202210315, 'Official Transcript-66c34f6cf30808.92395648.pdf', 3, 61),
(190, 202210323, 'Application Form-66c3501fdc84d4.22400404.pdf', 1, 61),
(191, 202210323, 'Proof of Residency-66c350271198b8.54937738.pdf', 2, 61),
(192, 202210323, 'Official Transcript-66c3502f72bf13.25754525.pdf', 3, 61),
(193, 202210324, 'Application Form-66c3511acb6599.11291630.pdf', 1, 61),
(194, 202210324, 'Proof of Residency-66c35123909928.80376874.pdf', 2, 61),
(195, 202210324, 'Official Transcript-66c3512ac64b70.45312357.pdf', 3, 61),
(196, 202210330, 'Application Form-66c352cc8f24d6.47197490.pdf', 1, 61),
(197, 202210330, 'Proof of Residency-66c352d46e4886.29512228.pdf', 2, 61),
(198, 202210330, 'Official Transcript-66c352daa6dab1.32396778.pdf', 3, 61),
(199, 202210334, 'Application Form-66c3535fcd0924.64929991.pdf', 1, 61),
(200, 202210334, 'Proof of Residency-66c3536629e6e2.51765043.pdf', 2, 61),
(201, 202210334, 'Official Transcript-66c3536cc66822.02820450.pdf', 3, 61),
(220, 8, 'Application Form-66c6bd38e5d9f5.34765563.pdf', 1, 61),
(221, 8, 'Proof of Residency-66c6bd44e49c47.78066560.pdf', 2, 61),
(222, 8, 'Official Transcript-66c6bd69c757f1.80489088.pdf', 3, 61),
(226, 8, 'sorry not found-66c6e609a7e6a8.78907662.pdf', 1, 63),
(227, 202210215, 'Application Form-66cd565d59de74.61644585.pdf', 1, 61),
(228, 202210215, 'Proof of Residency-66cd566b3e96b6.28427470.pdf', 2, 61),
(229, 202210215, 'Official Transcript-66cd567b7620b5.61720543.pdf', 3, 61),
(230, 202210347, 'Application Form-66cd8566a4c732.38917464.pdf', 1, 61),
(231, 202210347, 'Proof of Residency-66cd85718fee52.98667590.pdf', 2, 61),
(232, 202210347, 'Official Transcript-66cd857b192843.32408236.pdf', 3, 61);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_req_attachment_archive`
--

CREATE TABLE `tbl_req_attachment_archive` (
  `no_attach` int(11) NOT NULL,
  `Student_No` int(11) DEFAULT NULL,
  `Name_Attachment` varchar(255) DEFAULT NULL,
  `no_req` int(11) DEFAULT NULL,
  `scholarship_no` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_req_attachment_archive`
--

INSERT INTO `tbl_req_attachment_archive` (`no_attach`, `Student_No`, `Name_Attachment`, `no_req`, `scholarship_no`) VALUES
(144, 202210202, 'Application Form-66c21602e5f627.73523606.pdf', 1, 61),
(145, 202210202, 'Proof of Residency-66c21623a0c3d0.79459610.pdf', 2, 61),
(147, 202210202, 'Official Transcript-66c21699b9f939.72721975.pdf', 3, 61),
(148, 202210203, 'Proof of Residency-66c2185043a2f2.57529634.pdf', 2, 62),
(149, 202210203, 'Application Form-66c224cd0632c8.43279441.pdf', 1, 62),
(150, 202210203, 'Official Transcript-66c2254edf97a6.05850991.pdf', 3, 62),
(151, 202210206, 'Application Form-66c2274e349d23.35529743.pdf', 1, 61),
(152, 202210206, 'Proof of Residency-66c227570329d5.36711163.pdf', 2, 61),
(153, 202210206, 'Official Transcript-66c227644bdb51.94705436.pdf', 3, 61),
(154, 202210208, 'Application Form-66c229b36882c3.08844173.pdf', 1, 61),
(155, 202210208, 'Proof of Residency-66c229bde82004.44181374.pdf', 2, 61),
(156, 202210208, 'Official Transcript-66c229c94a2959.53303619.pdf', 3, 61),
(157, 202210219, 'Application Form-66c27c6a027a38.27552469.pdf', 1, 61),
(158, 202210219, 'Proof of Residency-66c27c75a97de6.69744187.pdf', 2, 61),
(159, 202210219, 'Official Transcript-66c27c862d7630.78547482.pdf', 3, 61),
(160, 202210224, 'Application Form-66c27ce1b03ba3.74546158.pdf', 1, 62),
(161, 202210224, 'Proof of Residency-66c27ceb797310.23465663.pdf', 2, 62),
(162, 202210224, 'Official Transcript-66c27d27149d51.80699778.pdf', 3, 62),
(163, 202210236, 'Application Form-66c2aaa36c2df4.60323496.pdf', 1, 62),
(164, 202210236, 'Proof of Residency-66c2aac00ff134.94026993.pdf', 2, 62),
(165, 202210236, 'Official Transcript-66c2aadf00f269.91530544.pdf', 3, 62),
(166, 202210250, 'Application Form-66c2af92536c91.28384750.pdf', 1, 61),
(167, 202210250, 'Proof of Residency-66c2afa3797747.79872951.pdf', 2, 61),
(168, 202210250, 'Official Transcript-66c2afb75158e9.07370748.pdf', 3, 61),
(169, 202210255, 'Application Form-66c2b1b0983938.20831824.pdf', 1, 61),
(170, 202210255, 'Proof of Residency-66c2b1c44e5152.24080655.pdf', 2, 61),
(171, 202210255, 'Official Transcript-66c2b1dde86120.23106929.pdf', 3, 61),
(172, 202210260, 'Application Form-66c2b338b52314.93917207.pdf', 1, 61),
(173, 202210260, 'Proof of Residency-66c2b345883ac1.34631703.pdf', 2, 61),
(174, 202210260, 'Official Transcript-66c2b3520a8175.54096621.pdf', 3, 61),
(175, 202210263, 'Application Form-66c2b4617c0aa3.98434044.pdf', 1, 61),
(176, 202210263, 'Proof of Residency-66c2b46f267b00.16085089.pdf', 2, 61),
(177, 202210263, 'Official Transcript-66c2b47d73f476.06950970.pdf', 3, 61),
(178, 202210289, 'Application Form-66c34c4311f6b3.23672581.pdf', 1, 61),
(179, 202210289, 'Proof of Residency-66c34c4e74b373.62955466.pdf', 2, 61),
(180, 202210289, 'Official Transcript-66c34c610d32e9.64812153.pdf', 3, 61),
(181, 202210291, 'Application Form-66c34d5948f325.06085664.pdf', 1, 61),
(182, 202210291, 'Proof of Residency-66c34d60026ff6.90679656.pdf', 2, 61),
(183, 202210291, 'Official Transcript-66c34d6bceba14.62933642.pdf', 3, 61),
(184, 202210299, 'Application Form-66c34e7ad48400.80526111.pdf', 1, 61),
(185, 202210299, 'Proof of Residency-66c34e83b623c1.37323764.pdf', 2, 61),
(186, 202210299, 'Official Transcript-66c34e8c754850.09947874.pdf', 3, 61),
(187, 202210315, 'Application Form-66c34f5b399bc5.10286032.pdf', 1, 61),
(188, 202210315, 'Proof of Residency-66c34f655b2982.35825487.pdf', 2, 61),
(189, 202210315, 'Official Transcript-66c34f6cf30808.92395648.pdf', 3, 61),
(190, 202210323, 'Application Form-66c3501fdc84d4.22400404.pdf', 1, 61),
(191, 202210323, 'Proof of Residency-66c350271198b8.54937738.pdf', 2, 61),
(192, 202210323, 'Official Transcript-66c3502f72bf13.25754525.pdf', 3, 61),
(193, 202210324, 'Application Form-66c3511acb6599.11291630.pdf', 1, 61),
(194, 202210324, 'Proof of Residency-66c35123909928.80376874.pdf', 2, 61),
(195, 202210324, 'Official Transcript-66c3512ac64b70.45312357.pdf', 3, 61),
(196, 202210330, 'Application Form-66c352cc8f24d6.47197490.pdf', 1, 61),
(197, 202210330, 'Proof of Residency-66c352d46e4886.29512228.pdf', 2, 61),
(198, 202210330, 'Official Transcript-66c352daa6dab1.32396778.pdf', 3, 61),
(199, 202210334, 'Application Form-66c3535fcd0924.64929991.pdf', 1, 61),
(200, 202210334, 'Proof of Residency-66c3536629e6e2.51765043.pdf', 2, 61),
(201, 202210334, 'Official Transcript-66c3536cc66822.02820450.pdf', 3, 61),
(216, 202210255, 'Application Form-66c609d7edcd31.57111786.pdf', 1, 62),
(217, 202210255, 'Official Transcript-66c60fd22b2f55.61231173.pdf', 2, 62),
(218, 202210255, 'Certification of Good Moral Character-66c60ff1ddc016.30721237.pdf', 3, 62),
(220, 8, 'Application Form-66c6bd38e5d9f5.34765563.pdf', 1, 61),
(221, 8, 'Proof of Residency-66c6bd44e49c47.78066560.pdf', 2, 61),
(222, 8, 'Official Transcript-66c6bd69c757f1.80489088.pdf', 3, 61),
(223, 8, 'Application Form-66c6c82988d592.47340050.pdf', 1, 62),
(224, 8, 'Official Transcript-66c6c83010e5d8.27815423.pdf', 2, 62),
(225, 8, 'Certification of Good Moral Character-66c6c83643cce8.57390951.pdf', 3, 62);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scholarship`
--

CREATE TABLE `tbl_scholarship` (
  `scholarship_no` int(11) NOT NULL,
  `scholarship_name` text NOT NULL,
  `description` text NOT NULL,
  `qualifications` text NOT NULL,
  `start_of_applications` date NOT NULL,
  `end_of_applications` date NOT NULL,
  `Admin_id` int(11) NOT NULL,
  `scholarship_processed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_scholarship`
--

INSERT INTO `tbl_scholarship` (`scholarship_no`, `scholarship_name`, `description`, `qualifications`, `start_of_applications`, `end_of_applications`, `Admin_id`, `scholarship_processed`) VALUES
(61, 'Region 4A Excellence Scholarship', 'The Region 4A Excellence Scholarship is awarded to outstanding students from the CALABARZON region who demonstrate academic excellence and leadership qualities. This scholarship aims to support high-achieving students in their pursuit of higher education and encourage them to contribute positively to their communities.', 'Must be a resident of the CALABARZON region (Cavite, Laguna, Batangas, Rizal, Quezon).\r\nMinimum GPA of 85% or its equivalent.\r\nActive participation in extracurricular activities or community service.\r\n', '2024-08-18', '2024-09-11', 101000002, '2024-08-18 00:00:00'),
(62, 'Cavite State University Academic Achievement Scholarship', 'The Cavite State University Academic Achievement Scholarship is designed to recognize and support students who have demonstrated exceptional academic performance and leadership skills. This scholarship aims to provide financial assistance to help students continue their studies and excel in their chosen fields.', 'Must be a current CvSU student or a newly admitted student for the upcoming academic year.\r\nMust have a minimum GPA of 90% or its equivalent in the previous academic year.\r\nActive participation in CvSU student organizations or community service.\r\nMust not be a recipient of any other major scholarship.', '2024-08-21', '2024-09-07', 101000002, '2024-08-21 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_scholarship_archive`
--

CREATE TABLE `tbl_scholarship_archive` (
  `scholarship_no` int(11) NOT NULL,
  `scholarship_name` text NOT NULL,
  `description` text NOT NULL,
  `qualifications` text NOT NULL,
  `start_of_applications` date NOT NULL,
  `end_of_applications` date NOT NULL,
  `Admin_id` int(11) DEFAULT NULL,
  `scholarship_processed` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_scholarship_archive`
--

INSERT INTO `tbl_scholarship_archive` (`scholarship_no`, `scholarship_name`, `description`, `qualifications`, `start_of_applications`, `end_of_applications`, `Admin_id`, `scholarship_processed`) VALUES
(20, 'Scholarship for Cavite State University', 'The Provincial Scholarship for Cavite State University -  Imus Campus is a prestigious program initiated by the Provincial Government of Cavite. Designed to aid academically talented and financially underprivileged students from the region, this scholarship supports their educational pursuits at Cavite State University - Imus  Campus, nurturing opportunities for academic excellence and personal growth.', '-Academic Excellence\r\nMaintain a minimum GPA.\r\n\r\n-Field of Study\r\nPursue a specified degree.\r\n\r\n-Enrollment Status\r\nBe enrolled or accepted in an accredited institution.\r\n\r\n-Financial Need\r\nDemonstrate financial need.', '2024-07-30', '2024-08-10', NULL, NULL),
(72, 'Strike financial assistant ', '2k', 'Legit bacoor resident', '2024-08-26', '2024-08-26', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_sh_edu_bg`
--

CREATE TABLE `tbl_sh_edu_bg` (
  `Student_No` int(11) NOT NULL,
  `SH_Name_of_school` text DEFAULT NULL,
  `SH_Year_graduated` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_sh_edu_bg`
--

INSERT INTO `tbl_sh_edu_bg` (`Student_No`, `SH_Name_of_school`, `SH_Year_graduated`) VALUES
(202210224, 'Informatics College Northgate', 2022),
(202110696, 'Manila Science High School', 2016),
(202210202, 'St Paul College of Cavite', 2018),
(202210203, 'Imus National High School', 2017),
(202210206, 'Bacoor National High School', 2019),
(202210208, 'St Dominic College of Asia', 2016),
(202210219, 'St Scholasticas College', 2018),
(202210227, 'Philippine Christian University  Dasmarinas', 2015),
(202210236, 'University of Perpetual Help System DALTA  GMA', 2018),
(202210250, 'Cavite State University Rosario Campus', 2017),
(202210255, 'Colegio de San Juan de Letran', 2018),
(202210260, 'Imus National High School', 2022),
(202210263, 'Dasmarinas National High School', 2022),
(202210289, 'Panapaan National High School', 2022),
(202210291, 'Talaba High School', 2022),
(202210299, 'Imus National High School', 2022),
(202210315, 'Southern Philippines Institute of Science Technology', 2022),
(202210323, 'Dasmarinas National High School', 2022),
(202210324, 'Imus National High School', 2022),
(202210330, 'Panapaan National High School', 2022),
(202210334, 'Panapaan National High School', 2022),
(202210215, 'Emiliano Tria Tirona Memorial National Integrated Highschool', 2021),
(202210347, 'Datacom Senior Highschool', 2022),
(202210810, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_acc`
--

CREATE TABLE `tbl_student_acc` (
  `Student_No` int(11) NOT NULL,
  `First_name` varchar(50) NOT NULL,
  `Last_name` varchar(50) NOT NULL,
  `Email_Address` varchar(50) NOT NULL,
  `Password` longtext NOT NULL,
  `OTP_password` varchar(191) DEFAULT NULL,
  `Verification_Token` varchar(191) NOT NULL,
  `Verification_Status` tinyint(2) NOT NULL DEFAULT 0 COMMENT '0 = no, 1 = yes',
  `Date_Created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student_acc`
--

INSERT INTO `tbl_student_acc` (`Student_No`, `First_name`, `Last_name`, `Email_Address`, `Password`, `OTP_password`, `Verification_Token`, `Verification_Status`, `Date_Created`) VALUES
(202110696, 'Johnriel', 'Orellano', 'ic.johnriel.orellano@cvsu.edu.ph', '$2y$10$MhPjKXVkzS8TNAlxydgbK.QLdhNLwjqMUu7EanxqfbiiqQvBxx92i', '', '', 1, '2024-08-15 18:00:29'),
(202210202, 'Meg Angeline', 'Fabian', 'ic.megangeline.fabian@cvsu.edu.ph', '$2y$10$pWrDOT4WziJto77rZCWZ/u4CusUUN3djCx16UtdYdAi.GJvylHrny', '', '', 1, '2024-08-15 02:00:25'),
(202210203, 'Alen', 'Fidelis', 'ic.alen.fidelis@cvsu.edu.ph', '$2y$10$nbRZCs996NLyFcQ0Xuk2wuq23IRWlhKhlrddPJkb5RZZaYVUlMRz6', '', '', 1, '2024-08-15 03:00:52'),
(202210206, 'Shanley', 'Galo', 'ic.shanley.galo@cvsu.edu.ph', '$2y$10$fFq8JX8UdWt9Is.Ylu1oNuy6shQj5oKpeXyuK30KWvniwoX2ycLh.', '', '', 1, '2024-08-15 04:00:39'),
(202210208, 'Angela Kate', 'Gumatas', 'ic.angelakate.gumatas@cvsu.edu.ph', '$2y$10$ss7pFBUDLkmOtqMaWzIOQOMmc4rl/5ca.NGC.gXI9O2sosb9edsiS', '', '', 1, '2024-08-15 07:00:27'),
(202210215, 'JAN', 'JAVIER', 'ic.janharvey.javier@cvsu.edu.ph', '$2y$10$OF4UqgP6hsOiJjx6dBqQ9uWeI2bU50utQbqvzJpPx91pokknvsCqm', NULL, 'a8f78f97444a705a2edf03f4431d1b04', 1, '2024-08-27 07:02:19'),
(202210219, 'John Patrick', 'Macaspac', 'ic.johnpatrick.macaspac@cvsu.edu.ph', '$2y$10$uu5rHXr05VsvHHC.4GQOo.PKc2a5vE7ny2VC2Lnby85yPcoxIt.1C', '', '', 1, '2024-08-15 13:00:23'),
(202210224, 'Charice', 'Morales', 'ic.charice.morales@cvsu.edu.ph', '$2y$10$wT501eevdu2PUV5.QT50UOcbdjX3kjD9fZm4B5WyfhEsKpgsnnHhK', '', '', 1, '2024-08-15 14:00:45'),
(202210227, 'Carlos Jr', 'Nicol', 'ic.carlosjr.nicol@cvsu.edu.ph', '$2y$10$39LuBks328U3d3X1Xd/bK.W5hH1Pb6vz6nyziHMIieplMQJXFeahy', '', '', 1, '2024-08-15 16:00:21'),
(202210236, 'Ginna', 'Palima', 'ic.ginna.palima@cvsu.edu.ph', '$2y$10$6yXpEVz5bHGxhTEdpacpEursMc3/8a79x27a24jEHWosl8/0NkwQq', '', '', 1, '2024-08-15 19:00:49'),
(202210239, 'John Patrick', 'Par', 'ic.johnpatrick.par@cvsu.edu.ph', '$2y$10$ieiGs7Yad4BvejWdWD5a.OCSyb5VzAaIuPbNhjIB5B/iJ3NZaA2o.', '', '', 1, '2024-08-15 21:00:06'),
(202210250, 'Kate', 'Serrano', 'ic.kate.serrano@cvsu.edu.ph', '$2y$10$ijosDZI/5Sf/ThydHAHC5uc62GOf3EMMtGF0wgjsAyAcq69hpuP62', '', '', 1, '2024-08-16 01:00:37'),
(202210255, 'Marc Andrei', 'Toledo', 'ic.marcandrei.toledo@cvsu.edu.ph', '$2y$10$ESAYvvy3p9S0RmlTAN.pG.jidOEnR58H/f1CbDH48Jid9FqplRWiS', '', '', 1, '2024-08-16 02:00:14'),
(202210260, 'Hazel Mae', 'Velasco', 'ic.hazelmae.velasco@cvsu.edu.ph', '$2y$10$qTGnM.Cw5mdGCO85GNo6.uy61l6sIlM44cECeDTteFoore7yzPwb6', '', '', 1, '2024-08-16 05:00:54'),
(202210263, 'Raven Nico', 'Zulueta', 'ic.ravennico.zulueta@cvsu.edu.ph', '$2y$10$uwT39GIQ8U/qqfdcMb/bHeGULYNesmQilN7ciebq5sAh8B6hFZ21i', '', '', 1, '2024-08-16 06:00:41'),
(202210289, 'Jamaielyn May', 'Gascon', 'ic.jamaielynmay.gascon@cvsu.edu.ph', '$2y$10$oEMowEo3RYi/LywK9Pphs.UyERbko8Vgx6.0cP7LMREaBkdGzdLqW', '', '', 1, '2024-08-15 05:00:48'),
(202210291, 'Daniela', 'Gervacio', 'ic.daniela.gervacio@cvsu.edu.ph', '$2y$10$wGoSXqJ2IVVTOfEddaXG8./qOvHj6KAVph6PvVwn9FLd00akWf7Bq', '', '', 1, '2024-08-15 06:00:11'),
(202210299, 'Kristine', 'Koa', 'ic.kristine.koa@cvsu.edu.ph', '$2y$10$V5h1fTMwRLzvccmD1oBziuQOTbBwoYUKqK1Faubtb0rKnQ0P0SZ/a', '', '', 1, '2024-08-15 09:00:53'),
(202210315, 'Jasmine', 'Pangilin', 'ic.jasmine.pangilin@cvsu.edu.ph', '$2y$10$dX8HviDfFyhOC1L7eFJVnOsPI1FVTJ.oeyIRP4L8Kdpd3bzo8Lj3W', '', '', 1, '2024-08-15 20:00:57'),
(202210323, 'Joey', 'Sangil', 'ic.joey.sangil@cvsu.edu.ph', '$2y$10$bIa/N6pAAywppE.UXggaWOZqXNev03abZZmhkqaf84yZnPnBigBRm', '', '', 1, '2024-08-15 23:00:21'),
(202210324, 'Rodney', 'Santos', 'ic.rodney.santos@cvsu.edu.ph', '$2y$10$ipGazPbgcZG8nJElchRlo.RXB.rimqspL1ChHR4YyGa1BMt7yead.', '', '', 1, '2024-08-16 00:00:55'),
(202210330, 'Freddrick', 'Tropico', 'ic.freddrick.tropico@cvsu.edu.ph', '$2y$10$8YOUNuGqXHELrWzYc.wSIelJTQggW0Gyeg203T/uDHC8gSdNA2id.', '5099', '', 1, '2024-08-27 07:10:56'),
(202210334, 'Martin Louis', 'Valentino', 'ic.martinlouis.valentino@cvsu.edu.ph', '$2y$10$bzj8iSAPr/O8AHNVSYl2LuaXHSx5XcIeGuwJHxC5CfjPXEPFXFsYe', '', '', 1, '2024-08-16 04:00:09'),
(202210344, 'Hazel Anne', 'Bautista', 'ic.hazelanne.bautista@cvsu.edu.ph', '$2y$10$ffT7t6HA7sxPxxAvrcv2vu6Thw4cx.XFO4WAhGn9Ibwk7Z4zQYAme', '', '', 1, '2024-08-14 17:00:47'),
(202210347, 'XEVIER', 'BITANCOR', 'ic.xevierclyde.bitancor@cvsu.edu.ph', '$2y$10$.h48IqDujmCoy63IX.yPV.8q1K6oM5/pwcayCQE9lQVZxpliknm/y', NULL, 'c83b4c70aa5095ef383b754ec0f78df4', 1, '2024-08-27 05:55:03'),
(202210352, 'Daniela Romana', 'Castaneda', 'ic.danielaromana.castaneda@cvsu.edu.ph', '$2y$10$M/.ScPcC2NM.TkdV0DLnfu4ZgAoC.7LR0RVEUWraJ7JPjglzhNdOm', '', '', 1, '2024-08-27 05:05:41'),
(202210356, 'Daniela Faith', 'Cinco', 'ic.danielafaith.cinco@cvsu.edu.ph', '$2y$10$nI/SCuVizg2VUpcEwKRdkOEU8U1bVURFEziqU8iLiUmRyekINLwN2', '', '', 1, '2024-08-14 23:00:45'),
(202210363, 'Krischelle', 'De Castro', 'ic.krischelle.decastro@cvsu.edu.ph', '$2y$10$9QFSfRUKl7RsnhNXqKbssubK791gRh5RCjfaaGzmOOb6VWvz6xpoe', '', '', 1, '2024-08-27 05:05:29'),
(202210572, 'Giuliani', 'Calais', 'ic.giuliani.calais@cvsu.edu.ph', '$2y$10$m8tGHOpJL.urkgvQAkwKGO6zeUzvCLZ/sk.KcmAw9r9UwuTt500HK', '', '', 1, '2024-08-14 20:00:54'),
(202210723, 'Evan Kerr', 'Labaniego', 'ic.evankerr.labaniego@cvsu.edu.ph', '$2y$10$S2wDO9uQteGW6ory6Hxp8u9uXIrRM2cNkq25v7m1zMoBJPpAXTdfi', '', '', 1, '2024-08-15 10:00:17'),
(202211106, 'James Carlo', 'Asperilla', 'ic.jamescarlo.asperilla@cvsu.edu.ph', '$2y$10$dbZkMB.ki92v7yFoToa3vu3GptP7fXFUI693FCVR0Kwyc9UhW.AjO', '', '', 1, '2024-08-14 16:00:23'),
(202211201, 'Angelo Mhyr', 'Lagsac', 'ic.angelomhyr.lagsac@cvsu.edu.ph', '$2y$10$TIMlzSYFoGZRKVUIoSsxBul1V3quQGhWxjqhJEhA33Sx05L1Nn7by', '', '', 1, '2024-08-15 11:00:36'),
(202211203, 'Dhaniel', 'Lofamia', 'ic.dhaniel.lofamia@cvsu.edu.ph', '$2y$10$0QJ5adWE2orKZsiJDOvk8ui1suIuxCsNvR0iOMMRz4i2WrFV/JIXG', '', '', 1, '2024-08-15 12:00:04'),
(202211207, 'Reymart', 'Omega', 'ic.reymart.omega@cvsu.edu.ph', '$2y$10$obVyG5ywkEFCu67xsRbStOlo.pgcJIzaKmq1pj29TLzD5UBtiYPnW', '', '', 1, '2024-08-15 17:00:16'),
(202211211, 'Andrei Angelo', 'Rama', 'ic.andreiangelo.rama@cvsu.edu.ph', '$2y$10$bXKFhothWnmvvPeHzXUf9O1TD8FbSn.0h0buHpQ4/VT.INgyXuJqG', '', '', 1, '2024-08-15 22:00:45'),
(202221074, 'Rhanel Seighmone', 'Buclares', 'ic.rhanelseighmone.buclares@cvsu.edu.ph', '$2y$10$fHRLTUIBqVIymdMyuQX36eqrzdPQ39tYsw3fQZVT/ZQPLFApVIeLC', '', '', 1, '2024-08-14 19:00:32'),
(202310536, 'Prince Harvey', 'Nagtalon', 'ic.princeharvey.nagtalon@cvsu.edu.ph', '$2y$10$x.wNE7daezguBkpUaMX2ReK/yW5eI17vexFNbEXMIrA5Nf3W033tW', '', '', 1, '2024-08-15 15:00:32');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_student_history`
--

CREATE TABLE `tbl_student_history` (
  `student_login_no` int(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `login_time` datetime NOT NULL,
  `logout_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_student_history`
--

INSERT INTO `tbl_student_history` (`student_login_no`, `email`, `login_time`, `logout_time`) VALUES
(1, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-23 20:50:00', '2024-08-23 20:50:26'),
(2, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-23 21:24:49', '2024-08-23 21:31:13'),
(3, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-23 21:31:20', '2024-08-23 21:45:24'),
(4, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-23 23:25:50', '2024-08-23 23:31:49'),
(5, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-23 23:31:53', '2024-08-23 23:37:10'),
(6, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-24 00:27:41', '0000-00-00 00:00:00'),
(7, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-24 14:27:10', '2024-08-24 14:27:57'),
(8, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-24 14:30:50', '2024-08-24 14:38:23'),
(9, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-24 15:42:34', '2024-08-24 15:49:30'),
(10, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-24 15:49:39', '2024-08-24 15:49:43'),
(11, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-24 16:08:03', '2024-08-24 16:08:11'),
(12, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-24 16:52:24', '0000-00-00 00:00:00'),
(13, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-24 23:30:09', '2024-08-24 23:33:00'),
(14, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 16:17:01', '2024-08-25 17:04:46'),
(15, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 17:31:15', '2024-08-25 18:09:38'),
(16, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 18:10:49', '2024-08-25 18:34:06'),
(17, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 20:26:33', '2024-08-25 20:27:37'),
(18, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 20:48:58', '2024-08-25 20:49:24'),
(19, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 21:08:54', '2024-08-25 21:20:35'),
(20, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 21:20:37', '2024-08-25 21:20:47'),
(21, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 21:28:03', '2024-08-25 21:28:17'),
(22, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 21:28:46', '2024-08-25 21:32:32'),
(23, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 21:36:15', '2024-08-25 21:36:18'),
(24, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 22:03:11', '2024-08-25 22:04:45'),
(25, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 22:06:05', '2024-08-25 22:06:08'),
(26, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 22:23:09', '2024-08-25 22:23:11'),
(27, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 22:24:32', '2024-08-25 22:26:56'),
(28, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-25 22:27:34', '2024-08-25 22:29:10'),
(29, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 00:49:33', '2024-08-26 00:55:15'),
(30, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 00:55:41', '2024-08-26 00:55:48'),
(31, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 00:57:22', '2024-08-26 00:57:44'),
(32, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 00:57:45', '2024-08-26 00:58:15'),
(33, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 00:58:27', '2024-08-26 00:59:50'),
(34, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 00:59:00', '2024-08-26 00:59:10'),
(35, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 01:46:38', '2024-08-26 01:53:46'),
(36, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 15:20:48', '2024-08-26 15:21:09'),
(37, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 16:10:20', '2024-08-26 16:10:39'),
(38, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 18:11:16', '2024-08-26 18:30:44'),
(39, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 18:49:26', '2024-08-26 18:53:33'),
(40, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 18:53:37', '2024-08-26 18:56:03'),
(41, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 18:56:06', '2024-08-26 19:05:04'),
(42, 'ic.hanni.pham@cvsu.edu.ph', '2024-08-26 19:24:03', '2024-08-26 19:46:50'),
(43, 'ic.janharvey.javier@cvsu.edu.ph', '2024-08-27 12:24:28', '2024-08-27 12:31:14'),
(44, 'ic.xevierclyde.bitancor@cvsu.edu.ph', '2024-08-27 13:55:28', '2024-08-27 13:55:43'),
(45, 'ic.lordravenfleairis.enrique@cvsu.edu.ph', '2024-08-27 14:00:57', '2024-08-27 14:01:04'),
(46, 'ic.janharvey.javier@cvsu.edu.ph', '2024-08-27 14:15:12', '2024-08-27 14:15:17'),
(47, 'ic.xevierclyde.bitancor@cvsu.edu.ph', '2024-08-27 15:34:28', '2024-08-27 15:57:22'),
(48, 'ic.xevierclyde.bitancor@cvsu.edu.ph', '2024-08-27 16:07:29', '2024-08-27 16:08:23'),
(49, 'ic.xevierclyde.bitancor@cvsu.edu.ph', '2024-08-27 16:09:56', '2024-08-27 16:10:23'),
(50, 'ic.xevierclyde.bitancor@cvsu.edu.ph', '2024-08-27 16:11:30', '2024-08-27 16:12:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_super_admin_account`
--

CREATE TABLE `tbl_super_admin_account` (
  `Super_admin_Id` int(11) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Password` longtext NOT NULL,
  `Username` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_super_admin_account`
--

INSERT INTO `tbl_super_admin_account` (`Super_admin_Id`, `Email`, `Password`, `Username`) VALUES
(300000000, 'scholarshipsystem1@gmail.com\r\n', 'Cvsu.Imus.Scholarship', 'Super_Admin');

-- --------------------------------------------------------

--
-- Table structure for table `tb_id_picture`
--

CREATE TABLE `tb_id_picture` (
  `Student_No` int(11) NOT NULL,
  `img_url` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_id_picture`
--

INSERT INTO `tb_id_picture` (`Student_No`, `img_url`) VALUES
(202210224, 'ID_PIC_ATTACHMENT66c1f5eccdbbd6.43308412.jpg'),
(202110696, NULL),
(202210202, 'ID_PIC_ATTACHMENT66c2159e7bfbc9.33985132.jpg'),
(202210203, 'ID_PIC_ATTACHMENT66c218197d3c78.70408835.jpg'),
(202210206, 'ID_PIC_ATTACHMENT66c226fca9dc31.41889374.jpg'),
(202210208, 'ID_PIC_ATTACHMENT66c229986bcdc3.58883034.jpg'),
(202210219, 'ID_PIC_ATTACHMENT66c22bea062ce4.20463086.jpg'),
(202210227, 'ID_PIC_ATTACHMENT66c29484ed8dc2.11720865.jpg'),
(202210236, 'ID_PIC_ATTACHMENT66c2aa94cb40b7.53487967.jpg'),
(202210250, 'ID_PIC_ATTACHMENT66c2af7b321480.27102470.jpg'),
(202210255, 'ID_PIC_ATTACHMENT66c2b19b3e82d5.99201091.jpg'),
(202210260, 'ID_PIC_ATTACHMENT66c2b320759a15.28451911.jpg'),
(202210263, 'ID_PIC_ATTACHMENT66c2b44e8874d2.21382589.jpg'),
(202210289, 'ID_PIC_ATTACHMENT66c34c32971d47.23951995.jpg'),
(202210291, 'ID_PIC_ATTACHMENT66c34d4dbab6b5.83422545.jpg'),
(202210299, 'ID_PIC_ATTACHMENT66c34e6eec12d5.79008663.jpg'),
(202210315, 'ID_PIC_ATTACHMENT66c34f503fc151.34800538.jpg'),
(202210323, 'ID_PIC_ATTACHMENT66c350157482e3.27699859.jpg'),
(202210324, 'ID_PIC_ATTACHMENT66c35110eee1d8.59999632.jpg'),
(202210330, 'ID_PIC_ATTACHMENT66c352bcd22fd4.09473771.jpg'),
(202210334, 'ID_PIC_ATTACHMENT66c3535560e2c9.01079960.jpg'),
(202210215, 'ID_PIC_ATTACHMENT66cd56406ffe68.33267914.jpg'),
(202210347, 'ID_PIC_ATTACHMENT66cd84c118f011.90448277.jpg'),
(202210810, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_admin_account`
--
ALTER TABLE `tbl_admin_account`
  ADD PRIMARY KEY (`Admin_id`);

--
-- Indexes for table `tbl_admin_archive`
--
ALTER TABLE `tbl_admin_archive`
  ADD PRIMARY KEY (`Archive_id`);

--
-- Indexes for table `tbl_admin_history`
--
ALTER TABLE `tbl_admin_history`
  ADD PRIMARY KEY (`admin_login_no`);

--
-- Indexes for table `tbl_admin_personal_info`
--
ALTER TABLE `tbl_admin_personal_info`
  ADD KEY `admin_id` (`Admin_id`);

--
-- Indexes for table `tbl_admin_profile_picture`
--
ALTER TABLE `tbl_admin_profile_picture`
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  ADD PRIMARY KEY (`no_announcement`);

--
-- Indexes for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  ADD PRIMARY KEY (`no_faq`);

--
-- Indexes for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  ADD PRIMARY KEY (`feedback_no`);

--
-- Indexes for table `tbl_personal_info`
--
ALTER TABLE `tbl_personal_info`
  ADD KEY `Student_No` (`Student_No`);

--
-- Indexes for table `tbl_requirements`
--
ALTER TABLE `tbl_requirements`
  ADD KEY `scholarship_no` (`scholarship_no`);

--
-- Indexes for table `tbl_req_attachment`
--
ALTER TABLE `tbl_req_attachment`
  ADD PRIMARY KEY (`no_attach`),
  ADD KEY `scholarship_no` (`scholarship_no`);

--
-- Indexes for table `tbl_req_attachment_archive`
--
ALTER TABLE `tbl_req_attachment_archive`
  ADD PRIMARY KEY (`no_attach`);

--
-- Indexes for table `tbl_scholarship`
--
ALTER TABLE `tbl_scholarship`
  ADD PRIMARY KEY (`scholarship_no`);

--
-- Indexes for table `tbl_student_acc`
--
ALTER TABLE `tbl_student_acc`
  ADD PRIMARY KEY (`Student_No`);

--
-- Indexes for table `tbl_student_history`
--
ALTER TABLE `tbl_student_history`
  ADD PRIMARY KEY (`student_login_no`);

--
-- Indexes for table `tbl_super_admin_account`
--
ALTER TABLE `tbl_super_admin_account`
  ADD PRIMARY KEY (`Super_admin_Id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_admin_account`
--
ALTER TABLE `tbl_admin_account`
  MODIFY `Admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101000005;

--
-- AUTO_INCREMENT for table `tbl_admin_archive`
--
ALTER TABLE `tbl_admin_archive`
  MODIFY `Archive_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_admin_history`
--
ALTER TABLE `tbl_admin_history`
  MODIFY `admin_login_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `tbl_announcement`
--
ALTER TABLE `tbl_announcement`
  MODIFY `no_announcement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `tbl_faq`
--
ALTER TABLE `tbl_faq`
  MODIFY `no_faq` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_feedback`
--
ALTER TABLE `tbl_feedback`
  MODIFY `feedback_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `tbl_req_attachment`
--
ALTER TABLE `tbl_req_attachment`
  MODIFY `no_attach` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=233;

--
-- AUTO_INCREMENT for table `tbl_scholarship`
--
ALTER TABLE `tbl_scholarship`
  MODIFY `scholarship_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tbl_student_acc`
--
ALTER TABLE `tbl_student_acc`
  MODIFY `Student_No` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202310537;

--
-- AUTO_INCREMENT for table `tbl_student_history`
--
ALTER TABLE `tbl_student_history`
  MODIFY `student_login_no` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_super_admin_account`
--
ALTER TABLE `tbl_super_admin_account`
  MODIFY `Super_admin_Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=300000001;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
