<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/fieldworkclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new workpaperClass();
$mode = $_POST['mode'] ?? 'add';
$STATUS = ['Draft', 'In Review', 'Finalized'];
if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Workpaper not found.');
    respond_ok($cls->remove($id));
}
$wpref = $_POST['wp_ref'] ?? '';
$title = $_POST['title'] ?? '';
$obj   = $_POST['objective'] ?? '';
$proc  = $_POST['procedures_performed'] ?? '';
$concl = $_POST['conclusion'] ?? '';
$prep  = $_POST['preparer'] ?? '';
$pdate = $_POST['prepared_date'] ?? '';
$rev   = $_POST['reviewer'] ?? '';
$rdate = $_POST['reviewed_date'] ?? '';
$status = $_POST['status'] ?? 'Draft';
if (trim($wpref) === '')                respond_error('Workpaper reference is required.');
if (trim($title) === '')                respond_error('Workpaper title is required.');
if (!in_array($status, $STATUS, true))  respond_error('Invalid status.');
foreach ([$pdate, $rdate] as $d) if ($d !== '' && !DateTime::createFromFormat('Y-m-d', $d)) respond_error('Enter valid dates.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Workpaper not found.');
    respond_ok($cls->update($uid, $ip, $id, $wpref, $title, $obj, $proc, $concl, $prep, $pdate, $rev, $rdate, $status));
}
$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');
respond_ok($cls->add($uid, $ip, $engId, $wpref, $title, $obj, $proc, $concl, $prep, $pdate, $rev, $rdate, $status));
