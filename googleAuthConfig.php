<?php
// config.php
class GoogleAuthConfig {
    // Google OAuth settings
    private static $googleClientId = '576284537138-no1mn59at641pcp62kovdpqgvscrnp9o.apps.googleusercontent.com';
    private static $googleClientSecret = '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';

    // Get the current base URL
    public static function getBaseUrl() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'https';
        $host = $_SERVER['HTTP_HOST'];
        return $protocol . '://' . $host;
    }

    // Get Google client ID
    public static function getGoogleClientId() {
        return self::$googleClientId;
    }

    // Get Google client secret
    public static function getGoogleClientSecret() {
        return self::$googleClientSecret;
    }

    // Get redirect URI for Google OAuth
    public static function getGoogleRedirectUri() {
        return self::getBaseUrl() . '/registeraction.php';
    }

    // Get allowed Gmail addresses
    public static function getAllowedGmailUsers() {
        return [
            'riskprogrc@gmail.com',
            'timothykimemia01@gmail.com',
            'kirimimartin4409@gmail.com',
        ];
    }

    // Get allowed domains
    public static function getAllowedDomains() {
        return [
            'strathmore.edu',
            'riskprogrc.com',
        ];
    }
}