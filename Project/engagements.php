<?php
include_once './engagement/engagementClass.php';
$engcls = new engagementClass();

function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
$TYPES  = ['Assurance', 'Advisory', 'Investigation', 'Follow-up'];
$STATUS = ['Notified', 'Planning', 'Fieldwork', 'Reporting', 'Closed'];
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; // $showdept,$showrisk,$showusers,$deptClass,$riskClass,$sess_roles,$sdid ?>
<?php
$engagements = ((int)$sess_roles === 1) ? $engcls->showall() : $engcls->showdept((string)$sdid);
// uid -> name map for lead auditor display
$userName = [];
foreach ($showusers as $u) $userName[(int)$u['id']] = trim(($u['fname'] ?? '') . ' ' . ($u['sname'] ?? ''));
?>
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
<div class="page-heading">
    <h4><i class="bi bi-briefcase-fill"></i> Internal Audit — Engagements</h4>
    <p class="text-muted" style="margin:0;font-size:13px;">Audit notifications and engagement lifecycle (PSASB engagement templates).</p>
</div>
    <div class="page-content">
        <section class="row"><div class="col-12">
            <section class="section"><div class="card">
                <div class="card-header">
                    <button class="btn btn-primary addeng btn-userpermission-add" style="float:right;"><i class="fas fa-fw fa-plus"></i> New Engagement</button>
                </div>
                <div class="card-body"><div class="table-responsive">
                    <table class="table table-striped table-buss" id="table-eng">
                        <thead><tr><th>#</th><th>Title</th><th>Department</th><th>Type</th><th>Status</th><th>Planned</th><th>Lead Auditor</th><th>Notif.</th><th>Action</th></tr></thead>
                        <tbody>
                        <?php if (!$engagements): ?>
                            <tr><td colspan="9" style="text-align:center;color:#888;">No engagements yet.</td></tr>
                        <?php else: $n = 1; foreach ($engagements as $e):
                            $badge = ['Closed' => 'success', 'Reporting' => 'warning', 'Fieldwork' => 'info', 'Planning' => 'primary'][$e['status']] ?? 'secondary';
                        ?>
                            <tr>
                                <td><?= $n++ ?></td>
                                <td style="text-align:left;"><?= iah($e['title']) ?></td>
                                <td><?= iah($deptClass->deptJoins((string)$e['dept_id'])) ?></td>
                                <td><?= iah($e['engagement_type']) ?></td>
                                <td><span class="badge bg-<?= $badge ?>"><?= iah($e['status']) ?></span></td>
                                <td><?= $e['planned_start'] ? iah($e['planned_start']) : '—' ?><?= $e['planned_end'] ? ' → ' . iah($e['planned_end']) : '' ?></td>
                                <td><?= iah($userName[(int)$e['lead_auditor']] ?? '—') ?: '—' ?></td>
                                <td><?= !empty($e['notification_filename']) ? '<a href="../' . iah($e['notification_filename']) . '" target="_blank" class="btn btn-sm btn-light-info"><i class="fas fa-file-earmark"></i></a>' : '—' ?></td>
                                <td>
                                    <a href="engagementview.php?id=<?= (int)$e['id'] ?>" class="btn btn-sm btn-success" title="Open workspace"><i class="fas fa-fw fa-folder-open"></i></a>
                                    <a href="#" class="btn btn-sm btn-primary editeng btn-userpermission-edit" title="Edit"
                                        data-id="<?= (int)$e['id'] ?>" data-title="<?= iah($e['title']) ?>" data-dept="<?= (int)$e['dept_id'] ?>" data-type="<?= iah($e['engagement_type']) ?>"
                                        data-risk="<?= (int)($e['risk_id'] ?? 0) ?>" data-scope="<?= iah($e['scope_description']) ?>" data-owner="<?= iah($e['auditee_owner']) ?>"
                                        data-lead="<?= (int)($e['lead_auditor'] ?? 0) ?>" data-start="<?= iah($e['planned_start']) ?>" data-end="<?= iah($e['planned_end']) ?>" data-status="<?= iah($e['status']) ?>"><i class="fas fa-fw fa-pen"></i></a>
                                    <a href="#" class="btn btn-sm btn-danger deleteeng btn-userpermission-delete" title="Delete"
                                        data-id="<?= (int)$e['id'] ?>" data-title="<?= iah($e['title']) ?>"><i class="fas fa-fw fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; endif; ?>
                        </tbody>
                    </table>
                </div></div>
            </div></section>
        </div></section>
    </div>
  </div>

<?php
$deptOpts = ''; foreach ($showdept as $d) $deptOpts .= '<option value="' . (int)$d['dept_id'] . '">' . iah($d['dept_name']) . '</option>';
$riskOpts = '<option value="">— none —</option>'; foreach ($showrisk as $r) $riskOpts .= '<option value="' . (int)$r['risk_id'] . '">' . iah($r['risk_name']) . '</option>';
$userOpts = '<option value="">— unassigned —</option>'; foreach ($showusers as $u) $userOpts .= '<option value="' . (int)$u['id'] . '">' . iah(trim(($u['fname'] ?? '') . ' ' . ($u['sname'] ?? ''))) . '</option>';
$typeOpts = ''; foreach ($TYPES as $t) $typeOpts .= '<option>' . iah($t) . '</option>';
$statusOpts = ''; foreach ($STATUS as $s) $statusOpts .= '<option>' . iah($s) . '</option>';
$engForm = function (string $pfx) use ($deptOpts, $riskOpts, $userOpts, $typeOpts, $statusOpts) { ?>
        <div class="row">
          <div class="col-md-8 form-group"><label>Engagement Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" id="<?= $pfx ?>_title"></div>
          <div class="col-md-4 form-group"><label>Type</label><select class="form-control" name="engagement_type" id="<?= $pfx ?>_type"><?= $typeOpts ?></select></div>
          <div class="col-md-6 form-group"><label>Department <span class="text-danger">*</span></label><select class="form-control" name="dept_id" id="<?= $pfx ?>_dept"><?= $deptOpts ?></select></div>
          <div class="col-md-6 form-group"><label>Related Risk</label><select class="form-control" name="risk_id" id="<?= $pfx ?>_risk"><?= $riskOpts ?></select></div>
          <div class="col-md-12 form-group"><label>Scope</label><textarea class="form-control" name="scope_description" id="<?= $pfx ?>_scope" rows="2"></textarea></div>
          <div class="col-md-6 form-group"><label>Auditee / Owner</label><input type="text" class="form-control" name="auditee_owner" id="<?= $pfx ?>_owner"></div>
          <div class="col-md-6 form-group"><label>Lead Auditor</label><select class="form-control" name="lead_auditor" id="<?= $pfx ?>_lead"><?= $userOpts ?></select></div>
          <div class="col-md-3 form-group"><label>Planned Start</label><input type="date" class="form-control" name="planned_start" id="<?= $pfx ?>_start"></div>
          <div class="col-md-3 form-group"><label>Planned End</label><input type="date" class="form-control" name="planned_end" id="<?= $pfx ?>_end"></div>
          <div class="col-md-3 form-group"><label>Status</label><select class="form-control" name="status" id="<?= $pfx ?>_status"><?= $statusOpts ?></select></div>
          <div class="col-md-3 form-group"><label>Notification (optional)</label><input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx"></div>
        </div>
<?php };
?>
  <!-- ADD engagement -->
  <div class="modal fade text-left" id="addeng-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">New Engagement</h4><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <form id="addengform" enctype="multipart/form-data"><div class="modal-body"><div id="message"></div><input type="hidden" name="mode" value="add"><?php $engForm('eng'); ?></div>
      <div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary addeng-btn">Create</button></div></form>
    </div></div>
  </div>
  <!-- EDIT engagement -->
  <div class="modal fade text-left" id="editeng-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Edit Engagement</h4><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <form id="editengform" enctype="multipart/form-data"><div class="modal-body"><input type="hidden" name="mode" value="update"><input type="hidden" name="id" id="eeng_id"><?php $engForm('eeng'); ?></div>
      <div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary updateeng-btn">Update</button></div></form>
    </div></div>
  </div>
  <!-- DELETE engagement -->
  <div class="modal fade text-left" id="deleteeng-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
      <div class="modal-header bg-danger"><h5 class="modal-title white">Delete Engagement</h5><button type="button" class="close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <div class="modal-body"><input type="hidden" id="deng_id"><h5>Delete this engagement and ALL its planning artefacts?</h5><div style="font-weight:600;text-align:center;margin-top:8px;" id="deng_title"></div></div>
      <div class="modal-footer"><button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger confirmdeleteeng-btn">Delete</button></div>
    </div></div>
  </div>

        <?php include_once '../layout/footer.php'; ?>
        </div></div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>var t=document.querySelector('#table-eng'); if(t) new simpleDatatables.DataTable(t,{perPage:10});</script>
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../assets/js/pages/horizontal-layout.js"></script>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
    <script src="../assets/js/ia.js"></script>
</body>
</html>
