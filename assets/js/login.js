/* login.js — handles login, reset-password, and confirm-password forms (3.6) */
(function ($) {
    'use strict';

    /* ── Login form (login.php) ─────────────────────────────────────── */
    if ($('#loginform').length) {

        /* show/hide password toggle (4.3) */
        $('#togglePwd').on('click', function () {
            var $field = $('#password');
            var isHidden = $field.attr('type') === 'password';
            $field.attr('type', isHidden ? 'text' : 'password');
            $('#eyeIcon').toggleClass('bi-eye bi-eye-slash');
        });

        $('#loginform').on('submit', function (e) {
            e.preventDefault();

            var email    = $('#email').val().trim();
            var password = $('#password').val();

            if (!email) {
                $('#message').text('Please enter your email').css('background-color', 'red');
                return;
            }
            if (!password) {
                $('#message').text('Please enter your password').css('background-color', 'red');
                return;
            }

            var $btn = $(this).find('button[type="submit"]'); /* 4.1 — scoped to this form */
            $btn.prop('disabled', true).html('<span>&#9654;</span> Logging in...'); /* 4.1 — loading state */

            $.ajax({
                url: 'loginaction.php',
                method: 'post',
                data: $(this).serialize(),
                dataType: 'json', /* 3.5 — was 'text' */
                complete: function () {
                    $btn.prop('disabled', false).html('Log In'); /* 4.1 — always re-enable */
                },
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({ icon: 'success', title: response.message, timer: 3500 });
                        setTimeout(function () { window.location.href = 'systemover.php'; }, 3500);
                    } else if (response.status === 'first_login') {
                        Swal.fire({ icon: 'success', title: 'UPDATE PASSWORD', timer: 3000 });
                        setTimeout(function () { window.location.href = 'confirmpass.php'; }, 1000);
                    } else {
                        /* 4.2 — stay on page, clear grammar, show message without redirect */
                        Swal.fire({
                            icon: 'error',
                            title: 'Login Failed',
                            text: response.message,
                            confirmButtonText: 'Try Again'
                        });
                    }
                }
            });
        });

        $(document).on('click', '.signin', function (e) {
            e.preventDefault();
            window.location.href = './register.php';
        });
    }

    /* ── Reset password form (reset-password.php) ───────────────────── */
    if ($('#reset-password').length) {

        $('.reset-password-btn').on('click', function (e) {
            e.preventDefault();

            var email = $('input[name="email"]').val().trim();
            if (!email) {
                Swal.fire({ icon: 'warning', title: 'Please enter your email address' });
                return;
            }

            $.ajax({
                url: 'reset-password-action.php',
                method: 'post',
                data: $('#reset-password').serialize(),
                dataType: 'json', /* 3.5 */
                success: function (response) {
                    /* 4.5 — always success icon (2.2 means server gives neutral message) */
                    Swal.fire({ icon: 'success', title: 'Check your inbox', text: response.message, timer: 4000 });
                    setTimeout(function () { window.location.href = 'login.php'; }, 4000);
                }
            });
        });
    }

    /* ── Confirm password form (confirmpass.php) ────────────────────── */
    if ($('#cpassword_form').length) {

        $('.login-btn').on('click', function (e) {
            e.preventDefault();

            var password  = $('#password').val();
            var cpassword = $('#cpassword').val();

            if (password.length < 8) {
                $('#message').text('Password must be at least 8 characters').css('background-color', 'red');
                return;
            }
            if (password !== cpassword) {
                $('#message').text('Passwords do not match').css('background-color', 'red');
                return;
            }

            $.ajax({
                url: 'confirmaction.php',
                method: 'post',
                data: $('#cpassword_form').serialize(),
                dataType: 'json', /* 3.5 */
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire({ icon: 'success', title: response.message, timer: 5500 });
                        setTimeout(function () { window.location.href = 'login.php'; }, 5500);
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                    }
                }
            });
        });
    }

}(jQuery));
