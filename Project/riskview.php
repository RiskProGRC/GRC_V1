<?php
include_once './connection/connect.php'; // $con — needed before DOCTYPE for dept dropdown
$depts = mysqli_query($con, "SELECT dept_id, dept_name FROM department ORDER BY dept_name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; ?>
<style>
/* ── Page layout ── */
.rv-header {
    background: #02338d; color: #fff;
    padding: 10px 16px; border-radius: 6px 6px 0 0;
    display: flex; align-items: center; gap: 12px; margin-bottom: 0;
}
.rv-header h4 { margin: 0; font-size: 15px; font-weight: 700; }

/* ── Dept selector card ── */
.rv-select-card {
    background: #fff; border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.09);
    padding: 18px 20px; margin-bottom: 18px;
    display: flex; align-items: center; gap: 16px; flex-wrap: wrap;
}
.rv-select-card label { font-size: 12px; font-weight: 700; color: #555; margin: 0; white-space: nowrap; }
.rv-select-card select { flex: 1; min-width: 220px; max-width: 360px; font-size: 13px; }

/* ── Dept info strip ── */
.rv-info {
    background: #f0f4ff; border: 1px solid #c5d5f0;
    border-radius: 6px; padding: 10px 16px;
    display: none; gap: 24px; flex-wrap: wrap; margin-bottom: 14px;
    align-items: flex-start;
}
.rv-info.visible { display: flex; }
.rv-info-item { display: flex; flex-direction: column; }
.rv-info-item .lbl { font-size: 10px; font-weight: 700; text-transform: uppercase; color: #6a7fa8; }
.rv-info-item .val { font-size: 13px; font-weight: 600; color: #1a2a4a; }

/* ── Tabs ── */
#rv-tabs {
    background: #02338d; border-bottom: 2px solid #012a73;
    padding: 6px 8px 0; gap: 3px; border-radius: 6px 6px 0 0;
    display: flex;
}
#rv-tabs .nav-link {
    display: flex; align-items: center; gap: 6px;
    padding: 10px 14px; margin: 3px 2px 0;
    border-radius: 6px 6px 0 0;
    border: 1px solid rgba(255,255,255,0.12) !important;
    border-bottom: 3px solid transparent !important;
    background: rgba(255,255,255,0.07);
    color: #cde0ff; font-size: 12px; font-weight: 600;
    text-decoration: none;
    transition: background 0.15s, color 0.15s, border-color 0.15s;
}
#rv-tabs .nav-link:hover { background: rgba(255,255,255,0.15); color: #fff; }
#rv-tabs .nav-link.active {
    background: #0554e9 !important; color: #fff !important;
    border-bottom: 3px solid #ffc107 !important;
    font-weight: 700;
}
.rv-count {
    background: rgba(255,255,255,0.18); color: #cde0ff;
    font-size: 10px; font-weight: 700; padding: 1px 7px;
    border-radius: 10px; min-width: 20px; text-align: center;
}
#rv-tabs .nav-link.active .rv-count { background: rgba(255,215,0,0.25); color: #ffd700; }

/* ── Tab content ── */
.rv-tab-content {
    background: #fff; border: 1px solid #d6e0f0;
    border-top: none; border-radius: 0 0 6px 6px;
    padding: 14px 12px; min-height: 280px;
}
.tab-pane { display: none; }
.tab-pane.active { display: block; }

/* ── Table ── */
.table-buss { border-collapse: collapse; width: 100%; }
.table-buss th {
    font-size: 11px; font-weight: 700; color: #fff;
    background: #02338d; padding: 5px 7px;
    white-space: nowrap; text-align: center; vertical-align: middle;
    border: 1px solid rgba(255,255,255,0.25);
}
.table-buss td {
    font-size: 11px; font-weight: 600; color: #1a1a2e;
    padding: 4px 7px; text-align: center; vertical-align: middle;
    border: 1px solid #cdd8ec;
}
.table-buss tbody tr:hover td { background: #eef4ff; }

/* ── Status / priority pills ── */
.pill {
    display: inline-block; padding: 2px 9px; border-radius: 20px;
    font-size: 10px; font-weight: 700; white-space: nowrap;
}
.pill-yes      { background: #d4edda; color: #155724; }
.pill-no       { background: #f8d7da; color: #721c24; }
.pill-ongoing  { background: #fff3cd; color: #856404; }
.pill-overdue  { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
.pill-phi      { background: #1a1a2e; color: #fff; }
.pill-vh       { background: #c0392b; color: #fff; }
.pill-high     { background: #e67e22; color: #fff; }
.pill-med      { background: #f1c40f; color: #333; }
.pill-low      { background: #27ae60; color: #fff; }

/* ── Loading / empty states ── */
.rv-loading {
    text-align: center; padding: 40px 0; color: #6a7fa8;
    font-size: 13px; font-weight: 600;
}
.rv-empty {
    text-align: center; padding: 32px 0; color: #aaa;
    font-size: 12px; font-style: italic;
}
.spinner {
    width: 28px; height: 28px; border: 3px solid #c5d5f0;
    border-top-color: #02338d; border-radius: 50%;
    animation: spin .7s linear infinite; margin: 0 auto 10px;
}
@keyframes spin { to { transform: rotate(360deg); } }

/* ── Prompt ── */
.rv-prompt {
    text-align: center; padding: 60px 0; color: #aab;
    font-size: 13px;
}
.rv-prompt .icon { font-size: 40px; margin-bottom: 10px; }
</style>
<body>
<div id="app">
    <div id="main" class="layout-horizontal">
        <?php include_once '../layout/nav.php'; ?>

        <div class="content-wrapper container">
            <div class="page-heading">
                <center><h4>Risk Tracker</h4></center>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12">

                        <!-- ── Dept selector ── -->
                        <div class="rv-select-card">
                            <label for="rv-dept">Choose Entity</label>
                            <select class="form-select" id="rv-dept">
                                <option value="">-- Select Entity --</option>
                                <?php while ($d = mysqli_fetch_assoc($depts)): ?>
                                <option value="<?= $d['dept_id'] ?>"><?= htmlspecialchars($d['dept_name']) ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <!-- ── Dept info strip (shown after selection) ── -->
                        <div class="rv-info" id="rv-info">
                            <div class="rv-info-item">
                                <span class="lbl">Company</span>
                                <span class="val" id="rv-company">—</span>
                            </div>
                            <div class="rv-info-item">
                                <span class="lbl">Entity</span>
                                <span class="val" id="rv-entity">—</span>
                            </div>
                            <div class="rv-info-item">
                                <span class="lbl">Owner</span>
                                <span class="val" id="rv-owner">—</span>
                            </div>
                            <div class="rv-info-item" style="flex:1">
                                <span class="lbl">Functions</span>
                                <span class="val" id="rv-functions" style="font-weight:500;font-size:12px;white-space:pre-line;">—</span>
                            </div>
                        </div>

                        <!-- ── Tabs (hidden until a dept loads) ── -->
                        <div id="rv-tab-area" style="display:none;">
                            <ul class="nav" id="rv-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#" data-tab="risks">
                                        Risks <span class="rv-count" id="cnt-risks">0</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-tab="ki">
                                        Key Indicators <span class="rv-count" id="cnt-ki">0</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-tab="controls">
                                        Controls <span class="rv-count" id="cnt-controls">0</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-tab="actions">
                                        Actions <span class="rv-count" id="cnt-actions">0</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#" data-tab="recommendations">
                                        Recommendations <span class="rv-count" id="cnt-recommendations">0</span>
                                    </a>
                                </li>
                            </ul>

                            <div class="rv-tab-content">
                                <div class="tab-pane active" id="tab-risks"></div>
                                <div class="tab-pane" id="tab-ki"></div>
                                <div class="tab-pane" id="tab-controls"></div>
                                <div class="tab-pane" id="tab-actions"></div>
                                <div class="tab-pane" id="tab-recommendations"></div>
                            </div>
                        </div>

                        <!-- ── Prompt before any selection ── -->
                        <div class="rv-prompt" id="rv-prompt">
                            <div class="icon">&#128202;</div>
                            Select an entity above to load its risk register
                        </div>

                    </div>
                </section>
            </div>
        </div>

        <?php include_once '../layout/footer.php'; ?>
    </div>
</div>

<script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script>
// ── DataTable instances — tracked so they can be destroyed on re-load ────────
const dtMap = {}; // keyed by table element id; holds the DataTable instance

function resetDT(id) {
    if (dtMap[id]) { try { dtMap[id].destroy(); } catch(e){} delete dtMap[id]; } // destroy old instance before re-rendering
}

function initDT(id) {
    resetDT(id); // always tear down first to avoid duplicate header rows
    const el = document.getElementById(id);
    if (el) dtMap[id] = new simpleDatatables.DataTable(el, { perPage: 10, perPageSelect: [10, 25, 50] }); // null-guard: skip if pane not yet in DOM
}

// ── Text helpers ─────────────────────────────────────────────────────────────
function trunc(s, n) {
    if (!s) return ''; // guard against null/undefined from DB
    return s.length > n ? s.slice(0, n) + '…' : s; // ellipsis truncate for long descriptions
}

function esc(s) {
    if (!s) return ''; // guard against null/undefined
    const d = document.createElement('div'); // textContent escapes <, >, &, " automatically
    d.textContent = s;
    return d.innerHTML; // return the escaped HTML string — prevents XSS in table cells
}

// ── Pill helpers ─────────────────────────────────────────────────────────────
function statusPill(s) {
    const map = { yes:'pill-yes', no:'pill-no', ongoing:'pill-ongoing', overdue:'pill-overdue' }; // all expected status values
    const cls = map[(s||'').toLowerCase()] || 'pill-ongoing'; // default to ongoing if unrecognised value
    return `<span class="pill ${cls}">${esc(s)}</span>`; // esc() prevents XSS in pill text
}

function priorityPill(p) {
    const map = {
        'incredibly high':'pill-phi', 'very high':'pill-vh', // pill-phi = black; pill-vh = dark red
        'high':'pill-high', 'medium':'pill-med', 'low':'pill-low'
    };
    const cls = map[(p||'').toLowerCase()] || ''; // empty string = no pill class; render plain text
    return cls ? `<span class="pill ${cls}">${esc(p)}</span>` : esc(p); // only wrap in span if class found
}

// ── Table builders ───────────────────────────────────────────────────────────
function buildRisks(rows) {
    if (!rows.length) return '<div class="rv-empty">No risks recorded for this entity</div>'; // empty state
    const thead = `<tr>
        <th>Ref</th><th>Risk Description</th><th>Cause</th>
        <th>Nominee</th><th>Reviewer</th><th>Review Date</th><th>Category</th>
    </tr>`;
    const tbody = rows.map(r => `<tr>
        <td>RSK${String(r.risk_id).padStart(3,'0')}</td>
        <td style="max-width:220px;white-space:normal;text-align:left">${esc(trunc(r.risk_name,60))}</td>
        <td style="max-width:220px;white-space:normal;text-align:left">${esc(trunc(r.cause,60))}</td>
        <td>${esc(r.nominee)}</td>
        <td>${esc(r.reviewer_name)}</td> <!-- reviewer_name = CONCAT(fname,' ',sname) from users JOIN -->
        <td>${esc(r.rdate)}</td>
        <td>${esc(r.category)}</td> <!-- category = riskcat.name via JOIN -->
    </tr>`).join('');
    return `<div class="table-responsive"><table class="table-buss" id="dt-risks"><thead>${thead}</thead><tbody>${tbody}</tbody></table></div>`; // table-responsive wrapper allows horizontal scroll on small screens
}

function buildKI(rows) {
    if (!rows.length) return '<div class="rv-empty">No key indicators recorded for this entity</div>'; // empty state
    const thead = `<tr>
        <th>Risk Ref</th><th>Risk</th><th>KI Ref</th><th>Key Indicator</th><th>Owner</th>
    </tr>`;
    const tbody = rows.map(r => `<tr>
        <td>RSK${String(r.risk_id).padStart(3,'0')}</td> <!-- risk ref padded to 3 digits -->
        <td style="max-width:200px;white-space:normal;text-align:left">${esc(trunc(r.risk_name,55))}</td>
        <td>KI${String(r.id).padStart(3,'0')}</td>
        <td style="max-width:220px;white-space:normal;text-align:left">${esc(trunc(r.ki,60))}</td>
        <td>${esc(r.owner_name)}</td> <!-- owner_name = CONCAT(fname,' ',sname) from users JOIN -->
    </tr>`).join('');
    return `<div class="table-responsive"><table class="table-buss" id="dt-ki"><thead>${thead}</thead><tbody>${tbody}</tbody></table></div>`;
}

function buildControls(rows) {
    if (!rows.length) return '<div class="rv-empty">No controls recorded for this entity</div>'; // empty state
    const thead = `<tr>
        <th>Risk Ref</th><th>Risk</th><th>Control Ref</th><th>Control</th>
        <th>Process</th><th>Strength</th><th>Type</th><th>Reviewer</th>
    </tr>`;
    const tbody = rows.map(r => `<tr>
        <td>RSK${String(r.risk_id).padStart(3,'0')}</td>
        <td style="max-width:180px;white-space:normal;text-align:left">${esc(trunc(r.risk_name,50))}</td>
        <td>CTL${String(r.control_id).padStart(3,'0')}</td>
        <td style="max-width:200px;white-space:normal;text-align:left">${esc(trunc(r.controls,55))}</td> <!-- column is 'controls' (plural) — verified via DESCRIBE -->
        <td>${esc(r.process_name)}</td>
        <td>${esc(r.cs_name)}</td> <!-- cs_name = control_strength.cs_name -->
        <td>${esc(r.ct_name)}</td> <!-- ct_name = control_type.ct_name -->
        <td>${esc(r.reviewer_name)}</td>
    </tr>`).join('');
    return `<div class="table-responsive"><table class="table-buss" id="dt-controls"><thead>${thead}</thead><tbody>${tbody}</tbody></table></div>`;
}

function buildActions(rows) {
    if (!rows.length) return '<div class="rv-empty">No actions recorded for this entity</div>'; // empty state
    const thead = `<tr>
        <th>Risk Ref</th><th>Risk</th><th>Action Ref</th><th>Action</th>
        <th>Process</th><th>Priority</th><th>Status</th><th>Timeline</th>
    </tr>`;
    const tbody = rows.map(r => `<tr>
        <td>RSK${String(r.risk_id).padStart(3,'0')}</td>
        <td style="max-width:180px;white-space:normal;text-align:left">${esc(trunc(r.risk_name,50))}</td>
        <td>ACT${String(r.id).padStart(3,'0')}</td>
        <td style="max-width:200px;white-space:normal;text-align:left">${esc(trunc(r.action,55))}</td>
        <td>${esc(r.process_name)}</td>
        <td>${priorityPill(r.priority)}</td> <!-- color pill: incredibly high→black, very high→red, high→orange, medium→yellow, low→green -->
        <td>${statusPill(r.status)}</td>     <!-- color pill: yes→green, no→red, ongoing→yellow, overdue→red-border -->
        <td>${esc(r.timeline)}</td>
    </tr>`).join('');
    return `<div class="table-responsive"><table class="table-buss" id="dt-actions"><thead>${thead}</thead><tbody>${tbody}</tbody></table></div>`;
}

function buildRecommendations(rows) {
    if (!rows.length) return '<div class="rv-empty">No recommendations recorded for this entity</div>'; // empty state
    const thead = `<tr>
        <th>Risk Ref</th><th>Risk</th><th>Ref</th><th>MRC</th>
        <th>ARMC</th><th>Action</th><th>Status</th><th>Timeline</th>
    </tr>`;
    const tbody = rows.map(r => `<tr>
        <td>RSK${String(r.risk_id).padStart(3,'0')}</td>
        <td style="max-width:160px;white-space:normal;text-align:left">${esc(trunc(r.risk_name,45))}</td>
        <td>RMD${String(r.id).padStart(3,'0')}</td>
        <td style="max-width:160px;white-space:normal;text-align:left">${esc(trunc(r.mrc,45))}</td>
        <td style="max-width:160px;white-space:normal;text-align:left">${esc(trunc(r.armc,45))}</td>
        <td style="max-width:150px;white-space:normal;text-align:left">${esc(trunc(r.action_name,40))}</td> <!-- action_name = action.action via LEFT JOIN; null if unlinked -->
        <td>${statusPill(r.status)}</td>
        <td>${esc(r.timeline)}</td>
    </tr>`).join('');
    return `<div class="table-responsive"><table class="table-buss" id="dt-recommendations"><thead>${thead}</thead><tbody>${tbody}</tbody></table></div>`;
}

// ── Tab switching ─────────────────────────────────────────────────────────────
document.getElementById('rv-tabs').addEventListener('click', function(e) {
    e.preventDefault(); // stop anchor from scrolling to top
    const link = e.target.closest('[data-tab]'); // works even if click lands on the count badge span
    if (!link) return; // clicked in the nav bar but not on a tab link
    const tab = link.dataset.tab; // e.g. 'risks', 'ki', 'controls'

    document.querySelectorAll('#rv-tabs .nav-link').forEach(l => l.classList.remove('active')); // deactivate all tabs
    link.classList.add('active'); // activate clicked tab

    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active')); // hide all panes
    document.getElementById('tab-' + tab).classList.add('active'); // show matching pane
});

// ── Main fetch on dropdown change ────────────────────────────────────────────
document.getElementById('rv-dept').addEventListener('change', function() {
    const deptId  = this.value; // empty string when user selects the placeholder option
    const tabArea = document.getElementById('rv-tab-area');
    const prompt  = document.getElementById('rv-prompt'); // "select an entity" message
    const infoBar = document.getElementById('rv-info');   // dept info strip above tabs

    if (!deptId) { // user cleared the selection — reset to initial state
        tabArea.style.display  = 'none';
        prompt.style.display   = 'block';
        infoBar.classList.remove('visible'); // hide info strip
        return;
    }

    // Show loading state in all panes while fetch is in flight
    tabArea.style.display = 'block'; // reveal tab area
    prompt.style.display  = 'none';  // hide "select entity" prompt
    ['risks','ki','controls','actions','recommendations'].forEach(t => {
        document.getElementById('tab-' + t).innerHTML =
            '<div class="rv-loading"><div class="spinner"></div>Loading…</div>'; // animated spinner
        document.getElementById('cnt-' + t).textContent = '…'; // indeterminate badge
    });

    fetch('riskview_fetch.php', {
        method:  'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, // required for $_POST to be populated in PHP
        body:    'deptid=' + encodeURIComponent(deptId) // encodeURIComponent handles edge-case dept IDs
    })
    .then(r => {
        if (!r.ok) throw new Error('Server error ' + r.status); // HTTP-level failure (500, 404, etc.)
        return r.json(); // parse; will throw if PHP returned HTML instead of JSON
    })
    .then(data => {
        if (data.error) throw new Error(data.error); // PHP-level error passed through JSON

        // ── Populate info strip ──
        const d = data.dept || {}; // dept may be empty if dept_id not found
        document.getElementById('rv-company').textContent   = d.company_name || '—'; // fallback dash if field is null
        document.getElementById('rv-entity').textContent    = d.dept_name    || '—';
        document.getElementById('rv-owner').textContent     = d.owner_name   || '—';
        document.getElementById('rv-functions').textContent = d.functions    || '—';
        infoBar.classList.add('visible'); // make the info strip visible (CSS: display:flex)

        // ── Render all 5 tables ──
        const sections = {
            risks:           { build: buildRisks,           dtId: 'dt-risks' },           // maps JSON key → builder fn + DataTable element id
            ki:              { build: buildKI,              dtId: 'dt-ki' },
            controls:        { build: buildControls,        dtId: 'dt-controls' },
            actions:         { build: buildActions,         dtId: 'dt-actions' },
            recommendations: { build: buildRecommendations, dtId: 'dt-recommendations' }
        };

        Object.entries(sections).forEach(([key, cfg]) => {
            const rows = data[key] || []; // fallback to empty array if key missing from response
            document.getElementById('cnt-' + key).textContent = rows.length; // update badge count
            const pane = document.getElementById('tab-' + key);
            pane.innerHTML = cfg.build(rows); // inject rendered table HTML into tab pane
            if (rows.length) initDT(cfg.dtId); // only init DataTable when there are rows; empty state uses div
        });
    })
    .catch(err => { // covers network errors, JSON parse failures, and PHP errors
        ['risks','ki','controls','actions','recommendations'].forEach(t => {
            document.getElementById('tab-' + t).innerHTML =
                `<div class="rv-empty" style="color:#c0392b">&#9888; ${err.message}</div>`; // show error in every pane
            document.getElementById('cnt-' + t).textContent = '!'; // exclamation badge signals error
        });
    });
});
</script>
</body>
</html>
