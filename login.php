<?php
session_start(); /* 1.6 — session must start before $_SESSION is readable */
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); /* 2.1 — generate CSRF token once per session */
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RiskPROGRC</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/pages/loginstyle.css">
    <!--<link rel="stylesheet" href="assets/css/pages/auth.css">-->
<!------------------------Sweet alerts------------------------------------>
<link rel="stylesheet" href="assets/vendors/sweetalert2/sweetalert2.min.css">
</head>
<style>
        #message{
            color:#fff;
            text-align: center;
        }
    </style>
<body>
    <?php
        require_once 'googleAuthConfig.php';
        require_once 'assets/vendors/googleAuth/vendor/autoload.php';

        $clientID = GoogleAuthConfig::getGoogleClientId();
        $clientSecret = GoogleAuthConfig::getGoogleClientSecret();
        $redirectUri = GoogleAuthConfig::getGoogleRedirectUri();
       
        // create Client Request to access Google API
        $client = new Google_Client();
        $client->setClientId($clientID);
        $client->setClientSecret($clientSecret);
        $client->setRedirectUri($redirectUri);
        $client->addScope("email");
        $client->addScope("profile");
       
    ?>
    <section class="container forms">
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
                <?= $_SESSION['login_error']; ?>
                <?php unset($_SESSION['login_error']); ?>
            </div>
        <?php endif; ?>

        <div class="form login">
            <div class="form-content">
                <header><img src="./assets/images/logo/GRC.png" alt="" width="120px" height="60px"></header>
                <form id="loginform">
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="email" name="email" id="email" class="form-control form-control-xl" placeholder="Email" autocomplete="email"> <!-- 4.4 — type=email + autocomplete for password managers -->
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" name="password" id="password" class="form-control form-control-xl" placeholder="Password" autocomplete="current-password"> <!-- 4.4 — autocomplete for password managers -->
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <span id="togglePwd" style="cursor:pointer;position:absolute;right:14px;top:50%;transform:translateY(-50%);z-index:10;"> <!-- 4.3 — show/hide toggle -->
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </span>
                    </div>
                    <p id="message"></p>

                    <div class="form-link">
                        <a href="reset-password.php" class="forgot-pass">Forgot password?</a>
                    </div>

                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>"> <!-- 2.1 — CSRF token bound to session -->
                    <div class="field button-field">
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg login-btn">Log In</button>
                    </div>
                </form>

                <!--<div class="form-link">
                    <span>Don't have an account? <a href="#" class="font-bold signin">Signup</a></span>
                </div>-->
            </div>

            <div class="line"></div>

            <div class="media-options">
                    <a href="<?= $client->createAuthUrl() ?>" class="field google">
                        <img src="./assets/images/google.png" alt="" class="google-img">
                        <span>Login with Google</span>
                    </a>
            </div>

        </div>
    </section>

     <!------------------------------SWEET ALERTS---------------------------------->
     <script src="assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <!------------------------ Include Choices JavaScript drop down--------------------- -->
    <script src="assets/vendors/jquery/jquery.min.js"></script>
    <script src="assets/vendors/jquery/jquery-ui.min.js"></script>
    <script src="assets/js/login.js"></script> <!-- 3.6 — JS moved to external file -->
</body>

</html>
