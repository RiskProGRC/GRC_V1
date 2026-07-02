-- Internal Audit — Phase 5: Reporting (PSASB templates 23-26)
-- Consumes orphan tables mngtletter (-> ia_action_plan_summary) and findings (-> ia_report_summary).

CREATE TABLE IF NOT EXISTS `ia_final_report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `report_title` varchar(255) NOT NULL,
  `executive_summary` text DEFAULT NULL,
  `overall_rating` int(11) DEFAULT NULL,
  `issued_date` date DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Draft',
  `uid` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_fr_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `mngtletter`;
CREATE TABLE IF NOT EXISTS `ia_action_plan_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dept_id` int(11) DEFAULT NULL,
  `year` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `closed` int(11) NOT NULL DEFAULT 0,
  `ongoing` int(11) NOT NULL DEFAULT 0,
  `pending` int(11) NOT NULL DEFAULT 0,
  `filename` varchar(255) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `findings`;
CREATE TABLE IF NOT EXISTS `ia_report_summary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `report_type` varchar(20) NOT NULL DEFAULT 'quarterly',   -- quarterly | annual
  `year` int(11) NOT NULL,
  `quarter` tinyint(2) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `narrative` text DEFAULT NULL,
  `closed` int(11) NOT NULL DEFAULT 0,
  `ongoing` int(11) NOT NULL DEFAULT 0,
  `pending` int(11) NOT NULL DEFAULT 0,
  `filename` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Draft',
  `uid` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
