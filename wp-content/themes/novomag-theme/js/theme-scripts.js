var breakingStart = true; // autostart breaking news
var breakingSpeed = 40; // breaking msg speed

var breakingScroll = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var breakingOffset = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
var elementsToClone = [true, true, true, true, true, true, true, true, true, true];
var elementsActive = [];
var theCount = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];



(function( $ ) {
	"use strict";
	
	jQuery(window).resize(function() {
		refreshSidebar();
	});

	jQuery(window).ready(function() {

		jQuery('img').each( function(i){
			var bottom_of_object = jQuery(this).offset().top + jQuery(this).outerHeight();
			var bottom_of_window = jQuery(window).scrollTop() + jQuery(window).height() + 200;

			if( bottom_of_window <= bottom_of_object ){
				jQuery(this).css("opacity", "0");
			}
		});

		jQuery(window).scroll( function(){
			jQuery('img').each( function(i){
				var bottom_of_object = jQuery(this).offset().top + jQuery(this).outerHeight();
				var bottom_of_window = jQuery(window).scrollTop() + jQuery(window).height() + 200;

				if( bottom_of_window > bottom_of_object ){
					jQuery(this).animate( {'opacity':'1'}, 500 );
				}
			});
		});

		jQuery(".tab-a").each(function(){
			jQuery(this).find("h3").eq(0).addClass("active");
		});

		jQuery(".tab-d").each(function(){
			jQuery(this).children("div").eq(0).addClass("active");
		});

		jQuery(".tab-a h3").click(function(){
			var thisel = jQuery(this);
			var thisindex = thisel.index();
			thisel.addClass("active").siblings("h3.active").removeClass("active");
			thisel.parent().siblings(".tab-d").children("div").eq(thisindex).addClass("active").siblings("div.active").removeClass("active");
			refreshSidebar();
		});

		jQuery(".w-photos .photo-images").each(function(){
			jQuery(this).children("a").eq(0).addClass("active");
		});

		jQuery(".gallery-link-left").click(function(){
			slideGalleryWidget(jQuery(this).siblings(".photo-images").children("a.active").prev());
			return false;
		});

		jQuery(".gallery-link-right").click(function(){
			slideGalleryWidget(jQuery(this).siblings(".photo-images").children("a.active").next());
			return false;
		});

		jQuery(".carousel-right").click(function(){
			var thisel = jQuery(this);
			var maxcount = Math.ceil((thisel.siblings(".inner-carousel").children(".item").size())/3);
			if(thisel.parent().attr("rel")){
				if(thisel.parent().attr("rel") < maxcount-1){
					var nuum = parseInt(thisel.parent().attr("rel"))+1;
				}else{
					var nuum = parseInt(thisel.parent().attr("rel"));
				}
			}else{
				if(maxcount-1 >= 1){
					var nuum = 1;
				}else{
					var nuum = 0;
				}
			}
			thisel.parent().attr("rel", nuum);
			thisel.siblings(".inner-carousel").animate({
				"left" : "-"+(nuum*103.5)+"%"
			}, 200);
			return false;
		});

		jQuery(".carousel-left").click(function(){
			var thisel = jQuery(this);
			if(thisel.parent().attr("rel")){
				if(thisel.parent().attr("rel") > 0){
					var nuum = parseInt(thisel.parent().attr("rel"))-1;
				}else{
					var nuum = parseInt(thisel.parent().attr("rel"));
				}
			}else{
				var nuum = 0;
			}
			thisel.parent().attr("rel", nuum);
			thisel.siblings(".inner-carousel").animate({
				"left" : "-"+(nuum*103.5)+"%"
			}, 200);
			return false;
		});

		jQuery(".slider .slider-navigation li > a").click(function() {
			var thisel = jQuery(this);
			var thisindex = thisel.parent().index();
			thisel.parent().addClass("active").siblings("li.active").removeClass("active");
			thisel.parent().parent().siblings(".slider-image").children("a").eq(thisindex).addClass("active").siblings("a.active").each(function() {
				var curel = jQuery(this);
				setTimeout(function () {
					curel.removeClass("active");
				}, 100);
			});
			return false;
		});


		// Alert box close
		jQuery('a[href="#close-alert"]').click(function() {
			jQuery(this).parent().animate({
				opacity: 0,
				padding: "0px 13px",
				margin: "0px",
				height: "0px"
			}, 300, function() {
				refreshSidebar();
			});
			return false;
		});

		// Accordion blocks
		jQuery(".accordion > div > a").click(function() {
			var thisel = jQuery(this).parent();
			if(thisel.hasClass("active")){
				thisel.removeClass("active").children("div").animate({
					"height": "toggle",
					"opacity": "toggle",
					"padding-top": "toggle"
				}, 300);
				return false;
			}
			// thisel.siblings("div").removeClass("active");
			thisel.siblings("div").each(function() {
				var tz = jQuery(this);
				if(tz.hasClass("active")){
					tz.removeClass("active").children("div").animate({
						"height": "toggle",
						"opacity": "toggle",
						"padding-top": "toggle"
					}, 300, function() {
						refreshSidebar();
					});
				}
			});
			// thisel.addClass("active");
			thisel.addClass("active").children("div").animate({
				"height": "toggle",
				"opacity": "toggle",
				"padding-top": "toggle"
			}, 300, function() {
				refreshSidebar();
			});
			return false;
		});
	  

		// Tabbed blocks
		jQuery(".short-tabs").each(function() {
			var thisel = jQuery(this);
			thisel.children("div").eq(0).addClass("active");
			thisel.children("ul").children("li").eq(0).addClass("active");
		});

		jQuery(".short-tabs > ul > li a").click(function() {
			var thisel = jQuery(this).parent();
			thisel.siblings(".active").removeClass("active");
			thisel.addClass("active");
			thisel.parent().siblings("div.active").removeClass("active");
			thisel.parent().siblings("div").eq(thisel.index()).addClass("active");
			refreshSidebar();
			return false;
		});

		jQuery(".lightbox").click(function () {
			jQuery(".lightbox").css('overflow', 'hidden');
			jQuery("body").css('overflow', 'auto');
			jQuery(".lightbox .lightcontent").fadeOut('fast');
			jQuery(".lightbox").fadeOut('slow');
		}).children().click(function(e) {
			return false;
		});


		// Responsive menu
		jQuery(".main-menu > div").append('<a href="#" class="toggle-menu"><i class="fa fa-ban"></i> Toggle Menu</a>');
		jQuery(".header-topmenu > div").append('<a href="#" class="toggle-menu"><i class="fa fa-ban"></i> Toggle Menu</a>');
		
		jQuery(".toggle-menu").click(function() {
			var thisel = jQuery(this).siblings("ul");
			thisel.fadeToggle();
			return false;
		});


		// Refresh sidebars look
		setTimeout(function () {
			refreshSidebar();
		}, 220);
		refreshSidebar();


        // Breaking News Scroller
        jQuery(".breaking-news .breaking-block").each(function () {
            var thisitem = jQuery(this);
        	thisitem.find("ul").html(thisitem.find("ul").html()+thisitem.find("ul").html());
            // thisitem.find("ul li").css("width", thisitem.width() + "px");
        });

        jQuery(".breaking-controls a").click(function () {
            var thisitem = jQuery(this), itemul = thisitem.parent().parent().find(".breaking-block ul"), items = itemul.find("li"), sega = (items.size() - 1) * (items.width() + parseInt(items.css("margin-right")));
            if (thisitem.hasClass("breaking-arrow-left")) {
                if (0 >= Math.abs(parseInt(itemul.css("margin-left")))) {
                    itemul.css("margin-left", (sega * (-1)) + "px");
                } else {
                    itemul.css("margin-left", (parseInt(itemul.css("margin-left")) + (items.width() + parseInt(items.css("margin-right")))) + "px");
                }
            } else {
                if (sega <= Math.abs(parseInt(itemul.css("margin-left")))) {
                    itemul.css("margin-left", "0px");
                } else {
                    itemul.css("margin-left", (parseInt(itemul.css("margin-left")) + (items.width() + parseInt(items.css("margin-right"))) * (-1)) + "px");
                }
            }
            return false;
        });

        jQuery(".breaking-news").mouseenter(function () {
            var thisindex = jQuery(this).attr("rel");
            clearTimeout(elementsActive[thisindex]);
        }).mouseleave(function () {
            var thisindex = jQuery(this).attr("rel");
            elementsActive[thisindex] = false;
        });

        start();

		if(_otSliderAuto){
			themesAutoLoad();
		}

		jQuery(".slider a.ot-slider-right").click(function() {
			var thenextpage = (jQuery(".slider > .slider-navigation > li.active").next().index() == "-1")?0:jQuery(".slider > .slider-navigation > li.active").next().index();
			themesLoadPage(thenextpage);
			themesCancelLoad();
			return false;
		});

		jQuery(".slider a.ot-slider-left").click(function() {
			var thenextpage = (jQuery(".slider > .slider-navigation > li.active").prev().index() == "-1")?jQuery(".slider > .slider-navigation > li").size()-1:jQuery(".slider > .slider-navigation > li.active").prev().index();
			themesLoadPage(thenextpage);
			themesCancelLoad();
			return false;
		});

	});

})(jQuery);

function start() {
    var z = 0;
    jQuery('.breaking-block ul').each(function () {
        var thisitem = jQuery(this), thisindex = z;

        z = z + 1;
        if (thisitem.find("li").size() > 0) {

            if (!breakingStart) { return false; }
            var theBreakingMargin = parseInt(thisitem.find("li").css("margin-right")), theBreakingWidth = parseInt(thisitem.parent().css("width"));
            theCount[thisindex] = (Math.ceil(thisitem.find("li").size() / 2) * (parseInt(thisitem.find("li").width()) + parseInt(thisitem.find("li").css("margin-right"))));

            if (elementsToClone[thisindex]) {
                jQuery(this).parent().parent().addClass("isscrolling");
                jQuery('.breaking-block').eq(thisindex).parent().attr("rel", thisindex);
                thisitem.find("li").clone().appendTo(this);

                elementsToClone[thisindex] = false;
            }
            var theNumber = theCount[thisindex] + breakingOffset[thisindex];
            if (Math.abs(theNumber) <= (Math.abs(breakingScroll[thisindex]))) {
                cloneBreakingLine(thisindex);
            }

            if (!elementsActive[thisindex]) {
                elementsActive[thisindex] = setInterval(function () {
                    beginScrolling(thisitem, thisindex);
                }, breakingSpeed);
            }
        }
    });

    setTimeout("start()", breakingSpeed);
}

function beginScrolling(thisitem, thisindex) {
    breakingScroll[thisindex] = breakingScroll[thisindex] - 1;
    thisitem.css("left", breakingScroll[thisindex] + 'px');
}

function cloneBreakingLine(thisindex) {
    breakingScroll[thisindex] = 0;
    jQuery('.breaking-block').eq(thisindex).find('ul').css("left", "0px");
}

function lightboxclose(){
	jQuery(".lightbox").css('overflow', 'hidden');
	jQuery(".lightbox .lightcontent").fadeOut('fast');
	jQuery(".lightbox").fadeOut('slow');
	jQuery("body").css('overflow', 'auto');
}


function refreshSidebar() {
	jQuery("#sidebar").each(function() {
		jQuery(this).css("height", "auto");
		var maxheight = jQuery(this).height();
		var secondheight = jQuery(".main-content").height();
		maxheight = (parseInt(secondheight) > parseInt(maxheight))?secondheight:maxheight;
		jQuery("#sidebar").css("min-height", maxheight);
	});
}

function slideGalleryWidget(theitem) {
	theitem.css("opacity", "0").css("display", "block").animate({
		"opacity" : "1"
	}, 200, function(){
		jQuery(this).addClass("active").siblings("a.active").removeClass("active").css("display", "none");
		refreshSidebar();
	});
}




