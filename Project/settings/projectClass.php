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

    // return full project row for edit populate
    public function editDetails(string $id): ?array {
        return $this->fetchOne('project', 'id', $id);
    }

    // update an existing project row (entity/risk are comma-joined id lists)
    public function update(string $id, string $name, string $entity, string $risk): string {
        $stmt = $this->prepare("UPDATE project SET name=?,entityid=?,riskid=? WHERE id=?");
        $stmt->bind_param('ssss', $name, $entity, $risk, $id);
        $stmt->execute();
        return "Project updated successfully";
    }

    // delete a project row
    public function delete(string $id): string {
        return $this->deleteById('project', 'id', $id) ? "Project deleted successfully" : "DELETE FAILED";
    }
}
