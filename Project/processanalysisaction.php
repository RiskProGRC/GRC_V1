<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/engagementclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new processAnalysisClass();
$mode = $_POST['mode'] ?? 'add';

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Entry not found.');
    respond_ok($cls->remove($id));
}

$pid      = $_POST['process_id'] ?? '';
$name     = $_POST['process_name'] ?? '';
$owner    = $_POST['process_owner'] ?? '';
$inputs   = $_POST['inputs'] ?? '';
$acts     = $_POST['activities'] ?? '';
$outputs  = $_POST['outputs'] ?? '';
$risks    = $_POST['key_risks'] ?? '';
$controls = $_POST['key_controls'] ?? '';
if (trim($name) === '')                            respond_error('Process name is required.');
if ($pid !== '' && !ctype_digit((string)$pid))     respond_error('Invalid process.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Entry not found.');
    respond_ok($cls->update($uid, $ip, $id, $pid, $name, $owner, $inputs, $acts, $outputs, $risks, $controls));
}

$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');
respond_ok($cls->add($uid, $ip, $engId, $pid, $name, $owner, $inputs, $acts, $outputs, $risks, $controls));
