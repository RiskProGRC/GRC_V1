<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class controltypeClass extends BaseRepository {

    // insert a new control type row
    public function addcontroltype(string $uid, string $ipaddress, string $name, string $desc): string {
        $stmt = $this->prepare("INSERT INTO control_type(ct_name,description) VALUES(?,?)");
        $stmt->bind_param('ss', $name, $desc);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "COULD NOT SEND";
        }
        ActivityLogger::log($this, $uid, 'Control Type', 'Added Control Type', $ipaddress);
        return "Control Type Added";
    }

    // return full control type row for edit form
    public function editct(string $ctid): ?array {
        return $this->fetchOne('control_type', 'ctype_id', $ctid);
    }

    // update an existing control type row
    public function updatect(string $uid, string $ipaddress, string $ctid, string $ctname, string $desc): string {
        $stmt = $this->prepare("UPDATE control_type SET ct_name=?,description=? WHERE ctype_id=?");
        $stmt->bind_param('sss', $ctname, $desc, $ctid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Control Type', "Edited Control Type id=$ctid", $ipaddress);
        return "Control Type Updated";
    }

    // delete a control type row
    public function delete(string $ctid): string {
        return $this->deleteById('control_type', 'ctype_id', $ctid)
            ? "Control Type Deleted"
            : "DATA NOT DELETED";
    }

    // return all control type rows
    public function showcontroltype(): array {
        return $this->fetchAll('control_type');
    }

    // return control type name for a given id (used in joins)
    public function ctypejoin(string $ctid): string {
        $row = $this->fetchOne('control_type', 'ctype_id', $ctid);
        return $row ? $row['ct_name'] : 'NULL VALUES';
    }
}
