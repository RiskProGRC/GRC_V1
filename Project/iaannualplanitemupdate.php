<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/iaplan/iaannualplanClass.php';

$cls        = new iaannualplanClass();
$id         = $_POST['id']             ?? '';
$dept       = $_POST['dept_id']        ?? '';
$process    = $_POST['process_id']     ?? '';
$risk       = $_POST['risk_id']        ?? '';
$auditTitle = $_POST['audit_title']    ?? '';
$rating     = $_POST['risk_rating']    ?? '';
$quarter    = $_POST['quarter_planned'] ?? '';
$days       = $_POST['budgeted_days']  ?? '';
$status     = $_POST['status']         ?? 'Planned';

$ITEM_STATUS = ['Planned', 'In Progress', 'Completed', 'Deferred', 'Cancelled'];
$RATINGS     = ['', 'Critical', 'High', 'Medium', 'Low'];

if (!ctype_digit((string)$id) || $cls->itemDetails($id) === null) respond_error('Invalid plan item.');
if (!ctype_digit((string)$dept))            respond_error('Select a department.');
if ($process !== '' && !ctype_digit((string)$process)) respond_error('Invalid process.');
if ($risk    !== '' && !ctype_digit((string)$risk))    respond_error('Invalid risk.');
if (trim($auditTitle) === '')               respond_error('Audit title is required.');
if (!in_array($rating, $RATINGS, true))     respond_error('Invalid risk rating.');
if ($quarter !== '' && !in_array($quarter, ['1', '2', '3', '4'], true)) respond_error('Quarter must be 1-4.');
if ($days !== '' && (!ctype_digit((string)$days) || (int)$days > 3650)) respond_error('Budgeted days must be a realistic number.');
if (!in_array($status, $ITEM_STATUS, true)) respond_error('Invalid status.');

$now = date('Y-m-d H:i:s');
respond_ok($cls->updateitem($uid, $ip, $id, $dept, $process, $risk, $auditTitle, $rating, $quarter, $days, $status, $now));
