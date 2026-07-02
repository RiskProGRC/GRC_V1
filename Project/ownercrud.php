<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/ownerClass.php';
$c = new ownerClass();
$id = $_POST['id'] ?? '';
if (!ctype_digit((string)$id)) respond_error('Invalid owner.');
if (($_POST['mode'] ?? '') === 'delete') {
    $m = $c->delete($id); $m === 'Owner deleted successfully' ? respond_ok($m) : respond_error($m);
}
$fname = $_POST['fname'] ?? ''; $sname = $_POST['sname'] ?? ''; $email = $_POST['email'] ?? '';
$sup = $_POST['sup'] ?? ''; $dept = $_POST['dept'] ?? ''; $division = $_POST['division'] ?? '';
if (trim($fname) === '' || trim($sname) === '' || trim($email) === '') respond_error('First name, surname and email are required');
respond_ok($c->update($id, $fname, $sname, $email, $sup, $dept, $division));
