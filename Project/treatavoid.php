<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/risk/riskClass.php';

$riskclass = new riskClass();

// treat type 2 = avoid; uid/ip from AuthGuard session
$treat   = 2;
$id      = $_POST['assavoidid'] ?? '';
$apetite = $_POST['apetite']    ?? '';

if ($id === '') {
    respond_error('FORM ERROR');
} elseif ($apetite === '') {
    respond_error('FORM ERROR');
} else {
    respond_ok($riskclass->avoidtreat($treat, $uid, $ip, $id, $apetite));
}
