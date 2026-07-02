<?php
require_once __DIR__ . '/../core/BaseRepository.php';

// Internal Audit — reporting artefacts (PSASB templates 23-26).

// (23) Internal Audit Final Report — per engagement
class finalReportClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, string $title, ?string $summary, ?string $rating, ?string $issued, string $status, ?string $filename): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_final_report(engagement_id,report_title,executive_summary,overall_rating,issued_date,filename,status,uid) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssss', ...[$engId, $title, $n($summary), $n($rating), $n($issued), $n($filename), $status, $uid]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Final report eng=$engId", $ip);
        return "Final Report Saved";
    }
    public function update(string $uid, string $ip, string $id, string $title, ?string $summary, ?string $rating, ?string $issued, string $status, ?string $filename): string {
        $n = fn($v) => ($v !== '' ? $v : null); $date = date('Y-m-d H:i:s');
        if ($filename === null || $filename === '') {
            $stmt = $this->prepare("UPDATE ia_final_report SET report_title=?,executive_summary=?,overall_rating=?,issued_date=?,status=?,uid=?,updated_at=? WHERE id=?");
            $stmt->bind_param('ssssssss', ...[$title, $n($summary), $n($rating), $n($issued), $status, $uid, $date, $id]);
        } else {
            $stmt = $this->prepare("UPDATE ia_final_report SET report_title=?,executive_summary=?,overall_rating=?,issued_date=?,filename=?,status=?,uid=?,updated_at=? WHERE id=?");
            $stmt->bind_param('sssssssss', ...[$title, $n($summary), $n($rating), $n($issued), $filename, $status, $uid, $date, $id]);
        }
        $stmt->execute();
        return "Final Report Updated";
    }
    public function all(): array { return $this->fetchAll('ia_final_report'); }
    public function byDeptEng(array $engIds): array {
        if (!$engIds) return [];
        $all = $this->fetchAll('ia_final_report');
        return array_values(array_filter($all, fn($r) => in_array((int)$r['engagement_id'], $engIds, true)));
    }
    public function details(string $id): ?array { return $this->fetchOne('ia_final_report', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_final_report', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
    public function ratingLabel(string $id): string { $r = $this->fetchOne('audit_rating', 'id', $id); return $r ? $r['grade'] : '—'; }
    public function ratings(): array { return $this->fetchAll('audit_rating'); }
}

// (24) Action Plan Reporting — periodic rollup snapshot
class actionSummaryClass extends BaseRepository {
    public function add(string $uid, string $ip, ?string $dept, string $year, ?string $title, string $closed, string $ongoing, string $pending, ?string $filename): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_action_plan_summary(dept_id,year,title,closed,ongoing,pending,filename) VALUES(?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssss', ...[$n($dept), $year, $n($title), $closed, $ongoing, $pending, $n($filename)]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Action plan summary $year", $ip);
        return "Action Plan Summary Saved";
    }
    public function update(string $uid, string $ip, string $id, ?string $dept, string $year, ?string $title, string $closed, string $ongoing, string $pending, ?string $filename): string {
        $n = fn($v) => ($v !== '' ? $v : null); $date = date('Y-m-d H:i:s');
        if ($filename === null || $filename === '') {
            $stmt = $this->prepare("UPDATE ia_action_plan_summary SET dept_id=?,year=?,title=?,closed=?,ongoing=?,pending=?,updated_at=? WHERE id=?");
            $stmt->bind_param('ssssssss', ...[$n($dept), $year, $n($title), $closed, $ongoing, $pending, $date, $id]);
        } else {
            $stmt = $this->prepare("UPDATE ia_action_plan_summary SET dept_id=?,year=?,title=?,closed=?,ongoing=?,pending=?,filename=?,updated_at=? WHERE id=?");
            $stmt->bind_param('sssssssss', ...[$n($dept), $year, $n($title), $closed, $ongoing, $pending, $filename, $date, $id]);
        }
        $stmt->execute();
        return "Action Plan Summary Updated";
    }
    public function all(): array { return $this->fetchAll('ia_action_plan_summary'); }
    public function details(string $id): ?array { return $this->fetchOne('ia_action_plan_summary', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_action_plan_summary', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}

// (25+26) Quarterly & Annual Reports
class reportSummaryClass extends BaseRepository {
    public function add(string $uid, string $ip, string $type, string $year, ?string $quarter, string $title, ?string $narrative, string $closed, string $ongoing, string $pending, string $status, ?string $filename): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_report_summary(report_type,year,quarter,title,narrative,closed,ongoing,pending,status,filename,uid) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssssss', ...[$type, $year, $n($quarter), $title, $n($narrative), $closed, $ongoing, $pending, $status, $n($filename), $uid]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "$type report $year", $ip);
        return "Report Saved";
    }
    public function update(string $uid, string $ip, string $id, string $type, string $year, ?string $quarter, string $title, ?string $narrative, string $closed, string $ongoing, string $pending, string $status, ?string $filename): string {
        $n = fn($v) => ($v !== '' ? $v : null); $date = date('Y-m-d H:i:s');
        if ($filename === null || $filename === '') {
            $stmt = $this->prepare("UPDATE ia_report_summary SET report_type=?,year=?,quarter=?,title=?,narrative=?,closed=?,ongoing=?,pending=?,status=?,uid=?,updated_at=? WHERE id=?");
            $stmt->bind_param('ssssssssssss', ...[$type, $year, $n($quarter), $title, $n($narrative), $closed, $ongoing, $pending, $status, $uid, $date, $id]);
        } else {
            $stmt = $this->prepare("UPDATE ia_report_summary SET report_type=?,year=?,quarter=?,title=?,narrative=?,closed=?,ongoing=?,pending=?,status=?,filename=?,uid=?,updated_at=? WHERE id=?");
            $stmt->bind_param('sssssssssssss', ...[$type, $year, $n($quarter), $title, $n($narrative), $closed, $ongoing, $pending, $status, $filename, $uid, $date, $id]);
        }
        $stmt->execute();
        return "Report Updated";
    }
    public function all(): array { return $this->fetchAll('ia_report_summary'); }
    public function details(string $id): ?array { return $this->fetchOne('ia_report_summary', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_report_summary', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}
