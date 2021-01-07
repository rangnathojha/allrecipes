-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2021 at 07:33 AM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `allrecepies_ndb`
--

-- --------------------------------------------------------

--
-- Table structure for table `ss_adminuser`
--

CREATE TABLE `ss_adminuser` (
  `user_id` int(11) NOT NULL,
  `user_group_id` int(11) NOT NULL,
  `user_group_name` varchar(255) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(40) NOT NULL,
  `salt` varchar(9) NOT NULL,
  `firstname` varchar(32) NOT NULL,
  `lastname` varchar(32) NOT NULL,
  `email` varchar(96) NOT NULL,
  `code` varchar(40) NOT NULL,
  `ip` varchar(40) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `last_login` datetime NOT NULL,
  `date_added` datetime NOT NULL DEFAULT '0000-00-00 00:00:00'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Storing administrative user with their details';

--
-- Dumping data for table `ss_adminuser`
--

INSERT INTO `ss_adminuser` (`user_id`, `user_group_id`, `user_group_name`, `username`, `password`, `salt`, `firstname`, `lastname`, `email`, `code`, `ip`, `status`, `last_login`, `date_added`) VALUES
(1, 1, 'Super Admin', 'gtadmin', 'ca591030845950aee9ecf347caf950b3', 'ee26356f6', 'All Recipes', 'Admin', 'wdraghwendra@gmail.com', '', '127.0.0.1', 1, '2021-01-05 15:37:52', '2014-09-08 12:33:07'),
(8, 4, 'Administrator', 'wdankur@gmail.com', '2bb5571df487bafcef785220ed0d5062', '', 'Ankur', 'Singh', 'wdankur@gmail.com', '', '', 1, '2018-09-25 14:11:14', '2018-09-25 13:15:09'),
(9, 2, 'Editor', 'wdrangnath@gmail.com', '0257b391796b06520fef94b002941235', '', 'Rangnath', 'Ojha', 'wdrangnath@gmail.com', '', '', 1, '2018-09-25 14:11:54', '2018-09-25 13:31:20'),
(10, 3, 'Manager', 'wdsanjeet@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '', 'Sanjeet', 'Kumar', 'wdsanjeet@gmail.com', '', '', 1, '2018-09-25 14:13:22', '2018-09-25 13:32:24'),
(11, 1, 'Super Admin', 'adis@gmail.com', 'e914970a179bc856f08608d6e842e6d5', '', 'Rangnath', 'Ojha', 'adis@gmail.com', '', '', 1, '2018-09-25 13:55:34', '2018-09-25 13:34:48'),
(12, 4, 'Administrator', 'ragh@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '', 'Ragh', 'ojha', 'ragh@gmail.com', '', '', 1, '0000-00-00 00:00:00', '2019-05-16 18:58:30');

-- --------------------------------------------------------

--
-- Table structure for table `ss_adminuser_groups`
--

CREATE TABLE `ss_adminuser_groups` (
  `user_group_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `permission` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ss_adminuser_groups`
--

INSERT INTO `ss_adminuser_groups` (`user_group_id`, `name`, `permission`) VALUES
(1, 'Super Admin', 'services,package,order,reports,members,admin_users'),
(2, 'Editor', 'services,package'),
(3, 'Manager', 'order,reports,members'),
(4, 'Administrator', 'services,package,order,reports,members');

-- --------------------------------------------------------

--
-- Table structure for table `ss_collection`
--

CREATE TABLE `ss_collection` (
  `collection_id` int(11) NOT NULL,
  `serviceproviderid` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `dateadded` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_consumers`
--

CREATE TABLE `ss_consumers` (
  `consumer_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_consumers_hour_tracking`
--

CREATE TABLE `ss_consumers_hour_tracking` (
  `consumer_hour_tracking_id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `dateofstudy` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `order_id` int(11) NOT NULL,
  `hours` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_consumer_order`
--

CREATE TABLE `ss_consumer_order` (
  `order_id` int(11) NOT NULL,
  `order_reference_number` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `totalamount` float NOT NULL,
  `services_id` int(11) NOT NULL,
  `packages_id` int(11) NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `startdate` date NOT NULL,
  `enddate` date NOT NULL,
  `dateoforder` datetime NOT NULL,
  `totalhours` int(11) NOT NULL,
  `totalusedhour` int(11) NOT NULL,
  `service_name` varchar(255) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `discountcost` float NOT NULL,
  `service_provider_name` varchar(255) NOT NULL,
  `order_status` tinyint(1) NOT NULL,
  `discounted_hour` int(4) NOT NULL,
  `duration` int(6) NOT NULL,
  `package_price` float NOT NULL,
  `hourly_cost` float NOT NULL,
  `discounted_hourly_cost` float NOT NULL,
  `services_package_id` int(11) NOT NULL,
  `buy_from` varchar(40) NOT NULL,
  `order_acceped` int(1) NOT NULL,
  `txid` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_institutes`
--

CREATE TABLE `ss_institutes` (
  `institute_id` int(11) NOT NULL,
  `institute_name` int(11) NOT NULL,
  `institute_address` int(11) NOT NULL,
  `institute_city` int(11) NOT NULL,
  `institute_distict` int(11) NOT NULL,
  `institute_state` int(11) NOT NULL,
  `instittue_pincode` int(11) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_packages`
--

CREATE TABLE `ss_packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `sort_order` int(2) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_services`
--

CREATE TABLE `ss_services` (
  `service_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `parent_id` int(11) NOT NULL,
  `level` int(2) NOT NULL,
  `sort_order` int(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL,
  `date_modified` datetime NOT NULL,
  `service_image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ss_services`
--

INSERT INTO `ss_services` (`service_id`, `name`, `description`, `parent_id`, `level`, `sort_order`, `status`, `date_added`, `date_modified`, `service_image`) VALUES
(1, 'Air Fryer Recipes', 'Wondering what to cook in an air fryer? Find easy recipes for air fried chicken, shrimp, fries and so much more!', 0, 0, 0, 1, '2021-01-05 10:28:46', '0000-00-00 00:00:00', '1_342082_1_112937_pan_cake.jpg'),
(2, 'Appetizers and Snacks', 'Appetizers and Snacks', 0, 0, 0, 1, '2021-01-05 10:31:38', '0000-00-00 00:00:00', '1_692359_cream-cheese-sugar-cookies.jpg'),
(3, 'Healthy Pizza Recipes for your Pizza Oven', 'We love our Instant Pot®. Meals that often take hours to slowly simmer are ready in mere minutes.', 0, 0, 0, 1, '2021-01-06 11:31:50', '0000-00-00 00:00:00', '1_671042_1_112937_pan_cake.jpg'),
(4, 'Healthy Instant Pot Recipes', 'We love our Instant Pot. Meals that often take hours to slowly simmer are ready in mere minutes.', 0, 0, 0, 1, '2021-01-06 11:32:48', '0000-00-00 00:00:00', '1_336410_1_671042_1_112937_pan_cake.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `ss_services_package`
--

CREATE TABLE `ss_services_package` (
  `services_package_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_1` varchar(255) NOT NULL,
  `image_2` varchar(255) NOT NULL,
  `image_3` varchar(255) NOT NULL,
  `image_4` varchar(255) NOT NULL,
  `rating` float NOT NULL,
  `author` varchar(255) NOT NULL,
  `prep` varchar(255) NOT NULL,
  `cook` varchar(255) NOT NULL,
  `total` varchar(255) NOT NULL,
  `servings` varchar(255) NOT NULL,
  `yield` varchar(255) NOT NULL,
  `nutrition_info` text NOT NULL,
  `ingredients` text NOT NULL,
  `directions` text NOT NULL,
  `cook_notes` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `date_added` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ss_services_package`
--

INSERT INTO `ss_services_package` (`services_package_id`, `service_id`, `title`, `description`, `image_1`, `image_2`, `image_3`, `image_4`, `rating`, `author`, `prep`, `cook`, `total`, `servings`, `yield`, `nutrition_info`, `ingredients`, `directions`, `cook_notes`, `status`, `date_added`) VALUES
(1, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(2, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(3, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(4, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(5, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(6, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(7, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(8, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(9, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(10, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(11, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(12, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(13, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(14, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(15, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(16, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(17, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(18, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(19, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(20, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(21, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(22, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(23, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(24, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(25, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(26, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49');
INSERT INTO `ss_services_package` (`services_package_id`, `service_id`, `title`, `description`, `image_1`, `image_2`, `image_3`, `image_4`, `rating`, `author`, `prep`, `cook`, `total`, `servings`, `yield`, `nutrition_info`, `ingredients`, `directions`, `cook_notes`, `status`, `date_added`) VALUES
(27, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(28, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(29, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(30, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(31, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(32, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(33, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(34, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(35, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(36, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49'),
(37, 1, 'Air Fryer Sweet and Spicy Roasted Carrots', '<p>These tender and roasted carrots cooked in the air fryer can be on your table in less than half an hour. Tossed in a honey-butter sauce and sprinkled with your choice of fresh basil, chives, or just salt and pepper.</p>\r\n', '1_136588_Air_fryer.jpg', '2_136588_Air_fryer.jpg', '3_136588_Air_fryer.jpg', '4_136588_Air_fryer.jpg', 0, 'Abhishek Baranwal', '5', '20', '25', '4', '8', '<p><strong>Per Serving:</strong></p>\r\n\r\n<p>129 calories; protein 0.9g; carbohydrates 19.3g; fat 6.1g; cholesterol 15.3mg; sodium 206.4mg.&nbsp;<a href="https://www.allrecipes.com/recipe/279984/air-fryer-sweet-and-spicy-roasted-carrots/#">Full Nutrition</a></p>\r\n', '<ul>\r\n	<li>cooking spray</li>\r\n	<li>1 tablespoon butter, melted</li>\r\n	<li>1 tablespoon hot honey (such as Mike&#39;s Hot Honey&reg;)</li>\r\n	<li>1 teaspoon grated orange zest</li>\r\n	<li>&frac12; teaspoon ground cardamom</li>\r\n	<li>&frac12; pound baby carrots</li>\r\n	<li>1 tablespoon freshly squeezed orange juice</li>\r\n</ul>\r\n', '<p><br />\r\n<strong>Step 1</strong><br />\r\nPreheat an air fryer to 400 degrees F (200 degrees C). Spray the basket with nonstick cooking spray.</p>\r\n\r\n<p><strong>Step 2</strong><br />\r\nCombine butter, honey, orange zest, and cardamom in a bowl. Remove 1 tablespoon of the sauce to a separate bowl and set aside. Add carrots to the remaining sauce and toss until all are well coated. Transfer carrots to the air fryer basket.</p>\r\n\r\n<p><strong>Step 3</strong><br />\r\nAir fry until carrots are roasted and fork tender, tossing every 7 minutes, for 15 to 22 minutes. Mix orange juice with reserved honey-butter sauce. Toss with carrots until well combined. Season with salt and pepper.</p>\r\n', '<p>Spray the basket with nonstick cooking spray</p>\r\n', 1, '2021-01-05 10:34:49');

-- --------------------------------------------------------

--
-- Table structure for table `ss_services_provider_hour_tracking`
--

CREATE TABLE `ss_services_provider_hour_tracking` (
  `service_provider_hour_tracking_id` int(11) NOT NULL,
  `sp_user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `hours` int(11) NOT NULL,
  `dateofclass` date NOT NULL,
  `starttime` time NOT NULL,
  `endtime` time NOT NULL,
  `approvedbyadmin` varchar(1) NOT NULL,
  `rating` int(1) NOT NULL,
  `status` int(1) NOT NULL,
  `add_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `checked` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_services_provider_institute_payment`
--

CREATE TABLE `ss_services_provider_institute_payment` (
  `service_provider_payment_id` int(11) NOT NULL,
  `service_provider_institute_id` int(11) NOT NULL,
  `total_hours` int(11) NOT NULL,
  `unit_hour_price` int(11) NOT NULL,
  `dateofpayment` datetime NOT NULL,
  `services_id` int(11) NOT NULL,
  `totalpayment` float NOT NULL,
  `bank_account_id` int(11) NOT NULL,
  `transactionid` varchar(100) NOT NULL,
  `service_provider_or_instittue` varchar(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_services_provider_ratings`
--

CREATE TABLE `ss_services_provider_ratings` (
  `service_provider_ratings_id` int(11) NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `consumer_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `totalstar` varchar(10) NOT NULL,
  `mentor_assign` int(1) NOT NULL,
  `recommend` int(1) NOT NULL,
  `comment` text NOT NULL,
  `status` int(1) NOT NULL,
  `add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_service_provider`
--

CREATE TABLE `ss_service_provider` (
  `service_provider_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `resume` varchar(255) NOT NULL,
  `resume_text` text NOT NULL,
  `occupation` varchar(255) NOT NULL,
  `designation` varchar(255) NOT NULL,
  `signinas` varchar(255) NOT NULL,
  `organization` varchar(255) NOT NULL,
  `institute_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_service_provider_availability`
--

CREATE TABLE `ss_service_provider_availability` (
  `service_provider_availablity_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `day` varchar(255) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `status` int(1) NOT NULL,
  `add_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_service_provider_bank_account_details`
--

CREATE TABLE `ss_service_provider_bank_account_details` (
  `service_provider_bank_account_details_id` int(11) NOT NULL,
  `service_provider_id` int(11) NOT NULL,
  `bankname` varchar(255) NOT NULL,
  `bankaddress` text NOT NULL,
  `ifsccode` varchar(30) NOT NULL,
  `accountname` varchar(255) NOT NULL,
  `accountnubmer` varchar(100) NOT NULL,
  `cancelchequephoto` varchar(255) NOT NULL,
  `primary_account` int(4) NOT NULL,
  `adddate` datetime NOT NULL,
  `status` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_service_provider_services`
--

CREATE TABLE `ss_service_provider_services` (
  `service_provider_service_id` int(11) NOT NULL,
  `service_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `price` float NOT NULL,
  `status` int(1) NOT NULL,
  `add_date` datetime NOT NULL,
  `modify_date` datetime NOT NULL,
  `pricebyadmin` float NOT NULL,
  `approvidebyadmin` varchar(1) NOT NULL,
  `packages_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_users`
--

CREATE TABLE `ss_users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photograph` varchar(255) NOT NULL,
  `gender` varchar(20) NOT NULL,
  `dateofbirth` date NOT NULL,
  `address` varchar(255) NOT NULL,
  `location` varchar(100) NOT NULL,
  `area` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `pincode` varchar(100) NOT NULL,
  `country` varchar(100) NOT NULL,
  `user_type` varchar(30) NOT NULL,
  `oauth_provider` varchar(255) NOT NULL,
  `oauth_uid` varchar(255) NOT NULL,
  `locale` varchar(255) NOT NULL,
  `gpluslink` tinytext NOT NULL,
  `oauth_token` varchar(255) NOT NULL,
  `oauth_secret` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `validate` tinyint(1) NOT NULL,
  `admin_validate` int(1) NOT NULL,
  `last_login` datetime NOT NULL,
  `add_date` datetime NOT NULL,
  `cover_pic` varchar(255) NOT NULL,
  `about_yourself` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_users_inbox`
--

CREATE TABLE `ss_users_inbox` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `from_user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ss_users_resetpasswordlinks`
--

CREATE TABLE `ss_users_resetpasswordlinks` (
  `users_resetpasswordlinks_id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `usertype` int(2) NOT NULL,
  `add_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ss_adminuser`
--
ALTER TABLE `ss_adminuser`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ss_adminuser_groups`
--
ALTER TABLE `ss_adminuser_groups`
  ADD PRIMARY KEY (`user_group_id`);

--
-- Indexes for table `ss_collection`
--
ALTER TABLE `ss_collection`
  ADD PRIMARY KEY (`collection_id`);

--
-- Indexes for table `ss_consumers`
--
ALTER TABLE `ss_consumers`
  ADD PRIMARY KEY (`consumer_id`);

--
-- Indexes for table `ss_consumers_hour_tracking`
--
ALTER TABLE `ss_consumers_hour_tracking`
  ADD PRIMARY KEY (`consumer_hour_tracking_id`);

--
-- Indexes for table `ss_consumer_order`
--
ALTER TABLE `ss_consumer_order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `ss_packages`
--
ALTER TABLE `ss_packages`
  ADD PRIMARY KEY (`package_id`);

--
-- Indexes for table `ss_services`
--
ALTER TABLE `ss_services`
  ADD PRIMARY KEY (`service_id`);

--
-- Indexes for table `ss_services_package`
--
ALTER TABLE `ss_services_package`
  ADD PRIMARY KEY (`services_package_id`);

--
-- Indexes for table `ss_services_provider_hour_tracking`
--
ALTER TABLE `ss_services_provider_hour_tracking`
  ADD PRIMARY KEY (`service_provider_hour_tracking_id`);

--
-- Indexes for table `ss_services_provider_institute_payment`
--
ALTER TABLE `ss_services_provider_institute_payment`
  ADD PRIMARY KEY (`service_provider_payment_id`);

--
-- Indexes for table `ss_services_provider_ratings`
--
ALTER TABLE `ss_services_provider_ratings`
  ADD PRIMARY KEY (`service_provider_ratings_id`);

--
-- Indexes for table `ss_service_provider`
--
ALTER TABLE `ss_service_provider`
  ADD PRIMARY KEY (`service_provider_id`);

--
-- Indexes for table `ss_service_provider_availability`
--
ALTER TABLE `ss_service_provider_availability`
  ADD PRIMARY KEY (`service_provider_availablity_id`);

--
-- Indexes for table `ss_service_provider_bank_account_details`
--
ALTER TABLE `ss_service_provider_bank_account_details`
  ADD PRIMARY KEY (`service_provider_bank_account_details_id`);

--
-- Indexes for table `ss_service_provider_services`
--
ALTER TABLE `ss_service_provider_services`
  ADD PRIMARY KEY (`service_provider_service_id`);

--
-- Indexes for table `ss_users`
--
ALTER TABLE `ss_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `ss_users_inbox`
--
ALTER TABLE `ss_users_inbox`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ss_users_resetpasswordlinks`
--
ALTER TABLE `ss_users_resetpasswordlinks`
  ADD PRIMARY KEY (`users_resetpasswordlinks_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ss_adminuser`
--
ALTER TABLE `ss_adminuser`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `ss_adminuser_groups`
--
ALTER TABLE `ss_adminuser_groups`
  MODIFY `user_group_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ss_collection`
--
ALTER TABLE `ss_collection`
  MODIFY `collection_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_consumers`
--
ALTER TABLE `ss_consumers`
  MODIFY `consumer_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_consumers_hour_tracking`
--
ALTER TABLE `ss_consumers_hour_tracking`
  MODIFY `consumer_hour_tracking_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_consumer_order`
--
ALTER TABLE `ss_consumer_order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_packages`
--
ALTER TABLE `ss_packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_services`
--
ALTER TABLE `ss_services`
  MODIFY `service_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `ss_services_package`
--
ALTER TABLE `ss_services_package`
  MODIFY `services_package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;
--
-- AUTO_INCREMENT for table `ss_services_provider_hour_tracking`
--
ALTER TABLE `ss_services_provider_hour_tracking`
  MODIFY `service_provider_hour_tracking_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_services_provider_institute_payment`
--
ALTER TABLE `ss_services_provider_institute_payment`
  MODIFY `service_provider_payment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_services_provider_ratings`
--
ALTER TABLE `ss_services_provider_ratings`
  MODIFY `service_provider_ratings_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_service_provider`
--
ALTER TABLE `ss_service_provider`
  MODIFY `service_provider_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_service_provider_availability`
--
ALTER TABLE `ss_service_provider_availability`
  MODIFY `service_provider_availablity_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_service_provider_bank_account_details`
--
ALTER TABLE `ss_service_provider_bank_account_details`
  MODIFY `service_provider_bank_account_details_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_service_provider_services`
--
ALTER TABLE `ss_service_provider_services`
  MODIFY `service_provider_service_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_users`
--
ALTER TABLE `ss_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_users_inbox`
--
ALTER TABLE `ss_users_inbox`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `ss_users_resetpasswordlinks`
--
ALTER TABLE `ss_users_resetpasswordlinks`
  MODIFY `users_resetpasswordlinks_id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
