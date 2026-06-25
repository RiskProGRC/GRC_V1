<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, respond_ok/error
require_once __DIR__ . '/risk/riskClass.php';

$riskclass = new riskClass();

// uid from AuthGuard session; approval method does not require ip
$rid  = $_POST['dcid'] ?? '';
$time = date('Y-m-d H:i:s');

respond_ok($riskclass->approverisk($uid, $rid, $time));
