<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<div id="clear_slider_add_video" style="display:none;">
	<p>add video</p>

	<input id="reslide_insert_video_input" placeholder="add video from youtube" value/>
	<button id="reslide_insert_video_button">Insert video</button>
</div>
<div id="reslider_static_post" class="resliderpopups" style="display:none;">
	<p>Add static post in your slider</p>
	<?php
	$count_posts = wp_count_posts();
	$published_posts = $count_posts->publish;
	$args            = array(
		'posts_per_page'   => $published_posts,
		'offset'           => 0,
		'category'         => '',
		'category_name'    => '',
		'orderby'          => 'date',
		'order'            => 'DESC',
		'include'          => '',
		'exclude'          => '',
		'meta_key'         => '',
		'meta_value'       => '',
		'post_type'        => 'post',
		'post_mime_type'   => '',
		'post_parent'      => '',
		'author'           => '',
		'post_status'      => 'publish',
		'suppress_filters' => true
	);
	$posts_array     = get_posts( $args );
	$postsForSlider  = array();
	foreach ( $posts_array as $_post ) {
		if ( has_post_thumbnail( $_post->ID ) ) {
			array_push( $postsForSlider, $_post );
		}
	}
	if ( count( $postsForSlider ) != 0 ) { ?>
			<ul>
		<?php 
			foreach ( $postsForSlider as $_post ) { 
				$src = wp_get_attachment_image_src( get_post_thumbnail_id( $_post->ID ), false, '' );

			?>
			<li>
				<div class="static-post">
					<input type='checkbox' name='postitem' value='0'>
					<div class="static-post-img">
						<img title = "<?php echo $_post->post_title;?>" src=" <?php echo $src[0] ;?> ">
					</div>
					<div class="static-post-title">
						<h3><?php echo $_post->post_title;?></h3>
						<!--<a href="<?php echo get_permalink( $_post->ID ) ?>" title="<?php echo  esc_attr( $_post->post_title ) ?>"><?php echo $_post->post_title;?>
						</a>-->
					</div>
					<p style="display:inline"> <?php // echo get_post_field( 'post_content', $_post->ID );?></p>
					<input type="hidden" class="description" value="<?php echo esc_attr(get_post_field( 'post_content', $_post->ID ));?>">
					<input type="hidden" class="title" value="<?php echo esc_attr( $_post->post_title );?>">
					<input type="hidden" class="image" value="<?php echo $src[0];?>">
				</div>
			</li>
			
	<?php 	} ?>
			</ul>
			<?php 

	} else { ?>
		<p>You have not any post with featured image</p>;
<?php	}
	?>
	<input id="reslide_insert_video_input" placeholder="add video from youtube" value/>
	<button id="reslide_insert_video_button">Insert video</button>
</div>
<style>

	select#ss {
		background: red;
		color: blue;
		border: 1px solid red;
	}
</style>
<div id="reslide_loading_overlay" style="display:none;">
	<div><img src="<?php echo RESLIDE_PLUGIN_PATH_IMAGES . "/loading_1.gif"; ?>"/></div>
</div>