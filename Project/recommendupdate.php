<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/recommend/recommendClass.php';

$recommendclass = new recommendClass();

// uid/ip from AuthGuard session
$rid      = $_POST['rid']         ?? '';
$process  = $_POST['rmdprocess']  ?? '';
$risk     = $_POST['rmdrisk']     ?? '';
$mrc      = $_POST['mrc']         ?? '';
$armc     = $_POST['armc']        ?? '';
$action   = $_POST['action']      ?? '';
$status   = $_POST['status']      ?? '';
$timeline = $_POST['timeline']    ?? '';
$date     = date('Y-m-d H:i:s');

if (empty($rid) || empty($process) || empty($risk) || empty($action) || empty($status) || empty($timeline)) {
    respond_error('ENTER DATA');
} else {
    respond_ok($recommendclass->update($uid, $ip, $rid, $process, $risk, $mrc, $armc, $action, $status, $timeline, $date));
}
