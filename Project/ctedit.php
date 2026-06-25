<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/controltypeClass.php';

$ctypeclass = new controltypeClass();

$ctid = $_POST['ctid'] ?? '';

if ($ctid !== '') {
    header('Content-Type: application/json');
    echo json_encode($ctypeclass->editct($ctid));
}
