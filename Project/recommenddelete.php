<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed for delete
require_once __DIR__ . '/recommend/recommendClass.php';

$recommendclass = new recommendClass();

$rid = $_POST['rid'] ?? '';

if ($rid === '') {
    respond_error('Cannot delete');
} else {
    respond_ok($recommendclass->delete($rid));
}
