<?php
require 'forms.php';

function pre($val) {
    echo "<pre>";
    print_r($val);
    echo "</pre>";
}

// see classes/abstract.field.php
abstract class FieldAbstract {    
    abstract public function elaborateFieldForm(&$form);
}

// see classes/class.field_factory.php
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

// see classes/abstract.form.php
abstract class FormAbstract {
    abstract public function createForm($nameForm); 
    abstract public function displayForm($nameForm); 
    abstract public function addTextfield($title, $name, $value, $description, $attr);
    abstract public function addTextarea($title, $name, $value, $description, $attr);
    abstract public function addSubmit($name, $value, $attr);
    abstract public function addButton($name, $value, $attr);
    abstract public function formNameExists(&$nameForm);
}

// see classes/class.form_factory.php
class FormFactory extends FormAbstract {
    //TODO: Add hadler/observer info
    private $field_count = 0;
    private $form = array();
    private $nameForm;
    private $theForm;
    
    public function __construct($nameForm = 'default') {
        if (!isset($GLOBALS['formFactories'])) $GLOBALS['formFactories'] = array();
        $this->nameForm = $nameForm;
        $this->field_count = 0;
        $this->theForm = new Enlimbo_Forms();
    }
    
    public function formNameExists(&$nameForm) {
        if (!in_array($nameForm, $GLOBALS['formFactories'])) {
            $GLOBALS['formFactories'][] = $nameForm;
            return false;
        } else {
            echo "Form name already exists!";
            return true;
        }
    }
    
    public function addTextfield($title, $name, $value = '', $description = '', $attr = array()) {       
        $global_name_field = $this->nameForm.'_field_'.$this->field_count;
        $fieldData = array(
            '#type' => 'textfield',
            '#title' => $title,
            '#description' => $description,
            '#name' => $name,
            '#attributes' => $attr
        );
        new FieldFactory($global_name_field, $fieldData, $this->form);
        $this->field_count++;
    }
    
    public function addTextarea($title, $name, $value = '', $description = '', $attr = array('style' => 'width:300px;height:100px;')) {
        $global_name_field = $this->nameForm.'_field_'.$this->field_count;
        $fieldData = array(
            '#type' => 'textarea',
            '#title' => $title,
            '#description' => $description,
            '#name' => $name,
            '#attributes' => $attr,
        );
        new FieldFactory($global_name_field, $fieldData, $this->form);
        $this->field_count++;
    }
    
    public function addSubmit($name = 'submit', $value = 'Submit', $attr = array()) {
        $global_name_field = $this->nameForm.'_field_'.$this->field_count;
        $fieldData = array(
            '#name' => 'submit',
            '#type' => 'submit',
            '#value' => $value,
            '#attributes' => $attr
        );
        new FieldFactory($global_name_field, $fieldData, $this->form);
        $this->field_count++;
    }
    
    public function addButton($name, $value, $attr = array()) {
        $global_name_field = $this->nameForm.'_field_'.$this->field_count;
        $fieldData = array(
            '#name' => $name,
            '#type' => 'button',
            '#value' => $value,
            '#attributes' => $attr
        );
        new FieldFactory($global_name_field, $fieldData, $this->form);
        $this->field_count++;
    }    
    
    public function createForm($nameForm = 'default') {
        if ($this->formNameExists($nameForm)) return;
        $myform = $this->theForm;
        $this->theForm->autoHandle('myform', $this->form);
        
        $out = "";
        $out .= '<form method="post" action="">';
        $out .= $this->theForm->renderElements($this->form);
        $out .= '</form>'; 
        
        return $out;
    }

    public function displayForm($nameForm = 'default') {
        if ($this->formNameExists($nameForm)) return;
        $myform = $this->theForm;
        $this->theForm->autoHandle('myform', $this->form);
        
        echo '<form method="post" action="">';
        echo $this->theForm->renderForm();
        echo '</form>';    
    }    
    
    public function __toString() {
        return join("\n", $this->elements);
    }
}

/*
 * pre($_REQUEST);

$frm = new FormFactory();
$frm->addTextfield("input", "text1");
$frm->addTextarea("textarea", "text2");
$frm->addSubmit();
echo $frm->createForm();
?>
*/
