<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class nomineeClass extends BaseRepository {

    // insert a new nominee row
    public function addNominee(string $fname, string $sname, string $email): string {
        $stmt = $this->prepare("INSERT INTO nominee(fname,sname,email) VALUES(?,?,?)");
        $stmt->bind_param('sss', $fname, $sname, $email);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return 'DATA WAS NOT ENTERED';
        }
        return 'Nominee added successfully';
    }

    // return all nominee rows
    public function showNominee(): array {
        return $this->fetchAll('nominee');
    }

    // return first name for a given nominee id (used in joins)
    public function nomineeJoins(string $nid): string {
        $row = $this->fetchOne('nominee', 'id', $nid);
        return $row ? $row['fname'] : 'NO VALUES FOUND';
    }

    public function editDetails(string $id): ?array { return $this->fetchOne('nominee', 'id', $id); }

    // update an existing nominee row
    public function update(string $id, string $fname, string $sname, string $email): string {
        $stmt = $this->prepare("UPDATE nominee SET fname=?,sname=?,email=? WHERE id=?");
        $stmt->bind_param('ssss', $fname, $sname, $email, $id);
        $stmt->execute();
        return "Nominee updated successfully";
    }

    // delete a nominee row
    public function delete(string $id): string {
        return $this->deleteById('nominee', 'id', $id) ? "Nominee deleted successfully" : "DELETE FAILED";
    }
}
