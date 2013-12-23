<?php
require_once 'abstract.types_field.php';

class WPToolset_Forms_Skype extends WPToolset_Types_Field
{

    protected $validation = array('required', 'url');
    protected $defaults = array('skypename' => '', 'button_style' => '');

    public function __construct(){
        wp_register_script( 'wptoolset-forms-skype',
                WPTOOLSET_FORMS_RELPATH . '/js/skype.js', array('jquery'),
                WPTOOLSET_FORMS_VERSION, true );
        wp_register_style( 'wptoolset-forms-skype',
                WPTOOLSET_FORMS_RELPATH . '/js/textfield.css',
                array(), WPTOOLSET_FORMS_VERSION );
    }

    public function enqueueScripts() {
        wp_enqueue_script( 'wptoolset-forms-skype' );
    }

    public function enqueueStyles() {
        wp_enqueue_style( 'wptoolset-forms-skype' );
    }

    public function metaform( $config, &$form ) {
        extract( $config );
        $value = wp_parse_args( isset($value) ? $value : array(), $this->defaults );
        $skype_form[] = array(
            '#type' => 'textfield',
            '#title' => $title,
            '#description' => $description,
            '#name' => $name . '[skypename]',
            '#attributes' => array(),
            '#value' => $value['skypename'],
            '#validate' => $config['validation'],
        );
        $skype_form[] = array(
            '#name' => '',
            '#type' => 'button',
            '#title' => 'Edit button',
            '#attributes' => array('class' => 'js-wpt-skype-button button-secondary'),
        );
        $skype_form[] = array(
            '#type' => 'markup',
            '#markup' => "<img src=\"{$value['button_style']}\"",
        );
        return $skype_form;
    }

    public function editform( $config, &$form ) {
        extract( $config );
        $value = wp_parse_args( isset($value) ? $value : array(), $this->defaults );
        $form[] = array(
            '#type' => 'radio',
            '#title' => $title,
            '#description' => __('Default button', 'wptoolset'),
            '#name' => $name . '[button_style]',
            '#attributes' => $attr,
            '#default_value' => $value['button_style'],
        );
        $form[] = array(
            '#type' => 'markup',
            '#markup' => "<img src=\"preview-{$value['button_style']}\"",
        );
        return $form;
    }

    public function mediaEditor(){
        return array();
    }

}
