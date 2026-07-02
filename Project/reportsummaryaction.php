<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/engagement/reportingclasses.php';

$cls  = new reportSummaryClass();
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

$type    = $_POST['report_type'] ?? 'quarterly';
$year    = $_POST['year'] ?? '';
$quarter = $_POST['quarter'] ?? '';
$title   = $_POST['title'] ?? '';
$narr    = $_POST['narrative'] ?? '';
$closed  = isset($_POST['closed'])  && $_POST['closed']  !== '' ? $_POST['closed']  : '0';
$ongoing = isset($_POST['ongoing']) && $_POST['ongoing'] !== '' ? $_POST['ongoing'] : '0';
$pending = isset($_POST['pending']) && $_POST['pending'] !== '' ? $_POST['pending'] : '0';
$status  = $_POST['status'] ?? 'Draft';
if (!in_array($type, ['quarterly', 'annual'], true))  respond_error('Invalid report type.');
if (!ctype_digit((string)$year) || (int)$year < 1900 || (int)$year > 2200) respond_error('Enter a valid year.');
if ($type === 'quarterly' && !in_array($quarter, ['1', '2', '3', '4'], true)) respond_error('Select a quarter (1-4).');
if ($type === 'annual') $quarter = '';
if (trim($title) === '')                              respond_error('Report title is required.');
foreach (['closed' => $closed, 'ongoing' => $ongoing, 'pending' => $pending] as $k => $v) if (!ctype_digit((string)$v)) respond_error(ucfirst($k) . ' count must be a number.');
if (!in_array($status, ['Draft', 'Issued'], true))    respond_error('Invalid status.');

$upload = ia_store_upload('file', 'period_reports', 'periodreport', ['pdf', 'doc', 'docx', 'xls', 'xlsx']);
if (!$upload['ok']) respond_error($upload['error']);

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id)) respond_error('Invalid report.');
    $existing = $cls->details($id);
    if ($existing === null) respond_error('Report not found.');
    $result = $cls->update($uid, $ip, $id, $type, $year, $quarter, $title, $narr, $closed, $ongoing, $pending, $status, $upload['filename']);
    if ($upload['filename'] !== null && !empty($existing['filename']) && $existing['filename'] !== $upload['filename']) ia_delete_upload($existing['filename']);
    respond_ok($result);
}
respond_ok($cls->add($uid, $ip, $type, $year, $quarter, $title, $narr, $closed, $ongoing, $pending, $status, $upload['filename']));
