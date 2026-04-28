-- Hidayah DeenHub - Database schema
-- Compatible with MySQL 5.7+ / MariaDB 10.3+

CREATE DATABASE IF NOT EXISTS `hidayah_deenhub`
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;

USE `hidayah_deenhub`;

-- ---------------------------------------------------------------------------
-- Users
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `username`      VARCHAR(40)  NOT NULL UNIQUE,
    `email`         VARCHAR(190) NOT NULL UNIQUE,
    `password_hash` VARCHAR(255) NOT NULL,
    `is_admin`      TINYINT(1)   NOT NULL DEFAULT 0,
    `city`          VARCHAR(100) DEFAULT NULL,
    `country`       VARCHAR(100) DEFAULT NULL,
    `created_at`    TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Islamic tips / daily reminders
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `tips` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `title`      VARCHAR(255) NOT NULL,
    `body`       TEXT NOT NULL,
    `reference`  VARCHAR(255) DEFAULT NULL,
    `category`   VARCHAR(50)  DEFAULT 'general',
    `is_active`  TINYINT(1)   NOT NULL DEFAULT 1,
    `created_at` TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_tips_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Quiz questions
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `quiz_questions` (
    `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `question`       TEXT NOT NULL,
    `option_a`       VARCHAR(255) NOT NULL,
    `option_b`       VARCHAR(255) NOT NULL,
    `option_c`       VARCHAR(255) NOT NULL,
    `option_d`       VARCHAR(255) NOT NULL,
    `correct_option` ENUM('A','B','C','D') NOT NULL,
    `explanation`    TEXT DEFAULT NULL,
    `difficulty`     ENUM('easy','medium','hard') NOT NULL DEFAULT 'easy',
    `is_active`      TINYINT(1) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`),
    KEY `idx_quiz_active` (`is_active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Quiz attempts (leaderboard)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `quiz_attempts` (
    `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id`         INT UNSIGNED DEFAULT NULL,
    `display_name`    VARCHAR(80)  NOT NULL,
    `score`           INT UNSIGNED NOT NULL,
    `total_questions` INT UNSIGNED NOT NULL,
    `duration_sec`    INT UNSIGNED NOT NULL DEFAULT 0,
    `created_at`      TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_attempts_score` (`score` DESC),
    CONSTRAINT `fk_attempt_user` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- 99 Names of Allah
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `names_of_allah` (
    `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `position`      INT UNSIGNED NOT NULL UNIQUE,
    `arabic`        VARCHAR(80)  NOT NULL,
    `transliteration` VARCHAR(80) NOT NULL,
    `meaning`       VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Prayer-time cache (one row per city/country/method/date)
-- ---------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `prayer_cache` (
    `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `cache_key`  VARCHAR(191) NOT NULL UNIQUE,
    `payload`    MEDIUMTEXT NOT NULL,
    `expires_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_prayer_expires` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
