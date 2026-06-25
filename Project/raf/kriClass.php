<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class kriClass extends BaseRepository {

    // insert a new KRI parameter row
    public function addkriparameter(string $uid, string $ipaddress, string $pname, string $rlimit, string $fmngt, string $tmngt, string $fboard, string $tboard, string $fmboard, string $tmboard, string $pdesc, string $dept): string {
        $stmt = $this->prepare(
            "INSERT INTO kri_parameter(pname,rlimit,fmngt,tmngt,fboard,tboard,fmboard,tmboard,pdesc,dept_id)
             VALUES(?,?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssssss', $pname, $rlimit, $fmngt, $tmngt, $fboard, $tboard, $fmboard, $tmboard, $pdesc, $dept);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "No values entered";
        }
        ActivityLogger::log($this, $uid, 'KRI', 'Added KRI', $ipaddress);
        return "Parameter Added successfully";
    }

    // update an existing KRI parameter row
    public function updateparameter(string $uid, string $ipaddress, string $pid, string $pname, string $apetite, string $type, string $rlimit, string $fmngt, string $tmngt, string $fboard, string $tboard, string $fmboard, string $tmboard): string {
        $stmt = $this->prepare(
            "UPDATE kri_parameter SET pname=?,apetite=?,type=?,rlimit=?,fmngt=?,tmngt=?,fboard=?,tboard=?,fmboard=?,tmboard=?
             WHERE id=?"
        );
        $stmt->bind_param('sssssssssss', $pname, $apetite, $type, $rlimit, $fmngt, $tmngt, $fboard, $tboard, $fmboard, $tmboard, $pid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "No values entered";
        }
        ActivityLogger::log($this, $uid, 'KRI', "Edited Kri id=$pid", $ipaddress);
        return "Parameter Updated successfully";
    }

    // return all KRI parameter rows
    public function fetchkriparameter(): array {
        return $this->fetchAll('kri_parameter');
    }

    // KRI parameter rows filtered by department
    public function fetchkriparameterdept(string $sdid): array {
        return $this->fetchWhere('kri_parameter', 'dept_id', $sdid);
    }

    // return full KRI parameter row by id
    public function fetchparameterid(string $pid): ?array {
        return $this->fetchOne('kri_parameter', 'id', $pid);
    }

    // return kri text for a given kri row id
    public function fetchkriname(string $kid): string {
        $row = $this->fetchOne('kri', 'id', $kid);
        return $row ? $row['kri'] : 'No values found';
    }

    // return parameter name for a given kri_parameter id
    public function fetchparameter(string $kid): string {
        $row = $this->fetchOne('kri_parameter', 'id', $kid);
        return $row ? $row['pname'] : 'No values found';
    }

    // return management range string (fmngt – tmngt) for a parameter
    public function fetchmngt(string $kid): string {
        $row = $this->fetchOne('kri_parameter', 'id', $kid);
        return $row ? $row['fmngt'] . '&nbsp; - &nbsp;' . $row['tmngt'] : 'No values found';
    }

    // return all kri_parameter rows (alias of fetchkriparameter for performance page)
    public function performance(): array {
        return $this->fetchAll('kri_parameter');
    }

    // return board range string (fboard – tboard) for a parameter
    public function fetchboard(string $kid): string {
        $row = $this->fetchOne('kri_parameter', 'id', $kid);
        return $row ? $row['fboard'] . '&nbsp; - &nbsp;' . $row['tboard'] : 'No values found';
    }

    // return management board range string (fmboard – tmboard) for a parameter
    public function fetchmngtboard(string $kid): string {
        $row = $this->fetchOne('kri_parameter', 'id', $kid);
        return $row ? $row['fmboard'] . '&nbsp; - &nbsp;' . $row['tmboard'] : 'No values found';
    }

    // return risk appetite value for a parameter
    public function fetchriskapetite(string $kid): string {
        $row = $this->fetchOne('kri_parameter', 'id', $kid);
        return $row ? $row['apetite'] : 'No values found';
    }

    // return risk limit value for a parameter
    public function fetchrisklimit(string $kid): string {
        $row = $this->fetchOne('kri_parameter', 'id', $kid);
        return $row ? $row['rlimit'] : 'No values found';
    }

    // return unit label for an appetite type code
    public function apetite(mixed $apetite): string {
        switch ((int)$apetite) {
            case 1: return "%";
            case 2: return "KSH/USD";
            case 3: return "DAYS";
            case 4: return "PEOPLE";
            case 5: return "NUMBER";
            default: return "";
        }
    }

    // insert a new KRI register row (kpi/kri/perform/action/date/dept/b_obj/owner → kri table)
    public function addkrientry(string $uid, string $ipaddress, string $kpi, string $kri, string $perform, string $action, string $date, string $dept, string $b_obj, string $owner): string {
        $stmt = $this->prepare(
            "INSERT INTO kri(kpi,kri,perform,action,date,dept_id,b_objective,owner)
             VALUES(?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssss', $kpi, $kri, $perform, $action, $date, $dept, $b_obj, $owner);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "No values entered";
        }
        ActivityLogger::log($this, $uid, 'KRI', 'Added KRI entry', $ipaddress);
        return "KRI Added successfully";
    }

    // insert a new KRI performance row and its first history entry
    public function addkri(string $uid, string $ipaddress, string $process, string $risk, string $measure, string $apetite, string $rapetite, string $description, string $timeline): string {
        $stmt = $this->prepare(
            "INSERT INTO performance(process_id,risk_id,measure,apetite,risk_apetite,rapetite_desc,timeline)
             VALUES(?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('sssssss', $process, $risk, $measure, $apetite, $rapetite, $description, $timeline);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "There is no query";
        }

        $kriid = $this->insert_id;
        $hstmt = $this->prepare("INSERT INTO kri_hist(kri,rapetite,owner,date) VALUES(?,?,?,?)");
        $hstmt->bind_param('ssss', $kriid, $rapetite, $uid, $timeline);
        $hstmt->execute();

        if ($hstmt->affected_rows > 0) {
            ActivityLogger::log($this, $uid, 'Risk Performance', 'Added Risk Performance', $ipaddress);
            return "Performance Entered successfully";
        }
        return "There is no query";
    }

    // update KRI performance value and insert a new history entry
    public function updatekriperform(string $uid, string $ipaddress, string $kriid, string $rapetite, string $date): string {
        $stmt = $this->prepare("UPDATE performance SET risk_apetite=?,updated_at=NOW() WHERE id=?");
        $stmt->bind_param('ss', $rapetite, $kriid);
        $stmt->execute();

        if ($stmt->affected_rows < 1) {
            return "There is no query";
        }

        $hstmt = $this->prepare("INSERT INTO kri_hist(kri,rapetite,owner,date) VALUES(?,?,?,?)");
        $hstmt->bind_param('ssss', $kriid, $rapetite, $uid, $date);
        $hstmt->execute();

        if ($hstmt->affected_rows > 0) {
            ActivityLogger::log($this, $uid, 'Performance History', "Added Performance History id=$kriid", $ipaddress);
            return "History Added Successfully";
        }
        return "There is no query";
    }

    // return history rows for a given KRI id
    public function fetchkriperformhist(string $kriid): array {
        return $this->fetchWhere('kri_hist', 'kriid', $kriid);
    }

    // update a KRI row and log the change
    public function updatekri(string $uid, string $ipaddress, string $kriid, string $kpi, string $kri, string $perform, string $action, string $b_obj, string $date): string {
        $stmt = $this->prepare(
            "UPDATE kri SET kpi=?,kri=?,perform=?,action=?,date=?,b_objective=? WHERE id=?"
        );
        $stmt->bind_param('sssssss', $kpi, $kri, $perform, $action, $date, $b_obj, $kriid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "There is no query";
        }
        ActivityLogger::log($this, $uid, 'Risk Performance', "Edited Performance id=$kriid", $ipaddress);
        return "Performance UPDATED successfully";
    }

    // delete a KRI row
    public function deletekri(string $rpid): string {
        $stmt = $this->prepare("DELETE FROM kri WHERE id=?");
        $stmt->bind_param('s', $rpid);
        $stmt->execute();
        return $stmt->affected_rows > 0 ? "Performance DELETED" : "There is no query";
    }

    // compute CSS class for a KRI performance value against its parameter thresholds
    public function calcperform(string $id): string {
        $pstmt = $this->prepare("SELECT perform, kri FROM kri WHERE id=?");
        $pstmt->bind_param('s', $id);
        $pstmt->execute();
        $prow = $pstmt->get_result()->fetch_assoc();
        if (!$prow) return "NO VALUES";

        $perform = $prow['perform'];
        $kri     = $prow['kri'];

        $kstmt = $this->prepare("SELECT * FROM kri_parameter WHERE id=?");
        $kstmt->bind_param('s', $kri);
        $kstmt->execute();
        $row = $kstmt->get_result()->fetch_array();
        if (!$row) return "NO VALUES";

        $rlimit  = $row['rlimit'];
        $type    = $row['type'];
        $fmngt   = $row['fmngt'];
        $tmngt   = $row['tmngt'];
        $fboard  = $row['fboard'];
        $tboard  = $row['tboard'];
        $fmboard = $row['fmboard'];
        $tmboard = $row['tmboard'];

        if ($type == 0) {
            if ($perform < $rlimit)                        return "btn-success";
            if ($perform >= $fmngt  && $perform <= $tmngt) return "btn-success";
            if ($perform >= $fboard && $perform <= $tboard) return "btn-warning";
            if ($perform >= $fmboard || $perform > $tmboard) return "btn-danger";
            return $perform . "btn-info";
        }

        if ($type == 1) {
            if ($perform > $rlimit)                         return "btn-success";
            if ($perform >= $fmngt  || $perform >= $tmngt)  return "btn-success";
            if ($perform == $fboard || $perform >= $tboard)  return "btn-warning";
            if ($perform <= $fmboard || $perform <= $tmboard) return "btn-danger";
            return $perform . "btn-info";
        }

        return "NO VALUES";
    }

    // return all KRI performance rows
    public function fetchkri(): array {
        return $this->fetchAll('performance');
    }

    // return KRI rows that have a BSC objective linked
    public function fetchkriobj(): array {
        $stmt = $this->prepare("SELECT * FROM kri WHERE (b_objective) IS NOT NULL");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }

    // return full checklist row for a KRI (multi-join, fixes original ASC syntax error)
    public function fetchkrichecklist(string $kriid): mixed {
        $stmt = $this->prepare(
            "SELECT kri.id,kri.kpi,kri.kri,kri.action,kri.perform,kri.date,
                    ki.ki,kri_parameter.pname,kri_parameter.rlimit,action.action
             FROM kri
             INNER JOIN ki           ON kri.kpi=ki.id
             INNER JOIN kri_parameter ON kri.kri=kri_parameter.id
             INNER JOIN action        ON kri.action=action.id
             WHERE kri.id=?"
        );
        $stmt->bind_param('s', $kriid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 1) {
            return "COULD NOT FIND";
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // return KRI history joined with performance measure
    public function fetchrphistory(string $kriid): mixed {
        $stmt = $this->prepare(
            "SELECT kri_hist.kri,kri_hist.rapetite,kri_hist.date,performance.measure
             FROM kri_hist
             INNER JOIN performance ON kri_hist.kri=performance.id
             WHERE kri_hist.kri=?"
        );
        $stmt->bind_param('s', $kriid);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows < 1) {
            return "COULD NOT FIND";
        }
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    // return KRI rows filtered by department
    public function fetchkridept(string $sdid): array {
        return $this->fetchWhere('kri', 'dept_id', $sdid);
    }

    // return a single performance row by id
    public function fetchkriid(string $kriid): ?array {
        return $this->fetchOne('performance', 'id', $kriid);
    }

    // return the action row linked to a KRI row (two-query chain)
    public function fetchkriaction(string $kriid): ?array {
        $stmt = $this->prepare("SELECT action FROM kri WHERE id=?");
        $stmt->bind_param('s', $kriid);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        if (!$row) return null;

        $action = $row['action'];
        $astmt  = $this->prepare("SELECT * FROM action WHERE id=?");
        $astmt->bind_param('s', $action);
        $astmt->execute();
        return $astmt->get_result()->fetch_assoc() ?: null;
    }
}
