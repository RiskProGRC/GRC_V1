<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/raf/kriClass.php';

$kriclass = new kriClass();

// uid/ip from AuthGuard session
$process     = $_POST['process']     ?? '';
$risk        = $_POST['risk']        ?? '';
$measure     = $_POST['measure']     ?? '';
$apetite     = $_POST['apetite']     ?? '';
$rapetite    = $_POST['rapetite']    ?? '';
$description = $_POST['description'] ?? '';
$timeline    = $_POST['timeline']    ?? '';

if ($risk === '') {
    respond_error('PLEASE CHOOSE RISK');
} elseif ($process === '') {
    respond_error('PLEASE CHOOSE PROCESS');
} elseif ($measure === '') {
    respond_error('PLEASE CHOOSE CONTROL');
} elseif ($apetite === '') {
    respond_error('PLEASE CHOOSE APPETITE');
} elseif ($rapetite === '') {
    respond_error('PLEASE CHOOSE RISK APPETITE');
} elseif ($description === '') {
    respond_error('PLEASE ENTER DESCRIPTION');
} elseif ($timeline === '') {
    respond_error('PLEASE CHOOSE TIMELINE');
} else {
    respond_ok($kriclass->addkri($uid, $ip, $process, $risk, $measure, $apetite, $rapetite, $description, $timeline));
}
