<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	wp_reset_query();

	// style
	$blogStyle = get_post_meta( OT_page_id(), "_".THEME_NAME."_blog_style", true ); 
	if(is_category()) {
		$catId = get_cat_id( single_cat_title("",false) );
		$blogStyle = ot_get_option ( $catId, "blog_style"); 
	}

	if(!$blogStyle) $blogStyle=1;//if the blog style isn't set, set it to 1

	$width = 677;
	$height = 316;






	$image = get_post_thumb($post->ID,$width,$height); 
	if(get_option(THEME_NAME."_show_first_thumb") == "on" && $image['show']==true) {
?>
	<a href="<?php the_permalink();?>" class="item-photo">
		<?php echo ot_image_html($post->ID,$width,$height); ?>
	</a>
<?php } ?>