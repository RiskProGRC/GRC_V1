<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/process/processClass.php';

$processclass = new processClass();

$pid = $_POST['processid'] ?? '';

if ($pid !== '') {
    header('Content-Type: application/json');
    echo json_encode($processclass->fetchedit($pid));
}
