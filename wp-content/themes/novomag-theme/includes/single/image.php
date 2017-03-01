<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_query();
	
	$width = 800;
	$height = 500;
	$image = get_post_thumb($post->ID,$width,$height); 

	//post details
	$singleImage = get_option(THEME_NAME."_show_single_thumb");
	$singleImageSingle = get_post_meta( $post->ID, "_".THEME_NAME."_show_single_thumb", true );

?>

<?php if((ot_option_compare($singleImage,$singleImageSingle)==true && $image['show']==true) || (!$singleImage && $image['show']==true)) { ?>

	<span class="hover-effect">
		<?php echo ot_image_html($post->ID,$width,$height,"article-photo"); ?>
	</span>

<?php } ?>