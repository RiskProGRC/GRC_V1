<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class ownerClass extends BaseRepository {

    // insert a new owner row
    public function addOwner(string $fname, string $sname, string $email, string $sup, string $dept, string $division): string {
        $stmt = $this->prepare(
            "INSERT INTO owner(fname,sname,email,sup,dept,division) VALUES(?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssss', $fname, $sname, $email, $sup, $dept, $division);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return 'DATA WAS NOT ENTERED';
        }
        return 'Owner added successfully';
    }

    // return all owner rows
    public function showOwner(): array {
        return $this->fetchAll('owner');
    }

    // return full name for a given owner id (used in joins)
    public function ownerJoins(string $oid): string {
        $row = $this->fetchOne('owner', 'id', $oid);
        if (!$row) return 'NO VALUES FOUND';
        return $row['fname'] . '&nbsp;' . $row['sname'];
    }

    // update an existing owner row
    public function update(string $id, string $fname, string $sname, string $email, string $sup, string $dept, string $division): string {
        $stmt = $this->prepare("UPDATE owner SET fname=?,sname=?,email=?,sup=?,dept=?,division=? WHERE id=?");
        $stmt->bind_param('sssssss', $fname, $sname, $email, $sup, $dept, $division, $id);
        $stmt->execute();
        return "Owner updated successfully";
    }

    // delete an owner row
    public function delete(string $id): string {
        return $this->deleteById('owner', 'id', $id) ? "Owner deleted successfully" : "DELETE FAILED";
    }
}
