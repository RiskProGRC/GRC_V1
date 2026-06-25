<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate for fetch endpoint
require_once __DIR__ . '/raf/kriClass.php';

$kriclass = new kriClass();

$pid = $_POST['pid'] ?? '';

if ($pid !== '') {
    header('Content-Type: application/json');
    echo json_encode($kriclass->fetchparameterid($pid));
}
