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
})();
