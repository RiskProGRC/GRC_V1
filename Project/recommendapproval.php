<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid; approval uses session user
require_once __DIR__ . '/recommend/recommendClass.php';

$recommendclass = new recommendClass();
$rid = $_POST['rcmdid'] ?? '';

if ($rid === '') {
    respond_error('No recommendation selected');
} else {
    respond_ok($recommendclass->approverecommend($uid, $rid, date('Y-m-d H:i:s')));
}
