-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 11, 2023 at 07:03 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.1.6

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
-- Table structure for table `att_dayorder`
--

CREATE TABLE `att_dayorder` (
  `id` tinyint(3) NOT NULL,
  `do_date` date DEFAULT NULL,
  `do_desc` varchar(150) NOT NULL,
  `dayorder` tinyint(2) UNSIGNED NOT NULL,
  `do_wday` tinyint(2) UNSIGNED NOT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `att_dayorder`
--

INSERT INTO `att_dayorder` (`id`, `do_date`, `do_desc`, `dayorder`, `do_wday`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, '2023-03-10', 'Holyday', 1, 65, 1, '2023-03-10 12:31:21', 1, '2023-03-10 12:50:50', 0),
(2, '2023-03-11', '', 2, 66, 1, '2023-03-11 16:47:16', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `att_timetable`
--

CREATE TABLE `att_timetable` (
  `id` tinyint(3) NOT NULL,
  `degree_id` tinyint(3) UNSIGNED NOT NULL,
  `tt_year` tinyint(3) UNSIGNED NOT NULL,
  `semester` tinyint(3) UNSIGNED NOT NULL,
  `staff_id` smallint(5) UNSIGNED NOT NULL,
  `day_order` tinyint(3) UNSIGNED NOT NULL,
  `days_hour` tinyint(3) UNSIGNED NOT NULL,
  `course_id` int(10) UNSIGNED NOT NULL,
  `course_type` tinyint(3) UNSIGNED NOT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `att_timetable`
--

INSERT INTO `att_timetable` (`id`, `degree_id`, `tt_year`, `semester`, `staff_id`, `day_order`, `days_hour`, `course_id`, `course_type`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(3, 7, 1, 1, 1, 1, 1, 1, 1, 1, '2023-03-07 23:40:34', NULL, NULL, 0),
(4, 7, 1, 1, 1, 1, 2, 3, 1, 1, '2023-03-08 12:56:51', NULL, NULL, 0),
(5, 7, 1, 1, 1, 1, 3, 1, 1, 1, '2023-03-08 12:57:02', 1, '2023-03-08 16:22:00', 0),
(7, 7, 1, 1, 1, 1, 4, 4, 1, 1, '2023-03-08 16:21:00', NULL, NULL, 0),
(8, 7, 1, 1, 1, 1, 5, 5, 1, 1, '2023-03-08 16:21:12', NULL, NULL, 0),
(10, 7, 1, 1, 1, 1, 6, 1, 1, 1, '2023-03-08 16:33:12', NULL, NULL, 0),
(11, 7, 1, 1, 1, 2, 1, 5, 1, 1, '2023-03-08 16:33:23', NULL, NULL, 0),
(12, 7, 1, 1, 1, 2, 2, 4, 1, 1, '2023-03-08 16:33:33', NULL, NULL, 0),
(13, 7, 1, 1, 1, 2, 3, 5, 1, 1, '2023-03-08 16:33:42', NULL, NULL, 0),
(14, 7, 1, 1, 1, 2, 4, 1, 1, 1, '2023-03-08 16:51:34', NULL, NULL, 0),
(15, 7, 1, 1, 1, 2, 5, 3, 1, 1, '2023-03-08 16:51:53', NULL, NULL, 0),
(16, 7, 1, 1, 1, 2, 6, 4, 1, 1, '2023-03-08 16:52:07', 1, '2023-03-08 16:52:19', 0),
(17, 7, 1, 1, 1, 3, 1, 1, 1, 1, '2023-03-08 16:53:47', NULL, NULL, 0),
(18, 7, 1, 1, 1, 3, 2, 3, 1, 1, '2023-03-08 16:53:59', NULL, NULL, 0),
(19, 7, 1, 1, 1, 3, 3, 4, 1, 1, '2023-03-08 16:54:08', NULL, NULL, 0),
(21, 7, 1, 1, 1, 3, 5, 5, 1, 1, '2023-03-08 18:31:48', NULL, NULL, 0),
(22, 7, 1, 1, 1, 3, 6, 4, 1, 1, '2023-03-08 18:31:59', NULL, NULL, 0),
(23, 7, 1, 1, 1, 4, 1, 3, 1, 1, '2023-03-08 18:32:07', NULL, NULL, 0),
(24, 7, 1, 1, 1, 3, 4, 1, 1, 1, '2023-03-08 18:33:13', NULL, NULL, 0),
(25, 7, 1, 1, 1, 4, 2, 1, 1, 1, '2023-03-11 09:23:34', NULL, NULL, 0),
(26, 7, 1, 1, 1, 5, 5, 5, 1, 1, '2023-03-11 10:35:37', NULL, NULL, 0),
(27, 7, 1, 1, 1, 5, 3, 4, 1, 1, '2023-03-11 16:45:46', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam_course`
--

CREATE TABLE `exam_course` (
  `id` bigint(10) NOT NULL,
  `course_code` varchar(15) DEFAULT NULL,
  `course_name` varchar(75) DEFAULT NULL,
  `course_type` tinyint(3) UNSIGNED NOT NULL,
  `course_part` tinyint(2) NOT NULL,
  `degree_id` tinyint(3) NOT NULL,
  `study_year` tinyint(2) DEFAULT NULL,
  `semester` tinyint(2) NOT NULL,
  `hours_week` tinyint(2) NOT NULL,
  `credits` tinyint(2) NOT NULL,
  `exam_hours` tinyint(2) NOT NULL,
  `max_int` tinyint(3) NOT NULL,
  `max_ext` tinyint(3) NOT NULL,
  `max_tot` tinyint(3) NOT NULL,
  `syllabus_file` varchar(100) NOT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_course`
--

INSERT INTO `exam_course` (`id`, `course_code`, `course_name`, `course_type`, `course_part`, `degree_id`, `study_year`, `semester`, `hours_week`, `credits`, `exam_hours`, `max_int`, `max_ext`, `max_tot`, `syllabus_file`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, '12BCA001', 'CPP', 1, 1, 7, 1, 1, 5, 4, 2, 50, 50, 100, '', 1, '2023-02-12 13:09:11', 0, '2023-02-25 21:01:30', 0),
(2, '12BSC1CT03', 'CPP Lang', 1, 1, 9, 1, 1, 5, 4, 2, 50, 50, 100, '', 1, '2023-02-12 13:17:39', 0, '2023-02-25 21:01:47', 0),
(3, '20PCA5CT2', 'Computer Networks', 1, 1, 7, 1, 1, 5, 4, 2, 50, 50, 50, '', 1, '2023-03-05 09:55:10', NULL, NULL, 0),
(4, '20UCA1CT1', 'Tamil I', 1, 1, 7, 1, 1, 5, 4, 2, 50, 50, 100, '', 1, '2023-03-08 16:08:26', NULL, NULL, 0),
(5, '20UCA1CT2', 'English I', 1, 1, 7, 1, 1, 5, 4, 2, 50, 50, 100, '', 1, '2023-03-08 16:09:09', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `exam_course_type`
--

CREATE TABLE `exam_course_type` (
  `id` tinyint(3) NOT NULL,
  `course_type` varchar(50) DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `exam_course_type`
--

INSERT INTO `exam_course_type` (`id`, `course_type`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'THEORY', 1, '2023-01-30 07:18:26', NULL, NULL, 0),
(2, 'PRACTICAL', 1, '2023-01-30 07:18:34', 0, '2023-01-30 07:18:44', 0),
(3, 'PROJECT', 1, '2023-01-30 07:19:12', NULL, NULL, 0),
(4, 'ELECTIVE', 1, '2023-01-30 07:19:18', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fc_feesmaster`
--

CREATE TABLE `fc_feesmaster` (
  `id` tinyint(3) NOT NULL,
  `fees_name` varchar(50) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fc_feesmaster`
--

INSERT INTO `fc_feesmaster` (`id`, `fees_name`, `amount`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'TUTION FEES', '3000.00', 1, '2023-02-05 11:23:20', NULL, NULL, 0),
(2, 'COURSE FEES', '2000.00', 1, '2023-02-05 11:57:17', NULL, NULL, 0),
(3, 'LIBRARY FEES', '500.00', 1, '2023-02-05 11:57:25', NULL, NULL, 0),
(4, 'EXAM FEES', '1000.00', 1, '2023-02-05 11:57:33', NULL, NULL, 0),
(5, 'LAB FEES', '2000.00', 1, '2023-02-05 11:57:41', NULL, NULL, 0),
(6, 'BREAKAGE FEES', '100.00', 1, '2023-02-05 11:57:55', NULL, NULL, 0),
(7, 'CAUTION DEPOSIT', '1000.00', 1, '2023-02-05 11:58:11', NULL, NULL, 0),
(8, 'INSURANCE', '100.00', 1, '2023-02-05 11:58:23', NULL, NULL, 0),
(9, 'SPECIAL FEES', '500.00', 1, '2023-02-05 11:59:21', NULL, NULL, 0),
(10, 'TRANSPORT FEES', '4000.00', 1, '2023-02-05 11:59:35', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fc_feesstructure`
--

CREATE TABLE `fc_feesstructure` (
  `id` smallint(5) NOT NULL,
  `degree_id` tinyint(2) UNSIGNED NOT NULL,
  `fees_year` tinyint(2) UNSIGNED NOT NULL,
  `semester` tinyint(2) UNSIGNED NOT NULL,
  `community` tinyint(2) UNSIGNED NOT NULL,
  `total_amount` decimal(10,2) NOT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fc_feesstructure`
--

INSERT INTO `fc_feesstructure` (`id`, `degree_id`, `fees_year`, `semester`, `community`, `total_amount`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 7, 1, 1, 0, '5000.00', 1, '2023-02-12 10:05:42', 0, '2023-02-12 16:43:42', 0),
(2, 9, 1, 1, 0, '3000.00', 1, '2023-02-12 14:10:47', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `fc_feesstructure_details`
--

CREATE TABLE `fc_feesstructure_details` (
  `id` smallint(5) NOT NULL,
  `fs_id` smallint(5) UNSIGNED NOT NULL,
  `sno` tinyint(3) UNSIGNED NOT NULL,
  `fees_id` tinyint(3) UNSIGNED NOT NULL,
  `amount` decimal(10,2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `fc_feesstructure_details`
--

INSERT INTO `fc_feesstructure_details` (`id`, `fs_id`, `sno`, `fees_id`, `amount`) VALUES
(5, 2, 1, 7, '1000.00'),
(6, 2, 2, 2, '2000.00'),
(7, 1, 1, 7, '1000.00'),
(8, 1, 2, 2, '2000.00'),
(9, 1, 3, 5, '2000.00');

-- --------------------------------------------------------

--
-- Table structure for table `internal_course_mapping`
--

CREATE TABLE `internal_course_mapping` (
  `id` bigint(10) NOT NULL,
  `staff_id` tinyint(6) DEFAULT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `course_id` tinyint(6) DEFAULT NULL,
  `course_code` varchar(15) DEFAULT NULL,
  `course_name` varchar(75) DEFAULT NULL,
  `degree_id` tinyint(3) DEFAULT NULL,
  `study_year` tinyint(2) DEFAULT NULL,
  `semester` tinyint(2) DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `internal_course_mapping`
--

INSERT INTO `internal_course_mapping` (`id`, `staff_id`, `staff_name`, `course_id`, `course_code`, `course_name`, `degree_id`, `study_year`, `semester`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(3, 2, 'Gokul', 1, '22PCA0C1', 'CPP', 12, 1, 1, 1, '2023-02-17 15:33:13', NULL, NULL, 0),
(4, 1, 'Somasundaram', 3, '22PCA0C3', 'Python', 7, 1, 2, 1, '2023-02-17 15:33:23', 0, '2023-02-17 19:19:17', 1),
(5, 2, 'Gokul', 3, '22PCA0C3', 'Python', 7, 1, 2, 1, '2023-02-17 19:21:07', NULL, NULL, 0),
(6, 1, 'Somasundaram', 2, '19PCA0C4', 'Java Programing', 13, 1, 3, 1, '2023-02-17 19:21:17', NULL, NULL, 0),
(7, 1, 'Somasundaram', 4, '22PCA0C5', 'PHP', 13, 1, 1, 1, '2023-02-17 19:48:58', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lib_books`
--

CREATE TABLE `lib_books` (
  `id` smallint(6) NOT NULL,
  `acc_no` smallint(10) NOT NULL,
  `class_no` varchar(50) NOT NULL,
  `title` varchar(200) NOT NULL,
  `sub_title` varchar(200) DEFAULT '-',
  `author1` varchar(50) NOT NULL,
  `author2` varchar(50) DEFAULT '-',
  `author3` varchar(50) DEFAULT '-',
  `yrpub` year(4) DEFAULT NULL,
  `edition` tinyint(4) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `isbn` varchar(50) DEFAULT '-',
  `publisher` varchar(200) DEFAULT '-',
  `pages` int(11) DEFAULT NULL,
  `department` varchar(150) DEFAULT '-',
  `subject` varchar(150) DEFAULT '-',
  `language` varchar(50) DEFAULT '-',
  `keyword` varchar(50) DEFAULT '-',
  `location` varchar(20) NOT NULL,
  `status` varchar(10) NOT NULL,
  `vendor` varchar(75) DEFAULT '-',
  `pur_no` varchar(25) DEFAULT '-',
  `notes` varchar(50) DEFAULT '-',
  `reportname` varchar(50) DEFAULT '-',
  `pur_date` datetime DEFAULT NULL,
  `created_by` tinyint(4) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lib_books`
--

INSERT INTO `lib_books` (`id`, `acc_no`, `class_no`, `title`, `sub_title`, `author1`, `author2`, `author3`, `yrpub`, `edition`, `price`, `isbn`, `publisher`, `pages`, `department`, `subject`, `language`, `keyword`, `location`, `status`, `vendor`, `pur_no`, `notes`, `reportname`, `pur_date`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 123, '123', 'asd', '', 'asd', '', '', 1968, 1, '540.00', '123AS', '2', 456, '1', '3', '2', '', '1', '1', '4', '', '', '-', '1970-01-01 00:00:00', 1, '2023-03-12 12:58:58', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `lib_location`
--

CREATE TABLE `lib_location` (
  `id` tinyint(4) NOT NULL,
  `location_id` varchar(10) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `created_by` tinyint(4) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lib_location`
--

INSERT INTO `lib_location` (`id`, `location_id`, `name`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'L0001', 'MAIN LIBRARY', 1, '2023-01-30 23:30:52', NULL, NULL, 0),
(2, 'L0002', 'SF LIBRARY', 1, '2023-01-30 23:39:27', 0, '2023-01-30 23:40:01', 0),
(3, 'L0003', 'MCA LIBRARY', 1, '2023-01-30 23:39:39', NULL, NULL, 0),
(5, 'L001', 'ABCD', 1, '2023-02-01 21:24:57', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `lib_publisher`
--

CREATE TABLE `lib_publisher` (
  `id` tinyint(4) NOT NULL,
  `pub_id` varchar(10) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `add` varchar(150) NOT NULL,
  `others` varchar(150) NOT NULL,
  `created_by` tinyint(4) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lib_publisher`
--

INSERT INTO `lib_publisher` (`id`, `pub_id`, `name`, `add`, `others`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
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
  `id` smallint(6) NOT NULL,
  `vendor_id` varchar(10) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `add` varchar(150) NOT NULL,
  `ph_no` varchar(20) NOT NULL,
  `mb_no` bigint(20) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `note` varchar(200) NOT NULL,
  `created_by` tinyint(4) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(4) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lib_vendor`
--

INSERT INTO `lib_vendor` (`id`, `vendor_id`, `title`, `name`, `add`, `ph_no`, `mb_no`, `email_id`, `note`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(2, '123', 'QQASAS', 'Asasas', 'asasasa', '9361621891', 9361621891, 'abc@gmail.com', '', 1, '2023-01-31 01:38:38', NULL, NULL, 0),
(3, 'V100', 'ABC SHOP', 'AGGG', 'qwerwertewterty', '9361621891', 9361621891, 'abc@gmail.com', 'ereryrtyrfhfdjgfhn', 1, '2023-01-31 18:33:40', NULL, NULL, 0),
(4, 'aaaa', 'AAAA', 'ABC', 'wdcsdcsdcsd', '', 9361621, '', '', 1, '2023-02-01 22:08:20', NULL, NULL, 0),
(5, 'V001', 'ABC', 'Fhgccccghcghc', 'cxfgxfxfgxf', '1299999999', 9999999999, '7t87587587587t75', 'hjhfjfjfhfjfj', 1, '2023-02-02 21:51:58', NULL, NULL, 0),
(6, '12', 'MR.', 'My Full Name', '01', '(123) 456-7890', 12, 'me@mydomain.com', '', 1, '2023-02-05 07:01:46', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_community`
--

CREATE TABLE `tbl_community` (
  `id` tinyint(3) NOT NULL,
  `comm_name` varchar(10) DEFAULT NULL,
  `cdescription` varchar(150) DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_community`
--

INSERT INTO `tbl_community` (`id`, `comm_name`, `cdescription`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'OC', 'Other Community', 1, '2023-03-10 14:07:54', 1, '2023-03-10 14:13:13', 0),
(2, 'BC', '', 1, '2023-03-10 14:08:24', NULL, NULL, 0),
(3, 'MBC', '', 1, '2023-03-10 14:08:32', NULL, NULL, 0),
(4, 'SC', '', 1, '2023-03-10 14:08:35', NULL, NULL, 0),
(5, 'SCA', '', 1, '2023-03-10 14:08:40', NULL, NULL, 0),
(6, 'ST', '', 1, '2023-03-10 14:08:44', NULL, NULL, 0),
(7, 'OBC', '', 1, '2023-03-10 14:09:00', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_degree`
--

CREATE TABLE `tbl_degree` (
  `id` tinyint(3) NOT NULL,
  `dname` varchar(50) DEFAULT NULL,
  `dtype` varchar(50) DEFAULT NULL,
  `department` tinyint(3) NOT NULL,
  `duration` varchar(50) DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_degree`
--

INSERT INTO `tbl_degree` (`id`, `dname`, `dtype`, `department`, `duration`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(7, 'BCA', 'U', 2, '3', 1, '2022-12-19 14:39:37', 0, '2022-12-27 11:17:14', 0),
(9, 'B.Sc. Computer Science', 'U', 1, '3', 1, '2022-12-19 15:14:45', 0, '2022-12-27 11:16:50', 0),
(10, 'B.Com. Commerce', 'U', 5, '3', 1, '2022-12-19 16:06:16', 0, '2022-12-27 11:16:42', 0),
(11, 'B.Com. CA', 'U', 4, '3', 1, '2022-12-19 16:06:42', 0, '2022-12-27 11:17:03', 0),
(12, 'B.Sc. IT', 'U', 3, '3', 1, '2022-12-19 16:20:47', 0, '2022-12-27 11:17:43', 0),
(13, 'MCA', 'P', 2, '2', 1, '2022-12-19 16:42:47', 0, '2022-12-27 11:17:31', 0),
(14, 'B.Sc. Phy. Edn.', 'U', 6, '3', 1, '2022-12-19 16:52:33', 0, '2022-12-27 11:26:31', 0),
(15, 'M.Sc. IT', 'P', 3, '2', 1, '2023-02-11 21:12:14', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_department`
--

CREATE TABLE `tbl_department` (
  `id` tinyint(3) NOT NULL,
  `dname` varchar(50) DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_department`
--

INSERT INTO `tbl_department` (`id`, `dname`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'DEPARTMENT OF COMPUTER SCIENCE', 1, '2022-12-26 16:37:27', NULL, NULL, 0),
(2, 'DEPARTMENT OF COMPUTER APPLICATION', 1, '2022-12-26 16:37:41', NULL, NULL, 0),
(3, 'DEPARTMENT OF INFORMATION TECHNOLOGY', 1, '2022-12-26 16:38:01', NULL, NULL, 0),
(4, 'DEPARTMENT OF COMMERCE WITH COMPUTER APPLICATION', 1, '2022-12-26 16:38:07', 0, '2022-12-26 16:38:21', 0),
(5, 'DEPARTMENT OF COMMERCE', 1, '2022-12-26 16:38:39', NULL, NULL, 0),
(6, 'DEPARTMENT OF PHYSICAL EDUCATION', 1, '2022-12-27 11:26:11', NULL, NULL, 0),
(7, 'S', 1, '2022-12-31 16:01:11', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_designation`
--

CREATE TABLE `tbl_designation` (
  `id` tinyint(3) NOT NULL,
  `dname` varchar(50) DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_designation`
--

INSERT INTO `tbl_designation` (`id`, `dname`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'PRINCIPAL', 1, '2023-01-26 18:46:11', NULL, NULL, 0),
(2, 'DIRECTOR', 1, '2023-01-26 18:46:19', NULL, NULL, 0),
(3, 'ASSISTANT PROFESSOR', 1, '2023-01-26 18:46:36', NULL, NULL, 0),
(4, 'ASSOCIATE PROFESSOR', 1, '2023-01-26 18:46:49', NULL, NULL, 0),
(5, 'LECTURER', 1, '2023-01-26 18:47:25', NULL, NULL, 0),
(6, 'GUEST LECTURER', 1, '2023-01-26 18:47:33', NULL, NULL, 0),
(7, 'SUPERINDENDENT', 1, '2023-01-26 18:47:55', NULL, NULL, 0),
(8, 'LAB ASSISTANT', 1, '2023-01-26 18:48:02', NULL, NULL, 0),
(9, 'LIBRARIAN', 1, '2023-01-26 18:48:08', NULL, NULL, 0),
(10, 'ASSISTANT', 1, '2023-01-26 18:48:20', NULL, NULL, 0),
(11, 'HELPER', 1, '2023-01-26 18:48:52', NULL, NULL, 0),
(12, 'PROGRAMMER', 1, '2023-01-26 18:48:57', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_internal_marks`
--

CREATE TABLE `tbl_internal_marks` (
  `id` bigint(10) NOT NULL,
  `course_id` tinyint(4) DEFAULT NULL,
  `s_id` int(11) DEFAULT NULL,
  `internal_mark` int(11) DEFAULT NULL,
  `reg_no` varchar(10) DEFAULT NULL,
  `student_name` varchar(50) DEFAULT NULL,
  `degree_id` tinyint(2) DEFAULT NULL,
  `study_year` tinyint(2) DEFAULT NULL,
  `semester` tinyint(2) DEFAULT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_internal_marks`
--

INSERT INTO `tbl_internal_marks` (`id`, `course_id`, `s_id`, `internal_mark`, `reg_no`, `student_name`, `degree_id`, `study_year`, `semester`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(3, 2, 19, 18, '22PCA009', 'Bharathidhasan', 13, 1, 3, 1, '2023-02-19 16:30:09', 0, '2023-03-25 11:04:46', 1),
(34, 4, 3, 20, '13PCA001', 'Arun A', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(35, 4, 4, 10, '13PCA002', 'Balaji A', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(36, 4, 5, 0, '13PCA003', 'Charan S', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(37, 4, 6, 10, '13PCA004', 'Dinesh L', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(38, 4, 7, 0, '13PCA005', 'Ezlil K', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(39, 4, 8, 0, '13PCA006', 'Franklin J', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(40, 4, 9, 10, '13PCA007', 'Ganesh L', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(41, 4, 10, 0, '13PCA008', 'Harish S', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(42, 4, 11, 10, '13PCA009', 'Jai K', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(43, 4, 12, 0, '13PCA010', 'Kalai S', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(44, 4, 13, 0, '13PCA011', 'Lakshmanan R', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(45, 4, 14, 10, '13PCA012', 'Madhan Mohan S', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(46, 4, 15, 0, '13PCA013', 'Nithi S', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(47, 4, 16, 10, '13PCA014', 'Om Prakash S', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(48, 4, 17, 20, '13PCA015', 'Prakash D', 13, 1, 1, 1, '2023-02-22 18:34:26', 0, '2023-02-23 12:13:54', 0),
(50, 2, 19, 18, '22PCA009', 'Bharathidhasan R', 13, 1, 3, 1, '2023-03-25 15:20:00', 0, '2023-03-25 19:08:20', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_roles`
--

CREATE TABLE `tbl_roles` (
  `id` tinyint(3) NOT NULL,
  `role_name` varchar(100) DEFAULT NULL,
  `menu_permission` text NOT NULL,
  `status` tinyint(3) NOT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_roles`
--

INSERT INTO `tbl_roles` (`id`, `role_name`, `menu_permission`, `status`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'Super Admin', 'createDepartment||updateDepartment||viewDepartment||deleteDepartment||createDegree||updateDegree||viewDegree||deleteDegree||createDesignation||updateDesignation||viewDesignation||deleteDesignation||createStudents||updateStudents||viewStudents||deleteStudents||createStaffs||updateStaffs||viewStaffs||deleteStaffs||createRoles||updateRoles||viewRoles||deleteRoles||createUsers||updateUsers||viewUsers||deleteUsers', 1, 1, '2023-01-03 12:57:26', 0, '2023-01-28 09:17:24', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_staffs`
--

CREATE TABLE `tbl_staffs` (
  `id` smallint(5) NOT NULL,
  `staff_id` varchar(10) DEFAULT NULL,
  `staff_name` varchar(50) DEFAULT NULL,
  `staff_type` tinyint(2) NOT NULL COMMENT '1-Teaching; 2-Non Teaching',
  `gender` tinyint(2) DEFAULT NULL COMMENT '1-Male; 2-Female;',
  `staff_dob` date NOT NULL,
  `qualification` varchar(100) NOT NULL,
  `mobile_no` varchar(12) NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `designation` tinyint(3) UNSIGNED NOT NULL,
  `staff_username` varchar(50) NOT NULL,
  `staff_password` varchar(50) NOT NULL,
  `image_file` varchar(100) NOT NULL,
  `staff_address` varchar(100) NOT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_staffs`
--

INSERT INTO `tbl_staffs` (`id`, `staff_id`, `staff_name`, `staff_type`, `gender`, `staff_dob`, `qualification`, `mobile_no`, `email_id`, `designation`, `staff_username`, `staff_password`, `image_file`, `staff_address`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'SF001', 'Somasundaram', 1, 1, '1990-03-26', 'M.Phil., CS', '9894326150', '', 8, 'somasundaram', 'somuji', 'Staff-SF001.jpg', 'Somasundaram', 1, '2023-01-26 16:11:31', 0, '2023-01-26 19:08:08', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_students`
--

CREATE TABLE `tbl_students` (
  `id` bigint(10) NOT NULL,
  `regno` varchar(10) DEFAULT NULL,
  `student_name` varchar(50) DEFAULT NULL,
  `degree` tinyint(3) NOT NULL,
  `study_year` tinyint(2) DEFAULT NULL,
  `semester` tinyint(2) NOT NULL,
  `mobile_no` varchar(15) NOT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_students`
--

INSERT INTO `tbl_students` (`id`, `regno`, `student_name`, `degree`, `study_year`, `semester`, `mobile_no`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, '12UCA001', 'Arun A', 7, 1, 1, '9999555522', 1, '2022-12-29 09:45:57', NULL, NULL, 0),
(2, '12UCS001', 'Arjun Raja A', 9, 1, 1, '', 1, '2022-12-29 18:17:20', 0, '2022-12-30 09:42:27', 0),
(3, '13PCA001', 'Arun A', 13, 1, 1, '9955667788', NULL, NULL, NULL, NULL, 0),
(4, '13PCA002', 'Balaji A', 13, 1, 1, '9456789788', NULL, NULL, NULL, NULL, 0),
(5, '13PCA003', 'Charan S', 13, 1, 1, '9894326150', NULL, NULL, NULL, NULL, 0),
(6, '13PCA004', 'Dinesh L', 13, 1, 1, '9944537774', NULL, NULL, NULL, NULL, 0),
(7, '13PCA005', 'Ezlil K', 13, 1, 1, '', NULL, NULL, NULL, NULL, 0),
(8, '13PCA006', 'Franklin J', 13, 1, 1, '4564564564', NULL, NULL, NULL, NULL, 0),
(9, '13PCA007', 'Ganesh L', 13, 1, 1, '3216546541', NULL, NULL, NULL, NULL, 0),
(10, '13PCA008', 'Harish S', 13, 1, 1, '9879879879', NULL, NULL, NULL, NULL, 0),
(11, '13PCA009', 'Jai K', 13, 1, 1, '', NULL, NULL, NULL, NULL, 0),
(12, '13PCA010', 'Kalai S', 13, 1, 1, '', NULL, NULL, NULL, NULL, 0),
(13, '13PCA011', 'Lakshmanan R', 13, 1, 1, '', NULL, NULL, NULL, NULL, 0),
(14, '13PCA012', 'Madhan Mohan S', 13, 1, 1, '', NULL, NULL, NULL, NULL, 0),
(15, '13PCA013', 'Nithi S', 13, 1, 1, '', NULL, NULL, NULL, NULL, 0),
(16, '13PCA014', 'Om Prakash S', 13, 1, 1, '', NULL, NULL, NULL, NULL, 0),
(17, '13PCA015', 'Prakash D', 13, 1, 1, '9966554422', NULL, NULL, NULL, NULL, 0),
(18, '12ASD', 'Asd', 12, 1, 2, '', 1, '2023-02-11 21:48:30', NULL, NULL, 0),
(19, '22PCA009', 'Bharathidhasan R', 13, 1, 3, '0987654321', 1, '2023-03-25 15:19:35', NULL, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_users`
--

CREATE TABLE `tbl_users` (
  `id` tinyint(3) NOT NULL,
  `uname` varchar(100) DEFAULT NULL,
  `mobile_no` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `roles_id` tinyint(3) DEFAULT NULL,
  `status` tinyint(2) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` text CHARACTER SET utf8mb4 NOT NULL,
  `hint_password` varchar(100) NOT NULL,
  `created_by` tinyint(3) DEFAULT NULL,
  `created_dt` datetime DEFAULT NULL,
  `updated_by` tinyint(3) DEFAULT NULL,
  `updated_dt` datetime DEFAULT NULL,
  `del_status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_users`
--

INSERT INTO `tbl_users` (`id`, `uname`, `mobile_no`, `email`, `roles_id`, `status`, `username`, `password`, `hint_password`, `created_by`, `created_dt`, `updated_by`, `updated_dt`, `del_status`) VALUES
(1, 'Ragupathy', '9944537774', 'ragupathyit@gmail.com', 1, 1, 'admin', 'e122911e07b7fe7df3cb4eaf9cd03f57', 'admin1234', 1, '2023-01-07 15:48:57', 0, '2023-01-07 16:28:03', 0),
(2, 'Somasundaram', '9894326150', '', NULL, 1, 'somasundaram', 'f935d1f8194b39a5a40843e383359a68', 'somuji', 1, '2023-01-26 16:11:31', 0, '2023-01-26 19:08:08', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `att_dayorder`
--
ALTER TABLE `att_dayorder`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `att_timetable`
--
ALTER TABLE `att_timetable`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_course`
--
ALTER TABLE `exam_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `exam_course_type`
--
ALTER TABLE `exam_course_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_feesmaster`
--
ALTER TABLE `fc_feesmaster`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_feesstructure`
--
ALTER TABLE `fc_feesstructure`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fc_feesstructure_details`
--
ALTER TABLE `fc_feesstructure_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `internal_course_mapping`
--
ALTER TABLE `internal_course_mapping`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `tbl_community`
--
ALTER TABLE `tbl_community`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_degree`
--
ALTER TABLE `tbl_degree`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_department`
--
ALTER TABLE `tbl_department`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_internal_marks`
--
ALTER TABLE `tbl_internal_marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_staffs`
--
ALTER TABLE `tbl_staffs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_students`
--
ALTER TABLE `tbl_students`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_users`
--
ALTER TABLE `tbl_users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `att_dayorder`
--
ALTER TABLE `att_dayorder`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `att_timetable`
--
ALTER TABLE `att_timetable`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `exam_course`
--
ALTER TABLE `exam_course`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `exam_course_type`
--
ALTER TABLE `exam_course_type`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `fc_feesmaster`
--
ALTER TABLE `fc_feesmaster`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `fc_feesstructure`
--
ALTER TABLE `fc_feesstructure`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `fc_feesstructure_details`
--
ALTER TABLE `fc_feesstructure_details`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `internal_course_mapping`
--
ALTER TABLE `internal_course_mapping`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `lib_books`
--
ALTER TABLE `lib_books`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `lib_location`
--
ALTER TABLE `lib_location`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `lib_publisher`
--
ALTER TABLE `lib_publisher`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `lib_vendor`
--
ALTER TABLE `lib_vendor`
  MODIFY `id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_community`
--
ALTER TABLE `tbl_community`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_degree`
--
ALTER TABLE `tbl_degree`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tbl_department`
--
ALTER TABLE `tbl_department`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_designation`
--
ALTER TABLE `tbl_designation`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_internal_marks`
--
ALTER TABLE `tbl_internal_marks`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT for table `tbl_roles`
--
ALTER TABLE `tbl_roles`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_staffs`
--
ALTER TABLE `tbl_staffs`
  MODIFY `id` smallint(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_students`
--
ALTER TABLE `tbl_students`
  MODIFY `id` bigint(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_users`
--
ALTER TABLE `tbl_users`
  MODIFY `id` tinyint(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
