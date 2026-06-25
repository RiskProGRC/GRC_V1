<?php
// fetch handler — despite the name, this retrieves control details for the edit modal
require_once __DIR__ . '/core/AuthGuard.php'; // session gate for fetch endpoint
require_once __DIR__ . '/control/controlClass.php';

$controlclass = new controlClass();

$cid = $_POST['cid'] ?? '';

if ($cid !== '') {
    header('Content-Type: application/json');
    echo json_encode($controlclass->fetchcdetails($cid));
}
