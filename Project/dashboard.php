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

                                <div class="hm-axis-y">Very High</div>
                                <div class="hm-cell hm-c3"></div>
                                <div class="hm-cell hm-c4"></div>
                                <div class="hm-cell hm-c5">6</div>
                                <div class="hm-cell hm-c6">8</div>
                                <div class="hm-cell hm-c6">1</div>

                                <div class="hm-axis-y">High</div>
                                <div class="hm-cell hm-c2"></div>
                                <div class="hm-cell hm-c3">1</div>
                                <div class="hm-cell hm-c4">4</div>
                                <div class="hm-cell hm-c5">2</div>
                                <div class="hm-cell hm-c5"></div>

                                <div class="hm-axis-y">Medium</div>
                                <div class="hm-cell hm-c1"></div>
                                <div class="hm-cell hm-c2"></div>
                                <div class="hm-cell hm-c3">3</div>
                                <div class="hm-cell hm-c4"></div>
                                <div class="hm-cell hm-c4"></div>

                                <div class="hm-axis-y">Low</div>
                                <div class="hm-cell hm-c1"></div>
                                <div class="hm-cell hm-c1"></div>
                                <div class="hm-cell hm-c2"></div>
                                <div class="hm-cell hm-c3"></div>
                                <div class="hm-cell hm-c3"></div>

                                <div class="hm-axis-y">Very Low</div>
                                <div class="hm-cell hm-c1"></div>
                                <div class="hm-cell hm-c1"></div>
                                <div class="hm-cell hm-c1"></div>
                                <div class="hm-cell hm-c2"></div>
                                <div class="hm-cell hm-c2"></div>

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
                            <div class="dash-card-title">2. Risk Appetite Overview</div>
                            <div class="gauge-grid">
                                <div class="gauge-item">
                                    <svg id="g1" viewBox="0 0 200 110" style="width:100%;max-width:120px;"></svg>
                                    <div class="gauge-lbl">Strategic</div>
                                </div>
                                <div class="gauge-item">
                                    <svg id="g2" viewBox="0 0 200 110" style="width:100%;max-width:120px;"></svg>
                                    <div class="gauge-lbl">Operational</div>
                                </div>
                                <div class="gauge-item">
                                    <svg id="g3" viewBox="0 0 200 110" style="width:100%;max-width:120px;"></svg>
                                    <div class="gauge-lbl">Financial</div>
                                </div>
                                <div class="gauge-item">
                                    <svg id="g4" viewBox="0 0 200 110" style="width:100%;max-width:120px;"></svg>
                                    <div class="gauge-lbl">Cyber</div>
                                </div>
                                <div class="gauge-item gauge-5th">
                                    <svg id="g5" viewBox="0 0 200 110" style="width:100%;max-width:120px;"></svg>
                                    <div class="gauge-lbl">Third-Party</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 3. Residual Risk Exposure -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">3. Residual Risk Exposure (USD)</div>
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
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:100%;background:#1565c0;"><?= $riskNumb ?></div></div>
                                    <span class="pipe-num"><?= $riskNumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Controls</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:80%;background:#1976d2;"><?= $controlNumb ?></div></div>
                                    <span class="pipe-num"><?= $controlNumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Actions</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:70%;background:#f57c00;"><?= $actionNumb ?></div></div>
                                    <span class="pipe-num"><?= $actionNumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Key Indicators</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:60%;background:#7b1fa2;"><?= $kiNumb ?></div></div>
                                    <span class="pipe-num"><?= $kiNumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Incidents</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:50%;background:#c62828;"><?= $incidentnumb ?></div></div>
                                    <span class="pipe-num"><?= $incidentnumb ?></span>
                                </div>
                                <div class="pipe-row">
                                    <span class="pipe-label">Recommend.</span>
                                    <div class="pipe-bar-wrap"><div class="pipe-bar" style="width:65%;background:#2e7d32;"><?= $recommendNumb ?></div></div>
                                    <span class="pipe-num"><?= $recommendNumb ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- 5. KRI Breach Radar -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">5. KRI Breach Radar (Early Warning)</div>
                            <canvas id="radarChart" style="max-height:220px;"></canvas>
                        </div>
                    </div>

                    <!-- 6. Risk Ownership Map -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">6. Risk Ownership Map</div>
                            <div class="own-grid mt-2">
                                <div class="own-tile" style="background:#1565c0;">
                                    <div class="dept">Finance</div>
                                    <div class="pct">22%</div>
                                </div>
                                <div class="own-tile" style="background:#2e7d32;">
                                    <div class="dept">Operations</div>
                                    <div class="pct">25%</div>
                                </div>
                                <div class="own-tile" style="background:#0097a7;">
                                    <div class="dept">IT</div>
                                    <div class="pct">18%</div>
                                </div>
                                <div class="own-tile" style="background:#f57c00;">
                                    <div class="dept">Procurement</div>
                                    <div class="pct">15%</div>
                                </div>
                                <div class="own-tile" style="background:#7b1fa2;">
                                    <div class="dept">HR</div>
                                    <div class="pct">10%</div>
                                </div>
                                <div class="own-tile" style="background:#546e7a;">
                                    <div class="dept">Legal</div>
                                    <div class="pct">10%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ── Row 4: Loss Curve | Watchlist | Priority Table ─────── -->
                <div class="row g-2">

                    <!-- 7. Scenario Loss Curve -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">7. Scenario Loss Curve (Cumulative Exposure)</div>
                            <canvas id="lineChart" style="max-height:220px;"></canvas>
                        </div>
                    </div>

                    <!-- 8. Emerging Risk Watchlist -->
                    <div class="col-12 col-lg-4">
                        <div class="dash-card">
                            <div class="dash-card-title">8. Emerging Risk Watchlist</div>
                            <div class="watch-item">
                                <div class="watch-icon" style="background:#fde8e8;">🤖</div>
                                <div>
                                    <div class="watch-name">Finance Bill 2026</div>
                                    <div class="watch-sub">Legislative &amp; compliance exposure</div>
                                </div>
                                <span class="risk-badge badge-high">High</span>
                            </div>
                            <div class="watch-item">
                                <div class="watch-icon" style="background:#fff3e0;">⛽</div>
                                <div>
                                    <div class="watch-name">EPRA Fuel Price Increase</div>
                                    <div class="watch-sub">Operational cost pressure</div>
                                </div>
                                <span class="risk-badge badge-high">High</span>
                            </div>
                            <div class="watch-item">
                                <div class="watch-icon" style="background:#eafaf1;">🌍</div>
                                <div>
                                    <div class="watch-name">Global Conflict</div>
                                    <div class="watch-sub">Supply chain &amp; trade disruption</div>
                                </div>
                                <span class="risk-badge badge-med">Medium</span>
                            </div>
                            <div class="watch-item">
                                <div class="watch-icon" style="background:#e3f2fd;">🧠</div>
                                <div>
                                    <div class="watch-name">Mental Health Risk</div>
                                    <div class="watch-sub">Workforce resilience gaps</div>
                                </div>
                                <span class="risk-badge badge-low">Low</span>
                            </div>
                            <div class="watch-item">
                                <div class="watch-icon" style="background:#f5eeff;">⚡</div>
                                <div>
                                    <div class="watch-name">Business Continuity</div>
                                    <div class="watch-sub">Resilience gaps identified</div>
                                </div>
                                <span class="risk-badge badge-high">High</span>
                            </div>
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
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td style="font-weight:700;color:#1565c0;">RM-001</td>
                                        <td>Critical vendor dependency</td>
                                        <td>Procurement</td>
                                        <td><span class="status-pill s-overdue">Overdue</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:700;color:#1565c0;">RM-002</td>
                                        <td>System outage exposure</td>
                                        <td>IT</td>
                                        <td><span class="status-pill s-progress">In Progress</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:700;color:#1565c0;">RM-003</td>
                                        <td>Demand volatility impact</td>
                                        <td>Operations</td>
                                        <td><span class="status-pill s-approved">Approved</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:700;color:#1565c0;">RM-004</td>
                                        <td>Currency fluctuation risk</td>
                                        <td>Finance</td>
                                        <td><span class="status-pill s-overdue">Overdue</span></td>
                                    </tr>
                                    <tr>
                                        <td style="font-weight:700;color:#1565c0;">RM-005</td>
                                        <td>Business continuity gap</td>
                                        <td>Risk Mgmt</td>
                                        <td><span class="status-pill s-identified">Identified</span></td>
                                    </tr>
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
drawGauge('g1', 70, '#1565c0');
drawGauge('g2', 65, '#2e7d32');
drawGauge('g3', 60, '#f57c00');
drawGauge('g4', 75, '#7b1fa2');
drawGauge('g5', 55, '#c62828');

// ── Bar Chart ─────────────────────────────────────────────────────────────────
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: ['Inherent\nExposure', 'Existing\nControls', 'Treatment\nActions', 'Residual\nExposure'],
        datasets: [{
            data: [5.8, -1.9, -1.3, 2.6],
            backgroundColor: ['#1565c0', '#c62828', '#c62828', '#2e7d32'],
            borderRadius: 4
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: {
            y: { ticks: { callback: v => '$' + v + 'M', font: { size: 10 } }, grid: { color: '#f0f2f7' } },
            x: { ticks: { font: { size: 9 } }, grid: { display: false } }
        }
    }
});

// ── Radar Chart ───────────────────────────────────────────────────────────────
new Chart(document.getElementById('radarChart'), {
    type: 'radar',
    data: {
        labels: ['Regulatory\nChange', 'Supplier\nDependency', 'Downtime', 'Data\nQuality', 'Safety', 'Liquidity'],
        datasets: [{
            label: 'Breach Score',
            data: [82, 68, 55, 74, 45, 60],
            backgroundColor: 'rgba(21,101,192,0.15)',
            borderColor: '#1565c0',
            pointBackgroundColor: '#1565c0',
            pointRadius: 4,
            borderWidth: 2
        }, {
            label: 'Appetite Limit',
            data: [70, 70, 70, 70, 70, 70],
            backgroundColor: 'rgba(198,40,40,0.05)',
            borderColor: '#c62828',
            borderDash: [4, 4],
            pointRadius: 0,
            borderWidth: 1.5
        }]
    },
    options: {
        plugins: { legend: { labels: { font: { size: 10 }, boxWidth: 12, padding: 8 } } },
        scales: {
            r: {
                min: 0, max: 100,
                ticks: { stepSize: 25, font: { size: 9 }, display: false },
                pointLabels: { font: { size: 9 } },
                grid: { color: '#e9ecef' }
            }
        }
    }
});

// ── Line Chart ────────────────────────────────────────────────────────────────
new Chart(document.getElementById('lineChart'), {
    type: 'line',
    data: {
        labels: ['0%', '20%', '40%', '60%', '80%', '100%'],
        datasets: [{
            label: 'Base Case',
            data: [0, 0.6, 1.4, 2.5, 3.8, 4.6],
            borderColor: '#1565c0',
            backgroundColor: 'rgba(21,101,192,0.08)',
            borderWidth: 2, fill: true, tension: 0.4, pointRadius: 2
        }, {
            label: 'Severe Case',
            data: [0, 0.9, 2.1, 3.6, 5.2, 6.8],
            borderColor: '#f57c00',
            backgroundColor: 'rgba(245,124,0,0.06)',
            borderWidth: 2, fill: true, tension: 0.4, pointRadius: 2
        }, {
            label: 'Stress Case',
            data: [0, 1.3, 3.0, 5.2, 7.5, 9.8],
            borderColor: '#c62828',
            backgroundColor: 'rgba(198,40,40,0.05)',
            borderWidth: 2, fill: true, tension: 0.4, pointRadius: 2
        }]
    },
    options: {
        plugins: { legend: { labels: { font: { size: 10 }, boxWidth: 12, padding: 8 } } },
        scales: {
            y: { ticks: { callback: v => '$' + v + 'M', font: { size: 10 } }, grid: { color: '#f0f2f7' } },
            x: {
                title: { display: true, text: 'Probability', font: { size: 10 } },
                ticks: { font: { size: 9 } }, grid: { display: false }
            }
        }
    }
});
</script>

<script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/pages/horizontal-layout.js"></script>

</body>
</html>
