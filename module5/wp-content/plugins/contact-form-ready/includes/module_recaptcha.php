<?php

add_action( "wpcf_hook_settings_page_bottom", "wpcf_hook_control_settings_page_bottom_recpatcha" , 10, 1 );
function wpcf_hook_control_settings_page_bottom_recpatcha($wpcf_nd_settings) {
	

	if (!isset($wpcf_nd_settings['wpcf_nd_recaptcha_site_key']))
			$wpcf_nd_settings['wpcf_nd_recaptcha_site_key'] = '';
	if (!isset($wpcf_nd_settings['wpcf_nd_recaptcha_secret_key']))
			$wpcf_nd_settings['wpcf_nd_recaptcha_secret_key'] = '';

	?>

	<h2><?php _e("Anti Spam Settings","wpcf_nd"); ?></h2>
	<table class='wp-list-table widefat striped fixed'>
		<tr>
			<td width='250'><?php _e("Enable reCAPTCHA?","wpcf_nd"); ?></td>
			<?php
			 $is_checked = (isset($wpcf_nd_settings['wpcf_nd_enable_recaptcha']) && $wpcf_nd_settings['wpcf_nd_enable_recaptcha'] == 1) ? "checked" : "";
			?>
			<td><input type='checkbox' name='wpcf_nd_enable_recaptcha' id='wpcf_nd_enable_recaptcha' value='1' <?php echo $is_checked; ?> /> <span class='description'><?php echo sprintf(__("Click <a href='%s' target='_BLANK'>here</a> to set up your reCAPTCHA profile.","wpcf_nd"),"https://www.google.com/recaptcha/intro/index.html");  ?></span></td>
		</tr>
		<tr class='recpatcha_settings'>
			<td><?php _e("Site key","wpcf_nd"); ?></td>
			<td><input type='text' name='wpcf_nd_recaptcha_site_key' class='regular-text' id='wpcf_nd_recaptcha_site_key' value='<?php echo $wpcf_nd_settings['wpcf_nd_recaptcha_site_key']; ?>' /></td>
		</tr>
		<tr class='recpatcha_settings'>
			<td><?php _e("Secret key","wpcf_nd"); ?></td>
			<td><input type='text' name='wpcf_nd_recaptcha_secret_key' class='regular-text' id='wpcf_nd_recaptcha_secret_key' value='<?php echo $wpcf_nd_settings['wpcf_nd_recaptcha_secret_key']; ?>' /></td>
		</tr>

	</table>

	<?php
}

add_filter( "wpcf_filter_save_settings", "wpcf_filter_control_save_settings_recaptcha", 10, 2);
function wpcf_filter_control_save_settings_recaptcha($wpcf_nd_settings, $post_data) {
	if (isset($post_data['wpcf_nd_enable_recaptcha'])) 
		$wpcf_nd_settings['wpcf_nd_enable_recaptcha'] = sanitize_text_field( $post_data['wpcf_nd_enable_recaptcha'] );

	if (isset($post_data['wpcf_nd_recaptcha_site_key'])) 
		$wpcf_nd_settings['wpcf_nd_recaptcha_site_key'] = sanitize_text_field( $post_data['wpcf_nd_recaptcha_site_key'] );

	if (isset($post_data['wpcf_nd_recaptcha_secret_key'])) 
		$wpcf_nd_settings['wpcf_nd_recaptcha_secret_key'] = sanitize_text_field( $post_data['wpcf_nd_recaptcha_secret_key'] );

	return $wpcf_nd_settings;
}


add_filter( "wpcf_filter_other_form_data_frontend", "wpcf_filter_control_other_form_data_frontend_recaptcha", 10, 1);
function wpcf_filter_control_other_form_data_frontend_recaptcha( $html_data ) {
	$wpcf_nd_settings = get_option( "wpcf_nd_settings" );
	if (isset($wpcf_nd_settings['wpcf_nd_enable_recaptcha']) && $wpcf_nd_settings['wpcf_nd_enable_recaptcha'] == '1' && isset($wpcf_nd_settings['wpcf_nd_recaptcha_site_key'])) {

		require_once(plugin_dir_path(dirname(__FILE__)).'assets/recaptcha/recaptchalib.php');
	    return recaptcha_get_html($wpcf_nd_settings['wpcf_nd_recaptcha_site_key']);
	}
	return "";
}


add_filter( "wpcf_filter_continue_form_post_handling", "wpcf_filter_continue_form_post_handling", 10, 2);
function wpcf_filter_continue_form_post_handling( $continue, $post_data ) {
	$wpcf_nd_settings = get_option( "wpcf_nd_settings" );
	if (isset($wpcf_nd_settings['wpcf_nd_enable_recaptcha']) && $wpcf_nd_settings['wpcf_nd_enable_recaptcha'] == '1' && isset($wpcf_nd_settings['wpcf_nd_recaptcha_secret_key'])) {
		require_once(plugin_dir_path(dirname(__FILE__)).'assets/recaptcha/recaptchalib.php');
		$privatekey = "your_private_key";
		$resp = recaptcha_check_answer ($wpcf_nd_settings['wpcf_nd_recaptcha_secret_key'],
		                        $_SERVER["REMOTE_ADDR"],
		                        $post_data["recaptcha_challenge_field"],
		                        $post_data["recaptcha_response_field"]);



		if (!$resp->is_valid) {
			return __( "The reCAPTCHA wasn't entered correctly. Please try sagain.", "wpcf_nd" ). " Error: ".$resp->error;
		} else {
		 	return true;
		}
	}
	return true;
  }


  add_filter( "wpcf_fiter_exclude_certain_fields", "wpcf_fiter_control_exclude_certain_fields_recpatcha", 10, 2);
  function wpcf_fiter_control_exclude_certain_fields_recpatcha( $key, $val ) {
  	if ( $key == "recaptcha_challenge_field" ) {
  		return false;
  	}
  	if ( $key == 'recaptcha_response_field' ) {
  		return false;
  	}
  	

  	return true;
  	
  	
  }