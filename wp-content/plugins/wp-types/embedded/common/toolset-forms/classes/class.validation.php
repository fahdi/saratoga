<?php
/*
 * - CakePHP library for PHP validation
 * - jQuery Validation plugin for JS validation
 * 
 * Flow
 * - Hooks to form filtering to collect data
 * - Queues scripts if any field is conditional
 * - Renders collected data as JSON in footer
 * - JS is initialized and checer performed
 * - On form submission PHP checks are performed also (used in specific context,
 * on client's side (CRED or Types) for e.g. aborting saving/processing form)
 */

class WPToolset_Forms_Validation
{

    private $__jsdata = array(), $__cake, $__formID;
    private $__method_map = array(
        'rangelength' => 'between',
    );

    function __construct( $formID ){
        $this->__formID = trim( $formID, '#' );
        // Register
        wp_register_script( 'wptoolset-form-jquery-validation',
                WPTOOLSET_FORMS_RELPATH . '/lib/js/jquery-form-validation/jquery.validate.js',
                array('jquery'), WPTOOLSET_FORMS_VERSION, false );
        wp_register_script( 'wptoolset-form-validation',
                WPTOOLSET_FORMS_RELPATH . '/js/validation.js',
                array('wptoolset-form-jquery-validation'),
                WPTOOLSET_FORMS_VERSION, false );
        wp_register_style( 'wptoolset-form-validation', '' );
        // Filter form HTML for JS validation
        add_action( 'wptoolset_forms_field_html_validation_' . $this->__formID,
                array($this, 'filterFieldHtml') );
        // Filter form  submit for PHP validation
        add_filter( 'wptoolset_form_submit_' . $this->__formID,
                array($this, 'filterFormSubmit') );
        // Render settings
        add_action( 'admin_footer', array($this, 'renderJsonData') );
        add_action( 'wp_footer', array($this, 'renderJsonData') );

        wp_enqueue_script( 'wptoolset-form-validation' );
        wp_enqueue_script( 'underscore' );
    }

    // Collect validation data
    // rendered on bottom of screen as JSON for each form
    // TODO There is functional code in Types
    // TODO Find appropriate way to pass form ID
    function filterFieldHtml( $element ) {
        if ( isset( $element['#validate'] ) ) {
            // element MUST have screen ID
            $id = $element['#id'];
            $data = $element['#validate'];
            $this->__jsdata[$id] = $data;
        }
    }

    // Called from Form_Factory or save_post hook
    // Form Factory should check if element has 'error' property (WP_Error)
    // and use WP_Error::get_error_message() to display error message
    // TODO See how to keep #validate property per element (consider sets like Skype)
    // Enlimbo Forms should assign data
    function filterFormSubmit( $form ) {
        foreach ( $form as &$element ) {
            if ( !empty( $element['#validate'] ) ) {
                foreach ( $element['#validate'] as $method => $args ) {
                    // Set value to be submitted
                    $args['args'][0] = $element['value'];
                    $valid = $this->validateField( $element['#validate'],
                            $element['value'] );
                    if ( $valid ) {
                        $element['error'][] = new WP_Error( 'wpt_validation',
                                $args['message'] );
                    }
                }
            }
        }
        return $form;
    }

    public function validateField( $validation, $value ) {
        try {
            $errors = array();
            foreach ( $validation as $method => $args ) {
                // Set value to be submitted
                $args['args'][0] = $value;
                if ( !$this->validate( $method, $args['args'] ) ) {
                    $errors[] = $args['message'];
                }
            }
            if ( !empty( $errors ) ) {
                throw new Exception();
            }
        } catch ( Exception $e ) {
            return new WP_Error( __CLASS__ . '::' . __METHOD__,
                    'Field not validated', $errors );
        }
        return true;
    }

    // PHP validation
    // Accepts e.g. validate('maxlength', array($value, '15'))
    // TODO May need method name mapping between settings, JS and PHP
    // TODO Finding way to connect it to settings more easily
    public function validate( $method, $args ) {
        $validator = $this->cake();
        $method = $this->__map_method_js_to_php( $method );
        if ( is_callable( array($validator, $method) ) ) {
            return call_user_func_array( array($validator, $method), $args );
        }
        return false;
    }

    function renderJsonData() {
        echo '<script type="text/javascript">wptoolsetValidationData["#'
        . $this->__formID . '"] = ' . json_encode( $this->__jsdata ) . ';</script>';
    }

    function cake() {
        if ( is_null( $this->__cake ) ) {
            require_once WPTOOLSET_FORMS_ABSPATH . '/lib/CakePHP-Validation.php';
            $this->__cake = new WPToolset_Cake_Validation;
        }
        return $this->__cake;
    }

    function __map_method_js_to_php( $method ) {
        return isset( $this->__method_map[$method] ) ? $this->__method_map[$method] : $method;
    }

}