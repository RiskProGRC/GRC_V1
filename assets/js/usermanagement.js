/* User Management Module — AJAX handlers
   Included on: usersadd.php, userslist.php, profile.php */
$(function () {

    /* ── Helpers ── */
    var base = (window.GRC && window.GRC.base) ? window.GRC.base : '../'; /* fallback for pages not under Project/ */

    function showFeedback(msg, type) {
        $('#form-feedback').html('<div class="alert alert-' + type + '">' + msg + '</div>'); /* targets inline div above form */
    }

    /* ─────────────────────────────────────────────
       ADD USER FORM (usersadd.php)
    ───────────────────────────────────────────── */

    /* validation rules — extend this array to add more checks */
    var addUserRules = [
        { field: 'fname',    message: 'First name is required.' },
        { field: 'sname',    message: 'Last name is required.' },
        { field: 'uname',    message: 'Username is required.' },
        { field: 'phone',    message: 'Mobile number is required.' },
        { field: 'email',    message: 'Enter a valid email address.',
          validator: function (v) { return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v); } },
        { field: 'password', message: 'Password must be at least 8 characters.',
          validator: function (v) { return v.length >= 8; } }
    ];

    $('#profileform').on('submit', function (e) { e.preventDefault(); }); /* block native submit (Enter key) */

    $('.adduser-button').on('click', function () {
       
        var $btn = $(this).prop('disabled', true).text('Adding…'); /* loading state — prevents double-submit */
        $.ajax({
            url:      base + 'Project/usersaction.php',
            method:   'post',
            dataType: 'json',
            data:     $('#profileform').serialize(),
            complete: function () { $btn.prop('disabled', false).text('ADD USER'); }, /* always re-enable, fires on success or error */
            success: function (res) {
                if (res.status === 'ok') {
                    showFeedback(res.message, 'success');
                    setTimeout(function () {
                        window.location.href = base + 'Project/userslist.php';
                    }, 1500); /* brief delay so user reads the feedback before redirect */
                } else {
                    showFeedback(res.message, 'danger');
                }
            },
            error: function () { showFeedback('Server error. Please try again.', 'danger'); }
        });
    });

    /* ── Username live availability check ── */
    $('#uname').on('blur', function () { /* blur not keyup — avoids hammering the server on every keystroke */
        var val = $(this).val().trim();
        if (!val) return;
        $.getJSON(base + 'Project/usernamecheck.php', { uname: val }, function (res) {
            var $fb = $('#uname').nextAll('.invalid-feedback').first(); /* Bootstrap sibling div for field error */
            if (res.taken) {
                $('#uname').addClass('is-invalid').removeClass('is-valid');
                $fb.text('Username already taken.').addClass('d-block');
            } else {
                $('#uname').removeClass('is-invalid').addClass('is-valid');
                $fb.removeClass('d-block');
            }
        });
    });

    /* ── Show / hide password toggle ── */
    $('.toggle-pw').on('click', function () {
        var $inp  = $('#password');
        var shown = $inp.attr('type') === 'text'; /* true = currently visible, click will hide */
        $inp.attr('type', shown ? 'password' : 'text');
        $(this).attr('aria-label', shown ? 'Show password' : 'Hide password'); /* keep screen-reader label in sync */
    });

    /* ── Password strength meter ── */
    $('#password').on('keyup', function () {
        var v = $(this).val(), s = 0; /* s = score 0–4, one point per passing check */
        if (v.length >= 8)           s++;
        if (/[A-Z]/.test(v))         s++;
        if (/\d/.test(v))            s++;
        if (/[^A-Za-z0-9]/.test(v)) s++; /* special character check */
        var colors = ['', 'bg-danger', 'bg-warning', 'bg-info', 'bg-success']; /* index 0 unused (empty password) */
        var labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
        $('#pw-bar').css('width', (s * 25) + '%') /* each point = 25% bar width */
                    .removeClass('bg-danger bg-warning bg-info bg-success')
                    .addClass(colors[s]);
        $('#pw-label').text(labels[s]);
    });

    /* ── Avatar preview ── */
    $('#avatar-file').on('change', function () {
        var file = this.files[0];
        if (!file) return;
        var reader = new FileReader();
        reader.onload = function (e) { $('#avatar-img').attr('src', e.target.result); }; /* data URL — no upload needed for preview */
        reader.readAsDataURL(file);
    });

    /* ─────────────────────────────────────────────
       USER LIST (userslist.php)
    ───────────────────────────────────────────── */

    /* ── Department filter ── */
    $('#dept-filter').on('change', function () {
        var val = $(this).val();
        $('#table1 tbody tr').show(); /* reset all rows before re-filtering */
        if (val) {
            $('#table1 tbody tr').filter(function () {
                return $(this).data('dept') != val; /* loose != — data-dept may come back as number or string */
            }).hide();
        }
    });

    /* ── Access toggle (suspend / activate) ── */
    $(document).on('click', '.access-toggle', function () { /* delegated — rows may be dynamically rendered */
        var $btn = $(this);
        var tUid = $btn.data('uid');
        var csrf = $btn.data('csrf'); /* CSRF token embedded in data attribute by PHP */
        $btn.prop('disabled', true); /* prevent double-click while request is in flight */
        $.ajax({
            url:      base + 'Project/useraccessaction.php',
            method:   'post',
            dataType: 'json',
            data:     { uid: tUid, csrf_token: csrf },
            success: function (res) {
                if (res.status === 'ok') {
                    var active = res.message === 'activated'; /* server echoes which action it took */
                    $btn.text(active ? 'Active' : 'Suspended')
                        .removeClass('btn-success btn-danger')
                        .addClass(active ? 'btn-success' : 'btn-danger');
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                }
            },
            error:    function () { Swal.fire({ icon: 'error', title: 'Error', text: 'Server error.' }); },
            complete: function () { $btn.prop('disabled', false); } /* always re-enable */
        });
    });

    /* ── Delete user (soft-delete) ── */
    $(document).on('click', '.user-delete', function () { /* delegated — rows may be dynamically rendered */
        var $btn = $(this);
        var tUid = $btn.data('uid');
        var name = $btn.data('name');
        var csrf = $btn.data('csrf');

        Swal.fire({
            title:              'Delete ' + name + '?',
            text:               'This user will be removed from the system.',
            icon:               'warning',
            showCancelButton:   true,
            confirmButtonColor: '#dc3545',
            confirmButtonText:  'Yes, delete'
        }).then(function (result) {
            if (!result.isConfirmed) return; /* user clicked Cancel */
            $.ajax({
                url:      base + 'Project/userdeleteaction.php',
                method:   'post',
                dataType: 'json',
                data:     { uid: tUid, csrf_token: csrf },
                success: function (res) {
                    if (res.status === 'ok') {
                        $btn.closest('tr').fadeOut(400, function () { $(this).remove(); }); /* animate out, then remove from DOM */
                        Swal.fire({ icon: 'success', title: 'Deleted', text: name + ' has been removed.' });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: res.message });
                    }
                },
                error: function () { Swal.fire({ icon: 'error', title: 'Error', text: 'Server error.' }); }
            });
        });
    });

    /* ─────────────────────────────────────────────
       PROFILE PAGE (profile.php)
    ───────────────────────────────────────────── */

    /* ── Admin reset password ── */
    $(document).on('click', '.reset-pw-btn', function () {
        var tUid = $(this).data('uid');
        var csrf = $(this).data('csrf');

        Swal.fire({
            title:             'Set temporary password',
            html:              '<input id="swal-pw" type="password" class="swal2-input" placeholder="New password (min 8 chars)" autocomplete="new-password">', /* autocomplete="new-password" blocks browser autofill */
            showCancelButton:  true,
            confirmButtonText: 'Reset Password',
            preConfirm: function () { /* preConfirm runs before Swal closes — keeps dialog open on validation failure */
                var pw = document.getElementById('swal-pw').value;
                if (!pw || pw.length < 8) {
                    Swal.showValidationMessage('Password must be at least 8 characters.');
                    return false;
                }
                return pw;
            }
        }).then(function (result) {
            if (!result.isConfirmed || !result.value) return; /* !result.value catches preConfirm returning false */
            $.ajax({
                url:      base + 'Project/userresetpwaction.php',
                method:   'post',
                dataType: 'json',
                data:     { uid: tUid, new_pass: result.value, csrf_token: csrf },
                success: function (res) {
                    var ok = res.status === 'ok'; /* single flag drives both icon and title */
                    Swal.fire({ icon: ok ? 'success' : 'error', title: ok ? 'Done' : 'Error', text: res.message });
                },
                error: function () { Swal.fire({ icon: 'error', title: 'Error', text: 'Server error.' }); }
            });
        });
    });

});
