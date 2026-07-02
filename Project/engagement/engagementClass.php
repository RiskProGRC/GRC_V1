<?php
require_once __DIR__ . '/../core/BaseRepository.php';

// Internal Audit — Engagement hub (PSASB template 7 Audit Notification + engagement lifecycle)
class engagementClass extends BaseRepository {

    public function add(string $uid, string $ip, string $title, string $dept, string $type, ?string $risk,
        ?string $scope, ?string $owner, ?string $lead, ?string $start, ?string $end, string $status, ?string $filename): string {

        $risk = $risk !== '' ? $risk : null;  $scope = $scope !== '' ? $scope : null;
        $owner = $owner !== '' ? $owner : null; $lead = $lead !== '' ? $lead : null;
        $start = $start !== '' ? $start : null; $end = $end !== '' ? $end : null;
        $filename = $filename !== '' ? $filename : null;

        $stmt = $this->prepare(
            "INSERT INTO audit_engagement(title,dept_id,engagement_type,risk_id,scope_description,auditee_owner,lead_auditor,planned_start,planned_end,status,notification_filename,uid)
             VALUES(?,?,?,?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssssssss', $title, $dept, $type, $risk, $scope, $owner, $lead, $start, $end, $status, $filename, $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) return "DATA NOT ENTERED";
        ActivityLogger::log($this, $uid, 'Internal Audit', 'Created Engagement: ' . $title, $ip);
        return "Engagement Created";
    }

    public function showall(): array { return $this->fetchAll('audit_engagement'); }
    public function showdept(string $sdid): array { return $this->fetchWhere('audit_engagement', 'dept_id', $sdid); }
    public function details(string $id): ?array { return $this->fetchOne('audit_engagement', 'id', $id); }

    public function update(string $uid, string $ip, string $id, string $title, string $dept, string $type, ?string $risk,
        ?string $scope, ?string $owner, ?string $lead, ?string $start, ?string $end, string $status, ?string $filename, string $date): string {

        $risk = $risk !== '' ? $risk : null;  $scope = $scope !== '' ? $scope : null;
        $owner = $owner !== '' ? $owner : null; $lead = $lead !== '' ? $lead : null;
        $start = $start !== '' ? $start : null; $end = $end !== '' ? $end : null;

        if ($filename === null || $filename === '') {
            $stmt = $this->prepare(
                "UPDATE audit_engagement SET title=?,dept_id=?,engagement_type=?,risk_id=?,scope_description=?,auditee_owner=?,lead_auditor=?,planned_start=?,planned_end=?,status=?,uid=?,updated_at=?
                 WHERE id=?"
            );
            $stmt->bind_param('sssssssssssss', $title, $dept, $type, $risk, $scope, $owner, $lead, $start, $end, $status, $uid, $date, $id);
        } else {
            $stmt = $this->prepare(
                "UPDATE audit_engagement SET title=?,dept_id=?,engagement_type=?,risk_id=?,scope_description=?,auditee_owner=?,lead_auditor=?,planned_start=?,planned_end=?,status=?,notification_filename=?,uid=?,updated_at=?
                 WHERE id=?"
            );
            $stmt->bind_param('ssssssssssssss', $title, $dept, $type, $risk, $scope, $owner, $lead, $start, $end, $status, $filename, $uid, $date, $id);
        }
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Edited Engagement id=$id", $ip);
        return "Engagement Updated";
    }

    // delete the engagement and every child artefact belonging to it (atomic)
    public function delete(string $id): string {
        $children = ['ia_ethics_ack', 'ia_coordination_reliance', 'ia_engagement_plan',
                     'ia_checklist_item', 'ia_process_analysis', 'ia_audit_program'];
        $this->begin_transaction();
        try {
            foreach ($children as $t) {
                $s = $this->prepare("DELETE FROM `$t` WHERE engagement_id=?");
                $s->bind_param('s', $id);
                $s->execute();
            }
            $ok = $this->deleteById('audit_engagement', 'id', $id);
            if (!$ok) { $this->rollback(); return "DELETE FAILED"; }
            $this->commit();
            return "Engagement Deleted";
        } catch (\Throwable $e) {
            $this->rollback();
            return "DELETE FAILED";
        }
    }
}
