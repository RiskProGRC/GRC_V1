<?php
session_start();
require_once 'googleAuthConfig.php';
require_once 'assets/vendors/googleAuth/vendor/autoload.php';
include_once './Project/login/loginClass.php';

// Configuration
$clientID = GoogleAuthConfig::getGoogleClientId();
$clientSecret = GoogleAuthConfig::getGoogleClientSecret();
$redirectUri = GoogleAuthConfig::getGoogleRedirectUri();

// Get allowed domains and emails
$allowedDomains = GoogleAuthConfig::getAllowedDomains();
$allowedGmailUsers = GoogleAuthConfig::getAllowedGmailUsers();

// Create Google Client
$client = new Google_Client();
$client->setClientId($clientID);
$client->setClientSecret($clientSecret);
$client->setRedirectUri($redirectUri);
$client->addScope("email");
$client->addScope("profile");

// Create debug log file
$debug_file = fopen("google_auth_debug.log", "a");
fwrite($debug_file, "\nregisteraction.php accessed at " . date('Y-m-d H:i:s') . "\n");

// Check if there's a code in the URL (callback from Google)
if (isset($_GET['code'])) {
    try {
        fwrite($debug_file, "Auth code received: " . $_GET['code'] . "\n");

        // Exchange authorization code for access token
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

        fwrite($debug_file, "Token response: " . json_encode($token) . "\n");

        if (isset($token['error'])) {
            throw new Exception($token['error_description']);
        }

        $client->setAccessToken($token);

        // Get user profile
        $google_oauth = new Google_Service_Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();

        $email = $google_account_info->email;
        $name = $google_account_info->name;
        $authid = $google_account_info->id;

        fwrite($debug_file, "User info retrieved: Email: $email, Name: $name, ID: $authid\n");

        // Check if the email is from an allowed domain or is a specifically allowed Gmail account
        $isAllowed = false;
        $domain = substr(strrchr($email, "@"), 1); // Get the domain part of the email

        if ($domain !== 'gmail.com') {
            // Check if domain is in the allowed list
            $isAllowed = in_array($domain, $allowedDomains);
            fwrite($debug_file, "Domain check: $domain - Allowed: " . ($isAllowed ? "Yes" : "No") . "\n");
        } else {
            // For Gmail accounts, check if the specific email is allowed
            $isAllowed = in_array($email, $allowedGmailUsers);
            fwrite($debug_file, "Gmail check: $email - Allowed: " . ($isAllowed ? "Yes" : "No") . "\n");
        }

        if ($isAllowed) {
            // Proceed with user registration/login
            $loginClass = new loginClass();
            $password = password_hash(bin2hex(random_bytes(12)), PASSWORD_DEFAULT); // Random secure password

            fwrite($debug_file, "About to call googlesignup for $email\n");

            $result = $loginClass->googlesignup($authid, $name, $email, $password);

            fwrite($debug_file, "googlesignup result: $result\n");

            // Note: Redirect is handled in googlesignup method
        } else {
            // Access denied - redirect to login with error message
            $_SESSION['login_error'] = "Access restricted: Your email domain is not authorized.";
            fwrite($debug_file, "Access denied for $email\n");
            header('Location: login');
            exit;
        }

    } catch (Exception $e) {
        // Handle authentication errors
        $_SESSION['login_error'] = "Authentication error: " . $e->getMessage();
        fwrite($debug_file, "Authentication error: " . $e->getMessage() . "\n");
        header('Location: login');
        exit;
    }
} else {
    // No code in URL, redirect to login
    fwrite($debug_file, "No auth code in URL, redirecting to login\n");
    header('Location: login');
    exit;
}

fclose($debug_file);
?>