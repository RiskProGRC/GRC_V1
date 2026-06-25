<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/department/departmentClass.php';

$departmentclass = new departmentClass();

$eid      = $_POST['eid']      ?? '';
$ename    = $_POST['ename']    ?? '';
$company  = $_POST['company']  ?? '';
$owner    = $_POST['owner']    ?? '';
$function = $_POST['function'] ?? '';

if ($ename === '') {
    respond_error('ENTER ENTITY NAME');
} elseif ($company === '') {
    respond_error('ENTER COMPANY');
} elseif ($owner === '') {
    respond_error('ENTER OWNER');
} elseif ($function === '') {
    respond_error('ENTER FUNCTION');
} else {
    respond_ok($departmentclass->update($uid, $ip, $eid, $ename, $company, $owner, $function));
}
