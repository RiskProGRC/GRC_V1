<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['uid'])) { header('Location:../login.php'); exit; }
require_once __DIR__ . '/iaplan/iaannualplanClass.php';
require_once __DIR__ . '/department/departmentClass.php';
require_once __DIR__ . '/process/processClass.php';
require_once __DIR__ . '/risk/riskClass.php';

$apcls  = new iaannualplanClass();
$planId = (isset($_GET['id']) && ctype_digit((string)$_GET['id'])) ? $_GET['id'] : '';
$plan   = $planId !== '' ? $apcls->planDetails($planId) : null;
$items  = $plan ? $apcls->showitems($planId) : [];
$deptClass = new departmentClass();
$processClass = new processClass();
$riskClass = new riskClass();
function vh($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $plan ? 'Annual Audit Plan ' . (int)$plan['plan_year'] : 'Plan not found' ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <style>
        body{background:#f4f6fb;font-family:'Nunito',Arial,sans-serif;color:#1a1a1a;}
        .doc{max-width:1100px;margin:24px auto;background:#fff;padding:40px 44px;box-shadow:0 2px 14px rgba(0,0,0,.08);}
        .doc h1{font-size:22px;color:#02338d;border-bottom:3px solid #02338d;padding-bottom:10px;}
        .doc .meta{font-size:13px;color:#555;margin-bottom:18px;}
        table.sched{width:100%;border-collapse:collapse;font-size:12px;}
        table.sched th{background:#02338d;color:#fff;padding:6px;border:1px solid #24509c;text-align:left;}
        table.sched td{padding:5px 6px;border:1px solid #c9d6ea;vertical-align:top;}
        .toolbar{max-width:1100px;margin:0 auto;text-align:right;}
        @media print{body{background:#fff;}.toolbar{display:none;}.doc{box-shadow:none;margin:0;max-width:100%;}}
    </style>
</head><body>
    <div class="toolbar">
        <a href="iaannualplan.php" class="btn btn-secondary btn-sm">&larr; Back</a>
        <?php if ($plan): ?><button onclick="window.print()" class="btn btn-primary btn-sm">Print / Save PDF</button><?php endif; ?>
    </div>
    <?php if (!$plan): ?>
        <div class="doc"><h1>Plan not found</h1></div>
    <?php else: ?>
        <div class="doc">
            <div style="font-size:12px;letter-spacing:1px;color:#888;text-transform:uppercase;">Annual Risk-Based Internal Audit Plan</div>
            <h1><?= vh($plan['title']) ?> — <?= (int)$plan['plan_year'] ?></h1>
            <div class="meta"><b>Status:</b> <?= vh($plan['status']) ?>
                <?= $plan['approved_by'] ? ' &nbsp;|&nbsp; <b>Approved By:</b> ' . vh($plan['approved_by']) : '' ?>
                <?= $plan['approved_date'] ? ' &nbsp;|&nbsp; <b>Approved:</b> ' . vh($plan['approved_date']) : '' ?></div>
            <table class="sched">
                <thead><tr><th>#</th><th>Audit Area / Title</th><th>Department</th><th>Process</th><th>Related Risk</th><th>Rating</th><th>Qtr</th><th>Days</th><th>Status</th></tr></thead>
                <tbody>
                <?php if (!$items): ?>
                    <tr><td colspan="9" style="text-align:center;color:#888;">No audits scheduled.</td></tr>
                <?php else: $n = 1; foreach ($items as $it): ?>
                    <tr>
                        <td><?= $n++ ?></td>
                        <td><?= vh($it['audit_title']) ?></td>
                        <td><?= vh($deptClass->deptJoins((string)$it['dept_id'])) ?></td>
                        <td><?= $it['process_id'] ? vh($processClass->processJoins((string)$it['process_id'])) : '—' ?></td>
                        <td><?= $it['risk_id'] ? vh($riskClass->Riskjoin((string)$it['risk_id'])) : '—' ?></td>
                        <td><?= vh($it['risk_rating'] ?: '—') ?></td>
                        <td><?= $it['quarter_planned'] ? 'Q' . (int)$it['quarter_planned'] : '—' ?></td>
                        <td><?= $it['budgeted_days'] !== null ? (int)$it['budgeted_days'] : '—' ?></td>
                        <td><?= vh($it['status']) ?></td>
                    </tr>
                <?php endforeach; endif; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</body></html>
