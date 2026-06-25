<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session gate; $uid = admin's session uid
require_once __DIR__ . '/users/usersClass.php';

$usersclass = new usersClass();
$edit_uid   = $_POST['uid']        ?? ''; // target user being edited (not the session admin)

$add       = isset($_POST['add'])       ? $_POST['add']       : 0;
$edit      = isset($_POST['edit'])      ? $_POST['edit']      : 0;
$delete    = isset($_POST['delete'])    ? $_POST['delete']    : 0;
$process   = isset($_POST['process'])   ? $_POST['process']   : 0;
$control   = isset($_POST['control'])   ? $_POST['control']   : 0;
$recommend = isset($_POST['recommend']) ? $_POST['recommend'] : 0;
$rlist     = isset($_POST['rlist'])     ? $_POST['rlist']     : 0;
$rassess   = isset($_POST['rassess'])   ? $_POST['rassess']   : 0;
$rregister = isset($_POST['rregister']) ? $_POST['rregister'] : 0;
$top       = isset($_POST['top'])       ? $_POST['top']       : 0;
$kpi       = isset($_POST['kpi'])       ? $_POST['kpi']       : 0;
$kri       = isset($_POST['kri'])       ? $_POST['kri']       : 0;
$perform   = isset($_POST['perform'])   ? $_POST['perform']   : 0;
$incident  = isset($_POST['incident'])  ? $_POST['incident']  : 0;
$action    = isset($_POST['action'])    ? $_POST['action']    : 0;
$objective = isset($_POST['objective']) ? $_POST['objective'] : 0;
$report    = isset($_POST['report'])    ? $_POST['report']    : 0;
$card      = isset($_POST['card'])      ? $_POST['card']      : 0;
$rating    = isset($_POST['rating'])    ? $_POST['rating']    : 0;

if ($edit_uid === '') {
    respond_error('No user selected');
} else {
    respond_ok($usersclass->permission($edit_uid, $add, $edit, $delete, $process, $control, $recommend, $rlist, $rassess, $rregister, $top, $kpi, $kri, $perform, $incident, $action, $objective, $report, $card, $rating));
}
