<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/department/departmentClass.php';

$departmentclass = new departmentClass();

$deptid = $_POST['deptid'] ?? '';

if ($deptid !== '') {
    header('Content-Type: application/json');
    echo json_encode($departmentclass->fetchedit($deptid));
}
