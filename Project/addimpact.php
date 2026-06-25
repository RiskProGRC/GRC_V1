<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/impactClass.php';

$impactclass = new impactClass();

$name  = $_POST['impname']  ?? '';
$level = $_POST['implevel'] ?? '';
$desc  = $_POST['impdesc']  ?? '';

if ($name === '') {
    respond_error('insert data');
} elseif ($level === '') {
    respond_error('insert data');
} elseif ($desc === '') {
    respond_error('insert data');
} else {
    respond_ok($impactclass->addImpact($uid, $ip, $name, $level, $desc));
}
