<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/engagementclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new auditProgramClass();
$mode = $_POST['mode'] ?? 'add';
$STATUS = ['Planned', 'In Progress', 'Completed'];

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Step not found.');
    respond_ok($cls->remove($id));
}

$obj     = $_POST['objective'] ?? '';
$risk    = $_POST['risk_addressed'] ?? '';
$control = $_POST['control_tested'] ?? '';
$proc    = $_POST['test_procedure'] ?? '';
$sample  = $_POST['sample_size'] ?? '';
$wpref   = $_POST['wp_ref'] ?? '';
$status  = $_POST['status'] ?? 'Planned';
if (trim($obj) === '')                   respond_error('Objective is required.');
if (trim($proc) === '')                  respond_error('Test procedure is required.');
if (!in_array($status, $STATUS, true))   respond_error('Invalid status.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Step not found.');
    respond_ok($cls->update($uid, $ip, $id, $obj, $risk, $control, $proc, $sample, $wpref, $status));
}

$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');
respond_ok($cls->add($uid, $ip, $engId, $obj, $risk, $control, $proc, $sample, $wpref, $status));
