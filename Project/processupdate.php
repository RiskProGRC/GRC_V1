<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/process/processClass.php';

$processclass = new processClass();

$pid    = $_POST['pid']    ?? '';
$entity = $_POST['entity'] ?? '';
$pname  = $_POST['pname']  ?? '';
$detail = $_POST['detail'] ?? '';

if ($entity === '') {
    respond_error('ENTER COMPANY NAME');
} elseif ($pname === '') {
    respond_error('ENTER PROCESS NAME');
} elseif ($detail === '') {
    respond_error('ENTER DETAILS');
} else {
    respond_ok($processclass->update($uid, $ip, $pid, $entity, $pname, $detail));
}
