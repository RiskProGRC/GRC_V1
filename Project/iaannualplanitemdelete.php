<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/iaplan/iaannualplanClass.php';

$cls = new iaannualplanClass();
$id  = $_POST['id'] ?? '';
if (!ctype_digit((string)$id))          respond_error('Invalid plan item.');
if ($cls->itemDetails($id) === null)    respond_error('Plan item not found.');

$msg = $cls->deleteitem($id);
if ($msg === 'Plan Item Deleted') {
    ActivityLogger::log($cls, $uid, 'Internal Audit', "Deleted Annual Plan item id=$id", $ip);
    respond_ok($msg);
}
respond_error($msg);
