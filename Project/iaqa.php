<?php
include_once './iaqa/qaclasses.php';
include_once './engagement/engagementClass.php';
$svcls = new surveyClass();
$pmcls = new performanceMatrixClass();
$qdcls = new qaDocClass();
$engcls = new engagementClass();

function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
$SURVEY_LABELS = ['client' => 'Client Satisfaction', 'audit_committee' => 'Audit Committee', 'senior_mgmt' => 'Senior Management', 'staff' => 'IA Staff'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; // $sess_roles,$sdid ?>
<?php
$surveys = $svcls->all();
$matrix  = $pmcls->all();
$qadocs  = $qdcls->all();
$engs    = ((int)$sess_roles === 1) ? $engcls->showall() : $engcls->showdept((string)$sdid);
$engMap  = []; foreach ($engs as $e) $engMap[(int)$e['id']] = $e['title'];
$avg = []; foreach (array_keys($SURVEY_LABELS) as $t) $avg[$t] = $svcls->avgScore($t);
?>
<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
<style>
.role-readonly .btn-userpermission-edit,.role-readonly .btn-userpermission-delete,.role-readonly .btn-userpermission-add{opacity:.4;pointer-events:none;cursor:not-allowed;}
.table-buss{border-collapse:collapse;width:100%;}
.table-buss th{font-size:12px;font-weight:700;color:#fff;background:#02338d;padding:5px 6px;text-align:center;border:1px solid rgba(255,255,255,.3);}
.table-buss td{font-size:12px;font-weight:500;color:#222;padding:4px 6px;text-align:center;border:1px solid #b8c8de;vertical-align:top;}
.ia-tab .nav-link.active{background:#02338d;color:#fff;}.ia-tab .nav-link{color:#02338d;font-weight:600;}
.stile{border-radius:8px;padding:12px;text-align:center;background:#eef4ff;border:1px solid #cfe0ff;}
.stile h3{color:#02338d;margin:0;font-size:22px;}
</style>
    <div id="app"><div id="main" class="layout-horizontal">
        <?php include_once '../layout/nav.php'; ?>
            <div class="content-wrapper container">
<div class="page-heading">
    <h4><i class="bi bi-patch-check-fill"></i> Internal Audit — Performance &amp; Quality Assurance</h4>
    <p class="text-muted" style="margin:0;font-size:13px;">Stakeholder surveys, performance matrix, and external quality assessment (PSASB QA templates).</p>
</div>
    <div class="page-content">
      <div class="card"><div class="card-body">
        <ul class="nav nav-tabs ia-tab" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#q-survey">Surveys (<?= count($surveys) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#q-perf">Performance Matrix (<?= count($matrix) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#q-doc">QA Documents (<?= count($qadocs) ?>)</a></li>
        </ul>
        <div class="tab-content pt-3">

          <!-- SURVEYS -->
          <div class="tab-pane fade show active" id="q-survey">
            <div class="row mb-3">
              <?php foreach ($SURVEY_LABELS as $t => $lbl): ?>
                <div class="col-6 col-lg-3"><div class="stile"><h3><?= $avg[$t] !== null ? number_format($avg[$t], 2) . ' / 5' : '—' ?></h3><?= iah($lbl) ?></div></div>
              <?php endforeach; ?>
            </div>
            <button class="btn btn-primary btn-sm addsurvey btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add Response</button>
            <table class="table table-buss" id="table-survey"><thead><tr><th>#</th><th>Type</th><th>Year</th><th>Respondent</th><th>Role</th><th>Score</th><th>Comments</th><th>Action</th></tr></thead><tbody>
            <?php if (!$surveys): ?><tr><td colspan="8" style="color:#888;">No survey responses.</td></tr><?php else: $i = 1; foreach ($surveys as $r): ?>
              <tr><td><?= $i++ ?></td><td><?= iah($SURVEY_LABELS[$r['survey_type']] ?? $r['survey_type']) ?></td><td><?= (int)$r['period_year'] ?></td><td><?= iah($r['respondent_name'] ?: '—') ?></td><td><?= iah($r['respondent_role'] ?: '—') ?></td><td><?= $r['overall_score'] !== null ? (int)$r['overall_score'] . '/5' : '—' ?></td><td style="text-align:left;"><?= iah(mb_strimwidth((string)($r['comments'] ?? ''), 0, 60, '…')) ?: '—' ?></td>
              <td><a href="#" class="btn btn-sm btn-primary editsurvey btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-period_year="<?= (int)$r['period_year'] ?>" data-respondent_name="<?= iah($r['respondent_name']) ?>" data-respondent_role="<?= iah($r['respondent_role']) ?>" data-overall_score="<?= (int)($r['overall_score'] ?? 0) ?>" data-comments="<?= iah($r['comments']) ?>" data-submitted_at="<?= iah($r['submitted_at']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="surveyaction.php" data-id="<?= (int)$r['id'] ?>" data-label="response"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- PERFORMANCE MATRIX -->
          <div class="tab-pane fade" id="q-perf">
            <button class="btn btn-primary btn-sm addperformance btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add KPI</button>
            <table class="table table-buss" id="table-perf"><thead><tr><th>#</th><th>Year</th><th>KPI</th><th>Target</th><th>Actual</th><th>Basis</th><th>Status</th><th>Action</th></tr></thead><tbody>
            <?php if (!$matrix): ?><tr><td colspan="8" style="color:#888;">No KPIs defined.</td></tr><?php else: $i = 1; foreach ($matrix as $r):
              $b = ['Achieved' => 'success', 'On Track' => 'info', 'At Risk' => 'warning', 'Behind' => 'danger'][$r['status']] ?? 'secondary'; ?>
              <tr><td><?= $i++ ?></td><td><?= (int)$r['period_year'] ?></td><td style="text-align:left;"><?= iah($r['kpi_name']) ?></td><td><?= iah($r['target'] ?: '—') ?></td><td><?= iah($r['actual'] ?: '—') ?></td><td style="text-align:left;"><?= iah(mb_strimwidth((string)($r['measurement_basis'] ?? ''), 0, 50, '…')) ?: '—' ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td>
              <td><a href="#" class="btn btn-sm btn-primary editperformance btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-period_year="<?= (int)$r['period_year'] ?>" data-kpi_name="<?= iah($r['kpi_name']) ?>" data-target="<?= iah($r['target']) ?>" data-actual="<?= iah($r['actual']) ?>" data-measurement_basis="<?= iah($r['measurement_basis']) ?>" data-status="<?= iah($r['status']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="performanceaction.php" data-id="<?= (int)$r['id'] ?>" data-label="KPI"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- QA DOCUMENTS -->
          <div class="tab-pane fade" id="q-doc">
            <button class="btn btn-primary btn-sm addqadoc btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Upload</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Year</th><th>Description</th><th>Assessor</th><th>Status</th><th>File</th><th>Action</th></tr></thead><tbody>
            <?php if (!$qadocs): ?><tr><td colspan="7" style="color:#888;">No QA documents.</td></tr><?php else: $i = 1; foreach ($qadocs as $r):
              $b = $r['status'] === 'Final' ? 'success' : 'warning'; ?>
              <tr><td><?= $i++ ?></td><td><?= (int)$r['year'] ?></td><td style="text-align:left;"><?= iah($r['description']) ?></td><td><?= iah($r['assessor_name'] ?: '—') ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td><td><a href="../<?= iah($r['filename']) ?>" target="_blank" class="btn btn-sm btn-light-info"><i class="fas fa-download"></i></a></td>
              <td><a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="qadocaction.php" data-id="<?= (int)$r['id'] ?>" data-label="document"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

        </div>
      </div></div>
    </div>
  </div>

<?php
$engOpts = '<option value="">— none —</option>'; foreach ($engs as $e) $engOpts .= '<option value="' . (int)$e['id'] . '">' . iah($e['title']) . '</option>';
$scoreOpts = '<option value="">—</option>'; for ($s = 1; $s <= 5; $s++) $scoreOpts .= '<option value="' . $s . '">' . $s . '</option>';
?>
  <!-- survey modal -->
  <div class="modal fade" id="survey-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Survey Response</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="surveyform" class="ia-entity-form" data-url="surveyaction.php" data-modal="survey-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id">
      <div class="row"><div class="col-6 form-group ia-add-only"><label>Survey Type <span class="text-danger">*</span></label><select class="form-control" name="survey_type"><option value="client">Client Satisfaction</option><option value="audit_committee">Audit Committee</option><option value="senior_mgmt">Senior Management</option><option value="staff">IA Staff</option></select></div>
      <div class="col-3 form-group"><label>Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="period_year" placeholder="2026"></div>
      <div class="col-3 form-group"><label>Overall Score</label><select class="form-control" name="overall_score"><?= $scoreOpts ?></select></div>
      <div class="col-6 form-group"><label>Respondent Name</label><input class="form-control" name="respondent_name"></div>
      <div class="col-6 form-group"><label>Respondent Role</label><input class="form-control" name="respondent_role"></div>
      <div class="col-6 form-group ia-add-only"><label>Engagement (client surveys)</label><select class="form-control" name="engagement_id"><?= $engOpts ?></select></div>
      <div class="col-6 form-group"><label>Submitted Date</label><input type="date" class="form-control" name="submitted_at"></div>
      <div class="col-12 form-group"><label>Comments</label><textarea class="form-control" name="comments" rows="3"></textarea></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- performance modal -->
  <div class="modal fade" id="performance-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Performance KPI</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="performanceform" class="ia-entity-form" data-url="performanceaction.php" data-modal="performance-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id">
      <div class="row"><div class="col-3 form-group"><label>Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="period_year" placeholder="2026"></div>
      <div class="col-9 form-group"><label>KPI Name <span class="text-danger">*</span></label><input class="form-control" name="kpi_name"></div>
      <div class="col-4 form-group"><label>Target</label><input class="form-control" name="target"></div>
      <div class="col-4 form-group"><label>Actual</label><input class="form-control" name="actual"></div>
      <div class="col-4 form-group"><label>Status</label><select class="form-control" name="status"><?php foreach (['On Track', 'At Risk', 'Behind', 'Achieved'] as $s) echo "<option>$s</option>"; ?></select></div>
      <div class="col-12 form-group"><label>Measurement Basis</label><textarea class="form-control" name="measurement_basis" rows="2"></textarea></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- qa doc modal -->
  <div class="modal fade" id="qadoc-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">QA Document (External Assessment)</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="qadocform" class="ia-entity-form" data-url="qadocaction.php" data-modal="qadoc-modal" enctype="multipart/form-data"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id">
      <div class="row"><div class="col-4 form-group"><label>Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="year" placeholder="2026"></div>
      <div class="col-8 form-group"><label>Assessor</label><input class="form-control" name="assessor_name"></div>
      <div class="col-8 form-group"><label>Description <span class="text-danger">*</span></label><input class="form-control" name="description"></div>
      <div class="col-4 form-group"><label>Status</label><select class="form-control" name="status"><option>Draft</option><option>Final</option></select></div>
      <div class="col-12 form-group"><label>File <span class="text-danger">*</span></label><input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx"></div></div>
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
    <script>['#table-survey','#table-perf'].forEach(function(s){var t=document.querySelector(s); if(t) new simpleDatatables.DataTable(t,{perPage:10});});</script>
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../assets/js/pages/horizontal-layout.js"></script>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
    <script src="../assets/js/ia.js"></script>
</body>
</html>
