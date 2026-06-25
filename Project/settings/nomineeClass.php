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
}
