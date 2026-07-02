<?php
require_once __DIR__ . '/../core/BaseRepository.php';

// Internal Audit — Charter register (PSASB templates 1 & 2)
// charter_type: 'audit_committee' (Audit Committee Charter) | 'internal_audit' (Internal Audit Charter)
class iacharterClass extends BaseRepository {

    // insert a new charter row (filename already moved/validated by the action handler; '' -> NULL)
    public function addcharter(string $uid, string $ipaddress, string $type, string $title, ?string $version,
        ?string $content, ?string $approvedBy, ?string $approvedDate, ?string $reviewDate, string $status, ?string $filename): string {

        $version      = $version      !== '' ? $version      : null;
        $content      = $content      !== '' ? $content      : null;
        $approvedBy   = $approvedBy   !== '' ? $approvedBy   : null;
        $approvedDate = $approvedDate !== '' ? $approvedDate : null;
        $reviewDate   = $reviewDate   !== '' ? $reviewDate   : null;
        $filename     = $filename     !== '' ? $filename     : null;

        $stmt = $this->prepare(
            "INSERT INTO ia_charter(charter_type,title,version,content,filename,approved_by,approved_date,review_date,status,uid)
             VALUES(?,?,?,?,?,?,?,?,?,?)"
        );
        $stmt->bind_param('ssssssssss', $type, $title, $version, $content, $filename, $approvedBy, $approvedDate, $reviewDate, $status, $uid);
        $stmt->execute();
        if ($stmt->affected_rows < 1) {
            return "DATA NOT ENTERED";
        }
        ActivityLogger::log($this, $uid, 'Internal Audit', 'Added ' . $this->label($type) . ' Charter', $ipaddress);
        return "Charter Added";
    }

    // charters of one type
    public function showchartertype(string $type): array {
        return $this->fetchWhere('ia_charter', 'charter_type', $type);
    }

    // single charter for edit/view
    public function editDetails(string $id): ?array {
        return $this->fetchOne('ia_charter', 'id', $id);
    }

    // update an existing charter row (updated_at set explicitly — schema never auto-updates it)
    public function update(string $uid, string $ipaddress, string $id, string $title, ?string $version,
        ?string $content, ?string $approvedBy, ?string $approvedDate, ?string $reviewDate, string $status, ?string $filename, string $date): string {

        $version      = $version      !== '' ? $version      : null;
        $content      = $content      !== '' ? $content      : null;
        $approvedBy   = $approvedBy   !== '' ? $approvedBy   : null;
        $approvedDate = $approvedDate !== '' ? $approvedDate : null;
        $reviewDate   = $reviewDate   !== '' ? $reviewDate   : null;

        if ($filename === null || $filename === '') {
            // no new file uploaded — keep the existing filename untouched
            $stmt = $this->prepare(
                "UPDATE ia_charter SET title=?,version=?,content=?,approved_by=?,approved_date=?,review_date=?,status=?,uid=?,updated_at=?
                 WHERE id=?"
            );
            $stmt->bind_param('ssssssssss', $title, $version, $content, $approvedBy, $approvedDate, $reviewDate, $status, $uid, $date, $id);
        } else {
            // replace the stored file reference with the newly uploaded one
            $stmt = $this->prepare(
                "UPDATE ia_charter SET title=?,version=?,content=?,filename=?,approved_by=?,approved_date=?,review_date=?,status=?,uid=?,updated_at=?
                 WHERE id=?"
            );
            $stmt->bind_param('sssssssssss', $title, $version, $content, $filename, $approvedBy, $approvedDate, $reviewDate, $status, $uid, $date, $id);
        }
        $stmt->execute();
        ActivityLogger::log($this, $uid, 'Internal Audit', "Edited Charter id=$id", $ipaddress);
        return "Charter Updated";
    }

    // delete a charter row
    public function delete(string $id): string {
        return $this->deleteById('ia_charter', 'id', $id)
            ? "Charter Deleted"
            : "DELETE FAILED";
    }

    // human label for a charter_type code
    public function label(string $type): string {
        return $type === 'audit_committee' ? 'Audit Committee' : 'Internal Audit';
    }
}
