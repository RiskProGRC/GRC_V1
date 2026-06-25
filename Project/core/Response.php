<?php
class Response { // static utility — replaces raw echo strings in AJAX wrapper files with consistent JSON

    // send a success JSON response — {"status":"success","message":"..."}
    public static function success(string $message): void {
        header('Content-Type: application/json'); // tell the browser this is JSON, not HTML
        echo json_encode(['status' => 'success', 'message' => $message]); // encode and output
        exit; // stop execution — nothing should run after a response is sent
    }

    // send an error JSON response — {"status":"error","message":"..."}
    public static function error(string $message): void {
        header('Content-Type: application/json');
        echo json_encode(['status' => 'error', 'message' => $message]);
        exit; // stop execution
    }

    // redirect to another page — replaces header("Location:...") scattered across entity methods
    public static function redirect(string $url): void {
        header("Location: $url"); // issue the redirect header
        exit;                     // stop execution immediately after redirect
    }
}
