<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/riskcategoryClass.php';

$riskcatclass = new riskCatClass();

$rcid = $_POST['rcdelete'] ?? '';

if ($rcid === '') {
    respond_error('No ID provided');
} else {
    respond_ok($riskcatclass->delete($rcid));
}
