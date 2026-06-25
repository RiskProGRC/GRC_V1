<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid; amendment uses session user
require_once __DIR__ . '/control/controlClass.php';

$controlclass = new controlClass();
$cid = $_POST['acid'] ?? '';

if ($cid === '') {
    respond_error('No control selected');
} else {
    respond_ok($controlclass->ammendcontrol($uid, $cid, date('Y-m-d H:i:s')));
}
