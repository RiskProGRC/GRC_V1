-- Internal Audit — Phase 3: Engagement Planning (PSASB templates 5-13)
-- Consumes orphan tables nletter (-> audit_engagement) and auditprog (-> ia_engagement_plan).
-- No FK constraints (schema-wide convention).

DROP TABLE IF EXISTS `nletter`;
CREATE TABLE IF NOT EXISTS `audit_engagement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `dept_id` int(11) NOT NULL,
  `engagement_type` varchar(50) NOT NULL DEFAULT 'Assurance',
  `risk_id` int(11) DEFAULT NULL,
  `annual_plan_item_id` int(11) DEFAULT NULL,
  `scope_description` text DEFAULT NULL,
  `auditee_owner` varchar(200) DEFAULT NULL,
  `lead_auditor` int(11) DEFAULT NULL,
  `planned_start` date DEFAULT NULL,
  `planned_end` date DEFAULT NULL,
  `status` varchar(30) NOT NULL DEFAULT 'Notified',
  `notification_filename` varchar(255) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ia_ethics_ack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `auditor_name` varchar(200) NOT NULL,
  `acknowledgement_text` text NOT NULL,
  `signed_date` date DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_ea_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ia_coordination_reliance` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `assurance_provider` varchar(200) NOT NULL,
  `scope_area` varchar(255) NOT NULL,
  `reliance_basis` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_cr_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS `auditprog`;
CREATE TABLE IF NOT EXISTS `ia_engagement_plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `objectives` text DEFAULT NULL,
  `scope` text DEFAULT NULL,
  `criteria` text DEFAULT NULL,
  `resources_required` text DEFAULT NULL,
  `risks_to_engagement` text DEFAULT NULL,
  `planned_start` date DEFAULT NULL,
  `exit_meeting` date DEFAULT NULL,
  `draft_issued` date DEFAULT NULL,
  `final_report` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Draft',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_ep_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ia_checklist_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `checklist_type` varchar(30) NOT NULL DEFAULT 'info_request',
  `item_description` varchar(500) NOT NULL,
  `requested_from` varchar(200) DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `completed_date` date DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Pending',
  `remarks` varchar(500) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_ci_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ia_process_analysis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `process_id` int(11) DEFAULT NULL,
  `process_name` varchar(200) NOT NULL,
  `process_owner` varchar(200) DEFAULT NULL,
  `inputs` text DEFAULT NULL,
  `activities` text DEFAULT NULL,
  `outputs` text DEFAULT NULL,
  `key_risks` text DEFAULT NULL,
  `key_controls` text DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_pa_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `ia_audit_program` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `engagement_id` int(11) NOT NULL,
  `objective` varchar(500) NOT NULL,
  `risk_addressed` varchar(500) DEFAULT NULL,
  `control_tested` varchar(500) DEFAULT NULL,
  `test_procedure` text NOT NULL,
  `sample_size` varchar(50) DEFAULT NULL,
  `wp_ref` varchar(50) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'Planned',
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`), KEY `idx_ap_eng` (`engagement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
