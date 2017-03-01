<?php
global $orange_themes_managment;
$orangeThemes_slider_options= array(
 array(
	"type" => "navigation",
	"name" => __("Style Settings", THEME_NAME),
	"slug" => "custom-styling"
),

array(
	"type" => "tab",
	"slug"=>'custom-styling'
),

array(
	"type" => "sub_navigation",
	"subname"=>array(
		array("slug"=>"font_style", "name"=>__("Font Style", THEME_NAME)),
		array("slug"=>"page_colors", "name"=>__("Page Colors/Style", THEME_NAME)),
		array("slug"=>"page_layout", "name"=>__("Layout", THEME_NAME))
		)
),

/* ------------------------------------------------------------------------*
 * PAGE FONT SETTINGS
 * ------------------------------------------------------------------------*/

 array(
	"type" => "sub_tab",
	"slug"=> 'font_style'
),

array(
	"type" => "row"
),

array(
	"type" => "google_font_select",
	"title" => "Content & Mega menu text font family:",
	"id" => $orange_themes_managment->themeslug."_google_font_1",
	"sort" => "alpha",
	"info" => "Font previews You Can find here: <a href='http://www.google.com/webfonts' target='_blank'>Google Fonts</a>",
	"default_font" => array('font' => "Open Sans", 'txt' => "(default)")
),
array(
	"type" => "google_font_select",
	"title" => "Panel titles font family:",
	"id" => $orange_themes_managment->themeslug."_google_font_2",
	"sort" => "alpha",
	"info" => "Font previews You Can find here: <a href='http://www.google.com/webfonts' target='_blank'>Google Fonts</a>",
	"default_font" => array('font' => "PT Sans Narrow", 'txt' => "(default)")
),
array(
	"type" => "google_font_select",
	"title" => "Content titles font family:",
	"id" => $orange_themes_managment->themeslug."_google_font_3",
	"sort" => "alpha",
	"info" => "Font previews You Can find here: <a href='http://www.google.com/webfonts' target='_blank'>Google Fonts</a>",
	"default_font" => array('font' => "Roboto Slab", 'txt' => "(default)")
),

array(
	"type" => "close"

),

array(
	"type" => "save",
	"title" => "Save Changes"
),
   
array(
	"type" => "closesubtab"
),
/* ------------------------------------------------------------------------*
 * PAGE COLORS
 * ------------------------------------------------------------------------*/

 array(
	"type" => "sub_tab",
	"slug"=> 'page_colors'
),

array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => __("Default Category/News page Color", THEME_NAME)
),

array( 
	"type" => "color", 
	"id" => $orange_themes_managment->themeslug."_default_cat_color", 
	"title" => __("Color:", THEME_NAME),
	"std" => "c12026",
),

array(
	"type" => "close"
),

array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => __("Page Color Settings",THEME_NAME)
),

array( 
	"type" => "color", 
	"id" => $orange_themes_managment->themeslug."_color_1", 
	"title" => __("Main Color Scheme:",THEME_NAME),
	"std" => "292a32",
),

array( 
	"type" => "color", 
	"id" => $orange_themes_managment->themeslug."_color_2", 
	"title" => __("Panel & Widget Title Color:",THEME_NAME),
	"std" => "A3A3A6",
),

array(
	"type" => "close"
),


array(
	"type" => "row",

),
array(
	"type" => "title",
	"title" => __("Body Backgrounds (only boxed view)",THEME_NAME)
),

array(
	"type" => "radio",
	"id" => $orange_themes_managment->themeslug."_body_bg_type",
	"radio" => array(
		array("title" => __("Pattern:",THEME_NAME), "value" => "pattern"),
		array("title" => __("Custom Image:",THEME_NAME), "value" => "image"),
		array("title" => __("Color:",THEME_NAME), "value" => "color"),
	),
	"std" => "pattern"
),

array(
	"type" => "select",
	"title" => "Patterns ",
	"id" => $orange_themes_managment->themeslug."_body_pattern",
	"options"=>array(
		array("slug"=>"texture-1", "name"=>__("Texture 1",THEME_NAME)), 
		array("slug"=>"texture-2", "name"=>__("Texture 2",THEME_NAME)), 
		array("slug"=>"texture-3", "name"=>__("Texture 3",THEME_NAME)), 
		array("slug"=>"texture-4", "name"=>__("Texture 4",THEME_NAME)), 
		array("slug"=>"texture-5", "name"=>__("Texture 5",THEME_NAME)), 
	),
	"protected" => array(
		array("id" => $orange_themes_managment->themeslug."_body_bg_type", "value" => "pattern")
	)
),

array(
	"type" => "color",
	"title" => __("Body Background Color:",THEME_NAME),
	"id" => $orange_themes_managment->themeslug."_body_color",
	"std" => "f1f1f1",
	"protected" => array(
		array("id" => $orange_themes_managment->themeslug."_body_bg_type", "value" => "color")
	)
),

array(
	"type" => "upload",
	"title" => __("Body Background Image:",THEME_NAME),
	"id" => $orange_themes_managment->themeslug."_body_image",
	"protected" => array(
		array("id" => $orange_themes_managment->themeslug."_body_bg_type", "value" => "image")
	)
),

array(
	"type" => "close",

),

array(
	"type" => "save",
	"title" => __("Save Changes", THEME_NAME),
),
   
array(
	"type" => "closesubtab"
),
/* ------------------------------------------------------------------------*
 * PAGE LAYOUT
 * ------------------------------------------------------------------------*/

 array(
	"type" => "sub_tab",
	"slug"=> 'page_layout'
),

array(
	"type" => "row"
),
array(
	"type" => "title",
	"title" => __("Enable Responsive", THEME_NAME),
),

array(
	"type" => "checkbox",
	"title" => __("Enable", THEME_NAME),
	"id" => $orange_themes_managment->themeslug."_responsive"
),

array(
	"type" => "close"
),


array(
	"type" => "row"
),

array(
	"type" => "title",
	"title" => __("Page Layout", THEME_NAME),
),

array(
	"type" => "radio",
	"id" => $orange_themes_managment->themeslug."_page_layout",
	"radio" => array(
		array("title" => __("Boxed:", THEME_NAME), "value" => "boxed"),
		array("title" => __("Wide:", THEME_NAME), "value" => "wide"),
	),
),

array(
	"type" => "close"
),

array(
	"type" => "save",
	"title" => __("Save Changes", THEME_NAME)
),
   
array(
	"type" => "closesubtab"
),

array(
	"type" => "closetab"
)
 
);

$orange_themes_managment->add_options($orangeThemes_slider_options);
?>