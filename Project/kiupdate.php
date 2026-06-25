<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/keyindicator/keyindicatorClass.php';

$kiclass = new kiClass();

// uid/ip from AuthGuard session
$kiid    = $_POST['kiid']    ?? '';
$process = $_POST['process'] ?? '';
$risk    = $_POST['risk']    ?? '';
$ki      = $_POST['ki']      ?? '';
$owner   = $_POST['owner']   ?? '';
$date    = date('Y-m-d H:i:s');

respond_ok($kiclass->update($uid, $ip, $kiid, $process, $risk, $ki, $owner, $date));
