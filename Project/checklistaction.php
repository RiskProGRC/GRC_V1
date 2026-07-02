<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/engagementclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new checklistClass();
$mode = $_POST['mode'] ?? 'add';
$STATUS = ['Pending', 'Received', 'Overdue', 'Complete', 'N/A'];
$TYPES  = ['info_request', 'workpaper_file'];

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Item not found.');
    respond_ok($cls->remove($id));
}

$desc      = $_POST['item_description'] ?? '';
$from      = $_POST['requested_from'] ?? '';
$due       = $_POST['due_date'] ?? '';
$completed = $_POST['completed_date'] ?? '';
$status    = $_POST['status'] ?? 'Pending';
$remarks   = $_POST['remarks'] ?? '';
if (trim($desc) === '')                  respond_error('Item description is required.');
if (!in_array($status, $STATUS, true))   respond_error('Invalid status.');
if ($due !== '' && !DateTime::createFromFormat('Y-m-d', $due))             respond_error('Enter a valid due date.');
if ($completed !== '' && !DateTime::createFromFormat('Y-m-d', $completed)) respond_error('Enter a valid completed date.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Item not found.');
    respond_ok($cls->update($uid, $ip, $id, $desc, $from, $due, $completed, $status, $remarks));
}

$engId = $_POST['engagement_id'] ?? '';
$type  = $_POST['checklist_type'] ?? 'info_request';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');
if (!in_array($type, $TYPES, true)) respond_error('Invalid checklist type.');
respond_ok($cls->add($uid, $ip, $engId, $type, $desc, $from, $due, $completed, $status, $remarks));
