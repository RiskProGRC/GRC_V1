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
- Phase 1 Governance (`feat/ia-governance-charters`): IN PROGRESS
- Phases 2-6: PENDING (see tasks / architecture doc for table + file lists)
