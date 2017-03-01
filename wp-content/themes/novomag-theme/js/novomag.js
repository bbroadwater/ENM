"use strict";

// Tabbed panels
jQuery(".tabbed-panel").each(function() {
	var thisel = jQuery(this);
	thisel.children("div.tab-content").eq(0).addClass("active");
	thisel.children("div.tabs").children("a").eq(0).addClass("active");
});

jQuery(".tabbed-panel > div.tabs > a").click(function() {
	var thisel = jQuery(this);
	thisel.siblings(".active").removeClass("active");
	thisel.addClass("active");
	thisel.parent().siblings("div.active").removeClass("active");
	thisel.parent().siblings("div.tab-content").eq(thisel.index()).addClass("active");

	return false;
});

jQuery(".gallery-thumbnail-list").niceScroll();