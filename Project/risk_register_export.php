<?php
session_start();
include_once './settings/riskcategoryClass.php';
include_once './risk/riskClass.php';
include_once './department/departmentClass.php';
include_once './process/processClass.php';
include_once './control/controlClass.php';
include_once './action/actionClass.php';
include_once './keyindicator/keyindicatorClass.php';

// Check if user is logged in
if (!isset($_SESSION["uid"])) {
    echo "Session expired or user not logged in.";
    exit;
}

// Only process if export flag is set
if (!isset($_POST['export'])) {
    echo "Invalid request.";
    exit;
}

$exportType = $_POST['export']; // 'excel' or 'pdf'

// Initialize classes
$riskClass = new riskClass();
$deptClass = new departmentClass();
$processClass = new processClass();
$riskCatClass = new riskCatClass();

// Helper functions
function getControlEffectivenessLabel($strength) {
    if ($strength >= 4) return 'Effective';
    elseif ($strength >= 3) return 'Moderate';
    elseif ($strength >= 2) return 'Weak';
    else return 'Ineffective';
}

function getRiskLevel($rating) {
    if ($rating >= 16) return 'Very High';
    elseif ($rating >= 12) return 'High';
    elseif ($rating >= 6) return 'Medium';
    elseif ($rating >= 3) return 'Low';
    else return 'Very Low';
}

function getTreatmentStrategy($residualRating) {
    if ($residualRating >= 16) return 'Mitigate/Transfer';
    elseif ($residualRating >= 12) return 'Mitigate';
    elseif ($residualRating >= 6) return 'Monitor';
    else return 'Accept';
}

// Process form data
$topRisks = isset($_POST['topRisks']) ? intval($_POST['topRisks']) : 0;
$initialCriteria = isset($_POST['initialCriteria']) ? $_POST['initialCriteria'] : '1';
$entity = isset($_POST['entity']) ? $_POST['entity'] : '';
$operationalModel = isset($_POST['operationalModel']) ? $_POST['operationalModel'] : '';
$riskCategory = isset($_POST['riskCategory']) ? $_POST['riskCategory'] : '';
$riskType = isset($_POST['riskType']) ? $_POST['riskType'] : '1';

// Extract entity ID from the entity string
$entityId = 0;
if (!empty($entity)) {
    preg_match('/ENT(\d+)/', $entity, $matches);
    if (isset($matches[1])) {
        $entityId = intval($matches[1]);
    }
}

// Build SQL query
$sql = "SELECT DISTINCT
            r.risk_id, 
            r.risk_name, 
            r.cause, 
            d.dept_name as department, 
            p.process_name as process, 
            rc.name as risk_category,
            u.username as risk_owner,
            a.iimp as inherent_impact, 
            a.ilikely as inherent_likelihood, 
            (a.iimp * a.ilikely) as inherent_rating,
            a.rimp as residual_impact, 
            a.rlikely as residual_likelihood, 
            (a.rimp * a.rlikely) as residual_rating,
            a.timp as target_impact, 
            a.tlikely as target_likelihood, 
            (a.timp * a.tlikely) as target_rating,
            r.created_at,
            r.updated_at
        FROM risk r 
        LEFT JOIN department d ON r.dept = d.dept_id 
        LEFT JOIN process p ON r.process = p.process_id 
        LEFT JOIN riskcat rc ON r.rcat = rc.riskcat_id 
        LEFT JOIN assessment a ON r.risk_id = a.risk_id 
        LEFT JOIN users u ON r.uid = u.id
        WHERE r.approval = 2"; // Only approved risks

// Apply filters based on criteria
switch ($initialCriteria) {
    case '2': // Selected Operation Model
        if ($operationalModel !== 'Location' && $operationalModel !== 'Department' && $operationalModel !== 'Process') {
            $sql .= " AND r.process = " . intval($operationalModel);
        }
        break;
    case '3': // Selected Entity
        if ($entityId > 0) {
            $sql .= " AND r.dept = " . $entityId;
        }
        break;
    case '4': // Selected Risk Category
        if (!empty($riskCategory)) {
            $sql .= " AND r.rcat = " . intval($riskCategory);
        }
        break;
}

// Order by risk assessment value based on selected type
if ($riskType == '1') { // Residual
    $sql .= " ORDER BY (a.rimp * a.rlikely) DESC";
} elseif ($riskType == '2') { // Inherent
    $sql .= " ORDER BY (a.iimp * a.ilikely) DESC";
} else { // Target
    $sql .= " ORDER BY (a.timp * a.tlikely) DESC";
}

// Limit results if top N risks requested
if ($topRisks > 0) {
    $sql .= " LIMIT " . $topRisks;
}

// Execute query
$risks = array();
try {
    $con = new connectionClass();
    $result = $con->query($sql) or die($con->error);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Get additional data for each risk
            $riskId = $row['risk_id'];

            // Get controls for this risk
            $controlSql = "SELECT GROUP_CONCAT(c.control SEPARATOR '; ') as controls,
                          COUNT(c.control_id) as control_count
                          FROM risk_control rc
                          INNER JOIN control c ON rc.control_id = c.control_id
                          WHERE rc.risk_id = $riskId AND rc.status = 1";
            $controlResult = $con->query($controlSql);
            $controlData = $controlResult->fetch_assoc();

            // Get actions for this risk
            $actionSql = "SELECT GROUP_CONCAT(
                            CONCAT(a.action, ' (Priority: ', COALESCE(a.priority, 'Medium'), ', Timeline: ', COALESCE(a.timeline, 'TBD'), ')') 
                            SEPARATOR '; '
                          ) as actions
                          FROM action a 
                          WHERE a.risk_id = $riskId";
            $actionResult = $con->query($actionSql);
            $actionData = $actionResult->fetch_assoc();

            // Get KRIs for this risk
            $kriSql = "SELECT GROUP_CONCAT(ki.ki SEPARATOR '; ') as kris
                      FROM ki
                      WHERE ki.risk_id = $riskId";
            $kriResult = $con->query($kriSql);
            $kriData = $kriResult->fetch_assoc();

            // Add additional data to risk row
            $row['existing_controls'] = $controlData['controls'] ?? 'To be defined';
            $row['control_effectiveness'] = getControlEffectivenessLabel($controlData['control_count'] ?? 0);
            $row['action_plan'] = $actionData['actions'] ?? 'Risk assessment and mitigation plan to be developed';
            $row['kri'] = $kriData['kris'] ?? 'Key performance indicators to be established';

            $risks[] = $row;
        }
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit;
}

// Get criteria labels for report header
$criteriaLabel = '';
switch ($initialCriteria) {
    case '1':
        $criteriaLabel = 'All Risks';
        break;
    case '2':
        if ($operationalModel === 'Location' || $operationalModel === 'Department' || $operationalModel === 'Process') {
            $criteriaLabel = 'Operational Model: ' . $operationalModel;
        } else {
            $processName = '';
            $processes = $processClass->showProcess();
            if (is_array($processes)) {
                foreach ($processes as $process) {
                    if ($process['process_id'] == $operationalModel) {
                        $processName = $process['process_name'];
                        break;
                    }
                }
            }
            $criteriaLabel = 'Process: ' . $processName;
        }
        break;
    case '3':
        $criteriaLabel = 'Entity: ' . $entity;
        break;
    case '4':
        $criteriaLabel = 'Risk Category: ' . $riskCategory;
        break;
}

$riskTypeLabel = '';
switch ($riskType) {
    case '1':
        $riskTypeLabel = 'Residual Risk';
        break;
    case '2':
        $riskTypeLabel = 'Inherent Risk';
        break;
    case '3':
        $riskTypeLabel = 'Target Risk';
        break;
}

// Generate export based on type
if ($exportType === 'excel') {
    generateExcelReport($risks, $criteriaLabel, $riskTypeLabel);
} elseif ($exportType === 'pdf') {
    generatePDFReport($risks, $criteriaLabel, $riskTypeLabel);
}

function generateExcelReport($risks, $criteriaLabel, $riskTypeLabel) {
    // Create filename with timestamp
    $filename = 'Risk_Register_' . date('Y-m-d_H-i-s') . '.xls';

    // Set headers for Excel download
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    // Create Excel content
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Risk Register Report</title>
        <style>
            body { font-family: Arial, sans-serif; font-size: 10px; }
            table { border-collapse: collapse; width: 100%; }
            th, td { border: 1px solid #000; padding: 4px; vertical-align: top; }
            th { background-color: #4472C4; color: white; font-weight: bold; text-align: center; }
            .report-header { font-size: 16px; font-weight: bold; margin-bottom: 10px; color: #4472C4; }
            .report-subheader { font-size: 12px; margin-bottom: 15px; }
            .very-high-risk { background-color: #C5504B; color: white; font-weight: bold; }
            .high-risk { background-color: #E7B416; color: white; font-weight: bold; }
            .medium-risk { background-color: #70AD47; color: white; font-weight: bold; }
            .low-risk { background-color: #5B9BD5; color: white; font-weight: bold; }
            .very-low-risk { background-color: #A5A5A5; color: white; font-weight: bold; }
            .text-center { text-align: center; }
            .wrap-text { white-space: normal; word-wrap: break-word; }
        </style>
    </head>
    <body>
        <div class="report-header">STRATHMORE UNIVERSITY</div>
        <div class="report-header">COMPREHENSIVE RISK REGISTER</div>
        <div class="report-subheader">
            <strong>Criteria:</strong> ' . htmlspecialchars($criteriaLabel) . '<br>
            <strong>Risk Type:</strong> ' . htmlspecialchars($riskTypeLabel) . '<br>
            <strong>Generated:</strong> ' . date('Y-m-d H:i:s') . '<br>
            <strong>Total Risks:</strong> ' . count($risks) . '
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Risk ID</th>
                    <th>Key Process</th>                                                        
                    <th>Risk Description</th>                                                        
                    <th>Cause of Risk</th>
                    <th>Consequence</th>
                    <th>Risk Category</th>
                    <th>Risk Owner</th>
                    <th>Inherent Likelihood</th>
                    <th>Inherent Impact</th>
                    <th>Inherent Rating</th>
                    <th>Existing Controls</th>
                    <th>Control Effectiveness</th>
                    <th>Control Owner</th>
                    <th>Residual Likelihood</th>
                    <th>Residual Impact</th>
                    <th>Residual Rating</th>
                    <th>Risk Appetite Level</th>
                    <th>Treatment Strategy</th>
                    <th>Action Plan</th>
                    <th>Action Owner</th>
                    <th>Action Target Date</th>
                    <th>Status</th>
                    <th>KPI</th>
                    <th>KRI</th>
                    <th>Review Frequency</th>
                    <th>Last Review Date</th>
                    <th>Next Review Date</th>
                    <th>Notes/Comments</th>
                </tr>
            </thead>
            <tbody>';

    // Add data rows
    foreach ($risks as $risk) {
        // Get risk rating classes
        $inherentClass = '';
        $residualClass = '';

        if($risk['inherent_rating'] >= 20) $inherentClass = 'very-high-risk';
        elseif($risk['inherent_rating'] >= 16) $inherentClass = 'high-risk';
        elseif($risk['inherent_rating'] >= 12) $inherentClass = 'medium-risk';
        elseif($risk['inherent_rating'] >= 6) $inherentClass = 'low-risk';
        else $inherentClass = 'very-low-risk';

        if($risk['residual_rating'] >= 20) $residualClass = 'very-high-risk';
        elseif($risk['residual_rating'] >= 16) $residualClass = 'high-risk';
        elseif($risk['residual_rating'] >= 12) $residualClass = 'medium-risk';
        elseif($risk['residual_rating'] >= 6) $residualClass = 'low-risk';
        else $residualClass = 'very-low-risk';

        echo '<tr>
            <td class="text-center">RSK-' . str_pad($risk['risk_id'], 3, '0', STR_PAD_LEFT) . '</td>
            <td class="wrap-text">' . htmlspecialchars($risk['process']) . '</td>
            <td class="wrap-text">' . htmlspecialchars($risk['risk_name']) . '</td>
            <td class="wrap-text">' . htmlspecialchars($risk['cause']) . '</td>            
            <td class="wrap-text">' . htmlspecialchars("Potential operational, financial, and reputational impact on " . $risk['department']) . '</td>
            <td>' . htmlspecialchars($risk['risk_category']) . '</td>
            <td>' . htmlspecialchars($risk['risk_owner'] ?? $risk['department']) . '</td>
            <td class="text-center">' . $risk['inherent_likelihood'] . '</td>
            <td class="text-center">' . $risk['inherent_impact'] . '</td>
            <td class="text-center ' . $inherentClass . '">' . $risk['inherent_rating'] . '</td>
            <td class="wrap-text">' . htmlspecialchars($risk['existing_controls']) . '</td>
            <td class="text-center">' . $risk['control_effectiveness'] . '</td>
            <td class="text-center">' . $risk['risk_owner'] . '</td>
            <td class="text-center">' . $risk['residual_likelihood'] . '</td>
            <td class="text-center">' . $risk['residual_impact'] . '</td>
            <td class="text-center ' . $residualClass . '">' . $risk['residual_rating'] . '</td>
            <td class="text-center">' . getRiskLevel($risk['residual_rating']) . '</td>
            <td class="text-center">' . getTreatmentStrategy($risk['residual_rating']) . '</td>
            <td class="wrap-text">' . htmlspecialchars($risk['action_plan']) . '</td>
            <td>' . htmlspecialchars($risk['risk_owner'] ?? $risk['department']) . '</td>
            <td class="text-center">' . date('Y-m-d', strtotime('+6 months')) . '</td>
            <td class="text-center"></td>
            <td class="wrap-text"></td>
            <td class="wrap-text"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td class="text-center"></td>
            <td></td>
        </tr>';
    }

    echo '</tbody>
        </table>
        
        <div style="margin-top: 20px; font-size: 10px;">
            <h4>Risk Rating Legend:</h4>
            <table style="width: 400px;">
                <tr>
                    <td class="very-high-risk text-center" style="width: 80px;">20-25</td>
                    <td>Very High Risk</td>
                </tr>
                <tr>
                    <td class="high-risk text-center">16-19</td>
                    <td>High Risk</td>
                </tr>
                <tr>
                    <td class="medium-risk text-center">12-15</td>
                    <td>Medium Risk</td>
                </tr>
                <tr>
                    <td class="low-risk text-center">6-11</td>
                    <td>Low Risk</td>
                </tr>
                <tr>
                    <td class="very-low-risk text-center">1-5</td>
                    <td>Very Low Risk</td>
                </tr>
            </table>
        </div>
    </body>
    </html>';
    exit;
}

function generatePDFReport($risks, $criteriaLabel, $riskTypeLabel) {
    // Simple HTML to PDF approach
    $filename = 'Risk_Register_' . date('Y-m-d_H-i-s') . '.pdf';

    // Set headers for PDF
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');

    // For now, output HTML that can be printed to PDF
    echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>Risk Register Report</title>
        <style>
            @page { margin: 1cm; size: A4 landscape; }
            body { font-family: Arial, sans-serif; font-size: 8px; margin: 0; }
            table { border-collapse: collapse; width: 100%; margin-top: 10px; }
            th, td { border: 1px solid #000; padding: 2px; vertical-align: top; }
            th { background-color: #4472C4; color: white; font-weight: bold; }
            .header { text-align: center; margin-bottom: 10px; }
            .header h1 { margin: 5px 0; color: #4472C4; }
            .info { margin-bottom: 10px; font-size: 9px; }
            .high-risk { background-color: #ffcccc; }
            .medium-risk { background-color: #ffffcc; }
            .low-risk { background-color: #ccffcc; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>STRATHMORE UNIVERSITY</h1>
            <h2>RISK REGISTER REPORT</h2>
        </div>
        
        <div class="info">
            <strong>Criteria:</strong> ' . htmlspecialchars($criteriaLabel) . ' | 
            <strong>Risk Type:</strong> ' . htmlspecialchars($riskTypeLabel) . ' | 
            <strong>Generated:</strong> ' . date('Y-m-d H:i:s') . ' | 
            <strong>Total Risks:</strong> ' . count($risks) . '
        </div>';

    // Create simplified table for PDF
    echo '<table>
        <thead>
            <tr>
                <th style="width: 60px;">Risk ID</th>
                <th style="width: 80px;">Category</th>
                <th style="width: 200px;">Risk Description</th>
                <th style="width: 80px;">Owner</th>
                <th style="width: 150px;">Cause</th>
                <th style="width: 40px;">I.L</th>
                <th style="width: 40px;">I.I</th>
                <th style="width: 40px;">I.R</th>
                <th style="width: 150px;">Controls</th>
                <th style="width: 40px;">R.L</th>
                <th style="width: 40px;">R.I</th>
                <th style="width: 40px;">R.R</th>
                <th style="width: 80px;">Strategy</th>
            </tr>
        </thead>
        <tbody>';

    foreach ($risks as $risk) {
        $riskClass = '';
        if($risk['residual_rating'] >= 16) $riskClass = 'high-risk';
        elseif($risk['residual_rating'] >= 12) $riskClass = 'medium-risk';
        elseif($risk['residual_rating'] >= 6) $riskClass = 'low-risk';

        echo '<tr>
            <td>RSK-' . str_pad($risk['risk_id'], 3, '0', STR_PAD_LEFT) . '</td>
            <td>' . htmlspecialchars(substr($risk['risk_category'], 0, 15)) . '</td>
            <td>' . htmlspecialchars(substr($risk['risk_name'], 0, 100)) . '</td>
            <td>' . htmlspecialchars(substr($risk['department'], 0, 15)) . '</td>
            <td>' . htmlspecialchars(substr($risk['cause'], 0, 80)) . '</td>
            <td style="text-align: center;">' . $risk['inherent_likelihood'] . '</td>
            <td style="text-align: center;">' . $risk['inherent_impact'] . '</td>
            <td style="text-align: center;">' . $risk['inherent_rating'] . '</td>
            <td>' . htmlspecialchars(substr($risk['existing_controls'], 0, 80)) . '</td>
            <td style="text-align: center;">' . $risk['residual_likelihood'] . '</td>
            <td style="text-align: center;">' . $risk['residual_impact'] . '</td>
            <td style="text-align: center;" class="' . $riskClass . '">' . $risk['residual_rating'] . '</td>
            <td>' . getTreatmentStrategy($risk['residual_rating']) . '</td>
        </tr>';
    }

    echo '</tbody>
    </table>
    
    <div style="margin-top: 20px;">
        <p><strong>Legend:</strong> I.L = Inherent Likelihood, I.I = Inherent Impact, I.R = Inherent Rating, R.L = Residual Likelihood, R.I = Residual Impact, R.R = Residual Rating</p>
    </div>
    
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
    </body>
    </html>';
    exit;
}
?>