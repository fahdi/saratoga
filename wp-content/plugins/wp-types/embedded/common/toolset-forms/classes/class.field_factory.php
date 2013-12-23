<?php
require 'abstract.field.php';
class FieldFactory extends FieldAbstract {
    //TODO: Add validation info
    //TODO: Add style info
    private $nameField;
    private $dataField = array();
        
    public function __construct($name, $data, &$form) {
        $this->nameField = $name;
        $this->dataField = $data;
        $this->formField = $form;
        $this->elaborateFieldForm($form);
    }
    
    public function elaborateFieldForm(&$form) {
        $form[$this->nameField] = $this->dataField;        
    }
    
}
