<?php
require_once __DIR__ . '/../core/BaseRepository.php';

class reviewerClass extends BaseRepository {

    // insert a new reviewer row and redirect
    public function addreviewer(string $fname, string $sname, string $email, string $phone): mixed {
        $stmt = $this->prepare("INSERT INTO reviewer(fname,sname,email,phone) VALUES(?,?,?,?)");
        $stmt->bind_param('ssss', $fname, $sname, $email, $phone);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "COULD NOT SEND";
        }
        return header("Location:addreviewer.php");
    }

    // return all reviewer rows
    public function showreviewer(): array {
        return $this->fetchAll('reviewer');
    }

    // return full name for a given reviewer id (used in joins)
    public function reviewerjoin(string $rvid): string {
        $row = $this->fetchOne('reviewer', 'id', $rvid);
        if (!$row) return 'NULL VALUES';
        return $row['fname'] . '&nbsp;' . $row['sname'];
    }

    // update an existing reviewer row
    public function update(string $id, string $fname, string $sname, string $email, string $phone): string {
        $stmt = $this->prepare("UPDATE reviewer SET fname=?,sname=?,email=?,phone=? WHERE id=?");
        $stmt->bind_param('sssss', $fname, $sname, $email, $phone, $id);
        $stmt->execute();
        return "Reviewer updated successfully";
    }

    // delete a reviewer row
    public function delete(string $id): string {
        return $this->deleteById('reviewer', 'id', $id) ? "Reviewer deleted successfully" : "DELETE FAILED";
    }
}
