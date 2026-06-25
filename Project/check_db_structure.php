<?php
// Database Structure Check for Risk Register System
include_once './connection/connect.php';

echo "<h2>Database Structure Verification for Risk Register System</h2>";

// Required tables and their key columns
$requiredTables = [
    'risk' => ['risk_id', 'risk_name', 'cause', 'dept', 'process', 'rcat', 'nominee', 'approval', 'created_at', 'updated_at'],
    'assessment' => ['id', 'risk_id', 'iimp', 'ilikely', 'rimp', 'rlikely', 'timp', 'tlikely'],
    'department' => ['dept_id', 'dept_name'],
    'process' => ['process_id', 'process_name'],
    'riskcat' => ['riskcat_id', 'name'],
    'control' => ['control_id', 'control', 'cstrength'],
    'risk_control' => ['risk_id', 'control_id'],
    'action' => ['id', 'risk_id', 'action', 'priority', 'timeline'],
    'ki' => ['id', 'risk_id', 'ki'],
    'users' => ['id', 'username']
];

foreach ($requiredTables as $tableName => $columns) {
    echo "<h3>Checking table: $tableName</h3>";

    // Check if table exists
    $con = new connectionClass();
    $checkTable = "SHOW TABLES LIKE '$tableName'";
    $result = $con->query($checkTable);

    if ($result->num_rows > 0) {
        echo "<p style='color: green;'>✓ Table '$tableName' exists</p>";

        // Check columns
        $checkColumns = "DESCRIBE $tableName";
        $columnResult = $con->query($checkColumns);

        if ($columnResult) {
            $existingColumns = [];
            while ($row = $columnResult->fetch_assoc()) {
                $existingColumns[] = $row['Field'];
            }

            echo "<p><strong>Existing columns:</strong> " . implode(', ', $existingColumns) . "</p>";

            // Check required columns
            $missingColumns = array_diff($columns, $existingColumns);
            if (empty($missingColumns)) {
                echo "<p style='color: green;'>✓ All required columns present</p>";
            } else {
                echo "<p style='color: orange;'>⚠ Missing columns: " . implode(', ', $missingColumns) . "</p>";
            }
        }
    } else {
        echo "<p style='color: red;'>✗ Table '$tableName' does not exist</p>";
        echo "<p><strong>Create table SQL needed for: $tableName</strong></p>";
    }
    echo "<hr>";
}

// Check sample data
echo "<h3>Sample Data Check</h3>";

$sampleQueries = [
    'Total Risks' => "SELECT COUNT(*) as count FROM risk",
    'Approved Risks' => "SELECT COUNT(*) as count FROM risk WHERE approval = 2",
    'Risks with Assessment' => "SELECT COUNT(*) as count FROM risk r INNER JOIN assessment a ON r.risk_id = a.risk_id",
    'Risk Categories' => "SELECT COUNT(*) as count FROM riskcat",
    'Departments' => "SELECT COUNT(*) as count FROM department",
    'Controls' => "SELECT COUNT(*) as count FROM control",
    'Actions' => "SELECT COUNT(*) as count FROM action",
    'Key Indicators' => "SELECT COUNT(*) as count FROM ki"
];

foreach ($sampleQueries as $label => $query) {
    try {
        $result = $con->query($query);
        if ($result) {
            $row = $result->fetch_assoc();
            echo "<p><strong>$label:</strong> " . $row['count'] . "</p>";
        }
    } catch (Exception $e) {
        echo "<p style='color: red;'><strong>$label:</strong> Error - " . $e->getMessage() . "</p>";
    }
}

echo "<h3>Ready for Risk Register Report?</h3>";
if ($con->query("SELECT COUNT(*) FROM risk WHERE approval = 2")->fetch_assoc()['count'] > 0) {
    echo "<p style='color: green; font-size: 18px;'>✓ System is ready! You have approved risks that can be included in the risk register.</p>";
    echo "<p><a href='risk_register_report.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px;'>Go to Risk Register Report</a></p>";
} else {
    echo "<p style='color: orange; font-size: 18px;'>⚠ You need to approve some risks first before generating the risk register report.</p>";
}
?>