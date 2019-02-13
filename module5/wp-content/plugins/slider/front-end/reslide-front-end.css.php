<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Php driven styles for front-end
 */
?>
<style>
#slider<?php echo $sliderID;?>_container {
    margin: 0 auto;
    margin-bottom: 10px;
    position: relative;
    top: 0;
    left: 0;
    display: none;
    overflow:hidden;
}
#slider<?php echo $sliderID;?>_container .reslide_slides img {
    display: none;
}
#slider<?php echo $sliderID;?>_container .reslide_loading {
    position: absolute;
    top: 0;
    left: 0;
}
#slider<?php echo $sliderID;?>_container .reslide_loading  > div {
    width:100%;
    height:100%;
    position: absolute;
    background: #ccc;
}
#slider<?php echo $sliderID ;?>_container .reslide_slides {
    width: <?php echo  absint($style->width);?>px;
    height: <?php echo  absint($style->height);?>px;
    position: absolute;
    left: 0;
    top: 0;
    overflow: hidden;
    cursor: move;
}

/*Title and description defaults ***/

#slider<?php echo $sliderID ;?>_container .reslidetitle,#slider<?php echo $sliderID ;?>_container .reslidedescription  {
    position: absolute;
    overflow: hidden;
    z-index: 2;
}
#slider<?php echo $sliderID ;?>_container .reslidetitle > div ,#slider<?php echo $sliderID ;?>_container .reslidedescription > div {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
    font-size: 14px;
}
#slider<?php echo $sliderID ;?>_container .reslidetitle > span ,#slider<?php echo $sliderID ;?>_container .reslidedescription > span {
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
    z-index: 1;
    padding: 10px;

}

/*Title styles ***/


#slider<?php echo $sliderID ;?>_container .reslidetitle {
    width: <?php echo absint($title->style->width); ?>px;
    height: <?php echo absint($title->style->height); ?>px;
    top: <?php echo esc_html($title->style->top); ?>;
    left: <?php echo esc_html($title->style->left); ?>;
    border: <?php echo absint($title->style->border->width); ?>px solid #<?php echo sanitize_text_field($title->style->border->color); ?>;
    border-radius: <?php echo intval($title->style->border->radius); ?>px;
}
#slider<?php echo $sliderID ;?>_container .reslidetitle > div {
    background: <?php echo sanitize_hex_color("#".$title->style->background->color); ?>;
    opacity: <?php echo abs($title->style->opacity)/100;?>;
    filter: alpha(opacity=<?php echo abs($title->style->opacity); ?>);
}
#slider<?php echo $sliderID ;?>_container .reslidetitle > span {
    padding: 10px;
    text-align: center;
    font-size: <?php echo absint($title->style->font->size); ?>px;
    color: <?php echo sanitize_hex_color("#".$title->style->color); ?>;
}

/*Description styles ***/

#slider<?php echo $sliderID ;?>_container .reslidedescription {
    width: <?php echo absint($description->style->width); ?>px;
    height: <?php echo absint($description->style->height); ?>px;
    top: <?php echo esc_html($description->style->top); ?>;
    left: <?php echo esc_html($description->style->left); ?>;
    border: <?php echo absint($description->style->border->width); ?>px solid <?php echo sanitize_hex_color("#".$description->style->border->color); ?>;
    border-radius: <?php echo absint($description->style->border->radius); ?>px;
}
#slider<?php echo $sliderID ;?>_container .reslidedescription > div {
    background: <?php echo sanitize_hex_color("#".$description->style->background->color); ?>;
    opacity: <?php echo abs($description->style->opacity)/100;?>;
    filter: alpha(opacity=<?php echo abs($description->style->opacity); ?>);
}
#slider<?php echo $sliderID ;?>_container .reslidedescription > span {
    font-size: <?php echo absint($description->style->font->size); ?>px;
    color: <?php echo sanitize_hex_color("#".$description->style->color); ?>;
}

/* slide static elements ***/

<?php
foreach($_reslides as $slide){
    if($slide->published == 0) continue;
    $customSlide = json_decode($slide->custom);
    foreach($customSlide as $customSlide) {
        switch($customSlide->type) {
            case 'h3':
                ?>
            .slide<?php echo $slide->id;?>h3<?php echo $customSlide->id;?>  {
                margin: 0;
                padding: 0;
                z-index: 2;
                position: absolute;
                background: none;
                width: <?php echo absint($customSlide->style->width); ?>px;
                height: <?php echo absint($customSlide->style->height); ?>px;
                border: <?php echo absint($customSlide->style->border->width); ?>px solid <?php echo sanitize_hex_color("#".$customSlide->style->border->color); ?>;
                top: <?php echo esc_html($customSlide->style->top); ?>;
                left: <?php echo esc_html($customSlide->style->left); ?>;
                border-radius: <?php echo absint($customSlide->style->border->radius); ?>px;
                overflow: hidden;
                cursor: text;
            }
            .slide<?php echo $slide->id;?>h3<?php echo $customSlide->id;?> > span {
                width: 100%;
                height: 100%;
                z-index: 2;
                position: absolute;
                top: 0;
                left: 0;
                opacity: <?php echo abs($customSlide->style->opacity)/100;?>;
                filter: alpha(opacity=<?php echo abs($customSlide->style->opacity); ?>);
                background: <?php echo sanitize_hex_color("#".$customSlide->style->background->color); ?>;
            }
            .slide<?php echo $slide->id;?>h3<?php echo $customSlide->id;?>:hover > span:first-child {
                opacity: <?php echo abs($customSlide->style->opacity)/100;?>;
                filter: alpha(opacity=<?php echo abs($customSlide->style->opacity); ?>);
                background: <?php echo sanitize_hex_color("#".$customSlide->style->background->hover); ?>;
            }
            .slide<?php echo $slide->id;?>h3<?php echo $customSlide->id;?> > span:first-child {
                background: <?php echo sanitize_hex_color("#".$customSlide->style->background->color); ?>;
            }
            .slide<?php echo $slide->id;?>h3<?php echo $customSlide->id;?> .gg {
                width: 100%;
                height: 100%;
                display: block;
                position: absolute;
                text-align: center;
                background: none;
                opacity: 1;
                top: 0;
                left: 0;
                font-size: <?php echo absint($customSlide->style->font->size); ?>px;
                z-index: 2;
                color: <?php echo sanitize_hex_color("#".$customSlide->style->color); ?>;
                line-height: 1.5;
            }
            <?php
                break;
                case 'button':
            ?>
            #slider<?php echo $sliderID ;?>_container  .slide<?php echo $sliderID ;?>_<?php echo $slide->id;?> 	.slide<?php echo $slide->id;?>button<?php echo $customSlide->id;?>.reslidebutton {
                padding: 0px;
                z-index: 2;
                position: absolute;
                border: 2px solid rgb(0, 0, 36);
                top: 0;
                left: 0;
                border-radius: 0;
                background: none;
                width: <?php echo absint($customSlide->style->width); ?>px;
                height: <?php echo absint($customSlide->style->height); ?>px;
                border: <?php echo absint($customSlide->style->border->width); ?>px solid #<?php echo absint($customSlide->style->border->color); ?>;
                top: <?php echo esc_html($customSlide->style->top); ?>;
                left: <?php echo esc_html($customSlide->style->left); ?>;
                border-radius: <?php echo absint($customSlide->style->border->radius); ?>px;
                overflow: hidden;
            }
            #slider<?php echo $sliderID ;?>_container  .slide<?php echo $sliderID ;?>_<?php echo $slide->id;?> 	.slide<?php echo $slide->id;?>button<?php echo $customSlide->id;?> div {
                width: 100%;
                height: 100%;
                z-index: 2;
                position: absolute;
                top: 0px;
                left: 0px;
                opacity: <?php echo abs($customSlide->style->opacity)/100;?>;
                filter: alpha(opacity=<?php echo abs($customSlide->style->opacity); ?>);
                background: <?php echo sanitize_hex_color("#".$customSlide->style->background->color); ?>;
            }
            #slider<?php echo $sliderID ;?>_container  .slide<?php echo $sliderID ;?>_<?php echo $slide->id;?> 	.slide<?php echo $slide->id;?>button<?php echo $customSlide->id;?>:hover div {
                opacity: <?php echo abs($customSlide->style->opacity)/100; ?>;
                filter: alpha(opacity=<?php echo abs($customSlide->style->opacity); ?>);
                background: <?php echo sanitize_hex_color("#".$customSlide->style->background->hover); ?>;
            }
            #slider<?php echo $sliderID ;?>_container  .slide<?php echo $sliderID ;?>_<?php echo $slide->id;?> 	.slide<?php echo $slide->id;?>button<?php echo $customSlide->id;?> .gg {
                font-size: <?php echo absint($customSlide->style->font->size); ?>px;
                width: 100%;
                height: 100%;
                z-index: 2;
                color: <?php echo sanitize_hex_color("#".$customSlide->style->color);?>;
                display: block;
                position: absolute;
                text-align: center;
                top: 0px;
                left: 0px;
                text-decoration: none;
            }
            #slider<?php echo $sliderID ;?>_container  .slide<?php echo $sliderID ;?>_<?php echo $slide->id;?> 	.slide<?php echo $slide->id;?>button<?php echo $customSlide->id;?> .gg span {
                width: 100%;
                display: block;
                height: auto;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%,-50%);
                text-align: center;
                word-wrap: break-word;
                font-size: <?php echo absint($customSlide->style->font->size);?>px;
                color: <?php echo sanitize_hex_color("#".$customSlide->style->color);?>;
            }

            <?php
                break;
                case 'img':
            ?>
            #slider<?php echo $sliderID ;?>_container .slide<?php echo $sliderID ;?>_<?php echo $slide->id;?> .slide<?php echo $slide->id;?>img<?php echo $customSlide->id;?>.reslideimg {
                position: absolute;
                z-index: 1;
                overflow: hidden;
                width: <?php echo absint($customSlide->style->width);?>px;
                height: <?php echo absint($customSlide->style->height);?>px;
                border: <?php echo absint($customSlide->style->border->width);?>px solid <?php echo sanitize_hex_color("#".$customSlide->style->border->color);?>;
                top: <?php echo esc_html($customSlide->style->top);?>;
                left: <?php echo esc_html($customSlide->style->left);?>;
                border-radius: <?php echo absint($customSlide->style->border->radius);?>px;
            }
            #slider<?php echo $sliderID ;?>_container  .slide<?php echo $sliderID ;?>_<?php echo $slide->id;?> 	.slide<?php echo $slide->id;?>img<?php echo $customSlide->id;?>.reslideimg img {
                width: 100%;
                height: 100%;
                z-index: 0;
                opacity: <?php echo abs($customSlide->style->opacity)/100;?>;
                filter: alpha(opacity=<?php echo  abs($customSlide->style->opacity);?>);
            }

            <?php break;
        }
    }
}
?>

#slider<?php echo $sliderID ;?>_container	#slider<?php echo $sliderID ;?>_container .reslide_any {
    width: 100px;
    height: 26px;
    position: absolute;
    top: 10px;
    left: 400px;
}
/* Sliders Customs Statics***/
<?php
		foreach($customs as $custom){ ?>
<?php switch($custom->type) {
            case 'h3':
        ?>
#slider<?php echo $sliderID ;?>_container	.reslideh3<?php echo $custom->id;?> {
    margin: 0px;
    padding: 0px;
    z-index: 2;
    position: absolute;
    background: none;
    width: <?php echo absint($custom->style->width);?>px;
    height: <?php echo absint($custom->style->height);?>px;
    border: <?php echo absint($custom->style->border->width);?>px solid <?php echo sanitize_hex_color("#".$custom->style->border->color);?>;
    top: <?php echo esc_html($custom->style->top);?>;
    left: <?php echo esc_html($custom->style->left);?>;
    border-radius: <?php echo abs($custom->style->border->radius);?>px;
    overflow: hidden;
}
#slider<?php echo $sliderID ;?>_container	.reslideh3<?php echo $custom->id;?> span:first-child {
    width: 100%;
    height: 100%;
    z-index: 2;
    position: absolute;
    top: 0;
    left: 0;
    opacity: <?php echo abs($custom->style->opacity)/100;?>;
    filter: alpha(opacity=<?php echo abs($custom->style->opacity);?>);
    background: <?php echo sanitize_hex_color("#".$custom->style->background->color);?>;
}
#slider<?php echo $sliderID ;?>_container	.reslideh3<?php echo $custom->id;?>:hover span:first-child {
    background: <?php echo sanitize_hex_color("#".$custom->style->background->hover);?>;
}
#slider<?php echo $sliderID ;?>_container	.reslideh3<?php echo $custom->id;?> .gg {
    width: 100%;
    height: 100%;
    display: block;
    position: absolute;
    text-align: center;
    top: 0;
    left: 0;
    font-size: <?php echo absint($custom->style->font->size);?>px;
    z-index: 2;
    color: <?php echo sanitize_hex_color("#".$custom->style->color);?>;
    line-height: 1.5;
}
<?php
    break;
    case 'button':
?>
#slider<?php echo $sliderID ;?>_container	.reslidebutton<?php echo $custom->id;?> {
    padding: 0;
    z-index: 2;
    position: absolute;
    border: 2px solid rgb(0, 0, 36);
    top: 0;
    left: 0;
    border-radius: 0px;
    background: none;
    width: <?php echo $custom->style->width;?>px;
    height: <?php echo $custom->style->height;?>px;
    border: <?php echo absint($custom->style->border->width);?>px solid <?php echo sanitize_hex_color("#".$custom->style->border->color);?>;
    top: <?php echo esc_html($custom->style->top);?>;
    left: <?php echo esc_html($custom->style->left);?>;
    border-radius: <?php echo absint($custom->style->border->radius);?>px;
    overflow: hidden;
}
#slider<?php echo $sliderID ;?>_container	.reslidebutton<?php echo $custom->id;?> > div {
    width: 100%;
    height: 100%;
    z-index: 2;
    position: absolute;
    top: 0px;
    left: 0px;
    opacity: <?php echo abs($custom->style->border->radius)/100;?>;
    filter: alpha(opacity=<?php echo abs($custom->style->opacity);?>);
    background: <?php echo sanitize_hex_color("#".$custom->style->background->color);?>;
}
#slider<?php echo $sliderID ;?>_container	.reslidebutton<?php echo $custom->id;?>:hover > div {
    opacity: <?php echo abs($custom->style->opacity)/100;?>;
    filter: alpha(opacity=<?php echo abs($custom->style->opacity);?>);
    background: <?php echo sanitize_hex_color("#".$custom->style->background->hover);?>;
}
#slider<?php echo $sliderID ;?>_container	.reslidebutton<?php echo $custom->id;?> .gg {
    font-size: <?php echo abs($custom->style->font->size);?>px;
    width: 100%;
    height: 100%;
    z-index: 2;
    color: <?php echo sanitize_hex_color("#".$custom->style->color);?>;
    display: block;
    position: absolute;
    text-align: center;
    top: 0;
    left: 0;
    text-decoration: none;
}
#slider<?php echo $sliderID ;?>_container	.reslidebutton<?php echo $custom->id;?> .gg span {
    width: 100%;
    display: block;
    height: auto;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    text-align: center;
    word-wrap: break-word;
    font-size: <?php echo absint($customSlide->style->font->size);?>px;
    color: <?php echo sanitize_hex_color("#".$customSlide->style->color);?>;

}

<?php
    break;
    case 'img':
?>
#slider<?php echo $sliderID ;?>_container	.reslideimg<?php echo $custom->id;?> {
    position: absolute;
    z-index: 1;
    overflow: hidden;
    width: <?php echo absint($custom->style->width);?>px;
    height: <?php echo absint($custom->style->height);?>px;
    border: <?php echo absint($custom->style->border->width);?>px solid <?php echo sanitize_hex_color("#".$custom->style->border->color);?>;
    top: <?php echo esc_html($custom->style->top);?>;
    left: <?php echo esc_html($custom->style->left);?>;
    border-radius: <?php echo absint($custom->style->border->radius);?>px;
}
#slider<?php echo $sliderID ;?>_container	.reslideimg<?php echo $custom->id;?> img {
    width: 100%;
    height: 100%;
    z-index: 0;
    opacity: <?php echo abs($custom->style->opacity)/100;?>;
    filter: alpha(opacity=<?php echo abs($custom->style->opacity);?>);
}
<?php break;default: ?>
<?php }?>
<?php
}?>

/*** navigator ***/

#slider<?php echo $sliderID ;?>_container .reslide_navigator {
    position: absolute;

}
#slider<?php echo $sliderID ;?>_container .reslide_navigator div,#slider<?php echo $sliderID ;?>_container .reslide_navigator div:hover,#slider<?php echo $sliderID ;?>_container .reslide_navigator .av {
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
#slider<?php echo $sliderID ;?>_container .reslide_navigator div { background-color: <?php echo sanitize_hex_color("#".$params->bullets->style->background->color->link);?>; }
body #slider<?php echo $sliderID ;?>_container .reslide_navigator div:hover { background-color:<?php echo sanitize_hex_color("#".$params->bullets->style->background->color->hover);?>; }
#slider<?php echo $sliderID ;?>_container  .reslide_navigator .reslide_dotav {background-color: #74B8CF !important;  border: #fff 1px solid; }
#slider<?php echo $sliderID ;?>_container  .reslide_navigator .dn,#slider<?php echo $sliderID ;?>_container .reslide_navigator .dn:hover { background-color: #555555; }

/* arrows */

#slider<?php echo $sliderID ;?>_container .reslide_arrow_left,#slider<?php echo $sliderID ;?>_container .reslide_arrow_right {
    display: block;
    position: absolute;
    /* size of arrow element */
    width:  <?php echo absint($params->arrows->style->background->width);?>px;
    height:  <?php echo absint($params->arrows->style->background->height);?>px;
    cursor: pointer;
    background-image: url(<?php echo RESLIDE_PLUGIN_PATH_FRONT_IMAGES;?>/arrows/arrows-<?php echo $params->arrows->type;?>.png);
    overflow: hidden;
    z-index: 9999;
}
#slider<?php echo $sliderID ;?>_container   .reslide_arrow_left { background-position: <?php echo esc_html($params->arrows->style->background->left);?>; }
#slider<?php echo $sliderID ;?>_container .reslide_arrow_left:hover { background-position: <?php echo esc_html($params->arrows->style->background->hover->left);?>; }
#slider<?php echo $sliderID ;?>_container .reslide_arrow_right { background-position: <?php echo esc_html($params->arrows->style->background->right);?>; }
#slider<?php echo $sliderID ;?>_container  .reslide_arrow_right:hover { background-position: <?php echo esc_html($params->arrows->style->background->hover->right);?>; }


#slider<?php echo $sliderID ;?>_container   .reslide_arrow_left.reslide_arrow_leftdn { background-position: <?php echo esc_html($params->arrows->style->background->left);?>; }
#slider<?php echo $sliderID ;?>_container  .reslide_arrow_right.reslide_arrow_leftdn { background-position: <?php echo esc_html($params->arrows->style->background->right);?>; }
/* thumbnail  */

.reslide-thumbnail<?php echo $sliderID;?> {
    position: absolute;
    /* size of thumbnail navigator container */
    height: 60px;
    width: <?php echo absint($style->width);?>px;
    z-index: 1;
}
#slider<?php echo $sliderID ;?>_container	.reslide-thumbnail<?php echo $sliderID;?> > div {
    top: 50%;
    left: 50%;
    transform: translate(-50%,-50%);
    max-width: <?php echo absint($style->width)-10;?>px;
}

#slider<?php echo $sliderID ;?>_container   .reslide-thumbnail<?php echo $sliderID;?> .p {
    position: absolute;
    top: 0;
    left: 0;
    /* max-width: 62px;*/
    height: 32px;
}

#slider<?php echo $sliderID ;?>_container   .reslide-thumbnail<?php echo $sliderID;?> .t {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
}

#slider<?php echo $sliderID ;?>_container   .reslide-thumbnail<?php echo $sliderID;?> .w,#slider<?php echo $sliderID ;?>_container .reslide-thumbnail<?php echo $sliderID;?> .pav:hover .w {
    position: absolute;
    /*  max-width: 60px;*/
    height: 30px;
    box-sizing: border-box;
    border: #0099FF 1px solid;
}

#slider<?php echo $sliderID ;?>_container   .reslide-thumbnail<?php echo $sliderID;?> .pdn .w,#slider<?php echo $sliderID ;?>_container .reslide-thumbnail<?php echo $sliderID;?> .pav .w {
    border-style: dashed;
}

#slider<?php echo $sliderID ;?>_container   .reslide-thumbnail<?php echo $sliderID;?> .c {
    position: absolute;
    top: 0;
    left: 0;
    /* max-width: 62px;*/
    height: 30px;
    background-color: #000;
    filter: alpha(opacity=45);
    opacity: .45;
    transition: opacity .6s;
    -moz-transition: opacity .6s;
    -webkit-transition: opacity .6s;
    -o-transition: opacity .6s;
}

#slider<?php echo $sliderID ;?>_container   .reslide-thumbnail<?php echo $sliderID;?> .p:hover .c,  #slider<?php echo $sliderID ;?>_container   .reslide-thumbnail<?php echo $sliderID;?> .pav .c {
    filter: alpha(opacity=0);
    opacity: 0;
}

#slider<?php echo $sliderID ;?>_container   .reslide-thumbnail<?php echo $sliderID;?> .p:hover .c {
    transition: none;
    -moz-transition: none;
    -webkit-transition: none;
    -o-transition: none;
}

* html #slider<?php echo $sliderID ;?>_container .reslide-thumbnail<?php echo $sliderID;?> .w {
    width /**/: 62px;
    height /**/: 32px;
}
</style>