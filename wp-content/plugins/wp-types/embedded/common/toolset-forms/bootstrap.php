<?php
require_once 'api.php';

define( 'WPTOOLSET_FORMS_VERSION', '0.1' );
define( 'WPTOOLSET_FORMS_ABSPATH', dirname( __FILE__ ) );
define( 'WPTOOLSET_FORMS_RELPATH', plugins_url( '', __FILE__ ) );

class WPToolset_Forms_Bootstrap
{

    private $__forms;

    public final function __construct(){
        // Custom conditinal AJAX check
        add_action( 'wp_ajax_wptoolset_custom_conditional',
                array($this, 'ajaxCustomConditional') );
    }

    // returns HTML
    public function field( $form_id, $config, $value ){
        $form = $this->form( $form_id, array() );
        return $form->metaform( $config, $value );
    }

    // returns HTML
    public function fieldEdit( $form_id, $config ){
        $form = $this->form( $form_id, array() );
        return $form->editform( $config );
    }

    public function form( $form_id, $config = array() ) {
        if ( isset( $this->__forms[$form_id] ) ) {
            return $this->__forms[$form_id];
        }
        require_once WPTOOLSET_FORMS_ABSPATH . '/classes/class.form_factory.php';
        return $this->__forms[$form_id] = new FormFactory( $form_id, $config );
    }

    public function validate_field( $form_id, $config, $value ) {
        if ( empty( $config['validation'] ) ) {
            return true;
        }
        $form = $this->form( $form_id, array() );
        return $form->validateField( $config, $value );
    }

    public function ajaxCustomConditional() {
        require_once WPTOOLSET_FORMS_ABSPATH . '/classes/class.conditional.php';
        WPToolset_Forms_Conditional::ajaxCheck();
    }

}

$wptoolset_forms = new WPToolset_Forms_Bootstrap();
