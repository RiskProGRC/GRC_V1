<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['uid'])) { header('Location:../login.php'); exit; }
require_once __DIR__ . '/engagement/reportingclasses.php';
require_once __DIR__ . '/engagement/fieldworkclasses.php';
require_once __DIR__ . '/engagement/engagementClass.php';
require_once __DIR__ . '/department/departmentClass.php';

$id  = (isset($_GET['id']) && ctype_digit((string)$_GET['id'])) ? $_GET['id'] : '';
$frcls = new finalReportClass();
$rep = $id !== '' ? $frcls->details($id) : null;
$eng = $rep ? (new engagementClass())->details((string)$rep['engagement_id']) : null;
$findings = $rep ? (new findingClass())->byEng((string)$rep['engagement_id']) : [];
$fcls = new findingClass();
$ratingMap = []; foreach ($fcls->ratings() as $rt) $ratingMap[(int)$rt['id']] = $rt['grade'];
$deptClass = new departmentClass();
function vh($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $rep ? vh($rep['report_title']) : 'Report not found' ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <style>
        body{background:#f4f6fb;font-family:'Nunito',Arial,sans-serif;color:#1a1a1a;}
        .doc{max-width:1000px;margin:24px auto;background:#fff;padding:44px 50px;box-shadow:0 2px 14px rgba(0,0,0,.08);}
        .doc h1{font-size:23px;color:#02338d;border-bottom:3px solid #02338d;padding-bottom:10px;}
        .doc h3{font-size:16px;color:#02338d;margin-top:24px;}
        .doc .meta{font-size:13px;color:#555;}.doc .content{font-size:15px;line-height:1.7;white-space:pre-wrap;}
        table.f{width:100%;border-collapse:collapse;font-size:12px;margin-top:8px;}
        table.f th{background:#02338d;color:#fff;padding:6px;border:1px solid #24509c;text-align:left;}
        table.f td{padding:5px 6px;border:1px solid #c9d6ea;vertical-align:top;}
        .toolbar{max-width:1000px;margin:0 auto;text-align:right;}
        @media print{body{background:#fff;}.toolbar{display:none;}.doc{box-shadow:none;margin:0;max-width:100%;}}
    </style>
</head><body>
    <div class="toolbar"><a href="iareports.php" class="btn btn-secondary btn-sm">&larr; Back</a>
        <?php if ($rep): ?><button onclick="window.print()" class="btn btn-primary btn-sm">Print / Save PDF</button><?php endif; ?></div>
    <?php if (!$rep): ?><div class="doc"><h1>Report not found</h1></div>
    <?php else: ?>
        <div class="doc">
            <div style="font-size:12px;letter-spacing:1px;color:#888;text-transform:uppercase;">Internal Audit Final Report</div>
            <h1><?= vh($rep['report_title']) ?></h1>
            <div class="meta">
                <b>Engagement:</b> <?= vh($eng['title'] ?? '—') ?> &nbsp;|&nbsp;
                <b>Overall Rating:</b> <?= vh($ratingMap[(int)$rep['overall_rating']] ?? '—') ?> &nbsp;|&nbsp;
                <b>Status:</b> <?= vh($rep['status']) ?> &nbsp;|&nbsp;
                <b>Issued:</b> <?= vh($rep['issued_date'] ?: '—') ?>
                <?= $rep['filename'] ? ' &nbsp;|&nbsp; <b>Attachment:</b> <a href="../' . vh($rep['filename']) . '" target="_blank">file</a>' : '' ?>
            </div>
            <h3>Executive Summary</h3>
            <div class="content"><?= $rep['executive_summary'] ? vh($rep['executive_summary']) : '<em style="color:#999;">No summary captured.</em>' ?></div>
            <h3>Findings &amp; Recommendations</h3>
            <table class="f"><thead><tr><th>#</th><th>Finding</th><th>Rating</th><th>Recommendation</th><th>Responsible</th><th>Target</th><th>Status</th></tr></thead><tbody>
            <?php if (!$findings): ?><tr><td colspan="7" style="text-align:center;color:#888;">No findings.</td></tr><?php else: $n = 1; foreach ($findings as $f): ?>
                <tr><td><?= $n++ ?></td><td><?= vh($f['finding']) ?></td><td><?= vh($ratingMap[(int)$f['rating']] ?? '—') ?></td><td><?= vh($f['recommend'] ?: '—') ?></td><td><?= vh($f['responsible_officer'] ?: '—') ?></td><td><?= vh($f['timeline'] ?: '—') ?></td><td><?= vh($f['status']) ?></td></tr>
            <?php endforeach; endif; ?>
            </tbody></table>
        </div>
    <?php endif; ?>
</body></html>
