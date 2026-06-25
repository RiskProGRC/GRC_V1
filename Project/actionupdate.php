<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/action/actionClass.php';

$actionclass = new actionClass();

// uid/ip from AuthGuard session
$cid      = $_POST['aid']       ?? '';
$process  = $_POST['aprocess']  ?? '';
$risk     = $_POST['arisk']     ?? '';
$action   = $_POST['action']    ?? '';
$status   = $_POST['status']    ?? '';
$priority = $_POST['priority']  ?? '';
$timeline = $_POST['timeline']  ?? '';
$date     = date('Y-m-d H:i:s');

if ($cid === '') {
    respond_error('PLEASE CHOOSE ACTION');
} elseif ($process === '') {
    respond_error('PROCESS IS BLANK');
} elseif ($risk === '') {
    respond_error('RISK IS BLANK');
} elseif ($action === '') {
    respond_error('ACTION IS BLANK');
} elseif ($status === '') {
    respond_error('STATUS IS BLANK');
} elseif ($priority === '') {
    respond_error('PRIORITY IS BLANK');
} elseif ($timeline === '') {
    respond_error('TIMELINE IS BLANK');
} else {
    respond_ok($actionclass->updateaction($uid, $ip, $cid, $process, $risk, $action, $status, $priority, $timeline, $date));
}
