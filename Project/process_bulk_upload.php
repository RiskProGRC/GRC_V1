<?php
session_start();
require_once './risk/riskClass.php';
require_once './department/departmentClass.php';
require_once './settings/riskcategoryClass.php';
require_once './process/processClass.php';
require_once './action/actionClass.php';

// Include the SimpleXLSX library
if (file_exists('../assets/vendors/shuchkin/xlsx.php')) {
    require_once '../assets/vendors/shuchkin/xlsx.php';
}

class BulkRiskUploader {
    private $riskClass;
    private $departmentClass;
    private $riskCatClass;
    private $processClass;
    private $actionClass;

    public function __construct() {
        $this->riskClass = new riskClass();
        $this->departmentClass = new departmentClass();
        $this->riskCatClass = new riskCatClass();
        $this->processClass = new processClass();
        $this->actionClass = new actionClass();
    }

    public function processUpload($files, $departmentId, $uploadType, $userId, $ipAddress, $validateOnly = false) {
        $successCount = 0;
        $failedCount = 0;
        $details = [];

        foreach ($files['tmp_name'] as $key => $tmpName) {
            if (empty($tmpName)) continue;

            $fileName = $files['name'][$key];
            $fileSize = $files['size'][$key];
            $fileError = $files['error'][$key];

            try {
                // Validate file
                if ($fileError !== UPLOAD_ERR_OK) {
                    throw new Exception("Upload error for file: $fileName");
                }

                if ($fileSize > 10 * 1024 * 1024) { // 10MB limit
                    throw new Exception("File too large: $fileName");
                }

                $allowedTypes = ['xlsx', 'xls', 'csv'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
                if (!in_array($fileExtension, $allowedTypes)) {
                    throw new Exception("Invalid file type: $fileName. Allowed: xlsx, xls, csv");
                }

                // Process file
                $result = $this->processFile($tmpName, $fileName, $fileExtension, $departmentId, $uploadType, $userId, $ipAddress, $validateOnly);

                if ($result['success']) {
                    $successCount++;
                    $details[] = [
                        'file' => $fileName,
                        'status' => 'success',
                        'message' => $result['message']
                    ];
                } else {
                    $failedCount++;
                    $details[] = [
                        'file' => $fileName,
                        'status' => 'error',
                        'message' => $result['message']
                    ];
                }

            } catch (Exception $e) {
                $failedCount++;
                $details[] = [
                    'file' => $fileName,
                    'status' => 'error',
                    'message' => $e->getMessage()
                ];
            }
        }

        return [
            'summary' => [
                'success' => $successCount,
                'failed' => $failedCount
            ],
            'details' => $details
        ];
    }

    private function processFile($filePath, $fileName, $fileExtension, $departmentId, $uploadType, $userId, $ipAddress, $validateOnly) {
        try {
            $rows = [];

            if ($fileExtension === 'csv') {
                $rows = $this->readCsvFile($filePath);
            } else {
                // Use SimpleXLSX reader if available
                if (class_exists('Shuchkin\SimpleXLSX')) {
                    $xlsx = \Shuchkin\SimpleXLSX::parse($filePath);
                    if ($xlsx) {
                        $rows = $xlsx->rows();
                    } else {
                        throw new Exception("Could not parse Excel file: " . \Shuchkin\SimpleXLSX::parseError());
                    }
                } else {
                    throw new Exception("Excel support not available. Please use CSV format or install SimpleXLSX library.");
                }
            }

            if (empty($rows)) {
                throw new Exception("No data found in file");
            }

            // Find the header row (look for "Risk ID." specifically to avoid false matches)
            $headerRowIndex = -1;
            $dataStartIndex = 0;

            foreach ($rows as $index => $row) {
                $col0 = trim($row[0] ?? '');
                // Look for exact header row with "Risk ID." or "Risk ID" in first column
                if ($col0 === 'Risk ID.' || $col0 === 'Risk ID' ||
                    (!empty($row[2]) && stripos($row[2], 'Risk Description') !== false && stripos($row[2], 'Event') !== false)) {
                    $headerRowIndex = $index;
                    $dataStartIndex = $index + 1;
                    break;
                }
            }

            // If no header found, assume data starts after first non-empty row
            if ($headerRowIndex === -1) {
                foreach ($rows as $index => $row) {
                    if (!empty(array_filter($row))) {
                        $dataStartIndex = $index + 1;
                        break;
                    }
                }
            }

            $processedCount = 0;
            $errors = [];

            for ($i = $dataStartIndex; $i < count($rows); $i++) {
                $row = $rows[$i];

                // Skip empty rows
                if (empty(array_filter($row))) continue;

                // Skip rows where first column is empty (likely continuation or notes)
                if (empty(trim($row[0])) || !is_numeric(trim($row[0]))) continue;

                try {
                    switch ($uploadType) {
                        case 'risks':
                            $this->processRiskRow($row, $departmentId, $userId, $ipAddress, $validateOnly);
                            break;
                        case 'complete':
                            $this->processCompleteRow($row, $departmentId, $userId, $ipAddress, $validateOnly);
                            break;
                        case 'controls':
                            $this->processControlRow($row, $departmentId, $userId, $ipAddress, $validateOnly);
                            break;
                    }
                    $processedCount++;
                } catch (Exception $e) {
                    $errors[] = "Row " . ($i + 1) . ": " . $e->getMessage();
                    // Only collect first 10 errors to avoid overwhelming response
                    if (count($errors) >= 10) break;
                }
            }

            if (!empty($errors)) {
                throw new Exception("Validation errors: " . implode('; ', array_slice($errors, 0, 5)));
            }

            return [
                'success' => true,
                'message' => "Processed $processedCount records successfully"
            ];

        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }

    private function readCsvFile($filePath) {
        $rows = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $rows[] = $data;
            }
            fclose($handle);
        }
        return $rows;
    }

    private function processRiskRow($row, $departmentId, $userId, $ipAddress, $validateOnly) {
        // Map columns based on actual Excel structure:
        // Col 0: Risk ID (numeric)
        // Col 1: Key Process
        // Col 2: Risk Description/Event (Risk Name)
        // Col 3: Cause of Risk
        // Col 4: Impact/Consequence of Risk
        // Col 5: Risk Category
        // Col 6: Risk owner

        $riskId = trim($row[0] ?? '');
        $processName = trim($row[1] ?? '');
        $riskName = trim($row[2] ?? '');
        $cause = trim($row[3] ?? '');
        $consequence = trim($row[4] ?? '');
        $categoryName = trim($row[5] ?? '');
        $riskOwner = trim($row[6] ?? '');

        // Validate required fields
        if (empty($riskName)) {
            throw new Exception("Risk description is required (Column C)");
        }

        if (empty($cause)) {
            throw new Exception("Risk cause is required (Column D)");
        }

        // Get or create process ID
        $processId = 1; // default
        if (!empty($processName)) {
            $processId = $this->getOrCreateProcess($processName, $departmentId);
        }

        // Get category ID (default to 1 if not found)
        $categoryId = $this->findRiskCategory($categoryName);

        if (!$validateOnly) {
            // Insert risk using existing method
            $result = $this->riskClass->addRisk(
                $userId,
                $ipAddress,
                $riskName,
                $categoryId,
                $departmentId,
                $processId,
                $cause,
                $consequence ?: 'Impact on business operations',
                0, // assessment
                $userId, // reviewer
                date('Y-m-d'), // review date
                !empty($riskOwner) ? $riskOwner : 'System Upload', // nominee
                1 // approval status - pending
            );

            if (strpos($result, 'Successfully') === false) {
                throw new Exception("Failed to add risk: $result");
            }
        }
    }

    private function processCompleteRow($row, $departmentId, $userId, $ipAddress, $validateOnly) {
        // For complete upload, use same structure as processRiskRow
        // since the Excel files follow the same format
        $this->processRiskRow($row, $departmentId, $userId, $ipAddress, $validateOnly);
    }

    private function processControlRow($row, $departmentId, $userId, $ipAddress, $validateOnly) {
        $controlName = trim($row[0] ?? '');
        $actionName = trim($row[1] ?? '');
        $status = trim($row[2] ?? 'ongoing');
        $priority = trim($row[3] ?? 'Medium');
        $timeline = trim($row[4] ?? '');

        if (empty($actionName)) {
            throw new Exception("Action name is required");
        }

        if (!$validateOnly) {
            // Use the existing action class if available
            if (class_exists('actionClass') && method_exists($this->actionClass, 'addaction')) {
                $result = $this->actionClass->addaction(
                    $userId,
                    $ipAddress,
                    $departmentId,
                    1, // default process
                    1, // default risk
                    $actionName,
                    $status,
                    $priority,
                    $timeline ?: date('Y-m-d', strtotime('+30 days'))
                );

                if (strpos($result, 'Successfully') === false) {
                    throw new Exception("Failed to add action: $result");
                }
            } else {
                // Log action to system_logs instead
                $insert = "INSERT INTO system_logs(user_id, entity, action, ip_address) 
                          VALUES ('$userId','Bulk Upload','Action: $actionName','$ipAddress')";
                $this->query($insert);
            }
        }
    }

    private function getOrCreateProcess($processName, $departmentId) {
        if (empty($processName)) {
            return 1; // default process
        }

        // Check if process exists
        $processes = $this->processClass->showProcessdept($departmentId);
        if (is_array($processes)) {
            foreach ($processes as $process) {
                if (strtolower($process['process_name']) === strtolower($processName)) {
                    return $process['process_id'];
                }
            }
        }

        // Create new process if it doesn't exist
        $result = $this->processClass->addProcess(
            1, // system user
            $_SERVER['REMOTE_ADDR'],
            $processName,
            $departmentId,
            'Auto-created from bulk upload'
        );

        if (strpos($result, 'Entered') !== false) {
            // Get the newly created process ID
            $processes = $this->processClass->showProcessdept($departmentId);
            if (is_array($processes)) {
                foreach ($processes as $process) {
                    if (strtolower($process['process_name']) === strtolower($processName)) {
                        return $process['process_id'];
                    }
                }
            }
        }

        return 1; // fallback to default
    }

    private function findRiskCategory($categoryName) {
        if (empty($categoryName)) {
            return 1; // default category
        }

        $categories = $this->riskCatClass->showRiskCat();
        if (is_array($categories)) {
            foreach ($categories as $category) {
                if (strtolower($category['name']) === strtolower($categoryName)) {
                    return $category['riskcat_id'];
                }
            }
        }

        return 1; // default category if not found
    }
}

// Handle the upload request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $uploader = new BulkRiskUploader();

        $departmentId = $_POST['department_id'] ?? '';
        $uploadType = $_POST['upload_type'] ?? '';
        $userId = $_POST['uid'] ?? '';
        $ipAddress = $_POST['ip'] ?? '';
        $validateOnly = isset($_POST['validate_only']) && $_POST['validate_only'] == '1';

        if (empty($departmentId) || empty($uploadType) || empty($_FILES['excel_files'])) {
            throw new Exception('Missing required parameters');
        }

        $result = $uploader->processUpload(
            $_FILES['excel_files'],
            $departmentId,
            $uploadType,
            $userId,
            $ipAddress,
            $validateOnly
        );

        echo json_encode($result);

    } catch (Exception $e) {
        echo json_encode([
            'summary' => ['success' => 0, 'failed' => 1],
            'details' => [['file' => 'System', 'status' => 'error', 'message' => $e->getMessage()]]
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
}
?>

