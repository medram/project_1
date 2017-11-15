CREATE TABLE `{DBP}contact` (
  `id` int(255) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(255) NOT NULL,
  `content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

{BR}

CREATE TABLE `{DBP}links` (
  `id` int(255) NOT NULL,
  `user_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `views` int(255) NOT NULL,
  `admin_views` int(255) NOT NULL,
  `modified` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

{BR}

CREATE TABLE `{DBP}online` (
  `id` int(255) NOT NULL,
  `ip` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `agent` text COLLATE utf8_unicode_ci NOT NULL,
  `platform` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `time` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

{BR}

CREATE TABLE `{DBP}pages` (
  `id` int(255) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `slug` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
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

{BR}

INSERT INTO `{DBP}pages` (`id`, `title`, `slug`, `keywords`, `description`, `published`, `show_header`, `show_footer`, `content`, `uneditable`, `created`, `modified`) VALUES
(1, 'اتصل بنا', 'contact', 'contact,contact us,support', '', '1', '1', '1', '', 1, '1474631403', '1474635467'),
(2, 'شروط الإستخدام', 'terms', 'terms,my site', 'nothing here', '1', '0', '1', '', 1, '1469443321', '1472655319'),
(3, 'سياسة الخصوصية', 'privacy', '', '', '1', '0', '1', '', 1, '1469443321', '1470350739');

{BR}

CREATE TABLE `{DBP}settings` (
  `option_id` int(255) NOT NULL,
  `option_name` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `option_value` text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `autoload` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

{BR}

INSERT INTO `{DBP}settings` (`option_id`, `option_name`, `option_value`, `autoload`) VALUES
(1, 'sitename', '', 'yes'),
(2, 'siteurl', '', 'yes'),
(3, 'version', '1.0.0', 'yes'),
(4, 'powredby', 'MOHAMMED RAMOUCHY', 'no'),
(6, 'siteclose', '0', 'yes'),
(7, 'secret_key', '', 'no'),
(8, 'public_key', '', 'no'),
(9, 'cookie_expire', '864000', 'yes'),
(10, 'site_domain', '', 'yes'),
(11, 'use_cookie_on_https', '0', 'yes'),
(12, 'hide_cookie_from_js', '1', 'yes'),
(13, 'cookie_name', 'U_C', 'yes'),
(14, 'default_language', 'en', 'no'),
(15, 'default_timezone', 'Africa/Casablanca', 'yes'),
(16, 'shutdown_msg', '<h1>عذرا الموقع مغلق حاليا ، عد لاحقا من فضلك</h1>', 'no'),
(17, 'tracking_code', '', 'no'),
(18, 'registration_status', '1', 'no'),
(19, 'user_delete_account', '1', 'no'),
(20, 'user_page_path', 'account', 'no'),
(21, 'admin_page_path', 'adminpanel', 'yes'),
(22, 'recaptcha_status', '0', 'no'),
(23, 'time_format', 'd-m-Y H:i', 'yes'),
(24, 'shutdown_msg_register', 'عذرا، لا يمكنك التسجيل بالموقع حاليا ، عد لاحقا !', 'no'),
(25, 'keywords', '', 'yes'),
(26, 'description', '', 'yes'),
(27, 'show_logo', '0', 'yes'),
(28, 'restoration_time_account', '5', 'no'),
(29, 'email_method', 'mail', 'no'),
(30, 'email_from', '', 'no'),
(31, 'SMTP_Host', '', 'no'),
(32, 'SMTP_Port', '', 'no'),
(33, 'SMTP_User', '', 'no'),
(34, 'SMTP_Pass', '', 'no'),
(35, 'mail_encription', 'tls', 'no'),
(36, 'ad_728x90', '728 x 90', 'no'),
(37, 'ad_300x250', '300 x 250', 'no'),
(38, 'ad_300x600', '300 x 600', 'no'),
(39, 'ad_autosize', 'autosize script here', 'no'),
(40, 'ads_status', '0', 'yes'),
(41, 'ads_status_on_accounts', '0', 'yes'),
(42, 'notes_delete_account', '', 'no'),
(43, 'countdown', '10', 'no'),
(44, 'admin_pub', '', 'no'),
(45, 'admin_channel', '0', 'no'),
(46, 'user_activation_ads', '1', 'no'),
(47, 'cencored_words_status', '1', 'no'),
(48, 'bad_words', 'aaa,xxxx,yyyy,zzzz', 'no'),
(49, 'bad_urls', 'http://www.exemple.com\r\nhttp://www.exemple2.com\r\n...', 'no');

{BR}

CREATE TABLE `{DBP}statistics` (
  `id` int(255) NOT NULL,
  `user_token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `date` date NOT NULL,
  `views` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

{BR}

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

{BR}

CREATE TABLE `{DBP}usersmeta` (
  `id` int(255) NOT NULL,
  `user_token` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_option` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `user_value` varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

{BR}

ALTER TABLE `{DBP}contact`
  ADD PRIMARY KEY (`id`);

{BR}

ALTER TABLE `{DBP}links`
  ADD PRIMARY KEY (`id`);

{BR}

ALTER TABLE `{DBP}online`
  ADD PRIMARY KEY (`id`);

{BR}

ALTER TABLE `{DBP}pages`
  ADD PRIMARY KEY (`id`);

{BR}

ALTER TABLE `{DBP}settings`
  ADD PRIMARY KEY (`option_id`);

{BR}

ALTER TABLE `{DBP}statistics`
  ADD PRIMARY KEY (`id`);

{BR}

ALTER TABLE `{DBP}users`
  ADD PRIMARY KEY (`id`);

{BR}

ALTER TABLE `{DBP}usersmeta`
  ADD PRIMARY KEY (`id`);

{BR}

ALTER TABLE `{DBP}contact`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

{BR}

ALTER TABLE `{DBP}links`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

{BR}

ALTER TABLE `{DBP}online`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

{BR}

ALTER TABLE `{DBP}pages`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

{BR}

ALTER TABLE `{DBP}settings`
  MODIFY `option_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

{BR}

ALTER TABLE `{DBP}statistics`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

{BR}

ALTER TABLE `{DBP}users`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

{BR}

ALTER TABLE `{DBP}usersmeta`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=944;