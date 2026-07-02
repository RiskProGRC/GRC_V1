<?php

include'../Project/department/departmentClass.php';
include'../Project/control/controlClass.php';
include'../Project/raf/kriClass.php';
include'../Project/keyindicator/keyindicatorClass.php';
include'../Project/recommend/recommendClass.php';
include'../Project/action/actionClass.php';
include'../Project/incident/incidentClass.php';
include_once'./settings/riskcategoryClass.php';
include_once'./connection/connect.php';
include_once'./settings/controlstrengthClass.php';

$riskcatclass   = new riskCatClass();
$cstrengthclass = new controlstrengthClass();

$kriClass  = new kriClass();
$showkri   = $kriClass->fetchkri();

$deptClass  = new departmentClass();
$deptNumb   = $deptClass->dashboard();

$controlClass = new controlClass();
$controlNumb  = $controlClass->dashboard();

$kiclass  = new kiClass();
$kiNumb   = $kiclass->dashboard();

$recommendclass = new recommendClass();
$recommendNumb  = $recommendclass->dashboard();

$actionclass = new actionClass();
$actionNumb  = $actionclass->dashboard();

$incidentclass = new incidentclass();
$incidentnumb  = $incidentclass->dashboard();
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once'../layout/header.php';
$riskNumb    = $riskClass->dashboard();
$showriskcat = $riskClass->showriskcat();

/* ============================================================
   REAL dashboard data — replaces the previous hardcoded facade
   values. All figures are computed live from the database.
   ============================================================ */
// residual-score band -> [label, heatmap css class, watch badge class, hex]
function dash_band(int $s): array {
    if ($s >= 17) return ['Extreme', 'hm-c6', 'badge-high', '#7b0000'];
    if ($s >= 10) return ['High',    'hm-c4', 'badge-high', '#f57c00'];
    if ($s >= 5)  return ['Medium',  'hm-c3', 'badge-med',  '#fbc02d'];
    if ($s >= 1)  return ['Low',     'hm-c1', 'badge-low',  '#388e3c'];
    return ['—', 'hm-c1', 'badge-low', '#e9ecef'];
}
function dash_h($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }

// 1) Heatmap counts: $heat[rimp][rlikely]
$heat = [];
$rs = mysqli_query($con, "SELECT rimp, rlikely, COUNT(*) c FROM assessment WHERE rimp BETWEEN 1 AND 5 AND rlikely BETWEEN 1 AND 5 GROUP BY rimp, rlikely");
if ($rs) while ($r = mysqli_fetch_assoc($rs)) { $heat[(int)$r['rimp']][(int)$r['rlikely']] = (int)$r['c']; }

// 2) Ownership by department (top 6) + real percentages
$ownRows = []; $ownTotal = 0;
$rs = mysqli_query($con, "SELECT dept, COUNT(*) c FROM risk WHERE dept IS NOT NULL AND dept <> '' GROUP BY dept ORDER BY c DESC LIMIT 6");
if ($rs) while ($r = mysqli_fetch_assoc($rs)) { $ownRows[] = $r; }
$rowTot = mysqli_fetch_row(mysqli_query($con, "SELECT COUNT(*) FROM risk"));
$riskTotalAll = max(1, (int)($rowTot[0] ?? 1));
$ownColors = ['#1565c0', '#2e7d32', '#0097a7', '#f57c00', '#7b1fa2', '#546e7a'];

// 3) Top priority risks (highest residual score)
$topRisks = [];
$rs = mysqli_query($con, "SELECT a.risk_id, r.risk_name, r.dept, (a.rimp*a.rlikely) score FROM assessment a JOIN risk r ON r.risk_id=a.risk_id ORDER BY score DESC, a.risk_id DESC LIMIT 6");
if ($rs) while ($r = mysqli_fetch_assoc($rs)) { $topRisks[] = $r; }

// 4) Watchlist: untreated risks with the highest residual score
$watchRisks = [];
$rs = mysqli_query($con, "SELECT r.risk_name, r.dept, (a.rimp*a.rlikely) score FROM assessment a JOIN risk r ON r.risk_id=a.risk_id WHERE a.treatment IS NULL ORDER BY score DESC, a.risk_id DESC LIMIT 5");
if ($rs) while ($r = mysqli_fetch_assoc($rs)) { $watchRisks[] = $r; }

// 5) Category gauges: top 5 categories by risk count, avg residual as % of max (25)
$catGauges = [];
$gaugeColors = ['#1565c0', '#2e7d32', '#f57c00', '#7b1fa2', '#c62828'];
$rs = mysqli_query($con, "SELECT rc.name, COUNT(r.risk_id) cnt, AVG(a.rimp*a.rlikely) avgscore FROM riskcat rc JOIN risk r ON r.rcat=rc.riskcat_id LEFT JOIN assessment a ON a.risk_id=r.risk_id GROUP BY rc.riskcat_id, rc.name HAVING cnt > 0 ORDER BY cnt DESC LIMIT 5");
if ($rs) while ($r = mysqli_fetch_assoc($rs)) { $catGauges[] = ['name' => $r['name'], 'pct' => (int)round(((float)($r['avgscore'] ?? 0)) / 25 * 100)]; }

// 6) Aggregate exposure scores (inherent / residual / target) — real risk scores, not $
$exRow = mysqli_fetch_assoc(mysqli_query($con, "SELECT COALESCE(SUM(iimp*ilikely),0) inh, COALESCE(SUM(rimp*rlikely),0) res, COALESCE(SUM(timp*tlikely),0) tgt FROM assessment")) ?: ['inh' => 0, 'res' => 0, 'tgt' => 0];

// 7) Treatment distribution (Accept/Avoid/Transfer/Mitigate/Untreated)
$treatMap = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 0 => 0];
$rs = mysqli_query($con, "SELECT COALESCE(treatment,0) t, COUNT(*) c FROM assessment GROUP BY COALESCE(treatment,0)");
if ($rs) while ($r = mysqli_fetch_assoc($rs)) { $treatMap[(int)$r['t']] = (int)$r['c']; }

// 8) Pipeline proportional bar widths
$pipeMax = max(1, (int)$riskNumb, (int)$controlNumb, (int)$actionNumb, (int)$kiNumb, (int)$incidentnumb, (int)$recommendNumb);
$pipeW = fn($n) => max(4, (int)round((int)$n / $pipeMax * 100));
$kriHasData = is_array($showkri) && count($showkri) > 0;
?>

<!-- Chart.js & FontAwesome -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<link  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
    /* ── Dashboard layout ─────────────────────────────────────────── */
    .dash-wrap { padding: 14px 16px 30px; }

    /* ── KPI cards ────────────────────────────────────────────────── */
    .kpi-card {
        background: #fff;
        border-radius: 8px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        height: 100%;
    }
    .kpi-icon {
        width: 42px; height: 42px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 18px;
        flex-shrink: 0;
    }
    .kpi-num { font-size: 24px; font-weight: 800; line-height: 1; }
    .kpi-lbl { font-size: 11px; color: #888; margin-top: 2px; }

    /* ── Section cards ────────────────────────────────────────────── */
    .dash-card {
        background: #fff;
        border-radius: 8px;
        padding: 14px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
        height: 100%;
    }
    .dash-card-title {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #555;
        margin-bottom: 10px;
    }

    /* ── Heatmap ──────────────────────────────────────────────────── */
    .heatmap-grid {
        display: grid;
        grid-template-columns: 60px repeat(5, 1fr);
        gap: 3px;
    }
    .hm-cell {
        height: 32px;
        border-radius: 4px;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; color: #fff;
    }
    .hm-axis-y { font-size: 9px; color: #666; display: flex; align-items: center; justify-content: flex-end; padding-right: 5px; height: 32px; font-weight: 600; }
    .hm-axis-x { font-size: 9px; color: #666; text-align: center; padding-top: 3px; font-weight: 600; }
    .hm-c1 { background: #388e3c; }
    .hm-c2 { background: #7cb342; }
    .hm-c3 { background: #fbc02d; }
    .hm-c4 { background: #f57c00; }
    .hm-c5 { background: #d32f2f; }
    .hm-c6 { background: #7b0000; }

    /* ── Gauges ───────────────────────────────────────────────────── */
    .gauge-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; }
    .gauge-item { text-align: center; }
    .gauge-lbl  { font-size: 10px; color: #555; font-weight: 600; margin-top: -4px; }
    .gauge-5th  { grid-column: 1 / -1; max-width: 120px; margin: 0 auto; }

    /* ── Treatment pipeline ───────────────────────────────────────── */
    .pipe-row      { display: flex; align-items: center; gap: 6px; margin-bottom: 7px; }
    .pipe-label    { font-size: 11px; color: #555; width: 80px; flex-shrink: 0; }
    .pipe-bar-wrap { flex: 1; background: #f0f2f7; border-radius: 4px; height: 22px; overflow: hidden; }
    .pipe-bar      { height: 100%; border-radius: 4px; display: flex; align-items: center; padding-left: 8px; font-size: 11px; font-weight: 700; color: #fff; }
    .pipe-num      { font-size: 11px; font-weight: 700; width: 24px; text-align: right; color: #555; }

    /* ── Ownership tiles ──────────────────────────────────────────── */
    .own-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 6px; }
    .own-tile { border-radius: 6px; padding: 10px 12px; color: #fff; }
    .own-tile .dept { font-weight: 700; font-size: 12px; }
    .own-tile .pct  { font-size: 18px; font-weight: 800; }

    /* ── Watchlist ────────────────────────────────────────────────── */
    .watch-item { display: flex; align-items: center; gap: 10px; padding: 8px 0; border-bottom: 1px solid #f0f2f7; }
    .watch-item:last-child { border-bottom: none; }
    .watch-icon { width: 34px; height: 34px; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 15px; flex-shrink: 0; }
    .watch-name { font-weight: 700; font-size: 12px; }
    .watch-sub  { font-size: 10px; color: #888; }
    .risk-badge { padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 700; margin-left: auto; white-space: nowrap; }
    .badge-high { background: #fde8e8; color: #c0392b; }
    .badge-med  { background: #fff3e0; color: #e65100; }
    .badge-low  { background: #eafaf1; color: #1e8449; }

    /* ── Priority table ───────────────────────────────────────────── */
    .pri-table { width: 100%; font-size: 11px; }
    .pri-table th { background: #f5f6fa; color: #888; font-weight: 700; padding: 6px 8px; text-transform: uppercase; font-size: 10px; }
    .pri-table td { padding: 7px 8px; border-bottom: 1px solid #f0f2f7; vertical-align: middle; }
    .pri-table tr:last-child td { border-bottom: none; }
    .status-pill   { padding: 2px 7px; border-radius: 10px; font-size: 10px; font-weight: 700; white-space: nowrap; }
    .s-overdue     { background: #fde8e8; color: #c0392b; }
    .s-progress    { background: #e3f2fd; color: #1565c0; }
    .s-approved    { background: #eafaf1; color: #1e8449; }
    .s-identified  { background: #f5eeff; color: #6a1b9a; }
</style>

<body>
<div id="app">
    <div id="main" class="layout-horizontal">

        <?php include_once'../layout/nav.php'; ?>

        <div class="content-wrapper container-fluid">

            <div class="page-heading">
                <h3>Strathmore University Risk Dashboard</h3>
            </div>

            <div class="dash-wrap">

                <!-- ── KPI strip ─────────────────────────────────────────── -->
                <div class="row g-2 mb-3">
                    <div class="col-6 col-sm-4 col-xl-2">
                        <div class="kpi-card">
                            <div class="kpi-icon" style="background:#e3f2fd;">
                                <i class="fa fa-shield-halved" style="color:#1565c0;"></i>
                            </div>
                            <div>
                                <div class="kpi-num" style="color:#1565c0;"><?= $riskNumb ?></div>
                                <div class="kpi-lbl">Total Risks</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-xl-2">
                        <div class="kpi-card">
                            <div class="kpi-icon" style="background:#fde8e8;">
                                <i class="fa fa-fire" style="color:#c0392b;"></i>
                            </div>
                            <div>
                                <div class="kpi-num" style="color:#c0392b;"><?= $incidentnumb ?></div>
                                <div class="kpi-lbl">Incidents</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-xl-2">
                        <div class="kpi-card">
                            <div class="kpi-icon" style="background:#eafaf1;">
                                <i class="fa fa-shield-check" style="color:#1e8449;"></i>
                            </div>
                            <div>
                                <div class="kpi-num" style="color:#1e8449;"><?= $controlNumb ?></div>
                                <div class="kpi-lbl">Controls</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-xl-2">
                        <div class="kpi-card">
                            <div class="kpi-icon" style="background:#f5eeff;">
                                <i class="fa fa-bell" style="color:#6a1b9a;"></i>
                            </div>
                            <div>
                                <div class="kpi-num" style="color:#6a1b9a;"><?= $kiNumb ?></div>
                                <div class="kpi-lbl">Key Indicators</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-xl-2">
                        <div class="kpi-card">
                            <div class="kpi-icon" style="background:#fff3e0;">
                                <i class="fa fa-circle-check" style="color:#e65100;"></i>
                            </div>
                            <div>
                                <div class="kpi-num" style="color:#e65100;"><?= $actionNumb ?></div>
                                <div class="kpi-lbl">Actions</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-sm-4 col-xl-2">
                        <div class="kpi-card">
                            <div class="kpi-icon" style="background:#fff8e1;">
                                <i class="fa fa-lightbulb" style="color:#f9a825;"></i>
                            </div>
                            <div>
                                <div class="kpi-num" style="color:#f9a825;"><?= $recommendNumb ?></div>
                                <div class="kpi-lbl">Recommendations</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Row 2: Heatmap | Gauges | Bar Chart ───────────────── -->
                <div class="row g-2 mb-2">

                    <!-- 1. Enterprise Risk Heatmap -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">1. Enterprise Risk Heatmap</div>
                            <div class="heatmap-grid">
                                <div></div>
                                <div class="hm-axis-x">Rare</div>
                                <div class="hm-axis-x">Unlikely</div>
                                <div class="hm-axis-x">Possible</div>
                                <div class="hm-axis-x">Likely</div>
                                <div class="hm-axis-x">Almost<br>Certain</div>

                                <?php
                                $impLabels = [5 => 'Very High', 4 => 'High', 3 => 'Medium', 2 => 'Low', 1 => 'Very Low'];
                                foreach ($impLabels as $imp => $lbl) {
                                    echo '<div class="hm-axis-y">' . $lbl . '</div>';
                                    for ($lik = 1; $lik <= 5; $lik++) {
                                        $cnt  = $heat[$imp][$lik] ?? 0;
                                        $band = dash_band($imp * $lik);
                                        echo '<div class="hm-cell ' . $band[1] . '">' . ($cnt > 0 ? $cnt : '') . '</div>';
                                    }
                                }
                                ?>

                                <div></div>
                                <div style="grid-column:2/-1;text-align:center;font-size:9px;color:#999;padding-top:3px;">← Likelihood →</div>
                            </div>
                            <div class="d-flex gap-2 mt-2 flex-wrap">
                                <span style="font-size:10px;display:flex;align-items:center;gap:3px;"><span style="width:10px;height:10px;border-radius:2px;background:#388e3c;display:inline-block;"></span>Low</span>
                                <span style="font-size:10px;display:flex;align-items:center;gap:3px;"><span style="width:10px;height:10px;border-radius:2px;background:#fbc02d;display:inline-block;"></span>Medium</span>
                                <span style="font-size:10px;display:flex;align-items:center;gap:3px;"><span style="width:10px;height:10px;border-radius:2px;background:#f57c00;display:inline-block;"></span>High</span>
                                <span style="font-size:10px;display:flex;align-items:center;gap:3px;"><span style="width:10px;height:10px;border-radius:2px;background:#7b0000;display:inline-block;"></span>Extreme</span>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Risk Appetite Gauges -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">2. Residual Risk by Category (% of max)</div>
                            <div class="gauge-grid">
                                <?php foreach ($catGauges as $i => $g):
                                    $isLastOdd = (count($catGauges) % 2 !== 0 && $i === count($catGauges) - 1); ?>
                                    <div class="gauge-item<?= $isLastOdd ? ' gauge-5th' : '' ?>">
                                        <svg id="gcat<?= $i ?>" viewBox="0 0 200 110" style="width:100%;max-width:120px;"></svg>
                                        <div class="gauge-lbl"><?= dash_h($g['name']) ?></div>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (!$catGauges): ?>
                                    <div style="grid-column:1/-1;font-size:12px;color:#888;padding:24px 0;text-align:center;">No categorised risk assessments yet.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Residual Risk Exposure -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">3. Aggregate Risk Exposure (Inherent → Residual → Target)</div>
                            <canvas id="barChart" style="max-height:220px;"></canvas>
                        </div>
                    </div>
                </div>

                <!-- ── Row 3: Pipeline | Radar | Ownership ───────────────── -->
                <div class="row g-2 mb-2">

                    <!-- 4. Risk Treatment Pipeline -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">4. Risk Treatment Pipeline</div>
                            <div class="mt-1">
                                <div class="pipe-row">
                                    <span class="pipe-label">Identified</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:<?= $pipeW($riskNumb) ?>%;background:#1565c0;"><?= $riskNumb ?></div></div>
                                    <span class="pipe-num"><?= $riskNumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Controls</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:<?= $pipeW($controlNumb) ?>%;background:#1976d2;"><?= $controlNumb ?></div></div>
                                    <span class="pipe-num"><?= $controlNumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Actions</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:<?= $pipeW($actionNumb) ?>%;background:#f57c00;"><?= $actionNumb ?></div></div>
                                    <span class="pipe-num"><?= $actionNumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Key Indicators</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:<?= $pipeW($kiNumb) ?>%;background:#7b1fa2;"><?= $kiNumb ?></div></div>
                                    <span class="pipe-num"><?= $kiNumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Incidents</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:<?= $pipeW($incidentnumb) ?>%;background:#c62828;"><?= $incidentnumb ?></div></div>
                                    <span class="pipe-num"><?= $incidentnumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Recommend.</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:<?= $pipeW($recommendNumb) ?>%;background:#2e7d32;"><?= $recommendNumb ?></div></div>
                                    <span class="pipe-num"><?= $recommendNumb ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. KRI Breach Radar -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">5. KRI Breach Radar (Early Warning)</div>
                            <?php if ($kriHasData): ?>
                                <canvas id="radarChart" style="max-height:220px;"></canvas>
                            <?php else: ?>
                                <div style="height:220px;display:flex;flex-direction:column;align-items:center;justify-content:center;color:#999;text-align:center;font-size:12px;">
                                    <i class="fas fa-gauge-high" style="font-size:28px;margin-bottom:8px;"></i>
                                    No Key Risk Indicators captured yet.<br>Add KRIs under <b>Risk Monitor → KRI</b> to populate this chart.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- 6. Risk Ownership Map -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">6. Risk Ownership Map</div>
                            <div class="own-grid mt-2">
                                <?php foreach ($ownRows as $i => $o):
                                    $pct = (int)round((int)$o['c'] * 100 / $riskTotalAll); ?>
                                    <div class="own-tile" style="background:<?= $ownColors[$i % count($ownColors)] ?>;">
                                        <div class="dept"><?= dash_h($deptClass->deptJoins((string)$o['dept'])) ?></div>
                                        <div class="pct"><?= $pct ?>%</div>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (!$ownRows): ?>
                                    <div style="grid-column:1/-1;font-size:12px;color:#888;padding:24px 0;text-align:center;">No risks assigned to departments yet.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Row 4: Loss Curve | Watchlist | Priority Table ─────── -->
                <div class="row g-2">

                    <!-- 7. Scenario Loss Curve -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">7. Risk Treatment Distribution</div>
                            <canvas id="treatChart" style="max-height:220px;"></canvas>
                        </div>
                    </div>

                    <!-- 8. Emerging Risk Watchlist -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">8. Watchlist — Untreated High-Residual Risks</div>
                            <?php if (!$watchRisks): ?>
                                <div style="font-size:12px;color:#888;padding:24px 0;text-align:center;">No untreated risks — all assessed risks have a treatment.</div>
                            <?php else: foreach ($watchRisks as $w):
                                $band = dash_band((int)$w['score']);
                                $iconBg = ['badge-high' => '#fde8e8', 'badge-med' => '#fff3e0', 'badge-low' => '#eafaf1'][$band[2]] ?? '#eef2f7'; ?>
                                <div class="watch-item">
                                    <div class="watch-icon" style="background:<?= $iconBg ?>;"><i class="fas fa-triangle-exclamation" style="color:<?= $band[3] ?>;"></i></div>
                                    <div>
                                        <div class="watch-name"><?= dash_h($w['risk_name']) ?></div>
                                        <div class="watch-sub"><?= dash_h($deptClass->deptJoins((string)$w['dept'])) ?> · residual score <?= (int)$w['score'] ?></div>
                                    </div>
                                    <span class="risk-badge <?= $band[2] ?>"><?= $band[0] ?></span>
                                </div>
                            <?php endforeach; endif; ?>
                        </div>
                    </div>

                    <!-- 9. Top Priority Risks -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">Top Priority Risks</div>
                            <table class="pri-table">
                                <thead>
                                    <tr>
                                        <th>Risk ID</th>
                                        <th>Risk Event</th>
                                        <th>Owner</th>
                                        <th>Severity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!$topRisks): ?>
                                        <tr><td colspan="4" style="text-align:center;color:#888;">No assessed risks yet.</td></tr>
                                    <?php else:
                                        $sevPill = ['Extreme' => 's-overdue', 'High' => 's-progress', 'Medium' => 's-identified', 'Low' => 's-approved'];
                                        foreach ($topRisks as $t):
                                            $band = dash_band((int)$t['score']); ?>
                                        <tr>
                                            <td style="font-weight:700;color:#1565c0;">RSK<?= str_pad((string)$t['risk_id'], 3, '0', STR_PAD_LEFT) ?></td>
                                            <td><?= dash_h($t['risk_name']) ?></td>
                                            <td><?= dash_h($deptClass->deptJoins((string)$t['dept'])) ?></td>
                                            <td><span class="status-pill <?= $sevPill[$band[0]] ?? 's-identified' ?>"><?= $band[0] ?> (<?= (int)$t['score'] ?>)</span></td>
                                        </tr>
                                    <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div><!-- /dash-wrap -->
        </div><!-- /content-wrapper -->

        <?php include_once'../layout/footer.php'; ?>

    </div>
</div>

<script>
// ── Gauge helper ─────────────────────────────────────────────────────────────
function drawGauge(svgId, value, color) {
    const svg = document.getElementById(svgId);
    const r = 78, cx = 100, cy = 100;
    const angle = (1 - value / 100) * Math.PI;
    const ex = cx + r * Math.cos(angle);
    const ey = cy - r * Math.sin(angle);
    const large = value > 50 ? 1 : 0;
    const bg = `M ${cx - r} ${cy} A ${r} ${r} 0 0 0 ${cx + r} ${cy}`;
    const fg = value >= 100
        ? `M ${cx - r} ${cy} A ${r} ${r} 0 0 0 ${cx} ${cy - r} A ${r} ${r} 0 0 0 ${cx + r} ${cy}`
        : value <= 0 ? ''
        : `M ${cx - r} ${cy} A ${r} ${r} 0 ${large} 0 ${ex.toFixed(2)} ${ey.toFixed(2)}`;
    svg.innerHTML = `
        <path d="${bg}" fill="none" stroke="#e9ecef" stroke-width="13"/>
        ${fg ? `<path d="${fg}" fill="none" stroke="${color}" stroke-width="13" stroke-linecap="round"/>` : ''}
        <text x="${cx}" y="${cy - 4}" text-anchor="middle"
              font-size="26" font-weight="800" fill="#1a1a2e"
              font-family="Segoe UI,Arial,sans-serif">${value}%</text>`;
}
// ── Category residual gauges (real data) ───────────────────────────────────────
<?php foreach ($catGauges as $i => $g): ?>
drawGauge('gcat<?= $i ?>', <?= (int)$g['pct'] ?>, '<?= $gaugeColors[$i % count($gaugeColors)] ?>');
<?php endforeach; ?>

// ── Aggregate Risk Exposure bar (real scores: inherent → residual → target) ─────
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Inherent', 'Residual', 'Target'],
        datasets: [{
            data: [<?= (int)$exRow['inh'] ?>, <?= (int)$exRow['res'] ?>, <?= (int)$exRow['tgt'] ?>],
            backgroundColor: ['#1565c0', '#f57c00', '#2e7d32'],
            borderRadius: 4
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { beginAtZero: true, ticks: { font: { size: 10 } }, grid: { color: '#f0f2f7' }, title: { display: true, text: 'Aggregate risk score', font: { size: 9 } } },
            x: { ticks: { font: { size: 10 } }, grid: { display: false } }
        }
    }
});

// ── KRI Breach Radar — only when real KRI data exists (empty-state otherwise) ────
<?php if ($kriHasData): ?>
new Chart(document.getElementById('radarChart'), {
    type: 'radar',
    data: {
        labels: <?= json_encode(array_map(fn($k) => $k['b_objective'] ?? ($k['kri'] ?? 'KRI'), array_slice($showkri, 0, 6))) ?>,
        datasets: [{
            label: 'KRIs',
            data: <?= json_encode(array_map(fn($k) => (int)($k['perform'] ?? 0), array_slice($showkri, 0, 6))) ?>,
            backgroundColor: 'rgba(21,101,192,0.15)', borderColor: '#1565c0', pointBackgroundColor: '#1565c0', pointRadius: 4, borderWidth: 2
        }]
    },
    options: { plugins: { legend: { labels: { font: { size: 10 }, boxWidth: 12, padding: 8 } } }, scales: { r: { pointLabels: { font: { size: 9 } }, grid: { color: '#e9ecef' } } } }
});
<?php endif; ?>

// ── Risk Treatment Distribution doughnut (real assessment.treatment counts) ──────
new Chart(document.getElementById('treatChart'), {
    type: 'doughnut',
    data: {
        labels: ['Accept', 'Avoid', 'Transfer', 'Mitigate', 'Untreated'],
        datasets: [{
            data: [<?= (int)$treatMap[1] ?>, <?= (int)$treatMap[2] ?>, <?= (int)$treatMap[3] ?>, <?= (int)$treatMap[4] ?>, <?= (int)$treatMap[0] ?>],
            backgroundColor: ['#2e7d32', '#0097a7', '#7b1fa2', '#1565c0', '#c62828']
        }]
    },
    options: { plugins: { legend: { position: 'bottom', labels: { font: { size: 10 }, boxWidth: 12, padding: 6 } } } }
});
</script>

<script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/pages/horizontal-layout.js"></script>

</body>
</html>
