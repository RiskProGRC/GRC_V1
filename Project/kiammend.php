<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid; amendment uses session user
require_once __DIR__ . '/keyindicator/keyindicatorClass.php';

$kiclass = new kiClass();
$akid = $_POST['akiid'] ?? '';

if ($akid === '') {
    respond_error('No KI selected');
} else {
    respond_ok($kiclass->ammendki($uid, $akid, date('Y-m-d H:i:s')));
}
