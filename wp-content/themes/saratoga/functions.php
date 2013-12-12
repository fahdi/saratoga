<?php

//1. Add a new form element...
    add_action('register_form','saratoga_register_form');
    function saratoga_register_form (){
        $first_name = ( isset( $_POST['first_name'] ) ) ? $_POST['first_name']: '';
        ?>
        <p>
            <label for="first_name"><?php _e('First Name','mydomain') ?><br />
                <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr(stripslashes($first_name)); ?>" size="25" /></label>
        </p>
        <p>
            <label for="first_name"><?php _e('First Name','mydomain') ?><br />
                <input type="text" name="first_name" id="first_name" class="input" value="<?php echo esc_attr(stripslashes($first_name)); ?>" size="25" /></label>
        </p>
        <?php
    }

    //2. Add validation. In this case, we make sure first_name is required.
    add_filter('registration_errors', 'saratoga_registration_errors', 10, 3);
    function saratoga_registration_errors ($errors, $sanitized_user_login, $user_email) {

        if ( empty( $_POST['first_name'] ) )
            $errors->add( 'first_name_error', __('<strong>ERROR</strong>: You must include a first name.','mydomain') );
        if ( empty( $_POST['first_name'] ) )
            $errors->add( 'first_name_error', __('<strong>ERROR</strong>: You must include a first name.','mydomain') );

        return $errors;
    }

    //3. Finally, save our extra registration user meta.
    add_action('user_register', 'saratoga_user_register');
    function saratoga_user_register ($user_id) {
        if ( isset( $_POST['first_name'] ) )
            update_user_meta($user_id, 'first_name', $_POST['first_name']);

        if ( isset( $_POST['first_name'] ) )
            update_user_meta($user_id, 'first_name', $_POST['first_name']);
    }

    ?>