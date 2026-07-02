<?php
include_once './iaplan/iaannualplanClass.php';
$apcls  = new iaannualplanClass();
$planId = (isset($_GET['id']) && ctype_digit((string)$_GET['id'])) ? $_GET['id'] : '';
$plan   = $planId !== '' ? $apcls->planDetails($planId) : null;
$items  = $plan ? $apcls->showitems($planId) : [];

function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
$ITEM_STATUS = ['Planned', 'In Progress', 'Completed', 'Deferred', 'Cancelled'];
$RATINGS     = ['Critical', 'High', 'Medium', 'Low'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; // provides $showdept,$showprocess,$showrisk,$deptClass,$processClass,$riskClass,$sess_roles ?>
<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
<style>
.role-readonly .btn-userpermission-edit,.role-readonly .btn-userpermission-delete,.role-readonly .btn-userpermission-add{opacity:.4;pointer-events:none;cursor:not-allowed;}
.table-buss{border-collapse:collapse;}
.table-buss th{font-size:12px;font-weight:700;color:#fff;background:#02338d;padding:5px 6px;text-align:center;border:1px solid rgba(255,255,255,.3);}
.table-buss td{font-size:12px;font-weight:500;color:#222;padding:4px 6px;text-align:center;border:1px solid #b8c8de;}
.table-buss tbody tr:hover td{background:#eef4ff;}
</style>
    <div id="app"><div id="main" class="layout-horizontal">
        <?php include_once '../layout/nav.php'; ?>
            <div class="content-wrapper container">
<?php if (!$plan): ?>
    <div class="page-heading"><h4>Annual Plan not found</h4></div>
    <div class="page-content"><a href="iaannualplan.php" class="btn btn-secondary">&larr; Back to Annual Plans</a></div>
<?php else: ?>
<div class="page-heading">
    <h4><i class="bi bi-calendar2-week-fill"></i> Annual Plan <?= (int)$plan['plan_year'] ?> — Risk-Based Schedule</h4>
    <p class="text-muted" style="margin:0;font-size:13px;"><?= iah($plan['title']) ?> · Status: <?= iah($plan['status']) ?></p>
</div>
    <div class="page-content">
        <section class="row"><div class="col-12">
            <section class="section"><div class="card">
                <div class="card-header">
                    <a href="iaannualplan.php" class="btn btn-light-secondary btn-sm"><i class="fas fa-arrow-left"></i> Plans</a>
                    <a href="iaannualplanprint.php?id=<?= (int)$plan['id'] ?>" target="_blank" class="btn btn-info btn-sm"><i class="fas fa-print"></i> Print Schedule</a>
                    <button class="btn btn-primary additem btn-userpermission-add" style="float:right;"><i class="fas fa-fw fa-plus"></i> Add Audit to Schedule</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-buss" id="table-item">
                            <thead><tr><th>#</th><th>Audit Area / Title</th><th>Department</th><th>Process</th><th>Related Risk</th><th>Rating</th><th>Qtr</th><th>Days</th><th>Status</th><th>Action</th></tr></thead>
                            <tbody>
                            <?php if (!$items): ?>
                                <tr><td colspan="10" style="text-align:center;color:#888;">No audits scheduled yet.</td></tr>
                            <?php else: $n = 1; foreach ($items as $it):
                                $badge = ['Completed' => 'success', 'In Progress' => 'warning', 'Deferred' => 'secondary', 'Cancelled' => 'danger'][$it['status']] ?? 'info';
                            ?>
                                <tr>
                                    <td><?= $n++ ?></td>
                                    <td style="text-align:left;"><?= iah($it['audit_title']) ?></td>
                                    <td><?= iah($deptClass->deptJoins((string)$it['dept_id'])) ?></td>
                                    <td><?= $it['process_id'] ? iah($processClass->processJoins((string)$it['process_id'])) : '—' ?></td>
                                    <td style="text-align:left;"><?= $it['risk_id'] ? iah($riskClass->Riskjoin((string)$it['risk_id'])) : '—' ?></td>
                                    <td><?= iah($it['risk_rating'] ?: '—') ?></td>
                                    <td><?= $it['quarter_planned'] ? 'Q' . (int)$it['quarter_planned'] : '—' ?></td>
                                    <td><?= $it['budgeted_days'] !== null ? (int)$it['budgeted_days'] : '—' ?></td>
                                    <td><span class="badge bg-<?= $badge ?>"><?= iah($it['status']) ?></span></td>
                                    <td>
                                        <a href="#" class="btn btn-sm btn-primary edititem btn-userpermission-edit" title="Edit"
                                            data-id="<?= (int)$it['id'] ?>" data-dept="<?= (int)$it['dept_id'] ?>" data-process="<?= (int)($it['process_id'] ?? 0) ?>"
                                            data-risk="<?= (int)($it['risk_id'] ?? 0) ?>" data-title="<?= iah($it['audit_title']) ?>" data-rating="<?= iah($it['risk_rating']) ?>"
                                            data-quarter="<?= (int)($it['quarter_planned'] ?? 0) ?>" data-days="<?= iah($it['budgeted_days']) ?>" data-status="<?= iah($it['status']) ?>"><i class="fas fa-fw fa-pen"></i></a>
                                        <a href="#" class="btn btn-sm btn-danger deleteitem btn-userpermission-delete" title="Delete"
                                            data-id="<?= (int)$it['id'] ?>" data-title="<?= iah($it['audit_title']) ?>"><i class="fas fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div></section>
        </div></section>
    </div>
<?php endif; ?>
  </div>

<?php if ($plan):
    // shared option builders for the item modals
    $deptOpts = '';
    foreach ($showdept as $d) $deptOpts .= '<option value="' . (int)$d['dept_id'] . '">' . iah($d['dept_name']) . '</option>';
    $procOpts = '<option value="">— none —</option>';
    foreach ($showprocess as $p) $procOpts .= '<option value="' . (int)$p['process_id'] . '">' . iah($p['process_name']) . '</option>';
    $riskOpts = '<option value="">— none —</option>';
    foreach ($showrisk as $rk) $riskOpts .= '<option value="' . (int)$rk['risk_id'] . '">' . iah($rk['risk_name']) . '</option>';
    $statusOpts = ''; foreach ($ITEM_STATUS as $s) $statusOpts .= '<option>' . iah($s) . '</option>';
    $ratingOpts = '<option value="">— none —</option>'; foreach ($RATINGS as $r) $ratingOpts .= '<option>' . iah($r) . '</option>';
    $qtrOpts = '<option value="">—</option>'; for ($q = 1; $q <= 4; $q++) $qtrOpts .= '<option value="' . $q . '">Q' . $q . '</option>';
?>
  <!-- ADD item -->
  <div class="modal fade text-left" id="additem-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Add Audit to Schedule</h4><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <form id="additemform"><div class="modal-body"><div id="message"></div>
        <input type="hidden" name="annual_plan_id" value="<?= (int)$plan['id'] ?>">
        <div class="row">
          <div class="col-md-12 form-group"><label>Audit Area / Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="audit_title" id="it_title"></div>
          <div class="col-md-6 form-group"><label>Department <span class="text-danger">*</span></label><select class="form-control" name="dept_id" id="it_dept"><?= $deptOpts ?></select></div>
          <div class="col-md-6 form-group"><label>Process</label><select class="form-control" name="process_id" id="it_process"><?= $procOpts ?></select></div>
          <div class="col-md-6 form-group"><label>Related Risk</label><select class="form-control" name="risk_id" id="it_risk"><?= $riskOpts ?></select></div>
          <div class="col-md-3 form-group"><label>Risk Rating</label><select class="form-control" name="risk_rating" id="it_rating"><?= $ratingOpts ?></select></div>
          <div class="col-md-3 form-group"><label>Quarter</label><select class="form-control" name="quarter_planned" id="it_quarter"><?= $qtrOpts ?></select></div>
          <div class="col-md-3 form-group"><label>Budgeted Days</label><input type="number" class="form-control" name="budgeted_days" id="it_days"></div>
          <div class="col-md-3 form-group"><label>Status</label><select class="form-control" name="status" id="it_status"><?= $statusOpts ?></select></div>
        </div>
      </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary additem-btn">Add Audit</button></div></form>
    </div></div>
  </div>
  <!-- EDIT item -->
  <div class="modal fade text-left" id="edititem-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Edit Scheduled Audit</h4><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <form id="edititemform"><div class="modal-body"><input type="hidden" name="id" id="eit_id">
        <div class="row">
          <div class="col-md-12 form-group"><label>Audit Area / Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="audit_title" id="eit_title"></div>
          <div class="col-md-6 form-group"><label>Department <span class="text-danger">*</span></label><select class="form-control" name="dept_id" id="eit_dept"><?= $deptOpts ?></select></div>
          <div class="col-md-6 form-group"><label>Process</label><select class="form-control" name="process_id" id="eit_process"><?= $procOpts ?></select></div>
          <div class="col-md-6 form-group"><label>Related Risk</label><select class="form-control" name="risk_id" id="eit_risk"><?= $riskOpts ?></select></div>
          <div class="col-md-3 form-group"><label>Risk Rating</label><select class="form-control" name="risk_rating" id="eit_rating"><?= $ratingOpts ?></select></div>
          <div class="col-md-3 form-group"><label>Quarter</label><select class="form-control" name="quarter_planned" id="eit_quarter"><?= $qtrOpts ?></select></div>
          <div class="col-md-3 form-group"><label>Budgeted Days</label><input type="number" class="form-control" name="budgeted_days" id="eit_days"></div>
          <div class="col-md-3 form-group"><label>Status</label><select class="form-control" name="status" id="eit_status"><?= $statusOpts ?></select></div>
        </div>
      </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary updateitem-btn">Update</button></div></form>
    </div></div>
  </div>
  <!-- DELETE item -->
  <div class="modal fade text-left" id="deleteitem-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
      <div class="modal-header bg-danger"><h5 class="modal-title white">Remove Scheduled Audit</h5><button type="button" class="close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <div class="modal-body"><input type="hidden" id="dit_id"><h5>Remove this audit from the schedule?</h5><div style="font-weight:600;text-align:center;margin-top:8px;" id="dit_title"></div></div>
      <div class="modal-footer"><button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger confirmdeleteitem-btn">Delete</button></div>
    </div></div>
  </div>
<?php endif; ?>

        <?php include_once '../layout/footer.php'; ?>
        </div></div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>var t=document.querySelector('#table-item'); if(t) new simpleDatatables.DataTable(t,{perPage:15});</script>
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../assets/js/pages/horizontal-layout.js"></script>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
    <script src="../assets/js/ia.js"></script>
</body>
</html>
