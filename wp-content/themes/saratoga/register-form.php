<?php
/*
If you would like to edit this file, copy it to your current theme's directory and edit it there.
Theme My Login will always look in your theme's directory first, before using this default template.
*/
?>
  <h2>Please fill out the form below and we will be in touch shortly.</h2>
<div class="login" id="theme-my-login<?php $template->the_instance(); ?>">
	
	<?php $template->the_errors(); ?>
	<form class="form-signin" name="registerform" id="registerform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'register' ); ?>" method="post">
	  <p>   
                <input type="text" name="name" id="name" class="form-control" placeholder="YOUR NAME" required autofocus="" autocomplete="off" />
            </p>
		<p>
			<input type="text" class="form-control" placeholder="USERNAME" required autofocus="" autocomplete="off" name="user_login" id="user_login<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_login' ); ?>" size="20" />
		</p>

		<p>
			<input type="text" class="form-control" placeholder="YOUR EMAIL" required autofocus="" autocomplete="off" name="user_email" id="user_email<?php $template->the_instance(); ?>" class="input" value="<?php $template->the_posted_value( 'user_email' ); ?>" size="20" />
		</p>

		<?php do_action( 'register_form' ); ?>

		<p id="reg_passmail<?php $template->the_instance(); ?>"><?php echo apply_filters( 'tml_register_passmail_template_message', __( 'A password will be e-mailed to you.' ) ); ?></p>

		<p class="submit">
		<button class="btn btn-lg btn-primary btn-block login-new"  type="submit" name="wp-submit" id="wp-submit<?php $template->the_instance(); ?>">REQUEST A LOGIN</button>
			
			<input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'register' ); ?>" />
			<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
			<input type="hidden" name="action" value="register" />
		</p>
	</form>
	<?php $template->the_action_links( array( 'register' => false ) ); ?>
</div>