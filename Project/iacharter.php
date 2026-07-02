<?php
include_once './iacharter/iacharterClass.php';
$charterclass = new iacharterClass();
$acCharters = $charterclass->showchartertype('audit_committee');  // PSASB template 1
$iaCharters = $charterclass->showchartertype('internal_audit');   // PSASB template 2

// page-local escaper (avoid clashing with any header globals)
function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }

$statusOptions = ['Draft', 'Under Review', 'Approved', 'Retired'];

// render one charter table body for a given result set
function ia_charter_rows(array $rows): string {
    if (!$rows) {
        return '<tr><td colspan="8" style="text-align:center;color:#888;">No charters recorded yet.</td></tr>';
    }
    $n = 1;
    $html = '';
    foreach ($rows as $r) {
        $doc = !empty($r['filename'])
            ? '<a href="../' . iah($r['filename']) . '" target="_blank" class="btn btn-sm btn-light-info"><i class="fas fa-file-earmark"></i> File</a>'
            : '<span style="color:#aaa;">—</span>';
        $badge = [
            'Approved'     => 'success',
            'Under Review' => 'warning',
            'Retired'      => 'secondary',
        ][$r['status']] ?? 'info';
        $html .= '<tr>'
            . '<td>' . ($n++) . '</td>'
            . '<td style="text-align:left;">' . iah($r['title']) . '</td>'
            . '<td>' . iah($r['version']) . '</td>'
            . '<td><span class="badge bg-' . $badge . '">' . iah($r['status']) . '</span></td>'
            . '<td>' . iah($r['approved_by']) . '</td>'
            . '<td>' . iah($r['approved_date']) . '</td>'
            . '<td>' . iah($r['review_date']) . '</td>'
            . '<td>'
                . '<a href="iacharterview.php?id=' . (int)$r['id'] . '" target="_blank" class="btn btn-sm btn-info" title="View / Print"><i class="fas fa-fw fa-eye"></i></a> '
                . '<a href="#" class="btn btn-sm btn-primary editcharter btn-userpermission-edit" title="Edit"'
                    . ' data-id="' . (int)$r['id'] . '"'
                    . ' data-title="' . iah($r['title']) . '"'
                    . ' data-version="' . iah($r['version']) . '"'
                    . ' data-content="' . iah($r['content']) . '"'
                    . ' data-approved_by="' . iah($r['approved_by']) . '"'
                    . ' data-approved_date="' . iah($r['approved_date']) . '"'
                    . ' data-review_date="' . iah($r['review_date']) . '"'
                    . ' data-status="' . iah($r['status']) . '"><i class="fas fa-fw fa-pen"></i></a> '
                . '<a href="#" class="btn btn-sm btn-danger deletecharter btn-userpermission-delete" title="Delete"'
                    . ' data-id="' . (int)$r['id'] . '" data-title="' . iah($r['title']) . '"><i class="fas fa-fw fa-trash"></i></a>'
            . '</td>'
            . '</tr>';
    }
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<!-_________________Header location______________________->
<?php include_once '../layout/header.php'; ?>

<body class="<?php echo (isset($sess_roles) && in_array((int)$sess_roles, [1, 3])) ? 'role-readonly' : '' ?>">
<style>
.role-readonly .btn-userpermission-edit,
.role-readonly .btn-userpermission-delete,
.role-readonly .btn-userpermission-add { opacity: 0.4; pointer-events: none; cursor: not-allowed; }
.table-buss { border-collapse: collapse; }
.table-buss th { font-size: 12px; font-weight: 700; color: #fff; background: #02338d; padding: 5px 6px; text-align: center; vertical-align: middle; border: 1px solid rgba(255,255,255,0.3); }
.table-buss td { font-size: 12px; font-weight: 500; color: #222; padding: 4px 6px; text-align: center; vertical-align: middle; border: 1px solid #b8c8de; }
.table-buss tbody tr:hover td { background: #eef4ff; }
.ia-tab .nav-link.active { background:#02338d; color:#fff; }
.ia-tab .nav-link { color:#02338d; font-weight:600; }
</style>
    <div id="app">
        <div id="main" class="layout-horizontal">

 <!-_________________Navigation location______________________->
 <?php include_once '../layout/nav.php'; ?>

            <div class="content-wrapper container">

<div class="page-heading">
    <h4><i class="bi bi-clipboard2-check-fill"></i> Internal Audit — Governance Charters</h4>
    <p class="text-muted" style="margin:0;font-size:13px;">PSASB Model Audit Committee Charter &amp; Model Internal Audit Charter.</p>
</div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
    <!-_________________Content location BEGINING______________________->
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                            <ul class="nav nav-tabs ia-tab" role="tablist">
                                <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#tab-ac" role="tab">Audit Committee Charter</a></li>
                                <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tab-ia" role="tab">Internal Audit Charter</a></li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="tab-pane fade show active" id="tab-ac" role="tabpanel">
                                    <button class="btn btn-primary addcharter btn-userpermission-add" data-type="audit_committee" style="float:right;margin-bottom:10px;">
                                        <i class="fas fa-fw fa-plus"></i> Add Audit Committee Charter</button>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-buss" id="table-ac">
                                            <thead><tr>
                                                <th>#</th><th>Title</th><th>Version</th><th>Status</th><th>Approved By</th><th>Approved Date</th><th>Review Date</th><th>Action</th>
                                            </tr></thead>
                                            <tbody><?= ia_charter_rows($acCharters) ?></tbody>
                                        </table>
                                    </div>
                                </div>

                                <div class="tab-pane fade" id="tab-ia" role="tabpanel">
                                    <button class="btn btn-primary addcharter btn-userpermission-add" data-type="internal_audit" style="float:right;margin-bottom:10px;">
                                        <i class="fas fa-fw fa-plus"></i> Add Internal Audit Charter</button>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-buss" id="table-ia">
                                            <thead><tr>
                                                <th>#</th><th>Title</th><th>Version</th><th>Status</th><th>Approved By</th><th>Approved Date</th><th>Review Date</th><th>Action</th>
                                            </tr></thead>
                                            <tbody><?= ia_charter_rows($iaCharters) ?></tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </section>
    <!-_________________Content location END______________________->
            </div>
        </section>
    </div>

  </div>

  <!----------------------------------- ADD Charter Modal ----------------------------------->
  <div class="modal fade text-left" id="addcharter-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title" id="addcharter-title">Add Charter</h4>
          <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
        </div>
        <form id="addcharterform" enctype="multipart/form-data">
          <div class="modal-body">
            <div id="message"></div>
            <input type="hidden" name="charter_type" id="add_charter_type" value="">
            <div class="row">
              <div class="col-md-8 form-group"><label>Charter Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" id="add_title" placeholder="e.g. Internal Audit Charter 2026" required></div>
              <div class="col-md-4 form-group"><label>Version</label>
                <input type="text" class="form-control" name="version" id="add_version" placeholder="e.g. v1.0"></div>
              <div class="col-md-12 form-group"><label>Charter Content</label>
                <textarea class="form-control" name="content" id="add_content" rows="8" placeholder="Purpose, authority, independence, scope, responsibilities…"></textarea></div>
              <div class="col-md-6 form-group"><label>Approved By</label>
                <input type="text" class="form-control" name="approved_by" id="add_approved_by" placeholder="e.g. Board Audit Committee"></div>
              <div class="col-md-3 form-group"><label>Approved Date</label>
                <input type="date" class="form-control" name="approved_date" id="add_approved_date"></div>
              <div class="col-md-3 form-group"><label>Next Review Date</label>
                <input type="date" class="form-control" name="review_date" id="add_review_date"></div>
              <div class="col-md-6 form-group"><label>Status</label>
                <select class="form-control" name="status" id="add_status">
                  <?php foreach ($statusOptions as $s) echo '<option value="' . iah($s) . '">' . iah($s) . '</option>'; ?>
                </select></div>
              <div class="col-md-6 form-group"><label>Signed Document (PDF/DOC, optional)</label>
                <input type="file" class="form-control" name="file" id="add_file" accept=".pdf,.doc,.docx"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary addcharter-btn">Save Charter</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!----------------------------------- EDIT Charter Modal ----------------------------------->
  <div class="modal fade text-left" id="editcharter-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">Edit Charter</h4>
          <button type="button" class="btn btn-danger close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
        </div>
        <form id="editcharterform" enctype="multipart/form-data">
          <div class="modal-body">
            <input type="hidden" name="id" id="edit_id">
            <div class="row">
              <div class="col-md-8 form-group"><label>Charter Title <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="title" id="edit_title" required></div>
              <div class="col-md-4 form-group"><label>Version</label>
                <input type="text" class="form-control" name="version" id="edit_version"></div>
              <div class="col-md-12 form-group"><label>Charter Content</label>
                <textarea class="form-control" name="content" id="edit_content" rows="8"></textarea></div>
              <div class="col-md-6 form-group"><label>Approved By</label>
                <input type="text" class="form-control" name="approved_by" id="edit_approved_by"></div>
              <div class="col-md-3 form-group"><label>Approved Date</label>
                <input type="date" class="form-control" name="approved_date" id="edit_approved_date"></div>
              <div class="col-md-3 form-group"><label>Next Review Date</label>
                <input type="date" class="form-control" name="review_date" id="edit_review_date"></div>
              <div class="col-md-6 form-group"><label>Status</label>
                <select class="form-control" name="status" id="edit_status">
                  <?php foreach ($statusOptions as $s) echo '<option value="' . iah($s) . '">' . iah($s) . '</option>'; ?>
                </select></div>
              <div class="col-md-6 form-group"><label>Replace Document (optional)</label>
                <input type="file" class="form-control" name="file" id="edit_file" accept=".pdf,.doc,.docx"></div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary updatecharter-btn">Update Charter</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!----------------------------------- DELETE Charter Modal ----------------------------------->
  <div class="modal fade text-left" id="deletecharter-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-danger"><h5 class="modal-title white">Delete Charter</h5>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><i data-feather="x"></i></button>
        </div>
        <div class="modal-body">
          <input type="hidden" id="delete_id">
          <h5>Are you sure you want to delete this charter?</h5>
          <div style="color:#000;font-weight:600;text-align:center;margin-top:8px;" id="delete_title"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-danger confirmdeletecharter-btn">Delete</button>
        </div>
      </div>
    </div>
  </div>

 <!-_________________Footer location______________________->
        <?php include_once '../layout/footer.php'; ?>
        </div>
    </div>

    <script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script>
        ['#table-ac', '#table-ia'].forEach(function (sel) {
            var el = document.querySelector(sel);
            if (el) new simpleDatatables.DataTable(el, { perPage: 10 });
        });
    </script>
    <script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>
    <script src="../assets/js/pages/horizontal-layout.js"></script>
    <script src="../assets/vendors/fontawesome/all.min.js"></script>
    <script src="../assets/js/ia.js"></script>
</body>
</html>
