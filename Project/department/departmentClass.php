<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class departmentClass extends BaseRepository {

    // insert a new entity/department row
    public function addDept(string $uid, string $ipaddress, string $name, string $company, string $owner, string $function): string {
        $stmt = $this->prepare(
            "INSERT INTO department(dept_name,company,owners,functions) VALUES(?,?,?,?)"
        );
        $stmt->bind_param('ssss', $name, $company, $owner, $function);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "data not entered";
        }
        ActivityLogger::log($this, $uid, 'Entity', 'added new Entity', $ipaddress);
        return "Entity Added";
    }

    // return all department rows
    public function showDept(): array {
        return $this->fetchAll('department');
    }

    // return department rows for a given session dept id
    public function showDeptSess(string $sdid): array {
        return $this->fetchWhere('department', 'dept_id', $sdid);
    }

    // return department rows for a given entity id
    public function showDeptentity(string $deptid): array {
        return $this->fetchWhere('department', 'dept_id', $deptid);
    }

    // return full department row for edit form
    public function fetchedit(string $deptid): ?array {
        return $this->fetchOne('department', 'dept_id', $deptid);
    }

    // update an existing department row
    public function update(string $uid, string $ipaddress, string $eid, string $ename, string $company, string $owner, string $function): string {
        $stmt = $this->prepare(
            "UPDATE department SET dept_name=?,company=?,owners=?,functions=? WHERE dept_id=?"
        );
        $stmt->bind_param('sssss', $ename, $company, $owner, $function, $eid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Entity', "edited entity id= ENT00$eid", $ipaddress);
        return "Entity Updated";
    }

    // delete a department row
    public function delete(string $deptid): string {
        return $this->deleteById('department', 'dept_id', $deptid)
            ? "DATA DELETED SUCCESSFULLY"
            : "DATA NOT DELTED";
    }

    // return department name for a given id (used in joins)
    public function deptJoins(string $deptid): string {
        $row = $this->fetchOne('department', 'dept_id', $deptid);
        return $row ? $row['dept_name'] : 'NO VALUES FOUND';
    }

    // return company id if this company has any departments (used in entity search)
    public function entitysearch(string $dcid): string {
        $row = $this->fetchOne('department', 'company', $dcid);
        return $row ? $row['company'] : 'NO VALUES FOUND';
    }

    // total department count for dashboard
    public function dashboard(): int {
        return $this->countAll('department');
    }
}
