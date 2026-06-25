<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid; amendment uses session user
require_once __DIR__ . '/recommend/recommendClass.php';

$recommendclass = new recommendClass();
$rid = $_POST['arid'] ?? '';

if ($rid === '') {
    respond_error('No recommendation selected');
} else {
    respond_ok($recommendclass->ammendrecommend($uid, $rid, date('Y-m-d H:i:s')));
}
