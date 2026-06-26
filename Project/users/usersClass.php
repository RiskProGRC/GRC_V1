<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class usersClass extends BaseRepository {

    // insert a new user row
    public function addusers(string $fname, string $sname, string $dept, string $gender, string $email, string $phone, string $uname, string $hpass, string $roles, string $user_type): string {
        $stmt = $this->prepare(
            "INSERT INTO users(fname,sname,gender,dept_id,email,phone,username,upassword,roles,user_type,access)
             VALUES(?,?,?,?,?,?,?,?,?,?,1)"
        );
        $stmt->bind_param('ssssssssss', $fname, $sname, $gender, $dept, $email, $phone, $uname, $hpass, $roles, $user_type);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "USER REGISTERED" : "DATA NOT SENT";
    }

    // return full name for a given user id (used in joins)
    public function userjoin(string $uid): string {
        $row = $this->fetchOne('users', 'id', $uid);
        if (!$row) return 'NO RECORDS FOUND';
        return $row['fname'] . ' ' . $row['sname'];
    }

    // return profile row — explicit columns exclude upassword and first_login
    public function profile(string $uid): ?array {
        $stmt = $this->prepare(
            "SELECT id, fname, sname, gender, dept_id, email, phone, username, access, roles
             FROM users WHERE id = ? AND deleted_at IS NULL LIMIT 1"
        );
        $stmt->bind_param('s', $uid);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    // insert a new permission row for a user
    public function permission(string $uid, string $add, string $edit, string $delete, string $process, string $control, string $recommend, string $rlist, string $rassess, string $rregister, string $top, string $kpi, string $kri, string $perform, string $incident, string $action, string $objective, string $report, string $card, string $rating): string {
        $stmt = $this->prepare(
            "INSERT INTO permission(uid,add_btn,edit_btn,delete_btn,process,control,recommend,rlist,rassess,rregister,top,kpi,kri,perform,incident,action,objective,report,card,rating)
             VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param(
            'ssssssssssssssssssss',
            $uid, $add, $edit, $delete, $process, $control, $recommend,
            $rlist, $rassess, $rregister, $top, $kpi, $kri, $perform,
            $incident, $action, $objective, $report, $card, $rating
        );
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "USER Permissions added" : "DATA NOT SENT";
    }

    // return all non-deleted user rows; excludes sensitive columns (upassword, first_login)
    public function fetchusers(): array {
        $stmt = $this->prepare(
            "SELECT id, fname, sname, gender, dept_id, email, phone, username, access, roles
             FROM users WHERE deleted_at IS NULL ORDER BY id ASC"
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    // return a flat array of UIDs that already have a permission row — single query replaces N accessbutton() calls
    public function fetchPermissionUids(): array {
        $stmt = $this->prepare("SELECT uid FROM permission");
        $stmt->execute();
        $rows = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return array_flip(array_column($rows, 'uid')); // keyed by uid for O(1) isset() lookup
    }

    // return permission row for a given user id
    public function fetchpermission(string $uid): ?array {
        return $this->fetchOne('permission', 'uid', $uid);
    }

    // return the uid from the permission row (used to check if permission exists)
    public function accessbutton(string $uid): mixed {
        $row = $this->fetchOne('permission', 'uid', $uid);
        return $row ? $row['uid'] : 'NO RECORDS FOUND';
    }

    // toggle access: 0→1 (activate) or 1→0 (suspend); logs the change
    public function toggleAccess(string $uid, string $adminUid, string $ip): string {
        $stmt = $this->prepare("UPDATE users SET access = 1 - access WHERE id = ?");
        $stmt->bind_param('s', $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) return 'no change';
        $row   = $this->fetchOne('users', 'id', $uid);
        $state = ($row['access'] == 1) ? 'activated' : 'suspended';
        ActivityLogger::log($this, $adminUid, 'Users', "$state user id=$uid", $ip);
        return $state;
    }

    // soft-delete: sets deleted_at; excluded from fetchusers() automatically
    public function deleteUser(string $uid, string $adminUid, string $ip): bool {
        $stmt = $this->prepare("UPDATE users SET deleted_at = NOW() WHERE id = ? AND deleted_at IS NULL");
        $stmt->bind_param('s', $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) return false;
        ActivityLogger::log($this, $adminUid, 'Users', "deleted user id=$uid", $ip);
        return true;
    }

    // force-reset password and flag first_login so user must change it
    public function adminResetPassword(string $uid, string $tempPass, string $adminUid, string $ip): string {
        $hash = password_hash($tempPass, PASSWORD_DEFAULT);
        $stmt = $this->prepare("UPDATE users SET upassword = ?, first_login = 1 WHERE id = ?");
        $stmt->bind_param('ss', $hash, $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) return 'Reset failed';
        ActivityLogger::log($this, $adminUid, 'Users', "force-reset password for user id=$uid", $ip);
        return 'Password reset. User must change on next login.';
    }

    // check username availability for the live-check endpoint
    public function usernameExists(string $uname): bool {
        return $this->fetchOne('users', 'username', $uname) !== null;
    }

    // aggregate stats for the dashboard cards on userslist.php
    public function getStats(): array {
        $stmt = $this->prepare(
            "SELECT COUNT(*) AS total,
                    COALESCE(SUM(access = 1), 0)        AS active,
                    COALESCE(SUM(access = 0), 0)        AS suspended,  /* direct count, not derived subtraction */
                    COALESCE(SUM(roles  = 1), 0)                        AS admins,
                    COALESCE(SUM(roles  = 2), 0)                        AS users
             FROM users
             WHERE deleted_at IS NULL"
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?? [];
    }

    // update permission row for a user
    public function updatepermission(string $uid, string $add, string $edit, string $delete, string $process, string $control, string $recommend, string $rlist, string $rassess, string $rregister, string $top, string $kpi, string $kri, string $perform, string $incident, string $action, string $objective, string $report, string $card, string $rating): string {
        $stmt = $this->prepare(
            "UPDATE permission SET add_btn=?,edit_btn=?,delete_btn=?,process=?,control=?,recommend=?,rlist=?,rassess=?,rregister=?,top=?,kpi=?,kri=?,perform=?,incident=?,action=?,objective=?,report=?,card=?,rating=?
             WHERE uid=?"
        );
        $stmt->bind_param(
            'ssssssssssssssssssss',
            $add, $edit, $delete, $process, $control, $recommend,
            $rlist, $rassess, $rregister, $top, $kpi, $kri, $perform,
            $incident, $action, $objective, $report, $card, $rating, $uid
        );
        $stmt->execute();
        return 'Permissions updated successfully';
    }
}
