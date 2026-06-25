<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/recommend/recommendClass.php';

$recommendclass = new recommendClass();

// uid/ip from AuthGuard session
$dept     = $_POST['rdept_id']    ?? '';
$process  = $_POST['rmdprocess']  ?? '';
$risk     = $_POST['rmdrisk']     ?? '';
$mrc      = $_POST['mrc']         ?? '';
$armc     = $_POST['armc']        ?? '';
$action   = $_POST['action']      ?? '';
$status   = $_POST['status']      ?? '';
$timeline = $_POST['timeline']    ?? '';

if (empty($dept) || empty($process) || empty($risk) || empty($action) || empty($status) || empty($timeline)) {
    respond_error('ENTER DATA');
} else {
    respond_ok($recommendclass->addrecommend($uid, $ip, $dept, $process, $risk, $mrc, $armc, $action, $status, $timeline));
}
