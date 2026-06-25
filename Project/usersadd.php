<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once './department/departmentClass.php';
include_once './users/usersClass.php';

$deptClass  = new departmentClass();
$showdept   = $deptClass->showDept();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once("../layout/header.php"); ?>
<link rel="stylesheet" href="../assets/css/user-form.css">
<body>
<div id="app">
    <div id="main" class="layout-horizontal">

        <?php include_once("../layout/nav.php") ?>

        <div class="content-wrapper container">
            <div class="page-heading">
                <h4>Add User</h4>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="container rounded bg-white mt-4 mb-5">

                            <p class="text-muted ps-3 pt-3" style="font-size:12px;">
                                Fields marked <span class="text-danger">*</span> are required.
                            </p>

                            <form id="profileform" onsubmit="return false;">
                                <input type="hidden" name="csrf_token"
                                       value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">

                                <div class="row">

                                    <!-- Avatar column (hidden on mobile) -->
                                    <div class="col-md-3 border-right order-md-1 d-none d-md-flex
                                                flex-column align-items-center text-center p-3 py-5">
                                        <img id="avatar-img" class="rounded-circle mt-5" width="130"
                                             src="../assets/images/faces/silhouette-glasses-profile.jpg"
                                             alt="Profile photo preview">
                                        <label for="avatar-file"
                                               class="btn btn-sm btn-outline-secondary mt-3">
                                            &#128247; Upload Photo
                                        </label>
                                        <input type="file" id="avatar-file" name="avatar"
                                               accept="image/*" class="d-none">
                                    </div>

                                    <!-- Main fields -->
                                    <div class="col-12 col-md-5 border-right order-md-2 order-1">
                                        <div class="p-3 py-5">
                                            <h4 class="mb-4">ADD USER</h4>

                                            <div class="row">
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="labels" for="fname">
                                                        First Name
                                                        <span class="text-danger" aria-hidden="true">*</span>
                                                    </label>
                                                    <input type="text" id="fname" name="fname"
                                                           class="form-control"
                                                           autocomplete="given-name"
                                                           aria-required="true">
                                                    <div class="invalid-feedback">First name is required.</div>
                                                </div>
                                                <div class="col-12 col-md-6 mb-3">
                                                    <label class="labels" for="sname">
                                                        Last Name
                                                        <span class="text-danger" aria-hidden="true">*</span>
                                                    </label>
                                                    <input type="text" id="sname" name="sname"
                                                           class="form-control"
                                                           autocomplete="family-name"
                                                           aria-required="true">
                                                    <div class="invalid-feedback">Last name is required.</div>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="labels" for="uname">
                                                    Username
                                                    <span class="text-danger" aria-hidden="true">*</span>
                                                </label>
                                                <input type="text" id="uname" name="uname"
                                                       class="form-control"
                                                       autocomplete="username"
                                                       aria-required="true">
                                                <div class="invalid-feedback">Username is required.</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="labels" for="phone">
                                                    Mobile Number
                                                    <span class="text-danger" aria-hidden="true">*</span>
                                                </label>
                                                <input type="tel" id="phone" name="phone"
                                                       class="form-control"
                                                       autocomplete="tel"
                                                       aria-required="true">
                                                <div class="invalid-feedback">Mobile number is required.</div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="labels" for="gender">Gender</label>
                                                <select id="gender" name="gender" class="form-select">
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="labels" for="email">
                                                    Email ID
                                                    <span class="text-danger" aria-hidden="true">*</span>
                                                </label>
                                                <input type="email" id="email" name="email"
                                                       class="form-control"
                                                       autocomplete="email"
                                                       aria-required="true">
                                                <div class="invalid-feedback">Enter a valid email address.</div>
                                            </div>

                                            <div class="d-grid d-md-block mt-4">
                                                <button class="btn btn-primary adduser-button"
                                                        type="button">
                                                    ADD USER
                                                </button>
                                            </div>

                                            <div id="form-feedback" role="alert"
                                                 aria-live="polite" class="mt-3"></div>

                                        </div>
                                    </div>

                                    <!-- Roles / dept / password -->
                                    <div class="col-12 col-md-4 order-md-3 order-2">
                                        <div class="p-3 py-5">

                                            <h4 class="mb-3">User Settings</h4>

                                            <div class="mb-3">
                                                <label class="labels" for="roles">User Role</label>
                                                <select id="roles" name="roles" class="form-select">
                                                    <option value="1">Administrator</option>
                                                    <option value="2" selected>User</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="labels" for="dept">Department</label>
                                                <select id="dept" name="dept" class="form-select">
                                                    <option value="">Select Department</option>
                                                    <?php foreach ($showdept as $dept): ?>
                                                    <option value="<?= $dept['dept_id'] ?>">
                                                        <?= htmlspecialchars($dept['dept_name']) ?>
                                                    </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="labels fw-bold text-danger" for="password">
                                                    Password
                                                    <span aria-hidden="true">*</span>
                                                </label>
                                                <div class="input-group has-validation">
                                                    <input type="password" id="password" name="password"
                                                           class="form-control"
                                                           autocomplete="new-password"
                                                           aria-required="true">
                                                    <button type="button"
                                                            class="btn btn-outline-secondary toggle-pw"
                                                            aria-label="Show password">&#128065;</button>
                                                </div>
                                                <div class="invalid-feedback">Password must be at least 8 characters.</div>
                                                <div class="progress mt-2" style="height:5px;">
                                                    <div id="pw-bar" class="progress-bar"
                                                         role="progressbar" style="width:0%"></div>
                                                </div>
                                                <small id="pw-label" class="text-muted"></small>
                                            </div>

                                        </div>
                                    </div>

                                </div><!-- /.row -->
                            </form>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include_once("../layout/footer.php"); ?>
    </div>
</div>

<script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/pages/horizontal-layout.js"></script>
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
<script src="../assets/vendors/fontawesome/all.min.js"></script>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>
<script src="../assets/js/formvalidation.js"></script>
<script src="../assets/js/usermanagement.js"></script>
</body>
</html>
