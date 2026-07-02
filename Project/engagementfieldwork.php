<?php
include_once './engagement/engagementClass.php';
include_once './engagement/engagementclasses.php';
include_once './engagement/fieldworkclasses.php';
$engcls = new engagementClass();
$engId  = (isset($_GET['id']) && ctype_digit((string)$_GET['id'])) ? $_GET['id'] : '';
$eng    = $engId !== '' ? $engcls->details($engId) : null;
function iah($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }

if ($eng) {
    $meetings   = (new meetingClass())->byEng($engId);
    $workpapers = (new workpaperClass())->byEng($engId);
    $fcls       = new findingClass();
    $findings   = $fcls->byEng($engId);
    $ratings    = $fcls->ratings();
    $wpchecks   = (new checklistClass())->byEngType($engId, 'workpaper_file');
    $reviews    = (new reviewNoteClass())->byEng($engId);
    $docs       = (new engDocClass())->byEng($engId);
    $ratingMap  = []; foreach ($ratings as $rt) $ratingMap[(int)$rt['id']] = $rt['grade'];
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; // $showdept,$showrisk,$deptClass,$sess_roles ?>
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
<?php if (!$eng): ?>
    <div class="page-heading"><h4>Engagement not found</h4></div>
    <div class="page-content"><a href="engagements.php" class="btn btn-secondary">&larr; Engagements</a></div>
<?php else: ?>
<div class="page-heading">
    <h4><i class="bi bi-clipboard-data-fill"></i> <?= iah($eng['title']) ?> — Fieldwork</h4>
    <p class="text-muted" style="margin:0;font-size:13px;"><?= iah($deptClass->deptJoins((string)$eng['dept_id'])) ?> · Status: <?= iah($eng['status']) ?></p>
</div>
    <div class="page-content">
      <a href="engagementview.php?id=<?= (int)$eng['id'] ?>" class="btn btn-light-secondary btn-sm mb-2"><i class="fas fa-arrow-left"></i> Planning</a>
      <a href="engagements.php" class="btn btn-light-secondary btn-sm mb-2">Engagements</a>
      <div class="card"><div class="card-body">
        <ul class="nav nav-tabs ia-tab" role="tablist">
          <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#f-meet">Meetings (<?= count($meetings) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#f-wp">Workpapers (<?= count($workpapers) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#f-find">Findings (<?= count($findings) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#f-wpc">WP Checklist (<?= count($wpchecks) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#f-rev">Review Notes (<?= count($reviews) ?>)</a></li>
          <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#f-doc">Documents (<?= count($docs) ?>)</a></li>
        </ul>
        <div class="tab-content pt-3">

          <!-- MEETINGS -->
          <div class="tab-pane fade show active" id="f-meet">
            <button class="btn btn-primary btn-sm addmeeting btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Type</th><th>Record</th><th>Date</th><th>Venue</th><th>Participants</th><th>Action</th></tr></thead><tbody>
            <?php if (!$meetings): ?><tr><td colspan="7" style="color:#888;">No meeting records.</td></tr><?php else: $i = 1; foreach ($meetings as $r): ?>
              <tr><td><?= $i++ ?></td><td><?= ucfirst(iah($r['meeting_type'])) ?></td><td><?= ucfirst(iah($r['record_type'])) ?></td><td><?= iah($r['mdate'] ?: '—') ?></td><td><?= iah($r['venue'] ?: '—') ?></td><td style="text-align:left;"><?= iah($r['participants'] ?: '—') ?></td>
              <td><a href="#" class="btn btn-sm btn-primary editmeeting btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-meeting_type="<?= iah($r['meeting_type']) ?>" data-record_type="<?= iah($r['record_type']) ?>" data-venue="<?= iah($r['venue']) ?>" data-mdate="<?= iah($r['mdate']) ?>" data-participants="<?= iah($r['participants']) ?>" data-content="<?= iah($r['content']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="meetingaction.php" data-id="<?= (int)$r['id'] ?>" data-label="meeting"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- WORKPAPERS -->
          <div class="tab-pane fade" id="f-wp">
            <button class="btn btn-primary btn-sm addworkpaper btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Ref</th><th>Title</th><th>Preparer</th><th>Reviewer</th><th>Status</th><th>Action</th></tr></thead><tbody>
            <?php if (!$workpapers): ?><tr><td colspan="7" style="color:#888;">No workpapers.</td></tr><?php else: $i = 1; foreach ($workpapers as $r):
              $b = ['Finalized' => 'success', 'In Review' => 'warning'][$r['status']] ?? 'info'; ?>
              <tr><td><?= $i++ ?></td><td><?= iah($r['wp_ref']) ?></td><td style="text-align:left;"><?= iah($r['title']) ?></td><td><?= iah($r['preparer'] ?: '—') ?></td><td><?= iah($r['reviewer'] ?: '—') ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td>
              <td><a href="#" class="btn btn-sm btn-primary editworkpaper btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-wp_ref="<?= iah($r['wp_ref']) ?>" data-title="<?= iah($r['title']) ?>" data-objective="<?= iah($r['objective']) ?>" data-procedures_performed="<?= iah($r['procedures_performed']) ?>" data-conclusion="<?= iah($r['conclusion']) ?>" data-preparer="<?= iah($r['preparer']) ?>" data-prepared_date="<?= iah($r['prepared_date']) ?>" data-reviewer="<?= iah($r['reviewer']) ?>" data-reviewed_date="<?= iah($r['reviewed_date']) ?>" data-status="<?= iah($r['status']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="workpaperaction.php" data-id="<?= (int)$r['id'] ?>" data-label="<?= iah($r['wp_ref']) ?>"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- FINDINGS -->
          <div class="tab-pane fade" id="f-find">
            <button class="btn btn-primary btn-sm addfinding btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Finding</th><th>Rating</th><th>Recommendation</th><th>Responsible</th><th>Target</th><th>Status</th><th>Action</th></tr></thead><tbody>
            <?php if (!$findings): ?><tr><td colspan="8" style="color:#888;">No findings.</td></tr><?php else: $i = 1; foreach ($findings as $r):
              $b = ['Closed' => 'success', 'Overdue' => 'danger', 'Open' => 'warning'][$r['status']] ?? 'secondary'; ?>
              <tr><td><?= $i++ ?></td><td style="text-align:left;"><?= iah(mb_strimwidth((string)$r['finding'], 0, 90, '…')) ?></td><td><?= iah($ratingMap[(int)$r['rating']] ?? '—') ?></td><td style="text-align:left;"><?= iah(mb_strimwidth((string)$r['recommend'], 0, 70, '…')) ?></td><td><?= iah($r['responsible_officer'] ?: '—') ?></td><td><?= iah($r['timeline'] ?: '—') ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td>
              <td><a href="#" class="btn btn-sm btn-primary editfinding btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-dept_id="<?= (int)($r['dept_id'] ?? 0) ?>" data-risk_id="<?= (int)($r['risk_id'] ?? 0) ?>" data-rating="<?= (int)($r['rating'] ?? 0) ?>" data-finding="<?= iah($r['finding']) ?>" data-root_cause="<?= iah($r['root_cause']) ?>" data-recommend="<?= iah($r['recommend']) ?>" data-management_response="<?= iah($r['management_response']) ?>" data-responsible_officer="<?= iah($r['responsible_officer']) ?>" data-status="<?= iah($r['status']) ?>" data-timeline="<?= iah($r['timeline']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="findingaction.php" data-id="<?= (int)$r['id'] ?>" data-label="finding"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- WP CHECKLIST -->
          <div class="tab-pane fade" id="f-wpc">
            <button class="btn btn-primary btn-sm addwpcheck btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Checklist Item</th><th>Status</th><th>Remarks</th><th>Action</th></tr></thead><tbody>
            <?php if (!$wpchecks): ?><tr><td colspan="5" style="color:#888;">No checklist items.</td></tr><?php else: $i = 1; foreach ($wpchecks as $r):
              $b = ['Complete' => 'success', 'N/A' => 'secondary'][$r['status']] ?? 'warning'; ?>
              <tr><td><?= $i++ ?></td><td style="text-align:left;"><?= iah($r['item_description']) ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td><td style="text-align:left;"><?= iah($r['remarks'] ?: '—') ?></td>
              <td><a href="#" class="btn btn-sm btn-primary editwpcheck btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-item_description="<?= iah($r['item_description']) ?>" data-status="<?= iah($r['status']) ?>" data-remarks="<?= iah($r['remarks']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="checklistaction.php" data-id="<?= (int)$r['id'] ?>" data-label="item"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- REVIEW NOTES -->
          <div class="tab-pane fade" id="f-rev">
            <button class="btn btn-primary btn-sm addreview btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Add</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>WP Ref</th><th>Reviewer</th><th>Comment</th><th>Response</th><th>Status</th><th>Action</th></tr></thead><tbody>
            <?php if (!$reviews): ?><tr><td colspan="7" style="color:#888;">No review notes.</td></tr><?php else: $i = 1; foreach ($reviews as $r):
              $b = $r['status'] === 'Cleared' ? 'success' : 'warning'; ?>
              <tr><td><?= $i++ ?></td><td><?= iah($r['wp_ref'] ?: '—') ?></td><td><?= iah($r['reviewer']) ?></td><td style="text-align:left;"><?= iah($r['review_comment']) ?></td><td style="text-align:left;"><?= iah($r['preparer_response'] ?: '—') ?></td><td><span class="badge bg-<?= $b ?>"><?= iah($r['status']) ?></span></td>
              <td><a href="#" class="btn btn-sm btn-primary editreview btn-userpermission-edit" data-id="<?= (int)$r['id'] ?>" data-wp_ref="<?= iah($r['wp_ref']) ?>" data-reviewer="<?= iah($r['reviewer']) ?>" data-review_comment="<?= iah($r['review_comment']) ?>" data-preparer_response="<?= iah($r['preparer_response']) ?>" data-status="<?= iah($r['status']) ?>" data-raised_date="<?= iah($r['raised_date']) ?>" data-cleared_date="<?= iah($r['cleared_date']) ?>"><i class="fas fa-pen"></i></a>
              <a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="reviewnoteaction.php" data-id="<?= (int)$r['id'] ?>" data-label="note"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

          <!-- DOCUMENTS -->
          <div class="tab-pane fade" id="f-doc">
            <button class="btn btn-primary btn-sm adddoc btn-userpermission-add" style="float:right;margin-bottom:8px;"><i class="fas fa-plus"></i> Upload</button>
            <table class="table table-buss"><thead><tr><th>#</th><th>Type</th><th>Description</th><th>File</th><th>Action</th></tr></thead><tbody>
            <?php if (!$docs): ?><tr><td colspan="5" style="color:#888;">No documents.</td></tr><?php else: $i = 1; foreach ($docs as $r): ?>
              <tr><td><?= $i++ ?></td><td><?= iah($r['doc_type'] ?: '—') ?></td><td style="text-align:left;"><?= iah($r['description'] ?: '—') ?></td><td><a href="../<?= iah($r['filename']) ?>" target="_blank" class="btn btn-sm btn-light-info"><i class="fas fa-download"></i></a></td>
              <td><a href="#" class="btn btn-sm btn-danger ia-del btn-userpermission-delete" data-url="engdocaction.php" data-id="<?= (int)$r['id'] ?>" data-label="document"><i class="fas fa-trash"></i></a></td></tr>
            <?php endforeach; endif; ?></tbody></table>
          </div>

        </div>
      </div></div>
    </div>
<?php endif; ?>
  </div>

<?php if ($eng):
  $ratingOpts = '<option value="">— none —</option>'; foreach ($ratings as $rt) $ratingOpts .= '<option value="' . (int)$rt['id'] . '">' . iah($rt['grade']) . '</option>';
  $deptOpts = '<option value="">— none —</option>'; foreach ($showdept as $d) $deptOpts .= '<option value="' . (int)$d['dept_id'] . '">' . iah($d['dept_name']) . '</option>';
  $riskOpts = '<option value="">— none —</option>'; foreach ($showrisk as $rk) $riskOpts .= '<option value="' . (int)$rk['risk_id'] . '">' . iah($rk['risk_name']) . '</option>';
?>
  <!-- meeting modal -->
  <div class="modal fade" id="meeting-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Meeting Record</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="meetingform" class="ia-entity-form" data-url="meetingaction.php" data-modal="meeting-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
      <div class="row"><div class="col-3 form-group"><label>Type</label><select class="form-control" name="meeting_type"><option value="entrance">Entrance</option><option value="exit">Exit</option></select></div>
      <div class="col-3 form-group"><label>Record</label><select class="form-control" name="record_type"><option value="agenda">Agenda</option><option value="minutes">Minutes</option></select></div>
      <div class="col-3 form-group"><label>Date</label><input type="date" class="form-control" name="mdate"></div>
      <div class="col-3 form-group"><label>Venue</label><input class="form-control" name="venue"></div>
      <div class="col-12 form-group"><label>Participants</label><textarea class="form-control" name="participants" rows="2"></textarea></div>
      <div class="col-12 form-group"><label>Agenda / Minutes</label><textarea class="form-control" name="content" rows="4"></textarea></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- workpaper modal -->
  <div class="modal fade" id="workpaper-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Workpaper</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="workpaperform" class="ia-entity-form" data-url="workpaperaction.php" data-modal="workpaper-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
      <div class="row"><div class="col-3 form-group"><label>WP Ref <span class="text-danger">*</span></label><input class="form-control" name="wp_ref"></div>
      <div class="col-6 form-group"><label>Title <span class="text-danger">*</span></label><input class="form-control" name="title"></div>
      <div class="col-3 form-group"><label>Status</label><select class="form-control" name="status"><?php foreach (['Draft', 'In Review', 'Finalized'] as $s) echo "<option>$s</option>"; ?></select></div>
      <div class="col-12 form-group"><label>Objective</label><textarea class="form-control" name="objective" rows="2"></textarea></div>
      <div class="col-12 form-group"><label>Procedures Performed</label><textarea class="form-control" name="procedures_performed" rows="3"></textarea></div>
      <div class="col-12 form-group"><label>Conclusion</label><textarea class="form-control" name="conclusion" rows="2"></textarea></div>
      <div class="col-3 form-group"><label>Preparer</label><input class="form-control" name="preparer"></div>
      <div class="col-3 form-group"><label>Prepared Date</label><input type="date" class="form-control" name="prepared_date"></div>
      <div class="col-3 form-group"><label>Reviewer</label><input class="form-control" name="reviewer"></div>
      <div class="col-3 form-group"><label>Reviewed Date</label><input type="date" class="form-control" name="reviewed_date"></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- finding modal -->
  <div class="modal fade" id="finding-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Audit Finding</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="findingform" class="ia-entity-form" data-url="findingaction.php" data-modal="finding-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
      <div class="row"><div class="col-12 form-group"><label>Finding <span class="text-danger">*</span></label><textarea class="form-control" name="finding" rows="2"></textarea></div>
      <div class="col-4 form-group"><label>Rating</label><select class="form-control" name="rating"><?= $ratingOpts ?></select></div>
      <div class="col-4 form-group"><label>Department</label><select class="form-control" name="dept_id"><?= $deptOpts ?></select></div>
      <div class="col-4 form-group"><label>Related Risk</label><select class="form-control" name="risk_id"><?= $riskOpts ?></select></div>
      <div class="col-12 form-group"><label>Root Cause</label><textarea class="form-control" name="root_cause" rows="2"></textarea></div>
      <div class="col-12 form-group"><label>Recommendation</label><textarea class="form-control" name="recommend" rows="2"></textarea></div>
      <div class="col-12 form-group"><label>Management Response</label><textarea class="form-control" name="management_response" rows="2"></textarea></div>
      <div class="col-4 form-group"><label>Responsible Officer</label><input class="form-control" name="responsible_officer"></div>
      <div class="col-4 form-group"><label>Target Date</label><input type="date" class="form-control" name="timeline"></div>
      <div class="col-4 form-group"><label>Status</label><select class="form-control" name="status"><?php foreach (['Draft', 'Open', 'Closed', 'Overdue'] as $s) echo "<option>$s</option>"; ?></select></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- wp checklist modal -->
  <div class="modal fade" id="wpcheck-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Workpaper File Checklist</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="wpcheckform" class="ia-entity-form" data-url="checklistaction.php" data-modal="wpcheck-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>"><input type="hidden" name="checklist_type" value="workpaper_file">
      <div class="form-group"><label>Checklist Item <span class="text-danger">*</span></label><input class="form-control" name="item_description"></div>
      <div class="row"><div class="col-6 form-group"><label>Status</label><select class="form-control" name="status"><?php foreach (['Pending', 'Complete', 'N/A'] as $s) echo "<option>$s</option>"; ?></select></div>
      <div class="col-6 form-group"><label>Remarks</label><input class="form-control" name="remarks"></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- review note modal -->
  <div class="modal fade" id="review-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Review Note</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="reviewform" class="ia-entity-form" data-url="reviewnoteaction.php" data-modal="review-modal"><div class="modal-body"><input type="hidden" name="mode" value="add"><input type="hidden" name="id"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
      <div class="row"><div class="col-4 form-group"><label>WP Ref</label><input class="form-control" name="wp_ref"></div>
      <div class="col-5 form-group"><label>Reviewer <span class="text-danger">*</span></label><input class="form-control" name="reviewer"></div>
      <div class="col-3 form-group"><label>Status</label><select class="form-control" name="status"><option>Open</option><option>Cleared</option></select></div>
      <div class="col-12 form-group"><label>Review Comment <span class="text-danger">*</span></label><textarea class="form-control" name="review_comment" rows="2"></textarea></div>
      <div class="col-12 form-group"><label>Preparer Response</label><textarea class="form-control" name="preparer_response" rows="2"></textarea></div>
      <div class="col-6 form-group"><label>Raised Date</label><input type="date" class="form-control" name="raised_date"></div>
      <div class="col-6 form-group"><label>Cleared Date</label><input type="date" class="form-control" name="cleared_date"></div></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary">Save</button></div></form></div></div></div>

  <!-- document upload modal (multipart) -->
  <div class="modal fade" id="doc-modal" tabindex="-1" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><h5 class="modal-title">Upload Document</h5><button type="button" class="btn btn-danger close" data-bs-dismiss="modal"><i data-feather="x"></i></button></div>
    <form id="docform" enctype="multipart/form-data"><div class="modal-body"><input type="hidden" name="engagement_id" value="<?= (int)$eng['id'] ?>">
      <div class="form-group"><label>Document Type</label><input class="form-control" name="doc_type" placeholder="e.g. Signed Minutes, Evidence"></div>
      <div class="form-group"><label>Description</label><input class="form-control" name="description"></div>
      <div class="form-group"><label>File <span class="text-danger">*</span></label><input type="file" class="form-control" name="file"></div>
    </div><div class="modal-footer"><button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button><button type="submit" class="btn btn-primary docupload-btn">Upload</button></div></form></div></div></div>

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
