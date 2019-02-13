<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly
function reslide_edit_slide_view( $_slider, $_slides, $_mainslide ) { // Slider's slide edit in  slide page
	function deleteSpacesNewlines( $str ) {
		return preg_replace( array( '/\r/', '/\n/' ), '', $str );
	}
	// getting sliders values from DB in json format
	$style      = json_decode( $_slider[0]->style );
	$params     = json_decode( $_slider[0]->params );
	$paramsJson = deleteSpacesNewlines( $_slider[0]->params );
	$styleJson  = deleteSpacesNewlines( $_slider[0]->style );
	$customJson = deleteSpacesNewlines( $_slider[0]->custom );

	$_row  = $_slides;
	$_id   = $_slider[0]->id;
	$count = 0;
	foreach ( $_row as $slide ) {
		if ( $slide->published == 0 ) {
			continue;
		}
		$count ++;
	}
	?>
	<script>
		const FRONT_IMAGES = '<?php echo RESLIDE_PLUGIN_PATH_FRONT_IMAGES;?>';
		const _IMAGES = '<?php echo RESLIDE_PLUGIN_PATH_IMAGES;?>';
			
		// initialize slider values in slider admin page
		var reslider = {
			id: '<?php echo $_id;?>',
			name: '<?php echo $_slider[0]->title;?>',
			params: JSON.parse('<?php echo $paramsJson;?>'),
			style: JSON.parse('<?php echo $styleJson;?>'),
			custom: JSON.parse('<?php echo $customJson;?>'),
			count: '<?php echo $count;?>',
			length: 0,

			slides: {}
		};
		<?php
		$Slidecount = 0;
		foreach ($_row as $row) {
			$Slidecount ++;
			$customSlideJson = deleteSpacesNewlines( $row->custom );
			$description = esc_js( html_entity_decode( $row->description, ENT_COMPAT, 'UTF-8' ) );
			$title = esc_js( html_entity_decode( $row->title, ENT_COMPAT, 'UTF-8' ) );
			$image_link = esc_js( html_entity_decode( $row->image_link, ENT_COMPAT, 'UTF-8' ) );
			$image_link_new_tab = esc_js( $row->image_link );
			?>
			reslider['slides']['slide' + '<?php echo $row->id;?>'] = {};
			reslider['slides']['slide' + '<?php echo $row->id;?>']['id'] = '<?php echo $row->id;?>';
			reslider.slides['slide' + '<?php echo $row->id;?>']['title'] = '<?php echo $title;?>';
			reslider.slides['slide' + '<?php echo $row->id;?>']['description'] = '<?php echo $description;?>';
			reslider.slides['slide' + '<?php echo $row->id;?>']['image_link'] = '<?php echo $image_link;?>';
			reslider.slides['slide' + '<?php echo $row->id;?>']['image_link_new_tab'] = '<?php echo $image_link_new_tab;?>';
			reslider.slides['slide' + '<?php echo $row->id;?>']['url'] = '<?php echo $row->thumbnail;?>';
			reslider.slides['slide' + '<?php echo $row->id;?>']['type'] = '<?php echo $row->type;?>';
			reslider.slides['slide' + '<?php echo $row->id;?>']['published'] = +'<?php echo $row->published;?>';
			reslider.slides['slide' + '<?php echo $row->id;?>']['ordering'] = +'<?php echo $row->ordering;?>';
			reslider.slides['slide' + '<?php echo $row->id;?>']['custom'] = JSON.parse('<?php echo $customSlideJson;?>');
		<?php    
		}?>
		reslider.length = +'<?php echo $Slidecount;?>';
	</script>
	<?php reslide_free_version_banner(); ?>
	<div class="reslide_slider_view_wrapper reslide_slide_view_wrapper">
		<div id="reslide_slider_view">
			<div class="add_slide_container">
				<a href="<?php echo wp_nonce_url(admin_url( 'admin.php?page=reslider&task=editslider&id=' . $_slider[0]->id ), 'reslide_editslider_'.$_slider[0]->id); ?>">
					<h2><?php echo $_slider[0]->title; ?></h2></a>
			</div>
			<div class="reslide_slider_images_list_wrapper">
				<ul id="reslide_slider_images_list">

					<?php
					foreach ( $_row as $rows ) {
						switch ( $rows->type ) {
							case 'video': ?>
								<li id="reslideitem_<?php echo $rows->id; ?>" class="reslideitem">
									<a class="edit video" 
									   href="<?php echo wp_nonce_url(admin_url( 'admin.php?page=reslider&task=editslider&id=' . $_id ), 'reslide_editslider_'.$_id); ?>">
										<?php echo reslide_text_sanitize( $rows->title ); ?>
										<iframe src="<?php echo esc_url($rows->thumbnail); ?>" frameborder="0"
										        allowfullscreen=""></iframe>
									</a>
									<b>
										<a href="#" class="quick_edit" data-slide-id="<?php echo absint($rows->id); ?>">Quick
											Edit</a></b>
								</li>
								<?php
								break;
							default: ?>
								<li id="reslideitem_<?php echo $rows->id; ?>"
								    class="reslideitem <?php if ( $rows->id == $_mainslide[0]->id ) {
									    echo 'active';
								    } ?>">
									<div class="reslideitem-img-container">
										<a class="edit"
										   href="<?php echo wp_nonce_url(admin_url( 'admin.php?page=reslider&task=editslide&slideid=' . $rows->id . '&id=' . $_id ), 'reslide_editslide_'.$_id); ?>">
											<img width="200" src="<?php echo esc_url($rows->thumbnail); ?>"/>
											<span
												class="title"><?php echo reslide_text_sanitize( $rows->title ); ?></span>
										</a>
								</li>
								<?php
						}
					} ?>
				</ul>
			</div>
		</div>
		<div id="reslide_slider_edit" class="slide_edit">
			<div class="header">
				<div><h3><?php echo reslide_text_sanitize( $_mainslide[0]->title ); ?></h3></div>
				<div class="slider-preview-options">
					<a id="reslide_preview" data="slide<?php echo $_mainslide[0]->id; ?>" href="#">Preview</a>
					<a id="save_custom_slide" href="#">Save Slide</a>
				</div>
			</div>
			<div class="settings">
				<div class="menu-content">
					<ul class="main-content">
						<li class="general active">
							<ul id="general-settings-slide" class="params custom slide">
								<li class="reslide-slide-title">
									<label for="reslide-slide-title">Title</label>
									<input type="text" id="reslide-slide-title"
									       value="<?php echo wp_unslash( $_mainslide[0]->title ); ?>"/><br/>
								</li>
								<li class="reslide-slide-description">
									<label for="reslide-slide-description">Description</label>
									<textarea type="text"
									          id="reslide-slide-description"><?php echo reslide_text_sanitize( $_mainslide[0]->description ); ?></textarea>
								</li>
								<li class="reslide-slide-image_link">
									<label for="reslide-slide-image_link">URL</label>
									<input type="text" id="reslide-slide-image_link"
									       value="<?php echo wp_unslash( $_mainslide[0]->image_link); ?>"/><br/>
								</li>
								<li class="reslide-slide-image_link_new_tab">
									<span for="reslide-slide-image_link_new_tab">Open in new tab</span>
									<input id="reslide-slide-image_link_new_tab" type="checkbox"
									       value="<?php echo esc_attr( $_mainslide[0]->image_link_new_tab ); ?>" <?php if ( $_mainslide[0]->image_link_new_tab ) {
										echo "checked";
									} ?> />
								</li>
								<li class="reslide-custom">
									<label for="reslide-custom">Slide Element:</label>
									<select id="reslide-custom">
										<option
											value="text" <?php echo ( $params->custom->type == 'text' ) ? "selected" : ""; ?>>
											Text
										</option>
										<option
											value="button" <?php echo ( $params->custom->type == 'button' ) ? "selected" : ""; ?>>
											Button
										</option>
										<option
											value="image" <?php echo ( $params->custom->type == 'image' ) ? "selected" : ""; ?>>
											Image
										</option>
									</select>
									<div id="reslide-custom-stylings">Style <i class="fa fa-pencil-square-o"
									                                           aria-hidden="true"></i></div>
									<div id="reslide-custom-add" class="reslide_drawelement free"
									     rel="reslide_<?php echo $params->custom->type; ?>"
									     data="<?php echo $params->custom->type; ?>" style="display:inline-block;">
										Add<span class="reslide-free" style="color:red;">&nbsp;(PRO)&nbsp;</span></div>
								</li>
							</ul>
							<div id="general-view">
								<div id="reslide-slider-construct">
									<div id="reslide-construct-vertical"></div>
									<div id="reslide-construct-horizontal"></div>
									<div id="reslide-title-construct" data="title">
										<div style="margin-left:5px;color:#565855">Title</div>
									</div>
									<div id="reslide-description-construct" data="description">
										<div style="margin-left:5px;color:#565855">Description</div>
									</div>
									<?php
									$button  = - 1;
									$customs = ( json_decode( $_mainslide[0]->custom ) );
									foreach ( $customs as $custom ) { ?>
										<?php
										switch ( $custom->type ) {
											case 'img':
												?>
												<img id="reslide_img<?php echo $custom->id; ?>"
												     class="reslide_img reslide_construct"
													 style="top: <?php echo $custom->style->top;?>;left: <?php echo $custom->style->left;?> "													 													 
												     data="img<?php echo $custom->id; ?>"
												     src="<?php echo esc_url($custom->src); ?>"
												     alt="<?php echo esc_attr($custom->alt); ?>">
												<?php
												break;
											case 'h3':
												?>
												<h3 id="reslide_h3<?php echo $custom->id; ?>"
												    class="reslide_h3 reslide_construct"
													style="top: <?php echo esc_attr($custom->style->top);?>;left: <?php echo esc_attr($custom->style->left);?> "
												    data="h3<?php echo $custom->id; ?>">
													<span class="reslide_construct_texter reslide_inputh3"
													      style="width: 100%; height: 100%; display: block;"><?php echo esc_html($custom->text); ?></span>
												</h3>
												<?php
												break;
											case 'button':
												$button ++;
												?>
												<button id="reslide_button<?php echo $custom->id; ?>"
												        class="reslide_button reslide_construct"
														style="top: <?php echo $custom->style->top;?>;left: <?php echo $custom->style->left;?> "													 														
												        data="button<?php echo $custom->id; ?>">
													<span class="reslide_construct_texter reslide_inputbutton"
													      style="width: 100%; height: 100%; display: block;"><?php echo esc_html($custom->text); ?></span>
												</button>
												<?php
												break;
											case 'iframe':
												?><img class="video"
												       src="<?php echo RESLIDE_PLUGIN_PATH_IMAGES . "/play.youtube.png"; ?>">
												<div class="properties">
													<span
														class="w"><?php echo esc_html($params->description->style->width); ?></span>
													<span
														class="h"><?php echo esc_html($params->description->style->height); ?></span>
												</div>
												<?php
												break;
										}
										?>
									<?php }
									?>
									<div id="zoom" class="sizer"></div>
									<a id="reslide_remove" title="Remove Element"><i class="fa fa-remove"
									                                                 aria-hidden="true"></i></a>
								</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
		<div id="reslide_slide_edit" style="display:none;">
			<input class="title" name="title" value=""/>
			<input class="description" name="description" value=""/>
			<div class="content">
				<span id="logo">Logo</span>
				<div class="contents"></div>
			</div>
			<div class="close">X</div>
		</div>
	</div>
	<div id="reslide_slider_preview_popup"></div>
	<div id="reslide_slider_preview">
		<div class="reslide_close" style="position:fixed;top: 12%;right: 6%;"><i class="fa fa-remove"
		                                                                         aria-hidden="true"></i></div>
		<style>
			/*** title ***/
			.reslide_bullets {
				position: absolute;

			}

			.reslide_bullets div, .reslide_bullets div:hover, .reslide_bullets .av {
				position: absolute;
				/* size of bullet elment */
				width: 12px;
				height: 12px;
				border-radius: 10px;
				filter: alpha(opacity=70);
				opacity: .7;
				overflow: hidden;
				cursor: pointer;
				border: #4B4B4B 1px solid;
			}

			.reslide_bullets div {
				background-color: <?php echo sanitize_hex_color("#".$params->bullets->style->background->color->link);?>;
			}

			body .reslide_bullets div:hover {
				background-color: <?php echo sanitize_hex_color("#".$params->bullets->style->background->color->hover);?>;
			}
			.reslide_bullets .bulletav {
				background-color: #74B8CF !important;
				border: #fff 1px solid;
			}

			/* arrows */

			.reslide_arrow_left, .reslide_arrow_right {
				display: block;
				position: absolute;
				/* size of arrow element */
				width: <?php echo absint($params->arrows->style->background->width);?>px;
				height: <?php echo absint($params->arrows->style->background->height);?>px;
				cursor: pointer;
				background-image: url(<?php echo trailingslashit( RESLIDE_PLUGIN_PATH_FRONT_IMAGES ).'arrows/arrows-'.$params->arrows->type.'.png'; ?>);
				overflow: hidden;
			}

			.reslide_arrow_left {
				background-position: <?php echo esc_attr($params->arrows->style->background->left);?>;
			}
			.reslide_arrow_left:hover {
				background-position: <?php echo esc_attr($params->arrows->style->background->left);?>;
			}
			.reslide_arrow_right {
				background-position: <?php echo esc_attr($params->arrows->style->background->right);?>;
			}
			.reslide_arrow_right:hover {
				background-position: <?php echo esc_attr($params->arrows->style->background->right);?>;
			}

			.reslide_arrow_left.reslide_arrow_leftdn {
				background-position: <?php echo esc_attr($params->arrows->style->background->left);?>;
			}

			.reslide_arrow_right.reslide_arrow_rightdn {
				background-position: <?php echo esc_attr($params->arrows->style->background->right);?>;
			}

			/*** title ***/
			.reslidetitle {
				box-sizing: border-box;
				padding: 1%;
				overflow: hidden;
			}

			.reslidetitle h3 {
				margin: 0;
				padding: 0;
				word-wrap: break-word;
				width: 100%;
				text-align: center;
				font-size: inherit !important;
			}
		</style>
	</div>
	<?php
	foreach ( $customs as $custom ) {
		$custom->id = absint($custom->id);
		if ( $custom->type == "button" || $custom->type == "h3" ) { ?>
			<div id="reslide_slider_<?php echo $custom->type . $custom->id; ?>_styling"
			     class="reslide-styling reslide-custom-styling main-content" style="display:none;">
				<div class="reslide_close"><i class="fa fa-remove" aria-hidden="true"></i></div>
				<span class="popup-type" data="off"><img
						src="<?php echo RESLIDE_PLUGIN_PATH_IMAGES . "/light_1.png"; ?>"></span>
				<form id="reslide-<?php echo $custom->type; ?>-styling" class="custom">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>]" rel="0" value="{}">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][id]" rel="0"
					       value="<?php echo $custom->id; ?>">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][type]" rel="0"
					       value="<?php echo $custom->type; ?>">
					<input type="hidden" class="text" name="custom[<?php echo $custom->type . $custom->id; ?>][text]"
					       rel="0" value="<?php echo esc_attr( $custom->text ); ?>">
					<?php if ( $custom->type == 'button' ) { ?>
						<span class="size">
							<label>Button url:</label>
							<input class="link" type="text"
							       name="custom[<?php echo $custom->type . $custom->id; ?>][link]" rel="0" value="<?php echo ($custom->link?$custom->link:'#');?>">
							</span>
					<?php } ?>
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][style]" rel="0"
					       value="{}">
					<input type="hidden" class="width"
					       name="custom[<?php echo $custom->type . $custom->id; ?>][style][width]" rel="0"
					       value="<?php echo esc_attr($custom->style->width); ?>">
					<input type="hidden" class="height"
					       name="custom[<?php echo $custom->type . $custom->id; ?>][style][height]" rel="0"
					       value="<?php echo esc_attr($custom->style->height); ?>">
					<input type="hidden" class="top"
					       name="custom[<?php echo $custom->type . $custom->id; ?>][style][top]" rel="0"
					       value="<?php echo esc_attr($custom->style->top); ?>">
					<input type="hidden" class="left"
					       name="custom[<?php echo $custom->type . $custom->id; ?>][style][left]" rel="0"
					       value="<?php echo esc_attr($custom->style->left); ?>">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][style][background]"
					       rel="0" value="{}">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][style][border]"
					       rel="0" value="{}">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][style][font]" rel="0"
					       value="{}">
				<span class=" color">
				<label for="custom-background-color-link">Background Color:</label>									
				<input type="text" class="jscolor" id="custom-bullets-background-color-link"
				       name="custom[<?php echo $custom->type . $custom->id; ?>][style][background][color]" rel="#"
				       value="<?php echo esc_attr($custom->style->background->color); ?>">
				</span class="border-width">
				<span class=" color">
				<label for="custom-background-color-hover">Hover Color:</label>																			
				<input type="text" class="jscolor" id="custom-bullets-background-color-hover"
				       name="custom[<?php echo $custom->type . $custom->id; ?>][style][background][hover]" rel="#"
				       value="<?php echo esc_attr($custom->style->background->hover); ?>">
				</span>
				<span class=" color">
				<label for="custom-background-opacity">Opacity:</label>																			
				<input type="number" id="custom-background-opacity"
				       name="custom[<?php echo $custom->type . $custom->id; ?>][style][opacity]" rel="0"
				       value="<?php echo esc_attr($custom->style->opacity); ?>">%
				</span>
				<span class=" size">
				<label for="custom-border-size">Border:</label>																			
				<input type="number" id="custom-border-width"
				       name="custom[<?php echo $custom->type . $custom->id; ?>][style][border][width]" rel="px"
				       value="<?php echo esc_attr($custom->style->border->width); ?>">
				</span>
				<span class="color">
				<label for="custom-border-color">Border Color:</label>																			
				<input type="text" class="jscolor" id="custom-custom-border-color"
				       name="custom[<?php echo $custom->type . $custom->id; ?>][style][border][color]" rel="#"
				       value="<?php echo esc_attr($custom->style->border->color); ?>">
				</span>
				<span class=" size">
				<label for="custom-background-radius">Border Radius:</label>																			
				<input type="number" id="custom-custom-border-radius"
				       name="custom[<?php echo $custom->type . $custom->id; ?>][style][border][radius]" rel="px"
				       value="<?php echo esc_attr($custom->style->border->radius); ?>">%
				</span>
				<span class="size">
				<label for="custom-font-size">Font Size:</label>																			
				<input type="number" id="custom-font-size"
				       name="custom[<?php echo $custom->type . $custom->id; ?>][style][font][size]" rel="px"
				       value="<?php echo esc_attr($custom->style->font->size); ?>">
				</span>
				<span class="color">
				<label for="custom-font-color">Font Color:</label>																			
				<input type="text" class="jscolor" id="custom-font-color"
				       name="custom[<?php echo $custom->type . $custom->id; ?>][style][color]" rel="#"
				       value="<?php echo esc_attr($custom->style->color); ?>">
				</span>
				</form>
				<div class="reslide_content">
					<div class="reslide_<?php echo $custom->type; ?> reslide_custom"
					     style="width: <?php echo $custom->style->width; ?>; height: <?php echo $custom->style->height; ?>;">
						<div class="reslide_custom_child"></div>
						<div class="reslide_custom_child"></div>
						<?php if ( $custom->type == 'button' ) {
							$custom->text = str_replace( '&#39;', "'", $custom->text );
							$custom->text = str_replace( '&#34;', '"', $custom->text );
							?>
							<span class="btn"><?php echo $custom->text; ?></span>
						<?php } else if ( $custom->type == 'h3' ) {
							$custom->text = str_replace( '&#39;', "'", $custom->text );
							$custom->text = str_replace( '&#34;', '"', $custom->text );
							?>
							<span class="h3"><?php echo $custom->text; ?></span>
						<?php } ?>
					</div>
				</div>
			</div>
			<?php

		} elseif ( $custom->type == "img" ) { ?>
			<div id="reslide_slider_<?php echo $custom->type . $custom->id; ?>_styling"
			     class="reslide-styling reslide-custom-styling main-content" style="display:none;">
				<div class="reslide_close"><i class="fa fa-remove" aria-hidden="true"></i></div>
				<span class="popup-type" data="off"><img
						src="<?php echo RESLIDE_PLUGIN_PATH_IMAGES . "/light_1.png"; ?>"></span>
				<form id="reslide-<?php echo $custom->type; ?>-styling" class="custom">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>]" rel="0" value="{}">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][style]" rel="0"
					       value="{}">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][id]" rel="0"
					       value="<?php echo $custom->id; ?>">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][style][border]"
					       rel="0" value="{}">
					<input type="hidden" id="custom_src" name="custom[<?php echo $custom->type . $custom->id; ?>][src]"
					       rel="0" value="<?php echo esc_attr($custom->src); ?>">
					<input type="hidden" id="custom_alt" name="custom[<?php echo $custom->type . $custom->id; ?>][alt]"
					       rel="0" value="<?php echo esc_attr($custom->alt); ?>">
					<input type="hidden" name="custom[<?php echo $custom->type . $custom->id; ?>][type]" rel="0"
					       value="img">
					<input type="hidden" class="width"
					       name="custom[<?php echo $custom->type . $custom->id; ?>][style][width]" rel="0"
					       value="<?php echo esc_attr($custom->style->width); ?>">
					<input type="hidden" class="height"
					       name="custom[<?php echo $custom->type . $custom->id; ?>][style][height]" rel="0"
					       value="<?php echo esc_attr($custom->style->height); ?>">
					<input type="hidden" class="top"
					       name="custom[<?php echo $custom->type . $custom->id; ?>][style][top]" rel="0"
					       value="<?php echo esc_attr($custom->style->top); ?>">
					<input type="hidden" class="left"
					       name="custom[<?php echo $custom->type . $custom->id; ?>][style][left]" rel="0"
					       value="<?php echo esc_attr($custom->style->left); ?>">
			<span class=" color">
			<label for="custom-background-opacity">Opacity:</label>																			
			<input type="number" id="custom-background-opacity"
			       name="custom[<?php echo $custom->type . $custom->id; ?>][style][opacity]" rel="0"
			       value="<?php echo esc_attr($custom->style->opacity); ?>">%
			</span>
			<span class="border-width size">
			<label for="custom-custom-border-size">Border:</label>																			
			<input type="number" id="custom-custom-border-width"
			       name="custom[<?php echo $custom->type . $custom->id; ?>][style][border][width]" rel="px"
			       value="<?php echo esc_attr($custom->style->border->width); ?>">
			</span>		
			<span class="border-color color">			
			<label for="custom-custom-border-color">Border Color:</label>																			
			<input type="text" class="jscolor" id="custom-custom-border-color"
			       name="custom[<?php echo $custom->type . $custom->id; ?>][style][border][color]" rel="#"
			       value="<?php echo esc_attr($custom->style->border->color); ?>">
			</span>									
			<span class="border-radius size">									
			<label for="custom-custom-background-radius">Border Radius:</label>	
			<input type="number" id="custom-custom-border-radius"
			       name="custom[<?php echo $custom->type . $custom->id; ?>][style][border][radius]" rel="px"
			       value="<?php echo esc_attr($custom->style->border->radius); ?>">
			</span>
				</form>
				<div class="reslide_content">
					<div class="reslide_img reslide_custom"><img class="img" src="<?php echo esc_attr($custom->src); ?>"></div>
				</div>
			</div>
			<?php
		}
	} ?>
	<style>
		#reslide_slider_preview_popup {
			display: none;
			position: fixed;
			height: 100%;
			width: 100%;
			background: #000000;
			opacity: 0.5;
			top: 0;
			left: 0;
			z-index: 9998;
		}

		#reslide_slider_preview {
			padding: 40px;
			overflow-y: scroll;
			overflow: overlay;
			display: none;
			position: fixed;
			height: 80%;
			width: 90%;
			background: #f1f1f1;
			opacity: 1;
			top: 10%;
			left: 5%;
			z-index: 10000;
			box-sizing: border-box;
		}

		/*** title styling***/
		#reslide_slider_title_styling .reslide_content, #reslide_slider_description_styling .reslide_content, .reslide-custom-styling .reslide_content {

		}

		.reslide-custom-styling .reslide_content .reslide_custom {
			box-sizing: border-box;
		}

		/*** title styling***/
		.reslide-custom-styling .reslide_content .reslide_custom .reslide_img {
			box-sizing: border-box;
		}

		.reslide-custom-styling .reslide_content .reslide_custom img {
			width: 100%;
			height: 100%;
			max-width: 100%;
			max-height: 100%;
			display: block;
		}

		.reslideimg {
			overflow: hidden;
			box-sizing: border-box;
			box-sizing: border-box;
		}

		#reslide_slider_preview .reslide_content {
			position: absolute;
			background: #FBABAB;
			width: 100%;
			height: 100%;
		}

		#reslide-slider-construct {
			width: <?php echo absint($style->width);?>px;
			height: <?php echo absint($style->height);?>px;
			position: relative;
			overflow: hidden;
		}

		#reslide-slider-construct:after {
			content: "";
			background: url(<?php echo esc_url($_mainslide[0]->thumbnail);?>);
			background-size: 100% 100%;
			background-repeat: no-repeat;
			opacity: 0.5;
			top: 0;
			left: 0;
			bottom: 0;
			right: 0;
			width: 100%;
			height: 100%;
			position: absolute;
			z-index: 0;
		}

		.reslide_construct {
			position: absolute;
			width: 100px;
			height: 50px;
			margin: 0;
			padding: 0;
			word-wrap: break-word;
			z-index: 1;
			background: green;
			display: inline-block;
			-webkit-touch-callout: none;
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			cursor: move;
		}

		img.reslide_construct {
			height: auto;
		}

		.reslide_construct .reslide_remove {
			position: absolute;
			right: 0;
			top: 0;
			color: red;
		}

		#reslide-title-construct {
			position: absolute;
			min-width: 50px;
			width: <?php echo absint($params->title->style->width);?>px;
			height: <?php echo absint($params->title->style->height);?>px;
			background: transparent;
			cursor: move;
			top: <?php echo esc_attr($params->title->style->top);?>;
			left: <?php echo esc_attr($params->title->style->left);?>;
			opacity: 0.9;
			color: rgb(86, 88, 85);
			filter: alpha(opacity=<?php echo abs($params->title->style->opacity);?>);
			border: 2px dashed #898989;
			word-wrap: break-word;
			overflow: hidden;
			-webkit-touch-callout: none;
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			box-sizing: border-box;
		}

		#reslide-description-construct {
			position: absolute;
			min-width: 50px;
			width: <?php echo absint($params->description->style->width);?>px;
			height: <?php echo absint($params->description->style->height);?>px;
			background: <?php echo sanitize_hex_color("#".$params->description->style->background->color);?>;
			background: transparent;
			cursor: move;
			top: <?php echo esc_attr($params->description->style->top);?>;
			left: <?php echo esc_attr($params->description->style->left);?>;
			opacity: 0.9;
			color: rgb(86, 88, 85);
			border: 2px dashed #898989;
			filter: alpha(opacity=<?php echo abs($params->description->style->opacity);?>);
			word-wrap: break-word;
			overflow: hidden;
			-webkit-touch-callout: none;
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
			box-sizing: border-box;
		}

		#reslide-custom-construct {
			position: absolute;
			min-width: 50px;
			min-height: 50px;
			cursor: move;
			word-wrap: break-word;
			overflow: hidden;
			-webkit-touch-callout: none;
			-webkit-user-select: none;
			-khtml-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		#zoom {
			width: 10px;
			height: 10px;
			position: absolute;
			display: none;
			right: 0;
			bottom: 0;
			border: 1px solid black;
			cursor: se-resize;
			z-index: 9999;
		}

		#reslide_remove {
			width: 10px;
			height: 10px;
			position: absolute;
			display: none;
			right: 0;
			bottom: 0;
			cursor: pointer;
			color: #D2646C;
			z-index: 9999;
		}

		.reslide_construct .properties {
			position: absolute;
			width: 30px;
			height: 40px;
			top: 0;
			right: 0;
			z-index: 1200;
			font-size: 8px;
			color: #000;
			text-shadow: 3px 3px 1px #fff;
		}

		.reslide_construct .properties .w {
			position: absolute;
			width: 100%;
			height: 18px;
			top: 0;
		}

		.reslide_construct .properties .h {
			position: absolute;
			width: 100%;
			height: 18px;
			top: 22px;
		}

		.reslide_construct.reslide_h3 {
			background: transparent;
			border: 1px solid #000024;
		}

		.reslide_construct.reslide_h3 .reslide_construct_textarea {
			background: transparent;
			resize: none;
			overflow: hidden;
			word-wrap: break-word;
		}

		.reslide_construct.reslide_button, .reslide-custom-styling .reslide_button.reslide_custom {
			width: 100px;
			height: 50px;
			position: relative;
		}

		.reslide-custom-styling .reslide_content .reslide_button {
			background: none;
		}

		.reslide_button.reslide_custom > div.reslide_custom_child {
			width: 100%;
			height: 100%;
			position: absolute;
			background: #1EBD27;
		}

		.reslide_h3.reslide_custom > .h3 {
			width: 100%;
			height: 100%;
			margin: 0;
			padding: 1%;
			text-align: center;
			position: absolute;
		}

		.reslide-custom-styling .reslide_h3.reslide_custom {
			width: 100px;
			height: 50px;
			border: 2px solid #000024;
			box-sizing: border-box;
			border-radius: 0;
			background: transparent;
			resize: none;
			overflow: hidden;
			word-wrap: break-word;
			position: relative;
		}

		.reslide-custom-styling .reslide_img.reslide_custom {
			width: 100px;
			border-radius: 0;
			box-sizing: border-box;
			position: relative;
		}

		.reslide_h3.reslide_custom > div.reslide_custom_child {
			width: 100%;
			height: 100%;
			position: absolute;
		}

		.reslide_h3.reslide_custom > .h3 {
			width: 100%;
			height: 100%;
			position: absolute;
		}

		.reslideh3 {
			box-sizing: border-box;
		}

		.reslide_construct.reslide_button .reslide_construct_textarea {
			resize: none;
			overflow: hidden;
			word-wrap: break-word;
		}

		/*** title in styling ***/
		.reslide_title > div.reslide_title_child, .reslide_description > div.reslide_description_child {
			width: 100%;
			height: 100%;
			position: absolute;
		}

		.reslide_title > .title {
			width: 100%;
			height: 100%;
			position: absolute;
			text-align: center;
			display: block;
		}

		.reslide_description > .description {
			width: 100%;
			height: 100%;
			position: absolute;
			text-align: center;
			display: block;
		}

		.reslidetitle span, .reslidedescription span {
			display: block;
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;

		}

		<?php
		foreach ($customs as $custom) {
			$custom->id = absint($custom->id);
			switch ($custom->type) {
				case 'img':
				?>
				/*** construct conatiner ***/
				#reslide_<?php echo $custom->type.$custom->id;?> {
					width: <?php echo absint($custom->style->width);?>px;
					height: <?php echo absint($custom->style->height);?>px;
					top: <?php echo esc_attr($custom->style->top);?>;
					left: <?php echo esc_attr($custom->style->left);?>;
				}

				#reslide_<?php echo $custom->type.$custom->id;?> img {
					width: 100%;
					height: 100%;
				}

				/*** styling conatiner ***/
				#reslide_slider_<?php echo $custom->type.$custom->id;?>_styling .reslide_content .reslide_img {
					width: <?php echo absint($custom->style->width);?>px;
					height: <?php echo absint($custom->style->height);?>px;
					border-width: <?php echo absint($custom->style->border->width);?>px;
					border-radius: <?php echo absint($custom->style->border->radius);?>px;
					border-color: <?php echo sanitize_hex_color("#".$custom->style->border->color);?>;
					border-style: solid;
					overflow: hidden;
				}

				#reslide_slider_<?php echo $custom->type.$custom->id;?>_styling .img {
					width: 100%;
					height: 100%;
					display: block;
					opacity: <?php echo (abs($custom->style->opacity)/100)?>;
				}

				<?php
				case 'h3':
				?>

				/*** construct conatiner ***/

				#reslide_<?php echo $custom->type.$custom->id;?> {
					width: <?php echo absint($custom->style->width);?>px;
					height: <?php echo absint($custom->style->height);?>px;
					top: <?php echo esc_attr($custom->style->top);?>;
					left: <?php echo esc_attr($custom->style->left);?>;
					position: absolute;
					box-sizing: border-box;
				}

				#reslide_<?php echo $custom->type.$custom->id;?> h3 {
					margin: 0;
					padding: 0;
					word-wrap: break-word;
				}

				/*** styling conatiner ***/
				#reslide_slider_<?php echo $custom->type.$custom->id;?>_styling .reslide_content .reslide_h3 {
					width: <?php echo absint($custom->style->width);?>px;
					height: <?php echo absint($custom->style->height);?>px;
					color: <?php echo sanitize_hex_color("#".$custom->style->color);?>;
					font-size: <?php echo absint($custom->style->font->size);?>px;
					border-width: <?php echo absint($custom->style->border->width);?>px;
					border-radius: <?php echo absint($custom->style->border->radius);?>px;
					border-color: <?php echo sanitize_hex_color("#".$custom->style->border->color);?>;
					border-style: solid;
				}

				#reslide_slider_<?php echo $custom->type.$custom->id;?>_styling .reslide_custom_child {
					background: <?php echo sanitize_hex_color("#".$custom->style->background->color);?>;
					opacity: <?php echo (abs($custom->style->opacity)/100)?>;
				}

				<?php
				break;
				case 'button':
				?>

				/*** construct conatiner ***/

				#reslide_<?php echo $custom->type.$custom->id;?> {
					width: <?php echo absint($custom->style->width);?>px;
					height: <?php echo absint($custom->style->height);?>px;
					top: <?php echo esc_attr($custom->style->top);?>;
					left: <?php echo esc_attr($custom->style->left);?>;
					position: absolute;
				}

				#reslide_<?php echo $custom->type.$custom->id;?> button {
					width: 100%;
					height: 100%;
					display: block;
				}

				/*** styling conatiner ***/

				#reslide_slider_<?php echo $custom->type.$custom->id;?>_styling .reslide_content .reslide_button {
					width: <?php echo absint($custom->style->width);?>px;
					height: <?php echo absint($custom->style->height);?>px;
					color: <?php echo sanitize_hex_color("#".$custom->style->color);?>;
					font-size: <?php echo absint($custom->style->font->size);?>px;
					border-width: <?php echo absint($custom->style->border->width);?>px;
					border-color: <?php echo sanitize_hex_color("#".$custom->style->border->color);?>;
					border-radius: <?php echo absint($custom->style->border->radius);?>px;
					border-style: solid;
				}

				#reslide_slider_<?php echo $custom->type.$custom->id;?>_styling .reslide_custom_child {
					background: <?php echo sanitize_hex_color("#".$custom->style->background->color);?>;
					opacity: <?php echo (abs($custom->style->opacity)/100)?>;
				}

				<?php
				break;
				case 'iframe':
				?>
				#reslide_<?php echo $custom->type.$custom->id;?> {
					width: <?php echo absint($custom->style->width);?>px;
					height: <?php echo absint($custom->style->height);?>px;
					top: <?php echo esc_attr($custom->style->top);?>;
					left: <?php echo esc_attr($custom->style->left);?>;
					position: relative;
					-webkit-background-size: cover;
					-moz-background-size: cover;
					-o-background-size: cover;
					background-size: cover;
				}

				#reslide_<?php echo $custom->type.$custom->id;?> img {
					width: 40px;
					height: 20px;
					position: absolute;
					top: 50%;
					left: 50%;
					display: block;
					transform: translate(-50%, -50%);
				}
				<?php
				break;
				}
		} ?>
	</style>
	<?php
}
