-- Internal Audit — Phase 1: Governance & Charter
-- PSASB templates: (1) Model Audit Committee Charter, (2) Model Internal Audit Charter
-- One table; `charter_type` discriminates the two. No FK constraints (schema-wide convention).

CREATE TABLE IF NOT EXISTS `ia_charter` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `charter_type` varchar(30) NOT NULL COMMENT 'audit_committee | internal_audit',
  `title` varchar(255) NOT NULL,
  `version` varchar(20) DEFAULT NULL,
  `content` text DEFAULT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `approved_by` varchar(200) DEFAULT NULL,
  `approved_date` date DEFAULT NULL,
  `review_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Draft',
  `uid` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `idx_charter_type` (`charter_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
