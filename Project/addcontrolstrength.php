<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/controlstrengthClass.php';

$cstrengthclass = new controlstrengthClass();

$name = $_POST['name'] ?? '';
$desc = $_POST['desc'] ?? '';

if ($name === '') {
    respond_error('ENTER CONTROL STRENGTH');
} elseif ($desc === '') {
    respond_error('ENTER description');
} else {
    respond_ok($cstrengthclass->addcontrolstrength($uid, $ip, $name, $desc));
}
