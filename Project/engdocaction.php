<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/engagement/fieldworkclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$cls  = new engDocClass();
$mode = $_POST['mode'] ?? 'add';

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id)) respond_error('Invalid document.');
    $row = $cls->details($id);
    if ($row === null) respond_error('Document not found.');
    $msg = $cls->remove($id);
    if ($msg === 'Deleted') {
        ia_delete_upload($row['filename'] ?? null);
        respond_ok($msg);
    }
    respond_error($msg);
}

$engId   = $_POST['engagement_id'] ?? '';
$docType = $_POST['doc_type'] ?? '';
$desc    = $_POST['description'] ?? '';
if (!ctype_digit((string)$engId) || (new engagementClass())->details($engId) === null) respond_error('Invalid engagement.');

$upload = ia_store_upload('file', 'engagement_docs', 'engdoc');
if (!$upload['ok']) respond_error($upload['error']);
if ($upload['filename'] === null) respond_error('Please choose a file to upload.');

respond_ok($cls->add($uid, $ip, $engId, $docType, $upload['filename'], $desc));
