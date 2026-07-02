<?php
// Internal Audit module landing — the entry point launched from systemover.php's
// "INTERNAL AUDIT" tile (./audit/). Presents the PSASB internal-audit module with
// live counts and links into the implemented pages under ../Project/.
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['uid'])) {
    header('Location: ../login.php');
    exit;
}
require_once __DIR__ . '/../Project/connection/connect.php'; // $con (shared mysqli)

function ia_count($con, string $table): int {
    $res = mysqli_query($con, "SELECT COUNT(*) FROM `" . $table . "`");
    return $res ? (int)(mysqli_fetch_row($res)[0] ?? 0) : 0;
}
$counts = [
    'charters'    => ia_count($con, 'ia_charter'),
    'strategic'   => ia_count($con, 'ia_strategic_plan'),
    'annual'      => ia_count($con, 'ia_annual_plan'),
    'engagements' => ia_count($con, 'audit_engagement'),
    'findings'    => ia_count($con, 'ia_finding'),
    'reports'     => ia_count($con, 'ia_final_report') + ia_count($con, 'ia_report_summary'),
    'surveys'     => ia_count($con, 'ia_survey'),
];

// PSASB-aligned module areas -> implemented pages (under ../Project/)
$areas = [
    ['Charters', 'Audit Committee &amp; Internal Audit Charters', 'bi-clipboard2-check-fill', '#02338d', '../Project/iacharter.php', $counts['charters'], 'charters'],
    ['Strategic Plan', 'Multi-year risk-based IA strategy', 'bi-diagram-3-fill', '#0097a7', '../Project/iastrategicplan.php', $counts['strategic'], 'plans'],
    ['Annual Plan', 'Annual risk-based audit schedule', 'bi-calendar2-week-fill', '#2e7d32', '../Project/iaannualplan.php', $counts['annual'], 'plans'],
    ['Engagements', 'Notifications, planning, fieldwork &amp; workpapers', 'bi-briefcase-fill', '#f57c00', '../Project/engagements.php', $counts['engagements'], 'engagements'],
    ['Findings Database', 'All audit findings across engagements', 'bi-database-fill-exclamation', '#c62828', '../Project/findingsdatabase.php', $counts['findings'], 'findings'],
    ['Reports', 'Final, action-plan, quarterly &amp; annual reports', 'bi-file-earmark-bar-graph-fill', '#6a1b9a', '../Project/iareports.php', $counts['reports'], 'reports'],
    ['Performance &amp; QA', 'Surveys, KPI matrix &amp; external assessment', 'bi-patch-check-fill', '#546e7a', '../Project/iaqa.php', $counts['surveys'], 'records'],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Internal Audit — RISKPRO</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <link rel="stylesheet" href="../assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <style>
        body { background:#014a54; font-family:'Nunito',Arial,sans-serif; min-height:100vh; }
        .ia-head { color:#fff; padding:26px 0 10px; }
        .ia-head h2 { font-weight:800; letter-spacing:.5px; margin:0; color:#ffffff; }
        .ia-head p { color:#bfe3e8; margin:2px 0 0; font-size:13px; }
        .ia-card { background:#fff; border-radius:10px; padding:20px; height:100%; text-decoration:none; display:block;
                   box-shadow:0 2px 10px rgba(0,0,0,.15); transition:transform .12s, box-shadow .12s; }
        .ia-card:hover { transform:translateY(-3px); box-shadow:0 8px 20px rgba(0,0,0,.25); text-decoration:none; }
        .ia-ico { width:52px; height:52px; border-radius:12px; display:flex; align-items:center; justify-content:center; color:#fff; font-size:26px; }
        .ia-title { font-weight:800; color:#12303a; margin:12px 0 2px; font-size:17px; }
        .ia-sub { color:#6b7c82; font-size:12.5px; min-height:34px; }
        .ia-count { font-weight:800; font-size:22px; color:#02338d; }
        .ia-count small { font-size:11px; color:#8a99a0; font-weight:600; }
        .ia-topbar a { color:#bfe3e8; text-decoration:none; font-size:13px; }
        .ia-topbar a:hover { color:#fff; }
    </style>
</head>
<body>
    <div class="container py-3">
        <div class="ia-topbar d-flex justify-content-between align-items-center pt-2">
            <a href="../systemover.php">&larr; RISKPRO Overview</a>
            <a href="../Project/logout.php">Logout</a>
        </div>
        <div class="ia-head text-center">
            <h2><i class="bi bi-shield-shaded"></i> INTERNAL AUDIT</h2>
            <p>PSASB internal-audit lifecycle — Governance · Planning · Engagements · Fieldwork · Reporting · Quality Assurance</p>
        </div>
        <div class="row g-3 py-3">
            <?php foreach ($areas as $a): ?>
                <div class="col-12 col-sm-6 col-lg-4">
                    <a href="<?= $a[4] ?>" class="ia-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="ia-ico" style="background:<?= $a[3] ?>;"><i class="bi <?= $a[2] ?>"></i></div>
                            <div class="text-end"><div class="ia-count"><?= (int)$a[5] ?></div><small><?= $a[6] ?></small></div>
                        </div>
                        <div class="ia-title"><?= $a[0] ?></div>
                        <div class="ia-sub"><?= $a[1] ?></div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
