<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class kiClass extends BaseRepository {

    // insert a new key indicator row
    public function addkeyindicator(string $dept_id, string $uid, string $ipaddress, string $processid, string $risk, string $ki, string $owner): string {
        $stmt = $this->prepare(
            "INSERT INTO ki(dept_id,process_id,risk_id,ki,owner) VALUES(?,?,?,?,?)"
        );
        $stmt->bind_param('sssss', $dept_id, $processid, $risk, $ki, $owner);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT ENTERED";
        }
        ActivityLogger::log($this, $uid, 'Key Indicator', 'Added Key indicator', $ipaddress);
        return "KPI Added Successfully";
    }

    // return the ki text for a given id (used in joins)
    public function kpiJoins(string $kpiid): string {
        $row = $this->fetchOne('ki', 'id', $kpiid);
        return $row ? $row['ki'] : 'NO VALUES FOUND';
    }

    // return ki + risk join row for dashboard display
    public function kpidashboard(string $kpiid): mixed {
        $stmt = $this->prepare(
            "SELECT ki.id,ki.risk_id,risk.risk_name,risk.rcat
             FROM ki
             INNER JOIN risk ON ki.risk_id=risk.risk_id
             WHERE ki.id=?"
        );
        $stmt->bind_param('s', $kpiid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 1) {
            return "NO RECORDS FOUND";
        }
        return $result->fetch_assoc();
    }

    // return all ki rows
    public function showKi(): array {
        return $this->fetchAll('ki');
    }

    // return approved ki rows (approval=2)
    public function showKiappr(): array {
        return $this->fetchWhere('ki', 'approval', '2');
    }

    // total ki count for dashboard
    public function dashboard(): int {
        return $this->countAll('ki');
    }

    // ki rows filtered by department
    public function showKidept(string $sdid): array {
        return $this->fetchWhere('ki', 'dept_id', $sdid);
    }

    // ki rows filtered by entity (alias of showKidept)
    public function showKientity(string $deptid): array {
        return $this->fetchWhere('ki', 'dept_id', $deptid);
    }

    // return process name for a given process id (used in ki listing joins)
    public function processJoins(string $pid): string {
        $row = $this->fetchOne('process', 'process_id', $pid);
        return $row ? $row['process_name'] : 'NO VALUES FOUND';
    }

    // return full ki row for edit form
    public function fetchedit(string $kiid): ?array {
        return $this->fetchOne('ki', 'id', $kiid);
    }

    // update an existing ki row
    public function update(string $uid, string $ipaddress, string $kiid, string $process, string $risk, string $ki, string $owner, string $date): string {
        $stmt = $this->prepare(
            "UPDATE ki SET process_id=?,risk_id=?,ki=?,owner=?,uid=?,updated_at=? WHERE id=?"
        );
        $stmt->bind_param('sssssss', $process, $risk, $ki, $owner, $uid, $date, $kiid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Key Indicator', "Edited Key indicator id=KI00$kiid", $ipaddress);
        return "KPI Updated Sucessfully";
    }

    // delete a ki row
    public function deleteki(string $kiid): string {
        return $this->deleteById('ki', 'id', $kiid)
            ? "KI Deleted Sucessfully"
            : "DATA CANNOT DELETED BECAUSE ITS HAS ASSESSMENT";
    }

    // count ki rows pending approval
    public function pendingki(): int {
        return $this->countWhere('ki', 'approval', '1');
    }

    // count approved ki rows
    public function approvedki(): int {
        return $this->countWhere('ki', 'approval', '2');
    }

    // approve a ki row
    public function approveki(string $uid, string $kiid, string $time): string {
        $stmt = $this->prepare("UPDATE ki SET approval=2, uid_approve=?,approved_at=? WHERE id=?");
        $stmt->bind_param('sss', $uid, $time, $kiid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Approval Success" : "NO Approval";
    }

    // send ki back for amendment
    public function ammendki(string $uid, string $kiid, string $time): string {
        $stmt = $this->prepare("UPDATE ki SET approval=3, uid_approve=?,approved_at=? WHERE id=?");
        $stmt->bind_param('sss', $uid, $time, $kiid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Ammend Control" : "NO Approval";
    }
}
