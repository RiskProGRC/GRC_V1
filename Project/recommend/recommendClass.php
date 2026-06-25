<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class recommendClass extends BaseRepository {

    // insert a new recommendation row
    public function addrecommend(string $uid, string $ipaddress, string $dept, string $process, string $risk, string $mrc, string $armc, string $action, string $status, string $timeline): string {
        $stmt = $this->prepare(
            "INSERT INTO recommend(dept_id,process_id,risk_id,mrc,armc,action,status,timeline,uid)
             VALUES(?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('sssssssss', $dept, $process, $risk, $mrc, $armc, $action, $status, $timeline, $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT ENTERED";
        }
        ActivityLogger::log($this, $uid, 'Recommendation', 'Added Recommendation', $ipaddress);
        return "Recommendation Added";
    }

    // return all recommendation rows
    public function showrecommend(): array {
        return $this->fetchAll('recommend');
    }

    // recommendations filtered by department
    public function showrecommenddept(string $sdid): array {
        return $this->fetchWhere('recommend', 'dept_id', $sdid);
    }

    // recommendations linked to a specific risk
    public function joinriskrecommend(string $rid): array {
        return $this->fetchWhere('recommend', 'risk_id', $rid);
    }

    // recommendations filtered by entity/department (alias of showrecommenddept)
    public function showrecommendentity(string $deptid): array {
        return $this->fetchWhere('recommend', 'dept_id', $deptid);
    }

    // total recommendation count for dashboard
    public function dashboard(): int {
        return $this->countAll('recommend');
    }

    // return process name for a given process id (used in listing joins)
    public function processJoins(string $pid): string {
        $row = $this->fetchOne('process', 'process_id', $pid);
        return $row ? $row['process_name'] : 'NO VALUES FOUND';
    }

    // return first recommend row for a given risk_id (used in joins)
    public function recommendJoins(string $rid): mixed {
        $row = $this->fetchOne('recommend', 'risk_id', $rid);
        return $row ? ($row['process_name'] ?? 'NO VALUES FOUND') : 'NO VALUES FOUND';
    }

    // return action value for a given action id on a recommend row
    public function fetchactionrecommend(string $aid): string {
        $row = $this->fetchOne('recommend', 'action', $aid);
        return $row ? $row['action'] : 'NULL VALUES';
    }

    // return full recommend row for edit form
    public function editDetails(string $rid): ?array {
        return $this->fetchOne('recommend', 'id', $rid);
    }

    // update an existing recommendation row
    public function update(string $uid, string $ipaddress, string $rid, string $process, string $risk, string $mrc, string $armc, string $action, string $status, string $timeline, string $date): string {
        $stmt = $this->prepare(
            "UPDATE recommend SET process_id=?,risk_id=?,mrc=?,armc=?,action=?,status=?,timeline=?,uid=?,updated_at=?
             WHERE id=?"
        );
        $stmt->bind_param('ssssssssss', $process, $risk, $mrc, $armc, $action, $status, $timeline, $uid, $date, $rid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Recommendation', "Edited Recommendation id=RMD00$rid", $ipaddress);
        return "Recommendation Updated";
    }

    // return full recommend row for delete confirmation (same as editDetails)
    public function recdelupdate(string $rid): ?array {
        return $this->fetchOne('recommend', 'id', $rid);
    }

    // delete a recommendation row
    public function delete(string $rid): string {
        return $this->deleteById('recommend', 'id', $rid)
            ? "Recommendation Deleted"
            : "DATA CANNOT DELETED BECAUSE ITS HAS ASSESSMENT";
    }

    // count recommendations pending approval
    public function pendingrecommend(): int {
        return $this->countWhere('recommend', 'approval', '1');
    }

    // count approved recommendations
    public function approvedrecommend(): int {
        return $this->countWhere('recommend', 'approval', '2');
    }

    // approve a recommendation
    public function approverecommend(string $uid, string $rid, string $time): string {
        $stmt = $this->prepare("UPDATE recommend SET approval=2, uid_approve=?,approved_at=? WHERE id=?");
        $stmt->bind_param('sss', $uid, $time, $rid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Approval Success" : "NO Approval";
    }

    // send recommendation back for amendment
    public function ammendrecommend(string $uid, string $rid, string $time): string {
        $stmt = $this->prepare("UPDATE recommend SET approval=3, uid_approve=?,approved_at=? WHERE id=?");
        $stmt->bind_param('sss', $uid, $time, $rid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Ammend Control" : "NO Approval";
    }
}
