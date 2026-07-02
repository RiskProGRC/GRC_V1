<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/engagementclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new relianceClass();
$mode = $_POST['mode'] ?? 'add';

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Entry not found.');
    respond_ok($cls->remove($id));
}

$provider = $_POST['assurance_provider'] ?? '';
$area     = $_POST['scope_area'] ?? '';
$basis    = $_POST['reliance_basis'] ?? '';
if (trim($provider) === '') respond_error('Assurance provider is required.');
if (trim($area) === '')     respond_error('Scope area is required.');
if (trim($basis) === '')    respond_error('Reliance basis is required.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Entry not found.');
    respond_ok($cls->update($uid, $ip, $id, $provider, $area, $basis));
}

$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');
respond_ok($cls->add($uid, $ip, $engId, $provider, $area, $basis));
