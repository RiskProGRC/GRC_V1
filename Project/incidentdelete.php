<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed for delete
require_once __DIR__ . '/incident/incidentClass.php';

$incidentclass = new incidentclass();

$iid = $_POST['incidentid'] ?? '';

if ($iid === '') {
    respond_error('Cannot delete');
} else {
    respond_ok($incidentclass->deleteincident($iid));
}
