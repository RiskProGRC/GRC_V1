<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/control/controlClass.php';

$controlclass = new controlClass();

// uid/ip from AuthGuard session
$cid       = $_POST['cid']       ?? '';
$process   = $_POST['cprocess']  ?? '';
$control   = $_POST['control']   ?? '';
$cstrength = $_POST['cstrength'] ?? '';
$ctype     = $_POST['ctype']     ?? '';
$reviewer  = $_POST['reviewer']  ?? '';
$rdate     = $_POST['rdate']     ?? '';
$date      = date('Y-m-d H:i:s');

respond_ok($controlclass->updatecontrol($cid, $uid, $ip, $process, $control, $cstrength, $ctype, $reviewer, $rdate, $date));
