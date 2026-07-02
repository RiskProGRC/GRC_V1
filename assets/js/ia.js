// Internal Audit module — AJAX handlers (shared across all IA pages).
// Depends on jQuery + grcSwalReload()/grcSwal() (defined in app.js, loaded before this file).
(function () {
    'use strict';

    function iaFail() { Swal.fire({ icon: 'error', title: 'Request failed. Please try again.' }); }

    /* =========================================================
       Phase 1 — Governance Charters
       ========================================================= */

    // open the Add modal, pre-setting the charter type from the tab's button
    $(document).on('click', '.addcharter', function (e) {
        e.preventDefault();
        var type = $(this).attr('data-type');
        var form = document.getElementById('addcharterform');
        if (form) form.reset();
        $('#add_charter_type').val(type);
        $('#addcharter-title').text(type === 'audit_committee' ? 'Add Audit Committee Charter' : 'Add Internal Audit Charter');
        $('#addcharter-modal').modal('show');
    });

    // submit Add (multipart — carries the optional file)
    $(document).on('submit', '#addcharterform', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'iacharteraction.php', method: 'POST',
            data: new FormData(this), processData: false, contentType: false, dataType: 'json',
            success: function (r) { grcSwalReload(r, 1500); }, error: iaFail
        });
    });

    // populate + open the Edit modal from the row's data-* attributes
    $(document).on('click', '.editcharter', function (e) {
        e.preventDefault();
        var b = $(this);
        $('#edit_id').val(b.attr('data-id'));
        $('#edit_title').val(b.attr('data-title'));
        $('#edit_version').val(b.attr('data-version'));
        $('#edit_content').val(b.attr('data-content'));
        $('#edit_approved_by').val(b.attr('data-approved_by'));
        $('#edit_approved_date').val(b.attr('data-approved_date'));
        $('#edit_review_date').val(b.attr('data-review_date'));
        $('#edit_status').val(b.attr('data-status'));
        $('#editcharter-modal').modal('show');
    });

    // submit Edit (multipart — optional replacement file)
    $(document).on('submit', '#editcharterform', function (e) {
        e.preventDefault();
        $.ajax({
            url: 'iacharterupdate.php', method: 'POST',
            data: new FormData(this), processData: false, contentType: false, dataType: 'json',
            success: function (r) { grcSwalReload(r, 1500); }, error: iaFail
        });
    });

    // open the Delete confirmation modal
    $(document).on('click', '.deletecharter', function (e) {
        e.preventDefault();
        $('#delete_id').val($(this).attr('data-id'));
        $('#delete_title').text($(this).attr('data-title'));
        $('#deletecharter-modal').modal('show');
    });

    // confirm Delete
    $(document).on('click', '.confirmdeletecharter-btn', function (e) {
        e.preventDefault();
        $('#deletecharter-modal').modal('hide');
        $.ajax({
            url: 'iacharterdelete.php', method: 'POST',
            data: { id: $('#delete_id').val() }, dataType: 'json',
            success: function (r) { grcSwalReload(r, 1200); }, error: iaFail
        });
    });

    /* generic helpers */
    function submitMultipart(formSel, url) {
        $.ajax({ url: url, method: 'POST', data: new FormData(document.querySelector(formSel)),
            processData: false, contentType: false, dataType: 'json',
            success: function (r) { grcSwalReload(r, 1500); }, error: iaFail });
    }
    function submitSerialized(formSel, url) {
        $.ajax({ url: url, method: 'POST', data: $(formSel).serialize(), dataType: 'json',
            success: function (r) { grcSwalReload(r, 1400); }, error: iaFail });
    }
    function delPost(url, id, delay) {
        $.ajax({ url: url, method: 'POST', data: { id: id }, dataType: 'json',
            success: function (r) { grcSwalReload(r, delay || 1200); }, error: iaFail });
    }
    var pick = function (b, name) { var v = b.attr('data-' + name); return (v && v !== '0') ? v : ''; };

    /* =========================================================
       Phase 2 — Strategic Plan
       ========================================================= */
    $(document).on('click', '.addsp', function (e) { e.preventDefault(); var f = document.getElementById('addspform'); if (f) f.reset(); $('#addsp-modal').modal('show'); });
    $(document).on('submit', '#addspform', function (e) { e.preventDefault(); submitMultipart('#addspform', 'iastrategicplanaction.php'); });
    $(document).on('click', '.editsp', function (e) {
        e.preventDefault(); var b = $(this);
        $('#esp_id').val(b.attr('data-id')); $('#esp_title').val(b.attr('data-title'));
        $('#esp_start').val(b.attr('data-start')); $('#esp_end').val(b.attr('data-end'));
        $('#esp_objectives').val(b.attr('data-objectives')); $('#esp_resource').val(b.attr('data-resource'));
        $('#esp_status').val(b.attr('data-status')); $('#editsp-modal').modal('show');
    });
    $(document).on('submit', '#editspform', function (e) { e.preventDefault(); submitMultipart('#editspform', 'iastrategicplanupdate.php'); });
    $(document).on('click', '.deletesp', function (e) { e.preventDefault(); $('#dsp_id').val($(this).attr('data-id')); $('#dsp_title').text($(this).attr('data-title')); $('#deletesp-modal').modal('show'); });
    $(document).on('click', '.confirmdeletesp-btn', function (e) { e.preventDefault(); $('#deletesp-modal').modal('hide'); delPost('iastrategicplandelete.php', $('#dsp_id').val()); });

    /* =========================================================
       Phase 2 — Annual Plan (header)
       ========================================================= */
    $(document).on('click', '.addap', function (e) { e.preventDefault(); var f = document.getElementById('addapform'); if (f) f.reset(); $('#addap-modal').modal('show'); });
    $(document).on('submit', '#addapform', function (e) { e.preventDefault(); submitMultipart('#addapform', 'iaannualplanaction.php'); });
    $(document).on('click', '.editap', function (e) {
        e.preventDefault(); var b = $(this);
        $('#eap_id').val(b.attr('data-id')); $('#eap_year').val(b.attr('data-year')); $('#eap_title').val(b.attr('data-title'));
        $('#eap_approved_by').val(b.attr('data-approved_by')); $('#eap_approved_date').val(b.attr('data-approved_date'));
        $('#eap_status').val(b.attr('data-status')); $('#editap-modal').modal('show');
    });
    $(document).on('submit', '#editapform', function (e) { e.preventDefault(); submitMultipart('#editapform', 'iaannualplanupdate.php'); });
    $(document).on('click', '.deleteap', function (e) { e.preventDefault(); $('#dap_id').val($(this).attr('data-id')); $('#dap_title').text($(this).attr('data-title')); $('#deleteap-modal').modal('show'); });
    $(document).on('click', '.confirmdeleteap-btn', function (e) { e.preventDefault(); $('#deleteap-modal').modal('hide'); delPost('iaannualplandelete.php', $('#dap_id').val()); });

    /* =========================================================
       Phase 2 — Annual Plan line items (schedule)
       ========================================================= */
    $(document).on('click', '.additem', function (e) { e.preventDefault(); var f = document.getElementById('additemform'); if (f) f.reset(); $('#additem-modal').modal('show'); });
    $(document).on('submit', '#additemform', function (e) { e.preventDefault(); submitSerialized('#additemform', 'iaannualplanitemaction.php'); });
    $(document).on('click', '.edititem', function (e) {
        e.preventDefault(); var b = $(this);
        $('#eit_id').val(b.attr('data-id')); $('#eit_title').val(b.attr('data-title'));
        $('#eit_dept').val(pick(b, 'dept')); $('#eit_process').val(pick(b, 'process')); $('#eit_risk').val(pick(b, 'risk'));
        $('#eit_rating').val(b.attr('data-rating') || ''); $('#eit_quarter').val(pick(b, 'quarter'));
        $('#eit_days').val(b.attr('data-days')); $('#eit_status').val(b.attr('data-status'));
        $('#edititem-modal').modal('show');
    });
    $(document).on('submit', '#edititemform', function (e) { e.preventDefault(); submitSerialized('#edititemform', 'iaannualplanitemupdate.php'); });
    $(document).on('click', '.deleteitem', function (e) { e.preventDefault(); $('#dit_id').val($(this).attr('data-id')); $('#dit_title').text($(this).attr('data-title')); $('#deleteitem-modal').modal('show'); });
    $(document).on('click', '.confirmdeleteitem-btn', function (e) { e.preventDefault(); $('#deleteitem-modal').modal('hide'); delPost('iaannualplanitemdelete.php', $('#dit_id').val()); });

    /* =========================================================
       Phase 3 — Engagement hub
       ========================================================= */
    $(document).on('click', '.addeng', function (e) { e.preventDefault(); var f = document.getElementById('addengform'); if (f) f.reset(); $('#addeng-modal').modal('show'); });
    $(document).on('submit', '#addengform', function (e) { e.preventDefault(); submitMultipart('#addengform', 'engagementaction.php'); });
    $(document).on('click', '.editeng', function (e) {
        e.preventDefault(); var b = $(this);
        $('#eeng_id').val(b.attr('data-id')); $('#eeng_title').val(b.attr('data-title')); $('#eeng_dept').val(b.attr('data-dept')); $('#eeng_type').val(b.attr('data-type'));
        $('#eeng_risk').val(pick(b, 'risk')); $('#eeng_scope').val(b.attr('data-scope')); $('#eeng_owner').val(b.attr('data-owner')); $('#eeng_lead').val(pick(b, 'lead'));
        $('#eeng_start').val(b.attr('data-start')); $('#eeng_end').val(b.attr('data-end')); $('#eeng_status').val(b.attr('data-status'));
        $('#editeng-modal').modal('show');
    });
    $(document).on('submit', '#editengform', function (e) { e.preventDefault(); submitMultipart('#editengform', 'engagementaction.php'); });
    $(document).on('click', '.deleteeng', function (e) { e.preventDefault(); $('#deng_id').val($(this).attr('data-id')); $('#deng_title').text($(this).attr('data-title')); $('#deleteeng-modal').modal('show'); });
    $(document).on('click', '.confirmdeleteeng-btn', function (e) { e.preventDefault(); $('#deleteeng-modal').modal('hide');
        $.ajax({ url: 'engagementaction.php', method: 'POST', data: { mode: 'delete', id: $('#deng_id').val() }, dataType: 'json', success: function (r) { grcSwalReload(r, 1200); }, error: iaFail }); });

    /* Phase 3 — Engagement Plan (single record per engagement) */
    $(document).on('submit', '#planform', function (e) { e.preventDefault();
        $.ajax({ url: 'engplanaction.php', method: 'POST', data: $(this).serialize(), dataType: 'json', success: function (r) { grcSwalReload(r, 1300); }, error: iaFail }); });

    /* Phase 3 — generic engagement sub-artefacts (ethics/reliance/checklist/process/program) */
    var IA_FORMS = [
        ['addethics', 'editethics', 'ethicsform', 'ethics-modal'],
        ['addreliance', 'editreliance', 'relianceform', 'reliance-modal'],
        ['addchecklist', 'editchecklist', 'checklistform', 'checklist-modal'],
        ['addprocess', 'editprocess', 'processform', 'process-modal'],
        ['addprogram', 'editprogram', 'programform', 'program-modal'],
        ['addmeeting', 'editmeeting', 'meetingform', 'meeting-modal'],
        ['addworkpaper', 'editworkpaper', 'workpaperform', 'workpaper-modal'],
        ['addfinding', 'editfinding', 'findingform', 'finding-modal'],
        ['addwpcheck', 'editwpcheck', 'wpcheckform', 'wpcheck-modal'],
        ['addreview', 'editreview', 'reviewform', 'review-modal'],
        ['addfinalreport', 'editfinalreport', 'finalreportform', 'finalreport-modal'],
        ['addactionsummary', 'editactionsummary', 'actionsummaryform', 'actionsummary-modal'],
        ['addreportsummary', 'editreportsummary', 'reportsummaryform', 'reportsummary-modal']
    ];
    IA_FORMS.forEach(function (cfg) {
        var addCls = cfg[0], editCls = cfg[1], formId = cfg[2], modalId = cfg[3];
        $(document).on('click', '.' + addCls, function (e) {
            e.preventDefault(); var f = document.getElementById(formId); if (!f) return;
            f.reset();
            var mEl = f.querySelector('[name="mode"]'); if (mEl) mEl.value = 'add';
            var iEl = f.querySelector('[name="id"]'); if (iEl) iEl.value = '';
            $('#' + modalId).modal('show');
        });
        $(document).on('click', '.' + editCls, function (e) {
            e.preventDefault(); var b = this, f = document.getElementById(formId); if (!f) return;
            f.reset(); f.querySelector('[name="mode"]').value = 'update';
            Object.keys(b.dataset).forEach(function (k) { var el = f.querySelector('[name="' + k + '"]'); if (el) el.value = b.dataset[k]; });
            $('#' + modalId).modal('show');
        });
    });
    $(document).on('submit', '.ia-entity-form', function (e) {
        e.preventDefault(); var url = $(this).data('url'), modal = $(this).data('modal');
        // FormData carries text fields AND any optional file inputs uniformly
        $.ajax({ url: url, method: 'POST', data: new FormData(this), processData: false, contentType: false, dataType: 'json',
            success: function (r) { if (modal) $('#' + modal).modal('hide'); grcSwalReload(r, 1300); }, error: iaFail });
    });

    /* Phase 4 — engagement document upload (multipart) */
    $(document).on('click', '.adddoc', function (e) { e.preventDefault(); var f = document.getElementById('docform'); if (f) f.reset(); $('#doc-modal').modal('show'); });
    $(document).on('submit', '#docform', function (e) { e.preventDefault(); submitMultipart('#docform', 'engdocaction.php'); });

    /* Phase 3/4 — shared delete for engagement sub-artefacts */
    $(document).on('click', '.ia-del', function (e) {
        e.preventDefault();
        $('#iadel_id').val($(this).attr('data-id')); $('#iadel_url').val($(this).attr('data-url')); $('#iadel_label').text($(this).attr('data-label'));
        $('#iadel-modal').modal('show');
    });
    $(document).on('click', '.iadel-confirm', function (e) {
        e.preventDefault(); $('#iadel-modal').modal('hide');
        $.ajax({ url: $('#iadel_url').val(), method: 'POST', data: { mode: 'delete', id: $('#iadel_id').val() }, dataType: 'json', success: function (r) { grcSwalReload(r, 1100); }, error: iaFail });
    });
})();
