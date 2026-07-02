-- Internal Audit — Phase 6: Quality Assurance & Performance (PSASB templates 27-32)
-- Consumes orphan table pubaccount (-> ia_qa_document).

-- (27-30) Surveys: client / audit_committee / senior_mgmt / staff (one row per respondent submission)
CREATE TABLE IF NOT EXISTS `ia_survey` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `survey_type` varchar(30) NOT NULL,             -- client | audit_committee | senior_mgmt | staff
  `period_year` int(11) NOT NULL,
  `engagement_id` int(11) DEFAULT NULL,           -- only for client surveys
  `respondent_name` varchar(200) DEFAULT NULL,
  `respondent_role` varchar(150) DEFAULT NULL,
  `overall_score` tinyint(2) DEFAULT NULL,        -- 1-5
  `comments` text DEFAULT NULL,
  `submitted_at` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_sv_type` (`survey_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- (31) Performance Measurement Matrix
CREATE TABLE IF NOT EXISTS `ia_performance_matrix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `period_year` int(11) NOT NULL,
  `kpi_name` varchar(255) NOT NULL,
  `target` varchar(100) DEFAULT NULL,
  `actual` varchar(100) DEFAULT NULL,
  `measurement_basis` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'On Track',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- (32) External Assessors TOR / QAIP documents
DROP TABLE IF EXISTS `pubaccount`;
CREATE TABLE IF NOT EXISTS `ia_qa_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `year` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `assessor_name` varchar(200) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Draft',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
