<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/iaqa/qaclasses.php';

$cls  = new surveyClass();
$mode = $_POST['mode'] ?? 'add';
$TYPES = ['client', 'audit_committee', 'senior_mgmt', 'staff'];

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Response not found.');
    respond_ok($cls->remove($id));
}

$year   = $_POST['period_year'] ?? '';
$name   = $_POST['respondent_name'] ?? '';
$role   = $_POST['respondent_role'] ?? '';
$score  = $_POST['overall_score'] ?? '';
$comm   = $_POST['comments'] ?? '';
$subm   = $_POST['submitted_at'] ?? '';
if (!ctype_digit((string)$year) || (int)$year < 1900 || (int)$year > 2200) respond_error('Enter a valid year.');
if ($score !== '' && !in_array($score, ['1', '2', '3', '4', '5'], true)) respond_error('Score must be 1-5.');
if ($subm !== '' && !DateTime::createFromFormat('Y-m-d', $subm)) respond_error('Enter a valid submission date.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('Response not found.');
    respond_ok($cls->update($uid, $ip, $id, $year, $name, $role, $score, $comm, $subm));
}

$type  = $_POST['survey_type'] ?? '';
$engId = $_POST['engagement_id'] ?? '';
if (!in_array($type, $TYPES, true)) respond_error('Select a valid survey type.');
if ($engId !== '' && !ctype_digit((string)$engId)) respond_error('Invalid engagement.');
respond_ok($cls->add($uid, $ip, $type, $year, $engId, $name, $role, $score, $comm, $subm));
