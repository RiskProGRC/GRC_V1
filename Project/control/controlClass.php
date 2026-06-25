<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class controlClass extends BaseRepository {

    // insert a new control row
    public function addcontrol(string $uid, string $ipaddress, string $dept_id, string $process, string $control, string $cstrength, string $ctype, string $reviewer, string $rdate): string {
        $stmt = $this->prepare(
            "INSERT INTO control(dept_id,process_id,controls,cstrength,ctype,reviewer,rdate,userid)
             VALUES(?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssss', $dept_id, $process, $control, $cstrength, $ctype, $reviewer, $rdate, $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "COULD NOT SEND";
        }
        ActivityLogger::log($this, $uid, 'Control', 'Added Control', $ipaddress);
        return "Control Added sucessfully";
    }

    // bulk-link multiple controls to a risk (array insert loop)
    public function addriskcontrol(string $risk, array $control): void {
        $stmt = $this->prepare("INSERT INTO risk_contol(risk_id,control_id) VALUES(?,?)");
        $ok = true;
        foreach ($control as $cid) {
            $stmt->bind_param('ss', $risk, $cid);
            $stmt->execute();
            if ($stmt->affected_rows < 1) {
                $ok = false;
            }
        }
        echo $ok ? "UPDATED" : "ERROR";
    }

    // render bullet-point text as an HTML list
    public function paragraph(string $text): void {
        $lines = str_replace("•", "<li>", $text);
        echo "<ul>";
        echo $lines;
        echo "<ul>";
    }

    // return all control rows ordered by newest first
    public function showcontrol(): array {
        $stmt = $this->prepare("SELECT * FROM control ORDER BY control_id DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    // return approved control rows (approval=2)
    public function showcontrolass(): array {
        return $this->fetchWhere('control', 'approval', '2');
    }

    // return control text for a given control id (used in joins)
    public function joincontrol(string $cid): string {
        $row = $this->fetchOne('control', 'control_id', $cid);
        return $row ? $row['controls'] : '';
    }

    // return control strength id for a given control id
    public function fetchcstrength(string $cid): string {
        $row = $this->fetchOne('control', 'control_id', $cid);
        return $row ? $row['cstrength'] : '';
    }

    // return control type id for a given control id
    public function fetchctype(string $cid): string {
        $row = $this->fetchOne('control', 'control_id', $cid);
        return $row ? $row['ctype'] : '';
    }

    // return reviewer id for a given control id
    public function fetchreviewer(string $cid): string {
        $row = $this->fetchOne('control', 'control_id', $cid);
        return $row ? $row['reviewer'] : '';
    }

    // control rows filtered by department
    public function showcontroldept(string $sdid): array {
        return $this->fetchWhere('control', 'dept_id', $sdid);
    }

    // control rows filtered by entity/department
    public function showcontrolentity(string $deptid): array {
        return $this->fetchWhere('control', 'dept_id', $deptid);
    }

    // risk_control rows filtered by department
    public function showriskcontrol(string $deptid): array {
        return $this->fetchWhere('risk_control', 'dept_id', $deptid);
    }

    // active risk_control links for a given risk (status=1 only)
    public function joinriskcontrol(string $rid): array {
        $stmt = $this->prepare("SELECT * FROM risk_control WHERE risk_id=? AND status=1");
        $stmt->bind_param('s', $rid);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    // soft-delete a risk-control link (set status=0)
    public function updateriskcontrol(string $cid, string $rid): string {
        $stmt = $this->prepare("UPDATE risk_control SET status=0 WHERE risk_id=? AND control_id=?");
        $stmt->bind_param('ss', $rid, $cid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Control Deleted" : "COULD NOT SEND";
    }

    // return all risk_control links for a given risk
    public function joinrcontrol(string $raid): array {
        return $this->fetchWhere('risk_control', 'risk_id', $raid);
    }

    // total control count for dashboard
    public function dashboard(): int {
        return $this->countAll('control');
    }

    // return control strength distribution (result object consumed by caller)
    public function dashboardcstrength(): mixed {
        $stmt = $this->prepare("SELECT cstrength, COUNT(*) as count FROM control GROUP BY cstrength");
        $stmt->execute();
        return $stmt->get_result();
    }

    // control strength distribution filtered by department
    public function dashboardcstrengthdept(string $sdid): mixed {
        $stmt = $this->prepare(
            "SELECT cstrength, COUNT(*) as count FROM control WHERE dept_id=? GROUP BY cstrength"
        );
        $stmt->bind_param('s', $sdid);
        $stmt->execute();
        return $stmt->get_result();
    }

    // return risk id linked to a control row
    public function fetchrisk(string $rid): string {
        $row = $this->fetchOne('control', 'risk', $rid);
        return $row ? $row['risk'] : 'NO ROW ADDED';
    }

    // return full control row for detail view
    public function fetchcdetails(string $cid): ?array {
        return $this->fetchOne('control', 'control_id', $cid);
    }

    // return impact and likelihood from control_strength joined to control
    public function fetchcontrol(string $cid): ?array {
        $stmt = $this->prepare(
            "SELECT control_strength.impact, control_strength.likelihood
             FROM control
             INNER JOIN control_strength ON control.cstrength=control_strength.strength_id
             WHERE control_id=?"
        );
        $stmt->bind_param('s', $cid);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc() ?: null;
    }

    // update an existing control row
    public function updatecontrol(string $cid, string $uid, string $ipaddress, string $process, string $control, string $cstrength, string $ctype, string $reviewer, string $rdate, string $date): string {
        $stmt = $this->prepare(
            "UPDATE control SET process_id=?,controls=?,cstrength=?,ctype=?,reviewer=?,rdate=?,userid=?,updated_at=?
             WHERE control_id=?"
        );
        $stmt->bind_param('sssssssss', $process, $control, $cstrength, $ctype, $reviewer, $rdate, $uid, $date, $cid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Controls', "Edited Control id=CTRL0$cid", $ipaddress);
        return "Control Updated Successfully";
    }

    // delete a control row
    public function deletecontrol(string $cid): string {
        return $this->deleteById('control', 'control_id', $cid)
            ? "Control Deleted SUCESSFUL"
            : "DATA CANNOT DELETED";
    }

    // count controls pending approval
    public function pendingcontlr(): int {
        return $this->countWhere('control', 'approval', '1');
    }

    // count approved controls
    public function approvedcontlr(): int {
        return $this->countWhere('control', 'approval', '2');
    }

    // approve a control
    public function approvecontrol(string $uid, string $cid, string $time): string {
        $stmt = $this->prepare("UPDATE control SET approval=2, uid_approve=?,approved_at=? WHERE control_id=?");
        $stmt->bind_param('sss', $uid, $time, $cid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Approval Success" : "NO Approval";
    }

    // send control back for amendment
    public function ammendcontrol(string $uid, string $cid, string $time): string {
        $stmt = $this->prepare("UPDATE control SET approval=3, uid_approve=?,approved_at=? WHERE control_id=?");
        $stmt->bind_param('sss', $uid, $time, $cid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Ammend Control" : "NO Approval";
    }
}
