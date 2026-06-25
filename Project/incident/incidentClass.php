<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class incidentclass extends BaseRepository {

    // insert a new incident row
    public function addincident(string $uid, string $ipaddress, string $incident, string $dept_id, string $process, string $risk, string $dol, string $actual, string $expected, string $potential, string $recovery, string $action): string {
        $stmt = $this->prepare(
            "INSERT INTO incident(incident,dept_id,process_id,risk_id,dol,actual,expected,potential,recovery,action)
             VALUES(?,?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssssss', $incident, $dept_id, $process, $risk, $dol, $actual, $expected, $potential, $recovery, $action);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA Error";
        }
        ActivityLogger::log($this, $uid, 'Incident', 'Added Incident', $ipaddress);
        return "Incident Added Successfully";
    }

    // total incident count for dashboard
    public function dashboard(): int {
        return $this->countAll('incident');
    }

    // return all incident rows
    public function showincident(): array {
        return $this->fetchAll('incident');
    }

    // incidents filtered by department
    public function showincidentdept(string $sdid): array {
        return $this->fetchWhere('incident', 'dept_id', $sdid);
    }

    // return the action value linked to an incident (used in joins)
    public function fetchactionincident(string $aid): string {
        $stmt = $this->prepare("SELECT action FROM incident WHERE action=?");
        $stmt->bind_param('s', $aid);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        return $row ? $row['action'] : 'NULL VALUES';
    }

    // return full incident row for edit form
    public function fetcheditincident(string $iid): ?array {
        return $this->fetchOne('incident', 'incident_id', $iid);
    }

    // update an existing incident row
    public function updateincident(string $uid, string $ipaddress, string $iid, string $incident, string $process, string $risk, string $dol, string $actual, string $expected, string $potential, string $recovery, string $action): string {
        $stmt = $this->prepare(
            "UPDATE incident SET incident=?,process_id=?,risk_id=?,dol=?,actual=?,expected=?,potential=?,recovery=?,action=?
             WHERE incident_id=?"
        );
        $stmt->bind_param('ssssssssss', $incident, $process, $risk, $dol, $actual, $expected, $potential, $recovery, $action, $iid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Incident', "Edited Incident id=INC0$iid", $ipaddress);
        return "Incident Updated Sucessfully";
    }

    // delete an incident row
    public function deleteincident(string $iid): string {
        return $this->deleteById('incident', 'incident_id', $iid)
            ? "DATA DELETED SUCESSFUL"
            : "DATA CANNOT DELETED BECAUSE ITS HAS ASSESSMENT";
    }
}
