<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid; approval uses session user
require_once __DIR__ . '/control/controlClass.php';

$controlclass = new controlClass();
$cid  = $_POST['controlid'] ?? '';

if ($cid === '') {
    respond_error('No control selected');
} else {
    respond_ok($controlclass->approvecontrol($uid, $cid, date('Y-m-d H:i:s')));
}
