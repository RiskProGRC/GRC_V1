<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/users/usersClass.php';
require_once __DIR__ . '/department/departmentClass.php';

$uc       = new usersClass();
$deptClass = new departmentClass();
$users    = $uc->fetchusers();

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="users_' . date('Y-m-d') . '.csv"');
header('Cache-Control: no-cache, no-store, must-revalidate');

$out = fopen('php://output', 'w');
fputcsv($out, ['User ID', 'First Name', 'Last Name', 'Username', 'Email', 'Phone', 'Gender', 'Department', 'Role', 'Status']);

foreach ($users as $u) {
    fputcsv($out, [
        'UID00' . $u['id'],
        $u['fname'],
        $u['sname'],
        $u['username'],
        $u['email'],
        $u['phone'],
        $u['gender'],
        $deptClass->deptJoins((string)$u['dept_id']),
        ($u['roles'] == 1 ? 'Administrator' : 'User'),
        ($u['access'] == 1 ? 'Active' : 'Suspended'),
    ]);
}

fclose($out);
