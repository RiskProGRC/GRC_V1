<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$sessionRole = $_SESSION['roles']   ?? 0;
$sessionDept = $_SESSION['dept_id'] ?? '';

include_once './connection/connect.php'; // $con — needed before DOCTYPE for dept dropdown

// roles 2 and 3 only see their own department in the dropdown
if (in_array((int)$sessionRole, [2, 3]) && $sessionDept !== '') {
    $stmt = $con->prepare("SELECT dept_id, dept_name FROM department WHERE dept_id = ?");
    $stmt->bind_param('s', $sessionDept);
    $stmt->execute();
    $depts = $stmt->get_result();
} else {
    $depts = mysqli_query($con, "SELECT dept_id, dept_name FROM department ORDER BY dept_name ASC");
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; ?>
<style>
/* ── Nav-tabs — matches riskstatus.php theme ── */
#rvTab {
    background: #02338d;
    border-bottom: 2px solid #012a73;
    padding: 5px 6px 0;
    gap: 3px;
    border-radius: 6px 6px 0 0;
}
#rvTab .nav-link {
    padding: 10px 14px;
    margin: 3px 2px 0;
    border-radius: 6px 6px 0 0;
    border: 1px solid rgba(255,255,255,0.15) !important;
    border-bottom: 3px solid transparent !important;
    background: rgba(255,255,255,0.08);
    color: #cde0ff;
    font-size: 12px;
    font-weight: 600;
    text-decoration: none;
    transition: background 0.15s, color 0.15s;
}
#rvTab .nav-link:hover  { background: rgba(255,255,255,0.18); color: #fff; }
#rvTab .nav-link.active {
    background: #0554e9 !important;
    color: #fff !important;
    font-weight: 700;
    border-bottom: 3px solid #ffc107 !important;
}

/* ── Table ── */
.table-buss { border-collapse: collapse; }
.table-buss th {
    font-size: 11px; font-weight: 700; color: #fff;
    background: #02338d; padding: 3px 5px;
    white-space: nowrap; text-align: center; vertical-align: middle;
    border: 1px solid rgba(255,255,255,0.3);
}
.table-buss td {
    font-size: 10px; font-weight: 700; color: #000;
    padding: 2px 5px; text-align: center; vertical-align: middle;
    border: 1px solid #b8c8de;
}
.table-buss tbody tr:hover td { background: #eef4ff; }

/* ── Dept dropdown ── */
#rv-dept {
    border: 2px solid #02338d !important;
    border-radius: 6px;
    font-size: 13px;
    font-weight: 600;
    color: #1a2a4a;
    box-shadow: 0 0 0 3px rgba(2,51,141,0.08);
}
#rv-dept:focus {
    border-color: #0554e9 !important;
    box-shadow: 0 0 0 3px rgba(5,84,233,0.18);
    outline: none;
}

/* ── Loading / prompt ── */
.rv-prompt { text-align: center; padding: 50px 0; color: #aaa; font-size: 13px; }
</style>

<body>
<div id="app">
    <div id="main" class="layout-horizontal">

        <?php include_once '../layout/nav.php'; ?>

        <div class="content-wrapper container">
            <div class="page-heading">
                <center><h4>Risk Tracker</h4></center>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">

                                    <!-- ── Dept dropdown ── -->
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Choose Entity</label>
                                            <?php $restrictedRole = in_array((int)$sessionRole, [2, 3]) && $sessionDept !== ''; ?>
                                            <select class="form-select" id="rv-dept" onchange="loadDept(this.value)"
                                                <?= $restrictedRole ? 'disabled' : '' ?>>
                                                <?php if (!$restrictedRole): ?>
                                                <option value="">-- Select Entity --</option>
                                                <?php endif; ?>
                                                <?php while ($d = mysqli_fetch_assoc($depts)): ?>
                                                <option value="<?= $d['dept_id'] ?>"
                                                    <?= $restrictedRole ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($d['dept_name']) ?>
                                                </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- ── AJAX result area ── -->
                                    <div class="col-sm-9">
                                        <div id="rv-display">
                                            <div class="rv-prompt">&#128202; Select an entity to load its risk register</div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include_once '../layout/footer.php'; ?>
    </div>
</div>

<script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
<?php if ($restrictedRole): ?>
// auto-load the user's department on page ready — no manual selection needed
$(document).ready(function() { loadDept('<?= addslashes($sessionDept) ?>'); });
<?php endif; ?>

function loadDept(id) {
    if (!id) { // user picked the blank option — reset display
        $('#rv-display').html('<div class="rv-prompt">&#128202; Select an entity to load its risk register</div>');
        return;
    }

    $('#rv-display').html('<div class="rv-prompt">Loading&#8230;</div>'); // loading message while request is in flight

    $.ajax({
        type: 'POST',
        url:  'riskview_fetch.php',
        data: { deptid: id },             // matches $_POST['deptid'] in fetch file
        success: function(html) {
            $('#rv-display').html(html);  // inject the full HTML response into the page

            // Init DataTables on each injected table (null-guard in case a table is empty)
            ['rv-tab1','rv-tab2','rv-tab3','rv-tab4','rv-tab5'].forEach(function(tid) {
                var el = document.getElementById(tid);
                if (el) new simpleDatatables.DataTable(el, { perPage: 10 }); // only init when table exists in DOM
            });
        },
        error: function() {
            $('#rv-display').html('<div class="rv-prompt" style="color:#c0392b">&#9888; Failed to load. Please try again.</div>');
        }
    });
}
</script>

</body>
</html>
