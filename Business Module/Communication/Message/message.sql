-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 19, 2016 at 01:22 PM
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
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `msg_id` int(11) NOT NULL,
  `ref_msg_id` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Not Replied Message',
  `subject` varchar(120) NOT NULL,
  `msg_content` text NOT NULL,
  `user_id` int(11) NOT NULL,
  `msg_date` datetime NOT NULL,
  `is_read` int(11) NOT NULL DEFAULT '0' COMMENT '0 = Not Read, 1 = Read',
  `sender_id` int(11) NOT NULL,
  `is_deleted` tinyint(11) NOT NULL DEFAULT '0' COMMENT '0 = Not Deleted, 1 = Deleted',
  `is_sent_msg_deleted` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0 = Not Deleted, 1 = Deleted'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`msg_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;






INSERT INTO `sub_modules` (`id`, `module_id`, `name`, `controller_name`, `icon`, `sequence`, `created_on`, `modified_on`) VALUES
	(2080, 1006, 'Message', 'Message', '<i class="fa fa-comments-o"></i>', 2, '2016-08-09 08:51:48', '0000-00-00 00:00:00');

INSERT INTO `pages` (`id`, `module_id`, `sub_module_id`, `name`, `method_name`, `available_to_company`, `created_on`, `modified_on`) VALUES
	(4000, 1006, 2080, 'Inbox', 'index', 1, '2016-08-09 08:58:00', '0000-00-00 00:00:00'),
	(4001, 1006, 2080, 'Send Message', 'send', 1, '2016-08-09 11:07:23', '0000-00-00 00:00:00'),
	(4002, 1006, 2080, 'View Message', 'view', 1, '2016-08-09 11:12:09', '0000-00-00 00:00:00'),
	(4003, 1006, 2080, 'Reply ', 'reply', 1, '2016-08-09 11:13:42', '0000-00-00 00:00:00'),
	(4004, 1006, 2080, 'Sent', 'sent', 1, '2016-08-09 11:14:29', '0000-00-00 00:00:00'),
	(4005, 1006, 2080, 'Delete Message', 'delete', 1, '2016-08-10 06:34:49', '0000-00-00 00:00:00'),
	(4006, 1006, 2080, 'View Sent Message', 'sentview', 1, '2016-08-19 16:44:05', '0000-00-00 00:00:00'),
	(4007, 1006, 2080, 'Delete Sent Message', 'sentdelete', 1, '2016-08-19 16:44:48', '0000-00-00 00:00:00');	
