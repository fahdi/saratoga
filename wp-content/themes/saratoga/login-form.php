<h2>Welcome, you can login securely below.</h2>
<?php $template->the_action_template_message( 'login' ); ?>
<?php $template->the_errors(); ?>
<form  class="form-signin" name="loginform" id="loginform<?php $template->the_instance(); ?>" action="<?php $template->the_action_url( 'login' ); ?>" method="post">

	<input type="email" name="log" id="user_login<?php $template->the_instance(); ?>" class="form-control" placeholder="EMAIL" value="<?php $template->the_posted_value( 'log' ); ?>" size="20" required autofocus/>
    <input type="password" class="form-control" placeholder="PASSWORD" required name="pwd" id="user_pass<?php $template->the_instance(); ?>">

<?php do_action( 'login_form' ); ?>

<p class="forgetmenot">
	<input name="rememberme" type="checkbox" id="rememberme<?php $template->the_instance(); ?>" value="forever" />
	<label for="rememberme<?php $template->the_instance(); ?>"><?php esc_attr_e( 'Remember Me' ); ?></label>
</p>
<?php //$template->the_action_links( array( 'login' => false ) ); ?>
<span id="forgotpass"><a href="<?php echo wp_lostpassword_url( get_bloginfo('url') ); ?>" title="Lost Password">forgot password?</a></span>
    <button class="btn btn-lg btn-primary btn-block" id="loginbutton" type="submit">LOGIN</button>        
    <input type="hidden" name="redirect_to" value="<?php $template->the_redirect_url( 'login' ); ?>" />
	<input type="hidden" name="instance" value="<?php $template->the_instance(); ?>" />
</form>
