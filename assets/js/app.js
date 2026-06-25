/**
 * app.js — GRC V1 unified AJAX handlers
 * Replaces mine.js and all inline <script> blocks across 52 PHP view files.
 * Loaded via layout/footer.php on every authenticated page.
 * Session values are available via window.GRC (set in layout/header.php).
 *
 * Sections:
 *  1  Company
 *  2  Entity / Department
 *  3  Process
 *  4  Users
 *  5  Impact
 *  6  Likelihood
 *  7  Risk Category
 *  8  Control Type
 *  9  Control Strength
 *  10 Risk
 *  11 Control
 *  12 Entity Dashboard (entity.php)
 *  13 KRI & Performance
 *  14 KPI & BSC / Objectives
 *  15 Actions
 *  16 Recommendations
 *  17 Incidents
 *  18 Approval & Inbox
 *  19 Profile & Permissions
 *  20 Bulk Upload (inline script kept in bulk_risk_upload.php)
 */

// ─────────────────────────────────────────────────────────────────────────────
// Shared helpers
// ─────────────────────────────────────────────────────────────────────────────

function grcToast(r) {
    Toastify({
        text: r.message,
        duration: 2500,
        close: true,
        gravity: 'top',
        position: 'center',
        backgroundColor: r.status === 'ok' ? '#4fbe87' : '#f0470d',
    }).showToast();
}

function grcSwal(r, delay, redirect) {
    Swal.fire({
        icon: r.status === 'ok' ? 'success' : 'error',
        title: r.message,
        timer: delay
    });
    window.setTimeout(function () { window.location.href = redirect; }, delay);
}

function grcSwalReload(r, delay) {
    Swal.fire({
        icon: r.status === 'ok' ? 'success' : 'error',
        title: r.message,
        timer: delay
    });
    window.setTimeout(function () { window.location.reload(); }, delay);
}

// ─────────────────────────────────────────────────────────────────────────────
// Datepicker initialisation (harmless on pages that lack the elements)
// ─────────────────────────────────────────────────────────────────────────────

$(function () {
    var dpOpts = { dateFormat: 'yy-mm-dd' };
    $('#datepicker').datepicker(dpOpts);
    $('#datepicker2').datepicker(dpOpts);
    $('#datepicker3').datepicker(dpOpts);
    $('#datepicker4').datepicker(dpOpts);
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 1 — Company
// ─────────────────────────────────────────────────────────────────────────────

// bussinf.php — fetch company for edit modal
$(document).ready(function () {
    $(document).on('click', '.editcompany', function (e) {
        e.preventDefault();
        var companyid = $(this).attr('id');
        $.ajax({
            url: 'editcompany.php',
            method: 'POST',
            data: { companyid: companyid },
            dataType: 'json',
            success: function (data) {
                $('#companyid').val(data.id);
                $('#cuname').val(data.company_name);
                $('#cugroup').val(data.cgroup);
                $('#cuemail').val(data.email);
                $('#cuphone').val(data.phone);
                $('#cuwebsite').val(data.website);
                $('#cuaddress').val(data.address);
                $('#editcompany-modal').modal('show');
            }
        });
    });
});

// bussinf.php — update company
$(document).on('click', '.updatecompanybtn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'companyupdate.php',
        method: 'POST',
        data: $('#companyupdateform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'bussinf.php'); }
    });
});

// companylist.php — fetch company for edit modal
$(document).on('click', '.edit-button', function (e) {
    e.preventDefault();
    var companyid = $(this).attr('id');
    $.ajax({
        url: 'editcompanylist',
        method: 'POST',
        data: { companyid: companyid },
        dataType: 'json',
        success: function (data) {
            $('#cid').val(data.id);
            $('#cname').val(data.company_name);
            $('#email').val(data.email);
            $('#phone').val(data.phone);
            $('#website').val(data.website);
            $('#address').val(data.address);
            $('#editcompany-modal').modal('show');
        }
    });
});

// companylist.php — update company
$(document).on('click', '.update', function (e) {
    if (!$('#formupdate').length || !$('.edit-button').length) return;
    e.preventDefault();
    $.ajax({
        url: 'companyupdate.php',
        method: 'POST',
        data: $('#formupdate').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'companylist.php'); }
    });
});

// companylist.php — fetch company for delete modal
$(document).on('click', '.delete-button', function (e) {
    e.preventDefault();
    var companyid = $(this).attr('id');
    $.ajax({
        url: 'editcompanylist',
        method: 'POST',
        data: { companyid: companyid },
        dataType: 'json',
        success: function (data) {
            $('#dcid').val(data.id);
            $('#dcname').html(data.company_name);
            $('#delete-modal').modal('show');
        }
    });
});

// companylist.php — confirm delete
$(document).on('click', '.delete-btn', function (e) {
    if (!$('.delete-button').length) return;
    e.preventDefault();
    $.ajax({
        url: 'companydelete.php',
        method: 'POST',
        data: $('#deleteform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'companylist.php'); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 2 — Entity / Department
// ─────────────────────────────────────────────────────────────────────────────

// Validation helpers (bussinf add entity form)
function checkentname() {
    var v = $('#entityname').val();
    if (v === '') { $('#entity_err').html('required field'); return false; }
    $('#entity_err').html(''); return true;
}
function checkcompany() {
    var v = $('#entcomp').val();
    if (v === '') { $('#company_err').html('required field'); return false; }
    $('#company_err').html(''); return true;
}
function checkowner() {
    var v = $('#entowner').val();
    if (v === '') { $('#owner_err').html('required field'); return false; }
    $('#owner_err').html(''); return true;
}

// bussinf.php — fetch entity for edit modal
$(document).on('click', '.editentity', function (e) {
    e.preventDefault();
    var deptid = $(this).attr('id');
    $.ajax({
        url: 'departmentedit.php',
        method: 'post',
        data: { deptid: deptid },
        dataType: 'json',
        success: function (data) {
            $('#eid').val(data.dept_id);
            $('#ename').val(data.dept_name);
            $('#company').val(data.company);
            $('#owner').val(data.owner);
            $('#function').val(data.function);
            $('#editdept-modal').modal('show');
        }
    });
});

// entitylist.php — fetch entity for edit modal
$(document).on('click', '.edit-dept', function (e) {
    e.preventDefault();
    var deptid = $(this).attr('id');
    $.ajax({
        url: 'departmentedit.php',
        method: 'post',
        data: { deptid: deptid },
        dataType: 'json',
        success: function (data) {
            $('#eid').val(data.dept_id);
            $('#ename').val(data.dept_name);
            $('#company').val(data.company);
            $('#owner').val(data.owner);
            $('#function').val(data.function);
            $('#editdept-modal').modal('show');
        }
    });
});

// Both bussinf + entitylist — update entity (redirect differs by referring page)
$(document).on('click', '.deptupdate', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('entitylist') !== -1 ? 'entitylist.php' : 'bussinf.php';
    $.ajax({
        url: 'departmentupdate.php',
        method: 'post',
        data: $('#deptupdate').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Both — fetch entity for delete modal
$(document).on('click', '.delete-dept', function (e) {
    e.preventDefault();
    var deptid = $(this).attr('id');
    $.ajax({
        url: 'departmentedit.php',
        method: 'post',
        data: { deptid: deptid },
        dataType: 'json',
        success: function (data) {
            $('#entityid').val(data.dept_id);
            $('#entname').html(data.dept_name);
            $('#deptdelete-modal').modal('show');
        }
    });
});

// bussinf.php — confirm entity delete
$(document).on('click', '.delete-btn', function (e) {
    if (!$('#entitydeleteform').length) return;
    e.preventDefault();
    $.ajax({
        url: 'departmentdelete.php',
        method: 'post',
        data: $('#entitydeleteform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1100, 'bussinf.php'); }
    });
});

// entitylist.php — confirm entity delete
$(document).on('click', '.delete-btn', function (e) {
    if (!$('.edit-dept').length) return;
    e.preventDefault();
    $.ajax({
        url: 'departmentdelete.php',
        method: 'post',
        data: $('#deleteform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1100, 'entitylist.php'); }
    });
});

// bussinf.php — open add entity modal
$(document).on('click', '.addentitybtn', function (e) {
    e.preventDefault();
    $('#addentity-modal').modal('show');
});

// bussinf.php — add entity
$(document).on('click', '.addentity', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'addentity.php', method: 'post', data: $('#entityform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 600, 'bussinf.php'); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 3 — Process
// ─────────────────────────────────────────────────────────────────────────────

function checkpentity() {
    var v = $('#pentity').val();
    if (v === '') { $('#pentity_err').html('required field'); return false; }
    $('#pentity_err').html(''); return true;
}
function checkprocess() {
    var v = $('#processname').val();
    if (v === '') { $('#process_err').html('required field'); return false; }
    $('#process_err').html(''); return true;
}

$('#pentity').on('change', function () { checkpentity(); });
$('#processname').on('input', function () { checkprocess(); });

// bussinf.php — open add process modal
$(document).on('click', '.addprocessmodal', function (e) {
    e.preventDefault();
    $('#addprocess-modal').modal('show');
});

// bussinf.php + addprocess.php — add process
// .addprocessmodal button only exists on bussinf; standalone addprocess.php lacks it.
$(document).on('click', '.addprocess', function (e) {
    e.preventDefault();
    var onBussinf = $('.addprocessmodal').length > 0;
    if (onBussinf && (!checkpentity() || !checkprocess())) {
        $('#processmessage').html('<div class="alert alert-warning">Please fill all required fields</div>');
        return;
    }
    var redirect = onBussinf ? 'bussinf.php' : 'processlist.php';
    $.ajax({
        url: 'processAction.php',
        method: 'post',
        data: $('#processform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch process for edit modal (bussinf + processlist)
$(document).on('click', '.editprocess', function (e) {
    e.preventDefault();
    var processid = $(this).attr('id');
    $.ajax({
        url: 'processedit.php',
        method: 'POST',
        data: { processid: processid },
        dataType: 'json',
        success: function (data) {
            $('#pid').val(data.process_id);
            $('#entityprocess, #entity').val(data.dept_id);
            $('#pname').val(data.process_name);
            $('#detail').val(data.details);
            $('#editprocess-modal, #edit-modal').modal('show');
        }
    });
});

// bussinf.php — update process
$(document).on('click', '.updateprocess', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('processlist') !== -1 ? 'processlist.php' : 'bussinf.php';
    var form = $('#formprocessupdate').length ? '#formprocessupdate' : '#formupdate';
    $.ajax({
        url: 'processupdate.php',
        method: 'POST',
        data: $(form).serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch process for delete modal (bussinf + processlist)
$(document).on('click', '.processdelete', function (e) {
    e.preventDefault();
    var processid = $(this).attr('id');
    $.ajax({
        url: 'processedit.php',
        method: 'POST',
        data: { processid: processid },
        dataType: 'json',
        success: function (data) {
            $('#pdid').val(data.process_id);
            $('#pdname').html(data.process_name);
            $('#deleteprocess-modal, #delete-modal').modal('show');
        }
    });
});

// bussinf.php — confirm process delete
$(document).on('click', '.deleteprocess-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'processdelete.php',
        method: 'POST',
        data: $('#deleteprocessform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'bussinf.php'); }
    });
});

// processlist.php — confirm process delete
$(document).on('click', '.delete-btn', function (e) {
    if (!$('.processdelete').length) return;
    e.preventDefault();
    $.ajax({
        url: 'processdelete.php',
        method: 'POST',
        data: $('#deleteform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'processlist.php'); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 4 — Users
// ─────────────────────────────────────────────────────────────────────────────

// bussinf.php — open add user modal
$(document).on('click', '.addusermodal', function (e) {
    e.preventDefault();
    $('#users-modal').modal('show');
});

// bussinf.php — add user
$(document).on('click', '.addusers-button', function (e) {
    e.preventDefault();
    $.ajax({
        type: 'post',
        url: 'usersaction.php',
        data: $('#usersform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'bussinf.php'); }
    });
});

// usersadd.php — handled by assets/js/usermanagement.js (includes validation)

// Generic fetchprocess — fills whichever risk dropdown this page owns.
// entity.php covers #crisk and #arisk via separate controlprocess/actiondrop calls.
function fetchprocess(id) {
    var $t = $('#editrisk').length   ? $('#editrisk')   :
             $('#selectrisk').length ? $('#selectrisk') :
             $('#arisk').length      ? $('#arisk')      :
             $('#crisk').length      ? $('#crisk')      :
             $('#rmdrisk').length    ? $('#rmdrisk')    : null;
    if (!$t) return;
    $.ajax({
        type: 'post',
        url: 'processfetch.php',
        data: { processid: id },
        success: function (data) { $t.html(data); }
    });
}

// ─────────────────────────────────────────────────────────────────────────────
// Section 5 — Impact
// ─────────────────────────────────────────────────────────────────────────────

function checkimpname() {
    var v = $('#impname').val();
    if (v === '') { $('#impname_err').html('required field'); return false; }
    $('#impname_err').html(''); return true;
}
function checkimplevel() {
    var v = $('#implevel').val();
    if (v === '') { $('#implevel_err').html('required field'); return false; }
    $('#implevel_err').html(''); return true;
}

// Open add impact modal (bussinf + impact.php)
$(document).on('click', '.addimpactmodal', function (e) {
    e.preventDefault();
    $('#addimpact-modal').modal('show');
});
$(document).on('click', '.addimpact', function (e) {
    e.preventDefault();
    $('#addimpact-modal').modal('show');
});

// Add impact
$(document).on('click', '.addimpact-btn', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('impact.php') !== -1 ? 'impact.php' : 'bussinf.php';
    $.ajax({
        type: 'post',
        url: 'addimpact.php',
        data: $('#addimpactform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch impact for edit modal
$(document).on('click', '.editimpact', function (e) {
    e.preventDefault();
    var impactid = $(this).attr('id');
    $.ajax({
        url: 'impactedit.php',
        method: 'POST',
        data: { impactid: impactid },
        dataType: 'json',
        success: function (data) {
            $('#iid').val(data.id);
            $('#name').val(data.name);
            $('#level').val(data.level);
            $('#impactdesc, #descimp').val(data.description);
            $('#editimpact').modal('show');
        }
    });
});

// Update impact
$(document).on('click', '.updateimpact', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('impact.php') !== -1 ? 'impact.php' : 'bussinf.php';
    $.ajax({
        url: 'impactupdate.php',
        method: 'POST',
        data: $('#impactupdateform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch impact for delete modal
$(document).on('click', '.deleteimpact', function (e) {
    e.preventDefault();
    var impactid = $(this).attr('id');
    $.ajax({
        url: 'impactdelupdate.php',
        method: 'POST',
        data: { impactid: impactid },
        dataType: 'json',
        success: function (data) {
            $('#impdelete').val(data.id);
            $('#impdcname').html(data.name);
            $('#dcname').html(data.name);
            $('#delete-modal').modal('show');
        }
    });
});

// bussinf.php — confirm impact delete
$(document).on('click', '.delete-btn', function (e) {
    if (!$('.deleteimpact').length) return;
    e.preventDefault();
    var redirect = window.location.href.indexOf('impact.php') !== -1 ? 'impact.php' : 'bussinf.php';
    var form = $('#impdeleteform').length ? '#impdeleteform' : '#deleteform';
    $.ajax({
        url: 'impactdelete.php',
        method: 'POST',
        data: $(form).serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 6 — Likelihood
// ─────────────────────────────────────────────────────────────────────────────

// Open add likelihood modal
$(document).on('click', '.addlikely', function (e) {
    e.preventDefault();
    $('#addlikely-modal').modal('show');
});

// Add likelihood
$(document).on('click', '.addlikely-btn', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('likelihood.php') !== -1 ? 'likelihood.php' : 'bussinf.php';
    $.ajax({
        type: 'post',
        url: 'addlikelihood.php',
        data: $('#addlikelyform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch likelihood for edit modal
$(document).on('click', '.editlikelihood, .editlikely', function (e) {
    e.preventDefault();
    var likelyid = $(this).attr('id');
    $.ajax({
        url: 'likelyedit.php',
        method: 'POST',
        data: { likelyid: likelyid },
        dataType: 'json',
        success: function (data) {
            $('#lid').val(data.id);
            $('#likelyname, #name').val(data.name);
            $('#likelylevel, #level').val(data.level);
            $('#ldesc').val(data.description);
            $('#editlikelihood-modal, #editlikely-modal').modal('show');
        }
    });
});

// Update likelihood
$(document).on('click', '.updatelikely', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('likelihood.php') !== -1 ? 'likelihood.php' : 'bussinf.php';
    $.ajax({
        url: 'likelyupdate.php',
        method: 'POST',
        data: $('#likelyupdateform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch likelihood for delete modal
$(document).on('click', '.deletelikely', function (e) {
    e.preventDefault();
    var likelyid = $(this).attr('id');
    $.ajax({
        url: 'likelydelupdate.php',
        method: 'POST',
        data: { likelyid: likelyid },
        dataType: 'json',
        success: function (data) {
            $('#ldelete').val(data.id);
            $('#ldcname, #dcname').html(data.name);
            $('#delete-modal').modal('show');
        }
    });
});

// Confirm likelihood delete (bussinf uses .lklydelete-btn, likelihood.php uses .delete-btn)
$(document).on('click', '.lklydelete-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'likelydelete.php',
        method: 'POST',
        data: $('#ldeleteform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'bussinf.php'); }
    });
});
$(document).on('click', '.delete-btn', function (e) {
    if (!$('.deletelikely').length) return;
    e.preventDefault();
    $.ajax({
        url: 'likelydelete.php',
        method: 'POST',
        data: $('#deleteform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'likelihood.php'); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 7 — Risk Category
// ─────────────────────────────────────────────────────────────────────────────

// Open add risk category modal
$(document).on('click', '.addriskcat', function (e) {
    e.preventDefault();
    if ($('#addentrisk-modal').length) return; // riskstatus add-risk, handled in s18
    $('#riskcat-modal').modal('show');
});

// Add risk category
$(document).on('click', '.addriskcat-btn', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('riskcat.php') !== -1 ? 'riskcat.php' : 'bussinf.php';
    $.ajax({
        type: 'post',
        url: 'riskcatAction.php',
        data: $('#addriskcatform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch risk category for edit modal
$(document).on('click', '.editriskcat', function (e) {
    e.preventDefault();
    var rcid = $(this).attr('id');
    $.ajax({
        url: 'riskcatedit.php',
        method: 'POST',
        data: { rcid: rcid },
        dataType: 'json',
        success: function (data) {
            $('#rcid').val(data.riskcat_id);
            $('#riskcatname').val(data.name);
            $('#rcedesc, #rcdesc').val(data.description);
            $('#editriskcat-modal').modal('show');
        }
    });
});

// Update risk category
$(document).on('click', '.updateriskcat', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('riskcat.php') !== -1 ? 'riskcat.php' : 'bussinf.php';
    $.ajax({
        url: 'riskcatupdate.php',
        method: 'POST',
        data: $('#riskcatupdateform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch risk category for delete modal
$(document).on('click', '.deleteriskcat', function (e) {
    e.preventDefault();
    var rcid = $(this).attr('id');
    $.ajax({
        url: 'riskcatedit.php',
        method: 'POST',
        data: { rcid: rcid },
        dataType: 'json',
        success: function (data) {
            $('#rcdelete').val(data.riskcat_id);
            $('#dcname').html(data.name);
            $('#delete-modal').modal('show');
        }
    });
});

// Confirm risk category delete
$(document).on('click', '.riskcatdelete-btn', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('riskcat.php') !== -1 ? 'riskcat.php' : 'bussinf.php';
    var form = $('#rcdeleteform').length ? '#rcdeleteform' : '#deleteform';
    $.ajax({
        url: 'riskcatdelete.php',
        method: 'POST',
        data: $(form).serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 8 — Control Type
// ─────────────────────────────────────────────────────────────────────────────

// Open add control type modal
$(document).on('click', '.addct', function (e) {
    e.preventDefault();
    $('#addct-modal').modal('show');
});

// Add control type
$(document).on('click', '.addct-btn', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('controltype.php') !== -1 ? 'controltype.php' : 'bussinf.php';
    $.ajax({
        type: 'post',
        url: 'addcontroltype.php',
        data: $('#addctform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch control type for edit modal
$(document).on('click', '.editct', function (e) {
    e.preventDefault();
    var ctid = $(this).attr('id');
    $.ajax({
        url: 'ctedit.php',
        method: 'POST',
        data: { ctid: ctid },
        dataType: 'json',
        success: function (data) {
            $('#ctid').val(data.ctype_id);
            $('#ctypename').val(data.ct_name);
            $('#ctedesc').val(data.description).html(data.description);
            $('#editctype-modal').modal('show');
        }
    });
});

// Update control type
$(document).on('click', '.updatect', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('controltype.php') !== -1 ? 'controltype.php' : 'bussinf.php';
    $.ajax({
        url: 'ctupdate.php',
        method: 'POST',
        data: $('#ctupdateform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch control type for delete modal
$(document).on('click', '.deletect', function (e) {
    e.preventDefault();
    var ctid = $(this).attr('id');
    $.ajax({
        url: 'ctedit.php',
        method: 'POST',
        data: { ctid: ctid },
        dataType: 'json',
        success: function (data) {
            $('#ctdelete').val(data.ctype_id);
            $('#name').html(data.ct_name);
            $('#ctdelete-modal').modal('show');
        }
    });
});

// Confirm control type delete
$(document).on('click', '.ctypedelete-btn, .ctdelete-btn', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('controltype.php') !== -1 ? 'controltype.php' : 'bussinf.php';
    var form = $('#ctypedeleteform').length ? '#ctypedeleteform' : '#deleteform';
    $.ajax({
        url: 'ctdelete.php',
        method: 'POST',
        data: $(form).serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 9 — Control Strength
// ─────────────────────────────────────────────────────────────────────────────

// Open add control strength modal
$(document).on('click', '.addcs', function (e) {
    e.preventDefault();
    $('#addcs-modal').modal('show');
});

// Add control strength
$(document).on('click', '.addcs-btn', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('controlstrength.php') !== -1 ? 'controlstrength.php' : 'bussinf.php';
    $.ajax({
        type: 'post',
        url: 'addcontrolstrength.php',
        data: $('#addcsform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch control strength for edit modal
$(document).on('click', '.editcs', function (e) {
    e.preventDefault();
    var csid = $(this).attr('id');
    $.ajax({
        url: 'csedit.php',
        method: 'POST',
        data: { csid: csid },
        dataType: 'json',
        success: function (data) {
            $('#csid').val(data.strength_id);
            $('#csname').val(data.cs_name);
            $('#csdesc').val(data.description);
            $('#editcs-modal').modal('show');
        }
    });
});

// Update control strength
$(document).on('click', '.updatecs', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('controlstrength.php') !== -1 ? 'controlstrength.php' : 'bussinf.php';
    $.ajax({
        url: 'csupdate.php',
        method: 'POST',
        data: $('#editcsform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// Fetch control strength for delete modal
$(document).on('click', '.deletecs', function (e) {
    e.preventDefault();
    var csid = $(this).attr('id');
    $.ajax({
        url: 'csedit.php',
        method: 'POST',
        data: { csid: csid },
        dataType: 'json',
        success: function (data) {
            $('#csdelete').val(data.strength_id);
            $('#dcname').html(data.cs_name);
            $('#csdelete-modal').modal('show');
        }
    });
});

// Confirm control strength delete
$(document).on('click', '.csdelete-btn', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('controlstrength.php') !== -1 ? 'controlstrength.php' : 'bussinf.php';
    var form = $('#csdeleteform').length ? '#csdeleteform' : '#deleteform';
    $.ajax({
        url: 'csdelete.php',
        method: 'POST',
        data: $(form).serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 10 — Risk
// ─────────────────────────────────────────────────────────────────────────────

// addrisk.php + entity.php — add risk
$(document).on('click', '.addrisk', function (e) {
    e.preventDefault();
    if ($('#addrisk-modal').length) { $('#addrisk-modal').modal('show'); return; }
    $.ajax({
        method: 'post',
        url: 'riskAction.php',
        data: $('#riskform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'risklist.php'); }
    });
});

// addrisk.php — quick add risk category via modal
$(document).on('click', '.rcategory', function (e) {
    e.preventDefault();
    $('#rcategory-modal').modal('show');
});
$(document).on('click', '.add-rcat', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'riskcatAction.php',
        method: 'POST',
        data: $('#riskcat').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'addrisk.php'); }
    });
});

// addrisk.php — quick add process via modal
$(document).on('click', '.process', function (e) {
    e.preventDefault();
    $('#process-modal').modal('show');
});
$(document).on('click', '.add-process', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'processAction.php',
        method: 'POST',
        data: $('#process').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'addrisk.php'); }
    });
});

// risklist.php — fetch risk for edit modal
$(document).on('click', '.edit-risk', function (e) {
    e.preventDefault();
    var rid = $(this).attr('id');
    $.ajax({
        url: 'riskedit.php',
        method: 'post',
        data: { rid: rid },
        dataType: 'json',
        success: function (data) {
            $('#dept_id').val(data.dept);
            $('#risk_id').val(data.risk_id);
            $('#process_id').val(data.process);
            $('#inherent').val(data.risk_name);
            $('#rcat').val(data.rcat);
            $('#nominee').val(data.nominee);
            $('#cause').val(data.cause);
            $('#reviewer').val(data.reviewer);
            $('#datepicker').val(data.rdate);
            $('#editrisk-modal').modal('show');
        }
    });
});

// risklist.php — submit risk edit
$(document).on('click', '.editriskbutton', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'riskeditAction.php',
        method: 'post',
        data: $('#editriskform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 5500, 'risklist.php'); }
    });
});

// risklist + risktop — fetch risk for delete modal
$(document).on('click', '.delete-risk', function (e) {
    e.preventDefault();
    var riskid = $(this).attr('id');
    $.ajax({
        url: 'riskdelupdate.php',
        method: 'post',
        data: { riskid: riskid },
        dataType: 'json',
        success: function (data) {
            $('#dcid').val(data.risk_id);
            $('#dcname').html(data.risk_name);
            $('#delete-modal').modal('show');
        }
    });
});

// risklist + risktop — confirm risk delete
$(document).on('click', '.delete-btn', function (e) {
    if (!$('.delete-risk').length) return;
    e.preventDefault();
    var redirect = window.location.href.indexOf('risktop') !== -1 ? 'risk.php' : 'risklist.php';
    $.ajax({
        url: 'riskdelete.php',
        method: 'post',
        data: $('#deleteform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// riskassessadd.php — fetch risk dept on change
function fetchrisk(id) {
    $.ajax({
        type: 'post',
        url: 'riskfetch.php',
        data: { riskid: id },
        dataType: 'json',
        success: function (data) { $('#riskdept').val(data.dept); }
    });
}

// riskassessadd.php — submit assessment
$(document).on('click', '.addassess', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'riskassessaction.php',
        method: 'post',
        data: $('#addassessform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 600, 'riskassess.php'); }
    });
});

// riskassessedit.php — fetch control residual
function fetchcontrol(id) {
    $.ajax({
        type: 'post',
        url: 'residual.php',
        data: { controlid: id },
        dataType: 'json',
        success: function (data) {
            $('#rimp').val(data.impact);
            $('#rlikely').val(data.likelihood);
        }
    });
}

// riskassessedit.php — submit edit assessment
$(document).on('click', '.editassess', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'riskasseditaction.php',
        method: 'post',
        data: $('#addassessform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'riskassess.php'); }
    });
});

// risktreatment.php — treatment actions
$(document).on('click', '.addaccepttreat', function (e) {
    e.preventDefault();
    $.ajax({ url: 'treataccept.php', method: 'POST', data: $('#treatmentform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'risktreatment.php'); } });
});
$(document).on('click', '.addavoidtreat', function (e) {
    e.preventDefault();
    $.ajax({ url: 'treatavoid.php', method: 'POST', data: $('#treatmentavoidform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'risktreatment.php'); } });
});
$(document).on('click', '.addtransfertreat', function (e) {
    e.preventDefault();
    $.ajax({ url: 'treattransfer.php', method: 'POST', data: $('#treatmenttransferform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'risktreatment.php'); } });
});
$(document).on('click', '.addmitigatetreat', function (e) {
    e.preventDefault();
    $.ajax({ url: 'treatmitigate.php', method: 'POST', data: $('#treatmentmitigateform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'risktreatment.php'); } });
});

// Unified display(id) — called from select onchange on four pages.
// Each page calls display(this.value); URL, POST key, and target differ per page.
function display(id) {
    var href = window.location.href;
    var url, data, $target;
    if (href.indexOf('overallrisk') !== -1) {
        url = 'rcatlist.php';       data = { rcatid: id }; $target = $('#roveralldisplay');
    } else if (href.indexOf('overallcontrol') !== -1) {
        url = 'controllist.php';    data = { csid: id };   $target = $('#roveralldisplay');
    } else if (href.indexOf('riskregister') !== -1) {
        url = 'registerAction.php'; data = { dept: id };   $target = $('#display');
    } else {
        url = 'entityAction.php';   data = { deptid: id }; $target = $('#display');
    }
    $.ajax({ type: 'post', url: url, data: data,
        success: function (response) { $target.html(response); } });
}

// risk_report.php — export to Excel
$(document).on('click', '#exportExcel', function () {
    var formData = $('#reportForm').serialize() + '&export=1';
    $.ajax({
        url: 'risk_report_generate.php',
        type: 'POST',
        data: formData,
        success: function (response) {
            if (response.startsWith('Success')) {
                window.location.href = 'risk_report_download.php?file=' + response.split(':')[1];
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: response });
            }
        },
        error: function () {
            Swal.fire({ icon: 'error', title: 'Error', text: 'An error occurred while generating the report.' });
        }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 11 — Control
// ─────────────────────────────────────────────────────────────────────────────

// addcontrol.php + entity.php — add control
$(document).on('click', '.addcontrol', function (e) {
    e.preventDefault();
    if ($('#addcontrol-modal').length) { $('#addcontrol-modal').modal('show'); return; }
    $.ajax({
        url: 'controladd.php',
        method: 'post',
        data: $('#addcontrolform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 600, 'controls.php'); }
    });
});

// controls.php — fetch control for edit modal
$(document).on('click', '.editcontrol-btn', function (e) {
    e.preventDefault();
    var cid = $(this).attr('id');
    $.ajax({
        url: 'controlupdate.php',
        method: 'post',
        data: { cid: cid },
        dataType: 'json',
        success: function (data) {
            $('#cid').val(data.control_id);
            $('#cprocess').val(data.process_id);
            $('#crisk').val(data.risk);
            $('#controls').val(data.controls);
            $('#cstrength').val(data.cstrength);
            $('#ctype').val(data.ctype);
            $('#creviewer').val(data.reviewer);
            $('#datepicker2').val(data.rdate);
            $('#editcontrol-modal').modal('show');
        }
    });
});

// controls.php — submit control edit
$(document).on('click', '.updatecontrol-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'controledit.php',
        method: 'post',
        data: $('#editcontrolform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'controls.php'); }
    });
});

// editcontrols.php — submit update
$(document).on('click', '.updatecontrol', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'controledit.php',
        method: 'post',
        data: $('#controlform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'controls.php'); }
    });
});

// controls.php — fetch control for delete modal
$(document).on('click', '.delete-btn', function (e) {
    if (!$('.editcontrol-btn').length) return;
    e.preventDefault();
    var control_id = $(this).attr('id');
    if (control_id) {
        $.ajax({
            url: 'controlupdate.php',
            method: 'post',
            data: { cid: control_id },
            dataType: 'json',
            success: function (data) {
                $('#dcid').val(data.control_id);
                $('#dcname').html(data.control);
                $('#delete-modal').modal('show');
            }
        });
        return;
    }
    $.ajax({
        url: 'controldelete.php',
        method: 'post',
        data: $('#deleteform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'controls.php'); }
    });
});

// controls.php — confirm control delete
$(document).on('click', '.delete-control', function (e) {
    e.preventDefault();
    var redirect = window.location.href.indexOf('update_rcontrol') !== -1 ? 'riskassess.php' : 'controls.php';
    var url = window.location.href.indexOf('update_rcontrol') !== -1 ? 'riskcontroldelete.php' : 'controldelete.php';
    $.ajax({
        url: url,
        method: 'post',
        data: $('#deleteform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// update_rcontrol.php — add risk-control link
$(document).on('click', '.addriskcontrol', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'riskcontrolaction.php',
        method: 'post',
        data: $('#riskcontrolform').serialize(),
        dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'riskassess.php'); }
    });
});

// update_rcontrol.php — fetch control for delete modal
$(document).on('click', '.remove-control', function (e) {
    e.preventDefault();
    var control_id = $(this).attr('id');
    $.ajax({
        url: 'controlupdate.php',
        method: 'post',
        data: { cid: control_id },
        dataType: 'json',
        success: function (data) {
            $('#dcid').val(data.control_id);
            $('#dcname').html(data.control);
            $('#delete-modal').modal('show');
        }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 12 — Entity Dashboard (entity.php)
// ─────────────────────────────────────────────────────────────────────────────

// display(id) defined in Section 10 handles entity.php via entityAction.php fallback.

function controlprocess(id) {
    $.ajax({ type: 'post', url: 'processfetch.php', data: { processid: id },
        success: function (data) { $('#crisk').html(data); } });
}
function actiondrop(id) {
    $.ajax({ type: 'post', url: 'processfetch.php', data: { processid: id },
        success: function (data) { $('#arisk').html(data); } });
}
function recommendprocess(id) {
    $.ajax({ type: 'post', url: 'processfetch.php', data: { processid: id },
        success: function (data) { $('#rmdrisk').html(data); } });
}

// entity.php — open add dept modal
$(document).on('click', '.adddept', function (e) {
    e.preventDefault();
    $('#adddept-modal').modal('show');
});
$(document).on('click', '.adddeptbutton', function () {
    $.ajax({
        url: 'addentity.php', method: 'post', data: $('#adddeptform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'entity.php'); }
    });
});

// add_entity.php — add entity (standalone form)
$(document).on('click', '.addentity', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'addentity.php', method: 'post', data: $('#entityform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'entitylist.php'); }
    });
});

// entity.php — add risk from entity dashboard
$(document).on('click', '.addrisksbutton', function (e) {
    e.preventDefault();
    if ($('#addriskform').length) {
        $.ajax({
            url: 'riskAction.php', method: 'post', data: $('#addriskform').serialize(), dataType: 'json',
            success: function (r) { grcSwal(r, 1500, 'entity.php'); }
        });
    }
});

// entity.php — open process modal
$(document).on('click', '.addprocess', function (e) {
    if ($('#processmodal').length) { e.preventDefault(); $('#processmodal').modal('show'); return; }
});
$(document).on('click', '.addprocessbtn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'processAction.php', method: 'post', data: $('#processform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'entity.php'); }
    });
});

// entity.php — add KI
$(document).on('click', '.addki', function (e) {
    e.preventDefault();
    if ($('#addki-modal').length) { $('#addki-modal').modal('show'); return; }
});
$(document).on('click', '.kiadd-btn', function (e) {
    e.preventDefault();
    if (!$('#kiaddform').length && !$('#kientaddform').length) return;
    var form = $('#kiaddform').length ? '#kiaddform' : '#kientaddform';
    var redirect = window.location.href.indexOf('riskstatus') !== -1 ? 'riskstatus.php' : 'entity.php';
    $.ajax({
        url: 'kiadd.php', method: 'post', data: $(form).serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, redirect); }
    });
});

// entity.php — add control
$(document).on('click', '.addcontrol-btn', function () {
    $.ajax({
        url: 'controladd.php', method: 'post', data: $('#addcontrolform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'entity.php'); }
    });
});

// entity.php — add action
$(document).on('click', '.addaction', function (e) {
    e.preventDefault();
    if ($('#addaction-modal').length) { $('#addaction-modal').modal('show'); return; }
});
$(document).on('click', '.actionaddbutton', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'actionadd.php', method: 'post', data: $('#actionform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'entity.php'); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 13 — KRI & Performance
// ─────────────────────────────────────────────────────────────────────────────

// kri.php — fetch action for checklist modal
$(document).on('click', '.action', function (e) {
    e.preventDefault();
    var kriid = $(this).attr('id');
    $.ajax({
        url: 'krifetchaction.php', method: 'post', data: { kriid: kriid }, dataType: 'json',
        success: function (data) { $('#actionname').html(data.action); $('#Action').modal('show'); }
    });
});

// kri.php + b_objective.php — fetch KRI for edit modal
$(document).on('click', '.kriedit', function (e) {
    e.preventDefault();
    var kriid = $(this).attr('id');
    $.ajax({
        url: 'kriedit.php', method: 'post', data: { kriid: kriid }, dataType: 'json',
        success: function (data) {
            $('#kriid').val(data.id);
            $('#kpi').val(data.kpi);
            $('#kri').val(data.kri);
            $('#perform').val(data.perform);
            $('#datepicker').val(data.date);
            $('#action').val(data.action);
            $('#b_obj').val(data.b_objective);
            $('#owner').val(data.owner);
            $('#edit-modal').modal('show');
        }
    });
});

// kri.php — submit KRI update
$(document).on('click', '.update', function (e) {
    if (!$('#updatekriform').length) return;
    e.preventDefault();
    $.ajax({
        url: 'kriupdate.php', method: 'POST', data: $('#updatekriform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'kri.php'); }
    });
});

// kri.php — fetch for delete modal
$(document).on('click', '.performdelete', function (e) {
    e.preventDefault();
    var kriid = $(this).attr('id');
    $.ajax({
        url: 'kriedit.php', method: 'post', data: { kriid: kriid }, dataType: 'json',
        success: function (data) {
            $('#pid').val(data.id);
            $('#performance').html(data.perform);
            $('#delete-modal').modal('show');
        }
    });
});

// kri.php — confirm delete
$(document).on('click', '.delete-btn', function (e) {
    if (!$('.performdelete').length) return;
    e.preventDefault();
    $.ajax({
        url: 'kridelete.php', method: 'POST', data: $('#deleteform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'kri.php'); }
    });
});

// kri.php — fetch for update history modal
$(document).on('click', '.histadd', function (e) {
    e.preventDefault();
    var kriid = $(this).attr('id');
    $.ajax({
        url: 'kriedit.php', method: 'post', data: { kriid: kriid }, dataType: 'json',
        success: function (data) {
            $('#upkriid').val(data.id);
            $('#upmeasure').val(data.measure);
            $('#up_apetite').val(data.risk_apetite);
            $('#up_date').val(data.timeline);
            $('#update-modal').modal('show');
        }
    });
});

// kri.php — checklist modal
$(document).on('click', '.checklist', function (e) {
    e.preventDefault();
    var kriid = $(this).attr('id');
    $.ajax({
        url: 'krihist.php', method: 'post', data: { kriid: kriid }, dataType: 'json',
        success: function (data) {
            $('#kpiid').html(data.ki);
            $('#kri').html(data.pname);
            $('#perform').html(data.perform);
            $('#action').html(data.action);
            $('#date').html(data.date);
            $('#performlimit').html(data.rlimit);
            $('#checklist').modal('show');
        }
    });
});

// kri.php + krihist.php — update performance history
$(document).on('click', '.riskperfhist', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'kriperformedit.php', method: 'POST', data: $('#riskperformform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'kri.php'); }
    });
});

// kriadd.php — add new KRI
$(document).on('click', '.addkri', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'kriaction.php', method: 'POST', data: $('#addkriform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'kri.php'); }
    });
});

// parameteradd.php — add KRI parameter
$(document).on('click', '.addparameter', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'parameterAction.php', method: 'POST', data: $('#addparameterform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'kra_settings.php'); }
    });
});

// kra_settings.php — fetch parameter for edit modal
$(document).on('click', '.parameteredit', function (e) {
    e.preventDefault();
    var pid = $(this).attr('id');
    $.ajax({
        url: 'editparameter.php', method: 'POST', data: { pid: pid }, dataType: 'json',
        success: function (data) {
            $('#parameterid').val(data.id);
            $('#p_name').val(data.pname);
            $('#apetite').val(data.apetite);
            $('#type').val(data.type);
            $('#rlimit').val(data.rlimit);
            $('#fmngt').val(data.fmngt);
            $('#tmngt').val(data.tmngt);
            $('#fboard').val(data.fboard);
            $('#tboard').val(data.tboard);
            $('#fmboard').val(data.fmboard);
            $('#tmboard').val(data.tmboard);
            $('#edit-modal').modal('show');
        }
    });
});

// kra_settings.php — update parameter
$(document).on('click', '.update', function (e) {
    if (!$('#updateparameterform').length) return;
    e.preventDefault();
    $.ajax({
        url: 'parameterupdate.php', method: 'post', data: $('#updateparameterform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 5500, 'kra_settings.php'); }
    });
});

// performance.php — add performance entry
$(document).on('click', '.addperform', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'performadd.php', method: 'post', data: $('#addkiform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'performance.php'); }
    });
});

// addkeyindicator.php — add KI
$(document).on('click', '.addki', function (e) {
    if (!$('#addkiform').length) return;
    e.preventDefault();
    $.ajax({
        url: 'kiadd.php', method: 'post', data: $('#addkiform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'kpi.php'); }
    });
});

// userslist.php (KI section) — fetch KI for edit modal
$(document).ready(function () {
    $(document).on('click', '.kiedit', function () {
        var kiid = $(this).attr('id');
        $.ajax({
            url: 'kiedit.php', method: 'POST', data: { kiid: kiid }, dataType: 'json',
            success: function (data) {
                $('#kiid').val(data.id);
                $('#process').val(data.process_id);
                $('#editrisk').val(data.risk_id);
                $('#ki').val(data.ki);
                $('#kri').val(data.apetite);
                $('#owner').val(data.owner);
                $('#edit-modal').modal('show');
            }
        });
    });
    $(document).on('click', '.kiupdate', function (e) {
        e.preventDefault();
        var redirect = window.location.href.indexOf('kpi') !== -1 ? 'kpi.php' : 'keyindicator.php';
        $.ajax({
            url: 'kiupdate.php', method: 'POST', data: $('#formupdate').serialize(), dataType: 'json',
            success: function (r) { grcSwal(r, 1500, redirect); }
        });
    });
    $(document).on('click', '.kidelete', function () {
        var kiid = $(this).attr('id');
        $.ajax({
            url: 'kiedit.php', method: 'POST', data: { kiid: kiid }, dataType: 'json',
            success: function (data) {
                $('#dcid').val(data.id);
                $('#dcname').html(data.ki);
                $('#delete-modal').modal('show');
            }
        });
    });
    $(document).on('click', '.delete-btn', function (e) {
        if (!$('.kidelete').length) return;
        e.preventDefault();
        var redirect = window.location.href.indexOf('kpi') !== -1 ? 'kpi.php' : 'keyindicator.php';
        $.ajax({
            url: 'kidelete.php', method: 'POST', data: $('#deleteform').serialize(), dataType: 'json',
            success: function (r) { grcSwal(r, 1500, redirect); }
        });
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 14 — KPI & BSC / Objectives
// ─────────────────────────────────────────────────────────────────────────────

// kpi.php — fetch KI for edit modal
$(document).on('click', '.kiedit-btn', function (e) {
    e.preventDefault();
    var kiid = $(this).attr('id');
    $.ajax({
        url: 'kiedit.php', method: 'POST', data: { kiid: kiid }, dataType: 'json',
        success: function (data) {
            $('#kiid').val(data.id);
            $('#process').val(data.process_id);
            $('#editrisk').val(data.risk_id);
            $('#ki').val(data.ki);
            $('#owner').val(data.owner);
            $('#editki-modal').modal('show');
        }
    });
});

// riskstatus.php process-to-dept mapping
$(document).on('change', '.selectprocess', function (e) {
    e.preventDefault();
    var pid = $(this).val();
    $.ajax({
        url: 'processdept.php', method: 'post', data: { option: pid }, dataType: 'json',
        success: function (data) {
            $('#pdept_id').val(data.dept_id);
            $('#cdept_id').val(data.dept_id);
            $('#adept_id').val(data.dept_id);
            $('#rdept_id').val(data.dept_id);
        }
    });
});

// b_objective.php / kri.php — same KRI checklist and edit (b_objective has same handlers as kri.php)

// ─────────────────────────────────────────────────────────────────────────────
// Section 15 — Actions
// ─────────────────────────────────────────────────────────────────────────────

// addaction.php — add action
$(document).on('click', '.addaction', function (e) {
    e.preventDefault();
    if ($('#addaction-modal').length) { $('#addaction-modal').modal('show'); return; }
    $.ajax({
        url: 'actionadd.php', method: 'post', data: $('#addactionform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'actions.php'); }
    });
});

// actions.php — fetch action for edit modal
$(document).ready(function () {
    $(document).on('click', '.editactionbtn', function (e) {
        e.preventDefault();
        var aid = $(this).attr('id');
        $.ajax({
            url: 'actioneditdata.php', method: 'POST', data: { aid: aid }, dataType: 'json',
            success: function (data) {
                $('#aid').val(data.id);
                $('#aprocess').val(data.process_id);
                $('#arisk').val(data.risk_id);
                $('#actionname').val(data.action);
                $('#status').val(data.status);
                $('#priority').val(data.priority);
                $('#datepicker3').val(data.timeline);
                $('#editaction-modal').modal('show');
            }
        });
    });
    $(document).on('click', '.updateaction-btn', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'actionupdate.php', method: 'POST', data: $('#actionform').serialize(), dataType: 'json',
            success: function (r) { grcSwal(r, 1500, 'actions.php'); }
        });
    });
    $(document).on('click', '.actiondeletebtn', function (e) {
        e.preventDefault();
        var aid = $(this).attr('id');
        $.ajax({
            url: 'actioneditdata.php', method: 'POST', data: { aid: aid }, dataType: 'json',
            success: function (data) {
                $('#actionid').val(data.id);
                $('#dcname').html(data.action);
                $('#delete-modal').modal('show');
            }
        });
    });
    $(document).on('click', '.delete-btn', function (e) {
        if (!$('.actiondeletebtn').length) return;
        e.preventDefault();
        $.ajax({
            url: 'actiondelete.php', method: 'POST', data: $('#deleteform').serialize(), dataType: 'json',
            success: function (r) { grcSwal(r, 1500, 'actions.php'); }
        });
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 16 — Recommendations
// ─────────────────────────────────────────────────────────────────────────────

// addrecommend.php — add recommendation
$(document).on('click', '.addrecommend', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'recommendaction.php', method: 'post', data: $('#addrecommendform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'recommendations.php'); }
    });
});

// recommendations.php — fetch for edit modal
$(document).on('click', '.editrecommend', function (e) {
    e.preventDefault();
    var rid = $(this).attr('id');
    $.ajax({
        url: 'recdelupdate.php', method: 'post', data: { rid: rid }, dataType: 'json',
        success: function (data) {
            $('#rid').val(data.id);
            $('#rmdp').val(data.process_id);
            $('#rmdrisk').val(data.risk_id);
            $('#action').val(data.action);
            $('#status').val(data.status);
            $('#datepicker4').val(data.timeline);
            $('#mrc').val(data.mrc);
            $('#armc').val(data.armc);
            $('#editrecommend-modal').modal('show');
        }
    });
});

// recommendations.php — submit edit
$(document).on('click', '.editrecommendation-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'recommendupdate.php', method: 'post', data: $('#editrecommendform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 5500, 'recommendations.php'); }
    });
});

// recommendations.php — fetch for delete modal
$(document).on('click', '.recommenddelete', function (e) {
    e.preventDefault();
    var rid = $(this).attr('id');
    $.ajax({
        url: 'recdelupdate.php', method: 'post', data: { rid: rid }, dataType: 'json',
        success: function (data) {
            $('#rid').val(data.id);
            $('#amc').html(data.mrc);
            $('#armc').html(data.armc);
            $('#delete-modal').modal('show');
        }
    });
});

// recommendations.php — confirm delete
$(document).on('click', '.delete-btn', function (e) {
    if (!$('.recommenddelete').length) return;
    e.preventDefault();
    $.ajax({
        url: 'recommenddelete.php', method: 'post', data: $('#deleteform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'recommendations.php'); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 17 — Incidents
// ─────────────────────────────────────────────────────────────────────────────

// incidentadd.php — add incident
$(document).on('click', '.addincident', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'incidentAction.php', method: 'post', data: $('#addincidentform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 5500, 'incidents.php'); }
    });
});

// incidents.php — fetch for edit modal
$(document).ready(function () {
    $(document).on('click', '.incidentedit', function () {
        var incedentid = $(this).attr('id');
        $.ajax({
            url: 'incidentedit.php', method: 'POST', data: { incedentid: incedentid }, dataType: 'json',
            success: function (data) {
                $('#iid').val(data.incident_id);
                $('#incident').val(data.incident);
                $('#processid').val(data.process_id);
                $('#selectrisk').val(data.risk_id);
                $('#datepicker').val(data.dol);
                $('#actual').val(data.actual);
                $('#expected').val(data.expected);
                $('#potential').val(data.potential);
                $('#recovery').val(data.recovery);
                $('#action').val(data.action);
                $('#edit-modal').modal('show');
            }
        });
    });
    $(document).on('click', '.incidentupdate', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'incidentupdate.php', method: 'POST', data: $('#formupdate').serialize(), dataType: 'json',
            success: function (r) { grcSwal(r, 1500, 'incidents.php'); }
        });
    });
    $(document).on('click', '.incidentdelete', function () {
        var incedentid = $(this).attr('id');
        $.ajax({
            url: 'incidentedit.php', method: 'POST', data: { incedentid: incedentid }, dataType: 'json',
            success: function (data) {
                $('#incidentid').val(data.incident_id);
                $('#dcname').html(data.incident);
                $('#delete-modal').modal('show');
            }
        });
    });
    $(document).on('click', '.delete-btn', function (e) {
        if (!$('.incidentdelete').length) return;
        e.preventDefault();
        $.ajax({
            url: 'incidentdelete.php', method: 'POST', data: $('#deleteform').serialize(), dataType: 'json',
            success: function (r) { grcSwal(r, 1500, 'incidents.php'); }
        });
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 18 — Approval & Inbox (inbox.php + riskstatus.php)
// ─────────────────────────────────────────────────────────────────────────────

// inbox.php — risk approval
$(document).on('click', '.approverisk', function (e) {
    e.preventDefault();
    var riskid = $(this).attr('id');
    $.ajax({
        url: 'riskdelupdate.php', method: 'post', data: { riskid: riskid }, dataType: 'json',
        success: function (data) {
            $('#dcid').val(data.risk_id);
            $('#dcname').html(data.risk_name);
            $('#approverisk-modal').modal('show');
        }
    });
});
$(document).on('click', '.approverisk-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'riskapprove.php', method: 'post', data: $('#approveriskform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// inbox.php — control approval
$(document).on('click', '.approvecontrol', function (e) {
    e.preventDefault();
    var cid = $(this).attr('id');
    $.ajax({
        url: 'controlupdate.php', method: 'POST', data: { cid: cid }, dataType: 'json',
        success: function (data) {
            $('#controlid').val(data.control_id);
            $('#controlname').html(data.controls);
            $('#approvecontrol-modal').modal('show');
        }
    });
});
$(document).on('click', '.approvecontrol-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'controlapprove.php', method: 'post', data: $('#approvecontrolform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// inbox.php — KI approval
$(document).on('click', '.approveki', function (e) {
    e.preventDefault();
    var kiid = $(this).attr('id');
    $.ajax({
        url: 'kiedit.php', method: 'POST', data: { kiid: kiid }, dataType: 'json',
        success: function (data) {
            $('#kiid').val(data.id);
            $('#kiname').html(data.ki);
            $('#approveki-modal').modal('show');
        }
    });
});
$(document).on('click', '.approveki-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'kiapproval.php', method: 'post', data: $('#approvekiform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// inbox.php — recommendation approval
$(document).on('click', '.approverecommend', function (e) {
    e.preventDefault();
    var rcdid = $(this).attr('id');
    $.ajax({
        url: 'recdelupdate.php', method: 'POST', data: { rid: rcdid }, dataType: 'json',
        success: function (data) {
            $('#rcmdid').val(data.id);
            $('#mrcname').html(data.mrc);
            $('#armcname').html(data.armc);
            $('#approverecommend-modal').modal('show');
        }
    });
});
$(document).on('click', '.approverecommend-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'recommendapproval.php', method: 'post', data: $('#approverecommendform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// inbox.php — action approval
$(document).on('click', '.approveaction', function (e) {
    e.preventDefault();
    var aid = $(this).attr('id');
    $.ajax({
        url: 'actioneditdata.php', method: 'POST', data: { aid: aid }, dataType: 'json',
        success: function (data) {
            $('#aid').val(data.id);
            $('#aname').html(data.action);
            $('#approveaction-modal').modal('show');
        }
    });
});
$(document).on('click', '.approveaction-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'actionapproval.php', method: 'post', data: $('#approveactionform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// inbox.php — reject risk
$(document).on('click', '.rejectrisk', function (e) {
    e.preventDefault();
    var riskid = $(this).attr('id');
    $.ajax({
        url: 'riskdelupdate.php', method: 'post', data: { riskid: riskid }, dataType: 'json',
        success: function (data) {
            $('#rejrid').val(data.risk_id);
            $('#rejname').html(data.risk_name);
            $('#rejectrisk-modal').modal('show');
        }
    });
});
$(document).on('click', '.rejectrisk-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'riskreject.php', method: 'post', data: $('#rejectriskform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// inbox.php — amend control
$(document).on('click', '.ammendcontrol', function (e) {
    e.preventDefault();
    var acid = $(this).attr('id');
    $.ajax({
        url: 'controlupdate.php', method: 'POST', data: { cid: acid }, dataType: 'json',
        success: function (data) {
            $('#acid').val(data.control_id);
            $('#acname').html(data.control);
            $('#ammendcontrol-modal').modal('show');
        }
    });
});
$(document).on('click', '.ammendcontrol-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'controlammend.php', method: 'post', data: $('#ammendcontrolform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// inbox.php — amend KI
$(document).on('click', '.ammendki', function (e) {
    e.preventDefault();
    var akiid = $(this).attr('id');
    $.ajax({
        url: 'kiedit.php', method: 'POST', data: { kiid: akiid }, dataType: 'json',
        success: function (data) {
            $('#akiid').val(data.id);
            $('#akiname').html(data.ki);
            $('#ammendki-modal').modal('show');
        }
    });
});
$(document).on('click', '.ammendki-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'kiammend.php', method: 'post', data: $('#kiammendform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// inbox.php — amend recommendation
$(document).on('click', '.ammendrecommend', function (e) {
    e.preventDefault();
    var arcid = $(this).attr('id');
    $.ajax({
        url: 'recdelupdate.php', method: 'POST', data: { rid: arcid }, dataType: 'json',
        success: function (data) {
            $('#arid').val(data.id);
            $('#ammendmrc').html(data.mrc);
            $('#ammendarmc').html(data.armc);
            $('#ammendrecommend-modal').modal('show');
        }
    });
});
$(document).on('click', '.ammendrecommend-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'recommendammend.php', method: 'post', data: $('#ammendrecommendform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// inbox.php — amend action
$(document).on('click', '.ammendaction', function (e) {
    e.preventDefault();
    var aid = $(this).attr('id');
    $.ajax({
        url: 'actioneditdata.php', method: 'POST', data: { aid: aid }, dataType: 'json',
        success: function (data) {
            $('#aaid').val(data.id);
            $('#aaname').html(data.action);
            $('#ammendaction-modal').modal('show');
        }
    });
});
$(document).on('click', '.ammendaction-btn', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'actionammend.php', method: 'post', data: $('#ammendactionform').serialize(), dataType: 'json',
        success: function (r) {
            grcToast(r);
            window.setTimeout(function () { window.location.href = 'inbox.php'; }, 1500);
        }
    });
});

// riskstatus.php — add risk with validation
$(document).on('click', '.addentrisk', function (e) {
    e.preventDefault();
    $('#addentrisk-modal').modal('show');
});

$(document).on('click', '.addrisksbutton', function (e) {
    e.preventDefault();
    if (!$('#addriskform').length) return;
    if (!checkrdeptid() || !checkprocessid() || !checkinherent() || !checkrcat() || !checkcause() || !checkreviewer() || !checkrdate()) {
        $('#messagerisk').html('<div class="alert alert-warning">Please fill all required fields</div>');
        return;
    }
    $.ajax({
        method: 'post', url: 'riskAction.php', data: $('#addriskform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'riskstatus.php'); }
    });
});

// riskstatus.php — validation functions
function checkrdeptid()  { var v=$('#dept_id').val();    if(!v){$('#deptid_err').html('required field');return false;}$('#deptid_err').html('');return true; }
function checkprocessid(){ var v=$('#process_id').val(); if(!v){$('#processid_err').html('required field');return false;}$('#processid_err').html('');return true; }
function checkinherent() { var v=$('#inherent').val();   if(!v){$('#inherent_err').html('required field');return false;}$('#inherent_err').html('');return true; }
function checkrcat()     { var v=$('#rcat').val();       if(!v){$('#rcat_err').html('required field');return false;}$('#rcat_err').html('');return true; }
function checkcause()    { var v=$('#cause').val();      if(!v){$('#cause_err').html('required field');return false;}$('#cause_err').html('');return true; }
function checkreviewer() { var v=$('#reviewer').val();   if(!v){$('#reviewer_err').html('required field');return false;}$('#reviewer_err').html('');return true; }
function checkrdate()    { var v=$('#datepicker').val(); if(!v){$('#rdate_err').html('required field');return false;}$('#rdate_err').html('');return true; }

// riskstatus.php — add KI with validation
$(document).on('click', '.addentki', function (e) {
    e.preventDefault();
    $('#addki-modal').modal('show');
});
$(document).on('click', '.kiadd-btn', function (e) {
    e.preventDefault();
    if (!$('#kientaddform').length) return;
    if (!checkkiprocess() || !checkkirisk() || !checkki() || !checkkiowner()) {
        $('#messageki').html('<div class="alert alert-warning">Please fill all required fields</div>');
        return;
    }
    $.ajax({
        url: 'kiadd.php', method: 'post', data: $('#kientaddform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'riskstatus.php'); }
    });
});
function checkkiprocess(){ var v=$('#kiprocess').val(); if(!v){$('#kiprocess_err').html('required field');return false;}$('#kiprocess_err').html('');return true; }
function checkkirisk()   { var v=$('#selectrisk').val();if(!v){$('#kirisk_err').html('required field');return false;}$('#kirisk_err').html('');return true; }
function checkki()       { var v=$('#ki').val();        if(!v){$('#ki_err').html('required field');return false;}$('#ki_err').html('');return true; }
function checkkiowner()  { var v=$('#kiowner').val();   if(!v){$('#kiowner_err').html('required field');return false;}$('#kiowner_err').html('');return true; }

// riskstatus.php — add control with validation
$(document).on('click', '.addentcontrol', function (e) {
    e.preventDefault();
    $('#addcontrol-modal').modal('show');
});
$(document).on('click', '.addentcontrol-btn', function (e) {
    e.preventDefault();
    if (!checkcprocess() || !checkcrisk() || !checkcontrol() || !checkcstrength() || !checkctype() || !checkcreviewer() || !checkcrdate()) {
        $('#messagecontrol').html('<div class="alert alert-warning">Please fill all required fields</div>');
        return;
    }
    $.ajax({
        method: 'post', url: 'controladd.php', data: $('#addcontrolform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'riskstatus.php'); }
    });
});
function checkcprocess()  { var v=$('#cprocess').val();  if(!v){$('#cprocess_err').html('required field');return false;}$('#cprocess_err').html('');return true; }
function checkcrisk()     { var v=$('#crisk').val();     if(!v){$('#crisk_err').html('required field');return false;}$('#crisk_err').html('');return true; }
function checkcontrol()   { var v=$('#controls').val();  if(!v){$('#control_err').html('required field');return false;}$('#control_err').html('');return true; }
function checkcstrength() { var v=$('#cstrength').val(); if(!v){$('#cstrength_err').html('required field');return false;}$('#cstrength_err').html('');return true; }
function checkctype()     { var v=$('#ctype').val();     if(!v){$('#ctype_err').html('required field');return false;}$('#ctype_err').html('');return true; }
function checkcreviewer() { var v=$('#creviewer').val(); if(!v){$('#creviewer_err').html('required field');return false;}$('#creviewer_err').html('');return true; }
function checkcrdate()    { var v=$('#crdate').val();    if(!v){$('#crdate_err').html('required field');return false;}$('#crdate_err').html('');return true; }

// riskstatus.php — add recommendation
$(document).on('click', '.addentrecommend', function (e) {
    e.preventDefault();
    $('#addentrecommend-modal').modal('show');
});
$(document).on('click', '.addentrecommend-btn', function (e) {
    e.preventDefault();
    $.ajax({
        method: 'post', url: 'recommendaction.php', data: $('#addentrecommendform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'riskstatus.php'); }
    });
});

// riskstatus.php — add action with validation
$(document).on('click', '.addentaction', function (e) {
    e.preventDefault();
    $('#addaction-modal').modal('show');
});
$(document).on('click', '.addentaction-btn', function (e) {
    e.preventDefault();
    if (!checkaprocess() || !checkarisk() || !checkaction() || !checktimeline()) {
        $('#messageaction').html('<div class="alert alert-warning">Please fill all required fields</div>');
        return;
    }
    $.ajax({
        url: 'actionadd.php', method: 'post', data: $('#actionform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'riskstatus.php'); }
    });
});
function checkaprocess()  { var v=$('#aprocess').val();    if(!v){$('#aprocess_err').html('required field');return false;}$('#aprocess_err').html('');return true; }
function checkarisk()     { var v=$('#arisk').val();       if(!v){$('#arisk_err').html('required field');return false;}$('#arisk_err').html('');return true; }
function checkaction()    { var v=$('#actionname').val();  if(!v){$('#action_err').html('required field');return false;}$('#action_err').html('');return true; }
function checktimeline()  { var v=$('#datepicker3').val(); if(!v){$('#atime_err').html('required field');return false;}$('#atime_err').html('');return true; }

// ─────────────────────────────────────────────────────────────────────────────
// Section 19 — Profile & Permissions
// ─────────────────────────────────────────────────────────────────────────────

$(document).on('click', '.access', function (e) {
    e.preventDefault();
    $('#access-modal').modal('show');
});

// profile.php — update profile
$(document).on('click', '.profileupdate', function (e) {
    e.preventDefault();
    $.ajax({
        url: 'profileaction.php', method: 'post', data: $('#profileform').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, 1500, 'userslist.php'); }
    });
});

// profile.php + permissionedit.php — save permissions
$(document).on('click', '.permission-button', function (e) {
    e.preventDefault();
    var delay = window.location.href.indexOf('permissionedit') !== -1 ? 3500 : 1500;
    var redirect = window.location.href.indexOf('permissionedit') !== -1 ? 'userlist.php' : 'userslist.php';
    $.ajax({
        url: 'permissions.php', method: 'post', data: $('#permission').serialize(), dataType: 'json',
        success: function (r) { grcSwal(r, delay, redirect); }
    });
});

// ─────────────────────────────────────────────────────────────────────────────
// Section 20 — Bulk Upload
// bulk_risk_upload.php keeps its own self-contained inline script
// (drag-drop UI, progress bar, file list, displayResults) — not moved here.
// ─────────────────────────────────────────────────────────────────────────────
