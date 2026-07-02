-- Internal Audit — Phase 4: Fieldwork & Documentation (PSASB templates 14-22)
-- Consumes orphan tables meeting (-> new meeting), letterupload (-> ia_engagement_document),
-- audit (-> ia_finding). Seeds audit_rating. No FK constraints (schema convention).

DROP TABLE IF EXISTS `meeting`;
CREATE TABLE IF NOT EXISTS `meeting` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `meeting_type` varchar(20) NOT NULL,            -- entrance | exit
  `record_type` varchar(20) NOT NULL,             -- agenda | minutes
  `venue` varchar(200) DEFAULT NULL,
  `mdate` date DEFAULT NULL,
  `participants` text DEFAULT NULL,
  `content` text DEFAULT NULL,                     -- agenda items or minutes
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_mt_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `letterupload`;
CREATE TABLE IF NOT EXISTS `ia_engagement_document` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `doc_type` varchar(60) DEFAULT NULL,
  `filename` varchar(255) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `uploaded_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_ed_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ia_workpaper` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `wp_ref` varchar(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `objective` text DEFAULT NULL,
  `procedures_performed` text DEFAULT NULL,
  `conclusion` text DEFAULT NULL,
  `preparer` varchar(150) DEFAULT NULL,
  `prepared_date` date DEFAULT NULL,
  `reviewer` varchar(150) DEFAULT NULL,
  `reviewed_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Draft',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_wp_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `audit`;
CREATE TABLE IF NOT EXISTS `ia_finding` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `dept_id` int(11) DEFAULT NULL,
  `risk_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL,
  `finding` varchar(3000) NOT NULL,
  `root_cause` text DEFAULT NULL,
  `recommend` varchar(3000) DEFAULT NULL,
  `management_response` text DEFAULT NULL,
  `responsible_officer` varchar(200) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Draft',   -- Draft | Open | Closed | Overdue
  `timeline` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_fd_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ia_review_note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `wp_ref` varchar(50) DEFAULT NULL,
  `reviewer` varchar(150) NOT NULL,
  `review_comment` text NOT NULL,
  `preparer_response` text DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Open',    -- Open | Cleared
  `raised_date` date DEFAULT NULL,
  `cleared_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_rn_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- severity/rating scale reused by findings & reports (idempotent seed)
INSERT INTO `audit_rating` (`grade`,`points`,`color`,`meaning`)
SELECT * FROM (
  SELECT 'Critical' AS grade, 4 AS points, 1 AS color, 'Severe control failure requiring immediate action' AS meaning UNION ALL
  SELECT 'High', 3, 2, 'Significant weakness requiring prompt action' UNION ALL
  SELECT 'Medium', 2, 3, 'Moderate weakness to be addressed in due course' UNION ALL
  SELECT 'Low', 1, 4, 'Minor issue / improvement opportunity' UNION ALL
  SELECT 'Satisfactory', 0, 5, 'Controls operating effectively'
) AS seed
WHERE NOT EXISTS (SELECT 1 FROM `audit_rating`);
