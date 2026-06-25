/* Centralised form validation utility — GRC_V1
   Usage: GRC.validate(formId, rules) → boolean

   Each rule: { field: 'inputId', message: 'Error text', validator: fn (optional) }
   - field      : id of the form element to check
   - message    : text written into the nearest .invalid-feedback element
   - validator  : optional fn(value) → bool for format checks beyond "not empty"

   Returns true only when every rule passes. */

window.GRC = window.GRC || {};

GRC.validate = function (formId, rules) {
    var valid = true;

    /* find the .invalid-feedback closest to an input —
       handles both plain inputs and inputs wrapped in .input-group */
    function findFeedback($el) {
        var $fb = $el.nextAll('.invalid-feedback').first();
        if ($fb.length) return $fb;
        return $el.closest('.input-group').nextAll('.invalid-feedback').first();
    }

    /* clear previous state before re-validating */
    rules.forEach(function (rule) {
        var $el = $('#' + rule.field);
        $el.removeClass('is-invalid is-valid');
        findFeedback($el).removeClass('d-block').text('');
    });

    rules.forEach(function (rule) {
        var $el  = $('#' + rule.field);
        var val  = ($el.val() || '').trim();
        var pass = val !== '';

        /* run optional format check only when field is not empty */
        if (pass && typeof rule.validator === 'function') {
            pass = rule.validator(val);
        }

        if (!pass) {
            $el.addClass('is-invalid');
            var $fb = findFeedback($el);
            if ($fb.length) {
                $fb.text(rule.message || 'This field is required.').addClass('d-block');
            }
            valid = false;
        } else {
            $el.addClass('is-valid');
        }
    });

    return valid;
};
