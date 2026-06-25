<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/users/usersClass.php';

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    respond_error('Invalid request token.');
}

$target_uid = $_POST['uid'] ?? '';
if ($target_uid === '') {
    respond_error('Missing user ID');
}

$state = (new usersClass())->toggleAccess($target_uid, $uid, $ip);
respond_ok($state);
