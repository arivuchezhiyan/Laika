-- -------------------------------------------------------------
-- QASWAH HEALTH CLINIC Database Schema Export
-- Database: u305588601_qaswah
-- Created for: Unified Blog Administration Panel
-- -------------------------------------------------------------

SET FOREIGN_KEY_CHECKS = 0;

-- -------------------------------------------------------------
-- Table Structure for `users` (Core Admin User Accounts)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `email` VARCHAR(100) DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('Administrator', 'Agent', 'Editor', 'Developer') DEFAULT 'Editor',
    `last_login` DATETIME DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Table Structure for `system_logs` (Audit Trails)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `system_logs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `user_id` INT DEFAULT NULL,
    `action` VARCHAR(255) DEFAULT NULL,
    `details` TEXT DEFAULT NULL,
    `ip_address` VARCHAR(45) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Table Structure for `category` (Blog Categories)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `category` (
    `category_id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_name` VARCHAR(255) NOT NULL,
    `category_slug` VARCHAR(255) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Table Structure for `tags` (Blog Tags)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tags` (
    `tag_id` INT AUTO_INCREMENT PRIMARY KEY,
    `tag_name` VARCHAR(255) NOT NULL,
    `tag_slug` VARCHAR(255) NOT NULL UNIQUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Table Structure for `posts` (Blog Posts Store)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `posts` (
    `post_id` INT AUTO_INCREMENT PRIMARY KEY,
    `post_title` VARCHAR(255) NOT NULL,
    `post_slug` VARCHAR(255) NOT NULL UNIQUE,
    `category_id` INT DEFAULT NULL,
    `post_content` LONGTEXT NOT NULL,
    `meta_title` VARCHAR(255) DEFAULT NULL,
    `meta_description` TEXT DEFAULT NULL,
    `meta_keyword` VARCHAR(255) DEFAULT NULL,
    `image_path` VARCHAR(255) DEFAULT NULL,
    `post_status` ENUM('draft', 'published') DEFAULT 'draft',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `published_at` TIMESTAMP NULL DEFAULT NULL,
    CONSTRAINT `fk_post_category` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -------------------------------------------------------------
-- Table Structure for `post_tags` (Junction Table for Posts & Tags)
-- -------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `post_tags` (
    `post_id` INT NOT NULL,
    `tag_id` INT NOT NULL,
    PRIMARY KEY (`post_id`, `tag_id`),
    CONSTRAINT `fk_post_tags_post` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`) ON DELETE CASCADE,
    CONSTRAINT `fk_post_tags_tag` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`tag_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
