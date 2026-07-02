<?php
require_once __DIR__ . '/../core/BaseRepository.php';

// Internal Audit — fieldwork artefacts (PSASB templates 14-22).

// (14-17) Entrance/Exit Meeting Agendas & Minutes
class meetingClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, string $mtype, string $rtype, ?string $venue, ?string $mdate, ?string $participants, ?string $content): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO meeting(engagement_id,meeting_type,record_type,venue,mdate,participants,content) VALUES(?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssss', ...[$engId, $mtype, $rtype, $n($venue), $n($mdate), $n($participants), $n($content)]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Meeting record eng=$engId", $ip);
        return "Meeting Record Saved";
    }
    public function update(string $uid, string $ip, string $id, string $mtype, string $rtype, ?string $venue, ?string $mdate, ?string $participants, ?string $content): string {
        $n = fn($v) => ($v !== '' ? $v : null); $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE meeting SET meeting_type=?,record_type=?,venue=?,mdate=?,participants=?,content=?,updated_at=? WHERE id=?");
        $stmt->bind_param('ssssssss', ...[$mtype, $rtype, $n($venue), $n($mdate), $n($participants), $n($content), $date, $id]);
        $stmt->execute();
        return "Meeting Record Updated";
    }
    public function byEng(string $engId): array { return $this->fetchWhere('meeting', 'engagement_id', $engId); }
    public function details(string $id): ?array { return $this->fetchOne('meeting', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('meeting', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}

// (18) Workpaper
class workpaperClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, string $wpref, string $title, ?string $obj, ?string $proc, ?string $concl, ?string $prep, ?string $prepDate, ?string $rev, ?string $revDate, string $status): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_workpaper(engagement_id,wp_ref,title,objective,procedures_performed,conclusion,preparer,prepared_date,reviewer,reviewed_date,status) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssssss', ...[$engId, $wpref, $title, $n($obj), $n($proc), $n($concl), $n($prep), $n($prepDate), $n($rev), $n($revDate), $status]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Workpaper eng=$engId", $ip);
        return "Workpaper Saved";
    }
    public function update(string $uid, string $ip, string $id, string $wpref, string $title, ?string $obj, ?string $proc, ?string $concl, ?string $prep, ?string $prepDate, ?string $rev, ?string $revDate, string $status): string {
        $n = fn($v) => ($v !== '' ? $v : null); $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE ia_workpaper SET wp_ref=?,title=?,objective=?,procedures_performed=?,conclusion=?,preparer=?,prepared_date=?,reviewer=?,reviewed_date=?,status=?,updated_at=? WHERE id=?");
        $stmt->bind_param('ssssssssssss', ...[$wpref, $title, $n($obj), $n($proc), $n($concl), $n($prep), $n($prepDate), $n($rev), $n($revDate), $status, $date, $id]);
        $stmt->execute();
        return "Workpaper Updated";
    }
    public function byEng(string $engId): array { return $this->fetchWhere('ia_workpaper', 'engagement_id', $engId); }
    public function details(string $id): ?array { return $this->fetchOne('ia_workpaper', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_workpaper', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}

// (19+20) Findings (Draft Finding Sheet + Findings Database)
class findingClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, ?string $dept, ?string $risk, ?string $rating, string $finding, ?string $rootCause, ?string $recommend, ?string $mgmt, ?string $officer, string $status, ?string $timeline): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_finding(engagement_id,dept_id,risk_id,rating,finding,root_cause,recommend,management_response,responsible_officer,status,timeline) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('sssssssssss', ...[$engId, $n($dept), $n($risk), $n($rating), $finding, $n($rootCause), $n($recommend), $n($mgmt), $n($officer), $status, $n($timeline)]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Finding eng=$engId", $ip);
        return "Finding Saved";
    }
    public function update(string $uid, string $ip, string $id, ?string $dept, ?string $risk, ?string $rating, string $finding, ?string $rootCause, ?string $recommend, ?string $mgmt, ?string $officer, string $status, ?string $timeline): string {
        $n = fn($v) => ($v !== '' ? $v : null); $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE ia_finding SET dept_id=?,risk_id=?,rating=?,finding=?,root_cause=?,recommend=?,management_response=?,responsible_officer=?,status=?,timeline=?,updated_at=? WHERE id=?");
        $stmt->bind_param('ssssssssssss', ...[$n($dept), $n($risk), $n($rating), $finding, $n($rootCause), $n($recommend), $n($mgmt), $n($officer), $status, $n($timeline), $date, $id]);
        $stmt->execute();
        return "Finding Updated";
    }
    public function byEng(string $engId): array { return $this->fetchWhere('ia_finding', 'engagement_id', $engId); }
    public function all(): array { return $this->fetchAll('ia_finding'); }
    public function byDept(string $sdid): array { return $this->fetchWhere('ia_finding', 'dept_id', $sdid); }
    public function details(string $id): ?array { return $this->fetchOne('ia_finding', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_finding', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
    public function ratings(): array { return $this->fetchAll('audit_rating'); }
    public function ratingLabel(string $id): string { $r = $this->fetchOne('audit_rating', 'id', $id); return $r ? $r['grade'] : '—'; }
}

// (22) Review Notes
class reviewNoteClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, ?string $wpref, string $reviewer, string $comment, ?string $response, string $status, ?string $raised, ?string $cleared): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_review_note(engagement_id,wp_ref,reviewer,review_comment,preparer_response,status,raised_date,cleared_date) VALUES(?,?,?,?,?,?,?,?)");
        $stmt->bind_param('ssssssss', ...[$engId, $n($wpref), $reviewer, $comment, $n($response), $status, $n($raised), $n($cleared)]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Review note eng=$engId", $ip);
        return "Review Note Saved";
    }
    public function update(string $uid, string $ip, string $id, ?string $wpref, string $reviewer, string $comment, ?string $response, string $status, ?string $raised, ?string $cleared): string {
        $n = fn($v) => ($v !== '' ? $v : null); $date = date('Y-m-d H:i:s');
        $stmt = $this->prepare("UPDATE ia_review_note SET wp_ref=?,reviewer=?,review_comment=?,preparer_response=?,status=?,raised_date=?,cleared_date=?,updated_at=? WHERE id=?");
        $stmt->bind_param('sssssssss', ...[$n($wpref), $reviewer, $comment, $n($response), $status, $n($raised), $n($cleared), $date, $id]);
        $stmt->execute();
        return "Review Note Updated";
    }
    public function byEng(string $engId): array { return $this->fetchWhere('ia_review_note', 'engagement_id', $engId); }
    public function details(string $id): ?array { return $this->fetchOne('ia_review_note', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_review_note', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}

// Engagement supporting documents (upload register; replaces orphan letterupload)
class engDocClass extends BaseRepository {
    public function add(string $uid, string $ip, string $engId, ?string $docType, string $filename, ?string $desc): string {
        $n = fn($v) => ($v !== '' ? $v : null);
        $stmt = $this->prepare("INSERT INTO ia_engagement_document(engagement_id,doc_type,filename,description,uploaded_by) VALUES(?,?,?,?,?)");
        $stmt->bind_param('sssss', ...[$engId, $n($docType), $filename, $n($desc), $uid]);
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Document eng=$engId", $ip);
        return "Document Uploaded";
    }
    public function byEng(string $engId): array { return $this->fetchWhere('ia_engagement_document', 'engagement_id', $engId); }
    public function details(string $id): ?array { return $this->fetchOne('ia_engagement_document', 'id', $id); }
    public function remove(string $id): string { return $this->deleteById('ia_engagement_document', 'id', $id) ? "Deleted" : "DELETE FAILED"; }
}
