<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/raf/kriClass.php';

$kriClass = new kriClass();

// uid/ip from AuthGuard session
$pname   = $_POST['p_name'] ?? '';
$rlimit  = $_POST['rlimit'] ?? '';
$fmngt   = $_POST['fmngt']  ?? '';
$tmngt   = $_POST['tmngt']  ?? '';
$fboard  = $_POST['fboard'] ?? '';
$tboard  = $_POST['tboard'] ?? '';
$fmboard = $_POST['fmboard'] ?? '';
$tmboard = $_POST['tmboard'] ?? '';
$pdesc   = $_POST['desc']   ?? '';
$dept    = $_POST['did']    ?? '';

if ($pname === '') {
    respond_error('ENTER PARAMETER NAME');
} elseif ($dept === '') {
    respond_error('ENTER DEPARTMENT');
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
    respond_ok($kriClass->addkriparameter($uid, $ip, $pname, $rlimit, $fmngt, $tmngt, $fboard, $tboard, $fmboard, $tmboard, $pdesc, $dept));
}
