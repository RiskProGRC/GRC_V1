<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/raf/kriClass.php';

$kriClass = new kriClass();

// uid/ip from AuthGuard session
$kriid    = $_POST['upkriid']  ?? '';
$rapetite = $_POST['rapetite'] ?? '';
$date     = $_POST['timeline'] ?? '';

if ($kriid === '') {
    respond_error('ENTER KRI ID');
} elseif ($rapetite === '') {
    respond_error('ENTER RISK PERFORMANCE');
} elseif ($date === '') {
    respond_error('ENTER DATE');
} else {
    respond_ok($kriClass->updatekriperform($uid, $ip, $kriid, $rapetite, $date));
}
