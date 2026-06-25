<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/riskcategoryClass.php';

$riskcatclass = new riskCatClass();

$rcid = $_POST['rcid'] ?? '';

if ($rcid !== '') {
    header('Content-Type: application/json');
    echo json_encode($riskcatclass->editimpact($rcid));
}
