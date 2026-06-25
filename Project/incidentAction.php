<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/incident/incidentClass.php';

$incidentClass = new incidentclass();

// uid/ip from AuthGuard session
$dept_id  = $_POST['dept_id']    ?? '';
$incident = $_POST['incident']   ?? '';
$process  = $_POST['processid']  ?? '';
$risk     = $_POST['selectrisk'] ?? '';
$dol      = $_POST['dol']        ?? '';
$actual   = $_POST['actual']     ?? '';
$expected = $_POST['expected']   ?? '';
$potential = $_POST['potential'] ?? '';
$recovery = $_POST['recovery']   ?? '';
$action   = $_POST['action']     ?? '';

if ($incident === '') {
    respond_error('PLEASE ENTER INCIDENT DESCRIPTION');
} elseif ($dept_id === '') {
    respond_error('FORM ERROR');
} elseif ($process === '') {
    respond_error('PLEASE ENTER PROCESS');
} elseif ($risk === '') {
    respond_error('PLEASE ENTER RISK');
} elseif ($dol === '') {
    respond_error('PLEASE ENTER DATE OF LOSS');
} elseif ($actual === '') {
    respond_error('PLEASE ENTER ACTUAL LOSS');
} elseif ($expected === '') {
    respond_error('PLEASE ENTER EXPECTED LOSS');
} elseif ($potential === '') {
    respond_error('PLEASE ENTER POTENTIAL LOSS');
} elseif ($recovery === '') {
    respond_error('PLEASE ENTER ESTIMATED RECOVERY');
} elseif ($action === '') {
    respond_error('PLEASE ENTER ACTION');
} else {
    respond_ok($incidentClass->addincident($uid, $ip, $incident, $dept_id, $process, $risk, $dol, $actual, $expected, $potential, $recovery, $action));
}
