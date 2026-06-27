<?php
require_once __DIR__ . '/core/AuthGuard.php'; // session check — sets $uid, $sdid
include_once './connection/connect.php';       // $con

$deptid = (int)($_POST['deptid'] ?? 0); // cast to int, safe even without prepared stmt
if (!$deptid) exit;                     // nothing to show if no dept sent

// ── 6 queries — all column names verified against live DB ────────────────────

// Dept info (single row)
$dept_q = mysqli_query($con,
    "SELECT d.dept_name, d.functions, c.company_name,
            CONCAT(u.fname,' ',u.sname) AS owner_name
     FROM department d
     INNER JOIN company c ON d.company = c.id   -- FK column is 'company' not 'company_id'
     INNER JOIN users   u ON d.owners  = u.id   -- FK column is 'owners' (plural)
     WHERE d.dept_id = $deptid"
);

// Risks — dept FK on risk table is 'dept' not 'dept_id'
$risk_q = mysqli_query($con,
    "SELECT r.risk_id, r.risk_name, r.cause, r.nominee, r.rdate,
            rc.name AS category,
            CONCAT(u.fname,' ',u.sname) AS reviewer_name
     FROM risk r
     INNER JOIN riskcat rc ON r.rcat     = rc.riskcat_id
     INNER JOIN users   u  ON r.reviewer = u.id
     WHERE r.dept = $deptid"
);

// Key Indicators
$ki_q = mysqli_query($con,
    "SELECT ki.id, ki.ki, r.risk_id, r.risk_name,
            CONCAT(u.fname,' ',u.sname) AS owner_name
     FROM ki
     INNER JOIN risk  r ON ki.risk_id = r.risk_id
     INNER JOIN users u ON ki.owner   = u.id
     WHERE ki.dept_id = $deptid
     ORDER BY ki.risk_id ASC"
);

// Controls — 'control' is a reserved word so backticks are required
//           control table has NO direct risk FK; link is via risk_control junction table
//           text column is 'controls' (plural) — verified via DESCRIBE
$ctrl_q = mysqli_query($con,
    "SELECT `control`.control_id, `control`.controls, r.risk_id, r.risk_name,
            p.process_name, cs.cs_name, ct.ct_name,
            CONCAT(u.fname,' ',u.sname) AS reviewer_name
     FROM `control`
     INNER JOIN risk_control     rcl ON `control`.control_id = rcl.control_id -- junction table
     INNER JOIN risk             r   ON rcl.risk_id          = r.risk_id
     INNER JOIN control_strength cs  ON `control`.cstrength  = cs.strength_id
     INNER JOIN control_type     ct  ON `control`.ctype      = ct.ctype_id
     INNER JOIN process          p   ON `control`.process_id = p.process_id
     INNER JOIN users            u   ON `control`.reviewer   = u.id
     WHERE `control`.dept_id = $deptid -- qualify table; process also has dept_id
     ORDER BY r.risk_id ASC"
);

// Actions
$act_q = mysqli_query($con,
    "SELECT a.id, a.action, a.priority, a.status, a.timeline,
            r.risk_id, r.risk_name, p.process_name
     FROM action a
     INNER JOIN risk    r ON a.risk_id    = r.risk_id
     INNER JOIN process p ON a.process_id = p.process_id
     WHERE a.dept_id = $deptid -- qualify table; process also has dept_id
     ORDER BY a.risk_id ASC"
);

// Recommendations — 'action' column in recommend is an INT FK to action.id
$rmd_q = mysqli_query($con,
    "SELECT rec.id, rec.mrc, rec.armc, rec.status, rec.timeline,
            r.risk_id, r.risk_name, a.action AS action_name
     FROM recommend rec
     INNER JOIN risk r   ON rec.risk_id = r.risk_id
     LEFT  JOIN action a ON rec.action  = a.id -- LEFT JOIN: some recs may have no linked action
     WHERE rec.dept_id = $deptid
     ORDER BY rec.risk_id ASC"
);

$dept = mysqli_fetch_assoc($dept_q); // single row for dept info strip
if (!$dept) { echo '<p class="text-muted text-center p-4">Entity not found.</p>'; exit; }

?>

<!-- ── Dept info strip ──────────────────────────────────────────────────── -->
<div class="row mb-2">
    <div class="col-md-3 form-group">
        <label>Company:</label>
        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($dept['company_name']) ?>" disabled>
    </div>
    <div class="col-md-3 form-group">
        <label>Entity:</label>
        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($dept['dept_name']) ?>" disabled>
    </div>
    <div class="col-md-3 form-group">
        <label>Owner:</label>
        <input type="text" class="form-control form-control-sm" value="<?= htmlspecialchars($dept['owner_name']) ?>" disabled>
    </div>
    <div class="col-md-3 form-group">
        <label>Functions:</label>
        <textarea class="form-control form-control-sm" rows="2" disabled><?= htmlspecialchars($dept['functions']) ?></textarea>
    </div>
</div>
<hr>

<!-- ── Tabs ─────────────────────────────────────────────────────────────── -->
<ul class="nav nav-tabs" id="rvTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" data-bs-toggle="tab" href="#rv-risks" role="tab">
            Risks <span class="badge bg-primary"><?= mysqli_num_rows($risk_q) ?></span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#rv-ki" role="tab">
            Key Indicators <span class="badge bg-primary"><?= mysqli_num_rows($ki_q) ?></span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#rv-controls" role="tab">
            Controls <span class="badge bg-primary"><?= mysqli_num_rows($ctrl_q) ?></span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#rv-actions" role="tab">
            Actions <span class="badge bg-primary"><?= mysqli_num_rows($act_q) ?></span>
        </a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" data-bs-toggle="tab" href="#rv-recommend" role="tab">
            Recommendations <span class="badge bg-primary"><?= mysqli_num_rows($rmd_q) ?></span>
        </a>
    </li>
</ul>

<div class="tab-content mt-2" id="rvTabContent">

    <!-- ── Risks ── -->
    <div class="tab-pane fade show active" id="rv-risks" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-striped table-buss" id="rv-tab1">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Risk Description</th>
                        <th>Cause</th>
                        <th>Nominee</th>
                        <th>Reviewer</th>
                        <th>Review Date</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($r = mysqli_fetch_assoc($risk_q)): ?>
                    <tr>
                        <td>RSK<?= str_pad($r['risk_id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td style="max-width:200px;white-space:normal"><?= htmlspecialchars(substr($r['risk_name'], 0, 60)) ?></td>
                        <td style="max-width:200px;white-space:normal"><?= htmlspecialchars(substr($r['cause'], 0, 60)) ?></td>
                        <td><?= htmlspecialchars($r['nominee']) ?></td>
                        <td><?= htmlspecialchars($r['reviewer_name']) ?></td>
                        <td><?= htmlspecialchars($r['rdate']) ?></td>
                        <td><?= htmlspecialchars($r['category']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── Key Indicators ── -->
    <div class="tab-pane fade" id="rv-ki" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-striped table-buss" id="rv-tab2">
                <thead>
                    <tr>
                        <th>Risk Ref</th>
                        <th>Risk</th>
                        <th>KI Ref</th>
                        <th>Key Indicator</th>
                        <th>Owner</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($ki = mysqli_fetch_assoc($ki_q)): ?>
                    <tr>
                        <td>RSK<?= str_pad($ki['risk_id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td style="max-width:200px;white-space:normal"><?= htmlspecialchars(substr($ki['risk_name'], 0, 55)) ?></td>
                        <td>KI<?= str_pad($ki['id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td style="max-width:220px;white-space:normal"><?= htmlspecialchars(substr($ki['ki'], 0, 60)) ?></td>
                        <td><?= htmlspecialchars($ki['owner_name']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── Controls ── -->
    <div class="tab-pane fade" id="rv-controls" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-striped table-buss" id="rv-tab3">
                <thead>
                    <tr>
                        <th>Risk Ref</th>
                        <th>Risk</th>
                        <th>Control Ref</th>
                        <th>Control</th>
                        <th>Process</th>
                        <th>Strength</th>
                        <th>Type</th>
                        <th>Reviewer</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($c = mysqli_fetch_assoc($ctrl_q)): ?>
                    <tr>
                        <td>RSK<?= str_pad($c['risk_id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td style="max-width:180px;white-space:normal"><?= htmlspecialchars(substr($c['risk_name'], 0, 50)) ?></td>
                        <td>CTL<?= str_pad($c['control_id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td style="max-width:200px;white-space:normal"><?= htmlspecialchars(substr($c['controls'], 0, 55)) ?></td>
                        <td><?= htmlspecialchars($c['process_name']) ?></td>
                        <td><?= htmlspecialchars($c['cs_name']) ?></td>
                        <td><?= htmlspecialchars($c['ct_name']) ?></td>
                        <td><?= htmlspecialchars($c['reviewer_name']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── Actions ── -->
    <div class="tab-pane fade" id="rv-actions" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-striped table-buss" id="rv-tab4">
                <thead>
                    <tr>
                        <th>Risk Ref</th>
                        <th>Risk</th>
                        <th>Action Ref</th>
                        <th>Action</th>
                        <th>Process</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Timeline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($a = mysqli_fetch_assoc($act_q)): ?>
                    <tr>
                        <td>RSK<?= str_pad($a['risk_id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td style="max-width:180px;white-space:normal"><?= htmlspecialchars(substr($a['risk_name'], 0, 50)) ?></td>
                        <td>ACT<?= str_pad($a['id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td style="max-width:200px;white-space:normal"><?= htmlspecialchars(substr($a['action'], 0, 55)) ?></td>
                        <td><?= htmlspecialchars($a['process_name']) ?></td>
                        <td><?= htmlspecialchars($a['priority']) ?></td>
                        <td><?= htmlspecialchars($a['status']) ?></td>
                        <td><?= htmlspecialchars($a['timeline']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── Recommendations ── -->
    <div class="tab-pane fade" id="rv-recommend" role="tabpanel">
        <div class="table-responsive">
            <table class="table table-striped table-buss" id="rv-tab5">
                <thead>
                    <tr>
                        <th>Risk Ref</th>
                        <th>Risk</th>
                        <th>Ref</th>
                        <th>MRC</th>
                        <th>ARMC</th>
                        <th>Action</th>
                        <th>Status</th>
                        <th>Timeline</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($rec = mysqli_fetch_assoc($rmd_q)): ?>
                    <tr>
                        <td>RSK<?= str_pad($rec['risk_id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td style="max-width:160px;white-space:normal"><?= htmlspecialchars(substr($rec['risk_name'], 0, 45)) ?></td>
                        <td>RMD<?= str_pad($rec['id'], 3, '0', STR_PAD_LEFT) ?></td>
                        <td style="max-width:160px;white-space:normal"><?= htmlspecialchars(substr($rec['mrc'], 0, 45)) ?></td>
                        <td style="max-width:160px;white-space:normal"><?= htmlspecialchars(substr($rec['armc'], 0, 45)) ?></td>
                        <td style="max-width:150px;white-space:normal"><?= htmlspecialchars(substr($rec['action_name'] ?? '', 0, 40)) ?></td>
                        <td><?= htmlspecialchars($rec['status']) ?></td>
                        <td><?= htmlspecialchars($rec['timeline']) ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

</div><!-- tab-content -->
