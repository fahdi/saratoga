<?php
//1. Add a new form element...
//add_action('register_form','saratoga_register_form');
function saratoga_register_form (){
    $first_name = ( isset( $_POST['name'] ) ) ? $_POST['name']: '';
    ?>
        <p>   
            <input type="text" name="name" id="name" class="form-control" placeholder="YOUR NAME" required autofocus="" autocomplete="off" />
        </p>
    <?
    }

//2. Add validation. In this case, we make sure first_name is required.
add_filter('registration_errors', 'saratoga_registration_errors', 10, 3);
function saratoga_registration_errors ($errors, $sanitized_user_login, $user_email) {

    if ( empty( $_POST['name'] ) )
        $errors->add( 'name_error', __('<strong>ERROR</strong>: You must include a name.','saratoga') );
   

    return $errors;
}

//3. Finally, save our extra registration user meta.
add_action('user_register', 'saratoga_user_register', 10, 1 );
function saratoga_user_register ($user_id) {
    if ( isset( $_POST['name'] ) ){
    // Get full name, santize it, split it and save in first and last name fields
    $name=explode(' ',sanitize_text_field($_POST['name']));
    // Update name
    if(count($name)>1)
        {
           
            update_user_meta($user_id, 'first_name', $name[0],'');
            update_user_meta($user_id, 'last_name', $name[1],'');      
        }
    }
}

function admin_redirect() {
    if ( !is_user_logged_in()) {
       wp_redirect( 'http://www.google.com' );
       exit;
    }
}
//add_action('get_header', 'admin_redirect');


function saratoga_login_redirect( $redirect_to, $request, $user ){
    //is there a user to check?
    global $user;
    if( isset( $user->roles ) && is_array( $user->roles ) ) {
        //check for admins
        if( in_array( "administrator", $user->roles ) ) {
            // redirect them to the default place
            return $redirect_to;
        } elseif( in_array( "subscriber", $user->roles ) ) {
            return home_url('/about/');
        }
      }     
}
//add_filter("login_redirect", "saratoga_login_redirect", 10, 3);


function my_theme_add_editor_styles() {
add_editor_style(array('css/bootstrap-theme.min.css','css/bootstrap.min.css'));
}
add_action( 'init', 'my_theme_add_editor_styles' );

add_filter('get_previous_post_where', 'my_get_post_where');
add_filter('get_next_post_where', 'my_get_post_where');

function my_get_post_where($sql) {
    return str_replace("publish", "finished", $sql);
}


// Portfolio Custom Post type

add_action('init', 'cptui_register_my_cpt_portfolio');
function cptui_register_my_cpt_portfolio() {
register_post_type('portfolio', array(
'label' => 'Portfolio',
'description' => 'This post type is used to display the portfolio items for an investor',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'map_meta_cap' => true,
'hierarchical' => false,
'rewrite' => array('slug' => 'portfolio', 'with_front' => true),
'query_var' => true,
'has_archive' => true,
'exclude_from_search' => true,
'supports' => array('title','custom-fields','thumbnail'),
'labels' => array (
  'name' => 'Portfolio',
  'singular_name' => 'Portfolio item',
  'menu_name' => 'Portfolio',
  'add_new' => 'Add Portfolio item',
  'add_new_item' => 'Add New Portfolio item',
  'edit' => 'Edit',
  'edit_item' => 'Edit Portfolio item',
  'new_item' => 'New Portfolio item',
  'view' => 'View Portfolio item',
  'view_item' => 'View Portfolio item',
  'search_items' => 'Search Portfolio',
  'not_found' => 'No Portfolio Found',
  'not_found_in_trash' => 'No Portfolio Found in Trash',
  'parent' => 'Parent Portfolio item',
)
) ); }


// Case Studies
add_action('init', 'cptui_register_my_cpt_case_study');
function cptui_register_my_cpt_case_study() {
register_post_type('case_study', array(
'label' => 'Case Studies',
'description' => 'Case Studies',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'map_meta_cap' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'case_study', 'with_front' => true),
'query_var' => true,
'has_archive' => true,
'supports' => array('title','editor','custom-fields'),
'taxonomies' => array('category'),
'labels' => array (
  'name' => 'Case Studies',
  'singular_name' => 'Case Study',
  'menu_name' => 'Case Studies',
  'add_new' => 'Add Case Study',
  'add_new_item' => 'Add New Case Study',
  'edit' => 'Edit',
  'edit_item' => 'Edit Case Study',
  'new_item' => 'New Case Study',
  'view' => 'View Case Study',
  'view_item' => 'View Case Study',
  'search_items' => 'Search Case Studies',
  'not_found' => 'No Case Studies Found',
  'not_found_in_trash' => 'No Case Studies Found in Trash',
  'parent' => 'Parent Case Study',
)
) ); }


// Investments 
add_action('init', 'cptui_register_my_cpt_investment');
function cptui_register_my_cpt_investment() {
register_post_type('investment', array(
'label' => 'Investments',
'description' => '',
'public' => true,
'show_ui' => true,
'show_in_menu' => true,
'capability_type' => 'post',
'map_meta_cap' => true,
'hierarchical' => true,
'rewrite' => array('slug' => 'investment', 'with_front' => true),
'query_var' => true,
'has_archive' => true,
'exclude_from_search' => true,
'supports' => array('title','editor','custom-fields'),
'taxonomies' => array('category'),
'labels' => array (
  'name' => 'Investments',
  'singular_name' => 'Investment ',
  'menu_name' => 'Investments',
  'add_new' => 'Add Investment ',
  'add_new_item' => 'Add New Investment ',
  'edit' => 'Edit',
  'edit_item' => 'Edit Investment ',
  'new_item' => 'New Investment ',
  'view' => 'View Investment ',
  'view_item' => 'View Investment ',
  'search_items' => 'Search Investments',
  'not_found' => 'No Investments Found',
  'not_found_in_trash' => 'No Investments Found in Trash',
  'parent' => 'Parent Investment ',
)
) ); }