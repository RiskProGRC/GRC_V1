<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/settings/likelihoodClass.php';

$likelyclass = new likelihoodClass();

$lid = $_POST['ldelete'] ?? '';

if ($lid === '') {
    respond_error('No ID provided');
} else {
    respond_ok($likelyclass->delete($lid));
}
