# GRC V1 — Permissions & Bug Fixes Session
**Date:** 2026-07-01

---

## Overview

This session implemented role-based button disabling across 10 pages, fixed several missing/wrong permission classes, resolved a fatal error in `entitylist.php`, removed an export button, and fixed a broken icon.

---

## 1. Role-Based Button Disabling — Approach

All pages use the same **CSS body-class technique**:

- PHP checks `$sess_roles` (set by `header.php`) and adds `role-readonly` to `<body>` when role is `1` or `3`.
- An inline `<style>` block on each page disables matching buttons via CSS.

```php
<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
```

```css
.role-readonly .btn-userpermission-edit,
.role-readonly .btn-userpermission-delete,
.role-readonly .btn-userpermission-add {
    opacity: 0.4;
    pointer-events: none;
    cursor: not-allowed;
}
```

**Why this approach:**
- DataTable-safe — CSS on `<body>` re-applies automatically after table redraws during search/pagination.
- No JavaScript required.
- One consistent pattern across all pages.

---

## 2. Role Access Matrix

| Role | Name              | Add      | Edit     | Delete   |
|------|-------------------|----------|----------|----------|
| `1`  | Risk Owner / Admin | Disabled | Disabled | Disabled |
| `2`  | Risk Champion     | Enabled  | Enabled  | Enabled  |
| `3`  | View-Only         | Disabled | Disabled | Disabled |

---

## 3. Files Changed

### Phase 1 — Initial 7 Pages

| File | Change |
|------|--------|
| `Project/bussinf.php` | Added `role-readonly` CSS to existing `<style>` block; body class PHP check |
| `Project/risklist.php` | Body class + inline `<style>`; fixed missing `btn-userpermission-edit` on `.edit-risk` button |
| `Project/riskassess.php` | Body class + inline `<style>` |
| `Project/kra_settings.php` | Body class + inline `<style>` |
| `Project/incidents.php` | Body class + inline `<style>` |
| `Project/actions.php` | Body class + inline `<style>`; fixed missing `btn-userpermission-edit` on `.editactionbtn` |
| `Project/recommendations.php` | Body class + inline `<style>`; Export button and `<form>` wrapper removed |

### Phase 2 — riskassess Button Class Fixes

Three buttons in `riskassess.php` had wrong or missing permission classes:

| Button | Before | After |
|--------|--------|-------|
| Edit (pencil) | `userpermission-edit` | `btn-userpermission-edit` |
| Delete (trash) | *(no class)* | `btn-userpermission-delete` |
| Edit control | `userpermission-control` | `btn-userpermission-edit` |

### Phase 3 — 3 Additional Pages

| File | Change |
|------|--------|
| `Project/risktreatment.php` | Body class + inline `<style>`; added `btn-userpermission-treatment` to Treatment dropdown — prevents dropdown from opening for roles 1 & 3 |
| `Project/kri.php` | Body class + inline `<style>`; added `btn-userpermission-edit` to Update button; added `btn-userpermission-history` to History button |
| `Project/controls.php` | Body class + inline `<style>`; added missing `btn-userpermission-edit` to `.editcontrol-btn` (add & delete already had classes) |

---

## 4. Button Class Convention

| Class | Controls | Pages |
|-------|----------|-------|
| `btn-userpermission-add` | Add / New record buttons | All 10 pages |
| `btn-userpermission-edit` | Edit, Update, Edit Control buttons | All 10 pages |
| `btn-userpermission-delete` | Delete / Trash buttons | All 10 pages |
| `btn-userpermission-treatment` | Treatment strategy dropdown toggle | `risktreatment.php` |
| `btn-userpermission-history` | History view button | `kri.php` |

> Any future button that should respect role permissions must carry the relevant `btn-userpermission-*` class — the body CSS handles the rest automatically.

---

## 5. Bug Fixes

### entitylist.php — Fatal Error on Line 59–60

**Error:**
```
Warning: Undefined array key "owner" in entitylist.php on line 59
Fatal error: Uncaught TypeError: usersClass::userjoin(): Argument #1 ($uid)
must be of type string, null given
```

**Root cause:**
- Wrong array key `"owner"` — database column is `"owners"` (confirmed in `bussinf.php` line 333).
- No null guard before passing the value to `userjoin(string $uid)`.

**Fix:**
```php
// Before
$uid = $dept["owner"];
$username = $userclass->userjoin($uid);

// After
$uid = $dept["owners"] ?? '';
$username = $uid ? $userclass->userjoin((string)$uid) : 'N/A';
```

---

### entitylist.php — Broken Icon on Create Entity Button

**Problem:** The button contained a garbled icon `<span class="fa-fw select-all fas">ï•</span>` (corrupted unicode bytes `0x3F 0x3F 0x3F`) and a stray `</a>` tag.

**Fix:**
```html
<!-- Before -->
<span class="fa-fw select-all fas">ï•</span>Create Entity</a></button>

<!-- After -->
<i class="fas fa-fw fa-plus"></i> Create Entity</button>
```

---

### recommendations.php — Export Button Removed

Removed the EXPORT button, its wrapping `<form action="export.php">`, hidden `file_content` input, and the commented-out old anchor link. The Add Recommendation button was left untouched.

---

## 6. Changes Report Files

| File | Description |
|------|-------------|
| `changes/permissions.html` | Full visual report of all permission changes |
| `changes/index.html` | Updated — Permissions section added (13 sections, 31 reports) |

---

## Summary

- **10 pages** updated with role-based button disabling
- **2 roles** restricted (1 and 3)
- **5 button types** controlled via permission classes
- **7 missing/wrong classes** fixed across multiple files
- **2 bugs** fixed in `entitylist.php` (wrong key + fatal type error)
- **1 broken icon** fixed on Create Entity button
- **1 export button** removed from `recommendations.php`
