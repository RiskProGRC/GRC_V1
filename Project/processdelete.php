<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/process/processClass.php';
require_once __DIR__ . '/risk/riskClass.php';

$processclass = new processClass();
$riskClass    = new riskClass();

$pid = $_POST['pdid'] ?? '';

if ($pid === $riskClass->processsearch($pid)) {
    respond_error('CANNOT DELETE!! PROCESS IS LINKED TO A RISK');
} else {
    respond_ok($processclass->delete($pid));
}
