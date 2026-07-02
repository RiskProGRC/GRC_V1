# PSASB Internal Audit Compliance — Gap Analysis

**Source of requirements:** https://psasb.go.ke/internal-audit-templates-and-manuals/
**App under review:** GRC_V1 (plain PHP + MySQL `risk_pro_grc`, 231 PHP files, 50 DB tables)
**Date:** 2026-07-02

## Method (no guesswork — evidence-based)
- Fetched the full PSASB template inventory: **32 templates in 6 categories**.
- Extracted all 50 DB tables from `db/grc.sql`.
- Grepped every `.php` file for references to audit-domain tables.
- Read `layout/nav.php` to enumerate every module actually exposed in the UI.

## Key finding
The app is a **Risk/GRC** system (risk register, controls, incidents, KRIs/KPIs, recommendations,
entities). The DB contains **dormant/orphaned audit tables** — `audit`, `auditprog`, `audit_rating`,
`findings`, `meeting`, `mngtletter`, `nletter`, `letterupload`, `pubaccount` — but **zero PHP files
reference any of them**, and **`nav.php` exposes no internal-audit menu**. Therefore the entire
PSASB internal-audit engagement lifecycle is **not implemented** in UI/logic.

Legend: ❌ Missing · 🟡 Partial/adjacent feature exists · 🟥 Orphan stub table exists (no UI/logic)

| # | PSASB Template | Status | Evidence / Nearest existing asset |
|---|----------------|--------|-----------------------------------|
| **Group 1 — Governance & Charter** |
| 1 | Model Audit Committee Charter | ❌ | none |
| 2 | Model Internal Audit Charter | ❌ | none |
| **Group 2 — Strategic & Annual Planning** |
| 3 | Internal Audit Strategic Plan | ❌ | none |
| 4 | Internal Audit Plan (annual, risk-based) | 🟡 | risk register (`risk`,`assessment`) can feed a risk-based plan; no plan module |
| **Group 3 — Engagement Planning** |
| 5 | Ethics & Professionalism Acknowledgement Form | ❌ | none |
| 6 | Coordination & Reliance Framework | ❌ | none |
| 7 | Audit Notification | 🟥 | orphan `nletter` (subject/entity/dates/owner/description) — no UI |
| 8 | Engagement Plan | 🟥 | orphan `auditprog` (milestone dates) — no UI |
| 9 | Internal Audit Planning Memorandum | ❌ | none |
| 10 | Request for Audit Information | ❌ | none |
| 11 | Information Request Monitoring Checklist | ❌ | none |
| 12 | Business Process Analysis Form | 🟡 | `process`/`dept_process` modules exist (not audit BPA) |
| 13 | Sample Engagement Audit Program | 🟥 | orphan `auditprog` — no UI |
| **Group 4 — Fieldwork & Documentation** |
| 14 | Entrance Meeting Agenda | 🟥 | orphan `meeting` (participant/requirement/date) — no UI |
| 15 | Entrance Meeting Minutes | 🟥 | orphan `meeting` — no UI |
| 16 | Exit Meeting Agenda | 🟥 | orphan `meeting` — no UI |
| 17 | Exit Meeting Minutes | 🟥 | orphan `meeting` — no UI |
| 18 | Workpaper Template | 🟥 | orphan `letterupload` (file uploads) — no UI |
| 19 | Draft Finding Sheet | 🟥 | orphan `audit` (finding/recommend/rating) — no UI |
| 20 | Findings Database | 🟥 | orphan `findings` (yearly count aggregate only) — no UI |
| 21 | Workpaper File Checklist | ❌ | none |
| 22 | Review Notes | ❌ | none |
| **Group 5 — Reporting** |
| 23 | Internal Audit Final Report | 🟥 | orphan `mngtletter` — no UI |
| 24 | Action Plan Reporting | 🟡 | `recommend`,`action` modules exist (risk-side, not audit engagement) |
| 25 | Internal Audit Quarterly Report | ❌ | none |
| 26 | Internal Audit Annual Report | ❌ | none |
| **Group 6 — Quality Assurance & Performance** |
| 27 | Audit Client Satisfaction Survey | ❌ | none |
| 28 | Periodic Audit Committee Survey | ❌ | none |
| 29 | Periodic Senior Management Survey | ❌ | none |
| 30 | Periodic Internal Audit Staff Survey | ❌ | none |
| 31 | Performance Measurement Matrix | 🟡 | `passess_fin`/`pkra`/`pkpi` (staff KPIs, not IA PMM) |
| 32 | External Assessors TOR | ❌ | none |

**Score: 0 / 32 implemented.** 8 have dormant stub tables; 4 have adjacent risk-side features that
are not the audit-engagement artefact PSASB defines.

## Proposed phased implementation (each phase = its own stacked git branch)
Branches stack sequentially per workflow rule (each forks from the previous phase tip):
- **Phase 1** `feat/ia-governance-charters` — Templates 1–2
- **Phase 2** `feat/ia-strategic-annual-planning` — Templates 3–4
- **Phase 3** `feat/ia-engagement-planning` — Templates 5–13
- **Phase 4** `feat/ia-fieldwork-workpapers` — Templates 14–22
- **Phase 5** `feat/ia-reporting` — Templates 23–26
- **Phase 6** `feat/ia-quality-assurance` — Templates 27–32

Each phase: DB migration → module code (list/add/action/edit/delete following existing app
convention) → `nav.php` menu wiring → permissions → before/after Playwright screenshots on
`:8020` → agent review (code-reviewer, security-reviewer) → commit.
