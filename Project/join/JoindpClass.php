<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class joindpClass extends BaseRepository {

    // link a department to a process — checks for duplicate before inserting
    public function addjoinDP(string $dept_id, string $pid): mixed {
        $check = $this->prepare("SELECT * FROM dept_process WHERE dept_id=? AND process_id=?");
        $check->bind_param('ss', $dept_id, $pid);
        $check->execute();
        if ($check->get_result()->num_rows >= 1) {
            return '<div class="alert alert-sm alert-danger">Process <b>:P00' . $pid . '</b> Already exist In that Department</div>';
        }

        $stmt = $this->prepare("INSERT INTO dept_process(dept_id,process_id) VALUES(?,?)");
        $stmt->bind_param('ss', $dept_id, $pid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "NOT INSERTED";
        }
        return header("Location:addjoinDP.php");
    }

    // return all department-process links
    public function showjoindp(): array {
        return $this->fetchAll('dept_process');
    }

    // return distinct department ids that have processes linked
    public function riskDept(): array {
        $stmt = $this->prepare("SELECT DISTINCT(dept_id) FROM dept_process");
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }
}
