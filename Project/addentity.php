<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/department/departmentClass.php';

$deptclass = new departmentClass();
$name     = trim($_POST['name']     ?? '');
$company  = $_POST['company']       ?? '';
$owner    = $_POST['owner']         ?? '';
$function = trim($_POST['function'] ?? '');

if ($name === '') {
    respond_error('PLEASE ENTER NAME');
} elseif ($company === '') {
    respond_error('PLEASE ENTER COMPANY');
} elseif ($owner === '') {
    respond_error('PLEASE ENTER OWNER');
} elseif ($function === '') {
    respond_error('PLEASE ENTER FUNCTION');
} else {
    respond_ok($deptclass->addDept($uid, $ip, $name, $company, $owner, $function));
}
