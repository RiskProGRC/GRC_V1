<?php
require_once __DIR__ . '/core/AuthGuard.php';        // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/iacharter/iacharterClass.php';

$charterclass = new iacharterClass();

$type         = $_POST['charter_type']  ?? '';
$title        = $_POST['title']         ?? '';
$version      = $_POST['version']       ?? '';
$content      = $_POST['content']       ?? '';
$approvedBy   = $_POST['approved_by']   ?? '';
$approvedDate = $_POST['approved_date'] ?? '';
$reviewDate   = $_POST['review_date']   ?? '';
$status       = $_POST['status']        ?? 'Draft';

if (!in_array($type, ['audit_committee', 'internal_audit'], true)) {
    respond_error('Select a valid charter type.');
}
if (trim($title) === '') {
    respond_error('Charter title is required.');
}
if (!in_array($status, ['Draft', 'Under Review', 'Approved', 'Retired'], true)) {
    respond_error('Invalid status.');
}

$upload = ia_store_upload('file', 'charters', $type, ['pdf', 'doc', 'docx']);
if (!$upload['ok']) {
    respond_error($upload['error']);
}

respond_ok($charterclass->addcharter(
    $uid, $ip, $type, $title, $version, $content, $approvedBy, $approvedDate, $reviewDate, $status, $upload['filename']
));
