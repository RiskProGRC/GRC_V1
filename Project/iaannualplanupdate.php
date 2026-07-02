<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/iaplan/iaannualplanClass.php';

$cls          = new iaannualplanClass();
$id           = $_POST['id']            ?? '';
$year         = $_POST['plan_year']     ?? '';
$title        = $_POST['title']         ?? '';
$approvedBy   = $_POST['approved_by']   ?? '';
$approvedDate = $_POST['approved_date'] ?? '';
$status       = $_POST['status']        ?? 'Draft';

if (!ctype_digit((string)$id))           respond_error('Invalid plan reference.');
if (!ctype_digit((string)$year) || (int)$year < 1900 || (int)$year > 2200) respond_error('Enter a valid plan year.');
if (trim($title) === '')                 respond_error('Plan title is required.');
if ($approvedDate !== '' && !DateTime::createFromFormat('Y-m-d', $approvedDate)) respond_error('Enter a valid approved date.');
if (!in_array($status, ['Draft', 'Under Review', 'Approved', 'Retired'], true)) respond_error('Invalid status.');

$existing = $cls->planDetails($id);
if ($existing === null) respond_error('Plan not found.');

$upload = ia_store_upload('file', 'annual_plans', 'annual', ['pdf', 'doc', 'docx', 'xls', 'xlsx']);
if (!$upload['ok']) respond_error($upload['error']);

$now    = date('Y-m-d H:i:s');
$result = $cls->updateplan($uid, $ip, $id, $year, $title, $approvedBy, $approvedDate, $status, $upload['filename'], $now);

if ($upload['filename'] !== null && !empty($existing['filename']) && $existing['filename'] !== $upload['filename']) {
    ia_delete_upload($existing['filename']);
}
respond_ok($result);
