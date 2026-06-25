<?php
if (session_status() === PHP_SESSION_NONE) { // start session only if not already active
    session_start();
}

if (!isset($_SESSION['uid']) || !isset($_SESSION['user'])) { // abort if user is not authenticated
    header('Content-Type: application/json'); // force JSON response for AJAX callers
    echo json_encode(['status' => 'error', 'message' => 'Session expired. Please log in again.']); // send auth failure payload
    exit; // halt execution immediately — nothing below should run unauthenticated
}

$uid  = $_SESSION['uid']; // authenticated user ID
$sdid = $_SESSION['dept_id'] ?? ''; // department ID, empty string if not set (e.g. super-admin)
$ip   = !empty($_SERVER['HTTP_CLIENT_IP'])          // prefer explicit client IP header
        ? $_SERVER['HTTP_CLIENT_IP']
        : (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])  // fall back to proxy-forwarded IP
            ? $_SERVER['HTTP_X_FORWARDED_FOR']
            : $_SERVER['REMOTE_ADDR']);               // last resort: direct connection IP

function respond_ok(string $message): void {
    header('Content-Type: application/json'); // signal JSON to the caller
    echo json_encode(['status' => 'ok', 'message' => $message]); // wrap message in standard envelope
    exit; // terminate after sending — no further output allowed
}

function respond_error(string $message): void {
    header('Content-Type: application/json'); // signal JSON to the caller
    echo json_encode(['status' => 'error', 'message' => $message]); // wrap error in standard envelope
    exit; // terminate after sending — no further output allowed
}
