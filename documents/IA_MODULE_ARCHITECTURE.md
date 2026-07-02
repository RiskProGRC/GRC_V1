# Internal Audit Module — Architecture (governs all 6 phases)

Grounded design from the `architect` agent. Backs all 32 PSASB templates with **25 tables**
(2 core + 23 phase tables), consuming all 9 orphan tables. Zero FK constraints (schema-wide convention).

## Core concept
`audit_engagement` (replaces orphan `nletter`) is the hub; Phase 3–5 artefacts hang off it via
`engagement_id`. `audit_rating` (grade/points/color/meaning) kept as the reused severity scale.

## Tables by phase
- **P1 Governance:** `ia_charter` (charter_type discriminates Audit-Committee vs Internal-Audit) — templates 1,2
- **P2 Planning:** `ia_strategic_plan` (3); `ia_annual_plan` + `ia_annual_plan_item` (4)
- **P3 Engagement:** `audit_engagement` (7 hub); `ia_ethics_ack` (5); `ia_coordination_reliance` (6);
  `ia_engagement_plan` (replaces `auditprog`; 8+9); `ia_checklist_item` (10,11,21 via checklist_type);
  `ia_process_analysis` (12); `ia_audit_program` (13)
- **P4 Fieldwork:** `meeting`+`meeting_participant` (14-17 via meeting_type×record_type);
  `ia_engagement_document` (replaces `letterupload`); `ia_workpaper` (18); `ia_finding` (replaces `audit`; 19,20);
  `ia_review_note` (22)
- **P5 Reporting:** `ia_final_report` (23); `ia_action_plan_summary` (replaces `mngtletter`; 24);
  `ia_report_summary` (replaces `findings`; 25,26 via report_type)
- **P6 QA:** `ia_survey`+`ia_survey_response` (27-30 via survey_type); `ia_performance_matrix` (31);
  `ia_qa_document` (replaces `pubaccount`; 32)

## Non-negotiable pitfalls (from grounded review)
1. `AuthGuard.php` exposes only `$uid,$sdid,$ip` — NOT `$sess_roles`. In action files read `(int)($_SESSION['roles'] ?? 0)`.
2. Pages use `include_once './mod/xClass.php'` (cwd-relative); action files use `require_once __DIR__ . '/mod/xClass.php'`. Mirror exactly.
3. No FK constraints anywhere — all relations are plain `int(11)` columns.
4. `updated_at` is NEVER DB-auto-updated — every `update()` sets it explicitly in SQL.
5. Orphan tables confirmed empty + unreferenced — `DROP TABLE IF EXISTS`+`CREATE` is safe.
6. `risk` table uses bare `dept` column (not `dept_id`); all new IA tables use `dept_id`.
7. `BaseRepository::fetchWhere()` is single-column only — discriminator+engagement filters need custom `prepare()` methods.
8. File uploads have no collision protection in existing code — prefix IA upload filenames with id+timestamp before `move_uploaded_file()`.
9. `role-readonly` gating: body class via `in_array($sess_roles,[1,3])` + `.btn-userpermission-add/edit/delete` on buttons. Reuse identically.
10. Do NOT add IA classes to `header.php` (it eager-instantiates every class per page load) — instantiate per page/action only.

## Nav
One "Internal Audit" dropdown inserted after Recommendations (nav.php ~line 360). Links added
**progressively per phase** (no dead links in any committed state): Charters → Strategic Plan →
Annual Plan → Engagements → Findings Database → Reports → Performance & QA.

## Branch plan (stacked; each forks from previous phase tip)
chore/gitignore → feat/ia-governance-charters → feat/ia-strategic-annual-planning →
feat/ia-engagement-planning → feat/ia-fieldwork-workpapers → feat/ia-reporting → feat/ia-quality-assurance
