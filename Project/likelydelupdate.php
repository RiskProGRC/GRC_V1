<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/likelihoodClass.php';

$likelyClass = new likelihoodClass();

$lid = $_POST['likelyid'] ?? '';

if ($lid !== '') {
    header('Content-Type: application/json');
    echo json_encode($likelyClass->delupdate($lid));
}
