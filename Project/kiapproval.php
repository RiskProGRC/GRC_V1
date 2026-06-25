<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid; approval uses session user
require_once __DIR__ . '/keyindicator/keyindicatorClass.php';

$kiclass = new kiClass();
$kiid = $_POST['kiid'] ?? '';

if ($kiid === '') {
    respond_error('No KI selected');
} else {
    respond_ok($kiclass->approveki($uid, $kiid, date('Y-m-d H:i:s')));
}
