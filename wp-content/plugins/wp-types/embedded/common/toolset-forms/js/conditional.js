/* 
 * Conditional JS.
 * 
 * Data [0] - field ID, [1] - jQuery selector, [2] - operation, [3] - value
 * 'conditions' => array(
 array('text', '[name="wpcf[text]"]', '==', 'show'),
 array('text', '[name="wpcf[text]"]', '==', 'showagain'),
 array('text', '[name="wpcf[text]"]', '>', 100),
 )
 */
var wptCondData = {};
var wptCustomCondData = {};
wptCond = (function($) {
    function init() {
        _.each(wptCondData, function(conditional, formID) {
            _.each(conditional, function(c, el, list) {
                showHide(formID, el, c.conditions, c.relation);
                _.each(c.conditions, function(data) {
                    bindChange(formID, data[1], function() {
                        showHide(formID, el, c.conditions, c.relation);
                    });
                });
            });
        });
        _.each(wptCustomCondData, function(triggers, formID) {
            _.each(triggers, function(c, trigger) {
                $(trigger, $(formID)).addClass('js-wpt-cond-check');
                bindChange(formID, trigger, function() {
                    custom(formID, trigger, c);
                });
            });
        });
    }
    function showHide(formID, el, c, rel) {
        var passed = compare(formID, c, rel);
        if (!passed) {
            $(el, $(formID)).parents('.form-item').hide().addClass('js-wptcond-failed');
        } else {
            $(el, $(formID)).parents('.form-item').show().removeClass('js-wptcond-failed');
        }
        if (typeof wptoolsetValidation != 'undefined') {
            wptoolsetValidation.setRules();
        }
    }
    function bindChange(formID, f, func) {
        var $f = $(f, $(formID));
        if ($f.hasClass('radio') || $f.hasClass('checkbox')) {
            $f.bind('click', func);
        } else if ($f.hasClass('select')) {
            $f.bind('change', func);
        } else if ($f.hasClass('js-wpt-date')) {
            $f.bind('wptDateBlur', func);
        } else {
            $f.bind('blur', func);
        }
    }
    function compare(formID, c, rel) {
        var passedOne = false, passedAll = true;
        _.each(c, function(data) {
            var $f = $(data[1], $(formID)), o = data[2], v = data[3], passed = false;
            // Date dd/mm/Y
            //var val = new Date($f.val()).getTime();
            switch (o) {
                case '===':
                case '==':
                    passed = $f.val() == v;
                    break;
                case '!==':
                case '!=':
                    passed = $f.val() != v;
                    break;
                case '>':
                    passed = parseInt($f.val()) > parseInt(v);
                    break;
                case '<':
                    passed = parseInt($f.val()) < parseInt(v);
                    break;
                case '>=':
                    passed = parseInt($f.val()) >= parseInt(v);
                    break;
                case '<=':
                    passed = parseInt($f.val()) <= parseInt(v);
                    break;
            }
            if (!passed) {
                passedAll = false;
            } else {
                passedOne = true;
            }
        });

        if (rel === 'AND' && passedAll)
            return true;
        if (rel === 'OR' && passedOne)
            return true;
        return false;
    }
    function custom(formID, el, c) {
        var data = {wpt: c, action: 'wptoolset_custom_conditional'};
        data.form = $('.js-wpt-cond-check', $(formID)).serialize();
        $.post(ajaxurl, data, function(res) {
            _.each(res.passed, function(k) {
                $(c[k].selector).show();
            });
            _.each(res.failed, function(k) {alert(k);
                $(c[k].selector).hide();
            });
        }, 'json')
                .done(function() {
            //alert("second success");
        })
                .fail(function() {
            alert("error");
        })
                .always(function() {
            //alert("finished");
        });
    }
    return {
        init: init
    };
})(jQuery);

jQuery(document).ready(function($) {
    wptCond.init();
});