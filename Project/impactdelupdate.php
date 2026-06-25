<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/impactClass.php';

$impactClass = new impactClass();

$iid = $_POST['impactid'] ?? '';

if ($iid !== '') {
    header('Content-Type: application/json');
    echo json_encode($impactClass->delupdate($iid));
}
