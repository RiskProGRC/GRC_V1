<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/engagement/reportingclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new finalReportClass();
$mode = $_POST['mode'] ?? 'add';

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id)) respond_error('Invalid report.');
    $row = $cls->details($id);
    if ($row === null) respond_error('Report not found.');
    $msg = $cls->remove($id);
    if ($msg === 'Deleted') { ia_delete_upload($row['filename'] ?? null); respond_ok($msg); }
    respond_error($msg);
}

$title   = $_POST['report_title'] ?? '';
$summary = $_POST['executive_summary'] ?? '';
$rating  = $_POST['overall_rating'] ?? '';
$issued  = $_POST['issued_date'] ?? '';
$status  = $_POST['status'] ?? 'Draft';
if (trim($title) === '')                              respond_error('Report title is required.');
if ($rating !== '' && !ctype_digit((string)$rating))  respond_error('Invalid overall rating.');
if ($issued !== '' && !DateTime::createFromFormat('Y-m-d', $issued)) respond_error('Enter a valid issued date.');
if (!in_array($status, ['Draft', 'Issued'], true))    respond_error('Invalid status.');

$upload = ia_store_upload('file', 'final_reports', 'finalreport', ['pdf', 'doc', 'docx']);
if (!$upload['ok']) respond_error($upload['error']);

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id)) respond_error('Invalid report.');
    $existing = $cls->details($id);
    if ($existing === null) respond_error('Report not found.');
    $result = $cls->update($uid, $ip, $id, $title, $summary, $rating, $issued, $status, $upload['filename']);
    if ($upload['filename'] !== null && !empty($existing['filename']) && $existing['filename'] !== $upload['filename']) ia_delete_upload($existing['filename']);
    respond_ok($result);
}

$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Select a valid engagement.');
respond_ok($cls->add($uid, $ip, $engId, $title, $summary, $rating, $issued, $status, $upload['filename']));
