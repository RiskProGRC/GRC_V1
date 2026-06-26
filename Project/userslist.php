<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$uid=1;
 
/* ARIA Phase 3 — auth gate for view pages: redirect instead of JSON */
if (empty($_SESSION['uid'])) {
    header('Location: ../Project/login/login.php');
    exit;
}

include_once './department/departmentClass.php';
include_once './users/usersClass.php';

$usersclass = new usersClass();
$deptClass  = new departmentClass();

$showusers  = $usersclass->fetchusers();   // explicit columns only — no password hash
$showdept   = $deptClass->showDept();
$stats      = $usersclass->getStats();

/* Build a dept name lookup from already-fetched $showdept — avoids N deptJoins() queries */
$deptMap = array_column($showdept, 'dept_name', 'dept_id');

/* Fetch all permission UIDs in one query — avoids N accessbutton() queries */
$permSet = $usersclass->fetchPermissionUids();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = htmlspecialchars($_SESSION['csrf_token']); // used once in a JS variable, not per-row
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; ?>
<style>
    tr, td { font-size: 13px; font-weight: 600; color: #000; }
    label  { font-size: 13px; font-weight: 800; color: #000; }
    .form-control, .form-select, .choices { font-size: 13px; }
    .stat-card          { border-radius: 10px; padding: 18px 20px; color: #fff; }
    .stat-card h2       { font-size: 28px; font-weight: 700; margin: 0; }
    .stat-card p        { font-size: 12px; margin: 4px 0 0; opacity: .85; }
    /* stat card colour modifiers — replaces inline style attributes */
    .stat-card.sc-blue   { background: #435ebe; }
    .stat-card.sc-green  { background: #28a745; }
    .stat-card.sc-red    { background: #dc3545; }
    .stat-card.sc-purple { background: #6f42c1; }
</style>
<body>
<div id="app">
    <div id="main" class="layout-horizontal">

        <?php include_once '../layout/nav.php'; ?>

        <div class="content-wrapper container">
            <div class="page-heading">
                <h4>User Management</h4>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12">

                        <!-- Stats cards — colours set via CSS classes, not inline styles -->
                        <div class="row mb-4 g-3">
                            <div class="col-6 col-md-3">
                                <div class="stat-card sc-blue">
                                    <h2><?= (int)($stats['total'] ?? 0) ?></h2>
                                    <p>Total Users</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-card sc-green">
                                    <h2><?= (int)($stats['active'] ?? 0) ?></h2>
                                    <p>Active</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-card sc-red">
                                    <h2><?= (int)($stats['suspended'] ?? 0) ?></h2>
                                    <p>Suspended</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-card sc-purple">
                                    <h2><?= (int)($stats['admins'] ?? 0) ?></h2>
                                    <p>Administrators</p>
                                </div>
                            </div>
                        </div>

                        <section class="section">
                            <div class="card">
                                <!-- Card header toolbar -->
                                <div class="card-header d-flex align-items-center gap-2 flex-wrap">
                                    <select id="dept-filter" class="form-select form-select-sm"
                                            style="max-width:200px;" aria-label="Filter by department">
                                        <option value="">All Departments</option>
                                        <?php foreach ($showdept as $d): ?>
                                        <option value="<?= $d['dept_id'] ?>">
                                            <?= htmlspecialchars($d['dept_name']) ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>

                                    <a href="../Project/userexport.php"
                                       class="btn btn-sm btn-outline-success ms-auto">
                                        &#128190; Export CSV
                                    </a>
                                    <!-- anchor tag preserves keyboard nav and middle-click; onclick on button does not -->
                                    <a href="../Project/usersadd.php" class="btn btn-sm btn-primary">
                                        &#43; Add User
                                    </a>
                                </div>

                                <div class="card-body">
                                    <table class="table table-striped" id="table1">
                                        <thead>
                                            <tr>
                                                <th>User ID</th>
                                                <th>Name</th>
                                                <th>Gender</th>
                                                <th>Department</th>
                                                <th>Username</th>
                                                <th>Phone</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($showusers)): ?>
                                            <!-- empty state — shown when no users exist yet -->
                                            <tr>
                                                <td colspan="8" class="text-center py-4 text-muted">
                                                    No users found. <a href="usersadd.php">Add the first user</a>.
                                                </td>
                                            </tr>
                                            <?php else: ?>
                                            <?php foreach ($showusers as $user):
                                                $uid_row  = (int)$user['id'];   // cast once; reused as int throughout
                                                $deptid   = (int)$user['dept_id'];

                                                /* O(1) array lookup — no DB call per row */
                                                $deptname = htmlspecialchars($deptMap[$deptid] ?? 'N/A', ENT_QUOTES, 'UTF-8');

                                                $accessLabel = (int)$user['access'] === 1 ? 'Active' : 'Suspended'; // strict comparison
                                                $accessClass = (int)$user['access'] === 1 ? 'btn-success' : 'btn-danger';

                                                /* isset() on pre-fetched array — no DB call per row */
                                                $permBtn = isset($permSet[$uid_row])
                                                    ? '<a href="permissionedit.php?id=' . $uid_row . '" class="btn btn-sm btn-primary"><span class="bi bi-check-square-fill"></span>&nbsp;Permission</a>'
                                                    : '';
                                            ?>
                                            <tr data-dept="<?= $deptid ?>"> <!-- int, no escaping needed -->
                                                <td>UID00<?= $uid++ ?></td>
                                                <td><?= htmlspecialchars($user['fname'] . ' ' . $user['sname'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($user['gender'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= $deptname ?></td>
                                                <td><?= htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td><?= htmlspecialchars($user['phone'], ENT_QUOTES, 'UTF-8') ?></td>
                                                <td>
                                                    <!-- CSRF read from JS variable set below, not per-button attribute -->
                                                    <button class="btn btn-sm <?= $accessClass ?> access-toggle"
                                                            data-uid="<?= $uid_row ?>">
                                                        <?= $accessLabel ?>
                                                    </button>
                                                </td>
                                                <td class="d-flex gap-1 flex-wrap">
                                                    <!-- POST hides uid from URL; profile.php PRG-redirects to clean profile.php -->
                                                    <form method="post" action="profile.php" class="d-inline">
                                                        <input type="hidden" name="id" value="<?= $uid_row ?>">
                                                        <button type="submit" class="btn btn-sm btn-primary">&#128100; Profile</button>
                                                    </form>
                                                    <?= $permBtn ?>
                                                    <button class="btn btn-sm btn-outline-danger delete-user"
                                                            data-uid="<?= $uid_row ?>">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>

                    </div>
                </section>
            </div>
        </div>

        <?php include_once '../layout/footer.php'; ?>
    </div>
</div>

<script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
<script>
    let table1 = document.querySelector('#table1');
    if (table1) { new simpleDatatables.DataTable(table1); }
</script>
<script src="../assets/js/pages/horizontal-layout.js"></script>
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
<script src="../assets/vendors/fontawesome/all.min.js"></script>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>
<!-- CSRF token as a single JS variable; usermanagement.js reads window.CSRF_TOKEN instead of per-button data-csrf -->
<script>window.CSRF_TOKEN = '<?= $csrf ?>';</script>
<script src="../assets/js/usermanagement.js"></script>
</body>
</html>
