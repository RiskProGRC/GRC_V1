<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/riskcategoryClass.php';

$riskcatclass = new riskCatClass();

$rcid   = $_POST['rcid']         ?? '';
$name   = $_POST['riskcatname']  ?? '';
$rcdesc = $_POST['rcedesc']      ?? '';

if ($rcid === '') {
    respond_error('FORM IS EMPTY');
} elseif ($name === '') {
    respond_error('FORM IS EMPTY');
} elseif ($rcdesc === '') {
    respond_error('FORM IS EMPTY');
} else {
    respond_ok($riskcatclass->updateriskcat($uid, $ip, $rcid, $name, $rcdesc));
}
