<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid; amendment uses session user
require_once __DIR__ . '/action/actionClass.php';

$actionclass = new actionClass();
$aid = $_POST['aaid'] ?? '';

if ($aid === '') {
    respond_error('No action selected');
} else {
    respond_ok($actionclass->ammendaction($uid, $aid, date('Y-m-d H:i:s')));
}
