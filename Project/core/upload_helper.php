<?php
// Shared, hardened file upload for Internal Audit modules.
// Security posture (reviewed): the stored filename is built ONLY from server-controlled data
// (prefix + timestamp + random token) — the caller-supplied name is discarded entirely, so a
// "double extension" payload such as shell.php.pdf can never land on disk. Extension is
// whitelisted, magic-byte MIME is verified, and the uploads root is hardened with a .htaccess
// that disables script execution. Returns ['ok'=>bool,'filename'=>?string,'error'=>?string];
// a missing/optional file returns ['ok'=>true,'filename'=>null].
function ia_store_upload(string $fileKey, string $subdir, string $prefix,
    array $allowed = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'png', 'jpg', 'jpeg']): array {

    if (empty($_FILES[$fileKey]) || ($_FILES[$fileKey]['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
        return ['ok' => true, 'filename' => null]; // optional — no file provided
    }
    $f = $_FILES[$fileKey];
    if ($f['error'] !== UPLOAD_ERR_OK) {
        return ['ok' => false, 'error' => 'File upload failed (code ' . (int)$f['error'] . ').'];
    }
    if ($f['size'] <= 0 || $f['size'] > 10 * 1024 * 1024) {
        return ['ok' => false, 'error' => 'File must be between 1 byte and 10MB.'];
    }

    $original = (string)$f['name'];
    // defense-in-depth: reject any executable/script token anywhere in the name (not just last ext)
    if (preg_match('/\.(php\d?|phtml|phar|phps|pht|cgi|pl|py|sh|htaccess|html?|svg|xml)(\.|$)/i', $original)) {
        return ['ok' => false, 'error' => 'This file type is not permitted.'];
    }
    $ext = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed, true)) {
        return ['ok' => false, 'error' => 'Only ' . strtoupper(implode(', ', $allowed)) . ' files are allowed.'];
    }

    // magic-byte / MIME verification — block scripts or HTML masquerading under an allowed extension
    if (function_exists('finfo_open')) {
        $fi   = finfo_open(FILEINFO_MIME_TYPE);
        $mime = (string)finfo_file($fi, $f['tmp_name']);
        finfo_close($fi);
        $dangerous = ['text/html', 'text/x-php', 'application/x-php', 'application/x-httpd-php',
                      'text/x-shellscript', 'application/x-executable', 'application/xml', 'image/svg+xml'];
        if (in_array($mime, $dangerous, true)) {
            return ['ok' => false, 'error' => 'File content is not permitted.'];
        }
        $okMime = [
            'pdf'  => ['application/pdf'],
            'doc'  => ['application/msword', 'application/x-ole-storage', 'application/vnd.ms-office', 'application/octet-stream'],
            'docx' => ['application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/zip', 'application/octet-stream'],
            'xls'  => ['application/vnd.ms-excel', 'application/x-ole-storage', 'application/vnd.ms-office', 'application/octet-stream'],
            'xlsx' => ['application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'application/zip', 'application/octet-stream'],
            'png'  => ['image/png'],
            'jpg'  => ['image/jpeg'],
            'jpeg' => ['image/jpeg'],
        ];
        if (isset($okMime[$ext]) && $mime !== '' && !in_array($mime, $okMime[$ext], true)) {
            return ['ok' => false, 'error' => 'File content (' . $mime . ') does not match a .' . $ext . ' file.'];
        }
    }

    $subdir = preg_replace('/[^A-Za-z0-9_-]/', '', $subdir); // never let subdir escape the uploads root
    $prefix = preg_replace('/[^A-Za-z0-9_-]/', '', $prefix);
    $root   = __DIR__ . '/../../assets/uploads/ia/';
    $dir    = $root . $subdir . '/';
    if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
        return ['ok' => false, 'error' => 'Cannot create the upload directory.'];
    }
    ia_harden_upload_dir($root); // ensure execution-disabling .htaccess exists

    // stored name = server-controlled only + random token → collision-safe and traversal-proof
    $name   = $prefix . '_' . date('YmdHis') . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $target = $dir . $name;
    if (!move_uploaded_file($f['tmp_name'], $target)) {
        return ['ok' => false, 'error' => 'Could not save the uploaded file.'];
    }
    @chmod($target, 0644);
    return ['ok' => true, 'filename' => 'assets/uploads/ia/' . $subdir . '/' . $name];
}

// Drop a hardening .htaccess at the uploads root so no uploaded file can ever be executed.
function ia_harden_upload_dir(string $root): void {
    $ht = $root . '.htaccess';
    if (is_file($ht)) {
        return;
    }
    $rules = "# Auto-generated — deny execution of any uploaded file\n"
        . "<IfModule mod_mime.c>\n"
        . "    RemoveHandler .php .php3 .php4 .php5 .php7 .php8 .phtml .phar\n"
        . "    RemoveType .php .php3 .php4 .php5 .php7 .php8 .phtml .phar\n"
        . "</IfModule>\n"
        . "<FilesMatch \"\\.(php\\d?|phtml|phar|phps|pht|cgi|pl|py|sh)$\">\n"
        . "    Require all denied\n"
        . "</FilesMatch>\n"
        . "php_flag engine off\n"
        . "Options -ExecCGI -Indexes\n";
    @file_put_contents($ht, $rules);
}

// Remove a previously-stored upload from disk (used on delete/replace). Path is the app-root-relative
// value returned by ia_store_upload(); guarded to stay inside the uploads root.
function ia_delete_upload(?string $relPath): void {
    if ($relPath === null || $relPath === '') {
        return;
    }
    if (strpos($relPath, 'assets/uploads/ia/') !== 0 || strpos($relPath, '..') !== false) {
        return; // refuse anything outside the uploads root
    }
    $full = __DIR__ . '/../../' . $relPath;
    if (is_file($full)) {
        @unlink($full);
    }
}
