<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/iaqa/qaclasses.php';

$cls  = new performanceMatrixClass();
$mode = $_POST['mode'] ?? 'add';
$STATUS = ['On Track', 'At Risk', 'Behind', 'Achieved'];

if ($mode === 'delete') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('KPI not found.');
    respond_ok($cls->remove($id));
}

$year   = $_POST['period_year'] ?? '';
$kpi    = $_POST['kpi_name'] ?? '';
$target = $_POST['target'] ?? '';
$actual = $_POST['actual'] ?? '';
$basis  = $_POST['measurement_basis'] ?? '';
$status = $_POST['status'] ?? 'On Track';
if (!ctype_digit((string)$year) || (int)$year < 1900 || (int)$year > 2200) respond_error('Enter a valid year.');
if (trim($kpi) === '')                    respond_error('KPI name is required.');
if (!in_array($status, $STATUS, true))    respond_error('Invalid status.');

if ($mode === 'update') {
    $id = $_POST['id'] ?? '';
    if (!ctype_digit((string)$id) || $cls->details($id) === null) respond_error('KPI not found.');
    respond_ok($cls->update($uid, $ip, $id, $year, $kpi, $target, $actual, $basis, $status));
}
respond_ok($cls->add($uid, $ip, $year, $kpi, $target, $actual, $basis, $status));
