<?php
session_start();
include_once './settings/riskcategoryClass.php';
include_once './risk/riskClass.php';
include_once './department/departmentClass.php';
include_once './process/processClass.php';

// Check if user is logged in
if (!isset($_SESSION["uid"])) {
    echo "Session expired or user not logged in.";
    exit;
}

// Only process if export flag is set
if (!isset($_POST['export']) || $_POST['export'] != '1') {
    echo "Invalid request.";
    exit;
}

// Initialize classes
$riskClass = new riskClass();
$deptClass = new departmentClass();
$processClass = new processClass();
$riskCatClass = new riskCatClass();

// Process form data
$topRisks = isset($_POST['topRisks']) ? intval($_POST['topRisks']) : 0;
$initialCriteria = isset($_POST['initialCriteria']) ? $_POST['initialCriteria'] : '1';
$entity = isset($_POST['entity']) ? $_POST['entity'] : '';
$operationalModel = isset($_POST['operationalModel']) ? $_POST['operationalModel'] : '';
$riskType = isset($_POST['riskType']) ? $_POST['riskType'] : '1';

// Extract entity ID from the entity string (format: "ENT00020 Group Co")
$entityId = 0;
if (!empty($entity)) {
    preg_match('/ENT(\d+)/', $entity, $matches);
    if (isset($matches[1])) {
        $entityId = intval($matches[1]);
    }
}

// Build SQL query based on criteria
$sql = "SELECT r.risk_id, r.risk_name, r.cause, d.dept_name as department, 
        p.process_name as process, rc.name as risk_category, 
        a.iimp, a.ilikely, a.rimp, a.rlikely, a.timp, a.tlikely 
        FROM risk r 
        LEFT JOIN department d ON r.dept = d.dept_id 
        LEFT JOIN process p ON r.process = p.process_id 
        LEFT JOIN riskcat rc ON r.rcat = rc.riskcat_id 
        LEFT JOIN assessment a ON r.risk_id = a.risk_id 
        WHERE 1=1";

// Apply filters based on criteria
switch ($initialCriteria) {
    case '2': // Selected Operation Model
        if ($operationalModel === 'Location' || $operationalModel === 'Department' || $operationalModel === 'Process') {
            // These are generic categories, no specific filter needed
        } else {
            // Specific process ID
            $sql .= " AND r.process = " . intval($operationalModel);
        }
        break;

    case '3': // Selected Entity
        if ($entityId > 0) {
            $sql .= " AND r.dept = " . $entityId;
        }
        break;

    case '4': // Selected Risk Category
        // Assuming risk category would be passed, but it's not in the form
        // This is a placeholder for future enhancement
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
try {
    $conn = new connectionClass();
    $result = $conn->query($sql) or die($conn->error);
    $risks = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $risks[] = $row;
        }
    }

    // Generate Excel file
    if (count($risks) > 0) {
        // Create filename with timestamp
        $filename = 'risk_report_' . date('Y-m-d_H-i-s') . '.xls';
        $filepath = '../reports/' . $filename;

        // Create directory if it doesn't exist
        if (!file_exists('../reports')) {
            mkdir('../reports', 0777, true);
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
                    foreach ($processClass->showProcess() as $process) {
                        if ($process['process_id'] == $operationalModel) {
                            $processName = $process['process_name'];
                            break;
                        }
                    }
                    $criteriaLabel = 'Process: ' . $processName;
                }
                break;
            case '3':
                $criteriaLabel = 'Entity: ' . $entity;
                break;
            case '4':
                $criteriaLabel = 'Risk Category';
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

        // Create Excel content with header
        $excel = '<!DOCTYPE html>
        <html>
        <head>
            <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
            <title>Risk Report</title>
            <style>
                table { border-collapse: collapse; width: 100%; }
                th, td { border: 1px solid #000; padding: 5px; }
                th { background-color: #f2f2f2; font-weight: bold; }
                .report-header { font-size: 16px; font-weight: bold; margin-bottom: 10px; }
                .report-subheader { font-size: 14px; margin-bottom: 15px; }
                .high-risk { background-color: #ff0000; color: #ffffff; }
                .medium-high-risk { background-color: #ff4700; color: #ffffff; }
                .medium-risk { background-color: #ffff00; }
                .low-risk { background-color: #00b050; color: #ffffff; }
            </style>
        </head>
        <body>
            <div class="report-header">GRC Risk Report</div>
            <div class="report-subheader">
                Criteria: ' . $criteriaLabel . '<br>
                Risk Type: ' . $riskTypeLabel . '<br>
                Date Generated: ' . date('Y-m-d H:i:s') . '
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Risk ID</th>
                        <th>Risk Name</th>
                        <th>Department</th>
                        <th>Process</th>
                        <th>Risk Category</th>
                        <th>Cause</th>';

        // Add assessment headers based on risk type
        if ($riskType == '1') { // Residual
            $excel .= '<th>Residual Impact</th>
                      <th>Residual Likelihood</th>
                      <th>Residual Rating</th>';
        } elseif ($riskType == '2') { // Inherent
            $excel .= '<th>Inherent Impact</th>
                      <th>Inherent Likelihood</th>
                      <th>Inherent Rating</th>';
        } else { // Target
            $excel .= '<th>Target Impact</th>
                      <th>Target Likelihood</th>
                      <th>Target Rating</th>';
        }

        $excel .= '</tr>
                </thead>
                <tbody>';

        // Add data rows
        foreach ($risks as $risk) {
            $excel .= '<tr>';
            $excel .= '<td>RSK0' . $risk['risk_id'] . '</td>';
            $excel .= '<td>' . htmlspecialchars($risk['risk_name']) . '</td>';
            $excel .= '<td>' . htmlspecialchars($risk['department']) . '</td>';
            $excel .= '<td>' . htmlspecialchars($risk['process']) . '</td>';
            $excel .= '<td>' . htmlspecialchars($risk['risk_category']) . '</td>';
            $excel .= '<td>' . htmlspecialchars($risk['cause']) . '</td>';

            // Add assessment values based on risk type
            if ($riskType == '1') { // Residual
                $impact = $risk['rimp'];
                $likelihood = $risk['rlikely'];
                $rating = $impact * $likelihood;

                $excel .= '<td>' . $impact . '</td>';
                $excel .= '<td>' . $likelihood . '</td>';

                // Add class based on rating
                $ratingClass = '';
                if($rating >= 1 && $rating <= 4) {
                    $ratingClass = 'class="low-risk"';
                } elseif($rating > 4 && $rating <= 9) {
                    $ratingClass = 'class="medium-risk"';
                } elseif($rating > 9 && $rating <= 16) {
                    $ratingClass = 'class="medium-high-risk"';
                } elseif($rating > 16 && $rating <= 25) {
                    $ratingClass = 'class="high-risk"';
                }

                $excel .= '<td ' . $ratingClass . '>' . $rating . '</td>';
            } elseif ($riskType == '2') { // Inherent
                $impact = $risk['iimp'];
                $likelihood = $risk['ilikely'];
                $rating = $impact * $likelihood;

                $excel .= '<td>' . $impact . '</td>';
                $excel .= '<td>' . $likelihood . '</td>';

                // Add class based on rating
                $ratingClass = '';
                if($rating >= 1 && $rating <= 4) {
                    $ratingClass = 'class="low-risk"';
                } elseif($rating > 4 && $rating <= 9) {
                    $ratingClass = 'class="medium-risk"';
                } elseif($rating > 9 && $rating <= 16) {
                    $ratingClass = 'class="medium-high-risk"';
                } elseif($rating > 16 && $rating <= 25) {
                    $ratingClass = 'class="high-risk"';
                }

                $excel .= '<td ' . $ratingClass . '>' . $rating . '</td>';
            }

            $excel .= '</tr>';
        }

        $excel .= '</tbody>
            </table>
        </body>
        </html>';

        // Write Excel content to file
        file_put_contents($filepath, $excel);

        // Return success message with filename for download
        echo 'Success:' . $filename;
    } else {
        echo 'No risks found matching the selected criteria.';
    }
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
}