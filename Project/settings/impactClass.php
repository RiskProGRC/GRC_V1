<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class impactClass extends BaseRepository {

    // insert a new impact level row
    public function addImpact(string $uid, string $ipaddress, string $name, string $level, string $desc): string {
        $stmt = $this->prepare("INSERT INTO impact(name,level,description) VALUES(?,?,?)");
        $stmt->bind_param('sss', $name, $level, $desc);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "COULD NOT SEND";
        }
        ActivityLogger::log($this, $uid, 'IMPACT', 'added impact level', $ipaddress);
        return "Impact Added Successfully";
    }

    // return all impact rows
    public function showImpact(): array {
        return $this->fetchAll('impact');
    }

    // return full impact row for edit form
    public function editimpact(string $iid): ?array {
        return $this->fetchOne('impact', 'id', $iid);
    }

    // update an existing impact row
    public function updateimpact(string $uid, string $ipaddress, string $iid, string $name, string $level, string $desc): string {
        $stmt = $this->prepare("UPDATE impact SET name=?,level=?,description=? WHERE id=?");
        $stmt->bind_param('ssss', $name, $level, $desc, $iid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'IMPACT', "Edited impact id=IMP00$iid", $ipaddress);
        return "Impact Updated Sucessfully";
    }

    // return full impact row for delete confirmation (same as editimpact)
    public function delupdate(string $iid): ?array {
        return $this->fetchOne('impact', 'id', $iid);
    }

    // delete an impact row
    public function delete(string $iid): string {
        return $this->deleteById('impact', 'id', $iid)
            ? "Impact Deleted Sucessfully"
            : "DATA NOT DELETED";
    }
}
