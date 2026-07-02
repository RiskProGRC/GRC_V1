<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/engagementclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new ethicsAckClass();
$mode = $_POST['mode'] ?? 'add';

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Entry not found.');
    respond_ok($cls->remove($id));
}

$name = $_POST['auditor_name'] ?? '';
$text = $_POST['acknowledgement_text'] ?? '';
$date = $_POST['signed_date'] ?? '';
if (trim($name) === '') respond_error('Auditor name is required.');
if (trim($text) === '') respond_error('Acknowledgement statement is required.');
if ($date !== '' && !DateTime::createFromFormat('Y-m-d', $date)) respond_error('Enter a valid signed date.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Entry not found.');
    respond_ok($cls->update($uid, $ip, $id, $name, $text, $date));
}

$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');
respond_ok($cls->add($uid, $ip, $engId, $name, $text, $date));
