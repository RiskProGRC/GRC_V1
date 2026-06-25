<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate for fetch endpoint
require_once __DIR__ . '/keyindicator/keyindicatorClass.php';

$kiclass = new kiClass();

$kiid = $_POST['kiid'] ?? '';

if ($kiid !== '') {
    header('Content-Type: application/json');
    echo json_encode($kiclass->fetchedit($kiid));
}
