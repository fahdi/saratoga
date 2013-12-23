<?php
require_once 'abstract.form.php';
require_once 'class.eforms.php';
require_once 'class.field_factory.php';

class FormFactory extends FormAbstract
{

    //TODO: Add hadler/observer info
    private $field_count = 0;
    private $form = array();
    private $nameForm;
    private $theForm;
    protected $_fields = array(), $_validation, $_conditional, $_repetitive;

    public function __construct( $nameForm = 'default' ) {
        if ( !isset( $GLOBALS['formFactories'] ) )
                $GLOBALS['formFactories'] = array();
        $this->nameForm = $nameForm;
        $this->field_count = 0;
        $this->theForm = new Enlimbo_Forms( $nameForm );
    }

    public function formNameExists( &$nameForm ) {
        if ( !in_array( $nameForm, $GLOBALS['formFactories'] ) ) {
            $GLOBALS['formFactories'][] = $nameForm;
            return false;
        } else {
            echo "Form name already exists!";
            return true;
        }
    }

    public function addTextfield( $title, $name, $value = '', $description = '',
            $attr = array() ) {
        $global_name_field = $this->nameForm . '_field_' . $this->field_count;
        $fieldData = array(
            '#type' => 'textfield',
            '#title' => $title,
            '#description' => $description,
            '#name' => $name,
            '#attributes' => $attr,
            '#value' => $value,
        );
        new FieldFactory( $global_name_field, $fieldData, $this->form );
        $this->field_count++;
    }

    public function addTextarea( $title, $name, $value = '', $description = '',
            $attr = array('style' => 'width:300px;height:100px;') ) {
        $global_name_field = $this->nameForm . '_field_' . $this->field_count;
        $fieldData = array(
            '#type' => 'textarea',
            '#title' => $title,
            '#description' => $description,
            '#name' => $name,
            '#attributes' => $attr,
            '#value' => $value,
        );
        new FieldFactory( $global_name_field, $fieldData, $this->form );
        $this->field_count++;
    }

    public function addSubmit( $name = 'submit', $value = 'Submit',
            $attr = array() ) {
        $global_name_field = $this->nameForm . '_field_' . $this->field_count;
        $fieldData = array(
            '#name' => 'submit',
            '#type' => 'submit',
            '#value' => $value,
            '#attributes' => $attr
        );
        new FieldFactory( $global_name_field, $fieldData, $this->form );
        $this->field_count++;
    }

    public function addButton( $name, $value, $attr = array() ) {
        $global_name_field = $this->nameForm . '_field_' . $this->field_count;
        $fieldData = array(
            '#name' => $name,
            '#type' => 'button',
            '#value' => $value,
            '#attributes' => $attr
        );
        new FieldFactory( $global_name_field, $fieldData, $this->form );
        $this->field_count++;
    }

    public function createForm( $nameForm = 'default' ) {
        if ( $this->formNameExists( $nameForm ) ) return;
        $this->theForm->autoHandle( $nameForm, $this->form );

        $out = "";
        $out .= '<form method="post" action="" id="' . $nameForm . '">';
        $out .= $this->theForm->renderElements( $this->form );
        //$out .= $this->theForm->renderForm();
        $out .= '</form>';

        return $out;
    }

    public function displayForm( $nameForm = 'default' ) {
        if ( $this->formNameExists( $nameForm ) ) return;
        $myform = $this->theForm;
        $this->theForm->autoHandle( $nameForm, $this->form );

        echo '<form method="post" action="" id="' . $nameForm . '">';
        echo $this->theForm->renderForm();
        echo '</form>';
    }

    // Needed to display each field e.g. on post edit screen
    public function displayFields( $elements = null ) {
        if ( is_array( $elements ) ) {
            return $this->theForm->renderElements( $elements );
        }
        return $this->theForm->renderElements( $this->form );
    }

    public function addField( $config ){
        if ( !is_wp_error( $field = $this->loadField( $config['type'] ) ) ) {
            $form = $field->metaform( $config, $this );
            $this->checkValidation( $config );
            $this->checkConditional( $config );
            $this->checkRepetitive( $config );
            $global_name_field = $this->nameForm . '_field_' . $this->field_count;
            foreach ( $form as $form_element ) {
                new FieldFactory( $global_name_field, $form_element, $this->form );
                $this->field_count++;
            }
        }
    }

    public function metaform( $config, $value ){
        if ( !is_wp_error( $field = $this->loadField( $config['type'] ) ) ) {
            $field = $this->loadField( $config['type'] );
            $form = $field->metaform( $config, $this );
            $this->checkValidation( $config );
            $this->checkConditional( $config );
            $this->checkRepetitive( $config, $field );
            return $this->displayFields( $form );
        }
    }

    public function editform( $config ){
        if ( !is_wp_error( $field = $this->loadField( $config['type'] ) ) ) {
            $field = $this->loadField( $config['type'] );
            $form_element = $field->editform( $config, $this );
            $this->checkValidation( $config );
            $this->checkConditional( $config );
            $this->checkRepetitive( $config );
            return $this->displayFields( $form_element );
        }
    }

    public function loadField( $type ){
        if ( isset( $this->_fields[$type] ) ) return $this->_fields[$type];
        $file = WPTOOLSET_FORMS_ABSPATH . '/classes/class.' . strtolower( $type ) . '.php';
        if ( file_exists( $file ) ) {
            require_once 'class.' . $type . '.php';
            if ( class_exists( 'WPToolset_Forms_' . ucfirst( $type ) ) ) {
                $class = 'WPToolset_Forms_' . ucfirst( $type );
                $field = new $class;
            }
        } else {
            // third party fields $type => __FILE__
            $third_party_fields = apply_filters( 'wptoolset_registered_fields',
                    array() );
            if ( isset( $third_party_fields[$type] ) && file_exists( $third_party_fields[$type] ) ) {
                require_once $third_party_fields[$type];
                if ( class_exists( 'WPToolset_Forms_' . ucfirst( $type ) ) ) {
                    $class = 'WPToolset_Forms_' . ucfirst( $type );
                    $field = new $class;
                }
            }
        }
        if ( isset( $field ) ) {
            $field->enqueueScripts();
            $field->enqueueStyles();
            return $this->_fields[$type] = $field;
        }
        return new WP_Error( 'wptoolset_forms', 'wrong field type' );
    }

    public function checkValidation( $config ) {
        if ( isset( $config['validation'] ) && is_null( $this->_validation ) ) {
            require_once 'class.validation.php';
            $this->_validation = new WPToolset_Forms_Validation( $this->nameForm );
        }
    }

    public function checkConditional( $config ) {
        if ( !empty( $config['conditional'] ) ) {
            if ( is_null( $this->_conditional ) ) {
                require_once 'class.conditional.php';
                $this->_conditional = new WPToolset_Forms_Conditional( $this->nameForm );
            }
            $this->_conditional->add( $config );
        }
    }

    public function checkRepetitive( $config, $field ) {
        if ( !empty( $config['repetitive'] ) ) {
            if ( is_null( $this->_repetitive ) ) {
                require_once 'class.repetitive.php';
                $this->_repetitive = new WPToolset_Forms_Repetitive();
            }
            $config['value'] = null;
            $html = $this->displayFields( $field->metaform($config, $this) );
            $this->_repetitive->add( $config, $html );
        }
    }

    public function validateField( $config, $value ) {
        $this->checkValidation( $config );
        return $this->_validation->validateField( $config['validation'], $value );
    }

    public function __toString() {
        return join( "\n", $this->elements );
    }

}
