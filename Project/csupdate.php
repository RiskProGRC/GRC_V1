<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/controlstrengthClass.php';

$cstrengthclass = new controlstrengthClass();

$csid   = $_POST['csid']   ?? '';
$csname = $_POST['csname'] ?? '';
$csdesc = $_POST['csdesc'] ?? '';

if ($csid === '') {
    respond_error('FORM IS EMPTY');
} elseif ($csname === '') {
    respond_error('FORM IS EMPTY');
} elseif ($csdesc === '') {
    respond_error('FORM IS EMPTY');
} else {
    respond_ok($cstrengthclass->updatecs($uid, $ip, $csid, $csname, $csdesc));
}
