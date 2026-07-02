<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/engagement/engagementclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';

$plan  = new engagementPlanClass();
$eng   = new engagementClass();
$engId = $_POST['engagement_id'] ?? '';
if (!ctype_digit((string)$engId) || $eng->details($engId) === null) respond_error('Invalid engagement.');

$status = $_POST['status'] ?? 'Draft';
if (!in_array($status, ['Draft', 'Approved'], true)) respond_error('Invalid status.');
foreach (['planned_start', 'exit_meeting', 'draft_issued', 'final_report'] as $df) {
    $v = $_POST[$df] ?? '';
    if ($v !== '' && !DateTime::createFromFormat('Y-m-d', $v)) respond_error('Enter valid dates.');
}

respond_ok($plan->save($uid, $ip, $engId,
    $_POST['objectives'] ?? '', $_POST['scope'] ?? '', $_POST['criteria'] ?? '',
    $_POST['resources_required'] ?? '', $_POST['risks_to_engagement'] ?? '',
    $_POST['planned_start'] ?? '', $_POST['exit_meeting'] ?? '', $_POST['draft_issued'] ?? '', $_POST['final_report'] ?? '', $status));
