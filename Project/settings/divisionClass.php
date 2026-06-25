<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class divisionClass extends BaseRepository {

    // insert a new division row
    public function addDivision(string $division): string {
        $stmt = $this->prepare("INSERT INTO division(name) VALUES(?)");
        $stmt->bind_param('s', $division);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return 'DATA NOT ENTERED';
        }
        return 'Division added successfully';
    }

    // return all division rows
    public function showDivision(): array {
        return $this->fetchAll('division');
    }

    // return division name for a given id (used in joins)
    public function divJoins(string $divid): string {
        $row = $this->fetchOne('division', 'id', $divid);
        return $row ? $row['name'] : 'NO VALUES FOUND';
    }
}
