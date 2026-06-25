<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/likelihoodClass.php';

$likelyclass = new likelihoodClass();

$name  = $_POST['name']  ?? '';
$level = $_POST['level'] ?? '';
$desc  = $_POST['ldesc'] ?? '';

if ($name === '') {
    respond_error('insert data');
} elseif ($level === '') {
    respond_error('insert data');
} elseif ($desc === '') {
    respond_error('insert data');
} else {
    respond_ok($likelyclass->addlikely($uid, $ip, $name, $level, $desc));
}
