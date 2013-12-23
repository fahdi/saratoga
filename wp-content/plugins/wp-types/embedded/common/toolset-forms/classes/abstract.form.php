<?php

abstract class FormAbstract {
    abstract public function createForm($nameForm); 
    abstract public function displayForm($nameForm); 
    abstract public function addTextfield($title, $name, $value, $description, $attr);
    abstract public function addTextarea($title, $name, $value, $description, $attr);
    abstract public function addSubmit($name, $value, $attr);
    abstract public function addButton($name, $value, $attr);
    abstract public function formNameExists(&$nameForm);

    // Adds field as class.skype.php to form
    abstract public function addField( $config );
    // Loads field (queue script and styles)
    abstract public function loadField( $type );
    // Render set of fields or current form without form tags
    abstract public function displayFields( $elements = null );
    // Single field form (not added to form fields)
    abstract public function metaform( $config, $value );
    // Single field edit  form (not added to form fields)
    abstract public function editform( $config );
    // Checks if validation is required and inits it per form
    abstract public function checkValidation( $config );
}
