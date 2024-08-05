-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Oct 02, 2021 at 06:25 PM
-- Server version: 5.7.31
-- PHP Version: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apam`
--

-- --------------------------------------------------------

--
-- Table structure for table `apartments`
--

DROP TABLE IF EXISTS `apartments`;
CREATE TABLE IF NOT EXISTS `apartments` (
  `apartment_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(500) NOT NULL,
  `floors` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `location` varchar(500) NOT NULL,
  `agent_id` int(11) NOT NULL,
  `date_added` int(11) NOT NULL,
  `delete_flag` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`apartment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apartments`
--

INSERT INTO `apartments` (`apartment_id`, `name`, `floors`, `description`, `location`, `agent_id`, `date_added`, `delete_flag`) VALUES
(1, 'Mtungo Flats', '30', 'It has a swimming pool. Very good climate.', 'Nakuru', 66, 1566470127, 0),
(2, 'Mlimani Flats', '12', 'In Kangundo road near Kamulu.', 'Nairobi', 66, 1565184664, 0),
(3, 'Kamba Flats', '', 'Machakos town apposite Peter Mulei Wholesale building', 'Machakos', 66, 1623591561, 0),
(4, 'Felister\'s Flats', '90', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. \n', 'Mombasa', 66, 1565340554, 0),
(5, 'Queens Hostel', '7', 'Located a long machakos university highway', 'Machakos', 66, 1626371243, 0);

-- --------------------------------------------------------

--
-- Table structure for table `app_config`
--

DROP TABLE IF EXISTS `app_config`;
CREATE TABLE IF NOT EXISTS `app_config` (
  `key` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `app_config`
--

INSERT INTO `app_config` (`key`, `value`) VALUES
('address', 'P.o Box 2345-90100  \\n Machakos'),
('company', 'Apam Apartments'),
('currency_side', '0'),
('currency_symbol', 'ksh.'),
('email', 'info@apam.com'),
('expense_categories', '[\"Dstv\",\"Food\",\"Internet\",\"Water\",\"Salary\"]'),
('fax', '0'),
('language', 'en'),
('logo', 'o_1falllqq21hmbnrmol1nn919ba7.JPG'),
('phone', '+25480737883'),
('timezone', 'Africa/Nairobi'),
('website', 'https://www.apam.com');

-- --------------------------------------------------------

--
-- Table structure for table `attachments`
--

DROP TABLE IF EXISTS `attachments`;
CREATE TABLE IF NOT EXISTS `attachments` (
  `attachment_id` int(11) NOT NULL AUTO_INCREMENT,
  `loan_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `filename` varchar(100) NOT NULL,
  `descriptions` varchar(100) NOT NULL,
  `session_id` varchar(100) NOT NULL,
  PRIMARY KEY (`attachment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `attachments`
--

INSERT INTO `attachments` (`attachment_id`, `loan_id`, `tenant_id`, `filename`, `descriptions`, `session_id`) VALUES
(1, 0, 0, 'o_1av647e1p1q191c5rk5hdrfkc47.jpg', '', '1');

-- --------------------------------------------------------

--
-- Table structure for table `expenses`
--

DROP TABLE IF EXISTS `expenses`;
CREATE TABLE IF NOT EXISTS `expenses` (
  `expense_id` int(11) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) NOT NULL DEFAULT 'others',
  `description` text NOT NULL,
  `amount` int(11) NOT NULL,
  `added_by` int(11) NOT NULL,
  `date` date NOT NULL,
  `delete_flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`expense_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenses`
--

INSERT INTO `expenses` (`expense_id`, `category`, `description`, `amount`, `added_by`, `date`, `delete_flag`) VALUES
(1, 'Water', 'Hello', 2000, 66, '2019-08-22', 0),
(2, 'Water', 'Borehole at Felisters apartments', 200000, 66, '2019-08-27', 0),
(3, 'Dstv', 'Payment for dstv for mohamud Ali', 5000, 66, '2021-07-15', 0);

-- --------------------------------------------------------

--
-- Table structure for table `houses`
--

DROP TABLE IF EXISTS `houses`;
CREATE TABLE IF NOT EXISTS `houses` (
  `house_id` int(11) NOT NULL AUTO_INCREMENT,
  `apartment_id` int(11) NOT NULL,
  `house_no` varchar(100) NOT NULL,
  `house_type` varchar(100) NOT NULL,
  `features` text NOT NULL,
  `description` text NOT NULL,
  `status` varchar(100) NOT NULL DEFAULT 'vacant',
  `rent` varchar(100) NOT NULL,
  PRIMARY KEY (`house_id`),
  UNIQUE KEY `house_no` (`house_no`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `houses`
--

INSERT INTO `houses` (`house_id`, `apartment_id`, `house_no`, `house_type`, `features`, `description`, `status`, `rent`) VALUES
(1, 1, 'M001', '3 Bedroom', '[\"wifi\",\"hot_shower\",\"dstv\"]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, ratione atque. Voluptate sunt deserunt harum quos velit, vero dolorum, nobis natus voluptatem nisi iure corporis fugiat illum inventore eius quas.\n', 'Under maintenance', '16,000'),
(2, 1, 'M002', '1 Bedroom', '[\"wifi\",\"dstv\"]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, ratione atque. Voluptate sunt deserunt harum quos velit, vero dolorum, nobis natus voluptatem nisi iure corporis fugiat illum inventore eius quas.\n', 'Occupied', '12000'),
(3, 1, 'M003', '3 Bedroom', '[\"hot_shower\"]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, ratione atque. Voluptate sunt deserunt harum quos velit, vero dolorum, nobis natus voluptatem nisi iure corporis fugiat illum inventore eius quas.\n', 'Occupied', '13000'),
(4, 1, 'M004', '4 Bedroom', '[\"hot_shower\",\"dstv\"]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, ratione atque. Voluptate sunt deserunt harum quos velit, vero dolorum, nobis natus voluptatem nisi iure corporis fugiat illum inventore eius quas.\n', 'Out of order', '20000'),
(5, 2, 'ML001', 'Double Room', '[\"wifi\",\"hot_shower\",\"dstv\"]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, ratione atque. Voluptate sunt deserunt harum quos velit, vero dolorum, nobis natus voluptatem nisi iure corporis fugiat illum inventore eius quas.\n', 'Occupied', '14,000'),
(6, 2, 'ML002', 'Double Room', '[\"wifi\",\"hot_shower\",\"dstv\"]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, ratione atque. Voluptate sunt deserunt harum quos velit, vero dolorum, nobis natus voluptatem nisi iure corporis fugiat illum inventore eius quas.\n', 'Occupied', '10000'),
(7, 2, 'ML003', 'Singe Room', '[\"wifi\",\"hot_shower\"]', 'Lorem ipsum', 'Out of order', '3000'),
(17, 2, 'ML004', 'Singe Room', '[\"dstv\"]', 'HELLO', 'Vacant', '2000'),
(18, 2, 'ML005', 'Bedsitter', '[\"hot_shower\",\"dstv\"]', 'HELLO', 'occupied', '2000'),
(19, 2, 'ML006', 'Bedsitter', '[\"dstv\"]', 'HELLO', 'Vacant', '2000'),
(8, 3, 'K001', '2 Bedroom', '[\"wifi\",\"hot_shower\",\"dstv\"]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, ratione atque. Voluptate sunt deserunt harum quos velit, vero dolorum, nobis natus voluptatem nisi iure corporis fugiat illum inventore eius quas.\n', 'Out of order', '3000'),
(9, 3, 'K002', '5 Bedroom', '[\"wifi\",\"hot_shower\"]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, ratione atque. Voluptate sunt deserunt harum quos velit, vero dolorum, nobis natus voluptatem nisi iure corporis fugiat illum inventore eius quas.\n', 'Occupied', '3000'),
(10, 3, 'K003', '4 Bedroom', '[\"hot_shower\",\"dstv\"]', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laborum, ratione atque. Voluptate sunt deserunt harum quos velit, vero dolorum, nobis natus voluptatem nisi iure corporis fugiat illum inventore eius quas.\n', 'Occupied', '3000'),
(12, 1, 'MLOO5', '2 Bedroom', '[\"wifi\",\"hot_shower\"]', 'BLAHBAH', 'vacant', '7000'),
(13, 4, 'F001', '2 Bedroom', '[\"wifi\",\"water\"]', 'I am felistus', 'Vacant', '15,000'),
(14, 4, 'F002', '2 Bedroom', '[\"wifi\",\"water\"]', 'I am felistus', 'Vacant', '20,000'),
(20, 2, 'ML007', 'Singe Room', '[\"hot_shower\"]', 'HELO', 'vacant', '2000'),
(21, 1, 'ML010', '3 Bedroom', '[\"wifi\",\"hot_shower\",\"dstv\"]', 'NEW', 'Occupied', '20000'),
(22, 1, 'ML011', 'Singe Room', '[\"wifi\",\"dstv\",\"water\"]', 'cool', 'Vacant', '20000'),
(23, 3, 'K004', '2 Bedroom', '[\"wifi\",\"hot_shower\",\"water\"]', 'I have nothing', 'Vacant', '20000'),
(24, 5, 'Q001', 'Bedsitter', '[\"wifi\",\"water\"]', 'In good condition', 'occupied', '7000'),
(25, 5, 'Q002', '1 Bedroom', '[\"wifi\",\"hot_shower\",\"dstv\",\"water\"]', 'In good condition', 'occupied', '10000'),
(26, 5, 'Q003', '2 Bedroom', '[\"wifi\",\"hot_shower\",\"water\"]', 'in good condition', 'Vacant', '15000');

-- --------------------------------------------------------

--
-- Table structure for table `letters`
--

DROP TABLE IF EXISTS `letters`;
CREATE TABLE IF NOT EXISTS `letters` (
  `letter_id` int(11) NOT NULL AUTO_INCREMENT,
  `address` text NOT NULL,
  `subject` varchar(100) NOT NULL,
  `created_by` varchar(20) NOT NULL,
  `message` text NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `delete_flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`letter_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `letters`
--

INSERT INTO `letters` (`letter_id`, `address`, `subject`, `created_by`, `message`, `date_created`, `delete_flag`) VALUES
(8, 'JOHN', 'Hello', '66   ', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod\ntempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,\nquis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo\nconsequat. Duis aute irure dolor in reprehenderit in voluptate velit esse\ncillum dolore eu fugiat nulla pariatur. ', '2019-08-12 21:00:00', 0),
(10, 'mutua', 'Hello', '66 ', 'gfdsvsdvsdvsv', '2019-11-02 21:00:00', 0),
(11, 'Mr ken', 'vacate', '66 ', 'Vacate because of this reason', '2019-12-28 21:00:00', 0),
(9, 'john,', 'Hello', '66   ', 'hello hello hello hello helloo', '2019-08-19 21:00:00', 0),
(12, 'Mr Kamau', 'vacate', '66 ', 'Vacate right now', '2020-02-24 21:00:00', 0),
(13, 'Mohamud Ali', 'You should pay rent', '66  ', 'You should vacate immediately because you have this and this which is illegal.', '2021-07-14 21:00:00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

DROP TABLE IF EXISTS `modules`;
CREATE TABLE IF NOT EXISTS `modules` (
  `module_id` varchar(255) NOT NULL,
  `controller` varchar(50) NOT NULL,
  `sort` int(10) NOT NULL,
  `icons` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`module_id`),
  UNIQUE KEY `name_lang_key` (`controller`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `modules`
--

INSERT INTO `modules` (`module_id`, `controller`, `sort`, `icons`, `is_active`) VALUES
('apartments', 'apartments', 20, '<i class=\"fa fa-briefcase\" style=\"font-size: 50px;\"></i>', 1),
('delayed payments', 'overdues', 40, '<i class=\"fa fa-bomb\" style=\"font-size: 50px;\"></i>', 1),
('expenses', 'expenses', 67, '<i class=\"fa fa-minus-circle\" style=\"font-size: 50px;\"></i>', 1),
('letters', 'letters', 65, '<i class=\"fa fa-envelope\" style=\"font-size: 50px;\"></i>', 1),
('payments', 'payments', 30, '<i class=\"fa fa-exchange\" style=\"font-size: 50px;\"></i>', 1),
('Settings', 'config', 70, '<i class=\"fa fa-cogs\" style=\"font-size: 50px\"></i>', 1),
('staff', 'staffs', 60, '<i class=\"fa fa-users\" style=\"font-size: 50px;\"></i>', 1),
('tenants', 'tenants', 10, '<i class=\"fa fa-smile-o\" style=\"font-size: 50px;\"></i>', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
CREATE TABLE IF NOT EXISTS `payments` (
  `payment_id` int(11) NOT NULL AUTO_INCREMENT,
  `house_id` int(11) NOT NULL,
  `tenant_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `breakdown` text NOT NULL,
  `paid_by` varchar(100) NOT NULL,
  `paid_for` varchar(100) NOT NULL,
  `teller_id` int(11) NOT NULL,
  `date_paid` date NOT NULL,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `remarks` varchar(2000) NOT NULL,
  `delete_flag` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`payment_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `house_id`, `tenant_id`, `amount`, `payment_method`, `breakdown`, `paid_by`, `paid_for`, `teller_id`, `date_paid`, `date_modified`, `remarks`, `delete_flag`) VALUES
(1, 7, 310, '3000.00', 'cash', '{\"deposit\":\"1500\",\"rent\":\"1500\"}', 'mutiso', '{\"month\":\"3\",\"year\":\" 2019\"}', 66, '2019-08-19', '2019-08-21 21:00:00', 'Good', 0),
(2, 14, 311, '30000.00', 'cash', '{\"deposit\":\"10000\",\"rent\":\"20000\"}', 'john', '{\"month\":\"4\",\"year\":\" 2021\"}', 66, '2019-08-18', '2019-08-21 21:00:00', 'better', 0),
(3, 18, 314, '2000.00', 'cash', '{\"deposit\":\"1000\",\"rent\":\"1000\"}', 'Sean', '{\"month\":\"5\",\"year\":\" 2020\"}', 66, '2019-08-20', '2019-08-21 21:00:00', 'good', 0),
(4, 12, 321, '14000.00', 'cash', '{\"deposit\":\"7000\",\"rent\":\"7000\"}', 'Kelvin', '{\"month\":\"8\",\"year\":\" 2019\"}', 320, '2019-08-22', '2019-08-22 10:29:02', 'good', 0),
(5, 7, 310, '3000.00', 'cash', '{\"deposit\":\"1500\",\"rent\":\"1500\"}', 'john', '{\"month\":\"8\",\"year\":\" 2019\"}', 320, '2019-08-23', '2019-08-23 10:19:18', 'good', 0),
(6, 12, 312, '7000.00', 'cash', '{\"deposit\":\"3500\",\"rent\":\"3500\"}', 'Sean', '{\"month\":\"8\",\"year\":\" 2019\"}', 320, '2019-08-23', '2019-08-23 10:29:19', 'good', 0),
(7, 20, 313, '2000.00', 'cash', '{\"deposit\":\"1000\",\"rent\":\"1000\"}', 'Sean', '{\"month\":\"8\",\"year\":\" 2019\"}', 320, '2019-08-23', '2019-08-23 10:34:41', 'good', 0),
(8, 20, 315, '2000.00', 'cash', '{\"deposit\":\"1000\",\"rent\":\"1000\"}', 'Ken', '{\"month\":\"8\",\"year\":\" 2019\"}', 320, '2019-08-23', '2019-08-23 10:35:26', 'good', 0),
(9, 20, 315, '1500.00', 'cash', '{\"deposit\":\"0\",\"rent\":\"1500\"}', 'Ken', '{\"month\":\"8\",\"year\":\" 2020\"}', 66, '2019-08-26', '2020-02-26 21:00:00', 'not good', 0),
(10, 7, 310, '1000.00', 'cash', '{\"deposit\":\"0\",\"rent\":\"1000\"}', 'john', '{\"month\":\"8\",\"year\":\" 2019\"}', 66, '2019-08-26', '2019-08-26 12:15:14', 'not good', 0),
(11, 10, 326, '4000.00', 'mpesa', '{\"deposit\":\"1000\",\"rent\":\"3000\"}', 'Dante', '{\"month\":\"7\",\"year\":\" 2021\"}', 66, '2021-06-13', '2021-06-13 13:46:43', 'paid in full', 0),
(12, 24, 327, '10000.00', 'bank_transfer', '{\"deposit\":\"7000\",\"rent\":\"3000\"}', 'Mohamud', '{\"month\":\"8\",\"year\":\" 2021\"}', 66, '2021-07-15', '2021-07-14 21:00:00', 'not paid in full', 0),
(13, 25, 328, '10000.00', 'mpesa', '{\"deposit\":\"10000\",\"rent\":\"0\"}', 'Moha', '{\"month\":\"8\",\"year\":\" 2021\"}', 66, '2021-07-31', '2021-07-31 17:10:01', 'not paid in full', 0);

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
CREATE TABLE IF NOT EXISTS `people` (
  `person_id` int(10) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `photo_url` varchar(255) DEFAULT NULL,
  `id_number` int(11) NOT NULL,
  `phone_number` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `home_address` varchar(255) NOT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB AUTO_INCREMENT=329 DEFAULT CHARSET=utf8;

--
-- Dumping data for table `people`
--

INSERT INTO `people` (`person_id`, `first_name`, `last_name`, `photo_url`, `id_number`, `phone_number`, `email`, `home_address`) VALUES
(66, 'admin', 'apam', NULL, 12345678, '0712345768', 'admin@apam.com', 'Nairobi'),
(310, 'john', 'jhbsxj', NULL, 12344554, '0704801487', 'test@gaml.com', 'mwala'),
(311, 'john', 'jhbsxj', NULL, 12344554, '0704801487', 'tetst@gaml.com', 'mwala'),
(312, 'Sean ', 'Baraka', NULL, 12121212, '0706801480', 'seanb@gmail.com', 'Mlimani'),
(313, 'Sean ', 'Hello', NULL, 12121212, '0704801487', 'test2@gaml.com', 'Mlimani'),
(314, 'Sean ', 'Hello', NULL, 12121212, '0704801487', 'test3@gaml.com', 'Mlimani'),
(315, 'Ken', 'Muthama', NULL, 12344554, '0789898989', 'mx@gmail.com', 'Mlimani'),
(317, 'Kelvin', 'Mboto', NULL, 123456781, '0712345678', 'vinte@gmail.com', 'Mitaboni'),
(319, 'Baraka', 'Sean', NULL, 898989898, '0789898989', 'bbaraka@gmail.com', 'Mlimani'),
(320, 'John', 'Malindi', NULL, 34289777, '0708112112', 'malindi.wambua@yahoo.com', 'mwala'),
(321, 'Kelvin', 'Mboto', NULL, 98765432, '0701995445', 'mboto@gmail.com', 'Mitaboni'),
(322, 'Sean ', 'Baraka', NULL, 98765431, '0789898989', 'seanbaraka@gmail.com', 'Mombasani'),
(323, 'Festus', 'Festus', NULL, 1234523, '0790909090', 'kisa@gmail.com', 'Uasin '),
(324, 'Diana', 'Kinyua', NULL, 78787878, '079999999', 'dayo@gmail.com', 'Nyandarua'),
(325, 'mary', 'mwongeli', NULL, 45454545, '070808080', 'ms@gmail.com', 'nyandarua'),
(326, 'Dante', 'Wambua', NULL, 347889123, '072389898989', 'dante@gmail.com', 'Machakos'),
(327, 'Mohamud', 'Ali', NULL, 798738383, '254704801788', 'mohamud@gmail.com', 'Machakos'),
(328, 'Moha', 'Abdul', NULL, 712123256, '0712123256', 'malindi.wambua9789@gmail.com', '123 main street');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
CREATE TABLE IF NOT EXISTS `sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) UNSIGNED NOT NULL DEFAULT '0',
  `user_data` text,
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`session_id`, `ip_address`, `user_agent`, `last_activity`, `user_data`) VALUES
('049d6f910d8e4925493294887435c6a0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582821459, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('07166416c70f0b9a370f328751fcffb0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605604249, ''),
('0780012e8bdb7ce610c538823c2230a4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1574135831, ''),
('07d7ff040c96e759b8234e9bf9979799', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579194007, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('0cda1efccff2f00205dc39e678640582', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579607731, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('114ed1acf792a2d3373b783216cd8752', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605516726, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('117c8c63dc4e8c2fc9baddc36184744d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36', 1606306675, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('11f9a9227c2a2b6ab01a5f36294a9861', '192.168.100.30', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36', 1585835366, ''),
('14f76bed1102de01480ad19478c4799f', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605263616, ''),
('17751f8c2b51e0d7e0f6b082e116b2ac', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36', 1619883427, ''),
('17a0ce7c1088aa7556f79e22a7b9d6f1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1574135831, ''),
('1caddf329f9d7a53e39d294a5546fe51', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.152 Safari/537.36', 1613555266, ''),
('243aa4c062791121c568769716812ac9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579162338, ''),
('269eb2a034427f8ef7834448a3d3c0b8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', 1626255337, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('27cd552fefbffb4db6f87da161644525', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', 1584015690, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('395fe63c25d2350af68d776bc5f560f7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582617879, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('3db1019397e7b691c9707fc8664c0bc8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.72 Safari/537.36', 1618911215, 'a:1:{s:9:\"person_id\";s:2:\"66\";}'),
('40a7d2f36a304950ddeeb8b48984f059', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1574232818, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('4160259e713a7be69251d9d52fc19dad', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579764416, 'a:1:{s:9:\"person_id\";s:2:\"66\";}'),
('45d10dbbd7272be18b00863455881948', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', 1580900090, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('46b4fcaa2ddaadfb43aae015de9b79d1', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.97 Safari/537.36', 1574136004, ''),
('4945d4acab177923eaf360492569d4f2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605595941, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('4960a9ff43e9403ba0f02741d0164321', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605531869, ''),
('4af43a9cee78e5cece2327002de3493d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.152 Safari/537.36', 1613555266, ''),
('4c82c912fe250c6d8627de1c480b3437', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.152 Safari/537.36', 1613555266, ''),
('5108f17a652ee80f207ad70c63dc3ebf', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', 1626372890, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:3:\"323\";}'),
('52b3bdbf9ecffa702613e7640993a2b5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582006676, ''),
('5bbae230b5afb04de1f124b7647284bd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1581936945, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('5e4b7b71f18ed6fa3506d1e9cf40a22d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1581576233, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('6b57c85561e6acb1ca7453160356ab3c', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582565586, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('6d552a43e496d2c5d532ee24d1bf0211', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 1606116987, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('6ed6f3546c4cb78ed2a998da4e781261', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', 1627751483, 'a:3:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";s:4:\"data\";N;}'),
('7328dc6eb4783a6df1e01591c2d137ef', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605610679, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('7872f72a724d6142d61b81ce08a363f0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', 1623592370, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('79f53520878c70f75fbb835a79e65b74', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36', 1606764325, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('7f5b8f60a01e2fa7cd110a2d102d70b9', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.67 Safari/537.36', 1606895061, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('828d74d4402ae481a01b2b5ba8dddae7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579162333, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('836d8227ef6921d47b5575736fb4b1de', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582616021, ''),
('89068db96a5ebf586cc5561f2f66961e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.152 Safari/537.36', 1613561387, ''),
('893ad7b563c409c03ff6c40a7cce4a97', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 1605618405, ''),
('8976ead7f133578702145ce5290ec2fc', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 1605618425, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('898b81dd81f5e88a884119a976ca1c10', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36', 1582902610, ''),
('8a8205a785c63babf6ec9e9ad965883a', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605538862, ''),
('8ae38736ba4d125fe81598b0b736bd2e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.149 Safari/537.36', 1585311800, ''),
('8f1e15cc63529030fc6c84044f9b8d37', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.212 Safari/537.36', 1624793427, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('9107a611e894081343232f5002d5db69', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.120 Safari/537.36', 1574135628, 'a:1:{s:9:\"person_id\";s:2:\"66\";}'),
('92f18909a190ca3d58278c04549eadb3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.115 Safari/537.36', 1629201074, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('93aff25d4cee8193fc18228ce618b38f', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', 1613916867, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('9472a275720e38d6a935e263238004fe', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605259225, 'a:1:{s:9:\"person_id\";s:2:\"66\";}'),
('94d1734df3067074b6f82832eaeee909', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1581936722, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('9bea29b4321bbc7536f036bb174eb297', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.115 Safari/537.36', 1628736680, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('9cbab01af45557749f7bd6db67c63e9d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579086027, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('a4ba9af6994675dadaf440653de7a586', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605598169, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('a71b506debb83c02cb7fe6293f71efec', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1581847502, 'a:1:{s:9:\"person_id\";s:2:\"66\";}'),
('a88f91465b5f28eb90cf1ceb231d56d3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', 1613921909, ''),
('ac724667b793dad5433dbdabf9c79d8b', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579080764, ''),
('ad2d601dff81d2dac6e5a900c2a57fe0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.182 Safari/537.36', 1613932780, ''),
('af1dc4741069cf4837355f7688c7b6c8', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.152 Safari/537.36', 1613561387, ''),
('b16a36127e4656ee3a8a6c6221c76765', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/77.0.3865.90 Safari/537.36', 1570024779, 'a:1:{s:9:\"person_id\";s:2:\"66\";}'),
('b1c3c7229d1e3280dedd44fbf8bb804d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582007195, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('b4acf9f9de2dee8363884ed921ee0ff4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.115 Safari/537.36', 1633060715, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('b7108a007f35ae40bb9e561880194691', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582821126, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('b9305fe8e3109e5429a49ef01abf89dc', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605260695, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('bb51dff65480f9252ad095edcd83a6d2', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605533085, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('bb64535933d2b53bf48c6fbec2128906', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582006929, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('c26ec85efe0c15c611dbca581217e122', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36', 1619869680, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('cadf50b76be8c3c8f4cbcfb78a31717e', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 1605690979, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('cb446997f837f3fcccb9d9126da009e6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579014150, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('ce061955a791ceb182b21246dd24f65c', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.198 Safari/537.36', 1606116975, ''),
('ce374038983ecee088609bae8c9281af', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582092650, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('d1f888b1d33fe0d819ded9cf63717af5', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', 1583949308, ''),
('d37dda8747939d096bdef522ae43640c', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579194027, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('d6ab5a1f8ba468b49f6c95e0a431cc7d', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605266752, ''),
('da0c6c3ad4b48867f0e0a1bfb45eec67', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605532551, 'a:1:{s:9:\"person_id\";s:2:\"66\";}'),
('dad429806c95d75b4f9951ef2347a065', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582008805, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('de836cb2cbda6baea004224b75f16b17', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1581936874, ''),
('e3d8077e54e22b9b6dc14341c88c5fd7', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', 1584016846, ''),
('e580acb63ddde012254606ee5831e877', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36', 1619980666, ''),
('e625ecb075a64cdcd5adfae0a0a10cc3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', 1584006612, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('e71deaf012ad6d943105b84b62a820b0', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36', 1580890126, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:3:\"324\";}'),
('e816690648a6f805a5397e81baf7cecd', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.72 Safari/537.36', 1618909059, 'a:1:{s:9:\"person_id\";s:2:\"66\";}'),
('e90667b852547561193cdca71449a3d6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.193 Safari/537.36', 1605595456, ''),
('e94fff673d4e1f5b348f76b66208fdfb', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36', 1619884283, ''),
('ede0c57a4eff43735b9903f59dd00db3', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.152 Safari/537.36', 1613561387, ''),
('f02777ed4dd72ff1403a4002ec387b12', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/92.0.4515.115 Safari/537.36', 1631446647, ''),
('f320fcd029a6ce5d1f8f207098942889', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1581936547, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('f852162c27aaebd097f38458de422774', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.122 Safari/537.36', 1582928609, ''),
('f853269c544304741c256e28f815d433', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.87 Safari/537.36', 1582006372, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}'),
('fb6313ef877aacd80eab75eead33ef88', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/88.0.4324.152 Safari/537.36', 1613553395, 'a:1:{s:9:\"person_id\";s:2:\"66\";}'),
('fe4cbfbdbdcff9e79e85762407e10af4', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.117 Safari/537.36', 1579194009, ''),
('ff39baff058e3c47023f32300c9a74d6', '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/80.0.3987.132 Safari/537.36', 1584015882, 'a:2:{s:9:\"user_data\";s:0:\"\";s:9:\"person_id\";s:2:\"66\";}');

-- --------------------------------------------------------

--
-- Table structure for table `staffs`
--

DROP TABLE IF EXISTS `staffs`;
CREATE TABLE IF NOT EXISTS `staffs` (
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(10) NOT NULL DEFAULT 'user',
  `person_id` int(10) NOT NULL,
  `added_by` int(10) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`person_id`),
  UNIQUE KEY `username` (`username`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staffs`
--

INSERT INTO `staffs` (`username`, `password`, `role`, `person_id`, `added_by`, `deleted`) VALUES
('admin', '21232f297a57a5a743894a0e4a801fc3', 'mgmt', 66, 66, 0),
('Festo', '827ccb0eea8a706c4c34a16891f84e7b', 'user', 323, 66, 0),
('dayo1', '8697f252713adc9d5c6a547ba55327f5', 'user', 324, 66, 0),
('mary2', '1252160b3e8f43f2fe2d23001d5152c8', 'user', 325, 324, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tenants`
--

DROP TABLE IF EXISTS `tenants`;
CREATE TABLE IF NOT EXISTS `tenants` (
  `person_id` int(10) NOT NULL,
  `house_id` int(11) DEFAULT NULL,
  `date_moved` int(11) NOT NULL DEFAULT '0',
  `deleted` int(1) NOT NULL DEFAULT '0',
  `added_by` int(5) DEFAULT NULL,
  PRIMARY KEY (`person_id`),
  KEY `person_id` (`person_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tenants`
--

INSERT INTO `tenants` (`person_id`, `house_id`, `date_moved`, `deleted`, `added_by`) VALUES
(310, 7, 0, 0, 66),
(311, 14, 0, 1, 66),
(312, 12, 1623591715, 0, 66),
(313, 20, 1577621579, 0, 66),
(314, 18, 0, 0, 66),
(315, 20, 0, 0, 66),
(321, 12, 1566556703, 0, 320),
(326, 10, 0, 0, 66),
(327, 24, 0, 0, 66),
(328, 25, 0, 0, 66);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `staffs`
--
ALTER TABLE `staffs`
  ADD CONSTRAINT `staffs_ibfk_1` FOREIGN KEY (`person_id`) REFERENCES `people` (`person_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
