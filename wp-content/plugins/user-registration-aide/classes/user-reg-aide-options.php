<?php
/**
 * User Registration Aide - Options
 * Handles all options and related functions for plugin
 * Plugin URI: http://creative-software-design-solutions.com/wordpress-user-registration-aide-force-add-new-user-fields-on-registration-form/
 * Version: 1.3.1
 * Author: Brian Novotny
 * Author URI: http://creative-software-design-solutions.com/
*/

/*For Debugging and Testing Purposes ------------


*/

// ----------------------------------------------

require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
require_once ("user-reg-aide-admin.php");
require_once (URA_PLUGIN_PATH."user-registration-aide.php");
require_once ("user-reg-aide-newFields.php");
require_once ("user-reg-aide-regForm.php");

/**
 * Class added for user options
  *
 * @category Class
 * @since 1.3.0
 * @updated 1.3.0
 * @access private
 * @author Brian Novotny
 * @website http://creative-software-design-solutions.com
*/

class URA_OPTIONS
{

	public static $instance;
	
	public function __construct() {
		$this->URA_OPTIONS();
	}
		
	function URA_OPTIONS() { //constructor
	
		global $wp_version, $new_fields, $admin, $admin_page, $ual, $ual_admin_settings;
		self::$instance = $this;
	}

	/**
	 * Adds the new default options for the options fields on admin forms
	 *
	 * @since 1.2.0
	 * @updated 1.3.0
	 * @handles action 'init' Line 118 user-registration-aide.php
	 * @access private
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/

	function csds_userRegAide_DefaultOptions(){
		
		global $wpdb;
		$options = array();
		$options = get_option('csds_userRegAide_Options');
		
		if(empty($options)){
		
			$options = $this->csds_userRegAide_defaultOptionsArray();
			update_option("csds_userRegAide_Options", $options);
			
			// For updates from older versions
			
			delete_option('csds_userRegAide_support');
			delete_option('csds_display_link');
			delete_option('csds_display_name');
			delete_option('csds_userRegAide_dbVersion');
			
			
		}else{
			$options = get_option('csds_userRegAide_Options');
		}
		//return $options;
	}
	
	/**
	 * Array for all the new default options for the options fields on admin forms
	 *
	 * @since 1.2.5
	 * @updated 1.3.0
	 * @handles line 67, 407 & 456 &$this
	 * @returns array $csds_userRegAide_Options - Default options array
	 *
	 * @access private
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/

	function csds_userRegAide_defaultOptionsArray(){
		global $current_site;
		$site_name = '';
		$login_url = '';
		if(!is_multisite()){
			$site_name = get_option('blogname');
			$url = wp_login_url();
			$login_url = $url;
			$registered_url = $url.'?checkemail=registered';
		}else{
			$site_name = $current_site->site_name;
			$url_login = network_site_url('/wp-login.php');
			$signup_url = network_site_url('/wp-signup.php');
			$login_url = $url_login;
			$registered_url = $signup_url;
		}
		$csds_userRegAide_Options = array(
			"csds_userRegAide_db_Version" => "1.3.4",
			"select_pass_message" => "2",
			"password"			=>	"2",
			"registration_form_message" => "You can use the password you entered here to log in right away, and for your reference, your registration details will be emailed after signup",
			"agreement_message" => "I have read and understand and agree to the terms and conditions of the guidelines/agreement policy required for this website provided in the link below",
			"empty"	=>	"No password Entered!",
			"short" => "Password Entered is too Short!", 
			"bad" => "Password Entered is Bad, Too Weak",
			"good" => "Password Entered is fairly tough and is good to accept",
			"strong" => "Password Entered is very strong!",
			"mismatch" => "Password Entered does not match Password Confirm! Try Again Please!",
			"show_support" => "2",
			"support_display_link" => "http://creative-software-design-solutions.com/#axzz24C84ExPC",
			"support_display_name" => "Creative Software Design Solutions",
			"show_logo" => "2",
			"logo_url" => "wp-admin/images/wordpress-logo.png",
			"show_background_image" => "2",
			"background_image_url" => "",
			"show_background_color" => "2",
			"reg_background_color" => "#FFFFFF",
			"show_reg_form_page_color" => "2",
			"reg_form_page_color" => "#FFFFFF",
			"show_reg_form_page_image" => "2",
			"reg_form_page_image" => "",
			"show_login_text_color" => "2",
			"login_text_color" => "#BBBBBB",
			"hover_text_color" => "#FF0000",
			"show_shadow" => "2",
			"shadow_size" => "0px",
			"shadow_color" => "#FFFFFF",
			"change_logo_link" => "2",
			"show_custom_agreement_link" => "2",
			"agreement_title" => "Agreement Policy",
			"show_custom_agreement_message" => "2",
			"show_custom_agreement_checkbox" => "2",
			"new_user_agree" => "2",
			"agreement_link" => esc_url_raw(site_url()),
			"show_login_message" =>	"2",
			"login_message"		=>	"Welcome to " . get_bloginfo('name') . "! Please login for our site here!",
			"reg_top_message"		=>	"Welcome to " . get_bloginfo('name') . "! Please register for our site here!",
			"login_messages_login" 	=>	"Extra Login messages",
			"login_messages_lost_password" 	=>	"Please enter your username(login name) or email address here. You will then soon receive a link to create a new password via email!",
			"login_messages_logged_out" 	=>	"Thank you for visiting us at  " . get_bloginfo('name') . "! You are now logged out",
			"login_messages_registered" 	=>	"Thank you for registering with us at  " . get_bloginfo('name') . "! You account is now active!",
			"reset_password_messages_security"		=> 	"Enter your new password here and confirm it, and enter your correct security question and answer, if you don't have one, just ignor that step for now and after you complete this, go to your profile and add a security question and answer to your profile to improve your personal security as well as our websites! Thank you!",
			"reset_password_messages_normal"		=> 	"Enter your new password below and confirm it, Thank you!",
			"reset_password_confirm"		=>	"You may now check your email for a confirmation link to reset your password!",
			"reset_password_success_security"		=>	'You have succesfully reset your password! You may now login again  <a href="' . esc_url_raw( wp_login_url() ) . '">' . __( 'Log in here' ) . '</a> with your new password!',
			"reset_password_success_normal"		=>	'You have succesfully changed your password! You may now login again  <a href="' . esc_url_raw( wp_login_url() ) . '">' . __( 'Log in here' ) . '</a> with your new password!',
			"add_security_question"			=>	"2",
			"rp_fill_in_security_question"		=>	"You haven't added your security question and security answer yet, please do so on your profile page after you have finished resetting your password!",
			"fill_in_security_question_answer"		=>	"You haven't added your security question and security answer yet, please do so on your profile page to improve your personal security!",
			"fill_in_security_question"		=>	"You haven't added your security question yet, please do so on your profile page to improve your personal security!",
			"fill_in_security_answer"		=>	"You need to enter your security answer for your security question otherwise you won't be able to reset tyour password without an administrators help!",
			"activate_anti_spam"			=>	"2",
			"activate_now"		=>	"2",
			"activation_message"	=>	"Welcome to " . get_bloginfo('name') . "! Your account is now activated!",
			"ms_activate_now"		=> "2",
			"user_password"			=> "2",
			"ms_user_activation_message" => 'Your user account is now activated for '.$site_name.' , you may proceed with your login <a href="'.esc_url_raw(wp_login_url()).'">Here</a> now!',
			"ms_activate_blog_now"		=> "2",
			"ms_non_activation_now"		=>	"2",
			"ms_non_activation_message"		=>	"Before you can start using this site and your new username, you must activate it by checking your email inbox and clocking on the activation link givern. *** If you do not activate your user account within two days, you will have to sign up again! ***",
			"wp_user_notification_message"	=>	"Thank you for registering with ".$site_name.",  \r\n\n Here are your new login credentials for ".$site_name.": \r\n\n",
			"redirect_registration"			=>	"2",
			"registration_redirect_url"		=> 	esc_url_raw($registered_url),
			"redirect_login"				=>	"2",
			"login_redirect_url"			=>	esc_url_raw(admin_url()),
			"change_profile_title"			=>	"2",
			"profile_title"					=>	"User Registration Aide Additional Fields",
			"show_dashboard_widget"			=>	"1"
			
				
		);
		return $csds_userRegAide_Options;
	}

	/**
	 * Fills array of known fields
	 *
	 * @since 1.0.0
	 * @updated 1.3.0
	 * @handles action 'init' Line 135 user-registration-aide.php and multiple calls 
	 * @access private
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/

	function csds_userRegAide_fill_known_fields(){
	
		$csds_userRegAide_knownFields = get_option('csds_userRegAide_knownFields');
		$csds_userRegAideFields = get_option('csds_userRegAide_knownFields'); 
		$new_fields = get_option('csds_userRegAide_NewFields'); 
		if(!empty($csds_userRegAide_knownFields) && !empty($csds_userRegAideFields)){
			$csds_userRegAide_knownFields = array();
			$csds_userRegAideFields = array();
		}
		
		$csds_userRegAide_knownFields = array(
		"first_name"	=> "First Name",
		"last_name"		=> "Last Name",
		"nickname"		=> "Nickname",
		"user_url"		=> "Website",
		"aim"			=> "AIM",
		"yim"			=> "Yahoo IM",
		"jabber"		=> "Jabber / Google Talk",
		"description"   => "Biographical Info",
		"user_pass"		=> "Password"
		);
		
		if(empty($csds_userRegAideFields)){
			if(empty($new_fields)){
				update_option("csds_userRegAideFields", $csds_userRegAide_knownFields);
			}else{
				$all_fields = array();
				$all_fields = $csds_userRegAide_knownFields + $new_fields;
				update_option("csds_userRegAideFields", $all_fields);
			}
		}else{
		 
		}
		update_option("csds_userRegAide_knownFields", $csds_userRegAide_knownFields);
		
		if(!empty($csds_userRegAide_NewFields)){
			foreach($csds_userRegAideFields as $key1 => $field1){
				foreach($csds_userRegAide_NewFields as $key => $field){
					if(!$key1 == $key){
						$csds_userRegAideFields[$key] = $field;
					}
				}
			}
		}
		
				
		// Updates the field order set to default by order entered into program
		
		if(empty($csds_userRegAide_fieldOrder) && !empty($csds_userRegAide_NewFields)){
			$this->csds_userRegAide_update_field_order();
		}
		
		if(empty($csds_userRegAide_registrationFields)){
			$this->csds_userRegAide_updateRegistrationFields();
		}
				
	}


	/**
	 * Updates the registration fields array and storage method in options db upgrade in 1.1.0
	 *
	 * @since 1.1.0
	 * @updated 1.3.0
	 * @access private
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/


	function csds_userRegAide_updateRegistrationFields(){

		global $csds_userRegAide_knownFields, $csds_userRegAide_getOptions, $csds_userRegAide_NewFields, $csds_userRegAide_fieldOrder;
		$csds_userRegAide_knownFields = array();
		$csds_userRegAide_newFields = array();
		$csds_userRegAide_fieldOrder = get_option('csds_userRegAide_fieldOrder');
		$csds_userRegAide_NewFields = get_option('csds_userRegAide_NewFields');
		$csds_userRegAide_knownFields = get_option('csds_userRegAide_knownFields');
		$csds_userRegAideFields = get_option('csds_userRegAideFields');
		$csds_userRegAide_registrationFields = get_option('csds_userRegAide_registrationFields');
				
		// Checks to see if older version of additional fields exists and if so transfers them to new option
		
		if(!empty($csds_userRegAide_getOptions["additionalFields"])){
			foreach($csds_userRegAide_getOptions["additionalFields"] as $key => $value){
				foreach($csds_userRegAide_knownFields as $key1 => $value1){
					if($value == $key1){
						$csds_userRegAide_registrationFields[$key1] = $value1;
						$csds_userRegAide_registrationFields = $csds_userRegAide_registrationFields;
						update_option("csds_userRegAide_registrationFields", $csds_userRegAide_registrationFields);
					}
				}
				foreach($csds_userRegAide_NewFields as $key2 => $value2){
					if($value == $key2){
						$csds_userRegAide_registrationFields[$key2] = $value2;
						$csds_userRegAide_registrationFields = $csds_userRegAide_registrationFields;
						update_option("csds_userRegAide_registrationFields", $csds_userRegAide_registrationFields);
					}
					// Testing echo '<div id="message" class="updated fade"><p>'. __('Test key:'.$key.' value: '.$value.'Key 1: '.$key1.'Value: '.$value1.'Key 2: '.$key2.'Value 2: '.$value2.' end test', 'csds_userRegAide') .'</p></div>';
				}
			}
		
		}
		if(!empty($csds_userRegAide_knownFields) && !empty($csds_userRegAide_NewFields)){
			$csds_userRegAideFields = array_merge($csds_userRegAide_knownFields, $csds_userRegAide_NewFields);
			update_option('csds_userRegAideFields', $csds_userRegAideFields);
		}elseif(!empty($csds_userRegAide_knownFields) && empty($csds_userRegAide_NewFields)){
			$csds_userRegAideFields = $csds_userRegAide_knownFields;
			update_option('csds_userRegAideFields', $csds_userRegAideFields);
		}else{
		
		}
			
		
	}


	/**
	 * Fills and arranges the order of new fields based on order of creation initially
	 *
	 * @since 1.1.0
	 * @updated 1.3.0
	 * @access private
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/

	function csds_userRegAide_update_field_order(){
		
		$csds_userRegAide_NewFields = get_option('csds_userRegAide_NewFields');
		$csds_userRegAide_knownFields = get_option('csds_userRegAide_knownFields');
		$csds_userRegAideFields = get_option('csds_userRegAideFields');
		$csds_userRegAide_fieldOrder = get_option('csds_userRegAide_fieldOrder');
		if(empty($csds_userRegAide_fieldOrder)){
			if(!empty($csds_userRegAide_NewFields)){
				$i = 1;
				foreach($csds_userRegAide_NewFields as $key => $field){
					$csds_userRegAide_fieldOrder[$key] = $i;
					
					$i++;
				}
			}
			$csds_userRegAideFields = array();
			$csds_userRegAideFields = $csds_userRegAide_knownFields + $csds_userRegAide_NewFields;
			update_option("csds_userRegAide_fieldOrder", $csds_userRegAide_fieldOrder);
		}else{
			$csds_userRegAide_fieldOrder = array();
			update_option("csds_userRegAide_fieldOrder", $csds_userRegAide_fieldOrder);
			if(!empty($csds_userRegAide_NewFields)){
				$i = 1;
				foreach($csds_userRegAide_NewFields as $key => $field){
					$csds_userRegAide_fieldOrder[$key] = $i;
					$i++;
				}
			}
			$csds_userRegAideFields = array();
			//$csds_userRegAideFields = $csds_userRegAide_knownFields + $csds_userRegAide_NewFields;
			$csds_userRegAideFields = array_merge($csds_userRegAide_knownFields, $csds_userRegAide_NewFields);
			update_option("csds_userRegAideFields", $csds_userRegAideFields);
			update_option("csds_userRegAide_fieldOrder", $csds_userRegAide_fieldOrder);
		}
	}


	/**
	 * Updates Database Options
	 *
	 * @since 1.2.5
	 * @updated 1.3.0
	 * @access private
	 * @author Brian Novotny
	 * @website http://creative-software-design-solutions.com
	*/

	function csds_userRegAide_updateOptions(){
		$csds_userRegAide_oldOptions = array();
		$csds_userRegAide_oldOptions = get_option('csds_userRegAide_Options');
		$csds_userRegAide_defOptions = array();
		$csds_userRegAide_defOptions = $this->csds_userRegAide_defaultOptionsArray();
		//$security_questions = array();
		//$security_questions = get_option('csds_userRegAide_SecurityQuestions');
		$update = array();
		if(empty($csds_userRegAide_oldOptions)){
			$this->csds_userRegAide_DefaultOptions();
		}else{
			foreach($csds_userRegAide_defOptions as $key => $value){
				foreach($csds_userRegAide_oldOptions as $key1 => $value1){
				
					if($key == $key1){
						if(!empty($value1)){
							if($key1 == 'csds_userRegAide_db_Version'){
								$update[$key1] = "1.3.2";
							}else{
								if($value1 != $value){
									$update[$key1] = $value1;
								}else{
									$update[$key1] = $value1;
								}
							}
						}else{
							$update[$key] = $value;
						}
					}
				
					 if(!array_key_exists($key, $csds_userRegAide_oldOptions)){
						 $update[$key] = $value;
					 }
					
				}
			}
			update_option("csds_userRegAide_Options", $update);
		}
	}
	
	/* Checks to make sure that the options table is up to date
	 *
	 * @since version 1.3.0
	 *
	 *
	 *
	*/
	
	function check_options_table(){
		$default_options = $this->csds_userRegAide_defaultOptionsArray();
		$options = get_option('csds_userRegAide_Options');
		$sec_questions = get_option('csds_userRegAide_SecurityQuestions');
		$default_count = count($default_options);
		$options_count = count($options);
		$a_diff = array_diff($default_options, $options);
		if($options_count < $default_count){
			$this->csds_userRegAide_updateOptions();
		}elseif(!empty($a_diff)){
			$this->csds_userRegAide_updateOptions();
		}elseif(empty($sec_questions)){
			$this->csds_userRegAide_updateOptions();
		}
	}
	
}
?>