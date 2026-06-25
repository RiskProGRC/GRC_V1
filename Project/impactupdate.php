<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/impactClass.php';

$impactclass = new impactClass();

$iid   = $_POST['iid']     ?? '';
$name  = $_POST['name']    ?? '';
$level = $_POST['level']   ?? '';
$desc  = $_POST['impdesc'] ?? '';

if ($iid === '') {
    respond_error('FORM IS EMPTY');
} elseif ($name === '') {
    respond_error('FORM IS EMPTY');
} elseif ($level === '') {
    respond_error('FORM IS EMPTY');
} elseif ($desc === '') {
    respond_error('FORM IS EMPTY');
} else {
    respond_ok($impactclass->updateimpact($uid, $ip, $iid, $name, $level, $desc));
}
