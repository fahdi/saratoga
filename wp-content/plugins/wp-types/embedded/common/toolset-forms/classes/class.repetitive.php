<?php
/*
 * Repetitive controller
 * 
 * If field is repetitive
 * - queues repetitive CSS and JS
 * - renders JS templates in admin footer
 */

class WPToolset_Forms_Repetitive
{

    private $__templates = array(), $__formID;

    function __construct( $formID ){
        $this->__formID = trim( $formID, '#' );
        // Register
        wp_register_script( 'wptoolset-forms-repetitive',
                WPTOOLSET_FORMS_RELPATH . '/js/repetitive.js', array('jquery'),
                WPTOOLSET_FORMS_VERSION, false );
        wp_register_style( 'wptoolset-forms-repetitive', '' );
        // Render settings
        add_action( 'admin_footer', array($this, 'renderTemplates') );
        add_action( 'wp_footer', array($this, 'renderTemplates') );

        wp_enqueue_script( 'wptoolset-forms-repetitive' );
        wp_enqueue_script( 'underscore' );
        
        // Add repetitive controls
        add_filter('wptoolset_fieldform_repetitive', array($this, 'addControls'), 10, 3);
    }

    function add( $config, $html ) {
        if ( !empty( $config['repetitive'] ) ) {
            $this->__templates[$config['id']] = $html;
        }
    }
    
    function addControls($html, $config, $formID) {
        $html = '<div class="js-wpt-rep-wrap">' . $html . '<a href="#" class="js-wpt-forms-rep-ctl button-primary" data-wpt-field="' . $config['id'] . '">Add new field</a></div>';
        return $html;
    }

    function renderTemplates() {
        foreach ( $this->__templates as $id => $template ) {
            echo '<script type="text/html" id="tpl-wptoolset-formfield-' . $id . '">'
            . $template . '</script>';
        }
    }

}