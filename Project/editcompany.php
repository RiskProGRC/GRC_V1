<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/company/companyClass.php';

$companyclass = new companyClass();

$cid = $_POST['companyid'] ?? '';

if ($cid !== '') {
    header('Content-Type: application/json');
    echo json_encode($companyclass->fetchedit($cid));
}
