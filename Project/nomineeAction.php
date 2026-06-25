<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/nomineeClass.php';

if (isset($_POST['addNominee'])) {
    $fname = $_POST['fname'] ?? '';
    $sname = $_POST['sname'] ?? '';
    $email = $_POST['email'] ?? '';

    if ($fname !== '' && $sname !== '' && $email !== '') {
        $nomineeClass = new nomineeClass();
        respond_ok($nomineeClass->addNominee($fname, $sname, $email));
    } else {
        respond_error('All fields are required');
    }
}
