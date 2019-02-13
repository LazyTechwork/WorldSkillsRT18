jQuery(function ($) {
    /*** Pro ***/

    $(document).ready(function () {
        if (jQuery('#reslide_sliders_list .id').length > 2) {
            jQuery('.add-slider').click(
                function () {
                    alert('There is a 3 sliders limit in lite version of the plugin.');
                    return false;
                }
            )
            jQuery('.duplicate-icon').click(
                function () {
                    alert('There is a 3 sliders limit in lite version of the plugin.');
                    return false;
                }
            )
        }

        function initSave() {
            jQuery('input.text').each(function () {
                var val = jQuery(this).val();
                val = val.ReslideReplaceAll('"', '&#34;');
                val = val.ReslideReplaceAll("'", '&#39;');
                val = val.ReslideReplaceAll("\\", '');
                jQuery(this).val(val);
            })
        }
        initSave();
        jQuery('#reslide_sliders_list .delete').click(function () {
            var t = confirm("You are going to permanently delete this slider...");
            if (!t)
                return false;
        });

        jQuery('.reslide-nodisplay').submit(function () {
            return false;
        });
		jQuery('#reslide_slider_images_list').on('click','.reslideitem .edit-image',function(){
			var $this = jQuery(this);
			var slideId = $this.parents('.reslideitem').attr('id');
			open_media_window.apply($this,['image',{'slide_image':slideId}]);
			return false;

		});
        $('#reslide_slider_insert_popup select').change(function () {
            var id = $(this).find('option:selected').val();
            id = parseInt(id);
            if (id) {
                add_shortcode($(this).find('option:selected').val());
                jQuery('#R-slider option:first-child').attr('selected', 'selected');
            }
        });
        jQuery('#add_image').click(open_media_window);
        jQuery('#reslide_insert_video_button').click(function () {
            add_video_popup(jQuery('#reslide_insert_video_input').val(), jQuery("#reslide_slider_images_list"));
        });

        /****    edit items ***/

        jQuery('#reslide_slider_images_list ').on('click', '.quick_edit', function () {
            var form = jQuery(this).parents('.reslideitem').find('form');
            form.toggle(218);
            return false;
        })

        jQuery('#reslide_slider_images_list form').on('click', '.quick_edit', function () {
            var form = jQuery(this).parents('.reslideitem').find('form');
            form.toggle(218);
            return false;
        })
    });

    /*** sortable ***/
	if(jQuery("#reslide_slider_images_list").length) {
		var minHeight = jQuery('#reslide_slider_images_list').height();
        if( jQuery("#reslide_slider_images_list li").length > 1 ){
            jQuery("#reslide_slider_images_list").sortable({
                start: function () {
                    jQuery('#reslide_slider_images_list').css('min-height', minHeight + 'px');
                },
                stop: function () {
                    var allSlidesCount = jQuery('.reslideitem').length, i = 0;
                    jQuery('.reslideitem').each(function () {
                        jQuery(this).find('.reslideitem-ordering').val(allSlidesCount - i);
                        i++;
                    })
                },
                revert: true
            });
        }

	}
    jQuery("body").on('click', '.popup-type', function () {
        var type = jQuery(this).attr('data');
        if (type == 'on') {    
            jQuery(this).find('img').attr('src', _IMAGES + '/light_1.png');
            jQuery(this).attr('data', 'off');
            jQuery(this).parents('.reslide-styling').removeClass('dark');
        }
        else {
            jQuery(this).find('img').attr('src', _IMAGES + '/light_2.png');
            jQuery(this).attr('data', 'on');
            jQuery(this).parents('.reslide-styling').addClass('dark');
        }

    })
});


function open_media_window() {
    var type = '', ordering = 0;
	var globalArguments = arguments;
    arguments.indexOf = [].indexOf;
    if (arguments.indexOf("image") > -1)
        type = 'reslide_image';
    var t = _reslide();
    if (this.window === undefined) {
        this.window = wp.media({
            title: 'Insert a media',
            multiple: true,
            button: {text: 'Insert'}
        });

        var self = this; // Needed to retrieve our variable in the anonymous function below
        if (!type) {
            self.window.on('select', function () {
                var attachment = self.window.state().get('selection').toJSON();
                ordering = jQuery('.reslideitem').length;
                attachment.forEach(function (item) {
                    if (item.type != 'video') {
                        ordering++;
                        jQuery('#reslide_slider_images_list').prepend(['<li class="reslideitem add">',
                            '<a class="edit" href="?page=reslider&amp;" onclick="return false;">',
                            '<img src="' + item.url + '">',
							'<span class="edit-image"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span>',							
                            '<span class="title">' + item.title + '</span>',
                            '</a>&nbsp;</b>',
                            '<form style="display:none;">',
                            '<input type = "hidden" class="reslideitem-add-title" value="' + item.title + '">',
                            '<input type = "hidden" class="reslideitem-add-url" value="' + item.url + '">',
                            '<input type = "hidden" class="reslideitem-add-type" value="">',
                            '<input type = "hidden" class="reslideitem-add-ordering" value="' + (ordering) + '">',
                            '</form>',
                            '</li>'
                        ].join(""));
                        jQuery('#reslide_slider_images_list .noimage').hide();
                    } else {
                        jQuery('#reslide_slider_images_list').prepend('<div><input class="title" name="title" hidden value="<?php echo $rows->title;?>" /><input class="description" name="description" hidden value="<?php echo $rows->description;?>" />'
                            + '<input class="type" name="description" hidden value="" /></div>' + '<li class="add-item video"><img style="display:none" src="' + item.url + '"/><a href="' + i18n_obj.editslider_link + '">'
                            + item.title + '</a><iframe  width="150" height="150" src="' + item.url + '" frameborder="0" allowfullscreen=""></iframe>&nbsp;<b>Quick Edit</b></li>');
                    }
                });
                jQuery('.reslide_save_all').click();
            });
        } else {
            var attachment = {};
            self.window = wp.media({
                title: 'Insert a media',
                multiple: false,
                button: {text: 'Insert'}
            });
            self.window.on('select', function () {
				attachment = self.window.state().get('selection').toJSON();
				if(typeof globalArguments[1] != 'object') {
					var currentimage = jQuery('#reslide-custom-stylings').attr('data');
					if (!currentimage) currentimage = 'img0';
					jQuery('#reslide_' + currentimage).attr('src', attachment[0]['url']);
					jQuery('#reslide_' + currentimage).attr('alt', attachment[0]['alt']);
					jQuery('#reslide_slider_' + currentimage + '_styling').find('#custom_src').val(attachment[0]['url']);
					jQuery('#reslide_slider_' + currentimage + '_styling').find('.reslide_content img').attr('src', attachment[0]['url']);
					jQuery('#reslide_slider_' + currentimage + '_styling').find('#custom_alt').val(attachment[0]['alt']);
					return attachment.url;
				}  else {
					jQuery('#reslide_slider_images_list #'+ globalArguments[1]['slide_image']+ ' img').attr('src',attachment[0]['url']);
					jQuery('#reslide_slider_images_list #'+ globalArguments[1]['slide_image']+ ' form .reslideitem-edit-url').val(attachment[0]['url']);	
					jQuery('.reslide_save_all').click();
				}
            });
        }
        self.window.open();
    }
    else {
        if (this.window) {
            this.window.open();
        }
    }
    return false;
}

function add_shortcode(shortcodeID) {
    wp.media.editor.insert('[R-slider id="' + shortcodeID + '"]');
}

function add_video_popup(video_url, video_append_element) {
    var showcontrols, prefix;

    function youtube_parser(url) {
        var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
        var match = url.match(regExp);
        var match_vimeo = /vimeo.*\/(\d+)/i.exec(url);
        if (match && match[7].length == 11) {
            return match[7];
        } else if (match_vimeo) {
            return match_vimeo[1];
        }
        else {
            return false;
        }
    }

    var new_video_id = youtube_parser(video_url);
    if (!new_video_id)
        return;
    if (new_video_id.length == 11) {
        showcontrols = "?modestbranding=1&showinfo=0&controls=0";
        prefix = "//www.youtube.com/embed/";
    }
    else {
        showcontrols = "?title=0&amp;byline=0&amp;portrait=0";
        prefix = "//player.vimeo.com/video/";
    }
    video_append_element.append('<div><input class="title" name="title" hidden value="<?php echo $rows->title;?>" /><input class="description" name="description" hidden value="<?php echo $rows->description;?>" />'
        + '<input class="type" name="description" hidden value="" /></div>' + '<li class="add-item video"><img style="display:none" src="' + prefix + new_video_id + showcontrols + '"/><a href="' + i18n_obj.editslider_link + '"></a><iframe  width="150" height="150" src="' + prefix + new_video_id + showcontrols + '" frameborder="0" allowfullscreen=""></iframe>&nbsp;<b>Quick Edit</b></li>');
    tb_remove();
}
function getAddedImages() {
    var slides = {};
    var i = 0;
    jQuery('.reslideitem.add form').each(function () {
        var slide = {};
        slide.title = jQuery(this).find('.reslideitem-add-title').val();
        slide.url = jQuery(this).find('.reslideitem-add-url').val();
        slide.type = jQuery(this).find('.reslideitem-add-type').val();
        slide.ordering = jQuery(this).find('.reslideitem-add-ordering').val();
        slides['slide' + i] = slide;
        i++;
    });
    if (i)
        return slides;
    return "none";
}
function getExistImagesId() {
    var ids = [];
    for (var slide in reslider.slides) {
        ids.push(reslider.slides[slide]['id']);
    }
    ids = ids.join();
    ids = "(" + ids + ")";
    return ids;
}
function getSlidesInput() {
    jQuery('#reslide_slider_images_list li.reslideitem').not('.add').each(function () {
        var id = jQuery(this).attr('id'), type, title, description, image_link, url, ordering;
        id = id.replace('reslideitem_', '');
        title = jQuery(this).find('.reslideitem-edit-title').val();
        description = jQuery(this).find('.reslideitem-edit-description').val();
        image_link = jQuery(this).find('.reslideitem-edit-image_link').val();
        ordering = jQuery(this).find('.reslideitem-ordering').val();
        url = jQuery(this).find('.reslideitem-edit-url').val();
        reslider['slides']['slide' + id]['title'] = title;
        reslider['slides']['slide' + id]['description'] = description;
        reslider['slides']['slide' + id]['image_link'] = image_link;
        reslider['slides']['slide' + id]['id'] = id;
        reslider['slides']['slide' + id]['url'] = url;
        reslider['slides']['slide' + id]['ordering'] = ordering;
    })
}
jQuery(window).load(function(){
    jQuery(".close_free_banner").on("click",function(){
        jQuery(".free_version_banner").css("display","none");
        reslideSetCookie( 'reslideFreeBannerShow', 'no', {expires:3600} );
    });
    jQuery('.close-black-friday').on('click',function () {
        jQuery(".backend-banner").css("display","none");
        reslideSetCookie( 'reSliderBlackFridayShow', 'no', {expires:345600} );
    });
    jQuery('.banner-block').on('click',function () {
        window.open('http://huge-it.com','_blank');
    });
    jQuery('.share-block >ul > li > a').on('click',function (e) {
        e.preventDefault();
        window.open(jQuery(this).attr('href'),'_blank');
    });
    
    function reslideSetCookie(name, value, options) {
        options = options || {};

        var expires = options.expires;

        if (typeof expires == "number" && expires) {
            var d = new Date();
            d.setTime(d.getTime() + expires * 1000);
            expires = options.expires = d;
        }
        if (expires && expires.toUTCString) {
            options.expires = expires.toUTCString();
        }


        if(typeof value == "object"){
            value = JSON.stringify(value);
        }
        value = encodeURIComponent(value);
        var updatedCookie = name + "=" + value;

        for (var propName in options) {
            updatedCookie += "; " + propName;
            var propValue = options[propName];
            if (propValue !== true) {
                updatedCookie += "=" + propValue;
            }
        }

        document.cookie = updatedCookie;
    }
    
});