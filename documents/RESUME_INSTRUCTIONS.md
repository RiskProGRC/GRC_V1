# RESUME INSTRUCTIONS

To continue this work in a fresh session:

1. Read `documents/SESSION_RECOVERY.md`, `documents/PSASB_IA_GAP_ANALYSIS.md`, `documents/IA_MODULE_ARCHITECTURE.md`.
2. Check current branch and phase progress: `git branch --list 'feat/ia-*'` and `git log --oneline -15`.
3. Branches STACK sequentially (each phase forks from the previous phase tip). Never branch phases from `main`.
4. Never `git push`. Never commit `Project/connection/config.php` (live DB creds).
5. Running app: `127.0.0.1:8020`. Login `hillary@gmail.com` / `hillary`.
6. DB: `mysql -ukimemia -p'@K1m3m14' risk_pro_grc`.
7. Screenshots: scratchpad `shoot.js` (Playwright). Save to `screenshots/<phase>/`. `.gitignore` excludes `/screenshots`.
8. Per-phase loop: branch → DDL (`db/ia_phaseN_*.sql`) + apply → classes → action handlers → pages → nav link → after-screenshots → code-reviewer + security-reviewer agents → commit (conventional message, NO self-attribution).

## Phase status
- Phase 1 Governance (`feat/ia-governance-charters`): COMPLETE — `ia_charter` table, CRUD, printable view,
  nav link, hardened upload helper (`Project/core/upload_helper.php`), `assets/js/ia.js`. Verified E2E
  (add both charter types, validation, malicious-upload rejected, MIME check, printable view). Reviewed by
  security-reviewer + code-reviewer; all CRITICAL/HIGH/MEDIUM findings fixed (upload RCE, MIME, file cleanup,
  status whitelist). Screenshots in `screenshots/phase1_charters/`.
- Phase 2 Planning (`feat/ia-strategic-annual-planning`): COMPLETE — `ia_strategic_plan`, `ia_annual_plan`,
  `ia_annual_plan_item`. Strategic Plan CRUD + print; Annual Plan CRUD + risk-based schedule (line items
  joined to real department/process/risk) + print. Verified E2E (validation, joins, cascade delete leaves
  0 orphans, zero console errors). code-reviewer run; hardening applied (date-format + year/day bounds +
  transaction cascade). Screenshots in `screenshots/phase2_planning/`.
- Phase 3 Engagement (`feat/ia-engagement-planning`): COMPLETE — hub + 6 sub-artefacts, workspace tabs, verified E2E.
- Phases 4-6: PENDING.

## Reusable assets for later phases
- `Project/core/upload_helper.php`: `ia_store_upload($fileKey,$subdir,$prefix,$allowed)`, `ia_delete_upload($relPath)`.
- `assets/js/ia.js`: add per-module AJAX handlers here (FormData for file forms; `grcSwalReload`).
- Module recipe: class in `Project/<mod>/<name>Class.php` extends BaseRepository; action files
  `Project/<name>action|update|delete.php` require `core/AuthGuard.php`; page includes `../layout/header.php`
  + `../layout/nav.php`; add nav link in `layout/nav.php` under the "Internal Audit" dropdown.
- Server-side status/enum whitelists in action handlers (mirror charter_type check).
