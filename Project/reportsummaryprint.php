<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['uid'])) { header('Location:../login.php'); exit; }
require_once __DIR__ . '/engagement/reportingclasses.php';

$id  = (isset($_GET['id']) && ctype_digit((string)$_GET['id'])) ? $_GET['id'] : '';
$rep = $id !== '' ? (new reportSummaryClass())->details($id) : null;
function vh($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
$period = $rep ? (ucfirst($rep['report_type']) . ' ' . (int)$rep['year'] . ($rep['quarter'] ? ' Q' . (int)$rep['quarter'] : '')) : '';
?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $rep ? vh($rep['title']) : 'Report not found' ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <style>
        body{background:#f4f6fb;font-family:'Nunito',Arial,sans-serif;color:#1a1a1a;}
        .doc{max-width:900px;margin:24px auto;background:#fff;padding:44px 50px;box-shadow:0 2px 14px rgba(0,0,0,.08);}
        .doc h1{font-size:23px;color:#02338d;border-bottom:3px solid #02338d;padding-bottom:10px;}
        .doc h3{font-size:16px;color:#02338d;margin-top:24px;}.doc .content{font-size:15px;line-height:1.7;white-space:pre-wrap;}
        .tiles{display:flex;gap:12px;margin-top:12px;}.tile{flex:1;border-radius:8px;padding:14px;text-align:center;color:#fff;}
        .toolbar{max-width:900px;margin:0 auto;text-align:right;}
        @media print{body{background:#fff;}.toolbar{display:none;}.doc{box-shadow:none;margin:0;max-width:100%;}}
    </style>
</head><body>
    <div class="toolbar"><a href="iareports.php" class="btn btn-secondary btn-sm">&larr; Back</a>
        <?php if ($rep): ?><button onclick="window.print()" class="btn btn-primary btn-sm">Print / Save PDF</button><?php endif; ?></div>
    <?php if (!$rep): ?><div class="doc"><h1>Report not found</h1></div>
    <?php else: ?>
        <div class="doc">
            <div style="font-size:12px;letter-spacing:1px;color:#888;text-transform:uppercase;">Internal Audit <?= vh(ucfirst($rep['report_type'])) ?> Report</div>
            <h1><?= vh($rep['title']) ?></h1>
            <div style="font-size:13px;color:#555;"><b>Period:</b> <?= vh($period) ?> &nbsp;|&nbsp; <b>Status:</b> <?= vh($rep['status']) ?>
                <?= $rep['filename'] ? ' &nbsp;|&nbsp; <b>Attachment:</b> <a href="../' . vh($rep['filename']) . '" target="_blank">file</a>' : '' ?></div>
            <div class="tiles">
                <div class="tile" style="background:#198754;"><h3 style="color:#fff;margin:0;"><?= (int)$rep['closed'] ?></h3>Closed</div>
                <div class="tile" style="background:#ffc107;color:#000;"><h3 style="margin:0;"><?= (int)$rep['ongoing'] ?></h3>Ongoing</div>
                <div class="tile" style="background:#dc3545;"><h3 style="color:#fff;margin:0;"><?= (int)$rep['pending'] ?></h3>Pending</div>
            </div>
            <h3>Narrative</h3>
            <div class="content"><?= $rep['narrative'] ? vh($rep['narrative']) : '<em style="color:#999;">No narrative captured.</em>' ?></div>
        </div>
    <?php endif; ?>
</body></html>
