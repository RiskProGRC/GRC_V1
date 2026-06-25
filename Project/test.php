<?php
// ─── Process form submission ───────────────────────────────────────────────
$result = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $planned   = floatval($_POST['planned']   ?? 0);
    $actual    = floatval($_POST['actual']    ?? 0);
    $budget    = floatval($_POST['budget']    ?? 0);
    $spent     = floatval($_POST['spent']     ?? 0);
    $tasks     = intval($_POST['tasks']       ?? 0);
    $completed = intval($_POST['completed']   ?? 0);

    // ── Schedule Performance ──────────────────────────────────────────────
    $schedule_variance = $planned > 0 ? (($actual - $planned) / $planned) * 100 : 0;
    if ($schedule_variance <= 5)       { $sched_status = 'green';  $sched_label = 'On Track'; }
    elseif ($schedule_variance <= 15)  { $sched_status = 'yellow'; $sched_label = 'At Risk'; }
    else                               { $sched_status = 'red';    $sched_label = 'Off Track'; }

    // ── Budget Performance ────────────────────────────────────────────────
    $budget_variance = $budget > 0 ? (($spent - $budget) / $budget) * 100 : 0;
    if ($budget_variance <= 5)         { $budget_status = 'green';  $budget_label = 'Within Budget'; }
    elseif ($budget_variance <= 15)    { $budget_status = 'yellow'; $budget_label = 'Nearing Limit'; }
    else                               { $budget_status = 'red';    $budget_label = 'Over Budget'; }

    // ── Task Completion ───────────────────────────────────────────────────
    $completion_pct = $tasks > 0 ? ($completed / $tasks) * 100 : 0;
    if ($completion_pct >= 80)         { $task_status = 'green';  $task_label = 'Excellent'; }
    elseif ($completion_pct >= 50)     { $task_status = 'yellow'; $task_label = 'In Progress'; }
    else                               { $task_status = 'red';    $task_label = 'Behind'; }

    // ── Overall RAG Status ────────────────────────────────────────────────
    $scores = ['green' => 0, 'yellow' => 1, 'red' => 2];
    $overall_score = $scores[$sched_status] + $scores[$budget_status] + $scores[$task_status];
    if ($overall_score <= 1)      { $overall = 'green';  $overall_label = 'Project Healthy'; }
    elseif ($overall_score <= 3)  { $overall = 'yellow'; $overall_label = 'Needs Attention'; }
    else                          { $overall = 'red';    $overall_label = 'Critical Risk'; }

    $result = compact(
        'planned','actual','budget','spent','tasks','completed',
        'schedule_variance','budget_variance','completion_pct',
        'sched_status','sched_label',
        'budget_status','budget_label',
        'task_status','task_label',
        'overall','overall_label'
    );
}

// ─── Helpers ───────────────────────────────────────────────────────────────
function rag_hex($status) {
    return match($status) {
        'green'  => '#22c55e',
        'yellow' => '#eab308',
        'red'    => '#ef4444',
        default  => '#6b7280',
    };
}
function rag_bg($status) {
    return match($status) {
        'green'  => 'rgba(34,197,94,0.12)',
        'yellow' => 'rgba(234,179,8,0.12)',
        'red'    => 'rgba(239,68,68,0.12)',
        default  => 'rgba(107,114,128,0.1)',
    };
}
function rag_icon($status) {
    return match($status) {
        'green'  => '✓',
        'yellow' => '⚠',
        'red'    => '✕',
        default  => '?',
    };
}
function val($key, $default = '') {
    return htmlspecialchars($_POST[$key] ?? $default);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Project RAG Calculator</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=Syne:wght@400;600;800&display=swap" rel="stylesheet">
<style>
  /* ── Reset & Base ─────────────────────────────────────────────── */
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg:      #0d0f14;
    --surface: #141720;
    --border:  #1e2330;
    --text:    #e2e8f0;
    --muted:   #64748b;
    --accent:  #818cf8;
    --green:   #22c55e;
    --yellow:  #eab308;
    --red:     #ef4444;
    --radius:  12px;
    --font-mono: 'Space Mono', monospace;
    --font-head: 'Syne', sans-serif;
  }

  body {
    background: var(--bg);
    color: var(--text);
    font-family: var(--font-mono);
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2.5rem 1rem 4rem;
  }

  /* ── Grid noise overlay ───────────────────────────────────────── */
  body::before {
    content: '';
    position: fixed; inset: 0;
    background-image:
      linear-gradient(rgba(255,255,255,.015) 1px, transparent 1px),
      linear-gradient(90deg, rgba(255,255,255,.015) 1px, transparent 1px);
    background-size: 32px 32px;
    pointer-events: none;
    z-index: 0;
  }

  .page { position: relative; z-index: 1; width: 100%; max-width: 760px; }

  /* ── Header ───────────────────────────────────────────────────── */
  header {
    text-align: center;
    margin-bottom: 2.5rem;
  }
  .eyebrow {
    font-family: var(--font-mono);
    font-size: .7rem;
    letter-spacing: .2em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: .6rem;
  }
  h1 {
    font-family: var(--font-head);
    font-size: clamp(1.8rem, 5vw, 2.8rem);
    font-weight: 800;
    letter-spacing: -.02em;
    line-height: 1.1;
    background: linear-gradient(135deg, #e2e8f0 30%, var(--accent));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
  }
  .subtitle {
    margin-top: .5rem;
    color: var(--muted);
    font-size: .8rem;
  }

  /* ── Card ─────────────────────────────────────────────────────── */
  .card {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    padding: 2rem;
    margin-bottom: 1.5rem;
  }

  .card-title {
    font-family: var(--font-head);
    font-size: .75rem;
    font-weight: 600;
    letter-spacing: .15em;
    text-transform: uppercase;
    color: var(--accent);
    margin-bottom: 1.4rem;
    padding-bottom: .6rem;
    border-bottom: 1px solid var(--border);
  }

  /* ── Form grid ────────────────────────────────────────────────── */
  .input-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem 1.5rem;
  }
  @media (max-width: 520px) { .input-grid { grid-template-columns: 1fr; } }

  .field { display: flex; flex-direction: column; gap: .4rem; }

  label {
    font-size: .7rem;
    letter-spacing: .1em;
    text-transform: uppercase;
    color: var(--muted);
  }

  input[type="number"] {
    background: var(--bg);
    border: 1px solid var(--border);
    border-radius: 8px;
    color: var(--text);
    font-family: var(--font-mono);
    font-size: .9rem;
    padding: .65rem .9rem;
    width: 100%;
    transition: border-color .2s, box-shadow .2s;
    outline: none;
    -moz-appearance: textfield;
  }
  input[type="number"]::-webkit-inner-spin-button,
  input[type="number"]::-webkit-outer-spin-button { -webkit-appearance: none; }
  input[type="number"]:focus {
    border-color: var(--accent);
    box-shadow: 0 0 0 3px rgba(129,140,248,.15);
  }

  /* ── Submit ───────────────────────────────────────────────────── */
  .btn-wrap { margin-top: 1.6rem; text-align: center; }
  button[type="submit"] {
    background: var(--accent);
    color: #0d0f14;
    border: none;
    border-radius: 8px;
    font-family: var(--font-head);
    font-size: .9rem;
    font-weight: 700;
    letter-spacing: .05em;
    padding: .8rem 2.4rem;
    cursor: pointer;
    transition: opacity .2s, transform .15s;
  }
  button[type="submit"]:hover { opacity: .9; transform: translateY(-1px); }

  /* ── Results ──────────────────────────────────────────────────── */
  .results { animation: fadeUp .4s ease both; }
  @keyframes fadeUp {
    from { opacity: 0; transform: translateY(16px); }
    to   { opacity: 1; transform: translateY(0); }
  }

  /* ── Overall banner ───────────────────────────────────────────── */
  .overall-banner {
    border-radius: var(--radius);
    padding: 1.6rem 2rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.2rem;
    border: 1px solid;
  }
  .overall-dot {
    width: 56px; height: 56px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.6rem;
    font-weight: 700;
    flex-shrink: 0;
  }
  .overall-text .label {
    font-family: var(--font-head);
    font-size: 1.2rem;
    font-weight: 800;
  }
  .overall-text .sub { font-size: .75rem; color: var(--muted); margin-top: .2rem; }

  /* ── KPI Cards ────────────────────────────────────────────────── */
  .kpi-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1.5rem;
  }
  @media (max-width: 540px) { .kpi-grid { grid-template-columns: 1fr; } }

  .kpi {
    background: var(--surface);
    border-radius: var(--radius);
    padding: 1.2rem 1rem 1rem;
    border: 1px solid var(--border);
    position: relative;
    overflow: hidden;
    text-align: center;
  }
  .kpi::before {
    content: '';
    position: absolute; top: 0; left: 0; right: 0;
    height: 3px;
  }
  .kpi .kpi-icon {
    width: 36px; height: 36px;
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 1rem;
    font-weight: 700;
    margin: 0 auto .6rem;
  }
  .kpi .kpi-name {
    font-size: .65rem;
    letter-spacing: .12em;
    text-transform: uppercase;
    color: var(--muted);
    margin-bottom: .3rem;
  }
  .kpi .kpi-value {
    font-family: var(--font-head);
    font-size: 1.5rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: .3rem;
  }
  .kpi .kpi-badge {
    display: inline-block;
    font-size: .65rem;
    letter-spacing: .08em;
    text-transform: uppercase;
    font-weight: 700;
    padding: .2em .6em;
    border-radius: 999px;
  }

  /* ── Detail table ─────────────────────────────────────────────── */
  .detail-table { width: 100%; border-collapse: collapse; font-size: .82rem; }
  .detail-table td { padding: .55rem .4rem; border-bottom: 1px solid var(--border); }
  .detail-table td:first-child { color: var(--muted); }
  .detail-table td:last-child { text-align: right; font-weight: 700; }
  .detail-table tr:last-child td { border-bottom: none; }

  /* ── Legend ───────────────────────────────────────────────────── */
  .legend {
    display: flex;
    gap: 1.2rem;
    justify-content: center;
    margin-top: .2rem;
    font-size: .7rem;
    color: var(--muted);
    flex-wrap: wrap;
  }
  .legend span { display: flex; align-items: center; gap: .4rem; }
  .legend .dot { width: 9px; height: 9px; border-radius: 50%; }
</style>
</head>
<body>
<div class="page">

  <!-- Header -->
  <header>
    <p class="eyebrow">Project Management</p>
    <h1>RAG Range Calculator</h1>
    <p class="subtitle">Red · Amber · Green status across schedule, budget &amp; tasks</p>
  </header>

  <!-- Input Form -->
  <div class="card">
    <p class="card-title">Project Inputs</p>
    <form method="POST" action="">
      <div class="input-grid">

        <div class="field">
          <label for="planned">Planned Days</label>
          <input type="number" id="planned" name="planned" min="0" step="any"
                 value="<?= val('planned','30') ?>" placeholder="e.g. 30">
        </div>
        <div class="field">
          <label for="actual">Actual Days Taken</label>
          <input type="number" id="actual" name="actual" min="0" step="any"
                 value="<?= val('actual','35') ?>" placeholder="e.g. 35">
        </div>

        <div class="field">
          <label for="budget">Total Budget ($)</label>
          <input type="number" id="budget" name="budget" min="0" step="any"
                 value="<?= val('budget','50000') ?>" placeholder="e.g. 50000">
        </div>
        <div class="field">
          <label for="spent">Amount Spent ($)</label>
          <input type="number" id="spent" name="spent" min="0" step="any"
                 value="<?= val('spent','58000') ?>" placeholder="e.g. 58000">
        </div>

        <div class="field">
          <label for="tasks">Total Tasks</label>
          <input type="number" id="tasks" name="tasks" min="0" step="1"
                 value="<?= val('tasks','40') ?>" placeholder="e.g. 40">
        </div>
        <div class="field">
          <label for="completed">Completed Tasks</label>
          <input type="number" id="completed" name="completed" min="0" step="1"
                 value="<?= val('completed','28') ?>" placeholder="e.g. 28">
        </div>

      </div>
      <div class="btn-wrap">
        <button type="submit">Calculate Status →</button>
      </div>
    </form>
  </div>

<?php if ($result): ?>
<?php
  $oc  = rag_hex($result['overall']);
  $obg = rag_bg($result['overall']);
?>
  <!-- Results -->
  <div class="results">

    <!-- Overall Banner -->
    <div class="overall-banner"
         style="background:<?= $obg ?>; border-color:<?= $oc ?>;">
      <div class="overall-dot"
           style="background:<?= $oc ?>; color:#0d0f14;">
        <?= rag_icon($result['overall']) ?>
      </div>
      <div class="overall-text">
        <div class="label" style="color:<?= $oc ?>">
          <?= htmlspecialchars($result['overall_label']) ?>
        </div>
        <div class="sub">Overall project RAG status based on all three dimensions</div>
      </div>
    </div>

    <!-- KPI Cards -->
    <div class="kpi-grid">

      <?php
        $kpis = [
          [
            'name'   => 'Schedule',
            'value'  => sprintf('%+.1f%%', $result['schedule_variance']),
            'badge'  => $result['sched_label'],
            'status' => $result['sched_status'],
          ],
          [
            'name'   => 'Budget',
            'value'  => sprintf('%+.1f%%', $result['budget_variance']),
            'badge'  => $result['budget_label'],
            'status' => $result['budget_status'],
          ],
          [
            'name'   => 'Completion',
            'value'  => sprintf('%.0f%%', $result['completion_pct']),
            'badge'  => $result['task_label'],
            'status' => $result['task_status'],
          ],
        ];
        foreach ($kpis as $k):
          $c  = rag_hex($k['status']);
          $bg = rag_bg($k['status']);
      ?>
      <div class="kpi" style="background:<?= $bg ?>;">
        <div style="position:absolute;top:0;left:0;right:0;height:3px;background:<?= $c ?>"></div>
        <div class="kpi-icon" style="background:<?= $c ?>; color:#0d0f14;">
          <?= rag_icon($k['status']) ?>
        </div>
        <div class="kpi-name"><?= $k['name'] ?></div>
        <div class="kpi-value" style="color:<?= $c ?>"><?= $k['value'] ?></div>
        <span class="kpi-badge"
              style="background:<?= $c ?>22; color:<?= $c ?>;">
          <?= htmlspecialchars($k['badge']) ?>
        </span>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Breakdown Detail -->
    <div class="card">
      <p class="card-title">Breakdown Detail</p>
      <table class="detail-table">
        <tr>
          <td>Planned days</td>
          <td><?= number_format($result['planned'], 1) ?></td>
        </tr>
        <tr>
          <td>Actual days</td>
          <td><?= number_format($result['actual'], 1) ?></td>
        </tr>
        <tr>
          <td>Schedule variance</td>
          <td style="color:<?= rag_hex($result['sched_status']) ?>">
            <?= sprintf('%+.2f%%', $result['schedule_variance']) ?>
          </td>
        </tr>
        <tr>
          <td>Total budget</td>
          <td>$<?= number_format($result['budget'], 2) ?></td>
        </tr>
        <tr>
          <td>Amount spent</td>
          <td>$<?= number_format($result['spent'], 2) ?></td>
        </tr>
        <tr>
          <td>Budget variance</td>
          <td style="color:<?= rag_hex($result['budget_status']) ?>">
            <?= sprintf('%+.2f%%', $result['budget_variance']) ?>
          </td>
        </tr>
        <tr>
          <td>Total tasks</td>
          <td><?= $result['tasks'] ?></td>
        </tr>
        <tr>
          <td>Completed tasks</td>
          <td><?= $result['completed'] ?></td>
        </tr>
        <tr>
          <td>Completion rate</td>
          <td style="color:<?= rag_hex($result['task_status']) ?>">
            <?= sprintf('%.1f%%', $result['completion_pct']) ?>
          </td>
        </tr>
      </table>
    </div>

    <!-- Legend -->
    <div class="legend">
      <span>
        <span class="dot" style="background:var(--green)"></span>Green ≤ 5% variance / ≥ 80% done
      </span>
      <span>
        <span class="dot" style="background:var(--yellow)"></span>Yellow ≤ 15% variance / ≥ 50% done
      </span>
      <span>
        <span class="dot" style="background:var(--red)"></span>Red &gt; 15% variance / &lt; 50% done
      </span>
    </div>

  </div>
<?php endif; ?>

</div>
</body>
</html>
