<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/fieldworkclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new reviewNoteClass();
$mode = $_POST['mode'] ?? 'add';
if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Note not found.');
    respond_ok($cls->remove($id));
}
$wpref    = $_POST['wp_ref'] ?? '';
$reviewer = $_POST['reviewer'] ?? '';
$comment  = $_POST['review_comment'] ?? '';
$response = $_POST['preparer_response'] ?? '';
$status   = $_POST['status'] ?? 'Open';
$raised   = $_POST['raised_date'] ?? '';
$cleared  = $_POST['cleared_date'] ?? '';
if (trim($reviewer) === '')                    respond_error('Reviewer is required.');
if (trim($comment) === '')                     respond_error('Review comment is required.');
if (!in_array($status, ['Open', 'Cleared'], true)) respond_error('Invalid status.');
foreach ([$raised, $cleared] as $d) if ($d !== '' && !DateTime::createFromFormat('Y-m-d', $d)) respond_error('Enter valid dates.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Note not found.');
    respond_ok($cls->update($uid, $ip, $id, $wpref, $reviewer, $comment, $response, $status, $raised, $cleared));
}
$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');
respond_ok($cls->add($uid, $ip, $engId, $wpref, $reviewer, $comment, $response, $status, $raised, $cleared));
