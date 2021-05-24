-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2019 at 02:53 PM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `cutlinks2`
--

-- --------------------------------------------------------

--
-- Table structure for table `{DBP}contact`
--

DROP TABLE IF EXISTS `{DBP}contact`;
CREATE TABLE `{DBP}contact` (
  `id` int(255) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(255) NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{DBP}languages`
--

DROP TABLE IF EXISTS `{DBP}languages`;
CREATE TABLE `{DBP}languages` (
  `id` int(11) NOT NULL,
  `name` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `symbol` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `isRTL` int(1) NOT NULL,
  `undeletable` int(1) NOT NULL,
  `active` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `{DBP}languages`
--

INSERT INTO `{DBP}languages` (`id`, `name`, `symbol`, `isRTL`, `undeletable`, `active`) VALUES
(1, 'english', 'en', 0, 1, 1),
(2, 'arabic', 'ar', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `{DBP}links`
--
DROP TABLE IF EXISTS `{DBP}links`;
CREATE TABLE `{DBP}links` (
  `id` int(255) NOT NULL,
  `user_id` int(255) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `domain` int(11) NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `views` int(255) NOT NULL,
  `admin_views` int(255) NOT NULL,
  `modified` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `{DBP}news`
--
DROP TABLE IF EXISTS `{DBP}news`;
CREATE TABLE `{DBP}news` (
  `news_ID` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `image_URL` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `news_URL` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `created` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{DBP}online`
--
DROP TABLE IF EXISTS `{DBP}online`;
CREATE TABLE `{DBP}online` (
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agent` text COLLATE utf8_unicode_ci NOT NULL,
  `platform` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{DBP}pages`
--
DROP TABLE IF EXISTS `{DBP}pages`;
CREATE TABLE `{DBP}pages` (
  `id` int(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lang_id` int(10) NOT NULL,
  `keywords` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `published` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `show_header` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `show_footer` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `content` longtext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `uneditable` int(255) NOT NULL,
  `created` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `modified` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `{DBP}pages`
--

INSERT INTO `{DBP}pages` (`id`, `title`, `slug`, `lang_id`, `keywords`, `description`, `published`, `show_header`, `show_footer`, `content`, `uneditable`, `created`, `modified`) VALUES
(1, 'contact', 'contact', 0, 'contact,contact us,support', '', '1', '1', '1', '', 1, '1474631403', '1532733916'),
(2, 'terms', 'terms', 1, '', '', '1', '1', '1', '', 0, '1531866913', '1531869055'),
(3, 'شروط الإستخدام', 'terms', 2, 'terms,my site', 'nothing here', '1', '0', '1', '', 0, '1469443321', '1531871193'),
(4, 'سياسة الخصوصية', 'privacy', 2, '', '', '1', '0', '1', '', 0, '1469443321', '1531868254');

-- --------------------------------------------------------

--
-- Table structure for table `{DBP}settings`
--
DROP TABLE IF EXISTS `{DBP}settings`;
CREATE TABLE `{DBP}settings` (
  `option_id` int(255) NOT NULL,
  `option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `option_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `autoload` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `{DBP}settings`
--

INSERT INTO `{DBP}settings` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'sitename', '', 'yes'),
(2, 'siteurl', '', 'yes'),
(4, 'powredby', 'Mohammed Ramouchy from MR4Web.com', 'no'),
(6, 'siteclose', '0', 'yes'),
(7, 'secret_key', '', 'no'),
(8, 'public_key', '', 'no'),
(9, 'cookie_expire', '1296000', 'yes'),
(10, 'site_domain', '', 'yes'),
(11, 'use_cookie_on_https', '0', 'yes'),
(12, 'hide_cookie_from_js', '1', 'yes'),
(13, 'cookie_name', 'U', 'yes'),
(14, 'default_language', '1', 'yes'),
(15, 'default_timezone', 'Africa/Casablanca', 'yes'),
(16, 'shutdown_msg', '<h1>The site isn\'t available for now, please try again later.</h1>', 'no'),
(17, 'tracking_code', '', 'no'),
(18, 'registration_status', '1', 'no'),
(19, 'user_delete_account', '0', 'no'),
(20, 'user_page_path', 'account', 'no'),
(21, 'admin_page_path', 'adminpanel', 'yes'),
(22, 'recaptcha_status', '0', 'no'),
(23, 'time_format', 'd-m-Y H:i', 'yes'),
(24, 'shutdown_msg_register', 'Sorry, you can\'t register now, please try later.', 'no'),
(25, 'keywords', '', 'yes'),
(26, 'description', '', 'yes'),
(27, 'show_logo', '0', 'yes'),
(28, 'restoration_time_account', '1', 'no'),
(29, 'email_method', 'mail', 'no'),
(30, 'email_from', '', 'no'),
(31, 'SMTP_Host', '', 'no'),
(32, 'SMTP_Port', '', 'no'),
(33, 'SMTP_User', '', 'no'),
(34, 'SMTP_Pass', '', 'no'),
(35, 'mail_encription', 'tls', 'no'),
(36, 'allow_SSL_Insecure_mode', '0', 'no'),
(37, 'ad_728x90', '728 x 90', 'no'),
(38, 'ad_300x250', '300 x 250', 'no'),
(39, 'ad_300x600', '300 x 600', 'no'),
(40, 'ad_autosize', 'autosize ads', 'no'),
(41, 'ads_status', '0', 'yes'),
(42, 'ads_status_on_accounts', '0', 'yes'),
(43, 'notes_delete_account', 'you can delete (block) your account from here.<br>', 'no'),
(44, 'countdown', '15', 'no'),
(45, 'admin_pub', '', 'no'),
(46, 'admin_channel', '0', 'no'),
(47, 'just_show_admin_ads', '0', 'no'),
(48, 'just_show_users_ads', '0', 'no'),
(49, 'bad_urls', 'gsurl.in\r\nlinkshrink.net\r\nadf.ly', 'no'),
(50, 'go_head_code', '', 'no'),
(51, 'showFakeNumbers', '1', 'no'),
(52, 'fakeViews', '35000', 'no'),
(53, 'fakeUsers', '500', 'no'),
(54, 'fakeLinks', '1400', 'no'),
(55, 'packages_domains', '', 'no'),
(56, 'purchase_code', '', 'yes'),
(57, 'viewed_news', '1', 'yes'),
(58, 'last_update', '0', 'yes'),
(59, 'social_media_facebook', '', 'no'),
(60, 'social_media_twitter', '', 'no'),
(61, 'social_media_youtube', '', 'no'),
(62, 'social_media_github', '', 'no'),
(63, 'social_media_linkedin', '', 'no'),
(64, 'social_media_reddit', '', 'no'),
(65, 'social_media_pinterest', '', 'no'),
(66, 'social_media_tumblr', '', 'no'),
(67, "social_media_instagram", "", "no"),
(98, "world_wide", "0.4", "no");


-- --------------------------------------------------------

--
-- Table structure for table `{DBP}statistics`
--
DROP TABLE IF EXISTS `{DBP}statistics`;
CREATE TABLE `{DBP}statistics` (
  `id` int(255) NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Table structure for table `{DBP}updates`
--
DROP TABLE IF EXISTS `{DBP}updates`;
CREATE TABLE `{DBP}updates` (
  `update_ID` int(11) NOT NULL,
  `product_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `product_version` varchar(5) COLLATE utf8_unicode_ci NOT NULL,
  `update_download_url` varchar(300) COLLATE utf8_unicode_ci NOT NULL,
  `features` text COLLATE utf8_unicode_ci NOT NULL,
  `time` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `{DBP}users`
--
DROP TABLE IF EXISTS `{DBP}users`;
CREATE TABLE `{DBP}users` (
  `id` int(255) NOT NULL,
  `username` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_joined` int(255) NOT NULL,
  `user_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_verified` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `account_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


--
-- Table structure for table `{DBP}usersmeta`
--
DROP TABLE IF EXISTS `{DBP}usersmeta`;
CREATE TABLE `{DBP}usersmeta` (
  `user_id` int(11) NOT NULL,
  `user_option` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for table `{DBP}contact`
--
ALTER TABLE `{DBP}contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{DBP}languages`
--
ALTER TABLE `{DBP}languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{DBP}links`
--
ALTER TABLE `{DBP}links`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `{DBP}links` ADD FULLTEXT KEY `title` (`title`);
ALTER TABLE `{DBP}links` ADD FULLTEXT KEY `slug` (`slug`);
ALTER TABLE `{DBP}links` ADD FULLTEXT KEY `title_2` (`title`,`slug`);

--
-- Indexes for table `{DBP}news`
--
ALTER TABLE `{DBP}news`
  ADD PRIMARY KEY (`news_ID`);

--
-- Indexes for table `{DBP}pages`
--
ALTER TABLE `{DBP}pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{DBP}settings`
--
ALTER TABLE `{DBP}settings`
  ADD PRIMARY KEY (`option_id`);

--
-- Indexes for table `{DBP}statistics`
--
ALTER TABLE `{DBP}statistics`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `{DBP}updates`
--
ALTER TABLE `{DBP}updates`
  ADD PRIMARY KEY (`update_ID`);

--
-- Indexes for table `{DBP}users`
--
ALTER TABLE `{DBP}users`
  ADD PRIMARY KEY (`id`);
ALTER TABLE `{DBP}users` ADD FULLTEXT KEY `username` (`username`,`email`,`user_token`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `{DBP}contact`
--
ALTER TABLE `{DBP}contact`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `{DBP}languages`
--
ALTER TABLE `{DBP}languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `{DBP}links`
--
ALTER TABLE `{DBP}links`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `{DBP}news`
--
ALTER TABLE `{DBP}news`
  MODIFY `news_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `{DBP}pages`
--
ALTER TABLE `{DBP}pages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `{DBP}settings`
--
ALTER TABLE `{DBP}settings`
  MODIFY `option_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=69;
--
-- AUTO_INCREMENT for table `{DBP}statistics`
--
ALTER TABLE `{DBP}statistics`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `{DBP}updates`
--
ALTER TABLE `{DBP}updates`
  MODIFY `update_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `{DBP}users`
--
ALTER TABLE `{DBP}users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;
