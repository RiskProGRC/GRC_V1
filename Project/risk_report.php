<?php
include_once './settings/riskcategoryClass.php';
include_once './risk/riskClass.php';
include_once './department/departmentClass.php';
include_once './process/processClass.php';

// Initialize classes
$riskClass = new riskClass();
$deptClass = new departmentClass();
$processClass = new processClass();
$riskCatClass = new riskCatClass();

// Get all departments/entities
$departments = $deptClass->showDept();

// Get operational models (processes)
$processes = $processClass->showProcess();

// Initialize variables for report preview
$showPreview = false;
$risks = array();
$riskType = '1'; // Default to Residual

// Check if form is submitted for preview
if(isset($_POST['preview'])) {
    $showPreview = true;

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

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $risks[] = $row;
            }
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<!-- Header location -->
<?php include_once("../layout/header.php"); ?>
<body>
<div id="app">
    <div id="main" class="layout-horizontal">
        <!-- Navigation location -->
        <?php include_once("../layout/nav.php") ?>
        <div class="content-wrapper container">

            <div class="page-heading">
                <h4>Risk Report</h4>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <!-- Content location BEGINNING -->
                        <section class="section">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Risk Report Generator</h4>
                                </div>
                                <div class="card-body">
                                    <form id="reportForm" method="post" action="">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-4">
                                                    <label for="topRisks">Print top 'n' risks (0 for ALL)</label>
                                                    <input type="number" class="form-control" id="topRisks" name="topRisks" value="<?= isset($_POST['topRisks']) ? $_POST['topRisks'] : '0' ?>" min="0">
                                                </div>

                                                <div class="alert alert-light-secondary">
                                                    First choose your initial selection criteria from this list then from Entities, Op Models etc
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label>Choose your initial selection criteria</label>
                                                    <select class="form-select" id="initialCriteria" name="initialCriteria">
                                                        <option value="1" <?= (isset($_POST['initialCriteria']) && $_POST['initialCriteria'] == '1') ? 'selected' : '' ?>>1: All Risks</option>
                                                        <option value="2" <?= (!isset($_POST['initialCriteria']) || $_POST['initialCriteria'] == '2') ? 'selected' : '' ?>>2: Selected Operation Model</option>
                                                        <option value="3" <?= (isset($_POST['initialCriteria']) && $_POST['initialCriteria'] == '3') ? 'selected' : '' ?>>3: Selected Entity</option>
                                                        <option value="4" <?= (isset($_POST['initialCriteria']) && $_POST['initialCriteria'] == '4') ? 'selected' : '' ?>>4: Selected Risk Category</option>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label>Select Entity</label>
                                                    <select class="form-select" id="entity" name="entity">
                                                        <?php
                                                        if (is_array($departments)) {
                                                            foreach ($departments as $dept) {
                                                                $entOption = 'ENT' . str_pad($dept['dept_id'], 5, '0', STR_PAD_LEFT) . ' ' . $dept['dept_name'];
                                                                $selected = (isset($_POST['entity']) && $_POST['entity'] == $entOption) ? 'selected' : '';
                                                                echo '<option value="' . $entOption . '" ' . $selected . '>' . $entOption . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label>Select Operational Model</label>
                                                    <select class="form-select" id="operationalModel" name="operationalModel">
                                                        <option value="Location" <?= (!isset($_POST['operationalModel']) || $_POST['operationalModel'] == 'Location') ? 'selected' : '' ?>>Location</option>
                                                        <option value="Department" <?= (isset($_POST['operationalModel']) && $_POST['operationalModel'] == 'Department') ? 'selected' : '' ?>>Department</option>
                                                        <option value="Process" <?= (isset($_POST['operationalModel']) && $_POST['operationalModel'] == 'Process') ? 'selected' : '' ?>>Process</option>
                                                        <?php
                                                        if (is_array($processes)) {
                                                            foreach ($processes as $process) {
                                                                $selected = (isset($_POST['operationalModel']) && $_POST['operationalModel'] == $process['process_id']) ? 'selected' : '';
                                                                echo '<option value="' . $process['process_id'] . '" ' . $selected . '>' . $process['process_name'] . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group mb-4">
                                                    <label>Select Residual OR Inherent</label>
                                                    <select class="form-select" id="riskType" name="riskType">
                                                        <option value="1" <?= (!isset($_POST['riskType']) || $_POST['riskType'] == '1') ? 'selected' : '' ?>>1: Residual</option>
                                                        <option value="2" <?= (isset($_POST['riskType']) && $_POST['riskType'] == '2') ? 'selected' : '' ?>>2: Inherent</option>
                                                        <option value="3" <?= (isset($_POST['riskType']) && $_POST['riskType'] == '3') ? 'selected' : '' ?>>3: Target</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-6 d-flex align-items-end">
                                                <div class="mt-4">
                                                    <button type="submit" class="btn btn-primary me-2" id="previewReport" name="preview" value="1">
                                                        <i class="bi bi-eye"></i> Preview Report
                                                    </button>
                                                    <?php if($showPreview && count($risks) > 0): ?>
                                                        <button type="button" class="btn btn-success" id="exportExcel">
                                                            <i class="bi bi-file-earmark-excel"></i> Export to Excel
                                                        </button>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <?php if($showPreview): ?>
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Report Preview</h4>
                                        <p class="text-subtitle text-muted">Showing <?= count($risks) ?> risk(s)</p>
                                    </div>
                                    <div class="card-body">
                                        <?php if(count($risks) > 0): ?>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover" id="previewTable">
                                                    <thead>
                                                    <tr>
                                                        <th>Risk ID</th>
                                                        <th>Risk Name</th>
                                                        <th>Department</th>
                                                        <th>Process</th>
                                                        <th>Risk Category</th>
                                                        <th>Cause</th>
                                                        <?php if($riskType == '1'): // Residual ?>
                                                            <th>Impact</th>
                                                            <th>Likelihood</th>
                                                            <th>Rating</th>
                                                        <?php elseif($riskType == '2'): // Inherent ?>
                                                            <th>Impact</th>
                                                            <th>Likelihood</th>
                                                            <th>Rating</th>
                                                        <?php else: // Target ?>
                                                            <th>Target Impact</th>
                                                            <th>Target Likelihood</th>
                                                            <th>Target Rating</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php foreach($risks as $risk):
                                                        // Calculate rating based on risk type
                                                        if($riskType == '1') { // Residual
                                                            $impact = $risk['rimp'];
                                                            $likelihood = $risk['rlikely'];
                                                        } elseif($riskType == '2') { // Inherent
                                                            $impact = $risk['iimp'];
                                                            $likelihood = $risk['ilikely'];
                                                        } else { // Target
                                                            $impact = $risk['timp'];
                                                            $likelihood = $risk['tlikely'];
                                                        }
                                                        $rating = $impact * $likelihood;

                                                        // Determine styling class based on rating
                                                        if($rating >= 1 && $rating <= 4) {
                                                            $ratingClass = 'bg-success text-white';
                                                        } elseif($rating > 4 && $rating <= 9) {
                                                            $ratingClass = 'bg-warning';
                                                        } elseif($rating > 9 && $rating <= 16) {
                                                            $ratingClass = 'bg-orange text-white';
                                                        } elseif($rating > 16 && $rating <= 25) {
                                                            $ratingClass = 'bg-danger text-white';
                                                        } else {
                                                            $ratingClass = '';
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td>RSK0<?= $risk['risk_id'] ?></td>
                                                            <td><?= htmlspecialchars($risk['risk_name']) ?></td>
                                                            <td><?= htmlspecialchars($risk['department']) ?></td>
                                                            <td><?= htmlspecialchars($risk['process']) ?></td>
                                                            <td><?= htmlspecialchars($risk['risk_category']) ?></td>
                                                            <td><?= htmlspecialchars($risk['cause']) ?></td>
                                                            <td><?= $impact ?></td>
                                                            <td><?= $likelihood ?></td>
                                                            <td class="<?= $ratingClass ?>"><?= $rating ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        <?php else: ?>
                                            <div class="alert alert-info">
                                                <h4 class="alert-heading">No Data Found</h4>
                                                <p>No risks match the selected criteria. Please try different filter options.</p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </section>
                        <!-- Content location END -->
                    </div>
                </section>
            </div>
        </div>
        <!-- Footer location -->
        <?php include_once("../layout/footer.php"); ?>
    </div>
</div>

<script src="../assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
<script src="../assets/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>
<script src="../assets/js/pages/horizontal-layout.js"></script>
<script src="../assets/vendors/fontawesome/all.min.js"></script>
<script src="../assets/vendors/simple-datatables/simple-datatables.js"></script>

<script>
    $(document).ready(function() {
        // Initialize datatable for preview table if exists
        if (document.getElementById('previewTable')) {
            let dataTable = new simpleDatatables.DataTable('#previewTable');
        }

        // Dynamic form behavior based on selection criteria
        $('#initialCriteria').change(function() {
            var selectedValue = $(this).val();

            // Enable/disable fields based on selection
            switch(selectedValue) {
                case "1": // All Risks
                    $('#entity, #operationalModel').prop('disabled', true);
                    break;
                case "2": // Selected Operation Model
                    $('#operationalModel').prop('disabled', false);
                    $('#entity').prop('disabled', true);
                    break;
                case "3": // Selected Entity
                    $('#entity').prop('disabled', false);
                    $('#operationalModel').prop('disabled', true);
                    break;
                case "4": // Selected Risk Category
                    $('#entity, #operationalModel').prop('disabled', true);
                    break;
                default:
                    $('#entity, #operationalModel').prop('disabled', false);
            }
        });

        // Trigger change event on page load to set initial state
        $('#initialCriteria').trigger('change');

        // Export to Excel button handler
        $('#exportExcel').on('click', function() {
            // Get form data
            var formData = $('#reportForm').serialize();

            // Add export flag
            formData += '&export=1';

            // AJAX call to generate Excel file
            $.ajax({
                url: 'risk_report_generate.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Check if response is a file download
                    if(response.startsWith('Success')) {
                        window.location.href = 'risk_report_download.php?file=' + response.split(':')[1];
                    } else {
                        // Display error message
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while generating the report.'
                    });
                }
            });
        });
    });
</script>

<style>
    .bg-orange {
        background-color: #ff4700 !important;
    }
</style>
</body>
</html>