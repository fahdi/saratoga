<?php

function wptoolset_form( $form_id, $config = array() ){
    global $wptoolset_forms;
    $html = $wptoolset_forms->form( $form_id, $config );
    return apply_filters( 'wptoolset_form', $html, $config );
}

function wptoolset_form_field( $form_id, $config, $value = array() ){
    if ( !empty( $config['repetitive'] ) ) {
        return wptoolset_forms_field_repetitive( $form_id, $config, $value );
    }
    global $wptoolset_forms;
    $html = $wptoolset_forms->field( $form_id, $config, $value );
    return apply_filters( 'wptoolset_fieldform', $html, $config, $form_id );
}

function wptoolset_form_field_edit( $form_id, $config ){
    global $wptoolset_forms;
    $html = $wptoolset_forms->fieldEdit( $form_id, $config );
    return apply_filters( 'wptoolset_fieldform_edit', $html, $config, $form_id );
}

function wptoolset_forms_types_filter_field( $field, $value = null ) {
    $conditional = $field['name'] == 'text' ? array() : array(
        'relation' => 'OR',
        'conditions' => array(
            array('text', '[name="wpcf[text]"]', '==', 'show'),
            array('text', '[name="wpcf[text]"]', '==', 'showagain'),
            array('text', '[name="wpcf[text]"]', '>', 100),
        ),
    );
//    $conditional = $field['name'] == 'text' ? array() : array(
//        'post_id' => 1,
//        'prefix' => 'wpcf-',
//        'use_custom' => true,
//        'custom' => '($text = show) AND ($text > 100)',
//        'name' => 'wpcf[%s]',
//    );
    return array(
        'id' => 'types-' . $field['id'],
        'type' => $field['type'],
        'slug' => $field['id'],
        'title' => $field['name'],
        'description' => $field['description'],
        'name' => "wpcf[{$field['id']}]",
        'value' => $value,
        'repetitive' => (bool) $field['data']['repetitive'],
        'validation' => array(
            'required' => array(
                'args' => array($value, true),
                'message' => 'Required'),
            'maxlength' => array(
                'args' => array($value, 12),
                'message' => 'maxlength of 12 exceeded'
            ),
            'rangelength' => array(
                'args' => array($value, 3, 25),
                'message' => 'input range from 3 to 25'
            ),
        ),
        'conditional' => $conditional,
    );
}

function wptoolset_form_validate_field( $form_id, $config, $value ) {
    global $wptoolset_forms;
    return $wptoolset_forms->validate_field( $form_id, $config, $value );
}

function wptoolset_forms_field_repetitive( $form_id, $config, $values ) {
    global $wptoolset_forms;
    $html = '';
    $config['name'] .= '[]';
    if ( empty( $values ) ) $values = array('');
    foreach ( $values as $value ) {
        $config['value'] = $value;
        foreach ( $config['validation'] as &$data ) {
            $data['args'][0] = $value;
        }
        $_html = $wptoolset_forms->field( $form_id, $config );
        $html .= apply_filters( 'wptoolset_fieldform', $_html, $config, $form_id );
    }
    return apply_filters( 'wptoolset_fieldform_repetitive', $html, $config,
            $form_id );
}