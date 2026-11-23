-- rigmarket db setup

CREATE DATABASE IF NOT EXISTS `rigmarket_db`;
USE `rigmarket_db`;

-- table for contact inquiries
CREATE TABLE IF NOT EXISTS `inquiries` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `category` VARCHAR(100) NOT NULL,
    `issue` VARCHAR(150) NOT NULL,
    `message` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- table for users
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- default users
INSERT INTO `users` (`name`, `email`, `password`) VALUES
('Test User', 'test@example.com', 'password123'),
('Admin', 'admin@rigmarket.ph', 'admin')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);
