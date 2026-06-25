<?php
require_once __DIR__ . '/core/AuthGuard.php';
require_once __DIR__ . '/company/companyClass.php';

$companyclass = new companyClass();

$companyid = $_POST['companyid'] ?? '';
$cname     = $_POST['cname']     ?? '';
$group     = $_POST['group']     ?? '';
$email     = $_POST['email']     ?? '';
$phone     = $_POST['phone']     ?? '';
$website   = $_POST['website']   ?? '';
$address   = $_POST['address']   ?? '';

if ($cname === '') {
    respond_error('ENTER COMPANY NAME');
} elseif ($email === '') {
    respond_error('ENTER COMPANY EMAIL');
} elseif ($phone === '') {
    respond_error('ENTER COMPANY PHONE');
} elseif ($website === '') {
    respond_error('ENTER COMPANY WEBSITE');
} elseif ($address === '') {
    respond_error('ENTER COMPANY ADDRESS');
} else {
    respond_ok($companyclass->update($uid, $ip, $companyid, $cname, $group, $email, $phone, $website, $address));
}
