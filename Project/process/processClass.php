<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class processClass extends BaseRepository {

    // insert a new process row
    public function addProcess(string $uid, string $ipaddress, string $name, string $dept, string $detail): string {
        $stmt = $this->prepare("INSERT INTO process(process_name,dept_id,details) VALUES(?,?,?)");
        $stmt->bind_param('sss', $name, $dept, $detail);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT ENTERED";
        }
        ActivityLogger::log($this, $uid, 'Process', 'Added Process', $ipaddress);
        return "Process Entered";
    }

    // return all process rows
    public function showProcess(): array {
        return $this->fetchAll('process');
    }

    // return a single process row by id
    public function showp_dept(string $pid): ?array {
        return $this->fetchOne('process', 'process_id', $pid);
    }

    // process rows filtered by department
    public function showProcessdept(string $sdid): array {
        return $this->fetchWhere('process', 'dept_id', $sdid);
    }

    // update an existing process row
    public function update(string $uid, string $ipaddress, string $pid, string $entity, string $pname, string $detail): string {
        $stmt = $this->prepare(
            "UPDATE process SET process_name=?,dept_id=?,details=? WHERE process_id=?"
        );
        $stmt->bind_param('ssss', $pname, $entity, $detail, $pid);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Process', "Edited Process id=P00$pid", $ipaddress);
        return "DATA SUCCESSFULLY UPDATED";
    }

    // return full process row for edit form
    public function fetchedit(string $pid): ?array {
        return $this->fetchOne('process', 'process_id', $pid);
    }

    // return process name for a given id (used in joins)
    public function processJoins(string $pid): string {
        $row = $this->fetchOne('process', 'process_id', $pid);
        return $row ? $row['process_name'] : 'NO VALUES FOUND';
    }

    // return the dept_id for a given department if it has any processes
    public function entitysearch(string $deptid): string {
        $row = $this->fetchOne('process', 'dept_id', $deptid);
        return $row ? $row['dept_id'] : 'NO VALUES FOUND';
    }

    // delete a process row
    public function delete(string $pid): string {
        return $this->deleteById('process', 'process_id', $pid)
            ? "Process Deleted Sucessfully"
            : "DATA NOT DELETED";
    }
}
