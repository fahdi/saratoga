/* 
 * Repetitive JS.
 */
var wptRep = (function($) {
    function init() {
        $('.js-wpt-forms-rep-ctl').on('click', function() {
            var $this = $(this), tpl = $('<div>' + $('#tpl-wptoolset-formfield-'+$this.data('wpt-field')).html() + '</div>');
            $('[id]', tpl).each(function() {
                var $this = $(this), uniqueId = _.uniqueId('wpt-form-el');
                tpl.find('label[for="' + $this.attr('id') + '"]').attr('for', uniqueId);
                $this.attr('id', uniqueId);
            });
            $this.before(tpl.html());
            return false;
        });
    }
    return {
        init: init
    };
})(jQuery);

jQuery(document).ready(wptRep.init);