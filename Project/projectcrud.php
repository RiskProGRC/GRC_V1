<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/projectClass.php';
$c = new projectClass();
$id = $_POST['id'] ?? '';
if (!ctype_digit((string)$id) || $c->editDetails($id) === null) respond_error('Project not found.');
if (($_POST['mode'] ?? '') === 'delete') {
    $m = $c->delete($id); $m === 'Project deleted successfully' ? respond_ok($m) : respond_error($m);
}
$name = $_POST['name'] ?? '';
$entity = isset($_POST['entity']) ? implode(',', (array)$_POST['entity']) : ($_POST['entityid'] ?? '');
$risk = isset($_POST['risk']) ? implode(',', (array)$_POST['risk']) : ($_POST['riskid'] ?? '');
if (trim($name) === '') respond_error('Project name is required');
respond_ok($c->update($id, $name, $entity, $risk));
