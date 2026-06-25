<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/projectClass.php';

if (isset($_POST['addproject'])) {
    $name   = $_POST['name']   ?? '';
    $entity = isset($_POST['entity']) ? implode(',', (array)$_POST['entity']) : '';
    $risk   = isset($_POST['risk'])   ? implode(',', (array)$_POST['risk'])   : '';

    if ($name !== '' && $entity !== '' && $risk !== '') {
        $projectClass = new projectClass();
        respond_ok($projectClass->addProject($name, $entity, $risk));
    } else {
        respond_error('All fields are required');
    }
}
