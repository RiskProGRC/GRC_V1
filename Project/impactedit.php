<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/impactClass.php';

$impactclass = new impactClass();

$iid = $_POST['impactid'] ?? '';

if ($iid !== '') {
    header('Content-Type: application/json');
    echo json_encode($impactclass->editimpact($iid));
}
