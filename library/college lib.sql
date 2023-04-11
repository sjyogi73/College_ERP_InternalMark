-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 05, 2023 at 08:43 AM
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
-- Database: `college`
--

-- --------------------------------------------------------

--
-- Table structure for table `lib_books`
--

CREATE TABLE `lib_books` (
  `id` smallint NOT NULL,
  `bk_acc_no` smallint NOT NULL,
  `bk_class_no` varchar(50) NOT NULL,
  `bk_no` varchar(50) NOT NULL,
  `bk_title` varchar(200) NOT NULL,
  `bk_sub_title` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_author1` varchar(50) NOT NULL,
  `bk_author2` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_author3` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_yrpub` year DEFAULT NULL,
  `bk_edition` tinyint DEFAULT NULL,
  `bk_price` decimal(10,2) DEFAULT NULL,
  `bk_isbn` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_publisher` varchar(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_pages` int DEFAULT NULL,
  `bk_department` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_subject` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_language` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_keyword` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_location` varchar(20) NOT NULL,
  `bk_status` varchar(10) NOT NULL,
  `bk_vendor` varchar(75) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_pur_no` varchar(25) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_notes` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_reportname` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT '-',
  `bk_pur_date` datetime DEFAULT NULL,
  `created_by` tinyint DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `lib_location`
--

CREATE TABLE `lib_location` (
  `id` tinyint NOT NULL,
  `lib_location_id` varchar(10) NOT NULL,
  `lib_location_name` varchar(50) DEFAULT NULL,
  `created_by` tinyint DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lib_location`
--

INSERT INTO `lib_location` (`id`, `lib_location_id`, `lib_location_name`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'L0001', 'MAIN LIBRARY', 1, '2023-01-30 23:30:52', NULL, NULL, 0),
(2, 'L0002', 'SF LIBRARY', 1, '2023-01-30 23:39:27', 0, '2023-01-30 23:40:01', 0),
(3, 'L0003', 'MCA LIBRARY', 1, '2023-01-30 23:39:39', NULL, NULL, 0),
(5, 'L001', 'ABCD', 1, '2023-02-01 21:24:57', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lib_publisher`
--

CREATE TABLE `lib_publisher` (
  `id` tinyint NOT NULL,
  `lib_pub_id` varchar(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lib_pub_name` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `lib_pub_add` varchar(150) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `lib_pub_others` varchar(150) NOT NULL,
  `created_by` tinyint DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lib_publisher`
--

INSERT INTO `lib_publisher` (`id`, `lib_pub_id`, `lib_pub_name`, `lib_pub_add`, `lib_pub_others`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'P001', 'ABC', 'ASAADASA', 'INDIA', 1, '2023-02-01 21:04:30', NULL, NULL, 0),
(2, 'p001', 'ABC', 'ABCDEFGHIF', 'INDIA', 1, '2023-02-01 21:17:13', NULL, NULL, 0),
(3, 'p001', 'ABC', 'ABCDEFGHIF', 'INDIA', 1, '2023-02-01 21:17:26', NULL, NULL, 0),
(4, 'P001', 'ABC', 'ABSDC djnbvkjdsvkjd dsjbvjdbvjd', 'INDIA', 1, '2023-02-01 21:23:03', NULL, NULL, 0),
(5, 'P001', 'ARAVIND APG', '1-23 ABD CBE', 'INDIA', 1, '2023-02-01 21:28:16', NULL, NULL, 0),
(6, 'P001', 'ARAVIND APG', '1-23 ABD CBE', 'INDIA', 1, '2023-02-01 22:01:38', NULL, NULL, 0),
(7, 'P00111', 'ABC', 'SVDSVSDV', 'WGSGSDVSDV', 1, '2023-02-01 22:40:04', 0, '2023-02-05 08:07:00', 0),
(8, 'P001', 'KALKI', 'AASASASASDFGHXDZ', 'FXCXCVVCCVCXV', 1, '2023-02-01 22:52:50', NULL, NULL, 0),
(9, 'P002', 'ALKI', 'SCASCA', 'CDCSCDS', 1, '2023-02-01 22:57:38', 0, '2023-02-01 23:00:44', 0);

-- --------------------------------------------------------

--
-- Table structure for table `lib_vendor`
--

CREATE TABLE `lib_vendor` (
  `id` smallint NOT NULL,
  `vendor_id` varchar(10) DEFAULT NULL,
  `vendor_tit` varchar(150) NOT NULL,
  `vendor_name` varchar(50) DEFAULT NULL,
  `vendor_add` varchar(150) NOT NULL,
  `vendor_ph_no` varchar(20) NOT NULL,
  `vendor_mb_no` bigint NOT NULL,
  `vendor_email_id` varchar(100) NOT NULL,
  `vendor_note` varchar(200) NOT NULL,
  `created_by` tinyint DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lib_vendor`
--

INSERT INTO `lib_vendor` (`id`, `vendor_id`, `vendor_tit`, `vendor_name`, `vendor_add`, `vendor_ph_no`, `vendor_mb_no`, `vendor_email_id`, `vendor_note`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(2, '123', 'QQASAS', 'Asasas', 'asasasa', '9361621891', 9361621891, 'abc@gmail.com', '', 1, '2023-01-31 01:38:38', NULL, NULL, 0),
(3, 'V100', 'ABC SHOP', 'AGGG', 'qwerwertewterty', '9361621891', 9361621891, 'abc@gmail.com', 'ereryrtyrfhfdjgfhn', 1, '2023-01-31 18:33:40', NULL, NULL, 0),
(4, 'aaaa', 'AAAA', 'ABC', 'wdcsdcsdcsd', '', 9361621, '', '', 1, '2023-02-01 22:08:20', NULL, NULL, 0),
(5, 'V001', 'ABC', 'Fhgccccghcghc', 'cxfgxfxfgxf', '1299999999', 9999999999, '7t87587587587t75', 'hjhfjfjfhfjfj', 1, '2023-02-02 21:51:58', NULL, NULL, 0),
(6, '12', 'MR.', 'My Full Name', '01', '(123) 456-7890', 12, 'me@mydomain.com', '', 1, '2023-02-05 07:01:46', NULL, NULL, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `lib_books`
--
ALTER TABLE `lib_books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_location`
--
ALTER TABLE `lib_location`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_publisher`
--
ALTER TABLE `lib_publisher`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lib_vendor`
--
ALTER TABLE `lib_vendor`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `lib_books`
--
ALTER TABLE `lib_books`
  MODIFY `id` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `lib_location`
--
ALTER TABLE `lib_location`
  MODIFY `id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lib_publisher`
--
ALTER TABLE `lib_publisher`
  MODIFY `id` tinyint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lib_vendor`
--
ALTER TABLE `lib_vendor`
  MODIFY `id` smallint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
