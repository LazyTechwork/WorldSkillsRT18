<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

function reslide_sliders_list_func() {
	global $wpdb;
	$s       = 1;
	$table   = RESLIDE_TABLE_SLIDERS;
	$sliders = array();
	$row     = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table WHERE %d", $s ) );
	$table   = RESLIDE_TABLE_SLIDES;
	foreach ( $row as $rows ) {
		$count       = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM $table WHERE sliderid = %d", $rows->id ) );
		$rows->count = $count;
		array_push( $sliders, $rows );
	};
	$sliders = array_reverse( $sliders );

	reslide_sliders_view_list( $sliders );
}

function reslide_edit_slider( $id ) {
	/***Slider images***/
	global $wpdb;
	$s            = 1;
	$table        = RESLIDE_TABLE_SLIDERS;
	$AllSLidersId = $wpdb->get_results( $wpdb->prepare( "SELECT id FROM $table WHERE %d", $s ), ARRAY_A );
	if ( ! in_array( array( 'id' => (string) $id ), $AllSLidersId ) ) {
		wp_die( '<h3 style="color: #FF0011;">R-slider ' . $id . ' does not exist</h3>' );
		exit;
	}
	$table      = RESLIDE_TABLE_SLIDES;
	$row        = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table  WHERE sliderid = %d order by ordering desc", $id ) );
	$table      = RESLIDE_TABLE_SLIDERS;
	$slider_row = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table  WHERE id = %d", $id ) );
	reslide_edit_slider_view( $row, $id, $slider_row );
}

function reslide_add_slider( $id ) {
	global $wpdb;
	$s     = 1;
	$table = RESLIDE_TABLE_SLIDERS;

	$now = current_time( 'mysql', false );
	$wpdb->insert(
		$table,

		array(
			'title'  => 'New Slider',
			'type'   => 'simple',
			'params' => '{"autoplay":1,"pauseonhover":1, "effect":{"type":3,"duration":1500,"interval":1000},"thumbnails":{"show":0,"positioning":0},"custom":{"type":"button","show":1,"style":{"width":"100","height":"50","left":"100px","top":"200px","color":"000000","opacity":"50","font":{"size":"14"},"border":{"color":"3478FF","width":"2","radius":"10"},"background":{"color":"E8FF81","hover":"30FF4F"}}},"title":{"show":1,"position":"1","style":{"width":150,"height":50,"left":"10px","top":"20px","color":"FFFFFF","opacity":70,"font":{"size":16},"border":{"color":"FFFFFF","width":0,"radius":2},"background":{"color":"CCCCCC","hover":"000000"}}},"description":{"show":1,"position":"1","style":{"width":200,"height":60,"left":"170px","top":"20px","color":"FFFFFF","opacity":70,"font":{"size":14},"border":{"color":"FFFFFF","width":0,"radius":2},"background":{"color":"CCCCCC","hover":"000000"}}},"arrows":{"show":2,"type":1,"style":{"background":{"width":"49","height":"49","left":"91px 46px","right":"-44px 1px","hover":{"left":"91px 46px","right":"-44px 1px"}}}},"bullets":{"show":0,"type":"0","position":0,"autocenter":"0","rows":1,"s_x":10,"s_y":10,"orientation":1,"style":{"background":{"width":"60","height":"60","color":{"hover":"646464","active":"30FF4F","link":"CCCCCC"}},"position":{"top":"16px","left":"10px"}}}}',
			'custom' => '{}',
			'style'  => '{"background":"blue;","border":"1px solid red;","color":"yellow","width":"800","height":"480","marginLeft":"0","marginRight":"0","marginTop":"0","marginBottom":"0"}',
			'time'   => $now
		),
		array(
			'%s',
			'%s',
			'%s',
			'%s',
			'%s',
			'%s'
		)
	);

	/**get max id**/
	$id = $wpdb->get_var( $wpdb->prepare(
		"
                SELECT ID 
                FROM $table WHERE %d
                ORDER BY ID DESC limit 0,1
            ",
		$s
	) );

    $location = admin_url( 'admin.php?page=reslider&task=editslider&id=' . $id);
    $location = wp_nonce_url( $location, 'reslide_editslider_' . $id );
    $location = html_entity_decode($location);
    wp_redirect( wp_sanitize_redirect(  $location )  );
    exit;
}

function reslide_remove_slider( $id ) {
	global $wpdb;
	$s     = 1;
	$table = RESLIDE_TABLE_SLIDERS;
	$wpdb->delete( $table, array( 'id' => $id ), array( '%d' ) );
	$wpdb->delete( RESLIDE_TABLE_SLIDES, array( 'sliderid' => $id ), array( '%d' ) );
	$row     = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM $table WHERE %d", $s ) );
	$table   = RESLIDE_TABLE_SLIDES;
	$sliders = array();
	foreach ( $row as $rows ) {
		$count       = $wpdb->get_var( $wpdb->prepare( "SELECT count(*) FROM `$table` WHERE sliderid = %d", $rows->id ) );
		$rows->count = $count;
		array_push( $sliders, $rows );
	};
	reslide_sliders_view_list( $sliders );
}

function reslide_add_slide( $title, $thumbnail, $sliderid, $type ) {
	global $wpdb;
	$table = RESLIDE_TABLE_SLIDES;

	$wpdb->insert(
		$table,
		array(
			'title'     => $title,
			'sliderid'  => $sliderid,
			'thumbnail' => $thumbnail,
			'type'      => $type
		),
		array(
			'%s',
			'%d',
			'%s',
			'%s'
		)
	);

}