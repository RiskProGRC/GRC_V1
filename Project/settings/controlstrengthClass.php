<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class controlstrengthClass extends BaseRepository {

    // insert a new control strength row
    public function addcontrolstrength(string $uid, string $ipaddress, string $name, string $desc): string {
        $stmt = $this->prepare("INSERT INTO control_strength(cs_name,description) VALUES(?,?)");
        $stmt->bind_param('ss', $name, $desc);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "COULD NOT SEND";
        }
        ActivityLogger::log($this, $uid, 'control strength', 'Added Control strength', $ipaddress);
        return "Control Strength Entered";
    }

    // return all control strength rows
    public function showcontrolstrength(): array {
        return $this->fetchAll('control_strength');
    }

    // return full control strength row for edit form
    public function editcs(string $csid): ?array {
        return $this->fetchOne('control_strength', 'strength_id', $csid);
    }

    // update an existing control strength row
    public function updatecs(string $uid, string $ipaddress, string $csid, string $csname, string $csdesc): string {
        $stmt = $this->prepare("UPDATE control_strength SET cs_name=?,description=? WHERE strength_id=?");
        $stmt->bind_param('sss', $csname, $csdesc, $csid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'control strength', "Edited Control strength id=$csid", $ipaddress);
        return "Control Strength Updated";
    }

    // delete a control strength row
    public function delete(string $csid): string {
        return $this->deleteById('control_strength', 'strength_id', $csid)
            ? "Control Strength Deleted"
            : "DATA NOT DELETED";
    }

    // return control strength name for a given id (used in joins)
    public function strengthjoin(string $csid): string {
        $row = $this->fetchOne('control_strength', 'strength_id', $csid);
        return $row ? $row['cs_name'] : '';
    }
}
