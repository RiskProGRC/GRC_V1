<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate for fetch endpoint
require_once __DIR__ . '/action/actionClass.php';

$actionclass = new actionClass();

$aid = $_POST['aid'] ?? '';

if ($aid !== '') {
    header('Content-Type: application/json');
    echo json_encode($actionclass->fetchaction($aid));
}
