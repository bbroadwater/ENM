<?php
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

	//get blog style
	$blogStyle = get_post_meta( OT_page_id(), "_".THEME_NAME."_blog_style", true ); 

	if(is_category()) {
		$catId = get_cat_id( single_cat_title("",false) );
		$blogStyle = ot_get_option ( $catId, "blog_style"); 
	}
	if(!$blogStyle) $blogStyle=1;//if the blog style isn't set, set it to 1
?>
	<!-- START .blog-lis-->
	<div class="blog-list style-<?php echo $blogStyle;?>">