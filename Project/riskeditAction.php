<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/risk/riskClass.php';

$riskClass = new riskClass();

// uid/ip from AuthGuard session
$rid      = $_POST['risk_id']   ?? '';
$name     = $_POST['name']      ?? '';
$rcat     = $_POST['rcat']      ?? '';
$dept     = $_POST['dept']      ?? '';
$process  = $_POST['process']   ?? '';
$cause    = $_POST['cause']     ?? '';
$reviewer = $_POST['reviewer']  ?? '';
$rdate    = $_POST['rdate']     ?? '';
$nominee  = $_POST['nominee']   ?? '';
$date     = date('Y-m-d H:i:s');

respond_ok($riskClass->editRisk($rid, $uid, $ip, $name, $rcat, $dept, $process, $cause, $reviewer, $rdate, $nominee, $date));
