<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed for delete
require_once __DIR__ . '/risk/riskClass.php';
require_once __DIR__ . '/control/controlClass.php';

$riskclass    = new riskClass();
$controlclass = new controlClass();

$cid = $_POST['dcid'] ?? '';

// block delete when this control is still linked to a risk assessment
$controlassess = $riskclass->fetchassess($cid);

if ($cid == $controlassess) {
    respond_error('CANNOT DELETE CONTROL IS LINKED TO AN ASSESSMENT');
} else {
    respond_ok($controlclass->deletecontrol($cid));
}
