<?php
global $orangeThemes_fields;
$orangeThemes_general_options= array(



/* ------------------------------------------------------------------------*
 * HOME SETTINGS
 * ------------------------------------------------------------------------*/   

array(
	"type" => "homepage_blocks",
	"title" => __("Homepage Blocks:", THEME_NAME),
	"id" => $orangeThemes_fields->themeslug."_homepage_blocks",
	"blocks" => array(
		array(
			"title" => __("Latest News Blocks", THEME_NAME),
			"type" => "homepage_news_block",
			"image" => "icon-article.png",
			"description" => __("Two news blocks.",THEME_NAME),
			"options" => array(
				array( "type" => "title", "title" => __("Block 1", THEME_NAME), "home" => "yes","id" => $orangeThemes_fields->themeslug."_homepage_news_block_t", ),

				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_title_0", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_count_0", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_cat_0",
					"taxonomy" => "category",
					"title" => "Set Category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_offset_0", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),
			
				array( "type" => "title", "title" => __("Block 2", THEME_NAME), "home" => "yes","id" => $orangeThemes_fields->themeslug."_homepage_news_block_t2" ),

				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_title_1", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_count_1", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_cat_1",
					"taxonomy" => "category",
					"title" => "Set Category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_offset_1", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),

			),
		),
		array(
			"title" => __("Latest News Style 2", THEME_NAME),
			"type" => "homepage_news_block_1",
			"image" => "icon-article.png",
			"description" => __("One news block.",THEME_NAME),
			"options" => array(
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_1_title", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_1_count", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_1_cat",
					"taxonomy" => "category",
					"title" => "Set Category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_1_offset", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),			

			),

		),
		array(
			"title" => __("Latest News Style 3", THEME_NAME),
			"type" => "homepage_news_block_3",
			"image" => "icon-article.png",
			"description" => __("Post carousel.",THEME_NAME),
			"options" => array(
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_3_title", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_3_count", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_3_cat",
					"taxonomy" => "category",
					"title" => __("Set Category", THEME_NAME),
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_3_offset", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),			

			),

		),

		array(
			"title" => __("Latest News Style 4", THEME_NAME),
			"type" => "homepage_news_block_8",
			"image" => "icon-article.png",
			"description" => __("Grid Views",THEME_NAME),
			"options" => array(
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_8_title", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_8_count", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_8_cat",
					"taxonomy" => "category",
					"title" => "Set Category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_8_offset", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),			

			),

		),
		array(
			"title" => __("Latest News Style 5", THEME_NAME),
			"type" => "homepage_news_block_10",
			"image" => "icon-article.png",
			"description" => __("Blog Style",THEME_NAME),
			"options" => array(
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_10_title", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_10_count", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "select",
					"title" => __("Style:", THEME_NAME),
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_10_style",
					"options"=>array(
						array("slug"=>"1", "name"=>__("Style 1 (default)", THEME_NAME)), 
						array("slug"=>"2", "name"=>__("Style 2 (grid view)", THEME_NAME)), 
					),
					"home" => "yes"
				),	
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_10_cat",
					"taxonomy" => "category",
					"title" => "Set Category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_10_offset", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),			

			),

		),
		array(
			"title" => __("Category News", THEME_NAME),
			"type" => "homepage_news_block_9",
			"image" => "icon-article.png",
			"description" => __("3 Column View",THEME_NAME),
			"options" => array(
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_9_count", "title" => __("Post Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "multiple_select",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_9_cat",
					"taxonomy" => "category",
					"title" => "Categories",
					"home" => "yes"
				),
			),

		),
		array(
			"title" => __("Reviews", THEME_NAME),
			"type" => "homepage_news_block_4",
			"image" => "icon-review.png",
			"description" => __("Latest/Top reviews.",THEME_NAME),
			"options" => array(
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_4_title", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array(
					"type" => "categories",
					"title" => __("Set Category", THEME_NAME),
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_4_cat",
					"taxonomy" => "category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_4_offset", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),
				array(
					"type" => "select",
					"title" => __("Type:", THEME_NAME),
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_4_type",
					"options"=>array(
						array("slug"=>"latest", "name"=>__("Latest Reviews", THEME_NAME)), 
						array("slug"=>"top", "name"=>__("Top Reviews", THEME_NAME)), 
					),
					"home" => "yes"
				),				
				array( 
					"type" => "color", 
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_4_color", 
					"title" => __("Color:", THEME_NAME),
					"std" => get_option(THEME_NAME."_default_cat_color"),
					"home" => "yes"
				),
			),
		),
		array(
			"title" => __("Popular News", THEME_NAME),
			"type" => "homepage_news_block_5",
			"image" => "icon-article-popular.png",
			"description" => __("Two popular news blocks.",THEME_NAME),
			"options" => array(
				array( "type" => "title", "title" => __("Block 1", THEME_NAME), "home" => "yes","id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_t", ),

				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_title_0", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_count_0", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_cat_0",
					"taxonomy" => "category",
					"title" => "Set Category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_offset_0", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),
				array( 
					"type" => "color", 
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_color_0", 
					"title" => __("Color:", THEME_NAME),
					"std" => get_option(THEME_NAME."_default_cat_color"),
					"home" => "yes"
				),
				array( "type" => "title", "title" => __("Block 2", THEME_NAME), "home" => "yes","id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_t2" ),

				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_title_1", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_count_1", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_cat_1",
					"taxonomy" => "category",
					"title" => "Set Category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_offset_1", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),
				array( 
					"type" => "color", 
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_5_color_1", 
					"title" => __("Color:", THEME_NAME),
					"std" => get_option(THEME_NAME."_default_cat_color"),
					"home" => "yes"
				),
			),
		),
		array(
			"title" => __("Popular News Style 2", THEME_NAME),
			"type" => "homepage_news_block_6",
			"image" => "icon-article-popular.png",
			"description" => __("One popular news block.",THEME_NAME),
			"options" => array(
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_6_title", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_6_count", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_6_cat",
					"taxonomy" => "category",
					"title" => "Set Category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_6_offset", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),				
				array( 
					"type" => "color", 
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_6_color", 
					"title" => __("Color:", THEME_NAME),
					"std" => get_option(THEME_NAME."_default_cat_color"),
					"home" => "yes"
				),
			),

		),

		array(
			"title" => __("Popular News Style 3", THEME_NAME),
			"type" => "homepage_news_block_7",
			"image" => "icon-article-popular.png",
			"description" => __("Popular post carousel.",THEME_NAME),
			"options" => array(
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_7_title", "title" => __("Title:", THEME_NAME), "home" => "yes" ),
				array( "type" => "scroller", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_7_count", "title" => __("Count:", THEME_NAME), "max" => 30, "home" => "yes" ),
				array(
					"type" => "categories",
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_7_cat",
					"taxonomy" => "category",
					"title" => "Set Category",
					"home" => "yes"
				),
				array( "type" => "input", "id" => $orangeThemes_fields->themeslug."_homepage_news_block_7_offset", "title" => __("From which post should start the loop (for example 4 ), for default leave it empty, or add 0. (Offset):", THEME_NAME), "home" => "yes" ),			

				array( 
					"type" => "color", 
					"id" => $orangeThemes_fields->themeslug."_homepage_news_block_7_color", 
					"title" => __("Color:", THEME_NAME),
					"std" => get_option(THEME_NAME."_default_cat_color"),
					"home" => "yes"
				),
			),

		),
		array(
			"title" => "HTML Code",
			"type" => "homepage_html",
			"image" => "icon-html.png",
			"description" => __("Custom HTML/Shortcodes Block",THEME_NAME),
			"options" => array(
				array( "type" => "textarea", "id" => $orangeThemes_fields->themeslug."_homepage_html", "title" => __("HTML Code:",THEME_NAME), "home" => "yes" ),
			),
		),
		array(
			"title" => "Banner Block",
			"type" => "homepage_banner",
			"image" => "icon-banner.png",
			"description" => __("Supports HTML,CSS and Javascript.",THEME_NAME),
			"options" => array(
				array( "type" => "textarea", "id" => $orangeThemes_fields->themeslug."_homepage_banner", "title" => __("HTML Code:",THEME_NAME), "home" => "yes","sample" => '<a href="http://www.orange-themes.com" target="_blank"><img src="'.THEME_IMAGE_URL.'no-banner-300x250.jpg" alt="" title="" /></a><a href="http://www.orange-themes.com" target="_blank"><img src="'.THEME_IMAGE_URL.'no-banner-300x250.jpg" alt="" title="" /></a>', ),
			),
		),

	)
),


 
 );


$orangeThemes_fields->add_options($orangeThemes_general_options);
?>