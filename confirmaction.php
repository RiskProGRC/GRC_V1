<?php
session_start(); /* 1.5 — session required to read uid server-side */

require_once './Project/login/loginClass.php';
require_once './Project/core/Response.php'; /* 3.4 — consistent JSON responses */
$loginclass = new loginClass();

if (!isset($_POST['token'], $_POST['email'], $_POST['pass'])) {
    Response::error('Missing required fields.');
}

$token = $_POST['token'];
$email = $_POST['email'];
$pass  = $_POST['pass'];

/* uid from session (first-login flow) or empty string (reset flow — token identifies the user) */
$uid = $_SESSION['uid'] ?? '';

/* must have either a session uid (first-login) or a token (reset link) — not both required */
if (empty($uid) && empty($token)) {
    Response::error('Session expired. Please log in again.');
}

$hpass = password_hash($pass, PASSWORD_DEFAULT);

$result = $loginclass->passupdate($uid, $hpass, $email, $token);

if ($result === 'Password updated') {
    Response::success('Password updated successfully. Please log in.');
} else {
    Response::error($result ?? 'Password update failed.');
}
