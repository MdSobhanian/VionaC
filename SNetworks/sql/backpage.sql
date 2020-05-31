--
-- Table structure for table `clf_acc_users`
--

CREATE TABLE IF NOT EXISTS `clf_acc_users` (
  `user_id` mediumint(8) unsigned NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `avatar` varchar(12) COLLATE utf8_unicode_ci DEFAULT NULL,
  `avatar_gd` varchar(16) COLLATE utf8_unicode_ci DEFAULT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `joined` varchar(11) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` int(11) DEFAULT NULL,
  `forgot_login` tinyint(1) DEFAULT NULL,
  `newsletter` tinyint(1) DEFAULT '0',
  `plan` tinyint(1) NOT NULL DEFAULT '1',
  `user_ip` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `how_found` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `clf_acc_users`
--

INSERT INTO `clf_acc_users` (`user_id`, `active`, `username`, `password`, `avatar`, `avatar_gd`, `level`, `email`, `joined`, `last_login`, `forgot_login`, `newsletter`, `plan`, `user_ip`, `how_found`) VALUES
(1, 1, 'admin', 'd385a2fdcb8757e8117b9494b4597dc6', NULL, NULL, 1, 'webmaster@domain.com', '2018-10-31 05:34:18', NULL, NULL, 1, 1, '65.99.54.121', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clf_adpics`
--

CREATE TABLE IF NOT EXISTS `clf_adpics` (
  `picid` int(10) unsigned NOT NULL,
  `picfile` varchar(50) NOT NULL DEFAULT '',
  `adid` int(10) unsigned NOT NULL DEFAULT '0',
  `isevent` enum('0','1') NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_ads`
--

CREATE TABLE IF NOT EXISTS `clf_ads` (
  `adid` int(10) unsigned NOT NULL,
  `adtitle` varchar(100) NOT NULL DEFAULT '',
  `addesc` longtext NOT NULL,
  `area` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `showemail` enum('0','1','2') NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '',
  `code` varchar(35) NOT NULL DEFAULT '',
  `cityid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `subcatid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `othercontactok` enum('0','1') NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verified` enum('0','1') NOT NULL DEFAULT '0',
  `abused` int(10) unsigned NOT NULL DEFAULT '0',
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expireson` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `paid` enum('0','1','2') NOT NULL DEFAULT '2',
  `user_id` mediumint(8) unsigned DEFAULT NULL,
  `reminder` tinyint(1) NOT NULL DEFAULT '0',
  `newsletter` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_adxfields`
--

CREATE TABLE IF NOT EXISTS `clf_adxfields` (
  `adid` int(10) unsigned NOT NULL DEFAULT '0',
  `f1` varchar(255) NOT NULL DEFAULT '',
  `f2` varchar(255) NOT NULL DEFAULT '',
  `f3` varchar(255) NOT NULL DEFAULT '',
  `f4` varchar(255) NOT NULL DEFAULT '',
  `f5` varchar(255) NOT NULL DEFAULT '',
  `f6` varchar(255) NOT NULL DEFAULT '',
  `f7` varchar(255) NOT NULL DEFAULT '',
  `f8` varchar(255) NOT NULL DEFAULT '',
  `f9` varchar(255) NOT NULL DEFAULT '',
  `f10` varchar(255) NOT NULL DEFAULT '',
  `f11` varchar(255) NOT NULL DEFAULT '',
  `f12` varchar(255) NOT NULL DEFAULT '',
  `f13` varchar(255) NOT NULL DEFAULT '',
  `f14` varchar(255) NOT NULL DEFAULT '',
  `f15` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_areas`
--

CREATE TABLE IF NOT EXISTS `clf_areas` (
  `areaid` smallint(5) unsigned NOT NULL,
  `areaname` varchar(50) NOT NULL DEFAULT '',
  `cityid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pos` smallint(5) unsigned NOT NULL DEFAULT '0',
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_cats`
--

CREATE TABLE IF NOT EXISTS `clf_cats` (
  `catid` smallint(5) unsigned NOT NULL,
  `catname` varchar(50) NOT NULL DEFAULT '',
  `pos` smallint(5) unsigned NOT NULL DEFAULT '0',
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `alert` enum('0','1') NOT NULL DEFAULT '0',
  `alerttitle` varchar(50) DEFAULT NULL,
  `alertdesc` varchar(1255) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clf_cats`
--

INSERT INTO `clf_cats` (`catid`, `catname`, `pos`, `enabled`, `alert`, `alerttitle`, `alertdesc`, `timestamp`) VALUES
(8, 'Adult', 10, '1', '1', 'Disclaimer', 'This section contains sexual content, including pictorial nudity and adult language. It is to be accessed only by persons who are 18 years of age or older (and is not considered to be a minor in his/her state of residence) and who live in a community or local jurisdiction where nude pictures and explicit adult materials are not prohibited by law. By accessing this website, you are representing to us that you meet the above qualifications. A false representation may be a criminal offense.\r\n\r\nI confirm and represent that I am 18 years of age or older (and am not considered to be a minor in my state of residence) and that I am not located in a community or local jurisdiction where nude pictures or explicit adult materials are prohibited by any law. I agree to report any illegal services or activities which violate the Terms of Use. I also agree to report suspected exploitation of minors and/or human trafficking to the appropriate authorities.\r\n\r\nI have read the disclaimer and agree to all rules and regulations.', '2015-11-03 16:46:42'),
(6, 'Services', 14, '1', '0', '', '', '2015-11-03 16:40:46'),
(5, 'Jobs', 6, '1', '0', NULL, NULL, '2015-11-03 18:01:34'),
(4, 'Gigs', 8, '1', '0', '', '', '2015-11-03 16:43:53'),
(2, 'Dating', 11, '1', '1', 'Adult Content Warning', 'This section contains sexual content, including pictorial nudity and adult language. It is to be accessed only by persons who are 18 years of age or older (and is not considered to be a minor in his/her state of residence) and who live in a community or local jurisdiction where nude pictures and explicit adult materials are not prohibited by law. By accessing this website, you are representing to us that you meet the above qualifications. A false representation may be a criminal offense.\r\n\r\nI confirm and represent that I am 18 years of age or older (and am not considered to be a minor in my state of residence) and that I am not located in a community or local jurisdiction where nude pictures or explicit adult materials are prohibited by any law. I agree to report any illegal services or activities which violate the Terms of Use. I also agree to report suspected exploitation of minors and/or human trafficking to the appropriate authorities.\r\n\r\nI have read the disclaimer and agree to all rules and regulations.', '2015-11-11 21:14:30'),
(1, 'Community', 3, '1', '0', '', '', '2015-11-03 16:42:46'),
(9, 'Local Places', 1, '1', '0', '', '', '2012-11-05 22:56:25'),
(10, 'Buy/ Sell/ Trade', 2, '1', '0', '', '', '2015-11-03 16:38:54'),
(11, 'Automotive', 4, '1', '0', '', '', '2015-11-03 16:42:59'),
(12, 'Musician', 12, '1', '0', '', '', '2015-11-03 16:46:34'),
(13, 'Rentals', 7, '1', '0', '', '', '2015-11-03 18:01:30'),
(14, 'Real Estate', 5, '1', '0', '', '', '2015-11-03 18:01:34');

-- --------------------------------------------------------

--
-- Table structure for table `clf_cities`
--

CREATE TABLE IF NOT EXISTS `clf_cities` (
  `cityid` smallint(5) unsigned NOT NULL,
  `cityname` varchar(50) NOT NULL DEFAULT '',
  `countryid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `pos` smallint(5) unsigned NOT NULL DEFAULT '0',
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=360 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clf_cities`
--

INSERT INTO `clf_cities` (`cityid`, `cityname`, `countryid`, `pos`, `enabled`, `timestamp`) VALUES
(1, 'Auburn', 1, 1, '1', '2012-11-21 18:01:26'),
(2, 'Birmingham', 1, 2, '1', '2012-11-21 18:01:26'),
(3, 'Dothan', 1, 3, '1', '2012-11-21 18:01:26'),
(4, 'Florence / Muscle Shoals', 1, 4, '1', '2012-11-21 18:01:26'),
(5, 'Gadsden / Anniston', 1, 5, '1', '2012-11-21 18:01:26'),
(6, 'Huntsville', 1, 6, '1', '2012-11-21 18:01:26'),
(7, 'Mobile', 1, 7, '1', '2012-11-21 18:01:26'),
(8, 'Montgomery', 1, 8, '1', '2012-11-21 18:01:26'),
(9, 'Tuscaloosa', 1, 9, '1', '2012-11-21 18:01:26'),
(10, 'Anchorage', 2, 10, '1', '2012-11-21 18:01:26'),
(11, 'Fairbanks', 2, 11, '1', '2012-11-21 18:01:26'),
(12, 'Homer', 2, 12, '1', '2012-11-21 18:01:26'),
(13, 'Juneau', 2, 13, '1', '2012-11-21 18:01:26'),
(14, 'Kenai', 2, 14, '1', '2012-11-21 18:01:26'),
(15, 'Kodiak', 2, 15, '1', '2012-11-21 18:01:26'),
(16, 'Flagstaff / Sedona', 3, 16, '1', '2012-11-21 18:01:26'),
(17, 'Mohave County', 3, 17, '1', '2012-11-21 18:01:26'),
(18, 'Prescott', 3, 18, '1', '2012-11-21 18:01:26'),
(19, 'Phoenix', 3, 19, '1', '2012-11-21 18:01:26'),
(20, 'Sierra Vista', 3, 20, '1', '2012-11-21 18:01:26'),
(21, 'Tucson', 3, 21, '1', '2012-11-21 18:01:26'),
(22, 'Yuma', 3, 22, '1', '2012-11-21 18:01:26'),
(23, 'Fayetteville', 4, 23, '1', '2012-11-21 18:01:26'),
(24, 'Fort Smith', 4, 24, '1', '2012-11-21 18:01:26'),
(25, 'Little Rock', 4, 25, '1', '2012-11-21 18:01:26'),
(26, 'Jonesboro', 4, 26, '1', '2012-11-21 18:01:26'),
(27, 'Texarkana', 4, 27, '1', '2012-11-21 18:01:26'),
(28, 'Bakersfield', 5, 28, '1', '2012-11-21 18:01:26'),
(29, 'Chico', 5, 29, '1', '2012-11-21 18:01:26'),
(30, 'Fresno', 5, 30, '1', '2012-11-21 18:01:26'),
(31, 'Gold Country', 5, 31, '1', '2012-11-21 18:01:26'),
(32, 'Humboldt County', 5, 32, '1', '2012-11-21 18:01:26'),
(33, 'Imperial County', 5, 33, '1', '2012-11-21 18:01:26'),
(34, 'Inland Empire', 5, 34, '1', '2012-11-21 18:01:26'),
(35, 'Los Angeles', 5, 35, '1', '2012-11-21 18:01:26'),
(36, 'Mendocino County', 5, 36, '1', '2012-11-21 18:01:26'),
(37, 'Merced', 5, 37, '1', '2012-11-21 18:01:26'),
(38, 'Modesto', 5, 38, '1', '2012-11-21 18:01:26'),
(39, 'Monterey Bay', 5, 39, '1', '2012-11-21 18:01:26'),
(40, 'Orange County', 5, 40, '1', '2012-11-21 18:01:26'),
(41, 'Palm Springs', 5, 41, '1', '2012-11-21 18:01:26'),
(42, 'Redding', 5, 42, '1', '2012-11-21 18:01:26'),
(43, 'Reno / Tahoe', 5, 43, '1', '2012-11-21 18:01:26'),
(44, 'Sacramento', 5, 44, '1', '2012-11-21 18:01:26'),
(45, 'San Diego', 5, 45, '1', '2012-11-21 18:01:26'),
(46, 'San Luis Obispo', 5, 46, '1', '2012-11-21 18:01:26'),
(47, 'Santa Barbara', 5, 47, '1', '2012-11-21 18:01:26'),
(48, 'SF Bay Area', 5, 48, '1', '2012-11-21 18:01:26'),
(49, 'Stockton', 5, 49, '1', '2012-11-21 18:01:26'),
(50, 'Ventura County', 5, 50, '1', '2012-11-21 18:01:26'),
(51, 'Visalia-Tulare', 5, 51, '1', '2012-11-21 18:01:26'),
(52, 'Yuba-Sutter', 5, 52, '1', '2012-11-21 18:01:26'),
(53, 'Boulder', 6, 53, '1', '2012-11-21 18:01:26'),
(54, 'Colorado Springs', 6, 54, '1', '2012-11-21 18:01:26'),
(55, 'Denver', 6, 55, '1', '2012-11-21 18:01:26'),
(56, 'Fort Collins / North CO', 6, 56, '1', '2012-11-21 18:01:26'),
(57, 'Pueblo', 6, 57, '1', '2012-11-21 18:01:26'),
(58, 'Rocky Mountains', 6, 58, '1', '2012-11-21 18:01:26'),
(59, 'Western Slope', 6, 59, '1', '2012-11-21 18:01:26'),
(60, 'Eastern CT', 7, 60, '1', '2012-11-21 18:01:26'),
(61, 'Hartford', 7, 61, '1', '2012-11-21 18:01:26'),
(62, 'Northwest CT', 7, 62, '1', '2012-11-21 18:01:26'),
(63, 'New Haven', 7, 63, '1', '2012-11-21 18:01:26'),
(64, 'Dover', 8, 64, '1', '2012-11-21 18:01:26'),
(65, 'Wilmington', 8, 65, '1', '2012-11-21 18:01:26'),
(66, 'Washington', 9, 66, '1', '2012-11-21 18:01:26'),
(67, 'Florida Keys', 10, 67, '1', '2012-11-21 18:01:26'),
(68, 'Ft Myers / SW Florida', 10, 68, '1', '2012-11-21 18:01:26'),
(69, 'Palm Beach', 10, 69, '1', '2012-11-21 18:01:26'),
(70, 'Broward', 10, 70, '1', '2012-11-21 18:01:26'),
(71, 'Daytona Beach', 10, 71, '1', '2012-11-21 18:01:26'),
(72, 'Gainesville', 10, 72, '1', '2012-11-21 18:01:26'),
(73, 'Jacksonville', 10, 73, '1', '2012-11-21 18:01:26'),
(74, 'Lakeland', 10, 74, '1', '2012-11-21 18:01:26'),
(75, 'Miami', 10, 75, '1', '2012-11-21 18:01:26'),
(76, 'Ocala', 10, 76, '1', '2012-11-21 18:01:26'),
(77, 'Orlando', 10, 77, '1', '2012-11-21 18:01:26'),
(78, 'Panama City', 10, 78, '1', '2012-11-21 18:01:26'),
(79, 'Pensacola / Panhandle', 10, 79, '1', '2012-11-21 18:01:26'),
(80, 'Sarasota / Bradenton', 10, 80, '1', '2012-11-21 18:01:26'),
(81, 'Space Coast', 10, 81, '1', '2012-11-21 18:01:26'),
(82, 'St Augustine', 10, 82, '1', '2012-11-21 18:01:26'),
(83, 'Tallahassee', 10, 83, '1', '2012-11-21 18:01:26'),
(84, 'Tampa Bay Area', 10, 84, '1', '2012-11-21 18:01:26'),
(85, 'Treasure Coast', 10, 85, '1', '2012-11-21 18:01:26'),
(86, 'Athens', 11, 86, '1', '2012-11-21 18:01:26'),
(87, 'Atlanta', 11, 87, '1', '2012-11-21 18:01:26'),
(88, 'Augusta', 11, 88, '1', '2012-11-21 18:01:26'),
(89, 'Brunswick', 11, 89, '1', '2012-11-21 18:01:26'),
(90, 'Columbus', 11, 90, '1', '2012-11-21 18:01:26'),
(91, 'Macon', 11, 91, '1', '2012-11-21 18:01:26'),
(92, 'Savannah', 11, 92, '1', '2012-11-21 18:01:26'),
(93, 'Valdosta', 11, 93, '1', '2012-11-21 18:01:26'),
(94, 'Agana', 12, 94, '1', '2012-11-21 18:01:26'),
(95, 'Hilo', 13, 95, '1', '2012-11-21 18:01:26'),
(96, 'Honolulu', 13, 96, '1', '2012-11-21 18:01:26'),
(97, 'Boise', 14, 97, '1', '2012-11-21 18:01:26'),
(98, 'Coeur d''Alene', 14, 98, '1', '2012-11-21 18:01:26'),
(99, 'East Idaho', 14, 99, '1', '2012-11-21 18:01:26'),
(100, 'Moscow / Pullman', 14, 100, '1', '2012-11-21 18:01:26'),
(101, 'Twin Falls', 14, 101, '1', '2012-11-21 18:01:26'),
(102, 'Bloomington-Normal', 15, 102, '1', '2012-11-21 18:01:26'),
(103, 'Carbondale', 15, 103, '1', '2012-11-21 18:01:26'),
(104, 'Champaign-Urbana', 15, 104, '1', '2012-11-21 18:01:26'),
(105, 'Chicago', 15, 105, '1', '2012-11-21 18:01:26'),
(106, 'Decatur', 15, 106, '1', '2012-11-21 18:01:26'),
(107, 'Peoria', 15, 107, '1', '2012-11-21 18:01:26'),
(108, 'Quad Cities, IA/IL', 15, 108, '1', '2012-11-21 18:01:26'),
(109, 'Rockford', 15, 109, '1', '2012-11-21 18:01:26'),
(110, 'Springfield', 15, 110, '1', '2012-11-21 18:01:26'),
(111, 'Bloomington', 16, 111, '1', '2012-11-21 18:01:26'),
(112, 'Evansville', 16, 112, '1', '2012-11-21 18:01:26'),
(113, 'Fort Wayne', 16, 113, '1', '2012-11-21 18:01:26'),
(114, 'Indianapolis', 16, 114, '1', '2012-11-21 18:01:26'),
(115, 'Lafayette / West Lafayette', 16, 115, '1', '2012-11-21 18:01:26'),
(116, 'Muncie / Anderson', 16, 116, '1', '2012-11-21 18:01:26'),
(117, 'Northwest IN', 16, 117, '1', '2012-11-21 18:01:26'),
(118, 'South Bend / Michiana', 16, 118, '1', '2012-11-21 18:01:26'),
(119, 'Terre Haute', 16, 119, '1', '2012-11-21 18:01:26'),
(120, 'Ames', 17, 120, '1', '2012-11-21 18:01:26'),
(121, 'Des Moines', 17, 121, '1', '2012-11-21 18:01:26'),
(122, 'Dubuque', 17, 122, '1', '2012-11-21 18:01:26'),
(123, 'Cedar Rapids', 17, 123, '1', '2012-11-21 18:01:26'),
(124, 'Iowa City', 17, 124, '1', '2012-11-21 18:01:26'),
(125, 'Omaha / Council Bluffs', 17, 125, '1', '2012-11-21 18:01:26'),
(126, 'Quad Cities, IA/IL', 17, 126, '1', '2012-11-21 18:01:26'),
(127, 'Sioux City', 17, 127, '1', '2012-11-21 18:01:26'),
(128, 'Waterloo / Cedar Falls', 17, 128, '1', '2012-11-21 18:01:26'),
(129, 'Lawrence', 18, 129, '1', '2012-11-21 18:01:26'),
(130, 'Manhattan', 18, 130, '1', '2012-11-21 18:01:26'),
(131, 'Topeka', 18, 131, '1', '2012-11-21 18:01:26'),
(132, 'Wichita', 18, 132, '1', '2012-11-21 18:01:26'),
(133, 'Bowling Green', 19, 133, '1', '2012-11-21 18:01:26'),
(134, 'Huntington-Ashland', 19, 134, '1', '2012-11-21 18:01:26'),
(135, 'Lexington', 19, 135, '1', '2012-11-21 18:01:26'),
(136, 'Louisville', 19, 136, '1', '2012-11-21 18:01:26'),
(137, 'Western KY', 19, 137, '1', '2012-11-21 18:01:26'),
(138, 'Baton Rouge', 20, 138, '1', '2012-11-21 18:01:26'),
(139, 'Lafayette', 20, 139, '1', '2012-11-21 18:01:26'),
(140, 'Lake Charles', 20, 140, '1', '2012-11-21 18:01:26'),
(141, 'Monroe', 20, 141, '1', '2012-11-21 18:01:26'),
(142, 'New Orleans', 20, 142, '1', '2012-11-21 18:01:26'),
(143, 'Shreveport', 20, 143, '1', '2012-11-21 18:01:26'),
(144, 'Bangor', 21, 144, '1', '2012-11-21 18:01:26'),
(145, 'Portland', 21, 145, '1', '2012-11-21 18:01:26'),
(146, 'Annapolis', 22, 146, '1', '2012-11-21 18:01:26'),
(147, 'Baltimore', 22, 147, '1', '2012-11-21 18:01:26'),
(148, 'Eastern Shore', 22, 148, '1', '2012-11-21 18:01:26'),
(149, 'MD suburbs of DC', 22, 149, '1', '2012-11-21 18:01:26'),
(150, 'Southern MD', 22, 150, '1', '2012-11-21 18:01:26'),
(151, 'Western MD', 22, 151, '1', '2012-11-21 18:01:26'),
(152, 'Boston', 23, 152, '1', '2012-11-21 18:01:26'),
(153, 'Cape Cod / Islands', 23, 153, '1', '2012-11-21 18:01:26'),
(154, 'South Coast', 23, 154, '1', '2012-11-21 18:01:26'),
(155, 'Western MA', 23, 155, '1', '2012-11-21 18:01:26'),
(156, 'Worcester / Central MA', 23, 156, '1', '2012-11-21 18:01:26'),
(157, 'Ann Arbor', 24, 157, '1', '2012-11-21 18:01:26'),
(158, 'Central MI', 24, 158, '1', '2012-11-21 18:01:26'),
(159, 'Detroit', 24, 159, '1', '2012-11-21 18:01:26'),
(160, 'Flint', 24, 160, '1', '2012-11-21 18:01:26'),
(161, 'Grand Rapids', 24, 161, '1', '2012-11-21 18:01:26'),
(162, 'Jackson', 24, 162, '1', '2012-11-21 18:01:26'),
(163, 'Kalamazoo', 24, 163, '1', '2012-11-21 18:01:26'),
(164, 'Lansing', 24, 164, '1', '2012-11-21 18:01:26'),
(165, 'Muskegon', 24, 165, '1', '2012-11-21 18:01:26'),
(166, 'Northern MI', 24, 166, '1', '2012-11-21 18:01:26'),
(167, 'Port Huron', 24, 167, '1', '2012-11-21 18:01:26'),
(168, 'Saginaw-Midland-Baycity', 24, 168, '1', '2012-11-21 18:01:26'),
(169, 'South Bend / Michiana', 24, 169, '1', '2012-11-21 18:01:26'),
(170, 'Upper Peninsula', 24, 170, '1', '2012-11-21 18:01:26'),
(171, 'Duluth / Superior', 25, 171, '1', '2012-11-21 18:01:26'),
(172, 'Fargo-Moorhead', 25, 172, '1', '2012-11-21 18:01:26'),
(173, 'Mankato', 25, 173, '1', '2012-11-21 18:01:26'),
(174, 'Minneapolis / St Paul', 25, 174, '1', '2012-11-21 18:01:26'),
(175, 'Rochester', 25, 175, '1', '2012-11-21 18:01:26'),
(176, 'St Cloud', 25, 176, '1', '2012-11-21 18:01:26'),
(177, 'Gulfport / Biloxi', 26, 177, '1', '2012-11-21 18:01:26'),
(178, 'Hattiesburg', 26, 178, '1', '2012-11-21 18:01:26'),
(179, 'Jackson', 26, 179, '1', '2012-11-21 18:01:26'),
(180, 'Northern MS', 26, 180, '1', '2012-11-21 18:01:26'),
(181, 'Columbia / Jeff City', 27, 181, '1', '2012-11-21 18:01:26'),
(182, 'Joplin', 27, 182, '1', '2012-11-21 18:01:26'),
(183, 'Kansas City', 27, 183, '1', '2012-11-21 18:01:26'),
(184, 'Southeast MO', 27, 184, '1', '2012-11-21 18:01:26'),
(185, 'Springfield', 27, 185, '1', '2012-11-21 18:01:26'),
(186, 'St Louis', 27, 186, '1', '2012-11-21 18:01:26'),
(187, 'Grand Island', 29, 187, '1', '2012-11-21 18:01:26'),
(188, 'Lincoln', 29, 188, '1', '2012-11-21 18:01:26'),
(189, 'Omaha / Council Bluffs', 29, 189, '1', '2012-11-21 18:01:26'),
(190, 'Sioux City, IA', 29, 190, '1', '2012-11-21 18:01:26'),
(191, 'Las Vegas', 30, 191, '1', '2012-11-21 18:01:26'),
(192, 'Reno / Tahoe', 30, 192, '1', '2012-11-21 18:01:26'),
(193, 'Concord', 31, 193, '1', '2012-11-21 18:01:26'),
(194, 'Northern NH', 31, 194, '1', '2012-11-21 18:01:26'),
(195, 'Central NJ', 32, 195, '1', '2012-11-21 18:01:26'),
(196, 'Jersey Shore', 32, 196, '1', '2012-11-21 18:01:26'),
(197, 'North Jersey', 32, 197, '1', '2012-11-21 18:01:26'),
(198, 'South Jersey', 32, 198, '1', '2012-11-21 18:01:26'),
(199, 'Albuquerque', 33, 199, '1', '2012-11-21 18:01:26'),
(200, 'Farmington', 33, 200, '1', '2012-11-21 18:01:26'),
(201, 'Las Cruces', 33, 201, '1', '2012-11-21 18:01:26'),
(202, 'Roswell / Carlsbad', 33, 202, '1', '2012-11-21 18:01:26'),
(203, 'Santa Fe / Taos', 33, 203, '1', '2012-11-21 18:01:26'),
(204, 'Albany', 34, 204, '1', '2012-11-21 18:01:26'),
(205, 'Binghamton', 34, 205, '1', '2012-11-21 18:01:26'),
(206, 'Buffalo', 34, 206, '1', '2012-11-21 18:01:26'),
(207, 'Catskills', 34, 207, '1', '2012-11-21 18:01:26'),
(208, 'Chautauqua', 34, 208, '1', '2012-11-21 18:01:26'),
(209, 'Elmira-Corning', 34, 209, '1', '2012-11-21 18:01:26'),
(210, 'Hudson Valley', 34, 210, '1', '2012-11-21 18:01:26'),
(211, 'Ithaca', 34, 211, '1', '2012-11-21 18:01:26'),
(212, 'Long Island', 34, 212, '1', '2012-11-21 18:01:26'),
(213, 'New York City', 34, 213, '1', '2012-11-21 18:01:26'),
(214, 'Plattsburgh-Adirondacks', 34, 214, '1', '2012-11-21 18:01:26'),
(215, 'Rochester', 34, 215, '1', '2012-11-21 18:01:26'),
(216, 'Syracuse', 34, 216, '1', '2012-11-21 18:01:26'),
(217, 'Utica', 34, 217, '1', '2012-11-21 18:01:26'),
(218, 'Watertown', 34, 218, '1', '2012-11-21 18:01:26'),
(219, 'Asheville', 35, 219, '1', '2012-11-21 18:01:26'),
(220, 'Boone', 35, 220, '1', '2012-11-21 18:01:26'),
(221, 'Charlotte', 35, 221, '1', '2012-11-21 18:01:26'),
(222, 'Eastern NC', 35, 222, '1', '2012-11-21 18:01:26'),
(223, 'Fayetteville', 35, 223, '1', '2012-11-21 18:01:26'),
(224, 'Greensboro', 35, 224, '1', '2012-11-21 18:01:26'),
(225, 'Hickory / Lenoir', 35, 225, '1', '2012-11-21 18:01:26'),
(226, 'Outer Banks', 35, 226, '1', '2012-11-21 18:01:26'),
(227, 'Raleigh / Durham / CH', 35, 227, '1', '2012-11-21 18:01:26'),
(228, 'Wilmington', 35, 228, '1', '2012-11-21 18:01:26'),
(229, 'Winston-Salem', 35, 229, '1', '2012-11-21 18:01:26'),
(230, 'Fargo / Moorhead', 36, 230, '1', '2012-11-21 18:01:26'),
(231, 'Northern ND', 36, 231, '1', '2012-11-21 18:01:26'),
(232, 'Akron / Canton', 37, 232, '1', '2012-11-21 18:01:26'),
(233, 'Athens', 37, 233, '1', '2012-11-21 18:01:26'),
(234, 'Cincinnati', 37, 234, '1', '2012-11-21 18:01:26'),
(235, 'Cleveland', 37, 235, '1', '2012-11-21 18:01:26'),
(236, 'Columbus', 37, 236, '1', '2012-11-21 18:01:26'),
(237, 'Dayton / Springfield', 37, 237, '1', '2012-11-21 18:01:26'),
(238, 'Huntington-Ashland', 37, 238, '1', '2012-11-21 18:01:26'),
(239, 'Lima / Findlay', 37, 239, '1', '2012-11-21 18:01:26'),
(240, 'Mansfield', 37, 240, '1', '2012-11-21 18:01:26'),
(241, 'Parkersburg-Marietta', 37, 241, '1', '2012-11-21 18:01:26'),
(242, 'Sandusky', 37, 242, '1', '2012-11-21 18:01:26'),
(243, 'Toledo', 37, 243, '1', '2012-11-21 18:01:26'),
(244, 'Youngstown', 37, 244, '1', '2012-11-21 18:01:26'),
(245, 'Fort smith, AR', 38, 245, '1', '2012-11-21 18:01:26'),
(246, 'Lawton', 38, 246, '1', '2012-11-21 18:01:26'),
(247, 'Oklahoma City', 38, 247, '1', '2012-11-21 18:01:26'),
(248, 'Stillwater', 38, 248, '1', '2012-11-21 18:01:26'),
(249, 'Tulsa', 38, 249, '1', '2012-11-21 18:01:26'),
(250, 'Bend', 39, 250, '1', '2012-11-21 18:01:26'),
(251, 'Corvallis/Albany', 39, 251, '1', '2012-11-21 18:01:26'),
(252, 'East Oregon', 39, 252, '1', '2012-11-21 18:01:26'),
(253, 'Eugene', 39, 253, '1', '2012-11-21 18:01:26'),
(254, 'Medford-Ashland-Klamath', 39, 254, '1', '2012-11-21 18:01:26'),
(255, 'Oregon Coast', 39, 255, '1', '2012-11-21 18:01:26'),
(256, 'Portland', 39, 256, '1', '2012-11-21 18:01:26'),
(257, 'Roseburg', 39, 257, '1', '2012-11-21 18:01:26'),
(258, 'Salem', 39, 258, '1', '2012-11-21 18:01:26'),
(259, 'Allentown', 40, 259, '1', '2012-11-21 18:01:26'),
(260, 'Altoona-Johnstown', 40, 260, '1', '2012-11-21 18:01:26'),
(261, 'Erie', 40, 261, '1', '2012-11-21 18:01:26'),
(262, 'Harrisburg', 40, 262, '1', '2012-11-21 18:01:26'),
(263, 'Lancaster', 40, 263, '1', '2012-11-21 18:01:26'),
(264, 'Lehigh Valley', 40, 264, '1', '2012-11-21 18:01:26'),
(265, 'Philadelphia', 40, 265, '1', '2012-11-21 18:01:26'),
(266, 'Pittsburgh', 40, 266, '1', '2012-11-21 18:01:26'),
(267, 'Poconos', 40, 267, '1', '2012-11-21 18:01:26'),
(268, 'Reading', 40, 268, '1', '2012-11-21 18:01:26'),
(269, 'Scranton / Wilkes-Barre', 40, 269, '1', '2012-11-21 18:01:26'),
(270, 'State College', 40, 270, '1', '2012-11-21 18:01:26'),
(271, 'Williamsport', 40, 271, '1', '2012-11-21 18:01:26'),
(272, 'York', 40, 272, '1', '2012-11-21 18:01:26'),
(273, 'Charleston / Lowcountry', 42, 273, '1', '2012-11-21 18:01:26'),
(274, 'Columbia', 42, 274, '1', '2012-11-21 18:01:26'),
(275, 'Florence', 42, 275, '1', '2012-11-21 18:01:26'),
(276, 'Greenville / Upstate', 42, 276, '1', '2012-11-21 18:01:26'),
(277, 'Hilton Head', 42, 277, '1', '2012-11-21 18:01:26'),
(278, 'Myrtle Beach', 42, 278, '1', '2012-11-21 18:01:26'),
(279, 'Rapid City', 43, 279, '1', '2012-11-21 18:01:26'),
(280, 'Sioux Falls', 43, 280, '1', '2012-11-21 18:01:26'),
(281, 'Aberdeen', 43, 281, '1', '2012-11-21 18:01:26'),
(282, 'Chattanooga', 44, 282, '1', '2012-11-21 18:01:26'),
(283, 'Clarksville', 44, 283, '1', '2012-11-21 18:01:26'),
(284, 'Jackson', 44, 284, '1', '2012-11-21 18:01:26'),
(285, 'Knoxville', 44, 285, '1', '2012-11-21 18:01:26'),
(286, 'Memphis', 44, 286, '1', '2012-11-21 18:01:26'),
(287, 'Nashville', 44, 287, '1', '2012-11-21 18:01:26'),
(288, 'Tri-Cities', 44, 288, '1', '2012-11-21 18:01:26'),
(289, 'Abilene', 45, 289, '1', '2012-11-21 18:01:26'),
(290, 'Amarillo', 45, 290, '1', '2012-11-21 18:01:26'),
(291, 'Austin', 45, 291, '1', '2012-11-21 18:01:26'),
(292, 'Beaumont / Port Arthur', 45, 292, '1', '2012-11-21 18:01:26'),
(293, 'Brownsville', 45, 293, '1', '2012-11-21 18:01:26'),
(294, 'College Station', 45, 294, '1', '2012-11-21 18:01:26'),
(295, 'Corpus Christi', 45, 295, '1', '2012-11-21 18:01:26'),
(296, 'Dallas / Fort Worth', 45, 296, '1', '2012-11-21 18:01:26'),
(297, 'El Paso', 45, 297, '1', '2012-11-21 18:01:26'),
(298, 'Galveston', 45, 298, '1', '2012-11-21 18:01:26'),
(299, 'Houston', 45, 299, '1', '2012-11-21 18:01:26'),
(300, 'Killeen / Temple / Ft Hood', 45, 300, '1', '2012-11-21 18:01:26'),
(301, 'Laredo', 45, 301, '1', '2012-11-21 18:01:26'),
(302, 'Lubbock', 45, 302, '1', '2012-11-21 18:01:26'),
(303, 'McAllen / Edinburg', 45, 303, '1', '2012-11-21 18:01:26'),
(304, 'Odessa / Midland', 45, 304, '1', '2012-11-21 18:01:26'),
(305, 'San Antonio', 45, 305, '1', '2012-11-21 18:01:26'),
(306, 'San Marcos', 45, 306, '1', '2012-11-21 18:01:26'),
(307, 'Texarkana', 45, 307, '1', '2012-11-21 18:01:26'),
(308, 'Tyler / East TX', 45, 308, '1', '2012-11-21 18:01:26'),
(309, 'Victoria', 45, 309, '1', '2012-11-21 18:01:26'),
(310, 'Waco', 45, 310, '1', '2012-11-21 18:01:26'),
(311, 'Wichita Falls', 45, 311, '1', '2012-11-21 18:01:26'),
(312, 'Logan', 46, 312, '1', '2012-11-21 18:01:26'),
(313, 'Ogden-Clearfield', 46, 313, '1', '2012-11-21 18:01:26'),
(314, 'Provo / Orem', 46, 314, '1', '2012-11-21 18:01:26'),
(315, 'Salt Lake City', 46, 315, '1', '2012-11-21 18:01:26'),
(316, 'St George', 46, 316, '1', '2012-11-21 18:01:26'),
(317, 'Blacksburg', 48, 317, '1', '2012-11-21 18:01:26'),
(318, 'Charlottesville', 48, 318, '1', '2012-11-21 18:01:26'),
(319, 'Danville', 48, 319, '1', '2012-11-21 18:01:26'),
(320, 'Eastern Shore', 48, 320, '1', '2012-11-21 18:01:26'),
(321, 'Fredericksburg', 48, 321, '1', '2012-11-21 18:01:26'),
(322, 'Hampton Roads', 48, 322, '1', '2012-11-21 18:01:26'),
(323, 'Harrisonburg', 48, 323, '1', '2012-11-21 18:01:26'),
(324, 'Lynchburg', 48, 324, '1', '2012-11-21 18:01:26'),
(325, 'Northern VA', 48, 325, '1', '2012-11-21 18:01:26'),
(326, 'Richmond', 48, 326, '1', '2012-11-21 18:01:26'),
(327, 'Roanoke', 48, 327, '1', '2012-11-21 18:01:26'),
(328, 'Bellingham', 49, 328, '1', '2012-11-21 18:01:26'),
(329, 'Kennewick-Pasco-Richland', 49, 329, '1', '2012-11-21 18:01:26'),
(330, 'Olympic Peninsula', 49, 330, '1', '2012-11-21 18:01:26'),
(331, 'Pullman / Moscow', 49, 331, '1', '2012-11-21 18:01:26'),
(332, 'Seattle-Tacoma', 49, 332, '1', '2012-11-21 18:01:26'),
(333, 'Skagit', 49, 333, '1', '2012-11-21 18:01:26'),
(334, 'Spokane / Coeur d''Alene', 49, 334, '1', '2012-11-21 18:01:26'),
(335, 'Wenatchee', 49, 335, '1', '2012-11-21 18:01:26'),
(336, 'Yakima', 49, 336, '1', '2012-11-21 18:01:26'),
(337, 'Charleston', 50, 337, '1', '2012-11-21 18:01:26'),
(338, 'Huntington-Ashland', 50, 338, '1', '2012-11-21 18:01:26'),
(339, 'Martinsburg', 50, 339, '1', '2012-11-21 18:01:26'),
(340, 'Morgantown', 50, 340, '1', '2012-11-21 18:01:26'),
(341, 'Parkersburg-Marietta', 50, 341, '1', '2012-11-21 18:01:26'),
(342, 'Wheeling', 50, 342, '1', '2012-11-21 18:01:26'),
(343, 'Appleton / Oshkosh', 51, 343, '1', '2012-11-21 18:01:26'),
(344, 'Duluth / Superior', 51, 344, '1', '2012-11-21 18:01:26'),
(345, 'Eau Claire', 51, 345, '1', '2012-11-21 18:01:26'),
(346, 'Green Bay', 51, 346, '1', '2012-11-21 18:01:26'),
(347, 'Janesville', 51, 347, '1', '2012-11-21 18:01:26'),
(348, 'Kenosha-Racine', 51, 348, '1', '2012-11-21 18:01:26'),
(349, 'La Crosse', 51, 349, '1', '2012-11-21 18:01:26'),
(350, 'Madison', 51, 350, '1', '2012-11-21 18:01:26'),
(351, 'Milwaukee', 51, 351, '1', '2012-11-21 18:01:26'),
(352, 'Sheboygan', 51, 352, '1', '2012-11-21 18:01:26'),
(353, 'WaUnited Statesu', 51, 353, '1', '2012-11-21 18:01:26'),
(354, 'Casper', 52, 354, '1', '2012-11-21 18:01:26'),
(355, 'Cody', 52, 355, '1', '2012-11-21 18:01:26'),
(356, 'Jackson', 52, 356, '1', '2012-11-21 18:01:26'),
(357, 'Sheridan', 52, 357, '1', '2012-11-21 18:01:26'),
(358, 'Queens', 34, 358, '1', '2012-11-21 19:01:29'),
(359, 'Pearl City', 13, 359, '1', '2015-11-14 04:05:18');

-- --------------------------------------------------------

--
-- Table structure for table `clf_countries`
--

CREATE TABLE IF NOT EXISTS `clf_countries` (
  `countryid` smallint(5) unsigned NOT NULL,
  `countryname` varchar(50) NOT NULL DEFAULT '',
  `pos` smallint(5) unsigned NOT NULL DEFAULT '0',
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clf_countries`
--

INSERT INTO `clf_countries` (`countryid`, `countryname`, `pos`, `enabled`, `timestamp`) VALUES
(1, 'Alabama', 1, '', '2015-11-14 03:54:10'),
(2, 'Alaska', 2, '', '2015-11-14 03:54:18'),
(3, 'Arizona', 3, '', '2015-11-14 03:54:23'),
(4, 'Arkansas', 4, '', '2015-11-14 03:54:28'),
(5, 'California', 5, '1', '2012-11-21 18:01:26'),
(6, 'Colorado', 6, '', '2015-11-14 03:54:37'),
(7, 'Connecticut', 7, '', '2015-11-14 03:54:42'),
(8, 'Delaware', 8, '', '2015-11-14 03:54:48'),
(9, 'DC', 9, '', '2015-11-14 03:54:53'),
(10, 'Florida', 10, '', '2015-11-14 03:55:01'),
(11, 'Georgia', 11, '', '2015-11-14 03:55:09'),
(12, 'Guam', 12, '', '2015-11-14 03:55:15'),
(13, 'Hawaii', 13, '1', '2012-11-21 18:01:26'),
(14, 'Idaho', 14, '', '2015-11-14 03:55:59'),
(15, 'Illinois', 15, '', '2015-11-14 03:56:05'),
(16, 'Indiana', 16, '', '2015-11-14 03:56:09'),
(17, 'Iowa', 17, '', '2015-11-14 03:56:23'),
(18, 'Kansas', 18, '', '2015-11-14 04:04:25'),
(19, 'Kentucky', 19, '', '2015-11-14 04:04:13'),
(20, 'Louisiana', 20, '', '2015-11-14 04:04:04'),
(21, 'Maine', 21, '', '2015-11-14 04:04:00'),
(22, 'Maryland', 22, '', '2015-11-14 04:03:55'),
(23, 'Massachusetts', 23, '', '2015-11-14 04:03:51'),
(24, 'Michigan', 24, '', '2015-11-14 04:03:47'),
(25, 'Minnesota', 25, '', '2015-11-14 04:03:43'),
(26, 'Mississippi', 26, '', '2015-11-14 04:03:39'),
(27, 'Missouri', 27, '', '2015-11-14 04:02:55'),
(28, 'Montana', 28, '', '2015-11-14 04:02:46'),
(29, 'Nebraska', 29, '', '2015-11-14 04:02:41'),
(30, 'Nevada', 30, '', '2015-11-14 04:02:35'),
(31, 'New Hampshire', 31, '', '2015-11-14 04:02:30'),
(32, 'New Jersey', 32, '', '2015-11-14 04:02:26'),
(33, 'New Mexico', 33, '', '2015-11-14 04:02:21'),
(34, 'New York', 34, '1', '2012-11-21 18:01:26'),
(35, 'North Carolina', 35, '', '2015-11-14 04:02:11'),
(36, 'North Dakota', 36, '', '2015-11-14 04:02:06'),
(37, 'Ohio', 37, '', '2015-11-14 04:01:28'),
(38, 'Oklahoma', 38, '', '2015-11-14 04:01:23'),
(39, 'Oregon', 39, '', '2015-11-14 04:01:18'),
(40, 'Pennsylvania', 40, '', '2015-11-14 04:01:14'),
(41, 'Rhode Island', 41, '', '2015-11-14 04:01:09'),
(42, 'South Carolina', 42, '', '2015-11-14 04:01:04'),
(43, 'South Dakota', 43, '', '2015-11-14 04:01:00'),
(44, 'Tennessee', 44, '', '2015-11-14 04:00:55'),
(45, 'Texas', 45, '1', '2012-11-21 18:01:26'),
(46, 'Utah', 46, '', '2015-11-14 04:00:08'),
(47, 'Vermont', 47, '', '2015-11-14 04:00:03'),
(48, 'Virginia', 48, '', '2015-11-14 03:59:56'),
(49, 'Washington', 49, '', '2015-11-14 03:59:50'),
(50, 'West Virginia', 50, '', '2015-11-14 03:59:45'),
(51, 'Wisconsin', 51, '', '2015-11-14 03:59:38'),
(52, 'Wyoming', 52, '', '2015-11-14 03:56:30');

-- --------------------------------------------------------

--
-- Table structure for table `clf_events`
--

CREATE TABLE IF NOT EXISTS `clf_events` (
  `adid` int(10) unsigned NOT NULL,
  `adtitle` varchar(100) NOT NULL DEFAULT '',
  `addesc` longtext NOT NULL,
  `area` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(50) NOT NULL DEFAULT '',
  `showemail` enum('0','1','2') NOT NULL DEFAULT '0',
  `password` varchar(50) NOT NULL DEFAULT '',
  `code` varchar(35) NOT NULL DEFAULT '',
  `cityid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `starton` date NOT NULL DEFAULT '0000-00-00',
  `endon` date NOT NULL DEFAULT '0000-00-00',
  `othercontactok` enum('0','1') NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verified` enum('0','1') NOT NULL DEFAULT '0',
  `abused` int(10) unsigned NOT NULL DEFAULT '0',
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expireson` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `paid` enum('0','1','2') NOT NULL DEFAULT '2',
  `user_id` mediumint(8) unsigned DEFAULT NULL,
  `newsletter` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_featured`
--

CREATE TABLE IF NOT EXISTS `clf_featured` (
  `featadid` int(10) unsigned NOT NULL,
  `adid` int(10) unsigned NOT NULL DEFAULT '0',
  `adtype` char(1) NOT NULL DEFAULT '',
  `featuredtill` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_feature_control`
--

CREATE TABLE IF NOT EXISTS `clf_feature_control` (
  `default_city` int(8) DEFAULT NULL,
  `max_abuse_reports` int(8) DEFAULT NULL,
  `sef` varchar(8) DEFAULT NULL,
  `site_calendar` varchar(8) DEFAULT NULL,
  `post_image` varchar(8) DEFAULT NULL,
  `numbers_directory` int(8) DEFAULT NULL,
  `numbers_location` int(8) DEFAULT NULL,
  `numbers_picture` int(8) DEFAULT NULL,
  `currency_symbol` varchar(4) DEFAULT NULL,
  `rich_text` varchar(8) DEFAULT NULL,
  `smtp_function` varchar(8) DEFAULT NULL,
  `smtp_host` varchar(32) DEFAULT NULL,
  `smtp_port` varchar(32) DEFAULT NULL,
  `smtp_authenticate` varchar(8) DEFAULT NULL,
  `smtp_username` varchar(64) DEFAULT NULL,
  `smtp_password` varchar(64) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clf_feature_control`
--

INSERT INTO `clf_feature_control` (`default_city`, `max_abuse_reports`, `sef`, `site_calendar`, `post_image`, `numbers_directory`, `numbers_location`, `numbers_picture`, `currency_symbol`, `rich_text`, `smtp_function`, `smtp_host`, `smtp_port`, `smtp_authenticate`, `smtp_username`, `smtp_password`) VALUES
(0, 3, '1', '1', '1', 4, 2, 4, '', '1', '0', 'localhost', '25', '1', 'username', 'password');

-- --------------------------------------------------------

--
-- Table structure for table `clf_fees`
--

CREATE TABLE IF NOT EXISTS `clf_fees` (
  `seclevel` int(11) NOT NULL,
  `secid` int(11) NOT NULL,
  `loclevel` int(11) NOT NULL,
  `locid` int(11) NOT NULL,
  `fee` decimal(7,2) NOT NULL,
  `pos` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_imgcomments`
--

CREATE TABLE IF NOT EXISTS `clf_imgcomments` (
  `commentid` int(10) unsigned NOT NULL,
  `imgid` int(10) unsigned NOT NULL DEFAULT '0',
  `postername` varchar(100) NOT NULL DEFAULT '',
  `comment` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_imgs`
--

CREATE TABLE IF NOT EXISTS `clf_imgs` (
  `imgid` int(10) unsigned NOT NULL,
  `imgtitle` varchar(255) NOT NULL DEFAULT '',
  `imgfilename` varchar(50) NOT NULL DEFAULT '',
  `imgdesc` text NOT NULL,
  `postername` varchar(100) NOT NULL DEFAULT '',
  `posteremail` varchar(100) NOT NULL DEFAULT '',
  `showemail` enum('0','1','2') NOT NULL DEFAULT '0',
  `password` varchar(100) NOT NULL DEFAULT '',
  `code` varchar(35) NOT NULL DEFAULT '',
  `cityid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `ip` varchar(15) NOT NULL DEFAULT '',
  `verified` enum('0','1') NOT NULL DEFAULT '0',
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `createdon` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `expireson` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `paid` enum('0','1','2') NOT NULL DEFAULT '2'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_ipblock`
--

CREATE TABLE IF NOT EXISTS `clf_ipblock` (
  `ipid` int(11) NOT NULL,
  `ip` varchar(15) NOT NULL DEFAULT '',
  `ipstart` bigint(20) NOT NULL DEFAULT '0',
  `ipend` bigint(20) NOT NULL DEFAULT '0',
  `blocks` int(11) NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_ipns`
--

CREATE TABLE IF NOT EXISTS `clf_ipns` (
  `ipnid` int(10) unsigned NOT NULL,
  `txnid` varchar(50) NOT NULL DEFAULT '',
  `result` varchar(50) NOT NULL DEFAULT '',
  `itemname` varchar(50) NOT NULL DEFAULT '',
  `itemnumber` varchar(25) NOT NULL DEFAULT '',
  `amount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(10) NOT NULL DEFAULT '',
  `payeremail` varchar(50) NOT NULL DEFAULT '',
  `receiveremail` varchar(50) NOT NULL DEFAULT '',
  `paymenttype` varchar(25) NOT NULL DEFAULT '',
  `verified` varchar(25) NOT NULL DEFAULT '',
  `status` varchar(25) NOT NULL DEFAULT '',
  `pendingreason` varchar(25) NOT NULL DEFAULT '',
  `fullipn` text NOT NULL,
  `receivedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_options_extended`
--

CREATE TABLE IF NOT EXISTS `clf_options_extended` (
  `eoptid` smallint(5) unsigned NOT NULL,
  `days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `price` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_options_featured`
--

CREATE TABLE IF NOT EXISTS `clf_options_featured` (
  `foptid` tinyint(3) unsigned NOT NULL,
  `days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `price` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_payments`
--

CREATE TABLE IF NOT EXISTS `clf_payments` (
  `paymentid` int(10) unsigned NOT NULL,
  `txnid` varchar(50) NOT NULL DEFAULT '',
  `adid` int(10) unsigned NOT NULL DEFAULT '0',
  `adtype` char(1) NOT NULL DEFAULT '',
  `itemname` varchar(50) NOT NULL DEFAULT '',
  `itemnumber` varchar(25) NOT NULL DEFAULT '',
  `amount` decimal(5,2) NOT NULL DEFAULT '0.00',
  `currency` varchar(10) NOT NULL DEFAULT '',
  `payeremail` varchar(50) NOT NULL DEFAULT '',
  `paymenttype` varchar(25) NOT NULL DEFAULT '',
  `verified` varchar(25) NOT NULL DEFAULT '',
  `status` varchar(25) NOT NULL DEFAULT '',
  `pendingreason` varchar(25) NOT NULL DEFAULT '',
  `fullipn` text NOT NULL,
  `receivedat` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_privacy_terms`
--

CREATE TABLE IF NOT EXISTS `clf_privacy_terms` (
  `p_bannerads` varchar(8) NOT NULL,
  `p_shareinfo` varchar(8) NOT NULL,
  `p_crossmarketing` varchar(8) NOT NULL,
  `p_tacking` varchar(8) NOT NULL,
  `p_sendcommunication` varchar(8) NOT NULL,
  `p_forums` varchar(8) NOT NULL,
  `p_under13` varchar(8) NOT NULL,
  `p_membershipmodule` varchar(8) NOT NULL,
  `p_newslettermodule` varchar(8) NOT NULL,
  `p_discloselegal` varchar(20) NOT NULL,
  `p_internationally` varchar(8) NOT NULL,
  `p_server_country` varchar(85) NOT NULL,
  `t_termsmodification` varchar(22) NOT NULL,
  `t_adultcontent` varchar(16) NOT NULL,
  `t_postingagents` varchar(6) NOT NULL,
  `t_paidads` varchar(16) NOT NULL,
  `t_registeredtrademark` varchar(16) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clf_privacy_terms`
--

INSERT INTO `clf_privacy_terms` (`p_bannerads`, `p_shareinfo`, `p_crossmarketing`, `p_tacking`, `p_sendcommunication`, `p_forums`, `p_under13`, `p_membershipmodule`, `p_newslettermodule`, `p_discloselegal`, `p_internationally`, `p_server_country`, `t_termsmodification`, `t_adultcontent`, `t_postingagents`, `t_paidads`, `t_registeredtrademark`) VALUES
('do not', 'do not', 'do not', 'do not', 'do', 'no', 'do', 'yes', 'yes', 'may', 'yes', 'United States', 'We do reserve', 'not allowed', 'yes', 'no', 'yes');

-- --------------------------------------------------------

--
-- Table structure for table `clf_promos_extended`
--

CREATE TABLE IF NOT EXISTS `clf_promos_extended` (
  `epromoid` int(10) unsigned NOT NULL,
  `adid` int(10) unsigned NOT NULL DEFAULT '0',
  `adtype` char(1) NOT NULL DEFAULT '',
  `days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `amountpaid` decimal(5,2) NOT NULL DEFAULT '0.00',
  `paymentid` int(10) unsigned NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_promos_featured`
--

CREATE TABLE IF NOT EXISTS `clf_promos_featured` (
  `fpromoid` int(10) unsigned NOT NULL,
  `adid` int(10) unsigned NOT NULL DEFAULT '0',
  `adtype` char(1) NOT NULL DEFAULT '',
  `days` smallint(5) unsigned NOT NULL DEFAULT '0',
  `amountpaid` decimal(5,2) NOT NULL DEFAULT '0.00',
  `paymentid` int(10) unsigned NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clf_site_control`
--

CREATE TABLE IF NOT EXISTS `clf_site_control` (
  `site_name` varchar(200) DEFAULT NULL,
  `site_email` varchar(200) DEFAULT NULL,
  `script_url` varchar(200) DEFAULT NULL,
  `language` varchar(16) DEFAULT NULL,
  `meta_keywords` text,
  `meta_description` text,
  `turn_site` varchar(16) DEFAULT NULL,
  `offline_mesg` varchar(200) DEFAULT NULL,
  `paypal_email` varchar(200) DEFAULT NULL,
  `paypal_currency_symbol` varchar(16) DEFAULT NULL,
  `user_name` varchar(200) DEFAULT NULL,
  `admin_password` varchar(200) DEFAULT NULL,
  `currency_word` varchar(16) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clf_site_control`
--

INSERT INTO `clf_site_control` (`site_name`, `site_email`, `script_url`, `language`, `meta_keywords`, `meta_description`, `turn_site`, `offline_mesg`, `paypal_email`, `paypal_currency_symbol`, `user_name`, `admin_password`, `currency_word`) VALUES
('Backpage Clone - Powered by SNetworksClassifieds.com', 'info@snetworks.biz', 'http://YOURWEBSITEDOMAIN.COM', 'en', 'classifieds,posts,ads,events,images,buy,sell,trade,real estate,apartments,personals,dating,community classifieds,classifieds,community classifieds,community,society,social networking, snetworks, shag networks', 'Check the LIVE DEMO of our Backpage Clone. Fully featured and professionally written in PHP. Powered by SNETWORKSCLASSIFIEDS.COM', 'no', 'The website is under maintenance.', 'email@sitedomain.com', '$', NULL, 'admin', 'USD');

-- --------------------------------------------------------

--
-- Table structure for table `clf_subcats`
--

CREATE TABLE IF NOT EXISTS `clf_subcats` (
  `subcatid` smallint(5) unsigned NOT NULL,
  `subcatname` varchar(50) NOT NULL DEFAULT '',
  `catid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `hasprice` enum('0','1') NOT NULL DEFAULT '0',
  `pricelabel` varchar(25) NOT NULL DEFAULT '',
  `expireafter` smallint(5) unsigned NOT NULL DEFAULT '100',
  `enabled` enum('0','1') NOT NULL DEFAULT '0',
  `pos` smallint(5) unsigned NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `upload_cost` decimal(6,2) NOT NULL,
  `upload_fields` tinyint(10) NOT NULL DEFAULT '0'
) ENGINE=MyISAM AUTO_INCREMENT=169 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clf_subcats`
--

INSERT INTO `clf_subcats` (`subcatid`, `subcatname`, `catid`, `hasprice`, `pricelabel`, `expireafter`, `enabled`, `pos`, `timestamp`, `upload_cost`, `upload_fields`) VALUES
(146, 'Want-Trade', 10, '0', '', 7, '1', 146, '2012-11-05 23:17:30', '0.00', 0),
(145, 'Tools/Materials', 10, '0', '', 7, '1', 145, '2012-11-05 23:16:55', '0.00', 0),
(144, 'Tickets', 10, '0', '', 7, '1', 144, '2012-11-05 23:16:26', '0.00', 0),
(143, 'Sports Equip.', 10, '0', '', 100, '1', 143, '2012-11-05 23:15:55', '0.00', 0),
(142, 'Pets/Pet Supplies', 10, '0', '', 7, '1', 142, '2012-11-05 23:14:26', '0.00', 0),
(140, 'Free', 10, '0', '', 7, '1', 139, '2012-11-05 23:11:25', '0.00', 0),
(139, 'Computer/Electronics', 10, '0', '', 7, '1', 138, '2012-11-05 23:11:23', '0.00', 0),
(138, 'Household Items', 10, '0', '', 7, '1', 137, '2012-11-05 23:11:20', '0.00', 0),
(137, 'Clothing/Jewelry', 10, '0', '', 7, '1', 136, '2012-11-05 23:11:17', '0.00', 0),
(136, 'Farm/Grden', 10, '0', '', 7, '1', 135, '2012-11-05 23:11:13', '0.00', 0),
(129, 'Adult Jobs', 8, '0', '', 7, '1', 129, '2012-11-05 21:06:32', '0.00', 0),
(128, 'Phone & Websites', 8, '0', '', 7, '1', 128, '2012-11-05 21:06:21', '0.00', 0),
(127, 'Male Escorts', 8, '0', '', 7, '1', 127, '2012-11-05 21:06:05', '0.00', 0),
(126, 'TS', 8, '0', '', 7, '1', 126, '2012-11-05 20:23:24', '0.00', 0),
(125, 'Dom & Fetish', 8, '0', '', 7, '1', 125, '2012-11-05 21:04:38', '0.00', 0),
(124, 'Strippers & Strip Clubs', 8, '0', '', 7, '1', 124, '2012-11-05 21:05:29', '0.00', 0),
(123, 'Body Rubs', 8, '0', '', 7, '1', 123, '2012-11-05 21:04:57', '0.00', 0),
(122, 'Female Escorts', 8, '0', '', 7, '1', 122, '2012-11-05 21:04:02', '0.00', 0),
(98, 'Furniture', 10, '0', '', 7, '1', 140, '2012-11-05 23:11:25', '0.00', 0),
(141, 'Miscellaneous', 10, '0', '', 7, '1', 141, '2012-11-05 23:13:42', '0.00', 0),
(95, 'Business', 10, '0', '', 7, '1', 98, '2012-11-05 23:11:09', '0.00', 0),
(93, 'Baotes/Motorcycles', 10, '0', '', 7, '1', 134, '2012-11-05 23:11:11', '0.00', 0),
(90, 'Write/Ed/Tr8', 6, '0', '', 7, '1', 90, '2012-11-06 17:28:16', '0.00', 0),
(89, 'Travel/Vac', 6, '0', '', 7, '1', 89, '2012-11-06 17:27:51', '0.00', 0),
(88, 'Theapeutic', 6, '0', '', 7, '1', 88, '2012-11-06 17:27:34', '0.00', 0),
(87, 'Small Biz Ads', 6, '0', '', 7, '1', 87, '2012-11-06 17:27:22', '0.00', 0),
(86, 'Real Estate', 6, '0', '', 7, '1', 86, '2012-11-06 17:27:02', '0.00', 0),
(85, 'Skill''d Trade', 6, '0', '', 7, '1', 85, '2012-11-06 17:26:51', '0.00', 0),
(84, 'Labor/Move', 6, '0', '', 7, '1', 84, '2012-11-06 17:26:32', '0.00', 0),
(83, 'Household', 6, '0', '', 7, '1', 83, '2012-11-06 17:26:15', '0.00', 0),
(82, 'Automative', 6, '0', '', 7, '1', 82, '2012-11-06 17:26:03', '0.00', 0),
(81, 'Lessons', 6, '0', '', 7, '1', 81, '2012-11-06 17:25:50', '0.00', 0),
(80, 'Legal', 6, '0', '', 7, '1', 80, '2012-11-06 17:25:38', '0.00', 0),
(79, 'Financial', 6, '0', '', 7, '1', 79, '2012-11-06 17:25:29', '0.00', 0),
(78, 'Event', 6, '0', '', 7, '1', 78, '2012-11-06 17:25:18', '0.00', 0),
(77, 'Erotic', 6, '0', '', 7, '1', 77, '2012-11-06 17:24:58', '0.00', 0),
(76, 'Creative', 6, '0', '', 7, '1', 76, '2012-11-06 17:24:45', '0.00', 0),
(75, 'Computer', 6, '0', '', 7, '1', 75, '2012-11-06 17:24:36', '0.00', 0),
(74, 'Beauty', 6, '0', '', 7, '1', 74, '2012-11-06 17:24:26', '0.00', 0),
(60, 'Trades/Labor', 5, '0', '', 7, '1', 60, '2012-11-06 17:13:24', '0.00', 0),
(59, 'Show biz/Audition', 5, '0', '', 7, '1', 59, '2012-11-06 17:12:51', '0.00', 0),
(58, 'Salon/Spa/Fitness', 5, '0', '', 7, '1', 58, '2012-11-06 17:15:12', '0.00', 0),
(57, 'Sales/Marketing', 5, '0', '', 7, '1', 57, '2012-11-06 17:11:08', '0.00', 0),
(56, 'Rest/Retail/Hotel', 5, '0', '', 7, '1', 56, '2012-11-06 17:10:18', '0.00', 0),
(55, 'Real Estate', 5, '0', '', 7, '1', 55, '2012-11-06 17:09:39', '0.00', 0),
(54, 'Part-time Jobs', 5, '0', '', 7, '1', 54, '2012-11-06 17:08:56', '0.00', 0),
(53, 'Miscellaneous', 5, '0', '', 7, '1', 53, '2012-11-06 17:08:18', '0.00', 0),
(52, 'Medical/Health', 5, '0', '', 7, '1', 52, '2012-11-06 17:07:50', '0.00', 0),
(51, 'Management/Professional', 5, '0', '', 7, '1', 51, '2012-11-06 17:07:16', '0.00', 0),
(50, 'Job Wanted/Resume', 5, '0', '', 7, '1', 50, '2012-11-06 17:06:31', '0.00', 0),
(49, 'Focus Group/Studies', 5, '0', '', 7, '1', 49, '2012-11-06 17:05:51', '0.00', 0),
(48, 'Education', 5, '0', '', 7, '1', 48, '2012-11-06 17:04:27', '0.00', 0),
(47, 'Driver/Delivery/Courier', 5, '0', '', 7, '1', 47, '2012-11-06 17:03:51', '0.00', 0),
(46, 'Domestic', 5, '0', '', 7, '1', 46, '2012-11-06 17:03:15', '0.00', 0),
(45, 'Customer Service ', 5, '0', '', 7, '1', 45, '2012-11-06 17:01:45', '0.00', 0),
(44, 'Computer/Technical', 5, '0', '', 7, '1', 44, '2012-11-06 17:01:13', '0.00', 0),
(43, 'Admin/Office', 5, '0', '', 7, '1', 43, '2012-11-06 17:02:29', '0.00', 0),
(42, 'Accounting/Finance', 5, '0', '', 7, '1', 42, '2012-11-06 17:02:45', '0.00', 0),
(41, 'Adult', 4, '0', '', 7, '1', 41, '2012-11-06 17:23:28', '0.00', 0),
(40, 'Talent', 4, '0', '', 7, '1', 40, '2012-11-06 17:23:19', '0.00', 0),
(39, 'Writing', 4, '0', '', 7, '1', 39, '2012-11-06 17:23:10', '0.00', 0),
(38, 'Labor', 4, '0', '', 7, '1', 38, '2012-11-06 17:22:59', '0.00', 0),
(37, 'Event', 4, '0', '', 7, '1', 37, '2012-11-06 17:22:49', '0.00', 0),
(36, 'Somestic', 4, '0', '', 7, '1', 36, '2012-11-06 17:22:34', '0.00', 0),
(35, 'Crew', 4, '0', '', 7, '1', 35, '2012-11-06 17:22:25', '0.00', 0),
(34, 'Creative', 4, '0', '', 7, '1', 34, '2012-11-06 17:22:15', '0.00', 0),
(33, 'Computer', 4, '0', '', 7, '1', 33, '2012-11-06 17:22:03', '0.00', 0),
(131, 'Bars/Clubs', 9, '0', '', 7, '1', 131, '2012-11-05 22:54:54', '0.00', 0),
(130, 'Events', 9, '0', '', 7, '1', 130, '2012-11-05 22:54:33', '0.00', 0),
(19, 'Men > Men', 2, '0', '', 100, '1', 19, '2015-11-03 16:46:04', '0.00', 0),
(18, 'Men > Women', 2, '0', '', 7, '1', 18, '2015-11-03 16:46:11', '0.00', 0),
(17, 'Women > Men', 2, '0', '', 7, '1', 17, '2015-11-03 16:45:27', '0.00', 0),
(16, 'Women > Women', 2, '0', '', 7, '1', 16, '2015-11-03 16:45:15', '0.00', 0),
(132, 'Restaurants', 9, '0', '', 7, '1', 132, '2012-11-05 22:55:21', '0.00', 0),
(14, 'Classes/Workshops', 1, '0', '', 7, '1', 4, '2012-11-05 22:57:41', '0.00', 0),
(13, 'Volunteers', 1, '0', '', 7, '1', 14, '2012-11-05 22:57:06', '0.00', 0),
(12, 'Rideshare', 1, '0', '', 7, '1', 13, '2012-11-05 22:57:08', '0.00', 0),
(133, 'Salons/Nails/Spas', 9, '0', '', 7, '1', 133, '2012-11-05 22:56:01', '0.00', 0),
(135, 'Appliances', 10, '0', '', 7, '1', 95, '2012-11-05 23:06:29', '0.00', 0),
(8, 'Lost+Found', 1, '0', '', 7, '1', 7, '2012-11-05 22:58:38', '0.00', 0),
(134, 'Antiq.-Collectibles', 10, '0', '', 7, '1', 93, '2012-11-05 23:06:24', '0.00', 0),
(5, 'Groups', 1, '0', '', 7, '1', 6, '2012-11-05 22:57:15', '0.00', 0),
(4, 'General', 1, '0', '', 7, '1', 5, '2012-11-05 22:57:16', '0.00', 0),
(3, 'Childcare', 1, '0', '', 7, '1', 3, '2012-11-05 21:37:52', '0.00', 0),
(147, 'Yard/Garage Sales', 10, '0', '', 7, '1', 147, '2012-11-05 23:18:12', '0.00', 0),
(148, 'Auto/Truck/RV', 11, '0', '', 7, '1', 148, '2012-11-05 23:20:35', '0.00', 0),
(149, 'Auto Parts', 11, '0', '', 7, '1', 149, '2012-11-05 23:21:35', '0.00', 0),
(150, 'Services', 11, '0', '', 7, '1', 150, '2012-11-05 23:21:59', '0.00', 0),
(151, 'Available/Wanted', 12, '0', '', 7, '1', 151, '2012-11-05 23:25:44', '0.00', 0),
(152, 'Equip/Instruments', 12, '0', '', 7, '1', 152, '2012-11-05 23:26:56', '0.00', 0),
(153, 'Instruction', 12, '0', '', 7, '1', 153, '2012-11-05 23:28:00', '0.00', 0),
(154, 'Services', 12, '0', '', 7, '1', 154, '2012-11-05 23:30:45', '0.00', 0),
(155, 'Plug the Band', 12, '0', '', 7, '1', 155, '2012-11-05 23:31:49', '0.00', 0),
(156, 'Roommates', 13, '0', '', 7, '1', 156, '2012-11-05 23:39:27', '0.00', 0),
(157, 'Apt/Condo/House', 13, '0', '', 7, '1', 157, '2012-11-05 23:40:01', '0.00', 0),
(158, 'Sublets', 13, '0', '', 7, '1', 158, '2012-11-05 23:40:27', '0.00', 0),
(159, 'Commercial', 13, '0', '', 7, '1', 159, '2012-11-05 23:40:50', '0.00', 0),
(160, 'Vacation', 13, '0', '', 7, '1', 160, '2012-11-05 23:41:14', '0.00', 0),
(161, 'Miscellaneous', 13, '0', '', 7, '1', 161, '2012-11-05 23:41:40', '0.00', 0),
(162, 'rentals wanted', 13, '0', '', 7, '1', 162, '2012-11-05 23:42:01', '0.00', 0),
(163, 'Co-ops/Condos', 14, '0', '', 7, '1', 163, '2015-11-11 21:34:34', '1.00', 1),
(164, 'House/Condo', 14, '0', '', 7, '1', 164, '2015-11-11 21:34:48', '1.00', 1),
(165, 'Land for Sale', 14, '0', '', 7, '1', 165, '2012-11-05 23:48:23', '0.00', 0),
(166, 'Commercial', 14, '0', '', 7, '1', 166, '2012-11-05 23:48:42', '0.00', 0),
(167, 'Miscellaneous', 14, '0', '', 7, '1', 167, '2012-11-05 23:48:54', '0.00', 0),
(168, 'Wanted', 14, '0', '', 7, '1', 168, '2012-11-05 23:49:21', '0.00', 0);

-- --------------------------------------------------------

--
-- Table structure for table `clf_subcatxfields`
--

CREATE TABLE IF NOT EXISTS `clf_subcatxfields` (
  `subcatid` smallint(5) unsigned NOT NULL DEFAULT '0',
  `fieldnum` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `type` enum('N','S','D','U','E') NOT NULL DEFAULT 'S',
  `vals` varchar(255) NOT NULL DEFAULT '',
  `required` enum('0','1') NOT NULL DEFAULT '0',
  `showinlist` enum('0','1') NOT NULL DEFAULT '1',
  `searchable` enum('0','1') NOT NULL DEFAULT '0',
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clf_subcatxfields`
--

INSERT INTO `clf_subcatxfields` (`subcatid`, `fieldnum`, `name`, `type`, `vals`, `required`, `showinlist`, `searchable`, `timestamp`) VALUES
(126, 7, 'Services Provided For', 'D', 'Men;Women;Men/Women;Couples', '1', '1', '1', '2012-11-21 23:47:50'),
(126, 6, 'Phone Number', 'S', '', '1', '1', '1', '2012-11-21 23:47:50'),
(126, 5, 'Services', 'S', '', '1', '1', '1', '2012-11-21 23:47:50'),
(123, 5, 'Services', 'S', '', '1', '1', '1', '2012-11-21 23:46:57'),
(123, 6, 'Phone Number', 'S', '', '1', '1', '1', '2012-11-21 23:46:57'),
(122, 4, 'Sexual Orientation', 'D', 'Streight;Bi', '1', '1', '1', '2015-11-18 07:11:26'),
(122, 3, 'Age', 'N', '', '1', '1', '0', '2012-11-21 23:46:41'),
(123, 7, 'Services Provided For', 'D', 'Men;Women;Men/Women;Couples', '1', '1', '1', '2012-11-21 23:46:57'),
(123, 8, 'Website', 'S', '', '0', '1', '0', '2012-11-21 23:46:57'),
(125, 4, 'Sexual Oriantation', 'D', 'Dom;Sub;Switch;No Sex', '1', '1', '1', '2012-11-21 23:47:33'),
(125, 2, 'Sex', 'D', 'Male;Female;TS', '1', '1', '1', '2012-11-21 23:47:33'),
(125, 3, 'Age', 'N', '', '1', '1', '0', '2012-11-21 23:47:33'),
(125, 1, 'Name', 'S', '', '1', '1', '1', '2012-11-21 23:47:33'),
(123, 3, 'Age', 'N', '', '1', '1', '0', '2012-11-21 23:46:57'),
(123, 4, 'Sexual Orientation', 'D', 'Top;Bottom;Switch;Streight;Bi;No Sex', '1', '1', '1', '2015-11-18 07:13:52'),
(126, 4, 'Sexual Oriantation', 'D', 'Top;Bottom;Switch', '1', '1', '1', '2012-11-21 23:47:50'),
(122, 2, 'Sex', 'D', 'Male;Female;TS', '1', '1', '1', '2012-11-21 23:46:41'),
(122, 1, 'Name', 'S', '', '1', '1', '1', '2012-11-21 23:46:41'),
(127, 3, 'Age', 'N', '', '1', '1', '0', '2012-11-21 23:48:04'),
(126, 3, 'Age', 'N', '', '1', '1', '0', '2012-11-21 23:47:50'),
(126, 2, 'Sex', 'D', 'Male;Female;TS', '1', '1', '1', '2012-11-21 23:47:50'),
(126, 1, 'Name', 'S', '', '1', '1', '1', '2012-11-21 23:47:50'),
(122, 5, 'Services', 'S', '', '1', '1', '1', '2012-11-21 23:46:41'),
(122, 6, 'Phone Number', 'S', '', '1', '1', '1', '2012-11-21 23:46:41'),
(122, 7, 'Services Provided For', 'D', 'Men;Women;Men/Women;Couples', '1', '1', '1', '2012-11-21 23:46:41'),
(127, 4, 'Sexual Oriantation', 'D', 'Top;Bottom;Switch', '1', '1', '1', '2012-11-21 23:48:04'),
(127, 5, 'Services', 'S', '', '1', '1', '1', '2012-11-21 23:48:04'),
(127, 6, 'Phone Number', 'S', '', '1', '1', '1', '2012-11-21 23:48:04'),
(127, 7, 'Services Provided For', 'D', 'Men;Women;Men/Women;Couples', '1', '1', '1', '2012-11-21 23:48:04'),
(127, 8, 'Website', 'S', '', '0', '1', '0', '2012-11-21 23:48:04'),
(123, 2, 'Sex', 'D', 'Male;Female;TS', '1', '1', '1', '2012-11-21 23:46:57'),
(123, 1, 'Name', 'S', '', '1', '1', '1', '2012-11-21 23:46:57'),
(124, 4, 'Sexual Oriantation', 'D', 'Top;Bottom;Switch;Streight;Bi;No Sex', '1', '1', '1', '2012-11-21 23:47:18'),
(124, 5, 'Services', 'S', '', '1', '1', '1', '2012-11-21 23:47:18'),
(124, 6, 'Phone Number', 'S', '', '1', '1', '1', '2012-11-21 23:47:18'),
(124, 7, 'Services Provided For', 'D', 'Men;Women;Men/Women;Couples', '1', '1', '1', '2012-11-21 23:47:18'),
(124, 8, 'Website', 'S', '', '0', '1', '0', '2012-11-21 23:47:18'),
(124, 3, 'Age', 'N', '', '0', '1', '0', '2012-11-21 23:47:18'),
(124, 2, 'Sex', 'D', 'Male;Female;TS', '1', '1', '1', '2012-11-21 23:47:18'),
(124, 1, 'Name', 'S', '', '1', '1', '1', '2012-11-21 23:47:18'),
(125, 5, 'Services', 'S', '', '1', '1', '1', '2012-11-21 23:47:33'),
(125, 6, 'Phone Number', 'S', '', '1', '1', '1', '2012-11-21 23:47:33'),
(125, 7, 'Services Provided For', 'D', 'Men;Women;Men/Women;Couples', '1', '1', '1', '2012-11-21 23:47:33'),
(125, 8, 'Website', 'S', '', '0', '1', '0', '2012-11-21 23:47:33'),
(125, 9, 'Location', 'S', '', '1', '1', '1', '2012-11-21 23:47:33'),
(127, 2, 'Sex', 'D', 'Male;Female;TS', '1', '1', '1', '2012-11-21 23:48:04'),
(127, 1, 'Name', 'S', '', '1', '1', '1', '2012-11-21 23:48:04'),
(128, 3, 'Age', 'N', '', '0', '1', '0', '2012-11-21 23:48:24'),
(128, 4, 'Sexual Oriantation', 'S', '', '0', '0', '0', '2012-11-21 23:48:24'),
(128, 5, 'Services', 'S', '', '1', '1', '1', '2012-11-21 23:48:24'),
(128, 6, 'Phone Number', 'S', '', '1', '1', '1', '2012-11-21 23:48:24'),
(128, 7, 'Services Provided For', 'D', 'Men;Women;Men/Women;Couples', '1', '1', '1', '2012-11-21 23:48:24'),
(128, 8, 'Website', 'S', '', '0', '1', '0', '2012-11-21 23:48:24'),
(128, 2, 'Sex', 'D', 'Male;Female;TS', '1', '1', '1', '2012-11-21 23:48:24'),
(128, 1, 'Name', 'S', '', '1', '1', '1', '2012-11-21 23:48:24'),
(129, 6, 'Phone Number', 'S', '', '1', '1', '1', '2012-11-21 23:48:36'),
(122, 8, 'Website', 'S', '', '0', '1', '0', '2012-11-21 23:46:41'),
(122, 9, 'Location', 'S', '', '1', '1', '1', '2012-11-21 23:46:41'),
(123, 9, 'Location', 'S', '', '1', '1', '1', '2012-11-21 23:46:57'),
(124, 9, 'Location', 'S', '', '1', '1', '1', '2012-11-21 23:47:18'),
(126, 8, 'Website', 'S', '', '0', '1', '0', '2012-11-21 23:47:50'),
(126, 9, 'Location', 'S', '', '1', '1', '1', '2012-11-21 23:47:50'),
(127, 9, 'Location', 'S', '', '1', '1', '1', '2012-11-21 23:48:04'),
(128, 9, 'Location', 'S', '', '0', '1', '0', '2012-11-21 23:48:24'),
(129, 8, 'Website', 'S', '', '0', '1', '0', '2012-11-21 23:48:36'),
(129, 9, 'Location', 'S', '', '0', '1', '0', '2012-11-21 23:48:36'),
(123, 10, 'Ethnicity', 'D', 'African American;Chinese;European;;Filipino;German;Italian;Japanese;Korean;Local Girl;Russian;Spanish;Thai:Vietnamese:', '1', '1', '1', '2015-11-18 19:23:30');

-- --------------------------------------------------------

--
-- Table structure for table `clf_user_data`
--

CREATE TABLE IF NOT EXISTS `clf_user_data` (
  `full_name` varchar(200) DEFAULT NULL,
  `licensed_email` varchar(80) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clf_user_data`
--

INSERT INTO `clf_user_data` (`full_name`, `licensed_email`) VALUES
('Official Backpage Suite', 'info@snetworks.biz');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `clf_acc_users`
--
ALTER TABLE `clf_acc_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `clf_adpics`
--
ALTER TABLE `clf_adpics`
  ADD PRIMARY KEY (`picid`), ADD KEY `adid` (`adid`,`isevent`);

--
-- Indexes for table `clf_ads`
--
ALTER TABLE `clf_ads`
  ADD PRIMARY KEY (`adid`), ADD KEY `subcatid` (`subcatid`), ADD KEY `cityid` (`cityid`), ADD KEY `verified` (`verified`), ADD KEY `enabled` (`enabled`), ADD KEY `paid` (`paid`);

--
-- Indexes for table `clf_adxfields`
--
ALTER TABLE `clf_adxfields`
  ADD KEY `adid` (`adid`);

--
-- Indexes for table `clf_areas`
--
ALTER TABLE `clf_areas`
  ADD PRIMARY KEY (`areaid`), ADD KEY `pos` (`pos`), ADD KEY `cityid` (`cityid`), ADD KEY `enabled` (`enabled`);

--
-- Indexes for table `clf_cats`
--
ALTER TABLE `clf_cats`
  ADD PRIMARY KEY (`catid`), ADD KEY `enabled` (`enabled`);

--
-- Indexes for table `clf_cities`
--
ALTER TABLE `clf_cities`
  ADD PRIMARY KEY (`cityid`), ADD KEY `countryid` (`countryid`), ADD KEY `pos` (`pos`), ADD KEY `enabled` (`enabled`);

--
-- Indexes for table `clf_countries`
--
ALTER TABLE `clf_countries`
  ADD PRIMARY KEY (`countryid`), ADD KEY `pos` (`pos`), ADD KEY `enabled` (`enabled`);

--
-- Indexes for table `clf_events`
--
ALTER TABLE `clf_events`
  ADD PRIMARY KEY (`adid`), ADD KEY `cityid` (`cityid`), ADD KEY `verified` (`verified`), ADD KEY `enabled` (`enabled`), ADD KEY `paid` (`paid`);

--
-- Indexes for table `clf_featured`
--
ALTER TABLE `clf_featured`
  ADD PRIMARY KEY (`featadid`), ADD UNIQUE KEY `adid` (`adid`,`adtype`);

--
-- Indexes for table `clf_fees`
--
ALTER TABLE `clf_fees`
  ADD PRIMARY KEY (`seclevel`,`secid`,`loclevel`,`locid`), ADD KEY `pos` (`pos`);

--
-- Indexes for table `clf_imgcomments`
--
ALTER TABLE `clf_imgcomments`
  ADD PRIMARY KEY (`commentid`), ADD KEY `imgid` (`imgid`);

--
-- Indexes for table `clf_imgs`
--
ALTER TABLE `clf_imgs`
  ADD PRIMARY KEY (`imgid`), ADD KEY `verified` (`verified`), ADD KEY `enabled` (`enabled`), ADD KEY `cityid` (`cityid`), ADD KEY `paid` (`paid`);

--
-- Indexes for table `clf_ipblock`
--
ALTER TABLE `clf_ipblock`
  ADD PRIMARY KEY (`ipid`), ADD KEY `ipstart` (`ipstart`,`ipend`);

--
-- Indexes for table `clf_ipns`
--
ALTER TABLE `clf_ipns`
  ADD PRIMARY KEY (`ipnid`);

--
-- Indexes for table `clf_options_extended`
--
ALTER TABLE `clf_options_extended`
  ADD PRIMARY KEY (`eoptid`);

--
-- Indexes for table `clf_options_featured`
--
ALTER TABLE `clf_options_featured`
  ADD PRIMARY KEY (`foptid`);

--
-- Indexes for table `clf_payments`
--
ALTER TABLE `clf_payments`
  ADD PRIMARY KEY (`paymentid`), ADD UNIQUE KEY `txnid` (`txnid`), ADD KEY `adid` (`adid`), ADD KEY `adtype` (`adtype`);

--
-- Indexes for table `clf_promos_extended`
--
ALTER TABLE `clf_promos_extended`
  ADD PRIMARY KEY (`epromoid`), ADD KEY `adid` (`adid`), ADD KEY `adtype` (`adtype`), ADD KEY `paymentid` (`paymentid`);

--
-- Indexes for table `clf_promos_featured`
--
ALTER TABLE `clf_promos_featured`
  ADD PRIMARY KEY (`fpromoid`), ADD KEY `adid` (`adid`), ADD KEY `adtype` (`adtype`), ADD KEY `paymentid` (`paymentid`);

--
-- Indexes for table `clf_site_control`
--
ALTER TABLE `clf_site_control`
  ADD UNIQUE KEY `script_url` (`script_url`);

--
-- Indexes for table `clf_subcats`
--
ALTER TABLE `clf_subcats`
  ADD PRIMARY KEY (`subcatid`), ADD KEY `catid` (`catid`);

--
-- Indexes for table `clf_subcatxfields`
--
ALTER TABLE `clf_subcatxfields`
  ADD PRIMARY KEY (`subcatid`,`fieldnum`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `clf_acc_users`
--
ALTER TABLE `clf_acc_users`
  MODIFY `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `clf_adpics`
--
ALTER TABLE `clf_adpics`
  MODIFY `picid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `clf_ads`
--
ALTER TABLE `clf_ads`
  MODIFY `adid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `clf_areas`
--
ALTER TABLE `clf_areas`
  MODIFY `areaid` smallint(5) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clf_cats`
--
ALTER TABLE `clf_cats`
  MODIFY `catid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `clf_cities`
--
ALTER TABLE `clf_cities`
  MODIFY `cityid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=360;
--
-- AUTO_INCREMENT for table `clf_countries`
--
ALTER TABLE `clf_countries`
  MODIFY `countryid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=53;
--
-- AUTO_INCREMENT for table `clf_events`
--
ALTER TABLE `clf_events`
  MODIFY `adid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clf_featured`
--
ALTER TABLE `clf_featured`
  MODIFY `featadid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clf_imgcomments`
--
ALTER TABLE `clf_imgcomments`
  MODIFY `commentid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clf_imgs`
--
ALTER TABLE `clf_imgs`
  MODIFY `imgid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clf_ipblock`
--
ALTER TABLE `clf_ipblock`
  MODIFY `ipid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clf_ipns`
--
ALTER TABLE `clf_ipns`
  MODIFY `ipnid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clf_options_extended`
--
ALTER TABLE `clf_options_extended`
  MODIFY `eoptid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clf_options_featured`
--
ALTER TABLE `clf_options_featured`
  MODIFY `foptid` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clf_payments`
--
ALTER TABLE `clf_payments`
  MODIFY `paymentid` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `clf_promos_extended`
--
ALTER TABLE `clf_promos_extended`
  MODIFY `epromoid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clf_promos_featured`
--
ALTER TABLE `clf_promos_featured`
  MODIFY `fpromoid` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clf_subcats`
--
ALTER TABLE `clf_subcats`
  MODIFY `subcatid` smallint(5) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=169;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
