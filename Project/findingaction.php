<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/fieldworkclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new findingClass();
$mode = $_POST['mode'] ?? 'add';
$STATUS = ['Draft', 'Open', 'Closed', 'Overdue'];
if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Finding not found.');
    respond_ok($cls->remove($id));
}
$dept    = $_POST['dept_id'] ?? '';
$risk    = $_POST['risk_id'] ?? '';
$rating  = $_POST['rating'] ?? '';
$finding = $_POST['finding'] ?? '';
$cause   = $_POST['root_cause'] ?? '';
$rec     = $_POST['recommend'] ?? '';
$mgmt    = $_POST['management_response'] ?? '';
$officer = $_POST['responsible_officer'] ?? '';
$status  = $_POST['status'] ?? 'Draft';
$timeline = $_POST['timeline'] ?? '';
if (trim($finding) === '')                          respond_error('Finding description is required.');
if ($dept !== '' && !ctype_digit((string)$dept))    respond_error('Invalid department.');
if ($risk !== '' && !ctype_digit((string)$risk))    respond_error('Invalid risk.');
if ($rating !== '' && !ctype_digit((string)$rating)) respond_error('Invalid rating.');
if (!in_array($status, $STATUS, true))              respond_error('Invalid status.');
if ($timeline !== '' && !DateTime::createFromFormat('Y-m-d', $timeline)) respond_error('Enter a valid target date.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Finding not found.');
    respond_ok($cls->update($uid, $ip, $id, $dept, $risk, $rating, $finding, $cause, $rec, $mgmt, $officer, $status, $timeline));
}
$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');
respond_ok($cls->add($uid, $ip, $engId, $dept, $risk, $rating, $finding, $cause, $rec, $mgmt, $officer, $status, $timeline));
