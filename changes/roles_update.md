# Role System Redesign — Session Notes

**Date:** 2026-06-30  
**Branch:** main  
**Files changed:** 5

---

## Background

The system previously used two access-control layers:

1. **Role layer** (`users.roles`) — `1` = Administrator, `2` = User  
2. **Permission layer** (`permission` table) — 19 boolean columns per user controlling individual nav menu items

The permission table drove nav visibility via `$access[]` checks in `nav.php`. This was replaced with a simpler 3-role system.

---

## New Role Definitions

| Value | Label | Status |
|---|---|---|
| 1 | Administrator | Unchanged |
| 2 | Champion | Renamed from "User" |
| 3 | Manager | New |

No database migration needed — values 1 and 2 are unchanged; 3 is a new integer stored in `users.roles`.

---

## Role Matrix — Nav Visibility

| Menu Item | Admin (1) | Manager (3) | Champion (2) |
|---|---|---|---|
| Dashboard | All depts | Own dept only | Own dept only |
| Overview | All depts | Own dept only | Own dept only |
| Inbox | Yes | Yes — own dept | Hidden |
| Risk Tracker | All depts | Own dept only | Own dept only |
| — Add Entity | Yes | Hidden | Hidden |
| Risks | All depts | Own dept only | Own dept only |
| Risk Treatment | All depts | Own dept only | Own dept only |
| Controls Lib. | All depts | Own dept only | Own dept only |
| Risk Monitor | All depts | Own dept only | Own dept only |
| Recommendations | All depts | Own dept only | Own dept only |
| Notifications | Removed | Removed | Removed |
| Settings | Full | Partial | Hidden |
| — User Management | Yes | Hidden | Hidden |
| — Impact / Likelihood / Category / Strength / Type | Yes | Yes | Hidden |
| — Activity Logs | Yes | Hidden | Hidden |

> **Dept scoping** is handled in `header.php` data fetching — not in nav visibility. The nav item is shown; the data behind it is already filtered by `$sdid`.

---

## Files Changed

### 1. `Project/profile.php`
- Roles dropdown: renamed `User` → `Champion`, added `Manager` (value `3`)
- Removed "Add/Edit Permissions" button
- Removed entire permissions modal (was ~230 lines)
- Removed dead variables: `$permSet`, `$hasPermRow`, `$perms`

### 2. `Project/userslist.php`
- Removed `fetchPermissionUids()` call
- Removed `$permBtn` variable and the Permission link from the Actions column

### 3. `layout/header.php`
- All 11 data-fetch blocks changed from:
  ```php
  if($sess_roles==1){ ... }elseif($sess_roles==2){ ... }
  ```
  to:
  ```php
  if($sess_roles==1){ ... }else{ ... }
  ```
- Manager (3) now gets the same dept-scoped data as Champion (2)
- Affected blocks: Department, Process, Risk, Risk Category, Control, Control Strength, KI, Action, Incident, Recommend, KRI

### 4. `layout/nav.php`
- Removed `$access = $userclass->fetchpermission($uid) ?? []` (no longer needed)
- Inbox guard: `$sess_roles == 1` → `$sess_roles == 1 || $sess_roles == 3`
- Removed `$access[]` outer guard on: Risks, Risk Treatment, Controls Lib., Risk Monitor, Recommendations
- Removed all `$access[]` inner guards within Risks and Risk Monitor submenus
- Settings guard: `$sess_roles == 1` → `$sess_roles == 1 || $sess_roles == 3`
- Added inner `$sess_roles == 1` guard on User Management and Activity Logs within Settings
- Removed Notifications menu item entirely

### 5. `layout/footer.php`
- Removed old permission-based role block that was disabling `btn-userpermission-*` buttons via inline CSS and jQuery (~28 lines removed)

---

## What Was NOT Changed

- `permission` table in the database — left intact, no SQL changes
- `usersClass.php` permission methods (`fetchpermission`, `permission`, `updatepermission`, `fetchPermissionUids`) — left in place
- `permissions.php`, `permissionaction.php`, `permissionedit.php` — left in place (orphaned but harmless)
- `AuthGuard.php` and all handler security — unchanged

---

## Key Design Decisions

- **Manager sees Settings but not User Management or Activity Logs** — prevents managers from editing users or viewing audit trails
- **All menus visible to all 3 roles** (except Inbox, Settings, Notifications) — dept scoping in `header.php` handles data restriction, not the nav
- **`else` instead of `elseif($sess_roles==3)`** in header.php — any future role added will safely default to dept-scoped data
- **Notifications removed from nav entirely** — not needed for any role
