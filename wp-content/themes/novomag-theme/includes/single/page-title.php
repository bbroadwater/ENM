<?php 
	if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
	wp_reset_query();
	//single page titile
	$titleShow = get_post_meta ( OT_page_id(), "_".THEME_NAME."_title_show", true ); 
	if(is_category()) {
		//custom colors
		$catId = get_cat_id( single_cat_title("",false) );
		$titleColor = ot_title_color($catId, "category", false);
	} else {
		//custom colors
		$titleColor = ot_title_color(OT_page_id(),"page", false);
	}


?>					

<?php if($titleShow!="no") { ?> 
	<div class="p-title">
		<h2 style="background-color: <?php echo $titleColor;?>;"><?php echo ot_page_title(); ?></h2>
	</div>
	<a href="<?php echo home_url();?>" class="upper-title"><?php _e("Back to homepage", THEME_NAME);?><i class="fa fa-home"></i></a>
<?php } ?>

