<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed by method
require_once __DIR__ . '/risk/riskClass.php';

$riskclass = new riskClass();
$rid     = $_POST['rid']       ?? '';
$control = $_POST['controlid'] ?? '';
$dept    = $_POST['dept']      ?? '';

if ($rid === '') {
    respond_error('PLEASE CHOOSE RISK');
} elseif ($control === '') {
    respond_error('PLEASE CHOOSE CONTROL');
} elseif ($dept === '') {
    respond_error('PLEASE CHOOSE DEPARTMENT');
} else {
    respond_ok($riskclass->addriskcontrol($dept, $rid, $control));
}
