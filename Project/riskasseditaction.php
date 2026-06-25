<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip, respond_ok/error
require_once __DIR__ . '/risk/riskClass.php';

$riskclass = new riskClass();

// uid/ip from AuthGuard session
$raid    = $_POST['raid']    ?? '';
$risk    = $_POST['riskid']  ?? '';
$iimp    = $_POST['iimp']    ?? '';
$ilikely = $_POST['ilikely'] ?? '';
$rimp    = $_POST['rimp']    ?? '';
$rlikely = $_POST['rlikely'] ?? '';
$timp    = $_POST['timp']    ?? '';
$tlikely = $_POST['tlikely'] ?? '';

if ($risk === '') {
    respond_error('PLEASE CHOOSE RISK');
} elseif ($iimp === '' || $ilikely === '') {
    respond_error('PLEASE CHOOSE INHERENT IMPACT/LIKELIHOOD');
} elseif ($rimp === '' || $rlikely === '') {
    respond_error('PLEASE CHOOSE RESIDUAL IMPACT/LIKELIHOOD');
} elseif ($timp === '' || $tlikely === '') {
    respond_error('PLEASE CHOOSE TARGET IMPACT/LIKELIHOOD');
} else {
    respond_ok($riskclass->updateassess($uid, $ip, $raid, $risk, $iimp, $ilikely, $rimp, $rlikely, $timp, $tlikely));
}
