<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
/**
 * @param $id
 *
 * @return string
 */
function reslide_show_published_sliders($id ) {
	global $wpdb;
	$query   = $wpdb->prepare( "SELECT * FROM " . RESLIDE_TABLE_SLIDERS . " WHERE id = '%d' ", $id );
	$reslider = $wpdb->get_results( $query );
	$query   = $wpdb->prepare( "SELECT * FROM " . RESLIDE_TABLE_SLIDES . " WHERE sliderid = '%d' ORDER BY ordering DESC", $id );
	$reslides = $wpdb->get_results( $query );

	return reslider_front_end( $id, $reslider, $reslides );
}
