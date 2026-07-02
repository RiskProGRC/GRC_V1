<?php
include_once './engagement/engagementClass.php';
include_once './engagement/fieldworkclasses.php';
$engcls = new engagementClass();
$fcls   = new findingClass();

function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; // $sess_roles,$sdid,$deptClass ?>
<?php
$findings  = ((int)$sess_roles === 1) ? $fcls->all() : $fcls->byDept((string)$sdid);
$ratingMap = []; foreach ($fcls->ratings() as $rt) $ratingMap[(int)$rt['id']] = $rt['grade'];
$engTitle  = [];
$counts = ['Open' => 0, 'Closed' => 0, 'Overdue' => 0, 'Draft' => 0];
foreach ($findings as $f) { if (isset($counts[$f['status']])) $counts[$f['status']]++; }
?>
<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
<style>
.table-buss{border-collapse:collapse;width:100%;}
.table-buss th{font-size:12px;font-weight:700;color:#fff;background:#02338d;padding:5px 6px;text-align:center;border:1px solid rgba(255,255,255,.3);}
.table-buss td{font-size:12px;font-weight:500;color:#222;padding:4px 6px;text-align:center;border:1px solid #b8c8de;vertical-align:top;}
.kpi{border-radius:8px;padding:14px;color:#fff;text-align:center;}
</style>
    <div id="app"><div id="main" class="layout-horizontal">
        <?php include_once '../layout/nav.php'; ?>
            <div class="content-wrapper container">
<div class="page-heading">
    <h4><i class="bi bi-database-fill-exclamation"></i> Internal Audit — Findings Database</h4>
    <p class="text-muted" style="margin:0;font-size:13px;">All audit findings across engagements (PSASB Findings Database).</p>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-6 col-lg-3"><div class="kpi" style="background:#ffc107;color:#000;"><h3><?= $counts['Open'] ?></h3>Open</div></div>
            <div class="col-6 col-lg-3"><div class="kpi" style="background:#dc3545;"><h3><?= $counts['Overdue'] ?></h3>Overdue</div></div>
            <div class="col-6 col-lg-3"><div class="kpi" style="background:#198754;"><h3><?= $counts['Closed'] ?></h3>Closed</div></div>
            <div class="col-6 col-lg-3"><div class="kpi" style="background:#6c757d;"><h3><?= $counts['Draft'] ?></h3>Draft</div></div>
        </section>
        <section class="row mt-2"><div class="col-12">
            <div class="card"><div class="card-body"><div class="table-responsive">
                <table class="table table-striped table-buss" id="table-fdb">
                    <thead><tr><th>#</th><th>Engagement</th><th>Department</th><th>Finding</th><th>Rating</th><th>Recommendation</th><th>Responsible</th><th>Target</th><th>Status</th></tr></thead>
                    <tbody>
                    <?php if (!$findings): ?>
                        <tr><td colspan="9" style="text-align:center;color:#888;">No findings recorded.</td></tr>
                    <?php else: $n = 1; foreach ($findings as $f):
                        $eid = (string)$f['engagement_id'];
                        if (!isset($engTitle[$eid])) { $row = $engcls->details($eid); $engTitle[$eid] = $row ? $row['title'] : '—'; }
                        $b = ['Closed' => 'success', 'Overdue' => 'danger', 'Open' => 'warning'][$f['status']] ?? 'secondary';
                    ?>
                        <tr>
                            <td><?= $n++ ?></td>
                            <td style="text-align:left;"><a href="engagementfieldwork.php?id=<?= (int)$f['engagement_id'] ?>"><?= iah($engTitle[$eid]) ?></a></td>
                            <td><?= $f['dept_id'] ? iah($deptClass->deptJoins((string)$f['dept_id'])) : '—' ?></td>
                            <td style="text-align:left;"><?= iah(mb_strimwidth((string)$f['finding'], 0, 100, '…')) ?></td>
                            <td><?= iah($ratingMap[(int)$f['rating']] ?? '—') ?></td>
                            <td style="text-align:left;"><?= iah(mb_strimwidth((string)$f['recommend'], 0, 80, '…')) ?></td>
                            <td><?= iah($f['responsible_officer'] ?: '—') ?></td>
                            <td><?= iah($f['timeline'] ?: '—') ?></td>
                            <td><span class="badge bg-<?= $b ?>"><?= iah($f['status']) ?></span></td>
                        </tr>
                    <?php endforeach; endif; ?>
                    </tbody>
                </table>
            </div></div></div>
        </div></section>
    </div>
  </div>
        <?php include_once '../layout/footer.php'; ?>
        </div></div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>var t=document.querySelector('#table-fdb'); if(t) new simpleDatatables.DataTable(t,{perPage:15});</script>
    <script src="../assets/js/pages/horizontal-layout.js"></script>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
</body>
</html>
