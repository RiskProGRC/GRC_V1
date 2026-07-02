<?php
require_once __DIR__ . '/../core/BaseRepository.php';

// Internal Audit — Annual (risk-based) Plan: header + line items (PSASB template 4)
class iaannualplanClass extends BaseRepository {

    /* ---------- Plan header ---------- */

    public function addplan(string $uid, string $ip, string $year, string $title,
        ?string $approvedBy, ?string $approvedDate, string $status, ?string $filename): string {

        $approvedBy   = $approvedBy   !== '' ? $approvedBy   : null;
        $approvedDate = $approvedDate !== '' ? $approvedDate : null;
        $filename     = $filename     !== '' ? $filename     : null;

        $stmt = $this->prepare(
            "INSERT INTO ia_annual_plan(plan_year,title,approved_by,approved_date,filename,status,uid)
             VALUES(?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('sssssss', $year, $title, $approvedBy, $approvedDate, $filename, $status, $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT ENTERED";
        }
        ActivityLogger::log($this, $uid, 'Internal Audit', 'Added Annual Plan ' . $year, $ip);
        return "Annual Plan Added";
    }

    public function showplans(): array {
        return $this->fetchAll('ia_annual_plan');
    }

    public function planDetails(string $id): ?array {
        return $this->fetchOne('ia_annual_plan', 'id', $id);
    }

    public function updateplan(string $uid, string $ip, string $id, string $year, string $title,
        ?string $approvedBy, ?string $approvedDate, string $status, ?string $filename, string $date): string {

        $approvedBy   = $approvedBy   !== '' ? $approvedBy   : null;
        $approvedDate = $approvedDate !== '' ? $approvedDate : null;

        if ($filename === null || $filename === '') {
            $stmt = $this->prepare(
                "UPDATE ia_annual_plan SET plan_year=?,title=?,approved_by=?,approved_date=?,status=?,uid=?,updated_at=?
                 WHERE id=?"
            );
            $stmt->bind_param('ssssssss', $year, $title, $approvedBy, $approvedDate, $status, $uid, $date, $id);
        } else {
            $stmt = $this->prepare(
                "UPDATE ia_annual_plan SET plan_year=?,title=?,approved_by=?,approved_date=?,filename=?,status=?,uid=?,updated_at=?
                 WHERE id=?"
            );
            $stmt->bind_param('sssssssss', $year, $title, $approvedBy, $approvedDate, $filename, $status, $uid, $date, $id);
        }
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Edited Annual Plan id=$id", $ip);
        return "Annual Plan Updated";
    }

    public function deleteplan(string $id): string {
        // atomic cascade — remove the plan's line items and the header together
        $this->begin_transaction();
        try {
            $this->deleteItemsForPlan($id);
            $ok = $this->deleteById('ia_annual_plan', 'id', $id);
            if (!$ok) {
                $this->rollback();
                return "DELETE FAILED";
            }
            $this->commit();
            return "Annual Plan Deleted";
        } catch (\Throwable $e) {
            $this->rollback();
            return "DELETE FAILED";
        }
    }

    /* ---------- Line items ---------- */

    public function additem(string $uid, string $ip, string $planId, string $dept, ?string $process, ?string $risk,
        string $auditTitle, ?string $rating, ?string $quarter, ?string $days, string $status): string {

        $process = $process !== '' ? $process : null;
        $risk    = $risk    !== '' ? $risk    : null;
        $rating  = $rating  !== '' ? $rating  : null;
        $quarter = $quarter !== '' ? $quarter : null;
        $days    = $days    !== '' ? $days    : null;

        $stmt = $this->prepare(
            "INSERT INTO ia_annual_plan_item(annual_plan_id,dept_id,process_id,risk_id,audit_title,risk_rating,quarter_planned,budgeted_days,status)
             VALUES(?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('sssssssss', $planId, $dept, $process, $risk, $auditTitle, $rating, $quarter, $days, $status);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT ENTERED";
        }
        ActivityLogger::log($this, $uid, 'Internal Audit', "Added Annual Plan item (plan=$planId)", $ip);
        return "Plan Item Added";
    }

    public function showitems(string $planId): array {
        return $this->fetchWhere('ia_annual_plan_item', 'annual_plan_id', $planId);
    }

    public function itemDetails(string $id): ?array {
        return $this->fetchOne('ia_annual_plan_item', 'id', $id);
    }

    public function updateitem(string $uid, string $ip, string $id, string $dept, ?string $process, ?string $risk,
        string $auditTitle, ?string $rating, ?string $quarter, ?string $days, string $status, string $date): string {

        $process = $process !== '' ? $process : null;
        $risk    = $risk    !== '' ? $risk    : null;
        $rating  = $rating  !== '' ? $rating  : null;
        $quarter = $quarter !== '' ? $quarter : null;
        $days    = $days    !== '' ? $days    : null;

        $stmt = $this->prepare(
            "UPDATE ia_annual_plan_item SET dept_id=?,process_id=?,risk_id=?,audit_title=?,risk_rating=?,quarter_planned=?,budgeted_days=?,status=?,updated_at=?
             WHERE id=?"
        );
        $stmt->bind_param('ssssssssss', $dept, $process, $risk, $auditTitle, $rating, $quarter, $days, $status, $date, $id);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Edited Annual Plan item id=$id", $ip);
        return "Plan Item Updated";
    }

    public function deleteitem(string $id): string {
        return $this->deleteById('ia_annual_plan_item', 'id', $id) ? "Plan Item Deleted" : "DELETE FAILED";
    }

    public function deleteItemsForPlan(string $planId): void {
        $stmt = $this->prepare("DELETE FROM ia_annual_plan_item WHERE annual_plan_id=?");
        $stmt->bind_param('s', $planId);
        $stmt->execute();
    }
}
