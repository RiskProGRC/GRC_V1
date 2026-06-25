<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/risk/riskClass.php';

$riskclass = new riskClass();

// treat type 3 = transfer; uid/ip from AuthGuard session
$treat   = 3;
$id      = $_POST['asstransferid'] ?? '';
$apetite = $_POST['apetite']       ?? '';
$action  = $_POST['action']        ?? '';

if ($id === '') {
    respond_error('FORM ERROR');
} elseif ($apetite === '' || $action === '') {
    respond_error('FORM ERROR');
} else {
    respond_ok($riskclass->transfertreat($treat, $uid, $ip, $id, $apetite, $action));
}
