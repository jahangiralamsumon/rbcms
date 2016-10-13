-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 16, 2016 at 03:34 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zeerowapp_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `feedbacks`
--

CREATE TABLE `feedbacks` (
  `id` int(11) NOT NULL COMMENT 'primary key,auto increment,type: int(11)',
  `company_id` int(11) NOT NULL COMMENT 'type: int(11)',
  `name` varchar(30) NOT NULL COMMENT 'type: varchar(30)',
  `email` varchar(60) NOT NULL COMMENT 'type: varchar(60)',
  `subject` varchar(255) NOT NULL COMMENT 'type: varchar(255)',
  `date` datetime NOT NULL COMMENT 'type: datetime',
  `replied_date` datetime NOT NULL COMMENT 'type: datetime',
  `status` tinyint(4) NOT NULL COMMENT '0 = pending, 1 = replied, type: tinyint(4)',
  `message` text NOT NULL COMMENT 'type: text',
  `replied_message` text NOT NULL COMMENT 'type: text'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `feedbacks`
--
ALTER TABLE `feedbacks`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedbacks`
--
ALTER TABLE `feedbacks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key,auto increment,type: int(11)';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


 
INSERT INTO `sub_modules` (`id`, `module_id`, `name`, `controller_name`, `icon`, `sequence`, `created_on`, `modified_on`) VALUES
	(2090, 1006, 'Feedback Management', 'Feedbacks', '<i class="fa  fa-angle-double-right"></i>', 1, '2016-08-08 13:19:32', '0000-00-00 00:00:00');

INSERT INTO `pages` (`id`, `module_id`, `sub_module_id`, `name`, `method_name`, `available_to_company`, `created_on`, `modified_on`) VALUES
	(3091, 1006, 2090, 'Feedback List', 'index', 1, '2016-08-08 13:23:19', '0000-00-00 00:00:00'),
	(3092, 1006, 2090, 'Delete Feedback', 'delete', 1, '2016-08-08 13:27:04', '0000-00-00 00:00:00'),
	(3093, 1006, 2090, 'Reply Feedback', 'reply', 1, '2016-08-08 13:28:35', '0000-00-00 00:00:00');	
