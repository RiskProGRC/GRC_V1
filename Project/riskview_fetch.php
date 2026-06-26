<?php
ob_start(); // buffer everything — catches stray PHP warnings before header() is sent

require_once __DIR__ . '/core/AuthGuard.php'; // session gate; sets $uid, $sdid
include_once './connection/connect.php';       // provides $con (mysqli object)

$stray = trim(ob_get_clean()); // collect any output that leaked from the includes

header('Content-Type: application/json'); // must be set before any echo

if ($stray) {
    echo json_encode(['error' => 'Include output: ' . strip_tags($stray)]); // surface leaked HTML as readable error
    exit;
}

$deptid = (int)($_POST['deptid'] ?? 0); // cast to int — safe even without prepared stmt
if (!$deptid) {
    echo json_encode(['error' => 'No department selected']); // early-exit; nothing to query
    exit;
}

if (!$con) {
    echo json_encode(['error' => 'DB connection failed: ' . mysqli_connect_error()]); // surface connect failure
    exit;
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); // convert mysqli failures to catchable Throwable

$out = []; // accumulates all 6 result sets; encoded as one JSON response at the end

try {

    // ── Department info ──────────────────────────────────────────────────────
    // Columns verified: department(dept_name,functions,company,owners)
    //                   company(id,company_name)  users(id,fname,sname)
    $stmt = $con->prepare(
        "SELECT d.dept_name, d.functions, c.company_name,
                CONCAT(u.fname,' ',u.sname) AS owner_name
         FROM department d
         INNER JOIN company c ON d.company = c.id  -- company FK is 'company' not 'company_id'
         INNER JOIN users   u ON d.owners  = u.id  -- owner FK is 'owners' (plural)
         WHERE d.dept_id = ?"
    );
    $stmt->bind_param('i', $deptid); // 'i' = integer type
    $stmt->execute();
    $out['dept'] = $stmt->get_result()->fetch_assoc() ?? []; // single row; null-coalesced to empty array
    $stmt->close(); // free statement before next prepare

    // ── Risks ────────────────────────────────────────────────────────────────
    // Columns verified: risk(risk_id,risk_name,cause,nominee,rdate,reviewer,rcat,dept)
    //                   riskcat(riskcat_id,name)  users(id,fname,sname)
    $stmt = $con->prepare(
        "SELECT r.risk_id, r.risk_name, r.cause, r.nominee, r.rdate,
                rc.name AS category,
                CONCAT(u.fname,' ',u.sname) AS reviewer_name
         FROM risk r
         INNER JOIN riskcat rc ON r.rcat     = rc.riskcat_id
         INNER JOIN users   u  ON r.reviewer = u.id
         WHERE r.dept = ?" // dept FK is 'dept' not 'dept_id' on risk table
    );
    $stmt->bind_param('i', $deptid);
    $stmt->execute();
    $out['risks'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC); // multi-row: returns array of assoc arrays
    $stmt->close();

    // ── Key Indicators ───────────────────────────────────────────────────────
    // Columns verified: ki(id,dept_id,risk_id,ki,owner)
    //                   risk(risk_id,risk_name)  users(id,fname,sname)
    $stmt = $con->prepare(
        "SELECT ki.id, ki.ki, r.risk_id, r.risk_name,
                CONCAT(u.fname,' ',u.sname) AS owner_name
         FROM ki
         INNER JOIN risk  r ON ki.risk_id = r.risk_id
         INNER JOIN users u ON ki.owner   = u.id
         WHERE ki.dept_id = ?
         ORDER BY ki.risk_id ASC" // group KIs by parent risk for readability
    );
    $stmt->bind_param('i', $deptid);
    $stmt->execute();
    $out['ki'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // ── Controls ─────────────────────────────────────────────────────────────
    // Columns verified: control(control_id,dept_id,process_id,controls,cstrength,ctype,reviewer)
    //                   risk_control(control_id,risk_id) — junction table; control has NO direct risk FK
    //                   control_strength(strength_id,cs_name)  control_type(ctype_id,ct_name)
    //                   process(process_id,process_name)  users(id,fname,sname)
    $stmt = $con->prepare(
        "SELECT `control`.control_id, `control`.controls, r.risk_id, r.risk_name,
                p.process_name, cs.cs_name, ct.ct_name,
                CONCAT(u.fname,' ',u.sname) AS reviewer_name
         FROM `control`                                                   -- backticks required: 'control' is a reserved word
         INNER JOIN risk_control     rcl ON `control`.control_id = rcl.control_id -- junction to risk
         INNER JOIN risk             r   ON rcl.risk_id          = r.risk_id
         INNER JOIN control_strength cs  ON `control`.cstrength  = cs.strength_id
         INNER JOIN control_type     ct  ON `control`.ctype      = ct.ctype_id
         INNER JOIN process          p   ON `control`.process_id = p.process_id
         INNER JOIN users            u   ON `control`.reviewer   = u.id
         WHERE `control`.dept_id = ?  -- qualify with table name; process also has dept_id
         ORDER BY r.risk_id ASC"
    );
    $stmt->bind_param('i', $deptid);
    $stmt->execute();
    $out['controls'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // ── Actions ──────────────────────────────────────────────────────────────
    // Columns verified: action(id,process_id,dept_id,risk_id,action,status,priority,timeline)
    //                   risk(risk_id,risk_name)  process(process_id,process_name)
    $stmt = $con->prepare(
        "SELECT a.id, a.action, a.priority, a.status, a.timeline,
                r.risk_id, r.risk_name, p.process_name
         FROM action a
         INNER JOIN risk    r ON a.risk_id    = r.risk_id
         INNER JOIN process p ON a.process_id = p.process_id
         WHERE a.dept_id = ? -- qualify table; process also has dept_id
         ORDER BY a.risk_id ASC"
    );
    $stmt->bind_param('i', $deptid);
    $stmt->execute();
    $out['actions'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    // ── Recommendations ──────────────────────────────────────────────────────
    // Columns verified: recommend(id,dept_id,risk_id,mrc,armc,action,status,timeline)
    //                   'action' column in recommend is an INT FK to action.id (not a text column)
    //                   risk(risk_id,risk_name)
    $stmt = $con->prepare(
        "SELECT rec.id, rec.mrc, rec.armc, rec.status, rec.timeline,
                r.risk_id, r.risk_name, a.action AS action_name
         FROM recommend rec
         INNER JOIN risk r   ON rec.risk_id = r.risk_id
         LEFT  JOIN action a ON rec.action  = a.id -- LEFT JOIN: some recs may not link to an action
         WHERE rec.dept_id = ?
         ORDER BY rec.risk_id ASC"
    );
    $stmt->bind_param('i', $deptid);
    $stmt->execute();
    $out['recommendations'] = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    echo json_encode($out); // all 6 keys: dept, risks, ki, controls, actions, recommendations

} catch (Throwable $e) {
    echo json_encode(['error' => $e->getMessage() . ' (line ' . $e->getLine() . ')']); // surfaces real SQL errors to the UI
}
