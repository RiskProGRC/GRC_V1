<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/risk/riskClass.php';

$riskclass = new riskClass();

// treat type 1 = accept; uid/ip from AuthGuard session
$treat   = 1;
$id      = $_POST['assmtid'] ?? '';
$apetite = $_POST['apetite'] ?? '';
$action  = $_POST['action']  ?? '';

if ($id === '') {
    respond_error('FORM ERROR');
} elseif ($apetite === '' || $action === '') {
    respond_error('FORM ERROR');
} else {
    respond_ok($riskclass->accepttreat($treat, $uid, $ip, $id, $apetite, $action));
}
