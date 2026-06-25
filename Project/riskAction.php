<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/risk/riskClass.php';

$riskClass = new riskClass();

// read POST fields; uid/ip come from AuthGuard session
$name        = $_POST['name']        ?? '';
$rcat        = $_POST['rcat']        ?? '';
$dept        = $_POST['dept']        ?? '';
$process     = $_POST['process']     ?? '';
$cause       = $_POST['cause']       ?? '';
$consequence = $_POST['consequence'] ?? '';
$reviewer    = $_POST['reviewer']    ?? '';
$rdate       = $_POST['rdate']       ?? '';
$nominee     = $_POST['nominee']     ?? '';
$assess      = 0;
$approval    = 1;

if ($name === '') {
    respond_error('ENTER INHERENT RISK');
} elseif ($rcat === '') {
    respond_error('ENTER RISK CATEGORY');
} elseif ($dept === '') {
    respond_error('ENTER DEPARTMENT');
} elseif ($process === '') {
    respond_error('ENTER PROCESS');
} elseif ($cause === '') {
    respond_error('ENTER CAUSE');
} elseif ($consequence === '') {
    respond_error('ENTER CONSEQUENCE');
} elseif ($reviewer === '') {
    respond_error('ENTER REVIEWER');
} elseif ($rdate === '') {
    respond_error('ENTER REVIEW DATE');
} else {
    respond_ok($riskClass->addRisk($uid, $ip, $name, $rcat, $dept, $process, $cause, $consequence, $assess, $reviewer, $rdate, $nominee, $approval));
}
