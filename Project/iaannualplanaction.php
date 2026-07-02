<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/iaplan/iaannualplanClass.php';

$cls          = new iaannualplanClass();
$year         = $_POST['plan_year']     ?? '';
$title        = $_POST['title']         ?? '';
$approvedBy   = $_POST['approved_by']   ?? '';
$approvedDate = $_POST['approved_date'] ?? '';
$status       = $_POST['status']        ?? 'Draft';

if (!ctype_digit((string)$year) || (int)$year < 1900 || (int)$year > 2200) respond_error('Enter a valid plan year.');
if (trim($title) === '')                 respond_error('Plan title is required.');
if ($approvedDate !== '' && !DateTime::createFromFormat('Y-m-d', $approvedDate)) respond_error('Enter a valid approved date.');
if (!in_array($status, ['Draft', 'Under Review', 'Approved', 'Retired'], true)) respond_error('Invalid status.');

$upload = ia_store_upload('file', 'annual_plans', 'annual', ['pdf', 'doc', 'docx', 'xls', 'xlsx']);
if (!$upload['ok']) respond_error($upload['error']);

respond_ok($cls->addplan($uid, $ip, $year, $title, $approvedBy, $approvedDate, $status, $upload['filename']));
