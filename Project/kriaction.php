<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/raf/kriClass.php';

$kriClass = new kriClass();

// uid/ip from AuthGuard session
$kpi    = $_POST['kpi']    ?? '';
$kri    = $_POST['kri']    ?? '';
$perform = $_POST['perform'] ?? '';
$action = $_POST['action'] ?? '';
$date   = $_POST['date']   ?? '';
$dept   = $_POST['did']    ?? '';
$b_obj  = $_POST['b_obj']  ?? '';
$owner  = $_POST['owner']  ?? '';

if ($kpi === '') {
    respond_error('ENTER KRA');
} elseif ($kri === '') {
    respond_error('ENTER RISK APPETITE FRAMEWORK');
} elseif ($perform === '') {
    respond_error('ENTER PERFORMANCE');
} elseif ($action === '') {
    respond_error('ENTER ACTION');
} elseif ($date === '') {
    respond_error('ENTER DATE');
} elseif ($dept === '') {
    respond_error('ENTER DEPARTMENT');
} elseif ($b_obj === '') {
    respond_error('ENTER BUSINESS OBJECTIVE');
} elseif ($owner === '') {
    respond_error('ENTER OWNER');
} else {
    // addkrientry inserts into the kri table; addkri (different) inserts into performance
    respond_ok($kriClass->addkrientry($uid, $ip, $kpi, $kri, $perform, $action, $date, $dept, $b_obj, $owner));
}
