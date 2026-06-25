<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/action/actionClass.php';

$actionClass = new actionClass();

// uid/ip from AuthGuard session
$dept_id  = $_POST['adept_id']  ?? '';
$process  = $_POST['aprocess']  ?? '';
$risk     = $_POST['arisk']     ?? '';
$action   = $_POST['action']    ?? '';
$status   = $_POST['status']    ?? '';
$priority = $_POST['priority']  ?? '';
$timeline = $_POST['timeline']  ?? '';

if ($process === '') {
    respond_error('ENTER PROCESS DATA');
} elseif ($dept_id === '') {
    respond_error('FORM ERROR');
} elseif ($risk === '') {
    respond_error('ENTER RISK DATA');
} elseif ($action === '') {
    respond_error('ENTER ACTION DATA');
} elseif ($status === '') {
    respond_error('ENTER STATUS DATA');
} elseif ($priority === '') {
    respond_error('ENTER PRIORITY DATA');
} elseif ($timeline === '') {
    respond_error('ENTER TIMELINE DATA');
} else {
    respond_ok($actionClass->addaction($uid, $ip, $dept_id, $process, $risk, $action, $status, $priority, $timeline));
}
