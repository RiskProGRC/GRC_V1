<?php
/* notifications.php — Notification centre for Risks, Controls, KPIs, Actions, Processes */
require_once __DIR__ . '/core/AuthGuard.php';    /* sets $uid, $sdid */
include_once './connection/connect.php';           /* $con */
include_once './department/departmentClass.php';

$today = date('Y-m-d');

/* ── 1. Risks pending or needing amendment ── */
$risk_q = mysqli_query($con,
    "SELECT r.risk_id, r.risk_name, r.rdate, r.approval,
            d.dept_name, rc.name AS category,
            CONCAT(u.fname,' ',u.sname) AS reviewer
     FROM risk r
     INNER JOIN department d  ON r.dept     = d.dept_id
     INNER JOIN riskcat    rc ON r.rcat     = rc.riskcat_id
     INNER JOIN users      u  ON r.reviewer = u.id
     WHERE r.approval IN (1,3)
     ORDER BY r.risk_id DESC
     LIMIT 50"
);

/* ── 2. Controls pending or needing amendment ── */
$ctrl_q = mysqli_query($con,
    "SELECT c.control_id, c.controls, c.rdate, c.approval,
            d.dept_name, p.process_name,
            CONCAT(u.fname,' ',u.sname) AS reviewer
     FROM `control` c
     INNER JOIN department d   ON c.dept_id    = d.dept_id
     INNER JOIN process    p   ON c.process_id = p.process_id
     INNER JOIN users      u   ON c.reviewer   = u.id
     WHERE c.approval IN (1,3)
     ORDER BY c.control_id DESC
     LIMIT 50"
);

/* ── 3. KPIs pending or needing amendment ── */
$ki_q = mysqli_query($con,
    "SELECT ki.id, ki.ki, ki.approval,
            r.risk_name, d.dept_name,
            CONCAT(u.fname,' ',u.sname) AS owner_name
     FROM ki
     INNER JOIN risk       r ON ki.risk_id = r.risk_id
     INNER JOIN department d ON ki.dept_id = d.dept_id
     INNER JOIN users      u ON ki.owner   = u.id
     WHERE ki.approval IN (1,3)
     ORDER BY ki.id DESC
     LIMIT 50"
);

/* ── 4. Actions overdue OR pending approval ── */
$act_q = mysqli_query($con,
    "SELECT a.id, a.action, a.timeline, a.priority, a.status, a.approval,
            r.risk_name, d.dept_name, p.process_name
     FROM action a
     INNER JOIN risk       r ON a.risk_id    = r.risk_id
     INNER JOIN department d ON a.dept_id    = d.dept_id
     INNER JOIN process    p ON a.process_id = p.process_id
     WHERE a.approval IN (1,3)
        OR (a.timeline < '$today' AND a.status != 'Closed')
     ORDER BY a.timeline ASC
     LIMIT 50"
);

/* ── 5. Processes — recently added (last 60 days) ── */
$proc_q = mysqli_query($con,
    "SELECT p.process_id, p.process_name, p.details,
            d.dept_name
     FROM process p
     INNER JOIN department d ON p.dept_id = d.dept_id
     ORDER BY p.process_id DESC
     LIMIT 30"
);

/* ── Collect counts for summary badges ── */
$c_risk  = $risk_q  ? mysqli_num_rows($risk_q)  : 0;
$c_ctrl  = $ctrl_q  ? mysqli_num_rows($ctrl_q)  : 0;
$c_ki    = $ki_q    ? mysqli_num_rows($ki_q)    : 0;
$c_act   = $act_q   ? mysqli_num_rows($act_q)   : 0;
$c_proc  = $proc_q  ? mysqli_num_rows($proc_q)  : 0;
$c_total = $c_risk + $c_ctrl + $c_ki + $c_act + $c_proc;

/* ── Read all rows into arrays so we can iterate multiple times ── */
$risks   = $risk_q  ? mysqli_fetch_all($risk_q,  MYSQLI_ASSOC) : [];
$ctrls   = $ctrl_q  ? mysqli_fetch_all($ctrl_q,  MYSQLI_ASSOC) : [];
$kis     = $ki_q    ? mysqli_fetch_all($ki_q,    MYSQLI_ASSOC) : [];
$actions = $act_q   ? mysqli_fetch_all($act_q,   MYSQLI_ASSOC) : [];
$procs   = $proc_q  ? mysqli_fetch_all($proc_q,  MYSQLI_ASSOC) : [];

/* ── Helper: status badge HTML ── */
function apprBadge(string $v, string $timeline = ''): string {
    $today = date('Y-m-d');
    if ($v === '1') return '<span class="nbadge nb-pending">Pending Approval</span>';
    if ($v === '3') return '<span class="nbadge nb-amend">Amendment Needed</span>';
    if ($timeline && $timeline < $today) return '<span class="nbadge nb-overdue">Overdue</span>';
    return '<span class="nbadge nb-ok">Active</span>';
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include_once '../layout/header.php'; ?>
<style>
/* ── Notification-centre styles ── */
:root{
    --risk-clr:#dc3545; --ctrl-clr:#0d6efd; --ki-clr:#198754;
    --act-clr:#fd7e14;  --proc-clr:#6f42c1;
}

/* summary stat cards */
.nc-stat{
    border-radius:10px; padding:14px 18px; color:#fff;
    display:flex; align-items:center; gap:12px; cursor:pointer;
    transition:transform .15s, box-shadow .15s;
    border:none; width:100%;
}
.nc-stat:hover{ transform:translateY(-2px); box-shadow:0 6px 20px rgba(0,0,0,.25); }
.nc-stat .nc-icon{ font-size:26px; opacity:.85; }
.nc-stat .nc-num{ font-size:26px; font-weight:800; line-height:1; }
.nc-stat .nc-lbl{ font-size:11px; font-weight:600; opacity:.9; }

.nc-risk { background:linear-gradient(135deg,#dc3545,#a71d2a); }
.nc-ctrl { background:linear-gradient(135deg,#0d6efd,#084298); }
.nc-ki   { background:linear-gradient(135deg,#198754,#0d5133); }
.nc-act  { background:linear-gradient(135deg,#fd7e14,#c25a00); }
.nc-proc { background:linear-gradient(135deg,#6f42c1,#4a2980); }
.nc-all  { background:linear-gradient(135deg,#02338d,#012063); }

/* filter tab strip */
.nc-filter{
    display:flex; gap:6px; flex-wrap:wrap; margin:16px 0 10px;
}
.nc-filter button{
    border:none; border-radius:20px; padding:4px 14px;
    font-size:12px; font-weight:600; cursor:pointer;
    background:#e9ecef; color:#444;
    transition:background .15s, color .15s;
}
.nc-filter button.active,
.nc-filter button:hover{ color:#fff; }
.nc-filter .f-all.active,  .nc-filter .f-all:hover  { background:#02338d; }
.nc-filter .f-risk.active, .nc-filter .f-risk:hover { background:var(--risk-clr); }
.nc-filter .f-ctrl.active, .nc-filter .f-ctrl:hover { background:var(--ctrl-clr); }
.nc-filter .f-ki.active,   .nc-filter .f-ki:hover   { background:var(--ki-clr);   }
.nc-filter .f-act.active,  .nc-filter .f-act:hover  { background:var(--act-clr);  }
.nc-filter .f-proc.active, .nc-filter .f-proc:hover { background:var(--proc-clr); }

/* notification card */
.nc-card{
    border-radius:8px; border:1px solid #dee2e6;
    padding:10px 14px; margin-bottom:8px;
    display:flex; align-items:flex-start; gap:12px;
    background:#fff; transition:box-shadow .15s;
}
.nc-card:hover{ box-shadow:0 4px 14px rgba(0,0,0,.1); }
.nc-card .nc-dot{
    width:10px; height:10px; border-radius:50%; margin-top:5px; flex-shrink:0;
}
.nc-card .nc-body{ flex:1; min-width:0; }
.nc-card .nc-ref{ font-size:10px; font-weight:700; color:#666; }
.nc-card .nc-title{
    font-size:12px; font-weight:700; color:#111;
    white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:95%;
}
.nc-card .nc-meta{
    font-size:11px; color:#666; margin-top:2px;
}
.nc-card .nc-foot{
    display:flex; align-items:center; gap:6px; margin-top:4px; flex-wrap:wrap;
}

/* status mini-badges */
.nbadge{
    border-radius:10px; padding:2px 8px; font-size:10px; font-weight:700;
    white-space:nowrap;
}
.nb-pending { background:#fff3cd; color:#7a5700; }
.nb-amend   { background:#f8d7da; color:#842029; }
.nb-overdue { background:#dc3545; color:#fff;    }
.nb-ok      { background:#d1e7dd; color:#0a3622; }

/* section header */
.nc-section-hdr{
    font-size:12px; font-weight:800; color:#fff;
    padding:5px 12px; border-radius:6px; margin:14px 0 6px;
    display:flex; align-items:center; gap:8px;
}
.s-risk { background:var(--risk-clr); }
.s-ctrl { background:var(--ctrl-clr); }
.s-ki   { background:var(--ki-clr);   }
.s-act  { background:var(--act-clr);  }
.s-proc { background:var(--proc-clr); }

.nc-empty{
    text-align:center; font-size:12px; color:#aaa;
    padding:10px; border:1px dashed #dee2e6;
    border-radius:8px; margin-bottom:8px;
}

/* scrollable list */
.nc-list{ max-height:640px; overflow-y:auto; padding-right:4px; }
.nc-list::-webkit-scrollbar{ width:5px; }
.nc-list::-webkit-scrollbar-thumb{ background:#c8d8f0; border-radius:4px; }

/* toast area */
.toast-area{
    position:fixed; top:70px; right:16px; z-index:9999;
    display:flex; flex-direction:column; gap:8px;
}
.nc-toast{
    border-radius:10px; box-shadow:0 4px 18px rgba(0,0,0,.22);
    padding:12px 16px; color:#fff; min-width:240px; max-width:300px;
    display:flex; align-items:flex-start; gap:10px;
    animation:slideIn .3s ease;
}
@keyframes slideIn{
    from{ transform:translateX(320px); opacity:0; }
    to  { transform:translateX(0);     opacity:1; }
}
.nc-toast .t-icon{ font-size:20px; flex-shrink:0; padding-top:1px; }
.nc-toast .t-body .t-title{ font-size:13px; font-weight:700; }
.nc-toast .t-body .t-msg  { font-size:11px; opacity:.9; }
.nc-toast .t-close{
    margin-left:auto; background:none; border:none;
    color:#fff; font-size:16px; cursor:pointer; opacity:.8; flex-shrink:0;
}
.nc-toast .t-close:hover{ opacity:1; }
</style>
<body>
<div id="app">
    <div id="main" class="layout-horizontal">
        <?php include_once '../layout/nav.php'; ?>

        <div class="content-wrapper container">
            <div class="page-heading">
                <h4><i class="bi bi-bell-fill me-2"></i>Notification Centre
                    <span class="badge bg-danger ms-2"><?= $c_total ?></span>
                </h4>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">

                        <!-- ── Summary Stat Cards ── -->
                        <div class="row g-2 mb-2">
                            <div class="col-6 col-md-2">
                                <button class="nc-stat nc-all w-100" onclick="filterCards('all')">
                                    <i class="bi bi-bell-fill nc-icon"></i>
                                    <div>
                                        <div class="nc-num"><?= $c_total ?></div>
                                        <div class="nc-lbl">All Alerts</div>
                                    </div>
                                </button>
                            </div>
                            <div class="col-6 col-md-2">
                                <button class="nc-stat nc-risk w-100" onclick="filterCards('risk')">
                                    <i class="bi bi-exclamation-triangle-fill nc-icon"></i>
                                    <div>
                                        <div class="nc-num"><?= $c_risk ?></div>
                                        <div class="nc-lbl">Risks</div>
                                    </div>
                                </button>
                            </div>
                            <div class="col-6 col-md-2">
                                <button class="nc-stat nc-ctrl w-100" onclick="filterCards('ctrl')">
                                    <i class="bi bi-shield-fill nc-icon"></i>
                                    <div>
                                        <div class="nc-num"><?= $c_ctrl ?></div>
                                        <div class="nc-lbl">Controls</div>
                                    </div>
                                </button>
                            </div>
                            <div class="col-6 col-md-2">
                                <button class="nc-stat nc-ki w-100" onclick="filterCards('ki')">
                                    <i class="bi bi-graph-up-arrow nc-icon"></i>
                                    <div>
                                        <div class="nc-num"><?= $c_ki ?></div>
                                        <div class="nc-lbl">KPIs</div>
                                    </div>
                                </button>
                            </div>
                            <div class="col-6 col-md-2">
                                <button class="nc-stat nc-act w-100" onclick="filterCards('act')">
                                    <i class="bi bi-lightning-fill nc-icon"></i>
                                    <div>
                                        <div class="nc-num"><?= $c_act ?></div>
                                        <div class="nc-lbl">Actions</div>
                                    </div>
                                </button>
                            </div>
                            <div class="col-6 col-md-2">
                                <button class="nc-stat nc-proc w-100" onclick="filterCards('proc')">
                                    <i class="bi bi-diagram-3-fill nc-icon"></i>
                                    <div>
                                        <div class="nc-num"><?= $c_proc ?></div>
                                        <div class="nc-lbl">Processes</div>
                                    </div>
                                </button>
                            </div>
                        </div>

                        <!-- ── Filter Pill Buttons ── -->
                        <div class="nc-filter">
                            <button class="f-all active"  onclick="filterCards('all')">All (<?= $c_total ?>)</button>
                            <button class="f-risk"        onclick="filterCards('risk')"><i class="bi bi-exclamation-triangle-fill"></i> Risks (<?= $c_risk ?>)</button>
                            <button class="f-ctrl"        onclick="filterCards('ctrl')"><i class="bi bi-shield-fill"></i> Controls (<?= $c_ctrl ?>)</button>
                            <button class="f-ki"          onclick="filterCards('ki')"><i class="bi bi-graph-up-arrow"></i> KPIs (<?= $c_ki ?>)</button>
                            <button class="f-act"         onclick="filterCards('act')"><i class="bi bi-lightning-fill"></i> Actions (<?= $c_act ?>)</button>
                            <button class="f-proc"        onclick="filterCards('proc')"><i class="bi bi-diagram-3-fill"></i> Processes (<?= $c_proc ?>)</button>
                        </div>

                        <!-- ── Notification List ── -->
                        <div class="nc-list" id="ncList">

                            <!-- ══ RISKS ══ -->
                            <div class="nc-section nc-section-risk" data-section="risk">
                                <div class="nc-section-hdr s-risk">
                                    <i class="bi bi-exclamation-triangle-fill"></i>
                                    Risks &nbsp;<span class="badge bg-light text-dark"><?= $c_risk ?></span>
                                </div>
                                <?php if (empty($risks)): ?>
                                    <div class="nc-empty"><i class="bi bi-check-circle text-success"></i> No pending risk notifications</div>
                                <?php else: foreach ($risks as $r):
                                    $isAmend = ($r['approval'] == '3');
                                    $status  = $isAmend ? 'Amendment Needed' : 'Pending Approval';
                                    $dot     = $isAmend ? '#dc3545' : '#fd7e14';
                                ?>
                                <div class="nc-card" data-type="risk">
                                    <div class="nc-dot" style="background:<?= $dot ?>"></div>
                                    <div class="nc-body">
                                        <div class="nc-ref">RSK<?= str_pad($r['risk_id'],3,'0',STR_PAD_LEFT) ?> &bull; <?= htmlspecialchars($r['category']) ?></div>
                                        <div class="nc-title" title="<?= htmlspecialchars($r['risk_name']) ?>"><?= htmlspecialchars(substr($r['risk_name'],0,80)) ?></div>
                                        <div class="nc-meta"><i class="bi bi-building"></i> <?= htmlspecialchars($r['dept_name']) ?> &nbsp;|&nbsp; <i class="bi bi-person"></i> <?= htmlspecialchars($r['reviewer']) ?></div>
                                        <div class="nc-foot">
                                            <?= apprBadge($r['approval']) ?>
                                            <span class="nbadge" style="background:#e8edf8;color:#02338d"><i class="bi bi-calendar2"></i> <?= htmlspecialchars($r['rdate']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>

                            <!-- ══ CONTROLS ══ -->
                            <div class="nc-section nc-section-ctrl" data-section="ctrl">
                                <div class="nc-section-hdr s-ctrl">
                                    <i class="bi bi-shield-fill"></i>
                                    Controls &nbsp;<span class="badge bg-light text-dark"><?= $c_ctrl ?></span>
                                </div>
                                <?php if (empty($ctrls)): ?>
                                    <div class="nc-empty"><i class="bi bi-check-circle text-success"></i> No pending control notifications</div>
                                <?php else: foreach ($ctrls as $c):
                                    $dot = ($c['approval'] == '3') ? '#dc3545' : '#0d6efd';
                                ?>
                                <div class="nc-card" data-type="ctrl">
                                    <div class="nc-dot" style="background:<?= $dot ?>"></div>
                                    <div class="nc-body">
                                        <div class="nc-ref">CTL<?= str_pad($c['control_id'],3,'0',STR_PAD_LEFT) ?> &bull; <?= htmlspecialchars($c['process_name']) ?></div>
                                        <div class="nc-title" title="<?= htmlspecialchars($c['controls']) ?>"><?= htmlspecialchars(substr($c['controls'],0,80)) ?></div>
                                        <div class="nc-meta"><i class="bi bi-building"></i> <?= htmlspecialchars($c['dept_name']) ?> &nbsp;|&nbsp; <i class="bi bi-person"></i> <?= htmlspecialchars($c['reviewer']) ?></div>
                                        <div class="nc-foot">
                                            <?= apprBadge($c['approval']) ?>
                                            <span class="nbadge" style="background:#e8edf8;color:#02338d"><i class="bi bi-calendar2"></i> <?= htmlspecialchars($c['rdate']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>

                            <!-- ══ KPIs ══ -->
                            <div class="nc-section nc-section-ki" data-section="ki">
                                <div class="nc-section-hdr s-ki">
                                    <i class="bi bi-graph-up-arrow"></i>
                                    Key Performance Indicators &nbsp;<span class="badge bg-light text-dark"><?= $c_ki ?></span>
                                </div>
                                <?php if (empty($kis)): ?>
                                    <div class="nc-empty"><i class="bi bi-check-circle text-success"></i> No pending KPI notifications</div>
                                <?php else: foreach ($kis as $k):
                                    $dot = ($k['approval'] == '3') ? '#dc3545' : '#198754';
                                ?>
                                <div class="nc-card" data-type="ki">
                                    <div class="nc-dot" style="background:<?= $dot ?>"></div>
                                    <div class="nc-body">
                                        <div class="nc-ref">KPI<?= str_pad($k['id'],3,'0',STR_PAD_LEFT) ?> &bull; <?= htmlspecialchars($k['risk_name']) ?></div>
                                        <div class="nc-title" title="<?= htmlspecialchars($k['ki']) ?>"><?= htmlspecialchars(substr($k['ki'],0,80)) ?></div>
                                        <div class="nc-meta"><i class="bi bi-building"></i> <?= htmlspecialchars($k['dept_name']) ?> &nbsp;|&nbsp; <i class="bi bi-person"></i> <?= htmlspecialchars($k['owner_name']) ?></div>
                                        <div class="nc-foot">
                                            <?= apprBadge($k['approval']) ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>

                            <!-- ══ ACTIONS ══ -->
                            <div class="nc-section nc-section-act" data-section="act">
                                <div class="nc-section-hdr s-act">
                                    <i class="bi bi-lightning-fill"></i>
                                    Actions &nbsp;<span class="badge bg-light text-dark"><?= $c_act ?></span>
                                </div>
                                <?php if (empty($actions)): ?>
                                    <div class="nc-empty"><i class="bi bi-check-circle text-success"></i> No action alerts</div>
                                <?php else: foreach ($actions as $a):
                                    $isOverdue = ($a['timeline'] && $a['timeline'] < $today && $a['status'] !== 'Closed');
                                    $dot = $isOverdue ? '#dc3545' : (($a['approval']=='3') ? '#e85f00' : '#fd7e14');
                                    $badge = '';
                                    if ($isOverdue)            $badge .= '<span class="nbadge nb-overdue">Overdue</span> ';
                                    if ($a['approval']=='1')   $badge .= apprBadge('1');
                                    elseif ($a['approval']=='3') $badge .= apprBadge('3');
                                    if (!$badge)               $badge  = '<span class="nbadge nb-ok">Active</span>';
                                ?>
                                <div class="nc-card" data-type="act">
                                    <div class="nc-dot" style="background:<?= $dot ?>"></div>
                                    <div class="nc-body">
                                        <div class="nc-ref">ACT<?= str_pad($a['id'],3,'0',STR_PAD_LEFT) ?> &bull; <?= htmlspecialchars($a['risk_name']) ?></div>
                                        <div class="nc-title" title="<?= htmlspecialchars($a['action']) ?>"><?= htmlspecialchars(substr($a['action'],0,80)) ?></div>
                                        <div class="nc-meta">
                                            <i class="bi bi-building"></i> <?= htmlspecialchars($a['dept_name']) ?> &nbsp;|&nbsp;
                                            <i class="bi bi-diagram-3"></i> <?= htmlspecialchars($a['process_name']) ?> &nbsp;|&nbsp;
                                            Priority: <strong><?= htmlspecialchars($a['priority']) ?></strong>
                                        </div>
                                        <div class="nc-foot">
                                            <?= $badge ?>
                                            <span class="nbadge" style="background:#fff3e0;color:#7a4000"><i class="bi bi-calendar2-x"></i> Due: <?= htmlspecialchars($a['timeline']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>

                            <!-- ══ PROCESSES ══ -->
                            <div class="nc-section nc-section-proc" data-section="proc">
                                <div class="nc-section-hdr s-proc">
                                    <i class="bi bi-diagram-3-fill"></i>
                                    Processes &nbsp;<span class="badge bg-light text-dark"><?= $c_proc ?></span>
                                </div>
                                <?php if (empty($procs)): ?>
                                    <div class="nc-empty"><i class="bi bi-check-circle text-success"></i> No process records found</div>
                                <?php else: foreach ($procs as $p): ?>
                                <div class="nc-card" data-type="proc">
                                    <div class="nc-dot" style="background:#6f42c1"></div>
                                    <div class="nc-body">
                                        <div class="nc-ref">PRC<?= str_pad($p['process_id'],3,'0',STR_PAD_LEFT) ?> &bull; <?= htmlspecialchars($p['dept_name']) ?></div>
                                        <div class="nc-title" title="<?= htmlspecialchars($p['process_name']) ?>"><?= htmlspecialchars(substr($p['process_name'],0,80)) ?></div>
                                        <div class="nc-meta"><?= htmlspecialchars(substr($p['details'] ?? '', 0, 100)) ?></div>
                                        <div class="nc-foot">
                                            <span class="nbadge" style="background:#ede7f6;color:#4a1f8c"><i class="bi bi-building"></i> <?= htmlspecialchars($p['dept_name']) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; endif; ?>
                            </div>

                        </div><!-- nc-list -->

                    </div>
                </section>
            </div><!-- page-content -->
        </div><!-- content-wrapper -->
    </div><!-- main -->
</div><!-- app -->

<!-- ── Toast popup area ── -->
<div class="toast-area" id="toastArea"></div>

<?php include_once '../layout/footer.php'; ?>

<script>
/* ── Filter function ── */
function filterCards(type) {
    /* update filter pills */
    document.querySelectorAll('.nc-filter button').forEach(b => b.classList.remove('active'));
    const pill = document.querySelector('.nc-filter .f-' + type);
    if (pill) pill.classList.add('active');

    /* show/hide sections */
    document.querySelectorAll('.nc-section').forEach(sec => {
        if (type === 'all' || sec.dataset.section === type) {
            sec.style.display = '';
        } else {
            sec.style.display = 'none';
        }
    });
}

/* ── Toast builder ── */
function showToast(icon, color, title, msg, delay) {
    const area  = document.getElementById('toastArea');
    const toast = document.createElement('div');
    toast.className = 'nc-toast';
    toast.style.background = color;
    toast.innerHTML = `
        <span class="t-icon">${icon}</span>
        <div class="t-body">
            <div class="t-title">${title}</div>
            <div class="t-msg">${msg}</div>
        </div>
        <button class="t-close" onclick="this.closest('.nc-toast').remove()">&#x2715;</button>
    `;
    area.appendChild(toast);
    setTimeout(() => {
        toast.style.transition = 'opacity .4s';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 450);
    }, delay);
}

/* ── Fire toasts on page load ── */
window.addEventListener('DOMContentLoaded', () => {
    const toasts = [
        <?php if($c_risk  > 0): ?>
        { icon:'&#9888;', color:'#dc3545', title:'Risks',    msg:'<?= $c_risk ?> risk(s) require attention',      delay:6000  },
        <?php endif; ?>
        <?php if($c_ctrl  > 0): ?>
        { icon:'&#128737;', color:'#0d6efd', title:'Controls', msg:'<?= $c_ctrl ?> control(s) awaiting approval',  delay:8000  },
        <?php endif; ?>
        <?php if($c_ki    > 0): ?>
        { icon:'&#128200;', color:'#198754', title:'KPIs',     msg:'<?= $c_ki ?> KPI(s) pending action',            delay:10000 },
        <?php endif; ?>
        <?php if($c_act   > 0): ?>
        { icon:'&#9889;', color:'#fd7e14', title:'Actions',  msg:'<?= $c_act ?> action(s) overdue or pending',     delay:12000 },
        <?php endif; ?>
        <?php if($c_proc  > 0): ?>
        { icon:'&#128203;', color:'#6f42c1', title:'Processes',msg:'<?= $c_proc ?> process(es) on record',         delay:14000 },
        <?php endif; ?>
    ];

    toasts.forEach((t, i) => {
        setTimeout(() => showToast(t.icon, t.color, t.title, t.msg, t.delay), i * 700);
    });
});
</script>
</body>
</html>
