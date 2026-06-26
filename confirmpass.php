<?php
session_start(); /* session needed for CSRF and first-login uid */
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

<body>
    <style>
        #message{
            color:#fff;
        }
    </style>
    <!--<div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                        <a href="#"><img src="assets/images/logo/GRC.png" width="270px"  alt="Logo"></a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p>

                    <form id="loginform">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" name="email" class="form-control form-control-xl" placeholder="Email">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" name="password" class="form-control form-control-xl" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>
                     <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="flexCheckDefault">
                            <label class="form-check-label text-gray-600" for="flexCheckDefault">
                                Keep me logged in
                            </label>
                        </div>
                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5 login">Log in</button>
                    </form>
                    <div class="text-center mt-5 text-lg fs-4">
                        <p class="text-gray-600">Don't have an account? <a href="" class="font-bold signin">Sign
                                up</a>.</p>
                        <p><a class="font-bold" href="">Forgot password?</a>.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">

                </div>
            </div>
        </div>
    </div>-->
   
    <section class="container forms">
        <div class="form login">
            <div class="form-content">
                <header><img src="./assets/images/logo/GRC.png" alt="" width="120px" height="60px"></header>
                <form id="cpassword_form">
                    
                    <input type="hidden" name="token" value="<?php if(isset($_GET["token"])){echo htmlspecialchars($_GET["token"], ENT_QUOTES, 'UTF-8');}?>">

                    <div class="form-group position-relative has-icon-left mb-4">
                        <label for=""> Email Address</label>
                        <input type="email" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? $_SESSION['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" class="form-control form-control-xl" readonly>
                        <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                        </div>
                    </div>

                    <div class="form-group position-relative has-icon-left mb-4">
                        <!-- uid removed from form — confirmaction.php reads it from $_SESSION (1.5) -->
                        <label for=""> Enter New Password</label>
                        <input type="password" name="pass" id="password" class="form-control form-control-xl" placeholder="Enter Password here">
                        <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                        </div>
                        <span id="togglePwd1" style="cursor:pointer;position:absolute;right:14px;top:50%;transform:translateY(-50%);z-index:10;">
                            <i class="bi bi-eye" id="eyeIcon1"></i>
                        </span>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                    <label for=""> Confirm Password</label>
                        <input type="password" name="cpass" id="cpassword" class="form-control form-control-xl" placeholder="Password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <span id="togglePwd2" style="cursor:pointer;position:absolute;right:14px;top:50%;transform:translateY(-50%);z-index:10;">
                            <i class="bi bi-eye" id="eyeIcon2"></i>
                        </span>
                    </div>    
                    <p id="message"></p>           

                    <div class="field button-field">
                        <button class="btn btn-primary btn-block btn-lg shadow-lg  login-btn">SUBMIT</button>
                    </div>
                </form>
               
            </div>

 <!--           <div class="line"></div>

            <div class="media-options">
                <a href="#" class="field facebook">
                    <i class='bx bxl-facebook facebook-icon'></i>
                    <span>Login with Facebook</span>
                </a>
            </div>

            <div class="media-options">
                    <a href="" class="field google">
                        <img src="./assets/images/google.png" alt="" class="google-img">
                        <span>Login with Google</span>
                    </a>
            </div>
-->
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
