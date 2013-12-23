<?php
require_once 'abstract.types_field.php';

class WPToolset_Forms_Textfield extends WPToolset_Types_Field
{

    // Use construct to register scripts and styles
    public function __construct(){
        //wp_register_script( 'toolset-forms-textfield', '/textfield.js' );
        //wp_register_style( 'toolset-forms-textfield', '/textfield.css' );
    }

    // Auto-called from Loader on field demand
    public function enqueueScripts() {
        //wp_enqueue_script( 'toolset-forms-textfield' );
    }

    // Auto-called from Loader on field demand
    public function enqueueStyles() {
        //wp_enqueue_style( 'toolset-forms-textfield' );
    }

    // Types will use this to define display mode
    // e.g. CRED on frontend, Types on post edit screen
    public function metaform( $config, &$form ) {
        extract( $config );
        $metaform = array();
        $metaform[] = array(
            '#type' => 'textfield',
            '#title' => $title,
            '#description' => $description,
            '#name' => $name,
            '#value' => $value,
            '#validate' => $config['validation'],
        );
        return $metaform;
    }

    // Types will use this to define edit field form
    // e.g. CRED edit form, Types group of fields edit screen
    public function editform( $config, &$form ) {
        extract( $config );
        $form->addTextfield( 'slug' );
        $form->addTextArea( 'description' );
    }
    
    public function mediaEditor() {
        return array();
    }

}
