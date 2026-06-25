<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/process/processClass.php';

$processClass = new processClass();

$name   = $_POST['name']   ?? '';
$dept   = $_POST['dept']   ?? '';
$detail = $_POST['detail'] ?? '';

if ($dept === '') {
    respond_error('CHOOSE Department');
} elseif ($name === '') {
    respond_error('ENTER Process Name');
} elseif ($detail === '') {
    respond_error('ENTER Process Detail');
} else {
    respond_ok($processClass->addProcess($uid, $ip, $name, $dept, $detail));
}
