<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/fieldworkclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new meetingClass();
$mode = $_POST['mode'] ?? 'add';
if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Record not found.');
    respond_ok($cls->remove($id));
}
$mtype = $_POST['meeting_type'] ?? '';
$rtype = $_POST['record_type'] ?? '';
$venue = $_POST['venue'] ?? '';
$mdate = $_POST['mdate'] ?? '';
$parts = $_POST['participants'] ?? '';
$body  = $_POST['content'] ?? '';
if (!in_array($mtype, ['entrance', 'exit'], true))   respond_error('Select entrance or exit.');
if (!in_array($rtype, ['agenda', 'minutes'], true))  respond_error('Select agenda or minutes.');
if ($mdate !== '' && !DateTime::createFromFormat('Y-m-d', $mdate)) respond_error('Enter a valid meeting date.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Record not found.');
    respond_ok($cls->update($uid, $ip, $id, $mtype, $rtype, $venue, $mdate, $parts, $body));
}
$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');
respond_ok($cls->add($uid, $ip, $engId, $mtype, $rtype, $venue, $mdate, $parts, $body));
