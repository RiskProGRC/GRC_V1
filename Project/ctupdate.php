<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/controltypeClass.php';

$ctypeclass = new controltypeClass();

$ctid   = $_POST['ctid']       ?? '';
$ctname = $_POST['ctypename']  ?? '';
$desc   = $_POST['ctedesc']    ?? '';

if ($ctid === '') {
    respond_error('FORM IS EMPTY');
} elseif ($ctname === '') {
    respond_error('FORM IS EMPTY');
} elseif ($desc === '') {
    respond_error('FORM IS EMPTY');
} else {
    respond_ok($ctypeclass->updatect($uid, $ip, $ctid, $ctname, $desc));
}
