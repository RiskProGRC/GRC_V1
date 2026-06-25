<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid; rejection uses session user
require_once __DIR__ . '/risk/riskClass.php';

$riskclass = new riskClass();
$rid = $_POST['rejrid'] ?? '';

if ($rid === '') {
    respond_error('No risk selected');
} else {
    respond_ok($riskclass->rejectrisk($uid, $rid, date('Y-m-d H:i:s')));
}
