<?php
include_once'./department/departmentClass.php';

// Initialize classes
$departmentClass = new departmentClass();
$showdept = $departmentClass->showDept();
?>

<!DOCTYPE html>
<html lang="en">
<?php include_once'../layout/header.php'; ?>

<style>
    .upload-area {
        border: 2px dashed #ccc;
        border-radius: 10px;
        width: 100%;
        padding: 40px;
        text-align: center;
        margin: 20px 0;
        background-color: #f8f9fa;
    }
    .upload-area:hover {
        border-color: #007bff;
        background-color: #e3f2fd;
    }
    .file-info {
        background-color: #e8f5e8;
        padding: 15px;
        border-radius: 5px;
        margin: 10px 0;
    }
    .progress-bar {
        width: 100%;
        background-color: #e0e0e0;
        border-radius: 5px;
        overflow: hidden;
        margin: 10px 0;
    }
    .progress {
        height: 20px;
        background-color: #28a745;
        width: 0%;
        transition: width 0.3s ease;
    }
    .validation-error {
        color: #dc3545;
        font-size: 0.9em;
        margin: 5px 0;
    }
    .success-item {
        color: #28a745;
        padding: 5px 0;
    }
    .error-item {
        color: #dc3545;
        padding: 5px 0;
    }
</style>

<body>
<div id="app">
    <div id="main" class="layout-horizontal">
        <?php include_once'../layout/nav.php'; ?>

        <div class="content-wrapper container">
            <div class="page-heading">
                <center><h4>BULK RISK REGISTER UPLOAD</h4></center>
            </div>

            <div class="page-content">
                <section class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Upload Risk Register Excel Files</h5>
                                <p class="text-muted">Upload multiple Excel files containing risk register data. Supported format: .xlsx, .xls</p>
                            </div>

                            <div class="card-body">
                                <!-- Upload Form -->
                                <form id="bulkUploadForm" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class="form-label">Select Department/Entity:</label>
                                            <select class="form-select choices" name="department_id" id="department_id" required>
                                                <option value="">Choose Department...</option>
                                                <?php foreach($showdept as $dept): ?>
                                                    <option value="<?=$dept['dept_id']?>"><?=$dept['dept_name']?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Upload Type:</label>
                                            <select class="form-select" name="upload_type" id="upload_type" required>
                                                <option value="">Choose Upload Type...</option>
                                                <option value="risks">Risks Only</option>
                                                <option value="complete">Complete Risk Register</option>
                                                <option value="controls">Controls & Actions</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="upload-area" id="uploadArea">
                                        <i class="bi bi-cloud-upload" style="font-size: 48px; color: #ccc;"></i>
                                        <h5>Drag and drop Excel files here or click to browse</h5>
                                        <p class="text-muted">Supported formats: .xlsx, .xls, .csv (Max: 10MB per file)</p>
                                        <input type="file" name="excel_files[]" id="excelFiles" multiple accept=".xlsx,.xls,.csv" style="display: none;">
                                        <button type="button" class="btn btn-outline-primary" onclick="document.getElementById('excelFiles').click();">
                                            <i class="bi bi-folder2-open"></i> Browse Files
                                        </button>
                                    </div>

                                    <div id="fileList" class="mt-3"></div>

                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="validateOnly" name="validate_only">
                                                <label class="form-check-label" for="validateOnly">
                                                    Validate Only (Don't Save Data)
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 text-end">
                                            <button type="button" class="btn btn-secondary me-2" id="downloadTemplate">
                                                <i class="bi bi-download"></i> Download Template
                                            </button>
                                            <button type="submit" class="btn btn-primary" id="uploadBtn" disabled>
                                                <i class="bi bi-upload"></i> Process Upload
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                <!-- Progress Section -->
                                <div id="progressSection" style="display: none;">
                                    <hr>
                                    <h6>Processing Files...</h6>
                                    <div class="progress-bar">
                                        <div class="progress" id="uploadProgress"></div>
                                    </div>
                                    <div id="currentFile" class="text-muted"></div>
                                </div>

                                <!-- Results Section -->
                                <div id="resultsSection" style="display: none;">
                                    <hr>
                                    <h6>Upload Results</h6>
                                    <div id="uploadResults"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>

<?php include_once'../layout/footer.php'; ?>

<script src="../assets/vendors/choices.js/choices.min.js"></script>
<script src="../assets/js/pages/form-element-select.js"></script>
<script src="../assets/vendors/sweetalert2/sweetalert2.all.min.js"></script>

<script>
    $(document).ready(function() {
        let selectedFiles = [];

        // File selection handling
        $('#excelFiles').on('change', function() {
            handleFileSelection(this.files);
        });

        // Drag and drop handling
        $('#uploadArea').on('dragover', function(e) {
            e.preventDefault();
            $(this).addClass('border-primary');
        });

        $('#uploadArea').on('dragleave', function(e) {
            e.preventDefault();
            $(this).removeClass('border-primary');
        });

        $('#uploadArea').on('drop', function(e) {
            e.preventDefault();
            $(this).removeClass('border-primary');
            handleFileSelection(e.originalEvent.dataTransfer.files);
        });

        function handleFileSelection(files) {
            selectedFiles = Array.from(files);
            displayFileList();
            $('#uploadBtn').prop('disabled', selectedFiles.length === 0);
        }

        function displayFileList() {
            let html = '<div class="mt-3"><h6>Selected Files:</h6>';
            selectedFiles.forEach((file, index) => {
                const size = (file.size / 1024 / 1024).toFixed(2);
                html += `
                    <div class="file-info d-flex justify-content-between align-items-center">
                        <div>
                            <strong>${file.name}</strong>
                            <span class="text-muted">(${size} MB)</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeFile(${index})">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                `;
            });
            html += '</div>';
            $('#fileList').html(html);
        }

        window.removeFile = function(index) {
            selectedFiles.splice(index, 1);
            displayFileList();
            $('#uploadBtn').prop('disabled', selectedFiles.length === 0);
        };

        // Form submission
        $('#bulkUploadForm').on('submit', function(e) {
            e.preventDefault();

            if (!$('#department_id').val() || !$('#upload_type').val()) {
                Swal.fire('Error', 'Please select department and upload type', 'error');
                return;
            }

            const formData = new FormData();
            formData.append('uid', $('input[name="uid"]').val());
            formData.append('ip', $('input[name="ip"]').val());
            formData.append('department_id', $('#department_id').val());
            formData.append('upload_type', $('#upload_type').val());
            formData.append('validate_only', $('#validateOnly').is(':checked') ? 1 : 0);

            selectedFiles.forEach(file => {
                formData.append('excel_files[]', file);
            });

            processUpload(formData);
        });

        function processUpload(formData) {
            $('#progressSection').show();
            $('#resultsSection').hide();
            $('#uploadBtn').prop('disabled', true);

            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 20;
                if (progress > 90) progress = 90;
                $('#uploadProgress').css('width', progress + '%');
            }, 500);

            $.ajax({
                url: 'process_bulk_upload.php',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    clearInterval(progressInterval);
                    $('#uploadProgress').css('width', '100%');

                    setTimeout(() => {
                        displayResults(response);
                        $('#uploadBtn').prop('disabled', false);
                    }, 1000);
                },
                error: function(xhr, status, error) {
                    clearInterval(progressInterval);
                    Swal.fire('Error', 'Upload failed: ' + error, 'error');
                    $('#uploadBtn').prop('disabled', false);
                }
            });
        }

        function displayResults(response) {
            $('#progressSection').hide();
            $('#resultsSection').show();

            try {
                const results = JSON.parse(response);
                let html = '<div class="row">';

                // Summary
                html += `
                    <div class="col-md-6">
                        <div class="card border-success">
                            <div class="card-body text-center">
                                <h5 class="text-success">Successful</h5>
                                <h2 class="text-success">${results.summary.success}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-danger">
                            <div class="card-body text-center">
                                <h5 class="text-danger">Failed</h5>
                                <h2 class="text-danger">${results.summary.failed}</h2>
                            </div>
                        </div>
                    </div>
                `;

                html += '</div><hr>';

                // Detailed results
                if (results.details && results.details.length > 0) {
                    html += '<h6>Detailed Results:</h6>';
                    results.details.forEach(detail => {
                        const statusClass = detail.status === 'success' ? 'success-item' : 'error-item';
                        html += `<div class="${statusClass}"><strong>${detail.file}:</strong> ${detail.message}</div>`;
                    });
                }

                $('#uploadResults').html(html);

                if (results.summary.success > 0) {
                    Swal.fire('Success', `Successfully processed ${results.summary.success} files`, 'success');
                }

            } catch (e) {
                $('#uploadResults').html('<div class="alert alert-danger">Error processing response</div>');
            }
        }

        // Download template
        $('#downloadTemplate').on('click', function() {
            window.location.href = 'download_template.php?type=' + $('#upload_type').val();
        });
    });
</script>
</body>
</html>