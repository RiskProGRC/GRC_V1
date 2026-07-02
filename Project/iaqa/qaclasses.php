<?php
require_once __DIR__ . '/../core/BaseRepository.php';

// Internal Audit — Quality Assurance & Performance (PSASB templates 27-32).

// (27-30) Stakeholder surveys
class surveyClass extends BaseRepository {
    public function add(string $uid, string $ip, string $type, string $year, ?string $engId, ?string $name, ?string $role, ?string $score, ?string $comments, ?string $submitted): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_survey(survey_type,period_year,engagement_id,respondent_name,respondent_role,overall_score,comments,submitted_at) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssss', ...[$type, $year, $n($engId), $n($name), $n($role), $n($score), $n($comments), $n($submitted)]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Survey ($type) $year", $ip);
        return "Survey Response Saved";
    }
    public function update(string $uid, string $ip, string $id, string $year, ?string $name, ?string $role, ?string $score, ?string $comments, ?string $submitted): string {
        $n = fn($v) => ($v !== '' ? $v : null); $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE ia_survey SET period_year=?,respondent_name=?,respondent_role=?,overall_score=?,comments=?,submitted_at=?,updated_at=? WHERE id=?");
        $stmt->bind_param('ssssssss', ...[$year, $n($name), $n($role), $n($score), $n($comments), $n($submitted), $date, $id]);
        $stmt->execute();
        return "Survey Response Updated";
    }
    public function all(): array { return $this->fetchAll('ia_survey'); }
    public function byType(string $type): array { return $this->fetchWhere('ia_survey', 'survey_type', $type); }
    public function details(string $id): ?array { return $this->fetchOne('ia_survey', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_survey', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
    public function avgScore(string $type): ?float {
        $stmt = $this->prepare("SELECT AVG(overall_score) FROM ia_survey WHERE survey_type=? AND overall_score IS NOT NULL");
        $stmt->bind_param('s', $type);
        $stmt->execute();
        $v = $stmt->get_result()->fetch_row()[0];
        return $v !== null ? round((float)$v, 2) : null;
    }
}

// (31) Performance Measurement Matrix
class performanceMatrixClass extends BaseRepository {
    public function add(string $uid, string $ip, string $year, string $kpi, ?string $target, ?string $actual, ?string $basis, string $status): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_performance_matrix(period_year,kpi_name,target,actual,measurement_basis,status) VALUES(?,?,?,?,?,?)");
        $stmt->bind_param('ssssss', ...[$year, $kpi, $n($target), $n($actual), $n($basis), $status]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Performance KPI $year", $ip);
        return "KPI Saved";
    }
    public function update(string $uid, string $ip, string $id, string $year, string $kpi, ?string $target, ?string $actual, ?string $basis, string $status): string {
        $n = fn($v) => ($v !== '' ? $v : null); $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE ia_performance_matrix SET period_year=?,kpi_name=?,target=?,actual=?,measurement_basis=?,status=?,updated_at=? WHERE id=?");
        $stmt->bind_param('ssssssss', ...[$year, $kpi, $n($target), $n($actual), $n($basis), $status, $date, $id]);
        $stmt->execute();
        return "KPI Updated";
    }
    public function all(): array { return $this->fetchAll('ia_performance_matrix'); }
    public function details(string $id): ?array { return $this->fetchOne('ia_performance_matrix', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_performance_matrix', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}

// (32) External Assessors TOR / QAIP documents
class qaDocClass extends BaseRepository {
    public function add(string $uid, string $ip, string $year, string $desc, ?string $assessor, string $filename, string $status): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_qa_document(year,description,assessor_name,filename,status) VALUES(?,?,?,?,?)");
        $stmt->bind_param('sssss', ...[$year, $desc, $n($assessor), $filename, $status]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "QA document $year", $ip);
        return "Document Saved";
    }
    public function all(): array { return $this->fetchAll('ia_qa_document'); }
    public function details(string $id): ?array { return $this->fetchOne('ia_qa_document', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_qa_document', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}
