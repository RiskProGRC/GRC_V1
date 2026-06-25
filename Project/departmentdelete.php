<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/department/departmentClass.php';
require_once __DIR__ . '/process/processClass.php';

$departmentclass = new departmentClass();
$processClass    = new processClass();

$deptid = $_POST['entityid'] ?? '';

if ($deptid === $processClass->entitysearch($deptid)) {
    respond_error('CANNOT DELETE!! ENTITY IS LINKED TO A PROCESS');
} else {
    respond_ok($departmentclass->delete($deptid));
}
