<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/iaplan/iaannualplanClass.php';

$cls = new iaannualplanClass();
$id  = $_POST['id'] ?? '';
if (!ctype_digit((string)$id)) respond_error('Invalid plan reference.');

$row = $cls->planDetails($id);
if ($row === null) respond_error('Plan not found.');

$msg = $cls->deleteplan($id);   // cascades line items
if ($msg === 'Annual Plan Deleted') {
    ia_delete_upload($row['filename'] ?? null);
    ActivityLogger::log($cls, $uid, 'Internal Audit', "Deleted Annual Plan id=$id (with line items)", $ip);
    respond_ok($msg);
}
respond_error($msg);
