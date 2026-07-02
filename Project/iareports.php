<?php
include_once './engagement/engagementClass.php';
include_once './engagement/reportingclasses.php';
$engcls = new engagementClass();
$frcls  = new finalReportClass();
$ascls  = new actionSummaryClass();
$rscls  = new reportSummaryClass();

function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; // $showdept,$sess_roles,$sdid,$deptClass ?>
<?php
$isAdmin  = ((int)$sess_roles === 1);
$engs     = $isAdmin ? $engcls->showall() : $engcls->showdept((string)$sdid);
$engMap   = []; foreach ($engs as $e) $engMap[(int)$e['id']] = $e['title'];
$engIds   = array_keys($engMap);
$finalReports = $isAdmin ? $frcls->all() : $frcls->byDeptEng($engIds);
$actionSummaries = $ascls->all();
$periodReports   = $rscls->all();
$ratings = $frcls->ratings();
$ratingMap = []; foreach ($ratings as $rt) $ratingMap[(int)$rt['id']] = $rt['grade'];
?>
<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
<style>
.role-readonly .btn-userpermission-edit,.role-readonly .btn-userpermission-delete,.role-readonly .btn-userpermission-add{opacity:.4;pointer-events:none;cursor:not-allowed;}
.table-buss{border-collapse:collapse;width:100%;}
.table-buss th{font-size:12px;font-weight:700;color:#fff;background:#02338d;padding:5px 6px;text-align:center;border:1px solid rgba(255,255,255,.3);}
.table-buss td{font-size:12px;font-weight:500;color:#222;padding:4px 6px;text-align:center;border:1px solid #b8c8de;vertical-align:top;}
.ia-tab .nav-link.active{background:#02338d;color:#fff;}.ia-tab .nav-link{color:#02338d;font-weight:600;}
</style>
    <div id="app"><div id="main" class="layout-horizontal">
        <?php include_once '../layout/nav.php'; ?>
            <div class="content-wrapper container">
<div class="page-heading">
    <h4><i class="bi bi-file-earmark-bar-graph-fill"></i> Internal Audit — Reports</h4>
    <p class="text-muted" style="margin:0;font-size:13px;">Final reports, action-plan reporting, quarterly &amp; annual reports (PSASB reporting templates).</p>
</div>
    <div class="page-content">
      <div class="card"><div class="card-body">
        <ul class="nav nav-tabs ia-tab" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#r-final">Final Reports (<?= count($finalReports) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#r-action">Action Plan Reporting (<?= count($actionSummaries) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#r-period">Quarterly / Annual (<?= count($periodReports) ?>)</a></li>
        </ul>
        <div class="tab-content pt-3">

          <!-- FINAL REPORTS -->
          <div class="tab-pane fade show active" id="r-final">
            <button class="btn btn-primary btn-sm addfinalreport btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Engagement</th><th>Title</th><th>Overall Rating</th><th>Issued</th><th>Status</th><th>Action</th></tr></thead><tbody>
            <?php if (!$finalReports): ?><tr><td colspan="7" style="color:#888;">No final reports.</td></tr><?php else: $i = 1; foreach ($finalReports as $r):
              $b = $r['status'] === 'Issued' ? 'success' : 'warning'; ?>
              <tr><td><?= $i++ ?></td><td style="text-align:left;"><?= iah($engMap[(int)$r['engagement_id']] ?? '—') ?></td><td style="text-align:left;"><?= iah($r['report_title']) ?></td><td><?= iah($ratingMap[(int)$r['overall_rating']] ?? '—') ?></td><td><?= iah($r['issued_date'] ?: '—') ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td>
              <td><a href="iafinalreportprint.php?id=<?= (int)$r['id'] ?>" target="_blank" class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a>
              <a href="#" class="btn btn-sm btn-primary editfinalreport btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-report_title="<?= iah($r['report_title']) ?>" data-executive_summary="<?= iah($r['executive_summary']) ?>" data-overall_rating="<?= (int)($r['overall_rating'] ?? 0) ?>" data-issued_date="<?= iah($r['issued_date']) ?>" data-status="<?= iah($r['status']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="finalreportaction.php" data-id="<?= (int)$r['id'] ?>" data-label="report"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- ACTION PLAN REPORTING -->
          <div class="tab-pane fade" id="r-action">
            <button class="btn btn-primary btn-sm addactionsummary btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Year</th><th>Department</th><th>Title</th><th>Closed</th><th>Ongoing</th><th>Pending</th><th>Doc</th><th>Action</th></tr></thead><tbody>
            <?php if (!$actionSummaries): ?><tr><td colspan="9" style="color:#888;">No action-plan summaries.</td></tr><?php else: $i = 1; foreach ($actionSummaries as $r): ?>
              <tr><td><?= $i++ ?></td><td><?= (int)$r['year'] ?></td><td><?= $r['dept_id'] ? iah($deptClass->deptJoins((string)$r['dept_id'])) : 'All' ?></td><td style="text-align:left;"><?= iah($r['title'] ?: '—') ?></td><td><?= (int)$r['closed'] ?></td><td><?= (int)$r['ongoing'] ?></td><td><?= (int)$r['pending'] ?></td><td><?= $r['filename'] ? '<a href="../' . iah($r['filename']) . '" target="_blank" class="btn btn-sm btn-light-info"><i class="fas fa-file-earmark"></i></a>' : '—' ?></td>
              <td><a href="#" class="btn btn-sm btn-primary editactionsummary btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-dept_id="<?= (int)($r['dept_id'] ?? 0) ?>" data-year="<?= (int)$r['year'] ?>" data-title="<?= iah($r['title']) ?>" data-closed="<?= (int)$r['closed'] ?>" data-ongoing="<?= (int)$r['ongoing'] ?>" data-pending="<?= (int)$r['pending'] ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="actionsummaryaction.php" data-id="<?= (int)$r['id'] ?>" data-label="summary"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- PERIOD REPORTS -->
          <div class="tab-pane fade" id="r-period">
            <button class="btn btn-primary btn-sm addreportsummary btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Type</th><th>Year</th><th>Qtr</th><th>Title</th><th>Closed</th><th>Ongoing</th><th>Pending</th><th>Status</th><th>Action</th></tr></thead><tbody>
            <?php if (!$periodReports): ?><tr><td colspan="10" style="color:#888;">No quarterly/annual reports.</td></tr><?php else: $i = 1; foreach ($periodReports as $r):
              $b = $r['status'] === 'Issued' ? 'success' : 'warning'; ?>
              <tr><td><?= $i++ ?></td><td><?= ucfirst(iah($r['report_type'])) ?></td><td><?= (int)$r['year'] ?></td><td><?= $r['quarter'] ? 'Q' . (int)$r['quarter'] : '—' ?></td><td style="text-align:left;"><?= iah($r['title']) ?></td><td><?= (int)$r['closed'] ?></td><td><?= (int)$r['ongoing'] ?></td><td><?= (int)$r['pending'] ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td>
              <td><a href="reportsummaryprint.php?id=<?= (int)$r['id'] ?>" target="_blank" class="btn btn-sm btn-info" title="Print"><i class="fas fa-print"></i></a>
              <a href="#" class="btn btn-sm btn-primary editreportsummary btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-report_type="<?= iah($r['report_type']) ?>" data-year="<?= (int)$r['year'] ?>" data-quarter="<?= (int)($r['quarter'] ?? 0) ?>" data-title="<?= iah($r['title']) ?>" data-narrative="<?= iah($r['narrative']) ?>" data-closed="<?= (int)$r['closed'] ?>" data-ongoing="<?= (int)$r['ongoing'] ?>" data-pending="<?= (int)$r['pending'] ?>" data-status="<?= iah($r['status']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="reportsummaryaction.php" data-id="<?= (int)$r['id'] ?>" data-label="report"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

        </div>
      </div></div>
    </div>
  </div>

<?php
$engOpts = '<option value="">— select engagement —</option>'; foreach ($engs as $e) $engOpts .= '<option value="' . (int)$e['id'] . '">' . iah($e['title']) . '</option>';
$ratingOpts = '<option value="">— none —</option>'; foreach ($ratings as $rt) $ratingOpts .= '<option value="' . (int)$rt['id'] . '">' . iah($rt['grade']) . '</option>';
$deptOpts = '<option value="">All departments</option>'; foreach ($showdept as $d) $deptOpts .= '<option value="' . (int)$d['dept_id'] . '">' . iah($d['dept_name']) . '</option>';
?>
  <!-- final report modal -->
  <div class="modal fade" id="finalreport-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Final Report</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="finalreportform" class="ia-entity-form" data-url="finalreportaction.php" data-modal="finalreport-modal" enctype="multipart/form-data"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id">
      <div class="row"><div class="col-md-6 form-group ia-add-only"><label>Engagement <span class="text-danger">*</span></label><select class="form-control" name="engagement_id"><?= $engOpts ?></select></div>
      <div class="col-md-6 form-group"><label>Report Title <span class="text-danger">*</span></label><input class="form-control" name="report_title"></div>
      <div class="col-md-12 form-group"><label>Executive Summary</label><textarea class="form-control" name="executive_summary" rows="4"></textarea></div>
      <div class="col-md-4 form-group"><label>Overall Rating</label><select class="form-control" name="overall_rating"><?= $ratingOpts ?></select></div>
      <div class="col-md-4 form-group"><label>Issued Date</label><input type="date" class="form-control" name="issued_date"></div>
      <div class="col-md-4 form-group"><label>Status</label><select class="form-control" name="status"><option>Draft</option><option>Issued</option></select></div>
      <div class="col-md-12 form-group"><label>Report File (optional)</label><input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx"></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- action summary modal -->
  <div class="modal fade" id="actionsummary-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Action Plan Summary</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="actionsummaryform" class="ia-entity-form" data-url="actionsummaryaction.php" data-modal="actionsummary-modal" enctype="multipart/form-data"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id">
      <div class="row"><div class="col-6 form-group"><label>Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="year" placeholder="2026"></div>
      <div class="col-6 form-group"><label>Department</label><select class="form-control" name="dept_id"><?= $deptOpts ?></select></div>
      <div class="col-12 form-group"><label>Title</label><input class="form-control" name="title"></div>
      <div class="col-4 form-group"><label>Closed</label><input type="number" class="form-control" name="closed" value="0"></div>
      <div class="col-4 form-group"><label>Ongoing</label><input type="number" class="form-control" name="ongoing" value="0"></div>
      <div class="col-4 form-group"><label>Pending</label><input type="number" class="form-control" name="pending" value="0"></div>
      <div class="col-12 form-group"><label>Report File (optional)</label><input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx"></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- period report modal -->
  <div class="modal fade" id="reportsummary-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Quarterly / Annual Report</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="reportsummaryform" class="ia-entity-form" data-url="reportsummaryaction.php" data-modal="reportsummary-modal" enctype="multipart/form-data"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id">
      <div class="row"><div class="col-3 form-group"><label>Type</label><select class="form-control" name="report_type"><option value="quarterly">Quarterly</option><option value="annual">Annual</option></select></div>
      <div class="col-3 form-group"><label>Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="year" placeholder="2026"></div>
      <div class="col-3 form-group"><label>Quarter</label><select class="form-control" name="quarter"><option value="">—</option><option value="1">Q1</option><option value="2">Q2</option><option value="3">Q3</option><option value="4">Q4</option></select></div>
      <div class="col-3 form-group"><label>Status</label><select class="form-control" name="status"><option>Draft</option><option>Issued</option></select></div>
      <div class="col-12 form-group"><label>Title <span class="text-danger">*</span></label><input class="form-control" name="title"></div>
      <div class="col-12 form-group"><label>Narrative</label><textarea class="form-control" name="narrative" rows="4"></textarea></div>
      <div class="col-4 form-group"><label>Closed</label><input type="number" class="form-control" name="closed" value="0"></div>
      <div class="col-4 form-group"><label>Ongoing</label><input type="number" class="form-control" name="ongoing" value="0"></div>
      <div class="col-4 form-group"><label>Pending</label><input type="number" class="form-control" name="pending" value="0"></div>
      <div class="col-12 form-group"><label>Report File (optional)</label><input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx"></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- shared delete modal -->
  <div class="modal fade" id="iadel-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header bg-danger"><h5 class="modal-title white">Delete</h5><button type="button" class="close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <div class="modal-body"><input type="hidden" id="iadel_id"><input type="hidden" id="iadel_url"><h5>Delete this item?</h5><div style="font-weight:600;text-align:center;margin-top:8px;" id="iadel_label"></div></div>
    <div class="modal-footer"><button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger iadel-confirm">Delete</button></div></div></div></div>

        <?php include_once '../layout/footer.php'; ?>
        </div></div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../assets/js/pages/horizontal-layout.js"></script>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
    <script src="../assets/js/ia.js"></script>
</body>
</html>
