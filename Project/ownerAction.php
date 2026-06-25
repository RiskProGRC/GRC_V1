<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/ownerClass.php';

if (isset($_POST['addowner'])) {
    $fname     = $_POST['fname']     ?? '';
    $sname     = $_POST['sname']     ?? '';
    $email     = $_POST['email']     ?? '';
    $sup       = $_POST['sup']       ?? '';
    $dept      = $_POST['dept']      ?? '';
    $division  = $_POST['division']  ?? '';

    if ($fname !== '' && $sname !== '' && $email !== '') {
        $ownerClass = new ownerClass();
        respond_ok($ownerClass->addOwner($fname, $sname, $email, $sup, $dept, $division));
    } else {
        respond_error('VALUES MISSING');
    }
}
