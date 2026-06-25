<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed by method
require_once __DIR__ . '/control/controlClass.php';

$controlclass = new controlClass();
$cid = $_POST['dcid'] ?? '';
$rid = $_POST['rid']  ?? '';

if ($cid === '') {
    respond_error('ERROR: Missing control ID');
} elseif ($rid === '') {
    respond_error('NO RISK');
} else {
    respond_ok($controlclass->updateriskcontrol($cid, $rid));
}
