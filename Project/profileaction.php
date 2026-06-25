<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; $uid = admin's session uid
require_once __DIR__ . '/login/loginClass.php';

$loginclass = new loginClass();
$edit_uid = $_POST['uid']    ?? ''; // target user being edited (not the session admin)
$fname    = $_POST['fname']  ?? '';
$sname    = $_POST['sname']  ?? '';
$dept     = $_POST['dept']   ?? '';
$gender   = $_POST['gender'] ?? '';
$email    = $_POST['email']  ?? '';
$phone    = $_POST['phone']  ?? '';
$user     = $_POST['user']   ?? '';
$roles    = $_POST['roles']  ?? '';
$access   = $_POST['access'] ?? '';

if ($fname === '') {
    respond_error('FORM ERROR');
} elseif ($edit_uid === '') {
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
} elseif ($user === '') {
    respond_error('FORM ERROR');
} elseif ($access === '') {
    respond_error('FORM ERROR');
} else {
    respond_ok($loginclass->Update($edit_uid, $fname, $sname, $dept, $gender, $email, $phone, $user, $roles, $access));
}
