-- MySQL dump 10.13  Distrib 8.0.36, for Win64 (x86_64)
--
-- Host: localhost    Database: ecommerceweb
-- ------------------------------------------------------
-- Server version	8.0.36

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `tbl_end_category`
--

CREATE TABLE `tbl_end_category` (
  `ecat_id` int(11) NOT NULL,
  `ecat_name` varchar(255) NOT NULL,
  `mcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_end_category`
--

INSERT INTO `tbl_end_category` (`ecat_id`, `ecat_name`, `mcat_id`) VALUES
(1, 'Mangoes', 1),
(2, 'Apples', 1),
(3, 'Oranges', 1),
(4, 'Avocados', 1),
(5, 'Watermelons', 1),
(6, 'Other', 1),
(7, 'Chicken', 5),
(8, 'Turkeys', 5),
(9, 'Ducks', 5),
(10, 'Other', 5),
(11, 'Goats and kids', 6),
(12, 'Cows', 7),
(13, 'Bulls', 7),
(14, 'Pigs', 8),
(15, 'Sheep and lambs', 9),
(16, 'Milk', 2),
(17, 'Eggs', 2),
(18, 'Yogurt', 2),
(19, 'Butter', 2),
(20, 'Maize', 3),
(21, 'Soyabeans', 3),
(22, 'Rice', 3),
(23, 'Ground nuts', 3),
(24, 'Wheat', 3),
(25, 'Other', 3),
(26, 'Beef', 4),
(27, 'Pork', 4),
(28, 'Chicken', 4),
(29, 'Lamb', 4),
(30, 'Turkey', 4),
(31, 'Corn seeds', 10),
(32, 'Soyabean seeds', 10),
(33, 'Nitorgen fertilizer', 11),
(34, 'NPKs fertilizer', 11),
(35, 'Urea', 11),
(36, 'Pestcides', 12),
(37, 'Herbicides', 12),
(38, 'Fungicides', 12),
(39, 'Baking flour', 13),
(40, 'All purpose flour', 13),
(41, 'Granulated sugar', 14),
(42, 'Olive oil', 15),
(43, 'Sunflower oil', 15),
(44, 'Utility tractors', 16),
(45, 'Garden tractors', 16),
(46, 'Compact tractors', 16),
(47, 'Sprinkler irrigation systems', 17),
(48, 'Drip irrigation systems', 17),
(49, 'Surface irrigation systems', 17),
(50, 'Others', 17),
(51, 'Combine harvesters', 18),
(52, 'Cotton harvestors', 18),
(53, 'Hoes', 19),
(54, 'Sholvels', 19),
(55, 'Garden forks and rakes', 19),
(56, 'Wheelbarrows', 19),
(57, 'Others', 20);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_mid_category`
--

CREATE TABLE `tbl_mid_category` (
  `mcat_id` int(11) NOT NULL,
  `mcat_name` varchar(255) NOT NULL,
  `tcat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_mid_category`
--

INSERT INTO `tbl_mid_category` (`mcat_id`, `mcat_name`, `tcat_id`) VALUES
(1, 'Fruit Products', 1),
(2, 'Dairy', 1),
(3, 'Grains and Legumes', 1),
(4, 'Meat', 1),
(5, 'Poultry', 5),
(6, 'Goat', 5),
(7, 'Cattle', 5),
(8, 'Swine', 5),
(9, 'Sheep', 5),
(10, 'Seeds', 2),
(11, 'Fertilizer', 2),
(12, 'Chemicals', 2),
(13, 'Flour', 3),
(14, 'Sugar', 3),
(15, 'Vegetables oil', 3),
(16, 'Tractors', 8),
(17, 'Irrigation equipment', 8),
(18, 'Harvesting equipment', 8),
(19, 'Farm tools', 8),
(20, 'Other', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_order`
--

DROP TABLE IF EXISTS `tbl_order`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_order` (
  `id` int NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `size` varchar(100) NOT NULL,
  `color` varchar(100) NOT NULL,
  `quantity` varchar(50) NOT NULL,
  `unit_price` varchar(50) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_order`
--

LOCK TABLES `tbl_order` WRITE;
/*!40000 ALTER TABLE `tbl_order` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_order` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_page`
--

DROP TABLE IF EXISTS `tbl_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_page` (
  `id` int NOT NULL AUTO_INCREMENT,
  `about_title` varchar(255) NOT NULL,
  `about_content` text NOT NULL,
  `about_banner` varchar(255) NOT NULL,
  `about_meta_title` varchar(255) NOT NULL,
  `about_meta_keyword` text NOT NULL,
  `about_meta_description` text NOT NULL,
  `faq_title` varchar(255) NOT NULL,
  `faq_banner` varchar(255) NOT NULL,
  `faq_meta_title` varchar(255) NOT NULL,
  `faq_meta_keyword` text NOT NULL,
  `faq_meta_description` text NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_banner` varchar(255) NOT NULL,
  `blog_meta_title` varchar(255) NOT NULL,
  `blog_meta_keyword` text NOT NULL,
  `blog_meta_description` text NOT NULL,
  `contact_title` varchar(255) NOT NULL,
  `contact_banner` varchar(255) NOT NULL,
  `contact_meta_title` varchar(255) NOT NULL,
  `contact_meta_keyword` text NOT NULL,
  `contact_meta_description` text NOT NULL,
  `pgallery_title` varchar(255) NOT NULL,
  `pgallery_banner` varchar(255) NOT NULL,
  `pgallery_meta_title` varchar(255) NOT NULL,
  `pgallery_meta_keyword` text NOT NULL,
  `pgallery_meta_description` text NOT NULL,
  `vgallery_title` varchar(255) NOT NULL,
  `vgallery_banner` varchar(255) NOT NULL,
  `vgallery_meta_title` varchar(255) NOT NULL,
  `vgallery_meta_keyword` text NOT NULL,
  `vgallery_meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_page`
--

LOCK TABLES `tbl_page` WRITE;
/*!40000 ALTER TABLE `tbl_page` DISABLE KEYS */;
INSERT INTO `tbl_page` VALUES (1,'About Us','<p style=\"border: 0px solid; margin-top: 1.5rem; margin-bottom: 0px;\">AgriConnect-Malawi&nbsp;<br><br>About Us</p>\r\n','about-banner.jpg','AgriConnect-Malawi - About Us','We Connect Farmers to Consumers','Our goal has always been to get the best in you','FAQ','faq-banner.jpg','AgriConnect-Malawi','','','Blog','blog-banner.jpg','AgriConnect-Malawi','','','Contact Us','contact-banner.jpg','AgriConnect-Malawi','','','Photo Gallery','pgallery-banner.jpg','AgriConnect-Malawi','','','Video Gallery','vgallery-banner.jpg','AgriConnect-Malawi','','');
/*!40000 ALTER TABLE `tbl_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_payment`
--

DROP TABLE IF EXISTS `tbl_payment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tbl_payment` (
  `id` int NOT NULL AUTO_INCREMENT,
  `customer_id` int NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `payment_date` varchar(50) NOT NULL,
  `txnid` varchar(255) NOT NULL,
  `paid_amount` int NOT NULL,
  `card_number` varchar(50) NOT NULL,
  `card_cvv` varchar(10) NOT NULL,
  `card_month` varchar(10) NOT NULL,
  `card_year` varchar(10) NOT NULL,
  `bank_transaction_info` text NOT NULL,
  `payment_method` varchar(20) NOT NULL,
  `payment_status` varchar(25) NOT NULL,
  `shipping_status` varchar(20) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_payment`
--

LOCK TABLES `tbl_payment` WRITE;
/*!40000 ALTER TABLE `tbl_payment` DISABLE KEYS */;
/*!40000 ALTER TABLE `tbl_payment` ENABLE KEYS */;
UNLOCK TABLES;


--
-- Table structure for table `tbl_product`
--

CREATE TABLE `tbl_product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `uploader` varchar(100) NOT NULL DEFAULT 'none',
  `p_old_price` varchar(10) NOT NULL,
  `p_current_price` varchar(10) NOT NULL,
  `p_qty` int(11) NOT NULL,
  `p_featured_photo` varchar(255) NOT NULL,
  `p_description` text NOT NULL,
  `p_short_description` text NOT NULL,
  `p_feature` text NOT NULL,
  `p_condition` text NOT NULL,
  `p_return_policy` text NOT NULL,
  `p_total_view` int(11) NOT NULL,
  `p_is_featured` int(11) NOT NULL,
  `p_is_active` int(11) NOT NULL,
  `ecat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_product`
--

INSERT INTO `tbl_product` (`p_id`, `p_name`, `uploader`, `p_old_price`, `p_current_price`, `p_qty`, `p_featured_photo`, `p_description`, `p_short_description`, `p_feature`, `p_condition`, `p_return_policy`, `p_total_view`, `p_is_featured`, `p_is_active`, `ecat_id`) VALUES
(117, 'kentt', 'kapembe@mail.com', '100', '120', 11, 'product-featured-1.jpg', '<p>Kentt mangoes</p>', '<p>Mangoes</p>', '', '<p>fresh</p>', '<p>No any</p>', 31, 1, 1, 80),
(118, 'British apples', 'none', '140', '170', 45, 'product-featured-118.jpg', '<p>British apples</p>', '<p>Apples</p>', '', '<p>fresh</p>', '<p>No any</p>', 0, 1, 1, 81),
(119, 'Kenyan Mangoes', 'none', '60', '85', 37, 'product-featured-119.jpg', '<p>Kenyan mangoes</p>', '<p>Mangoes</p>', '', '<p>fresh</p>', '<p>No any</p>', 4, 1, 1, 80),
(120, 'Tanzanian apples', 'none', '70', '82', 5, 'product-featured-120.jpg', '<p>Tanzania apples</p>', '<p>apples</p>', '', '<p>Fresh</p>', '<p>No any</p>', 7, 1, 1, 81),
(122, 'Second hand wheel barrow', 'kapembe@mail.com', '120000', '100000', 1, 'product-featured-122.jpg', '<p>Fairly Used Wheelbarrow</p>', '<p>Second hand</p>', '<p>Some Features here of wheelbarrow</p>', '<p>Second hand</p>', '<p>No return policy</p>', 5, 0, 1, 85);

-- --------------------------------------------------------


LOCK TABLES `tbl_product` WRITE;
/*!40000 ALTER TABLE `tbl_product` DISABLE KEYS */;
INSERT INTO `tbl_product` VALUES (103,'Local mangoes','110','150',30,'product-featured-103.jpg','<p>Malawian Mangoes</p>','Malawian Mangoes Short','','<p>Fresh</p>','<p>No any</p>',24,1,1,80),(104,'indian','180','200',50,'product-featured-104.png','<p>Mongies, indian variety</p>','<p>Indian Mangoes</p>','<p>N/A</p>','<p>Fresh</p>','<p>No any</p>',0,1,1,80),(105,'kensington Mangoes','120','140',74,'product-featured-105.jpg','<p>kensington, Indian mango variety<br></p>','<p>Indian Mangoes</p>','','<p>fresh</p>','<p>No any</p>',4,1,1,80),(109,'Tanzania Apples','130','150',70,'product-featured-104.jpg','<p>Tanzanian apples</p>','<p>Tanzania Apples</p>','','<p>fresh</p>','<p>No any</p>',1,0,1,81),(110,'British apples','180','200',64,'product-featured-110.jpg','<p>British apple variety</p>','<p>British apples</p>','','<p>No any</p>','<p>no any</p>',4,0,1,81);
/*!40000 ALTER TABLE `tbl_product` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `id` int(11) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `footer_about` text NOT NULL,
  `footer_copyright` text NOT NULL,
  `contact_address` text NOT NULL,
  `contact_email` varchar(255) NOT NULL,
  `contact_phone` varchar(255) NOT NULL,
  `contact_fax` varchar(255) NOT NULL,
  `contact_map_iframe` text NOT NULL,
  `receive_email` varchar(255) NOT NULL,
  `receive_email_subject` varchar(255) NOT NULL,
  `receive_email_thank_you_message` text NOT NULL,
  `forget_password_message` text NOT NULL,
  `total_recent_post_footer` int(11) NOT NULL,
  `total_popular_post_footer` int(11) NOT NULL,
  `total_recent_post_sidebar` int(11) NOT NULL,
  `total_popular_post_sidebar` int(11) NOT NULL,
  `total_featured_product_home` int(11) NOT NULL,
  `total_latest_product_home` int(11) NOT NULL,
  `total_popular_product_home` int(11) NOT NULL,
  `meta_title_home` text NOT NULL,
  `meta_keyword_home` text NOT NULL,
  `meta_description_home` text NOT NULL,
  `banner_login` varchar(255) NOT NULL,
  `banner_registration` varchar(255) NOT NULL,
  `banner_forget_password` varchar(255) NOT NULL,
  `banner_reset_password` varchar(255) NOT NULL,
  `banner_search` varchar(255) NOT NULL,
  `banner_cart` varchar(255) NOT NULL,
  `banner_checkout` varchar(255) NOT NULL,
  `banner_product_category` varchar(255) NOT NULL,
  `banner_blog` varchar(255) NOT NULL,
  `cta_title` varchar(255) NOT NULL,
  `cta_content` text NOT NULL,
  `cta_read_more_text` varchar(255) NOT NULL,
  `cta_read_more_url` varchar(255) NOT NULL,
  `cta_photo` varchar(255) NOT NULL,
  `featured_product_title` varchar(255) NOT NULL,
  `featured_product_subtitle` varchar(255) NOT NULL,
  `latest_product_title` varchar(255) NOT NULL,
  `latest_product_subtitle` varchar(255) NOT NULL,
  `popular_product_title` varchar(255) NOT NULL,
  `popular_product_subtitle` varchar(255) NOT NULL,
  `testimonial_title` varchar(255) NOT NULL,
  `testimonial_subtitle` varchar(255) NOT NULL,
  `testimonial_photo` varchar(255) NOT NULL,
  `blog_title` varchar(255) NOT NULL,
  `blog_subtitle` varchar(255) NOT NULL,
  `newsletter_text` text NOT NULL,
  `paypal_email` varchar(255) NOT NULL,
  `stripe_public_key` varchar(255) NOT NULL,
  `stripe_secret_key` varchar(255) NOT NULL,
  `bank_detail` text NOT NULL,
  `before_head` text NOT NULL,
  `after_body` text NOT NULL,
  `before_body` text NOT NULL,
  `home_service_on_off` int(11) NOT NULL,
  `home_welcome_on_off` int(11) NOT NULL,
  `home_featured_product_on_off` int(11) NOT NULL,
  `home_latest_product_on_off` int(11) NOT NULL,
  `home_popular_product_on_off` int(11) NOT NULL,
  `home_testimonial_on_off` int(11) NOT NULL,
  `home_blog_on_off` int(11) NOT NULL,
  `newsletter_on_off` int(11) NOT NULL,
  `ads_above_welcome_on_off` int(11) NOT NULL,
  `ads_above_featured_product_on_off` int(11) NOT NULL,
  `ads_above_latest_product_on_off` int(11) NOT NULL,
  `ads_above_popular_product_on_off` int(11) NOT NULL,
  `ads_above_testimonial_on_off` int(11) NOT NULL,
  `ads_category_sidebar_on_off` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci ROW_FORMAT=COMPRESSED;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`id`, `logo`, `favicon`, `footer_about`, `footer_copyright`, `contact_address`, `contact_email`, `contact_phone`, `contact_fax`, `contact_map_iframe`, `receive_email`, `receive_email_subject`, `receive_email_thank_you_message`, `forget_password_message`, `total_recent_post_footer`, `total_popular_post_footer`, `total_recent_post_sidebar`, `total_popular_post_sidebar`, `total_featured_product_home`, `total_latest_product_home`, `total_popular_product_home`, `meta_title_home`, `meta_keyword_home`, `meta_description_home`, `banner_login`, `banner_registration`, `banner_forget_password`, `banner_reset_password`, `banner_search`, `banner_cart`, `banner_checkout`, `banner_product_category`, `banner_blog`, `cta_title`, `cta_content`, `cta_read_more_text`, `cta_read_more_url`, `cta_photo`, `featured_product_title`, `featured_product_subtitle`, `latest_product_title`, `latest_product_subtitle`, `popular_product_title`, `popular_product_subtitle`, `testimonial_title`, `testimonial_subtitle`, `testimonial_photo`, `blog_title`, `blog_subtitle`, `newsletter_text`, `paypal_email`, `stripe_public_key`, `stripe_secret_key`, `bank_detail`, `before_head`, `after_body`, `before_body`, `home_service_on_off`, `home_welcome_on_off`, `home_featured_product_on_off`, `home_latest_product_on_off`, `home_popular_product_on_off`, `home_testimonial_on_off`, `home_blog_on_off`, `newsletter_on_off`, `ads_above_welcome_on_off`, `ads_above_featured_product_on_off`, `ads_above_latest_product_on_off`, `ads_above_popular_product_on_off`, `ads_above_testimonial_on_off`, `ads_category_sidebar_on_off`) VALUES
(1, 'logo.jpeg', 'favicon.png', '<p>Lorem ipsum dolor sit amet, omnis signiferumque in mei, mei ex enim concludaturque. Senserit salutandi euripidis no per, modus maiestatis scribentur est an.Â Ea suas pertinax has.</p>\r\n', 'Copyright © 2024 - AgriConnect-Malawi', 'Free market \r\nBlantyre', 'support@agriconnect-malawi.com', '+265880218905', '', '<iframe src=\"https://www.google.com/maps/place/6254%2BWX3+Blantyre+Market,+Market+Street,+Blantyre/@-15.7895743,35.004898,17.02z/data=!4m6!3m5!1s0x18d845a7b76ce68d:0x9de528f83fb4b182!8m2!3d-15.7906358!4d35.0073189!16s%2Fg%2F11b8tgs1x2?authuser=0&entry=ttu\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>', 'support@ecommercephp.com', 'Visitor Email Message from Ecommerce Site PHP', 'Thank you for sending email. We will contact you shortly.', 'A confirmation link is sent to your email address. You will get the password reset information in there.', 4, 4, 5, 5, 5, 5, 6, 'AgriConnect-Malawi', 'AgriConnect-Malawi', 'AgriConnect-Malawi', 'banner_login.jpg', 'banner_registration.jpg', 'banner_forget_password.jpg', 'banner_reset_password.jpg', 'banner_search.jpg', 'banner_cart.jpg', 'banner_checkout.jpg', 'banner_product_category.jpg', 'banner_blog.jpg', 'Welcome To Our Ecommerce Website', 'Lorem ipsum dolor sit amet, an labores explicari qui, eu nostrum copiosae argumentum has. Latine propriae quo no, unum ridens expetenda id sit, \r\nat usu eius eligendi singulis. Sea ocurreret principes ne. At nonumy aperiri pri, nam quodsi copiosae intellegebat et, ex deserunt euripidis usu. ', 'Read More', '#', 'cta.jpg', 'Featured Products', 'Our list on Top Featured Products', 'Latest Products', 'Our list of recently added products', 'Popular Products', 'Popular products based on customer\'s choice', 'Testimonials', 'See what our clients tell about us', 'testimonial.jpg', 'Latest Blog', 'See all our latest articles and news from below', 'Sign-up to our newsletter for latest promotions and discounts.', 'admin@ecom.com', 'pk_test_0SwMWadgu8DwmEcPdUPRsZ7b', 'sk_test_TFcsLJ7xxUtpALbDo1L5c1PN', 'Bank Name: National Bank of Malawi\r\nAccount Number: 100600645\r\nBranch Name: Zomba branch', '', '<div id=\"fb-root\"></div>\r\n<script>(function(d, s, id) {\r\n  var js, fjs = d.getElementsByTagName(s)[0];\r\n  if (d.getElementById(id)) return;\r\n  js = d.createElement(s); js.id = id;\r\n  js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=323620764400430\";\r\n  fjs.parentNode.insertBefore(js, fjs);\r\n}(document, \'script\', \'facebook-jssdk\'));</script>', '<!--Start of Tawk.to Script-->\n<script type=\"text/javascript\">\nvar Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\n(function(){\nvar s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\ns1.async=true;\ns1.src=\'https://embed.tawk.to/5ae370d7227d3d7edc24cb96/default\';\ns1.charset=\'UTF-8\';\ns1.setAttribute(\'crossorigin\',\'*\');\ns0.parentNode.insertBefore(s1,s0);\n})();\n</script>\n<!--End of Tawk.to Script-->', 1, 1, 0, 1, 1, 1, 1, 0, 1, 1, 1, 1, 1, 1);

-- --------------------------------------------------------

LOCK TABLES `tbl_settings` WRITE;
/*!40000 ALTER TABLE `tbl_settings` DISABLE KEYS */;
INSERT INTO `tbl_settings` VALUES (1,'logo.jpeg','favicon.png','<p>Lorem ipsum dolor sit amet, omnis signiferumque in mei, mei ex enim concludaturque. Senserit salutandi euripidis no per, modus maiestatis scribentur est an.Â Ea suas pertinax has.</p>\r\n','Copyright © 2024 - AgriConnect-Malawi','Free market \r\nBlantyre','support@agriconnect-malawi.com','+265880218905','','<iframe src=\"https://www.google.com/maps/place/6254%2BWX3+Blantyre+Market,+Market+Street,+Blantyre/@-15.7895743,35.004898,17.02z/data=!4m6!3m5!1s0x18d845a7b76ce68d:0x9de528f83fb4b182!8m2!3d-15.7906358!4d35.0073189!16s%2Fg%2F11b8tgs1x2?authuser=0&entry=ttu\" width=\"600\" height=\"450\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\"></iframe>','support@ecommercephp.com','Visitor Email Message from Ecommerce Site PHP','Thank you for sending email. We will contact you shortly.','A confirmation link is sent to your email address. You will get the password reset information in there.',4,4,5,5,5,5,6,'AgriConnect-Malawi','AgriConnect-Malawi','AgriConnect-Malawi','banner_login.jpg','banner_registration.jpg','banner_forget_password.jpg','banner_reset_password.jpg','banner_search.jpg','banner_cart.jpg','banner_checkout.jpg','banner_product_category.jpg','banner_blog.jpg','Welcome To Our Ecommerce Website','Lorem ipsum dolor sit amet, an labores explicari qui, eu nostrum copiosae argumentum has. Latine propriae quo no, unum ridens expetenda id sit, \r\nat usu eius eligendi singulis. Sea ocurreret principes ne. At nonumy aperiri pri, nam quodsi copiosae intellegebat et, ex deserunt euripidis usu. ','Read More','#','cta.jpg','Featured Products','Our list on Top Featured Products','Latest Products','Our list of recently added products','Popular Products','Popular products based on customer\'s choice','Testimonials','See what our clients tell about us','testimonial.jpg','Latest Blog','See all our latest articles and news from below','Sign-up to our newsletter for latest promotions and discounts.','admin@ecom.com','pk_test_0SwMWadgu8DwmEcPdUPRsZ7b','sk_test_TFcsLJ7xxUtpALbDo1L5c1PN','Bank Name: National Bank of Malawi\r\nAccount Number: 1002398543\r\nBranch Name: Henderson Street, Blantyre\r\nCountry: Blantyre','','<div id=\"fb-root\"></div>\r\n<script>(function(d, s, id) {\r\n  var js, fjs = d.getElementsByTagName(s)[0];\r\n  if (d.getElementById(id)) return;\r\n  js = d.createElement(s); js.id = id;\r\n  js.src = \"//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.10&appId=323620764400430\";\r\n  fjs.parentNode.insertBefore(js, fjs);\r\n}(document, \'script\', \'facebook-jssdk\'));</script>','<!--Start of Tawk.to Script-->\r\n<script type=\"text/javascript\">\r\nvar Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();\r\n(function(){\r\nvar s1=document.createElement(\"script\"),s0=document.getElementsByTagName(\"script\")[0];\r\ns1.async=true;\r\ns1.src=\'https://embed.tawk.to/5ae370d7227d3d7edc24cb96/default\';\r\ns1.charset=\'UTF-8\';\r\ns1.setAttribute(\'crossorigin\',\'*\');\r\ns0.parentNode.insertBefore(s1,s0);\r\n})();\r\n</script>\r\n<!--End of Tawk.to Script-->',0,1,0,1,1,1,1,1,1,1,1,1,1,1);
/*!40000 ALTER TABLE `tbl_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_slider`
--

CREATE TABLE `tbl_slider` (
  `id` int(11) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `heading` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `button_text` varchar(255) NOT NULL,
  `button_url` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_slider`
--

INSERT INTO `tbl_slider` (`id`, `photo`, `heading`, `content`, `button_text`, `button_url`, `position`) VALUES
(4, 'slider-4.jpg', 'Welcome to AgriConnect-Malawi', 'Shop online farm products and farm tools', '', '', 'Center'),
(5, 'slider-4.jpeg', '50% Discount on all Products', 'Buy more enjoy high Discounts', '', '', 'Center'),
(6, 'slider-6.jpg', '24 Hours Customer Support', 'Anytime we are available for you', '', '', 'Right');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_top_category`
--

CREATE TABLE `tbl_top_category` (
  `tcat_id` int(11) NOT NULL,
  `tcat_name` varchar(255) NOT NULL,
  `show_on_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_top_category`
--

INSERT INTO `tbl_top_category` (`tcat_id`, `tcat_name`, `show_on_menu`) VALUES
(1, 'Food Products', 1),
(2, 'Non-Food Products', 1),
(3, 'Prepared Products', 1),
(5, 'Livestock', 1),
(8, 'Machinery & Tools', 1);

-- --------------------------------------------------------


