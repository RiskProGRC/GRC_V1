<?php
require_once __DIR__ . '/core/AuthGuard.php';        // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/iacharter/iacharterClass.php';

$charterclass = new iacharterClass();

$id = $_POST['id'] ?? '';
if (trim($id) === '' || !ctype_digit((string)$id)) {
    respond_error('Invalid charter reference.');
}

$row = $charterclass->editDetails($id);
if ($row === null) {
    respond_error('Charter not found.');
}

$msg = $charterclass->delete($id);
if ($msg === 'Charter Deleted') {
    ia_delete_upload($row['filename'] ?? null); // remove the attached document from disk
    ActivityLogger::log($charterclass, $uid, 'Internal Audit', "Deleted Charter id=$id", $ip);
    respond_ok($msg);
}
respond_error($msg);
