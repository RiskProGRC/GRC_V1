<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/iaqa/qaclasses.php';

$cls  = new qaDocClass();
$mode = $_POST['mode'] ?? 'add';

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id)) respond_error('Invalid document.');
    $row = $cls->details($id);
    if ($row === null) respond_error('Document not found.');
    $msg = $cls->remove($id);
    if ($msg === 'Deleted') { ia_delete_upload($row['filename'] ?? null); respond_ok($msg); }
    respond_error($msg);
}

$year     = $_POST['year'] ?? '';
$desc     = $_POST['description'] ?? '';
$assessor = $_POST['assessor_name'] ?? '';
$status   = $_POST['status'] ?? 'Draft';
if (!ctype_digit((string)$year) || (int)$year < 1900 || (int)$year > 2200) respond_error('Enter a valid year.');
if (trim($desc) === '')                            respond_error('Description is required.');
if (!in_array($status, ['Draft', 'Final'], true))  respond_error('Invalid status.');

$upload = ia_store_upload('file', 'qa_documents', 'qadoc', ['pdf', 'doc', 'docx']);
if (!$upload['ok']) respond_error($upload['error']);
if ($upload['filename'] === null) respond_error('Please choose a file to upload.');

respond_ok($cls->add($uid, $ip, $year, $desc, $assessor, $upload['filename'], $status));
