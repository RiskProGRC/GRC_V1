<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/impactClass.php';

$impactclass = new impactClass();

$iid = $_POST['impdelete'] ?? '';

if ($iid === '') {
    respond_error('No ID provided');
} else {
    respond_ok($impactclass->delete($iid));
}
