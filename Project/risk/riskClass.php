<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class riskClass extends BaseRepository {

    // insert a new risk row
    public function addRisk(string $uid, string $ipaddress, string $name, string $rcat, string $dept, string $process, string $cause, string $consequence, string $assess, string $reviewer, string $rdate, string $nominee, string $approval): string {
        $stmt = $this->prepare(
            "INSERT INTO risk(risk_name,rcat,dept,process,cause,consequence,assessment,reviewer,rdate,nominee,userid,approval)
             VALUES(?,?,?,?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssssssss', $name, $rcat, $dept, $process, $cause, $consequence, $assess, $reviewer, $rdate, $nominee, $uid, $approval);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "could not connect";
        }
        ActivityLogger::log($this, $uid, 'Risk', 'Added risk', $ipaddress);
        return "Risk Added Successfully";
    }

    // link controls to a risk then insert the assessment row
    public function addassessment(string $uid, string $ipaddress, string $risk, string $riskdept, string $iimp, string $ilikely, array $control, string $rimp, string $rlikely, string $timp, string $tlikely): mixed {
        $cstmt = $this->prepare("INSERT INTO risk_control(dept_id,risk_id,control_id) VALUES(?,?,?)");
        $ok = true;
        foreach ($control as $cid) {
            $cstmt->bind_param('sss', $riskdept, $risk, $cid);
            $cstmt->execute();
            if ($cstmt->affected_rows < 1) {
                $ok = false;
            }
        }

        if (!$ok) {
            echo "ERROR";
            return null;
        }

        $stmt = $this->prepare(
            "INSERT INTO assessment(risk_id,iimp,ilikely,rimp,rlikely,timp,tlikely,userid)
             VALUES(?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssss', $risk, $iimp, $ilikely, $rimp, $rlikely, $timp, $tlikely, $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "could not connect";
        }

        $ustmt = $this->prepare("UPDATE risk SET assessment=1 WHERE risk_id=?");
        $ustmt->bind_param('s', $risk);
        $ustmt->execute();
        if ($ustmt->affected_rows < 1) {
            return "DID NOT UPDATE";
        }

        ActivityLogger::log($this, $uid, 'Assessment', 'Added Risk Assessment', $ipaddress);
        return "Assessment UPDATED Successfully";
    }

    // add additional risk-control links in bulk
    public function addriskcontrol(string $dept, string $rid, array $control): string {
        $stmt = $this->prepare("INSERT INTO risk_control(dept_id,risk_id,control_id) VALUES(?,?,?)");
        $ok = true;
        foreach ($control as $cid) {
            $stmt->bind_param('sss', $dept, $rid, $cid);
            $stmt->execute();
            if ($stmt->affected_rows < 1) {
                $ok = false;
            }
        }
        return $ok ? "Control Added Successfully" : "could not connect";
    }

    // update an existing assessment row
    public function updateassess(string $uid, string $ipaddress, string $raid, string $risk, string $iimp, string $ilikely, string $rimp, string $rlikely, string $timp, string $tlikely): string {
        $stmt = $this->prepare(
            "UPDATE assessment SET risk_id=?,iimp=?,ilikely=?,rimp=?,rlikely=?,timp=?,tlikely=?,userid=?
             WHERE id=?"
        );
        $stmt->bind_param('sssssssss', $risk, $iimp, $ilikely, $rimp, $rlikely, $timp, $tlikely, $uid, $raid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Assessment', "Edited Risk Assessment id=RSK0$raid", $ipaddress);
        return "Assessment UPDATED";
    }

    // return all risk rows ordered newest first
    public function showRisk(): array {
        $stmt = $this->prepare("SELECT * FROM risk ORDER BY risk_id DESC");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    // risk rows filtered by department
    public function showRiskdept(string $sdid): array {
        return $this->fetchWhere('risk', 'dept', $sdid);
    }

    // risk rows filtered by entity/department
    public function showRiskentity(string $deptid): array {
        return $this->fetchWhere('risk', 'dept', $deptid);
    }

    // total risk count for dashboard
    public function dashboard(): int {
        return $this->countAll('risk');
    }

    // count risks pending approval
    public function pendingrisks(): int {
        return $this->countWhere('risk', 'approval', '1');
    }

    // count approved risks
    public function approvedrisks(): int {
        return $this->countWhere('risk', 'approval', '2');
    }

    // count rejected/amended risks
    public function rejectedrisks(): int {
        return $this->countWhere('risk', 'approval', '3');
    }

    // return risk category distribution (result object consumed by caller)
    public function dashboardrcat(): mixed {
        $stmt = $this->prepare("SELECT rcat, COUNT(*) as count FROM risk GROUP BY rcat");
        $stmt->execute();
        return $stmt->get_result();
    }

    // risk category distribution filtered by department
    public function dashboardrcatdept(string $sdid): mixed {
        $stmt = $this->prepare("SELECT rcat, COUNT(*) as count FROM risk WHERE dept=? GROUP BY rcat");
        $stmt->bind_param('s', $sdid);
        $stmt->execute();
        return $stmt->get_result();
    }

    // return risks not yet assessed and approved
    public function showRiskassess(): array {
        $stmt = $this->prepare("SELECT * FROM risk WHERE assessment=0 AND approval=2");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    // return unassessed risks for a specific department
    public function showRiskassessdept(string $sdid): array {
        $stmt = $this->prepare("SELECT * FROM risk WHERE assessment=0 AND dept=?");
        $stmt->bind_param('s', $sdid);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    // return all assessment rows for a given id
    public function showass(string $id): array {
        return $this->fetchWhere('assessment', 'id', $id);
    }

    // accept treatment — link actions then update assessment
    public function accepttreat(string $treat, string $uid, string $ipaddress, string $id, string $apetite, array $action): mixed {
        $astmt = $this->prepare("INSERT INTO ass_action(ass_id,action,uid) VALUES(?,?,?)");
        $ok = true;
        foreach ($action as $act) {
            $astmt->bind_param('sss', $id, $act, $uid);
            $astmt->execute();
            if ($astmt->affected_rows < 1) {
                $ok = false;
            }
        }

        if (!$ok) {
            echo "DATA ERROR NOT ENTERED";
            return null;
        }

        $stmt = $this->prepare("UPDATE assessment SET treatment=?,apetite=?,ass_uid=? WHERE id=?");
        $stmt->bind_param('ssss', $treat, $apetite, $uid, $id);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DID NOT UPDATE";
        }

        ActivityLogger::log($this, $uid, 'Treatment', 'Accepted Risk Assessment', $ipaddress);
        return "treatment Successfully";
    }

    // avoid treatment — update assessment directly (no action links)
    public function avoidtreat(string $treat, string $uid, string $ipaddress, string $id, string $apetite): string {
        $stmt = $this->prepare("UPDATE assessment SET treatment=?,apetite=?,ass_uid=? WHERE id=?");
        $stmt->bind_param('ssss', $treat, $apetite, $uid, $id);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DID NOT UPDATE";
        }
        ActivityLogger::log($this, $uid, 'Treatment', 'Avoided Risk Assessment', $ipaddress);
        return "treatment Successfully";
    }

    // transfer treatment — link actions then update assessment
    public function transfertreat(string $treat, string $uid, string $ipaddress, string $id, string $apetite, array $action): mixed {
        $astmt = $this->prepare("INSERT INTO ass_action(ass_id,action,uid) VALUES(?,?,?)");
        $ok = true;
        foreach ($action as $act) {
            $astmt->bind_param('sss', $id, $act, $uid);
            $astmt->execute();
            if ($astmt->affected_rows < 1) {
                $ok = false;
            }
        }

        if (!$ok) {
            echo "DATA ERROR NOT ENTERED";
            return null;
        }

        $stmt = $this->prepare("UPDATE assessment SET treatment=?,apetite=?,ass_uid=? WHERE id=?");
        $stmt->bind_param('ssss', $treat, $apetite, $uid, $id);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DID NOT UPDATE";
        }

        ActivityLogger::log($this, $uid, 'Treatment', 'Transfer Risk Assessment', $ipaddress);
        return "treatment Successfully";
    }

    // mitigate treatment — link actions then update assessment
    public function mitigatetreat(string $treat, string $uid, string $ipaddress, string $id, string $apetite, array $action): mixed {
        $astmt = $this->prepare("INSERT INTO ass_action(ass_id,action,uid) VALUES(?,?,?)");
        $ok = true;
        foreach ($action as $act) {
            $astmt->bind_param('sss', $id, $act, $uid);
            $astmt->execute();
            if ($astmt->affected_rows < 1) {
                $ok = false;
            }
        }

        if (!$ok) {
            echo "DATA ERROR NOT ENTERED";
            return null;
        }

        $stmt = $this->prepare("UPDATE assessment SET treatment=?,apetite=?,ass_uid=? WHERE id=?");
        $stmt->bind_param('ssss', $treat, $apetite, $uid, $id);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DID NOT UPDATE";
        }

        ActivityLogger::log($this, $uid, 'Treatment', 'Mitigated Risk Assessment', $ipaddress);
        return "Treatment Successfully";
    }

    // return action rows linked to an assessment
    public function assaction(string $assid): array {
        return $this->fetchWhere('ass_action', 'ass_id', $assid);
    }

    // return full assessment list joined with risk, ordered by residual score
    public function showassessment(): array {
        $stmt = $this->prepare(
            "SELECT assessment.id,assessment.risk_id,assessment.iimp,assessment.ilikely,
                    assessment.rimp,assessment.rlikely,assessment.timp,assessment.tlikely,
                    assessment.treatment,assessment.apetite,risk.risk_name
             FROM risk
             INNER JOIN assessment ON risk.risk_id=assessment.risk_id
             ORDER BY (assessment.rimp * assessment.rlikely) DESC"
        );
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    // assessment list filtered by department, joined with risk
    public function showassessmentdept(string $sdid): array {
        $stmt = $this->prepare(
            "SELECT assessment.id,assessment.risk_id,assessment.iimp,assessment.ilikely,
                    assessment.rimp,assessment.rlikely,assessment.timp,assessment.tlikely,
                    assessment.treatment,assessment.apetite,risk.risk_name,risk.dept
             FROM risk
             INNER JOIN assessment ON risk.risk_id=assessment.risk_id
             WHERE risk.dept=?"
        );
        $stmt->bind_param('s', $sdid);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    // return all risk categories
    public function showriskcat(): array {
        return $this->fetchAll('riskcat');
    }

    // return all assessment rows for a given assessment id
    public function assesseditDetails(string $raid): array {
        return $this->fetchWhere('assessment', 'id', $raid);
    }

    // return risk name for a given risk id (used in joins)
    public function Riskjoin(string $rid): string {
        $row = $this->fetchOne('risk', 'risk_id', $rid);
        return $row ? $row['risk_name'] : 'NULL VALUES';
    }

    // return full risk row for audit view
    public function Riskaudit(string $rid): ?array {
        return $this->fetchOne('risk', 'risk_id', $rid);
    }

    // return an HTML option element for risks linked to a process
    public function fetchprocess(string $pid): string {
        $stmt = $this->prepare("SELECT risk_id, risk_name FROM risk WHERE process=?");
        $stmt->bind_param('s', $pid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 1) {
            return '<option>NO VALUES SELECTED</option>';
        }
        $option = '';
        while ($row = $result->fetch_assoc()) {
            $option .= '<option value=' . $row['risk_id'] . '>' . $row['risk_name'] . '</option>';
        }
        return $option;
    }

    // return full risk row by id
    public function fetchRisk(string $rid): ?array {
        return $this->fetchOne('risk', 'risk_id', $rid);
    }

    // return control id from assessment for a given control id
    public function fetchassess(string $cid): string {
        $row = $this->fetchOne('assessment', 'control', $cid);
        return $row ? $row['control'] : 'NULL VALUES';
    }

    // return control value from assessment for a given risk id
    public function fetchcontrol(string $rid): string {
        $row = $this->fetchOne('assessment', 'risk_id', $rid);
        return $row ? $row['control'] : 'NULL VALUES';
    }

    // return full risk row for delete confirmation
    public function fetchdelRisk(string $rid): ?array {
        return $this->fetchOne('risk', 'risk_id', $rid);
    }

    // update an existing risk row
    public function editRisk(string $rid, string $uid, string $ipaddress, string $name, string $rcat, string $dept, string $process, string $cause, string $reviewer, string $rdate, string $nominee, string $date): string {
        $stmt = $this->prepare(
            "UPDATE risk SET risk_name=?,rcat=?,dept=?,process=?,cause=?,reviewer=?,rdate=?,nominee=?,userid=?,updated_at=?
             WHERE risk_id=?"
        );
        $stmt->bind_param('sssssssssss', $name, $rcat, $dept, $process, $cause, $reviewer, $rdate, $nominee, $uid, $date, $rid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Risk', "Edited Risk id=$rid", $ipaddress);
        return "DATA SUCCESSFULLY UPDATED";
    }

    // delete a risk row only if it has no assessment
    public function deleteRisk(string $rid): string {
        $stmt = $this->prepare("DELETE FROM risk WHERE risk_id=? AND assessment=0");
        $stmt->bind_param('s', $rid);
        $stmt->execute();
        return $stmt->affected_rows > 0
            ? "RISK DELETED SUCESSFUL"
            : "DATA CANNOT DELETED BECAUSE ITS HAS ASSESSMENT";
    }

    // approve a risk
    public function approverisk(string $uid, string $rid, string $time): string {
        $stmt = $this->prepare("UPDATE risk SET approval=2, uid_approve=?,approved_at=? WHERE risk_id=?");
        $stmt->bind_param('sss', $uid, $time, $rid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Approval Success" : "NO Approval";
    }

    // reject/amend a risk
    public function rejectrisk(string $uid, string $rid, string $time): string {
        $stmt = $this->prepare("UPDATE risk SET approval=3, uid_approve=?,approved_at=? WHERE risk_id=?");
        $stmt->bind_param('sss', $uid, $time, $rid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Risk to be Ammended" : "NO Approval";
    }

    // return process id if this process has any linked risks
    public function processsearch(string $pid): string {
        $row = $this->fetchOne('risk', 'process', $pid);
        return $row ? $row['process'] : 'NO VALUES FOUND';
    }

    // return CSS button class for inherent risk score
    public function inherent(int $irass): string {
        if ($irass >= 1  && $irass <= 4)  return "btn-success";
        if ($irass > 4   && $irass <= 9)  return "btn-warning";
        if ($irass > 9   && $irass <= 16) return "btn-orange";
        if ($irass > 16  && $irass <= 25) return "btn-danger";
        return "btn-light";
    }

    // return CSS button class for residual risk score
    public function residual(int $rrass): string {
        if ($rrass >= 1  && $rrass <= 4)  return "btn-success";
        if ($rrass > 4   && $rrass <= 9)  return "btn-warning";
        if ($rrass > 9   && $rrass <= 16) return "btn-orange";
        if ($rrass > 16  && $rrass <= 25) return "btn-danger";
        return "btn-light";
    }

    // return CSS button class for target risk score
    public function target(int $trass): string {
        if ($trass >= 1  && $trass <= 4)  return "btn-success";
        if ($trass > 4   && $trass <= 9)  return "btn-warning";
        if ($trass > 9   && $trass <= 16) return "btn-orange";
        if ($trass > 16  && $trass <= 25) return "btn-danger";
        return "btn-light";
    }

    // return ordinal ranking (1–11) for a risk score value
    public function ranking(int $rass): int {
        if ($rass >= 25) return 1;
        if ($rass == 24) return 2;
        if ($rass == 23) return 3;
        if ($rass == 22) return 4;
        if ($rass == 21) return 5;
        if ($rass == 20) return 6;
        if ($rass == 19) return 7;
        if ($rass == 18) return 8;
        if ($rass == 17) return 9;
        if ($rass == 16) return 10;
        return 11;
    }
}
