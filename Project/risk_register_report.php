<?php
include_once './connection/connect.php';
include_once './settings/riskcategoryClass.php';
include_once './risk/riskClass.php';
include_once './department/departmentClass.php';
include_once './process/processClass.php';
include_once './control/controlClass.php';
include_once './action/actionClass.php';
include_once './keyindicator/keyindicatorClass.php';
include_once './users/usersClass.php';

// Initialize classes
$riskClass = new riskClass();
$userclass= new usersClass();
$deptClass = new departmentClass();
$processClass = new processClass();
$riskCatClass = new riskCatClass();
$controlClass = new controlClass();
$actionClass = new actionClass();
$kiClass = new kiClass();

// Get all departments/entities
$departments = $deptClass->showDept();
// Get operational models (processes)
$processes = $processClass->showProcess();
// Get risk categories
$riskCategories = $riskCatClass->showRiskCat();

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
    $riskCategory = isset($_POST['riskCategory']) ? $_POST['riskCategory'] : '';
    $riskType = isset($_POST['riskType']) ? $_POST['riskType'] : '1';

    // Extract entity ID from the entity string (format: "ENT00020 Group Co")
    $entityId = 0;
    if (!empty($entity)) {
        preg_match('/ENT(\d+)/', $entity, $matches);
        if (isset($matches[1])) {
            $entityId = intval($matches[1]);
        }
    }

    // Build a comprehensive SQL query for complete risk register
    $sql = "SELECT DISTINCT
                r.risk_id, 
                r.risk_name, 
                r.cause, 
                r.consequence,
                d.dept_name as department, 
                p.process_name as process, 
                rc.name as risk_category,
                u.username as risk_owner,
                a.id as assid,
                a.iimp as inherent_impact, 
                a.ilikely as inherent_likelihood, 
                (a.iimp * a.ilikely) as inherent_rating,
                a.rimp as residual_impact, 
                a.rlikely as residual_likelihood, 
                (a.rimp * a.rlikely) as residual_rating,
                a.timp as target_impact, 
                a.apetite as risk_apetite,
                a.treatment as risk_treatment,
                a.tlikely as target_likelihood, 
                (a.timp * a.tlikely) as target_rating,
                r.created_at,
                r.updated_at
            FROM risk r 
            LEFT JOIN department d ON r.dept = d.dept_id 
            LEFT JOIN process p ON r.process = p.process_id 
            LEFT JOIN riskcat rc ON r.rcat = rc.riskcat_id 
            LEFT JOIN assessment a ON r.risk_id = a.risk_id 
            LEFT JOIN users u ON r.userid = u.id
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
    try {
        $con = new connectionClass();
        $result = $con->query($sql) or die($con->error);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Get additional data for each risk
                $riskId = $row['risk_id'];

                // Get controls for this risk
                $controlSql = "SELECT MAX(c.reviewer) as reviewer, 
                              GROUP_CONCAT(c.controls SEPARATOR '; ') as controls,
                              COUNT(c.control_id) as control_count
                              FROM risk_control rc
                              INNER JOIN control c ON rc.control_id = c.control_id
                              WHERE rc.risk_id = $riskId AND rc.status = 1";
                $controlResult = $con->query($controlSql);
                $controlData = $controlResult->fetch_assoc();

                // Get actions for this risk
                $actionSql = "SELECT GROUP_CONCAT(
                                CONCAT(a.action, ' (Priority: ', a.priority, ', Timeline: ', a.timeline, ')') 
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
                $row['existing_controls'] = $controlData['controls'] ?? '';
                $row['control_owner'] = $controlData['reviewer'] ?? '';
                $row['control_effectiveness'] = getControlEffectivenessLabel($controlData['control_count'] ?? 0);
                $row['action_plan'] = $actionData['actions'] ?? '';
                $row['kri'] = $kriData['kris'] ?? '';

                $risks[] = $row;
            }
        }
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . $e->getMessage() . '</div>';
    }
}

// Helper function to get control effectiveness label
function getControlEffectivenessLabel($strength) {
    if ($strength == 1) return 'Effective';
    elseif ($strength == 2) return 'ineffective';
    elseif ($strength == 3) return 'Partially effective';
    else return '';
}

// Helper function to get risk level label
function getRiskLevel($rating) {
    if ($rating >= 16) return 'Very High';
    elseif ($rating >= 12) return 'High';
    elseif ($rating >= 6) return 'Medium';
    elseif ($rating >= 3) return 'Low';
    else return 'Very Low';
}

// Helper function to get risk level label
function getRiskapetite($apetite) {
    if ($apetite == 1) return 'Low Apetite';
    elseif ($apetite == 2) return 'Medium Apetite';
    elseif ($apetite == 3) return 'Low Apetite';
    else return '';
}
// Helper function to get treatment strategy
function getRiskTreatment($treatment) {
    if ($treatment == 1) return 'Accepted';
    elseif ($treatment == 2) return 'Avoid';
    elseif ($treatment == 3) return 'Transfer';
    elseif ($treatment == 4) return 'Mitigate';
    else return '';
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
                <h4>Risk Register Report</h4>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-12">
                        <section class="section">
                            <div class="card">
                                <div class="card-header">
                                    <!-- <h4 class="card-title">Risk Register Generator</h4>-->
                                </div>
                                <div class="card-body">
                                    <form id="reportForm" method="post" action="">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!--<div class="form-group mb-4">
                                                    <label for="topRisks">Print top 'n' risks (0 for ALL)</label>
                                                    <input type="number" class="form-control" id="topRisks" name="topRisks"
                                                           value="" min="0">
                                                </div>

                                                <div class="alert alert-light-secondary">
                                                    First choose your initial selection criteria from this list then from Entities, Op Models etc
                                                </div>-->




                                            </div>

                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="form-group mb-4 col-md-3">
                                                        <label>Choose your initial selection criteria</label>
                                                        <select class="form-select" id="initialCriteria" name="initialCriteria">
                                                            <option value="1" <?= (isset($_POST['initialCriteria']) && $_POST['initialCriteria'] == '1') ? 'selected' : '' ?>>1: All Risks</option>
                                                            <option value="2" <?= (!isset($_POST['initialCriteria']) || $_POST['initialCriteria'] == '2') ? 'selected' : '' ?>>2: Selected Operation Model</option>
                                                            <option value="3" <?= (isset($_POST['initialCriteria']) && $_POST['initialCriteria'] == '3') ? 'selected' : '' ?>>3: Selected Entity</option>
                                                            <option value="4" <?= (isset($_POST['initialCriteria']) && $_POST['initialCriteria'] == '4') ? 'selected' : '' ?>>4: Selected Risk Category</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mb-4 col-md-3">
                                                        <label>Select Entity</label>
                                                        <select class="form-select" id="entity" name="entity">
                                                            <option value="">Select Entity</option>
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
                                                    <div class="form-group mb-4 col-md-3">
                                                        <label>Select Operational Model</label>
                                                        <select class="form-select" id="operationalModel" name="operationalModel">
                                                            <option value="">Select Operational Model</option>
                                                            <option value="Location" <?= (isset($_POST['operationalModel']) && $_POST['operationalModel'] == 'Location') ? 'selected' : '' ?>>Location</option>
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
                                                    <div class="form-group mb-4 col-md-3">
                                                        <label>Select Risk Category</label>
                                                        <select class="form-select" id="riskCategory" name="riskCategory">
                                                            <option value="">Select Risk Category</option>
                                                            <?php
                                                            if (is_array($riskCategories)) {
                                                                foreach ($riskCategories as $category) {
                                                                    $selected = (isset($_POST['riskCategory']) && $_POST['riskCategory'] == $category['riskcat_id']) ? 'selected' : '';
                                                                    echo '<option value="' . $category['riskcat_id'] . '" ' . $selected . '>' . $category['name'] . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="col-md-12">
                                                <div class="mt-4">
                                                    <button type="submit" class="btn btn-primary me-2" id="previewReport" name="preview" value="1">
                                                        <i class="bi bi-eye"></i> Preview Risk Register
                                                    </button>

                                                    <?php if($showPreview && count($risks) > 0): ?>
                                                        <button type="button" class="btn btn-success" id="exportExcel">
                                                            <i class="bi bi-file-earmark-excel"></i> Export to Excel
                                                        </button>
                                                        <button type="button" class="btn btn-info" id="exportPDF">
                                                            <i class="bi bi-file-earmark-pdf"></i> Export to PDF
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
                                        <h4 class="card-title">Risk Register Preview</h4>
                                        <p class="text-subtitle text-muted">Showing <?= count($risks) ?> risk(s) in comprehensive format</p>
                                    </div>

                                    <div class="card-body">
                                        <?php if(count($risks) > 0): ?>
                                            <div class="table-responsive">
                                                <table class="table table-striped table-hover" id="riskRegisterTable" style="font-size: 12px;">
                                                    <thead class="table-dark">
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
                                                    <tbody>
                                                    <?php foreach($risks as $risk):
                                                        //assessment id
                                                        $aid=$risk['assid'];
                                                        $assactn=$riskClass->assaction($aid);
                                                        //control reviewer
                                                        $uid=$risk['control_owner'];
                                                        $control_owner = $userclass->userjoin($uid);
                                                        // Get styling for risk ratings
                                                        $inherentClass = '';
                                                        $residualClass = '';

                                                        if($risk['inherent_rating'] >= 16) $inherentClass = 'bg-danger text-white';
                                                        elseif($risk['inherent_rating'] >= 12) $inherentClass = 'bg-warning';
                                                        elseif($risk['inherent_rating'] >= 6) $inherentClass = 'bg-info text-white';
                                                        else $inherentClass = 'bg-success text-white';

                                                        if($risk['residual_rating'] >= 16) $residualClass = 'bg-danger text-white';
                                                        elseif($risk['residual_rating'] >= 12) $residualClass = 'bg-warning';
                                                        elseif($risk['residual_rating'] >= 6) $residualClass = 'bg-info text-white';
                                                        else $residualClass = 'bg-success text-white';
                                                        ?>
                                                        <tr>
                                                            <td>RSK-<?= str_pad($risk['risk_id'], 3, '0', STR_PAD_LEFT) ?></td>
                                                            <td><?= htmlspecialchars($risk['process']) ?></td>
                                                            <td style="max-width: 200px; white-space: normal;"><?= htmlspecialchars($risk['risk_name']) ?></td>
                                                            <td style="max-width: 150px; white-space: normal;"><?= htmlspecialchars($risk['cause']) ?></td>
                                                            <td style="max-width: 150px; white-space: normal;">
                                                                <?= htmlspecialchars($risk['consequence']) ?>
                                                            </td>
                                                            <td><?= htmlspecialchars($risk['risk_category']) ?></td>
                                                            <td><?= htmlspecialchars($risk['risk_owner'] ?? $risk['department']) ?></td>
                                                            <td class="text-center"><?= $risk['inherent_likelihood'] ?></td>
                                                            <td class="text-center"><?= $risk['inherent_impact'] ?></td>
                                                            <td class="text-center <?= $inherentClass ?>"><?= $risk['inherent_rating'] ?></td>
                                                            <td style="max-width: 200px; white-space: normal;"><?= htmlspecialchars($risk['existing_controls']) ?></td>
                                                            <td><?= $risk['control_effectiveness'] ?></td>
                                                            <td><?= $control_owner ?></td>
                                                            <td class="text-center"><?= $risk['residual_likelihood'] ?></td>
                                                            <td class="text-center"><?= $risk['residual_impact'] ?></td>
                                                            <td class="text-center <?= $residualClass ?>"><?= $risk['residual_rating'] ?></td>
                                                            <td><?= getRiskapetite($risk['risk_apetite']) ?></td>
                                                            <td><?= getRiskTreatment($risk['risk_treatment']) ?></td>
                                                            <td style="max-width: 200px; white-space: normal;">
                                                                <?php
                                                                foreach($assactn as $action){
                                                                    $aid=$action["action"];
                                                                    $action=$actionClass->actionJoins($aid);
                                                                    echo 'ACT00'.$aid.'&nbsp;'.$action.'<br>' ;
                                                                }
                                                                ?>
                                                            </td>
                                                            <td><?= htmlspecialchars($risk['risk_owner'] ?? $risk['department']) ?></td>
                                                            <td><?= date('Y-m-d', strtotime('+6 months')) ?></td>
                                                            <td><span class="badge bg-warning">ongoing</span></td>
                                                            <td style="max-width: 150px; white-space: normal;"></td>
                                                            <td style="max-width: 150px; white-space: normal;"></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
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
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        // Initialize datatable for risk register table if exists
        if (document.getElementById('riskRegisterTable')) {
            let dataTable = new simpleDatatables.DataTable('#riskRegisterTable', {
                scrollX: true,
                fixedHeight: true,
                searchable: true,
                sortable: true
            });
        }

        // Dynamic form behavior based on selection criteria
        $('#initialCriteria').change(function() {
            var selectedValue = $(this).val();
            // Enable/disable fields based on selection
            switch(selectedValue) {
                case "1": // All Risks
                    $('#entity, #operationalModel, #riskCategory').prop('disabled', true);
                    break;
                case "2": // Selected Operation Model
                    $('#operationalModel').prop('disabled', false);
                    $('#entity, #riskCategory').prop('disabled', true);
                    break;
                case "3": // Selected Entity
                    $('#entity').prop('disabled', false);
                    $('#operationalModel, #riskCategory').prop('disabled', true);
                    break;
                case "4": // Selected Risk Category
                    $('#riskCategory').prop('disabled', false);
                    $('#entity, #operationalModel').prop('disabled', true);
                    break;
                default:
                    $('#entity, #operationalModel, #riskCategory').prop('disabled', false);
            }
        });

        // Trigger change event on page load to set initial state
        $('#initialCriteria').trigger('change');

        // Export to Excel button handler
        $('#exportExcel').on('click', function() {
            var formData = $('#reportForm').serialize();
            formData += '&export=excel';

            // Create a temporary form and submit
            var form = $('<form>', {
                method: 'post',
                action: 'risk_register_export.php'
            });

            // Add form data as hidden fields
            var params = new URLSearchParams(formData);
            for (let [key, value] of params) {
                form.append($('<input>', {
                    type: 'hidden',
                    name: key,
                    value: value
                }));
            }

            // Submit form to download file
            $('body').append(form);
            form.submit();
            form.remove();
        });

        // Export to PDF button handler
        $('#exportPDF').on('click', function() {
            var formData = $('#reportForm').serialize();
            formData += '&export=pdf';

            // Create a temporary form and submit
            var form = $('<form>', {
                method: 'post',
                action: 'risk_register_export.php',
                target: '_blank'
            });

            // Add form data as hidden fields
            var params = new URLSearchParams(formData);
            for (let [key, value] of params) {
                form.append($('<input>', {
                    type: 'hidden',
                    name: key,
                    value: value
                }));
            }

            // Submit form to open PDF in new tab
            $('body').append(form);
            form.submit();
            form.remove();
        });
    });
</script>

</body>

<style>
    .mt-4 {
        margin-top: 1.0rem !important;
        margin-bottom: 1.0rem !important;
    }

    .bg-orange {
        background-color: #ff4700 !important;
    }

    #riskRegisterTable {
        min-width: 2000px;
    }

    #riskRegisterTable th,
    #riskRegisterTable td {
        min-width: 120px;
        vertical-align: top;
        padding: 8px 4px;
        font-size: 11px;
    }

    #riskRegisterTable th:nth-child(1),
    #riskRegisterTable td:nth-child(1) { min-width: 80px; } /* Risk ID */
    #riskRegisterTable th:nth-child(4),
    #riskRegisterTable td:nth-child(4) { min-width: 250px; } /* Risk Description */
    #riskRegisterTable th:nth-child(6),
    #riskRegisterTable td:nth-child(6) { min-width: 200px; } /* Cause */
    #riskRegisterTable th:nth-child(7),
    #riskRegisterTable td:nth-child(7) { min-width: 200px; } /* Consequence */
    #riskRegisterTable th:nth-child(11),
    #riskRegisterTable td:nth-child(11) { min-width: 250px; } /* Existing Controls */
    #riskRegisterTable th:nth-child(18),
    #riskRegisterTable td:nth-child(18) { min-width: 250px; } /* Action Plan */

    .table-responsive {
        max-height: 600px;
        overflow-y: auto;
    }
</style>
</html>