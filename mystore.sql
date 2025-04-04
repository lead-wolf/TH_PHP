-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.10.0.7000
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for my_store
DROP DATABASE IF EXISTS `my_store`;
CREATE DATABASE IF NOT EXISTS `my_store` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `my_store`;

-- Dumping structure for table my_store.account
DROP TABLE IF EXISTS `account`;
CREATE TABLE IF NOT EXISTS `account` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.account: ~2 rows (approximately)
DELETE FROM `account`;
INSERT INTO `account` (`id`, `username`, `fullname`, `password`, `role`) VALUES
	(1, 'binhan', 'ThieuBinhAn', '$2y$10$CtZ3q4.X8B/TpjXIXiQLUeBLCTwh.gUv/nv7kzuw8dESq/rwKPWoC', 'user'),
	(2, 'admin', 'admin', '$2y$12$zBfLJExxn7uBebIaZpdLnumQxhema4o9AbjrXu4gp/sGt/Y/Kdone', 'admin'),
	(4, 'testuser', 'Test User', '$2y$12$zBfLJExxn7uBebIaZpdLnumQxhema4o9AbjrXu4gp/sGt/Y/Kdone', 'user'),
	(5, 'abc', 'test abc', '$2y$12$oveOnWrvYNEE.C3uwOkI5.2AaZWyhRlC.82wgwMiyINNyzflezmeW', 'user');

-- Dumping structure for table my_store.category
DROP TABLE IF EXISTS `category`;
CREATE TABLE IF NOT EXISTS `category` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.category: ~8 rows (approximately)
DELETE FROM `category`;
INSERT INTO `category` (`id`, `name`, `description`) VALUES
	(1, 'Bộ điều khiển', 'Bộ điều khiển'),
	(2, 'Chuột máy tính', 'Chuột máy tính'),
	(3, 'Điện thoại', 'Điện thoại'),
	(4, 'Đồng hồ', 'Đồng hồ'),
	(5, 'Keyboard', 'Keyboard'),
	(6, 'Màn hình', 'Màn hình'),
	(7, 'Máy tính', 'Máy tính'),
	(8, 'Smart Home', 'Smart Home');

-- Dumping structure for table my_store.orders
DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.orders: ~2 rows (approximately)
DELETE FROM `orders`;
INSERT INTO `orders` (`id`, `name`, `phone`, `address`, `created_at`) VALUES
	(1, 'ca', '(+84) 907 298 564', 'ádfb', '2025-03-21 03:47:39'),
	(2, 'binhan', '0907298564', 'thuduc', '2025-03-21 03:56:37');

-- Dumping structure for table my_store.order_details
DROP TABLE IF EXISTS `order_details`;
CREATE TABLE IF NOT EXISTS `order_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `order_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.order_details: ~6 rows (approximately)
DELETE FROM `order_details`;
INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
	(1, 1, 4, 3, 18790000.00),
	(2, 1, 2, 1, 1799000.00),
	(3, 1, 6, 2, 31090000.00),
	(4, 1, 5, 1, 18690000.00),
	(5, 1, 8, 1, 31990000.00),
	(6, 2, 4, 4, 18790000.00);

-- Dumping structure for table my_store.product
DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `description` text,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `category_id` (`category_id`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table my_store.product: ~7 rows (approximately)
DELETE FROM `product`;
INSERT INTO `product` (`id`, `name`, `description`, `price`, `image`, `category_id`) VALUES
	(2, 'Laptop HP Pavilion 15-eg3111TU i5 1335U/16GB/512GB/15.6inchFHD/Win11', 'Chính sách dành cho sản phẩm\r\nHàng chính hãng\r\nBảo hành 12 tháng\r\nGiao hàng miễn phí trong 90 phút\r\nHỗ trợ cài đặt miễn phí\r\nChính sách đổi trả\r\nChính sách trả góp\r\nKỹ thuật viên hỗ trợ trực tuyến', 1799000.00, '67dcc477dbc6f.jpg', 7),
	(4, 'Laptop MSI Gaming Thin GF63 12VE-454VN', 'Chính sách dành cho sản phẩm\nHàng chính hãng\nBảo hành 12 tháng\nGiao hàng miễn phí trong 90 phút\nHỗ trợ cài đặt miễn phí\nChính sách đổi trả\nChính sách trả góp\nKỹ thuật viên hỗ trợ trực tuyến', 18790000.00, '67dcc7fe002c5.jpg', 7),
	(5, 'Laptop Acer Aspire 7 Gaming A715-76G-5806', 'Laptop Acer Aspire 7 Gaming A715-76G-5806 i5 12450H/16GB/512GB/NVIDIA RTX3050 4GB/Win11', 18690000.00, '67dcc84f25590.jpg', 7),
	(6, 'Phone 16 Pro Max 256GB', 'Chính sách dành cho sản phẩm\nHàng chính hãng - Bảo hành 12 tháng\nGiao hàng toàn quốc\nKỹ thuật viên hỗ trợ trực tuyến', 31090000.00, '67dcc8a2d0e9e.png', 3),
	(7, 'Samsung Galaxy S24 Ultra 5G 256GB', 'Chính sách dành cho sản phẩm image Hàng chính hãng - Bảo hành 12 tháng image Giao hàng toàn quốc image Kỹ thuật viên hỗ trợ trực tuyến', 2399000.00, '67dcc8da40e3b.png', 3),
	(12, 'fsjksfjhjh', 'ksdfjhfdhjk', 8643368.00, '67ef3dfd3915f.jpg', 1),
	(13, 'new nfsjksfjhjh tata', 'ksdfjhfdhjk', 8643368.00, '67ef4f980b47e.jpg', 1),
	(14, 'edit nfsjksfjhjh', 'ksdfjhfdhjk', 8643368.00, '67ef4d4f36dd5.jpg', 1),
	(16, 'jfsnsfnjsf', ';ksdjsfdkfjl', 89383384.00, '67ef5017c6eb3.jpg', 1);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
