<?php
session_start();
if (!isset($_SESSION['user']) || !isset($_SESSION['uid'])) {   // standalone page — guard auth directly
    header('Location:../login.php');
    exit;
}
require_once __DIR__ . '/iacharter/iacharterClass.php';         // __DIR__ — cwd-independent (standalone view)

$id = (isset($_GET['id']) && ctype_digit((string)$_GET['id'])) ? $_GET['id'] : '';
$charterclass = new iacharterClass();
$c = $id !== '' ? $charterclass->editDetails($id) : null;

function vh($v): string { return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8'); }
$typeLabel = $c ? ($c['charter_type'] === 'audit_committee' ? 'Audit Committee Charter' : 'Internal Audit Charter') : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $c ? vh($c['title']) : 'Charter not found' ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.css">
    <style>
        body { background:#f4f6fb; font-family:'Nunito',Arial,sans-serif; color:#1a1a1a; }
        .doc { max-width:900px; margin:24px auto; background:#fff; padding:48px 56px; box-shadow:0 2px 14px rgba(0,0,0,.08); }
        .doc h1 { font-size:24px; color:#02338d; border-bottom:3px solid #02338d; padding-bottom:10px; margin-bottom:4px; }
        .doc .meta { font-size:13px; color:#555; margin-bottom:24px; }
        .doc .meta table td { padding:3px 10px 3px 0; }
        .doc .meta td:first-child { font-weight:700; color:#333; white-space:nowrap; }
        .doc .content { font-size:15px; line-height:1.7; white-space:pre-wrap; }
        .doc .badge-status { display:inline-block; padding:2px 10px; border-radius:12px; background:#e7f0ff; color:#02338d; font-weight:700; font-size:12px; }
        .toolbar { max-width:900px; margin:0 auto; text-align:right; }
        @media print { body { background:#fff; } .toolbar { display:none; } .doc { box-shadow:none; margin:0; max-width:100%; } }
    </style>
</head>
<body>
    <div class="toolbar">
        <a href="iacharter.php" class="btn btn-secondary btn-sm">&larr; Back</a>
        <?php if ($c): ?><button onclick="window.print()" class="btn btn-primary btn-sm"><i class="fas fa-print"></i> Print / Save PDF</button><?php endif; ?>
    </div>

    <?php if (!$c): ?>
        <div class="doc"><h1>Charter not found</h1><p>The requested charter does not exist.</p></div>
    <?php else: ?>
        <div class="doc">
            <div style="font-size:12px;letter-spacing:1px;color:#888;text-transform:uppercase;"><?= vh($typeLabel) ?></div>
            <h1><?= vh($c['title']) ?></h1>
            <div class="meta">
                <table>
                    <tr><td>Version</td><td><?= $c['version'] ? vh($c['version']) : '—' ?></td>
                        <td>Status</td><td><span class="badge-status"><?= vh($c['status']) ?></span></td></tr>
                    <tr><td>Approved By</td><td><?= $c['approved_by'] ? vh($c['approved_by']) : '—' ?></td>
                        <td>Approved Date</td><td><?= $c['approved_date'] ? vh($c['approved_date']) : '—' ?></td></tr>
                    <tr><td>Next Review</td><td><?= $c['review_date'] ? vh($c['review_date']) : '—' ?></td>
                        <td>Document</td><td><?= $c['filename'] ? '<a href="../' . vh($c['filename']) . '" target="_blank">Attached file</a>' : '—' ?></td></tr>
                </table>
            </div>
            <div class="content"><?= $c['content'] ? vh($c['content']) : '<em style="color:#999;">No charter body captured. Attach a signed document or add content via Edit.</em>' ?></div>
        </div>
    <?php endif; ?>
</body>
</html>
