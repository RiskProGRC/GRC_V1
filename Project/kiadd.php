<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/keyindicator/keyindicatorClass.php';

$kiclass = new kiClass();

// uid/ip from AuthGuard session
$dept_id   = $_POST['dept_id']   ?? '';
$processid = $_POST['processid'] ?? '';
$risk      = $_POST['selectrisk'] ?? '';
$ki        = $_POST['ki']        ?? '';
$owner     = $_POST['owner']     ?? '';

if ($processid === '') {
    respond_error('ENTER PROCESS');
} elseif ($risk === '') {
    respond_error('ENTER RISK');
} elseif ($dept_id === '') {
    respond_error('ENTER DEPARTMENT');
} elseif ($ki === '') {
    respond_error('ENTER KEY INDICATOR');
} elseif ($owner === '') {
    respond_error('ENTER OWNER');
} else {
    respond_ok($kiclass->addkeyindicator($dept_id, $uid, $ip, $processid, $risk, $ki, $owner));
}
