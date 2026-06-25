<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed for delete
require_once __DIR__ . '/raf/kriClass.php';

$kriclass = new kriClass();

$rpid = $_POST['pid'] ?? '';

if ($rpid === '') {
    respond_error('Cannot delete');
} else {
    respond_ok($kriclass->deletekri($rpid));
}
