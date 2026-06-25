<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/controltypeClass.php';

$ctypeclass = new controltypeClass();

$name = $_POST['ctname']  ?? '';
$desc = $_POST['ctdesc']  ?? '';

if ($name === '') {
    respond_error('insert data');
} elseif ($desc === '') {
    respond_error('insert data');
} else {
    respond_ok($ctypeclass->addcontroltype($uid, $ip, $name, $desc));
}
