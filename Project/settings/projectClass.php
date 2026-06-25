<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class projectClass extends BaseRepository {

    // insert a new project row
    public function addProject(string $name, string $entity, string $risk): string {
        $stmt = $this->prepare("INSERT INTO project(name,entityid,riskid) VALUES(?,?,?)");
        $stmt->bind_param('sss', $name, $entity, $risk);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return 'PROJECT COULD NOT BE SAVED';
        }
        return 'Project added successfully';
    }

    // return all project rows
    public function showProject(): array {
        return $this->fetchAll('project');
    }

    // return first element from an array (utility used by callers)
    public function explode(array $eid): mixed {
        foreach ($eid as $values) {
            return $values;
        }
        return null;
    }
}
