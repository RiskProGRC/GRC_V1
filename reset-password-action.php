<?php
session_start(); /* 2.1 — session needed for CSRF check */

require_once './Project/core/Response.php'; /* 3.4 — consistent JSON responses */
require './assets/vendors/PHPMailer/src/Exception.php';
require './assets/vendors/PHPMailer/src/PHPMailer.php';
require './assets/vendors/PHPMailer/src/SMTP.php';
include_once './Project/connection/connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function send_password_reset(string $get_name, string $get_email, string $token): string
{
    $mail = new PHPMailer(true);

    $mail->SMTPDebug = SMTP::DEBUG_OFF; /* 1.3 — was DEBUG_SERVER which printed SMTP to browser */
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'kirimimartin4409@gmail.com';
    $mail->Password   = 'paheqajlrpfilacs';
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    $mail->setFrom('info@riskProgrc.com', $get_name);
    $mail->addAddress($get_email);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Notification';
    $mail->Body    = 'Click this link to reset your password (valid for 1 hour): <a href="http://localhost/GRC_V1/confirmpass.php?token=' . $token . '&email=' . urlencode($get_email) . '">Reset Password</a>';
    $mail->AltBody = 'You requested a password reset. Copy this link: http://localhost/GRC_V1/confirmpass.php?token=' . $token . '&email=' . urlencode($get_email);

    try {
        $mail->Send();
        return "Message has been sent";
    } catch (Exception $e) {
        return "Mailer Error: " . $e->getMessage();
    }
}

if (!isset($_POST['email'], $_POST['csrf_token'])) { /* 2.5 — guard missing POST keys */
    Response::error('Missing required fields.');
}
if ($_POST['csrf_token'] !== ($_SESSION['csrf_token'] ?? '')) { /* 2.1 — reject forged requests */
    Response::error('Invalid request. Please refresh and try again.');
}

$token   = bin2hex(random_bytes(16)); /* 1.3 / 2.6 — cryptographically secure token */
$expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

$email = mysqli_real_escape_string($con, trim($_POST['email']));

$check_email = "SELECT * FROM users WHERE email='$email' LIMIT 1";
$query_check = mysqli_query($con, $check_email) or die(mysqli_error($con));

if (mysqli_num_rows($query_check) > 0) {
    $row      = mysqli_fetch_assoc($query_check);
    $get_name = $row['username'];

    /* 1.3 — save secure token with 1-hour expiry
       Requires: ALTER TABLE users ADD COLUMN token_expires_at DATETIME NULL AFTER verify_token; */
    $update_token = "UPDATE users SET verify_token='$token', token_expires_at='$expires' WHERE email='$email' LIMIT 1";
    $query_token  = mysqli_query($con, $update_token) or die(mysqli_error($con));

    if ($query_token) {
        send_password_reset($get_name, $email, $token);
    }
}

/* 2.2 — always return the same message regardless of whether the email exists — prevents enumeration */
Response::success('If that email is registered, a reset link has been sent.');
