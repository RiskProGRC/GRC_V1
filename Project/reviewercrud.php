<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/reviewerClass.php';
$c = new reviewerClass();
$id = $_POST['id'] ?? '';
if (!ctype_digit((string)$id)) respond_error('Invalid reviewer.');
if (($_POST['mode'] ?? '') === 'delete') {
    $m = $c->delete($id); $m === 'Reviewer deleted successfully' ? respond_ok($m) : respond_error($m);
}
$fname = $_POST['fname'] ?? ''; $sname = $_POST['sname'] ?? ''; $email = $_POST['email'] ?? ''; $phone = $_POST['phone'] ?? '';
if (trim($fname) === '' || trim($sname) === '' || trim($email) === '') respond_error('First name, surname and email are required');
respond_ok($c->update($id, $fname, $sname, $email, $phone));
