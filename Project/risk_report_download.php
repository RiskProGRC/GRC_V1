<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["uid"])) {
    echo "Session expired or user not logged in.";
    exit;
}

// Get filename from query parameter
$filename = isset($_GET['file']) ? $_GET['file'] : '';

// Basic security check: ensure filename only contains allowed characters
if (!preg_match('/^risk_report_[0-9]{4}-[0-9]{2}-[0-9]{2}_[0-9]{2}-[0-9]{2}-[0-9]{2}\.xls$/', $filename)) {
    echo "Invalid filename.";
    exit;
}

$filepath = '../reports/' . $filename;

// Check if file exists
if (!file_exists($filepath)) {
    echo "File not found.";
    exit;
}

// Set headers for file download
header('Content-Description: File Transfer');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
header('Content-Length: ' . filesize($filepath));

// Clear output buffer
ob_clean();
flush();

// Read file and output to browser
readfile($filepath);
exit;