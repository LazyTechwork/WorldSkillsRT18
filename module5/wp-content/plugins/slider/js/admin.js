function reslideOffset(elem) {
    function isWindow(obj) {
        return obj != null && obj === obj.window;
    }

    function getWindow(elem) {
        return isWindow(elem) ? elem : elem.nodeType === 9 && elem.defaultView;
    }

    var docElem, win,
        box = {top: 0, left: 0},
        doc = elem && elem.ownerDocument;

    docElem = doc.documentElement;

    if (typeof elem.getBoundingClientRect !== typeof undefined) {
        box = elem.getBoundingClientRect();
    }
    win = getWindow(doc);
    return {
        top: box.top + win.pageYOffset - docElem.clientTop,
        left: box.left + win.pageXOffset - docElem.clientLeft
    };
}
function reslideDiffer(elem1, elem2) {
    return reslideOffset(elem1).left - reslideOffset(elem2).left;
}

/**### DRAW SLIDER ###**/
function reslideDrawSlider() {
    /*** bullets ***/
    switch (reslider["params"]["bullets"]["position"]) {
        case 0:
            reslider["params"]["bullets"]["autocenter"] = 0;
            var css_bullets_obj = {
                "left": reslider["params"]["bullets"]["style"]["position"]["left"],
                "top": reslider["params"]["bullets"]["style"]["position"]["top"]
            };
            var css_bullets = "left:" + reslider["params"]["bullets"]["style"]["position"]["left"] + ";top:" + reslider["params"]["bullets"]["style"]["position"]["top"];
            break;
        case 1:
            reslider["params"]["bullets"]["autocenter"] = 1;
            var css_bullets_obj = {
                "right": "",
                "top": reslider["params"]["bullets"]["style"]["position"]["top"],
                "left": "",
                "bottom": ""
            };
            var css_bullets = "top:" + reslider["params"]["bullets"]["style"]["position"]["top"];
            break;
        case 2:
            reslider["params"]["bullets"]["autocenter"] = 0;
            var css_bullets_obj = {
                "right": reslider["params"]["bullets"]["style"]["position"]["right"],
                "top": reslider["params"]["bullets"]["style"]["position"]["top"]
            };
            var css_bullets = "right:" + reslider["params"]["bullets"]["style"]["position"]["right"] + ";top:" + reslider["params"]["bullets"]["style"]["position"]["top"];
            break;
        case 3:
            reslider["params"]["bullets"]["autocenter"] = 2;
            var css_bullets_obj = {
                "right": "",
                "top": "",
                "left": reslider["params"]["bullets"]["style"]["position"]["left"],
                "bottom": ""
            };
            var css_bullets = "left:" + reslider["params"]["bullets"]["style"]["position"]["left"];
            break;
        case 4:
            reslider["params"]["bullets"]["autocenter"] = 3;
            var css_bullets_obj = {"right": "", "top": "", "left": "", "bottom": ""};
            var css_bullets = "";
            break;
        case 5:
            reslider["params"]["bullets"]["autocenter"] = 2;
            var css_bullets_obj = {
                "right": reslider["params"]["bullets"]["style"]["position"]["right"],
                "top": "",
                "left": "",
                "bottom": ""
            };
            var css_bullets = "right:" + reslider["params"]["bullets"]["style"]["position"]["right"];
            break;
        case 6:
            reslider["params"]["bullets"]["autocenter"] = 0;
            var css_bullets_obj = {
                "left": reslider["params"]["bullets"]["style"]["position"]["left"],
                "bottom": reslider["params"]["bullets"]["style"]["position"]["bottom"]
            };
            var css_bullets = "left:" + reslider["params"]["bullets"]["style"]["position"]["left"] + ";bottom:" + reslider["params"]["bullets"]["style"]["position"]["bottom"];
            break;
        case 7:
            reslider["params"]["bullets"]["autocenter"] = 1;
            var css_bullets_obj = {
                "left": "",
                "bottom": reslider["params"]["bullets"]["style"]["position"]["bottom"],
                "right": ""
            };
            var css_bullets = "bottom:" + reslider["params"]["bullets"]["style"]["position"]["bottom"];
            break;
        case 8:
            reslider["params"]["bullets"]["autocenter"] = 0;
            var css_bullets_obj = {
                "left": "",
                "bottom": reslider["params"]["bullets"]["style"]["position"]["bottom"],
                "right": reslider["params"]["bullets"]["style"]["position"]["right"]
            };
            var css_bullets = "bottom:" + reslider["params"]["bullets"]["style"]["position"]["bottom"] + ";right:" + reslider["params"]["bullets"]["style"]["position"]["right"];
            break;
    }

    switch (reslider["params"]["effect"]["type"]) {
        case 0:
            var reslide_effect = {
                $Duration: reslider["params"]["effect"]["duration"],
                $Opacity: 2,
                $Brother: {$Duration: 1000, $Opacity: 2}
            };
            break;
        case 1:
            reslide_effect = {
                $Duration: reslider["params"]["effect"]["duration"],
                x: -0.3,
                y: 0.5,
                $Zoom: 1,
                $Rotate: 0.1,
                $During: {$Left: [0.6, 0.4], $Top: [0.6, 0.4], $Rotate: [0.6, 0.4], $Zoom: [0.6, 0.4]},
                $Easing: {
                    $Left: $JssorEasing$.$EaseInQuad,
                    $Top: $JssorEasing$.$EaseInQuad,
                    $Opacity: $JssorEasing$.$EaseLinear,
                    $Rotate: $JssorEasing$.$EaseInQuad
                },
                $Opacity: 2,
                $Brother: {
                    $Duration: 1000,
                    $Zoom: 11,
                    $Rotate: -0.5,
                    $Easing: {$Opacity: $JssorEasing$.$EaseLinear, $Rotate: $JssorEasing$.$EaseInQuad},
                    $Opacity: 2,
                    $Shift: 200
                }
            };
            break;
        case 2:
            reslide_effect = {
                $Duration: reslider["params"]["effect"]["duration"],
                x: 0.25,
                $Zoom: 1.5,
                $Easing: {$Left: $JssorEasing$.$EaseInWave, $Zoom: $JssorEasing$.$EaseInSine},
                $Opacity: 2,
                $ZIndex: -10,
                $Brother: {
                    $Duration: 1400,
                    x: -0.25,
                    $Zoom: 1.5,
                    $Easing: {$Left: $JssorEasing$.$EaseInWave, $Zoom: $JssorEasing$.$EaseInSine},
                    $Opacity: 2,
                    $ZIndex: -10
                }
            }
            break;
        case 3:
            reslide_effect = {
                $Duration: reslider["params"]["effect"]["duration"],
                x: 0.5,
                $Cols: 2,
                $ChessMode: {$Column: 3},
                $Easing: {$Left: $JssorEasing$.$EaseInOutCubic},
                $Opacity: 2,
                $Brother: {$Duration: 1500, $Opacity: 2}
            }
            break;
        case 4:
            reslide_effect = {
                $Duration: reslider["params"]["effect"]["duration"],
                x: -0.1,
                y: -0.7,
                $Rotate: 0.1,
                $During: {$Left: [0.6, 0.4], $Top: [0.6, 0.4], $Rotate: [0.6, 0.4]},
                $Easing: {
                    $Left: $JssorEasing$.$EaseInQuad,
                    $Top: $JssorEasing$.$EaseInQuad,
                    $Opacity: $JssorEasing$.$EaseLinear,
                    $Rotate: $JssorEasing$.$EaseInQuad
                },
                $Opacity: 2,
                $Brother: {
                    $Duration: 1000,
                    x: 0.2,
                    y: 0.5,
                    $Rotate: -0.1,
                    $Easing: {
                        $Left: $JssorEasing$.$EaseInQuad,
                        $Top: $JssorEasing$.$EaseInQuad,
                        $Opacity: $JssorEasing$.$EaseLinear,
                        $Rotate: $JssorEasing$.$EaseInQuad
                    },
                    $Opacity: 2
                }
            }
            break;
        case 5:
            reslide_effect = {
                $Duration: reslider["params"]["effect"]["duration"],
                x: -1,
                y: -0.5,
                $Delay: 50,
                $Cols: 8,
                $Rows: 4,
                $Formation: $JssorSlideshowFormations$.$FormationSquare,
                $Easing: {$Left: $JssorEasing$.$EaseSwing, $Top: $JssorEasing$.$EaseInJump},
                $Assembly: 260,
                $Round: {$Top: 1.5}
            }
            break;
        case 6:
            reslide_effect = {
                $Duration: reslider["params"]["effect"]["duration"],
                $Delay: 30,
                $Cols: 8,
                $Rows: 4,
                $Clip: 15,
                $SlideOut: true,
                $Formation: $JssorSlideshowFormations$.$FormationStraightStairs,
                $Easing: $JssorEasing$.$EaseOutQuad,
                $Assembly: 2049
            }
            break;
    }

    var _SlideshowTransitions = [
        reslide_effect
    ];
    if (!reslider['params']['thumbnails']['positioning'])
        var thumbnailsCount = Math.ceil(reslider.count - 1);
    else {
        var thumbnailsCount = Math.ceil(reslider.count)
    }
    var options = {
        $AutoPlay: (reslider["params"]["autoplay"] == 1) ? true : false,                                   //[Optional] Whether to auto play, to enable slideshow, this option must be set to true, default value is false
        $SlideDuration: 500,
        $PauseOnHover: reslider["params"]["pauseonhover"],
        $AutoPlayInterval: reslider["params"]["effect"]["interval"],                               //[Optional] Specifies default duration (swipe) for slide in milliseconds, default value is 500

        $BulletNavigatorOptions: {                                //[Optional] Options to specify and enable navigator or not
            $Class: $JssorBulletNavigator$,                       //[Required] Class to create navigator instance
            $ChanceToShow: reslider["params"]["bullets"]["show"],                               //[Required] 0 Never, 1 Mouse Over, 2 Always
            $AutoCenter: reslider["params"]["bullets"]["autocenter"],                                 //[Optional] Auto center navigator in parent container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
            $Steps: 1,                                      //[Optional] Steps to go for each navigation request, default value is 1
            $Rows: reslider["params"]["bullets"]["rows"],                                      //[Optional] Specify lanes to arrange items, default value is 1
            $SpacingX: reslider["params"]["bullets"]["s_x"],                                  //[Optional] Horizontal space between each item in pixel, default value is 0
            $SpacingY: reslider["params"]["bullets"]["s_y"],                                  //[Optional] Vertical space between each item in pixel, default value is 0
            $Orientation: reslider["params"]["bullets"]["orientation"]                                //[Optional] The orientation of the navigator, 1 horizontal, 2 vertical, default value is 1
        },
        $ArrowNavigatorOptions: {                       //[Optional] Options to specify and enable arrow navigator or not
            $Class: $JssorArrowNavigator$,              //[Requried] Class to create arrow navigator instance
            $ChanceToShow: reslider["params"]["arrows"]["show"],                               //[Required] 0 Never, 1 Mouse Over, 2 Always
            $AutoCenter: 2,                                 //[Optional] Auto center arrows in parent container, 0 No, 1 Horizontal, 2 Vertical, 3 Both, default value is 0
            $Steps: 1                                       //[Optional] Steps to go for each navigation request, default value is 1
        },
        $SlideshowOptions: {                                //[Optional] Options to specify and enable slideshow or not
            $Class: $JssorSlideshowRunner$,                 //[Required] Class to create instance of slideshow
            $Transitions: _SlideshowTransitions,            //[Required] An array of slideshow transitions to play slideshow
            $TransitionsOrder: 1,                           //[Optional] The way to choose transition to play slide, 1 Sequence, 0 Random
            $ShowLink: true                                    //[Optional] Whether to bring slide link on top of the slider when slideshow is running, default value is false
        },
        $ThumbnailNavigatorOptions: {
            $Class: $JssorThumbnailNavigator$,              //[Required] Class to create thumbnail navigator instance
            $ChanceToShow: reslider["params"]["thumbnails"]["show"],                               //[Required] 0 Never, 1 Mouse Over, 2 Always
            $ActionMode: 1,                                 //[Optional] 0 None, 1 act by click, 2 act by mouse hover, 3 both, default value is 1
            $AutoCenter: 0,                                 //[Optional] Auto center thumbnail items in the thumbnail navigator container, 0 None, 1 Horizontal, 2 Vertical, 3 Both, default value is 3
            $Rows: 1,                                      //[Optional] Specify lanes to arrange thumbnails, default value is 1
            $SpacingX: 3,                                   //[Optional] Horizontal space between each thumbnail in pixel, default value is 0
            $SpacingY: 3,                                   //[Optional] Vertical space between each thumbnail in pixel, default value is 0
            $Cols: thumbnailsCount,                              //[Optional] Number of pieces to display, default value is 1
            $ParkingPosition: 0,                          //[Optional] The offset position to park thumbnail
            $Orientation: 1,                                //[Optional] Orientation to arrange thumbnails, 1 horizental, 2 vertical, default value is 1
            $NoDrag: false                            //[Optional] Disable drag or not, default value is false
        }

    };

    setTimeout(function () {
        var maincontent = _reslide();
        maincontent.id = ReslideGenerateId();
        maincontent.style.position = "relative";
        maincontent.style.top = "0px";
        maincontent.style.left = "0px";
        maincontent.style.width = reslider["style"]["width"] + 'px';
        maincontent.style.height = reslider["style"]["height"] + 'px';
        _reslide(maincontent).addClass('reslide_slider_container_preview');
        var content = _reslide(maincontent);

        var loading_content = _reslide();
        loading_content.addAttr('u', 'loading').addStyle("position: absolute; top: 0px; left: 0px;");
        var load_content_child = _reslide().addStyle("position:fixed;top:0;left: 0;height: 100%;width: 100%;background: red;");
        loading_content.append(load_content_child);


        var slidescontent = _reslide();
        slidescontent.addAttr('u', 'slides').addClass('reslide_slider_preview').addStyle('cursor: move; position: absolute; overflow: hidden; left: 0px; top: 0px; width: ' + reslider["style"]["width"] + 'px; height: ' + reslider["style"]["height"] + 'px;');
        var slides = "";

        for (slide in reslider["slides"]) {
            if (!reslider["slides"][slide]['published']) continue;
            reslider["slides"][slide]["title"] = reslider["slides"][slide]["title"].ReslideReplaceAll('&quot;', '"');
            reslider["slides"][slide]["description"] = reslider["slides"][slide]["description"].ReslideReplaceAll('&quot;', '"');
            reslider["slides"][slide]["image_link"] = reslider["slides"][slide]["image_link"].ReslideReplaceAll('&quot;', '"');
            if (reslider["slides"][slide] ["type"] != 'video') {
                var item = _reslide();
                item.addClass('reslideitem');
                item.id = slide;
                var itemimg = _reslide('img');
                var itemThumbnail = _reslide('img');
                itemimg.addStyle('width: 100%;height:100%').addAttr('src', reslider["slides"][slide]["url"]);
                itemThumbnail.addAttr('src', reslider["slides"][slide]["url"], 'u', 'thumb');
                /*** title ***/

                var itemtitle = _reslide();
                itemtitle.addClass('reslidetitle').addStyle("position:absolute;overflow:hidden;z-index:1;width:" + parseFloat(reslider["params"]["title"]["style"]["width"]) + "px;height:" + parseFloat(reslider["params"]["title"]["style"]["height"])
                    + "px;border:" + reslider["params"]["title"]["style"]["border"]["width"] + "px solid #" +
                    reslider["params"]["title"]["style"]["border"]["color"] + ";top:" +
                    reslider["params"]["title"]["style"]["top"] + ";left:" + reslider["params"]["title"]["style"]["left"] + ";border-radius:" +
                    reslider["params"]["title"]["style"]["border"]["radius"] + "px;font-size:" +
                    reslider["params"]["title"]["style"]["font"]["size"] + "px;color:#" +
                    reslider["params"]["title"]["style"]["color"]);

                var innerTitleCover = _reslide();
                innerTitleCover.addStyle("position:absolute;left:0;top:0;width:" + parseFloat(reslider["params"]["title"]["style"]["width"]) + "px;height:" + parseFloat(reslider["params"]["title"]["style"]["height"]) + "px;opacity:" + reslider["params"]["title"]["style"]["opacity"] / 100 + ";background: #" +
                    reslider["params"]["title"]["style"]["background"]["color"] + ";font-size:" +
                    reslider["params"]["title"]["style"]["font"]["size"] + "px;color:#" +
                    reslider["params"]["title"]["style"]["color"]);

                var h3 = _reslide('span');
                var t = document.createTextNode(reslider["slides"][slide]["title"].ReslideReplaceAll('&quot;', '"'));
                h3.append(t);
                itemtitle.append(innerTitleCover);
                itemtitle.append(h3);

                /*** description ***/

                var itemdescription = _reslide();
                itemdescription.addClass('reslidedescription').addStyle("position:absolute;z-index:1;overflow:hidden;width:" + parseFloat(reslider["params"]["description"]["style"]["width"]) + "px;height:" + parseFloat(reslider["params"]["description"]["style"]["height"])
                    + "px;border:" + reslider["params"]["description"]["style"]["border"]["width"] + "px solid #" +
                    reslider["params"]["description"]["style"]["border"]["color"] + ";top:" +
                    reslider["params"]["description"]["style"]["top"] + ";left:" + reslider["params"]["description"]["style"]["left"] + ";border-radius:" +
                    reslider["params"]["description"]["style"]["border"]["radius"] + "px;font-size:" +
                    reslider["params"]["description"]["style"]["font"]["size"] + "px;color:#" +
                    reslider["params"]["description"]["style"]["color"]);

                var innerdescriptionCover = _reslide();
                innerdescriptionCover.addStyle("position:absolute;left:0;top:0;width:" + parseFloat(reslider["params"]["description"]["style"]["width"]) + "px;height:" + parseFloat(reslider["params"]["description"]["style"]["height"]) + "px;opacity:" + reslider["params"]["description"]["style"]["opacity"] / 100 + ";background: #" +
                    reslider["params"]["description"]["style"]["background"]["color"] + ";font-size:" +
                    reslider["params"]["description"]["style"]["font"]["size"] + "px;color:#" +
                    reslider["params"]["description"]["style"]["color"]);

                var h3 = _reslide('span');
                var t = document.createTextNode(reslider["slides"][slide]["description"]);
                h3.append(t);
                itemdescription.append(innerdescriptionCover);
                itemdescription.append(h3);
                item.append(itemimg);
                item.append(itemThumbnail);
                (reslider["params"]["description"]['show'] && reslider["slides"][slide]["description"]) && (item.append(itemdescription));
                (reslider["params"]["title"]['show'] && reslider["slides"][slide]["title"]) && (item.append(itemtitle));

                /*** slide's custom elements ***/
                for (var slidecustom in reslider["slides"][slide]['custom']) {

                    if (reslider["slides"][slide]['custom'][slidecustom]["text"]) {
                        //	alert(reslider["slides"][slide]['custom'][slidecustom]["text"]);
                        reslider["slides"][slide]['custom'][slidecustom]["text"] = reslider["slides"][slide]['custom'][slidecustom]["text"].ReslideReplaceAll('&#34;', '"');
                        reslider["slides"][slide]['custom'][slidecustom]["text"] = reslider["slides"][slide]['custom'][slidecustom]["text"].ReslideReplaceAll('&#39;', "'");
                    }
                    if (reslider["slides"][slide]['custom'][slidecustom]['type'] == 'button') {
                        var staticElement = _reslide(reslider["slides"][slide]['custom'][slidecustom]['type']);
                        staticElement.addAttr('u', 'any').addClass('reslidebutton').addStyle("background:none;padding:0;z-index:2;position:absolute;outline:none;overflow:hidden;width:" + parseFloat(reslider["slides"][slide]['custom'][slidecustom]["style"]["width"]) + "px;height:" + parseFloat(reslider["slides"][slide]['custom'][slidecustom]["style"]["height"])
                            + "px;border:" + reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["width"] + "px solid #" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["color"] + ";top:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["top"] + ";left:" + reslider["slides"][slide]['custom'][slidecustom]["style"]["left"] + ";border-radius:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["radius"] + "px;font-size:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["font"]["size"] + "px;color:#" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["color"]);
                        var innerStaticCover = _reslide();
                        innerStaticCover.addStyle('width: 100%;height: 100%;z-index:2;display:block;position:absolute;top:0;left:0;opacity:' + reslider["slides"][slide]['custom'][slidecustom]["style"]["opacity"] / 100 + ';background: #' +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["background"]["color"] + ";font-size:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["font"]["size"] + "px;color:#" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["color"]);
                        var innerStatic = _reslide('span');
                        innerStatic.addStyle('width: 100%;height: auto;z-index:2;display:block;position:absolute;text-align:center;top:50%;left:50%;transform: translate(-50%,-50%);');
                        innerStatic.addClass('gg');
                        var t = document.createTextNode(reslider["slides"][slide]['custom'][slidecustom]["text"]);
                        innerStatic.append(t);
                        staticElement.append(innerStaticCover);
                        staticElement.append(innerStatic);
                        item.append(staticElement);

                    }
                    else if (reslider["slides"][slide]['custom'][slidecustom]['type'] == 'img') {
                        var staticElement = _reslide();
                        staticElement.addAttr('u', 'any').addClass('reslideimg').addStyle("position:absolute;z-index:1;width:" + parseFloat(reslider["slides"][slide]['custom'][slidecustom]["style"]["width"]) + "px;height:" + parseFloat(reslider["slides"][slide]['custom'][slidecustom]["style"]["height"])
                            + "px;border:" + reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["width"] + "px solid #" + reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["color"] + ";top:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["top"] + ";left:" + reslider["slides"][slide]['custom'][slidecustom]["style"]["left"] + ";border-radius:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["radius"] + "px;");
                        var t = _reslide('img');
                        t.addStyle('width:100%;height:100%;z-index:0;display:block;opacity:' + reslider["slides"][slide]['custom'][slidecustom]["style"]["opacity"] / 100);
                        t.addAttr('src', reslider["slides"][slide]['custom'][slidecustom]['src']);
                        t.addAttr('alt', reslider["slides"][slide]['custom'][slidecustom]['alt']);
                        staticElement.append(t);
                        item.append(staticElement);
                    }
                    else if (reslider["slides"][slide]['custom'][slidecustom]['type'] == 'h3') {
                        var staticElement = _reslide(reslider["slides"][slide]['custom'][slidecustom]['type']);
                        staticElement.addAttr('u', 'any').addClass('reslideh3').addStyle("margin:0;padding:0;z-index:2;word-wrap: break-word;position:absolute;width:" + parseFloat(reslider["slides"][slide]['custom'][slidecustom]["style"]["width"]) + "px;height:" + parseFloat(reslider["slides"][slide]['custom'][slidecustom]["style"]["height"])
                            + "px;border:" + reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["width"] + "px solid #" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["color"] + ";top:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["top"] + ";left:" + reslider["slides"][slide]['custom'][slidecustom]["style"]["left"] + ";border-radius:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["radius"] + "px;font-size:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["font"]["size"] + "px;color:#" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["color"]);
                        var innerStaticCover = _reslide();
                        innerStaticCover.addStyle('width: 100%;height: 100%;display:block;z-index:2;absolute;top:0;left:0;opacity:' + reslider["slides"][slide]['custom'][slidecustom]["style"]["opacity"] / 100 + ';background: #' +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["background"]["color"] + ";border-radius:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["border"]["radius"] + "px;font-size:" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["font"]["size"] + "px;color:#" +
                            reslider["slides"][slide]['custom'][slidecustom]["style"]["color"]);
                        var innerStatic = _reslide('span');
                        innerStatic.addStyle('width: 100%;height: 100%;display:block;position:absolute;text-align:center;top:0;left:0;line-height: 1.5;');
                        innerStatic.addClass('gg');
                        var t = document.createTextNode(reslider["slides"][slide]['custom'][slidecustom]["text"]);
                        innerStatic.append(t);
                        staticElement.append(innerStaticCover);
                        staticElement.append(innerStatic);
                        item.append(staticElement);
                    }
                }
                slidescontent.append(item);
                slidescontent.append(item);


            }
            else {
                var item = _reslide();
                item.addClass('reslideitem');
                item.id = slide;
                var itemiframe = _reslide('iframe');
                itemiframe.addStyle("width: 100%;height: 100%;").addAttr('src', reslider["slides"][slide]["url"], 'frameborder', "0", 'allowfullscreen', "");
                var itemtitle = _reslide();
                itemtitle.addClass('reslidetitle').addStyle("position:absolute;z-index:1;width:" + reslider["params"]["title"]["style"]["width"] + ";height:" + reslider["params"]["title"]["style"]["height"]
                    + ";border:" + reslider["params"]["title"]["style"]["border"]["width"] + "px solid #" +
                    reslider["params"]["title"]["style"]["border"]["color"] + ";background: #" +
                    reslider["params"]["title"]["style"]["background"]["color"] + ";top:" +
                    reslider["params"]["title"]["style"]["top"] + ";left:" + reslider["params"]["title"]["style"]["left"] + ";border-radius:" +
                    reslider["params"]["title"]["style"]["border"]["radius"] + "px;font-size:" +
                    reslider["params"]["title"]["style"]["font"]["size"] + "px;color:#" +
                    reslider["params"]["title"]["style"]["color"]);
                var h3 = _reslide('h3');
                var t = document.createTextNode(reslider["slides"][slide]["title"]);
                h3.append(t);
                itemtitle.append(h3);
                item.append(itemiframe).append(itemtitle);
                //ass.push(item);
                slidescontent.append(item);

            }
        }

        /****# Static element #****/
        var i = 0;
        for (var custom in reslider['custom']) {
            if (reslider["custom"][custom]["text"]) {
                //alert(reslider["custom"][custom]["text"]);
                reslider["custom"][custom]["text"] = reslider["custom"][custom]["text"].ReslideReplaceAll('&#34;', '"');
                reslider["custom"][custom]["text"] = reslider["custom"][custom]["text"].ReslideReplaceAll('&#39;', "'");
            }
            i++;
            //console.log('CCC',reslider['custom'][custom]['type']);
            if (reslider['custom'][custom]['type'] == 'button') {
                var staticElement = _reslide(reslider['custom'][custom]['type']);
                staticElement.addAttr('u', 'any').addClass('reslidebutton').addStyle("background:none;padding:0;z-index:2;overflow:hidden;outline:none;position:absolute;width:" + parseFloat(reslider["custom"][custom]["style"]["width"]) + "px;height:" + parseFloat(reslider["custom"][custom]["style"]["height"])
                    + "px;border:" + reslider["custom"][custom]["style"]["border"]["width"] + "px solid #" +
                    reslider["custom"][custom]["style"]["border"]["color"] + ";top:" +
                    reslider["custom"][custom]["style"]["top"] + ";left:" + reslider["custom"][custom]["style"]["left"] + ";border-radius:" +
                    reslider["custom"][custom]["style"]["border"]["radius"] + "px;font-size:" +
                    reslider["custom"][custom]["style"]["font"]["size"] + "px;color:#" +
                    reslider["custom"][custom]["style"]["color"]);
                var innerStaticCover = _reslide();
                innerStaticCover.addStyle('width: 100%;height: 100%;z-index:2;display:block;position:absolute;top:0;left:0;opacity:' + reslider["custom"][custom]["style"]["opacity"] / 100 + ';background: #' +
                    reslider["custom"][custom]["style"]["background"]["color"] + ";font-size:" +
                    reslider["custom"][custom]["style"]["font"]["size"] + "px;color:#" +
                    reslider["custom"][custom]["style"]["color"]);
                var innerStatic = _reslide('span');
                innerStatic.addStyle('width: 100%;height: auto;z-index:2;display:block;position:absolute;text-align:center;top:50%;left:50%;transform: translate(-50%,-50%);');
                innerStatic.addClass('gg');
                var t = document.createTextNode(reslider["custom"][custom]["text"]);
                innerStatic.append(t);
                staticElement.append(innerStaticCover);
                staticElement.append(innerStatic);
                slidescontent.append(staticElement);

            }
            else if (reslider['custom'][custom]['type'] == 'img') {
                var staticElement = _reslide();
                staticElement.addAttr('u', 'any').addClass('reslideimg').addStyle("position:absolute;z-index:1;width:" + parseFloat(reslider["custom"][custom]["style"]["width"]) + "px;height:" + parseFloat(reslider["custom"][custom]["style"]["height"])
                    + "px;border:" + reslider["custom"][custom]["style"]["border"]["width"] + "px solid #" + reslider["custom"][custom]["style"]["border"]["color"] + ";top:" +
                    reslider["custom"][custom]["style"]["top"] + ";left:" + reslider["custom"][custom]["style"]["left"] + ";border-radius:" +
                    reslider["custom"][custom]["style"]["border"]["radius"] + "px;");
                var t = _reslide('img');
                t.addStyle('width:100%;height:100%;z-index:0;display:block;opacity:' + reslider["custom"][custom]["style"]["opacity"] / 100);
                t.addAttr('src', reslider['custom'][custom]['src']);
                t.addAttr('alt', reslider['custom'][custom]['alt']);
                staticElement.append(t);
                slidescontent.append(staticElement);
            }
            else if (reslider['custom'][custom]['type'] == 'h3') {
                var staticElement = _reslide(reslider['custom'][custom]['type']);
                staticElement.addAttr('u', 'any').addClass('reslideh3').addStyle("margin:0;padding:0;z-index:2;word-wrap: break-word;position:absolute;width:" + parseFloat(reslider["custom"][custom]["style"]["width"]) + "px;height:" + parseFloat(reslider["custom"][custom]["style"]["height"])
                    + "px;border:" + reslider["custom"][custom]["style"]["border"]["width"] + "px solid #" +
                    reslider["custom"][custom]["style"]["border"]["color"] + ";top:" +
                    reslider["custom"][custom]["style"]["top"] + ";left:" + reslider["custom"][custom]["style"]["left"] + ";border-radius:" +
                    reslider["custom"][custom]["style"]["border"]["radius"] + "px;font-size:" +
                    reslider["custom"][custom]["style"]["font"]["size"] + "px;color:#" +
                    reslider["custom"][custom]["style"]["color"]);
                var innerStaticCover = _reslide();
                innerStaticCover.addStyle('width: 100%;height: 100%;display:block;z-index:2;absolute;top:0;left:0;opacity:' + reslider["custom"][custom]["style"]["opacity"] / 100 + ';background: #' +
                    reslider["custom"][custom]["style"]["background"]["color"] + ";border-radius:" +
                    reslider["custom"][custom]["style"]["border"]["radius"] + "px;font-size:" +
                    reslider["custom"][custom]["style"]["font"]["size"] + "px;color:#" +
                    reslider["custom"][custom]["style"]["color"]);
                var innerStatic = _reslide('span');
                innerStatic.addStyle('width: 100%;height: 100%;display:block;position:absolute;text-align:center;top:0;left:0;line-height: 1.5;');
                innerStatic.addClass('gg');
                var t = document.createTextNode(reslider["custom"][custom]["text"]);
                innerStatic.append(t);
                staticElement.append(innerStaticCover);
                staticElement.append(innerStatic);
                slidescontent.append(staticElement);
            }
        }

        /*****### Navigator ###****/
        var nav = _reslide();
        nav.addAttr('u', 'navigator').addClass('reslide_bullets').addStyle('bottom: 16px; right: 10px;');
        var bullet_container = _reslide();
        bullet_container.addAttr('u', 'prototype').addClass('bullet');
        var arrowleft = _reslide('span');
        arrowleft.addAttr('u', 'arrowleft').addClass('reslide_arrow_left').addStyle('top: 123px; left: 8px;width:' + reslider["params"]["arrows"]["style"]["background"]["width"] + 'px;height:' +
            reslider["params"]["arrows"]["style"]["background"]["height"] + 'px;background-position:' + reslider["params"]["arrows"]["style"]["background"]["left"]
        );
        arrowleft.style.backgroundImage = "url(" + FRONT_IMAGES + '/arrows/arrows-' + reslider["params"]["arrows"]["type"] + ".png)";


        var arrowright = _reslide('span');

        arrowright.addAttr('u', 'arrowright').addClass('reslide_arrow_right').addStyle('top: 123px; right: 8px;width:' + reslider["params"]["arrows"]["style"]["background"]["width"] + 'px;height:' +
            reslider["params"]["arrows"]["style"]["background"]["height"] + 'px;background-position:' + reslider["params"]["arrows"]["style"]["background"]["right"]
        );
        arrowright.style.backgroundImage = "url(" + FRONT_IMAGES + '/arrows/arrows-' + reslider["params"]["arrows"]["type"] + ".png)";
        nav.append(bullet_container);


        content.append(loading_content);
        content.append(slidescontent);
        content.append(nav);
        content.append(arrowleft);
        content.append(arrowright);


        var thumbContainer = _reslide.html('<div u="thumbnavigator" class="reslide-thumbnail" style="right: 0px; bottom: 0px;">' +
            '  		 <div u="slides" style="bottom: 25px;  cursor: default;">' +
            '  	 <div u="prototype" class="p"> <div class=w><div u="thumbnailtemplate" class="t"></div></div> <div class=c></div></div> </div> </div>');
        content.append(thumbContainer[0]);

        _reslide._('#reslide_slider_preview').append(content);

        if (reslider.count) {
            jQuery('.reslide-thumbnail').width(reslider.style.width);
            jQuery('.reslide-thumbnail > div').css('max-width', reslider.style.width - 40);
            jQuery('.reslide-thumbnail > div').width(reslider.style.width - 40);
            var thubmnailCWidth = jQuery('.reslide-thumbnail > div').width();
            var thumbWidth = thubmnailCWidth / reslider.count;
            if (reslider['params']['thumbnails']['positioning']) {
                jQuery('.reslide-thumbnail .c,.reslide-thumbnail .p,.reslide-thumbnail .w').width(thumbWidth - 4);

            }
            else {
                jQuery('.reslide-thumbnail .c,.reslide-thumbnail .p,.reslide-thumbnail .w').width(58);
                jQuery('.reslide-thumbnail .w').width(56);
                jQuery('.reslide-thumbnail > div').css('max-width', (jQuery('.reslide-thumbnail').width() - 20) + 'px');//width(58);
                var walk = jQuery('.reslide-thumbnail').width() - 20;
                var walkcount = Math.floor(walk / 61);
                walk = walkcount * 61 - 3;
                jQuery('.reslide-thumbnail > div').css('max-width', walk + 'px');
            }
        }

        _reslide.find('#reslide_slider_preview', '.reslide_bullets')[0].addStyle(css_bullets);
        _reslide.find('#reslide_slider_preview', '.reslide_bullets .bullet')[0].addStyle("background:#" + reslider["params"]["bullets"]["style"]["background"]["color"]["link"]);

        new $JssorSlider$(maincontent.id, options);
        _reslide.each('#reslide_slider_preview .reslide_bullets .bullet', function (e) {
            this.addEventListener('mouseenter', function (e) {
                e = e || window.event;
                $this = e.target;
                _reslide($this).addStyle("background:#" + reslider["params"]["bullets"]["style"]["background"]["color"]["hover"]);
            });
            this.addEventListener('mouseleave', function (e) {
                e = e || window.event;
                $this = e.target;
                _reslide($this).addStyle("background:#" + reslider["params"]["bullets"]["style"]["background"]["color"]["link"]);
            });
        });

        reslidePopupPreview.show();

    }, 0);
}

/**###POPUPS###**/
function reslidePopups(overlay, popup) {
    var overlay = overlay;
    var popup = popup;

    this.show = function () {
        document.getElementById(overlay) && (document.getElementById(overlay).style.display = 'block');
        document.getElementById(popup) && (document.getElementById(popup).style.display = 'block');
    }
    this.hide = function () {
        document.getElementById(overlay) && (document.getElementById(overlay).style.display = 'none');
        document.getElementById(popup) && (document.getElementById(popup).style.display = 'none');
    };
}

var reslidePopupPreview = new reslidePopups('reslide_slider_preview_popup', 'reslide_slider_preview');
var reslidePopupTitle = new reslidePopups('reslide_slider_preview_popup', 'reslide_slider_title_styling');
var reslidePopupDescription = new reslidePopups('reslide_slider_preview_popup', 'reslide_slider_description_styling');
var reslidePopupCustom;

/*** create slidinf custom popups ***/
function reslideCreateStylingPopup(custom, customid) {
    var wrapper = _reslide();
    wrapper.id = 'reslide_slider_' + customid + '_styling';
    wrapper.addClass('reslide-styling', 'reslide-custom-styling', 'main-content');
    var form = _reslide('form');
    form.id = 'reslide-' + custom + '-styling';
    form.addClass('custom');
    var close = _reslide.html('<div class="reslide_close"><i class="fa fa-remove" aria-hidden="true"></i></div>');
    var popup_style = _reslide.html('<span class="popup-type" data="off"><img src="' + _IMAGES + '/light_1.png"></span>');
    if (custom == "button") {
        var content = [
            '<input  type="hidden" name="custom[' + customid + ']" rel="0" value="{}" >',
            '<input  type="hidden" name="custom[' + customid + '][id]" rel="0" value="' + customid.replace(custom, '') + '" >',
            '<input  type="hidden" name="custom[' + customid + '][type]" rel="0" value="button" >',
            '<input  type="hidden" class="text" name="custom[' + customid + '][text]" rel="0" value="Button ' + customid.replace(custom, '') + '" >',
            '<span class="size">',
            '<label>Button url:</label>',
            '<input   class="link" name="custom[' + customid + '][link]" rel="0" value="#" >',
            '</span>',
            '<input  type="hidden" name="custom[' + customid + '][style]" rel="0" value="{}" >',
            '<input  type="hidden" class="width" name="custom[' + customid + '][style][width]" rel="0" value="100" >',
            '<input  type="hidden" class="height" name="custom[' + customid + '][style][height]" rel="0" value="50" >',
            '<input  type="hidden" class="top" name="custom[' + customid + '][style][top]" rel="0" value="0px" >',
            '<input  type="hidden" class="left" name="custom[' + customid + '][style][left]" rel="0" value="0px" >',
            '<input  type="hidden"  name="custom[' + customid + '][style][background]" rel="0" value="{}" >',
            '<input  type="hidden"  name="custom[' + customid + '][style][border]" rel="0" value="{}" >',
            '<input  type="hidden"  name="custom[' + customid + '][style][font]" rel="0" value="{}" >',
            '<span class="color">',
            '<label for="custom-background-color-link">Background Color:</label>',
            '<input  type="text" class="jscolor" id="custom-bullets-background-color-link"  name="custom[' + customid + '][style][background][color]" rel="#" value="1EBD27" >',
            '</span>',
            '<span class="color">',
            '<label for="custom-background-color-hover">Hover Color:</label>',
            '<input  type="text" class="jscolor" id="custom-bullets-background-color-hover" name="custom[' + customid + '][style][background][hover]" rel="#" value="0FE923" >',
            '</span>',
            '<span class="size">',
            '<label for="custom-background-opacity">Opacity:</label>',
            '<input  type="number"  id="custom-background-opacity" name="custom[' + customid + '][style][opacity]" rel="0" value="100" >%',
            '</span>',
            '<span class="size">',
            '<label for="custom-border-size">Border Width:</label>',
            '<input  type="number"  id="custom-border-width" name="custom[' + customid + '][style][border][width]" rel="px" value="2" >',
            '</span>',
            '<span class="color">',
            '<label for="custom-border-color">Border Color:</label>',
            '<input  type="text" class="jscolor"  id="custom-custom-border-color" name="custom[' + customid + '][style][border][color]" rel="#" value="18902F" >',
            '</span>',
            '<span class="size">',
            '<label for="custom-background-radius">Border Radius:</label>',
            '<input  type="number"   id="custom-custom-border-radius" name="custom[' + customid + '][style][border][radius]" rel="px" value="2" >',
            '</span>',
            '<span class="size">',
            '<label for="custom-font-size">Font Size:</label>',
            '<input  type="number"   id="custom-font-size" name="custom[' + customid + '][style][font][size]" rel="px" value="14" >',
            '</span>',
            '<span class="color">',
            '<label for="custom-custom-font-color">Font Color:</label>',
            '<input  type="text" class="jscolor"  id="custom-custom-font-color" name="custom[' + customid + '][style][color]" rel="#" value="FFFFFF" >',
            '</span>'
        ].join("");
        var divc = _reslide.html('<div class="reslide_content"></div>');
        divc[0].innerHTML = '<div class="reslide_' + custom + ' reslide_custom"><div class="reslide_custom_child"></div><span class="btn">CHECK NOW!</span></div>';

    }
    else if (custom == 'iframe') {
        content = [
            '<input  type="hidden" id="custom_src" name="custom[' + customid + '][src]" rel="0" value="" >',
            '<input  type="hidden" name="custom[' + customid + ']" rel="0" value="{}" >',
            '<input  type="hidden" name="custom[' + customid + '][style]" rel="0" value="{}" >',
            '<input  type="hidden" name="custom[' + customid + '][type]" rel="0" value="iframe" >',
            '<input  type="hidden" class="width" name="custom[' + customid + '][style][width]" rel="px" value="50" >',
            '<input  type="hidden" class="height" name="custom[' + customid + '][style][height]" rel="px" value="40" >',
            '<input  type="hidden" class="top" name="custom[' + customid + '][style][top]" rel="0" value="30px" >',
            '<input  type="hidden" class="left" name="custom[' + customid + '][style][left]" rel="0" value="10px" >',
            '<input  type="hidden"  name="custom[' + customid + '][style][border]" rel="0" value="{}" >',
            '<label for="custom-custom-border-size">"Border"</label>',
            '<input  type="number"  id="custom-custom-border-width" name="custom[' + customid + '][style][border][width]" rel="px" value="100" >',
            '<label for="custom-custom-border-color">"Border Color"</label>',
            '<input  type="text" class="jscolor"  id="custom-custom-border-color" name="custom[' + customid + '][style][border][color]" rel="#" value="000" >',
            '<label for="custom-custom-background-radius">"Border Radius"</label>',
            '<input  type="number"   id="custom-custom-border-radius" name="custom[' + customid + '][style][border][radius]" rel="px" value="10" >'
        ].join("");
        var divc = _reslide.html('<div class="reslide_content"></div>');
        divc[0].innerHTML = '<div class="reslide_' + custom + ' reslide_custom"><img class="video" src="' + reslide_ajax_object.images_url + '/play.youtube.png"></div>';
    }
    else if (custom == 'h3') {
        content = [
            '<input  type="hidden" name="custom[' + customid + ']" rel="0" value="{}" >',
            '<input  type="hidden" name="custom[' + customid + '][style]" rel="0" value="{}" >',
            '<input  type="hidden" name="custom[' + customid + '][type]" rel="0" value="h3" >',
            '<input  type="hidden" name="custom[' + customid + '][id]" rel="0" value="' + customid.replace(custom, '') + '" >',
            '<input  type="hidden" class="text" name="custom[' + customid + '][text]" rel="0" value="Text ' + customid.replace(custom, '') + '" >',
            '<input  type="hidden" class="width" name="custom[' + customid + '][style][width]" rel="0" value="100" >',
            '<input  type="hidden" class="height" name="custom[' + customid + '][style][height]" rel="0" value="50" >',
            '<input  type="hidden" class="top" name="custom[' + customid + '][style][top]" rel="0" value="0px" >',
            '<input  type="hidden" class="left" name="custom[' + customid + '][style][left]" rel="0" value="0px" >',
            '<input  type="hidden"  name="custom[' + customid + '][style][background]" rel="0" value="{}" >',
            '<input  type="hidden" name="custom[' + customid + '][style][border]" rel="0" value="{}" >',
            '<input  type="hidden" name="custom[' + customid + '][style][font]" rel="0" value="{}" >',
            '<span class="color">',
            '<label for="custom-background-color-link">Color:</label>',
            '<input  type="text" class="jscolor" id="custom-bullets-background-color-link"  name="custom[' + customid + '][style][background][color]" rel="#" value="FFFFFF" >',
            '</span>',
            '<span class="color">',
            '<label for="custom-background-color-hover">Hover Color:</label>',
            '<input  type="text" class="jscolor" id="custom-bullets-background-color-hover" name="custom[' + customid + '][style][background][hover]" rel="#" value="ff0" >',
            '</span>',
            '<span class="size">',
            '<label for="custom-background-opacity">Opacity:</label>',
            '<input  type="number"  id="custom-background-opacity" name="custom[' + customid + '][style][opacity]" rel="0" value="0" >%',
            '</span>',
            '<span class="size">',
            '<label for="custom-border-size">Border Width:</label>',
            '<input  type="number"  id="custom-border-width" name="custom[' + customid + '][style][border][width]" rel="px" value="1" >',
            '</span>',
            '<span class="color">',
            '<label for="custom-border-color">Border Color:</label>',
            '<input  type="text" class="jscolor"  id="custom-custom-border-color" name="custom[' + customid + '][style][border][color]" rel="#" value="000" >',
            '</span>',
            '<span class="size">',
            '<label for="custom-background-radius">Border Radius:</label>',
            '<input  type="number"   id="custom-custom-border-radius" name="custom[' + customid + '][style][border][radius]" rel="px" value="0" >',
            '</span>',
            '<span class="size">',
            '<label for="custom-font-size">Font Size:</label>',
            '<input  type="number"   id="custom-font-size" name="custom[' + customid + '][style][font][size]" rel="px" value="12" >',
            '</span>',
            '<span class="color">',
            '<label for="custom-font-color">Font Color:</label>',
            '<input  type="text" class="jscolor"  id="custom-font-color" name="custom[' + customid + '][style][color]" rel="#" value="000" >',
            '</span>'

        ].join("");
        var divc = _reslide.html('<div class="reslide_content"></div>');
        divc[0].innerHTML = '<div class="reslide_' + custom + ' reslide_custom"><div class="reslide_custom_child"></div><span class="h3">Text</span></div>';
    }
    else if (custom == 'img') {
        content = [
            '<input  type="hidden" name="custom[' + customid + ']" rel="0" value="{}" >',
            '<input  type="hidden" name="custom[' + customid + '][style]" rel="0" value="{}" >',
            '<input  type="hidden" name="custom[' + customid + '][id]" rel="0" value="' + customid.replace(custom, '') + '" >',
            '<input  type="hidden" name="custom[' + customid + '][style][border]" rel="0" value="{}" >',
            '<input  type="hidden" id="custom_src" name="custom[' + customid + '][src]" rel="0" value="" >',
            '<input  type="hidden" id="custom_alt" name="custom[' + customid + '][alt]" rel="0" value="" >',
            '<input  type="hidden" name="custom[' + customid + '][type]" rel="0" value="img" >',
            '<input  type="hidden" class="width" name="custom[' + customid + '][style][width]" rel="0" value="100" >',
            '<input  type="hidden" class="height" name="custom[' + customid + '][style][height]" rel="0" value="" >',
            '<input  type="hidden" class="top" name="custom[' + customid + '][style][top]" rel="0" value="0px" >',
            '<input  type="hidden" class="left" name="custom[' + customid + '][style][left]" rel="0" value="0px" >',
            '<span class=" color">',
            '<label for="custom-background-opacity">Opacity:</label>',
            '<input  type="number"  id="custom-background-opacity" name="custom[' + customid + '][style][opacity]" rel="0" value="100" >%',
            '</span>',
            '<span class=" size">',
            '<label for="custom-custom-border-size">Border:</label>',
            '<input  type="number"  id="custom-custom-border-width" name="custom[' + customid + '][style][border][width]" rel="px" value="0" >',
            '</span>',
            '<span class=" color">',
            '<label for="custom-custom-border-color">Border Color:</label>',
            '<input  type="text" class="jscolor"  id="custom-custom-border-color" name="custom[' + customid + '][style][border][color]" rel="#" value="000" >',
            '</span>',
            '<span class=" size">',
            '<label for="custom-custom-background-radius">Border Radius:</label>',
            '<input  type="number"   id="custom-custom-border-radius" name="custom[' + customid + '][style][border][radius]" rel="px" value="0" >',
            '</span>'
        ].join("");
        var divc = _reslide.html('<div class="reslide_content"></div>');
        divc[0].innerHTML = '<div class="reslide_' + custom + ' reslide_custom"><img class="img" src=""></div>';
    }
    form.innerHTML = content;
    wrapper.append(close[0]);
    wrapper.append(popup_style[0]);
    wrapper.append(form).append(divc[0]);
    _reslide._('body')[0].append(wrapper);
    _resliderjscolor();
}


/**###POPUPS CLOSE###**/
document.onkeydown = function (evt) {
    evt = evt || window.event;
    if (evt.keyCode == 27) {
        reslidePopupPreview.hide();
        reslidePopupTitle.hide();
        reslidePopupDescription.hide();
        if (reslidePopupCustom) reslidePopupCustom.hide();
        if (_reslide._('.reslide_slider_container_preview')[0]) {
            _reslide(_reslide._('.reslide_slider_container_preview')[0]).parent().removeChild(_reslide._('.reslide_slider_container_preview')[0]);
        }
    }
};


(function ($) {
    $(function () {
        /***  preview ***/
        if (document.getElementById("reslide_preview")) {
            document.getElementById("reslide_preview").addEventListener("click", function (e) {
                if (!reslider.length) {
                    alert('Firstly add slides in your slider!');
                    return false;
                }
                var saveFor = _reslide(e.currentTarget).getAttr('data');
                if (saveFor) {
                    //alert(saveFor);
                    reslideGetSlideParams(saveFor);
                    reslideDrawSlider();
                    return false;
                }
                reslideGetSliderStyles();
                reslideGetSliderParams();
                reslideGetSliderParams('custom');
                reslideDrawSlider();
                return false;
            });
        }
        jQuery("body").on("click", '.reslide_close,#reslide_slider_preview_popup', function () {
            reslidePopupPreview.hide();
            reslidePopupTitle.hide();
            reslidePopupDescription.hide();
            if (reslidePopupCustom) reslidePopupCustom.hide();
            if (_reslide._('.reslide_slider_container_preview')[0]) {
                _reslide(_reslide._('.reslide_slider_container_preview')[0]).parent().removeChild(_reslide._('.reslide_slider_container_preview')[0]);
            }
            return false;
        });

        jQuery("#reslide_slide_edit > .close").click(function () {
            jQuery(this).parent().css('display', 'none');
        });

        /****     menu slider settings ***/

        jQuery('#reslide_slider_edit .settings  .menu ul > li a').click(function () {
            var menu_setting = jQuery(this).parent().attr('rel');
            jQuery('#reslide_slider_edit .settings  .menu ul > li a').removeClass('active');
            jQuery(this).addClass('active');
            jQuery('#reslide_slider_edit .settings .menu-content ul li').removeClass('active');
            jQuery('#reslide_slider_edit .settings .menu-content ul li.' + menu_setting).addClass('active');
            return false;

        });

        /***validation****/
        jQuery('#general-settings input[type="number"],#bullet-settings input[type="number"],.reslide-styling  input[type="number"]').on('keyup change', function () {
            var value = jQuery(this).val();
            value = Math.abs(value);
            jQuery(this).val(value);
        });
        jQuery('#general-settings input[type="checkbox"]').on('change', function () {
            var prop = jQuery(this).prop('checked');
            (prop) ? jQuery(this).val(1) : jQuery(this).val(0);
        });

        /*** slider general options ***/
        jQuery('#reslide-autoplay').on('change', function () {
            jQuery(this).attr('checked') ? jQuery(this).val(1) : jQuery(this).val(0);
            reslideGetSliderParams();
        });
        
        jQuery('#reslide-pauseonhover').on('change', function () {
            jQuery(this).attr('checked') ? jQuery(this).val(1) : jQuery(this).val(0);
            reslideGetSliderParams();
        });

        jQuery('#reslide-slide-image_link_new_tab').on('change', function () {
            jQuery(this).attr('checked') ? jQuery(this).val(1) : jQuery(this).val(0);
        });

        _reslide._('#reslide-effect-type').on('change', function () {
            var value = _reslide(this).value;
            _reslide._('#reslide-effect-type + input')[0].value = value;
        });
        _reslide._('#reslide-custom').on('change', function () {
            var value = _reslide(this).value;
            _reslide._('#reslide-custom-type').value = value;
            _reslide(_reslide._('#reslide-custom-add')).addAttr('data', value);
        });

        /*** arrow settings ***/
        jQuery('#reslide-arrows-background input[type="radio"]').on('change', function () {
            if (jQuery(this).attr('checked')) {
                jQuery('#params-arrows-type').val(jQuery(this).attr('rel'));
                reslideGetSliderParams();
            }
        });

        /*** bullets settings ***/
        jQuery('#reslide-bullets-position input[type="radio"]').on('change', function () {

            if (jQuery(this).attr('checked')) {
                jQuery('#params-bullets-position').val(jQuery(this).attr('rel'));
                reslideGetSliderParams();
            }
        });


    });
})(jQuery);

/***  get slider styles ***/
function reslideGetSliderStyles() {
    jQuery('#general-settings li input[name^="style"]').each(function () {
        var param = jQuery(this).attr('name');
        param = param.replace('style[', '');
        param = param.replace(']', '');
        reslider["style"][param] = jQuery(this).val();
    });
    reslideGetSliderMainOptions();
    reslideGetSliderParams();
    jQuery('#reslide-slider-construct').width(reslider['style']['width']);
    jQuery('#reslide-slider-construct').height(reslider['style']['height']);
    jQuery('#reslide-slider-construct .reslide_construct').css('max-width', reslider['style']['width'] + 'px');
    jQuery('#reslide-slider-construct .reslide_construct').css('max-height', reslider['style']['height'] + 'px');
}
function reslideGetSliderMainOptions() {
    jQuery('#general-settings li input[name^="cs["]').each(function () {
        var param = jQuery(this).attr('name');
        param = param.replace('cs[', '');
        param = param.replace(']', '');
        reslider[param] = jQuery(this).val();
    });
}
function reslideGetSliderParams(custom) {

    var params = custom || 'params';
    _reslide.each('.main-content .' + params + ' input[name^="' + params + '"]', function () {
        $this = _reslide(this);
        if (($this.getAttr('type') == 'radio') && (!$this.checked))
            return;
        var param = $this.getAttr('name');

        //	console.log('param',param);
        var currentvalue = jQuery($this).val();
        //	console.log(param,currentvalue);
        param = param.replace(params + '[', '');
        param = param.replace(']', '');
        param = param.replace(']', '');
        param = param.replace(']', '');
        param = param.replace(']', '');
        param = param.replace(']', '');
        param = param.split('[');

        //param = param.split(target).join(replacement);

        currentvalue = (IsJsonString(currentvalue)) ? JSON.parse(currentvalue) : currentvalue;
        //console.log(param);
        if (param.length == 1)
            reslider[params][param] = currentvalue;
        else if (param.length == 2) {
            reslider[params][param[0]][param[1]] = currentvalue;
        }
        else if (param.length == 3) {
            //	console.log(param);
            reslider[params][param[0]][param[1]][param[2]] = currentvalue;
        }
        else if (param.length == 4) {
            //console.log(param);
            reslider[params][param[0]][param[1]][param[2]][param[3]] = currentvalue;
        }
        else if (param.length == 5) {
            //	console.log(param);
            reslider[params][param[0]][param[1]][param[2]][param[3]][param[4]] = currentvalue;
        }
    });
}

function reslideGetSlideParams(slide) {
    var params = 'custom';// || 'params';
    //	alert(0);
    _reslide.each('.main-content .' + params + ' input[name^="' + params + '"]', function () {//alert(1);
        $this = _reslide(this);
        if (($this.getAttr('type') == 'radio') && (!$this.checked))
            return;
        var param = $this.getAttr('name');
        var currentvalue = jQuery($this).val();
        param = param.replace(params + '[', '');
        param = param.replace(']', '');
        param = param.replace(']', '');
        param = param.replace(']', '');
        param = param.replace(']', '');
        param = param.replace(']', '');
        param = param.split('[');


        currentvalue = (IsJsonString(currentvalue)) ? JSON.parse(currentvalue) : currentvalue;
        //console.log(param);
        if (param.length == 1)
            reslider['slides'][slide][params][param] = currentvalue;
        else if (param.length == 2) {
            reslider['slides'][slide][params][param[0]][param[1]] = currentvalue;
        }
        else if (param.length == 3) {
            //	console.log(param);
            reslider['slides'][slide][params][param[0]][param[1]][param[2]] = currentvalue;
        }
        else if (param.length == 4) {
            //console.log(param);
            reslider['slides'][slide][params][param[0]][param[1]][param[2]][param[3]] = currentvalue;
        }
        else if (param.length == 5) {
            //	console.log(param);
            reslider['slides'][slide][params][param[0]][param[1]][param[2]][param[3]][param[4]] = currentvalue;
        }
    });
    var slidetitle = _reslide(_reslide._('#reslide-slide-title')).val();
    var slidedescription = _reslide(_reslide._('#reslide-slide-description')).val();
    var slideimage_link = _reslide(_reslide._('#reslide-slide-image_link')).val();
    var slideimage_link_new_tab = _reslide(_reslide._('#reslide-slide-image_link_new_tab')).val();
    reslider['slides'][slide]['title'] = slidetitle;
    reslider['slides'][slide]['description'] = slidedescription;
    reslider['slides'][slide]['image_link'] = slideimage_link;
    reslider['slides'][slide]['image_link_new_tab'] = slideimage_link_new_tab;

}


/****    styling   ***/


function reslideSetCustomFieldStyles(field, element) {
    if (arguments.length < 2) {
        var params = 'params';
    }
    else params = 'custom';

    if (!getparamsFromUrl('slideid', location.href)) {
        var styleFor = reslider[params][field];
    }
    else {
        var styleFor = reslider['slides']['slide' + getparamsFromUrl('slideid', location.href)][params][field];
    }

    jQuery('#reslide_slider_' + field + '_styling').find('.reslide_' + (element || field)).outerWidth(parseFloat(styleFor['style']['width']));
    jQuery('#reslide_slider_' + field + '_styling').find('.reslide_' + (element || field)).outerHeight(parseFloat(styleFor['style']['height']));


}
function reslideDrawCustomFieldStyles(field) {
    var field = field;

    function createCssJson(name, value, direction) {
        var name = name.split('[style]');
        var style;
        var direction = (direction == "0") ? "" : direction;
        style = (direction == "#") ? ('"' + direction + value + '"') : ('"' + value + direction + '"');
        name = name[1];
        param = name;
        param = param.ReslideReplaceAll('][', '-');
        param = param.replace('][', '-');
        param = param.replace(']', '');
        param = param.replace(']', '');
        param = param.replace('[', '');
        param = param.replace('[', '');
        param = param.replace('[', '');
        param = param.split('[');
        param = '"' + param.toString() + '"';
        direction = "";
        param = "{" + param + ":" + style + "}";
        return param;
    }

    if (arguments.length < 2) {
        jQuery('#reslide_slider_' + field + '_styling .params input[name^="params"]').on('change', function () {

            var css = createCssJson(jQuery(this).attr('name'), jQuery(this).val(), jQuery(this).attr('rel'));

            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_' + field).css(JSON.parse(css));
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_' + field + '_child').css(JSON.parse(css));
            var opacity = jQuery('#reslide_slider_' + field + '_styling ' + '#params-' + field + '-background-opacity').val();
            var borderRadius = jQuery('#reslide_slider_' + field + '_styling ' + '#params-' + field + '-background-opacity').val();
            opacity = opacity / 100;
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_' + field).css('opacity', '1');
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_' + field).css('background', 'none');
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_' + field + '_child').css('opacity', opacity);

        })
    }
    else {
        _reslide._('#reslide_slider_' + field + '_styling .custom input[name^="custom"]').on('change', function () {
            var css = createCssJson(jQuery(this).attr('name'), jQuery(this).val(), jQuery(this).attr('rel'));

            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_custom').css(JSON.parse(css));
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_custom').css('overflow', 'hidden');
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_custom_child').css(JSON.parse(css));
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_custom_child').css('border-radius', '0');
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_custom_child').css('border-width', '0');
            var opacity = jQuery('#reslide_slider_' + field + '_styling ' + '#custom-background-opacity').val();
            var borderRadius = jQuery('#reslide_slider_' + field + '_styling ' + '#custom-background-opacity').val();
            opacity = opacity / 100;
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_custom').css('opacity', '1');
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_custom').css('background', 'none');
            jQuery('#reslide_slider_' + field + '_styling ' + '.reslide_custom_child').css('opacity', opacity);
            jQuery('#reslide_slider_' + field + '_styling ' + '.img').css('opacity', opacity);

        })
    }
}


var initDifferX, initDifferY, moveCondition = {type: ''};


(function ($) {
    $(function () {
        /***title styling ***/
        if (document.getElementById('reslide-title-stylings')) {
            document.getElementById('reslide-title-stylings').addEventListener('click', function () {
                reslideGetSliderParams();
                reslideSetCustomFieldStyles('title');
                reslideDrawCustomFieldStyles('title');
                reslidePopupTitle.show();
                _resliderjscolor();
            });
        }
        /***title styling ***/
        /***description styling ***/
        if (document.getElementById('reslide-description-stylings')) {

            document.getElementById('reslide-description-stylings').addEventListener('click', function () {
                reslideGetSliderParams();
                reslideSetCustomFieldStyles('description')
                reslideDrawCustomFieldStyles('description');
                reslidePopupDescription.show();
                _resliderjscolor();
            })
        }
        if (document.getElementById('reslide-custom-stylings')) {
            document.getElementById('reslide-custom-stylings').addEventListener('click', function (e) {
                var type = _reslide(_reslide._('#reslide-custom-type')).val();
                var arr = {'image': 'img', 'text': 'h3', 'youtube': 'iframe', 'button': 'button'};
                type = arr[type];

                var idstyle = _reslide(e.currentTarget).getAttr('data');
                if (idstyle == 'title' || idstyle == 'description')
                    return;

                reslidePopupCustom = new reslidePopups('reslide_slider_preview_popup', 'reslide_slider_' + idstyle + '_styling');
                if (!getparamsFromUrl('slideid', location.href))
                    reslideGetSliderParams('custom');
                else
                    reslideGetSlideParams('slide' + getparamsFromUrl('slideid', location.href));
                reslideSetCustomFieldStyles(idstyle, type)
                reslideDrawCustomFieldStyles(idstyle, true);
                reslidePopupCustom.show();

            });
        }


        /*** for define current move + resize element ***/

        var csconstruct = document.getElementsByClassName('reslide_construct');
        for (var i = 0; i < csconstruct.length; i++) {
            reslideDrag(csconstruct[i], 'reslide-slider-construct');
            csconstruct[i].onclick = function (e) {

                e = e || window.event;
                bl = e.currentTarget;
                var typeid = bl.getAttribute('data');

                if (typeid != 'description' && typeid != 'title')
                    remove.style.display = 'block';
                else {
                    remove.style.display = 'none';
                    custum_styling.style.display = 'none';
                }
                _reslide(_reslide._('#reslide-custom-stylings')).addAttr('data', typeid);
                zoom.style.display = 'block';
                if (typeid != 'description' && typeid != 'title')
                    custum_styling.style.display = 'inline-block';
            }
        }
        /***<default construct >***/

        if (_reslide._('.reslide_construct_texter').length)
            _reslide._('.reslide_construct_texter').on('dblclick', function (e) {
                moveCondition.type = 'standing';
                e = e || window.event;
                var text = e.currentTarget.innerHTML;
                _reslide(e.currentTarget).addStyle('display:none;');
                var inputElement = _reslide('textarea');
                inputElement.addClass('reslide_construct_textarea').addStyle('width: 100%;height:100%;display:block;');
                inputElement.innerHTML = text;
                _reslide(e.currentTarget.parentNode).append(inputElement);
            })


        /***<default construct >***/

        var zoom = document.getElementById('zoom');
        var remove = document.getElementById('reslide_remove');
        var custum_styling = document.getElementById('reslide-custom-stylings');
        var bl, type;

        _reslide._('#reslide_remove').on('click', function () {
            var deletel = _reslide(bl).getAttr('data');
            delete reslider['custom'][deletel];
            if (getparamsFromUrl('slideid', location.href))
                delete reslider['slides']['slide' + getparamsFromUrl('slideid', location.href)]['custom'][deletel];
            jQuery('#reslide_' + deletel).remove();
            jQuery('#reslide_slider_' + deletel + '_styling').remove();
            zoom.style.display = 'none';
            remove.style.display = 'none';
            _reslide._('#reslide-custom-stylings').style.display = 'none';
        })
        _reslide._('#reslide-custom-add').on('click', function () {
            if(jQuery(this).hasClass('free')) return false;
            var type = event.currentTarget.getAttribute('data');
            if (type == 'button') {
                type = "button";
                var id = _reslide._('.reslide_' + type + '.reslide_construct').length;

            }
            else if (type == "image") {
                type = "img";
                var id = _reslide._('.reslide_' + type + '.reslide_construct').length;

                var d = this;
                open_media_window.apply(d, ['image', type + id]);
            }
            else if (type == "text") {
                type = "h3";
                var id = _reslide._('.reslide_' + type + '.reslide_construct').length;

            }
            else if (type == "vimeo" || type == "youtube") {
                type = "iframe";
                var id = _reslide._('.reslide_' + type + '.reslide_construct').length;
            }

            var clas = event.currentTarget.getAttribute('rel');
            reslideCreateStylingPopup(type, type + id);
            _reslide(_reslide._('#reslide-custom-stylings')).addAttr('data', type + id);
            reslideCreateDragElement(clas, type, 'reslide-slider-construct');
        })


        function setWrittenText() {
            var allWrittenTexts = _reslide._('.reslide_construct_textarea');
            for (var i = 0; i < allWrittenTexts.length; i++) {
                var textContent = allWrittenTexts[i].value;
                _reslide(allWrittenTexts[i]).addStyle('display:none;');
                _reslide.find(allWrittenTexts[i].parentNode, '.reslide_construct_texter')[0].innerHTML = textContent;
                var id = _reslide(allWrittenTexts[i].parentNode).getAttr('data');
                _reslide(allWrittenTexts[i]).parent().removeChild(_reslide.find(allWrittenTexts[i].parentNode, '.reslide_construct_textarea')[0]);
                textContent = textContent.ReslideReplaceAll('"', '&#34;');
                textContent = textContent.ReslideReplaceAll("'", '&#39;');
                textContent = textContent.ReslideReplaceAll("\\", '');
                jQuery('#reslide_slider_' + id + '_styling .text').val(textContent);
                jQuery('#reslide_slider_' + id + '_styling .btn').text(allWrittenTexts[i].value);
                jQuery('#reslide_slider_' + id + '_styling .h3').text(allWrittenTexts[i].value);
                jQuery('.reslide_construct_texter').css('display', 'block');
                moveCondition.type = '';
            }
        }

        function reslideCreateDragElement(elementName, type, container) {
            var id, elements, type, newElement, newtextNode;
            remove.style.display = 'none';
            zoom.style.display = 'none';
            type = type.toLowerCase();
            newElement = document.createElement(type);
            elements = document.querySelectorAll('.reslide_' + type + ".reslide_construct");
            id = (elements.length) ? id = elements.length : 0;
            if (type == 'img') _reslide(newElement).addAttr('src', _IMAGES + '/noimage.png');
            newElement.id = 'reslide_' + type + id;
            newElement.classList.add('reslide_' + type);
            newElement.classList.add('reslide_construct');
            newElement.setAttribute("data", type + id);
            newElement.style.position = "absolute";
            newElement.style.left = "0px";
            newElement.style.top = "0px";
            if (type == 'h3' || type == "button") {
                var innerInput = _reslide('span');
                innerInput.addClass('reslide_construct_texter', 'reslide_input' + type).addStyle('width: 100%;height:100%;display:block;');
                (type == 'h3') && (newElementTEXT = document.createTextNode("Text " + id));
                (type == 'button') && (newElementTEXT = document.createTextNode("Button " + id));
                innerInput.append(newElementTEXT);
                newElement.appendChild(innerInput);
            }
            reslideDrag(newElement, container);
            document.getElementById(container).appendChild(newElement);
            var allDrawenElements = document.querySelectorAll("#" + container + " .reslide_construct");
            for (var i = 0; i < allDrawenElements.length; i++) {
                allDrawenElements[i].onclick = function () {

                    bl = event.currentTarget;
                    typeid = bl.getAttribute('data');
                    if (typeid != 'description' && typeid != 'title')
                        remove.style.display = 'block';
                    else
                        remove.style.display = 'none';
                    _reslide(_reslide._('#reslide-custom-stylings')).addAttr('data', typeid);
                    //alert(styling);
                    //		console.log(event.currentTarget);
                    zoom.style.display = 'block';

                    custum_styling.style.display = 'inline-block';
                }
            }
            _reslide._('.reslide_construct_texter').length &&
            _reslide._('.reslide_construct_texter').on('dblclick', function (e) {
                e = e || window.event;
                var text = e.currentTarget.innerHTML;
                _reslide(e.currentTarget).addStyle('display:none;');
                var inputElement = _reslide('textarea');
                inputElement.addClass('reslide_construct_textarea').addStyle('width: 100%;height:100%;display:block;');
                inputElement.innerHTML = text;
                if (!_reslide.find(e.currentTarget.parentNode, '.reslide_construct_textarea').length)
                    _reslide(e.currentTarget.parentNode).append(inputElement);
            })
        }


        function reslideDrag(dragElement, dragIn) {
            var gv = document.getElementById('general-view');
            var gvc = document.getElementById('reslide-slider-construct');

            var c = document.getElementById(dragIn) || document.getElementById('reslide-slider-construct');

            var dragElement = dragElement;
            bl = dragElement;

            dragElement.ondragstart = function () {
                return false;
            };
            reslideDrag.getCoords = function (elem) {
                var box = elem.getBoundingClientRect();

                return {
                    top: box.top + pageYOffset,
                    left: box.left + pageXOffset
                };

            }

            function getOffsetTop(elem) {
                var offsetTop = 0;
                do {
                    if (!isNaN(elem.offsetTop)) {
                        offsetTop += elem.offsetTop;
                    }
                } while (elem = elem.offsetParent);
                return offsetTop;
            }

            function getOffsetLeft(elem) {
                var offsetLeft = 0;
                do {
                    if (!isNaN(elem.offsetLeft)) {
                        offsetLeft += elem.offsetLeft;
                    }
                } while (elem = elem.offsetParent);
                return offsetLeft;
            }

            function moveAt(evnt, mover, shiftX, shiftY) {
                $this = this.type;
                type = mover.getAttribute('data');
                var RH = parseFloat(dragElement.style.left) + jQuery(dragElement).width() / 2;
                var RV = parseFloat(dragElement.style.top) + jQuery(dragElement).height() / 2;
                var CH = jQuery(c).width() / 2;
                var CV = jQuery(c).height() / 2;
                if (Math.abs(RH - CH) < 3) {
                    var coords = reslideDrag.getCoords(dragElement);
                    jQuery('#reslide-construct-vertical').show();
                    if (typeof initDifferX == 'undefined')
                        initDifferX = evnt.pageX - coords.left;
                    var newDiffer = evnt.pageX - coords.left;
                    if (Math.abs(newDiffer - initDifferX) > 20) {
                        if ($this !== 'standing') {
                            mover.style.left = evnt.pageX - shiftX + 'px';
                            jQuery('#reslide-construct-vertical').hide();
                        }
                    }
                    else
                        jQuery('#reslide-construct-vertical').show();
                } else {
                    if ($this !== 'standing') {
                        mover.style.left = evnt.pageX - shiftX + 'px';
                        zoom.style.left = evnt.pageX - shiftX + mover.offsetWidth + 'px';
                        if (type != 'title')
                            remove.style.left = evnt.pageX - shiftX + mover.offsetWidth - 14 + 'px';
                    }
                }
                if (Math.abs(RV - CV) < 3) {
                    var coords = reslideDrag.getCoords(dragElement);
                    jQuery('#reslide-construct-horizontal').show();
                    if (typeof initDifferY == 'undefined')
                        initDifferY = evnt.pageY - coords.top;
                    var newDiffer = evnt.pageY - coords.top;
                    if (Math.abs(newDiffer - initDifferY) > 20) {
                        if ($this !== 'standing') {
                            mover.style.top = evnt.pageY - shiftY + 'px';
                        }
                        jQuery('#reslide-construct-horizontal').hide();
                    }
                    else
                        jQuery('#reslide-construct-horizontal').show();
                } else {
                    if ($this !== 'standing') {
                        mover.style.top = evnt.pageY - shiftY + 'px';
                        zoom.style.top = evnt.pageY - shiftY + mover.offsetHeight + 'px';
                        if (type != 'title')
                            remove.style.top = evnt.pageY - shiftY + 'px';
                    }
                }
                if (type.substring(0, 3) != 'img') {
                    if (parseFloat(mover.style.left) < 0) {
                        if ($this !== 'standing') {
                            mover.style.left = '0px';
                            zoom.style.top = evnt.pageY - shiftY + mover.offsetHeight + 'px';
                            zoom.style.left = mover.offsetWidth + 'px';
                            remove.style.left = mover.offsetWidth - 14 + 'px';
                        }
                    }
                    if (parseFloat(mover.style.top) < 0) {
                        if ($this !== 'standing') {
                            mover.style.top = '0px';
                            zoom.style.top = mover.offsetHeight + 'px';
                            remove.style.top = 0 + 'px';
                        }
                    }
                    if (parseFloat(mover.style.left) > (jQuery('#reslide-slider-construct').width() - jQuery(mover).outerWidth())) {
                        if (this !== 'standing') {
                            mover.style.left = jQuery('#reslide-slider-construct').width() - jQuery(mover).outerWidth() + 'px';
                            remove.style.left = jQuery('#reslide-slider-construct').width() - 14 + 'px';
                        }
                    }
                    if (parseFloat(mover.style.top) > (jQuery('#reslide-slider-construct').height() - jQuery(mover).outerHeight())) {
                        if ($this !== 'standing') {
                            mover.style.top = jQuery('#reslide-slider-construct').height() - jQuery(mover).outerHeight() + 'px';
                            remove.style.top = jQuery('#reslide-slider-construct').height() - jQuery(mover).outerHeight() + 'px';
                        }
                    }
                }
                jQuery('#reslide_slider_' + type + '_styling').find('.top').val(mover.style.top);
                jQuery('#reslide_slider_' + type + '_styling').find('.left').val(mover.style.left);
            }

            dragElement.onmousedown = function (e) {
                moveCondition.type = 'standing';
                type = dragElement.getAttribute('data');
                differ = reslideDiffer(gv, gvc);
                if (differ < 15) differ = 0;
                // console.log('DF',differ);
                var coords = reslideDrag.getCoords(dragElement);
                var shiftX = e.pageX - coords.left + getOffsetLeft(c) - differ;
                var shiftY = e.pageY - coords.top + getOffsetTop(c);
                zoom.style.left = parseFloat(reslideDrag.getCoords(dragElement).left) - parseFloat(reslideDrag.getCoords((_reslide._('#reslide-slider-construct'))).left) + dragElement.offsetWidth + 'px';
                if (type != 'title' && type != 'description') {
                    remove.style.display = 'block';
                    remove.style.left = parseFloat(reslideDrag.getCoords(dragElement).left) - parseFloat(reslideDrag.getCoords((_reslide._('#reslide-slider-construct'))).left) + dragElement.offsetWidth - 14 + 'px';
                }
                else
                    remove.style.display = 'none';
                dragElement.style.position = 'absolute';

                (function () {  /*init remove and zoom button's position */
                    zoom.style.top = e.pageY - shiftY + dragElement.offsetHeight + 'px';
                    remove.style.top = e.pageY - shiftY + 'px';
                })();


                dragElement.style.zIndex = 1000;
                moveAt.call(moveCondition, e, dragElement, shiftX, shiftY);

                document.onmousemove = function (e) {
                    if (_reslide.find('#reslide-slider-construct', '.reslide_construct_textarea').length)
                        moveCondition.type = 'standing';
                    else moveCondition.type = '';
                    moveAt.call(moveCondition, e, dragElement, shiftX, shiftY);
                }

                dragElement.onmouseup = function () {
                    initDifferX = undefined;
                    initDifferY = undefined;
                    document.onmousemove = null;
                    dragElement.onmouseup = null;
                };

                document.onclick = function () {
                    document.onmousemove = null;
                    if (_reslide._('.reslide_construct_textarea').length) {
                        _reslide._('.reslide_construct_textarea').on('blur', function () {
                            setWrittenText();
                        });
                    }
                };

            }
            return dragElement;
        }

        /*** resize ***/
        if (zoom) zoom.addEventListener('mousedown', reslideInitDrag, false);

        var startX, startY, startWidth, startHeight, shiftX, shiftY;

        function reslideInitDrag(e) {
            moveCondition.type = '';
            jQuery('#reslide-construct-vertical').hide();
            jQuery('#reslide-construct-horizontal').hide();
            startX = e.clientX;
            startY = e.clientY;
            startWidth = parseInt(document.defaultView.getComputedStyle(bl).width, 10);
            startHeight = parseInt(document.defaultView.getComputedStyle(bl).height, 10);
            document.documentElement.addEventListener('mousemove', reslideDoDrag, false);
            document.documentElement.addEventListener('mouseup', reslideStopDrag, false);
        }

        function reslideDoDrag(e) {

            bl.style.width = (startWidth + e.clientX - startX) + 'px';
            bl.style.height = (startHeight + e.clientY - startY) + 'px';
            zoom.style.top = bl.offsetTop + bl.offsetHeight + 'px';
            zoom.style.left = bl.offsetLeft + bl.offsetWidth + 'px';
            jQuery('#reslide_slider_' + type + '_styling').find('.width').val(parseFloat(bl.style.width));
            jQuery('#reslide_slider_' + type + '_styling').find('.reslide_content .reslide_custom').width(bl.style.width);
            jQuery('#reslide_slider_' + type + '_styling').find('.height').val(parseFloat(bl.style.height));
            jQuery('#reslide_slider_' + type + '_styling').find('.reslide_content .reslide_custom').height(bl.style.height);
            zoom.style.top = parseInt(bl.style.top) + bl.offsetHeight + 'px';
            zoom.style.left = parseInt(bl.style.left) + bl.offsetWidth + 'px';
            remove.style.top = parseInt(bl.style.top) + 'px';
            remove.style.left = parseInt(bl.style.left) + bl.offsetWidth - 14 + 'px';

        }

        function reslideStopDrag(e) {
            document.documentElement.removeEventListener('mousemove', reslideDoDrag, false);
            document.documentElement.removeEventListener('mouseup', reslideStopDrag, false);
            zoom.style.top = parseInt(bl.style.top) + bl.offsetHeight + 'px';
            zoom.style.left = parseInt(bl.style.left) + bl.offsetWidth + 'px';
            remove.style.top = parseInt(bl.style.top) + 'px';
            remove.style.left = parseInt(bl.style.left) + bl.offsetWidth - 14 + 'px';
            moveCondition.type = '';
        }
        
    });



    /* Cookies */
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
    
    function reslideGetCookie(name) {
        var matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    function reslideDeleteCookie(name) {
        setCookie(name, "", {
            expires: -1
        })
    }
})
(jQuery);