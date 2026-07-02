<?php
require_once __DIR__ . '/../core/BaseRepository.php';

// Internal Audit — Strategic Plan register (PSASB template 3)
class iastrategicplanClass extends BaseRepository {

    public function add(string $uid, string $ip, string $title, string $startYear, string $endYear,
        string $objectives, ?string $resourcePlan, string $status, ?string $filename): string {

        $resourcePlan = $resourcePlan !== '' ? $resourcePlan : null;
        $filename     = $filename     !== '' ? $filename     : null;

        $stmt = $this->prepare(
            "INSERT INTO ia_strategic_plan(title,period_start_year,period_end_year,objectives,resource_plan,filename,status,uid)
             VALUES(?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssss', $title, $startYear, $endYear, $objectives, $resourcePlan, $filename, $status, $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT ENTERED";
        }
        ActivityLogger::log($this, $uid, 'Internal Audit', 'Added Strategic Plan', $ip);
        return "Strategic Plan Added";
    }

    public function showall(): array {
        return $this->fetchAll('ia_strategic_plan');
    }

    public function editDetails(string $id): ?array {
        return $this->fetchOne('ia_strategic_plan', 'id', $id);
    }

    public function update(string $uid, string $ip, string $id, string $title, string $startYear, string $endYear,
        string $objectives, ?string $resourcePlan, string $status, ?string $filename, string $date): string {

        $resourcePlan = $resourcePlan !== '' ? $resourcePlan : null;

        if ($filename === null || $filename === '') {
            $stmt = $this->prepare(
                "UPDATE ia_strategic_plan SET title=?,period_start_year=?,period_end_year=?,objectives=?,resource_plan=?,status=?,uid=?,updated_at=?
                 WHERE id=?"
            );
            $stmt->bind_param('sssssssss', $title, $startYear, $endYear, $objectives, $resourcePlan, $status, $uid, $date, $id);
        } else {
            $stmt = $this->prepare(
                "UPDATE ia_strategic_plan SET title=?,period_start_year=?,period_end_year=?,objectives=?,resource_plan=?,filename=?,status=?,uid=?,updated_at=?
                 WHERE id=?"
            );
            $stmt->bind_param('ssssssssss', $title, $startYear, $endYear, $objectives, $resourcePlan, $filename, $status, $uid, $date, $id);
        }
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Edited Strategic Plan id=$id", $ip);
        return "Strategic Plan Updated";
    }

    public function delete(string $id): string {
        return $this->deleteById('ia_strategic_plan', 'id', $id) ? "Strategic Plan Deleted" : "DELETE FAILED";
    }
}
