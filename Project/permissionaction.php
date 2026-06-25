<?php
require_once __DIR__ . '/core/AuthGuard.php'; // $uid = session admin performing the edit
require_once __DIR__ . '/users/usersClass.php';

$usersclass = new usersClass();

$add       = isset($_POST['add'])       ? 1 : 0;
$edit      = isset($_POST['edit'])      ? 1 : 0;
$delete    = isset($_POST['delete'])    ? 1 : 0;
$process   = isset($_POST['process'])   ? 1 : 0;
$control   = isset($_POST['control'])   ? 1 : 0;
$recommend = isset($_POST['recommend']) ? 1 : 0;
$rlist     = isset($_POST['rlist'])     ? 1 : 0;
$rassess   = isset($_POST['rassess'])   ? 1 : 0;
$rregister = isset($_POST['rregister']) ? 1 : 0;
$top       = isset($_POST['top'])       ? 1 : 0;
$kpi       = isset($_POST['kpi'])       ? 1 : 0;
$kri       = isset($_POST['kri'])       ? 1 : 0;
$perform   = isset($_POST['perform'])   ? 1 : 0;
$incident  = isset($_POST['incident'])  ? 1 : 0;
$action    = isset($_POST['action'])    ? 1 : 0;
$objective = isset($_POST['objective']) ? 1 : 0;
$report    = isset($_POST['report'])    ? 1 : 0;
$card      = isset($_POST['card'])      ? 1 : 0;
$rating    = isset($_POST['rating'])    ? 1 : 0;

$edit_uid = $_POST['uid'] ?? ''; // target user being edited — not the session admin
if ($edit_uid !== '') {
    respond_ok($usersclass->updatepermission(
        $edit_uid, $add, $edit, $delete, $process, $control, $recommend,
        $rlist, $rassess, $rregister, $top, $kpi, $kri, $perform,
        $incident, $action, $objective, $report, $card, $rating
    ));
} else {
    respond_error('Missing user ID');
}
