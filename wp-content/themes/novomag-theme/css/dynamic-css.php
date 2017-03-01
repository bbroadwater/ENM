<?php
	header("Content-type: text/css");
	require_once('../../../../wp-load.php');

	//banner settings
	$banner_type = get_option ( THEME_NAME."_banner_type" );

	//bg type
	$bg_type = get_option ( THEME_NAME."_body_bg_type" );
	$bg_color = get_option ( THEME_NAME."_body_color" );
	$bg_image = get_option ( THEME_NAME."_body_image" );
	$bg_texture = get_option ( THEME_NAME."_body_pattern" );
	if(!$bg_texture) $bg_texture = "texture-1";

	//colors
	$color_1 = get_option(THEME_NAME."_color_1");
	$color_2 = get_option(THEME_NAME."_color_2");




?>


/* Main Color Scheme */
.header-topmenu li,
.slider-navigation li.active a,
.main-menu,
.header-topmenu {
	background-color: #<?php echo $color_1;?>;
}
.main-menu {
	color: #<?php echo $color_1;?>;
}


/* Panel & Widget Title Color */
#sidebar .widget > .w-title h3,
.content .panel > .p-title h2 {
	background-color: #<?php echo $color_2;?>;
}
.tab-a {
	box-shadow: inset 0 -3px 0 #<?php echo $color_2;?>;
}

/* Background Color/Texture/Image */
body {
	<?php if($bg_type == "color") { ?>
		background: #<?php echo $bg_color;?>;
	<?php } else if ($bg_type == "pattern") { ?> 
		background: url(<?php echo THEME_IMAGE_URL."background-".$bg_texture;?>.jpg);
	<?php } else if ($bg_type == "image") { ?>
		background-image: url(<?php echo $bg_image;?>);background-size: 100%; background-attachment: fixed;
	<?php } else { ?>
		background: #<?php echo $bg_color;?>;
	<?php } ?>

}

<?php
	if ( $banner_type == "image" ) {
	//Image Banner
?>
		#overlay { width:100%; height:100%; position:fixed;  _position:absolute; top:0; left:0; z-index:1001; background-color:#000000; overflow: hidden;  }
		#popup { display: none; position:absolute; width:auto; height:auto; z-index:1002; color: #000; font-family: Tahoma,sans-serif;font-size: 14px; }
		#baner_close { width: 22px; height: 25px; background: url(<?php echo get_template_directory_uri(); ?>/images/close.png) 0 0 repeat; text-indent: -5000px; position: absolute; right: -10px; top: -10px; }
<?php
	} else if ( $banner_type == "text" ) {
	//Text Banner
?>
		#overlay { width:100%; height:100%; position:fixed;  _position:absolute; top:0; left:0; z-index:1001; background-color:#000000; overflow: hidden;  }
		#popup { display: none; position:absolute; width:auto; height:auto; max-width:700px; z-index:1002; border: 1px solid #000; background: #e5e5e5 url(<?php echo get_template_directory_uri(); ?>/images/dotted-bg-6.png) 0 0 repeat; color: #000; font-family: Tahoma,sans-serif;font-size: 14px; line-height: 24px; border: 1px solid #cccccc; -moz-border-radius: 4px; -webkit-border-radius: 4px; border-radius: 4px; text-shadow: #fff 0 1px 0; }
		#popup center { display: block; padding: 20px 20px 20px 20px; }
		#baner_close { width: 22px; height: 25px; background: url(<?php echo get_template_directory_uri(); ?>/images/close.png) 0 0 repeat; text-indent: -5000px; position: absolute; right: -12px; top: -12px; }
<?php 
	} else if ( $banner_type == "text_image" ) {
	//Image And Text Banner
?>
		#overlay { width:100%; height:100%; position:fixed;  _position:absolute; top:0; left:0; z-index:1001; background-color:#000000; overflow: hidden;  }
		#popup { display: none; position:absolute; width:auto; z-index:1002; color: #000; font-size: 11px; font-weight: bold; }
		#popup center { padding: 15px 0 0 0; }
		#baner_close { width: 22px; height: 25px; background: url(<?php echo get_template_directory_uri(); ?>/images/close.png) 0 0 repeat; text-indent: -5000px; position: absolute; right: -10px; top: -10px; }
<?php } ?>
