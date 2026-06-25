<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate for fetch endpoint
require_once __DIR__ . '/raf/kriClass.php';

$kriClass = new kriClass();

$kriid = $_POST['kriid'] ?? '';

if ($kriid !== '') {
    header('Content-Type: application/json');
    echo json_encode($kriClass->fetchkriid($kriid));
}
