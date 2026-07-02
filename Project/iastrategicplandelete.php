<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/iaplan/iastrategicplanClass.php';

$cls = new iastrategicplanClass();
$id  = $_POST['id'] ?? '';
if (!ctype_digit((string)$id)) respond_error('Invalid plan reference.');

$row = $cls->editDetails($id);
if ($row === null) respond_error('Plan not found.');

$msg = $cls->delete($id);
if ($msg === 'Strategic Plan Deleted') {
    ia_delete_upload($row['filename'] ?? null);
    ActivityLogger::log($cls, $uid, 'Internal Audit', "Deleted Strategic Plan id=$id", $ip);
    respond_ok($msg);
}
respond_error($msg);
