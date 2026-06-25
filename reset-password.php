<?php
session_start(); /* 2.1 — session needed for CSRF token */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); /* 2.1 — generate CSRF token once per session */
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password — RiskPROGRC</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <link rel="stylesheet" href="assets/vendors/sweetalert2/sweetalert2.min.css">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="login.php"><img src="./assets/images/logo/GRC.png" alt="Logo"></a>
                    </div>
                    <h1>Forgot Password</h1><br>
                    <h5 class="text-gray-600">Enter your email address and we'll send a reset link.</h5><br>

                    <form action="" id="reset-password">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"> <!-- 2.1 — CSRF token -->
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" name="email" class="form-control form-control-xl" placeholder="Email" autocomplete="email">
                            <div class="form-control-icon">
                                <i class="bi bi-envelope"></i>
                            </div>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5 reset-password-btn">Send Reset Password</button> <!-- 4.5 — was "Passoword" -->
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Remember your password? <a href="login.php" class="font-bold">Log in</a>.</p> <!-- 4.5 — was auth-login.html -->
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>

    <script src="assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="assets/vendors/jquery/jquery.min.js"></script>
    <script src="assets/vendors/jquery/jquery-ui.min.js"></script>
    <script src="assets/js/login.js"></script> <!-- 3.6 — JS moved to external file -->
</body>
</html>
