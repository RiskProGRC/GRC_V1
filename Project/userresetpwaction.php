<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/users/usersClass.php';

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    respond_error('Invalid request token.');
}

$target_uid = $_POST['uid']      ?? '';
$temp_pass  = $_POST['new_pass'] ?? '';

if ($target_uid === '' || $temp_pass === '') {
    respond_error('FORM ERROR');
}
if (strlen($temp_pass) < 8) {
    respond_error('Password must be at least 8 characters.');
}

$msg = (new usersClass())->adminResetPassword($target_uid, $temp_pass, $uid, $ip);
respond_ok($msg);
