<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/divisionClass.php';

$division = $_POST['division'] ?? '';
if ($division === '') {
    respond_error('EMPTY VALUES');
} else {
    $divisionClass = new divisionClass();
    respond_ok($divisionClass->addDivision($division));
}
