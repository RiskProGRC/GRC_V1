<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/controlstrengthClass.php';

$cstrengthclass = new controlstrengthClass();

$csid = $_POST['csdelete'] ?? '';

if ($csid === '') {
    respond_error('No ID provided');
} else {
    respond_ok($cstrengthclass->delete($csid));
}
