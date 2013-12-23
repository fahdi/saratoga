<?php
/*
 * - Checks conditionals using JS when form is displayed and values changed
 * - Checks conditionals using PHP when form is submitted (?)
 * 
 * - Form is submitted via AJAX and fields are compared using PHP
 * (works OK, but we should consider optimization or using JS)
 * - wpv_condition()involved (checks against posts, see if anything from there is needed)
 * 
 * - Statements are added using GUI (pre-defined sets od  statements)
 * - Custom conditional statements (written manually in textarea, with formatting help)
 * - Conditional settings are saved on clients side, passed to forms which then
 * controls process
 * 
 * Data [0] - field ID, [1] - jQuery selector, [2] - operation, [3] - value
 * 'conditions' => array(
  array('text', '[name="wpcf[text]"]', '==', 'show'),
  array('text', '[name="wpcf[text]"]', '==', 'showagain'),
  array('text', '[name="wpcf[text]"]', '>', 100),
  )
 */

class WPToolset_Forms_Conditional
{

    private $__formID;
    protected $_data = array(), $_custom_data = array();

    public function __construct( $formID ){
        $this->__formID = trim( $formID, '#' );
        // Register
        wp_register_script( 'wptoolset-form-conditional',
                WPTOOLSET_FORMS_RELPATH . '/js/conditional.js', array('jquery'),
                WPTOOLSET_FORMS_VERSION, false );
        // Render settings
        add_action( 'admin_footer', array($this, 'renderJsonData') );
        add_action( 'wp_footer', array($this, 'renderJsonData') );
        // Custom conditinal AJAX check (called from bootstrap)
//        add_action( 'wp_ajax_wptoolset_custom_conditional',
//                array($this, 'ajaxCheck') );
        wp_enqueue_script( 'wptoolset-form-conditional' );
    }

    public function add( $config ) {
        if ( !empty( $config['conditional'] ) ) {
            $name = "[name=\"{$config['name']}\"]";
            if ( !empty( $config['conditional']['use_custom'] ) ) {
                $evaluate = $config['conditional']['custom'];
                $fields = self::_extractFields( $evaluate );
                foreach ( $fields as $field ) {
                    $key = sprintf( '[name="' . $config['conditional']['name'] . '"]',
                            $field );
                    $data = array(
                        'selector' => '[name="' . $config['name'] . '"]',
                        'post_id' => $config['conditional']['post_id'],
                        'prefix' => $config['conditional']['prefix'],
                        'custom' => $config['conditional']['custom'],
                    );
                    $this->_custom_data[$key][$config['slug']] = $data;
                }//debug( $this->_custom_data );
            } else {
                $data = $config['conditional'];
                $this->_data[$name] = $data;
            }
        }
    }

    public function renderJsonData() {
        if ( !empty( $this->_data ) ) {
            echo '<script type="text/javascript">wptCondData["#'
            . $this->__formID . '"] = ' . json_encode( $this->_data ) . ';</script>';
        }
        if ( !empty( $this->_custom_data ) ) {
            echo '<script type="text/javascript">wptCustomCondData["#'
            . $this->__formID . '"] = ' . json_encode( $this->_custom_data ) . ';</script>';
        }
    }

    function ajaxCheck() {//debug( $_POST );
        add_action( 'get_post_metadata', array($this, 'filterPostMeta') );
        $res = array('passed' => array(), 'failed' => array());
        foreach ( $_POST['wpt'] as $k => $c ) {
            $post = $c['post_id'];
            $evaluate = $c['evaluate'];
            if ( $passed = self::evaluate( $post, $evaluate ) ) {
                $res['passed'][] = $k;
            } else {
                $res['failed'][] = $k;
            }
        }
//        remove_action( 'get_post_metadata', array($this, 'filterPostMeta') );
        echo json_encode( $res );
        die();
    }

    function filterPostMeta( $post, $meta ) {//debug(func_get_args());
        return isset( $_POST['form'][$meta] ) ? $_POST['wpt'][$meta] : null;
    }

    public static function evaluate( $post, $evaluate ) {
        $evaluate = trim( stripslashes( $evaluate ) );
        // Check dates
        $evaluate = wpv_filter_parse_date( $evaluate );
        $fields = self::_extractFields( $evaluate );
        $fields['evaluate'] = $evaluate;
        $check = wpv_condition( $fields, $post );
        if ( !is_bool( $check ) ) {
            return false;
        }
        return $check;
    }

    public static function _extractFields( $evaluate ) {
        $evaluate = trim( stripslashes( $evaluate ) );
        // Check dates
        $evaluate = wpv_filter_parse_date( $evaluate );
        // Add quotes = > < >= <= === <> !==
        $strings_count = preg_match_all( '/[=|==|===|<=|<==|<===|>=|>==|>===|\!===|\!==|\!=|<>]\s(?!\$)(\w*)[\)|\$|\W]/',
                $evaluate, $matches );
        if ( !empty( $matches[1] ) ) {
            foreach ( $matches[1] as $temp_match ) {
                $temp_replace = is_numeric( $temp_match ) ? $temp_match : '\'' . $temp_match . '\'';
                $evaluate = str_replace( ' ' . $temp_match . ')',
                        ' ' . $temp_replace . ')', $evaluate );
            }
        }
        preg_match_all( '/\$([^\s]*)/', $evaluate, $matches );
        $fields = array();
        if ( !empty( $matches ) ) {
            foreach ( $matches[1] as $field_name ) {
                $fields[$field_name] = $field_name;
            }
        }
        return $fields;
    }

}