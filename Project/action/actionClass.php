<?php
require_once __DIR__ . '/../core/BaseRepository.php'; // pulls in connectionClass + ActivityLogger

class actionClass extends BaseRepository {

    // insert a new action row
    public function addaction(string $uid, string $ipaddress, string $dept_id, string $process, string $risk, string $action, string $status, string $priority, string $timeline): string {
        $stmt = $this->prepare(
            "INSERT INTO action(process_id,dept_id,risk_id,action,status,priority,timeline,uid)
             VALUES(?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssss', $process, $dept_id, $risk, $action, $status, $priority, $timeline, $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT ENTERED";
        }
        ActivityLogger::log($this, $uid, 'Action', 'Added Action', $ipaddress);
        return "Action Added Successfully";
    }

    // return all action rows
    public function showaction(): array {
        return $this->fetchAll('action');
    }

    // total action count for dashboard
    public function dashboard(): int {
        return $this->countAll('action');
    }

    // actions filtered by department
    public function showactiondept(string $sdid): array {
        return $this->fetchWhere('action', 'dept_id', $sdid);
    }

    // return the action id linked to a risk (used in joins)
    public function showactionrisk(string $rid): mixed {
        $row = $this->fetchOne('action', 'risk_id', $rid);
        if (!$row) return "NO RECORDS FOUND";
        return $row['id'];
    }

    // actions filtered by entity/department
    public function showactionentity(string $deptid): array {
        return $this->fetchWhere('action', 'dept_id', $deptid);
    }

    // return the action text for a given action id (used in joins)
    public function actionJoins(string $aid): string {
        $row = $this->fetchOne('action', 'id', $aid);
        return $row ? $row['action'] : '';
    }

    // return full action row for edit form
    public function fetchaction(string $aid): ?array {
        return $this->fetchOne('action', 'id', $aid);
    }

    // update an existing action row
    public function updateaction(string $uid, string $ipaddress, string $cid, string $process, string $risk, string $action, string $status, string $priority, string $timeline, string $date): string {
        $stmt = $this->prepare(
            "UPDATE action SET process_id=?,risk_id=?,action=?,status=?,priority=?,timeline=?,uid=?,updated_at=?
             WHERE id=?"
        );
        $stmt->bind_param('sssssssss', $process, $risk, $action, $status, $priority, $timeline, $uid, $date, $cid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Action', "Edited Action id=ACT0$cid", $ipaddress);
        return "Action UPDATED";
    }

    // delete an action row
    public function deleteaction(string $aid): string {
        return $this->deleteById('action', 'id', $aid)
            ? "DATA DELETED SUCESSFUL"
            : "DATA CANNOT DELETED BECAUSE ITS HAS ASSESSMENT";
    }

    // return a CSS class based on days overdue
    public function audit(int $days): string {
        if ($days <= 0) return "success";
        return "danger";
    }

    // count actions pending approval
    public function pendingaction(): int {
        return $this->countWhere('action', 'approval', '1');
    }

    // count approved actions
    public function approvedaction(): int {
        return $this->countWhere('action', 'approval', '2');
    }

    // approve an action
    public function approveaction(string $uid, string $aid, string $time): string {
        $stmt = $this->prepare("UPDATE action SET approval=2, uid_approve=?,approved_at=? WHERE id=?");
        $stmt->bind_param('sss', $uid, $time, $aid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Approval Success" : "NO Approval";
    }

    // send action back for amendment
    public function ammendaction(string $uid, string $aid, string $time): string {
        $stmt = $this->prepare("UPDATE action SET approval=3, uid_approve=?,approved_at=? WHERE id=?");
        $stmt->bind_param('sss', $uid, $time, $aid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Ammend Action" : "NO Approval";
    }
}   
