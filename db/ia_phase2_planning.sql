-- Internal Audit — Phase 2: Strategic & Annual Planning
-- PSASB templates: (3) IA Strategic Plan, (4) IA Annual Plan (risk-based)
-- No FK constraints (schema-wide convention); relations are plain int columns.

CREATE TABLE IF NOT EXISTS `ia_strategic_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `period_start_year` int(11) NOT NULL,
  `period_end_year` int(11) NOT NULL,
  `objectives` text NOT NULL,
  `resource_plan` text DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Draft',
  `uid` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ia_annual_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `plan_year` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `approved_by` varchar(200) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Draft',
  `uid` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ia_annual_plan_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `annual_plan_id` int(11) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `process_id` int(11) DEFAULT NULL,
  `risk_id` int(11) DEFAULT NULL,
  `audit_title` varchar(255) NOT NULL,
  `risk_rating` varchar(30) DEFAULT NULL,
  `quarter_planned` tinyint(1) DEFAULT NULL,
  `budgeted_days` int(11) DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Planned',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_api_plan` (`annual_plan_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
