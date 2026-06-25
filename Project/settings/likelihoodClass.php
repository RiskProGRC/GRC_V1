<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class likelihoodClass extends BaseRepository {

    // insert a new likelihood row
    public function addlikely(string $uid, string $ipaddress, string $name, string $level, string $desc): string {
        $stmt = $this->prepare("INSERT INTO likelihood(name,level,description) VALUES(?,?,?)");
        $stmt->bind_param('sss', $name, $level, $desc);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "COULD NOT SEND";
        }
        ActivityLogger::log($this, $uid, 'Likelihood', 'Added likelihood', $ipaddress);
        return "Likelihood Added Successfully";
    }

    // return all likelihood rows
    public function showlikely(): array {
        return $this->fetchAll('likelihood');
    }

    // return full likelihood row for edit form
    public function editlikely(string $lid): ?array {
        return $this->fetchOne('likelihood', 'id', $lid);
    }

    // update an existing likelihood row
    public function updatelikely(string $uid, string $ipaddress, string $lid, string $name, string $level, string $desc): string {
        $stmt = $this->prepare("UPDATE likelihood SET name=?,level=?,description=? WHERE id=?");
        $stmt->bind_param('ssss', $name, $level, $desc, $lid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Likelihood', "Edited likelihood id=$lid", $ipaddress);
        return "Likelihood Updated Sucessfully";
    }

    // return full likelihood row for delete confirmation (same as editlikely)
    public function delupdate(string $lid): ?array {
        return $this->fetchOne('likelihood', 'id', $lid);
    }

    // delete a likelihood row
    public function delete(string $lid): string {
        return $this->deleteById('likelihood', 'id', $lid)
            ? "Likelihood Deleted Sucessfully"
            : "DATA NOT DELETED";
    }
}
