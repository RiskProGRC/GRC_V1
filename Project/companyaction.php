<?php
require_once __DIR__ . '/core/AuthGuard.php'; // sets $uid, $ip from session; traditional form POST handler
require_once __DIR__ . '/company/companyClass.php';

$companyClass = new companyClass();

$file    = $_FILES['file']['name'] ?? '';
$logo    = basename($file);
$name    = $_POST['name']    ?? '';
$group   = $_POST['group']   ?? '';
$email   = $_POST['email']   ?? '';
$phone   = $_POST['phone']   ?? '';
$website = $_POST['website'] ?? '';
$address = $_POST['address'] ?? '';

if (empty($name) && empty($email) && empty($group) && empty($phone) && empty($website) && empty($address)) {
    echo "insert data";
} elseif (empty($logo)) {
    echo "please select a file to upload";
} else {
    // uid/ip sourced from AuthGuard session, not POST
    echo $companyClass->addCompany($uid, $ip, $logo, $name, $group, $email, $phone, $website, $address);
}
