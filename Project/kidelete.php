<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed for delete
require_once __DIR__ . '/keyindicator/keyindicatorClass.php';

$kiclass = new kiClass();

$kiid = $_POST['dcid'] ?? '';

if ($kiid === '') {
    respond_error('Cannot delete');
} else {
    respond_ok($kiclass->deleteki($kiid));
}
