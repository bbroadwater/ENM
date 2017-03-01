<?php
	wp_reset_query();

	$sidebar = get_post_meta( OT_page_ID(), "_".THEME_NAME.'_sidebar_select', true );


	if(is_category()) {
		$sidebar = ot_get_option( get_cat_id( single_cat_title("",false) ), 'sidebar_select', false );
	} elseif(is_tax()){
		$sidebar = ot_get_option( get_queried_object()->term_id, 'sidebar_select', false );
	}
	/*
	if($sidebar=='' && function_exists('is_woocommerce') && is_woocommerce()) {
		$sidebar = 'ot_woocommerce';
	}
	if($sidebar=='' && function_exists("is_bbpress") && is_bbpress()) {
		$sidebar = 'ot_bbpress';
	}

	if($sidebar=='' && function_exists("is_buddypress") && is_buddypress()) {
		$sidebar = 'ot_buddypress';
	}
	*/

	if ( $sidebar=='' || is_search()) {
		$sidebar='default';
	}	
	
	if($sidebar!="off") {
?>
	
	<!-- BEGIN #sidebar -->
	<aside id="sidebar" class="<?php OT_sidebarClass(OT_page_ID());?>">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($sidebar) ) : ?>
		<?php endif; ?>
	<!-- END #sidebar -->
	</aside>
<?php }  ?>
<?php wp_reset_query();  ?>