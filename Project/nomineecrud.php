<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/nomineeClass.php';
$c = new nomineeClass();
$id = $_POST['id'] ?? '';
if (!ctype_digit((string)$id) || $c->editDetails($id) === null) respond_error('Nominee not found.');
if (($_POST['mode'] ?? '') === 'delete') {
    $m = $c->delete($id); $m === 'Nominee deleted successfully' ? respond_ok($m) : respond_error($m);
}
$fname = $_POST['fname'] ?? ''; $sname = $_POST['sname'] ?? ''; $email = $_POST['email'] ?? '';
if (trim($fname) === '' || trim($sname) === '' || trim($email) === '') respond_error('All fields are required');
respond_ok($c->update($id, $fname, $sname, $email));
