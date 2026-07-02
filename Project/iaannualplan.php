<?php
include_once './iaplan/iaannualplanClass.php';
$cls   = new iaannualplanClass();
$plans = $cls->showplans();   // PSASB template 4

function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
$statusOptions = ['Draft', 'Under Review', 'Approved', 'Retired'];

function ia_ap_rows(iaannualplanClass $cls, array $rows): string {
    if (!$rows) return '<tr><td colspan="7" style="text-align:center;color:#888;">No annual plans recorded yet.</td></tr>';
    $n = 1; $html = '';
    foreach ($rows as $r) {
        $badge = ['Approved' => 'success', 'Under Review' => 'warning', 'Retired' => 'secondary'][$r['status']] ?? 'info';
        $items = count($cls->showitems((string)$r['id']));
        $html .= '<tr>'
            . '<td>' . ($n++) . '</td>'
            . '<td>' . (int)$r['plan_year'] . '</td>'
            . '<td style="text-align:left;">' . iah($r['title']) . '</td>'
            . '<td><span class="badge bg-primary">' . $items . ' audit' . ($items === 1 ? '' : 's') . '</span></td>'
            . '<td><span class="badge bg-' . $badge . '">' . iah($r['status']) . '</span></td>'
            . '<td>' . (!empty($r['filename']) ? '<a href="../' . iah($r['filename']) . '" target="_blank" class="btn btn-sm btn-light-info"><i class="fas fa-file-earmark"></i></a>' : '<span style="color:#aaa;">—</span>') . '</td>'
            . '<td>'
                . '<a href="iaannualplanview.php?id=' . (int)$r['id'] . '" class="btn btn-sm btn-success" title="Risk-based schedule"><i class="fas fa-fw fa-list-check"></i> Schedule</a> '
                . '<a href="#" class="btn btn-sm btn-primary editap btn-userpermission-edit" title="Edit"'
                    . ' data-id="' . (int)$r['id'] . '" data-year="' . (int)$r['plan_year'] . '" data-title="' . iah($r['title']) . '"'
                    . ' data-approved_by="' . iah($r['approved_by']) . '" data-approved_date="' . iah($r['approved_date']) . '" data-status="' . iah($r['status']) . '"><i class="fas fa-fw fa-pen"></i></a> '
                . '<a href="#" class="btn btn-sm btn-danger deleteap btn-userpermission-delete" title="Delete"'
                    . ' data-id="' . (int)$r['id'] . '" data-title="' . iah($r['title']) . '"><i class="fas fa-fw fa-trash"></i></a>'
            . '</td></tr>';
    }
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; ?>
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
    <h4><i class="bi bi-calendar2-week-fill"></i> Internal Audit — Annual Plan</h4>
    <p class="text-muted" style="margin:0;font-size:13px;">Annual risk-based audit plan and schedule (PSASB Annual Plan template).</p>
</div>
    <div class="page-content">
        <section class="row"><div class="col-12">
            <section class="section"><div class="card">
                <div class="card-header">
                    <button class="btn btn-primary addap btn-userpermission-add" style="float:right;"><i class="fas fa-fw fa-plus"></i> Add Annual Plan</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-buss" id="table-ap">
                            <thead><tr><th>#</th><th>Year</th><th>Title</th><th>Audits</th><th>Status</th><th>Doc</th><th>Action</th></tr></thead>
                            <tbody><?= ia_ap_rows($cls, $plans) ?></tbody>
                        </table>
                    </div>
                </div>
            </div></section>
        </div></section>
    </div>
  </div>

  <div class="modal fade text-left" id="addap-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Add Annual Plan</h4><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <form id="addapform" enctype="multipart/form-data"><div class="modal-body"><div id="message"></div>
        <div class="row">
          <div class="col-md-3 form-group"><label>Plan Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="plan_year" id="ap_year" placeholder="2026"></div>
          <div class="col-md-9 form-group"><label>Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" id="ap_title"></div>
          <div class="col-md-6 form-group"><label>Approved By</label><input type="text" class="form-control" name="approved_by" id="ap_approved_by"></div>
          <div class="col-md-3 form-group"><label>Approved Date</label><input type="date" class="form-control" name="approved_date" id="ap_approved_date"></div>
          <div class="col-md-3 form-group"><label>Status</label><select class="form-control" name="status" id="ap_status"><?php foreach ($statusOptions as $s) echo '<option>' . iah($s) . '</option>'; ?></select></div>
          <div class="col-md-6 form-group"><label>Document (optional)</label><input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx"></div>
        </div>
      </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary addap-btn">Save Plan</button></div></form>
    </div></div>
  </div>

  <div class="modal fade text-left" id="editap-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Edit Annual Plan</h4><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <form id="editapform" enctype="multipart/form-data"><div class="modal-body"><input type="hidden" name="id" id="eap_id">
        <div class="row">
          <div class="col-md-3 form-group"><label>Plan Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="plan_year" id="eap_year"></div>
          <div class="col-md-9 form-group"><label>Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" id="eap_title"></div>
          <div class="col-md-6 form-group"><label>Approved By</label><input type="text" class="form-control" name="approved_by" id="eap_approved_by"></div>
          <div class="col-md-3 form-group"><label>Approved Date</label><input type="date" class="form-control" name="approved_date" id="eap_approved_date"></div>
          <div class="col-md-3 form-group"><label>Status</label><select class="form-control" name="status" id="eap_status"><?php foreach ($statusOptions as $s) echo '<option>' . iah($s) . '</option>'; ?></select></div>
          <div class="col-md-6 form-group"><label>Replace Document (optional)</label><input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx"></div>
        </div>
      </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary updateap-btn">Update Plan</button></div></form>
    </div></div>
  </div>

  <div class="modal fade text-left" id="deleteap-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
      <div class="modal-header bg-danger"><h5 class="modal-title white">Delete Annual Plan</h5><button type="button" class="close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <div class="modal-body"><input type="hidden" id="dap_id"><h5>Delete this annual plan and all its scheduled audits?</h5><div style="font-weight:600;text-align:center;margin-top:8px;" id="dap_title"></div></div>
      <div class="modal-footer"><button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger confirmdeleteap-btn">Delete</button></div>
    </div></div>
  </div>

        <?php include_once '../layout/footer.php'; ?>
        </div></div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>var t=document.querySelector('#table-ap'); if(t) new simpleDatatables.DataTable(t,{perPage:10});</script>
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../assets/js/pages/horizontal-layout.js"></script>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
    <script src="../assets/js/ia.js"></script>
</body>
</html>
