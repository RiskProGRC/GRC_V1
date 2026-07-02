<?php
include_once './iaplan/iastrategicplanClass.php';
$cls   = new iastrategicplanClass();
$plans = $cls->showall();   // PSASB template 3

function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
$statusOptions = ['Draft', 'Under Review', 'Approved', 'Retired'];

function ia_sp_rows(array $rows): string {
    if (!$rows) return '<tr><td colspan="7" style="text-align:center;color:#888;">No strategic plans recorded yet.</td></tr>';
    $n = 1; $html = '';
    foreach ($rows as $r) {
        $badge = ['Approved' => 'success', 'Under Review' => 'warning', 'Retired' => 'secondary'][$r['status']] ?? 'info';
        $obj = mb_strimwidth((string)$r['objectives'], 0, 70, '…');
        $html .= '<tr>'
            . '<td>' . ($n++) . '</td>'
            . '<td style="text-align:left;">' . iah($r['title']) . '</td>'
            . '<td>' . (int)$r['period_start_year'] . ' – ' . (int)$r['period_end_year'] . '</td>'
            . '<td style="text-align:left;">' . iah($obj) . '</td>'
            . '<td><span class="badge bg-' . $badge . '">' . iah($r['status']) . '</span></td>'
            . '<td>' . (!empty($r['filename']) ? '<a href="../' . iah($r['filename']) . '" target="_blank" class="btn btn-sm btn-light-info"><i class="fas fa-file-earmark"></i></a>' : '<span style="color:#aaa;">—</span>') . '</td>'
            . '<td>'
                . '<a href="iastrategicplanview.php?id=' . (int)$r['id'] . '" target="_blank" class="btn btn-sm btn-info" title="View / Print"><i class="fas fa-fw fa-eye"></i></a> '
                . '<a href="#" class="btn btn-sm btn-primary editsp btn-userpermission-edit" title="Edit"'
                    . ' data-id="' . (int)$r['id'] . '"'
                    . ' data-title="' . iah($r['title']) . '"'
                    . ' data-start="' . (int)$r['period_start_year'] . '"'
                    . ' data-end="' . (int)$r['period_end_year'] . '"'
                    . ' data-objectives="' . iah($r['objectives']) . '"'
                    . ' data-resource="' . iah($r['resource_plan']) . '"'
                    . ' data-status="' . iah($r['status']) . '"><i class="fas fa-fw fa-pen"></i></a> '
                . '<a href="#" class="btn btn-sm btn-danger deletesp btn-userpermission-delete" title="Delete"'
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
    <h4><i class="bi bi-diagram-3-fill"></i> Internal Audit — Strategic Plan</h4>
    <p class="text-muted" style="margin:0;font-size:13px;">Multi-year, risk-based internal audit strategy (PSASB Strategic Plan template).</p>
</div>
    <div class="page-content">
        <section class="row"><div class="col-12">
            <section class="section"><div class="card">
                <div class="card-header">
                    <button class="btn btn-primary addsp btn-userpermission-add" style="float:right;"><i class="fas fa-fw fa-plus"></i> Add Strategic Plan</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-buss" id="table-sp">
                            <thead><tr><th>#</th><th>Title</th><th>Period</th><th>Objectives</th><th>Status</th><th>Doc</th><th>Action</th></tr></thead>
                            <tbody><?= ia_sp_rows($plans) ?></tbody>
                        </table>
                    </div>
                </div>
            </div></section>
        </div></section>
    </div>
  </div>

  <!-- ADD / EDIT modal (shared form fields, separate forms) -->
  <div class="modal fade text-left" id="addsp-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Add Strategic Plan</h4>
        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <form id="addspform" enctype="multipart/form-data"><div class="modal-body">
        <div id="message"></div>
        <div class="row">
          <div class="col-md-8 form-group"><label>Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" id="sp_title" required></div>
          <div class="col-md-2 form-group"><label>From Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="period_start_year" id="sp_start" placeholder="2026"></div>
          <div class="col-md-2 form-group"><label>To Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="period_end_year" id="sp_end" placeholder="2028"></div>
          <div class="col-md-12 form-group"><label>Strategic Objectives <span class="text-danger">*</span></label><textarea class="form-control" name="objectives" id="sp_objectives" rows="5"></textarea></div>
          <div class="col-md-12 form-group"><label>Resource Plan</label><textarea class="form-control" name="resource_plan" id="sp_resource" rows="3"></textarea></div>
          <div class="col-md-6 form-group"><label>Status</label><select class="form-control" name="status" id="sp_status"><?php foreach ($statusOptions as $s) echo '<option>' . iah($s) . '</option>'; ?></select></div>
          <div class="col-md-6 form-group"><label>Document (PDF/DOC, optional)</label><input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx"></div>
        </div>
      </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary addsp-btn">Save Plan</button></div></form>
    </div></div>
  </div>

  <div class="modal fade text-left" id="editsp-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg"><div class="modal-content">
      <div class="modal-header"><h4 class="modal-title">Edit Strategic Plan</h4>
        <button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <form id="editspform" enctype="multipart/form-data"><div class="modal-body">
        <input type="hidden" name="id" id="esp_id">
        <div class="row">
          <div class="col-md-8 form-group"><label>Title <span class="text-danger">*</span></label><input type="text" class="form-control" name="title" id="esp_title" required></div>
          <div class="col-md-2 form-group"><label>From Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="period_start_year" id="esp_start"></div>
          <div class="col-md-2 form-group"><label>To Year <span class="text-danger">*</span></label><input type="number" class="form-control" name="period_end_year" id="esp_end"></div>
          <div class="col-md-12 form-group"><label>Strategic Objectives <span class="text-danger">*</span></label><textarea class="form-control" name="objectives" id="esp_objectives" rows="5"></textarea></div>
          <div class="col-md-12 form-group"><label>Resource Plan</label><textarea class="form-control" name="resource_plan" id="esp_resource" rows="3"></textarea></div>
          <div class="col-md-6 form-group"><label>Status</label><select class="form-control" name="status" id="esp_status"><?php foreach ($statusOptions as $s) echo '<option>' . iah($s) . '</option>'; ?></select></div>
          <div class="col-md-6 form-group"><label>Replace Document (optional)</label><input type="file" class="form-control" name="file" accept=".pdf,.doc,.docx"></div>
        </div>
      </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary updatesp-btn">Update Plan</button></div></form>
    </div></div>
  </div>

  <div class="modal fade text-left" id="deletesp-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered"><div class="modal-content">
      <div class="modal-header bg-danger"><h5 class="modal-title white">Delete Strategic Plan</h5><button type="button" class="close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
      <div class="modal-body"><input type="hidden" id="dsp_id"><h5>Delete this strategic plan?</h5><div style="font-weight:600;text-align:center;margin-top:8px;" id="dsp_title"></div></div>
      <div class="modal-footer"><button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button><button type="button" class="btn btn-danger confirmdeletesp-btn">Delete</button></div>
    </div></div>
  </div>

        <?php include_once '../layout/footer.php'; ?>
        </div></div>
    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>var t=document.querySelector('#table-sp'); if(t) new simpleDatatables.DataTable(t,{perPage:10});</script>
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../assets/js/pages/horizontal-layout.js"></script>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
    <script src="../assets/js/ia.js"></script>
</body>
</html>
