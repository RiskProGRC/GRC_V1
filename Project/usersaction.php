<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/users/usersClass.php';

if (!hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
    respond_error('Invalid request token.');
}

$usersclass = new usersClass();

$uname  = $_POST['uname']    ?? '';
$fname  = $_POST['fname']    ?? '';
$sname  = $_POST['sname']    ?? '';
$dept   = $_POST['dept']     ?? '';
$gender = $_POST['gender']   ?? '';
$email  = $_POST['email']    ?? '';
$phone  = $_POST['phone']    ?? '';
$roles  = $_POST['roles']    ?? '';
$pass   = $_POST['password'] ?? '';
$hpass  = password_hash($pass, PASSWORD_DEFAULT);
$user_type = 0;

if ($fname === '') {
    respond_error('FORM ERROR');
} elseif ($uname === '') {
    respond_error('FORM ERROR');
} elseif ($sname === '') {
    respond_error('FORM ERROR');
} elseif ($dept === '') {
    respond_error('FORM ERROR');
} elseif ($gender === '') {
    respond_error('FORM ERROR');
} elseif ($email === '') {
    respond_error('FORM ERROR');
} elseif ($phone === '') {
    respond_error('FORM ERROR');
} elseif ($pass === '') {
    respond_error('FORM ERROR');
} else {
    respond_ok($usersclass->addusers($fname, $sname, $dept, $gender, $email, $phone, $uname, $hpass, $roles, $user_type));
}
