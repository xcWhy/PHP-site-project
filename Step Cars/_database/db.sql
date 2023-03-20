-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.31 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table emag.category
CREATE TABLE IF NOT EXISTS `category` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table emag.category: ~6 rows (approximately)
INSERT INTO `category` (`id`, `name`) VALUES
	(1, 'Toys'),
	(2, 'Men Clothing'),
	(3, 'Women Clothing'),
	(4, 'Electonics'),
	(5, 'Smartphones and Tablets'),
	(8, 'Abc');

-- Dumping structure for table emag.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `category_id` int unsigned NOT NULL,
  `is_promo` tinyint unsigned NOT NULL DEFAULT '1',
  `availability` enum('available','out_of_stock','expected') NOT NULL DEFAULT 'available',
  `picture` varchar(50) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table emag.product: ~7 rows (approximately)
INSERT INTO `product` (`id`, `name`, `price`, `category_id`, `is_promo`, `availability`, `picture`, `description`) VALUES
	(1, 'Teddy Bear', 12.34, 1, 1, 'available', '63df8a9f73b83.jpg', NULL),
	(2, 'Unicorn Pink', 23.45, 1, 0, 'available', '63df8f7819fc7.jpg', 'Vivamus lacinia convallis leo, ac vehicula odio imperdiet sed. In pulvinar ornare vulputate. Cras dapibus elit eget velit porta, sit amet lacinia velit dictum. Integer id nisl sit amet mi eleifend mollis. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean mattis venenatis mauris, ut finibus arcu vehicula vitae. Aenean tincidunt purus at sodales bibendum. Nam sit amet lobortis quam. In ut ligula malesuada, posuere mauris vel, tristique magna. Integer eget placerat lorem. Suspendisse sit amet laoreet turpis, id iaculis lorem. Mauris et aliquam urna. Vestibulum consectetur turpis id convallis sagittis.\r\n\r\nNam lacus orci, ultrices sed sapien porttitor, fringilla aliquet metus. Ut egestas, velit vehicula dictum faucibus, mi lectus rhoncus arcu, at congue turpis turpis sed diam. Nullam sed hendrerit urna. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Ut volutpat massa dui, molestie porttitor lorem sodales eu. Nulla rutrum lorem at consequat porttitor. Vivamus sed pulvinar sapien. Pellentesque sapien ipsum, lacinia ac sem vitae, ultrices sagittis quam. Suspendisse mollis mi eget lacus imperdiet, vitae porttitor tortor ornare. Maecenas sed tellus eget elit euismod ornare. Suspendisse et enim efficitur dui iaculis pellentesque at ut metus. Vestibulum mattis dignissim nisi eu tincidunt.'),
	(3, 'Laptop Lenovo', 121212.34, 4, 1, 'available', '63dfa01598cd8.jpg', NULL),
	(4, 'Laptop Dell', 45.23, 4, 1, 'available', '63e8a339c3626.jpg', NULL),
	(5, 'Laptop Dell', 45.23, 4, 1, 'available', '63e8a3f470d06.jpg', NULL),
	(6, 'Laptop Dell', 45.36, 4, 1, 'available', '63e8acfe3e1b4.jpg', NULL),
	(7, 'iPhone 14', 121212.00, 5, 0, 'available', '', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
