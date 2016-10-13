-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 05, 2016 at 08:09 AM
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
-- Table structure for table `cmsusers`
--

CREATE TABLE `cmsusers` (
  `id` int(11) NOT NULL,
  `language` varchar(2) COLLATE utf16_unicode_ci NOT NULL,
  `username` varchar(20) COLLATE utf16_unicode_ci NOT NULL,
  `password` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf16_unicode_ci NOT NULL,
  `img_path` varchar(255) COLLATE utf16_unicode_ci NOT NULL,
  `reset_password_token` varchar(20) COLLATE utf16_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `company_id` tinyint(4) UNSIGNED NOT NULL,
  `fb_id` varchar(50) COLLATE utf16_unicode_ci DEFAULT NULL,
  `permission_version` int(11) NOT NULL DEFAULT '0',
  `user_type` tinyint(4) NOT NULL DEFAULT '3' COMMENT '1 = Super Super Admin, 2 = Company''s Admin,3 = Normal User ',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cmsuser_usergroups`
--

CREATE TABLE `cmsuser_usergroups` (
  `id` int(11) NOT NULL,
  `usergroup_id` int(11) NOT NULL,
  `cms_user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` tinyint(4) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf16_unicode_ci NOT NULL,
  `address1` varchar(50) COLLATE utf16_unicode_ci NOT NULL,
  `address2` varchar(50) COLLATE utf16_unicode_ci NOT NULL,
  `postcode` varchar(10) COLLATE utf16_unicode_ci NOT NULL,
  `phone` varchar(15) COLLATE utf16_unicode_ci NOT NULL,
  `email` varchar(50) COLLATE utf16_unicode_ci NOT NULL,
  `fax` varchar(15) COLLATE utf16_unicode_ci NOT NULL,
  `city` varchar(15) COLLATE utf16_unicode_ci NOT NULL,
  `state` varchar(15) COLLATE utf16_unicode_ci NOT NULL,
  `country` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `logo` varchar(50) COLLATE utf16_unicode_ci NOT NULL,
  `registration_no` varchar(40) COLLATE utf16_unicode_ci NOT NULL,
  `timezone` int(6) NOT NULL,
  `timezone_value` varchar(20) COLLATE utf16_unicode_ci NOT NULL,
  `tax_no` varchar(40) COLLATE utf16_unicode_ci NOT NULL,
  `no_of_employees` int(11) NOT NULL,
  `cmmi_level` tinyint(4) NOT NULL,
  `yearly_revenue` double NOT NULL,
  `hourly_rate` double NOT NULL,
  `daily_rate` double NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '1=active,0=inactive',
  `added_by` int(6) NOT NULL DEFAULT '1',
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` int(11) NOT NULL,
  `country_code` varchar(100) NOT NULL,
  `country_name` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `timeline_artist_id` int(11) DEFAULT '-1',
  `name_en` varchar(150) COLLATE utf16_unicode_ci DEFAULT '',
  `name_ja` varchar(150) COLLATE utf16_unicode_ci DEFAULT '',
  `name_zh` varchar(150) COLLATE utf16_unicode_ci DEFAULT '',
  `name_ko` varchar(150) COLLATE utf16_unicode_ci DEFAULT '',
  `name_es` varchar(150) COLLATE utf16_unicode_ci DEFAULT NULL,
  `description_en` text COLLATE utf16_unicode_ci,
  `description_ja` text COLLATE utf16_unicode_ci,
  `description_zh` text COLLATE utf16_unicode_ci,
  `description_ko` text COLLATE utf16_unicode_ci,
  `brief_intro` text COLLATE utf16_unicode_ci NOT NULL,
  `description_es` text COLLATE utf16_unicode_ci,
  `type` tinyint(1) DEFAULT '0' COMMENT '0=free group,1=paid',
  `profile_pic_url` varchar(200) COLLATE utf16_unicode_ci DEFAULT '',
  `explore_screen_image` varchar(200) COLLATE utf16_unicode_ci DEFAULT '',
  `status` tinyint(1) DEFAULT '1' COMMENT '0=inactive,1=active',
  `created_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `company_id` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `modules`
--

CREATE TABLE `modules` (
  `id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf16_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `sub_module_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `method_name` varchar(255) COLLATE utf16_unicode_ci NOT NULL,
  `available_to_company` tinyint(1) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `title` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `company_id` tinyint(4) UNSIGNED NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `role_pages`
--

CREATE TABLE `role_pages` (
  `id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `page_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `meta_tag` varchar(255) NOT NULL,
  `logo_path` varchar(255) NOT NULL,
  `favicon_path` varchar(255) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16;

-- --------------------------------------------------------

--
-- Table structure for table `sub_modules`
--

CREATE TABLE `sub_modules` (
  `id` int(11) NOT NULL,
  `module_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `controller_name` varchar(255) COLLATE utf16_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf16_unicode_ci NOT NULL,
  `sequence` int(11) NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` int(11) NOT NULL,
  `country_code` char(2) COLLATE utf8_unicode_ci NOT NULL,
  `time_zone` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `utc_offset` char(8) COLLATE utf8_unicode_ci NOT NULL,
  `utc_dst_offset` char(8) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usergroups`
--

CREATE TABLE `usergroups` (
  `id` int(11) NOT NULL,
  `group_name` varchar(100) COLLATE utf16_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL,
  `company_id` tinyint(4) UNSIGNED NOT NULL,
  `created_on` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_on` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `usergroup_roles`
--

CREATE TABLE `usergroup_roles` (
  `id` int(11) NOT NULL,
  `usergroup_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf16 COLLATE=utf16_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cmsusers`
--
ALTER TABLE `cmsusers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cmsuser_usergroups`
--
ALTER TABLE `cmsuser_usergroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `modules`
--
ALTER TABLE `modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_pages`
--
ALTER TABLE `role_pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_modules`
--
ALTER TABLE `sub_modules`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usergroups`
--
ALTER TABLE `usergroups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `usergroup_roles`
--
ALTER TABLE `usergroup_roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cmsusers`
--
ALTER TABLE `cmsusers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `cmsuser_usergroups`
--
ALTER TABLE `cmsuser_usergroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` tinyint(4) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `role_pages`
--
ALTER TABLE `role_pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `usergroups`
--
ALTER TABLE `usergroups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `usergroup_roles`
--
ALTER TABLE `usergroup_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
