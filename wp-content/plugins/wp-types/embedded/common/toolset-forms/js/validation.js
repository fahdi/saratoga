/* 
 * Validation JS
 * 
 * - Initializes validation on selector (forms)
 * - Adds/removes rules on elements contained in var wptoolsetValidationData
 * - Checks if elements are hidden by conditionals
 * 
 * @see WPCF_Validation::renderJsonData( $selector ) how rules are added
 * Use wp_enqueue_script( 'types-validation' ) to enqueue this script.
 * Use wpcf_form_render_js_validation( $selector ) to render validation data used here.
 * 
 * Used in post-relationship.js in 2 places for callback.
 */
var wptoolsetValidationData = {};
var wptoolsetValidation = (function($) {

    function init() {
        _.each(wptoolsetValidationData, function(elements, formID) {
            _initValidation(formID);
            _setRules(elements, formID);
        });
    }

    function setRules() {
        _.each(wptoolsetValidationData, _setRules);
    }

    function _initValidation(formID) {
        var $form = $(formID);
        $form.validate({
            // :hidden is kept because it's default value.
            // All accepted by jQuery.not() can be added.
            ignore: 'input[type="hidden"],:not(.js-wpt-validate)',
            errorPlacement: function(error, element) {
                error.insertBefore(element);
            },
            highlight: function(element, errorClass, validClass) {
                // Expand container
                $(element).parents('.collapsible').slideDown();
                if (formID == '#post') {
                    var box = $(element).parents('postbox');
                    if (box.hasClass('closed')) {
                        box.find('.handlediv').trigger('click');
                    }
                }
                // $.validator.defaults.highlight(element, errorClass, validClass); // Do not add class to element
            },
            unhighlight: function(element, errorClass, validClass) {
                $("input#publish, input#save-post").removeClass("button-primary-disabled").removeClass("button-disabled");
                // $.validator.defaults.unhighlight(element, errorClass, validClass);
            },
            invalidHandler: function(form, validator) {
                if (formID == '#post') {
                    $('#publishing-action .spinner').css('visibility', 'hidden');
                    $('#publish').bind('click', function() {
                        $('#publishing-action .spinner').css('visibility', 'visible');
                    });
                    $("input#publish").addClass("button-primary-disabled");
                    $("input#save-post").addClass("button-disabled");
                    $("#save-action .ajax-loading").css("visibility", "hidden");
                    $("#publishing-action #ajax-loading").css("visibility", "hidden");
                }
                //wpcfLoadingButtonStop();
            },
            submitHandler: function(form) {
                // Remove failed conditionals
                $('.js-wptcond-failed', $(form)).remove();
                form.submit();
            },
            errorClass: "wpt-form-error"
        });
    }

    function isHiddenByConditional($el) {
        return $el.parents('.form-item').hasClass('js-wptcond-failed');
    }

    function _setRules(elements, formID) {
        if ($(formID).length > 0) {
            _.each(elements, function(rules, id) {
                var element = $('#' + id);
                if (element.length > 0) {
                    if (isHiddenByConditional(element)) {
                        element.rules('remove');
                        element.removeClass('js-wpt-validate');
                    } else {
                        _.each(rules, function(value, rule) {
                            var _rule = {messages: {}};
                            _rule[rule] = _.rest(value.args);
                            if (value.message !== 'undefined') {
                                _rule.messages[rule] = value.message;
                            }
                            element.rules('add', _rule);
                            element.addClass('js-wpt-validate');
                        });
                    }
                }
            });
        }
    }

    return {
        init: init,
        setRules: setRules,
        isHiddenByConditional: isHiddenByConditional
    };

})(jQuery);

jQuery(document).ready(function($) {
    wptoolsetValidation.init();
});