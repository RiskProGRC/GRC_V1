<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/riskcategoryClass.php';

$riskCatClass = new riskCatClass();

$name   = $_POST['riskcat'] ?? '';
$rcdesc = $_POST['rcdesc']  ?? '';

if ($name === '') {
    respond_error('Values empty');
} else {
    respond_ok($riskCatClass->addRiskCat($uid, $ip, $name, $rcdesc));
}
