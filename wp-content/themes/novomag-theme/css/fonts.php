<?php
	header("Content-type: text/css");
	require_once('../../../../wp-load.php');
	//fonts
	$google_font_1 = get_option(THEME_NAME."_google_font_1");
	$google_font_2 = get_option(THEME_NAME."_google_font_2");
	$google_font_3 = get_option(THEME_NAME."_google_font_3");



?>


/* Content & Mega menu text */
.mega-menu-full p,
.mega-menu-full > ul a,
.mega-menu-full,
body {
	font-family: '<?php echo $google_font_1;?>', sans-serif;
}

/* Panel titles */
body .toggle-menu,
.footer .footer-widgets > .widget > h3,
.footer .footer-widgets > .widget > .w-title h3,
.rating-total .master-rate,
.content .panel > .p-title h2,
#sidebar .widget > .w-title h3,
.panel-title,
.breaking-news h3,
.breaking-news .breaking-block h4
.main-menu ul.menu > li ul.sub-menu > li > a,
.main-menu ul.menu > li > a,
.header-topmenu {
	font-family: '<?php echo $google_font_2;?>', sans-serif;
}

/* Content titles */
h1, h2, h3, h4, h5, h6,
.slider .slider-image a .slider-overlay strong,
.menu-content.featured-post .article-icons,
.menu-block .featured-post .article-icons,
.comments-list .item .item-content span,
.article-list .item .item-content span {
	font-family: '<?php echo $google_font_3;?>', serif;
}

