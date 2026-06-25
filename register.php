<?php
include_once'../GRC/Project/department/departmentClass.php';
//include_once'../https://test.riskprogrc.com/Project/department/departmentClass.php';
$deptClass= new departmentClass();
$department= $deptClass->showDept();

?>
<style>
   #auth #auth-left .auth-logo {
    margin-bottom: 0.1rem !important;
}
#auth #auth-left {
    padding: 3rem 5rem !important;
}
.form-control.form-control-xl {
    padding: .375rem 1.75rem .375rem 3rem !important;
}
</style>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - RISKPROGRC</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="stylesheet" href="assets/css/pages/auth.css">
    <!------------------------Sweet alerts------------------------------------>
<link rel="stylesheet" href="assets/vendors/sweetalert2/sweetalert2.min.css">
</head>

<body>
    <div id="auth">
        
<div class="row h-100">
    <div class="col-lg-5 col-12">
        <div id="auth-left">
            <div class="auth-logo">
                <a href="login.php"><img src="assets/images/logo/GRC.png" width="270px"  alt="Logo"></a>
            </div>
            <h1 class="">Sign Up</h1>
            <p class="auth-subtitle mb-5">Input your data to register to GRC.</p>

            <form id="signupform">
                <div class="row">
                    <div class="form-group position-relative  col-6">
                        <input type="text" class="form-control form-control-xl" name="fname" placeholder="First name">
                        
                    </div>
                    <div class="form-group position-relative col-6">
                        <input type="text" class="form-control form-control-xl" name="sname" placeholder="Second name">
                        
                    </div>

                    <div class="form-group position-relative has-icon-left mb-4 col-6">
                        <select class="form-select form-control-xl choices" name="dept" id="">
                            <option value="" selected>&nbsp;&nbsp;Department</option>
                            <?php
                            foreach($department as $dept){
                                echo'<option value='.$dept["dept_id"].'>'.$dept["dept_name"].'</option>';
                            }
                            ?>
                        </select>
                        <div class="form-control-icon">
                            <i class="bi bi-collection"></i>
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4 col-6">
                        <select class="form-select form-control-xl" name="gender" id="">
                            <option value="" selected>&nbsp;&nbsp;Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <div class="form-control-icon">
                            <i class="bi bi-people"></i>
                        </div>
                    </div>
                </div><!--end of row----------------------------->
                
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" class="form-control form-control-xl" name="email" placeholder="Email">
                    <div class="form-control-icon">
                        <i class="bi bi-envelope"></i>
                    </div>
                </div>

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" class="form-control form-control-xl" name="phone" placeholder="phone">
                    <div class="form-control-icon">
                        <i class="bi bi-phone"></i>
                    </div>
                </div>

                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="text" class="form-control form-control-xl" name="user" placeholder="Username">
                    <div class="form-control-icon">
                        <i class="bi bi-person"></i>
                    </div>
                </div>
                <div class="form-group position-relative has-icon-left mb-4">
                    <input type="password" class="form-control form-control-xl" name="pass" placeholder="Password">
                    <div class="form-control-icon">
                        <i class="bi bi-shield-lock"></i>
                    </div>
                </div>
               
                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5 signup">Sign Up</button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'>Already have an account? <a href="auth-login.html" class="font-bold">Log
                        in</a>.</p>
            </div>
        </div>
    </div>
    <div class="col-lg-7 d-none d-lg-block">
        <div id="auth-right">

        </div>
    </div>
</div>

    </div>

     <!------------------------------SWEET ALERTS---------------------------------->
     <script src="assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <!------------------------ Include Choices JavaScript drop down--------------------- -->
    <script src="assets/vendors/jquery/jquery.min.js"></script>
    <script src="assets/vendors/jquery/jquery-ui.min.js"></script>

    <script>
        $(document).on('click','.signup',function(e){
            e.preventDefault();
            $.ajax({
                url:'registeraction.php',
                method:'post',
                data:$("#signupform").serialize(),
                dataType:'text',
                success:function(response){
                    Swal.fire({
                    icon: "success",
                    title: response,
                    timer: 1500
                    })
                    window.setTimeout(function(){//time to switch to location
                        window.location.href="login.php";
                    }, 1500);
                }

            });
        });

    </script>

</body>

</html>
