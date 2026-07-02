<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['uid'])) { header('Location:../login.php'); exit; }
require_once __DIR__ . '/iaplan/iastrategicplanClass.php';

$id  = (isset($_GET['id']) && ctype_digit((string)$_GET['id'])) ? $_GET['id'] : '';
$cls = new iastrategicplanClass();
$p   = $id !== '' ? $cls->editDetails($id) : null;
function vh($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
?>
<!DOCTYPE html>
<html lang="en"><head>
    <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $p ? vh($p['title']) : 'Plan not found' ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <style>
        body{background:#f4f6fb;font-family:'Nunito',Arial,sans-serif;color:#1a1a1a;}
        .doc{max-width:900px;margin:24px auto;background:#fff;padding:48px 56px;box-shadow:0 2px 14px rgba(0,0,0,.08);}
        .doc h1{font-size:24px;color:#02338d;border-bottom:3px solid #02338d;padding-bottom:10px;margin-bottom:4px;}
        .doc h3{font-size:16px;color:#02338d;margin-top:26px;}
        .doc .meta{font-size:13px;color:#555;margin-bottom:8px;}
        .doc .content{font-size:15px;line-height:1.7;white-space:pre-wrap;}
        .toolbar{max-width:900px;margin:0 auto;text-align:right;}
        @media print{body{background:#fff;}.toolbar{display:none;}.doc{box-shadow:none;margin:0;max-width:100%;}}
    </style>
</head><body>
    <div class="toolbar">
        <a href="iastrategicplan.php" class="btn btn-secondary btn-sm">&larr; Back</a>
        <?php if ($p): ?><button onclick="window.print()" class="btn btn-primary btn-sm"><i class="fas fa-print"></i> Print / Save PDF</button><?php endif; ?>
    </div>
    <?php if (!$p): ?>
        <div class="doc"><h1>Plan not found</h1></div>
    <?php else: ?>
        <div class="doc">
            <div style="font-size:12px;letter-spacing:1px;color:#888;text-transform:uppercase;">Internal Audit Strategic Plan</div>
            <h1><?= vh($p['title']) ?></h1>
            <div class="meta"><b>Period:</b> <?= (int)$p['period_start_year'] ?> – <?= (int)$p['period_end_year'] ?> &nbsp;|&nbsp; <b>Status:</b> <?= vh($p['status']) ?>
                <?= $p['filename'] ? ' &nbsp;|&nbsp; <b>Document:</b> <a href="../' . vh($p['filename']) . '" target="_blank">Attached file</a>' : '' ?></div>
            <h3>Strategic Objectives</h3>
            <div class="content"><?= vh($p['objectives']) ?></div>
            <?php if (!empty($p['resource_plan'])): ?>
                <h3>Resource Plan</h3>
                <div class="content"><?= vh($p['resource_plan']) ?></div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</body></html>
