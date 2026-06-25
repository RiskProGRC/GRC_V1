<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/controlstrengthClass.php';

$cstrengthclass = new controlstrengthClass();

$csid = $_POST['csid'] ?? '';

if ($csid !== '') {
    header('Content-Type: application/json');
    echo json_encode($cstrengthclass->editcs($csid));
}
