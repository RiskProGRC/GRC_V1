<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/risk/riskClass.php';

$riskclass = new riskClass();

// treat type 4 = mitigate; uid/ip from AuthGuard session
$treat   = 4;
$id      = $_POST['assmitigateid'] ?? '';
$apetite = $_POST['apetite']       ?? '';
$action  = $_POST['action']        ?? '';

if ($id === '') {
    respond_error('FORM ERROR');
} elseif ($apetite === '' || $action === '') {
    respond_error('FORM ERROR');
} else {
    respond_ok($riskclass->mitigatetreat($treat, $uid, $ip, $id, $apetite, $action));
}
