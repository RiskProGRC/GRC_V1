<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new engagementClass();
$mode = $_POST['mode'] ?? '';

$TYPES  = ['Assurance', 'Advisory', 'Investigation', 'Follow-up'];
$STATUS = ['Notified', 'Planning', 'Fieldwork', 'Reporting', 'Closed'];

function ia_date_ok(string $d): bool { return $d === '' || (bool)DateTime::createFromFormat('Y-m-d', $d); }

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id)) respond_error('Invalid engagement.');
    $row = $cls->details($id);
    if ($row === null) respond_error('Engagement not found.');
    $msg = $cls->delete($id);
    if ($msg === 'Engagement Deleted') {
        ia_delete_upload($row['notification_filename'] ?? null);
        ActivityLogger::log($cls, $uid, 'Internal Audit', "Deleted Engagement id=$id", $ip);
        respond_ok($msg);
    }
    respond_error($msg);
}

$title  = $_POST['title']           ?? '';
$dept   = $_POST['dept_id']         ?? '';
$type   = $_POST['engagement_type'] ?? '';
$risk   = $_POST['risk_id']         ?? '';
$scope  = $_POST['scope_description'] ?? '';
$owner  = $_POST['auditee_owner']   ?? '';
$lead   = $_POST['lead_auditor']    ?? '';
$start  = $_POST['planned_start']   ?? '';
$end    = $_POST['planned_end']     ?? '';
$status = $_POST['status']          ?? 'Notified';

if (trim($title) === '')                          respond_error('Engagement title is required.');
if (!ctype_digit((string)$dept))                  respond_error('Select a department.');
if (!in_array($type, $TYPES, true))               respond_error('Select a valid engagement type.');
if ($risk !== '' && !ctype_digit((string)$risk))  respond_error('Invalid risk.');
if ($lead !== '' && !ctype_digit((string)$lead))  respond_error('Invalid lead auditor.');
if (!ia_date_ok($start) || !ia_date_ok($end))     respond_error('Enter valid planned dates.');
if (!in_array($status, $STATUS, true))            respond_error('Invalid status.');

$upload = ia_store_upload('file', 'engagements', 'engagement', ['pdf', 'doc', 'docx']);
if (!$upload['ok']) respond_error($upload['error']);

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id)) respond_error('Invalid engagement.');
    $existing = $cls->details($id);
    if ($existing === null) respond_error('Engagement not found.');
    $now = date('Y-m-d H:i:s');
    $result = $cls->update($uid, $ip, $id, $title, $dept, $type, $risk, $scope, $owner, $lead, $start, $end, $status, $upload['filename'], $now);
    if ($upload['filename'] !== null && !empty($existing['notification_filename']) && $existing['notification_filename'] !== $upload['filename']) {
        ia_delete_upload($existing['notification_filename']);
    }
    respond_ok($result);
}

// default: add
respond_ok($cls->add($uid, $ip, $title, $dept, $type, $risk, $scope, $owner, $lead, $start, $end, $status, $upload['filename']));
