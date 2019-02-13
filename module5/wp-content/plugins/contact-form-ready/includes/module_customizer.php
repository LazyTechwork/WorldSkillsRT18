<?php
// coming soon!

class WP_Contact_Form_ND_Customizer extends WP_Contact_Form_ND {

	public function __construct(){
		add_action( 'customize_register', array( $this, 'wpcf_nd_customize_register' ) );
	}

	function wpcf_nd_customize_register( $wp_customize ) {

	}

}

$WP_Contact_Form_ND_Customizer = new WP_Contact_Form_ND_Customizer();