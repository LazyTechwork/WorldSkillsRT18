<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/**
 * Edit slide
 *
 * @param $_slideid id of slide
 * @param $_sliderid id of slider
 */
function reslide_edit_slide( $_slideid, $_sliderid ) {
	/***Slider images***/
	global $wpdb;
	$s            = 1;
	$table        = RESLIDE_TABLE_SLIDERS;
	$AllSLidersId = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM $table WHERE %d", $s ), ARRAY_A );
	if ( ! in_array( array( 'id' => $_sliderid ), $AllSLidersId ) ) {
		wp_die( '<h3 style="color: #FF0011;">R-slider ' . $_sliderid . ' does not exist</h3>' );
		exit;
	}
	$table       = RESLIDE_TABLE_SLIDES;
	$AllSLidesId = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM $table WHERE %d", $s ), ARRAY_A );
	if ( ! in_array( array( 'id' => $_slideid ), $AllSLidesId ) ) {
		wp_die( '<h3 style="color: #FF0011;">Slide ' . $_slideid . ' does not exist in Slider ' . $_sliderid . '</h3>' );
		exit;
	}
	$slides = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table  WHERE sliderid = %d order by ordering desc", $_sliderid ) );
	$mainslide = $wpdb->get_results( $wpdb->prepare(
		"
                SELECT * 
                FROM $table WHERE id = %d
            ",
		$_slideid
	) );

	$table      = RESLIDE_TABLE_SLIDERS;
	$slider_row = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table  WHERE id = %d", $_sliderid ) );
	reslide_edit_slide_view( $slider_row, $slides, $mainslide );
}