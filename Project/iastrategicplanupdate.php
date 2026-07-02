<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/core/upload_helper.php';
require_once __DIR__ . '/iaplan/iastrategicplanClass.php';

$cls          = new iastrategicplanClass();
$id           = $_POST['id']                ?? '';
$title        = $_POST['title']             ?? '';
$startYear    = $_POST['period_start_year'] ?? '';
$endYear      = $_POST['period_end_year']   ?? '';
$objectives   = $_POST['objectives']        ?? '';
$resourcePlan = $_POST['resource_plan']     ?? '';
$status       = $_POST['status']            ?? 'Draft';

if (!ctype_digit((string)$id))                              respond_error('Invalid plan reference.');
if (trim($title) === '')                                    respond_error('Plan title is required.');
if (!ctype_digit((string)$startYear) || !ctype_digit((string)$endYear)
    || (int)$startYear < 1900 || (int)$startYear > 2200 || (int)$endYear < 1900 || (int)$endYear > 2200) respond_error('Enter valid start and end years.');
if ((int)$endYear < (int)$startYear)                        respond_error('End year cannot be before start year.');
if (trim($objectives) === '')                               respond_error('Strategic objectives are required.');
if (!in_array($status, ['Draft', 'Under Review', 'Approved', 'Retired'], true)) respond_error('Invalid status.');

$existing = $cls->editDetails($id);
if ($existing === null) respond_error('Plan not found.');

$upload = ia_store_upload('file', 'strategic_plans', 'strategic', ['pdf', 'doc', 'docx']);
if (!$upload['ok']) respond_error($upload['error']);

$now    = date('Y-m-d H:i:s');
$result = $cls->update($uid, $ip, $id, $title, $startYear, $endYear, $objectives, $resourcePlan, $status, $upload['filename'], $now);

if ($upload['filename'] !== null && !empty($existing['filename']) && $existing['filename'] !== $upload['filename']) {
    ia_delete_upload($existing['filename']);
}
respond_ok($result);
