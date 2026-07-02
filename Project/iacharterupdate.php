<?php
require_once __DIR__ . '/core/AuthGuard.php';        // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/iacharter/iacharterClass.php';

$charterclass = new iacharterClass();

$id           = $_POST['id']            ?? '';
$title        = $_POST['title']         ?? '';
$version      = $_POST['version']       ?? '';
$content      = $_POST['content']       ?? '';
$approvedBy   = $_POST['approved_by']   ?? '';
$approvedDate = $_POST['approved_date'] ?? '';
$reviewDate   = $_POST['review_date']   ?? '';
$status       = $_POST['status']        ?? 'Draft';

if (trim($id) === '' || !ctype_digit((string)$id)) {
    respond_error('Invalid charter reference.');
}
if (trim($title) === '') {
    respond_error('Charter title is required.');
}
if (!in_array($status, ['Draft', 'Under Review', 'Approved', 'Retired'], true)) {
    respond_error('Invalid status.');
}

// single fetch — used both to confirm existence and to derive the upload prefix
$existing = $charterclass->editDetails($id);
if ($existing === null) {
    respond_error('Charter not found.');
}

$upload = ia_store_upload('file', 'charters', $existing['charter_type'], ['pdf', 'doc', 'docx']);
if (!$upload['ok']) {
    respond_error($upload['error']);
}

$now = date('Y-m-d H:i:s');
$result = $charterclass->update(
    $uid, $ip, $id, $title, $version, $content, $approvedBy, $approvedDate, $reviewDate, $status, $upload['filename'], $now
);

// a new file replaced the old one — remove the now-orphaned file from disk
if ($upload['filename'] !== null && !empty($existing['filename']) && $existing['filename'] !== $upload['filename']) {
    ia_delete_upload($existing['filename']);
}

respond_ok($result);
