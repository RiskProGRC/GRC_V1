-- ============================================================
-- User Management Module — DB Migration
-- Run this in phpMyAdmin or via CLI: mysql -u root grc < migration_user_management.sql
-- Date: 2026-06-24
-- ============================================================

-- 1. Soft-delete support
ALTER TABLE `users` ADD COLUMN `deleted_at` DATETIME NULL DEFAULT NULL AFTER `created_at`;

-- 2. Profile photo path
ALTER TABLE `users` ADD COLUMN `avatar` VARCHAR(255) NULL DEFAULT NULL AFTER `deleted_at`;

-- 3. Force-reset flag (used by adminResetPassword)
ALTER TABLE `users` ADD COLUMN `first_login` TINYINT(1) NOT NULL DEFAULT 0 AFTER `avatar`;

-- 4. Unique constraints — prevent duplicate email/username at DB level
--    (Comment out if duplicates already exist in your data)
ALTER TABLE `users` ADD UNIQUE KEY `uq_email`    (`email`);
ALTER TABLE `users` ADD UNIQUE KEY `uq_username` (`username`);
