<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/control/controlClass.php';

$controlClass = new controlClass();

// uid/ip sourced from AuthGuard session, not POST
$dept_id   = $_POST['cdept_id']  ?? '';
$process   = $_POST['cprocess']  ?? '';
$control   = $_POST['control']   ?? '';
$cstrength = $_POST['cstrength'] ?? '';
$ctype     = $_POST['ctype']     ?? '';
$reviewer  = $_POST['reviewer']  ?? '';
$rdate     = $_POST['rdate']     ?? '';

if ($dept_id === '') {
    respond_error('PLEASE ENTER DEPARTMENT');
} elseif ($process === '') {
    respond_error('PLEASE ENTER PROCESS');
} elseif ($control === '') {
    respond_error('PLEASE ENTER CONTROL');
} elseif ($cstrength === '') {
    respond_error('PLEASE ENTER CONTROL STRENGTH');
} elseif ($ctype === '') {
    respond_error('PLEASE ENTER CONTROL TYPE');
} elseif ($reviewer === '') {
    respond_error('PLEASE ENTER REVIEWER');
} elseif ($rdate === '') {
    respond_error('PLEASE ENTER REVIEW DATE');
} else {
    respond_ok($controlClass->addcontrol($uid, $ip, $dept_id, $process, $control, $cstrength, $ctype, $reviewer, $rdate));
}
