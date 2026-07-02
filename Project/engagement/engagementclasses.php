<?php
require_once __DIR__ . '/../core/BaseRepository.php';

// Internal Audit — engagement sub-artefacts (PSASB templates 5,6,8,9,10,11,12,13).
// One compact CRUD class per artefact, each scoped to an engagement_id.

// (8+9) Engagement Plan / Planning Memorandum — one row per engagement
class engagementPlanClass extends BaseRepository {
    public function save(string $uid, string $ip, string $engId, ?string $obj, ?string $scope, ?string $criteria,
        ?string $res, ?string $risks, ?string $start, ?string $exit, ?string $draft, ?string $final, string $status): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $existing = $this->fetchOne('ia_engagement_plan', 'engagement_id', $engId);
        if ($existing) {
            $stmt = $this->prepare("UPDATE ia_engagement_plan SET objectives=?,scope=?,criteria=?,resources_required=?,risks_to_engagement=?,planned_start=?,exit_meeting=?,draft_issued=?,final_report=?,status=?,updated_at=? WHERE engagement_id=?");
            $date = date('Y-m-d H:i:s');
            $stmt->bind_param('ssssssssssss', ...[$n($obj), $n($scope), $n($criteria), $n($res), $n($risks), $n($start), $n($exit), $n($draft), $n($final), $status, $date, $engId]);
            $stmt->execute();
            ActivityLogger::log($this, $uid, 'Internal Audit', "Updated Engagement Plan eng=$engId", $ip);
            return "Engagement Plan Saved";
        }
        $stmt = $this->prepare("INSERT INTO ia_engagement_plan(engagement_id,objectives,scope,criteria,resources_required,risks_to_engagement,planned_start,exit_meeting,draft_issued,final_report,status) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssssss', ...[$engId, $n($obj), $n($scope), $n($criteria), $n($res), $n($risks), $n($start), $n($exit), $n($draft), $n($final), $status]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Created Engagement Plan eng=$engId", $ip);
        return "Engagement Plan Saved";
    }
    public function byEng(string $engId): ?array { return $this->fetchOne('ia_engagement_plan', 'engagement_id', $engId); }
}

// (5) Ethics & Professionalism Acknowledgement
class ethicsAckClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, string $name, string $text, ?string $date): string {
        $date = $date !== '' ? $date : null;
        $stmt = $this->prepare("INSERT INTO ia_ethics_ack(engagement_id,auditor_name,acknowledgement_text,signed_date) VALUES(?,?,?,?)");
        $stmt->bind_param('ssss', $engId, $name, $text, $date);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Ethics ack eng=$engId", $ip);
        return "Acknowledgement Recorded";
    }
    public function update(string $uid, string $ip, string $id, string $name, string $text, ?string $date): string {
        $date = $date !== '' ? $date : null;
        $stmt = $this->prepare("UPDATE ia_ethics_ack SET auditor_name=?,acknowledgement_text=?,signed_date=? WHERE id=?");
        $stmt->bind_param('ssss', $name, $text, $date, $id);
        $stmt->execute();
        return "Acknowledgement Updated";
    }
    public function byEng(string $engId): array { return $this->fetchWhere('ia_ethics_ack', 'engagement_id', $engId); }
    public function details(string $id): ?array { return $this->fetchOne('ia_ethics_ack', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_ethics_ack', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}

// (6) Coordination & Reliance Framework
class relianceClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, string $provider, string $area, string $basis): string {
        $stmt = $this->prepare("INSERT INTO ia_coordination_reliance(engagement_id,assurance_provider,scope_area,reliance_basis) VALUES(?,?,?,?)");
        $stmt->bind_param('ssss', $engId, $provider, $area, $basis);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Reliance eng=$engId", $ip);
        return "Reliance Entry Added";
    }
    public function update(string $uid, string $ip, string $id, string $provider, string $area, string $basis): string {
        $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE ia_coordination_reliance SET assurance_provider=?,scope_area=?,reliance_basis=?,updated_at=? WHERE id=?");
        $stmt->bind_param('sssss', $provider, $area, $basis, $date, $id);
        $stmt->execute();
        return "Reliance Entry Updated";
    }
    public function byEng(string $engId): array { return $this->fetchWhere('ia_coordination_reliance', 'engagement_id', $engId); }
    public function details(string $id): ?array { return $this->fetchOne('ia_coordination_reliance', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_coordination_reliance', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}

// (10+11) Request for Information / Monitoring Checklist  &  (21) Workpaper File Checklist (Phase 4 reuse)
class checklistClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, string $type, string $desc, ?string $from, ?string $due, ?string $completed, string $status, ?string $remarks): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_checklist_item(engagement_id,checklist_type,item_description,requested_from,due_date,completed_date,status,remarks) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssss', ...[$engId, $type, $desc, $n($from), $n($due), $n($completed), $status, $n($remarks)]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Checklist item eng=$engId", $ip);
        return "Checklist Item Added";
    }
    public function update(string $uid, string $ip, string $id, string $desc, ?string $from, ?string $due, ?string $completed, string $status, ?string $remarks): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE ia_checklist_item SET item_description=?,requested_from=?,due_date=?,completed_date=?,status=?,remarks=?,updated_at=? WHERE id=?");
        $stmt->bind_param('ssssssss', ...[$desc, $n($from), $n($due), $n($completed), $status, $n($remarks), $date, $id]);
        $stmt->execute();
        return "Checklist Item Updated";
    }
    public function byEngType(string $engId, string $type): array {
        $stmt = $this->prepare("SELECT * FROM ia_checklist_item WHERE engagement_id=? AND checklist_type=? ORDER BY id");
        $stmt->bind_param('ss', $engId, $type);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC) ?? [];
    }
    public function details(string $id): ?array { return $this->fetchOne('ia_checklist_item', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_checklist_item', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}

// (12) Business Process Analysis Form
class processAnalysisClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, ?string $pid, string $name, ?string $owner, ?string $inputs, ?string $acts, ?string $outputs, ?string $risks, ?string $controls): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_process_analysis(engagement_id,process_id,process_name,process_owner,inputs,activities,outputs,key_risks,key_controls) VALUES(?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssss', ...[$engId, $n($pid), $name, $n($owner), $n($inputs), $n($acts), $n($outputs), $n($risks), $n($controls)]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Process analysis eng=$engId", $ip);
        return "Process Analysis Added";
    }
    public function update(string $uid, string $ip, string $id, ?string $pid, string $name, ?string $owner, ?string $inputs, ?string $acts, ?string $outputs, ?string $risks, ?string $controls): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE ia_process_analysis SET process_id=?,process_name=?,process_owner=?,inputs=?,activities=?,outputs=?,key_risks=?,key_controls=?,updated_at=? WHERE id=?");
        $stmt->bind_param('ssssssssss', ...[$n($pid), $name, $n($owner), $n($inputs), $n($acts), $n($outputs), $n($risks), $n($controls), $date, $id]);
        $stmt->execute();
        return "Process Analysis Updated";
    }
    public function byEng(string $engId): array { return $this->fetchWhere('ia_process_analysis', 'engagement_id', $engId); }
    public function details(string $id): ?array { return $this->fetchOne('ia_process_analysis', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_process_analysis', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}

// (13) Sample Engagement Audit Program — one row per test step
class auditProgramClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, string $obj, ?string $risk, ?string $control, string $proc, ?string $sample, ?string $wpref, string $status): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_audit_program(engagement_id,objective,risk_addressed,control_tested,test_procedure,sample_size,wp_ref,status) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssss', ...[$engId, $obj, $n($risk), $n($control), $proc, $n($sample), $n($wpref), $status]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Audit program step eng=$engId", $ip);
        return "Program Step Added";
    }
    public function update(string $uid, string $ip, string $id, string $obj, ?string $risk, ?string $control, string $proc, ?string $sample, ?string $wpref, string $status): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE ia_audit_program SET objective=?,risk_addressed=?,control_tested=?,test_procedure=?,sample_size=?,wp_ref=?,status=?,updated_at=? WHERE id=?");
        $stmt->bind_param('sssssssss', ...[$obj, $n($risk), $n($control), $proc, $n($sample), $n($wpref), $status, $date, $id]);
        $stmt->execute();
        return "Program Step Updated";
    }
    public function byEng(string $engId): array { return $this->fetchWhere('ia_audit_program', 'engagement_id', $engId); }
    public function details(string $id): ?array { return $this->fetchOne('ia_audit_program', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_audit_program', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}
