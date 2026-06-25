<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/likelihoodClass.php';

$likelyclass = new likelihoodClass();

$lid   = $_POST['lid']   ?? '';
$name  = $_POST['name']  ?? '';
$level = $_POST['level'] ?? '';
$desc  = $_POST['ldesc'] ?? '';

if ($lid === '') {
    respond_error('FORM IS EMPTY');
} elseif ($name === '') {
    respond_error('FORM IS EMPTY');
} elseif ($level === '') {
    respond_error('FORM IS EMPTY');
} elseif ($desc === '') {
    respond_error('FORM IS EMPTY');
} else {
    respond_ok($likelyclass->updatelikely($uid, $ip, $lid, $name, $level, $desc));
}
