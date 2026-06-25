<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed for delete
require_once __DIR__ . '/action/actionClass.php';
require_once __DIR__ . '/recommend/recommendClass.php';
require_once __DIR__ . '/incident/incidentClass.php';

$actionclass    = new actionClass();
$recommendclass = new recommendClass();
$incidentclass  = new incidentclass();

$aid = $_POST['actionid'] ?? '';

// block delete when action is still linked to a recommendation or incident
$arecommend = $recommendclass->fetchactionrecommend($aid);
$aincident  = $incidentclass->fetchactionincident($aid);

if ($aid == $arecommend) {
    respond_error('CANNOT DELETE ACTION LINKED TO RECOMMENDATION');
} elseif ($aid == $aincident) {
    respond_error('CANNOT DELETE ACTION LINKED TO INCIDENT');
} else {
    respond_ok($actionclass->deleteaction($aid));
}
