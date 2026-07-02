<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/engagement/reportingclasses.php';

$cls  = new actionSummaryClass();
$mode = $_POST['mode'] ?? 'add';

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id)) respond_error('Invalid record.');
    $row = $cls->details($id);
    if ($row === null) respond_error('Record not found.');
    $msg = $cls->remove($id);
    if ($msg === 'Deleted') { ia_delete_upload($row['filename'] ?? null); respond_ok($msg); }
    respond_error($msg);
}

$dept    = $_POST['dept_id'] ?? '';
$year    = $_POST['year'] ?? '';
$title   = $_POST['title'] ?? '';
$closed  = isset($_POST['closed'])  && $_POST['closed']  !== '' ? $_POST['closed']  : '0';
$ongoing = isset($_POST['ongoing']) && $_POST['ongoing'] !== '' ? $_POST['ongoing'] : '0';
$pending = isset($_POST['pending']) && $_POST['pending'] !== '' ? $_POST['pending'] : '0';
if (!ctype_digit((string)$year) || (int)$year < 1900 || (int)$year > 2200) respond_error('Enter a valid year.');
if ($dept !== '' && !ctype_digit((string)$dept)) respond_error('Invalid department.');
foreach (['closed' => $closed, 'ongoing' => $ongoing, 'pending' => $pending] as $k => $v) if (!ctype_digit((string)$v)) respond_error(ucfirst($k) . ' count must be a number.');

$upload = ia_store_upload('file', 'action_summaries', 'actionplan', ['pdf', 'doc', 'docx', 'xls', 'xlsx']);
if (!$upload['ok']) respond_error($upload['error']);

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id)) respond_error('Invalid record.');
    $existing = $cls->details($id);
    if ($existing === null) respond_error('Record not found.');
    $result = $cls->update($uid, $ip, $id, $dept, $year, $title, $closed, $ongoing, $pending, $upload['filename']);
    if ($upload['filename'] !== null && !empty($existing['filename']) && $existing['filename'] !== $upload['filename']) ia_delete_upload($existing['filename']);
    respond_ok($result);
}
respond_ok($cls->add($uid, $ip, $dept, $year, $title, $closed, $ongoing, $pending, $upload['filename']));
