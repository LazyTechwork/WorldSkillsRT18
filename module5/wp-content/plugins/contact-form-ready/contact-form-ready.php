<?php
/*
  Plugin Name: Contact Form Ready
  Plugin URI: http://contactform.org
  Description: The easiest to use Contact Form plugin for WordPress with a drag and drop interface.
  Version: 1.04
  Author: NickDuncan
  Author URI: http://nickduncan.co.za
 */


/**
 * 1.04 - 2017-11-29
 * Added Google reCAPTCHA
 * Fixed the bug that stopped the "skip" button from working on the welcome page
 * Updated the predefined contact forms to suit the new reCAPTCHA inclusion
 * 
 * 1.03 - 2017-11-28
 * Fixed a bug that caused a stray open form tag when outputting the contact form
 * Updated FormBuilder to 1.24.2
 * Added predefined contact forms in the contact form builder
 *  - Simple contact form
 *  - Hotel check in form
 *  - Restaurant booking form
 *  - Support request contact form
 *  - How did you hear about us
 *  - NPS Score
 * Fixed a bug that caused the nonce field to be emailed along with the message
 * Added support for shortcodes
 * Fixed a bug that caused hidden text inputs to hide within the contact form builder
 * 
 * 1.02 - 2017-11-28
 * Added a welcome page
 * 
 * 1.01 - 2017-11-26
 * Added a nonce to the contact form
 * Code refacotring in the send process
 *  - Ensured multiple lines (textareas) carry over into the email
 *  - Remove the "Sent by Nifty Contact Forms" link at the bottom of each email
 * Added submission and view counters for each contact form
 * Added the contact form shortcode to the list view
 *
 *
 * 1.00 - 2017-11-xx
 * Launch
 *
 * 
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}
global $wpcf_thank_you;
global $wpcf_error_message;
include "includes/module_customizer.php";
include "includes/module_recaptcha.php";

class WP_Contact_Form_ND{

	var $current_version;

	public function __construct(){

		$this->current_version = "1.04a";

		$this->upload_dir =(defined('WP_CONTENT_DIR')) ? WP_CONTENT_DIR . '/uploads' : ABSPATH . 'wp-content' . $this->DS() . 'uploads';
		$this->upload_url =(defined('WP_CONTENT_URL')) ? WP_CONTENT_URL . '/uploads' : get_option('siteurl') . '/wp-content/uploads';
		 
		$this->admin_scripts();
		add_action( 'admin_menu', array( $this, 'wpcf_nd_menu_items' ) );
		add_action( 'admin_init', array( $this, 'wpcf_nd_save_settings' ) );

    	add_shortcode( 'cform-nd', array( $this , 'wpcf_tag' ) );

		add_action( "wpcf_nd_general_settings", array($this, 'view_general_settings'),10 ); 

		register_activation_hook( __FILE__, array($this, 'plugin_activate') );
		add_action( "init", array($this, "check_versions") );
		add_action( "init", array($this, "create_post_type") );
		add_filter( "wpcf_nd_html_control", array( $this, "wpcf_nd_filter_control_html_control" ), 10, 2 );
		add_action( 'save_post', array( $this, 'wpcf_nd_save_meta_box' ) );
		add_action( 'save_post', array( $this, 'wpcf_nd_save_meta_box_control' ) );

		add_action( 'add_meta_boxes', array( $this, 'wpcf_nd_add_events_metaboxes' ) );
		add_action( 'add_meta_boxes', array( $this, 'wpcf_nd_add_cf_control_metabox' ) , 1 );
		add_action( 'add_meta_boxes', array( $this, 'wpcf_nd_add_cf_support_metabox' ) , 1 );

		add_action( 'wp_head' , array( $this, 'wpcf_nd_control_post' ) , 10 );


		add_action( "admin_head", array($this, "wpcf_nd_api_post" ) , 10 );
		add_action( "activated_plugin", array($this, "redirect_on_activate") );


		add_filter( "wpcf_nd_email_wrapper", array( $this, "wpcf_nd_email_wrapper_control" ) , 10 , 1 );

		add_filter( 'manage_contact-forms-nd_posts_columns', array( $this, 'set_custom_edit_columns' ) ) ;
		add_action( 'manage_contact-forms-nd_posts_custom_column' , array( $this, 'custom_column' ) , 10, 2  ) ;

	}

	function redirect_on_activate( $plugin ) {
		if( $plugin == plugin_basename( __FILE__ ) ) {
			if (!get_option("wpcf_nd_first_time")) {
		    	update_option("wpcf_nd_first_time",true);
		    	exit( wp_redirect( admin_url( 'admin.php?page=wpcf-settings&action=wpcf_nd_welcome' ) ) );
		    }
		}
	}

	function wpcf_nd_control_post() {
		if ( isset( $_POST['wpcf_nd_submit'] ) ) {

			if ( ! isset( $_POST['wpcf_nonce_field'] ) || ! wp_verify_nonce( $_POST['wpcf_nonce_field'], 'wpcf_nd' ) ) {
				// invalid nonce
			} else {


				/**
				 * Find out if we can continue or not, based on filter outputs
				 * @var boolean
				 */
				$continue = apply_filters( "wpcf_filter_continue_form_post_handling", true, $_POST);
				if ($continue !== true) {
					global $wpcf_error_message;
					$wpcf_error_message = $continue;
					return;
				}

				$user_email = '';


		        $body = "<table width='100%'>";
		        foreach ( $_POST as $key => $val ) {

		        	if ( is_array( $val ) ) {
		        		// checkbox
		        		$tmpbody = "<table>";
		        		foreach ( $val as $k => $v ) {
				            $tmpbody .= "<tr>";
				            $tmpbody .= "	<td width='50%' align='left' valign='top'><strong>". esc_attr( $k ). "</strong></td><td align='left'>: ". esc_attr( $v ) ."</td>";
				            $tmpbody .= "</tr>";
		        		}
		        		$tmpbody .= "</table>";
			            $body .= "<tr>";
			            $body .= "	<td width='50%' align='right' valign='top'><strong>". esc_attr( $key ). "</strong></td><td align='left'>" . esc_attr( $tmpbody ) ."</td>";
			            $body .= "</tr>";

		        	} else {
			        	if ( $key == "wpcf_nd_send_id" ) {
			        		$cfid = intval( sanitize_text_field( $val ));

			        	} else if ( $key == "wpcf_nd_submit" ) {

						} else if ( $key == 'wpcf_nonce_field' ) {

						} else if ( strpos( $key, 'email' ) !== false ) {
							$user_email = sanitize_text_field( $val );
						} else {

							$include = apply_filters( "wpcf_fiter_exclude_certain_fields", $key, $val );
							if ($include) {
								/* normal field */
					            $body .= "<tr>";
					            $body .= "<td width='50%' align='right' valign='top'><strong>". esc_attr( $key ). "</strong></td><td align='left'>: ". nl2br( esc_attr( $val ) ). "</td>";
					            $body .= "</tr>";
					        }
				        }
				    }
		        }
		        $body .= "</table>";

				$this->increase_submissions( $cfid );


		        $data = array(
		        	'user_email' => $user_email
	        	);
		        $this->wpcf_send_email( $cfid , $body , $data );
		    	
		    	$wpcf_nd_redirect_uri = get_post_meta( $cfid, 'wpcf_nd_redirect_uri', true );
		    	if ($wpcf_nd_redirect_uri) {
		    		wp_redirect( get_option("siteurl") . $wpcf_nd_redirect_uri );
		    		exit();
		    	}
		    	global $wpcf_thank_you;


		    	$wpcf_nd_settings = get_option( "wpcf_nd_settings" );
		    	if ( isset( $wpcf_nd_settings['wpcf_nd_thank_you_text'] ) ) {
		    		$wpcf_thank_you = esc_attr($wpcf_nd_settings['wpcf_nd_thank_you_text']);
		    	} else {
		    		$wpcf_thank_you = __("Thank you. Your message has been sent.","wpcf_nd");
		    	}
		    }
	        
		}

	}



	function wpcf_nd_api_post() {


		$this->create_contact_form_types();



		if (isset($_POST['action']) && $_POST['action'] == 'wpcf_nd_submit_find_us') {
		    if (function_exists('curl_version')) {

		        $request_url = "http://www.contactformready.com/apif/rec.php";
		        $ch = curl_init();
		        curl_setopt($ch, CURLOPT_URL, $request_url);
		        curl_setopt($ch, CURLOPT_POST, 1);
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
		        curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
		        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		        $output = curl_exec($ch);
		        curl_close($ch);
				exit( wp_redirect( admin_url( 'edit.php?post_type=contact-forms-nd' ) ) );

		    }

		}

	    if (isset($_POST['action']) && $_POST['action'] == 'wpcf_nd_skip_find_us') {
	        exit( wp_redirect( admin_url( 'edit.php?post_type=contact-forms-nd' ) ) );
	    }

	}

	function increase_submissions($cfid) {
        $submissions = intval(get_post_meta( $cfid , 'cform_submissions' , true )); 
        $submissions++;
        update_post_meta(intval($cfid), 'cform_submissions', $submissions);
	}
	function increase_views($cfid) {
        $views = intval(get_post_meta( $cfid , 'cform_views' , true )); 
        $views++;
        update_post_meta(intval($cfid), 'cform_views', $views);
	}

	function wpcf_nd_set_html_mail_content_type() {
		return 'text/html';
	}
	function wpcf_send_email($cfid,$body,$sent_data) {
		add_filter( 'wp_mail_content_type', array( $this, 'wpcf_nd_set_html_mail_content_type' ) );

		$wpcf_nd_settings = get_option( "wpcf_nd_settings" );
    	$sendto = get_post_meta( $cfid, 'wpcf_nd_send_to', true );
    	if (!$sendto) {
    		//set admin email as defaul email address if nothing was set
    		$sendto = get_option( 'admin_email' );

    	} else {
    		if (is_array($sendto)) {
    			$sendto = implode( "," , $sendto );
    		}
    	}

    	$headers = '';
    	$headers = apply_filters("wpcf_nd_filter_mail_headers",$headers,$cfid);
    	$attachments = array();
    	$attachments = apply_filters("wpcf_nd_filter_mail_attachments",$attachments,$cfid);


    	$header = sprintf("<a href='%s'>%s</a>",get_option('siteurl'),get_option('blogname'));

    	// SEND TO ADMIN
    	
    	if (!isset($wpcf_nd_settings['wpcf_nd_message_admin']))
    		$wpcf_nd_settings['wpcf_nd_message_admin'] = __( "A new message has been received." , "wpcf_nd" );

		$data = array(
			'message' => $body,
			'footer' => '',
			'logo' => $header,
			'header' => $wpcf_nd_settings['wpcf_nd_message_admin']
		);
		$body = apply_filters( "wpcf_nd_email_wrapper" , $data );

		if (!isset($wpcf_nd_settings['wpcf_nd_subject_admin']))
			$wpcf_nd_settings['wpcf_nd_subject_admin'] = __("New Contact Form Response","wpcf_nd");
    	wp_mail( $sendto , $wpcf_nd_settings['wpcf_nd_subject_admin'] , $body , $headers , $attachments );
    	// SEND TO USER?
    	if (isset($wpcf_nd_settings['wpcf_nd_send_to_user']) && intval($wpcf_nd_settings['wpcf_nd_send_to_user']) == 1 && $sent_data['user_email'] != false) { 
	    	if (!isset($wpcf_nd_settings['wpcf_nd_message_user']))
	    		$wpcf_nd_settings['wpcf_nd_message_user'] = __( "Thank you for your message. We will respond to you as soon as possible." , "wpcf_nd" );

			$data = array(
				'message' => $body,
				'footer' => '',
				'logo' => $header,
				'header' => $wpcf_nd_settings['wpcf_nd_message_user']
			);
			$body = apply_filters( "wpcf_nd_email_wrapper" , $data );

			if (!isset($wpcf_nd_settings['wpcf_nd_subject_user']))
				$wpcf_nd_settings['wpcf_nd_subject_user'] = __("Contact Form Response Received","wpcf_nd");

	    	@wp_mail( $sent_data['user_email'] , $wpcf_nd_settings['wpcf_nd_subject_user'] , $body , $headers , $attachments );
	    }



	}

	function wpcf_nd_add_events_metaboxes() {
		add_meta_box('wpcf_nd_main', __('Contact Form Data','wpcf_nd'), array( $this, 'wpcf_main_content' ), 'contact-forms-nd', 'normal', 'default');
	}


	function wpcf_nd_add_cf_control_metabox( $post ) {
		add_meta_box('wpcf_nd_main_control', __('Contact Form Settings','wpcf_nd'), array( $this, 'wpcf_main_control' ), 'contact-forms-nd', 'normal', 'default');
	}

	function wpcf_nd_add_cf_support_metabox( $post ) {
		add_meta_box('wpcf_nd_main_support', __('Need help?','wpcf_nd'), array( $this, 'wpcf_main_support' ), 'contact-forms-nd', 'side', 'default');
	}

	function wpcf_main_support( $post ) {
		echo "Get in touch with <a href='mailto:nick@codecabin.co.za'>nick@codecabin.co.za</a>";

	}

	function wpcf_main_control( $post ) {

		// We'll use this nonce field later on when saving.
    	wp_nonce_field( 'wpcf_nd_add_cf_control_metabox', 'wpcf_nd_nonce_control' );

    	$sendto = get_post_meta( $post->ID, 'wpcf_nd_send_to', true );
    	if (!$sendto) {
    		$sendto = get_option("admin_email");
    	} else {
    		if (is_array($sendto)) { 
    			$sendto = implode( "," , $sendto );
    		}
    	}
    	$wpcf_nd_redirect_uri = get_post_meta( $post->ID, 'wpcf_nd_redirect_uri', true );
		$submit_string = get_post_meta( $post->ID, 'wpcf_nd_submit_string' , true );
		if (!$submit_string || $submit_string === null) {
			$submit_string = __("Send","wpcf_nd");
		}
    	

	    ?>
	    <table class='wp-list-table widefat fixed'>
	    	<tr>
	    		<td width='250'><label for='wpcf_nd_shortcode'><?php _e("Shortcode","wpcf_nd"); ?></label></td>
	    		<td>
	    			<input type='text' readonly value='[cform-nd id="<?php echo $post->ID; ?>"]' />
	    			<p class='description'><?php _e("Copy this to your post or page to show the contact form","wpcf_nd"); ?></p>

	    		</td>
	    	</tr>
	    	<tr>
	    		<td valign='top'><label for='wpcf_nd_send_to'><?php _e("Send emails to","wpcf_nd"); ?></label></td>
	    		<td>
	    			<input type='text' value='<?php echo $sendto; ?>' id='wpcf_nd_send_to' name='wpcf_nd_send_to' />
	    			<p class='description'><?php _e("Multiple emails separated by commas","wpcf_nd"); ?></p>

	    		</td>
	    	</tr>
	    	<tr>
	    		<td valign='top'><label for='wpcf_nd_redirect_uri'><?php _e("Redirect to URL after submit","wpcf_nd"); ?></label></td>
	    		<td>
	    			<input type='text' value='<?php echo $wpcf_nd_redirect_uri; ?>' id='wpcf_nd_redirect_uri' name='wpcf_nd_redirect_uri' />
	    			<p class='description'><?php _e("Example: /thank-you <br>Leave blank for no redirect","wpcf_nd"); ?></p>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td><label for='wpcf_nd_submit_string'><?php _e("Submit button value","wpcf_nd"); ?></label></td>
	    		<td><input type='text' value='<?php echo $submit_string; ?>' id='wpcf_nd_submit_string' name='wpcf_nd_submit_string' /></td>
	    	</tr>
	    </table>

        <!-- / Components -->
        <?php
	}








	 
	/**
	 * Meta box display callback.
	 *
	 * @param WP_Post $post Current post object.
	 */
	function wpcf_main_content( $post ) {

		// We'll use this nonce field later on when saving.
    	wp_nonce_field( 'wpcf_nd_add_events_metaboxes', 'wpcf_nd_nonce' );

    	$htmls = get_post_meta( $post->ID, 'wpcf_nd_html_data', true );
    	$formdata = get_post_meta( $post->ID, 'wpcf_nd_form_data', true );
    	$formdata = preg_replace('/>\s+</', "><", $formdata);

		$contact_form_types = get_option("wpcf_nd_contact_forms");




		?>
	    <script>
		    //var tmpdata = '<?php echo trim($formdata); ?>';
		    //var tmpformData = JSON.stringify(tmpdata);

		</script>

		<form action='' method='POST' novalidate>


        <!-- Building Form. -->
        <div class="col-sm-12">
            <h3 class="tagline"><?php _e("Select from a predefined list","wpcf_nd"); ?></h3>
            <select name='wpcf_nd_predfined' id='wpcf_nd_predfined'>
            	<option value='x'><?php _e("Please select","wpcf_nd"); ?></option>
            	<?php
            		
            		foreach ($contact_form_types as $key => $data) {
            			echo "\t<option value='".$key."'>".$data['title']."</option>".PHP_EOL;
            		}
            	?>
            </select>
        </div>
        <p>&nbsp;</p>

        <hr />

        <p>&nbsp;</p>


    	
    		<!-- YES -->
        <!-- Building Form. -->
        <div class="col-sm-12">
            <h3 class="tagline"><?php _e("Drag and drop the elements to create your contact form.","wpcf_nd"); ?></h3>
            <section id="main_content" class="inner">
			    <div class="build-wrap"></div>
			    <div class="render-wrap"></div>
            </section>
        </div>
		

         <textarea id="fb-temp-formdata" name="fb-temp-formdata" style='width:100%; display:none;'><?php echo $formdata; ?></textarea>
         <textarea id="fb-temp-htmldata" name="fb-temp-htmldata" style='width:100%; display:none;'><?php echo htmlentities($htmls); ?></textarea>

        <!-- / Components -->

        </form>
        <?php
        
	}
	 
	/**
	 * Save meta box content.
	 *
	 * @param int $post_id Post ID
	 */
	function wpcf_nd_save_meta_box( $post_id ) {

	 // Bail if we're doing an auto save
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	     
	    // if our nonce isn't there, or we can't verify it, bail
	    if( !isset( $_POST['wpcf_nd_nonce'] ) || !wp_verify_nonce( $_POST['wpcf_nd_nonce'], 'wpcf_nd_add_events_metaboxes' ) )  {
	    	return;
	    }
	     
	    // if our current user can't edit this post, bail
	    if( !current_user_can( 'edit_post' ) ) return;	


	    $allowed_html = array(
	    	 'a' => array(
		        'href' => array(),
		        'title' => array()
		    ),
		    'br' => array(),
		    'em' => array(),
		    'strong' => array(),
		    'select' => array(
		    	'class' => array(),
		    	'type' => array(),
	    		'required' => array(),
	    		'aria-required' => array(),
	    		'style' => array(),
	    		'data-other-id' => array(),
		    	'name' => array(),
		    	'id' => array(),
		    	'value' => array()
	    		),
		    'option' => array(
		    	'value' => array(),
		    	'id' => array()
		    	),
		    'input' => array(
		    	'class' => array(),
		    	'type' => array(),
		    	'subtype' => array(),
		    	'name' => array(),
	    		'aria-required' => array(),
	    		'style' => array(),
	    		'data-other-id' => array(),
		    	'id' => array(),
	    		'required' => array(),
		    	'value' => array()
		    	),
		    'h1' => array(
		    	'class' => array(),
		    	'type' => array(),
		    	'subtype' => array(),
		    	'id' => array() 
		    	),
		    'h2' => array(
		    	'class' => array(),
		    	'type' => array(),
		    	'subtype' => array(),
		    	'id' => array() 
		    	),
		    'br' => array(),
		    'p' => array(
		    	'class' => array(),
		    	'type' => array(),
		    	'subtype' => array(),
		    	'id' => array()
		    	),
		    'label' => array(
		    	'for' => array(),
		    	'id' => array(),
		    	'class' => array()
		    	),
		    'div' => array(
		    	'class' => array()
	    		),
		    'span' => array(
		    	'class' => array(),
		    	'tooltip' => array()
	    	),
		    'textarea' => array(
		    	'class' => array(),
	    		'required' => array(),
		    	'type' => array(),
		    	'name' => array(),
		    	'id' => array()
		    	)
	    );

	    $allowed_xml = array(
	    	'form-template' => array(),
	    	'fields' => array(),
	    	'field' => array(
	    		'class' => array(),
	    		'aria-required' => array(),
	    		'style' => array(),
	    		'id' => array(),
	    		'data-other-id' => array(),
	    		'label' => array(),
	    		'description' => array(),
	    		'enable-other' => array(),
	    		'name' => array(),
	    		'required' => array(),
	    		'type' => array(),
	    		'subtype' => array()
    		),
    		'option' => array(
    			'value' => array()
			)


    	);


		// Make sure your data is set before trying to save it
	    if( isset( $_POST['fb-temp-htmldata'] ) )
	        update_post_meta( $post_id, 'wpcf_nd_html_data', wp_kses( $_POST['fb-temp-htmldata'] , $allowed_html ) );
	    if( isset( $_POST['fb-temp-formdata'] ) )
	        update_post_meta( $post_id, 'wpcf_nd_form_data', wp_kses( $_POST['fb-temp-formdata'] , $allowed_xml ) );

	    
	}

	function wpcf_nd_save_meta_box_control( $post_id ) {



	 // Bail if we're doing an auto save
	    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
	     
	    // if our nonce isn't there, or we can't verify it, bail
	    if( !isset( $_POST['wpcf_nd_nonce_control'] ) || !wp_verify_nonce( $_POST['wpcf_nd_nonce_control'], 'wpcf_nd_add_cf_control_metabox' ) )  {
	    	return;
	    }
	     
	    // if our current user can't edit this post, bail
	    if( !current_user_can( 'edit_post' ) ) return;	


		// Make sure your data is set before trying to save it
	    if( isset( $_POST['wpcf_nd_send_to'] ) ) {
			$email_array = explode( "," , $_POST['wpcf_nd_send_to'] );
			foreach ($email_array as $key => $val) {
				$email_array[$key] = sanitize_email( $val );
			}
     	   	update_post_meta( $post_id, 'wpcf_nd_send_to', $email_array );
	    }
	    if( isset( $_POST['wpcf_nd_submit_string'] ) )
	        update_post_meta( $post_id, 'wpcf_nd_submit_string', sanitize_text_field( $_POST['wpcf_nd_submit_string'] ) );
	    if( isset( $_POST['wpcf_nd_redirect_uri'] ) )
	        update_post_meta( $post_id, 'wpcf_nd_redirect_uri', sanitize_text_field( $_POST['wpcf_nd_redirect_uri'] ) );
	    
	}



	function check_versions() {

		$current_option = get_option("wpcf_nd_version");
		

		if ($current_option !== $this->current_version) {
			$this->handle_defaults();
			$this->create_contact_form_types(true);
			update_option("wpcf_nd_version",$this->current_version);
		}
	}
	function create_post_type() {
		
	    $labels = array(
	        'name' => __('Contact Forms', 'wpcf_nd'),
	        'singular_name' => __('Contact Form', 'wpcf_nd'),
	        'add_new' => __('New Contact Form', 'wpcf_nd'),
	        'add_new_item' => __('Add New Contact Form', 'wpcf_nd'),
	        'edit_item' => __('Edit Contact Form', 'wpcf_nd'),
	        'new_item' => __('New Contact Form', 'wpcf_nd'),
	        'all_items' => __('All Contact Forms', 'wpcf_nd'),
	        'view_item' => __('View Contact Form', 'wpcf_nd'),
	        'search_items' => __('Search Contact Forms', 'wpcf_nd'),
	        'not_found' => __('No contact forms found', 'wpcf_nd'),
	        'not_found_in_trash' => __('No contact forms in the Trash', 'wpcf_nd'),
	        'menu_name' => __('Contact Forms', 'wpcf_nd')
	    );
	    $args = array(
	        'labels' => $labels,
	        'description' => __('Contact Forms', 'wpcf_nd'),
	        'public' => true,
	        'menu_position' => 5,
	        'hierarchical' => false,
	        'rewrite' => array('slug' => 'contact-forms-nd'),
	        'supports' => array('title','custom-meta'),
	        'publicly_queryable' => false,
	        'exclude_from_search' => false,
	        'query_var' => true,
	        'has_archive' => true,
	        'register_meta_box_cb' => array($this, 'wpcf_nd_add_events_metaboxes' )
	    );
	    if (post_type_exists('contact-forms-nd')) {

	    } else {
	        register_post_type('contact-forms-nd', $args);
		    flush_rewrite_rules();

	    }

	}

	function plugin_activate() {
		$this->handle_defaults();
		$this->create_contact_form_types();
	}

	function create_contact_form_types($force = false) {
		/* contact form types */
		if (!get_option("wpcf_nd_contact_forms") || $force) {
			$contact_form_type = array(
				1 => array(
					"title" => __("Simple contact form","wpcf_nd"),
					"xml_data" => '<form-template><fields><field type="header" subtype="h1" label="Contact us" class="header"></field><field type="text" label="Name" subtype="text" class="form-control text-input" name="name-field"></field><field type="text" subtype="email" label="Email" class="form-control text-input" name="email-field"></field><field type="textarea" label="Your message" class="form-control text-area" name="message"></field></fields></form-template>'
				),
				2 => array(
					"title" => __("Booking form (hotel)", "wpcf_nd"),
					"xml_data" => '<form-template><fields><field type="header" subtype="h1" label="Book now" class="header"></field><field type="paragraph" subtype="p" label="This is a customizable paragraph field" class="paragraph"></field><field type="text" label="Name" subtype="text" class="form-control text-input" name="name-field"></field><field type="text" subtype="email" label="Email" class="form-control text-input" name="email-field"></field><field type="select" label="Guests" class="form-control" name="guestqty">	<option label="1" value="1" selected="true">1</option><option label="2" value="2">2</option><option label="3" value="3">3</option><option label="4" value="4">4</option><option label="5" value="5">5</option><option label="6" value="6">6</option><option label="7" value="7">7</option><option label="8" value="8">8</option><option label="9" value="9">9</option></field><field type="date" label="Check in date" class="calendar" name="check-in-date"></field><field type="date" label="Check out date" class="calendar" name="check-out-date"></field><field type="textarea" label="Additional comments" class="form-control text-area" name="additional-comments"></field></fields></form-template>'
				),
				3 => array(
					"title" => __("Booking form (restaurant)", "wpcf_nd"),
					"xml_data" => '<form-template><fields><field type="header" subtype="h1" label="Book now" class="header"></field><field type="paragraph" subtype="p" label="This is a customizable paragraph field" class="paragraph"></field><field type="text" label="Name" subtype="text" class="form-control text-input" name="name-field"></field><field type="text" subtype="email" label="Email" class="form-control text-input" name="email-field"></field><field type="number" label="Guests" min="1" max="100" step="1" class="form-control" name="guests"></field><field type="date" label="Booking date" class="calendar" name="booking-date"></field><field type="select" label="Occassion" class="form-control" name="occassion"><option label="No occassion" value="none">No occassion</option><option label="Birthday" value="birthday" selected="true">Birthday</option><option label="Engagement" value="engagement">Engagement</option><option label="Anniversary" value="anniversary">Anniversary</option><option label="Meeting" value="meeting">Meeting</option></field><field type="textarea" label="Additional comments" class="form-control text-area" name="additional-comments"></field></fields></form-template>'
				),
				4 => array(
					"title" => __("Support form", "wpcf_nd"),
					"xml_data" => '<form-template><fields><field type="header" subtype="h1" label="Support query" class="header"></field><field type="paragraph" subtype="p" label="Please enter your details below and an agent will get in touch with you as soon as possible" class="paragraph"></field><field type="text" label="Name" subtype="text" class="form-control text-input" name="name-field"></field><field type="text" subtype="email" label="Email" class="form-control text-input" name="email-field"></field><field type="radio-group" label="Department" class="radio-group" name="department"><option label="Sales" value="sales" selected="true">Sales</option><option label="Technical Support" value="technical-support">Technical Support</option><option label="Accounts" value="accounts">Accounts</option></field><field type="textarea" label="Describe your issue" class="form-control" name="message"></field></fields></form-template>'
				),
				5 => array(
					"title" => __("How did you hear about us", "wpcf_nd"),
					"xml_data" => '<form-template><fields><field type="header" subtype="h1" label="How did you hear about us?" class="header"></field><field type="text" label="Name" subtype="text" class="form-control text-input" name="name-field"></field><field type="text" subtype="email" label="Email" class="form-control text-input" name="email-field"></field><field type="select" label="How did you hear about us?" class="form-control" name="hearaboutus"><option label="Radio" value="radio" selected="true">Radio</option><option label="Television" value="television">Television</option><option label="Online Advertising" value="online-advertising">Online Advertising</option><option label="Billboard" value="billboard">Billboard</option><option label="Newspaper ad" value="newspaper-ad">Newspaper ad</option><option label="Friend" value="friend">Friend</option><option label="Search Engine" value="search-engine">Search Engine</option></field><field type="textarea" label="Additional feedback" class="form-control text-area" name="additional-feedback"></field></fields></form-template>'
				),
				6 => array(
					"title" => __("NPS Score", "wpcf_nd"),
					"xml_data" => '<form-template><fields><field type="header" subtype="h1" label="How likely are you to suggest our brand to your friends or family?" class="header"></field><field type="text" label="Name" subtype="text" class="form-control text-input" name="name-field"></field><field type="text" subtype="email" label="Email" class="form-control text-input" name="email-field"></field><field type="radio-group" label="How likely are you to suggest our brand to your friends or family?" class="radio-group" name="nps-score"><option label="1 - Not likely at all" value="1">1 - Not likely at all</option><option label="2" value="2">2</option><option label="3" value="3">3</option><option label="4" value="4">4</option><option label="5" value="5">5</option><option label="6" value="6">6</option><option label="7" value="7">7</option><option label="8" value="8">8</option><option label="9" value="9">9</option><option label="10 - Extremely likely" value="10">10 - Extremely likely</option></field><field type="textarea" label="Additional feedback" class="form-control text-area" name="additional-feedback"></field></fields></form-template>'
				)
			);
			update_option("wpcf_nd_contact_forms",$contact_form_type);
		}

	}


	function handle_defaults() {
		$wpcf_nd_settings = get_option("wpcf_nd_settings");
		/**
		 * defaults here
		 */

		if (!isset($wpcf_nd_settings['wpcf_nd_subject_admin']))
			$wpcf_nd_settings['wpcf_nd_subject_admin'] = __("New Contact Form Response","wpcf_nd"); 

		if (!isset($wpcf_nd_settings['wpcf_nd_subject_user']))
			$wpcf_nd_settings['wpcf_nd_subject_user'] = __("Contact Form Response Received","wpcf_nd"); 
		
		
		if (!isset($wpcf_nd_settings['wpcf_nd_message_admin']))
			$wpcf_nd_settings['wpcf_nd_message_admin'] = __("A new message has been received.","wpcf_nd"); 

		if (!isset($wpcf_nd_settings['wpcf_nd_message_user']))
			$wpcf_nd_settings['wpcf_nd_message_user'] = __("Thank you for your message. We will respond to you as soon as possible.","wpcf_nd"); 

		if (!isset($wpcf_nd_settings['wpcf_nd_thank_you_text']))
			$wpcf_nd_settings['wpcf_nd_thank_you_text'] = __("Thank you. Your message has been sent and we will be in touch as soon as possible.","wpcf_nd"); 


		update_option("wpcf_nd_settings",$wpcf_nd_settings);
	}

	


	private function admin_scripts() {
		add_action('admin_print_scripts', array($this, 'load_admin_scripts'));
		add_action('admin_print_styles', array($this, 'load_admin_styles'));
	}



	
	function load_admin_scripts() {
	 	global $post_type;
	 	global $post;
	    if( "contact-forms-nd" == $post_type ) {
	        wp_register_script( 'form-builder-js', plugins_url(plugin_basename(dirname(__FILE__)))."/assets/formbuilder/js/helpers.js", true );
	        wp_enqueue_script( 'form-builder-js' );
	        wp_register_script( 'form-builder-js1', plugins_url(plugin_basename(dirname(__FILE__)))."/assets/formbuilder/js/events.js", true );
	        wp_enqueue_script( 'form-builder-js1' );
	        wp_register_script( 'form-builder-js2', plugins_url(plugin_basename(dirname(__FILE__)))."/assets/formbuilder/js/kc-toggle.js", true );
	        wp_enqueue_script( 'form-builder-js2' );
	        wp_register_script( 'form-builder-js3', plugins_url(plugin_basename(dirname(__FILE__)))."/assets/formbuilder/js/polyfills.js", true );
	        wp_enqueue_script( 'form-builder-js3' );
	        wp_register_script( 'form-builder-js4', plugins_url(plugin_basename(dirname(__FILE__)))."/assets/formbuilder/js/utils.js", true );
	        wp_enqueue_script( 'form-builder-js4' );
	        wp_register_script( 'form-builder-js6', plugins_url(plugin_basename(dirname(__FILE__)))."/assets/formbuilder/js/form-builder.js", true );
	        wp_enqueue_script( 'form-builder-js6' );

	        wp_register_script( 'form-builder-site-js', plugins_url(plugin_basename(dirname(__FILE__)))."/assets/formbuilder/js/site.js", true );
	        wp_enqueue_script( 'form-builder-site-js' );

	        wp_register_script( 'form-builder-render-js', plugins_url(plugin_basename(dirname(__FILE__)))."/assets/formbuilder/js/form-render.min.js", true );
	        wp_enqueue_script( 'form-builder-render-js' );

	        wp_register_script( 'wpcf-admin', plugins_url(plugin_basename(dirname(__FILE__)))."/js/admin.js", true );
	        wp_enqueue_script( 'wpcf-admin' );

    		$contact_form_types = get_option("wpcf_nd_contact_forms");

			wp_localize_script( 'wpcf-admin', 'wpcf_nd_types', $contact_form_types );

			$formdata = get_post_meta( $post->ID, 'wpcf_nd_form_data', true );
	    	$formdata = preg_replace('/>\s+</', "><", $formdata);
			wp_localize_script( 'wpcf-admin', 'tmpformData', $formdata );


			
		    


		}
	}
	function load_admin_styles() {
	 	global $post_type;
	    if( "contact-forms-nd" == $post_type ) {
	        wp_register_style( 'form-builder-css', plugins_url(plugin_basename(dirname(__FILE__)))."/assets/formbuilder/css/form-builder.min.css", true );
	        wp_enqueue_style( 'form-builder-css' );
	        wp_register_style( 'wpcf-nd-css', plugins_url(plugin_basename(dirname(__FILE__)))."/css/admin.css", true );
	        wp_enqueue_style( 'wpcf-nd-css' );

		}
	}


	private function DS() {
		if(strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
			return '\\';
		} else {
			return '/';
			
		}
	}

	public function wpcf_nd_menu_items(){

        add_submenu_page('edit.php?post_type=contact-forms-nd', __('Settings', 'wpcf_nd'), __('Settings', 'wpcf_nd'), 'manage_options', 'wpcf-settings',  array( $this , 'wpcf_settings_page' ) );


	}

	function wpcf_nd_save_settings() {
	}

	function wpcf_settings_page() {
		$wpcf_nd_settings = get_option("wpcf_nd_settings");


		if (isset($_GET['page']) && $_GET['page'] == 'wpcf-settings' && isset($_GET['action']) && $_GET['action'] == 'wpcf_nd_welcome') {

	        if (class_exists("APC_Object_Cache")) {
	            /* do nothing here as this caches the "first time" option and the welcome page just loads over and over again. quite annoying really... */
	        }  else { 
	            update_option('nifty-bu-first-time', true);
	            include('templates/welcome.php');
	        }
        

		} else {
			if (isset($_POST['wpcf_submit_save_settings'])) {


				if (isset($_POST['wpcf_nd_subject_admin'])) 
					$wpcf_nd_settings['wpcf_nd_subject_admin'] = sanitize_text_field( $_POST['wpcf_nd_subject_admin'] );

				if (isset($_POST['wpcf_nd_subject_user'])) 
					$wpcf_nd_settings['wpcf_nd_subject_user'] = sanitize_text_field( $_POST['wpcf_nd_subject_user'] );

				if (isset($_POST['wpcf_nd_send_to_user'])) 
					$wpcf_nd_settings['wpcf_nd_send_to_user'] = intval(sanitize_text_field( $_POST['wpcf_nd_send_to_user'] ));

				if (isset($_POST['wpcf_nd_message_user'])) 
					$wpcf_nd_settings['wpcf_nd_message_user'] = sanitize_text_field( $_POST['wpcf_nd_message_user'] );

				if (isset($_POST['wpcf_nd_message_admin'])) 
					$wpcf_nd_settings['wpcf_nd_message_admin'] = sanitize_text_field( $_POST['wpcf_nd_message_admin'] );


				if (isset($_POST['wpcf_nd_thank_you_text'])) 
					$wpcf_nd_settings['wpcf_nd_thank_you_text'] = sanitize_text_field( $_POST['wpcf_nd_thank_you_text'] );


				$wpcf_nd_settings = apply_filters("wpcf_filter_save_settings", $wpcf_nd_settings, $_POST);
				
				update_option( "wpcf_nd_settings" , $wpcf_nd_settings );
				echo "<span class='update-nag below-h1'>Settings saved</span>";

			}



			?>

			<form action='' method='POST' name='wpcf_settings_form'>
				<h1><?php _e("Contact form settings","wpcf_nd"); ?></h1>
				

				<h2><?php _e("Contact Form Settings","wpcf_nd"); ?></h2>

				<table class='wp-list-table widefat striped fixed'>
					<tr>
						<td width='250'><?php _e("Thank you text","wpcf_nd"); ?></td>
						<td><input type='text' name='wpcf_nd_thank_you_text' class='regular-text' id='wpcf_nd_thank_you_text' value='<?php echo $wpcf_nd_settings['wpcf_nd_thank_you_text']; ?>' /></td>
					</tr>
				</table>


				<h2><?php _e("Email Settings","wpcf_nd"); ?></h2>

				<table class='wp-list-table widefat striped fixed'>
					<tr>
						<td width='250'><?php _e("Email subject (admin)","wpcf_nd"); ?></td>
						<td><input type='text' name='wpcf_nd_subject_admin' class='regular-text' id='wpcf_nd_subject_admin' value='<?php echo $wpcf_nd_settings['wpcf_nd_subject_admin']; ?>' /></td>
					</tr>
					<tr>
						<td><?php _e("Email body (admin)","wpcf_nd"); ?></td>
						<td><input type='text' name='wpcf_nd_message_admin' class='regular-text' id='wpcf_nd_message_admin' value='<?php echo $wpcf_nd_settings['wpcf_nd_message_admin']; ?>' /></td>
					</tr>


					<tr>
						<td><?php _e("Send confirmation email to user?","wpcf_nd"); ?></td>
						<?php
						 $is_checked = (isset($wpcf_nd_settings['wpcf_nd_send_to_user']) && $wpcf_nd_settings['wpcf_nd_send_to_user'] == 1) ? "checked" : "";
						?>
						<td><input type='checkbox' name='wpcf_nd_send_to_user' id='wpcf_nd_send_to_user' value='1' <?php echo $is_checked; ?> /></td>
					</tr>
					<tr>
						<td><?php _e("Email subject (user)","wpcf_nd"); ?></td>
						<td><input type='text' name='wpcf_nd_subject_user' class='regular-text' id='wpcf_nd_subject_user' value='<?php echo $wpcf_nd_settings['wpcf_nd_subject_user']; ?>' /></td>
					</tr>
					<tr>
						<td><?php _e("Email body (user)","wpcf_nd"); ?></td>
						<td><input type='text' name='wpcf_nd_message_user' class='regular-text' id='wpcf_nd_message_user' value='<?php echo $wpcf_nd_settings['wpcf_nd_message_user']; ?>' /></td>
					</tr>





				</table>
				<?php do_action( "wpcf_hook_settings_page_bottom", $wpcf_nd_settings ); ?>

				<input type='submit' value='Save settings' name='wpcf_submit_save_settings' />
			</form>




			<?php
		}
	}

	function wpcf_nd_email_wrapper_control($data) {
		$dir = dirname(__FILE__);
		$template_content_template = file_get_contents($dir."/templates/mail_template.html");

		$template_content_template = str_replace("{header}",$data['header'],$template_content_template);
		$template_content_template = str_replace("{message}",$data['message'],$template_content_template);
		$template_content_template = str_replace("{footer}",$data['footer'],$template_content_template);
		$template_content_template = str_replace("{logo}",$data['logo'],$template_content_template);

		return $template_content_template;



	}
	function set_custom_edit_columns($columns) {

	    $columns['shortcode'] = __( 'Shortcode', 'wpcf_nd' );
	    $columns['views'] = __( 'Views', 'wpcf_nd' );
	    $columns['submissions'] = __( 'Submissions', 'wpcf_nd' );
    
	    return $columns;
	}

	function custom_column( $column, $post_id ) {
	    switch ( $column ) {

	        case 'shortcode' :
	            echo '<pre>[cform-nd id="'.$post_id.'"]</pre>';
	            break;
	        case 'views' :
	            $views = intval(get_post_meta( $post_id , 'cform_views' , true )); 
	            echo $views;
	            break;
	        case 'submissions' :
	            $views = intval(get_post_meta( $post_id , 'cform_submissions' , true )); 
	            echo $views;
	            break;


	    }
	}

	/**
	 * Enqueue user styles on the front end
	 * 
	 * @return void
	 */
	function enqueue_user_styles() {
        wp_register_style( 'contact-form-ready', plugins_url(plugin_basename(dirname(__FILE__)))."/css/front-end.css", true );
        wp_enqueue_style( 'contact-form-ready' );
	}

	/**
	 * Shortcode handler
	 * 
	 * @param  array $atts 	Shortcode attributes
	 * @return string 		Shortcode output
	 */
	function wpcf_tag( $atts ) {
		
		if (isset($atts['id'])) {

	    	global $wpcf_thank_you;
	    	global $wpcf_error_message;
	    	if ($wpcf_thank_you) { 

    			return "<div class='wpcf-nd-thank-you'>".$wpcf_thank_you."</div>";

			} else {

				$this->enqueue_user_styles();

				$this->increase_views(intval($atts['id']));

				$html_data = get_post_meta( $atts['id'], 'wpcf_nd_html_data' , true );
				$send_to = get_post_meta( $atts['id'], 'wpcf_nd_send_to' , true );

				$submit_string = get_post_meta( $atts['id'], 'wpcf_nd_submit_string' , true );
				if (!$submit_string || $submit_string === null) {
					$submit_string = __("Send","wpcf_nd");
				}

				$data = array(
					"cfid" => $atts['id'],
					"submit_string" => $submit_string,
					"sendto" => $send_to
				);
				$html_data = apply_filters( "wpcf_nd_html_control" , $html_data, $data );
				$style = '<style>.form-control { clear: both; display: block; }</style>';

				$other_data = '';
				if ($wpcf_error_message) 
					$other_data = "<div class='wpcf-nd-error-message'>".$wpcf_error_message."</div>";

				return $style.$other_data.do_shortcode($html_data);
			}
		}

	}

	function wpcf_nd_filter_control_html_control( $html_data, $data ) {
		$form_start = '<form action="" method="POST" name="wpcf_nd" cfid="'.esc_attr($data['cfid']).'">'.PHP_EOL;
		//we dont need to send the email address here as we can pick it up with the ID later.
		$id_string = "			<input type='hidden' value='".esc_attr($data['cfid'])."' name='wpcf_nd_send_id' id='wpcf_nd_send_id' />".PHP_EOL;
		$nonce_string = '			'.wp_nonce_field( 'wpcf_nd', 'wpcf_nonce_field', false, false ).PHP_EOL;

		$other_data = apply_filters( "wpcf_filter_other_form_data_frontend", "" );
		$submit_string = PHP_EOL."<p><input type='submit' value='".esc_attr($data['submit_string'])."' name='wpcf_nd_submit' id='wpcf_nd_submit' /><p>".PHP_EOL;

		$form_end = '</form>'.PHP_EOL;
		return $form_start.$id_string.$nonce_string.$html_data.$other_data.$submit_string.$form_end;
	}
}

$contact_form_nd = new WP_Contact_Form_ND();