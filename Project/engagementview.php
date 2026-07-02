<?php
include_once './engagement/engagementClass.php';
include_once './engagement/engagementclasses.php';
$engcls = new engagementClass();
$engId  = (isset($_GET['id']) && ctype_digit((string)$_GET['id'])) ? $_GET['id'] : '';
$eng    = $engId !== '' ? $engcls->details($engId) : null;

function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }

if ($eng) {
    $plan     = (new engagementPlanClass())->byEng($engId);
    $ethics   = (new ethicsAckClass())->byEng($engId);
    $reliance = (new relianceClass())->byEng($engId);
    $infoReq  = (new checklistClass())->byEngType($engId, 'info_request');
    $process  = (new processAnalysisClass())->byEng($engId);
    $program  = (new auditProgramClass())->byEng($engId);
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; // $showprocess,$deptClass,$sess_roles ?>
<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
<style>
.role-readonly .btn-userpermission-edit,.role-readonly .btn-userpermission-delete,.role-readonly .btn-userpermission-add,.role-readonly .planbtn{opacity:.4;pointer-events:none;cursor:not-allowed;}
.table-buss{border-collapse:collapse;width:100%;}
.table-buss th{font-size:12px;font-weight:700;color:#fff;background:#02338d;padding:5px 6px;text-align:center;border:1px solid rgba(255,255,255,.3);}
.table-buss td{font-size:12px;font-weight:500;color:#222;padding:4px 6px;text-align:center;border:1px solid #b8c8de;vertical-align:top;}
.ia-tab .nav-link.active{background:#02338d;color:#fff;}.ia-tab .nav-link{color:#02338d;font-weight:600;}
.eng-meta div{font-size:13px;margin-bottom:3px;}
</style>
    <div id="app"><div id="main" class="layout-horizontal">
        <?php include_once '../layout/nav.php'; ?>
            <div class="content-wrapper container">
<?php if (!$eng): ?>
    <div class="page-heading"><h4>Engagement not found</h4></div>
    <div class="page-content"><a href="engagements.php" class="btn btn-secondary">&larr; Back to Engagements</a></div>
<?php else: ?>
<div class="page-heading">
    <h4><i class="bi bi-briefcase-fill"></i> <?= iah($eng['title']) ?></h4>
    <p class="text-muted" style="margin:0;font-size:13px;"><?= iah($deptClass->deptJoins((string)$eng['dept_id'])) ?> · <?= iah($eng['engagement_type']) ?> · Status: <?= iah($eng['status']) ?></p>
</div>
    <div class="page-content">
      <input type="hidden" id="engId" value="<?= (int)$eng['id'] ?>">
      <a href="engagements.php" class="btn btn-light-secondary btn-sm mb-2"><i class="fas fa-arrow-left"></i> Engagements</a>
      <a href="engagementfieldwork.php?id=<?= (int)$eng['id'] ?>" class="btn btn-success btn-sm mb-2"><i class="fas fa-clipboard-data"></i> Fieldwork &amp; Findings &rarr;</a>
      <div class="card"><div class="card-body">
        <ul class="nav nav-tabs ia-tab" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#t-plan">Engagement Plan</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#t-ethics">Ethics (<?= count($ethics) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#t-reliance">Reliance (<?= count($reliance) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#t-info">Info Requests (<?= count($infoReq) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#t-process">Process Analysis (<?= count($process) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#t-program">Audit Program (<?= count($program) ?>)</a></li>
        </ul>
        <div class="tab-content pt-3">

          <!-- PLAN -->
          <div class="tab-pane fade show active" id="t-plan">
            <form id="planform">
              <input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
              <div class="row">
                <div class="col-md-12 form-group"><label>Objectives</label><textarea class="form-control" name="objectives" rows="2"><?= iah($plan['objectives'] ?? '') ?></textarea></div>
                <div class="col-md-6 form-group"><label>Scope</label><textarea class="form-control" name="scope" rows="2"><?= iah($plan['scope'] ?? '') ?></textarea></div>
                <div class="col-md-6 form-group"><label>Criteria</label><textarea class="form-control" name="criteria" rows="2"><?= iah($plan['criteria'] ?? '') ?></textarea></div>
                <div class="col-md-6 form-group"><label>Resources Required</label><textarea class="form-control" name="resources_required" rows="2"><?= iah($plan['resources_required'] ?? '') ?></textarea></div>
                <div class="col-md-6 form-group"><label>Risks to the Engagement</label><textarea class="form-control" name="risks_to_engagement" rows="2"><?= iah($plan['risks_to_engagement'] ?? '') ?></textarea></div>
                <div class="col-md-3 form-group"><label>Planned Start</label><input type="date" class="form-control" name="planned_start" value="<?= iah($plan['planned_start'] ?? '') ?>"></div>
                <div class="col-md-3 form-group"><label>Exit Meeting</label><input type="date" class="form-control" name="exit_meeting" value="<?= iah($plan['exit_meeting'] ?? '') ?>"></div>
                <div class="col-md-3 form-group"><label>Draft Issued</label><input type="date" class="form-control" name="draft_issued" value="<?= iah($plan['draft_issued'] ?? '') ?>"></div>
                <div class="col-md-3 form-group"><label>Final Report</label><input type="date" class="form-control" name="final_report" value="<?= iah($plan['final_report'] ?? '') ?>"></div>
                <div class="col-md-3 form-group"><label>Status</label><select class="form-control" name="status"><?php foreach (['Draft', 'Approved'] as $s) echo '<option' . (($plan['status'] ?? 'Draft') === $s ? ' selected' : '') . '>' . $s . '</option>'; ?></select></div>
              </div>
              <button type="submit" class="btn btn-primary planbtn btn-userpermission-add">Save Engagement Plan</button>
            </form>
          </div>

          <!-- ETHICS -->
          <div class="tab-pane fade" id="t-ethics">
            <button class="btn btn-primary btn-sm addethics btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Auditor</th><th>Acknowledgement</th><th>Signed</th><th>Action</th></tr></thead><tbody>
            <?php if (!$ethics): ?><tr><td colspan="5" style="color:#888;">None recorded.</td></tr><?php else: $i = 1; foreach ($ethics as $r): ?>
              <tr><td><?= $i++ ?></td><td><?= iah($r['auditor_name']) ?></td><td style="text-align:left;"><?= iah($r['acknowledgement_text']) ?></td><td><?= iah($r['signed_date'] ?: '—') ?></td>
              <td><a href="#" class="btn btn-sm btn-primary editethics btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-auditor_name="<?= iah($r['auditor_name']) ?>" data-acknowledgement_text="<?= iah($r['acknowledgement_text']) ?>" data-signed_date="<?= iah($r['signed_date']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="ethicsaction.php" data-id="<?= (int)$r['id'] ?>" data-label="<?= iah($r['auditor_name']) ?>"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- RELIANCE -->
          <div class="tab-pane fade" id="t-reliance">
            <button class="btn btn-primary btn-sm addreliance btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Assurance Provider</th><th>Scope Area</th><th>Reliance Basis</th><th>Action</th></tr></thead><tbody>
            <?php if (!$reliance): ?><tr><td colspan="5" style="color:#888;">None recorded.</td></tr><?php else: $i = 1; foreach ($reliance as $r): ?>
              <tr><td><?= $i++ ?></td><td><?= iah($r['assurance_provider']) ?></td><td><?= iah($r['scope_area']) ?></td><td style="text-align:left;"><?= iah($r['reliance_basis']) ?></td>
              <td><a href="#" class="btn btn-sm btn-primary editreliance btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-assurance_provider="<?= iah($r['assurance_provider']) ?>" data-scope_area="<?= iah($r['scope_area']) ?>" data-reliance_basis="<?= iah($r['reliance_basis']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="relianceaction.php" data-id="<?= (int)$r['id'] ?>" data-label="<?= iah($r['assurance_provider']) ?>"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- INFO REQUESTS -->
          <div class="tab-pane fade" id="t-info">
            <button class="btn btn-primary btn-sm addchecklist btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Item Requested</th><th>From</th><th>Due</th><th>Received</th><th>Status</th><th>Remarks</th><th>Action</th></tr></thead><tbody>
            <?php if (!$infoReq): ?><tr><td colspan="8" style="color:#888;">No information requests.</td></tr><?php else: $i = 1; foreach ($infoReq as $r):
              $b = ['Received' => 'success', 'Overdue' => 'danger', 'Complete' => 'success', 'N/A' => 'secondary'][$r['status']] ?? 'warning'; ?>
              <tr><td><?= $i++ ?></td><td style="text-align:left;"><?= iah($r['item_description']) ?></td><td><?= iah($r['requested_from'] ?: '—') ?></td><td><?= iah($r['due_date'] ?: '—') ?></td><td><?= iah($r['completed_date'] ?: '—') ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td><td style="text-align:left;"><?= iah($r['remarks'] ?: '—') ?></td>
              <td><a href="#" class="btn btn-sm btn-primary editchecklist btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-item_description="<?= iah($r['item_description']) ?>" data-requested_from="<?= iah($r['requested_from']) ?>" data-due_date="<?= iah($r['due_date']) ?>" data-completed_date="<?= iah($r['completed_date']) ?>" data-status="<?= iah($r['status']) ?>" data-remarks="<?= iah($r['remarks']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="checklistaction.php" data-id="<?= (int)$r['id'] ?>" data-label="request"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- PROCESS ANALYSIS -->
          <div class="tab-pane fade" id="t-process">
            <button class="btn btn-primary btn-sm addprocess btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Process</th><th>Owner</th><th>Key Risks</th><th>Key Controls</th><th>Action</th></tr></thead><tbody>
            <?php if (!$process): ?><tr><td colspan="6" style="color:#888;">No process analysis.</td></tr><?php else: $i = 1; foreach ($process as $r): ?>
              <tr><td><?= $i++ ?></td><td style="text-align:left;"><?= iah($r['process_name']) ?></td><td><?= iah($r['process_owner'] ?: '—') ?></td><td style="text-align:left;"><?= iah($r['key_risks'] ?: '—') ?></td><td style="text-align:left;"><?= iah($r['key_controls'] ?: '—') ?></td>
              <td><a href="#" class="btn btn-sm btn-primary editprocess btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-process_id="<?= (int)($r['process_id'] ?? 0) ?>" data-process_name="<?= iah($r['process_name']) ?>" data-process_owner="<?= iah($r['process_owner']) ?>" data-inputs="<?= iah($r['inputs']) ?>" data-activities="<?= iah($r['activities']) ?>" data-outputs="<?= iah($r['outputs']) ?>" data-key_risks="<?= iah($r['key_risks']) ?>" data-key_controls="<?= iah($r['key_controls']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="processanalysisaction.php" data-id="<?= (int)$r['id'] ?>" data-label="<?= iah($r['process_name']) ?>"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- AUDIT PROGRAM -->
          <div class="tab-pane fade" id="t-program">
            <button class="btn btn-primary btn-sm addprogram btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Objective</th><th>Risk</th><th>Control</th><th>Test Procedure</th><th>WP Ref</th><th>Status</th><th>Action</th></tr></thead><tbody>
            <?php if (!$program): ?><tr><td colspan="8" style="color:#888;">No program steps.</td></tr><?php else: $i = 1; foreach ($program as $r):
              $b = ['Completed' => 'success', 'In Progress' => 'warning'][$r['status']] ?? 'info'; ?>
              <tr><td><?= $i++ ?></td><td style="text-align:left;"><?= iah($r['objective']) ?></td><td style="text-align:left;"><?= iah($r['risk_addressed'] ?: '—') ?></td><td style="text-align:left;"><?= iah($r['control_tested'] ?: '—') ?></td><td style="text-align:left;"><?= iah($r['test_procedure']) ?></td><td><?= iah($r['wp_ref'] ?: '—') ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td>
              <td><a href="#" class="btn btn-sm btn-primary editprogram btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-objective="<?= iah($r['objective']) ?>" data-risk_addressed="<?= iah($r['risk_addressed']) ?>" data-control_tested="<?= iah($r['control_tested']) ?>" data-test_procedure="<?= iah($r['test_procedure']) ?>" data-sample_size="<?= iah($r['sample_size']) ?>" data-wp_ref="<?= iah($r['wp_ref']) ?>" data-status="<?= iah($r['status']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="auditprogramaction.php" data-id="<?= (int)$r['id'] ?>" data-label="step"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

        </div>
      </div></div>
    </div>
<?php endif; ?>
  </div>

<?php if ($eng):
    $procOpts = '<option value="">— none —</option>'; foreach ($showprocess as $p) $procOpts .= '<option value="' . (int)$p['process_id'] . '">' . iah($p['process_name']) . '</option>';
?>
  <!-- ethics modal -->
  <div class="modal fade" id="ethics-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Ethics Acknowledgement</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="ethicsform" class="ia-entity-form" data-url="ethicsaction.php" data-modal="ethics-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
      <div class="form-group"><label>Auditor Name <span class="text-danger">*</span></label><input class="form-control" name="auditor_name"></div>
      <div class="form-group"><label>Acknowledgement <span class="text-danger">*</span></label><textarea class="form-control" name="acknowledgement_text" rows="3"></textarea></div>
      <div class="form-group"><label>Signed Date</label><input type="date" class="form-control" name="signed_date"></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- reliance modal -->
  <div class="modal fade" id="reliance-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Reliance Entry</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="relianceform" class="ia-entity-form" data-url="relianceaction.php" data-modal="reliance-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
      <div class="form-group"><label>Assurance Provider <span class="text-danger">*</span></label><input class="form-control" name="assurance_provider"></div>
      <div class="form-group"><label>Scope Area <span class="text-danger">*</span></label><input class="form-control" name="scope_area"></div>
      <div class="form-group"><label>Reliance Basis <span class="text-danger">*</span></label><textarea class="form-control" name="reliance_basis" rows="3"></textarea></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- checklist modal -->
  <div class="modal fade" id="checklist-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Information Request</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="checklistform" class="ia-entity-form" data-url="checklistaction.php" data-modal="checklist-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>"><input type="hidden" name="checklist_type" value="info_request">
      <div class="form-group"><label>Item Requested <span class="text-danger">*</span></label><input class="form-control" name="item_description"></div>
      <div class="row"><div class="col-6 form-group"><label>Requested From</label><input class="form-control" name="requested_from"></div>
      <div class="col-3 form-group"><label>Due Date</label><input type="date" class="form-control" name="due_date"></div>
      <div class="col-3 form-group"><label>Received</label><input type="date" class="form-control" name="completed_date"></div></div>
      <div class="row"><div class="col-6 form-group"><label>Status</label><select class="form-control" name="status"><?php foreach (['Pending', 'Received', 'Overdue', 'Complete', 'N/A'] as $s) echo "<option>$s</option>"; ?></select></div>
      <div class="col-6 form-group"><label>Remarks</label><input class="form-control" name="remarks"></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- process modal -->
  <div class="modal fade" id="process-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Business Process Analysis</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="processform" class="ia-entity-form" data-url="processanalysisaction.php" data-modal="process-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
      <div class="row"><div class="col-6 form-group"><label>Process Name <span class="text-danger">*</span></label><input class="form-control" name="process_name"></div>
      <div class="col-3 form-group"><label>Link Process</label><select class="form-control" name="process_id"><?= $procOpts ?></select></div>
      <div class="col-3 form-group"><label>Process Owner</label><input class="form-control" name="process_owner"></div>
      <div class="col-6 form-group"><label>Inputs</label><textarea class="form-control" name="inputs" rows="2"></textarea></div>
      <div class="col-6 form-group"><label>Activities</label><textarea class="form-control" name="activities" rows="2"></textarea></div>
      <div class="col-6 form-group"><label>Outputs</label><textarea class="form-control" name="outputs" rows="2"></textarea></div>
      <div class="col-6 form-group"><label>Key Risks</label><textarea class="form-control" name="key_risks" rows="2"></textarea></div>
      <div class="col-6 form-group"><label>Key Controls</label><textarea class="form-control" name="key_controls" rows="2"></textarea></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- program modal -->
  <div class="modal fade" id="program-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Audit Program Step</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="programform" class="ia-entity-form" data-url="auditprogramaction.php" data-modal="program-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
      <div class="form-group"><label>Objective <span class="text-danger">*</span></label><input class="form-control" name="objective"></div>
      <div class="row"><div class="col-6 form-group"><label>Risk Addressed</label><input class="form-control" name="risk_addressed"></div>
      <div class="col-6 form-group"><label>Control Tested</label><input class="form-control" name="control_tested"></div></div>
      <div class="form-group"><label>Test Procedure <span class="text-danger">*</span></label><textarea class="form-control" name="test_procedure" rows="3"></textarea></div>
      <div class="row"><div class="col-4 form-group"><label>Sample Size</label><input class="form-control" name="sample_size"></div>
      <div class="col-4 form-group"><label>WP Ref</label><input class="form-control" name="wp_ref"></div>
      <div class="col-4 form-group"><label>Status</label><select class="form-control" name="status"><?php foreach (['Planned', 'In Progress', 'Completed'] as $s) echo "<option>$s</option>"; ?></select></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- shared delete modal -->
  <div class="modal fade" id="iadel-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-dialog-centered"><div class="modal-content"><div class="modal-header bg-danger"><h5 class="modal-title white">Delete</h5><button type="button" class="close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <div class="modal-body"><input type="hidden" id="iadel_id"><input type="hidden" id="iadel_url"><h5>Delete this item?</h5><div style="font-weight:600;text-align:center;margin-top:8px;" id="iadel_label"></div></div>
    <div class="modal-footer"><button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger iadel-confirm">Delete</button></div></div></div></div>
<?php endif; ?>

        <?php include_once '../layout/footer.php'; ?>
        </div></div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../assets/js/pages/horizontal-layout.js"></script>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
    <script src="../assets/js/ia.js"></script>
</body>
</html>
