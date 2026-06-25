<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/raf/kriClass.php';

$kriClass = new kriClass();

// uid/ip from AuthGuard session
$kriid   = $_POST['kriid']   ?? '';
$kpi     = $_POST['kpi']     ?? '';
$kri     = $_POST['kri']     ?? '';
$perform = $_POST['perform'] ?? '';
$action  = $_POST['action']  ?? '';
$b_obj   = $_POST['b_obj']   ?? '';
$date    = $_POST['date']    ?? '';

if ($kriid === '') {
    respond_error('ERROR');
} elseif ($kpi === '') {
    respond_error('ENTER RISK APPETITE FRAMEWORK');
} elseif ($kri === '') {
    respond_error('ENTER RISK APPETITE FRAMEWORK');
} elseif ($perform === '') {
    respond_error('ENTER PERFORMANCE');
} elseif ($action === '') {
    respond_error('ENTER ACTION');
} elseif ($b_obj === '') {
    respond_error('ENTER OBJECTIVES');
} elseif ($date === '') {
    respond_error('ENTER DATE');
} else {
    respond_ok($kriClass->updatekri($uid, $ip, $kriid, $kpi, $kri, $perform, $action, $b_obj, $date));
}
