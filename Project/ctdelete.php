<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/controltypeClass.php';

$ctypeclass = new controltypeClass();

$ctid = $_POST['ctdelete'] ?? '';

if ($ctid === '') {
    respond_error('No ID provided');
} else {
    respond_ok($ctypeclass->delete($ctid));
}
