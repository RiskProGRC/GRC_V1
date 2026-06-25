<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/users/usersClass.php';

$uname = trim($_GET['uname'] ?? '');
if ($uname === '') {
    respond_error('Missing username');
}

$taken = (new usersClass())->usernameExists($uname);
header('Content-Type: application/json');
echo json_encode(['taken' => $taken]);
