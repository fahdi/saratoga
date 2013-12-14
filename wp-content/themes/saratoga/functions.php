<?php

//1. Add a new form element...
    add_action('register_form','saratoga_register_form');
    function saratoga_register_form (){
        $first_name = ( isset( $_POST['first_name'] ) ) ? $_POST['first_name']: '';
        ?>
           <input type="text" name="name" id="name" class="form-control" placeholder="YOUR NAME" required autofocus="" autocomplete="off" />
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
    
    ?>