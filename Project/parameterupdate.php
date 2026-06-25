<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/raf/kriClass.php';

$kriClass = new kriClass();

// uid/ip from AuthGuard session
$pid     = $_POST['parameterid'] ?? '';
$pname   = $_POST['p_name']      ?? '';
$apetite = $_POST['apetite']     ?? '';
$type    = $_POST['type']        ?? '';
$rlimit  = $_POST['rlimit']      ?? '';
$fmngt   = $_POST['fmngt']       ?? '';
$tmngt   = $_POST['tmngt']       ?? '';
$fboard  = $_POST['fboard']      ?? '';
$tboard  = $_POST['tboard']      ?? '';
$fmboard = $_POST['fmboard']     ?? '';
$tmboard = $_POST['tmboard']     ?? '';

if ($pid === '') {
    respond_error('ERROR');
} elseif ($pname === '') {
    respond_error('ENTER PARAMETER NAME');
} elseif ($apetite === '') {
    respond_error('ENTER APPETITE');
} elseif ($type === '') {
    respond_error('ENTER TYPE');
} elseif ($rlimit === '') {
    respond_error('ENTER RISK APPETITE LIMIT');
} elseif ($tmngt === '') {
    respond_error('ENTER MANAGEMENT TO RANGE');
} elseif ($fboard === '') {
    respond_error('ENTER BOARD FROM RANGE');
} elseif ($tboard === '') {
    respond_error('ENTER BOARD TO RANGE');
} elseif ($fmboard === '') {
    respond_error('ENTER MANAGEMENT BOARD FROM RANGE');
} elseif ($tmboard === '') {
    respond_error('ENTER MANAGEMENT BOARD TO RANGE');
} else {
    respond_ok($kriClass->updateparameter($uid, $ip, $pid, $pname, $apetite, $type, $rlimit, $fmngt, $tmngt, $fboard, $tboard, $fmboard, $tmboard));
}
