<?php
session_start();

require_once './Project/login/loginClass.php';
require_once './Project/core/Response.php'; /* 3.4 — consistent JSON responses */
$loginclass = new loginClass();

function getuseripaddress() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']); /* can return multiple IPs */
        $ip = trim($ipList[0]);
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
$ip_address = getuseripaddress();

if (!isset($_POST['email'], $_POST['password'], $_POST['csrf_token'])) { /* 2.2 — guard missing POST keys */
    Response::error('Missing required fields.');
}
if ($_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) { /* 2.3 — reject forged or replayed requests */
    Response::error('Invalid request. Refresh and try again.');
}

$email = $_POST['email'];
$pass  = $_POST['password'];

$result = $loginclass->login($email, $pass, $ip_address);

if (is_string($result) && str_starts_with($result, 'WELCOME')) { /* successful normal login */
    Response::success($result);
} elseif ($result === 'first_login') { /* user_type=0 — must change password first */
    header('Content-Type: application/json');
    echo json_encode(['status' => 'first_login', 'message' => 'Please update your password.']);
    exit;
} elseif ($result === 'locked') { /* 2.3 — rate limit reached */
    Response::error('Too many failed attempts. Please try again in 15 minutes.');
} else {
    Response::error('Invalid email or password.'); /* 2.5 — same message for wrong password and unknown email */
}
