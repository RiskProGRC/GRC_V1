<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include_once './department/departmentClass.php';
include_once './users/usersClass.php';

$usersclass = new usersClass();
$deptClass  = new departmentClass();
$showusers  = $usersclass->fetchusers();
$showdept   = $deptClass->showDept();
$stats      = $usersclass->getStats();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf = htmlspecialchars($_SESSION['csrf_token']);
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; ?>
<style>
    tr, td { font-size: 13px; font-weight: 600; color: #000; }
    label  { font-size: 13px; font-weight: 800; color: #000; }
    .form-control, .form-select, .choices { font-size: 13px; }
    .stat-card { border-radius: 10px; padding: 18px 20px; color: #fff; }
    .stat-card h2 { font-size: 28px; font-weight: 700; margin: 0; }
    .stat-card p  { font-size: 12px; margin: 4px 0 0; opacity: .85; }
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

                        <!-- Stats cards -->
                        <div class="row mb-4 g-3">
                            <div class="col-6 col-md-3">
                                <div class="stat-card" style="background:#435ebe;">
                                    <h2><?= (int)($stats['total'] ?? 0) ?></h2>
                                    <p>Total Users</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-card" style="background:#28a745;">
                                    <h2><?= (int)($stats['active'] ?? 0) ?></h2>
                                    <p>Active</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-card" style="background:#dc3545;">
                                    <h2><?= (int)($stats['suspended'] ?? 0) ?></h2>
                                    <p>Suspended</p>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="stat-card" style="background:#6f42c1;">
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
                                    <button onclick="location.href='../Project/usersadd.php'"
                                            type="button" class="btn btn-sm btn-primary">
                                        &#43; Add User
                                    </button>
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
                                            <?php foreach ($showusers as $user):
                                                $deptid   = $user['dept_id'];
                                                $deptname = $deptClass->deptJoins((string)$deptid);
                                                $uid_row  = $user['id'];
                                                $puid     = $usersclass->accessbutton((string)$uid_row);

                                                $accessLabel = $user['access'] == 1 ? 'Active' : 'Suspended';
                                                $accessClass = $user['access'] == 1 ? 'btn-success' : 'btn-danger';

                                                $permBtn = ($uid_row == $puid)
                                                    ? '<a href="permissionedit?id=' . $uid_row . '" class="btn btn-sm btn-primary"><span class="bi bi-check-square-fill"></span>&nbsp;Permission</a>'
                                                    : '';
                                            ?>
                                            <tr data-dept="<?= $deptid ?>">
                                                <td>UID00<?= $uid_row ?></td>
                                                <td><?= htmlspecialchars($user['fname'] . ' ' . $user['sname']) ?></td>
                                                <td><?= htmlspecialchars($user['gender']) ?></td>
                                                <td><?= htmlspecialchars($deptname) ?></td>
                                                <td><?= htmlspecialchars($user['username']) ?></td>
                                                <td><?= htmlspecialchars($user['phone']) ?></td>
                                                <td>
                                                    <button class="btn btn-sm <?= $accessClass ?> access-toggle"
                                                            data-uid="<?= $uid_row ?>"
                                                            data-csrf="<?= $csrf ?>">
                                                        <?= $accessLabel ?>
                                                    </button>
                                                </td>
                                                <td class="d-flex gap-1 flex-wrap">
                                                    <a href="profile.php?id=<?= $uid_row ?>"
                                                       class="btn btn-sm btn-primary">
                                                        &#128100; Profile
                                                    </a>
                                                    <?= $permBtn ?>
                                                    <button class="btn btn-sm btn-outline-secondary" disabled>
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
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
<script src="../assets/js/usermanagement.js"></script>
</body>
</html>
