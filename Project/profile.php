<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

/* ARIA Phase 3 — auth gate for view pages */
if (empty($_SESSION['uid'])) {
    header('Location: ../Project/login/login.php');
    exit;
}

include_once './users/usersClass.php';
include_once './department/departmentClass.php';

$usersclass  = new usersClass();
$deptClass   = new departmentClass();

$sessionUid  = (int)$_SESSION['uid'];
$sessionRole = (int)($_SESSION['roles'] ?? 0);
$isAdmin     = $sessionRole === 1;

/* PRG — POST from userslist stores target UID in session then redirects; no ID ever in URL */
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $posted = (int)$_POST['id'];
    $_SESSION['profile_uid'] = $isAdmin ? $posted : $sessionUid; /* non-admins locked to own profile */
    header('Location: profile.php');
    exit;
}

/* resolve which profile to show — falls back to own profile when no session target set */
$uid = isset($_SESSION['profile_uid']) ? (int)$_SESSION['profile_uid'] : $sessionUid;

/* defense-in-depth: prevent session-tamper edge case for non-admins */
if ($uid !== $sessionUid && !$isAdmin) {
    $uid = $sessionUid;
}

$profile = $usersclass->profile((string)$uid);

/* null guard — invalid ID redirects instead of fatal crash */
if ($profile === null) {
    header('Location: userslist.php');
    exit;
}

$upid          = (int)$profile['id'];
$currentAccess = (int)($profile['access'] ?? 1);
$showdept      = $deptClass->showDept();

/* pre-fetch permission data in one pass — no extra per-row queries */
$permSet    = $usersclass->fetchPermissionUids();
$hasPermRow = isset($permSet[$upid]);
$perms      = $hasPermRow ? ($usersclass->fetchpermission((string)$upid) ?? []) : [];

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8');

/* XSS shorthand — wraps all DB string outputs in the template */
function e(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Header location -->
<?php include_once("../layout/header.php"); ?>
<style>
    body { background: rgb(39 59 120) }
    .form-control:focus { box-shadow: none; border-color: #BA68C8 }
    .access { margin-left: 20px; background: rgb(99, 39, 120); }
    .profile-button { background: #435ebe; box-shadow: none; border: none }
    .profile-button:hover { background: #682773 }
    .profile-button:focus, .profile-button:active { background: #682773; box-shadow: none }
    .back:hover { color: #682773; cursor: pointer }
    .labels { font-size: 11px }
    .add-experience:hover { background: #BA68C8; color: #fff; cursor: pointer; border: solid 1px #BA68C8 }
    .space { margin-right: 20px; }
</style>
<body>
    <div id="app">
        <div id="main" class="layout-horizontal">

            <!-- Navigation location -->
            <?php include_once("../layout/nav.php") ?>

            <div class="content-wrapper container">

                <!-- Content location BEGINNING -->
                <div class="page-content">
                    <section class="row">
                        <div class="col-lg-12">
                            <div class="container rounded bg-white mt-5 mb-5">
                                <form id="profileform">
                                    <div class="row">
                                        <div class="col-md-3 border-right">
                                            <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                                                <img class="rounded-circle mt-5" width="150px"
                                                     src="../assets/images/faces/silhouette-glasses-profile.jpg"
                                                     alt="Profile photo">
                                                <span class="font-weight-bold"><?= e($profile['username']) ?></span>
                                                <span class="text-black-50"><?= e($profile['email']) ?></span>
                                            </div>
                                        </div>
                                        <div class="col-md-5 border-right">
                                            <div class="p-3 py-5">
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h4 class="text-right">Profile Settings</h4>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-6">
                                                        <label class="labels">Name</label>
                                                        <input type="hidden" class="form-control" name="uid" value="<?= $upid ?>">
                                                        <input type="text" class="form-control" name="fname" value="<?= e($profile['fname']) ?>">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="labels">Second name</label>
                                                        <input type="text" class="form-control" name="sname" value="<?= e($profile['sname']) ?>">
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-md-12">
                                                        <label class="labels">Username</label>
                                                        <input type="text" class="form-control" name="user" value="<?= e($profile['username']) ?>">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="labels">Mobile Number</label>
                                                        <input type="text" class="form-control" name="phone" value="0<?= e($profile['phone']) ?>">
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="labels">Gender</label>
                                                        <select class="form-select" name="gender" id="gender">
                                                            <?php $gender = $profile['gender']; ?>
                                                            <option value="male"   <?= $gender === 'male'   ? 'selected' : '' ?>>Male</option>
                                                            <option value="female" <?= $gender === 'female' ? 'selected' : '' ?>>Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <label class="labels">Email ID</label>
                                                        <input type="text" class="form-control" name="email" value="<?= e($profile['email']) ?>">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="p-3 py-5">
                                                <div class="d-flex justify-content-between align-items-center experience">
                                                    <span><h4>Select User Roles</h4></span>
                                                </div><br>
                                                <div class="col-md-12">
                                                    <label class="labels"><h5>Choose User Roles</h5></label>
                                                    <select class="form-select" name="roles" id="roles">
                                                        <?php $roles = (int)$profile['roles']; ?>
                                                        <option value="1" <?= $roles === 1 ? 'selected' : '' ?>>Administrator</option>
                                                        <option value="2" <?= $roles === 2 ? 'selected' : '' ?>>User</option>
                                                    </select>
                                                </div><br>
                                                <div class="col-md-12">
                                                    <label class="labels"><h5>Choose Department</h5></label>
                                                    <select class="form-select" name="dept" id="dept">
                                                        <option value="">Select Department</option>
                                                        <?php foreach ($showdept as $dept): ?>
                                                            <option value="<?= (int)$dept['dept_id'] ?>"
                                                                    <?= (int)$profile['dept_id'] === (int)$dept['dept_id'] ? 'selected' : '' ?>>
                                                                <?= e($dept['dept_name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select><br>
                                                </div>
                                                <div class="col-md-12">
                                                    <label class="labels"><h5 style="color:red;">SYSTEM ACCESS</h5></label>
                                                    <select class="form-select" name="access" id="access-select">
                                                        <option value="1" <?= $currentAccess === 1 ? 'selected' : '' ?>>ACTIVE</option>
                                                        <option value="0" <?= $currentAccess === 0 ? 'selected' : '' ?>>SUSPENDED</option>
                                                    </select>
                                                </div><br>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Action buttons — full-width row below all three columns -->
                                    <div class="row">
                                        <div class="col-12 d-flex gap-2 justify-content-center flex-wrap py-4 border-top">
                                            <a href="../Project/userslist.php" class="btn btn-danger btn-lg">CLOSE</a>
                                            <button type="button" class="btn btn-primary btn-lg profileupdate">Update Profile</button>
                                            <?php if ($isAdmin): ?>
                                                <button type="button" class="btn btn-primary btn-lg"
                                                        data-bs-toggle="modal" data-bs-target="#access-modal">
                                                    <?= $hasPermRow ? 'Edit Permissions' : 'Add Permissions' ?>
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($isAdmin && $upid !== $sessionUid): ?>
                                                <button type="button" class="btn btn-warning btn-lg reset-pw-btn"
                                                        data-uid="<?= $upid ?>">
                                                    &#128274; Reset Password
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </section>
                </div>
                <!-- Content location END -->

            </div>

            <?php include_once("../layout/footer.php"); ?>

        </div>
    </div>

<!-- Permissions modal -->
<div class="modal fade text-left" id="access-modal" tabindex="-1" role="dialog"
     aria-labelledby="permModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="permModalLabel">User Permissions</h5>
                <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            <form id="permission">
                <input type="hidden" name="uid" value="<?= $upid ?>">
                <div class="modal-body">
                    <section id="basic-checkbox">
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-content">
                                        <div class="card-body">
                                            <h4 class="card-title">Key Roles</h4>
                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block me-2 mb-1">
                                                    <div class="form-check">
                                                        <div class="checkbox space">
                                                            <input type="checkbox" id="perm-add" name="add" value="1" class="form-check-input" <?= !empty($perms['add_btn']) ? 'checked' : '' ?>>
                                                            <label for="perm-add">ADD</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="d-inline-block me-2 mb-1">
                                                    <div class="form-check">
                                                        <div class="checkbox space">
                                                            <input type="checkbox" id="perm-edit" name="edit" value="1" class="form-check-input" <?= !empty($perms['edit_btn']) ? 'checked' : '' ?>>
                                                            <label for="perm-edit">EDIT</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <li class="d-inline-block me-2 mb-1">
                                                    <div class="form-check">
                                                        <div class="checkbox space">
                                                            <input type="checkbox" id="perm-delete" name="delete" value="1" class="form-check-input" <?= !empty($perms['delete_btn']) ? 'checked' : '' ?>>
                                                            <label for="perm-delete">DELETE</label>
                                                        </div>
                                                    </div>
                                                </li>
                                                <hr>
                                            </ul>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 class="card-title">Menus</h4>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-process" name="process" value="1" class="form-check-input" <?= !empty($perms['process']) ? 'checked' : '' ?>>
                                                                    <label for="perm-process">Process</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-control" name="control" value="1" class="form-check-input" <?= !empty($perms['control']) ? 'checked' : '' ?>>
                                                                    <label for="perm-control">Control</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-recommend" name="recommend" value="1" class="form-check-input" <?= !empty($perms['recommend']) ? 'checked' : '' ?>>
                                                                    <label for="perm-recommend">Recommendation</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <hr>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 class="card-title">Risk</h4>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-rlist" name="rlist" value="1" class="form-check-input" <?= !empty($perms['rlist']) ? 'checked' : '' ?>>
                                                                    <label for="perm-rlist">Risk List</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-rassess" name="rassess" value="1" class="form-check-input" <?= !empty($perms['rassess']) ? 'checked' : '' ?>>
                                                                    <label for="perm-rassess">Risk Assessment</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-rregister" name="rregister" value="1" class="form-check-input" <?= !empty($perms['rregister']) ? 'checked' : '' ?>>
                                                                    <label for="perm-rregister">Risk Register</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-top" name="top" value="1" class="form-check-input" <?= !empty($perms['top']) ? 'checked' : '' ?>>
                                                                    <label for="perm-top">Top 10</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <hr>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 class="card-title">Risk Monitoring</h4>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox">
                                                                    <input type="checkbox" id="perm-kpi" name="kpi" value="1" class="form-check-input" <?= !empty($perms['kpi']) ? 'checked' : '' ?>>
                                                                    <label for="perm-kpi">KPI</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox">
                                                                    <input type="checkbox" id="perm-kri" name="kri" value="1" class="form-check-input" <?= !empty($perms['kri']) ? 'checked' : '' ?>>
                                                                    <label for="perm-kri">KRI</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox">
                                                                    <input type="checkbox" id="perm-perform" name="perform" value="1" class="form-check-input" <?= !empty($perms['perform']) ? 'checked' : '' ?>>
                                                                    <label for="perm-perform">Risk Performance</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox">
                                                                    <input type="checkbox" id="perm-incident" name="incident" value="1" class="form-check-input" <?= !empty($perms['incident']) ? 'checked' : '' ?>>
                                                                    <label for="perm-incident">Incidents</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox">
                                                                    <input type="checkbox" id="perm-action" name="action" value="1" class="form-check-input" <?= !empty($perms['action']) ? 'checked' : '' ?>>
                                                                    <label for="perm-action">Actions</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox">
                                                                    <input type="checkbox" id="perm-objective" name="objective" value="1" class="form-check-input" <?= !empty($perms['objective']) ? 'checked' : '' ?>>
                                                                    <label for="perm-objective">Business Objectives</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <hr>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <h4 class="card-title">Audit Report</h4>
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-report" name="report" value="1" class="form-check-input" <?= !empty($perms['report']) ? 'checked' : '' ?>>
                                                                    <label for="perm-report">Audit Report</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-card" name="card" value="1" class="form-check-input" <?= !empty($perms['card']) ? 'checked' : '' ?>>
                                                                    <label for="perm-card">Tracking Card</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="d-inline-block me-2 mb-1">
                                                            <div class="form-check">
                                                                <div class="checkbox space">
                                                                    <input type="checkbox" id="perm-rating" name="rating" value="1" class="form-check-input" <?= !empty($perms['rating']) ? 'checked' : '' ?>>
                                                                    <label for="perm-rating">Audit Rating</label>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <hr>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="button" class="btn btn-primary permission-button">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block"><?= $hasPermRow ? 'Update Permissions' : 'Add Permissions' ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/pages/horizontal-layout.js"></script>
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
<script src="../assets/vendors/fontawesome/all.min.js"></script>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>
<!-- CSRF token as a single JS variable; usermanagement.js reads window.CSRF_TOKEN -->
<script>window.CSRF_TOKEN = '<?= $csrf ?>';</script>
<script src="../assets/js/usermanagement.js"></script>
</body>
</html>
