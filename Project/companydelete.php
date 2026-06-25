<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; no uid/ip needed for delete
require_once __DIR__ . '/company/companyClass.php';
require_once __DIR__ . '/department/departmentClass.php';

$companyclass    = new companyClass();
$departmentClass = new departmentClass();

$dcid = $_POST['dcid'] ?? '';

// block delete when a department/entity is still linked to this company
$entity = $departmentClass->entitysearch($dcid);

if ($dcid == $entity) {
    respond_error('CANNOT DELETE!! COMPANY IS LINKED TO AN ENTITY');
} else {
    respond_ok($companyclass->delete($dcid));
}
