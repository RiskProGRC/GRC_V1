<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed for delete
require_once __DIR__ . '/risk/riskClass.php';
require_once __DIR__ . '/control/controlClass.php';

$riskclass   = new riskClass();
$controlclass = new controlClass();

$rid = $_POST['dcid'] ?? '';

// block delete when a control is still linked to this risk
$crisk = $controlclass->fetchrisk($rid);

if ($crisk == $rid) {
    respond_error('CANNOT DELETE RISK LINKED TO CONTROL');
} else {
    respond_ok($riskclass->deleteRisk($rid));
}
