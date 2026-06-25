<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate for fetch endpoint
require_once __DIR__ . '/incident/incidentClass.php';

$incidentclass = new incidentclass();

$iid = $_POST['incedentid'] ?? '';

if ($iid !== '') {
    header('Content-Type: application/json');
    echo json_encode($incidentclass->fetcheditincident($iid));
}
